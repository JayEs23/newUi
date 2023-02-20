<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Paystackcountries extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	 }
	 
	public function GetCountries()
	{
		$sql = "SELECT * FROM paystack_countries ORDER BY name";											

		$query = $this->db->query(stripslashes($sql));	

		$results = $query->result_array();		

		if ($results)
		{
			$data=array();

			if (is_array($results))
			{
				foreach($results as $row):
					$tp=array($row['name'],$row['iso_code'],$row['default_currency_code']);
					
					$data[]=$tp;
				endforeach;
			}

			print_r(json_encode($data));
		}else
		{
			print_r(json_encode($results));
		}
	}
	
	public function RetrieveCountries()
	{
		$url="https://api.paystack.co/country";
		
		//Retrieve Countries
		$result = array();
				
		$ch = curl_init();
		
		curl_setopt_array($ch, array(
			CURLOPT_URL 			=> $url,
			CURLOPT_RETURNTRANSFER 	=> true,
			CURLOPT_SSL_VERIFYPEER 	=> false,
			CURLOPT_SSL_VERIFYHOST 	=> false
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
				$this->db->truncate('paystack_countries');			
				$this->db->trans_complete();				
			
				$data=$result['data'];
				
				foreach($data as $country)
				{
					$name=''; $iso_code=''; $default_currency_code='';
					
					$name=$country['name'];
					$iso_code=$country['iso_code'];
					$default_currency_code=$country['default_currency_code'];
					
					//Insert
					$this->db->trans_start();
						
					$dat=array(
						'name' 					=> $this->db->escape_str($name),
						'iso_code'				=> $this->db->escape_str($iso_code),
						'default_currency_code' => $this->db->escape_str($default_currency_code)
					);
					
					$this->db->insert('paystack_countries', $dat);					
					$this->db->trans_complete();
				}
				
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'RETRIEVED PAYSTACK COUNTRIES',$_SESSION['LogID']);				
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
			
			$this->load->view('admin/paystackcountries_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
