<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Tradingsettings extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
										
		#Load the getdata model to make it available to *all* of the controller's actions 
		$this->load->model('getdata_model');
	 }
	 
	 
	public function UpdateParameter()
	{		
		$market_start_time=''; $market_close_time=''; $min_buy_qty=''; $brokers_commission = '';
		$nse_commission=''; $price_limit_percent=''; $max_order_days=''; $sms_fee=''; $holdingperiod='';		
				
		if ($this->input->post('market_start_time')) $market_start_time = trim($this->input->post('market_start_time'));
		if ($this->input->post('market_close_time')) $market_close_time = trim($this->input->post('market_close_time'));
		if ($this->input->post('min_buy_qty')) $min_buy_qty = trim($this->input->post('min_buy_qty'));		
		if ($this->input->post('nse_commission')) $nse_commission = trim($this->input->post('nse_commission'));		
		if ($this->input->post('brokers_commission')) $brokers_commission = trim($this->input->post('brokers_commission'));		
		if ($this->input->post('price_limit_percent')) $price_limit_percent = trim($this->input->post('price_limit_percent'));
		if ($this->input->post('max_order_days')) $max_order_days = trim($this->input->post('max_order_days'));
		if ($this->input->post('sms_fee')) $sms_fee = trim($this->input->post('sms_fee'));
		if ($this->input->post('holdingperiod')) $holdingperiod = trim($this->input->post('holdingperiod'));
				
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
		//Check if record exists
		$sql = "SELECT * FROM trading_parameters";

		$query = $this->db->query($sql);
				
		if ($query->num_rows() == 0 )
		{
			$this->db->trans_start();
					
			$dat=array(
				'market_start_time' 	=> $this->db->escape_str($market_start_time),
				'market_close_time'	 	=> $this->db->escape_str($market_close_time),
				'min_buy_qty'			=> $this->db->escape_str($min_buy_qty),
				'nse_commission' 		=> $this->db->escape_str($nse_commission),				
				'brokers_commission'	=> $this->db->escape_str($brokers_commission),
				'price_limit_percent' 	=> $this->db->escape_str($price_limit_percent),
				'sms_fee' 				=> $this->db->escape_str($sms_fee),
				'holdingperiod' 		=> $this->db->escape_str($holdingperiod),
				'max_order_days'	 	=> $this->db->escape_str($max_order_days)			
			);
			
			$this->db->insert('trading_parameters', $dat);
			
			$this->db->trans_complete();
			
			$Msg='';	
			
			if ($this->db->trans_status() === FALSE)
			{
				$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted inserting trading parameters but failed.";
				
				$ret = 'Trading Parameters Was Not Inserted.';
			}else
			{				
				$Msg="Trading Parameters Was Inserted Successfully.";				
				
				$ret ='OK';	
				
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'INSERTED TRADING PARAMETERS RECORD',$_SESSION['LogID']);
			}
		}else
		{
			$st=''; $ct=''; $qty=''; $nc=''; $bc=''; $lmt=''; $dys=''; $sms=''; $hp='';
						
			$row = $query->row();			
			
			if ($row->market_start_time) $st=trim($row->market_start_time);
			if ($row->market_close_time) $ct=trim($row->market_close_time);
			if ($row->min_buy_qty) $qty=trim($row->min_buy_qty);
			if ($row->nse_commission) $nc=trim($row->nse_commission);			
			if ($row->brokers_commission) $bc=trim($row->brokers_commission);			
			if ($row->price_limit_percent) $lmt=trim($row->price_limit_percent);
			if ($row->max_order_days) $dys=trim($row->max_order_days);
			if ($row->sms_fee) $sms=trim($row->sms_fee);	
			if ($row->holdingperiod) $hp=trim($row->holdingperiod);			
						
			$OldValues="Market Starting Time = ".$st."; Market Closing Time = ".$ct."; Minimum Buy Quantity = ".$qty."; NSE Commission = ".$nc."; Broker's Commission = ".$bc."; Price Limit Percentage = ".$lmt."; Maximum No. Of Days For Infinite Orders Like Good Till Cancelled (GTC) = ".$dys."; SMS Fee = ".$sms."; Holding Period = ".$hp;
			
			$NewValues="Market Starting Time = ".$market_start_time."; Market Closing Time = ".$market_close_time."; Minimum Buy Quantity  = ".$min_buy_qty."; NSE Commission = ".$nse_commission."; Broker's Commission = ".$brokers_commission."; Price Limit Percentage = ".$price_limit_percent."; Maximum No. Of Days For Infinite Orders Like Good Till Cancelled (GTC) = ".$max_order_days."; SMS Fee = ".$sms_fee."; Holding Period = ".$holdingperiod;
			
			$dat=array(
				'market_start_time' 	=> $this->db->escape_str($market_start_time),
				'market_close_time'	 	=> $this->db->escape_str($market_close_time),
				'min_buy_qty'			=> $this->db->escape_str($min_buy_qty),
				'nse_commission' 		=> $this->db->escape_str($nse_commission),				
				'brokers_commission'	=> $this->db->escape_str($brokers_commission),
				'price_limit_percent' 	=> $this->db->escape_str($price_limit_percent),
				'sms_fee' 				=> $this->db->escape_str($sms_fee),
				'holdingperiod' 		=> $this->db->escape_str($holdingperiod),
				'max_order_days' 		=> $this->db->escape_str($max_order_days)			
			);
			
			#Update
			$this->db->trans_start();
			$this->db->update('trading_parameters', $dat);			
			$this->db->trans_complete();
						
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{
				$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted updating trading parameters but failed.";
								
				$ret = 'Trading Parameters Could Not Be Edited.';
			}else
			{
				$Msg="Trading parameters has been edited successfully by ".strtoupper($_SESSION['fullname'].'('.$_SESSION['email'])."). Old Values => ".$OldValues.". Updated values => ".$NewValues;				
				
				$ret ='OK';
			
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'EDITED TRADING PARAMETERS RECORD',$_SESSION['LogID']);	
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
			$set = $this->getdata_model->GetTradingParamaters();
				
			if ($set->min_buy_qty) $data['min_buy_qty'] = $set->min_buy_qty; else $data['min_buy_qty'] ='';
			
			if ($set->price_limit_percent) $data['price_limit_percent'] = $set->price_limit_percent; else $data['price_limit_percent']='';
			
			if ($set->brokers_commission) $data['brokers_commission'] = $set->brokers_commission; else $data['brokers_commission'] = '';
			
			if ($set->nse_commission) $data['nse_commission'] = $set->nse_commission; else $data['nse_commission'] = '';
			
			if ($set->market_start_time) $data['market_start_time'] = $set->market_start_time; else $data['market_start_time'] = '';
			
			if ($set->market_close_time) $data['market_close_time'] = $set->market_close_time; else $data['market_close_time'] = '';
			
			if ($set->max_order_days) $data['max_order_days'] = $set->max_order_days; else $data['max_order_days'] = '';
			
			if ($set->sms_fee) $data['sms_fee'] = $set->sms_fee; else $data['sms_fee'] = '';
			if ($set->holdingperiod) $data['holdingperiod'] = $set->holdingperiod; else $data['holdingperiod'] = '';
				
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
			
			$this->load->view('admin/tradingsettings_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
