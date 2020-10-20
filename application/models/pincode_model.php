<?php


class pincode_model extends CI_Model
{
	public $pincode;
	public $City;
	public $State;
	public $created;
	public $modified;

	public function getPincodeDetails($pincode){
		$this->pincode = $pincode;
		$value = $this->checkAlreadyExistenceOfPincode($pincode);
		if ($value && count($value) > 0){
			$value = reset($value);
			$this->City = $value['City'];
			$this->State = $value['State'];
			$data = array('City' => $this->City, 'State' => $this->State, 'Pincode' => $this->pincode, 'status_code' => 200);
			return $data;
		}else{
			$apivalue = $this->callApi($pincode);
			 if($apivalue['Status'] == "Success"){
			 	$this->City = reset($apivalue['PostOffice'])['District'];
				 $this->State = reset($apivalue['PostOffice'])['State'];
				 $data = array('City' => $this->City, 'State' => $this->State, 'Pincode' => $this->pincode, 'status_code' => 200);
				 $this->insert($data);
				 return $data;
			 }
		}
	}

	private function insert($data){
		$this->pincode    = $data['Pincode'];
		$this->City = $data['City'];
		$this->State  = $data['State'];
		$this->created    = date("Y-m-d H:i:s");
		$this->modified = date("Y-m-d H:i:s");
		if($this->db->insert('pincodes',$this)) {
			return true;
		}
		else {
			return false;
		}
	}

	private function  checkAlreadyExistenceOfPincode($pincode){
		$value = $this->db->select('*')->from('pincodes')->where (['pincode'=>$pincode] )->get()->result_array();
		return $value;
	}

	private function callApi($pincode){
		$curl = curl_init();
		$baseUrl = 'http://www.postalpincode.in/api/pincode';
		$url = sprintf("%s/%s", $baseUrl, $pincode);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		curl_close($curl);
		return json_decode($result, true);
	}
}
