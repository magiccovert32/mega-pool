<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Signup extends CI_Controller {

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

		if ($this->session->userdata('user_session_id') != null) {
            redirect(base_url('home'));
		}

		$this->load->model("Usermaster_model");
		$this->load->model("Playerwallet_model");
	}


	/**
	 * 
	 * Function used to display create account page
	 * 
	 */
	public function create_account(){
		$data = array();

		$this->front_template_login->set('title', 'Supersportspool :: Create Account');
		$this->front_template_login->set('header', 'Create Account');				
		$this->front_template_login->load('front_template_login', 'contents' , 'front_end/auth/signup/create_account', $data);
	}


	/**
	 *
	 * Function used to save account 
	 *
	 */
	public function save_account(){
		if($this->input->post()){	
			$full_name 		= trim($this->input->post('full_name'));	
			$user_type_id 	= trim($this->input->post('user_type_id'));	
			$login_email 	= trim($this->input->post('email'));
			$dob 			= trim($this->input->post('dob'));
			$login_password = md5(trim($this->input->post('password')));
			
			if($login_email != '' && $login_password != '' && $user_type_id != '' && $full_name != '' && $dob != ''){
				if (!filter_var($login_email, FILTER_VALIDATE_EMAIL)) {
					$response = array('status' => 0, 'message' => 'Please enter valid email address.');
				}else{
					$email_exists = $this->Usermaster_model->checkEmailExistsByType($login_email,$user_type_id);
					
					if(!$email_exists){
						#save account information to database
						$user_unique_id 			= md5(@date('Y-m-d h:i:s')).md5(rand(2000,4000));
						$email_verification_link 	= md5(@date('Y-m-d h:i:s')).$user_unique_id.md5(@date('Y-m-d h:i:s'));

						$user_profile_data = array(
											'user_unique_id' 			=> $user_unique_id,
											'user_type_id'				=> $user_type_id,
											'user_email'				=> $login_email,
											'user_password'				=> $login_password,
											'dob'						=> @date('Y-m-d', strtotime($dob)),
											'email_verification_link' 	=> $email_verification_link,
											'full_name'					=> $full_name
											);
						
						if($user_id = $this->Usermaster_model->save($user_profile_data)){
							if($user_type_id == 2){
								$user_wallet_data = array(
														'user_id' 			=> $user_id,
														'wallet_balance'	=> 100,
													);

								$walletId = $this->Playerwallet_model->save($user_wallet_data);

								if($walletId){
									$user_wallet_history = array(
																'wallet_id' 	 		=> $walletId,
																'transaction_amount'	=> 100,
																'transaction_type'		=> '1',
																'transaction_purpose'	=> 'Signup bonus amount received.'
															);

									$walletId = $this->Playerwallet_model->saveWalletHistory($user_wallet_history);
								}
							}

							$this->send_verification_mail($email_verification_link,$login_email);
							$response = array('status' => 1, 'message' => 'Account created successfully. We have sent you a verification link to your email address. Please click on the verification link to verify your account.'); 
						}else{
							$response = array('status' => 0, 'message' => 'Something went wrong while creating your account. Please try again later.'); 
						}
					}else{
						$response = array('status' => 0, 'message' => 'Email already exists. Please try eith another email address.'); 
					}
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
	 *  Function used to verify email address
	 * 
	 * 
	 */
	public function verify_account(){
		$data = array();

		$this->front_template_login->set('title', 'Supersportspool :: Verify Account');
		$this->front_template_login->set('header', 'Verify Account');			

		$link = $this->uri->segment(2);

		$data['verification_status'] = $this->Usermaster_model->verifyEmailAccress($link);

		$this->front_template_login->load('front_template_login', 'contents' , 'front_end/auth/signup/verify_account', $data);
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
        $mail->Subject = 'MEGA POOL ACCOUNT VERIFICATION';
        $mail->isHTML(true);
		
        $mailContent = "<p>Please click on the below link to verify your email address.</p>
            			<a href='".base_url()."verify-account/".$link."'>Verify Account</a>";
        $mail->Body = $mailContent;
        
        if(!$mail->send()){
            return 0;
        }else{
            return 1;
		}
    }
}
