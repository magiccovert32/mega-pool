$(document).ready(function(){
    $('#forgot-pass-frm')[0].reset();
});

$('#forgot-pass-btn').on('click', function(){
    $('#forgot-pass-btn').attr('disabled','disabled');

    $('.alert').hide();

    let email       = $.trim($('#email').val());
    let error       = 0;
    let error_msg   = [];
    let email_ptr   = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if(email !== ''){
        if(!email_ptr.test(email)){
            error = 1;
            error_msg.push('Enter valid email address.');
        }
    }else{
        error = 1;
        error_msg.push('Enter valid email address.');
    }

    if(error == 0){
        $.ajax({
            url: base_path+"send-reset-link",
            type: "POST",
            data: $('#forgot-pass-frm').serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.status == 1){
                    $('#forgot-pass-frm')[0].reset();
                    $('#success-msg').find('.alert_message').html(response.message);
                    $('#success-msg').show();

                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                }else{
                    $('#forgot-pass-btn').removeAttr('disabled');
                    $('#error-msg').find('.alert_message').html(response.message);
                    $('#error-msg').show();
                }
            }
        });
    }else{
        $('#forgot-pass-btn').removeAttr('disabled');
        
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
        $("#forgot-pass-btn").click();
    }
});