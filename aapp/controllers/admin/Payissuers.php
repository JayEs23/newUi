<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('assets/vendor/autoload.php');

class Payissuers extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	 }
	
		
	function GetTradesLists()
	{
		$sql = "SELECT issuers_to_pay.*,(SELECT listing_ends FROM listed_artworks WHERE TRIM(listed_artworks.symbol)=TRIM(issuers_to_pay.symbol) LIMIT 0,1) AS listing_ends FROM issuers_to_pay WHERE (payment_status<>1) ORDER BY trade_date,trade_id";											

		$query = $this->db->query(stripslashes($sql));	

		$results = $query->result_array();		

		if ($results)
		{
			$data=array();

			if (is_array($results))
			{
				$sn=0; $bal='';
				
				$ret=$this->getdata_model->CheckPaystackBalance();
		
				$sta=$ret['Status'];
		
				if ($sta==1)
				{
					$bal = $ret['Balance'];
				}else
				{
					$bal = $ret['message'];
				}
		
				
				foreach($results as $row):
					$sn++; $sel=''; $tdt=''; $ended='No'; $sdt='';
					
					if ($row['listing_ended']==1)
					{
						$ended='<span title="Listing Ended On '.date('d M Y',strtotime($row['listing_ends'])).'">Yes</span>';
					}else
					{
						$ended='<span title="Listing Will End On '.date('d M Y',strtotime($row['listing_ends'])).'">No</span>';
					}
					
					if ($row['trade_date']) $tdt=date('d M Y',strtotime($row['trade_date']));
					if ($row['listing_ends']) $sdt=date('d M Y',strtotime($row['listing_ends']));
					
//issuer_email,trade_id,trade_date,symbol,num_tokens,price,trade_amount,recipient_amount,currency,description,recipient,recipient_code,transfer_code,listing_ended,listing_ends					
					if ($row['listing_ended']==1)
					{						
						$sel='<img onClick="ViewRow(\''.$row['issuer_email'].'\',\''.$row['trade_id'].'\',\''.$tdt.'\',\''.$row['symbol'].'\',\''.$row['num_tokens'].'\',\''.$row['price'].'\',\''.$row['trade_amount'].'\',\''.$row['recipient_amount'].'\',\''.$row['currency'].'\',\''.$row['description'].'\',\''.$row['recipient'].'\',\''.$row['recipient_code'].'\',\''.$row['transfer_code'].'\',\''.$row['listing_ended'].'\',\''.$sdt.'\',\''.$bal.'\')" style="cursor:pointer; height:30px; " src="'.base_url().'images/view_icon.png" title="Select '.strtoupper(trim($row['symbol'])).' Trade Record">';
					}else
					{
						$sel='';
					}
							
					$tp=array($tdt,$row['symbol'],number_format($row['num_tokens'],0),number_format($row['price'],2),number_format($row['recipient_amount'],2),$row['issuer_email'],$ended,$sel);
					
					$data[]=$tp;
				endforeach;
			}

			print_r(json_encode($data));
		}else
		{
			print_r(json_encode($results));
		}
	}
	
	public function MakePayment()
	{
		$trade_date=''; $trade_id=''; $symbol=''; $num_tokens=''; $price='';$trade_amount='';
		$recipient_amount=''; $listingenddate=''; $listing_ended=''; $issuer_email=''; $recipient_code='';
		$email=''; $description='';	$Msg='';  $currency='NGN';
		
		if ($this->input->post('trade_date')) $trade_date = trim($this->input->post('trade_date'));	
		if ($this->input->post('trade_id')) $trade_id = trim($this->input->post('trade_id'));
		if ($this->input->post('symbol')) $symbol = strtoupper(trim($this->input->post('symbol')));
		if ($this->input->post('num_tokens')) $num_tokens = trim($this->input->post('num_tokens'));
		if ($this->input->post('price')) $price = trim($this->input->post('price'));
		if ($this->input->post('trade_amount')) $trade_amount = trim($this->input->post('trade_amount'));
		if ($this->input->post('recipient_amount')) $recipient_amount = trim($this->input->post('recipient_amount'));
		if ($this->input->post('listingenddate')) $listingenddate = trim($this->input->post('listingenddate'));
		if ($this->input->post('listing_ended')) $listing_ended = trim($this->input->post('listing_ended'));
		if ($this->input->post('issuer_email')) $issuer_email = trim($this->input->post('issuer_email'));
		if ($this->input->post('recipient_code')) $recipient_code = trim($this->input->post('recipient_code'));		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('description')) $description = ucwords(trim($this->input->post('description')));		
									
		$transfer_date=date('Y-m-d H:i:s');
											
		//Check if symbol exists
		$sql = "SELECT * FROM issuers_to_pay WHERE (TRIM(trade_id)='".$this->db->escape_str($trade_id)."') AND (TRIM(symbol)='".$this->db->escape_str($symbol)."')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() == 0 )
		{
			$Msg="No issuer payment record was found for trade Id ".$trade_id." and security ".$symbol." in the database.";
			
			$m = "Payment to the issuer was NOT successful. Symbol, <b>".strtoupper($symbol)."</b> with trade Id <b>".$trade_id."</b> does not exist in the payment table.";
			
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			$row = $query->row();
			
			if ($row->listing_ended <> 1)
			{
				$Msg="Payment was not successful. The listing period for the security, ".$symbol.", with trade Id, ".$trade_id.", has not ended.";
			
				$m = "Payment to the issuer was NOT successful. Listing period for the security, <b>".strtoupper($symbol)."</b> with trade Id <b>".$trade_id."</b> has not ended.";
				
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{
				//Check paystack balance
				$bal=''; $transferfee=0; $sms=0;
				$paystack = $this->getdata_model->GetPaystackSettings();
				if ($paystack->transfer_fee) $transferfee = $paystack->transfer_fee;
				
				$set = $this->getdata_model->GetTradingParamaters();
				if ($set->sms_fee) $sms = $set->sms_fee;
				
				$rt=$this->getdata_model->CheckPaystackBalance();
		
				$sta=$rt['Status'];
		
				if ($sta==1)
				{
					$bal = $rt['Balance'];
					
					if (floatval($bal) < floatval($recipient_amount))
					{
						$Msg="You do not have enough balance in the paystack account to pay the issuer. Current paystack balance is (NGN".number_format($bal,2).") and the total amount needed to pay the issuer is (" . number_format($recipient_amount,2) . ").";
						
						$m = "You do not have enough balance in the paystack account to pay the issuer. Current paystack balance is (<b>₦".number_format($bal,2)."</b>) and the total amount needed to pay the issuer is (<b>₦" . number_format($recipient_amount,2) . "</b>).";
						
						$ret=array('status'=>'FAIL','Message'=>$m);	
					}else
					{
						//Get recipient code
						$recipient_code=$this->getdata_model->GetRecipientCode($issuer_email,'issuer');
						
						if (!isset($recipient_code))
						{
							$m="Payment failed. The issuer's bank details have not been added to the profile. Without the issuer's bank details, you cannot make the transfer. Ask the issuer to add the bank details in the user profile module.";
						
							$ret=array('status'=>'FAIL','Message'=>$m);
						}else
						{
							/*$recipient = array('source' => "balance", 'amount' => (floatval($recipient_amount) * 100), 'recipient' => $recipient_code, 'reason' => $description);							
							
							$recipient_string = http_build_query($recipient);
							
							$transfer_result = $this->getdata_model->PaystackSingleTransferFund($recipient_string);*/							
							

							$recipients=array(
								"currency"=>$currency,
								"source"=>"balance", 
								"transfers"=>array(array(
									"amount"=>(floatval($recipient_amount) * 100), 
									"reason"=>$description, 
									"recipient"=>$recipient_code
								))
							);
				
							$data_string = http_build_query($recipients);							
																																
							$transfer_result=$this->getdata_model->PaystackBulkTransferFunds($data_string);
						
							if ($transfer_result['Status']==1)
							{
								$transfercode='';
								
								$paydata=$transfer_result['data'];
							
								foreach($paydata as $pd)
								{
									$transfercode=$pd['TransferCode'];
									
									if (trim($pd['Recipient'] == trim($recipient_code)) And (floatval($pd['Amount']/100) == floatval($recipient_amount)))
									{
										//Update transfer_code,payment_status,transfer_date
										$this->db->trans_start();	
							
										$dat=array(
											'transfer_code'	=> $this->db->escape_str($transfercode),
											'payment_status'=> 1,
											'transfer_date'	=> $transfer_date
										);			
						
										$this->db->where(array('trade_id'=>$trade_id, 'symbol'=>$symbol));
										$this->db->update('issuers_to_pay',$dat);
																	
										$this->db->trans_complete();
									}
									
									//Update trade_payments
									$sql="SELECT * FROM trades_payments WHERE (TRIM(trade_id)='".$this->db->escape_str($trade_id)."') AND (TRIM(recipient)='Issuer') AND (recipient_amount=".$this->db->escape_str($recipient_amount).") AND (TRIM(recipient_code)='".$this->db->escape_str($recipient_code)."')";
										
									$query=$this->db->query($sql);
									
									if ($query->num_rows() == 0)
									{
										$this->db->trans_start();	
											
										$dat=array(
											'trade_id' 			=> $this->db->escape_str($trade_id),
											'symbol' 			=> $this->db->escape_str($symbol),
											'num_tokens' 		=> $this->db->escape_str($num_tokens),
											'currency' 			=> $this->db->escape_str($currency),
											'price' 			=> $this->db->escape_str($price),
											'trade_amount' 		=> $this->db->escape_str($trade_amount),
											'recipient_amount'	=> $this->db->escape_str($recipient_amount),
											'recipient' 		=> 'Issuer',
											'recipient_code' 	=> $this->db->escape_str($recipient_code),
											'description'		=> $this->db->escape_str($description),
											'transfer_code'		=> $this->db->escape_str($transfercode),
											'transfer_date'		=> $this->db->escape_str($transfer_date),
											'trade_date'		=> $this->db->escape_str($trade_date)
										);
							
										$this->db->insert('trades_payments', $dat);	
											
										$this->db->trans_complete();
									}
								}
								
								//Log Payment To Issuer
								$operation='Made Payment By Transfer To Issuer';
						
								$activity='Payment by transfer was made to Issuer successfully. Details Of Trade: Trade Date: '.$trade_date.'; Trade Id: '.$trade_id.'; Security: '.$symbol.'; Token Quantity: '.$num_tokens.'; Token Price: '.$price.'; Trade Amount: '.$trade_amount.'; Amount Transferred: '.$recipient_amount.'; Transfer Code: '.$transfercode.'; Admin Email: '.$email;
										
								$username='System';
								$fullname='Naija Art Mart Core';
								$remote_ip=$_SERVER['REMOTE_ADDR'];
								$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
								
								$this->getdata_model->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
								
							
								//SEND MESSAGE TO ISSUER
								$rwt = $this->getdata_model->GetArtTitle($symbol);
								$title = trim($rwt);
							
								$issuer_phone=''; $issuer_name='';
								
								$det=$this->getdata_model->GetIssuerDetails($issuer_email);
								if ($det->phone) $issuer_phone = $det->phone;
								if ($det->user_name) $issuer_name = $det->user_name;
								
								$details='';
								$msgtype='system,sms';						
								$header='Payment For Primary Trade With Id '.$trade_id;
								$groups='';
								$emails=$issuer_email;
								$phones=$issuer_phone;
								$category='Message';
								//$expiredate='';
								$display_status=1;
								$sender='Naija Art Mart';						
								
								$details="Dear ".$issuer_name.", payment has been made to your registered account on Naija Art Mart by transfer for the trade involving your listed security with symbol ".strtoupper($symbol).". Trade Id is ".$trade_id." and the number of tokens sold is ".number_format($num_tokens,0)." at NGN".number_format($price,2)." per token. Trade Amount is NGN".number_format($trade_amount,2)." and amount transferred after deduction of sms (NGN".$sms.") and transfer fees (NGN".$transferfee.") is NGN".number_format($recipient_amount,2).". Transfer date is ".date('d M Y H:i:s',strtotime($transfer_date)).".";
								
								$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,NULL,$display_status,$sender);
								
								
								//Send EMAIL to Issuer
								$from='admin@naijaartmart.com';
								$to=$issuer_email;
								$subject=$header;
								$Cc='support@naijaartmart.com, idongesit_a@yahoo.com';
												
								$img=base_url()."images/logo.png";
													
								//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>		
								$message = '
									<html>
									<head>
									<meta charset="utf-8">
									<title>Naija Art Mart | Payment For Trade</title>
									</head>
									<body>								
																		
											Dear '.$issuer_name.',<br><br>
											
											Payment for trade with Id '.$trade_id.' for your listed security with symbol '.$symbol.' has been made to your registered account on Naija Art Mart by the admin. Below are the details of the payment:
											
											<table border="1" style="border:thin solid #3D3939; width:85%" cellpadding="7" cellspacing="0">
												<tr>
													<th style="width:40%;" align="right">Artwork&nbsp;Title:</th>
													<td style="width:60%;"><font color="#FF0000">'.strtoupper($title).'</font></td>
												</tr>
												
												<tr >
													<th align="right">Symbol:</th>
												   <td><font color="#FF0000">'.strtoupper($symbol).'</font></td>
												</tr>
												
												<tr>
													<th align="right">Trade&nbsp;Date:</th>
												   <td><font color="#FF0000">'.date('d F Y',strtotime($trade_date)).'</font></td>
												</tr>
																			
												<tr>
													<th align="right">Trade&nbsp;Id:</th>
												   <td><font color="#FF0000">'.$trade_id.'</font></td>
												</tr>
																			
												 <tr>
													<th align="right">No.&nbsp;Of&nbsp;Tokens&nbsp;Sold:</th>
												   <td><font color="#FF0000">'.number_format($num_tokens,0).'</font></td>
												</tr>
												
												<tr>
													<th align="right">Price&nbsp;Per&nbsp;Token:</th>
												   <td><font color="#FF0000">&#8358;'.number_format($price,2).'</font></td>
												</tr>
												
												<tr>
													<th align="right">Trade&nbsp;Amount:</th>
													<td><font color="#FF0000">&#8358;'.number_format($trade_amount,2).'</font></td>
												</tr>
												
												<tr>
													<th align="right">SMS&nbsp;Fee:</th>
													<td><font color="#FF0000">&#8358;'.number_format($sms,2).'</font></td>
												</tr>
												
												<tr>
													<th align="right">Transfer&nbsp;Fee:</th>
													<td><font color="#FF0000">&#8358;'.number_format($transferfee,2).'</font></td>
												</tr>
												
												<tr>
													<th align="right">Amount&nbsp;Transferred:</th>
													<td><font color="#FF0000">&#8358;'.number_format($recipient_amount,2).'</font></td>
												</tr>
												
												<tr>
													<th align="right">Recipient&nbsp;Code:</th>
													<td><font color="#FF0000">'.$recipient_code.'</font></td>
												</tr>
												
												<tr>
													<th align="right">Transfer&nbsp;Date:</th>
												   <td><font color="#FF0000">'.date('d F Y H:i:s',strtotime($transfer_date)).'</font></td>
												</tr>
											</table>
											
											<br><br>For any enquiry contact us at <a href="mailto:support@naijaartmart.com">support@naijaartmart.com</a>.
													
											<p>Best Regards</p>
											Naija Art Mart
									</body>
									</html>';
									
								$altmessage = '
									Dear '.$issuer_name.',
											
									Payment for trade with Id '.$trade_id.' for your listed security with symbol '.$symbol.' has been made to your registered account on Naija Art Mart by the admin. Below are the details of the payment:
									Artwork Title: '.strtoupper($title).'
									Symbol: '.strtoupper($symbol).'									
									Trade Date: '.date('d F Y',strtotime($trade_date)).'									
									Trade Id: '.$trade_id.'									
									No. Of Tokens Sold: '.number_format($num_tokens,0).'									
									Price Per Token: NGN'.number_format($price,2).'									
									Trade Amount: NGN'.number_format($trade_amount,2).'									
									SMS Fee: NGN'.number_format($sms,2).'									
									Transfer Fee: NGN'.number_format($transferfee,2).'
								
									Amount Transferred: NGN'.number_format($recipient_amount,2).'
									Recipient Code: '.$recipient_code.'
									Transfer Date: '.date('d F Y H:i:s',strtotime($transfer_date)).'
									
									For any enquiry contact us at support@naijaartmart.com.
											
									Best Regards
									Naija Art Mart';
								
								if ($to) $v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$issuer_name);
								
								if (strtoupper(trim($v)) <> 'OK')
								{
									$Msg ="Payment Was Successful, But Sending Of Email To Issuer Failed. A Message Has Been Sent To Issuer's Phone. Message Can Also Be Viewed Via Naija Art Mart Messaging Screen.";
									
									$ret=array('status'=>'OK','Message'=>$Msg);					
								}else
								{
									$Msg="Payment Was Successful.";				
									
									$ret=array('status'=>'OK','Message'=>'');
								}	
							}else
							{
								$Msg = array('status'=>'FAIL','Message'=>'Payment Failed. Funds Transfer Was Not Successful. ERROR: '.strtoupper($transfer_result['Message']));
								
								$ret=array('status'=>'FAIL','Message'=>$Msg);
							}
						}
					}
				}else
				{
					$bal = $rt['message'];
					
					$Msg="Payment was not successful. Paystack balance error: ".strtoupper($bal);
			
					$m = "Payment to the issuer was NOT successful. Paystack balance error: <b>".strtoupper($bal)."</b>";
					
					$ret=array('status'=>'FAIL','Message'=>$m);
				}	
			}								
		}
		
		$Op="PAYMENT TO ISSUER";	
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
		$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,$Op,$_SESSION['LogID']);
		
		echo json_encode($ret);
	}
	
		
	public function index()
	{
		$data['fullname']=''; $data['email']=''; $data['phone']='';
		$data['accountstatus'] = ''; $data['usertype'] = ''; $data['datecreated'] = '';
		
		$data['CreateAccount']='0';
		$data['AddItem']='0'; $data['EditItem']='0'; $data['DeleteItem']='0'; $data['ClearLogFiles']='0';
		$data['ViewLogReports']='0'; $data['ViewReports']='0'; $data['SetParameters']='0';
		
		$data['SetMarketParameters']=''; $data['ViewOrders']=''; $data['ViewPrices']='';
		$data['BuyAndSellToken']=''; $data['RegisterBroker']=''; $data['PublishWork']='';
		$data['RequestListing']='';
		
		if ($_SESSION['email'])
		{
			$data['email']=trim($_SESSION['email']);
						
			#User Info
			if ($_SESSION['fullname']) $data['fullname']=$_SESSION['fullname'];
			if ($_SESSION['accountstatus']) $data['accountstatus'] = $_SESSION['accountstatus'];
			if ($_SESSION['datecreated']) $data['datecreated'] = $_SESSION['datecreated'];
			if ($_SESSION['usertype']) $data['usertype'] = $_SESSION['usertype'];
			if ($_SESSION['phone']) $data['phone']=$_SESSION['phone'];
			
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
			
			$this->load->view('admin/payissuers_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
