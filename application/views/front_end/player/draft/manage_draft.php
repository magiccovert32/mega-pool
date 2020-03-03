
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<div class="row">
	
	<div class="col-lg-12">
		<div class="card-header-tab card-header">
			<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
				<i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>My Drafts
			</div>
		</div>
		<?php if($draft_list){ ?>
			<?php foreach($draft_list as $list){ ?>
				<div class="card mt-2">
					<div class="no-gutters row">
						<div class="col-md-12 col-lg-3">
							<ul class="list-group list-group-flush">
								<li class="bg-transparent list-group-item">
									<div class="widget-content p-0">
										<div class="widget-content-outer">
											<div class="widget-content-wrapper">
												<div class="widget-content-left">
													<div class="widget-heading">#draft</div>
													<div class="widget-subheading text-info"><span><?php echo $list['draft_title']; ?></span></div>
													<div>League: <span class="text-warning"><?php echo $list['league_title']; ?></span></div>
												</div>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</div>
						
						<div class="col-md-12 col-lg-3">
							<ul class="list-group list-group-flush">
								<li class="bg-transparent list-group-item">
									<div class="widget-content p-0">
										<div class="widget-content-outer">
											<div class="widget-content-wrapper">
												<div class="widget-content-left">
													<div class="widget-heading text-success">Starting Date</div>
													<div class="widget-subheading text-dark"><span><?php echo @date('d-m-Y H:i:s', strtotime($list['team_selection_ends_on'])); ?></span></div>
												</div>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</div>
						
						<div class="col-md-12 col-lg-4">
							<ul class="list-group list-group-flush">
								<li class="bg-transparent list-group-item">
									<div class="widget-content p-0">
										<div class="widget-content-outer">
											<div class="widget-content-wrapper">
												<?php
													$countDownDate 	= new DateTime(@date('Y-m-d H:i:s', strtotime($list['team_selection_ends_on'])));
													$now 			= new DateTime();
													
													if($countDownDate > $now){
												?>
													<div class="widget-content-left">
														<div class="widget-heading">Expiry</div>
														<div class="widget-subheading text-danger"><strong><?php echo @date('d-m-Y H:i:s', strtotime($list['team_selection_ends_on'])); ?></strong></div>
													</div>
												<?php }else{ ?>
													<div class="widget-content-left">
														<div class="widget-heading text-info">Selected Team</div>
														<?php if($list['team_title']){ ?>
															<div class="widget-subheading text-dark"><span><?php echo $list['team_title']; ?></span></div>
														<?php }else{ ?>
															<div class="widget-subheading text-danger"><span>Nothing Selected</span></div>
														<?php } ?>
													</div>
												<?php } ?>
												<div class="widget-content-right">
													<?php
														$countDownDate 	= new DateTime(@date('Y-m-d H:i:s', strtotime($list['team_selection_ends_on'])));
														$now 			= new DateTime();
														
														if($countDownDate > $now){
													?>
														<div class="widget-numbers text-success">Active</div>
													<?php }else{ ?>
														<div class="widget-numbers text-danger">Expired</div>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div class="col-md-12 col-lg-2">
							<ul class="list-group list-group-flush">
								<li class="bg-transparent list-group-item text-right">
									<div class="widget-content-right" style="margin-top: 10px;">
										<a href="<?php echo base_url().'draft/'.$list['draft_url']; ?>">
											<button class="mb-2 mr-2 btn-icon btn-pill btn btn-outline-warning"><i class="pe-7s-rocket btn-icon-wrapper"> </i>View Draft</button>
										</a>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			<?php } ?>
		<?php }else{ ?>
			<div class="">
				<br/>
				<div class="alert alert-danger fade show" role="alert">
					<div>
						<strong>Error</strong>
						<div class="page-title-subheading">Nothing to display! Seems, there is no draft yet.</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<br/>
		<?php if (isset($links)) { ?>
			<?php echo $links ?>
		<?php } ?>
	</div>
</div>