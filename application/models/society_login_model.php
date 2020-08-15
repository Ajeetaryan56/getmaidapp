<?php


class society_login_model extends CI_Model
{
	public $EmailId;
	public $loginkey;
	public $ipaddresses;
	public $created;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('login_model');
	}

	public function executeLogin($data) {
		$this->EmailId = $data['EmailId'];
		$this->executeLogout($this->EmailId);
		$this->loginkey = $this->login_model->createLoginKey();
		$this->ipaddresses = $this->login_model->get_client_ip();
		$this->created = date("Y-m-d H:i:s");

		if($this->db->insert('societyloginkeys',$this))
		{
			return $this->loginkey;
		}
		else
		{
			return "Error has occurred";
		}
	}

	public function returnEmail($loginKey){
		$result = $this->db->select('*')->from('societyloginkeys', ['loginkey'=>$loginKey])->get()->result_array();
		$value = reset($result);
		return $value['EmailId'];
	}

	public function logout($data){
		$this->EmailId = $data;
		$this->executeLogout($this->EmailId);
	}

	function executeLogout($EmailId){
		$result= $this->db->delete('societyloginkeys')->where( ['EmailId'=>$EmailId]);
	}
}
