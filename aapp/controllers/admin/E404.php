<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");


class E404 extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');		
	}

	public function index()
	{		
		$this->load->view('admin/error_404_view');
	}
}
