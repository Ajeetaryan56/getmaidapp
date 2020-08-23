<?php


class society_model extends CI_Model
{
	public $SocietyName;
	public $EmailId;
	public $PASSWORD;
	public $Address;
	public $City;
	public $State;
	public $Pincode;
	public $Modified;
	public $Created;

	function __construct(){
		parent::__construct();
		$this->load->model('EmailModel');
	}

	public function read($key, $data){
		$result = $this->db->select('*')->from('societies')->where([$key =>$data])->get()->result_array();
		$response = array();
		foreach ($result as $value){
			$data = array('SocietyName' => $value['SocietyName'],
				'EmailId' => $value['EmailId'],
				'MobileNumber' => $value['MobileNumber'],
				'Address' =>$value['Address'],
				'City' => $value['City'],
				'State' => $value['State'],
				'Pincode' => $value['Pincode'],
				'SocietyId' => $value['ID']
			);
			array_push($response, $data);
		}
		//return $this->EmailModel->sendVerificationEmail('ajeetpatel12jul@gmail.com', 'Sample Email');
		return $response;
	}

	public function  checkAlreadyExistenceOfSociety($Email){
		$value = $this->db->select('*')->from('societies')->where (['EmailID'=>$Email] )->get()->result_array();
		if ($value && count($value) > 0){
			return true;
		}
		return false;
	}

	public function checkSociety($data, $society_model){
		$email =  $data['EmailId'];
		$password = $data['PASSWORD'];
		$value = $this->db->select('*')->from('societies')->where(['EmailId'=>$email])->get()->result_array();
		$tableData = reset($value);
		$savedpassword = $tableData["PASSWORD"];
		if ($password == $savedpassword) {
			$loginKey = $this->society_login_model->executeLogin($tableData);
			return array('loginKey' => $loginKey, 'message' => "Your are successfully loggedin");
		}
		else {
			return "Wrong password or mobilenumber";
		}
	}

	public function insert($data){
		$this->SocietyName    = $data['SocietyName'];
		$this->MobileNumber  = $data['MobileNumber'];
		$this->EmailId    = $data['EmailId'];
		$this->PASSWORD = $data['PASSWORD'];
		$this->Address  = $data['Address'];
		$this->City    = $data['City'];
		$this->State = $data['State'];
		$this->Pincode  = $data['Pincode'];
		$this->Created    = date("Y-m-d H:i:s");
		$this->Modified = date("Y-m-d H:i:s");

		if($this->db->insert('societies',$this))
		{
			return 'Society is added successfully';
		}
		else
		{
			return "Error has occurred";
		}
	}

	public function update($id,$data){
		$this->SocietyName    = $data['SocietyName'];
		$this->LastName = $data['LastName'];
		$this->EmailId    = $data['EmailId'];
		$this->PASSWORD = $data['PASSWORD'];
		$this->Address  = $data['Address'];
		$this->City    = $data['City'];
		$this->State = $data['State'];
		$this->Pincode  = $data['Pincode'];
		$this->Modified    = date("Y-m-d H:i:s");

		$result = $this->db->update('societies',$this,array('ID' => $id));

		if($result)
		{
			return "Society is updated successfully";
		}
		else
		{
			return "Error has occurred";
		}
	}

	public function delete($id){
		$result= $this->db->delete('societies', ['ID'=>$id]);
		if($result)
		{
			return "Society is deleted successfully";
		}
		else
		{
			return "Error has occurred";
		}
	}
}
