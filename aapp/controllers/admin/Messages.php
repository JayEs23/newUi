<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('assets/vendor/autoload.php');

class Messages extends CI_Controller {
	private $msgid='', $header='', $details, $msgdate='', $category='';
	private $sender='', $expiredate='', $display_status='0', $recipients='';
	
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
		
		if ($this->input->post('msgid')) $this->msgid = trim($this->input->post('msgid'));		
		if ($this->input->post('header')) $this->header = trim($this->input->post('header'));
		if ($this->input->post('details')) $this->details = trim($this->input->post('details'));
		if ($this->input->post('category')) $this->category = trim($this->input->post('category'));
		if ($this->input->post('sender')) $this->sender = trim($this->input->post('sender'));
		if ($this->input->post('display_status') == 1) $this->display_status = 1;
		if ($this->input->post('recipients')) $this->recipients = trim($this->input->post('recipients'));
		
		if ($this->input->post('msgdate'))
		{
			$this->msgdate=$this->input->post('msgdate');
			
			if ($this->msgdate <> '0000-00-00 00:00:00')
			{
				$this->msgdate = date('d M Y @ H:i:s',strtotime($this->msgdate));
			}else
			{
				$this->msgdate = '';
			}
		}
		
		if ($this->input->post('expiredate'))
		{
			$this->expiredate=$this->input->post('expiredate');
			
			if ($this->expiredate <> '0000-00-00 00:00:00')
			{
				$this->expiredate = date('d M Y',strtotime($this->expiredate));
			}else
			{
				$this->expiredate = '';
			}
		}
		
	 }
	 
	public function GetStates()
	{
		$sql="SELECT DISTINCT(state) as state FROM states ORDER BY state";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetStates
	 
	function GetMessages()
	{
		$email='';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		
		if (strtolower(trim($_SESSION['usertype'])) == 'admin')
		{
			$results=$this->getdata_model->GetQueuedMessages($email,1);
		}else
		{
			$results=$this->getdata_model->GetQueuedMessages($email,'');
		}		
		
		$data=array();

		if ($results)
		{
			foreach($results as $row):
				$sel=''; $del=''; $dt=''; $edt=''; $sta="Don't Display Message";
				
				if ($row->display_status == 1) $sta="Display Message";
				
				if (($row->msgdate <> '0000-00-00 00:00:00') and (!is_null($row->msgdate))) $dt=date('d M Y @ H:i:s',strtotime($row->msgdate));
				if (($row->expiredate <> '0000-00-00 00:00:00') and (!is_null($row->expiredate))) $edt=date('d M Y @ H:i',strtotime($row->expiredate));
				
				if ($row->header) $row->header = str_replace("'","`",$row->header);				
				if ($row->details) $row->details = str_replace("'","`",$row->details);
				
				$sel='<img onClick="SelectRow(\''.$row->msgid.'\',\''.urlencode($row->header).'\',\''.urlencode($row->details).'\',\''.$row->sender.'\',\''.$dt.'\',\''.$edt.'\',\''.$row->category.'\',\''.$row->display_status.'\',\''.$row->recipients.'\')" style="cursor:pointer; height:30px;" src="'.base_url().'images/view_icon.png" title="Click To Select '.$row->category.' With Header '.$row->header.'">';
				
				if ($_SESSION['DeleteItem']==1)
				{
					$del='<img onClick="DeleteRow(\''.$row->msgid.'\',\''.urlencode($row->header).'\',\''.urlencode($row->details).'\',\''.$row->sender.'\',\''.$dt.'\',\''.$row->category.'\',\''.$row->display_status.'\',\''.$row->recipients.'\')" style="cursor:pointer; height:30px;" src="'.base_url().'images/delete_icon.png" title="Delete '.$row->category.' With Header '.$row->header.'">';	
				}
								
				$tp=array($sel,$del,$dt,$row->category,$row->header,$row->sender,$sta);
				
				$data[]=$tp;
			endforeach;
		}

		print_r(json_encode($data));
	}
	
	function SendMsg()
	{
		$header=''; $details=''; $category=''; $expiredate=NULL; $recipients=''; $display_status='';
		$msgid=''; $email='';
		
		if ($this->input->post('header')) $header = trim($this->input->post('header'));
		if ($this->input->post('details')) $details = trim($this->input->post('details'));
		if ($this->input->post('category')) $category = trim($this->input->post('category'));
		if ($this->input->post('expiredate')) $expiredate = trim($this->input->post('expiredate'));
		if ($this->input->post('recipients')) $recipients = trim($this->input->post('recipients'));
		if ($this->input->post('display_status')) $display_status = trim($this->input->post('display_status'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		
		$msgdate=date('Y-m-d H:i:s');
		
		if ($expiredate === NULL) $expiredate=date('Y-m-d H:i:s',strtotime($msgdate.' +7 days'));
		
		$msgid=$this->getdata_model->GetId('messages','msgid');
								
		$this->db->trans_start();
				
		$dat=array(
			'msgid' 			=> $this->db->escape_str($msgid),
			'header' 			=> $this->db->escape_str($header),
			'details' 			=> $this->db->escape_str($details),
			'msgdate' 			=> $this->db->escape_str($msgdate),
			'category' 			=> $this->db->escape_str($category),
			'expiredate'		=> $this->db->escape_str($expiredate),
			'recipients' 		=> $this->db->escape_str($recipients),
			'sender' 			=> $this->db->escape_str($email),
			'display_status' 	=> $this->db->escape_str($display_status)				
			);
		
		$this->db->insert('messages', $dat);
		
		$this->db->trans_complete();
		
		$Msg='';	
		
		if ($this->db->trans_status() === FALSE)
		{					
			$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted sending message to message queue but failed.";
			$m = "Message Could Not Be Queued.";
			$ret=array('status'=>'FAIL','Message'=>$m);					
		}else
		{					
			$Msg="Message Was Queued Successfully.";				
			
			$ret=array('status'=>'OK','Message'=>'');
			
			$m="QUEUED MESSAGE FOR SENDING";
			
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,$m,$_SESSION['LogID']);	
		}
				
		echo json_encode($ret);
	}
	
	public function EditMessage()
	{
		$header=''; $details=''; $category=''; $expiredate=NULL; $recipients=''; $display_status='';
		$msgid=''; $email='';
		
		if ($this->input->post('header')) $header = trim($this->input->post('header'));
		if ($this->input->post('details')) $details = trim($this->input->post('details'));
		if ($this->input->post('category')) $category = trim($this->input->post('category'));
		if ($this->input->post('expiredate')) $expiredate = trim($this->input->post('expiredate'));
		if ($this->input->post('recipients')) $recipients = trim($this->input->post('recipients'));
		if ($this->input->post('display_status')) $display_status = trim($this->input->post('display_status'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('msgid')) $msgid = trim($this->input->post('msgid'));	
		
		if ($expiredate === NULL) $expiredate=date('Y-m-d H:i:s',strtotime($msgdate.' +7 days'));	
		
		//Check if record exists		
		$sql = "SELECT * FROM messages WHERE (msgid=".$this->db->escape_str($msgid).")";

		$query = $this->db->query($sql);
					
		if ($query->num_rows() == 0 )
		{
			$m = "Could Not Edit Message. Message Id ".$msgid." Does Not Exist.";
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			$mid=''; $hd=''; $det=''; $dt=''; $ct=''; $edt=''; $rec=''; $sn=''; $sta='0';
		
			$row = $query->row();			
			
			if ($row->msgid) $mid=trim($row->msgid);
			if ($row->header) $hd=trim($row->header);
			if ($row->details) $det=trim($row->details);
			if ($row->msgdate) $dt=trim($row->msgdate);
			if ($row->category) $ct=trim($row->category);
			if ($row->expiredate) $edt=trim($row->expiredate);
			if ($row->recipients) $rec=trim($row->recipients);
			if ($row->sender) $sn=trim($row->sender);
			if ($row->display_status == 1) $sta=1;
						
			$OldValues="Message Id = ".$mid."; Message Header = ".$hd."; Message Details = ".$det."; Message Date = ".$dt."; Message Category = ".$ct."; Message Expiry Date = ".$edt."; Message Recipients = ".$rec."; Message Sender = ".$sn."; Message Display Status = ".$sta;			
			
			$NewValues="Message Id = ".$msgid."; Message Header = ".$header."; Message Details = ".$details."; Message Date = ".$dt."; Message Category = ".$category."; Message Expiry Date = ".$expiredate."; Message Recipients = ".$recipients."; Message Sender = ".$email."; Message Display Status = ".$display_status;
			
			$dat=array(
				'header' 			=> $this->db->escape_str($header),
				'details' 			=> $this->db->escape_str($details),
				'category' 			=> $this->db->escape_str($category),
				'expiredate'		=> $this->db->escape_str($expiredate),
				'recipients' 		=> $this->db->escape_str($recipients),
				'sender' 			=> $this->db->escape_str($email),
				'display_status' 	=> $this->db->escape_str($display_status)
			);
			
			#Edit
			$this->db->trans_start();
			$this->db->where(array('msgid' => $msgid));
			$this->db->update('messages', $dat);			
			$this->db->trans_complete();
						
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{					
				$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted editing message but failed.";
				
				$m = "Message Record Could Not Be Edited.";
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{
				$Msg="Message has been edited successfully by ".strtoupper($_SESSION['fullname'].'('.$_SESSION['email'])."). Old Values => ".$OldValues.". Updated values => ".$NewValues;				
				
				$ret=array('status'=>'OK','Message'=>'');
								
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,"EDITED MESSAGE",$_SESSION['LogID']);
			}			
		}
				
		echo json_encode($ret);
	}
	
	public function DeleteMessage()
	{
		$msgid=''; $email='';
		
		if ($this->input->post('msgid')) $msgid = trim($this->input->post('msgid'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		
		//Check if record exists		
		$sql = "SELECT * FROM messages WHERE (msgid=".$this->db->escape_str($msgid).")";
		
		$query = $this->db->query($sql);
					
		if ($query->num_rows() > 0 )
		{
			$row = $query->row();
			
			if ($row->email) $email=trim($row->email);
			
			$this->db->trans_start();
			$this->db->delete('messages', array('msgid' => $msgid)); 				
			$this->db->trans_complete();
			
			$sql = "SELECT * FROM messages";		
			$qry = $this->db->query($sql);			
			$rowcount=$qry->num_rows();		
						
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{
				$Msg=$_SESSION['email'].'('.$_SESSION['fullname'].") attempted deleting message with id ".$msgid." but failed.";
				
				$ret=array('status'=>'FAIL','Message'=>"Message Could Not Be Deleted.",'rowcount'=>$rowcount);
			}else
			{
				$Msg="Message with id ".$msgid." has been deleted successfully by ".strtoupper($_SESSION['email'].'('.$_SESSION['fullname']).").";
				
				$ret=array('status'=>'OK','Message'=>'','rowcount'=>$rowcount);
				
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],$_SESSION['LogIn'],$_SESSION['RemoteIP'],$_SESSION['RemoteHost'],"DELETED MESSAGE",$_SESSION['LogID']);
			}
		}else
		{
			$ret=array('status'=>'FAIL','Message'=>"Could Not Delete Message. Message Does Not Exist.",'rowcount'=>$rowcount);
		}
		
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
			
			if ($this->msgid) $data['msgid'] = $this->msgid; else $data['msgid']='';
			if ($this->header) $data['header'] = $this->header; else $data['header']='';
			if ($this->details) $data['details'] = $this->details; else $data['details']='';
			if ($this->msgdate) $data['msgdate'] = $this->msgdate; else $data['msgdate']='';
			if ($this->category) $data['category'] = $this->category; else $data['category']='';			
			if ($this->expiredate) $data['expiredate'] = $this->expiredate; else $data['expiredate']='';			
			if ($this->recipients) $data['recipients'] = $this->recipients; else $data['recipients']='';
			if ($this->display_status == 1) $data['display_status'] = 1; else $data['display_status']='0';
			if ($this->sender) $data['sender'] = $this->sender; else $data['sender']='';
			
			$this->load->view('admin/messages_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
