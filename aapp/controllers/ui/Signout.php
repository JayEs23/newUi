<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Signout extends CI_Controller {	
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url'); 
		$this->load->model('getdata_model');
	 }
	

	public function index()
	{
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
		$_SESSION = array();
		
		unset($_SESSION);
    			
		session_destroy();
		
		$host=strtolower(trim($_SERVER['HTTP_HOST']));
		
		if ($host=='localhost')
		{
			echo '<script>window.location.replace("http://localhost/lvi/ui/Login/");</script>';
		}else
		{
			echo '<script>window.location.replace("http://www.naijaartmart.com/ethoz/ui/Login/");</script>';
		}
	}
}
