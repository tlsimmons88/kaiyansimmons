<?php

class facebook_model extends CI_Model
{
	/*
	 * PUBLIC VARIABLES
	 */
	public $facebook_data;

    public function __construct()
    {
        parent::__construct();

		// 'redirect_uri' => 'http://kaiyansimmons.com/index.php/news', // URL where you want to redirect your users after a successful login
		//Init Class vars
		$this->facebook_data = array(
                        'userProfile' => '',
                        'userID' => '',
                        'loginUrl' => $this->facebook->getLoginUrl(
                            array(
                                'scope' => 'email,user_birthday,publish_stream', // app permissions
								'display' => 'page'
                            )
                        ),
                        'logoutUrl' => $this->facebook->getLogoutUrl(),
                    );
	}

	//Get User ID
	public function getUserID()
	{
        //Grab User Profile
		$this->facebook_data['userID'] = $this->facebook->getUser();
	}

	//Get user profile
	public function getUserProfile()
	{
        // We may or may not have this data based on whether the user is logged in.
        //
        // If we have a $user id here, it means we know the user is logged into
        // Facebook, but we don't know if the access token is valid. An access
        // token is invalid if the usker logged out of Facebook.
        if($this->facebook_data['userID'] != "")
        {
            try
			{
                // Proceed knowing you have a logged in user who's authenticated.
				//Example of how to grab various data: /me?fields=id,name,link,email
                $this->facebook_data['userProfile'] = $this->facebook->api('/me');
            }
			catch (FacebookApiException $ex)
			{
                error_log($ex);
                $this->facebook_data['userID'] = "";
            }
        }
    }

	//Log into facebook and set session var
	public function login()
	{
		//Get User ID to setup Facebook Data array
		$this->getUserID();

		//Get User Profile to setup Facebook Data array
		$this->getUserProfile();

		//Create Session
		$this->session->set_userdata('facebook_data', $this->facebook_data);
		
		return $this->facebook_data;
	}

	//Log out of facebook and destory session var
	public function logout()
	{
		$this->facebook->destroySession();
		$this->session->sess_destroy();
		$this->session->userdata = array();
	}
}
?>
