<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terms extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	 
	public function index()
	{
		$this->load->view('ui/terms_of_service',$data);
	}
}
