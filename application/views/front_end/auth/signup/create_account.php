<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet" >

<div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
	<div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
		<div class="app-logo"></div>
		<h4 class="mb-0">
			<span class="d-block">Create an account</span>
        </h4>
        <h6 class="mt-3">Already have an account? <a href="<?php echo base_url('account-login'); ?>" class="text-primary">Sign in</a></h6>
		<div class="divider row"></div>
		<div>
            <form method="post" id="signup-frm">
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
							<label for="full_name" class="card-title">Full Name</label>
							<input type="text" class="form-control" id="full_name" placeholder="Enter your name" name="full_name" autocomplete="off">
						</div>
					</div>
                    
					<div class="col-md-6">
						<div class="position-relative form-group">
							<label for="email" class="card-title">Email</label>
							<input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email" autocomplete="off">
						</div>
					</div>
					
					<div class="col-md-8">
						<div class="position-relative form-group">
							<label for="dob" class="card-title">DOB</label>
							<div class="row">
								<div class="col-md-4">
									<select class="form-control" id="dobday" name="dobday"></select>
								</div>
								<div class="col-md-4">
									<select class="form-control" id="dobmonth" name="dobmonth"></select>
								</div>
								<div class="col-md-4">
									<select class="form-control" id="dobyear" name="dobyear"></select>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="position-relative form-group">
							<label for="password" class="card-title">Password</label>
							<input type="password" class="form-control" id="password" placeholder="Password"  autocomplete="off" name="password">
						</div>
					</div>
                    <div class="col-md-6">
						<div class="position-relative form-group">
							<label for="confirm-password" class="card-title">Confirm Password</label>
							<input type="password" class="form-control" id="confirm-password" placeholder="Confirm Password"  autocomplete="off" name="confirm_password">
						</div>
					</div>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" value="" id="tandc" checked>
					<label class="form-check-label" for="tandc">
						By clicking 'Sign up', you agree to our <a href="<?php echo base_url('terms-conditions'); ?>" class="text-info" style="cursor: pointer;"><b>terms of service, privacy policy</b></a>
					</label>
				</div>
				<div class="divider row"></div>
				<div class="d-flex align-items-center">
					<div class="ml-auto">
						<button class="btn btn-primary btn-lg" type="button" id="signup-btn">Create Account</button>
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

<script src="<?php echo base_url('assets/front_end/js/auth/create_account.js'); ?>" ></script>
<script src="<?php echo base_url('assets/front_end/js/auth/dobpicker.js'); ?>" ></script>