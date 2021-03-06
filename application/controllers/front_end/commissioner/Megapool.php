<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Megapool extends CI_Controller {

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
		$this->load->model("Megapooltemplate_model");
	}


	/**
	 *
	 * Function used to display commissioner list page
	 *
	 */
	public function my_megapool(){
		$userId = $this->session->userdata('user_id');

		$this->front_template_inner->set('title', 'Megapool Management');
		$this->front_template_inner->set('header', 'Megapool Management');
		$this->front_template_inner->set('action', 'my_megapool');
		$this->front_template_inner->set('page_icon', 'pe-7s-note2');
		
		$data = array();
		$config["base_url"] 		= base_url() . "my-megapool";
		$config["total_rows"] 		= $this->Megapoolmaster_model->getTotalLeagueCountCommissionerId($userId);
		$config["uri_segment"] 		= 2;
		$config["per_page"] 		= 10;
		$choice 					= $config["total_rows"] / $config["per_page"];
		$config["num_links"] 		= round($choice);
		$config['use_page_numbers'] = true; 
		$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
		$data["league_list"] 		= $this->Megapoolmaster_model->getAllLeaguesByCommissionerId($page,$config["per_page"],$userId);
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
			
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/commissioner/megapool/my_megapool', $data);
	}



	/**
	 * 
	 * Function used to display create account page
	 * 
	 */
	public function create_megapool(){
		$data = array();

		$this->front_template_inner->set('title', 'Supersportspool :: Create Megapool');
		$this->front_template_inner->set('header', 'Create Megapool');	
		$this->front_template_inner->set('action', 'create_megapool');			
		$this->front_template_inner->set('page_icon', 'pe-7s-plus');	

		$data['sport_list'] 		= $this->Sportmaster_model->getAllActiveSports();
		$data['megapool_template'] 	= $this->Megapooltemplate_model->getAllActiveLeagueTemplate();
		
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/commissioner/megapool/create_megapool', $data);
	}
	
	
	public function get_league_template_details(){
		$data = array();
		
		if($this->input->post()){
			$template_id			= $this->input->post('template_id');
			$data['league_details'] = $this->Megapooltemplate_model->getDetailedTemplateDetails($template_id);
			
			if($data['league_details']){
				$data['related_league'] = $this->Megapooltemplate_model->getRelatedLeagueDetails($template_id);
			}

			$this->load->view('front_end/commissioner/megapool/get_league_template_details', $data);
		}else{
			$this->load->view('front_end/commissioner/megapool/get_league_template_details', $data);
		}
	}
	
	
	public function create_megapool_from_league_template(){	
		if($this->input->post()){
			$template_id	= $this->input->post('selected_template_id');
			$user_id		= $this->session->userdata('user_id');

			if($template_id){
				$league_details = $this->Megapooltemplate_model->getDetailedTemplateDetails($template_id);
			
				if($league_details){
					$selected_league = $this->Megapooltemplate_model->getAllSelectedLeagueByMegaPoolId($league_details['mega_pool_id']);
					
					if($selected_league){
						$league_image 	= md5(strtotime(@date('y-m-d h:i:s')).'_'.rand(100,200));
						$new_name		= $league_image.'-'.$league_details['league_logo'];
						$logo 			= 'assets/uploads/megapool_template/'.$league_details['league_logo'];
						$copy_image 	= 'assets/uploads/megapool_logo/'.$new_name;						
						
						if (!copy($logo, $copy_image)) {
							echo "failed to copy";
						}
						
						$string = str_replace(' ', '-', $league_details['mega_pool_title']);
						$string = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
						$url	= hash('sha256', trim(preg_replace('/-+/', '-', $string), '-').'-'.rand(100,200).'-'.md5(@date('Y-m-d h:i:s')));
	
						$leagueData = array(
										'related_sport_id'	=> $league_details['related_sport_id'],
										'mega_pool_title' 	=> $league_details['mega_pool_title'],
										'mega_pool_url'		=> strtolower($url),
										'league_logo' 		=> $new_name,
										'created_by' 		=> $user_id,
										'current_status'	=> '2'
										);
						
						if($mega_pool_id = $this->Megapoolmaster_model->save($leagueData)){
							if($selected_league){
								foreach($selected_league as $league){
									$leagueData = array(
													'mega_pool_id'	=> $mega_pool_id,
													'league_id' 	=> $league['league_id'],
													);
	
									$this->Megapoolmaster_model->saveMegapoolLeagueRelation($leagueData);
								}
							}
	
							$response = array('status' => 1,'message' => 'Your megapool created successfully.');
						}else{
							$response = array('status' => 0,'message' => 'Something went wrong, while saving information. Please try again later.');
						}
					}else{
						$response = array('status' => 0,'message' => 'Unable to find related league information.');
					}
				}else{
					$response = array('status' => 0,'message' => 'Unable to find league information.');
				}
			}else{
				$response = array('status' => 0,'message' => 'Some informations are missing. Please fill up all informations');
			}
		}else{
			$response = array('status' => 0,'message' => 'Some informations are missing. Please fill up all informations1');
		}

		echo json_encode($response);
		die;
	}


	/**
	 *
	 * Function used to save megapool 
	 *
	 */
	public function save_megapool(){	
		if($this->input->post()){
			$sport_id			= $this->input->post('sport_id');
			$league_title		= trim($this->input->post('mega_pool_title'));
			$selected_league 	= $this->input->post('selected_league');
			$user_id			= $this->session->userdata('user_id');

			if($league_title != '' && $selected_league != '' && $sport_id != '' && is_array($sport_id)){
				#Check League name exists
				if($this->Megapoolmaster_model->checkLeagueNameExists($league_title)){
					$response = array('status' => 0,'message' => 'League name already exists into this system. Please try with different name.');
				}else{
					#Validate and save league logo
					if($_FILES['league_logo']["tmp_name"] != ''){
						if(!empty($_FILES['league_logo']["tmp_name"])){
							#check size grater than 1MB
							if($_FILES['league_logo']['size'] > 1000000){
								$response = array('status' => 0,'message' => 'Please upload logo within 1MB.');
							}else{
								$imageName 		= md5(strtotime(@date('y-m-d h:i:s')).'_'.rand(111111,999999));
								$imageFileType 	= pathinfo($_FILES["league_logo"]["name"],PATHINFO_EXTENSION);
								
								if (move_uploaded_file($_FILES["league_logo"]["tmp_name"], 'assets/uploads/megapool_logo/'.$imageName.'.'.$imageFileType)) {
									$league_image = $imageName.'.'.$imageFileType;
								}
							}
						}
					}else{
						$league_image 	= md5(strtotime(@date('y-m-d h:i:s')).'_'.rand(100,200)).'.png';
						$logo 			= 'assets/images/shield.png';
						$copy_image 	= 'assets/uploads/megapool_logo/'.$league_image;						
						
						if (!copy($logo, $copy_image)) {
							echo "failed to copy";
						}
					}
					
					
					$string = str_replace(' ', '-', $league_title);
					$string = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
					$url	= hash('sha256', trim(preg_replace('/-+/', '-', $string), '-').'-'.rand(100,200).'-'.md5(@date('Y-m-d h:i:s')));

					$leagueData = array(
									'related_sport_id'	=> implode(',',$sport_id),
									'mega_pool_title' 	=> $league_title,
									'mega_pool_url'		=> strtolower($url),
									'league_logo' 		=> $league_image,
									'created_by' 		=> $user_id,
									'current_status'	=> '2'
									);
					
					if($mega_pool_id = $this->Megapoolmaster_model->save($leagueData)){
						if($selected_league){
							foreach($selected_league as $league){
								$leagueData = array(
												'mega_pool_id'	=> $mega_pool_id,
												'league_id' 	=> $league,
												);

								$this->Megapoolmaster_model->saveMegapoolLeagueRelation($leagueData);
							}
						}

						$response = array('status' => 1,'message' => 'Your megapool created successfully.');
					}else{
						$response = array('status' => 0,'message' => 'Something went wrong, while saving information. Please try again later.');
					}
				}
			}else{
				$response = array('status' => 0,'message' => 'Some informations are missing. Please fill up all informations');
			}
		}else{
			$response = array('status' => 0,'message' => 'Some informations are missing. Please fill up all informations');
		}

		echo json_encode($response);
		die;
	}



	/**
	 * 
	 * Function used to display create account page
	 * 
	 */
	public function edit_megapool(){
		$data = array();

		$this->front_template_inner->set('title', 'Supersportspool :: Edit Megapool');
		$this->front_template_inner->set('header', 'Edit Megapool');	
		$this->front_template_inner->set('action', 'my_megapool');			
		$this->front_template_inner->set('page_icon', 'pe-7s-note');	

		$league_url = $this->uri->segment(2);
		$user_id	= $this->session->userdata('user_id');

		$data['league_details'] = $this->Megapoolmaster_model->getLeagueDetailsByUrlAndCommissionerId($league_url,$user_id);
		$data['sport_list'] 	= $this->Sportmaster_model->getAllActiveSports();

		if($data['league_details']){
			if($data['league_details']['related_sport_id'] !== ''){
				$data['sportId'] = explode(',',$data['league_details']['related_sport_id']);
			}else{
				$data['sportId'] = array();
			}
			
			$data['selected_league'] = $this->Megapoolmaster_model->getAllSelectedLeagueByMegaPoolId($data['league_details']['mega_pool_id']);
			$data['league_list'] 	 = $this->Leaguemaster_model->getAllActiveLeagueBySportId($data['sportId']);
		}

		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/commissioner/megapool/edit_megapool', $data);
	}



	public function update_megapool(){
		if($this->input->post()){
			$sport_id			= $this->input->post('sport_id');
			$league_url			= trim($this->input->post('url'));
			$selected_league 	= $this->input->post('selected_league');
			$old_league_image	= trim($this->input->post('old_league_logo'));
			$league_title		= trim($this->input->post('mega_pool_title'));
			$league_status 		= trim($this->input->post('league_status'));
			//$entry_fee 			= $this->input->post('entry_fee');
			$user_id			= $this->session->userdata('user_id');

			$leagueDetails 		= $this->Megapoolmaster_model->getLeagueDetailsByUrlAndCommissionerId($league_url,$user_id);
			
			if($leagueDetails){
				$league_id = $leagueDetails['mega_pool_id'];

				if($league_title != '' && $selected_league != '' && $sport_id != '' && is_array($sport_id)){
					#Check League name exists
					if($this->Leaguemaster_model->checkLeagueNameExistsWithOutLeagueId($league_title,$league_id)){
						$response = array('status' => 0,'message' => 'League name already exists into this system. Please try with different name.');
					}else{
						#Validate and save league logo
						if($_FILES){
							if(!empty($_FILES['league_logo']["tmp_name"])){
								#check size grater than 1MB
								if($_FILES['league_logo']['size'] > 1000000){
									$response = array('status' => 0,'message' => 'Please upload logo within 1MB.');
								}else{
									$imageName 		= md5(strtotime(@date('y-m-d h:i:s')).'_'.rand(111111,999999));
									$imageFileType 	= pathinfo($_FILES["league_logo"]["name"],PATHINFO_EXTENSION);
									
									if (move_uploaded_file($_FILES["league_logo"]["tmp_name"], 'assets/uploads/megapool_logo/'.$imageName.'.'.$imageFileType)) {
										$league_image = $imageName.'.'.$imageFileType;
										
										unlink('assets/uploads/megapool_logo/'.$old_league_image);
									}
								}
							}else{
								$league_image = $old_league_image;
							}
						}else{
							$league_image = $old_league_image;
						}
	
						//$string = str_replace(' ', '-', $league_title);
						//$string = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
						//$url	= hash('sha256', trim(preg_replace('/-+/', '-', $string), '-').'-'.rand(100,200).'-'.md5(@date('Y-m-d h:i:s')));
						//
						$leagueData = array(
										'related_sport_id'	=> implode(',',$sport_id),
										'mega_pool_title' 	=> $league_title,
										//'mega_pool_url'		=> strtolower($url),
										'league_logo' 		=> $league_image,
										'current_status'	=> $league_status,
										'last_modified_on'	=> @date('Y-m-d h:i:s'),
										'last_modified_by' 	=> $user_id,
										);
						
						if($this->Megapoolmaster_model->update($leagueData,$league_id)){
							if($selected_league){
								$this->Megapoolmaster_model->removeMegapoolLeagueRelation($league_id);

								foreach($selected_league as $league){
									$leagueData = array(
													'mega_pool_id'	=> $league_id,
													'league_id' 	=> $league,
													);
	
									$this->Megapoolmaster_model->saveMegapoolLeagueRelation($leagueData);
								}
							}
	
							$response = array('status' => 1,'message' => 'Your megapool updated successfully.');
						}else{
							$response = array('status' => 0,'message' => 'Something went wrong, while saving information. Please try again later.');
						}
					}
				}else{
					$response = array('status' => 0,'message' => 'Some informations are missing. Please fill up all informations');
				}
			}else{
				$response = array('status' => 1,'message' => 'You dont have access to update this league.');
			}
		}else{
			$response = array('status' => 0,'message' => 'Some informations are missing. Please fill up all informations');
		}

		echo json_encode($response);
		die;
	}
	
	
	
	/**
	 * 
	 * Function used to display megapool details
	 * 
	 */
	public function view_megapool(){
		$data = array();

		$this->front_template_inner->set('title', 'Supersportspool :: View Megapool');
		$this->front_template_inner->set('header', 'View Megapool');	
		$this->front_template_inner->set('action', 'view_megapool');			
		$this->front_template_inner->set('page_icon', 'pe-7s-note');	

		$league_url = $this->uri->segment(2);
		$user_id	= $this->session->userdata('user_id');

		$data['league_details'] = $this->Megapoolmaster_model->getLeagueDetailsByUrlAndCommissionerIdWithoutRestriction($league_url,$user_id);

		if($data['league_details']){
			$data['sport_list'] 		= $this->Megapoolmaster_model->getAllSelectedSports($data['league_details']['mega_pool_id']);
			$data['selected_league'] 	= $this->Megapoolmaster_model->getAllSelectedLeagueDetailsByMegaPoolId($data['league_details']['mega_pool_id']);
			$data['player_league'] 		= $this->Megapoolmaster_model->getAllJoinedPlayersCountByMegaPoolId($data['league_details']['mega_pool_id']);
		}

		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/commissioner/megapool/view_megapool', $data);
	}



	public function publish_megapool(){
		if($this->input->post()){
			$league_url			= trim($this->input->post('url'));
			$user_id			= $this->session->userdata('user_id');

			$leagueDetails 		= $this->Megapoolmaster_model->getLeagueDetailsByUrlAndCommissionerId($league_url,$user_id);
			
			if($leagueDetails){
				$league_id = $leagueDetails['mega_pool_id'];

				$leagueData = array(
					'current_status'	=> '4',
					'last_modified_on'	=> @date('Y-m-d h:i:s'),
					'published_on'		=> @date('Y-m-d h:i:s'),
					'last_modified_by' 	=> $user_id,
					);
	
				if($this->Megapoolmaster_model->update($leagueData,$league_id)){
					$response = array('status' => 1,'message' => 'Your megapool published.');
				}else{
					$response = array('status' => 0,'message' => 'Something went wrong, while saving information. Please try again later.');
				}
			}else{
				$response = array('status' => 1,'message' => 'You dont have access to update this league.');
			}
		}else{
			$response = array('status' => 0,'message' => 'Something went wrong, while saving information. Please try again later.');
		}

		echo json_encode($response);
		die;
	}



	public function remove_megapool(){
		if($this->input->post()){
			$league_url			= trim($this->input->post('url'));
			$user_id			= $this->session->userdata('user_id');

			$leagueDetails 		= $this->Megapoolmaster_model->getLeagueDetailsByUrlAndCommissionerId($league_url,$user_id);
			
			if($leagueDetails){
				$league_id = $leagueDetails['mega_pool_id'];

				$leagueData = array(
								'current_status'	=> '3',
								'last_modified_on'	=> @date('Y-m-d h:i:s'),
								'last_modified_by' 	=> $user_id,
								);
	
				if($this->Megapoolmaster_model->update($leagueData,$league_id)){
					$response = array('status' => 1,'message' => 'Your megapool removed.');
				}else{
					$response = array('status' => 0,'message' => 'Something went wrong, while saving information. Please try again later.');
				}
			}else{
				$response = array('status' => 1,'message' => 'You dont have access to update this league.');
			}
		}else{
			$response = array('status' => 0,'message' => 'Something went wrong, while saving information. Please try again later.');
		}

		echo json_encode($response);
		die;
	}
	
	
	
	function view_standings_table(){
		$data 		= array();
		
		$league_url = $this->uri->segment(2);
		$user_id	= $this->session->userdata('user_id');
		
		$data['league_details'] = $this->Megapoolmaster_model->getPublichedLeagueDetailsByUrlAndCommissionerId($league_url,$user_id);

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
		
		

		$this->load->view('front_end/commissioner/megapool/view_standings_table', $data);
	}
	
	
	public function my_invitation(){
		$userId = $this->session->userdata('user_id');

		$this->front_template_inner->set('title', 'Invitation Management');
		$this->front_template_inner->set('header', 'Invitation Management');
		$this->front_template_inner->set('action', 'my_invitation');
		$this->front_template_inner->set('page_icon', 'pe-7s-note2');
		
		$data = array();
		$config["base_url"] 		= base_url() . "my-invitation";
		$config["total_rows"] 		= $this->Invitationmaster_model->getTotalInvitationCountCommissionerId($userId);
		$config["uri_segment"] 		= 2;
		$config["per_page"] 		= 50;
		$choice 					= $config["total_rows"] / $config["per_page"];
		$config["num_links"] 		= round($choice);
		$config['use_page_numbers'] = true; 
		$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
		$data["invitation_list"] 	= $this->Invitationmaster_model->getAllInvitationByCommissionerId($page,$config["per_page"],$userId);
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
			
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/commissioner/megapool/my_invitation', $data);
	}
	
	
	/**
	 * 
	 * Function used to display invite page
	 * 
	 */
	public function invite_player(){
		$data = array();

		$this->front_template_inner->set('title', 'Supersportspool :: Invite Players');
		$this->front_template_inner->set('header', 'Invite Players');	
		$this->front_template_inner->set('action', 'invite_player');			
		$this->front_template_inner->set('page_icon', 'pe-7s-add-user');	

		$league_url = $this->uri->segment(2);
		$user_id	= $this->session->userdata('user_id');
		
		$data['league_details'] = $this->Megapoolmaster_model->getPublichedLeagueDetailsByUrlAndCommissionerId($league_url,$user_id);

		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/commissioner/megapool/invite_player', $data);
	}
	
	
	
	/**
	 * 
	 * Function used to send invitation
	 * 
	 */
	public function send_invitation(){
		if($this->input->post()){
			$emails 			= $this->input->post('emails');
			$url 				= $this->input->post('url');
			$mailSendArray 		= array();
			$user_id			= $this->session->userdata('user_id');
			$invitation_code 	= hash('sha256', rand(100,200).'-'.md5(@date('Y-m-d h:i:s')));
			
			if(count($emails) > 0){
				$league_details = $this->Megapoolmaster_model->getPublichedLeagueDetailsByUrlAndCommissionerId($url,$user_id);
				
				if($league_details){
					foreach($emails as $email){
						$mailSendArray[] = $email;
						
						$invitationArray = array(
												'invitation_code' 	=> $invitation_code,
												'megapool_id'		=> $league_details['mega_pool_id'],
												'to_email'			=> $email
												);

						$this->Invitationmaster_model->save($invitationArray);
					}
					
					$this->send_invitation_mail($mailSendArray,$invitation_code);
					
					$response = array('status' => 1, 'message' => "Your invitation has been sent.");
				}else{
					$response = array('status' => 0, 'message' => "You don't have permission to make this request!");
				}
			}else{
				$response = array('status' => 0, 'message' => 'Email is blank');
			}
		}else{
			$response = array('status' => 0, 'message' => 'Something went wrong!');
		}

		echo json_encode($response);
		die;
	}



	public function megapool_players(){
		$this->front_template_inner->set('title', 'Megapool Players');
		$this->front_template_inner->set('header', 'Megapool Players');
		$this->front_template_inner->set('action', 'my_megapool');
		$this->front_template_inner->set('page_icon', 'pe-7s-note2');
		
		$league_url = $this->uri->segment(2);
		$user_id	= $this->session->userdata('user_id');
		
		$data = array();
		
		$data['league_details'] = $this->Megapoolmaster_model->getLeagueDetailsByUrlAndCommissionerIdWithoutRestriction($league_url,$user_id);
		
		if($data['league_details']){
			$league_id 					= $data['league_details']['mega_pool_id'];
			$config["base_url"] 		= base_url() . "megapool-players/".$league_url;
			$config["total_rows"] 		= $this->Megapoolmaster_model->getTotalCountOfPlayersByMegapoolLeagueId($league_id);
			$config["uri_segment"] 		= 3;
			$config["per_page"] 		= 20;
			$choice 					= $config["total_rows"] / $config["per_page"];
			$config["num_links"] 		= round($choice);
			$config['use_page_numbers'] = true; 
			$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
			$data["player_list"] 		= $this->Megapoolmaster_model->getAllPlayersByMegapoolLeagueId($page,$config["per_page"],$league_id);
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
		}
			
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/commissioner/megapool/megapool_players', $data);
	}

	/**
	 * 
	 * Function used to get league list by sport id
	 * 
	 */
	function get_related_league_by_sport_id(){
		if($this->input->post()){
			$sport_id		= $this->input->post('sport_id');
			$league_list	= $this->Leaguemaster_model->getAllActiveLeagueBySportId($sport_id);

			if($league_list){
				$response = array('status' => 1,'league_list' => $league_list);
			}else{
				$response = array('status' => 0);
			}
		}else{
			$response = array('status' => 0);
		}

		echo json_encode($response);
		die;
	}



	/**
	 * 
	 * Function used to send account verification mail
	 * 
	 */
	function send_invitation_mail($emails,$invitation_code){
		require_once('./vendor/autoload.php');
	
		$mail = new PHPMailer;
		
        //SMTP configuration
        $mail->isSMTP();
		$mail->setFrom('support@playthemegapool.com', 'Playthemegapool.com support team');
		$mail->Username 	= 'support@playthemegapool.com';
		$mail->Password 	= 'support123!@#';
		$mail->Host     	= 'smtp.mail.us-east-1.awsapps.com';
		$mail->SMTPSecure	= 'ssl';
		$mail->Port    		= 465;
		$mail->SMTPAuth 	= true;
                
        // Add a recipient
		foreach($emails as $email){
			$mail->addAddress($email);
		}

        // Email subject
        $mail->Subject = 'MEGA POOL INVITATION';
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mailContent = "<p>Please click on the below link to join megapool.</p>
						<div style='margin-bottom: 30px;height: 60px;'>
            			<a style='width: 150px;text-decoration: none;padding: 10px;background-color: #3ac47d;border-radius: 4;text-align: center;color: #FFF' href='".base_url()."join-megapool/".$invitation_code."'>
							Join Megapool
						</a>
						<div>
						<div style='margin-top: 20px;color: #FFF;padding: 10px;background-color: orange;border-radius: 6px;'>
							<strong style='color: #222;'>Please Note: </strong> <span> You need a Megapool Account as a player with this email address to accept this invitation.</span>
						</div>";
        $mail->Body = $mailContent;
        
        // Send email
        if(!$mail->send()){
            return 0;
        }else{
            return 1;
		}
    }
	
	
	function sorting($a,$b) {
		return ($a["total_point"] >= $b["total_point"]) ? -1 : 1;
	}
	
	function sortingScore($a,$b) {
		return ($a["standing_score"] >= $b["standing_score"]) ? -1 : 1;
	}
}
