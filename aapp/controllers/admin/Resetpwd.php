<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Resetpwd extends CI_Controller {	
	private $pemail='',$pflag=false, $palert='';
	
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url'); 
		$this->load->model('getdata_model');
	 }
	
	
	public function UpdatePassword()
	{
		$email=''; $Pwd=''; $opwd = '';
	
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('pwd')) $Pwd = $this->input->post('pwd');
						
		//Check if record exists
		$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() == 0 )
		{
			$ret='User record with email <b>'.$email.'</b> does not exist in the database.';			
		}else
		{
			$this->db->trans_start();	//Update password		
							
			$this->db->where('email', $email);
			$dat=array('pwd' => $this->db->escape_str($Pwd));
			$this->db->update('userinfo', $dat);
			
			$this->db->trans_complete();

			$Msg='';
			
			if ($this->db->trans_status() === FALSE)
			{
				$Msg="Attempted resetting user password with email '".$email."' but failed.";

				$ret = 'Password Reset Was Not Successful.';
			}else
			{
				setcookie("TR6wTuqB6pfUCBRd99T8QCk2pUrGJC", "", time() - ($days * 86400 * 1000));
				
				$Msg="User with email ".$email." carried out a successful password reset.";
									
				$img=base_url()."images/emaillogo.png";
							
				$nm=$this->getdata_model->GetUserName($email);
					
				if (trim($nm)=='') $nm='User';
	
				$from='support@naijaartmart.com';
				$to=$email;
				$subject='Password Reset';
				$Cc='';
				
				$img=base_url()."images/emaillogo.png";
				
				$message = '
					<html>
					<head>
					<meta charset="utf-8">
					<title>Naija Art Mart - Password Reset</title>
					</head>
					<body>
							<p><img src="'.$img.'" width="100" title="Naija Art Mart" /></p>
							
							Hello '.$nm.',<br>
							
							<p>You have successfully reset your password. Please ensure that you have noted down your new password. DO NOT EXPOSE YOUR PASSWORD TO UNAUTHORIZED PERSONS.</p>
																																									
							<p>Best Regards</p>
							Admin
					</body>
					</html>';
					
					$altmessage = '
						Hello '.$nm.',
								
						You have successfully reset your password. Please ensure that you have noted down your new password. DO NOT EXPOSE YOUR PASSWORD TO UNAUTHORIZED PERSONS.
																																					
						Best Regards
						
						Admin';
				
				$v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$nm);
		
				$ret ="OK";					
			}
			
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
			$this->getdata_model->LogDetails($nm,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'PASSWORD RESET',$_SESSION['LogID']);				
		}
	
		echo $ret;	
	}
	
	
	public function Reset()
	{
		$parameters = $this->uri->uri_to_assoc();
		$ResetCode = $parameters['rc'];
		
		$sql="SELECT * FROM reset_pwd WHERE (SHA1(email)='".$this->db->escape_str($ResetCode)."')";
			
		$query = $this->db->query($sql);
		
		if ( $query->num_rows()> 0 )
		{
			$row = $query->row();
			$em='';
			
			if ($row->email) $em=$row->email;
			
			$this->pemail=$em;
			$this->pflag=true;
		}else
		{
			$this->palert='Sorry. Your Password Recovery Request Was Not Found In Our Database.';
		}
		
		$this->index();
	}
	
	public function index()
	{
		$data['Email']=$this->pemail;
		$data['Alert']=$this->palert;
		
		if ($this->pflag==true) $data['Success']='Yes'; else $data['Success']='No';
		
		$ret=$this->getdata_model->GetMarketStatus();				
		$data['MarketStatus']=$ret['MarketStatus'];
		$data['ScrollingPrices']=$this->getdata_model->MarketData();
		
		$set=$this->getdata_model->GetParamaters();
				
		if (intval($set->refreshinterval) > 0)
		{
			$data['RefreshInterval'] = $set->refreshinterval;
		}else
		{
			$data['RefreshInterval']=5;
		}
		
		$this->load->view('admin/resetpwd_view',$data);
	}
}
