
<div class="row">
	<div class="col-lg-12 text-right mb-2">
		<div class="page-title-actions">
			<a href="<?php echo base_url('my-megapool'); ?>">
				<button type="button" data-toggle="tooltip" title="" data-placement="bottom" class="btn-shadow btn btn-success" data-original-title="Back to Megapool">
					<i class="fa fa-angle-left"></i>
				</button>
			</a>
		</div>
	</div>
	<div class="col-lg-12">			
		<?php if($league_details){ ?>
			<div class="card-header-tab card-header">
				<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
					<i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i><?php echo $league_details['mega_pool_title']; ?> - Players
				</div>
			</div>
			
			<?php if($player_list){ ?>
				<ul class="todo-list-wrapper list-group list-group-flush">
					<?php foreach($player_list as $list){ ?>
					
						<li class="list-group-item card mt-2">
							<div class="widget-content p-0">
								<div class="widget-content-wrapper">
									<div class="widget-content-left mr-3">
										<div class="widget-content-left">
											<?php if($list['profile_image'] != ''){ ?>
												<img width=42 src="<?php echo base_url('assets/uploads/profile_image/'.$list['profile_image']) ?>" class="img-thumbnail">
											<?php }else{ ?>
												<img width=42 src="<?php echo base_url('assets/images/user.png') ?>" class="img-thumbnail">
											<?php } ?>
										</div>
									</div>
									<div class="widget-content-left">
										<div class="widget-heading"><?php echo $list['full_name']; ?></div>
										<div>
											<span>Joined on <?php echo @date('Y-m-d', strtotime($list['joined_on'])); ?></span>
										</div>
									</div>
								</div>
							</div>
						</li>
					<?php } ?>
				</ul>
			<?php }else{ ?>
				<div class="alert alert-info fade show mt-3" role="alert">
					<div class="page-title-subheading">No player joined this megapool.</div>
				</div>
			<?php } ?>
		<?php }else{ ?>
			<div class="alert alert-danger fade show" role="alert">
				<div>
					<strong>Error</strong>
					<div class="page-title-subheading">Nothing to display! Access restricted.</div>
				</div>
			</div>
		<?php } ?>
		<br/>
		<?php if (isset($links)) { ?>
			<?php echo $links ?>
		<?php } ?>
	</div>
</div>
