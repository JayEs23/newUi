<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Derived Homes - User Profile</title>
    <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Naija Art Mart - The New Art Market For Everyone">    
    <meta name="msapplication-tap-highlight" content="no"><!-- Disable tap highlight on IE -->

	<?php include('header.php'); ?>
    <?php include('scripts.php'); ?>

	<script>
	
	var Title='<font color="#AF4442">Update Profile Message</font>';
	
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
		
		$('#btnUpdate').click(function(e) {
			try
			{
				if (!CheckForm()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Update Profile Button Clicked ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
		});//btnUpdate Click Ends
		
		
		$('#btnChange').click(function(e) {
			try
			{
				if (!CheckPwd()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Change Password Button Clicked ERROR:\n'+e;				
				DisplayMessage(m, 'error','Password Change');
				return false;
			}
		});//btnChange Click Ends
		
		function CheckPwd()
		{
			var m='';
			
			try
			{
				var opwd=$.trim($('#txtOldPwd').val());
				var em='<?php echo $email; ?>';
				var npwd=$.trim($('#txtNewPwd').val());
				var cpwd=$.trim($('#txtCPwd').val());
				
				//Email
				if (!em)
				{
					m='Email field is blank. Refresh the window. If it is still blank, log out and log in again before continuing with the profile update.';
					
					DisplayMessage(m, 'error','Password Change');
					return false;
				}
				
				//Old Password
				if (!opwd)
				{
					m='Old password field must not be blank.';
					DisplayMessage(m, 'error','Password Change');
					$('#txtOldPwd').focus();
					return false;
				}
				
				//New Password
				if (!npwd)
				{
					m='New password field must not be blank.';
					DisplayMessage(m, 'error','Password Change');
					return false;
				}
				
				var v=IsValidPassord(npwd,em,8);
					
				if (v != 1)
				{
					DisplayMessage(v, 'error',Title);					
					return false;
				}
				
				//Confirm Password
				if (npwd != cpwd)
				{
					m='New password and confirming password do not match.';
					
					DisplayMessage(m, 'error','Password Change');
					return false;
				}
								
				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  text: "This action will permanently modify your password. Do you want to proceed with the password change?",
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Yes, Go Ahead!'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Changing Password. Please Wait...</p>',theme: false,baseZ: 2000});

					var mydata={pwd:AES256.encrypt($('#txtNewPwd').val(),'<?php echo ACCESS_STAMP; ?>'),opwd:AES256.encrypt($('#txtOldPwd').val(),'<?php echo ACCESS_STAMP; ?>'),email:em};
					
					$.ajax({
						url: "<?php echo site_url('admin/Profile/ChangePassword');?>",
						data: mydata,
						type: 'POST',
						dataType: 'text',
						success: function(data,status,xhr) {	
							$.unblockUI();
							
							var ret='';
							ret=$.trim(data);
							
							if (ret.toUpperCase()=='OK')
							{
								m='Password Change Was Successful';
								DisplayMessage(m, 'success','Password Change','SuccessTheme');
								setTimeout(function() {
									window.location.reload(true);
								}, 3000);
							}else
							{
								m=data;
								
								DisplayMessage(m,'error','Password Change');
							}		
						},
						error:  function(xhr,status,error) {
							$.unblockUI();
							m='Error '+ xhr.status + ' Occurred: ' + error;
							DisplayMessage(m,'error','Password Change');
						}
					});
				  }
				})
			}catch(e)
			{
				$.unblockUI();
				m='CheckForm ERROR:\n'+e;
				
				DisplayMessage(m,'error',Title);
			}
		}
		
		
		function CheckForm()
		{
			var m='';
			
			try
			{
				var nm=$.trim($('#txtName').val());
				var em='<?php echo $email; ?>';
				var ph=$.trim($('#txtPhone').val());
				
				//Email
				if (!em)
				{
					m='Email field is blank. Refresh the window. If it is still blank, log out and log in again before continuing with the profile update.';
					
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				
				if (!nm)
				{
					m='Fullname field must not be blank.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtName').focus(); return false;
				}
				
				if ($.isNumeric(nm))
				{
					m='Fullname field must not be a number.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtName').focus(); return false;
				}
				
				if (nm.length<2)
				{
					m='Fullname must be in full.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtName').focus(); return false;
				}		
				
				//Phone								
				if (ph)
				{
					if (!$.isNumeric(ph.replace('+','')))
					{
						m='Phone number field must be numeric.';						
						DisplayMessage(m, 'error',Title);						
						$('#txtPhone').focus(); return false;
					}	
				}
								
				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  text: "This action will permanently modify your profile record. Do you want to proceed with your profile update?",
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Yes, Go Ahead!'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Updating Profile. Please Wait...</p>',theme: false,baseZ: 2000});
						
					var nm=$.trim($('#txtName').val());
					var em='<?php echo $email; ?>';
					var ph=$.trim($('#txtPhone').val());
					
					var mydata={name:nm, phone:ph,email:em};
					
					$.ajax({
						url: "<?php echo site_url('admin/Profile/UpdateProfile');?>",
						data: mydata,
						type: 'POST',
						dataType: 'text',
						success: function(data,status,xhr) {	
							$.unblockUI();
							
							var ret='';
							ret=$.trim(data);
							
							if (ret.toUpperCase()=='OK')
							{
								m='Profile Update Was Successful';
								DisplayMessage(m, 'success','Profile Update','SuccessTheme');
								setTimeout(function() {
									window.location.reload(true);
								}, 3000);
							}else
							{
								m=data;
								
								DisplayMessage(m,'error',Title);
							}		
						},
						error:  function(xhr,status,error) {
							$.unblockUI();
							m='Error '+ xhr.status + ' Occurred: ' + error;
							DisplayMessage(m,'error',Title);
						}
					});
				  }
				})
			}catch(e)
			{
				$.unblockUI();
				m='CheckForm ERROR:\n'+e;
				
				DisplayMessage(m,'error',Title);
			}
		}
	
    });
		
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
                                                    User Profile
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
                                    <div title="Your registered email" class="position-relative row form-group"><label for="txtEmail" class="col-sm-2 col-form-label">Email<span class="redtext">*</span></label>
                                        <div title="Your fullname" class="col-sm-10"><input readonly style="cursor:default;" id="txtEmail" placeholder="Your Email" type="email" class="form-control" value="<?php echo $email; ?>"></div>
                                    </div>
                                    
                                    <div class="position-relative row form-group"><label for="txtName" class="col-sm-2 col-form-label">Fullname<span class="redtext">*</span></label>
                                        <div class="col-sm-10"><input id="txtName" placeholder="Your Fullname" type="text" class="form-control" value="<?php echo $fullname; ?>"></div>
                                    </div>
                                    
                                    <div class="position-relative row form-group"><label for="txtPhone" class="col-sm-2 col-form-label">Phone</label>
                                        <div class="col-sm-10"><input id="txtPhone" placeholder="Your Phone" type="text" class="form-control" value="<?php echo $phone; ?>"></div>
                                    </div>
                                    
                                   <div class="position-relative row form-check">
                                        <div class="col-sm-10 offset-sm-2">
                                            <button id="btnUpdate" type="button" class="btn-pill btn btn-primary"><i class="pe-7s-note size-14 makebold"></i> Update Profile</button>                                                
                                             <button onClick="window.location.reload(true);" style="margin-left:10px;" type="button" class="btn-pill btn btn-info"><i class="pe-7s-refresh-2 size-14 makebold"></i> Refresh</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                       <div class="main-card mb-3 card">
                                <div class="card-body"><h5 class="card-title">Change Password</h5>
                                    <form class=""> 
                                    	<div class="position-relative row form-group">
                                        	<label for="txtOldPwd" class="col-sm-2 col-form-label">Old Password<span class="redtext">*</span></label>
                                            
                                            <div class="col-sm-4">
                                            	<input id="txtOldPwd" placeholder="Enter Old Password" type="password" class="form-control">
                                            </div>
                                            
                                            
                                            <!--New Pasword-->
                                            <label for="txtNewPwd" class="col-sm-2 col-form-label text-right">New Password<span class="redtext">*</span></label>
                                            
                                            <div class="col-sm-4">
                                            	<input id="txtNewPwd" placeholder="Enter New Password" type="password" class="form-control">
                                            </div>
                                        </div>
                                    </form>
                                    
                                     <div class="divider"></div>
                                    
                                    <form class="">                                        
                                        <div class="position-relative row form-group">
                                        	<label for="txtCPwd" class="col-sm-2 col-form-label">Confirm New Password<span class="redtext">*</span></label>
                                            
                                            <div class="col-sm-4">
                                            	<input id="txtCPwd" placeholder="Confirm New Password" type="password" class="form-control">
                                            </div>
                                            
                                            <!--Button-->
                                           <div class="text-right col-sm-2">
                                                <button id="btnChange" type="button" class="btn-pill btn btn-danger"><i class="pe-7s-key size-14 makebold"></i> Change Password</button>                                                
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
