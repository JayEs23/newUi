<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('assets/vendor/autoload.php');

class Trades extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	 }
	 
	public function GetStates()
	{
		$sql="SELECT DISTINCT(state) as state FROM states ORDER BY state";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetStates
	 
	public function GetBrokers()
	{
		$sql = "SELECT * FROM brokers ORDER BY company";											

		$query = $this->db->query(stripslashes($sql));	

		$results = $query->result_array();		

		if ($results)
		{
			$data=array();

			if (is_array($results))
			{
				$sn=0;
				
				foreach($results as $row):
					$sn++; $sel=''; $del=''; $sta='Disabled'; $dt='';
					
					if ($row['incorporationdate'] <> '0000-00-00') $dt=date('d M Y',strtotime($row['incorporationdate']));
					
					if ($row['accountstatus']==1) $sta='Active';
					
					$sel='<img onClick="SelectRow(\''.$row['company'].'\',\''.$row['address'].'\',\''.$row['state'].'\',\''.$row['email'].'\',\''.$row['phone'].'\',\''.$dt.'\',\''.$row['broker_id'].'\',\''.$row['accountstatus'].'\',\''.$row['id'].'\')" style="cursor:pointer; height:30px; " src="'.base_url().'images/pencil_icon.png" title="Edit '.strtoupper(trim($row['company'])).'\'s Record">';

//company,address,state,email,phone,incorporationdate,broker_id,accountstatus,pwd,id
					
										
					if ($_SESSION['DeleteItem']==1)
					{
						$del='<img onClick="DeleteRow(\''.$row['company'].'\',\''.$row['broker_id'].'\',\''.$row['accountstatus'].'\',\''.$row['id'].'\')" style="cursor:pointer; height:30px;" src="'.base_url().'images/delete_icon.png" title="Delete '.strtoupper(trim($row['company'])).'\'s Record">';	
					}
					
					$tp=array($sel,$del,$row['company'],$row['broker_id'],$row['phone'],$row['email'],$sta);
					
					$data[]=$tp;
				endforeach;
			}

			print_r(json_encode($data));
		}else
		{
			print_r(json_encode($results));
		}
	}
	
	public function AddBroker()
	{
		$company=''; $address=''; $state=''; $email=''; $phone=''; $incorporationdate='';
		$broker_id='';  $accountstatus='0'; $pwd=''; $Msg='';
		
		if ($this->input->post('company')) $company = trim($this->input->post('company'));
		if ($this->input->post('address')) $address = trim($this->input->post('address'));
		if ($this->input->post('state')) $state = trim($this->input->post('state'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('phone')) $phone = trim($this->input->post('phone'));
		if ($this->input->post('incorporationdate')) $incorporationdate = trim($this->input->post('incorporationdate'));
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));
		if ($this->input->post('accountstatus')) $accountstatus = trim($this->input->post('accountstatus'));
		if ($this->input->post('pwd')) $pwd = $this->input->post('pwd');
		
		$date_created=date('Y-m-d H:i:s');
								
		//Check if record exists
		$sql = "SELECT * FROM brokers WHERE (TRIM(company)='".$this->db->escape_str($company)."')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 )
		{
			$Msg="Creation of broker's record was NOT successful. Broker name exists in the database.";
			$m = "Creation of broker's record was NOT successful. Broker name exists in the database.";
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			$sql = "SELECT * FROM brokers WHERE (TRIM(broker_id)='".$this->db->escape_str($broker_id)."')";
		
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0 )
			{
				$Msg="Creation of broker's record was NOT successful. Broker's membership code exists in the database.";
				
				$m = "Creation of broker's record was NOT successful. Broker's membership code exists in the database.";
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{
				$this->db->trans_start();
				
				$dat=array(
					'company' 			=> $this->db->escape_str($company),
					'address' 			=> $this->db->escape_str($address),
					'state' 			=> $this->db->escape_str($state),
					'email' 			=> $this->db->escape_str($email),
					'phone' 			=> $this->db->escape_str($phone),
					'incorporationdate'	=> $this->db->escape_str($incorporationdate),
					'broker_id' 		=> $this->db->escape_str($broker_id),
					'pwd' 				=> $this->db->escape_str($pwd),
					'date_created' 		=> $this->db->escape_str($date_created),
					'accountstatus' 	=> '0'				
					);
				
				$this->db->insert('brokers', $dat);
				
				$this->db->trans_complete();	
				
				if ($this->db->trans_status() === FALSE)
				{					
					$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted creating broker's record but failed.";
					$m = "Broker's Record Was Not Created.";
					$ret=array('status'=>'FAIL','Message'=>$m);					
				}else
				{
					//Create access account
					$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
					$query = $this->db->query($sql);
								
					if ($query->num_rows() == 0 )
					{
						$this->db->trans_start();
				
						$dat=array(
							'email' 				=> $this->db->escape_str($email),
							'fullname' 				=> $this->db->escape_str($company),
							'company' 				=> $this->db->escape_str($company),
							'phone' 				=> $this->db->escape_str($phone),
							'pwd' 					=> $this->db->escape_str($pwd),
							'usertype' 				=> 'Broker',				
							'accountstatus' 		=> '0',
							'datecreated' 			=> $this->db->escape_str($date_created),				
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
							'BuyAndSellToken' 		=> 1,
							'ViewPrices' 			=> 1,
							'ViewOrders' 			=> 1,
							'SetMarketParameters' 	=> '0'
						);
							
						$this->db->insert('userinfo', $dat);
						
						$this->db->trans_complete();
						
						$activationCode=sha1($email);
					
						$activationurl = base_url()."Creg/Cf/".$activationCode;
																
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
																
									Dear Broker,<br><br>
									
									An account has been created for you on Naija Art Mart platform. Your account details are:
									<br><br><strong>Access Email:</strong> '.$email.'
									<br><strong>Default Password:</strong> '.$dec.'
									
									<br><br>Please make sure you change the default password to your secured password.
									<br><br>Also, after activating this account as directed below, sign in and update your profile by supplying your bank account details. Please note that you will not be able to trade on the Naija Art Mart platform if your bank account details are not updated in your profile.
									
									<br><br>For full access to your account on Naija Art Mart platform, you will need to activate your account. To do so, click on the link below or copy and paste it in your browser. Please note that activation is a one time action:
											
									<br><br><a href="'.$activationurl.'">Click Here To Activate Your Naija Art Mart Account<a/>					
									
																																											
									<p>Best Regards</p>
									Naija Art Mart
							</body>
							</html>';
							
						$altmessage = '
							Dear Broker,
									
							An account has been created for you on Naija Art Mart platform. Your account details are:
							Access Email: '.$email.'
							Default Password: '.$dec.'
							
							Please make sure you change the default password to your secured password.
							
							Also, after activating this account as directed below, sign in and update your profile by supplying your bank account details. Please note that you will not be able to trade on the Naija Art Mart platform if your bank account details are not updated in your profile.
							
							For full access to your account on Naija Art Mart platform, you will need to activate your account. To do so, click on the link below or copy and paste it in your browser. Please note that activation is a one time action: '.$activationurl.'
																																						
							Best Regards
							
							Naija Art Mart';
						
						if ($to) $v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$company);
						
						if (strtoupper(trim($v)) <> 'OK')
						{
							$rows =array(
								'status' => "Registration was Not successful.<br><br><b>".$ret.'<br>',
								'Flag'=>'FAIL',
								'email' => $email
								);
							
							#Delete Entry From brokers Table
							$this->db->trans_start();
							$this->db->delete('brokers', array('email' => $this->db->escape_str($email))); 				
							$this->db->trans_complete();
							
							//Remove from userinfo
							$this->db->trans_start();
							$this->db->delete('userinfo', array('email' => $this->db->escape_str($email))); 				
							$this->db->trans_complete();					
						}else
						{
							$Msg="Broker Account Was Created Successfully.";				
							
							$ret=array('status'=>'OK','Message'=>'');
							
							$m="CREATED BROKER'S ACCOUNT";	
						}						
					}else
					{
						#Delete Entry From brokers Table
						$this->db->trans_start();
						$this->db->delete('brokers', array('email' => $this->db->escape_str($email))); 				
						$this->db->trans_complete();
						
						$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted creating broker's record but failed. Email ".$email." exists in the our system.";
						
						$m = "Creation of broker's record was NOT successful. Email <b>".$email."</b> exists in the our system.";
						$ret=array('status'=>'FAIL','Message'=>$m);
					}
				}				
			}				
		}
		
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
		$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,$m,$_SESSION['LogID']);
		
		echo json_encode($ret);
	}
	
	public function EditBroker()
	{
		$company=''; $address=''; $state=''; $email=''; $phone=''; $incorporationdate='';
		$broker_id='';  $accountstatus='0'; $Id = '';
		
		if ($this->input->post('company')) $company = trim($this->input->post('company'));
		if ($this->input->post('address')) $address = trim($this->input->post('address'));
		if ($this->input->post('state')) $state = trim($this->input->post('state'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('phone')) $phone = trim($this->input->post('phone'));
		if ($this->input->post('incorporationdate')) $incorporationdate = trim($this->input->post('incorporationdate'));
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));
		if ($this->input->post('accountstatus')) $accountstatus = trim($this->input->post('accountstatus'));
		if ($this->input->post('id')) $Id = trim($this->input->post('id'));
		
		
		//Check if record exists		
		$sql = "SELECT * FROM brokers WHERE (id=".$this->db->escape_str($Id).")";

		$query = $this->db->query($sql);
					
		if ($query->num_rows() == 0 )
		{
			$m = "Could Not Edit Broker's Record. Record ID Does Not Exist.";
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			$cm=''; $add=''; $st=''; $em=''; $ph=''; $dt=''; $bid=''; $des=''; $sta='0'; $pwd='';
		
			$row = $query->row();			
			
			if ($row->company) $cm=trim($row->company);
			if ($row->address) $add=trim($row->address);
			if ($row->state) $st=trim($row->state);
			if ($row->email) $em=trim($row->email);
			if ($row->phone) $ph=trim($row->phone);
			if ($row->incorporationdate) $dt=trim($row->incorporationdate);
			if ($row->broker_id) $bid=trim($row->broker_id);
			if ($row->pwd) $pwd=trim($row->pwd);
			if ($row->accountstatus == 1) $sta=1;
						
			$OldValues="Company Name = ".$cm."; Address = ".$add."; State = ".$st."; Email = ".$em."; Phone = ".$ph."; Date Of Incorporation = ".$dt."; Broker Id = ".$bid."; Broker Account Status = ".$sta;			
			
			$NewValues="Company Name = ".$company."; Address = ".$address."; State = ".$state."; Email = ".$email."; Phone = ".$phone."; Date Of Incorporation = ".$incorporationdate."; Broker Id = ".$broker_id."; Broker Account Status = ".$accountstatus;
			
			$dat=array(
				'company' 			=> $this->db->escape_str($company),
				'address' 			=> $this->db->escape_str($address),
				'state' 			=> $this->db->escape_str($state),
				'email' 			=> $this->db->escape_str($email),
				'phone' 			=> $this->db->escape_str($phone),
				'incorporationdate'	=> $this->db->escape_str($incorporationdate),
				'broker_id' 		=> $this->db->escape_str($broker_id),
				'accountstatus' 	=> $this->db->escape_str($accountstatus)
			);
			
			#Edit
			$this->db->trans_start();
			$this->db->where(array('id' => $Id));
			$this->db->update('brokers', $dat);			
			$this->db->trans_complete();
						
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{					
				$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted editing broker's record but failed.";
				
				$m = "Broker's Record Could Not Be Edited.";
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{
				//Update access acount
				$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
				$query = $this->db->query($sql);
							
				if ($query->num_rows() == 0 )
				{
					$this->db->trans_start();
			
					$dat=array(
						'email' 				=> $this->db->escape_str($email),
						'fullname' 				=> $this->db->escape_str($company),
						'phone' 				=> $this->db->escape_str($phone),
						'company' 				=> $this->db->escape_str($company),
						'pwd' 					=> $this->db->escape_str($pwd),
						'usertype' 				=> 'Broker',				
						'accountstatus' 		=> $this->db->escape_str($accountstatus),
						'datecreated' 			=> date('Y-m-d H:i:s'),				
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
						'BuyAndSellToken' 		=> 1,
						'ViewPrices' 			=> 1,
						'ViewOrders' 			=> 1,
						'SetMarketParameters' 	=> '0'
					);
						
					$this->db->insert('userinfo', $dat);
					
					$this->db->trans_complete();
				}else
				{
					$this->db->trans_start();
								
					$dat=array(
						'fullname' 				=> $this->db->escape_str($fullname),
						'phone' 				=> $this->db->escape_str($phone),
						'company' 				=> $this->db->escape_str($company),
						'accountstatus' 		=> $this->db->escape_str($accountstatus),
						'pwd' 					=> $this->db->escape_str($pwd),
						'usertype' 				=> 'Broker',				
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
						'BuyAndSellToken' 		=> 1,
						'ViewPrices' 			=> 1,
						'ViewOrders' 			=> 1,
						'SetMarketParameters' 	=> '0'
						);							
					
					$this->db->where('email', $email);
					$this->db->update('userinfo', $dat);
				
					$this->db->trans_complete();
				}
				
				$Msg="Broker's account has been edited successfully by ".strtoupper($_SESSION['fullname'].'('.$_SESSION['email'])."). Old Values => ".$OldValues.". Updated values => ".$NewValues;				
				
				$ret=array('status'=>'OK','Message'=>'');
								
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,"EDITED BROKER'S ACCOUNT",$_SESSION['LogID']);
			}			
		}
				
		echo json_encode($ret);
	}
	
	public function DeleteBroker()
	{
		$company=''; $broker_id=''; $id=''; $email='';
		
		if ($this->input->post('id')) $id = trim($this->input->post('id'));
		if ($this->input->post('company')) $company = trim($this->input->post('company'));
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));
		
		//Check if record exists		
		$sql = "SELECT * FROM brokers WHERE (id=".$this->db->escape_str($id).")";
		
		$query = $this->db->query($sql);
					
		if ($query->num_rows() > 0 )
		{
			$row = $query->row();
			
			if ($row->email) $email=trim($row->email);
			
			$this->db->trans_start();
			$this->db->delete('brokers', array('id' => $id)); 				
			$this->db->trans_complete();
			
			$sql = "SELECT * FROM brokers";		
			$qry = $this->db->query($sql);			
			$rowcount=$qry->num_rows();		
						
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{
				$Msg=$_SESSION['email'].'('.$_SESSION['fullname'].") attempted deleting broker's record but failed.";
				
				$ret=array('status'=>'FAIL','Message'=>"Broker's Record Could Not Be Deleted.",'rowcount'=>$rowcount);
			}else
			{
				//Update access account
				$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
				$query = $this->db->query($sql);
							
				if ($query->num_rows() > 0 )
				{
					$this->db->trans_start();
					$this->db->delete('messages', array('email' => $email)); 				
					$this->db->trans_complete();
				}
				
				
				$Msg="Broker's record has been deleted successfully by ".strtoupper($_SESSION['email'].'('.$_SESSION['fullname']).").";
				
				$ret=array('status'=>'OK','Message'=>'','rowcount'=>$rowcount);
				
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],$_SESSION['LogIn'],$_SESSION['RemoteIP'],$_SESSION['RemoteHost'],"DELETED BROKER'S RECORD",$_SESSION['LogID']);
			}
		}else
		{
			$ret=array('status'=>'FAIL','Message'=>"Could Not Delete Broker's Record. Record Does Not Exist.",'rowcount'=>0);
		}
		
		echo json_encode($ret);
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
			
			$this->load->view('admin/trades_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
