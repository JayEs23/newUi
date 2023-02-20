<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class States extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	 }
	 
	public function GetStates()
	{
		$sql = "SELECT * FROM states ORDER BY state";											

		$query = $this->db->query(stripslashes($sql));	

		$results = $query->result_array();		

		if ($results)
		{
			$data=array();

			if (is_array($results))
			{
				$sn=0;
				
				foreach($results as $row):
					$sn++; $sel=''; $del='';
					
					$sel='<img onClick="SelectRow(\''.$row['state'].'\',\''.$row['id'].'\')" style="cursor:pointer; height:30px; " src="'.base_url().'images/pencil_icon.png" title="Edit The State, '.strtoupper(trim($row['state'])).'">';
					
										
					if ($_SESSION['DeleteItem']==1)
					{
						$del='<img onClick="DeleteRow(\''.$row['state'].'\',\''.$row['id'].'\')" style="cursor:pointer; height:30px;" src="'.base_url().'images/delete_icon.png" title="Delete The State '.strtoupper(trim($row['state'])).'">';	
					}
					
					$tp=array($sel,$del,$row['state']);
					
					$data[]=$tp;
				endforeach;
			}

			print_r(json_encode($data));
		}else
		{
			print_r(json_encode($results));
		}
	}
	
	public function AddState()
	{
		$state='';
		
		if ($this->input->post('state')) $state = trim($this->input->post('state'));
								
		//Check if record exists
		$sql = "SELECT * FROM states WHERE (TRIM(state)='".$this->db->escape_str($state)."')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 )
		{
			$m = 'Addition of state record was NOT successful. The state record exists in the database.';
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			$this->db->trans_start();
				
			$dat=array('state' => $this->db->escape_str($state));
			
			$this->db->insert('states', $dat);
			
			$this->db->trans_complete();
			
			$Msg='';	
			
			if ($this->db->trans_status() === FALSE)
			{					
				$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted adding state record but failed.";
				$m = 'State Record Was Not Added.';
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{					
				$Msg="State Record Was Added Successfully.";				
				
				$ret=array('status'=>'OK','Message'=>'');
			}
			
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'ADDED STATE RECORD',$_SESSION['LogID']);				
		}
				
		echo json_encode($ret);
	}
	
	public function EditState()
	{
		$state=''; $Id = '';
		
		if ($this->input->post('state')) $state = trim($this->input->post('state'));
		if ($this->input->post('id')) $Id = trim($this->input->post('id'));
		
		
		//Check if record exists		
		$sql = "SELECT * FROM states WHERE (id=".$this->db->escape_str($Id).")";

		$query = $this->db->query($sql);
					
		if ($query->num_rows() == 0 )
		{
			$m = 'Could Not Edit State Record. Record ID Does Not Exist.';
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			$st='';
			
			$row = $query->row();			
			
			if ($row->state) $cd=trim($row->state);
									
			$OldValues="State = ".$st;			
			$NewValues="State = ".$state;
			
			$dat=array('state' => $this->db->escape_str($state));
			
			#Edit
			$this->db->trans_start();
			$this->db->where(array('id' => $Id));
			$this->db->update('states', $dat);			
			$this->db->trans_complete();
						
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{					
				$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted editing state but failed.";
				
				$m = 'State Record Could Not Be Edited.';
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{				
				$Msg="State record has been edited successfully by ".strtoupper($_SESSION['fullname'].'('.$_SESSION['email'])."). Old Values => ".$OldValues.". Updated values => ".$NewValues;				
				
				$ret=array('status'=>'OK','Message'=>'');
								
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'EDITED STATE RECORD',$_SESSION['LogID']);
			}			
		}
				
		echo json_encode($ret);
	}
	
	public function DeleteState()
	{
		$state=''; $id='';
		
		if ($this->input->post('id')) $id = trim($this->input->post('id'));
		if ($this->input->post('state')) $state = trim($this->input->post('state'));
		
		//Check if record exists		
		$sql = "SELECT * FROM states WHERE (id=".$this->db->escape_str($id).")";
		
		$query = $this->db->query($sql);
					
		if ($query->num_rows() > 0 )
		{
			$row = $query->row();
			
			$this->db->trans_start();
			$this->db->delete('states', array('id' => $id)); 				
			$this->db->trans_complete();
			
			$sql = "SELECT * FROM states";		
			$qry = $this->db->query($sql);			
			$rowcount=$qry->num_rows();		
						
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{
				$Msg=$_SESSION['email'].'('.$_SESSION['fullname'].") attempted deleting state record but failed.";
				
				$ret=array('status'=>'FAIL','Message'=>'State Record Could Not Be Deleted.','rowcount'=>$rowcount);
			}else
			{
				$Msg="State record for has been deleted successfully by ".strtoupper($_SESSION['email'].'('.$_SESSION['fullname']).").";
				
				$ret=array('status'=>'OK','Message'=>'','rowcount'=>$rowcount);
				
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],$_SESSION['LogIn'],$_SESSION['RemoteIP'],$_SESSION['RemoteHost'],'DELETED STATE RECORD',$_SESSION['LogID']);
			}
		}else
		{
			$ret=array('status'=>'FAIL','Message'=>'Could Not Delete State Record. Record Does Not Exist.','rowcount'=>$rowcount);
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
			
			$this->load->view('admin/states_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
