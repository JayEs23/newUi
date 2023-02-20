<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tradinggateway extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	
	
	//Receives orders from brokers and forwards the request to the matching engine if it passes validation.
	//Update is sent to broker/investor informing of order status
	function DirectProcess()
	{			
		$ChangePriceQty=''; $order=array();
		
		if ($this->input->post('order')) $order = $this->input->post('order');
		if ($this->input->post('changeprice')) $ChangePriceQty = trim($this->input->post('changeprice'));
		
		$transtype = trim(ucwords($order['transtype']));
		
		$header=''; $details=''; $msgtype='system,sms';
		$emails=$order['broker_email'].','.$order['investor_email'];
		$groups='';
		
		$category='Message';
		$expiredate=NULL;
		$display_status=1;
		$sender='System';
		
		$phones=$order['broker_phone'].','.$order['investor_phone'];
		
		//Send submit message
		$header='Sell Order Submitted';
			
		$details="Sell order for ".$order['qty']." tokens of ".$order['symbol']." was been placed successfully at ".date('H:i:s',strtotime($order['orderdate']))." on ".date('l, F d, Y',strtotime($order['orderdate'])).". Order id is ".$order['order_id'].".";
		
		$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);		
		
		$ret 			= $this->getdata_model->SaveDirectOrder($order);//Save Order		
		$result 		= $this->getdata_model->DirectMatchingEngine($order,$ChangePriceQty);
			
		//Send Message
		$details='';
		$msgtype='system';
		
		
		if (floatval($order['sms_fee']) > 0) $msgtype .= ',sms';			
		
		$header='Trading Report'; $groups='';
		$emails=$order['broker_email'].','.$order['investor_email'];
		$phones=$order['broker_phone'].','.$order['investor_phone'];
		$category='Message';  $expiredate=date('Y-m-d H:i:s',strtotime('+3 days')); $display_status=1; $sender='System';
		
		if ($result['Status']==1)//Trade Success
		{
			$msgtype .= ',email';
			$details = $result['msg']." Trade Id is ".$result['trade_id'].".";
			$res = $this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
			
			//Send Message to transacting partners - transact_partners
			//$transact_partners= array("symbol","broker_id","investor_id","qty","price",'sms_fee','transtype');
			$partners=$result['transact_partners'];
			
			if (count($partners) > 0)
			{
				foreach($partners as $part):
					if (count($part) > 0)
					{
						$symbol = $part['symbol'];  			$broker_id = $part['broker_id'];
						$investor_id = $part['investor_id'];  	$price = $part['price'];
						$qty = $part['qty'];  					$sms_fee = $part['sms_fee'];
						$ttype = $part['transtype'];
						
						//Get phones and emails
						$det = $this->getdata_model->GetBrokerDetails($broker_id);
						if ($det->email) $brokeremail = trim($det->email);
						if ($det->phone) $brokerphone = trim($det->phone);
						
						$inv = $this->getdata_model->GetInvestorDetails($investor_id);
						if ($inv->email) $investor_email = trim($inv->email);
						if ($inv->phone) $investor_phone = trim($inv->phone);
						
						if (trim(strtolower($ttype)) == 'buy')
						{
							$details="Trade Was Successful. ".number_format($qty,0)." Tokens Of ".$symbol." Was Bought At NGN".number_format($price,2)." Per Token. Trade Id Is ".$result['trade_id'];
						}elseif (trim(strtolower($ttype)) == 'sell')
						{
							$details="Trade Was Successful. ".number_format($qty,0)." Tokens Of ".$symbol." Was Sold At NGN ".number_format($price,2)." Per Token. Trade Id Is ".$result['trade_id'];
						}							
						
						$msgtype='system,email';
						$emails=$brokeremail.','.$investor_email;
						$phones=$brokerphone.','.$investor_phone;
													
						if (floatval($part['sms_fee']) > 0) $msgtype .= ',sms';
						
						$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
					}
				endforeach;
			}
		}elseif (strtolower(trim($result['Status'])) == 'queued')//Order Queued
		{
			$header=$transtype.' Order Report';
			$details=$result['msg'];
			
			$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
		}elseif (strtolower(trim($result['Status']))=='fail')//Trade Failed
		{
			$details=$result['msg'];
			
			$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
		}		
				
		//return true;
	}
	
	function Process()
	{			
		$ChangePriceQty=''; $order=array();
		
		if ($this->input->post('order')) $order = $this->input->post('order');
		if ($this->input->post('changeprice')) $ChangePriceQty = trim($this->input->post('changeprice'));
		
		$transtype = trim(ucwords($order['transtype']));
		
		$header=''; $details=''; $msgtype='system';
		$emails=$order['broker_email'].','.$order['investor_email'];
		$groups='';
		
		if (floatval($order['sms_fee'])>0) $msgtype .= ',sms';
		
		$category='Message';
		$expiredate=NULL;
		$display_status=1;
		$sender='System';
		
		$phones=$order['broker_phone'].','.$order['investor_phone'];
		
		//Send submit message
		if (strtolower($transtype)=='buy')
		{
			$header = 'Buy Order Submitted';
			
			$details = "Buy order for ".$order['qty']." tokens of ".$order['symbol']." was been placed successfully at ".date('H:i:s',strtotime($order['orderdate']))." on ".date('l, F d, Y',strtotime($order['orderdate'])).". Order id is ".$order['order_id'].".";	
		}elseif (strtolower($transtype)=='sell')
		{
			$header='Sell Order Submitted';
			
			$details="Sell order for ".$order['qty']." tokens of ".$order['symbol']." was been placed successfully at ".date('H:i:s',strtotime($order['orderdate']))." on ".date('l, F d, Y',strtotime($order['orderdate'])).". Order id is ".$order['order_id'].".";
		}
		
		$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);	
		
		
		//$file = fopen('aaa.txt',"w"); fwrite($file,print_r("Change Price Qty = ".$ChangePriceQty."\r\nTrans Type = ".$transtype."\r\nInvestor Id = ".$order['investor_id']."\r\nOrder Type = ".$order['ordertype'],true)); fclose($file);
		
		$ret 			= $this->getdata_model->SaveOrder($order);//Save Order		
		$result 		= $this->getdata_model->MatchingEngine($order,$ChangePriceQty);
			
		//Send Message
		$details='';
		$msgtype='system';
		
		
		if (floatval($order['sms_fee']) > 0) $msgtype .= ',sms';			
		
		$header='Trading Report'; $groups='';
		$emails=$order['broker_email'].','.$order['investor_email'];
		$phones=$order['broker_phone'].','.$order['investor_phone'];
		$category='Message';  $expiredate=date('Y-m-d H:i:s',strtotime('+3 days')); $display_status=1; $sender='System';
		
		if ($result['Status']==1)//Trade Success
		{
			$msgtype .= ',email';
			$details = $result['msg']." Trade Id is ".$result['trade_id'].".";
			$res = $this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
			
			//Send Message to transacting partners - transact_partners
			//$transact_partners= array("symbol","broker_id","investor_id","qty","price",'sms_fee','transtype');
			$partners=$result['transact_partners'];
			
			if (count($partners) > 0)
			{
				foreach($partners as $part):
					if (count($part) > 0)
					{
						$symbol = $part['symbol'];  			$broker_id = $part['broker_id'];
						$investor_id = $part['investor_id'];  	$price = $part['price'];
						$qty = $part['qty'];  					$sms_fee = $part['sms_fee'];
						$ttype = $part['transtype'];
						
						//Get phones and emails
						$det = $this->getdata_model->GetBrokerDetails($broker_id);
						if ($det->email) $brokeremail = trim($det->email);
						if ($det->phone) $brokerphone = trim($det->phone);
						
						$inv = $this->getdata_model->GetInvestorDetails($investor_id);
						if ($inv->email) $investor_email = trim($inv->email);
						if ($inv->phone) $investor_phone = trim($inv->phone);
						
						if (trim(strtolower($ttype)) == 'buy')
						{
							$details="Trade Was Successful. ".number_format($qty,0)." Tokens Of ".$symbol." Was Bought At NGN".number_format($price,2)." Per Token. Trade Id Is ".$result['trade_id'];
						}elseif (trim(strtolower($ttype)) == 'sell')
						{
							$details="Trade Was Successful. ".number_format($qty,0)." Tokens Of ".$symbol." Was Sold At NGN ".number_format($price,2)." Per Token. Trade Id Is ".$result['trade_id'];
						}							
						
						$msgtype='system,email';
						$emails=$brokeremail.','.$investor_email;
						$phones=$brokerphone.','.$investor_phone;
													
						if (floatval($part['sms_fee']) > 0) $msgtype .= ',sms';
						
						$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
					}
				endforeach;
			}
		}elseif (strtolower(trim($result['Status'])) == 'queued')//Order Queued
		{
			$header=$transtype.' Order Report';
			$details=$result['msg'];
			
			$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
		}elseif (strtolower(trim($result['Status']))=='fail')//Trade Failed
		{
			$details=$result['msg'];
			
			$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
		}		
				
		//return true;
	}
	
	public function index()
	{
				
	}
}
