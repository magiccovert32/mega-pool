<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminconfig_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct(); 
    }
	
	
	/**
	 *
	 * Function used to update admin info
	 *
	 * @param $data, $admin_id
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function update($data,$admin_id){
		$this->db->where('admin_id',$admin_id);

		if($this->db->update('admin_config',$data)){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to check admin login
	 *
	 * @param $email, $password
	 *
	 * @return result
	 *
	 */
	public function getAuth($email,$password){
		$query = $this->db->select("*")->from("admin_config")->where('login_email',$email)->where('login_password',$password)->get();
        
		if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	/**
	 *
	 * Function used to get profile details
	 *
	 * @param $id
	 *
	 * @return array
	 *
	 */
	public function getProfileDetailsByAdminId($id){
		$query = $this->db->select("*")->from("admin_config")->where('admin_id',$id)->get();
        
		if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	
	
	/**
	 *
	 * Function used to update admin info
	 *
	 * @param $data, $admin_id
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function updateProfileInformation($data,$admin_id){
		#check email exists in other profile
		$query = $this->db->select("*")->from("admin_config")->where('admin_id != '.$admin_id)->where('login_email',$data['login_email'])->get();
        
		if($query->num_rows() > 0){
			return 2;
		}else{
			
			$this->db->where('admin_id',$admin_id);

			if($this->db->update('admin_config',$data)){
				return 1;
			}else{
				return 0;
			}
		}
	}
	
	
	
	/**
	 *
	 * Function used to check old password
	 *
	 * @param $password, $admin_id
	 *
	 * @return boolen
	 * 
	 *
	 */
	public function checkPassword($password,$admin_id){
		#check email exists in other profile
		$query = $this->db->select("*")->from("admin_config")->where('admin_id',$admin_id)->where('login_password',$password)->get();

		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
}