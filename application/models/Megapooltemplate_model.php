<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Megapooltemplate_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct(); 
    }
	
	
	/**
	 *
	 * Function used to add league info
	 *
	 * @param $data
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function save($data){
		if($this->db->insert('mega_pool_template_master', $data)){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

    public function getTemplateDetails($mega_pool_id){				
		$query = $this->db->select("*")
						->from("mega_pool_template_master MPTM")
						->where("MPTM.mega_pool_id",$mega_pool_id)
						->get();
                        
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
    
    
    public function getAllSelectedLeagueByMegaPoolId($id){				
		$query = $this->db->select("*")
						->from("mega_pool_template_league_relation MPLR")
						->where('MPLR.mega_pool_id',$id)
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}


	/**
	 *
	 * Function used to add league relation with megapool
	 *
	 * @param $data
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function saveMegapoolLeagueRelation($data){
		if($this->db->insert('mega_pool_template_league_relation', $data)){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 *
	 * Function used to delete league relation with megapool
	 *
	 * @param $id
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function removeMegapoolLeagueRelation($id){
		$this->db->where('mega_pool_id', $id);
	
		if($this->db->delete('mega_pool_template_league_relation')){
			return true;
		}else{
			return false;
		}
	}

	
	
	/**
	 *
	 * Function used to update league info
	 *
	 * @param $data, $league_id
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function update($data,$league_id){
		$this->db->where('mega_pool_id',$league_id);

		if($this->db->update('mega_pool_template_master',$data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to check league name already exists
	 *
	 * @param $title
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function checkLeagueNameExists($title){				
		$query = $this->db->select("mega_pool_id")
                        ->from("mega_pool_template_master")
						->where("mega_pool_title", $title)
						->get();
 
        if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to check league name already exists
	 *
	 * @param $title,$id
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function checkLeagueNameExistsWithOutLeagueId($title,$id){				
		$query = $this->db->select("mega_pool_id")
                        ->from("mega_pool_template_master")
						->where("mega_pool_title", $title)
						->where("mega_pool_id !=".$id)
						->get();
 
        if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
    
	public function getTotalTemplateCountForAdmin(){				
		$query = $this->db->select("COUNT(MPTM.mega_pool_id) as count")
						->from("mega_pool_template_master MPTM")
						->where("MPTM.current_status != 3")
						->get();
                        
        if($query->num_rows() > 0){
			$count =  $query->row();
			return $count->count;
		}else{
			return 0;
		}
	}
    
    public function getAllLeagueTemplateForAdmin($page,$perpage){		
		$page = $page-1;
		
		if ($page<0) { 
			$page = 0;
		}
		
		$from = $page*$perpage;
		$this->db->limit($perpage, $from);
		
		$query = $this->db->select("MPTM.*")
							->from("mega_pool_template_master MPTM")
							->order_by('MPTM.created_on DESC')
							->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
    
    
    public function getAllActiveLeagueTemplate(){		
		$query = $this->db->select("MPTM.mega_pool_title,MPTM.mega_pool_id")
							->from("mega_pool_template_master MPTM")
							->order_by('MPTM.created_on DESC')
                            ->where('current_status', '1')
							->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
    
    
    public function getDetailedTemplateDetails($mega_pool_id){				
		$query = $this->db->select("MPTM.*, GROUP_CONCAT(SM.sport_title SEPARATOR ',') as related_sport")
						->from("mega_pool_template_master MPTM")
                        ->join("sports_master AS SM","find_in_set(SM.sport_id,MPTM.related_sport_id)<> 0","left",false)
						->where("MPTM.mega_pool_id",$mega_pool_id)
						->get();
                        
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
    
    
    public function getRelatedLeagueDetails($mega_pool_id){				
		$query = $this->db->select("LM.league_title,LM.league_logo")
						->from("mega_pool_template_league_relation MPTLR")
                        ->join("leagues_master AS LM","LM.league_id = MPTLR.league_id","left",false)
						->where("MPTLR.mega_pool_id",$mega_pool_id)
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
}