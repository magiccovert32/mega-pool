<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

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
		
		if ($this->session->userdata('admin_session_id') == null) {
            redirect(base_url('admin-login'));
        }
		
		$this->load->model("Adminconfig_model");
	}
	
	
	/**
	 *
	 * Function used to display profile edit page
	 *
	 */
	public function admin_profile_edit(){
		$data = array();

		$this->admin_template->set('title', 'Update Profile');
		$this->admin_template->set('header', 'Update Profile');
		$this->admin_template->set('action', 'admin_profile_edit');
		$this->admin_template->set('page_icon', 'pe-7s-settings');
		
		$user_id 					= $this->session->userdata('admin_id');
		$data['profile_details'] 	= $this->Adminconfig_model->getProfileDetailsByAdminId($user_id);
		
		$this->admin_template->load('admin_template', 'contents' , 'admin/profile/admin_profile_edit', $data);
	}
	
	
	/**
	 *
	 * Function used to update profile data
	 *
	 */
	public function admin_update_profile(){
		if($this->input->post()){			
			$login_email	= trim($this->input->post('email'));
			$profile_name 	= trim($this->input->post('full_name'));
			
			if($login_email != '' && $profile_name != ''){
				if (!filter_var($login_email, FILTER_VALIDATE_EMAIL)) {
					$this->session->set_flashdata('profile_item', array('message' => 'Invalid email format','class' => 'danger'));
					redirect(base_url('admin-profile-edit')); 
				}else{
					$updateData = array(
									'login_email' => $login_email,
									'profile_name'=> $profile_name
									);
					
					$updateStatus = $this->Adminconfig_model->updateProfileInformation($updateData,$this->session->userdata('admin_id'));
					
					if($updateStatus == 1){
						#Store login session
						$user_session = array(
											'admin_profile_name'=> $profile_name,
											);
						
						$this->session->set_userdata($user_session);
						
						$this->session->set_flashdata('profile_item', array('message' => 'Profile information updated successfully.','class' => 'success'));
						redirect(base_url('admin-profile-edit')); 
					}elseif($updateStatus == 2){
						$this->session->set_flashdata('profile_item', array('message' => 'Email address already taken. Please try with some different email-address','class' => 'danger'));
						redirect(base_url('admin-profile-edit')); 
					}else{
						$this->session->set_flashdata('profile_item', array('message' => 'Something went wrong. Please try again later','class' => 'danger'));
						redirect(base_url('admin-profile-edit')); 
					}
				}
			}else{
				$this->session->set_flashdata('profile_item', array('message' => 'Please fill up all information','class' => 'danger'));
				redirect(base_url('admin-profile-edit')); 
			}
		}else{
			$this->session->set_flashdata('profile_item', array('message' => 'Please fill up all information','class' => 'danger'));
			redirect(base_url('admin-profile-edit')); 
		}
	}
	
	
	
	/**
	 *
	 * Function used to update profile password
	 *
	 */
	public function admin_update_password(){
		if($this->input->post()){			
			$old_password		= trim($this->input->post('old_password'));
			$new_password 		= trim($this->input->post('new_password'));
			$confirm_password 	= trim($this->input->post('confirm_password'));
			$adminId			= $this->session->userdata('admin_id');
			
			if($old_password != '' && $new_password != '' && $confirm_password != ''){
				#check the old password right or wrong
				if (!$this->Adminconfig_model->checkPassword(md5($old_password),$adminId)) {
					$this->session->set_flashdata('profile_password', array('message' => 'You have entered wrong old password.','class' => 'danger'));
					redirect(base_url('admin-profile-edit')); 
				}else{
					if($new_password != $confirm_password){
						$this->session->set_flashdata('profile_password', array('message' => 'New password & confirm password does not match.','class' => 'danger'));
						redirect(base_url('admin-profile-edit')); 
					}else{
						$updateData = array(
										'login_password' => md5($new_password),
										);
						
						if($this->Adminconfig_model->update($updateData,$adminId)){
							$this->session->set_flashdata('profile_password', array('message' => 'Password updated successfully.','class' => 'success'));
							redirect(base_url('admin-profile-edit')); 
						}else{
							$this->session->set_flashdata('profile_password', array('message' => 'Something went wrong while updating your password. Please try again later','class' => 'danger'));
							redirect(base_url('admin-profile-edit'));
						}
					}
				}
			}else{
				$this->session->set_flashdata('profile_password', array('message' => 'Please fill up all information','class' => 'danger'));
				redirect(base_url('admin-profile-edit')); 
			}
		}else{
			$this->session->set_flashdata('profile_password', array('message' => 'Please fill up all information','class' => 'danger'));
			redirect(base_url('admin-profile-edit')); 
		}
	}
}
