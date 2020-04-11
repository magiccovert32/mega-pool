
<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3">
			<div class="card-body">
				
				<?php if($league_details){ ?>
					<div class="main-card mb-3 card">
						<div class="card-header-tab card-header">
							<div class="card-header-title font-size-lg text-capitalize font-weight-normal">
								Megapool Information
							</div>
						</div>	
						<div class="no-gutters row">
							<div class="col-md-6 col-xl-4">
								<div class="widget-content">
									<div class="widget-content-wrapper">
										<div class="widget-content-right ml-0 mr-3">
											<div class="widget-numbers text-success">
												<img width=60 height=60 class="img-thumbnail" src="<?php echo base_url('assets/uploads/megapool_logo/'.$league_details['league_logo']) ?>">
											</div>
										</div>
										<div class="widget-content-left">
											<div class="widget-heading">Megapool Name</div>
											<div class="widget-subheading"><?php echo $league_details['mega_pool_title']; ?></div>
										</div>
									</div>
								</div>
							</div>
							<!--<div class="col-md-6 col-xl-4">
								<div class="widget-content">
									<div class="widget-content-wrapper">
										<div class="widget-content-right ml-0 mr-3">
											<div class="widget-numbers text-success">$ <?php echo $league_details['entry_fee']; ?></div>
										</div>
										<div class="widget-content-left">
											<div class="widget-heading">Entry Fee (USD)</div>
											<div class="widget-subheading">Players to pay</div>
										</div>
									</div>
								</div>
							</div>-->
							<div class="col-md-6 col-xl-4">
								<div class="widget-content">
									<div class="widget-content-wrapper">
										<div class="widget-content-right ml-0 mr-3">
											<div class="widget-numbers text-danger"><?php echo $player_league; ?></div>
										</div>
										<div class="widget-content-left">
											<div class="widget-heading">Player(s)</div>
											<div class="widget-subheading">Joined the Megapool</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<div class="card-header-title font-size-lg text-capitalize font-weight-normal mb-3">
								Selected Sports
							</div>
						</div>
						<?php if($sport_list){ foreach($sport_list as $sport){ ?>
							<div class="col-md-6 col-xl-4">
								<div class="card mb-3 widget-content bg-night-fade">
									<div class="widget-content-wrapper text-white">
										<div class="widget-content-left">
											<div class="widget-subheading"><?php echo $sport['sport_title']; ?></div>
										</div>
									</div>
								</div>
							</div>
						<?php }} ?>
					</div>

					<div class="position-relative form-group">
						<div class="card-header-title font-size-lg text-capitalize font-weight-normal mb-3">
							Selected Leagues
						</div>
						<div class="row">
							<div class="col-sm-12" style="max-height: 400px; overflow-y: auto;">
								<ul class="todo-list-wrapper list-group list-group-flush" id="league-list">
									<?php if($selected_league){ ?>
										<?php foreach($selected_league as $league){ ?>
											<li class="list-group-item">
												<div class="todo-indicator bg-warning"></div>
												<div class="widget-content p-0">
													<div class="widget-content-wrapper">
														<div class="widget-content-left mr-3">
															<div class="widget-content-left">
																<img width="42" class="rounded" src="<?php echo base_url(); ?>assets/uploads/league_logo/<?php echo $league['league_logo']; ?>" alt="">
															</div>
														</div>
														<div class="widget-content-left">
															<div class="text-dark"><?php echo $league['league_title'] ?></div>
														</div>
													</div>
												</div>
											</li>
										<?php } ?>
									<?php }else{ ?>
										<li class="list-group-item" style="padding: 0;">
											<div class="alert alert-info fade show mt-10" role="alert">
												<div>
													<div class="page-title-subheading">No league to display! Select any sport to check available leagues.</div>
												</div>
											</div>
										</li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>

					<a href="<?php echo  base_url('my-megapool'); ?>">
						<button class="mt-1 btn btn-outline-dark" type="button">Back to megapool</button>
					</a>
				<?php }else{ ?>
					<div class="row">
						<div class="col-sm-12">
							<div class="alert alert-info fade show mt-10" role="alert">
									<div>
										<div class="page-title-subheading">Nothing to display! Please check if you have permission to view the URL.</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<style>
	.ms-choice{
		border: 0px !important;
		line-height: 32px !important;
	}
	
	.multi-select-form-control{
		display: block;
		width: 100%;
		height: calc(2.25rem + 2px);
		font-size: 1rem;
		font-weight: 400;
		line-height: 1.5;
		color: #495057;
		background-color: #fff;
		background-clip: padding-box;
		border: 1px solid #ced4da;
		border-radius: .25rem;
		transition: border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out;
		padding-top: 10px;
	}
</style>

<script>
	$('select').multipleSelect();
</script>


<script src="<?php echo base_url('assets/front_end/js/commissioner/edit_megapool.js'); ?>" ></script>