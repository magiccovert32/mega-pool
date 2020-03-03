<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<?php if($league_details){ ?>
					<h5 class="card-title">Add league information <small class="form-text text-danger">All fields are mandatory</small></h5>
					
					<form id="update-profile" action="<?php echo base_url('admin-update-league'); ?>" method="post" enctype="multipart/form-data">
						<input value="<?php echo $league_details['league_id']; ?>" name="league_id" type="hidden">
						<input value="<?php echo $league_details['league_logo']; ?>" name="old_league_logo" type="hidden">
						
						<div class="position-relative form-group">
							<label for="exampleSelect" class="">Select Sport</label>
							<select name="sport_id" id="sport_id" class="form-control">
								<option value="">Choose sport</option>
								<?php if($sport_list){ foreach($sport_list as $sport){ ?>
									<option value="<?php echo $sport['sport_id']; ?>" <?php if($sport['sport_id'] == $league_details['related_sport_id']){ echo "selected"; } ?>><?php echo $sport['sport_title']; ?></option>
								<?php }} ?>
							</select>
						</div>
						<div class="position-relative form-group">
							<label for="league_title" class="">League Name</label>
							<input value="<?php echo $league_details['league_title']; ?>" name="league_title" id="league_title" placeholder="League name" type="text" class="form-control" required="required" autocomlete="off">
						</div>
						<div class="position-relative form-group">
							<label for="league_description" class="">Write something about the league</label>
							<textarea name="league_description" id="league_description" class="form-control" required="required" rows=5 style="font-size: 14px;">
								<?php echo $league_details['league_description']; ?>
							</textarea>
						</div>
						<div class="row">
							<div class="col-sm-6 col-md-6">
								<div class="position-relative form-group">
									<label for="win_point" class="">Winning Point</label>
									<input name="win_point" id="win_point" placeholder="Winning Point" type="text" value="<?php echo $league_details['win_point']; ?>" class="form-control" required="required" autocomlete="off">
								</div>
							</div>
							<div class="col-sm-6 col-md-6">
								<div class="position-relative form-group">
									<label for="draw_point" class="">Draw Point</label>
									<input name="draw_point" id="draw_point" placeholder="Draw Point" type="text" value="<?php echo $league_details['draw_point']; ?>" class="form-control" required="required" autocomlete="off">
								</div>
							</div>
						</div>
						<div class="position-relative form-group">
							<img width=200 height=200 class="img-thumbnail" src="<?php echo base_url('assets/uploads/league_logo/'.$league_details['league_logo']) ?>">
						</div>
						<div class="position-relative form-group">
							<label for="league_logo" class="">League Logo</label>
							<input name="league_logo" id="league_logo" type="file" class="form-control-file" accept="image/*">
							<small class="form-text text-info">This logo will be used in front-end. Plesase maintain the size 200x200</small>
						</div>
						<div class="position-relative form-group">
							<label for="league_logo" class="">Current Status</label>
							<div>
								<div class="custom-radio custom-control">
									<input value="1" type="radio" id="league_status1" name="league_status" class="custom-control-input" <?php if($league_details['league_status'] == 1){ ?> checked <?php } ?>>
									<label class="custom-control-label" for="league_status1">Active</label>
								</div>
								<div class="custom-radio custom-control">
									<input value="2" type="radio" id="league_status2" name="league_status" class="custom-control-input" <?php if($league_details['league_status'] == 2){ ?> checked <?php } ?>>
									<label class="custom-control-label" for="league_status2">In-active</label>
								</div>
								<div class="custom-radio custom-control">
									<input value="3" type="radio" id="league_status3" name="league_status" class="custom-control-input" <?php if($league_details['league_status'] == 3){ ?> checked <?php } ?>>
									<label class="custom-control-label" for="league_status3">Removed</label>
								</div>
							</div>
						</div>
						<button class="mt-1 btn btn-primary" type="submit">Update League</button>
						<a href="<?php echo  base_url('admin-league-management'); ?>">
							<button class="mt-1 btn btn-outline-dark ml-3" type="button">Cancel</button>
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