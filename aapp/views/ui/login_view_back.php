<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>

<head><meta http-equiv="content-type" content="text/html;charset=utf-8" />

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <noscript>False</noscript>
    <title>Derived Homes - Login</title>
    <link rel="icon" href="<?php echo base_url(); ?>wp-content/uploads/d_favicon.png" type="image/png" sizes="16x16"/>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/general.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>loginassets/css/bundle.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>loginassets/css/site.min.css" />

	 <?php include('scripts.php'); ?>
     
    
    
        
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-29392430-71"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'UA-29392430-71');
</script>

        <!-- Google Tag Manager -->
        <script>(function (w, d, s, l, i) { w[l] = w[l] || []; w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' }); var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src = '<?php echo base_url(); ?>tagmanager/gtm5445.html?id=' + i + dl; f.parentNode.insertBefore(j, f); })(window, document, 'script', 'dataLayer', 'GTM-K529X6D');</script>
        <!-- End Google Tag Manager -->
        
	<script>
		
	var Title='<font color="#AF4442">Naija Art Mart Help</font>';
	var m='';
	
	function DisplayMessage(msg,msgtype,msgtitle,theme='AlertTheme')
	{
		try
		{//SuccessTheme, AlertTheme
			$('#divAlert').html(msg).addClass(theme);
			
			
			Swal.fire({
				  type: msgtype,
				  title: '<strong>'+msgtitle+'</strong>',
				  background: '#F3D3F2',
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
		
		$("#myModal").on('show.bs.modal', function(){
			try
			{
				$.unblockUI();
			}catch(e)
			{
				$.unblockUI();
				m='Show Modal Event ERROR:\n'+e;			
				DisplayMessage(m, 'error',Title);
			}
		  });
  
		$("#myModal").on('hidden.bs.modal', function(){
			try
			{
				$('#txtForgotEmail').val('');
			}catch(e)
			{
				$.unblockUI();
				m='Hide Modal Event ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		 });
		 
		$('#btnLogin').click(function(e) {
            try
			{
				if (!CheckLogin()) return false;
				
				
			}catch(e)
			{
				$.unblockUI();
				m='Login Button Click ERROR:\n'+e;
				DisplayMessage(m, 'error',Title);
			}
		});	
			
			
		$('#btnRequest').click(function(e) {
			try
			{
				var em=$.trim($('#txtForgotEmail').val());
				
				//Email
				if (!em)
				{
					m='Registered email field must not be blank.';
					DisplayMessage(m, 'error',Title);
					$('#txtForgotEmail').focus(); return false;
				}
				
				//Valid Email?
				//  /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
				var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-zA-Z]{2,4}$");
				if(!rx.test(em))
				{
					m='Invalid registered email.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtForgotEmail').focus(); return false;
				}
				
				$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Requesting For Password Change. Please Wait...</p>',theme: false,baseZ: 2000});
				
				//Make Ajax Request
				var em=$.trim($('#txtForgotEmail').val());
											
				var mydata={email:em};
						
				$.ajax({
					url: "<?php echo site_url('Signin/ForgotPwd');?>",
					data: mydata,
					type: 'POST',
					dataType: 'text',
					success: function(data,status,xhr) {	
						$.unblockUI();
							
						if ($.trim(data.toUpperCase())=='OK')
						{
							$('#txtForgotEmail').val('');
											
							m='Password Reset Link Has Been Sent To <b>'+em+'</b>.';				
							DisplayMessage(m, 'success','Payment Added','SuccessTheme');
							$("#myModal").modal("hide");
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
			}catch(e)
			{
				$.unblockUI();
				m='Request For Password Change Button Click ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
		});
		
		function CheckLogin()
		{
			var m;				

			try
			{
				var em=$.trim($('#txtEmail').val());
				var pwd=$('#txtPwd').val();
				
				//Email
				if (em.toLowerCase() != 'master')
				{
					if (!em)
					{
						m='Email field must not be blank.';
						DisplayMessage(m, 'error',Title);
						$('#txtEmail').focus(); return false;
					}				
	
					//Valid Email?
					//  /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
					var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-zA-Z]{2,4}$");
					if(!rx.test(em))
					{
						m='Invalid email address.';   						
						DisplayMessage(m, 'error',Title);
						$('#txtEmail').focus(); return false;
					}	
				}
				
				//Password			
				if (!$.trim(pwd))
				{
					m='Password field must not be blank.';
					DisplayMessage(m, 'error',Title);
					$('#txtPwd').focus(); return false;
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
						
						if ((ret=='operator') || (ret=='gallery') || (ret=='admin'))
						{												
							Swal.fire({
							  title: 'LOGIN',
							  html: "<font size='3' face='Arial'>You are at the wrong login screen. You will now be redirected to the correct login screen where you will enter your login details to log in.</font>",
							  type: 'info',
							  showCancelButton: false,
							  confirmButtonColor: '#3085d6',
							  confirmButtonText: '<font size="3" face="Arial">OK</font>'
							}).then((result) => {
								window.location.href='<?php echo site_url("admin/Signin");?>';
							})
						}else
						{
							Login(ret);
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
				$.unblockUI();
				m='CheckLogin ERROR:\n'+e;					
				DisplayMessage(m, 'error',Title);
			}
		}
		
		function Login(ut)
		{
			try
			{
				//Make Ajax Request
				var em=$.trim($('#txtEmail').val());				
				var mydata={email:em, pwd:AES256.encrypt($('#txtPwd').val(),'<?php echo ACCESS_STAMP; ?>')};
				
				$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Signing In. Please Wait...</p>',theme: false,baseZ: 2000});

				$.ajax({
					url: "<?php echo site_url('ui/Login/UserLogin');?>",
					data: mydata,
					type: 'POST',
					dataType: 'json',
					success: function(data,status,xhr) {
						$.unblockUI();
						
						var sta='';
						
						if ($(data).length > 0)
						{
							$.each($(data), function(i,e)
							{
								sta=e.status;
	
								if ($.trim(sta).toUpperCase()=='OK')
								{
									if (ut=='broker')
									{
										window.location.href='<?php echo site_url("ui/Dashboard"); ?>';
									}else if ((ut=='issuer') or (ut=='investor'))//(ut=='investor/issuer') or 
									{
										window.location.href='<?php echo site_url("ui/Dashboardiv"); ?>';
									}									
								}else
								{
									m=e.msg;
									DisplayMessage(m, 'error',Title);
								}
								
								return;
							});//End each
						}else
						{
							$.unblockUI();		
							m='Login Failed.';
							DisplayMessage(m, 'error',Title);
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
				m='Login ERROR:\n'+e;					
				DisplayMessage(m, 'error',Title);
			}
		}
	}); //End document ready   
</script>
</head>
<body class="page-login">
        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K529X6D" height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>

    
    <main class="page-content">
        <div class="page-inner">
            <div id="main-wrapper">
                <div class="row">
                    <div class="col-md-3 center">
                       <center>
                        <a href="<?php echo site_url('ui/Home'); ?>">
                        		<img class="mobile-logo preload-me" src="<?php echo base_url(); ?>wp-content/uploads/Logo_ArtSquare_mobile.png" width="200" height="33" sizes="200px" alt="Naija Art Market – The new art market. For everyone"/>
                        </a>
                        </center>
                       
                        <div class="login-box">
                           
<br><p  class="logo-name text-lg text-center">Welcome To Naija Art Market</p>
<p class="login-info text-center redtext">Please Enter Your Login Details</p>

<form class="m-t-md" autocomplete="off">
    <validation-summary-errors></validation-summary-errors>
    <div class="row">
        <div class="col-xs-12">
            <templatefor>
<div class="form-group">
    		    <input id="txtEmail" class="form-control" type="text" placeholder="Your Email" name="fakepasswordremembered" />
</div></templatefor>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <templatefor>
                <div class="form-group  has-feedback">                   
                    <input autocomplete="new-password" id="txtPwd" class="form-control" type="password" placeholder="Your Password" name="fakepasswordremembered" />
                    <!--<span style="margin-top:10px; margin-right:10px; z-index:1000; cursor:default; " toggle="#txtPwd" class="fa fa-fw fa-eye-slash field-icon toggle-password form-control-feedback"></span>-->
                </div>
            </templatefor>
        </div>
    </div>
    
   <div id="divAlert"></div>
    
    <div class="row">
        <div class="col-xs-12">
            <button id="btnLogin" type="button" class="btn btn-art-green btn-block btn-rounded btn-gradient">Login</button>
            
            <a title="Click here to reset password" href="" class="display-block text-center m-t-md text-sm" data-keyboard="false" data-backdrop="static" data-toggle="modal" data-target="#myModal"><i class="fa fa-lock"></i> Forgot password?</a>
           
            <p class="text-center m-t-xs text-sm">Do not have an account?</p>
            <a class="btn btn-default btn-block m-t-md" href="<?php echo site_url('ui/Signup'); ?>">Sign up</a>
        </div>
    </div>
<input name="__RequestVerificationToken" type="hidden" value="CfDJ8NUHs6S8PkRFu6aLeW-WKGFGm6QDl78vLBQctimJaMr944D2u4p2nq-3x09h2Tl0KPhiQNJiQpBYUFzPkSGJtI9TkAbD4_rjm20Q2ZqEzZP36VQY3XKgK1JyF9a5wLxX3ADCwTZb_09gu1yILAxG0ZQ" /></form>

                        </div>
                        <p class="text-center m-t-xxl text-sm">&copy; <?php echo date('Y'); ?> NAIJA ART MARKET</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript">
    var culture = 'en-US';
</script>


    <script src="<?php echo base_url(); ?>loginassets/js/bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>loginassets/js/bundle.en-US.min.js"></script>
    <script src="<?php echo base_url(); ?>loginassets/js/site.min.js"></script>
    <script src="<?php echo base_url(); ?>loginassets/js/locales/site.en-US.min.js"></script>


    <script></script>
</body>

<!--Reset Password-->
  <div class="col-md-12">
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
				<h4 class="modal-title">Request For Password Change</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              
              <div class="modal-body">
              	<form class="form-horizontal">
                    <!--Email-->
                        <div title="Enter your registered email" class="form-group">
                            <div class="col-sm-12">
                                <input id="txtForgotEmail" type="text" class="form-control" placeholder="Enter Your Registered Email">
                            </div>
                       </div>
                       
                       <div align="center" style="margin-top:-10px;" id="divModalAlert"></div>
                </form>
              
              	 
              </div>
              
              <div class="modal-footer">
                <div class="form-group">
                	                    
                    <div class="col-sm-12 ">
                        <button id="btnRequest" type="button" class="btn btn-info">Submit Request</button>
                    	<button id="btnCloseModal" type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
                    </div>
                           
                </div>
                
              </div>
            </div>
            
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</html>




