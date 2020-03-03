<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Match extends CI_Controller {

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
		
		if ($this->session->userdata('admin_session_id') == null) {
            redirect(base_url('admin-login'));
        }
		
		$this->load->model("Sportmaster_model");
		$this->load->model("Leaguemaster_model");
		$this->load->model("Teammaster_model");
		$this->load->model("Matchmaster_model");
		$this->load->model("Draftmaster_model");
	}
	
	
	/**
	 *
	 * Function used to display league list page
	 *
	 */
	public function admin_match_management(){
		$this->admin_template->set('title', 'Match Management');
		$this->admin_template->set('header', 'Match Management');
		$this->admin_template->set('action', 'admin_match_management');
		$this->admin_template->set('page_icon', 'pe-7s-note2');
		
		$data = array();
		
		$data['league_list'] 		= $this->Leaguemaster_model->getAllActiveLeagues();
		
		if(!empty($_GET['league_id'])){
			$config["base_url"] 		= base_url() . "admin-match-management";
			$config['suffix'] 			= '?' . http_build_query($_GET, '', "&");
			$config["total_rows"] 		= $this->Matchmaster_model->getTotalMatchCountForAdmin($_GET['league_id']);
			$config["uri_segment"] 		= 2;
			$config["per_page"] 		= 20;
			$choice 					= $config["total_rows"] / $config["per_page"];
			$config["num_links"] 		= round($choice);
			$config['use_page_numbers'] = true; 
			$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
			$data["match_list"] 		= $this->Matchmaster_model->getAllMatchForAdmin($page,$config["per_page"],$_GET['league_id']);
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
		}else{
			$data["match_list"] = false;
		}
		
		$this->admin_template->load('admin_template', 'contents' , 'admin/match/admin_match_management', $data);
	}
	
	
	/**
	 *
	 * Function used to display match add page
	 *
	 */
	public function admin_add_match(){
		$data = array();

		$this->admin_template->set('title', 'Create Match');
		$this->admin_template->set('header', 'Create Match');
		$this->admin_template->set('action', 'admin_add_match');
		$this->admin_template->set('page_icon', 'pe-7s-plus');
		
		$data['league_list'] = $this->Leaguemaster_model->getAllActiveLeagues();

		$this->admin_template->load('admin_template', 'contents' , 'admin/match/admin_add_match', $data);
	}
	
	
	/**
	 *
	 * Function used to save league data
	 *
	 */
	public function admin_save_match(){
		if($this->input->post()){
			$league_id			= trim($this->input->post('league_id'));
			$match_date			= trim($this->input->post('match_date'));
			$home_team_id 		= trim($this->input->post('home_team_id'));
			$away_team_id		= trim($this->input->post('away_team_id'));
			$home_team_score	= trim($this->input->post('home_team_score'));
			$away_team_score	= trim($this->input->post('away_team_score'));
			
			if($league_id != '' && $match_date != '' && $home_team_id != '' && $away_team_id != '' && $home_team_score != '' && $away_team_score != ''){
				
				if($home_team_id == $away_team_id){
					$this->session->set_flashdata('league_item', array('message' => 'Both team can not be same','class' => 'danger'));
					redirect(base_url('admin-add-match')); 
				}else{
					$matchData = array(
								'league_id'			=> $league_id,
								'match_url'			=> md5(@date('Y-m-d h:i:s')),
								'match_type'		=> '1',
								'home_team_id' 		=> $home_team_id,
								'away_team_id'		=> $away_team_id,
								'home_team_score' 	=> $home_team_score,
								'match_date'		=> @date('Y-m-d' , strtotime($match_date)),
								'away_team_score' 	=> $away_team_score
								);
				
					#check Match already exists
					if(!$this->Matchmaster_model->checkMatchExists(@date('Y-m-d' , strtotime($match_date)),$home_team_id,$away_team_id)){
						if($this->Matchmaster_model->save($matchData)){
							$this->session->set_flashdata('league_item', array('message' => 'Match created','class' => 'success'));
							redirect(base_url('admin-match-management?league_id='.$league_id)); 
						}else{
							$this->session->set_flashdata('league_item', array('message' => 'Something went wrong , while saving the match.','class' => 'danger'));
							redirect(base_url('admin-add-match')); 
						}
					}else{
						$this->session->set_flashdata('league_item', array('message' => 'Match already exists on selected date','class' => 'danger'));
						redirect(base_url('admin-add-match')); 
					}
				}
			}else{
				$this->session->set_flashdata('league_item', array('message' => 'Please fill up all informations','class' => 'danger'));
				redirect(base_url('admin-add-match')); 
			}
		}else{
			$this->session->set_flashdata('profile_item', array('message' => 'Please fill up all informations','class' => 'danger'));
			redirect(base_url('admin-add-match')); 
		}
	}
	
	
	
	/**
	 *
	 * Function used to display match edit page
	 *
	 */
	public function admin_edit_match(){
		$data = array();

		$this->admin_template->set('title', 'Edit Match');
		$this->admin_template->set('header', 'Edit Match');
		$this->admin_template->set('action', 'admin_match_management');
		$this->admin_template->set('page_icon', 'pe-7s-note');
		
		$matchURL = $this->uri->segment(2);
		
		$data['match_details'] 	= $this->Matchmaster_model->getMatchDetailsByMatchUrl($matchURL);
		
		if($data['match_details']){
			$data['team_list'] 	= $this->Leaguemaster_model->getAllTeamByLeagueId($data['match_details']['league_id']);
		}
		
		$data['league_list']	= $this->Leaguemaster_model->getAllActiveLeagues();
		
		$this->admin_template->load('admin_template', 'contents' , 'admin/match/admin_edit_match', $data);
	}
	
	
	
	/**
	 *
	 * Function used to update league data
	 *
	 */
	public function admin_update_match(){
		if($this->input->post()){
			$match_id			= trim($this->input->post('match_id'));
			$match_url			= trim($this->input->post('match_url'));
			$league_id			= trim($this->input->post('league_id'));
			$match_date			= trim($this->input->post('match_date'));
			$home_team_id 		= trim($this->input->post('home_team_id'));
			$away_team_id		= trim($this->input->post('away_team_id'));
			$home_team_score	= trim($this->input->post('home_team_score'));
			$away_team_score	= trim($this->input->post('away_team_score'));
			$note				= trim($this->input->post('note'));
			
			if($league_id != '' && $match_date != '' && $home_team_id != '' && $away_team_id != '' && $home_team_score != '' && $away_team_score != ''){
				if($home_team_id == $away_team_id){
					$this->session->set_flashdata('league_item', array('message' => 'Both team can not be same','class' => 'danger'));
					redirect(base_url('admin-edit-match/'.$match_url)); 
				}else{
					$matchData = array(
								'league_id'			=> $league_id,
								'match_type'		=> '1',
								'home_team_id' 		=> $home_team_id,
								'away_team_id'		=> $away_team_id,
								'home_team_score' 	=> $home_team_score,
								'match_date'		=> @date('Y-m-d' , strtotime($match_date)),
								'away_team_score' 	=> $away_team_score,
								'note'				=> $note
								);
				
					#check Match already exists
					if(!$this->Matchmaster_model->checkMatchExistsWithOutMatchId(@date('Y-m-d' , strtotime($match_date)),$home_team_id,$away_team_id,$match_id)){
						if($this->Matchmaster_model->update($matchData,$match_id)){
							$this->session->set_flashdata('league_item', array('message' => 'Match created','class' => 'success'));
							redirect(base_url('admin-match-management?league_id='.$league_id)); 
						}else{
							$this->session->set_flashdata('league_item', array('message' => 'Something went wrong , while saving the match.','class' => 'danger'));
							redirect(base_url('admin-add-match')); 
						}
					}else{
						$this->session->set_flashdata('league_item', array('message' => 'Match already exists on selected date','class' => 'danger'));
						redirect(base_url('admin-add-match')); 
					}
				}
			}else{
				$this->session->set_flashdata('league_item', array('message' => 'Please fill up all informations','class' => 'danger'));
				redirect(base_url('admin-add-match')); 
			}
		}else{
			$this->session->set_flashdata('profile_item', array('message' => 'Please fill up all informations','class' => 'danger'));
			redirect(base_url('admin-add-match')); 
		}
	}
	
	
	
	public function admin_remove_match(){
		if($this->input->post()){
			$match_id	= trim($this->input->post('id'));
			
			if($match_id != ''){
				$matchData = array(
								'match_status'	=> '3',
								);
				
				if($this->Matchmaster_model->update($matchData,$match_id)){
					$response = array('status' => 1,'message' => 'Match removed');
				}else{
					$response = array('status' => 0,'message' => 'Something went wrong. Please try again.');
				}
			}else{
				$response = array('status' => 0,'message' => 'Something went wrong. Please try again.');
			}
		}else{
			$response = array('status' => 0,'message' => 'Something went wrong. Please try again.');
		}
		
		echo json_encode($response);
		die;
	}
	
	
	
	public function get_teams_by_league(){
		if($this->input->post()){
			$league_id	= $this->input->post('league_id');
			
			if($league_id != ''){
				if($teams = $this->Leaguemaster_model->getAllTeamByLeagueId($league_id)){
					$result = array('status' => 1,'team_list' => $teams);
				}else{
					$result = array('status' => 0,'team_list' => array());
				}
			}else{
				$result = array('status' => 0,'team_list' => array());
			}
		}else{
			$result = array('status' => 0,'team_list' => array());
		}
		
		echo json_encode($result);
		die;
	}
	
	
	
	public function publish_match(){
		$url = $this->uri->segment(2);
		
		if($url != ''){
			$matchDetails = $this->Matchmaster_model->getMatchDetailsByMatchUrl($url);
			
			if($matchDetails){
				if($matchDetails){
					$leagueDetails = $this->Leaguemaster_model->getLeagueDetailsByLeagueIdByAdmin($matchDetails['league_id']);
					
					if($leagueDetails){
						$win_point 	= $leagueDetails['win_point'];
						$draw_point = $leagueDetails['draw_point'];
					}else{
						$win_point 	= 3;
						$draw_point = 1;
					}
					
					if($matchDetails['is_published'] == 2){
						$matchData = array(
										'is_published' => '1'   
										);
						
						$this->Matchmaster_model->update($matchData,$matchDetails['match_id']);
						
						$this->calculateResult($matchDetails,$win_point,$draw_point);
					
						$result = array('status' => 1,'message' => 'Match published');
					}else{
						$result = array('status' => 0,'message' => 'Match already published!');
					}
				}
			}else{
				$result = array('status' => 0,'message' => 'No match details found!');
			}
		}else{
			$result = array('status' => 0,'message' => 'Something went wrong.Please try again later!');
		}
		
		echo json_encode($result);
		die;
	}
	
	
	
	function calculateResult($matchDetails,$winning_point,$draw_point){
		$match_id 			= $matchDetails['match_id'];
		$league_id 			= $matchDetails['league_id'];
		$home_team_id 		= $matchDetails['home_team_id'];
		$away_team_id 		= $matchDetails['away_team_id'];
		$home_team_score	= $matchDetails['home_team_score'];
		$away_team_score	= $matchDetails['away_team_score'];
		$match_point		= $matchDetails['match_point'];
		$match_date			= $matchDetails['match_date'];
		$losing_point 		= 0;
				
		#check winning team
		if($home_team_score == $away_team_score){
			$team1 = $home_team_id;
			$team2 = $away_team_id;
			
			$this->updateDrawMatch($team1,$draw_point,$match_id,$league_id,$match_date);
			$this->updateDrawMatch($team2,$draw_point,$match_id,$league_id,$match_date);
		}elseif($home_team_score > $away_team_score){
			$w_team = $home_team_id;
			$l_team = $away_team_id;
			
			$this->updateWinningMatch($w_team,$winning_point,$match_id,$league_id,$match_date);
			$this->updateLosingMatch($l_team,$losing_point,$match_id,$league_id,$match_date);
		}elseif($home_team_score < $away_team_score){
			$w_team = $away_team_id;
			$l_team = $home_team_id;
			
			$this->updateWinningMatch($w_team,$winning_point,$match_id,$league_id,$match_date);
			$this->updateLosingMatch($l_team,$losing_point,$match_id,$league_id,$match_date);
		}
	}
	
	
	function updateDrawMatch($team_id,$point,$match_id,$league_id,$match_date){
		$draft_list = $this->Draftmaster_model->checkAllPlayerDraftRelationWithTeamIdAndLeagueId($team_id,$league_id,$match_date);
		
		if($draft_list){
			foreach($draft_list as $draft){
				$relation_id 	= $draft['relation_id'];
				$draft_id 		= $draft['draft_id'];
				$player_id 		= $draft['player_id'];
				$league_id 		= $draft['league_id'];
				
				#check player already got point for this match
				if(!$this->Matchmaster_model->checkPlayerAlreadyGotPointForThisMatch($draft_id,$player_id,$league_id,$match_id)){
					#update player total point
					$getDraftPlayerRelation = $this->Draftmaster_model->getDraftDetailsByDraftRelationId($relation_id);
					
					if($getDraftPlayerRelation){
						$total_point 	= $getDraftPlayerRelation['total_point'];
						$total_point	= $point+$total_point;
						
						$updateDtata = array(
										'total_point' => $total_point
										);
						
						if($this->Draftmaster_model->updateDraftRelationByDraftRelationId($updateDtata,$relation_id)){
							$newPointRecordData = array(
													'player_id' 	=> $player_id,
													'match_id'		=> $match_id,
													'league_id'		=> $league_id,
													'draft_id'		=> $draft_id,
													'point_earned'	=> $point									
													);
							
							$this->Draftmaster_model->savePointHistory($newPointRecordData);
						}
					}
				}
			}
		}
	}
	
	function updateWinningMatch($team_id,$point,$match_id,$league_id,$match_date){
		$draft_list = $this->Draftmaster_model->checkAllPlayerDraftRelationWithTeamIdAndLeagueId($team_id,$league_id,$match_date);
		
		if($draft_list){
			foreach($draft_list as $draft){
				$relation_id 	= $draft['relation_id'];
				$draft_id 		= $draft['draft_id'];
				$player_id 		= $draft['player_id'];
				$league_id 		= $draft['league_id'];
				
				#check player already got point for this match
				if(!$this->Matchmaster_model->checkPlayerAlreadyGotPointForThisMatch($draft_id,$player_id,$league_id,$match_id)){
					
					#update player total point
					$getDraftPlayerRelation = $this->Draftmaster_model->getDraftDetailsByDraftRelationId($relation_id);
					
					if($getDraftPlayerRelation){
						$total_point 	= $getDraftPlayerRelation['total_point'];
						$total_point	= $point+$total_point;
						
						$updateDtata = array(
										'total_point' => $total_point
										);
						
						if($this->Draftmaster_model->updateDraftRelationByDraftRelationId($updateDtata,$relation_id)){
							$newPointRecordData = array(
													'player_id' 	=> $player_id,
													'match_id'		=> $match_id,
													'league_id'		=> $league_id,
													'draft_id'		=> $draft_id,
													'point_earned'	=> $point									
													);
							
							$this->Draftmaster_model->savePointHistory($newPointRecordData);
						}
					}
				}
			}
		}
	}
	
	function updateLosingMatch($team_id,$point,$match_id,$league_id,$match_date){
		$draft_list = $this->Draftmaster_model->checkAllPlayerDraftRelationWithTeamIdAndLeagueId($team_id,$league_id,$match_date);
		
		if($draft_list){
			foreach($draft_list as $draft){
				$relation_id 	= $draft['relation_id'];
				$draft_id 		= $draft['draft_id'];
				$player_id 		= $draft['player_id'];
				$league_id 		= $draft['league_id'];
				
				#check player already got point for this match
				if(!$this->Matchmaster_model->checkPlayerAlreadyGotPointForThisMatch($draft_id,$player_id,$league_id,$match_id)){
					
					#update player total point
					$getDraftPlayerRelation = $this->Draftmaster_model->getDraftDetailsByDraftRelationId($relation_id);
					
					if($getDraftPlayerRelation){
						$total_point 	= $getDraftPlayerRelation['total_point'];
						$total_point	= $point+$total_point;
						
						$updateDtata = array(
										'total_point' => $total_point
										);
						
						if($this->Draftmaster_model->updateDraftRelationByDraftRelationId($updateDtata,$relation_id)){
							$newPointRecordData = array(
													'player_id' 	=> $player_id,
													'match_id'		=> $match_id,
													'league_id'		=> $league_id,
													'draft_id'		=> $draft_id,
													'point_earned'	=> $point									
													);
							
							$this->Draftmaster_model->savePointHistory($newPointRecordData);
						}
					}
				}				
			}
		}
	}
	
	
	public function update_match_point(){
		$getAllPublishedMatch = $this->Matchmaster_model->getAllPublishedMatch();
		
		$win_point 	= 3;
		$draw_point = 1;
		
		if($getAllPublishedMatch){
			foreach($getAllPublishedMatch as $matchDetails){
				$match_id 			= $matchDetails['match_id'];
				$league_id 			= $matchDetails['league_id'];
				$home_team_id 		= $matchDetails['home_team_id'];
				$away_team_id 		= $matchDetails['away_team_id'];
				$home_team_score	= $matchDetails['home_team_score'];
				$away_team_score	= $matchDetails['away_team_score'];
				$match_point		= $matchDetails['match_point'];
				$match_date			= $matchDetails['match_date'];
				$losing_point 		= 0;
				$win_point 			= $matchDetails['win_point'];
				$draw_point 		= $matchDetails['draw_point'];
				
				#check winning team
				if($home_team_score == $away_team_score){
					$team1 = $home_team_id;
					$team2 = $away_team_id;
					
					$this->updateDrawMatch($team1,$draw_point,$match_id,$league_id,$match_date);
					$this->updateDrawMatch($team2,$draw_point,$match_id,$league_id,$match_date);
				}elseif($home_team_score > $away_team_score){
					$w_team = $home_team_id;
					$l_team = $away_team_id;
					
					$this->updateWinningMatch($w_team,$win_point,$match_id,$league_id,$match_date);
					$this->updateLosingMatch($l_team,$losing_point,$match_id,$league_id,$match_date);
				}elseif($home_team_score < $away_team_score){
					$w_team = $away_team_id;
					$l_team = $home_team_id;
					
					$this->updateWinningMatch($w_team,$win_point,$match_id,$league_id,$match_date);
					$this->updateLosingMatch($l_team,$losing_point,$match_id,$league_id,$match_date);
				}
			}
		}
		
		
		redirect(base_url('admin-dashboard'));
	}
}
