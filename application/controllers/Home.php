<?php

class Home extends CI_Controller{

	function index(){
		//echo 'Home Page';
		$this->load->helper('url');
		$this->load->view("<?php echo base_url(); ?>index.html");
		//redirect('index.html');
	}
}
