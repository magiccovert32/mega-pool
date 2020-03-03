function publish(url){
    swal({
        title: "Are you sure?",
        text: "Once published, you will not be able to modify the league. Please make sure all the informations are ready to be online.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: base_path+"publish-megapool",
                type: "POST",
                data: {url:url},
                dataType: 'json',
                success: function (response) {
                    if(response.status == 1){
                        setTimeout(function(){
                            window.location.href = base_path+"my-megapool";
                        },500)
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


function removeLeague(url){
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
                url: base_path+"remove-megapool",
                type: "POST",
                data: {url:url},
                dataType: 'json',
                success: function (response) {
                    if(response.status == 1){
                        setTimeout(function(){
                            window.location.href = base_path+"my-megapool";
                        },500)
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