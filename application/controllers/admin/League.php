<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class League extends CI_Controller {

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
	}
	
	
	/**
	 *
	 * Function used to display league list page
	 *
	 */
	public function admin_league_management(){
		$this->admin_template->set('title', 'League Management');
		$this->admin_template->set('header', 'League Management');
		$this->admin_template->set('action', 'admin_league_management');
		$this->admin_template->set('page_icon', 'pe-7s-note2');
		
		$data = array();
		$config["base_url"] 		= base_url() . "admin-league-management";
		$config["total_rows"] 		= $this->Leaguemaster_model->getTotalLeagueCountForAdmin();
		$config["uri_segment"] 		= 2;
		$config["per_page"] 		= 10;
		$choice 					= $config["total_rows"] / $config["per_page"];
		$config["num_links"] 		= round($choice);
		$config['use_page_numbers'] = true; 
		$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
		$data["league_list"] 		= $this->Leaguemaster_model->getAllLeaguesForAdmin($page,$config["per_page"]);
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
			
		$this->admin_template->load('admin_template', 'contents' , 'admin/league/admin_league_management', $data);
	}
	
	
	/**
	 *
	 * Function used to display league add page
	 *
	 */
	public function admin_add_league(){
		$data = array();

		$this->admin_template->set('title', 'Add League');
		$this->admin_template->set('header', 'Add League');
		$this->admin_template->set('action', 'admin_add_league');
		$this->admin_template->set('page_icon', 'pe-7s-plus');
		
		$data['sport_list'] = $this->Sportmaster_model->getAllActiveSports();

		$this->admin_template->load('admin_template', 'contents' , 'admin/league/admin_add_league', $data);
	}
	
	
	/**
	 *
	 * Function used to save league data
	 *
	 */
	public function admin_save_league(){
		if($this->input->post()){
			$sport_id			= trim($this->input->post('sport_id'));
			$league_title		= trim($this->input->post('league_title'));
			$league_description = trim($this->input->post('league_description'));
			$draw_point 		= trim($this->input->post('draw_point'));
			$win_point 			= trim($this->input->post('win_point'));
			$admin_id			= $this->session->userdata('admin_id');
			
			if($league_title != '' && $league_description != '' && $_FILES != null && $sport_id != '' && $win_point != '' && $draw_point != ''){
				#Check League name exists
				if($this->Leaguemaster_model->checkLeagueNameExists($league_title)){
					$this->session->set_flashdata('league_item', array('message' => 'League name already exists into this system. Please try with different name.','class' => 'danger'));
					redirect(base_url('admin-add-league')); 
				}else{
					#Validate and save league logo
					if($_FILES){
						if(!empty($_FILES['league_logo']["tmp_name"])){
							#check size grater than 1MB
							if($_FILES['league_logo']['size'] > 1000000){
								$this->session->set_flashdata('league_item', array('message' => 'Please upload logo within 1MB.','class' => 'danger'));
								redirect(base_url('admin-add-league')); 
							}else{
								$imageName 		= md5(strtotime(@date('y-m-d h:i:s')).'_'.rand(111111,999999));
								$imageFileType 	= pathinfo($_FILES["league_logo"]["name"],PATHINFO_EXTENSION);
								
								if (move_uploaded_file($_FILES["league_logo"]["tmp_name"], 'assets/uploads/league_logo/'.$imageName.'.'.$imageFileType)) {
									$league_image = $imageName.'.'.$imageFileType;
									
									$leagueData = array(
													'related_sport_id'	=> $sport_id,
													'league_title' 		=> $league_title,
													'league_description'=> $league_description,
													'win_point'			=> $win_point,
													'draw_point'		=> $draw_point,
													'league_logo' 		=> $league_image,
													'created_by' 		=> $admin_id,
													);
									
									if($this->Leaguemaster_model->save($leagueData)){
										$this->session->set_flashdata('league_item', array('message' => 'League created successfully.','class' => 'danger'));
										redirect(base_url('admin-league-management')); 
									}else{
										$this->session->set_flashdata('league_item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
										redirect(base_url('admin-add-league')); 
									}
								}else{
									$this->session->set_flashdata('league_item', array('message' => 'Something went wrong, while uploading logo. Please try again later.','class' => 'danger'));
									redirect(base_url('admin-add-league')); 
								}
							}
						}else{
							$this->session->set_flashdata('league_item', array('message' => 'Please fill up all informations','class' => 'danger'));
							redirect(base_url('admin-add-league')); 
						}
					}
				}
			}else{
				$this->session->set_flashdata('league_item', array('message' => 'Please fill up all informations','class' => 'danger'));
				redirect(base_url('admin-add-league')); 
			}
		}else{
			$this->session->set_flashdata('profile_item', array('message' => 'Please fill up all informations','class' => 'danger'));
			redirect(base_url('admin-add-league')); 
		}
	}
	
	
	
	/**
	 *
	 * Function used to update league
	 *
	 */
	public function admin_update_league(){
		if($this->input->post()){
			$sport_id			= trim($this->input->post('sport_id'));
			$league_id			= trim($this->input->post('league_id'));
			$old_league_image	= trim($this->input->post('old_league_logo'));
			$league_title		= trim($this->input->post('league_title'));
			$league_description = trim($this->input->post('league_description'));
			$league_status 		= trim($this->input->post('league_status'));
			$draw_point 		= trim($this->input->post('draw_point'));
			$win_point 			= trim($this->input->post('win_point'));
			$admin_id			= $this->session->userdata('admin_id');
			
			if($league_title != '' && $league_description != '' && $draw_point != '' && $win_point != ''){
				#Check League name exists
				if($this->Leaguemaster_model->checkLeagueNameExistsWithOutLeagueId($league_title,$league_id)){
					$this->session->set_flashdata('league_item', array('message' => 'League name already exists into this system. Please try with different name.','class' => 'danger'));
					redirect(base_url('admin-edit-league/'.$league_id)); 
				}else{
					#Validate and save league logo
					if($_FILES){
						if(!empty($_FILES['league_logo']["tmp_name"])){
							#check size grater than 1MB
							if($_FILES['league_logo']['size'] > 1000000){
								$this->session->set_flashdata('league_item', array('message' => 'Please upload logo within 1MB.','class' => 'danger'));
								redirect(base_url('admin-edit-league/'.$league_id)); 
							}else{
								$imageName 		= md5(strtotime(@date('y-m-d h:i:s')).'_'.rand(111111,999999));
								$imageFileType 	= pathinfo($_FILES["league_logo"]["name"],PATHINFO_EXTENSION);
								
								if (move_uploaded_file($_FILES["league_logo"]["tmp_name"], 'assets/uploads/league_logo/'.$imageName.'.'.$imageFileType)) {
									$league_image = $imageName.'.'.$imageFileType;
									
									unlink('assets/uploads/league_logo/'.$old_league_image);
								}else{
									$this->session->set_flashdata('league_item', array('message' => 'Something went wrong, while uploading logo. Please try again later.','class' => 'danger'));
									redirect(base_url('admin-edit-league/'.$league_id)); 
								}
							}
						}else{
							$league_image = $old_league_image;
						}
					}else{
						$league_image = $old_league_image;
					}
					
					$leagueData = array(
									'related_sport_id'	=> $sport_id,
									'league_title' 		=> $league_title,
									'league_description'=> $league_description,
									'league_logo' 		=> $league_image,
									'league_status' 	=> $league_status,
									'win_point'			=> $win_point,
									'draw_point'		=> $draw_point,
									'last_modified_on' 	=> @date('Y-m-d h:i:s'),
									);
					
					if($this->Leaguemaster_model->update($leagueData,$league_id)){
						$this->session->set_flashdata('league_item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
						redirect(base_url('admin-league-management')); 
					}else{
						$this->session->set_flashdata('league_item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
						redirect(base_url('admin-edit-league/'.$league_id)); 
					}
				}
				
			}else{
				$this->session->set_flashdata('league_item', array('message' => 'Please fill up all informations','class' => 'danger'));
				redirect(base_url('admin-edit-league/'.$league_id)); 
			}
		}else{
			$this->session->set_flashdata('league_item', array('message' => 'Please fill up all information','class' => 'danger'));
			redirect(base_url('admin-edit-league/'.$league_id)); 
		}
	}
	
	
	
	/**
	 *
	 * Function used to display league edit page
	 *
	 */
	public function admin_edit_league(){
		$data = array();

		$this->admin_template->set('title', 'Edit League');
		$this->admin_template->set('header', 'Edit League');
		$this->admin_template->set('action', 'admin_league_management');
		$this->admin_template->set('page_icon', 'pe-7s-note');
		
		$leagueId = $this->uri->segment(2);
		
		$data['league_details'] = $this->Leaguemaster_model->getLeagueDetailsByLeagueIdByAdmin($leagueId);
		$data['sport_list'] 	= $this->Sportmaster_model->getAllActiveSports();
		
		$this->admin_template->load('admin_template', 'contents' , 'admin/league/admin_edit_league', $data);
	}
	
	
	
	/**
	 *
	 * Function used to attatch team with league
	 *
	 *
	 */
	public function admin_attatch_team_with_league(){
		$data = array();

		$this->admin_template->set('title', 'Attatch Team');
		$this->admin_template->set('header', 'Attatch Team');
		$this->admin_template->set('action', 'admin_league_management');
		$this->admin_template->set('page_icon', 'pe-7s-link');
		
		$leagueId = $this->uri->segment(2);
		
		$data['league_details'] = $this->Leaguemaster_model->getLeagueDetailsByLeagueIdByAdmin($leagueId);
		
		if($data['league_details']){
			$sportId 						= $data['league_details']['related_sport_id'];
			$data['attatched_team_list']	= $this->Leaguemaster_model->getAllTeamByLeagueId($leagueId);
			
			$selected_team = array();
			
			if($data['attatched_team_list']){
				foreach($data['attatched_team_list'] as $team){
					$selected_team[] = $team['team_id'];
				}
			}
			
			$data['team_list'] = $this->Leaguemaster_model->getAllTeamByLeagueIdAndWithoutSelectedTeam($sportId,$selected_team);
		}
		
		$this->admin_template->load('admin_template', 'contents' , 'admin/league/admin_attatch_team_with_league', $data);
	}
	
	
	
	/**
	 *
	 * Function used to save team with league
	 *
	 *
	 */
	public function admin_save_league_team_relation(){
		if($this->input->post()){
			$league_id			= $this->input->post('league_id');
			$team_ids			= $this->input->post('team_id');
			$admin_id			= $this->session->userdata('admin_id');
			
			if($league_id != '' && count($team_ids) > 0){
				foreach($team_ids as $id){
					$relationData = array(
										'league_id'	=> $league_id,
										'team_id' 	=> $id,
										'added_by'	=> $admin_id,
										'added_date'=> @date('Y-m-d h:i:s'),
										);
				
					$this->Leaguemaster_model->addLeagueTeamRelation($relationData,$league_id,$id);
				}
			
				$this->session->set_flashdata('league_item', array('message' => 'Team added successfully.','class' => 'success'));
				redirect(base_url('admin-attatch-team-with-league/'.$league_id)); 
			}else{
				$this->session->set_flashdata('league_item', array('message' => 'Please fill up all informations','class' => 'danger'));
				redirect(base_url('admin-attatch-team-with-league/'.$league_id)); 
			}
		}else{
			$this->session->set_flashdata('league_item', array('message' => 'Something went wrong. Please try again later','class' => 'danger'));
			redirect(base_url('admin-league-management')); 
		}
	}
	
	
	
	/**
	 *
	 * Function used to remove team with league
	 *
	 *
	 */
	public function admin_remove_league_team_relation(){
		if($this->input->post()){
			$league_id	= $this->input->post('league_id');
			$team_id	= $this->input->post('teamId');
			
			if($league_id != '' && $team_id != ''){
				if($this->Leaguemaster_model->removeLeagueTeamRelation($league_id,$team_id)){
					$result = array('status' => 1,'message' => 'Removed.');
				}else{
					$result = array('status' => 0,'message' => 'Something went wrong.');
				}
			}else{
				$result = array('status' => 0,'message' => 'Something went wrong.');
			}
		}else{
			$result = array('status' => 0,'message' => 'Something went wrong.');
		}
		
		echo json_encode($result);
		die;
	}
	
	
	
	/**
	 *
	 * Function used to display league position table
	 *
	 */
	public function admin_league_table(){
		$data = array();

		$this->admin_template->set('title', 'League Team Position Table');
		$this->admin_template->set('header', 'League Team Position Table');
		$this->admin_template->set('action', 'admin_league_table');
		$this->admin_template->set('page_icon', 'pe-7s-menu');
		
		$leagueId = $this->uri->segment(2);
		
		$data['league_details'] 		= $this->Leaguemaster_model->getLeagueDetailsByLeagueIdByAdmin($leagueId);
		$data['league_team_count'] 		= $this->Leaguemaster_model->getLeagueTeamCount($leagueId);
		$data['league_team_position'] 	= $this->Leaguemaster_model->getLeagueTeamPosition($leagueId);
		
		$this->admin_template->load('admin_template', 'contents' , 'admin/league/admin_league_table', $data);
	}
	
	
	/**
	 *
	 * Function used to display league position table
	 *
	 */
	public function admin_save_league_team_position_score(){
		if($this->input->post()){
			$league_id	= $this->input->post('league_id');
			$position	= $this->input->post('position');
			
			if(count($position) > 0){
				$league_team_count = $this->Leaguemaster_model->getLeagueTeamCount($league_id);
				
				if($league_team_count > 0){
					$this->Leaguemaster_model->removeLeagueTeamPositionScore($league_id);
					
					for($i=1;$i<=$league_team_count;$i++){
						$j = $i-1;
						
						if(!empty($position[$j])){
							$scoreArray = array(
											'league_id'		=> $league_id,
											'position_id'	=> $i,
											'score'			=> $position[$j]
											);
						}else{
							$scoreArray = array(
											'league_id'		=> $league_id,
											'position_id'	=> $i,
											'score'			=> 0
											);
						}
						
						$this->Leaguemaster_model->saveLeagueTeamPositionScore($scoreArray);
					}
				}
				
				$this->session->set_flashdata('league_item', array('message' => 'Position score saved','class' => 'success'));
				redirect(base_url('admin-league-table/'.$league_id)); 
			}
		}else{
			$this->session->set_flashdata('league_item', array('message' => 'Please fill up all information','class' => 'danger'));
			redirect(base_url('admin-league-table/'.$league_id)); 
		}
	}
	
	
	public function admin_league_standing_table(){
		$data = array();

		$this->admin_template->set('title', 'League Standing Table');
		$this->admin_template->set('header', 'League Standing Table');
		$this->admin_template->set('action', 'admin_league_standing_table');
		$this->admin_template->set('page_icon', 'pe-7s-menu');
		
		$leagueId = $this->uri->segment(2);
		
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
		
		$this->admin_template->load('admin_template', 'contents' , 'admin/league/admin_league_standing_table', $data);
	}
	
	function sorting($a,$b) 
	{
	  return ($a["total_point"] >= $b["total_point"]) ? -1 : 1;
	}
}
