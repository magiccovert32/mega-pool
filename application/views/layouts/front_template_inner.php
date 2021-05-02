<!doctype html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TCNFDV8');</script>
    <!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="icon" href="<?php echo base_url('assets/images/fav.png'); ?>" type="image/png" sizes="16x16">
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&display=swap&subset=latin-ext" rel="stylesheet">
	<link href="<?php echo base_url(); ?>main.cba69814a806ecc7945a.css" rel="stylesheet"></head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

	<style>
        body{
			font-family: 'Open Sans', sans-serif !important;
			letter-spacing: 0.03em;
		}

        a{
            text-decoration: none !important;
        }

        .display_none{
            display: none;
        }
	</style>
    <script>
        var base_path = "<?php echo base_url(); ?>";
    </script>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TCNFDV8"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    <div class="app-header header-shadow">
        <div class="app-header__logo">
            <a href="<?php echo base_url('my-dashboard'); ?>"><div class="logo-src"></div></a>
            <div class="header__pane ml-auto">
                <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="app-header__mobile-menu">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
        <div class="app-header__menu">
            <span>
                <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                    <span class="btn-icon-wrapper">
                        <i class="fa fa-ellipsis-v fa-w-6"></i>
                    </span>
                </button>
            </span>
        </div>
		<div class="app-header__content">

            <div class="app-header-right">
                <div class="header-btn-lg pr-0">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="btn-group">
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                        <img width="42" class="rounded-circle" src="assets/images/avatars/1.png" alt="">
                                        <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                    </a>
                                    <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-menu-header">
                                            <div class="dropdown-menu-header-inner bg-info">
                                                <div class="menu-header-image opacity-2" style="background-image: url('assets/images/dropdown-header/city3.jpg');"></div>
                                                <div class="menu-header-content text-left">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <img width="42" class="rounded-circle" src="assets/images/avatars/1.png" alt="">
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">
																	<?php echo $this->session->userdata('full_name'); ?>
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-right mr-2">
																<a href="<?php echo base_url('account-logout'); ?>">
																	<button class="btn-pill btn-shadow btn-shine btn btn-focus">Logout</button>
																</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="scroll-area-xs">
                                            <div class="scrollbar-container ps">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item-header nav-item">My Account</li>
                                                    <li class="nav-item">
                                                        <a href="<?php echo base_url('my-profile'); ?>" class="nav-link">Settings
                                                            <div class="ml-auto badge badge-success">Profile Edit </div>
                                                        </a>
                                                    </li>
													
                                                    <li class="nav-item-header nav-item">Wallet</li>
                                                    <li class="nav-item">
                                                        <a href="<?php echo base_url('my-wallet'); ?>" class="nav-link">My Wallet
                                                            <div class="ml-auto badge badge-success">View</div>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="<?php echo base_url('wallet-transactions'); ?>" class="nav-link">Wallet Transaction
                                                            <div class="ml-auto badge badge-success">View</div>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item-header nav-item">Invitations</li>
                                                    <li class="nav-item">
                                                        <a href="<?php echo base_url('invitations'); ?>" class="nav-link">My Invitations
                                                            <div class="ml-auto badge badge-success">View</div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content-left  ml-3 header-user-info">
                                <div class="widget-heading">
                                    <?php echo $this->session->userdata('full_name') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="app-main">
		<div class="app-sidebar sidebar-shadow">
			<div class="app-header__logo">
				<div class="logo-src"></div>
				<div class="header__pane ml-auto">
					<div>
						<button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
							<span class="hamburger-box">
								<span class="hamburger-inner"></span>
							</span>
						</button>
					</div>
				</div>
			</div>
			<div class="app-header__mobile-menu">
				<div>
					<button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</div>
			</div>
			<div class="app-header__menu">
				<span>
					<button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
						<span class="btn-icon-wrapper">
							<i class="fa fa-ellipsis-v fa-w-6"></i>
						</span>
					</button>
				</span>
			</div>
			<div class="scrollbar-sidebar">
				<div class="app-sidebar__inner">
					<ul class="vertical-nav-menu">
						<li class="app-sidebar__heading">Dashboard</li>
						<li <?php if($action == 'my_dashboard'){ ?> class="mm-active" <?php } ?>>
							<a href="#">
								<i class="metismenu-icon pe-7s-rocket"></i> My Dashboard
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul>
								<li>
									<a href="<?php echo  base_url('my-dashboard'); ?>" <?php if($action == 'my_dashboard'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> Analytics
									</a>
								</li>
							</ul>
						</li>
						<li <?php if($action == 'my_profile'){ ?> class="mm-active" <?php } ?>>
							<a href="#">
								<i class="metismenu-icon pe-7s-settings"></i>
								Profile Settings
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul>
								<li>
									<a href="<?php echo  base_url('my-profile'); ?>" <?php if($action == 'my_profile'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> Update Profile
									</a>
								</li>
							</ul>
						</li>
						
                        <li class="app-sidebar__heading">Megapool Management</li>
                        <li <?php if(in_array($action,array('my_megapool','create_megapool','my_draft','my_invitation'))){ ?> class="mm-active" <?php } ?>>
                            <a href="#">
                                <i class="metismenu-icon pe-7s-rocket"></i> Megapool
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            </a>
                            <ul>
                                <li>
                                    <a href="<?php echo  base_url('my-megapool'); ?>" <?php if($action == 'my_megapool'){ ?> class="mm-active" <?php } ?>>
                                        <i class="metismenu-icon"></i> My Megapool
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo  base_url('create-megapool'); ?>" <?php if($action == 'create_megapool'){ ?> class="mm-active" <?php } ?>>
                                        <i class="metismenu-icon"></i> Create Megapool
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo  base_url('my-draft'); ?>" <?php if($action == 'my_draft'){ ?> class="mm-active" <?php } ?>>
                                        <i class="metismenu-icon"></i> Created Drafts
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo  base_url('my-invitation'); ?>" <?php if($action == 'my_invitation'){ ?> class="mm-active" <?php } ?>>
                                        <i class="metismenu-icon pe-7s-star"></i> Sent Invitations
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="app-sidebar__heading">Joined Megapool</li>
                        <li>
                            <a href="<?php echo  base_url('invitations'); ?>" <?php if(in_array($action,array('invitations'))){ ?> class="mm-active" <?php } ?>>
                                <i class="metismenu-icon pe-7s-star"></i> Received Invitations
                            </a>
                        </li>
                    
                        <li>
                            <a href="<?php echo  base_url('my-leagues'); ?>" <?php if($action == 'joined_megapool'){ ?> class="mm-active" <?php } ?>>
                                <i class="metismenu-icon"></i> My Leagues
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo  base_url('manage-draft'); ?>" <?php if(in_array($action,array('manage_draft','my_draft_player'))){ ?> class="mm-active" <?php } ?>>
                                <i class="metismenu-icon"></i> My Draft
                            </a>
                        </li>
					</ul>
				</div>
			</div>
		</div>
		<div class="app-main__outer">
			<div class="app-main__inner">
				<div class="app-page-title">
					<div class="page-title-wrapper">
						<div class="page-title-heading">
							<div class="page-title-icon">
								<i class="<?php echo $page_icon; ?> icon-gradient bg-mean-fruit"></i>
							</div>
							<div>
								<?php echo $header; ?>
							</div>
						</div>
					</div>
				</div>
				
				<?php echo $contents ?>
			</div>
			<div class="app-wrapper-footer">
				<div class="app-footer">
					<div class="app-footer__inner">
						<div class="app-footer-left">
							
						</div>
						<div class="app-footer-right">
							
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>

<div class="app-drawer-overlay d-none animated fadeIn"></div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/main.cba69814a806ecc7945a.js"></script>


</html>
