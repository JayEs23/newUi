<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('assets/vendor/autoload.php');

class ManageUsers extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	 }
	
	function GetCompanies()
	{
		$sql="SELECT DISTINCT(company) as company FROM brokers ORDER BY company";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetCompanies
	
	function LoadUsers()
	{
		$company='';
		
		if ($this->input->post('company')) $company = trim($this->input->post('company'));
		
		if ($company=='')
		{
			$sql = "SELECT DATE_FORMAT(datecreated,'%d %b %Y') AS date_created,userinfo.* FROM userinfo ORDER BY company,fullname";
		}else
		{
			$sql = "SELECT DATE_FORMAT(datecreated,'%d %b %Y') AS date_created,userinfo.* FROM userinfo WHERE TRIM(company)='".$this->db->escape_str($company)."' ORDER BY fullname";
		}
		
		
		$query=$this->db->query($sql);
		
		echo json_encode($query->result());
	}#End Of LoadUsers functions
		
	function AddUsers()
	{
		$email=''; $company=''; $fullname=''; $phone=''; $pwd=''; $usertype=''; $accountstatus='0';
		
		$AddItem='0';$EditItem='0'; $DeleteItem='0'; $CreateAccount='0'; $ClearLogFiles='0';
		$SetParameters='0'; 		$ViewLogReports='0'; $ViewReports='0';
		
		$RequestListing='0'; $PublishWork='0'; $RegisterBroker='0'; $BuyAndSellToken='0';
		$ViewPrices='0'; $ViewOrders='0'; $SetMarketParameters='0'; $ret = '';
	
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('company')) $company = trim($this->input->post('company'));
		if ($this->input->post('fullname')) $fullname = trim($this->input->post('fullname'));		
		if ($this->input->post('phone')) $phone = trim($this->input->post('phone'));
		if ($this->input->post('pwd')) $pwd = $this->input->post('pwd');
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));		
		if ($this->input->post('accountstatus')) $accountstatus = trim($this->input->post('accountstatus'));		
		if ($this->input->post('AddItem')) $AddItem = trim($this->input->post('AddItem'));		
		if ($this->input->post('EditItem')) $EditItem = trim($this->input->post('EditItem'));
		if ($this->input->post('DeleteItem')) $DeleteItem = trim($this->input->post('DeleteItem'));				
		if ($this->input->post('CreateAccount')) $CreateAccount = trim($this->input->post('CreateAccount'));		
		if ($this->input->post('ClearLogFiles')) $ClearLogFiles = trim($this->input->post('ClearLogFiles'));		
		if ($this->input->post('SetParameters')) $SetParameters = trim($this->input->post('SetParameters'));
		if ($this->input->post('ViewLogReports')) $ViewLogReports = trim($this->input->post('ViewLogReports'));		
		if ($this->input->post('ViewReports')) $ViewReports = trim($this->input->post('ViewReports'));		
		if ($this->input->post('RequestListing')) $RequestListing = trim($this->input->post('RequestListing'));		
		if ($this->input->post('PublishWork')) $PublishWork = trim($this->input->post('PublishWork'));
		if ($this->input->post('RegisterBroker')) $RegisterBroker = trim($this->input->post('RegisterBroker'));
		if ($this->input->post('BuyAndSellToken')) $BuyAndSellToken = trim($this->input->post('BuyAndSellToken'));
		if ($this->input->post('ViewPrices')) $ViewPrices = trim($this->input->post('ViewPrices'));
		if ($this->input->post('ViewOrders')) $ViewOrders = trim($this->input->post('ViewOrders'));
		if ($this->input->post('SetMarketParameters')) $SetMarketParameters = trim($this->input->post('SetMarketParameters'));
				
		$datecreated=date('Y-m-d H:i:s');
		
		if (!$accountstatus) $accountstatus='0';
			
		//Check if record exists
		$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		$query = $this->db->query($sql);
					
		if ($query->num_rows() > 0 )
		{
			$ret = 'User Account Creation Was Not Successful. Email <b>'.$email.'</b> Exists In The Database.';
		}else
		{
			$this->db->trans_start();
				
			$dat=array(
				'email' 				=> $this->db->escape_str($email),
				'fullname' 				=> $this->db->escape_str($fullname),
				'phone' 				=> $this->db->escape_str($phone),
				'company' 				=> $this->db->escape_str($company),
				'pwd' 					=> $this->db->escape_str($pwd),
				'usertype' 				=> $this->db->escape_str($usertype),				
				'accountstatus' 		=> '0',
				'datecreated' 			=> $this->db->escape_str($datecreated),				
				'AddItem' 				=> $this->db->escape_str($AddItem),
				'EditItem' 				=> $this->db->escape_str($EditItem),
				'DeleteItem' 			=> $this->db->escape_str($DeleteItem),				
				'CreateAccount' 		=> $this->db->escape_str($CreateAccount),	
				'ClearLogFiles' 		=> $this->db->escape_str($ClearLogFiles),
				'ViewReports' 			=> $this->db->escape_str($ViewReports),
				'ViewLogReports' 		=> $this->db->escape_str($ViewLogReports),				
				'SetParameters' 		=> $this->db->escape_str($SetParameters),				
				'RequestListing' 		=> $this->db->escape_str($RequestListing),
				'PublishWork' 			=> $this->db->escape_str($PublishWork),
				'RegisterBroker' 		=> $this->db->escape_str($RegisterBroker),
				'BuyAndSellToken' 		=> $this->db->escape_str($BuyAndSellToken),
				'ViewPrices' 			=> $this->db->escape_str($ViewPrices),
				'ViewOrders' 			=> $this->db->escape_str($ViewOrders),
				'SetMarketParameters' 	=> $this->db->escape_str($SetMarketParameters)
			);
				
			$this->db->insert('userinfo', $dat);
			
			$this->db->trans_complete();
			
			$Msg='';	
			
			if ($this->db->trans_status() === FALSE)
			{					
				$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted creating a user account with email '".$email."' but failed.";
				$ret = 'User Account Creation Was Not Successful.';
			}else
			{
				$activationCode=sha1($email);					
				$activationurl = base_url()."Creg/Asu/".$activationCode;
														
				//Send email to Broker
				$from='support@naijaartmart.com';
				$to=$email;
				$subject='A New Naija Art Mart Account';
				$Cc='idongesit_a@yahoo.com';
								
				$img=base_url()."images/logo.png";
									
				//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
				
				$dec=\mervick\aesEverywhere\AES256::decrypt($pwd,ACCESS_STAMP);
											
				$message = '
					<html>
					<head>
					<meta charset="utf-8">
					<title>Naija Art Mart | New Account</title>
					</head>
					<body>								
														
							Dear User,<br><br>
							
							An account has been created for you on Naija Art Mart platform. Your account access details are:
							<br><br><strong>Access Email:</strong> '.$email.'
							<br><strong>Default Password:</strong> '.$dec.'
							
							<br><br>Please make sure you change the default password to a secured password.
							
							<br><br>For full access to your account on Naija Art Mart platform, you will need to activate your account. To do so, click on the link below or copy and paste it in your browser. Please note that activation is a one time action:
									
							<br><br><a href="'.$activationurl.'">Click Here To Activate Your Naija Art Mart Account<a/>					
							
																																									
							<p>Best Regards</p>
							Naija Art Mart
					</body>
					</html>';
					
				$altmessage = '
					Dear User,
							
					An account has been created for you on Naija Art Mart platform. Your account access details are:
					Access Email: '.$email.'
					Default Password: '.$dec.'
					
					Please make sure you change the default password to your secured password.
					
					For full access to your account on Naija Art Mart platform, you will need to activate your account. To do so, click on the link below or copy and paste it in your browser. Please note that activation is a one time action: '.$activationurl.'
																																				
					Best Regards
					
					Naija Art Mart';
				
				if ($to) $v=$this->getdata_model->SendBlueMail($from,$to,$subject,$Cc,$message,$altmessage,$fullname);
				
				if (strtoupper(trim($v)) <> 'OK')
				{
					$ret = "User Registration Was Not Successful.";
					
					//Remove from userinfo
					$this->db->trans_start();
					$this->db->delete('userinfo', array('email' => $this->db->escape_str($email))); 				
					$this->db->trans_complete();	
					
					$Msg="User Account Creation Was Not Successful.";					
				}else
				{
					$Msg="User Account Was Created Successfully.";					
					$m="CREATED USER'S ACCOUNT";
					$ret ='OK';	
				}				
			}
			
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
			$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'CREATED USER ACCOUNT',$_SESSION['LogIn']);	
		}
				
		echo $ret;
	}
	
	function EditUsers()
	{
		$email=''; $company=''; $fullname=''; $phone=''; $usertype=''; $accountstatus='0';
		
		$AddItem='0';$EditItem='0'; $DeleteItem='0'; $CreateAccount='0'; $ClearLogFiles='0'; $SetParameters='0'; 		$ViewLogReports='0'; $ViewReports='0';
		
		$RequestListing='0'; $PublishWork='0'; $RegisterBroker='0'; $BuyAndSellToken='0';
		$ViewPrices='0'; $ViewOrders='0'; $SetMarketParameters='0';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('company')) $company = trim($this->input->post('company'));
		if ($this->input->post('fullname')) $fullname = trim($this->input->post('fullname'));		
		if ($this->input->post('phone')) $phone = trim($this->input->post('phone'));
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));		
		if ($this->input->post('accountstatus')) $accountstatus = trim($this->input->post('accountstatus'));		
		if ($this->input->post('AddItem')) $AddItem = trim($this->input->post('AddItem'));		
		if ($this->input->post('EditItem')) $EditItem = trim($this->input->post('EditItem'));
		if ($this->input->post('DeleteItem')) $DeleteItem = trim($this->input->post('DeleteItem'));				
		if ($this->input->post('CreateAccount')) $CreateAccount = trim($this->input->post('CreateAccount'));		
		if ($this->input->post('ClearLogFiles')) $ClearLogFiles = trim($this->input->post('ClearLogFiles'));		
		if ($this->input->post('SetParameters')) $SetParameters = trim($this->input->post('SetParameters'));
		if ($this->input->post('ViewLogReports')) $ViewLogReports = trim($this->input->post('ViewLogReports'));		
		if ($this->input->post('ViewReports')) $ViewReports = trim($this->input->post('ViewReports'));		
		if ($this->input->post('RequestListing')) $RequestListing = trim($this->input->post('RequestListing'));		
		if ($this->input->post('PublishWork')) $PublishWork = trim($this->input->post('PublishWork'));
		if ($this->input->post('RegisterBroker')) $RegisterBroker = trim($this->input->post('RegisterBroker'));
		if ($this->input->post('BuyAndSellToken')) $BuyAndSellToken = trim($this->input->post('BuyAndSellToken'));
		if ($this->input->post('ViewPrices')) $ViewPrices = trim($this->input->post('ViewPrices'));
		if ($this->input->post('ViewOrders')) $ViewOrders = trim($this->input->post('ViewOrders'));
		if ($this->input->post('SetMarketParameters')) $SetMarketParameters = trim($this->input->post('SetMarketParameters'));
		
		if (!$accountstatus) $accountstatus='0';
		
		//Check if record exists
		$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";

		$query = $this->db->query($sql);
					
		if ($query->num_rows() == 0 )
		{
			$ret = 'Could Not Edit User Account Record. Record Does Not Exist.';
		}else
		{
			$row = $query->row();	
			
			$fn=''; $em=''; $ph=''; $sta='0'; $ut=''; $cm='';
			$ait='0'; $eit='0'; $dit='0'; $cusr='0'; $clog='0'; $vlog='0'; $vrep='0'; $spar='0';
			
			$rl='0'; $pw='0'; $rb='0'; $bt='0'; $vp='0'; $vo='0'; $smp='0';
			if ($row->fullname) $fn=$row->fullname;
			if ($row->email) $em=$row->email;
			if ($row->phone) $ph=$row->phone;
			if ($row->company) $cm=$row->company;
			if ($row->accountstatus==1) $sta=$row->accountstatus;
			if ($row->usertype) $ut=$row->usertype;				
			if ($row->AddItem==1) $ait=$row->AddItem;				
			if ($row->EditItem==1) $eit=$row->EditItem;								
			if ($row->DeleteItem==1) $dit=$row->DeleteItem;
			if ($row->CreateAccount==1) $cusr=$row->CreateAccount;					
			if ($row->ClearLogFiles==1) $clog=$row->ClearLogFiles;
			if ($row->SetParameters==1) $spar=$row->SetParameters;
			if ($row->ViewLogReports==1) $vlog=$row->ViewLogReports;				
			if ($row->ViewReports==1) $vrep=$row->ViewReports;						
			if ($row->RequestListing==1) $rl=$row->RequestListing;
			if ($row->PublishWork==1) $pw=$row->PublishWork;
			if ($row->RegisterBroker==1) $rb=$row->RegisterBroker;
			if ($row->BuyAndSellToken==1) $bt=$row->BuyAndSellToken;
			if ($row->ViewPrices==1) $vp=$row->ViewPrices;
			if ($row->ViewOrders==1) $vo=$row->ViewOrders;
			if ($row->SetMarketParameters==1) $smp=$row->SetMarketParameters;
		
			$OldValues='Full Name='.$fn.'; Email='.$em.'; Company='.$cm.'; Phone='.$ph.'; Account Status='.$sta.'; User Type='.$ut.'; Add Item='.$ait.'; Edit Item='.$eit.'; Delete Item='.$dit.'; Create Users='.$cusr.'; Clear Log Files='.$clog.'; Set Parameters='.$spar.'; View Log Reports='.$vlog.'; View Reports='.$vrep.'; Request Listing='.$rl."; Publish ArtWork=".$pw."; Register Broker=".$rb."; Buy And Sell Token=".$bt."; View Prices=".$vp."; View Orders=".$vo."; Set Market Parameters=".$smp;
			
			$NewValues='Full Name='.$fullname.'; Email='.$email.'; Company='.$company.'; Phone='.$phone.'; Account Status='.$accountstatus.'; User Type='.$usertype.'; Add Item='.$AddItem.'; Edit Item='.$EditItem.'; Delete Item='.$DeleteItem.'; Create Users='.$CreateAccount.'; Clear Log Files='.$ClearLogFiles.'; Set Parameters='.$SetParameters.'; View Log Reports='.$ViewLogReports.'; View Reports='.$ViewReports.'; Request Listing='.$RequestListing."; Publish ArtWork=".$PublishWork."; Register Broker=".$RegisterBroker."; Buy And Sell Token=".$BuyAndSellToken."; View Prices=".$ViewPrices."; View Orders=".$ViewOrders."; Set Market Parameters=".$SetMarketParameters;
			
			$this->db->trans_start();
									
			$dat=array(
				'fullname' 				=> $this->db->escape_str($fullname),
				'phone' 				=> $this->db->escape_str($phone),
				'company' 				=> $this->db->escape_str($company),
				'accountstatus' 		=> $this->db->escape_str($accountstatus),
				'usertype' 				=> $this->db->escape_str($usertype),				
				'AddItem' 				=> $this->db->escape_str($AddItem),
				'EditItem' 				=> $this->db->escape_str($EditItem),
				'DeleteItem' 			=> $this->db->escape_str($DeleteItem),				
				'CreateAccount' 		=> $this->db->escape_str($CreateAccount),	
				'ClearLogFiles' 		=> $this->db->escape_str($ClearLogFiles),
				'ViewReports' 			=> $this->db->escape_str($ViewReports),
				'ViewLogReports' 		=> $this->db->escape_str($ViewLogReports),				
				'SetParameters' 		=> $this->db->escape_str($SetParameters),				
				'RequestListing' 		=> $this->db->escape_str($RequestListing),
				'PublishWork' 			=> $this->db->escape_str($PublishWork),
				'RegisterBroker' 		=> $this->db->escape_str($RegisterBroker),
				'BuyAndSellToken' 		=> $this->db->escape_str($BuyAndSellToken),
				'ViewPrices' 			=> $this->db->escape_str($ViewPrices),
				'ViewOrders' 			=> $this->db->escape_str($ViewOrders),
				'SetMarketParameters' 	=> $this->db->escape_str($SetMarketParameters)
				);							
			
			$this->db->where('email', $email);
			$this->db->update('userinfo', $dat);
		
			$this->db->trans_complete();
			
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{					
				$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted editing a user account with email '".$email."' but failed.";
				
				$ret = 'User Account Record Could Not Be Edited.';
			}else
			{
				$Msg="User account record has been edited successfully by ".strtoupper($_SESSION['fullname'].'('.$_SESSION['email'])."). Old Values => ".$OldValues.". Updated values => ".$NewValues;				
				
				$ret ='OK';	
			}
			
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
			$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'EDITED USER ACCOUNT',$_SESSION['LogIn']);
		}
				
		echo $ret;
	}
	
	function DeleteUser()
	{
		$email=''; $fullname=''; $company = '';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('fullname')) $fullname = trim($this->input->post('fullname'));
		if ($this->input->post('company')) $company = trim($this->input->post('company'));
	
		//Check if record exists
		$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		$query = $this->db->query($sql);
					
		if ($query->num_rows() > 0 )
		{
			
			$this->db->trans_start();
			$this->db->delete('userinfo', array('email' => $email)); 				
			$this->db->trans_complete();
						
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{
				$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted deleting a user account with email '".$email."' but failed.";
				
				$ret = 'User Account Record Could Not Be Deleted.';
			}else
			{
				$Msg="User account record with email ".strtoupper($email).'('.strtoupper($fullname).") has been deleted successfully by ".strtoupper($_SESSION['fullname'].'('.$_SESSION['email']).").";
				
				$ret="OK";
			}
			
			$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],$_SESSION['LogIn'],$_SESSION['RemoteIP'],$_SESSION['RemoteHost'],'DELETED USER ACCOUNT',$_SESSION['LogID']);
		}else
		{
			$ret="Could Not Delete User Account Record. Record Does Not Exist.";
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
			
			$this->load->view('admin/users_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
