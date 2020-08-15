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
		$this->response("You are logged out");
	}

	public function user_get()
	{
		$MobileNumber = $this->get('MobileNumber');
		$accessToken = $this->head('Authorization');

		if (is_null($MobileNumber) || is_null($accessToken)){
			$this->response("Parameters are missing in request");
		}
		else{
			$mobile = $this->login_model->returnMobile($accessToken);
			if($mobile == $MobileNumber){
				$r = $this->user_model->read($MobileNumber);
				$this->response($r);
			}else{
				$this->response("You don't have any active login");
			}
		}
	}

	public function user_put()
	{
		$id=$this->put('id');
		$data = array('FirstName' => $this->put('FirstName'),
			'LastName' => $this->put('LastName'),
			'MobileNumber' => $this->put('MobileNumber'),
			'EmailId' => $this->put('EmailId'),
			'PASSWORD' => $this->put('PASSWORD'),
			'Address' => $this->put('Address'),
		    'City' => $this->put('City'),
			'State' => $this->put('State'),
			'Pincode' => $this->put('Pincode'),
			'isPremium'=> $this->post('isPremium')
		);

		$r = $this->user_model->update($id, $data);
		$this->response($r);
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
			'isPremium'=> $this->post('isPremium')
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
		$this->response("Your Society is logged out");
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
			$this->response("Your society doesn't have any active login");
		}

	}

	public function society_post()
	{
		$data = array('SocietyName' => $this->post('SocietyName'),
			'MobileNumber' => $this->post('MobileNumber'),
			'EmailId' => $this->post('EmailId'),
			'PASSWORD' => $this->post('PASSWORD'),
			'Address' => $this->post('Address'),
			'City' => $this->post('City'),
			'State' => $this->post('State'),
			'Pincode' => $this->post('Pincode'),
		);
		$r = $this->society_model->insert($data);
		$this->response($r);
	}

	public function society_delete()
	{
		$id = $this->delete('id');
		$r = $this->society_model->delete($id);
		$this->response($r);
	}
}
