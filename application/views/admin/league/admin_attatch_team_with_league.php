<!-- Include the plugin's CSS and JS: -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" type="text/css"/>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<div class="row">
	<div class="col-md-12">
		<?php if($league_details){ ?>
			<div class="main-card mb-3 card">
				<div class="card-body">
					<h5 class="card-title">Attatch teams to <?php echo $league_details['league_title']; ?> <small class="form-text text-danger">All fields are mandatory</small></h5>
					<div class="widget-content-left mr-4">
						<img width=200 height=200 src="<?php echo base_url('assets/uploads/league_logo/'.$league_details['league_logo']) ?>" class="img-thumbnail">
					</div>
					<form id="update-profile" action="<?php echo base_url('admin-save-league-team-relation'); ?>" method="post">
						<input type="hidden" name="league_id" value="<?php echo $league_details['league_id']; ?>">
						<br/>
						<div class="position-relative form-group">
							<label for="team_id" class="">Select Team</label>
							<select name="team_id[]" id="team_id" class="form-control" multiple="multiple">
								<?php if($team_list){ foreach($team_list as $team){ ?>
									<option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_title']; ?></option>
								<?php }} ?>
							</select>
						</div>
						<button class="ladda-button mb-2 mr-2 btn btn-primary" data-style="expand-left" type="submit">
								<span class="ladda-label">Add Teams</span>                                    
			                    <span class="ladda-spinner"></span>
							<div class="ladda-progress" style="width: 0px;"></div>
						</button>
						<a href="<?php echo  base_url('admin-league-management'); ?>">
							<button class="btn btn-outline-dark mb-2 mr-2" type="button">Back</button>
						</a>
					</form>
					
					<?php
						if($this->session->flashdata('league_item')) {
							$message = $this->session->flashdata('league_item');
					?>
						<br/>
						<div class="alert alert-<?php echo $message['class']; ?> fade show mt-10" role="alert">
							<div>
								<strong>Notifications</strong>
								<div class="page-title-subheading"><?php echo $message['message']; ?></div>
							</div>
						</div>
					<?php 
						}
					?>
				</div>
			</div>
			
			<div class="main-card mb-3 card">
				<div class="card-body">
					<h5 class="card-title">Attatched Teams</h5>
					
					<div class="row">
						<?php if($attatched_team_list){ ?>
							<?php foreach($attatched_team_list as $team_list){ ?>
								<div class="col-md-2">
									<div class="main-card mb-4 card">
										<div class="card-header">
											<div class="btn-actions-pane-right actions-icon-btn">
												<button class="btn-icon btn-icon-only btn btn-link" onclick="removeRelation(<?php echo $team_list['team_id']; ?>,<?php echo $league_details['league_id']; ?>)"><i class="pe-7s-trash btn-icon-wrapper text-danger"></i></button>
											</div>
										</div>
										<div class="card-body">
											<img width=100 height=100 src="<?php echo base_url('assets/uploads/team_logo/'.$team_list['team_logo']) ?>" class="img-thumbnail">
										</div>
										<div class="card-footer">
											<small>
												<?php
													if(strlen($team_list['team_title']) > 15){
														echo substr($team_list['team_title'],0,15).'..';
													}else{
														echo $team_list['team_title'];
													}
												?>
											</small>
										</div>
									</div>
								</div>
							<?php } ?>
						<?php }else{ ?>
							<div class="col-md-12">
								<div class="alert alert-warning fade show mt-10" role="alert">
									<div>
										<strong>Notice</strong>
										<div class="page-title-subheading">No team added with this league.</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php }else{ ?>
			<div class="alert alert-info fade show mt-10" role="alert">
				<div>
					<strong>Error</strong>
					<div class="page-title-subheading">No details found! Something went wrong.</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
        $('#team_id').multiselect({
            enableFiltering: true,
            filterPlaceholder: 'Search for team name...'
        });
    });
	
	function removeRelation(id,league_id){
		swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to recover this!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					type: 'POST',
					url: "<?php echo base_url('admin-remove-league-team-relation'); ?>",
					data: {teamId: id,league_id:league_id},
					dataType: "json",
					success: function(resultData) {
						if(resultData.status == 1){
							location.reload();
						}else{
							swal(resultData.message);
						}
					}
				});
			}
		});
	}
</script>