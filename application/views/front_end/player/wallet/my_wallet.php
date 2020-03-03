<div class="row">
	<?php
		if($wallet){
	?>
	<div class="col-md-12">
		<div class="mb-3 card">
			<div class="card-header-tab card-header">
				<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
					<i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>
					My Wallet Report
				</div>
				<div class="btn-actions-pane-right text-capitalize">
					<a href="<?php echo base_url('wallet-transactions'); ?>">
						<button class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm">View All</button>
					</a>
				</div>
			</div>
			<div class="no-gutters row">
				<div class="col-sm-6 col-md-4 col-xl-4">
					<div class="card no-shadow rm-border bg-transparent widget-chart text-left">
						<div class="icon-wrapper rounded-circle">
							<div class="icon-wrapper-bg opacity-10 bg-warning"></div>
							<i class="pe-7s-piggy text-dark opacity-8"></i>
						</div>
						<div class="widget-chart-content">
							<div class="widget-subheading">Wallet Balance</div>
							<div class="widget-numbers text-success">
								$<?php echo $wallet['wallet_balance']; ?>
							</div>
						</div>
					</div>
					<div class="divider m-0 d-md-none d-sm-block"></div>
				</div>
				<div class="col-sm-6 col-md-4 col-xl-4">
					<div class="card no-shadow rm-border bg-transparent widget-chart text-left">
						<div class="icon-wrapper rounded-circle">
							<div class="icon-wrapper-bg opacity-9 bg-success"></div>
							<i class="pe-7s-cloud-download text-white"></i>
						</div>
						<div class="widget-chart-content">
							<div class="widget-subheading">Received Amount</div>
							<div class="widget-numbers">
								$<?php echo $received_amount; ?>
							</div>
						</div>
					</div>
					<div class="divider m-0 d-md-none d-sm-block"></div>
				</div>
				<div class="col-sm-6 col-md-4 col-xl-4">
					<div class="card no-shadow rm-border bg-transparent widget-chart text-left">
						<div class="icon-wrapper rounded-circle">
							<div class="icon-wrapper-bg opacity-9 bg-danger"></div>
							<i class="pe-7s-up-arrow text-white"></i>
						</div>
						<div class="widget-chart-content">
							<div class="widget-subheading">Invested Amount</div>
							<div class="widget-numbers">
								$<?php echo $out_amount; ?>
							</div>
						</div>
					</div>
					<div class="divider m-0 d-md-none d-sm-block"></div>
				</div>
			</div>
			<div class="text-center d-block p-3 card-footer">
				<a href="<?php echo base_url('wallet-transactions'); ?>">
					<button class="btn-pill btn-shadow btn-wide fsize-1 btn btn-primary btn-lg">
						<span class="mr-2 opacity-7">
							<i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
						</span>
						<span class="mr-1">View Complete Report</span>
					</button>
				</a>
			</div>
		</div>
	</div>
	<?php }else{ ?>
		<div class="col-md-12">
			<br/>
			<div class="alert alert-danger fade show" role="alert">
				<div>
					<strong>Error</strong>
					<div class="page-title-subheading">Nothing to display! Seems, there are no Mega Pool created yet.</div>
				</div>
			</div>
		</div>
	<?php } ?>
</div>