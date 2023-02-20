<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Requestlisting extends CI_Controller {
	function __construct() 
	{
		parent::__construct();		
		$this->load->helper('url');
		$this->load->model('getdata_model');
	}
	
	
	function GetListings()
	{
		$email='';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		
		$sql = "SELECT * FROM art_works WHERE (TRIM(email)='".$this->db->escape_str($email)."') ORDER BY title";											

		$query = $this->db->query(stripslashes($sql));	

		$results = $query->result_array();		

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
						$pix='<img style="height:80px; width:120px !important;border-radius:12px; background-size:cover;" src="'.base_url().'art-works/thumbs/t_'.$row['art_pix1'].'" title="'.strtoupper(trim($row['title'])).'">';
					}
					
					if (($row['listing_starts']) and ($row['listing_starts'] <> '0000-00-00')) $sdt=date('d M Y',strtotime($row['listing_starts']));
					
					if (($row['listing_ends']) and ($row['listing_ends'] <> '0000-00-00')) $edt=date('d M Y',strtotime($row['listing_ends']));
					
					if (($row['approvaldate']) and ($row['approvaldate'] <> '0000-00-00')) $adt=date('d M Y',strtotime($row['approvaldate']));
					
					if (trim(strtolower($row['listing_status'])) == 'awaiting approval')
					{
						$sel='<img onClick="SelectRow(\''.$row['artist'].'\',\''.$row['art_id'].'\',\''.$row['title'].'\',\''.$row['symbol'].'\',\''.$row['creationyear'].'\',\''.$row['dimensions'].'\',\''.$row['materials'].'\',\''.$row['description'].'\',\''.$row['document'].'\',\''.$row['display_location'].'\',\''.$row['artwork_value'].'\',\''.$row['tokens'].'\',\''.$row['tokens_for_sale'].'\',\''.$row['price_per_token'].'\',\''.$sdt.'\',\''.$edt.'\',\''.$row['art_pix1'].'\',\''.$row['art_pix2'].'\',\''.$row['art_pix3'].'\',\''.$row['art_pix4'].'\',\''.$row['listing_status'].'\',\''.$adt.'\',\''.$row['id'].'\')" style="cursor:pointer; height:30px; " src="'.base_url().'images/view_icon.png" title="Edit '.strtoupper(trim($row['title'])).'\'s Record">';
						
						$del='<img onClick="DeleteRow(\''.$row['title'].'\',\''.$row['artist'].'\',\''.$row['art_id'].'\',\''.$row['id'].'\')" style="cursor:pointer; height:30px; " src="'.base_url().'images/delete_icon.png" title="Delete '.strtoupper(trim($row['title'])).'\'s Record">';
					}
					
					//artist,art_id,title,symbol,creationyear,dimensions,materials,description,document,display_location,artwork_value,tokens,price_per_token,listing_starts,listing_ends,art_pix1,art_pix2,art_pix3,art_pix4,listing_status,approvaldate
										
					$tp=array($pix,$row['title'],'&#8358;'.number_format($row['artwork_value'],2),number_format($row['tokens'],0),'&#8358;'.number_format($row['price_per_token'],2),$sdt,$edt,$row['listing_status'],$sel);
					
					$data[]=$tp;
				endforeach;
			}

			print_r(json_encode($data));
		}else
		{
			print_r(json_encode($results));
		}
	}
	
	function AddListingRequest()
	{
		$email=''; $artist=''; $title=''; $creationyear=''; $dimensions=''; $materials=''; $description=''; 
		$display_location=''; $artwork_value=''; $tokens=''; $price_per_token=''; $uid=''; $art_id='';
		$tokens_for_sale='';
		
		$PixImg1 = ''; $PixImg2 = ''; $PixImg3 = ''; $PixImg4 = ''; $pdf = '';
		
		if ($this->input->post('uid')) $uid = trim($this->input->post('uid'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('artist')) $artist = trim($this->input->post('artist'));			
		if ($this->input->post('title')) $title = trim($this->input->post('title'));		
		if ($this->input->post('creationyear')) $creationyear = trim($this->input->post('creationyear'));		
		if ($this->input->post('dimensions')) $dimensions = trim($this->input->post('dimensions'));					
		if ($this->input->post('materials')) $materials = trim(htmlentities($this->input->post('materials')));			
		if ($this->input->post('description')) $description = trim(htmlentities($this->input->post('description')));		
		if ($this->input->post('display_location')) $display_location = trim($this->input->post('display_location'));		
		if ($this->input->post('artwork_value')) $artwork_value = trim($this->input->post('artwork_value'));		
		if ($this->input->post('tokens')) $tokens = trim($this->input->post('tokens'));	
		if ($this->input->post('tokens_for_sale')) $tokens_for_sale = trim($this->input->post('tokens_for_sale'));	
		if ($this->input->post('price_per_token')) $price_per_token = trim($this->input->post('price_per_token'));
		
		if (isset($_FILES['art_pix1'])) $PixImg1 = $_FILES['art_pix1'];
		if (isset($_FILES['art_pix2'])) $PixImg2 = $_FILES['art_pix2'];
		if (isset($_FILES['art_pix3'])) $PixImg3 = $_FILES['art_pix3'];
		if (isset($_FILES['art_pix4'])) $PixImg4 = $_FILES['art_pix4'];
		if (isset($_FILES['document'])) $pdf = $_FILES['document'];
		
		$requestdate=date('Y-m-d H:i:s');
		
		//Check if record exists
		$sql = "SELECT * FROM art_works WHERE (TRIM(email)='".$this->db->escape_str($email)."') AND (TRIM(title)='".$this->db->escape_str($title)."')";

		$query = $this->db->query($sql);
					
		if ($query->num_rows() > 0 )
		{
			$ret="Listing request failed. Artwork record with title <b>".strtoupper($title)."</b> made by account with the email <b>".$email."</b> exists in the database.";
		}else
		{
			$art_id=$this->getdata_model->GetId('art_works','art_id');
			
			$pix1=''; $pix2=''; $pix3=''; $pix4=''; $doc='';			
								
			if ($PixImg1)
			{
				$fn=$art_id."_pix1.jpg";
				$thumb="t_".$art_id."_pix1.jpg";
				
				$target 		= "art-works/".$fn;
				$thumb_target 	= "art-works/thumbs/".$thumb;
				
				if (move_uploaded_file($PixImg1['tmp_name'], $target))
				{
					$pix1=$fn;
					$image_info = getimagesize($target);
					$imgWidth = $image_info[0];
					$imgHeight = $image_info[1];
					
					if ($imgWidth > 1000) $this->getdata_model->ResizeImage($target,1000); //Resize to 1000px
					
					$r=copy($target, $thumb_target);
					
					if ($r === true)//Create thumbnails	
					{										
						$this->getdata_model->ResizeImageByHeight($thumb_target,100); //Resize to 100px	
					}				
				}
			}
			
			if ($PixImg2)
			{
				$fn=$art_id."_pix2.jpg";
				$thumb="t_".$art_id."_pix2.jpg";
				
				$target 		= "art-works/".$fn;
				$thumb_target 	= "art-works/thumbs/".$thumb;
				
				if (move_uploaded_file($PixImg2['tmp_name'], $target))
				{
					$pix2=$fn;
					$image_info = getimagesize($target);
					$imgWidth = $image_info[0];
					$imgHeight = $image_info[1];
					
					if ($imgWidth > 1000) $this->getdata_model->ResizeImage($target,1000); //Resize to 1000px
					
					$r=copy($target, $thumb_target);
					
					if ($r === true)//Create thumbnails	
					{										
						$this->getdata_model->ResizeImageByHeight($thumb_target,100); //Resize to 100px	
					}				
				}
			}
			
			if ($PixImg3)
			{
				$fn=$art_id."_pix3.jpg";
				$thumb="t_".$art_id."_pix3.jpg";
				
				$target 		= "art-works/".$fn;
				$thumb_target 	= "art-works/thumbs/".$thumb;
				
				if (move_uploaded_file($PixImg3['tmp_name'], $target))
				{
					$pix3=$fn;
					$image_info = getimagesize($target);
					$imgWidth = $image_info[0];
					$imgHeight = $image_info[1];
					
					if ($imgWidth > 1000) $this->getdata_model->ResizeImage($target,1000); //Resize to 1000px
					
					$r=copy($target, $thumb_target);
					
					if ($r === true)//Create thumbnails	
					{										
						$this->getdata_model->ResizeImageByHeight($thumb_target,100); //Resize to 100px	
					}				
				}
			}
			
			if ($PixImg4)
			{
				$fn=$art_id."_pix4.jpg";
				$thumb="t_".$art_id."_pix4.jpg";
				
				$target 		= "art-works/".$fn;
				$thumb_target 	= "art-works/thumbs/".$thumb;
				
				if (move_uploaded_file($PixImg4['tmp_name'], $target))
				{
					$pix4=$fn;
					$image_info = getimagesize($target);
					$imgWidth = $image_info[0];
					$imgHeight = $image_info[1];
					
					if ($imgWidth > 1000) $this->getdata_model->ResizeImage($target,1000); //Resize to 1000px
					
					$r=copy($target, $thumb_target);
					
					if ($r === true)//Create thumbnails	
					{										
						$this->getdata_model->ResizeImageByHeight($thumb_target,100); //Resize to 100px	
					}				
				}
			}
			
			if ($pdf)
			{
				$fn		= $art_id."_doc.pdf";
				$target = "art-works/docs/".$fn;
				
				if (move_uploaded_file($pdf['tmp_name'], $target)) $doc=$fn;
			}						
						
			$Values="Issuer Id = ".$uid."; Email = ".$email."; Artist = ".$artist."; Artwork Id = ".$art_id."; Artwork Title = ".$title."; Creation Date = ".$creationyear."; Dimensions = ".$dimensions."; Materials Used For Artwork = ".$materials."; Description = ".$description."; Document Filename = ".$doc."; Display Location = ".$display_location."; Artwork Value = ".$artwork_value."; No Of Tokens = ".$tokens."; Price Per Token = ".$price_per_token."; Artwork Picture 1 Filename = ".$pix1."; Artwork Picture 2 Filename = ".$pix2."; Artwork Picture 3 Filename = ".$pix3."; Artwork Picture 4 Filename = ".$pix4."; Listing Status = Awaiting Approval; Request Date = ".$requestdate;

			$dat=array(
				'email'				=> $this->db->escape_str($email),
				'issuer_id' 		=> $this->db->escape_str($uid),
				'artist' 			=> $this->db->escape_str($artist),
				'art_id' 			=> $this->db->escape_str($art_id),
				'title' 			=> $this->db->escape_str($title),
				'symbol' 			=> '',
				'creationyear' 		=> $this->db->escape_str($creationyear),
				'dimensions' 		=> $this->db->escape_str($dimensions),
				'materials' 		=> $this->db->escape_str($materials),
				'description' 		=> $this->db->escape_str($description),
				'document' 			=> $this->db->escape_str($doc),
				'display_location'	=> $this->db->escape_str($display_location),
				'artwork_value' 	=> $this->db->escape_str($artwork_value),
				'tokens' 			=> $this->db->escape_str($tokens),
				'tokens_for_sale' 	=> $this->db->escape_str($tokens_for_sale),
				'price_per_token' 	=> $this->db->escape_str($price_per_token),					
				'art_pix1' 			=> $this->db->escape_str($pix1),
				'art_pix2' 			=> $this->db->escape_str($pix2),
				'art_pix3' 			=> $this->db->escape_str($pix3),
				'art_pix4' 			=> $this->db->escape_str($pix4),
				'listing_status' 	=> 'Awaiting Approval',
				'requestdate' 		=> $requestdate
			);
			
			#Edit
			$this->db->trans_start();
			$this->db->insert('art_works', $dat);			
			$this->db->trans_complete();
						
			$Msg='';
		
			if ($this->db->trans_status() === FALSE)
			{					
				$Msg=$_SESSION['email']." attempted requesting for listing for artwork with title ".strtoupper($title)." but failed.";
				
				$ret = 'Listing Request Was Not Successful.';
			}else
			{
				//***************Send Message****************
				//Get recipients
				$emails='';
				$users=$this->getdata_model->GetUsers(array('Admin','Gallery'));
				
				if ($users)
				{
					foreach($users as $u)
					{
						if (trim($emails)=='') $emails=$u->email; else $emails .= ",".$u->email;
					}
				}
				
										
				$det=$this->getdata_model->GetIssuerDetails($uid);
				if ($det->phone) $issuer_phone = $det->phone;
				if ($det->user_name) $issuer_name = $det->user_name;
				
				$msgtype='system';						
				$header='Listing Request For '.strtoupper($title);
				$groups='';
				$emails=$emails;
				$phones='';
				$category='Message';
				$expiredate=NULL;
				$display_status=1;
				$sender='System';						
				
				$details="An issuer, ".strtoupper($issuer_name).", with email ".$email.", and phone number, ".$issuer_phone.", has submitted a request for the listing of an artwork title, ".strtoupper($title).". Please attend to the request.";
				
				$res=$this->getdata_model->SendMessage($header,$details,$msgtype,$groups,$emails,$phones,$category,$expiredate,$display_status,$sender);
				
				
				$Msg="Request for listing was successfully.Details are: ".$Values;
				
				$ret ='OK';
				
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
				//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
				$this->getdata_model->LogDetails($email,$Msg,$email,date('Y-m-d H:i:s'),$remote_ip,$remote_host,'MADE REQUEST FOR ARTWORK LISTING',$_SESSION['LogID']);	
			}			
		}
				
		echo $ret;
	}
	
	public function EditListing()
	{
		$email=''; $artist=''; $title=''; $creationyear=''; $dimensions=''; $materials=''; $description=''; 
		$display_location=''; $artwork_value=''; $tokens=''; $price_per_token=''; $uid=''; $art_id='';
		$tokens_for_sale='';
		
		$PixImg1 = ''; $PixImg2 = ''; $PixImg3 = ''; $PixImg4 = ''; $pdf = ''; $Id = ''; $art_id='';
		// echo json_encode($this->input->post()); die();
		if ($this->input->post('uid')) $uid = trim($this->input->post('uid'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('artist')) $artist = trim($this->input->post('artist'));			
		if ($this->input->post('title')) $title = trim($this->input->post('title'));		
		if ($this->input->post('creationyear')) $creationyear = trim($this->input->post('creationyear'));		
		if ($this->input->post('dimensions')) $dimensions = trim($this->input->post('dimensions'));					
		if ($this->input->post('materials')) $materials = trim(htmlentities($this->input->post('materials')));			
		if ($this->input->post('description')) $description = trim(htmlentities($this->input->post('description')));		
		if ($this->input->post('display_location')) $display_location = trim($this->input->post('display_location'));		
		if ($this->input->post('artwork_value')) $artwork_value = trim($this->input->post('artwork_value'));		
		if ($this->input->post('tokens')) $tokens = trim($this->input->post('tokens'));	
		if ($this->input->post('tokens_for_sale')) $tokens_for_sale = trim($this->input->post('tokens_for_sale'));	
		if ($this->input->post('price_per_token')) $price_per_token = trim($this->input->post('price_per_token'));
		if (isset($_FILES['art_pix1'])) $PixImg1 = $_FILES['art_pix1'];
		if (isset($_FILES['art_pix2'])) $PixImg2 = $_FILES['art_pix2'];
		if (isset($_FILES['art_pix3'])) $PixImg3 = $_FILES['art_pix3'];
		if (isset($_FILES['art_pix4'])) $PixImg4 = $_FILES['art_pix4'];
		if (isset($_FILES['document'])) $pdf = $_FILES['document'];
		if ($this->input->post('art_id')) $art_id = trim($this->input->post('art_id'));
		if ($this->input->post('id')) $Id = trim($this->input->post('id'));
				
		//Check if record exists		
		$sql = "SELECT * FROM art_works WHERE (art_id=".$this->db->escape_str($art_id).")";

		$query = $this->db->query($sql);
					
		if ($query->num_rows() == 0 )
		{
			$m = "Could Not Edit Listing Request Record. Art Id '".$art_id."' Does Not Exist.";
			$ret=array('status'=>'FAIL','Message'=>$m);
		}else
		{
			$tist=''; $aid=''; $tit=''; $sym=''; $cyr=''; $dim=''; $mat=''; $des=''; $loc=''; $dc='';
			$tval=''; $tok=''; $pr=''; $sdt=''; $edt=''; $p1=''; $p2=''; $p3=''; $p4=''; $sta='';
			$adt=''; $rdt=''; $sale='';
		
			$row = $query->row();			
			
			if ($row->artist) $tist=trim($row->artist);
			if ($row->art_id) $aid=trim($row->art_id);
			if ($row->title) $tit=trim($row->title);
			if ($row->symbol) $sym=trim($row->symbol);
			if ($row->creationyear) $cyr=trim($row->creationyear);
			if ($row->dimensions) $dim=trim($row->dimensions);
			if ($row->materials) $mat=trim($row->materials);
			if ($row->description) $des=trim($row->description);			
			if ($row->display_location) $loc=trim($row->display_location);			
			if ($row->document) $dc=trim($row->document);			
			if ($row->artwork_value) $tval=trim($row->artwork_value);			
			if ($row->tokens) $tok=trim($row->tokens);
			if ($row->tokens_for_sale) $sale=trim($row->tokens_for_sale);
			if ($row->price_per_token) $pr=trim($row->price_per_token);			
			if ($row->listing_starts) $sdt=trim($row->listing_starts);
			if ($row->listing_ends) $edt=trim($row->listing_ends);			
			if ($row->art_pix1) $p1=trim($row->art_pix1);
			if ($row->art_pix2) $p2=trim($row->art_pix2);
			if ($row->art_pix3) $p3=trim($row->art_pix3);
			if ($row->art_pix4) $p4=trim($row->art_pix4);			
			if ($row->listing_status) $sta=trim($row->listing_status);			
			if ($row->approvaldate) $adt=trim($row->approvaldate);
			if ($row->requestdate) $rdt=trim($row->requestdate);
			
			$pix1=''; $pix2=''; $pix3=''; $pix4=''; $doc='';			
								
			if ($PixImg1)
			{
				$fn=$art_id."_pix1.jpg";
				$thumb="t_".$art_id."_pix1.jpg";
				
				$target 		= "art-works/".$fn;
				$thumb_target 	= "art-works/thumbs/".$thumb;
				
				if (move_uploaded_file($PixImg1['tmp_name'], $target))
				{
					$pix1=$fn;
					$image_info = getimagesize($target);
					$imgWidth = $image_info[0];
					$imgHeight = $image_info[1];
					
					if ($imgWidth > 1000) $this->getdata_model->ResizeImage($target,1000); //Resize to 1000px
					
					$r=copy($target, $thumb_target);
					
					if ($r === true)//Create thumbnails	
					{										
						$this->getdata_model->ResizeImageByHeight($thumb_target,100); //Resize to 100px	
					}				
				}
			}
			
			if ($PixImg2)
			{
				$fn=$art_id."_pix2.jpg";
				$thumb="t_".$art_id."_pix2.jpg";
				
				$target 		= "art-works/".$fn;
				$thumb_target 	= "art-works/thumbs/".$thumb;
				
				if (move_uploaded_file($PixImg2['tmp_name'], $target))
				{
					$pix2=$fn;
					$image_info = getimagesize($target);
					$imgWidth = $image_info[0];
					$imgHeight = $image_info[1];
					
					if ($imgWidth > 1000) $this->getdata_model->ResizeImage($target,1000); //Resize to 1000px
					
					$r=copy($target, $thumb_target);
					
					if ($r === true)//Create thumbnails	
					{										
						$this->getdata_model->ResizeImageByHeight($thumb_target,100); //Resize to 100px	
					}				
				}
			}
			
			if ($PixImg3)
			{
				$fn=$art_id."_pix3.jpg";
				$thumb="t_".$art_id."_pix3.jpg";
				
				$target 		= "art-works/".$fn;
				$thumb_target 	= "art-works/thumbs/".$thumb;
				
				if (move_uploaded_file($PixImg3['tmp_name'], $target))
				{
					$pix3=$fn;
					$image_info = getimagesize($target);
					$imgWidth = $image_info[0];
					$imgHeight = $image_info[1];
					
					if ($imgWidth > 1000) $this->getdata_model->ResizeImage($target,1000); //Resize to 1000px
					
					$r=copy($target, $thumb_target);
					
					if ($r === true)//Create thumbnails	
					{										
						$this->getdata_model->ResizeImageByHeight($thumb_target,100); //Resize to 100px	
					}				
				}
			}
			
			if ($PixImg4)
			{
				$fn=$art_id."_pix4.jpg";
				$thumb="t_".$art_id."_pix4.jpg";
				
				$target 		= "art-works/".$fn;
				$thumb_target 	= "art-works/thumbs/".$thumb;
				
				if (move_uploaded_file($PixImg4['tmp_name'], $target))
				{
					$pix4=$fn;
					$image_info = getimagesize($target);
					$imgWidth = $image_info[0];
					$imgHeight = $image_info[1];
					
					if ($imgWidth > 1000) $this->getdata_model->ResizeImage($target,1000); //Resize to 1000px
					
					$r=copy($target, $thumb_target);
					
					if ($r === true)//Create thumbnails	
					{										
						$this->getdata_model->ResizeImageByHeight($thumb_target,100); //Resize to 100px	
					}				
				}
			}
			
			if ($pdf)
			{
				$fn		= $art_id."_doc.pdf";
				$target = "art-works/docs/".$fn;
				
				if (move_uploaded_file($pdf['tmp_name'], $target)) $doc=$fn;
			}
			
			//Check if Listing has been listed or declined
			if (strtolower($sta) == 'listed')//Listed, Awaiting Approval, Not Approved
			{
				$m = "You Cannot Edit Listing Request For Artwork Titled <b>".$tit."</b> Because It Has Already Been Listed.";
				$ret=array('status'=>'FAIL','Message'=>$m);
			}elseif (strtolower($sta) == 'not approved')
			{
				$m = "You Cannot Edit Listing Request For Artwork Titled <b>".$tit."</b> Because It Has Already Been Declined.";
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{
				$OldValues="Issuer Id = ".$uid."; Email = ".$email."; Artist = ".$tist."; Artwork Id = ".$aid."; Artwork Title = ".$tit."; Symbol = ".$sym."; Creation Date = ".$cyr."; Dimensions = ".$dim."; Materials Used For Artwork = ".$mat."; Description = ".$des."; Document Filename = ".$dc."; Display Location = ".$loc."; Artwork Value = ".$tval."; No Of Tokens = ".$tok."; No Of Tokens For Sale = ".$sale."; Price Per Token = ".$pr."; Artwork Picture 1 Filename = ".$p1."; Artwork Picture 2 Filename = ".$p2."; Artwork Picture 3 Filename = ".$p3."; Artwork Picture 4 Filename = ".$p4."; Listing Status = ".$sta."; Request Date = ".$rdt."; Listing Start Date = ".$sdt."; Listing End date = ".$edt."; Approval Date = ".$adt;
				
				if (trim($pix1) == '') $np1 = $p1; else $np1 = $pix1;
				if (trim($pix2) == '') $np2 = $p2; else $np2 = $pix2;
				if (trim($pix3) == '') $np3 = $p3; else $np3 = $pix3;
				if (trim($pix4) == '') $np4 = $p4; else $np4 = $pix4;
				if (trim($doc) == '') $ndc = $dc; else $ndc = $doc;
				
				$NewValues="Issuer Id = ".$uid."; Email = ".$email."; Artist = ".$artist."; Artwork Id = ".$art_id."; Artwork Title = ".$title."; Symbol = ".$sym."; Creation Date = ".$creationyear."; Dimensions = ".$dimensions."; Materials Used For Artwork = ".$materials."; Description = ".$description."; Document Filename = ".$ndc."; Display Location = ".$display_location."; Artwork Value = ".$artwork_value."; No Of Tokens = ".$tokens."; No Of Tokens For Sale = ".$tokens_for_sale."; Price Per Token = ".$price_per_token."; Artwork Picture 1 Filename = ".$np1."; Artwork Picture 2 Filename = ".$np2."; Artwork Picture 3 Filename = ".$np3."; Artwork Picture 4 Filename = ".$np4."; Listing Status = ".$sta."; Request Date = ".$rdt."; Listing Start Date = ".$sdt."; Listing End date = ".$edt."; Approval Date = ".$adt;
				
				$dat=array(
					'artist' 			=> $this->db->escape_str($artist),
					'title' 			=> $this->db->escape_str($title),
					'creationyear' 		=> $this->db->escape_str($creationyear),
					'dimensions' 		=> $this->db->escape_str($dimensions),
					'materials' 		=> $this->db->escape_str($materials),
					'description' 		=> $this->db->escape_str($description),				
					'display_location'	=> $this->db->escape_str($display_location),
					'artwork_value' 	=> $this->db->escape_str($artwork_value),
					'tokens' 			=> $this->db->escape_str($tokens),
					'tokens_for_sale' 	=> $this->db->escape_str($tokens_for_sale),
					'price_per_token' 	=> $this->db->escape_str($price_per_token)
				);
				
				if (trim($pix1) <> '') $dat['art_pix1'] = $this->db->escape_str($pix1);			
				if (trim($pix2) <> '') $dat['art_pix2'] = $this->db->escape_str($pix2);
				if (trim($pix3) <> '') $dat['art_pix3'] = $this->db->escape_str($pix3);
				if (trim($pix4) <> '') $dat['art_pix4'] = $this->db->escape_str($pix4);			
				if (trim($doc) <> '') $dat['document'] = $this->db->escape_str($doc);
				
				#Edit
				$this->db->trans_start();
				$this->db->where(array('art_id' => $art_id));
				$this->db->update('art_works', $dat);			
				$this->db->trans_complete();
							
				$Msg='';
			
				if ($this->db->trans_status() === FALSE)
				{					
					$Msg=$_SESSION['fullname'].'('.$_SESSION['email'].") attempted editing listing request record but failed.";
					
					$m = "Listing Request Record Could Not Be Edited.";
					$ret=array('status'=>'FAIL','Message'=>$m);
				}else
				{
					$Msg="Listing request record has been edited successfully by ".strtoupper($_SESSION['fullname'].'('.$_SESSION['email'])."). Old Values => ".$OldValues.". Updated values => ".$NewValues;				
					
					$ret=array('status'=>'OK','Message'=>'');
									
					$remote_ip=$_SERVER['REMOTE_ADDR'];
					$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
					
					//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
					$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],date('Y-m-d H:i:s'),$remote_ip,$remote_host,"EDITED LISTING REQUEST RECORD",$_SESSION['LogID']);
				}		
			}					
		}
				
		echo json_encode($ret);
	}
	
	function DeleteListing()
	{
		$email=''; $art_id=''; $id=''; $title=''; $artist='';
		
		if ($this->input->post('id')) $id = trim($this->input->post('id'));
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('art_id')) $art_id = trim($this->input->post('art_id'));
		if ($this->input->post('title')) $title = trim($this->input->post('title'));
		if ($this->input->post('artist')) $artist = trim($this->input->post('artist'));
		
		//Check if record exists		
		$sql = "SELECT * FROM art_works WHERE (art_id=".$this->db->escape_str($art_id).") OR (id=".$this->db->escape_str($id).")";
		
		$query = $this->db->query($sql);
					
		if ($query->num_rows() > 0 )
		{
			$tit=''; $sta='';		
			$row = $query->row();			
			
			if ($row->title) $tit=trim($row->title);		
			if ($row->listing_status) $sta=trim($row->listing_status);
			
			//Check if Listing has been listed or declined
			if (strtolower($sta) == 'listed')//Listed, Awaiting Approval, Not Approved
			{
				$m = "You Cannot Delete Listing Request For Artwork Titled <b>".$tit."</b> Because It Has Already Been Listed.";
				$ret=array('status'=>'FAIL','Message'=>$m);
			}elseif (strtolower($sta) == 'not approved')
			{
				$m = "You Cannot Delete Listing Request For Artwork Titled <b>".$tit."</b> Because It Has Already Been Declined.";
				$ret=array('status'=>'FAIL','Message'=>$m);
			}else
			{
				$this->db->trans_start();
				$this->db->delete('art_works', array('art_id' => $art_id)); 				
				$this->db->trans_complete();
				
				$sql = "SELECT * FROM art_works WHERE (TRIM(email)='".$this->db->escape_str($email)."')";		
				$qry = $this->db->query($sql);			
				$rowcount=$qry->num_rows();		
							
				$Msg='';
			
				if ($this->db->trans_status() === FALSE)
				{
					$Msg=$email.") attempted deleting listing request record with art id ".$art_id." but failed.";
					
					$ret=array('status'=>'FAIL','Message'=>"Listing Request Record Could Not Be Deleted.",'rowcount'=>$rowcount);
				}else
				{
					$Msg="Listing request record has been deleted successfully by ".strtoupper($_SESSION['email']).".";
					
					$ret=array('status'=>'OK','Message'=>'','rowcount'=>$rowcount);
					
					//LogDetails($Name,$Activity,$Username,$logdate,$ip,$host,$Operation,$LogID)
					$this->getdata_model->LogDetails($_SESSION['fullname'],$Msg,$_SESSION['email'],$_SESSION['LogIn'],$_SESSION['RemoteIP'],$_SESSION['RemoteHost'],"DELETED LISTISTING REQUEST RECORD",$_SESSION['LogID']);
				}	
			}
		}else
		{
			$ret=array('status'=>'FAIL','Message'=>"Could Not Delete Listing Request Record. Record Does Not Exist.",'rowcount'=>0);
		}
		
		echo json_encode($ret);
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
						
			$ret=$this->getdata_model->GetMarketStatus();									
			$data['MarketStatus']=$ret['MarketStatus'];
			$data['ScrollingPrices']=$this->getdata_model->MarketData();
			
			$data['balance']=$this->getdata_model->GetWalletBalance($data['email']);	
			
			$rw=$this->getdata_model->GetIssuerDetails($data['email']); //Issuer Details
			
			if ($rw->uid) $data['uid'] = $rw->uid; else $data['uid']='';
			if ($rw->user_name) $data['company'] = $rw->user_name; else $data['company']='';
						
			$set=$this->getdata_model->GetParamaters();
				
			if (intval($set->refreshinterval) > 0)
			{
				$data['RefreshInterval'] = $set->refreshinterval;
			}else
			{
				$data['RefreshInterval']=5;
			}
						
			$this->load->view('ui/requestlisting_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('');
		}
	}
}
