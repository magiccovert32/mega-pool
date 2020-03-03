<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commissioner extends CI_Controller {

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
		
		$this->load->model("Usermaster_model");
	}
	
	
	/**
	 *
	 * Function used to display commissioner list page
	 *
	 */
	public function admin_commissioner_management(){
		$this->admin_template->set('title', 'Commissioners Management');
		$this->admin_template->set('header', 'Commissioners Management');
		$this->admin_template->set('action', 'admin_commissioner_management');
		$this->admin_template->set('page_icon', 'pe-7s-note2');
		
		$data = array();
		$config["base_url"] 		= base_url() . "admin-commissioner-management";
		$config["total_rows"] 		= $this->Usermaster_model->getTotalUserCountForAdmin(1);
		$config["uri_segment"] 		= 2;
		$config["per_page"] 		= 20;
		$choice 					= $config["total_rows"] / $config["per_page"];
		$config["num_links"] 		= round($choice);
		$config['use_page_numbers'] = true; 
		$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
		$data["commissioner_list"] 	= $this->Usermaster_model->getAllUserForAdmin(1,$page,$config["per_page"]);
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
			
		$this->admin_template->load('admin_template', 'contents' , 'admin/commissioner/admin_commissioner_management', $data);
	}
	
	
	/**
	 *
	 * Function used to update profile
	 *
	 */
	public function admin_update_commissioner(){
		if($this->input->post()){
			$user_id			= trim($this->input->post('user_id'));
			$old_profile_image	= trim($this->input->post('old_profile_image'));
			$user_email			= trim($this->input->post('user_email'));
			$full_name 			= trim($this->input->post('full_name'));
			$current_status 	= trim($this->input->post('current_status'));
			$admin_id			= $this->session->userdata('admin_id');
			
			if($full_name != '' && $user_email != ''){
				if($this->Usermaster_model->checkEmailExistsWithOutUserId($user_email,$user_id)){
					$this->session->set_flashdata('item', array('message' => 'Email address already exists. Please try with different email address.','class' => 'danger'));
					redirect(base_url('admin-edit-commissioner/'.$user_id)); 
				}else{
					#Validate and save user image
					if($_FILES){
						if(!empty($_FILES['profile_image']["tmp_name"])){
							#check size grater than 1MB
							if($_FILES['profile_image']['size'] > 1000000){
								$this->session->set_flashdata('item', array('message' => 'Please upload logo within 1MB.','class' => 'danger'));
								redirect(base_url('admin-edit-commissioner/'.$user_id)); 
							}else{
								$imageName 		= md5(strtotime(@date('y-m-d h:i:s')).'_'.rand(111111,999999));
								$imageFileType 	= pathinfo($_FILES["profile_image"]["name"],PATHINFO_EXTENSION);
								
								if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], 'assets/uploads/profile_image/'.$imageName.'.'.$imageFileType)) {
									$user_image = $imageName.'.'.$imageFileType;
									
									if(file_exists('assets/uploads/profile_image/'.$old_profile_image) && $old_profile_image != ''){
										unlink('assets/uploads/profile_image/'.$old_profile_image);
									}
								}else{
									$this->session->set_flashdata('item', array('message' => 'Something went wrong, while uploading logo. Please try again later.','class' => 'danger'));
									redirect(base_url('admin-edit-commissioner/'.$user_id)); 
								}
							}
						}else{
							$user_image = $old_profile_image;
						}
					}else{
						$user_image = $old_profile_image;
					}
	
					$commissionerData = array(
										'user_email' 				=> $user_email,
										'full_name' 				=> $full_name,
										'profile_image' 			=> $user_image,
										'current_status'			=> $current_status,
										'email_verification_link'	=> null,
										'is_email_verified'			=> '1',
										'last_modified_on'			=> @date('Y-m-d h:i:s')
										);
					
					if($this->Usermaster_model->update($commissionerData,$user_id)){
						$this->session->set_flashdata('item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
						redirect(base_url('admin-commissioner-management')); 
					}else{
						$this->session->set_flashdata('item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
						redirect(base_url('admin-edit-commissioner/'.$user_id)); 
					}
				}
			}else{
				$this->session->set_flashdata('item', array('message' => 'Please fill up all informations','class' => 'danger'));
				redirect(base_url('admin-edit-commissioner/'.$user_id)); 
			}
		}else{
			$this->session->set_flashdata('profile_password', array('message' => 'Please fill up all information','class' => 'danger'));
			redirect(base_url('admin-edit-commissioner/'.$user_id)); 
		}
	}
	
	
	
	/**
	 *
	 * Function used to display user edit page
	 *
	 */
	public function admin_edit_commissioner(){
		$data = array();

		$this->admin_template->set('title', 'Edit Commissioner');
		$this->admin_template->set('header', 'Edit Commissioner');
		$this->admin_template->set('action', 'admin_commissioner_management');
		$this->admin_template->set('page_icon', 'pe-7s-note');
		
		$userId = $this->uri->segment(2);
		
		$data['user_details'] = $this->Usermaster_model->getUserDetailsByUserIdByAdmin($userId);
		
		$this->admin_template->load('admin_template', 'contents' , 'admin/commissioner/admin_edit_commissioner', $data);
	}
}
