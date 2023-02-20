<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Userprofile extends CI_Controller {
	function __construct() 
	{
		parent::__construct();		
		$this->load->helper('url');
		$this->load->model('getdata_model');
	}
	
	public function GetCountries()
	{
		$sql="SELECT DISTINCT(country) as country FROM countries ORDER BY country";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetCountries functions
	
	public function UpdateProfile()
	{
		$email=''; $phone=''; $lastname=''; $firstname=''; $gender=''; $dob=''; $nationality=''; $residence_country='';
		$referral=''; $PixImg = '';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('phone')) $phone = trim($this->input->post('phone'));			
		if ($this->input->post('lastname')) $lastname = trim($this->input->post('lastname'));
		if ($this->input->post('firstname')) $firstname = trim($this->input->post('firstname'));
		if ($this->input->post('gender')) $gender = trim($this->input->post('gender'));			
		if ($this->input->post('dob')) $dob = trim($this->input->post('dob'));	
		if ($this->input->post('nationality')) $nationality = trim($this->input->post('nationality'));
		if ($this->input->post('residence_country')) $residence_country = trim($this->input->post('residence_country'));	
		if ($this->input->post('referral')) $referral = trim($this->input->post('referral'));	
		
		if (isset($_FILES['pix'])) $PixImg = $_FILES['pix'];
		
		//Check if record exists
		$sql = "SELECT * FROM investors WHERE (TRIM(email)='".$this->db->escape_str($email)."')";

		$query = $this->db->query($sql);
					
		if ($query->num_rows() == 0 )
		{
			$ret='Investor record with email "'.$email.'" does not exist in the database.';
		}else
		{
			$Lpix=''; $ph=''; $ln=''; $fn=''; $gn=''; $d=''; $cn=''; $rcn=''; $ref=''; $px=''; $uid='';
						
			$row = $query->row();			
			
			if ($row->phone) $ph=trim($row->phone);
			if ($row->lastname) $ln=trim($row->lastname);
			if ($row->firstname) $fn=trim($row->firstname);
			if ($row->gender) $gn=trim($row->gender);
			if ($row->dob) $d=trim($row->dob);
			if ($row->nationality) $cn=trim($row->nationality);
			if ($row->residence_country) $rcn=trim($row->residence_country);
			if ($row->referral) $ref=trim($row->referral);
			if ($row->pix) $px=trim($row->pix);
			if ($row->uid) $uid=trim($row->uid);
					
			if ($PixImg)
			{
				if (file_exists("assets/investor_pixs/".$px)) unlink("assets/investor_pixs/".$px); //Delete old logo
					
				$ext = explode('.', basename($PixImg['name']));
				
				$fn=$uid.".".array_pop($ext);
				
				$target ="assets/investor_pixs/".$fn;
				
				if (move_uploaded_file($PixImg['tmp_name'], $target))
				{
					$Lpix=$fn;
					$this->getdata_model->ResizeImage($target,150);
				}
			}
						
						
			$OldValues="Email = ".$email."; Phone = ".$ph."; Lastname = ".$ln."; Firstname = ".$fn."; Gender = ".$gn."; Date Of Birth = ".$d."; Nationality = ".$cn."; Country Of Residence = ".$rcn."; Picture File Name = ".$px."; Referral Email = ".$ref."; User Id = ".$uid;
			
			$NewValues="Email = ".$email."; Phone = ".$phone."; Lastname = ".$lastname."; Firstname = ".$firstname."; Gender = ".$gender."; Date Of Birth = ".$dob."; Nationality = ".$nationality."; Country Of Residence = ".$residence_country."; Picture File Name = ".$Lpix."; Referral Email = ".$referral."; User Id = ".$uid;
			
			if ($dob)
			{
				$dat=array(
					'phone' 			=> $this->db->escape_str($phone),
					'lastname' 			=> $this->db->escape_str($lastname),
					'firstname' 		=> $this->db->escape_str($firstname),
					'gender' 			=> $this->db->escape_str($gender),
					'dob' 				=> $this->db->escape_str($dob),
					'nationality' 		=> $this->db->escape_str($nationality),
					'residence_country' => $this->db->escape_str($residence_country),
					'referral' 			=> $this->db->escape_str($referral),
					'Lpix' 				=> $this->db->escape_str($Lpix)
				);	
			}else
			{
				$dat=array(
					'phone' 			=> $this->db->escape_str($phone),
					'lastname' 			=> $this->db->escape_str($lastname),
					'firstname' 		=> $this->db->escape_str($firstname),
					'gender' 			=> $this->db->escape_str($gender),
					'nationality' 		=> $this->db->escape_str($nationality),
					'residence_country' => $this->db->escape_str($residence_country),
					'referral' 			=> $this->db->escape_str($referral)
				);
			}
			
			#Edit
			$this->db->trans_start();
			$this->db->where(array('email' => $email));
			$this->db->update('investors', $dat);			
			$this->db->trans_complete();
						
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{					
				$Msg=$_SESSION['email']." attempted editing record for investor with email ".strtoupper($email)." and user Id '".$uid."' but failed.";
				
				$ret = 'Profile Record Could Not Be Updated.';
			}else
			{
				#Update Pix
				if ($Lpix)
				{
					$this->db->trans_start();			
					$dat=array('pix' => $this->db->escape_str($Lpix));
					$this->db->where(array('email' => $email));
					$this->db->update('investors', $dat);					
					$this->db->trans_complete();
				}
				
				$Msg="Profile record has been edited successfully by ".$_SESSION['email'].". Old Values => ".$OldValues.". Updated values => ".$NewValues;
				
				$ret ='OK';
				
				#Send Email - EmailSender($from,$to,$Cc,$message,$name)
				$from='support@naijaartmart.com';
				$to=$email;
				$subject='Updated Profile';
				$Cc='';
								
				$img=base_url()."images/logo.png";
				//$img="https://imgur.com/idvcINL";
				
				//$file = fopen('aaa.txt',"a"); fwrite($file,$img); fclose($file);
				
				$message = '
					<html>
					<head>
					<meta charset="utf-8">
					<title>Naija Art Mart | User Profile Update</title>
					</head>
					<body>
							<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
														
							Dear Investor,<br></p>
							
							<p>You have successfully updated your profile.</p>
																																									
							<p>Best Regards</p>
							Naija Art Mart
					</body>
					</html>';
					
					$altmessage = '
						Dear Investor,
								
						You have successfully updated your profile.
																																					
						Best Regards
						
						Naija Art Mart';
				
				#SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$name)
				if ($to) $v=$this->getdata_model->SendMail($from,$to,$subject,$Cc,$message,$altmessage,'');
				
				$_SESSION['lastname']=$lastname;
				$_SESSION['firstname']=$firstname;
				$_SESSION['pix'] = $Lpix;
				$_SESSION['phone']=$phone;
				
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
				$this->getdata_model->LogDetails($email,$email,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'UPDATED PROFILE RECORD',$_SESSION['LogID']);	
			}			
		}
				
		echo $ret;
	}
	
	public function index()
	{
		$data['lastname']=''; $data['firstname']=''; $data['email']=''; $data['phone']=''; $data['pix']='';
		$data['accountstatus'] = ''; $data['investortype'] = ''; $data['pix'] = ''; $data['broker_id']='';
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
			
			//Investor Details
			$rw=$this->getdata_model->GetInvestorDetails($data['email']);
			
			if ($rw->investortype) $data['investortype'] = $rw->investortype;
			if ($rw->accountstatus) $data['accountstatus'] = $rw->accountstatus;
			if ($rw->lastname) $data['lastname'] = $rw->lastname;
			if ($rw->firstname) $data['firstname'] = $rw->firstname;
			if ($rw->pix) $data['pix'] = $rw->pix;
			if ($rw->gender) $data['gender'] = $rw->gender;
			if ($rw->phone) $data['phone'] = $rw->phone;
			if ($rw->dob) $data['dob'] = $rw->dob;
			if ($rw->nationality) $data['nationality'] = $rw->nationality;
			if ($rw->residence_country) $data['residence_country'] = $rw->residence_country;
			if ($rw->referral) $data['referral'] = $rw->referral;
			if ($rw->broker_id) $data['broker_id'] = $rw->broker_id;
			if ($rw->company) $data['company'] = $rw->company;
			if ($rw->address) $data['address'] = $rw->address;
			
			$set=$this->getdata_model->GetParamaters();
				
			if (intval($set->refreshinterval) > 0)
			{
				$data['RefreshInterval'] = $set->refreshinterval;
			}else
			{
				$data['RefreshInterval']=5;
			}
						
			$this->load->view('ui/userprofile_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('');
		}
	}
}
