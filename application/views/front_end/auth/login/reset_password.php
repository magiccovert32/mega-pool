<div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
	<div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
		<div class="app-logo"></div>
		<h4 class="mb-0">
			<span class="d-block">Reset Password,</span>
        </h4>
		<p><span class="text-dark">Don't share your password to anyone.</span></p>
		<div class="divider row"></div>
		<div>
			<form method="post" id="reset-pass-frm">
				<input type="hidden" name="link" value="<?php echo $link; ?>">
				<div class="form-row">
					<div class="col-md-6">
						<div class="position-relative form-group">
							<label for="new_password" class="card-title">Password</label>
							<input type="password" class="form-control" id="new_password" placeholder="Password"  autocomplete="off" name="new_password">
						</div>
					</div>
                    <div class="col-md-6">
						<div class="position-relative form-group">
							<label for="c_password" class="card-title">Confirm Password</label>
							<input type="password" class="form-control" id="c_password" placeholder="Confirm Password"  autocomplete="off" name="confirm_password">
						</div>
					</div>
				</div>
				<div class="divider row"></div>
				<div class="d-flex align-items-center">
					<div class="ml-auto">
						<button class="btn btn-primary btn-lg" type="button" id="reset-pass-btn">Change Password</button>
					</div>
				</div>
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

<script src="<?php echo base_url('assets/front_end/js/auth/reset_password.js'); ?>" ></script>