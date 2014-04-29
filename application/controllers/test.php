<?php
/**
 * @property Facebook $facebook
 */
class Test extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
	}

	public function index()
	{
		//We don't need a facebook model. You already have that with the Library. 
		//So Lets try to get a userID
		$pageData = array();
		if($userID = $this->facebook->getUser())
		{
			try
			{
				$pageData['userProfile'] = $this->facebook->api('/me' , 'GET');
			}
			catch(FacebookApiException $e)
			{
				$pageData['login_url'] = $this->facebook->getLoginUrl();
				$pageData['login_error'] = $e->getMessage();
			}
		}
		else
		{
			$pageData['login_url'] = $this->facebook->getLoginUrl();
		}
		
		
		$this->load->view('test/index.phtml' , array('pageData'=>$pageData));
	}
}