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
		$this->load->model("Cms_pages_model");
	}
	
	
	/**
	 *
	 * Function used to display about us page
	 *
	 */
	public function about_us(){
		$data = array();

		$this->front_template->set('title', 'Mega Pool:: About Us');
		$this->front_template->set('header', 'Home');
		
		$data['page_details'] = $this->Cms_pages_model->getPageDetailsByPageUrl('about_us');
		
		$this->front_template->load('front_template', 'contents' , 'front_end/cms/page', $data);
	}
	
	
	public function contact_us(){
		$data = array();

		$this->front_template->set('title', 'Mega Pool:: About Us');
		$this->front_template->set('header', 'Home');
		
		$data['page_details'] = $this->Cms_pages_model->getPageDetailsByPageUrl('contact_us');
		
		$this->front_template->load('front_template', 'contents' , 'front_end/cms/page', $data);
	}
}
