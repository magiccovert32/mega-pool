
$('#add-player').on('click', function(){
    $('#add-player').attr('disabled','disabled');

    $('.alert').hide();

    let player_id   = $.trim($('#player_id').val());
    let team_id     = $.trim($('#team_id').val());

    let error                   = 0;
    let error_msg               = [];

    if(player_id == ''){
        error = 1;
        error_msg.push('select player.');
    }

    if(team_id == ''){
        error = 1;
        error_msg.push('Select team.');
    }

    if(error == 0){
        var formData = new FormData($('#add-player-frm')[0]);

        $.ajax({
            url: base_path+"attatch-player-to-draft",
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
                    $('#add-player').removeAttr('disabled');
                    $('#error-msg').find('.alert_message').html(response.message);
                    $('#error-msg').show();
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }else{
        $('#add-player').removeAttr('disabled');
        
        let error_str = '';

        error_msg.forEach(function(item,key) {
            var sl = key+1;
            error_str += "<div>"+sl+". <span>"+item+"</span></div>";
        });

        $('#error-msg').find('.alert_message').html(error_str);
        $('#error-msg').show();
    }
});