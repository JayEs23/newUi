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
	
	public function EditPwd()
	{
		$email=''; $Pwd='';
	
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('pwd')) $Pwd = $this->input->post('pwd');
						
		//Check if record exists
		$sql = "SELECT * FROM customers WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
					
		if ($query->num_rows() == 0 )
		{
			$ret='Customer record with email <b>'.$email.'</b> does not exist in the database.';			
		}else
		{
			$this->db->trans_start();	//Update password		
						
			$this->db->where('email', $email);
			$dat=array('pwd' => $this->db->escape_str($Pwd));
			$this->db->update('customers', $dat);
			
			$this->db->trans_complete();

			$Msg='';
			
			if ($this->db->trans_status() === FALSE)
			{
				$Msg="Attempted editing customer password with email '".$email."' but failed.";

				$ret = 'Password Reset Was Not Successful.';
			}else
			{
				#Update reset_pwd table
				$sql="SELECT * FROM reset_pwd WHERE (email='".$this->db->escape_str($email)."')";

				$query = $this->db->query($sql);

				if ( $query->num_rows() > 0 )
				{
					$this->db->trans_start();	
								
					$this->db->where('email',$email);
					$this->db->delete('reset_pwd');
					$this->db->trans_complete();
					
					$Msg="Customer with email ".$email." carried out a successful password reset.";
									
					#Send Email - EmailSender($from,$to,$Cc,$message,$name)
					$img=base_url()."images/emaillogo.png";
								
					$nm=$this->getdata_model->GetCustomerName($email);
						
					if (trim($nm)=='') $nm='Customer';
					
		#$file = fopen('aaa.txt',"w"); fwrite($file, $nm); fclose($file);
		
					$from='support@sparechange.com.ng';
					$to=$email;
					$subject='SaveMyChange Updated Password';
					$Cc='';
					
					$img=base_url()."images/emaillogo.png";
					
					$message = '
						<html>
						<head>
						<meta charset="utf-8">
						<title>SaveMyChange Password Reset</title>
						</head>
						<body>
								<p><img src="'.$img.'" width="100" title="SaveMyChange" /></p>
								
								Hello '.$nm.',<br>
								
								<p>You have successfully reset your access password. Please ensure that you have noted down your new password. DO NOT EXPOSE YOUR PASSWORD TO UNAUTHORIZED PERSONS.</p>
																																										
								<p>Best Regards</p>
								SaveMyChange
						</body>
						</html>';
						
						$altmessage = '
							Hello '.$nm.',
									
							You have successfully reset your access password. Please ensure that you have noted down your new password. DO NOT EXPOSE YOUR PASSWORD TO UNAUTHORIZED PERSONS.
																																						
							Best Regards
							
							SaveMyChange';
					
					$v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$nm);
			
					$ret ="OK";	
				}else
				{
					$Msg="Attempted editing customer password with email '".$email."' but failed. No password reset request was made.";

					$ret = 'Password Reset Was Not Successful.';
				}					
			}
			
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
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
			$this->palert='Sorry. Your Password Request Was Not Found In Our Database. You Cannot Proceed With The Reset.';
		}
		
		$this->index();
	}
	
	public function index()
	{
		$set=$this->getdata_model->GetParamaters();
			
		if (intval($set->refreshinterval) > 0)
		{
			$data['RefreshInterval'] = $set->refreshinterval;
		}else
		{
			$data['RefreshInterval']=5;
		}
		
		$data['Email']=$this->pemail;
		$data['Alert']=$this->palert;
		
		if ($this->pflag==true) $data['Success']='Yes'; else $data['Success']='No';
		
		$this->load->view('resetpwd_view',$data);
	}
}
