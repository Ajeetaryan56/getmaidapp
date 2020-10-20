<?php
require(APPPATH.'/libraries/RestController.php');
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends RestController
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('login_model');
		$this->load->model('society_login_model');
		$this->load->model('society_model');
		$this->load->model('maid_model');
		$this->load->model('pincode_model');
        $this->load->model('Saree_model');
        $this->load->model('contactus_model');
	}

    public function saree_post(){
           $data = array('SareeName' => $this->post('SareeName'),
			'BrandName' => $this->post('BrandName'),
			'FabricName' => $this->post('FabricName'),
			'PriceRange' => $this->post('PriceRange'),
			'Length' => $this->post('Length'),
			'Stock' => $this->post('Stock'),
			'Colors' => $this->post('Colors'),
		);
		$r = $this->Saree_model->insertSaree($data);
		$this->response($r);
    }

    public function contactus_post(){
           $data = array('FullName' => $this->post('FullName'),
			'Email' => $this->post('Email'),
			'Phone' => $this->post('Phone'),
			'InterestedIn' => $this->post('InterestedIn'),
			'Company' => $this->post('Company'),
			'Description' => $this->post('Description'),
		);
		$r = $this->contactus_model->insert($data);
		$this->response($r);
    }

	public function login_post(){
		$data = array(
			'MobileNumber' => $this->post('MobileNumber'),
			'PASSWORD' => $this->post('PASSWORD'),
		);
		$r = $this->user_model->checkUser($data, $this->login_model);
		$this->response($r);
	}

	public function logout_get(){
		$MobileNumber = $this->get('MobileNumber');
		$this->login_model->logout($MobileNumber);
		$result = array('message'=> "You are logged out", 'status_code'=> 200);
		$this->response($result);
	}

	public function user_get()
	{
		$accessToken = $this->head('Authorization');
		if (is_null($accessToken)){
			$result = array('message'=> "Please login again to see profile data", 'error_code'=> 422);
			$this->response($result);
		}
		else{
			$mobile = $this->login_model->returnMobile($accessToken);
			$r = $this->user_model->read($mobile);
			//$r = $mobile;
			$result = array('profile'=> $r, 'status_code'=> 200);
			$this->response($result);
		}
	}

	public function user_post()
	{
		$data = array('FirstName' => $this->post('FirstName'),
			'LastName' => $this->post('LastName'),
			'MobileNumber' => $this->post('MobileNumber'),
			'EmailId' => $this->post('EmailId'),
			'PASSWORD' => $this->post('PASSWORD'),
			'Address' => $this->post('Address'),
			'City' => $this->post('City'),
			'State' => $this->post('State'),
			'Pincode' => $this->post('Pincode'),
			'isPremium'=> $this->post('isPremium'),
			'SocietyId'=> $this->post('SocietyId')
		);
		$r = $this->user_model->insert($data);
		$this->response($r);
	}

	public function user_delete()
	{
		$id = $this->delete('id');
		$r = $this->user_model->delete($id);
		$this->response($r);
	}

	public function societylogin_post(){
		$data = array(
			'EmailId' => $this->post('EmailId'),
			'PASSWORD' => $this->post('PASSWORD'),
		);
		$r = $this->society_model->checkSociety($data, $this->society_login_model);
		$this->response($r);
	}

	public function societylogout_get(){
		$EmailId = $this->get('EmailId');
		$this->society_login_model->logout($EmailId);
		$result = array('message'=> "Your Society is logged out", 'status_code'=> 200);
		$this->response($result);
	}

	public function society_get()
	{
		$EmailId = $this->get('EmailId');
		$accessToken = $this->head('Authorization');
		$email = $this->society_login_model->returnEmail($accessToken);

		if($email == $EmailId){
			$r = $this->society_model->read($email);
			$this->response($r);
		}else{
			$result = array('message'=> "Your society doesn't have any active login", 'error_code'=> 401);
			$this->response($result);
		}

	}

	public function society_post()
	{
		if ($this->society_model->checkAlreadyExistenceOfSociety($this->post('EmailId')) == true){
			$result = array('message'=> "This EmailId is already registered", 'error_code'=> 400);
		}else{
			$data = array('SocietyName' => $this->post('SocietyName'),
				'MobileNumber' => $this->post('MobileNumber'),
				'EmailId' => $this->post('EmailId'),
				'PASSWORD' => $this->post('PASSWORD'),
				'Address' => $this->post('Address'),
				'City' => $this->post('City'),
				'State' => $this->post('State'),
				'Pincode' => $this->post('Pincode'),
			);
			$result = $this->society_model->insert($data);
		}
		$this->response($result);
	}

	public function societies_get(){
		$City =  $this->get('City');
		$societies = $this->society_model->read('City', $City);
		$result = array('societies'=> $societies, 'status_code'=> 200);
		$this->response($result);
	}

	public function society_delete()
	{
		$id = $this->delete('id');
		$result = $this->society_model->delete($id);
		$this->response($result);
	}

	public function maids_get(){
		$accessToken = $this->head('Authorization');
		$societyId = $this->get('SocietyId');
		if ($this->login_model->isLoginKeyValid($accessToken) == true || $this->society_login_model->isLoginKeyValid($accessToken) == true){
			$result = $this->maid_model->read('SocietyId', $societyId);
			$result = array('maids'=> $result, 'status_code'=> 200);
		}else{
			$result = array('message'=> "You don't have any active login", 'error_code'=> 401);
		}
		$this->response($result);
	}

	public function maids_post(){
		$accessToken = $this->head('Authorization');
		if (is_null($accessToken)){
			$result = array('message'=> "Parameters are missing in request", 'error_code'=> 400);
			$this->response($result);
		}
		else {
			if ($this->society_login_model->isLoginKeyValid($accessToken)) {
				$data = array('FirstName' => $this->post('FirstName'),
					'LastName' => $this->post('LastName'),
					'ProfilePic' => $this->post('ProfilePic'),
					'PoliceVerification' => $this->post('PoliceVerification'),
					'MobileNumber' => $this->post('MobileNumber'),
					'FlatNumbers' => $this->post('FlatNumbers'),
					'PASSWORD' => $this->post('PASSWORD'),
					'Address' => $this->post('Address'),
					'City' => $this->post('City'),
					'State' => $this->post('State'),
					'Pincode' => $this->post('Pincode'),
					'SocietyId'=> $this->post('SocietyId')
				);
				$result = $this->maid_model->insert($data);
				$this->response($result);
			} else {
				$result = array('message'=> "Your Society doesn't have any active login", 'error_code'=> 401);
				$this->response($result);
			}
		}
	}

	public function pin_get(){
		$pincode = $this->get('pincode');
		$this->response($this->pincode_model->getPincodeDetails($pincode));
	}
}
