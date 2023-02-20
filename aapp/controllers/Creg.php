<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Creg extends CI_Controller {	
	private $reg_success=false;
	private $user='',$usermessage='';
	
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	 }
	
	function Asu()//Backend users/Gallery staff
	{
		$activationCode =  $this->uri->segment(3);
		
		#Check for the code in the db
		$sql = "SELECT * FROM userinfo WHERE (sha1(TRIM(email))='".$this->db->escape_str($activationCode)."')";
		
		$query = $this->db->query($sql);
			
		$nm=''; $em=''; $sta='0';
		
		if ($query->num_rows() > 0 )
		{
			$row = $query->row();
					
			if ($row->company) $nm=$row->company;			
			if ($row->email) $em=$row->email;
			if ($row->accountstatus==1) $sta=$row->accountstatus;
			
			$this->user=$nm;
			
			if ($sta <> 1)
			{
				$this->db->trans_start();
	
				$dat=array('accountstatus' => 1);														
				$this->db->where('sha1(email)', $activationCode);				
				$this->db->update('userinfo', $dat);
				
				$this->db->trans_complete();
				
				$Msg='';
	
				if ($this->db->trans_status() === FALSE)
				{					
					$Msg=$nm." attempted activating the user account with email ".$em." but failed.";
					
					$this->usermessage = "Account activation was not successful. Please try again. If this persists, contact our support team at support@naijaartmart.com.";
				}else
				{
					$Msg=$nm." activated user account with email ".$em." successfully.";
										
					$this->usermessage = '<strong>Congratulations dear user!</strong> You have successfully activated your Naija Art Mart account. Please remember to change your default password to a more secured one. Click <a href="'.site_url("admin/Signin").'">SIGN IN</a> to go to the sign in page.';
					
					$this->reg_success=true;
				}	
			}else
			{
				$Msg=$nm." attempted activating an already activated account with email ".$em." but failed.";
				
				$this->usermessage = "Account activation was not successful. This account has already been activated. You can click <a href='".site_url("ui/Home")."'>HERE</a> to go to home page.";
			}
		}else
		{
			$Msg=$fn." attempted activating the user account with email ".$em." but failed. Registration record not found.";
						
			$this->usermessage = "Account activation was not successful. Registration record was not found. Please try registering afresh. If this persists, contact our support team at support@naijaartmart.com.";
		}
		
		$op='ACTIVATED USER ACCOUNT';
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		$this->getdata_model->LogDetails($nm,$Msg,$em,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'ACTIVATED USER ACCOUNT',$activationCode);
		
		$this->index();
	}#End Of Asu functions
	
	function Cf()//Brokers
	{
		$activationCode =  $this->uri->segment(3);
		
		#Check for the code in the db
		$sql = "SELECT * FROM brokers WHERE (sha1(TRIM(email))='".$this->db->escape_str($activationCode)."')";
		
		$query = $this->db->query($sql);
			
		$nm=''; $em=''; $sta='0';
		
		if ($query->num_rows() > 0 )
		{
			$row = $query->row();
					
			if ($row->company) $nm=$row->company;			
			if ($row->email) $em=$row->email;
			if ($row->accountstatus==1) $sta=$row->accountstatus;
			
			$this->user=$nm;
			
			if ($sta <> 1)
			{
				$this->db->trans_start();
	
				$dat=array('accountstatus' => 1);														
				$this->db->where('sha1(email)', $activationCode);				
				$this->db->update('brokers', $dat);
				
				$this->db->trans_complete();
				
				//User Info
				$this->db->trans_start();
	
				$dat=array('accountstatus' => 1);														
				$this->db->where('sha1(email)', $activationCode);				
				$this->db->update('userinfo', $dat);
				
				$this->db->trans_complete();
							
				$Msg='';
	
				if ($this->db->trans_status() === FALSE)
				{					
					$Msg=$nm." attempted activating the broker account with email ".$em." but failed.";
					
					$this->usermessage = "Account activation was not successful. Please try again. If this persists, contact our support team at support@naijaartmart.com.";
				}else
				{
					$Msg=$nm." activated broker account with email ".$em." successfully.";
										
					$this->usermessage = '<strong>Congratulations dear broker!</strong> You have successfully activated your Naija Art Mart account. Please remember to change your default password to a more secured one, and also update your profile by supplying your trading bank account details. Click <a href="'.site_url("ui/Login").'">SIGN IN</a> to go to the sign in page.';
					
					$this->reg_success=true;
				}	
			}else
			{
				$Msg=$nm." attempted activating an already activated account with email ".$em." but failed.";
				
				$this->usermessage = "Account activation was not successful. This account has already been activated. You can click <a href='".site_url("ui/Home")."'>HERE</a> to go to home page.";
			}
		}else
		{
			$Msg=$fn." attempted activating the broker account with email ".$em." but failed. Registration record not found.";
						
			$this->usermessage = "Account activation was not successful. Registration record was not found. Please try registering afresh. If this persists, contact our support team at support@naijaartmart.com.";
		}
		
		$op='ACTIVATED BROKER ACCOUNT';
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		$this->getdata_model->LogDetails($nm,$Msg,$em,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'ACTIVATED BROKER ACCOUNT',$activationCode);
		
		$this->index();
	}#End Of Cf functions
	
	public function Icf()//Investors
	{
		$activationCode =  $this->uri->segment(3);
		
		#Check for the code in the db
		$sql = "SELECT * FROM investors WHERE (sha1(TRIM(email))='".$this->db->escape_str($activationCode)."')";
		
		$query = $this->db->query($sql);
			
		$em=''; $tb='0'; $usertype=''; $fn=''; $exp='';  $ph=''; $pwd=''; $dt=''; $op=''; $Msg=''; $badd='';
			
		if ($query->num_rows() > 0 )
		{
			$rw = $query->row();
			if ($rw->blockchain_address) $badd=trim($rw->blockchain_address);			
			
			$sql="SELECT * FROM temp_users WHERE (sha1(TRIM(email))='".$this->db->escape_str($activationCode)."')";
			$qry = $this->db->query($sql);

			if ($qry->num_rows() > 0 )
			{
				$row = $qry->row();
				
				if ($row->email) $em = trim($row->email);
				if ($row->fullname) $fn = trim($row->fullname);
				if ($row->usertype) $usertype = trim($row->usertype);
				if ($row->phone) $ph = trim($row->phone);				
				if ($row->pwd) $pwd = trim($row->pwd);
				if ($row->date_created) $dt=$row->date_created;				
				if ($row->expire) $exp = trim($row->expire);				
				if ($row->tables) $tb = trim($row->tables);

				//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($usertype,true)); fclose($file);					
				
				$this->user=$fn;
					
				//Update investors
				$this->db->trans_start();		
				$dat=array('accountstatus' => 1);														
				$this->db->where('email', $em);				
				$this->db->update('investors', $dat);				
				$this->db->trans_complete();
				
				//Update blockchain address
				if (trim($badd) == '')
				{				
					$user = $this->getdata_model->CreateUserRecordOnBlockchain($em,$ph,$fn,'Investor');
					// echo $badd; echo "<br/><pre>";
					// print_r($user); die();
					if ($user['status']==1)
					{
						$blockchain_address=$user['blockchainAddress'];
						
						$dat=array(
							'blockchain_address' => $this->db->escape_str($blockchain_address),
							'userId' => $this->db->escape_str($user['userId']),
						);
	
						$this->db->trans_start();
						$this->db->where('email', $em);
						$this->db->update('investors', $dat);			
						$this->db->trans_complete();
					}
				}
				//Create access account
				$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($em)."')";
				$query = $this->db->query($sql);
							
				if ($query->num_rows() == 0 )
				{
					$this->db->trans_start();
			
					$dat=array(
						'email' 				=> $this->db->escape_str($em),
						'fullname' 				=> $this->db->escape_str($fn),
						'company' 				=> $this->db->escape_str($fn),
						'phone' 				=> $this->db->escape_str($ph),
						'pwd' 					=> $this->db->escape_str($pwd),
						'usertype' 				=> 'Investor',				
						'accountstatus' 		=> '1',
						'datecreated' 			=> $this->db->escape_str($dt),				
						'AddItem' 				=> '0',
						'EditItem' 				=> '0',
						'DeleteItem' 			=> '0',				
						'CreateAccount' 		=> '0',	
						'ClearLogFiles' 		=> '0',
						'ViewReports' 			=> 1,
						'ViewLogReports' 		=> '0',				
						'SetParameters' 		=> '0',				
						'RequestListing' 		=> '0',
						'PublishWork' 			=> '0',
						'RegisterBroker' 		=> '0',
						'BuyAndSellToken' 		=> '0',
						'ViewPrices' 			=> 1,
						'ViewOrders' 			=> 1,
						'SetMarketParameters' 	=> '0'
					);
						
					$this->db->insert('userinfo', $dat);
					
					$this->db->trans_complete();
				}else
				{
					$this->db->trans_start();
								
					$dat=array('accountstatus' => '1');						
					$this->db->where('email', $em);
					$this->db->update('userinfo', $dat);					
					$this->db->trans_complete();
				}
										
				$Msg=$fn." activated investor account with email ".$em." successfully.";
									
				$this->usermessage = '<strong>Congratulations dear investor!</strong> You have successfully activated your Naija Art Mart account. Please remember to update your profile by supplying your trading bank account and other details. Click <a href="'.site_url("ui/Login").'">SIGN IN</a> to go to the sign in page.';
				$op='ACTIVATED INVESTOR ACCOUNT';
				
				/*if (strtolower($usertype) == 'investor/issuer')
				{
					$this->db->trans_start();		
					$dat=array('accountstatus' => 1);														
					$this->db->where('email', $em);				
					$this->db->update('issuers', $dat);
					$this->db->trans_complete();
					
					//Create access account
					$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($em)."')";
					$query = $this->db->query($sql);
								
					if ($query->num_rows() == 0 )
					{
						$this->db->trans_start();
				
						$dat=array(
							'email' 				=> $this->db->escape_str($em),
							'fullname' 				=> $this->db->escape_str($fn),
							'company' 				=> $this->db->escape_str($fn),
							'phone' 				=> $this->db->escape_str($ph),
							'pwd' 					=> $this->db->escape_str($pwd),
							'usertype' 				=> 'Investor/Issuer',				
							'accountstatus' 		=> '1',
							'datecreated' 			=> $this->db->escape_str($dt),				
							'AddItem' 				=> '0',
							'EditItem' 				=> '0',
							'DeleteItem' 			=> '0',				
							'CreateAccount' 		=> '0',	
							'ClearLogFiles' 		=> '0',
							'ViewReports' 			=> 1,
							'ViewLogReports' 		=> '0',				
							'SetParameters' 		=> '0',				
							'RequestListing' 		=> 1,
							'PublishWork' 			=> '0',
							'RegisterBroker' 		=> '0',
							'BuyAndSellToken' 		=> '0',
							'ViewPrices' 			=> 1,
							'ViewOrders' 			=> 1,
							'SetMarketParameters' 	=> '0'
						);
							
						$this->db->insert('userinfo', $dat);
						
						$this->db->trans_complete();
					}else
					{
						$this->db->trans_start();
									
						$dat=array('accountstatus' => 1,'RequestListing'=>1,'usertype'=>'Investor/Issuer');						
						$this->db->where('email', $em);
						$this->db->update('userinfo', $dat);					
						$this->db->trans_complete();
					}
					
					$Msg=$fn." activated investor/issuer account with email ".$em." successfully.";
											
					$this->usermessage = '<strong>Congratulations dear investor/issuer!</strong> You have successfully activated your Naija Art Mart account. Please remember to update your profile by supplying your trading bank account and other details. Click <a href="'.site_url("ui/Login").'">SIGN IN</a> to go to the sign in page.';	
					
					$op='ACTIVATED INVESTOR/ISSUER ACCOUNT';	
				}*/				
				
				$this->reg_success=true;
				
				//Delete temp_users entry
				$this->db->trans_start();									
				$this->db->where('email', $em);
				$this->db->delete('temp_users');					
				$this->db->trans_complete();
			}else
			{
				$op='ACTIVATED INVESTOR ACCOUNT';
				$Msg=$fn." attempted activating the investor account with email ".$em." but failed.";
						
				$this->usermessage = "Account activation was not successful. Please try again. If this persists, contact our support team at support@naijaartmart.com.";
			}
		}else
		{
			$op='ACTIVATED INVESTOR ACCOUNT';
			$Msg=$fn." attempted activating the investor account with email ".$em." but failed. Registration record not found.";
						
			$this->usermessage = "Account activation was not successful. Registration record was not found. Please try registering afresh. If this persists, contact our support team at support@naijaartmart.com.";
		}
		
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
		$this->getdata_model->LogDetails($fn,$Msg,$em,date('Y-m-d H:i:s'),$remote_ip,$remote_host,$op,$activationCode);
		
		$this->index();
	}#End Of Icf 
	
	public function Isf()//Issuers
	{
		$activationCode =  $this->uri->segment(3);
		
		#Check for the code in the db
		$sql = "SELECT * FROM issuers WHERE (sha1(TRIM(email))='".$this->db->escape_str($activationCode)."')";
		
		$query = $this->db->query($sql);
			
		$em=''; $tb='0'; $fn=''; $exp='';  $ph=''; $pwd=''; $dt=''; $op=''; $badd='';
		
		if ($query->num_rows() > 0 )
		{
			$rw = $query->row();
			if ($rw->blockchain_address) $badd=trim($rw->blockchain_address);
			
			$sql="SELECT * FROM temp_users WHERE (sha1(TRIM(email))='".$this->db->escape_str($activationCode)."')";
			$qry = $this->db->query($sql);
			
			if ($qry->num_rows() > 0 )
			{
				$row = $qry->row();

				if ($row->email) $em = trim($row->email);
				if ($row->fullname) $fn = trim($row->fullname);
				if ($row->phone) $ph = trim($row->phone);				
				if ($row->pwd) $pwd = trim($row->pwd);
				if ($row->date_created) $dt=$row->date_created;				
				if ($row->expire) $exp = trim($row->expire);				
				if ($row->tables) $tb = trim($row->tables);				
				
				$this->user=$fn;
				
				$this->db->trans_start();		
				$dat=array('accountstatus' => 1);														
				$this->db->where('email', $em);				
				$this->db->update('issuers', $dat);
				
				$this->db->trans_complete();
							
				$Msg='';
	
				if ($this->db->trans_status() === FALSE)
				{					
					$Msg=$fn." attempted activating the issuer account with email ".$em." but failed.";
					
					$this->usermessage = "Account activation was not successful. Please try again. If this persists, contact our support team at support@naijaartmart.com.";
				}else
				{
					//Update blockchain address
					if (trim($badd) == '')
					{				
						$user = $this->getdata_model->CreateUserRecordOnBlockchain($em,$ph,$fn,'Issuer');
						
						if ($user['status']==1)
						{
							$blockchain_address=$user['blockchainAddress'];
							
							$dat=array(
								'blockchain_address' => $this->db->escape_str($blockchain_address),
								'userId' => $this->db->escape_str($user['userId']),
							);
		
							$this->db->trans_start();
							$this->db->where('email', $em);
							$this->db->update('issuers', $dat);			
							$this->db->trans_complete();
						}
					}
					
					//Create access account
					$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($em)."')";
					$query = $this->db->query($sql);
								
					if ($query->num_rows() == 0 )
					{
						$this->db->trans_start();
				
						$dat=array(
							'email' 				=> $this->db->escape_str($em),
							'fullname' 				=> $this->db->escape_str($fn),
							'company' 				=> $this->db->escape_str($fn),
							'phone' 				=> $this->db->escape_str($ph),
							'pwd' 					=> $this->db->escape_str($pwd),
							'usertype' 				=> 'Issuer',				
							'accountstatus' 		=> '1',
							'datecreated' 			=> $this->db->escape_str($dt),				
							'AddItem' 				=> '0',
							'EditItem' 				=> '0',
							'DeleteItem' 			=> '0',				
							'CreateAccount' 		=> '0',	
							'ClearLogFiles' 		=> '0',
							'ViewReports' 			=> 1,
							'ViewLogReports' 		=> '0',				
							'SetParameters' 		=> '0',				
							'RequestListing' 		=> 1,
							'PublishWork' 			=> '0',
							'RegisterBroker' 		=> '0',
							'BuyAndSellToken' 		=> '0',
							'ViewPrices' 			=> 1,
							'ViewOrders' 			=> 1,
							'SetMarketParameters' 	=> '0'
						);
							
						$this->db->insert('userinfo', $dat);
						
						$this->db->trans_complete();
					}else
					{
						$this->db->trans_start();
									
						$dat=array('accountstatus' => '1');						
						$this->db->where('email', $em);
						$this->db->update('userinfo', $dat);					
						$this->db->trans_complete();
					}
					
					$Msg=$fn." activated issuer account with email ".$em." successfully.";
										
					$this->usermessage = '<strong>Congratulations dear issuer!</strong> You have successfully activated your Naija Art Mart account. Please remember to update your profile by supplying your trading bank account and other details. Click <a href="'.site_url("ui/Login").'">SIGN IN</a> to go to the sign in page.';
										
					$this->reg_success=true;
					
					//Delete temp_users entry
					$this->db->trans_start();									
					$this->db->where('email', $em);
					$this->db->delete('temp_users');					
					$this->db->trans_complete();
				}								
			}else
			{
				$Msg=$fn." attempted activating the issuer account with email ".$em." but failed.";
						
				$this->usermessage = "Account activation was not successful. Please try again. If this persists, contact our support team at support@naijaartmart.com.";
			}
		}else
		{
			$Msg=$fn." attempted activating the issuer account with email ".$em." but failed. Registration record not found.";
						
			$this->usermessage = "Account activation was not successful. Registration record was not found. Please try registering afresh. If this persists, contact our support team at support@naijaartmart.com.";
		}
		
		$op='ACTIVATED ISSUER ACCOUNT';
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
		$this->getdata_model->LogDetails($fn,$Msg,$em,date('Y-m-d H:i:s'),$remote_ip,$remote_host,$op,$activationCode);
			
		$this->index();
	}#End Of Icf 
			
	public function index()
	{		
		$this->getdata_model->KillSleepingConnections();
				
		if ($this->reg_success==true)
		{
			$data['RegisterInfo']=$this->usermessage;
			
			$this->load->view('ui/regsuccess_view',$data);#Success Page
		}else
		{
			$data['RegisterInfo']=$this->usermessage;
			
			$this->load->view('ui/regfail_view',$data);#Fail Page
		}	
	}
}
