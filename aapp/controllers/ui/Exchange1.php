<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");

date_default_timezone_set('Africa/Lagos');
set_time_limit(0);

require_once(realpath('.')."/vendor/autoload.php"); 

class Exchange extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
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
	
	function GetOrderBook()
	{
		$symbol='';
		
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));
		
		$ret = $this->getdata_model->DisplayOrderBook($symbol);
		
		echo json_encode($ret);
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
	
	function GetTokensFromPortfolio()
	{
		$email=''; $ret=''; $symbol=''; $t='0'; $brokerid='';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));
		if ($this->input->post('brokerid')) $brokerid = trim($this->input->post('brokerid'));
		
		$ret=$this->getdata_model->GetPortfolioDetails($symbol,$brokerid,$email);
		
		if ($ret->tokens) $t=$ret->tokens;
		
		echo $t;

	}#End Of GetTokensFromPortfolio
	
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
		$sql="SELECT symbol FROM listed_artworks ORDER BY symbol";		

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
	
	function GetOrderTypes()
	{
		$sql="SELECT ordertype,description FROM ordertypes WHERE (status=1) ORDER BY description";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetOrderTypes
	
	
	public function GetOrders()
	{
		$email=''; $broker_id='';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		
		$det = $this->getdata_model->GetBrokerDetails($email);		
		if ($det->broker_id) $broker_id = trim($det->broker_id);
		
		$qry = "SELECT * FROM orders WHERE (TRIM(broker_id)='".$this->db->escape_str($broker_id)."') ORDER BY orderdate DESC,symbol";

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array(); $sn=-1;

		foreach($results as $row):
			$up=''; $del=''; $dt=''; $qty=''; $pr='';
			
			if ($row['orderdate']) $dt=date('d M Y H:i',strtotime($row['orderdate']));			
			if (intval($row['qty'])>0) $qty=number_format($row['qty'],0);			
			if (floatval($row['price'])>0) $pr='₦'.number_format($row['price'],2);
					
			$sn++;
			
			$up='<input class="btn btn-success makebold" onClick="UpdateOrder(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['order_id'].'\',\''.$row['qty'].'\',\''.$row['price'].'\',\''.$row['ordertype'].'\',\''.$row['expirydate'].'\',\''.$row['transtype'].'\')" style="cursor:pointer; height:30px; width: 70px;  text-align:center; padding-right:2px; padding-left:2px;" title="Update This '.strtoupper(trim($row['symbol'])).' '.strtoupper(trim($row['transtype'])).' Order" value="EDIT">';
			
			$del='<input class="btn btn-danger makebold" onClick="CancelOrder(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['order_id'].'\',\''.$row['qty'].'\',\''.$row['price'].'\',\''.$row['ordertype'].'\',\''.$row['expirydate'].'\',\''.$row['transtype'].'\')" style="cursor:pointer; height:30px; width: 70px; text-align:center; padding-right:2px; padding-left:2px;" title="Cancel This '.strtoupper(trim($row['symbol'])).' '.strtoupper(trim($row['transtype'])).' Order" value="CANCEL">';
			
			$tp=array($dt,$row['order_id'],$row['symbol'],$qty,$pr,$row['ordertype'],$row['investor_id'],$row['orderstatus'],$up,$del);
			
			$data[]=$tp;
		endforeach;

		print_r(json_encode($data));
	}
	
	function GetDirectMarketData()
	{
		$usertype=''; $broker_id='';
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));
		
		$ret=$this->getdata_model->GetMarketStatus();		
		$sta=$ret['MarketStatus'];
		
		if (trim(strtoupper($sta)) == 'OPEN')
		{
			$qry = "SELECT daily_price.*,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS title,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS creationyear FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".date('Y-m-d')."') ORDER BY symbol";	
		}else
		{
			$latestdate=$this->getdata_model->GetLatestDate('historical_prices','price_date');			
			
			$qry="SELECT historical_prices.*,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS title,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS creationyear FROM historical_prices WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".$latestdate."') ORDER BY symbol";	
		}

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array(); $sn=-1;

		foreach($results as $row):
			$sell=''; $buy=''; $cp=''; $hp='-'; $lp='-'; $op='-'; $tra='-'; $vol='-'; $tp=array();
			
			if (floatval($row['open_price'])>0) $op='₦'.number_format($row['open_price'],2);			
			if (floatval($row['high_price'])>0) $hp='₦'.number_format($row['high_price'],2);
			if (floatval($row['low_price'])>0) $lp='₦'.number_format($row['low_price'],2);
			if (floatval($row['close_price'])>0) $cp='₦'.number_format($row['close_price'],2);
			if (floatval($row['trades'])>0) $tra=number_format($row['trades'],0);
			if (floatval($row['volume'])>0) $vol=number_format($row['volume'],0);
			
			if ($row['pix'])
			{
				$pix='<img onClick="ShowPix(\''.$row['symbol'].'\',\''.$row['title'].'\',\''.$row['pix'].'\');" style="cursor:pointer; height:60px;" src="'.base_url().'art-works/thumbs/t_'.$row['pix'].'" title="Click To Display '.strtoupper(trim($row['title'])).' Picture">'.'<br>'.$row['title'].', '.$row['creationyear'];				
			}
						
			$sn++;
			
			if (strtolower($usertype) == 'broker')
			{
				$buy='<input type="button" class="btn btn-nse-green makebold" onClick="BuyDirectArt(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['close_price'].'\',\''.$row['volume'].'\')" style="cursor:pointer; height:30px; width: 75px;  text-align:center;" title="Buy '.strtoupper(trim($row['symbol'])).'" value="BUY">';
				
				$sell='<input type="button" class="btn btn-danger makebold" onClick="SellDirectArt(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['close_price'].'\',\''.$row['volume'].'\')" style="cursor:pointer; height:30px; width: 75px; text-align:center; padding-right:3px; padding-left:3px;" title="Sell '.strtoupper(trim($row['symbol'])).'" value="SELL">';	
				
				$tp=array($row['symbol'],$op,$hp,$lp,$cp,$tra,$vol,$buy,$sell);
			}elseif (strtolower($usertype) == 'investor') //or (strtolower($usertype) == 'investor/issuer'))
			{
				$buy='<div class="btn-group">
				  		<button type="button" class="btn btn-nse-green dropdown-toggle makebold" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					ACTION
							
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
							
				  		</button>
						
				  		<div class="dropdown-menu dropdown-menu-right">
							<a onClick="Request_A_Secondary_Buy(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['close_price'].'\',\''.$row['tokens_for_sale'].'\')" title="Send A Request To Your Broker To Buy The Artwork With Symbol, '.strtoupper(trim($row['symbol'])).', For You" class="dropdown-item makebold btn-block nsegreen-dark text-center" href="#">Request A Buy</a>
					
							<a style="margin-top:10px;" onClick="Request_A_Secondary_Sell(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['close_price'].'\',\''.$row['tokens_for_sale'].'\')" title="Send A Request To Your Broker To Sell The Artwork With Symbol, '.strtoupper(trim($row['symbol'])).', For You" class="dropdown-item makebold btn-block nsegreen-dark text-center" href="#">Request A Sell</a>
				 		</div>
			 		</div>';
				
				$tp=array($pix,$row['symbol'],$op,$hp,$lp,$cp,$tra,$vol,$buy);
			}			
			
			
			
			$data[]=$tp;
		endforeach;

		print_r(json_encode($data));
	}
	
	public function GetMarketData()
	{
		$usertype=''; $broker_id='';
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));
		
		$ret=$this->getdata_model->GetMarketStatus();		
		$sta=$ret['MarketStatus'];
		
		if (trim(strtoupper($sta)) == 'OPEN')
		{
			$qry = "SELECT daily_price.*,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS title,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS creationyear FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".date('Y-m-d')."') ORDER BY symbol";	
		}else
		{
			$latestdate=$this->getdata_model->GetLatestDate('historical_prices','price_date');			
			$qry="SELECT historical_prices.*,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS title,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS creationyear FROM historical_prices WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".$latestdate."') ORDER BY symbol";	
		}

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array(); $sn=-1;

		foreach($results as $row):
			$sell=''; $buy=''; $cp=''; $hp='-'; $lp='-'; $op='-'; $tra='-'; $vol='-'; $tp=array();
			
			if (floatval($row['open_price'])>0) $op='₦'.number_format($row['open_price'],2);			
			if (floatval($row['high_price'])>0) $hp='₦'.number_format($row['high_price'],2);
			if (floatval($row['low_price'])>0) $lp='₦'.number_format($row['low_price'],2);
			if (floatval($row['close_price'])>0) $cp='₦'.number_format($row['close_price'],2);
			if (floatval($row['trades'])>0) $tra=number_format($row['trades'],0);
			if (floatval($row['volume'])>0) $vol=number_format($row['volume'],0);
			
			if ($row['pix'])
			{
				$pix='<img onClick="ShowPix(\''.$row['symbol'].'\',\''.$row['title'].'\',\''.$row['pix'].'\');" style="cursor:pointer; height:60px;" src="'.base_url().'art-works/thumbs/t_'.$row['pix'].'" title="Click To Display '.strtoupper(trim($row['title'])).' Picture">'.'<br>'.$row['title'].', '.$row['creationyear'];				
			}
						
			$sn++;
			
			if (strtolower($usertype) == 'broker')
			{
				$buy='<input class="btn btn-nse-green makebold" onClick="BuyArt(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['close_price'].'\',\''.$row['volume'].'\')" style="cursor:pointer; height:30px; width: 75px;  text-align:center;" title="Buy '.strtoupper(trim($row['symbol'])).'" value="BUY">';
				
				$sell='<input class="btn btn-danger makebold" onClick="SellArt(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['close_price'].'\',\''.$row['volume'].'\')" style="cursor:pointer; height:30px; width: 75px; text-align:center; padding-right:3px; padding-left:3px;" title="Sell '.strtoupper(trim($row['symbol'])).'" value="SELL">';	
				
				$tp=array($row['symbol'],$op,$hp,$lp,$cp,$tra,$vol,$buy,$sell);
			}elseif (strtolower($usertype) == 'investor')// or (strtolower($usertype) == 'investor/issuer'))
			{
				//$buy='<input type="button" class="btn btn-nse-green makebold" onClick="Request_A_Secondary_Buy(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['close_price'].'\',\''.$row['tokens_for_sale'].'\')" style="cursor:pointer; height:60px; width: 100%; padding:5px;  text-align:center; padding:1px; " title="Send A Request To Your Broker To Buy This Artwork With Symbol, '.strtoupper(trim($row['symbol'])).', For You" value="REQUEST A BUY">';
				
				$buy='<div class="btn-group">
				  		<button type="button" class="btn btn-nse-green dropdown-toggle makebold" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					ACTION
							
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
							
				  		</button>
						
				  		<div class="dropdown-menu dropdown-menu-right">
							<a onClick="Request_A_Secondary_Buy(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['close_price'].'\',\''.$row['tokens_for_sale'].'\')" title="Send A Request To Your Broker To Buy The Artwork With Symbol, '.strtoupper(trim($row['symbol'])).', For You" class="dropdown-item makebold btn-block nsegreen-dark text-center" href="#">Request A Buy</a>
					
							<a style="margin-top:10px;" onClick="Request_A_Secondary_Sell(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['close_price'].'\',\''.$row['tokens_for_sale'].'\')" title="Send A Request To Your Broker To Sell The Artwork With Symbol, '.strtoupper(trim($row['symbol'])).', For You" class="dropdown-item makebold btn-block nsegreen-dark text-center" href="#">Request A Sell</a>
				 		</div>
			 		</div>';
				
				$tp=array($pix,$row['symbol'],$op,$hp,$lp,$cp,$tra,$vol,$buy);
			}			
			
			
			
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
				
				$this->getdata_model->LogDetails($brokername,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'PLACED ORDER TO BUY '.$qty.' TOKENS OF '.$symbol,$_SESSION['LogID']);			
			}
		}
				
		echo json_encode($ret);
	}
	
	public function SellTokens()
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
					$Msg=$brokername.' with email '.$email.", has successfully placed a sell order for ".number_format($qty,0)." tokens of '".$symbol."'.";
					
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
					$opts->set(CURLOPT_POSTFIELDS,http_build_query($postdata));
					
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
				
				$this->getdata_model->LogDetails($brokername,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'PLACED ORDER TO SELL '.$qty.' TOKENS OF '.$symbol,$_SESSION['LogID']);			
			}
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
			
			$data['broker_id']=''; $data['broker_recipient_code']='';
			
			if (trim(strtolower($data['usertype']))=='broker')
			{
				$det = $this->getdata_model->GetBrokerDetails($data['email']);
				
				if ($det->broker_id) $data['broker_id'] = trim($det->broker_id);
				
				
			}elseif (trim(strtolower($data['usertype']))=='investor')// or (trim(strtolower($data['usertype']))=='investor/issuer'))
			{
				$det = $this->getdata_model->GetInvestorDetails($data['email']);
				
				if ($det->broker_id) $data['broker_id'] = trim($det->broker_id);
			}
			
			
			//if ($det->recipient_code) $data['broker_recipient_code'] = $det->recipient_code;
						
			$data['balance']=$this->getdata_model->GetWalletBalance($data['email']);
			
			
			$set = $this->getdata_model->GetTradingParamaters();			
			if ($set->brokers_commission) $data['brokers_rate'] = $set->brokers_commission;
			if ($set->nse_commission) $data['nse_rate'] = $set->nse_commission;
			if ($set->price_limit_percent) $data['price_limit_percent'] = $set->price_limit_percent;
			if ($set->sms_fee) $data['sms_fee'] = $set->sms_fee; else $data['sms_fee'] = '0';
			
			$this->load->view('ui/exchange_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('');
		}
	}
}
