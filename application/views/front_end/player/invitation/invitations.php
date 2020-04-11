
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<div class="row">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
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
										<!--<div class="row">
											<div class="col-sm-12">
												<span class="widget-numbers text-success">Entry $<?php echo $list['entry_fee']; ?></span>
											</div>
										</div>-->
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
				<div class="col-md-12">
					<br/>
					<div class="alert alert-danger fade show" role="alert">
						<div>
							<strong>Oops</strong>
							<div class="page-title-subheading">Nothing to display! Seems, there is no invitation.</div>
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

<script src="<?php echo base_url('assets/front_end/js/player/invite_action.js'); ?>" ></script>