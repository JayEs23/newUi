<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Derived Homes - Approve Listing</title>
    <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Naija Art Mart - The New Art Market For Everyone">    
    <meta name="msapplication-tap-highlight" content="no"><!-- Disable tap highlight on IE -->

	<?php include('header.php'); ?>
    <?php include('scripts.php'); ?>

	 <style>
    	/* DivTable.com */
				
		.divTableCell, .divTableHead {
			border: 0px solid #ffffff;
			/*display: table-cell;
			padding: 3px 10px;*/
			text-align: center;
		}
			
		@media (max-width: 320px) { 
			.divTableCell {
				width: 100%;
			}
		}
		
		.modal-content {
		  background-color: #fefefe;
		  margin: 10% auto; /* 15% from the top and centered */
		  padding: 10px;
		  border: 1px solid #888;/*888*/
		  position: relative;
		  margin-top:30px;
		  width: 100%; /* Could be more or less, depending on screen size */
		}

		
		/* The Close Button */
		.close {
		  /*color: #fefefe;*/
		  float: right;
		  font-size: 28px;
		  font-weight: bold;
		}
		
		.close:hover,
		.close:focus {
		  color: yellow;
		  text-decoration: none;
		  cursor: pointer;
		}
    </style>

	<script type = "text/javascript">
	
	var Title='<font color="#AF4442">Naija Art Mart Message</font>';
	var Email='<?php echo $email; ?>';
	var emptypix='<?php echo base_url(); ?>images/empty.jpg';
	var m='',table;
	
	function DisplayMessage(msg,msgtype,msgtitle,theme='AlertTheme')
	{
		try
		{//SuccessTheme, AlertTheme
			$('#divAlert').html(msg).addClass(theme);
			
			
			Swal.fire({
				  type: msgtype,
				  title: '<strong>'+msgtitle+'</strong>',
				  background: '#E2F3D4',
				  color: '#f00',
				  allowEscapeKey: false,
				  allowOutsideClick: false,
				  html: '<font color="#000000">'+msg+'</font>',
				  showCloseButton: true,
				  //footer: '<a href>Why do I have this issue?</a>'
				})
				
			//Swal.showLoading(); Swal.hideLoading() 
			
			//Swal.close()
			setTimeout(function() {
				$('#divAlert').load(location.href + " #divAlert").removeClass(theme);
			}, 10000);
		}catch(e)
		{
			alert('ERROR Displaying Message: '+e);
		}
	}
	
	$(document).ready(function(e) {
		
		$(function() {			
			$.blockUI.defaults.css = {};// clear out plugin default styling
		});
		
		$(document).ajaxStop($.unblockUI);
		
		$('.datepicker').datepicker({
			weekStart: 1,
			todayBtn:  "linked",
			autoclose: 1,
			todayHighlight: 1,
			maxViewMode: 4,
			clearBtn: 1,
			forceParse: 0,
			daysOfWeekHighlighted: "0,6",
			//daysOfWeekDisabled: "0,6",
			format: 'd M yyyy'
		});			

		$('#txtListingStart').datepicker({
			weekStart: 1,
			todayBtn:  "linked",
			autoclose: 1,
			todayHighlight: 1,
			maxViewMode: 4,
			clearBtn: 1,
			forceParse: 0,
			daysOfWeekHighlighted: "0,6",
			//daysOfWeekDisabled: "0,6",
			format: 'd M yyyy'
		});
		
		$('#txtListingEnd').datepicker({
			weekStart: 1,
			todayBtn:  "linked",
			autoclose: 1,
			todayHighlight: 1,
			maxViewMode: 4,
			clearBtn: 1,
			forceParse: 0,
			daysOfWeekHighlighted: "0,6",
			//daysOfWeekDisabled: "0,6",
			format: 'd M yyyy'
		});
		
		$('#txtListingStart').blur(function(e) {
			try
			{
				if ($('#txtListingStart').val() && $('#txtListingEnd').val())
				{
					VerifyStartAndEndDates();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="Listing Start Date Blur ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});
		
		$('#txtListingStart').change(function(e) {
			try
			{
				if ($('#txtListingStart').val() && $('#txtListingEnd').val())
				{
					VerifyStartAndEndDates();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="Listing Start Change ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}
		});
		
		$('#txtListingEnd').blur(function(e) {
			try
			{
				if ($('#txtListingStart').val() && $('#txtListingEnd').val())
				{
					VerifyStartAndEndDates();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="Listing End Date Blur ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}
		});
		
		$('#txtListingEnd').change(function(e) {
			try
			{
				if ($('#txtListingStart').val() && $('#txtListingEnd').val())
				{
					VerifyStartAndEndDates();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="Listing End Change ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}
		});
		
		$('#spnEndStar').hide();
		$('#spnStartStar').hide();
		
		function VerifyStartAndEndDates()
		{
			try
			{
				$('#divAlert').html('');
				
				var startdt=ChangeDateFrom_dMY_To_Ymd($('#txtListingStart').val());
				var enddt=ChangeDateFrom_dMY_To_Ymd($('#txtListingEnd').val());
				var sdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
				var edt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
				var d;
				
				if ($('#txtListingStart').val()=='0000-00-00') $('#txtListingStart').val('');
				if ($('#txtListingEnd').val()=='0000-00-00') $('#txtListingEnd').val('');
				
				if ($('#txtListingStart').val())
				{
					if (!sdt.isValid())
					{
						m="Listing Start Date Is Not Valid. Please Select A Valid Listing Start Date.";
						
						DisplayMessage(m, 'error',Title);
					}	
				}
				
				
				if ($('#txtListingEnd').val())
				{
					if (!edt.isValid())
					{
						m="Listing End Date Is Not Valid. Please Select A Valid Listing End Date.";
						DisplayMessage(m, 'error',Title);
					}	
				}
				
									
				//moment('2010-10-20').isSameOrBefore('2010-10-21');  // true				
				var dys=edt.diff(sdt, 'days') //If this -ve invalid date entries. Delivery earlier than pickup
				var diff = moment.duration(edt.diff(sdt));
				var mins = parseInt(diff.asMinutes());
				
				
				if (dys<0)
				{
					$('#txtListingEnd').val('');
										
					m="Listing End Date Is Before Listing Start Date. Please Correct Your Entries!";
					DisplayMessage(m, 'error',Title);
				}
			}catch(e)
			{
				$.unblockUI();
				m="VerifyStartAndEndDates ERROR:\n"+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
		}
		
		document.getElementById('btnDecline').disabled=true;
		document.getElementById('btnApprove').disabled=false;	
				
		$('#imgPix1').prop('src',emptypix);	$('#imgPix2').prop('src',emptypix);
		$('#imgPix3').prop('src',emptypix);	$('#imgPix4').prop('src',emptypix);
		
		LoadListings();
		
		$('#btnApprove').click(function(e)
		{
			try
			{
				$('#divAlert').html('');			
				if (!CheckApprove()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Approve Listing Button Click ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		});//btnApprove Click Ends
		
		$('#btnDecline').click(function(e) {
			try
			{					
				$('#divAlert').html('');
				
				if (!CheckDecline()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Decline Listing Button Click ERROR:\n'+e;					
				DisplayMessage(m, 'error',Title);
			}
		});//btnDecline Click Ends
		
		function CheckDecline()
		{
			try
			{				
				var issuer_id=$.trim($('#hidId').val());
				var aid=$.trim($('#hidArtId').val());
				var issuer_email=$.trim($('#hidEm').val());
				var nm=$.trim($('#txtArtist').val());
				var tit=$.trim($('#txtTitle').val());
				
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the declining of the listing request.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}				
								
				//Confirm Decline				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: "<font size='3' face='Arial'>Do you want to proceed with the declining of the listing request?</font>",
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Declining Listing Request. Please Wait...</p>",theme: false,baseZ: 2000});
					
					$.ajax({
						url: '<?php echo site_url('admin/Approvelisting/Decline'); ?>',
						data: {email:Email,issuer_id:issuer_id,issuer_email:issuer_email,artist:nm,art_id:aid,title:tit},
						type: 'POST',
						dataType: 'json',
						success: function(data,status,xhr) {				
							$.unblockUI();
							
							if ($(data).length > 0)
							{
								$.each($(data), function(i,e)
								{
									if ($.trim(e.status).toUpperCase() == 'OK')
									{
										if ($.trim(e.Message) == '')
										{
											m="Listing request has been declined successfully.";
										}else
										{
											m=e.Message;
										}								
										
										DisplayMessage(m, 'success','Declined Listing Request','SuccessTheme');
										
										ResetControls();
										LoadListings();	
										
										AdminActivateTab('view');
									}else
									{
										m=e.Message;
										
										DisplayMessage(m, 'error',Title);	
									}
									
									return;
								});//End each
							}
						},
						error:  function(xhr,status,error) {
							m='Error '+ xhr.status + ' Occurred: ' + error
							DisplayMessage(m,'error',Title);
						}
					});
				  }
				})
			}catch(e)
			{
				$.unblockUI();
				m='CheckDecline ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End CheckDecline
		
		function CheckApprove()
		{
			try
			{
				var sym=$.trim($('#txtSymbol').val());
				var val=$.trim($('#txtValue').val()).replace(new RegExp(',', 'g'), '');			
				var tok=$.trim($('#txtTokens').val()).replace(new RegExp(',', 'g'), '');				
				var pr=$.trim($('#txtTokenPrice').val()).replace(new RegExp(',', 'g'), '');		
				var sale=$.trim($('#txtTokensForSale').val()).replace(new RegExp(',', 'g'), '');
				var per=$.trim($('#txtPercentTokens').val()).replace(new RegExp(',', 'g'), '');	
				
				var startdt=ChangeDateFrom_dMY_To_Ymd($('#txtListingStart').val());
				var enddt=ChangeDateFrom_dMY_To_Ymd($('#txtListingEnd').val());
				var pdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
				var ddt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
				var p=$.trim($('#txtListingStart').val());
				var d=$.trim($('#txtListingEnd').val());
				
				var issuer_id=$.trim($('#hidId').val());
				var aid=$.trim($('#hidArtId').val());
				var issuer_email=$.trim($('#hidEm').val());
				var nm=$.trim($('#txtArtist').val());
				var tit=$.trim($('#txtTitle').val());
				
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the approving of listing request.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}
								
				//Symbol
				if (!sym)
				{
					m='Artwork symbol field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtSymbol').focus();
					AdminActivateTab('data'); return false;
				}
				
				if ($.isNumeric(sym))
				{
					m='Artwork symbol field must not be a number.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtSymbol').focus();
					AdminActivateTab('data'); return false;
				}
				
				if (sym.length<3)
				{
					m='Entered artwork symbol is too short.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtSymbol').focus();
					AdminActivateTab('data'); return false;
				}
				
				//Artwork Value
				if (!val)
				{
					m='Artwork value field must not be blank.';						
					DisplayMessage(m, 'error',Title);						
					AdminActivateTab('data'); return false;		
				}
				
				if (!$.isNumeric(val))
				{
					m='Artwork value field must be a number.';					
					DisplayMessage(m, 'error',Title);					
					AdminActivateTab('data'); return false;
				}
				
				if (parseFloat(val) == 0)
				{
					m='Artwork value must not be zero.';				
					DisplayMessage(m, 'error',Title);
					AdminActivateTab('data'); return false;
				}
				
				if (parseFloat(val) < 0)
				{
					m='Artwork value must not be a negative number.';				
					DisplayMessage(m, 'error',Title);
					AdminActivateTab('data'); return false;
				}
				
				//Tokens
				if (!tok)
				{
					m='Number of artwork tokens field must not be blank.';						
					DisplayMessage(m, 'error',Title);						
					AdminActivateTab('data'); return false;		
				}
				
				if (!$.isNumeric(tok))
				{
					m='Number of artwork tokens field must be a number.';					
					DisplayMessage(m, 'error',Title);					
					AdminActivateTab('data'); return false;
				}
				
				if (parseInt(tok) == 0)
				{
					m='Number of artwork tokens must not be zero.';				
					DisplayMessage(m, 'error',Title);
					AdminActivateTab('data'); return false;
				}
				
				if (parseInt(tok) < 0)
				{
					m='Number of artwork tokens must not be a negative number.';				
					DisplayMessage(m, 'error',Title);
					AdminActivateTab('data'); return false;
				}
				
				//Price/Token
				if (!pr)
				{
					m='Artwork price per token field must not be blank.';						
					DisplayMessage(m, 'error',Title);						
					AdminActivateTab('data'); return false;		
				}
				
				if (!$.isNumeric(pr))
				{
					m='Artwork price per token field must be a number.';					
					DisplayMessage(m, 'error',Title);					
					AdminActivateTab('data'); return false;
				}
				
				if (parseFloat(pr) == 0)
				{
					m='Artwork price per token must not be zero.';				
					DisplayMessage(m, 'error',Title);
					AdminActivateTab('data'); return false;
				}
				
				if (parseFloat(pr) < 0)
				{
					m='Artwork price per token must not be a negative number.';				
					DisplayMessage(m, 'error',Title);
					AdminActivateTab('data'); return false;
				}
				
				//Tokens For Sale
				if (!sale)
				{
					m='Number of artwork tokens for sale field must not be blank. Enter the percentage of the artworks token for sale (value is from 1 to 100).';						
					DisplayMessage(m, 'error',Title);						
					AdminActivateTab('data'); return false;		
				}
				
				if (!$.isNumeric(sale))
				{
					m='Number of artwork tokens for sale field must be a number. Enter the percentage of the artworks token for sale (value is from 1 to 100).';					
					DisplayMessage(m, 'error',Title);					
					AdminActivateTab('data'); return false;
				}
				
				if (parseInt(sale) <= 0)
				{
					m='Number of artwork tokens for sale must be greater than zero. Enter the percentage of the artworks token for sale (value is from 1 to 100).';				
					DisplayMessage(m, 'error',Title);
					AdminActivateTab('data'); return false;
				}
				
				//Listing Start Date
				if (!p)
				{
					m='You have not selected the listing start date.';					
					DisplayMessage(m, 'error',Title);
					AdminActivateTab('data'); return false; 
				}
								
				if (!d)
				{
					m='You have not selected the listing end date.';
					
					DisplayMessage(m, 'error',Title);
					AdminActivateTab('data'); return false; 
				}
					
				if (!p && d)
				{
					m='You have selected the listing end date. Listing start date field must also be selected.';					
					DisplayMessage(m, 'error',Title);
					AdminActivateTab('data'); return false; 
				}
				
				//Listing End Date
				if (p && !d)
				{
					m='You have selected the listing start date. Listing end date field must also be selected.';					
					DisplayMessage(m, 'error',Title);
					AdminActivateTab('data'); return false; 
				}
					
				if (p)
				{
					if (!pdt.isValid())
					{
						m="Listing Start Date Is Not Valid. Please Select A Valid Listing Start Date";
						DisplayMessage(m, 'error',Title);
						AdminActivateTab('data'); return false;
					}	
				}
					
				if (d)
				{
					if (!ddt.isValid())
					{
						m="Listing End Date Is Not Valid. Please Select A Valid Listing End Date";
						DisplayMessage(m, 'error',Title);						
						AdminActivateTab('data'); return false;
					}	
				}
								
				if (p && d)
				{
					var dys=ddt.diff(pdt, 'days') //If this -ve invalid date entries. Delivery earlier than pickup
					
					if (dys<0)
					{
						m="Listing End Date Is Before The Listing Start Date. Please Correct Your Entries!";						DisplayMessage(m, 'error',Title);
						AdminActivateTab('data'); return false;
					}
				}
				
				//Confirm Approval				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: "<font size='3' face='Arial'>Do you want to proceed with the approval of listing request?</font>",
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Approving Listing Request. Please Wait...</p>",theme: false,baseZ: 2000});
										
					//Initiate POST
					var uri = "<?php echo site_url('admin/Approvelisting/Approve'); ?>";
					var xhr = new XMLHttpRequest();
					var fd = new FormData();
					
					xhr.open("POST", uri, true);
					
					xhr.onreadystatechange = function() {
						if (xhr.readyState == 4 && xhr.status == 200)
						{
							// Handle response.
							$.unblockUI();
							
							var res = JSON.parse(xhr.responseText);
							
							if ($.trim(res.status).toUpperCase()=='OK')
							{
								if ($.trim(res.Message) != '')
								{
									m=res.Message;
								}else
								{
									m="Listing request has been approved successfully.";
								}								
								
								DisplayMessage(m, 'success','Approved Listing Request','SuccessTheme');
								
								ResetControls();
								LoadListings();	
								AdminActivateTab('view');																						
							}else
							{
								m=res.Message;
								DisplayMessage(m, 'error',Title);
							}
						}
					};

					fd.append('email', Email);
					fd.append('issuer_id', issuer_id);
					fd.append('issuer_email', issuer_email);
					fd.append('artist', nm);
					fd.append('art_id', aid);
					fd.append('title', TitleCase(tit));
					fd.append('symbol', sym.toUpperCase());
					fd.append('artwork_value', val);
					fd.append('tokens', tok);
					fd.append('tokens_for_sale', sale);
					fd.append('price_per_token', pr);
					fd.append('listing_starts', startdt);
					fd.append('listing_ends', enddt);
																									
					xhr.send(fd);// Initiate a multipart/form-data upload
				  }
				})	
			}catch(e)
			{
				$.unblockUI();
				m='CheckApprove ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End CheckApprove
		
		$('#imgPix1').click(function(e) {
            try
			{
				var img = document.getElementById('imgPix1');
				var modalImg = document.getElementById("img01");				
							
				if (img.src=='<?php echo base_url(); ?>images/empty.jpg') return;
				
				modalImg.src = img.src;
				var c=$.trim($('#txtTitle').val());
				
				if (c) c = c+': Picture 1'; else c = 'Picture 1';
				
				$("#modPixTitle").html(TitleCase(c)); 
			}catch(e)
			{
				$.unblockUI();
				m='Image 1 Click ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
        });
		
		$('#imgPix2').click(function(e) {
            try
			{
				var img = document.getElementById('imgPix2');
				var modalImg = document.getElementById("img01");				
							
				if (img.src=='<?php echo base_url(); ?>images/empty.jpg') return;
				
				modalImg.src = img.src;
				var c=$.trim($('#txtTitle').val());
				
				if (c) c = c+': Picture 2'; else c = 'Picture 2';
				
				$("#modPixTitle").html(TitleCase(c)); 
			}catch(e)
			{
				$.unblockUI();
				m='Image 2 Click ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
        });
		
		$('#imgPix3').click(function(e) {
            try
			{
				var img = document.getElementById('imgPix3');
				var modalImg = document.getElementById("img01");				
							
				if (img.src=='<?php echo base_url(); ?>images/empty.jpg') return;
				
				modalImg.src = img.src;
				var c=$.trim($('#txtTitle').val());
				
				if (c) c = c+': Picture 3'; else c = 'Picture 3';
				
				$("#modPixTitle").html(TitleCase(c)); 
			}catch(e)
			{
				$.unblockUI();
				m='Image 3 Click ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
        });
		
		$('#imgPix4').click(function(e) {
            try
			{
				var img = document.getElementById('imgPix4');
				var modalImg = document.getElementById("img01");				
							
				if (img.src=='<?php echo base_url(); ?>images/empty.jpg') return;
				
				modalImg.src = img.src;
				var c=$.trim($('#txtTitle').val());
				
				if (c) c = c+': Picture 4'; else c = 'Picture 4';
				
				$("#modPixTitle").html(TitleCase(c)); 
			}catch(e)
			{
				$.unblockUI();
				m='Image 4 Click ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
        });

    });//Document Ready
	
	function ViewRow(em,artist,aid,tit,sym,cyr,dim,mat,des,doc,loc,tval,tok,sale,pr,sdt,edt,p1,p2,p3,p4,sta,adt,issuer_id,url)
	{
		try
		{
			ResetControls();

			$('#txtArtist').val(artist);
			$('#txtCreationYear').val(cyr);	
			$('#txtTitle').val(tit);
			$('#txtDescription').val(des);					
			$('#txtMaterials').val(mat);
			$('#txtDimension').val(dim);
			$('#txtLocation').val(loc);	
			
			if (url)
			{
				$('#ancBlockchainUrl').html(url);
				$('#ancBlockchainUrl').prop('href',url).prop('title',"Click To View Asset Blockchain Details");
			}

			$('#txtSymbol').val(sym);
			$('#txtListingStatus').val(sta);		
			$('#txtValue').val(number_format(tval,2,'.',','));
			$('#txtApprovalDate').val(adt);
			$('#txtTokens').val(number_format(tok,0,'',','));
			$('#txtTokenPrice').val(number_format(pr,2,'.',','));	
			
			$('#txtTokensForSale').val(number_format(sale,0,'',','));
				
			if (parseFloat(tok) != 0)
			{
				var p=parseFloat(sale)/parseFloat(tok) * 100;
				$('#txtPercentTokens').val(number_format(p,2,'.',','));	
			}else
			{
				$('#txtPercentTokens').val('0.00');	
			}
			
			$('#txtListingStart').val(sdt);
			$('#txtListingEnd').val(edt);
			
			var path='<?php echo base_url()."art-works/"; ?>';
			
			if (p1) $('#imgPix1').css('cursor','pointer').attr({'data-toggle':'modal','data-target':'.bd-example-modal-lg', 'data-backdrop':'static','data-keyboard':'false','data-fadeDuration':'1000', 'data-fadeDelay':'0.50','src':path+p1});
			
			if (p2) $('#imgPix2').css('cursor','pointer').attr({'data-toggle':'modal','data-target':'.bd-example-modal-lg', 'data-backdrop':'static','data-keyboard':'false','data-fadeDuration':'1000', 'data-fadeDelay':'0.50','src':path+p2});
			
			if (p3) $('#imgPix3').css('cursor','pointer').attr({'data-toggle':'modal','data-target':'.bd-example-modal-lg', 'data-backdrop':'static','data-keyboard':'false','data-fadeDuration':'1000', 'data-fadeDelay':'0.50','src':path+p3});
			
			if (p4) $('#imgPix4').css('cursor','pointer').attr({'data-toggle':'modal','data-target':'.bd-example-modal-lg', 'data-backdrop':'static','data-keyboard':'false','data-fadeDuration':'1000', 'data-fadeDelay':'0.50','src':path+p4});
			
			
			$('#divPdfViewer').html('');
			
			LoadPDFFile(path+'docs/'+doc);								
			
			$('#hidId').val(issuer_id);
			$('#hidArtId').val(aid);
			$('#hidEm').val(em);
			
			if ($.trim(sta).toUpperCase() == 'AWAITING APPROVAL')
			{
				document.getElementById('btnDecline').disabled=false;
				document.getElementById('btnApprove').disabled=false;
				
				$('#btnApprove').show();
				$('#btnDecline').show();
				$('#spnEndStar').show();
				$('#spnStartStar').show();
			}else
			{
				document.getElementById('btnDecline').disabled=true;
				document.getElementById('btnApprove').disabled=true;
				
				$('#btnApprove').hide();
				$('#btnDecline').hide();
				$('#spnEndStar').hide();
				$('#spnStartStar').hide();
			}

			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m='ViewRow ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}

	function ResetControls()
	{
		try
		{					
			document.getElementById('btnDecline').disabled=true;
			document.getElementById('btnApprove').disabled=false;
			
			$('#txtArtist').val('');
			$('#txtCreationYear').val('');	
			$('#txtTitle').val('');
			$('#txtDescription').val('');					
			$('#txtMaterials').val('');
			$('#txtDimension').val('');
			$('#txtLocation').val('');	
			
			$('#ancBlockchainUrl').html('').prop('href','').prop('title','');
			$('#ancBlockchainUrl').removeAttr('href');
					
			$('#txtSymbol').val('');
			$('#txtListingStatus').val('');		
			$('#txtValue').val('');
			$('#txtApprovalDate').val('');
			$('#txtTokens').val('');
			$('#txtTokenPrice').val('');	
			
			$('#txtTokensForSale').val('');
			$('#txtPercentTokens').val('');
			
			$('#txtListingStart').val('');
			$('#txtListingEnd').val('');				
			
			$('#imgPix1').prop('src',emptypix).css('cursor','default');
			$('#imgPix2').prop('src',emptypix).css('cursor','default');
			$('#imgPix3').prop('src',emptypix).css('cursor','default');
			$('#imgPix4').prop('src',emptypix).css('cursor','default');
			
						
			$('#hidArtId').val('');
			$('#hidId').val('');
			$('#hidEm').val('');
			
			$('#btnApprove').hide();
			$('#btnDecline').hide();
			$('#spnEndStar').hide();
			$('#spnStartStar').hide();
			
			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m="ResetControls ERROR:\n"+e;
			DisplayMessage(m,'error',Title);
		}
	}//End ResetControls
	
	function LoadListings()
	{
		try
		{			
			$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Loading Listings. Please Wait...</p>",theme: false,baseZ: 2000});
			
			$('#recorddisplay > tbody').html('');
			
			$.ajax({
				url: "<?php echo site_url('admin/Approvelisting/GetListings');?>",
				type: 'POST',
				dataType: 'json',
				success: function(dataSet,status,xhr) {	
					$.unblockUI();
					
					if (table) table.destroy();
					
					//f-filtering, l-length, i-information, p-pagination
					table = $('#recorddisplay').DataTable( {
						dom: '<"top"if>rt<"bottom"lp><"clear">',
						responsive: true,
						ordering: false,
						autoWidth:false,
						language: {zeroRecords: "No Listing Record Found"},
						lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
						columnDefs: [
							{
								"targets": [ 0,1,2,3,4,5,6,7,8 ],
								"visible": true
							},
							{
								"targets": [ 1,2,3,4,5,6,7 ],
								"orderable": true,
								"searchable": true
							},
							{
								"targets": [ 0,8 ],
								"orderable": false,
								"searchable": false
							},
							{ className: "dt-center", "targets": [ 0,1,3,5,6,7,8 ] },
							{ className: "dt-right", "targets": [ 2,4 ] }
						],					
						order: [[ 7, 'asc' ]],
						data: dataSet, 
						columns: [
							{ width: "8%" },//Picture
							{ width: "26%" },//Title
							{ width: "12%" },//Value
							{ width: "8%" }, //Tokens
							{ width: "10%" }, //Price/Token
							{ width: "9%" }, //Listing Starts
							{ width: "9%" }, //Listing Ends
							{ width: "14%" }, //Status
							{ width: "4" } //Select
						]
					} );

					//AdminActivateTab('view');		
				},
				error:  function(xhr,status,error) {
					$.unblockUI();
					m='Error '+ xhr.status + ' Occurred: ' + error;
					DisplayMessage(m,'error',Title);
				}
			});
		}catch(e)
		{
			$.unblockUI();
			m='LoadListings ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}
	
	
	function LoadPDFFile(fn) 
	{
		try
		{
			var scale = 1.5;
			var pageStarts = new Array();
			pageStarts[0] = 0;
			
			var loadingTask = pdfjsLib.getDocument(fn);
	
			loadingTask.promise.then(function(pdf)
			{
				viewer = document.getElementById('divPdfViewer');							
				
				for(var pg = 1; pg <= pdf.numPages; pg++)
				{
					pdf.getPage(pg).then(function(page)
					{
						
						var viewport = page.getViewport({scale: scale,});					
						var canvas = document.createElement( "canvas" );
						canvas.style.display = "block";
						
						var context = canvas.getContext('2d');
						canvas.height += viewport.height;
						canvas.width = viewport.width;
		
						var renderContext = {canvasContext: context,viewport: viewport};
						page.render(renderContext);
						
						viewer.appendChild(canvas); 
					});
				}
			});
		}catch(e)
		{
			$.unblockUI();
			m='LoadPDFFile ERROR:\n'+e;
			DisplayMessage(m, 'error','Request Listing');
		}
	}
	
    </script>
</head>
<body>

<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    <?php include('dheader.php'); //Dashboard Header ?>
    
    
    <div class="app-main">
          	<?php include('sidemenu.php'); //Side Menu ?>
            
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title" style="padding:5px">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div>
                                    
                                    <div class="page-title-subheading opacity-10">
                                        <nav class="" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item">
                                                    <a>
                                                        <i aria-hidden="true" class="fa fa-home"></i>
                                                    </a>
                                                </li>
                                                <li class="active breadcrumb-item">
                                                    <a href="<?php echo site_url('admin/Dashboard'); ?>">Dashboards</a>
                                                </li>
                                                <li class="breadcrumb-item" aria-current="page">
                                                    Approve Listing Requests
                                                </li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    
                    <ul class="body-tabs-layout tabs-animated body-tabs-animated nav">
                        <li class="nav-item">
                            <a role="tab" class="nav-link active" id="tabView" data-toggle="tab" href="#view">
                                <span>Listing Requests</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabData" data-toggle="tab" href="#data">
                                <span>Listing Data</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabDetails" data-toggle="tab" href="#details">
                                <span>Artwork Details</span>
                            </a>
                        </li>
                        
                         <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabUpload" data-toggle="tab" href="#upload">
                                <span>Art Uploads</span>
                            </a>
                        </li> 
                        
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabUpload" data-toggle="tab" href="#pdf">
                                <span>Art PDF Document</span>
                            </a>
                        </li>                         
                        
                        <li onClick="window.location.reload(true);" class="nav-item">
                            <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#refresh">
                                <span>Refresh</span>
                            </a>
                        </li>
                    </ul>
                    
                    
                    <div class="tab-content">
                    	 <!--Request Tab-->
                        <div class="tab-pane tabs-animation fade show active" id="view" role="tabpanel">
                        	<div class="row">
                            	<div class="col-md-12">
                                	<div class="mb-3 card">
                                        <div class="card-body">
                                            <table class="hover table table-bordered data-table display wrap" id="recorddisplay">
                                              <thead>
                                                <tr>
                                                    <th style="text-align:center" width="10%">PICTURE</th>
                                                    <th style="text-align:center" width="21%">PROPERTY TITLE</th>
                                                    <th style="text-align:right; padding-right:10px;" width="10%">VALUE&nbsp;(&#8358;)</th> 
                                                    <th style="text-align:center" width="10%">TOKENS</th>
                                                    <th style="text-align:right; padding-right:10px;" width="10%">PRICE/TOKEN&nbsp;(&#8358;)</th>
                                                    <th style="text-align:center" width="11%">LISTING&nbsp;STARTS</th>
                                                    <th style="text-align:center" width="11%">LISTING&nbsp;ENDS</th>
                                                    <th style="text-align:center" width="13%">STATUS</th>
                                                    <th style="text-align:center" width="4%">VIEW</th>
                                                </tr>
                                              </thead>
                    
                                              <tbody id="tbbody"></tbody>
                                            </table>                                           
                                        </div>
                                    </div> 
                                </div>
                            </div>                            
                        </div>
                       
                       	 <!--Request Data Tab-->
                        <div class="tab-pane tabs-animation fade" id="data" role="tabpanel">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <input type="hidden" id="hidArtId" />
                                    <input type="hidden" id="hidId" />
                                    <input type="hidden" id="hidEm" />
                                    
                                	<form class="">
                                    	<!--Art Title-->
                                         <div title="Artwork Title" class="position-relative row form-group">
                                            <label for="txtTitle" class="col-sm-2 col-form-label nsegreen">Art Title<span class="redtext">*</span></label>
                                        
                                            <div class="col-sm-10">
                                                <input style="background:#F5F5F5; color:#000000; cursor:default;" readonly id="txtTitle" placeholder="Artwork Title" type="text" class="form-control makebold">
                                            </div>
                                         </div>
                                                                          
                                        <!--Symbol-->
                                        <div class="position-relative row form-group">
                                            <label title="Artwork Symbol" for="txtSymbol" class="col-sm-2 col-form-label nsegreen">Artwork symbol</label>
                                        
                                            <div title="Artwork Symbol" class="col-sm-4">
                                                <input style="text-transform:uppercase;" id="txtSymbol" placeholder="Artwork symbol" type="text" class="form-control">
                                            </div>
                                            
                                            <!--Listing Status-->
                                            <label title="Listing Status" for="txtListingStatus" class="col-sm-2 col-form-label nsegreen text-right">Listing Status</label>
                                             
                                             <div title="Listing Status" class="col-sm-4">
                                                <input style="background:#ffffff; color:#ff0000; cursor:default;" readonly class="form-control" type="text" id="txtListingStatus" placeholder="Listing Status">                                               
                                             </div>
                                         </div>
                                        
                                        <!--Art Value-->
                                        <div class="position-relative row form-group">
                                            <label title="Artwork Value" for="txtValue" class="col-sm-2 col-form-label nsegreen">Artwork Value<span class="redtext">*</span></label>
                                        
                                            
                                            <div title="Artwork Value" class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                                                    
                                                     <input min="0" type="text" id="txtValue" placeholder="Artwork Value" class="form-control">
                                                </div>
                                            </div>
                                            
                                            <!--Approval Date-->
                                            <label title="Listing Approval Date" for="txtApprovalDate" class="col-sm-2 col-form-label nsegreen text-right">Approval Date</label>
                                             
                                             <div title="Listing Approval Date" class="col-sm-4">
                                                <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtApprovalDate" placeholder="Listing Approval Date">                                               
                                             </div>
                                         </div>
                                         
                                         <!--No Of Tokens/Price Per Token-->
                                        <div class="position-relative row form-group">
                                        	<!--No Of Tokens-->
                                             <label title="Number Of Tokens" for="txtTokens" class="col-sm-2 col-form-label nsegreen">No Of Tokens<span class="redtext">*</span></label>
                                            
                                            <div title="Number Of Tokens" class="col-sm-4">
                                                <input min="0" type="text" class="form-control" placeholder="No Of Tokens" id="txtTokens">
                                            </div>
                                            
                                             <!--Price Per Token-->
                                            <label title="Artwork Price Per Token" for="txtTokenPrice" class="col-sm-2 col-form-label nsegreen text-right">Price Per Token<span class="redtext">*</span></label>
                                        
                                            
                                            <div title="Artwork Price Per Token" class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                                                    
                                                     <input min="0" type="text" id="txtTokenPrice" placeholder="Price Per Token" class="form-control">
                                                </div>
                                            </div>
                                         </div>   
                                         
                                         <!--Percentage Of Tokens For Sale/Tokens For Sale-->
                                         <div class="position-relative row form-group">
                                         	<!--Percentage Of Tokens For Sale-->
                                            <label title="Number Of Tokens" for="txtPercentTokens" class="col-sm-2 col-form-label nsegreen">Tokens For Sale (%)<span class="redtext">*</span></label>
                                            
                                            <div title="Percentage Of Tokens For Sale" class="col-sm-4">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Percentage Of Tokens For Sale" id="txtPercentTokens">
                                                    
                                                    <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">%</button></span>
                                            	</div>
                                            </div>
                                            
                                            <!--Tokens For Sale-->
                                            <label title="Tokens For Sale" for="txtTokensForSale" class="col-sm-2 col-form-label nsegreen text-right">Tokens For Sale<span class="redtext">*</span></label>
                                             <div title="Tokens For Sale" class="col-sm-4">
                                                <input min="0" type="text" id="txtTokensForSale" placeholder="Tokens For Sale" class="form-control">
                                            </div>
                                         </div>
                                         
                                         <!--Listing Start Date/Listing End Date-->
                                         <div class="position-relative row form-group">
                                         <!--Listing Start Date-->
                                             <label title="Listing Start Date" for="txtListingStart" class="col-sm-2 col-form-label nsegreen">Listing Start Date<span id="spnStartStar" class="redtext">*</span></label>
                                             
                                             <div title="Listing Start Date" class="col-sm-4 date datepicker">
                                             	 <div class="input-group">
                                                    <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtListingStart" placeholder="Listing Start Date">
                                                    
                                                    <span class="input-group-btn"><button class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                                </div>
                                             </div>
                                             
                                             <!--Listing End Date-->
                                             <label title="Listing End Date" for="txtListingEnd" class="col-sm-2 col-form-label nsegreen text-right">Listing End Date<span id="spnEndStar" class="redtext">*</span></label>
                                             
                                             <div title="Listing End Date" class="col-sm-4 date datepicker">
                                             	<div class="input-group">
                                                    <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtListingEnd" placeholder="Listing End Date">                                               	
                                                    <span class="input-group-btn"><button class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                                </div>                                                
                                             </div>
                                         </div>      
                                         
                                         <!--Blockchain Url-->              
                                		<div title="Blockchain Url" class="position-relative row form-group">
                                             <label for="ancBlockchainUrl" class="col-sm-2 col-form-label nsegreen">Blockchain Url</label>
                                             
                                             <div title="" class="col-sm-10">
                                                <a style="border:none;" class="form-control" id="ancBlockchainUrl" target="_blank"></a>
                                             </div>
                                         </div>  
                                    
                                    </form>
                                </div>
                               
                                <!--Buttons-->
                                 <div class="card-footer">                                    
                                   <div class="col-sm-12" style="text-align:center">
                                  
                                        <button id="btnApprove" type="button" class="btn btn-nse-green makebold size-16">Approve Listing</button>
                                        
                                        <button style="margin-left:10px;" id="btnDecline" type="button" class="btn btn-danger makebold size-16">Decline Listing</button>
                                        
                                        <button style="margin-left:10px;" onClick="window.location.reload(true);" type="button" class="btn btn-info makebold size-16">Refresh</button>
                                    </div>                                     
                                 </div>                                
                            </div>
                        </div>
                        
                        <!--Details Tab-->
                        <div class="tab-pane tabs-animation fade" id="details" role="tabpanel">
                        	<div class="main-card mb-3 card">
                            	<div class="card-body">
                                	<form class="">
                                        <!--Artist/Creation Year-->
                                        <div title="Artist Name" class="position-relative row form-group">
                                            <label for="txtArtist" class="col-sm-2 col-form-label nsegreen">Artist Name<span class="redtext">*</span></label>
                                        
                                            <div class="col-sm-5">
                                                <input style="background:#F4F4F4; cursor:default;" readonly id="txtArtist" placeholder="Artist Name" type="text" class="form-control">
                                             </div>
                                             
                                             <!--Creation Year-->
                                             <label title="Artwork Creation Year" for="txtCreationYear" class="col-sm-2 col-form-label nsegreen text-right">Creation Year<span class="redtext">*</span></label>
                                             
                                             <div title="Artwork Creation Year" class="col-sm-3">
                                                <div class="input-group">
                                                    <input style="background:#F4F4F4; cursor:default;" readonly class="form-control" type="text" id="txtCreationYear" placeholder="Artwork Creation Year">
                                                </div>                                                
                                             </div>
                                        </div>                                       
                                  
                                     <!--Description-->
                                     <div title="Artwork Description" class="position-relative row form-group">
                                        <label for="txtDescription" class="col-sm-2 col-form-label nsegreen">Description<span class="redtext">*</span></label>
                                        
                                        <div class="col-sm-10">
                                            <textarea style="background:#F4F4F4; cursor:default;" readonly rows="3" id="txtDescription" placeholder="Artwork Description" class="form-control"></textarea>
                                        </div>                                          
                                     </div>
                                     
                                     
                                     <!--materials-->
                                     <div title="Materials Used For Artwork" class="position-relative row form-group">                                           <!--Materials-->
                                           <label for="txtMaterials" class="col-sm-2 col-form-label nsegreen">Materials<span class="redtext">*</span></label>
                                                
                                            <div class="col-sm-10">
                                               <textarea style="background:#F4F4F4; cursor:default;" readonly rows="3" id="txtMaterials" placeholder="Artwork Materials" class="form-control"></textarea>
                                           </div>
                                     </div>
                                     
                                         
                                       <!--Dimensions/Location-->
                                       <div class="position-relative row form-group">
                                         <!--Dimensions-->
                                         <label title="Artwork Dimensions" for="txtDimension" class="col-sm-2 col-form-label nsegreen">Artwork Dimensions<span class="redtext">*</span></label>
                                         
                                         <div title="Artwork Dimensions" class="col-sm-10">
                                            <input style="background:#F4F4F4; cursor:default;" readonly id="txtDimension" placeholder="Artwork Dimensions" type="text" class="form-control">
                                         </div>                              
                                     </div>
                                     
                                      <!--Dimensions/Location-->
                                       <div class="position-relative row form-group">
                                        <!--Location-->
                                           <label title="Artwork Display Location" for="txtLocation" class="col-sm-2 col-form-label nsegreen">Display Location<span class="redtext">*</span></label>
                                                
                                            <div class="col-sm-10">
                                               <input style="background:#F4F4F4; cursor:default;" readonly type="text" id="txtLocation" placeholder="Artwork Display Location" class="form-control">
                                           </div>
                                     </div>
                                
                                </form>
                                </div>
                            </div>
                        </div>
                        
                        <!--Uploads Tab-->
                        <div class="tab-pane tabs-animation fade" id="upload" role="tabpanel">
                        	<div class="main-card mb-3 card">
                            	<div class="card-body">
                                	<form class="">
                                    	
                                        <div class="position-relative row form-group">
                                            <!--Artwork Picture 1-->
                                             <label title="Upload art picture number one (jpg or png format)" for="imgPix1" class="col-sm-2 col-form-label nsegreen text-right">Art Picture 1<span class="redtext">*</span></label>
                                             
                                             <div class="col-sm-4">
                                                <img class="rounded img-thumbnail" id="imgPix1" style="height:160px; margin-top:10px; border:solid 2px;" />
                                             </div>
                                             
                                             <!--Artwork Picture 2-->
                                             <label title="Upload art picture number two (jpg or png format)" for="imgPix2" class="col-sm-2 col-form-label nsegreen text-right">Art Picture 2<span class="redtext">*</span></label>
                                             
                                             <div class="col-sm-4">
                                                <img class="rounded img-thumbnail" id="imgPix2" onclick="LoadPix('imgPix2','2');" style="height:160px; margin-top:10px;" />
                                             </div>
                                        </div>
                                        
                                        <!--Artwork Picture 3/Artwork Picture 4-->
                                        <div class="position-relative row form-group">
                                            <!--Artwork Picture 1-->
                                             <label title="Upload art picture number three (jpg or png format)" for="imgPix3" class="col-sm-2 col-form-label nsegreen text-right">Art Picture 3<span class="redtext">*</span></label>
                                             
                                             <div class="col-sm-4">
                                                <img class="rounded img-thumbnail" id="imgPix3" onclick="LoadPix('imgPix3','3');" style="height:160px; margin-top:10px;" />
                                             </div>
                                             
                                             <!--Artwork Picture 4-->
                                             <label title="Upload art picture number four (jpg or png format)" for="imgPix4" class="col-sm-2 col-form-label nsegreen text-right">Art Picture 4<span class="redtext">*</span></label>
                                             
                                             <div class="col-sm-4">
                                                <img class="rounded  img-thumbnail" id="imgPix4" onclick="LoadPix('imgPix4','4');" style="height:160px; margin-top:10px;" />
                                             </div>
                                        </div>                      
                                </form>
                                </div>
                                
                                
                            </div>
                        </div>
                        
                        <!--PDF Doc Tab-->
                        <div class="tab-pane tabs-animation fade" id="pdf" role="tabpanel">
                        	<div class="main-card mb-3 card">
                            	<div class="card-body">
                                	<form class="">                                    	
                                    	 <!--Documents-->
                                    	<div class="position-relative row form-group">
                                            <div class="col-sm-12">
                                            	<div id="divPdfViewer" style="max-height: 512px; overflow: auto;"></div>
                                            </div>
                                        </div>                          
                                </form>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>                                            
                </div>
                
                
                
                
                
                <!--Footer-->
               <?php include('footer.php'); ?>
           </div>
    </div>
</div>


<!--Start Pix Popup-->
<div id="myPixModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background-color:#000000; padding:0;">
          <div class="modal-header" style="background-color:#363131;">              
              <h4 style="color:#ffffff; margin-right:39px;" id="modPixTitle" class="modal-title">PICTURE</h4>
              <button title="Click X to close the picture screen" type="button" class="close" data-dismiss="modal">×</button>
          </div>
          
          <div align="center" class="modal-body" style="padding:1px;">
            <img class="modal-content" id="img01" style="margin-top:0; border:none; ">
          </div>
          
          <div class="modal-footer">
            <center><button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button></center>
          </div>
        </div>
      </div>
</div>

<!--End Pix Popup-->


<script type="text/javascript" src="<?php echo base_url();?>assets/js/main.8d288f825d8dffbbe55e.js"></script>
</body>
</html>
