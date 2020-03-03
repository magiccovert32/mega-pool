<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Login extends CI_Controller {

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
	}


	
	public function account_login(){
		if ($this->session->userdata('user_session_id') != null) {
            redirect(base_url('home'));
		}
		
		$data = array();

		$this->front_template_login->set('title', 'Mega Pool:: Account Login');
		$this->front_template_login->set('header', 'Account Login');				
		$this->front_template_login->load('front_template_login', 'contents' , 'front_end/auth/login/account_login', $data);
	}
	
	
	
	public function forgot_password(){
		if ($this->session->userdata('user_session_id') != null) {
            redirect(base_url('home'));
		}
		
		$data = array();

		$this->front_template_login->set('title', 'Forgot password');
		$this->front_template_login->set('header', 'Forgot password');				
		$this->front_template_login->load('front_template_login', 'contents' , 'front_end/auth/login/forgot_password', $data);
	}
	
	
	
	public function send_reset_link(){
		if ($this->session->userdata('user_session_id') != null) {
            redirect(base_url('home'));
		}
		
		if($this->input->post()){			
			$login_email	= trim($this->input->post('email'));
			
			if($login_email != ''){
				if (!filter_var($login_email, FILTER_VALIDATE_EMAIL)) {
					$response = array('status' => 0, 'message' => 'Please enter valid email address.');
				}else{
					if($userDetails = $this->Usermaster_model->checkEmailRecordExists($login_email)){
						$reset_link = md5(@date('Y-m-d h:i:s')).'-'.rand(1000,1500).'-'.md5(@date('Y-m-d h:i:s'));
						
						$updateArray = array(
											'reset_link'  => $reset_link
											);

						$this->Usermaster_model->update($updateArray,$userDetails['user_id']);
						$this->send_verification_mail($reset_link,$login_email);
						
						$response = array('status' => 1, 'message' => 'Password reset link has been sent to your email address. Please click on that link to set new password.'); 
					}else{
						$response = array('status' => 0, 'message' => 'We are unable to find your email address into our system. Please check your email address and try again.'); 
					}
				}
			}else{
				$response = array('status' => 0, 'message' => 'Please enter your email address.'); 
			}
		}else{
			$response = array('status' => 0, 'message' => 'Please enter your email address.'); 
		}

		echo json_encode($response);
		die;
	}
	
	
	
	
	public function reset_password(){
		if ($this->session->userdata('user_session_id') != null) {
            redirect(base_url('home'));
		}
		
		$data = array();
		
		$data['link'] = $this->uri->segment(2);

		$this->front_template_login->set('title', 'Reset Password');
		$this->front_template_login->set('header', 'Reset Password');				
		$this->front_template_login->load('front_template_login', 'contents' , 'front_end/auth/login/reset_password', $data);
	}
	
	

	public function update_reset_password(){
		if ($this->session->userdata('user_session_id') != null) {
            redirect(base_url('home'));
		}
		
		if($this->input->post()){			
			$link				= trim($this->input->post('link'));
			$new_password 		= md5(trim($this->input->post('new_password')));
			$confirm_password	= md5(trim($this->input->post('confirm_password')));
			
			if($link != ''){
				if ($new_password != $confirm_password) {
					$response = array('status' => 0, 'message' => "Password and confirm password doesn't match.");
				}else{
					$user_profile_data = array(
											'user_password'	=> $new_password,
											'reset_link'	=> null
											);
	
					if($this->Usermaster_model->updatePasswordByResetLink($user_profile_data,$link)){					
						$response = array('status' => 1, 'message' => 'Password changed successfully.'); 
					}else{
						$response = array('status' => 0, 'message' => 'Password reset link expired or invalid. Please try again later.'); 
					}
				}
			}else{
				$response = array('status' => 0, 'message' => 'Please enter your email address.'); 
			}
		}else{
			$response = array('status' => 0, 'message' => 'Please enter your email address.'); 
		}

		echo json_encode($response);
		die;
	}
	
	

	/**
	 *
	 * Function used to check login 
	 *
	 */
	public function verify_login(){
		if ($this->session->userdata('user_session_id') != null) {
            redirect(base_url('home'));
		}
		
		if($this->input->post()){			
			$login_email 	= trim($this->input->post('email'));
			$login_password = md5(trim($this->input->post('password')));
			
			if($login_email != '' && $login_password != ''){
				if (!filter_var($login_email, FILTER_VALIDATE_EMAIL)) {
					$response = array('status' => 0, 'message' => 'Please enter valid email address.');
				}else{
					$login_result = $this->Usermaster_model->getAuth($login_email,$login_password);
					
					if($login_result){
						if($login_result['current_status'] == 4){
							$response = array('status' => 0, 'message' => 'Email is not verified yet. Please verify your email.');
						}elseif($login_result['current_status'] == 3){
							$response = array('status' => 0, 'message' => 'Your account access has been removed.');
						}elseif($login_result['current_status'] == 2){
							$response = array('status' => 0, 'message' => 'Your account access has been changed to inactive.');
						}elseif($login_result['current_status'] == 1){
							#Successful login
							$generate_session = md5(@date('Y-m-d h:i:s')).md5(rand(2000,4000));
							
							#update login session to database
							$user_session_data = array(
												'user_session_id' 	=> $generate_session,
												'last_login' 		=> @date('Y-m-d h:i:s'),
												);
							
							$this->Usermaster_model->update($user_session_data,$login_result['user_id']);
							
							#Store login session
							$user_session = array(
												'user_session_id' 	=> $generate_session,
												'user_id' 			=> $login_result['user_id'],
												'full_name'			=> $login_result['full_name'],
												'profile_image'		=> $login_result['profile_image'],
												'user_type_id'		=> $login_result['user_type_id']
												);
							
							$this->session->set_userdata($user_session);
							
							$response = array('status' => 1, 'message' => 'Login successful.');
						}else{
							$response = array('status' => 0, 'message' => 'Something went wrong, please contact developer support.');
						}
					}else{
						$response = array('status' => 0, 'message' => 'Invalid login credentials used. Please try again.'); 
					}
				}
			}else{
				$response = array('status' => 0, 'message' => 'Please enter your login information.'); 
			}
		}else{
			$response = array('status' => 0, 'message' => 'Please enter your login information.'); 
		}

		echo json_encode($response);
		die;
	}


	/**
	 *
	 * Function used to logout profile
	 * & clear current login session
	 *
	 */
	public function account_logout(){
		$userId = $this->session->userdata('user_session_id');

		#update login session to database
		$user_session_data = array(
								'user_session_id' 	=> null,
								);

		$this->Usermaster_model->update($user_session_data,$userId);

		$this->session->sess_destroy();
		
		redirect(base_url('account-login')); 
	}
	
	
	
	/**
	 * 
	 * Function used to send account verification mail
	 * 
	 */
	function send_verification_mail($link,$email){
		require_once('./vendor/autoload.php');
	
		$mail = new PHPMailer;
		
        $mail->isSMTP();
        $mail->Host     	= 'email-smtp.us-west-2.amazonaws.com';
        $mail->SMTPAuth 	= true;
        $mail->Username 	= 'AKIAX4SIXGNNHPBQEUPT';
        $mail->Password 	= 'BAWQ8phJv1lOmHH5xeQhIc/tWcfzwYY1Ab90bw2PAfDT';
        $mail->SMTPSecure	= 'tls';
        $mail->Port    		= 587;
        
        $mail->setFrom('debasish.wdc@gmail.com', 'Mega Pool support team');
        
		$mail->addAddress($email);
        $mail->Subject = "Here's how to reset your password.";
        $mail->isHTML(true);
		
        $mailContent = "<p>Please click on the below link to reset password.</p>
            			<a href='".base_url()."reset-password/".$link."'>Reset Password</a>";
        $mail->Body = $mailContent;
        
        if(!$mail->send()){
            return 0;
        }else{
            return 1;
		}
    }
}
