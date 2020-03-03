<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<?php if($team_details){ ?>
					<h5 class="card-title">Add team information <small class="form-text text-danger">All fields are mandatory</small></h5>
					
					<form id="update-profile" action="<?php echo base_url('admin-update-team'); ?>" method="post" enctype="multipart/form-data">
						<input value="<?php echo $team_details['team_id']; ?>" name="team_id" type="hidden">
						<input value="<?php echo $team_details['team_logo']; ?>" name="old_team_logo" type="hidden">
						
						<div class="position-relative form-group">
							<label for="exampleSelect" class="">Select Sport</label>
							<select name="sport_id" id="sport_id" class="form-control">
								<option value="">Choose sport</option>
								<?php if($sport_list){ foreach($sport_list as $sport){ ?>
									<option value="<?php echo $sport['sport_id']; ?>" <?php if($sport['sport_id'] == $team_details['related_sport_id']){ echo "selected"; } ?>><?php echo $sport['sport_title']; ?></option>
								<?php }} ?>
							</select>
						</div>
						<div class="position-relative form-group">
							<label for="team_title" class="">Team Name</label>
							<input value="<?php echo $team_details['team_title']; ?>" name="team_title" id="team_title" placeholder="Team name" type="text" class="form-control" required="required" autocomlete="off">
						</div>
						<div class="position-relative form-group">
							<label for="team_description" class="">Write something about the team</label>
							<textarea name="team_description" id="team_description" class="form-control" required="required" rows=5 style="font-size: 14px;">
								<?php echo $team_details['team_description']; ?>
							</textarea>
						</div>
						<div class="position-relative form-group">
							<img width=200 height=200 class="img-thumbnail" src="<?php echo base_url('assets/uploads/team_logo/'.$team_details['team_logo']) ?>">
						</div>
						<div class="position-relative form-group">
							<label for="team_logo" class="">Team Logo</label>
							<input name="team_logo" id="team_logo" type="file" class="form-control-file" accept="image/*">
							<small class="form-text text-info">This logo will be used in front-end. Plesase maintain the size 200x200</small>
						</div>
						<div class="position-relative form-group">
							<label for="team_logo" class="">Current Status</label>
							<div>
								<div class="custom-radio custom-control">
									<input value="1" type="radio" id="team_status1" name="team_status" class="custom-control-input" <?php if($team_details['team_status'] == 1){ ?> checked <?php } ?>>
									<label class="custom-control-label" for="team_status1">Active</label>
								</div>
								<div class="custom-radio custom-control">
									<input value="2" type="radio" id="team_status2" name="team_status" class="custom-control-input" <?php if($team_details['team_status'] == 2){ ?> checked <?php } ?>>
									<label class="custom-control-label" for="team_status2">In-active</label>
								</div>
								<div class="custom-radio custom-control">
									<input value="3" type="radio" id="team_status3" name="team_status" class="custom-control-input" <?php if($team_details['team_status'] == 3){ ?> checked <?php } ?>>
									<label class="custom-control-label" for="team_status3">Removed</label>
								</div>
							</div>
						</div>
						<button class="mt-1 btn btn-primary" type="submit">Update Team</button>
						<a href="<?php echo  base_url('admin-team-management'); ?>">
							<button class="mt-1 btn btn-outline-dark ml-3" type="button">Cancel</button>
						</a>
					</form>
					
					<?php
						if($this->session->flashdata('team_item')) {
							$message = $this->session->flashdata('team_item');
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