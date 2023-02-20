<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");

date_default_timezone_set('Africa/Lagos');
set_time_limit(0);

require_once(realpath('.')."/vendor/autoload.php"); 

class ArtworkDetails extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	
	public function GetTrades()
	{
		$email=''; $startdate=''; $enddate=''; $usertype=''; $data=array();
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('startdate')) $startdate = $this->input->post('startdate');
		if ($this->input->post('enddate')) $enddate = $this->input->post('enddate');
		
		if (trim(strtolower($usertype)) == 'investor')
		{
			$qry = "SELECT * FROM primary_trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND (TRIM(buy_investor_email)='".$this->db->escape_str($email)."') AND (TRIM(payment_status)='Successful') ORDER BY tradedate DESC";
			
			$query = $this->db->query(stripslashes($qry));
		
			$results = $query->result_array();
			
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
						
				$tp=array($dt,$row['trade_id'],$row['symbol'],$qty,$pr,$amt,$row['issuer_email'],$row['buy_investor_email']);
				
				$data[]=$tp;
			endforeach;
		}		

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
	
	public function GetMarketData()
	{
		$usertype=''; $data=array();
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		
		if (strtolower($usertype) == 'investor') //or (strtolower($usertype) == 'investor/issuer'))
		{
			$qry = "SELECT *,(SELECT email FROM issuers WHERE TRIM(issuers.uid)=TRIM(primary_market.uid) LIMIT 0,1) AS issuer_email,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS pix,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS title,(SELECT artist FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS artist,(SELECT artwork_value FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS artwork_value,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS creationyear FROM primary_market WHERE (TRIM(listing_status)='Started') ORDER BY symbol";//Pending, Started, Ended
	
			$query = $this->db->query(stripslashes($qry));
			
			$results = $query->result_array();
			
			$sn=-1;
	
			foreach($results as $row):
				$buy=''; $pix='';
				
				if ($row['pix'])
				{
					$pix='<img onClick="ShowPix(\''.$row['symbol'].'\',\''.$row['title'].'\',\''.$row['pix'].'\',\''.$row['blockchainUrl'].'\');" style="cursor:pointer; max-height:60px;border-radius:12px; padding:2px 1px;box-shadow: 2px 10px 15px #a1b8a2;" src="'.base_url().'art-works/thumbs/t_'.$row['pix'].'" title="Click To Display '.strtoupper(trim($row['title'])).' Picture">'.'<br>'.$row['title'].', '.$row['creationyear'];				
				}
							
				$sn++;
				
				$buy='<input type="button" class="btn btn-success makebold" onClick="ShowMarketData(\''.$sn.'\',\''.$row['symbol'].'\',\''.$row['price'].'\',\''.$row['tokens_available'].'\',\''.$row['title'].'\',\''.$row['issuer_email'].'\')" style="cursor:pointer; height:auto; width: 100%;  text-align:center; padding:0;" title="Buy Artwork With Symbol '.strtoupper(trim($row['symbol'])).'" value="Buy Artwork">';						
				
				$tp=array($pix,$row['artist'],$row['symbol'],'&#8358;'.number_format($row['artwork_value'],2),number_format($row['tokens_available'],0),'&#8358;'.number_format($row['price'],2),$buy);
				
				$data[]=$tp;
			endforeach;	
		}
		
		print_r(json_encode($data));
	}
	
	function BuyPrimaryTokens()
	{
		$buy_investor_email=''; $buy_investor_name=''; $symbol=''; $price=''; $qty=''; $available_qty=''; 		$nse_commission=''; $sms_fee=''; $TransferFee=''; $issuer_email=''; $TradeAmount=''; 
		$total_amount='';
		
		if ($this->input->post('buy_investor_email')) $buy_investor_email = trim($this->input->post('buy_investor_email'));
		if ($this->input->post('buy_investor_name')) $buy_investor_name = trim($this->input->post('buy_investor_name'));		
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));	
		if ($this->input->post('price')) $price = trim($this->input->post('price'));
		if ($this->input->post('qty')) $qty = trim($this->input->post('qty'));
		if ($this->input->post('available_qty')) $available_qty = trim($this->input->post('available_qty'));
		if ($this->input->post('nse_commission')) $nse_commission = trim($this->input->post('nse_commission'));
		if ($this->input->post('sms_fee')) $sms_fee = trim($this->input->post('sms_fee'));
		if ($this->input->post('transfer_fee')) $TransferFee = trim($this->input->post('transfer_fee'));
		if ($this->input->post('issuer_email')) $issuer_email = trim($this->input->post('issuer_email'));
		if ($this->input->post('tradeamount')) $TradeAmount = trim($this->input->post('tradeamount'));
		if ($this->input->post('total_amount')) $total_amount = trim($this->input->post('total_amount'));
		
		$tradedate=$this->getdata_model->GetOrderTime();
				
		$issuer_recipient_code=''; $buyer_recipient_code =''; $nse_recipient_code='';
		
		//Get recipient codes
		$issuer_recipient_code = $this->getdata_model->GetRecipientCode($issuer_email,'issuer');
		$buyer_recipient_code = $this->getdata_model->GetRecipientCode($buy_investor_email,'investor');
		$nse_recipient_code = $this->getdata_model->GetNSERecipientCode('admin');		
		
		$investor_email=''; $investor_phone='';
			
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
		
		$nsefee = floatval($nse_commission) * 2;
						
		$total_issuer_fee=floatval($TradeAmount) - floatval($nse_commission) - floatval($TransferFee) - floatval($sms_fee);
		
		$trade=array('trade_id'=>$trade_id,'symbol'=>$symbol,'num_tokens'=>$qty,'price'=>$price,'nse_fee'=>$nsefee,'sms_fee'=>(floatval($sms_fee) * 2),'transfer_fees'=>($TransferFee * 2),'tradestatus'=>1,'payment_status'=>'Successful','tradedate'=>$tradedate,'trade_amount'=>$TradeAmount,'total_buyer_fee'=>$total_amount,'total_issuer_fee'=>$total_issuer_fee,'issuer_recipient_code'=>$issuer_recipient_code,'buyer_recipient_code'=>$buyer_recipient_code,'nse_recipient_code'=>$nse_recipient_code,'buy_investor_email'=>$buy_investor_email,'issuer_uid'=>$issuer_uid,'issuer_email'=>$issuer_email,'issuer_phone'=>$issuer_phone,'buy_investor_phone'=>$buy_investor_phone,'issuer_name'=>$issuer_name,'buy_investor_name'=>$buy_investor_name);

		//Checkif buyer has recipientcode
		if (!isset($buyer_recipient_code))
		{
			$m="Transaction failed. Your bank details have not been added to your profile. Without your bank details, you cannot trade on the platform. Add your bank details in the user profile module.";
		
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
				$bal=$this->getdata_model->GetWalletBalance($buy_investor_email);
				
				if (floatval($bal) < floatval($total_amount))
				{
					$m="You do not have enough balance in your e-wallet to buy this security. Your current e-wallet balance is <b>₦".number_format($bal,2)."</b> and the total amount needed to buy ".number_format($qty,0)." tokens of ".$symbol." is <b>₦" . number_format($total_amount,2) . "</b>.";
					
					$ret=array('status'=>'FAIL','Message'=>$m);
				}else
				{
					$Msg='';					
						
					//Send trade to trading direct engine
					$res = $this->getdata_model->DirectInvestorPrimaryMarketEngine($trade);
					
					if ($res['Status']<> 1)
					{
						$ret=array('status'=>'FAIL','Message'=>$res['msg']);
						
						$Msg ="Purchase of ".number_format($qty,0)." tokens of artwork with symbol, ".strtoupper($symbol).", by ".strtoupper($buy_investor_name)." with email ".$buy_investor_email.", was not successful. ERROR: ".strtoupper($res['msg']);
					}else
					{						
						$Msg=$buy_investor_name.' with email '.$buy_investor_email.", has successfully bought ".number_format($qty,0)." tokens of '".$symbol."' at the primary market.";
						
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
						
						$details = strtoupper($buy_investor_name)." has purchased ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title)." at ₦".number_format($price,2)." per token at the primary market.";
						
						$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
						
						//Send Email
						$from = 'admin@naijaartmart.com';
						$to = $buy_investor_email;
						$subject = $header;
						$Cc = 'idongesit_a@yahoo.com';
										
						$img=base_url()."images/logo.png";
						$img="https://www.naijaartmart.com/images/emaillogo.png";
											
						//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
					
						$message = '
							<html>
							<head>
							<meta charset="utf-8">
							<title>Naija Art Mart | Purchase Of Artwork Tokens</title>
							</head>
							<body>								
							
							<p><img src="'.$img.'" alt="Naija Art Mart" title="Naija Art Mart" /></p>
													
							Dear Investor,<br><br>
									
							You have purchased '.number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title).", at ₦".number_format($price,2)." per token at the primary market.
											
							<p>Best Regards</p>
							Naija Art Mart
							
							</body>
							</html>";
							
						$altmessage = "
							Dear Investor,
									
							You have purchased ".number_format($qty,0)." tokens of artwork with symbol ".strtoupper($symbol)." titled, ".strtoupper($title)." at NGN".number_format($price,2)." per token at the primary market.
									
							Best Regards
							Naija Art Mart";
						
						if ($to) $v=$this->getdata_model->SendBlueMail($from,$to,$subject,$Cc,$message,$altmessage,$buy_investor_name);
							
						
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
						$to=$issuer_email;
						$subject=$header;
						$Cc='idongesit_a@yahoo.com';
										
						//$img=base_url()."images/logo.png";
											
						//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
					
						$message = '
							<html>
							<head>
							<meta charset="utf-8">
							<title>Naija Art Mart | Sale Of Artwork Tokens</title>
							</head>
							<body>								
							
							<p><img src="'.$img.'" alt="Naija Art Mart" title="Naija Art Mart" /></p>
															
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
						
						if ($to) $v=$this->getdata_model->SendBlueMail($from,$to,$subject,$Cc,$message,$altmessage,$buy_investor_name);
						
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
	
	public function index()
	{
		// echo "<pre>";
		// print_r($_SERVER); die();
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
			
			if (trim(strtolower($data['usertype']))=='investor')// or (trim(strtolower($data['usertype']))=='investor/issuer'))
			{
				$det = $this->getdata_model->GetInvestorDetails($data['email']);
				
				if ($det->uid) $data['investor_id'] = trim($det->uid);	
				
				$data['balance']=$this->getdata_model->GetWalletBalance($data['email']);			
			
				$set = $this->getdata_model->GetTradingParamaters();			
				if ($set->brokers_commission) $data['brokers_rate'] = $set->brokers_commission;
				if ($set->nse_commission) $data['nse_rate'] = $set->nse_commission;
				if ($set->price_limit_percent) $data['price_limit_percent'] = $set->price_limit_percent;
				if ($set->sms_fee) $data['sms_fee'] = $set->sms_fee; else $data['sms_fee'] = '0';
				
				//Paystack settings
				$pay = $this->getdata_model->GetPaystackSettings();			
				if ($pay->transfer_fee) $data['transfer_fee']=$pay->transfer_fee; else $data['transfer_fee']='';
				$data['LastestPixs']=$this->getdata_model->GetLatestListings();//latest 3
				
				$this->load->view('ui/directinvestorprymarket_view',$data);
			}else
			{
				$this->getdata_model->GoToLogin('');
			}
		}else
		{
			$this->getdata_model->GoToLogin('');
		}
	}

	public function Market($id) {

		$id = html_entity_decode($id);
		// die($id);
        $data['lastname']=''; $data['firstname']=''; $data['email']=''; $data['phone']=''; $data['pix']='';
		$data['accountstatus'] = ''; $data['role'] = ''; $data['pix'] = '';
		
		$data['CreateAccount']='0';
		$data['AddItem']='0'; $data['EditItem']='0'; $data['DeleteItem']='0'; $data['ClearLogFiles']='0';
		$data['ViewLogReports']='0'; $data['ViewReports']='0'; $data['SetParameters']='0';
		
		$data['SetMarketParameters']=''; $data['ViewOrders']=''; $data['ViewPrices']='';
		$data['BuyAndSellToken']=''; $data['RegisterBroker']=''; $data['PublishWork']='';
		$data['RequestListing']='';

		$data['artwork_id'] = $id;
		
		$data['userlogo'] = '';

		$qry = "SELECT daily_price.*,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT artist FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS artist,(SELECT description FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS description,(SELECT dimensions FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS dimensions,(SELECT materials FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS materials,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS title,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS creationyear,(SELECT id FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol) LIMIT 0,1) AS art_id FROM daily_price WHERE symbol='".$id."'";

		//$qry = "SELECT *,(SELECT email FROM issuers WHERE TRIM(issuers.uid)=TRIM(primary_market.uid) LIMIT 0,1) AS issuer_email,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS pix,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS title,(SELECT artist FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS artist,(SELECT artwork_value FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS artwork_value,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_market.symbol) LIMIT 0,1) AS creationyear FROM primary_market WHERE (TRIM(listing_status)='Started') AND art_id = ".$id." ORDER BY symbol";//Pending, Started, Ended
	
			$query = $this->db->query(stripslashes($qry));
			
			$results = $query->result_array();
			// echo "<pre>";
			// print_r($results); die();
		
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
			
			if (trim(strtolower($data['usertype']))=='investor' or (trim(strtolower($data['usertype']))=='broker'))
			{
				$det = $this->getdata_model->GetInvestorDetails($data['email']);
				
				if ($det->uid) $data['investor_id'] = trim($det->uid);	
				
				$data['balance']=$this->getdata_model->GetWalletBalance($data['email']);			
			
				$set = $this->getdata_model->GetTradingParamaters();			
				if ($set->brokers_commission) $data['brokers_rate'] = $set->brokers_commission;
				if ($set->nse_commission) $data['nse_rate'] = $set->nse_commission;
				if ($set->price_limit_percent) $data['price_limit_percent'] = $set->price_limit_percent;
				if ($set->sms_fee) $data['sms_fee'] = $set->sms_fee; else $data['sms_fee'] = '0';
				
				//Paystack settings
				$pay = $this->getdata_model->GetPaystackSettings();			
				if ($pay->transfer_fee) $data['transfer_fee']=$pay->transfer_fee; else $data['transfer_fee']='';
				$data['LastestPixs']=$results[0];//latest 3

				// echo "<pre>";
				// print_r($data); die;
				if (isset($_GET['action']) && strtolower($_GET['action']) == 'buy') {
					$this->load->view('ui/buyartwork',$data);
				}else{
					$this->load->view('ui/artwork',$data);
				}
				
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
