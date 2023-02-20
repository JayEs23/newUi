<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Deletelogs extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	 }
	 
	
	function LoadUsers()
	{
		$result=$this->getdata_model->GetLogUsers();
		echo json_encode($result);
	}	
	
	function Delete()
	{
		$users=''; $fromdate=''; $todate = '';	

		if ($this->input->post('users')) $users = $this->input->post('users');
		if ($this->input->post('fromdate')) $fromdate = $this->input->post('fromdate');
		if ($this->input->post('todate')) $todate = $this->input->post('todate');		

		$Msg=''; $crit='';		

		if ((trim($users) != '') && (trim(strtoupper($users))!= "ALL"))
		{
			$arr=explode(',',$users);			

			if (count($arr)>0)
			{
				$u='';				

				for($i=0; $i<count($arr); $i++):
					if ($arr[$i])
					{
						$arr[$i]=trim($arr[$i]);
						if ($u == '') $u="'".$arr[$i]."'"; else $u .= ",'".$arr[$i]."'";
					}
				endfor;
			}
		}		

		if ($u) $crit = " (Username IN (". $u . "))";				

		//Check if record exists
		$sql = "SELECT * FROM loginfo WHERE (DATE_FORMAT(ActionDate,'%Y-%m-%d') BETWEEN '".$fromdate."' AND '".$todate."')";		

		if (trim($crit)!='') $sql .= " AND ".$crit;		

		$query = $this->db->query($sql);					

		if ($query->num_rows() > 0 )
		{
			$qry = "DELETE FROM loginfo WHERE (DATE_FORMAT(ActionDate,'%Y-%m-%d') BETWEEN '".$fromdate."' AND '".$todate."')";			

			if (trim($crit)!='') $qry .= " AND ".$crit;		

			$this->db->query($qry);			

			$pd='';			

			if (trim($fromdate) == trim($todate))
			{
				$pd=" for ".$fromdate;
			}else
			{
				$pd=" from ".$fromdate." to ".$todate;
			}

			$Msg="User '".$_SESSION['fullname']."(".$_SESSION['email'].")' deleted log records ".$pd." successfully.";		

			$ret = 'OK';			

			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);		

			$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,'DELETED LOG RECORDS',$_SESSION['LogID']);
		}else
		{
			$ret = 'No Log Records To Delete.';
		}	

		echo $ret;	
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
			
			$this->load->view('admin/deletelogs_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
