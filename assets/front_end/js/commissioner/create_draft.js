
$('#create-draft').on('click', function(){
    $('#create-draft').attr('disabled','disabled');

    $('.alert').hide();
	
    let draft_title     		= $.trim($('#draft_title').val());
    let league_id     			= $.trim($('#league_id').val());
    let team_selection_ends_on  = $.trim($('#team_selection_ends_on').val());

    let error                   = 0;
    let error_msg               = [];
	
	if(draft_title == ''){
        error = 1;
        error_msg.push('Enter Title');
    }

    if(league_id == ''){
        error = 1;
        error_msg.push('Select league.');
    }

    if(team_selection_ends_on == ''){
        error = 1;
        error_msg.push('Enter timing.');
    }

    if(error == 0){
        var formData = new FormData($('#draft-create-frm')[0]);

        $.ajax({
            url: base_path+"save-draft",
            type: "POST",
            data: formData,
            dataType: 'json',
            success: function (response) {
                if(response.status == 1){
                    $('#success-msg').find('.alert_message').html(response.message);
                    $('#success-msg').show();

                    setTimeout(function(){
                        window.location.href = base_path+"my-draft";
                    },500);
                }else{
                    $('#create-draft').removeAttr('disabled');
                    $('#error-msg').find('.alert_message').html(response.message);
                    $('#error-msg').show();
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }else{
        $('#create-draft').removeAttr('disabled');
        
        let error_str = '';

        error_msg.forEach(function(item,key) {
            var sl = key+1;
            error_str += "<div>"+sl+". <span>"+item+"</span></div>";
        });

        $('#error-msg').find('.alert_message').html(error_str);
        $('#error-msg').show();
    }
});