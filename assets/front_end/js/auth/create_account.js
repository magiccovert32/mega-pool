$(document).ready(function(){
    $('#signup-frm')[0].reset();
});

$('#signup-btn').on('click', function(){
    $('#signup-btn').attr('disabled','disabled');

    $('.alert').hide();

    let full_name   = $.trim($('#full_name').val());
    let email       = $.trim($('#email').val());
    let password    = $.trim($('#password').val());
    let cpassword   = $.trim($('#confirm-password').val());
    let error       = 0;
    let error_msg   = [];
    let email_ptr   = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    // check login fields
    if(full_name == ''){
        error = 1;
        error_msg.push('Enter your full name.');
    }

    if(email !== ''){
        if(!email_ptr.test(email)){
            error = 1;
            error_msg.push('Enter valid email address.');
        }
    }else{
        error = 1;
        error_msg.push('Enter valid email address.');
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
        error_msg.push('Enter account password.');
    }

    if(error == 0){
        $.ajax({
            url: "save-account",
            type: "POST",
            data: $('#signup-frm').serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.status == 1){
                    $('#signup-frm')[0].reset();
                    $('#success-msg').find('.alert_message').html(response.message);
                    $('#success-msg').show();

                    setTimeout(() => {
                        location.reload();
                    }, 3000)
                }else{
                    $('#signup-btn').removeAttr('disabled');
                    $('#error-msg').find('.alert_message').html(response.message);
                    $('#error-msg').show();
                }
            }
        });
    }else{
        $('#signup-btn').removeAttr('disabled');
        
        let error_str = '';

        error_msg.forEach(function(item) {
            error_str += "<div><span>"+item+"</span></div>";
        });

        $('#error-msg').find('.alert_message').html(error_str);
        $('#error-msg').show();
    }
})