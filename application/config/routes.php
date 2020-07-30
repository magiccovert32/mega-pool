<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


#Admin auth section
$route['admin-login'] 	= 'admin/auth/admin_login';
$route['check-auth'] 	= 'admin/auth/check_auth';
$route['admin-logout'] 	= 'admin/auth/admin_logout';


#Admin dashboard
$route['admin-dashboard'] 	= 'admin/dashboard/admin_dashboard';


#Admin profile management own
$route['admin-profile-edit']	= 'admin/profile/admin_profile_edit';
$route['admin-update-profile']	= 'admin/profile/admin_update_profile';
$route['admin-update-password']	= 'admin/profile/admin_update_password';


#Admin sport management
$route['admin-sport-management']		= 'admin/sport/admin_sport_management';
$route['admin-sport-management/(:num)']	= 'admin/sport/admin_sport_management/$1';
$route['admin-add-sport']				= 'admin/sport/admin_add_sport';
$route['admin-save-sport']				= 'admin/sport/admin_save_sport';
$route['admin-edit-sport/(:num)']		= 'admin/sport/admin_edit_sport/$1';
$route['admin-update-sport']			= 'admin/sport/admin_update_sport';


#Admin blog management
$route['admin-blog-management']			= 'admin/blog/admin_blog_management';
$route['admin-blog-management/(:num)']	= 'admin/blog/admin_blog_management/$1';
$route['admin-add-blog']				= 'admin/blog/admin_add_blog';
$route['admin-save-blog']				= 'admin/blog/admin_save_blog';
$route['admin-edit-blog/(:num)']		= 'admin/blog/admin_edit_blog/$1';
$route['admin-update-blog']				= 'admin/blog/admin_update_blog';


#Admin league management
$route['admin-league-management']				= 'admin/league/admin_league_management';
$route['admin-league-management/(:num)']		= 'admin/league/admin_league_management/$1';
$route['admin-add-league']						= 'admin/league/admin_add_league';
$route['admin-save-league']						= 'admin/league/admin_save_league';
$route['admin-edit-league/(:num)']				= 'admin/league/admin_edit_league/$1';
$route['admin-update-league']					= 'admin/league/admin_update_league';
$route['admin-attatch-team-with-league/(:num)']	= 'admin/league/admin_attatch_team_with_league/$1';
$route['admin-save-league-team-relation']		= 'admin/league/admin_save_league_team_relation';
$route['admin-remove-league-team-relation']		= 'admin/league/admin_remove_league_team_relation';
$route['admin-league-table/(:num)']				= 'admin/league/admin_league_table/$1';
$route['admin-save-league-team-position-score']	= 'admin/league/admin_save_league_team_position_score';
$route['admin-league-standing-table/(:num)']	= 'admin/league/admin_league_standing_table/$1';


#Admin commissioner management
$route['admin-commissioner-management']			= 'admin/commissioner/admin_commissioner_management';
$route['admin-commissioner-management/(:num)']	= 'admin/commissioner/admin_commissioner_management/$1';
$route['admin-edit-commissioner/(:num)']		= 'admin/commissioner/admin_edit_commissioner/$1';
$route['admin-update-commissioner']				= 'admin/commissioner/admin_update_commissioner';


#Admin player management
$route['admin-player-management']			= 'admin/player/admin_player_management';
$route['admin-player-management/(:num)']	= 'admin/player/admin_player_management/$1';
$route['admin-edit-player/(:num)']			= 'admin/player/admin_edit_player/$1';
$route['admin-update-player']				= 'admin/player/admin_update_player';


#Admin team management
$route['admin-team-management']			= 'admin/team/admin_team_management';
$route['admin-team-management/(:num)']	= 'admin/team/admin_team_management/$1';
$route['admin-add-team']				= 'admin/team/admin_add_team';
$route['admin-save-team']				= 'admin/team/admin_save_team';
$route['admin-edit-team/(:num)']		= 'admin/team/admin_edit_team/$1';
$route['admin-update-team']				= 'admin/team/admin_update_team';


