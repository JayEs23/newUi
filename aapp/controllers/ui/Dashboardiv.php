<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboardiv extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	
	function GetSummary()
	{
		$email=''; $issuer_id=''; $usertype='';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('issuer_id')) $issuer_id = trim($this->input->post('issuer_id'));
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
	
		//TotalIssuerListedSecurities,TotalIssuerListedSecuritiesValue,TotalIssuerExecutedPrimaryTrades,TotalIssuerExecutedPrimaryTradesValue,TotalIssuerCurrentlyListedSecurities,TotalIssuerCurrentlyListedSecuritiesValue
		
		//TotalInvestorSecurities,TotalInvestorSecuritiesValue,TotalInvestorPrimaryTrades,TotalInvestorPrimaryTradesValue,TotalInvestorSellOrders,TotalInvestorSellOrdersValue,TotalInvestorExecutedSellOrders,TotalInvestorExecutedSellOrdersValue

		
		if (trim(strtolower($usertype))=='issuer')
		{
			$TotalIssuerListedSecurities='0'; $TotalIssuerListedSecuritiesValue='0';
			$TotalIssuerExecutedPrimaryTrades='0'; $TotalIssuerExecutedPrimaryTradesValue='0';
			$TotalIssuerCurrentlyListedSecurities='0'; $TotalIssuerCurrentlyListedSecuritiesValue='0';
			
			$TotalIssuerListedSecurities = $this->getdata_model->GetTotalIssuerListedSecurities($issuer_id);					
			$TotalIssuerListedSecuritiesValue = $this->getdata_model->GetTotalIssuerListedSecuritiesValue($email);
			
			$TotalIssuerExecutedPrimaryTrades = $this->getdata_model->GetTotalIssuerExecutedPrimaryTrades($email);
			$TotalIssuerExecutedPrimaryTradesValue = $this->getdata_model->GetTotalIssuerExecutedPrimaryTradesValue($email);
			
			$TotalIssuerCurrentlyListedSecurities = $this->getdata_model->GetTotalIssuerCurrentlyListedSecurities($issuer_id);
			
			$TotalIssuerCurrentlyListedSecuritiesValue = $this->getdata_model->GetTotalIssuerCurrentlyListedSecuritiesValue($email);
			
			$ret=array('TotalIssuerListedSecurities'=>$TotalIssuerListedSecurities,'TotalIssuerListedSecuritiesValue'=>$TotalIssuerListedSecuritiesValue,'TotalIssuerExecutedPrimaryTrades'=>$TotalIssuerExecutedPrimaryTrades,'TotalIssuerExecutedPrimaryTradesValue'=>$TotalIssuerExecutedPrimaryTradesValue,'TotalIssuerCurrentlyListedSecurities'=>$TotalIssuerCurrentlyListedSecurities,'TotalIssuerCurrentlyListedSecuritiesValue'=>$TotalIssuerCurrentlyListedSecuritiesValue);
			
		}elseif (trim(strtolower($usertype))=='investor')
		{
			$TotalInvestorSecurities='0'; $TotalInvestorSecuritiesValue='0';
			$TotalInvestorPrimaryTrades='0'; $TotalInvestorPrimaryTradesValue='0';
			$TotalInvestorSellOrders='0'; $TotalInvestorSellOrdersValue='0';
			$TotalInvestorExecutedSellOrders='0'; $TotalInvestorExecutedSellOrdersValue='0';
			
			$TotalInvestorSecurities = $this->getdata_model->GetTotalInvestorSecurities($email);
			$TotalInvestorSecuritiesValue = $this->getdata_model->GetTotalInvestorSecuritiesValue($email);
			
			$TotalInvestorPrimaryTrades = $this->getdata_model->GetTotalInvestorPrimaryTrades($email);
			$TotalInvestorPrimaryTradesValue = $this->getdata_model->GetTotalInvestorPrimaryTradesValue($email);
			
			$TotalInvestorSellOrders = $this->getdata_model->GetTotalInvestorSellOrders($email);
			$TotalInvestorSellOrdersValue = $this->getdata_model->GetTotalInvestorSellOrdersValue($email);
			
			
			$TotalInvestorExecutedSellOrders = $this->getdata_model->GetTotalInvestorExecutedSellOrders($email);
			$TotalInvestorExecutedSellOrdersValue = $this->getdata_model->GetTotalInvestorExecutedSellOrdersValue($email);
			
			$ret=array('TotalInvestorSecurities'=>$TotalInvestorSecurities,'TotalInvestorSecuritiesValue'=>$TotalInvestorSecuritiesValue,'TotalInvestorPrimaryTrades'=>$TotalInvestorPrimaryTrades,'TotalInvestorPrimaryTradesValue'=>$TotalInvestorPrimaryTradesValue,'TotalInvestorSellOrders'=>$TotalInvestorSellOrders,'TotalInvestorSellOrdersValue'=>$TotalInvestorSellOrdersValue,'TotalInvestorExecutedSellOrders'=>$TotalInvestorExecutedSellOrders,'TotalInvestorExecutedSellOrdersValue'=>$TotalInvestorExecutedSellOrdersValue);
		}
		
		echo json_encode($ret);
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
		
		
		$data['RequestListing']='0'; $data['PublishWork']='0'; $data['RegisterBroker']='0'; 
		$data['BuyToken']='0'; $data['SellToken']='0'; $data['ViewPrices']='0'; $data['ViewOrders']='0';
		$data['ViewOffers']='0'; $data['SetPrices']='0';
		
		
		$data['userlogo'] = '';
		
		if ($_SESSION['email'])
		{
			$data['email']=trim($_SESSION['email']);
			
			$user=$this->getdata_model->GetUserDetails($data['email']);
								
			#User Info
			if ($user->fullname) $data['fullname'] = trim($user->fullname);
			if ($user->company) $data['company'] = trim($user->company);
			if ($user->accountstatus) $data['accountstatus'] = $user->accountstatus;
			if ($user->datecreated) $data['datecreated'] = $user->datecreated;
			if ($user->usertype) $data['usertype'] = trim($user->usertype);
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
			
			//Remind broker/investor to update bank details			
			$rc=trim($this->getdata_model->GetRecipientCode($data['email'],$data['usertype']));
		
			if ($rc <> '')
			{
				if (trim(strtolower($data['usertype']))=='investor')
				{
					$data['TotalInvestorSecurities'] = $this->getdata_model->GetTotalInvestorSecurities($data['email']);
					$data['TotalInvestorSecuritiesValue'] = $this->getdata_model->GetTotalInvestorSecuritiesValue($data['email']);
					
					$data['TotalInvestorPrimaryTrades'] = $this->getdata_model->GetTotalInvestorPrimaryTrades($data['email']);
					$data['TotalInvestorPrimaryTradesValue'] = $this->getdata_model->GetTotalInvestorPrimaryTradesValue($data['email']);
					
					$data['TotalInvestorSellOrders'] = $this->getdata_model->GetTotalInvestorSellOrders($data['email']);
					$data['TotalInvestorSellOrdersValue'] = $this->getdata_model->GetTotalInvestorSellOrdersValue($data['email']);
					
					
					$data['TotalInvestorExecutedSellOrders'] = $this->getdata_model->GetTotalInvestorExecutedSellOrders($data['email']);
					$data['TotalInvestorExecutedSellOrdersValue'] = $this->getdata_model->GetTotalInvestorExecutedSellOrdersValue($data['email']);
					$data['LastestPixs'] = $this->getdata_model->GetLatestListings();
					
					$this->load->view('ui/dashboardiv_view',$data);
				}elseif (trim(strtolower($data['usertype']))=='issuer')
				{
					//Get Issuer Details
					$rw=$this->getdata_model->GetIssuerDetails($data['email']); //Issuer Details
			
					if ($rw->uid) $data['issuer_id'] = $rw->uid; else $data['issuer_id']='';
					
					$data['TotalIssuerListedSecurities'] = $this->getdata_model->GetTotalIssuerListedSecurities($data['issuer_id']);					
					$data['TotalIssuerListedSecuritiesValue'] = $this->getdata_model->GetTotalIssuerListedSecuritiesValue($data['email']);
					
					$data['TotalIssuerExecutedPrimaryTrades'] = $this->getdata_model->GetTotalIssuerExecutedPrimaryTrades($data['email']);
					$data['TotalIssuerExecutedPrimaryTradesValue'] = $this->getdata_model->GetTotalIssuerExecutedPrimaryTradesValue($data['email']);
					
					$data['TotalIssuerCurrentlyListedSecurities'] = $this->getdata_model->GetTotalIssuerCurrentlyListedSecurities($data['issuer_id']);
					$data['TotalIssuerCurrentlyListedSecuritiesValue'] = $this->getdata_model->GetTotalIssuerCurrentlyListedSecuritiesValue($data['email']);
					$data['LastestPixs'] = $this->getdata_model->GetLatestListings();
					// print_r($data);
					// die();
					$this->load->view('ui/dashboardiv_view',$data);
				}				
			}else
			{
				$m="Your account details (<b>account name, account number and bank name</b>) have not been set on Naija Art Mart. Please do that now so that you can trade on the platform.";
						
				$_SESSION['set_rc']=$m;
				
				if (trim(strtolower($data['usertype']))=='broker')
				{
					redirect('ui/Userprofile','refresh');
				}else
				{
					redirect('ui/Userprofileiv','refresh');
				}				
			}			
		}else
		{
			$this->getdata_model->GoToLogin('');
		}
	}
}
