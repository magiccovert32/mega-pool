<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Draft extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	function __construct(){
        parent::__construct();

		$this->load->helper('url');
		$this->load->library('session');	
		$this->load->library("pagination");

		if ($this->session->userdata('user_session_id') == null) {
            redirect(base_url('account-login'));
		}

//		if ($this->session->userdata('user_type_id') != 2) {
//            redirect(base_url('home'));
//		}

		$this->load->model("Usermaster_model");
		$this->load->model("Megapoolmaster_model");
		$this->load->model("Sportmaster_model");
		$this->load->model("Leaguemaster_model");
		$this->load->model("Invitationmaster_model");
		$this->load->model("Draftmaster_model");
		$this->load->model("Matchmaster_model");
		$this->load->model("Singlematchmaster_model");
	}



	/**
	 *
	 * Function used to display players draft list page
	 *
	 */
	public function manage_draft(){
		$userId = $this->session->userdata('user_id');

		$this->front_template_inner->set('title', 'Draft Management');
		$this->front_template_inner->set('header', 'Draft Management');
		$this->front_template_inner->set('action', 'manage_draft');
		$this->front_template_inner->set('page_icon', 'pe-7s-note2');
		
		$data = array();
		$config["base_url"] 		= base_url() . "manage-draft";
		$config["total_rows"] 		= $this->Draftmaster_model->getTotalDraftCountPlayerId($userId);
		$config["uri_segment"] 		= 2;
		$config["per_page"] 		= 10;
		$choice 					= $config["total_rows"] / $config["per_page"];
		$config["num_links"] 		= round($choice);
		$config['use_page_numbers'] = true; 
		$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
		$data["draft_list"] 		= $this->Draftmaster_model->getAllDraftByPlayerId($page,$config["per_page"],$userId);
		$config['full_tag_open'] 	= '<ul class="pagination pull-right">';
		$config['full_tag_close'] 	= '</ul>';
		$config['first_link'] 		= '&laquo; First';
		$config['first_tag_open'] 	= '<li class="prev page">';
		$config['first_tag_close'] 	= '</li>' . "\n";
		$config['last_link'] 		= 'Last &raquo;';
		$config['last_tag_open'] 	= '<li class="next page">';
		$config['last_tag_close'] 	= '</li>' . "\n";
		$config['next_link'] 		= 'Next &rarr;';
		$config['next_tag_open'] 	= '<li class="next page">';
		$config['next_tag_close'] 	= '</li>' . "\n";
		$config['prev_link'] 		= '&larr; Previous';
		$config['prev_tag_open'] 	= '<li class="prev page">';
		$config['prev_tag_close'] 	= '</li>' . "\n";
		$config['cur_tag_open'] 	= '<li class="active"><a href="">';
		$config['cur_tag_close'] 	= '</a></li>';
		$config['num_tag_open'] 	= '<li class="page">';
		$config['num_tag_close'] 	= '</li>' . "\n";

		$this->pagination->initialize($config);

		$data["links"] 	= $this->pagination->create_links();
			
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/player/draft/manage_draft', $data);
	}



	/**
	 * 
	 * Function used to display draft page
	 * 
	 */
	public function draft(){
		$data = array();

		$this->front_template_inner->set('title', 'Supersportspool :: Draft');
		$this->front_template_inner->set('header', 'Draft');	
		$this->front_template_inner->set('action', 'my_draft');			
		$this->front_template_inner->set('page_icon', 'pe-7s-plus');
		
		$draft_url 	= $this->uri->segment(2);
		$user_id	= $this->session->userdata('user_id');

		$data['draft_details'] = $this->Draftmaster_model->getDraftDetailsByDraftUrl($draft_url,$user_id);
		
		if($data['draft_details']){
			$megapoolId = $data['draft_details']['megapool_id'];
			$leagueId 	= $data['draft_details']['league_id'];
			
			#check user has access to megapool
			$data['related_team'] 	= $this->Leaguemaster_model->getAllTeamByLeagueId($leagueId);
			$data['selected_team'] 	= $this->Draftmaster_model->getAllSelectedTeamByDraftId($data['draft_details']['draft_id']);
			$data['has_record'] 	= $this->Draftmaster_model->checkUserSelectedTeam($data['draft_details']['draft_id'],$user_id);
			
			$newTeamArray 	= array();
			$selected_team	= array();
			
			if($data['selected_team']){
				$selected_team = explode(',',$data['selected_team']['team_ids']);
			}
			
			if($data['related_team']){
				foreach($data['related_team'] as $team){
					if(!in_array($team['team_id'],$selected_team)){
						$newTeamArray[] = $team;
					}
				}
			}
			
			$data['related_team'] = $newTeamArray;
			
			if(!$data['has_record']){
				$data['has_record'] = 0;
			}else{
				$data['related_team'][] = $data['has_record'];
			}
			
			
			#-----------check league standing table--------------
					
			$data['league_details'] 		= $this->Leaguemaster_model->getLeagueDetailsByLeagueIdByAdmin($leagueId);
			$data['league_team_count'] 		= $this->Leaguemaster_model->getLeagueTeamCount($leagueId);
			$data['league_team_position'] 	= $this->Leaguemaster_model->getLeagueTeamPositionPoint($leagueId);
			$data['league_teams'] 			= $this->Leaguemaster_model->getAllTeamByLeagueId($leagueId);
			
			$team_score_position = array();
			
			if($data['league_details']){
				if($data['league_details']['league_type'] == 1){
					if($data['league_teams']){
						foreach($data['league_teams'] as $key=>$team){
							$teamResult = $this->Matchmaster_model->getTeamWinningRelation($team['team_id'],$leagueId,$data['league_details']['win_point'],$data['league_details']['draw_point']);
							
							if($teamResult){
								$team['play_count'] = $teamResult['play_count'];
								$team['draw_count'] = $teamResult['draw_count'];
								$team['win_count'] 	= $teamResult['win_count'];
								$team['total_point']= $teamResult['total_point'];
							}
							
							$team_score_position[$key] = $team;
						}
					}
				}elseif($data['league_details']['league_type'] == 2){
					if($data['league_teams']){
						foreach($data['league_teams'] as $key=>$team){
							$teamResult = $this->Singlematchmaster_model->getTeamWinningRelation($team['team_id'],$leagueId);

							if($teamResult){
								$team['play_count'] = $teamResult['play_count'];
								$team['draw_count'] = 0;
								$team['win_count'] 	= 0;
								$team['total_point']= $teamResult['total_point'];
							}
							
							$team_score_position[$key] = $team;
						}
					}
				}
			}
			
			
			usort($team_score_position, array($this,'sorting'));
			
			$data['team_score_position']	= $team_score_position;
			
			#------------------- END ---------------------
			
			if(!$this->Megapoolmaster_model->checkUserAccessToMegapoolAsPlayer($megapoolId,$user_id)){
				$this->session->set_flashdata('item', array('message' => 'You do not have access to view this page.','class' => 'danger'));	
			}
		}
		
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/player/draft/draft_details', $data);
	}
	
	public function submit_team(){
		if($this->input->post()){
			$draft_url		= $this->input->post('draft_url');
			$selected_team	= trim($this->input->post('selected_team'));
			$user_id		= $this->session->userdata('user_id');
			
			if($draft_url != '' && $selected_team != ''){
				$data['draft_details'] = $this->Draftmaster_model->getDraftDetailsByDraftUrl($draft_url,$user_id);
				
				if($data['draft_details']){
					$team_selection_ends_on = strtotime($data['draft_details']['team_selection_ends_on']);
					
					$countDownDate 	= new DateTime(@date('Y-m-d h:i:s', strtotime($data['draft_details']['team_selection_ends_on'])));
					$now 			= new DateTime();
					
					if($countDownDate < $now){
						$response = array('status' => 0,'message' => 'Draft already expired you can not make your team selection for this draft.');
					}else{
						$draft_id = $data['draft_details']['draft_id'];
					
						$draftTeamData = array(
											'draft_id'   	=> $draft_id,
											'player_id'		=> $user_id,
											'team_id'		=> $selected_team
											);
						
						if($this->Draftmaster_model->saveDraftPlayerRelation($draftTeamData,$user_id,$draft_id)){
							$response = array('status' => 1,'message' => 'Successfully submitted.');
						}else{
							$response = array('status' => 0,'message' => 'Something went wrong, while saving your information.Please try again later.');
						}
					}
				}else{
					$response = array('status' => 0,'message' => 'You do not have access to make this request.');
				}
			}
		}else{
			$response = array('status' => 0,'message' => 'Some informations are missing. Please fill up all informations.');
		}

		echo json_encode($response);
		die;
	}
	
	
	public function view_draft_standings_table(){
		$data 		= array();
		
		$league_url = $this->uri->segment(2);
		$user_id	= $this->session->userdata('user_id');
		
		$data['league_details'] = $this->Megapoolmaster_model->getLeagueDetailsByUrl($league_url);

		if($data['league_details']){
			$data['league_players'] 	= $this->Megapoolmaster_model->getPlayerListByMegapoolId($data['league_details']['mega_pool_id']);
			$data['associated_leagues'] = $this->Megapoolmaster_model->getAllSelectedLeagueDetailsByMegaPoolId($data['league_details']['mega_pool_id']);
			$data['draft_list'] 		= $this->Draftmaster_model->getAllPublishedDraftListByMegaPoolId($data['league_details']['mega_pool_id']);
			$data['player_score']		= false;
			$data['no_draft']			= 1;
			
			$draft_IDS = array();
			
			if($data['associated_leagues']){
				foreach($data['associated_leagues'] as $key => $league){
					$league_id 	= $data['associated_leagues'][$key]['league_id'];
					$win_point 	= $data['associated_leagues'][$key]['win_point'];
					$draw_point = $data['associated_leagues'][$key]['draw_point'];
					
					$data['associated_leagues'][$key]['league_team_position']	= $this->Leaguemaster_model->getLeagueTeamPositionPoint($league['league_id']);
					$data['associated_leagues'][$key]['league_teams'] 			= $this->Leaguemaster_model->getAllTeamByLeagueId($league['league_id']);
					
					if($league['league_type'] == 1){						
						$team_score_position = array();
						
						if($data['associated_leagues'][$key]['league_teams']){
							foreach($data['associated_leagues'][$key]['league_teams'] as $k => $team){
								$teamResult = $this->Matchmaster_model->getTeamWinningRelation($team['team_id'],$league_id,$win_point,$draw_point);
							
								if($teamResult){
									$team['total_point']= $teamResult['total_point'];
								}
								
								$team_score_position[$k] = $team;
							}
						}
						
						usort($team_score_position, array($this,'sorting'));
						$data['associated_leagues'][$key]['team_score_position'] = $team_score_position;
					}else{
						$team_score_position = array();
						
						if($data['associated_leagues'][$key]['league_teams']){
							foreach($data['associated_leagues'][$key]['league_teams'] as $k => $team){
								$teamResult = $this->Singlematchmaster_model->getTeamWinningRelation($team['team_id'],$league_id);
							
								if($teamResult){
									$team['total_point']= $teamResult['total_point'];
								}
								
								$team_score_position[$k] = $team;
							}
						}
						
						usort($team_score_position, array($this,'sorting'));
						$data['associated_leagues'][$key]['team_score_position'] = $team_score_position;
					}					
				}
			}
			
			if($data['draft_list']){
				foreach($data['draft_list'] as $list){
					$draft_IDS[] = $list['draft_id'];
				}
			}
			
			if(count($draft_IDS) > 0){
				$data['no_draft'] = 2;
				
				if($data['league_players']){
					foreach($data['league_players'] as $key => $player){
						$data['league_players'][$key]['point_history'] = array();
						
						#get point by leagueId
						if($data['associated_leagues']){
							foreach($data['associated_leagues'] as $league){
								$data['league_players'][$key]['point_history'][] = $this->Draftmaster_model->getPointRecordByLeagueIdAndDraftIds($league['league_id'],$draft_IDS,$player['user_id']);							
								$data['league_players'][$key]['team_name'][] 	 = $this->Draftmaster_model->getTeamRecordByLeagueIdAndDraftIds($league['league_id'],$draft_IDS,$player['user_id']);
							}
						}
					}
				}
			}else{
				if($data['league_players']){
					foreach($data['league_players'] as $key => $player){
						$data['league_players'][$key]['point_history'] = array();
						
						#get point by leagueId
						if($data['associated_leagues']){
							foreach($data['associated_leagues'] as $league){
								$data['league_players'][$key]['point_history'][] = 0;							
							}
						}
					}
				}
			}
			
			#marge player with league and team
			
			if($data['league_players']){
				foreach($data['league_players'] as $key => $player){
					$data['league_players'][$key]['standing_score'] = 0;
					
					if(!empty($player['team_name'])){
						foreach($player['team_name'] as $k => $team){
							if($team){
								#get league postion
								if($data['associated_leagues'][$k]['team_score_position']){
									foreach($data['associated_leagues'][$k]['team_score_position'] as $j => $position){
										if($position['total_point'] != 0){
											if($position['team_id'] == $team['team_id']){
												$data['league_players'][$key]['standing_score'] += $data['associated_leagues'][$k]['league_team_position'][$j]['score'];
											}
										}
										
									}
								}
							}
						}
					}
				}
			}
						
			if($data['league_players']){
				$league_players 		= $data['league_players'];
				usort($league_players, array($this,'sortingScore'));
				$data['league_players'] = $league_players;
			}
		}else{
			$data['league_players'] 	= false;
			$data['associated_leagues'] = false;
			$data['no_draft']			= 1;
		}
		
		

		$this->load->view('front_end/player/draft/view_standings_table', $data);
	}
	
	
	function sorting($a,$b) {
		return ($a["total_point"] >= $b["total_point"]) ? -1 : 1;
	}
	
	function sortingScore($a,$b) {
		return ($a["standing_score"] >= $b["standing_score"]) ? -1 : 1;
	}
}
