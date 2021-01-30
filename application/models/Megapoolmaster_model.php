<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Megapoolmaster_model extends CI_Model {
    
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
		if($this->db->insert('mega_pool_master', $data)){
			return $this->db->insert_id();
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
		if($this->db->insert('mega_pool_league_relation', $data)){
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
	
		if($this->db->delete('mega_pool_league_relation')){
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

		if($this->db->update('mega_pool_master',$data)){
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
                        ->from("mega_pool_master")
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
                        ->from("mega_pool_master")
						->where("mega_pool_title", $title)
						->where("mega_pool_id !=".$id)
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
	 * @param $page,$perpage,$userId
	 *
	 * @return array
	 * 
	 *
	 */
	public function getAllLeaguesByCommissionerId($page,$perpage, $userId){		
		$page = $page-1;
		
		if ($page<0) { 
			$page = 0;
		}
		
		$from = $page*$perpage;
		$this->db->limit($perpage, $from);
		
		$query = $this->db->select("MPM.mega_pool_id,MPM.entry_fee,MPM.mega_pool_url,MPM.mega_pool_title,MPM.related_sport_id,MPM.league_logo,MPM.created_on,MPM.current_status,COUNT(MPPR.player_id) as player_count")
						->from("mega_pool_master MPM")
						->join('mega_pool_player_relation MPPR', 'MPPR.megapool_id = MPM.mega_pool_id', 'left')
						->where('MPM.created_by',$userId)
						->where("MPM.current_status != 3")
						->group_by('MPM.mega_pool_id')
						->order_by('created_on DESC')
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
	public function getTotalLeagueCountCommissionerId($userId){				
		$query = $this->db->select("COUNT(MPM.mega_pool_id) as count")
						->from("mega_pool_master MPM")
						->where('MPM.created_by',$userId)
						->where("MPM.current_status != 3")
						->get();
                        
        if($query->num_rows() > 0){
			$count =  $query->row();
			return $count->count;
		}else{
			return 0;
		}
	}
	
	
	public function getTotalPlayerCountByCommissionerId($userId){				
		$query = $this->db->select("COUNT(MPPR.player_id) as count")
						->from("mega_pool_master MPM")
						->join('mega_pool_player_relation MPPR', 'MPPR.megapool_id = MPM.mega_pool_id', 'inner')
						->where('MPM.created_by',$userId)
						->where("MPM.current_status != 3")
						->get();
                        
        if($query->num_rows() > 0){
			$count =  $query->row();
			return $count->count;
		}else{
			return 0;
		}
	}
	
	
	public function getAllActiveMegapoolByCommissionerId($userId){				
		$query = $this->db->select("MPM.mega_pool_id,MPM.entry_fee,MPM.mega_pool_url,MPM.mega_pool_title,MPM.related_sport_id,MPM.league_logo,MPM.created_on,MPM.current_status,SM.sport_title")
						->from("mega_pool_master MPM")
						->join('sports_master SM', 'SM.sport_id = MPM.related_sport_id', 'inner')
						->where('MPM.created_by',$userId)
						->where("MPM.current_status != 3")
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}

	
	public function getAllActiveDraftLeagueByPlayerId($userId){				
		$query = $this->db->select("LM.league_id,league_title,DM.draft_url,DM.draft_title")
						->from("draft_player_relation DPR")
						->join('draft_master DM', 'DM.draft_id = DPR.draft_id', 'inner')
						->join('leagues_master LM', 'LM.league_id = DM.league_id', 'inner')
						->where('DPR.player_id',$userId)
						->get();

        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	public function getAllPlayersByMegapoolLeagueId($page,$perpage, $leagueId){		
		$page = $page-1;
		
		if ($page<0) { 
			$page = 0;
		}
		
		$from = $page*$perpage;
		$this->db->limit($perpage, $from);
		
		$query = $this->db->select("MPPR.joined_on,UM.full_name,UM.profile_image")
							->from("mega_pool_player_relation MPPR")
							->join('user_master UM', 'UM.user_id = MPPR.player_id', 'inner')
							->where('MPPR.megapool_id',$leagueId)
							->order_by('MPPR.joined_on DESC')
							->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	public function getTotalCountOfPlayersByMegapoolLeagueId($leagueId){				
		$query = $this->db->select("COUNT(MPPR.player_id) as count")
						->from("mega_pool_player_relation MPPR")
						->join('user_master UM', 'UM.user_id = MPPR.player_id', 'inner')
						->where('MPPR.megapool_id',$leagueId)
						->get();
                        
        if($query->num_rows() > 0){
			$count =  $query->row();
			return $count->count;
		}else{
			return 0;
		}
	}


	public function getLeagueDetailsByUrlAndCommissionerId($url,$userId){				
		$query = $this->db->select("*")
						->from("mega_pool_master MPM")
						->where('MPM.mega_pool_url',$url)
						->where('MPM.created_by',$userId)
						->where("current_status != 4")
						->where("current_status != 3")
						->get();
                        
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	
	public function getLeagueDetailsByUrlAndCommissionerIdWithoutRestriction($url,$userId){				
		$query = $this->db->select("*")
						->from("mega_pool_master MPM")
						->where('MPM.mega_pool_url',$url)
						->where('MPM.created_by',$userId)
						->where("current_status != 3")
						->get();
                        
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	
	public function getPublichedLeagueDetailsByUrlAndCommissionerId($url,$userId){				
		$query = $this->db->select("*")
						->from("mega_pool_master MPM")
						->where('MPM.mega_pool_url',$url)
						->where('MPM.created_by',$userId)
						->where("current_status", '4')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}



	public function getLeagueDetailsByUrl($url){				
		$query = $this->db->select("MPM.*,UM.full_name,UM.profile_image")
						->from("mega_pool_master MPM")
						->join('user_master UM', 'UM.user_id = MPM.created_by', 'inner')
						->where('MPM.mega_pool_url',$url)
						->where("MPM.current_status",4)
						->get();
                        
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}


	public function getAllSelectedLeagueByMegaPoolId($id){				
		$query = $this->db->select("*")
						->from("mega_pool_league_relation MPLR")
						->where('MPLR.mega_pool_id',$id)
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	
	public function getAllSelectedLeagueDetailsByMegaPoolId($id){				
		$query = $this->db->select("LM.league_id,LM.league_title,LM.league_logo,LM.league_type,LM.win_point,LM.draw_point")
						->from("mega_pool_league_relation MPLR")
						->join('leagues_master LM', 'LM.league_id = MPLR.league_id', 'inner')
						->where('MPLR.mega_pool_id',$id)
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	
	public function getAllJoinedPlayersCountByMegaPoolId($id){				
		$query = $this->db->select("COUNT(player_id) as player_count")
						->from("mega_pool_player_relation MPPR")
						->where('MPPR.megapool_id',$id)
						->get();
                        
        if($query->num_rows() > 0){
			$res = $query->row_array();
			return $res['player_count'];
		}else{
			return false;
		}
	}
	
	
	
	public function getAllSelectedSports($id){				
		$query = $this->db->select("MPM.related_sport_id")
						->from("mega_pool_master MPM")
						->where('MPM.mega_pool_id',$id)
						->get();
                        
        if($query->num_rows() > 0){
			$sports = $query->row_array();
			
			$sportArray = explode(',',$sports['related_sport_id']);
			
			$finalResult = array();
			
			foreach($sportArray as $s_id){
				$query = $this->db->select("SM.sport_title")
						->from("sports_master SM")
						->where('SM.sport_id',$s_id)
						->get();
                        
				if($query->num_rows() > 0){
					$finalResult[] = $query->row_array();
				}else{
					return false;
				}
			}
			
			return $finalResult;
		}else{
			return false;
		}
	}



	/**
	 *
	 * Function used to get all megapool list count
	 *
	 * @return int
	 * 
	 *
	 */
	public function getTotalCountPublishedMegapoolList(){				
		$query = $this->db->select("COUNT(MPM.mega_pool_id) as count")
							->from("mega_pool_master MPM")
							->where("MPM.current_status",'4')
							->get();
                        
        if($query->num_rows() > 0){
			$count =  $query->row();
			return $count->count;
		}else{
			return 0;
		}
	}



	public function getPublishedMegapoolList($page,$perpage){		
		$page = $page-1;
		
		if ($page<0) { 
			$page = 0;
		}
		
		$from = $page*$perpage;
		$this->db->limit($perpage, $from);
		
		$query = $this->db->select("MPM.mega_pool_id,MPM.published_on,MPM.entry_fee,MPM.mega_pool_url,MPM.mega_pool_title,MPM.related_sport_id,MPM.league_logo,MPM.created_on,MPM.current_status,SM.sport_title")
						->from("mega_pool_master MPM")
						->join('sports_master SM', 'SM.sport_id = MPM.related_sport_id', 'inner')
						->where("MPM.current_status",'4')
						->group_by('MPM.mega_pool_id')
						->order_by('MPM.published_on DESC')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	
	public function savePlayerRelation($data,$poolId,$playerId){
		$query = $this->db->select("*")
						->from("mega_pool_player_relation MPPR")
						->where('MPPR.player_id',$playerId)
						->where('MPPR.megapool_id',$poolId)
						->get();
                        
        if($query->num_rows() > 0){
			return false;
		}else{
			if($this->db->insert('mega_pool_player_relation', $data)){
				return $this->db->insert_id();
			}else{
				return false;
			}
		}
	}
	
	
	
	
	/**
	 *
	 * Function used to get my megapool list count
	 *
	 * @return int
	 * 
	 *
	 */
	public function getTotalCountMyMegapoolList($userId){				
		$query = $this->db->select("COUNT(MPM.mega_pool_id) as count")
							->from("mega_pool_master MPM")
							->join('mega_pool_player_relation MPPR', 'MPPR.megapool_id = MPM.mega_pool_id', 'inner')
							->where("MPM.current_status",'4')
							->where('MPPR.player_id',$userId)
							->get();
                        
        if($query->num_rows() > 0){
			$count =  $query->row();
			return $count->count;
		}else{
			return 0;
		}
	}



	public function getMyMegapoolList($page,$perpage,$userId){		
		$page = $page-1;
		
		if ($page<0) { 
			$page = 0;
		}
		
		$from = $page*$perpage;
		$this->db->limit($perpage, $from);
		
		$query = $this->db->select("MPM.mega_pool_id,MPM.published_on,MPM.entry_fee,MPM.mega_pool_url,MPM.mega_pool_title,MPM.related_sport_id,MPM.league_logo,MPM.created_on,MPM.current_status,SM.sport_title,MPPR.joined_on")
						->from("mega_pool_master MPM")
						->join('mega_pool_player_relation MPPR', 'MPPR.megapool_id = MPM.mega_pool_id', 'inner')
						->join('sports_master SM', 'SM.sport_id = MPM.related_sport_id', 'inner')
						->where("MPM.current_status",'4')
						->group_by('MPM.mega_pool_id')
						->where('MPPR.player_id',$userId)
						->order_by('MPPR.joined_on DESC')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	public function getLeagueDetailsByUrlAndPlayerId($url,$userId){				
		$query = $this->db->select("MPM.*,UM.full_name,UM.profile_image")
						->from("mega_pool_master MPM")
						->join('mega_pool_player_relation MPPR', 'MPPR.megapool_id = MPM.mega_pool_id', 'inner')
						->join('user_master UM', 'UM.user_id = MPM.created_by', 'inner')
						->where('MPM.mega_pool_url',$url)
						->where('MPPR.player_id',$userId)
						->where("MPM.current_status",'4')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	
	public function getTotalPlayerCountByLeagueId($megapool_id){				
		$query = $this->db->select("COUNT(MPPR.relation_id) as count")
						->from("mega_pool_player_relation MPPR")
						->where('MPPR.megapool_id',$megapool_id)
						->get();
                        
        if($query->num_rows() > 0){
			$count =  $query->row();
			return $count->count;
		}else{
			return 0;
		}
	}
	
	
	
	public function getRelatedLeagueByMegaPoolId($poolId){				
		$query = $this->db->select("LM.league_title,LM.league_logo,LM.league_id")
						->from("mega_pool_league_relation MPLR")
						->join('leagues_master LM', 'LM.league_id = MPLR.league_id', 'inner')
						->where('MPLR.mega_pool_id',$poolId)
						->where("LM.league_status",'1')
						->group_by('LM.league_id')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	
	public function getLeagueDetailsByIdAndCommiossionerId($id,$userId){				
		$query = $this->db->select("MPM.mega_pool_url,MPM.mega_pool_id")
						->from("mega_pool_master MPM")
						->where('MPM.mega_pool_id',$id)
						->where('MPM.created_by',$userId)
						->where("MPM.current_status",'4')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	public function getPlayerListByMegapoolId($id){
		$query = $this->db->select("UM.user_id,UM.full_name,UM.user_email")
						->from("mega_pool_player_relation MPPR")
						->join('user_master UM', 'UM.user_id = MPPR.player_id', 'inner')
						->where('MPPR.megapool_id',$id)
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	
	public function checkUserAccessToMegapoolAsPlayer($megapoolId,$user_id){
		$query = $this->db->select("player_id")
						->from("mega_pool_player_relation MPPR")
						->where('MPPR.megapool_id',$megapoolId)
						->where('MPPR.player_id',$user_id)
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	public function getPlayerMegapoolList($userId){		
		$query = $this->db->select("MPM.mega_pool_id,MPM.entry_fee,MPM.mega_pool_url,MPM.mega_pool_title")
						->from("mega_pool_master MPM")
						->join('mega_pool_player_relation MPPR', 'MPPR.megapool_id = MPM.mega_pool_id', 'inner')
						->join('sports_master SM', 'SM.sport_id = MPM.related_sport_id', 'inner')
						->where("MPM.current_status",'4')
						->group_by('MPM.mega_pool_id')
						->where('MPPR.player_id',$userId)
						->order_by('MPPR.joined_on DESC')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
}