<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invitationmaster_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct(); 
    }
	
	
	/**
	 *
	 * Function used to add invitation info
	 *
	 * @param $data
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function save($data){
		if($this->db->insert('invitation_master', $data)){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}
	
	
	
	/**
	 *
	 * Function used to get all invitation list
	 *
	 * @param $page,$perpage,$email
	 *
	 * @return array
	 * 
	 *
	 */
	public function getInvitationListByUserEmail($page,$perpage,$email){		
		$page = $page-1;
		
		if ($page<0) { 
			$page = 0;
		}
		
		$from = $page*$perpage;
		$this->db->limit($perpage, $from);
		
		$query = $this->db->select("IM.*,MPM.mega_pool_url,MPM.mega_pool_title,MPM.entry_fee,MPM.league_logo,UM.full_name,SM.sport_title")
							->from("invitation_master IM")
							->join('mega_pool_master MPM', 'MPM.mega_pool_id = IM.megapool_id', 'inner')
							->join('sports_master SM', 'SM.sport_id = MPM.related_sport_id', 'inner')
							->join('user_master UM', 'MPM.created_by = UM.user_id', 'inner')
							->where('IM.to_email',$email)
							->where('IM.invitation_accepted','3')
							->group_by('megapool_id')
							->order_by('created_date DESC')
							->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to get all invitation
	 *
	 * @package $email
	 * 
	 * @return int
	 * 
	 *
	 */
	public function getTotalCountInvitationListByUserEmail($email){				
		$query = $this->db->select("COUNT(IM.invitation_id) as count")
							->from("invitation_master IM")
							->where('IM.to_email',$email)
							->where('IM.invitation_accepted','3')
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
	 * Function used to get all invitation list count
	 *
	 * @return int
	 * 
	 *
	 */
	public function getTotalInvitationCountCommissionerId($userId){				
		$query = $this->db->select("COUNT(IM.invitation_id ) as count")
						->from("invitation_master IM")
						->join('mega_pool_master MPM', 'MPM.mega_pool_id = IM.megapool_id', 'inner')
						->where('MPM.created_by',$userId)
						->get();
                        
        if($query->num_rows() > 0){
			$count =  $query->row();
			return $count->count;
		}else{
			return 0;
		}
	}
	
	
	public function getAllInvitationByCommissionerId($page,$perpage, $userId){		
		$page = $page-1;
		
		if ($page<0) { 
			$page = 0;
		}
		
		$from = $page*$perpage;
		$this->db->limit($perpage, $from);
		
		$query = $this->db->select("IM.*,MPM.mega_pool_title")
						->from("invitation_master IM")
						->join('mega_pool_master MPM', 'MPM.mega_pool_id = IM.megapool_id', 'inner')
						->where('MPM.created_by',$userId)
						->group_by('IM.invitation_id')
						->order_by('IM.created_date DESC')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	public function checkInvitationByLeagueIdAndUserEmail($email,$id){				
		$query = $this->db->select("COUNT(IM.invitation_id) as count")
							->from("invitation_master IM")
							->where('IM.to_email',$email)
							->where('IM.megapool_id',$id)
							->where('IM.invitation_accepted','3')
							->get();
                        
        if($query->num_rows() > 0){
			$count =  $query->row();
			return $count->count;
		}else{
			return 0;
		}
	}
	
	
	
	public function updateInvitationStatus($email,$data,$leagueId){
		$this->db->where('to_email',$email);
		$this->db->where('megapool_id',$leagueId);
		
		if($this->db->update('invitation_master',$data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	
	public function getInvitationDetails($url,$email){				
		$query = $this->db->select("IM.*,MPM.mega_pool_id,MPM.mega_pool_url,MPM.mega_pool_title,MPM.entry_fee,MPM.league_logo,UM.full_name,SM.sport_title")
							->from("invitation_master IM")
							->join('mega_pool_master MPM', 'MPM.mega_pool_id = IM.megapool_id', 'inner')
							->join('sports_master SM', 'SM.sport_id = MPM.related_sport_id', 'inner')
							->join('user_master UM', 'MPM.created_by = UM.user_id', 'inner')
							->where('IM.to_email',$email)
							->where('IM.invitation_code',$url)
							->where('IM.invitation_accepted','3')
							->group_by('megapool_id')
							->order_by('created_date DESC')
							->get();
                        
        if($query->num_rows() > 0){
			return  $query->row_array();
		}else{
			return false;
		}
	}
}