<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<?php if($blog_details){ ?>
					<h5 class="card-title">Add blog information <small class="form-text text-danger">All fields are mandatory</small></h5>
					
					<form id="update-profile" action="<?php echo base_url('admin-update-blog'); ?>" method="post" enctype="multipart/form-data">
						<input value="<?php echo $blog_details['blog_id']; ?>" name="blog_id" type="hidden">
						<input value="<?php echo $blog_details['blog_image_path']; ?>" name="old_blog_image_path" type="hidden">
						<div class="position-relative form-group">
							<label for="blog_title" class="">Blog Name</label>
							<input value="<?php echo $blog_details['blog_title']; ?>" name="blog_title" id="blog_title" placeholder="Blog title" type="text" class="form-control" required="required" autocomlete="off">
						</div>
						<div class="position-relative form-group">
							<label for="blog_content" class="">Write something about the blog</label>
							<textarea wrap="virtual" name="blog_content" id="blog_content" class="form-control" required="required" rows=5 style="font-size: 14px;"><?php echo $blog_details['blog_content']; ?></textarea>
						</div>
						<div class="position-relative form-group">
							<img style="width: 200px; height: auto;" src="<?php echo base_url('assets/uploads/blog_logo/'.$blog_details['blog_image_path']) ?>">
						</div>
						<div class="position-relative form-group">
							<label for="blog_image_path" class="">Blog Image</label>
							<input name="blog_image_path" id="blog_image_path" type="file" class="form-control-file" accept="image/*">
							<small class="form-text text-info">Image size should be less than 1 MB</small>
						</div>
						<div class="position-relative form-group">
							<label for="blog_logo" class="">Current Status</label>
							<div>
								<div class="custom-radio custom-control">
									<input value="1" type="radio" id="blog_status1" name="status" class="custom-control-input" <?php if($blog_details['status'] == 1){ ?> checked <?php } ?>>
									<label class="custom-control-label" for="blog_status1">Active</label>
								</div>
								<div class="custom-radio custom-control">
									<input value="2" type="radio" id="blog_status2" name="status" class="custom-control-input" <?php if($blog_details['status'] == 2){ ?> checked <?php } ?>>
									<label class="custom-control-label" for="blog_status2">In-active</label>
								</div>
								<div class="custom-radio custom-control">
									<input value="3" type="radio" id="blog_status3" name="status" class="custom-control-input" <?php if($blog_details['status'] == 3){ ?> checked <?php } ?>>
									<label class="custom-control-label" for="blog_status3">Removed</label>
								</div>
							</div>
						</div>
						<button class="mt-1 btn btn-primary" type="submit">Update Blog</button>
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
				<?php }else{ ?>
					<div class="alert alert-info fade show mt-10" role="alert">
						<div>
							<strong>Error</strong>
							<div class="page-title-subheading">No details found! Something went wrong.</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>