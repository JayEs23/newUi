<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Africa/Lagos');

class Portfolio extends CI_Controller {
	function __construct() 
	{
		parent::__construct();		
		$this->load->helper('url');
		$this->load->model('getdata_model');
	}
	
	public function GetPortfolios()
	{
		$email=''; $usertype='';
						
		if ($this->input->post('email')) $email = $this->input->post('email');
		if ($this->input->post('usertype')) $usertype = $this->input->post('usertype');
		
		if (trim(strtolower($usertype)) == 'investor')
		{
			$qry = "SELECT portfolios.*, (SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(portfolios.symbol) LIMIT 0,1) AS art_title FROM portfolios WHERE (TRIM(email)='".$this->db->escape_str($email)."') ORDER BY symbol";
		}elseif (trim(strtolower($usertype)) == 'broker')
		{
			$broker_details = $this->getdata_model->GetBrokerDetails($email);
					
			$em=''; $brokerid='';
			
			if ($broker_details->email) $em = trim($broker_details->email);
			if ($broker_details->broker_id) $brokerid = trim($broker_details->broker_id);
			
			$qry = "SELECT portfolios.*, (SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(portfolios.symbol) LIMIT 0,1) AS art_title FROM portfolios WHERE (TRIM(email)='".$this->db->escape_str($email)."') OR (TRIM(broker_id)='".$this->db->escape_str($brokerid)."') ORDER BY symbol";	
		}
		

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array();

		foreach($results as $row):	
			$cp='-';
			$llnk = '<a href="'.site_url('ui/ArtworkDetails/Market/').$row['symbol'].'" class="btn btn-sm btn-success">Sell</a>';
			
			if (floatval($row['currentprice']) > 0) $cp='₦'.number_format($row['currentprice'],2);
							
			$tp=array($row['email'],$row['symbol'].' ('.$row['art_title'].')',number_format($row['tokens'],0),'₦'.number_format($row['price_bought'],2),$cp,date('d M Y @ H:i:s',strtotime($row['date_updated'])),$llnk);
			
			$data[]=$tp;
		endforeach;

		print_r(json_encode($data));
	}
	
	 
	public function index()
	{
		$data['lastname']=''; $data['firstname']=''; $data['email']=''; $data['phone']=''; $data['pix']='';
		$data['accountstatus'] = ''; $data['usertype'] = ''; $data['pix'] = ''; $data['company']='';
		
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
						
			$this->load->view('ui/portfolio_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('');
		}
	}
}
