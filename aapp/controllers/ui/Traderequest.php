<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");

date_default_timezone_set('Africa/Lagos');
set_time_limit(0);

require_once(realpath('.')."/vendor/autoload.php"); 

class Traderequest extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	
	public function GetSecondaryMarketData()
	{
		$usertype=''; $broker_id=''; $brokername=''; $investor_id='';
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));
		if ($this->input->post('investor_id')) $investor_id = trim($this->input->post('investor_id'));
		
		$ret=$this->getdata_model->GetMarketStatus();		
		$sta=$ret['MarketStatus'];
		
		$det = $this->getdata_model->GetBrokerDetails($broker_id);
		
		if ($det->company) $brokername = trim($det->company);
	
		if (trim(strtoupper($sta)) == 'OPEN')
		{
			$qry = "SELECT daily_price.*,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS title,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS creationyear,(SELECT tokens FROM portfolios WHERE (TRIM(portfolios.symbol)=TRIM(daily_price.symbol)) AND (TRIM(portfolios.uid)='".trim($investor_id)."')) AS availqty FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".date('Y-m-d')."') ORDER BY symbol";	
		}else
		{
			$latestdate=$this->getdata_model->GetLatestDate('historical_prices','price_date');			
			
			$qry="SELECT historical_prices.*,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS title,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS creationyear,(SELECT tokens FROM portfolios WHERE (TRIM(portfolios.symbol)=TRIM(historical_prices.symbol)) AND (TRIM(portfolios.uid)='".trim($investor_id)."') LIMIT 0,1) AS availqty FROM historical_prices WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".$latestdate."') ORDER BY symbol";	
		}

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array(); $sn=-1;

		foreach($results as $row):
			$act=''; $cp=''; $hp='-'; $lp='-'; $op='-'; $tra='-'; $vol='-'; $tp=array();
			
			if (floatval($row['open_price'])>0) $op='₦'.number_format($row['open_price'],2);			
			if (floatval($row['high_price'])>0) $hp='₦'.number_format($row['high_price'],2);
			if (floatval($row['low_price'])>0) $lp='₦'.number_format($row['low_price'],2);
			if (floatval($row['close_price'])>0) $cp='₦'.number_format($row['close_price'],2);
			if (floatval($row['trades'])>0) $tra=number_format($row['trades'],0);
			if (floatval($row['volume'])>0) $vol=number_format($row['volume'],0);
			
			if ($row['pix'])
			{
				$pix='<img onClick="ShowPix(\''.$row['symbol'].'\',\''.$row['title'].'\',\''.$row['pix'].'\',\''.$row['blockchainUrl'].'\');" style="cursor:pointer; height:60px;" src="'.base_url().'art-works/thumbs/t_'.$row['pix'].'" title="Click To Display '.strtoupper(trim($row['title'])).' Picture">'.'<br>'.$row['title'].', '.$row['creationyear'];				
			}
						
			$sn++;
			
			if (strtolower($usertype) == 'investor') //or (strtolower($usertype) == 'investor/issuer'))
			{
				$act='<div class="btn-group">
				  		<button type="button" class="btn btn-nse-green dropdown-toggle makebold" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					ACTION
							
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
							
				  		</button>
						
				  		<div class="dropdown-menu dropdown-menu-right">
							<a onClick="Request_A_Secondary_Buy(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['close_price'].'\',\''.$row['tokens_for_sale'].'\',\''.$brokername.'\',\''.$row['availqty'].'\')" title="Send A Request To Your Broker To Buy The Artwork With Symbol, '.strtoupper(trim($row['symbol'])).', For You" class="dropdown-item makebold btn-block nsegreen-dark text-center" href="#">Request A Buy</a>
					
							<a style="margin-top:10px;" onClick="Request_A_Secondary_Sell(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['close_price'].'\',\''.$row['tokens_for_sale'].'\',\''.$brokername.'\',\''.$row['availqty'].'\')" title="Send A Request To Your Broker To Sell The Artwork With Symbol, '.strtoupper(trim($row['symbol'])).', For You" class="dropdown-item makebold btn-block nsegreen-dark text-center" href="#">Request A Sell</a>
				 		</div>
			 		</div>';
				
				$tp=array($pix,$row['symbol'],$op,$hp,$lp,$cp,$tra,$vol,$act);
				
				$data[]=$tp;
			}			
			
		endforeach;

		print_r(json_encode($data));
	}
	
	public function GetTrades()
	{
		$email=''; $broker_id=''; $startdate=''; $enddate='';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));
		if ($this->input->post('startdate')) $startdate = $this->input->post('startdate');
		if ($this->input->post('enddate')) $enddate = $this->input->post('enddate');
				
		$qry = "SELECT * FROM trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND ((TRIM(buy_broker_id)='".$this->db->escape_str($broker_id)."') OR (TRIM(sell_broker_id)='".$this->db->escape_str($broker_id)."')) AND (TRIM(payment_status)='Successful') ORDER BY tradedate DESC";

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
					
			$tp=array($dt,$row['trade_id'],$row['symbol'],$qty,$pr,$amt,$seller_email,$buyer_email);
			
			$data[]=$tp;
		endforeach;

		print_r(json_encode($data));
	}	
	
	function LoadMessages()
	{
		$email=''; $detail_width=''; $header_width=''; $usertype='';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('detail_width')) $detail_width = trim($this->input->post('detail_width'));
		if ($this->input->post('header_width')) $header_width = trim($this->input->post('header_width'));
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		
		$results=$this->getdata_model->GetUserMessages($email,$usertype);
		
		$data=array();

		if ($results)
		{
			$chr_count=floor($detail_width/8);
			$head_count=floor($header_width/8);
			
			foreach($results as $row):
				$view=''; $dt=''; $details=''; $header='';
				
				if ($row->msgdate <> '0000-00-00 00:00:00') $dt=date('d M Y',strtotime($row->msgdate));
				
				if ($row->header) $row->header=str_replace("'","`",$row->header);				
				if ($row->details) $row->details=str_replace("'","`",$row->details);
				
				$details=$row->details;
				$header=$row->header;
				
				if (strlen($row->details) > $chr_count) $row->details = substr($row->details,0,$chr_count-3).'...';
				if (strlen($row->header) > $head_count) $row->header = substr($row->header,0,$head_count-3).'...';
				
				$view='<img onClick="LocateMesssage('.$row->msgid.',\''.urlencode($header).'\',\''.urlencode($details).'\',\''.$dt.'\',\''.$row->category.'\')" style="cursor:pointer; height:30px;" src="'.base_url().'images/view_icon.png" title="Click To View Details Of This '.$row->category.'">';
								
				$tp=array($dt,$row->header,$row->sender,$view);
				
				$data[]=$tp;
			endforeach;
		}

		print_r(json_encode($data));
	}
	
	function GetBalance()
	{
		$email=''; $bal='';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		
		$bal=$this->getdata_model->GetWalletBalance($email);
		
		echo $bal;

	}#End Of GetBalance
	
	function GetPrice()
	{
		$symbol='';
		
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));
		
		$sql="SELECT close_price FROM daily_price WHERE (TRIM(symbol)='".$this->db->escape_str($symbol)."')";		

		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		$price='0';
		
		if ($row->close_price) $price=trim($row->close_price);
	
		echo $price;

	}#End Of GetPrice
	
	function GetSymbols()
	{
		$sql="SELECT listed_artworks.symbol,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol) LIMIT 0,1) AS title,(SELECT artist FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol) LIMIT 0,1) AS artist,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol) LIMIT 0,1) AS creationyear FROM listed_artworks WHERE (holding_period_ends IS NULL) OR (DATE_FORMAT(holding_period_ends,'%Y-%m-%d') < DATE_FORMAT(NOW(),'%Y-%m-%d')) ORDER BY symbol";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetSymbols functions
	
	function GetInvestors()
	{
		$email=''; $broker_id='';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		
		$det = $this->getdata_model->GetBrokerDetails($email);
		
		if ($det->broker_id) $broker_id = trim($det->broker_id);
				
		$sql="SELECT user_name,email FROM investors WHERE (TRIM(broker_id)='".$this->db->escape_str($broker_id)."') AND (accountstatus=1) ORDER BY user_name";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetInvestors
		
	public function GetRequestsHistory()
	{
		$usertype='';
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		
		$qry = "SELECT *,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS title,(SELECT artist FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS artist,(SELECT artwork_value FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS artwork_value,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS creationyear,(SELECT tokens_for_sale FROM listed_artworks WHERE TRIM(listed_artworks.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS tokens_for_sale FROM request_to_buy ORDER BY requestdate DESC,symbol";

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array(); $sn=-1;

		foreach($results as $row):
			$pix='';  $min='-';  $max='-';
			
			if ($row['pix'])
			{
				$pix='<img onClick="ShowPix(\''.$row['symbol'].'\',\''.$row['title'].'\',\''.$row['pix'].'\',\''.$row['blockchainUrl'].'\');" style="height:60px; cursor:pointer;" src="'.base_url().'art-works/thumbs/t_'.$row['pix'].'" title="'.strtoupper(trim($row['title'])).'('.strtoupper(trim($row['symbol'])).')"><br>'.$row['title'].', '.$row['creationyear'];				
			}
			
			if (floatval($row['min_price'])>0) $min='&#8358;'.number_format($row['min_price'],2);
			if (floatval($row['max_price'])>0) $max='&#8358;'.number_format($row['max_price'],2);

			$tp=array($row['market_type'],$pix,$row['symbol'],$row['trans_type'],number_format($row['tokens'],0),$min,$max,'&#8358;'.number_format($row['marketprice'],2));
			
			$data[]=$tp;
		endforeach;

		print_r(json_encode($data));
	}
	
	public function BuyTokens()
	{		
		$broker_id=''; $broker_recipient_code=''; $investor_recipient_code=''; $brokername=''; 
		
		$email=''; $investor_id='';  $transtype=''; $symbol=''; $price=''; $qty=''; $available_qty='';
		$ordertype=''; $orderstatus=''; $expirydate=''; $sms_fee=''; $investor_email=''; $investor_phone='';
		$brokerphone='';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('investor_id')) $investor_id = trim($this->input->post('investor_id'));
		if ($this->input->post('transtype')) $transtype = trim($this->input->post('transtype'));
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));	
		if ($this->input->post('price')) $price = trim($this->input->post('price'));		
		if ($this->input->post('qty')) $qty = trim($this->input->post('qty'));	
		if ($this->input->post('available_qty')) $available_qty = trim($this->input->post('available_qty'));		
		if ($this->input->post('ordertype')) $ordertype = trim($this->input->post('ordertype'));		
		if ($this->input->post('orderstatus')) $orderstatus = trim($this->input->post('orderstatus'));
		if ($this->input->post('expirydate')) $expirydate = trim($this->input->post('expirydate'));
		if ($this->input->post('sms_fee')) $sms_fee = trim($this->input->post('sms_fee'));
		
		$orderdate=$this->getdata_model->GetOrderTime();
		$order_id=$this->getdata_model->GetId('orders','order_id');
		
		$det = $this->getdata_model->GetBrokerDetails($email);		
		if ($det->broker_id) $broker_id = trim($det->broker_id);
		if ($det->recipient_code) $broker_recipient_code = trim($det->recipient_code);
		if ($det->company) $brokername = trim($det->company);
		if ($det->phone) $brokerphone = trim($det->phone);
		
		$inv = $this->getdata_model->GetInvestorDetails($investor_id);
		if ($inv->recipient_code) $investor_recipient_code = trim($inv->recipient_code);
		if ($inv->email) $investor_email = trim($inv->email);
		if ($inv->phone) $investor_phone = trim($inv->phone);
				
		//Checkif broker has recipientcode
		if (!isset($broker_recipient_code))
		{
			$m='Placing of order failed. Your have not added your bank details to your profile. Without your bank details, you cannot trade on the platform. Go to your user profile in the user avatar menu items and update your account information.';
			
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			if (!isset($investor_recipient_code))
			{
				$m="Placing of order failed. The investor's bank details have not been added to the profile. Without the investor's bank details, you cannot trade on the platform. Ask the investor to add the bank details in the user profile module.";
			
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{
				$Msg='';					
					
				//Send order to trading gateway
				$order=array('order_id'=>$order_id,'broker_id'=>$broker_id,'broker_email'=>$email,'broker_phone'=>$brokerphone,'investor_id'=>$investor_id,'investor_email'=>$investor_email,'investor_phone'=>$investor_phone,'transtype'=>$transtype,'symbol'=>$symbol,'price'=>$price,'qty'=>$qty,'available_qty'=>$qty,'ordertype'=>$ordertype,'orderdate'=>$orderdate,'expirydate'=>$expirydate,'orderstatus'=>$orderstatus,'broker_commission'=>'0','nse_commission'=>'','transfer_fee'=>'','sms_fee'=>$sms_fee,'total_amount'=>'','trade_amount'=>'','limit_market'=>'','broker_recipient_code'=>$broker_recipient_code,'investor_recipient_code'=>$investor_recipient_code);					
				
				$res=$this->getdata_model->ValidateOrder($order);
				
				if ($res['status']<> 1)
				{
					$ret=array('status'=>'FAIL','Message'=>$res['msg']);
				}else
				{
					$Msg=$brokername.' with email '.$email.", has successfully placed a buy order for ".number_format($qty,0)." tokens of '".$symbol."'.";
					
					$ret=array('status'=>'OK','Message'=>'OK');
					
					//$r=$this->getdata_model->TradingGateway($res['order'],$res['ChangePriceQty']);
					
					
					///// POST
					$url=base_url()."admin/Tradinggateway/Process";
					$postdata=array('order' =>$res['order'], 'changeprice'	=> $res['ChangePriceQty']);
					
					//Set option to Request 1
					$opts = new \cURL\Options;
					$opts->set(CURLOPT_URL, $url);
					$opts->set(CURLOPT_RETURNTRANSFER, true);
					$opts->set(CURLOPT_TIMEOUT, 5);
					$opts->set(CURLOPT_SSL_VERIFYPEER, false);
					$opts->set(CURLOPT_POST, true);
					$opts->set(CURLOPT_SSL_VERIFYHOST, false);
					$opts->set(CURLOPT_POSTFIELDS, http_build_query($postdata));
					
					//Assign options to requests
					$request = new \cURL\Request;
					$request->setOptions($opts);
					
					//Create queue
					$queue = new \cURL\RequestsQueue;
					
					$queue->attach($request);
									
					$queue->addListener('complete', function (\cURL\Event $event) {				
						//echo $event->response;
					});
					
					// Execute queue
					$queue->send();
				}				
				
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
				//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
				$this->getdata_model->LogDetails($brokername,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'PLACED ORDER TO BUY '.$qty.' TOKENS OF '.$symbol,$_SESSION['LogID']);			
			}
		}
				
		echo json_encode($ret);
	}
	
	public function RequestBuy()
	{//
		$broker_id=''; $brokername=''; $investor_id=''; $symbol=''; $marketprice=''; $tokens=''; 
		$sms_fee=''; $brokerfee=''; $nsefee=''; $email=''; $investor_name=$email;
		
		$trans_type='Buy';
		$request_status='Pending';
		$market_type='Primary';
		$requestdate=date('Y-m-d H:i:s');
		$request_id=$this->getdata_model->GetId('request_to_buy','request_id');
		
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));
		if ($this->input->post('brokername')) $brokername = trim($this->input->post('brokername'));
		if ($this->input->post('investor_id')) $investor_id = trim($this->input->post('investor_id'));
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));
		if ($this->input->post('marketprice')) $marketprice = trim($this->input->post('marketprice'));
		if ($this->input->post('tokens')) $tokens = trim($this->input->post('tokens'));
		if ($this->input->post('sms_fee')) $sms_fee = trim($this->input->post('sms_fee'));
		if ($this->input->post('brokerfee')) $brokerfee = trim($this->input->post('brokerfee'));
		if ($this->input->post('nsefee')) $nsefee = trim($this->input->post('nsefee'));		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));		
		
		//Check if symbol exists
		$sql = "SELECT * FROM primary_market WHERE (TRIM(symbol)='".$this->db->escape_str($symbol)."')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() == 0 )
		{
			$Msg="The security, ".strtoupper($symbol).", does not exist in the database.";
			
			$m = "The security, <b>".strtoupper($symbol)."</b>, does not exist in the database.";
			
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			//Check if available quantity is still enough for the buy
			$row = $query->row();
			
			$avtok=''; $sta='';
			
			if ($row->tokens_available) $avtok=$row->tokens_available;
			if ($row->listing_status) $sta=trim($row->listing_status);
			
			if (strtolower($sta) == 'ended')
			{
				$Msg="The primary market for security, ".strtoupper($symbol).", has ended.";
			
				$m = "The primary market for security, <b>".strtoupper($symbol)."</b>, has ended.";
			
				$ret=array('status'=>'FAIL','Message'=>$m);
			}elseif (strtolower($sta) == 'pending')
			{
				$Msg="The primary market for security, ".strtoupper($symbol).", has not started. It is still waiting for approval from the exchange.";
			
				$m = "The primary market for security, ".strtoupper($symbol).", has not started. It is still waiting for approval from the exchange.";
			
				$ret=array('status'=>'FAIL','Message'=>$m);
			}elseif (strtolower($sta) == 'started')
			{
				$investor_name=''; $broker_email=''; $investor_phone=''; $investor_email=''; $title='';
												
				if (floatval($tokens) > floatval($avtok))
				{
					$Msg="The quantity of the security you have entered to buy, " . number_format($tokens,0,'',',') . ", is more than the available number of tokens for sale which is " . number_format($avtok,0,'',',') . ".";
					
					$m="The quantity of the security you have entered to buy, <b>" . number_format($tokens,0,'',',') . "</b>, is more than the available number of tokens for sale which is <b>" . number_format($avtok,0,'',',') . "</b>.";
					
					$ret=array('status'=>'FAIL','Message'=>$m);
				}else
				{
					$this->db->trans_start();
		
					$dat=array(
						'investor_id' 		=> $this->db->escape_str($investor_id),
						'broker_id' 		=> $this->db->escape_str($broker_id),
						'market_type' 		=> $this->db->escape_str($market_type),
						'trans_type' 		=> $this->db->escape_str($trans_type),
						'symbol' 			=> $this->db->escape_str($symbol),
						'marketprice' 		=> $this->db->escape_str($marketprice),
						'tokens' 			=> $this->db->escape_str($tokens),
						'brokerfee'			=> $this->db->escape_str($brokerfee),						
						'nsefee' 			=> $this->db->escape_str($nsefee),						
						'sms_fee' 			=> $this->db->escape_str($sms_fee),						
						'request_id'		=> $this->db->escape_str($request_id),
						'request_status'	=> $this->db->escape_str($request_status),
						'requestdate' 		=> $this->db->escape_str($requestdate)
					);
					
					$this->db->insert('request_to_buy', $dat);
					
					$this->db->trans_complete();					
					
					if ($this->db->trans_status() === FALSE)
					{					
						$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted requesting that the broker buys ".number_format($tokens,0,'',',')." tokens of ".strtoupper($symbol)." but failed.";
						
						$m = "Request To Buy ".number_format($tokens,0,'',',')." Tokens Of ".strtoupper($symbol)." Failed.";
						$ret=array('status'=>'FAIL','Message'=>$m);					
					}else
					{
						//Send message
						$inv = $this->getdata_model->GetInvestorDetails($investor_id);
						if ($inv->user_name) $investor_name = trim($inv->user_name);
						if ($inv->phone) $investor_phone = trim($inv->phone);
						if ($inv->email) $investor_email = trim($inv->email);
						
						$r = $this->getdata_model->GetBrokerDetails($broker_id);
						if ($r->email) $broker_email = trim($r->email);
						
						$rwt = $this->getdata_model->GetArtTitle($symbol);
						$title = trim($rwt);
						
						$msgtype='system';						
						$header='Request For Purchase Of '.strtoupper($symbol);
						$groups='';
						$emails=$broker_email;
						$phones='';
						$category='Message';
						$expiredate=NULL;
						$display_status=1;
						$sender='System';						
						
						$details="The investor, ".strtoupper($investor_name).", with email ".$investor_email.", and phone number, ".$investor_phone.", has submitted a request for you to assist in buying the artwork with symbol ".strtoupper($symbol)." and title, ".strtoupper($title).". Please attend to the request.";
						
						$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
						
						//Send Email
						$from='admin@naijaartmart.com';
						$to=$broker_email;
						$subject=$header;
						$Cc='idongesit_a@yahoo.com';
										
						$img=base_url()."images/logo.png";
											
						//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
					
						$message = '
							<html>
							<head>
							<meta charset="utf-8">
							<title>Naija Art Mart | Resquest To Buy</title>
							</head>
							<body>								
																
							Dear Broker,<br><br>
									
							The investor, '.strtoupper($investor_name).', with email '.$investor_email.', and phone number, '.$investor_phone.', has submitted a request for you to assist in buying the artwork with symbol '.strtoupper($symbol).' and title, '.strtoupper($title).'. Please attend to the request.
											
							<p>Best Regards</p>
							Naija Art Mart
							
							</body>
							</html>';
							
						$altmessage = '
							Dear Broker,
									
							The investor, '.strtoupper($investor_name).', with email '.$investor_email.', and phone number, '.$investor_phone.', has submitted a request for you to assist in buying the artwork with symbol '.strtoupper($symbol).' and title, '.strtoupper($title).'. Please attend to the request.
									
							Best Regards
							Naija Art Mart';
						
						if ($to) $v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$brokername);
						
						if (strtoupper(trim($v)) <> 'OK')
						{
							$Msg ="Request To Buy Artwork With Symbol, ".strtoupper($symbol)." Was Successful, But Sending Of Email To Broker Failed. Broker Will Be Able To View The Request Via Naija Art Mart Messaging Screen.";
							
							$m ="Request Was Successfully Sent, But Sending Of Email To Broker Failed. Broker Will Be Able To View The Request Via Naija Art Mart Messaging Screen.";		
								
							$ret=array('status'=>'OK','Message'=>$m);					
						}else
						{
							$Msg="Request To Buy Artwork With Symbol, ".strtoupper($symbol)." Was Successful.";				
							
							$ret=array('status'=>'OK','Message'=>'');
						}
						
												
						$Msg="Investor Requested That The Broker Buys ".number_format($tokens,0,'',',')." Tokens Of ".strtoupper($symbol).".";				
							
						$remote_ip=$_SERVER['REMOTE_ADDR'];
						$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
						
						//$Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID
						$this->getdata_model->LogDetails($investor_name,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'REQUESTED TO BUYS ARTWORK FROM PRIMARY MARKET',$_SESSION['LogID']);
					}
				}
			}
		}
		
		echo json_encode($ret);
	}
	
	function CheckIfSecBuyExists()
	{
		$broker_id=''; $investor_id=''; $symbol=''; $max_price=''; $min_price=''; $tokens='';
		$trans_type='Buy'; $request_status='Pending'; $market_type='Secondary'; $ret='0';	
		
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));
		if ($this->input->post('investor_id')) $investor_id = trim($this->input->post('investor_id'));		
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));		
		if ($this->input->post('max_price')) $max_price = trim($this->input->post('max_price'));
		if ($this->input->post('min_price')) $min_price = trim($this->input->post('min_price'));		
		if ($this->input->post('tokens')) $tokens = trim($this->input->post('tokens'));
		
		$sql = "SELECT * FROM request_to_buy WHERE (investor_id=".$this->db->escape_str($investor_id).") AND (TRIM(broker_id)='".$this->db->escape_str($broker_id)."') AND (TRIM(symbol)='".$this->db->escape_str($symbol)."') AND (max_price=".$this->db->escape_str($max_price).") AND (min_price=".$this->db->escape_str($min_price).") AND (tokens=".$this->db->escape_str($tokens).") AND (TRIM(trans_type)='".$this->db->escape_str($trans_type)."') AND (TRIM(request_status)='".$this->db->escape_str($request_status)."') AND (TRIM(market_type)='".$this->db->escape_str($market_type)."') AND (DATE_FORMAT(requestdate,'%Y-%m-%d')='".date('Y-m-d')."')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 ) $ret=1;
		
		echo $ret;
	}	
	
	public function RequestSecBuy()
	{
		$email=''; $broker_id=''; $brokername=''; $investor_id=''; $symbol=''; $marketprice='';
		$max_price=''; $min_price=''; $tokens=''; $brokerfee=''; $nsefee=''; $sms_fee='';
		$investor_name=''; $broker_email=''; $investor_phone=''; $investor_email=''; $title='';
		
		$trans_type='Buy';
		$request_status='Pending';
		$market_type='Secondary';
		$requestdate=date('Y-m-d H:i:s');
		$request_id=$this->getdata_model->GetId('request_to_buy','request_id');
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));		
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));		
		if ($this->input->post('brokername')) $brokername = trim($this->input->post('brokername'));		
		if ($this->input->post('investor_id')) $investor_id = trim($this->input->post('investor_id'));		
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));		
		if ($this->input->post('marketprice')) $marketprice = trim($this->input->post('marketprice'));		
		if ($this->input->post('max_price')) $max_price = trim($this->input->post('max_price'));
		if ($this->input->post('min_price')) $min_price = trim($this->input->post('min_price'));		
		if ($this->input->post('tokens')) $tokens = trim($this->input->post('tokens'));
		if ($this->input->post('brokerfee')) $brokerfee = trim($this->input->post('brokerfee'));
		if ($this->input->post('nsefee')) $nsefee = trim($this->input->post('nsefee'));
		if ($this->input->post('sms_fee')) $sms_fee = trim($this->input->post('sms_fee'));
		
		$this->db->trans_start();

		$dat=array(
			'investor_id' 		=> $this->db->escape_str($investor_id),
			'broker_id' 		=> $this->db->escape_str($broker_id),
			'market_type' 		=> $this->db->escape_str($market_type),
			'trans_type' 		=> $this->db->escape_str($trans_type),
			'symbol' 			=> $this->db->escape_str($symbol),
			'marketprice' 		=> $this->db->escape_str($marketprice),
			'max_price' 		=> $this->db->escape_str($max_price),
			'min_price' 		=> $this->db->escape_str($min_price),
			'tokens' 			=> $this->db->escape_str($tokens),
			'brokerfee'			=> $this->db->escape_str($brokerfee),						
			'nsefee' 			=> $this->db->escape_str($nsefee),						
			'sms_fee' 			=> $this->db->escape_str($sms_fee),
			'request_status'	=> $this->db->escape_str($request_status),						
			'request_id'		=> $this->db->escape_str($request_id),			
			'requestdate' 		=> $this->db->escape_str($requestdate)
		);
		
		$this->db->insert('request_to_buy', $dat);
		
		$this->db->trans_complete();					
		
		if ($this->db->trans_status() === FALSE)
		{					
			$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted requesting that the broker buys ".number_format($tokens,0,'',',')." tokens of ".strtoupper($symbol)." from the secondary market but failed.";
			
			$m = "Request To Buy ".number_format($tokens,0,'',',')." Tokens Of ".strtoupper($symbol)." From The Secondary Market Failed.";
			$ret=array('status'=>'FAIL','Message'=>$m);					
		}else
		{
			//Send message
			$inv = $this->getdata_model->GetInvestorDetails($investor_id);
			if ($inv->user_name) $investor_name = trim($inv->user_name);
			if ($inv->phone) $investor_phone = trim($inv->phone);
			if ($inv->email) $investor_email = trim($inv->email);
			
			$r = $this->getdata_model->GetBrokerDetails($broker_id);
			if ($r->email) $broker_email = trim($r->email);
			
			$rwt = $this->getdata_model->GetArtTitle($symbol);
			$title = trim($rwt);
			
			$msgtype='system';						
			$header='Request For Purchase Of '.number_format($tokens,0,'',',')." Tokens Of ".strtoupper($symbol);
			$groups='';
			$emails=$broker_email;
			$phones='';
			$category='Message';
			$expiredate=NULL;
			$display_status=1;
			$sender='System';						
			
			$details="The investor, ".strtoupper($investor_name).", with email ".$investor_email.", and phone number, ".$investor_phone.", has submitted a request for you to assist in buying the artwork with symbol ".strtoupper($symbol)." and title, ".strtoupper($title)." from the secondary market. Please attend to the request.";
			
			$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
			
			//Send Email
			$from='admin@naijaartmart.com';
			$to=$broker_email;
			$subject=$header;
			$Cc='idongesit_a@yahoo.com';
							
			$img=base_url()."images/logo.png";
								
			//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
		
			$message = '
				<html>
				<head>
				<meta charset="utf-8">
				<title>Naija Art Mart | Resquest To Buy</title>
				</head>
				<body>								
													
				Dear Broker,<br><br>
						
				The investor, '.strtoupper($investor_name).', with email '.$investor_email.', and phone number, '.$investor_phone.', has submitted a request for you to assist in buying the artwork with symbol '.strtoupper($symbol).' and title, '.strtoupper($title).', from the secondary market. Please attend to the request.
								
				<p>Best Regards</p>
				Naija Art Mart
				
				</body>
				</html>';
				
			$altmessage = '
				Dear Broker,
						
				The investor, '.strtoupper($investor_name).', with email '.$investor_email.', and phone number, '.$investor_phone.', has submitted a request for you to assist in buying the artwork with symbol '.strtoupper($symbol).' and title, '.strtoupper($title).' from the secondary market. Please attend to the request.
						
				Best Regards
				Naija Art Mart';
			
			if ($to) $v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$brokername);
			
			if (strtoupper(trim($v)) <> 'OK')
			{
				$Msg ="Request To Buy Artwork With Symbol, ".strtoupper($symbol)." From The Secondary Market Was Successful, But Sending Of Email To Broker Failed. Broker Will Be Able To View The Request Via Naija Art Mart Messaging Screen.";
				
				$m ="Request Was Successfully Sent, But Sending Of Email To Broker Failed. Broker Will Be Able To View The Request Via Naija Art Mart Messaging Screen.";		
					
				$ret=array('status'=>'OK','Message'=>$m);					
			}else
			{
				$Msg="Request To Buy Artwork With Symbol, ".strtoupper($symbol)." Was Successful.";				
				
				$ret=array('status'=>'OK','Message'=>'');
			}
			
									
			$Msg="Investor Requested That The Broker Buys ".number_format($tokens,0,'',',')." Tokens Of ".strtoupper($symbol)." From The Secondary Market.";				
				
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			//$Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID
			$this->getdata_model->LogDetails($investor_name,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'REQUESTED TO BUY ARTWORK FROM SECONDARY MARKET',$_SESSION['LogID']);
		}
		
		echo json_encode($ret);
	}
	
	//Sec Sell
	function CheckIfSecSellExists()
	{
		$broker_id=''; $investor_id=''; $symbol=''; $max_price=''; $min_price=''; $tokens='';
		$trans_type='Sell'; $request_status='Pending'; $market_type='Secondary'; $ret='0';	
		
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));
		if ($this->input->post('investor_id')) $investor_id = trim($this->input->post('investor_id'));		
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));		
		if ($this->input->post('max_price')) $max_price = trim($this->input->post('max_price'));
		if ($this->input->post('min_price')) $min_price = trim($this->input->post('min_price'));		
		if ($this->input->post('tokens')) $tokens = trim($this->input->post('tokens'));
		
		$sql = "SELECT * FROM request_to_buy WHERE (investor_id=".$this->db->escape_str($investor_id).") AND (TRIM(broker_id)='".$this->db->escape_str($broker_id)."') AND (TRIM(symbol)='".$this->db->escape_str($symbol)."') AND (max_price=".$this->db->escape_str($max_price).") AND (min_price=".$this->db->escape_str($min_price).") AND (tokens=".$this->db->escape_str($tokens).") AND (TRIM(trans_type)='".$this->db->escape_str($trans_type)."') AND (TRIM(request_status)='".$this->db->escape_str($request_status)."') AND (TRIM(market_type)='".$this->db->escape_str($market_type)."') AND (DATE_FORMAT(requestdate,'%Y-%m-%d')='".date('Y-m-d')."')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 ) $ret=1;
		
		echo $ret;
	}	
	
	public function RequestSecSell()
	{
		$email=''; $broker_id=''; $brokername=''; $investor_id=''; $symbol=''; $marketprice='';
		$max_price=''; $min_price=''; $tokens=''; $brokerfee=''; $nsefee=''; $sms_fee='';
		$investor_name=''; $broker_email=''; $investor_phone=''; $investor_email=''; $title='';
		
		$trans_type='Sell';
		$request_status='Pending';
		$market_type='Secondary';
		$requestdate=date('Y-m-d H:i:s');
		$request_id=$this->getdata_model->GetId('request_to_buy','request_id');
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));		
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));		
		if ($this->input->post('brokername')) $brokername = trim($this->input->post('brokername'));		
		if ($this->input->post('investor_id')) $investor_id = trim($this->input->post('investor_id'));		
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));		
		if ($this->input->post('marketprice')) $marketprice = trim($this->input->post('marketprice'));		
		if ($this->input->post('max_price')) $max_price = trim($this->input->post('max_price'));
		if ($this->input->post('min_price')) $min_price = trim($this->input->post('min_price'));		
		if ($this->input->post('tokens')) $tokens = trim($this->input->post('tokens'));
		if ($this->input->post('brokerfee')) $brokerfee = trim($this->input->post('brokerfee'));
		if ($this->input->post('nsefee')) $nsefee = trim($this->input->post('nsefee'));
		if ($this->input->post('sms_fee')) $sms_fee = trim($this->input->post('sms_fee'));
		
		$this->db->trans_start();

		$dat=array(
			'investor_id' 		=> $this->db->escape_str($investor_id),
			'broker_id' 		=> $this->db->escape_str($broker_id),
			'market_type' 		=> $this->db->escape_str($market_type),
			'trans_type' 		=> $this->db->escape_str($trans_type),
			'symbol' 			=> $this->db->escape_str($symbol),
			'marketprice' 		=> $this->db->escape_str($marketprice),
			'max_price' 		=> $this->db->escape_str($max_price),
			'min_price' 		=> $this->db->escape_str($min_price),
			'tokens' 			=> $this->db->escape_str($tokens),
			'brokerfee'			=> $this->db->escape_str($brokerfee),						
			'nsefee' 			=> $this->db->escape_str($nsefee),						
			'sms_fee' 			=> $this->db->escape_str($sms_fee),
			'request_status'	=> $this->db->escape_str($request_status),						
			'request_id'		=> $this->db->escape_str($request_id),			
			'requestdate' 		=> $this->db->escape_str($requestdate)
		);
		
		$this->db->insert('request_to_buy', $dat);
		
		$this->db->trans_complete();					
		
		if ($this->db->trans_status() === FALSE)
		{					
			$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted requesting that the broker sells ".number_format($tokens,0,'',',')." tokens of ".strtoupper($symbol)." on the secondary market but failed.";
			
			$m = "Request To Sell ".number_format($tokens,0,'',',')." Tokens Of ".strtoupper($symbol)." On The Secondary Market Failed.";
			$ret=array('status'=>'FAIL','Message'=>$m);					
		}else
		{
			//Send message
			$inv = $this->getdata_model->GetInvestorDetails($investor_id);
			if ($inv->user_name) $investor_name = trim($inv->user_name);
			if ($inv->phone) $investor_phone = trim($inv->phone);
			if ($inv->email) $investor_email = trim($inv->email);
			
			$r = $this->getdata_model->GetBrokerDetails($broker_id);
			if ($r->email) $broker_email = trim($r->email);
			
			$rwt = $this->getdata_model->GetArtTitle($symbol);
			$title = trim($rwt);
			
			$msgtype='system';						
			$header='Request For Sale Of '.number_format($tokens,0,'',',')." Tokens Of ".strtoupper($symbol);
			$groups='';
			$emails=$broker_email;
			$phones='';
			$category='Message';
			$expiredate=NULL;
			$display_status=1;
			$sender='System';						
			
			$details="The investor, ".strtoupper($investor_name).", with email ".$investor_email.", and phone number, ".$investor_phone.", has submitted a request for you to assist in selling the artwork with symbol ".strtoupper($symbol)." and title, ".strtoupper($title)." on the secondary market. Please attend to the request.";
			
			$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
			
			//Send Email
			$from='admin@naijaartmart.com';
			$to=$broker_email;
			$subject=$header;
			$Cc='idongesit_a@yahoo.com';
							
			$img=base_url()."images/logo.png";
								
			//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
		
			$message = '
				<html>
				<head>
				<meta charset="utf-8">
				<title>Naija Art Mart | Resquest To Sell</title>
				</head>
				<body>								
													
				Dear Broker,<br><br>
						
				The investor, '.strtoupper($investor_name).', with email '.$investor_email.', and phone number, '.$investor_phone.', has submitted a request for you to assist in selling the artwork with symbol '.strtoupper($symbol).' and title, '.strtoupper($title).', on the secondary market. Please attend to the request.
								
				<p>Best Regards</p>
				Naija Art Mart
				
				</body>
				</html>';
				
			$altmessage = '
				Dear Broker,
						
				The investor, '.strtoupper($investor_name).', with email '.$investor_email.', and phone number, '.$investor_phone.', has submitted a request for you to assist in selling the artwork with symbol '.strtoupper($symbol).' and title, '.strtoupper($title).' on the secondary market. Please attend to the request.
						
				Best Regards
				Naija Art Mart';
			
			if ($to) $v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$brokername);
			
			if (strtoupper(trim($v)) <> 'OK')
			{
				$Msg ="Request To Sell Artwork With Symbol, ".strtoupper($symbol)." On The Secondary Market Was Successful, But Sending Of Email To Broker Failed. Broker Will Be Able To View The Request Via Naija Art Mart Messaging Screen.";
				
				$m ="Request Was Successfully Sent, But Sending Of Email To Broker Failed. Broker Will Be Able To View The Request Via Naija Art Mart Messaging Screen.";		
					
				$ret=array('status'=>'OK','Message'=>$m);					
			}else
			{
				$Msg="Request To Sell Artwork With Symbol, ".strtoupper($symbol)." Was Successful.";				
				
				$ret=array('status'=>'OK','Message'=>'');
			}
			
									
			$Msg="Investor Requested That The Broker Sells ".number_format($tokens,0,'',',')." Tokens Of ".strtoupper($symbol)." On The Secondary Market.";				
				
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			//$Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID
			$this->getdata_model->LogDetails($investor_name,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'REQUESTED TO SELL ARTWORK ON SECONDARY MARKET',$_SESSION['LogID']);
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
		
		$data['userlogo'] = '';
		
		if (isset($_SESSION['email']))
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
			
			$data['broker_id']=''; $data['broker_name']=''; $data['broker_recipient_code']='';
			$data['investor_id'] = '';
			
			if (trim(strtolower($data['usertype']))=='broker')
			{
				$det = $this->getdata_model->GetBrokerDetails($data['email']);
				
				if ($det->broker_id) $data['broker_id'] = trim($det->broker_id);	
				if ($det->company) $data['broker_name'] = trim($det->company);	
			}elseif (trim(strtolower($data['usertype']))=='investor') //or (trim(strtolower($data['usertype']))=='investor/issuer'))
			{
				$det = $this->getdata_model->GetInvestorDetails($data['email']);
				
				if ($det->uid) $data['investor_id'] = trim($det->uid);	
				
				if ($det->broker_id)
				{
					$data['broker_id'] = trim($det->broker_id);
					
					$br = $this->getdata_model->GetBrokerDetails($data['broker_id']);
					
					if ($br->company) $data['broker_name'] = trim($br->company);	
				}
			}
			
			
			//if ($det->recipient_code) $data['broker_recipient_code'] = $det->recipient_code;
						
			$data['balance']=$this->getdata_model->GetWalletBalance($data['email']);			
			
			$set = $this->getdata_model->GetTradingParamaters();			
			if ($set->brokers_commission) $data['brokers_rate'] = $set->brokers_commission;
			if ($set->nse_commission) $data['nse_rate'] = $set->nse_commission;
			if ($set->price_limit_percent) $data['price_limit_percent'] = $set->price_limit_percent;
			if ($set->sms_fee) $data['sms_fee'] = $set->sms_fee; else $data['sms_fee'] = '0';
			
			$this->load->view('ui/traderequest_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('');
		}
	}
}
