<div class="row">
	<div class="col-lg-12">
		<div class="">
			<div class="card-header-tab card-header">
				<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
					<i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>My Invitations
				</div>
			</div>
			<?php if($invitation_list){ ?>
				<ul class="todo-list-wrapper list-group list-group-flush">
					<?php foreach($invitation_list as $list){ ?>
						<li class="list-group-item main-card mt-2 card">
							<div class="no-gutters row">
								<div class="col-md-4 col-xl-4">
									<div class="widget-content">
										<div class="widget-content-wrapper">
											<div class="widget-content-right ml-0 mr-3">
												
											</div>
											<div class="widget-content-left">
												<div class="widget-heading text-success">
													<?php echo $list['mega_pool_title']; ?>
												</div>
												<div class="widget-subheading">
													<?php
														if($list['invitation_accepted'] == 1){
															$status_class="success";
															$status_text = "Accepted";
														}elseif($list['invitation_accepted'] == 2){
															$status_class="warning";
															$status_text = "Rejected";
														}elseif($list['invitation_accepted'] == 3){
															$status_class="danger";
															$status_text = "Pending";
														}
													?>
													<div class="badge badge-<?php echo $status_class; ?>"><?php echo $status_text; ?></div>
												</div>
												<div>
													<span>Sent on <?php echo @date('Y-m-d', strtotime($list['created_date'])); ?></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-md-4 col-xl-4">
									<div class="widget-content">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-right ml-0 mr-3">
                                                <div class="widget-numbers text-warning">Email</div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-subheading"><?php echo $list['to_email']; ?></div>
                                            </div>
                                        </div>
                                    </div>
								</div>
							</div>
						</li>
					<?php } ?>
				</ul>
			<?php }else{ ?>
			<div class="row">
				<div class="col-md-12">
					<br/>
					<div class="alert alert-danger fade show" role="alert">
						<div>
							<strong>Error</strong>
							<div class="page-title-subheading">Nothing to display!</div>
						</div>
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