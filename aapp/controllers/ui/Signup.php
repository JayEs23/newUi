<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	
	function RegisterInvestor()
	{
		// print_r($this->input); die();
		$usertype=''; $name=''; $email=''; $pwd=''; $phone=''; $uid=''; $uid=''; $rows=array();
		$$date_created='';
		
		if ($this->input->post('usertype')) $usertype = trim($this->input->post('usertype'));
		if ($this->input->post('name')) $name = trim($this->input->post('name'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('pwd')) $pwd = $this->input->post('pwd');		
		if ($this->input->post('phone')) $phone = trim($this->input->post('phone'));
				
		//Check if record exists
		$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		$query = $this->db->query($sql);
		
		$dat=array();
					
		if ($query->num_rows() > 0 )
		{
			$rows =array(
				'status' => 'Registration Was Not Successful. Email <b>'.$email.'</b> exists in the database.',
				'Flag'=>'FAIL',
				'email' => $email
			);
		}else
		{
			$date_created = date('Y-m-d H:i:s');
			$uid = $this->getdata_model->GetId('investors','uid');
			$activationCode = sha1($email);					
			$activationurl = base_url()."Creg/Icf/".$activationCode;
			
			$dat=array(
				'user_name' 		=> $this->db->escape_str($name),
				'email' 			=> $this->db->escape_str($email),					
				'phone' 			=> $this->db->escape_str($phone),
				'pwd' 				=> $this->db->escape_str($pwd),			
				'uid' 				=> $this->db->escape_str($uid),
				'accountstatus' 	=> 0,						
				'date_created' 		=>  $date_created
			);
			
			$this->db->trans_start();							
			$this->db->insert('investors', $dat);				
			$this->db->trans_complete();
			
			//For Dual User - Investor/Issuer
			if (strtolower($usertype) == 'both')
			{
				$uid = $this->getdata_model->GetId('issuers','uid');
				
				$dat=array(
					'uid' 		=> $this->db->escape_str($uid),
					'user_name' 		=> $this->db->escape_str($name),					
					'email' 			=> $this->db->escape_str($email),
					'phone' 			=> $this->db->escape_str($phone),
					'pwd' 				=> $this->db->escape_str($pwd),
					'accountstatus' 	=> 0,						
					'date_created' 		=> $date_created 
				);
				
				$this->db->trans_start();							
				$this->db->insert('issuers', $dat);				
				$this->db->trans_complete();
			}			
			
			$Msg='';
			
			if ($this->db->trans_status() === FALSE)
			{
				if (strtolower($usertype) == 'investor')
				{
					$Msg=$name." attempted registration as an investor with email '".$email."' but failed.";
									
					$rows =array(
						'status' => "Registration Was Not Successful.",
						'Flag'=>'FAIL',
						'email' => $email
					);	
				}elseif (strtolower($usertype) == 'both')
				{
					$Msg=$name." attempted registration as an investor/issuer with email '".$email."' but failed.";
									
					$rows =array(
						'status' => "Registration Was Not Successful.",
						'Flag'=>'FAIL',
						'email' => $email
					);	

				}				
			}else
			{
				$Msg="Registration was successful.";				
				
				//Send Email
				$from='support@naijaartmart.com';
				$subject='Verify Your Email Address';
				$to=$email;
				$Cc='';
								
				$img="https://www.naijaartmart.com/images/emaillogo.png";
									
				//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
				
				$custname='';
				
				if (strtolower($usertype) == 'investor')
				{
					$custname='Investor';
				}elseif (strtolower($usertype) == 'both')
				{
					$custname='Investor/Issuer';
				}
				
				$message = '
					<html>
					<head>
					<meta charset="utf-8">
					<title>Naija Art Mart | User Registration</title>
					</head>
					<body>								
							<p><img src="'.$img.'" alt="Naija Art Mart" title="Naija Art Mart" /></p>
													
							Dear '.$custname.',<br><br>
							
							An account has been created for you on Naija Art Mart platform. Your login email is <b>'.$email.'</b>.
														
							<br><br>After activating this account as directed below, sign in and update your profile by supplying your bank account and other details. Please note that you will not be able to participate in any commercial activity on the Naija Art Mart platform if your bank account details are not updated in your profile.
							
							<br><br>For full access to your account on Naija Art Mart platform, you will need to activate your account. To do so, click on the link below or copy and paste it in your browser. Please note that activation is a one time action:
									
							<br><br><a href="'.$activationurl.'">Click Here To Activate Your Naija Art Mart Account<a/>					
							
																																									
							<p>Best Regards</p>
							Naija Art Mart
					</body>
					</html>';
					
				$altmessage = '
					Dear '.$custname.',
							
					An account has been created for you on Naija Art Mart platform. Your login email is '.$email.'.
					
					After activating this account as directed below, sign in and update your profile by supplying your bank account and other details. Please note that you will not be able to participate in any commercial activity on the Naija Art Mart platform if your bank account details are not updated in your profile.
					
					For full access to your account on Naija Art Mart platform, you will need to activate your account. To do so, click on the link below or copy and paste it in your browser. Please note that activation is a one time action: '.$activationurl.'
																																				
					Best Regards
					
					Naija Art Mart';
				
				if ($to) $v=$this->getdata_model->SendBlueMail($from,$to,$subject,$Cc,$message,$altmessage,$custname);				
							
				if (strtoupper(trim($v)) <> 'OK')
				{
					$rows =array(
						'status' => "Registration was Not successful.<br><br><b>".$ret.'<br>',
						'Flag'=>'FAIL',
						'email' => $email
						);
					
					#Delete Entry From investors Table
					$this->db->trans_start();
					$this->db->delete('investors', array('email' => $this->db->escape_str($email))); 				
					$this->db->trans_complete();
					
					if (strtolower($usertype) == 'both')
					{
						$this->db->trans_start();
						$this->db->delete('issuers', array('email' => $this->db->escape_str($email))); 				
						$this->db->trans_complete();
					}					
				}else
				{
					//temp_users
					$sql = "SELECT * FROM temp_users WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
					$query = $this->db->query($sql);
								
					if ($query->num_rows() > 0 )
					{
						$this->db->trans_start();									
						$this->db->where('email', $email);
						$this->db->delete('temp_users');					
						$this->db->trans_complete();
					}
					
					$exp = date('Y-m-d H:i:s', strtotime($date_created . ' +1 day'));
					
					$this->db->trans_start();
				
					if (strtolower($usertype) == 'investor')
					{
						$dat=array(
							'email' 				=> $this->db->escape_str($email),
							'fullname' 				=> $this->db->escape_str($name),
							'usertype' 				=> $this->db->escape_str('Investor'),
							'phone' 				=> $this->db->escape_str($phone),
							'pwd' 					=> $this->db->escape_str($pwd),
							'date_created' 			=> $this->db->escape_str($date_created),				
							'expire' 				=> $exp,
							'tables' 				=> 'investors'
						);	
					}elseif (strtolower($usertype) == 'both')
					{
						$dat=array(
							'email' 				=> $this->db->escape_str($email),
							'fullname' 				=> $this->db->escape_str($name),
							'usertype' 				=> 'Investor/Issuer',
							'phone' 				=> $this->db->escape_str($phone),
							'pwd' 					=> $this->db->escape_str($pwd),
							'date_created' 			=> $this->db->escape_str($date_created),				
							'expire' 				=>$exp,
							'tables' 				=> 'investors,issuers'
						);	
					}					
						
					$this->db->insert('temp_users', $dat);
					
					$this->db->trans_complete();
					
										
					$rows =array(
						'status' => "Registration was successful but the account has not been activated. An email has been sent to <b>".$email."</b>. Click on the link in the email to activate the account.",
						'Flag'=>'OK',
						'email' => $email
						);
				}
			}
			
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			if (strtolower($usertype) == 'investor')
			{
				//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
				$this->getdata_model->LogDetails($nm,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'REGISTERED INVESTOR','');
			}elseif (strtolower($usertype) == 'both')
			{				
				$this->getdata_model->LogDetails($nm,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'REGISTERED INVESTOR/ISSUER','');
			}
					
		}
		
		echo json_encode($rows);
	}
	
	function RegisterIssuer()
	{
		$user_name=''; $email=''; $pwd=''; $phone=''; $uid=''; $rows=array();
		$$date_created='';
		
		if ($this->input->post('user_name')) $user_name = trim($this->input->post('user_name'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('pwd')) $pwd = $this->input->post('pwd');		
		if ($this->input->post('phone')) $phone = trim($this->input->post('phone'));
				
		//Check if record exists
		$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		$query = $this->db->query($sql);
		
		$dat=array();
					
		if ($query->num_rows() > 0 )
		{
			$rows =array(
				'status' => 'Registration Was Not Successful. Email <b>'.$email.'</b> exists in the database.',
				'Flag'=>'FAIL',
				'email' => $email
			);
		}else
		{
			$date_created = date('Y-m-d H:i:s');
			$uid = $this->getdata_model->GetId('issuers','uid');
			$activationCode = sha1($email);					
			$activationurl = base_url()."Creg/Isf/".$activationCode;
			
			$dat=array(
				'user_name' 		=> $this->db->escape_str($user_name),
				'email' 			=> $this->db->escape_str($email),					
				'phone' 			=> $this->db->escape_str($phone),
				'pwd' 				=> $this->db->escape_str($pwd),			
				'uid' 				=> $this->db->escape_str($uid),
				'accountstatus' 	=> 0,						
				'date_created' 		=>  $date_created
			);
			
			$this->db->trans_start();							
			$this->db->insert('issuers', $dat);				
			$this->db->trans_complete();
			
			$Msg='';
			
			if ($this->db->trans_status() === FALSE)
			{
				$Msg=$user_name." attempted registration as an issuer with email '".$email."' but failed.";
									
				$rows =array(
					'status' => "Registration Was Not Successful.",
					'Flag'=>'FAIL',
					'email' => $email
				);			
			}else
			{
				$Msg="Registration was successful.";				
				
				//Send Email
				$from='support@naijaartmart.com';
				$subject='Verify Your Email Address';
				$to=$email;
				$Cc='';
								
				$img="https://www.naijaartmart.com/images/emaillogo.png";
									
				//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
				
				$custname='Issuer';
				
				$message = '
					<html>
					<head>
					<meta charset="utf-8">
					<title>Naija Art Mart | User Registration</title>
					</head>
					<body>								
							<p><img src="'.$img.'" alt="Naija Art Mart" title="Naija Art Mart" /></p>
													
							Dear '.$custname.',<br><br>
							
							An account has been created for you on Naija Art Mart platform. Your login email is <b>'.$email.'</b>.
														
							<br><br>After activating this account as directed below, sign in and update your profile by supplying your bank account and other details. Please note that you will not be able to participate in any commercial activity on the Naija Art Mart platform if your bank account details are not updated in your profile.
							
							<br><br>For full access to your account on Naija Art Mart platform, you will need to activate your account. To do so, click on the link below or copy and paste it in your browser. Please note that activation is a one time action:
									
							<br><br><a href="'.$activationurl.'">Click Here To Activate Your Naija Art Mart Account<a/>					
							
																																									
							<p>Best Regards</p>
							Naija Art Mart
					</body>
					</html>';
					
				$altmessage = '
					Dear '.$custname.',
							
					An account has been created for you on Naija Art Mart platform. Your login email is '.$email.'.
					
					After activating this account as directed below, sign in and update your profile by supplying your bank account and other details. Please note that you will not be able to participate in any commercial activity on the Naija Art Mart platform if your bank account details are not updated in your profile.
					
					For full access to your account on Naija Art Mart platform, you will need to activate your account. To do so, click on the link below or copy and paste it in your browser. Please note that activation is a one time action: '.$activationurl.'
																																				
					Best Regards
					
					Naija Art Mart';
				
				if ($to) $v=$this->getdata_model->SendBlueMail($from,$to,$subject,$Cc,$message,$altmessage,$custname);				
				
							
				if (strtoupper(trim($v)) <> 'OK')
				{
					$rows =array(
						'status' => "Registration was Not successful.<br><br><b>".$ret.'<br>',
						'Flag'=>'FAIL',
						'email' => $email
						);
					
					#Delete Entry From investors Table
					$this->db->trans_start();
					$this->db->delete('issuers', array('email' => $this->db->escape_str($email))); 				
					$this->db->trans_complete();					
				}else
				{
					//temp_users
					$sql = "SELECT * FROM temp_users WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
					$query = $this->db->query($sql);
								
					if ($query->num_rows() > 0 )
					{
						$this->db->trans_start();									
						$this->db->where('email', $email);
						$this->db->delete('temp_users');					
						$this->db->trans_complete();
					}
					
					$exp = date('Y-m-d H:i:s', strtotime($date_created . ' +1 day'));
					
					$this->db->trans_start();
				
					$dat=array(
						'email' 				=> $this->db->escape_str($email),
						'fullname' 				=> $this->db->escape_str($user_name),
						'usertype' 				=> $this->db->escape_str('Issuer'),
						'phone' 				=> $this->db->escape_str($phone),
						'pwd' 					=> $this->db->escape_str($pwd),
						'date_created' 			=> $this->db->escape_str($date_created),				
						'expire' 				=> $exp,
						'tables' 				=> 'issuers'
					);				
						
					$this->db->insert('temp_users', $dat);
					
					$this->db->trans_complete();
					
										
					$rows =array(
						'status' => "Registration was successful but the account has not been activated. An email has been sent to <b>".$email."</b>. Click on the link in the email to activate the account.",
						'Flag'=>'OK',
						'email' => $email
						);
				}
			}
			
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
			$this->getdata_model->LogDetails($user_name,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'REGISTERED ISSUER','');					
		}
		
		echo json_encode($rows);
	}
	
	public function index()
	{
		$this->load->view('ui/signup_view');
	}
}
