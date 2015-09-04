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
	}

	//Verify if person is a friend
	public function isFriend($userID)
	{
		$response = $this->facebook->api("/560146889/friends/".$userID."");

		if(count($response['data']) == 0)
		{
			$response = $this->facebook->api("/100001083368384/friends/".$userID."");
			{
				if(count($response['data']) == 0)
				{
					return false;
				}
				else
				{
					return true;
				}
			}
		}
		else
		{
			return true;;
		}
	}

	//Get User ID
	public function getUserID()
	{
        //Grab User Profile
		return $this->facebook_data['userID'] = $this->facebook->getUser();
	}

	//Get user profile
	public function getUserProfile()
	{
        // We may or may not have this data based on whether the user is logged in.
        //
        // If we have a $user id here, it means we know the user is logged into
        // Facebook, but we don't know if the access token is valid. An access
        // token is invalid if the usker logged out of Facebook.
        if($this->facebook_data['userID'] != 0)
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
                $this->facebook_data['userID'] = 0;
            }
			return $this->facebook_data;
        }
    }

	//Log into facebook and set session var
	public function login()
	{
		$this->facebook_data['loginUrl'] = $this->facebook->getLoginUrl();

		//Create Session
		$this->session->set_userdata('facebook_data', $this->facebook_data);

		return $this->facebook_data;
	}

	//Log out of facebook and destory session var
	public function logout()
	{
		//Generate the logout url before we clear the data
		$logoutUrl = $this->facebook->getLogoutUrl(array('next'=>base_url()."news"));

		//Clear all facebook data in app
		$this->facebook->destroySession();
		$this->session->sess_destroy();
		$this->session->userdata = array();

		//Redirect to facebook logout url so user is also logged out of facebook.com
		redirect($logoutUrl);
	}
}
?>
