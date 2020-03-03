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
		
		if ($this->session->userdata('admin_session_id') == null) {
            redirect(base_url('admin-login'));
        }
		
		$this->load->model("Sportmaster_model");
		$this->load->model("Leaguemaster_model");
		$this->load->model("Teammaster_model");
		$this->load->model("Usermaster_model");
	}
	
	
	/**
	 *
	 * Function used to display dashboard page
	 *
	 */
	public function admin_dashboard(){
		$data = array();

		$this->admin_template->set('title', 'Dashboard');
		$this->admin_template->set('header', 'Analytics Dashboard');
		$this->admin_template->set('action', 'analytics_dashboard');
		$this->admin_template->set('page_icon', 'pe-7s-graph2');
		
		$data['league_count'] 		= $this->Leaguemaster_model->getAllLeagueCount();
		$data['sport_count'] 		= $this->Sportmaster_model->getAllSportCount();
		$data['team_count'] 		= $this->Teammaster_model->getAllTeamCount();
		$data['commissioner_count'] = $this->Usermaster_model->getAllCommissionerCount();
		$data['player_count'] 		= $this->Usermaster_model->getAllPlayerCount();
		
		$this->admin_template->load('admin_template', 'contents' , 'admin/dashboard/admin_dashboard', $data);
	}
}
