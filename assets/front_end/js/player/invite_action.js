$('.accept-invitation').on('click', function(){
	var leagueUrl = $(this).attr('data-url');
	
	swal({
		title: "Are you sure?",
		text: "You want to join this league?",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.ajax({
				url: base_path+"accept-invitation",
				type: "POST",
				data: {leagueUrl:leagueUrl},
				dataType: 'json',
				success: function (response) {
					if(response.status == 1){
						swal({
							title: "Success",
							text: response.message,
							icon: "success",
						});
						
						setTimeout(() => {
							location.reload();
						}, 1000);
					}else{
						swal({
							title: "Oops",
							text: response.message,
							icon: "error",
						});
					}
				}
			});
		}
	});
});


$('.reject-invitation').on('click', function(){
	var leagueUrl = $(this).attr('data-url');
	
	swal({
		title: "Are you sure?",
		text: "Once rejected, you will not be able join this league again",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.ajax({
				url: base_path+"reject-invitation",
				type: "POST",
				data: {leagueUrl:leagueUrl},
				dataType: 'json',
				success: function (response) {
					if(response.status == 1){
						swal({
							title: "Success",
							text: response.message,
							icon: "success",
						});
						
						setTimeout(() => {
							location.reload();
						}, 1000);
					}else{
						swal({
							title: "Oops",
							text: response.message,
							icon: "error",
						});
					}
				}
			});
		}
	});
});