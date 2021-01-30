<div class="row">
	<div class="col-md-6 col-xl-4">
		<div class="card mb-3 widget-content">
			<div class="widget-content-outer">
				<div class="widget-content-wrapper">
					<div class="widget-content-left">
						<div class="widget-heading">Total Megapool</div>
						<div class="widget-subheading">Your created Megapool</div>
					</div>
					<div class="widget-content-right">
						<div class="widget-numbers text-success"><?php echo $megapool_count; ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-xl-4">
		<div class="card mb-3 widget-content">
			<div class="widget-content-outer">
				<div class="widget-content-wrapper">
					<div class="widget-content-left">
						<div class="widget-heading">Total Draft</div>
						<div class="widget-subheading">Your created Drafts</div>
					</div>
					<div class="widget-content-right">
						<div class="widget-numbers text-warning"><?php echo $draft_count; ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-xl-4">
		<div class="card mb-3 widget-content">
			<div class="widget-content-outer">
				<div class="widget-content-wrapper">
					<div class="widget-content-left">
						<div class="widget-heading">Total Players</div>
						<div class="widget-subheading">Megapool players</div>
					</div>
					<div class="widget-content-right">
						<div class="widget-numbers text-danger"><?php echo $player_count; ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php if($created_megapool_list){ ?>
        <div class="col-sm-12 col-lg-6">
            <div class="card-hover-shadow-2x mb-3 card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-database icon-gradient bg-sunny-morning"> </i>My Megapools
                    </div>
                    <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                        <a href="<?php echo base_url('my-megapool'); ?>">view all <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="scroll-area-lg">
                    <div class="scrollbar-container ps ps--active-y">
                        <ul class="todo-list-wrapper list-group list-group-flush">
							<?php foreach($created_megapool_list as $list){ ?>
								<li class="list-group-item">
									<div class="todo-indicator bg-warning"></div>
									<div class="widget-content p-0">
										<div class="widget-content-wrapper">
											<div class="widget-content-left mr-2">
												<img width=30 height=30 src="<?php echo base_url('assets/uploads/megapool_logo/'.$list['league_logo']) ?>" class="img-thumbnail">
											</div>
											<div class="widget-content-left">
												<div class="widget-heading">
													<?php echo $list['mega_pool_title']; ?>
												</div>
												<div class="widget-subheading"><span class="text-info"><?php echo $list['sport_title']; ?></span></div>
											</div>
											<div class="widget-content-right">
												<a href="<?php echo  base_url('view-megapool/'.$list['mega_pool_url']); ?>">
													<div class="badge badge-success">View</div>
												</a>
											</div>
										</div>
									</div>
								</li>
							<?php } ?>
						</ul>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    
    <?php if($my_megapool_list){ ?>
        <div class="col-sm-12 col-lg-6">
            <div class="card-hover-shadow-2x mb-3 card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-database icon-gradient bg-sunny-morning"> </i>My Leagues
                    </div>
                    <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                        <a href="<?php echo base_url('my-leagues'); ?>">view all <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="scroll-area-lg">
                    <div class="scrollbar-container ps ps--active-y">
                        <div>
                            <ul class="todo-list-wrapper list-group list-group-flush">
                                <?php foreach($my_megapool_list as $list){ ?>
                                    <li class="list-group-item">
                                        <div class="todo-indicator bg-warning"></div>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-2">
                                                    <img width=30 height=30 src="<?php echo base_url('assets/uploads/megapool_logo/'.$list['league_logo']) ?>" class="img-thumbnail">
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">
                                                        <?php echo $list['mega_pool_title']; ?>
                                                    </div>
                                                    <div class="widget-subheading"><span class="text-info"><?php echo $list['sport_title']; ?></span></div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <a href="<?php echo  base_url('megapool/'.$list['mega_pool_url']); ?>">
                                                        <div class="badge badge-success">View</div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    
    <?php if($invitation_list){ ?>
        <div class="col-sm-12 col-lg-12">
            <div class="card-hover-shadow-2x mb-3 card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-cog icon-gradient bg-malibu-beach"> </i>My Invitations
                    </div>
                    <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                        <a href="<?php echo base_url('invitations'); ?>">view all <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="scroll-area-lg">
                    <div class="scrollbar-container ps ps--active-y">
                        <div>
                            <ul class="todo-list-wrapper list-group list-group-flush">
                                <?php foreach($invitation_list as $list){ ?>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left">
                                                    <div class="widget-heading"> 
                                                        <span class="text-info"><?php echo $list['full_name']; ?></span> invited you for megapool - <span class="text-success"><?php echo $list['mega_pool_title']; ?></span>
                                                    </div>
                                                    <div><small>Invited on <?php echo @date('Y-m-d', strtotime($list['created_date'])); ?></small></div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="widget-content-left">
                                                                <span>Sport - </span> <span class="text-warning"><?php echo $list['sport_title']; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-right">
                                                    <button data-url="<?php echo $list['mega_pool_url']; ?>" class="mb-2 mr-2 btn-icon btn-pill btn btn-outline-success accept-invitation"><i class="ion-android-done-all btn-icon-wrapper"> </i>Accept</button>
                                                    <button data-url="<?php echo $list['mega_pool_url']; ?>" class="mb-2 mr-2 btn-icon btn-pill btn btn-outline-danger reject-invitation"><i class="ion-android-close btn-icon-wrapper"> </i>Reject</button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php }else{ ?>
        <div class="col-sm-12 col-lg-12 mb-4">
            <div class="main-card card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-cog icon-gradient bg-malibu-beach"> </i>My Invitations
                    </div>
                    <div class="btn-actions-pane-right text-capitalize actions-icon-btn">
                        <a href="<?php echo base_url('invitations'); ?>">view all <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning fade show" role="alert" style="margin-bottom: 0px !important;">
                        <span class="alert-link">You are all done now.</span> no more invitation!
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
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

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="<?php echo base_url('assets/front_end/js/player/view_standing_table.js'); ?>" ></script>
<script src="<?php echo base_url('assets/front_end/js/player/invite_action.js'); ?>" ></script>