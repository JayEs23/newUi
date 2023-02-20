<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Confirmreg extends CI_Controller {	
	private $reg_success=false;
	
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('getdata_model');
	 }
	
	public function Confirm()
	{
		$c = $this->uri->segment(5); //1 -> ui
		$activationCode = $c;
		
		//$file = fopen('aaa.txt',"w"); fwrite($file,$this->uri->segment(5)); fclose($file);
		
		#Check for the code in the db
		$sql = "SELECT * FROM investors WHERE (sha1(TRIM(email))='".$this->db->escape_str($activationCode)."')";
		
		$query = $this->db->query($sql);
			
		$em=''; $sta='0'; $pwd='';
		
		if ($query->num_rows() > 0 )
		{
			$row = $query->row();
					
			if ($row->email) $em=$row->email;
			if ($row->accountstatus==1) $sta=$row->accountstatus;
			if ($row->pwd) $pwd=$row->pwd;
			
			if ($sta <> 1)
			{
				$this->db->trans_start();
	
				$dat=array('accountstatus' => 1);														
				$this->db->where('sha1(email)', $activationCode);				
				$this->db->update('investors', $dat);
				
				$this->db->trans_complete();
							
				$Msg='';
	
				if ($this->db->trans_status() === FALSE)
				{					
					$Msg=$nm." attempted activating the investor account with email ".$em." but failed.";
					
					$rows[] = "Account activation was not successful.";
				}else
				{
					$Msg="Investor with email ".$em." successfully activated his/her account.";
										
					$rows[] = "<p>Your account has been successfully activated. You can log in to your account dashboard to modify any data and to carry out transactions.</p>";
					
					$this->reg_success=true;
				}	
			}else
			{
				$Msg=$nm." attempted activating an already activated account with email ".$em." but failed.";
				$rows[] = "Account has already been activated.";
			}
			
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
			$this->getdata_model->LogDetails($nm,$Msg,$em,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'ACTIVATED INVESTOR',$activationCode);
			
			$this->index();
		}
		
	}#End Of Register functions
			
	public function index()
	{		
		$this->getdata_model->KillSleepingConnections();
				
		if ($this->reg_success==true)
		{
			$data['RegisterInfo']='<strong>Congratulations!</strong> You have successfully activated your Naija Art Mart account. Click <a href="'.site_url("ui/Login").'">HERE</a> to go to the log in page.';
			
			$this->load->view('ui/registersuccess_view',$data);#Success Page
		}else
		{
			$data['RegisterInfo']='<strong>Sorry!</strong> Your Naija Art Mart account activation was not successful. Click <a href="'.site_url("ui/Home").'">HERE</a> to go to the home page.';
			
			$this->load->view('ui/registerfail_view',$data);#Fail Page
		}	
	}
}
