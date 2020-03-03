<div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
	<div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
		<div class="app-logo"></div>
		
		<?php
			if($verification_status == 1){
				$status_class = 'success';
				$status_message = 'Account verified successfully. Please login to continue.';
			}elseif($verification_status == 2){
				$status_class = 'warning';
				$status_message = 'We are unable to verify your account at this moment. Please try again later.';
			}elseif($verification_status == 4){
				$status_class = 'warning';
				$status_message = 'We are unable to verify your account at this moment. Please try again later.';
			}elseif($verification_status == 3){
				$status_class = 'danger';
				$status_message = 'Your account has been blocked. We are unable to verify your account. Please contact Mega Pool support team.';
			}
		?>
	
		<div class="col-sm-12">
			<h4 class="text-center text-<?php echo $status_class; ?>"><?php echo $status_message; ?></h4>
		</div>
		
		<div class="col-sm-12 text-center">
			<a href="<?php echo base_url(); ?>"><div class="btn btn-success">Back To Home</div></a>
		</div>
	</div>
</div>