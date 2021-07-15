<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://unpkg.com/multiple-select@1.4.1/dist/multiple-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://unpkg.com/multiple-select@1.4.1/dist/multiple-select.min.js"></script>

<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<h5 class="card-title">Edit draft information <small class="form-text text-danger">All fields are mandatory</small></h5>
				
				<form id="draft-edit-frm" method="post" enctype="multipart/form-data">
					<input type="hidden" name="draft_id" value="<?php echo $draft_details['draft_id']; ?>" >
					<div class="row">
						<div class="col-sm-12 col-md-4">
							<div class="position-relative form-group">
								<label for="team_selection_ends_on" class="">End Date</label>
								<input name="team_selection_ends_on" id="team_selection_ends_on" value="<?php echo @date('Y-m-d', strtotime($draft_details['team_selection_ends_on'])); ?>" placeholder="Selection Date" type="date" class="form-control" required="required" autocomlete="off">
							</div>
						</div>
					</div>
				
					<button class="mt-1 btn btn-primary" id="edit-draft" type="button">Save Changes</button>
					<a href="<?php echo  base_url('admin-megapool-draft'); ?>">
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

<script src="<?php echo base_url('assets/front_end/js/admin/edit_draft.js'); ?>" ></script>