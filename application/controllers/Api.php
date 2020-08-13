<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');
class Api extends REST_Controller
{

	public $user_model;
	protected $input;

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
		$id = $this->uri->segment(9);
		$data = array('FirstName' => $this->input->get('FirstName'),
			'LastName' => $this->input->get('LastName'),
			'MobileNumber' => $this->input->get('MobileNumber'),
			'EmailId' => $this->input->get('EmailId'),
			'PASSWORD' => $this->input->get('PASSWORD'),
			'Address' => $this->input->get('Address'),
		    'City' => $this->input->get('City'),
			'State' => $this->input->get('State'),
			'Pincode' => $this->input->get('Pincode')
		);

		$r = $this->user_model->update($id, $data);
		$this->response($r);
	}

	public function user_post()
	{
		$data = array('FirstName' => $this->input->get('FirstName'),
			'LastName' => $this->input->get('LastName'),
			'MobileNumber' => $this->input->get('MobileNumber'),
			'EmailId' => $this->input->get('EmailId'),
			'PASSWORD' => $this->input->get('PASSWORD'),
			'Address' => $this->input->get('Address'),
			'City' => $this->input->get('City'),
			'State' => $this->input->get('State'),
			'Pincode' => $this->input->get('Pincode')
		);
		$r = $this->user_model->insert($data);
		$this->response($r);
	}

	public function user_delete()
	{
		$id = $this->uri->segment(3);
		$r = $this->user_model->delete($id);
		$this->response($r);
	}
}
