<div class="row">
	<div class="col-md-12">
		<?php if($league_details){ ?>
			<form id="tmp-frm">
				<input type="hidden" name="selected_template_id" id="selected_template_id" value="<?php echo $league_details['mega_pool_id']; ?>">
			</form>
			<div class="main-card mb-3">
				<div class="main-card mb-3 card">
					<div class="card-header-tab card-header">
						<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
							League Template Information
						</div>
					</div>	
					<div class="no-gutters row">
						<div class="col-md-6 col-xl-4">
							<div class="widget-content">
								<div class="widget-content-wrapper">
									<div class="widget-content-right ml-0 mr-3">
										<div class="widget-numbers text-success">
											<img width="60" height="60" class="img-thumbnail" src="<?php echo base_url('assets/uploads/megapool_template/'.$league_details['league_logo']); ?>">
										</div>
									</div>
									<div class="widget-content-left">
										<strong>Megapool Name</strong>
										<div class="widget-subheading"><?php echo $league_details['mega_pool_title']; ?></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-xl-8">
							<div class="widget-content">
								<div class="widget-content-wrapper">
									<div class="widget-content-left">
										<strong>Sport(s)</strong>
										<div class="widget-subheading">
											<?php
												if($league_details['related_sport']){
													$template_sports = explode(',',$league_details['related_sport']);
													
													foreach($template_sports as $sport){
											?>
												<span class="badge badge-primary"><?php echo $sport; ?></span>
											<?php }} ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-xl-12">
							<div class="widget-content">
								<div class="widget-content-wrapper">
									<div class="widget-content-left">
										<strong>Related Leagues(s)</strong>
										<div class="widget-subheading">
											<?php
												if($related_league){													
													foreach($related_league as $league){
											?>
												<span class="badge badge-warning"><?php echo $league['league_title']; ?></span>
											<?php }} ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-xl-12">
							<div class="widget-content">
								<div class="widget-content-wrapper">
									<div class="widget-content-left">
										<button class="mt-1 btn btn-success" id="create-mega-pool-from-template" type="button">Select this Template</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php }else{ ?>
			<div class="alert alert-danger" role="alert">
				<div>
					<div class="page-title-subheading">Nothing to display!</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>

<script>
	$('#create-mega-pool-from-template').on('click', function(){
		var template_id = $('#selected_template_id').val();
		
		$('#create-mega-pool-from-template').attr('disabled','disabled');

		if(template_id !== ''){
			$.ajax({
				url: base_path+"create-megapool-from-league-template",
				type: "POST",
				data: $('#tmp-frm').serialize(),
				dataType: 'json',
				success: function(response) {
					if(response.status === 1){
						window.location.href = "my-megapool";
					}else{
						$('#create-mega-pool-from-template').removeAttr('disabled');
					}
				}
			});
		}
	});
</script>