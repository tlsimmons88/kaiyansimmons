<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AdminController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	//Load default view
	public function index()
	{
		//Setup Data array for view
		$data = array('fb_data' => $this->facebookData);
		$data['page'] = "admin";
		$data['isAdmin'] = false;

		//Only allow me or Tea to see the admin page
		if($this->facebookData['userID'] == "560146889" || $this->facebookData['userID'] == "100001083368384")
		{
			$data['isAdmin'] = true;
		}

		//Load view
		$this->load->view('admin', $data);
	}
}
?>
