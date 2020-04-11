<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<h5 class="card-title">Add page information <small class="form-text text-danger">All fields are mandatory</small></h5>
				
				<form id="update-profile" action="<?php echo base_url('cms/home-page'); ?>" method="post" enctype="multipart/form-data">
					<input value="<?php echo $page_details['banner_image']; ?>" name="old_banner_image" type="hidden">
					<input value="<?php echo $page_details['small_image']; ?>" name="old_small_image" type="hidden">
					
					<div class="position-relative form-group">
						<img style="width: 300px; height: auto;" src="<?php echo base_url('assets/uploads/cms/'.$page_details['banner_image']) ?>">
					</div>
					<div class="position-relative form-group">
						<label for="banner_image" class="">Banner Image</label>
						<input name="banner_image" id="banner_image" type="file" class="form-control-file" accept="image/*">
						<small class="form-text text-info">Image size should be less than 2 MB</small>
					</div>
					<div class="position-relative form-group">
						<label for="page_title" class="">Block Title</label>
						<input name="page_title" id="page_title" placeholder="Page title" type="text" class="form-control" required="required" autocomlete="off" value="<?php echo $page_details['page_title']; ?>">
					</div>
					<div class="position-relative form-group">
						<label for="page_content" class="">Write something Home Page</label>
						<textarea name="page_content" id="page_content" class="form-control" required="required"><?php echo $page_details['page_content']; ?></textarea>
					</div>
					<div class="position-relative form-group">
						<label for="small_content" class="">Small Content</label>
						<textarea name="small_content" id="small_content" class="form-control" required="required"><?php echo $page_details['small_content']; ?></textarea>
					</div>
					<div class="position-relative form-group">
						<img style="width: 300px; height: auto;" src="<?php echo base_url('assets/uploads/cms/'.$page_details['small_image']) ?>">
					</div>
					<div class="position-relative form-group">
						<label for="small_image" class="">Small Image</label>
						<input name="small_image" id="small_image" type="file" class="form-control-file" accept="image/*">
						<small class="form-text text-info">Image size should be less than 2 MB</small>
					</div>
					<button class="mt-1 btn btn-primary" type="submit">Save</button>
					<a href="<?php echo  base_url('cms/home-page'); ?>">
						<button class="mt-1 btn btn-outline-dark ml-3" type="button">Cancel</button>
					</a>
				</form>
				
				<?php
					if($this->session->flashdata('item')) {
						$message = $this->session->flashdata('item');
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

<script>
	CKEDITOR.replace( 'page_content' );
</script>