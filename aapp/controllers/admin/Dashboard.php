<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	 }
	 
	 function BackupDb()
	 {
		$ret=$this->getdata_model->BackupDB();
		
		if ($ret) $ret='OK'; else $ret='Database backup was not successful.';
		
		echo $ret;
	 }
	 
	 function GetAdminMessages()
	 {
		$email=''; $usertype='';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		
		$ret=$this->getdata_model->GetQueuedMessages($email,$usertype);
		
		echo json_encode($ret);
	 }
	 
	 function GetMessages()
	 {
		$email=''; $usertype='';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		
		$ret=$this->getdata_model->GetUserMessages($email,$usertype);
		
		echo json_encode($ret);
	 }
	 
	 function GetPricesAndStatus()
	 {
		$ret=$this->getdata_model->GetMarketStatus();
		$MarketStatus=$ret['MarketStatus'];
		$ScrollingPrices=$this->getdata_model->MarketData();
		
		echo json_encode(array('MarketStatus'=>$MarketStatus, 'ScrollingPrices'=>$ScrollingPrices));
	 }
	
	
	function GetSummary()
	{
		$usertype='';
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
	
			
		if (trim(strtolower($usertype))=='admin')
		{
			$TotalAdminTradeOrders='0'; $TotalAdminListedSecurities='0';
			$TotalAdminSecondaryTrades='0'; $TotalAdminPrimaryTrades='0';
			$TotalAdminSecondaryMarketSecurities='0'; $TotalAdminPrimaryMarketSecurities='0';
			$TotalAdminApprovedSecurities='0'; $TotalAdminListedSecuritiesAwaitingApproval='0';
			$TotalAdminDayMarketValue='0'; $TotalAdminTotalMarketValue='0';
			
			$TotalAdminTradeOrders=$this->getdata_model->GetTotalAdminTradeOrders();				
			$TotalAdminListedSecurities=$this->getdata_model->GetTotalAdminListedSecurities();
			
			$TotalAdminSecondaryTrades=$this->getdata_model->GetTotalAdminSecondaryTrades();
			$TotalAdminPrimaryTrades=$this->getdata_model->GetTotalAdminPrimaryTrades();
			
			$TotalAdminSecondaryMarketSecurities=$this->getdata_model->GetTotalAdminSecondaryMarketSecurities();
			$TotalAdminPrimaryMarketSecurities=$this->getdata_model->GetTotalAdminPrimaryMarketSecurities();
			
			$TotalAdminApprovedSecurities=$this->getdata_model->GetTotalAdminApprovedSecurities();
			$TotalAdminListedSecuritiesAwaitingApproval=$this->getdata_model->GetTotalAdminListedSecuritiesAwaitingApproval();
	
			$TotalAdminDayMarketValue=$this->getdata_model->ComputeDateTradeValue(date('Y-m-d'));
			$TotalAdminTotalMarketValue=$this->getdata_model->ComputeTotalTradeValue();
			
			$ret=array('TotalAdminTradeOrders'=>$TotalAdminTradeOrders,'TotalAdminListedSecurities'=>$TotalAdminListedSecurities,'TotalAdminSecondaryTrades'=>$TotalAdminSecondaryTrades,'TotalAdminPrimaryTrades'=>$TotalAdminPrimaryTrades,'TotalAdminSecondaryMarketSecurities'=>$TotalAdminSecondaryMarketSecurities,'TotalAdminPrimaryMarketSecurities'=>$TotalAdminPrimaryMarketSecurities,'TotalAdminApprovedSecurities'=>$TotalAdminApprovedSecurities,'TotalAdminListedSecuritiesAwaitingApproval'=>$TotalAdminListedSecuritiesAwaitingApproval,'TotalAdminDayMarketValue'=>$TotalAdminDayMarketValue,'TotalAdminTotalMarketValue'=>$TotalAdminTotalMarketValue);
			
		}elseif (trim(strtolower($usertype))=='operator')
		{
			$TotalOperatorTradeOrders='0'; $TotalOperatorListedSecurities='0';
			$TotalOperatorSecondaryTrades='0'; $TotalOperatorPrimaryTrades='0';
			$TotalOperatorSecondaryMarketSecurities='0'; $TotalOperatorPrimaryMarketSecurities='0';
			$TotalOperatorDayMarketValue='0'; $TotalOperatorTotalMarketValue='0';
			
			$TotalOperatorTradeOrders=$this->getdata_model->GetTotalAdminTradeOrders();				
			$TotalOperatorListedSecurities=$this->getdata_model->GetTotalAdminListedSecurities();
			
			$TotalOperatorSecondaryTrades=$this->getdata_model->GetTotalAdminSecondaryTrades();
			$TotalOperatorPrimaryTrades=$this->getdata_model->GetTotalAdminPrimaryTrades();
			
			$TotalOperatorSecondaryMarketSecurities=$this->getdata_model->GetTotalAdminSecondaryMarketSecurities();
			$TotalOperatorPrimaryMarketSecurities=$this->getdata_model->GetTotalAdminPrimaryMarketSecurities();
			
			$TotalOperatorDayMarketValue=$this->getdata_model->ComputeDateTradeValue(date('Y-m-d'));
			$TotalOperatorTotalMarketValue=$this->getdata_model->ComputeTotalTradeValue();
			
			$ret=array('TotalOperatorTradeOrders'=>$TotalOperatorTradeOrders,'TotalOperatorListedSecurities'=>$TotalOperatorListedSecurities,'TotalOperatorSecondaryTrades'=>$TotalOperatorSecondaryTrades,'TotalOperatorPrimaryTrades'=>$TotalOperatorPrimaryTrades,'TotalOperatorSecondaryMarketSecurities'=>$TotalOperatorSecondaryMarketSecurities,'TotalOperatorPrimaryMarketSecurities'=>$TotalOperatorPrimaryMarketSecurities,'TotalOperatorDayMarketValue'=>$TotalOperatorDayMarketValue,'TotalOperatorTotalMarketValue'=>$TotalOperatorTotalMarketValue);
			
		}elseif (trim(strtolower($usertype))=='gallery')
		{
			$TotalGalleryListedSecurities='0'; $TotalGalleryPrimaryMarketSecurities='0';
			$TotalGalleryApprovedSecurities='0'; $TotalGalleryListedSecuritiesAwaitingApproval='0';
			$TotalGalleryDayMarketValue='0'; $TotalGalleryTotalMarketValue='0';
			
			$TotalGalleryListedSecurities=$this->getdata_model->GetTotalAdminListedSecurities();			
			$TotalGalleryPrimaryMarketSecurities=$this->getdata_model->GetTotalAdminPrimaryMarketSecurities();
			
			$TotalGalleryApprovedSecurities=$this->getdata_model->GetTotalAdminApprovedSecurities();
			$TotalGalleryListedSecuritiesAwaitingApproval=$this->getdata_model->GetTotalAdminListedSecuritiesAwaitingApproval();
			
			$TotalGalleryDayMarketValue=$this->getdata_model->ComputeDateTradeValue(date('Y-m-d'));
			$TotalGalleryTotalMarketValue=$this->getdata_model->ComputeTotalTradeValue();
			
			
			$ret=array('TotalGalleryListedSecurities'=>$TotalGalleryListedSecurities,'TotalGalleryPrimaryMarketSecurities'=>$TotalGalleryPrimaryMarketSecurities,'TotalGalleryApprovedSecurities'=>$TotalGalleryApprovedSecurities,'TotalGalleryListedSecuritiesAwaitingApproval'=>$TotalGalleryListedSecuritiesAwaitingApproval,'TotalGalleryDayMarketValue'=>$TotalGalleryDayMarketValue,'TotalGalleryTotalMarketValue'=>$TotalGalleryTotalMarketValue);
		}
		
		echo json_encode($ret);
	}
	
	
	public function index()
	{
		if ($_SESSION['email'] <> '')
		{
			$data['fullname']=''; $data['email']=''; $data['phone']='';
			$data['accountstatus'] = ''; $data['usertype'] = ''; $data['datecreated'] = '';
			
			$data['CreateAccount']='0';
			$data['AddItem']='0'; $data['EditItem']='0'; $data['DeleteItem']='0'; $data['ClearLogFiles']='0';
			$data['ViewLogReports']='0'; $data['ViewReports']='0'; $data['SetParameters']='0';
			
			$data['SetMarketParameters']=''; $data['ViewOrders']=''; $data['ViewPrices']='';
			$data['BuyAndSellToken']=''; $data['RegisterBroker']=''; $data['PublishWork']='';
			$data['RequestListing']=''; $data['RefreshInterval']=5;
			
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
								
	//$file = fopen('aaa.txt',"w"); fwrite($file, $data['email']); fclose($file);
				
				if (trim(strtolower($data['usertype']))=='admin')
                {
					$data['TotalAdminTradeOrders']=$this->getdata_model->GetTotalAdminTradeOrders();				
					$data['TotalAdminListedSecurities']=$this->getdata_model->GetTotalAdminListedSecurities();
					
					$data['TotalAdminSecondaryTrades']=$this->getdata_model->GetTotalAdminSecondaryTrades();
					$data['TotalAdminPrimaryTrades']=$this->getdata_model->GetTotalAdminPrimaryTrades();
					
					$data['TotalAdminSecondaryMarketSecurities']=$this->getdata_model->GetTotalAdminSecondaryMarketSecurities();
					$data['TotalAdminPrimaryMarketSecurities']=$this->getdata_model->GetTotalAdminPrimaryMarketSecurities();
					
					$data['TotalAdminApprovedSecurities']=$this->getdata_model->GetTotalAdminApprovedSecurities();
					$data['TotalAdminListedSecuritiesAwaitingApproval']=$this->getdata_model->GetTotalAdminListedSecuritiesAwaitingApproval();
						
					$data['TotalAdminDayMarketValue']=$this->getdata_model->ComputeDateTradeValue(date('Y-m-d'));
					$data['TotalAdminTotalMarketValue']=$this->getdata_model->ComputeTotalTradeValue();
											 
				}elseif (trim(strtolower($data['usertype']))=='operator')
                {
					$data['TotalOperatorTradeOrders']=$this->getdata_model->GetTotalAdminTradeOrders();				
					$data['TotalOperatorListedSecurities']=$this->getdata_model->GetTotalAdminListedSecurities();
					
					$data['TotalOperatorSecondaryTrades']=$this->getdata_model->GetTotalAdminSecondaryTrades();
					$data['TotalOperatorPrimaryTrades']=$this->getdata_model->GetTotalAdminPrimaryTrades();
					
					$data['TotalOperatorSecondaryMarketSecurities']=$this->getdata_model->GetTotalAdminSecondaryMarketSecurities();
					$data['TotalOperatorPrimaryMarketSecurities']=$this->getdata_model->GetTotalAdminPrimaryMarketSecurities();
					
					$data['TotalOperatorDayMarketValue']=$this->getdata_model->ComputeDateTradeValue(date('Y-m-d'));
					$data['TotalOperatorTotalMarketValue']=$this->getdata_model->ComputeTotalTradeValue();
					
				}elseif (trim(strtolower($data['usertype']))=='gallery')
                {
					$data['TotalGalleryListedSecurities']=$this->getdata_model->GetTotalAdminListedSecurities();			
					$data['TotalGalleryPrimaryMarketSecurities']=$this->getdata_model->GetTotalAdminPrimaryMarketSecurities();
					
					$data['TotalGalleryApprovedSecurities']=$this->getdata_model->GetTotalAdminApprovedSecurities();
					$data['TotalGalleryListedSecuritiesAwaitingApproval']=$this->getdata_model->GetTotalAdminListedSecuritiesAwaitingApproval();
					
					$data['TotalGalleryDayMarketValue']=$this->getdata_model->ComputeDateTradeValue(date('Y-m-d'));
					$data['TotalGalleryTotalMarketValue']=$this->getdata_model->ComputeTotalTradeValue();
				}
								
				
				$ret=$this->getdata_model->GetMarketStatus();				
				$data['MarketStatus']=$ret['MarketStatus'];
		
				$data['ScrollingPrices']=$this->getdata_model->MarketData();
				
				//Remind broker/investor to update bank details
				if (strtolower(trim($data['usertype'])) == 'admin')
				{
					$rc=trim($this->getdata_model->GetNSERecipientCode($data['usertype']));
					
					if ($rc <> '')
					{
						$this->load->view('admin/dashboard_view',$data);
					}else
					{
						$m="NSE account details (<b>account name, account number and bank name</b>) have not been set on Naija Art Mart. Please do that now so that trade can go on successfully on the platform.";
						
						$_SESSION['set_rc']=$m;
						
						redirect('admin/Settings','refresh');
					}
				}else
				{
					$this->load->view('admin/dashboard_view',$data);
				}
			}else
			{
				$this->getdata_model->GoToLogin('admin');
			}	
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}		
	}
}
