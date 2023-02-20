<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('assets/vendor/autoload.php');

class Viewtrades extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	 }
	 
	function GetIssuers()
	{
		$sql="SELECT user_name,email FROM issuers WHERE (accountstatus=1) ORDER BY user_name";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetInvestors
	
	function GetPrimaryTrades()
	{
		$startdate=''; $enddate=''; $issuer=''; $status='0';
		
		if ($this->input->post('status')) $status = $this->input->post('status');
		if ($this->input->post('issuer')) $issuer = trim($this->input->post('issuer'));
		if ($this->input->post('startdate')) $startdate = $this->input->post('startdate');
		if ($this->input->post('enddate')) $enddate = $this->input->post('enddate');
		
		if (trim($issuer) <> '')
		{
			if (strtoupper(trim($status))=='ALL')
			{
				$qry = "SELECT * FROM primary_trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND (TRIM(issuer_email)='".$this->db->escape_str($issuer)."') ORDER BY tradedate DESC";
			}else
			{
				if (trim($status)=='1')
				{
					$qry = "SELECT * FROM primary_trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND (TRIM(issuer_email)='".$this->db->escape_str($issuer)."') AND (tradestatus=1) ORDER BY tradedate DESC";
				}elseif (trim($status)=='0')
				{
					$qry = "SELECT * FROM primary_trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND (TRIM(issuer_email)='".$this->db->escape_str($issuer)."') AND (tradestatus<>1) ORDER BY tradedate DESC";
				}	
			}
		}else
		{
			if (strtoupper(trim($status))=='ALL')
			{
				$qry = "SELECT * FROM primary_trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') ORDER BY tradedate DESC";
			}else
			{
				if (trim($status)=='1')
				{
					$qry = "SELECT * FROM primary_trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND (tradestatus=1) ORDER BY tradedate DESC";
				}elseif (trim($status)=='0')
				{
					$qry = "SELECT * FROM primary_trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND (tradestatus=0) ORDER BY tradedate DESC";
				}	
			}
		}

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array();

		foreach($results as $row):
			$dt=''; $qty=''; $pr=''; $amt=0; $seller_email=''; $buyer_email='';
			
			if ($row['tradedate']) $dt=date('d M Y H:i',strtotime($row['tradedate']));			
			if (intval($row['num_tokens']) > 0) $qty=number_format($row['num_tokens'],0);			
			if (floatval($row['trade_price']) > 0) $pr='₦'.number_format($row['trade_price'],2);
			
			$amt = intval($row['num_tokens']) * floatval($row['trade_price']);			
			$amt = '₦'.number_format($amt,2);
			
			$r=$this->getdata_model->GetOrderDetails($row['sell_order_id']);
			if ($r->investor_id) $seller_email = trim($r->investor_id);
			
			$r=$this->getdata_model->GetOrderDetails($row['buy_order_id']);
			if ($r->investor_id) $buyer_email = trim($r->investor_id);

			$tp=array($dt,$row['trade_id'],$row['symbol'],$qty,$pr,$amt,$row['issuer_email'],$row['buy_investor_email']);
			
			$data[]=$tp;
		endforeach;

		print_r(json_encode($data));
	}
	
	function GetSecondaryTrades()
	{
		$startdate=''; $enddate=''; $status='0';
		
		if ($this->input->post('status')) $status = $this->input->post('status');
		if ($this->input->post('startdate')) $startdate = $this->input->post('startdate');
		if ($this->input->post('enddate')) $enddate = $this->input->post('enddate');
		
		if (strtoupper(trim($status))=='ALL')
		{
			$qry = "SELECT * FROM trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') ORDER BY tradedate DESC";
		}else
		{
			if (trim($status)=='1')
			{
				$qry = "SELECT * FROM trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND (tradestatus=1) ORDER BY tradedate DESC";
			}elseif (trim($status)=='0')
			{
				$qry = "SELECT * FROM trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND (tradestatus<>1) ORDER BY tradedate DESC";
			}	
		}

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array();

		foreach($results as $row):
			$dt=''; $qty=''; $pr=''; $amt=0; $seller_email=''; $buyer_email='';
			
			if ($row['tradedate']) $dt=date('d M Y H:i',strtotime($row['tradedate']));			
			if (intval($row['num_tokens']) > 0) $qty=number_format($row['num_tokens'],0);			
			if (floatval($row['trade_price']) > 0) $pr='₦'.number_format($row['trade_price'],2);
			
			$amt = intval($row['num_tokens']) * floatval($row['trade_price']);			
			$amt = '₦'.number_format($amt,2);
			
			if (strtolower(trim($row['engine_type'])) == 'direct')
			{
				$r=$this->getdata_model->GetDirectOrderDetails($row['sell_order_id']);
				
				if ($r->sell_investor_email) $seller_email = trim($r->sell_investor_email);				
				if ($r->buy_investor_email) $buyer_email = trim($r->buy_investor_email);	
			}elseif (strtolower(trim($row['engine_type'])) == 'automatic')
			{
				$r=$this->getdata_model->GetOrderDetails($row['sell_order_id']);
				if ($r->investor_id) $seller_email = trim($r->investor_id);
				
				$r=$this->getdata_model->GetOrderDetails($row['buy_order_id']);
				if ($r->investor_id) $buyer_email = trim($r->investor_id);	

			}			
			
					
			$tp=array($dt,$row['trade_id'],$row['symbol'],$qty,$pr,$amt,$seller_email,$buyer_email);
			
			$data[]=$tp;
		endforeach;

		print_r(json_encode($data));
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
			
			$this->load->view('admin/viewtrades_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
