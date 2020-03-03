<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<?php if($user_details){ ?>
					<h5 class="card-title">Add commissioner information <small class="form-text text-danger">All fields are mandatory</small></h5>
					
					<form id="update-profile" action="<?php echo base_url('admin-update-commissioner'); ?>" method="post" enctype="multipart/form-data">
						<input value="<?php echo $user_details['user_id']; ?>" name="user_id" type="hidden">
						<input value="<?php echo $user_details['profile_image']; ?>" name="old_profile_image" type="hidden">
						<div class="position-relative form-group">
							<label for="full_name" class="">Commissioner Name</label>
							<input value="<?php echo $user_details['full_name']; ?>" name="full_name" id="full_name" placeholder="Commissioner name" type="text" class="form-control" required="required" autocomlete="off">
						</div>
						<div class="position-relative form-group">
							<label for="user_email" class="">Commissioner Email</label>
							<input value="<?php echo $user_details['user_email']; ?>" name="user_email" id="user_email" placeholder="Commissioner email" type="email" class="form-control" required="required" autocomlete="off">
						</div>
						<?php if($user_details['profile_image'] != ''){ ?>
							<div class="position-relative form-group">
								<img width=200 height=200 class="img-thumbnail" src="<?php echo base_url('assets/uploads/profile_image/'.$user_details['profile_image']); ?>">
							</div>
						<?php }else{ ?>
							<div class="position-relative form-group">
								<img width=200 height=200 class="img-thumbnail" src="<?php echo base_url('assets/images/user.png'); ?>">
							</div>
						<?php } ?>
						<div class="position-relative form-group">
							<label for="profile_image" class="">Profile Image</label>
							<input name="profile_image" id="profile_image" type="file" class="form-control-file" accept="image/*">
							<small class="form-text text-info">This logo will be used in front-end. Plesase maintain the size 200x250</small>
						</div>
						<div class="position-relative form-group">
							<label for="current_status" class="">Current Status</label>
							<div>
								<div class="custom-radio custom-control">
									<input value="1" type="radio" id="current_status1" name="current_status" class="custom-control-input" <?php if($user_details['current_status'] == 1){ ?> checked <?php } ?>>
									<label class="custom-control-label" for="current_status1">Active</label>
								</div>
								<div class="custom-radio custom-control">
									<input value="2" type="radio" id="current_status2" name="current_status" class="custom-control-input" <?php if($user_details['current_status'] == 2){ ?> checked <?php } ?>>
									<label class="custom-control-label" for="current_status2">In-active</label>
								</div>
								<div class="custom-radio custom-control">
									<input value="3" type="radio" id="current_status3" name="current_status" class="custom-control-input" <?php if($user_details['current_status'] == 3){ ?> checked <?php } ?>>
									<label class="custom-control-label" for="current_status3">Blocked</label>
								</div>
								<div class="custom-radio custom-control">
									<input value="4" type="radio" id="current_status4" name="current_status" class="custom-control-input" <?php if($user_details['current_status'] == 4){ ?> checked <?php } ?>>
									<label class="custom-control-label" for="current_status4">Email Un-verified</label>
								</div>
							</div>
						</div>
						<button class="mt-1 btn btn-primary" type="submit">Update Commissioner</button>
						<a href="<?php echo  base_url('admin-commissioner-management'); ?>">
							<button class="mt-1 btn btn-outline-dark ml-3" type="button">Cancel</button>
						</a>
					</form>
					
					<?php
						if($this->session->flashdata('commissioner_item')) {
							$message = $this->session->flashdata('commissioner_item');
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