
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<div class="row">
	<div class="col-lg-12 text-right mb-2">
		<div class="page-title-actions">
			<a href="<?php echo  base_url('my-dashboard'); ?>">
				<button type="button" data-toggle="tooltip" title="" data-placement="bottom" class="btn-shadow btn btn-success" data-original-title="Back">
					<i class="pe-7s-angle-left-circle"></i>
				</button>
			</a>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="card-header-tab card-header">
			<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
				<i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>My Leagues
			</div>
		</div>
		
		
			<?php if($megapool_list){ ?>
			<div class="main-card mb-3">
				<?php foreach($megapool_list as $list){ ?>
					<li class="main-card mb-2 card mt-2">
						<div class="widget-content">
							<div class="widget-content-wrapper">
								<div class="widget-content-left mr-4">
									<img width=50 height=50 src="<?php echo base_url('assets/uploads/megapool_logo/'.$list['league_logo']) ?>" class="img-thumbnail">
								</div>
								<div class="widget-content-left">
									<div class="widget-heading"> 
										<?php echo $list['mega_pool_title']; ?>
									</div>
									<div><span>Joined on <?php echo @date('Y-m-d', strtotime($list['joined_on'])); ?></span></div>
									<div class="row">
										<div class="col-sm-12">
											<div class="widget-content-left">
												<strong class="text-info"><?php echo $list['sport_title']; ?></strong>
											</div>
										</div>
									</div>
								</div>
								
								<div class="widget-content-right widget-content-actions">
									<a href="<?php echo  base_url('megapool/'.$list['mega_pool_url']); ?>">
										<button class="mb-2 mr-2 btn-icon btn-pill btn btn-outline-success"><i class="pe-7s-rocket btn-icon-wrapper"> </i>View League</button>
									</a>
								</div>
							</div>
						</div>
					</li>
				<?php } ?>
				</div>
			<?php }else{ ?>
				<br/>
				<div class="alert alert-danger fade show" role="alert">
					<div>
						<strong>Error</strong>
						<div class="page-title-subheading">Nothing to display! Seems, there is no transaction yet.</div>
					</div>
				</div>
			<?php } ?>
		
		
		
		
				
		<?php if (isset($links)) { ?>
			<?php echo $links ?>
		<?php } ?>
	</div>
</div>