<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Derived Homes - Paystack Settings</title>
    <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Naija Art Mart - The New Art Market For Everyone">    
    <meta name="msapplication-tap-highlight" content="no"><!-- Disable tap highlight on IE -->

	<?php include('header.php'); ?>
    <?php include('scripts.php'); ?>

	

	<script type = "text/javascript">
	
	var Title='<font color="#AF4442">Artx Exchange Message</font>';
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
		
		if ('<?php echo $otp_status; ?>' == '1')
		{
			 $("#chkOTP").prop("checked", true);
		}else
		{
			 $("#chkOTP").prop("checked", false);
		}
		
		$('#btnUpdate').click(function(e) {
			try
			{
				if (!CheckUpdate()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Update Paystack Settings Button Clicked ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
		});//btnUpdate Click Ends
		
		$('#chkOTP').click(function(e) {
            try
			{
				if ($(this).is(':checked'))
				{
					EnableDisableOTP('1');
				}else
				{
					EnableDisableOTP('0');
				}
			}catch(e)
			{
				$.unblockUI();
				m='OTP Checkbox Clicked ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
        });
		
		function EnableDisableOTP(state)
		{
			try
			{
				if (state=='1')
				{
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Enabling OTP. Please Wait...</p>',theme: false,baseZ: 2000});	
				}else
				{
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Disabling OTP. Please Wait...</p>',theme: false,baseZ: 2000});
				}				
				
				var uri = "<?php echo site_url('admin/Paystack/EnableDisableOTP'); ?>";
				var xhr = new XMLHttpRequest();
				var fd = new FormData();
				
				xhr.open("POST", uri, true);
			
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4 && xhr.status == 200)
					{
						$.unblockUI();
						
						var res=$.trim(xhr.responseText);
						var r=res.split('^');
						
													
						if (r[0].toUpperCase()=='OK')
						{
							if (state=='1')
							{
								m='OTP Has Been Enabled For Your Transactions Successfully.';
								DisplayMessage(m, 'success','OTP State Updated','SuccessTheme');
							}else
							{
								//Confirm
								m='Your request to disable OTP during transfers has been submitted. '+r[1]+'.<br><br>To confirm the disabling of OTP, enter the OTP sent to your phone in the text box below and click on <b>CONFIRM</b> button.';
								
								ConfirmDisableOTP(m);
							}																											
						}else
						{
							m=res;								
							DisplayMessage(m, 'error',Title);
						}
					}
				};
			
				fd.append('state', state);
				
				xhr.send(fd);// Initiate a multipart/form-data upload
			}catch(e)
			{
				$.unblockUI();
				m='EnableDisableOTP ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
		}
		
		function ConfirmDisableOTP(msg)
		{
			try
			{
				Swal.fire({
					icon: 'info',
					title: 'PLEASE CONFIRM ACTION',
					input: 'text',
					inputAttributes: {autocapitalize: 'off'},
					html: msg,
					showClass: {popup: 'animate__animated animate__fadeInDown'},
					hideClass: {popup: 'animate__animated animate__fadeOutUp'},
					showCancelButton: true,
					cancelButtonColor: '#d33',
					cancelButtonText: '<font size="3" face="Arial">CANCEL</font>',
					confirmButtonText: '<font size="3" face="Arial">CONFIRM</font>',
					confirmButtonColor: '#3085d6',
					showLoaderOnConfirm: true,
					inputValidator: (value) => {
						if (value)
						{
							value=$.trim(value);
							
							if (!$.isNumeric(value)) return 'OTP MUST be a number.';
							if (parseFloat(value) == 0) return 'OTP must not be zero.';			
							if (parseFloat(value) < 0) return 'OTP MUST NOT be a negative number.';			
							if (value.length < 3) return 'OTP size is too short.';
							
							//Send Value
							$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Confirming Disabling Of Transfer OTP. Please Wait...</p>',theme: false,baseZ: 2000});
							
							//Initiate POST
							var uri = "<?php echo site_url('admin/Paystack/ConfirmDisableOTP'); ?>";
							var xhr = new XMLHttpRequest();
							var fd = new FormData();
							
							xhr.open("POST", uri, true);
							
							xhr.onreadystatechange = function() {
								if (xhr.readyState == 4 && xhr.status == 200)
								{
									$.unblockUI();
									
									var res=$.trim(xhr.responseText);
																
									if (res.toUpperCase()=='OK')
									{
										m='Your Transfer OTP Has Been Disabled Successfully.';
										DisplayMessage(m, 'success','Transfer OTP Disabled','SuccessTheme');																												
									}else
									{
										m=res;								
										DisplayMessage(m, 'error',Title);
									}
								}
							};
						
							fd.append('otp', value);
												
							xhr.send(fd);// Initiate a multipart/form-data upload
						}else
						{
							return 'OTP field must not be blank. You need to enter a value.';
						}
					}
				})
			}catch(e)
			{
				$.unblockUI();
				m='ConfirmDisableOTP ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
		}
		
		function CheckUpdate()
		{
			try
			{
				var url=$.trim($('#txtVerifyUrl').val());
				var skey=$.trim($('#txtSandboxKey').val());	
				var lkey=$.trim($('#txtLiveKey').val());				
				var intper=$.trim($('#txtInternationalPercent').val()).replace(new RegExp('%', 'g'), '');				
				var locper=$.trim($('#txtLocalPercent').val()).replace(new RegExp('%', 'g'), '');				
				var intextra=$.trim($('#txtInternationalExtraFee').val()).replace(new RegExp(',', 'g'), '');					
				var locextra=$.trim($('#txtLocalExtraFee').val()).replace(new RegExp(',', 'g'), '');				
				var intcap=$.trim($('#txtInternationalCap').val()).replace(new RegExp(',', 'g'), '');					
				var loccap=$.trim($('#txtLocalCap').val()).replace(new RegExp(',', 'g'), '');
				var intwaiv=$.trim($('#txtInternationalWaiver').val()).replace(new RegExp(',', 'g'), '');					
				var locwaiv=$.trim($('#txtLocalWaiver').val()).replace(new RegExp(',', 'g'), '');				
				var fee=$.trim($('#txtTransferFee').val()).replace(new RegExp(',', 'g'), '');				
																	
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the parameters update.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}			
				
				//Paystack sandbox secret Key
				if (!skey)
				{
					m='Paystack sandbox secret Key field must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}		
								
				//Paystack live secret Key
				/*if (!lkey)
				{
					m='Paystack live secret Key field must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}*/
				
				//Paystack verification url
				if (!url)
				{
					m='Paystack payment verification url field must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}
				
				if (!isUrl(url))
				{
					m='Invalid paystack payment verification url. Please check your entry and retype the url.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}
				
				//Transfer Fee
				if (!fee)
				{
					m='Paystack fee per funds transfer field must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					
				}				
				
				if (!$.isNumeric(fee))
				{
					m='Paystack fee per funds transfer MUST be a number. Current entry <b>'+fee+'</b> is not valid.';						
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(fee) == 0)
				{
					m='Paystack fee per funds transfer must not be zero.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(fee) < 0)
				{
					m='Paystack fee per funds transfer must not be a negative number.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				//International transaction commission percent
				if (!intper)
				{
					m="Paystack international transactions commission percentage field must not be blank.";
					
					DisplayMessage(m, 'error',Title);
					
				}				
				
				if (!$.isNumeric(intper))
				{
					m="Paystack international transactions commission percentage MUST be a number. Current entry <b>"+intper+"</b> is not valid.";						
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(intper) == 0)
				{
					m="Paystack international transactions commission percentage must not be zero.";				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(intper) < 0)
				{
					m="Paystack international transactions commission percentage must not be a negative number.";				
					DisplayMessage(m, 'error',Title);
					return false;
				}
					
				//Local transaction commission percent
				if (!locper)
				{
					m="Paystack local transactions commission percentage field must not be blank.";
					
					DisplayMessage(m, 'error',Title);
					
				}				
				
				if (!$.isNumeric(locper))
				{
					m="Paystack local transactions commission percentage MUST be a number. Current entry <b>"+locper+"</b> is not valid.";						
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(locper) == 0)
				{
					m="Paystack local transactions commission percentage must not be zero.";				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(locper) < 0)
				{
					m="Paystack local transactions commission percentage must not be a negative number.";				
					DisplayMessage(m, 'error',Title);
					return false;
				}	
				
				//International Extra Fee				
				if (!intextra)
				{
					m='Paystack international transactions extra fee field must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					
				}				
				
				if (!$.isNumeric(intextra))
				{
					m='Paystack international transactions extra fee MUST be a number. Current entry <b>'+intextra+'</b> is not valid.';						
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(intextra) == 0)
				{
					m='Paystack international transactions extra fee must not be zero.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(intextra) < 0)
				{
					m='Paystack international transactions extra fee must not be a negative number.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				//Local Extra Fee				
				if (!locextra)
				{
					m='Paystack local transactions extra fee field must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					
				}				
				
				if (!$.isNumeric(locextra))
				{
					m='Paystack local transactions extra fee MUST be a number. Current entry <b>'+locextra+'</b> is not valid.';						
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(locextra) == 0)
				{
					m='Paystack local transactions extra fee must not be zero.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(locextra) < 0)
				{
					m='Paystack local transactions extra fee must not be a negative number.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}				
				
				
				//International Cap
				if (intcap)
				{					
					if (!$.isNumeric(intcap))
					{
						m='Paystack international transactions commission cap MUST be a number. Current entry <b>'+intcap+'</b> is not valid.';						
						DisplayMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(intcap) < 0)
					{
						m='Paystack international transactions commission cap must not be a negative number.';				
						DisplayMessage(m, 'error',Title);
						return false;
					}	
				}				
				
				//Local Cap
				if (!loccap)
				{
					m='Paystack local transactions commission cap field must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					
				}
				
				if (!$.isNumeric(loccap))
				{
					m='Paystack local transactions commission cap MUST be a number. Current entry <b>'+loccap+'</b> is not valid.';						
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(loccap) == 0)
				{
					m='Paystack local transactions commission cap must not be zero.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(loccap) < 0)
				{
					m='Paystack local transactions commission cap must not be a negative number.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				//International Waiver				
				if (intwaiv)
				{
					if (!$.isNumeric(intwaiv))
					{
						m='International fee waiver limit MUST be a number. Current entry <b>'+intwaiv+'</b> is not valid.';						
						DisplayMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(intwaiv) < 0)
					{
						m='International fee waiver limit must not be a negative number.';				
						DisplayMessage(m, 'error',Title);
						return false;
					}						
				}				
				
				//Local Waiver				
				if (!locwaiv)
				{
					m='Local fee waiver limit must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					
				}
				
				if (!$.isNumeric(locwaiv))
				{
					m='Local fee waiver limit MUST be a number. Current entry <b>'+locwaiv+'</b> is not valid.';						
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(locwaiv) == 0)
				{
					m='Local fee waiver limit must not be zero.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(locwaiv) < 0)
				{
					m='Local fee waiver limit must not be a negative number.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				

				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: '<font size="3" face="Arial">Do you want to proceed with the updating of the Paystack settings?</font>',
				  type: 'question',
				  showClass: {popup: 'animate__animated animate__fadeInDown'},
				  hideClass: {popup: 'animate__animated animate__fadeOutUp'},
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Updating Paystack Settings. Please Wait...</p>',theme: false,baseZ: 2000});
					
					//Initiate POST
					var uri = "<?php echo site_url('admin/Paystack/UpdateSettings'); ?>";
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
								m='Paystack Settings Have Been Updated Successfully.';
								DisplayMessage(m, 'success','Paystack Settings Updated','SuccessTheme');
								
								setTimeout(window.location.reload(true), 5000);																													
							}else
							{
								m=res;								
								DisplayMessage(m, 'error',Title);
							}
						}
					};
				
					fd.append('VerifyUrl', url);
					fd.append('Sandbox_SecretKey', skey);
					fd.append('Live_SecretKey', lkey);						
					fd.append('local_trans_percent', locper);
					fd.append('local_commission_cap', loccap);				
					fd.append('local_extra_fee', locextra);
					fd.append('inter_trans_percent', intper);
					fd.append('inter_commission_cap', intcap);
					fd.append('inter_extra_fee', intextra);
					fd.append('inter_commission_waiver', intwaiv);
					fd.append('local_commission_waiver', locwaiv);
					fd.append('transfer_fee', fee);
					
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
                                                    Paystack Settings
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
                                    <!--Sandbox Secret Key-->
                                    <div title="Sandbox Secret Key" class="position-relative row form-group">
                                        
                                         <label for="txtSandboxKey" class="col-sm-3 col-form-label">Sandbox Secret Key<span class="redtext">*</span></label>
                                         
                                         
                                         <div class="col-sm-9">
                                        	<input id="txtSandboxKey" placeholder="Sandbox Secret Key" type="text" class="form-control" value="<?php echo $Sandbox_SecretKey; ?>">
                                        </div>
                                    </div>                                    
                                    
                                    <!--Live Secret Key-->
                                    <div title="Live Secret Key" class="position-relative row form-group"><label for="txtLiveKey" class="col-sm-3 col-form-label">Live Secret Key</label>
                                    
                                        <div class="col-sm-9"><input id="txtLiveKey" placeholder="Live Secret Key" type="text" class="form-control" value="<?php echo $Live_SecretKey; ?>"></div>
                                    </div>
                                    
                                    <!--Payment Verification Url/Transfer Fee-->
                                    <div title="Payment Verification Url" class="position-relative row form-group"><label for="txtVerifyUrl" class="col-sm-3 col-form-label">Payment Verification Url<span class="redtext">*</span></label>
                                    
                                        <div class="col-sm-4">
                                        	<input id="txtVerifyUrl" placeholder="Payment Verification Url" type="text" class="form-control" value="<?php echo $VerifyUrl; ?>">
                                        </div>
                                        
                                        <!--Transfer Fee-->   
                                       <label title="Fee Per Funds Transfer (₦)" for="txtTransferFee" class="col-sm-2 col-form-label text-right">Fee Per Transfer<span class="redtext">*</span></label>
                                       
                                        <div title="Fee Per Funds Transfer (₦)" class="col-sm-3">
                                        	<div class="input-group">
                                             	<div class="input-group-prepend"><span class="input-group-text btn-nse-darkgreen">₦</span></div>
                                             	<input id="txtTransferFee" placeholder="Fee Per Funds Transfer" type="text" class="form-control" value="<?php if (floatval($transfer_fee) > 0) echo number_format($transfer_fee,2); else echo ''; ?>">
                                             </div>
                                       </div>
                                    </div>
                                    
                                    <!--International Transaction Percent (%)/Local Transaction Percent (%)-->
                                    <div class="position-relative row form-group">
                                    	<label title="International Transaction Commission Percentage (%)" for="txtInternationalPercent" class="col-sm-3 col-form-label">International Commission %<span class="redtext">*</span></label>
                                    
                                        <div title="International Transaction Commission Percentage (%)" class="col-sm-4">
                                        	<div class="input-group">
                                             	<input id="txtInternationalPercent" placeholder="International Trans. Commission" type="text" class="form-control" value="<?php if (floatval($inter_trans_percent) > 0) echo number_format($inter_trans_percent,2); else echo ''; ?>">
                                                <div class="input-group-prepend"><span class="input-group-text btn-nse-darkgreen">%</span></div>
                                             </div>
                                        </div>
                                         
                                        <!--Local Transaction %-->
                                        <label title="Local Transaction Commission Percent (%)" for="txtLocalPercent" class="col-sm-2 col-form-label text-right">Local Commission %<span class="redtext">*</span></label>
                                    
                                        <div title="Local Transaction Commission Percent (%)" class="col-sm-3">
                                        	<div class="input-group">
                                             	<input id="txtLocalPercent" placeholder="Local Trans. Commission" type="text" class="form-control" value="<?php if (floatval($local_trans_percent) > 0) echo number_format($local_trans_percent,2); else echo ''; ?>">
                                                <div class="input-group-prepend"><span class="input-group-text btn-nse-darkgreen">%</span></div>
                                             </div>
                                       </div>                       
                                    </div>
                                    
                                    <!--International Transaction %/Local Extra Fee-->
                                    <div class="position-relative row form-group">
                                        <!--International Extra Fee-->   
                                       <label title="International Extra Fee (₦)" for="txtInternationalExtraFee" class="col-sm-3 col-form-label">International Extra Fee<span class="redtext">*</span></label>
                                                                             
                                       
                                        <div title="International Extra Fee (₦)" class="col-sm-4">
                                        	<div class="input-group">
                                             	<div class="input-group-prepend"><span class="input-group-text btn-nse-darkgreen">₦</span></div>
                                             	<input id="txtInternationalExtraFee" placeholder="International Extra Fee" type="text" class="form-control" value="<?php if (floatval($inter_extra_fee) > 0) echo number_format($inter_extra_fee,2); else echo ''; ?>">
                                             </div>
                                       </div> 
                                       
                                      <!--Local Extra Fee-->   
                                       <label title="Local Extra Fee (₦)" for="txtLocalExtraFee" class="col-sm-2 col-form-label text-right">Local Extra Fee<span class="redtext">*</span></label>
                                       
                                        <div title="Local Extra Fee (₦)" class="col-sm-3">
                                        	<div class="input-group">
                                             	<div class="input-group-prepend"><span class="input-group-text btn-nse-darkgreen">₦</span></div>
                                             	<input id="txtLocalExtraFee" placeholder="Local Extra Fee" type="text" class="form-control" value="<?php if (floatval($local_extra_fee) > 0) echo number_format($local_extra_fee,2); else echo ''; ?>">
                                             </div>
                                       </div>
                                    </div>
                                    
                                    
                                    <!--International Commission Cap/Local Commission Cap-->
                                    <div class="position-relative row form-group">
                                        <!--International Commission Cap-->   
                                       <label title="International Commission Cap (₦)" for="txtInternationalCap" class="col-sm-3 col-form-label">International Commission Cap</label>
                                       
                                        <div title="International Commission Cap (₦)" class="col-sm-4">
                                        	<div class="input-group">
                                             	<div class="input-group-prepend"><span class="input-group-text btn-nse-darkgreen">₦</span></div>
                                             	<input id="txtInternationalCap" placeholder="International Commission Cap" type="text" class="form-control" value="<?php if (floatval($inter_commission_cap) > 0) echo number_format($inter_commission_cap,2); else echo ''; ?>">
                                            </div>
                                       </div> 
                                       
                                       <!--Local Commission Cap-->
                                        <label title="Local Commission Cap (₦)" for="txtLocalCap" class="col-sm-2 col-form-label text-right">Local Commission Cap<span class="redtext">*</span></label>
                                    
                                        <div title="Local Commission Cap (₦)" class="col-sm-3">
                                        	<div class="input-group">
                                             	<div class="input-group-prepend"><span class="input-group-text btn-nse-darkgreen">₦</span></div>
                                             	<input id="txtLocalCap" placeholder="Local Commission Cap" type="text" class="form-control" value="<?php if (floatval($local_commission_cap) > 0) echo number_format($local_commission_cap,2); else echo ''; ?>">
                                            </div>
                                       </div>
                                    </div>
                                    
                                    
                                    <!--International Fee Waiver Limit/Local Fee Waiver Limit-->
                                    <div class="position-relative row form-group">
                                        <!--International Fee Waiver Limit-->   
                                       <label title="International Fee Waiver Limit (₦)" for="txtInternationalWaiver" class="col-sm-3 col-form-label">International Fee Waiver Limit</label>
                                       
                                        <div title="International Fee Waiver Limit (₦)" class="col-sm-4">
                                        	<div class="input-group">
                                             	<div class="input-group-prepend"><span class="input-group-text btn-nse-darkgreen">₦</span></div>
                                             	<input id="txtInternationalWaiver" placeholder="International Fee Waiver Limit" type="text" class="form-control" value="<?php if (floatval($inter_commission_waiver) > 0) echo number_format($inter_commission_waiver,2); else echo ''; ?>">
                                            </div>
                                       </div> 
                                       
                                       <!--Local Fee Waiver Limit-->
                                        <label title="Local Fee Waiver Limit (₦)" for="txtLocalWaiver" class="col-sm-2 col-form-label text-right">Local Fee Waiver Limit<span class="redtext">*</span></label>
                                    
                                        <div title="Local Fee Waiver Limit (₦)" class="col-sm-3">
                                        	<div class="input-group">
                                             	<div class="input-group-prepend"><span class="input-group-text btn-nse-darkgreen">₦</span></div>
                                             	<input id="txtLocalWaiver" placeholder="Local Fee Waiver Limit" type="text" class="form-control" value="<?php if (floatval($local_commission_waiver) > 0) echo number_format($local_commission_waiver,2); else echo ''; ?>">
                                            </div>
                                       </div>
                                    </div>
                                    
                                    
                                   <div class="position-relative row " style="margin-top:30px;">
                                        <div class="col-sm-6 offset-sm-3">
                                            <button id="btnUpdate" type="button" class="btn-pill btn btn-nse-green"><i class="pe-7s-note size-14 makebold"></i> Update Paystack Settings</button>                                                
                                             <button onClick="window.location.reload(true);" style="margin-left:10px; padding-left:50px; padding-right: 50px;" type="button" class="btn-pill btn btn-danger"><i class="pe-7s-refresh-2 size-14 makebold"></i> Refresh</button>
                                        </div>
                                        
                                        <!--OTP Button (Enable/Disable)-->
                                        <div title="Click to enable/disable the One-Time-Password feature" class="col-sm-3">
                                        	<div class="custom-checkbox custom-control text-right makebold">
                                            	<input type="checkbox" id="chkOTP" class="custom-control-input">
                                            	<label style="color:#3F6AD8;" class="custom-control-label" for="chkOTP">OTP (Enable/Disable)</label>
                                            </div>                                        
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
