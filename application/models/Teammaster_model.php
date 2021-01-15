<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teammaster_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct(); 
    }
	
	
	/**
	 *
	 * Function used to add team info
	 *
	 * @param $data
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function save($data){
		if($this->db->insert('teams_master', $data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to update team info
	 *
	 * @param $data, $team_id
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function update($data,$team_id){
		$this->db->where('team_id',$team_id);

		if($this->db->update('teams_master',$data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to check team name already exists
	 *
	 * @param $title
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function checkTeamNameExists($title){				
		$query = $this->db->select("team_id")
                        ->from("teams_master")
						->where("team_title", $title)
						->get();
 
        if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to check team name already exists
	 *
	 * @param $title,$id
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function checkTeamNameExistsWithOutTeamId($title,$id){				
		$query = $this->db->select("team_id")
                        ->from("teams_master")
						->where("team_title", $title)
						->where("team_id !=".$id)
						->get();
 
        if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to get all team list
	 *
	 * @param $page,$perpage
	 *
	 * @return array
	 * 
	 *
	 */
	public function getAllTeamsForAdmin($page,$perpage){		
		$page = $page-1;
		
		if ($page<0) { 
			$page = 0;
		}
		
		$from = $page*$perpage;
		$this->db->limit($perpage, $from);
		
		$query = $this->db->select("TM.team_id,TM.related_sport_id,TM.team_title,TM.team_logo,TM.team_status,SUBSTRING(TM.team_description, 1, 100) AS team_description")
                        ->from("teams_master TM")
						->order_by('team_title')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to get all team list count
	 *
	 * @return int
	 * 
	 *
	 */
	public function getTotalTeamCountForAdmin(){				
		$query = $this->db->select("COUNT(TM.team_id) as count")
                        ->from("teams_master TM")
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
	 * Function used to get details of team
	 *
	 * $id
	 *
	 * @return array
	 * 
	 *
	 */
	public function getTeamDetailsByTeamIdByAdmin($id){				
		$query = $this->db->select("*")
                        ->from("teams_master")
						->where("team_id", $id)
						->get();
 
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	
	/**
	 *
	 * Function used to get team by sportId
	 *
	 * $id
	 *
	 * @return array
	 * 
	 *
	 */
	public function getAllActiveTeamBySportId($id){				
		$query = $this->db->select("team_id,team_title")
                        ->from("teams_master")
						->where("related_sport_id", $id)
						->where("team_status",'1')
						->order_by('team_title')
						->get();
 
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	
	/**
	 *
	 * Function used to count all team
	 *
	 */
	public function getAllTeamCount(){
		$query = $this->db->select("COUNT(TM.team_id) as count")
                        ->from("teams_master TM")
						->get();
                        
        if($query->num_rows() > 0){
			$count =  $query->row();
			return $count->count;
		}else{
			return 0;
		}
	}
}