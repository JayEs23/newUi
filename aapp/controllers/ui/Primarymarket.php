<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");

date_default_timezone_set('Africa/Lagos');
set_time_limit(0);

require_once(realpath('.')."/vendor/autoload.php"); 

class Primarymarket extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	
	public function GetTrades()
	{
		$email=''; $broker_id=''; $startdate=''; $enddate=''; $usertype='';
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));
		if ($this->input->post('startdate')) $startdate = $this->input->post('startdate');
		if ($this->input->post('enddate')) $enddate = $this->input->post('enddate');
		
		if (trim(strtolower($usertype)) == 'broker')
		{
			$qry = "SELECT * FROM primary_trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND (TRIM(buy_broker_id)='".$this->db->escape_str($broker_id)."') AND (TRIM(payment_status)='Successful') ORDER BY tradedate DESC";	
		}elseif (trim(strtolower($usertype)) == 'issuer')
		{
			$qry = "SELECT * FROM primary_trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND (TRIM(issuer_email)='".$this->db->escape_str($email)."') AND (TRIM(payment_status)='Successful') ORDER BY tradedate DESC";
		}elseif (trim(strtolower($usertype)) == 'investor')
		{
			$qry = "SELECT * FROM primary_trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND (TRIM(buy_investor_email)='".$this->db->escape_str($email)."') AND (TRIM(payment_status)='Successful') ORDER BY tradedate DESC";
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

		//buy_broker_id,buy_investor_email,issuer_email,trade_id,symbol,num_tokens,trade_price,issuer_fee,buy_broker_fee,nse_fee,transfer_fees,total_amount,tradestatus,payment_status,tradedate	
					
			$tp=array($dt,$row['trade_id'],$row['symbol'],$qty,$pr,$amt,$row['issuer_email'],$row['buy_investor_email']);
			
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
	
	
	public function GetMarketData()
	{
		$usertype='';
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		
		$qry = "SELECT *,(SELECT email FROM issuers WHERE TRIM(issuers.uid)=TRIM(primary_market.uid) LIMIT 0,1) AS issuer_email,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS pix,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS title,(SELECT artist FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS artist,(SELECT artwork_value FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS artwork_value,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS creationyear FROM primary_market WHERE (TRIM(listing_status)='Started') ORDER BY symbol";//Pending, Started, Ended

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array(); $sn=-1;

		foreach($results as $row):
			$buy=''; $pix='';
			
			if ($row['pix'])
			{
				$pix='<img onClick="ShowPix(\''.$row['symbol'].'\',\''.$row['title'].'\',\''.$row['pix'].'\',\''.$row['blockchainUrl'].'\');" style="cursor:pointer; height:60px;" src="'.base_url().'art-works/thumbs/t_'.$row['pix'].'" title="Click To Display '.strtoupper(trim($row['title'])).' Picture">'.'<br>'.$row['title'].', '.$row['creationyear'];				
			}
						
			$sn++;
			
			if (strtolower($usertype) == 'broker')
			{
				$buy='<input type="button" class="btn btn-nse-green makebold" onClick="ShowMarketData(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['price'].'\',\''.$row['tokens_available'].'\',\''.$row['title'].'\',\''.$row['issuer_email'].'\')" style="cursor:pointer; height:60px; width: 100%;  text-align:center; padding:0;" title="Buy Artwork With Symbol '.strtoupper(trim($row['symbol'])).'" value="BUY ARTWORK">';
								
			}elseif (strtolower($usertype) == 'investor') //or (strtolower($usertype) == 'investor/issuer'))
			{
				$buy='<input type="button" class="btn btn-nse-green makebold" onClick="Request_A_Buy(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['price'].'\',\''.$row['tokens_available'].'\')" style="cursor:pointer; height:60px; width: 100%;  text-align:center; padding:1px; " title="Send A Request To Your Broker To Buy This Artwork With Symbol, '.strtoupper(trim($row['symbol'])).', For You" value="REQUEST A BUY">';
			}
			
						
			
			$tp=array($pix,$row['artist'],$row['symbol'],'&#8358;'.number_format($row['artwork_value'],2),number_format($row['tokens_available'],0),'&#8358;'.number_format($row['price'],2),$buy);
			
			$data[]=$tp;
		endforeach;

		print_r(json_encode($data));
	}
	
	public function GetRequestsHistory()
	{
		$usertype='';
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		
		$qry = "SELECT *,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS title,(SELECT artist FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS artist,(SELECT artwork_value FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS artwork_value,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS creationyear,(SELECT tokens_for_sale FROM listed_artworks WHERE TRIM(listed_artworks.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS tokens_for_sale FROM request_to_buy ORDER BY requestdate DESC,symbol";

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array(); $sn=-1;

		foreach($results as $row):
			$pix='';
			
			if ($row['pix'])
			{
				$pix='<img style="height:60px;" src="'.base_url().'art-works/thumbs/t_'.$row['pix'].'" title="'.strtoupper(trim($row['title'])).'('.strtoupper(trim($row['symbol'])).')"><br>'.$row['title'].', '.$row['creationyear'];				
			}

			$tp=array($pix,$row['artist'],$row['symbol'],'&#8358;'.number_format($row['artwork_value'],2),number_format($row['tokens_for_sale'],0),number_format($row['tokens'],0),'&#8358;'.number_format($row['marketprice'],2));
			
			$data[]=$tp;
		endforeach;

		print_r(json_encode($data));
	}
	
	function BuyPrimaryTokens()
	{
		$buy_broker_id=''; $buy_broker_email=''; $buy_investor_email=''; $symbol=''; $price=''; $qty='';
		$available_qty=''; $broker_commission=''; $nse_commission=''; $sms_fee=''; $transfer_fee='';
		$issuer_email=''; $total_amount='';
		
		if ($this->input->post('buy_broker_id')) $buy_broker_id = trim($this->input->post('buy_broker_id'));
		if ($this->input->post('buy_broker_email')) $buy_broker_email = trim($this->input->post('buy_broker_email'));
		if ($this->input->post('buy_investor_email')) $buy_investor_email = trim($this->input->post('buy_investor_email'));
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));	
		if ($this->input->post('price')) $price = trim($this->input->post('price'));
		if ($this->input->post('qty')) $qty = trim($this->input->post('qty'));
		if ($this->input->post('available_qty')) $available_qty = trim($this->input->post('available_qty'));
		if ($this->input->post('broker_commission')) $broker_commission = trim($this->input->post('broker_commission'));
		if ($this->input->post('nse_commission')) $nse_commission = trim($this->input->post('nse_commission'));
		if ($this->input->post('sms_fee')) $sms_fee = trim($this->input->post('sms_fee'));
		if ($this->input->post('transfer_fee')) $transfer_fee = trim($this->input->post('transfer_fee'));
		if ($this->input->post('issuer_email')) $issuer_email = trim($this->input->post('issuer_email'));
		if ($this->input->post('total_amount')) $total_amount = trim($this->input->post('total_amount'));
		
		$tradedate=$this->getdata_model->GetOrderTime();
				
		$issuer_recipient_code=''; $buyer_recipient_code =''; $buy_broker_recipient_code='';
		$nse_recipient_code='';
		
		//Get recipient codes
		$issuer_recipient_code = $this->getdata_model->GetRecipientCode($issuer_email,'issuer');
		$buyer_recipient_code = $this->getdata_model->GetRecipientCode($buy_investor_email,'investor');
		$buy_broker_recipient_code = $this->getdata_model->GetRecipientCode($buy_broker_id,'broker');
		$nse_recipient_code = $this->getdata_model->GetNSERecipientCode('admin');
		
		
		$investor_email=''; $investor_phone=''; $brokerphone='';
		
		//Get buyer broker details
		$buy_broker_phone=''; $buy_broker_name='';		
		$r = $this->getdata_model->GetBrokerDetails($buy_broker_email);
		
		if ($r->phone) $buy_broker_phone = trim($r->phone);
		if ($r->company) $buy_broker_name = trim($r->company);
		
		//Get issuer details
		$issuer_phone=''; $issuer_name=''; $issuer_uid='';	
		$r = $this->getdata_model->GetIssuerDetails($issuer_email);
		
		if ($r->user_name) $issuer_name = trim($r->user_name);
		if ($r->phone) $issuer_phone = trim($r->phone);
		if ($r->uid) $issuer_uid = trim($r->uid);
		
		//Get buy investor details
		$buy_investor_phone=''; $buy_investor_name='';		
		$r = $this->getdata_model->GetInvestorDetails($buy_investor_email);
		
		if ($r->user_name) $buy_investor_name = trim($r->user_name);
		if ($r->phone) $buy_investor_phone = trim($r->phone);
						
		//Generate data
		$trade_id=$this->getdata_model->GeneratePrimaryTradeId();
		
		$TradeAmount = floatval($qty) * floatval($price);		
		$TransferFee = 0; $nse_recipientcode='';
				
		$paystack 		= $this->getdata_model->GetPaystackSettings();
		$setings		= $this->getdata_model->GetParamaters();
		
		if ($paystack->transfer_fee) $TransferFee = $paystack->transfer_fee;
				
		$nsefee = floatval($nse_commission) * 2;
						
		$total_issuer_fee=floatval($TradeAmount) - floatval($nse_commission) - floatval($TransferFee) - (floatval($sms_fee)/2);
		
		$trade=array('buy_broker_id'=>$buy_broker_id,'trade_id'=>$trade_id,'symbol'=>$symbol,'num_tokens'=>$qty,'price'=>$price,'buy_broker_fee'=>$broker_commission,'nse_fee'=>$nsefee,'sms_fee'=>$sms_fee,'transfer_fees'=>($TransferFee * 3),'tradestatus'=>1,'payment_status'=>'Successful','tradedate'=>$tradedate,'trade_amount'=>$TradeAmount,'total_buyer_fee'=>$total_amount,'total_issuer_fee'=>$total_issuer_fee,'issuer_recipient_code'=>$issuer_recipient_code,'buyer_recipient_code'=>$buyer_recipient_code,'buy_broker_recipient_code'=>$buy_broker_recipient_code,'nse_recipient_code'=>$nse_recipient_code,'buy_broker_email'=>$buy_broker_email,'buy_investor_email'=>$buy_investor_email,'issuer_uid'=>$issuer_uid,'issuer_email'=>$issuer_email,'buy_broker_phone'=>$buy_broker_phone,'issuer_phone'=>$issuer_phone,'buy_investor_phone'=>$buy_investor_phone,'buy_broker_name'=>$buy_broker_name,'issuer_name'=>$issuer_name,'buy_investor_name'=>$buy_investor_name);


		//buy_broker_id,buy_investor_email,issuer_email,trade_id,symbol,num_tokens,trade_price,issuer_fee,buy_broker_fee,nse_fee,transfer_fees,total_amount,tradestatus,payment_status,tradedate		
				
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
					$bal=$this->getdata_model->GetWalletBalance($buy_broker_email);
					
					if (floatval($bal) < floatval($total_amount))
					{
						$m="You do not have enough balance in your e-wallet to buy this security. Your current e-wallet balance is <b>₦".number_format($bal,2)."</b> and the total amount needed for buying ".number_format($qty,0)." tokens of ".$symbol." is <b>₦" . number_format($total_amount,2) . "</b>.";
						
						$ret=array('status'=>'FAIL','Message'=>$m);
					}else
					{
						$Msg='';					
							
						//Send trade to trading direct engine
						$res = $this->getdata_model->PrimaryMarketEngine($trade);
						
						if ($res['Status']<> 1)
						{
							$ret=array('status'=>'FAIL','Message'=>$res['msg']);
							
							$Msg ="Purchase of ".number_format($qty,0)." tokens of artwork with symbol, ".strtoupper($symbol).", by ".strtoupper($buy_broker_name)." with email ".$buy_broker_email.", was not successful. ERROR: ".strtoupper($res['msg']);
						}else
						{						
							$Msg=$buy_broker_name.' with email '.$buy_broker_email.", has successfully bought ".number_format($qty,0)." tokens of '".$symbol."' at the primary market.";
							
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
							
							$details = strtoupper($buy_broker_name)." has purchased ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title)." at ₦".number_format($price,2)." per token for ".strtoupper($buy_investor_name)." at the primary market. Broker's email is ".$buy_broker_email." and phone number is ".$buy_broker_phone.".";
							
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
										
								'.strtoupper($buy_broker_name)." has purchased ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title).", at ₦".number_format($price,2)." per token for ".strtoupper($buy_investor_name)." at the primary market. Broker's email is ".$buy_broker_email." and phone number is ".$buy_broker_phone.'
												
								<p>Best Regards</p>
								Naija Art Mart
								
								</body>
								</html>';
								
							$altmessage = '
								Dear Investor,
										
								'.strtoupper($buy_broker_name)." has purchased ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title)." at NGN".number_format($price,2)." per token for ".strtoupper($buy_investor_name)." at the primary market. Broker's email is ".$buy_broker_email." and phone number is ".$buy_broker_phone.'
										
								Best Regards
								Naija Art Mart';
							
							if ($to) $v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$buy_broker_name);
							
							//Issuer Message
							$msgtype='system';						
							$header='Sale Of '.number_format($qty,0).' Tokens Of '.strtoupper($symbol);
							$groups='';
							$emails=$issuer_email;
							$phones=$issuer_phone;
							$category='Message';
							$expiredate=NULL;
							$display_status=1;
							$sender='System';						
							
							$details = "You have sold ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title)." at ₦".number_format($price,2)." per token to ".strtoupper($buy_investor_name)." at the primary market.";
							
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
																	
								Dear Issuer,<br><br>
										
								You have sold '.number_format($qty,0).' tokens of artwork with symbol '.strtoupper($symbol).' titled, '.strtoupper($title).', at ₦'.number_format($price,2).' per token to '.strtoupper($buy_investor_name).' at the primary market.
												
								<p>Best Regards</p>
								Naija Art Mart
								
								</body>
								</html>';
								
							$altmessage = '
								Dear Issuer,
										
								You have sold '.number_format($qty,0).' tokens of artwork with symbol '.strtoupper($symbol).' titled, '.strtoupper($title).' at NGN'.number_format($price,2).' per token to '.strtoupper($buy_investor_name).' at the primary market.
										
								Best Regards
								Naija Art Mart';
							
							if ($to) $v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$buy_broker_name);
							
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
						$header='Request For Purchase Of '.number_format($tokens,0,'',',')." Tokens Of ".strtoupper($symbol);
						$groups='';
						$emails=$broker_email;
						$phones='';
						$category='Message';
						$expiredate=NULL;
						$display_status=1;
						$sender='System';						
						
						$details="The investor, ".strtoupper($investor_name).", with email ".$investor_email.", and phone number, ".$investor_phone.", has submitted a request for you to assist in buying the artwork with symbol ".strtoupper($symbol)." and title, ".strtoupper($title)." from the primary market. Please attend to the request.";
						
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
									
							The investor, '.strtoupper($investor_name).', with email '.$investor_email.', and phone number, '.$investor_phone.', has submitted a request for you to assist in buying the artwork with symbol '.strtoupper($symbol).' and title, '.strtoupper($title).', from the primary market. Please attend to the request.
											
							<p>Best Regards</p>
							Naija Art Mart
							
							</body>
							</html>';
							
						$altmessage = '
							Dear Broker,
									
							The investor, '.strtoupper($investor_name).', with email '.$investor_email.', and phone number, '.$investor_phone.', has submitted a request for you to assist in buying the artwork with symbol '.strtoupper($symbol).' and title, '.strtoupper($title).' from the primary market. Please attend to the request.
									
							Best Regards
							Naija Art Mart';
						
						if ($to) $v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$brokername);
						
						if (strtoupper(trim($v)) <> 'OK')
						{
							$Msg ="Request To Buy Artwork With Symbol, ".strtoupper($symbol)." From The Primary Market Was Successful, But Sending Of Email To Broker Failed. Broker Will Be Able To View The Request Via Naija Art Mart Messaging Screen.";
							
							$m ="Request Was Successfully Sent, But Sending Of Email To Broker Failed. Broker Will Be Able To View The Request Via Naija Art Mart Messaging Screen.";		
								
							$ret=array('status'=>'OK','Message'=>$m);					
						}else
						{
							$Msg="Request To Buy Artwork With Symbol, ".strtoupper($symbol)." Was Successful.";				
							
							$ret=array('status'=>'OK','Message'=>'');
						}
						
												
						$Msg="Investor Requested That The Broker Buys ".number_format($tokens,0,'',',')." Tokens Of ".strtoupper($symbol)." From The Primary Market.";				
							
						$remote_ip=$_SERVER['REMOTE_ADDR'];
						$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
						
						//$Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID
						$this->getdata_model->LogDetails($investor_name,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'REQUESTED TO BUY ARTWORK FROM PRIMARY MARKET',$_SESSION['LogID']);
					}
				}
			}
		}
		
		echo json_encode($ret);
	}
	
	public function index()
	{
		$qry = "SELECT *,(SELECT email FROM issuers WHERE TRIM(issuers.uid)=TRIM(primary_market.uid) LIMIT 0,1) AS issuer_email,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS pix,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS title,(SELECT artist FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS artist,(SELECT artwork_value FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS artwork_value,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS creationyear FROM primary_market WHERE (TRIM(listing_status)='Started') ORDER BY symbol";//Pending, Started, Ended
	
		$query = $this->db->query(stripslashes($qry));
			
		$results = $query->result_array();
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
			}elseif (trim(strtolower($data['usertype']))=='investor')// or (trim(strtolower($data['usertype']))=='investor/issuer'))
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
			
			//Paystack settings
			$pay = $this->getdata_model->GetPaystackSettings();			
			if ($pay->transfer_fee) $data['transfer_fee']=$pay->transfer_fee; else $data['transfer_fee']='';
			$data['LastestPixs']=$results;
			$this->load->view('ui/primarymarket_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('');
		}
	}
}
