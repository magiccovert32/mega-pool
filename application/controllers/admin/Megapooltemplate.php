<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Megapooltemplate extends CI_Controller {

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

		$this->load->model("Megapooltemplate_model");
		$this->load->model("Sportmaster_model");
		$this->load->model("Leaguemaster_model");
	}
	
	public function megapool_template(){
		$this->admin_template->set('title', 'League Template Management');
		$this->admin_template->set('header', 'League Template Management');
		$this->admin_template->set('action', 'megapool_template');
		$this->admin_template->set('page_icon', 'pe-7s-note2');
		
		$data = array();
		$config["base_url"] 		= base_url() . "megapool-template";
		$config["total_rows"] 		= $this->Megapooltemplate_model->getTotalTemplateCountForAdmin();
		$config["uri_segment"] 		= 2;
		$config["per_page"] 		= 20;
		$choice 					= $config["total_rows"] / $config["per_page"];
		$config["num_links"] 		= round($choice);
		$config['use_page_numbers'] = true; 
		$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
		$data["template_list"] 		= $this->Megapooltemplate_model->getAllLeagueTemplateForAdmin($page,$config["per_page"]);
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
			
		$this->admin_template->load('admin_template', 'contents' , 'admin/megapool_template/megapool_template', $data);
	}

	/**
	 * 
	 * Function used to display create account page
	 * 
	 */
	public function create_megapool_template(){
		$data = array();

		$this->front_template_inner->set('title', 'Supersportspool :: Create Megapool Template');
		$this->front_template_inner->set('header', 'Create Megapool Template');	
		$this->front_template_inner->set('action', 'create_megapool_template');			
		$this->front_template_inner->set('page_icon', 'pe-7s-plus');	

		$data['sport_list'] = $this->Sportmaster_model->getAllActiveSports();

		$this->front_template_inner->load('admin_template', 'contents' , 'admin/megapool_template/create_megapool', $data);
	}


	/**
	 *
	 * Function used to save megapool 
	 *
	 */
	public function save_megapool_template(){	
		if($this->input->post()){
			$sport_id			= $this->input->post('sport_id');
			$league_title		= trim($this->input->post('mega_pool_title'));
			$selected_league 	= $this->input->post('selected_league');
			$user_id			= $this->session->userdata('user_id');

			if($league_title != '' && $selected_league != '' && $_FILES != null && $sport_id != '' && is_array($sport_id)){
				#Check League name exists
				if($this->Megapooltemplate_model->checkLeagueNameExists($league_title)){
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
								
								if (move_uploaded_file($_FILES["league_logo"]["tmp_name"], 'assets/uploads/megapool_template/'.$imageName.'.'.$imageFileType)) {
									$league_image = $imageName.'.'.$imageFileType;
									
									$leagueData = array(
													'related_sport_id'	=> implode(',',$sport_id),
													'mega_pool_title' 	=> $league_title,
													'league_logo' 		=> $league_image,
													'current_status'	=> '1'
													);
									
									if($mega_pool_id = $this->Megapooltemplate_model->save($leagueData)){
										if($selected_league){
											foreach($selected_league as $league){
												$leagueData = array(
																'mega_pool_id'	=> $mega_pool_id,
																'league_id' 	=> $league,
																);

												$this->Megapooltemplate_model->saveMegapoolLeagueRelation($leagueData);
											}
										}

										$response = array('status' => 1,'message' => 'Your megapool created successfully.');
									}else{
										$response = array('status' => 0,'message' => 'Something went wrong, while saving information. Please try again later.');
									}
								}else{
									$response = array('status' => 0,'message' => 'Something went wrong, while uploading logo. Please try again later.');
								}
							}
						}else{
							$response = array('status' => 0,'message' => 'Some informations are missing. Please fill up all informations');
						}
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
	public function edit_megapool_template(){
		$data = array();

		$this->front_template_inner->set('title', 'Supersportspool :: Edit Megapool');
		$this->front_template_inner->set('header', 'Edit Megapool');	
		$this->front_template_inner->set('action', 'my_megapool');			
		$this->front_template_inner->set('page_icon', 'pe-7s-note');	

		$league_id = $this->uri->segment(2);

		$data['league_details'] = $this->Megapooltemplate_model->getTemplateDetails($league_id);
		$data['sport_list'] 	= $this->Sportmaster_model->getAllActiveSports();
		
		if($data['league_details']){
			if($data['league_details']['related_sport_id'] !== ''){
				$data['sportId'] = explode(',',$data['league_details']['related_sport_id']);
			}else{
				$data['sportId'] = array();
			}
			
			$data['selected_league'] = $this->Megapooltemplate_model->getAllSelectedLeagueByMegaPoolId($data['league_details']['mega_pool_id']);
			$data['league_list'] 	 = $this->Leaguemaster_model->getAllActiveLeagueBySportId($data['sportId']);
		}
		
		$this->front_template_inner->load('admin_template', 'contents' , 'admin/megapool_template/edit_megapool', $data);
	}



	public function update_megapool_template(){
		if($this->input->post()){
			$sport_id			= $this->input->post('sport_id');
			$mega_pool_id		= trim($this->input->post('mega_pool_id'));
			$selected_league 	= $this->input->post('selected_league');
			$old_league_image	= trim($this->input->post('old_league_logo'));
			$league_title		= trim($this->input->post('mega_pool_title'));
			$league_status 		= trim($this->input->post('league_status'));

			$leagueDetails 		= $this->Megapooltemplate_model->getTemplateDetails($mega_pool_id);

			if($leagueDetails){
				$league_id = $leagueDetails['mega_pool_id'];

				if($league_title != '' && $selected_league != '' && $sport_id != '' && is_array($sport_id)){
					#Check League name exists
					if($this->Megapooltemplate_model->checkLeagueNameExistsWithOutLeagueId($league_title,$mega_pool_id)){
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
									
									if (move_uploaded_file($_FILES["league_logo"]["tmp_name"], 'assets/uploads/megapool_template/'.$imageName.'.'.$imageFileType)) {
										$league_image = $imageName.'.'.$imageFileType;
										
										unlink('assets/uploads/megapool_template/'.$old_league_image);
									}
								}
							}else{
								$league_image = $old_league_image;
							}
						}else{
							$league_image = $old_league_image;
						}
	
						$leagueData = array(
										'related_sport_id'	=> implode(',',$sport_id),
										'mega_pool_title' 	=> $league_title,
										'league_logo' 		=> $league_image,
										);
						
						if($this->Megapooltemplate_model->update($leagueData,$league_id)){
							if($selected_league){
								$this->Megapooltemplate_model->removeMegapoolLeagueRelation($league_id);

								foreach($selected_league as $league){
									$leagueData = array(
													'mega_pool_id'	=> $league_id,
													'league_id' 	=> $league,
													);
	
									$this->Megapooltemplate_model->saveMegapoolLeagueRelation($leagueData);
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
}
