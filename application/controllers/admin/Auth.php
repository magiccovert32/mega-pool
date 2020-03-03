<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

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
		
		$this->load->model("Adminconfig_model");
	}
	
	public function admin_login(){
		if ($this->session->userdata('admin_session_id') != null) {
            redirect(base_url('admin-dashboard'));
        }
		
		$data = array();

		$this->admin_login_template->set('title', 'Admin Login');
		$this->admin_login_template->set('header', 'Admin Login');				
		$this->admin_login_template->load('admin_login_template', 'contents' , 'admin/auth/login', $data);
	}
	
	
	/**
	 *
	 * Function used to check admin login 
	 *
	 */
	public function check_auth(){
		if($this->input->post()){			
			$login_email 	= trim($this->input->post('email'));
			$login_password = md5(trim($this->input->post('password')));
			
			if($login_email != '' && $login_password != ''){
				if (!filter_var($login_email, FILTER_VALIDATE_EMAIL)) {
					$this->session->set_flashdata('item', array('message' => 'Invalid email format','class' => 'danger'));
					redirect(base_url('admin-login')); 
				}else{
					$login_result = $this->Adminconfig_model->getAuth($login_email,$login_password);
					
					if($login_result){
						if($login_result['current_status'] == 3){
							$this->session->set_flashdata('item', array('message' => 'Your account access has been removed.','class' => 'danger'));
							redirect(base_url('admin-login')); 
						}elseif($login_result['current_status'] == 2){
							$this->session->set_flashdata('item', array('message' => 'Your account access has been changed to inactive.','class' => 'danger'));
							redirect(base_url('admin-login')); 
						}elseif($login_result['current_status'] == 1){
							#Successful login
							$generate_session = md5(@date('Y-m-d h:i:s')).md5(rand(2000,4000));
							
							#update login session to database
							$user_session_data = array(
												'admin_session_id' 	=> $generate_session,
												'last_login' 		=> @date('Y-m-d h:i:s')
												);
							
							$this->Adminconfig_model->update($user_session_data,$login_result['admin_id']);
							
							#Store login session
							$user_session = array(
												'admin_session_id' 	=> $generate_session,
												'admin_id' 			=> $login_result['admin_id'],
												'admin_profile_name'=> $login_result['profile_name'],
												);
							
							$this->session->set_userdata($user_session);
							
							redirect(base_url('admin-dashboard'), 'refresh'); 
						}else{
							$this->session->set_flashdata('item', array('message' => 'Something went wrong, please contact developer support.','class' => 'danger'));
							redirect(base_url('admin-login')); 
						}
					}else{
						$this->session->set_flashdata('item', array('message' => 'Invalid login credentials used. Please try again.','class' => 'danger'));
						redirect(base_url('admin-login')); 
					}
				}
			}else{
				$this->session->set_flashdata('item', array('message' => 'Please enter your login information','class' => 'danger'));
				redirect(base_url('admin-login')); 
			}
		}else{
			$this->session->set_flashdata('item', array('message' => 'Please enter your login information','class' => 'danger'));
			redirect(base_url('admin-login')); 
		}
	}
	
	
	
	/**
	 *
	 * Function used to logout profile
	 * & clear current login session
	 *
	 */
	public function admin_logout(){
		$this->session->sess_destroy();
		redirect(base_url('admin-login')); 
	}
}
