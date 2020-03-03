
$('#update-profile-btn').on('click', function(){
    $('#update-profile-btn').attr('disabled','disabled');

    $('.alert').hide();

    let full_name   = $.trim($('#full_name').val());
    let error       = 0;
    let error_msg   = [];

    // check login fields
    if(full_name == ''){
        error = 1;
        error_msg.push('Enter your full name.');
    }

    if(error == 0){
        $.ajax({
            url: "update-profile",
            type: "POST",
            data: $('#my-profile-frm').serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.status == 1){
                    $('#success-msg').find('.alert_message').html(response.message);
                    $('#success-msg').show();
                }else{
                    $('#error-msg').find('.alert_message').html(response.message);
                    $('#error-msg').show();
                }

                $('#update-profile-btn').removeAttr('disabled');
            }
        });
    }else{
        $('#update-profile-btn').removeAttr('disabled');
        
        let error_str = '';

        error_msg.forEach(function(item) {
            error_str += "<div><span>"+item+"</span></div>";
        });

        $('#error-msg').find('.alert_message').html(error_str);
        $('#error-msg').show();
    }
});


// change password
$('#chamge-password-btn').on('click', function(){
    $('#chamge-password-btn').attr('disabled','disabled');

    $('.alert').hide();

    let o_password  = $.trim($('#old_password').val());
    let password    = $.trim($('#new_password').val());
    let cpassword   = $.trim($('#c_password').val());
    let error       = 0;
    let error_msg   = [];

    // check login fields
    if(o_password == ''){
        error = 1;
        error_msg.push('Enter your old password.');
    }

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
            url: "update-password",
            type: "POST",
            data: $('#change-password-frm').serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.status == 1){
                    $('#change-password-frm')[0].reset();
                    $('#success-msg-p').find('.alert_message').html(response.message);
                    $('#success-msg-p').show();
                }else{
                    $('#error-msg-p').find('.alert_message').html(response.message);
                    $('#error-msg-p').show();
                }

                $('#chamge-password-btn').removeAttr('disabled');
            }
        });
    }else{
        $('#chamge-password-btn').removeAttr('disabled');
        
        let error_str = '';

        error_msg.forEach(function(item) {
            error_str += "<div><span>"+item+"</span></div>";
        });

        $('#error-msg-p').find('.alert_message').html(error_str);
        $('#error-msg-p').show();
    }
})