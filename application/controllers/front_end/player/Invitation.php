<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Invitation extends CI_Controller {

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
		
		$route = $this->uri->segment(1);

		if ($this->session->userdata('user_session_id') == null) {
            redirect(base_url('account-login'));
		}

		if($route == 'join-megapool'){
			if ($this->session->userdata('user_type_id') != 2) {
				$this->session->sess_destroy();
				redirect(base_url('account-login'));
			}
		}

		$this->load->model("Usermaster_model");
		$this->load->model("Invitationmaster_model");
		$this->load->model("Megapoolmaster_model");
		$this->load->model("Playerwallet_model");
	}



	/**
	 *
	 * Function used to display invitation list page
	 *
	 */
	public function invitations(){
		$userId = $this->session->userdata('user_id');

		$this->front_template_inner->set('title', 'Invitations');
		$this->front_template_inner->set('header', 'Invitations');
		$this->front_template_inner->set('action', 'invitations');
		$this->front_template_inner->set('page_icon', 'pe-7s-star');
		
		$data = array();
		
		$userDetails 	= $this->Usermaster_model->getUserDetailsByUserId($userId);
		$email			= $userDetails['user_email'];
		
		$config["base_url"] 		= base_url() . "all-megapool";
		$config["total_rows"] 		= $this->Invitationmaster_model->getTotalCountInvitationListByUserEmail($email);
		$config["uri_segment"] 		= 2;
		$config["per_page"] 		= 10;
		$choice 					= $config["total_rows"] / $config["per_page"];
		$config["num_links"] 		= round($choice);
		$config['use_page_numbers'] = true; 
		$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
		$data["invitation_list"] 	= $this->Invitationmaster_model->getInvitationListByUserEmail($page,$config["per_page"],$email);
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
			
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/player/invitation/invitations', $data);
	}



	public function megapool_preview(){
		$data = array();

		$this->front_template_inner->set('title', 'Preview');
		$this->front_template_inner->set('header', 'Preview');
		$this->front_template_inner->set('action', 'megapool_preview');
		$this->front_template_inner->set('page_icon', 'pe-7s-note');
		
		$leagueUrl = $this->uri->segment(2);
		
		$data['league_details'] = $this->Megapoolmaster_model->getLeagueDetailsByUrl($leagueUrl);
		
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/player/megapool/megapool_preview', $data);
	}
	
	
	
	public function join_megapool(){
		$data = array();

		$this->front_template_inner->set('title', 'Invitation');
		$this->front_template_inner->set('header', 'Invitation');
		$this->front_template_inner->set('action', 'join_megapool');
		$this->front_template_inner->set('page_icon', 'pe-7s-note');
		
		$invitationUrl 	= $this->uri->segment(2);
		$user_id		= $this->session->userdata('user_id');
		$userDetails 	= $this->Usermaster_model->getUserDetailsByUserId($user_id);
		$email			= $userDetails['user_email'];
		
		$data['invitation_details'] = $this->Invitationmaster_model->getInvitationDetails($invitationUrl,$email);
		
		if($data['invitation_details']){
			$data['total_player'] = $this->Megapoolmaster_model->getTotalPlayerCountByLeagueId($data['invitation_details']['mega_pool_id']);
		}
		
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/player/invitation/join_megapool', $data);
	}
	
	
	
	public function accept_invitation(){
		if($this->input->post()){
			$leagueUrl 	= $this->input->post('leagueUrl');
			$user_id	= $this->session->userdata('user_id');

			$league_details = $this->Megapoolmaster_model->getLeagueDetailsByUrl($leagueUrl);
			
			if($league_details){
				$wallet_details = $this->Playerwallet_model->getWallet($user_id);
				$userDetails 	= $this->Usermaster_model->getUserDetailsByUserId($user_id);
				$email			= $userDetails['user_email'];
				
				#check user invitation
				$invitationCheck = $this->Invitationmaster_model->checkInvitationByLeagueIdAndUserEmail($email,$league_details['mega_pool_id']);
				
				if($invitationCheck){
					$data = array(
								'invitation_accepted'  => 1
							);

					if($this->Invitationmaster_model->updateInvitationStatus($email,$data,$league_details['mega_pool_id'])){
						$joinData = array(
										'megapool_id' 	=> $league_details['mega_pool_id'],
										'player_id' 	=> $user_id,
										);
						
						if($this->Megapoolmaster_model->savePlayerRelation($joinData,$league_details['mega_pool_id'],$user_id)){
							
							#update wallet
							//$newWalletBalance = $wallet_details['wallet_balance'] - $league_details['entry_fee'];
							//
							//$walletData = array(
							//				'wallet_balance' => $newWalletBalance,
							//				);
							//
							//$this->Playerwallet_model->updateWallet($walletData,$user_id);
							
							#insert wallet transaction data
							$transaction_id	= md5(@date('Y-m-d h:i:d').rand(100,300));
							
							$user_wallet_history = array(
														'transaction_id'		=> $transaction_id,
														'wallet_id' 	 		=> $wallet_details['player_wallet_id'],
														//'transaction_amount'	=> $league_details['entry_fee'],
														'transaction_type'		=> '2',
														'megapool_id'			=> $league_details['mega_pool_id'],
														'transaction_purpose'	=> 'Megapool - '.$league_details['mega_pool_title'].' joining fee'
													);

							$walletId = $this->Playerwallet_model->saveWalletHistory($user_wallet_history);
							
							$response = array('status' => 1,'message' => 'Congratulation , you joined the league');
						}else{
							$response = array('status' => 0,'message' => 'You are already in this league.');
						}
					}else{
						$response = array('status' => 0,'message' => 'You are not allowed to join this league.');
					}
				}else{
					$response = array('status' => 0,'message' => 'You are not allowed to join this league.');
				}
			}else{
				$response = array('status' => 0,'message' => 'You are not allowed to execute this action.');
			}
		}else{
			$response = array('status' => 0,'message' => 'You are not allowed to execute this action.');
		}

		echo json_encode($response);
		die;
	}
	
	
	
	public function reject_invitation(){
		if($this->input->post()){
			$leagueUrl 	= $this->input->post('leagueUrl');
			$user_id	= $this->session->userdata('user_id');

			$league_details = $this->Megapoolmaster_model->getLeagueDetailsByUrl($leagueUrl);
			
			if($league_details){
				$userDetails 	= $this->Usermaster_model->getUserDetailsByUserId($user_id);
				$email			= $userDetails['user_email'];
				
				#check user invitation
				$invitationCheck = $this->Invitationmaster_model->checkInvitationByLeagueIdAndUserEmail($email,$league_details['mega_pool_id']);
				
				if($invitationCheck){
					$data = array(
								'invitation_accepted'  => 2
							);

					if($this->Invitationmaster_model->updateInvitationStatus($email,$data,$league_details['mega_pool_id'])){
						$response = array('status' => 1,'message' => 'Successfully rejected.');
					}else{
						$response = array('status' => 0,'message' => 'You are not allowed to join this league.');
					}
				}else{
					$response = array('status' => 0,'message' => 'You are not allowed to join this league.');
				}
			}else{
				$response = array('status' => 0,'message' => 'You are not allowed to execute this action.');
			}
		}else{
			$response = array('status' => 0,'message' => 'You are not allowed to execute this action.');
		}

		echo json_encode($response);
		die;
	}
}
