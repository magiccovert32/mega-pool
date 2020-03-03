<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sport extends CI_Controller {

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
	}
	
	
	/**
	 *
	 * Function used to display sport list page
	 *
	 */
	public function admin_sport_management(){
		$this->admin_template->set('title', 'Sports Management');
		$this->admin_template->set('header', 'Sports Management');
		$this->admin_template->set('action', 'admin_sport_management');
		$this->admin_template->set('page_icon', 'pe-7s-note2');
		
		$data = array();
		$config["base_url"] 		= base_url() . "admin-sport-management";
		$config["total_rows"] 		= $this->Sportmaster_model->getTotalSportCountForAdmin();
		$config["uri_segment"] 		= 2;
		$config["per_page"] 		= 20;
		$choice 					= $config["total_rows"] / $config["per_page"];
		$config["num_links"] 		= round($choice);
		$config['use_page_numbers'] = true; 
		$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
		$data["sport_list"] 		= $this->Sportmaster_model->getAllSportsForAdmin($page,$config["per_page"]);
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
			
		$this->admin_template->load('admin_template', 'contents' , 'admin/sport/admin_sport_management', $data);
	}
	
	
	/**
	 *
	 * Function used to display sport add page
	 *
	 */
	public function admin_add_sport(){
		$data = array();

		$this->admin_template->set('title', 'Add Sport');
		$this->admin_template->set('header', 'Add Sport');
		$this->admin_template->set('action', 'admin_add_sport');
		$this->admin_template->set('page_icon', 'pe-7s-plus');
		
		$this->admin_template->load('admin_template', 'contents' , 'admin/sport/admin_add_sport', $data);
	}
	
	
	/**
	 *
	 * Function used to save sport data
	 *
	 */
	public function admin_save_sport(){
		if($this->input->post()){			
			$sport_title		= trim($this->input->post('sport_title'));
			$sport_description 	= trim($this->input->post('sport_description'));
			$admin_id			= $this->session->userdata('admin_id');
			
			if($sport_title != '' && $sport_description != '' && $_FILES != null){
				#Check Sport name exists
				if($this->Sportmaster_model->checkSportNameExists($sport_title)){
					$this->session->set_flashdata('sport_item', array('message' => 'Sport name already exists into this system. Please try with different name.','class' => 'danger'));
					redirect(base_url('admin-add-sport')); 
				}else{
					#Validate and save sport logo
					if($_FILES){
						if(!empty($_FILES['sport_logo']["tmp_name"])){
							#check size grater than 1MB
							if($_FILES['sport_logo']['size'] > 1000000){
								$this->session->set_flashdata('sport_item', array('message' => 'Please upload logo within 1MB.','class' => 'danger'));
								redirect(base_url('admin-add-sport')); 
							}else{
								$imageName 		= md5(strtotime(@date('y-m-d h:i:s')).'_'.rand(111111,999999));
								$imageFileType 	= pathinfo($_FILES["sport_logo"]["name"],PATHINFO_EXTENSION);
								
								if (move_uploaded_file($_FILES["sport_logo"]["tmp_name"], 'assets/uploads/sport_logo/'.$imageName.'.'.$imageFileType)) {
									$sport_image = $imageName.'.'.$imageFileType;
									
									$sportData = array(
													'sport_title' 		=> $sport_title,
													'sport_description' => $sport_description,
													'sport_logo' 		=> $sport_image,
													'created_by' 		=> $admin_id,
													);
									
									if($this->Sportmaster_model->save($sportData)){
										$this->session->set_flashdata('sport_item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
										redirect(base_url('admin-sport-management')); 
									}else{
										$this->session->set_flashdata('sport_item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
										redirect(base_url('admin-add-sport')); 
									}
								}else{
									$this->session->set_flashdata('sport_item', array('message' => 'Something went wrong, while uploading logo. Please try again later.','class' => 'danger'));
									redirect(base_url('admin-add-sport')); 
								}
							}
						}else{
							$this->session->set_flashdata('sport_item', array('message' => 'Please fill up all informations','class' => 'danger'));
							redirect(base_url('admin-add-sport')); 
						}
					}
				}
				
			}else{
				$this->session->set_flashdata('sport_item', array('message' => 'Please fill up all informations','class' => 'danger'));
				redirect(base_url('admin-add-sport')); 
			}
		}else{
			$this->session->set_flashdata('profile_item', array('message' => 'Please fill up all informations','class' => 'danger'));
			redirect(base_url('admin-add-sport')); 
		}
	}
	
	
	
	/**
	 *
	 * Function used to update sport details
	 *
	 */
	public function admin_update_sport(){
		if($this->input->post()){
			$sport_id			= trim($this->input->post('sport_id'));
			$old_sport_image	= trim($this->input->post('old_sport_logo'));
			$sport_title		= trim($this->input->post('sport_title'));
			$sport_description 	= trim($this->input->post('sport_description'));
			$sport_status 		= trim($this->input->post('sport_status'));
			$admin_id			= $this->session->userdata('admin_id');
			
			if($sport_title != '' && $sport_description != ''){
				#Check Sport name exists
				if($this->Sportmaster_model->checkSportNameExistsWithOutSportId($sport_title,$sport_id)){
					$this->session->set_flashdata('sport_item', array('message' => 'Sport name already exists into this system. Please try with different name.','class' => 'danger'));
					redirect(base_url('admin-edit-sport/'.$sport_id)); 
				}else{
					#Validate and save sport logo
					if($_FILES){
						if(!empty($_FILES['sport_logo']["tmp_name"])){
							#check size grater than 1MB
							if($_FILES['sport_logo']['size'] > 1000000){
								$this->session->set_flashdata('sport_item', array('message' => 'Please upload logo within 1MB.','class' => 'danger'));
								redirect(base_url('admin-edit-sport/'.$sport_id)); 
							}else{
								$imageName 		= md5(strtotime(@date('y-m-d h:i:s')).'_'.rand(111111,999999));
								$imageFileType 	= pathinfo($_FILES["sport_logo"]["name"],PATHINFO_EXTENSION);
								
								if (move_uploaded_file($_FILES["sport_logo"]["tmp_name"], 'assets/uploads/sport_logo/'.$imageName.'.'.$imageFileType)) {
									$sport_image = $imageName.'.'.$imageFileType;
									
									unlink('assets/uploads/sport_logo/'.$old_sport_image);
								}else{
									$this->session->set_flashdata('sport_item', array('message' => 'Something went wrong, while uploading logo. Please try again later.','class' => 'danger'));
									redirect(base_url('admin-edit-sport/'.$sport_id)); 
								}
							}
						}else{
							$sport_image = $old_sport_image;
						}
					}else{
						$sport_image = $old_sport_image;
					}
					
					$sportData = array(
									'sport_title' 		=> $sport_title,
									'sport_description' => $sport_description,
									'sport_logo' 		=> $sport_image,
									'sport_status' 		=> $sport_status,
									'last_modified_on' 	=> @date('Y-m-d h:i:s'),
									);
					
					if($this->Sportmaster_model->update($sportData,$sport_id)){
						$this->session->set_flashdata('sport_item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
						redirect(base_url('admin-sport-management')); 
					}else{
						$this->session->set_flashdata('sport_item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
						redirect(base_url('admin-edit-sport/'.$sport_id)); 
					}
				}
				
			}else{
				$this->session->set_flashdata('sport_item', array('message' => 'Please fill up all informations','class' => 'danger'));
				redirect(base_url('admin-edit-sport/'.$sport_id)); 
			}
		}else{
			$this->session->set_flashdata('sport_item', array('message' => 'Please fill up all information','class' => 'danger'));
			redirect(base_url('admin-edit-sport/'.$sport_id)); 
		}
	}
	
	
	
	/**
	 *
	 * Function used to display sport edit page
	 *
	 */
	public function admin_edit_sport(){
		$data = array();

		$this->admin_template->set('title', 'Edit Sport');
		$this->admin_template->set('header', 'Edit Sport');
		$this->admin_template->set('action', 'admin_sport_management');
		$this->admin_template->set('page_icon', 'pe-7s-note');
		
		$sportId = $this->uri->segment(2);
		
		$data['sport_details'] = $this->Sportmaster_model->getSportDetailsBySportIdByAdmin($sportId);
		
		$this->admin_template->load('admin_template', 'contents' , 'admin/sport/admin_edit_sport', $data);
	}
}
