
$('#draft-id').on('change', function(){
	var draft_url = $(this).val();
	
	if(draft_url !== ''){
		$.ajax({
			url: base_path+"view-draft-standings-table/"+draft_url,
			type: "POST",
			dataType: 'html',
			success: function (response) {
				$('#standing-table').html(response);
			}
		});
	}else{
		let response = `<div class="row">
							<div class="col-sm-12 col-md-12">
								<div class="alert alert-info fade show" role="alert">
									<span class="alert-link">Megapool Standing Table</span> will be displayed here!
								</div>
							</div>
						</div>`;
						
		$('#standing-table').html(response);
	}
});
