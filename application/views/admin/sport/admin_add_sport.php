<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<h5 class="card-title">Add sport information <small class="form-text text-danger">All fields are mandatory</small></h5>
				
				<form id="update-profile" action="<?php echo base_url('admin-save-sport'); ?>" method="post" enctype="multipart/form-data">
					<div class="position-relative form-group">
						<label for="sport_title" class="">Sport Name</label>
						<input name="sport_title" id="sport_title" placeholder="Sport name" type="text" class="form-control" required="required" autocomlete="off">
					</div>
					<div class="position-relative form-group">
						<label for="sport_description" class="">Write something about the sport</label>
						<textarea name="sport_description" id="sport_description" class="form-control" required="required" rows=5 style="font-size: 14px;"></textarea>
					</div>
					<div class="position-relative form-group">
						<label for="sport_logo" class="">Sport Logo</label>
						<input name="sport_logo" id="sport_logo" type="file" class="form-control-file" accept="image/*">
						<small class="form-text text-info">This logo will be used in front-end. Plesase maintain the size 200x200</small>
					</div>
					<button class="mt-1 btn btn-primary" type="submit">Add Sport</button>
					<a href="<?php echo  base_url('admin-sport-management'); ?>">
						<button class="mt-1 btn btn-outline-dark ml-3" type="button">Cancel</button>
					</a>
				</form>
				
				<?php
					if($this->session->flashdata('sport_item')) {
						$message = $this->session->flashdata('sport_item');
				?>
					<br/>
					<div class="alert alert-<?php echo $message['class']; ?> fade show mt-10" role="alert">
						<div>
							<strong>Notifications</strong>
							<div class="page-title-subheading"><?php echo $message['message']; ?></div>
						</div>
					</div>
				<?php 
					}
				?>
			</div>
		</div>
	</div>
</div>