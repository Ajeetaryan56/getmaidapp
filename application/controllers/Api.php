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
	}

	public function user_get()
	{
		$r = $this->user_model->read();
		$this->response($r);
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
}
