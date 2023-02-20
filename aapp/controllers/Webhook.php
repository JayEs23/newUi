<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
date_default_timezone_set('Africa/Lagos');
set_time_limit(0);

include_once('ui/nairaandkobo.php');

class Webhook extends CI_Controller {
	function __construct() 
	{
		parent::__construct();				
	}
	
	function PaystackTransfers()
	{
		$SecretKey='';
		$logdate=date('Y-m-d H:i:s');
		$today=date('Y-m-d');
		$valid_ips=array('52.31.139.75', '52.49.173.169', '52.214.14.220');
		
		$remote_ip=$_SERVER['REMOTE_ADDR'];

		$input = @file_get_contents("php://input");// Retrieve the request's body
		$result = json_decode($input);		
		$result = json_decode(json_encode($result), true);
		
		$settings=$this->getdata_model->GetParamaters();
		
		if ($settings->runmode) $runmode=trim($settings->runmode);
		
		$PayStackSettings = $this->getdata_model->GetPaystackSettings();
		
		if (strtolower(trim($runmode))=='sandbox')
		{
			if ($PayStackSettings->Sandbox_SecretKey) $SecretKey=trim($PayStackSettings->Sandbox_SecretKey);
		}elseif (strtolower(trim($runmode))=='live')
		{
			if ($PayStackSettings->Live_SecretKey) $SecretKey=trim($PayStackSettings->Live_SecretKey);
		}
		
		// validate event do all at once to avoid timing attack
		if($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, $SecretKey))
		{
			$file = fopen('error_webhook.txt',"a"); fwrite($file,date("d M Y H:i")." => Wrong Signature: ".$_SERVER['HTTP_X_PAYSTACK_SIGNATURE']."\r\n"); fclose($file);
		}else
		{
			if (in_array($remote_ip,$valid_ips))
			{
				$event=''; $domain=''; $status=''; $reference=''; $amount=''; $currency='';
				$paystack_ip_address=''; $created_at=''; $transref=''; $usertype='';
				
				$event=$result['event'];
				$data=$result['data'];
				
				if (isset($data['domain'])) $domain = $data['domain'];
				if (isset($data['status'])) $status = $data['status'];
				if (isset($data['reference'])) $reference = $data['reference'];
				if (isset($data['amount'])) $amount = floatval($data['amount'])/100;
				if (isset($data['currency'])) $currency = $data['currency'];
				if (isset($data['created_at']))
				{
					$created_at = $data['created_at'];
					$created_at=str_replace('T',' ',substr($created_at,0,19));
				}				
				
				$paystack_ip_address=$remote_ip;
				
				$udt=date('Y-m-d H:i:s');
				
				if (trim(strtolower($event))=='charge.success')
				{
					$message=''; $gateway_response=''; $paid_at=''; $channel=''; $user_ip_address='';
					$fees=''; $bin=''; $last4=''; $card_type=''; $bank=''; $country_code=''; $brand='';
					$customer_email=''; $authorization_code=''; $exp_month=''; $exp_year='';
					$receiver_bank_account_number=''; $receiver_bank=''; $wallet_update='0';
					
					if (isset($data['message'])) $message = $data['message'];
					if (isset($data['gateway_response'])) $gateway_response = $data['gateway_response'];
										
					if (isset($data['paid_at']))
					{
						$paid_at = $data['paid_at'];
						$paid_at=str_replace('T',' ',substr($paid_at,0,19));
					}
					
					if (isset($data['channel'])) $channel = $data['channel'];
					if (isset($data['ip_address'])) $user_ip_address = $data['ip_address'];
					if (isset($data['fees'])) $fees = floatval($data['fees'])/100;
					if (isset($data['authorization']['bin'])) $bin = $data['authorization']['bin'];
					if (isset($data['authorization']['last4'])) $last4 = $data['authorization']['last4'];
					if (isset($data['authorization']['card_type'])) $card_type = $data['authorization']['card_type'];
					if (isset($data['authorization']['bank'])) $bank = $data['authorization']['bank'];
					if (isset($data['authorization']['country_code'])) $country_code = $data['authorization']['country_code'];
					if (isset($data['authorization']['brand'])) $brand = $data['authorization']['brand'];
					if (isset($data['authorization']['authorization_code'])) $authorization_code = $data['authorization']['authorization_code'];
					if (isset($data['authorization']['exp_month'])) $exp_month = $data['authorization']['exp_month'];
					if (isset($data['authorization']['exp_year'])) $exp_year = $data['authorization']['exp_year'];
					if (isset($data['authorization']['receiver_bank_account_number'])) $receiver_bank_account_number = $data['authorization']['receiver_bank_account_number'];
					if (isset($data['authorization']['receiver_bank'])) $receiver_bank = $data['authorization']['receiver_bank'];
					
					if (isset($data['customer']['email'])) $customer_email = $data['customer']['email'];
					if (isset($data['metadata']['custom_fields'][0]['trans_ref']))
					{
						$transref = $data['metadata']['custom_fields'][0]['trans_ref'];
					}
					
					if (isset($data['metadata']['custom_fields'][0]['usertype']))
					{
						$usertype = $data['metadata']['custom_fields'][0]['usertype'];
					}
					
					
					//Insert webhook record - charge.success
					$sql="SELECT * FROM webhook_log WHERE (TRIM(event)='".$this->db->escape_str($event)."') AND (TRIM(domain)='".$this->db->escape_str($domain)."') AND (amount=".$this->db->escape_str($amount).") AND (TRIM(reference)='".$this->db->escape_str($reference)."') AND (TRIM(customer_email)='".$this->db->escape_str($customer_email)."')";
						
					$query=$this->db->query($sql);
					
					if ($query->num_rows() == 0)
					{
						$this->db->trans_start();	
							
						$dat=array(
							'event' 				=> $this->db->escape_str($event),
							'domain' 				=> $this->db->escape_str($domain),
							'status' 				=> $this->db->escape_str($status),
							'transref' 				=> $this->db->escape_str($transref),
							'reference' 			=> $this->db->escape_str($reference),
							'amount' 				=> $this->db->escape_str($amount),
							'message' 				=> $this->db->escape_str($message),
							'gateway_response'		=> $this->db->escape_str($gateway_response),
							'paid_at' 				=> $this->db->escape_str($paid_at),
							'channel' 				=> $this->db->escape_str($channel),
							'currency'				=> $this->db->escape_str($currency),
							'user_ip_address'		=> $this->db->escape_str($user_ip_address),
							'paystack_ip_address'	=> $this->db->escape_str($paystack_ip_address),
							'fees'					=> $this->db->escape_str($fees),
							'bin'					=> $this->db->escape_str($bin),
							'last4'					=> $this->db->escape_str($last4),
							'card_type'				=> $this->db->escape_str($card_type),
							'bank'					=> $this->db->escape_str($bank),
							'country_code'			=> $this->db->escape_str($country_code),
							'brand'					=> $this->db->escape_str($brand),
							'customer_email'		=> $this->db->escape_str($customer_email),
							'created_at'			=> $this->db->escape_str($created_at)
						);
			
						$this->db->insert('webhook_log', $dat);	
							
						$this->db->trans_complete();
					}	
					
					//Check if payment_log has been updated
					$sql="SELECT * FROM payment_log WHERE (TRIM(transref)='".$this->db->escape_str($transref)."') AND (TRIM(email)='".$this->db->escape_str($customer_email)."') AND (TRIM(trans_status) <> 'success') AND (amount=".$this->db->escape_str($amount).")";
			

					$query=$this->db->query($sql);
					
					if ($query->num_rows() > 0)//Update wallets and payment_log tables
					{
						$row = $query->row();			
						if (intval($row->wallet_update) == 1) $wallet_update=1;

						$this->db->trans_start();
					
						$dat=array(
							'channel' 						=> $this->db->escape_str($channel),
							'paystack_fees' 				=> $this->db->escape_str($fees),
							'user_ipaddress'				=> $this->db->escape_str($user_ip_address),
							'payment_date' 					=> $this->db->escape_str($paid_at),
							'gateway_response' 				=> $this->db->escape_str($gateway_response),
							'trans_status' 					=> $this->db->escape_str($status),
							'payment_reference' 			=> $this->db->escape_str($reference),
							'authorization_code' 			=> $this->db->escape_str($authorization_code),
							'card_bin' 						=> $this->db->escape_str($bin),
							'card_last4digits' 				=> $this->db->escape_str($last4),
							'exp_month' 					=> $this->db->escape_str($exp_month),
							'exp_year' 						=> $this->db->escape_str($exp_year),
							'card_brand' 					=> $this->db->escape_str($brand),
							'card_type' 					=> $this->db->escape_str($card_type),
							'bank' 							=> $this->db->escape_str($bank),
							'country_code' 					=> $this->db->escape_str($country_code),
							'receiver_bank_account_number' 	=> $this->db->escape_str($receiver_bank_account_number),
							'receiver_bank' 				=> $this->db->escape_str($receiver_bank),
							'domain' 						=> $this->db->escape_str($domain),
							'created_at' 					=> $this->db->escape_str($created_at),
							'paid_at' 						=> $this->db->escape_str($paid_at),
							'update_date' 					=> $this->db->escape_str($udt)
						);
		
						$array = array('transref'=>$transref, 'email'=>$customer_email);
						
						$this->db->where($array);
						$this->db->update('payment_log', $dat);	
						
						$this->db->trans_complete();
						
						if (trim(strtolower($status)) == "success")
						{
							$Msg=''; $cur=''; $user_id='';
							
							if (trim(strtolower($usertype))=='broker')
							{
								$Msg = "Broker with email ".$email." successfully funded his/her wallet.";
								
								$rw=$this->getdata_model->GetBrokerDetails($email);
			
								if ($rw->company) $user_name=trim($rw->company);
								if ($rw->broker_id) $user_id=trim($rw->broker_id);
							}elseif (trim(strtolower($usertype))=='investor')
							{
								$Msg = "Investor with email ".$email." successfully funded his/her wallet.";
								
								$rw=$this->getdata_model->GetInvestorDetails($email);
			
								if ($rw->user_name) $user_name=trim($rw->user_name);
								if ($rw->uid) $user_id=trim($rw->uid);
							}
							
							//if (intval($wallet_update) <> 1)
							//{
								$bal=0;
								
								#Update wallet
								$sql="SELECT * FROM wallets WHERE (TRIM(email)='".$this->db->escape_str($customer_email)."')";			
						
								$query = $this->db->query($sql);
		
								if ( $query->num_rows() > 0 )
								{
									$row = $query->row();			
									
									if ($row->balance) $bal=$row->balance;
									
									$bal=floatval($bal) + floatval($amount);
									
									//Update wallet table
									$dat=array('balance' => $this->db->escape_str($bal));
									
									$this->db->trans_start();
									$this->db->where(array('email' => $customer_email));
									$this->db->update('wallets', $dat);			
									$this->db->trans_complete();
								}else
								{
									$bal=$amount;
									
									//Insert wallet table
									$dat=array(
										'balance' 	=> $this->db->escape_str($bal),
										'email' 	=> $this->db->escape_str($customer_email),
										'uid' 		=> $this->db->escape_str($user_id)
									);					
									
									$this->db->trans_start();
									$this->db->insert('wallets', $dat);			
									$this->db->trans_complete();
								}
								
								
								if (trim(strtoupper($currency))=='NGN') $cur='&#8358;';
								
								$img=base_url()."images/logo.png";
								$from='support@naijaartmart.com';
								$to=$customer_email;
								$subject='You Have Funded Your Wallet';
								$Cc='';
								
								$message = '
									<html>
									<head>
									<meta charset="utf-8">
									<title>Naija Art Mart | Funded Wallet</title>
									</head>
									<body>
											<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
																		
											Dear Investor,<br></p>
											
											Your payment of <b>'.$currency.' '.$amount.' ('.strtolower(str_replace('.','',MoneyInWords(str_replace(',','',$amount)))).')</b> to <b><i>Naija Art Mart</i></b> with transaction Id <b>'.$transref.'</b>, to fund your wallet via <b>'.$gateway.'</b> was <b>successful</b>.<br><br>
									
									Best Regards
									
									Naija Art Mart
									</body>
									</html>';
														
								$altmessage = '
									Dear Investor,
											
									Your payment of '.$currency.' '.$amount.' ('.strtolower(str_replace('.','',MoneyInWords(str_replace(',','',$amount)))).') to Naija Art Mart with transaction Id '.$transref.', to fund your wallet via '.$gateway.' was successful.
																																								
									Best Regards
									
									Naija Art Mart';												
								
								$v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,'');
								
								$remote_ip=$_SERVER['REMOTE_ADDR'];
								$remote_host=gethostbyaddr($remote_ip);
							
								//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
								$this->getdata_model->LogDetails($user_name,$Msg,$customer_email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'FUNDED WALLET',$_SESSION['LogID']);
							//}
						}else
						{
							$this->db->trans_start();
						
							$dat=array('trans_status' => 'Failed','update_date'  => $this->db->escape_str($udt));
			
							$array = array('transref' => $transref, 'email' => $customer_email);
							$this->db->where($array);
							$this->db->update('payment_log', $dat);	
							
							$this->db->trans_complete();							
						}
					}
								
				}elseif (trim(strtolower($event))=='transfer.success')
				{//event,domain,status,reference,amount,currency,paystack_ip_address,reason,transfer_code,transferred_at,recipient_code,account_number,bank_code,bank_name,created_at,updated_at
					$reason=''; $transfer_code=''; $transferred_at=''; $recipient_code=''; $account_number=''; $bank_code=''; $bank_name=''; $updated_at='';
				
					if (isset($data['reason'])) $reason = $data['reason'];
					if (isset($data['transfer_code'])) $transfer_code = $data['transfer_code'];
					
					if (isset($data['transferred_at']))
					{
						$transferred_at = $data['transferred_at'];
						$transferred_at=str_replace('T',' ',substr($transferred_at,0,19));
					}
					
					if (isset($data['recipient']['recipient_code'])) $recipient_code = $data['recipient']['recipient_code'];
					if (isset($data['recipient']['details']['account_number'])) $account_number = $data['recipient']['details']['account_number'];
					if (isset($data['recipient']['details']['bank_code'])) $bank_code = $data['recipient']['details']['bank_code'];
					if (isset($data['recipient']['details']['bank_name'])) $bank_name = $data['recipient']['details']['bank_name'];
					
					if (isset($data['updated_at']))
					{
						$updated_at = $data['updated_at'];
						$updated_at=str_replace('T',' ',substr($updated_at,0,19));
					}
					
					//Insert webhook record - transfer.success
					$sql="SELECT * FROM webhook_log WHERE (TRIM(event)='".$this->db->escape_str($event)."') AND (TRIM(domain)='".$this->db->escape_str($domain)."') AND (amount=".$this->db->escape_str($amount).") AND (TRIM(reference)='".$this->db->escape_str($reference)."') AND (TRIM(recipient_code)='".$this->db->escape_str($recipient_code)."') AND (TRIM(transfer_code)='".$this->db->escape_str($transfer_code)."')";
						
					$query=$this->db->query($sql);
					
					if ($query->num_rows() == 0)
					{
						$this->db->trans_start();	
							
						$dat=array(
							'event' 				=> $this->db->escape_str($event),
							'domain' 				=> $this->db->escape_str($domain),
							'status' 				=> $this->db->escape_str($status),
							'reference' 			=> $this->db->escape_str($reference),
							'amount' 				=> $this->db->escape_str($amount),
							'currency'				=> $this->db->escape_str($currency),
							'paystack_ip_address'	=> $this->db->escape_str($paystack_ip_address),
							'reason' 				=> $this->db->escape_str($reason),
							'transfer_code'			=> $this->db->escape_str($transfer_code),
							'transferred_at' 		=> $this->db->escape_str($transferred_at),
							'recipient_code' 		=> $this->db->escape_str($recipient_code),							
							'account_number'		=> $this->db->escape_str($account_number),							
							'bank_code'				=> $this->db->escape_str($bank_code),							
							'bank_name'				=> $this->db->escape_str($bank_name),
							'created_at'			=> $this->db->escape_str($created_at),
							'updated_at'			=> $this->db->escape_str($updated_at)
						);
			
						$this->db->insert('webhook_log', $dat);	
							
						$this->db->trans_complete();
					}
					
					//Update Tables
				}elseif (trim(strtolower($event))=='transfer.failed')
				{//event,domain,status,amount,currency,paystack_ip_address,reason,transfer_code,transferred_at,recipient_code,account_number,account_name,bank_code,bank_name,created_at
				
					$reason=''; $transfer_code=''; $transferred_at=''; $recipient_code=''; $account_number=''; $account_name=''; $bank_code=''; $bank_name='';
				
					if (isset($data['reason'])) $reason = $data['reason'];
					if (isset($data['transfer_code'])) $transfer_code = $data['transfer_code'];
					
					if (isset($data['transferred_at']))
					{
						$transferred_at = $data['transferred_at'];
						$transferred_at=str_replace('T',' ',substr($transferred_at,0,19));
					}
					
					if (isset($data['recipient']['recipient_code'])) $recipient_code = $data['recipient']['recipient_code'];
					if (isset($data['recipient']['details']['account_number'])) $account_number = $data['recipient']['details']['account_number'];
					if (isset($data['recipient']['details']['account_name'])) $account_name = $data['recipient']['details']['account_name'];
					if (isset($data['recipient']['details']['bank_code'])) $bank_code = $data['recipient']['details']['bank_code'];
					if (isset($data['recipient']['details']['bank_name'])) $bank_name = $data['recipient']['details']['bank_name'];
					
					
					//Insert webhook record - transfer.failed
					$sql="SELECT * FROM webhook_log WHERE (TRIM(event)='".$this->db->escape_str($event)."') AND (TRIM(domain)='".$this->db->escape_str($domain)."') AND (amount=".$this->db->escape_str($amount).") AND (TRIM(recipient_code)='".$this->db->escape_str($recipient_code)."') AND (TRIM(transfer_code)='".$this->db->escape_str($transfer_code)."')";
						
					$query=$this->db->query($sql);
					
					if ($query->num_rows() == 0)
					{
						$this->db->trans_start();	
							
						$dat=array(
							'event' 				=> $this->db->escape_str($event),
							'domain' 				=> $this->db->escape_str($domain),
							'status' 				=> $this->db->escape_str($status),
							'amount' 				=> $this->db->escape_str($amount),
							'currency'				=> $this->db->escape_str($currency),
							'paystack_ip_address'	=> $this->db->escape_str($paystack_ip_address),
							'reason' 				=> $this->db->escape_str($reason),
							'transfer_code'			=> $this->db->escape_str($transfer_code),
							'transferred_at' 		=> $this->db->escape_str($transferred_at),
							'recipient_code' 		=> $this->db->escape_str($recipient_code),							
							'account_number'		=> $this->db->escape_str($account_number),
							'account_name'			=> $this->db->escape_str($account_name),
							'bank_code'				=> $this->db->escape_str($bank_code),							
							'bank_name'				=> $this->db->escape_str($bank_name),
							'created_at'			=> $this->db->escape_str($created_at)
						);
			
						$this->db->insert('webhook_log', $dat);	
							
						$this->db->trans_complete();
					}
				}elseif (trim(strtolower($event))=='transfer.reversed')
				{//event,domain,status,reference,amount,currency,paystack_ip_address,reason,transfer_code,transferred_at,recipient_code,account_number,account_name,bank_code,bank_name,provider,session_id,failures,created_at,updated_at

					$reason=''; $transfer_code=''; $transferred_at=''; $updated_at=''; $recipient_code='';
					$recipient_email=''; $recipient_name=''; $account_number=''; $account_name=''; 
					$bank_code=''; $bank_name=''; $provider=''; $session_id=''; $failures='';
				
					if (isset($data['reason'])) $reason = $data['reason'];
					if (isset($data['transfer_code'])) $transfer_code = $data['transfer_code'];					
					if (isset($data['reference'])) $reference = $data['reference'];
					
					if (isset($data['transferred_at']))
					{
						$transferred_at = $data['transferred_at'];
						$transferred_at=str_replace('T',' ',substr($transferred_at,0,19));
					}
					
					if (isset($data['updated_at']))
					{
						$updated_at = $data['updated_at'];
						$updated_at=str_replace('T',' ',substr($updated_at,0,19));
					}
					
					if (isset($data['recipient']['recipient_code'])) $recipient_code = $data['recipient']['recipient_code'];					
					if (isset($data['recipient']['email'])) $recipient_email = $data['recipient']['email'];
					if (isset($data['recipient']['name'])) $recipient_name = $data['recipient']['name'];					
					if (isset($data['recipient']['details']['account_number'])) $account_number = $data['recipient']['details']['account_number'];
					if (isset($data['recipient']['details']['account_name'])) $account_name = $data['recipient']['details']['account_name'];
					if (isset($data['recipient']['details']['bank_code'])) $bank_code = $data['recipient']['details']['bank_code'];
					if (isset($data['recipient']['details']['bank_name'])) $bank_name = $data['recipient']['details']['bank_name'];					
					if (isset($data['session']['provider'])) $provider = $data['session']['provider'];
					if (isset($data['session']['id'])) $session_id = $data['recipient']['id'];
					if (isset($data['failures'])) $failures = $data['failures'];					
					
					//Insert webhook record - transfer.failed
					$sql="SELECT * FROM webhook_log WHERE (TRIM(event)='".$this->db->escape_str($event)."') AND (TRIM(domain)='".$this->db->escape_str($domain)."') AND (amount=".$this->db->escape_str($amount).") AND (TRIM(recipient_code)='".$this->db->escape_str($recipient_code)."') AND (TRIM(transfer_code)='".$this->db->escape_str($transfer_code)."') AND (TRIM(reference)='".$this->db->escape_str($reference)."')";
						
					$query=$this->db->query($sql);
					
					if ($query->num_rows() == 0)
					{
						$this->db->trans_start();	
						
						$dat=array(
							'event' 				=> $this->db->escape_str($event),
							'domain' 				=> $this->db->escape_str($domain),
							'status' 				=> $this->db->escape_str($status),
							'reference' 			=> $this->db->escape_str($reference),
							'amount' 				=> $this->db->escape_str($amount),
							'currency'				=> $this->db->escape_str($currency),
							'paystack_ip_address'	=> $this->db->escape_str($paystack_ip_address),
							'reason' 				=> $this->db->escape_str($reason),
							'transfer_code'			=> $this->db->escape_str($transfer_code),
							'transferred_at' 		=> $this->db->escape_str($transferred_at),
							'recipient_code' 		=> $this->db->escape_str($recipient_code),
							'recipient_email' 		=> $this->db->escape_str($recipient_email),
							'recipient_name' 		=> $this->db->escape_str($recipient_name),
							'account_number'		=> $this->db->escape_str($account_number),
							'account_name'			=> $this->db->escape_str($account_name),
							'bank_code'				=> $this->db->escape_str($bank_code),							
							'bank_name'				=> $this->db->escape_str($bank_name),
							'provider'				=> $this->db->escape_str($provider),
							'session_id'			=> $this->db->escape_str($session_id),
							'failures'				=> $this->db->escape_str($failures),
							'updated_at'			=> $this->db->escape_str($updated_at),
							'created_at'			=> $this->db->escape_str($created_at)
						);
			
						$this->db->insert('webhook_log', $dat);	
							
						$this->db->trans_complete();
						
						//Update tables
					}
				}
				
				//$file = fopen('event_webhook.txt',"a"); fwrite($file,print_r($result,true)."\r\n"); fclose($file);	
			}else
			{
				$file = fopen('error_webhook.txt',"a"); fwrite($file,date("d M Y H:i")." => Unknown IP: ".$remote_ip."\r\n"); fclose($file);
			}	
		}
		
		http_response_code(200);
	}
	
	
	public function index()
	{
		#$this->load->view('home_view');
	}
}
