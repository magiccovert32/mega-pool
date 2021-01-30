
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<div class="row">
	<div class="col-lg-12">
		<div class="card-header-tab card-header">
			<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
				<i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>Received Invitations
			</div>
		</div>
		
		<div class="main-card mb-3">
			<?php if($invitation_list){ ?>
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
									<div class="widget-content-right widget-content-actions">
										<button data-url="<?php echo $list['mega_pool_url']; ?>" class="mb-2 mr-2 btn-icon btn-pill btn btn-outline-success accept-invitation"><i class="ion-android-done-all btn-icon-wrapper"> </i>Accept</button>
										<button data-url="<?php echo $list['mega_pool_url']; ?>" class="mb-2 mr-2 btn-icon btn-pill btn btn-outline-danger reject-invitation"><i class="ion-android-close btn-icon-wrapper"> </i>Reject</button>
									</div>
								</div>
							</div>
						</li>
					<?php } ?>
				</ul>
			<?php }else{ ?>
				<br/>
				<div class="alert alert-danger fade show" role="alert">
					<div>
						<strong>Oops</strong>
						<div class="page-title-subheading">Nothing to display! Seems, there is no invitation.</div>
					</div>
				</div>
			<?php } ?>
		</div>
		
		<?php if (isset($links)) { ?>
			<?php echo $links ?>
		<?php } ?>
	</div>
</div>

<script src="<?php echo base_url('assets/front_end/js/player/invite_action.js'); ?>" ></script>