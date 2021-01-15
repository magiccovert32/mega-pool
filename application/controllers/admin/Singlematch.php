<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Singlematch extends CI_Controller {

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
		$this->load->model("Singlematchmaster_model");
		$this->load->model("Draftmaster_model");
	}
	
	
	/**
	 *
	 * Function used to display league list page
	 *
	 */
	public function admin_single_match_management(){
		$this->admin_template->set('title', 'Match Management');
		$this->admin_template->set('header', 'Match Management');
		$this->admin_template->set('action', 'admin_single_match_management');
		$this->admin_template->set('page_icon', 'pe-7s-note2');
		
		$data = array();
		
		$data['league_list'] = $this->Leaguemaster_model->getAllSingleActiveLeagues();
		
		if(!empty($_GET['league_id'])){
			$team_name					= @$_GET['team_name'];
			$config["base_url"] 		= base_url() . "admin-single-match-management";
			$config['suffix'] 			= '?' . http_build_query($_GET, '', "&");
			$config["total_rows"] 		= $this->Singlematchmaster_model->getTotalMatchCountForAdmin($_GET['league_id'],$team_name);
			$config["uri_segment"] 		= 2;
			$config["per_page"] 		= 100;
			$choice 					= $config["total_rows"] / $config["per_page"];
			$config["num_links"] 		= round($choice);
			$config['use_page_numbers'] = true; 
			$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
			$data["match_list"] 		= $this->Singlematchmaster_model->getAllMatchForAdmin($page,$config["per_page"],$_GET['league_id'],$team_name);
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
		
		$this->admin_template->load('admin_template', 'contents' , 'admin/singlematch/admin_single_match_management', $data);
	}
	
	
	/**
	 *
	 * Function used to display match add page
	 *
	 */
	public function admin_single_add_match(){
		$data = array();

		$this->admin_template->set('title', 'Create Match');
		$this->admin_template->set('header', 'Create Match');
		$this->admin_template->set('action', 'admin_single_add_match');
		$this->admin_template->set('page_icon', 'pe-7s-plus');
		
		$data['league_list'] = $this->Leaguemaster_model->getAllSingleActiveLeagues();

		$this->admin_template->load('admin_template', 'contents' , 'admin/singlematch/admin_single_add_match', $data);
	}
	
	
	/**
	 *
	 * Function used to save league data
	 *
	 */
	public function admin_single_save_match(){
		if($this->input->post()){
			$league_id		= trim($this->input->post('league_id'));
			$match_date		= trim($this->input->post('match_date'));
			$team_id 		= trim($this->input->post('team_id'));
			$match_point	= trim($this->input->post('match_point'));
			
			if($league_id != '' && $match_date != '' && $team_id != '' && $match_point != ''){
				$matchData = array(
								'league_id'			=> $league_id,
								'match_url'			=> md5(@date('Y-m-d h:i:s')),
								'team_id' 			=> $team_id,
								'match_point'		=> $match_point,
								'match_date'		=> @date('Y-m-d' , strtotime($match_date)),
								);
				
				#check Match already exists
				if(!$this->Singlematchmaster_model->checkSingleMatchExists(@date('Y-m-d' , strtotime($match_date)),$team_id)){
					if($this->Singlematchmaster_model->save($matchData)){
						$this->session->set_flashdata('league_item', array('message' => 'Match created','class' => 'success'));
						redirect(base_url('admin-single-match-management?league_id='.$league_id)); 
					}else{
						$this->session->set_flashdata('league_item', array('message' => 'Something went wrong , while saving the match.','class' => 'danger'));
						redirect(base_url('admin-single-add-match')); 
					}
				}else{
					$this->session->set_flashdata('league_item', array('message' => 'Record already exists on selected date','class' => 'danger'));
					redirect(base_url('admin-single-add-match')); 
				}
			}else{
				$this->session->set_flashdata('league_item', array('message' => 'Please fill up all informations','class' => 'danger'));
				redirect(base_url('admin-single-add-match')); 
			}
		}else{
			$this->session->set_flashdata('profile_item', array('message' => 'Please fill up all informations','class' => 'danger'));
			redirect(base_url('admin-single-add-match')); 
		}
	}
	
	
	
	/**
	 *
	 * Function used to display match edit page
	 *
	 */
	public function admin_single_edit_match(){
		$data = array();

		$this->admin_template->set('title', 'Edit Match');
		$this->admin_template->set('header', 'Edit Match');
		$this->admin_template->set('action', 'admin_single_match_management');
		$this->admin_template->set('page_icon', 'pe-7s-note');
		
		$matchURL = $this->uri->segment(2);
		
		$data['match_details'] 	= $this->Singlematchmaster_model->getMatchDetailsByMatchUrl($matchURL);
		
		if($data['match_details']){
			$data['team_list'] 	= $this->Leaguemaster_model->getAllTeamByLeagueId($data['match_details']['league_id']);
		}
		
		$data['league_list']	= $this->Leaguemaster_model->getAllSingleActiveLeagues();
		
		$this->admin_template->load('admin_template', 'contents' , 'admin/singlematch/admin_single_edit_match', $data);
	}
	
	
	
	/**
	 *
	 * Function used to update league data
	 *
	 */
	public function admin_single_update_match(){
		if($this->input->post()){
			$league_id		= trim($this->input->post('league_id'));
			$match_date		= trim($this->input->post('match_date'));
			$team_id 		= trim($this->input->post('team_id'));
			$match_point	= trim($this->input->post('match_point'));
			$match_id		= trim($this->input->post('match_id'));
			$match_url		= trim($this->input->post('match_url'));

			if($league_id != '' && $match_date != '' && $team_id != '' && $match_point != ''){
				$matchData = array(
								'league_id'		=> $league_id,
								'match_url'		=> md5(@date('Y-m-d h:i:s')),
								'team_id' 		=> $team_id,
								'match_point'	=> $match_point,
								'match_date'	=> @date('Y-m-d' , strtotime($match_date)),
							);
			
				#check Match already exists
				if(!$this->Singlematchmaster_model->checkMatchExistsWithOutMatchId(@date('Y-m-d' , strtotime($match_date)),$team_id,$match_id)){
					if($this->Singlematchmaster_model->update($matchData,$match_id)){
						$this->session->set_flashdata('league_item', array('message' => 'Match created','class' => 'success'));
						redirect(base_url('admin-single-match-management?league_id='.$league_id)); 
					}else{
						$this->session->set_flashdata('league_item', array('message' => 'Something went wrong , while saving the match.','class' => 'danger'));
						redirect(base_url('admin-single-add-match')); 
					}
				}else{
					$this->session->set_flashdata('league_item', array('message' => 'Record already exists on selected date','class' => 'danger'));
					redirect(base_url('admin-single-add-match')); 
				}
			}else{
				$this->session->set_flashdata('league_item', array('message' => 'Please fill up all informations','class' => 'danger'));
				redirect(base_url('admin-single-add-match')); 
			}
		}else{
			$this->session->set_flashdata('profile_item', array('message' => 'Please fill up all informations','class' => 'danger'));
			redirect(base_url('admin-single-add-match')); 
		}
	}
	
	
	public function admin_single_remove_match(){
		if($this->input->post()){
			$match_id	= trim($this->input->post('id'));
			
			if($match_id != ''){
				$matchData = array(
								'match_status'	=> '3',
								);
				
				if($this->Singlematchmaster_model->update($matchData,$match_id)){
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
	
	
	public function publish_single_match(){
		$url = $this->uri->segment(2);
		
		if($url != ''){
			$matchDetails = $this->Singlematchmaster_model->getMatchDetailsByMatchUrl($url);
			
			if($matchDetails){
				if($matchDetails){
					$leagueDetails = $this->Leaguemaster_model->getLeagueDetailsByLeagueIdByAdmin($matchDetails['league_id']);
					
					if($matchDetails['is_published'] == 2){
						$matchData = array(
										'is_published' => '1'   
										);
						
						$this->Singlematchmaster_model->update($matchData,$matchDetails['match_id']);
											
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
	
	
	public function update_single_match_point(){
		$getAllPublishedMatch = $this->Singlematchmaster_model->getAllPublishedMatch();
		
		if($getAllPublishedMatch){
			foreach($getAllPublishedMatch as $match){
				$record 			= $this->Draftmaster_model->getPlayerDraftRelationWithTeamIDAndLeagueId($match['team_id'],$match['league_id']);
				$player_total_point = $this->Singlematchmaster_model->getPlayerTotalPointByLeagueId($match['team_id'],$match['league_id']);
				$player_match_point = $this->Singlematchmaster_model->getPlayerMatchPointByMatchId($match['team_id'],$match['match_id']);
				
				if($record){
					foreach($record as $relation){
						if($player_total_point){
							$updateDtata = 	array(
												'total_point' => $player_total_point
												);

							if($this->Draftmaster_model->updateDraftRelationByDraftRelationId($updateDtata,$relation['relation_id'])){
								$newPointRecordData = array(
														'player_id' 	=> $relation['player_id'],
														'match_id'		=> $match['match_id'],
														'league_id'		=> $match['league_id'],
														'draft_id'		=> $relation['draft_id'],
														'point_earned'	=> $player_match_point									
														);
								
								$this->Draftmaster_model->savePointHistory($newPointRecordData);
							}
						}
					}
				}
			}
		}
		
		redirect(base_url('admin-dashboard'));
	}
}
