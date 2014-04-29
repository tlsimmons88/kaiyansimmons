<?php

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		//We do this for the sake of facebook API.
		parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
	}
}