<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");

date_default_timezone_set('Africa/Lagos');
set_time_limit(0);

require_once(realpath('.')."/vendor/autoload.php"); 

class Directexchange extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	
	
	function GetSellers()
	{
		$symbol='';
		
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));
		
		$qry = "SELECT direct_orders.*,(SELECT company FROM brokers WHERE TRIM(brokers.broker_id)=TRIM(direct_orders.broker_id) LIMIT 0,1) AS brokername FROM direct_orders WHERE (TRIM(symbol)='".$this->db->escape_str($symbol)."') AND (TRIM(orderstatus)='Active') ORDER BY price";

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array(); $sn=-1;

		foreach($results as $row):
			$buy=''; $pr=''; $qty='';
			
			if (intval($row['available_qty'])>0) $qty=number_format($row['available_qty'],0);			
			if (floatval($row['price'])>0) $pr='₦'.number_format($row['price'],2);
								
			$sn++;

			$buy='<input type="button" class="btn btn-success makebold" onClick="BuyDirectArt(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['order_id'].'\',\''.$row['broker_id'].'\',\''.$row['price'].'\',\''.$row['investor_id'].'\',\''.$row['available_qty'].'\',\''.$row['ordertype'].'\')" style="cursor:pointer; height:30px; width: 70px;  text-align:center; padding-right:2px; padding-left:2px;" title="Click here to buy '.strtoupper(trim($row['symbol'])).'." value="BUY">';
			
			
			$tp=array($row['symbol'],$qty,$pr,$row['brokername'],$buy);
			
			$data[]=$tp;
		endforeach;

		print_r(json_encode($data));
	}
	
	
	function GetTrades()
	{
		$email=''; $broker_id=''; $startdate=''; $enddate=''; $usertype='';
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
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
	
	public function GetOrders()
	{
		$email=''; $broker_id='';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		
		$det = $this->getdata_model->GetBrokerDetails($email);		
		if ($det->broker_id) $broker_id = trim($det->broker_id);
		
		$qry = "SELECT * FROM direct_orders WHERE (TRIM(broker_id)='".$this->db->escape_str($broker_id)."') ORDER BY orderdate DESC,symbol";

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array(); $sn=-1;

		foreach($results as $row):
			$up=''; $del=''; $dt=''; $qty=''; $pr=''; $pqty=''; $amt=''; $symprice='';
			
			if ($row['orderdate']) $dt=date('d M Y H:i',strtotime($row['orderdate']));			
			if (intval($row['qty'])>0) $qty=number_format($row['qty'],0);			
			if (floatval($row['price'])>0) $pr='₦'.number_format($row['price'],2);
			
			$ret=$this->getdata_model->GetPortfolioDetails($row['symbol'],$row['broker_id'],$row['investor_id']);
		
			if ($ret->tokens) $pqty=$ret->tokens;
			
			$cpr=$this->getdata_model->GetCurrentSymbolPrice($row['symbol']);
			
			if ($cpr) $symprice=$cpr;
			
			$amt=floatval($row['qty']) * floatval($row['price']);
					
			$sn++;
			
			if ((strtolower(trim($row['orderstatus']))=='not active') or (strtolower(trim($row['orderstatus']))=='submitted') or (strtolower(trim($row['orderstatus']))=='active'))
			{
				$up='<input class="btn btn-success makebold" onClick="UpdateOrder(\''.$row['symbol'].'\',\''.$row['order_id'].'\',\''.$row['qty'].'\',\''.$row['price'].'\',\''.ucwords(strtolower($row['ordertype'])).'\',\''.$row['transtype'].'\',\''.$row['investor_id'].'\',\''.$pqty.'\',\''.$row['broker_commission'].'\',\''.$row['nse_commission'].'\',\''.$amt.'\',\''.$row['total_amount'].'\',\''.$row['sms_fee'].'\',\''.$row['transfer_fee'].'\',\''.$symprice.'\',\''.$row['available_qty'].'\')" style="cursor:pointer; height:30px; width: 70px;  text-align:center; padding-right:2px; padding-left:2px;" title="Update This '.strtoupper(trim($row['symbol'])).' '.strtoupper(trim($row['transtype'])).' Order" value="EDIT">';
				
				$del='<input class="btn btn-danger makebold" onClick="CancelOrder(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['order_id'].'\',\''.$row['qty'].'\',\''.$row['price'].'\',\''.$row['ordertype'].'\',\''.$row['transtype'].'\')" style="cursor:pointer; height:30px; width: 70px; text-align:center; padding-right:2px; padding-left:2px;" title="Cancel This '.strtoupper(trim($row['symbol'])).' '.strtoupper(trim($row['transtype'])).' Order" value="CANCEL">';	
			}		
			
			
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
			$qry = "SELECT daily_price.*,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS title,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS creationyear FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".date('Y-m-d')."') ORDER BY symbol";	
		}else
		{
			$latestdate=$this->getdata_model->GetLatestDate('historical_prices','price_date');			
			
			$qry="SELECT historical_prices.*,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS title,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS creationyear FROM historical_prices WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".$latestdate."') ORDER BY symbol";	
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
				$pix='<img onClick="ShowPix(\''.$row['symbol'].'\',\''.$row['title'].'\',\''.$row['pix'].'\',\''.$row['blockchainUrl'].'\');" style="cursor:pointer; height:60px;" src="'.base_url().'art-works/thumbs/t_'.$row['pix'].'" title="Click To Display '.strtoupper(trim($row['title'])).' Picture">'.'<br>'.$row['title'].', '.$row['creationyear'];				
			}
						
			$sn++;
			
			if (strtolower($usertype) == 'broker')
			{
				$buy='<input type="button" class="btn btn-nse-green makebold" onClick="ShowBuyers(\''.$row['symbol'].'\',\''.$row['close_price'].'\')" style="cursor:pointer; height:30px; width: 75px;  text-align:center;" title="Buy '.strtoupper(trim($row['symbol'])).'" value="BUY">';
				
				$sell='<input type="button" class="btn btn-danger makebold" onClick="SellDirectArt(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['close_price'].'\',\''.$row['volume'].'\')" style="cursor:pointer; height:30px; width: 75px; text-align:center; padding-right:3px; padding-left:3px;" title="Sell '.strtoupper(trim($row['symbol'])).'" value="SELL">';	
				
				$tp=array($row['symbol'],$op,$hp,$lp,$cp,$tra,$vol,$buy,$sell);
			}elseif (strtolower($usertype) == 'investor')// or (strtolower($usertype) == 'investor/issuer'))
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
			$qry = "SELECT daily_price.*,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS title,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS creationyear FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".date('Y-m-d')."') ORDER BY symbol";	
		}else
		{
			$latestdate=$this->getdata_model->GetLatestDate('historical_prices','price_date');			
			$qry="SELECT historical_prices.*,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS title,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(historical_prices.symbol) LIMIT 0,1) AS creationyear FROM historical_prices WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".$latestdate."') ORDER BY symbol";	
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
				$pix='<img onClick="ShowPix(\''.$row['symbol'].'\',\''.$row['title'].'\',\''.$row['pix'].'\',\''.$row['blockchainUrl'].'\');" style="cursor:pointer; height:60px;" src="'.base_url().'art-works/thumbs/t_'.$row['pix'].'" title="Click To Display '.strtoupper(trim($row['title'])).' Picture">'.'<br>'.$row['title'].', '.$row['creationyear'];				
			}
						
			$sn++;
			
			if (strtolower($usertype) == 'broker')
			{
				$buy='<input class="btn btn-nse-green makebold" onClick="BuyArt(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['close_price'].'\',\''.$row['volume'].'\')" style="cursor:pointer; height:30px; width: 75px;  text-align:center;" title="Buy '.strtoupper(trim($row['symbol'])).'" value="BUY">';
				
				$sell='<input class="btn btn-danger makebold" onClick="SellArt(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['close_price'].'\',\''.$row['volume'].'\')" style="cursor:pointer; height:30px; width: 75px; text-align:center; padding-right:3px; padding-left:3px;" title="Sell '.strtoupper(trim($row['symbol'])).'" value="SELL">';	
				
				$tp=array($row['symbol'],$op,$hp,$lp,$cp,$tra,$vol,$buy,$sell);
			}elseif (strtolower($usertype) == 'investor') //or (strtolower($usertype) == 'investor/issuer'))
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
		$brokeremail=''; $sell_broker_id='';  $sell_order_id=''; $sell_investor_id=''; $buy_broker_id=''; 
		$buy_investor_id=''; $symbol=''; $price=''; $qty=''; $available_qty=''; $broker_commission='';
		$broker_commission=''; $nse_commission=''; $sms_fee=''; $transfer_fee=''; $total_amount='';
		$ordertype=''; $min_buy_qty='';	$updaterequeststatus='0'; $request_id='';
		
		if ($this->input->post('request_id')) $request_id = trim($this->input->post('request_id'));
		if ($this->input->post('brokeremail')) $brokeremail = trim($this->input->post('brokeremail'));
		if ($this->input->post('sell_broker_id')) $sell_broker_id = trim($this->input->post('sell_broker_id'));
		if ($this->input->post('sell_order_id')) $sell_order_id = trim($this->input->post('sell_order_id'));
		if ($this->input->post('sell_investor_id')) $sell_investor_id = trim($this->input->post('sell_investor_id'));
		
		if ($this->input->post('buy_broker_id')) $buy_broker_id = trim($this->input->post('buy_broker_id'));
		if ($this->input->post('buy_investor_id')) $buy_investor_id = trim($this->input->post('buy_investor_id'));		
		if ($this->input->post('symbol')) $symbol = strtoupper(trim($this->input->post('symbol')));			
		if ($this->input->post('price')) $price = trim($this->input->post('price'));				
		if ($this->input->post('qty')) $qty = trim($this->input->post('qty'));			
		if ($this->input->post('available_qty')) $available_qty = trim($this->input->post('available_qty'));			
		if ($this->input->post('broker_commission')) $broker_commission = trim($this->input->post('broker_commission'));		
		if ($this->input->post('nse_commission')) $nse_commission = trim($this->input->post('nse_commission'));
		if ($this->input->post('sms_fee')) $sms_fee = trim($this->input->post('sms_fee'));
		if ($this->input->post('transfer_fee')) $transfer_fee = trim($this->input->post('transfer_fee'));
		if ($this->input->post('total_amount')) $total_amount = trim($this->input->post('total_amount'));
		if ($this->input->post('min_buy_qty')) $min_buy_qty = trim($this->input->post('min_buy_qty'));
		if ($this->input->post('ordertype')) $ordertype = trim($this->input->post('ordertype'));
		if (intval($this->input->post('updaterequeststatus'))==1) $updaterequeststatus = 1;
				
		$tradedate=$this->getdata_model->GetOrderTime();
		
		$seller_recipient_code=''; $sell_broker_recipient_code='';
		$buyer_recipient_code =''; $buy_broker_recipient_code='';
		$nse_recipient_code='';
		
		//Get recipient codes
		$seller_recipient_code = $this->getdata_model->GetRecipientCode($sell_investor_id,'investor');
		$sell_broker_recipient_code = $this->getdata_model->GetRecipientCode($sell_broker_id,'broker');
		$buyer_recipient_code = $this->getdata_model->GetRecipientCode($buy_investor_id,'investor');
		$buy_broker_recipient_code = $this->getdata_model->GetRecipientCode($buy_broker_id,'broker');
		$nse_recipient_code = $this->getdata_model->GetNSERecipientCode('admin');
		
		//$file = fopen('aaa.txt',"w"); fwrite($file,"Seller Code=".$seller_recipient_code."\r\nSeller Id=".$sell_investor_id); fclose($file); return;
		
		//Get seller broker details
		$sell_broker_email=''; $sell_broker_phone=''; $sell_broker_name='';		
		$r = $this->getdata_model->GetBrokerDetails($sell_broker_id);
		
		if ($r->email) $sell_broker_email = trim($r->email);
		if ($r->phone) $sell_broker_phone = trim($r->phone);
		if ($r->company) $sell_broker_name = trim($r->company);
		
		//Get buyer broker details
		$buy_broker_email=''; $buy_broker_phone=''; $buy_broker_name='';		
		$r = $this->getdata_model->GetBrokerDetails($buy_broker_id);
		
		$buy_broker_email = $brokeremail;
		if ($r->phone) $buy_broker_phone = trim($r->phone);
		if ($r->company) $buy_broker_name = trim($r->company);
		
		//Get sell investor details
		$sell_investor_email=''; $sell_investor_phone=''; $sell_investor_name='';		
		$r = $this->getdata_model->GetInvestorDetails($sell_investor_id);
		
		if ($r->user_name) $sell_investor_name = trim($r->user_name);
		if ($r->phone) $sell_investor_phone = trim($r->phone);
		if ($r->email) $sell_investor_email = trim($r->email);
		
		//Get buy investor details
		$buy_investor_email=''; $buy_investor_phone=''; $buy_investor_name='';		
		$r = $this->getdata_model->GetInvestorDetails($buy_investor_id);
		
		if ($r->user_name) $buy_investor_name = trim($r->user_name);
		if ($r->phone) $buy_investor_phone = trim($r->phone);
		if ($r->email) $buy_investor_email = trim($r->email);
				
		//Generate data
		$trade_id=$this->getdata_model->GenerateTradeId();
		
		$TradeAmount = floatval($qty) * floatval($price);		
		$TransferFee = 0; $current_price=0; $nse_recipientcode='';
				
		$paystack 		= $this->getdata_model->GetPaystackSettings();
		$current_price 	= $this->getdata_model->GetSymbolPrice($symbol);
		$setings		= $this->getdata_model->GetParamaters();
		
		if ($paystack->transfer_fee) $TransferFee = $paystack->transfer_fee;
		if ($setings->recipient_code) $nse_recipientcode = $setings->recipient_code;
		
		$nsefee = round(floatval($nse_commission) * 2,2);
						
		$total_seller_fee=floatval($TradeAmount) - floatval($broker_commission) - floatval($nse_commission) - floatval($TransferFee) - floatval($sms_fee);
		
		$trade=array('sell_broker_id'=>$sell_broker_id,'sell_order_id'=>$sell_order_id,'buy_broker_id'=>$buy_broker_id,'buy_order_id'=>'','trade_id'=>$trade_id,'symbol'=>$symbol,'num_tokens'=>$qty,'ask_price'=>$price,'bid_price'=>'','price'=>$price,'market_price'=>$current_price,'sell_broker_fee'=>$broker_commission,'buy_broker_fee'=>$broker_commission,'nse_fee'=>$nsefee,'transfer_fees'=>($TransferFee * 4),'tradestatus'=>1,'payment_status'=>'Successful','tradedate'=>$tradedate,'trade_amount'=>$TradeAmount,'total_buyer_fee'=>$total_amount,'total_seller_fee'=>$total_seller_fee,'seller_recipient_code'=>$seller_recipient_code,'sell_broker_recipient_code'=>$sell_broker_recipient_code,'buyer_recipient_code'=>$buyer_recipient_code,'buy_broker_recipient_code'=>$buy_broker_recipient_code,'nse_recipient_code'=>$nse_recipient_code,'buy_broker_email'=>$buy_broker_email,'sell_broker_email'=>$sell_broker_email,'buy_investor_email'=>$buy_investor_id,'sell_investor_email'=>$sell_investor_id,'sell_broker_phone'=>$sell_broker_phone,'buy_broker_phone'=>$buy_broker_phone,'sell_investor_phone'=>$sell_investor_phone,'buy_investor_phone'=>$buy_investor_phone,'sell_broker_name'=>$sell_broker_name,'buy_broker_name'=>$buy_broker_name,'sell_investor_name'=>$sell_investor_name,'buy_investor_name'=>$buy_investor_name,'min_buy_qty'=>$min_buy_qty,'sell_ordertype'=>$ordertype);
		
				
		//Checkif broker has recipientcode
		if (!isset($buy_broker_recipient_code))
		{
			$m='Transaction failed. Your have not added your bank details to your profile. Without your bank details, you cannot trade on the platform. Go to your user profile in the user avatar menu items and update your account information.';
			
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			if (!isset($buyer_recipient_code))
			{
				$m="Transaction failed. The investor's bank details have not been added to the profile. Without the investor's bank details, you cannot trade on the platform. Ask the investor to add the bank details in the user profile module.";
			
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{
				if (!isset($nse_recipient_code))
				{
					$m="Transaction failed. The Nigerian Stock Exchange (NSE) bank details has not been captured by the system administration. Please contact the system administrator at <a href='mailto:support@naijaartmart.com'>support@naijaartmart.com</a> to capture NSE bank details.";
				
					$ret=array('status'=>'FAIL','Message'=>$m);
				}else
				{
					//check broker balance
					$bal=$this->getdata_model->GetWalletBalance($brokeremail);
					
					if (floatval($bal) < floatval($total_amount))
					{
						$m="You do not have enough balance in your e-wallet to buy this security. Your current e-wallet balance is <b>₦".number_format($bal,2)."</b> and the total amount needed for buying ".number_format($qty,0)." tokens of ".$symbol." is <b>₦" . number_format($total_amount,2) . "</b>.";
						
						$ret=array('status'=>'FAIL','Message'=>$m);
					}else
					{
						$Msg='';					
							
						//Send trade to trading direct engine
						$res = $this->getdata_model->DirectMatchingEngine($trade);
						
						if ($res['Status']<> 1)
						{
							$ret=array('status'=>'FAIL','Message'=>$res['msg']);
							
							$Msg ="Purchase of ".number_format($qty,0)." tokens of artwork with symbol, ".strtoupper($symbol).", by ".strtoupper($buy_broker_name)." with email ".$buy_broker_email.", was not successful. ERROR: ".strtoupper($res['msg']);
						}else
						{
							if (intval($updaterequeststatus)==1)
							{
								//Update request_to_buy table
								$this->db->trans_start();	
						
								$dat=array('request_status' => 'Treated');			
				
								$this->db->where(array('request_id'=>$request_id));
								$this->db->update('request_to_buy',$dat);
															
								$this->db->trans_complete();
							}
							
							$Msg=$buy_broker_name.' with email '.$buy_broker_email.", has successfully bought ".number_format($qty,0)." tokens of '".$symbol."'.";
							
							//$ret=array('status'=>'OK','Message'=>'OK');
							
							//Send Messages
							$rwt = $this->getdata_model->GetArtTitle($symbol);
							$title = trim($rwt);
							
							//Buyer
							$msgtype='system';						
							$header='Purchase Of '.number_format($qty,0).' Tokens Of '.strtoupper($symbol);
							$groups='';
							$emails=$buy_broker_email.','.$buy_investor_email;
							$phones=$buy_broker_phone.','.$buy_investor_phone;
							$category='Message';
							$expiredate=NULL;
							$display_status=1;
							$sender='System';						
							
							$details = strtoupper($buy_broker_name)." has purchased ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title)." at ₦".number_format($price,2)." per token for ".strtoupper($buy_investor_name).". Broker's email is ".$buy_broker_email." and phone number is ".$buy_broker_phone.".";
							
							$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
							
							//Send Email
							$from='admin@naijaartmart.com';
							$to=$buy_broker_email.','.$buy_investor_email;
							$subject=$header;
							$Cc='idongesit_a@yahoo.com';
											
							$img=base_url()."images/logo.png";
												
							//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
						
							$message = '
								<html>
								<head>
								<meta charset="utf-8">
								<title>Naija Art Mart | Purchase Of Artwork Tokens</title>
								</head>
								<body>								
																	
								Dear Investor,<br><br>
										
								'.strtoupper($buy_broker_name)." has purchased ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title).", at ₦".number_format($price,2)." per token for ".strtoupper($buy_investor_name).". Broker's email is ".$buy_broker_email." and phone number is ".$buy_broker_phone.'
												
								<p>Best Regards</p>
								Naija Art Mart
								
								</body>
								</html>';
								
							$altmessage = '
								Dear Investor,
										
								'.strtoupper($buy_broker_name)." has purchased ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title)." at NGN".number_format($price,2)." per token for ".strtoupper($buy_investor_name).". Broker's email is ".$buy_broker_email." and phone number is ".$buy_broker_phone.'
										
								Best Regards
								Naija Art Mart';
							
							if ($to) $v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$brokername);
							
							//Seller Messages
							$msgtype='system';						
							$header='Sales Of '.number_format($qty,0).' Tokens Of '.strtoupper($symbol);
							$groups='';
							$emails=$sell_broker_email.','.$sell_investor_email;
							$phones=$sell_broker_phone.','.$sell_investor_phone;
							$category='Message';
							$expiredate=NULL;
							$display_status=1;
							$sender='System';						
							
							$details = strtoupper($sell_broker_name)." has sold ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title)." at ₦".number_format($price,2)." per token for ".strtoupper($sell_investor_name).". Broker's email is ".$sell_broker_email." and phone number is ".$sell_broker_phone.".";
							
							$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
							
							//Send Email
							$from='admin@naijaartmart.com';
							$to=$sell_broker_email.','.$sell_investor_email;
							$subject=$header;
							$Cc='idongesit_a@yahoo.com';
											
							$img=base_url()."images/logo.png";
												
							//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
						
							$message = '
								<html>
								<head>
								<meta charset="utf-8">
								<title>Naija Art Mart | Sale Of Artwork Tokens</title>
								</head>
								<body>								
																	
								Dear Investor,<br><br>
										
								'.strtoupper($sell_broker_name)." has sold ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title).", at ₦".number_format($price,2)." per token for ".strtoupper($sell_investor_name).". Broker's email is ".$sell_broker_email." and phone number is ".$sell_broker_phone.'
												
								<p>Best Regards</p>
								Naija Art Mart
								
								</body>
								</html>';
								
							$altmessage = '
								Dear Investor,
										
								'.strtoupper($sell_broker_name)." has sold ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title)." at NGN".number_format($price,2)." per token for ".strtoupper($sell_investor_name).". Broker's email is ".$sell_broker_email." and phone number is ".$sell_broker_phone.'
										
								Best Regards
								Naija Art Mart';
							
							if ($to) $v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$brokername);
							
							$ret=array('status'=>'OK','Message'=>'');
						}				
						
						$remote_ip=$_SERVER['REMOTE_ADDR'];
						$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
						
						//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
						$this->getdata_model->LogDetails($buy_broker_name,$Msg,$brokeremail,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'PURCHASED '.$qty.' TOKENS OF '.$symbol,$_SESSION['LogID']);		
					}	
				}	
			}
		}
				
		echo json_encode($ret);
	}
	
	function PlaceSellOrder()
	{		
		$broker_id=''; $brokerphone=''; $broker_recipient_code=''; $investor_recipient_code=''; $brokername=''; 
		
		$email=''; $investor_id='';   $symbol=''; $price=''; $qty=''; $available_qty='';
		$ordertype=''; $broker_commission=''; $nse_commission=''; $sms_fee=''; $investor_email='';
		$investor_phone=''; $transfer_fee=''; $total_amount=''; $updaterequeststatus='0'; $request_id='';
				
		if ($this->input->post('request_id')) $request_id = trim($this->input->post('request_id'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));		
		if ($this->input->post('investor_id')) $investor_id = trim($this->input->post('investor_id'));
		if ($this->input->post('ordertype')) $ordertype = trim($this->input->post('ordertype'));		
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));			
		if ($this->input->post('price')) $price = trim($this->input->post('price'));				
		if ($this->input->post('qty')) $qty = trim($this->input->post('qty'));		
		if ($this->input->post('available_qty')) $available_qty = trim($this->input->post('available_qty'));		
		if ($this->input->post('broker_commission')) $broker_commission = trim($this->input->post('broker_commission'));		
		if ($this->input->post('nse_commission')) $nse_commission = trim($this->input->post('nse_commission'));		
		if ($this->input->post('sms_fee')) $sms_fee = trim($this->input->post('sms_fee'));
		if ($this->input->post('transfer_fee')) $transfer_fee = trim($this->input->post('transfer_fee'));
		if ($this->input->post('total_amount')) $total_amount = trim($this->input->post('total_amount'));
		if (intval($this->input->post('updaterequeststatus'))==1) $updaterequeststatus = 1;
		
		$transtype='Sell';
		$orderstatus='Submitted';
		
		$orderdate=$this->getdata_model->GetOrderTime();
		$order_id=$this->getdata_model->GetId('direct_orders','order_id');
		
		$det = $this->getdata_model->GetBrokerDetails($email);
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
			$m='Placing of sell order failed. Your have not added your bank details to your profile. Without your bank details, you cannot trade on the platform. Go to your user profile in the user avatar menu items and update your account information.';
			
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			if (!isset($investor_recipient_code))
			{
				$m="Placing of sell order failed. The investor's bank details have not been added to the profile. Without the investor's bank details, you cannot trade on the platform. Ask the investor to add the bank details in the user profile module.";
			
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{
				$Msg='';	
									
				//Send order to trading gateway
				$order=array('order_id'=>$order_id,'broker_id'=>$broker_id,'broker_email'=>$email,'broker_phone'=>$brokerphone,'investor_id'=>$investor_id,'investor_email'=>$investor_email,'investor_phone'=>$investor_phone,'transtype'=>$transtype,'symbol'=>$symbol,'price'=>$price,'qty'=>$qty,'available_qty'=>$qty,'ordertype'=>$ordertype,'orderdate'=>$orderdate,'orderstatus'=>$orderstatus,'broker_commission'=>$broker_commission,'nse_commission'=>$nse_commission,'transfer_fee'=>'','sms_fee'=>$sms_fee,'total_amount'=>'','trade_amount'=>'','broker_recipient_code'=>$broker_recipient_code,'investor_recipient_code'=>$investor_recipient_code,'transfer_fee'=>$transfer_fee,'total_amount'=>$total_amount);
				
				$res=$this->getdata_model->ValidateDirectOrder($order);
				
				if ($res['status']<> 1)
				{
					$ret=array('status'=>'FAIL','Message'=>$res['msg']);
				}else
				{					
					$rt = $this->getdata_model->SaveDirectOrder($res['order']);//Save Order
					
					if ($rt == true)
					{
						if (intval($updaterequeststatus)==1)
						{
							//Update request_to_buy table
							$this->db->trans_start();	
					
							$dat=array('request_status' => 'Treated');			
			
							$this->db->where(array('request_id'=>$request_id));
							$this->db->update('request_to_buy',$dat);
														
							$this->db->trans_complete();
						}
						
						$Msg=$brokername.' with email '.$email.", has successfully placed a sell order for ".number_format($qty,0)." tokens of '".$symbol."'.";
						
						$ret=array('status'=>'OK','Message'=>'OK');
						
						$remote_ip=$_SERVER['REMOTE_ADDR'];
						$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
						
						//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
						$this->getdata_model->LogDetails($brokername,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'PLACED ORDER TO SELL '.$qty.' TOKENS OF '.$symbol,$_SESSION['LogID']);	
					}else
					{
						$ret=array('status'=>'FAIL','Message'=>'Could not save sell order.');			
					}
				}	
			}
		}
				
		echo json_encode($ret);
	}
	
	function UpdateSellOrder()
	{		
		$broker_id=''; $brokerphone=''; $broker_recipient_code=''; $investor_recipient_code=''; $brokername=''; 
		
		$email=''; $investor_id='';   $symbol=''; $price=''; $qty=''; $available_qty=''; $old_invid='';
		$ordertype=''; $broker_commission=''; $nse_commission=''; $sms_fee=''; $investor_email='';
		$investor_phone=''; $transfer_fee=''; $total_amount=''; $order_id='';
				
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('order_id')) $order_id = trim($this->input->post('order_id'));
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));		
		if ($this->input->post('investor_id')) $investor_id = trim($this->input->post('investor_id'));
		if ($this->input->post('old_invid')) $old_invid = trim($this->input->post('old_invid'));
		if ($this->input->post('ordertype')) $ordertype = trim($this->input->post('ordertype'));		
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));			
		if ($this->input->post('price')) $price = trim($this->input->post('price'));				
		if ($this->input->post('qty')) $qty = trim($this->input->post('qty'));		
		if ($this->input->post('available_qty')) $available_qty = trim($this->input->post('available_qty'));		
		if ($this->input->post('broker_commission')) $broker_commission = trim($this->input->post('broker_commission'));		
		if ($this->input->post('nse_commission')) $nse_commission = trim($this->input->post('nse_commission'));		
		if ($this->input->post('sms_fee')) $sms_fee = trim($this->input->post('sms_fee'));
		if ($this->input->post('transfer_fee')) $transfer_fee = trim($this->input->post('transfer_fee'));
		if ($this->input->post('total_amount')) $total_amount = trim($this->input->post('total_amount'));
		
		$transtype='Sell';
		
		$last_update_date=date('Y-m-d H:i:s');
				
		$det = $this->getdata_model->GetBrokerDetails($email);
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
			$m='Updating of sell order failed. Your have not added your bank details to your profile. Without your bank details, you cannot trade on the platform. Go to your user profile in the user avatar menu items and update your account information.';
			
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			if (!isset($investor_recipient_code))
			{
				$m="Updating of sell order failed. The investor's bank details have not been added to the profile. Without the investor's bank details, you cannot trade on the platform. Ask the investor to add the bank details in the user profile module.";
			
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{
				$Msg='';	
									
				//Send order to trading gateway
				$sql = "SELECT * FROM direct_orders WHERE (TRIM(order_id)=".$this->db->escape_str($order_id).") AND (TRIM(broker_id)='".$this->db->escape_str($broker_id)."')";		
		
				$query = $this->db->query($sql);
							
				if ($query->num_rows() == 0 )
				{
					$m='Order update was not successful. Order with Id <b>'.$order_id.'</b> was not found in the database.';
					$ret=array('status'=>'FAIL','Message'=>$m);
				}else
				{
					$oid=''; $bid=''; $invid=''; $ty=''; $ot=''; $sym=''; $pr=''; $qt=''; $aqt='';
					$sta=''; $bf=''; $nf=''; $tf=''; $sf=''; $bc=''; $ic=''; $odt=''; $amt='';
								
					$row = $query->row();			

					if ($row->order_id) $oid=$row->order_id;
					if ($row->broker_id) $bid=trim($row->broker_id);
					if ($row->investor_id) $invid=trim($row->investor_id);
					if ($row->transtype) $ty=trim($row->transtype);
					if ($row->ordertype) $ot=trim($row->ordertype);
					if ($row->symbol) $sym=trim($row->symbol);
					if ($row->price) $pr=$row->price;						
					if ($row->qty) $qt=$row->qty;
					if ($row->available_qty) $aqt=$row->available_qty;						
					if ($row->orderstatus) $sta=trim($row->orderstatus);
					if ($row->broker_commission) $bf=$row->broker_commission;
					if ($row->nse_commission) $nf=$row->nse_commission;						
					if ($row->transfer_fee) $tf=$row->transfer_fee;
					if ($row->sms_fee) $sf=$row->sms_fee;
					if ($row->broker_recipient_code) $bc=trim($row->broker_recipient_code);
					if ($row->investor_recipient_code) $ic=trim($row->investor_recipient_code);
					if ($row->orderdate) $odt=trim($row->orderdate);
					if ($row->total_amount) $amt=$row->total_amount;
					
					$OldValues='Order Date: '.$odt.'; Order Id: '.$oid.'; Trade Type: '.$ty.'; Broker Id: '.$bid.'; Investor Id: '.$invid.'; Security: '.$sym.'; Order Quantity: '.$qt.'; Price Per Token: '.$pr.'; Order Type: '.$ot.'; Order Status: '.$sta.'; Broker Commission: '.$bf.'; NSE Commission: '.$nf.'; Transfer Fee: '.$tf.'; SMS Fee: '.$sf.'; Total Amount: '.$amt;
					
					$NewValues='Order Date: '.$odt.'; Order Id: '.$oid.'; Trade Type: '.$transtype.'; Broker Id: '.$bid.'; Investor Id: '.$investor_id.'; Security: '.$symbol.'; Order Quantity: '.$qty.'; Price Per Token: '.$price.'; Order Type: '.$ordertype.'; Order Status: '.$sta.'; Broker Commission: '.$broker_commission.'; NSE Commission: '.$nse_commission.'; Transfer Fee: '.$transfer_fee.'; SMS Fee: '.$sms_fee.'; Total Amount: '.$total_amount;
					
					$this->db->trans_start();
				
					$dat=array(
						'investor_id' 				=> $this->db->escape_str($investor_id),
						'transtype' 				=> $this->db->escape_str($transtype),
						'ordertype'					=> $this->db->escape_str($ordertype),			
						'symbol' 					=> $this->db->escape_str($symbol),			
						'price'						=> $this->db->escape_str($price),
						'qty' 						=> $this->db->escape_str($qty),			
						'available_qty' 			=> $this->db->escape_str($available_qty),
						'broker_commission' 		=> $this->db->escape_str($broker_commission),
						'nse_commission' 			=> $this->db->escape_str($nse_commission),
						'transfer_fee' 				=> $this->db->escape_str($transfer_fee),
						'sms_fee' 					=> $this->db->escape_str($sms_fee),
						'broker_recipient_code' 	=> $this->db->escape_str($broker_recipient_code),
						'investor_recipient_code'	=> $this->db->escape_str($investor_recipient_code),			
						'last_update_date' 			=> $this->db->escape_str($last_update_date),
						'total_amount' 				=> $this->db->escape_str($total_amount)
					);
					
					$this->db->where(array('order_id' => $order_id, 'broker_id' => $broker_id));
					$this->db->update('direct_orders', $dat);			
					$this->db->trans_complete();
					
					if ($this->db->trans_status() === FALSE)
					{
						$Msg="Broker ".strtoupper($brokername)." attempted updating sell order with order Id ".$order_id." but failed.";
						$m='Sell Order Could Not Be Updated.';
						$ret=array('status'=>'FAIL','Message'=>$m);
					}else
					{						
						$Msg="Sell order has been edited successfully by ".$_SESSION['email'].". Old Values => ".$OldValues.". Updated values => ".$NewValues;
				
						//Log activity
						$Msg=$brokername.' with email '.$email.", has successfully edited sell order with order Id ".$order_id.".";
						
						$ret=array('status'=>'OK','Message'=>'OK');	
					}
					
					$remote_ip=$_SERVER['REMOTE_ADDR'];
					$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
					//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
					$this->getdata_model->LogDetails($brokername,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'EDITE SELL ORDER',$_SESSION['LogID']);
				}
			}
		}
				
		echo json_encode($ret);
	}
	
	function CancelSellOrder()
	{		
		$symbol=''; $order_id=''; $qty=''; $price=''; $ordertype=''; $transtype=''; $broker_email='';
		$broker_name=''; $broker_id='';

		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));
		if ($this->input->post('order_id')) $order_id = trim($this->input->post('order_id'));	
		if ($this->input->post('qty')) $qty = trim($this->input->post('qty'));
		if ($this->input->post('price')) $price = trim($this->input->post('price'));
		if ($this->input->post('ordertype')) $ordertype = trim($this->input->post('ordertype'));
		if ($this->input->post('transtype')) $transtype = trim($this->input->post('transtype'));							
		if ($this->input->post('email')) $broker_email = trim($this->input->post('email'));
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));
		if ($this->input->post('broker_name')) $broker_name = trim($this->input->post('broker_name'));
		
		$dt=date('Y-m-d H:i:s');
				
		//Checkif sell order exists
		$Msg='';	
							
		$sql = "SELECT * FROM direct_orders WHERE (TRIM(order_id)=".$this->db->escape_str($order_id).") AND (TRIM(symbol)='".$this->db->escape_str($symbol)."') AND (TRIM(broker_id)='".$this->db->escape_str($broker_id)."')";		

		$query = $this->db->query($sql);
					
		if ($query->num_rows() == 0 )
		{
			$m='Cancellation of sell order with Id '.$order_id.'. was not successful. Order with Id <b>'.$order_id.'</b> was not found in the database.';
			$ret=$m;
		}else
		{
			$this->db->trans_start();		
			$this->db->delete('direct_orders', array('order_id'=>$order_id, 'symbol'=>$symbol,'broker_id'=>$broker_id));
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE)
			{
				$Msg="Cancellation of sell order by the broker ".strtoupper($broker_name)." for sell order with order Id ".$order_id." failed.";
				
				$m='Sell Order Cancellation Failed.';
				$ret=$m;
			}else
			{								
				$Msg='Cancellation of sell order was successful. Order details include: Broker Name: '.$broker_name.'; Broker Id: '.$broker_id.'; Order Id: '.$order_id.'; Trade Type: '.$transtype.'; Security: '.$symbol.'; Order Quantity: '.$qty.'; Price Per Token: '.$price.'; Order Type: '.$ordertype;
		
				//Log activity
				$Msg=$broker_name.' with email '.$broker_email.", has successfully cancelled sell order with order Id ".$order_id.".";
				
				$ret='OK';	
			}
			
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
			$this->getdata_model->LogDetails($broker_name,$Msg,$broker_email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'CANCELLED SELL ORDER',$_SESSION['LogID']);
		}
			
		echo $ret;
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
				if ($det->user_name) $data['brokername'] = trim($det->user_name);
				
			}elseif (trim(strtolower($data['usertype']))=='investor')
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
			if ($set->min_buy_qty) $data['min_buy_qty'] = $set->min_buy_qty; else $data['min_buy_qty'] = '';
			
			//Paystack settings
			$pay = $this->getdata_model->GetPaystackSettings();			
			if ($pay->transfer_fee) $data['transfer_fee']=$pay->transfer_fee; else $data['transfer_fee']=''; 
						
			$this->load->view('ui/directexchange_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('');
		}
	}
}
