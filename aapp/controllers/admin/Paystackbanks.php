<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Paystackbanks extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	 }
	
	public function GetPaystackCountries()
	{		
		$sql="SELECT DISTINCT(name) as name FROM paystack_countries ORDER BY name";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());
	}
	
	public function GetPaystackBanks()
	{
		$country='';
		
		if ($this->input->post('country')) $country = trim($this->input->post('country'));
		
		if ($country=='')
		{
			$sql = "SELECT * FROM paystack_banks ORDER BY country,name";
		}else
		{
			$sql = "SELECT * FROM paystack_banks WHERE TRIM(country)='".$this->db->escape_str($country)."' ORDER BY name";
		}										

		$query = $this->db->query(stripslashes($sql));	

		$results = $query->result_array();		

		if ($results)
		{
			$data=array();

			if (is_array($results))
			{
				$sn=0;
				
				foreach($results as $row):
					$act='No'; $del='No';
					
					if ($row['active']==1) $act='Yes';
					if ($row['is_deleted']==1) $del='Yes';
					
					$tp=array($row['country'],$row['name'],$row['slug'],$row['code'],$row['longcode'],$row['gateway'],$act,$del);
					
					$data[]=$tp;
				endforeach;
			}

			print_r(json_encode($data));
		}else
		{
			print_r(json_encode($results));
		}
	}
	
	public function RetrieveBanks()
	{
		$country='';
		
		if ($this->input->post('country')) $country = trim($this->input->post('country'));
		
		//Get Settings
		$settings=$this->getdata_model->GetParamaters();
		
		if ($settings->runmode) $runmode=trim($settings->runmode);
		
		#Get PayStack Settings
		$PayStackSettings = $this->getdata_model->GetPaystackSettings();
		
		if (strtolower(trim($runmode))=='sandbox')
		{
			if ($PayStackSettings->Sandbox_SecretKey) $SecretKey=trim($PayStackSettings->Sandbox_SecretKey);
		}elseif (strtolower(trim($runmode))=='live')
		{
			if ($PayStackSettings->Live_SecretKey) $SecretKey=trim($PayStackSettings->Live_SecretKey);
		}
		
		if ($country=='')
		{
			$url="https://api.paystack.co/bank";
		}else
		{
			$url="https://api.paystack.co/bank?country=".$country;
		}
		
		$result = array();				
		$ch = curl_init();
		
		curl_setopt_array($ch, array(
			CURLOPT_URL 			=> $url,
			CURLOPT_RETURNTRANSFER 	=> true,
			CURLOPT_SSL_VERIFYPEER 	=> false,
			CURLOPT_SSL_VERIFYHOST 	=> false,
			CURLOPT_HTTPHEADER 		=> ["Authorization: Bearer ".$SecretKey]
		));
				
		$request = curl_exec($ch);
		
		curl_close($ch);
		
		$result = json_decode($request, true);
		
		$status = false; $message = ''; $data=array();
		
		if ($result)
		{
			$status=$result['status'];
			$message=$result['message'];
						
			if ($status)
			{
				$this->db->trans_start();
				
				if ($country=='')
				{
					$this->db->truncate('paystack_banks');
				}else
				{
					$this->db->delete('paystack_banks',array('country'=>$country));
				}				
						
				$this->db->trans_complete();				
			
				$data=$result['data'];
				
				foreach($data as $bank)
				{
					$name=''; $slug=''; $code=''; $longcode=''; $gateway=''; $active=''; $is_deleted='';
					$createdAt=''; $updatedAt='';
					
					$name = $bank['name'];
					$slug = $bank['slug'];
					$code = $bank['code'];
					$longcode = $bank['longcode'];
					$gateway = $bank['gateway'];
					$active = $bank['active'];
					$is_deleted = $bank['is_deleted'];
					$createdAt = $bank['createdAt'];
					$updatedAt = $bank['updatedAt'];
					
					//Insert
					$this->db->trans_start();
						
					$dat=array(
						'country' 		=> $this->db->escape_str($country),
						'name' 			=> $this->db->escape_str($name),
						'slug'			=> $this->db->escape_str($slug),
						'code' 			=> $this->db->escape_str($code),
						'longcode' 		=> $this->db->escape_str($longcode),
						'gateway'		=> $this->db->escape_str($gateway),
						'active' 		=> $this->db->escape_str($active),
						'is_deleted'	=> $this->db->escape_str($is_deleted),
						'createdAt'		=> $this->db->escape_str($createdAt),
						'updatedAt' 	=> $this->db->escape_str($updatedAt)
					);
					
					$this->db->insert('paystack_banks', $dat);					
					$this->db->trans_complete();
				}
				
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
				if ($country=='')
				{
					$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'RETRIEVED PAYSTACK BANKS',$_SESSION['LogID']);
				}else
				{
					$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'RETRIEVED PAYSTACK BANKS FOR '.strtoupper($country),$_SESSION['LogID']);
				}				
			}
		}
		
		echo json_encode($ret=array('status'=>'OK','Message'=>''));
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
			
			$this->load->view('admin/paystackbanks_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
