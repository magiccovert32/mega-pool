<div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
	<div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
		<div class="app-logo"></div>
		<h4 class="mb-0">
			<span class="d-block">Welcome back,</span>
			<span>Please sign in to your account.</span></h4>
		<div class="divider row"></div>
		<div>
			<form id="admin-login-frm" action="<?php echo base_url('check-auth'); ?>" method="post">
				<div class="form-row">
					<div class="col-md-6">
						<div class="position-relative form-group">
							<label for="exampleEmail" class="">Email</label>
							<input name="email" id="email" placeholder="Email here..." type="text" class="form-control" autocomplete="off">
						</div>
					</div>
					<div class="col-md-6">
						<div class="position-relative form-group">
							<label for="examplePassword" class="">Password</label>
							<input name="password" id="password" placeholder="Password here..." type="password" class="form-control" autocomplete="off">
						</div>
					</div>
				</div>
				<div class="divider row"></div>
				<div class="d-flex align-items-center">
					<div class="ml-auto">
						<!--<a href="javascript:void(0);" class="btn-lg btn btn-link">Recover Password</a>-->
						<button class="btn btn-primary btn-lg" type="submit">Login to Dashboard</button>
					</div>
				</div>
			</form>
			<?php
				if($this->session->flashdata('item')) {
					$message = $this->session->flashdata('item');
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