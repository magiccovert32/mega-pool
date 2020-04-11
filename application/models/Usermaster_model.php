<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usermaster_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct(); 
	}
	

	/**
	 *
	 * Function used to check login
	 *
	 * @param $email, $password
	 *
	 * @return result
	 *
	 */
	public function getAuth($email,$password,$user_type_id){
		$query = $this->db->select("user_id,user_type_id,user_email,full_name,profile_image,current_status")
							->from("user_master")
							->where('user_email',$email)
							->where('user_password',$password)
							->where('user_type_id',$user_type_id)
							->get();

		if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to add user info
	 *
	 * @param $data
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function save($data){
		if($this->db->insert('user_master', $data)){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to update user info
	 *
	 * @param $data, $user_id
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function update($data,$user_id){
		$this->db->where('user_id',$user_id);

		if($this->db->update('user_master',$data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	
	public function updatePasswordByResetLink($data,$link){
		$query = $this->db->select("user_id")->from("user_master")->where('reset_link',$link)->where('current_status != 3')->get();

		if($query->num_rows() > 0){
			$this->db->where('reset_link',$link);

			if($this->db->update('user_master',$data)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to check user email already exists
	 *
	 * @param $email
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function checkEmailExists($email){				
		$query = $this->db->select("user_id")
                        ->from("user_master")
						->where("user_email", $email)
						->get();
 
        if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	public function checkEmailExistsByType($email,$user_type_id){				
		$query = $this->db->select("user_id")
                        ->from("user_master")
						->where("user_email", $email)
						->where("user_type_id", $user_type_id)
						->get();
 
        if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	public function checkEmailRecordExists($email){				
		$query = $this->db->select("user_id")
                        ->from("user_master")
						->where("user_email", $email)
						->get();
 
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to check user email already exists
	 *
	 * @param $email,$id
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function checkEmailExistsWithOutUserId($email,$id){				
		$query = $this->db->select("user_id")
                        ->from("user_master")
						->where("user_email", $email)
						->where("user_id !=".$id)
						->get();
 
        if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	
	/**
	 *
	 * Function used to get all user list
	 *
	 * @param $page,$perpage
	 *
	 * @return array
	 * 
	 *
	 */
	public function getAllUserForAdmin($type,$page=0,$perpage){		
		$page = $page-1;
		
		if ($page<0) { 
			$page = 0;
		}
		
		$from = $page*$perpage;
		$this->db->limit($perpage, $from);
		
		$query = $this->db->select("UM.*")
                        ->from("user_master UM")
						->where("UM.user_type_id",$type)
						->order_by('registration_date DESC')
						->get();
                        
        if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to get all user list count
	 *
	 * @return int
	 * 
	 *
	 */
	public function getTotalUserCountForAdmin($type){				
		$query = $this->db->select("COUNT(UM.user_id) as count")
                        ->from("user_master UM")
						->where("UM.user_type_id",$type)
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
	 * Function used to get details of user
	 *
	 * $id
	 *
	 * @return array
	 * 
	 *
	 */
	public function getUserDetailsByUserIdByAdmin($id){				
		$query = $this->db->select("*")
                        ->from("user_master")
						->where("user_id", $id)
						->get();
 
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	
	/**
	 *
	 * Function used to count all commissioner
	 *
	 */
	public function getAllCommissionerCount(){
		$query = $this->db->select("COUNT(UM.user_id) as count")
                        ->from("user_master UM")
						->where("UM.user_type_id",'1')
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
	 * Function used to count all player
	 *
	 */
	public function getAllPlayerCount(){
		$query = $this->db->select("COUNT(UM.user_id) as count")
                        ->from("user_master UM")
						->where("UM.user_type_id",'2')
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
	 * Function used to verify and update account status
	 *
	 */
	public function verifyEmailAccress($link){				
		$query = $this->db->select("user_id,current_status")
                        ->from("user_master")
						->where("email_verification_link", $link)
						->get();
 
        if($query->num_rows() > 0){
			$user_details = $query->row();

			if($user_details->current_status == '3'){
				return 3;
			}else{
				$update_data = array(
					'email_verification_link' 	=> null,
					'is_email_verified'			=> '1',
					'current_status'			=> '1'
				);

				$this->db->where('user_id',$user_details->user_id);

				if($this->db->update('user_master',$update_data)){
					return 1;
				}else{
					return 2;
				}
			}
		}else{
			return 4;
		}
	}


	public function getUserDetailsByUserId($id){				
		$query = $this->db->select("*")
                        ->from("user_master")
						->where("user_id", $id)
						->get();
 
        if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}



	/**
	 * 
	 * Function used to check current password 
	 * 
	 * @param $password, $user_id
	 * 
	 */
	public function checkOldPassword($password,$user_id){
		$query = $this->db->select("user_id")->from("user_master")->where('user_id',$user_id)->where('user_password',$password)->get();

		if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
}