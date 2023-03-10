<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Derived Homes - User Account</title>
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
	
	var Title='<font color="#AF4442">Naija Art Mart Help</font>';
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
		
		document.getElementById('btnEdit').disabled=true;
		document.getElementById('btnCreate').disabled=false;	
				  		
		LoadPermissions();		
		LoadCompanies();
		LoadUsers('');
		
		$('#cboCompany').change(function(e) {
            try
			{
				$('#recorddisplay > tbody').html('');	

				var cm=$(this).val();
				
				if (cm) LoadUsers(cm);
			}catch(e)
			{
				$.unblockUI();
				m='Company Changed ERROR:\n'+e;				

				DisplayMessage(m, 'error',Title);
			}
        });	

		$('#cboType').change(function(e) {
            try
			{
				$('#recorddisplay > tbody').html('');	

				var rl=$(this).val();
				var cm=$('#cboCompany').val();
				
				LoadPermissions();
					
				$('#cboItems').prop('disabled',false);
				$('#cboPermissions').prop('disabled',false);
				
				$('#btnAdd').prop('disabled',false);
				$('#btnAddAll').prop('disabled',false);
				$('#btnRemove').prop('disabled',false);
				$('#btnRemoveAll').prop('disabled',false);

				if (rl)
				{					
					if ($.trim(rl.toLowerCase()) == 'admin')
					{
						$('#btnAddAll').trigger('click');
						
						$('#cboItems').prop('disabled',true);
						$('#cboPermissions').prop('disabled',true);
						
						$('#btnAdd').prop('disabled',true);
						$('#btnAddAll').prop('disabled',true);
						$('#btnRemove').prop('disabled',true);
						$('#btnRemoveAll').prop('disabled',true);
					}else
					{
						//Autoselect permission
						LoadPermissions();
						
						if ($.trim(rl.toLowerCase()) == 'operator')
						{
							$("#cboItems > option").each(function() {					
								if ($.trim(this.value).toLowerCase()=='view orders')
								{
									//Remove the permission
									$('#cboPermissions').append( new Option('View Orders','View Orders') ); 
						
									$("#cboItems > option").each(function (i,pe) {
										if ($.trim(pe.value).toLowerCase()== 'view orders') {pe.remove();}
									});
									
									return false;
								}
							});	
							
							$("#cboItems > option").each(function() {					
								if ($.trim(this.value).toLowerCase()=='view reports')
								{
									//Remove the permission
									$('#cboPermissions').append( new Option('View Reports','View Reports') ); 
						
									$("#cboItems > option").each(function (i,pe) {
										if ($.trim(pe.value).toLowerCase()== 'view reports') {pe.remove();}
									});
									
									return false;
								}
							});	
								
						}else if ($.trim(rl.toLowerCase()) == 'gallery')
						{
							$("#cboItems > option").each(function() {					
								if ($.trim(this.value).toLowerCase()=='publish artwork')
								{
									//Remove the permission
									$('#cboPermissions').append( new Option('Publish ArtWork','Publish ArtWork') ); 
						
									$("#cboItems > option").each(function (i,pe) {
										if ($.trim(pe.value).toLowerCase()== 'publish artwork') {pe.remove();}
									});
									
									return false;
								}
							});	
							
							$("#cboItems > option").each(function() {					
								if ($.trim(this.value).toLowerCase()=='view reports')
								{
									//Remove the permission
									$('#cboPermissions').append( new Option('View Reports','View Reports') ); 
						
									$("#cboItems > option").each(function (i,pe) {
										if ($.trim(pe.value).toLowerCase()== 'view reports') {pe.remove();}
									});
									
									return false;
								}
							});	
						}
						
						
						$("#cboItems > option").each(function() {					
							if ($.trim(this.value).toLowerCase()=='view prices')
							{
								//Remove the permission
								$('#cboPermissions').append( new Option('View Prices','View Prices') ); 
					
								$("#cboItems > option").each(function (i,pe) {
									if ($.trim(pe.value).toLowerCase()== 'view prices') {pe.remove();}
								});
								
								return false;
							}
						});
						
						$('#cboItems').prop('disabled',false);
						$('#cboPermissions').prop('disabled',false);
						
						$('#btnAdd').prop('disabled',false);
						$('#btnAddAll').prop('disabled',false);
						$('#btnRemove').prop('disabled',false);
						$('#btnRemoveAll').prop('disabled',false);
					}
				}
			}catch(e)
			{
				$.unblockUI();
				m='Usertype Changed ERROR:\n'+e;				

				DisplayMessage(m, 'error',Title);
			}
        });
		
		$('#btnCreate').click(function(e)
		{
			try
			{
				$('#divAlert').html('');			
				if (!CheckCreate()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Create Users Button Click ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		});//btnCreate Click Ends
		
		$('#btnEdit').click(function(e) {
			try
			{					
				$('#divAlert').html('');
				
				if (!CheckEdit()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Edit User Button Click ERROR:\n'+e;					
				DisplayMessage(m, 'error',Title);
			}
		});//btnEdit Click Ends
		
		function CheckEdit()
		{
			try
			{
				var nm=$.trim($('#txtName').val());
				var em=$.trim($('#txtEmail').val());
				var cm=$.trim($('#cboCompany').val());
				var ph=$.trim($('#txtPhone').val());
				var ut=$.trim($('#cboType').val());
				var sta=$.trim($('#cboStatus').val());
				var ret=true,msg='';
									
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the editing of the user account.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}
				
				//Company Name
				if ($('#cboCompany > option').length < 2)
				{
					m='No broker record has been captured. Please contact the system administrator.';
					DisplayMessage(m, 'error',Title);					
					return false;
				}
				
				if (!cm)
				{
					m='Please select the user company.';
					DisplayMessage(m, 'error',Title);					
					$('#cboCompany').focus(); return false;
				}
				
				//Full Name
				if (!nm)
				{
					m='User fullname field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtName').focus(); return false;
				}
				
				if ($.isNumeric(nm))
				{
					m='User fullname field must not be a number.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtName').focus(); return false;
				}
				
				if (nm.length<3)
				{
					m='Please enter the user fullname in full.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtName').focus(); return false;
				}
				
								
				//Emails
				if (!em)
				{
					m='User email field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtEmail').focus(); return false;
				}
				
				//Phone								
				if (!ph)
				{
					m='User phone number field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtPhone').focus(); return false;
				}
				
				if (!$.isNumeric(ph.replace('+','')))
				{
					m='User phone number field must be numeric.';
					DisplayMessage(m, 'error',Title);					
					$('#txtPhone').focus(); return false;
				}
				
				//Usertype
				if (!ut)
				{
					m="Please select the user's usertype.";
					DisplayMessage(m, 'error',Title);					
					$('#cboType').focus(); return false;
				}	
								
				//Account Status
				/*if (!sta)
				{
					m='Please select the user account status.';
					DisplayMessage(m, 'error',Title);					
					$('#cboStatus').focus(); return false;
				}	*/
				
				//Permissions
				if ($('#cboPermissions > option').length==0)
				{
					m='Please assign the necessary permission(s) to the user by selecting the appropriate permission fron the box.';
					DisplayMessage(m, 'error',Title);					
					$('#cboItems').focus(); return false;
				}
				
				$("#cboPermissions > option").each(function() 
				{
					if ($.trim(ut.toLowerCase()) != 'admin')
					{
						if ($.trim(ut.toLowerCase()) != 'gallery')
						{
							if ($.trim(this.value).toLowerCase()=='publish artwork')
							{
								msg='This user cannot be assigned <b>PUBLISH ARTWORK</b> permission.';
								
								//Remove the permission
								$('#cboItems').append( new Option('Publish ArtWork','Publish ArtWork') ); 
					
								$("#cboPermissions > option").each(function (i,pe) {
									if ($.trim(pe.value).toLowerCase()== 'publish artwork') {pe.remove();}
								});
								
								ret=false;
								
								$('#cboPermissions').focus(); return false;
							}	
						}							
					}					
					
					if ($.trim(ut.toLowerCase()) != 'admin')
					{
						if ($.trim(this.value).toLowerCase()=='clear log data')
						{
							msg='This user cannot be assigned <b>CLEAR LOG DATA</b> permission.';
							
							//Remove the permission
							$('#cboItems').append( new Option('Clear Log Data','Clear Log Data') ); 
				
							$("#cboPermissions > option").each(function (i,pe) {
								if ($.trim(pe.value).toLowerCase()== 'clear log data') {pe.remove();}
							});
							
							ret=false; $('#cboPermissions').focus(); return false;
						}	
						
						if ($.trim(this.value).toLowerCase()=='set parameters')
						{
							msg='This user cannot be assigned <b>SET PARAMETERS</b> permission.';
							
							//Remove the permission
							$('#cboItems').append( new Option('Set Parameters','Set Parameters') ); 
				
							$("#cboPermissions > option").each(function (i,pe) {
								if ($.trim(pe.value).toLowerCase()== 'set parameters') {pe.remove();}
							});
							
							ret=false; $('#cboPermissions').focus(); return false;
						}
						
						if ($.trim(this.value).toLowerCase()=='view log reports')
						{
							msg='This user cannot be assigned <b>VIEW LOG REPORTS</b> permission.';
							
							//Remove the permission
							$('#cboItems').append( new Option('View Log Reports','View Log Reports') ); 
				
							$("#cboPermissions > option").each(function (i,pe) {
								if ($.trim(pe.value).toLowerCase()== 'view log reports') {pe.remove();}
							});
							
							ret=false; $('#cboPermissions').focus(); return false;
						}
					}
					
					/*if ($.trim(this.value).toLowerCase()=='set market parameters')
					{
						msg='This user cannot be assigned <b>SET MARKET PARAMETERS</b> permission.';
						
						//Remove the permission
						$('#cboItems').append( new Option('Set Market Parameters','Set Market Parameters') ); 
			
						$("#cboPermissions > option").each(function (i,pe) {
							if ($.trim(pe.value).toLowerCase()== 'set market parameters') {pe.remove();}
						});
						
												
						ret=false; $('#cboPermissions').focus(); return false;
					}*/
					
					/*if ($.trim(this.value).toLowerCase()=='create account')
					{
						msg='This user cannot be assigned <b>CREATE ACCOUNT</b> permission.';
						
						//Remove the permission
						$('#cboItems').append( new Option('Create Account','Create Account') ); 
			
						$("#cboPermissions > option").each(function (i,pe) {
							if ($.trim(pe.value).toLowerCase()== 'create account') {pe.remove();}
						});
						
						ret=false; $('#cboPermissions').focus(); return false;
					}*/					
					
					/*if ($.trim(this.value).toLowerCase()=='delete item')
					{
						msg='This user cannot be assigned <b>DELETE ITEM</b> permission.';
						
						//Remove the permission
						$('#cboItems').append( new Option('Delete Item','Delete Item') ); 
			
						$("#cboPermissions > option").each(function (i,pe) {
							if ($.trim(pe.value).toLowerCase()== 'delete item') {pe.remove();}
						});
						
						ret=false; $('#cboPermissions').focus(); return false;
					}*/
				});	
				
				if (ret==false)
				{
					if (msg != '') DisplayMessage(msg, 'error',Title);
					return false;
				}
				
				
				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: '<font size="3" face="Arial">Do you want to proceed with the editing of the user account?</font>',
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Go Ahead!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Editing User Account. Please Wait...</p>',theme: false,baseZ: 2000});
					
					var ait='0',eit='0',dit='0',cusr='0',vrep='0',vlog='0',spar='0',clog='0',rl='0';
					var pw='0',rb='0',bt='0',vp='0',vo='0',smp='0';
					
					$("#cboPermissions > option").each(function() {
						if ($.trim(this.value).toLowerCase()=='add item') ait='1';
						if ($.trim(this.value).toLowerCase()=='edit item') eit='1';
						if ($.trim(this.value).toLowerCase()=='delete item') dit='1';
						if ($.trim(this.value).toLowerCase()=='create account') cusr='1';
						if ($.trim(this.value).toLowerCase()=='view reports') vrep='1';
						if ($.trim(this.value).toLowerCase()=='view log reports') vlog='1';
						if ($.trim(this.value).toLowerCase()=='set parameters') spar='1';					
						if ($.trim(this.value).toLowerCase()=='clear log data') clog='1';
						if ($.trim(this.value).toLowerCase()=='request listing') rl='1';						
						if ($.trim(this.value).toLowerCase()=='publish artwork') pw='1';						
						if ($.trim(this.value).toLowerCase()=='register broker') rb='1';						
						if ($.trim(this.value).toLowerCase()=='buy and sell token') bt='1';						
						if ($.trim(this.value).toLowerCase()=='view prices') vp='1';						
						if ($.trim(this.value).toLowerCase()=='view orders') vo='1';						
						if ($.trim(this.value).toLowerCase()=='SetMarketParameters') smp='1';
					});										
					
					var mydata={email:em, company:cm, fullname:nm, phone:ph, usertype:ut, accountstatus:sta,AddItem:ait,EditItem:eit,DeleteItem:dit,CreateAccount:cusr,ClearLogFiles:clog,SetParameters:spar,ViewLogReports:vlog,ViewReports:vrep,RequestListing:rl,PublishWork:pw,RegisterBroker:rb,ViewPrices:vp,ViewOrders:vo,SetMarketParameters:smp};
										
					$.ajax({
						url: "<?php echo site_url('admin/Users/EditUsers');?>",
						data: mydata,
						type: 'POST',
						dataType: 'text',
						success: function(data,status,xhr) {	
							$.unblockUI();
							
							var ret='';
							ret=$.trim(data);
							
							if (ret.toUpperCase()=='OK')
							{
								m='User Account with email <b>'+em.toUpperCase()+'('+nm.toUpperCase()+')</b> was edited successfully.';
								
								ResetControls();
								LoadUsers(cm);
								DisplayMessage(m, 'success','User Account Edited','SuccessTheme');
								
								AdminActivateTab('view');
							}else
							{
								m=data;
								DisplayMessage(m, 'error',Title);
							}		
						},
						error:  function(xhr,status,error) {
							$.unblockUI();
							m='Error '+ xhr.status + ' Occurred: ' + error;
							DisplayMessage(m, 'error',Title);
						}
					});
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
		
		function CheckCreate()
		{
			try
			{
				var nm=$.trim($('#txtName').val());
				var em=$.trim($('#txtEmail').val());
				var cm=$.trim($('#cboCompany').val());
				var ph=$.trim($('#txtPhone').val());
				var ut=$.trim($('#cboType').val());
				var sta=$.trim($('#cboStatus').val());
				var pwd=$('#txtPwd').val();
				var cpwd=$('#txtConfirmPwd').val();
				var ret=true,msg='';
									
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the user account creation.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}
				
				//Company Name
				if ($('#cboCompany > option').length < 2)
				{
					m='No broker record has been captured. Please contact the system administrator.';
					DisplayMessage(m, 'error',Title);					
					return false;
				}
				
				if (!cm)
				{
					m='Please select the user company.';
					DisplayMessage(m, 'error',Title);					
					$('#cboCompany').focus(); return false;
				}
				
				//Full Name
				if (!nm)
				{
					m='User fullname field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtName').focus(); return false;
				}
				
				if ($.isNumeric(nm))
				{
					m='User fullname field must not be a number.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtName').focus(); return false;
				}
				
				if (nm.length<3)
				{
					m='Please enter the user fullname in full.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtName').focus(); return false;
				}
				
								
				//Emails
				if (!em)
				{
					m='User email field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtEmail').focus(); return false;
				}
				
				if (!isEmail(em))
				{
					m='User email is not valid.';
					DisplayMessage(m, 'error',Title);					
					$('#txtEmail').focus(); return false;
				}
				
				//Phone								
				if (!ph)
				{
					m='User phone number field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtPhone').focus(); return false;
				}
				
				if (!$.isNumeric(ph.replace('+','')))
				{
					m='User phone number field must be numeric.';
					DisplayMessage(m, 'error',Title);					
					$('#txtPhone').focus(); return false;
				}	
				
				//Pwd
				if (!$.trim(pwd))
				{
					m='Password field must not be blank.';
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
					m='Password and confirming password fields do not match.';
					DisplayMessage(m, 'error',Title);					
					return false;
				}
				
				//Usertype
				if (!ut)
				{
					m="Please select the user's usertype.";
					DisplayMessage(m, 'error',Title);					
					$('#cboType').focus(); return false;
				}
				
				//Account Status
				/*if (!sta)
				{
					m='Please select the user account status.';
					DisplayMessage(m, 'error',Title);					
					$('#cboStatus').focus(); return false;
				}	*/
				
				//Permissions
				if ($('#cboPermissions > option').length==0)
				{
					m='Please assign the necessary permission(s) to the user by selecting the appropriate permission from the box.';
					DisplayMessage(m, 'error',Title);					
					$('#cboItems').focus(); return false;
				}
				
				$("#cboPermissions > option").each(function() 
				{
					if ($.trim(ut.toLowerCase()) != 'admin')
					{
						if ($.trim(ut.toLowerCase()) != 'gallery')
						{
							if ($.trim(this.value).toLowerCase()=='publish artwork')
							{
								msg='This user cannot be assigned <b>PUBLISH ARTWORK</b> permission.';
								
								//Remove the permission
								$('#cboItems').append( new Option('Publish ArtWork','Publish ArtWork') ); 
					
								$("#cboPermissions > option").each(function (i,pe) {
									if ($.trim(pe.value).toLowerCase()== 'publish artwork') {pe.remove();}
								});
								
								ret=false;
								
								$('#cboPermissions').focus(); return false;
							}	
						}							
					}					
					
					if ($.trim(ut.toLowerCase()) != 'admin')
					{
						if ($.trim(this.value).toLowerCase()=='clear log data')
						{
							msg='This user cannot be assigned <b>CLEAR LOG DATA</b> permission.';
							
							//Remove the permission
							$('#cboItems').append( new Option('Clear Log Data','Clear Log Data') ); 
				
							$("#cboPermissions > option").each(function (i,pe) {
								if ($.trim(pe.value).toLowerCase()== 'clear log data') {pe.remove();}
							});
							
							ret=false; $('#cboPermissions').focus(); return false;
						}	
						
						if ($.trim(this.value).toLowerCase()=='set parameters')
						{
							msg='This user cannot be assigned <b>SET PARAMETERS</b> permission.';
							
							//Remove the permission
							$('#cboItems').append( new Option('Set Parameters','Set Parameters') ); 
				
							$("#cboPermissions > option").each(function (i,pe) {
								if ($.trim(pe.value).toLowerCase()== 'set parameters') {pe.remove();}
							});
							
							ret=false; $('#cboPermissions').focus(); return false;
						}
						
						if ($.trim(this.value).toLowerCase()=='view log reports')
						{
							msg='This user cannot be assigned <b>VIEW LOG REPORTS</b> permission.';
							
							//Remove the permission
							$('#cboItems').append( new Option('View Log Reports','View Log Reports') ); 
				
							$("#cboPermissions > option").each(function (i,pe) {
								if ($.trim(pe.value).toLowerCase()== 'view log reports') {pe.remove();}
							});
							
							ret=false; $('#cboPermissions').focus(); return false;
						}
					}
					
					/*if ($.trim(this.value).toLowerCase()=='set market parameters')
					{
						msg='This user cannot be assigned <b>SET MARKET PARAMETERS</b> permission.';
						
						//Remove the permission
						$('#cboItems').append( new Option('Set Market Parameters','Set Market Parameters') ); 
			
						$("#cboPermissions > option").each(function (i,pe) {
							if ($.trim(pe.value).toLowerCase()== 'set market parameters') {pe.remove();}
						});
						
												
						ret=false; $('#cboPermissions').focus(); return false;
					}*/
					
					/*if ($.trim(this.value).toLowerCase()=='create account')
					{
						msg='This user cannot be assigned <b>CREATE ACCOUNT</b> permission.';
						
						//Remove the permission
						$('#cboItems').append( new Option('Create Account','Create Account') ); 
			
						$("#cboPermissions > option").each(function (i,pe) {
							if ($.trim(pe.value).toLowerCase()== 'create account') {pe.remove();}
						});
						
						ret=false; $('#cboPermissions').focus(); return false;
					}*/					
					
					/*if ($.trim(this.value).toLowerCase()=='delete item')
					{
						msg='This user cannot be assigned <b>DELETE ITEM</b> permission.';
						
						//Remove the permission
						$('#cboItems').append( new Option('Delete Item','Delete Item') ); 
			
						$("#cboPermissions > option").each(function (i,pe) {
							if ($.trim(pe.value).toLowerCase()== 'delete item') {pe.remove();}
						});
						
						ret=false; $('#cboPermissions').focus(); return false;
					}*/
				});	
				
				if (ret==false)
				{
					if (msg != '') DisplayMessage(msg, 'error',Title);
					return false;
				}				
				
				
				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: '<font size="3" face="Arial">Do you want to proceed with the user account creation?</font>',
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Go Ahead!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Creating User Account. Please Wait...</p>',theme: false,baseZ: 2000});
					
					var ait='0',eit='0',dit='0',cusr='0',vrep='0',vlog='0',spar='0',clog='0',rl='0';
					var pw='0',rb='0',bt='0',vp='0',vo='0',smp='0';
					
					$("#cboPermissions > option").each(function() {
						if ($.trim(this.value).toLowerCase()=='add item') ait='1';
						if ($.trim(this.value).toLowerCase()=='edit item') eit='1';
						if ($.trim(this.value).toLowerCase()=='delete item') dit='1';
						if ($.trim(this.value).toLowerCase()=='create account') cusr='1';
						if ($.trim(this.value).toLowerCase()=='view reports') vrep='1';
						if ($.trim(this.value).toLowerCase()=='view log reports') vlog='1';
						if ($.trim(this.value).toLowerCase()=='set parameters') spar='1';					
						if ($.trim(this.value).toLowerCase()=='clear log data') clog='1';
						if ($.trim(this.value).toLowerCase()=='request listing') rl='1';						
						if ($.trim(this.value).toLowerCase()=='publish artwork') pw='1';						
						if ($.trim(this.value).toLowerCase()=='register broker') rb='1';						
						if ($.trim(this.value).toLowerCase()=='buy and sell token') bt='1';						
						if ($.trim(this.value).toLowerCase()=='view prices') vp='1';						
						if ($.trim(this.value).toLowerCase()=='view orders') vo='1';						
						if ($.trim(this.value).toLowerCase()=='SetMarketParameters') smp='1';
					});										
					
					var mydata={email:em, company:cm, fullname:nm, phone:ph, pwd:AES256.encrypt($('#txtPwd').val(),'<?php echo ACCESS_STAMP; ?>'), usertype:ut, accountstatus:sta,AddItem:ait,EditItem:eit,DeleteItem:dit,CreateAccount:cusr,ClearLogFiles:clog,SetParameters:spar,ViewLogReports:vlog,ViewReports:vrep,RequestListing:rl,PublishWork:pw,RegisterBroker:rb,ViewPrices:vp,ViewOrders:vo,SetMarketParameters:smp};
			
					$.ajax({
						url: "<?php echo site_url('admin/Users/AddUsers');?>",
						data: mydata,
						type: 'POST',
						dataType: 'text',
						success: function(data,status,xhr) {	
							$.unblockUI();
							
							var ret='';
							ret=$.trim(data);
							
							if (ret.toUpperCase()=='OK')
							{					
								m="User account was created successfully but the account has not been activated. An email has been sent to <b>"+em+"</b>. The user will have to click on the link in the email to activate the account.";
								
								ResetControls();
								LoadUsers(cm);
								DisplayMessage(m, 'success','User Account Created','SuccessTheme');
								
								AdminActivateTab('view');
							}else
							{
								m=data;
								DisplayMessage(m, 'error',Title);
							}		
						},
						error:  function(xhr,status,error) {
							$.unblockUI();
							m='Error '+ xhr.status + ' Occurred: ' + error;
							DisplayMessage(m, 'error',Title);
						}
					});
				}
			})	
			}catch(e)
			{
				$.unblockUI();
				m='CheckCreate ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End CheckCreate
		
		$('#btnAdd').click(function(e) {
			try
			{
				$('#cboItems > option:selected').appendTo('#cboPermissions');
				e.preventDefault();
				if ($('#cboItems > option').length > 0) SortList('cboItems');
				SortList('cboPermissions');
			}catch(e)
			{
				$.unblockUI();
				m='Add Selected Permissions Click ERROR:\n'+e;
				DisplayMessage(m, 'error',Title);;				
				return false;
			}
		});

		$('#cboItems').dblclick(function(e) {
		   try
		   {
				$('#btnAdd').trigger('click')
			}catch(e)
			{
				$.unblockUI();
				m='Add Selected Permissions Double Click ERROR:\n'+e;					
				DisplayMessage(m, 'error',Title);
				return false;
			}
		}); 			

		$('#btnAddAll').click(function(e) {
			try
			{
				$('#cboItems > option').appendTo('#cboPermissions');
				e.preventDefault();
				if ($('#cboPermissions > option').length > 0) SortList('cboPermissions');
			}catch(e)
			{
				$.unblockUI();
				m='Add All Permissions Click ERROR:\n'+e;
				DisplayMessage(m, 'error',Title);				
				return false;
			}
		});
		
		$('#btnRemove').click(function(e) {
			try
			{
				$('#cboPermissions > option:selected').appendTo('#cboItems');
				e.preventDefault();
				SortList('cboItems');
				if ($('#cboPermissions > option').length > 0) SortList('cboPermissions');
			}catch(e)
			{
				$.unblockUI();
				m='Remove Selected Permissions Click ERROR:\n'+e;
				DisplayMessage(m, 'error',Title);				
				return false;
			}
		});
		
		$('#cboPermissions').dblclick(function(e) {
		   try
		   {
				$('#btnRemove').trigger('click')
			}catch(e)
			{
				$.unblockUI();
				m='Remove Selected Permissions Double Click ERROR:\n'+e;
				DisplayMessage(m, 'error',Title);		
				return false;
			}
		}); 
						
		$('#btnRemoveAll').click(function(e) {
			try
			{
				LoadPermissions();
			}catch(e)
			{
				$.unblockUI();
				m='Remove All Permissions Click ERROR:\n'+e;					
				DisplayMessage(m, 'error',Title);				
				return false;
			}
		});
    });//Document Ready
	
	function LoadCompanies()
	{
		try
		{
			$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Companies. Please Wait...</p>',theme: false,baseZ: 2000});				

			$('#cboCompany').empty();
			$("#cboCompany").append(new Option("[SELECT]", ""));
			$("#cboCompany").append(new Option("LVI", "LVI"));				

			$.ajax({
				url: "<?php echo site_url('admin/Users/GetCompanies');?>",
				type: 'POST',
				dataType: 'json',
				success: function(data,status,xhr) {	
					$.unblockUI();

					if ($(data).length > 0)
					{						
						$.each($(data), function(i,e)
						{
							if (e.company) $("#cboCompany").append(new Option($.trim(e.company), $.trim(e.company)));
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
			m='LoadCompanies ERROR:\n'+e;
			DisplayMessage(m, 'error',Title);
		}
	}
	
	function LoadUsers(cm)
	{
		try
		{
			$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Users. Please Wait...</p>',theme: false,baseZ: 2000});			

			$('#recorddisplay > tbody').html('');
		
			$.ajax({
				url: "<?php echo site_url('admin/Users/LoadUsers');?>",
				data:{company:cm},
				type: 'POST',
				dataType: 'json',
				success: function(data,status,xhr) {	
					$.unblockUI();
					
					if ($(data).length > 0)
					{
						var j=0;

						$.each($(data), function(i,e)
						{
							if (e.email)
							{
								var tb='';
								
								j+=1;
								
								var x = (j % 2);//Even = 0, Odd=1
								
								//Build Records
								var perm='', accsta='', edt='', del='';
		
								if (e.AddItem=='1') perm='Add Item';
								
								if (e.EditItem=='1')
								{
									if (!perm) perm='Edit Item'; else perm += ', Edit Item';
								}
								
								if (e.DeleteItem=='1')
								{
									if (!perm) perm='Delete Item'; else perm += ', Delete Item';
								}
								
								if (e.CreateAccount=='1')
								{
									if (!perm) perm='Create Account'; else perm += ', Create Account';
								}
								if (e.ManageUsers=='1')
								{
									if (!perm) perm='Manage Users'; else perm += ', Manage Users';
								}
								
								if (e.ClearLogFiles=='1')
								{
									if (!perm) perm='Clear Log Files'; else perm += ', Clear Log Files';
								}
							
								if (e.SetParameters=='1')
								{
									if (!perm) perm='Set Parameters'; else perm += ', Set Parameters';
								}	

								if (e.ViewLogReports=='1')
								{
									if (!perm) perm='View Log Reports'; else perm += ', View Log Reports';
								}
								
								if (e.ViewReports=='1')
								{
									if (!perm) perm='View Reports'; else perm += ', View Reports';
								}								
								
								if (e.RequestListing=='1')
								{
									if (!perm) perm='Request Listing'; else perm += ', Request Listing';
								}
								
								if (e.PublishWork=='1')
								{
									if (!perm) perm='Publish ArtWork'; else perm += ', Publish ArtWork';
								}
								
								if (e.RegisterBroker=='1')
								{
									if (!perm) perm='Register Broker'; else perm += ', Register Broker';
								}
								
								if (e.BuyAndSellToken=='1')
								{
									if (!perm) perm='Buy And Sell Token'; else perm += ', Buy And Sell Token';
								}
																
								if (e.ViewPrices=='1')
								{
									if (!perm) perm='View Prices'; else perm += ', View Prices';
								}
								
								if (e.ViewOrders=='1')
								{
									if (!perm) perm='View Orders'; else perm += ', View Orders';
								}
								
								if (e.SetMarketParameters=='1')
								{
									if (!perm) perm='Set Market Parameters'; else perm += ', Set Market Parameters';
								}							
																
								if (e.accountstatus=='1')
								{
									accsta='<font color="#249A47">Active</font>';
								}else
								{
									accsta='<font color="#BD1111">Non-Active</font>';
								}
	
								edt='<img onClick="SelectRow(\''+e.email+'\',\''+e.company+'\',\''+e.fullname+'\',\''+e.phone+'\',\''+e.accountstatus+'\',\''+e.usertype+'\',\''+e.AddItem+'\',\''+e.EditItem+'\',\''+e.DeleteItem+'\',\''+e.CreateAccount+'\',\''+e.ManageUsers+'\',\''+e.ClearLogFiles+'\',\''+e.SetParameters+'\',\''+e.ViewLogReports+'\',\''+e.ViewReports+'\',\''+e.RequestListing+'\',\''+e.PublishWork+'\',\''+e.RegisterBroker+'\',\''+e.BuyAndSellToken+'\',\''+e.ViewPrices+'\',\''+e.ViewOrders+'\',\''+e.SetMarketParameters+'\')" style="cursor:pointer; height:30px; " src="<?php echo base_url();?>images/view_icon.png" title="Click To Edit '+ $.trim(e.fullname).toUpperCase() + '(' + e.email + ')\'s Record">';
	
							
								var DeleteItem='<?php echo $DeleteItem; ?>';
								
								if (parseInt(DeleteItem,10)==1)
								{
									del='<img onClick="DeleteRow(\''+e.email+'\',\''+e.company+'\',\''+e.fullname+'\')" style="cursor:pointer; height:30px;" src="<?php echo base_url();?>images/delete_icon.png" title="Click To Delete '+$.trim(e.fullname).toUpperCase() +'(' + e.email +')">';	
								}else
								{
									del='';
								}									

								if (e.company) tb += '<td style="text-align:center" width="10%">'+e.company+'</td>'; else tb += '<td></td>';
								if (e.email) tb += '<td style="text-align:center" width="13%">'+e.email+'</td>'; else tb += '<td></td>';
								if (e.fullname) tb += '<td style="text-align:center" width="13%">'+e.fullname+'</td>'; else tb += '<td></td>';
								if (e.phone) tb += '<td style="text-align:center" width="9%">'+e.phone+'</td>'; else tb += '<td></td>';
								if (e.usertype) tb += '<td style="text-align:center" width="5%">'+e.usertype+'</td>'; else tb += '<td></td>';
								if (perm) tb += '<td style="text-align:center" width="30%">'+perm+'</td>'; else tb += '<td></td>';
								if (e.date_created) tb += '<td style="text-align:center" width="7%">'+e.date_created+'</td>'; else tb += '<td></td>';
								if (accsta) tb += '<td style="text-align:center" width="5%">'+accsta+'</td>'; else tb += '<td></td>';
								tb += '<td style="text-align:center" width="4%">'+ edt +'</td>';
								tb += '<td style="text-align:center" width="4%">'+del+'</td>';
								
								$('<tr>', { html: tb }).appendTo($("#tbbody"));
							}
						});//End each
						
					}		
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
			m='LoadUsers ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}


	function SelectRow(em,cm,fn,ph,sta,ut,ait,eit,dit,cusr,clog,spar,vlog,vrep,rl,pw,rb,bt,vp,vo,smp)
	{
		try
		{
			if (document.getElementById('btnEdit')) document.getElementById('btnEdit').disabled=false;
			if (document.getElementById('btnCreate')) document.getElementById('btnCreate').disabled=true;

			$('#txtEmail').val(em);
			$('#txtName').val(fn);
			$('#txtPhone').val(ph);
			$('#cboStatus').val(sta);
			$('#cboType').val(ut);
			$('#cboCompany').val(cm);
			
			$('#txtEmail').prop('disabled',true);
			
			LoadPermissions();

			if (parseInt(ait,10)==1) 
			{
				$('#cboPermissions').append( new Option('Add Item','Add Item') ); 
				
				$("#cboItems > option").each(function (i,e) {
					if ($.trim(e.value).toLowerCase()== 'add item') {e.remove();}
				});
			}
			
			if (parseInt(eit,10)==1)
			{
				$('#cboPermissions').append( new Option('Edit Item','Edit Item') ); 
				
				$("#cboItems > option").each(function (i,e) {
					if ($.trim(e.value).toLowerCase() == 'edit item') {e.remove();}
				});
			}
	
			if (parseInt(dit,10)==1)
			{
				$('#cboPermissions').append( new Option('Delete Item','Delete Item') );
				
				$("#cboItems > option").each(function (i,e) {
					if ($.trim(e.value).toLowerCase() == 'delete item') e.remove();
				});
			}
			
			if (parseInt(cusr,10)==1)
			{
				$('#cboPermissions').append( new Option('Create Account','Create Account') );
				
				$("#cboItems > option").each(function (i,e) {
					if ($.trim(e.value).toLowerCase() == 'create account') e.remove();
				});
			}
			
			if (parseInt(clog,10)==1)
			{
				$('#cboPermissions').append( new Option('Clear Log Data','Clear Log Data') );
				
				$("#cboItems > option").each(function (i,e) {
					if ($.trim(e.value).toLowerCase() == 'clear log data') e.remove();
				});
			}
				
			if (parseInt(spar,10)==1)
			{
				$('#cboPermissions').append( new Option('Set Parameters','Set Parameters') );
				
				$("#cboItems > option").each(function (i,e) {
					if ($.trim(e.value).toLowerCase() == 'set parameters') e.remove();
				});
			}
			
			if (parseInt(vlog,10)==1)
			{
				$('#cboPermissions').append( new Option('View Log Reports','View Log Reports') );
				
				$("#cboItems > option").each(function (i,e) {
					if ($.trim(e.value).toLowerCase() == 'view log reports') e.remove();
				});
			}
		
			
			if (parseInt(vrep,10)==1)
			{
				$('#cboPermissions').append( new Option('View Reports','View Reports') );
				
				$("#cboItems > option").each(function (i,e) {
					if ($.trim(e.value).toLowerCase() == 'view reports') e.remove();
				});
			}
				
			if (parseInt(rl,10)==1)
			{
				$('#cboPermissions').append( new Option('Request Listing','Request Listing') );
				
				$("#cboItems > option").each(function (i,e) {
					if ($.trim(e.value).toLowerCase() == 'request listing') e.remove();
				});
			}			
		
			if (parseInt(pw,10)==1)
			{
				$('#cboPermissions').append( new Option('Publish ArtWork','Publish ArtWork') );
				
				$("#cboItems > option").each(function (i,e) {
					if ($.trim(e.value).toLowerCase() == 'publish artwork') e.remove();
				});
			}			
			
			if (parseInt(rb,10)==1)
			{
				$('#cboPermissions').append( new Option('Register Broker','Register Broker') );
				
				$("#cboItems > option").each(function (i,e) {
					if ($.trim(e.value).toLowerCase() == 'register broker') e.remove();
				});
			}
			
			if (parseInt(bt,10)==1)
			{
				$('#cboPermissions').append( new Option('Buy And Sell Token','Buy And Sell Token') );
				
				$("#cboItems > option").each(function (i,e) {
					if ($.trim(e.value).toLowerCase() == 'buy and sell token') e.remove();
				});
			}
			
			if (parseInt(vp,10)==1)
			{
				$('#cboPermissions').append( new Option('View Prices','View Prices') );
				
				$("#cboItems > option").each(function (i,e) {
					if ($.trim(e.value).toLowerCase() == 'view prices') e.remove();
				});
			}
			
			if (parseInt(vo,10)==1)
			{
				$('#cboPermissions').append( new Option('View Orders','View Orders') );
				
				$("#cboItems > option").each(function (i,e) {
					if ($.trim(e.value).toLowerCase() == 'view orders') e.remove();
				});
			}
			
			if (parseInt(smp,10)==1)
			{
				$('#cboPermissions').append( new Option('Set Market Parameters','Set Market Parameters') );
				
				$("#cboItems > option").each(function (i,e) {
					if ($.trim(e.value).toLowerCase() == 'set market parameters') e.remove();
				});
			}

			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m='SelectRow ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}
	
	function DeleteRow(em,company,fullname)
	{			
		try
		{
			if (!em)
			{
				m='There is a problem with the selected row. Click on REFRESH button to refresh the page. If this message keeps coming up, please contact us at support@naijaartmart.com.';
				
				DisplayMessage(m,'error',Title);
				return false;
			}else
			{
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: '<font size="3" face="Arial">Are you sure you want to delete the user account with email "'+em.toUpperCase()+'('+fullname+')" from the database?. Please note that this action is irreversible.</font>',
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Go Ahead!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Deleting User Account. Please Wait...</p>',theme: false,baseZ: 2000});
					
					$('#divAlert').html('');
					
					m=''
					
					//Make Ajax Request			
					$.ajax({
						url: '<?php echo site_url('admin/Users/DeleteUser'); ?>',
						data: {email:em,fullname:fullname,company:company},
						type: 'POST',
						dataType: 'text',
						success: function(data,status,xhr) {				
							$.unblockUI();
													
							if ($.trim(data).toUpperCase() == 'OK')
							{
								ResetControls();									
								LoadUsers(company);
								
								m='User Account with email <b>'+em.toUpperCase()+'('+fullname.toUpperCase()+')</b> was deleted successfully.';
								DisplayMessage(m, 'success','User Account Deleted','SuccessTheme');
																	
								AdminActivateTab('view');
							}else
							{
								m=data;
								DisplayMessage(m,'error',Title);
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
			m='Delete User Button Click ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}
	
	function ResetControls()
	{
		try
		{					
			if (document.getElementById('btnEdit')) document.getElementById('btnEdit').disabled=true;
			if (document.getElementById('btnCreate')) document.getElementById('btnCreate').disabled=false;
			
			$('#txtName').val('');
			$('#txtEmail').val('');
			$('#txtPhone').val('');				
			$('#cboCompany').val('');	
			$('#cboType').val('');				
			$('#cboStatus').val('');				
			$('#txtPwd').val('');
			$('#txtConfirmPwd').val('');
			
			LoadPermissions();
			
			$('#txtEmail').prop('disabled',false); 
			$('#txtPwd').prop('disabled',false); 
			$('#txtConfirmPwd').prop('disabled',false);
			
			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m="ResetControls ERROR:\n"+e;
			DisplayMessage(m,'error',Title);
		}
	}//End ResetControls
	
	function SortList(id)
	{
		var prePrepend = "#";

		if (id.match("^#") == "#") prePrepend = "";

		$(prePrepend + id).html($(prePrepend + id + " option").sort(
			function (a, b) { return a.text == b.text ? 0 : a.text < b.text ? -1 : 1 })
		);
	}
		
	function LoadPermissions()
	{
		try
		{
			$('#cboItems').empty();
			$('#cboPermissions').empty();
			
			$('#cboItems').append( new Option('Add Item','Add Item') );
			$('#cboItems').append( new Option('Clear Log Data','Clear Log Data') );
			$('#cboItems').append( new Option('Create Account','Create Account') );
			$('#cboItems').append( new Option('Manage Users','Manage Users') );
			$('#cboItems').append( new Option('Delete Item','Delete Item') );
			$('#cboItems').append( new Option('Edit Item','Edit Item') );
			$('#cboItems').append( new Option('Set Parameters','Set Parameters') );
			$('#cboItems').append( new Option('View Log Reports','View Log Reports') );
			$('#cboItems').append( new Option('View Reports','View Reports') );
			$('#cboItems').append( new Option('Request Listing','Request Listing') );			
			$('#cboItems').append( new Option('Publish ArtWork','Publish ArtWork') );
			$('#cboItems').append( new Option('Register Broker','Register Broker') );
			$('#cboItems').append( new Option('Buy And Sell Token','Buy And Sell Token') );
			$('#cboItems').append( new Option('View Prices','View Prices') );
			$('#cboItems').append( new Option('View Orders','View Orders') );
			$('#cboItems').append( new Option('Set Market Parameters','Set Market Parameters') );			
						
			SortList('cboItems');		

			$('#cboPermissions').prop('disabled',false);
			$('#btnRemove').prop('disabled',false);
			$('#btnRemoveAll').prop('disabled',false);
		}catch(e)
		{
			$.unblockUI();
			m="LoadPermissions ERROR:\n"+e;
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
                                                    System Users
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
                                <span>User Data</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabView" data-toggle="tab" href="#view">
                                <span>View Users</span>
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
                                        <!--Company-->
                                        <div class="position-relative row form-group">
                                        	<label title="Company" for="cboCompany" class="col-sm-2 col-form-label">Company<span class="redtext">*</span></label>
                                            
                                            <div title="Company" class="col-sm-4">
                                            	 <select id="cboCompany" class="form-control"></select>
                                             </div>
                                             
                                             <!--Fullname-->
                                             <label for="txtName" class="col-sm-2 col-form-label text-right">User Fullname<span class="redtext">*</span></label>
                                             
                                             <div title="User Fullname" class="col-sm-4"><input id="txtName" placeholder="User Fullname" type="text" class="form-control"></div>
                                        </div>
                                        
                                        
                                        <!--Email/Phone-->
                                         <div class="position-relative row form-group">
                                         	<!--Email-->
                                            <label title="User Email" for="txtEmail" class="col-sm-2 col-form-label">User Email<span class="redtext">*</span></label>
                                            <div title="User Email" class="col-sm-4"><input id="txtEmail" placeholder="User Email" type="email" class="form-control"></div>
                                            
                                            <!--Phone-->
                                            <label title="User Phone" for="txtPhone" class="col-sm-2 col-form-label text-right">User Phone<span class="redtext">*</span></label>
                                            
                                            <div title="User Phone" class="col-sm-4"><input id="txtPhone" placeholder="User Phone" type="tel" class="form-control"></div>
                                        </div>
                                        
                                                                                
                                        <!--Password/ConfirmPwd-->
                                        <div class="position-relative row form-group">
                                        	<label title="User Password" for="txtPwd" class="col-sm-2 col-form-label">User Password<span class="redtext">*</span></label>
                                            
                                            <div title="User Password" class="col-sm-4"><input autocomplete="new-password" id="txtPwd" placeholder="User Password" type="password" class="form-control"></div>
                                            
                                            <!--Confirm Password-->
                                            <label title="Confirm User Password" for="txtConfirmPwd" class="col-sm-2 col-form-label text-right">Confirm Pwd<span class="redtext">*</span></label>
                                            
                                            <div title="Confirm User Password" class="col-sm-4"><input id="txtConfirmPwd" placeholder="Confirm User Password" type="password" class="form-control"></div>
                                        </div>
                                        
                                         <!--User Type/Account Status-->
                                        <div class="position-relative row form-group">
                                        	<label title="User Type" for="cboType" class="col-sm-2 col-form-label">User Type<span class="redtext">*</span></label>
                                            
                                            <div title="User Type" class="col-sm-4">
                                                <select id="cboType" class="form-control">
                                                    <option value="">[SELECT]</option>
                                                    <option value="Operator">Operator</option>
                                                    <option value="Gallery">Gallery Personnel</option>
                                                    <option value="Admin">Admin</option>
                                                  </select>
                                           </div>
                                           
                                           
                                           <!--Account Status-->
                                           <!--Status-->
                                        	<label title="User Account Status"  for="cboStatus" class="col-sm-2 col-form-label text-right">Account Status</label>
                                            
                                            <div title="User Account Status"  class="col-sm-4">
                                                <select id="cboStatus" class="form-control">
                                                    <option value="">[SELECT]</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Disabled</option>
                                                  </select>
                                           </div>
                                       
                                        </div>
                                    </form>
                                </div>
                            </div>                                   
                    
                            <div class="main-card mb-3 card">
                            	 <div class="card-body" style="padding:5px;">
                                 	<span class="card-title">Select User Permissions</span>
                                 </div>
                                
                                <div title="Select User Permissions" class="card-body row form-group" style="padding:5px;">
                                
                                
                                    <div class="controls col-sm-5">
                                       <!--User Permissions Label-->                                        
                                         <div id="divItems" align="center" class="divTableCell">
                                                <select size="10" id="cboItems" multiple class="form-control size-15"></select>
                                          </div>
                                    </div>
                                    
                                    <div class="controls col-sm-2 divTableCell">
                                            <input title="Add selected permissions" type="button" id="btnAdd" value=">" style="width: 60px; font-weight:bold; font-size:16px;" /><br>
                                            <input title="Add all permissions" type="button" id="btnAddAll" value=">>" style="width: 60px; font-weight:bold; font-size:16px; margin-top:10px;" /><br>
                                            <input title="Remove selected permissions" type="button" id="btnRemove" value="<" style="width: 60px; font-weight:bold; font-size:16px; margin-top:10px;" /><br>
                                            <input title="Remove all permissions" type="button" id="btnRemoveAll" value="<<" style="width: 60px; font-weight:bold; font-size:16px; margin-top:10px;" />                                        
                                    </div>
                                    
                                    <div class="controls col-sm-5">                                      
                                            <select size="10" id="cboPermissions" multiple class="form-control size-15"></select>                                         
                                    </div>
                                                                       
                                </div>
                               	
                                <div style="padding-bottom:20px;" align="center" id="divAlert" data-type="info" class="btn-show-swal"></div>
                                
                                <div align="center">
									 <?php
                                            if ($AddItem==1)
                                            {
                                                echo '<button id="btnCreate" type="button" class="btn btn-primary makebold">Create User</button>';
                                            }													
    
                                            if ($EditItem==1)
                                            {
                                                echo '<button style="margin-left:10px;" id="btnEdit" type="button" class="btn btn-info makebold">Edit User</button>';
                                            }
                                        ?>                                	
                                        
                                        <a style="margin-left:10px;" onClick="window.location.reload(true);" href="#" class="btn btn-danger makebold">Refresh</a>
                                        
                                </div><br><br><br>
                            </div>
                        </div>
                        
                        <div class="tab-pane tabs-animation fade" id="view" role="tabpanel">
                        	<div class="row">
                            	<div class="col-md-12">
                                	<div class="mb-3 card">
                                        <div class="card-body">
                                            <table class="hover table table-responsive table-bordered data-table display" id="recorddisplay">
                                              <thead>
                                                <tr>
                                                    <th align="center" width="10%">COMPANY</th>
                                                    <th align="center" width="13%">EMAIL</th> 
                                                    <th align="center" width="13%">NAME</th> 
                                                    <th align="center" width="9%">PHONE</th> 
                                                    <th align="center" width="5%">USERTYPE</th>
                                                    <th align="center" width="30%">PERMISSIONS</th>          
                                                    <th align="center" width="7%">DATE&nbsp;CREATED</th>
                                                    <th align="center" width="5%">STATUS</th>
                                                    <th align="center" width="4%">SELECT</th>
                                                    <th align="center" width="4%">DELETE</th> 
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
