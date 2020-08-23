<?php


class login_model extends CI_Model
{
	public $MobileNumber;
	public $loginkey;
	public $ipaddresses;
	public $created;

	public function executeLogin($data) {
		$this->MobileNumber = $data['MobileNumber'];
		$this->executeLogout($this->MobileNumber);
		$this->loginkey = $this->createLoginKey();
		$this->ipaddresses = $this->get_client_ip();
		$this->created = date("Y-m-d H:i:s");

		if($this->db->insert('loginkeys',$this))
		{
			return $this->loginkey;
		}
		else
		{
			return "Error has occurred";
		}
	}

	public function isLoginKeyValid($loginKey){
		$result = $this->db->select('*')->from('loginkeys')->where(['loginkey'=>$loginKey])->get()->result_array();
		return count($result) > 0;
	}

	public function returnMobile($loginKey){
		$result = $this->db->select('*')->from('loginkeys')->where(['loginkey'=>$loginKey])->get()->result_array();
		$value = reset($result);
		return $value['MobileNumber'];
	}

	public function logout($data){
		$this->MobileNumber = $data;
		$this->executeLogout($this->MobileNumber);
	}

	function executeLogout($MobileNumber){
		$result= $this->db->delete('loginkeys', ['MobileNumber'=>$MobileNumber]);
	}

	public function createLoginKey() {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';

	for ($i = 0; $i < 50; $i++) {
		$index = rand(0, strlen($characters) - 1);
		$randomString .= $characters[$index];
	}
	return $randomString;
	}

	public function get_client_ip() {
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
}
