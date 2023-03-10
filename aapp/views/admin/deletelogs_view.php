<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Derived Homes - Delete Log Records</title>
    <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Naija Art Mart - The New Art Market For Everyone">    
    <meta name="msapplication-tap-highlight" content="no"><!-- Disable tap highlight on IE -->

	<?php include('header.php'); ?>
    <?php include('scripts.php'); ?>

	 

	<script type = "text/javascript">
	
	var Title='<font color="#AF4442">Delete Log Records Message</font>';
	var Email='<?php echo $email; ?>';
	
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
		
		LoadUsers();
		
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

		$('#txtStartDate').datepicker({
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
		
		$('#txtStartDate').blur(function(e) {
			try
			{
				if ($('#txtStartDate').val() && $('#txtEndDate').val())
				{
					VerifyStartAndEndDates();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="Start Date Blur ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});
		
		$('#txtStartDate').change(function(e) {
			try
			{
				if ($('#txtStartDate').val() && $('#txtEndDate').val())
				{
					VerifyStartAndEndDates();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="Start Date Change ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});			

		$('#txtEndDate').datepicker({
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

		$('#txtEndDate').blur(function(e) 
		{
			try
			{
				if ($('#txtStartDate').val() && $('#txtEndDate').val())
				{
					VerifyStartAndEndDates();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="End Date Blur ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});
		
		$('#txtEndDate').change(function(e) 
		{
			try
			{
				if ($('#txtStartDate').val() && $('#txtEndDate').val())
				{
					VerifyStartAndEndDates();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="End Date Change ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});			
		
		
		$('#chkSelect').prop('title','Click To Select All User Accounts');
		$('#lblSelect').prop('title','Click To Select All User Accounts');
		
		function VerifyStartAndEndDates()
		{
			try
			{
				$('#divAlert').html('');
				
				var startdt=ChangeDateFrom_dMY_To_Ymd($('#txtStartDate').val());
				var enddt=ChangeDateFrom_dMY_To_Ymd($('#txtEndDate').val());
				var sdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
				var edt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
				var d;
				
				if ($('#txtStartDate').val()=='0000-00-00') $('#txtStartDate').val('');
				if ($('#txtEndDate').val()=='0000-00-00') $('#txtEndDate').val('');
				
				if ($('#txtStartDate').val())
				{
					if (!sdt.isValid())
					{
						m="Start Date Is Not Valid. Please Select A Valid Start Date.";
						
						DisplayMessage(m, 'error',Title);
					}	
				}
				
				
				if ($('#txtEndDate').val())
				{
					if (!edt.isValid())
					{
						m="End Date Is Not Valid. Please Select A Valid End Date.";
						DisplayMessage(m, 'error',Title);
					}	
				}
				
									
				//moment('2010-10-20').isSameOrBefore('2010-10-21');  // true				
				var dys=edt.diff(sdt, 'days') //If this -ve invalid date entries. Delivery earlier than pickup
				var diff = moment.duration(edt.diff(sdt));
				var mins = parseInt(diff.asMinutes());
				
				
				if (dys<0)
				{
					$('#txtEndDate').val('');
										
					m="End Date Is Before Start Date. Please Correct Your Entries!";
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
		
		$('#chkSelect').click(function(e)
		{
			try
			{
				if ($(this).prop('checked'))
				{
					$('#cboUsers option').prop('selected', true);
					$(this).prop('title','Click To Deselect All User Accounts');
					$('#lblSelect').prop('title','Click To Deselect All User Accounts');
				}else
				{
					//clearSelected('cboUsers');
					$('#cboUsers option').prop('selected',false);
					$(this).prop('title','Click To Select All User Accounts');
					$('#lblSelect').prop('title','Click To Select All User Accounts');
				}
			}catch(e)
			{
				m='Select Checkbox Click Error:\n'+e;
				$.unblockUI();
				DisplayMessage(m,'error',Title);
			}
		});//End chkSelect Click
		
		function clearSelected(id)
		{
			var elements = document.getElementById(id).options;
			
			for(var i = 0; i < elements.length; i++)
			{
				elements[i].selected = false;
			}
		}

		function ResetControls()
		{
			try
			{
				$('#txtStartDate').val('');
				$('#txtEndDate').val('');
				//$('#cboUsers').val('');
				$('#chkSelect').prop('checked',false);
			}catch(e)
			{
				$.unblockUI();
				m="ResetControls ERROR:\n"+e;
				DisplayMessage(m,'error',Title);
			}
		}//End ResetControls		

		$('#btnDelete').click(function(e) 
		{
			try
			{
				if (!CheckForm()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Update Button Click ERROR:\n'+e;					
				DisplayMessage(m,'error',Title);
			}
		});//btnDelete Click Ends
		
		function CheckForm()
		{
			try
			{
				var startdt=ChangeDateFrom_dMY_To_Ymd($('#txtStartDate').val());
				var enddt=ChangeDateFrom_dMY_To_Ymd($('#txtEndDate').val());
				var pdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
				var ddt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
				var p=$.trim($('#txtStartDate').val());
				var d=$.trim($('#txtEndDate').val());
				
				var users = $("#cboUsers").val() || [];
				var usr=users.join(",");	

				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the update.';						

					DisplayMessage(m,'error',Title);
					return false;
				}
				
				if (!usr)
				{
					m='Please select the user(s) whose log records you want to delete. You can click on <b>SELECT ALL</b> to select all the users.';					
					DisplayMessage(m,'error',Title);
					return false;
				}

				//Start date
				if (!p)
				{
					m='You have not selected the start date.';					
					DisplayMessage(m,'error',Title);
					return false;
				}					

				//End Date
				if (!d)
				{
					m='You have not selected the end date.';
					DisplayMessage(m,'error',Title);
					return false;
				}					

				if (!p && d)
				{
					m='You have selected the end date. Start date field must also be selected.';						
					DisplayMessage(m,'error',Title);
					return false;
				}					

				if (p && !d)
				{
					m='You have selected the start date. End date field must also be selected.';						

					DisplayMessage(m,'error',Title);
					return false;
				}					

				if (p && d)
				{
					var dys=ddt.diff(pdt, 'days') //If this -ve invalid date entries.
							
					if (dys<0)
					{
						m="End Date Is Before The Start Date. Please Correct Your Entries!";
						DisplayMessage(m, 'error',Title);
						return false;
					}
				}
				
				
				if (!usr)
				{
					$('#cboUsers option').prop('selected', true);	
					users=$("#cboUsers").val() || [];
					usr=users.join(",");
				}					

				if (usr)
				{
					var t=usr.split(',');						

					if (t.length==$('#cboUsers > option').length) usr="ALL";
				}

				
				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: '<font size="3" face="Arial">This action will permanently delete log records. Do you want to proceed with the deleting of the log records for the selected period?</font>',
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Deleting Log Records. Please Wait...</p>',theme: false,baseZ: 2000});
					
					//Initiate POST
					var uri = "<?php echo site_url('admin/Deletelogs/Delete'); ?>";
					var xhr = new XMLHttpRequest();
					var fd = new FormData();
					
					xhr.open("POST", uri, true);
					
					xhr.onreadystatechange = function() {
						if (xhr.readyState == 4 && xhr.status == 200)
						{
							// Handle response.
	
							$.unblockUI();
							
							var res=$.trim(xhr.responseText);
														
							if (res.toUpperCase()=='OK')
							{
								ResetControls();
								LoadUsers();
								m='Delete Log Records Successfully.';
								DisplayMessage(m, 'success','Log Records Deleted','SuccessTheme');																												
							}else
							{
								m=res;								
								DisplayMessage(m, 'error',Title);
							}
						}
					};

					fd.append('fromdate', startdt);
					fd.append('todate', enddt);
					fd.append('users', usr);
																				
					xhr.send(fd);// Initiate a multipart/form-data upload
				  }
				})	
			}catch(e)
			{
				$.unblockUI();
				m='CheckForm ERROR:\n'+e;					
				DisplayMessage(m,'error',Title);
			}
		}//End CheckForm
		
		function LoadUsers()
		{
			try
			{
				$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading System Users. Please Wait...</p>',theme: false,baseZ: 2000});				

				$('#cboUsers').empty();				

				$.ajax({
					url: "<?php echo site_url('admin/Deletelogs/LoadUsers');?>",
					type: 'POST',
					dataType: 'json',
					success: function(data,status,xhr) {	
						$.unblockUI();

						if ($(data).length > 0)
						{
							$.each($(data), function(i,e)
							{//{"Username":"idongesit_a@yahoo.com","Name":"Admin User"}
								if (e.Username)
								{
									var n='';
									
									if (e.Name) n = $.trim(e.Name) + ' => [' + $.trim(e.Username) + ']'; else n = $.trim(e.Username);
									$("#cboUsers").append(new Option(n, $.trim(e.Username)));
								}
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
				m='LoadUsers ERROR:\n'+e;
				DisplayMessage(m, 'error',Title);
			}
		}
    });//End ready
		
    </script>
</head>
<body>

<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    <?php include('dheader.php'); //Dashboard Header ?>
    
    
    <div class="app-main">
          	<?php include('sidemenu.php'); //Side Menu ?>
            
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
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
                                                    Delete Log Records
                                                </li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>            
                    
                    <div class="tabs-animation">
                       <div class="main-card mb-3 card">
                            <div class="card-body">
                                <form class="">
                                	<!--User Account-->
                                    <div class="position-relative row form-group">
                                    	<label title="User Account" for="cboUsers" class="col-sm-2 col-form-label text-right">User Account<span class="redtext">*</span></label>
                                        
                                        <div title="User Account" class="col-sm-9">
                                            <select class="form-control" size="10" multiple style="text-transform:none;" id="cboUsers" name="cboUsers">
                                             </select>
                                        </div>
                                    </div>
                                    
                                    <div class="position-relative row form-group ">
                                    	<label class="col-sm-2 col-form-label text-right"></label>
                                        
                                    	<div style="padding-bottom:5px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-style:italic; font-size:0.9em; color:#900;" title="Select All Users" class="col-sm-offset-3 col-sm-9">
                                        	<label id="lblSelect" title="Click To Select All Users">
                                                <input  type="checkbox" name="radios" id="chkSelect" />
                                                SELECT ALL
                                            </label>
                                        </div>
                                    </div>
                                    
                                    
                                    <!--Start Date/End Date-->
                                    <div class="position-relative row form-group">
                                    	<label title="Start Date" for="txtStartDate" class="col-sm-2 col-form-label text-right">Start Date<span class="redtext">*</span></label>
                                    	
                                         <div title="Start Date" class="col-sm-3 date datepicker">
                                            <div class="input-group">
                                                <input style="background:#ffffff; cursor:default;" readonly id="txtStartDate" placeholder="Start Date" type="text" class="form-control">
                                                
                                                <span class="input-group-btn"><button style="border-radius:0;" class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                            </div>
                                         </div>
                                        
                                        
                                        <!--End Date-->
                                        <label title="End Date" for="txtEndDate" class="col-sm-2 col-form-label text-right">End Date<span class="redtext">*</span></label> 
                                        
                                         <div title="End Date" class="col-sm-3 date datepicker">
                                            <div class="input-group">
                                                <input style="background:#ffffff; cursor:default;" readonly id="txtEndDate" placeholder="End Date" type="text" class="form-control">
                                                
                                                <span class="input-group-btn"><button style="border-radius:0;" class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                            </div>
                                         </div>
                                    </div>
                                    
                                                                    
                                    <br>
                                   <div class="position-relative row form-check">
                                        <div class="col-sm-8 offset-sm-4">
                                        	 <?php

												if ($ClearLogFiles==1)
	
												{
	
													echo '<button style="margin-right:10px;" id="btnDelete" title="Delete Log Records" type="button" class="btn-pill btn btn-nse-green size-14 makebold"><i class="fa fa-trash size-14 makebold"></i> Delete Records</button>';
	
												}
	
											?>
											
                                            <button onClick="window.location.reload(true);"  type="button" class="btn-pill btn btn-danger size-14 makebold"><i class="pe-7s-refresh-2 size-14 makebold"></i> Refresh</button>
                                        </div>
                                    </div>
                                </form>
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
