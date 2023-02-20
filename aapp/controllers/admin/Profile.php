<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('assets/vendor/autoload.php');

class Profile extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	 
	 
	function ChangePassword()
	{
		$pwd=''; $email=''; $ret=''; $opwd = '';
	
		if ($this->input->post('pwd')) $pwd = $this->input->post('pwd');
		if ($this->input->post('email')) $email = $this->input->post('email');
		if ($this->input->post('opwd')) $opwd = $this->input->post('opwd');
		
		//Check if record exists
		$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
					
		if ($query->num_rows() == 0 )
		{
			$ret='User record with email <b>'.$email.'</b> does not exist in the database.';
		}else
		{
			//Verify old password
			$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
			
			$query = $this->db->query($sql);
			
			$row = $query->row();
			
			$temp_pwd=''; $nm='';
		
			if ($row->pwd)
			{
				$temp_pwd=trim($row->pwd);
				
				$temp_pwd=\mervick\aesEverywhere\AES256::decrypt($temp_pwd,ACCESS_STAMP);
			}
			
			if ($row->fullname) $nm=trim($row->fullname);
						
			if (trim($nm)=='') $nm='User';

			$temp_opwd=\mervick\aesEverywhere\AES256::decrypt($opwd,ACCESS_STAMP);
			
			
			if ($temp_pwd <> $temp_opwd)
			{
				$ret='Old password entered is not correct.';			
			}else
			{
				$this->db->trans_start();	//Update password		
							
				$this->db->where('email', $email);
				$dat=array('pwd' => $this->db->escape_str($pwd));
				$this->db->update('userinfo', $dat);
				
				$this->db->trans_complete();
	
				$Msg='';
				
				if ($this->db->trans_status() === FALSE)
				{
					$Msg="Staff with email, ".$email." attempted changing user password but failed.";
	
					$ret = 'Password Change Was Not Successful.';
				}else
				{
					setcookie("TR6wTuqB6pfUCBRd99T8QCk2pUrGJC", "", time() - ($days * 86400 * 1000));
					
					$Msg="User with email ".$email." carried out a successful password change.";
										
					$img=base_url()."images/emaillogo.png";
		
					$from='support@naijaartmart.com';
					$to=$email;
					$subject='Password Change';
					$Cc='';
					
					$img=base_url()."images/emaillogo.png";
					
					//<p><img src="'.$img.'" width="100" title="Naija Art Mart" /></p>
					
					$message = '
						<html>
						<head>
						<meta charset="utf-8">
						<title>Naija Art Mart - Password Change</title>
						</head>
						<body>
								Dear User,
								
								<br><br>You have successfully changed your password. Please ensure that you have noted down your new password. DO NOT EXPOSE YOUR PASSWORD TO UNAUTHORIZED PERSONS.
																																										
								<br><br>Best Regards
								<br>Naija Art Mart
						</body>
						</html>';
						
						$altmessage = '
							Hello '.$nm.',
									
							You have successfully changed your password. Please ensure that you have noted down your new password. DO NOT EXPOSE YOUR PASSWORD TO UNAUTHORIZED PERSONS.
																																						
							Best Regards
							
							Naija Art Mart';
					
					$v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$nm);
			
					$ret ="OK";					
				}
				
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
				$this->getdata_model->LogDetails($nm,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'CHANGED PASSWORD',$_SESSION['LogID']);	
			}
		}
	
		echo $ret;	
	}
	
	function UpdateProfile()
	{
		$name=''; $email=''; $ret=''; $phone='';
	
		if ($this->input->post('name')) $name = $this->input->post('name');
		if ($this->input->post('phone')) $phone = $this->input->post('phone');
		if ($this->input->post('email')) $email = $this->input->post('email');
		
		if (trim($phone) <> '') $storephone=$this->getdata_model->RegularPhoneNo($phone);
				
		//Check if record exists
		$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
					
		if ($query->num_rows() == 0 )
		{
			$ret='User record with email <b>'.$email.'</b> does not exist in the database.';
		}else
		{
			#Get Old Values
			$row = $query->row();
			
			$OldName=''; $OldPh='';
			
			if (isset($row))
			{
				if ($row->fullname) $OldName = $row->fullname;
				if ($row->phone) $OldPh = $row->phone;
			}
			
			$BeforeValues="Name = ".$OldName."; Phone = ".$OldPh;				
				
			$AfterValues="Name = ".$name.";  Phone = ".$storephone;
			
			//Update transactions
			$this->db->trans_start();			
			$where = "email='".$this->db->escape_str($email)."'";
			
			$dat=array(
				'fullname' => $this->db->escape_str($name),
				'phone' => $this->db->escape_str($storephone)
			);
			
			$this->db->update('userinfo', $dat, $where);			
			$this->db->trans_complete();
			
			$Msg='';
			
			if ($this->db->trans_status() === FALSE)
			{					
				$Msg="Attempted editing user profile with email '".$email."' but failed.";
				$ret = 'Profile Editing Was Not Successful.';
			}else
			{
				$_SESSION['phone']=$storephone;
				$_SESSION['fullname']=$name;
								
				$Msg="User with email '".$email."' edited profile successfully. Profile data before editing => ".$BeforeValues.". Profile data after editing => ".$AfterValues;			
				
				#Send Email - EmailSender($from,$to,$Cc,$message,$name)
				$from='support@naijaartmart.com';
				$to=$email;
				$subject='Updated Profile';
				//$Cc='idongesit_a@yahoo.com';
				
				$img=base_url()."images/emaillogo.png";
				
				$message = '
					<html>
					<head>
					<meta charset="utf-8">
					<title>Naija Art Mart | User Profile Update</title>
					</head>
					<body>
							<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
							
							Dear '.$name.',<br><br></p>
							
							<p>You have successfully updated your profile.</p>
																																									
							<p>Best Regards</p>
							<p>
								Admin
							</p>
					</body>
					</html>';
					
					$altmessage = '
						Dear '.$name.',
								
						You have successfully updated your profile.
																																					
						Best Regards
						
						Admin';
				
				#SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$fullname)
				if ($email) $v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$name);
		
				$ret ="OK";	
			}
			
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
			$this->getdata_model->LogDetails($name,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'UPDATE PROFILE',$_SESSION['LogID']);
		}
	
		echo $ret;	
	}
	
	public function index()
	{
		$data['fullname']=''; $data['email']=''; $data['phone']='';
		$data['accountstatus'] = ''; $data['usertype'] = ''; $data['datecreated'] = '';
		
		$data['CreateAccount']='0';
		$data['AddItem']='0'; $data['EditItem']='0'; $data['DeleteItem']='0'; $data['ClearLogFiles']='0';
		$data['ViewLogReports']='0'; $data['ViewReports']='0'; $data['SetParameters']='0';
		
		$data['SetMarketParameters']=''; $data['ViewOrders']=''; $data['ViewPrices']='';
		$data['BuyAndSellToken']=''; $data['RegisterBroker']=''; $data['PublishWork']='';
		$data['RequestListing']='';
		
		if ($_SESSION['email'])
		{
			$data['email']=trim($_SESSION['email']);
						
			#User Info
			if ($_SESSION['fullname']) $data['fullname']=$_SESSION['fullname'];
			if ($_SESSION['accountstatus']) $data['accountstatus'] = $_SESSION['accountstatus'];
			if ($_SESSION['datecreated']) $data['datecreated'] = $_SESSION['datecreated'];
			if ($_SESSION['usertype']) $data['usertype'] = $_SESSION['usertype'];
			if ($_SESSION['phone']) $data['phone']=$_SESSION['phone'];
			
			//Get Permissions
			$perm=$this->getdata_model->GetPermissions($data['email']);				
			
			if ($perm->RequestListing==1) $data['RequestListing']=1;
			if ($perm->PublishWork==1) $data['PublishWork']=1;
			if ($perm->RegisterBroker==1) $data['RegisterBroker']=1;			
			if ($perm->BuyAndSellToken==1) $data['BuyAndSellToken']=1;
			if ($perm->ViewPrices==1) $data['ViewPrices']=1;			
			if ($perm->ViewOrders==1) $data['ViewOrders']=1;
			if ($perm->SetMarketParameters==1) $data['SetMarketParameters']=1;
			
			if ($perm->CreateAccount==1) $data['CreateAccount']=1;
			if ($perm->ClearLogFiles==1) $data['ClearLogFiles']=1;			
			if ($perm->SetParameters==1) $data['SetParameters']=1;			
			if ($perm->ViewLogReports==1) $data['ViewLogReports']=1;					
			if ($perm->ViewReports==1) $data['ViewReports']=1;			
			if ($perm->AddItem==1) $data['AddItem']=1;
			if ($perm->EditItem==1) $data['EditItem']=1;
			if ($perm->DeleteItem==1) $data['DeleteItem']=1;
			
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
			
			$this->load->view('admin/profile_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
