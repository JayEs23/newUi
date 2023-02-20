<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atest extends CI_Controller {
	private $reg_success=false;
	
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	}
	 
	public function index()
	{
		$set=$this->getdata_model->GetParamaters();
				
		if (intval($set->refreshinterval) > 0)
		{
			$data['RefreshInterval'] = $set->refreshinterval;
		}else
		{
			$data['RefreshInterval']=5;
		}
				
		$data['holidays']=$this->getdata_model->GetHolidays();
		
		
		
		/*$account_name='My Test Bank Account';
		$account_number='0000000000';
		$desc='Account Description';
		$bank_code='011';
		*/
		/*$recipients=array(
			'currency'=>$currency, 
			"source"=>"balance", 
			"transfers"=>array(
							array("amount" =>$nse_commission, "reason" => "Commission For Trading With Code ".$tradeid,  "recipient" => $nse_recipientcode),
							
							array("amount" =>$broker_commission, "reason" => "Commission For Trading With Code ".$tradeid,  "recipient" => $broker_recipientcode),
							
							array("amount" =>$investor_amount, "reason" => "Payment For Trade With Code ".$tradeid,  "recipient" => $investor_recipientcode)
							)
				);*/
		
		//$currency='NGN';
//		$tradeid='20200772-1';
//		$nse_commission=1000000;//kobo
//		$broker_commission=1500000;
//		$investor_amount=15000000;
//		
//		$nse_recipientcode='RCP_n73yiq9okhkghxp';
//		$broker_recipientcode='RCP_n73yiq9okhkghxp';
//		$investor_recipientcode='RCP_n73yiq9okhkghxp';
		
		/*$recipients=array(
			"currency"=>$currency,
			"source"=>"balance", 
			"transfers"=>array(
							array("amount"=>$nse_commission, "reason"=>"Commission For Trading With Code ".$tradeid, "recipient"=>$nse_recipientcode),							
							array("amount"=>$broker_commission, "reason"=>"Commission For Trading With Code ".$tradeid, "recipient"=>$broker_recipientcode),							
							array("amount"=>$investor_amount, "reason"=>"Payment For Trade With Code ".$tradeid, "recipient"=>$investor_recipientcode)
							)
				);
				
		$data_string = http_build_query($recipients);*/
		
					
		//$data['Transfer']=$this->getdata_model->PaystackBulkTransferFunds($data_string);
		
		//$data['TransferRecipient']=$this->getdata_model->CreatePaystackTransferRecipient($account_name,$account_number, $desc,$bank_code,$currency);
		
		
		$broker_id='C235678AB';
		$investor_id='idongesit@gmail.com';
		$symbol="ROYALT";
		$transtype='Buy';
		$price='4900';
		$qty=130;
		$ordertype='GTM';
		$expirydate='Jan 2021';
		
		$broker_id='C123567AB';
		$investor_id='idongesit_a@yahoo.com';
		$symbol="ROYALT";
		$transtype='Buy';
		$price='4750';
		$qty=120;
		$ordertype='GTM';
		$expirydate='Jan 2021';
		
		//$broker_status=IsValidateBroker('idongakpan@brandstolife.com',$db);
				
		//echo GetMonthEnd('jan 2020');
		
		//print_r(IsValidateBroker('idongakpan@brandstolife.com',$db)); exit();
		
		$order=array('order_id'=>'','broker_id'=>$broker_id,'investor_id'=>$investor_id,'transtype'=>$transtype,'symbol'=>$symbol,'price'=>$price,'qty'=>$qty,'ordertype'=>$ordertype,'orderdate'=>'','expirydate'=>$expirydate,'orderstatus'=>'','canchangeprice'=>false,'broker_commission'=>'','nse_commission'=>'','transfer_fee'=>'','total_amount'=>'','trade_amount'=>'');
		
		$ret=$this->getdata_model->ValidateOrder($order);
		
		if ($ret['status']==1)
		{
			//$res=$this->getdata_model->SaveOrder($ret['order']);//Store Order
			
			if ($res)
			{
				//$res = $this->getdata_model->MatchineEngine($ret['order']);
				
				//Send Message To Broker/Investor	
			}else
			{
				
			}	
		}else
		{
			//$data['ret'] = $ret['msg'];
		}
		
	$GLOBALS['OrderBook']=array('Buy','Sell'=>array('Qty'=>50,'price'=>4500));
		
		//$data['CloseMarket']= $this->getdata_model->SetDayPrice();
		
		//$data['OrderBook'] = $this->getdata_model->GetOrderBook($symbol);
		
		$today=date('Y-m-d');
		$yesterday=date('Y-m-d',strtotime('yesterday'));
		//$data['returnvalue'] = $this->getdata_model->SetDayPrice();

		
		$this->load->view('admin/atest_view',$data);#Fail Page
		
		//$this->reg_success=true;
		//$this->user='User';
		
		/*if ($this->reg_success==true)
		{
			$data['RegisterInfo']='<strong>Congratulations!</strong> You have successfully activated your Naija Art Mart account. Click <a href="'.site_url("ui/Login").'">HERE</a> to go to the log in page.';
			
			$this->load->view('ui/registersuccess_view',$data);#Success Page
		}else
		{
			$data['RegisterInfo']='<strong>Sorry!</strong> Your Naija Art Mart account activation was not successful. Click <a href="'.site_url("ui/Home").'">HERE</a> to go to home page.';
			
			$this->load->view('ui/registerfail_view',$data);#Fail Page
		}*/
	}
}
