<?php

if (!defined('BASEPATH'))
{
	exit('No direct script access allowed');
}

class NewsController extends CI_Controller
{
	/*
	 * VARIABLES
	 */
	public $facebookData;

	public function __construct()
	{
		parent::__construct();

		//Load jquery
		//$this->load->library('javascript');
		//Load Facebook Model
		$this->load->model('facebook_model');
	}

	//Load default view
	public function index()
	{
		///Attempt to login
		$this->facebook_model->login();

		//Grab Facebook data
		$this->facebookData =  $this->session->userdata('facebook_data');

		//Setup Data array for view
		$data = array('fb_data' => $this->facebookData);

		//Load view
		$this->load->view('index', $data);
	}

	//Controll Login
	/*public function login()
	{
		//Attempt to login
		$this->facebook_model->login();

		//Grab Session var data
		//$fb_data = $this->session->userdata('facebook_data'); // This array contains all the user FB information

		var_dump($this->facebookData);

		if ((!$this->facebookData['userID']) || (!$this->facebookData['userProfile']))
		{
		  // If this is a protected section that needs user authentication
		  // you can redirect the user somewhere else
		  // or take any other action you need
		  //redirect('login');
		  //$this->facebookModel->facebookLogout();
		  //$data['loginUrl'] = $this->facebook->getLoginUrl();
		  //print_r($data);
			$data = array(
					'fb_data' => $this->facebookData
				);
			var_dump($data);
			$this->load->view('index', $data);
		}
		else
		{
			$data = array(
					'fb_data' => $this->facebookData,
				);

			var_dump($data);
			$this->load->view('index', $data);
		}
	}

	public function logout()
	{
		//$this->facebookModel->facebookLogout();
		/*$this->session->sess_destroy();
		$this->session->userdata = array();
		$this->load->helper('cookie');
		delete_cookie('ci_session');
		$this->clear_cache();
		//redirect('/news');
		$data['fb_data']['loginUrl'] = $this->facebook->getLoginUrl();
		if (isset($_SESSION))
		{
			unset($_SESSION);
		}*/
		/*unset($this->session);
		var_dump($this->session);
		$this->load->view('index', $data);
	}*/

	/*public function clear_cache()
	{
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
	}*/

}

?>
