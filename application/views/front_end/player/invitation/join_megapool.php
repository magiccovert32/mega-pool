
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<div class="row">
	<?php if($invitation_details){ ?>
		<div class="col-sm-12 col-md-12 widget-content">
			<h4 class="widget-numbers text-success">
				<span>
					<?php echo $invitation_details['mega_pool_title']; ?>
				</span>
			</h4>
		</div>
		<div class="col-sm-12 col-md-12">
			<div class="main-card mb-3 card">
				<div class="no-gutters row">
					<div class="col-md-6 col-xl-4">
						<div class="widget-content">
							<div class="widget-content-wrapper">
								<div class="widget-content-right ml-0 mr-3">
									<div class="widget-numbers text-success"><?php echo $total_player; ?></div>
								</div>
								<div class="widget-content-left">
									<div class="widget-heading">Total Players</div>
									<div class="widget-subheading">This season playing</div>
								</div>
							</div>
						</div>
					</div>
					<!--<div class="col-md-6 col-xl-4">
						<div class="widget-content">
							<div class="widget-content-wrapper">
								<div class="widget-content-right ml-0 mr-3">
									<div class="widget-numbers text-warning">$<?php echo $invitation_details['entry_fee']; ?></div>
								</div>
								<div class="widget-content-left">
									<div class="widget-heading">Entry Fee</div>
									<div class="widget-subheading">You will be charged</div>
								</div>
							</div>
						</div>
					</div>-->
					<div class="col-md-6 col-xl-4">
						<div class="widget-content">
							<div class="widget-content-wrapper">
								<div class="widget-content-left mr-4">
									<img width=50 height=50 src="<?php echo base_url('assets/images/user.png'); ?>" class="img-thumbnail">
								</div>
								<div class="widget-content-left">
									<div class="widget-heading">League Owner</div>
									<div class="widget-subheading"><?php echo $invitation_details['full_name']; ?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="widget-content-right widget-content-actions text-center">
					<button data-url="<?php echo $invitation_details['mega_pool_url']; ?>" class="mb-2 mr-2 btn-icon btn-pill btn btn-outline-success accept-invitation"><i class="ion-android-done-all btn-icon-wrapper"> </i>Accept</button>
					<button data-url="<?php echo $invitation_details['mega_pool_url']; ?>" class="mb-2 mr-2 btn-icon btn-pill btn btn-outline-danger reject-invitation"><i class="ion-android-close btn-icon-wrapper"> </i>Reject</button>
				</div>
			</div>
		</div>
	<?php }else{ ?>
		<div class="col-md-12">
			<br/>
			<div class="alert alert-danger fade show" role="alert">
				<div>
					<strong>Error</strong>
					<div class="page-title-subheading">You don't have access to view this page!</div>
				</div>
			</div>
			<div class="widget-content-right widget-content-actions text-center">
				<a href="<?php echo base_url('invitations'); ?>">
					<button class="btn-pill btn-shadow btn-wide fsize-1 btn btn-primary btn-lg">
						<span class="mr-2 opacity-7">
							<i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
						</span>
						<span class="mr-1">View Pending Invitations</span>
					</button>
				</a>
			</div>
		</div>
	<?php } ?>
</div>

<script src="<?php echo base_url('assets/front_end/js/player/invite_action.js'); ?>" ></script>