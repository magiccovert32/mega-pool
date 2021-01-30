<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://unpkg.com/multiple-select@1.4.1/dist/multiple-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://unpkg.com/multiple-select@1.4.1/dist/multiple-select.min.js"></script>

<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<h5 class="card-title">Add megapool information <small class="form-text text-danger">All fields are mandatory</small></h5>
				
				<form id="mega-pool-edit-frm" method="post" enctype="multipart/form-data">
					<input type="hidden" name="mega_pool_id" value="<?php echo $league_details['mega_pool_id']; ?>" >
					<input value="<?php echo $league_details['league_logo']; ?>" name="old_league_logo" type="hidden">
					<div class="row">
						<div class="col-sm-12 col-md-4">
							<div class="position-relative form-group">
								<label for="mega_pool_title" class="">Megapool Name</label>
								<input name="mega_pool_title" id="mega_pool_title" value="<?php echo $league_details['mega_pool_title']; ?>" placeholder="League name" type="text" class="form-control" required="required" autocomlete="off">
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12 col-md-6">
							<div class="position-relative form-group">
								<label for="sport_id" class="">Select Sport</label>
								<select name="sport_id[]" id="sport_id" class="multi-select-form-control" multiple="multiple">
									<?php if($sport_list){ foreach($sport_list as $sport){ ?>
										<option value="<?php echo $sport['sport_id']; ?>" <?php if(in_array($sport['sport_id'],$sportId)){ echo "selected"; } ?>><?php echo $sport['sport_title']; ?></option>
									<?php }} ?>
								</select>
								<div>
									<p class="text-danger">You need to select at least 1 league.</p>
								</div>
							</div>
						</div>
					</div>
					
					<?php 
							$selectedLeagues = array();

							if($selected_league){
								foreach($selected_league as $league){
									$selectedLeagues[] = $league['league_id'];
								}
							}
						?>
						
						
					<div class="position-relative form-group">
						<label for="mega_pool_title" class="">Select Leagues</label>
						<div class="row">
							<div class="col-sm-12" style="max-height: 400px; overflow-y: auto;">
								<ul class="todo-list-wrapper list-group list-group-flush" id="league-list">
									<?php if($league_list){ ?>
										<?php foreach($league_list as $league){ ?>
											<li class="list-group-item">
												<div class="todo-indicator bg-warning"></div>
												<div class="widget-content p-0">
													<div class="widget-content-wrapper">
														<div class="widget-content-left mr-2">
															<div class="custom-checkbox custom-control">
																<input type="checkbox" id="exampleCustomCheckbox<?php echo $league['league_id']; ?>" <?php if(in_array($league['league_id'],$selectedLeagues)){ echo "checked"; } ?> value="<?php echo $league['league_id']; ?>" name="selected_league[]" class="custom-control-input"><label class="custom-control-label" for="exampleCustomCheckbox<?php echo $league['league_id']; ?>">&nbsp;</label>
															</div>
														</div>
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

					<div class="row">
						<div class="col-sm-12 col-md-12">
							<div class="position-relative form-group">
								<img width=200 height=200 class="img-thumbnail" src="<?php echo base_url('assets/uploads/megapool_template/'.$league_details['league_logo']) ?>">
							</div>

							<div class="position-relative form-group">
								<label for="league_logo" class="">Megapool Logo</label>
								<input name="league_logo" id="league_logo" type="file" class="form-control-file" accept="image/*">
								<small class="form-text text-info">This logo will be used in front-end. Plesase maintain the size 200x200</small>
							</div>
						</div>
					</div>
				
					<button class="mt-1 btn btn-primary" id="edit-mega-pool" type="button">Save Changes</button>
					<a href="<?php echo  base_url('megapool-template'); ?>">
						<button class="mt-1 btn btn-outline-dark ml-3" type="button">Cancel</button>
					</a>
				</form>
				
				<br/>
				<div class="alert alert-danger fade show mt-10 display_none" role="alert" id="error-msg">
					<strong>Correct the following error(s)</strong>
					<div class="alert_message">
					
					</div>
				</div>
				<div class="alert alert-success fade show mt-10 display_none" role="alert" id="success-msg">
					<strong>Success</strong>
					<div class="alert_message">
					
					</div>
				</div>
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

<script src="<?php echo base_url('assets/front_end/js/admin/edit_megapool.js'); ?>" ></script>