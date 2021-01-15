<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sportmaster_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct(); 
    }
	
	
	/**
	 *
	 * Function used to add sport info
	 *
	 * @param $data
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function save($data){
		if($this->db->insert('sports_master', $data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to update sport info
	 *
	 * @param $data, $sport_id
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function update($data,$sport_id){
		$this->db->where('sport_id',$sport_id);

		if($this->db->update('sports_master',$data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to check sport name already exists
	 *
	 * @param $title
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function checkSportNameExists($title){				
		$query = $this->db->select("sport_id")
                        ->from("sports_master")
						->where("sport_title", $title)
						->get();
 
        if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to check sport name already exists
	 *
	 * @param $title,$id
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function checkSportNameExistsWithOutSportId($title,$id){				
		$query = $this->db->select("sport_id")
                        ->from("sports_master")
						->where("sport_title", $title)
						->where("sport_id !=".$id)
						->get();
 
        if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	
	/**
	 *
	 * Function used to get all sport list
	 *
	 * @param $page,$perpage
	 *
	 * @return array
	 * 
	 *
	 */
	public function getAllSportsForAdmin($page,$perpage){		
		$page = $page-1;
		
		if ($page<0) { 
			$page = 0;
		}
		
		$from = $page*$perpage;
		$this->db->limit($perpage, $from);
		
		$query = $this->db->select("SM.*")
                        ->from("sports_master SM")
						->order_by('sport_title')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to get all sport list count
	 *
	 * @return int
	 * 
	 *
	 */
	public function getTotalSportCountForAdmin(){				
		$query = $this->db->select("COUNT(SM.sport_id) as count")
                        ->from("sports_master SM")
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
	 * Function used to get details of sport
	 *
	 * $id
	 *
	 * @return array
	 * 
	 *
	 */
	public function getSportDetailsBySportIdByAdmin($id){				
		$query = $this->db->select("*")
                        ->from("sports_master")
						->where("sport_id", $id)
						->get();
 
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to all active sport
	 *
	 * @return array
	 * 
	 *
	 */
	public function getAllActiveSports(){				
		$query = $this->db->select("sport_id,sport_title")
                        ->from("sports_master")
						->where("sport_status", '1')
						->get();
 
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	
	/**
	 *
	 * Function used to count all sport
	 *
	 */
	public function getAllSportCount(){
		$query = $this->db->select("COUNT(SM.sport_id) as count")
                        ->from("sports_master SM")
						->get();
                        
        if($query->num_rows() > 0){
			$count =  $query->row();
			return $count->count;
		}else{
			return 0;
		}
	}
}