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

		if ($this->session->userdata('admin_session_id') == null) {
            redirect(base_url('admin-login'));
        }

		$this->load->model("Megapoolmaster_model");
		$this->load->model("Leaguemaster_model");
		$this->load->model("Draftmaster_model");
	}
	
	public function admin_megapool_leagues(){
		$this->admin_template->set('title', 'Megapool Management');
		$this->admin_template->set('header', 'Megapool Management');
		$this->admin_template->set('action', 'admin_megapool_leagues');
		$this->admin_template->set('page_icon', 'pe-7s-note2');
		
		$data = array();
		$config["base_url"] 		= base_url() . "admin-megapool-leagues";
		$config["total_rows"] 		= $this->Megapoolmaster_model->getTotalMegapoolCountForAdmin();
		$config["uri_segment"] 		= 2;
		$config["per_page"] 		= 20;
		$choice 					= $config["total_rows"] / $config["per_page"];
		$config["num_links"] 		= round($choice);
		$config['use_page_numbers'] = true; 
		$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
		$data["megapool_list"] 		= $this->Megapoolmaster_model->getAllMegapoolForAdmin($page,$config["per_page"]);
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
			
		$this->admin_template->load('admin_template', 'contents' , 'admin/megapool/admin_megapool_leagues', $data);
	}
	
	public function admin_megapool_draft(){
		$this->admin_template->set('title', 'Draft Management');
		$this->admin_template->set('header', 'Draft Management');
		$this->admin_template->set('action', 'admin_megapool_draft');
		$this->admin_template->set('page_icon', 'pe-7s-note2');
		
		$data = array();
		$config["base_url"] 		= base_url() . "admin-megapool-draft";
		$config["total_rows"] 		= $this->Megapoolmaster_model->getTotalDraftCountForAdmin();
		$config["uri_segment"] 		= 2;
		$config["per_page"] 		= 20;
		$choice 					= $config["total_rows"] / $config["per_page"];
		$config["num_links"] 		= round($choice);
		$config['use_page_numbers'] = true; 
		$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
		$data["draft_list"] 		= $this->Megapoolmaster_model->getAllDraftForAdmin($page,$config["per_page"]);
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
			
		$this->admin_template->load('admin_template', 'contents' , 'admin/megapool/admin_megapool_draft', $data);
	}
	
	public function admin_edit_draft(){
		$data = array();

		$this->front_template_inner->set('title', 'Supersportspool :: Edit Draft');
		$this->front_template_inner->set('header', 'Edit Draft');	
		$this->front_template_inner->set('action', 'admin_megapool_draft');			
		$this->front_template_inner->set('page_icon', 'pe-7s-note');	

		$draft_id = $this->uri->segment(2);

		$data['draft_details'] = $this->Megapoolmaster_model->getDraftDetails($draft_id);
		
		$this->front_template_inner->load('admin_template', 'contents' , 'admin/megapool/admin_edit_draft', $data);
	}
	
	public function update_admin_draft(){
		if($this->input->post()){
			$draft_id			= $this->input->post('draft_id');
			$date 				= @date('Y-m-h H:i:s', strtotime($this->input->post('team_selection_ends_on')));

			$draftDetails 		= $this->Megapoolmaster_model->getDraftDetails($draft_id);

			if($draftDetails){
				$draftData = array(
								'team_selection_ends_on' => $date,
								);
	
				if($this->Draftmaster_model->update($draftData,$draft_id)){
					$response = array('status' => 1,'message' => 'Draft updated.');
				}else{
					$response = array('status' => 0,'message' => 'Something went wrong, while saving information. Please try again later.');
				}
			}else{
				$response = array('status' => 1,'message' => 'You dont have access to update this draft.');
			}
		}else{
			$response = array('status' => 0,'message' => 'Some informations are missing. Please fill up all informations');
		}

		echo json_encode($response);
		die;
	}
}
