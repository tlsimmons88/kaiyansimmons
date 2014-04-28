<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VideosController extends CI_Controller
{
	public function index()
	{
		$this->load->add_package_path(APPPATH.'third_party/facebook/');
		$this->load->library('facebook');
		$this->load->view('videos');
	}
}
?>
