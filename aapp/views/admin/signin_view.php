<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Naija Art Mart | Admin Login</title>
    <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Naija Art Mart - The New Market For Everyone">    
    <meta name="msapplication-tap-highlight" content="no"><!-- Disable tap highlight on IE -->
    
    <?php include('header.php'); ?>
    <?php include('lscripts.php'); ?>
    
	<style>
		.field-icon {
		  float: right;
		  margin-right: 5px;
		  margin-top: -44px;
		  position: relative;
		  color:#000000;
		  font-size:1.3em;
		  z-index: 2;
		}
		
		.bootbox .modal-header{ display: block; }
  </style>
  
	<script>
	history.pushState(null, null, location.href);
		
	window.onpopstate = function () {
		history.go(1);
	};
	
	var Title='<font color="#AF4442">Naija Art Mart Help</font>';
	
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
				  html: '<font size="3" face="Arial">'+msg+'</font>',
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
		
		$(".toggle-password").click(function() 
		{
			$(this).toggleClass("fa-eye fa-eye-slash");
		  
			var input = $($(this).attr("toggle"));
		  
			if (input.attr("type") == "password") 
			{
				input.attr("type", "text");
			}else 
			{
				input.attr("type", "password");
			}
		});	

		if ('<?php echo $autosignin; ?>' == '1') 
		{			
			$('#txtEmail').val('<?php echo $email; ?>')
			$('#chkRemember').prop('checked', true)
		}else
		{
			$('#txtEmail').val('');
			//$('#txtPwd').val('');
			$('#chkRemember').prop('checked', false);
		}			
		
        $('#btnSignIn').click(function(e) {
            try
			{
				if (!CheckLogin()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Login Button Clicked ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
        });
		
		
		function CheckLogin()
		{			
			try
			{
				var em=$.trim($('#txtEmail').val());
				var pwd=$('#txtPwd').val();
				var chk='0';
				
				if ($('#chkRemember').is(':checked')) chk='1';
				
				if (em.toLowerCase() != 'master')
				{
					if (!em)
					{
						m='Email field must not be blank.';					
						DisplayMessage(m, 'error',Title);
						$('#txtEmail').focus();
						return false;
					}
					
					//Valid Email?
					//  /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
					var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-zA-Z]{2,4}$");
					
					if(!rx.test(em))
					{
						m='Invalid email address.';					
						DisplayMessage(m, 'error',Title);
						$('#txtEmail').focus();
						return false;
					}	
				}
									
				//Password
				if (chk == '0')	
				{
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
				}
				
				var rt=false;
				
				//Check if user is at correct login
				$.ajax({
					url: "<?php echo site_url('admin/Signin/CheckLogin');?>",
					data: {email:em},
					type: 'POST',
					dataType: 'text',
					success: function(data,status,xhr) {
						$.unblockUI();
						
						var ret=$.trim(data.toLowerCase());

						if ((ret=='') || (ret=='broker') || (ret=='issuer') || (ret=='investor'))//or (ret=='investor/issuer')
						{												
							Swal.fire({
							  title: 'LOGIN',
							  html: "<font size='3' face='Arial'>You are at the wrong login screen. You will now be redirected to the correct login screen where you will enter your login details to log in.</font>",
							  type: 'info',
							  showCancelButton: false,
							  confirmButtonColor: '#3085d6',
							  confirmButtonText: '<font size="3" face="Arial">OK</font>'
							}).then((result) => {
								window.location.href='<?php echo site_url("ui/Login");?>';
							})
						}else
						{
							Login();
						}					
					},
					error:  function(xhr,status,error) {
						$.unblockUI();
						m='Error '+ xhr.status + ' Occurred: ' + error;
						DisplayMessage(m,'error',Title);
					}
				});		
				
				//return rt;
			}catch(e)
			{
				m='Check Form ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
		}
		
		function Login()
		{
			try
			{
				$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Signing In. Please Wait...</p>",theme: false,baseZ: 2000});
				
				var em=$.trim($('#txtEmail').val());
				var chk='0';
				
				if ($('#chkRemember').is(':checked')) chk='1';

				var mydata={autosignin:chk,remember:chk,em:em, pwd:AES256.encrypt($('#txtPwd').val(),'<?php echo ACCESS_STAMP; ?>')};
				
				
				$.ajax({
					url: "<?php echo site_url('admin/Signin/UserLogin');?>",
					data: mydata,
					type: 'POST',
					dataType: 'text',
					success: function(data,status,xhr) {
						$.unblockUI();
						
						if ($.trim(data.toUpperCase())=='OK')
						{																	
							window.location.href='<?php echo site_url("admin/Dashboard");?>';
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
			}catch(e)
			{
				$.unblockUI();
				m='Login ERROR:\n'+e;					
				DisplayMessage(m, 'error',Title);
			}
		}
		
    });
	
	function Recover()
	{			
		try
		{
			(async () => {

			const { value: email } = await Swal.fire({
			  title: 'Your Email Address',
			  input: 'email',
			  showCancelButton: true,
			  confirmButtonText: '<i class="fa fa-envelope-square"></i> Submit',
			  inputPlaceholder: 'Enter your registered email address'
			})
			
			if (email) 
			{
				$.blockUI({message: '<img src="images/loader.gif" /><p>Requesting For Password Reset. Please Wait...</p>',theme: false,baseZ: 2000});
				
				var mydata={email:email};							

				$.ajax({
					url: "<?php echo site_url('admin/Signin/RecoverPwd');?>",
					data: mydata,
					type: 'POST',
					dataType: 'text',
					success: function(data,status,xhr) {
						$.unblockUI();
						
						var r='';
						r=$.trim(data).toUpperCase();							

						if (r=='OK')
						{
							m='Password Reset Link Has Been Sent To <b>'+email+'</b>.';
							DisplayMessage(m, 'success','Password Reset','SuccessTheme');
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
			
			})()
		}catch(e)
		{
			$.unblockUI();
			m='Recover Password Button Clicked ERROR:\n'+e;				
			DisplayMessage(m, 'error',Title);
			return false;
		}	
	}
	
    </script>
</head>

<body>
<div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100">
                <div class="h-100 no-gutters row">
                    <div class="d-none d-lg-block col-lg-7">
                        <div class="slider-light">
                            <div class="slick-slider">
                                
                                <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-premium-dark" tabindex="-1">
                                        <div class="slide-img-bg" style="background-image: url('<?php echo base_url(); ?>assets/front/images/app-bg.jpg');"></div>
                                        <div class="slider-content"><h3>Innovative Exchange</h3>
                                            <p>The New Art Market For Everyone.</p></div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-11 col-lg-5">
                        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                            
                            <div title="Naija Art Mart Home" OnClick="window.location.href='<?php echo site_url('ui/Home');?>';" style="cursor:pointer;" class="app-logo"></div>
                            
                            <h4 class="mb-0">
                                <span style="text-transform:uppercase;">Please sign in to your account.</span></h4>
                            <div class="divider row"></div>
                            <div>
                                <form class="">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="position-relative form-group"><label for="txtEmail" class="">Email</label><input id="txtEmail" placeholder="Your Email" type="email" class="form-control"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                       <div class="col-md-12">
                                            <div class="position-relative form-group"><label for="txtPwd" class="">Password</label><input id="txtPwd" placeholder="Your Password" name="fakepassword" type="password" autocomplete="new-password" class="form-control"></div>
                                            
                                            <span toggle="#txtPwd" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                                        </div>
                                    </div>
                                    
                                    <!--*********************************Alert Display***************-->
                                   <div id="divAlert"></div>
                                    
                                    
                                    <!--<div class="position-relative form-check"><input id="chkRemember" type="checkbox" class="form-check-input"><label for="chkRemember" class="form-check-label">Keep me logged in for 2 weeks</label> 
                                    </div>-->
                                     
                                     <div class="form-row">&nbsp;</div>
                                                                  
                                     <div class="form-row">
                                        <div>                                           
                                           <button style="min-width:100px" id="btnSignIn" class="btn btn-pill btn-nse-green" type="button"> Login </button>
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">&nbsp;</div>
                                    
                                    <div class="form-row">
                                        <div style="font-style:italic; color:#F3696C;">Forgot Password? <a title="Click here to reset your password" onClick="Recover();" href="#">Reset Password</a></div>
                                    </div>
                                
                                </form>
                            </div>
                        
                        <br><br>
                        	<!--<div align="center">
	<span id="siteseal"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=3727e1vZgu7gH15VkOvqO14iy1OUDa895AVCYbuwJsyoyLcuafrh68NgzohQ"></script></span>
</div>-->
                        
                        </div>
                    </div>
                    
            
                    
                </div>
            </div>
        </div>
</div>



<script type="text/javascript" src="<?php echo base_url();?>assets/js/main.8d288f825d8dffbbe55e.js"></script>

</body>

</html>
