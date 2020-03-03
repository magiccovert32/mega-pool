<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://unpkg.com/multiple-select@1.4.1/dist/multiple-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://unpkg.com/multiple-select@1.4.1/dist/multiple-select.min.js"></script>

<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<h5 class="card-title">Add megapool information <small class="form-text text-danger">All fields are mandatory</small></h5>
				
				<form id="mega-pool-create-frm" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-sm-12 col-md-4">
							<div class="position-relative form-group">
								<label for="mega_pool_title" class="">Megapool Name</label>
								<input name="mega_pool_title" id="mega_pool_title" placeholder="League name" type="text" class="form-control" required="required" autocomlete="off">
							</div>
						</div>
						<div class="col-sm-12 col-md-4">
							<div class="position-relative form-group">
								<label for="entry_fee" class="">Entry Fee (USD)</label>
								<input name="entry_fee" id="entry_fee" placeholder="Enter entry fee" type="text" class="form-control" required="required" autocomlete="off">
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12 col-md-6">
							<div class="position-relative form-group">
								<div>
									<label for="sport_id" class="">Select Sport</label>
								</div>
								
								<select name="sport_id[]" id="sport_id" class="multi-select-form-control" multiple="multiple" style="padding-left: 5px !important;">
									<?php if($sport_list){ foreach($sport_list as $sport){ ?>
										<option value="<?php echo $sport['sport_id']; ?>"><?php echo $sport['sport_title']; ?></option>
									<?php }} ?>
								</select>
								<div>
									<p class="text-danger">You need to select at least 1 league.</p>
								</div>
							</div>
						</div>
					</div>
					
					<div class="position-relative form-group">
						<label for="mega_pool_title" class="">Select Leagues</label>
						<div class="row">
							<div class="col-sm-12" style="max-height: 400px; overflow-y: auto;">
								<ul class="todo-list-wrapper list-group list-group-flush" id="league-list">
									<li class="list-group-item" style="padding: 0;">
										<div class="alert alert-info fade show mt-10" role="alert">
											<div>
												<div class="page-title-subheading">No league to display! Select any sport to check available leagues.</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12 col-md-6">
							<div class="position-relative form-group">
								<label for="league_logo" class="">Megapool Logo</label>
								<input name="league_logo" id="league_logo" type="file" class="form-control-file" accept="image/*">
								<small class="form-text text-info">This logo will be used in front-end. Plesase maintain the size 200x200</small>
							</div>
						</div>
					</div>
					<button class="mt-1 btn btn-primary" id="create-mega-pool" type="button">Create Mega Pool</button>
					<a href="<?php echo  base_url('my-megapool'); ?>">
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

<script src="<?php echo base_url('assets/front_end/js/commissioner/create_megapool.js'); ?>" ></script>