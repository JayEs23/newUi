<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Publicholidays extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	 }
	 
	public function GetHolidays()
	{
		$sql = "SELECT * FROM public_holidays ORDER BY holidaydate";											

		$query = $this->db->query(stripslashes($sql));	

		$results = $query->result_array();		

		if ($results)
		{
			$data=array();

			if (is_array($results))
			{
				$sn=0;
				
				foreach($results as $row):
					$sn++; $sel=''; $del=''; $dt='';
					
					if ($row['holidaydate'] <> '0000-00-00') $dt=date('d M Y',strtotime($row['holidaydate']));
					
					$sel='<img onClick="SelectRow(\''.$row['holiday'].'\',\''.$dt.'\',\''.$row['id'].'\')" style="cursor:pointer; height:30px; " src="'.base_url().'images/pencil_icon.png" title="Edit '.strtoupper(trim($row['holiday'])).'\'s Record">';

//company,address,state,email,phone,incorporationdate,broker_id,accountstatus,pwd,id
					
										
					if ($_SESSION['DeleteItem']==1)
					{
						$del='<img onClick="DeleteRow(\''.$row['holiday'].'\',\''.$row['holidaydate'].'\',\''.$row['id'].'\')" style="cursor:pointer; height:30px;" src="'.base_url().'images/delete_icon.png" title="Delete '.strtoupper(trim($row['holiday'])).'\'s Record">';	
					}
					
					
					
					$tp=array($sel,$del,$row['holiday'],$dt);
					
					$data[]=$tp;
				endforeach;
			}

			print_r(json_encode($data));
		}else
		{
			print_r(json_encode($results));
		}
	}
	
	public function AddHoliday()
	{
		$holiday=''; $holidaydate='';
		
		if ($this->input->post('holiday')) $holiday = trim($this->input->post('holiday'));
		if ($this->input->post('holidaydate')) $holidaydate = trim($this->input->post('holidaydate'));
		
		$date_created=date('Y-m-d H:i:s');
								
		//Check if record exists
		$sql = "SELECT * FROM public_holidays WHERE (DATE_FORMAT(holidaydate,'%Y-%m-%d')='".$this->db->escape_str($holidaydate)."')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 )
		{
			$m = "Creation of public holiday record was NOT successful. Public holiday date (<b>".date('d M Y',strtotime($holidaydate))."</b>) exists in the database.";
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			$this->db->trans_start();
				
				$dat=array(
					'holiday' 		=> $this->db->escape_str($holiday),
					'holidaydate'	=> $this->db->escape_str($holidaydate)				
					);
				
				$this->db->insert('public_holidays', $dat);
				
				$this->db->trans_complete();
				
				$Msg='';	
				
				if ($this->db->trans_status() === FALSE)
				{					
					$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted creating public holiday record but failed.";
					$m = "Public Holiday Record Was Not Created.";
					$ret=array('status'=>'FAIL','Message'=>$m);					
				}else
				{
					$Msg="Public Holiday Record Was Created Successfully.";				
					
					$ret=array('status'=>'OK','Message'=>'');
					
					$m="CREATED PUBLIC HOLIDAY RECORD";
					
					$remote_ip=$_SERVER['REMOTE_ADDR'];
					$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
					$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,$m,$_SESSION['LogID']);		
				}
		}
				
		echo json_encode($ret);
	}
	
	public function EditHoliday()
	{
		$holiday=''; $holidaydate=''; $Id = '';
		
		if ($this->input->post('holiday')) $holiday = trim($this->input->post('holiday'));
		if ($this->input->post('holidaydate')) $holidaydate = trim($this->input->post('holidaydate'));
		if ($this->input->post('id')) $Id = trim($this->input->post('id'));		
		
		//Check if record exists		
		$sql = "SELECT * FROM public_holidays WHERE (id=".$this->db->escape_str($Id).")";

		$query = $this->db->query($sql);
					
		if ($query->num_rows() == 0 )
		{
			$m = "Could Not Edit Public Holiday Record. Record ID Does Not Exist.";
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			$ph=''; $dt='';
		
			$row = $query->row();			
			
			if ($row->holiday) $ph=trim($row->holiday);
			if ($row->holidaydate) $dt=trim($row->holidaydate);
						
			$OldValues="Public Holiday = ".$ph."; Public Holiday Date = ".$dt;			
			$NewValues="Public Holiday = ".$holiday."; Public Holiday Date = ".$holidaydate;
			
			$dat=array(
				'holiday' 		=> $this->db->escape_str($holiday),
				'holidaydate' 	=> $this->db->escape_str($holidaydate)
			);
			
			//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($dat,true)); fclose($file);
			
			#Edit
			$this->db->trans_start();
			$this->db->where(array('id' => $Id));
			$this->db->update('public_holidays', $dat);			
			$this->db->trans_complete();
						
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{					
				$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted editing public holiday record but failed.";
				
				$m = "Public Holiday Record Could Not Be Edited.";
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{
				$Msg="Public holiday record has been edited successfully by ".strtoupper($_SESSION['fullname'].'('.$_SESSION['email'])."). Old Values => ".$OldValues.". Updated values => ".$NewValues;				
				
				$ret=array('status'=>'OK','Message'=>'');
								
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,"EDITED PUBLIC HOLIDAY RECORD",$_SESSION['LogID']);
			}			
		}
				
		echo json_encode($ret);
	}
	
	public function DeleteHoliday()
	{
		$holiday=''; $holidaydate=''; $id=''; $email='';
		
		if ($this->input->post('id')) $id = trim($this->input->post('id'));
		if ($this->input->post('holiday')) $holiday = trim($this->input->post('holiday'));
		if ($this->input->post('holidaydate')) $holidaydate = trim($this->input->post('holidaydate'));
		
		//Check if record exists		
		$sql = "SELECT * FROM public_holidays WHERE (id=".$this->db->escape_str($id).")";
		
		$query = $this->db->query($sql);
					
		if ($query->num_rows() > 0 )
		{
			$row = $query->row();
			
			if ($row->email) $email=trim($row->email);
			
			$this->db->trans_start();
			$this->db->delete('public_holidays', array('id' => $id)); 				
			$this->db->trans_complete();
			
			$sql = "SELECT * FROM public_holidays";		
			$qry = $this->db->query($sql);			
			$rowcount=$qry->num_rows();		
						
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{
				$Msg=$_SESSION['email'].'('.$_SESSION['fullname'].") attempted deleting public holiday record but failed.";
				
				$ret=array('status'=>'FAIL','Message'=>"Public Holiday Record Could Not Be Deleted.");
			}else
			{
				$Msg="Public holiday record has been deleted successfully by ".strtoupper($_SESSION['email'].'('.$_SESSION['fullname']).").";
				
				$ret=array('status'=>'OK','Message'=>'');
				
				$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],$_SESSION['LogIn'],$_SESSION['RemoteIP'],$_SESSION['RemoteHost'],"DELETED PUBLIC HOLIDAY RECORD",$_SESSION['LogID']);
			}
		}else
		{
			$ret=array('status'=>'FAIL','Message'=>"Could Not Delete Public Holiday Record. Record Does Not Exist.");
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
			
			$this->load->view('admin/publicholidays_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
