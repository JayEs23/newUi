<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Rc extends CI_Controller {	
	private $reg_success=false;
	private $name='';
	private $email='';
	private $phone='';
	
	function __construct() 
	{
		parent::__construct();
	}
	
	public function RegCom()#Registration Complete
	{		#/Rc/RegCom/name/'+e.name+'/email/'+e.email+'/flag/'+e.Flag+'/phone/'+e.phone;
		$parameters = $this->uri->uri_to_assoc();
		$this->name = urldecode($parameters['name']);
		$this->email = urldecode($parameters['email']);
		$this->phone = urldecode($parameters['phone']);
		$flag = $parameters['flag'];
		
		if ($flag=='OK') $this->reg_success=true;
		
		$this->index();
	}#End Of RegisterComplete functions
	
	
	public function index()
	{			
		if ($this->reg_success==true)
		{
			$data['RegisterInfo']="<strong>Congratulations ".$this->name."!</strong> You have successfully registered your account. However, you will not be able to login until you activate your account. Please confirm the mail sent to <b>".$this->email."</b> to activate your account!.";
						
			$this->load->view('registersuccess_view',$data);#Success Page
		}else
		{
			$data['RegisterInfo']="<strong>Sorry ".$this->name."!</strong> You account registration was not successful. Please start the registration process again.";
			
			$this->load->view('registerfail_view',$data);#Fail Page
		}	
	}
}
