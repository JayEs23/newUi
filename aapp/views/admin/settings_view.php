<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Naija Art Mart - Application Settings</title>
    <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Naija Art Mart - The New Art Market For Everyone">    
    <meta name="msapplication-tap-highlight" content="no"><!-- Disable tap highlight on IE -->

	<?php include('header.php'); ?>
    <?php include('scripts.php'); ?>

	 

	<script type = "text/javascript">
	
	var Title='<font color="#AF4442">Application Settings Message</font>';
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
		
		if ('<?php echo $set_rc;  ?>') DisplayMessage('<?php echo $set_rc;  ?>', 'info',Title);
		
		LoadPaystackBanks();
		
		$('#cboMode').val('<?php echo $runmode; ?>');
		
		$('#btnUpdate').click(function(e) {
			try
			{
				if (!CheckUpdate()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Update Settings Button Clicked ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
		});//btnUpdate Click Ends
		
		function CheckUpdate()
		{
			try
			{
				var un=$.trim($('#txtUsername').val());
				var sid=$.trim($('#txtSenderId').val());
				var api=$.trim($('#txtApiKey').val());
				var md=$.trim($('#cboMode').val());
				var ref=$.trim($('#txtInterval').val()).replace(new RegExp(',', 'g'), '');
				
				var acnm=$.trim($('#txtAccName').val());
				var acno=$.trim($('#txtAccNo').val());
				var bnk=$.trim($('#cboBank').val());				
				var del=$.trim($('#txtDeleteMsg').val()).replace(new RegExp(',', 'g'), '');
				var tok=$.trim($('#txtBlockchainToken').val());
				var add=$.trim($('#txtBlockchainAddress').val());
				var burl=$.trim($('#txtBaseurl').val());
																	
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the parameters update.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}
				
				//SMS Sandbox Username				
				if (!un)
				{
					m='SMS username field must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}
				
				//SMS Sender Id				
				if (!sid)
				{
					m='SMS sender Id field must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}
				
				//SMS Api Key				
				if (!api)
				{
					m='SMS Api Key field must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}
				
				//Run Mode
				if (!md)
				{
					m='Please select the application run mode.';
					DisplayMessage(m, 'error',Title);					
					$('#cboMode').focus(); return false;
				}
				
				//Refresh Interval
				if (!ref)
				{
					m='Prices refresh interval (in minutes) field must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					return false;
				}				
				
				if (!$.isNumeric(ref))
				{
					m='Prices refresh interval (in minutes) MUST be a number. Current entry <b>'+ref+'</b> is not valid.';						
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(ref) == 0)
				{
					m='Prices refresh interval (in minutes) must not be zero.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(ref) < 0)
				{
					m='Prices refresh interval (in minutes) must not be a negative number.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				//Account Name
				if (acnm=='')
				{
					m='NSE account name field must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if ($.isNumeric(acnm))
				{
					m='NSE account name MUST NOT be a number. Current entry <b>'+acnm+'</b> is not valid.';						
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (acnm.length < 3)
				{
					m='Please enter the correct NSE account name. Current entry <b>'+acnm+'</b> is too short.';						
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				//Bank Name
				if ($('#cboBank > option').length < 2)
				{
					m='No Paystack bank record has been retrieved. Please contact the system administrator.';
					DisplayMessage(m, 'error',Title);					
					return false;
				}
				
				if (!bnk)
				{
					m='Please select NSE bank from the list of Paystack banks.';
					DisplayMessage(m, 'error',Title);					
					$('#cboBank').focus(); return false;
				}
				
				//NSE Account No
				if (acno=='')
				{
					m='NSE account number field must not be blank.';					
					DisplayMessage(m, 'error',Title);
					$('#txtAccNo').focus(); return false;
				}
				
				if (!$.isNumeric(acno))
				{
					m='NSE account number MUST be a number. Current entry <b>'+acno+'</b> is not valid.';						
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (acno.length != 10)
				{
					m='Please enter the correct NSE account number. Valid account number must be 10 digits long (NUBAN).';						
					DisplayMessage(m, 'error',Title);
					return false;
				}	
				
				//Blockchain Base Url
				if (burl)
				{
					if (!isUrl(burl))
					{
						m='Invalid blockchain api base url. Please check your entry and retype the url.';
						
						DisplayMessage(m, 'error',Title);
						return false; 
					}
				}
				
				//Delete Message Period
				if (!del)
				{
					m='Messages deletion period (in days) field must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					return false;
				}				
				
				if (!$.isNumeric(del))
				{
					m='Messages deletion period (in days) MUST be a number. Current entry <b>'+del+'</b> is not valid.';						
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(del) == 0)
				{
					m='Messages deletion period (in days) must not be zero.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(del) < 0)
				{
					m='Messages deletion period (in days) must not be a negative number.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}			

				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: '<font size="3" face="Arial">Do you want to proceed with the updating of the system parameters?</font>',
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Updating System Parameters. Please Wait...</p>',theme: false,baseZ: 2000});
					
					//Initiate POST
					var uri = "<?php echo site_url('admin/Settings/UpdateParameter'); ?>";
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
							m='System Parameters Have Been Updated Successfully.';
							DisplayMessage(m, 'success','System Parameters Updated','SuccessTheme');
							
							setTimeout(window.location.reload(true), 5000);							
																													
						}else
						{
							m=res;								
							DisplayMessage(m, 'error',Title);
						}
					}
				};
				
					fd.append('sms_username', un);
					fd.append('sms_sender_id', sid);
					fd.append('sms_apikey', api);				
					fd.append('runmode', md);
					fd.append('refreshinterval', ref);
					fd.append('message_delete_period', del);
					fd.append('blockchain_token', tok);
					fd.append('blockchain_baseurl', burl);
					fd.append('blockchain_address', add);
					fd.append('account_name', acnm);
					fd.append('account_number', acno);
					fd.append('bank_code', bnk);
																									
					xhr.send(fd);// Initiate a multipart/form-data upload
				  }
				})	
			}catch(e)
			{
				$.unblockUI();
				m='CheckUpdate ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End CheckUpdate
		

		function LoadPaystackBanks()
		{
			try
			{
				$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Paystack Banks. Please Wait...</p>',theme: false,baseZ: 2000});				
	
				$('#cboBank').empty();				
	
				$.ajax({
					url: "<?php echo site_url('admin/Settings/GetPaystackBanks');?>",
					type: 'POST',
					dataType: 'json',
					success: function(data,status,xhr) {	
						$.unblockUI();
	
						if ($(data).length > 0)
						{
							$("#cboBank").append(new Option("[SELECT]", ""));
							
							$.each($(data), function(i,e)
							{
								if (e.name && e.code)
								{
									if (e.name) $("#cboBank").append(new Option($.trim(e.name), $.trim(e.code)));
								}
							});//End each
							
							$('#cboBank').val('<?php echo $bank_code; ?>');
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
				m='LoadPaystackBanks ERROR:\n'+e;
				DisplayMessage(m, 'error',Title);
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
                                                    Application Settings
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
                                	<!--SMS Username-->
                                    <div class="position-relative row form-group">
                                    	<label title="SMS Username" for="txtUsername" class="col-sm-3 col-form-label text-right">SMS Username<span class="redtext">*</span></label>
                                        
                                        <div title="SMS Username" class="col-sm-3"><input style="cursor:default;" id="txtUsername" placeholder="SMS Username" type="text" class="form-control" value="<?php echo $sms_username; ?>"></div>
                                        
                                        <!--SMS Sender Id-->
                                        <label title="SMS Sender Id"  for="txtSenderId" class="col-sm-3 col-form-label text-right">SMS Sender Id<span class="redtext">*</span></label>
                                    
                                        <div title="SMS Sender Id"  class="col-sm-3"><input id="txtSenderId" placeholder="SMS Sender Id" type="text" class="form-control" value="<?php echo $sms_sender_id; ?>"></div>
                                    </div>
                                    
                                    
                                    <!--SMS Api Key-->
                                    <div title="SMS Api Key" class="position-relative row form-group"><label for="txtApiKey" class="col-sm-3 col-form-label text-right">SMS Api Key<span class="redtext">*</span></label>
                                    
                                        <div class="col-sm-9"><input id="txtApiKey" placeholder="SMS Api Key" type="text" class="form-control" value="<?php echo $sms_apikey; ?>"></div>
                                    </div>
                                    
                                    <!--Application Run Mode/Refresh Interval-->
                                    <div class="position-relative row form-group">
                                        
                                         <label title="Application Run Mode" for="cboMode" class="col-sm-3 col-form-label text-right">Application Run Mode<span class="redtext">*</span></label>
                                         
                                         
                                         <div title="Application Run Mode" class="col-sm-3">
                                        	<select id="cboMode" class="form-control">
                                            	<option value="">[SELECT]</option>
                                                <option value="Sandbox">Sandbox</option>
                                                <option value="Live">Live</option>
                                            </select>
                                        </div>
                                        
                                         <!--Refresh Interval-->
                                         <label title="Prices Refresh Interval In Minutes" for="txtInterval" class="col-sm-3 col-form-label text-right">Refresh Interval (Min)<span class="redtext">*</span></label>
                                         
                                         <div title="Prices Refresh Interval In Minutes" class="col-sm-3">
                                        	<input id="txtInterval" placeholder="Prices Refresh Interval In Minute" type="number" class="form-control" value="<?php echo $refreshinterval; ?>">
                                        </div>
                                    </div>
                                    
                                    <!--NSE Account Name/NSE Bank-->
                                    <div class="position-relative row form-group">
                                    	<!--NSE Account Name-->
                                        <label title="NSE Account Name" for="txtAccName" class="col-sm-3 col-form-label text-right">NSE Account Name<span class="redtext">*</span>
                                        </label>
                                    
                                        <div title="NSE Account Name" class="col-sm-3"><input id="txtAccName" placeholder="NSE Account Name" type="text" class="form-control" value="<?php echo $account_name; ?>"></div>
                                        
                                        <!--NSE Bank-->
                                        <label title="NSE Bank" for="cboBank" class="col-sm-3 col-form-label text-right">NSE Bank<span class="redtext">*</span></label>
                                    
                                        <div title="NSE Bank" class="col-sm-3">
                                        	<select id="cboBank" class="form-control"></select>
                                        </div>                                        
                                    </div>
                                    
                                    <!--NSE Account No/NSE Recipient Code-->
                                  <div class="position-relative row form-group">
                                  	<label title="NSE Account No" for="txtAccNo" class="col-sm-3 col-form-label text-right">NSE Account No<span class="redtext">*</span>
                                   	</label>
                                    
                                        <div class="col-sm-3"><input id="txtAccNo" placeholder="NSE Account No" type="text" class="form-control" value="<?php echo $account_number; ?>"></div>
                                        
                                        
                                        <!--NSE Recipient Code-->
                                        <label title="NSE Recipient Code" for="txtRecipientCode" class="col-sm-3 col-form-label text-right">NSE Recipient Code</label>
                                    
                                        <div title="NSE Recipient Code" class="col-sm-3">
                                        	<input readonly id="txtRecipientCode" placeholder="NSE Transfer Recipient Code" type="text" class="form-control redalerttext" value="<?php echo $recipient_code; ?>" style="background:#ffffff; cursor:default;">
                                        </div>
                                    </div>
                                    
                                   <!--Blockchain Token-->
                                    <div title="Blockchain Token" class="position-relative row form-group"><label for="txtBlockchainToken" class="col-sm-3 col-form-label text-right">Blockchain Token</label>
                                    
                                        <div class="col-sm-9"><input id="txtBlockchainToken" placeholder="Blockchain Token" type="text" class="form-control" value="<?php echo $blockchain_token; ?>"></div>
                                    </div>
                                    
                                    <!--Blockchain Base Url/Messages Deletion Period-->
                                  <div class="position-relative row form-group">
                                  	<!--Blockchain Base Url-->
                                    <label title="Blockchain APIs Base Url" for="txtBaseurl" class="col-sm-3 col-form-label text-right">Blockchain APIs Base Url</label>
                                    
                                    <div title="Blockchain APIs Base Url" class="col-sm-3"><input id="txtBaseurl" placeholder="Blockchain APIs Base Url" type="url" class="form-control" value="<?php echo $blockchain_baseurl; ?>"></div>
                                  
                                  	<!--Messages Deletion Period-->
                                  	<label title="Messages Deletion Period (In Days)" for="txtDeleteMsg" class="col-sm-3 col-form-label text-right">Deletion Messages Older Than<span class="redtext">*</span>
                                   	</label>
                                    
                                        <div title="Messages Deletion Period (In Days)" class="col-sm-2">
                                        	<input id="txtDeleteMsg" placeholder="Message Deletion Period (In Days)" type="text" class="form-control" value="<?php echo $message_delete_period; ?>">
                                        </div>
                                        
                                       <label style="padding-left:0; font-weight:normal;" title="Messages Deletion Period (In Days)" class="col-sm-1 col-form-label nobold redtext">Days</label>
                                    </div>
                                   
                                    <!--NSE Blockchain Address-->
                                    <div title="NSE Blockchain Address" class="position-relative row form-group"><label for="txtBlockchainAddress" class="col-sm-3 col-form-label text-right">NSE Blockchain Address<span class="redtext">*</span></label>
                                    
                                        <div class="col-sm-9"><input id="txtBlockchainAddress" placeholder="NSE Blockchain Address" type="text" class="form-control" value="<?php echo $blockchain_address; ?>"></div>
                                    </div>
                                    
                                    
                                   <div class="position-relative row form-check">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button id="btnUpdate" type="button" class="btn-pill btn btn-nse-green"><i class="pe-7s-note size-14 makebold"></i> Update Settings</button>                                                
                                             <button onClick="window.location.reload(true);" style="margin-left:10px;" type="button" class="btn-pill btn btn-danger"><i class="pe-7s-refresh-2 size-14 makebold"></i> Refresh</button>
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
