<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Derived Homes - Register Broker</title>
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

	<script type = "text/javascript">
	
	var Title='<font color="#AF4442">Naija Art Mart Message</font>';
	var Email='<?php echo $email; ?>';
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

		$('#txtDate').datepicker({
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
		
		document.getElementById('btnEdit').disabled=true;
		document.getElementById('btnAdd').disabled=false;	
		
		LoadStates();
		LoadBrokers();
		
		$('#btnAdd').click(function(e)
		{
			try
			{
				$('#divAlert').html('');			
				if (!CheckAdd()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Add Broker Button Click ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		});//btnAdd Click Ends
		
		$('#btnEdit').click(function(e) {
			try
			{					
				$('#divAlert').html('');
				
				if (!CheckEdit()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Edit Broker Button Click ERROR:\n'+e;					
				DisplayMessage(m, 'error',Title);
			}
		});//btnEdit Click Ends
		
		function CheckEdit()
		{
			try
			{
				var add=$.trim($('#txtAddress').val());
				var cm=$.trim($('#txtCompanyName').val());				
				var st=$.trim($('#cboState').val());				
				var em=$.trim($('#txtEmail').val());				
				var ph=$.trim($('#txtPhone').val());				
				var cd=$.trim($('#txtCode').val());
				var sta=$.trim($('#cboStatus').val());
				var dt=ChangeDateFrom_dMY_To_Ymd($('#txtDate').val());
				var d=$.trim($('#txtDate').val());
				var id=$.trim($('#hidId').val());
									
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the broker record update.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}
				
				//Broker Name
				if (!cm)
				{
					m='Broker company name field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtCompanyName').focus(); return false;
				}
				
				if ($.isNumeric(cm))
				{
					m='Broker company name field must not be a number.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtCompanyName').focus(); return false;
				}
				
				if (cm.length<3)
				{
					m='Please enter a meaningful broker company name.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtCompanyName').focus(); return false;
				}
				
				//Membership Code
				if (!cd)
				{
					m='Broker membership code field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtCode').focus(); return false;
				}
				
				if (cd.length<2)
				{
					m='Please enter a meaningful broker membership code.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtCode').focus(); return false;
				}
				
				//Incorporation Date
				if (!d)
				{
					m='Brokerage company incorporation date field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtDate').focus(); return false;
				}
				
				//Address
				if (!add)
				{
					m='Brokerage company address field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtAddress').focus(); return false;
				}
				
				if ($.isNumeric(add))
				{
					m='Brokerage company address entry is valid. Please type the full address.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtAddress').focus(); return false;
				}
				
				if (add.length<2)
				{
					m='Brokerage company address entry is valid. Please type the full address.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtAddress').focus(); return false;
				}
				
				//State
				if ($('#cboState > option').length < 2)
				{
					m='Records of states in Nigeria have not been captured. Please contact the system administrator.';
					DisplayMessage(m, 'error',Title);					
					return false;
				}
				
				if (!st)
				{
					m='Please select the state where the headquarter of the bokerage company is located.';
					DisplayMessage(m, 'error',Title);					
					$('#cboState').focus(); return false;
				}
				
				//Email
				if (!em)
				{
					m="Broker's email address field must not be blank.";
					DisplayMessage(m, 'error',Title);					
					$('#txtEmail').focus(); return false;
				}
				
				if (!isEmail(em))
				{
					m="Broker's email address is not valid.";
					DisplayMessage(m, 'error',Title);					
					$('#txtEmail').focus(); return false;
				}
				
				//Phone								
				if (!ph)
				{
					m="Broker's phone number field must not be blank.";
					DisplayMessage(m, 'error',Title);					
					$('#txtPhone').focus(); return false;
				}
				
				if (!$.isNumeric(ph.replace('+','')))
				{
					m="Broker's phone number field must be numeric.";
					DisplayMessage(m, 'error',Title);					
					$('#txtPhone').focus(); return false;
				}				
				
				/*//Status
				if (!sta)
				{
					m="Please select broker's account status. This indicates whether the broker's account will take part in trading (activate) or not (disabled).";
					DisplayMessage(m, 'error',Title);					
					$('#cboStatus').focus(); return false;
				}*/
				
				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: "<font size='3' face='Arial'>Do you want to proceed with the editing of the broker's record?</font>",
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Editing Broker's Record. Please Wait...</p>",theme: false,baseZ: 2000});
															
					//Initiate POST
					var uri = "<?php echo site_url('admin/Registerbroker/EditBroker'); ?>";
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
							m="Broker's record has been edited successfully.";
							DisplayMessage(m, 'success','Broker Edited','SuccessTheme');
							
							ResetControls();
							LoadBrokers();																					
						}else
						{
							m=res.Message;								
							DisplayMessage(m, 'error',Title);
						}
					}
				};
				
					fd.append('company', cm);
					fd.append('address', add);
					fd.append('state', st);
					fd.append('email', em);
					fd.append('phone', ph);
					fd.append('incorporationdate', dt);
					fd.append('broker_id', cd);
					fd.append('accountstatus', sta);
					fd.append('id', id);
																				
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
		
		function CheckAdd()
		{
			try
			{
				var add=$.trim($('#txtAddress').val());
				var cm=$.trim($('#txtCompanyName').val());				
				var st=$.trim($('#cboState').val());				
				var em=$.trim($('#txtEmail').val());				
				var ph=$.trim($('#txtPhone').val());				
				var cd=$.trim($('#txtCode').val());
				var sta=$.trim($('#cboStatus').val());				
				var pwd=$.trim($('#txtPwd').val());
				var cpwd=$.trim($('#txtConfirmPwd').val());
				var dt=ChangeDateFrom_dMY_To_Ymd($('#txtDate').val());
				var d=$.trim($('#txtDate').val());
									
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the broker registration.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}
								
				//Broker Name
				if (!cm)
				{
					m='Broker company name field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtCompanyName').focus(); return false;
				}
				
				if ($.isNumeric(cm))
				{
					m='Broker company name field must not be a number.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtCompanyName').focus(); return false;
				}
				
				if (cm.length<3)
				{
					m='Please enter a meaningful broker company name.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtCompanyName').focus(); return false;
				}
				
				//Membership Code
				if (!cd)
				{
					m='Broker membership code field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtCode').focus(); return false;
				}
				
				if (cd.length<2)
				{
					m='Please enter a meaningful broker membership code.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtCode').focus(); return false;
				}
				
				//Incorporation Date
				if (!d)
				{
					m='Brokerage company incorporation date field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtDate').focus(); return false;
				}
				
				//Address
				if (!add)
				{
					m='Brokerage company address field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtAddress').focus(); return false;
				}
				
				if ($.isNumeric(add))
				{
					m='Brokerage company address entry is valid. Please type the full address.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtAddress').focus(); return false;
				}
				
				if (add.length<2)
				{
					m='Brokerage company address entry is valid. Please type the full address.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtAddress').focus(); return false;
				}
				
				//State
				if ($('#cboState > option').length < 2)
				{
					m='Records of states in Nigeria have not been captured. Please contact the system administrator.';
					DisplayMessage(m, 'error',Title);					
					return false;
				}
				
				if (!st)
				{
					m='Please select the state where the headquarter of the bokerage company is located.';
					DisplayMessage(m, 'error',Title);					
					$('#cboState').focus(); return false;
				}
				
				//Email
				if (!em)
				{
					m="Broker's email address field must not be blank.";
					DisplayMessage(m, 'error',Title);					
					$('#txtEmail').focus(); return false;
				}
				
				if (!isEmail(em))
				{
					m="Broker's email address entered (<b> " + em + "</b>) is not invalid. Please check your entry.";
					DisplayMessage(m, 'error',Title);					
					$('#txtEmail').focus(); return false;
				}
				
				//Phone								
				if (!ph)
				{
					m="Broker's phone number field must not be blank.";
					DisplayMessage(m, 'error',Title);					
					$('#txtPhone').focus(); return false;
				}
				
				if (!$.isNumeric(ph.replace('+','')))
				{
					m="Broker's phone number field must be numeric.";
					DisplayMessage(m, 'error',Title);					
					$('#txtPhone').focus(); return false;
				}
				
				//Pwd
				if (!$.trim(pwd))
				{
					m='Naija Art Mart access password field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					return false;
				}
				
				var v=IsValidPassord(pwd,em,8);
				
				if (v != 1)
				{
					DisplayMessage(v, 'error',Title);					
					return false;
				}				
				
				//Confirm Password
				if (pwd != cpwd)
				{
					m='Naija Art Mart access password and confirming password fields do not match.';
					DisplayMessage(m, 'error',Title);					
					return false;
				}				
				
				/*//Status
				if (!sta)
				{
					m="Please select broker's account status. This indicates whether the broker's account will take part in trading (activate) or not (disabled).";
					DisplayMessage(m, 'error',Title);					
					$('#cboStatus').focus(); return false;
				}*/
						
				
				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: "<font size='3' face='Arial'>Do you want to proceed with the creation of broker's trading account record?</font>",
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Creating Broker's Record. Please Wait...</p>",theme: false,baseZ: 2000});
										
					//Initiate POST
					var uri = "<?php echo site_url('admin/Registerbroker/AddBroker'); ?>";
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
							m="Broker's record has been created successfully.";
							DisplayMessage(m, 'success','Broker Added','SuccessTheme');
							
							ResetControls();
							LoadBrokers();																							
						}else
						{
							m=res.Message;
							DisplayMessage(m, 'error',Title);
						}
					}
				};

					fd.append('company', cm);
					fd.append('address', add);
					fd.append('state', st);
					fd.append('email', em);
					fd.append('phone', ph);
					fd.append('incorporationdate', dt);
					fd.append('broker_id', cd);
					fd.append('accountstatus', sta);
					fd.append('pwd', AES256.encrypt($('#txtPwd').val(),'<?php echo ACCESS_STAMP; ?>'));
																				
					xhr.send(fd);// Initiate a multipart/form-data upload
				  }
				})	
			}catch(e)
			{
				$.unblockUI();
				m='CheckAdd ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End CheckAdd
		
		
    });//Document Ready
	
	function LoadStates()
	{
		try
		{
			$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading States. Please Wait...</p>',theme: false,baseZ: 2000});				

			$('#cboState').empty();				

			$.ajax({
				url: "<?php echo site_url('admin/Registerbroker/GetStates');?>",
				type: 'POST',
				dataType: 'json',
				success: function(data,status,xhr) {	
					$.unblockUI();

					if ($(data).length > 0)
					{
						$("#cboState").append(new Option("[SELECT]", ""));
						
						$.each($(data), function(i,e)
						{
							if (e.state) $("#cboState").append(new Option($.trim(e.state), $.trim(e.state)));
						});//End each
					}	
				},
				error:  function(xhr,status,error) {
					$.unblockUI();
					m='Error '+ xhr.status + ' Occurred: ' + error;
					DisplayMessage(m, 'error',Title);
				}
			});
		}catch(e)
		{
			$.unblockUI();
			m='LoadStates ERROR:\n'+e;
			DisplayMessage(m, 'error',Title);
		}
	}
	
	function LoadBrokers()
	{
		try
		{			
			$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Loading Broker's Record. Please Wait...</p>",theme: false,baseZ: 2000});
			
			$('#recorddisplay > tbody').html('');
			
			$.ajax({
				url: "<?php echo site_url('admin/Registerbroker/GetBrokers');?>",
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
						language: {zeroRecords: "No Broker Record Found"},
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
							{ width: "5%" },//Select
							{ width: "5%" },//Delete
							{ width: "20%" },//Company
							{ width: "15%" }, //Broker Id
							{ width: "20%" }, //Phone
							{ width: "20%" }, //Email
							{ width: "15%" } //Status
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
			m='LoadBrokers ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}

	function SelectRow(cm,add,st,em,ph,dt,bid,sta,id)
	{
		try
		{
			ResetControls();
			
			if (document.getElementById('btnEdit')) document.getElementById('btnEdit').disabled=false;
			if (document.getElementById('btnAdd')) document.getElementById('btnAdd').disabled=true;

			$('#txtCompanyName').val(cm);
			$('#txtAddress').val(add);
			$('#cboState').val(st);
			$('#txtEmail').val(em);
			$('#txtPhone').val(ph);
			$('#txtDate').val(dt);
			$('#txtCode').val(bid);
			$('#cboStatus').val(sta);
			$('#hidId').val(id);

			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m='SelectRow ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}

	function DeleteRow(cm,bid,sta,id)
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
				  html: "<font size='3' face='Arial'>Do you want to delete this broker's record from the database?. Please note that this action is irreversible.</font>",
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Delete!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Deleting Broker's Record. Please Wait...</p>",theme: false,baseZ: 2000});
					
					$('#divAlert').html('');
					
					m=''
					
					//Make Ajax Request			
					$.ajax({
						url: '<?php echo site_url('admin/Registerbroker/DeleteBroker'); ?>',
						data: {company:cm,broker_id:bid,id:id},
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
										LoadBrokers();
										
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
			m='Delete Broker Button Click ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}
	
	function ResetControls()
	{
		try
		{					
			if (document.getElementById('btnEdit')) document.getElementById('btnEdit').disabled=true;
			if (document.getElementById('btnAdd')) document.getElementById('btnAdd').disabled=false;
			
			$('#txtCompanyName').val('');
			$('#txtAddress').val('');
			$('#cboState').val('');
			$('#txtEmail').val('');
			$('#txtPhone').val('');
			$('#txtDate').val('');
			$('#txtCode').val('');
			$('#cboStatus').val('');
			$('#txtPwd').val('');
			$('#txtConfirmPwd').val('');
			$('#hidId').val('');
			
			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m="ResetControls ERROR:\n"+e;
			DisplayMessage(m,'error',Title);
		}
	}//End ResetControls
	
		
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
                                                    Register Broker
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
                                <span>Broker Data</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabView" data-toggle="tab" href="#view">
                                <span>View Brokers</span>
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
                                        
                                        <!--Broker Name-->
                                        <div title="Broker Name" class="position-relative row form-group">
                                        	<label for="txtCompanyName" class="col-sm-2 col-form-label">Broker Name<span class="redtext">*</span></label>
                                            
                                            <div class="col-sm-10">
                                            	<input type="text" style="text-transform:capitalize;" class="form-control" id="txtCompanyName" placeholder="Broker Name">
                                             </div>
                                        </div>
                                        
                                        
                                        <!--Membership Code/Incorporation Date-->
                                        <div class="position-relative row form-group">
                                         	<!--Membership Code-->
                                            <label title="Broker Membership Code" for="txtCode" class="col-sm-2 col-form-label">Membership Code<span class="redtext">*</span></label>
                                            
                                            <div title="Broker Membership Code" class="col-sm-4"><input id="txtCode" placeholder="Broker Membership Code" type="text" class="form-control"></div>
                                            
                                            <!--Incorporation Date-->
                                           <label title="Incorporation Date" for="txtDate" class="col-sm-2 col-form-label text-right">Incorporation Date<span class="redtext">*</span></label>
                                    	
                                         <div title="Broker Incorporation Date" class="col-sm-4 date datepicker">
                                            <div class="input-group">
                                                <input style="background:#ffffff; cursor:default;" readonly id="txtDate" placeholder="Broker Incorporation Date" type="text" class="form-control">
                                                
                                                <span class="input-group-btn"><button style="border-radius:0;" class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                            </div>
                                         </div>
                                       </div>
                                        
                                                                                
                                        <!--Address-->
                                        <div title="Broker Address" class="position-relative row form-group">
                                        	<label for="txtAddress" class="col-sm-2 col-form-label">Address<span class="redtext">*</span></label>
                                             
                                             <div class="col-sm-10">
                                             	<input id="txtAddress" placeholder="Broker Address" type="text" class="form-control">
                                             </div>
                                        </div>
                                        
                                         <!--State Of Residence/Phone-->
                                        <div class="position-relative row form-group">
                                        	<label title="State Where Broker Headquarters Is Location" for="cboState" class="col-sm-2 col-form-label">State<span class="redtext">*</span></label>
                                             
                                             <div title="State Where Broker Headquarters Is Location" class="col-sm-4">
                                             	<select id="cboState" class="form-control"></select>
                                             </div>
                                             
                                              <!--Phone-->
                                              <label title="Broker Phone" for="txtPhone" class="col-sm-2 col-form-label text-right">Broker Phone<span class="redtext">*</span></label>
                                            
                                               <div title="Broker Phone" class="col-sm-4"><input id="txtPhone" placeholder="Broker Phone" type="tel" class="form-control"></div>
                                        </div>
                                        
                                        <!--Email/Status-->
                                        <div class="position-relative row form-group">
                                         	<!--Email-->
                                            <label title="Broker Email" for="txtEmail" class="col-sm-2 col-form-label">Broker Email<span class="redtext">*</span></label>
                                            
                                            <div title="Broker Email" class="col-sm-4"><input id="txtEmail" placeholder="Broker Email" type="email" class="form-control"></div>
                                            
                                          <!--Status--> 
                                            <label title="Broker Account Status" for="cboStatus" class="col-sm-2 col-form-label">Account Status</label>
                                             
                                             <div title="Broker Account Status" class="col-sm-4">
                                             	<select id="cboStatus" class="form-control">
                                                    <option value="">[SELECT]</option>
                                                    <option value="1">Activate</option>
                                                    <option value="0">Disable</option>
                                                  </select>
                                             </div>
                                        </div>
                                        
                                         <!--Password/ConfirmPwd-->
                                        <div class="position-relative row form-group">
                                        	<label title="Access Password" for="txtPwd" class="col-sm-2 col-form-label">Access Password<span class="redtext">*</span></label>
                                            
                                            <div title="Access Password" class="col-sm-4"><input autocomplete="new-password" id="txtPwd" placeholder="Access Password" type="password" class="form-control"></div>
                                            
                                            <!--Confirm Password-->
                                            <label title="Confirm Access Password" for="txtConfirmPwd" class="col-sm-2 col-form-label text-right">Confirm Pwd<span class="redtext">*</span></label>
                                            
                                            <div title="Confirm Access Password" class="col-sm-4"><input id="txtConfirmPwd" placeholder="Confirm Access Password" type="password" class="form-control"></div>
                                        </div>
                                        
                                        
                                        <!--Broker Account Status/Buttons-->
                                        <div class="position-relative row form-group">
                                             <!--Buttond-->
                                             <div class="col-sm-12">
                                                 <div align="center" style="margin-top:15px;">
                                                    <button id="btnAdd" type="button" class="btn btn-primary size-16 ">Add Broker</button>
                                                    <button style="margin-left:10px;" id="btnEdit" type="button" class="btn btn-info size-16">Edit Broker</button>                                	
                                                        
                                                     <button type="button" style="margin-left:10px;" onClick="window.location.reload(true);" class="btn btn-danger size-16">Refresh</button>
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
                                                        <th style="text-align:center" width="5%">SELECT</th>
                                                        <th style="text-align:center" width="5%">DELETE</th>
                                                        <th style="text-align:center" width="20%">BROKER NAME</th>
                                                        <th style="text-align:center" width="15%">MEMBERSHIP CODE</th>
                                                        
                                                        <th style="text-align:center" width="20%">PHONE</th>
                                                        
                                                        <th style="text-align:center" width="20%">EMAIL</th>
                                                        
                                                         <th style="text-align:center" width="15%">ACCOUNT STATUS</th>
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
