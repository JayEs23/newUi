<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Paystack extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	 }
	 
	public function ConfirmDisableOTP()
	{
		$otp='';
				
		if ($this->input->post('otp')) $otp = trim($this->input->post('otp'));
		
		$res=$this->getdata_model->ConfirmDisablingOfPaystackOTP($otp);
		
		if ($res)
		{
			//Check if record exists
			$sql = "SELECT * FROM paystack_settings";
	
			$query = $this->db->query($sql);
					
			if ($query->num_rows() == 0 )
			{					
				$this->db->trans_start();							
				$dat=array('otp_status'	=> 0);					
				$this->db->insert('paystack_settings', $dat);					
				$this->db->trans_complete();
				
				$Msg='';	
				
				if ($this->db->trans_status() === FALSE)
				{
					$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted disabling Paystack transfer OTP but failed.";
					
					$ret = 'Paystack Transfer OTP Was Not Disabled.';
				}else
				{				
					$Msg="Paystack Transfer OTP Was Disabled Successfully.";				
					
					$ret ='OK';	
					
					$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'DISABLED PAYSTACK TRANSFER OTP',$_SESSION['LogID']);
				}
			}else
			{
				$sta='0';
							
				$row = $query->row();			
				
				if ($row->otp_status==1) $sta=trim($row->otp_status);			
							
				$OldValues="OTP Status = ".$sta;    $NewValues="OTP Status = 0";
				
				$dat=array('otp_status'	=> 0);
				
				#Update
				$this->db->trans_start();
				$this->db->update('paystack_settings', $dat);			
				$this->db->trans_complete();
							
				$Msg='';
			
				if ($this->db->trans_status() === FALSE)
				{
					$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted disabling Paystack transfer OTP but failed.";
									
					$ret = 'Paystack Transfer OTP Record Could Not Be Disabled.';
				}else
				{
					$Msg="Paystack transfer OTP state has been disabled successfully by ".strtoupper($_SESSION['fullname'].'('.$_SESSION['email'])."). Old Values => ".$OldValues.". Updated values => ".$NewValues;				
					
					$ret ='OK';
				
					$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'DISABLED PAYSTACK TRANSFER OTP',$_SESSION['LogID']);	
				}			
			}	
		}else
		{
			$ret = 'Disabling Transfer OTP Confirmation Was Not Successful.';
		}
		
		echo $ret;
	}
	
	public function EnableDisableOTP()
	{		
		$state='0';
				
		if (intval($this->input->post('state')) == 1) $state = 1;
						
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		if ($state=='1')
		{
			$res=$this->getdata_model->EnablePaystackTransferOTP();
		}else
		{
			$res=$this->getdata_model->DisablePaystackTransferOTP();
		}
		
		//array('status'=>$status,'message'=>$message)
		
		$status=$res['status'];
		$message=$res['message'];
		
		if ($status)
		{
			if ($state == '1')
			{
				//Check if record exists
				$sql = "SELECT * FROM paystack_settings";
		
				$query = $this->db->query($sql);
						
				if ($query->num_rows() == 0 )
				{					
					$this->db->trans_start();							
					$dat=array('otp_status'	=> 1);					
					$this->db->insert('paystack_settings', $dat);					
					$this->db->trans_complete();
					
					$Msg='';	
					
					if ($this->db->trans_status() === FALSE)
					{
						$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted enabling Paystack transfer OTP but failed.";
						
						$ret = 'Paystack Transfer OTP Was Not Enabled.';
					}else
					{				
						$Msg="Paystack Transfer OTP Was Enabled Successfully.";				
						
						$ret ='OK';	
						
						$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'ENABLED PAYSTACK TRANSFER OTP',$_SESSION['LogID']);
					}
				}else
				{
					$sta='0';
								
					$row = $query->row();			
					
					if ($row->otp_status==1) $sta=trim($row->otp_status);			
								
					$OldValues="OTP Status = ".$sta;    $NewValues="OTP Status = ".$state;
					
					$dat=array('otp_status'	=> 1);
					
					#Update
					$this->db->trans_start();
					$this->db->update('paystack_settings', $dat);			
					$this->db->trans_complete();
								
					$Msg='';
				
					if ($this->db->trans_status() === FALSE)
					{
						$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted enabling Paystack transfer OTP but failed.";
										
						$ret = 'Paystack Transfer OTP Record Could Not Be Enabled.';
					}else
					{
						$Msg="Paystack transfer OTP state has been enabled successfully by ".strtoupper($_SESSION['fullname'].'('.$_SESSION['email'])."). Old Values => ".$OldValues.". Updated values => ".$NewValues;				
						
						$ret ='OK';
					
						$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'ENABLED PAYSTACK TRANSFER OTP',$_SESSION['LogID']);	
					}			
				}		
			}else
			{
				$ret ='OK^'.$message;
			}			
		}else
		{
			if ($state == '1')
			{
				$ret = 'Enabling Transfer OTP Was Not Successful.';
			}else
			{
				$ret = 'Disabling Transfer OTP Was Not Successful.';
			}
		}
				
		echo $ret;
	}
	 
	 
	public function UpdateSettings()
	{		
		$VerifyUrl=''; $Sandbox_SecretKey=''; $Live_SecretKey=''; $local_trans_percent = '';
		$local_commission_cap=''; $local_extra_fee=''; $inter_trans_percent='';
		$inter_commission_cap=''; $inter_extra_fee=''; $inter_commission_waiver='';
		$local_commission_waiver=''; $transfer_fee='';		
				
		if ($this->input->post('VerifyUrl')) $VerifyUrl = trim($this->input->post('VerifyUrl'));
		if ($this->input->post('Sandbox_SecretKey')) $Sandbox_SecretKey = trim($this->input->post('Sandbox_SecretKey'));
		if ($this->input->post('Live_SecretKey')) $Live_SecretKey = trim($this->input->post('Live_SecretKey'));		
		if ($this->input->post('local_commission_cap')) $local_commission_cap = trim($this->input->post('local_commission_cap'));		
		if ($this->input->post('local_trans_percent')) $local_trans_percent = trim($this->input->post('local_trans_percent'));		
		if ($this->input->post('local_extra_fee')) $local_extra_fee = trim($this->input->post('local_extra_fee'));
		if ($this->input->post('inter_trans_percent')) $inter_trans_percent = trim($this->input->post('inter_trans_percent'));		
		
		if ($this->input->post('inter_commission_cap')) $inter_commission_cap = trim($this->input->post('inter_commission_cap'));
		
		if ($this->input->post('inter_extra_fee')) $inter_extra_fee = trim($this->input->post('inter_extra_fee'));
		
		if ($this->input->post('inter_commission_waiver')) $inter_commission_waiver = trim($this->input->post('inter_commission_waiver'));
		
		if ($this->input->post('local_commission_waiver')) $local_commission_waiver = trim($this->input->post('local_commission_waiver'));
		
		if ($this->input->post('transfer_fee')) $transfer_fee = trim($this->input->post('transfer_fee'));
		
				
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
		//Check if record exists
		$sql = "SELECT * FROM paystack_settings";

		$query = $this->db->query($sql);
				
		if ($query->num_rows() == 0 )
		{
			$this->db->trans_start();
					
			$dat=array(
				'VerifyUrl' 				=> $this->db->escape_str($VerifyUrl),
				'Sandbox_SecretKey'	 		=> $this->db->escape_str($Sandbox_SecretKey),
				'Live_SecretKey'			=> $this->db->escape_str($Live_SecretKey),
				'local_trans_percent'		=> $this->db->escape_str($local_trans_percent),
				'local_commission_cap' 		=> $this->db->escape_str($local_commission_cap),				
				'local_extra_fee' 			=> $this->db->escape_str($local_extra_fee),
				'inter_trans_percent'	 	=> $this->db->escape_str($inter_trans_percent),				
				'inter_commission_cap'	 	=> $this->db->escape_str($inter_commission_cap),
				'inter_extra_fee'	 		=> $this->db->escape_str($inter_extra_fee),
				'inter_commission_waiver' 	=> $this->db->escape_str($inter_commission_waiver),
				'local_commission_waiver'	=> $this->db->escape_str($local_commission_waiver),
				'transfer_fee'				=> $this->db->escape_str($transfer_fee)
			);
			
			$this->db->insert('paystack_settings', $dat);
			
			$this->db->trans_complete();
			
			$Msg='';	
		
			if ($this->db->trans_status() === FALSE)
			{
				$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted inserting Paystack settings but failed.";
				
				$ret = 'Paystack Settings Was Not Inserted.';
			}else
			{				
				$Msg="Paystack Settings Was Inserted Successfully.";				
				
				$ret ='OK';	
				
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'INSERTED PAYSTACK SETTINGS RECORD',$_SESSION['LogID']);
			}
		}else
		{
			$url=''; $skey=''; $lkey=''; $loccap=''; $locper=''; $locextra=''; $intper=''; $intcap='';
			$intextra=''; $intwaiv=''; $locwaiv=''; $fee='';
						
			$row = $query->row();			
			
			if ($row->VerifyUrl) $url=trim($row->VerifyUrl);
			if ($row->Sandbox_SecretKey) $skey=trim($row->Sandbox_SecretKey);
			if ($row->Live_SecretKey) $lkey=trim($row->Live_SecretKey);
			if ($row->local_commission_cap) $loccap=trim($row->local_commission_cap);			
			if ($row->local_trans_percent) $locper=trim($row->local_trans_percent);			
			if ($row->local_extra_fee) $locextra=trim($row->local_extra_fee);
			if ($row->inter_trans_percent) $intper=trim($row->inter_trans_percent);			
			if ($row->inter_commission_cap) $intcap=trim($row->inter_commission_cap);
			if ($row->inter_extra_fee) $intextra=trim($row->inter_extra_fee);
			if ($row->inter_commission_waiver) $intwaiv=trim($row->inter_commission_waiver);
			if ($row->local_commission_waiver) $locwaiv=trim($row->local_commission_waiver);
			if ($row->transfer_fee) $fee=trim($row->transfer_fee);
					
						
			$OldValues="Paystack Payment Verification Url = ".$url."; Sandbox Secret Key = ".$skey."; Live Secret Key = ".$lkey."; Local Commission Cap = ".$loccap."; Local Transaction Commission (%) = ".$locper."; Local Transaction Extra Fee = ".$locextra."; International Transaction Commission (%) = ".$intper."; Local Commission Cap = ".$intcap."; International Transaction Extra = ".$intextra."; International Fee Waiver Limit = ".$intwaiv."; Local Fee Waiver Limit = ".$locwaiv."; Fee Per Transfer = ".$fee;
			
			$NewValues="Paystack Payment Verification Url = ".$VerifyUrl."; Sandbox Secret Key = ".$Sandbox_SecretKey."; Live Secret Key  = ".$Live_SecretKey."; Local Commission Cap = ".$local_commission_cap."; Local Transaction Commission (%) = ".$local_trans_percent."; Local Transaction Extra Fee = ".$local_extra_fee."; International Transaction Commission (%) = ".$inter_trans_percent."; Local Commission Cap = ".$inter_commission_cap."; International Transaction Extra = ".$inter_extra_fee."; International Fee Waiver Limit = ".$inter_commission_waiver."; Local Fee Waiver Limit = ".$local_commission_waiver."; Fee Per Transfer = ".$transfer_fee;
			
			$dat=array(
				'VerifyUrl' 				=> $this->db->escape_str($VerifyUrl),
				'Sandbox_SecretKey'	 		=> $this->db->escape_str($Sandbox_SecretKey),
				'Live_SecretKey'			=> $this->db->escape_str($Live_SecretKey),
				'local_trans_percent'		=> $this->db->escape_str($local_trans_percent),
				'local_commission_cap' 		=> $this->db->escape_str($local_commission_cap),				
				'local_extra_fee' 			=> $this->db->escape_str($local_extra_fee),
				'inter_trans_percent'	 	=> $this->db->escape_str($inter_trans_percent),				
				'inter_commission_cap'	 	=> $this->db->escape_str($inter_commission_cap),
				'inter_extra_fee'	 		=> $this->db->escape_str($inter_extra_fee),
				'inter_commission_waiver' 	=> $this->db->escape_str($inter_commission_waiver),
				'local_commission_waiver'	=> $this->db->escape_str($local_commission_waiver),
				'transfer_fee'				=> $this->db->escape_str($transfer_fee)		
			);
			
			#Update
			$this->db->trans_start();
			$this->db->update('paystack_settings', $dat);			
			$this->db->trans_complete();
						
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{
				$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted updating Paystack settings but failed.";
								
				$ret = 'Paystack Settings Could Not Be Edited.';
			}else
			{
				$Msg="Paystack settings has been edited successfully by ".strtoupper($_SESSION['fullname'].'('.$_SESSION['email'])."). Old Values => ".$OldValues.". Updated values => ".$NewValues;				
				
				$ret ='OK';
			
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'EDITED PAYSTACK SETTINGS RECORD',$_SESSION['LogID']);	
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
			$set = $this->getdata_model->GetPaystackSettings();
				
			if ($set->VerifyUrl) $data['VerifyUrl'] = $set->VerifyUrl; else $data['VerifyUrl'] ='';
			
			if ($set->Sandbox_SecretKey) $data['Sandbox_SecretKey'] = $set->Sandbox_SecretKey; else $data['Sandbox_SecretKey']='';
			
			if ($set->Live_SecretKey) $data['Live_SecretKey'] = $set->Live_SecretKey; else $data['Live_SecretKey'] = '';
			
			if ($set->local_trans_percent) $data['local_trans_percent'] = $set->local_trans_percent; else $data['local_trans_percent'] = '';
			
			if ($set->local_commission_cap) $data['local_commission_cap'] = $set->local_commission_cap; else $data['local_commission_cap'] = '';
			
			if ($set->local_extra_fee) $data['local_extra_fee'] = $set->local_extra_fee; else $data['local_extra_fee'] = '';
			
			if ($set->inter_trans_percent) $data['inter_trans_percent'] = $set->inter_trans_percent; else $data['inter_trans_percent'] = '';
			
			if ($set->inter_commission_cap) $data['inter_commission_cap'] = $set->inter_commission_cap; else $data['inter_commission_cap'] = '';
			
			if ($set->inter_extra_fee) $data['inter_extra_fee'] = $set->inter_extra_fee; else $data['inter_extra_fee'] = '';
			
			if ($set->inter_commission_waiver) $data['inter_commission_waiver'] = $set->inter_commission_waiver; else $data['inter_commission_waiver'] = '';
			
			if ($set->local_commission_waiver) $data['local_commission_waiver'] = $set->local_commission_waiver; else $data['local_commission_waiver'] = '';
			
			if ($set->transfer_fee) $data['transfer_fee'] = $set->transfer_fee; else $data['transfer_fee'] = '';
			
			if ($set->otp_status == 1) $data['otp_status'] = 1; else $data['otp_status'] = '0';
						
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
			
			$this->load->view('admin/paystack_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
