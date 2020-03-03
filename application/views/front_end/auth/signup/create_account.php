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








<!-- <div class="container align-baseline">
    <div class="jumbotron">
        <div class="container">
            <form method="post" id="signup-frm">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" class="form-control" id="full_name" placeholder="Enter your name" name="full_name" autocomplete="off">
                </div>
                <div class="form-group">
                    <div>
                        <label for="password">I am a</label>
                    </div>
                    <input type="radio"  name="user_type_id" value="1"> Commissioner 
                    <input type="radio"  name="user_type_id" value="2" checked="checked"> Player
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password"  autocomplete="off" name="password">
                </div>
                <div class="form-group">
                    <label for="password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm-password" placeholder="Confirm Password"  autocomplete="off" name="confirm_password">
                </div>
                <button type="button" class="btn btn-primary" id="signup-btn">Create Account</button>
            </form>
            <div class="alert alert-danger display_none mt-2" role="alert" id="error-msg">
                <h5 class="alert-heading">Please correct the following error(s)</h5>
                <div class="alert_message">
                
                </div>
            </div>
            <div class="alert alert-success display_none mt-2" role="alert" id="success-msg">
                <h5 class="alert-heading">Success</h5>
                <div class="alert_message">
                
                </div>
            </div>
            <div class="divider"></div>
            <p>
                <small id="emailHelp" class="form-text text-muted">Already have an account? <a href="<?php echo base_url('account-login'); ?>">Sign in</a></small>
            </p>
        </div>
    </div>
</div> -->

<script src="<?php echo base_url('assets/front_end/js/auth/create_account.js'); ?>" ></script>