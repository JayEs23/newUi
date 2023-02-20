<?php

$logged_in = false;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://www.naijaartmart.com/assets/images/favicon_artsquare_16x16.png" sizes="16x16">
    <title> Naija Art Mart - Sign in.</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/assets/owl.theme.default.min.css">
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progressjs.css"> -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/fonts/fonts.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/css/app.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>


<!--     <div class="loader"></div>
 -->
    <!--=======================================
            login Start Here
    ========================================-->

        <div class="login-main" style="background: url('https://www.naijaartmart.com/assets/front/images/we-have-designed.jpg') !important; background-repeat: no-repeat; background-size: cover !important;">
            <div class="container-fluid">
                <div class="log-in">
                    <div class="nav-bar">
                        <div class="logo-otr">
                            <!-- <a href="#" class="logo-inr">
                                <img class="logo-img" src="<?php echo site_url() ?>newassets/img/naija_art_mart1.png" alt="logo">
                            </a> -->
                        </div>
                        <div class="button-otr">
                            <a href="<?php echo site_url('ui/Signup'); ?>" class="member body-sb">Not a member?</a>
                            <div class="action-otr">
                                <a href="<?php echo site_url('ui/Signup'); ?>" class="btn-fill-white btn-signup">Sign Up</a>
                            </div>
                        </div>
                    </div>
                    <div class="row row-login">
                        <div class="col-lg-6 col-md-8 col-login-otr">
                            <div class="col-login-inr">
                                <div class="content">
                                    <h3 class="head heading-h3">Naija Art Mart</h3>
                                    <div class="login-social">
                                        <span class="line"></span>
                                        <p class="desc body-s">Login</p>
                                        <span class="line"></span>
                                    </div>
                                    <form class="form-main" method="post">
                                        <div class="input-otr">
                                            <input class="input" type="email" id="txtEmail" name="email" placeholder="Your Email Address" required>
                                        </div>
                                        <div class="input-otr input-otr-2">
                                            <input class="input" type="password" id="txtPwd" name="password" placeholder="*****" required>
                                        </div>
                                        
                                        <div class="check-main">
                                            <div class="check">
                                                <label>
                                                    <span class="check-inner">
                                                        <input type="checkbox" class="input-check opacity-0 absolute">
                                                        <svg class="fill-current" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="12" fill="#366CE3"/><path d="M16.521 8.938l-6.125 6.125L7.335 12" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </span>
                                                    <span class="select-none body-sb">Remember Me</span>
                                                </label>
                                            </div>
                                            <a title="Click here to reset password" href="#" data-keyboard="false" data-backdrop="static" data-toggle="modal" data-target="#myModal" class="forget body-sb">Forgot Password?</a>
                                        </div>
                                        <div class="action-otr">
                                            <button id="btnLogin" class="button body-sb" type="button">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="copy-otr-home2">
		      <div class="container-fluid">
		          <div class="copy-inr">
		              <a href="#" class="logo-otr">
		                  <img class="logo" style="min-height: 40px; min-width: 30px; border-radius: 16px;" src="<?php echo base_url(); ?>/newassets/img/naija_art_mart1.png"  alt="brand-logo">
		              </a>
		              <div class="copy-name body-s">
		                  Copyright © 2022  <a href="#" target="_blank" class="name body-sb">Naija Art Mart.</a>
		              </div>
		              <div class="all-rights">
		                  <p class="all body-s">
		                      All rights reserved.
		                  </p>
		              </div>
		          </div>
		      </div>    
		    </div>
        </div>

    <!--=======================================
            login End Here
    ========================================-->
    

    <script src="<?php echo base_url(); ?>/newassets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/jquery.countdown/jquery.countdown.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/tilt.js/dest/tilt.jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progress.js"></script> -->
    <script src="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/js/app.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/general.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/aes256.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/sum().js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/back.js"></script>

    <script type="text/javascript">
    	let Title= "Naija Art Mart Help!";
    	let m = '';

    	/**
		* Displays Alert Message
		* @param {string} msg
		* @param {string} type
		* @param {string} title
		* @param {string} theme
		* @return void
		*/
    	function displayMessage(msg,type,title,theme){
    		swal({
			  title: title,
			  text: msg,
			  icon: theme,
			  dangerMode: false,
			})
    	}

    	/**
		* Displays Alert Message
		* @param {string} msg
		* @param {number} timer
		* @param {string} title
		* @param {string} theme
		* @return void
		*/

    	function timedAlert(msg,timer,title,theme){
    		swal({
			  title: title,
			  text: msg,
			  icon: theme,
			  timer: timer,
			  showConfirmButton: false
			})
    	}

    	$(document).ready(function(e) {
	
			//toggle password
			$(".toggle-password").click(function(){

				$(this).toggleClass("fa-eye fa-eye-slash");
		  
				var input = $($(this).attr("toggle"));
		  
				if (input.attr("type") == "password"){
					input.attr("type", "text");
				}else{
					input.attr("type", "password");
				}
			});
		 	

		 	//listing for login button click
			$('#btnLogin').click(function(e) {
            	try {
					if (!CheckLogin()) return false;				
				}catch(e) {
					m='Login Button Click Error:\n'+e;
					displayMessage(m, 'Error!',Title,'warning');
				}
			});	
			
			//recover password
			$('#btnRequest').click(function(e) {

				try{
					var em=$.trim($('#txtForgotEmail').val());
					
					// Check Email
					if (!em){
						m='Registered email field must not be blank.';
						DisplayMessage(m, 'Warning',Title,'warning');
						$('#txtForgotEmail').focus(); return false;
					}
					
					//Valid Email?
					//  /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
					var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-zA-Z]{2,4}$");
					if(!rx.test(em)){
						m='Invalid registered email.';					
						displayMessage(m, 'Warning',Title,'warning');					
						$('#txtForgotEmail').focus(); return false;
					}
					
					timedAlert('Requesting For Password Change. Please Wait.',2000,'','');
					
					//Make Ajax Request
					var em = $.trim($('#txtForgotEmail').val());
												
					var mydata = {email:em};
							
					$.ajax({
						url: "<?php echo site_url('Signin/ForgotPwd');?>",
						data: mydata,
						type: 'POST',
						dataType: 'text',
						success: function(data,status,xhr) {								
							if ($.trim(data.toUpperCase())=='OK'){
								$('#txtForgotEmail').val('');
												
								m = 'Password Reset Link Has Been Sent To <b>'+em+'</b>.';				
								displayMessage(m, 'Success','Email Confirmed','success');
								
								$("#myModal").modal("hide");
							}else{
								m = data;
								displayMessage(m, 'Error',Title,'error');
							}					
						},
						error:  function(xhr,status,error) {
							m='Error '+ xhr.data + ' Occurred: ' + error;				
							displayMessage(m, 'Server Error',Title,'error');
						}
					});	
				}catch(e)
				{
					m='Request For Password Change Button Click ERROR:\n'+e;				
					displayMessage(m, 'Warning',Title,'warning');
					return false;
				}
			});
		
			function CheckLogin()
			{
				var m;				
				try {
					var em = $.trim($('#txtEmail').val());
					//var pwd=$('#txtPwd').val();
					
					//Email
					if (em.toLowerCase() != 'master'){
						if (!em){
							m='Email field must not be blank.';
							displayMessage(m, 'Warning',Title,'warning');
							$('#txtEmail').focus(); return false;
						}				
		
						//Valid Email?
						//  /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
						var rx = new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-zA-Z]{2,4}$");
						if(!rx.test(em)) {
							m='Invalid email address.';   						
							displayMessage(m, 'Warning!',Title,'warning');
							$('#txtEmail').focus(); return false;
						}	
					}
					
					//Password			
					if (!$.trim($('#txtPwd').val()))
					{
						m='Password field must not be blank.';
						displayMessage(m, 'Warning !',Title,'warning');
						$('#txtPwd').focus(); return false;
					}
					
					var rt = false;
					
					//Check if user is at correct login
					$.ajax({
						url: "<?php echo site_url('admin/Signin/CheckLogin');?>",
						data: {email:em},
						type: 'POST',
						dataType: 'text',
						success: function(data,status,xhr) {
							
							var ret=$.trim(data.toLowerCase());
							
							if ((ret == 'operator') || (ret == 'gallery') || (ret == 'admin')) {												
								swal({
								  title: 'LOGIN',
								  text: "You are at the wrong login screen. You will now be redirected to the correct login screen where you will enter your login details to log in.",
								  type: 'info',
								  showCancelButton: false,
								  confirmButtonText: 'OK'
								}).then((result) => {
									window.location.href='<?php echo site_url("admin/Signin");?>';
								})
							}else
							{
								Login(ret);
							}					
						},
						error:  function(xhr,status,error) {
							m ='Error '+ xhr.status + ' Occurred: ' + error;
							displayMessage(m,'Error',Title,'error');
						}
					});		
					
					//return rt;
				}catch(e)
				{
					m='CheckLogin ERROR:\n'+e;					
					displayMessage(m, 'Warning!',Title,'warning');
				}
			}
			
			function Login(ut)
			{
				try
				{
					//Make Ajax Request
					var em = $.trim($('#txtEmail').val());				
					var mydata = {email:em, pwd:AES256.encrypt($('#txtPwd').val(),'<?php echo ACCESS_STAMP; ?>')};
					
					timedAlert('Please Wait...',2000,'','info');


					if (ut=='broker'){
						window.location.href='<?php echo site_url("ui/Dashboard"); ?>';
					}else if ((ut=='issuer') || (ut=='investor')){
						window.location.href='<?php echo site_url("ui/Dashboardiv"); ?>';
					}

					$.ajax({
						url: "<?php echo site_url('ui/Login/UserLogin');?>",
						data: mydata,
						type: 'POST',
						dataType: 'json',
						success: function(data,status,xhr) {
							
							var sta ='';
							
							if ($(data).length > 0) {
								$.each($(data), function(i,e) {
									sta = e.status;
		
									if ($.trim(sta).toUpperCase()=='OK') {
										if (ut=='broker') {
											window.location.href='<?php echo site_url("ui/Dashboard"); ?>';
										}else if ((ut=='issuer') || (ut=='investor')) {
											window.location.href='<?php echo site_url("ui/Dashboardiv"); ?>';
										}									
									}else
									{
										m = e.msg;
										displayMessage(m, 'Error',Title,'error');
									}
									
									return;
								});
							}else
							{
								m='Login Failed.';
								displayMessage(m, 'Error',Title,'error');
							}	
						},
						error:  function(xhr,status,error) {
							m='Error '+ xhr.status + ' Occurred: ' + error;
							displayMessage(m, 'Error',Title,'error');
						}
					});
				}catch(e)
				{
					m='Login ERROR:\n'+e;					
					displayMessage(m, 'Error',Title,'error');
				}
			}
			
			function Login_bak(ut) {
				try {
					//Make Ajax Request
					var em = $.trim($('#txtEmail').val());				
					var mydata = {email:em, pwd:AES256.encrypt($('#txtPwd').val(),'<?php echo ACCESS_STAMP; ?>')};
					
					timedAlert('Please Wait.',2000,'','info');

					$.ajax({
						url: "<?php echo site_url('ui/Login/UserLogin');?>",
						data: mydata,
						type: 'POST',
						dataType: 'json',
						success: function(data,status,xhr) {
							
							var sta='';
							
							if ($(data).length > 0){
								$.each($(data), function(i,e){
									sta = e.status;
		
									if ($.trim(sta).toUpperCase()=='OK'){
										if (ut=='broker'){
											window.location.href='<?php echo site_url("ui/Dashboard"); ?>';
										}else if ((ut=='issuer') || (ut=='investor')) {
											window.location.href='<?php echo site_url("ui/Dashboardiv"); ?>';
										}									
									}else
									{
										m = e.msg;
										displayMessage(m, 'Error',Title,'error');
									}
									return;
								});
							}else
							{
								m='Login Failed.';
								displayMessage(m, 'Error',Title,'error');
							}	
						},
						error:  function(xhr,status,error) {
							$.unblockUI();
							m='Error '+ xhr.status + ' Occurred: ' + error;
							displayMessage(m, 'Error',Title,'error');
						}
					});
				}catch(e) {
					m='Login ERROR:\n'+e;					
					displayMessage(m, 'error',Title,'error');
				}
			}
	    });
    </script>
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