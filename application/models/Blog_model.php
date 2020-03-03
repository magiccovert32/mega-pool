<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct(); 
    }
	
	
	/**
	 *
	 * Function used to add blog info
	 *
	 * @param $data
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function save($data){
		if($this->db->insert('blog', $data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to update blog info
	 *
	 * @param $data, $blog_id
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function update($data,$blog_id){
		$this->db->where('blog_id',$blog_id);

		if($this->db->update('blog',$data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to check blog name already exists
	 *
	 * @param $title
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function checkBlogNameExists($title){				
		$query = $this->db->select("blog_id")
                        ->from("blog")
						->where("blog_title", $title)
						->get();
 
        if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	
	/**
	 *
	 * Function used to check blog name already exists
	 *
	 * @param $title,$id
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function checkBlogNameExistsWithOutBlogId($title,$id){				
		$query = $this->db->select("blog_id")
                        ->from("blog")
						->where("blog_title", $title)
						->where("blog_id !=".$id)
						->get();
 
        if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	
	/**
	 *
	 * Function used to get all blog list
	 *
	 * @param $page,$perpage
	 *
	 * @return array
	 * 
	 *
	 */
	public function getAllBlogForAdmin($page=0,$perpage){		
		$page = $page-1;
		
		if ($page<0) { 
			$page = 0;
		}
		
		$from = $page*$perpage;
		$this->db->limit($perpage, $from);
		
		$query = $this->db->select("B.*")
                        ->from("blog B")
						->order_by('blog_id DESC')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to get all blog list count
	 *
	 * @return int
	 * 
	 *
	 */
	public function getTotalBlogCountForAdmin(){				
		$query = $this->db->select("COUNT(B.blog_id) as count")
                        ->from("blog B")
						->get();
                        
        if($query->num_rows() > 0){
			$count =  $query->row();
			return $count->count;
		}else{
			return 0;
		}
	}
	
	
	/**
	 *
	 * Function used to get details of blog
	 *
	 * $id
	 *
	 * @return array
	 * 
	 *
	 */
	public function getBlogDetailsByBlogIdByAdmin($id){				
		$query = $this->db->select("*")
                        ->from("blog")
						->where("blog_id", $id)
						->get();
 
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to all active blog
	 *
	 * @return array
	 * 
	 *
	 */
	public function getAllActiveBlog(){				
		$query = $this->db->select("blog_id,blog_title,blog_url, SUBSTR(blog_content, 1, 200) AS blog_content")
                        ->from("blog")
						->where("status", '1')
						->get();
 
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	public function getBlogDetails($blog_url){				
		$query = $this->db->select("*")
                        ->from("blog")
						->where("blog_url", $blog_url)
						->where("status", '1')
						->get();
 
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	
	/**
	 *
	 * Function used to count all blog
	 *
	 */
	public function getAllBlogCount(){
		$query = $this->db->select("COUNT(B.blog_id) as count")
                        ->from("blog B")
						->get();
                        
        if($query->num_rows() > 0){
			$count =  $query->row();
			return $count->count;
		}else{
			return 0;
		}
	}
}