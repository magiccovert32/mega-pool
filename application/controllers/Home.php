<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Home extends CI_Controller {

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
		
		$this->load->model("Blog_model");
	}
	
	public function index(){
		$data = array();

		$this->front_template->set('title', 'Mega Pool:: Home');
		$this->front_template->set('header', 'Home');
		
		$data['blog'] = $this->Blog_model->getAllActiveBlog();
		
		$this->front_template->load('front_template', 'contents' , 'front_end/home/index', $data);
	}
	
	
	public function blog_details(){
		$data = array();

		$this->front_template->set('title', 'Mega Pool:: Home');
		$this->front_template->set('header', 'Home');
		
		$blog_url = $this->uri->segment(2);
		
		if($data['blog_details'] = $this->Blog_model->getBlogDetails($blog_url)){
			$this->front_template->load('front_template', 'contents' , 'front_end/home/blog_details', $data);
		}else{
			$this->output->set_status_header('404');
			$this->load->view('front_end/404_error');
		}
	}
}
