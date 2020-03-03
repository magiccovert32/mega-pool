
$('#entry_fee').keydown(function(e)
{
    var key = e.charCode || e.keyCode || 0;
    // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
    // home, end, period, and numpad decimal
    return (
        key == 8 || 
        key == 9 ||
        key == 13 ||
        key == 46 ||
        key == 110 ||
        key == 190 ||
        (key >= 35 && key <= 40) ||
        (key >= 48 && key <= 57) ||
        (key >= 96 && key <= 105));
});

$('#create-mega-pool').on('click', function(){
    $('#create-mega-pool').attr('disabled','disabled');

    $('.alert').hide();

    let mega_pool_title     = $.trim($('#mega_pool_title').val());
    let sport_id            = $.trim($('#sport_id').val());
    let entry_fee           = $.trim($('#entry_fee').val());
    let league_logo         = $("#league_logo")[0].files.length;

    let error                   = 0;
    let error_msg               = [];
    let selected_league_count   = 0;

    $("input[name='selected_league[]']").each(function (index, obj) {
        if ($(this).prop('checked')==true){ 
            selected_league_count++;
        }
    });

    // check form fields
    if(mega_pool_title == ''){
        error = 1;
        error_msg.push('Enter your league name.');
    }

    if(sport_id == ''){
        error = 1;
        error_msg.push('select your sport.');
    }

    if(selected_league_count < 1){
        error = 1;
        error_msg.push('Select at least 1 league.');
    }

    if(entry_fee == ''){
        error = 1;
        error_msg.push('Enter entry fee.');
    }else{
        var regex = /^(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/;
        if(!regex.test(entry_fee)){
            error = 1;
            error_msg.push('Enter valid entry fee.');
        }
    }

    if(league_logo == 0){
        error = 1;
        error_msg.push('Upload league logo.');
    }
    

    if(error == 0){
        var formData = new FormData($('#mega-pool-create-frm')[0]);

        $.ajax({
            url: base_path+"save-megapool",
            type: "POST",
            data: formData,
            dataType: 'json',
            success: function (response) {
                if(response.status == 1){
                    $('#success-msg').find('.alert_message').html(response.message);
                    $('#success-msg').show();

                    setTimeout(function(){
                        window.location.href = "my-megapool";
                    },500)
                }else{
                    $('#create-mega-pool').removeAttr('disabled');
                    $('#error-msg').find('.alert_message').html(response.message);
                    $('#error-msg').show();
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }else{
        $('#create-mega-pool').removeAttr('disabled');
        
        let error_str = '';

        error_msg.forEach(function(item,key) {
            var sl = key+1;
            error_str += "<div>"+sl+". <span>"+item+"</span></div>";
        });

        $('#error-msg').find('.alert_message').html(error_str);
        $('#error-msg').show();
    }
});


$('#sport_id').on('change', function(){
    var sport_id = $('#sport_id').val();

    if(sport_id !== ''){
        $.ajax({
            url: base_path+"get-related-league-by-sport-id",
            type: "POST",
            data: {sport_id:sport_id},
            dataType: 'json',
            success: function(response) {
                if(response.status == 1){
                    $('#league-list').html('');

                    var list = response.league_list;
                    
                    $.each(list, function(key,value) {
                        var html = `<li class="list-group-item">
										<div class="todo-indicator bg-warning"></div>
										<div class="widget-content p-0">
											<div class="widget-content-wrapper">
												<div class="widget-content-left mr-2">
													<div class="custom-checkbox custom-control">
														<input type="checkbox" id="exampleCustomCheckbox`+value.league_id+`" value="`+value.league_id+`" name="selected_league[]" class="custom-control-input"><label class="custom-control-label" for="exampleCustomCheckbox`+value.league_id+`">&nbsp;</label>
													</div>
												</div>
												<div class="widget-content-left mr-3">
													<div class="widget-content-left">
														<img width="42" class="rounded" src="`+base_path+`assets/uploads/league_logo/`+value.league_logo+`" alt="">
													</div>
												</div>
												<div class="widget-content-left">
													<div class="text-dark">`+value.league_title+`</div>
												</div>
											</div>
										</div>
									</li>`;
									
                        $('#league-list').append(html);
                    }); 
                }else{
                    var html = `<li class="list-group-item" style="padding: 0;">
									<div class="alert alert-info fade show mt-10" role="alert">
										<div>
											<div class="page-title-subheading">No league to display! Select any sport to check available leagues.</div>
										</div>
									</div>
								</li>`;
								
					$('#league-list').html(html);
                }                
            }
        });
    }
})