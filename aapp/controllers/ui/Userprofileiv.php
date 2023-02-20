<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Userprofileiv extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	
	public function GetBrokers()
	{
		$sql="SELECT DISTINCT broker_id,company FROM brokers ORDER BY company";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetBrokers functions
	
	public function GetStates()
	{
		$sql="SELECT DISTINCT(state) as state FROM states ORDER BY state";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetStates functions
	
	public function GetCountries()
	{
		$sql="SELECT DISTINCT(country) as country FROM countries ORDER BY country";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetCountries functions
	
	public function UpdateProfile()
	{
		$usertype=''; $company=''; $email=''; $phone=''; $broker_id=''; $address=''; $state=''; $dob = '';
		$nationality=''; $account_name=''; $account_number=''; $bank_code='';
		$currency='NGN'; $recipient_code=''; $bank_account_status='0';
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		if ($this->input->post('company')) $company = trim($this->input->post('company'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));		
		if ($this->input->post('phone')) $phone = trim($this->input->post('phone'));					
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));		
		if ($this->input->post('address')) $address = trim($this->input->post('address'));					
		if ($this->input->post('state')) $state = trim($this->input->post('state'));		
		if ($this->input->post('dob')) $dob = trim($this->input->post('dob'));
		if ($this->input->post('nationality')) $nationality = trim($this->input->post('nationality'));		
		if ($this->input->post('account_name')) $account_name = trim($this->input->post('account_name'));		
		if ($this->input->post('account_number')) $account_number = trim($this->input->post('account_number'));			
		if ($this->input->post('bank_code')) $bank_code = trim($this->input->post('bank_code'));	
		
		//Check if record exists
		if (strtolower($usertype) == 'issuer')
		{
			$sql = "SELECT * FROM issuers WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		}elseif (strtolower($usertype) == 'investor') //or (strtolower($usertype) == 'investor/issuer'))
		{
			$sql = "SELECT * FROM investors WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		}
		
		$query = $this->db->query($sql);
					
		if ($query->num_rows() == 0 )
		{
			$ret='User record with email "'.$email.'" does not exist in our database.';
		}else
		{
			$uid=''; $cm=''; $add=''; $st=''; $em=''; $ph=''; $cn=''; $dt=''; $pwd=''; $sta='0'; $acnm='';
			$acno=''; $bnk=''; $bnm=''; $rc=''; $bsta='0'; $bid=''; $op=''; $Msg=''; $badd='';
						
			$row = $query->row();
			
			if ($row->uid) $uid=trim($row->uid);
			if ($row->user_name) $cm=trim($row->user_name);
			if ($row->address) $add=trim($row->address);
			if ($row->state) $st=trim($row->state);
			if ($row->email) $em=trim($row->email);
			if ($row->phone) $ph=trim($row->phone);
			if ($row->nationality) $cn=trim($row->nationality);
			if ($row->dob) $dt=trim($row->dob);			
			if ($row->pwd) $pwd=trim($row->pwd);
			if ($row->accountstatus == 1) $sta=1;			
			if ($row->account_name) $acnm=trim($row->account_name);
			if ($row->account_number) $acno=trim($row->account_number);
			if ($row->bank_code) $bnk=trim($row->bank_code);
			if ($row->bankname) $bnm=trim($row->bankname);
			if ($row->recipient_code) $rc=trim($row->recipient_code);
			if ($row->bank_account_status==1) $bsta=trim($row->bank_account_status);
			if ($row->blockchain_address) $badd=trim($row->blockchain_address);

			if (strtolower($usertype) == 'investor') //or (strtolower($usertype) == 'investor/issuer'))
			{
				//if ($row->broker_id) $bid=trim($row->broker_id);
			}
			
			if ((trim(strtolower($bnk)) <> trim(strtolower($bank_code))) or (trim(strtolower($acno)) <> trim(strtolower($account_number)))  or (trim(strtolower($rc))==''))
			{
				$TRec=$this->getdata_model->CreatePaystackTransferRecipient($account_name,$account_number, $account_name,$bank_code,$currency);
		
				if ($TRec['Status'] === true)
				{
					$bankname = $TRec['BankName'];
					$recipient_code = $TRec['RecipientCode'];
					$bank_account_status = $TRec['BankAccountStatus'];					
				}
			}else
			{
				$bankname = $bnm;
				$recipient_code = $rc;
				$bank_account_status = $bsta;
			}			
			
			if (strtolower($usertype) == 'issuer')
			{
				$OldValues="Issuer Id ' ".$uid."; Issuer Name = ".$cm."; Address = ".$add."; State Of Location = ".$st."; Email = ".$em."; Phone = ".$ph."; Date Of Birth Or Incorporation (Company) = ".$dt."; Nationality = ".$cn."; Account Status = ".$sta."; Bank Account Name = ".$acnm."; Account Number = ".$acno."; Bank Name = ".$bnm."; Bank Code = ".$bnk."; Recipient Code = ".$rc."; Bank Account Status = ".$bsta;			
				
				$NewValues="Issuer Id ' ".$uid."; Issuer Name = ".$company."; Address = ".$address."; State Of Location = ".$state."; Email = ".$email."; Phone = ".$phone."; Date Of Birth Or Incorporation (Company) = ".$dob."; Nationality = ".$nationality."; Account Status = ".$sta."; Bank Account Name = ".$account_name."; Account Number = ".$account_number."; Bank Name = ".$bankname."; Bank Code = ".$bank_code."; Recipient Code = ".$recipient_code."; Bank Account Status = ".$bank_account_status;	
			}elseif (strtolower($usertype) == 'investor')
			{
				$OldValues="Investor Id ' ".$uid."; Investor Name = ".$cm."; Address = ".$add."; State Of Location = ".$st."; Email = ".$em."; Phone = ".$ph."; Date Of Birth Or Incorporation (Company) = ".$dt."; Nationality = ".$cn."; Broker Id = ".$bid."; Account Status = ".$sta."; Bank Account Name = ".$acnm."; Account Number = ".$acno."; Bank Name = ".$bnm."; Bank Code = ".$bnk."; Recipient Code = ".$rc."; Bank Account Status = ".$bsta;			
				
				$NewValues="Investor Id ' ".$uid."; Investor Name = ".$company."; Address = ".$address."; State Of Location = ".$state."; Email = ".$email."; Phone = ".$phone."; Date Of Birth Or Incorporation (Company) = ".$dob."; Nationality = ".$nationality."; Broker Id = ".$broker_id."; Account Status = ".$sta."; Bank Account Name = ".$account_name."; Account Number = ".$account_number."; Bank Name = ".$bankname."; Bank Code = ".$bank_code."; Recipient Code = ".$recipient_code."; Bank Account Status = ".$bank_account_status;
			}/*elseif (strtolower($usertype) == 'investor/issuer')
			{
				$OldValues="Investor/Issuer Id ' ".$uid."; Investor/Issuer Name = ".$cm."; Address = ".$add."; State Of Location = ".$st."; Email = ".$em."; Phone = ".$ph."; Date Of Birth Or Incorporation (Company) = ".$dt."; Nationality = ".$cn."; Broker Id = ".$bid."; Account Status = ".$sta."; Bank Account Name = ".$acnm."; Account Number = ".$acno."; Bank Name = ".$bnm."; Bank Code = ".$bnk."; Recipient Code = ".$rc."; Bank Account Status = ".$bsta;			
				
				$NewValues="Investor/Issuer Id ' ".$uid."; Investor/Issuer Name = ".$company."; Address = ".$address."; State Of Location = ".$state."; Email = ".$email."; Phone = ".$phone."; Date Of Birth Or Incorporation (Company) = ".$dob."; Nationality = ".$nationality."; Broker Id = ".$broker_id."; Account Status = ".$sta."; Bank Account Name = ".$account_name."; Account Number = ".$account_number."; Bank Name = ".$bankname."; Bank Code = ".$bank_code."; Recipient Code = ".$recipient_code."; Bank Account Status = ".$bank_account_status;
			}*/					
			
			$dat=array(); $dat2=array();
			
			$updt=date('Y-m-d H:i:s');
			
			$dat=array(
				'user_name' 			=> $this->db->escape_str($company),
				'address' 				=> $this->db->escape_str($address),
				'state'	 				=> $this->db->escape_str($state),
				'phone' 				=> $this->db->escape_str($phone),	
				'dob' 					=> $this->db->escape_str($dob),
				'nationality' 			=> $this->db->escape_str($nationality),
				'broker_id' 			=> $this->db->escape_str($broker_id),								
				'account_name' 			=> $this->db->escape_str($account_name),
				'account_number' 		=> $this->db->escape_str($account_number),
				'bank_code' 			=> $this->db->escape_str($bank_code),
				'bankname' 				=> $this->db->escape_str($bankname),
				'recipient_code' 		=> $this->db->escape_str($recipient_code),
				'date_created' 			=> $this->db->escape_str($updt),
				'bank_account_status'	=> $this->db->escape_str($bank_account_status)
			);
			
			$dat2=array(
				'user_name' 			=> $this->db->escape_str($company),
				'address' 				=> $this->db->escape_str($address),
				'state'	 				=> $this->db->escape_str($state),
				'phone' 				=> $this->db->escape_str($phone),	
				'dob' 					=> $this->db->escape_str($dob),
				'nationality' 			=> $this->db->escape_str($nationality),
				'account_name' 			=> $this->db->escape_str($account_name),
				'account_number' 		=> $this->db->escape_str($account_number),
				'bank_code' 			=> $this->db->escape_str($bank_code),
				'bankname' 				=> $this->db->escape_str($bankname),
				'recipient_code' 		=> $this->db->escape_str($recipient_code),
				'date_created' 			=> $this->db->escape_str($updt),
				'bank_account_status'	=> $this->db->escape_str($bank_account_status)
			);
			
			
			if (strtolower($usertype) == 'investor')
			{
				$this->db->trans_start();
				$this->db->where(array('email' => $email));
				$this->db->update('investors', $dat);			
				$this->db->trans_complete();
				
				$op='UPDATED INVESTOR PROFILE';
			}elseif (strtolower($usertype) == 'issuer')
			{
				$this->db->trans_start();
				$this->db->where(array('email' => $email));
				$this->db->update('issuers', $dat2);			
				$this->db->trans_complete();
				
				$op='UPDATED ISSUER PROFILE';
			}/*elseif (strtolower($usertype) == 'investor/issuer')
			{
				$this->db->trans_start();
				$this->db->where(array('email' => $email));
				$this->db->update('investors', $dat);			
				$this->db->trans_complete();
				
				$this->db->trans_start();
				$this->db->where(array('email' => $email));
				$this->db->update('issuers', $dat2);			
				$this->db->trans_complete();
				
				$op='UPDATED INVESTOR/ISSUER PROFILE';
			}*/
			
			//Update blockchain address
			if (trim($badd) == '')
			{
				if (strtolower($usertype) == 'investor')
				{
					$user = $this->getdata_model->CreateUserRecordOnBlockchain($email,$phone,$company,'Investor');
					
					if ($user['status']==1)
					{
						$blockchain_address=$user['blockchainAddress'];
						
						$dat = array(
							'blockchain_address' => $this->db->escape_str($blockchain_address),
							'userId' => $this->db->escape_str($user['userId']),
						);
	
						$this->db->trans_start();
						$this->db->where(array('email' => $email));
						$this->db->update('investors', $dat);				
						$this->db->trans_complete();
					}	
				}elseif (strtolower($usertype) == 'issuer')
				{
					$user=$this->getdata_model->CreateUserRecordOnBlockchain($email,$phone,$company,'Issuer');
					
					if ($user['status']==1)
					{
						$blockchain_address=$user['blockchainAddress'];
						
						$dat = array(
							'blockchain_address' => $this->db->escape_str($blockchain_address),
							'userId' => $this->db->escape_str($user['userId']),
						);
	
						$this->db->trans_start();
						$this->db->where(array('email' => $email));
						$this->db->update('issuers', $dat);				
						$this->db->trans_complete();
					}	

				}
				
			}
			
			$dat=array(
				'company' 	=> $this->db->escape_str($company),
				'fullname' 	=> $this->db->escape_str($company),
				'phone' 	=> $this->db->escape_str($phone),
			);
			
			//Update userinfo
			$this->db->trans_start();
			$this->db->where(array('email' => $email));
			$this->db->update('userinfo', $dat);			
			$this->db->trans_complete();
		
			if ($this->db->trans_status() === FALSE)
			{					
				$Msg=$_SESSION['email']." attempted updating user profile with email ".strtoupper($email)." but failed.";
				
				$ret = 'Profile Record Could Not Be Updated.';
			}else
			{				
				$Msg="User profile record has been edited successfully by ".$_SESSION['email'].". Old Values => ".$OldValues.". Updated values => ".$NewValues;
				
				$ret ='OK';
				
				#Send Email - EmailSender($from,$to,$Cc,$message,$name)
				$from='support@naijaartmart.com';
				$to=$email;
				$subject='Updated Profile';
				$Cc='';
								
				$img=base_url()."images/logo.png";
				$img="https://www.naijaartmart.com/images/emaillogo.png";
				
				//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
						
				$message = '
					<html>
					<head>
					<meta charset="utf-8">
					<title>Naija Art Mart | User Profile Update</title>
					</head>
					<body>
							<p><img src="'.$img.'" alt="Naija Art Mart" title="Naija Art Mart" /></p>
														
							Dear User,<br><br>
							
							<p>You have successfully updated your profile.</p>
																																									
							<p>Best Regards</p>
							Naija Art Mart
					</body>
					</html>';
					
					$altmessage = '
						Dear User,
								
						You have successfully updated your profile.
																																					
						Best Regards
						
						Naija Art Mart';
				
				//if ($to) $v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$company);
				if ($to) $v=$this->getdata_model->SendBlueMail($from,$to,$subject,$Cc,$message,$altmessage,$company);
				
				$_SESSION['company']=$company;
				$_SESSION['phone']=$phone;
				
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
			//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
				$this->getdata_model->LogDetails($email,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,$op,$_SESSION['LogID']);	
			}			
		}
				
		echo $ret;
	}
	
	public function index()
	{
		$data['lastname']=''; $data['firstname']=''; $data['email']=''; $data['phone']=''; $data['pix']='';
		$data['accountstatus'] = ''; $data['pix'] = ''; $data['broker_id']='';
		$data['company']=''; $data['address']='';
		
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
			
			$ret=$this->getdata_model->GetMarketStatus();									
			$data['MarketStatus']=$ret['MarketStatus'];
			$data['ScrollingPrices']=$this->getdata_model->MarketData();	
			
			$data['balance']=$this->getdata_model->GetWalletBalance($data['email']);
			
			if (trim(strtolower($data['usertype']))=='investor') //or (trim(strtolower($data['usertype']))=='investor/issuer'))
			{
				$rw=$this->getdata_model->GetInvestorDetails($data['email']); //Investor Details				
				
				if ($rw->broker_id) $data['broker_id'] = $rw->broker_id; else $data['broker_id'] = '';			
			}elseif (trim(strtolower($data['usertype']))=='issuer')
			{
				$rw=$this->getdata_model->GetIssuerDetails($data['email']); //Issuer Details
				
				$data['broker_id'] = '';
			}
			
			if ($rw->user_name) $data['company'] = $rw->user_name; else $data['company']='';
			if ($rw->nationality) $data['nationality'] = $rw->nationality; else $data['nationality'] = '';				
			if ($rw->address) $data['address'] = $rw->address; else $data['address']='';
			if ($rw->state) $data['state'] = $rw->state; else $data['state']='';
			if ($rw->phone) $data['phone'] = $rw->phone; else $data['phone']='';			
			if ($rw->dob) $data['dob'] = $rw->dob; else $data['dob']='';
			
			if ($rw->account_name) $data['account_name'] = $rw->account_name; else $data['account_name']='';
			if ($rw->account_number) $data['account_number']=$rw->account_number; else $data['account_number']='';
			if ($rw->bank_code) $data['bank_code'] = $rw->bank_code; else $data['bank_code']='';
			if ($rw->recipient_code) $data['recipient_code'] = $rw->recipient_code; else $data['recipient_code']='';
			if ($rw->blockchain_address) $data['blockchain_address'] = $rw->blockchain_address; else $data['blockchain_address']='';
			
			$set=$this->getdata_model->GetParamaters();
				
			if (intval($set->refreshinterval) > 0)
			{
				$data['RefreshInterval'] = $set->refreshinterval;
			}else
			{
				$data['RefreshInterval']=5;
			}
			
			$data['set_rc']='';
			
			if (trim($_SESSION['set_rc']) <> '')
			{
				$data['set_rc']=$_SESSION['set_rc'];
				
				unset($_SESSION['set_rc']);
			}
				
			$this->load->view('ui/userprofileiv_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('');
		}
	}
}
