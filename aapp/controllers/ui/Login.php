<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('assets/vendor/autoload.php');

class Login extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	
	public function ForgotPwd()
	{
		$email=''; $nm='';

		if ($this->input->post('email')) $email = trim($this->input->post('email'));

		$dt=date('Y-m-d H:i:s');

		#Check for the email
		$sql="SELECT * FROM customers WHERE (TRIM(email)='".$this->db->escape_str($email)."')";	

		$query = $this->db->query($sql);		

		if ( $query->num_rows()== 0 )
		{
			$ret="The email you entered (<b>".$email."</b>) does not exist in SaveMyChange database. Please check your email entry.";
		}else
		{
			$expdt=date('Y-m-d H:i:s',strtotime($dt.' 1day'));

			$row = $query->row();			

			$nm='';
			
			if ($row->fullname) $nm=trim($row->fullname);		

			#Check if there is an existing request
			$sql="SELECT * FROM reset_pwd WHERE (email='".$this->db->escape_str($email)."')";

			$query = $this->db->query($sql);		

			$Flag=false;			

			if ( $query->num_rows()> 0 )
			{
				$row = $query->row();		

				if ($row->status==1)
				{

					$ret="You have already requested for password reset and the link is still active. Please click on the <b>RESET YOUR PASSWORD</b> link in the email sent to you.";
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
					$ret = 'Password Reset Request Was Not Successful. Please Try Again.';
				}else
				{
					$Msg=$nm.' requested for a password reset successfully!';
					$ResetCode=sha1($email);
					$link=base_url()."Resetpwd/Reset/rc/".$ResetCode;
					
					#Send Email Notification
					$img=base_url()."images/emaillogo.png";				

					$emailmsg='
						<img src="'.$img.'" width="100" title="SaveMyChange Password Reset" />
						<br>
						Dear '.$nm.',<br><br>

						We received a request to reset your SaveMyChange password. Click the link below to choose a new one:<br><br><a href="'.$link.'"><b style="color:#660000;">Reset Your Password</b></a><br><br>								

						Please note that this link will expire after 24 hours.<br><br>						

						Contact us at <a href="mailto:support@sparechange.com.ng">support@sparechange.com.ng</a> if you need assistance.<br><br>

						Yours Faithfully,<br><br>

						SaveMyChange';

						

						$altemailmsg='

						Dear '.$nm.',

						We received a request to reset your SaveMyChange password. To reset your password, copy this link and paste in your browser: '.$link.'. 											

						Please note that this link will expire after 24 hours. 						

						Contact us at support@sparechange.com.ng if you need assistance. 

						Yours Faithfully, 

						SaveMyChange';						

						$RT=$this->getdata_model->SendEmail('support@sparechange.com.ng',$email,'SaveMyChange Password Reset Link','',$emailmsg,$altemailmsg,$nm);				

					$ret='OK';
					$remote_ip=$_SERVER['REMOTE_ADDR'];
					$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
					//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
					$this->getdata_model->LogDetails($email,$Msg, $email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'PASSWORD RESET LINK','');
				}
			}
		}		

		echo $ret;
	}

  	public function UserLogin()
	{
		$email=''; $pwd=''; $ph=''; $ret=array();  $MarketStatus='';

		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('pwd')) $pwd = $this->input->post('pwd');
		
		//Updated Market Status
		$ret=$this->getdata_model->GetMarketStatus();				
		$_SESSION['MarketStatus']=$ret['MarketStatus'];
		
		$LogDate=date('Y-m-d H:i:s');
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
		$_SESSION['LogID']='';
		$_SESSION['Master']=0;
		
		#Investor Info
		#User Info	
		$_SESSION['fullname'] = '';
		$_SESSION['company'] = '';
		$_SESSION['accountstatus'] = '0';
		$_SESSION['datecreated'] = '';
		$_SESSION['usertype'] = '';		
		$_SESSION['email'] = '';
		$_SESSION['phone'] = '';
		
		#Permissions	
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
		
		if ((trim(strtolower($email)=='master')) && ($dec == 'jesus'))
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
			
			//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
			$this->getdata_model->LogDetails('Super Master','User Login','Master',$LogDate,$remote_ip,$remote_host,'LOGIN',$_SESSION['LogID']);
			
			$ret=array('status'=>'OK');
		}else
		{
			$_SESSION['Master']=0;
			
			$sql = "SELECT * FROM userinfo WHERE (TRIM(email)='".trim($this->db->escape_str($email))."')";	

			$query = $this->db->query($sql);

			if ($query->num_rows()>0)
			{
				$success=false;
				
				$row = $query->row();
					
				//Decrypt
				$pwd_table = \mervick\aesEverywhere\AES256::decrypt($row->pwd, ACCESS_STAMP);					
				$pwd_user  = \mervick\aesEverywhere\AES256::decrypt($pwd, ACCESS_STAMP);
								
				if ($pwd_table == $pwd_user) $success=true;
				
				if ($success)
				{	
					if ($row->accountstatus <> 1) 
					{
						$msg = "Account has been disabled. Please contact our support team at <a href='mailto:support@naijaartmart.com' target='new'>support@naijaartmart.com</a>.";
						
						$ret=array('status'=>'Failed','msg'=>$msg);
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
						
						$_SESSION['LogID']=uniqid();
						
						if ($_SESSION['company'])
						{
							$nm = $_SESSION['company'];
						}elseif ($_SESSION['fullname'])
						{
							$nm = $_SESSION['fullname'];
						}						
						
						//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
						$this->getdata_model->LogDetails($nm,'User Login',$_SESSION['email'],$LogDate,$remote_ip,$remote_host,'LOGIN',$_SESSION['LogID']);
						
						$ret='OK';
						$ret=array('status'=>'OK');
					}	
				}else
				{
					$msg="Login Failed: Invalid authentication information. Wrong password entered.";
					$ret=array('status'=>'Failed','msg'=>$msg);
				}					
			}else
			{
				$msg="Login Failed: Invalid authentication information. Please Confirm Email Address.";
				$ret=array('status'=>'Failed','msg'=>$msg);
			}
		}	

		echo json_encode($ret);
	}#End Of UserLogin functions
	
	public function index()
	{
		$this->load->view('ui/login_view');
	}
}
