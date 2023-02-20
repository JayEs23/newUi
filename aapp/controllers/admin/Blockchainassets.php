<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('assets/vendor/autoload.php');

class Blockchainassets extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	 }
	 
	function GetAssets()
	{
		$results=$this->getdata_model->GetBlockchainAssets();
		// print_r(json_encode($results)); die;
		
		if ($results['status']==1)
		{
			$datas=$results['data'];
			
			$rows=$this->getdata_model->GetAllApprovedAssets();
			
			$assets=array(); $pixs=array();
			
			foreach($rows as $rw):
				if ($rw['art_id'])
				{
					$assets[]=$rw['art_id'];
					$pixs[$rw['art_id']]=$rw['art_pix1'];
				}
			endforeach;

			//$file = fopen('bbb.txt',"w"); fwrite($file,print_r($assets,true)); fclose($file);

			foreach($datas as $row):
				
				if (in_array($row['ArtId'], $assets))
				{
					$sel=''; $pix=''; $p='';
					
					if ($pixs[$row['ArtId']])
					{
						$f = base_url().'art-works/thumbs/t_'.$pixs[$row['ArtId']];
						$p = base_url().'art-works/'.$pixs[$row['ArtId']];
						
						$pix='<img style="height:60px; width:90%; border-radius:4px;" src="'.$f.'" title="'.strtoupper(trim($row['Title'])).'">';
						
						//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($f."\r\n",true)); fclose($file);
					}
					
					$issuer = $this->getdata_model->GetIssuerNameWithBlockchainAddress($row['IssuerAddress']);
					$asset  = $this->getdata_model->GetAssetFromId($row['ArtId']);
					
					$sel='<img onClick="ViewRow(\''.$row['ArtId'].'\',\''.$row['Description'].'\',\''.$row['Symbol'].'\',\''.$row['numberOfTokens'].'\',\''.$row['PricePerToken'].'\',\''.$issuer->user_name.'\',\''.$row['Artist'].'\',\''.$row['Title'].'\',\''.date('d M Y',strtotime($asset->approvaldate)).'\',\''.$row['TokensForSale'].'\',\''.date_format(date_create($row['CreationYear']),'Y').'\',\''.$row['ArtValue'].'\',\''.$p.'\',\''.$asset->blockchainUrl.'\')" style="cursor:pointer; height:30px; " src="'.base_url().'images/view_icon.png" title="View '.strtoupper(trim($row['Title'])).'\'s Blockchain Record">';
										
					$tp=array($pix, ucwords(strtolower($row['Title']).' ('.date_format(date_create($row['CreationYear']),'Y').')'),$row['Symbol'],ucwords(strtolower($row['Artist'])),number_format($row['ArtValue'],2),number_format($row['numberOfTokens'],0),number_format($row['TokensForSale'],0),number_format($row['PricePerToken'],2),$sel);
					
					$data[]=$tp;	
				}				
			endforeach;		

			print_r(json_encode($data));
		}elseif (trim(strtolower($results['status'])) == 'error')
		{
			print_r(json_encode(array()));
		}
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
			
			$this->load->view('admin/blockchainassets_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
