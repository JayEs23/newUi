<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('assets/vendor/autoload.php');

class Approvelisting extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	 }
	 
	function GetListings()
	{
		$sql = "SELECT * FROM art_works ORDER BY listing_status,title";											

		$query = $this->db->query(stripslashes($sql));	

		$results = $query->result_array();

		// $res = [];

		// $n = 1;
		// foreach($results as $listing){
		// 	if ($listing['listing_status'] == 'Listed') {
		// 		$art_pix1 = base_url()."art-works/".$listing['art_pix1'];
		// 		$date=date_create($listing['creationyear']);
		// 		$fields = array(
		// 			'artistName' => $listing['artist'], 
		// 			'artId'=>$listing['art_id'], 
		// 			'artTitle'=>$listing['title'], 
		// 			'artSymbol'=>$listing['symbol'], 
		// 			"artDescription" => $listing['description'], 
		// 			"artCreationYear"=> date_format($date,DATE_ISO8601), 
		// 			"artValue"=>$listing['artwork_value'], 
		// 			"artPicture"=>$art_pix1, 
		// 			"pricePerToken"=>intval(number_format($listing['price_per_token'],0)), 
		// 			"numberOftokens"=>$listing['tokens'], 
		// 			"numberOfTokensForSale"=>$listing['tokens_for_sale'], 
		// 			"issuerEmail"=>$listing['email']
		// 		);
		// 		$res[$n]['fields'] = json_encode($fields);

		// 		$res[$n]['result'] = $this->getdata_model->CreateAssetOnBlockchain($fields);
		// 		$n++;
		// 	}
		// }	

		// echo "<pre>";

		// print_r($res); die();

		if ($results)
		{
			$data=array();

			if (is_array($results))
			{
				$sn=0;
				
				foreach($results as $row):
					$sn++; $sel=''; $del=''; $sdt=''; $edt=''; $adt=''; $pix='';
					
					if ($row['art_pix1'])
					{
						$pix='<img style="height:60px;" src="'.base_url().'art-works/thumbs/t_'.$row['art_pix1'].'" title="'.strtoupper(trim($row['title'])).'">';
					}
					
					if (($row['listing_starts']) and ($row['listing_starts'] <> '0000-00-00')) $sdt=date('d M Y',strtotime($row['listing_starts']));
					
					if (($row['listing_ends']) and ($row['listing_ends'] <> '0000-00-00')) $edt=date('d M Y',strtotime($row['listing_ends']));
					
					if (($row['approvaldate']) and ($row['approvaldate'] <> '0000-00-00')) $adt=date('d M Y',strtotime($row['approvaldate']));
					
					if (trim(strtolower($row['listing_status'])) == 'awaiting approval')
					{						
						/*$sel='
							<div class="dropdown d-inline-block">
								<button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-secondary" title="Select An Action On '.strtoupper(trim($row['title'])).'\'s Listing Request">Action</button>
								<div id="dd" tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu">
									<button type="button" tabindex="0" class="dropdown-item" title="View '.strtoupper(trim($row['title'])).'\'s Listing Request" onClick="ViewRow(\''.$row['artist'].'\',\''.$row['art_id'].'\',\''.$row['title'].'\',\''.$row['symbol'].'\',\''.$row['creationyear'].'\',\''.$row['dimensions'].'\',\''.$row['materials'].'\',\''.$row['description'].'\',\''.$row['document'].'\',\''.$row['display_location'].'\',\''.$row['artwork_value'].'\',\''.$row['tokens'].'\',\''.$row['price_per_token'].'\',\''.$sdt.'\',\''.$edt.'\',\''.$row['art_pix1'].'\',\''.$row['art_pix2'].'\',\''.$row['art_pix3'].'\',\''.$row['art_pix4'].'\',\''.$row['listing_status'].'\',\''.$adt.'\',\''.$row['id'].'\')">View</button>
									
									<button type="button" tabindex="0" class="dropdown-item greentext" title="Approve '.strtoupper(trim($row['title'])).'\'s Listing Request" onClick="ApproveRequest(\''.$row['artist'].'\',\''.$row['art_id'].'\',\''.$row['title'].'\',\''.$row['symbol'].'\',\''.$row['creationyear'].'\',\''.$row['dimensions'].'\',\''.$row['materials'].'\',\''.$row['description'].'\',\''.$row['document'].'\',\''.$row['display_location'].'\',\''.$row['artwork_value'].'\',\''.$row['tokens'].'\',\''.$row['price_per_token'].'\',\''.$sdt.'\',\''.$edt.'\',\''.$row['art_pix1'].'\',\''.$row['art_pix2'].'\',\''.$row['art_pix3'].'\',\''.$row['art_pix4'].'\',\''.$row['listing_status'].'\',\''.$adt.'\',\''.$row['id'].'\')">Approve</button>
									
									<button type="button" tabindex="0" class="dropdown-item redtext" title="Decline '.strtoupper(trim($row['title'])).'\'s Listing Request" onClick="DeclineRequest(\''.$row['artist'].'\',\''.$row['art_id'].'\',\''.$row['title'].'\',\''.$row['symbol'].'\',\''.$row['creationyear'].'\',\''.$row['dimensions'].'\',\''.$row['materials'].'\',\''.$row['description'].'\',\''.$row['document'].'\',\''.$row['display_location'].'\',\''.$row['artwork_value'].'\',\''.$row['tokens'].'\',\''.$row['price_per_token'].'\',\''.$sdt.'\',\''.$edt.'\',\''.$row['art_pix1'].'\',\''.$row['art_pix2'].'\',\''.$row['art_pix3'].'\',\''.$row['art_pix4'].'\',\''.$row['listing_status'].'\',\''.$adt.'\',\''.$row['id'].'\')">Decline</button>
								</div>
							</div>
						';*/
					}else
					{
						/*$sel='
							<div class="dropdown d-inline-block">
								<button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-secondary" title="Select An Action On '.strtoupper(trim($row['title'])).'\'s Listing Request">Action</button>
								<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu">
									<button type="button" tabindex="0" class="dropdown-item" title="View '.strtoupper(trim($row['title'])).'\'s Listing Request" onClick="ViewRow(\''.$row['artist'].'\',\''.$row['art_id'].'\',\''.$row['title'].'\',\''.$row['symbol'].'\',\''.$row['creationyear'].'\',\''.$row['dimensions'].'\',\''.$row['materials'].'\',\''.$row['description'].'\',\''.$row['document'].'\',\''.$row['display_location'].'\',\''.$row['artwork_value'].'\',\''.$row['tokens'].'\',\''.$row['price_per_token'].'\',\''.$sdt.'\',\''.$edt.'\',\''.$row['art_pix1'].'\',\''.$row['art_pix2'].'\',\''.$row['art_pix3'].'\',\''.$row['art_pix4'].'\',\''.$row['listing_status'].'\',\''.$adt.'\',\''.$row['id'].'\')">View</button>
								</div>
							</div>
						';*/
					}
					
					$sel='<img onClick="ViewRow(\''.$row['email'].'\',\''.$row['artist'].'\',\''.$row['art_id'].'\',\''.$row['title'].'\',\''.$row['symbol'].'\',\''.$row['creationyear'].'\',\''.$row['dimensions'].'\',\''.$row['materials'].'\',\''.$row['description'].'\',\''.$row['document'].'\',\''.$row['display_location'].'\',\''.$row['artwork_value'].'\',\''.$row['tokens'].'\',\''.$row['tokens_for_sale'].'\',\''.$row['price_per_token'].'\',\''.$sdt.'\',\''.$edt.'\',\''.$row['art_pix1'].'\',\''.$row['art_pix2'].'\',\''.$row['art_pix3'].'\',\''.$row['art_pix4'].'\',\''.$row['listing_status'].'\',\''.$adt.'\',\''.$row['issuer_id'].'\',\''.$row['blockchainUrl'].'\')" style="cursor:pointer; height:30px; " src="'.base_url().'images/view_icon.png" title="View '.strtoupper(trim($row['title'])).'\'s Listing Record">';
					 
		//artist,art_id,title,symbol,creationyear,dimensions,materials,description,document,display_location,artwork_value,tokens,price_per_token,listing_starts,listing_ends,art_pix1,art_pix2,art_pix3,art_pix4,listing_status,approvaldate
										
					$tp=array($pix,$row['title'],number_format($row['artwork_value'],2),number_format($row['tokens'],0),number_format($row['price_per_token'],2),$sdt,$edt,$row['listing_status'],$sel);
					
					$data[]=$tp;
				endforeach;
			}

			print_r(json_encode($data));
		}else
		{
			print_r(json_encode($results));
		}
	}
	
	function Approve()
	{
		$issuer_email=''; $email=''; $artist=''; $art_id=''; $title=''; $symbol=''; $artwork_value='';
		$tokens=''; $price_per_token=''; $listing_starts=''; $listing_ends=''; $Msg=''; $Op='';
		$listing_status='Listed'; $issuer_id=''; $tokens_for_sale='';
				
		if ($this->input->post('issuer_email')) $issuer_email = trim($this->input->post('issuer_email'));
		if ($this->input->post('issuer_id')) $issuer_id = trim($this->input->post('issuer_id'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));	
		if ($this->input->post('artist')) $artist = trim($this->input->post('artist'));		
		if ($this->input->post('art_id')) $art_id = trim($this->input->post('art_id'));		
		if ($this->input->post('title')) $title = ucwords(trim($this->input->post('title')));		
		if ($this->input->post('symbol')) $symbol = strtoupper(trim($this->input->post('symbol')));
		if ($this->input->post('artwork_value')) $artwork_value = trim($this->input->post('artwork_value'));		
		if ($this->input->post('tokens')) $tokens = trim($this->input->post('tokens'));
		if ($this->input->post('tokens_for_sale')) $tokens_for_sale = trim($this->input->post('tokens_for_sale'));
		if ($this->input->post('price_per_token')) $price_per_token = trim($this->input->post('price_per_token'));
		if ($this->input->post('listing_starts')) $listing_starts = $this->input->post('listing_starts');
		if ($this->input->post('listing_ends')) $listing_ends = $this->input->post('listing_ends');
				
		$approvaldate=date('Y-m-d H:i:s');		
											
		//Check if symbol exists
		$sql = "SELECT * FROM art_works WHERE (TRIM(symbol)='".$this->db->escape_str($symbol)."')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 )
		{
			$Msg="Approving of listing request was NOT successful. Symbol, ".strtoupper($symbol).", exists in the database.";
			
			$m = "Approving of listing request was NOT successful. Symbol, <b>".strtoupper($symbol)."</b>, exists in the database.";
			
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			$sql = "SELECT * FROM art_works WHERE (art_id=".$this->db->escape_str($art_id).")";
		
			$query = $this->db->query($sql);
			
			if ($query->num_rows() == 0)
			{
				$Msg="Approving of listing request was NOT successful. Art Id, ".$art_id.", was not found in the database.";
				
				$m = "Approving of listing request was NOT successful. Art Id, <b>".$art_id."</b>, was not found in the database.";
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{
				$description=''; $creationyear=''; $art_pix1='';
				
				$row = $query->row();
				
				if ($row->description) $description = trim($row->description);
				if ($row->creationyear) $creationyear = trim($row->creationyear);
				if ($row->art_pix1) $art_pix1 = trim($row->art_pix1);
				
				
				$holdingperiod=0; $holding_period_ends='';
				$set=$this->getdata_model->GetTradingParamaters();
				
				if ($set->holdingperiod) $holdingperiod = $set->holdingperiod;
								
				if (intval($holdingperiod) > 0) $holding_period_ends=date('Y-m-d',strtotime($listing_ends.' +'.$holdingperiod.' days'));						
				
				$dat=array();
				
				if (trim($holding_period_ends) <> '')
				{
					$dat=array(
						'symbol' 				=> $this->db->escape_str($symbol),
						'artwork_value' 		=> $this->db->escape_str($artwork_value),
						'tokens' 				=> $this->db->escape_str($tokens),
						'tokens_for_sale' 		=> $this->db->escape_str($tokens_for_sale),
						'price_per_token' 		=> $this->db->escape_str($price_per_token),
						'listing_starts' 		=> $this->db->escape_str($listing_starts),
						'listing_ends'			=> $this->db->escape_str($listing_ends),
						'holding_period_ends'	=> $this->db->escape_str($holding_period_ends),
						'listing_status' 		=> $this->db->escape_str($listing_status),
						'approvaldate' 			=> $this->db->escape_str($approvaldate)			
					);	
				}else
				{
					$dat=array(
						'symbol' 				=> $this->db->escape_str($symbol),
						'artwork_value' 		=> $this->db->escape_str($artwork_value),
						'tokens' 				=> $this->db->escape_str($tokens),
						'tokens_for_sale' 		=> $this->db->escape_str($tokens_for_sale),
						'price_per_token' 		=> $this->db->escape_str($price_per_token),
						'listing_starts' 		=> $this->db->escape_str($listing_starts),
						'listing_ends'			=> $this->db->escape_str($listing_ends),
						'listing_status' 		=> $this->db->escape_str($listing_status),
						'approvaldate' 			=> $this->db->escape_str($approvaldate)			
					);	
				}				
				
				$this->db->trans_start();
				$this->db->where(array('art_id' => $art_id));
				$this->db->update('art_works', $dat);			
				$this->db->trans_complete();	
				
				if ($this->db->trans_status() === FALSE)
				{					
					$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted approving listing request for artwork with title ".strtoupper($title)." but failed.";
					$m = "Listing Request Approval Failed.";
					$ret=array('status'=>'FAIL','Message'=>$m);					
				}else
				{
					//Update blockchain url
					$art_pix1 = base_url()."art-works/".$art_pix1;
					$date=date_create($creationyear);
					$fields = array(
						'artistName' => $artist, 
						'artId'=>$art_id, 
						'artTitle'=>$title, 
						'artSymbol'=>$symbol, 
						"artDescription" => $description, 
						"artCreationYear"=> date_format($date,DATE_ISO8601), 
						"artValue"=>$artwork_value, 
						"artPicture"=>$art_pix1, 
						"pricePerToken"=>$price_per_token, 
						"numberOftokens"=>$tokens, 
						"numberOfTokensForSale"=>$tokens_for_sale, 
						"issuerEmail"=>$issuer_email
					);
					
					$asset = $this->getdata_model->CreateAssetOnBlockchain($fields);
					
					if ($asset['status']==1)
					{
						$blockchainUrl=$asset['blockchainUrl'];
						
						$dat=array('blockchainUrl' => $this->db->escape_str($blockchainUrl));
	
						$this->db->trans_start();
						$this->db->where(array('art_id' => $art_id));
						$this->db->update('art_works', $dat);	
						$this->db->trans_complete();
					}
					
					
					
					//Create a record in listed_artworks table
					$sql = "SELECT * FROM listed_artworks WHERE (TRIM(symbol)='".$this->db->escape_str($symbol)."')";
					$query = $this->db->query($sql);
								
					if ($query->num_rows() == 0)
					{
						$this->db->trans_start();
						
						$dat=array(
							'uid' 					=> $this->db->escape_str($issuer_id),
							'symbol' 				=> $this->db->escape_str($symbol),
							'art_id' 				=> $this->db->escape_str($art_id),
							'tokens_on_issue' 		=> $this->db->escape_str($tokens),
							'tokens_for_sale' 		=> $this->db->escape_str($tokens_for_sale),
							'tokens_available' 		=> $this->db->escape_str($tokens_for_sale),
							'price_on_issue' 		=> $this->db->escape_str($price_per_token),
							'listing_starts' 		=> $this->db->escape_str($listing_starts),
							'listing_ends' 			=> $this->db->escape_str($listing_ends),
							'holding_period_ends'	=> $this->db->escape_str($holding_period_ends),
							'datelisted' 			=> $approvaldate
						);
		
						$this->db->insert('listed_artworks', $dat);

						$this->db->trans_complete();
						
						
						//Create an entry in primary_market table
						$sql="SELECT * FROM primary_market WHERE (TRIM(symbol)='".$this->db->escape_str($symbol)."')";
							
						$query=$this->db->query($sql);
				
						if ($query->num_rows() > 0)
						{
							$this->db->trans_start();
							$this->db->delete('primary_market', array('symbol' => $symbol)); 				
							$this->db->trans_complete();
						}
						
						if (date('Y-m-d',strtotime($listing_starts))==date('Y-m-d'))
						{
							$list_status='Started';
						}else
						{
							$list_status='Pending';
						}
						
						
						$this->db->trans_start();			
							
						$dat=array(
							'uid' 					=> $this->db->escape_str($issuer_id),
							'symbol'				=> $this->db->escape_str($symbol),
							'art_id' 				=> $this->db->escape_str($art_id),
							'tokens_on_issue' 		=> $this->db->escape_str($tokens),
							'tokens_for_sale' 		=> $this->db->escape_str($tokens_for_sale),
							'tokens_available'		=> $this->db->escape_str($tokens_for_sale),
							'price' 				=> $this->db->escape_str($price_per_token),
							'listing_starts' 		=> $this->db->escape_str($listing_starts),
							'holding_period_ends'	=> $this->db->escape_str($holding_period_ends),
							'listing_ends' 			=> $this->db->escape_str($listing_ends),
							'listing_status' 		=> $list_status
						);
						
						$this->db->insert('primary_market', $dat);	
							
						$this->db->trans_complete();
						
						/////////////////////////////////////////////////////////////
						//SEND MESSAGE TO ISSUER
						$issuer_phone=''; $issuer_name='';
						
						$det=$this->getdata_model->GetIssuerDetails($issuer_id);
						if ($det->phone) $issuer_phone = $det->phone;
						if ($det->user_name) $issuer_name = $det->user_name;
						
						$details='';
						$msgtype='system,sms';						
						$header='Listing Approval For '.strtoupper($title);
						$groups='';
						$emails=$issuer_email;
						$phones=$issuer_phone;
						$category='Message';
						$expiredate=$listing_ends;
						$display_status=1;
						$sender='Naija Art Mart';						
						
						$details="Dear ".$issuer_name.", your request to list your artwork titled, ".strtoupper($title).", has been approved. Symbol: ".strtoupper($symbol)."; Listing Starts: ".date('d M Y H:i:s',strtotime($listing_starts))."; Listing Ends: ".date('d M Y H:i:s',strtotime($listing_ends))."; Tokens: ".number_format($tokens,0)."; Tokens For Sale: ".number_format($tokens_for_sale,0)."; Value: NGN".number_format($artwork_value,2)."; Price: NGN".number_format($price_per_token,2).".";
						
						$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
						
						
						//Send EMAIL to Issuer
						$from='admin@naijaartmart.com';
						$to=$issuer_email;
						$subject=$header;
						$Cc='support@naijaartmart.com, idongesit_a@yahoo.com';
										
						$img=base_url()."images/logo.png";
											
						//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
					
						$message = '
							<html>
							<head>
							<meta charset="utf-8">
							<title>Naija Art Mart | Listing Approval</title>
							</head>
							<body>								
																
									Dear '.$issuer_name.',<br><br>
									
									Your request to list your artwork titled, '.strtoupper($title).', has been approved. Below are the details of your listing approval:
									
									<table border="1" style="border:thin solid #3D3939; width:85%" cellpadding="7" cellspacing="0">
										<tr>
											<th style="width:40%;" align="right">Artwork&nbsp;Title:</th>
											<td style="width:60%;"><font color="#FF0000">'.strtoupper($title).'</font></td>
										</tr>
										
										<tr >
											<th align="right">Symbol:</th>
										   <td><font color="#FF0000">'.strtoupper($symbol).'</font></td>
										</tr>
										
										<tr>
											<th align="right">Listing&nbsp;Starts:</th>
										   <td><font color="#FF0000">'.date('d F Y',strtotime($listing_starts)).'</font></td>
										</tr>
																	
										<tr>
											<th align="right">Listing&nbsp;Ends:</th>
										   <td><font color="#FF0000">'.date('d F Y',strtotime($listing_ends)).'</font></td>
										</tr>
																	
										 <tr>
											<th align="right">Approved&nbsp;No.&nbsp;Of&nbsp;Tokens:</th>
										   <td><font color="#FF0000">'.number_format($tokens,0).'</font></td>
										</tr>
										
										<tr>
											<th align="right">Tokens&nbsp;For&nbsp;Sale:</th>
										   <td><font color="#FF0000">'.number_format($tokens_for_sale,0).'</font></td>
										</tr>
										
										<tr>
											<th align="right">Artwork&nbsp;Value:</th>
											<td><font color="#FF0000">&#8358;'.number_format($artwork_value,2).'</font></td>
										</tr>
										
										<tr>
											<th align="right">Primary&nbsp;Price&nbsp;Per&nbsp;Token:</th>
											<td><font color="#FF0000">&#8358;'.number_format($price_per_token,2).'</font></td>
										</tr>
										
										<tr>
											<th align="right">Holding&nbsp;Period&nbsp;After&nbsp;Listing:</th>
											<td><font color="#FF0000">'.$holdingperiod.' Months ('.date('d F Y',strtotime($holding_period_ends)).')</font></td>
										</tr>
									</table>
									
									<br><br>Congratulations and welcome to Naija Art Mart trading platform.
											
									<p>Best Regards</p>
									Naija Art Mart
							</body>
							</html>';
							
						$altmessage = '
							Dear '.$issuer_name.',
									
							Your request to list your artwork titled, '.strtoupper($title).', has been approved. Below are the details of your listing approval:
							
							Title: '.strtoupper($title).'
							Symbol: '.strtoupper($symbol).'
							Listing Starts: '.date('d M Y H:i:s',strtotime($listing_starts)).'
							Listing Ends: '.date('d M Y H:i:s',strtotime($listing_ends)).'
							Approved No. Of Tokens: '.number_format($tokens,0).'
							Tokens For Sale: '.number_format($tokens_for_sale,0).'
							Artwork Value: NGN'.number_format($artwork_value,2).'
							Primary Price Per Token: NGN'.number_format($price_per_token,2).'
							Holding Period After Listing: '.$holdingperiod.' Months ('.date('d M Y H:i:s',strtotime($holding_period_ends)).')
							
							Congratulations and welcome to Naija Art Mart trading platform.
									
							Best Regards
							Naija Art Mart';
						
						if ($to) $v=$this->getdata_model->SendBlueMail($from,$to,$subject,$Cc,$message,$altmessage,$issuer_name);
						if (strtoupper(trim($v)) <> 'OK')
						{
							$Msg ="Listing Approval Was Successful, But Sending Of Email To Issuer Failed. A Message Has Been Sent To Issuer's Phone. Message Can Also Be Viewed Via Naija Art Mart Messaging Screen.";
							
							$m ="Listing Approval Was Successful, But Sending Of Email To Issuer Failed. A Message Has Been Sent To Issuer's Phone. Message Can Also Be Viewed Via Naija Art Mart Messaging Screen.";		
								
							$ret=array('status'=>'OK','Message'=>$m);					
						}else
						{
							$Msg="Listing Approval Was Successful.";				
							
							$ret=array('status'=>'OK','Message'=>'');
						}
					}else
					{
						$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted approving listing request for artwork with title ".$title." but failed. Symbol ".strtoupper($symbol)." already exists in the Naija Art Mart system.";
						
						$m = "Listing request approval was NOT successful. Symbol <b>".strtoupper($symbol)."</b> exists in the Naija Art Mart system.";
						
						$ret=array('status'=>'FAIL','Message'=>$m);
					}
				}				
			}				
		}
		
		$Op="LISTING REQUEST APPROVAL";	
		$remote_ip=$_SERVER['REMOTE_ADDR'];
		$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
		$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,$Op,$_SESSION['LogID']);
		
		echo json_encode($ret);
	}
	
	public function Decline()
	{
		$issuer_email=''; $email=''; $issuer_id=''; $artist=''; $art_id=''; $title=''; 
		$Msg=''; $Op=''; $listing_status='Not Approved';
				
		if ($this->input->post('issuer_email')) $issuer_email = trim($this->input->post('issuer_email'));
		if ($this->input->post('issuer_id')) $issuer_id = trim($this->input->post('issuer_id'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));	
		if ($this->input->post('artist')) $artist = trim($this->input->post('artist'));		
		if ($this->input->post('art_id')) $art_id = trim($this->input->post('art_id'));		
		if ($this->input->post('title')) $title = trim($this->input->post('title'));		
		
		$declinedate=date('Y-m-d H:i:s');
											
		//Check if symbol exists
		$sql = "SELECT * FROM art_works WHERE (art_id=".$this->db->escape_str($art_id).") AND (issuer_id=".$this->db->escape_str($issuer_id).")";

//$file = fopen('aaa.txt',"a"); fwrite($file,$sql."\r\n"); fclose($file);//////////////////////////
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() == 0 )
		{
			$Msg="Declining of listing request was NOT successful. Listing request with art Id ".$art_id." was not found in the database.";
			
			$m = "Declining of listing request was NOT successful. Listing request with art Id ".$art_id." was not found in the database.";
			
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			$dat=array('listing_status'=>$listing_status,'declinedate'=>$declinedate);				
			
			$this->db->trans_start();
			$array = array('art_id' => $art_id, 'issuer_id' => $issuer_id);
			$this->db->where($array);
			$this->db->update('art_works', $dat);			
			$this->db->trans_complete();	
			
			if ($this->db->trans_status() === FALSE)
			{					
				$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted declining listing request for artwork with title ".strtoupper($title)." but failed.";
				$m = "Listing Request Decline Failed.";
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{
				//SEND MESSAGE TO ISSUER
				$issuer_phone=''; $issuer_name='';
				
				$det=$this->getdata_model->GetIssuerDetails($issuer_id);
				if ($det->phone) $issuer_phone = $det->phone;
				if ($det->user_name) $issuer_name = $det->user_name;
				
				$details='';
				$msgtype='system';						
				$header='Listing Declining For '.strtoupper($title);
				$groups='';
				$emails=$issuer_email;
				$phones=$issuer_phone;
				$category='Message';
				$display_status=1;
				$sender='Naija Art Mart';						
				
				$details="Dear ".$issuer_name.", your request to list your artwork titled, ".strtoupper($title).", has been declined. You are free to contact us for more information.";
				
				$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
				
				
				//Send EMAIL to Issuer
				$from='admin@naijaartmart.com';
				$to=$issuer_email;
				$subject=$header;
				$Cc='support@naijaartmart.com, idongesit_a@yahoo.com';
								
				$img=base_url()."images/logo.png";
									
				//<p><img src="'.$img.'" width="100" alt="Naija Art Mart" title="Naija Art Mart" /></p>
			
				$message = '
					<html>
					<head>
					<meta charset="utf-8">
					<title>Naija Art Mart | Listing Decline</title>
					</head>
					<body>								
														
							Dear '.$issuer_name.',<br><br>
							
							Your request to list your artwork titled, '.strtoupper($title).', has been declined.
							
							<br><br>You are free to contact us for more information.
									
							<p>Best Regards</p>
							Naija Art Mart
					</body>
					</html>';
					
				$altmessage = 'Dear '.$issuer_name.',
							
					Your request to list your artwork titled, '.strtoupper($title).', has been declined.
					
					You are free to contact us for more information.
							
					Best Regards
					Naija Art Mart';
				
				if ($to) $v=$this->getdata_model->SendBlueMail($from,$to,$subject,$Cc,$message,$altmessage,$issuer_name);
				
				if (strtoupper(trim($v)) <> "OK")
				{
					$Msg ="Listing Decline Was Successful, But Sending Of Email To Issuer Failed. A Message Has Been Sent Issuer's Phone. Message Can Also Be Viewed Via Naija Art Mart Messaging Screen.";
					
					$m = "Listing Decline Was Successful, But Sending Of Email To Issuer Failed. A Message Has Been Sent Issuer's Phone. Message Can Also Be Viewed Via Naija Art Mart Messaging Screen.";		

					$ret=array('status'=>'OK','Message'=>$m);						
				}else
				{
					$Msg = "Listing Decline Was Successful.";				
					
					$ret = array("status"=>'OK', "Message"=>"");
				}
				
				//$file = fopen('aaa1.txt',"a"); fwrite($file,print_r($ret,true)); fclose($file);
			}				
		}
		
		$Op          = "LISTING REQUEST DECLINED";	
		$remote_ip   = $_SERVER['REMOTE_ADDR'];
		$remote_host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
		$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,$Op,$_SESSION['LogID']);
		
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
			
			$this->load->view('admin/approvelisting_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
