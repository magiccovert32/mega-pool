<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team extends CI_Controller {

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
		$this->load->model("Teammaster_model");
	}
	
	
	/**
	 *
	 * Function used to display team list page
	 *
	 */
	public function admin_team_management(){
		$this->admin_template->set('title', 'Team Management');
		$this->admin_template->set('header', 'Team Management');
		$this->admin_template->set('action', 'admin_team_management');
		$this->admin_template->set('page_icon', 'pe-7s-note2');
		
		$data = array();
		$config["base_url"] 		= base_url() . "admin-team-management";
		$config["total_rows"] 		= $this->Teammaster_model->getTotalTeamCountForAdmin();
		$config["uri_segment"] 		= 2;
		$config["per_page"] 		= 10;
		$choice 					= $config["total_rows"] / $config["per_page"];
		$config["num_links"] 		= round($choice);
		$config['use_page_numbers'] = true; 
		$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
		$data["team_list"] 			= $this->Teammaster_model->getAllTeamsForAdmin($page,$config["per_page"]);
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
			
		$this->admin_template->load('admin_template', 'contents' , 'admin/team/admin_team_management', $data);
	}
	
	
	/**
	 *
	 * Function used to display team add page
	 *
	 */
	public function admin_add_team(){
		$data = array();

		$this->admin_template->set('title', 'Add Team');
		$this->admin_template->set('header', 'Add Team');
		$this->admin_template->set('action', 'admin_add_team');
		$this->admin_template->set('page_icon', 'pe-7s-plus');
		
		$data['sport_list'] = $this->Sportmaster_model->getAllActiveSports();

		$this->admin_template->load('admin_template', 'contents' , 'admin/team/admin_add_team', $data);
	}
	
	
	/**
	 *
	 * Function used to save team data
	 *
	 */
	public function admin_save_team(){
		if($this->input->post()){
			$sport_id			= trim($this->input->post('sport_id'));
			$team_title			= trim($this->input->post('team_title'));
			$team_description 	= trim($this->input->post('team_description'));
			$admin_id			= $this->session->userdata('admin_id');
			
			if($team_title != '' && $team_description != '' && $_FILES != null && $sport_id != ''){
				#Check Team name exists
				if($this->Teammaster_model->checkTeamNameExists($team_title)){
					$this->session->set_flashdata('team_item', array('message' => 'Team name already exists into this system. Please try with different name.','class' => 'danger'));
					redirect(base_url('admin-add-team')); 
				}else{
					#Validate and save team logo
					if($_FILES){
						if(!empty($_FILES['team_logo']["tmp_name"])){
							#check size grater than 1MB
							if($_FILES['team_logo']['size'] > 1000000){
								$this->session->set_flashdata('team_item', array('message' => 'Please upload logo within 1MB.','class' => 'danger'));
								redirect(base_url('admin-add-team')); 
							}else{
								$imageName 		= md5(strtotime(@date('y-m-d h:i:s')).'_'.rand(111111,999999));
								$imageFileType 	= pathinfo($_FILES["team_logo"]["name"],PATHINFO_EXTENSION);
								
								if (move_uploaded_file($_FILES["team_logo"]["tmp_name"], 'assets/uploads/team_logo/'.$imageName.'.'.$imageFileType)) {
									$team_image = $imageName.'.'.$imageFileType;
									
									$teamData = array(
													'related_sport_id'	=> $sport_id,
													'team_title' 		=> $team_title,
													'team_description'	=> $team_description,
													'team_logo' 		=> $team_image,
													'created_by' 		=> $admin_id,
													);
									
									if($this->Teammaster_model->save($teamData)){
										$this->session->set_flashdata('team_item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
										redirect(base_url('admin-team-management')); 
									}else{
										$this->session->set_flashdata('team_item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
										redirect(base_url('admin-add-team')); 
									}
								}else{
									$this->session->set_flashdata('team_item', array('message' => 'Something went wrong, while uploading logo. Please try again later.','class' => 'danger'));
									redirect(base_url('admin-add-team')); 
								}
							}
						}else{
							$this->session->set_flashdata('team_item', array('message' => 'Please fill up all informations','class' => 'danger'));
							redirect(base_url('admin-add-team')); 
						}
					}
				}
			}else{
				$this->session->set_flashdata('team_item', array('message' => 'Please fill up all informations','class' => 'danger'));
				redirect(base_url('admin-add-team')); 
			}
		}else{
			$this->session->set_flashdata('profile_item', array('message' => 'Please fill up all informations','class' => 'danger'));
			redirect(base_url('admin-add-team')); 
		}
	}
	
	
	
	/**
	 *
	 * Function used to update team
	 *
	 */
	public function admin_update_team(){
		if($this->input->post()){
			$sport_id			= trim($this->input->post('sport_id'));
			$team_id			= trim($this->input->post('team_id'));
			$old_team_image		= trim($this->input->post('old_team_logo'));
			$team_title			= trim($this->input->post('team_title'));
			$team_description 	= trim($this->input->post('team_description'));
			$team_status 		= trim($this->input->post('team_status'));
			$admin_id			= $this->session->userdata('admin_id');
			
			if($team_title != '' && $team_description != ''){
				#Check Team name exists
				if($this->Teammaster_model->checkTeamNameExistsWithOutTeamId($team_title,$team_id)){
					$this->session->set_flashdata('team_item', array('message' => 'Team name already exists into this system. Please try with different name.','class' => 'danger'));
					redirect(base_url('admin-edit-team/'.$team_id)); 
				}else{
					#Validate and save team logo
					if($_FILES){
						if(!empty($_FILES['team_logo']["tmp_name"])){
							#check size grater than 1MB
							if($_FILES['team_logo']['size'] > 1000000){
								$this->session->set_flashdata('team_item', array('message' => 'Please upload logo within 1MB.','class' => 'danger'));
								redirect(base_url('admin-edit-team/'.$team_id)); 
							}else{
								$imageName 		= md5(strtotime(@date('y-m-d h:i:s')).'_'.rand(111111,999999));
								$imageFileType 	= pathinfo($_FILES["team_logo"]["name"],PATHINFO_EXTENSION);
								
								if (move_uploaded_file($_FILES["team_logo"]["tmp_name"], 'assets/uploads/team_logo/'.$imageName.'.'.$imageFileType)) {
									$team_image = $imageName.'.'.$imageFileType;
									
									unlink('assets/uploads/team_logo/'.$old_team_image);
								}else{
									$this->session->set_flashdata('team_item', array('message' => 'Something went wrong, while uploading logo. Please try again later.','class' => 'danger'));
									redirect(base_url('admin-edit-team/'.$team_id)); 
								}
							}
						}else{
							$team_image = $old_team_image;
						}
					}else{
						$team_image = $old_team_image;
					}
					
					$teamData = array(
									'related_sport_id'	=> $sport_id,
									'team_title' 		=> $team_title,
									'team_description'	=> $team_description,
									'team_logo' 		=> $team_image,
									'team_status' 		=> $team_status,
									'last_modified_on' 	=> @date('Y-m-d h:i:s'),
									);
					
					if($this->Teammaster_model->update($teamData,$team_id)){
						$this->session->set_flashdata('team_item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
						redirect(base_url('admin-team-management')); 
					}else{
						$this->session->set_flashdata('team_item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
						redirect(base_url('admin-edit-team/'.$team_id)); 
					}
				}
				
			}else{
				$this->session->set_flashdata('team_item', array('message' => 'Please fill up all informations','class' => 'danger'));
				redirect(base_url('admin-edit-team/'.$team_id)); 
			}
		}else{
			$this->session->set_flashdata('team_item', array('message' => 'Please fill up all information','class' => 'danger'));
			redirect(base_url('admin-edit-team/'.$team_id)); 
		}
	}
	
	
	
	/**
	 *
	 * Function used to display team edit page
	 *
	 */
	public function admin_edit_team(){
		$data = array();

		$this->admin_template->set('title', 'Edit Team');
		$this->admin_template->set('header', 'Edit Team');
		$this->admin_template->set('action', 'admin_team_management');
		$this->admin_template->set('page_icon', 'pe-7s-note');
		
		$teamId = $this->uri->segment(2);
		
		$data['team_details'] = $this->Teammaster_model->getTeamDetailsByTeamIdByAdmin($teamId);
		$data['sport_list'] 	= $this->Sportmaster_model->getAllActiveSports();
		
		$this->admin_template->load('admin_template', 'contents' , 'admin/team/admin_edit_team', $data);
	}
}
