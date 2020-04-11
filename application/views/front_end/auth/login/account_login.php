<div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
	<div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
		<div class="app-logo"></div>
		<h4 class="mb-0">
			<span class="d-block">Welcome back,</span>
			<span>Please sign in to your account.</span>
        </h4>
        <h6 class="mt-3">Don't have an account? <a href="<?php echo base_url('create-account'); ?>" class="text-primary">Sign up now</a></h6>
		<div class="divider row"></div>
		<div>
			<form method="post" id="login-frm">
				<div class="form-row">
					<div class="col-md-12">
						<div class="position-relative form-group">
							<label for="full_name" class="card-title">I am a</label>
                            <div class="custom-radio custom-control">
                                <input type="radio" id="user_type_id1" name="user_type_id" value="1" class="custom-control-input">
                                <label class="custom-control-label" for="user_type_id1">Commissioner</label>
                            </div>
                            <div class="custom-radio custom-control">
                                <input type="radio" id="user_type_id2" name="user_type_id" value="2" class="custom-control-input" checked="checked">
                                <label class="custom-control-label" for="user_type_id2">Player</label>
                            </div>
                        </div>
					</div>
					<div class="col-md-6">
						<div class="position-relative form-group">
							<label for="exampleEmail" class="card-title">Email</label>
							<input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email" autocomplete="off">
						</div>
					</div>
					<div class="col-md-6">
						<div class="position-relative form-group">
							<label for="examplePassword" class="card-title">Password</label>
							<input type="password" class="form-control" id="password" placeholder="Password"  autocomplete="off" name="password">
						</div>
					</div>
				</div>
				
				<p class="mt-3 text-right">Forgot password? <a href="<?php echo base_url('forgot-password'); ?>" class="text-primary">Click here</a></p>
				
				<div class="divider row"></div>
				<div class="d-flex align-items-center">
					<div class="ml-auto">
						<button class="btn btn-primary btn-lg" type="button" id="login-btn">Login to Dashboard</button>
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

<script src="<?php echo base_url('assets/front_end/js/auth/account_login.js'); ?>" ></script>