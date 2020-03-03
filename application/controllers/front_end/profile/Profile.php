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

		if ($this->session->userdata('user_session_id') == null) {
            redirect(base_url('account-login'));
		}

		$this->load->model("Usermaster_model");
	}


	
	public function my_profile(){
		$data = array();

		$data['user_details'] = $this->Usermaster_model->getUserDetailsByUserId($this->session->userdata('user_id'));

		$this->front_template_inner->set('title', 'Mega Pool:: My Profile');
		$this->front_template_inner->set('header', 'My Profile');
		$this->front_template_inner->set('action', 'my_profile');	
		$this->front_template_inner->set('page_icon', 'pe-7s-settings');			
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/profile/my_profile', $data);
	}



	/**
	 *
	 * Function used to update account 
	 *
	 */
	public function update_profile(){	
		if($this->input->post()){	
			$full_name 	= trim($this->input->post('full_name'));	
			$userId 	= $this->session->userdata('user_id');
			
			if($full_name != ''){
				$user_profile_data = array(
										'full_name'	=> $full_name
										);

				if($this->Usermaster_model->update($user_profile_data,$userId)){					
					$response = array('status' => 1, 'message' => 'Profile updated successfully.'); 
				}else{
					$response = array('status' => 0, 'message' => 'Something went wrong while updating your profile. Please try again later.'); 
				}
			}else{
				$response = array('status' => 0, 'message' => 'Please enter all informations.'); 
			}
		}else{
			$response = array('status' => 0, 'message' => 'Please enter all informations.'); 
		}

		echo json_encode($response);
		die;
	}



	/**
	 *
	 * Function used to update password 
	 *
	 */
	public function update_password(){	
		if($this->input->post()){	
			$old_password 	= md5(trim($this->input->post('old_password')));
			$login_password = md5(trim($this->input->post('new_password')));
			$userId 		= $this->session->userdata('user_id');
			
			if($this->Usermaster_model->checkOldPassword($old_password,$userId)){
				if($old_password != '' && $login_password != ''){
					$user_profile_data = array(
											'user_password'	=> $login_password
											);
	
					if($this->Usermaster_model->update($user_profile_data,$userId)){					
						$response = array('status' => 1, 'message' => 'Password changed successfully.'); 
					}else{
						$response = array('status' => 0, 'message' => 'Something went wrong while updating your password. Please try again later.'); 
					}
				}else{
					$response = array('status' => 0, 'message' => 'Please enter all informations.'); 
				}
			}else{
				$response = array('status' => 0, 'message' => 'Old password is wrong.'); 
			}
			
		}else{
			$response = array('status' => 0, 'message' => 'Please enter all informations.'); 
		}

		echo json_encode($response);
		die;
	}
}
