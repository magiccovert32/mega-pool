
$('#megapool-id').on('change', function(){
	var league_url 	= $(this).val();
	var html 		= $('#loading-screen').html();
	
	if(league_url !== ''){
		$('#standing-table').html(html);
		$.ajax({
			url: base_path+"view-draft-standings-table/"+league_url,
			type: "POST",
			dataType: 'html',
			success: function (response) {
				$('#standing-table').html(response);
			}
		});
	}
});
