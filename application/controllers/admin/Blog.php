<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

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
		
		$this->load->model("Blog_model");
	}
	
	
	/**
	 *
	 * Function used to display blog list page
	 *
	 */
	public function admin_blog_management(){
		$this->admin_template->set('title', 'Blog Management');
		$this->admin_template->set('header', 'Blog Management');
		$this->admin_template->set('action', 'admin_blog_management');
		$this->admin_template->set('page_icon', 'pe-7s-note2');
		
		$data = array();
		$config["base_url"] 		= base_url() . "admin-blog-management";
		$config["total_rows"] 		= $this->Blog_model->getTotalBlogCountForAdmin();
		$config["uri_segment"] 		= 2;
		$config["per_page"] 		= 20;
		$choice 					= $config["total_rows"] / $config["per_page"];
		$config["num_links"] 		= round($choice);
		$config['use_page_numbers'] = true; 
		$page 						= ($this->uri->segment($config["uri_segment"] )) ? $this->uri->segment($config["uri_segment"] ) : 0;
		$data["blog_list"] 			= $this->Blog_model->getAllBlogForAdmin($page,$config["per_page"]);
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
			
		$this->admin_template->load('admin_template', 'contents' , 'admin/blog/admin_blog_management', $data);
	}
	
	
	/**
	 *
	 * Function used to display blog add page
	 *
	 */
	public function admin_add_blog(){
		$data = array();

		$this->admin_template->set('title', 'Add Blog');
		$this->admin_template->set('header', 'Add Blog');
		$this->admin_template->set('action', 'admin_add_blog');
		$this->admin_template->set('page_icon', 'pe-7s-plus');
		
		$this->admin_template->load('admin_template', 'contents' , 'admin/blog/admin_add_blog', $data);
	}
	
	
	/**
	 *
	 * Function used to save blog data
	 *
	 */
	public function admin_save_blog(){
		if($this->input->post()){			
			$blog_title		= trim($this->input->post('blog_title'));
			$blog_content 	= trim($this->input->post('blog_content'));
			$admin_id		= $this->session->userdata('admin_id');
			$blog_url		= md5(@date('Y-m-d h:i:s')).'-'.rand(1000,4000);
			
			if($blog_title != '' && $blog_content != '' && $_FILES != null){
				#Check Blog name exists
				if($this->Blog_model->checkBlogNameExists($blog_title)){
					$this->session->set_flashdata('blog_item', array('message' => 'Blog title already exists into this system. Please try with different name.','class' => 'danger'));
					redirect(base_url('admin-add-blog')); 
				}else{
					#Validate and save blog logo
					if($_FILES){
						if(!empty($_FILES['blog_image_path']["tmp_name"])){
							#check size grater than 1MB
							if($_FILES['blog_image_path']['size'] > 2000000){
								$this->session->set_flashdata('blog_item', array('message' => 'Please upload logo within 1MB.','class' => 'danger'));
								redirect(base_url('admin-add-blog')); 
							}else{
								$imageName 		= md5(strtotime(@date('y-m-d h:i:s')).'_'.rand(111111,999999));
								$imageFileType 	= pathinfo($_FILES["blog_image_path"]["name"],PATHINFO_EXTENSION);
																
								if (move_uploaded_file($_FILES["blog_image_path"]["tmp_name"], 'assets/uploads/blog_logo/'.$imageName.'.'.$imageFileType)) {
									$blog_image = $imageName.'.'.$imageFileType;
									
									$blogData = array(
													'blog_title' 		=> $blog_title,
													'blog_content' 		=> $blog_content,
													'blog_image_path' 	=> $blog_image,
													'blog_url'			=> $blog_url,
													);
									
									if($this->Blog_model->save($blogData)){
										$this->session->set_flashdata('blog_item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
										redirect(base_url('admin-blog-management')); 
									}else{
										$this->session->set_flashdata('blog_item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
										redirect(base_url('admin-add-blog')); 
									}
								}else{
									$this->session->set_flashdata('blog_item', array('message' => 'Something went wrong, while uploading logo. Please try again later.','class' => 'danger'));
									redirect(base_url('admin-add-blog')); 
								}
							}
						}else{
							$this->session->set_flashdata('blog_item', array('message' => 'Please fill up all informations','class' => 'danger'));
							redirect(base_url('admin-add-blog')); 
						}
					}
				}
				
			}else{
				$this->session->set_flashdata('blog_item', array('message' => 'Please fill up all informations','class' => 'danger'));
				redirect(base_url('admin-add-blog')); 
			}
		}else{
			$this->session->set_flashdata('blog_item', array('message' => 'Please fill up all informations','class' => 'danger'));
			redirect(base_url('admin-add-blog')); 
		}
	}
	
	
	
	/**
	 *
	 * Function used to update blog details
	 *
	 */
	public function admin_update_blog(){
		if($this->input->post()){
			$blog_id				= trim($this->input->post('blog_id'));
			$old_blog_image_path	= trim($this->input->post('old_blog_image_path'));
			$blog_title				= trim($this->input->post('blog_title'));
			$blog_content 			= trim($this->input->post('blog_content'));
			$status 				= trim($this->input->post('status'));
			$admin_id				= $this->session->userdata('admin_id');
			
			if($blog_title != '' && $blog_content != ''){
				#Check blog name exists
				if($this->Blog_model->checkBlogNameExistsWithOutBlogId($blog_title,$blog_id)){
					$this->session->set_flashdata('blog_item', array('message' => 'Blog name already exists into this system. Please try with different name.','class' => 'danger'));
					redirect(base_url('admin-edit-blog/'.$blog_id)); 
				}else{
					#Validate and save blog logo
					if($_FILES){
						if(!empty($_FILES['blog_image_path']["tmp_name"])){
							#check size grater than 1MB
							if($_FILES['blog_image_path']['size'] > 2000000){
								$this->session->set_flashdata('blog_item', array('message' => 'Please upload logo within 1MB.','class' => 'danger'));
								redirect(base_url('admin-edit-blog/'.$blog_id)); 
							}else{
								$imageName 		= md5(strtotime(@date('y-m-d h:i:s')).'_'.rand(111111,999999));
								$imageFileType 	= pathinfo($_FILES["blog_image_path"]["name"],PATHINFO_EXTENSION);
								
								if (move_uploaded_file($_FILES["blog_image_path"]["tmp_name"], 'assets/uploads/blog_logo/'.$imageName.'.'.$imageFileType)) {
									$blog_image = $imageName.'.'.$imageFileType;
									
									unlink('assets/uploads/blog_logo/'.$old_blog_image_path);
								}else{
									$this->session->set_flashdata('blog_item', array('message' => 'Something went wrong, while uploading logo. Please try again later.','class' => 'danger'));
									redirect(base_url('admin-edit-blog/'.$blog_id)); 
								}
							}
						}else{
							$blog_image = $old_blog_image_path;
						}
					}else{
						$blog_image = $old_blog_image_path;
					}
					
					$blogData = array(
									'blog_title' 		=> $blog_title,
									'blog_content' 		=> $blog_content,
									'blog_image_path' 	=> $blog_image,
									'status' 			=> $status,
									'last_modified_on' 	=> @date('Y-m-d h:i:s'),
									);
					
					if($this->Blog_model->update($blogData,$blog_id)){
						$this->session->set_flashdata('blog_item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
						redirect(base_url('admin-blog-management')); 
					}else{
						$this->session->set_flashdata('blog_item', array('message' => 'Something went wrong, while saving information. Please try again later.','class' => 'danger'));
						redirect(base_url('admin-edit-blog/'.$blog_id)); 
					}
				}
				
			}else{
				$this->session->set_flashdata('blog_item', array('message' => 'Please fill up all informations','class' => 'danger'));
				redirect(base_url('admin-edit-blog/'.$blog_id)); 
			}
		}else{
			$this->session->set_flashdata('blog_item', array('message' => 'Please fill up all information','class' => 'danger'));
			redirect(base_url('admin-edit-blog/'.$blog_id)); 
		}
	}
	
	
	
	/**
	 *
	 * Function used to display blog edit page
	 *
	 */
	public function admin_edit_blog(){
		$data = array();

		$this->admin_template->set('title', 'Edit Blog');
		$this->admin_template->set('header', 'Edit Blog');
		$this->admin_template->set('action', 'admin_blog_management');
		$this->admin_template->set('page_icon', 'pe-7s-note');
		
		$blogId = $this->uri->segment(2);
		
		$data['blog_details'] = $this->Blog_model->getBlogDetailsByBlogIdByAdmin($blogId);
		
		$this->admin_template->load('admin_template', 'contents' , 'admin/blog/admin_edit_blog', $data);
	}
}
