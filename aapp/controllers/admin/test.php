<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
										
		#Load the getdata model to make it available to *all* of the controller's actions 
		$this->load->model('getdata_model');
	 }
	
	public function index()
	{
		$data['Email']='idongesit_a@yahoo.com';
		$this->load->view('resetpwd_view',$data);
	}
}
