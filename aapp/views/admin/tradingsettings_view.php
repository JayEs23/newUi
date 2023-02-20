<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Naija Art Mart - Trading Parameters</title>
    <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Naija Art Mart - The New Art Market For Everyone">    
    <meta name="msapplication-tap-highlight" content="no"><!-- Disable tap highlight on IE -->

	<?php include('header.php'); ?>
    <?php include('scripts.php'); ?>

	 

	<script type = "text/javascript">
	
	var Title='<font color="#AF4442">Trading Parameters Message</font>';
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
		
		$('#txtMarketStartTime').ptTimeSelect({
			containerClass: "",
			containerWidth: "350px",
			setButtonLabel: "Set Time",
			popupImage :'<img src="<?php echo base_url(); ?>images/clock.png" height="37px" />',
			minutesLabel: "Minutes",
			hoursLabel: "Hours"
		});
		
		$('#btnStartTime').click(function(e) {
            $('#txtMarketStartTime').trigger('focus');
        });
		
		$('#txtMarketCloseTime').ptTimeSelect({
			containerClass: "",
			containerWidth: "auto",
			setButtonLabel: "Set Time",
			popupImage :'<img src="<?php echo base_url(); ?>images/clock.png" height="37px" />',
			minutesLabel: "Minutes",
			hoursLabel: "Hours"
		});
		
		$('#btnCloseTime').click(function(e) {
            $('#txtMarketCloseTime').trigger('focus');
        });
		
		
		$('#txtMarketStartTime').blur(function(e) {
			try
			{
				if ($('#txtMarketStartTime').val() && $('#txtMarketCloseTime').val())
				{
					ret=VerifyStartAndCloseTimes();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="Start Time Blur ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});
		
		$('#txtMarketStartTime').change(function(e) {
			try
			{
				if ($('#txtMarketStartTime').val() && $('#txtMarketCloseTime').val())
				{
					var ret=VerifyStartAndCloseTimes();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="Start Time Change ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});
		
		
		$('#txtMarketCloseTime').blur(function(e) 
		{
			try
			{
				if ($('#txtMarketStartTime').val() && $('#txtMarketCloseTime').val())
				{
					var ret=VerifyStartAndCloseTimes();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="Closing Time Blur ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}
		});
		
		$('#txtMarketCloseTime').change(function(e) 
		{
			try
			{
				if ($('#txtMarketStartTime').val() && $('#txtMarketCloseTime').val())
				{
					var ret=VerifyStartAndCloseTimes();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="Closing Time Change ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});	
			
		
		$('#btnUpdate').click(function(e) {
			try
			{
				if (!CheckUpdate()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Update Parameters Button Clicked ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
		});//btnUpdate Click Ends
		
		
		function VerifyStartAndCloseTimes()
		{
			try
			{
				$('#divAlert').html('');
				
				var start = $.trim($('#txtMarketStartTime').val());
				var end   = $.trim($('#txtMarketCloseTime').val());
				
				var regex = new RegExp(':', 'g');
				
				if (parseInt(start.replace(regex, ''), 10) == parseInt(end.replace(regex, ''), 10))
				{
				  	$('#txtMarketCloseTime').val('');
										
					m="Market Closing Time And Starting Time Are The Same. Please Correct Your Selections!";
					DisplayMessage(m, 'error',Title);
					
					return false;
				}else if (parseInt(start.replace(regex, ''), 10) < parseInt(end.replace(regex, ''), 10))
				{
				  return true;// 'start is earlier then end';
				}else
				{
					$('#txtMarketCloseTime').val('');
										
					m="Market Closing Time Is Earlier Than Starting Time. Please Correct Your Selections!";
					DisplayMessage(m, 'error',Title);
					
					return false;
				}	
			}catch(e)
			{
				$.unblockUI();
				m="VerifyStartAndCloseTimes ERROR:\n"+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}			
		}		
		
		function CheckUpdate()
		{
			try
			{
				var st=$.trim($('#txtMarketStartTime').val());
				var ct=$.trim($('#txtMarketCloseTime').val());
				var qty=$.trim($('#txtBuyQty').val()).replace(new RegExp(',', 'g'), '');
				var lmt=$.trim($('#txtPriceLimit').val()).replace(new RegExp('%', 'g'), '');				
				var bc=$.trim($('#txtBrokerCommission').val()).replace(new RegExp('%', 'g'), '');	
				var nc=$.trim($('#txtNSECommission').val()).replace(new RegExp('%', 'g'), '');
				var dys=$.trim($('#txtMaxDays').val()).replace(new RegExp(',', 'g'), '');
				var sms=$.trim($('#txtSMSFee').val()).replace(new RegExp(',', 'g'), '');
				var hp=$.trim($('#txtHoldingPeriod').val()).replace(new RegExp(',', 'g'), '');
				
																	
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the parameters update.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}
				
				//Start time			
				if (!st)
				{
					m='Market daily starting time field must not be blank. Please make a selection.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}
				
				//Closing time				
				if (!ct)
				{
					m='Market daily closing time field must not be blank. Please make a selection.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}
				
				var ret=VerifyStartAndCloseTimes();
				
				if (ret==false) return false;
				
				//Buy Qty				
				if (!qty)
				{
					m='Minimum buy quantity field must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					
				}				
				
				if (!$.isNumeric(qty))
				{
					m='Minimum buy quantity MUST be a number. Current entry <b>'+qty+'</b> is not valid.';						
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(qty) == 0)
				{
					m='Minimum buy quantity must not be zero.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(qty) < 0)
				{
					m='Minimum buy quantity must not be a negative number.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}				
				
				
				//Price Limit
				if (!lmt)
				{
					m='Price limit percentage field must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					
				}				
				
				if (!$.isNumeric(lmt))
				{
					m='Price limit percentage MUST be a number. Current entry <b>'+lmt+'</b> is not valid.';						
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(lmt) == 0)
				{
					m='Price limit percentage must not be zero.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(lmt) < 0)
				{
					m='Price limit percentage must not be a negative number.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				//Broker's Commission
				if (!bc)
				{
					m="Broker's commission field must not be blank.";
					
					DisplayMessage(m, 'error',Title);
					
				}				
				
				if (!$.isNumeric(bc))
				{
					m="Broker's commission MUST be a number. Current entry <b>"+bc+"</b> is not valid.";						
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(bc) == 0)
				{
					m="Broker's commission must not be zero.";				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(bc) < 0)
				{
					m="Broker's commission must not be a negative number.";				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				//NSE Commission
				if (!nc)
				{
					m="NSE commission field must not be blank.";
					
					DisplayMessage(m, 'error',Title);
					
				}				
				
				if (!$.isNumeric(nc))
				{
					m="NSE commission MUST be a number. Current entry <b>"+nc+"</b> is not valid.";						
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(nc) == 0)
				{
					m="NSE commission must not be zero.";				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(nc) < 0)
				{
					m="NSE commission must not be a negative number.";				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				
				//Holding Period
				if (!hp)
				{
					m="Holding period field must not be blank.";
					
					DisplayMessage(m, 'error',Title);
					
				}				
				
				if (!$.isNumeric(hp))
				{
					m="Holding period MUST be a number. Current entry <b>"+hp+"</b> is not valid.";						
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseInt(hp) == 0)
				{
					m="Holding period must not be zero.";				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(hp) < 0)
				{
					m="Holding period must not be a negative number.";				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				//Maximum No Of Days				
				if (!dys)
				{
					m='Field for maximum number of days for infinite orders like Good Till Cancelled (GTC) must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					
				}				
				
				if (!$.isNumeric(dys))
				{
					m='Maximum number of days for infinite orders like Good Till Cancelled (GTC) MUST be a number. Current entry <b>'+dys+'</b> is not valid.';						
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(dys) == 0)
				{
					m='Maximum number of days for infinite orders like Good Till Cancelled (GTC) must not be zero.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(dys) < 0)
				{
					m='Maximum number of days for infinite orders like Good Till Cancelled (GTC) must not be a negative number.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}	
				
				//SMS Fee
				if (!sms)
				{
					m='SMS fee field must not be blank.';
					
					DisplayMessage(m, 'error',Title);
					
				}				
				
				if (!$.isNumeric(sms))
				{
					m='SMS fee MUST be a number. Current entry <b>'+sms+'</b> is not valid.';						
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(sms) == 0)
				{
					m='SMS fee must not be zero.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(sms) < 0)
				{
					m='SMS fee must not be a negative number.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				

				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: '<font size="3" face="Arial">Do you want to proceed with the updating of the trading parameters?</font>',
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Updating Trading Parameters. Please Wait...</p>',theme: false,baseZ: 2000});
					
					//Initiate POST
					var uri = "<?php echo site_url('admin/Tradingsettings/UpdateParameter'); ?>";
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
							m='Trading Parameters Have Been Updated Successfully.';
							DisplayMessage(m, 'success','Trading Parameters Updated','SuccessTheme');
							
							setTimeout(window.location.reload(true), 5000);																													
						}else
						{
							m=res;								
							DisplayMessage(m, 'error',Title);
						}
					}
				};
				
					fd.append('market_start_time', st);
					fd.append('market_close_time', ct);
					fd.append('min_buy_qty', qty);						
					fd.append('brokers_commission', bc);
					fd.append('nse_commission', nc);				
					fd.append('price_limit_percent', lmt);
					fd.append('max_order_days', dys);
					fd.append('sms_fee', sms);
					fd.append('holdingperiod', hp);
																				
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
                                                    Trading Parameters
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
                                	<!--Market Starting Time-->
                                    <div class="position-relative row form-group">
                                    	<label title="Daily Market Starting Time" for="txtMarketStartTime" class="col-sm-3 col-form-label">Market Starting Time<span class="redtext">*</span></label>
                                        
                                        
                                        		<div title="Daily Market Starting Time" class="col-sm-3 input-group">
                                                    <input style="background:#ffffff; cursor:default;" readonly id="txtMarketStartTime" type="text" class="form-control" placeholder="Market Starting Time" value="<?php echo $market_start_time; ?>">
                                                </div>
                                        
                                        
                                                                                      
                                        
                                        
                                        <!--Market Closing Time-->
                                        <label title="Daily Market Closing Time"  for="txtMarketCloseTime" class="col-sm-3 col-form-label text-right">Market Closing Time<span class="redtext">*</span></label>
                                    	
                                         <div title="Daily Market Closing Time" class="col-sm-3">
                                            <div class="input-group">
                                                <input style="background:#ffffff; cursor:default;" readonly id="txtMarketCloseTime" placeholder="Market Closing Time" type="text" class="form-control" value="<?php echo $market_close_time; ?>">
                                            </div>
                                         </div>
                                    </div>
                                    
                                    
                                    <!--Minimum Buy Quantity-->
                                    <div title="Minimum Buy Quantity That Can Effect A Price Change" class="position-relative row form-group"><label for="txtBuyQty" class="col-sm-3 col-form-label">Minimum Buy Quantity<span class="redtext">*</span></label>
                                    
                                        <div class="col-sm-9">
                                        	<input id="txtBuyQty" placeholder="Minimum Buy Quantity To Change Price" type="text" class="form-control" value="<?php echo number_format($min_buy_qty,0); ?>">
                                        </div>
                                    </div>
                                    
                                    <!--Application Run Mode-->
                                    <div title="Percentage Of Current Price Beyond Or Below Which Buying And Selling Price Cannot Exceed" class="position-relative row form-group">
                                        
                                         <label for="txtPriceLimit" class="col-sm-3 col-form-label">Price Limit Percentage (%)<span class="redtext">*</span></label>
                                         
                                         
                                         <div class="col-sm-9">
                                        	<input id="txtPriceLimit" placeholder="Buy/Sell Price Limit Percentage" type="text" class="form-control" value="<?php if (floatval($price_limit_percent) > 0) echo number_format($price_limit_percent,2).'%'; else echo ''; ?>">
                                        </div>
                                    </div>
                                    
                                    
                                    <!--Broker's Commission-->
                                    <div title="Broker's Commission. This Is A Percentage Of Each Trade Value" class="position-relative row form-group"><label for="txtBrokerCommission" class="col-sm-3 col-form-label">Broker's Commission (%)<span class="redtext">*</span></label>
                                    
                                        <div class="col-sm-9"><input id="txtBrokerCommission" placeholder="Broker's Commission Percentage" type="text" class="form-control" value="<?php if (floatval($brokers_commission) > 0) echo number_format($brokers_commission,2).'%'; else echo ''; ?>"></div>
                                    </div>
                                    
                                    
                                    <!--NSE Commission/Primary Market Holding Period-->
                                    <div class="position-relative row form-group">
                                    	<!--NSE Commission-->
                                        <label title="NSE Commission. This Is A Percentage Of Each Trade Value" for="txtNSECommission" class="col-sm-3 col-form-label">NSE Commission (%)<span class="redtext">*</span></label>
                                    
                                        <div title="NSE Commission. This Is A Percentage Of Each Trade Value" class="col-sm-3">
                                        	<input id="txtNSECommission" placeholder="NSE Commission Percentage" type="text" class="form-control" value="<?php if (floatval($nse_commission) > 0) echo number_format($nse_commission,2).'%'; else echo ''; ?>">
                                        </div>
                                        
                                        <!--Primary Market Holding Period-->
                                        <label title="Primary Market Holding Period" for="txtHoldingPeriod" class="col-sm-3 col-form-label text-right">Primary Market Holding Period<span class="redtext">*</span></label>
                                        
                                        <div title="Primary Market Holding Period" class="col-sm-3">
                                        	<div class="input-group">
                                                 <input id="txtHoldingPeriod" placeholder="Holding Period" type="text" class="form-control" value="<?php if (intval($holdingperiod) > 0) echo $holdingperiod; else echo ''; ?>">
                                                 
                                                 <span class="input-group-btn size-16" style="margin-top:7px;">&nbsp;Days</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!--Maximum No Of Days For Orders-->
                                    <div title="Maximum No Of Days For Infinite Orders Like Good Till Cancelled (GTC)" class="position-relative row form-group">
                                    	<label for="txtMaxDays" class="col-sm-3 col-form-label">Max. No Of Days For Infinite Orders<span class="redtext">*</span></label>
                                    
                                        <div class="col-sm-3"><input id="txtMaxDays" placeholder="Maximum No Of Days For Infinite Orders Like Good Till Cancelled (GTC)" type="text" class="form-control" value="<?php if (floatval($max_order_days) > 0) echo number_format($max_order_days,0); else echo ''; ?>"></div>
                                        
                                        <!--SMS Fee-->
                                        <label for="txtSMSFee" class="col-sm-3 col-form-label text-right">SMS Fee<span class="redtext">*</span></label>
                                    	                                        
                                        <div class="col-sm-3">
                                        	<div class="input-group">
                                                <span class="input-group-btn size-22 makebold"><button style="padding-left:10px; padding-right:10px; border-radius:0; height:38px;" class="btn btn-nse-green" type="button">₦</button></span>
                                                
                                                 <input id="txtSMSFee" placeholder="SMS Fee" type="text" class="form-control" value="<?php if (floatval($sms_fee) > 0) echo number_format($sms_fee,2); else echo ''; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                   <div class="position-relative row form-check">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button id="btnUpdate" type="button" class="btn-pill btn btn-nse-green"><i class="pe-7s-note size-14 makebold"></i> Update Parameters</button>                                                
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
