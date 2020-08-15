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
	private $load;

	public function read($data){
		$mobile =  $data['MobileNumber'];
		$result = $this->db->select('*')->from('users', ['MobileNumber'=>$mobile])->get()->result_array();
		$value = reset($result);
		$data = array('FirstName' => $value['FirstName'],
			'LastName' => $value['LastName'],
			'MobileNumber' => $value['MobileNumber'],
			'EmailId' => $value['EmailId'],
			'Address' =>$value['Address'],
			'City' => $value['City'],
			'State' => $value['State'],
			'Pincode' => $value['Pincode'],
			'isPremium'=> $value['isPremium']
		);
		return $data;
	}

	public function checkUser($data, $login_model){
		$mobile =  $data['MobileNumber'];
		$password = $data['PASSWORD'];
		$value = $this->db->select('*')->from('users')->where( ['MobileNumber'=>$mobile])->get()->result_array();
		$tableData = reset($value);
		$savedpassword = $tableData["PASSWORD"];
		if ($password == $savedpassword) {
			$loginKey = $login_model->executeLogin($tableData);
			return array('loginKey' => $loginKey, 'message' => "Your are successfully loggedin");
			}
		else {
			return "Wrong password or mobilenumber";
		}
	}

	private function  checkAlreadyExistenceOfUser($mobile){
		$value = $this->db->select('*')->from('users')->where (['MobileNumber'=>$mobile] )->get()->result_array();
		if ($value){
			return true;
		}
		return false;
	}

	public function insert($data){
		if ($this->checkAlreadyExistenceOfUser($data['MobileNumber']) == true){
			return "This Mobile Number already registered.";
		}
		$this->FirstName    = $data['FirstName'];
		$this->LastName = $data['LastName'];
		$this->MobileNumber  = $data['MobileNumber'];
		$this->EmailId    = $data['EmailId'];
		$this->PASSWORD = $data['PASSWORD'];
		$this->Address  = $data['Address'];
		$this->City    = $data['City'];
		$this->State = $data['State'];
		$this->Pincode  = $data['Pincode'];
		$this->isPremium = $data['isPremium'];
		$this->CreatedDate    = date("Y-m-d H:i:s");
		$this->ModifiedDate = date("Y-m-d H:i:s");

		if($this->db->insert('users',$this))
		{
			return 'User is added successfully';
		}
		else
		{
			return "Error has occurred";
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
		$this->ModifiedDate    = date("Y-m-d H:i:s");
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
		$result= $this->db->delete('users', ['ID'=>$id]);
		//$result = $this->db->query("delete from `users` where ID = $id");
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
