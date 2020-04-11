<div class="container">
	<!-- Features Section -->
	<h1 class="my-4"></h1>
	<div class="row">
		<div class="col-lg-12">
			<br/>
			<h2 class="card-title"><?php echo $blog_details['blog_title']; ?></h2>
			<hr>
			<img class="img-fluid rounded" style="max-width: 50%" src="<?php echo base_url('assets/uploads/blog_logo/'.$blog_details['blog_image_path']); ?>" alt="">
			<div style="min-height: calc(80vh - 100px);">
				<?php echo $blog_details['blog_content']; ?>
				<br/>
			</div>
			
		</div>
	</div>
</div>

<style>
	.img-fluid {
		float: left;
		margin: 0 20px 20px 0;
	}
</style>