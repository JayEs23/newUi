<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('assets/vendor/autoload.php');

class Blockchainusers extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	 }
	 
	function GetUsers()
	{
		$usertype='';
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		
		if (trim($usertype) == '-2') $usertype='0';
		
		if (trim($usertype) == '-1')
		{
			$results=$this->getdata_model->GetAllBlockchainUsers();
		}else
		{
			$results=$this->getdata_model->GetBlockchainUsersByRole($usertype);
		}
		
		//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($users,true)); fclose($file);
		
		if ($results['status']==1)
		{
			$datas=$results['data'];
			
			$users=$this->getdata_model->GetAllRegisteredUsers();

			foreach($datas as $row):
				if (in_array($row['UserId'], $users))
				{
					$sel='<img onClick="ViewRow(\''.$row['UserId'].'\',\''.$row['Email'].'\',\''.$row['Phone'].'\',\''.$row['UserName'].'\',\''.$row['UserType'].'\',\''.$row['BlockchainAddress'].'\')" style="cursor:pointer; height:30px; " src="'.base_url().'images/view_icon.png" title="View '.strtoupper(trim($row['UserName'])).' Blockchain Record">';
										
					$tp=array(
						ucwords(strtolower($row['UserType'])),
						ucwords(strtolower($row['UserName'])),
						$row['Email'],
						$row['Phone'],
						$row['UserId'],
						$sel
					);
					
					$data[]=$tp;	
				}				
			endforeach;		

			print_r(json_encode($data));
		}elseif (trim(strtolower($results['status'])) == 'error')
		{
			print_r(json_encode(array()));
		}
	}
		
		
	public function index()
	{
		// $results=$this->getdata_model->GetAllBlockchainUsers();
		// echo "<pre>";
		// print_r($results); die();
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
			
			$this->load->view('admin/blockchainusers_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
