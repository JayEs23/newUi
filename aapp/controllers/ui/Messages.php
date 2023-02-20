<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends CI_Controller {
	private $msgid='', $header='', $details, $msgdate='', $category='';
	
	function __construct() 
	{
		parent::__construct();		
		$this->load->helper('url');
		
		if ($this->input->post('msgid')) $this->msgid = trim($this->input->post('msgid'));		
		if ($this->input->post('header')) $this->header = trim($this->input->post('header'));
		if ($this->input->post('details')) $this->details = trim($this->input->post('details'));
		
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
		
		if ($this->input->post('category')) $this->category = trim($this->input->post('category'));
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
				
				if ($row->msgdate <> '0000-00-00 00:00:00') $dt=date('d M Y @ H:i:s',strtotime($row->msgdate));
				
				if ($row->header) $row->header=str_replace("'","`",$row->header);				
				if ($row->details) $row->details=str_replace("'","`",$row->details);
				
				$details=$row->details;
				$header=$row->header;
				
				if (strlen($row->details) > $chr_count) $row->details = substr($row->details,0,$chr_count-3).'...';
				//if (strlen($row->header) > $head_count) $row->header = substr($row->header,0,$head_count-3).'...';
				
				
				$view='<img onClick="ViewMessage(\''.$row->msgid.'\',\''.urlencode($header).'\',\''.urlencode($details).'\',\''.date('d M Y @ H:i:s',strtotime($row->msgdate)).'\',\''.$row->category.'\')" style="cursor:pointer; height:30px;" src="'.base_url().'images/view_icon.png" title="Click To View '.$row->category.'">';
								
				$tp=array($dt,$row->header,$row->sender,$view);
				
				$data[]=$tp;
			endforeach;
		}

		print_r(json_encode($data));
	}
	

	
	public function index()
	{
		$data['lastname']=''; $data['firstname']=''; $data['email']=''; $data['phone']=''; $data['pix']='';
		$data['accountstatus'] = ''; $data['pix'] = ''; $data['broker_id']='';
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
			
			if ($this->msgid) $data['msgid'] = $this->msgid; else $data['msgid']='';
			if ($this->header) $data['header'] = $this->header; else $data['header']='';
			if ($this->details) $data['details'] = $this->details; else $data['details']='';
			if ($this->msgdate) $data['msgdate'] = $this->msgdate; else $data['msgdate']='';
			if ($this->category) $data['category'] = $this->category; else $data['category']='';
			
			$set=$this->getdata_model->GetParamaters();
				
			if (intval($set->refreshinterval) > 0)
			{
				$data['RefreshInterval'] = $set->refreshinterval;
			}else
			{
				$data['RefreshInterval']=5;
			}
			
			$data['balance']=$this->getdata_model->GetWalletBalance($data['email']);
						
			$this->load->view('ui/messages_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('');
		}
	}
}
