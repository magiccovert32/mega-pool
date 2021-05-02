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
		$this->front_template_inner->set('action', 'my_draft_player');			
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
			
			$data['player_selected_teams'] = false;
			$data['player_selected_teams_id'] = false;
			
			if($data['has_record']){
				foreach($data['has_record'] as $teams){
					$data['player_selected_teams'][] = $teams['team_title'];
					$data['player_selected_teams_id'][] = $teams['team_id'];
				}
			}

			$newTeamArray 	= array();
			$selected_team	= array();
			
			if($data['selected_team']){
				$selected_team = explode(',',$data['selected_team']);
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
				foreach($data['has_record'] as $team){
					$data['related_team'][] = $team;
				}
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
			
			$data['team_score_position'] = $team_score_position;
			
			#------------------- END ---------------------
			
			if(!$this->Megapoolmaster_model->checkUserAccessToMegapoolAsPlayer($megapoolId,$user_id)){
				$this->session->set_flashdata('item', array('message' => 'You do not have access to view this page.','class' => 'danger'));	
			}
		}
		
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/player/draft/draft_details', $data);
	}
	
	public function check_draft_selection_timing(){
		$user_id = $this->session->userdata('user_id');
			
		#check draft timing
		$draft_list = $this->Draftmaster_model->checkDraftSelectionTiming($user_id);
		
		if($draft_list){
			$response = array('draft_list_status' => $draft_list, 'status' => 1);
		}else{
			$response = array('status' => 0);
		}

		echo json_encode($response);
		die;
	}
	
	
	public function check_draft_selection_timing_by_draft_id(){
		if($this->input->post()){
			$draft_url	= $this->input->post('draft_url');
				
			#check my turn
			$draft = $this->Draftmaster_model->getDraftDetailsByDraftUrl($draft_url);
			
			if($draft){
				if($draft['team_selection_started'] == 1){
					$response = array('status' => 1);
				}else{
					$response = array('status' => 0);
				}
			}else{
				$response = array('status' => 0);
			}
		}else{
			$response = array('status' => 0);
		}

		echo json_encode($response);
		die;
	}
	
	public function check_my_selection_time(){
		if($this->input->post()){
			$user_id 	= $this->session->userdata('user_id');
			$draft_id	= $this->input->post('draft_id');
				
			#check my turn
			$my_turn = $this->Draftmaster_model->checkMySelectionTurn($draft_id,$user_id);
			
			if($my_turn){
				$response = array('status' => 1,'my_turn' => $my_turn);
			}else{
				$response = array('status' => 0);
			}
		}else{
			$response = array('status' => 0);
		}

		echo json_encode($response);
		die;
	}
	
	public function get_already_selected_players(){
		if($this->input->post()){
			$draft_id	= $this->input->post('draft_id');
				
			#check my turn
			$teams = $this->Draftmaster_model->getAlreadySelectedTeams($draft_id);
			
			if($teams){
				$response = array('status' => 1, 'teams' => $teams);
			}else{
				$response = array('status' => 0);
			}
		}else{
			$response = array('status' => 0);
		}

		echo json_encode($response);
		die;
	}
	
	public function get_available_teams_to_select(){
		if($this->input->post()){
			$draft_id = $this->input->post('draft_id');
				
			$selected_players = $this->Draftmaster_model->getAllSelectedTeamByDraftId($draft_id);
			$available_teams  = $this->Draftmaster_model->get_all_available_teams_by_draft($draft_id, explode(',',$selected_players));
						
			if($available_teams){
				$response = array('status' => 1, 'teams' => $available_teams);
			}else{
				$response = array('status' => 0);
			}
		}else{
			$response = array('status' => 0);
		}

		echo json_encode($response);
		die;
	}
	
	public function submit_team(){
		if($this->input->post()){
			$draft_url		= $this->input->post('draft_url');
			$selected_team	= $this->input->post('selected_team');
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
						
						$my_turn = $this->Draftmaster_model->checkMySelectionTurn($draft_id,$user_id);
			
						if($my_turn){
							if($my_turn['turn'] == 2){
								$response = array('status' => 0, 'Your turn has expired.');
							}else{
								//$this->Draftmaster_model->removeDraftPlayerRelation($user_id,$draft_id);
					
								foreach($selected_team as $team){
									$draftTeamData = array(
														'draft_id'   	=> $draft_id,
														'player_id'		=> $user_id,
														'team_id'		=> $team
														);
									
									$this->Draftmaster_model->saveRelation($draftTeamData);
								}
								
								#prepare next player
								$draft_details = $data['draft_details'];
								
								$total_player_playing 	= $draft_details['total_player_playing'];
								$total_round 			= $draft_details['total_round'];
								$current_round 			= $draft_details['current_round'];
								$current_player_order	= $draft_details['current_player_order'];
								
								$next_player_order	= $current_player_order+1;
								
								if($next_player_order > $total_player_playing){
									$next_round = $current_round + 1;
									$next_player_order = 1;
								}else{
									$next_round = $current_round;
								}
																
								if($next_round <= $total_round){
									$dataArray = array(
													'current_round'			=> $next_round,
													'current_player_order'	=> $next_player_order,
												);
									
									//print_r($dataArray);
									//die;
									//
									$this->Draftmaster_model->update($dataArray,$draft_details['draft_id']);
									
									#UPDATE FIRST PLAYER SELECTION TURN
									$player = $this->Draftmaster_model->getPlayerByTurn($draft_details['megapool_id'],$next_round,$next_player_order);
									
									if($player){
										$turnArray = array(
														'turn' => 1,
														'turn_started_at' => @date('Y-m-d H:i:s'),
														);
										
										$this->Draftmaster_model->updatePlayerTurn($turnArray,$player['player_id'],$draft_details['megapool_id']);
									}
								}else{
									$dataArray = array(
														'team_selection_ended'	=> 1,
														'team_selection_started'=> 2,
													);
							
									//print_r($dataArray);
									//die;
									
									$this->Draftmaster_model->update($dataArray,$draft_details['draft_id']);
									$this->Draftmaster_model->resetAllPlayerTurn($draft_details['megapool_id']);
								}
								$response = array('status' => 1,'message' => 'Player selected');
							}
						}else{
							$response = array('status' => 0, 'Your turn has expired.');
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
						foreach($player['team_name'] as $k => $teams){
							if($teams){
								foreach($teams as $i => $team){
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
	
	public function start_team_selection(){
		if($this->input->post()){
			$draft_url		= $this->input->post('draft_url');
			$user_id		= $this->session->userdata('user_id');
			
			if($draft_url != '' && $user_id != ''){
				$draft_details = $this->Draftmaster_model->getDraftDetailsByDraftUrl($draft_url,$user_id);
				
				if($draft_details){
					$countDownDate 	= new DateTime(@date('Y-m-d H:i:s', strtotime($draft_details['team_selection_ends_on'])));
					$now 			= new DateTime(@date('Y-m-d H:i:s'));
					
					if($countDownDate > $now){
						if($draft_details['team_selection_started'] == 2 && $draft_details['team_selection_ended'] == 2){
							$megapoolId = $draft_details['megapool_id'];
							$leagueId 	= $draft_details['league_id'];
							
							$player_joined = $this->Megapoolmaster_model->getPlayerCountInDraft($megapoolId,$user_id);
							$total_teams   = $this->Leaguemaster_model->getAllTeamCountLeagueId($leagueId);
							
							if($player_joined !== 0 && $total_teams !== 0){
								$roundCount = intdiv($total_teams, $player_joined);
								
								if($roundCount > 0){
									$dataArray = array(
											'team_selection_started' 	=> 1,
											'total_round'				=> $roundCount,
											'current_round'				=> 1,
											'current_player_order'		=> 1,
											'total_player_playing'		=> $player_joined,
											);
							
									$this->Draftmaster_model->update($dataArray,$draft_details['draft_id']);
								}else{
									$response = array('status' => 0,'message' => 'Round creation error. Player count is more than league teams/players.');
								
									echo json_encode($response);
									die;
								}
							}else{
								$response = array('status' => 0,'message' => 'No team/player found!');
								
								echo json_encode($response);
								die;
							}
							
							#UPDATE FIRST PLAYER SELECTION TURN
							$player = $this->Draftmaster_model->getPlayerByTurn($draft_details['megapool_id'],1,1);
							
							if($player){
								$turnArray = array(
												'turn' => 1,
												'turn_started_at' => @date('Y-m-d H:i:s'),
												);
								
								$this->Draftmaster_model->updatePlayerTurn($turnArray,$player['player_id'],$draft_details['megapool_id']);
							}
							
							$response = array('status' => 1);
						}else{
							$response = array('status' => 0,'message' => 'You do not have access to make this request.');
						}
					}else{
						$response = array('status' => 0,'message' => 'Selection time expired');
					}
				}else{
					$response = array('status' => 0,'message' => 'You do not have access to make this request.');
				}
			}
		}else{
			$response = array('status' => 0,'message' => 'You do not have access to make this request.');
		}

		echo json_encode($response);
		die;
	}
	
	function sorting($a,$b) {
		return ($a["total_point"] >= $b["total_point"]) ? -1 : 1;
	}
	
	function sortingScore($a,$b) {
		return ($a["standing_score"] >= $b["standing_score"]) ? -1 : 1;
	}
}
