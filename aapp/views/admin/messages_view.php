<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Naija Art Mart - Messages</title>
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
		
		
    </style>

  
	<script type="text/javascript">
	
	var Title='<font color="#AF4442">Naija Art Mart Message</font>';
	var Email='<?php echo $email; ?>';
	var m='',table;
	var divArea;
			
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
				
		$('#txtExpiryDate').datepicker({
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
		
		ResetControls();		
		LoadMessages();		
			
		if ('<?php echo $msgid; ?>')
		{
			//Controls
			$('#hidId').val('<?php echo $msgid; ?>');			
			$('#txtHeader').val('<?php echo urldecode($header); ?>');
			$('#divDetails').html('<?php echo urldecode($details); ?>');			
			$('#cboCategory').val('<?php echo $category; ?>');				
			$('#cboStatus').val('<?php echo $display_status; ?>');			
			$('#txtExpiryDate').val('<?php echo $expiredate; ?>');
			
			var recs='<?php echo $recipients; ?>';
			
			if ($.trim(recs).toLowerCase() == 'all')
			{
				$('#chkAll').prop('checked', true);
				$('#chkBrokers').prop('checked', true);
				$('#chkInvestors').prop('checked', true);
				$('#chkIssuers').prop('checked', true);
				$('#chkGallery').prop('checked', true);
			}else
			{
				if ($.trim(recs.toLowerCase()).indexOf('brokers') != -1) $('#chkBrokers').prop('checked', true);
				if ($.trim(recs.toLowerCase()).indexOf('investors') != -1) $('#chkInvestors').prop('checked', true);
				if ($.trim(recs.toLowerCase()).indexOf('issuers') != -1) $('#chkIssuers').prop('checked', true);
				if ($.trim(recs.toLowerCase()).indexOf('gallery') != -1) $('#chkGallery').prop('checked', true);
			}				
		}		
		
		
		$('#divDetails').dblclick(function(e) {
            try
			{ 	
				toggleArea1();
			}catch(e)
			{
				$.unblockUI();
				m='Double Click Text Editor ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
        });
		
		$('#btnEditor').click(function(e)
		{
			try
			{
				toggleArea1();
			}catch(e)
			{
				$.unblockUI();
				m='Editor Toggle Button Click ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		});
		
		function toggleArea1()
		{
			if (!divArea)
			{
				divArea = new nicEditor({maxHeight:'250px'},{buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','indent','outdent','fontFormat','subscript','superscript','strikethrough','removeformat','hr','forecolor','bgcolor','link','unlink']
	}).panelInstance('divDetails',{hasPanel : true});
	
				divArea.addEvent('focus', function() {
					
					if ($.trim($('#divDetails').html()).toLowerCase() == '[type your message here after double clicking in this space or clicking the enable button below]')
					{
						divArea.instanceById('divDetails').setContent('');
					}
				});
				
								
				$('#btnEditor').html('Click Here When You Have Finished Typing Your Message');
			}else
			{
				divArea.removeInstance('divDetails');
				divArea = null;
				//
				//var h=$.trim($('#divDetails').html().replace(new RegExp('&nbsp;', 'g'), ''));
			
				
				$('#btnEditor').html('Click To Enable Message Editor');
			}
		}
		
		$('#txtExpiryDate').blur(function(e) 
		{
			try
			{
				if ($('#txtExpiryDate').val()) VerifyExpiryDate();	
			}catch(e)
			{
				$.unblockUI();
				m="Message Expiry Date Blur ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});
		
		$('#txtExpiryDate').change(function(e) 
		{
			try
			{
				if ($('#txtExpiryDate').val()) VerifyExpiryDate();	
			}catch(e)
			{
				$.unblockUI();
				m="Message Expiry Date Change ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});
		
		function VerifyExpiryDate()
		{
			try
			{
				$('#divAlert').html('');
				
				var startdt='<?php echo date('Y-m-d'); ?>';
				var enddt=ChangeDateFrom_dMY_To_Ymd($('#txtExpiryDate').val());
				var sdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
				var edt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
				var d;
				
				if ($('#txtExpiryDate').val()=='0000-00-00') $('#txtExpiryDate').val('');
								
				if ($('#txtExpiryDate').val())
				{
					if (!edt.isValid())
					{
						m="Expiry Date Is Not Valid. Please Select A Valid Expiry Date.";
						DisplayMessage(m, 'error',Title);
					}	
				}
				
									
				//moment('2010-10-20').isSameOrBefore('2010-10-21');  // true				
				var dys=edt.diff(sdt, 'days') //If this -ve invalid date entries. Delivery earlier than pickup
				var diff = moment.duration(edt.diff(sdt));
				var mins = parseInt(diff.asMinutes());
				
				
				if (dys<0)
				{
					$('#txtExpiryDate').val('');
										
					m="Expiry Date Is In The Past. Please Correct Your Entry!";
					DisplayMessage(m, 'error',Title);
				}
			}catch(e)
			{
				$.unblockUI();
				m="VerifyExpiryDate ERROR:\n"+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
		}
		
		$('#btnSend').click(function(e)
		{
			try
			{ 	
				$('#divAlert').html('');			
				if (!CheckSend()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Send Message Button Click ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		});//btnSend Click Ends
		
		$('#btnEdit').click(function(e) {
			try
			{					
				$('#divAlert').html('');
				
				if (!CheckEdit()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Edit Message Button Click ERROR:\n'+e;					
				DisplayMessage(m, 'error',Title);
			}
		});//btnEdit Click Ends
		
		function CheckEdit()
		{
			try
			{
				var mid=$.trim($('#hidId').val());
				var cat=$.trim($('#cboCategory').val());
				var hd=$.trim($('#txtHeader').val());		
				var det=$.trim($('#divDetails').html().replace(new RegExp('&nbsp;', 'g'), ''));	
							
				var al = false, brok = false, inv  = false, iss  = false, gal  = false;
				var recs='';
				
				al = $('#chkAll').is(':checked');
				brok = $('#chkBrokers').is(':checked');
				inv  = $('#chkInvestors').is(':checked');
				iss  = $('#chkIssuers').is(':checked');
				gal  = $('#chkGallery').is(':checked');
								
				var edt=ChangeDateFrom_dMY_To_Ymd($('#txtExpiryDate').val());
				var ex=$.trim($('#txtExpiryDate').val());				
												
				var sta=$.trim($('#cboStatus').val());				
													
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the sending of message.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}
								
				//Header
				if (!hd)
				{
					m='Message header field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtHeader').focus(); return false;
				}
				
				if ($.isNumeric(hd))
				{
					m='Message header field must not be a number.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtHeader').focus(); return false;
				}
				
				if (hd.length<3)
				{
					m='Please enter a meaningful message header.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtHeader').focus(); return false;
				}
				
				//Message details
				if (!det)
				{
					m='Message details field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					return false;
				}
				
				if (det.length<2)
				{
					m='Please enter a meaningful message.';					
					DisplayMessage(m, 'error',Title);					
					return false;
				}
				
				//Recipient
				if ((al == false) && (brok==false) && (inv==false) && (iss==false) && (gal==false) && !cust)
				{
					m='You have not selected or entered any recipient.';
					DisplayMessage(m, 'error',Title);					
					return false;
				}			
											
				//Category
				if (!cat)
				{
					m='Please select the message category. Indicate if it is a trading message or a general news.';
					DisplayMessage(m, 'error',Title);					
					$('#cboCategory').focus(); return false;
				}		
				
				//Status
				if (!sta)
				{
					m="Please select message display status. Indicate if the message is to be displayed to recipient or not.";
					DisplayMessage(m, 'error',Title);					
					$('#cboStatus').focus(); return false;
				}
				
				//Get recipients
				
				if (al)
				{
					recs='All';
				}else
				{
					if (brok)
					{
						if (recs=='') recs='Brokers'; else recs += ',' + 'Brokers';
					}
					
					if (inv)
					{
						if (recs=='') recs='Investors'; else recs += ',' + 'Investors';
					}
					
					if (iss)
					{
						if (recs=='') recs='Issuers'; else recs += ',' + 'Issuers';
					}
					
					if (gal)
					{
						if (recs=='') recs='Gallery'; else recs += ',' + 'Gallery';
					}
				}
				
				if (ex=='') edt='';
				
				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: "<font size='3' face='Arial'>Do you want to proceed with the editing of the message?</font>",
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Editing Message. Please Wait...</p>",theme: false,baseZ: 2000});
															
					//Initiate POST
					var uri = "<?php echo site_url('admin/Messages/EditMessage'); ?>";
					var xhr = new XMLHttpRequest();
					var fd = new FormData();
					
					xhr.open("POST", uri, true);
					
					xhr.onreadystatechange = function() {
						if (xhr.readyState == 4 && xhr.status == 200)
						{
							$.unblockUI();
							
							var res = JSON.parse(xhr.responseText);
														
							if ($.trim(res.status).toUpperCase()=='OK')
							{
								m="Message has been edited successfully.";
								DisplayMessage(m, 'success','Message Edited','SuccessTheme');
								
								ResetControls();
								LoadMessages();																					
							}else
							{
								m=res.Message;								
								DisplayMessage(m, 'error',Title);
							}
						}
					};
				
					fd.append('header', hd);
					fd.append('details', det);
					fd.append('category', cat);
					fd.append('expiredate', edt);
					fd.append('recipients', recs);
					fd.append('display_status', sta);
					fd.append('email', Email);
					fd.append('msgid', mid);
																				
					xhr.send(fd);// Initiate a multipart/form-data upload
				  }
				})	
			}catch(e)
			{
				$.unblockUI();
				m='CheckEdit ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End CheckEdit
		
		function CheckSend()
		{
			try
			{
				var cat=$.trim($('#cboCategory').val());
				var hd=$.trim($('#txtHeader').val());		
				var det=$.trim($('#divDetails').html().replace(new RegExp('&nbsp;', 'g'), ''));	
							
				var al = false, brok = false, inv  = false, iss  = false, gal  = false;
				var recs='';
				
				al = $('#chkAll').is(':checked');
				brok = $('#chkBrokers').is(':checked');
				inv  = $('#chkInvestors').is(':checked');
				iss  = $('#chkIssuers').is(':checked');
				gal  = $('#chkGallery').is(':checked');
								
				var edt=ChangeDateFrom_dMY_To_Ymd($('#txtExpiryDate').val());
				var ex=$.trim($('#txtExpiryDate').val());				
												
				var sta=$.trim($('#cboStatus').val());				
													
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the sending of message.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}
								
				//Header
				if (!hd)
				{
					m='Message header field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtHeader').focus(); return false;
				}
				
				if ($.isNumeric(hd))
				{
					m='Message header field must not be a number.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtHeader').focus(); return false;
				}
				
				if (hd.length<3)
				{
					m='Please enter a meaningful message header.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtHeader').focus(); return false;
				}
				
				//Message details
				if (!det)
				{
					m='Message details field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					return false;
				}
				
				if (det.length<2)
				{
					m='Please enter a meaningful message.';					
					DisplayMessage(m, 'error',Title);					
					return false;
				}
				
				//Recipient
				if ((al == false) && (brok==false) && (inv==false) && (iss==false) && (gal==false) && !cust)
				{
					m='You have not selected or entered any recipient.';
					DisplayMessage(m, 'error',Title);					
					return false;
				}			
											
				//Category
				if (!cat)
				{
					m='Please select the message category. Indicate if it is a trading message or a general news.';
					DisplayMessage(m, 'error',Title);					
					$('#cboCategory').focus(); return false;
				}		
				
				//Status
				if (!sta)
				{
					m="Please select message display status. Indicate if the message is to be displayed to recipient or not.";
					DisplayMessage(m, 'error',Title);					
					$('#cboStatus').focus(); return false;
				}
				
				//Get recipients
				
				if (al)
				{
					recs='All';
				}else
				{
					if (brok)
					{
						if (recs=='') recs='Brokers'; else recs += ',' + 'Brokers';
					}
					
					if (inv)
					{
						if (recs=='') recs='Investors'; else recs += ',' + 'Investors';
					}
					
					if (iss)
					{
						if (recs=='') recs='Issuers'; else recs += ',' + 'Issuers';
					}
					
					if (gal)
					{
						if (recs=='') recs='Gallery'; else recs += ',' + 'Gallery';
					}
				}
				
				if (ex=='') edt='';
				
				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: "<font size='3' face='Arial'>Do you want to proceed with the sending of this message?</font>",
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Sending Message. Please Wait...</p>",theme: false,baseZ: 2000});
										
					//Initiate POST
					var uri = "<?php echo site_url('admin/Messages/SendMsg'); ?>";
					var xhr = new XMLHttpRequest();
					var fd = new FormData();
					
					xhr.open("POST", uri, true);
					
					xhr.onreadystatechange = function() {
						if (xhr.readyState == 4 && xhr.status == 200)
						{
							$.unblockUI();
							
							var res = JSON.parse(xhr.responseText);
							
							if ($.trim(res.status).toUpperCase()=='OK')
							{
								m="Message has been queued successfully.";
								DisplayMessage(m, 'success','Message Queued','SuccessTheme');
								
								ResetControls();
								LoadMessages();																							
							}else
							{
								m=res.Message;
								DisplayMessage(m, 'error',Title);
							}
						}
					};

					fd.append('header', hd);
					fd.append('details', det);
					fd.append('category', cat);
					fd.append('expiredate', edt);
					fd.append('recipients', recs);
					fd.append('display_status', sta);
					fd.append('email', Email);
																									
					xhr.send(fd);// Initiate a multipart/form-data upload
				  }
				})	
			}catch(e)
			{
				$.unblockUI();
				m='CheckSend ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End CheckSend
		
		
    });//Document Ready
	
	
	function LoadMessages()
	{
		try
		{
			$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Loading Messages. Please Wait...</p>",theme: false,baseZ: 2000});
			
			$('#recorddisplay > tbody').html('');
			
			$.ajax({
				url: '<?php echo site_url('admin/Messages/GetMessages'); ?>',
				type: 'POST',
				data: {email:Email},
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
						language: {zeroRecords: "No Message Record Found"},
						lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
						columnDefs: [
							{
								"targets": [ 0,1,2,3,4,5,6 ],
								"visible": true
							},
							{
								"targets": [ 0,1 ],
								"orderable": false,
								"searchable": false
							},
							{
								"targets": [ 2,3,4,5,6 ],
								"searchable": true
							},
							{ className: "dt-center", "targets": [ 0,1,2,3,4,5,6 ] }
						],					
						order: [[ 2, 'asc' ]],
						data: dataSet, 
						columns: [
							{ width: "4%" },//Select
							{ width: "4%" },//Delete
							{ width: "18%" },//Date
							{ width: "12%" },//Category
							{ width: "35%" },//Header
							{ width: "15%" },//Sender
							{ width: "12%" }//Status
						]
					} );
					
					//UiActivateTab('view');		
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
			m='LoadMessages ERROR:\n'+e;
			DisplayMessage(m, 'error',Title);
		}
	}

	function SelectRow(mid,hd,det,sender,dt,edt,cat,sta,recs)
	{
		try
		{
			ResetControls();
			
			if (document.getElementById('btnEdit')) document.getElementById('btnEdit').disabled=false;
			if (document.getElementById('btnSend')) document.getElementById('btnSend').disabled=true;

			$('#cboCategory').val(cat);
			$('#txtHeader').val(urldecode(hd));		
			$('#divDetails').html(urldecode(det));							
			$('#txtExpiryDate').val(edt);
			$('#cboStatus').val(sta);				
			$('#hidId').val(mid);
			
			if ($.trim(recs).toLowerCase() == 'all')
			{
				$('#chkAll').prop('checked', true);
				$('#chkBrokers').prop('checked', true);
				$('#chkInvestors').prop('checked', true);
				$('#chkIssuers').prop('checked', true);
				$('#chkGallery').prop('checked', true);
			}else
			{
				if ($.trim(recs.toLowerCase()).indexOf('brokers') != -1) $('#chkBrokers').prop('checked', true);
				if ($.trim(recs.toLowerCase()).indexOf('investors') != -1) $('#chkInvestors').prop('checked', true);
				if ($.trim(recs.toLowerCase()).indexOf('issuers') != -1) $('#chkIssuers').prop('checked', true);
				if ($.trim(recs.toLowerCase()).indexOf('gallery') != -1) $('#chkGallery').prop('checked', true);
			}

			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m='SelectRow ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}

	function DeleteRow(mid,hd,det,sender,dt,cat,sta,recs)
	{			
		try
		{
			if (!Email)
			{
				m='There is a problem with the selected row. Click on REFRESH button to refresh the page. If this message keeps coming up, please contact us at support@naijaartmart.com.';
				
				DisplayMessage(m,'error',Title);
				return false;
			}else
			{
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: "<font size='3' face='Arial'>Do you want to delete this message from the database?. Please note that this action is irreversible.</font>",
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Delete!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Deleting Message. Please Wait...</p>",theme: false,baseZ: 2000});
					
					$('#divAlert').html('');
					
					m=''
					
					//Make Ajax Request			
					$.ajax({
						url: '<?php echo site_url('admin/Messages/DeleteMessage'); ?>',
						data: {email:Email,msgid:mid},
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
										ResetControls();									
										LoadMessages();
										
										m='Broker was deleted successfully.';
										
										DisplayMessage(m, 'success','Broker Deleted','SuccessTheme');
								
										if (parseInt(e.rowcount) > 0)
										{
											activateTab('view');
										}else
										{
											activateTab('data');
										}
									}else
									{
										m=e.Message;
										
										DisplayMessage(m,'error',Title);		
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
			}
		}catch(e)
		{
			$.unblockUI();
			m='Delete Message Button Click ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}
	
	function ResetControls()
	{
		try
		{					
			if (document.getElementById('btnEdit')) document.getElementById('btnEdit').disabled=true;
			if (document.getElementById('btnSend')) document.getElementById('btnSend').disabled=false;
			
			$('#cboCategory').val('');
			$('#txtHeader').val('');		
			$('#divDetails').html('[Type your message here after double clicking in this space or clicking the enable button below]');	
						
			$('#chkAll').prop('checked', false);
			$('#chkBrokers').prop('checked', false);
			$('#chkInvestors').prop('checked', false);
			$('#chkIssuers').prop('checked', false);
			$('#chkGallery').prop('checked', false);
							
			$('#txtExpiryDate').val('');
			$('#cboStatus').val('');				
			$('#hidId').val('');
			
			$('#btnEditor').html('Click To Enable Message Editor');
			
			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m="ResetControls ERROR:\n"+e;
			DisplayMessage(m,'error',Title);
		}
	}//End ResetControls	
		
	function CheckSelection()
	{
		try
		{					
			var brok = false, inv  = false, iss  = false, gal  = false;
			
			brok = $('#chkBrokers').is(':checked');
			inv  = $('#chkInvestors').is(':checked');
			iss  = $('#chkIssuers').is(':checked');
			gal  = $('#chkGallery').is(':checked');
			
			if ((brok==false) || (inv==false) || (iss==false) || (gal==false)) $('#chkAll').prop('checked', false);
			if ((brok==true) && (inv==true) && (iss==true) && (gal==true)) $('#chkAll').prop('checked', true);
			
		}catch(e)
		{
			$.unblockUI();
			m="CheckSelection ERROR:\n"+e;
			DisplayMessage(m,'error',Title);
		}
	}
		
	function CheckAll()
	{
		try
		{					
			var a=false;
			
			a = $('#chkAll').is(':checked');
			
			if (a)
			{
				$('#chkBrokers').prop('checked', true);
				$('#chkInvestors').prop('checked', true);
				$('#chkIssuers').prop('checked', true);
				$('#chkGallery').prop('checked', true);
			}
		}catch(e)
		{
			$.unblockUI();
			m="CheckSelection ERROR:\n"+e;
			DisplayMessage(m,'error',Title);
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
                                                    Messages
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
                            <a role="tab" class="nav-link active" id="tabData" data-toggle="tab" href="#data">
                                <span>Send Message</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabView" data-toggle="tab" href="#view">
                                <span>View Messages</span>
                            </a>
                        </li>
                        <li onClick="window.location.reload(true);" class="nav-item">
                            <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#refresh">
                                <span>Refresh</span>
                            </a>
                        </li>
                    </ul>
                    
                    
                    <div class="tab-content">
                        <div class="tab-pane tabs-animation fade show active" id="data" role="tabpanel">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <form class="">
                                    	<input id="hidId" type="hidden" />
                                                                                
                                        <!--Message Header-->
                                        <div title="Message Header" class="position-relative row form-group">
                                        	<label for="txtHeader" class="col-sm-2 col-form-label">Message Header<span class="redtext">*</span></label>
                                            
                                            <div class="col-sm-10">
                                            	<input type="text" style="text-transform:capitalize;" class="form-control" id="txtHeader" placeholder="Message Header">
                                             </div>
                                        </div>
                                        
                                        
                                        <!--Message Details-->
                                        <div class="position-relative row form-group">
                                            <label for="divDetails" class="col-sm-2 col-form-label">Message Details<span class="redtext">*</span></label>
                                            
                                            <div class="col-sm-10">
                                            	<div id="divDetails" class="form-control" style="height:250px; border:1px solid #000; overflow-y:auto;">[Type your message here after double clicking in this space or clicking the enable button below]</div>
                                                
                                                <button class="btn btn-nse-green" style="margin-top:5px;" id="btnEditor" type="button" >Click To Enable Message Editor</button>
    
                                            	<!--<textarea rows="10" style="max-height:250px; id="txtDetails" placeholder="Message Details" class="form-control"></textarea>-->
                                            </div>
                                       </div>
                                       
                                       
                                       <!--Recipients-->
                                        <div title="Message Recipients. Select at least one" class="position-relative row form-group">
                                        	<label class="col-sm-2 col-form-label">Message Recipients<span class="redtext">*</span></label>                                             
                                            
                                            <div class="col-sm-5 " style="height:34px; padding:6px 12px;">
                                            	<div title="Send Message To Everyone" class="custom-checkbox custom-control custom-control-inline">
                                                    <input onClick="CheckAll();" type="checkbox" id="chkAll" class="custom-control-input">
                                                    <label class="custom-control-label" for="chkAll">All</label>
                                                </div>
                                                
                                                <div title="Send Message To Brokers" class="custom-checkbox custom-control custom-control-inline ">
                                                    <input onClick="CheckSelection();" type="checkbox" id="chkBrokers" class="custom-control-input">
                                                    <label class="custom-control-label" for="chkBrokers">Brokers</label>
                                                </div>
                                                
                                                <div title="Send Message To Investors" class="custom-checkbox custom-control custom-control-inline">
                                                    <input onClick="CheckSelection();" type="checkbox" id="chkInvestors" class="custom-control-input">
                                                    <label class="custom-control-label" for="chkInvestors">Investors</label>
                                                </div>
                                                
                                                <div title="Send Message To Issuers" class="custom-checkbox custom-control custom-control-inline">
                                                    <input onClick="CheckSelection();" type="checkbox" id="chkIssuers" class="custom-control-input">
                                                    <label class="custom-control-label" for="chkIssuers">Issuers</label>
                                                </div>
                                                
                                                <div title="Send Message To Gallery Personnel" class="custom-checkbox custom-control custom-control-inline">
                                                    <input onClick="CheckSelection();" type="checkbox" id="chkGallery" class="custom-control-input">
                                                    <label class="custom-control-label" for="chkGallery">Gallery</label>
                                                </div>
                                            </div>
                                            
                                            <!--Category-->
                                             <label title="Message Category" for="cboCategory" class="col-sm-2 col-form-label text-right">Message Category<span class="redtext">*</span></label>
                                             
                                             <div title="Message Category" class="col-sm-3">
                                             	<select id="cboCategory" class="form-control">
                                                    <option title="Select Category" value="">[SELECT]</option>
                                                    <option title="Category Is Message" value="Message">Message</option>
                                                    <option title="Category Is News" value="News">News</option>
                                                  </select>
                                             </div>
                                        </div>
                                                                               
                                        <div class="position-relative row form-group">
                                        	<!--Expiry Date-->
                                           <label title="Expiry Date" for="txtExpiryDate" class="col-sm-2 col-form-label">Expiry Date</label>
                                            
                                             <div title="Expiry Date" class="col-sm-4 date datepicker">
                                                <div class="input-group">
                                                    <input style="background:#ffffff; cursor:default;" readonly id="txtExpiryDate" placeholder="Expiry Date" type="text" class="form-control">
                                                    
                                                    <span class="input-group-btn"><button style="border-radius:0;" class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                                </div>
                                             </div>
                                             
                                              <!--Display Status-->
                                             <label title="Display Status" for="cboStatus" class="col-sm-3 col-form-label text-right">Display Status<span class="redtext">*</span></label>
                                             
                                             <div title="Display Status" class="col-sm-3">
                                             	<select id="cboStatus" class="form-control">
                                                    <option title="Select Display Message" value="">[SELECT]</option>
                                                    <option title="Display Message" value="1">Dispay Message</option>
                                                    <option title="Do Not Display Message" value="0">Don't Display Message</option>
                                                  </select>
                                             </div>
                                        </div>
                                        
                                                                                
                                       
                                        
                                                                                
                                        
                                        <!--Buttons-->
                                        <div class="position-relative row form-group">
                                             <!--Buttond-->
                                             <div class="col-sm-12">
                                                 <div align="center" style="margin-top:15px;">
                                                    <button id="btnSend" type="button" class="btn btn-primary size-16 ">Send Message</button>
                                                    <button style="margin-left:10px;" id="btnEdit" type="button" class="btn btn-info size-16">Edit Message</button>                                	
                                                        
                                                     <button style="margin-left:10px;" onClick="window.location.reload(true);" class="btn btn-danger size-16">Refresh</button>
                                                </div>    
                                             </div>
                                        </div>                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane tabs-animation fade" id="view" role="tabpanel">
                        	<div class="row">
                            	<div class="col-md-12">
                                	<div class="mb-3 card">
                                        <div class="card-body">
                                            <table class="hover table table-bordered data-table display" id="recorddisplay">
                                              <thead>
                                                <tr>
                                                        <th style="text-align:center" width="4%">SELECT</th>
                                                        <th style="text-align:center" width="4%">DELETE</th>
                                                        <th style="text-align:center" width="12%">DATE</th>
                                                        <th style="text-align:center" width="12%">CATEGORY</th>
                                                        <th style="text-align:center" width="40%">HEADER</th>
                                                        <th style="text-align:center;" width="16%">SENDER</th>
                                                        <th style="text-align:center;" width="12%">STATUS</th>
                                                    </tr>
                                              </thead>
        
                                              <tbody id="tbbody"></tbody>
                                            </table>                                           
                                        </div>
                                    </div> 
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

<script type="text/javascript" src="<?php echo base_url();?>assets/js/main.8d288f825d8dffbbe55e.js"></script>



</body>
</html>
