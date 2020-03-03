<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<h5 class="card-title">Add team information <small class="form-text text-danger">All fields are mandatory</small></h5>
				
				<form id="update-profile" action="<?php echo base_url('admin-save-team'); ?>" method="post" enctype="multipart/form-data">
					<div class="position-relative form-group">
						<label for="exampleSelect" class="">Select Sport</label>
						<select name="sport_id" id="sport_id" class="form-control">
							<option value="">Choose sport</option>
							<?php if($sport_list){ foreach($sport_list as $sport){ ?>
								<option value="<?php echo $sport['sport_id']; ?>"><?php echo $sport['sport_title']; ?></option>
							<?php }} ?>
						</select>
					</div>
					<div class="position-relative form-group">
						<label for="team_title" class="">Team Name</label>
						<input name="team_title" id="team_title" placeholder="Team name" type="text" class="form-control" required="required" autocomlete="off">
					</div>
					<div class="position-relative form-group">
						<label for="team_description" class="">Write something about the team</label>
						<textarea name="team_description" id="team_description" class="form-control" required="required" rows=5 style="font-size: 14px;"></textarea>
					</div>
					<div class="position-relative form-group">
						<label for="team_logo" class="">Team Logo</label>
						<input name="team_logo" id="team_logo" type="file" class="form-control-file" accept="image/*">
						<small class="form-text text-info">This logo will be used in front-end. Plesase maintain the size 200x200</small>
					</div>
					<button class="mt-1 btn btn-primary" type="submit">Add Team</button>
					<a href="<?php echo  base_url('admin-team-management'); ?>">
						<button class="mt-1 btn btn-outline-dark ml-3" type="button">Cancel</button>
					</a>
				</form>
				
				<?php
					if($this->session->flashdata('team_item')) {
						$message = $this->session->flashdata('team_item');
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