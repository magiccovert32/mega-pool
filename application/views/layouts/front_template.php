<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="icon" href="<?php echo base_url(); ?>/assets/images/fav.png" type="image/png" sizes="16x16">
    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/new_assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>assets/new_assets/css/modern-business.css" rel="stylesheet">
	
	<link href="https://fonts.googleapis.com/css?family=Fjalla+One&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i,900,900i&display=swap" rel="stylesheet">	

	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-TCNFDV8');</script>
	<!-- End Google Tag Manager -->
	
	<style>
		body{
			font-family: 'Lato', sans-serif;
			font-size: 14px;
			color: #212529;
			background: #F8F9FA;
		}
		
		.card-title{
			font-size: 26px;
			font-family: nunito,-apple-system,BlinkMacSystemFont,segoe ui,Roboto,helvetica neue,Arial,sans-serif,apple color emoji,segoe ui emoji,segoe ui symbol,noto color emoji;
			color: rgb(221, 61, 49);
		}
		
		a{
			color: #0B2239;
		}
		
		.btn-md{
			font-size: 15px;
			letter-spacing: 2px;
			font-weight: 600;
			text-transform: uppercase;
			color: #FFF;
			font-family: nunito,-apple-system,BlinkMacSystemFont,segoe ui,Roboto,helvetica neue,Arial,sans-serif,apple color emoji,segoe ui emoji,segoe ui symbol,noto color emoji;
		}
		
		.card{
			box-shadow: 0 .15rem 1.75rem 0 rgba(33,37,41,.15)!important;
		}
		
		@media (min-width: 992px) {
			.animate {
				animation-duration: 0.3s;
				-webkit-animation-duration: 0.3s;
				animation-fill-mode: both;
				-webkit-animation-fill-mode: both;
			}
		}
		  
		@keyframes slideIn {
			0% {
				transform: translateY(1rem);
				opacity: 0;
			}
			100% {
				transform:translateY(0rem);
				opacity: 1;
			}
			0% {
				transform: translateY(1rem);
				opacity: 0;
			}
		}
		  
		@-webkit-keyframes slideIn {
			0% {
				-webkit-transform: transform;
				-webkit-opacity: 0;
			}
			100% {
				-webkit-transform: translateY(0);
				-webkit-opacity: 1;
			}
			0% {
				-webkit-transform: translateY(1rem);
				-webkit-opacity: 0;
			}
		}
		  
		.slideIn {
			-webkit-animation-name: slideIn;
			animation-name: slideIn;
		}
	</style>
</head>
<body>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TCNFDV8"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
    <!-- Navigation -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo base_url('/'); ?>">
				<img src="<?php echo base_url('assets/images/logo-inverse.png'); ?>?text=Supersportspool" alt="" width="40" height="40"> Supersportspool
			</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" <?php if($action == 'home'){ ?> style="color: #FFF !important;" <?php } ?> href="<?php echo base_url('/'); ?>">Home</a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link" <?php if($action == 'about_us'){ ?> style="color: #FFF !important;" <?php } ?> href="<?php echo base_url('about-us'); ?>">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" <?php if($action == 'contact_us'){ ?> style="color: #FFF !important;" <?php } ?> href="<?php echo base_url('contact-us'); ?>">Contact Us</a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link" <?php if($action == 'privacy_policy'){ ?> style="color: #FFF !important;" <?php } ?> href="<?php echo base_url('privacy-policy'); ?>">Privacy Policy</a>
                    </li>
                   
					<?php if($this->session->userdata('user_session_id') != null){ ?>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Account
							</a>
							<div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="<?php echo base_url('my-profile'); ?>">My Profile</a>
								<a class="dropdown-item" href="<?php echo base_url('account-logout'); ?>">Logout</a>
							</div>
						</li>
					<?php }else{ ?>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo base_url('account-login'); ?>">Login</a>
						</li>
					<?php } ?>
                </ul>
            </div>
        </div>
    </nav>

	<?php echo $contents ?>
    
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; supersportspool.com 2020</p>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url(); ?>assets/new_assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/new_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>