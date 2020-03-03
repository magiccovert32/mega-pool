<div class="row">
    <?php if($user_details){ ?>
		<div class="col-md-6">
			<div class="main-card mb-3 card">
				<div class="card-body">
					<h5 class="card-title">Update profile information <small class="form-text text-danger">All fields are mandatory</small></h5>
					
					<form method="post" id="my-profile-frm">
                        <div class="position-relative form-group">
                            <label for="full_name">Name</label>
                            <input type="text" value="<?php echo $user_details['full_name']; ?>" class="form-control" id="full_name" placeholder="Enter full name" name="full_name" autocomplete="off">
                        </div>
                        <div class="position-relative form-group">
                            <label for="email">Email address</label>
                            <input disabled="disabled" type="email" value="<?php echo $user_details['user_email']; ?>" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email" autocomplete="off">
                            <small id="emailHelp" class="form-text text-danger">Email address can't be modified.</small>
                        </div>
						<button class="mt-1 btn btn-primary" type="button" id="update-profile-btn">Update Profile</button>
					</form>
					
					<br/>
                    <div class="alert alert-danger fade show mt-10 display_none" role="alert" id="error-msg">
                        <strong>Error</strong>
                        <div class="alert_message">
                        
                        </div>
                    </div>
                    <div class="alert alert-success fade show mt-10 display_none" role="alert" id="success-msg">
                        <strong>Success</strong>
                        <div class="alert_message">
                        
                        </div>
                    </div>
				</div>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="main-card mb-3 card">
				<div class="card-body"><h5 class="card-title">Update account password</h5>
                    <form method="post" id="change-password-frm">
						<div class="position-relative form-group">
							<label for="old_password" class="">Old Password</label>
							<input name="old_password" id="old_password" placeholder="Old password" type="password" class="form-control" required autocomlete="off">
						</div>
						<div class="position-relative form-group">
							<label for="new_password" class="">New Password</label>
							<input name="new_password" id="new_password" placeholder="New password" type="password" class="form-control" required autocomlete="off">
						</div>
						<div class="position-relative form-group">
							<label for="c_password" class="">Confirm Password</label>
							<input name="c_password" id="c_password" placeholder="Confirm password" type="password" class="form-control" required autocomlete="off">
						</div>
						<button class="mt-1 btn btn-primary" type="button" id="chamge-password-btn">Update Password</button>
					</form>
					<br/>
                    <div class="alert alert-danger fade show mt-10 display_none" role="alert" id="error-msg-p">
                        <strong>Error</strong>
                        <div class="alert_message">
                        
                        </div>
                    </div>
                    <div class="alert alert-success fade show mt-10 display_none" role="alert" id="success-msg-p">
                        <strong>Success</strong>
                        <div class="alert_message">
                        
                        </div>
                    </div>
				</div>
			</div>
		</div>
	<?php } ?>
</div>


<script src="<?php echo base_url('assets/front_end/js/profile/profile_update.js'); ?>" ></script>