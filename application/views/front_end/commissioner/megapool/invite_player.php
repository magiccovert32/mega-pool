
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<div class="row">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-header-tab card-header">
				<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
					<i class="header-icon lnr-envelope icon-gradient bg-malibu-beach"> </i>Invite players
				</div>
			</div>
			<?php if($league_details){ ?>
				<div class="card-body">
					<form method="post">
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<div class="position-relative form-group">
									<input name="url" id="url" type="hidden" value="<?php echo $league_details['mega_pool_url']; ?>" class="form-control" autocomplete="off">
									<label for="email" class="">Email Address</label>
									<input name="email" id="email" placeholder="Enter player email address" type="email" class="form-control" autocomplete="off">
									<strong class="text-info">Click the plus button to add the email address to the list.</strong>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<div class="position-relative form-group">
									<button type="button" data-toggle="tooltip" title="" id="add-email" data-placement="bottom" class="btn-shadow mr-3 btn btn-success" data-original-title="Click to add email">
										<i class="fa fa-plus"></i>
									</button>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
                                <div class="alert alert-info fade show" role="alert">
									<div id="email-list">
										List is empty!
									</div>
								</div>
							</div>
						</div>
					</form>
					
					<br/>
					<div class="alert alert-danger fade show mt-10 display_none n_alert" role="alert" id="error-msg">
						<strong>Correct the following error(s)</strong>
						<div class="alert_message">
						
						</div>
					</div>
					<div class="alert alert-success fade show mt-10 display_none n_alert" role="alert" id="success-msg">
						<strong>Success</strong>
						<div class="alert_message">
						
						</div>
					</div>
				</div>
				<div class="card-footer d-block clearfix">
					<div class="float-left">
						<button class="mt-1 btn btn-primary" type="button" id="send-invitation">Send Invitation</button>
					</div>
				</div>
			<?php }else{ ?>
				<div class="col-md-12">
					<br/>
					<div class="alert alert-danger fade show" role="alert">
						<div>
							<strong>Error</strong>
							<div class="page-title-subheading">Something went wrong. Please check your URL.</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>

<script src="<?php echo base_url('assets/front_end/js/commissioner/invite_player.js'); ?>" ></script>