<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Singlematchmaster_model extends CI_Model {
    
    function __construct(){
        parent::__construct(); 
    }
	
	
	/**
	 *
	 * Function used to add match info
	 *
	 * @param $data
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function save($data){
		if($this->db->insert('single_player_match_master', $data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	public function checkSingleMatchExists($match_date,$team_id){				
		$query = $this->db->select("match_id")
                        ->from("single_player_match_master")
						->where("match_date", $match_date)
						->where('match_status != 3')
						->where("team_id",$team_id)
						->get();
 
        if($query->num_rows() > 0){
			return $query->row_array();
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
	public function getTotalMatchCountForAdmin($league_id,$team){
		if(strlen($team) > 0){
			$query = $this->db->select("COUNT(SPMM.match_id) as count")
                        ->from("single_player_match_master SPMM")
						->join('teams_master TM', 'TM.team_id = SPMM.team_id', 'left')
						->where('league_id',$league_id)
						->where("(TM.team_title LIKE '%".$team."%')")
						->where('match_status != 3')
						->get();
		}else{
			$query = $this->db->select("COUNT(SPMM.match_id) as count")
                        ->from("single_player_match_master SPMM")
						->where('league_id',$league_id)
						->where('match_status != 3')
						->get();
		}
                        
        if($query->num_rows() > 0){
			$count =  $query->row();
			return $count->count;
		}else{
			return 0;
		}
	}
	
	
	/**
	 *
	 * Function used to get all match list
	 *
	 * @param $page,$perpage
	 *
	 * @return array
	 * 
	 *
	 */
	public function getAllMatchForAdmin($page,$perpage,$league_id,$team){		
		$page = $page-1;
		
		if ($page<0) { 
			$page = 0;
		}
		
		$from = $page*$perpage;
		$this->db->limit($perpage, $from);
		
		if(strlen($team) > 0){
            $query = $this->db->select("SPMM.*,TM.team_title,TM.team_logo")
							->from("single_player_match_master SPMM")
							->join('teams_master TM', 'TM.team_id = SPMM.team_id', 'left')
							->where('league_id',$league_id)
							->where("(TM.team_title LIKE '%".$team."%')")
							->where('match_status != 3')
							->group_by('SPMM.match_id')
							->order_by('SPMM.match_date DESC')
							->get();
		}else{
            $query = $this->db->select("SPMM.*,TM.team_title,TM.team_logo")
							->from("single_player_match_master SPMM")
							->join('teams_master TM', 'TM.team_id = SPMM.team_id', 'left')
							->where('league_id',$league_id)
							->where('match_status != 3')
							->group_by('SPMM.match_id')
							->order_by('SPMM.match_date DESC')
							->get();            
		}
		
		
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	public function checkMatchExistsWithOutMatchId($match_date,$team_id,$matchId){				
		$query = $this->db->select("match_id")
							->from("single_player_match_master SPMM")
							->where("match_date", $match_date)
							->where("team_id",$team_id)
							->where('match_id != '.$matchId)
							->where('match_status != 3')
							->get();
 
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to update match info
	 *
	 * @param $data, $match_id
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function update($data,$match_id){
		$this->db->where('match_id',$match_id);

		if($this->db->update('single_player_match_master',$data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	public function getMatchDetailsByMatchUrl($matchUrl){				
		$query = $this->db->select("*")
                        ->from("single_player_match_master SPMM")
						->where('match_url',$matchUrl)
						->where('match_status != 3')
						->get();
                        
        if($query->num_rows() > 0){
			return  $query->row_array();
		}else{
			return 0;
		}
	}
	
	
	public function getTeamWinningRelation($team_id,$league_id){
		$total_point = 0;
		
		#calculate match played
		$query = $this->db->select("COUNT(match_id) AS play_count, SUM(match_point) as total_point") 
                        ->from("single_player_match_master SPMM")
						->where('SPMM.team_id',$team_id)
						->where('SPMM.match_status != 3')
						->where('SPMM.is_published',1)
						->where('SPMM.league_id',$league_id)
						->get();
 
        if($query->num_rows() > 0){
			$played = $query->row_array();

			$resut_array =  array(
								'play_count' 	=> $played['play_count'] == ''?0:$played['play_count'],
								'total_point'	=> $played['total_point'] == ''?0:$played['total_point'],
							);
		
			return $resut_array;
		}else{
			$resut_array = 	array(
								'play_count' 	=> 0,
								'total_point'	=> 0
							);
		
			return $resut_array;
		}		
	}
	
	
	public function getAllPublishedMatch(){				
		$query = $this->db->select("SPMM.*")
                        ->from("single_player_match_master SPMM")
						->where('SPMM.is_published',1)
						->where('SPMM.match_status != 3')
						->get();
 
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	public function getPlayerTotalPointByLeagueId($team_id,$league_id){
		$total_point = 0;
		
		#calculate match point
		$query = $this->db->select("SUM(match_point) as total_point") 
                        ->from("single_player_match_master SPMM")
						->where('SPMM.team_id',$team_id)
						->where('SPMM.match_status != 3')
						->where('SPMM.is_published',1)
						->where('SPMM.league_id',$league_id)
						->get();
 
        if($query->num_rows() > 0){
			$point = $query->row_array();
			return $point['total_point'];
		}else{
			return 0;
		}		
	}
	
	
	public function getPlayerMatchPointByMatchId($team_id,$match_id){
		$query = $this->db->select("match_point") 
                        ->from("single_player_match_master SPMM")
						->where('SPMM.team_id',$team_id)
						->where('SPMM.match_status != 3')
						->where('SPMM.is_published',1)
						->where('SPMM.match_id',$match_id)
						->get();
 
        if($query->num_rows() > 0){
			$point = $query->row_array();
			return $point['match_point'];
		}else{
			return 0;
		}	
	}
}