<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<h5 class="card-title">Add blog information <small class="form-text text-danger">All fields are mandatory</small></h5>
				
				<form id="update-profile" action="<?php echo base_url('admin-save-blog'); ?>" method="post" enctype="multipart/form-data">
					<div class="position-relative form-group">
						<label for="blog_title" class="">Blog Title</label>
						<input name="blog_title" id="blog_title" placeholder="Blog title" type="text" class="form-control" required="required" autocomlete="off">
					</div>
					<div class="position-relative form-group">
						<label for="blog_content" class="">Write something about the blog</label>
						<textarea name="blog_content" id="blog_content" class="form-control" required="required" rows=5 style="font-size: 14px;"></textarea>
					</div>
					<div class="position-relative form-group">
						<label for="blog_image_path" class="">Blog Image</label>
						<input name="blog_image_path" id="blog_image_path" type="file" class="form-control-file" accept="image/*">
						<small class="form-text text-info">Image size should be less than 1 MB</small>
					</div>
					<button class="mt-1 btn btn-primary" type="submit">Add Blog</button>
					<a href="<?php echo  base_url('admin-blog-management'); ?>">
						<button class="mt-1 btn btn-outline-dark ml-3" type="button">Cancel</button>
					</a>
				</form>
				
				<?php
					if($this->session->flashdata('blog_item')) {
						$message = $this->session->flashdata('blog_item');
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