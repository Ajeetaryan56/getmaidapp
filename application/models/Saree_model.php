<?php


class Saree_model extends CI_Model
{
	public $sareeName;
	public $brandName;
	public $fabricName;
	public $priceRange;
	public $length;
	public $stock;
	public $colors;
	public $created;
	public $modified;

	public function insertSaree($data){
		if ($this->checkAlreadyExistenceOfSaree($data['SareeName']) == true){
			return array('message' => "This Mobile Number already registered.", 'error_code' => 400);
		}
		$this->sareeName    = $data['SareeName'];
		$this->brandName = $data['BrandName'];
		$this->fabricName  = $data['FabricName'];
		$this->priceRange = $data['PriceRange'];
		$this->length = $data['Length'];
		$this->stock  = $data['Stock'];
		$this->colors    = $data['Colors'];
		$this->created    = date("Y-m-d H:i:s");
		$this->modified = date("Y-m-d H:i:s");

		if($this->db->insert('sarees',$this)) {
			return array('message' => 'Congrats, you saree details added successfully', 'status_code' => 200);
		}
		else {
			return array('message' => 'Sorry, we are not able to process your request.', 'error_code' => 422);
		}
	}

    private function  checkAlreadyExistenceOfSaree($sareeName){
		$value = $this->db->select('*')->from('sarees')->where (['sareeName'=>$sareeName] )->get()->result_array();
		if ($value && count($value) > 0){
			return true;
		}
		return false;
	}
}
