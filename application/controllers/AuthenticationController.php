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

	//Controll Login
	public function login($page)
	{
		///Attempt to login
		$this->facebook_model->login();

		//Grab Facebook data
		$this->facebookData = $this->session->userdata('facebook_data');

		//Setup Data array for view
		$data = array('fb_data' => $this->facebookData);
		//var_dump($data);
		if(strlen($data['fb_data']['loginUrl']) > 0)
		{
			redirect($data['fb_data']['loginUrl']);
		}
		else
		{
			echo "Unable to load Login Page.";
		}
	}

	public function logout()
	{
		$this->facebook_model->logout();
		//facebook_model::logout();
		/*$this->session->sess_destroy();
		$this->session->userdata = array();
		$this->load->helper('cookie');
		delete_cookie('ci_session');
		$this->clear_cache();
		//redirect('/news');
		$params = array( 'next' => 'http://kaiyansimmons.com/index.php/news' );
		$data['fb_data']['logoutUrl'] = $this->facebook->getLogoutUrl($params);
		if (isset($_SESSION))
		{
			unset($_SESSION);
		}
		unset($this->session);

		//Setup Data array for view
		if(strlen($data['fb_data']['logoutUrl']) > 0)
		{
			//redirect($data['fb_data']['logoutUrl']);
		}
		else
		{
			echo "Unable to load Logout Page.";
		}*/

		//var_dump($this->session);
		$this->load->view('images', $data);
	}

	/*public function clear_cache()
	{
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
	}*/
}
?>
