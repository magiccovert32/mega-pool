
$('#megapool-id').on('change', function(){
	var league_url = $(this).val();
	
	if(league_url !== ''){
		$.ajax({
			url: base_path+"view-standings-table/"+league_url,
			type: "POST",
			dataType: 'html',
			success: function (response) {
				$('#standing-table').html(response);
			}
		});
	}
});
