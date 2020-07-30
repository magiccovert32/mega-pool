<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leaguemaster_model extends CI_Model {
    
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
		if($this->db->insert('leagues_master', $data)){
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
		$this->db->where('league_id',$league_id);

		if($this->db->update('leagues_master',$data)){
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
		$query = $this->db->select("league_id")
                        ->from("leagues_master")
						->where("league_title", $title)
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
		$query = $this->db->select("league_id")
                        ->from("leagues_master")
						->where("league_title", $title)
						->where("league_id !=".$id)
						->get();
 
        if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	
	/**
	 *
	 * Function used to get all league list
	 *
	 * @param $page,$perpage
	 *
	 * @return array
	 * 
	 *
	 */
	public function getAllLeaguesForAdmin($page=0,$perpage){		
		$page = $page-1;
		
		if ($page<0) { 
			$page = 0;
		}
		
		$from = $page*$perpage;
		$this->db->limit($perpage, $from);
		
		$query = $this->db->select("LM.league_id,LM.related_sport_id,LM.league_title,LM.league_logo,LM.league_status,SUBSTRING(LM.league_description, 1, 100) AS league_description")
                        ->from("leagues_master LM")
						->order_by('league_title')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to get all league list count
	 *
	 * @return int
	 * 
	 *
	 */
	public function getTotalLeagueCountForAdmin(){				
		$query = $this->db->select("COUNT(LM.league_id) as count")
                        ->from("leagues_master LM")
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
	 * Function used to get details of league
	 *
	 * $id
	 *
	 * @return array
	 * 
	 *
	 */
	public function getLeagueDetailsByLeagueIdByAdmin($id){				
		$query = $this->db->select("*")
                        ->from("leagues_master")
						->where("league_id", $id)
						->get();
 
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	
	/**
	 *
	 * Function used to add team with league
	 *
	 * @param $data,$leagueId,$teamId
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function addLeagueTeamRelation($data,$leagueId,$teamId){
		$query = $this->db->select("league_team_relation_id")
                        ->from("league_team_relation")
						->where("league_id", $leagueId)
						->where("team_id", $teamId)
						->get();
 
        if($query->num_rows() > 0){
			return false;
		}else{
			if($this->db->insert('league_team_relation', $data)){
				return true;
			}else{
				return false;
			}
		}
	}
	
	
	
	/**
	 *
	 * Function used to get all tams by league
	 *
	 * @param $leagueId
	 *
	 * @return array
	 * 
	 *
	 */
	public function getAllTeamByLeagueId($leagueId){
		$query = $this->db->select("LTR.league_team_relation_id,TM.team_title,TM.team_id,TM.team_logo")
                        ->from("league_team_relation LTR")
						->join('teams_master TM', 'TM.team_id = LTR.team_id', 'inner')
						->where("LTR.league_id", $leagueId)
						->order_by("team_title")
						->get();
						
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	
	/**
	 *
	 * Function used to get all tams by league and without teamid
	 *
	 * @param $sportId,$team
	 *
	 * @return array
	 * 
	 *
	 */
	public function getAllTeamByLeagueIdAndWithoutSelectedTeam($sportId,$team){
		if(count($team) > 0){
			$query = $this->db->select("TM.team_title,TM.team_id")
                        ->from("teams_master TM")
						->where("TM.related_sport_id", $sportId)
						->where_not_in("TM.team_id", $team)
						->order_by("team_title")
						->get();
		}else{
			$query = $this->db->select("TM.team_title,TM.team_id")
                        ->from("teams_master TM")
						->where("TM.related_sport_id", $sportId)
						->order_by("team_title")
						->get();
		}
		
		
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	
	/**
	 *
	 * Function used to remove relation
	 *
	 */
	public function removeLeagueTeamRelation($leagueId,$teamId){
		$this->db->where('league_id', $leagueId);
		$this->db->where('team_id', $teamId);
		$this->db->delete('league_team_relation');
		
		return true;
	}
	
	
	
	/**
	 *
	 * Function used to count all league
	 *
	 */
	public function getAllLeagueCount(){
		$query = $this->db->select("COUNT(LM.league_id) as count")
                        ->from("leagues_master LM")
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
	 * Function used to get all league by sport id
	 *
	 * @param $sportId
	 *
	 * @return array
	 * 
	 *
	 */
	public function getAllActiveLeagueBySportId($sportId){
		$query = $this->db->select("LM.league_id,LM.league_title,LM.league_logo")
                        ->from("leagues_master LM")
						->where_in("LM.related_sport_id", $sportId)
						->where("league_status",'1')
						->order_by("league_title")
						->get();
						
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	public function getAllActiveLeagues(){		
		$query = $this->db->select("LM.league_id,LM.league_title")
                        ->from("leagues_master LM")
						->where('league_status','1')
						->order_by('league_title')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	public function getAllLeaguePlayer($megapoolId){		
		$query = $this->db->select("UM.user_id,UM.full_name,UM.user_email")
                        ->from("mega_pool_player_relation MPPR")
						->join('user_master UM', 'UM.user_id = MPPR.player_id', 'inner')
						->where('megapool_id',$megapoolId)
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	public function getLeagueTeamCount($id){				
		$query = $this->db->select("COUNT(team_id) as team_count")
                        ->from("league_team_relation")
						->where("league_id", $id)
						->get();
 
        if($query->num_rows() > 0){
			$res = $query->row_array();
			return $res['team_count'];
		}else{
			return 0;
		}
	}
	
	
	public function getLeagueTeamPosition($id){				
		$query = $this->db->select("*")
                        ->from("league_team_position_score")
						->where("league_id", $id)
						->get();
 
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	public function getLeagueTeamPositionPoint($id){				
		$query = $this->db->select("*")
                        ->from("league_team_position_score")
						->where("league_id", $id)
						->order_by('score DESC')
						->get();
 
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	public function saveLeagueTeamPositionScore($data){
		if($this->db->insert('league_team_position_score', $data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	public function removeLeagueTeamPositionScore($leagueId){
		$this->db->where('league_id', $leagueId);
		$this->db->delete('league_team_position_score');
		
		return true;
	}
	
	
	public function getAllGenericActiveLeagues(){		
		$query = $this->db->select("LM.league_id,LM.league_title")
                        ->from("leagues_master LM")
						->where('league_status','1')
						->where('league_type',1)
						->order_by('league_title')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	public function getAllSingleActiveLeagues(){		
		$query = $this->db->select("LM.league_id,LM.league_title")
                        ->from("leagues_master LM")
						->where('league_status','1')
						->where('league_type',2)
						->order_by('league_title')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
}