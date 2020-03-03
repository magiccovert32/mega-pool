<header>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <!-- Slide One - Set the background image for this slide in the line below -->
                <div class="carousel-item active" style="background-image: url('<?php echo base_url(); ?>assets/images/6.jpg')">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>First Slide</h3>
                        <p>This is a description for the first slide.</p>
                    </div>
                </div>
				
				<div class="carousel-item" style="background-image: url('<?php echo base_url(); ?>assets/images/4.jpg')">
                    <div class="carousel-caption d-none d-md-block">
                        <!--<h3>Second Slide</h3>
                        <p>This is a description for the first slide.</p>-->
                    </div>
                </div>
				
				<div class="carousel-item" style="background-image: url('<?php echo base_url(); ?>assets/images/3.jpg')">
                    <div class="carousel-caption d-none d-md-block">
                        <!--<h3>Third Slide</h3>
                        <p>This is a description for the first slide.</p>-->
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
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
							<a href="<?php echo base_url(); ?>blogs/<?php echo $b['blog_url']; ?>"><img class="card-img-top" src="<?php echo base_url('assets/images/blog1.jpg'); ?>" alt=""></a>
							<div class="card-body">
								<h4 class="card-title">
									<a href="<?php echo base_url(); ?>blogs/<?php echo $b['blog_url']; ?>"><?php echo $b['blog_title']; ?></a>
								</h4>
								<p class="card-text"><?php echo $b['blog_content']; ?></p>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
        <?php } ?>
    </div>