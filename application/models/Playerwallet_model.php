<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Playerwallet_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct(); 
    }
	
	
	/**
	 *
	 * Function used to add wallet info
	 *
	 * @param $data
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function save($data){
		if($this->db->insert('player_wallet', $data)){
			return $this->db->insert_id();
		}else{
			return false;
		}
    }
    


    public function saveWalletHistory($data){
		if($this->db->insert('player_wallet_transaction_history', $data)){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}


	public function getWallet($userId){
		$query = $this->db->select("*")
						->from("player_wallet PW")
						->where('PW.user_id',$userId)
						->get();
                        
        if($query->num_rows() > 0){
			return  $query->row_array();
		}else{
			return 0;
		}
	}


	public function getTotalTransactionByUserIdAndTransactionType($wallet_id,$transactionType){
		$query = $this->db->select("SUM(PWTH.transaction_amount) as amount")
						->from("player_wallet_transaction_history PWTH")
						->where('PWTH.wallet_id',$wallet_id)
						->where('PWTH.transaction_type',$transactionType)
						->get();
                        
		if($query->num_rows() > 0){
			$result =  $query->row_array();
			
			if($result['amount']){
				return $result['amount'];
			}else{
				return 0;
			}
			
		}else{
			return '0';
		}
	}




	/**
	 *
	 * Function used to get all transaction list count
	 *
	 * @return int
	 * 
	 *
	 */
	public function getTotalTransactionList($userId){				
		$query = $this->db->select("COUNT(PWTH.history_id) as count")
						->from("player_wallet_transaction_history PWTH")
						->join('player_wallet PW', 'PW.player_wallet_id = PWTH.wallet_id', 'inner')
						->where('PW.user_id',$userId)
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
	 * Function used to get all transaction list
	 *
	 * @return array
	 * 
	 *
	 */
	public function getAllTransactionByUserId($page,$perpage, $userId){	
		$page = $page-1;
		
		if ($page<0) { 
			$page = 0;
		}
		
		$from = $page*$perpage;
		$this->db->limit($perpage, $from);

		$query = $this->db->select("*")
						->from("player_wallet_transaction_history PWTH")
						->join('player_wallet PW', 'PW.player_wallet_id = PWTH.wallet_id', 'inner')
						->where('PW.user_id',$userId)
						->group_by('PWTH.history_id')
						->order_by('PWTH.transaction_date DESC')
						->get();
                        
        if($query->num_rows() > 0){
			return  $query->result_array();
		}else{
			return 0;
		}
	}
	
	
	
	public function updateWallet($data,$user_id){
		$this->db->where('user_id',$user_id);

		if($this->db->update('player_wallet',$data)){
			return true;
		}else{
			return false;
		}
	}
}