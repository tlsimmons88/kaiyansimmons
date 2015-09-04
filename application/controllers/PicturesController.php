<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PicturesController extends MY_Controller
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
		$data['page'] = "pictures";
		$data['error'] = "";
		$media = array();		//hold all media found in database
		$pictures = array();	//hold just images found in database

		//Call api
		$url = base_url("api/rest/media_by_date");
		$results = $this->executeCurl($url, null, false);

		if($results['status'] == "OK")
		{
			$media = json_decode($results['data'], true);

			foreach($media as $medium)
			{
				if($medium['type_id'] == 1)
				{
					$pictures[] = $medium;
				}
			}
		}
		else
		{
			$data['error'] = "There was a problem finding pictures.";
		}
		$data['media'] = $pictures;

		//Load view
		$this->load->view('pictures', $data);
	}

	/*
	* @description - Function that makes the curl call to the .net rest api
	* @param - url - string - the URL to curl
	* @param - data - array - POST Data to send in cur
	* @param - isPost - bool - Flag to set if the curl call is post or not
	* @return - array - results of curl call
	*/
	private function executeCurl($url, $data, $isPost = true)
	{
		//$serviceAccount = $this->getServiceAccount();

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		if($isPost == true)
		{
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		}
		//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
		curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, true);
		//curl_setopt($ch, CURLOPT_USERPWD, $serviceAccount['UserID'].":".$serviceAccount['Password']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		//Exexcute curl call, and grab the http status code.
		$curlResults = curl_exec($ch);
		$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		/*if($httpStatusCode == 401)
		{
			throw new \Exception("Could not authenticate Service Account with the Active Directory Domain provided.  Please verify the account is a memeber of that domain.");
		}*/

		//Convert results to an Assc Array so that it can be onverted to xml or json
		//$results = array();
		return json_decode($curlResults, true);
		//$results['httpStatusCode'] = $httpStatusCode;
		curl_close($ch);

		//return $results;
	}
}
?>
