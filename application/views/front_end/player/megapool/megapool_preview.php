
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



<div class="row">
	<?php if($league_details){ ?>
		<div class="col-sm-12 col-md-12 widget-content">
			<h4 class="widget-numbers text-success">
				<span>
					<?php echo $league_details['mega_pool_title']; ?>
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
					<div class="col-md-6 col-xl-4">
						<div class="widget-content">
							<div class="widget-content-wrapper">
								<div class="widget-content-right ml-0 mr-3">
									<div class="widget-numbers text-warning">$<?php echo $league_details['entry_fee']; ?></div>
								</div>
								<div class="widget-content-left">
									<div class="widget-heading">Entry Fee</div>
									<div class="widget-subheading">You will be charged</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-xl-4">
						<div class="widget-content">
							<div class="widget-content-wrapper">
								<div class="widget-content-left mr-4">
									<img width=50 height=50 src="<?php echo base_url('assets/images/user.png'); ?>" class="img-thumbnail">
								</div>
								<div class="widget-content-left">
									<div class="widget-heading">League Owner</div>
									<div class="widget-subheading"><?php echo $league_details['full_name']; ?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php if($related_leagues){ ?>
			<div class="col-sm-12 col-md-12">
				<h4 class="text-dark">
					<span>
						Leagues
					</span>
				</h4>
				<div class="row">
					<?php foreach($related_leagues as $league){ ?>
						<div class="col-md-3 col-lg-3">
							
							
							<div class="card mb-3 widget-content bg-arielle-smile">
								<div class="widget-content-wrapper text-white">
									<div class="widget-content-left">
										<div class="widget-heading text-white"><?php echo $league['league_title']; ?></div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	<?php }else{ ?>
		<div class="col-md-12">
			<br/>
			<div class="alert alert-danger fade show" role="alert">
				<div>
					<strong>Error</strong>
					<div class="page-title-subheading">Nothing to display!</div>
				</div>
			</div>
		</div>
	<?php } ?>
</div>