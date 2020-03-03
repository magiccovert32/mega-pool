<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<?php if($sport_details){ ?>
					<h5 class="card-title">Add sport information <small class="form-text text-danger">All fields are mandatory</small></h5>
					
					<form id="update-profile" action="<?php echo base_url('admin-update-sport'); ?>" method="post" enctype="multipart/form-data">
						<input value="<?php echo $sport_details['sport_id']; ?>" name="sport_id" type="hidden">
						<input value="<?php echo $sport_details['sport_logo']; ?>" name="old_sport_logo" type="hidden">
						<div class="position-relative form-group">
							<label for="sport_title" class="">Sport Name</label>
							<input value="<?php echo $sport_details['sport_title']; ?>" name="sport_title" id="sport_title" placeholder="Sport name" type="text" class="form-control" required="required" autocomlete="off">
						</div>
						<div class="position-relative form-group">
							<label for="sport_description" class="">Write something about the sport</label>
							<textarea name="sport_description" id="sport_description" class="form-control" required="required" rows=5 style="font-size: 14px;">
								<?php echo $sport_details['sport_description']; ?>
							</textarea>
						</div>
						<div class="position-relative form-group">
							<img width=200 height=200 class="img-thumbnail" src="<?php echo base_url('assets/uploads/sport_logo/'.$sport_details['sport_logo']) ?>">
						</div>
						<div class="position-relative form-group">
							<label for="sport_logo" class="">Sport Logo</label>
							<input name="sport_logo" id="sport_logo" type="file" class="form-control-file" accept="image/*">
							<small class="form-text text-info">This logo will be used in front-end. Plesase maintain the size 200x200</small>
						</div>
						<div class="position-relative form-group">
							<label for="sport_logo" class="">Current Status</label>
							<div>
								<div class="custom-radio custom-control">
									<input value="1" type="radio" id="sport_status1" name="sport_status" class="custom-control-input" <?php if($sport_details['sport_status'] == 1){ ?> checked <?php } ?>>
									<label class="custom-control-label" for="sport_status1">Active</label>
								</div>
								<div class="custom-radio custom-control">
									<input value="2" type="radio" id="sport_status2" name="sport_status" class="custom-control-input" <?php if($sport_details['sport_status'] == 2){ ?> checked <?php } ?>>
									<label class="custom-control-label" for="sport_status2">In-active</label>
								</div>
								<div class="custom-radio custom-control">
									<input value="3" type="radio" id="sport_status3" name="sport_status" class="custom-control-input" <?php if($sport_details['sport_status'] == 3){ ?> checked <?php } ?>>
									<label class="custom-control-label" for="sport_status3">Removed</label>
								</div>
							</div>
						</div>
						<button class="mt-1 btn btn-primary" type="submit">Update Sport</button>
						<a href="<?php echo  base_url('admin-sport-management'); ?>">
							<button class="mt-1 btn btn-outline-dark ml-3" type="button">Cancel</button>
						</a>
					</form>
					
					<?php
						if($this->session->flashdata('sport_item')) {
							$message = $this->session->flashdata('sport_item');
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