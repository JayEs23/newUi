<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
	 }
	 
	function GetPaystackBanks()
	{		
		$sql="SELECT DISTINCT name,code FROM paystack_banks WHERE TRIM(country)='Nigeria' ORDER BY name";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());
	}
	
	function CreateNSEBlockchainAddress()
	{
		$userId=$this->getdata_model->GetBlockchainUserID();
		$email = "admin@naijaartmart.com";
		$phone = "08022227157";
		$userType= 'Admin';
		$userName='Nigerian Stock Exchange';
		
		$usr = array("userId"=>$userId, "email"=>$email, "phone"=>$phone, "userType"=>$userType, "userName"=>$userName);
		
		return $this->getdata_model->CreateUserOnBlockchain($usr);		
	}
	
	function UpdateParameter()
	{		
		$sms_username=''; $sms_sender_id=''; $sms_apikey=''; $runmode=''; $refreshinterval='';
		$account_name=''; $account_number=''; $bank_code=''; $currency='NGN'; $bankname='';
		$recipient_code=''; $bank_account_status='0'; $message_delete_period=0; $blockchain_token='';
		$blockchain_baseurl=''; $blockchain_address='';
				
		if ($this->input->post('sms_username')) $sms_username = trim($this->input->post('sms_username'));
		if ($this->input->post('sms_sender_id')) $sms_sender_id = trim($this->input->post('sms_sender_id'));
		if ($this->input->post('sms_apikey')) $sms_apikey = trim($this->input->post('sms_apikey'));				
		if ($this->input->post('runmode')) $runmode = trim($this->input->post('runmode'));
		if ($this->input->post('refreshinterval')) $refreshinterval = trim($this->input->post('refreshinterval'));
		
		if ($this->input->post('account_name')) $account_name = trim($this->input->post('account_name'));
		if ($this->input->post('account_number')) $account_number = trim($this->input->post('account_number'));
		if ($this->input->post('bank_code')) $bank_code = trim($this->input->post('bank_code'));
		if ($this->input->post('message_delete_period')) $message_delete_period = trim($this->input->post('message_delete_period'));
		if ($this->input->post('blockchain_token')) $blockchain_token=trim($this->input->post('blockchain_token'));
		if ($this->input->post('blockchain_baseurl')) $blockchain_baseurl=trim($this->input->post('blockchain_baseurl'));
		if ($this->input->post('blockchain_address')) $blockchain_address=trim($this->input->post('blockchain_address'));
				
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
						
		//Check if record exists
		$sql = "SELECT * FROM settings";

		$query = $this->db->query($sql);
				
		if ($query->num_rows() == 0 )
		{
			$TRec=$this->getdata_model->CreatePaystackTransferRecipient($account_name,$account_number, $account_name,$bank_code,$currency);
		
			if ($TRec['Status'] === true)
			{
				$bankname = $TRec['BankName'];
				$recipient_code = $TRec['RecipientCode'];
				$bank_account_status = $TRec['BankAccountStatus'];
			}
			
			$this->db->trans_start();
					
			$dat=array(
				'sms_username' 			=> $this->db->escape_str($sms_username),
				'sms_sender_id'	 		=> $this->db->escape_str($sms_sender_id),
				'sms_apikey' 			=> $this->db->escape_str($sms_apikey),
				'refreshinterval' 		=> $this->db->escape_str($refreshinterval),
				'message_delete_period'	=> $this->db->escape_str($message_delete_period),				
				'account_name' 			=> $this->db->escape_str($account_name),
				'account_number' 		=> $this->db->escape_str($account_number),
				'bank_code' 			=> $this->db->escape_str($bank_code),
				'bankname' 				=> $this->db->escape_str($bankname),
				'recipient_code' 		=> $this->db->escape_str($recipient_code),
				'bank_account_status'	=> $this->db->escape_str($bank_account_status),
				'blockchain_token'		=> $this->db->escape_str($blockchain_token),
				'blockchain_baseurl'	=> $this->db->escape_str($blockchain_baseurl),
				'blockchain_address'	=> $this->db->escape_str($blockchain_address),

				'runmode' 				=> $this->db->escape_str($runmode)				
			);
			
			$this->db->insert('settings', $dat);
			
			$this->db->trans_complete();
			
			$Msg='';	
			
			if ($this->db->trans_status() === FALSE)
			{
				$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted inserting system parameters but failed.";
				
				$ret = 'System Parameters Was Not Inserted.';
			}else
			{
				//Update blockchain address
				$user=$this->CreateNSEBlockchainAddress();
				
				if ($user['status']==1)
				{
					$dat=array(
						'blockchain_address' => $this->db->escape_str($user['blockchainAddress']),
						'userId' => $this->db->escape_str($user['userId']),
					);					
						
					#Update
					$this->db->trans_start();
					$this->db->update('settings', $dat);			
					$this->db->trans_complete();
				}
						
				$Msg="System Parameters Was Inserted Successfully.";				
				
				$ret ='OK';	
				
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'INSERTED SYSTEM PARAMETERS RECORD',$_SESSION['LogID']);
			}
		}else
		{
			$un=''; $sid=''; $api=''; $md=''; $ref=''; $sta='0'; $rc=''; $bnm=''; $bnk=''; $acno='';
			$acnm=''; $del=''; $tok=''; $burl=''; $add='';
						
			$row = $query->row();			
			
			if ($row->sms_username) $un=trim($row->sms_username);
			if ($row->sms_sender_id) $sid=trim($row->sms_sender_id);
			if ($row->sms_apikey) $api=trim($row->sms_apikey);
			if ($row->runmode) $md=trim($row->runmode);
			if ($row->refreshinterval) $ref=trim($row->refreshinterval);			
			if ($row->account_name) $acnm=trim($row->account_name);
			if ($row->account_number) $acno=trim($row->account_number);
			if ($row->bank_code) $bnk=trim($row->bank_code);
			if ($row->bankname) $bnm=trim($row->bankname);
			if ($row->recipient_code) $rc=trim($row->recipient_code);
			if ($row->bank_account_status==1) $sta=trim($row->bank_account_status);
			if ($row->message_delete_period) $del=trim($row->message_delete_period);
			if ($row->blockchain_token) $tok=trim($row->blockchain_token);
			if ($row->blockchain_baseurl) $burl=trim($row->blockchain_baseurl);
			if ($row->blockchain_address) $add=trim($row->blockchain_address);
			
			if ((trim(strtolower($bnk)) <> trim(strtolower($bank_code))) or (trim(strtolower($acno)) <> trim(strtolower($account_number))) or (trim($rc)==''))
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
				$bank_account_status = $sta;
			}		
						
			$OldValues="SMS Username = ".$un."; SMS Sender Id = ".$sid."; SMS Api Key = ".$api."; Applciation Run Mode = ".$md."; Refresh Interval = ".$ref."; NSE Bank Account Name = ".$acnm."; NSE Bank Account No = ".$acno."; NSE Bank Code = ".$bnk."; NSE Bank Name = ".$bnm."; NSE Recipient Code = ".$rc."; NSE Bank Account Status = ".$sta."; Message Deletion Period = ".$del."; Blockchain Token = ".$tok."; Blockchain APIs Base Url = ".$burl;
			
			$NewValues="SMS Username = ".$sms_username."; SMS Sender Id = ".$sms_sender_id."; SMS Api Key  = ".$sms_apikey."; Applciation Run Mode = ".$runmode."; Refresh Interval = ".$refreshinterval."; NSE Bank Account Name = ".$account_name."; NSE Bank Account No = ".$account_number."; NSE Bank Code = ".$bank_code."; NSE Bank Name = ".$bankname."; NSE Recipient Code = ".$recipient_code."; NSE Bank Account Status = ".$bank_account_status."; Message Deletion Period = ".$message_delete_period."; Blockchain Token = ".$blockchain_token."; Blockchain APIs Base Url = ".$blockchain_baseurl;
			
			$dat=array(
				'sms_username' 			=> $this->db->escape_str($sms_username),
				'sms_sender_id'	 		=> $this->db->escape_str($sms_sender_id),
				'sms_apikey' 			=> $this->db->escape_str($sms_apikey),
				'refreshinterval' 		=> $this->db->escape_str($refreshinterval),
				'account_name' 			=> $this->db->escape_str($account_name),
				'account_number' 		=> $this->db->escape_str($account_number),
				'bank_code' 			=> $this->db->escape_str($bank_code),
				'bankname' 				=> $this->db->escape_str($bankname),
				'recipient_code' 		=> $this->db->escape_str($recipient_code),
				'bank_account_status'	=> $this->db->escape_str($bank_account_status),
				'message_delete_period'	=> $this->db->escape_str($message_delete_period),
				'blockchain_token'		=> $this->db->escape_str($blockchain_token),
				'blockchain_baseurl'	=> $this->db->escape_str($blockchain_baseurl),
				'runmode' 				=> $this->db->escape_str($runmode)
			);
			
			#Update
			$this->db->trans_start();
			$this->db->update('settings', $dat);			
			$this->db->trans_complete();
						
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{
				$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted updating system parameters but failed.";
								
				$ret = 'System Parameters Could Not Be Edited.';
			}else
			{
				if (trim($add) == '')//Update blockchain address
				{				
					$user=$this->CreateNSEBlockchainAddress();
					
					if ($user['status']==1)
					{
						$blockchain_address=$user['blockchainAddress'];
						
						$dat=array(
							'blockchain_address' => $this->db->escape_str($blockchain_address),
							'userId' => $this->db->escape_str($user['userId']),
						);
	
						$this->db->trans_start();
						$this->db->update('settings', $dat);			
						$this->db->trans_complete();
					}
				}
				
				$Msg="System parameters has been edited successfully by ".strtoupper($_SESSION['fullname'].'('.$_SESSION['email'])."). Old Values => ".$OldValues.". Updated values => ".$NewValues;				
				
				$ret ='OK';
			
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'EDITED SYSTEM PARAMETERS RECORD',$_SESSION['LogID']);	
			}			
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
			
			//Get Settings
			$set = $this->getdata_model->GetParamaters();
				
			if ($set->sms_username) $data['sms_username'] = $set->sms_username; else $data['sms_username'] ='';
			if ($set->sms_sender_id) $data['sms_sender_id'] = $set->sms_sender_id; else $data['sms_sender_id']='';
			if ($set->sms_apikey) $data['sms_apikey'] = $set->sms_apikey; else $data['sms_apikey'] = '';
			if ($set->runmode) $data['runmode'] = $set->runmode; else $data['runmode'] = '';
			if ($set->refreshinterval) $data['refreshinterval'] = $set->refreshinterval; else $data['refreshinterval'] = '';
			
			if ($set->account_name) $data['account_name'] = $set->account_name; else $data['account_name'] = '';
			if ($set->account_number) $data['account_number'] = $set->account_number; else $data['account_number'] = '';
			if ($set->bank_code) $data['bank_code'] = $set->bank_code; else $data['bank_code'] = '';
			if ($set->bankname) $data['bankname'] = $set->bankname; else $data['bankname'] = '';
			if ($set->recipient_code) $data['recipient_code'] = $set->recipient_code; else $data['recipient_code'] = '';
			
			if ($set->blockchain_token) $data['blockchain_token'] = $set->blockchain_token; else $data['blockchain_token'] = '';
			
			if ($set->blockchain_baseurl) $data['blockchain_baseurl'] = $set->blockchain_baseurl; else $data['blockchain_baseurl'] = '';
			
			if ($set->blockchain_address) $data['blockchain_address'] = $set->blockchain_address; else $data['blockchain_address'] = '';
			
			
			if ($set->message_delete_period) $data['message_delete_period'] = $set->message_delete_period; else $data['message_delete_period'] = '';
			
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
			
			$data['set_rc']='';
			
			if (trim($_SESSION['set_rc']) <> '')
			{
				$data['set_rc']=$_SESSION['set_rc'];
				
				unset($_SESSION['set_rc']);
			}
			
			$this->load->view('admin/settings_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
