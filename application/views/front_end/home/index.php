<header>
	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
		</ol>
		<div class="carousel-inner" role="listbox">
			<div class="carousel-item active" style="background-image: url('<?php echo base_url(); ?>assets/uploads/cms/<?php echo $page_details['banner_image']; ?>')">
				<div class="carousel-caption d-none d-md-block">
					<h3>First Slide</h3>
				</div>
			</div>
		</div>
	</div>
</header>

<!-- Page Content -->
<div class="container">
	<!-- Features Section -->
	<h1 class="my-4"></h1>
	<div class="row">
		<div class="col-lg-6">
			<h2 class="card-title"><?php echo $page_details['page_title']; ?></h2>
			<hr/>
			<p class="sm-text">
				<?php echo $page_details['page_content']; ?>
			</p>
		</div>
		<div class="col-lg-6">
			<img class="img-fluid rounded" src="<?php echo base_url(); ?>assets/uploads/cms/<?php echo $page_details['small_image']; ?>" alt="">
		</div>
	</div>
	<!-- /.row -->

	<hr>

	<!-- Call to Action Section -->
	<div class="row mb-4">
		<div class="col-md-8">
			<?php echo $page_details['small_content']; ?>
		</div>
		
		<div class="col-md-4">
			<a class="btn btn-md btn-warning btn-block" href="<?php echo base_url('my-leagues'); ?>">
				<img src="<?php echo base_url('assets/images/shield.png'); ?>" alt="" width="30" height="30">
				Create League
			</a>
		</div>
		<div class="col-md-4">
			<a class="btn btn-md btn-warning btn-block" href="<?php echo base_url('my-megapool'); ?>">
				<img src="<?php echo base_url('assets/images/shield.png'); ?>" alt="" width="30" height="30">
				My Megapool
			</a>
		</div>
	</div>
	
	<?php if($blog){ ?>
		<h2 class="card-title">Blogs</h2>
		<hr/>
		<div class="row">
			<?php foreach($blog as $b){ ?>
				<div class="col-lg-4 col-sm-6 portfolio-item">
					<div class="card h-100">
						<a href="<?php echo base_url(); ?>blogs/<?php echo $b['blog_url']; ?>">
							<img class="card-img-top" src="<?php echo base_url('assets/uploads/blog_logo/'.$b["blog_image_path"]); ?>" alt="" style="background: #f1f1f1;border-bottom: 1px dashed #ccc;">
						</a>
						<div class="card-body">
							<h4 class="card-title" style="font-size: 20px;">
								<a href="<?php echo base_url(); ?>blogs/<?php echo $b['blog_url']; ?>"><?php echo $b['blog_title']; ?></a>
							</h4>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
</div>