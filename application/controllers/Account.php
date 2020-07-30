<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Account extends CI_Controller {

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
		$this->load->model("Usermaster_model");
		
		if ($this->session->userdata('user_session_id') == null) {
            redirect(base_url('account-login'));
		}
	}
	
	public function switch_account(){
		$generate_session 	= md5(@date('Y-m-d h:i:s')).md5(rand(2000,4000));
		$user_id			= $this->session->userdata('user_id');
		
		$userDetails = $this->Usermaster_model->getUserDetailsByUserIdByAdmin($user_id);
		
		if($userDetails){
			$user_type 	= $userDetails['user_type_id'];
			$user_email = $userDetails['user_email'];
			
			if($user_type == 1){
				$another_type = 2;
			}else{
				$another_type = 1;
			}
			
			$userDetails = $this->Usermaster_model->getUserDetailsByUserEmailAndType($user_email,$another_type);
			
			if($userDetails){
				#Store login session
				$user_session = array(
									'user_session_id' 	=> $generate_session,
									'user_id' 			=> $userDetails['user_id'],
									'full_name'			=> $userDetails['full_name'],
									'profile_image'		=> $userDetails['profile_image'],
									'user_type_id'		=> $userDetails['user_type_id']
									);
				
				$this->session->set_userdata($user_session);
				redirect(base_url('my-dashboard'));
			}else{
				redirect(base_url('my-dashboard'));
			}
		}else{
			redirect(base_url('my-dashboard'));
		}		
	}
}
