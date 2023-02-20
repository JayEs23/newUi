<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Ordertypes extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	 }
	 
	function GetOrdertypes()
	{
		$sql = "SELECT * FROM ordertypes ORDER BY ordertype";											

		$query = $this->db->query(stripslashes($sql));	

		$results = $query->result_array();		

		if ($results)
		{
			$data=array();

			if (is_array($results))
			{
				$sn=0;
				
				foreach($results as $row):
					$sn++; $sel=''; $del=''; $sta='Disable';
					
					if ($row['status']==1) $sta='Active';
					
					$sel='<img onClick="SelectRow(\''.$row['ordertype'].'\',\''.$row['description'].'\',\''.$row['status'].'\',\''.$row['id'].'\')" style="cursor:pointer; height:30px; " src="'.base_url().'images/pencil_icon.png" title="Edit The Order Type, '.strtoupper(trim($row['description'])).'">';
					
										
					if ($_SESSION['DeleteItem']==1)
					{
						$del='<img onClick="DeleteRow(\''.$row['ordertype'].'\',\''.$row['description'].'\',\''.$row['status'].'\',\''.$row['id'].'\')" style="cursor:pointer; height:30px;" src="'.base_url().'images/delete_icon.png" title="Delete The Order Type '.strtoupper(trim($row['description'])).'">';	
					}
					
					$tp=array($sel,$del,$row['ordertype'],$row['description'],$sta);
					
					$data[]=$tp;
				endforeach;
			}

			print_r(json_encode($data));
		}else
		{
			print_r(json_encode($results));
		}
	}
	
	function AddOrdertype()
	{
		$ordertype=''; $description=''; $status='0';
		
		if ($this->input->post('ordertype')) $ordertype = strtoupper(trim($this->input->post('ordertype')));
		if ($this->input->post('description')) $description = trim($this->input->post('description'));
		if ($this->input->post('status')) $status = trim($this->input->post('status'));
								
		//Check if record exists
		$sql = "SELECT * FROM ordertypes WHERE (TRIM(ordertype)='".$this->db->escape_str($ordertype)."')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 )
		{
			$m = 'Addition of order type record was NOT successful. The order type code record exists in the database.';
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			$sql = "SELECT * FROM ordertypes WHERE (TRIM(description)='".$this->db->escape_str($description)."')";
		
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0 )
			{
				$m = 'Addition of order type record was NOT successful. The order type description record exists in the database.';
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{
				$this->db->trans_start();
				
				$dat=array(
					'ordertype' 	=> $this->db->escape_str($ordertype),
					'description' 	=> $this->db->escape_str($description),
					'status' 		=> $this->db->escape_str($status)				
					);
				
				$this->db->insert('ordertypes', $dat);
				
				$this->db->trans_complete();
				
				$Msg='';	
				
				if ($this->db->trans_status() === FALSE)
				{					
					$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted adding order type record but failed.";
					$m = 'Order Type Record Was Not Added.';
					$ret=array('status'=>'FAIL','Message'=>$m);
				}else
				{					
					$Msg="Order Type Record Was Added Successfully.";				
					
					$ret=array('status'=>'OK','Message'=>'');
				}
				
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'ADDED ORDER TYPE RECORD',$_SESSION['LogID']);	
			}				
		}
				
		echo json_encode($ret);
	}
	
	function EditOrdertype()
	{
		$ordertype=''; $description=''; $status='0'; $Id = '';
		
		if ($this->input->post('ordertype')) $ordertype = strtoupper(trim($this->input->post('ordertype')));
		if ($this->input->post('description')) $description = $description = trim($this->input->post('description'));
		if ($this->input->post('status')) $status = trim($this->input->post('status'));
		if ($this->input->post('id')) $Id = trim($this->input->post('id'));
		
		
		//Check if record exists		
		$sql = "SELECT * FROM ordertypes WHERE (id=".$this->db->escape_str($Id).")";

		$query = $this->db->query($sql);
					
		if ($query->num_rows() == 0 )
		{
			$m = 'Could Not Edit Order Type Record. Record ID Does Not Exist.';
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			$cd=''; $des=''; $sta='';
			
			$row = $query->row();			
			
			if ($row->ordertype) $cd=trim($row->ordertype);
			if ($row->description) $des=trim($row->description);
			if ($row->status) $sta=trim($row->status);
						
			$OldValues="Order Type Code = ".$cd."; Order Type Description = ".$des."; Order Type Status = ".$sta;			
			$NewValues="Order Type Code = ".$ordertype."; Order Type Description = ".$description."; Order Type Status = ".$status;
			
			$dat=array(
				'ordertype' 	=> $this->db->escape_str($ordertype),
				'description' 	=> $this->db->escape_str($description),
				'status' 		=> $this->db->escape_str($status)
			);
			
			#Edit
			$this->db->trans_start();
			$this->db->where(array('id' => $Id));
			$this->db->update('ordertypes', $dat);			
			$this->db->trans_complete();
						
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{					
				$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted editing order type but failed.";
				
				$m = 'Order Type Record Could Not Be Edited.';
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{				
				$Msg="Order type record has been edited successfully by ".strtoupper($_SESSION['fullname'].'('.$_SESSION['email'])."). Old Values => ".$OldValues.". Updated values => ".$NewValues;				
				
				$ret=array('status'=>'OK','Message'=>'');
								
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'EDITED ORDER TYPE RECORD',$_SESSION['LogID']);
			}			
		}
				
		echo json_encode($ret);
	}
	
	function DeleteOrderType()
	{
		$ordertype=''; $description=''; $id='';
		
		if ($this->input->post('id')) $id = trim($this->input->post('id'));
		if ($this->input->post('ordertype')) $ordertype = trim($this->input->post('ordertype'));
		if ($this->input->post('description')) $description = trim($this->input->post('description'));
		
		//Check if record exists		
		$sql = "SELECT * FROM ordertypes WHERE (id=".$this->db->escape_str($id).")";
		
		$query = $this->db->query($sql);
					
		if ($query->num_rows() > 0 )
		{
			$row = $query->row();
			
			$this->db->trans_start();
			$this->db->delete('ordertypes', array('id' => $id)); 				
			$this->db->trans_complete();
			
			$sql = "SELECT * FROM ordertypes";		
			$qry = $this->db->query($sql);			
			$rowcount=$qry->num_rows();		
						
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{
				$Msg=$_SESSION['email'].'('.$_SESSION['fullname'].") attempted deleting order type record but failed.";
				
				$ret=array('status'=>'FAIL','Message'=>'Order Type Record Could Not Be Deleted.','rowcount'=>$rowcount);
			}else
			{
				$Msg="Order type record has been deleted successfully by ".strtoupper($_SESSION['email'].'('.$_SESSION['fullname']).").";
				
				$ret=array('status'=>'OK','Message'=>'','rowcount'=>$rowcount);
				
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],$_SESSION['LogIn'],$_SESSION['RemoteIP'],$_SESSION['RemoteHost'],'DELETED ORDER TYPE RECORD',$_SESSION['LogID']);
			}
		}else
		{
			$ret=array('status'=>'FAIL','Message'=>'Could Not Delete Order Type Record. Record Does Not Exist.','rowcount'=>$rowcount);
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
				
			$this->load->view('admin/ordertypes_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
