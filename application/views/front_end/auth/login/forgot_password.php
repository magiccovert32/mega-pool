<div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
	<div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
		<div class="app-logo"></div>
		<h4 class="mb-0">
			<span class="d-block">Forgot Password,</span>
        </h4>
		<p><span class="text-info">Please enter your email address. We will send a password verification link to your registered email address.</span></p>
		<div class="divider row"></div>
		<div>
			<form method="post" id="forgot-pass-frm">
				<div class="form-row">
					<div class="col-md-12">
						<div class="position-relative form-group">
							<label for="exampleEmail" class="card-title">Email</label>
							<input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email" autocomplete="off">
						</div>
					</div>
				</div>				
				<div class="divider row"></div>
				<div class="d-flex align-items-center">
					<div class="ml-auto">
						<button class="btn btn-primary btn-lg" type="button" id="forgot-pass-btn">Send Link</button>
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

<script src="<?php echo base_url('assets/front_end/js/auth/forgot_password.js'); ?>" ></script>