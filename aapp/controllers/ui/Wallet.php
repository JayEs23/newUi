<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
date_default_timezone_set('Africa/Lagos');
set_time_limit(0);

include_once('nairaandkobo.php');

class Wallet extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	
	public function GetStatuses()
	{
		$sql="SELECT DISTINCT(trans_status) as trans_status FROM payment_log ORDER BY trans_status";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetStatuses functions
	
	public function GetPayments()
	{
		$startdate=''; $enddate=''; $period=''; $trans_status=''; $email = '';
						
		if ($this->input->post('email')) $email = $this->input->post('email');
		if ($this->input->post('startdate')) $startdate = $this->input->post('startdate');
		if ($this->input->post('enddate')) $enddate = $this->input->post('enddate');
		if ($this->input->post('period')) $period = $this->input->post('period');
		if ($this->input->post('trans_status')) $trans_status = $this->input->post('trans_status');
		
		if (strtolower(trim($period))=='range of dates')
		{
			if ($startdate and $enddate)
			{
				if (trim($trans_status) <> '')
				{
					$qry = "SELECT * FROM payment_log WHERE email = '".$email."' AND (DATE_FORMAT(payment_date,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND (TRIM(trans_status)='".$this->db->escape_str($trans_status)."') ORDER BY payment_date DESC";
				}else
				{
					$qry = "SELECT * FROM payment_log WHERE email = '".$email."' AND (DATE_FORMAT(payment_date,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') ORDER BY payment_date DESC";
				}
			}
		}elseif (strtolower(trim($period))=='today')
		{
			if (trim($trans_status) <> '')
			{
				$qry = "SELECT * FROM payment_log WHERE email = '".$email."' AND (DATE_FORMAT(payment_date,'%Y-%m-%d')='".date('Y-m-d')."') AND (TRIM(trans_status)='".$this->db->escape_str($trans_status)."') ORDER BY payment_date DESC";
			}else
			{
				$qry = "SELECT * FROM payment_log WHERE email = '".$email."' AND (DATE_FORMAT(payment_date,'%Y-%m-%d')='".date('Y-m-d')."') ORDER BY payment_date DESC";
			}			
		}elseif (strtolower(trim($period))=='last week')
		{
			$previous_week = strtotime("-1 week +1 day");
			$start_week = strtotime("last sunday midnight",$previous_week);
			$end_week = strtotime("next saturday",$start_week);
			$startlastweek = date("Y-m-d",$start_week);
			$endlastweek = date("Y-m-d",$end_week);
			
			if (trim($trans_status) <> '')
			{
				$qry = "SELECT * FROM payment_log WHERE email = '".$email."' AND (DATE_FORMAT(payment_date,'%Y-%m-%d') BETWEEN '".$startlastweek."' AND '".$endlastweek."') AND (TRIM(trans_status)='".$this->db->escape_str($trans_status)."') ORDER BY payment_date DESC";
			}else
			{
				$qry = "SELECT * FROM payment_log WHERE email = '".$email."' AND (DATE_FORMAT(payment_date,'%Y-%m-%d') BETWEEN '".$startlastweek."' AND '".$endlastweek."') ORDER BY payment_date DESC";
			}
		}elseif (strtolower(trim($period))=='this week')
		{			
			$startthisweek=date("Y-m-d", strtotime("last week Sunday"));
			$endthisweek=date("Y-m-d");
			
			if (trim($trans_status) <> '')
			{
				$qry = "SELECT * FROM payment_log WHERE email = '".$email."' AND (DATE_FORMAT(payment_date,'%Y-%m-%d') BETWEEN '".$startthisweek."' AND '".$endthisweek."') AND (TRIM(trans_status)='".$this->db->escape_str($trans_status)."') ORDER BY payment_date DESC";
			}else
			{
				$qry = "SELECT * FROM payment_log WHERE email = '".$email."' AND (DATE_FORMAT(payment_date,'%Y-%m-%d') BETWEEN '".$startthisweek."' AND '".$endthisweek."') ORDER BY payment_date DESC";
			}
		}elseif (strtolower(trim($period))=='last month')
		{
			$startmonth=date("Y-m-d", strtotime("first day of previous month"));
			$endmonth=date("Y-m-d", strtotime("last day of previous month"));
			
			if (trim($trans_status) <> '')
			{
				$qry = "SELECT * FROM payment_log WHERE email = '".$email."' AND (DATE_FORMAT(payment_date,'%Y-%m-%d') BETWEEN '".$startmonth."' AND '".$endmonth."') AND (TRIM(trans_status)='".$this->db->escape_str($trans_status)."') ORDER BY payment_date DESC";
			}else
			{
				$qry = "SELECT * FROM payment_log WHERE email = '".$email."' AND (DATE_FORMAT(payment_date,'%Y-%m-%d') BETWEEN '".$startmonth."' AND '".$endmonth."') ORDER BY payment_date DESC";
			}
		}elseif (strtolower(trim($period))=='last 10 days')
		{			
			if (trim($trans_status) <> '')
			{
				$qry = "SELECT * FROM payment_log WHERE email = '".$email."' AND (TRIM(trans_status)='".$this->db->escape_str($trans_status)."') ORDER BY payment_date DESC LIMIT 0,10";
			}else
			{
				$qry = "SELECT * FROM payment_log WHERE email = '".$email."' ORDER BY payment_date DESC LIMIT 0,10";
			}
			//$file = fopen('aaa.txt',"a"); fwrite($file,$qry); fclose($file);
		}

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		$data=array();

		foreach($results as $row):
			$dt='';
								
			if ($row['payment_date']) $dt=date('d M Y @ H:i',strtotime($row['payment_date']));
			
			$tp=array($dt,$row['payment_reference'],strtoupper($row['channel']),'₦'.number_format($row['amount'],2),strtoupper($row['trans_status']));
			
			$data[]=$tp;
		endforeach;

		print_r(json_encode($data));
	}
	
	function CancelTransLog()
	{
		$email=''; $transref=''; $brokername='';
	
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('transref')) $transref = trim($this->input->post('transref'));
		
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$Msg=''; $dt=date('Y-m-d H:i:s');						
		$rw=$this->getdata_model->GetBrokerDetails($email);		
		if ($rw->company) $brokername=trim($rw->company);
				
		$sql = "SELECT * FROM payment_log WHERE (TRIM(email)='".$this->db->escape_str($email)."') AND (TRIM(transref)='".$this->db->escape_str($transref)."')";
				
		$query = $this->db->query($sql);
		
		if ($query->num_rows() == 0 )
		{
			$Msg="Could Not Delete Paystack Transaction Log Record With Id ".$transref.".";			
			$ret=array('Status'=>0,'Message'=>$Msg);			
			$this->getdata_model->LogDetails($brokername,$Msg,$email,$dt,$remote_ip,$remote_host,'FAILED PAYSTACK LOG DELETE',$_SESSION['LogID']);
		}else
		{
			#Delete Log Transaction
			$this->db->trans_start();
			$this->db->where(array('email'=>$email, 'transref'=>$transref));
			$this->db->delete('payment_log');			
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE)
			{
				$Msg="Could Not Delete Paystack Transaction Log Record With Id ".$transref.".";
				$ret=array('Status'=>0,'Message'=>$Msg);	
				$this->getdata_model->LogDetails($brokername,$Msg,$email,$dt,$remote_ip,$remote_host,'FAILED PAYSTACK LOG DELETE',uniqid());
			}else
			{							
				$Msg='Deleting of paystack transaction log with id '.$transref.' was successful';
				
				$this->getdata_model->LogDetails($brokername,$Msg,$email,$dt,$remote_ip,$remote_host,'PAYSTACK LOG DELETED',$_SESSION['LogID']);	
						
				$ret = array('Status'=>1);
			}
		}
		
		echo json_encode($ret);	
    }
	
	
	function LogTrans()
	{
		$amount=''; $email=''; $currency=''; $description=''; $TransRef=''; $txn_ref=''; $brokername=''; $phone=''; $blockchain_address ='';
	
		if ($this->input->post('amount')) $amount = trim($this->input->post('amount'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('description')) $description = trim($this->input->post('description'));		
		if ($this->input->post('TransRef')) $TransRef = trim($this->input->post('TransRef'));
		if ($this->input->post('currency')) $currency = trim($this->input->post('currency'));

		$gateway='Paystack';
		
		if (floatval($amount) > 0) $amount=floatval(str_replace(',','',$amount))/100;
		
		$rw=$this->getdata_model->GetBrokerDetails($email);
		$investorDetails =$this->getdata_model->GetInvestorDetails($email);


		
		if ($rw->company) $brokername=trim($rw->company);
		if ($investorDetails->blockchain_address) $blockchain_address=trim($investorDetails->blockchain_address);
		
		if ($rw->phone) $phone=trim($rw->phone);
		
		$dt=date('Y-m-d H:i');

		$sql = "SELECT * FROM payment_log WHERE (TRIM(email)='".$this->db->escape_str($email)."') AND (TRIM(transref)='".$this->db->escape_str($TransRef)."')";
							
		$query = $this->db->query($sql);
		
		if ($query->num_rows() == 0 )#Insert
		{
			#Log Transaction
			#***************Save Response in payment_log table***********************
			$this->db->trans_start();
														
			$dat=array(
				'payername' 			=> $this->db->escape_str($brokername),
				'phone' 				=> $this->db->escape_str($phone),
				'email' 				=> $this->db->escape_str($email),
				'gateway' 				=> $this->db->escape_str($gateway),
				'transref' 				=> $this->db->escape_str($TransRef),
				'amount' 				=> $this->db->escape_str($amount),
				'currency' 				=> $this->db->escape_str($currency),
				'description' 			=> $this->db->escape_str($description),
				'trans_status'			=> 'Pending',
				'insert_date' 			=> date('Y-m-d H:i:s')
			);
			
			$this->db->insert('payment_log', $dat);		
	
			$this->db->trans_complete();
			
			$nm=$brokername; $Msg='';
			
			if ($this->db->trans_status() === FALSE)
			{					
				$Msg="Could Not Log Payment With Id ".$TransRef.".";
				$ret = 'Could Not Log Payment With Id <b>'.$TransRef.'</b>. Please Restart The Payment Process.';
			}else
			{			
				$Msg="Payment With Id ".$TransRef." Was Logged Successfully.";
					
				$ret ="OK";	
			}
			
			$this->getdata_model->FundWalletOnBlockchain($email,$amount,$blockchain_address,$TransRef);
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
			$this->getdata_model->LogDetails($nm,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'LOGGED WALLET TOP-UP',$_SESSION['LogID']);	
		}else
		{
			$ret ="OK";
		}	
			
		echo $ret;	
	}
	
	public function VerifyTransaction()
	{
		$email=''; $amount=''; $TransRef=''; $payment_reference=''; $SecretKey=''; $VerifyUrl=''; $runmode=''; $url=''; $usertype='';
				
		if ($this->input->post('amount')) $amount = $this->input->post('amount');#in kobo
		if ($this->input->post('email')) $email=$this->input->post('email');
		if ($this->input->post('TransRef')) $TransRef= $this->input->post('TransRef');
		if ($this->input->post('payment_reference')) $payment_reference=$this->input->post('payment_reference');
		if ($this->input->post('usertype')) $usertype=$this->input->post('usertype');
				
		$udt=date('Y-m-d H:i:s');
		
		$gateway='Paystack';
		
		//Get Settings
		$settings=$this->getdata_model->GetParamaters();
		
		
		if ($settings->runmode) $runmode=trim($settings->runmode);
		
		#Get PayStack Settings
		$PayStackSettings = $this->getdata_model->GetPaystackSettings();
		// print_r($PayStackSettings);
		// die;
		if (strtolower(trim($runmode))=='sandbox')
		{
			if ($PayStackSettings->Sandbox_SecretKey) $SecretKey=trim($PayStackSettings->Sandbox_SecretKey);
		}elseif (strtolower(trim($runmode))=='live')
		{
			if ($PayStackSettings->Live_SecretKey) $SecretKey=trim($PayStackSettings->Live_SecretKey);
		}		
		
		if ($PayStackSettings->VerifyUrl) $VerifyUrl=trim($PayStackSettings->VerifyUrl);
				
		if ($VerifyUrl[strlen($VerifyUrl)-1]=='/') 
		{
			$url = $VerifyUrl.$payment_reference;
		}else
		{
			$url = $VerifyUrl.'/'.$payment_reference;
		}
		
		//Verify Transaction
		$result = array();
				
		$ch = curl_init();
		
		curl_setopt_array($ch, array(
			CURLOPT_URL 			=> $url,
			CURLOPT_RETURNTRANSFER 	=> true,
			CURLOPT_SSL_VERIFYPEER 	=> true,
			CURLOPT_SSL_VERIFYHOST 	=> false,
			CURLOPT_HTTPHEADER 		=> ["Authorization: Bearer ".$SecretKey]
		));
				
		$request = curl_exec($ch);
		
		//$httpCode = curl_getinfo($ch);
		
		curl_close($ch);
		
		$result = json_decode($request, true);
		
		//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($result,true)); fclose($file);
		
		$status = false; $message = ''; $data=array(); $authorization=array();
    		
		if ($result)
		{			
			$status=$result['status'];
			$message=$result['message'];
			
			$trans_status=''; $reference=''; $domain=''; $VerifiedAmount='';  $gateway_response=''; 
			$paid_at=''; $created_at=''; $channel=''; $currency=''; $ip=''; $pay_id='';
			
			$authorization_code=''; $card_bin=''; $card_last4digits=''; $exp_month=''; $exp_year=''; 
			$card_type=''; $bank=''; $country_code=''; $receiver_bank_account_number='';
			$receiver_bank='';
			
			if (($status) and (trim(strtolower($message))=='verification successful'))
			{
				$data=$result['data'];   $authorization=$result['data']['authorization'];
				
				$trans_status=$data['status']; //success
				$reference=$data['reference'];
				$fees=floatval($data['fees'])/100;;
				$domain=$data['domain']; //test
				$VerifiedAmount=floatval($data['amount'])/100;
				$gateway_response=$data['gateway_response'];//Successful
				$currency=$data['currency'];
				
				$paid_at=$data['paid_at'];
				if ($paid_at) $paid_at=str_replace('T',' ',substr($paid_at,0,19));
				
				$created_at=$data['created_at'];
				if ($created_at) $created_at=str_replace('T',' ',substr($created_at,0,19));
				
				$channel=$data['channel'];//card/Bank
				$ip=$data['ip_address']; $pay_id=$data['id'];
				
				//authorization Variables
				$authorization_code=$authorization['authorization_code'];
				$card_bin=$authorization['bin'];				
				$card_last4digits=$authorization['last4'];				
				$exp_month=$authorization['exp_month'];				
				$exp_year=$authorization['exp_year'];				
				$card_type=$authorization['card_type'];				
				$bank=$authorization['bank'];				
				$country_code=$authorization['country_code'];				
				$card_brand=$authorization['brand'];				
				$receiver_bank_account_number=$authorization['receiver_bank_account_number'];
				$receiver_bank=$authorization['receiver_bank'];
				
				#***************Update payment_log table***********************	
				$sql="SELECT * FROM payment_log WHERE (TRIM(transref)='".$this->db->escape_str($TransRef)."') AND (TRIM(email)='".$this->db->escape_str($email)."')";			
				
				$query = $this->db->query($sql);
						
				if ( $query->num_rows() > 0 )
				{
					
					$this->db->trans_start();
					
					$dat=array(
						'channel' 						=> $this->db->escape_str($channel),
						'paystack_fees' 				=> $this->db->escape_str($fees),
						'user_ipaddress'				=> $this->db->escape_str($ip),
						'payment_date' 					=> $this->db->escape_str($paid_at),
						'gateway_response' 				=> $this->db->escape_str($gateway_response),
						'trans_status' 					=> $this->db->escape_str($trans_status),
						'payment_reference' 			=> $this->db->escape_str($reference),
						'authorization_code' 			=> $this->db->escape_str($authorization_code),
						'card_bin' 						=> $this->db->escape_str($card_bin),
						'card_last4digits' 				=> $this->db->escape_str($card_last4digits),
						'exp_month' 					=> $this->db->escape_str($exp_month),
						'exp_year' 						=> $this->db->escape_str($exp_year),
						'card_brand' 					=> $this->db->escape_str($card_brand),
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
	
					$array = array('transref' => $TransRef, 'email' => $email);
					
					$this->db->where($array);
					$this->db->update('payment_log', $dat);	
					
					$this->db->trans_complete();
					
					if (trim(strtolower($trans_status)) == "success")
					{
						$ret='OK'; $Msg=''; $cur=''; $user_id='';
						
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
						
						$bal=0;
						
						#Update wallet
						$sql="SELECT * FROM wallets WHERE (TRIM(email)='".$this->db->escape_str($email)."')";			
				
						$query = $this->db->query($sql);
								
						if ( $query->num_rows() > 0 )
						{
							$row = $query->row();			
							
							if ($row->balance) $bal=$row->balance;
							
							$bal=floatval($bal) + floatval($VerifiedAmount);
							
							//Update wallet table
							$dat=array('balance' => $this->db->escape_str($bal));
							
							$this->db->trans_start();
							$this->db->where(array('email' => $email));
							$this->db->update('wallets', $dat);			
							$this->db->trans_complete();
							
							//Update wallet_update field
							$this->db->trans_start();
							$this->db->where(array('email'=>$email, 'transref'=>$TransRef));
							$this->db->update('payment_log', array('wallet_update' => 1));			
							$this->db->trans_complete();
						}else
						{
							$bal=$VerifiedAmount;
							
							//Insert wallet table
							$dat=array(
								'balance' 	=> $this->db->escape_str($bal),
								'email' 	=> $this->db->escape_str($email),
								'uid' 		=> $this->db->escape_str($user_id)
							);					
							
							$this->db->trans_start();
							$this->db->insert('wallets', $dat);			
							$this->db->trans_complete();
							
							//Update wallet_update field
							$this->db->trans_start();
							$this->db->where(array('email'=>$email, 'transref'=>$TransRef));
							$this->db->update('payment_log', array('wallet_update' => 1));			
							$this->db->trans_complete();
						}		
						
						/*if (trim(strtoupper($currency))=='NGN') $cur='&#8358;';
						
						$img=base_url()."images/logo.png";
						$from='support@naijaartmart.com';
						$to=$email;
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
									
									Your payment of <b>'.$currency.' '.$VerifiedAmount.' ('.strtolower(str_replace('.','',MoneyInWords(str_replace(',','',$VerifiedAmount)))).')</b> to <b><i>Naija Art Mart</i></b> with transaction Id <b>'.$TransRef.'</b>, to fund your wallet via <b>'.$gateway.'</b> was <b>successful</b>.<br><br>
							
							Best Regards
							
							Naija Art Mart
							</body>
							</html>';
												
						$altmessage = '
							Dear Investor,
									
							Your payment of '.$currency.' '.$VerifiedAmount.' ('.strtolower(str_replace('.','',MoneyInWords(str_replace(',','',$VerifiedAmount)))).') to Naija Art Mart with transaction Id '.$TransRef.', to fund your wallet via '.$gateway.' was successful.
																																						
							Best Regards
							
							Naija Art Mart';												
						
						$v=$this->getdata_model->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,'');*/
						
						$ret = array('status'=>'OK','balance'=>$bal);
						
						$remote_ip=$_SERVER['REMOTE_ADDR'];
						$remote_host=gethostbyaddr($remote_ip);
					
						//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
						$this->getdata_model->LogDetails($user_name,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'FUNDED WALLET',$_SESSION['LogID']);	
					}else
					{
						$this->db->trans_start();
					
						$dat=array('trans_status' => 'Failed','update_date'  => $this->db->escape_str($udt));
		
						$array = array('transref' => $TransRef, 'email' => $email);
						$this->db->where($array);
						$this->db->update('payment_log', $dat);	
						
						$this->db->trans_complete();
																		
						$m='Transaction Was Not Successful. => '.$m;
						
						$ret = array('status'=>'Fail','messages'=>$m);
					}			
				}	
			}else
			{
				$this->db->trans_start();
					
				$dat=array('trans_status' => 'Failed','update_date'  => $this->db->escape_str($udt));

				$array = array('transref' => $TransRef, 'email' => $email);
				$this->db->where($array);
				$this->db->update('payment_log', $dat);	
				
				$this->db->trans_complete();
				
				$m='Transaction Was Not Successful. => '.$m;
				$ret = array('status'=>'Fail','messages'=>$m);
			}		
		}else
		{
			$file = fopen('curl_error.txt',"a"); fwrite($file, "WALLET FUNDING CURL ERROR FAILED:\r\n".$curlerror); fclose($file);
			
			$m = $curlerror;
			
			$ret = array('status'=>'Fail','messages'=>$m);
		}
		
		echo json_encode($ret);
	}
	
	function LoadWalletBalance()
	{
		$email=''; $bal=0;
				
		if ($this->input->post('email')) $email=$this->input->post('email');
		
		$sql="SELECT * FROM wallets WHERE (TRIM(email)='".$this->db->escape_str($email)."')";			
				
		$query = $this->db->query($sql);
				
		if ( $query->num_rows() > 0 )
		{
			$row = $query->row();			
			
			if ($row->balance) $bal=$row->balance;
		}
		
		echo $bal;
	}
	
	
	public function index()
	{
		$data['lastname']=''; $data['firstname']=''; $data['email']=''; $data['phone']=''; $data['pix']='';
		$data['accountstatus'] = ''; $data['usertype'] = ''; $data['pix'] = ''; $_SESSION['company']='';
		
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
			
			if ((trim(strtolower($data['usertype']))=='broker') or (trim(strtolower($data['usertype']))=='investor'))
			{
				$data['balance']=$this->getdata_model->GetWalletBalance($data['email']);		
							
				$this->load->view('ui/wallet_view',$data);	
			}else
			{
				redirect('ui/Dashboard');
			}			
		}else 
		{
			$this->getdata_model->GoToLogin('');
		}
	}
}
