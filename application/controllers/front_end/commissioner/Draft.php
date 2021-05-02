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
	}



	/**
	 *
	 * Function used to display commissioner list page
	 *
	 */
	public function my_draft(){
		$userId = $this->session->userdata('user_id');

		$this->front_template_inner->set('title', 'Draft Management');
		$this->front_template_inner->set('header', 'Draft Management');
		$this->front_template_inner->set('action', 'my_draft');
		$this->front_template_inner->set('page_icon', 'pe-7s-note2');
		
		$data = array();
		$config["base_url"] 		= base_url() . "my-draft";
		$config["total_rows"] 		= $this->Draftmaster_model->getTotalDraftCountCommissionerId($userId);
		$config["uri_segment"] 		= 2;
		$config["per_page"] 		= 4;
		$choice 					= $config["total_rows"] / $config["per_page"];
		$config["num_links"] 		= round($choice);
		$config['use_page_numbers'] = true; 
		$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
		$data["draft_list"] 		= $this->Draftmaster_model->getAllDraftByCommissionerId($page,$config["per_page"],$userId);
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
			
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/commissioner/draft/my_draft', $data);
	}



	/**
	 * 
	 * Function used to display create draft page
	 * 
	 */
	public function create_draft(){
		$data = array();

		$this->front_template_inner->set('title', 'Supersportspool :: Create Draft');
		$this->front_template_inner->set('header', 'Create Draft');	
		$this->front_template_inner->set('action', 'create_draft');			
		$this->front_template_inner->set('page_icon', 'pe-7s-plus');
		
		$league_url = $this->uri->segment(2);
		$user_id	= $this->session->userdata('user_id');

		$data['league_details'] = $this->Megapoolmaster_model->getPublichedLeagueDetailsByUrlAndCommissionerId($league_url,$user_id);
		
		if($data['league_details']){
			$data['existing_draft_leagues'] = $this->Draftmaster_model->getAllLeaguesByDraftAndMegapool($data['league_details']['mega_pool_id']);
			$data['selected_league'] 		= $this->Megapoolmaster_model->getRelatedLeagueByMegaPoolId($data['league_details']['mega_pool_id']);
		}
		
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/commissioner/draft/create_draft', $data);
	}
	


	/**
	 *
	 * Function used to save megapool 
	 *
	 */
	public function save_draft(){	
		if($this->input->post()){
			$mega_pool_url			= $this->input->post('mega_pool_url');
			$draft_title			= $this->input->post('draft_title');
			$league_id				= $this->input->post('league_id');
			$team_selection_ends_on = $this->input->post('team_selection_ends_on');
			$user_id				= $this->session->userdata('user_id');
			$selection_timing		= $this->input->post('selection_timing');

			if($draft_title != '' && $mega_pool_url != '' && $league_id != '' && $team_selection_ends_on != null && $team_selection_ends_on != ''){
				
				$league_details = $this->Megapoolmaster_model->getPublichedLeagueDetailsByUrlAndCommissionerId($mega_pool_url,$user_id);
				
				if($league_details){
					$curdate	= strtotime(@date('Y-m-d H:i'));
					$mydate		= strtotime($team_selection_ends_on);
					
					if($curdate > $mydate){
						$response = array('status' => 0,'message' => "Date should be grater than current date time.");
					}else{
						$draftData = array(
										'user_id'				=> $user_id,
										'draft_url' 			=> md5(@date('Y-m-d H:i:s').rand(100,300)),
										'draft_title'			=> $draft_title,
										'megapool_id'			=> $league_details['mega_pool_id'],
										'league_id'				=> $league_id,
										'selection_timing'		=> $selection_timing,
										'team_selection_ends_on'=> @date('Y-m-d H:i:s',strtotime($team_selection_ends_on))
										);
						
						if($this->Draftmaster_model->save($draftData)){
							$response = array('status' => 1,'message' => "Draft created successfully. Now publish to notify your players.");
						}else{
							$response = array('status' => 0,'message' => "Something went wrong , while saving your draft. Please try again later.");
						}
					}
				}else{
					$response = array('status' => 0,'message' => "You don't have access to perform this action.");
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
	
	
	public function remove_draft(){
		if($this->input->post()){
			$draft_url			= trim($this->input->post('url'));
			$user_id			= $this->session->userdata('user_id');

			$draftDetails 		= $this->Draftmaster_model->getDraftDetailsByUrlAndCommissionerId($draft_url,$user_id);
			
			if($draftDetails){
				$draft_id = $draftDetails['draft_id'];

				$draftData = array(
								'draft_status'	=> '3',
								);
	
				if($this->Draftmaster_model->update($draftData,$draft_id)){
					$response = array('status' => 1,'message' => 'Your draft removed.');
				}else{
					$response = array('status' => 0,'message' => 'Something went wrong, while saving information. Please try again later.');
				}
			}else{
				$response = array('status' => 1,'message' => 'You dont have access to update this draft.');
			}
		}else{
			$response = array('status' => 0,'message' => 'Something went wrong, while saving information. Please try again later.');
		}

		echo json_encode($response);
		die;
	}
	
	
	
	public function update_draft(){	
		if($this->input->post()){
			$draft_url				= $this->input->post('draft_url');
			$draft_title			= $this->input->post('draft_title');
			$league_id				= $this->input->post('league_id');
			$team_selection_ends_on = $this->input->post('team_selection_ends_on');
			$user_id				= $this->session->userdata('user_id');
			$selection_timing		= $this->input->post('selection_timing');

			$draft_details	=  $this->Draftmaster_model->getDraftDetailsByUrlAndCommissionerId($draft_url,$user_id);
			
			$curdate	= strtotime(@date('Y-m-d H:i'));
			$mydate		= strtotime($draft_details['team_selection_ends_on']);
			
			if($curdate < $mydate){
				if($draft_title != '' && $league_id != '' && $team_selection_ends_on != null && $team_selection_ends_on != ''){
					$draftDetails 	= $this->Draftmaster_model->getDraftDetailsByUrlAndCommissionerId($draft_url,$user_id);
									
					if($draftDetails){
						$curdate	= strtotime(@date('Y-m-d H:i'));
						$mydate		= strtotime($team_selection_ends_on);
						
						if($curdate > $mydate){
							$response = array('status' => 0,'message' => "Date should be grater than current date time.");
						}else{
							$draftData = array(
											'user_id'				=> $user_id,
											'league_id'				=> $league_id,
											'draft_title'			=> $draft_title,
											'selection_timing'		=> $selection_timing,
											'team_selection_ends_on'=> @date('Y-m-d H:i:s',strtotime($team_selection_ends_on))
											);
							
							if($this->Draftmaster_model->update($draftData,$draftDetails['draft_id'])){
								$response = array('status' => 1,'message' => "Draft updated successfully. Now publish to notify your players.");
							}else{
								$response = array('status' => 0,'message' => "Something went wrong , while saving your draft. Please try again later.");
							}
						}
					}else{
						$response = array('status' => 0,'message' => "You don't have access to perform this action.");
					}				
				}else{
					$response = array('status' => 0,'message' => 'Some informations are missing. Please fill up all informations');
				}
			}else{
				$response = array('status' => 0,'message' => 'Unable to update draft information. Time expired.');
			}			
		}else{
			$response = array('status' => 0,'message' => 'Some informations are missing. Please fill up all informations');
		}

		echo json_encode($response);
		die;
	}
	
	
	
	public function edit_draft(){
		$data = array();

		$this->front_template_inner->set('title', 'Supersportspool :: Edit Draft');
		$this->front_template_inner->set('header', 'Edit Draft');	
		$this->front_template_inner->set('action', 'my_draft');			
		$this->front_template_inner->set('page_icon', 'pe-7s-note');
		
		$draft_url 	= $this->uri->segment(2);
		$user_id	= $this->session->userdata('user_id');

		$data['draft_details'] 	=  $this->Draftmaster_model->getDraftDetailsByUrlAndCommissionerId($draft_url,$user_id);

		if($data['draft_details']){
			$curdate	= strtotime(@date('Y-m-d H:i'));
			$mydate		= strtotime($data['draft_details']['team_selection_ends_on']);
			
			if($curdate < $mydate){
				$data['league_details'] = $this->Megapoolmaster_model->getLeagueDetailsByIdAndCommiossionerId($data['draft_details']['megapool_id'],$user_id);
				
				if($data['league_details']){
					$data['selected_league'] = $this->Megapoolmaster_model->getRelatedLeagueByMegaPoolId($data['league_details']['mega_pool_id']);
				}
			}else{
				$data['draft_details'] = false;
				$data['league_details'] = false;
			}
		}else{
			$data['league_details'] = false;
		}
		
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/commissioner/draft/edit_draft', $data);
	}
	
	
	
	public function add_player(){
		$data = array();

		$this->front_template_inner->set('title', 'Supersportspool :: Add Player');
		$this->front_template_inner->set('header', 'Add Player');	
		$this->front_template_inner->set('action', 'my_draft');			
		$this->front_template_inner->set('page_icon', 'pe-7s-note');
		
		$draft_url 	= $this->uri->segment(2);
		$user_id	= $this->session->userdata('user_id');

		$data['draft_details'] 	=  $this->Draftmaster_model->getDraftDetailsByUrlAndCommissionerIdWithoutCondition($draft_url,$user_id);
	
		if($data['draft_details']){
			$countDownDate 	= new DateTime(@date('Y-m-d H:i:s', strtotime($list['team_selection_ends_on'])));
			$now 			= new DateTime();
			
			if($countDownDate > $now){
				$data['draft_active'] = true;
			}else{
				$data['draft_active'] = false;
			}
			
			$all_megapool_player 	= $this->Leaguemaster_model->getAllLeaguePlayer($data['draft_details']['megapool_id']);
			$all_draft_player 		= $this->Draftmaster_model->getAllDraftPlayer($data['draft_details']['draft_id']);
			
			$existing_player = array();
			
			if($all_draft_player){
				foreach($all_draft_player as $player){
					$existing_player[] = $player['player_id'];
				}
			}
			
			if($all_megapool_player){
				foreach($all_megapool_player as $k => $all_player){
					if(in_array($all_player['user_id'],$existing_player)){
						unset($all_megapool_player[$k]);
					}
				}
			}
			
			$data['all_megapool_player'] = $all_megapool_player;
			
			$data['related_team'] 	= $this->Leaguemaster_model->getAllTeamByLeagueId($data['draft_details']['league_id']);
			$data['selected_team'] 	= $this->Draftmaster_model->getAllSelectedTeamByDraftId($data['draft_details']['draft_id']);

			if($data['selected_team']){
				$data['selected_team'] = explode(',',$data['selected_team']['team_ids']);
			}else{
				$data['selected_team'] = array();
			}
			
			$teamLeftArray = array();
			
			if($data['related_team']){
				foreach($data['related_team'] as $k => $team){
					if(in_array($team['team_id'],$data['selected_team'])){
						unset($data['related_team'][$k]);
					}
				}
			}

			
			
		}else{
			$data['draft_details'] = false;
		}
		
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/commissioner/draft/add_player', $data);
	}
	
	
	
	public function attatch_player_to_draft(){
		if($this->input->post()){
			$draft_url	= $this->input->post('draft_url');
			$player_id	= $this->input->post('player_id');
			$team_id	= $this->input->post('team_id');
			$user_id	= $this->session->userdata('user_id');

			if($draft_url != '' && $player_id != '' && $team_id != ''){
				$draft_details 	=  $this->Draftmaster_model->getDraftDetailsByUrlAndCommissionerIdWithoutCondition($draft_url,$user_id);
			
				if($draft_details){
					$team_selection_ends_on = strtotime($draft_details['team_selection_ends_on']);
					
					$countDownDate 	= new DateTime(@date('Y-m-d h:i:s', strtotime($draft_details['team_selection_ends_on'])));
					$now 			= new DateTime();
					
					if($countDownDate < $now){
						$response = array('status' => 0,'message' => 'Draft already expired you can not make your team selection for this draft.');
					}else{
						$draft_id = $draft_details['draft_id'];
					
						$draftTeamData = array(
											'draft_id'   	=> $draft_id,
											'player_id'		=> $player_id,
											'team_id'		=> $team_id
											);
						
						if($this->Draftmaster_model->saveDraftPlayerRelation($draftTeamData,$player_id,$draft_id)){
							$response = array('status' => 1,'message' => 'Successfully submitted.');
						}else{
							$response = array('status' => 0,'message' => 'Something went wrong, while saving your information.Please try again later.');
						}
					}
				}else{
					$response = array('status' => 0,'message' => 'You do not have access to perform this request!');
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
	
	
	
	public function view_draft(){
		$data = array();

		$this->front_template_inner->set('title', 'Supersportspool :: View Draft');
		$this->front_template_inner->set('header', 'Draft Information');	
		$this->front_template_inner->set('action', 'my_draft');			
		$this->front_template_inner->set('page_icon', 'pe-7s-note');
		
		$draft_url 	= $this->uri->segment(2);
		$user_id	= $this->session->userdata('user_id');

		$data['draft_details'] 	=  $this->Draftmaster_model->getDraftDetailsByUrlAndCommissionerIdWithoutCondition($draft_url,$user_id);
		
		if($data['draft_details']){
			$data['league_details'] = $this->Megapoolmaster_model->getLeagueDetailsByIdAndCommiossionerId($data['draft_details']['megapool_id'],$user_id);
			$data['player_joined'] = $this->Megapoolmaster_model->getPlayerCountInDraft($data['draft_details']['megapool_id'],$user_id);

			if($data['league_details']){
				$data['team_list'] = $this->Leaguemaster_model->getAllTeamByLeagueId($data['draft_details']['league_id']);
			}
			
			$data['selected_team_ids'] = $this->Draftmaster_model->getAllSelectedTeamByDraftId($data['draft_details']['draft_id']);
			
			if($data['selected_team_ids']){
				$data['selected_team_ids'] = explode(',',$data['selected_team_ids']);
			}else{
				$data['selected_team_ids'] = array();
			}
		}else{
			$data['league_details'] = false;
			$data['team_list'] = false;
		}
		
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/commissioner/draft/view_draft', $data);
	}
	
	
	
	public function publish_draft(){
		if($this->input->post()){
			$draft_url	= $this->input->post('url');
			$user_id	= $this->session->userdata('user_id');
			
			if($draft_url != ''){
				$draftDetails 	= $this->Draftmaster_model->getDraftDetailsByUrlAndCommissionerId($draft_url,$user_id);
								
				if($draftDetails){
					$draft_id = $draftDetails['draft_id'];

					$draftData = array(
									'draft_status'	=> '4',
									);
		
					if($this->Draftmaster_model->update($draftData,$draft_id)){
						$this->send_draft_mail($draft_url,$user_id);
						$response = array('status' => 1,'message' => 'Your draft published.');
					}else{
						$response = array('status' => 0,'message' => 'Something went wrong, while saving information. Please try again later.');
					}
				}else{
					$response = array('status' => 0,'message' => "You don't have access to perform this action.");
				}				
			}else{
				$response = array('status' => 0,'message' => "You don't have access to perform this action.");
			}
		}else{
			$response = array('status' => 0,'message' => "You don't have access to perform this action.");
		}

		echo json_encode($response);
		die;
	}
	
	
	
	/**
	 * 
	 * Function used to send draft mail
	 * 
	 */
	function send_draft_mail($draft_url,$user_id){
		$draftDetails 	= $this->Draftmaster_model->getDraftBriefDetailsByUrlAndCommissionerId($draft_url,$user_id);
		
		$players = false;
		
		if($draftDetails){
			$players = $this->Megapoolmaster_model->getPlayerListByMegapoolId($draftDetails['megapool_id']);
		}
		
		if($players){
			require_once('./vendor/autoload.php');
	
			$mail = new PHPMailer;
			
			$mail->isSMTP();
			$mail->setFrom('support@playthemegapool.com', 'Playthemegapool.com support team');
			$mail->Username 	= 'support@playthemegapool.com';
			$mail->Password 	= 'support123!@#';
			$mail->Host     	= 'smtp.mail.us-east-1.awsapps.com';
			$mail->SMTPSecure	= 'ssl';
			$mail->Port    		= 465;
			$mail->SMTPAuth 	= true;
			
			// Add a recipient
			foreach($players as $player){
				$mail->addAddress($player['user_email']);
			}
	
			// Email subject
			$mail->Subject = 'MEGA POOL DRAFT INVITATION';
			
			// Set email format to HTML
			$mail->isHTML(true);
			
			// Email body content
			$mailContent = "<p>Please click on the below link to select your team.</p>
							<div style='margin-bottom: 30px;height: 60px;'>
								<a style='width: 150px;text-decoration: none;padding: 10px;background-color: #3ac47d;border-radius: 4;text-align: center;color: #FFF' href='".base_url()."draft/".$draftDetails['draft_url']."'>
									Choose Team
								</a>
							</div>";
			$mail->Body = $mailContent;
			
			// Send email
			if(!$mail->send()){
				return 0;
			}else{
				return 1;
			}
		}else{
			return 1;
		}
    }
}
