<?php

class MY_Controller extends CI_Controller
{
	/*
	 * VARIABLES
	 */
	public $facebookData;

	public function __construct()
	{
		parent::__construct();

		//We do this for the sake of facebook API.
		parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );

		$this->load->model('facebook_model');

		//See if we can get a userID
		$this->facebookData = $this->facebook_model->getUserID();

		//IF we can then load the data for the view
		if($this->facebookData['userID'] != 0)
		{
			$this->facebookData = $this->facebook_model->getUserProfile();
		}
		else	//we are not logged in
		{
			//Grab the data needed to allow the user to login from the view
			$this->facebookData = $this->facebook_model->login();
		}

		//See if they are a friend
		$this->facebookData['isFriend'] = $this->facebook_model->isFriend($this->facebookData['userID']);
	}
}