<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Draftmaster_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct(); 
    }
	
	
	/**
	 *
	 * Function used to add draft info
	 *
	 * @param $data
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function save($data){
		if($this->db->insert('draft_master', $data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to update draft info
	 *
	 * @param $data, $draft_id
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function update($data,$draft_id){
		$this->db->where('draft_id',$draft_id);

		if($this->db->update('draft_master',$data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	public function getTotalDraftCountCommissionerId($userId){				
		$query = $this->db->select("COUNT(DM.draft_id) as count")
							->from("draft_master DM")
							->where("DM.user_id",$userId)
							->where("DM.draft_status",4)
							->get();
                        
        if($query->num_rows() > 0){
			$count =  $query->row();
			
			return $count->count;
		}else{
			return 0;
		}
	}
	
	
	public function getDraftDetailsByUrlAndCommissionerId($url,$userId){				
		$query = $this->db->select("DM.*")
							->from("draft_master DM")
							->where("DM.user_id",$userId)
							->where("DM.draft_url",$url)
							->where("DM.draft_status != 3")
							//->where("DM.draft_status != 4")
							->get();
                        
        if($query->num_rows() > 0){
			return  $query->row_array();
		}else{
			return 0;
		}
	}
	
	
	public function getDraftDetailsByUrlAndCommissionerIdWithoutCondition($url,$userId){				
		$query = $this->db->select("DM.*,MPM.mega_pool_title,MPM.mega_pool_url,LM.league_title")
							->from("draft_master DM")
							->join('mega_pool_master MPM', 'MPM.mega_pool_id = DM.megapool_id', 'inner')
							->join('leagues_master LM', 'LM.league_id = DM.league_id', 'inner')
							->where("DM.user_id",$userId)
							->where("DM.draft_url",$url)
							->where("DM.draft_status != 3")
							->get();
                        
        if($query->num_rows() > 0){
			return  $query->row_array();
		}else{
			return 0;
		}
	}
	
	
	public function getDraftBriefDetailsByUrlAndCommissionerId($url,$userId){				
		$query = $this->db->select("DM.*")
							->from("draft_master DM")
							->where("DM.user_id",$userId)
							->where("DM.draft_url",$url)
							->where("DM.draft_status != 3")
							->get();
                        
        if($query->num_rows() > 0){
			return  $query->row_array();
		}else{
			return 0;
		}
	}
	
	public function getAllDraftByCommissionerId($page,$perpage,$userId){		
		$page = $page-1;
		
		if ($page<0) { 
			$page = 0;
		}
		
		$from = $page*$perpage;
		$this->db->limit($perpage, $from);
		
		$query = $this->db->select("DM.*")
						->from("draft_master DM")
						->where("DM.user_id",$userId)
						->where("DM.draft_status != 3")
						->order_by('DM.created_on DESC')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	
	public function getDraftDetailsByDraftUrl($draft_url){				
		$query = $this->db->select("DM.*")
							->from("draft_master DM")
							->join('draft_player_relation DPR', 'DPR.draft_id = DM.draft_id', 'left')
							->where("DM.draft_url",$draft_url)
							->where("DM.draft_status",'4')
							->get();
                        
        if($query->num_rows() > 0){
			return  $query->row_array();
		}else{
			return 0;
		}
	}
	
	
	
	public function saveDraftPlayerRelation($data,$user_id,$draft_id){
		$query = $this->db->select("DPR.relation_id")
							->from("draft_player_relation DPR")
							->where("DPR.player_id",$user_id)
							->where("DPR.draft_id",$draft_id)
							->get();
                        
        if($query->num_rows() > 0){
			$details =  $query->row_array();
			
			$this->db->where('relation_id',$details['relation_id']);

			if($this->db->update('draft_player_relation',$data)){
				return true;
			}else{
				return false;
			}
		}else{
			if($this->db->insert('draft_player_relation', $data)){
				return true;
			}else{
				return false;
			}
		}
	}
	
	
	
	public function updateDraftRelationByDraftRelationId($data,$relation_id){
		$this->db->where('relation_id',$relation_id);

		if($this->db->update('draft_player_relation',$data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	
	public function checkDraftPlayerRelation($draft_id,$player_id){				
		$query = $this->db->select("DPR.team_id")
							->from("draft_player_relation DPR")
							->where("DPR.draft_id",$draft_id)
							->where("DPR.player_id",$player_id)
							->get();
                        
        if($query->num_rows() > 0){
			$result =  $query->row_array();
			return $result['team_id'];
		}else{
			return 0;
		}
	}
	
	
	
	public function checkUserSelectedTeam($draft_id,$player_id){				
		$query = $this->db->select("TM.team_title,TM.team_id,TM.team_logo")
							->from("draft_player_relation DPR")
							->join('teams_master TM', 'TM.team_id = DPR.team_id', 'inner')
							->where("DPR.draft_id",$draft_id)
							->where("DPR.player_id",$player_id)
							->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return 0;
		}
	}
	
	
	public function getTotalDraftCountPlayerId($userId){				
		$query = $this->db->select("COUNT(DM.draft_id) as count")
							->from("mega_pool_player_relation MPPR")
							->join('draft_master DM', 'DM.megapool_id = MPPR.megapool_id', 'inner')
							->join('mega_pool_master MPM', 'MPM.mega_pool_id = MPPR.megapool_id', 'inner')
							->where("MPPR.player_id",$userId)
							->where("DM.draft_status",'4')
							->where("MPM.current_status",'4')
							->get();
                        
        if($query->num_rows() > 0){
			$count =  $query->row();
			return $count->count;
		}else{
			return 0;
		}
	}
	
	
	
	public function getAllDraftByPlayerId($page,$perpage,$userId){		
		$page = $page-1;
		
		if ($page<0) { 
			$page = 0;
		}
		
		$from = $page*$perpage;
		$this->db->limit($perpage, $from);
		
		$query = $this->db->select("DM.*,TM.team_title,LM.league_title")
						->from("mega_pool_player_relation MPPR")
						->join('draft_master DM', 'DM.megapool_id = MPPR.megapool_id', 'inner')
						->join('leagues_master LM', 'LM.league_id = DM.league_id', 'inner')
						->join('mega_pool_master MPM', 'MPM.mega_pool_id = MPPR.megapool_id', 'inner')
						->join('draft_player_relation DPR', 'DPR.draft_id = DM.draft_id', 'left')
						->join('teams_master TM', 'TM.team_id = DPR.team_id', 'left')
						->where("MPPR.player_id",$userId)
						->where("DM.draft_status",'4')
						->where("MPM.current_status",'4')
						->group_by("DM.draft_id")
						->order_by('DM.created_on DESC')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	public function getAllLeaguesByDraftAndMegapool($megapool_id){				
		$query = $this->db->select("GROUP_CONCAT(DM.league_id) as league_ids")
							->from("draft_master DM")
							->where("DM.megapool_id",$megapool_id)
							->get();
                        
        if($query->num_rows() > 0){
			return  $query->row_array();
		}else{
			return 0;
		}
	}
	
	public function getAllSelectedTeamByDraftId($draft_id){				
		$query = $this->db->select("GROUP_CONCAT(DPR.team_id) as team_ids")
							->from("draft_player_relation DPR")
							->where("DPR.draft_id",$draft_id)
							->get();
                        
        if($query->num_rows() > 0){
			$res = $query->row_array();
            
            if($res['team_ids'] != ""){
                return $res['team_ids'];
            }else{
                return false;
            }
		}else{
			return false;
		}
	}
	
    public function get_all_available_teams_by_draft($draft_id,$selected_players){
        if($selected_players){
            $query = $this->db->select("TM.team_id,TM.team_title,TM.team_logo")
							->from("draft_master DM")
							->join('league_team_relation LMR', 'LMR.league_id = DM.league_id', 'inner')
                            ->join('teams_master TM', 'TM.team_id = LMR.team_id', 'inner')
							->where("DM.draft_id",$draft_id)
                            ->where_not_in('TM.team_id', $selected_players)
                            ->order_by('TM.team_title')
							->get();
        }else{
            $query = $this->db->select("TM.team_id,TM.team_title,TM.team_logo")
							->from("draft_master DM")
							->join('league_team_relation LMR', 'LMR.league_id = DM.league_id', 'inner')
                            ->join('teams_master TM', 'TM.team_id = LMR.team_id', 'inner')
							->where("DM.draft_id",$draft_id)
                            ->order_by('TM.team_title')
							->get();
        }
                                
        if($query->num_rows() > 0){
			return  $query->result_array();
		}else{
			return false;
		}
	}
	
	public function checkAllPlayerDraftRelationWithTeamIdAndLeagueId($team_id,$league_id,$match_date){
		$date = @date('Y-m-d H:i:s',strtotime($match_date));
		
		$query = $this->db->select("DPR.*,DM.league_id")
							->from("draft_player_relation DPR")
							->join('draft_master DM', 'DM.draft_id = DPR.draft_id', 'inner')
							->where("DM.league_id",$league_id)
							->where("DPR.team_id",$team_id)
							//->where('DM.team_selection_ends_on <= DATE("'.$date.'")')
							->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	
	public function getDraftDetailsByDraftRelationId($relation_id){				
		$query = $this->db->select("DPR.*")
							->from("draft_player_relation DPR")
							->where("DPR.relation_id",$relation_id)
							->get();
                        
        if($query->num_rows() > 0){
			return  $query->row_array();
		}else{
			return 0;
		}
	}
	
	
	public function savePointHistory($data){
		if($this->db->insert('player_point_history', $data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	public function getAllDraftListByMegaPoolId($mega_pool_id){
		$query = $this->db->select("DM.*")
							->from("draft_master DM")
							->where("DM.megapool_id",$mega_pool_id)
							->get();
                        
        if($query->num_rows() > 0){
			return  $query->result_array();
		}else{
			return 0;
		}
	}
	
	
	public function getAllPublishedDraftListByMegaPoolId($mega_pool_id){
		$query = $this->db->select("DM.*")
							->from("draft_master DM")
							->where("DM.megapool_id",$mega_pool_id)
							->where("DM.draft_status",'4')
							->get();
                        
        if($query->num_rows() > 0){
			return  $query->result_array();
		}else{
			return '0';
		}
	}
	
	
	public function getPointRecordByLeagueIdAndDraftIds($league_id,$draft_IDS,$playerId){
		$query = $this->db->select("SUM(DPR.total_point) as total_point")
							->from("draft_player_relation DPR")
							->join('draft_master DM', 'DM.draft_id = DPR.draft_id', 'inner')
							->where("DM.league_id",$league_id)
							->where("DPR.player_id",$playerId)
							->where_in("DPR.draft_id",$draft_IDS)
							->get();

        if($query->num_rows() > 0){
			$res =  $query->row_array();
			
			if($res['total_point'] > 0){
                return $res['total_point'];
            }else{
                return 0;
            }
		}else{
			return 0;
		}
	}
	
	
	public function getTeamRecordByLeagueIdAndDraftIds($league_id,$draft_IDS,$playerId){
		$query = $this->db->select("TM.team_title,TM.team_id")
							->from("draft_player_relation DPR")
							->join('draft_master DM', 'DM.draft_id = DPR.draft_id', 'inner')
							->join('teams_master TM', 'TM.team_id = DPR.team_id', 'inner')
							->where("DM.league_id",$league_id)
							->where("DPR.player_id",$playerId)
							->where_in("DPR.draft_id",$draft_IDS)
							->get();
                        
        if($query->num_rows() > 0){
			$res =  $query->result_array();
			
			return $res;
		}else{
			return false;
		}
	}
	
	
	public function getAllDraftPlayer($draft_id){
		$query = $this->db->select("DPR.player_id")
							->from("draft_player_relation DPR")
							->where("DPR.draft_id",$draft_id)
							->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	public function getPlayerDraftRelationWithTeamIDAndLeagueId($team_id,$league_id){
		$query = $this->db->select("DPR.*")
							->from("draft_player_relation DPR")
							->join('draft_master DM', 'DM.draft_id = DPR.draft_id', 'inner')
							->where("DM.league_id",$league_id)
							->where("DPR.team_id",$team_id)
							->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
    
    public function removeDraftPlayerRelation($user_id,$draft_id){
        $this->db->where('player_id', $user_id);
        $this->db->where('draft_id', $draft_id);
	
		if($this->db->delete('draft_player_relation')){
			return true;
		}else{
			return false;
		}
    }
    
    public function saveRelation($data){
		if($this->db->insert('draft_player_relation', $data)){
            return true;
        }else{
            return false;
        }
	}
    
    public function checkDraftSelectionTiming($user_id){
		$query = $this->db->select("DM.draft_url,DM.draft_url,DM.team_selection_ended,DM.team_selection_started")
							->from("mega_pool_player_relation MPPR")
							->join('draft_master DM', 'DM.megapool_id = MPPR.megapool_id', 'inner')
							->where("MPPR.player_id",$user_id)
                            ->where("DM.draft_status = 4")
                            ->group_by('DM.draft_id')
							->get();
    
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
    
    public function checkMySelectionTurn($draft_id,$user_id){
		$query = $this->db->select("MPPR.turn,MPPR.turn_started_at")
							->from("draft_master DM")
                            ->join('mega_pool_player_relation MPPR', 'MPPR.megapool_id = DM.megapool_id', 'inner')
							->where("MPPR.player_id",$user_id)
                            ->where("DM.draft_id",$draft_id)
                            ->where("DM.team_selection_ended",2)
                            ->where("DM.team_selection_started",1)
							->get();
                            
        if($query->num_rows() > 0){
			$res = $query->row_array();
            
            return $res;
		}else{
			return false;
		}
	}
    
    
    public function getAlreadySelectedTeams($draft_id){
		$query = $this->db->select("TM.team_title,TM.team_logo")
							->from("draft_player_relation DPR")
                            ->join('teams_master TM', 'TM.team_id = DPR.team_id', 'inner')
                            ->where("DPR.draft_id",$draft_id)
							->get();
                            
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
    
    public function getPlayerByTurn($megapool_id,$current_round,$current_player_order){
        if($current_round % 2 == 0){
            $orderBy = "ASC";
        }else{
            $orderBy = "DESC";
        }
        
        $current_player_order = $current_player_order - 1;
        
		$query = $this->db->select("MPPR.player_id")
							->from("mega_pool_player_relation MPPR")
                            ->where("MPPR.megapool_id",$megapool_id)
                            ->order_by("MPPR.joined_on",$orderBy)
                            ->offset($current_player_order)
                            ->limit(1)
							->get();

        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
    
    public function updatePlayerTurn($data,$player_id,$megapool_id){
        $this->db->where('megapool_id',$megapool_id);

        $resetData = array(
                        'turn' => 2,
                        'turn_started_at' => null,
                        );
        
        $this->db->update('mega_pool_player_relation',$resetData);
        
        $this->db->where('player_id',$player_id);
        $this->db->where('megapool_id',$megapool_id);
        
		if($this->db->update('mega_pool_player_relation',$data)){
			return true;
		}else{
			return false;
		}
	}
    
    public function resetAllPlayerTurn($megapool_id){
        $this->db->where('megapool_id',$megapool_id);

        $resetData = array(
                        'turn' => 2,
                        'turn_started_at' => null,
                        );
                
		if($this->db->update('mega_pool_player_relation',$resetData)){
			return true;
		}else{
			return false;
		}
	}
}