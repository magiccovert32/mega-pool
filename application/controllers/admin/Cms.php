<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends CI_Controller {

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
		
		$this->load->model("Cms_pages_model");
	}
	
	
	/**
	 *
	 * Function used to display about us page
	 *
	 */
	public function about_us(){
		$data = array();

		$this->admin_template->set('title', 'About Page Content');
		$this->admin_template->set('header', 'About Page Content');
		$this->admin_template->set('action', 'about_us');
		$this->admin_template->set('page_icon', 'pe-7s-plus');
		
		$data['page_details'] = $this->Cms_pages_model->getPageDetailsByPageUrl('about_us');
		
		if($this->input->post()){
			$page_title			= trim($this->input->post('page_title'));
			$page_content		= trim($this->input->post('page_content'));
			
			$cms_array = array(
							'page_title' 	=> $page_title,
							'page_content' 	=> $page_content,
							);
			
			$this->Cms_pages_model->update($cms_array,'about_us');
			
			$this->session->set_flashdata('item', array('message' => 'Page updated','class' => 'success'));
			redirect(base_url('cms/about-us')); 
		}else{
			$this->admin_template->load('admin_template', 'contents' , 'admin/cms/about_us', $data);
		}
	}
	
	
	public function contact_us(){
		$data = array();

		$this->admin_template->set('title', 'Contact Page Content');
		$this->admin_template->set('header', 'Contact Page Content');
		$this->admin_template->set('action', 'contact_us');
		$this->admin_template->set('page_icon', 'pe-7s-plus');
		
		$data['page_details'] = $this->Cms_pages_model->getPageDetailsByPageUrl('contact_us');
		
		if($this->input->post()){
			$page_title			= trim($this->input->post('page_title'));
			$page_content		= trim($this->input->post('page_content'));
			
			$cms_array = array(
							'page_title' 	=> $page_title,
							'page_content' 	=> $page_content,
							);
			
			$this->Cms_pages_model->update($cms_array,'contact_us');
			
			$this->session->set_flashdata('item', array('message' => 'Page updated','class' => 'success'));
			redirect(base_url('cms/contact-us')); 
		}else{
			$this->admin_template->load('admin_template', 'contents' , 'admin/cms/contact_us', $data);
		}
	}
	
	
	public function privacy_policy(){
		$data = array();

		$this->admin_template->set('title', 'Privacy Policy Content');
		$this->admin_template->set('header', 'Privacy Policy Content');
		$this->admin_template->set('action', 'privacy_policy');
		$this->admin_template->set('page_icon', 'pe-7s-plus');
		
		$data['page_details'] = $this->Cms_pages_model->getPageDetailsByPageUrl('privacy_policy');
		
		if($this->input->post()){
			$page_title			= trim($this->input->post('page_title'));
			$page_content		= trim($this->input->post('page_content'));
			
			$cms_array = array(
							'page_title' 	=> $page_title,
							'page_content' 	=> $page_content,
							);
			
			$this->Cms_pages_model->update($cms_array,'privacy_policy');
			
			$this->session->set_flashdata('item', array('message' => 'Page updated','class' => 'success'));
			redirect(base_url('cms/privacy-policy')); 
		}else{
			$this->admin_template->load('admin_template', 'contents' , 'admin/cms/privacy_policy', $data);
		}
	}
}
