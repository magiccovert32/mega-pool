<header>
	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
		</ol>
		<div class="carousel-inner" role="listbox">
			<div class="carousel-item active" style="background-image: url('<?php echo base_url(); ?>assets/images/1211189745.jpg')">
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
			<h2 class="card-title">Real Fantasy Sport At Supersportspool</h2>
			<hr/>
			<p class="sm-text">
				Want to enjoy sport, but just can't manage the time? Well, Supersportspool.com is the answer you need. This is the place that makes your favorite sports come alive. Bringing fantasy sport league right on your device. Pick teams of your choice and play daily fantasy sport.
			</p>
			<p class="sm-text">
				Supersportspool.com is a part of Play Games24x7 bringing fantasy games to your home. Register with us, pick a game and play fantasy sport and win cash daily. Don't wait further, join us now and enjoy the game.
			</p>
			<p class="sm-text">
				Fantasy games boosts your skill level and even lets you win real cash rewards. We give a safe and secure platform to enjoy fantasy sports at your leisure. Get started right away and join fastest growing online fantasy sport platform and be the part of the action and thrill of real fantasy sport.
			</p>
		</div>
		<div class="col-lg-6">
			<img class="img-fluid rounded" src="<?php echo base_url('assets/images/Redbull.jpg'); ?>" alt="">
		</div>
	</div>
	<!-- /.row -->

	<hr>

	<!-- Call to Action Section -->
	<div class="row mb-4">
		<div class="col-md-8">
			<p>
				Fantasy megapool is a sports game where each player can make a team 11, selecting players from a pool of 25 or 30. As the game starts, the users get points for the team 11 players based on their performance in the real match.
			</p>
		</div>
		
		<?php if($this->session->userdata('user_type_id') == 2){ ?>
			<div class="col-md-4">
				<a class="btn btn-md btn-warning btn-block" href="<?php echo base_url('my-leagues'); ?>">
					<img src="<?php echo base_url('assets/images/shield.png'); ?>" alt="" width="30" height="30">
					Create League
				</a>
			</div>
		<?php }else{ ?>
			<div class="col-md-4">
				<a class="btn btn-md btn-warning btn-block" href="<?php echo base_url('my-megapool'); ?>">
					<img src="<?php echo base_url('assets/images/shield.png'); ?>" alt="" width="30" height="30">
					My Megapool
				</a>
			</div>
		<?php } ?>
	</div>
	
	<?php if($blog){ ?>
		<h2 class="card-title">Blogs</h2>
		<hr/>
		<div class="row">
			<?php foreach($blog as $b){ ?>
				<div class="col-lg-4 col-sm-6 portfolio-item">
					<div class="card h-100">
						<a href="<?php echo base_url(); ?>blogs/<?php echo $b['blog_url']; ?>"><img class="card-img-top" src="<?php echo base_url('assets/uploads/blog_logo/'.$b["blog_image_path"]); ?>" alt=""></a>
						<div class="card-body">
							<h4 class="card-title" style="font-size: 20px;">
								<a><?php echo $b['blog_title']; ?></a>
							</h4>
							<?php echo $b['blog_content']; ?>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
</div>