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
	<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&display=swap" rel="stylesheet">
	<link href="<?php echo base_url(); ?>main.cba69814a806ecc7945a.css" rel="stylesheet"></head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

    <style>
        body{
			font-family: 'Lato', sans-serif !important;
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
		<div class="app-header__content">
            
            <div class="app-header-right">
                <div class="header-dots">
                    
                </div>
                
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
																	<?php echo $this->session->userdata('admin_profile_name') ?>
                                                                </div>
                                                                <div class="widget-subheading opacity-8">
																	Site Admin Manager
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-right mr-2">
																<a href="<?php echo base_url('admin-logout'); ?>">
																	<button class="btn-pill btn-shadow btn-shine btn btn-focus">Logout</button>
																</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="scroll-area-xs" style="height: 150px;">
                                            <div class="scrollbar-container ps">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item-header nav-item">My Account</li>
                                                    <li class="nav-item">
                                                        <a href="<?php echo base_url('admin-profile-edit'); ?>" class="nav-link">Settings
                                                            <div class="ml-auto badge badge-success">Profile Edit </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <ul class="nav flex-column">
                                            <li class="nav-item-divider mb-0 nav-item"></li>
                                        </ul>
                                        <div class="grid-menu grid-menu-2col">
                                            <div class="no-gutters row">
                                                <div class="col-sm-6">
                                                    <button class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-warning">
                                                        <i class="pe-7s-chat icon-gradient bg-amy-crisp btn-icon-wrapper mb-2"></i>
                                                        Message Inbox
                                                    </button>
                                                </div>
                                                <div class="col-sm-6">
                                                    <button class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-danger">
                                                        <i class="pe-7s-ticket icon-gradient bg-love-kiss btn-icon-wrapper mb-2"></i>
                                                        <b>Support Tickets</b>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content-left  ml-3 header-user-info">
                                <div class="widget-heading">
                                    <?php echo $this->session->userdata('admin_profile_name') ?>
                                </div>
                                <div class="widget-subheading">
                                    Site Admin Manager
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
						<li class="app-sidebar__heading">Menu</li>
						<li <?php if($action == 'analytics_dashboard'){ ?> class="mm-active" <?php } ?>>
							<a href="#">
								<i class="metismenu-icon pe-7s-rocket"></i> My Dashboard
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul>
								<li>
									<a href="<?php echo  base_url('admin-dashboard'); ?>" <?php if($action == 'analytics_dashboard'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> Analytics
									</a>
								</li>
							</ul>
						</li>
						<li <?php if($action == 'admin_profile_edit'){ ?> class="mm-active" <?php } ?>>
							<a href="#">
								<i class="metismenu-icon pe-7s-settings"></i>
								Profile Settings
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul>
								<li>
									<a href="<?php echo  base_url('admin-profile-edit'); ?>" <?php if($action == 'admin_profile_edit'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> Update Profile
									</a>
								</li>
							</ul>
						</li>
                        
                        <li <?php if(in_array($action, array('megapool_template','create_megapool_template'))){ ?> class="mm-active" <?php } ?>>
							<a href="<?php echo  base_url('megapool-template'); ?>" <?php if(in_array($action, array('megapool_template','create_megapool_template'))){ ?> class="mm-active" <?php } ?>>
								<i class="metismenu-icon pe-7s-star"></i>
								League Template
							</a>
						</li>
						
						<li class="app-sidebar__heading">Sports</li>
						<li <?php if($action == 'admin_sport_management' || $action == 'admin_add_sport'){ ?> class="mm-active" <?php } ?>>
							<a href="#">
								<i class="metismenu-icon pe-7s-target"></i> Sport Management
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul>
								<li>
									<a href="<?php echo  base_url('admin-sport-management'); ?>" <?php if($action == 'admin_sport_management'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> All Sports
									</a>
								</li>
								<li>
									<a href="<?php echo  base_url('admin-add-sport'); ?>" <?php if($action == 'admin_add_sport'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> Add New Sport
									</a>
								</li>
							</ul>
						</li>
						<li <?php if($action == 'admin_league_management'){ ?> class="mm-active" <?php } ?>>
							<a href="#">
								<i class="metismenu-icon pe-7s-network"></i> League Management
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul>
								<li>
									<a href="<?php echo  base_url('admin-league-management'); ?>" <?php if($action == 'admin_league_management'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> All Leagues
									</a>
								</li>
								<li>
									<a href="<?php echo  base_url('admin-add-league'); ?>" <?php if($action == 'admin_add_league'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> Add New League
									</a>
								</li>
							</ul>
						</li>
						
						<li <?php if($action == 'admin_team_management'){ ?> class="mm-active" <?php } ?>>
							<a href="#">
								<i class="metismenu-icon pe-7s-star"></i> Team Management
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul>
								<li>
									<a href="<?php echo  base_url('admin-team-management'); ?>" <?php if($action == 'admin_team_management'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> All Team
									</a>
								</li>
								<li>
									<a href="<?php echo  base_url('admin-add-team'); ?>" <?php if($action == 'admin_add_team'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> Add New Team
									</a>
								</li>
							</ul>
						</li>
						<li <?php if(in_array($action, array('admin_match_management','admin_add_match','admin_single_match_management','admin_single_add_match'))){ ?> class="mm-active" <?php } ?>>
							<a href="#">
								<i class="metismenu-icon pe-7s-network"></i> Match Management
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul>
								<li>
									<a href="<?php echo  base_url('admin-match-management'); ?>" <?php if($action == 'admin_match_management'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> All Generic Matches
									</a>
								</li>
								<li>
									<a href="<?php echo  base_url('admin-add-match'); ?>" <?php if($action == 'admin_add_match'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> Add New Generic Match
									</a>
								</li>
								<li>
									<a href="<?php echo  base_url('admin-single-match-management'); ?>" <?php if($action == 'admin_single_match_management'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> Single Play Matches
									</a>
								</li>
								<li>
									<a href="<?php echo  base_url('admin-single-add-match'); ?>" <?php if($action == 'admin_single_add_match'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> Add Single Play Match
									</a>
								</li>
							</ul>
						</li>
						<li class="app-sidebar__heading">Commissioners</li>
						<li <?php if($action == 'admin_commissioner_management'){ ?> class="mm-active" <?php } ?>>
							<a href="#">
								<i class="metismenu-icon pe-7s-users"></i> Profile Management
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul>
								<li>
									<a href="<?php echo  base_url('admin-commissioner-management'); ?>" <?php if($action == 'admin_commissioner_management'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> All Profiles
									</a>
								</li>
							</ul>
						</li>
						<li <?php if($action == 'admin_megapool_leagues'){ ?> class="mm-active" <?php } ?>>
							<a href="#">
								<i class="metismenu-icon pe-7s-network"></i> Mega Pool Leagues
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul>
								<li>
									<a href="<?php echo  base_url('admin-megapool-leagues'); ?>" <?php if($action == 'admin_megapool_leagues'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> All Mega Pools
									</a>
								</li>
                                <li>
									<a href="<?php echo  base_url('admin-megapool-draft'); ?>" <?php if($action == 'admin_megapool_draft'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> All Draft
									</a>
								</li>
							</ul>
						</li>
						
						<li class="app-sidebar__heading">Players</li>
						<li <?php if($action == 'admin_player_management'){ ?> class="mm-active" <?php } ?>>
							<a href="#">
								<i class="metismenu-icon pe-7s-user"></i> Profile Management
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul>
								<li>
									<a href="<?php echo  base_url('admin-player-management'); ?>" <?php if($action == 'admin_player_management'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> All Profiles
									</a>
								</li>
							</ul>
						</li>
						
						<li class="app-sidebar__heading">Blogs</li>
						<li <?php if($action == 'admin_blog_management'){ ?> class="mm-active" <?php } ?>>
							<a href="#">
								<i class="metismenu-icon pe-7s-network"></i> Blog Management
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul>
								<li>
									<a href="<?php echo  base_url('admin-blog-management'); ?>" <?php if($action == 'admin_blog_management'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> All Blogs
									</a>
								</li>
								<li>
									<a href="<?php echo  base_url('admin-add-blog'); ?>" <?php if($action == 'admin_add_blog'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> Add New Blog
									</a>
								</li>
							</ul>
						</li>
						
						<li class="app-sidebar__heading">CMS Pages</li>
						<li <?php if(in_array($action, array('about_us','contact_us','privacy_policy','home_page'))){ ?> class="mm-active" <?php } ?>>
							<a href="#">
								<i class="metismenu-icon pe-7s-network"></i> Page Management
								<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
							</a>
							<ul>
								<li>
									<a href="<?php echo  base_url('cms/home-page'); ?>" <?php if($action == 'home_page'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> Home Page
									</a>
								</li>
								<li>
									<a href="<?php echo  base_url('cms/about-us'); ?>" <?php if($action == 'about_us'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> About Page
									</a>
								</li>
								<li>
									<a href="<?php echo  base_url('cms/contact-us'); ?>" <?php if($action == 'contact_us'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> Contact Page
									</a>
								</li>
								<li>
									<a href="<?php echo  base_url('cms/privacy-policy'); ?>" <?php if($action == 'privacy_policy'){ ?> class="mm-active" <?php } ?>>
										<i class="metismenu-icon"></i> Privacy Policy
									</a>
								</li>
							</ul>
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
