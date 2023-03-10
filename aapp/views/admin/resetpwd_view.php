<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Derived Homes - Reset Password</title>
    <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Naija Art Mart - The New Market For Everyone">    
    <meta name="msapplication-tap-highlight" content="no"><!-- Disable tap highlight on IE -->
    
    <?php include('header.php'); ?>
    <?php include('scripts.php'); ?>
    

	<script>
	history.pushState(null, null, location.href);
		
	window.onpopstate = function () {
		history.go(1);
	};
	
	var Title='<font color="#AF4442">Reset Password Message</font>';
	
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

					
		
        $('#btnResetPwd').click(function(e) {
            try
			{
				if (!CheckValue()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Reset Password Button Clicked ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
        });
		
		
		function CheckValue()
		{			
			try
			{
				var em='<?php echo $Email; ?>';
				var pwd=$('#txtPwd').val();
				var cpwd=$('#txtConfirmPwd').val();
				var ret=false;
				
				//Email
				if (!em)
				{
					m='Email field is blank. Refresh the window. If it is still blank, log out and log in again before continuing with the profile update.';
					
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
														
				//Password
				if (!$.trim(pwd))
				{
					m='Password field must not be blank.';
					DisplayMessage(m, 'error',Title);
					$('#txtPwd').focus();
					return false;
				}
				
				if (pwd.length<6)
				{
					m='Minimum password size is six(6) characters.';
					DisplayMessage(m, 'error',Title);
					$('#txtPwd').focus();
					return false;
				}	
				
				//Confirm Password
				if (!$.trim(cpwd))
				{
					m='Confirm password field must not be blank.';
					DisplayMessage(m, 'error',Title);
					$('#txtConfirmPwd').focus();
					return false;
				}
				
				
				if (pwd != cpwd)
				{
					m='New password and confirming password do not match.';
					
					DisplayMessage(m, 'error',Title);
					$('#txtConfirmPwd').focus();
					return false;
				}
				
				//Confirm Registration				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  text: "Do you want to proceed with the password reset?",
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Yes, Go Ahead!'
				}).then((result) => {
				  if (result.value) 
				  {
					  $.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Resetting Password. Please Wait...</p>',theme: false,baseZ: 2000});
				
					var mydata={email:'<?php echo $Email; ?>',pwd:AES256.encrypt($('#txtPwd').val(),'<?php echo ACCESS_STAMP; ?>')};				
					
					$.ajax({
						url: "<?php echo site_url('admin/Resetpwd/UpdatePassword');?>",
						data: mydata,
						type: 'POST',
						dataType: 'text',
						success: function(data,status,xhr) {
							$.unblockUI();
							
							if ($.trim(data.toUpperCase())=='OK')
							{
								m='Password Reset Was Successful.';
								Swal.fire({
								  title: 'PASSWORD RESET',
								  text: "Password Reset Was Successful",
								  type: 'success',
								  confirmButtonColor: '#3085d6',
								  cancelButtonColor: '#d33',
								  confirmButtonText: 'Great!'
								}).then((result) => {
								  window.location.href='<?php echo site_url("admin/Signin");?>';
								})							
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
				m='Check Form ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
		}
		
    });
	
	
    </script>
</head>

<body>
<div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100">
                <div class="h-100 no-gutters row">
                    <div class="d-none d-lg-block col-lg-4">
                        <div class="slider-light">
                            <div class="slick-slider">
                                
                                <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-premium-dark" tabindex="-1">
                                        <div class="slide-img-bg" style="background-image: url('<?php echo base_url(); ?>images/gokada1.png');"></div>
                                        <div class="slider-content"><h3>Innovative</h3>
                                            <p>The Revamped Face of Transportation In Nigeria.</p></div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
                        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                            <div class="app-logo"></div>
                            <h4 class="mb-0">
                                <span style="text-transform:uppercase;">Reset Your Password.</span></h4>
                            <div class="divider row"></div>
                            <div>
                                <form class="">
                                    <div class="form-row">
                                        <div title="Your email" class="col-md-12">
                                            <div class="position-relative form-group"><label for="txtEmail" class="">Email</label>
                                            	<input style="color:#8F0B0D ; background-color:#F7E1E1; cursor:default;" readonly id="txtEmail" placeholder="Email" type="email" class="form-control" value="<?php echo $Email; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div title="Please enter your new password here" class="position-relative form-group"><label for="txtPwd" class="">New Password</label><input id="txtPwd" placeholder="Enter Your New Password" type="password" autocomplete="new-password" class="form-control"></div>
                                        </div>
                                        
                                        <!--Confirm-->
                                        <div class="col-md-6">
                                            <div title="Please enter your new password again here" class="position-relative form-group"><label for="txtConfirmPwd" class="">Confirm New Password</label><input id="txtConfirmPwd" placeholder="Confirm Your New Password" type="password" autocomplete="new-password" class="form-control"></div>
                                        </div>
                                    </div>
                                    
                                    
                                    <!--*********************************Alert Display***************-->
                                   <div id="divAlert"></div>
                                    
                                    <div class="divider row"></div>
                                    
                                    <div class="d-flex align-items-center">
                                    	<div style="width:100%">
                                           <span style="font-style:italic; color:#F3696C;">Change your Mind? <a style="min-width:100px" title="Click here to log in" href="<?php echo site_url('admin/Signin');?>">Login</a></span>
                                           
                                            <span style="float:right">
                                            	 <button title="Click here to reset your password" id="btnResetPwd" class="btn btn-pill btn-primary" type="button">Reset Password</button>
                                            </span>
                                        </div>
                                    </div>
                                
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/main.8d288f825d8dffbbe55e.js"></script>

</body>

</html>
