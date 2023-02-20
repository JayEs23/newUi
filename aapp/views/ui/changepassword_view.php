<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<title>Naija Art Market | Change Password</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	
    <style>.nav-tabs > li.active > a, .nav-tabs > li > a:hover { border: none;  color: #A8AC2E !important; background: #fff; }</style>
    
    <?php include('reportsheader.php'); ?>
    <?php include('reportscripts.php'); ?>
    
    
    <script>
		var Title='<font color="#AF4442">Naija Art Mart Help</font>';
		var m='';
		var Email='<?php echo $email; ?>';
		var Usertype='<?php echo $usertype; ?>';
				
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
			
			$('#btnChange').click(function(e) {
				try
				{
					if (!CheckForm()) return false;				
				}catch(e)
				{
					$.unblockUI();
					m='Change Password Button Clicked ERROR:\n'+e;				
					DisplayMessage(m, 'error',Title);
					return false;
				}
			});//btnChange Click Ends
		
			function CheckForm()
			{
				var m='';
				
				try
				{
					var opw=$('#txtOldPwd').val();
					var npw=$('#txtNewPwd').val();					
					var cpw=$('#txtCPwd').val();
					
					//Email
					if (!Email)
					{
						m='Email field is blank. Refresh the window. If it is still blank, sign out and sign in again before continuing with the changing of password.';
						
						DisplayMessage(m, 'error',Title);
						return false;
					}			
					
					//Old password
					if (!$.trim(opw))
					{
						m='Current password field must not be blank.';
						DisplayMessage(m, 'error',Title);
						return false;
					}
					
					//New password
					if (!$.trim(npw))
					{
						m='New password field must not be blank.';
						DisplayMessage(m, 'error',Title);
						return false;
					}
					
					var v=IsValidPassord(npw,Email,8);
					
					if (v != 1)
					{
						DisplayMessage(v, 'error',Title);					
						return false;
					}
					
					//Confirm New Password
					if (npw != cpw)
					{
						m='New password and confirming password do not match.';
						DisplayMessage(m, 'error',Title);
						return false;
					}
															
					//Confirm Update			
					Swal.fire({
					  title: 'PLEASE CONFIRM',
					  html: '<font size="3" face="Arial">Do you want to proceed with the password change?</font>',
					  type: 'question',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  cancelButtonText: '<font size="3" face="Arial">No</font>',
					  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
					}).then((result) => {
					  if (result.value)
					  {
						$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Changing Password. Please Wait...</p>',theme: false,baseZ: 2000});
											
						//Initiate POST
						var uri = "<?php echo site_url('ui/Changepassword/UpdatePassword'); ?>";
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
									m='Password Change Was successful';
									DisplayMessage(m, 'success','Change Password','SuccessTheme');																					
								}else
								{
									m=res;								
									DisplayMessage(m, 'error',Title);
								}
							}
						};
					
						fd.append('email', Email);
						fd.append('usertype', Usertype);
						fd.append('opwd', AES256.encrypt($('#txtOldPwd').val(),'<?php echo ACCESS_STAMP; ?>'));
						fd.append('pwd', AES256.encrypt($('#txtNewPwd').val(),'<?php echo ACCESS_STAMP; ?>'));
																											
						xhr.send(fd);// Initiate a multipart/form-data upload
					  }
					})
				}catch(e)
				{
					$.unblockUI();
					m='CheckForm ERROR:\n'+e;
					DisplayMessage(m, 'error',Title);
					return false;
				}
			}
        });
	</script>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<?php include('header.php'); ?>
        <?php include('sidemenu.php'); ?>
				
        
        <!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
                	<div class="panel panel-headline">
						 <!-- Breadcrum -->
                         <div class="page-title-subheading opacity-10">
                            <nav class="" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url('ui/Dashboard'); ?>">
                                            <i aria-hidden="true" class="fa fa-home"></i>
                                        </a>
                                    </li>
                                    <li class="active breadcrumb-item" aria-current="page">
                                        <a class="nsegreen-dark">Change Password</a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        
						
                        <div class="panel-body">                       
                            <form class="">
                               <!--Password-->
                              <div class="row">
                                    <div class="col-md-12">
                                        <div title="Your current password" class="position-relative row form-group">
                                            <label for="txtOldPwd" class="col-sm-3 col-form-label text-right">Current Password<span class="redtext">*</span></label>
                                        
                                            <div class="col-sm-9">
                                               <input autocomplete="new-password" id="txtOldPwd" placeholder="Your Current Password" type="password" class="form-control">
                                             </div>
                                        </div>
                                    </div>
                                </div>                                    
                            
                               <!--New Password-->
                               <div class="row">
                                    <div class="col-md-12">
                                        <div title="Your new password" class="position-relative row form-group">
                                            <label for="txtNewPwd" class="col-sm-3 col-form-label text-right">New Password<span class="redtext">*</span></label>
                                        
                                            <div class="col-sm-9">
                                                <input autocomplete="new-password" id="txtNewPwd" placeholder="Your New Password" type="password" class="form-control">
                                             </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!--Confirm New Password-->
                               <div class="row">                                  
                                   <div class="col-md-12">
                                        <div title="Confirm your new password" class="position-relative row form-group">
                                            <label for="txtCPwd" class="col-sm-3 col-form-label text-right">Confirm New Password<span class="redtext">*</span></label>
                                        
                                            <div class="col-sm-9">
                                                <input autocomplete="new-password" id="txtCPwd" placeholder="Confirm Your New Password" type="password" class="form-control">
                                             </div>
                                        </div>
                                    </div>                                 
                                </div>                          
                        </form>
                        
                       <div id="divAlert"></div>
                        
						</div>
                        
                         <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-6 text-right"><a id="btnChange" href="#" class="btn btn-nse-green makebold">Change Password</a></div>
                                
                                <div class="col-md-6"><a onClick="window.location.reload(true);" href="#" class="btn btn-danger makebold">Refresh</a></div>
                            </div>
                        </div>
					</div>
                    
                 
					
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		
         <?php include('footer.php'); ?>
	</div>
    
	<!-- END WRAPPER -->
</body>

</html>
