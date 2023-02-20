<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('assets/vendor/autoload.php');

class Paystacktransstatus extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	 }
	
		
	function GetTransactionStatus()
	{
		$event='';
		
		if ($this->input->post('event')) $event = trim($this->input->post('event'));
		
		$sql = "SELECT * FROM webhook_log WHERE (TRIM(event)='".$this->db->escape_str($event)."') ORDER BY created_at DESC";											

		$query = $this->db->query(stripslashes($sql));	

		$results = $query->result_array();		

		if ($results)
		{
			$data=array();

			if (is_array($results))
			{
				$sn=0;
				
				foreach($results as $row):
					$sn++; $sel=''; $cdt=''; $pdt=''; $tdt=''; $udt='';
					
					if ($row['paid_at']) $pdt=date('d M Y H:i',strtotime($row['paid_at']));
					if ($row['transferred_at']) $tdt=date('d M Y H:i',strtotime($row['transferred_at']));
					if ($row['created_at']) $cdt=date('d M Y H:i',strtotime($row['created_at']));
					if ($row['updated_at']) $udt=date('d M Y H:i',strtotime($row['updated_at']));
					
//event,domain,`status`,reference,amount,message,gateway_response,paid_at,channel,currency,user_ip_address,paystack_ip_address,fees,`bin`,last4,card_type,bank,country_code,brand,customer_email,reason,transfer_code,transferred_at,recipient_code,recipient_email,recipient_name,account_name,account_number,bank_code,bank_name,provider,session_id,failures,created_at,updated_at
					
					$sel='<img onClick="ViewRow(\''.$row['event'].'\',\''.$row['domain'].'\',\''.$row['status'].'\',\''.$row['reference'].'\',\''.$row['amount'].'\',\''.$row['message'].'\',\''.$row['gateway_response'].'\',\''.$pdt.'\',\''.$row['channel'].'\',\''.$row['currency'].'\',\''.$row['user_ip_address'].'\',\''.$row['paystack_ip_address'].'\',\''.$row['fees'].'\',\''.$row['bin'].'\',\''.$row['last4'].'\',\''.$row['card_type'].'\',\''.$row['bank'].'\',\''.$row['country_code'].'\',\''.$row['brand'].'\',\''.$row['customer_email'].'\',\''.$row['reason'].'\',\''.$row['transfer_code'].'\',\''.$tdt.'\',\''.$row['recipient_code'].'\',\''.$row['recipient_email'].'\',\''.$row['recipient_name'].'\',\''.$row['account_name'].'\',\''.$row['account_number'].'\',\''.$row['bank_code'].'\',\''.$row['bank_name'].'\',\''.$row['provider'].'\',\''.$row['session_id'].'\',\''.$row['failures'].'\',\''.$cdt.'\',\''.$udt.'\')" style="cursor:pointer; height:30px; " src="'.base_url().'images/view_icon.png" title="Select Transaction Record">';
							
					$tp=array($cdt,$row['event'],$row['reference'],'₦'.number_format($row['amount'],2),$row['domain'],$row['paystack_ip_address'],$row['status'],$sel);
					
					$data[]=$tp;
				endforeach;
			}

			print_r(json_encode($data));
		}else
		{
			print_r(json_encode($results));
		}
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
			
			$this->load->view('admin/paystacktransstatus_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