#Admin match management
$route['admin-match-management']		= 'admin/match/admin_match_management';
$route['admin-match-management/(:num)']	= 'admin/match/admin_match_management/$1';
$route['admin-add-match']				= 'admin/match/admin_add_match';
$route['admin-save-match']				= 'admin/match/admin_save_match';
$route['admin-edit-match/(:num)']		= 'admin/match/admin_edit_match/$1';
$route['admin-update-match']			= 'admin/match/admin_update_match';
$route['admin-remove-match']			= 'admin/match/admin_remove_match';
$route['get-teams-by-league']			= 'admin/match/get_teams_by_league';
$route['admin-edit-match/(:any)']		= 'admin/match/admin_edit_match/$1';
$route['publish-match/(:any)']			= 'admin/match/publish_match/$1';
$route['update-match-point']			= 'admin/match/update_match_point';


$route['admin-single-match-management']			= 'admin/singlematch/admin_single_match_management';
$route['admin-single-match-management/(:num)']	= 'admin/singlematch/admin_single_match_management/$1';
$route['admin-single-add-match']				= 'admin/singlematch/admin_single_add_match';
$route['admin-single-save-match']				= 'admin/singlematch/admin_single_save_match';
$route['admin-single-edit-match/(:num)']		= 'admin/singlematch/admin_single_edit_match/$1';
$route['admin-single-update-match']				= 'admin/singlematch/admin_single_update_match';
$route['admin-single-remove-match']				= 'admin/singlematch/admin_single_remove_match';
$route['admin-single-edit-match/(:any)']		= 'admin/singlematch/admin_single_edit_match/$1';
$route['publish-single-match/(:any)']			= 'admin/singlematch/publish_single_match/$1';
$route['update-single-match-point']				= 'admin/singlematch/update_single_match_point';


$route['cms/about-us']		= 'admin/cms/about_us';
$route['cms/contact-us']	= 'admin/cms/contact_us';
$route['cms/privacy-policy']= 'admin/cms/privacy_policy';
$route['cms/home-page']		= 'admin/cms/home_page';

$route['about-us']		= 'front_end/cms/about_us';
$route['contact-us']	= 'front_end/cms/contact_us';
$route['privacy-policy']= 'front_end/cms/privacy_policy';

/**
 * 
 * FRONT END ROUTE
 * 
 */

#login route
$route['account-login']     	= 'front_end/auth/login/account_login';
$route['verify-login']      	= 'front_end/auth/login/verify_login';
$route['account-logout']    	= 'front_end/auth/login/account_logout';
$route['create-account']    	= 'front_end/auth/signup/create_account';
$route['forgot-password']   	= 'front_end/auth/login/forgot_password';
$route['send-reset-link']   	= 'front_end/auth/login/send_reset_link';
$route['reset-password/(:any)'] = 'front_end/auth/login/reset_password/$1';
$route['update-reset-password'] = 'front_end/auth/login/update_reset_password';


#signup route
$route['save-account']          = 'front_end/auth/signup/save_account';
$route['verify-account/(:any)'] = 'front_end/auth/signup/verify_account/$1';


#my profile route
$route['my-dashboard']      = 'front_end/profile/dashboard/my_dashboard';
$route['my-profile']        = 'front_end/profile/profile/my_profile';
$route['update-profile']    = 'front_end/profile/profile/update_profile';
$route['update-password']   = 'front_end/profile/profile/update_password';


