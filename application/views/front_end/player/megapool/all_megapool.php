
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
		<div class="main-card mb-3 card">
			<?php if($megapool_list){ ?>
				<ul class="todo-list-wrapper list-group list-group-flush">
					<?php foreach($megapool_list as $list){ ?>
						<li class="list-group-item">
							<div class="widget-content p-0">
								<div class="widget-content-wrapper">
									<div class="widget-content-left mr-4">
										<img width=50 height=50 src="<?php echo base_url('assets/uploads/megapool_logo/'.$list['league_logo']) ?>" class="img-thumbnail">
									</div>
									<div class="widget-content-left">
										<div class="widget-heading"> 
											<?php echo $list['mega_pool_title']; ?>
										</div>
										<div><small>Published <?php echo @date('Y-m-d', strtotime($list['published_on'])); ?></small></div>
										<div class="row">
											<div class="col-sm-12">
												<div class="widget-content-left">
													<strong class="text-info"><?php echo $list['sport_title']; ?></strong>
												</div>
											</div>
										</div>
										<!--<div class="row">
											<div class="col-sm-12">
												<div class="widget-numbers text-success">Entry $<?php echo $list['entry_fee']; ?></div>
											</div>
										</div>-->
									</div>
									
									<div class="widget-content-right widget-content-actions">
										<a href="<?php echo  base_url('megapool/'.$list['mega_pool_url']); ?>">
											<button class="mb-2 mr-2 btn-icon btn-pill btn btn-outline-success"><i class="pe-7s-rocket btn-icon-wrapper"> </i>Join League</button>
										</a>
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
							<div class="page-title-subheading">Nothing to display! Seems, there is no transaction yet.</div>
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