$('#reset-pass-btn').on('click', function(){
    $('#reset-pass-btn').attr('disabled','disabled');

    $('.alert').hide();

    let password    = $.trim($('#new_password').val());
    let cpassword   = $.trim($('#c_password').val());
    let error       = 0;
    let error_msg   = [];

    if(password !== ''){
        if(password.length < 6){
            error = 1;
            error_msg.push('Password should be at lease 6 characters.');
        }else{
            if(password !== cpassword){
                error = 1;
                error_msg.push("Password and confirm password doesn't match.");
            }
        }
    }else{
        error = 1;
        error_msg.push('Enter account new password.');
    }

    if(error == 0){
        $.ajax({
            url: base_path+"update-reset-password",
            type: "POST",
            data: $('#reset-pass-frm').serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.status == 1){
                    $('#reset-pass-frm')[0].reset();
                    $('#success-msg').find('.alert_message').html(response.message);
                    $('#success-msg').show();
					
					setTimeout(() => {
						window.location.replace(base_path+"account-login");
					},2000);
                }else{
                    $('#error-msg').find('.alert_message').html(response.message);
                    $('#error-msg').show();
                }

                $('#reset-pass-btn').removeAttr('disabled');
            }
        });
    }else{
        $('#reset-pass-btn').removeAttr('disabled');
        
        let error_str = '';

        error_msg.forEach(function(item) {
            error_str += "<div><span>"+item+"</span></div>";
        });

        $('#error-msg').find('.alert_message').html(error_str);
        $('#error-msg').show();
    }
});