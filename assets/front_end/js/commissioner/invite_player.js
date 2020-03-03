var emails = [];

$('#add-email').on('click', function(){
    $('#add-email').attr('disabled','disabled');
	$('.n_alert').hide();

    let email       = $.trim($('#email').val());
    let error       = 0;
    let error_msg   = '';
    let email_ptr   = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if(email !== ''){
        if(!email_ptr.test(email)){
            error = 1;
            error_msg= 'Enter valid email address.';
        }else{
			if(emails.length !== 0){
				$.each(emails, function(key,value) {
					if(value == email){
						error = 1;
						error_msg= 'You have already selected this email address.';
					}
				});
			}
		}
    }else{
        error = 1;
        error_msg= 'Enter valid email address.';
    }
	

    if(error == 0){
        emails.push(email);
		$('#email').val('');
		$('#add-email').removeAttr('disabled');
		
		var html = '';
		
		$.each(emails, function(key,value) {
			html += `<div class="mb-2 mr-2 btn btn-warning">`+value+`<span class="badge bg-light" onclick="removeEmail('`+value+`');"><i class="fa fa-trash"></i></span></div>`;
		});

		$('#email-list').html(html);
    }else{
        swal({
			title: "Error!",
			text: error_msg,
			icon: "error",
			button: "Close",
		});
		
		$('#add-email').removeAttr('disabled');
    }
});


function removeEmail(val){
	emails.pop(val);
	
	var html = '';
	
	if(emails.length === 0){
		html = 'List is empty!';
	}else{
		$.each(emails, function(key,value) {
			html += `<div class="mb-2 mr-2 btn btn-warning">`+value+`<span class="badge bg-light" onclick="removeEmail('`+value+`');"><i class="fa fa-trash"></i></span></div>`;
		});
	}
	

	$('#email-list').html(html);
}


$('#send-invitation').on('click', function(){
    $('#send-invitation').attr('disabled','disabled');

    $('.n_alert').hide();
	
	let error       = 0;
    let error_msg   = [];
	let url			= $('#url').val();

    if(emails.length === 0){
        error = 1;
        error_msg.push('No email entered');
    }

    if(error == 0){
        $.ajax({
            url: base_path+"send-invitation",
            type: "POST",
            data: {emails: emails,url: url},
            dataType: 'json',
            success: function (response) {
                if(response.status == 1){
                    $('#success-msg').find('.alert_message').html(response.message);
                    $('#success-msg').show();

                    setTimeout(function(){
                        window.location.href = base_path+"my-megapool";
                    },500);
                }else{
                    $('#send-invitation').removeAttr('disabled');
                    $('#error-msg').find('.alert_message').html(response.message);
                    $('#error-msg').show();
                }
            }
        });
    }else{
        $('#send-invitation').removeAttr('disabled');
        
        let error_str = '';

        error_msg.forEach(function(item,key) {
            var sl = key+1;
            error_str += "<div>"+sl+". <span>"+item+"</span></div>";
        });

        $('#error-msg').find('.alert_message').html(error_str);
        $('#error-msg').show();
    }
});
