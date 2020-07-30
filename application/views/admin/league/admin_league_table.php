<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<?php if($league_details){ ?>
					<h5 class="card-title">Add Position Point</h5>
					
					<?php
						if($league_team_count > 0){
					?>
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
						<form id="update-profile" action="<?php echo base_url('admin-save-league-team-position-score'); ?>" method="post">
							
							<input type="hidden" class="form-control" name="league_id" value="<?php echo $league_details['league_id'] ?>">
							<?php
								for($i=1;$i<=$league_team_count;$i++){
									$j = $i-1;
							?>
								<div class="form-group">
									<label for="firstname">Position <?php echo $i; ?></label>
									<div>
										<input type="text" class="form-control" name="position[]" placeholder="Enter point" data-position="<?php echo $i; ?>" <?php if(!empty($league_team_position[$j])){ ?> value="<?php echo $league_team_position[$j]['score'] ?>" <?php }else{ ?> value="0" <?php } ?>>
									</div>
								</div>
							<?php } ?>
							<button class="mt-1 btn btn-primary" type="submit">Save Position Score</button>
							
							<a href="<?php echo  base_url('admin-league-management'); ?>">
								<button class="mt-1 btn btn-outline-dark ml-3" type="button">Cancel</button>
							</a>
						</form>
					<?php }else{ ?>
						<div class="alert alert-danger fade show mt-10" role="alert">
							<div>
								<strong>Error</strong>
								<div class="page-title-subheading">No team added yet.</div>
							</div>
						</div>
					<?php } ?>
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
	</div>
</div>