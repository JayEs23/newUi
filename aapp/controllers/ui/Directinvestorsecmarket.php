<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");

date_default_timezone_set('Africa/Lagos');
set_time_limit(0);

require_once(realpath('.')."/vendor/autoload.php"); 

class Directinvestorsecmarket extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}	
	
	function GetSellers()
	{
		$symbol='';
		// print_r($_SESSION);
		
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));
		
		$qry = "SELECT direct_orders.*,(SELECT company FROM brokers WHERE TRIM(brokers.broker_id)=TRIM(direct_orders.broker_id) LIMIT 0,1) AS brokername FROM direct_orders WHERE (TRIM(symbol)='".$this->db->escape_str($symbol)."') AND (TRIM(orderstatus)='Active') ORDER BY price";

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		// print_r(json_encode($results)); die();

		$data=array(); $sn=-1;

		foreach($results as $row):
			$buy=''; $pr=''; $qty='';
			
			if (intval($row['available_qty'])>0) $qty=number_format($row['available_qty'],0);			
			if (floatval($row['price'])>0) $pr='₦'.number_format($row['price'],2);
								
			$sn++;
			$disabled = ($_SESSION['email'] == $row['investor_id'])? 'disabled' : '';
			$class = ($_SESSION['email'] == $row['investor_id'])? 'btn-warning' : 'btn-success';
			$buy='<input type="button" '.$disabled.' class="btn '.$class.' makebold" onClick="BuyDirectArt(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['order_id'].'\',\''.$row['broker_id'].'\',\''.$row['price'].'\',\''.$row['investor_id'].'\',\''.$row['available_qty'].'\',\''.$row['ordertype'].'\')" style="cursor:pointer; height:30px; width: 70px;  text-align:center; padding-right:2px; padding-left:2px;" title="Click here to buy '.strtoupper(trim($row['symbol'])).'." value="BUY">';
			
			
			$tp=array($row['symbol'],$qty,$pr,$buy);
			
			$data[]=$tp;
		endforeach;

		print_r(json_encode($data));
	}	
	
	function GetTrades()
	{
		$email=''; $startdate=''; $enddate=''; $usertype='';
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('startdate')) $startdate = $this->input->post('startdate');
		if ($this->input->post('enddate')) $enddate = $this->input->post('enddate');
				
		$qry = "SELECT * FROM trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND ((TRIM(buy_investor_email)='".$this->db->escape_str($email)."') OR (TRIM(sell_investor_email)='".$this->db->escape_str($email)."')) AND (TRIM(payment_status)='Successful') ORDER BY tradedate DESC";

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array();

		foreach($results as $row):
			$dt=''; $qty=''; $pr=''; $amt=0;
			
			if ($row['tradedate']) $dt=date('d M Y H:i',strtotime($row['tradedate']));			
			if (intval($row['num_tokens']) > 0) $qty=number_format($row['num_tokens'],0);			
			if (floatval($row['trade_price']) > 0) $pr='₦'.number_format($row['trade_price'],2);
			
			$amt = intval($row['num_tokens']) * floatval($row['trade_price']);			
			$amt = '₦'.number_format($amt,2);			
					
			$tp=array($dt,$row['trade_id'],$row['symbol'],$qty,$pr,$amt,$row['sell_investor_email'],$row['buy_investor_email']);
			
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
	
	function GetTokensFromPortfolio()
	{
		$email=''; $ret=''; $symbol=''; $t='0';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));
				
		$ret=$this->getdata_model->GetPortfolioDetails($symbol,'',$email);
		
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
	
	public function GetOrders()
	{
		$email=''; $investor_id='';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		
		$det = $this->getdata_model->GetInvestorDetails($email);		
		if ($det->uid) $investor_id = trim($det->uid);
		
		$qry = "SELECT * FROM direct_orders WHERE (TRIM(investor_id)='".$this->db->escape_str($email)."') OR (TRIM(investor_id)='".$this->db->escape_str($investor_id)."') ORDER BY orderdate DESC,symbol";

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array(); $sn=-1;

		foreach($results as $row):
			$up=''; $del=''; $dt=''; $qty=''; $pr=''; $pqty=''; $amt=''; $symprice='';
			
			if ($row['orderdate']) $dt=date('d M Y H:i',strtotime($row['orderdate']));			
			if (intval($row['qty'])>0) $qty=number_format($row['qty'],0);			
			if (floatval($row['price'])>0) $pr='₦'.number_format($row['price'],2);
			
			$ret=$this->getdata_model->GetPortfolioDetails($row['symbol'],'',$row['investor_id']);
		
			if ($ret->tokens) $pqty=$ret->tokens;
			
			$cpr=$this->getdata_model->GetCurrentSymbolPrice($row['symbol']);
			
			if ($cpr) $symprice=$cpr;
			
			$amt=floatval($row['qty']) * floatval($row['price']);
					
			$sn++;
			
			if ((strtolower(trim($row['orderstatus']))=='not active') or (strtolower(trim($row['orderstatus']))=='submitted') or (strtolower(trim($row['orderstatus']))=='active'))
			{
				$up='<input class="btn btn-success makebold" onClick="UpdateOrder(\''.$row['symbol'].'\',\''.$row['order_id'].'\',\''.$row['qty'].'\',\''.$row['price'].'\',\''.ucwords(strtolower($row['ordertype'])).'\',\''.$row['transtype'].'\',\''.$row['investor_id'].'\',\''.$pqty.'\',\''.$row['transfer_fee'].'\',\''.$row['nse_commission'].'\',\''.$amt.'\',\''.$row['total_amount'].'\',\''.$row['sms_fee'].'\',\''.$symprice.'\',\''.$row['available_qty'].'\')" style="cursor:pointer; height:30px; width: 70px;  text-align:center; padding-right:2px; padding-left:2px;" title="Update This '.strtoupper(trim($row['symbol'])).' '.strtoupper(trim($row['transtype'])).' Order" value="EDIT">';
				
				$del='<input class="btn btn-danger makebold" onClick="CancelOrder(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['order_id'].'\',\''.$row['qty'].'\',\''.$row['price'].'\',\''.$row['ordertype'].'\',\''.$row['transtype'].'\')" style="cursor:pointer; height:30px; width: 70px; text-align:center; padding-right:2px; padding-left:2px;" title="Cancel This '.strtoupper(trim($row['symbol'])).' '.strtoupper(trim($row['transtype'])).' Order" value="CANCEL">';	
			}		
			
			
			$tp=array($dt,$row['order_id'],$row['symbol'],$qty,$pr,$row['ordertype'],$row['investor_id'],$row['orderstatus'],$up,$del);
			
			$data[]=$tp;
		endforeach;

		print_r(json_encode($data));
	}
	
	function GetDirectMarketData()
	{
		$usertype=''; $data=array();
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		$usertype = 'Investor';

		if (strtolower($usertype) == 'investor')
		{
			$ret=$this->getdata_model->GetMarketStatus();		
			$sta=$ret['MarketStatus'];	
			
			if (trim(strtoupper($sta)) == 'OPEN')
			{
				$qry = "SELECT DISTINCT daily_price.*,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS title,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS creationyear FROM daily_price JOIN direct_orders ON daily_price.symbol = direct_orders.symbol WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".date('Y-m-d')."') GROUP BY daily_price.symbol ORDER BY symbol";
	
			}else
			{
				$latestdate=$this->getdata_model->GetLatestDate('historical_prices','price_date');			
				
				$qry = "SELECT 
			          historical_prices.*, 
			          (SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol) = TRIM(historical_prices.symbol) LIMIT 0,1) AS blockchainUrl, 
			          (SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol) = TRIM(historical_prices.symbol) LIMIT 0,1) AS pix, 
			          (SELECT title FROM art_works WHERE TRIM(art_works.symbol) = TRIM(historical_prices.symbol) LIMIT 0,1) AS title, 
			          (SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol) = TRIM(historical_prices.symbol) LIMIT 0,1) AS creationyear 
			        FROM 
			          historical_prices 
			          JOIN direct_orders ON historical_prices.symbol = direct_orders.symbol 
			        WHERE 
			          DATE_FORMAT(price_date,'%Y-%m-%d') = '".$latestdate."' 
			        GROUP BY 
			          historical_prices.symbol, 
			          blockchainUrl 
			        ORDER BY symbol";
	
			}	
			
			$query = $this->db->query(stripslashes($qry));
			
			$results = $query->result_array();
			
			return $results;
			$sn=-1;	
			
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
				
				
				$buy='<input type="button" class="btn btn-nse-green makebold" onClick="ShowBuyers(\''.$row['symbol'].'\',\''.$row['close_price'].'\')" style="cursor:pointer; height:30px; width: 75px;  text-align:center;" title="Buy '.strtoupper(trim($row['symbol'])).'" value="BUY">';
				
				$sell='<input type="button" class="btn btn-danger makebold" onClick="SellDirectArt(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['close_price'].'\',\''.$row['volume'].'\')" style="cursor:pointer; height:30px; width: 75px; text-align:center; padding-right:3px; padding-left:3px;" title="Sell '.strtoupper(trim($row['symbol'])).'" value="SELL">';	
				
				$tp=array($pix,$row['symbol'],$op,$hp,$lp,$cp,$tra,$vol,$buy,$sell);
					
				$data[]=$tp;
			endforeach;	
		}
		
		return $data;
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
		$investor_mail=''; $sell_broker_id=''; $sell_order_id=''; $sell_investor_id='';
		$buy_broker_id=''; $buy_investor_id=''; $symbol=''; $price=''; $qty=''; $available_qty=''; 
		$nse_commission=''; $sms_fee=''; $transfer_fee=''; $total_amount=''; $min_buy_qty='';
		$ordertype=''; $brokers_rate=''; $updaterequeststatus='0'; $request_id='';
		
		if ($this->input->post('request_id')) $request_id = trim($this->input->post('request_id'));
		if ($this->input->post('sell_broker_id')) $sell_broker_id = trim($this->input->post('sell_broker_id'));
		if ($this->input->post('sell_order_id')) $sell_order_id = trim($this->input->post('sell_order_id'));
		if ($this->input->post('sell_investor_id')) $sell_investor_id = trim($this->input->post('sell_investor_id'));
		if ($this->input->post('buy_investor_id')) $buy_investor_id = trim($this->input->post('buy_investor_id'));
		if ($this->input->post('symbol')) $symbol = strtoupper(trim($this->input->post('symbol')));
		
		if ($this->input->post('investor_mail')) $investor_mail = trim($this->input->post('investor_mail'));
		if ($this->input->post('price')) $price = trim($this->input->post('price'));
		if ($this->input->post('qty')) $qty = trim($this->input->post('qty'));
		if ($this->input->post('available_qty')) $available_qty = trim($this->input->post('available_qty'));
		if ($this->input->post('brokers_rate')) $brokers_rate = trim($this->input->post('brokers_rate'));
		if ($this->input->post('nse_commission')) $nse_commission = trim($this->input->post('nse_commission'));
		if ($this->input->post('sms_fee')) $sms_fee = trim($this->input->post('sms_fee'));
		if ($this->input->post('transfer_fee')) $transfer_fee = trim($this->input->post('transfer_fee'));
		if ($this->input->post('total_amount')) $total_amount = trim($this->input->post('total_amount'));
		if ($this->input->post('min_buy_qty')) $min_buy_qty = trim($this->input->post('min_buy_qty'));
		
		
		if ($this->input->post('buy_broker_id')) $buy_broker_id = trim($this->input->post('buy_broker_id'));
		if ($this->input->post('ordertype')) $ordertype = trim($this->input->post('ordertype'));
		if (intval($this->input->post('updaterequeststatus'))==1) $updaterequeststatus = 1;
				
		$tradedate=$this->getdata_model->GetOrderTime();
		
		$seller_recipient_code=''; $sell_broker_recipient_code='';
		$buyer_recipient_code =''; $nse_recipient_code='';
		
		//Get recipient codes
		$seller_recipient_code = $this->getdata_model->GetRecipientCode($sell_investor_id,'investor');
		$buyer_recipient_code = $this->getdata_model->GetRecipientCode($buy_investor_id,'investor');
		$nse_recipient_code = $this->getdata_model->GetNSERecipientCode('admin');
		
		//$file = fopen('aaa.txt',"w"); fwrite($file,"Seller Code=".$seller_recipient_code."\r\nSeller Id=".$sell_investor_id); fclose($file); return;
		
		$sell_broker_email=''; $sell_broker_phone=''; $sell_broker_name='';	
		
		//Get seller broker details
		if (trim($sell_broker_id) <> '')
		{
			$sell_broker_recipient_code = $this->getdata_model->GetRecipientCode($sell_broker_id,'broker');
			$r = $this->getdata_model->GetBrokerDetails($sell_broker_id);		
			if ($r->email) $sell_broker_email = trim($r->email);
			if ($r->phone) $sell_broker_phone = trim($r->phone);
			if ($r->company) $sell_broker_name = trim($r->company);
		}		
				
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
		
		$broker_commission= floatval($brokers_rate)/100 * $TradeAmount;
		$nsefee = round(floatval($nse_commission) * 2,2);
						
		$total_seller_fee=0; $transfee='';
		
		if (trim($sell_broker_id) <> '')
		{
			$transfee=($TransferFee * 3);
			$total_seller_fee=floatval($TradeAmount) - floatval($broker_commission) - floatval($nse_commission) - floatval($TransferFee) - floatval($sms_fee);
		}else
		{
			$transfee=$transfee=($TransferFee * 2);
			$total_seller_fee=floatval($TradeAmount) - floatval($nse_commission) - floatval($TransferFee) - floatval($sms_fee);
		}
		
		$trade=array('sell_broker_id'=>$sell_broker_id,'sell_order_id'=>$sell_order_id,'trade_id'=>$trade_id,'symbol'=>$symbol,'num_tokens'=>$qty,'ask_price'=>$price,'bid_price'=>'','price'=>$price,'market_price'=>$current_price,'sell_broker_fee'=>$broker_commission,'nse_fee'=>$nsefee,'transfer_fees'=>$transfee,'tradestatus'=>1,'payment_status'=>'Successful','tradedate'=>$tradedate,'trade_amount'=>$TradeAmount,'total_buyer_fee'=>$total_amount,'total_seller_fee'=>$total_seller_fee,'seller_recipient_code'=>$seller_recipient_code,'sell_broker_recipient_code'=>$sell_broker_recipient_code,'buyer_recipient_code'=>$buyer_recipient_code,'nse_recipient_code'=>$nse_recipient_code,'sell_broker_email'=>$sell_broker_email,'buy_investor_email'=>$buy_investor_email,'sell_investor_email'=>$sell_investor_email,'sell_broker_phone'=>$sell_broker_phone,'sell_investor_phone'=>$sell_investor_phone,'buy_investor_phone'=>$buy_investor_phone,'sell_broker_name'=>$sell_broker_name,'sell_investor_name'=>$sell_investor_name,'buy_investor_name'=>$buy_investor_name,'min_buy_qty'=>$min_buy_qty,'sell_ordertype'=>$ordertype);
		
				
		//Check if buyer has recipientcode		
		if (!isset($buyer_recipient_code))
		{
			$m="Transaction failed. Your bank details have not been added to your profile. Without the bank details, you cannot trade on the platform. Add the bank details in your user profile module.";
		
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			if (!isset($nse_recipient_code))
			{
				$m="Transaction failed. The Nigerian Stock Exchange (NSE) bank details has not been captured by the system administration. Please contact the system administrator at <a href='mailto:support@naijaartmart.com'>support@naijaartmart.com</a> to capture NSE bank details.";
			
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{
				//check buyer balance
				$bal=$this->getdata_model->GetWalletBalance($investor_mail);
				
				if (floatval($bal) < floatval($total_amount))
				{
					$m="You do not have enough balance in your e-wallet to buy this security. Your current e-wallet balance is <b>₦".number_format($bal,2)."</b> and the total amount needed for buying ".number_format($qty,0)." tokens of ".$symbol." is <b>₦" . number_format($total_amount,2) . "</b>.";
					
					$ret=array('status'=>'FAIL','Message'=>$m);
				}else
				{
					$Msg='';					
						
					//Send trade to trading direct engine
					$res = $this->getdata_model->DirectInvestorMatchingEngine($trade);
					
					if ($res['Status']<> 1)
					{
						$ret=array('status'=>'FAIL','Message'=>$res['msg']);
						
						$Msg ="Purchase of ".number_format($qty,0)." tokens of artwork with symbol, ".strtoupper($symbol).", by ".strtoupper($buy_broker_name)." with email ".$buy_broker_email.", was not successful. ERROR: ".strtoupper($res['msg']);
					}else
					{
						$Msg=$buy_broker_name.' with email '.$buy_broker_email.", has successfully bought ".number_format($qty,0)." tokens of '".$symbol."'.";
						
						//$ret=array('status'=>'OK','Message'=>'OK');
						
						//Send Messages
						$rwt = $this->getdata_model->GetArtTitle($symbol);
						$title = trim($rwt);
						
						//Buyer
						$msgtype='system';						
						$header='Purchase Of '.number_format($qty,0).' Tokens Of '.strtoupper($symbol);
						$groups='';
						$emails=$buy_investor_email;
						$phones=$buy_investor_phone;
						$category='Message';
						$expiredate=NULL;
						$display_status=1;
						$sender='System';						
						
						$details = strtoupper($buy_investor_name)." has purchased ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title)." at ₦".number_format($price,2)." per token.";
						
						$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
						
						//Send Email
						$from='admin@naijaartmart.com';
						$to=$buy_investor_email;
						$subject=$header;
						$Cc='idongesit_a@yahoo.com';
										
						$img=base_url()."images/logo.png";
											
						//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
					
						$message = "
							<html>
							<head>
							<meta charset='utf-8'>
							<title>Naija Art Mart | Purchase Of Artwork Tokens</title>
							</head>
							<body>								
																
							Dear Investor,<br><br>
									
							You have purchased ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title).", at ₦".number_format($price,2)." per token.
											
							<p>Best Regards</p>
							Naija Art Mart
							
							</body>
							</html>";
							
						$altmessage = "
							Dear Investor,
									
							You have purchased ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title)." at NGN".number_format($price,2)." per token.
									
							Best Regards
							Naija Art Mart";
						
						if ($to) $v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$buy_investor_name);
						
						//Seller Messages
						$msgtype='system';						
						$header='Sales Of '.number_format($qty,0).' Tokens Of '.strtoupper($symbol);
						$groups='';
						
						$emails=''; $phones=''; $details='';
						
						if (trim($sell_broker_id) <> '')
						{
							$emails=$sell_broker_email.','.$sell_investor_email;
							$phones=$sell_broker_phone.','.$sell_investor_phone;
							$details = strtoupper($sell_broker_name)." has sold ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title)." at ₦".number_format($price,2)." per token for ".strtoupper($sell_investor_name).". Broker's email is ".$sell_broker_email." and phone number is ".$sell_broker_phone.".";
						}else
						{
							$emails=$sell_investor_email;
							$phones=$sell_investor_phone;
							$details = strtoupper($sell_investor_name)." has sold ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title)." at ₦".number_format($price,2)." per token.";
						}						
						
						$category='Message';
						$expiredate=NULL;
						$display_status=1;
						$sender='System';						
						
						$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
						
						//Send Email
						$to=''; $altmessage=''; $message=''; $nm='';
						
						$from='admin@naijaartmart.com';
						
						if (trim($sell_broker_id) <> '')
						{
							$to=$sell_broker_email.','.$sell_investor_email;
							$nm=$sell_broker_name;
						}else
						{
							$to=$sell_investor_email;
							$nm=$sell_investor_name;
						}
						
						$subject=$header;
						$Cc='idongesit_a@yahoo.com';
										
						$img=base_url()."images/logo.png";
											
						//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
						if (trim($sell_broker_id) <> '')
						{
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
						}else
						{
							$message = "
								<html>
								<head>
								<meta charset='utf-8'>
								<title>Naija Art Mart | Sale Of Artwork Tokens</title>
								</head>
								<body>								
																	
								Dear Investor,<br><br>
										
								You have sold ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title).", at ₦".number_format($price,2)." per token.
												
								<p>Best Regards</p>
								Naija Art Mart
								
								</body>
								</html>";
							
							$altmessage = "
								Dear Investor,
										
								You have sold ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title)." at NGN".number_format($price,2)." per token.
										
								Best Regards
								Naija Art Mart";
						}
						
						
						if ($to) $v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$nm);
						
						$ret=array('status'=>'OK','Message'=>'');
					}				
					
					$remote_ip=$_SERVER['REMOTE_ADDR'];
					$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
					//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
					$this->getdata_model->LogDetails($buy_broker_name,$Msg,$brokeremail,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'PURCHASED '.$qty.' TOKENS OF '.$symbol,$_SESSION['LogID']);		
				}	
			}	
		}
				
		echo json_encode($ret);
	}
	
	function PlaceSellOrder()
	{				
		$investor_email=''; $investor_id=''; $investor_name=''; $ordertype='';  $symbol='';
		$price=''; $qty='';	$available_qty=''; $nse_commission=''; $sms_fee=''; $transfer_fee='';
		$total_amount=''; $trade_amount='';
		$investor_phone=''; $investor_recipient_code=''; $updaterequeststatus='0';				
		
		if ($this->input->post('email')) $investor_email = trim($this->input->post('email'));	
		if ($this->input->post('investor_id')) $investor_id = trim($this->input->post('investor_id'));
		if ($this->input->post('investor_name')) $investor_name = trim($this->input->post('investor_name'));
		if ($this->input->post('ordertype')) $ordertype = trim($this->input->post('ordertype'));		
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));			
		if ($this->input->post('price')) $price = trim($this->input->post('price'));				
		if ($this->input->post('qty')) $qty = trim($this->input->post('qty'));		
		if ($this->input->post('available_qty')) $available_qty = trim($this->input->post('available_qty'));		
		if ($this->input->post('nse_commission')) $nse_commission = trim($this->input->post('nse_commission'));		
		if ($this->input->post('sms_fee')) $sms_fee = trim($this->input->post('sms_fee'));
		if ($this->input->post('transfer_fee')) $transfer_fee = trim($this->input->post('transfer_fee'));
		if ($this->input->post('total_amount')) $total_amount = trim($this->input->post('total_amount'));
		if ($this->input->post('trade_amount')) $trade_amount = trim($this->input->post('trade_amount'));
		
		$transtype='Sell';
		$orderstatus='Submitted';
		
		$orderdate=$this->getdata_model->GetOrderTime();
		$order_id=$this->getdata_model->GetId('direct_orders','order_id');
		
		$inv = $this->getdata_model->GetInvestorDetails($investor_email);
		if ($inv->recipient_code) $investor_recipient_code = trim($inv->recipient_code);
		if ($inv->uid) $investor_id = trim($inv->uid);
		if ($inv->phone) $investor_phone = trim($inv->phone);

		//Checkif investor has recipientcode		
		if (!isset($investor_recipient_code))
		{
			$m="Placing of sell order failed. Your bank details have not been added to your profile. Without your bank details, you cannot trade on the platform. Please add your bank details in the user profile module.";
		
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			$Msg='';					
			
			//Send order to trading gateway
			$order=array('order_id'=>$order_id,'investor_id'=>$investor_id,'investor_email'=>$investor_email,'investor_phone'=>$investor_phone,'transtype'=>$transtype,'symbol'=>$symbol,'price'=>$price,'qty'=>$qty,'available_qty'=>$qty,'ordertype'=>$ordertype,'orderdate'=>$orderdate,'orderstatus'=>$orderstatus,'nse_commission'=>$nse_commission,'transfer_fee'=>$transfer_fee,'sms_fee'=>$sms_fee,'total_amount'=>$total_amount,'trade_amount'=>$trade_amount,'investor_recipient_code'=>$investor_recipient_code,'transfer_fee'=>$transfer_fee);
			
			$res=$this->getdata_model->ValidateInvestorDirectOrder($order);
			
			if ($res['status']<> 1)
			{
				$ret=array('status'=>'FAIL','Message'=>$res['msg']);
			}else
			{					
				$rt = $this->getdata_model->SaveInvestorDirectOrder($res['order']);//Save Order
			
				if ($rt == true)
				{
					$Msg=$investor_name.' with email '.$investor_email.", has successfully placed a sell order for ".number_format($qty,0)." tokens of '".$symbol."'.";
					
					$ret=array('status'=>'OK','Message'=>'OK');
					
					$remote_ip=$_SERVER['REMOTE_ADDR'];
					$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
					//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
					$this->getdata_model->LogDetails($investor_name,$Msg,$investor_email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'PLACED ORDER TO SELL '.$qty.' TOKENS OF '.$symbol,$_SESSION['LogID']);	
				}else
				{
					$ret=array('status'=>'FAIL','Message'=>'Could not save sell order.');			
				}
			}	
		}
						
		echo json_encode($ret);
	}
	
	function UpdateSellOrder()
	{		
		$investor_recipient_code='';
		
		$investor_id='';   $symbol=''; $price=''; $qty=''; $available_qty=''; $old_invid='';
		$ordertype=''; $nse_commission=''; $sms_fee=''; $investor_email='';
		$investor_phone=''; $transfer_fee=''; $total_amount=''; $order_id='';
		
		if ($this->input->post('email')) $investor_email = trim($this->input->post('email'));
		if ($this->input->post('order_id')) $order_id = trim($this->input->post('order_id'));
		if ($this->input->post('investor_id')) $investor_id = trim($this->input->post('investor_id'));
		if ($this->input->post('investor_name')) $investor_name = trim($this->input->post('investor_name'));
		if ($this->input->post('old_invid')) $old_invid = trim($this->input->post('old_invid'));
		if ($this->input->post('ordertype')) $ordertype = trim($this->input->post('ordertype'));		
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));			
		if ($this->input->post('price')) $price = trim($this->input->post('price'));				
		if ($this->input->post('qty')) $qty = trim($this->input->post('qty'));		
		if ($this->input->post('available_qty')) $available_qty = trim($this->input->post('available_qty'));		
		if ($this->input->post('nse_commission')) $nse_commission = trim($this->input->post('nse_commission'));		
		if ($this->input->post('sms_fee')) $sms_fee = trim($this->input->post('sms_fee'));
		if ($this->input->post('transfer_fee')) $transfer_fee = trim($this->input->post('transfer_fee'));
		if ($this->input->post('total_amount')) $total_amount = trim($this->input->post('total_amount'));
		
		$transtype='Sell';
		
		$last_update_date=date('Y-m-d H:i:s');
				
		$inv = $this->getdata_model->GetInvestorDetails($investor_email);
		if ($inv->recipient_code) $investor_recipient_code = trim($inv->recipient_code);
		if ($inv->uid) $investor_id = trim($inv->uid);
		if ($inv->phone) $investor_phone = trim($inv->phone);
				
		//Checkif investor has recipientcode
		if (!isset($investor_recipient_code))
		{
			$m="Updating of sell order failed. The your bank details have not been added to the profile. Without the your bank details, you cannot trade on the platform. Please add your bank details in the user profile module.";
		
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			$Msg='';	
								
			//Send order to trading gateway
			$sql = "SELECT * FROM direct_orders WHERE (TRIM(order_id)=".$this->db->escape_str($order_id).") AND (TRIM(investor_id)='".$this->db->escape_str($investor_email)."')";		
	
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
				if ($row->investor_id) $invid=trim($row->investor_id);
				if ($row->transtype) $ty=trim($row->transtype);
				if ($row->ordertype) $ot=trim($row->ordertype);
				if ($row->symbol) $sym=trim($row->symbol);
				if ($row->price) $pr=$row->price;						
				if ($row->qty) $qt=$row->qty;
				if ($row->available_qty) $aqt=$row->available_qty;						
				if ($row->orderstatus) $sta=trim($row->orderstatus);
				if ($row->nse_commission) $nf=$row->nse_commission;						
				if ($row->transfer_fee) $tf=$row->transfer_fee;
				if ($row->sms_fee) $sf=$row->sms_fee;
				if ($row->investor_recipient_code) $ic=trim($row->investor_recipient_code);
				if ($row->orderdate) $odt=trim($row->orderdate);
				if ($row->total_amount) $amt=$row->total_amount;
				
				$OldValues='Order Date: '.$odt.'; Order Id: '.$oid.'; Trade Type: '.$ty.'; Investor Id: '.$invid.'; Security: '.$sym.'; Order Quantity: '.$qt.'; Price Per Token: '.$pr.'; Order Type: '.$ot.'; Order Status: '.$sta.'; NSE Commission: '.$nf.'; Transfer Fee: '.$tf.'; SMS Fee: '.$sf.'; Total Amount: '.$amt;
				
				$NewValues='Order Date: '.$odt.'; Order Id: '.$oid.'; Trade Type: '.$transtype.'; Investor Id: '.$investor_email.'; Security: '.$symbol.'; Order Quantity: '.$qty.'; Price Per Token: '.$price.'; Order Type: '.$ordertype.'; Order Status: '.$sta.'; NSE Commission: '.$nse_commission.'; Transfer Fee: '.$transfer_fee.'; SMS Fee: '.$sms_fee.'; Total Amount: '.$total_amount;
				
				$this->db->trans_start();
			
				$dat=array(
					'investor_id' 				=> $this->db->escape_str($investor_email),
					'transtype' 				=> $this->db->escape_str($transtype),
					'ordertype'					=> $this->db->escape_str($ordertype),			
					'symbol' 					=> $this->db->escape_str($symbol),			
					'price'						=> $this->db->escape_str($price),
					'qty' 						=> $this->db->escape_str($qty),			
					'available_qty' 			=> $this->db->escape_str($available_qty),
					'nse_commission' 			=> $this->db->escape_str($nse_commission),
					'transfer_fee' 				=> $this->db->escape_str($transfer_fee),
					'sms_fee' 					=> $this->db->escape_str($sms_fee),
					'investor_recipient_code'	=> $this->db->escape_str($investor_recipient_code),			
					'last_update_date' 			=> $this->db->escape_str($last_update_date),
					'total_amount' 				=> $this->db->escape_str($total_amount)
				);
				
				$this->db->where(array('order_id' => $order_id, 'investor_id' => $investor_email));
				$this->db->update('direct_orders', $dat);			
				$this->db->trans_complete();
				
				if ($this->db->trans_status() === FALSE)
				{
					$Msg="Investor ".strtoupper($investor_name)." attempted updating sell order with order Id ".$order_id." but failed.";
					$m='Sell Order Could Not Be Updated.';
					$ret=array('status'=>'FAIL','Message'=>$m);
				}else
				{						
					$Msg="Sell order has been edited successfully by ".$investor_email.". Old Values => ".$OldValues.". Updated values => ".$NewValues;
			
					//Log activity
					$Msg=$investor_name.' with email '.$investor_email.", has successfully edited sell order with order Id ".$order_id.".";
					
					$ret=array('status'=>'OK','Message'=>'OK');	
				}
				
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
				//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
				$this->getdata_model->LogDetails($investor_name,$Msg,$investor_email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'EDITED SELL ORDER',$_SESSION['LogID']);
			}
		}
				
		echo json_encode($ret);
	}
	
	function CancelSellOrder()
	{		
		$symbol=''; $order_id=''; $qty=''; $price=''; $ordertype=''; $transtype=''; $investor_email='';
		$investor_name='';

		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));
		if ($this->input->post('order_id')) $order_id = trim($this->input->post('order_id'));	
		if ($this->input->post('qty')) $qty = trim($this->input->post('qty'));
		if ($this->input->post('price')) $price = trim($this->input->post('price'));
		if ($this->input->post('ordertype')) $ordertype = trim($this->input->post('ordertype'));
		if ($this->input->post('transtype')) $transtype = trim($this->input->post('transtype'));							
		if ($this->input->post('email')) $investor_email = trim($this->input->post('email'));
		if ($this->input->post('investor_name')) $investor_name = trim($this->input->post('investor_name'));
		
		$dt=date('Y-m-d H:i:s');
				
		//Checkif sell order exists
		$Msg='';	
							
		$sql = "SELECT * FROM direct_orders WHERE (TRIM(order_id)=".$this->db->escape_str($order_id).") AND (TRIM(symbol)='".$this->db->escape_str($symbol)."') AND (TRIM(investor_id)='".$this->db->escape_str($investor_email)."')";		

		$query = $this->db->query($sql);
					
		if ($query->num_rows() == 0 )
		{
			$m='Cancellation of sell order with Id '.$order_id.'. was not successful. Order with Id <b>'.$order_id.'</b> was not found in the database.';
			$ret=$m;
		}else
		{
			$this->db->trans_start();		
			$this->db->delete('direct_orders', array('order_id'=>$order_id, 'symbol'=>$symbol,'investor_id'=>$investor_email));
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE)
			{
				$Msg="Cancellation of sell order by the investor ".strtoupper($investor_name)." for sell order with order Id ".$order_id." failed.";
				
				$m='Sell Order Cancellation Failed.';
				$ret=$m;
			}else
			{								
				$Msg='Cancellation of sell order was successful. Order details include: Investor Name: '.$investor_name.'; Investor Id: '.$investor_email.'; Order Id: '.$order_id.'; Trade Type: '.$transtype.'; Security: '.$symbol.'; Order Quantity: '.$qty.'; Price Per Token: '.$price.'; Order Type: '.$ordertype;
		
				//Log activity
				$Msg=$investor_name.' with email '.$investor_email.", has successfully cancelled sell order with order Id ".$order_id.".";
				
				$ret='OK';	
			}
			
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
			$this->getdata_model->LogDetails($investor_name,$Msg,$investor_email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'CANCELLED SELL ORDER',$_SESSION['LogID']);
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
			$marketData = $this->GetDirectMarketData();
			if (count($marketData) != 0){
				$data['DirectMarketData']=$marketData;
			}else{
				$setMarket = $this->getdata_model->SetDayPrice();
				$data['DirectMarketData']= $this->GetDirectMarketData();
			}
			



			// print_r($data); die();
			$data['broker_id']=''; $data['broker_recipient_code']='';
			
			if (trim(strtolower($data['usertype']))=='investor')
			{
				$det = $this->getdata_model->GetInvestorDetails($data['email']);
				
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
							
				$this->load->view('ui/directinvestorsecmarket_view',$data);
			}else
			{
				$this->getdata_model->GoToLogin('');
			}			
		}else
		{
			$this->getdata_model->GoToLogin('');
		}
	}
}
