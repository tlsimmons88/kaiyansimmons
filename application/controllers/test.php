<?php

class Test extends CI_Controller
{
	public function index()
	{
		$this->load->model('facebook_model');
		
		//Loginto that bitch.
		$facebookData =  $this->facebook_model->login();
		
		$this->load->view('test/index.phtml' , array('fb_data' => $facebookData));
	}
}