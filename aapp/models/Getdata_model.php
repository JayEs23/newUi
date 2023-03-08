<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_STRICT);

date_default_timezone_set('Africa/Lagos');
set_time_limit(0);

require 'phpmailer/class.phpmailer.php';
require 'phpmailer/class.smtp.php';
include('imageresize/lib/ImageResize.php');
include("email_validator.php");
require_once('SimpleImage.php');

class Getdata_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
	}
	
	
	function GoToLogin($source)
	{
		$host=strtolower(trim($_SERVER['HTTP_HOST']));
		
		if (strtolower(trim($source)) == 'admin')
		{
			if ($host=='localhost')
			{
				echo '<script>window.location.replace("http://localhost/lvi/admin/Signin");</script>';
			}else
			{
				echo '<script>window.location.replace("https://derivedhomes.name/ui/Signin");</script>';
			}	
		}else
		{
			if ($host=='localhost')
			{
				echo '<script>window.location.replace("http://localhost/lvi/ui/Home");</script>';
			}else
			{
				echo '<script>window.location.replace("http://derivedhomes.name/ui/Home");</script>';
			}	

		}		
	}
	
	function GetBlockchainUserID()
	{		
		$max=0;
		
		//investors
		$sql="SELECT MAX(userId) AS userId FROM investors";
			
		$query = $this->db->query($sql);
				
		if ( $query->num_rows() > 0 )
		{
			$row = $query->row();			
			if (intval($row) > 0)
			{
				if (intval($row->userId) > intval($max)) $max = $row->userId;
			}
		}
		
		//brokers
		$sql="SELECT MAX(userId) AS userId FROM brokers";
			
		$query = $this->db->query($sql);
				
		if ( $query->num_rows() > 0 )
		{
			$row = $query->row();	
					
			if (intval($row) > 0)
			{
				if (intval($row->userId) > intval($max)) $max = $row->userId;
			}
		}
		
		//issuers
		$sql="SELECT MAX(userId) AS userId FROM issuers";
			
		$query = $this->db->query($sql);
				
		if ( $query->num_rows() > 0 )
		{
			$row = $query->row();	
					
			if (intval($row) > 0)
			{
				if (intval($row->userId) > intval($max)) $max = $row->userId;
			}
		}
		
		//settings
		$sql="SELECT MAX(userId) AS userId FROM settings";
			
		$query = $this->db->query($sql);
				
		if ( $query->num_rows() > 0 )
		{
			$row = $query->row();	
					
			if (intval($row) > 0)
			{
				if (intval($row->userId) > intval($max)) $max = $row->userId;
			}
		}
		
		$max += 1;
		
		if ($max==30) $max=31;
		
		return $max;
	}
	
	function ConvertTimespanToDate($tm)
	{
		if (strlen($tm)==10)//Seconds
		{
			return date('Y-m-d H:i:s',$tm);
		}elseif (strlen($tm)==13)//Milliseconds
		{
			return date('Y-m-d H:i:s',$tm/1000);
		}
	}
	
	function GetAllRegisteredUsers()
	{
		$uids=array();
		
		//investors
		$sql="SELECT userId FROM investors";
			
		$query = $this->db->query($sql);
				
		if ( $query->num_rows() > 0 )
		{
			$rows=$query->result_array();
			
			foreach($rows as $rw):
				if ($rw['userId']) $uids[]=$rw['userId'];
			endforeach;
		}
		
		//brokers
		$sql="SELECT userId FROM brokers";
			
		$query = $this->db->query($sql);
				
		if ( $query->num_rows() > 0 )
		{
			$rows=$query->result_array();
			
			foreach($rows as $rw):
				if ($rw['userId']) $uids[]=$rw['userId'];
			endforeach;
		}
		
		//issuers
		$sql="SELECT userId FROM issuers";
			
		$query = $this->db->query($sql);
				
		if ( $query->num_rows() > 0 )
		{
			$rows=$query->result_array();
			
			foreach($rows as $rw):
				if ($rw['userId']) $uids[]=$rw['userId'];
			endforeach;
		}
		
		//settings
		$sql="SELECT userId FROM settings";
			
		$query = $this->db->query($sql);
				
		if ( $query->num_rows() > 0 )
		{
			$rows=$query->result_array();
			
			foreach($rows as $rw):
				if ($rw['userId']) $uids[]=$rw['userId'];
			endforeach;
		}
		
		return $uids;
	}
	
	function GetAllApprovedAssets()
	{
		$sql="SELECT * FROM art_works WHERE (TRIM(listing_status)='Listed')";
		
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	
	function GetAssetFromId($ArtId)
	{
		$sql="SELECT * FROM art_works WHERE (TRIM(art_id)='".$this->db->escape_str($ArtId)."')";
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
	
		return $row;
	}
	
	function GetIssuerNameWithBlockchainAddress($address)
	{
		$sql="SELECT * FROM issuers WHERE (TRIM(blockchain_address)='".$this->db->escape_str($address)."')";
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		//if ($row->user_name) $t=trim($row->user_name);
	
		return $row;
	}

	/////////////////////////////////////////  BLOCKCHAIN APIS ////////////////////////////////////////
	
		
	function GetAllBlockchainUsers()
	{
		$token=''; $baseurl='';
		
		$page = 0;
		$limit = 10;
		
		$settings=$this->GetParamaters();//Get Settings
		
		if ($settings->blockchain_token) $token=trim($settings->blockchain_token);
		if ($settings->blockchain_baseurl) $baseurl=trim($settings->blockchain_baseurl);
				
		if ($baseurl[strlen($baseurl)-1] <> '/') $baseurl .='/'; 		
		$url=$baseurl."user/allusers?page=".$page."&limit=".$limit; 
		$header=array('api-key: '.$token,'Content-Type: application/json');		
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		$output = curl_exec($ch);

		// echo $output;
		
		curl_close($ch);
		
		$result = json_decode($output, true);
		// echo "<pre>";
		// print_r($result);
		// die();
		
		$ret=array();
		
		if (trim(strtolower($result['status'])) =='success')
		{			
			$data=$result['data'];
			
			if (isset($data) and (count($data)>0))
			{
				
				
				$items=$data;
		
				$i=0; $dat=array();
				
				foreach($items as $row):
					$i++; $userId=''; $email=''; $phoneNumber=''; $userName=''; $userType=''; $add='';
				
					if (isset($row['userId'])) $userId = $row['userId'];
					if (isset($row['email'])) $email = $row['email']; 
					if (isset($row['phone'])) $phoneNumber = $row['phone'];
					if (isset($row['userName'])) $userName = $row['userName'];
					$add = isset($row['ethereumAddress']) ? $row['ethereumAddress'] : $row['blockchainAddress'];	
					if (isset($row['userType']))
					{
						if (intval($row['userType'])==0) $userType = 'Investor';
						if (intval($row['userType'])==1) $userType = 'Admin';
						if (intval($row['userType'])==2) $userType = 'Issuer';
						if (intval($row['userType'])==3) $userType = 'Broker';
					}			 
				
					$dat[]=array('UserId'=>$userId,'Email'=>$email,'Phone'=>$phoneNumber, 'UserName'=>$userName, 'UserType'=>$userType, 'BlockchainAddress'=>$add);

				endforeach;
				
				$ret=array('status'=>1,'data'=>$dat);
			}else
			{
				$ret=array('status'=>"Error", 'message'=>'No User Record');
			}
		}else
		{
			$data=$result['data'];
			
			$statusCode=$data['statusCode'];
			$timestamp = str_replace('T',' ',substr($data['timestamp'],0,19));
			$path = $data['path'];
			$error = $data['error'];
			
			$ret=array('status'=>'Error', 'code'=>$statusCode, 'message'=>$error, 'datetime'=>$timestamp, 'path'=>$path);
		}
		
		return $ret;
	}
	
	function GetBlockchainUsersByRole($role)
	{
		$token=''; $baseurl='';
		
		$settings=$this->GetParamaters();//Get Settings
		
		if ($settings->blockchain_token) $token=trim($settings->blockchain_token);
		if ($settings->blockchain_baseurl) $baseurl=trim($settings->blockchain_baseurl);
				
		if ($baseurl[strlen($baseurl)-1] <> '/') $baseurl .='/'; 		
		
		$url=$baseurl."user/users-by-role/".$role;
		$header=array('api-key: '.$token,'Content-Type: application/json');		
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		$output = curl_exec($ch);
		
		curl_close($ch);
		
		$result = json_decode($output, true);
		
		$ret=array();
		
		if (count($result) > 0)
		{			
			$data=$result;
			
			if (count($data)>0)
			{				
				$i=0; $dat=array();
				
				foreach($data as $row):
					$i++; $userId=''; $email=''; $phoneNumber=''; $userName=''; $userType=''; $add='';
				
					if (isset($row['userId'])) $userId = $row['userId'];
					if (isset($row['email'])) $email = $row['email']; 
					if (isset($row['phone'])) $phoneNumber = $row['phone'];
					if (isset($row['userName'])) $userName = $row['userName'];
					if (isset($row['ethereumAddress'])) $add = $row['ethereumAddress'];	
					if (isset($row['userType']))
					{
						if (intval($row['userType'])==0) $userType = 'Investor';
						if (intval($row['userType'])==1) $userType = 'Admin';
						if (intval($row['userType'])==2) $userType = 'Issuer';
						if (intval($row['userType'])==3) $userType = 'Broker';
					}			 
				
					$dat[]=array('UserId'=>$userId,'Email'=>$email,'Phone'=>$phoneNumber, 'UserName'=>$userName, 'UserType'=>$userType, 'BlockchainAddress'=>$add);

				endforeach;
				
				$ret=array('status'=>1,'data'=>$dat);
			}else
			{
				$ret=array('status'=>"Error", 'message'=>'No User Record');
			}
		}else
		{
			$data=$result['data'];
			
			$statusCode=$data['statusCode'];
			$timestamp = str_replace('T',' ',substr($data['timestamp'],0,19));
			$path = $data['path'];
			$error = $data['error'];
			
			$ret=array('status'=>'Error', 'code'=>$statusCode, 'message'=>$error, 'datetime'=>$timestamp, 'path'=>$path);
		}
		
		return $ret;
	}
	
	function GetBlockchainAssets()
	{
		$token=''; $baseurl='';
		
		$page = 0;
		$limit = 200;
		
		$settings=$this->GetParamaters();//Get Settings
		
		if ($settings->blockchain_token) $token=trim($settings->blockchain_token);
		if ($settings->blockchain_baseurl) $baseurl=trim($settings->blockchain_baseurl);
				
		if ($baseurl[strlen($baseurl)-1] <> '/') $baseurl .='/'; 		
		$url=$baseurl.'asset/all-assets?page='.$page.'&limit='.$limit;
		$header=array('api-key: '.$token,'Content-Type: application/json');		
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		$output = curl_exec($ch);
		
		curl_close($ch);

		// print_r($output); die();
		$result = json_decode($output, true);


		
		$ret=array();
		
		if (trim(strtolower($result['status'])) =='success')
		{			
			$data=$result['data'];
			
			if (isset($result['data']) and (count($result['data'])>0))
			{
				$items=$result['data'];
		
				$i=0; $dat=array();
				
				foreach($items as $row):
					$i++; $id=''; $brokerId=''; $createdOn=''; $issuerId=''; $issuer=''; $tokenId=''; $value='';
					$creationYear=''; $description=''; $symbol=''; $artistName=''; $titleOfWork=''; $owner='';
					$issuingPrice=''; $totalSupply=''; $commission=''; $price=''; $sharesAvailable=''; $market='';
					$nameOfOwners=''; $sharesContract=''; $approved=''; $imageUrl=''; $marketPrice=''; 
					$listImmediately='';									
				
					if ($row['_id']) $id = $row['_id'];
					if ($row['brokerId']) $brokerId = $row['brokerId'];
					if ($row['createdAt']) $createdOn = $this->ConvertTimespanToDate($row['createdAt']);
					if ($row['issuerId']) $issuerId = trim($row['issuerId']);
					if ($row['issuer']) $issuer = trim($row['issuer']); //Issuer Blockchain Address
					if ($row['artId']) $tokenId = $row['artId']; //Asset Id
					if ($row['artDescription']) $description = trim($row['artDescription']);
					if ($row['artSymbol']) $symbol = trim($row['artSymbol']);
					if ($row['artistName']) $artistName = trim($row['artistName']);
					if ($row['artTitle']) $titleOfWork = trim($row['artTitle']);
					if ($row['pricePerToken']) $issuingPrice = $row['pricePerToken'];
					if ($row['numberOftokens']) $totalSupply = $row['numberOftokens'];
					if ($row['commission']) $commission = $row['commission'];
					if ($row['price']) $price = $row['price'];
					if ($row['artValue']) $value = $row['artValue'];
					if ($row['numberOfTokensForSale']) $sharesAvailable = $row['numberOfTokensForSale'];
					if ($row['nameOfOwners']) $nameOfOwners = trim($row['nameOfOwners']);
					if ($row['owner']) $owner = trim($row['owner']);
					if ($row['sharesContract']) $sharesContract = trim($row['sharesContract']);
					if ($row['approved']) $approved = $row['approved'];
					if ($row['imageUrl']) $imageUrl = trim($row['artPicture']);
					if ($row['market']) $market = trim($row['market']);
					if ($row['marketPrice']) $marketPrice = trim($row['marketPrice']);
					if ($row['listImmediately']) $listImmediately = trim($row['listImmediately']);
					if ($row['artCreationYear']) $creationYear = trim($row['artCreationYear']);				 
				
					$dat[]=array(
						'CreatedOn'=>$createdOn,
						'IssuerAddress'=>$issuer,
						'Title'=>$titleOfWork, 
						'ArtId'=>$tokenId, 
						'Description'=>$description, 'Symbol'=>$symbol, 
						"Artist"=>$artistName, 
						"CreationYear"=>$creationYear, 
						"ArtValue"=>$value, 
						"Picture"=>$imageUrl, 
						"PricePerToken"=>$issuingPrice,
						"numberOfTokens"=>$totalSupply, 
						"TokensForSale"=>intval($sharesAvailable)
					);

				endforeach;
				
				$ret=array('status'=>1,'data'=>$dat);
			}else
			{
				$ret=array('status'=>"Error", 'message'=>'No Asset Record');
			}
		}else
		{
			$data=$result['data'];
			
			$statusCode=$data['statusCode'];
			$timestamp = str_replace('T',' ',substr($data['timestamp'],0,19));
			$path = $data['path'];
			$error = $data['error'];
			
			$ret=array('status'=>'Error', 'code'=>$statusCode, 'message'=>$error, 'datetime'=>$timestamp, 'path'=>$path);
		}		

		return $ret;
	}
	
	function CreateUserRecordOnBlockchain($email,$phone,$userName,$userType)
	{
		$userId=$this->GetBlockchainUserID();

		$type = ['Investor'=> 0, 'Admin' => 1,'Issuer' => 2,'Broker' => 3];
		$uType = $type[$userType];
		$usr = array("userId"=>$userId, "email"=>$email, "phone"=>$phone, "userType"=>$uType, "userName"=>$userName);
		
		
		return $this->CreateUserOnBlockchain($usr);		
	}
	
	function CreateUserOnBlockchain($fields)
	{
		$token=''; $baseurl='';
		
		$settings=$this->GetParamaters();//Get Settings
		
		if ($settings->blockchain_token) $token=trim($settings->blockchain_token);
		if ($settings->blockchain_baseurl) $baseurl=trim($settings->blockchain_baseurl);
				
		if ($baseurl[strlen($baseurl)-1] <> '/') $baseurl .='/'; 		
		$url=$baseurl."user";
		$header=array('api-key: '.$token,'Content-Type: application/json');		
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		$output = curl_exec($ch);
		
		curl_close($ch);
		
		$result = json_decode($output, true);
		// print_r($result);
		// die();
		
		$ret=array();
		
		if (trim(strtolower($result['blockchainAddress'])) !='')
		{
			$uid=''; $em=''; $ph=''; $ut=''; $nm=''; $add='';
			
			$data=$result;
			// echo $data['userType'];
			
			$type = ['0'=>'Investor','1'=>'Admin','2'=>'Issuer','3'=>'Broker'];
			
			$uType = $type[strval($data['userType'])];

			if ($data['userId']) $uid = trim($data['userId']);
			if ($data['email']) $em = trim($data['email']);
			if ($data['phone']) $ph = trim($data['phone']);
			if ($data['userName']) $nm = trim($data['userName']);
			//if (strval($data['userType'])) 
			$ut = trim($uType);
			if ($data['blockchainAddress']) $add = trim($data['blockchainAddress']);
			
			$ret=array('status'=>1,'userId'=>$uid, 'email'=>$em, 'phone'=>$ph, 'userName'=>$nm, 'userType'=>$ut, 'blockchainAddress'=>$add);
			// print_r($data);
			// die();
		}else
		{
			$data=$result['data'];
			
			$statusCode=$data['statusCode'];
			$timestamp = str_replace('T',' ',substr($data['timestamp'],0,19));
			$path = $data['path'];
			$error = $data['error'];
			
			$ret=array('status'=>'Error', 'code'=>$statusCode, 'message'=>$error, 'datetime'=>$timestamp, 'path'=>$path);
		}
		
		return $ret;
	}
	
	function CreateAssetOnBlockchain($fields)
	{
		$token=''; $baseurl='';
		
		//Get Settings
		$settings=$this->GetParamaters();
		
		if ($settings->blockchain_token) $token=trim($settings->blockchain_token);
		if ($settings->blockchain_baseurl) $baseurl=trim($settings->blockchain_baseurl);
				
		if ($baseurl[strlen($baseurl)-1] <> '/') $baseurl .='/'; 		
		$url=$baseurl."asset";
		$header=array('api-key: '.$token,'Content-Type: application/json');		
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		$output = curl_exec($ch);
		
		curl_close($ch);
		
		$result = json_decode($output, true);
		
		$ret=array();
		
		if (trim(strtolower($result['status'])) =='success')
		{
			$anm=''; $aid=-1; $tit=''; $sym=''; $desc=''; $yr=''; $val=0; $pix=''; $pr=0; $tok=0; $toksal=0;
			$em=''; $url='';	
			
			$data=$result['data'];
			
			if ($data['artId']) $aid = $data['artId'];	
			if ($data['artistName']) $anm = trim($data['artistName']);
			if ($data['artTitle']) $tit = trim($data['artTitle']);	
			if ($data['artSymbol']) $sym = trim($data['artSymbol']);	
			if ($data['artDescription']) $desc = trim($data['artDescription']);	
			if ($data['artCreationYear']) $yr = trim($data['artCreationYear']);	
			if ($data['artValue']) $val = $data['artValue'];
			if ($data['numberOfTokens']) $tok = trim($data['numberOfTokens']);
			if ($data['numberOfTokensForSale']) $toksal = trim($data['numberOfTokensForSale']);	
			if ($data['pricePerToken']) $pr = trim($data['pricePerToken']);					
			if ($data['artPicture']) $pix = trim($data['artPicture']);	
			if ($data['issuerEmail']) $em = trim($data['issuerEmail']);
			if ($data['blockchainUrl']) $url = trim($data['blockchainUrl']);
			
			$ret=array('status'=>1,'artId'=>$aid, 'artistName'=>$anm, 'artTitle'=>$tit, 'artSymbol'=>$sym, 'artDescription'=>$desc, 'artCreationYear'=>$yr, 'artValue'=>$val, 'numberOfTokens'=>$tok, 'numberOfTokensForSale'=>$toksal, 'pricePerToken'=>$pr, 'artPicture'=>$pix, 'issuerEmail'=>$em, 'blockchainUrl'=>$url);
		}else
		{
			$data=$result['data'];
			
			$statusCode=$data['statusCode'];
			$timestamp = str_replace('T',' ',substr($data['timestamp'],0,19));//2020-11-06T11:25:27.572807Z	
			$path = $data['path'];
			$error = $data['error'];
			
			$ret=array('status'=>'Error', 'code'=>$statusCode, 'message'=>$error, 'datetime'=>$timestamp, 'path'=>$path);
		}
		
		return $ret;
	}
	function FundWalletOnBlockchain($email,$amount,$blockchain_address,$reference)
	{
		$token=''; $baseurl='';

		$fields = [
			'email' => $email,
			'amount' => $amount,
			'blockchainAddress' => $blockchain_address,
			'reference' => $reference
		];
		
		$settings=$this->GetParamaters();//Get Settings
		
		if ($settings->blockchain_token) $token=trim($settings->blockchain_token);
		if ($settings->blockchain_baseurl) $baseurl=trim($settings->blockchain_baseurl);
				
		if ($baseurl[strlen($baseurl)-1] <> '/') $baseurl .='/'; 		
		$url=$baseurl."trade/fund/address";
		$header=array('api-key: '.$token,'Content-Type: application/json');		
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		$output = curl_exec($ch);
		
		curl_close($ch);
		
		$result = json_decode($output, true);
		
		return true;		
	}

	function MakeTradeOnBlockchain($issuer_email,$issuer_address,$art_id,$token_amount,$investor_address,$investor_email) {
		$token=''; $baseurl='';

		
		$fields = [
			'investorAddress' => $investor_address,
			'tokenAmount' => $token_amount,
			'issuerAddress' => $issuer_address,
			'issuerEmail' => $issuer_email,
			'artId' => $art_id,
			'investorEmail' => $investor_email
		];
		
		$settings=$this->GetParamaters();//Get Settings
		
		if ($settings->blockchain_token) $token=trim($settings->blockchain_token);
		if ($settings->blockchain_baseurl) $baseurl=trim($settings->blockchain_baseurl);
				
		if ($baseurl[strlen($baseurl)-1] <> '/') $baseurl .='/'; 		
		$url=$baseurl."trade/buy/shares";
		$header=array('api-key: '.$token,'Content-Type: application/json');		
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		$output = curl_exec($ch);
		
		curl_close($ch);
		
		$result = json_decode($output, true);
		
		return true;		
	}
	
	///////////////////////////////////////// END BLOCKCHAIN APIS /////////////////////////////////////
	
	
	function GetLatestListings()
	{
		$sql = "SELECT *,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol) LIMIT 0,1) AS title,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol) LIMIT 0,1) AS creationyear,(SELECT artist FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol) LIMIT 0,1) AS artist,(SELECT artwork_value FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol) LIMIT 0,1) AS artwork_value FROM listed_artworks ORDER BY datelisted DESC LIMIT 12";

		$query = $this->db->query($sql);
			
		return $query->result();
	}
	
	function GetListingById($id)
	{
		$sql = "SELECT *,(SELECT blockchainUrl FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol) LIMIT 0,1) AS blockchainUrl,(SELECT art_pix1 FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol) LIMIT 0,1) AS pix,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol) LIMIT 0,1) AS title,(SELECT creationyear FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol) LIMIT 0,1) AS creationyear,(SELECT artist FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol) LIMIT 0,1) AS artist,(SELECT artwork_value FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol) LIMIT 0,1) AS artwork_value FROM listed_artworks ORDER BY datelisted DESC LIMIT 3";

		$query = $this->db->query($sql);
			
		return $query->result();
	}
	
	function ComputeDateTradeValue($dt)
	{
		$sql="SELECT symbol,num_tokens FROM trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d')='".$this->db->escape_str($dt)."') AND (tradestatus=1)";
		
		$query = $this->db->query($sql);
		
		$val=0;		
	
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
			foreach($results as $row):
				$price=0;
				
				if ($row['symbol'])
				{
					$price = floatval($this->GetCurrentSymbolPrice(trim($row['symbol'])));
					
					if (floatval($price)==0) $price=floatval($this->GetSymbolPrimaryMarketPrice(trim($row['symbol'])));
					
					$val += floatval($price) * floatval($row['num_tokens']);
				}
			endforeach;
		}
	
		return $val;
	}
	
	function ComputeTotalTradeValue()
	{
		$sql="SELECT symbol,tokens FROM portfolios";
		
		$query = $this->db->query($sql);
		
		$val=0;		
	
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
			foreach($results as $row):
				$price=0;
				
				if ($row['symbol'])
				{
					$price = floatval($this->GetCurrentSymbolPrice(trim($row['symbol'])));
					
					if (floatval($price)==0) $price=floatval($this->GetSymbolPrimaryMarketPrice(trim($row['symbol'])));
					
					$val += floatval($price) * floatval($row['tokens']);
				}
			endforeach;
		}
	
		return $val;
	}
	
	
	//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% ADMIN SUMMARY %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	function GetTotalAdminTradeOrders()
	{
		$sql="SELECT COUNT(order_id) AS Total FROM direct_orders WHERE (TRIM(orderstatus) IN ('Submitted', 'Active', 'Executed'))";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}
	
	function GetTotalAdminListedSecurities()
	{
		$sql="SELECT COUNT(symbol) AS Total FROM listed_artworks";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}
	
	function GetTotalAdminSecondaryTrades()
	{
		$sql="SELECT COUNT(trade_id) AS Total FROM trades WHERE tradestatus=1";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}
	
	function GetTotalAdminPrimaryTrades()
	{
		$sql="SELECT COUNT(trade_id) AS Total FROM primary_trades WHERE tradestatus=1";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}
		
	function GetTotalAdminSecondaryMarketSecurities()
	{
		$sql="SELECT COUNT(symbol) AS Total FROM daily_price";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}
	
	function GetTotalAdminPrimaryMarketSecurities()
	{
		$sql="SELECT COUNT(symbol) AS Total FROM primary_market WHERE (TRIM(listing_status)='Started')";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}
	
	function GetTotalAdminApprovedSecurities()
	{
		$sql="SELECT COUNT(symbol) AS Total FROM primary_market WHERE (TRIM(listing_status)='Started')";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}
	
	function GetTotalAdminListedSecuritiesAwaitingApproval()
	{
		$sql="SELECT COUNT(title) AS Total FROM art_works WHERE (TRIM(listing_status)='Awaiting Approval')";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}
		
	//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% END ADMIN SUMMARY %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	
	
	
	
	//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% BROKER SUMMARY %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	
	function GetTotalBrokerActiveInvestors($broker_id)
	{
		$sql="SELECT COUNT(email) AS Total FROM investors WHERE (TRIM(broker_id)='".$this->db->escape_str($broker_id)."') AND (accountstatus=1)";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}	
	
	function GetTotalBrokerSecondaryTradeOrders($broker_id)
	{
		$sql="SELECT COUNT(order_id) AS Total FROM direct_orders WHERE (TRIM(broker_id)='".$this->db->escape_str($broker_id)."') AND (TRIM(orderstatus) IN ('Submitted', 'Active', 'Executed'))";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}
	
	function GetTotalBrokerExecutedSecondaryTrades($broker_id)
	{
		$sql="SELECT COUNT(trade_id) AS Total FROM trades WHERE ((TRIM(sell_broker_id)='".$this->db->escape_str($broker_id)."') OR (TRIM(buy_broker_id)='".$this->db->escape_str($broker_id)."')) AND (tradestatus = 1)";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}
	
	function GetTotalBrokerExecutedPrimaryTrades($broker_id)
	{
		$sql="SELECT COUNT(trade_id) AS Total FROM primary_trades WHERE (TRIM(buy_broker_id)='".$this->db->escape_str($broker_id)."') AND (tradestatus = 1)";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}
	
	function GetTotalBrokerPersonalPortfolioValue($email)
	{
		$sql="SELECT symbol,tokens FROM portfolios WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
		
		$val=0;		
	
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
			foreach($results as $row):
				$price=0;
				
				if ($row['symbol'])
				{
					$price = floatval($this->GetCurrentSymbolPrice(trim($row['symbol'])));
					
					if (floatval($price)==0) $price=floatval($this->GetSymbolPrimaryMarketPrice(trim($row['symbol'])));
					
					$val += floatval($price) * floatval($row['tokens']);
				}
			endforeach;
		}
	
		return $val;
	}
	
	function GetTotalBrokerInvestorPortfolioValue($broker_id,$email)
	{
		$sql="SELECT symbol,tokens FROM portfolios WHERE (TRIM(broker_id)='".$this->db->escape_str($broker_id)."') AND (TRIM(email) <> '".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
		
		$val=0;		
	
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
			foreach($results as $row):
				$price=0;
				
				if ($row['symbol'])
				{
					$price = floatval($this->GetCurrentSymbolPrice(trim($row['symbol'])));
					
					if (floatval($price)==0) $price=floatval($this->GetSymbolPrimaryMarketPrice(trim($row['symbol'])));
					
					$val += floatval($price) * floatval($row['tokens']);
				}
			endforeach;
		}
	
		return $val;
	}

	
	//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% END BROKER SUMMARY %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	
	
	
	
	//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% INVESTOR SUMMARY %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	function GetTotalInvestorSecurities($email)
	{
		$sql="SELECT COUNT(symbol) AS Total FROM portfolios WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}	
	
	function GetTotalInvestorSecuritiesValue($email)
	{
		$sql="SELECT symbol,tokens FROM portfolios WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
		
		$val=0;		
	
		if ($query->num_rows() > 0)
		{
			$results = $query->result_array();
			
			foreach($results as $row):
				$price=0;
				
				if ($row['symbol'])
				{
					$price = floatval($this->GetCurrentSymbolPrice(trim($row['symbol'])));
					
					if (floatval($price)==0) $price=floatval($this->GetSymbolPrimaryMarketPrice(trim($row['symbol'])));
					
					$val += floatval($price) * floatval($row['tokens']);
				}
			endforeach;
		}
	
		return $val;
	}
	
	function GetTotalInvestorPrimaryTrades($email)
	{
		$sql="SELECT COUNT(trade_id) AS Total FROM primary_trades WHERE (TRIM(buy_investor_email)='".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}
	
	function GetTotalInvestorPrimaryTradesValue($email)
	{
		$sql="SELECT SUM(total_buyer_fee) AS Total FROM primary_trades WHERE (TRIM(buy_investor_email)='".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
		
		$val=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $val=trim($row->Total);
		}
	
		return $val;
	}
	
	function GetTotalInvestorSellOrders($email)
	{
		$sql="SELECT COUNT(order_id) AS Total FROM direct_orders WHERE (TRIM(investor_id)='".$this->db->escape_str($email)."') AND (TRIM(transtype)='Sell') AND (TRIM(orderstatus) IN ('Submitted', 'Active', 'Executed'))";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}
	
	function GetTotalInvestorSellOrdersValue($email)
	{
		$sql="SELECT SUM(total_amount) AS Total FROM direct_orders WHERE (TRIM(investor_id)='".$this->db->escape_str($email)."') AND (TRIM(transtype)='Sell') AND (TRIM(orderstatus) IN ('Submitted', 'Active', 'Executed'))";
		
		$query = $this->db->query($sql);
		
		$val=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $val=trim($row->Total);
		}
	
		return $val;
	}
	
	
	function GetTotalInvestorExecutedSellOrders($email)
	{
		$sql="SELECT COUNT(order_id) AS Total FROM direct_orders WHERE (TRIM(investor_id)='".$this->db->escape_str($email)."') AND (TRIM(transtype)='Sell') AND (TRIM(orderstatus) = 'Executed')";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}
	
	function GetTotalInvestorExecutedSellOrdersValue($email)
	{
		$sql="SELECT SUM(total_amount) AS Total FROM direct_orders WHERE (TRIM(investor_id)='".$this->db->escape_str($email)."') AND (TRIM(transtype)='Sell') AND (TRIM(orderstatus) = 'Executed')";
		
		$query = $this->db->query($sql);
		
		$val=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $val=trim($row->Total);
		}
	
		return $val;
	}
	
	//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% END INVESTOR SUMMARY %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	
	
	
	// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%% ISSUER SUMMARY %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	
	function GetTotalIssuerCurrentlyListedSecuritiesValue($email)
	{
		$sql="SELECT SUM(artwork_value) AS Total FROM art_works WHERE (TRIM(email)='".$this->db->escape_str($email)."') AND (art_works.issuer_id=(SELECT uid FROM primary_market WHERE (TRIM(primary_market.listing_status)='Started') AND (TRIM(primary_market.symbol)=TRIM(art_works.symbol)) LIMIT 0,1));";
		
		$query = $this->db->query($sql);
		
		$val=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $val=trim($row->Total);
		}
	
		return $val;
	}
	
	function GetTotalIssuerCurrentlyListedSecurities($issuer_id)
	{
		$sql="SELECT COUNT(symbol) AS Total FROM primary_market WHERE (TRIM(uid)=".$this->db->escape_str($issuer_id).") AND (TRIM(listing_status)='Started')";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}
	
	function GetTotalIssuerExecutedPrimaryTradesValue($email)
	{
		$sql="SELECT SUM(issuer_fee) AS Total FROM primary_trades WHERE (TRIM(issuer_email)='".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
		
		$val=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $val=trim($row->Total);
		}
	
		return $val;
	}
	
	function GetTotalIssuerExecutedPrimaryTrades($email)
	{
		$sql="SELECT COUNT(trade_id) AS Total FROM primary_trades WHERE (TRIM(issuer_email)='".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}
	
	function GetTotalIssuerListedSecuritiesValue($email)
	{
		$sql="SELECT SUM(artwork_value) AS Total FROM art_works WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
		
		$val=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $val=trim($row->Total);
		}
	
		return $val;
	}
	
	function GetTotalIssuerListedSecurities($issuer_id)
	{
		$sql="SELECT COUNT(symbol) AS Total FROM listed_artworks WHERE (uid=".$this->db->escape_str($issuer_id).")";
		
		$query = $this->db->query($sql);
		
		$cnt=0;		
	
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Total) $cnt=trim($row->Total);
		}
	
		return $cnt;
	}

	function guidv4($data = null) {
	    $data = $data ?? random_bytes(16);
	    assert(strlen($data) == 16);

	    // Set version to 0100
	    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
	    // Set bits 6-7 to 10
	    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

	    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}
	
	// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%% END ISSUER SUMMARY %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	
	
	//******************** Investor Direct Sell **********************************
	function DirectInvestorPrimaryMarketEngine($trade)
	{
		$dt=date('Y-m-d H:i:s');
		
		$ret=array();				
		$symbol			= $trade['symbol'];
		$paystack 		= $this->GetPaystackSettings();
		$setings		= $this->GetTradingParamaters();
		
		//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($trade,true)); fclose($file); return;	
		
		$transfers=array();  $currency='NGN'; $listing_ends=''; $listing_ended='0';
		
		$lst=$this->GetListingDetailsFromSymbol($symbol);
		
		if ($lst->listing_ends) $listing_ends=$lst->listing_ends;
		
		$expired=$this->CheckIfDateHasExpired($listing_ends);
		
		//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($lst,true)."\r\n".$expired); fclose($file); return;			
		
		if ($expired) $listing_ended='1';
				
		$deductions=array(); $trades_payments=array(); $issuers_to_pay=array();

		//$trade=array('trade_id','symbol','num_tokens','price','nse_fee','sms_fee','transfer_fees','tradestatus','payment_status','tradedate','trade_amount','total_buyer_fee','total_issuer_fee','issuer_recipient_code','buyer_recipient_code','nse_recipient_code','buy_investor_email','issuer_uid','issuer_email','issuer_phone','buy_investor_phone','issuer_name','buy_investor_name');

		/****** PAYMENTS *****/
		//ISSUER
		$desc="Payment For Sales Of ".$trade['num_tokens']." Tokens Of ".$trade['symbol']." At ".round($trade['price'],2)." Per Token At The Primary Market. Trade Id Is ".$trade['trade_id'];
							
		$issuers_to_pay[] = array('issuer_uid'=>$trade['issuer_uid'],'issuer_email'=>$trade['issuer_email'],'trade_id'=>$trade['trade_id'],'trade_date'=>$trade['tradedate'],'symbol'=>$trade['symbol'],'num_tokens'=>$trade['num_tokens'],'price'=>$trade['price'],'trade_amount'=>$trade['trade_amount'],'recipient_amount'=>$trade['total_issuer_fee'],'currency'=>$currency,'description'=>$desc,'recipient'=>'Issuer','recipient_code'=>$trade['issuer_recipient_code'],'transfer_code'=>'','listing_ended'=>$listing_ended,'payment_status'=>'0');
		
		//Deduction from buyer
		$deductions[]=array('trade_id'=>$trade['trade_id'],"amount"=>$trade['total_buyer_fee'], "reason"=>"Payment For Purchase Of ".$trade['num_tokens']." Tokens Of ".$trade['symbol']." At ".$trade['price']." Per Token And Commissions At The Primary Market. Trade Id Is ".$trade['trade_id'], "investor_id"=>$trade['buy_investor_email']);		
		
		//NSE
		$desc="Commission For Trading Of ".$trade['num_tokens']." Tokens Of ".$trade['symbol']." At ".$trade['price']." Per Token At The Primary Market. Trade Id Is ".$trade_id;
		
		$transfers[]=array("amount"=>($trade['nse_fee'] * 100), "reason"=>$desc, "recipient"=>$trade['nse_recipient_code']);
		
		$trades_payments[] = array('trade_id'=>$trade['trade_id'],'symbol'=>$trade['symbol'],'num_tokens'=>$trade['num_tokens'],'price'=>$trade['price'],'trade_amount'=>$trade['trade_amount'],'recipient_amount'=>$trade['nse_fee'],'recipient'=>'NSE','recipient_code'=>$trade['nse_recipient_code'],'description'=>$desc,'trade_date'=>$trade['tradedate'],'currency'=>$currency,'transfer_code'=>'');		
	
		$transfer_result = '';
		//Make transfers		
		$datee = date('Y-m-d h:m:s').'';
		// $this->guidv4(md5($datee))
						
		if (count($transfers) == 1) {
			$recipient=array(
				"currency"=>$currency,
				"amount" => $transfers[0]['amount'],
				"reference" => '',	
				"source"=>"balance", 
				"recipient"=>$transfers[0]['recipient'],
				"reason"=>$transfers[0]['reason']
			);
			$recipient_string = http_build_query($recipient);
			$transfer_result = $this->PaystackSingleTransferFund($recipient_string);
		}else{
			$recipients=array("currency"=>$currency, "source"=>"balance", "transfers"=>$transfers);
			$recipients_string = http_build_query($recipients);
			$transfer_result = $this->PaystackBulkTransferFunds($recipients_string);
		}
		
		if ($transfer_result['Status']==1)
		{//$transfer_result = array('Status','data') - data='Recipient','Amount','TransferCode','Currency'
			//Log successful transfer
			$operation='Transfer Of Primary Market Trade Commission';
					
			$activity='Transfer of funds to NSE was done successfully from the primary market trade with Id '.$trade['trade_id'].'. Details Of The Transfer Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Issuer Email: '.$trade['issuer_email'].'; Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Trade Price: '.$trade['price'].'; Trade Amount: '.(floatval($trade['num_tokens']) * floatval($trade['price'])).'; NSE Commission: '.$trade['nse_fee'].'; Payment Status: '.$trade['payment_status'].'; Engine Type: Direct; Issuer Fee: '.$trade['total_issuer_fee'];
					
			$username='System';
			$fullname='Naija Art Mart Core';
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
			
			$r=$this->InvestorBalanceWalletAfterTrade($deductions); //Deduct from Wallet			
			
			if ($r==true)
			{				
				//Log the issuer payment to issuers_to_pay table
				if (count($issuers_to_pay) > 0)
				{
					foreach($issuers_to_pay as $rec)
					{
						$sql="SELECT * FROM issuers_to_pay WHERE (TRIM(issuer_email)='".$this->db->escape_str($rec['issuer_email'])."') AND (TRIM(trade_id)='".$this->db->escape_str($rec['trade_id'])."') AND (TRIM(symbol)='".$this->db->escape_str($rec['symbol'])."')";
							
						$query=$this->db->query($sql);
						
						if ($query->num_rows() == 0)
						{
							$this->db->trans_start();			
							
							$dat=array(
								'issuer_uid' 		=> $this->db->escape_str($rec['issuer_uid']),
								'issuer_email' 		=> $this->db->escape_str($rec['issuer_email']),
								'trade_id' 			=> $this->db->escape_str($rec['trade_id']),
								'symbol' 			=> $this->db->escape_str($rec['symbol']),
								'num_tokens'		=> $this->db->escape_str($rec['num_tokens']),
								'price' 			=> $this->db->escape_str($rec['price']),
								'trade_amount' 		=> $this->db->escape_str($rec['trade_amount']),
								'recipient_amount'	=> $this->db->escape_str($rec['recipient_amount']),
								'currency' 			=> $this->db->escape_str($rec['currency']),
								'description' 		=> $this->db->escape_str($rec['description']),
								'recipient' 		=> $this->db->escape_str($rec['recipient']),
								'recipient_code' 	=> $this->db->escape_str($rec['recipient_code']),
								'transfer_code' 	=> $this->db->escape_str($rec['transfer_code']),
								'listing_ended' 	=> $this->db->escape_str($rec['listing_ended']),
								'payment_status' 	=> $this->db->escape_str($rec['payment_status']),
								'trade_date'		=> $this->db->escape_str($rec['trade_date'])
							);
							
							$this->db->insert('issuers_to_pay', $dat);	
								
							$this->db->trans_complete();
						}
					}
				}
				
				//Process transfer data
				$paydata=$transfer_result['data'];
			
				if (count($paydata) > 0)
				{
					foreach($paydata as $pd)
					{
						for($i=0; $i < count($trades_payments); $i++)
						{//'Recipient','Amount','TransferCode','Currency'							
							if (trim($pd['Recipient'] == trim($trades_payments[$i]['recipient_code'])) And (floatval($pd['Amount']/100) == floatval($trades_payments[$i]['recipient_amount'])))
							{
								$trades_payments[$i]['transfer_code']=$pd['TransferCode'];
							}
						}						
					}
				}		
		
				$save_trade_result=$this->SaveInvestorPrimaryTrade($trade); //Save trade
								
				//Update portfolios	
				$buy_uid=''; $title='';
				
				//Issuer
				$inv_rw = $this->GetIssuerDetails($trade['issuer_email']);				
				
								
				//Buyer
				$inv_rw = $this->GetInvestorDetails($trade['buy_investor_email']);
				if ($inv_rw->uid) $buy_uid = trim($inv_rw->uid);
				
				$at = $this->GetArtTitle($trade['symbol']);
				$title = trim($at);
				
				//Buyer
				$sql="SELECT * FROM portfolios WHERE (TRIM(email)='".$this->db->escape_str($trade['buy_investor_email'])."') AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
					
				$query=$this->db->query($sql);
				
				$buy_old_portfolio=0; $buy_new_portfolio=0; 
				
				if ($query->num_rows() > 0)
				{
					$rr = $query->row();
					
					if ($rr->tokens) $buy_old_portfolio =$rr->tokens;
					
					$tok = intval($rr->tokens) + intval($trade['num_tokens']);
					$buy_new_portfolio=$tok;
					
					$this->db->trans_start();	
					
					$dat=array(
						'tokens' 		=> $this->db->escape_str($tok),
						'currentprice' 	=> $this->db->escape_str($trade['market_price']),
						'price_bought' 	=> $this->db->escape_str($trade['price']),
						'date_updated'	=> $dt
					);			
	
					$this->db->where(array('email'=>$trade['buy_investor_email'],'symbol'=>$trade['symbol']));
					$this->db->update('portfolios',$dat);
												
					$this->db->trans_complete();
				}else
				{
					$buy_new_portfolio=$trade['num_tokens'];
					
					$this->db->trans_start();			
					
					$dat=array(
						'email' 		=> $this->db->escape_str($trade['buy_investor_email']),
						'uid' 			=> $this->db->escape_str($buy_uid),
						'symbol'		=> $this->db->escape_str($trade['symbol']),
						'art_title' 	=> $this->db->escape_str($title),
						'tokens' 		=> $this->db->escape_str($trade['num_tokens']),
						'price_bought' 	=> $this->db->escape_str($trade['price']),
						'currentprice' 	=> $this->db->escape_str($trade['market_price']),
						'date_created'	=> $dt
					);
					
					$this->db->insert('portfolios', $dat);	
						
					$this->db->trans_complete();
				}

				//Issuer
				$sql="SELECT * FROM primary_market WHERE (TRIM(uid)=".$this->db->escape_str($trade['issuer_uid']).") AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
				
				$query=$this->db->query($sql);
				
				$sell_old_portfolio=0; $sell_new_portfolio=0;
				
				if ($query->num_rows() > 0)
				{
					$rr = $query->row();
					if ($rr->tokens_available) $sell_old_portfolio = $rr->tokens_available;
					
					$sell_new_portfolio = intval($sell_old_portfolio) - intval($trade['num_tokens']);	
										
					$this->db->trans_start();	
					
					$dat=array(
						'tokens_available'	=> $this->db->escape_str($sell_new_portfolio),
						'market_date'		=> $dt
					);		
	
					$this->db->where(array('uid'=>$trade['issuer_uid'],'symbol'=>$trade['symbol']));
					$this->db->update('primary_market',$dat);
												
					$this->db->trans_complete();
				}
				
				//listed_artworks
				$sql="SELECT * FROM listed_artworks WHERE (TRIM(uid)=".$this->db->escape_str($trade['issuer_uid']).") AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
				
				$query=$this->db->query($sql);
				
				if ($query->num_rows() > 0)
				{										
					$this->db->trans_start();	
					
					$dat=array('tokens_available' => $this->db->escape_str($sell_new_portfolio));		
	
					$this->db->where(array('uid'=>$trade['issuer_uid'],'symbol'=>$trade['symbol']));
					$this->db->update('listed_artworks',$dat);
												
					$this->db->trans_complete();
				}
				
				//Log Portfolio Update
				$operation='Updated Issuer And Buyer Portfolios';
		
				$activity='Updated Issuer And Buyer portfolios after trade successfully. Details Of Portfolio Update: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Asset: '.$trade['symbol'].'; Buyer Old Portfolio Quantity: '.$buy_old_portfolio.'; Buyer New Portfolio Quantity: '.$buy_new_portfolio.'; Issuer Old Portfolio Quantity: '.$sell_old_portfolio.'; Issuer New Portfolio Quantity: '.$sell_new_portfolio;
						
				$username='System';
				$fullname='Naija Art Mart Core';
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
				$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
				
								
				//$trades_payments= array('trade_id','symbol','num_tokens','price','trade_amount','recipient_amount','recipient','recipient_code','description','trade_date','currency','transfer_code');
				
				if (count($trades_payments) > 0)
				{
					foreach($trades_payments as $pay)
					{
						$sql="SELECT * FROM trades_payments WHERE (TRIM(trade_id)='".$this->db->escape_str($pay['trade_id'])."') AND (TRIM(recipient)='".$this->db->escape_str($pay['recipient'])."') AND (TRIM(recipient_amount)=".$this->db->escape_str($pay['recipient_amount']).") AND (TRIM(recipient_code)='".$this->db->escape_str($pay['recipient_code'])."')";
					
						$query=$this->db->query($sql);
						
						if ($query->num_rows() == 0)
						{
							$this->db->trans_start();	
								
							$dat=array(
								'trade_id' 			=> $this->db->escape_str($pay['trade_id']),
								'symbol' 			=> $this->db->escape_str($pay['symbol']),
								'num_tokens' 		=> $this->db->escape_str($pay['num_tokens']),
								'currency' 			=> $this->db->escape_str($pay['currency']),
								'price' 			=> $this->db->escape_str($pay['price']),
								'trade_amount' 		=> $this->db->escape_str($pay['trade_amount']),
								'recipient_amount'	=> $this->db->escape_str($pay['recipient_amount']),
								'recipient' 		=> $this->db->escape_str($pay['recipient']),
								'recipient_code' 	=> $this->db->escape_str($pay['recipient_code']),
								'description'		=> $this->db->escape_str($pay['description']),
								'transfer_code'		=> $this->db->escape_str($pay['transfer_code']),
								'transfer_date'		=> $this->db->escape_str($pay['trade_date']),
								'trade_date'		=> $this->db->escape_str($pay['trade_date'])
							);
				
							$this->db->insert('trades_payments', $dat);	
								
							$this->db->trans_complete();
						}
					}
				}
			
				$sms=0;
				
				if ($setings->sms_fee) $sms = $setings->sms_fee;
				
				$transact_partners = array("symbol"=>$symbol,"investor_id"=>$trade['buy_investor_email'],"qty" => $trade['num_tokens'],"price" => $trade['price'], 'sms_fee'=>($sms * 2),'transtype'=>$transtype);
		
				$ret = array('Status'=>1,"msg"=>"Trade Was Successful. ".$trade['num_tokens']." Tokens Of ".$symbol." Was Sold At ".round($trade['price'],2).".","trade_id"=>$trade['trade_id'],'transact_partners'=>$transact_partners);	
			}else
			{
				$ret = array('Status'=>'FAIL','msg'=>'Trade Execution Failed. Funds Deduction From Buyer Broker Wallet Was Not Successful.');
			}
		}else
		{
			$ret = array('Status'=>'FAIL','msg'=>'Trade Execution Failed. Funds Transfer Was Not Successful: '.strtoupper($transfer_result['Message']));
		}
				
		return $ret;
	}
	
	function SaveInvestorPrimaryTrade($trade)
	{
		$ret=false;
			
		if (is_array($trade))
		{
			$this->db->trans_start();

			$dat=array(
				'buy_investor_email' 	=> $this->db->escape_str($trade['buy_investor_email']),				
				'issuer_email'			=> $this->db->escape_str($trade['issuer_email']),						
				'trade_id' 				=> $this->db->escape_str($trade['trade_id']),				
				'symbol'				=> $this->db->escape_str($trade['symbol']),				
				'num_tokens' 			=> $this->db->escape_str($trade['num_tokens']),				
				'trade_price' 			=> $this->db->escape_str($trade['price']),
				'issuer_fee' 			=> $this->db->escape_str($trade['total_issuer_fee']),			
				'nse_fee' 				=> $this->db->escape_str($trade['nse_fee']),				
				'transfer_fees' 		=> $this->db->escape_str($trade['transfer_fees']),
				'tradestatus' 			=> $this->db->escape_str($trade['tradestatus']),
				'payment_status' 		=> $this->db->escape_str($trade['payment_status']),												
				'total_buyer_fee' 		=> $this->db->escape_str($trade['total_buyer_fee']),
				'engine_type' 			=> 'Direct',				
				'tradedate'				=> $this->db->escape_str($trade['tradedate'])
			);
			
			$this->db->insert('primary_trades', $dat);	
				
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE)
			{
				$operation='Saving Primary Market Trade Record With Trade Id '.$trade['trade_id'].' Failed';
				
				$activity='Attempted Saving A Primary Market Trade With Id '.$trade['trade_id'].' But Failed. Details Of The Trade Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Trade Price: '.$trade['price'].'; Trade Amount: '.round((floatval($trade['num_tokens']) * floatval($trade['price'])),2).'; NSE Commission: '.$trade['nse_fee'].'; Transfer Fees: '.$trade['transfer_fees'].'; Trade Status: '.$trade['tradestatus'].'; Payment Status: '.$trade['payment_status'].'; Engine Type: Direct; Total Buyer Fee: '.$trade['total_buyer_fee'].'; Total Issuer Fee: '.$trade['total_issuer_fee'];
			}else
			{		
				//Log activity
				$operation='Saved Primary Market Trade Record';
				
				$activity='A Trade Was Created With Id '.$trade['trade_id'].'. Details Of The Trade Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Trade Price: '.$trade['price'].'; Trade Amount: '.round((floatval($trade['num_tokens']) * floatval($trade['price'])),2).'; NSE Commission: '.$trade['nse_fee'].'; Transfer Fees: '.$trade['transfer_fees'].'; Trade Status: '.$trade['tradestatus'].'; Payment Status: '.$trade['payment_status'].'; Engine Type:  Direct; Total Buyer Fee: '.$trade['total_buyer_fee'].'; Total Issuer Fee: '.$trade['total_issuer_fee'];
									
				$ret=true;
			}
		}		
		
		//Log activity
		$username='System';
		$fullname='Naija Art Mart Core';
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
		$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
		
		return $ret;
	}
	
	function DirectInvestorMatchingEngine($trade)
	{
		$dt=date('Y-m-d H:i:s');
		
		$ret=array();				
		$transtype		= 'Buy'; 
		$symbol			= $trade['symbol'];
		$paystack 		= $this->GetPaystackSettings();
		$setings		= $this->GetTradingParamaters();
		
		$transfers=array();  $currency='NGN'; $min_buy_qty = 0;
		
		if ($setings->min_buy_qty) $min_buy_qty = $setings->min_buy_qty;
		
		$deductions=array(); $price_changes = array(); $trades_payments=array();

		/****** PAYMENTS *****/
		//SELLER
		$desc="Payment For Sales Of ".$trade['num_tokens']." Tokens Of ".$trade['symbol']." At ".round($trade['price'],2)." Per Token. Trade Id Is ".$trade['trade_id'];
		
		$transfers[]=array("amount" => ($trade['total_seller_fee'] * 100), "reason"=>$desc, "recipient"=>$trade['seller_recipient_code']);
						
		$trades_payments[] = array('trade_id'=>$trade['trade_id'],'symbol'=>$trade['symbol'],'num_tokens'=>$trade['num_tokens'],'price'=>round($trade['price'],2),'trade_amount'=>round($trade['trade_amount'],2),'recipient_amount'=>round($trade['total_seller_fee'],2),'recipient'=>'Seller','recipient_code'=>$trade['seller_recipient_code'],'description'=>$desc,'trade_date'=>$trade['tradedate'],'currency'=>$currency,'transfer_code'=>'');		
		
		if (trim($trade['sell_broker_id']) <> '')
		{
			//Seller Broker
			$desc="Commission For Sales Of ".$trade['num_tokens']." Tokens Of ".$trade['symbol']." At ".round($trade['price'],2)." Per Token. Trade Id Is ".$trade['trade_id'];
				
			$transfers[]=array("amount"=>($trade['sell_broker_fee'] * 100), "reason"=>$desc, "recipient"=>$trade['sell_broker_recipient_code']);
			
			$trades_payments[] = array('trade_id'=>$trade['trade_id'],'symbol'=>$trade['symbol'],'num_tokens'=>$trade['num_tokens'],'price'=>round($trade['price'],2),'trade_amount'=>round($trade['trade_amount'],2),'recipient_amount'=>round($trade['sell_broker_fee'],2),'recipient'=>'Seller Broker','recipient_code'=>$trade['sell_broker_recipient_code'],'description'=>$desc,'trade_date'=>$trade['tradedate'],'currency'=>$currency,'transfer_code'=>'');		
		}
					
		//Deduction from buyer
		$deductions[]=array('trade_id'=>$trade['trade_id'],"amount"=>$trade['total_buyer_fee'], "reason"=>"Payment For Buying Of ".$trade['num_tokens']." Tokens Of ".$trade['symbol']." At ".round($trade['price'],2)." Per Token And Commissions. Trade Id Is ".$trade['trade_id'], "investor_id"=>$trade['buy_investor_email']);		
		
		//NSE
		$desc="Commission For Trading Of ".$trade['num_tokens']." Tokens Of ".$trade['symbol']." At ".round($trade['price'],2)." Per Token. Trade Id Is ".$trade['trade_id'];
		
		$transfers[]=array("amount"=>($trade['nse_fee'] * 100), "reason"=>$desc, "recipient"=>$trade['nse_recipient_code']);
		
		$trades_payments[] = array('trade_id'=>$trade['trade_id'],'symbol'=>$trade['symbol'],'num_tokens'=>$trade['num_tokens'],'price'=>round($trade['price'],2),'trade_amount'=>round($trade['trade_amount'],2),'recipient_amount'=>round($trade['nse_fee'],2),'recipient'=>'NSE','recipient_code'=>$trade['nse_recipient_code'],'description'=>$desc,'trade_date'=>$trade['tradedate'],'currency'=>$currency,'transfer_code'=>'');
		

		//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($trade,true)); fclose($file); return;
	
		//Make transfers		
		$recipients=array("currency"=>$currency, "source"=>"balance", "transfers"=>$transfers);				
				
		$recipients_string = http_build_query($recipients);	

		if (count($transfers) == 1) {
			$recipient=array(
				"currency"=>$currency,
				"amount" => $transfers[0]['amount'],
				"reference" => '',	
				"source"=>"balance", 
				"recipient"=>$transfers[0]['recipient'],
				"reason"=>$transfers[0]['reason']
			);
			$recipient_string = http_build_query($recipient);
			$transfer_result = $this->PaystackSingleTransferFund($recipient_string);
		}else{
			$recipients=array("currency"=>$currency, "source"=>"balance", "transfers"=>$transfers);
			$recipients_string = http_build_query($recipients);
			$transfer_result = $this->PaystackBulkTransferFunds($recipients_string);
		}	
					
		if ($transfer_result['Status']==1)
		{//$transfer_result = array('Status','data') - data='Recipient','Amount','TransferCode','Currency'
			//Log successful transfer
			$operation='Transfer Of Transaction Amounts';
			
			if (trim($trade['sell_broker_id']) <> '')
			{
				$activity='Transfer of funds to seller, seller broker and NSE was done successfully from trade with Id '.$trade['trade_id'].'. Details Of The Transfer Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Buyer Email: '.$trade['buy_investor_email'].'; Seller Broker Id: '.$trade['sell_broker_id'].'; Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Trade Price: '.$trade['price'].'; Trade Amount: '.round((floatval($trade['num_tokens']) * floatval($trade['price'])),2).'; Seller Broker Fee: '.$trade['sell_broker_fee'].'; NSE Commission: '.$trade['nse_fee'].'; Payment Status: '.$trade['payment_status'].'; Engine Type: Direct; Seller Fee: '.$trade['total_seller_fee'];	
			}else
			{
				$activity='Transfer of funds to seller and NSE was done successfully from trade with Id '.$trade['trade_id'].'. Details Of The Transfer Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Buyer Email: '.$trade['buy_investor_email'].'; Seller Email: '.$trade['sell_investor_email'].'; Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Trade Price: '.$trade['price'].'; Trade Amount: '.round((floatval($trade['num_tokens']) * floatval($trade['price'])),2).'; NSE Commission: '.$trade['nse_fee'].'; Payment Status: '.$trade['payment_status'].'; Engine Type: Direct; Seller Fee: '.$trade['total_seller_fee'];	
			}			
					
			$username='System';
			$fullname='Naija Art Mart Core';
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
			
			$r=$this->InvestorBalanceWalletAfterTrade($deductions); //Deduct from Wallet			
			
			if ($r==true)
			{
				$paydata=$transfer_result['data'];
			
				if (count($paydata) > 0)
				{
					foreach($paydata as $pd)
					{
						for($i=0; $i < count($trades_payments); $i++)
						{//'Recipient','Amount','TransferCode','Currency'							
							if (trim($pd['Recipient'] == trim($trades_payments[$i]['recipient_code'])) And (floatval($pd['Amount']/100) == floatval($trades_payments[$i]['recipient_amount'])))
							{
								$trades_payments[$i]['transfer_code']=$pd['TransferCode'];
							}
						}						
					}
				}		
		
				$save_trade_result=$this->SaveInvestorDirectTrade($trade); //Save trades
				
				//Update Prices And Order Values ****Change And Update Price
				if ((intval($trade['num_tokens']) >= intval($min_buy_qty)) And (intval($min_buy_qty) > 0))
				{
					$sql="SELECT * FROM price_changes WHERE (TRIM(trade_id)='".$this->db->escape_str($trade['trade_id'])."') AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."') AND (DATE_FORMAT(date_updated,'%Y-%m-%d')='".date('Y-m-d')."')";
					
					$query=$this->db->query($sql);
					
					if ($query->num_rows() == 0)
					{
						$this->db->trans_start();	
								
						$dat=array(
							'trade_id' 		=> $this->db->escape_str($trade['trade_id']),
							'symbol' 		=> $this->db->escape_str($trade['symbol']),
							'qty' 			=> $this->db->escape_str($trade['num_tokens']),
							'current_price'	=> $this->db->escape_str($trade['market_price']),
							'new_price' 	=> $this->db->escape_str($trade['price']),
							'date_updated'	=> $this->db->escape_str($dt)
						);
					
						$this->db->insert('price_changes', $dat);							
						$this->db->trans_complete();
					}					
					
					//Get High And Low Intraday Prices
					$high=0; $low=0; $volume=0; $change=0; $no_of_trades=0; $trade_value=0;
					$close_price=0; $prevclose=0; $changepercent=0;
					
					$sql="SELECT MAX(trade_price) AS High, MIN(trade_price) AS Low FROM trades WHERE (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."') AND (trade_price > 0) AND (DATE_FORMAT(tradedate,'%Y-%m-%d')='".date('Y-m-d')."')";
					
					$query=$this->db->query($sql);
					
					$old_close_price=0;
					
					if ($query->num_rows() > 0)
					{
						$row = $query->row();
						
						if ($row->High) $high =$row->High;
						if ($row->Low) 	$low =$row->Low;
						if ($row->close_price) 	$old_close_price =$row->close_price;
		
						$close_price = floatval($trade['price']);
						
						$trade_value = intval($trade['num_tokens']) * $close_price;
						
						$sql="SELECT * FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".date('Y-m-d')."') AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
						
						$query=$this->db->query($sql);
						
						if ($query->num_rows() > 0)
						{
							$row = $query->row();
							
							if ($row->previous_close_price) $prevclose =$row->previous_close_price;
							if ($row->trades) $no_of_trades = $row->trades + 1; else $no_of_trades=1;
							if ($row->volume) $volume = $row->volume + intval($trade['num_tokens']); else $volume=$trade['num_tokens'];
							if ($row->trade_value) $trade_value += $row->trade_value;
							
							$change = $close_price - $prevclose;
							$changepercent = round(($change/$prevclose) * 100,2);
							
							//Update daily_price
							$this->db->trans_start();	
								
							$dat=array(
								'close_price' 			=> $this->db->escape_str($close_price),
								'high_price' 			=> $this->db->escape_str($high),
								'low_price' 			=> $this->db->escape_str($low),
								'volume'				=> $this->db->escape_str($volume),
								'change' 				=> $this->db->escape_str($change),
								'trades'				=> $this->db->escape_str($no_of_trades),
								'trade_value'			=> $this->db->escape_str($trade_value),
								'previous_close_price'	=> $this->db->escape_str($prevclose),
								'change_percent'		=> $this->db->escape_str($changepercent)
							);
						
							$this->db->where(array('symbol'=>$trade['symbol'],'price_date'=>date('Y-m-d')));
							$this->db->update('daily_price', $dat);						
							$this->db->trans_complete();
							
							//Log Price change
							$operation='Updated Market Price For Asset';
					
							$activity='Updated market price for asset after successful trade. Details Of Price Update: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Minimum Quantity For Price Change: '.$min_buy_qty.'; Trade Price: '.$trade['price'].'; Old Market Price: '.$old_close_price.'; Market Price After Trade: '.$close_price;
									
							$username='System';
							$fullname='Naija Art Mart Core';
							$remote_ip=$_SERVER['REMOTE_ADDR'];
							$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
							
							$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
						}				
					}
				}else
				{
					//Get High And Low Intraday Prices
					$high=0; $low=0; $volume=0; $change=0; $no_of_trades=0; $trade_value=0;
					$close_price=0; $prevclose=0; $changepercent=0;
					
					$sql="SELECT MAX(trade_price) AS High, MIN(trade_price) AS Low FROM trades WHERE (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."') AND (trade_price > 0) AND (DATE_FORMAT(tradedate,'%Y-%m-%d')='".date('Y-m-d')."')";
					
					$query=$this->db->query($sql);
					
					$old_close_price=0;
					
					if ($query->num_rows() > 0)
					{
						$row = $query->row();
						
						if ($row->High) $high =$row->High;
						if ($row->Low) 	$low =$row->Low;
						if ($row->close_price) 	$old_close_price =$row->close_price;
		
						$close_price = floatval($trade['price']);
						
						$trade_value = intval($trade['num_tokens']) * $close_price;
						
						$sql="SELECT * FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".date('Y-m-d')."') AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
						
						$query=$this->db->query($sql);
						
						if ($query->num_rows() > 0)
						{
							$row = $query->row();
							
							if ($row->previous_close_price) $prevclose =$row->previous_close_price;
							if ($row->trades) $no_of_trades = $row->trades + 1; else $no_of_trades=1;
							if ($row->volume) $volume = $row->volume + intval($trade['num_tokens']); else $volume=$trade['num_tokens'];
							if ($row->trade_value) $trade_value += $row->trade_value;
							
							$change = $close_price - $prevclose;
							$changepercent = round(($change/$prevclose) * 100,2);
							
							//Update daily_price
							$this->db->trans_start();	
								
							$dat=array(
								'volume'				=> $this->db->escape_str($volume),
								'trades'				=> $this->db->escape_str($no_of_trades),
								'trade_value'			=> $this->db->escape_str($trade_value)
							);
						
							$this->db->where(array('symbol'=>$trade['symbol'],'price_date'=>date('Y-m-d')));
							$this->db->update('daily_price', $dat);						
							$this->db->trans_complete();
						}				
					}
				}
				
				//Update portfolios	
				$sell_email=''; $buy_email='';	$sell_uid=''; $buy_uid=''; $title='';
				
				//Seller
				$inv_rw = $this->GetInvestorDetails($trade['sell_investor_email']);				
				if ($inv_rw->email) $sell_email = trim($inv_rw->email);
				if ($inv_rw->uid) $sell_uid = trim($inv_rw->uid);
				
				//Buyer
				$inv_rw = $this->GetInvestorDetails($trade['buy_investor_email']);				
				if ($inv_rw->email) $buy_email = trim($inv_rw->email);
				if ($inv_rw->uid) $buy_uid = trim($inv_rw->uid);
				
				$at = $this->GetArtTitle($trade['symbol']);
				$title = trim($at);
								
				//Buyer
				$sql="SELECT * FROM portfolios WHERE ((TRIM(email)='".$this->db->escape_str($buy_email)."') OR (TRIM(uid)='".$this->db->escape_str($buy_uid)."')) AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
					
				$query=$this->db->query($sql);
				
				$buy_old_portfolio=0; $buy_new_portfolio=0; 
				
				if ($query->num_rows() > 0)
				{
					$rr = $query->row();
					
					if ($rr->tokens) $buy_old_portfolio =$rr->tokens;
					
					$tok = intval($rr->tokens) + intval($trade['num_tokens']);
					$buy_new_portfolio=$tok;
					
					$this->db->trans_start();	
					
					$dat=array(
						'tokens' 		=> $this->db->escape_str($tok),
						'currentprice' 	=> $this->db->escape_str($trade['market_price']),
						'price_bought' 	=> $this->db->escape_str($trade['price']),
						'date_updated'	=> $dt
					);			
	
					$this->db->where(array('email'=>$buy_email,'symbol'=>$trade['symbol']));
					$this->db->update('portfolios',$dat);
												
					$this->db->trans_complete();
				}else
				{
					$buy_new_portfolio=$trade['num_tokens'];
					
					$this->db->trans_start();			
					
					$dat=array(
						'email' 		=> $this->db->escape_str($buy_email),
						'uid' 			=> $this->db->escape_str($buy_uid),
						'symbol'		=> $this->db->escape_str($trade['symbol']),
						'art_title' 	=> $this->db->escape_str($title),
						'tokens' 		=> $this->db->escape_str($trade['num_tokens']),
						'price_bought' 	=> $this->db->escape_str($trade['price']),
						'currentprice' 	=> $this->db->escape_str($trade['market_price']),
						'date_created'	=> $dt
					);
					
					$this->db->insert('portfolios', $dat);	
						
					$this->db->trans_complete();
				}
				
				//Seller
				if (trim($trade['sell_broker_id']) <> '')
				{					
					$sql="SELECT * FROM portfolios WHERE ((TRIM(email)='".$this->db->escape_str($sell_email)."') OR (TRIM(uid)='".$this->db->escape_str($sell_uid)."')) AND (TRIM(broker_id)='".$this->db->escape_str($trade['sell_broker_id'])."') AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
					
					$query=$this->db->query($sql);
					
					$sell_old_portfolio=0; $sell_new_portfolio=0;
					
					if ($query->num_rows() > 0)
					{
						$rr = $query->row();
						if ($rr->tokens) $sell_old_portfolio =$rr->tokens;
						
						$tok = intval($rr->tokens) - intval($trade['num_tokens']);	
						$sell_new_portfolio=$tok;
						
						$this->db->trans_start();	
						
						$dat=array(
							'tokens' 		=> $this->db->escape_str($tok),
							'currentprice' 	=> $this->db->escape_str($trade['market_price']),
							'price_bought' 	=> $this->db->escape_str($trade['price']),
							'date_updated'	=> $dt
						);		
		
						$this->db->where(array('email'=>$sell_email,'broker_id'=>$trade['sell_broker_id'],'symbol'=>$trade['symbol']));
						$this->db->update('portfolios',$dat);
													
						$this->db->trans_complete();
					}else
					{		
						$sell_new_portfolio=$trade['num_tokens'];
						
						$this->db->trans_start();			
						
						$dat=array(
							'email' 		=> $this->db->escape_str($sell_email),
							'uid' 			=> $this->db->escape_str($sell_uid),
							'broker_id' 	=> $this->db->escape_str($trade['sell_broker_id']),
							'symbol'		=> $this->db->escape_str($trade['symbol']),
							'art_title' 	=> $this->db->escape_str($title),
							'tokens' 		=> $this->db->escape_str($trade['num_tokens']),
							'price_bought' 	=> $this->db->escape_str($trade['price']),
							'currentprice' 	=> $this->db->escape_str($trade['market_price']),
							'date_created'	=> $dt
						);
						
						$this->db->insert('portfolios', $dat);	
							
						$this->db->trans_complete();
					}	
				}else
				{
					//Seller
					$sql="SELECT * FROM portfolios WHERE ((TRIM(email)='".$this->db->escape_str($sell_email)."') OR (TRIM(uid)='".$this->db->escape_str($sell_uid)."')) AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
					
					$query=$this->db->query($sql);
					
					$sell_old_portfolio=0; $sell_new_portfolio=0;
					
					if ($query->num_rows() > 0)
					{
						$rr = $query->row();
						if ($rr->tokens) $sell_old_portfolio =$rr->tokens;
						
						$tok = intval($rr->tokens) - intval($trade['num_tokens']);	
						$sell_new_portfolio=$tok;
						
						$this->db->trans_start();	
						
						$dat=array(
							'tokens' 		=> $this->db->escape_str($tok),
							'currentprice' 	=> $this->db->escape_str($trade['market_price']),
							'price_bought' 	=> $this->db->escape_str($trade['price']),
							'date_updated'	=> $dt
						);		
		
						$this->db->where(array('email'=>$sell_email,'symbol'=>$trade['symbol']));
						$this->db->update('portfolios',$dat);
													
						$this->db->trans_complete();
					}else
					{		
						$sell_new_portfolio=$trade['num_tokens'];
						
						$this->db->trans_start();			
						
						$dat=array(
							'email' 		=> $this->db->escape_str($sell_email),
							'uid' 			=> $this->db->escape_str($sell_uid),
							'symbol'		=> $this->db->escape_str($trade['symbol']),
							'art_title' 	=> $this->db->escape_str($title),
							'tokens' 		=> $this->db->escape_str($trade['num_tokens']),
							'price_bought' 	=> $this->db->escape_str($trade['price']),
							'currentprice' 	=> $this->db->escape_str($trade['market_price']),
							'date_created'	=> $dt
						);
						
						$this->db->insert('portfolios', $dat);	
							
						$this->db->trans_complete();
					}	
				}

				//Log Portfolio Update
				$operation='Updated Investors Portfolios';
		
				$activity='Updated investors portfolios after trade successfully. Details Of Portfolio Update: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Asset: '.$trade['symbol'].'; Buyer Old Portfolio Quantity: '.$buy_old_portfolio.'; Buyer New Portfolio Quantity: '.$buy_new_portfolio.'; Seller Old Portfolio Quantity: '.$sell_old_portfolio.'; Seller New Portfolio Quantity: '.$sell_new_portfolio;
						
				$username='System';
				$fullname='Naija Art Mart Core';
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
				$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
				
				
				//********************UPDATE Sell Orders - Seller
				 $sell_order_qty_before=0; $sell_order_qty_after=0;
				 $sell_order_status_before=''; $sell_order_status_after='';
				 $sta=''; $newprice=''; $newsta=''; $oldprice='';
				  
				$sql="SELECT * FROM direct_orders WHERE (TRIM(order_id)='".$this->db->escape_str($trade['sell_order_id'])."')";
					
				$query=$this->db->query($sql);
				
				if ($query->num_rows() > 0)
				{
					$rr = $query->row();
					
					if ($rr->available_qty) $sell_order_qty_before =$rr->available_qty;
					if ($rr->orderstatus) $sell_order_status_before =trim($rr->orderstatus);
					if ($rr->price) $oldprice =$rr->price;
					
					$tamt = floatval($trade['num_tokens']) * floatval($trade['price']); //Trade amount						
					$availQty= intval($rr->available_qty) - intval($trade['num_tokens']);
										
					if (intval($availQty) > 0)
					{
						if (trim(strtolower($trade['sell_ordertype'])) == 'limit')
						{
							$newprice=$trade['price'];
						}elseif (trim(strtolower($trade['sell_ordertype'])) == 'market')
						{
							$newprice=$trade['market_price'];
						}
					}
					
					$this->db->trans_start();
					
					$dat=array();
					
					if (intval($availQty)==0)
					{
						$sell_order_status_after='Executed';
						
						$dat=array(
							'available_qty' 	=> $this->db->escape_str($availQty),
							'orderstatus'		=> $sell_order_status_after,
							'last_update_date'	=> $dt
						);
					}elseif (intval($availQty) > 0)
					{
						$TFee=0; $br_rate=0; $n_rate=0; $sms_rate = 0;
						
						//Recompute fees/commissions					
						if ($paystack->transfer_fee) $TFee = $paystack->transfer_fee;
						if ($paystack->brokers_commission) $br_rate = $paystack->brokers_commission;
						if ($paystack->nse_commission) $n_rate = $paystack->nse_commission;
						
						if ($setings->sms_fee) $sms_rate = $setings->sms_fee;
						
						$new_tradeamount = floatval($availQty) * floatval($newprice);
						
						$new_brokerfee = (floatval($br_rate)/100) * $new_tradeamount;
						$new_nsefee = (floatval($n_rate)/100) * $new_tradeamount;
						$new_totalamount = floatval($new_tradeamount) + floatval($new_brokerfee) + floatval(($new_nsefee/2)) + floatval(($sms_rate * 2)) + floatval($TFee);
											
									
						$new_seller_fee=$new_tradeamount - floatval($new_brokerfee) - floatval(($new_nsefee/2)) - floatval($TFee) - floatval(($sms_rate * 2));		
						
						$sell_order_status_after= 'Active';		
						
						if (trim($trade['sell_broker_id']) <> '')
						{
							$dat=array(
								'available_qty' 	=> $this->db->escape_str($availQty),
								'orderstatus'		=> $sell_order_status_after,
								'price'				=> $this->db->escape_str($newprice),							
								'broker_commission'	=> $this->db->escape_str($new_brokerfee),
								'nse_commission'	=> $this->db->escape_str($new_nsefee),
								'total_amount'		=> $this->db->escape_str($new_totalamount),							
								'last_update_date'	=> $dt
							);	
						}else
						{
							$dat=array(
								'available_qty' 	=> $this->db->escape_str($availQty),
								'orderstatus'		=> $sell_order_status_after,
								'price'				=> $this->db->escape_str($newprice),
								'nse_commission'	=> $this->db->escape_str($new_nsefee),
								'total_amount'		=> $this->db->escape_str($new_totalamount),							
								'last_update_date'	=> $dt
							);
						}						
					}											
				
					$this->db->where('order_id',$trade['sell_order_id']);
					$this->db->update('direct_orders', $dat);						
					$this->db->trans_complete();
					
					$sell_order_qty_after = $availQty;
					$sell_order_status_after = trim($rr->orderstatus);
					
					//Log Sell Order Update
					$operation='Updated Sell Order After Trade';
			
					$activity='Updated sell order after trade successfully. Details Of Sell Order Update: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Asset: '.$trade['symbol'].'; Sell Order Id: '.$trade['sell_order_id'].'; Order Quantity Before Trade: '.$sell_order_qty_before.'; Order Quantity After Trade: '.$sell_order_qty_after.'; Order Price Before Trade: '.$oldprice.'; Order Price After Trade: '.$newprice.'; Order Status Before Trade: '.$sell_order_status_before.'; Order Status After Trade: '.$sell_order_status_after;
							
					$username='System';
					$fullname='Naija Art Mart Core';
					$remote_ip=$_SERVER['REMOTE_ADDR'];
					$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
					$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
				}
				
				//$trades_payments= array('trade_id','symbol','num_tokens','price','trade_amount','recipient_amount','recipient','recipient_code','description','trade_date','currency','transfer_code');
				
				if (count($trades_payments) > 0)
				{
					foreach($trades_payments as $pay)
					{
						$sql="SELECT * FROM trades_payments WHERE (TRIM(trade_id)='".$this->db->escape_str($pay['trade_id'])."') AND (TRIM(recipient)='".$this->db->escape_str($pay['recipient'])."') AND (TRIM(recipient_amount)=".$this->db->escape_str($pay['recipient_amount']).") AND (TRIM(recipient_code)='".$this->db->escape_str($pay['recipient_code'])."')";
					
						$query=$this->db->query($sql);
						
						if ($query->num_rows() == 0)
						{
							$this->db->trans_start();	
								
							$dat=array(
								'trade_id' 			=> $this->db->escape_str($pay['trade_id']),
								'symbol' 			=> $this->db->escape_str($pay['symbol']),
								'num_tokens' 		=> $this->db->escape_str($pay['num_tokens']),
								'currency' 			=> $this->db->escape_str($pay['currency']),
								'price' 			=> $this->db->escape_str($pay['price']),
								'trade_amount' 		=> $this->db->escape_str($pay['trade_amount']),
								'recipient_amount'	=> $this->db->escape_str($pay['recipient_amount']),
								'recipient' 		=> $this->db->escape_str($pay['recipient']),
								'recipient_code' 	=> $this->db->escape_str($pay['recipient_code']),
								'description'		=> $this->db->escape_str($pay['description']),
								'transfer_code'		=> $this->db->escape_str($pay['transfer_code']),
								'transfer_date'		=> $this->db->escape_str($pay['trade_date']),
								'trade_date'		=> $this->db->escape_str($pay['trade_date'])
							);
				
							$this->db->insert('trades_payments', $dat);	
								
							$this->db->trans_complete();
						}
					}
				}
			
				
			//$trade=array('sell_broker_id', 'sell_order_id', 'trade_id', 'symbol', 'num_tokens', 'ask_price', 'bid_price', 'price', 'market_price', 'sell_broker_fee', 'nse_fee', 'transfer_fees', 'tradestatus', 'payment_status', 'tradedate', 'trade_amount', 'total_buyer_fee', 'total_seller_fee', 'seller_recipient_code', 'sell_broker_recipient_code', 'buyer_recipient_code', 'nse_recipient_code', 'sell_broker_email', 'buy_investor_email', 'sell_investor_email', 'sell_broker_phone', 'sell_investor_phone', 'buy_investor_phone', 'sell_broker_name', 'sell_investor_name', 'buy_investor_name', 'min_buy_qty', 'sell_ordertype');		
				
				$sms=0;
						
				if ($setings->sms_fee) $sms = $setings->sms_fee;
				
				$transact_partners = array("symbol"=>$symbol,"investor_id"=>$trade['buy_investor_email'],"qty" => $trade['num_tokens'],"price" => $trade['price'], 'sms_fee'=>($sms * 2),'transtype'=>$transtype);
		
				$ret = array('Status'=>1,"msg"=>"Trade Was Successful. ".$trade['num_tokens']." Tokens Of ".$symbol." Was Sold At ".round($trade['price'],2).".","trade_id"=>$trade['trade_id'],'transact_partners'=>$transact_partners);	
			}else
			{
				$ret = array('Status'=>'FAIL','msg'=>'Trade Execution Failed. Funds Deduction From Buyer Wallet Was Not Successful.');
			}
		}else
		{
			$ret = array('Status'=>'FAIL','msg'=>'Trade Execution Failed. Funds Transfer Was Not Successful. ERROR: '.json_encode($transfer_result['Message']));
		}
				
		return $ret;
	}
	
	function SaveInvestorDirectTrade($trade)
	{
		$ret=false;
			
		if (is_array($trade))
		{
			$dat=array();
			
			$this->db->trans_start();	
			
			if (trim($trade['sell_broker_id']) <> '')
			{
				$dat=array(
					'sell_broker_id' 		=> $this->db->escape_str($trade['sell_broker_id']),
					'sell_order_id' 		=> $this->db->escape_str($trade['sell_order_id']),			
					'buy_investor_email' 	=> $this->db->escape_str($trade['buy_investor_email']),
					'sell_investor_email'	=> $this->db->escape_str($trade['sell_investor_email']),				
					'trade_id' 				=> $this->db->escape_str($trade['trade_id']),
					'symbol'				=> $this->db->escape_str($trade['symbol']),
					'num_tokens' 			=> $this->db->escape_str($trade['num_tokens']),
					'ask_price' 			=> $this->db->escape_str($trade['ask_price']),
					'trade_price' 			=> $this->db->escape_str($trade['price']),
					'market_price' 			=> $this->db->escape_str($trade['market_price']),
					'sell_broker_fee'		=> $this->db->escape_str($trade['sell_broker_fee']),
					'nse_fee' 				=> $this->db->escape_str($trade['nse_fee']),
					'transfer_fees' 		=> $this->db->escape_str($trade['transfer_fees']),					
					'total_buyer_fee' 		=> $this->db->escape_str($trade['total_buyer_fee']),
					'total_seller_fee' 		=> $this->db->escape_str($trade['total_seller_fee']),
					'engine_type' 			=> 'Direct',					
					'tradestatus' 			=> $this->db->escape_str($trade['tradestatus']),			
					'payment_status' 		=> $this->db->escape_str($trade['payment_status']),
					'tradedate'				=> $this->db->escape_str($trade['tradedate'])
				);	
			}else
			{
				$dat=array(
					'sell_order_id' 		=> $this->db->escape_str($trade['sell_order_id']),				
					'buy_investor_email' 	=> $this->db->escape_str($trade['buy_investor_email']),
					'sell_investor_email'	=> $this->db->escape_str($trade['sell_investor_email']),				
					'trade_id' 				=> $this->db->escape_str($trade['trade_id']),
					'symbol'				=> $this->db->escape_str($trade['symbol']),
					'num_tokens' 			=> $this->db->escape_str($trade['num_tokens']),
					'ask_price' 			=> $this->db->escape_str($trade['ask_price']),
					'trade_price' 			=> $this->db->escape_str($trade['price']),
					'market_price' 			=> $this->db->escape_str($trade['market_price']),
					'nse_fee' 				=> $this->db->escape_str($trade['nse_fee']),
					'transfer_fees' 		=> $this->db->escape_str($trade['transfer_fees']),					
					'total_buyer_fee' 		=> $this->db->escape_str($trade['total_buyer_fee']),
					'total_seller_fee' 		=> $this->db->escape_str($trade['total_seller_fee']),
					'engine_type' 			=> 'Direct',					
					'tradestatus' 			=> $this->db->escape_str($trade['tradestatus']),			
					'payment_status' 		=> $this->db->escape_str($trade['payment_status']),
					'tradedate'				=> $this->db->escape_str($trade['tradedate'])
				);
			}			
			
			$this->db->insert('trades', $dat);	
				
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE)
			{
				$operation='Saving Trade Record With Trade Id '.$trade['trade_id'].' Failed';
				
				if (trim($trade['sell_broker_id']) <> '')
				{
					$activity='Attempted Saving A Trade With Id '.$trade['trade_id'].' But Failed. Details Of The Trade Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Seller Broker Id: '.$trade['sell_broker_id'].'; Sell Order Id: '.$trade['sell_order_id'].'; Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Ask Price: '.$trade['ask_price'].'; Trade Price: '.$trade['price'].'; Market Price: '.$trade['market_price'].'; Trade Amount: '.round((floatval($trade['num_tokens']) * floatval($trade['price'])),2).'; Seller Broker Fee: '.$trade['sell_broker_fee'].'; NSE Commission: '.$trade['nse_fee'].'; Transfer Fees: '.$trade['transfer_fees'].'; Trade Status: '.$trade['tradestatus'].'; Payment Status: '.$trade['payment_status'].'; Engine Type: Direct; Total Buyer Fee: '.$trade['total_buyer_fee'].'; Total Seller Fee: '.$trade['total_seller_fee'];	
				}else
				{
					$activity='Attempted Saving A Trade With Id '.$trade['trade_id'].' But Failed. Details Of The Trade Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Sell Order Id: '.$trade['sell_order_id'].'; Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Ask Price: '.$trade['ask_price'].'; Trade Price: '.$trade['price'].'; Market Price: '.$trade['market_price'].'; Trade Amount: '.round((floatval($trade['num_tokens']) * floatval($trade['price'])),2).'; NSE Commission: '.$trade['nse_fee'].'; Transfer Fees: '.$trade['transfer_fees'].'; Trade Status: '.$trade['tradestatus'].'; Payment Status: '.$trade['payment_status'].'; Engine Type: Direct; Total Buyer Fee: '.$trade['total_buyer_fee'].'; Total Seller Fee: '.$trade['total_seller_fee'];
				}
			}else
			{		
				//Log activity
				$operation='Saved Trade Record';
				
				if (trim($trade['sell_broker_id']) <> '')
				{
					$activity='A Trade Was Created With Id '.$trade['trade_id'].'. Details Of The Trade Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Seller Broker Id: '.$trade['sell_broker_id'].'; Sell Order Id: '.$trade['sell_order_id'].'; Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Ask Price: '.$trade['ask_price'].'; Trade Price: '.$trade['price'].'; Market Price: '.$trade['market_price'].'; Trade Amount: '.round((floatval($trade['num_tokens']) * floatval($trade['price'])),2).'; Seller Broker Fee: '.$trade['sell_broker_fee'].'; NSE Commission: '.$trade['nse_fee'].'; Transfer Fees: '.$trade['transfer_fees'].'; Trade Status: '.$trade['tradestatus'].'; Payment Status: '.$trade['payment_status'].'; Engine Type:  Direct; Total Buyer Fee: '.$trade['total_buyer_fee'].'; Total Seller Fee: '.$trade['total_seller_fee'];	
				}else
				{
					$activity='A Trade Was Created With Id '.$trade['trade_id'].'. Details Of The Trade Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Sell Order Id: '.$trade['sell_order_id'].'; Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Ask Price: '.$trade['ask_price'].'; Trade Price: '.$trade['price'].'; Market Price: '.$trade['market_price'].'; Trade Amount: '.round((floatval($trade['num_tokens']) * floatval($trade['price'])),2).'; NSE Commission: '.$trade['nse_fee'].'; Transfer Fees: '.$trade['transfer_fees'].'; Trade Status: '.$trade['tradestatus'].'; Payment Status: '.$trade['payment_status'].'; Engine Type:  Direct; Total Buyer Fee: '.$trade['total_buyer_fee'].'; Total Seller Fee: '.$trade['total_seller_fee'];
				}				
									
				$ret=true;
			}
		}		
		
		//Log activity
		$username='System';
		$fullname='Naija Art Mart Core';
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
		$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
		
		return $ret;
	}
	
	function InvestorBalanceWalletAfterTrade($deductions)
	{//Deduct from buyer's wallet balance
	
	//$deductions[]=array('trade_id', "amount", "reason", "investor_id");
	
		$ret=false;

		foreach($deductions as $deduct)
		{			
			$this->db->trans_start();			
			
			$this->db->set('balance', 'balance - '.$deduct['amount'],false);
			
			$where="(TRIM(email)='".$deduct['investor_id']."')";
			
			$this->db->where($where);
			$this->db->update('wallets');
				
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE)
			{
				$operation='Deduction Of Trade Amount From Wallet For Trade With Id '.$deduct['trade_id'].' Failed';
				
				$activity='Attempted Deducting The Trade Amount From The Investor Wallet Balance For A Trade With Id '.$deduct['trade_id'].' But Failed. Details Of The Trade Are: Trade Id: '.$deduct['trade_id'].'; Buyer Email: '.$deduct['investor_id'].'; Description: '.$deduct['reason'];
			}else
			{		
				//Log activity
				$operation='Deducted Trade Amount From Wallet';
				
				$activity="Trade Amount Was Deducted From Buyer Broker's Wallet For Trade With Id ".$deduct['trade_id'].". Details Of The Trade Are: Trade Id: ".$deduct['trade_id']."; Buyer Email: ".$deduct['investor_id']."; Description: ".$deduct['reason'];
									
				$ret=true;
			}		
		}		
	
		//Log activity
		$username='System';
		$fullname='Naija Art Mart Core';
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
		$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
		
		return $ret;
	}
	
	function ValidateInvestorDirectOrder($order)
	{
		$m='';
		
		$ret = $this->GetMarketStatus();
		$MarketStatus = $ret['MarketStatus'];
		
		//if (trim(strtolower($MarketStatus)) == 'closed') return array('status'=>0,'msg'=>"Market has closed for today.");
		
		$today=date('Y-m-d');		
		
		if (!$order['orderdate']) $order['orderdate']=$this->GetOrderTime();		
		if (!$order['order_id']) $order['order_id']=$this->GetId('direct_orders','order_id');	
			
		$set=$this->GetTradingParamaters();
		$paystack=$this->GetPaystackSettings();
		$order['orderstatus']="Not Active";		
				
		//investor_email
		$order['investor_email']=trim($order['investor_email']);
		
		if (!$order['investor_email'])
		{
			$m="Investor email field is empty. Please resend the order."; 
			return array('status'=>0,'msg'=>$m);
		}
		
		$inv_status=$this->IsValidateInvestor($order['investor_email']);		
		if ($inv_status !== true) return array('status'=>0,'msg'=>$inv_status);
		
		//Investor recipient code
		if ((!$order['investor_recipient_code']) or (trim($order['investor_recipient_code'])==''))
		{
			$m="Investor payment recipient code is not available. Your registration process is not complete. You need to supply your account details before you can carry out any trade. Go to your profile and update the account details."; 
			return array('status'=>0,'msg'=>$m);
		}
		
		//transtype
		$order['transtype']=trim($order['transtype']);
		
		if (!$order['transtype'])
		{
			$m="Transaction type field is empty. Please resend the order."; 
			return array('status'=>0,'msg'=>$m);
		}
		
		if (trim(strtolower($order['transtype']))<>'sell') $order['transtype']='Sell';		
		
		//symbol
		$order['symbol']=strtoupper(trim($order['symbol']));
		
		if (!$order['symbol'])
		{
			$m="Transaction asset field is empty. Please resend the order.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (is_numeric($order['symbol']))
		{
			$m="Asset MUST NOT be a number. Please resend the order with a valid asset.";
			return array('status'=>0,'msg'=>$m);
		}
		
		$sym=$this->IsValidateSymbol($order['symbol']);	
		if ($sym !== true) return array('status'=>0,'msg'=>$sym);
		
		//Get Symbol Price
		$price=$this->GetSymbolPrice($order['symbol']);
		
		$price_limit_percent=0; $upperlimit=0; $lowerlimit=0; $close_time=''; $max_order_days=0;
		$min_buy_qty=0; $broker_commission=0; $nse_commission=0;
		
		//Check if amount is within accepted limited				
		if ($set->price_limit_percent) $price_limit_percent = $set->price_limit_percent;
		if ($set->market_close_time) $close_time = $set->market_close_time;
		if ($set->max_order_days) $max_order_days = $set->max_order_days;
		if ($set->min_buy_qty) $min_buy_qty = $set->min_buy_qty;
		
		//ordertype
		$order['ordertype']=strtoupper(trim($order['ordertype']));
		$order['price']=str_replace(",","",trim($order['price']));//price	
		
		if (!$order['ordertype']) $order['ordertype']="Market";		
			
		if ((trim($order['price'])=='') or (floatval($order['price']) == 0))
		{
			$m="Selling price field is empty. Please resend the order.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (!is_numeric($order['price']))//Not numeric
		{
			$m="Selling price must be a number. Please resend the order with a valid price.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (floatval($order['price'])==0)//Zero sent
		{
			$m="Selling price MUST NOT be zero. Please resend the order with a valid price.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (floatval($order['price'])<0)//Negative number sent
		{
			$m="Selling price MUST NOT be a negative number. Please resend the order with a valid price.";
			return array('status'=>0,'msg'=>$m);
		}
						
		$diff=(floatval($price_limit_percent)/100) * $price;			
		$lowerlimit = floatval($price) - floatval($diff);
		$upperlimit = floatval($price) + floatval($diff);
							
		if (floatval($order['price'])< floatval($lowerlimit))//Exceeded lower limit
		{
			$m="The selling price of ".number_format($order['price'],2,'.','')." is less than the minimum price, ".number_format($lowerlimit,2,'.','').", allowed for the asset. Please resend the order with a valid price.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (floatval($order['price']) > floatval($upperlimit))//Exceeded upper limit
		{
			$m="The selling price of ".number_format($order['price'],2,'.','')." is more than the maximum price, ".number_format($upperlimit,2,'.','').", allowed for the asset. Please resend the order with a valid price.";
			return array('status'=>0,'msg'=>$m);
		}			
		
		//qty
		$order['qty']=str_replace(",","",trim($order['qty']));
		
		if ((trim($order['qty'])=='') or (floatval($order['qty']) == 0))
		{
			$m="Transaction quantity field is empty. Please resend the order.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (!is_numeric($order['qty']))//Not numeric
		{
			$m="Transaction quantity must be a number. Please resend the order with a valid quantity.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (floatval($order['qty'])==0)//Zero sent
		{
			$m="Transaction quantity MUST NOT be zero. Please resend the order with a valid quantity.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (floatval($order['qty'])<0)//Negative number sent
		{
			$m="Transaction quantity MUST NOT be a negative number. Please resend the order with a valid quantity.";
			return array('status'=>0,'msg'=>$m);
		}
		
		//$fees=$this->GetTradeFees($order['qty'],$order['price']);
			
		//if (floatval($order['trade_amount']) < 0) $order['trade_amount']=$fees['TradeAmount'];
		//if (floatval($order['nse_commission']) < 0) $order['nse_commission']=$fees['NSEFee'];
		//if (floatval($order['transfer_fee']) < 0) $order['transfer_fee']=$fees['TransferFee'];
		//if (floatval($order['total_amount']) < 0) $order['total_amount']=$fees['TotalAmount'];
						
		$order['orderstatus']="Active";
		
		$m="Your order to sell ".number_format($order['qty'],0)." tokens of ".$order['symbol']." at ".number_format($order['price'],2,'.',',')." per token has been successful placed.";
		
		return array('status'=>1,'msg'=>$m,'ChangePriceQty'=>$min_buy_qty,'order'=>$order);
	}
	
	function SaveInvestorDirectOrder($order)
	{		
		$this->db->trans_start();
		//$order=array('order_id', 'investor_id','investor_email', 'investor_phone', 'transtype', 'symbol', 'price', 'qty', 'available_qty',  'ordertype', 'orderdate', 'orderstatus', 'nse_commission', 'transfer_fee', 'sms_fee', 'total_amount', 'trade_amount', 'investor_recipient_code', 'transfer_fee');		
		$dat=array(
			'order_id' 					=> $this->db->escape_str($order['order_id']),
			'investor_id' 				=> $this->db->escape_str($order['investor_email']),
			'transtype' 				=> $this->db->escape_str($order['transtype']),
			'ordertype'					=> $this->db->escape_str($order['ordertype']),			
			'symbol' 					=> $this->db->escape_str($order['symbol']),			
			'price'						=> $this->db->escape_str($order['price']),
			'qty' 						=> $this->db->escape_str($order['qty']),			
			'available_qty' 			=> $this->db->escape_str($order['available_qty']),
			'orderstatus'				=> $this->db->escape_str($order['orderstatus']),
			'nse_commission' 			=> $this->db->escape_str($order['nse_commission']),
			'transfer_fee' 				=> $this->db->escape_str($order['transfer_fee']),
			'sms_fee' 					=> $this->db->escape_str($order['sms_fee']),
			'investor_recipient_code'	=> $this->db->escape_str($order['investor_recipient_code']),			
			'orderdate' 				=> $this->db->escape_str($order['orderdate']),
			'total_amount' 				=> $this->db->escape_str($order['total_amount'])
		);
		
		$this->db->insert('direct_orders', $dat);	
			
		$this->db->trans_complete();
		
		$ret=false;
		
		if ($this->db->trans_status() === FALSE)
		{
			$operation='Saved Sell Order Failed';
			$activity='Attempted Saving A Sell Order Created By Investor With Email '.$order['investor_email'].' But Failed. Details Of The Order Are: Order Date: '.$order['orderdate'].'; Order Id: '.$order['order_id'].'; Trade Type: '.$order['transtype'].'; Investor Email: '.$order['investor_email'].'; Asset: '.$order['symbol'].'; Order Quantity: '.$order['qty'].'; Price Per Token: '.$order['price'].'; Order Type: '.$order['ordertype'].'; Order Status: '.$order['orderstatus'].'; NSE Commission: '.$order['nse_commission'].'; Trade Amount: '.$order['trade_amount'].'; Transfer Fee: '.$order['transfer_fee'].'; Total Amount: '.$order['total_amount'];
		}else
		{		
			//Log activity
			$operation='Saved '.$order['transtype'].' Order';
			$activity='An Order Was Created For Investor With Email '.$order['investor_email'].'. Details Of The Order Are: Order Date: '.$order['orderdate'].'; Order Id: '.$order['order_id'].'; Trade Type: '.$order['transtype'].'; Investor Email: '.$order['investor_email'].'; Asset: '.$order['symbol'].'; Order Quantity: '.$order['qty'].'; Price Per Token: '.$order['price'].'; Order Type: '.$order['ordertype'].'; Order Status: '.$order['orderstatus'].'; NSE Commission: '.$order['nse_commission'].'; Trade Amount: '.$order['trade_amount'].'; Transfer Fee: '.$order['transfer_fee'].'; Total Amount: '.$order['total_amount'];
								
			$ret=true;
		}
		
		//Log activity
		$username='System';
		$fullname='Naija Art Mart Core';
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
		$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
		
		return $ret;
	}
	
	//******************** End Investor Direct Sell ******************************
	
	
	//******************** Direct Sell ******************************
	function CheckIfMessageDateHasExpired()
	{
		$ret=$this->GetParamaters();
		
		$period=7;
		
		if ($ret->message_delete_period) $period=$ret->message_delete_period;
		
		$sql="SELECT msgid FROM messages WHERE DATE_FORMAT(DATE_ADD(msgdate, INTERVAL ".$period." DAY),'%Y-%m-%d') < DATE_FORMAT(NOW(),'%Y-%m-%d')";		
			   		
		$query = $this->db->query($sql);
		
		$rows = $query->result_array();
	
		return $rows;
		
		//if (trim($date)<>'')
		//{
			//if (strtotime(date('Y-m-d')) > strtotime($date)) $ret=true;
		//}
		
		
	}
	
	function SavePrimaryTrade($trade)
	{
		$ret=false;
			
		if (is_array($trade))
		{
			$this->db->trans_start();

			$dat=array(
				'buy_broker_id' 		=> $this->db->escape_str($trade['buy_broker_id']),				
				'buy_investor_email' 	=> $this->db->escape_str($trade['buy_investor_email']),				
				'issuer_email'			=> $this->db->escape_str($trade['issuer_email']),						
				'trade_id' 				=> $this->db->escape_str($trade['trade_id']),				
				'symbol'				=> $this->db->escape_str($trade['symbol']),				
				'num_tokens' 			=> $this->db->escape_str($trade['num_tokens']),				
				'trade_price' 			=> $this->db->escape_str($trade['price']),
				'issuer_fee' 			=> $this->db->escape_str($trade['total_issuer_fee']),				
				'buy_broker_fee' 		=> $this->db->escape_str($trade['buy_broker_fee']),				
				'nse_fee' 				=> $this->db->escape_str($trade['nse_fee']),				
				'transfer_fees' 		=> $this->db->escape_str($trade['transfer_fees']),
				'tradestatus' 			=> $this->db->escape_str($trade['tradestatus']),
				'payment_status' 		=> $this->db->escape_str($trade['payment_status']),												
				'total_buyer_fee' 		=> $this->db->escape_str($trade['total_buyer_fee']),
				'engine_type' 			=> 'Direct',				
				'tradedate'				=> $this->db->escape_str($trade['tradedate'])
			);
			
			$this->db->insert('primary_trades', $dat);	
				
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE)
			{
				$operation='Saving Primary Market Trade Record With Trade Id '.$trade['trade_id'].' Failed';
				
				$activity='Attempted Saving A Primary Market Trade With Id '.$trade['trade_id'].' But Failed. Details Of The Trade Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Buyer Broker Id: '.$trade['buy_broker_id'].'; Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Trade Price: '.$trade['price'].'; Trade Amount: '.round((floatval($trade['num_tokens']) * floatval($trade['price'])),2).'; Buyer Broker Fee: '.$trade['buy_broker_fee'].'; NSE Commission: '.$trade['nse_fee'].'; Transfer Fees: '.$trade['transfer_fees'].'; Trade Status: '.$trade['tradestatus'].'; Payment Status: '.$trade['payment_status'].'; Engine Type: Direct; Total Buyer Fee: '.$trade['total_buyer_fee'].'; Total Issuer Fee: '.$trade['total_issuer_fee'];
			}else
			{		
				//Log activity
				$operation='Saved Primary Market Trade Record';
				
				$activity='A Trade Was Created With Id '.$trade['trade_id'].'. Details Of The Trade Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Buyer Broker Id: '.$trade['buy_broker_id'].'; Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Trade Price: '.$trade['price'].'; Trade Amount: '.round((floatval($trade['num_tokens']) * floatval($trade['price'])),2).'; Buyer Broker Fee: '.$trade['buy_broker_fee'].'; NSE Commission: '.$trade['nse_fee'].'; Transfer Fees: '.$trade['transfer_fees'].'; Trade Status: '.$trade['tradestatus'].'; Payment Status: '.$trade['payment_status'].'; Engine Type:  Direct; Total Buyer Fee: '.$trade['total_buyer_fee'].'; Total Issuer Fee: '.$trade['total_issuer_fee'];
									
				$ret=true;
			}
		}		
		
		//Log activity
		$username='System';
		$fullname='Naija Art Mart Core';
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
		$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
		
		return $ret;
	}
	
	function GetListingDetailsFromSymbol($symbol)
	{
		$sql="SELECT * FROM listed_artworks WHERE (TRIM(symbol)='".$this->db->escape_str($symbol)."')";		
			   		
		$query = $this->db->query($sql);
		
		$row = $query->row();
	
		return $row;
	}
	
	function CheckIfDateHasExpired($date)
	{
		$ret=false;
		
		if (trim($date)<>'')
		{
			if (strtotime(date('Y-m-d')) > strtotime($date)) $ret=true;
		}
		
		return $ret;
	}
	
	function PrimaryMarketEngine($trade)
	{
		$dt=date('Y-m-d H:i:s');
		
		$ret=array();				
		$symbol			= $trade['symbol'];
		$paystack 		= $this->GetPaystackSettings();
		$setings		= $this->GetTradingParamaters();
		
			//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($trade,true)); fclose($file); return;	

		//$trade=array('buy_broker_id', 'trade_id', 'symbol', 'num_tokens', 'price', 'buy_broker_fee', 'nse_fee', 'transfer_fees', 'tradestatus', 'payment_status', 'tradedate', 'trade_amount', 'total_buyer_fee', 'total_issuer_fee', 'issuer_recipient_code', 'buyer_recipient_code', 'buy_broker_recipient_code', 'nse_recipient_code', 'buy_broker_email', 'buy_investor_email', 'issuer_uid', 'issuer_email', 'buy_broker_phone', 'issuer_phone', 'buy_investor_phone', 'buy_broker_name', 'issuer_name', 'buy_investor_name');
		
		$transfers=array();  $currency='NGN'; $listing_ends=''; $listing_ended='0';
		
		$set=$this->GetTradingParamaters();
		$lst=$this->GetListingDetailsFromSymbol($symbol);
		
		if ($lst->listing_ends) $listing_ends=$lst->listing_ends;
		
		$expired=$this->CheckIfDateHasExpired($listing_ends);
		
		if ($expired) $listing_ended='1';
				
		$deductions=array(); $trades_payments=array(); $issuers_to_pay=array();

		/****** PAYMENTS *****/
		//ISSUER
		$desc="Payment For Sales Of ".$trade['num_tokens']." Tokens Of ".$trade['symbol']." At ".round($trade['price'],2)." Per Token At The Primary Market. Trade Id Is ".$trade['trade_id'];
							
		$issuers_to_pay[] = array('issuer_uid'=>$trade['issuer_uid'],'issuer_email'=>$trade['issuer_email'],'trade_id'=>$trade['trade_id'],'trade_date'=>$trade['tradedate'],'symbol'=>$trade['symbol'],'num_tokens'=>$trade['num_tokens'],'price'=>$trade['price'],'trade_amount'=>$trade['trade_amount'],'recipient_amount'=>$trade['total_issuer_fee'],'currency'=>$currency,'description'=>$desc,'recipient'=>'Issuer','recipient_code'=>$trade['issuer_recipient_code'],'transfer_code'=>'','listing_ended'=>$listing_ended,'payment_status'=>'0');
		
		//******Buyer Broker*********
		$desc = "Commission For Buying Of ".$trade['num_tokens']." Tokens Of ".$trade['symbol']." At ".round($trade['price'],2)." Per Token At The Primary Market. Trade Id Is ".$trade['trade_id'];
						
		$transfers[]=array("amount"=>($trade['buy_broker_fee'] * 100), "reason"=>$desc, "recipient"=>$trade['buy_broker_recipient_code']);
		
		$trades_payments[] = array('trade_id'=>$trade['trade_id'],'symbol'=>$trade['symbol'],'num_tokens'=>$trade['num_tokens'],'price'=>$trade['price'],'trade_amount'=>$trade['trade_amount'],'recipient_amount'=>$trade['buy_broker_fee'],'recipient'=>'Buyer Broker','recipient_code'=>$trade['buy_broker_recipient_code'],'description'=>$desc,'trade_date'=>$trade['tradedate'],'currency'=>$currency,'transfer_code'=>'');
		
		
		//Deduction from buyer
		$deductions[]=array('trade_id'=>$trade['trade_id'],"amount"=>$trade['total_buyer_fee'], "reason"=>"Payment For Purchase Of ".$trade['num_tokens']." Tokens Of ".$trade['symbol']." At ".$trade['price']." Per Token And Commissions At The Primary Market. Trade Id Is ".$trade['trade_id'], "investor_id"=>$trade['buy_investor_email'],'buyer_broker_id'=>$trade['buy_broker_id']);		
		
		//NSE
		$desc="Commission For Trading Of ".$trade['num_tokens']." Tokens Of ".$trade['symbol']." At ".$trade['price']." Per Token At The Primary Market. Trade Id Is ".$trade_id;
		
		$transfers[]=array("amount"=>($trade['nse_fee'] * 100), "reason"=>$desc, "recipient"=>$trade['nse_recipient_code']);
		
		$trades_payments[] = array('trade_id'=>$trade['trade_id'],'symbol'=>$trade['symbol'],'num_tokens'=>$trade['num_tokens'],'price'=>$trade['price'],'trade_amount'=>$trade['trade_amount'],'recipient_amount'=>$trade['nse_fee'],'recipient'=>'NSE','recipient_code'=>$trade['nse_recipient_code'],'description'=>$desc,'trade_date'=>$trade['tradedate'],'currency'=>$currency,'transfer_code'=>'');		
	
		//Make transfers		
		$recipients=array("currency"=>$currency, "source"=>"balance", "transfers"=>$transfers);				
				
		$recipients_string = http_build_query($recipients);		
		$transfer_result = $this->PaystackBulkTransferFunds($recipients_string);
		
		if ($transfer_result['Status']==1)
		{//$transfer_result = array('Status','data') - data='Recipient','Amount','TransferCode','Currency'
			//Log successful transfer
			$operation='Transfer Of Primary Market Trade Commission';
					
			$activity='Transfer of funds to buyer broker and NSE was done successfully from the primary market trade with Id '.$trade['trade_id'].'. Details Of The Transfer Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Buyer Broker Id: '.$trade['buy_broker_id'].'; Issuer Email: '.$trade['issuer_email'].'; Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Trade Price: '.$trade['price'].'; Trade Amount: '.(floatval($trade['num_tokens']) * floatval($trade['price'])).'; Buyer Broker Fee: '.$trade['buy_broker_fee'].'; NSE Commission: '.$trade['nse_fee'].'; Payment Status: '.$trade['payment_status'].'; Engine Type: Direct; Issuer Fee: '.$trade['total_issuer_fee'];
					
			$username='System';
			$fullname='Naija Art Mart Core';
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
			
			$r=$this->BalanceWalletAfterTrade($deductions); //Deduct from Wallet			
			
			if ($r==true)
			{
				//$issuers_to_pay[] = array('issuer_email', 'trade_id', 'trade_date', 'symbol', 'num_tokens', 'price', 'trade_amount', 'recipient_amount', 'currency', 'description', 'recipient', 'recipient_code', 'transfer_code', 'listing_ended', 'payment_status');
				
				//Log the issuer payment to issuers_to_pay table
				if (count($issuers_to_pay) > 0)
				{
					foreach($issuers_to_pay as $rec)
					{
						$sql="SELECT * FROM issuers_to_pay WHERE (TRIM(issuer_email)='".$this->db->escape_str($rec['issuer_email'])."') AND (TRIM(trade_id)='".$this->db->escape_str($rec['trade_id'])."') AND (TRIM(symbol)='".$this->db->escape_str($rec['symbol'])."')";
							
						$query=$this->db->query($sql);
						
						if ($query->num_rows() == 0)
						{
							$this->db->trans_start();			
							
							$dat=array(
								'issuer_uid' 		=> $this->db->escape_str($rec['issuer_uid']),
								'issuer_email' 		=> $this->db->escape_str($rec['issuer_email']),
								'trade_id' 			=> $this->db->escape_str($rec['trade_id']),
								'symbol' 			=> $this->db->escape_str($rec['symbol']),
								'num_tokens'		=> $this->db->escape_str($rec['num_tokens']),
								'price' 			=> $this->db->escape_str($rec['price']),
								'trade_amount' 		=> $this->db->escape_str($rec['trade_amount']),
								'recipient_amount'	=> $this->db->escape_str($rec['recipient_amount']),
								'currency' 			=> $this->db->escape_str($rec['currency']),
								'description' 		=> $this->db->escape_str($rec['description']),
								'recipient' 		=> $this->db->escape_str($rec['recipient']),
								'recipient_code' 	=> $this->db->escape_str($rec['recipient_code']),
								'transfer_code' 	=> $this->db->escape_str($rec['transfer_code']),
								'listing_ended' 	=> $this->db->escape_str($rec['listing_ended']),
								'payment_status' 	=> $this->db->escape_str($rec['payment_status']),
								'trade_date'		=> $this->db->escape_str($rec['trade_date'])
							);
							
							$this->db->insert('issuers_to_pay', $dat);	
								
							$this->db->trans_complete();
						}
					}
				}
				
				//Process transfer data
				$paydata=$transfer_result['data'];
			
				if (count($paydata) > 0)
				{
					foreach($paydata as $pd)
					{
						for($i=0; $i < count($trades_payments); $i++)
						{//'Recipient','Amount','TransferCode','Currency'							
							if (trim($pd['Recipient'] == trim($trades_payments[$i]['recipient_code'])) And (floatval($pd['Amount']/100) == floatval($trades_payments[$i]['recipient_amount'])))
							{
								$trades_payments[$i]['transfer_code']=$pd['TransferCode'];
							}
						}						
					}
				}		
		
				$save_trade_result=$this->SavePrimaryTrade($trade); //Save trade
								
				//Update portfolios	
				$issuer_name=''; $issuer_uid=''; $buy_email='';	$buy_uid=''; $title='';
				
				//Issuer
				$inv_rw = $this->GetIssuerDetails($trade['issuer_email']);				
				if ($inv_rw->user_name) $issuer_name = trim($inv_rw->user_name);
				if ($inv_rw->uid) $issuer_uid = trim($inv_rw->uid);
				if ($inv_rw->blockchain_address) $issuer_address = trim($inv_rw->blockchain_address);

				//Buyer
				$inv_rw = $this->GetInvestorDetails($trade['buy_investor_email']);				
				if ($inv_rw->email) $buy_email = trim($inv_rw->email);
				if ($inv_rw->uid) $buy_uid = trim($inv_rw->uid);
				if ($inv_rw->blockchain_address) $buy_address = trim($inv_rw->blockchain_address);
				
				$at = $this->GetArtTitle($trade['symbol']);
				$art_id = $this->GetArtId($trade['symbol']);
				$title = trim($at);

				//make trade on blockchain
				$this->MakeTradeOnBlockchain($trade['issuer_email'],$issuer_address,$art_id,$trade['num_tokens'],$buy_address,$trade['buy_investor_email']);
				
				
				//Buyer
				$sql="SELECT * FROM portfolios WHERE ((TRIM(email)='".$this->db->escape_str($buy_email)."') OR (TRIM(uid)='".$this->db->escape_str($buy_uid)."')) AND (TRIM(broker_id)='".$this->db->escape_str($trade['buy_broker_id'])."') AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
					
				$query=$this->db->query($sql);
				
				$buy_old_portfolio=0; $buy_new_portfolio=0; 
				
				if ($query->num_rows() > 0)
				{
					$rr = $query->row();
					
					if ($rr->tokens) $buy_old_portfolio =$rr->tokens;
					
					$tok = intval($rr->tokens) + intval($trade['num_tokens']);
					$buy_new_portfolio=$tok;
					
					$this->db->trans_start();	
					
					$dat=array(
						'tokens' 		=> $this->db->escape_str($tok),
						'currentprice' 	=> $this->db->escape_str($trade['market_price']),
						'price_bought' 	=> $this->db->escape_str($trade['price']),
						'date_updated'	=> $dt
					);			
	
					$this->db->where(array('email'=>$buy_email,'broker_id'=>$trade['buy_broker_id'],'symbol'=>$trade['symbol']));
					$this->db->update('portfolios',$dat);
												
					$this->db->trans_complete();
				}else
				{
					$buy_new_portfolio=$trade['num_tokens'];
					
					$this->db->trans_start();			
					
					$dat=array(
						'email' 		=> $this->db->escape_str($buy_email),
						'uid' 			=> $this->db->escape_str($buy_uid),
						'broker_id' 	=> $this->db->escape_str($trade['buy_broker_id']),
						'symbol'		=> $this->db->escape_str($trade['symbol']),
						'art_title' 	=> $this->db->escape_str($title),
						'tokens' 		=> $this->db->escape_str($trade['num_tokens']),
						'price_bought' 	=> $this->db->escape_str($trade['price']),
						'currentprice' 	=> $this->db->escape_str($trade['market_price']),
						'date_created'	=> $dt
					);
					
					$this->db->insert('portfolios', $dat);	
						
					$this->db->trans_complete();
				}

				//Issuer
				$sql="SELECT * FROM primary_market WHERE (TRIM(uid)=".$this->db->escape_str($issuer_uid).") AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
				
				$query=$this->db->query($sql);
				
				$sell_old_portfolio=0; $sell_new_portfolio=0;
				
				if ($query->num_rows() > 0)
				{
					$rr = $query->row();
					if ($rr->tokens_available) $sell_old_portfolio = $rr->tokens_available;
					
					$sell_new_portfolio = intval($sell_old_portfolio) - intval($trade['num_tokens']);	
										
					$this->db->trans_start();	
					
					$dat=array(
						'tokens_available'	=> $this->db->escape_str($sell_new_portfolio),
						'market_date'		=> $dt
					);		
	
					$this->db->where(array('uid'=>$issuer_uid,'symbol'=>$trade['symbol']));
					$this->db->update('primary_market',$dat);
												
					$this->db->trans_complete();
				}
				
				//listed_artworks
				$sql="SELECT * FROM listed_artworks WHERE (TRIM(uid)=".$this->db->escape_str($issuer_uid).") AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
				
				$query=$this->db->query($sql);
				
				if ($query->num_rows() > 0)
				{										
					$this->db->trans_start();	
					
					$dat=array('tokens_available' => $this->db->escape_str($sell_new_portfolio));		
	
					$this->db->where(array('uid'=>$issuer_uid,'symbol'=>$trade['symbol']));
					$this->db->update('listed_artworks',$dat);
												
					$this->db->trans_complete();
				}
				
				//Log Portfolio Update
				$operation='Updated Issuer And Buyer Portfolios';
		
				$activity='Updated Issuer And Buyer portfolios after trade successfully. Details Of Portfolio Update: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Asset: '.$trade['symbol'].'; Buyer Old Portfolio Quantity: '.$buy_old_portfolio.'; Buyer New Portfolio Quantity: '.$buy_new_portfolio.'; Issuer Old Portfolio Quantity: '.$sell_old_portfolio.'; Issuer New Portfolio Quantity: '.$sell_new_portfolio;
						
				$username='System';
				$fullname='Naija Art Mart Core';
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
				$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
				
								
				//$trades_payments= array('trade_id','symbol','num_tokens','price','trade_amount','recipient_amount','recipient','recipient_code','description','trade_date','currency','transfer_code');
				
				if (count($trades_payments) > 0)
				{
					foreach($trades_payments as $pay)
					{
						$sql="SELECT * FROM trades_payments WHERE (TRIM(trade_id)='".$this->db->escape_str($pay['trade_id'])."') AND (TRIM(recipient)='".$this->db->escape_str($pay['recipient'])."') AND (TRIM(recipient_amount)=".$this->db->escape_str($pay['recipient_amount']).") AND (TRIM(recipient_code)='".$this->db->escape_str($pay['recipient_code'])."')";
					
						$query=$this->db->query($sql);
						
						if ($query->num_rows() == 0)
						{
							$this->db->trans_start();	
								
							$dat=array(
								'trade_id' 			=> $this->db->escape_str($pay['trade_id']),
								'symbol' 			=> $this->db->escape_str($pay['symbol']),
								'num_tokens' 		=> $this->db->escape_str($pay['num_tokens']),
								'currency' 			=> $this->db->escape_str($pay['currency']),
								'price' 			=> $this->db->escape_str($pay['price']),
								'trade_amount' 		=> $this->db->escape_str($pay['trade_amount']),
								'recipient_amount'	=> $this->db->escape_str($pay['recipient_amount']),
								'recipient' 		=> $this->db->escape_str($pay['recipient']),
								'recipient_code' 	=> $this->db->escape_str($pay['recipient_code']),
								'description'		=> $this->db->escape_str($pay['description']),
								'transfer_code'		=> $this->db->escape_str($pay['transfer_code']),
								'transfer_date'		=> $this->db->escape_str($pay['trade_date']),
								'trade_date'		=> $this->db->escape_str($pay['trade_date'])
							);
				
							$this->db->insert('trades_payments', $dat);	
								
							$this->db->trans_complete();
						}
					}
				}
			
				$sms=0;
				
				if ($setings->sms_fee) $sms = $setings->sms_fee;
				
				$transact_partners = array("symbol"=>$symbol,"broker_id"=>$trade['buy_broker_id'],"investor_id"=>$trade['buy_investor_email'],"qty" => $trade['num_tokens'],"price" => $trade['price'], 'sms_fee'=>($sms * 2),'transtype'=>$transtype);
		
				$ret = array('Status'=>1,"msg"=>"Trade Was Successful. ".$trade['num_tokens']." Tokens Of ".$symbol." Was Sold At ".round($trade['price'],2).".","trade_id"=>$trade['trade_id'],'transact_partners'=>$transact_partners);	
			}else
			{
				$ret = array('Status'=>'FAIL','msg'=>'Trade Execution Failed. Funds Deduction From Buyer Broker Wallet Was Not Successful.');
			}
		}else
		{
			$ret = array('Status'=>'FAIL','msg'=>'Trade Execution Failed. Funds Transfer Was Not Successful. ERROR: '.strtoupper($transfer_result['Message']));
		}
				
		return $ret;
	}
	
	function GetDirectOrderDetails($orderid)
	{
		$sql="SELECT * FROM trades WHERE (TRIM(sell_order_id)=".$this->db->escape_str($orderid).")";		
			   		
		$query = $this->db->query($sql);
		
		$row = $query->row();
	
		return $row;
	}
	
	function SaveDirectOrder($order)
	{		
		$this->db->trans_start();
			
		$dat=array(
			'order_id' 					=> $this->db->escape_str($order['order_id']),
			'broker_id' 				=> $this->db->escape_str($order['broker_id']),
			'investor_id' 				=> $this->db->escape_str($order['investor_id']),
			'transtype' 				=> $this->db->escape_str($order['transtype']),
			'ordertype'					=> $this->db->escape_str($order['ordertype']),			
			'symbol' 					=> $this->db->escape_str($order['symbol']),			
			'price'						=> $this->db->escape_str($order['price']),
			'qty' 						=> $this->db->escape_str($order['qty']),			
			'available_qty' 			=> $this->db->escape_str($order['available_qty']),
			'orderstatus'				=> $this->db->escape_str($order['orderstatus']),
			'broker_commission' 		=> $this->db->escape_str($order['broker_commission']),
			'nse_commission' 			=> $this->db->escape_str($order['nse_commission']),
			'transfer_fee' 				=> $this->db->escape_str($order['transfer_fee']),
			'sms_fee' 					=> $this->db->escape_str($order['sms_fee']),
			'broker_recipient_code' 	=> $this->db->escape_str($order['broker_recipient_code']),
			'investor_recipient_code'	=> $this->db->escape_str($order['investor_recipient_code']),			
			'orderdate' 				=> $this->db->escape_str($order['orderdate']),
			'total_amount' 				=> $this->db->escape_str($order['total_amount'])
		);
		
		$this->db->insert('direct_orders', $dat);	
			
		$this->db->trans_complete();
		
		$ret=false;
		
		if ($this->db->trans_status() === FALSE)
		{
			$operation='Saved Sell Order Failed';
			$activity='Attempted Saving A Sell Order Created By Broker With Id '.$order['broker_id'].' But Failed. Details Of The Order Are: Order Date: '.$order['orderdate'].'; Order Id: '.$order['order_id'].'; Trade Type: '.$order['transtype'].'; Broker Id: '.$order['broker_id'].'; Investor Id: '.$order['investor_id'].'; Asset: '.$order['symbol'].'; Order Quantity: '.$order['qty'].'; Price Per Token: '.$order['price'].'; Order Type: '.$order['ordertype'].'; Order Status: '.$order['orderstatus'].'; Broker Commission: '.$order['broker_commission'].'; NSE Commission: '.$order['nse_commission'].'; Trade Amount: '.$order['trade_amount'].'; Transfer Fee: '.$order['transfer_fee'].'; Total Amount: '.$order['total_amount'];
		}else
		{		
			//Log activity
			$operation='Saved '.$order['transtype'].' Order';
			$activity='An Order Was Created For Broker With Id '.$order['broker_id'].'. Details Of The Order Are: Order Date: '.$order['orderdate'].'; Order Id: '.$order['order_id'].'; Trade Type: '.$order['transtype'].'; Broker Id: '.$order['broker_id'].'; Investor Id: '.$order['investor_id'].'; Asset: '.$order['symbol'].'; Order Quantity: '.$order['qty'].'; Price Per Token: '.$order['price'].'; Order Type: '.$order['ordertype'].'; Order Status: '.$order['orderstatus'].'; Broker Commission: '.$order['broker_commission'].'; NSE Commission: '.$order['nse_commission'].'; Trade Amount: '.$order['trade_amount'].'; Transfer Fee: '.$order['transfer_fee'].'; Total Amount: '.$order['total_amount'];
								
			$ret=true;
		}
		
		//Log activity
		$username='System';
		$fullname='Naija Art Mart Core';
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
		$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
		
		return $ret;
	}
	
	function ValidateDirectOrder($order)
	{
		$m='';
		
		$ret = $this->GetMarketStatus();
		$MarketStatus = $ret['MarketStatus'];
		
		//if (trim(strtolower($MarketStatus)) == 'closed') return array('status'=>0,'msg'=>"Market has closed for today.");
		
		$today=date('Y-m-d');		
		
		if (!$order['orderdate']) $order['orderdate']=$this->GetOrderTime();		
		if (!$order['order_id']) $order['order_id']=$this->GetId('direct_orders','order_id');	
			
		$set=$this->GetTradingParamaters();
		$paystack=$this->GetPaystackSettings();
		$order['orderstatus']="Not Active";		
		
		//broker_id
		$order['broker_id']=trim($order['broker_id']);
		
		if (!$order['broker_id'])
		{
			$m="Broker Id field is empty. Please resend the order."; 
			return array('status'=>0,'msg'=>$m);
		}
		
		$broker_status=$this->IsValidateBroker($order['broker_id']);		
		if ($broker_status !== true) return array('status'=>0,'msg'=>$broker_status);
				
		//investor_id
		$order['investor_id']=trim($order['investor_id']);
		
		if (!$order['investor_id'])
		{
			$m="Investor Id field is empty. Please resend the order."; 
			return array('status'=>0,'msg'=>$m);
		}
		
		$inv_status=$this->IsValidateInvestor($order['investor_id']);		
		if ($inv_status !== true) return array('status'=>0,'msg'=>$inv_status);
		
		if ((!$order['broker_recipient_code']) or (trim($order['broker_recipient_code'])==''))
		{
			$m="Broker payment recipient code is not available. Registration process is not complete. You need to supply your account details before you can carry out any trade. Go to your profile and update your account details."; 
			return array('status'=>0,'msg'=>$m);
		}
		
		//Investor recipient code
		if ((!$order['investor_recipient_code']) or (trim($order['investor_recipient_code'])==''))
		{
			$m="Investor payment recipient code is not available. Investor registration process is not complete. You need to supply the investor account details before you can carry out any trade. Go to the investor profile and update the account details."; 
			return array('status'=>0,'msg'=>$m);
		}
		
		//transtype
		$order['transtype']=trim($order['transtype']);
		
		if (!$order['transtype'])
		{
			$m="Transaction type field is empty. Please resend the order."; 
			return array('status'=>0,'msg'=>$m);
		}
		
		if (trim(strtolower($order['transtype']))<>'sell') $order['transtype']='Sell';		
		
		//symbol
		$order['symbol']=strtoupper(trim($order['symbol']));
		
		if (!$order['symbol'])
		{
			$m="Transaction asset field is empty. Please resend the order.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (is_numeric($order['symbol']))
		{
			$m="Asset MUST NOT be a number. Please resend the order with a valid asset.";
			return array('status'=>0,'msg'=>$m);
		}
		
		$sym=$this->IsValidateSymbol($order['symbol']);	
		if ($sym !== true) return array('status'=>0,'msg'=>$sym);
		
		//Get Symbol Price
		$price=$this->GetSymbolPrice($order['symbol']);
		
		$price_limit_percent=0; $upperlimit=0; $lowerlimit=0; $close_time=''; $max_order_days=0;
		$min_buy_qty=0; $broker_commission=0; $nse_commission=0;
		
		//Check if amount is within accepted limited				
		if ($set->price_limit_percent) $price_limit_percent = $set->price_limit_percent;
		if ($set->market_close_time) $close_time = $set->market_close_time;
		if ($set->max_order_days) $max_order_days = $set->max_order_days;
		if ($set->min_buy_qty) $min_buy_qty = $set->min_buy_qty;
		
		//ordertype
		$order['ordertype']=strtoupper(trim($order['ordertype']));
		$order['price']=str_replace(",","",trim($order['price']));//price	
		
		if (!$order['ordertype']) $order['ordertype']="Market";		
			
		if ((trim($order['price'])=='') or (floatval($order['price']) == 0))
		{
			$m="Selling price field is empty. Please resend the order.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (!is_numeric($order['price']))//Not numeric
		{
			$m="Selling price must be a number. Please resend the order with a valid price.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (floatval($order['price'])==0)//Zero sent
		{
			$m="Selling price MUST NOT be zero. Please resend the order with a valid price.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (floatval($order['price'])<0)//Negative number sent
		{
			$m="Selling price MUST NOT be a negative number. Please resend the order with a valid price.";
			return array('status'=>0,'msg'=>$m);
		}
						
		$diff=(floatval($price_limit_percent)/100) * $price;			
		$lowerlimit = floatval($price) - floatval($diff);
		$upperlimit = floatval($price) + floatval($diff);
							
		if (floatval($order['price'])< floatval($lowerlimit))//Exceeded lower limit
		{
			$m="The selling price of ".number_format($order['price'],2,'.','')." is less than the minimum price, ".number_format($lowerlimit,2,'.','').", allowed for the asset. Please resend the order with a valid price.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (floatval($order['price']) > floatval($upperlimit))//Exceeded upper limit
		{
			$m="The selling price of ".number_format($order['price'],2,'.','')." is more than the maximum price, ".number_format($upperlimit,2,'.','').", allowed for the asset. Please resend the order with a valid price.";
			return array('status'=>0,'msg'=>$m);
		}			
		
		//qty
		$order['qty']=str_replace(",","",trim($order['qty']));
		
		if ((trim($order['qty'])=='') or (floatval($order['qty']) == 0))
		{
			$m="Transaction quantity field is empty. Please resend the order.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (!is_numeric($order['qty']))//Not numeric
		{
			$m="Transaction quantity must be a number. Please resend the order with a valid quantity.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (floatval($order['qty'])==0)//Zero sent
		{
			$m="Transaction quantity MUST NOT be zero. Please resend the order with a valid quantity.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (floatval($order['qty'])<0)//Negative number sent
		{
			$m="Transaction quantity MUST NOT be a negative number. Please resend the order with a valid quantity.";
			return array('status'=>0,'msg'=>$m);
		}
		
		$fees=$this->GetTradeFees($order['qty'],$order['price']);
			
		if (floatval($order['trade_amount']) < 0) $order['trade_amount']=$fees['TradeAmount'];
		if (floatval($order['broker_commission']) < 0) $order['broker_commission']=$fees['BrokerFee'];
		if (floatval($order['nse_commission']) < 0) $order['nse_commission']=$fees['NSEFee'];
		if (floatval($order['transfer_fee']) < 0) $order['transfer_fee']=$fees['TransferFee'];
		if (floatval($order['total_amount']) < 0) $order['total_amount']=$fees['TotalAmount'];
						
		$order['orderstatus']="Active";
		
		$m="Your order to sell ".number_format($order['qty'],0)." tokens of ".$order['symbol']." at ".number_format($order['price'],2,'.',',')." per token has been successful placed.";
		
		return array('status'=>1,'msg'=>$m,'ChangePriceQty'=>$min_buy_qty,'order'=>$order);
	}
	
	//Processes orders from TradingGateway and manages order books. It also sends updates to MarketData.
	function DirectMatchingEngine($trade)
	{
		$dt=date('Y-m-d H:i:s');
		
		$ret=array();				
		$transtype		= 'Buy'; 
		$symbol			= $trade['symbol'];
		$paystack 		= $this->GetPaystackSettings();
		$setings		= $this->GetTradingParamaters();
		
		$transfers=array();  $currency='NGN'; $min_buy_qty = 0;

		if ($setings->min_buy_qty) $min_buy_qty = $setings->min_buy_qty;
		
		$deductions=array(); $price_changes = array(); $trades_payments=array();

		/****** PAYMENTS *****/
		//SELLER
		$desc="Payment For Sales Of ".$trade['num_tokens']." Tokens Of ".$trade['symbol']." At ".round($trade['price'],2)." Per Token. Trade Id Is ".$trade['trade_id'];
		
		$transfers[]=array("amount" => ($trade['total_seller_fee'] * 100), "reason"=>$desc, "recipient"=>$trade['seller_recipient_code']);
						
		$trades_payments[] = array('trade_id'=>$trade['trade_id'],'symbol'=>$trade['symbol'],'num_tokens'=>$trade['num_tokens'],'price'=>round($trade['price'],2),'trade_amount'=>round($trade['trade_amount'],2),'recipient_amount'=>round($trade['total_seller_fee'],2),'recipient'=>'Seller','recipient_code'=>$trade['seller_recipient_code'],'description'=>$desc,'trade_date'=>$trade['tradedate'],'currency'=>$currency,'transfer_code'=>'');		
		
		//Seller Broker
		$desc="Commission For Sales Of ".$trade['num_tokens']." Tokens Of ".$trade['symbol']." At ".round($trade['price'],2)." Per Token. Trade Id Is ".$trade['trade_id'];
			
		$transfers[]=array("amount"=>($trade['sell_broker_fee'] * 100), "reason"=>$desc, "recipient"=>$trade['sell_broker_recipient_code']);
		
		$trades_payments[] = array('trade_id'=>$trade['trade_id'],'symbol'=>$trade['symbol'],'num_tokens'=>$trade['num_tokens'],'price'=>round($trade['price'],2),'trade_amount'=>round($trade['trade_amount'],2),'recipient_amount'=>round($trade['sell_broker_fee'],2),'recipient'=>'Seller Broker','recipient_code'=>$trade['sell_broker_recipient_code'],'description'=>$desc,'trade_date'=>$trade['tradedate'],'currency'=>$currency,'transfer_code'=>'');		
		
		//Buyer Broker
		$desc = "Commission For Buying Of ".$trade['num_tokens']." Tokens Of ".$trade['symbol']." At ".round($trade['price'],2)." Per Token. Trade Id Is ".$trade['trade_id'];
						
		$transfers[]=array("amount"=>($trade['buy_broker_fee'] * 100), "reason"=>$desc, "recipient"=>$trade['buy_broker_recipient_code']);
		
		$trades_payments[] = array('trade_id'=>$trade['trade_id'],'symbol'=>$trade['symbol'],'num_tokens'=>$trade['num_tokens'],'price'=>round($trade['price'],2),'trade_amount'=>round($trade['trade_amount'],2),'recipient_amount'=>round($trade['buy_broker_fee'],2),'recipient'=>'Buyer Broker','recipient_code'=>$trade['buy_broker_recipient_code'],'description'=>$desc,'trade_date'=>$trade['tradedate'],'currency'=>$currency,'transfer_code'=>'');
		
		//Deduction from buyer
		$deductions[]=array('trade_id'=>$trade['trade_id'],"amount"=>$trade['total_buyer_fee'], "reason"=>"Payment For Buying Of ".$trade['num_tokens']." Tokens Of ".$trade['symbol']." At ".round($trade['price'],2)." Per Token And Commissions. Trade Id Is ".$trade['trade_id'], "investor_id"=>$trade['buy_investor_email'],'buyer_broker_id'=>$trade['buy_broker_id']);		
		
		//NSE
		$desc="Commission For Trading Of ".$trade['num_tokens']." Tokens Of ".$trade['symbol']." At ".round($trade['price'],2)." Per Token. Trade Id Is ".$trade['trade_id'];
		
		$transfers[]=array("amount"=>($trade['nse_fee'] * 100), "reason"=>$desc, "recipient"=>$trade['nse_recipient_code']);
		
		$trades_payments[] = array('trade_id'=>$trade['trade_id'],'symbol'=>$trade['symbol'],'num_tokens'=>$trade['num_tokens'],'price'=>round($trade['price'],2),'trade_amount'=>round($trade['trade_amount'],2),'recipient_amount'=>round($trade['nse_fee'],2),'recipient'=>'NSE','recipient_code'=>$trade['nse_recipient_code'],'description'=>$desc,'trade_date'=>$trade['tradedate'],'currency'=>$currency,'transfer_code'=>'');
		

//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($trade,true)); fclose($file); return;
	
		//Make transfers		
		$recipients=array("currency"=>$currency, "source"=>"balance", "transfers"=>$transfers);				
				
		$recipients_string = http_build_query($recipients);		
			
		$transfer_result = $this->PaystackBulkTransferFunds($recipients_string);
		
		if ($transfer_result['Status']==1)
		{//$transfer_result = array('Status','data') - data='Recipient','Amount','TransferCode','Currency'
			//Log successful transfer
			$operation='Transfer Of Transaction Amounts';
					
			$activity='Transfer of funds to seller, buyer broker, seller broker and NSE was done successfully from trade with Id '.$trade['trade_id'].'. Details Of The Transfer Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Buyer Broker Id: '.$trade['buy_broker_id'].'; Seller Broker Id: '.$trade['sell_broker_id'].'; Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Trade Price: '.$trade['price'].'; Trade Amount: '.round((floatval($trade['num_tokens']) * floatval($trade['price'])),2).'; Seller Broker Fee: '.$trade['sell_broker_fee'].'; Buyer Broker Fee: '.$trade['buy_broker_fee'].'; NSE Commission: '.$trade['nse_fee'].'; Payment Status: '.$trade['payment_status'].'; Engine Type: Direct; Seller Fee: '.$trade['total_seller_fee'];
					
			$username='System';
			$fullname='Naija Art Mart Core';
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
			
			$r=$this->BalanceWalletAfterTrade($deductions); //Deduct from Wallet			
			
			if ($r==true)
			{
				$paydata=$transfer_result['data'];
			
				if (count($paydata) > 0)
				{
					foreach($paydata as $pd)
					{
						for($i=0; $i < count($trades_payments); $i++)
						{//'Recipient','Amount','TransferCode','Currency'							
							if (trim($pd['Recipient'] == trim($trades_payments[$i]['recipient_code'])) And (floatval($pd['Amount']/100) == floatval($trades_payments[$i]['recipient_amount'])))
							{
								$trades_payments[$i]['transfer_code']=$pd['TransferCode'];
							}
						}						
					}
				}		
		
				$save_trade_result=$this->SaveDirectTrade($trade); //Save trades
				
				//Update Prices And Order Values ****Change And Update Price
				if ((intval($trade['num_tokens']) >= intval($min_buy_qty)) And (intval($min_buy_qty) > 0))
				{
					$sql="SELECT * FROM price_changes WHERE (TRIM(trade_id)='".$this->db->escape_str($trade['trade_id'])."') AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."') AND (DATE_FORMAT(date_updated,'%Y-%m-%d')='".date('Y-m-d')."')";
					
					$query=$this->db->query($sql);
					
					if ($query->num_rows() == 0)
					{
						$this->db->trans_start();	
								
						$dat=array(
							'trade_id' 		=> $this->db->escape_str($trade['trade_id']),
							'symbol' 		=> $this->db->escape_str($trade['symbol']),
							'qty' 			=> $this->db->escape_str($trade['num_tokens']),
							'current_price'	=> $this->db->escape_str($trade['market_price']),
							'new_price' 	=> $this->db->escape_str($trade['price']),
							'date_updated'	=> $this->db->escape_str($dt)
						);
					
						$this->db->insert('price_changes', $dat);							
						$this->db->trans_complete();
					}					
					
					//Get High And Low Intraday Prices
					$high=0; $low=0; $volume=0; $change=0; $no_of_trades=0; $trade_value=0;
					$close_price=0; $prevclose=0; $changepercent=0;
					
					$sql="SELECT MAX(trade_price) AS High, MIN(trade_price) AS Low FROM trades WHERE (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."') AND (trade_price > 0) AND (DATE_FORMAT(tradedate,'%Y-%m-%d')='".date('Y-m-d')."')";
					
					$query=$this->db->query($sql);
					
					$old_close_price=0;
					
					if ($query->num_rows() > 0)
					{
						$row = $query->row();
						
						if ($row->High) $high =$row->High;
						if ($row->Low) 	$low =$row->Low;
						if ($row->close_price) 	$old_close_price =$row->close_price;
		
						$close_price = floatval($trade['price']);
						
						$trade_value = intval($trade['num_tokens']) * $close_price;
						
						$sql="SELECT * FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".date('Y-m-d')."') AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
						
						$query=$this->db->query($sql);
						
						if ($query->num_rows() > 0)
						{
							$row = $query->row();
							
							if ($row->previous_close_price) $prevclose =$row->previous_close_price;
							if ($row->trades) $no_of_trades = $row->trades + 1; else $no_of_trades=1;
							if ($row->volume) $volume = $row->volume + intval($trade['num_tokens']); else $volume=$trade['num_tokens'];
							if ($row->trade_value) $trade_value += $row->trade_value;
							
							$change = $close_price - $prevclose;
							$changepercent = round(($change/$prevclose) * 100,2);
							
							//Update daily_price
							$this->db->trans_start();	
								
							$dat=array(
								'close_price' 			=> $this->db->escape_str($close_price),
								'high_price' 			=> $this->db->escape_str($high),
								'low_price' 			=> $this->db->escape_str($low),
								'volume'				=> $this->db->escape_str($volume),
								'change' 				=> $this->db->escape_str($change),
								'trades'				=> $this->db->escape_str($no_of_trades),
								'trade_value'			=> $this->db->escape_str($trade_value),
								'previous_close_price'	=> $this->db->escape_str($prevclose),
								'change_percent'		=> $this->db->escape_str($changepercent)
							);
						
							$this->db->where(array('symbol'=>$trade['symbol'],'price_date'=>date('Y-m-d')));
							$this->db->update('daily_price', $dat);						
							$this->db->trans_complete();
							
							//Log Price change
							$operation='Updated Market Price For Asset';
					
							$activity='Updated market price for asset after successful trade. Details Of Price Update: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Minimum Quantity For Price Change: '.$min_buy_qty.'; Trade Price: '.$trade['price'].'; Old Market Price: '.$old_close_price.'; Market Price After Trade: '.$close_price;
									
							$username='System';
							$fullname='Naija Art Mart Core';
							$remote_ip=$_SERVER['REMOTE_ADDR'];
							$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
							
							$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
						}				
					}
				}else
				{
					//Get High And Low Intraday Prices
					$high=0; $low=0; $volume=0; $change=0; $no_of_trades=0; $trade_value=0;
					$close_price=0; $prevclose=0; $changepercent=0;
					
					$sql="SELECT MAX(trade_price) AS High, MIN(trade_price) AS Low FROM trades WHERE (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."') AND (trade_price > 0) AND (DATE_FORMAT(tradedate,'%Y-%m-%d')='".date('Y-m-d')."')";
					
					$query=$this->db->query($sql);
					
					$old_close_price=0;
					
					if ($query->num_rows() > 0)
					{
						$row = $query->row();
						
						if ($row->High) $high =$row->High;
						if ($row->Low) 	$low =$row->Low;
						if ($row->close_price) 	$old_close_price =$row->close_price;
		
						$close_price = floatval($trade['price']);
						
						$trade_value = intval($trade['num_tokens']) * $close_price;
						
						$sql="SELECT * FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".date('Y-m-d')."') AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
						
						$query=$this->db->query($sql);
						
						if ($query->num_rows() > 0)
						{
							$row = $query->row();
							
							if ($row->previous_close_price) $prevclose =$row->previous_close_price;
							if ($row->trades) $no_of_trades = $row->trades + 1; else $no_of_trades=1;
							if ($row->volume) $volume = $row->volume + intval($trade['num_tokens']); else $volume=$trade['num_tokens'];
							if ($row->trade_value) $trade_value += $row->trade_value;
							
							$change = $close_price - $prevclose;
							$changepercent = round(($change/$prevclose) * 100,2);
							
							//Update daily_price
							$this->db->trans_start();	
								
							$dat=array(
								'volume'				=> $this->db->escape_str($volume),
								'trades'				=> $this->db->escape_str($no_of_trades),
								'trade_value'			=> $this->db->escape_str($trade_value)
							);
						
							$this->db->where(array('symbol'=>$trade['symbol'],'price_date'=>date('Y-m-d')));
							$this->db->update('daily_price', $dat);						
							$this->db->trans_complete();
						}				
					}
				}
				
				//Update portfolios
	
				$sell_email=''; $buy_email='';	$sell_uid=''; $buy_uid=''; $title='';
				
				//Seller
				$inv_rw = $this->GetInvestorDetails($trade['sell_investor_email']);				
				if ($inv_rw->email) $sell_email = trim($inv_rw->email);
				if ($inv_rw->uid) $sell_uid = trim($inv_rw->uid);
				
				//Buyer
				$inv_rw = $this->GetInvestorDetails($trade['buy_investor_email']);				
				if ($inv_rw->email) $buy_email = trim($inv_rw->email);
				if ($inv_rw->uid) $buy_uid = trim($inv_rw->uid);
				
				$at = $this->GetArtTitle($trade['symbol']);
				$title = trim($at);
								
				//Buyer
				$sql="SELECT * FROM portfolios WHERE ((TRIM(email)='".$this->db->escape_str($buy_email)."') OR (TRIM(uid)='".$this->db->escape_str($buy_uid)."')) AND (TRIM(broker_id)='".$this->db->escape_str($trade['buy_broker_id'])."') AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
					
				$query=$this->db->query($sql);
				
				$buy_old_portfolio=0; $buy_new_portfolio=0; 
				
				if ($query->num_rows() > 0)
				{
					$rr = $query->row();
					
					if ($rr->tokens) $buy_old_portfolio =$rr->tokens;
					
					$tok = intval($rr->tokens) + intval($trade['num_tokens']);
					$buy_new_portfolio=$tok;
					
					$this->db->trans_start();	
					
					$dat=array(
						'tokens' 		=> $this->db->escape_str($tok),
						'currentprice' 	=> $this->db->escape_str($trade['market_price']),
						'price_bought' 	=> $this->db->escape_str($trade['price']),
						'date_updated'	=> $dt
					);			
	
					$this->db->where(array('email'=>$buy_email,'broker_id'=>$trade['buy_broker_id'],'symbol'=>$trade['symbol']));
					$this->db->update('portfolios',$dat);
												
					$this->db->trans_complete();
				}else
				{
					$buy_new_portfolio=$trade['num_tokens'];
					
					$this->db->trans_start();			
					
					$dat=array(
						'email' 		=> $this->db->escape_str($buy_email),
						'uid' 			=> $this->db->escape_str($buy_uid),
						'broker_id' 	=> $this->db->escape_str($trade['buy_broker_id']),
						'symbol'		=> $this->db->escape_str($trade['symbol']),
						'art_title' 	=> $this->db->escape_str($title),
						'tokens' 		=> $this->db->escape_str($trade['num_tokens']),
						'price_bought' 	=> $this->db->escape_str($trade['price']),
						'currentprice' 	=> $this->db->escape_str($trade['market_price']),
						'date_created'	=> $dt
					);
					
					$this->db->insert('portfolios', $dat);	
						
					$this->db->trans_complete();
				}
				
		
				//Seller
				$sql="SELECT * FROM portfolios WHERE ((TRIM(email)='".$this->db->escape_str($sell_email)."') OR (TRIM(uid)='".$this->db->escape_str($sell_uid)."')) AND (TRIM(broker_id)='".$this->db->escape_str($trade['sell_broker_id'])."') AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
				
				$query=$this->db->query($sql);
				
				$sell_old_portfolio=0; $sell_new_portfolio=0;
				
				if ($query->num_rows() > 0)
				{
					$rr = $query->row();
					if ($rr->tokens) $sell_old_portfolio =$rr->tokens;
					
					$tok = intval($rr->tokens) - intval($trade['num_tokens']);	
					$sell_new_portfolio=$tok;
					
					$this->db->trans_start();	
					
					$dat=array(
						'tokens' 		=> $this->db->escape_str($tok),
						'currentprice' 	=> $this->db->escape_str($trade['market_price']),
						'price_bought' 	=> $this->db->escape_str($trade['price']),
						'date_updated'	=> $dt
					);		
	
					$this->db->where(array('email'=>$sell_email,'broker_id'=>$trade['sell_broker_id'],'symbol'=>$trade['symbol']));
					$this->db->update('portfolios',$dat);
												
					$this->db->trans_complete();
				}else
				{		
					$sell_new_portfolio=$trade['num_tokens'];
					
					$this->db->trans_start();			
					
					$dat=array(
						'email' 		=> $this->db->escape_str($sell_email),
						'uid' 			=> $this->db->escape_str($sell_uid),
						'broker_id' 	=> $this->db->escape_str($trade['sell_broker_id']),
						'symbol'		=> $this->db->escape_str($trade['symbol']),
						'art_title' 	=> $this->db->escape_str($title),
						'tokens' 		=> $this->db->escape_str($trade['num_tokens']),
						'price_bought' 	=> $this->db->escape_str($trade['price']),
						'currentprice' 	=> $this->db->escape_str($trade['market_price']),
						'date_created'	=> $dt
					);
					
					$this->db->insert('portfolios', $dat);	
						
					$this->db->trans_complete();
				}
				
				//Log Portfolio Update
				$operation='Updated Investors Portfolios';
		
				$activity='Updated investors portfolios after trade successfully. Details Of Portfolio Update: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Asset: '.$trade['symbol'].'; Buyer Old Portfolio Quantity: '.$buy_old_portfolio.'; Buyer New Portfolio Quantity: '.$buy_new_portfolio.'; Seller Old Portfolio Quantity: '.$sell_old_portfolio.'; Seller New Portfolio Quantity: '.$sell_new_portfolio;
						
				$username='System';
				$fullname='Naija Art Mart Core';
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
				$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
				
				
				//********************UPDATE Sell Orders - Seller
				 $sell_order_qty_before=0; $sell_order_qty_after=0;
				 $sell_order_status_before=''; $sell_order_status_after='';
				 $sta=''; $newprice=''; $newsta=''; $oldprice='';
				  
				$sql="SELECT * FROM direct_orders WHERE (TRIM(order_id)='".$this->db->escape_str($trade['sell_order_id'])."')";
					
				$query=$this->db->query($sql);
				
				if ($query->num_rows() > 0)
				{
					$rr = $query->row();
					
					if ($rr->available_qty) $sell_order_qty_before =$rr->available_qty;
					if ($rr->orderstatus) $sell_order_status_before =trim($rr->orderstatus);
					if ($rr->price) $oldprice =$rr->price;
					
					$tamt = floatval($trade['num_tokens']) * floatval($trade['price']); //Trade amount						
					$availQty= intval($rr->available_qty) - intval($trade['num_tokens']);
										
					if (intval($availQty) > 0)
					{
						if (trim(strtolower($trade['sell_ordertype'])) == 'limit')
						{
							$newprice=$trade['price'];
						}elseif (trim(strtolower($trade['sell_ordertype'])) == 'market')
						{
							$newprice=$trade['market_price'];
						}
					}
					
					$this->db->trans_start();
					
					$dat=array();
					
					if (intval($availQty)==0)
					{
						$sell_order_status_after='Executed';
						
						$dat=array(
							'available_qty' 	=> $this->db->escape_str($availQty),
							'orderstatus'		=> $sell_order_status_after,
							'last_update_date'	=> $dt
						);
					}elseif (intval($availQty) > 0)
					{
						$TFee=0; $br_rate=0; $n_rate=0; $sms_rate = 0;
						
						//Recompute fees/commissions					
						if ($paystack->transfer_fee) $TFee = $paystack->transfer_fee;
						if ($paystack->brokers_commission) $br_rate = $paystack->brokers_commission;
						if ($paystack->nse_commission) $n_rate = $paystack->nse_commission;
						
						if ($setings->sms_fee) $sms_rate = $setings->sms_fee;
						
						$new_tradeamount = floatval($availQty) * floatval($newprice);
						
						$new_brokerfee = (floatval($br_rate)/100) * $new_tradeamount;
						$new_nsefee = (floatval($n_rate)/100) * $new_tradeamount;
						$new_totalamount = floatval($new_tradeamount) + floatval($new_brokerfee) + floatval(($new_nsefee/2)) + floatval(($sms_rate * 2)) + floatval($TFee);
											
									
						$new_seller_fee=$new_tradeamount - floatval($new_brokerfee) - floatval(($new_nsefee/2)) - floatval($TFee) - floatval(($sms_rate * 2));		
						
						$sell_order_status_after= 'Active';		
						
						$dat=array(
							'available_qty' 	=> $this->db->escape_str($availQty),
							'orderstatus'		=> $sell_order_status_after,
							'price'				=> $this->db->escape_str($newprice),							
							'broker_commission'	=> $this->db->escape_str($new_brokerfee),
							'nse_commission'	=> $this->db->escape_str($new_nsefee),
							'total_amount'		=> $this->db->escape_str($new_totalamount),							
							'last_update_date'	=> $dt
						);
					}											
				
					$this->db->where('order_id',$trade['sell_order_id']);
					$this->db->update('direct_orders', $dat);						
					$this->db->trans_complete();
					
					$sell_order_qty_after = $availQty;
					$sell_order_status_after = trim($rr->orderstatus);
					
					//Log Sell Order Update
					$operation='Updated Sell Order After Trade';
			
					$activity='Updated sell order after trade successfully. Details Of Sell Order Update: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Asset: '.$trade['symbol'].'; Sell Order Id: '.$trade['sell_order_id'].'; Order Quantity Before Trade: '.$sell_order_qty_before.'; Order Quantity After Trade: '.$sell_order_qty_after.'; Order Price Before Trade: '.$oldprice.'; Order Price After Trade: '.$newprice.'; Order Status Before Trade: '.$sell_order_status_before.'; Order Status After Trade: '.$sell_order_status_after;
							
					$username='System';
					$fullname='Naija Art Mart Core';
					$remote_ip=$_SERVER['REMOTE_ADDR'];
					$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
					$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
				}
				
				//$trades_payments= array('trade_id','symbol','num_tokens','price','trade_amount','recipient_amount','recipient','recipient_code','description','trade_date','currency','transfer_code');
				
				if (count($trades_payments) > 0)
				{
					foreach($trades_payments as $pay)
					{
						$sql="SELECT * FROM trades_payments WHERE (TRIM(trade_id)='".$this->db->escape_str($pay['trade_id'])."') AND (TRIM(recipient)='".$this->db->escape_str($pay['recipient'])."') AND (TRIM(recipient_amount)=".$this->db->escape_str($pay['recipient_amount']).") AND (TRIM(recipient_code)='".$this->db->escape_str($pay['recipient_code'])."')";
					
						$query=$this->db->query($sql);
						
						if ($query->num_rows() == 0)
						{
							$this->db->trans_start();	
								
							$dat=array(
								'trade_id' 			=> $this->db->escape_str($pay['trade_id']),
								'symbol' 			=> $this->db->escape_str($pay['symbol']),
								'num_tokens' 		=> $this->db->escape_str($pay['num_tokens']),
								'currency' 			=> $this->db->escape_str($pay['currency']),
								'price' 			=> $this->db->escape_str($pay['price']),
								'trade_amount' 		=> $this->db->escape_str($pay['trade_amount']),
								'recipient_amount'	=> $this->db->escape_str($pay['recipient_amount']),
								'recipient' 		=> $this->db->escape_str($pay['recipient']),
								'recipient_code' 	=> $this->db->escape_str($pay['recipient_code']),
								'description'		=> $this->db->escape_str($pay['description']),
								'transfer_code'		=> $this->db->escape_str($pay['transfer_code']),
								'transfer_date'		=> $this->db->escape_str($pay['trade_date']),
								'trade_date'		=> $this->db->escape_str($pay['trade_date'])
							);
				
							$this->db->insert('trades_payments', $dat);	
								
							$this->db->trans_complete();
						}
					}
				}
			
				$sms=0;
				
				if ($setings->sms_fee) $sms = $setings->sms_fee;
				
				$transact_partners = array("symbol"=>$symbol,"broker_id"=>$trade['buy_broker_id'],"investor_id"=>$trade['buy_investor_email'],"qty" => $trade['num_tokens'],"price" => $trade['price'], 'sms_fee'=>($sms * 2),'transtype'=>$transtype);
		
				$ret = array('Status'=>1,"msg"=>"Trade Was Successful. ".$trade['num_tokens']." Tokens Of ".$symbol." Was Sold At ".round($trade['price'],2).".","trade_id"=>$trade['trade_id'],'transact_partners'=>$transact_partners);	
			}else
			{
				$ret = array('Status'=>'FAIL','msg'=>'Trade Execution Failed. Funds Deduction From Buyer Broker Wallet Was Not Successful.');
			}
		}else
		{
			$ret = array('Status'=>'FAIL','msg'=>'Trade Execution Failed. Funds Transfer Was Not Successful. ERROR: '.strtoupper($transfer_result['Message']));
		}
				
		return $ret;
	}
	
	function SaveDirectTrade($trade)
	{
		$ret=false;
			
		if (is_array($trade))
		{
			$this->db->trans_start();	

			$dat=array(
				'sell_broker_id' 		=> $this->db->escape_str($trade['sell_broker_id']),
				'sell_order_id' 		=> $this->db->escape_str($trade['sell_order_id']),
				'buy_broker_id' 		=> $this->db->escape_str($trade['buy_broker_id']),
				'buy_order_id' 			=> $this->db->escape_str($trade['buy_order_id']),				
				'buy_investor_email' 	=> $this->db->escape_str($trade['buy_investor_email']),
				'sell_investor_email'	=> $this->db->escape_str($trade['sell_investor_email']),				
				'trade_id' 				=> $this->db->escape_str($trade['trade_id']),
				'symbol'				=> $this->db->escape_str($trade['symbol']),
				'num_tokens' 			=> $this->db->escape_str($trade['num_tokens']),
				'ask_price' 			=> $this->db->escape_str($trade['ask_price']),
				'bid_price'				=> $this->db->escape_str($trade['bid_price']),
				'trade_price' 			=> $this->db->escape_str($trade['price']),
				'market_price' 			=> $this->db->escape_str($trade['market_price']),
				'sell_broker_fee'		=> $this->db->escape_str($trade['sell_broker_fee']),
				'buy_broker_fee' 		=> $this->db->escape_str($trade['buy_broker_fee']),
				'nse_fee' 				=> $this->db->escape_str($trade['nse_fee']),
				'transfer_fees' 		=> $this->db->escape_str($trade['transfer_fees']),					
				'total_buyer_fee' 		=> $this->db->escape_str($trade['total_buyer_fee']),
				'total_seller_fee' 		=> $this->db->escape_str($trade['total_seller_fee']),
				'engine_type' 			=> 'Direct',					
				'tradestatus' 			=> $this->db->escape_str($trade['tradestatus']),			
				'payment_status' 		=> $this->db->escape_str($trade['payment_status']),
				'tradedate'				=> $this->db->escape_str($trade['tradedate'])
			);
			
			$this->db->insert('trades', $dat);	
				
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE)
			{
				$operation='Saving Trade Record With Trade Id '.$trade['trade_id'].' Failed';
				
				$activity='Attempted Saving A Trade With Id '.$trade['trade_id'].' But Failed. Details Of The Trade Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Buyer Broker Id: '.$trade['buy_broker_id'].'; Seller Broker Id: '.$trade['sell_broker_id'].'; Sell Order Id: '.$trade['sell_order_id'].'; Buy Order Id: '.$trade['buy_order_id'].' Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Ask Price: '.$trade['ask_price'].'; Bid Price: '.$trade['bid_price'].'; Trade Price: '.$trade['price'].'; Market Price: '.$trade['market_price'].'; Trade Amount: '.round((floatval($trade['num_tokens']) * floatval($trade['price'])),2).'; Seller Broker Fee: '.$trade['sell_broker_fee'].'; Buyer Broker Fee: '.$trade['buy_broker_fee'].'; NSE Commission: '.$trade['nse_fee'].'; Transfer Fees: '.$trade['transfer_fees'].'; Trade Status: '.$trade['tradestatus'].'; Payment Status: '.$trade['payment_status'].'; Engine Type: Direct; Total Buyer Fee: '.$trade['total_buyer_fee'].'; Total Seller Fee: '.$trade['total_seller_fee'];
			}else
			{		
				//Log activity
				$operation='Saved Trade Record';
				
				$activity='A Trade Was Created With Id '.$trade['trade_id'].'. Details Of The Trade Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Buyer Broker Id: '.$trade['buy_broker_id'].'; Seller Broker Id: '.$trade['sell_broker_id'].'; Sell Order Id: '.$trade['sell_order_id'].'; Buy Order Id: '.$trade['buy_order_id'].' Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Ask Price: '.$trade['ask_price'].'; Bid Price: '.$trade['bid_price'].'; Trade Price: '.$trade['price'].'; Market Price: '.$trade['market_price'].'; Trade Amount: '.round((floatval($trade['num_tokens']) * floatval($trade['price'])),2).'; Seller Broker Fee: '.$trade['sell_broker_fee'].'; Buyer Broker Fee: '.$trade['buy_broker_fee'].'; NSE Commission: '.$trade['nse_fee'].'; Transfer Fees: '.$trade['transfer_fees'].'; Trade Status: '.$trade['tradestatus'].'; Payment Status: '.$trade['payment_status'].'; Engine Type:  Direct; Total Buyer Fee: '.$trade['total_buyer_fee'].'; Total Seller Fee: '.$trade['total_seller_fee'];
									
				$ret=true;
			}
		}		
		
		//Log activity
		$username='System';
		$fullname='Naija Art Mart Core';
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
		$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
		
		return $ret;
	}	
	
	function GetSymbolPrimaryMarketPrice($symbol)
	{
		$sql="SELECT price FROM primary_market WHERE (TRIM(symbol)='".$this->db->escape_str($symbol)."') AND (DATE_FORMAT(holding_period_ends,'%Y-%m-%d') > DATE_FORMAT(NOW(),'%Y-%m-%d'))";
		
		$query = $this->db->query($sql);
		
		$price=0;		
	
		if ($query->num_rows() > 0)  //Build Array of results
		{
			$row = $query->row();
			
			if ($row->price) $price=trim($row->price);
		}
	
		return $price;
	}
	
	function GetCurrentSymbolPrice($symbol)
	{
		$sql="SELECT close_price FROM daily_price WHERE (TRIM(symbol)='".$this->db->escape_str($symbol)."')";
		
		$query = $this->db->query($sql);
		
		$price=0;		
	
		if ($query->num_rows() > 0)  //Build Array of results
		{
			$row = $query->row();
			
			if ($row->close_price) $price=trim($row->close_price);
		}
	
		return $price;
	}
	
	function GetOrderDetails($orderid)
	{
		$sql="SELECT * FROM orders WHERE (TRIM(order_id)='".$this->db->escape_str($orderid)."')";		
			   		
		$query = $this->db->query($sql);
		
		$row = $query->row();
	
		return $row;
	}	
	
	function DisplayOrderBook($symbol)
	{
		$sell_orders=array(); $buy_orders=array(); $buy=array(); $sell=array();
		
		$sell_sql="SELECT CONCAT(DATE_FORMAT(orderdate,'%d %b %Y'),' ',MID(orderdate,11)) AS orderdate,order_id,broker_id,available_qty,price FROM orders WHERE (TRIM(transtype)='Sell') AND (TRIM(orderstatus)='Active') AND (TRIM(symbol)='".$this->db->escape_str($symbol)."') AND (price > 0) ORDER BY symbol,price,orderdate";		
			   
		$buy_sql="SELECT CONCAT(DATE_FORMAT(orderdate,'%d %b %Y'),' ',MID(orderdate,11)) AS orderdate,order_id,broker_id,available_qty,price FROM orders WHERE (TRIM(transtype)='Buy') AND (TRIM(orderstatus)='Active') AND (TRIM(symbol)='".$this->db->escape_str($symbol)."') AND (price > 0) ORDER BY symbol,price DESC,orderdate";
		
		//Get sell orders records
		$query=$this->db->query($sell_sql);		
		if ($query->num_rows() > 0) $sell_orders = $query->result_array();
		
		//Get buy orders records
		$query=$this->db->query($buy_sql);
		if ($query->num_rows() > 0) $buy_orders = $query->result_array();

		if (count($sell_orders) > 0)
		{
			foreach($sell_orders as $row):
				if ($row['available_qty'] and $row['order_id'] and $row['broker_id'])
				{
					$sell[] = array('orderdate'=>$row['orderdate'], "order_id"=>$row['order_id'], 'broker_id'=>$row['broker_id'], "Qty"=>$row['available_qty'], 'price'=>$row['price']);
				}
			endforeach;	
		}
		
		if (count($buy_orders) > 0)
		{
			foreach($buy_orders as $row):
				if ($row['available_qty'] and $row['order_id'] and $row['broker_id'])
				{
					$buy[] = array('orderdate'=>$row['orderdate'], "order_id"=>$row['order_id'], 'broker_id'=>$row['broker_id'], "Qty"=>$row['available_qty'], 'price'=>$row['price']);
				}
			endforeach;	
		}
		
		return array('Sell'=>$sell,'Buy'=>$buy);
	}
	
	function  SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$display_status,$sender,$expiredate = NULL)
	{
		$ex=explode(",",$msgtype);
		
		for($i=0; $i<count($ex); $i++)
		{
			if (strtolower(trim($ex[$i])) == 'email')
			{
				////Subject and Sender in Trade email message
				$subject='Naija Art Mart Trading Report';
				$from='admin@naijaartmart.com';
				$Cc='';
				$altmessage=strip_tags($details);
				
				$this->SendEmail($from,$emails,$subject,$Cc,$details,$altmessage,'Trader');
			}
			
			if (strtolower(trim($ex[$i])) == 'sms')
			{
				$this->SendBulkSMS($phones,$details);
			}
			
			if (strtolower(trim($ex[$i])) == 'system')
			{
				$ret = $this->SendMsg($emails, $groups, $header, $details, $category, $sender, $expiredate, $display_status);
			}	
		}		
		
		
		return true;
	}
	
	function SendMsg($emails, $groups, $header, $details, $category, $sender, $expiredate=NULL, $display_status='0')
	{
		$msgdate=date('Y-m-d H:i:s');		
		$msgid=$this->GetId('messages','msgid');
		
		if ($expiredate === NULL) $expiredate=date('Y-m-d H:i:s',strtotime($msgdate.' +7 days'));
		
		$rec='';
		
		if (trim($groups) <> '') $rec=$groups;
		
		if (trim($emails) <> '')
		{
			if (trim($rec) == '') $rec=$emails; else $rec=$emails;
		}
								
		$this->db->trans_start();
				
		$dat=array(
			'msgid' 			=> $this->db->escape_str($msgid),
			'header' 			=> $this->db->escape_str($header),
			'details' 			=> $this->db->escape_str($details),
			'msgdate' 			=> $this->db->escape_str($msgdate),
			'category' 			=> $this->db->escape_str($category),
			'expiredate'		=> $this->db->escape_str($expiredate),
			'recipients' 		=> $this->db->escape_str($rec),
			'sender' 			=> $this->db->escape_str($sender),
			'display_status' 	=> $this->db->escape_str($display_status)				
			);
		
		$this->db->insert('messages', $dat);
		
		$this->db->trans_complete();
		
		$Msg='';	
		
		if ($this->db->trans_status() === FALSE)
		{					
			$Msg="System attempted sending message to message queue but failed.";		
			
			return false;		
		}else
		{					
			$Msg="Message Was Queued Successfully.";
			
			$m="QUEUED MESSAGE FOR SENDING";
			
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			$this->LogDetails('System',$Msg,'System',date('Y-m-d H:i:s'),$remote_ip,$remote_host,$m,$_SESSION['LogID']);	
		}
				
		return true;
	}
	
	function GetNSERecipientCode($usertype)
	{
		$rc='';
		
		if (strtolower(trim($usertype)) == 'admin')
		{
			$sql="SELECT recipient_code FROM settings";
			
			$query = $this->db->query($sql);		
			
			if ($query->num_rows() > 0 )
			{
				$row = $query->row();
				
				if ($row->recipient_code) $rc=trim($row->recipient_code);
			}	
		}
	
		return $rc;
	}
	
	function GetRecipientCode($email,$usertype)
	{
		$rc='';
		
		if (strtolower(trim($usertype)) == 'broker')
		{
			$sql="SELECT recipient_code FROM brokers WHERE (TRIM(email)='".$this->db->escape_str($email)."') OR (TRIM(broker_id)='".$this->db->escape_str($email)."')";
		}elseif (strtolower($usertype) == 'investor') //or (strtolower($usertype) == 'investor/issuer'))
		{
			if (is_numeric($email))
			{
				$sql="SELECT recipient_code FROM investors WHERE (TRIM(uid)=".$this->db->escape_str($email).")";	
			}else
			{
				$sql="SELECT recipient_code FROM investors WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
			}
		}elseif (strtolower($usertype) == 'issuer')
		{
			if (is_numeric($email))
			{
				$sql="SELECT recipient_code FROM issuers WHERE (TRIM(uid)=".$this->db->escape_str($email).")";	
			}else
			{
				$sql="SELECT recipient_code FROM issuers WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
			}
		}
			
		$query = $this->db->query($sql);		
		
		if ($query->num_rows() > 0 )
		{
			$row = $query->row();
			
			if ($row->recipient_code) $rc=trim($row->recipient_code);
		}
	
		return $rc;
	}
	
	function GetQueuedMessages($email,$admin)
	{
		if ($admin == 1)
		{
			$sql = "SELECT * FROM messages ORDER BY msgdate DESC, category,header";
		}else
		{
			$sql = "SELECT * FROM messages WHERE (TRIM(sender)='".trim($this->db->escape_str($email))."') ORDER BY msgdate DESC, category,header";
		}		

		$query = $this->db->query($sql);
						
		return $query->result();
	}
	
	function GetUserMessages($email,$usertype)
	{
		$sql = "SELECT * FROM messages WHERE ((LOCATE('".trim($this->db->escape_str($usertype))."',recipients) > 0) OR (TRIM(recipients)='ALL') OR (LOCATE('".trim($this->db->escape_str($email))."',recipients) > 0)) AND (display_status=1) ORDER BY msgdate DESC, header";

		$query = $this->db->query($sql);
			
		return $query->result();
	}
		
	function ValidateOrder($order)
	{
		$m='';
		$ret = $this->GetMarketStatus();
		$MarketStatus = $ret['MarketStatus'];
		
		//UNCOMMENT THIS LATER
		//if (trim(strtolower($MarketStatus)) == 'closed') return array('status'=>0,'msg'=>"Market has closed for today.");
		
		$today=date('Y-m-d');		
		
		if (!$order['orderdate']) $order['orderdate']=$this->GetOrderTime();		
		if (!$order['order_id']) $order['order_id']=$this->GetId('orders','order_id');	
			
		$set=$this->GetTradingParamaters();
		$paystack=$this->GetPaystackSettings();
		$order['orderstatus']="Not Active";		
		
		//broker_id
		$order['broker_id']=trim($order['broker_id']);
		
		if (!$order['broker_id'])
		{
			$m="Broker Id field is empty. Please resend the order."; 
			return array('status'=>0,'msg'=>$m);
		}
		
		$broker_status=$this->IsValidateBroker($order['broker_id']);		
		if ($broker_status !== true) return array('status'=>0,'msg'=>$broker_status);
		
		//Get broker details
		$broker_detail=$this->GetBrokerDetails($order['broker_id']);
		
		if ($broker_detail->recipient_code) $order['broker_recipient_code'] = $broker_detail->recipient_code;
		
		//investor_id
		$order['investor_id']=trim($order['investor_id']);
		
		if (!$order['investor_id'])
		{
			$m="Investor Id field is empty. Please resend the order."; 
			return array('status'=>0,'msg'=>$m);
		}
		
		$inv_status=$this->IsValidateInvestor($order['investor_id']);		
		if ($inv_status !== true) return array('status'=>0,'msg'=>$inv_status);
		
		//Get Investor details
		$investor_details=$this->GetInvestorDetails($order['investor_id']);
		
		if ($investor_details->recipient_code) $order['investor_recipient_code'] = $investor_details->recipient_code;
		
		if ((!$order['broker_recipient_code']) or (trim($order['broker_recipient_code'])==''))
		{
			$m="Broker payment recipient code is not available. Registration process is not complete. You need to supply your account details before you can carry out any trade. Go to your profile and update your account details."; 
			return array('status'=>0,'msg'=>$m);
		}
		
		//Investor recipient code
		if ((!$order['investor_recipient_code']) or (trim($order['investor_recipient_code'])==''))
		{
			$m="Investor payment recipient code is not available. Investor registration process is not complete. You need to supply the investor account details before you can carry out any trade. Go to the investor profile and update the account details."; 
			return array('status'=>0,'msg'=>$m);
		}
		
		//transtype
		$order['transtype']=trim($order['transtype']);
		
		if (!$order['transtype'])
		{
			$m="Transaction type field is empty. Please resend the order."; 
			return array('status'=>0,'msg'=>$m);
		}
		
		if ((trim(strtolower($order['transtype']))<>'buy') and (trim(strtolower($order['transtype']))<>'sell'))
		{
			$m="Transaction type can either be BUY or SELL. An unknown type, '".strtoupper($order['transtype'])."', was posted with the order.";
			return array('status'=>0,'msg'=>$m);
		}		
		
		//symbol
		$order['symbol']=strtoupper(trim($order['symbol']));
		
		if (!$order['symbol'])
		{
			$m="Transaction asset field is empty. Please resend the order.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (is_numeric($order['symbol']))
		{
			$m="Asset MUST NOT be a number. Please resend the order with a valid asset.";
			return array('status'=>0,'msg'=>$m);
		}
		
		$sym=$this->IsValidateSymbol($order['symbol']);	
		if ($sym !== true) return array('status'=>0,'msg'=>$sym);
		
		//Get Symbol Price
		$price=$this->GetSymbolPrice($order['symbol']);
		
		$price_limit_percent=0; $upperlimit=0; $lowerlimit=0; $close_time=''; $max_order_days=0;
		$min_buy_qty=0; $broker_commission=0; $nse_commission=0;
		
		//Check if amount is within accepted limited				
		if ($set->price_limit_percent) $price_limit_percent = $set->price_limit_percent;
		if ($set->market_close_time) $close_time = $set->market_close_time;
		if ($set->max_order_days) $max_order_days = $set->max_order_days;
		if ($set->min_buy_qty) $min_buy_qty = $set->min_buy_qty;
		
		//ordertype
		$order['ordertype']=strtoupper(trim($order['ordertype']));
		$order['price']=str_replace(",","",trim($order['price']));//price	
		
		if (!$order['ordertype'])
		{
			$order['ordertype']="MO";
			$order['expirydate']=$today." ".$close_time;
			$order['limit_market']='Market';
		}else
		{
			if ((trim(strtolower($order['ordertype']))=='market order') or (trim(strtolower($order['ordertype']))=='mo'))
			{
				$order['ordertype']='MO';
				$order['expirydate']=$today." ".$close_time;
				$order['limit_market']='Market';
			}
			
			if ((trim(strtolower($order['ordertype']))=='good till date') or (trim(strtolower($order['ordertype']))=='gtd'))
			{
				$order['ordertype']='GTD';
				$order['expirydate']=$today." ".$close_time;
			}
			
			if ((trim(strtolower($order['ordertype']))=='good till cancel') or (trim(strtolower($order['ordertype']))=='gtc'))
			{$today=date('Y-m-d');
	$exp=
	
				$order['ordertype']='GTC';
				$order['expirydate']=date('Y-m-d',strtotime($today.$max_order_days.' weekdays'))." ".$close_time;
				
			}
			
			if ((trim(strtolower($order['ordertype']))=='good till month-end') or (trim(strtolower($order['ordertype']))=='gtm'))
			{
				$order['ordertype']='GTM';
				
				if (!$order['expirydate'])
				{
					$m="You must select the month this order is ending for this type of order (GOOD TILL MONTHEND). Date format is MONTH YEAR (Eg. Jan 2020).";
				
					return array('status'=>0,'msg'=>$m);
				}
				
				$order['expirydate']=$this->GetMonthEnd($order['expirydate'])." ".$close_time;
			}
			
			if ((trim(strtolower($order['ordertype']))=='all or none') or (trim(strtolower($order['ordertype']))=='aon'))
			{
				$order['ordertype']='AON';
				$order['expirydate']=$today." ".$close_time;
					
				if ((trim($order['price'])=='') or (floatval($order['price']) == 0))
				{
					$m="Transaction price field is empty. Please resend the order.";
					return array('status'=>0,'msg'=>$m);
				}
				
				if (!is_numeric($order['price']))//Not numeric
				{
					$m="Transaction price must be a number. Please resend the order with a valid price.";
					return array('status'=>0,'msg'=>$m);
				}
				
				if (floatval($order['price'])==0)//Zero sent
				{
					$m="Transaction price MUST NOT be zero. Please resend the order with a valid price.";
					return array('status'=>0,'msg'=>$m);
				}
				
				if (floatval($order['price'])<0)//Negative number sent
				{
					$m="Transaction price MUST NOT be a negative number. Please resend the order with a valid price.";
					return array('status'=>0,'msg'=>$m);
				}
			}elseif ((trim(strtolower($order['ordertype']))=='gtd') or (trim(strtolower($order['ordertype']))=='gtc') or (trim(strtolower($order['ordertype']))=='gtm'))
			{
				if (floatval($order['price']) > 0)
				{
					if (!is_numeric($order['price']))//Not numeric
					{
						$m="Transaction price must be a number. Please resend the order with a valid price.";
						return array('status'=>0,'msg'=>$m);
					}
					
					if (floatval($order['price'])==0)//Zero sent
					{
						$m="Transaction price MUST NOT be zero. Please resend the order with a valid price.";
						return array('status'=>0,'msg'=>$m);
					}
					
					if (floatval($order['price'])<0)//Negative number sent
					{
						$m="Transaction price MUST NOT be a negative number. Please resend the order with a valid price.";
						return array('status'=>0,'msg'=>$m);
					}	
					
					$order['limit_market']='Limit';
				}else
				{
					$order['limit_market']='Market';	
				}
			}			
		}
				
		$diff=(floatval($price_limit_percent)/100) * $price;			
		$lowerlimit = floatval($price) - floatval($diff);
		$upperlimit = floatval($price) + floatval($diff);
				
		if (floatval($order['price']) > 0)
		{			
			if (floatval($order['price'])< floatval($lowerlimit))//Exceeded lower limit
			{
				$m="The transaction price, ".number_format($order['price'],2,'.','').", is less than the minimum price, ".number_format($lowerlimit,2,'.','').", allowed for the asset. Please resend the order with a valid price.";
				return array('status'=>0,'msg'=>$m);
			}
			
			if (floatval($order['price']) > floatval($upperlimit))//Exceeded upper limit
			{
				$m="The transaction price, ".number_format($order['price'],2,'.','').", is more than the maximum price, ".number_format($upperlimit,2,'.','').", allowed for the asset. Please resend the order with a valid price.";
				return array('status'=>0,'msg'=>$m);
			}		
		}				
		
		//qty
		$order['qty']=str_replace(",","",trim($order['qty']));
		
		if ((trim($order['qty'])=='') or (floatval($order['qty']) == 0))
		{
			$m="Transaction quantity field is empty. Please resend the order.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (!is_numeric($order['qty']))//Not numeric
		{
			$m="Transaction quantity must be a number. Please resend the order with a valid quantity.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (floatval($order['qty'])==0)//Zero sent
		{
			$m="Transaction quantity MUST NOT be zero. Please resend the order with a valid quantity.";
			return array('status'=>0,'msg'=>$m);
		}
		
		if (floatval($order['qty'])<0)//Negative number sent
		{
			$m="Transaction quantity MUST NOT be a negative number. Please resend the order with a valid quantity.";
			return array('status'=>0,'msg'=>$m);
		}
		
		$fees=$this->GetTradeFees($order['qty'],$upperlimit);
			
		$order['trade_amount']=$fees['TradeAmount'];
		$order['broker_commission']=$fees['BrokerFee'];
		$order['nse_commission']=$fees['NSEFee'];
		$order['transfer_fee']=$fees['TransferFee'];
		$order['total_amount']=$fees['TotalAmount'];
		
		if (trim(strtolower($order['transtype'])) == 'buy')
		{			
			//Check if broker has enough in the wallet
			$bal=$this->GetWalletBalance($broker_detail->email);			
			
			if (floatval($bal) < floatval($order['total_amount']))
			{
				$m="You do not have sufficient balance in your wallet to execute this trade. Estimated total trade amount including commissions is ".number_format($order['total_amount'],2,'.','').". Fund your wallet to be able to execute this trade.";
				
				return array('status'=>0,'msg'=>$m);
			}	
		}
				
		$order['orderstatus']="Active";
		
		if (floatval($order['price'])==0)
		{
			$m="Your order for ".number_format($order['qty'],0)." tokens of ".$order['symbol']." has been successful placed.";	
		}else
		{
			$m="Your order for ".number_format($order['qty'],0)." tokens of ".$order['symbol']." at ".number_format($order['price'],2,'.',',')." per token has been successful placed.";
		}
		
		return array('status'=>1,'msg'=>$m,'ChangePriceQty'=>$min_buy_qty,'order'=>$order);
	}	
	
	//Receives orders from brokers and forwards the request to the matching engine if it passes validation.
	//Update is sent to broker/investor informing of order status
	function TradingGateway($order,$ChangePriceQty)
	{				
		$transtype=ucwords($order['transtype']);		
		$ret 			= $this->SaveOrder($order);//Save Order		
		$result 		= $this->MatchingEngine($order,$ChangePriceQty);
		
		/*
			$ret = array('Status'=>1,"msg"=>"Trade Was Successful. ".$TotalTokens." Tokens Of ".$symbol." Was Sold At ".round($TradeAmount,2).".","trade_id"=>$trade_id,'transact_partners'=>$transact_partners);	
			
			$ret = array('Status'=>'0','msg'=>'Trade Execution Failed. Funds Transfer Was Not Successful');
			
			$ret=array('Status'=>'Queued','msg'=>'Your buy order for '.$symbol.' has been queued in the order book.');
		*/		
		//Send Message
		$details='';
		$msgtype='system';
		
		
		if (floatval($order['sms_fee']) > 0) $msgtype .= ',sms';			
		
		$header='Trading Report'; $groups='';
		$emails=$order['broker_email'].','.$order['investor_email'];
		$phones=$order['broker_phone'].','.$order['investor_phone'];
		$category='Message';  $expiredate=date('Y-m-d H:i:s',strtotime('+3 days')); $display_status=1; $sender='System';
		
		if ($result['Status']==1)//Trade Success
		{
			$msgtype .= ',email';
			$details=$result['msg']." Trade Id is ".$result['trade_id'].".";
			$res = $this->SendMessage($header, $details, $msgtype, $groups, $emails, $phones, $category, $display_status, $sender, $expiredate);

			
			//Send Message to transacting partners - transact_partners
			//$transact_partners= array("symbol","broker_id","investor_id","qty","price",'sms_fee','transtype');
			$partners=$result['transact_partners'];
			
			if (count($partners) > 0)
			{
				foreach($partners as $part):
					if (count($part) > 0)
					{
						$symbol = $part['symbol'];  			$broker_id = $part['broker_id'];
						$investor_id = $part['investor_id'];  	$price = $part['price'];
						$qty = $part['qty'];  					$sms_fee = $part['sms_fee'];
						$ttype = $part['transtype'];
						
						//Get phones and emails
						$det = $this->GetBrokerDetails($broker_id);
						if ($det->email) $brokeremail = trim($det->email);
						if ($det->phone) $brokerphone = trim($det->phone);
						
						$inv = $this->GetInvestorDetails($investor_id);
						if ($inv->email) $investor_email = trim($inv->email);
						if ($inv->phone) $investor_phone = trim($inv->phone);
						
						if (trim(strtolower($ttype)) == 'buy')
						{
							$details="Trade Was Successful. ".$qty." Tokens Of ".$symbol." Was Bought At ".round($price,2)." Per Token. Trade Id Is ".$result['trade_id'];
						}elseif (trim(strtolower($ttype)) == 'sell')
						{
							$details="Trade Was Successful. ".$qty." Tokens Of ".$symbol." Was Sold At ".round($price,2)." Per Token. Trade Id Is ".$result['trade_id'];
						}							
						
						$msgtype='system,email';
						$emails=$brokeremail.','.$investor_email;
						$phones=$brokerphone.','.$investor_phone;
													
						if (floatval($part['sms_fee']) > 0) $msgtype .= ',sms';
						
						$res = $this->SendMessage($header, $details, $msgtype, $groups, $emails, $phones, $category, $display_status, $sender, $expiredate);
					}
				endforeach;
			}
		}elseif (strtolower(trim($result['Status'])) == 'queued')//Order Queued
		{
			$header=$transtype.' Order Report';
			$details=$result['msg'];
			
			$res = $this->SendMessage($header, $details, $msgtype, $groups, $emails, $phones, $category, $display_status, $sender, $expiredate);
		}elseif (strtolower(trim($result['Status']))=='fail')//Trade Failed
		{
			$details=$result['msg'];
			
			$res = $this->SendMessage($header, $details, $msgtype, $groups, $emails, $phones, $category, $display_status, $sender, $expiredate);
		}		
				
		return true;
	}
	
	//Processes orders from TradingGateway and manages order books. It also sends updates to MarketData.
	function MatchingEngine($order,$ChangePriceQty)
	{
		$dt=date('Y-m-d H:i:s');
		
		$ret=array(); $orderbook=array(); $trades=array();
		$sellOrders=array(); $buyOrders=array();
		$transact_partners=array();
		
		$symbol='';  $transtype='';  $limit_market='';
		
		$limit_market=$order['limit_market'];
		$transtype=$order['transtype'];
		$symbol=trim(strtoupper($order['symbol']));
		
		$orderbook=$this->GetOrderBook($symbol); //'Symbol'
		$sellOrders=$orderbook['Sell'];
		$buyOrders=$orderbook['Buy'];
		$trade_id=$this->GenerateTradeId();
		
		$TotalTokens = 0;
		$TradeAmount = 0;
		$TotalAmount = 0;
		$BuyBrokersFee = 0;
		$tokenCount = $order['qty'];
		
		//Check of there is any order in the book
		if (trim(strtolower($transtype)) == 'buy')
		{
			$purchasedTokens = 0;// this is where we keep track of total tokens bought
			
			 if (count($sellOrders)==0)//No sell order to match this with. Add to order table.
			 {
				 $ret=array('Status'=>'Queued','msg'=>'Your buy order for '.$symbol.' has been queued in the order book.');
				 
				 return $ret;
			 }else if (count($sellOrders) > 0)
			 {
				 if (trim(strtolower($limit_market)) == 'market')
				 {
					foreach($sellOrders as $sell)
					{
						$thisPurchase = 0; $changedprice='0';
						
						if (($tokenCount - $purchasedTokens) >= $sell['Qty'])
						{
							$thisPurchase = $sell['Qty'];
							$purchasedTokens += $sell['Qty'];
						}else
						{
							$thisPurchase = $tokenCount - $purchasedTokens;
							$purchasedTokens = $tokenCount;
						}
						
						if (intval($thisPurchase) >= intval($ChangePriceQty)) $changedprice=1;
						
						$trades[] = array("trade_id"=>$trade_id,"buy_order_id"=>$order['order_id'], "sell_order_id"=>$sell['order_id'], "symbol"=>$symbol,"transtype"=>$order['transtype'],"buy_broker_id"=>$order['broker_id'],"buy_investor_id"=>$order['investor_id'],"sell_broker_id"=>$sell['broker_id'],"sell_investor_id"=>$sell['investor_id'],"qty" => $thisPurchase,'ask_price'=>$sell['price'],'bid_price'=>'0', "price" => $sell['price'], "changedprice"=>$changedprice,'buy_broker_recipient_code'=>$order['broker_recipient_code'],'buy_investor_recipient_code'=>$order['investor_recipient_code'],'sell_broker_recipient_code'=>$sell['broker_recipient_code'],'sell_investor_recipient_code'=>$sell['investor_recipient_code'],'buy_sms_fee'=>$order['sms_fee']);
						
						$transact_partners[] = array("symbol"=>$symbol,"broker_id"=>$sell['broker_id'],"investor_id"=>$sell['investor_id'],"qty" => $thisPurchase,"price" => $sell['price'], 'sms_fee'=>$sell['sms_fee'],'transtype'=>'Sell');

						$TradeAmount += floatval($thisPurchase) * floatval($sell['price']);
					
						if(intval($purchasedTokens) == intval($tokenCount)) break;
					}	 
				 }elseif (trim(strtolower($limit_market)) == 'limit')
				 {
					 if (trim(strtolower($order['ordertype']))=='aon')
					 {
						foreach($sellOrders as $sell)
						{
							$thisPurchase = 0; $changedprice='0';
							
							if ((intval($order['qty']) == intval($sell['Qty'])) and (floatval($order['price']) >= floatval($sell['price'])))
							{
								$thisPurchase = $sell['Qty'];
								$purchasedTokens = $sell['Qty'];
								
								if (intval($thisPurchase) >= intval($ChangePriceQty)) $changedprice=1;
							
								$trades[] = array("trade_id"=>$trade_id,"buy_order_id"=>$order['order_id'], "sell_order_id"=>$sell['order_id'], "symbol"=>$symbol,"transtype"=>$order['transtype'],"buy_broker_id"=>$order['broker_id'],"buy_investor_id"=>$order['investor_id'],"sell_broker_id"=>$sell['broker_id'],"sell_investor_id"=>$sell['investor_id'],"qty" => $thisPurchase,'ask_price'=>$sell['price'],'bid_price'=>'0', "price" => $sell['price'], "changedprice"=>$changedprice,'buy_broker_recipient_code'=>$order['broker_recipient_code'],'buy_investor_recipient_code'=>$order['investor_recipient_code'],'sell_broker_recipient_code'=>$sell['broker_recipient_code'],'sell_investor_recipient_code'=>$sell['investor_recipient_code'],'buy_sms_fee'=>$order['sms_fee']);
								
								$transact_partners[] = array("symbol"=>$symbol,"broker_id"=>$sell['broker_id'],"investor_id"=>$sell['investor_id'],"qty" => $thisPurchase,"price" => $sell['price'], 'sms_fee'=>$sell['sms_fee'],'transtype'=>'Sell');
								
								$TradeAmount += floatval($thisPurchase) * floatval($sell['price']);
							
								break; 
							}
						}
					 }else
					 {						
						foreach($sellOrders as $sell)
						{
							$thisPurchase = 0; $changedprice='0';
							
							if (floatval($order['price']) >= floatval($sell['price']))
							{
								if (($tokenCount - $purchasedTokens) >= $sell['Qty'])
								{
									$thisPurchase = $sell['Qty'];
									$purchasedTokens += $sell['Qty'];
								}else
								{
									$thisPurchase = $tokenCount - $purchasedTokens;
									$purchasedTokens = $tokenCount;
								}
								
								if (intval($thisPurchase) >= intval($ChangePriceQty)) $changedprice=1;						
							
								$trades[] = array("trade_id"=>$trade_id,"buy_order_id"=>$order['order_id'], "sell_order_id"=>$sell['order_id'], "symbol"=>$symbol,"transtype"=>$order['transtype'],"buy_broker_id"=>$order['broker_id'],"buy_investor_id"=>$order['investor_id'],"sell_broker_id"=>$sell['broker_id'],"sell_investor_id"=>$sell['investor_id'],"qty" => $thisPurchase,'ask_price'=>$sell['price'],'bid_price'=>'0', "price" => $sell['price'], "changedprice"=>$changedprice,'buy_broker_recipient_code'=>$order['broker_recipient_code'],'buy_investor_recipient_code'=>$order['investor_recipient_code'],'sell_broker_recipient_code'=>$sell['broker_recipient_code'],'sell_investor_recipient_code'=>$sell['investor_recipient_code'],'buy_sms_fee'=>$order['sms_fee']);
								
								$transact_partners[] = array("symbol"=>$symbol,"broker_id"=>$sell['broker_id'],"investor_id"=>$sell['investor_id'],"qty" => $thisPurchase,"price" => $sell['price'], 'sms_fee'=>$sell['sms_fee'],'transtype'=>'Sell');
								
																								
								$TradeAmount += floatval($thisPurchase) * floatval($sell['price']);
							
								if(intval($purchasedTokens) == intval($tokenCount)) break; 
							}
						}
					 }
				 }				
			 }
			 
			 $TotalTokens=$purchasedTokens;
		}elseif (trim(strtolower($transtype)) == 'sell')
		{
			$sell_order_id=$order['order_id'];
			
			$soldTokens = 0; // this is where we keep track of total tokens sold
			
			if (count($buyOrders)==0)//No buy order to match this with. Add to order table.
			{
			 	$ret=array('Status'=>'Queued','msg'=>'Your sell order for '.$symbol.' has been queued in the order book.');
				
				return $ret;
			}elseif (count($buyOrders) > 0)
			{
				if (trim(strtolower($limit_market)) == 'market')
				{					
					foreach($buyOrders as $buy)
					{
						$thisSell = 0; $changedprice='0';
						
						if (($tokenCount - $soldTokens) >= $buy['Qty'])
						{
							$thisSell = $buy['Qty'];
							$soldTokens += $buy['Qty'];
						}else
						{
							$thisSell = $tokenCount - $soldTokens;
							$soldTokens = $tokenCount;
						}
						
						if (intval($thisSell) >= intval($ChangePriceQty)) $changedprice=1;
					
						$trades[] = array("trade_id"=>$trade_id,"sell_order_id"=>$order['order_id'],"buy_order_id"=>$buy['order_id'],"symbol"=>$symbol,"transtype"=>$order['transtype'],"sell_broker_id"=>$order['broker_id'],"sell_investor_id"=>$order['investor_id'],"buy_broker_id"=>$buy['broker_id'],"buy_investor_id"=>$buy['investor_id'],"qty" => $thisSell, 'ask_price'=>'0','bid_price'=>$buy['price'], "price" => $buy['price'], "changedprice"=>$changedprice,'buy_broker_recipient_code'=>$buy['broker_recipient_code'],'buy_investor_recipient_code'=>$buy['investor_recipient_code'],'sell_broker_recipient_code'=>$order['broker_recipient_code'],'sell_investor_recipient_code'=>$order['investor_recipient_code'],'sell_sms_fee'=>$order['sms_fee']);
						
						$transact_partners[] = array("symbol"=>$symbol,"broker_id"=>$buy['broker_id'],"investor_id"=>$buy['investor_id'],"qty" => $thisSell,"price" => $buy['price'],'sms_fee'=>$buy['sms_fee'],'transtype'=>'Buy');
						
						$TradeAmount += floatval($thisSell) * floatval($buy['price']);
					
						if(intval($soldTokens) == intval($tokenCount)) break;
					}
				}elseif (trim(strtolower($limit_market)) == 'limit')
				{
					if (trim(strtolower($order['ordertype']))=='aon')
					{
						foreach($buyOrders as $buy)
						{
							$thisPurchase = 0; $changedprice='0';
							
							if ((intval($order['qty']) == intval($buy['Qty'])) and (floatval($order['price']) >= floatval($buy['price'])))
							{
								$thisPurchase = $buy['Qty'];
								$soldTokens = $buy['Qty'];
								
								if (intval($thisPurchase) >= intval($ChangePriceQty)) $changedprice=1;
							
								$trades[] = array("trade_id"=>$trade_id,"sell_order_id"=>$order['order_id'],"buy_order_id"=>$buy['order_id'],"symbol"=>$symbol,"transtype"=>$order['transtype'],"sell_broker_id"=>$order['broker_id'],"sell_investor_id"=>$order['investor_id'],"buy_broker_id"=>$buy['broker_id'],"buy_investor_id"=>$buy['investor_id'],"qty" => $thisSell, 'ask_price'=>'0','bid_price'=>$buy['price'], "price" => $buy['price'], "changedprice"=>$changedprice,'buy_broker_recipient_code'=>$buy['broker_recipient_code'],'buy_investor_recipient_code'=>$buy['investor_recipient_code'],'sell_broker_recipient_code'=>$order['broker_recipient_code'],'sell_investor_recipient_code'=>$order['investor_recipient_code'],'sell_sms_fee'=>$order['sms_fee']);
								$transact_partners[] = array("symbol"=>$symbol,"broker_id"=>$buy['broker_id'],"investor_id"=>$buy['investor_id'],"qty" => $thisSell,"price" => $buy['price'],'sms_fee'=>$buy['sms_fee'],'transtype'=>'Buy');
								
								$TradeAmount += floatval($thisSell) * floatval($buy['price']);
							
								break; 
							}
						}
					}else
					{
						foreach($buyOrders as $buy)
						{
							$thisPurchase = 0; $changedprice='0';
							
							if (floatval($order['price']) >= floatval($buy['price']))
							{
								if (($tokenCount - $soldTokens) >= $buy['Qty'])
								{
									$thisPurchase = $buy['Qty'];
									$soldTokens += $buy['Qty'];
								}else
								{
									$thisPurchase = $tokenCount - $soldTokens;
									$soldTokens = $tokenCount;
								}
								
								if (intval($thisPurchase) >= intval($ChangePriceQty)) $changedprice=1;						
							
								$trades[] = array("trade_id"=>$trade_id,"sell_order_id"=>$order['order_id'],"buy_order_id"=>$buy['order_id'],"symbol"=>$symbol,"transtype"=>$order['transtype'],"sell_broker_id"=>$order['broker_id'],"sell_investor_id"=>$order['investor_id'],"buy_broker_id"=>$buy['broker_id'],"buy_investor_id"=>$buy['investor_id'],"qty" => $thisSell, 'ask_price'=>'0','bid_price'=>$buy['price'], "price" => $buy['price'], "changedprice"=>$changedprice,'buy_broker_recipient_code'=>$buy['broker_recipient_code'],'buy_investor_recipient_code'=>$buy['investor_recipient_code'],'sell_broker_recipient_code'=>$order['broker_recipient_code'],'sell_investor_recipient_code'=>$order['investor_recipient_code'],'sell_sms_fee'=>$order['sms_fee']);
								$transact_partners[] = array("symbol"=>$symbol,"broker_id"=>$buy['broker_id'],"investor_id"=>$buy['investor_id'],"qty" => $thisSell,"price" => $buy['price'],'sms_fee'=>$buy['sms_fee'],'transtype'=>'Buy');
								
								$TradeAmount += floatval($thisSell) * floatval($buy['price']);
							
								if(intval($soldTokens) == intval($tokenCount)) break; 
							}
						}
					}
				}
			}
			
			$TotalTokens = $soldTokens;
		}
//print_r($trades); echo '<br><br>'; print_r($transact_partners); exit();
		
		$TotalAmount += $TradeAmount;
		
		$brokers_rate = 0 ; $nse_commission = 0; $TransferFee = 0; $current_price=0; $sms_fee=0;
		$nse_recipientcode='';
				
		$set 			= $this->GetTradingParamaters();
		$paystack 		= $this->GetPaystackSettings();
		$current_price 	= $this->GetSymbolPrice($symbol);
		$setings		= $this->GetParamaters();
		
		if ($set->brokers_commission) $brokers_rate = $set->brokers_commission;
		if ($set->nse_commission) $nse_commission = $set->nse_commission;	
		if ($paystack->transfer_fee) $TransferFee = $paystack->transfer_fee;
		if ($setings->recipient_code) $nse_recipientcode = $setings->recipient_code;		
		
		$TotalBuyerFee=array(); //Deduction
		$TotalSellerFee=array();//Transfer
		$TotalBuyBrokersFee=array(); //Transfer
		$TotalSellBrokersFee=array(); //Transfer
		$recipients=array();//Payment recipients
		$transfers=array();
		
		$TotalNSEFee=0; $currency='NGN';
		
		$deductions=array(); $price_changes = array(); $trades_table=array(); $trades_payments=array();
		
		//Compute total fees
		if (count($trades) > 0)
		{
			foreach($trades as $trade):
				$qty=0; $price=0; $amount=0; $brokerfee=0; $nsefee=0; $buyerfee=0; $sellerfee=0;
				$buy_sms=0; $sell_sms=0;
				
				if (isset($trade['buy_sms_fee']) and (floatval($trade['buy_sms_fee']) > 0)) $buy_sms=floatval($trade['buy_sms_fee']);
				
				if (isset($trade['sell_sms_fee']) and (floatval($trade['sell_sms_fee']) > 0)) $sell_sms=floatval($trade['sell_sms_fee']);
				
				$qty = floatval($trade['qty']);
				$price = floatval($trade['price']);				
				$amount = $qty * $price;
				$brokerfee = round(((floatval($brokers_rate)/100) * $amount),2);//Same for seller/buyer brokers
				$nsefee = round(((floatval($nse_commission)/100) * $amount),2);
				$buyerfee = round(($amount + $brokerfee + ($nsefee/2)),2);//Deduct from broker
				$sellerfee = round(($amount - $brokerfee - ($nsefee/2)),2);
				
				if (isset($TotalBuyerFee[$trade['buy_investor_id']]))
				{
					$TotalBuyerFee[$trade['buy_investor_id']] += $buyerfee;
				}else
				{
					$TotalBuyerFee[$trade['buy_investor_id']] = $buyerfee + ($buy_sms/2);
				}
				
				if (isset($TotalSellerFee[$trade['sell_investor_id']]))
				{
					$TotalSellerFee[$trade['sell_investor_id']] += $sellerfee;
				}else
				{
					$TotalSellerFee[$trade['sell_investor_id']] = $sellerfee - ($sell_sms/2);
				}
				
				if (isset($TotalBuyBrokersFee[$trade['buy_broker_id']]))
				{
					$TotalBuyBrokersFee[$trade['buy_broker_id']] += $brokerfee;
				}else
				{
					$TotalBuyBrokersFee[$trade['buy_broker_id']] = $brokerfee - ($buy_sms/2);
				}
				
				if (isset($TotalSellBrokersFee[$trade['sell_broker_id']]))
				{
					$TotalSellBrokersFee[$trade['sell_broker_id']] += $brokerfee;
				}else
				{
					$TotalSellBrokersFee[$trade['sell_broker_id']] = $brokerfee - ($sell_sms/2);
				}
				
				$TotalNSEFee += $nsefee;
				
				//Track Prices changes
				if ($trade['changedprice'] == 1)
				{
					$price_changes=array('trade_id'=>$trade['trade_id'],'symbol'=>$symbol,'current_price'=>$current_price,'new_price'=>$price,'qty'=>$qty,'date_updated'=>$dt);
				}
				
				//trades_table
				$trades_table[]=array('sell_broker_id'=>$trade['sell_broker_id'],'sell_order_id'=>$trade['sell_order_id'],'buy_broker_id'=>$trade['buy_broker_id'],'buy_order_id'=>$trade['buy_order_id'],'trade_id'=>$trade['trade_id'],'symbol'=>$trade['symbol'],'num_tokens'=>$qty,'ask_price'=>$trade['ask_price'],'bid_price'=>$trade['bid_price'],'trade_price'=>$price,'sell_broker_fee'=>$brokerfee,'buy_broker_fee'=>$brokerfee,'nse_fee'=>$nsefee,'transfer_fees'=>($TransferFee * 4),'tradestatus'=>1,'payment_status'=>'Successful','tradedate'=>$dt);
			endforeach;
		}


		/****** PAYMENTS *****/
		//Seller		
		if (count($TotalSellerFee) > 0)
		{
			foreach($TotalSellerFee as $Id => $amt)
			{
				foreach($trades as $trade)
				{
					if (trim(strtolower($Id)) == trim(strtolower($trade['sell_investor_id'])))
					{
						$desc="Payment For Sales Of ".$trade['qty']." Tokens Of ".$trade['symbol']." At ".round($trade['price'],2)." Per Token. Trade Id Is ".$trade['trade_id'];
						
						$transfers[]=array("amount"=>($amt*100), "reason"=>$desc, "recipient"=>$trade['sell_investor_recipient_code']);
						
						$trades_payments[] = array('trade_id'=>$trade['trade_id'],'symbol'=>$trade['symbol'],'num_tokens'=>$trade['qty'],'price'=>round($trade['price'],2),'trade_amount'=>round($TradeAmount,2),'recipient_amount'=>round($amt,2),'recipient'=>'Seller','recipient_code'=>$trade['sell_investor_recipient_code'],'description'=>$desc,'trade_date'=>$dt);
					}
				}
			}
		}
		
		//Seller Broker
		if (count($TotalSellBrokersFee) > 0)
		{
			foreach($TotalSellBrokersFee as $Id => $amt)
			{
				foreach($trades as $trade)
				{
					if (trim(strtolower($Id)) == trim(strtolower($trade['sell_broker_id'])))
					{
						$desc="Commission For Sales Of ".$trade['qty']." Tokens Of ".$trade['symbol']." At ".round($trade['price'],2)." Per Token. Trade Id Is ".$trade['trade_id'];
						
						$transfers[]=array("amount"=>$amt, "reason"=>$desc, "recipient"=>$trade['sell_broker_recipient_code']);
						
						$trades_payments[] = array('trade_id'=>$trade['trade_id'],'symbol'=>$trade['symbol'],'num_tokens'=>$trade['qty'],'price'=>round($trade['price'],2),'trade_amount'=>round($TradeAmount,2),'recipient_amount'=>round($amt,2),'recipient'=>'Seller Broker','recipient_code'=>$trade['sell_broker_recipient_code'],'description'=>$desc,'trade_date'=>$dt);
					}
				}
			}
		}
		
		//Buyer Broker
		if (count($TotalBuyBrokersFee) > 0)
		{
			foreach($TotalBuyBrokersFee as $Id => $amt)
			{
				foreach($trades as $trade)
				{
					if (trim(strtolower($Id)) == trim(strtolower($trade['buy_broker_id'])))
					{
						$TotalAmount += $amt;
						$BuyBrokersFee += $amt;
						
						$desc = "Commission For Buying Of ".$trade['qty']." Tokens Of ".$trade['symbol']." At ".round($trade['price'],2)." Per Token. Trade Id Is ".$trade['trade_id'];
						
						$transfers[]=array("amount"=>$amt, "reason"=>$desc, "recipient"=>$trade['buy_broker_recipient_code']);
						
						$trades_payments[] = array('trade_id'=>$trade['trade_id'],'symbol'=>$trade['symbol'],'num_tokens'=>$trade['qty'],'price'=>round($trade['price'],2),'trade_amount'=>round($TradeAmount,2),'recipient_amount'=>round($amt,2),'recipient'=>'Buyer Broker','recipient_code'=>$trade['buy_broker_recipient_code'],'description'=>$desc,'trade_date'=>$dt);
					}
				}
			}
		}
		
		//NSE
		$desc="Commission For Trading Of ".$TotalTokens." Tokens Of ".$symbol." At ".round($current_price,2)." Per Token. Trade Id Is ".$trade_id;
		
		$TotalAmount += $TotalNSEFee;
		
		$transfers[]=array("amount"=>$TotalNSEFee, "reason"=>$desc, "recipient"=>$nse_recipientcode);
		
		$trades_payments[] = array('trade_id'=>$trade_id,'symbol'=>$symbol,'num_tokens'=>$TotalTokens,'price'=>round($current_price,2),'trade_amount'=>round($TradeAmount,2),'recipient_amount'=>round($TotalNSEFee,2),'recipient'=>'NSE','recipient_code'=>$nse_recipientcode,'description'=>$desc,'trade_date'=>$dt);
		
		//Buyer - deductions from buyer broker account
		if (count($TotalBuyerFee) > 0)
		{
			foreach($TotalBuyerFee as $Id => $amt)
			{
				foreach($trades as $trade)
				{
					if (trim(strtolower($Id)) == trim(strtolower($trade['buy_investor_id'])))
					{
						$deductions[]=array('trade_id'=>$trade['trade_id'],"amount"=>$amt, "reason"=>"Payment For Buying Of ".$trade['qty']." Tokens Of ".$trade['symbol']." At ".round($trade['price'],2)." Per Token. Trade Id Is ".$trade['trade_id'], "investor_id"=>$trade['buy_investor_id'],'buyer_broker_id'=>$trade['buy_broker_id']);
					}
				}
			}
		}
		
		//Make transfers		
		$recipients=array("currency"=>$currency, "source"=>"balance", "transfers"=>$transfers);				
		$recipients_string = http_build_query($recipients);		
		$transfer_result = $this->PaystackBulkTransferFunds($recipients_string);
		
		if ($transfer_result['Status']==1)
		{			
			if (count($deductions) > 0) $this->BalanceWalletAfterTrade($deductions); //Deduct from Wallet
			
			if (count($trades_table) > 0) $save_trade_result=$this->SaveTrade($trades_table); //Save trades
			
			//Update Prices And Order Values			
			if (count($price_changes) > 0)//****Change And Update Price
			{
				$sql="SELECT * FROM price_changes WHERE (TRIM(trade_id)='".$this->db->escape_str($price_changes['trade_id'])."') AND (TRIM(symbol)='".$this->db->escape_str($price_changes['symbol'])."') AND (DATE_FORMAT(date_updated,'%Y-%m-%d')='".date('Y-m-d')."')";
				
				$query=$this->db->query($sql);
				
				if ($query->num_rows() == 0)
				{
					$this->db->trans_start();	
							
					$dat=array(
						'trade_id' 		=> $this->db->escape_str($price_changes['trade_id']),
						'symbol' 		=> $this->db->escape_str($price_changes['symbol']),
						'qty' 			=> $this->db->escape_str($price_changes['qty']),
						'current_price'	=> $this->db->escape_str($price_changes['current_price']),
						'new_price' 	=> $this->db->escape_str($price_changes['new_price']),
						'date_updated'	=> $this->db->escape_str($price_changes['date_updated'])
					);
				
					$this->db->insert('price_changes', $dat);							
					$this->db->trans_complete();
				}
				
				
				//Get High And Low Intraday Prices
				$high=0; $low=0; $volume=0; $change=0; $no_of_trades=0; $trade_value=0;
				$close_price=0; $prevclose=0; $changepercent=0;
				
				$sql="SELECT MAX(trade_price) AS High, MIN(trade_price) AS Low FROM trades WHERE (TRIM(symbol)='".$this->db->escape_str($symbol)."') AND (trade_price > 0) AND (DATE_FORMAT(tradedate,'%Y-%m-%d')='".date('Y-m-d')."')";
				
				$query=$this->db->query($sql);
				
				if ($query->num_rows() > 0)
				{
					$row = $query->row();
					
					if ($row->High) $high =$row->High;
					if ($row->Low) 	$low =$row->Low;
	
					$close_price = floatval($price_changes['new_price']);
					
					$trade_value = intval($TotalTokens) * $close_price;
					
					$sql="SELECT * FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".date('Y-m-d')."') AND (TRIM(symbol)='".$this->db->escape_str($symbol)."')";
					
					$query=$this->db->query($sql);
					
					if ($query->num_rows() > 0)
					{
						$row = $query->row();
						
						if ($row->previous_close_price) $prevclose =$row->previous_close_price;
						if ($row->trades) $no_of_trades = $row->trades + 1; else $no_of_trades=1;
						if ($row->volume) $volume = $row->volume + intval($TotalTokens); else $volume=$TotalTokens;
						if ($row->trade_value) $trade_value += $row->trade_value;
						
						$change = $close_price - $prevclose;
						$changepercent = round(($change/$prevclose) * 100,2);
						
						//Update daily_price
						$this->db->trans_start();	
							
						$dat=array(
							'close_price' 			=> $this->db->escape_str($close_price),
							'high_price' 			=> $this->db->escape_str($high),
							'low_price' 			=> $this->db->escape_str($low),
							'volume'				=> $this->db->escape_str($volume),
							'change' 				=> $this->db->escape_str($change),
							'trades'				=> $this->db->escape_str($no_of_trades),
							'trade_value'			=> $this->db->escape_str($trade_value),
							'previous_close_price'	=> $this->db->escape_str($prevclose),
							'change_percent'		=> $this->db->escape_str($changepercent)
						);
					
						$this->db->where(array('symbol'=>$symbol,'price_date'=>date('Y-m-d')));
						$this->db->update('daily_price', $dat);						
						$this->db->trans_complete();
					}				
				}
			}
						
			//Update portfolios
						
//$trades[] = array("symbol", "transtype", "buy_broker_id", "buy_investor_id", "sell_broker_id", "sell_investor_id", "qty",'ask_price','bid_price', "price");


			//*******SELLER PORTFOLIO
			if (count($trades) > 0)
			{
				foreach($trades as $trade):
					$sell_email=''; $buy_email='';	$sell_uid=''; $buy_uid=''; $title='';
					
					//Seller
					$inv_rw = $this->GetInvestorDetails($trade['sell_investor_id']);				
					if ($inv_rw->email) $sell_email = trim($inv_rw->email);
					if ($inv_rw->uid) $sell_uid = trim($inv_rw->uid);
					
					//Buyer
					$inv_rw = $this->GetInvestorDetails($trade['buy_investor_id']);				
					if ($inv_rw->email) $buy_email = trim($inv_rw->email);
					if ($inv_rw->uid) $buy_uid = trim($inv_rw->uid);
					
					$at = $this->GetArtTitle($trade['symbol']);
					$title = trim($at);
										
					//Buyer
					$sql="SELECT * FROM portfolios WHERE ((TRIM(email)='".$this->db->escape_str($buy_email)."') OR (TRIM(uid)='".$this->db->escape_str($buy_uid)."')) AND (TRIM(broker_id)='".$this->db->escape_str($trade['buy_broker_id'])."') AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
						
					$query=$this->db->query($sql);
					
					if ($query->num_rows() > 0)
					{
						$rr = $query->row();
						
						$tok = intval($rr->tokens) + intval($trade['qty']);	
						
						$this->db->trans_start();	
						
						$dat=array(
							'tokens' 		=> $this->db->escape_str($tok),
							'currentprice' 	=> $this->db->escape_str($trade['price']),
							'date_updated'	=> $dt
						);			
		
						$this->db->where(array('email'=>$buy_email,'broker_id'=>$trade['buy_broker_id'],'symbol'=>$trade['symbol']));
						$this->db->update('portfolios',$dat);
													
						$this->db->trans_complete();
					}else
					{							
						$this->db->trans_start();			
						
						$dat=array(
							'email' 		=> $this->db->escape_str($buy_email),
							'uid' 			=> $this->db->escape_str($buy_uid),
							'broker_id' 	=> $this->db->escape_str($trade['buy_broker_id']),
							'symbol'		=> $this->db->escape_str($trade['symbol']),
							'art_title' 	=> $this->db->escape_str($title),
							'tokens' 		=> $this->db->escape_str($trade['qty']),
							'price_bought' 	=> $this->db->escape_str($trade['price']),
							'currentprice' 	=> $this->db->escape_str($trade['price']),
							'date_created'	=> $dt
						);
						
						$this->db->insert('portfolios', $dat);	
							
						$this->db->trans_complete();
					}
					
			
					//Seller
					$sql="SELECT * FROM portfolios WHERE ((TRIM(email)='".$this->db->escape_str($sell_email)."') OR (TRIM(uid)='".$this->db->escape_str($sell_uid)."')) AND (TRIM(broker_id)='".$this->db->escape_str($trade['sell_broker_id'])."') AND (TRIM(symbol)='".$this->db->escape_str($trade['symbol'])."')";
					
					$query=$this->db->query($sql);
					
					if ($query->num_rows() > 0)
					{
						$rr = $query->row();
						
						$tok = intval($rr->tokens) - intval($trade['qty']);	
						
						$this->db->trans_start();	
						
						$dat=array(
							'tokens' 		=> $this->db->escape_str($tok),
							'currentprice' 	=> $this->db->escape_str($trade['price']),
							'date_updated'	=> $dt
						);		
		
						$this->db->where(array('email'=>$sell_email,'broker_id'=>$trade['sell_broker_id'],'symbol'=>$trade['symbol']));
						$this->db->update('portfolios',$dat);
													
						$this->db->trans_complete();
					}else
					{							
						$this->db->trans_start();			
						
						$dat=array(
							'email' 		=> $this->db->escape_str($sell_email),
							'uid' 			=> $this->db->escape_str($sell_uid),
							'broker_id' 	=> $this->db->escape_str($trade['sell_broker_id']),
							'symbol'		=> $this->db->escape_str($trade['symbol']),
							'art_title' 	=> $this->db->escape_str($title),
							'tokens' 		=> $this->db->escape_str($trade['qty']),
							'price_bought' 	=> $this->db->escape_str($trade['price']),
							'currentprice' 	=> $this->db->escape_str($trade['price']),
							'date_created'	=> $dt
						);
						
						$this->db->insert('portfolios', $dat);	
							
						$this->db->trans_complete();
					}
					
					//Update orders
					//Buyer
					$sql="SELECT * FROM orders WHERE (TRIM(order_id)='".$this->db->escape_str($trade['buy_order_id'])."')";
						
					$query=$this->db->query($sql);
					
					if ($query->num_rows() > 0)
					{
						$rr = $query->row();
						
						$tamt = floatval($trade['qty']) * floatval($trade['price']); //Trade amount						
						$availQty= intval($rr->available_qty) - intval($trade['qty']);
						$sta='';						
						if (intval($availQty)==0) $sta='Executed';else $sta='Active';
		//$file = fopen('aaa.txt',"w"); fwrite($file,print_r("Avail. Qty = ".$order['available_qty']."\r\nTotal Token = ".$TotalTokens."\r\nAvail Qty = ".$availQty,true)); fclose($file);									
						$this->db->trans_start();	
							
						$dat=array(
							'available_qty' 	=> $this->db->escape_str($availQty),
							'trade_amount' 		=> $this->db->escape_str($tamt),
							'total_amount' 		=> $this->db->escape_str($TotalAmount),
							'broker_commission'	=> $this->db->escape_str($TotalBuyBrokersFee[$trade['buy_broker_id']]),
							'nse_commission' 	=> $this->db->escape_str($TotalNSEFee),
							'orderstatus'		=> $sta,
							'canupdate'			=> 0,
							'transfer_fee'		=> 0.00
						);
					
						$this->db->where('order_id',$trade['buy_order_id']);
						$this->db->update('orders', $dat);						
						$this->db->trans_complete();
					}
					
					//Seller
					$sql="SELECT * FROM orders WHERE (TRIM(order_id)='".$this->db->escape_str($trade['sell_order_id'])."')";
						
					$query=$this->db->query($sql);
					
					if ($query->num_rows() > 0)
					{
						$rr = $query->row();
						
						$tamt = floatval($trade['qty']) * floatval($trade['price']); //Trade amount						
						$availQty= intval($rr->available_qty) - intval($trade['qty']);
						$sta='';						
						if (intval($availQty)==0) $sta='Executed';else $sta='Active';
						
						$this->db->trans_start();	
							
						$dat=array(
							'available_qty' 	=> $this->db->escape_str($availQty),
							'trade_amount' 		=> $this->db->escape_str($tamt),
							'total_amount' 		=> $this->db->escape_str($TotalAmount),
							'broker_commission'	=> $this->db->escape_str($TotalBuyBrokersFee[$trade['sell_order_id']]),
							'nse_commission' 	=> $this->db->escape_str($TotalNSEFee),
							'orderstatus'		=> $sta,
							'canupdate'			=> 0,
							'transfer_fee'		=> 0.00
						);
					
						$this->db->where('order_id',$trade['sell_order_id']);
						$this->db->update('orders', $dat);						
						$this->db->trans_complete();
					}
					
				endforeach;
			}			
			
			
			//trades_payments  => currency,amount,transfer_code,transfer_date	-> UPDATE AFTER TRANSFER			
			if (count($trades_payments) > 0)
			{
				foreach($trades_payments as $pay)
				{
					$sql="SELECT * FROM trades_payments WHERE (TRIM(trade_id)='".$this->db->escape_str($pay['trade_id'])."') AND (TRIM(recipient)='".$this->db->escape_str($pay['recipient'])."') AND (TRIM(recipient_amount)=".$this->db->escape_str($pay['recipient_amount']).") AND (TRIM(recipient_code)='".$this->db->escape_str($pay['recipient_code'])."')";
				
					$query=$this->db->query($sql);
					
					if ($query->num_rows() == 0)
					{
						$this->db->trans_start();	
							
						$dat=array(
							'trade_id' 			=> $this->db->escape_str($pay['trade_id']),
							'symbol' 			=> $this->db->escape_str($pay['symbol']),
							'num_tokens' 		=> $this->db->escape_str($pay['num_tokens']),
							'price' 			=> $this->db->escape_str($pay['price']),
							'trade_amount' 		=> $this->db->escape_str($pay['trade_amount']),
							'recipient_amount'	=> $this->db->escape_str($pay['recipient_amount']),
							'recipient' 		=> $this->db->escape_str($pay['recipient']),
							'recipient_code' 	=> $this->db->escape_str($pay['recipient_code']),
							'description'		=> $this->db->escape_str($pay['description']),
							'trade_date'		=> $this->db->escape_str($pay['trade_date'])
						);
					
						$this->db->insert('trades_payments', $dat);	
							
						$this->db->trans_complete();
					}
				}
			}
			
			$ret = array('Status'=>1,"msg"=>"Trade Was Successful. ".$TotalTokens." Tokens Of ".$symbol." Was Sold At ".round($TradeAmount,2).".","trade_id"=>$trade_id,'transact_partners'=>$transact_partners);
		}else
		{
			$ret = array('Status'=>'FAIL','msg'=>'Trade Execution Failed. Funds Transfer Was Not Successful. '.$transfer_result['Message']);
		}
	
		return $ret;
	}
	
	function BalanceWalletAfterTrade($deductions)
	{//Deduct from buyer's broker wallet balance
	
		$ret=false;

		foreach($deductions as $deduct)
		{			
			$this->db->trans_start();			
			
			$this->db->set('balance', 'balance - '.$deduct['amount'],false);
			
			$where="(TRIM(uid)='".$deduct['buyer_broker_id']."') OR (TRIM(email)='".$deduct['buyer_broker_id']."')";
			
			$this->db->where($where);
			$this->db->update('wallets');
				
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE)
			{
				$operation='Deduction Of Trade Amount From Wallet For Trade With Id '.$deduct['trade_id'].' Failed';
				
				$activity='Attempted Deducting The Trade Amount From The Buyer Broker Wallet Balance For A Trade With Id '.$deduct['trade_id'].' But Failed. Details Of The Trade Are: Trade Id: '.$deduct['trade_id'].'; Buyer Broker Id: '.$deduct['buyer_broker_id'].'; Description: '.$deduct['reason'];
			}else
			{		
				//Log activity
				$operation='Deducted Trade Amount From Wallet';
				
				$activity="Trade Amount Was Deducted From Buyer Broker's Wallet For Trade With Id ".$deduct['trade_id'].". Details Of The Trade Are: Trade Id: ".$deduct['trade_id']."; Buyer Broker Id: ".$deduct['buyer_broker_id']."; Description: ".$deduct['reason'];
									
				$ret=true;
			}		
		}		
	
		//Log activity
		$username='System';
		$fullname='Naija Art Mart Core';
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
		$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
		
		return $ret;
	}
	
	function SaveTrade($trades)
	{
		$ret=false;
			
		if (count($trades) > 0)
		{
			foreach($trades as $trade)
			{
				$this->db->trans_start();	
					
				$dat=array(
					'sell_broker_id' 	=> $this->db->escape_str($trade['sell_broker_id']),
					'sell_order_id' 	=> $this->db->escape_str($trade['sell_order_id']),
					'buy_broker_id' 	=> $this->db->escape_str($trade['buy_broker_id']),
					'buy_order_id' 		=> $this->db->escape_str($trade['buy_order_id']),
					'trade_id' 			=> $this->db->escape_str($trade['trade_id']),
					'symbol'			=> $this->db->escape_str($trade['symbol']),
					'num_tokens' 		=> $this->db->escape_str($trade['num_tokens']),
					'ask_price' 		=> $this->db->escape_str($trade['ask_price']),
					'bid_price'			=> $this->db->escape_str($trade['bid_price']),
					'trade_price' 		=> $this->db->escape_str($trade['trade_price']),
					'sell_broker_fee'	=> $this->db->escape_str($trade['sell_broker_fee']),
					'buy_broker_fee' 	=> $this->db->escape_str($trade['buy_broker_fee']),
					'nse_fee' 			=> $this->db->escape_str($trade['nse_fee']),
					'transfer_fees' 	=> $this->db->escape_str($trade['transfer_fees']),
					'tradestatus' 		=> $this->db->escape_str($trade['tradestatus']),			
					'payment_status' 	=> $this->db->escape_str($trade['payment_status']),
					'engine_type' 		=> 'Automatic',
					'tradedate'			=> $this->db->escape_str($trade['tradedate'])
				);
				
				$this->db->insert('trades', $dat);	
					
				$this->db->trans_complete();
				
				if ($this->db->trans_status() === FALSE)
				{
					$operation='Saving Trade Record With Trade Id '.$trade['trade_id'].' Failed';
					
					$activity='Attempted Saving A Trade With Id '.$trade['trade_id'].' But Failed. Details Of The Trade Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Buyer Broker Id: '.$trade['buy_broker_id'].'; Seller Broker Id: '.$trade['sell_broker_id'].'; Sell Order Id: '.$trade['sell_order_id'].'; Buy Order Id: '.$trade['buy_order_id'].' Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Ask Price: '.$trade['ask_price'].'; Bid Price: '.$trade['bid_price'].'; Trade Price: '.$trade['trade_price'].'; Trade Amount: '.round((floatval($trade['num_tokens']) * floatval($trade['trade_price'])),2).'; Seller Broker Fee: '.$trade['sell_broker_fee'].'; Buyer Broker Fee: '.$trade['buy_broker_fee'].'; NSE Commission: '.$trade['nse_fee'].'; Transfer Fees: '.$trade['transfer_fees'].'; Trade Status: '.$trade['tradestatus'].'; Payment Status: '.$trade['payment_status'];
				}else
				{		
					//Log activity
					$operation='Saved Trade Record';
					
					$activity='A Trade Was Created With Id '.$trade['trade_id'].'. Details Of The Trade Are: Trade Date: '.$trade['tradedate'].'; Trade Id: '.$trade['trade_id'].'; Buyer Broker Id: '.$trade['buy_broker_id'].'; Seller Broker Id: '.$trade['sell_broker_id'].'; Sell Order Id: '.$trade['sell_order_id'].'; Buy Order Id: '.$trade['buy_order_id'].' Asset: '.$trade['symbol'].'; Trade Quantity: '.$trade['num_tokens'].'; Ask Price: '.$trade['ask_price'].'; Bid Price: '.$trade['bid_price'].'; Trade Price: '.$trade['trade_price'].'; Trade Amount: '.round((floatval($trade['num_tokens']) * floatval($trade['trade_price'])),2).'; Seller Broker Fee: '.$trade['sell_broker_fee'].'; Buyer Broker Fee: '.$trade['buy_broker_fee'].'; NSE Commission: '.$trade['nse_fee'].'; Transfer Fees: '.$trade['transfer_fees'].'; Trade Status: '.$trade['tradestatus'].'; Payment Status: '.$trade['payment_status'];
										
					$ret=true;
				}		
			}
		}		
		
		//Log activity
		$username='System';
		$fullname='Naija Art Mart Core';
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
		$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
		
		return $ret;
	}	
	
	function GetOrderBook($symbol)
	{
		$sell_orders=array(); $buy_orders=array(); $buy=array(); $sell=array();
		
		$sell_sql="SELECT broker_recipient_code,investor_recipient_code,symbol,price,orderdate AS orderdatetime,DATE_FORMAT(orderdate,'%d %b %Y') AS orderdate,MID(orderdate,11) AS 'ordertime',order_id,broker_id,investor_id,transtype,qty,available_qty,sms_fee,ordertype FROM orders WHERE (TRIM(transtype)='Sell') AND (TRIM(orderstatus)='Active') AND (TRIM(symbol)='".$this->db->escape_str($symbol)."') AND (price > 0) ORDER BY symbol,price,orderdate";		
			   
		$buy_sql="SELECT broker_recipient_code,investor_recipient_code,symbol,price,orderdate AS orderdatetime,DATE_FORMAT(orderdate,'%d %b %Y') AS orderdate,MID(orderdate,11) AS 'ordertime' ,order_id,broker_id,investor_id,transtype,qty,available_qty,sms_fee,ordertype FROM orders WHERE (TRIM(transtype)='Buy') AND (TRIM(orderstatus)='Active') AND (TRIM(symbol)='".$this->db->escape_str($symbol)."') AND (price > 0) ORDER BY symbol,price DESC,orderdate";
		
		//Get sell orders records
		$query=$this->db->query($sell_sql);		
		if ($query->num_rows() > 0) $sell_orders = $query->result_array();
		
		//Get buy orders records
		$query=$this->db->query($buy_sql);
		if ($query->num_rows() > 0) $buy_orders = $query->result_array();

		$sell_total_qty=0; $buy_total_qty=0;		
		
		if (count($sell_orders) > 0)
		{
			foreach($sell_orders as $row):
				if ($row['symbol'] and $row['order_id'] and $row['transtype'] and $row['broker_id'])
				{
					$sell_total_qty += $row['available_qty'];
					
					$sell[] = array('Symbol'=>$row['symbol'],"Qty"=>$row['available_qty'],"order_id"=>$row['order_id'],'price'=>$row['price'],'broker_id'=>$row['broker_id'],'investor_id'=>$row['investor_id'],'total_qty'=>$sell_total_qty,'transtype'=>$row['transtype'],'orderdatetime'=>$row['orderdatetime'],'orderdate'=>$row['orderdate'],'ordertime'=>$row['ordertime'],'broker_recipient_code'=>$row['broker_recipient_code'],'investor_recipient_code'=>$row['investor_recipient_code'],'sms_fee'=>$row['sms_fee']);
				}
			endforeach;	
		}
		
		if (count($buy_orders) > 0)
		{
			foreach($buy_orders as $row):
				if ($row['symbol'] and $row['order_id'] and $row['transtype'] and $row['broker_id'])
				{
					$buy_total_qty += $row['available_qty'];
						
					$buy[] = array('Symbol'=>$row['symbol'],"Qty"=>$row['available_qty'], "order_id"=>$row['order_id'],'price'=>$row['price'],'broker_id'=>$row['broker_id'],'investor_id'=>$row['investor_id'],'total_qty'=>$buy_total_qty,'transtype'=>$row['transtype'],'orderdatetime'=>$row['orderdatetime'],'orderdate'=>$row['orderdate'],'ordertime'=>$row['ordertime'],'broker_recipient_code'=>$row['broker_recipient_code'],'investor_recipient_code'=>$row['investor_recipient_code'],'sms_fee'=>$row['sms_fee']);
				}
			endforeach;	
		}
		
		return array('Symbol'=>$symbol,'Sell'=>$sell,'Buy'=>$buy);
	}	
	
	function GetTradeFees($qty,$price)
	{
		$set=$this->GetTradingParamaters();
		$paystack=$this->GetPaystackSettings();
		
		$sms_fee=0;$transfer_fee=0;
		
		if ($set->brokers_commission) $brokers_commission = $set->brokers_commission;
		if ($set->nse_commission) $nse_commission = $set->nse_commission;	
		if ($set->sms_fee) $sms_fee = floatval($set->sms_fee);	
		
		if ($paystack->transfer_fee) $transfer_fee = $paystack->transfer_fee;
		
		$tradeamount = floatval($qty) * floatval($price);
		$broker_fee = (floatval($brokers_commission)/100) * floatval($tradeamount);
		$nse_fee = (floatval($nse_commission)/100) * floatval($tradeamount);		
		//$transfer_fee=floatval($transfer_fee) * 2;//Buyer and NSE
		
		$total_amount = $tradeamount + $broker_fee + ($nse_fee/2) + ($sms_fee*2) + $transfer_fee;
		
		return array('TotalAmount'=>$total_amount,'TradeAmount'=>$tradeamount,'BrokerFee'=>$broker_fee,'NSEFee'=>$nse_fee,'TransferFee'=>$transfer_fee);
	}
	
	function CheckPaystackBalance()
	{		
		$SecretKey='';
		
		//Get Settings
		$settings=$this->GetParamaters();
		
		if ($settings->runmode) $runmode=trim($settings->runmode);
		
		#Get PayStack Settings
		$PayStackSettings = $this->GetPaystackSettings();
		
		if (strtolower(trim($runmode))=='sandbox')
		{
			if ($PayStackSettings->Sandbox_SecretKey) $SecretKey=trim($PayStackSettings->Sandbox_SecretKey);
		}elseif (strtolower(trim($runmode))=='live')
		{
			if ($PayStackSettings->Live_SecretKey) $SecretKey=trim($PayStackSettings->Live_SecretKey);
		}
		
		$url="https://api.paystack.co/balance";
		
		$result = array();				
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$SecretKey]);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					
		$request = curl_exec($ch);
		
		curl_close($ch);
		
		$result = json_decode($request, true);
		
		$status=false; $message=''; $data=array();
				
		$status = $result['status'];
		$message = $result['message'];
		
		
		if ($status==true)
		{
			$data = $result['data'][0];
			
			return array('Status'=>1,'Currency'=>$data['currency'],'Balance'=>$data['balance']/100);
		}else
		{
			return array('Status'=>'0','message'=>'Balance Retrieval Failed');
		}
	}
	
	function PaystackFetchTransfer($transfer_code)
	{
		$SecretKey='';
		
		//Get Settings
		$settings=$this->GetParamaters();
		
		if ($settings->runmode) $runmode=trim($settings->runmode);
		
		#Get PayStack Settings
		$PayStackSettings = $this->GetPaystackSettings();
		
		if (strtolower(trim($runmode))=='sandbox')
		{
			if ($PayStackSettings->Sandbox_SecretKey) $SecretKey=trim($PayStackSettings->Sandbox_SecretKey);
		}elseif (strtolower(trim($runmode))=='live')
		{
			if ($PayStackSettings->Live_SecretKey) $SecretKey=trim($PayStackSettings->Live_SecretKey);
		}
		
		$url="https://api.paystack.co/transfer/".$transfer_code;	
		
		$result = array();
						
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$SecretKey]);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				
		$request = curl_exec($ch);
		
		$ret=array();
		
		curl_close($ch);
		
		$result = json_decode($request, true);
//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($result,true)); fclose($file);	
//return $result;	
		
		$status = false; $message = ''; $data=array();
		
		$status=$result['status'];
		$message=$result['message'];

//Array ( [status] => 1 [message] => Transfer retrieved [data] => Array ( [amount] => 2491700 [createdAt] => 2020-11-02T11:52:15.000Z [currency] => NGN [domain] => test [failures] => [id] => 38076509 [integration] => 416233 [reason] => Payment For Sales Of 6 Tokens Of AWEBEA At 4500 Per Token. Trade Id Is 20201102-2 [reference] => 6lkhyf76h-lrwf9ufgul [source] => balance [source_details] => [status] => success [titan_code] => [transfer_code] => TRF_3gt9c7si9lw5c3p [transferred_at] => [updatedAt] => 2020-11-02T11:52:15.000Z [recipient] => Array ( [active] => 1 [createdAt] => 2020-07-25T11:41:52.000Z [currency] => NGN [description] => Aniekan Abasi [domain] => test [email] => [id] => 7909143 [integration] => 416233 [metadata] => [name] => Aniekan Abasi [recipient_code] => RCP_do4dza1hkqn27c8 [type] => nuban [updatedAt] => 2020-10-14T19:02:18.000Z [is_deleted] => [details] => Array ( [authorization_code] => [account_number] => 0000000000 [account_name] => [bank_code] => 011 [bank_name] => First Bank of Nigeria ) ) [session] => Array ( [provider] => [id] => ) ) )
				
		if ($status)
		{
			$data=$result['data'];
			$rt=array();
//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($data,true)); fclose($file);				
			
			$amount=''; $currency=''; $reason=''; $reference=''; $transfer_code=''; $data_status='';
			
			$amount = floatval($data['amount'])/100;
			$currency = $data['currency'];
			$reason = $data['reason'];
			$reference = $data['reference'];
			$transfer_code = $data['transfer_code'];
			$data_status = $data['status'];				
			
			$rt = array('Amount'=>$amount,'Currency'=>$currency,'Reason'=>$reason,'Reference'=>$reference,'TransferCode'=>$transfer_code,'Status'=>$data_status);
			
			
			$ret = array('Status'=>1,'data'=>$rt);
		}else
		{
			$ret=array('Status'=>false,'Message'=>$message);
		}

//Array ( [Status] => 1 [data] => Array ( [Amount] => 24917 [Currency] => NGN [Reason] => Payment For Sales Of 6 Tokens Of AWEBEA At 4500 Per Token. Trade Id Is 20201102-2 [Reference] => 6lkhyf76h-lrwf9ufgul [TransferCode] => TRF_3gt9c7si9lw5c3p [Status] => success ) )

		return $ret;
	}
	
	function PaystackSingleTransferFund($recipient)
	{
		$SecretKey='';
		
		//Get Settings
		$settings=$this->GetParamaters();
		
		if ($settings->runmode) $runmode=trim($settings->runmode);
		
		#Get PayStack Settings
		$PayStackSettings = $this->GetPaystackSettings();
		
		if (strtolower(trim($runmode))=='sandbox')
		{
			if ($PayStackSettings->Sandbox_SecretKey) $SecretKey=trim($PayStackSettings->Sandbox_SecretKey);
		}elseif (strtolower(trim($runmode))=='live')
		{
			if ($PayStackSettings->Live_SecretKey) $SecretKey=trim($PayStackSettings->Live_SecretKey);
		}
		
		$url="https://api.paystack.co/transfer";	
		
		$result = array();
						
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Cache-Control: no-cache',));
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$SecretKey]);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$recipient);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				
		$request = curl_exec($ch);
		
		$ret=array();
		
		curl_close($ch);
		
		$result = json_decode($request, true);
		//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($result,true)); fclose($file);		
		
		$status = false; $message = ''; $data=array();
		
		$status=$result['status'];
		$message=$result['message'];
				
		if ($status)
		{
			$data=$result['data'];
			$rt=array();
			
			foreach($data as $res)
			{
				$recipient=''; $amount=''; $transfer_code=''; $currency='';
				
				$recipient = $res['recipient'];
				$amount = $res['amount'];
				$transfer_code = $res['transfer_code'];
				$currency = $res['currency'];
				
				$rt[] = array('Recipient'=>$recipient,'Amount'=>$amount,'TransferCode'=>$transfer_code,'Currency'=>$currency);
			}
			
			$ret = array('Status'=>1,'data'=>$rt);
		}else
		{
			$ret=array('Status'=>false,'Message'=>$message);
		}
		
		return $ret;
	}
	
	function PaystackBulkTransferFunds($recipients)
	{
		$SecretKey='';
		
		//Get Settings
		$settings=$this->GetParamaters();
		
		if ($settings->runmode) $runmode=trim($settings->runmode);
		
		#Get PayStack Settings
		$PayStackSettings = $this->GetPaystackSettings();
		
		if (strtolower(trim($runmode))=='sandbox')
		{
			if ($PayStackSettings->Sandbox_SecretKey) $SecretKey=trim($PayStackSettings->Sandbox_SecretKey);
		}elseif (strtolower(trim($runmode))=='live')
		{
			if ($PayStackSettings->Live_SecretKey) $SecretKey=trim($PayStackSettings->Live_SecretKey);
		}
		
		$url="https://api.paystack.co/transfer/bulk";
	
		
		$result = array();
						
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$SecretKey]);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$recipients);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				
		$request = curl_exec($ch);
		
		$ret=array();
		
		curl_close($ch);
		
		$result = json_decode($request, true);
//$file = fopen('bbb.txt',"w"); fwrite($file,print_r($result,true)); fclose($file);		
		$status = false; $message = ''; $data=array();
		
		$status=$result['status'];
		$message=$result['message'];
				
		if ($status)
		{
			$data=$result['data'];
			$rt=array();
			
			foreach($data as $res)
			{
				$recipient=''; $amount=''; $transfer_code=''; $currency='';
				
				$recipient = $res['recipient'];
				$amount = $res['amount'];
				$transfer_code = $res['transfer_code'];
				$currency = $res['currency'];
				
				$rt[] = array('Recipient'=>$recipient,'Amount'=>$amount,'TransferCode'=>$transfer_code,'Currency'=>$currency);
			}
			
			$ret = array('Status'=>1,'data'=>$rt);
		}else
		{
			$ret=array('Status'=>false,'Message'=>$message);
		}
		
		return $ret;
	}
	
	function DisablePaystackTransferOTP()
	{		
		$SecretKey='';
		
		//Get Settings
		$settings=$this->GetParamaters();
		
		if ($settings->runmode) $runmode=trim($settings->runmode);
		
		#Get PayStack Settings
		$PayStackSettings = $this->GetPaystackSettings();
		
		if (strtolower(trim($runmode))=='sandbox')
		{
			if ($PayStackSettings->Sandbox_SecretKey) $SecretKey=trim($PayStackSettings->Sandbox_SecretKey);
		}elseif (strtolower(trim($runmode))=='live')
		{
			if ($PayStackSettings->Live_SecretKey) $SecretKey=trim($PayStackSettings->Live_SecretKey);
		}
		
		$url="https://api.paystack.co/transfer/disable_otp";
		
		$result = array();				
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$SecretKey]);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					
		$request = curl_exec($ch);
		
		$ret=array();
		
		curl_close($ch);
		
		$result = json_decode($request, true);
		
		$status = false; $message = '';
				
		$status = $result['status'];
		$message = $result['message'];	
		
		//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($result,true)); fclose($file);				
		
		return array('status'=>$status,'message'=>$message);
	}
	
	function ConfirmDisablingOfPaystackOTP($otp)
	{		
		$SecretKey='';
		
		//Get Settings
		$settings=$this->GetParamaters();
		
		if ($settings->runmode) $runmode=trim($settings->runmode);
		
		#Get PayStack Settings
		$PayStackSettings = $this->GetPaystackSettings();
		
		if (strtolower(trim($runmode))=='sandbox')
		{
			if ($PayStackSettings->Sandbox_SecretKey) $SecretKey=trim($PayStackSettings->Sandbox_SecretKey);
		}elseif (strtolower(trim($runmode))=='live')
		{
			if ($PayStackSettings->Live_SecretKey) $SecretKey=trim($PayStackSettings->Live_SecretKey);
		}
		
		$url="https://api.paystack.co/transfer/disable_otp_finalize";
		
		$data=array('otp'=>$otp);
		
		$result = array();				
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$SecretKey]);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					
		$request = curl_exec($ch);
		
		$ret=array();
		
		curl_close($ch);
		
		$result = json_decode($request, true);
		
		$status = false; $message = '';
				
		$status = $result['status'];
		$message = $result['message'];					
		
		return $status;
	}
	
	function EnablePaystackTransferOTP()
	{		
		$SecretKey='';
		
		//Get Settings
		$settings=$this->GetParamaters();
		
		if ($settings->runmode) $runmode=trim($settings->runmode);
		
		#Get PayStack Settings
		$PayStackSettings = $this->GetPaystackSettings();
		
		if (strtolower(trim($runmode))=='sandbox')
		{
			if ($PayStackSettings->Sandbox_SecretKey) $SecretKey=trim($PayStackSettings->Sandbox_SecretKey);
		}elseif (strtolower(trim($runmode))=='live')
		{
			if ($PayStackSettings->Live_SecretKey) $SecretKey=trim($PayStackSettings->Live_SecretKey);
		}
		
		$url="https://api.paystack.co/transfer/enable_otp";
		
		$result = array();				
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$SecretKey]);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					
		$request = curl_exec($ch);
		
		$ret=array();
		
		curl_close($ch);
		
		$result = json_decode($request, true);
		
		$status = false; $message = '';
				
		$status = $result['status'];
		$message = $result['message'];					
		
		//return $status;
		return array('status'=>$status,'message'=>$message);
	}
	
	function CreatePaystackTransferRecipient($account_name,$account_no, $desc,$bank_code,$currency)
	{		
		$SecretKey='';
		
		//Get Settings
		$settings=$this->GetParamaters();
		
		if ($settings->runmode) $runmode=trim($settings->runmode);
		
		#Get PayStack Settings
		$PayStackSettings = $this->GetPaystackSettings();
		
		if (strtolower(trim($runmode))=='sandbox')
		{
			if ($PayStackSettings->Sandbox_SecretKey) $SecretKey=trim($PayStackSettings->Sandbox_SecretKey);
		}elseif (strtolower(trim($runmode))=='live')
		{
			if ($PayStackSettings->Live_SecretKey) $SecretKey=trim($PayStackSettings->Live_SecretKey);
		}
		
		$url="https://api.paystack.co/transferrecipient";
		
		$data=array("type"=>"nuban", "name"=>$account_name, "description"=>$desc, "account_number"=>$account_no,"bank_code"=>$bank_code,"currency"=>$currency);
		
		$result = array();				
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$SecretKey]);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					
		$request = curl_exec($ch);
		
		$ret=array();
		
		curl_close($ch);
		
		$result = json_decode($request, true);
		
		$status = false; $message = ''; $data=array(); $details=array();
		
		$out=$result;
				
		$status = $result['status'];
		$message = $result['message'];		
		if ($result['data']) $data = $result['data'];						
		
		if (($status) and (trim(strtolower($message)) == 'transfer recipient created successfully'))
		{
			$details=$data['details'];
			
			$recipient_code=''; $bank_account_status=''; $bank_name=''; $account_number=''; $createdAt='';
			$updatedAt=''; $bcode='';
									
			$recipient_code = $data['recipient_code'];
			$bank_account_status = $data['active'];
			$createdAt = $data['createdAt'];
			$updatedAt = $data['updatedAt'];
			
			$bank_name = $details['bank_name'];
			$account_number = $details['account_number'];
			$bcode = $details['bank_code'];
			
			
			if ((strtolower(trim($bank_code))==strtolower(trim($bcode))) and (strtolower(trim($account_no))==strtolower(trim($account_number))))
			{
				$ret=array('Status'=>true,'RecipientCode'=>$recipient_code,'BankName'=>$bank_name,'BankAccountStatus'=>$bank_account_status);
			}
		}

		return $ret;
	}
	
	function OpenMarket()
	{		
		$logdate=date('Y-m-d H:i:s');
		$today=date('Y-m-d');
		
		$ret=$this->GetMarketStatus();		
		$sta=$ret['MarketStatus'];		
		
		if (trim(strtoupper($sta)) == 'OPEN')
		{		
			$sql="SELECT * FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".$today."')";
		
			$query=$this->db->query($sql);
			
			if ($query->num_rows() == 0) $this->SetDayPrice();
			
			//Log activity
			$username='System';
			$fullname='Naija Art Mart Core';
			$operation='Opened Market';
			$activity='Market For '.date('d M Y').' Was Opened By System At '.$logdate.'.';
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
			$this->LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
		}	
		
		//Check for expired messages
		$sql="SELECT * FROM messages WHERE (DATE_FORMAT(expiredate,'%Y-%m-%d %H:%i:%s') <= '".$logdate."') AND (expiredate <> '0000-00-00 00:00:00')";
	
		$query=$this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{//Expired
			$rows = $query->result_array();
			
			foreach($rows as $row):
				if ($row['msgid'])
				{
					$this->db->trans_start();
				
					$dat=array('display_status' => '0');							
					$this->db->where(array('msgid'=>$this->db->escape_str($row['msgid'])));
					$this->db->update('messages', $dat);
					
					$this->db->trans_complete();
				}
			endforeach;
		}
	}
	
	function CloseMarket()
	{
		$logdate=date('Y-m-d H:i:s');
		$today=date('Y-m-d');//,strtotime("-1 day")		
		$ret=$this->GetMarketStatus();
		
		$sta=$ret['MarketStatus'];	
		
		//Dev. Code
		//$today='2020-10-12';
		//$logdate='2020-10-12 '.date('H:i:s');

		//return 	$sta;		
		if (trim(strtoupper($sta)) == 'CLOSED')
		{
			//Update historical_prices at the close of day
			$sql="SELECT * FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".$today."')";
		
			$query=$this->db->query($sql);
			
			if ($query->num_rows() > 0)
			{
				//Clear daily_price
				$this->db->trans_start();
				$this->db->delete('historical_prices', array('price_date'=>$today)); 				
				$this->db->trans_complete();				
				
				$prices = $query->result_array();
				
				foreach($prices as $row):
					if ($row['symbol'] and $row['close_price'])
					{						
						//Compute price change at the close of day
						$prev=0;
					
						if (floatval($row['previous_close_price']) > 0) $prev=$row['previous_close_price'];
						
						$change=floatval($row['close_price']) - $prev;
						
						$this->db->trans_start();
					
						$dat=array(
							'symbol' 				=> $this->db->escape_str($row['symbol']),
							'previous_close_price'	=> $this->db->escape_str($row['previous_close_price']),
							'open_price' 			=> $this->db->escape_str($row['open_price']),
							'high_price'			=> $this->db->escape_str($row['high_price']),
							'low_price'				=> $this->db->escape_str($row['low_price']),
							'close_price'			=> $this->db->escape_str($row['close_price']),
							'change'				=> $this->db->escape_str($change),
							'trades'				=> $this->db->escape_str($row['trades']),
							'volume'				=> $this->db->escape_str($row['volume']),
							'trade_value'			=> $this->db->escape_str($row['trade_value']),
							'price_date' 			=> $this->db->escape_str($today),
							'last_updated_date' 	=> $this->db->escape_str($row['last_updated_date'])			
						);
						
						$this->db->insert('historical_prices', $dat);
						
						$this->db->trans_complete();
					}
				endforeach; //End $prices
				
				//Log activity
				$username='System';
				$fullname='Naija Art Mart Core';
				$operation='Closed Market';
				$activity='Market For '.date('d M Y').' Was Closed By System At '.$logdate.'.';
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
				//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
				$this->LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
			}
			
			//Check for expired orders
			$sql="SELECT * FROM orders WHERE (DATE_FORMAT(expirydate,'%Y-%m-%d %H:%i:%s') <= '".$logdate."')";
		
			$query=$this->db->query($sql);
			
			if ($query->num_rows() > 0)
			{//Expired
				$rows = $query->result_array();
				
				foreach($rows as $row):
					if ($row['order_id'])
					{
						$this->db->trans_start();
					
						$dat=array('orderstatus' => 'Expired');							
						$this->db->where(array('order_id'=>$this->db->escape_str($row['order_id'])));
						$this->db->update('orders', $dat);
						
						$this->db->trans_complete();
					}
				endforeach;
			}
			
			//Check for expired messages
			$sql="SELECT * FROM messages WHERE (DATE_FORMAT(expiredate,'%Y-%m-%d %H:%i:%s') <= '".$logdate."') AND (expiredate <> '0000-00-00 00:00:00')";
		
			$query=$this->db->query($sql);
			
			if ($query->num_rows() > 0)
			{//Expired
				$rows = $query->result_array();
				
				foreach($rows as $row):
					if ($row['msgid'])
					{
						$this->db->trans_start();
					
						$dat=array('display_status' => '0');							
						$this->db->where(array('msgid'=>$this->db->escape_str($row['msgid'])));
						$this->db->update('messages', $dat);
						
						$this->db->trans_complete();
					}
				endforeach;
			}
			
			//Check if listing period has ended today
			$sql="SELECT * FROM primary_market WHERE (DATE_FORMAT(listing_ends,'%Y-%m-%d') <= DATE_FORMAT(NOW(),'%Y-%m-%d')) AND (TRIM(listing_status)='Started')";
			
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0 )
			{
				$listings = $query->result_array();
				
				foreach($listings as $row):
					$this->db->trans_start();
					
					$dat=array('listing_status'=>'Ended', 'market_date'=>$today);
					$this->db->where('art_id', $row['art_id']);
					$this->db->update('primary_market', $dat);
					
					$this->db->trans_complete();
				endforeach;
			}
		}
	}
	
	function SetDayPrice()
	{
		$logdate=date('Y-m-d H:i:s');		
		$today=date('Y-m-d');		
		$yesterday=date('Y-m-d',strtotime('yesterday'));		
		
		//Dev Code
		//$logdate=date('Y-m-d H:i:s',strtotime('-2 day'));
		//$today=date('Y-m-d',strtotime("-2 day"));
		//$yesterday=date('Y-m-d',strtotime('-3 day'));
		
		
		//check if yesterday was weekend of public holiday
		$weekend_holiday=$this->IsDateWeekendOrHoliday($yesterday);
	
		if ($weekend_holiday)
		{
			$latestdate=$this->GetLatestDate('historical_prices','price_date');
			
			$sql="SELECT * FROM historical_prices WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".$latestdate."')";
		}else
		{ 
			//Get yesterday's prices from historical_prices table
			$sql="SELECT * FROM historical_prices WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".$yesterday."')";	
		}
		//return 	$today;				
		$query=$this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{
			//Clear daily_price
			$this->db->trans_start();
			$this->db->truncate('daily_price');				
			$this->db->trans_complete();
			
			
			$prices = $query->result_array();
			
			foreach($prices as $row):
				if ($row['symbol'] and $row['close_price'])
				{
					$this->db->trans_start();
				
					$dat=array(
						'symbol' 				=> $this->db->escape_str($row['symbol']),
						'previous_close_price'	=> $this->db->escape_str($row['close_price']),
						'open_price' 			=> $this->db->escape_str($row['close_price']),
						'close_price'			=> $this->db->escape_str($row['close_price']),
						'price_date' 			=> $this->db->escape_str($today),
						'last_updated_date' 	=> $this->db->escape_str($logdate)			
					);
					
					$this->db->insert('daily_price', $dat);
					
					$this->db->trans_complete();
				}
			endforeach; //End $prices	
			
			//Log activity
			$username='System';
			$fullname='Naija Art Mart Core';
			$operation='Set Daily Prices';
			$activity='Daily Prices For '.date('d M Y').' Was Set By System At '.$logdate.'.';
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
			$this->LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
		}
		
		//Check for expired registration
		$sql="SELECT * FROM temp_users WHERE (DATE_FORMAT(expire,'%Y-%m-%d %H:%i') <= DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i'))";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 )
		{
			$where="(DATE_FORMAT(expire,'%Y-%m-%d %H:%i') <= DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i'))";
			
			$this->db->trans_start();									
			$this->db->where($where);
			$this->db->delete('temp_users');					
			$this->db->trans_complete();
		}
		
		//Check in primary_market table if there is a listing that starts today
		$sql="SELECT * FROM primary_market WHERE (DATE_FORMAT(listing_starts,'%Y-%m-%d') <= DATE_FORMAT(NOW(),'%Y-%m-%d')) AND (TRIM(listing_status)='Pending')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 )
		{
			$listings = $query->result_array();
			
			foreach($listings as $row):
				$this->db->trans_start();
				
				$dat=array('listing_status'=>'Started', 'market_date'=>$today);
				$this->db->where('art_id', $row['art_id']);
				$this->db->update('primary_market', $dat);
				
				$this->db->trans_complete();
			endforeach;
		}
		
		
		//Check for end of holding period (create symbol record in daily_price)
		$sql="SELECT * FROM primary_market WHERE (DATE_FORMAT(holding_period_ends,'%Y-%m-%d') < DATE_FORMAT(NOW(),'%Y-%m-%d')) AND (TRIM(listing_status)='Ended')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 )
		{
			$listings = $query->result_array();
			
			foreach($listings as $row):
				if ($row['symbol'] and $row['price'])
				{
					$this->db->trans_start();
				
					$dat=array(
						'symbol' 				=> $this->db->escape_str($row['symbol']),
						'previous_close_price'	=> '0',
						'open_price' 			=> $this->db->escape_str($row['price']),
						'close_price'			=> $this->db->escape_str($row['price']),
						'price_date' 			=> $this->db->escape_str($today),
						'last_updated_date' 	=> $this->db->escape_str($logdate)			
					);
					
					$this->db->insert('daily_price', $dat);
					
					$this->db->trans_complete();
					
					
					//Update listing_status
					/*$this->db->trans_start();
					
					$dat=array('listing_status'=>'Secondary');
					$this->db->where('symbol', $row['symbol']);
					$this->db->update('primary_market', $dat);
					
					$this->db->trans_complete();*/
				}
			endforeach; //End $prices
		}
		
		
		//Check for end of holding period (create symbol record in daily_price)
		$sql="SELECT * FROM primary_market WHERE (DATE_FORMAT(holding_period_ends,'%Y-%m-%d') < DATE_FORMAT(NOW(),'%Y-%m-%d')) AND (TRIM(listing_status)='Ended')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 )
		{
			$listings = $query->result_array();
			
			foreach($listings as $row):
				if ($row['symbol'] and $row['price'])
				{
					$this->db->trans_start();
				
					$dat=array(
						'symbol' 				=> $this->db->escape_str($row['symbol']),
						'previous_close_price'	=> '0',
						'open_price' 			=> $this->db->escape_str($row['price']),
						'close_price'			=> $this->db->escape_str($row['price']),
						'price_date' 			=> $this->db->escape_str($today),
						'last_updated_date' 	=> $this->db->escape_str($logdate)			
					);
					
					$this->db->insert('daily_price', $dat);
					
					$this->db->trans_complete();
					
					
					//Update listing_status
					/*$this->db->trans_start();
					
					$dat=array('listing_status'=>'Secondary');
					$this->db->where('symbol', $row['symbol']);
					$this->db->update('primary_market', $dat);
					
					$this->db->trans_complete();*/
				}
			endforeach; //End $prices
		}
		
		//Check if listing period has ended today
		$sql="SELECT * FROM primary_market WHERE (DATE_FORMAT(listing_ends,'%Y-%m-%d') < DATE_FORMAT(NOW(),'%Y-%m-%d')) AND (TRIM(listing_status)='Started')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 )
		{
			$listings = $query->result_array();
			
			foreach($listings as $row):
				$this->db->trans_start();
				
				$dat=array('listing_status'=>'Ended', 'market_date'=>$today);
				$this->db->where('art_id', $row['art_id']);
				$this->db->update('primary_market', $dat);
				
				$this->db->trans_complete();
				
				//Update issuers_to_pay in readiness for payment
				$sq="SELECT * FROM issuers_to_pay WHERE (issuer_uid=".$row['uid'].") AND (TRIM(symbol)='".$row['symbol']."')";
				
				$qry = $this->db->query($sq);
				
				if ($qry->num_rows() > 0 )
				{
					$this->db->trans_start();
				
					$dat=array('listing_ended'=>1);
					$this->db->where(array('issuer_uid'=>$row['uid'], 'symbol'=>$row['symbol']));
					$this->db->update('issuers_to_pay', $dat);
					
					$this->db->trans_complete();
				}					
				
			endforeach;
		}
		
		return true;
	}
	
	function SaveOrder($order)
	{		
		$this->db->trans_start();
			
		$dat=array(
			'order_id' 					=> $this->db->escape_str($order['order_id']),
			'broker_id' 				=> $this->db->escape_str($order['broker_id']),
			'investor_id' 				=> $this->db->escape_str($order['investor_id']),
			'transtype' 				=> $this->db->escape_str($order['transtype']),
			'symbol' 					=> $this->db->escape_str($order['symbol']),
			'price'						=> $this->db->escape_str($order['price']),
			'qty' 						=> $this->db->escape_str($order['qty']),
			'available_qty' 			=> $this->db->escape_str($order['available_qty']),
			'ordertype'					=> $this->db->escape_str($order['ordertype']),
			'orderdate' 				=> $this->db->escape_str($order['orderdate']),
			'orderstatus'				=> $this->db->escape_str($order['orderstatus']),
			'expirydate' 				=> $this->db->escape_str($order['expirydate']),
			'broker_commission' 		=> $this->db->escape_str($order['broker_commission']),
			'nse_commission' 			=> $this->db->escape_str($order['nse_commission']),
			'transfer_fee' 				=> $this->db->escape_str($order['transfer_fee']),			
			'broker_recipient_code' 	=> $this->db->escape_str($order['broker_recipient_code']),
			'investor_recipient_code'	=> $this->db->escape_str($order['investor_recipient_code']),			
			'total_amount' 				=> $this->db->escape_str($order['total_amount']),
			'trade_amount' 				=> $this->db->escape_str($order['trade_amount']),
			'sms_fee' 					=> $this->db->escape_str($order['sms_fee']),
			'canupdate' 				=> 1,
			'limit_market' 				=> $this->db->escape_str($order['limit_market'])
		);
		
		
		$this->db->insert('orders', $dat);	
			
		$this->db->trans_complete();
		
		$ret=false;
		
		if ($this->db->trans_status() === FALSE)
		{
			$operation='Saved '.$order['transtype'].' Order Failed';
			$activity='Attempted Saving An Order Created For Broker With Id '.$order['broker_id'].' But Failed. Details Of The Order Are: Order Date: '.$order['orderdate'].'; Order Id: '.$order['order_id'].'; Trade Type: '.$order['transtype'].'; Broker Id: '.$order['broker_id'].'; Investor Id: '.$order['investor_id'].'; Asset: '.$order['symbol'].'; Order Quantity: '.$order['qty'].'; Price Per Token: '.$order['price'].'; Order Type: '.$order['ordertype'].'; Order Expiry Date: '.$order['expirydate'].'; Order Status: '.$order['orderstatus'].'; Broker Commission: '.$order['broker_commission'].'; NSE Commission: '.$order['nse_commission'].'; Trade Amount: '.$order['trade_amount'].'; Transfer Fee: '.$order['transfer_fee'].'; Total Amount: '.$order['total_amount'];
		}else
		{		
			//Log activity
			$operation='Saved '.$order['transtype'].' Order';
			$activity='An Order Was Created For Broker With Id '.$order['broker_id'].'. Details Of The Order Are: Order Date: '.$order['orderdate'].'; Order Id: '.$order['order_id'].'; Trade Type: '.$order['transtype'].'; Broker Id: '.$order['broker_id'].'; Investor Id: '.$order['investor_id'].'; Asset: '.$order['symbol'].'; Order Quantity: '.$order['qty'].'; Price Per Token: '.$order['price'].'; Order Type: '.$order['ordertype'].'; Order Expiry Date: '.$order['expirydate'].'; Order Status: '.$order['orderstatus'].'; Broker Commission: '.$order['broker_commission'].'; NSE Commission: '.$order['nse_commission'].'; Trade Amount: '.$order['trade_amount'].'; Transfer Fee: '.$order['transfer_fee'].'; Total Amount: '.$order['total_amount'];
								
			$ret=true;
		}
		
		//Log activity
		$username='System';
		$fullname='Naija Art Mart Core';
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
		$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
		
		return $ret;
	}
	
	function GetMonthEnd($monyear)
	{
		$lastDay = date('t',strtotime($monyear));
		
		$dt=$lastDay.' '.$monyear;
		
		$dt=date('Y-m-d',strtotime($dt));
	
		return $dt;
	}

	function IsValidateSymbol($symbol)
	{
		$ret='';
		
		$sql="SELECT symbol FROM listed_artworks WHERE (TRIM(symbol)='".$this->db->escape_str($symbol)."')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{
			$ret=true;
		}else
		{
			$ret="Asset with symbol '".strtoupper($symbol)."' does not exist in our system.";
		}
	
		return $ret;
	}
	
	function IsValidateBroker($id)
	{
		$ret='';
		
		$sql="SELECT accountstatus FROM brokers WHERE (TRIM(email)='".$this->db->escape_str($id)."') OR (TRIM(broker_id)='".$this->db->escape_str($id)."')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->accountstatus==1)
			{
				$ret=true;
			}else
			{
				$ret="Broker account with id '".$id."' is not active in our system.";
			}
		}else
		{
			$ret="Broker record with id '".$id."' does not exist in our system.";
		}
	
		return $ret;
	}
	
	function IsValidateInvestor($id)
	{
		$ret='';
		
		$sql="SELECT accountstatus FROM investors WHERE (TRIM(email)='".$this->db->escape_str($id)."') OR (TRIM(uid)='".$this->db->escape_str($id)."')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->accountstatus==1)
			{
				$ret=true;
			}else
			{
				$ret="Investor account with email '".$id."' is not active in our system.";
			}
		}else
		{
			$ret="Investor record with email '".$id."' does not exist in our system.";
		}
	
		return $ret;
	}	
	
	function GetId($table,$field)
	{
		if (!$table) return '';
		if (!$field) return '';
		
		$id='';
		
		$sql="SELECT MAX(`".$field."`)+1 AS Id FROM `".$table."`";
			
		$query = $this->db->query($sql);
				
		if ($query->num_rows()> 0)
		{
			$row = $query->row();
		
			if ($row->Id) $id=$row->Id; else $id='1';
		}else
		{
			$id='1';
		}
		
		return $id;
	}
	
	function GenerateTradeId()
	{
		$id='';
		
		$dt=date('Ymd');
		
		$sql="SELECT MAX(SUBSTRING_INDEX(trade_id, '-', -1))+1 AS Id FROM trades WHERE (INSTR(trade_id,".$dt.") > 0);";
		
		$query=$this->db->query($sql);
				
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Id) $id=$dt.'-'.$row->Id; else $id=$dt.'-1';
		}else
		{
			$id=$dt.'-1';
		}
	
		return $id;
	}
	
	function GeneratePrimaryTradeId()
	{
		$id='';
		
		$dt=date('Ymd');
		
		$sql="SELECT MAX(SUBSTRING_INDEX(trade_id, '-', -1))+1 AS Id FROM primary_trades WHERE (INSTR(trade_id,".$dt.") > 0);";
		
		$query=$this->db->query($sql);
				
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			if ($row->Id) $id='P'.$dt.'-'.$row->Id; else $id='P'.$dt.'-1';
		}else
		{
			$id='P'.$dt.'-1';
		}
	
		return $id;
	}
	
	function GetOrderTime()
	{
		list($usec, $sec) = explode(' ', microtime()); //split the microtime on space with two tokens $usec and $sec
		
		$usec = number_format($usec,3);
		
		$usec = str_replace("0.", ".", $usec);     //remove the leading '0.' from usec
		
		$dtm=date('Y-m-d H:i:s', $sec) . $usec;	
		
		return $dtm;
	}
	
	function MarketData()
	{
		$opentime=''; $closetime='';
		
		$par=$this->GetTradingParamaters();
		
		if ($par->market_start_time) $opentime = trim($par->market_start_time);
		if ($par->market_close_time) $closetime = trim($par->market_close_time);		

		$today=date('Y-m-d');
		$yesterday=date('Y-m-d',strtotime('yesterday'));
		
		//Get Market Status
		$rett=$this->GetMarketStatus();		
		$sta=$rett['MarketStatus'];
		$MarketDate=$rett['MarketDate'];
	
		if (trim(strtoupper($sta)) == 'OPEN')
		{
			$sql="SELECT * FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".date('Y-m-d')."') ORDER BY symbol";
		}elseif (trim(strtoupper($sta)) == 'CLOSED')
		{
			$latestdate=$this->GetLatestDate('historical_prices','price_date');
			
			if ($this->IsDateWeekendOrHoliday($today))//Weekend or holiday
			{
				$sql="SELECT * FROM historical_prices WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".$latestdate."') ORDER BY symbol";
			}else
			{
				if (trim(date('H:i:s')) < $opentime)//Before market open - historical_prices
				{
					$sql="SELECT * FROM historical_prices WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".$latestdate."') ORDER BY symbol";
				}elseif (trim(date('H:i:s')) >= $closetime) //After market close - daily_price
				{
					$sql="SELECT * FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".$today."') ORDER BY symbol";
				}
			}
		}			
		
		$ret='';	
		
		$query=$this->db->query($sql);
		
		//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($query->num_rows()."\r\n",true)); fclose($file);
		
		if ($query->num_rows() > 0)
		{
			$prices = $query->result_array();
			
			foreach($prices as $row):
				if ($row['symbol'] and (floatval($row['close_price'])>0))
				{
					$title=$this->GetArtTitle($row['symbol']);
					
					$p='<font title="'.$title.'" color="lightgray">'.$row['symbol'].' ₦'.$row['close_price'].'</font>';					
					
					$prev=0; $dir='';
					
					if (floatval($row['previous_close_price']) > 0) $prev=$row['previous_close_price'];
					
					$change=floatval($row['close_price']) - $prev;
					
					$change_percent= number_format(floatval($change)/floatval($row['previous_close_price']) * 100,2);
					
					if (floatval($change_percent) < 0) //down
					{
						$p .= ' <font color="#FF7D7D">'.$change_percent.'%</font> <i style="color:#FF7D7D;" class="lnr lnr-arrow-down size-12 makebold"></i>';
					}elseif (floatval($change_percent) > 0) //up
					{
						$p .= ' <font color="#94EDB8">'.$change_percent.'%</font> <i class="lnr lnr-arrow-up size-12 makebold" style="color:#94EDB8;"></i>';
					}else //No change
					{
						$p .= ' '.$change_percent.'% <i class="lnr lnr-arrow-left size-12 makebold"></i><i class="lnr lnr-arrow-right makebold size-12" style="margin-left:-10px;"></i>';
					}										
					
					if ($ret=='') $ret=$p; else $ret .='&nbsp;&nbsp;&nbsp;'.$p;
				}
			endforeach; //End $prices
		}
		
		if ($ret<>'') $ret = '<b><font color="darkgray"><b>ASSETS:</b>&nbsp;&nbsp;</font>'.$ret.'</b>';
		
		return $ret;
	}	
	
	function GetPortfolioDetails($symbol,$brokerid,$investor_id)
	{
		$row=NULL;
		
		if (trim($brokerid)=='')
		{
			$sql="SELECT * FROM portfolios WHERE ((TRIM(email)='".$this->db->escape_str($investor_id)."') OR (TRIM(uid)='".$this->db->escape_str($investor_id)."')) AND (TRIM(symbol)='".trim($this->db->escape_str($symbol))."')";	
		}else
		{
			$sql="SELECT * FROM portfolios WHERE ((TRIM(email)='".$this->db->escape_str($investor_id)."') OR (TRIM(uid)='".$this->db->escape_str($investor_id)."')) AND (TRIM(symbol)='".trim($this->db->escape_str($symbol))."') AND (TRIM(broker_id)='".$this->db->escape_str($brokerid)."')";	
		}		
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)  $row = $query->row();		
	
		return $row;
	}
	
	function GetSymbolPrice($symbol)
	{
		$sql="SELECT close_price FROM daily_price WHERE (TRIM(symbol)='".trim($this->db->escape_str($symbol))."') AND (DATE_FORMAT(price_date,'%Y-%m-%d')='".date('Y-m-d')."') ";
		
		$query = $this->db->query($sql);
		
		$price=0;		
	
		if ($query->num_rows() > 0)  //Build Array of results
		{
			$row=$query->row();
			
			if ($row->close_price) $price=trim($row->close_price);
		}else
		{
			$dt=$this->GetLatestDate('historical_prices','price_date');
				
			$sql="SELECT * FROM historical_prices WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".$dt."')";
			
			$query = $this->db->query($sql);
			
			$row=$query->row();
			
			if ($row->close_price) $price=trim($row->close_price);
		}
	
		return $price;
	}
	
	
	function GetLatestDate($table,$datefield)
	{	
		$dt='';
		
		$sql="SELECT MAX(".$datefield.") AS MaxDate FROM ".$table;
				
		$query=$this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{
			$row=$query->row();
			
			if ($row->MaxDate) $dt=$row->MaxDate;
		}

		return $dt;
	}
	
	function IsDateWeekendOrHoliday($dt)
	{
		$public_holiday=false;
		$dayofweek=strtolower(trim(date('l',strtotime($dt))));			
		$holidays=$this->GetHolidays(); //Get holidays
		
		if (count($holidays) > 0)
		{
			foreach($holidays as $dy)
			{
				if (trim($dy['holidaydate']) == trim($dt))
				{
					$public_holiday=true;
					break;
				}
			}
		}
		
		if (($dayofweek=='sunday') or ($dayofweek=='saturday') or ($public_holiday))
		{
			return true;
		}else
		{
			return false;
		}
	}
	
	function GetHolidays()
	{
		$ret=array();
		
		$sql = "SELECT * FROM public_holidays WHERE (DATE_FORMAT(holidaydate,'%Y-%m-%d') >= '".date('Y-m-d')."')";

		$query = $this->db->query($sql);
					
		if ($query->num_rows() > 0 )
		{
			$holidays = $query->result_array();
			
			foreach($holidays as $row):
				if ($row['holiday'] and $row['holidaydate'])
				{
					$ret[]=array('holiday'=>$row['holiday'],'holidaydate'=>$row['holidaydate']);
				}
			endforeach;
		}
		
		return $ret;
	}
	
	function GetMarketStatus()
	{
		$today=date('Y-m-d');
		$sta=''; $operation=''; $activity='';
		$now=date('H:i:s');
		$start_time='';
		$close_time='';
		$dayofweek=strtolower(trim(date('l')));
		
		$par=$this->GetTradingParamaters();
		
		if ($par->market_start_time) $start_time=trim($par->market_start_time);
		if ($par->market_close_time) $close_time=trim($par->market_close_time);
		
		//Get holidays
		$holidays=$this->GetHolidays(); $public_holiday=false;
	
		if (count($holidays) > 0)
		{
			foreach($holidays as $dy)
			{
				if (trim($dy['holidaydate']) == trim($today))
				{
					$public_holiday=true;
					break;
				}
			}
		}
		
		if (($dayofweek=='sunday') or ($dayofweek=='saturday') or ($public_holiday))
		{
			$sta='CLOSED';
		}else
		{
			if (strtotime($now) < strtotime($start_time))
			{
				$sta='CLOSED';
			}elseif (strtotime($now) >= strtotime($close_time))
			{
				$sta="CLOSED";
			}else
			{
				$sta='OPEN';
			}
		}
		
		//Update market_status
		$sql = "SELECT * FROM market_status";

		$query = $this->db->query($sql);
					
		if ($query->num_rows() == 0 )
		{
			$this->db->trans_start();			
			
			$dat=array('market_date'=>date('Y-m-d'), 'market_status'=>$this->db->escape_str($sta));
			$this->db->insert('market_status', $dat);			
			
			$this->db->trans_complete();
			
			$operation='Set Market Status';
			$activity='Market Status For '.date('d M Y').' Was Set By System.';
		}else
		{
			$row = $query->row();
		
			$msta='';
			
			if ($row->market_status) $msta=strtolower(trim($row->market_status));
			
			if (trim(strtolower($sta)) <> $msta)
			{
				$this->db->trans_start();
				
				$dat=array('market_date'=>date('Y-m-d'), 'market_status'=>$this->db->escape_str($sta));			
				$this->db->update('market_status', $dat);			
				
				$this->db->trans_complete();
				
				$operation='Updated Market Status';
				$activity='Market Status For '.date('d M Y').' Was Updated By System.';
			}			
		}
		
		
		if ((trim($operation) <> '') and (trim($activity) <> ''))
		{
			//Log activity
			$username='System';
			$fullname='Naija Art Mart Core';			
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
			$this->LogTradeActivity(date('Y-m-d H:i:s'),$activity,$username,$fullname,$operation,$remote_ip,$remote_host);	
		}
		
		$_SESSION['MarketStatus']=$sta;		
	
		return array('MarketStatus'=>$sta,'MarketDate'=>$today);
	}
	
	function LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
	{		
		$this->db->trans_start();
				
		$dat=array(
			'logdate' 			=> $this->db->escape_str($logdate),
			'activity' 			=> $this->db->escape_str($activity),
			'username' 			=> $this->db->escape_str($username),
			'fullname' 			=> $this->db->escape_str($fullname),
			'operation' 		=> $this->db->escape_str($operation),
			'remote_ip'			=> $this->db->escape_str($ip),
			'remote_host' 		=> $this->db->escape_str($host)				
		);
		
		$this->db->insert('trade_log', $dat);	
			
		$this->db->trans_complete();
		
		//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($dat,true)); fclose($file);
	}	
	
	function GetLogUsers()
	{
		$sql = "SELECT DISTINCT Username,Name FROM loginfo ORDER BY Name";		
		
		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	function UpdateCurrentPrice($email)
	{
		$sql="SELECT * FROM daily_price";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 )
		{
			foreach ($query->result() as $row)
			{
				$pr=0;
				
				if (floatval($row->low_price) > 0) $pr=$row->low_price;
				
				$sq = "SELECT * FROM portfolios WHERE (TRIM(email)='".$this->db->escape_str($email)."') AND (TRIM(symbol)='".$this->db->escape_str($row->symbol)."')";
		
				$qry = $this->db->query($sq);
				
				if ($qry->num_rows() > 0)
				{										
					$dat=array(
						'currentprice' => $this->db->escape_str($row->low_price),
						'date_updated' => date('Y-m-d H:i:s')
					);
					
					$this->db->trans_start();
					$this->db->where(array('email' => $email,'symbol'=>$row->symbol));
					$this->db->update('portfolios', $dat);			
					$this->db->trans_complete();
				}
			}
		}
		
		return true;
	}
	
	function GetArtTitle($symbol)
	{
		$sql="SELECT title FROM art_works WHERE (TRIM(symbol)='".$this->db->escape_str($symbol)."')";
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		$t='';
		
		if ($row->title) $t=trim($row->title);
	
		return $t;
	}

	function GetArtID($symbol)
	{
		$sql="SELECT art_id FROM art_works WHERE (TRIM(symbol)='".$this->db->escape_str($symbol)."')";
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		$t='';
		
		if ($row->art_id) $t=trim($row->art_id);
	
		return $t;
	}
	
	function GetSymbolPortfolioIdAndName($email,$symbol)
	{
		$sql="SELECT DISTINCT(portfolioId) AS portfolioId,portfolioname FROM portfolios WHERE (TRIM(email)='".$this->db->escape_str($email)."') AND (TRIM(symbol)='".$this->db->escape_str($symbol)."')";
	
		$query = $this->db->query($sql);
		
		$ret='';
		
		if ($query->num_rows() > 0 )
		{
			$row = $query->row();
			
			$pid=''; $nm='';
			
			if ($row->portfolioId) $pid=trim($row->portfolioId);
			if ($row->portfolioname) $nm=trim($row->portfolioname);	
			
			$ret=array('portfolioId'=>$pid,'portfolioname'=>$nm);
		}else
		{
			$ret=NULL;
		}
		
		
	
		return $ret;
	}
	
	function GetSymbolPortfolioId($email,$symbol)
	{
		$sql="SELECT portfolioId FROM portfolios WHERE (TRIM(email)='".$this->db->escape_str($email)."') AND (TRIM(symbol)='".$this->db->escape_str($symbol)."')";
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		$id='';
		
		if ($row->portfolioId) $id=trim($row->portfolioId);
	
		return $id;
	}
	
	function GetPortfolioID()
	{
		$sql="SELECT MAX(portfolioId) AS portfolioId FROM portfolios";
			
		$query = $this->db->query($sql);
				
		if ( $query->num_rows() > 0 )  //Build Array of results
		{
			$row = $query->row();
			
			if (isset($row))
			{
				$i=$row->portfolioId + 1;
								
				return $i;
			}else
			{
				return 1;
			}
		}else
		{
			return 1;
		}	
	}
	
	function GetWalletBalance($email)
	{
		$sql="SELECT balance FROM wallets WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		$amt='0';
		
		if ($row->balance) $amt=trim($row->balance);
	
		return $amt;
	}
	
	function GetPaystackSettings()
	{
		$sql="SELECT * FROM paystack_settings";
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
	
		return $row;
	}
	
	function GetInvestorDetails($id)
	{
		if (is_numeric($id))
		{
			$sql="SELECT * FROM investors WHERE (TRIM(uid)=".$this->db->escape_str($id).")";	
		}else
		{
			$sql="SELECT * FROM investors WHERE (TRIM(email)='".$this->db->escape_str($id)."')";
		}
		
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
	
		return $row;
	}
		
	function GetBrokerInvestors($id)
	{
		$sql="SELECT * FROM investors WHERE (TRIM(broker_id)='".$this->db->escape_str($id)."')";
		
		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	function GetIssuerDetails($id)
	{
		if (is_numeric($id))
		{
			$sql="SELECT * FROM issuers WHERE (TRIM(uid)=".$this->db->escape_str($id).")";	
		}else
		{
			$sql="SELECT * FROM issuers WHERE (TRIM(email)='".$this->db->escape_str($id)."')";
		}		
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
	
		return $row;
	}
	
	function GetUsers($usertype='')
	{
		if (is_array($usertype))
		{
			$lst='';
			
			foreach($usertype as $a)
			{
				if (trim($lst)=='') $lst="'".$a."'"; else $lst .= ",'".$a."'";
			}
			
			$sql="SELECT * FROM userinfo WHERE TRIM(usertype) IN (".$lst.")";	
		}else
		{
			$sql="SELECT * FROM userinfo ORDER BY fullname";
		}		
		
		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	function GetBrokerDetails($id)
	{
		$sql="SELECT * FROM brokers WHERE (TRIM(broker_id)='".$this->db->escape_str($id)."') OR (TRIM(email)='".$this->db->escape_str($id)."')";
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
	
		return $row;
	}
		
	function getDatesFromRange($start, $end, $format = 'Y-m-d')
	{ 
		  
		// Declare an empty array 
		$array = array(); 
		  
		// Variable that store the date interval of period 1 day 
		$interval = new DateInterval('P1D'); 
	  
		$realEnd = new DateTime($end); 
		$realEnd->add($interval); 
	  
		$period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
	  
		// Use loop to store date into array 
		foreach($period as $date) {                  
			$array[] = $date->format($format);  
		}
		 
		return $array; // Return the array elements
	}	
	
	function GetDurationFromSeconds($duration)
	{
		 $du='';
	
		$h=gmdate("H", $duration); $m=gmdate("i", $duration); $s=gmdate("s", $duration);
		
		if (intval($h) >0 ) $du=intval($h).'hr';
		
		if (intval($m) >0 )
		{
			if ($du=='') $du=intval($m).'min'; else $du .= ' '.intval($m).'min';
		}
		
		if (intval($s) >0 )
		{
			if ($du=='') $du=intval($s).'sec'; else $du .= ' '.intval($s).'sec';
		}
		
		return $du;
	}

	function ResizeImageByHeight($img,$newHeight)#Width In Pixels
	{
		//Resize very large images to 200
		 $image_info = getimagesize($img);//index 0 is width, index 1 is heigth
						  
		 $width=$image_info[0];
		 $height=$image_info[1];
		
		//Determine is image is Portrait or Landscape
		 if ($height > $newHeight)//Resize
		 { 
			$imgH = new SimpleImage();
			$imgH->load($img);	
					
			$imgH->resizeToHeight($newHeight);
			$imgH->save($img);
		}
	}
	
	function ResizeImage($img,$newWidth)#Width In Pixels
	{
		//Resize very large images to 200
		 $image_info = getimagesize($img);//index 0 is width, index 1 is heigth
						  
		 $width=$image_info[0];
		 $height=$image_info[1];
		
		//Determine is image is Portrait or Landscape
		 if ($width > $newWidth)//Resize
		 { 
			$imgW = new SimpleImage();
			$imgW->load($img);	
					
			$imgW->resizeToWidth($newWidth);
			$imgW->save($img);
		}
	}
		
	function GetPermissions($email)
	{
		$sql="SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		return $row;
	}
	
	function GetParamaters()
	{
		$sql="SELECT * FROM settings;";
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		return $row;
	}	
	
	function GetTradingParamaters()
	{
		$sql="SELECT * FROM trading_parameters;";
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		return $row;
	}	
	
	function GetUserDetails($email)
	{
		$sql="SELECT * FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
			
		return $row;
	}
		
	function GetUserName($email)
	{
		$sql="SELECT fullname FROM userinfo WHERE (TRIM(email)='".$this->db->escape_str($email)."')";
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		$nm='';
		
		if ($row->fullname) $nm=trim($row->fullname);
	
		return $nm;
	}	
	
	function ShortenUrl($longurl)
	{
		$key='5c55889bc9c0763e60d48fbeb1d66b4395503';
		$url='https://cutt.ly/api/api.php?key='.$key.'&short='.urlencode($longurl);
		
		$response = file_get_contents($url);
		
		$json = json_decode($response, true);
		
		$json=$json['url'];
		
		if ($json['status']==7) 
		{
			return $json['shortLink'];
		}else
		{
			return $longurl;
		}
	}
	
	// Encrypt
	function EncryptText($data) 
	{
		$key = '$BSGK4MtR7-XUtE?N8JvjC!2qV=PzMT!MH866mm42@2WZtRGFq2Xz5ZW';
		$salt = 'cH!swe!retReGu7W6bEDRup7usuDUh9THeD2CHeGE*ewr4n39=E@rAsp7c-Ph@pH';
		$iv_size = openssl_cipher_iv_length( "AES-256-CBC" );
		$hash = hash( 'sha256', $salt . $key . $salt );
		$iv = substr( $hash, strlen( $hash ) - $iv_size );
		$key = substr( $hash, 0, 32 );
		$encrypted = base64_encode( openssl_encrypt( $data, "AES-256-CBC", $key, OPENSSL_RAW_DATA, $iv ) );		
	
		return $encrypted;
	}		
	
	// Decrypt
	function DecryptText($data)
	{
		$key = '$BSGK4MtR7-XUtE?N8JvjC!2qV=PzMT!MH866mm42@2WZtRGFq2Xz5ZW';
		
		$salt = 'cH!swe!retReGu7W6bEDRup7usuDUh9THeD2CHeGE*ewr4n39=E@rAsp7c-Ph@pH';
		$iv_size = openssl_cipher_iv_length( "AES-256-CBC" );
		$hash = hash( 'sha256', $salt . $key . $salt );
		$iv = substr( $hash, strlen( $hash ) - $iv_size );
		$key = substr( $hash, 0, 32 );
		$decrypted = openssl_decrypt( base64_decode( $data ), "AES-256-CBC", $key, OPENSSL_RAW_DATA, $iv );
		$decrypted = rtrim( $decrypted, "\0" );
	
		return $decrypted;
	}
	
	function GSMPhoneNo($phone)
	{
		if ($phone)
		{
			$phone=trim($phone);
			
			$new='';
			
			$first=$phone[0];
			$code=trim(substr($phone,0,4));
			
			if (($first=='+') && ($code=='+234'))
			{
				$new=$phone;
			}elseif ($first=='0')
			{
				$new='+234'.substr($phone,1);
			}elseif (($first=='2') && (trim(substr($phone,0,3))=='234'))
			{
				$new="+".$phone;
			}
			
			return $new;
		}else
		{
			return '';
		}
	}	
		
	function CleanPhoneNo($phone)
	{
		if ($phone)
		{
			$new='';
			
			$first=$phone[0];
			$code=trim(substr($phone,0,4));
			
			if (($first=='+') && ($code=='+234'))
			{
				$new=str_replace('+','',$phone);
			}elseif ($first=='0')
			{
				$new='234'.substr($phone,1);
			}elseif (($first=='2') && (trim(substr($phone,0,3))=='234'))
			{
				$new=$phone;
			}
			
			//$ret=$first.' : '.$code.' => '.$new;
			
			return $new;
		}else
		{
			return '';
		}
	}
	
	function RegularPhoneNo($phone)
	{
		if ($phone)
		{
			$new='';
			
			$first=$phone[0];
			$code=trim(substr($phone,0,4));
			
			if (($first=='+') && ($code=='+234'))
			{
				$new=str_replace('+234','0',$phone);
			}elseif ($first=='0')
			{
				$new=$phone;
			}elseif (($first=='2') && (trim(substr($phone,0,3))=='234'))
			{
				$new='0'.substr($phone,3);
			}
			
			return $new;
		}else
		{
			return '';
		}
	}

	function ConvertToHoursAndMins($time)
	{
		if ($time < 1) return;
	
		$hours = floor($time / 60);
		$minutes = ($time % 60);
		
		$h=''; $m=''; $tm='';
		
		if ($hours > 0)
		{
			if ($hours == 1) $h=$hours.'hr'; else $h=$hours.'hrs';
		}
		
		if ($minutes > 0)
		{
			if ($minutes == 1) $m=$minutes.'min'; else $m=$minutes.'mins';
		}
		
		if (trim($h) <> '') $tm=$h;
		
		if (trim($m) <> '')
		{
			if (trim($tm) <> '') $tm .= ' '.$m; else $tm=$m;
		}
		
		return $tm;
	}
	
	function GetTransactionId()
	{
		$m=microtime();
		$e=explode(' ',$m);
		$e[0]=str_replace('0.','',$e[0]);	
		$tid=intval($e[0]) + intval($e[1]);
		
		return $tid;
	}

	function BulkSMSBalance()
	{
		$url = "https://cloud.nuobjects.com/api/credit/?user=nsikakj&pass=homelottery12345";	

		$ch = curl_init();	
		
		curl_setopt_array($ch, array(
			CURLOPT_URL 			=> $url,
			CURLOPT_RETURNTRANSFER 	=> true,
			CURLOPT_SSL_VERIFYPEER 	=> false,
			CURLOPT_SSL_VERIFYHOST 	=> false
		));	
		
		$req = curl_exec($ch);
		
		curl_close($ch);
		
		return $req;
	}
	
	function SendBulkSMS($to,$msg)
	{
		$row=$this->GetTradingParamaters();
		$sms_fee=0;
		if ($row->sms_fee) $sms_fee=$row->sms_fee;
		
		$bal=$this->BulkSMSBalance();
		
		if (floatval($bal) < ($sms_fee * 50))
		{
			//Send system message to Admin
			$msgtype='system,email';						
			$header='Bulk SMS Balance Very Low';
			$groups='';
			$emails='admin@naijaartmart.com';
			$phones='';
			$category='Message';
			$display_status=1;
			$sender='System';						
			
			$details="Current Naija Art Mart bulk SMS balance is NGN".number_format($bal,2).". Your need to credit your bulk SMS wallet as soon as possible.";
			
			$res = $this->SendMessage($header, $details, $msgtype, $groups, $emails, $phones, $category, $display_status, $sender, $expiredate);
			
			
			//Send EMAIL to Issuer
			$from='admin@naijaartmart.com';
			$to='admin@naijaartmart.com';
			$subject=$header;
			$Cc='idongesit_a@yahoo.com';
							
			$img=base_url()."images/logo.png";
								
			//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
		
			$message = '
				<html>
				<head>
				<meta charset="utf-8">
				<title>Naija Art Mart | Recharge Bulk SMS Account</title>
				</head>
				<body>								
													
						Dear Admin,<br><br>
						
						<b><u>ATTENTION:</u></b>
						<br><br>Current Naija Art Mart bulk SMS balance is <b>&#8358;'.number_format($bal,2).'</b>. You need to credit your bulk SMS wallet as soon as possible.
				</body>
				</html>';
				
			$altmessage = 'Dear Admin,
						
				ATTENTION:
				Current Naija Art Mart bulk SMS balance is NGN'.number_format($bal,2).'. You need to credit your bulk SMS wallet as soon as possible.';
			
			$v=$this->SendEmail($from,$to,$subject,$Cc,$message,$altmessage,'Admin');
			
			return false;
		}
		
		$from='Naija Art Mart';
		$url="http://cloud.nuobjects.com/api/send";
		$user='nsikakj';
		$pass='homelottery12345';
		
		$ex=explode(",",$to);
		
		$to='';
		
		for($i=0; $i<count($ex); $i++)
		{
			$ph=trim($ex[$i]);
			$ph=$this->CleanPhoneNo($ph);
			
			if ($ph)
			{
				if ($to == '') $to=$ph; else $to .= ','.$ph;
			}
		}
		
		if ($to && $msg)
		{
			
			$curlPost = 'user='.$user.'&pass='.$pass.'&to='.$to.'&from='.$from.'&msg='.$msg;
			#http://cloud.nuobjects.com/api/send/? user=demo&pass=demopass&to=2348030000000&from=Testing&msg=Testing
			#?username=xxx&password=yyy&sender=@@sender@@&recipient=@@recipient@@&message=@@message@@
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
			
			// response of the POST request
			$response = curl_exec($ch);
			curl_close($ch);
							
			return $response;	#write out the response	
		}else
		{
			return 'Invalid Message Parameters';
		}

	}
	
	function GenerateCode($length=6)
	{
		return strtoupper(substr(md5(uniqid(mt_rand(), true)) , 0, $length));
	}
	
	function crypto_rand_secure($min, $max,$Id) 
	{
		$range = $max - $min;
		if ($range < 0) return $min; // not so random...
		$log = log($range, 2);
		$bytes = (int) ($log / 8) + 1; // length in bytes
		$bits = (int) $log + 1; // length in bits
		$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
		
		do {
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes))); #md5(uniqid($Id, true));
			$rnd = $rnd & $filter; // discard irrelevant bits
		} while ($rnd >= $range);
		
		return $min + $rnd;
	}
	
	function GetTransactionCode($length,$Id)
	{
		$length = !empty($length)? $length: 24;
		$token = "";
		
		$codeAlphabet = "ABCDEFGHJKLMNPQRSTUVWXYZ";
		$codeAlphabet.= "abcdefghjkmnpqrstuvwxyz";
		$codeAlphabet.= "23456789";

		for($i=0;$i<$length;$i++){
			$token .= $codeAlphabet[$this->crypto_rand_secure(0,strlen($codeAlphabet),$Id)];
		}
		
		return $token;
	}	
				
	function SendRegistrationEmail($from,$to,$subject,$Cc,$name,$activationurl)
	{
		$img=base_url()."images/logo.png";
		
		$message = '
			<html>
			<head>
			<meta charset="utf-8">
			<title>Naija Art Mart Registration</title>
			</head>
			<body>
					<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
					
					Dear User,<br><br></p>
					
					<p>Thank you for registering on Naija Art Mart.</p>
										
					<p>For full access to your account on the Naija Art Mart website, you will need to activate your account. To do so, click on the link below or copy and paste it in your browser (for security purpose, this is a one time action):</p>
										
					<p><a href="'.$activationurl.'">Click Here To Activate Your Naija Art Mart Account<a/></p>
																										
					<p>Best Regards</p>
					<p>
						Naija Art Mart Team
					</p>
			</body>
			</html>';
			
			$altmessage = '
			Dear User,
					
			Thank you for registering on Naija Art Mart.
					
			Your account username is your email address: '.$to.'
					
			For full access to your account on the Naija Art Mart website, you will need to activate your account. To do so, click on the link below or copy and paste it in your browser (for security purpose, this is a one time action):

										
			'.$activationurl.'
																										
			Best Regards
			
			Naija Art Mart Team';
			
		


		//Create a new PHPMailer instance
		$mail = new PHPMailer();#Create a new PHPMailer instance
		$mail->CharSet = "UTF-8";
		$mail->isSMTP();#/Tell PHPMailer to use SMTP
		$mail->SMTPDebug = 0;
		$mail->SMTPKeepAlive = true;   
		$mail->Mailer = “smtp”; // don't change the quotes!
		$mail->Debugoutput = 'html';//Ask for HTML-friendly debug output		
		$mail->Host = 'smtp-relay.sendinblue.com';//Set the hostname of the mail server	- smtp-relay.sendinblue.com
		$mail->Port = 587;//Set the SMTP port number - likely to be 25, 465 or 587	- 25, 2525, or 587
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;//Whether to use SMTP authentication		
		$mail->Username = "idongesit_a@yahoo.com";//Username to use for SMTP authentication		
		$mail->Password = "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";
		$mail->setFrom($from, 'Naija Art Mart');//Set who the message is to be sent from		
		$mail->addReplyTo($from, 'Naija Art Mart');//Set an alternative reply-to address
		$mail->addAddress($to);//Set who the message is to be sent to
		
		$mail->AltBody = $altmessage;
		
		if ($Cc) $mail->addBCC($Cc);
		
		$mail->Subject = $subject;//Set the subject line
		$mail->isHTML(true);/*Set email format to HTML (default = true)*/
		
		$mail->Body  = $message;
		$mail->msgHTML($message);
		
		//send the message, check for errors
		if (!$mail->send()) {
			$file = fopen('emailerror.txt',"a"); fwrite($file,"\r\nMailer Error: " . $mail->ErrorInfo); fclose($file);
			
			return "MAILER ERROR: ". $mail->ErrorInfo;
		} else {
			return 'OK';
		}
	}	
	
	
	function SendBlueMail($from,$to,$subject,$Cc,$message,$altmessage,$name)
	{
		require_once('sendemail/autoload.php');
		
		$config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');
		$apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(new GuzzleHttp\Client(),$config);
		$sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail();		
					
		$sendSmtpEmail['subject'] = $subject;
		$sendSmtpEmail['htmlContent'] = $message;
		$sendSmtpEmail['textContent'] = $altmessage;
		$sendSmtpEmail['sender'] = array('name' => 'Naija Art Mart', 'email' => $from);
		$sendSmtpEmail['to'] = array(array('email' => $to, 'name' => $name));
		
		/*$sendSmtpEmail['cc'] = array(
			array('email' => $Cc, 'name' => 'Copied Name')
		);*/
		
		if (!empty($Cc))
		{
			$sendSmtpEmail['bcc'] = array(
				array('email' => $Cc, 'name' => $Cc)
				);
		}
		
		//$sendSmtpEmail['replyTo'] = array('email' => $from, 'name' => 'Nsikak John');
		//$sendSmtpEmail['headers'] = array('Some-Custom-Name' => 'unique-id-1234');
		//$sendSmtpEmail['params'] = array('parameter' => 'My param value', 'subject' => 'New Subject');
		
		try
		{
			$result = $apiInstance->sendTransacEmail($sendSmtpEmail);
			//Array([*container] => Array ([messageId] => <202106291236.47259119834@smtp-relay.mailin.fr> ))			
			$res=(array)$result;
			
			$ret='';
			
			foreach($res as $v)
			{
				if (is_array($v))
				{
					if (!empty($v['messageId'])) $ret = $v['messageId'];
				}
				
			}
			
			$retvalue='';
			
			if (!empty($ret))
			{
				//echo 'OK => '.$ret;
				$retvalue='OK';
			}else
			{
				$retvalue='FAILED';
			}
			
			return $retvalue;
		}catch (Exception $e)
		{
			//echo 'SEND EMAIL ERROR: ', $e->getMessage(), PHP_EOL;
			$file = fopen('emailerror.txt',"a"); fwrite($file,"\r\nMailer Error: " . $e->getMessage()); fclose($file);
			
			return 'FAILED';
		}
	}
	
	
	function SendEmail($from,$to,$subject,$Cc,$message,$altmessage,$name)
	{
		//$from='support@xrosspay.com';
					
		//$img=base_url()."images/emaillogo.png";
		$img="https://imgur.com/idvcINL";
								
		$mail = new PHPMailer();#Create a new PHPMailer instance
		$mail->CharSet = "UTF-8";
		$mail->isSMTP();#/Tell PHPMailer to use SMTP
		$mail->SMTPDebug = 0;
		$mail->SMTPKeepAlive = true;   
		$mail->Mailer = “smtp”; // don't change the quotes!
		$mail->Debugoutput = 'html';//Ask for HTML-friendly debug output		
		$mail->Host = 'smtp-relay.sendinblue.com';//Set the hostname of the mail server	- smtp-relay.sendinblue.com
		$mail->Port = 587;//Set the SMTP port number - likely to be 25, 465 or 587	- 25, 2525, or 587
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;//Whether to use SMTP authentication		
		$mail->Username = "idongesit_a@yahoo.com";//Username to use for SMTP authentication		
		$mail->Password = "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";
		$mail->setFrom($from, 'Naija Art Mart');//Set who the message is to be sent from		
		$mail->addReplyTo($from, 'Naija Art Mart');//Set an alternative reply-to address		
		
		$em=explode(',',$to);
		$em1=explode(';',$to);
		
		$tem='';
		
		if (count($em)>1)
		{
			foreach($em as $v)
			{
				$mail->addAddress($v);//Set who the message is to be sent to		
			}
		}elseif (count($em1)>1)
		{
			foreach($em1 as $v)
			{
				$mail->addAddress($v);//Set who the message is to be sent to		
			}
		}else
		{
			$mail->addAddress($to,$name);//Set who the message is to be sent to	
		}		
		
		$mail->Subject = $subject;//Set the subject line
		$mail->isHTML(true);/*Set email format to HTML (default = true)*/
		
		if ($Cc)
		{
			#$mail->addBCC($Cc);
			
			$em=explode(',',$Cc);
			$em1=explode(';',$Cc);
			
			$tem='';
			
			if (count($em)>1)
			{
				foreach($em as $v)
				{
					$mail->addBCC($v);//Set who the message is to be sent to		
				}
			}elseif (count($em1)>1)
			{
				foreach($em1 as $v)
				{
					$mail->addBCC($v);//Set who the message is to be sent to		
				}
			}else
			{
				$mail->addBCC($Cc);//Set who the message is to be sent to	
			}
		}
					
		//Attach an image file
		#$mail->AddEmbeddedImage("emaillogo.png", "ms-attach", "emaillogo.png");
		$mail->AddEmbeddedImage($img, "logo", 'logo.png');
		
		
		// addEmbeddedImage ($path,$cid, $name = '', $encoding = 'base64', $type = '', $disposition = 'inline' )		
		
		$mail->AltBody = $altmessage;
		//$mail->msgHTML($message,'','');
		$mail->Body=$message;
		
		//$mail->addEmbeddedImage($img, 'logo');
		
		
		//send the message, check for errors
		if (!$mail->send()) {
			$file = fopen('emailerror.txt',"a"); fwrite($file,"\r\nMailer Error: " . $mail->ErrorInfo); fclose($file);
			
			return "MAILER ERROR: ". $mail->ErrorInfo;
			
		} else 
		{
			return 'OK';
		}
	}
	
	function GetUserID()
	{
		$sql="SELECT MAX(uid) AS uid FROM investors";
			
		$query = $this->db->query($sql);
				
		if ( $query->num_rows() > 0 )  //Build Array of results
		{
			$row = $query->row();
			
			if (isset($row))
			{
				$i=$row->uid + 1;
								
				return $i;
			}else
			{
				return 1;
			}
		}else
		{
			return 1;
		}	
	}
	
	function GetUserInfo() 
	{
		$output=array();
		
		$output = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
		
		return $output;
	}
	
	function KillSleepingConnections()
	{		
		$iMinSecondsToExpire = 10;
		
        $strSQL= "SHOW PROCESSLIST;";
				
		$query = $this->db->query("SHOW PROCESSLIST;");
		
		$arr=array();
				
		foreach ($query->result() as $row)
		{
			$iTime=''; $strState=''; $iPID='';
			#echo $row->title;
			if ($row->Id) $iPID=$row->Id;
			if ($row->Command) $strState=$row->Command;
			if ($row->Time) $iTime=$row->Time;
			
			if ((strtolower(trim($strState)) == "sleep") && ($iTime >= $iMinSecondsToExpire) && ($iPID > 0))
			{
			   $arr[]=$iPID;#This connection is sitting around doing nothing. Kill it.
			}
		}
		
		if (count($arr)>0)
		{
			foreach($arr as $p):
				if ($p)
				{
			 		$strSQL = "KILL ".$p.";";
				
					$query = $this->db->query($strSQL);	
				}
			endforeach;
		}
	}
	
	function LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
	{
		$this->db->trans_start();
				
		#LoginDate,`Name`,Activity,ActionDate,Username,LogOutDate,Operation,LogID
		
		if (trim(strtoupper($Operation))=='LOGOUT') $logoutdate=date('Y-m-d H:i:s'); else $logoutdate='';
		
		if (trim(strtoupper($Operation))=='LOGOUT')
		{
			$logdate=date('Y-m-d H:i:s');
			
			$data = array(
				'Activity'      => $this->db->escape_str($Activity),
				'ActionDate'	=> $logdate,
				'LogOutDate' 	=> $logdate,
				'Operation' 	=> $Operation,
				'remote_ip'		=> $ip,
				'remote_host'	=> $host
			);

			$this->db->where('LogID', $LogID);
			$this->db->update('loginfo', $data); 
		}else
		{
			if (trim(strtoupper($Operation))=='LOGIN')
			{
				$this->db->insert('loginfo', array(
					'LoginDate' 	=> $logdate,
					'Name' 			=> $this->db->escape_str($Name),
					'Activity'      => $this->db->escape_str($Activity),
					'ActionDate'	=> $logdate,
					'Username' 		=> $this->db->escape_str($Username),
					'Operation' 	=> $Operation,
					'LogID'			=> $LogID,
					'remote_ip'		=> $ip,
					'remote_host'	=> $host
				));
			}else
			{
				$logdate=date('Y-m-d H:i:s');
				
				$this->db->insert('loginfo', array(
					'LoginDate' 	=> $logdate,
					'Name' 			=> $this->db->escape_str($Name),
					'Activity'      => $this->db->escape_str($Activity),
					'ActionDate'	=> $logdate,
					'Username' 		=> $this->db->escape_str($Username),
					'Operation' 	=> $Operation,
					'LogID'			=> $LogID,
					'remote_ip'		=> $ip,
					'remote_host'	=> $host
				));	
			}
				
		}
		
		
		$this->db->trans_complete();
	}
	
	function BackupDB()
	{
		$dt=date('Y-m-d_H-m-s');
		$db_name = 'backup-on-'.$dt.'.zip';
		$path=FCPATH.'backups/';
		
		$prefs = array(
			'tables'        => array(),   						// Array of tables to backup.
			'ignore'        => array('trade_log', 'loginfo'),  // List of tables to omit from the backup
			'format'        => 'zip',                       	// gzip, zip, txt
			'filename'      => $db_name,           				// File name - NEEDED ONLY WITH ZIP FILES
			'add_drop'      => TRUE,                        	// Add DROP TABLE statements to backup file
			'add_insert'    => TRUE,                        	// Add INSERT data to backup file
			'newline'       => "\n"                         	// Newline character used in backup file
		);		
		
		$this->load->dbutil();
		
		$backup = $this->dbutil->backup($prefs); //Backup your entire database and assign it to a variable		
		write_file($path.$db_name, $backup); // Load the file helper and write the file to your server		
		//force_download($db_name, $backup);// Load the download helper and send the file to your desktop		
		
		
		//************Log tables
		$log = 'log-backup-on-'.$dt.'.zip';
		
		$prefs = array(
			'tables'        => array('trade_log', 'loginfo'),  // Array of tables to backup.
			'format'        => 'zip',                       	// gzip, zip, txt
			'filename'      =>  $log,            				// File name - NEEDED ONLY WITH ZIP FILES
		);
		
		$backup = $this->dbutil->backup($prefs); //Backup your entire database and assign it to a variable		
		write_file($path.$db_name, $backup);			
		//force_download($log, $backup);
		
		return true;
	}
	
	function CreateThumbnail($fileName,$width) 
    {
		#Get Image Width And Height
		$image_info = getimagesize($fileName);
		$imgWidth = $image_info[0];
		$imgHeight = $image_info[1];
		
		$ratio = $width / $imgWidth;
		
		$newHeight=$imgHeight * $ratio;
		$newWidth=$width;
		
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = $fileName;       
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
		$config['thumb_marker'] = '';
		$config['width'] = $newWidth;
        $config['height'] = $newHeight;
                    
        $this->image_lib->initialize($config);
		
		return $this->image_lib->resize()     ;
    }
	
}
?>
