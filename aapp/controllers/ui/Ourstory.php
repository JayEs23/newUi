<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('assets/vendor/autoload.php');

class Ourstory extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	
	
	public function index()
	{
		$this->load->view('ui/ourstory_view',$data);
	}
}
