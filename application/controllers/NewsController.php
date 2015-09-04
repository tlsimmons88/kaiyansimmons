<?php

if (!defined('BASEPATH'))
{
	exit('No direct script access allowed');
}

class NewsController extends MY_Controller
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
		$data['page'] = "news";

		//Load view
		$this->load->view('index', $data);
	}
}

?>
