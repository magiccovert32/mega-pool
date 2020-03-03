<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms_pages_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct(); 
    }
	
	
	/**
	 *
	 * Function used to add
	 *
	 * @param $data
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function save($data){
		if($this->db->insert('cms_pages', $data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to update info
	 *
	 * @param $data, $page_url
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function update($data,$page_url){
		$this->db->where('page_url',$page_url);

		if($this->db->update('cms_pages',$data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	public function getPageDetailsByPageUrl($page_url){				
		$query = $this->db->select("*")
							->from("cms_pages CP")
							->where('CP.page_url',$page_url)
							->get();
                        
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
}