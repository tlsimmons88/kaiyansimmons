<?php
/**
 * @property Facebook $facebook
 * @property layout $layout
 */
class Test extends MY_Controller
{
	public function index()
	{
		//We don't need a facebook model. You already have that with the Library. 
		//So Lets try to get a userID
		if($userID = $this->facebook->getUser())
		{
			try
			{
				$user = $this->facebook->api('/me' , 'GET');
				$this->layout->set('user', $user);
				$this->layout->set('loginoutLink', $this->facebook->getLogoutUrl(array('next'=>'http://travis.site.com/test/logout')));
			}
			catch(FacebookApiException $e)
			{
				$this->layout->set('loginoutLink', $this->facebook->getLoginUrl());
				$this->layout->set('loginError', $e->getMessage());
			}
		}
		else
		{
			$this->layout->set('loginoutLink', $this->facebook->getLoginUrl());
		}
		
		
		$this->layout->render();
	}
	
	public function logout()
	{
		$this->facebook->destroySession();
		redirect('/test/index');
	}
}