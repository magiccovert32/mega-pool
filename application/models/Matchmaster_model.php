<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Matchmaster_model extends CI_Model {
    
    function __construct()
    {
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
		if($this->db->insert('match_master', $data)){
			return true;
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
		//$this->db->where('is_published','2');

		if($this->db->update('match_master',$data)){
			return true;
		}else{
			return false;
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
			$query = $this->db->select("MM.*,TM1.team_title as home_team,TM1.team_logo as home_team_logo,TM2.team_title as away_team,TM2.team_logo as away_team_logo")
							->from("match_master MM")
							->join('teams_master TM1', 'TM1.team_id = MM.home_team_id', 'left')
							->join('teams_master TM2', 'TM2.team_id = MM.away_team_id', 'left')
							->where('league_id',$league_id)
							->where("(TM1.team_title LIKE '%".$team."%' OR TM2.team_title LIKE '%".$team."%')")
							->where('match_status != 3')
							->group_by('MM.match_id')
							->order_by('MM.match_date DESC')
							->get();
		}else{
            $query = $this->db->select("MM.*,TM1.team_title as home_team,TM1.team_logo as home_team_logo,TM2.team_title as away_team,TM2.team_logo as away_team_logo")
							->from("match_master MM")
							->join('teams_master TM1', 'TM1.team_id = MM.home_team_id', 'left')
							->join('teams_master TM2', 'TM2.team_id = MM.away_team_id', 'left')
							->where('league_id',$league_id)
							->where('match_status != 3')
							->group_by('MM.match_id')
							->order_by('MM.match_date DESC')
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
	 * Function used to get all league list count
	 *
	 * @return int
	 * 
	 *
	 */
	public function getTotalMatchCountForAdmin($league_id,$team){
		if(strlen($team) > 0){
			$query = $this->db->select("COUNT(MM.match_id) as count")
                        ->from("match_master MM")
						->join('teams_master TM1', 'TM1.team_id = MM.home_team_id', 'left')
						->join('teams_master TM2', 'TM2.team_id = MM.away_team_id', 'left')
						->where('league_id',$league_id)
						->where("(TM1.team_title LIKE '%".$team."%' OR TM2.team_title LIKE '%".$team."%')")
						->where('match_status != 3')
						->get();
		}else{
			$query = $this->db->select("COUNT(MM.match_id) as count")
                        ->from("match_master MM")
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
	
	
	public function checkMatchExists($match_date,$home_team_id,$away_team_id){				
		$query = $this->db->select("match_id")
                        ->from("match_master")
						->where("match_date", $match_date)
						->where('match_status != 3')
						->where("((home_team_id = ".$home_team_id." AND away_team_id = ".$away_team_id.") OR (home_team_id = ".$away_team_id." AND away_team_id = ".$home_team_id."))")
						->get();
 
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	
	public function checkMatchExistsWithOutMatchId($match_date,$home_team_id,$away_team_id,$matchId){				
		$query = $this->db->select("match_id")
                        ->from("match_master")
						->where("match_date", $match_date)
						->where("((home_team_id = ".$home_team_id." AND away_team_id = ".$away_team_id.") OR (home_team_id = ".$away_team_id." AND away_team_id = ".$home_team_id."))")
						->where('match_id != '.$matchId)
						->where('match_status != 3')
						->get();
 
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	
	public function getMatchDetailsByMatchUrl($matchUrl){				
		$query = $this->db->select("*")
                        ->from("match_master MM")
						->where('match_url',$matchUrl)
						->where('match_status != 3')
						->get();
                        
        if($query->num_rows() > 0){
			return  $query->row_array();
		}else{
			return 0;
		}
	}
	
	
	
	public function getAllPublishedMatch(){				
		$query = $this->db->select("LM.win_point,LM.draw_point,MM.*")
                        ->from("match_master MM")
						->join('leagues_master LM', 'LM.league_id = MM.league_id', 'inner')
						->where('MM.is_published',1)
						->where('MM.match_status != 3')
						->get();
 
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	public function checkPlayerAlreadyGotPointForThisMatch($draft_id,$player_id,$league_id,$match_id){
		$query = $this->db->select("history_id")
                        ->from("player_point_history PPH")
						->where('PPH.draft_id',$draft_id)
						->where('PPH.player_id',$player_id)
						->where('PPH.league_id',$league_id)
						->where('PPH.match_id',$match_id)
						->get();
 
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	public function getTeamWinningRelation($team_id,$league_id,$win_point,$draw_point){
		$total_point = 0;
		
		#calculate match played
		$query = $this->db->select("COUNT(match_id) as total_played")
                        ->from("match_master MM")
						->where('(MM.home_team_id = '.$team_id.' OR MM.away_team_id = '.$team_id.')')
						->where('MM.match_status != 3')
						->where('MM.is_published',1)
						->where('MM.league_id',$league_id)
						->get();
 
        if($query->num_rows() > 0){
			$played = $query->row_array();
			$played = $played['total_played'];
		}else{
			$played = 0;
		}
		
		#calculate total draw
		$query = $this->db->select("COUNT(match_id) as total_draw")
                        ->from("match_master MM")
						->where('(MM.home_team_id = '.$team_id.' OR MM.away_team_id = '.$team_id.')')
						->where('MM.home_team_score = MM.away_team_score')
						->where('MM.match_status != 3')
						->where('MM.is_published',1)
						->where('MM.league_id',$league_id)
						->get();
 
        if($query->num_rows() > 0){
			$draw = $query->row_array();
			$draw = $draw['total_draw'];
		}else{
			$draw = 0;
		}
		
		$total_point = $draw*$draw_point;
		
		#calculate total home win
		$query = $this->db->select("COUNT(match_id) as total_home_win")
                        ->from("match_master MM")
						->where('MM.home_team_id = '.$team_id)
						->where('MM.home_team_score > MM.away_team_score')
						->where('MM.match_status != 3')
						->where('MM.is_published',1)
						->where('MM.league_id',$league_id)
						->get();
 
        if($query->num_rows() > 0){
			$home_win = $query->row_array();
			$home_win = $home_win['total_home_win'];
		}else{
			$home_win = 0;
		}
				
		#calculate total away win
		$query = $this->db->select("COUNT(match_id) as total_away_win")
                        ->from("match_master MM")
						->where('MM.away_team_id = '.$team_id)
						->where('MM.home_team_score < MM.away_team_score')
						->where('MM.match_status != 3')
						->where('MM.is_published',1)
						->where('MM.league_id',$league_id)
						->get();
 
        if($query->num_rows() > 0){
			$away_win = $query->row_array();
			$away_win = $away_win['total_away_win'];
		}else{
			$away_win = 0;
		}
		
		$total_win = $home_win+$away_win;
		
		$total_point = $total_point+$total_win*$win_point;
		
		$resut_array =  array(
							'play_count' 	=> $played,
							'draw_count' 	=> $draw,
							'win_count' 	=> $away_win+$home_win,
							'total_point'	=> $total_point
						);
		
		return $resut_array;
	}
	
	public function getTeamLeaguePositionScore($team_id,$league_id,$win_point,$draw_point){
		$total_point = 0;
		
		#calculate match played
		$query = $this->db->select("COUNT(match_id) as total_played")
                        ->from("match_master MM")
						->where('(MM.home_team_id = '.$team_id.' OR MM.away_team_id = '.$team_id.')')
						->where('MM.match_status != 3')
						->where('MM.is_published',1)
						->where('MM.league_id',$league_id)
						->get();
 
        if($query->num_rows() > 0){
			$played = $query->row_array();
			$played = $played['total_played'];
		}else{
			$played = 0;
		}
		
		#calculate total draw
		$query = $this->db->select("COUNT(match_id) as total_draw")
                        ->from("match_master MM")
						->where('(MM.home_team_id = '.$team_id.' OR MM.away_team_id = '.$team_id.')')
						->where('MM.home_team_score = MM.away_team_score')
						->where('MM.match_status != 3')
						->where('MM.is_published',1)
						->where('MM.league_id',$league_id)
						->get();
 
        if($query->num_rows() > 0){
			$draw = $query->row_array();
			$draw = $draw['total_draw'];
		}else{
			$draw = 0;
		}
		
		$total_point = $draw*$draw_point;
		
		#calculate total home win
		$query = $this->db->select("COUNT(match_id) as total_home_win")
                        ->from("match_master MM")
						->where('MM.home_team_id = '.$team_id)
						->where('MM.home_team_score > MM.away_team_score')
						->where('MM.match_status != 3')
						->where('MM.is_published',1)
						->where('MM.league_id',$league_id)
						->get();
 
        if($query->num_rows() > 0){
			$home_win = $query->row_array();
			$home_win = $home_win['total_home_win'];
		}else{
			$home_win = 0;
		}
				
		#calculate total away win
		$query = $this->db->select("COUNT(match_id) as total_away_win")
                        ->from("match_master MM")
						->where('MM.away_team_id = '.$team_id)
						->where('MM.home_team_score < MM.away_team_score')
						->where('MM.match_status != 3')
						->where('MM.is_published',1)
						->where('MM.league_id',$league_id)
						->get();
 
        if($query->num_rows() > 0){
			$away_win = $query->row_array();
			$away_win = $away_win['total_away_win'];
		}else{
			$away_win = 0;
		}
		
		$total_win = $home_win+$away_win;
		
		$total_point = $total_point+$total_win*$win_point;
		
		$resut_array =  array(
							'play_count' 	=> $played,
							'draw_count' 	=> $draw,
							'win_count' 	=> $away_win+$home_win,
							'total_point'	=> $total_point
						);
		
		return $resut_array;
	}
}