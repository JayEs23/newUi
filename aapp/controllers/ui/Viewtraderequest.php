<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Viewtraderequest extends CI_Controller {
	function __construct() 
	{
		parent::__construct();		
		$this->load->helper('url');
	}
	
	function BuyPrimaryTokens()
	{
		$buy_broker_id=''; $buy_broker_email=''; $buy_investor_email=''; $symbol=''; $price=''; $qty='';
		$available_qty=''; $broker_commission=''; $nse_commission=''; $sms_fee=''; $transfer_fee='';
		$issuer_email=''; $total_amount=''; $investor_name=''; $request_id=''; $investor_id='';
		
		if ($this->input->post('request_id')) $request_id = trim($this->input->post('request_id'));
		if ($this->input->post('buy_broker_id')) $buy_broker_id = trim($this->input->post('buy_broker_id'));
		if ($this->input->post('buy_broker_email')) $buy_broker_email = trim($this->input->post('buy_broker_email'));
		if ($this->input->post('investor_id')) $investor_id = trim($this->input->post('investor_id'));
		if ($this->input->post('buy_investor_email')) $buy_investor_email = trim($this->input->post('buy_investor_email'));
		if ($this->input->post('investor_name')) $investor_name = trim($this->input->post('investor_name'));
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
		$buy_broker_recipient_code = $this->getdata_model->GetRecipientCode($buy_broker_email,'broker');
		$nse_recipient_code = $this->getdata_model->GetNSERecipientCode('admin');
		
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
		$TransferFee = 0;
				
		$paystack 		= $this->getdata_model->GetPaystackSettings();
		$setings		= $this->getdata_model->GetParamaters();
		
		if ($paystack->transfer_fee) $TransferFee = $paystack->transfer_fee;
				
		$nsefee = floatval($nse_commission) * 2;
						
		$total_issuer_fee=floatval($TradeAmount) - floatval($nse_commission) - floatval($TransferFee) - (floatval($sms_fee)/2);
		
		$trade=array('buy_broker_id'=>$buy_broker_id,'trade_id'=>$trade_id,'symbol'=>$symbol,'num_tokens'=>$qty,'price'=>$price,'buy_broker_fee'=>$broker_commission,'nse_fee'=>$nsefee,'sms_fee'=>$sms_fee,'transfer_fees'=>($TransferFee * 3),'tradestatus'=>1,'payment_status'=>'Successful','tradedate'=>$tradedate,'trade_amount'=>$TradeAmount,'total_buyer_fee'=>$total_amount,'total_issuer_fee'=>$total_issuer_fee,'issuer_recipient_code'=>$issuer_recipient_code,'buyer_recipient_code'=>$buyer_recipient_code,'buy_broker_recipient_code'=>$buy_broker_recipient_code,'nse_recipient_code'=>$nse_recipient_code,'buy_broker_email'=>$buy_broker_email,'buy_investor_email'=>$buy_investor_email,'issuer_uid'=>$issuer_uid,'issuer_email'=>$issuer_email,'buy_broker_phone'=>$buy_broker_phone,'issuer_phone'=>$issuer_phone,'buy_investor_phone'=>$buy_investor_phone,'buy_broker_name'=>$buy_broker_name,'issuer_name'=>$issuer_name,'buy_investor_name'=>$buy_investor_name);		
				
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
							//Update request_to_buy table
							$this->db->trans_start();	
					
							$dat=array('request_status' => 'Treated');			
			
							$this->db->where(array('request_id'=>$request_id));
							$this->db->update('request_to_buy',$dat);
														
							$this->db->trans_complete();
														
												
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
							
							if ($to) $v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$brokername);
							
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
							
							$details = "You have sold ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title)." at ₦".number_format($price,2)." per token for ".strtoupper($sell_investor_name)." at the primary market.";
							
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
										
								You have sold '.number_format($qty,0).' tokens of artwork with symbol '.strtoupper($symbol).' titled, '.strtoupper($title).', at ₦'.number_format($price,2).' per token for '.strtoupper($buy_investor_name).' at the primary market.
												
								<p>Best Regards</p>
								Naija Art Mart
								
								</body>
								</html>';
								
							$altmessage = '
								Dear Issuer,
										
								You have sold '.number_format($qty,0).' tokens of artwork with symbol '.strtoupper($symbol).' titled, '.strtoupper($title).' at NGN'.number_format($price,2).' per token for '.strtoupper($buy_investor_name).' at the primary market.
										
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
	
	function GetPrimaryMarketDetails()
	{
		$symbol='';
		
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));
		
		$sql="SELECT primary_market.*,(SELECT email FROM issuers WHERE issuers.uid=primary_market.uid LIMIT 0,1) AS issuer_email,(SELECT user_name FROM issuers WHERE issuers.uid=primary_market.uid LIMIT 0,1) AS issuer_name FROM primary_market WHERE (TRIM(symbol)='".$this->db->escape_str($symbol)."')";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetPrimaryMarketDetails functions
		
	function GetRequests()
	{
		$usertype=''; $request_status='';
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		if ($this->input->post('request_status')) $request_status = trim($this->input->post('request_status'));
		
		if ($request_status == '')
		{
			$qry = "SELECT request_to_buy.*,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS title,(SELECT artist FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS artist,(SELECT user_name FROM investors WHERE TRIM(investors.uid)=TRIM(request_to_buy.investor_id) LIMIT 0,1) AS investor_name, (SELECT uid FROM investors WHERE TRIM(investors.uid)=TRIM(request_to_buy.investor_id) LIMIT 0,1) AS investor_id,(SELECT email FROM investors WHERE TRIM(investors.uid)=TRIM(request_to_buy.investor_id) LIMIT 0,1) AS investor_email,(SELECT listing_status FROM primary_market WHERE TRIM(primary_market.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS listing_status FROM request_to_buy ORDER BY requestdate DESC,symbol";	
		}else
		{
			$qry = "SELECT request_to_buy.*,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS title,(SELECT artist FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS artist,(SELECT user_name FROM investors WHERE TRIM(investors.uid)=TRIM(request_to_buy.investor_id) LIMIT 0,1) AS investor_name, (SELECT uid FROM investors WHERE TRIM(investors.uid)=TRIM(request_to_buy.investor_id) LIMIT 0,1) AS investor_id,(SELECT email FROM investors WHERE TRIM(investors.uid)=TRIM(request_to_buy.investor_id) LIMIT 0,1) AS investor_email,(SELECT listing_status FROM primary_market WHERE TRIM(primary_market.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS listing_status FROM request_to_buy WHERE TRIM(request_status)='".$this->db->escape_str($request_status)."' ORDER BY requestdate DESC,symbol";
		}
		

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array(); $sn=-1;

		foreach($results as $row):
			$pix=''; $view=''; $max_price='-'; $min_price='-'; $dt=''; $amt=0; $tamt=0;
			
			$amt=floatval($row['tokens']) * floatval($row['marketprice']);
			$tamt=$amt + floatval($row['brokerfee']) + floatval($row['nsefee']) + floatval($row['sms_fee']);
			
			if (floatval($amt) == 0) $amt=''; 
			if (floatval($tamt) == 0) $tamt=''; 
			
			if ($row['pix'])
			{
				$pix='<img onClick="ShowPix(\''.$row['symbol'].'\',\''.$row['title'].'\',\''.$row['pix'].'\',\''.$row['blockchainUrl'].'\');" style="height:60px; cursor:pointer;" src="'.base_url().'art-works/thumbs/t_'.$row['pix'].'" title="'.strtoupper(trim($row['title'])).'('.strtoupper(trim($row['symbol'])).')"><br>'.$row['title'].', '.$row['creationyear'];				
			}
			
			if ($row['requestdate']) $dt=date('d M Y @ H:i',strtotime($row['requestdate']));
			if ($row['max_price']) $max_price='&#8358;'.number_format($row['max_price'],2);
			if ($row['min_price']) $min_price='&#8358;'.number_format($row['min_price'],2);
	
	
			$view='<img onClick="SelectRow(\''.$row['symbol'].'\',\''.$dt.'\',\''.$row['tokens'].'\',\''.$row['marketprice'].'\',\''.$row['sms_fee'].'\',\''.$row['brokerfee'].'\',\''.$row['nsefee'].'\',\''.$row['market_type'].'\',\''.$row['request_status'].'\',\''.$row['investor_name'].'\',\''.$row['investor_id'].'\',\''.$amt.'\',\''.$tamt.'\',\''.$row['request_id'].'\',\''.$row['trans_type'].'\',\''.$row['min_price'].'\',\''.$row['max_price'].'\',\''.$row['investor_email'].'\',\''.$row['listing_status'].'\')" style="cursor:pointer; height:30px;" src="'.base_url().'images/view_icon.png" title="Click To View Details Of This Request">';

			$tp=array($pix,$row['market_type'],$row['trans_type'],$row['symbol'],number_format($row['tokens'],0),'&#8358;'.number_format($row['marketprice'],2),$row['request_status'],$view);
			
			$data[]=$tp;
		endforeach;

		print_r(json_encode($data));
	}
	
	function GetPrimaryMarketData()
	{
		$usertype='';
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		
		$qry = "SELECT request_to_buy.*,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS title,(SELECT artist FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS artist,(SELECT artwork_value FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS artwork_value,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS creationyear,(SELECT user_name FROM investors WHERE TRIM(investors.uid)=TRIM(request_to_buy.investor_id) LIMIT 0,1) AS investor_name, (SELECT uid FROM investors WHERE TRIM(investors.uid)=TRIM(request_to_buy.investor_id) LIMIT 0,1) AS investor_id,(SELECT email FROM investors WHERE TRIM(investors.uid)=TRIM(request_to_buy.investor_id) LIMIT 0,1) AS investor_email,(SELECT tokens_available FROM primary_market WHERE TRIM(primary_market.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS avail_qty,(SELECT email FROM art_works WHERE TRIM(art_works.symbol)=TRIM(request_to_buy.symbol) LIMIT 0,1) AS issuer_email FROM request_to_buy ORDER BY requestdate DESC,symbol";

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array(); $sn=-1;

		foreach($results as $row):
			$pix=''; $view=''; $max_price='-'; $min_price='-'; $dt=''; $amt=0; $tamt=0;
			
			$amt=floatval($row['tokens']) * floatval($row['marketprice']);
			$tamt=$amt + floatval($row['brokerfee']) + floatval($row['nsefee']) + floatval($row['sms_fee']);
			
			if (floatval($amt) == 0) $amt=''; 
			if (floatval($tamt) == 0) $tamt=''; 
			
			if ($row['pix'])
			{
				$pix='<img onClick="ShowPix(\''.$row['symbol'].'\',\''.$row['title'].'\',\''.$row['pix'].'\');" style="height:60px; cursor:pointer;" src="'.base_url().'art-works/thumbs/t_'.$row['pix'].'" title="'.strtoupper(trim($row['title'])).'('.strtoupper(trim($row['symbol'])).')"><br>'.$row['title'].', '.$row['creationyear'];				
			}
			
			if ($row['requestdate']) $dt=date('d M Y @ H:i',strtotime($row['requestdate']));
			if ($row['max_price']) $max_price='&#8358;'.number_format($row['max_price'],2);
			if ($row['min_price']) $min_price='&#8358;'.number_format($row['min_price'],2);
	
			$view='<img onClick="SelectRow(\''.$row['symbol'].'\',\''.$dt.'\',\''.$row['tokens'].'\',\''.$row['marketprice'].'\',\''.$row['sms_fee'].'\',\''.$row['brokerfee'].'\',\''.$row['nsefee'].'\',\''.$row['market_type'].'\',\''.$row['request_status'].'\',\''.$row['investor_name'].'\',\''.$row['investor_id'].'\',\''.$amt.'\',\''.$tamt.'\',\''.$row['request_id'].'\',\''.$row['trans_type'].'\',\''.$row['min_price'].'\',\''.$row['max_price'].'\',\''.$row['investor_email'].'\',\''.$row['avail_qty'].'\',\''.$row['issuer_email'].'\')" style="cursor:pointer; height:30px;" src="'.base_url().'images/view_icon.png" title="Click To View Details Of This Request">';

			$tp=array($pix,$row['artist'],$row['market_type'],$row['trans_type'],$row['symbol'],number_format($row['tokens'],0),'&#8358;'.number_format($row['marketprice'],2),$view);
			
			$data[]=$tp;
		endforeach;

		print_r(json_encode($data));
	}
	
	function GetMarketPrice()
	{
		$symbol='';
		
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));
		
		$sym = $this->getdata_model->GetCurrentSymbolPrice($symbol);
		
		echo $sym;
	}
	
	public function index()
	{
		$data['lastname']=''; $data['firstname']=''; $data['email']=''; $data['phone']=''; $data['pix']='';
		$data['accountstatus'] = ''; $data['pix'] = ''; $data['broker_id']='';
		$data['company']=''; $data['address']='';
		
		$data['CreateAccount']='0';
		$data['AddItem']='0'; $data['EditItem']='0'; $data['DeleteItem']='0'; $data['ClearLogFiles']='0';
		$data['ViewLogReports']='0'; $data['ViewReports']='0'; $data['SetParameters']='0';
		
		$data['SetMarketParameters']=''; $data['ViewOrders']=''; $data['ViewPrices']='';
		$data['BuyAndSellToken']=''; $data['RegisterBroker']=''; $data['PublishWork']='';
		$data['RequestListing']='';
		
		$data['userlogo'] = '';
		
		if ($_SESSION['email'])
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
			
			$set=$this->getdata_model->GetParamaters();
				
			if (intval($set->refreshinterval) > 0)
			{
				$data['RefreshInterval'] = $set->refreshinterval;
			}else
			{
				$data['RefreshInterval']=5;
			}
			
			$det = $this->getdata_model->GetBrokerDetails($data['email']);
				
			if ($det->broker_id) $data['broker_id'] = trim($det->broker_id);
			
			$data['balance']=$this->getdata_model->GetWalletBalance($data['email']);
			
			$set = $this->getdata_model->GetTradingParamaters();			
			if ($set->brokers_commission) $data['brokers_rate'] = $set->brokers_commission;
			if ($set->nse_commission) $data['nse_rate'] = $set->nse_commission;
			if ($set->price_limit_percent) $data['price_limit_percent'] = $set->price_limit_percent;
			if ($set->sms_fee) $data['sms_fee'] = $set->sms_fee; else $data['sms_fee'] = '0';
			if ($set->min_buy_qty) $data['min_buy_qty'] = $set->min_buy_qty; else $data['min_buy_qty']='';
			
			//Paystack settings
			$pay = $this->getdata_model->GetPaystackSettings();			
			if ($pay->transfer_fee) $data['transfer_fee']=$pay->transfer_fee; else $data['transfer_fee']='';
						
			$this->load->view('ui/viewtraderequest_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('');
		}
	}
}
