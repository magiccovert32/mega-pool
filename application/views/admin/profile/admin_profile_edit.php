<div class="row">
	<?php if($profile_details){ ?>
		<div class="col-md-6">
			<div class="main-card mb-3 card">
				<div class="card-body">
					<h5 class="card-title">Update profile information <small class="form-text text-danger">All fields are mandatory</small></h5>
					
					
					<form id="update-profile" action="<?php echo base_url('admin-update-profile'); ?>" method="post">
						<div class="position-relative form-group">
							<label for="full_name" class="">Full Name</label>
							<input value="<?php echo $profile_details['profile_name']; ?>" name="full_name" id="full_name" placeholder="Full name" type="text" class="form-control" required="required" autocomlete="off">
						</div>
						<div class="position-relative form-group">
							<label for="email" class="">Email</label>
							<input value="<?php echo $profile_details['login_email']; ?>" name="email" id="email" placeholder="Account login email" type="email" class="form-control" required="required" autocomlete="off">
						</div>
						<button class="mt-1 btn btn-primary" type="submit">Update Profile</button>
					</form>
					
					<?php
						if($this->session->flashdata('profile_item')) {
							$message = $this->session->flashdata('profile_item');
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
		</div>
		
		<div class="col-md-6">
			<div class="main-card mb-3 card">
				<div class="card-body"><h5 class="card-title">Update account password</h5>
					<form id="update-password" action="<?php echo base_url('admin-update-password'); ?>" method="post">
						<div class="position-relative form-group">
							<label for="old_password" class="">Old Password</label>
							<input name="old_password" id="old_password" placeholder="Old password" type="password" class="form-control" required autocomlete="off">
						</div>
						<div class="position-relative form-group">
							<label for="new_password" class="">New Password</label>
							<input name="new_password" id="new_password" placeholder="New password" type="password" class="form-control" required autocomlete="off">
						</div>
						<div class="position-relative form-group">
							<label for="confirm_password" class="">Confirm Password</label>
							<input name="confirm_password" id="confirm_password" placeholder="Confirm password" type="password" class="form-control" required autocomlete="off">
						</div>
						<button class="mt-1 btn btn-primary" type="submit">Update Password</button>
					</form>
					<?php
						if($this->session->flashdata('profile_password')) {
							$message = $this->session->flashdata('profile_password');
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
		</div>
	<?php } ?>
</div>