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
	
	
	public function home_page(){
		$data = array();

		$this->admin_template->set('title', 'Home Page Content');
		$this->admin_template->set('header', 'Home Page Content');
		$this->admin_template->set('action', 'home_page');
		$this->admin_template->set('page_icon', 'pe-7s-plus');
		
		$data['page_details'] = $this->Cms_pages_model->getPageDetailsByPageUrl('home_page');
		
		if($this->input->post()){
			$page_title			= trim($this->input->post('page_title'));
			$small_content		= trim($this->input->post('small_content'));
			$old_banner_image	= trim($this->input->post('old_banner_image'));
			$old_small_image	= trim($this->input->post('old_small_image'));
			$page_content		= trim($this->input->post('page_content'));
			
			#Validate and save blog logo
			if($_FILES){
				if(!empty($_FILES['banner_image']["tmp_name"])){
					#check size grater than 1MB
					if($_FILES['banner_image']['size'] > 2000000){
						$this->session->set_flashdata('blog_item', array('message' => 'Please upload banner within 2MB.','class' => 'danger'));
						redirect(base_url('cms/home-page')); 
					}else{
						$imageName 		= md5(strtotime(@date('y-m-d h:i:s')).'_'.rand(111111,999999));
						$imageFileType 	= pathinfo($_FILES["banner_image"]["name"],PATHINFO_EXTENSION);
						
						if (move_uploaded_file($_FILES["banner_image"]["tmp_name"], 'assets/uploads/cms/'.$imageName.'.'.$imageFileType)) {
							$banner_image = $imageName.'.'.$imageFileType;
							
							unlink('assets/uploads/cms/'.$old_banner_image);
						}else{
							$this->session->set_flashdata('item', array('message' => 'Something went wrong, while uploading banner. Please try again later.','class' => 'danger'));
							redirect(base_url('cms/home-page')); 
						}
					}
				}else{
					$banner_image = $old_banner_image;
				}
				
				if(!empty($_FILES['small_image']["tmp_name"])){
					#check size grater than 1MB
					if($_FILES['small_image']['size'] > 2000000){
						$this->session->set_flashdata('blog_item', array('message' => 'Please upload small image within 2MB.','class' => 'danger'));
						redirect(base_url('cms/home-page')); 
					}else{
						$imageName 		= md5(strtotime(@date('y-m-d h:i:s')).'_'.rand(111111,999999));
						$imageFileType 	= pathinfo($_FILES["small_image"]["name"],PATHINFO_EXTENSION);
						
						if (move_uploaded_file($_FILES["small_image"]["tmp_name"], 'assets/uploads/cms/'.$imageName.'.'.$imageFileType)) {
							$small_image = $imageName.'.'.$imageFileType;
							
							unlink('assets/uploads/cms/'.$old_small_image);
						}else{
							$this->session->set_flashdata('item', array('message' => 'Something went wrong, while uploading small image. Please try again later.','class' => 'danger'));
							redirect(base_url('cms/home-page')); 
						}
					}
				}else{
					$small_image = $old_small_image;
				}
			}else{
				$small_image = $old_small_image;
			}
			
			$cms_array = array(
						'page_title' 	=> $page_title,
						'small_content' => $small_content,
						'banner_image' 	=> $banner_image,
						'page_content' 	=> $page_content,
						'small_image' 	=> $small_image,
						);
			
			$this->Cms_pages_model->update($cms_array,'home_page');
			
			$this->session->set_flashdata('item', array('message' => 'Page updated','class' => 'success'));
			redirect(base_url('cms/home-page')); 
		}else{
			$this->admin_template->load('admin_template', 'contents' , 'admin/cms/home_page', $data);
		}
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
