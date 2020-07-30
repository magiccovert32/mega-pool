<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body"><h5 class="card-title">Quick Access</h5>
                <div class="grid-menu grid-menu-3col">
                    <div class="no-gutters row">
                        <div class="col-sm-6 col-xl-4">
                            <a href="<?php echo  base_url('manage-draft'); ?>">
                                <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-primary"><i class="lnr-heart btn-icon-wrapper"> </i><span class="badge badge-primary badge-dot badge-dot-lg badge-dot-inside"> </span>My Draft
                                </button>
                            </a>
                        </div>
                        <div class="col-sm-6 col-xl-4">
                            <a href="<?php echo  base_url('my-leagues'); ?>">
                                <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-secondary"><i class="lnr-database btn-icon-wrapper"> </i><span class="badge badge-success badge-dot badge-dot-inside"> </span>My Megapool
                                </button>
                            </a>
                        </div>
                        <div class="col-sm-6 col-xl-4">
                            <a href="<?php echo  base_url('my-profile'); ?>">
                                <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-success"><i class="lnr-cog btn-icon-wrapper"> </i><span class="badge badge-danger badge-dot badge-dot-inside"> </span>Profile Settings
                                </button>
                            </a>
                        </div>
                        <div class="col-sm-6 col-xl-4">
                            <a href="<?php echo  base_url('my-wallet'); ?>">
                                <button class="btn-icon-vertical btn-square  br-tr btn-transition btn btn-outline-info"><i class="lnr-users btn-icon-wrapper"> </i><span class="badge badge-warning badge-dot badge-dot-inside"> </span>My Wallet
                                </button>
                            </a>
                        </div>
                        <div class="col-sm-6 col-xl-4">
                            <a href="<?php echo  base_url('wallet-transactions'); ?>">
                                <button class="btn-icon-vertical btn-square  br-bl btn-transition btn btn-outline-warning"><i class="lnr-layers btn-icon-wrapper"> </i><span class="badge badge-primary badge-dot badge-dot-inside"> </span>Transactions
                                </button>
                            </a>
                        </div>
                        <div class="col-sm-6 col-xl-4">
							<a href="<?php echo  base_url('invitations'); ?>">
								<button class="btn-icon-vertical btn-square btn-transition btn btn-outline-danger"><i class="lnr-bullhorn btn-icon-wrapper"> </i><span class="badge badge-success badge-dot badge-dot-inside"> </span>Invitations
								</button>
							</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<h5 class="widget-heading text-dark">Select your Megapool to see the Standing Table</h5>
				<div class="row">
					<div class="col-sm-12 col-md-4">
						<div class="position-relative form-group">
							<label for="megapool-id" class="">Megapool List :</label>
							<select name="select" id="megapool-id" class="form-control">
								<option value="">Choose...</option>
								<?php if($megapool_list){ foreach($megapool_list as $megapool){ ?>
									<option value="<?php echo $megapool['mega_pool_url']; ?>"><?php echo $megapool['mega_pool_title']; ?></option>
								<?php }} ?>
							</select>
						</div>
					</div>
				</div>
				
				<div id="standing-table">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<div class="alert alert-info fade show" role="alert">
								<span class="alert-link">Megapool Standing Table</span> will be displayed here!
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div style="display: none;" id="loading-screen">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<span class="alert-link text-warning">Please wait. Loading Standing Table...</span>
		</div>
	</div>
</div>

<script src="<?php echo base_url('assets/front_end/js/player/view_standing_table.js'); ?>" ></script>