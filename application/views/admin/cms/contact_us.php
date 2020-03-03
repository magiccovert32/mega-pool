<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<h5 class="card-title">Add page information <small class="form-text text-danger">All fields are mandatory</small></h5>
				
				<form id="update-profile" action="<?php echo base_url('cms/contact-us'); ?>" method="post" enctype="multipart/form-data">
					<div class="position-relative form-group">
						<label for="page_title" class="">Page Title</label>
						<input name="page_title" id="page_title" placeholder="Page title" type="text" class="form-control" required="required" autocomlete="off" value="<?php echo $page_details['page_title']; ?>">
					</div>
					<div class="position-relative form-group">
						<label for="page_content" class="">Write something Contact page</label>
						<textarea name="page_content" id="page_content" class="form-control" required="required"><?php echo $page_details['page_content']; ?></textarea>
					</div>
					
					<button class="mt-1 btn btn-primary" type="submit">Save</button>
					<a href="<?php echo  base_url('cms/contact-us'); ?>">
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