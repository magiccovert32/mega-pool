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

		if ($this->session->userdata('user_type_id') != 2) {
            redirect(base_url('home'));
		}

		$this->load->model("Usermaster_model");
		$this->load->model("Megapoolmaster_model");
		$this->load->model("Sportmaster_model");
		$this->load->model("Leaguemaster_model");
		$this->load->model("Invitationmaster_model");
		$this->load->model("Draftmaster_model");
		$this->load->model("Matchmaster_model");
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
		$this->front_template_inner->set('action', 'my_draft');
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

		$this->front_template_inner->set('title', 'Mega Pool:: Draft');
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
			
			usort($team_score_position, array($this,'sorting'));
			
			$data['team_score_position']	= $team_score_position;
			
			#------------------- END ---------------------
			
			if(!$this->Megapoolmaster_model->checkUserAccessToMegapoolAsPlayer($megapoolId,$user_id)){
				$this->session->set_flashdata('item', array('message' => 'You do not have access to view this page.','class' => 'danger'));	
			}
		}
		
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/player/draft/draft_details', $data);
	}
	
	function sorting($a,$b) 
	{
		return ($a["total_point"] >= $b["total_point"]) ? -1 : 1;
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
}
