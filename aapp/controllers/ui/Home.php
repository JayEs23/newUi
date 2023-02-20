<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	 
	public function index()
	{
		$data['LastestPixs']=$this->getdata_model->GetLatestListings();//latest 3
		$this->load->view('ui/home_view',$data);
	}
}
