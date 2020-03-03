
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<div class="row">
	<div class="col-lg-12 text-right mb-2">
		<div class="page-title-actions">
			<a href="<?php echo  base_url('create-megapool'); ?>">
				<button type="button" data-toggle="tooltip" title="" data-placement="bottom" class="btn-shadow btn btn-success" data-original-title="Create Megapool">
					<i class="fa fa-plus"></i>
				</button>
			</a>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="">
			<div class="card-header-tab card-header">
				<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
					<i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>My Mega Pool Leagues
				</div>
			</div>
			<?php if($league_list){ ?>
				<ul class="todo-list-wrapper list-group list-group-flush">
					<?php foreach($league_list as $list){ ?>
						<li class="list-group-item main-card mt-2 card">
							<div class="no-gutters row">
								<div class="col-md-4 col-xl-4">
									<div class="widget-content">
										<div class="widget-content-wrapper">
											<div class="widget-content-right ml-0 mr-3">
												<div class="widget-numbers text-success">
													<img width=50 height=50 src="<?php echo base_url('assets/uploads/megapool_logo/'.$list['league_logo']) ?>" class="img-thumbnail">
												</div>
											</div>
											<div class="widget-content-left">
												<div class="widget-heading text-success">
													<?php echo $list['mega_pool_title']; ?>
												</div>
												<div class="widget-subheading">
													<?php
														if($list['current_status'] == 1){
															$status_class="success";
															$status_text = "Active";
														}elseif($list['current_status'] == 2){
															$status_class="warning";
															$status_text = "In-active";
														}elseif($list['current_status'] == 3){
															$status_class="danger";
															$status_text = "Removed";
														}elseif($list['current_status'] == 4){
															$status_class="success";
															$status_text = "Published";
														}
													?>
													<div class="badge badge-<?php echo $status_class; ?>"><?php echo $status_text; ?></div>
												</div>
												<div>
													<span>Created on <?php echo @date('Y-m-d', strtotime($list['created_on'])); ?></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-4 col-xl-4">
									<div class="widget-content">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-right ml-0 mr-3">
                                                <div class="widget-numbers text-warning">$ <?php echo $list['entry_fee']; ?></div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Entry Fee</div>
                                                <div class="widget-subheading">applicable to Players</div>
                                            </div>
                                        </div>
                                    </div>
								</div>
								
								<div class="col-md-4 col-xl-4">
									<div class="widget-content">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-right ml-0 mr-3">
                                                <div class="widget-numbers text-warning"><?php echo $list['player_count']; ?></div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Player Count</div>
                                                <div class="widget-subheading">Joined this megapool</div>
												<a href="<?php echo base_url('megapool-players/'.$list['mega_pool_url']); ?>" class="text-info">
													<div class="widget-heading"> View Players </div>
												</a>
                                            </div>
                                        </div>
                                    </div>
								</div>
				
								<div class="col-md-12 col-xl-12 card-footer">
                                    <div class="widget-content">
                                        <div class="widget-content-wrapper page-title-actions">
											<?php if($list['current_status'] != 4){ ?>
												<div class="widget-content-right ml-0 mr-3">
													<div class="widget-content-left ml-0" onclick="publish('<?php echo $list['mega_pool_url']; ?>')">
														<div class=" btn-pill btn btn-outline-warning">Publish Now</div>
													</div>
												</div>
												
												<div class="widget-content-right ml-0 mr-3">
													<a href="<?php echo  base_url('edit-megapool/'.$list['mega_pool_url']); ?>">
														<div class="widget-content-left ml-0">
															<div class="btn-pill btn btn-outline-success">
																<i class="pe-7s-tools btn-icon-wrapper"> </i> Edit
															</div>
														</div>
													</a>
												</div>
												
												<div class="widget-content-left ml-0 mr-3">
													<a href="#" onclick="removeLeague('<?php echo $list['mega_pool_url']; ?>')">
														<div class="widget-content-left ml-0">
															<div class="btn-pill btn btn-danger">
																<i class="pe-7s-trash btn-icon-wrapper"> </i> Remove
															</div>
														</div>
													</a>
												</div>
											<?php }else{ ?>
												<div class="widget-content-right ml-0 mr-3">
													<a href="<?php echo  base_url('invite-player/'.$list['mega_pool_url']); ?>">
														<div class="btn-pill btn btn-outline-info">
															<i class="pe-7s-mail-open btn-icon-wrapper"> </i> Invite Players
														</div>
													</a>
												</div>
												
												<div class="widget-content-left ml-0 mr-3">
													<a href="<?php echo  base_url('create-draft/'.$list['mega_pool_url']); ?>">
														<div class="btn-pill btn btn-outline-danger">
															<i class="pe-7s-link btn-icon-wrapper"> </i> Create Draft
														</div>
													</a>
												</div>												
											<?php } ?>
											<div class="widget-content-right ml-0 mr-3">
												<a href="<?php echo  base_url('view-megapool/'.$list['mega_pool_url']); ?>">
													<div class="btn-pill btn btn-outline-success">
														<i class="pe-7s-news-paper btn-icon-wrapper"> </i> View Pool
													</div>
												</a>
											</div>
                                        </div>
                                    </div>
                                </div>
							</div>
						</li>
					<?php } ?>
				</ul>
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
		<br/>
		<?php if (isset($links)) { ?>
			<?php echo $links ?>
		<?php } ?>
	</div>
</div>

<script src="<?php echo base_url('assets/front_end/js/commissioner/my_megapool.js'); ?>" ></script>