#megapool route for commissioner
$route['my-megapool']           			= 'front_end/commissioner/megapool/my_megapool';
$route['my-megapool/(:num)']    			= 'front_end/commissioner/megapool/my_megapool/$1';
$route['create-megapool']       			= 'front_end/commissioner/megapool/create_megapool';
$route['save-megapool']         			= 'front_end/commissioner/megapool/save_megapool';
$route['edit-megapool/(:any)']  			= 'front_end/commissioner/megapool/edit_megapool/$1';
$route['update-megapool']       			= 'front_end/commissioner/megapool/update_megapool';
$route['publish-megapool']      			= 'front_end/commissioner/megapool/publish_megapool';
$route['remove-megapool']       			= 'front_end/commissioner/megapool/remove_megapool';
$route['get-related-league-by-sport-id'] 	= 'front_end/commissioner/megapool/get_related_league_by_sport_id';
$route['invite-player/(:any)']  			= 'front_end/commissioner/megapool/invite_player/$1';
$route['send-invitation']  					= 'front_end/commissioner/megapool/send_invitation';
$route['my-invitation']  					= 'front_end/commissioner/megapool/my_invitation';
$route['my-invitation/(:num)']  			= 'front_end/commissioner/megapool/my_invitation/$1';
$route['view-megapool/(:any)']				= 'front_end/commissioner/megapool/view_megapool/$1';
$route['megapool-players/(:any)']			= 'front_end/commissioner/megapool/megapool_players/$1';
$route['megapool-players/(:any)/(:num)']	= 'front_end/commissioner/megapool/megapool_players/$1/$1';
$route['view-standings-table/(:any)']		= 'front_end/commissioner/megapool/view_standings_table/$1';

#draft route for commissioner
$route['my-draft']           		= 'front_end/commissioner/draft/my_draft';
$route['my-draft/(:num)']    		= 'front_end/commissioner/draft/my_draft/$1';
$route['create-draft/(:any)']		= 'front_end/commissioner/draft/create_draft/$1';
$route['save-draft']         		= 'front_end/commissioner/draft/save_draft';
$route['edit-draft/(:any)']  		= 'front_end/commissioner/draft/edit_draft/$1';
$route['update-draft']       		= 'front_end/commissioner/draft/update_draft';
$route['publish-draft']      		= 'front_end/commissioner/draft/publish_draft';
$route['remove-draft']       		= 'front_end/commissioner/draft/remove_draft';
$route['view-draft/(:any)']  		= 'front_end/commissioner/draft/view_draft/$1';
$route['add-player/(:any)']  		= 'front_end/commissioner/draft/add_player/$1';
$route['attatch-player-to-draft']  	= 'front_end/commissioner/draft/attatch_player_to_draft';

#draft route for players
$route['draft/(:any)']  					= 'front_end/player/draft/draft/$1';
$route['submit-team']   					= 'front_end/player/draft/submit_team';
$route['manage-draft']          			= 'front_end/player/draft/manage_draft';
$route['manage-draft/(:num)']   			= 'front_end/player/draft/manage_draft/$1';
$route['view-draft-standings-table/(:any)'] = 'front_end/player/draft/view_draft_standings_table/$1';

#player wallet
$route['my-wallet']                     = 'front_end/player/wallet/my_wallet';
$route['wallet-transactions']           = 'front_end/player/wallet/wallet_transactions';
$route['wallet-transactions/(:num)']    = 'front_end/player/wallet/wallet_transactions/$1';


$route['all-megapool']           = 'front_end/player/megapool/all_megapool';
$route['all-megapool/(:num)']    = 'front_end/player/megapool/all_megapool/$1';
$route['megapool/(:any)']        = 'front_end/player/megapool/megapool_preview';

$route['invitations']   		= 'front_end/player/invitation/invitations';
$route['invitations/(:num)']   	= 'front_end/player/invitation/invitations/$1';
$route['accept-invitation']   	= 'front_end/player/invitation/accept_invitation';
$route['reject-invitation']   	= 'front_end/player/invitation/reject_invitation';
$route['join-megapool/(:any)']  = 'front_end/player/invitation/join_megapool/$1';

$route['my-leagues']   		= 'front_end/player/megapool/my_leagues';
$route['my-leagues/(:num)'] = 'front_end/player/megapool/my_leagues/$1';
$route['blogs/(:any)']   	= 'home/blog_details/$1';

$route['switch-account']    = 'account/switch_account';


$route['404_override'] = 'my404';