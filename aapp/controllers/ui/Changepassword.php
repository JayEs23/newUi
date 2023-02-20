<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('assets/vendor/autoload.php');

class Changepassword extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	
	public function UpdatePassword()
	{
		$usertype=''; $email=''; $pwd = ''; $opwd='';
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('pwd')) $pwd = $this->input->post('pwd');
		if ($this->input->post('opwd')) $opwd = $this->input->post('opwd');			
				
		//Check if record exists
		if (strtolower($usertype) == 'issuer')
		{
			$sql = "SELECT * FROM issuers WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		}elseif (strtolower($usertype) == 'investor')// or (strtolower($usertype) == 'investor/issuer'))
		{
			$sql = "SELECT * FROM investors WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		}elseif (strtolower($usertype) == 'broker')
		{
			$sql = "SELECT * FROM brokers WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		}

		$query = $this->db->query($sql);
					
		if ($query->num_rows() == 0 )
		{
			$ret='User record with email "'.$email.'" does not exist in the database.';
		}else
		{
			$user_name='';
			
			if (strtolower($usertype) == 'issuer')
			{
				$rw=$this->getdata_model->GetIssuerDetails($email);
				
				if ($rw->user_name) $user_name=trim($rw->user_name);
			}elseif ((strtolower($usertype) == 'investor') or (strtolower($usertype) == 'investor/issuer'))
			{
				$rw=$this->getdata_model->GetInvestorDetails($email);
				
				if ($rw->user_name) $user_name=trim($rw->user_name);
			}elseif ((strtolower($usertype) == 'broker'))
			{
				$rw=$this->getdata_model->GetBrokerDetails($email);
				
				if ($rw->company) $user_name=trim($rw->company);
			}
			
			$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
			
			$query = $this->db->query($sql);
			
			$row = $query->row();
			
			$temp_pwd='';
		
			if ($row->pwd)
			{
				$temp_pwd=trim($row->pwd);
				
				$temp_pwd=\mervick\aesEverywhere\AES256::decrypt($temp_pwd,ACCESS_STAMP);
			}

			$temp_opwd=\mervick\aesEverywhere\AES256::decrypt($opwd,ACCESS_STAMP);	
				
			if ($temp_pwd <> $temp_opwd)
			{
				$ret='Wrong current password entered.';
			}else
			{
				$op='';
				
				$OldValues="Email = ".$email."; Password = ".$opwd;				
				$NewValues="Email = ".$email."; Password = ".$pwd;	
							
				$dat=array('pwd' => $this->db->escape_str($pwd));
								
				#Edit
				if (strtolower($usertype) == 'issuer')
				{
					$this->db->trans_start();
					$this->db->where(array('email' => $email));
					$this->db->update('issuers', $dat);			
					$this->db->trans_complete();
					
					$op='CHANGED ISSUER PASSWORD';
				}elseif (strtolower($usertype) == 'investor')
				{
					$this->db->trans_start();
					$this->db->where(array('email' => $email));
					$this->db->update('investors', $dat);			
					$this->db->trans_complete();
					
					$op='CHANGED INVESTOR PASSWORD';
				}elseif ((strtolower($usertype) == 'broker'))
				{
					$this->db->trans_start();
					$this->db->where(array('email' => $email));
					$this->db->update('brokers', $dat);			
					$this->db->trans_complete();
					
					$op='CHANGED BROKER PASSWORD';
				}/*elseif (strtolower($usertype) == 'investor/issuer')
				{
					$this->db->trans_start();
					$this->db->where(array('email' => $email));
					$this->db->update('issuers', $dat);			
					$this->db->trans_complete();
					
					$this->db->trans_start();
					$this->db->where(array('email' => $email));
					$this->db->update('investors', $dat);			
					$this->db->trans_complete();
					
					$op='CHANGED INVESTOR/ISSUER PASSWORD';
				}*/
				
				//Update userinfo
				$this->db->trans_start();
				$this->db->where(array('email' => $email));
				$this->db->update('userinfo', $dat);			
				$this->db->trans_complete();
							
				$Msg='';
			
				if ($this->db->trans_status() === FALSE)
				{					
					$Msg=$_SESSION['email']." attempted changing password for the account with email ".strtoupper($email)." but failed.";
					
					$ret = 'Password Could Not Be Changed.';
				}else
				{
					$Msg="Password has been changed successfully by ".$_SESSION['email'].". Old Values => ".$OldValues.". Updated values => ".$NewValues;
					
					$ret ='OK';
					
					#Send Email - EmailSender($from,$to,$Cc,$message,$name)
					$from='support@naijaartmart.com';
					$to=$email;
					$subject='Password Change';
					$Cc='';
									
					$img=base_url()."images/logo.png";
					//$img="https://imgur.com/idvcINL";
					
					//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
					
					$message = '
						<html>
						<head>
						<meta charset="utf-8">
						<title>Naija Art Mart | Change Password</title>
						</head>
						<body>															
								Dear User,
								
								<br><br>You have successfully changed your password. Please ensure that you have noted down your new password. DO NOT EXPOSE YOUR PASSWORD TO UNAUTHORIZED PERSONS.
																																										
								<br><br>Best Regards
								<br>Naija Art Mart
						</body>
						</html>';
						
					$altmessage = '
						Dear User,
								
						You have successfully changed your password. Please ensure that you have noted down your new password. DO NOT EXPOSE YOUR PASSWORD TO UNAUTHORIZED PERSONS.
																																					
						Best Regards
						
						Naija Art Mart';
					
					#SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$name)
					if ($to) $v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$user_name);

					$remote_ip=$_SERVER['REMOTE_ADDR'];
					$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
					//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
					$this->getdata_model->LogDetails($user_name,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,$op,$_SESSION['LogID']);	
				}	
			}
						
		}
				
		echo $ret;
	}
	
	public function index()
	{
		$data['lastname']=''; $data['firstname']=''; $data['email']=''; $data['phone']=''; $data['pix']='';
		$data['accountstatus'] = ''; $data['role'] = ''; $data['pix'] = '';
		
		$data['CreateAccount']='0';
		$data['AddItem']='0'; $data['EditItem']='0'; $data['DeleteItem']='0'; $data['ClearLogFiles']='0';
		$data['ViewLogReports']='0'; $data['ViewReports']='0'; $data['SetParameters']='0';
		
		$data['SetMarketParameters']=''; $data['ViewOrders']=''; $data['ViewPrices']='';
		$data['BuyAndSellToken']=''; $data['RegisterBroker']=''; $data['PublishWork']='';
		$data['RequestListing']='';
		
		$data['userlogo'] = '';
		
		if ($_SESSION['email'])
		{
			$data['email']=trim($_SESSION['email']);
						
			$user=$this->getdata_model->GetUserDetails($data['email']);
								
			#User Info
			if ($user->fullname) $data['fullname']=$user->fullname;
			if ($user->company) $data['company']=$user->company;
			if ($user->accountstatus) $data['accountstatus'] = $user->accountstatus;
			if ($user->datecreated) $data['datecreated'] = $user->datecreated;
			if ($user->usertype) $data['usertype'] = $user->usertype;
			if ($user->phone) $data['phone']=$user->phone;
			
			if ($user->company)
			{
				$data['fullname']=$user->company;
			}elseif ($user->fullname)
			{
				$data['fullname']=$user->fullname;
			}
			
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
			
			$set=$this->getdata_model->GetParamaters();

			if (intval($set->refreshinterval) > 0)
			{
				$data['RefreshInterval'] = $set->refreshinterval;
			}else
			{
				$data['RefreshInterval']=5;
			}
			
			$data['balance']=$this->getdata_model->GetWalletBalance($data['email']);
			
			$ret=$this->getdata_model->GetMarketStatus();									
			$data['MarketStatus']=$ret['MarketStatus'];
			$data['ScrollingPrices']=$this->getdata_model->MarketData();
						
			$this->load->view('ui/changepassword_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('');
		}
	}
}
