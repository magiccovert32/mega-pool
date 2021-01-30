$('#login-btn').on('click', function(){
    $('.alert').hide();

    let email       = $.trim($('#email').val());
    let password    = $.trim($('#password').val());
    let error       = 0;
    let error_msg   = [];
    let email_ptr   = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    // check login fields
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
        }
    }else{
        error = 1;
        error_msg.push('Enter account password.');
    }

    if(error == 0){
        $.ajax({
            url: "verify-login",
            type: "POST",
            data: $('#login-frm').serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.status == 1){
                    $('#success-msg').find('.alert_message').html(response.message);
                    $('#success-msg').show();

                    setTimeout(function(){
                        window.location.href = "home";
                    },500);
                }else{
                    $('#error-msg').find('.alert_message').html(response.message);
                    $('#error-msg').show();
                }
            }
        });
    }else{
        let error_str = '';

        error_msg.forEach(function(item) {
            error_str += "<div><span>"+item+"</span></div>";
        });

        $('#error-msg').find('.alert_message').html(error_str);
        $('#error-msg').show();
    }
});

$("input").keypress(function(event) {
    if (event.which == 13) {
        event.preventDefault();
        $("#login-btn").click();
    }
});