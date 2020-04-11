<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Dashboard extends CI_Controller {

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
		$this->load->model("Megapoolmaster_model");
		$this->load->model("Draftmaster_model");
	}


	
	public function my_dashboard(){
		$data = array();

		$data['user_details'] = $this->Usermaster_model->getUserDetailsByUserId($this->session->userdata('user_id'));

		$this->front_template_inner->set('title', 'Supersportspool :: My Dashboard');
		$this->front_template_inner->set('header', 'My Dashboard');
		$this->front_template_inner->set('action', 'my_dashboard');	
		$this->front_template_inner->set('page_icon', 'pe-7s-graph2');
		
		if($this->session->userdata('user_type_id') == 1){
			$data['megapool_count'] = $this->Megapoolmaster_model->getTotalLeagueCountCommissionerId($this->session->userdata('user_id'));
			$data['draft_count'] 	= $this->Draftmaster_model->getTotalDraftCountCommissionerId($this->session->userdata('user_id'));
			$data['player_count'] 	= $this->Megapoolmaster_model->getTotalPlayerCountByCommissionerId($this->session->userdata('user_id'));
			
			
			$data['megapool_list'] 	= $this->Megapoolmaster_model->getAllActiveMegapoolByCommissionerId($this->session->userdata('user_id'));
		}else{
			$data['league_list'] 	= $this->Megapoolmaster_model->getAllActiveDraftLeagueByPlayerId($this->session->userdata('user_id'));
		}
		
		if($this->session->userdata('user_type_id') == 2){
			$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/profile/player_dashboard', $data);
		}else{
			$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/profile/commissioner_dashboard', $data);
		}
	}
}
