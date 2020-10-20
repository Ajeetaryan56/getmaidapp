<?php


class contactus_model extends CI_Model
{
	public $fullName;
	public $email;
	public $phone;
	public $company;
	public $interestedIn;
	public $description;

	public function insert($data){
		$this->fullName    = $data['FullName'];
		$this->email = $data['Email'];
		$this->phone  = $data['Phone'];
		$this->company = $data['Company'];
		$this->interestedIn = $data['InterestedIn'];
		$this->description  = $data['Description'];

		if($this->db->insert('contactus',$this)) {
			return array('message' => 'Congrats, your details added successfully', 'status_code' => 200);
		}
		else {
			return array('message' => 'Sorry, we are not able to process your request.', 'error_code' => 422);
		}
	}
}
