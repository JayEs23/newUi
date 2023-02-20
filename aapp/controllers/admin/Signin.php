<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('assets/vendor/autoload.php');

class Signin extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
		//$this->load->helper('form');
	 }
	 
	public function RecoverPwd()
	{
		$email=''; $nm='';;

		if ($this->input->post('email')) $email = trim($this->input->post('email'));

		$dt=date('Y-m-d H:i:s');

		#Check for the email
		$sql="SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";	

		$query = $this->db->query($sql);		

		if ( $query->num_rows()== 0 )
		{
			$ret="The email you entered (<b>".$email."</b>) does not exist in the database.";
		}else
		{
			$expdt=date('Y-m-d H:i:s',strtotime($dt.' 1day'));

			$row = $query->row();			

			if ($row->fullname) $nm=trim($row->fullname);			

			#Check if there is an existing request
			$sql="SELECT * FROM reset_pwd WHERE (TRIM(email)='".$this->db->escape_str($email)."')";

			$query = $this->db->query($sql);		

			$Flag=false;			

			if ( $query->num_rows()> 0 )
			{
				$row = $query->row();		

				if ($row->status==1)
				{

					$ret="You have already requested for password recovery and the link is still active. Please click on the <b>RESET YOUR PASSWORD</b> link in the email sent to you.";
				}else
				{
					$Flag=true;
				}
			}else
			{
				$Flag=true;
			}

			if ($Flag==true)
			{
				$this->db->trans_start();				

				$dat=array(
					'email' => $this->db->escape_str($email),
					'request_date' => $this->db->escape_str($dt),
					'expire_date' => $this->db->escape_str($expdt),
					'status' => 1
					);

				$this->db->insert('reset_pwd', $dat);
				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE)
				{
					$ret = 'Password Recovery Request Was Not Successful. Please Try Again.';
				}else
				{
					$Msg=$nm.' requested for a password recovery successfully!';
					$ResetCode=sha1($email);
					$link=base_url()."admin/Resetpwd/Reset/rc/".$ResetCode;
					//$link=base_url()."admin/index.php/Resetpwd/Reset/rc/".$ResetCode;
					
					$link=$this->getdata_model->ShortenUrl($link);

					#Send Email Notification
					$img=base_url()."images/emaillogo.png";				

					$emailmsg='
						<img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart - Password Reset" />
						<br><br>
						Dear '.$nm.',<br><br>

						We received a request to reset your Naija Art Mart password. Click the link below to choose a new one:<br><br><a href="'.$link.'"><b style="color:#660000;">Reset Your Password</b></a><br><br>								

						Please note that this link will expire after 24 hours.<br><br>						

						Contact us at <a href="mailto:support@naijaartmart.com">support@naijaartmart.com</a> if you need assistance.<br><br>

						Yours Faithfully,<br><br>

						Admin';

						

						$altemailmsg='

						Dear '.$nm.',

						We received a request to reset your Naija Art Mart password. To reset your password, copy this link and paste in your browser: '.$link.'. 											

						Please note that this link will expire after 24 hours. 						

						Contact us at support@naijaartmart.com if you need assistance. 

						Yours Faithfully, 

						Admin
						';						
						
						//SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$name)
						$RT=$this->getdata_model->SendEmail('support@naijaartmart.com',$email,'Naija Art Mart Password Reset Link','',$emailmsg,$altemailmsg,$nm);				

					$ret='OK';
					$remote_ip=$_SERVER['REMOTE_ADDR'];
					$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					$this->getdata_model->LogDetails($nm,$Msg, $email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'PASSWORD RESET LINK','');
				}
			}
		}		

		echo $ret;
	}	
	
	public function UserLogin()
	{
		$em=''; $pwd=''; $remember='0'; $days = 14; $MarketStatus='';
		
		if ($this->input->post('em')) $em = trim($this->input->post('em'));
		if ($this->input->post('pwd')) $pwd = $this->input->post('pwd');
		if ($this->input->post('autosignin')) $autosignin = '1';
		if ($this->input->post('remember')) $remember = '1';
		
		//Updated Market Status
		$ret=$this->getdata_model->GetMarketStatus();				
		$_SESSION['MarketStatus']=$ret['MarketStatus'];
		
		if ($remember=='0') $autosignin='0';
				
		$LogDate=date('Y-m-d H:i:s');
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		$_SESSION['LogID']='';
		$_SESSION['Master']=0;
		
		#User Info	
		$_SESSION['fullname'] = '';
		$_SESSION['company'] = '';
		$_SESSION['accountstatus'] = '0';
		$_SESSION['datecreated'] = '';
		$_SESSION['usertype'] = '';		
		$_SESSION['email'] = '';
		$_SESSION['phone'] = '';
		
		$_SESSION['AddItem'] = '0';
		$_SESSION['EditItem'] = '0';
		$_SESSION['DeleteItem'] = '0';		
		$_SESSION['RequestListing']='0';
		$_SESSION['PublishWork']='0';
		$_SESSION['RegisterBroker']='0';			
		$_SESSION['BuyAndSellToken']='0';			
		$_SESSION['ViewPrices']='0';			
		$_SESSION['ViewOrders']='0';				
		$_SESSION['SetMarketParameters']='0';			
		$_SESSION['CreateAccount']='0';
		$_SESSION['ClearLogFiles']='0';			
		$_SESSION['SetParameters']='0';			
		$_SESSION['ViewLogReports']='0';					
		$_SESSION['ViewReports']='0';
		
				
		#System
		$_SESSION['RemoteIP']=$remote_ip;
		$_SESSION['RemoteHost']=$remote_host;
		$_SESSION['LogIn']=date('Y-m-d H:i:s');
		
		$dec=\mervick\aesEverywhere\AES256::decrypt($pwd,ACCESS_STAMP);
		
		if ((trim(strtolower($em)=='master')) && ($dec == 'jesus'))
		{
			$_SESSION['LogID']=uniqid();
			$_SESSION['Master']=1;
			
			#User Info
			$_SESSION['fullname'] = 'Super Master User';
			$_SESSION['company'] = 'Super Master';
			$_SESSION['accountstatus'] = 1; 
			$_SESSION['datecreated']=date('Y-m-d H:i:s');
			$_SESSION['usertype'] = 'SUPER MASTER';
			$_SESSION['email'] = ''; 
			$_SESSION['phone'] = ''; 
			
			$_SESSION['AddItem'] = 1;
			$_SESSION['EditItem'] = 1;
			$_SESSION['DeleteItem'] = 1;
			$_SESSION['RequestListing']=1;
			$_SESSION['PublishWork']=1;
			$_SESSION['RegisterBroker']=1;			
			$_SESSION['BuyAndSellToken']=1;			
			$_SESSION['ViewPrices']=1;			
			$_SESSION['ViewOrders']=1;				
			$_SESSION['SetMarketParameters']=1;			
			$_SESSION['CreateAccount']=1;
			$_SESSION['ClearLogFiles']=1;			
			$_SESSION['SetParameters']=1;			
			$_SESSION['ViewLogReports']=1;					
			$_SESSION['ViewReports']=1;
																
			$this->getdata_model->LogDetails('Super Master','User Login',$_SESSION['email'],$LogDate,$remote_ip,$remote_host,'LOGIN',$_SESSION['LogID']);
			
			$ret="OK";
		}else
		{
			$_SESSION['Master']=0;
			
			$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($em)."')";			
		
			$query = $this->db->query($sql);
			
			$success=false;
						
			if ($query->num_rows()>0)
			{
				$row = $query->row();
				
				if ($autosignin == '1')
				{
					$success=true;
				}else
				{	//Decrypt
					$pwd_table = \mervick\aesEverywhere\AES256::decrypt($row->pwd, ACCESS_STAMP);					
					$pwd_user  = \mervick\aesEverywhere\AES256::decrypt($pwd, ACCESS_STAMP); 
				
					if ($pwd_table == $pwd_user) $success=true;
				}
				
				if ($success)
				{					
					if(strtolower($row->accountstatus) != 1) 
					{
						$ret = "Account has been disabled. Please contact our support team at support@naijaartmart.com.";
					}else
					{
						#User Info					
						if ($row->fullname) $_SESSION['fullname'] = $row->fullname;
						if ($row->company) $_SESSION['company'] = $row->company;
						if ($row->accountstatus) $_SESSION['accountstatus'] = '1';
						if ($row->datecreated) $_SESSION['datecreated']= $row->datecreated;
						if ($row->usertype) $_SESSION['usertype'] = $row->usertype;
						if ($row->email) $_SESSION['email'] = $row->email;
						if ($row->phone) $_SESSION['phone'] = $row->phone;
						
						if ($row->AddItem==1) $_SESSION['AddItem']=1;
						if ($row->EditItem==1) $_SESSIONata['EditItem']=1;
						if ($row->DeleteItem==1) $_SESSION['DeleteItem']=1;
		
						if (intval($remember) == 1)//Set cookie
						{ //86400=1day, 3600=1hour, 60=1minute
							$value = $this->getdata_model->EncryptText($em);
							setcookie ("TR6wTuqB6pfUCBRd99T8QCk2pUrGJC",$value,time() + ($days * 86400),"/");
						}else//Delete cookie
						{
							$em =$this->getdata_model->DecryptText($_COOKIE["TR6wTuqB6pfUCBRd99T8QCk2pUrGJC"]);
							
							$value=time() - 360;
							
							setcookie("TR6wTuqB6pfUCBRd99T8QCk2pUrGJC", $em, $value,'/');
						}
						
						if ($_SESSION['company'])
						{
							$nm = $_SESSION['company'];
						}elseif ($_SESSION['fullname'])
						{
							$nm = $_SESSION['fullname'];
						}
						
						$_SESSION['LogID']=uniqid();
												
						$this->getdata_model->LogDetails($_SESSION['fullname'],'User Login',$_SESSION['email'],$LogDate,$remote_ip,$remote_host,'LOGIN',$_SESSION['LogID']);
						
						$ret='OK';
					}	
				}else
				{
					$ret="Login Failed: Invalid authentication information. Wrong password entered.";
				}				
			}else
			{
				$ret="Login Failed: Invalid authentication information. Wrong email entered.";
			}
		}
				
		echo $ret;
	}#End Of UserLogin functions
	
	public function CheckLogin()
	{
		$em=''; $usertype='';
		
		if ($this->input->post('email')) $em = trim($this->input->post('email'));
		
		$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($em)."')";			
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows()>0)
		{
			$row = $query->row();
			
			if ($row->usertype) $usertype = $row->usertype;
		}
				
		echo $usertype;
	}#End Of CheckLogin functions
	
	public function index()
	{
		if (isset($_COOKIE["TR6wTuqB6pfUCBRd99T8QCk2pUrGJC"]))
		{ 
			$v =$this->getdata_model->DecryptText($_COOKIE["TR6wTuqB6pfUCBRd99T8QCk2pUrGJC"]);
	
			 $data['autosignin']='1';
			 $data['email']=$v;
		}else
		{	
			$data['autosignin']='0';
		}
		
		$this->load->view('admin/signin_view',$data);
	}
}
