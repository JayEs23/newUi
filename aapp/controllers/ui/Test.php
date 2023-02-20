<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('assets/vendor/autoload.php');

require_once(realpath('.')."/vendor/autoload.php"); 

class Test extends CI_Controller {
	private $reg_success=false;
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function Testpost()
	{
		$v = $this->uri->segment(4);
		
		$file = fopen('aaa.txt',"a"); fwrite($file,print_r("Received v = ".$v."\r\n",true)); fclose($file);		
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
		
		
		/*$broker_id='C235678AB';
		$investor_id='idongesit@gmail.com';
		$symbol="AWEBEA";
		$transtype='Buy';
		$price='4900';
		$qty=130;
		$ordertype='GTM';
		$expirydate='Jan 2021';
		
		$broker_id='C123567AB';
		$investor_id='idong.akpan@divinetreasurers.com';
		$symbol="AWEBEA";
		$transtype='Sell';
		$price='';
		$qty=45;
		$ordertype='GTC';
		$expirydate='Jan 2021';*/
		
		//$broker_status=IsValidateBroker('idongakpan@brandstolife.com',$db);
				
		//echo GetMonthEnd('jan 2020');
		
		//print_r(IsValidateBroker('idongakpan@brandstolife.com',$db)); exit();
		
		//$order=array('order_id'=>'','broker_id'=>$broker_id,'investor_id'=>$investor_id,'transtype'=>$transtype,'symbol'=>$symbol,'price'=>$price,'qty'=>$qty,'available_qty'=>$qty,'ordertype'=>$ordertype,'orderdate'=>'','expirydate'=>$expirydate,'orderstatus'=>'','broker_commission'=>'','nse_commission'=>'','transfer_fee'=>'','sms_fee'=>'','total_amount'=>'','trade_amount'=>'','limit_market'=>'','broker_recipient_code'=>'','investor_recipient_code'=>'');
		
		//$data['OrderBook'] = $this->getdata_model->TradingGateway($order);
		
		
		
		//$bal=$this->getdata_model->CheckPaystackBalance();
		
		//$pw='Abc7&#^*'; //Abc7&#^*   Abc7&#^*
		//$dec='U2FsdGVkX18zOpiZ/fSK0ESOycdeyx3NqhTtx6O6/wQ=';
		
		//$data['enc']=\mervick\aesEverywhere\AES256::encrypt($pw,ACCESS_STAMP);
		//$data['dec']=\mervick\aesEverywhere\AES256::decrypt($dec,ACCESS_STAMP);
		
		//$data['Balance']=$bal['Currency'].' '.number_format($bal['Balance'],2);
		
		//$ret=$this->getdata_model->GetPortfolioDetails($symbol,'C123567AB','idong.akpan@divinetreasurers.com');
		
		//if ($ret->tokens) $data['Tokens']=number_format($ret->tokens,0); else $data['Tokens']='0';
		
		
		//$data['CloseMarket']= $this->getdata_model->SetDayPrice();
		
		//$data['OrderBook'] = $this->getdata_model->GetOrderBook($symbol);
		
		/////////////////////////// TEST DB BACKUP ////////////////////////////
		
		//$r=$this->getdata_model->BackupDB();
		
		//if ($r) $data['ret']='Database Has Been Backed Up.';
		
		if ($this->db->table_exists('alerts'))
		{
			//$sql="DROP TABLE alerts";
			//$this->db->query($sql);

			//$this->load->dbforge();
			//$this->dbforge->drop_table('alerts');
			//$data['ret']='Table Has Been Dropped.';
		}else
		{
			//$data['ret']='Table alerts does not exist.';
		}
		
		
		///////////////////////////////////////
		
		//$today=date('Y-m-d');
		//$yesterday=date('Y-m-d',strtotime('yesterday'));
		//$data['returnvalue'] = $this->getdata_model->SetDayPrice();
		//$data['returnvalue'] = $this->getdata_model->CloseMarket();
		
		//$data['msgid'] = $this->getdata_model->GetId('issuers','uid');
		
		
		/// RESIZE TEST
		/*$art_id=1;
		$fn=$art_id."_pix1.jpg";
		$thumb="t_".$art_id."_pix1.jpg";
		
		$f="bruno-emmanuelle-ahtoh0_C8EI-unsplash.jpg";
		
		rename("t/".$f,"t/".$fn);		
		
		$target 		= "t/".$fn;
		$thumb_target 	= "t/thumbs/".$thumb;	
				
		$pix1=$fn;
		$image_info = getimagesize('t/'.$fn);
		$imgWidth = $image_info[0];
		$imgHeight = $image_info[1];
		
		if ($imgWidth > 1000) $this->getdata_model->ResizeImage($target,1000); //Resize to 1000px
		
		$r=copy($target, $thumb_target);
		
		if ($r === true)//Create thumbnails	
		{										
			$this->getdata_model->ResizeImageByHeight($thumb_target,100); //Resize to 100px	
			$data['res']="<b>".$pix1."</b> and <b>".$thumb."</b> were created.<br>".$pix1." initial width was <b>".$imgWidth."px</b>";
		}else
		{
			$data['res']="<b>".$pix1."</b> was created. <b>".$thumb."</b> was not created.<br>".$pix1." initial width was <b>".$imgWidth."px</b>";
		}*/
		/////////////////END RESIZE TEST ////////////////////
		
		
		/*$ChangePriceQty='Yes';
		
		$postdata=array('order' => $order, 'changeprice' => $ChangePriceQty);
		
		$url=base_url()."admin/Tradinggateway/Process";
		
		
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
			$data['curl']=$event->response;
		});*/
		
	
		
		// Execute queue
		//$queue->send();		
		/*
		$bal=$this->getdata_model->BulkSMSBalance();
		
		$row=$this->getdata_model->GetTradingParamaters();
		$sms_fee=0;
		if ($row->sms_fee) $sms_fee=$row->sms_fee;
		
		$bal=$this->getdata_model->BulkSMSBalance();
		
		if (floatval($bal) < ($sms_fee * 50))
		{
			//Send system message to Admin
			$msgtype='system,email';						
			$header='Bulk SMS Balance Very Low';
			$groups='';
			$emails='admin@naijaartmart.com';
			$phones='';
			$category='Message';
			$display_status=1;
			$sender='System';						
			
			$details="Current Naija Art Mart bulk SMS balance is NGN".number_format($bal,2).". Your need to credit your bulk SMS wallet as soon as possible.";
			
			$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
			
			
			//Send EMAIL to Issuer
			$from='admin@naijaartmart.com';
			$to='admin@naijaartmart.com';
			$subject=$header;
			$Cc='idongesit_a@yahoo.com';
							
			$img=base_url()."images/logo.png";
								
			//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
		
			$message = '
				<html>
				<head>
				<meta charset="utf-8">
				<title>Naija Art Mart | Recharge Bulk SMS Account</title>
				</head>
				<body>								
													
						Dear Admin,<br><br>
						
						<b><u>Attention:</u></b>
						<br><br>Current Naija Art Mart bulk SMS balance is <b>&#8358;'.number_format($bal,2).'</b>. You need to credit your bulk SMS wallet as soon as possible.
				</body>
				</html>';
				
			$altmessage = 'Dear Admin,
						
				Attention:
				Current Naija Art Mart bulk SMS balance is NGN'.number_format($bal,2).'. You need to credit your bulk SMS wallet as soon as possible.';
			
			$v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,'Admin');
			
			
		}
		
		$users=$this->getdata_model->GetUsers(array('Admin','Gallery'));
		
		$emails='';
		
		if ($users)
		{
			foreach($users as $u)
			{
				if (trim($emails)=='') $emails=$u->email; else $emails .= ",".$u->email;
			}
		}*/
		
		//$msgs=$this->getdata_model->CheckIfMessageDateHasExpired();
		
		/*$ret=$this->getdata_model->CheckPaystackBalance();
		
		$sta=$ret['Status'];
		
		if ($sta==1)
		{
			$data['msgs']='Balance:  '.$ret['Currency'].$ret['Balance'];
		}else
		{
			$data['msgs']=$ret['message'];
		}*/
		
		//$symbol="EXSPEC";
		
		//$data['result']=$this->getdata_model->GetArtTitle($symbol);
		
		$currency='NGN';
		$recipient_code='RCP_do4dza1hkqn27c8';
		$description='Testing single transfer';
		$recipient_amount=5000;
		
		/*		
		$recipient = array('source' => "balance", 'amount' => (floatval($recipient_amount) * 100), 'recipient' => $recipient_code, 'reason' => $description);							
							
		$recipient_string = http_build_query($recipient);
		
		$transfer_result = $this->getdata_model->PaystackSingleTransferFund($recipient_string);
		*/
		
		/*$recipients=array(
			"currency"=>$currency,
			"source"=>"balance", 
			"transfers"=>array(array("amount"=>(floatval($recipient_amount) * 100), "reason"=>$description, "recipient"=>$recipient_code))
		);
				
		$data_string = http_build_query($recipients);
		
		$transfer_code='TRF_3gt9c7si9lw5c3p';
		
		$data['Transfer']=$this->getdata_model->PaystackFetchTransfer($transfer_code);*/
		
		$artistName='Greater Man';
		$artId = 26;
		$artTitle = "Graceful Face 2";
		$artSymbol = "GRFA2";
		$artDescription = "The face of beauty and grace 2.";
		$artCreationYear = "2021";
		$artValue = 20000000;
		$artPicture = "https://www.naijaartmart.com/test/art-works/2_pix1.jpg";
		$pricePerToken = 2000;
		$numberOfTokens = 10000;
		$numberOfTokensForSale = 5000;
		$issuerEmail = "muyiwabamgboye@gmail.com";
		
		$userId=$this->getdata_model->GetBlockchainUserID();
		$data['userId']=$userId;
		$email = "idyema1h@gmail.com";
		$phone = "08071234567";
		$userType= 'Admin'; //Broker/Investor/Issuer
		$userName='Idara Emy1';
		
		$usr = array("userId"=>$userId, "email"=>$email, "phone"=>$phone, "userType"=>$userType, "userName"=>$userName);
		
		//$data['user']=$this->getdata_model->CreateUserOnBlockchain($usr);
		
		
		$dat = array('artistName' => $artistName, 'artId'=>$artId, 'artTitle'=>$artTitle, 'artSymbol'=>$artSymbol, "artDescription" => $artDescription, "artCreationYear"=>$artCreationYear, "artValue"=>$artValue, "artPicture"=>$artPicture, "pricePerToken"=>$pricePerToken, "numberOfTokens"=>$numberOfTokens, "numberOfTokensForSale"=>$numberOfTokensForSale, "issuerEmail"=>$issuerEmail);
		
		//$data['asset']=$this->getdata_model->CreateAssetOnBlockchain($dat);
		
		$data['users']=$this->getdata_model->GetBlockchainUsersByRole(3);
		
		
		$this->load->view('ui/test_view',$data);#Fail Page		
	}
}
