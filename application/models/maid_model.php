<?php


class maid_model extends CI_Model
{
	public string $FirstName;
	public $LastName;
	public string $ProfilePic;
	public $PoliceVerification;
	public $Address;
	public $City;
	public $State;
	public $Pincode;
	public $FlatNumbers;
	public $MobileNumber;
	public $Rating;
	public $Modified;
	public $Created;
	public $SocietyId;

	public function read($key, $data){
		$result = $this->db->select('*')->from('maids')->where ([$key=>$data] )->get()->result_array();
		$response = array();
		foreach ($result as $value){
			$data = array('FirstName' => $value['FirstName'],
				'LastName' => $value['LastName'],
				'MobileNumber' => $value['MobileNumber'],
				'ProfilePic' => $value['ProfilePic'],
				'PoliceVerification' => $value['PoliceVerification'],
				'Address' =>$value['Address'],
				'City' => $value['City'],
				'State' => $value['State'],
				'Pincode' => $value['Pincode'],
				'FlatNumbers' => $value['FlatNumbers'],
				'Rating' => $value['Rating'],
				'MaidId' => (int)$value['ID'] ,
				'created' => $value['Created'],
				'modified' => $value['Modified'],
				'SocietyId' => $value['SocietyId']
			);
			array_push($response, $data);
		}
		return $response;
	}

	private function  checkAlreadyExistenceOfUser($mobile){
		$value = $this->db->select('*')->from('maids')->where (['MobileNumber'=>$mobile] )->get()->result_array();
		if ($value && count($value) > 0){
			return true;
		}
		return false;
	}

	public function insert($data){
		  //return ($this->checkAlreadyExistenceOfUser($data['MobileNumber']));
		if ($this->checkAlreadyExistenceOfUser($data['MobileNumber']) == true){
			return "This Mobile Number already registered.";
		}
		$this->FirstName    = $data['FirstName'];
		$this->LastName = $data['LastName'];
		$this->MobileNumber  = $data['MobileNumber'];
		$profileImgName = $data['MobileNumber'].'pic';
		$pvImgName = $data['MobileNumber'].'pv';
		$this->ProfilePic = $this->uploadImage(base64_decode($this->input->post("ProfilePic")), $profileImgName);
		$this->PoliceVerification = $this->uploadImage(base64_decode($this->input->post("PoliceVerification")), $pvImgName);
		$this->Address = $data['Address'];
		$this->City    = $data['City'];
		$this->State = $data['State'];
		$this->Pincode  = $data['Pincode'];
		$this->Created    = date("Y-m-d H:i:s");
		$this->Modified = date("Y-m-d H:i:s");
		$this->	SocietyId = $data["SocietyId"];

		if($this->db->insert('maids',$this))
		{
			return 'Maid is added successfully';
		}
		else
		{
			return "Error has occurred";
		}
	}

	public function update($MobileNumber,$data){
		$this->FirstName    = $data['FirstName'];
		$this->LastName = $data['LastName'];
		$profileImgName = $MobileNumber.'pic';
		$pvImgName = $MobileNumber.'pv';
		$this->ProfilePic = $this->uploadImage(base64_decode($this->input->post("ProfilePic")), $profileImgName);
		$this->PoliceVerification = $this->uploadImage(base64_decode($this->input->post("PoliceVerification")), $pvImgName);
		$this->Address  = $data['Address'];
		$this->City    = $data['City'];
		$this->State = $data['State'];
		$this->Pincode  = $data['Pincode'];
		$this->Modified = date("Y-m-d H:i:s");
		$this->Rating = $data['Rating'];
		$this->FlatNumbers = $data['FlatNumbers'];
		$this->	SocietyId = $data['SocietyId'];

		$result = $this->db->update('maids',$this,array('MobileNumber' => $MobileNumber));

		if($result)
		{
			return "Maid is updated successfully";
		}
		else
		{
			return "Error has occurred";
		}
	}

	public function delete($MobileNumber){
		$value = $this->db->select('*')->from('maids')->where (['MobileNumber'=>$MobileNumber] )->get()->result_array();
		$value = reset($value);
		$this->ProfilePic = $value['ProfilePic'];
		$this->PoliceVerification = $value['PoliceVerification'];
		$this->deleteImage($this->ProfilePic);
		$this->deleteImage($this->PoliceVerification);

		$result= $this->db->delete('maids', ['MobileNumber'=>$MobileNumber]);
		//$result = $this->db->query("delete from `users` where ID = $id");
		if($result)
		{
			return "Maid Profile is deleted successfully";
		}
		else
		{
			return "Error has occurred";
		}
	}

	private function uploadImage($image, $image_name){
		$filename = $image_name.'.'.'png';
		//(making folder just in case(not present))
		$upload_path = './assets/img/upload/';
		if(!is_dir($upload_path)) mkdir($upload_path, 0777, TRUE);
		$path = "./assets/img/upload/".$filename;
		// image is bind and upload to respective folder
		file_put_contents($path, $image);
		//final value to store in database
		$image_upload_full_path = 'assets/img/upload/'.$filename;
		return $image_upload_full_path;
	}

	private function deleteImage($imageurl){
		file_delete_contents($imageurl);
	}
}
