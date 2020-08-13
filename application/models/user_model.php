<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class User_model extends CI_Model
{
	/**
	 * @var mixed
	 */
	public $FirstName;
	public $LastName;
	public $MobileNumber;
    public $EmailId;
    public $PASSWORD;
    public $Address;
    public $City;
    public $State;
    public $Pincode;
    public $isPremium;
    public $CreatedDate;
    public $ModifiedDate;
	private $db;

	public function read(){
		$query = $this->db->query("select * from `users`");
		$userVal = $query->result_array();
		//$userVal.PASSWORD = '';
		return userVal;
	}

	public function insert($data){
		$this->FirstName    = $data['FirstName'];
		$this->LastName = $data['LastName'];
		$this->MobileNumber  = $data['MobileNumber'];
		$this->EmailId    = $data['EmailId'];
		$this->PASSWORD = $data['PASSWORD'];
		$this->Address  = $data['Address'];
		$this->City    = $data['City'];
		$this->State = $data['State'];
		$this->Pincode  = $data['Pincode'];
		$this->CreatedDate    = date("Y-m-d H:i:s");
		$this->ModifiedDate = date("Y-m-d H:i:s");

		if($this->db->insert('users',$this))
		{
			return 'User is added successfully';
		}
		else
		{
			return "Error has occured";
		}
	}

	public function update($id,$data){
		$this->FirstName    = $data['FirstName'];
		$this->LastName = $data['LastName'];
		$this->EmailId    = $data['EmailId'];
		$this->PASSWORD = $data['PASSWORD'];
		$this->Address  = $data['Address'];
		$this->City    = $data['City'];
		$this->State = $data['State'];
		$this->Pincode  = $data['Pincode'];
		$this->CreatedDate    = date("Y-m-d H:i:s");
		$this->isPremium = $data['isPremium'];

		$result = $this->db->update('users',$this,array('ID' => $id));

		if($result)
		{
			return "User Profile is updated successfully";
		}
		else
		{
			return "Error has occurred";
		}
	}

	public function delete($id){
		$result = $this->db->query("delete from `users` where ID = $id");
		if($result)
		{
			return "User Profile is deleted successfully";
		}
		else
		{
			return "Error has occurred";
		}
	}



}
