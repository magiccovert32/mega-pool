<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="http://t00rk.github.io/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" />
<script type="text/javascript" src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script type="text/javascript" src="http://t00rk.github.io/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<?php if($league_details && $draft_details){ ?>
					<h5 class="card-title">Edit draft information <small class="form-text text-danger">All fields are mandatory</small></h5>
					
					<form id="draft-update-frm" method="post">
						<input type="hidden" value="<?php echo $draft_details['draft_url']; ?>" name="draft_url">
						<div class="row">
							<div class="col-sm-12 col-md-4">
								<div class="position-relative form-group">
									<label for="team_selection_ends_on" class="">Draft Title</label>
									<input name="draft_title" value="<?php echo $draft_details['draft_title']; ?>" id="draft_title" placeholder="Enter title" type="text" class="form-control" required="required" autocomlete="off">
								</div>
							</div>
							<div class="col-sm-12 col-md-4">
								<div class="position-relative form-group">
									<div>
										<label for="sport_id" class="">Select League</label>
									</div>
									<select name="league_id" id="league_id" class="form-control" style="padding-left: 5px !important;" readonly>
										<option value="">Choose...</option>
										<?php if($selected_league){ foreach($selected_league as $league){ if($draft_details['league_id'] != $league['league_id']){ continue; }?>
											<option <?php if($draft_details['league_id'] == $league['league_id']){ echo "selected"; } ?> value="<?php echo $league['league_id']; ?>"><?php echo $league['league_title']; ?></option>
										<?php }} ?>
									</select>
								</div>
							</div>
							<div class="col-sm-12 col-md-4">
								<div class="position-relative form-group">
									<label for="team_selection_ends_on" class="">Team Selection Ends On</label>
									<input value="<?php echo $draft_details['team_selection_ends_on']; ?>" name="team_selection_ends_on" id="team_selection_ends_on" placeholder="Enter timeing" type="text" class="datepicker form-control" required="required" autocomlete="off">
								</div>
							</div>
						</div>
						<button class="mt-1 btn btn-primary" id="update-draft" type="button">Update Draft</button>
						<a href="<?php echo  base_url('my-draft'); ?>">
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
				<?php }else{ ?>
					<div class="alert alert-danger fade show">
							<strong>Notification</strong>
							<div class="alert_message">
								You don't have access to view this page.
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
	$('#team_selection_ends_on').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD H:mm',minDate : new Date() });
</script>

<script src="<?php echo base_url('assets/front_end/js/commissioner/edit_draft.js'); ?>" ></script>