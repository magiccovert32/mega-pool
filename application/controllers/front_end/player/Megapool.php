<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Megapool extends CI_Controller {

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

		if ($this->session->userdata('user_session_id') == null) {
            redirect(base_url('account-login'));
		}

		if ($this->session->userdata('user_type_id') != 2) {
            redirect(base_url('home'));
		}

		$this->load->model("Usermaster_model");
		$this->load->model("Megapoolmaster_model");
	}



	/**
	 *
	 * Function used to display commissioner list page
	 *
	 */
	public function all_megapool(){
		$userId = $this->session->userdata('user_id');

		$this->front_template_inner->set('title', 'All Megapools');
		$this->front_template_inner->set('header', 'All Megapools');
		$this->front_template_inner->set('action', 'my_leagues');
		$this->front_template_inner->set('page_icon', 'pe-7s-note2');
		
		$data = array();

		$config["base_url"] 		= base_url() . "all-megapool";
		$config["total_rows"] 		= $this->Megapoolmaster_model->getTotalCountPublishedMegapoolList();
		$config["uri_segment"] 		= 2;
		$config["per_page"] 		= 10;
		$choice 					= $config["total_rows"] / $config["per_page"];
		$config["num_links"] 		= round($choice);
		$config['use_page_numbers'] = true; 
		$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
		$data["megapool_list"] 		= $this->Megapoolmaster_model->getPublishedMegapoolList($page,$config["per_page"]);
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
			
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/player/megapool/all_megapool', $data);
	}



	public function megapool_preview(){
		$data = array();

		$this->front_template_inner->set('title', 'Preview');
		$this->front_template_inner->set('header', 'Preview');
		$this->front_template_inner->set('action', 'megapool_preview');
		$this->front_template_inner->set('page_icon', 'pe-7s-note');
		
		$leagueUrl 	= $this->uri->segment(2);
		$userId 	= $this->session->userdata('user_id');
		
		$data['league_details'] = $this->Megapoolmaster_model->getLeagueDetailsByUrlAndPlayerId($leagueUrl,$userId);
		
		if($data['league_details']){
			$this->front_template_inner->set('title', 'Preview : '.$data['league_details']['mega_pool_title']);
		
			$data['total_player']		= $this->Megapoolmaster_model->getTotalPlayerCountByLeagueId($data['league_details']['mega_pool_id']);
			$data['related_leagues'] 	= $this->Megapoolmaster_model->getRelatedLeagueByMegaPoolId($data['league_details']['mega_pool_id']);
		}
		
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/player/megapool/megapool_preview', $data);
	}
	
	
	
	/**
	 *
	 * Function used to display commissioner list page
	 *
	 */
	public function my_leagues(){
		$userId = $this->session->userdata('user_id');

		$this->front_template_inner->set('title', 'My Megapools');
		$this->front_template_inner->set('header', 'My Megapools');
		$this->front_template_inner->set('action', 'my_megapool');
		$this->front_template_inner->set('page_icon', 'pe-7s-note2');
		
		$data = array();
		
		$config["base_url"] 		= base_url() . "my-leagues";
		$config["total_rows"] 		= $this->Megapoolmaster_model->getTotalCountMyMegapoolList($userId);
		$config["uri_segment"] 		= 2;
		$config["per_page"] 		= 10;
		$choice 					= $config["total_rows"] / $config["per_page"];
		$config["num_links"] 		= round($choice);
		$config['use_page_numbers'] = true; 
		$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
		$data["megapool_list"] 		= $this->Megapoolmaster_model->getMyMegapoolList($page,$config["per_page"],$userId);
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
			
		$this->front_template_inner->load('front_template_inner', 'contents' , 'front_end/player/megapool/my_leagues', $data);
	}
}
