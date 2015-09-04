<?php

if (!defined('BASEPATH'))
{
	exit('No direct script access allowed');
}

class AuthenticationController extends CI_Controller
{
	/*
	 * VARIABLES
	 */
	public $facebookData;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('facebook_model');
	}

	//Load default view
	public function index()
	{
	}

	//Function to log user out of app and facebook.com
	public function logout()
	{
		$this->facebook_model->logout();
	}
}
?>
