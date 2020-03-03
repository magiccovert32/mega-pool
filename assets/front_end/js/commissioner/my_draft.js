function publish(url){
    swal({
        title: "Are you sure?",
        text: "You want to publish this draft. Once published , you will not be able to edit or remove this draft.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: base_path+"publish-draft",
                type: "POST",
                data: {url:url},
                dataType: 'json',
                success: function (response) {
                    if(response.status == 1){
                        setTimeout(function(){
                            window.location.href = base_path+"my-draft";
                        },500);
                    }else{
                        swal({
                            title: "Error",
                            text: response.message,
                            icon: "error",
                            button: "Close",
                        });
                    }
                }
            });
        } 
    });
}



function removeDraft(url){
	swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to access back.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: base_path+"remove-draft",
                type: "POST",
                data: {url:url},
                dataType: 'json',
                success: function (response) {
                    if(response.status == 1){
						$('#draft-'+url).remove();
						
						setTimeout(function(){
                            window.location.href = base_path+"my-draft";
                        },500);
                    }else{
                        swal({
                            title: "Error",
                            text: response.message,
                            icon: "error",
                            button: "Close",
                        });
                    }
                }
            });
        } 
    });
}
