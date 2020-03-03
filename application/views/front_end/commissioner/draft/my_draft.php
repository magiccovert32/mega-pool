<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.8/flipclock.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.8/flipclock.min.css">

<div class="row">
	<div class="col-lg-12">
		<div class="main-card mb-3">
			<div class="card-header-tab card-header">
				<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
					<i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>My Drafts
				</div>
			</div>
			<?php if($draft_list){ ?>
				<?php foreach($draft_list as $key => $list){ ?>
						<?php
							$timeFirst  = strtotime(@date('Y-m-d h:i:s'));
							$timeSecond = strtotime(@date('Y-m-d h:i:s',strtotime($list['team_selection_ends_on'])));
							$differenceInSeconds = $timeSecond - $timeFirst;
						?>
						<div class="main-card mb-2 card mt-2" id="draft-<?php echo $list['draft_url']; ?>">
							<div class="widget-content">
								<div class="widget-content-wrapper">
									<div class="col-md-4 col-xl-4">
										<div class="widget-content-left">
											<div class="widget-heading">
												<?php echo $list['draft_title']; ?>
												<?php
													if($list['draft_status'] == 1){
														$status_class="success";
														$status_text = "Active";
													}elseif($list['draft_status'] == 2){
														$status_class="warning";
														$status_text = "In-active";
													}elseif($list['draft_status'] == 3){
														$status_class="danger";
														$status_text = "Removed";
													}elseif($list['draft_status'] == 4){
														$status_class="warning";
														$status_text = "Published";
													}
												?>
												<div class="badge badge-<?php echo $status_class; ?> ml-2"><?php echo $status_text; ?></div>
											</div>
										</div>

										<div>Created on <?php echo @date('d-m-Y', strtotime($list['created_on'])); ?></div>
									</div>
									
									<div class="col-md-4 col-xl-4">
										<div class="widget-content-left">
											<div class="widget-heading text-success">
												Starting Date
											</div>
										</div>

										<div><?php echo @date('d-m-Y h:i:s', strtotime($list['team_selection_ends_on'])); ?></div>
									</div>
									
									<div class="col-md-4 col-xl-4">
										<ul class="list-group list-group-flush">
											<li class="bg-transparent list-group-item">
												<div class="widget-content p-0">
													<div class="widget-content-outer">
														<div class="widget-content-wrapper">
															<div class="widget-content-left">
																<div class="widget-heading">Team Selection</div>
																<div class="widget-subheading text-danger">
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
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-xl-12 card-footer">
								<div class="widget-content-right ml-0 mt-3">
									<?php if($list['draft_status'] != 4){ ?>
										<a href="#" onclick="publish('<?php echo $list['draft_url']; ?>')">
											<button class="mr-3 mb-3 btn-icon btn-pill btn btn-outline-warning">Publish Now</button>
										</a>
										
										<a href="<?php echo  base_url('edit-draft/'.$list['draft_url']); ?>">
											<button class="mr-3 mb-3 btn-icon btn-pill btn btn-outline-success"><i class="pe-7s-tools btn-icon-wrapper"> </i>Edit</button>
										</a>
										
										<a href="#" onclick="removeDraft('<?php echo $list['draft_url']; ?>')">
											<button class="mr-3 mb-3 btn-icon btn-pill btn btn-outline-danger"><i class="pe-7s-trash btn-icon-wrapper"> </i>Remove</button>
										</a>
									<?php }else{ ?>
										<?php
											$countDownDate 	= new DateTime(@date('Y-m-d H:i:s', strtotime($list['team_selection_ends_on'])));
											$now 			= new DateTime();
											
											if($countDownDate > $now){
										?>
											<a href="<?php echo  base_url('add-player/'.$list['draft_url']); ?>">
												<button class="mr-3 mb-3 btn-icon btn-pill btn btn-outline-warning"><i class="pe-7s-notes btn-icon-wrapper"> </i>Add Player</button>
											</a>
										<?php } ?>
									<?php } ?>
									<a href="<?php echo  base_url('view-draft/'.$list['draft_url']); ?>">
										<button class="mr-3 mb-3 btn-icon btn-pill btn btn-outline-info"><i class="pe-7s-notes btn-icon-wrapper"> </i>View Draft</button>
									</a>
								</div>
							</div>
						</div>
					<?php } ?>
			<?php }else{ ?>
				<div class="col-md-12">
					<br/>
					<div class="alert alert-danger fade show" role="alert">
						<div>
							<strong>Error</strong>
							<div class="page-title-subheading">Nothing to display! Seems, there are no Draft created yet.</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<?php if (isset($links)) { ?>
			<?php echo $links ?>
		<?php } ?>
	</div>
</div>

<script src="<?php echo base_url('assets/front_end/js/commissioner/my_draft.js'); ?>" ></script>