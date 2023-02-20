<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<title>Naija Art Market | View Trade Request</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	
    <style>
		.nav-tabs > li.active > a, .nav-tabs > li > a:hover { border: none;  color: #A8AC2E !important; background: #fff; }
        
        </style>
    
    <?php include('reportsheader.php'); ?>
    <?php include('reportscripts.php'); ?>  
    
    <style>
    	.modal-content {
		  background-color: #fefefe;
		  margin: 15% auto; /* 15% from the top and centered */
		  padding: 20px;
		  border: 1px solid #888;/*888*/
		  position: relative;
		  margin-top:20px;
		  width: 140%; /* Could be more or less, depending on screen size */
		}
		
		/* The Close Button */
		.close {
		  color: #333;
		  float: right;
		  font-size: 28px;
		  font-weight: bold;
		}
		
		.close:hover,
		.close:focus {
		  color: black;
		  text-decoration: none;
		  cursor: pointer;
		}
		
		table.dataTable tbody td {
		  vertical-align: middle;
		}
		#wrapper .main {
		    -webkit-transition: all 0.3s ease-in-out;
		    -moz-transition: all 0.3s ease-in-out;
		    -ms-transition: all 0.3s ease-in-out;
		    -o-transition: all 0.3s ease-in-out;
		    transition: all 0.3s ease-in-out;
		    left: 0;
		    position: relative;
		    float: right;
		    background-color: #f5f5fa;
		}
		.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
    		background-color: #fcfcfa !important;
		}
		navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
		    background-color: #f6f6f0 !important;
		}
		.nav-text{
			font-size: 16px;
			font-weight: bold;
			font-family:"DMSans-Bold";
		}
	</style>  
    
    <script>
		var Title='<font color="#AF4442">Naija Art Mart Help</font>';
		var m='',table,tableseller;
		var Email='<?php echo $email; ?>';
		var Usertype='<?php echo $usertype; ?>';
		var BrokerId='<?php echo $broker_id; ?>';
		var CurrentSymbolPrice='';
		
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
		
		function DisplayDirectBuyMessage(msg,msgtype,msgtitle,theme='AlertTheme')
		{
			try
			{//SuccessTheme, AlertTheme
				$('#divDirectBuyAlert').html(msg).addClass(theme);
				
				
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
					$('#divDirectBuyAlert').load(location.href + " #divDirectBuyAlert").removeClass(theme);
				}, 10000);
			}catch(e)
			{
				alert('ERROR Displaying Message: '+e);
			}
		}
		
		function DisplayDirectSellMessage(msg,msgtype,msgtitle,theme='AlertTheme')
		{
			try
			{//SuccessTheme, AlertTheme
				$('#divDirectSellAlert').html(msg).addClass(theme);
				
				
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
					$('#divDirectSellAlert').load(location.href + " #divDirectSellAlert").removeClass(theme);
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
			
			setInterval(function() {
				updateClock();
			}, 1000);
			
			$('#btnBuy').hide();
			$('#btnSell').hide();
			$('#divStatus').hide();
			$('#lblStatus').hide();
			$('#divBuyToken').hide();
			$('#divBrokerNSE').hide();
			$('#divSMSTransfer').hide();
			$('#lblHideShowTotalAmount').hide();
			$('#divHideShowTotalAmount').hide();
			$('#divMinMaxPrice').hide();
			
			$('#lblHideShowAvailableQty').hide();
			$('#divHideShowAvailableQty').hide();
							
			$('[data-toggle="tooltip"]').tooltip();

			$(document).ajaxStop($.unblockUI);
						
			function LoadBuyAndSellRequests(sta)
			{
				try
				{
					$('#ancBlockchainUrl').html('').prop('href','').prop('title','');
					$('#ancBlockchainUrl').removeAttr('href');
					
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Trade Requests. Please Wait...</p>',theme: false,baseZ: 2000});
					
					//$('#tabRequests > tbody').html('');
	
					$.ajax({
						url: "<?php echo site_url('ui/Viewtraderequest/GetRequests');?>",
						type: 'POST',
						data: {usertype:Usertype,request_status:sta},
						dataType: 'json',
						success: function(dataSet,status,xhr) {	
							$.unblockUI();
							
							if (table) table.destroy();
							
							//f-filtering, l-length, i-information, p-pagination
							table = $('#tabRequests').DataTable( {
								dom: '<"top"if>rt<"bottom"lp><"clear">',
								responsive: true,
								ordering: true,
								autoWidth:false,
								language: {zeroRecords: "No Request Record Found"},
								lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
								columnDefs: [
									{
										"targets": [ 0,1,2,3,4,5,6 ],
										"visible": true
									},
									{
										"targets": [ 0,7 ],
										"orderable": false,
										"searchable": false
									},
									{
										"targets": [ 1,2,3,4,5,6 ],
										"orderable": true,
										"searchable": true
									},
									{ className: "dt-center", "targets": [ 0,1,2,3,4,5,6,7 ] }
								],					
								order: [[ 2, 'asc' ]],
								data: dataSet, 
								columns: [
									{ width: "24%" },//Artwork
									{ width: "11%" },//Market Type
									{ width: "10%" },//Trans. Type
									{ width: "11%" },//Symbol
									{ width: "12%" },//Requested Tokens
									{ width: "12%" },//Price
									{ width: "14%" },//Request Status
									{ width: "5%" }//View
								],
							} );
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
					m='LoadBuyAndSellRequests ERROR:\n'+e;
					DisplayMessage(m,'error',Title);
				}
			}
			
			$('#btnDisplayStatus').click(function(e) {
                try
				{
					$('#tabRequests > tbody').html('');
					
					var sta=$.trim($('#cboRequestStatus').val());
					
					LoadBuyAndSellRequests(sta);
				}catch(e)
				{
					$.unblockUI();
					m='Display Status Button Click ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
            });
			
			$("#txtQty").on("keyup",function(event)
			{
				try
				{
					ComputeAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Quantity Keyup ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			});
			
			$("#txtQty").on("change",function(event)
			{
				try
				{
					ComputeAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Quantity Changed ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			});	
			
			$("#txtPrice").on("keyup",function(event)
			{
				try
				{
					ComputeAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Price Keyup ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			});	
			
			$("#txtPrice").on("change",function(event)
			{
				try
				{
					ComputeAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Price Changed ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			});
			
			$("#txtMarketPrice").on("keyup",function(event)
			{
				try
				{
					ComputeAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Price Keyup ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			});
			
			$("#txtMarketPrice").on("change",function(event)
			{
				try
				{
					ComputeAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Price Changed ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			});	
			
			function ComputeAmount()
			{
				try
				{
					$('#lblBrokerFee').html('');					
					$('#lblNSEFee').html('');
					$('#lblTotalTradeAmount').html('');
					$('#lblTradeAmount').html('');
					
					var sms=$.trim($('#lblSMSFee').html()).replace(new RegExp(',', 'g'), '');
					sms=sms.replace(new RegExp('₦', 'g'), '');
					var qty=$.trim($('#txtQty').val()).replace(new RegExp(',', 'g'), '');					
					var price=$.trim($('#txtPrice').val()).replace(new RegExp(',', 'g'), '');				
					price=price.replace(new RegExp('₦', 'g'), '');
					
					var brokers_rate = '<?php echo $brokers_rate; ?>';
					var nse_rate = '<?php echo $nse_rate; ?>';					
					var amt = parseFloat(qty) * parseFloat(price);
					var bfee = (parseFloat(brokers_rate)/100) * amt;
					var nsefee = (parseFloat(nse_rate)/100) * amt;
					var total = parseFloat(amt)+parseFloat(bfee) + parseFloat(nsefee/2) + parseFloat(sms);
								
					if (parseFloat(amt) > 0) $('#lblTradeAmount').html(number_format(amt, 2, '.', ','));
					if (parseFloat(bfee) > 0) $('#lblBrokerFee').html(number_format(bfee, 2, '.', ','));
					if (parseFloat(nsefee) > 0) $('#lblNSEFee').html(number_format(nsefee/2, 2, '.', ','));
					if (parseFloat(total) > 0) $('#lblTotalTradeAmount').html(number_format(total, 2, '.', ','));

				}catch(e)
				{
					$.unblockUI();
					m='ComputeAmount ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			}
			
			
			$('#btnBuy').click(function(e) {
                try
				{
					
					var market_type=$.trim($('#lblMarketType').html());
					
					if 	($.trim(market_type).toLowerCase() == 'primary')
					{
						$('#divAlert').html('');			
						if (!CheckPrimaryBuy()) return false;
					}else if ($.trim(market_type).toLowerCase() == 'secondary')
					{
						GetBalance();	
						
						var inv_nm=$.trim($('#lblInvestor').html());
						var sym=$.trim($('#lblSymbol').html());						
						var qty=$.trim($('#txtQty').val());
						var minpr=$.trim($('#lblMinPrice').html());	
						var maxpr=$.trim($('#lblMaxPrice').html());						
				
						$('#lblDirectBuySymbol').html(sym);
						$('#txtDirectBuyQty').val(qty);					
						$('#lblDirectBuyMinPrice').html(minpr);
						$('#lblDirectBuyMaxPrice').html(maxpr);
						$('#lblDirectBuyInvestor').html(inv_nm);						
						
						//Buy Qty
						if (!qty)
						{
							m='Number of tokens to buy MUST not be blank.';				
							DisplayMessage(m, 'error',Title);					
							return false;
						}
						
						if (!$.isNumeric(qty))
						{
							m='Number of tokens to buy MUST be a number. Current entry <b>'+qty+'</b> is not valid.';						
							DisplayMessage(m, 'error',Title);
							return false;
						}
		
						if (parseInt(qty) == 0)
						{
							m='Number of tokens to buy must not be zero.';				
							DisplayMessage(m, 'error',Title);
							return false;
						}
						
						if (parseInt(qty) < 0)
						{
							m='Number of tokens to buy must not be less than zero.';				
							DisplayMessage(m, 'error',Title);
							return false;
						}
															
						LoadSellers(sym);
						
						$('#divDirectBuyModal').modal({
							fadeDuration: 	1000,
							fadeDelay: 		0.50,
							keyboard: 		false,
							backdrop:		'static'
						});
					}
					
				}catch(e)
				{
					$.unblockUI();
					m='Buy Button Click ERROR:\n'+e;				
					DisplayMessage(m, 'error',Title);
				}
            });
			
			$("#divDirectBuyModal").on('hidden.bs.modal', function(){
				try
				{
					ResetModalSecBuy();
				}catch(e)
				{
					$.unblockUI();
					m='Direct Buy Modal Close ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			});
			
			function CheckPrimaryBuy()
			{
				try
				{
					var market_type=$.trim($('#lblMarketType').html());
					var req_id=$.trim($('#hidId').val());
					var inv=$.trim($('#hidInvId').val());
					var issuer_email=$.trim($('#hidIssuerEmail').val());
					var issuer_name=$.trim($('#hidIssuerName').val());
					var inv_nm=$.trim($('#lblInvestor').html());
					var inv_em=$.trim($('#lblInvestorEmail').html());
					var transfer_fee=$.trim($('#lblTransferFee').html()).replace(new RegExp(',', 'g'), '');	
					
					var bal=$.trim($('#uiWalletBalance').html()).replace(new RegExp(',', 'g'), '');				
					bal=bal.replace(new RegExp('₦', 'g'), '');
					
					var sym=$.trim($('#lblSymbol').html());
					
					var pr=$.trim($('#txtMarketPrice').val()).replace(new RegExp(',', 'g'), '');				
					pr = pr.replace(new RegExp('₦', 'g'), '');
					
					var qty=$.trim($('#txtQty').val()).replace(new RegExp(',', 'g'), '');
					var availqty=$.trim($('#lblAvailableQty').html()).replace(new RegExp(',', 'g'), '');
					
					var listing_status=$.trim($('#lblListingStatus').html());
					
					
					var brfee=$.trim($('#lblBrokerFee').html()).replace(new RegExp(',', 'g'), '');				
					brfee=brfee.replace(new RegExp('₦', 'g'), '');
					
					var nse=$.trim($('#lblNSEFee').html()).replace(new RegExp(',', 'g'), '');				
					nse=nse.replace(new RegExp('₦', 'g'), '');
					
					var sms=$.trim($('#lblSMSFee').html()).replace(new RegExp(',', 'g'), '');				
					sms=sms.replace(new RegExp('₦', 'g'), '');
					
					var amt=$.trim($('#lblTradeAmount').html()).replace(new RegExp(',', 'g'), '');				
					amt=amt.replace(new RegExp('₦', 'g'), '');
					
					var tot=$.trim($('#lblTotalTradeAmount').html()).replace(new RegExp(',', 'g'), '');				
					tot=tot.replace(new RegExp('₦', 'g'), '');
										
					//Check status of asset
					if ($.trim(listing_status).toLowerCase() == 'ended')
					{
						m='The primary market for the asset <b>'+sym+'</b> has ended. Trade cannot take place';
						DisplayMessage(m, 'error',Title);					
						return false;
					}						
										
					if (!inv)
					{
						m='The investor id is not captured by the system. Please refresh the page';
						DisplayMessage(m, 'error',Title);					
						return false;
					}
					
					if (!inv_em)
					{
						m='The investor email is not displayed by the system. Please refresh the page';
						DisplayMessage(m, 'error',Title);					
						return false;
					}
					
					//Email or Broker Id not displaying
					if (!Email || !BrokerId)
					{
						m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of the asset.';						
	
						DisplayMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Symbol not displaying
					if (!sym)
					{
						m='The asset to buy from the primary market is not displaying. Current session may have timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of the asset.';						
	
						DisplayMessage(m, 'error',Title);				
	
						return false;
					}
					
					if (parseInt(availqty) == 0)
					{
						m='Number of available tokens of '+sym+' to buy from is zero. Trade cannot continue';				
						DisplayMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(pr) == 0)
					{
						m='Price per token for the asset is zero. Trade cannot continue';				
						DisplayMessage(m, 'error',Title);
						return false;
					}
					
					//Buy Qty
					if (!qty)
					{
						m='Number of tokens of '+sym+' to buy MUST not be blank.';				
						DisplayMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(qty))
					{
						m='Number of tokens of '+sym+' to buy MUST be a number. Current entry <b>'+qty+'</b> is not valid.';						
						DisplayMessage(m, 'error',Title);
						return false;
					}
	
					if (parseInt(qty) == 0)
					{
						m='Number of tokens of '+sym+' to buy must not be zero.';				
						DisplayMessage(m, 'error',Title);
						return false;
					}
					
					if (parseInt(qty) < 0)
					{
						m='Number of tokens of '+sym+' to buy must not be less than zero.';				
						DisplayMessage(m, 'error',Title);
						return false;
					}				
										
					if (parseInt(availqty) < parseInt(qty))
					{
						m="The number of tokens of "+sym+" to buy (<b>"+number_format(qty,0,'',',')+"</b>) is more than the available tokens for sale (<b>" + number_format(availqty,0,'',',') + "</b>).";
						DisplayMessage(m, 'error',Title);
						return false;
					}					
				
					if (!bal)
					{
						m='Your e-wallet balance is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of asset. If the issue still persists after signout and signin and you are sure that you have credited your e-wallet, please contact the system administrator at support@naijaartmart.com, otherwise credit your wallet through <a href="<?php echo site_url('ui/Wallet'); ?>">Wallet Module</a> on your side menu.';	
								
						DisplayMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(bal))
					{
						m='E-wallet balance MUST be a number.';						
						DisplayMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(bal) == 0)
					{
						m='E-wallet balance is zero. Please fund your e-wallet so that you can trade with it.';				
						DisplayMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(bal) < 0)
					{
						m='E-wallet balance must not be a negative number. Please fund your e-wallet so that you can trade with it.';				
						DisplayMessage(m, 'error',Title);
						return false;
					}
										
					if (parseFloat(bal) < parseFloat(tot))
					{
						m="You do not have enough balance in your e-wallet to buy this asset. Your current e-wallet balance is (<b>₦"+number_format(bal,2,'.',',')+"</b>) and the total amount needed for buying "+number_format(qty,0,'',',')+" tokens of "+sym+" is (<b>₦" + number_format(tot,2,'.',',') + "</b>).";
						DisplayMessage(m, 'error',Title);
						return false;
					}
					
					Swal.fire({
					  title: 'PLEASE CONFIRM BUY',
					  html: '<font size="3" face="Arial">Do You Want To Proceed With The Buying Of The Asset From The Primary Market?</font>',
					  type: 'question',
					  customClass: 'swal-wide',
					  showCancelButton: true,
					  showClass: {popup: 'animate__animated animate__fadeInDown'},
					  hideClass: {popup: 'animate__animated animate__fadeOutUp'},
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  cancelButtonText: '<font size="3" face="Arial">No</font>',
					  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
					}).then((result) => {
					  if (result.value)
					  {
						$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Buying Asset. Please Wait...</p>',theme: false,baseZ: 2000});
	
						var mdata={buy_broker_id:BrokerId, buy_broker_email:Email, buy_investor_email:inv_em, symbol:sym, price:pr, qty:qty, available_qty:availqty, broker_commission:brfee, nse_commission:nse, sms_fee:sms, transfer_fee:transfer_fee, total_amount:tot, issuer_email:issuer_email, investor_name:inv_nm,request_id:req_id, investor_id:inv};
									
						//Make Ajax Request			
						$.ajax({
							url: '<?php echo site_url('ui/Viewtraderequest/BuyPrimaryTokens'); ?>',
							data: mdata,
							type: 'POST',
							dataType: 'json',
							success: function(data,status,xhr) {				
								$.unblockUI();
								
								if ($(data).length > 0)
								{
									$.each($(data), function(i,e)
									{
										if ($.trim(e.status).toUpperCase() == 'OK')
										{				
											ResetControls();
				
											m= 'Purchase of '+number_format(qty, '0', '', ',') + ' tokens of '+ $.trim(sym).toUpperCase() +' was successful.';
											
											DisplayMessage(m, 'success','Token Purchase','SuccessTheme');
											
											GetBalance();												
											//LoadBuyAndSellRequests('');
										}else
										{
											m=e.Msg;
											
											DisplayMessage(m,'error',Title);		
										}
										
										return;
									});//End each
								}
							},
							error:  function(xhr,status,error) {
								m='Error '+ xhr.status + ' Occurred: ' + error
								DisplayMessage(m,'error',Title);
							}
						});
					  }
					})						
				}catch(e)
				{
					$.unblockUI();
					m='CheckPrimaryBuy ERROR:\n'+e;				
					DisplayMessage(m, 'error',Title);
				}		
			}//End CheckPrimaryBuy
			
			function CheckSecondaryBuy()
			{
				try
				{
					var market_type=$.trim($('#lblMarketType').html());
					var req_id=$.trim($('#hidId').val());
					var inv=$.trim($('#hidInvId').val());
					var issuer_email=$.trim($('#hidIssuerEmail').val());
					var inv_nm=$.trim($('#lblInvestor').html());
					var inv_em=$.trim($('#lblInvestorEmail').html());
					var transfer_fee='<?php echo str_replace(',','',$transfer_fee); ?>';;
					
					var bal=$.trim($('#uiWalletBalance').html()).replace(new RegExp(',', 'g'), '');				
					bal=bal.replace(new RegExp('₦', 'g'), '');
					
					var sym=$.trim($('#lblSymbol').html());
					
					var pr=$.trim($('#txtMarketPrice').val()).replace(new RegExp(',', 'g'), '');				
					pr = pr.replace(new RegExp('₦', 'g'), '');
					
					var qty=$.trim($('#txtQty').val()).replace(new RegExp(',', 'g'), '');
					var availqty=$.trim($('#hidAvailQty').val()).replace(new RegExp(',', 'g'), '');
					
					
					var brfee=$.trim($('#lblBrokerFee').html()).replace(new RegExp(',', 'g'), '');				
					brfee=brfee.replace(new RegExp('₦', 'g'), '');
					
					var nse=$.trim($('#lblNSEFee').html()).replace(new RegExp(',', 'g'), '');				
					nse=nse.replace(new RegExp('₦', 'g'), '');
					
					var sms=$.trim($('#lblSMSFee').html()).replace(new RegExp(',', 'g'), '');				
					sms=sms.replace(new RegExp('₦', 'g'), '');
					
					var amt=$.trim($('#lblTradeAmount').html()).replace(new RegExp(',', 'g'), '');				
					amt=amt.replace(new RegExp('₦', 'g'), '');
					
					var tot=$.trim($('#lblTotalTradeAmount').html()).replace(new RegExp(',', 'g'), '');				
					tot=tot.replace(new RegExp('₦', 'g'), '');
					
					
					
					
					///////////////////////////////////////////////////////////////////////
					if ($('#cboDirectBuyInvestor > option').length < 2)
					{
						m='You have not registered any investor under your account.';
						DisplayDirectBuyMessage(m, 'error',Title);					
						return false;
					}
					
					if (!inv)
					{
						m='Please select the investor who is buying the asset.';
						DisplayDirectBuyMessage(m, 'error',Title);					
						$('#cboDirectBuyInvestor').focus(); return false;
					}
					
					//Email or Broker Id not displaying
					if (!Email || !BrokerId)
					{
						m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of the asset.';						
	
						DisplayDirectBuyMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Symbol not displaying
					if (!sym)
					{
						m='The asset to buy is not displaying. Current session may have timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of the asset.';						
	
						DisplayDirectBuyMessage(m, 'error',Title);				
	
						return false;
					}
					
					if (parseInt(availqty) == 0)
					{
						m='Number of available tokens to buy from is zero. Trade cannot continue';				
						DisplayDirectBuyMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(pr) == 0)
					{
						m='Price per token for the asset is zero. Trade cannot continue';				
						DisplayDirectBuyMessage(m, 'error',Title);
						return false;
					}
					
					//Buy Qty
					if (!qty)
					{
						m='Number of tokens to buy MUST not be blank.';				
						DisplayDirectBuyMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(qty))
					{
						m='Number of tokens to buy MUST be a number. Current entry <b>'+qty+'</b> is not valid.';						
						DisplayDirectBuyMessage(m, 'error',Title);
						return false;
					}
	
					if (parseInt(qty) == 0)
					{
						m='Number of tokens to buy must not be zero.';				
						DisplayDirectBuyMessage(m, 'error',Title);
						return false;
					}
					
					if (parseInt(qty) < 0)
					{
						m='Number of tokens to buy must not be less than zero.';				
						DisplayDirectBuyMessage(m, 'error',Title);
						return false;
					}				
										
					if (parseInt(availqty) < parseInt(qty))
					{
						m="The number of tokens to buy (<b>"+number_format(qty,0,'',',')+"</b>) is more than the available tokens for sale (<b>" + number_format(availqty,0,'',',') + "</b>).";
						DisplayDirectBuyMessage(m, 'error',Title);
						return false;
					}
					
				
					if (!bal)
					{
						m='Your e-wallet balance is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of asset. If the issue still persists after signout and signin and you are sure that you have credited your e-wallet, please contact the system administrator at support@naijaartmart.com, otherwise credit your wallet through <a href="<?php echo site_url('ui/Wallet'); ?>">Wallet Module</a> on your side menu.';	
								
						DisplayDirectBuyMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(bal))
					{
						m='E-wallet balance MUST be a number.';						
						DisplayDirectBuyMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(bal) == 0)
					{
						m='E-wallet balance is zero. Please fund your e-wallet so that you can trade with it.';				
						DisplayDirectBuyMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(bal) < 0)
					{
						m='E-wallet balance must not be a negative number. Please fund your e-wallet so that you can trade with it.';				
						DisplayDirectBuyMessage(m, 'error',Title);
						return false;
					}
										
					if (parseFloat(bal) < parseFloat(tot))
					{
						m="You do not have enough balance in your e-wallet to buy this asset. Your current e-wallet balance is (<b>₦"+number_format(bal,2,'.',',')+"</b>) and the total amount needed for buying "+number_format(qty,0,'',',')+" tokens of the asset is (<b>₦" + number_format(total,2,'.',',') + "</b>).";
						DisplayDirectBuyMessage(m, 'error',Title);
						return false;
					}
					///////////////////////////////////////////////////////////////////////
					
					//m='Email = '+Email+'<br>Broker Id = '+BrokerId+'<br>Market type = '+market_type+'<br>Req. Id = '+req_id+'<br>Investor Id = '+inv+'<br>Investor Name = '+inv_nm+'<br>Investor Email = '+inv_em+'<br>Issuer Email = '+issuer_email+'<br>Wallet Balance = '+bal+'<br>Symbol = '+sym+'<br>Price = '+pr+'<br>Available Quantity = '+availqty+'<br>Quantity = '+qty+'<br>Broker Fee = '+brfee+'<br>NSE Fee = '+nse+'<br>SMS Fee = '+sms+'<br>Transfer Fee = '+transfer_fee+'<br>Trade Amount = '+amt+'<br>Total = '+tot;				
					
					//DisplayMessage(m, 'info',Title);	return;	
					
					if 	($.trim(market_type).toLowerCase() == 'primary')
					{//Primary Buy
						
						
						Swal.fire({
					  title: 'PLEASE CONFIRM BUY',
					  html: '<font size="3" face="Arial">Do You Want To Proceed With The Buying Of The Asset?</font>',
					  type: 'question',
					  customClass: 'swal-wide',
					  showCancelButton: true,
					  showClass: {popup: 'animate__animated animate__fadeInDown'},
					  hideClass: {popup: 'animate__animated animate__fadeOutUp'},
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  cancelButtonText: '<font size="3" face="Arial">No</font>',
					  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
					}).then((result) => {
						  if (result.value)
						  {
							$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Buying Asset. Please Wait...</p>',theme: false,baseZ: 2000});
		
						var mdata={buy_broker_id:BrokerId, buy_broker_email:Email, buy_investor_email:inv_em, symbol:sym, price:pr, qty:qty, available_qty:availqty, broker_commission:brfee, nse_commission:nse, sms_fee:sms, transfer_fee:transfer_fee, total_amount:tot, issuer_email:issuer_email};		
										
							//Make Ajax Request			
							$.ajax({
								url: '<?php echo site_url('ui/Primarymarket/BuyPrimaryTokens'); ?>',
								data: mdata,
								type: 'POST',
								dataType: 'json',
								success: function(data,status,xhr) {				
									$.unblockUI();
									
									if ($(data).length > 0)
									{
										$.each($(data), function(i,e)
										{
											if ($.trim(e.status).toUpperCase() == 'OK')
											{				
												ResetControls();
					
												m= 'Purchase of '+number_format(qty, '0', '', ',') + ' tokens of '+ $.trim(sym).toUpperCase() +' was successful.';
												
												DisplayMessage(m, 'success','Token Purchase','SuccessTheme');
												
												GetBalance();												
												//LoadBuyAndSellRequests();
											}else
											{
												m=e.Msg;
												
												DisplayDirectBuyMessage(m,'error',Title);		
											}
											
											return;
										});//End each
									}
								},
								error:  function(xhr,status,error) {
									m='Error '+ xhr.status + ' Occurred: ' + error
									DisplayDirectBuyMessage(m,'error',Title);
								}
							});
						  }
						})
					}else if ($.trim(market_type).toLowerCase() == 'secondary')
					{//Secondary Buy
						
						//Confirm Update				
						Swal.fire({
						  title: 'PLEASE CONFIRM BUY',
						  html: '<div>'+det+'</div>',
						  type: 'question',
						  customClass: 'swal-wide',
						  showCancelButton: true,
						  showClass: {popup: 'animate__animated animate__fadeInDown'},
						  hideClass: {popup: 'animate__animated animate__fadeOutUp'},
						  confirmButtonColor: '#3085d6',
						  cancelButtonColor: '#d33',
						  cancelButtonText: '<font size="3" face="Arial">No</font>',
						  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
						}).then((result) => {
						  if (result.value)
						  {
							$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Buying Asset. Please Wait...</p>',theme: false,baseZ: 2000});
		
						var mdata={brokeremail:Email, sell_broker_id:broker_id, sell_order_id:order_id, sell_investor_id:investor_id, buy_broker_id:BrokerId, buy_investor_id:inv, symbol:sym, price:price, qty:qty, available_qty:available_qty, broker_commission:brokerfee,nse_commission:nf, sms_fee:sms, transfer_fee:transfer_fee,total_amount:number_format(total,2,'.',''),min_buy_qty:'<?php echo $min_buy_qty; ?>',ordertype:ordertype};
			
										
							//Make Ajax Request			
							$.ajax({
								url: '<?php echo site_url('ui/Directexchange/BuyTokens'); ?>',
								data: mdata,
								type: 'POST',
								dataType: 'json',
								success: function(data,status,xhr) {				
									$.unblockUI();
									
									if ($(data).length > 0)
									{
										$.each($(data), function(i,e)
										{
											if ($.trim(e.status).toUpperCase() == 'OK')
											{				
												$('#txtDirectBuyQty').val('');
					
												m= 'Purchase of '+number_format(qty, '0', '', ',') + ' tokens of '+ $.trim(sym).toUpperCase() +' was successful.';
												
												DisplayMessage(m, 'success','Token Purchase','SuccessTheme');
												$('#cboDirectBuyInvestor').val('');
												
												GetBalance();
												
												$("#divDirectBuyModal").modal('hide');//Close modal
												
												LoadOrders();
												LoadMessages();
												LoadDirectMarketData();
												
												GetPortfolioTokens(sym,inv);
											}else
											{
												m=e.Message;
												
												DisplayDirectBuyMessage(m,'error',Title);		
											}
											
											return;
										});//End each
									}
								},
								error:  function(xhr,status,error) {
									m='Error '+ xhr.status + ' Occurred: ' + error
									DisplayDirectBuyMessage(m,'error',Title);
								}
							});
						  }
						})
					}
						
				}catch(e)
				{
					$.unblockUI();
					m='CheckSecondaryBuy ERROR:\n'+e;				
					DisplayMessage(m, 'error',Title);
				}		
			}//End CheckSecondaryBuy
			
			$('#btnSell').click(function(e) {
                try
				{
					GetBalance();
					
					var inv_nm=$.trim($('#lblInvestor').html());					
					var sym=$.trim($('#lblSymbol').html());	
					var mpr=$.trim($('#lblMarketType').html());										
					var qty=$.trim($('#txtQty').val());					
					var minpr=$.trim($('#lblMinPrice').html());	
					var maxpr=$.trim($('#lblMaxPrice').html());
					var sms=$('#lblSMSFee').html();				
					var bfee=$('#lblBrokerFee').html();
					var nse=$('#lblNSEFee').html();	
					var transfer_fee=$('#lblTransferFee').html();		
					
					$('#lblDirectSellInvestor').html(inv_nm);
					$('#lblDirectSellSymbol').html(sym);								
					$('#lblDirectSellMarketPrice').val(number_format(mpr, 2, '.', ','));
					$('#txtDirectSellQty').val(qty);
					if (parseFloat(minpr) > 0) $('#lblDirectSellMinPrice').html(minpr);	
					if (parseFloat(maxpr) > 0) $('#lblDirectSellMaxPrice').html(maxpr);					
					if (parseFloat(bfee) > 0) $('#lblDirectSellBrokerFee').html(bfee);
					if (parseFloat(sms) > 0) $('#lblDirectSellSMS').html(sms);					
					if (parseFloat(nse) > 0) $('#lblDirectSellNSEFee').html(nse);
					
					//if (parseFloat(transfer_fee) > 0) $('#').html(transfer_fee);
					
					
					$('#divDirectSellAlert').html('');
					
					//Sell Qty
					if (!qty)
					{
						m='Number of tokens to sell MUST not be blank.';				
						DisplayMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(qty))
					{
						m='Number of tokens to sell MUST be a number. Current entry <b>'+qty+'</b> is not valid.';						
						DisplayMessage(m, 'error',Title);
						return false;
					}
	
					if (parseInt(qty) == 0)
					{
						m='Number of tokens to sell must not be zero.';				
						DisplayMessage(m, 'error',Title);
						return false;
					}
					
					if (parseInt(qty) < 0)
					{
						m='Number of tokens to sell must not be less than zero.';				
						DisplayMessage(m, 'error',Title);
						return false;
					}
														
					$('#divDirectSellModal').modal({
						fadeDuration: 	1000,
						fadeDelay: 		0.50,
						keyboard: 		false,
						backdrop:		'static'
					});					
										
				}catch(e)
				{
					$.unblockUI();
					m='Sell Button Click ERROR:\n'+e;				
					DisplayMessage(m, 'error',Title);
				}
            });
			
			$("#divDirectSellModal").on('hidden.bs.modal', function(){
				try
				{
					ResetModalSecSell();
				}catch(e)
				{
					$.unblockUI();
					m='Direct Buy Modal Close ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			});
			
			function ComputeDirectSellAmount()
			{
				try
				{
					$('#lblDirectSellAmount').html('');					
					$('#lblDirectSellBrokerFee').html('');
					$('#lblDirectSellNSEFee').html('');
					$('#lblDirectSellTotalAmount').html('');					
					
					var qty=$.trim($('#txtDirectSellQty').val()).replace(new RegExp(',', 'g'), '');					
					var price=$.trim($('#txtDirectSellPrice').val()).replace(new RegExp(',', 'g'), '');				
					price=price.replace(new RegExp('₦', 'g'), '');
					
					var sms=$.trim($('#lblDirectSellSMS').html()).replace(new RegExp(',', 'g'), '');				
					sms=sms.replace(new RegExp('₦', 'g'), '');
															
					CurrentSymbolPrice=CurrentSymbolPrice.replace(new RegExp(',', 'g'), '');				
					CurrentSymbolPrice=CurrentSymbolPrice.replace(new RegExp('₦', 'g'), '');
					
					var transfer_fee='<?php echo $transfer_fee; ?>';
					var price_limit_percent = '<?php echo $price_limit_percent; ?>';
					var diff=(parseFloat(price_limit_percent)/100) * parseFloat(CurrentSymbolPrice);		
					
					var lowerlimit = parseFloat(CurrentSymbolPrice) - parseFloat(diff);
					var upperlimit = parseFloat(CurrentSymbolPrice) + parseFloat(diff);
								
					var brokers_rate = '<?php echo $brokers_rate; ?>';
					var nse_rate = '<?php echo $nse_rate; ?>';
					
					var amount = parseFloat(qty) * parseFloat(price);
					var brokerfee = (parseFloat(brokers_rate)/100) * amount;
					var nsefee = (parseFloat(nse_rate)/100) * amount;
					var total = parseFloat(amount) + parseFloat(brokerfee) + parseFloat((nsefee/2)) + parseFloat(sms) + parseFloat(transfer_fee);
				
					if (parseFloat(amount) > 0) $('#lblDirectSellAmount').html('₦' + number_format(amount, 2, '.', ','));
					if (parseFloat(brokerfee) > 0) $('#lblDirectSellBrokerFee').html('₦' + number_format(brokerfee, 2, '.', ','));
					if (parseFloat(nsefee) > 0) $('#lblDirectSellNSEFee').html('₦' + number_format((nsefee/2), 2, '.', ','));
					if (parseFloat(total) > 0) $('#lblDirectSellTotalAmount').html('₦' + number_format(total, 2, '.', ','));
				}catch(e)
				{
					$.unblockUI();
					m='ComputeDirectSellAmount ERROR:\n'+e;			
					DisplayDirectSellMessage(m, 'error',Title);
				}
			}
			
			$("#txtDirectSellQty").on("keyup",function(event)
			{
				try
				{
					ComputeDirectSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Sell Quantity Keyup ERROR:\n'+e;			
					DisplayDirectSellMessage(m, 'error',Title);
				}
			});
			
			$("#txtDirectSellQty").on("change",function(event)
			{
				try
				{
					ComputeDirectSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Sell Quantity Changed ERROR:\n'+e;			
					DisplayDirectSellMessage(m, 'error',Title);
				}
			});
						
			$("#txtDirectSellPrice").on("keyup",function(event)
			{
				try
				{
					ComputeDirectSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Sell Price Keyup ERROR:\n'+e;			
					DisplayDirectSellMessage(m, 'error',Title);
				}
			});	
			
			$("#txtDirectSellPrice").on("change",function(event)
			{
				try
				{
					ComputeDirectSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Sell Price Changed ERROR:\n'+e;			
					DisplayDirectSellMessage(m, 'error',Title);
				}
			});
			
			$('#cboDirectSellOrderType').change(function(e) {
                try
				{	
					var ty=$(this).val();
					
					if ($.trim(ty).toLowerCase() == 'limit')
					{
						$('#txtDirectSellPrice').val('');
						$('#lblDirectSellPrice').html('Selling Price<span class="redtext">*</span>');
						$('#txtDirectSellPrice').prop('readonly',false).css('background-color','#ffffff').css('cursor','text');
					}else
					{
						$('#lblDirectSellPrice').html('Selling Price');
						$('#txtDirectSellPrice').val($('#lblDirectSellMarketPrice').html());
						$('#txtDirectSellPrice').prop('readonly',true).css('background-color','#ffffff').css('cursor','default');
					}
				}catch(e)
				{
					$.unblockUI();
					m='Direct Sell Order Type Change ERROR:\n'+e;			
					DisplayDirectSellMessage(m, 'error',Title);
				}
            });
			
			$('#btnDirectSell').click(function(e) {
                try
				{
					$('#divDirectSellAlert').html('');			
					if (!CheckDirectSell()) return false;
				}catch(e)
				{
					
				}
            });
			
			function CheckDirectSell()
			{
				try
				{
					var req_id=$.trim($('#hidId').val());
					var inv=$.trim($('#lblInvestorEmail').html());					
					var sym=$.trim($('#lblDirectSellSymbol').html());					
					var mktpr=$.trim($('#lblDirectSellMarketPrice').html()).replace(new RegExp(',', 'g'), '');				
					mktpr = mktpr.replace(new RegExp('₦', 'g'), '');
										
					var typ=$.trim($('#cboDirectSellOrderType').val());					
					var pr=$.trim($('#txtDirectSellPrice').val()).replace(new RegExp(',', 'g'), '');				
					pr = pr.replace(new RegExp('₦', 'g'), '');	
									
					var qty=$.trim($('#txtDirectSellQty').val()).replace(new RegExp(',', 'g'), '');					
					var portqty=$.trim($('#lblDirectSellPortfolioQty').html()).replace(new RegExp(',', 'g'), '');					
					var brfee=$.trim($('#lblDirectSellBrokerFee').html()).replace(new RegExp(',', 'g'), '');
					brfee=brfee.replace(new RegExp('₦', 'g'), '');	
									
					var nse=$.trim($('#lblDirectSellNSEFee').html()).replace(new RegExp(',', 'g'), '');				
					nse=nse.replace(new RegExp('₦', 'g'), '');
					
					var amt=$.trim($('#lblDirectSellAmount').html()).replace(new RegExp(',', 'g'), '');				
					amt=amt.replace(new RegExp('₦', 'g'), '');
					
					var tot=$.trim($('#lblDirectSellTotalAmount').html()).replace(new RegExp(',', 'g'), '');				
					tot=tot.replace(new RegExp('₦', 'g'), '');	
									
					var sms=$.trim($('#lblDirectSellSMS').html()).replace(new RegExp(',', 'g'), '');				
					sms=sms.replace(new RegExp('₦', 'g'), '');	
									
					var transfer_fee='<?php echo $transfer_fee; ?>';							
															
					//UNCOMMENT THIS LATER
					/*if ($.trim(MarketStatus).toLowerCase() == 'closed')
					{
						m='Market is closed. You cannot place any order.';						
	
						DisplayDirectSellMessage(m, 'error',Title);				
	
						return false;
					}*/
					
					//User Email
					if (!Email)
					{
						m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the placing of sell order.';						
	
						DisplayDirectSellMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Wallet balance
					//var bal=$.trim($('#lblDirectSellBalance').html()).replace(new RegExp(',', 'g'), '');				
					//bal=bal.replace(new RegExp('₦', 'g'), '');
					
					/*if (!bal)
					{
						m='Your e-wallet balance is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the placing of sell order. If the issue still persists after signout and signin and you are sure that you have credited your e-wallet, please contact the system administrator at support@naijaartmart.com, otherwise credit your wallet through <a href="<?php //echo site_url('ui/Wallet'); ?>">Wallet Module</a> on your side menu.';	
								
						DisplayDirectSellMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(bal))
					{
						m='E-wallet balance MUST be a number.';						
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(bal) == 0)
					{
						m='E-wallet balance is zero. Please fund your e-wallet so that you can trade with it.';				
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(bal) < 0)
					{
						m='E-wallet balance must not be a negative number. Please fund your e-wallet so that you can trade with it.';				
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}*/
					
					//Investor					
					if (!inv)
					{
						m='Please select the investor whose asset you are placing sell order for.';
						DisplayDirectSellMessage(m, 'error',Title);					
						$('#cboDirectSellInvestor').focus(); return false;
					}					
									
					//Symbol
					if (!sym)
					{
						m='No asset is displaying. Refresh the page or logout and login again before continue.';
						DisplayDirectSellMessage(m, 'error',Title);					
						return false;
					}
					
					
					//Market Price
					if (!mktpr)
					{
						m='Asset current market price field MUST not be blank.';				
						DisplayDirectSellMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(mktpr))
					{
						m='Asset current market price MUST be a number.';						
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(mktpr) == 0)
					{
						m='Asset current market price must not be zero.';				
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(mktpr) < 0)
					{
						m='Asset current market price must not be a negative number.';				
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
					
					
					//Sell Order Type
					if ($('#cboDirectSellOrderType > option').length < 2)
					{
						m='Sell order types have not been captured. Please contact the system administrator at support@naijaartmart.com';
						DisplayDirectSellMessage(m, 'error',Title);					
						return false;
					}
					
					if (!typ)
					{
						m='Please select the type of sell order you want to place.';
						DisplayDirectSellMessage(m, 'error',Title);					
						$('#cboDirectSellOrderType').focus(); return false;
					}
					
					
					//Selling Price
					if (!pr)
					{
						m='Asset selling price field MUST not be blank.';				
						DisplayDirectSellMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(pr))
					{
						m='Asset selling price MUST be a number.';						
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(pr) == 0)
					{
						m='Asset selling price must not be zero.';				
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(pr) < 0)
					{
						m='Asset selling price must not be a negative number.';				
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
			
					
					var price_limit_percent = '<?php echo $price_limit_percent; ?>';
					var diff=(parseFloat(price_limit_percent)/100) * parseFloat(mktpr);		
					
					var lowerlimit = parseFloat(mktpr) - parseFloat(diff);
					var upperlimit = parseFloat(mktpr) + parseFloat(diff);									
										
					//Lower/Upper Price Limits					
					if (parseFloat(pr) < parseFloat(lowerlimit))//Exceeded lower limit
					{
						m="The selling price, <b>₦" + number_format(pr,2,'.',',') + "</b>, is less than the minimum price of <b>₦" + number_format(lowerlimit,2,'.',',') + "</b> allowed for the asset. Please enter a value not less than <b>₦" + number_format(lowerlimit,2,'.',',') +"</b>, or more than <b>₦" + number_format(upperlimit,2,'.',',') + "</b>.";
						
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(pr) > parseFloat(upperlimit))//Exceeded upper limit
					{
						m="The selling price, <b>₦" + number_format(pr,2,'.',',') + "</b>, is more than the maximum price of <b>₦" + number_format(upperlimit,2,'.',',') + "</b> allowed for the asset. Please enter a value not less than <b>₦" + number_format(lowerlimit,2,'.',',') +"</b>, or more than <b>₦" + number_format(upperlimit,2,'.',',') + "</b>.";
						
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
					
					
					//Portfolio Quantity
					if (!$.isNumeric(portqty))
					{
						m='There is no valid number of tokens of the selected asset in your portfolio. Selling order cannot continue.';						
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseInt(portqty) == 0)
					{
						m="You do not have any token of <b>"+ sym.toUpperCase() + "</b> in your portfolio to sell.";
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}					
	
					if (parseInt(portqty) == 0)
					{
						m='Number of tokens of <b>'+ sym.toUpperCase() + '</b> in your portfolio must not be zero.';				
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseInt(portqty) < 0)
					{
						m='Number of tokens of <b>'+ sym.toUpperCase() + '</b> in your portfolio must not be less than zero.';				
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
								
																	
					//Qty to sell
					if (!qty)
					{
						m='Number of tokens of the asset to sell MUST not be blank.';				
						DisplayDirectSellMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(qty))
					{
						m='Number of tokens of the asset to sell MUST be a number. Current entry <b>'+qty+'</b> is not valid.';						
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
	
					if (parseInt(qty) == 0)
					{
						m='Number of tokens of the asset to sell must not be zero.';				
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseInt(qty) < 0)
					{
						m='Number of tokens of the asset to sell must not be less than zero.';				
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
					
										
					if (parseInt(portqty) < parseInt(qty))
					{
						m="You do not have enough tokens of <b>"+ sym.toUpperCase() + "</b> in your portfolio to sell. The number of tokens of the asset in your portfolio currently is <b>"+ number_format(portqty,0,'',',') + "</b>.";
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
					
					//Broker
					if (!brfee)
					{
						m='Broker fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the placing of sell order. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayDirectSellMessage(m, 'error',Title);				
	
						return false;
					}
					
					//NSE Fee
					if (!nse)
					{
						m='NSE fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the placing of sell order. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayDirectSellMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Token Amount
					if (!amt)
					{
						m='Amount for the token to sell is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the placing of sell order. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayDirectSellMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Estimated Total Amount
					if (!tot)
					{
						m='Total trade amount for the sell order is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the placing of sell order. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayDirectSellMessage(m, 'error',Title);				
	
						return false;
					}
	
					
					//Confirm Update				
					Swal.fire({
					  title: 'PLEASE CONFIRM',
					  html: '<font size="3" face="Arial">Do you want to proceed with the placing of sell order for the selected asset?</font>',
					  type: 'question',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  cancelButtonText: '<font size="3" face="Arial">No</font>',
					  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
					}).then((result) => {
					  if (result.value)
					  {
						$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Placing Selling Order. Please Wait...</p>',theme: false,baseZ: 2000});

					var mdata={email:Email, broker_id:BrokerId, investor_id:inv, ordertype:typ, symbol:sym, price:pr, qty:qty, available_qty:qty, broker_commission:brfee,nse_commission:nse, sms_fee:sms, transfer_fee:transfer_fee,total_amount:tot,updaterequeststatus:1, request_id:req_id}						

									
						//Make Ajax Request			
						$.ajax({
							url: '<?php echo site_url('ui/Directexchange/PlaceSellOrder'); ?>',
							data: mdata,
							type: 'POST',
							dataType: 'json',
							success: function(data,status,xhr) {				
								$.unblockUI();
								
								if ($(data).length > 0)
								{
									$.each($(data), function(i,e)
									{
										if ($.trim(e.status).toUpperCase() == 'OK')
										{
											ResetModalSecSell();
											ResetControls();
				
											m= 'Order to sell '+number_format(qty, '0', '', ',') + ' tokens of '+ $.trim(sym).toUpperCase() +' was placed successfully.';
											
											DisplayMessage(m,'success','Sell Order Placed','SuccessTheme');
																					
											GetBalance();
											GetDirectPortfolioTokens(sym,inv);
											
											$('#tabRequests > tbody').html('');
						
											$('#cboRequestStatus').val('');
						
											$("#divDirectSellModal").modal('hide');//Close modal
											
											UiActivateTab('view');
										}else
										{
											m=e.Message;
											
											DisplayDirectSellMessage(m,'error',Title);		
										}
										
										return;
									});//End each
								}
							},
							error:  function(xhr,status,error) {
								m='Error '+ xhr.status + ' Occurred: ' + error
								DisplayDirectSellMessage(m,'error',Title);
							}
						});
					  }
					})	
				}catch(e)
				{
					$.unblockUI();
					m='CheckDirectSell ERROR:\n'+e;				
					DisplayDirectSellMessage(m, 'error',Title);
				}		
			}//End CheckDirectSell
			
        });//Document Ready
		
		function ResetModalSecSell()
		{
			try
			{
				$('#lblDirectSellBalance').html('');					
				$('#lblDirectSellInvestor').html('');
				$('#lblDirectSellSymbol').html('');	
				$('#lblDirectSellMarketPrice').val('');
				$('#cboDirectSellOrderType').val('');
				$('#txtDirectSellPrice').val('');				
				$('#lblDirectSellPortfolioQty').html('');					
				$('#lblDirectSellSymbol').html('');
				$('#txtDirectSellQty').val('');
				$('#lblDirectSellBrokerFee').html('');
				$('#lblDirectSellNSEFee').html('');				
				$('#lblDirectSellAmount').html('');
				$('#lblDirectSellSMS').html('');
				$('#lblDirectSellTransferFee').html('');
				$('#lblDirectSellTotalAmount').html('');
				$('#divDirectSellAlert').html('');
			}catch(e)
			{
				$.unblockUI();
				m='ResetModalSecSell ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		}
		
		function ResetModalSecBuy()
		{
			try
			{
				$('#lblDirectBuyBalance').html('');					
				$('#lblDirectBuyInvestor').html('');					
				$('#lblDirectBuySymbol').html('');					
				$('#txtDirectBuyQty').val('');					
				$('#lblDirectBuyMinPrice').html('');					
				$('#lblDirectBuyMaxPrice').html('');
				$('#divDirectBuyAlert').html('');
				
				$('#tabSellers > tbody').html('');		
			}catch(e)
			{
				$.unblockUI();
				m='ResetModalSecBuy ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		}
		
		function BuyDirectArt(sn,sym,order_id,sell_broker_id,price,sell_investor_id,available_qty,ordertype)
		{
			try
			{
				var qty=$.trim($('#txtDirectBuyQty').val()).replace(new RegExp(',', 'g'), '');
				var inv=$.trim($('#lblInvestor').html());
				var inv_em=$.trim($('#lblInvestorEmail').html());
				var av_qty=$('#tabSellers > tbody').find("tr").eq(sn).find("td").eq(1).html();
				var req_id=$.trim($('#hidId').val());
				
				if (!inv)
				{
					m='Investor name is not displaying. Refresh the page and restart the process.';
					DisplayDirectBuyMessage(m, 'error',Title);					
					return false;
				}
				
							
				//Qty
				if (!qty)
				{
					m='Number of tokens to buy MUST not be blank.';				
					DisplayDirectBuyMessage(m, 'error',Title);					
					return false;
				}
				
				if (!$.isNumeric(qty))
				{
					m='Number of tokens to buy MUST be a number. Current entry <b>'+qty+'</b> is not valid.';						
					DisplayDirectBuyMessage(m, 'error',Title);
					return false;
				}

				if (parseInt(qty) == 0)
				{
					m='Number of tokens to buy must not be zero.';				
					DisplayDirectBuyMessage(m, 'error',Title);
					return false;
				}
				
				if (parseInt(qty) < 0)
				{
					m='Number of tokens to buy must not be less than zero.';				
					DisplayDirectBuyMessage(m, 'error',Title);
					return false;
				}				
									
				if (parseInt(available_qty) < parseInt(qty))
				{
					m="The number of tokens to buy (<b>"+number_format(qty,0,'',',')+"</b>) is more than the available tokens for sale (<b>" + number_format(available_qty,0,'',',') + "</b>).";
					DisplayDirectBuyMessage(m, 'error',Title);
					return false;
				}
				
				//Wallet balance
				var bal=$.trim($('#lblDirectBuyBalance').html()).replace(new RegExp(',', 'g'), '');				
				bal=bal.replace(new RegExp('₦', 'g'), '');
				
				if (!bal)
				{
					m='Your e-wallet balance is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of asset. If the issue still persists after signout and signin and you are sure that you have credited your e-wallet, please contact the system administrator at support@naijaartmart.com, otherwise credit your wallet through <a href="<?php echo site_url('ui/Wallet'); ?>">Wallet Module</a> on your side menu.';	
							
					DisplayDirectBuyMessage(m, 'error',Title);					
					return false;
				}
				
				if (!$.isNumeric(bal))
				{
					m='E-wallet balance MUST be a number.';						
					DisplayDirectBuyMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(bal) == 0)
				{
					m='E-wallet balance is zero. Please fund your e-wallet so that you can trade with it.';				
					DisplayDirectBuyMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(bal) < 0)
				{
					m='E-wallet balance must not be a negative number. Please fund your e-wallet so that you can trade with it.';				
					DisplayDirectBuyMessage(m, 'error',Title);
					return false;
				}
				
				var sms='<?php echo (floatval($sms_fee) * 2); ?>';
				var transfer_fee='<?php echo $transfer_fee; ?>';			
				var brokers_rate = '<?php echo $brokers_rate; ?>';
				var nse_rate = '<?php echo $nse_rate; ?>';
				
				var amount = parseFloat(qty) * parseFloat(price);
				var brokerfee = (parseFloat(brokers_rate)/100) * amount;
				var nsefee = (parseFloat(nse_rate)/100) * amount;
				var total = parseFloat(amount) + parseFloat(brokerfee) + parseFloat((nsefee/2)) + parseFloat(sms) + parseFloat(transfer_fee);
				
				if (parseFloat(bal) < parseFloat(total))
				{
					m="You do not have enough balance in your e-wallet to buy this asset. Your current e-wallet balance is (<b>₦"+number_format(bal,2,'.',',')+"</b>) and the total amount needed for buying "+number_format(qty,0,'',',')+" tokens of the asset is (<b>₦" + number_format(total,2,'.',',') + "</b>).";
					DisplayDirectBuyMessage(m, 'error',Title);
					return false;
				}
				
				var det='<h3 style="background-color:#337AB7; color:#ffffff;"><b>TRADE DETAILS</b></h3>';
				
				
				det += '<div class=" form-group size-17"><label title="Wallet Balance" class="col-sm-6 col-form-label nsegreen text-right">Wallet Balance:</label><label class="col-form-label redalerttext col-sm-6 text-left">₦' + number_format(bal,2,'.',',') + '</label></div>';
				
				det += '<div class=" form-group size-17"><label title="Asset" class="col-sm-6 col-form-label nsegreen text-right">Symbol:</label><label class="col-form-label redalerttext col-sm-6 text-left">' + sym + '</label></div>';
				
				//det += '<div class=" form-group size-17"><label title="Available Quantity" class="col-sm-6 col-form-label nsegreen text-right">Available Qty:</label><label class="col-form-label redalerttext col-sm-6 text-left">' + number_format(av_qty,0,'',',') + '</label></div>';
				
				det += '<div class=" form-group size-17"><label title="Quantity Of Tokens To Buy" class="col-sm-6 col-form-label nsegreen text-right">Qty To Buy:</label><label class="col-form-label redalerttext col-sm-6 text-left">' + number_format(qty,0,'',',') + '</label></div>';
				
				
				det += '<div class=" form-group size-17"><label title="Buying Price Per Tokens" class="col-sm-6 col-form-label nsegreen text-right">Price:</label><label class="col-form-label redalerttext col-sm-6 text-left">₦' + number_format(price,2,'.',',') + '</label></div>';
				
				det += '<div class=" form-group size-17"><label title="Broker Transaction Fee" class="col-sm-6 col-form-label nsegreen text-right">Broker Fee:</label><label class="col-form-label redalerttext col-sm-6 text-left">₦' + number_format(brokerfee,2,'.',',') + '</label></div>';
				
				var nf=(nsefee/2);
				
				det += '<div class=" form-group size-17"><label title="NSE Transaction Fee" class="col-sm-6 col-form-label nsegreen text-right">NSE Fee:</label><label class="col-form-label redalerttext col-sm-6 text-left">₦' + number_format(nf,2,'.',',') + '</label></div>';
				
				det += '<div class=" form-group size-17"><label title="SMS Fee" class="col-sm-6 col-form-label nsegreen text-right">SMS Fee:</label><label class="col-form-label redalerttext col-sm-6 text-left">₦' + number_format(sms,2,'.',',') + '</label></div>';
				
				det += '<div class=" form-group size-17"><label title="Transfer Fee" class="col-sm-6 col-form-label nsegreen text-right">Transfer Fee:</label><label class="col-form-label redalerttext col-sm-6 text-left">₦' + number_format(transfer_fee,2,'.',',') + '</label></div>';
				
				det += '<div class=" form-group size-17"><label title="Total Transaction Fee Including Fees/Commissions" class="col-sm-6 col-form-label nsegreen text-right">TOTAL AMOUNT:</label><label class="col-form-label redalerttext col-sm-6 text-left">₦' + number_format(total,2,'.',',') + '</label></div>';
				
				det += '<br><p style="color:#ff0000;" align="center" class="size-17 makebold redalerttext">Do You Want To Proceed With The Buying Of The Asset?</p>';	
				
				//Confirm Update				
				Swal.fire({
				  title: 'CONFIRM BUY',
				  html: '<div>'+det+'</div>',
				  //type: 'question',
				  customClass: 'swal-wide',
				  showCancelButton: true,
				  showClass: {popup: 'animate__animated animate__fadeInDown'},
				  hideClass: {popup: 'animate__animated animate__fadeOutUp'},
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Buying Asset. Please Wait...</p>',theme: false,baseZ: 2000});

				var mdata={brokeremail:Email, sell_broker_id:sell_broker_id, sell_order_id:order_id, sell_investor_id:sell_investor_id, buy_broker_id:BrokerId, buy_investor_id:inv_em, symbol:sym, price:price, qty:qty, available_qty:available_qty, broker_commission:brokerfee, nse_commission:nf, sms_fee:sms, transfer_fee:transfer_fee, total_amount:total, min_buy_qty:'<?php echo $min_buy_qty; ?>',ordertype:ordertype,updaterequeststatus:1,request_id:req_id};	
								
					//Make Ajax Request			
					$.ajax({
						url: '<?php echo site_url('ui/Directexchange/BuyTokens'); ?>',

						data: mdata,
						type: 'POST',
						dataType: 'json',
						success: function(data,status,xhr) {				
							$.unblockUI();
							
							if ($(data).length > 0)
							{
								$.each($(data), function(i,e)
								{
									if ($.trim(e.status).toUpperCase() == 'OK')
									{				
										ResetModalSecBuy();
										ResetControls();
			
										m= 'Purchase of '+number_format(qty, '0', '', ',') + ' tokens of '+ $.trim(sym).toUpperCase() +' was successful.';
										
										DisplayMessage(m, 'success','Token Purchase','SuccessTheme');
																				
										GetBalance();
										
										$('#tabRequests > tbody').html('');
					
										$('#cboRequestStatus').val('');
					
										$("#divDirectBuyModal").modal('hide');//Close modal
										
										UiActivateTab('view');
									}else
									{
										m=e.Message;
										
										DisplayDirectBuyMessage(m,'error',Title);		
									}
									
									return;
								});//End each
							}
						},
						error:  function(xhr,status,error) {
							m='Error '+ xhr.status + ' Occurred: ' + error
							DisplayDirectBuyMessage(m,'error',Title);
						}
					});
				  }
				})
			}catch(e)
			{
				$.unblockUI();
				m='BuyDirectArt ERROR:\n'+e;
				DisplayDirectBuyMessage(m,'error',Title);
			}
		}
		
		function LoadSellers(symbol)
		{
			try
			{
				$('#tabSellers > tbody').html('');
				
				$.ajax({
					url: "<?php echo site_url('ui/Directexchange/GetSellers');?>",
					type: 'POST',
					data: {symbol:symbol},
					dataType: 'json',
					success: function(dataSet,status,xhr) {	
						$.unblockUI();
						
						if (tableseller) tableseller.destroy();
						
						//f-filtering, l-length, i-information, p-pagination
						tableseller = $('#tabSellers').DataTable( {
							dom: '<"top"i>rt<"bottom"lp><"clear">',
							responsive: true,
							ordering: false,
							autoWidth:false,
							language: {zeroRecords: "No Sell Orders Record Found"},
							lengthMenu: [ [5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"] ],									
							columnDefs: [
								{
									"targets": [ 0,1,2,3,4 ],
									"visible": true
								},
								{
									"targets": [ 4 ],
									"orderable": false,
								},
								{
									"targets": [ 1,2,3 ],
									"orderable": true
								},
								{ className: "dt-center", "targets": [ 0,1,2,3,4 ] }
							],					
							order: [[ 2, 'asc' ]],
							data: dataSet, 
							columns: [
								{ width: "15%" },//Asset
								{ width: "16%" },//Available Qty
								{ width: "14%" },//Price
								{ width: "35%" },//Broker
								{ width: "10%" }//Buy button
							],
						} );		
					},
					error:  function(xhr,status,error) {
						$.unblockUI();
						m='Error '+ xhr.status + ' Occurred: ' + error;
						DisplayDirectBuyMessage(m,'error',Title);
					}
				});
			}catch(e)
			{
				$.unblockUI();
				m='LoadSellers ERROR:\n'+e;
				DisplayDirectBuyMessage(m,'error',Title);
			}
		}
				
		function GetBalance()
		{
			try
			{
				var bal=$.trim($('#uiWalletBalance').html()).replace(new RegExp(',', 'g'), '');				
				bal=bal.replace(new RegExp('₦', 'g'), '');
				
				if (parseFloat(bal) > 0)
				{
					$('#uiWalletBalance').html(number_format(bal, '2', '.', ','));
					$('#lblDirectBuyBalance').html(number_format(bal, '2', '.', ','));
					$('#lblDirectSellBalance').html(number_format(bal, '2', '.', ','));
				}else
				{
					$('#uiWalletBalance').html('');
					$('#lblDirectBuyBalance').html('');
					$('#lblDirectSellBalance').html('');
					
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Wallet Balance. Please Wait...</p>',theme: false,baseZ: 2000});
											
					//Make Ajax Request			
					$.ajax({
						url: '<?php echo site_url('ui/Directexchange/GetBalance'); ?>',
						data: {email:Email},
						type: 'POST',
						dataType: 'text',
						success: function(data,status,xhr) {				
							$.unblockUI();
							
							var b=data;							
							
							if ($.isNumeric(b))
							{
								$('#uiWalletBalance').html(number_format(b, '2', '.', ','));
								$('#lblDirectBuyBalance').html(number_format(b, '2', '.', ','));
								$('#lblDirectSellBalance').html(number_format(b, '2', '.', ','));
							}else
							{
								m=data;
								DisplayMessage(m,'error',Title);	
							}
						},
						error:  function(xhr,status,error) {
							m='Error '+ xhr.status + ' Occurred: ' + error;
							DisplayMessage(m,'error',Title);
						}
					});	
				}
			}catch(e)
			{
				$.unblockUI();
				m='GetBalance ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End GetBalance
		
		function ResetControls()
		{
			try
			{
				$('#lblSymbol').html('');
				$('#lblRequestDate').html('');				
				$('#lblMinPrice').html('');
				$('#lblMarketType').html('');
				$('#txtQty').val('');
				$('#txtPrice').val('');
				$('#lblPrice').html('Transaction Price<span class="redtext">*</span>');
				$('#txtMarketPrice').val('');
				$('#lblRequestStatus').html('');
				$('#lblMinPrice').html('');
				$('#lblMaxPrice').html('');
				$('#lblTransType').html('');
				$('#lblTradeAmount').html('');
				$('#lblSMSFee').html('');				
				$('#lblBrokerFee').html('');
				$('#lblNSEFee').html('');
				$('#lblTransferFee').html('');
				$('#lblTotalTradeAmount').html('');
				$('#lblInvestor').html('');
				$('#lblInvestorEmail').html('');
				$('#lblListingStatus').html('');
				$('#lblQty').html('Total Quantity');
				
				$('#btnBuy').hide();
				$('#btnSell').hide();
				
				$('#divStatus').hide();
				$('#lblStatus').hide();				
				
				
				$('#hidId').val('');	
				$('#hidInvId').val('');
				$('#hidIssuerId').val('');
				$('#hidIssuerName').val('');
				$('#hidIssuerEmail').val('');
				
			}catch(e)
			{
				$.unblockUI();
				m='ResetControls ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}
		
		function SelectRow(sym,dt,qty,marketprice,sms,bfee,nse,mtype,sta,inv,invid,tamt,totamt,rid,ttype,minpr,maxpr,invemail,listing_status)
		{
			try
			{
				ResetControls();
				ResetModalSecSell();
				ResetModalSecBuy();
				
				GetBalance();
				
				var transfer_fee='<?php echo str_replace(',','',$transfer_fee); ?>';
				
				totamt=parseFloat(transfer_fee) + parseFloat(totamt);
				
				$('#lblRequestDate').html(dt);
				$('#lblSymbol').html(sym);
				$('#lblMarketType').html(mtype);
				$('#lblTransType').html(ttype);
				$('#lblRequestStatus').html(sta);
				$('#txtQty').val(number_format(qty, 0, '', ','));
				
				$('#lblInvestor').html(inv);
				$('#lblInvestorEmail').html(invemail);
				$('#hidInvId').val(invid);
				$('#hidId').val(rid);
				
				LoadMarketPrice(sym);
				
				if (parseFloat(sms) > 0) $('#lblSMSFee').html(number_format(sms, 2, '.', ','));				
				if (parseFloat(bfee) > 0) $('#lblBrokerFee').html(number_format(bfee, 2, '.', ','));
				if (parseFloat(nse) > 0) $('#lblNSEFee').html(number_format(nse, 2, '.', ','));	
				if (parseFloat(transfer_fee) > 0) $('#lblTransferFee').html(number_format(transfer_fee, 2, '.', ','));					
				if (parseFloat(minpr) > 0) $('#lblMinPrice').html(number_format(minpr, 2, '.', ','));	
				if (parseFloat(maxpr) > 0) $('#lblMaxPrice').html(number_format(maxpr, 2, '.', ','));
				
				$('#lblTradeAmount').html(number_format(tamt, 2, '.', ','));
				$('#lblTotalTradeAmount').html(number_format(totamt, 2, '.', ','));
				
				$('#txtMarketPrice').css('cursor','default').prop('readonly',true).css('background-color','#ffffff');
				
				if ($.trim(mtype).toLowerCase() == 'secondary')
				{
					$('#txtMarketPrice').val(number_format(marketprice, 2, '.', ','));
					$('#txtPrice').css('cursor','default').prop('readonly',true).css('background-color','#ffffff');
					
					$('#lblHideShowAvailableQty').hide();
					$('#divHideShowAvailableQty').hide();
					
					$('#divMinMaxPrice').show();	
					$('#divStatus').hide();
					$('#lblStatus').hide();
					
					$('#divBuyToken').hide();
					$('#divBrokerNSE').hide();
					$('#divSMSTransfer').hide();
					$('#lblHideShowTotalAmount').hide();
					$('#divHideShowTotalAmount').hide();
				}else if ($.trim(mtype).toLowerCase() == 'primary')
				{
					$('#lblHideShowAvailableQty').show();
					$('#divHideShowAvailableQty').show();
			
					$('#divMinMaxPrice').hide();
					$('#divStatus').show();
					$('#lblStatus').show();
					
					$('#divBuyToken').show();
					$('#divBrokerNSE').show();
					$('#divSMSTransfer').show();
					$('#lblHideShowTotalAmount').show();
					$('#divHideShowTotalAmount').show();
				
					$('#lblListingStatus').html(listing_status);
					GetPrimaryMarketDetails(sym);
				}
								
				
				if ($.trim(ttype).toLowerCase() == 'buy')
				{
					$('#btnBuy').show();
					$('#btnSell').hide();
					$('#lblPrice').html('Buying Price<span class="redtext">*</span>');
					
					$('#lblQty').html('Quantity To Buy<span class="redtext">*</span>');
				}else if ($.trim(ttype).toLowerCase() == 'sell')
				{
					$('#btnBuy').hide();
					$('#btnSell').show();
					$('#lblPrice').html('Selling Price<span class="redtext">*</span>');
					$('#lblQty').html('Quantity To Sell<span class="redtext">*</span>');					
					$('#lblDirectSellTransferFee').html(number_format(transfer_fee, 2, '.', ','));	
								
					GetDirectPortfolioTokens(sym,invemail); //Load seller portfolio	
				}
				
				if ($.trim(sta).toLowerCase() == 'treated')
				{
					$('#btnBuy').hide();
					$('#btnSell').hide();
					$('#lblQty').html('Token Quantity<span class="redtext">*</span>');
					$('#lblPrice').html('Transaction Price<span class="redtext">*</span>');
				}
				
				UiActivateTab('data');				
			}catch(e)
			{
				$.unblockUI();
				m='SelectRow ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}
		
		function GetDirectPortfolioTokens(symbol,invEmail)
		{
			try
			{
				$('#lblDirectSellPortfolioQty').html('');
								
				$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Number Of Tokens. Please Wait...</p>',theme: false,baseZ: 2000});
										
				//Make Ajax Request			
				$.ajax({
					url: '<?php echo site_url('ui/Directexchange/GetTokensFromPortfolio'); ?>',
					data: {email:invEmail,symbol:symbol,brokerid:BrokerId},
					type: 'POST',
					dataType: 'text',
					success: function(data,status,xhr) {				
						$.unblockUI();
						
						var b=data;							
						
						if ($.isNumeric(b))
						{
							$('#lblDirectSellPortfolioQty').html(number_format(b, '0', '', ','));
						}else
						{
							m=data;
							DisplayDirectSellMessage(m,'error',Title);	
						}
					},
					error:  function(xhr,status,error) {
						m='Error '+ xhr.status + ' Occurred: ' + error;
						DisplayDirectSellMessage(m,'error',Title);
					}
				});
			}catch(e)
			{
				$.unblockUI();
				m='GetDirectPortfolioTokens ERROR:\n'+e;				
				DisplayDirectSellMessage(m, 'error',Title);
				return false;
			}		
		}//End GetDirectPortfolioTokens
		
		function LoadMarketPrice(symbol)
		{
			try
			{
				$('#lblDirectSellMarketPrice').html('');
				$('#txtMarketPrice').val('');
								
				$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Market Price. Please Wait...</p>',theme: false,baseZ: 2000});
										
				//Make Ajax Request			
				$.ajax({
					url: '<?php echo site_url('ui/Viewtraderequest/GetMarketPrice'); ?>',
					data: {symbol:symbol},
					type: 'POST',
					dataType: 'text',
					success: function(data,status,xhr) {				
						$.unblockUI();
						
						var s=data;							
						
						if ($.isNumeric(s))
						{
							$('#lblDirectSellMarketPrice').html(number_format(s, '2', '.', ','));
							$('#txtMarketPrice').val(s);
						}else
						{
							m=data;
							DisplayMessage(m,'error',Title);	
						}
					},
					error:  function(xhr,status,error) {
						m='Error '+ xhr.status + ' Occurred: ' + error;
						DisplayMessage(m,'error',Title);
					}
				});
			}catch(e)
			{
				$.unblockUI();
				m='LoadMarketPrice ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End LoadMarketPrice
		
		function GetPrimaryMarketDetails(symbol)
		{
			try
			{			
				$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Primary Market Details. Please Wait...</p>',theme: false,baseZ: 2000});
										
				//Make Ajax Request			
				$.ajax({
					url: '<?php echo site_url('ui/Viewtraderequest/GetPrimaryMarketDetails'); ?>',
					data: {symbol:symbol},
					type: 'POST',
					dataType: 'json',
					success: function(data,status,xhr) {				
						$.unblockUI();
						
						if ($(data).length > 0)
						{
							$.each($(data), function(i,e)
							{//Price, Available Qty, IssuerId,IssuerEmail,IssuerName
								if (parseFloat(e.price) > 0)
								{
									$('#txtMarketPrice').val(number_format(e.price, 2, '.', ','));
									$('#txtPrice').val(number_format(e.price, 2, '.', ','));
								}
								
								$('#txtMarketPrice').css('cursor','default').prop('readonly',true);
								$('#txtPrice').css('cursor','default').prop('readonly',true);
								
								if (parseInt(e.tokens_available) > 0) $('#lblAvailableQty').html(number_format(e.tokens_available, 0, '', ','));
								$('#hidIssuerId').val(e.uid);
								$('#hidIssuerName').val(e.issuer_name);
								$('#hidIssuerEmail').val(e.issuer_email);
								
								return;
							});//End each
						}
					},
					error:  function(xhr,status,error) {
						m='Error '+ xhr.status + ' Occurred: ' + error;
						DisplayMessage(m,'error',Title);
					}
				});
			}catch(e)
			{
				$.unblockUI();
				m='GetPrimaryMarketDetails ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End GetPrimaryMarketDetails
		
		function ShowPix(sym,title,p1,url)
		{
			try
			{
				$('#ancBlockchainUrl').html('').prop('href','').prop('title','');
				$('#ancBlockchainUrl').removeAttr('href');
				
				if (p1)
				{
					var pixpath = '<?php echo base_url(); ?>art-works/'+p1;
					
					var c=$.trim(title);
					
					if (c) c = c+': Picture 1'; else c = 'Artwork Picture';
					
					$("#modPixTitle").html(TitleCase(c));

					$('#img01').css('width','100%').attr({'src':pixpath});
					
					if (url)
					{
						$('#ancBlockchainUrl').html('Click To View Asset Blockchain Record');
						$('#ancBlockchainUrl').prop('href',url).prop('title',"Click To View Asset Blockchain Details");
					}
					
					$('#myPixModal').modal({
						fadeDuration: 	1000,
						fadeDelay: 		0.50,
						keyboard: 		false,
						backdrop:		'static'
					});	
				}
			}catch(e)
			{
				$.unblockUI();
				m='ShowPix ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
		}
		
		function updateClock()
		{
			var currentTime = new Date ( );
			var currentHours = currentTime.getHours ( );
			var currentMinutes = currentTime.getMinutes ( );
			var currentSeconds = currentTime.getSeconds ( );				
			var month=currentTime.getMonth()+1;
			var day=currentTime.getDate();
			var year=currentTime.getFullYear();
			
			var weekdays = new Array(7);
			weekdays[0] = "Sunday";
			weekdays[1] = "Monday";
			weekdays[2] = "Tuesday";
			weekdays[3] = "Wednesday";
			weekdays[4] = "Thursday";
			weekdays[5] = "Friday";
			weekdays[6] = "Saturday";
			
			var dayname = weekdays[currentTime.getDay()];
			
			
			if (month <10 ){month='0' + month;}
			if (day <10 ){day='0' + day;}
			
			var dt= day+' '+GetMonthName(month)+' '+year;
			
			// Pad the minutes and seconds with leading zeros, if required
			currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
			currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
			
			// Choose either "AM" or "PM" as appropriate
			var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";
			
			// Convert the hours component to 12-hour format if needed
			currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;
			
			// Convert an hours component of "0" to "12"
			currentHours = ( currentHours == 0 ) ? 12 : currentHours;
			
			// Compose the string for display
			var currentTimeString = dayname+", "+dt+" "+currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
			
			$("#lblTime").html(currentTimeString);
		
		}
	</script>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
<nav class="navbar navbar-default navbar-fixed-top" style="background:#ffffff; z-index:10;
    box-shadow: 2px 2px 21px 10px lightgrey ">
    <div class="brand" style="background:#ffffff;">
        <a href="<?php echo site_url('ui/Dashboard');?>">
        <img style="height:45px;" src="<?php echo base_url(); ?>newassets/img/naija_art_mart1.png" alt="Naija Art Market Logo" class="img-responsive logo mobile-logo preload-me">
        
        </a>
    </div>
    
    <div class="container-fluid ">
        <!-- <form class="navbar-form">
            <div class="input-group">
                <?php
					if ((trim(strtolower($usertype))=='broker') or (trim(strtolower($usertype))=='investor'))
					{
						echo '
							<span class="input-group-btn"><a href="'.site_url('ui/Wallet').'" type="button" class="btn btn-nse-green" style="font-size:14px; font-weight:bold;"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;DEPOSIT FUNDS</a></span>		
						';
					}
				?>                
                
             	
               <span style="background:transparent; margin-left:12px; line-height:35px;">               
                 <span class="whitetext size-12 makebold" style="text-transform:uppercase;">
                 	Market&nbsp;Status:&nbsp;&nbsp;<span id="spnClientMarketStatus"><?php if (trim(strtoupper($_SESSION['MarketStatus'])) == 'OPEN') echo '<font color="#82E99B">'.$_SESSION['MarketStatus'].'</font>'; else echo '<font color="#FF5858">'.$_SESSION['MarketStatus'].'</font>'; ?></span>
                 </span> 
             </span>
            
            
             </div>
        </form>        
         -->
        <div class="navbar-menu">
            <ul class="nav navbar-nav">
            <li class="nav-li">
            <?php
            if (trim(strtolower($usertype))=='broker'){?>
              <a class="nav-text home" href="<?php echo site_url('ui/Dashboard') ?>">
             <?php }elseif ((trim(strtolower($usertype))=='issuer') or (trim(strtolower($usertype))=='investor')){ ?>
              <a class="nav-text home" href="<?php echo site_url('ui/Dashboardiv') ?>">
                <?php } ?>Dashboard
              </a>
            </li>
            <?php if ($usertype == 'Issuer') {?>
               <li class="nav-li">
                    <a href="<?php echo site_url(); ?>ui/Primarytradehistory" class="nav-text pages">Primary Trade History</a>
                </li>
                <li class="nav-li">
                    <a href="<?php echo site_url('ui/Requestlisting'); ?>" class="nav-text">Request For Listing</a>
                </li>
            
            <?php } else { ?>
            <li class="nav-li">
                <a class="dropdown-toggle text-right nav-text" data-toggle="dropdown">Markets <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li class="">
                        <?php
                        if (trim(strtolower($usertype))=='broker'){?>
                          <a class="nav-text"  href="<?php echo site_url('ui/Primarymarket') ?>">
                         <?php }elseif ((trim(strtolower($usertype))=='issuer') or (trim(strtolower($usertype))=='investor')){ ?>
                          <a class="nav-text"  href="<?php echo site_url('ui/Directinvestorprymarket') ?>">
                            <?php } ?>Primary Market</a>
                        
                    </li>
                    <li class="">
                        <?php
                        if (trim(strtolower($usertype))=='broker'){?>
                          <a class="nav-text"  href="<?php echo site_url('ui/Directexchange') ?>">
                         <?php }elseif ((trim(strtolower($usertype))=='issuer') or (trim(strtolower($usertype))=='investor')){ ?>
                          <a class="nav-text" href="<?php echo site_url('ui/Directinvestorsecmarket') ?>">
                            <?php } ?>Secondary Market</a>
                        
                    </li>  
                    <?php
                    if (trim(strtolower($usertype))=='broker'){?>
                    <li class="">
                        <a class="nav-text"  href="<?php echo site_url('ui/Viewtraderequest') ?>">
                            View Buy/Sell Request</a>
                        
                    </li> 
                    <?php } ?>
                    
                </ul>
            </li> 
            <li class="nav-li">
                <a href="<?php echo site_url(); ?>ui/Portfolio" class="nav-text">Portfolio</a>
            </li>
            <li class="nav-li">
                <a href="<?php echo site_url(); ?>ui/Wallet" class="nav-text">Wallet</a>
            </li>
            <?php } ?>                               
            <li class="nav-li">
                <a href="<?php echo site_url(); ?>ui/Messages" class="nav-text">Messages</a>
            </li>
            
            
            <!-- <li class="nav-li">
                <a class="nav-text pages">Reports</a>
                <ul class="dropdown-otr drop-3">
                <?php if ($usertype == 'Issuer') { ?>
                    <li class="dropdown-li">
                        <a href="<?php echo site_url('ui/Listingrep') ?>" class="dropdown-a body-mb">Listings Report</a>
                    </li>
                    <li class="dropdown-li">
                        <a href="<?php echo site_url('ui/Primarytradesrep') ?>" class="dropdown-a body-mb">Primary Trades</a>
                    </li>
                
                <?php } else { ?>
                    <li class="dropdown-li">
                        <a href="<?php echo site_url('ui/Listingrep') ?>" class="dropdown-a body-mb">Listings Report</a>
                    </li>
                    <li class="dropdown-li">
                        <a href="<?php echo site_url('ui/Primarytradesrep') ?>" class="dropdown-a body-mb">Primary Trades</a>
                    </li>
                <?php }
                 ?>                                       
                </ul>
            </li> -->
            
        </ul>
        <div id="navbar-menu">
        	
                    	
            <ul id="ulUsertype" class="nav navbar-nav navbar-right">
            	<li>
            		<a class="d-lg-flex d-none nav-text">Market Status  &nbsp; :
                    	<span id="spnClientMarketStatus"><?php if (trim(strtoupper($_SESSION['MarketStatus'])) == 'OPEN') echo '<font color="#82E99B">'.$_SESSION['MarketStatus'].'</font>'; else echo '<font color="#FF5858">'.$_SESSION['MarketStatus'].'</font>'; ?></span>
                                <!-- <?php if (trim(strtoupper($_SESSION['MarketStatus'])) == 'OPEN') { ?>
                                    <button type="button" class="btn btn-inverse-success btn-sm">
                                        <?php echo $_SESSION['MarketStatus']; ?></button>
                                <?php
                                }else{?>
                                    <button type="button" class="btn btn-inverse-danger btn-sm"><?php echo $_SESSION['MarketStatus']; ?></button>
                                <?php }?> -->
                              </a>
            	</li>
            	<li class="dropdown">
                    <a id="ancMsg" href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                        <i class="lnr lnr-alarm msgclass"></i>
                        <span id="uiMsgCount" class="badge bg-danger"></span>
                    </a>
                    
                   <!-- <ul class="dropdown-menu notifications">
                    	<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Message</a></li>
                    </ul>-->
                    
                </li>
                
                
                
               <li class="dropdown">
                    <a href="#" class="dropdown-toggle text-right" data-toggle="dropdown"><img src="<?php echo base_url(); ?>assets/img/avatar1.png" class="img-circle" alt="Avatar"> <span title="<?php echo $fullname; ?>" style="color:darkgray;"><?php echo $usertype; ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                    
                    <ul class="dropdown-menu">
                        <li title="<?php echo $fullname; ?>"><a href="#"><i style="color:#ff0000;" class="fa fa-user"></i> <span><span style="color:#ff0000;"><?php echo $email; ?></span></span></a></li>
                        
                        <li><a href="<?php if (strtolower(trim($usertype))=='broker') echo site_url('ui/Userprofile'); else echo site_url('ui/Userprofileiv'); ?>"><i style="color:#3D3E11;" class="fa fa-id-badge"></i> <span style="color:#3D3E11;">My Profile</span></a></li>
                        
                        <li><a href="<?php echo site_url('ui/Changepassword');?>"><i style="color:#3D3E11;" class="fa fa-id-badge"></i> <span style="color:#3D3E11;">Change Password</span></a></li>
                        
                        <li><a onClick="LogOut();" href="#"><i style="color:#3D3E11;"  class="lnr lnr-exit"></i> <span style="color:#3D3E11;">Logout</span></a></li>
                    </ul>
                </li>	
            </ul>
        </div>
    </div>
</nav>
<!-- END NAVBAR -->

        
        <!-- MAIN -->
		<div class="main" style="width:100% !important; height: 80% !important;">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
                     <!-- Breadcrum -->
                    <div class="page-title-subheading opacity-10">
                        <div class="col-sm-12 form-group">
                            <div class="col-sm-3">
                                 <nav class="" aria-label="breadcrumb">
                                    <h3>Trade Requests</h3>
                                </nav>   
                            </div>
                            
                            <div class="col-sm-9">
                                <div class="col-sm-3">&nbsp;</div>
                                
                                 
                                    
                                <div class="col-sm-9 text-right">
                                    <span style="margin-left:5px;" id="lblTime" class=" makebold size-17 redalerttext"></span>
                                 </div>
                            </div> 
                        </div>                           
                    </div>                        
						
                    <ul class="nav nav-tabs">
                       <li class="active makebold size-16">
                            <a id="tabView" data-toggle="tab" href="#view" style="text-transform:uppercase;">View Trade Request</a>
                       </li>
                       
                       <li class="makebold size-16">
                            <a id="tabData" data-toggle="tab" href="#data" style="text-transform:uppercase;">Request Details</a>
                       </li>
                                              
                       
                       
                       <li onClick="window.location.reload(true);" class="makebold size-16"><a data-toggle="tab" href="#refresh" style="text-transform:uppercase;" class="redtext">Refresh</a></li>
                   </ul>
                       
                   <div class="tab-content"> <!--details-->
                        <div id="view" class="tab-pane tabs-animation fade in active">
                        	<div class="position-relative row form-group">
                                <!--Request Status-->
                                <label title="Request Status" for="cboRequestStatus" class="col-sm-2 col-form-label text-right nsegreen text-right">Request Status</label>
                            
                                <div title="Request Status" class="col-sm-3">
                                    <select id="cboRequestStatus" class="form-control">
                                    	<option value="">[ALL STATUS]</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Treated">Treated</option>
                                    </select>
                                </div>
                                
                                <!--Button-->
                                <div class="col-sm-5">
                                    <button title="Click to display requests" id="btnDisplayStatus" type="button" class="btn btn-primary makebold">Click To Display Requests</button>
                                </div>
                            </div>
                               
                            <table class="hover table table-bordered data-table display wrap" id="tabRequests">
                              <thead>
                                <tr>
                                    <th style="text-align:center" width="22%">ARTWORK</th>
                                    <th style="text-align:center" width="11%">MARKET&nbsp;TYPE</th>
                                    <th title="Transaction Type" style="text-align:center" width="10%">TRANS.&nbsp;TYPE</th>
                                    <th style="text-align:center" width="11%">SYMBOL</th>
                                    <th style="text-align:center" width="12%">TOKEN&nbsp;QTY</th>
                                    <th style="text-align:center" width="12%">MARKET&nbsp;PRICE</th>
                                    <th style="text-align:center" width="16%">REQUEST&nbsp;STATUS</th>
                                    <th style="text-align:center;" width="5%">VIEW</th>
                                </tr>
                              </thead>
    
                              <tbody id="tbmarketbody"></tbody>
                            </table>
                        </div>
                        
                        <div id="data" class="tab-pane tabs-animation fade">
                            <form>
                            	<input type="hidden" id="hidId">
                                <input type="hidden" id="hidInvId">
                                <input type="hidden" id="hidIssuerEmail">
                                <input type="hidden" id="hidIssuerName">
                                <input type="hidden" id="hidIssuerId">
                                
                               <!--Request Date/Market Type-->
                                 <div class="position-relative row form-group">
                                    <!--Request Date-->
                                    <label title="Request Date" for="lblRequestDate" class="col-sm-2 col-form-label text-right nsegreen text-right">Request Date</label>
                                
                                    <div title="Request Date" class="col-sm-4">
                                        <label id="lblRequestDate" class="form-control nobold"></label>
                                    </div>
                                    
                                    <!--Market Type-->
                                    <label title="Market Type" for="lblMarketType" class="col-sm-2 col-form-label text-right nsegreen text-right">Market Type</label>
                                
                                    <div title="Market Type" class="col-sm-4">
                                        <label id="lblMarketType" class="form-control nobold"></label>
                                    </div>
                                </div>
                                
                                
                                <!--Transaction Type/Request Status-->
                                 <div class="position-relative row form-group">
                                    <!--Transaction Type-->
                                    <label title="Transaction Type" for="lblTransType" class="col-sm-2 col-form-label text-right nsegreen text-right">Transaction Type</label>
                                
                                    <div title="Transaction Type" class="col-sm-4">
                                        <label id="lblTransType" class="form-control nobold"></label>
                                    </div>
                                   
                                    <!--Request Status-->
                                     <label title="Request Status" for="lblRequestStatus" class="col-sm-2 col-form-label text-right nsegreen text-right">Request Status</label>
                                
                                     <div title="Request Status" class="col-sm-4">
                                        <label id="lblRequestStatus" class="form-control makebold"></label>
                                     </div>
                                </div>
                                                                
                               <!--Asset/Market Price-->
                                 <div class="position-relative row form-group">
                                    <!--Asset--> 
                                    <label title="Asset" for="lblSymbol" class="col-sm-2 col-form-label text-right">Asset<span class="redtext">*</span></label>
                                    
                                    <div title="Asset" class="col-sm-4">
                                        <label id="lblSymbol" class="form-control nobold"></label>
                                    </div>               
                                
                                	 <!--Market price-->
                                    <label title="Market price. Default is the current market price" for="txtMarketPrice" class="col-sm-2 col-form-label text-right">Market Price</label>
                                    
                                    <div title="Current Market Price" class="col-sm-4">
                                    	<div class="input-group">
                                            <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                                            
                                             <input readonly style="cursor:default;" type="text" id="txtMarketPrice" placeholder="Market Price" class="form-control size-17">
                                        </div>                                        
                                    </div>                                    
                                </div>
                                
                                
                                <!--Request Min Price/Request Max Price-->
                                <div id="divMinMaxPrice" class="position-relative row form-group">
                                	<!--Request Min Price-->
                                    <label style="padding-left:0px;" title="Request minimum price" for="lblMinPrice" class="col-sm-2 col-form-label text-right">Request Min. Price</label>
                                        
                                    <div  title="Request minimum price" class="col-sm-4">
                                    	<div class="input-group">
                                            <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                                            
                                             <label id="lblMinPrice" class="form-control nobold size-17"></label>
                                        </div>                                        
                                    </div>
                                    
                                    <!--Request Max Price-->
                                    <label style="padding-left:0px;" title="Request maximum price" for="lblMaxPrice" class="col-sm-2 col-form-label text-right">Request Max. Price</label>
                                        
                                    <div  title="Request maximum price" class="col-sm-4">
                                    	<div class="input-group">
                                            <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                                            
                                             <label id="lblMaxPrice" class="form-control nobold size-17"></label>
                                        </div>                                        
                                    </div>
                                </div>    
                                
                                <!--Available Quantity/Tokens To Buy-->
                                <div id="divAvailableQty" class="position-relative row form-group">
                                    <!--Available Quantity-->
                                    <label id="lblHideShowAvailableQty" title="Available tokens for sale" for="lblAvailableQty" class="col-sm-2 col-form-label nsegreen text-right">Available Tokens<span class="redtext">*</span> <i data-toggle="tooltip" data-placement="right auto" title="Note that this available quantity may change at the point of actual trading as the market is very dynamic." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                                    
                                    <div id="divHideShowAvailableQty" title="Available tokens for sale" class="col-sm-4">
                                        <label id="lblAvailableQty" class="form-control nobold size-17"></label>
                                    </div>
                                    
                                    <!--Quantity To Buy-->
                                    <label id="lblQty" title="Number of tokens to buy" for="txtQty" class="col-sm-2 col-form-label nsegreen text-right">Quantity To Buy<span class="redtext">*</span> <i data-toggle="tooltip" data-placement="right auto" title="Note that this requested quantity was based on the available quantity at the time the request was made by the investor. Current available quantity of tokens for transaction may be different. So you may have to change the request quantity to meet up with the current available quantity." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                                    
                                    <div title="Number of tokens" class="col-sm-4">
                                        <input min="1" type="number" id="txtQty" placeholder="Number Of Tokens" class="form-control size-17">
                                    </div>
                                </div>
                                
                                <!--Price To Buy/Token Amount-->
                                <div id="divBuyToken" class="position-relative row form-group">
                                    <!--Transaction Price-->
                                    <label id="lblPrice" style="padding-left:0px;" title="Transaction Price" for="txtPrice" class="col-sm-2 col-form-label text-right">Transaction Price<span class="redtext">*</span> </label>
                                        
                                    <div  title="Transaction Price" class="col-sm-4">
                                    	<div class="input-group">
                                            <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                                            
                                             <input min="1" type="text" id="txtPrice" placeholder="Transaction Price" class="form-control size-17">
                                        </div>                                        
                                    </div>
                                    
                                    <!--Token Amount-->
                                    <label style="padding-left:0px;" title="Tokens Amount" for="lblTradeAmount" class="col-sm-2 col-form-label text-right">Tokens Amount<span class="redtext">*</span> <i data-toggle="tooltip" data-placement="right auto" title="This is the amount required to buy the total number of tokens excluding broker, NSE and SMS fees." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                                    
                                    <div title="Tokens Amount" class="col-sm-4">
                                    	<div class="input-group">
                                            <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                                            
                                             <label id="lblTradeAmount" class="form-control nobold size-17"></label>
                                        </div>
                                    </div>
                                </div>
                                
                               
                                <!--Broker Fee/NSE Fee-->
                             <div id="divBrokerNSE" class="position-relative row form-group">
                                <!--Broker Fee-->
                                <label style="padding-left:0px;" title="Broker Fee" for="lblBrokerFee" class="col-sm-2 col-form-label  nsegreen text-right">Broker Fee<span class="redtext">*</span> </label>
                                
                                <div title="Broker Fee" class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                                         <label id="lblBrokerFee" class="form-control nobold size-17"></label>
                                    </div>
                                </div>
                                
                                  <!--NSE Fee-->
                                 <label title="NSE Fee" for="lblNSEFee" class="col-sm-2 col-form-label text-right nsegreen">NSE Fee<span class="redtext">*</span> </label>
                                 
                                 <div title="NSE Fee" class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                                         <label id="lblNSEFee" class="form-control nobold size-17"></label>
                                    </div>                                    
                                </div>  
                            </div>
                                
                                                     
                             <!--SMS Fee/Transfer Fee-->
                             <div id="divSMSTransfer" class="position-relative row form-group">
                                <!--SMS Fee-->
                                 <label title="SMS Fee" for="lblSMSFee" class="col-sm-2 col-form-label text-right nsegreen">SMS Fee<span class="redtext">*</span> </label>
                                 
                                 <div title="SMS Fee" class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                                        
                                         <label id="lblSMSFee" class="form-control nobold size-17"></label>
                                    </div>
                                </div>
                                
                                <!--Transfer Fee-->
                                <label title="Transfer Fee" for="lblTransferFee" class="col-sm-2 col-form-label text-right nsegreen">Transfer Fee<span class="redtext">*</span> </label>
                                 
                                 <div title="Transfer Fee" class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                                        
                                         <label id="lblTransferFee" class="form-control nobold size-17"></label>
                                    </div>
                                </div>
                            </div>
                        
                             <!--Total Trade Amount/Listing Status-->
                             <div class="position-relative row form-group">
                                 <!--Total Trade Amount-->
                                <label id="lblHideShowTotalAmount" title="Total Trade Amount" for="lblTotalTradeAmount" class="col-sm-2 col-form-label text-right nsegreen text-right">Total Trade Amount <i data-toggle="tooltip" data-placement="right auto" title="This is the total amount required to buy the asset including all the broker, NSE and SMS fees." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                                
                                <div id="divHideShowTotalAmount" style="color:#AF4442;" title="Total Trade Amount" class="col-sm-4">
                                	<div class="input-group">
                                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                                         <label id="lblTotalTradeAmount" class="form-control nobold size-17"></label>
                                    </div>
                                </div>   
                                    
                                    <!--Listing Status-->
                                    <label id="lblStatus"  title="Listing Status" for="lblListingStatus" class="col-sm-2 col-form-label text-right nsegreen text-right">Listing Status</label>
                                    
                                    <div id="divStatus" style="color:#AF4442;" title="Listing Status" class="col-sm-4">
                                        <label id="lblListingStatus" class="form-control nobold size-17"></label>
                                    </div>                       
                               </div>
                       
                               <!--Investor/Investor Email-->
                               <div class="position-relative row form-group">
                                  <!--Investor-->
                                 <label title="Investor" for="lblInvestor" class="col-sm-2 col-form-label text-right nsegreen">Investor<span class="redtext">*</span></label>
                                    
                                  <div title="Investor" class="col-sm-4">
                                      <label id="lblInvestor" class="form-control nobold size-17"></label>
                                  </div>
                                  
                                 
                                     <!--Investor Email-->
                                    <label title="Investor Email" for="lblInvestorEmail" class="col-sm-2 col-form-label text-right nsegreen text-right">Investor Email </label>
                                    
                                    <div style="color:#AF4442;" title="Investor Email" class="col-sm-4">
                                        <label id="lblInvestorEmail" class="form-control nobold size-17"></label>
                                    </div>                    
                               </div>
                               
                               <div id="divAlert"></div>
                               
                              <center><div align="center" class="row">
                                    <button title="Click to buy the artwork" id="btnBuy" type="button" class="btn btn-nse-green makebold">Buy Artwork</button>
                                    
                                    <button style="margin-left:15px;" title="Click to place an order to sell the artwork" id="btnSell" type="button" class="btn btn-nse-green makebold">Place Sell Order</button>
                                    
                                    <button style="margin-left:15px;" onClick="window.location.reload(true);" type="button" class="btn btn-danger makebold">Refresh</button>
                                </div></center>
                            </form>
                            
                                
                        </div>
                   </div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		
         <?php //include('footer.php'); ?>
	</div>
     
	<!-- END WRAPPER -->
</body>

<!--Direct Sell Popup-->
<div id="divDirectSellModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        	<b><span class="redtext" style="margin-right:39px;">SELL ORDER</span> </b>
            
           <span style="float:right">Fields With <span class="redtext">*</span> Are Required               
               <button style="margin-left:50px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
           </span>            
        </h5>        
      </div>
      
      <div class="modal-body">
        <form>
        	<!--Balance-->
             <div class="position-relative row form-group">
                 <!--Balance-->
                <label title="Wallet Balance" for="lblDirectSellBalance" class="col-sm-3 col-form-label  nsegreen text-right labelmiddle">Wallet Balance</label>
                
                <div title="Wallet Balance" class="col-sm-4">
                	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellBalance" class="col-form-label labelmiddle"></label>
                    </div>                    
                </div>
            </div>
                       
            <!--Investor-->
            <div class="row">
                 <div title="Investor" class="position-relative row form-group">
                    <label for="lblDirectSellInvestor" class="col-sm-3 col-form-label nsegreen text-right">Investor<span class="redtext">*</span></label>
                    
                    <div class="col-sm-9">
                        <label id="lblDirectSellInvestor" class="col-form-label labelmiddle"></label>
                    </div>
                </div>
            </div>
                        
            <!--Asset/Market Price-->
             <div class="position-relative row form-group">
                <label title="Asset" for="lblDirectSellSymbol" class="col-sm-3 col-form-label nsegreen text-right labelmiddle">Asset</label>
                
                <div title="Asset" class="col-sm-4">
                    <label id="lblDirectSellSymbol" class="col-form-label redalerttext labelmiddle"></label>
                </div>
                
                
                <!--Market Price-->
                <label title="Market Price" for="lblDirectSellMarketPrice" class="col-sm-2 col-form-label nsegreen text-right labelmiddle">Market Price</label>
                
                <div title="Current Market Price" class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                        
                         <label id="lblDirectSellMarketPrice" class="col-form-label redalerttext labelmiddle"></label>
                    </div>
                </div>                
            </div>
            
            <!--Order Type/Selling Price-->
            <div class="position-relative row form-group">
                <label title="Order Type" for="cboDirectSellOrderType" class="col-sm-3 col-form-label nsegreen text-right">Order Type <i data-toggle="tooltip" data-placement="right auto" title="Not selecting any order type will automatically create this order as a Market Order." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                
                <div title="Order Type" class="col-sm-4">
                    <select id="cboDirectSellOrderType" class="form-control">
                        <option value="">[SELECT]</option>
                        <option value="Market">Market Order</option>
                        <option value="Limit">Limit Order</option>
                    </select>
                </div>
                
                
                <!--Selling Price-->
                <label id="lblDirectSellPrice" title="Selling Price" for="txtDirectSellPrice" class="col-sm-2 col-form-label nsegreen text-right">Selling Price</label>
                
                <div title="Selling Price" class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                        
                         <input type="text" id="txtDirectSellPrice" placeholder="Selling Price" class="form-control size-17 makebold">
                    </div>
                </div>                
            </div>
                        
            <!--Portfolio Qty/No of Token-->            
             <div class="position-relative row form-group">
                <!--Portfolio Qty-->
                <label title="Number of tokens in portfolio" for="lblDirectSellPortfolioQty" class="col-sm-3 col-form-label nsegreen text-right">Portfolio Qty</label>
                
                <div title="Number of tokens in portfolio" class="col-sm-4">
                    <label id="lblDirectSellPortfolioQty" class="col-form-label redalerttext"></label>
                </div>
                
                
                <!--No Of Tokens-->
                <label title="Number of tokens to sell" for="txtDirectSellQty" class="col-sm-2 col-form-label text-right nsegreen text-right">No Of Tokens<span class="redtext">*</span></label>
                
                <div title="Number of tokens to sell" class="col-sm-3">
                    <input type="text" class="form-control" placeholder="No Of Tokens To Sell" id="txtDirectSellQty">
                </div>
            </div>
                      
            <!--Broker Fee/NSE Fee-->
             <div class="position-relative row form-group">
                <label style="padding-left:0px;" title="Broker Fee" for="lblDirectSellBrokerFee" class="col-sm-3 col-form-label  nsegreen text-right labelmiddle">Broker Fee</label>
                
                <div title="Broker Fee" class="col-sm-4">                    
                    <div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellBrokerFee" class="col-form-label redalerttext labelmiddle"></label>
                    </div>
                </div>
                
                  <!--NSE Fee-->
                 <label title="NSE Fee" for="lblDirectSellNSEFee" class="col-sm-2 col-form-label text-right nsegreen text-right labelmiddle">NSE Fee</label>
                 
                 <div title="NSE Fee" class="col-sm-3">
                 	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellNSEFee" class="col-form-label redalerttext labelmiddle"></label>
                    </div>                    
                </div>  
            </div>
            
             <!--SMS Fee/Transfer Fee-->
             <div class="position-relative row form-group">
                <!--SMS Fee-->
                <label title="SMS Fee" for="lblDirectSellSMS" class="col-sm-3 col-form-label text-right nsegreen labelmiddle">SMS Fee<i data-toggle="tooltip" data-placement="right auto" title="Covers cost of sending trading status SMS to investor and broker." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="SMS Fee" class="col-sm-4">
                	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellSMS" class="col-form-label labelmiddle"></label>
                    </div>
                </div>
                
                <!--Transfer Fee-->
                <label title="Transfer Fee" for="lblDirectSellTransferFee" class="col-sm-2 col-form-label text-right nsegreen labelmiddle">Transfer Fee <i data-toggle="tooltip" data-placement="right auto" title="This is the fee for transferring money to your account after a successful trade. This fee is set by the payment processor." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="Transfer Fee" class="col-sm-3">
                	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellTransferFee" class="col-form-label labelmiddle"></label>
                    </div>
                </div>
            </div>   
            
            <!--Tokens Amount/Total Trade Amount-->
             <div class="position-relative row form-group">
                <!--Tokens Amount-->
                <label style="padding-left:0px;" title="Tokens Amount" for="lblDirectSellAmount" class="col-sm-3 col-form-label nsegreen text-right labelmiddle">Tokens Amount <i data-toggle="tooltip" data-placement="right auto" title="This is the amount for the quantity of tokens to sell excluding fees/commission." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="Tokens Amount" class="col-sm-4">
                	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellAmount" class="col-form-label redalerttext labelmiddle"></label>
                    </div>                    
                </div>
                
                <!--Total Trade Amount-->
                <label title="Total Trade Amount" for="lblDirectSellTotalAmount" class="col-sm-2 col-form-label text-right nsegreen labelmiddle">Total&nbsp;Amount&nbsp;<i data-toggle="tooltip" data-placement="right auto" title="This is the total trade amount including all the fees/commission. Please note that every transfer to seller and brokers accounts attracts fee set by the payment processor. This transfer fee is borne by each transfer recipient." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="Total Trade Amount" class="col-sm-3">
                	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellTotalAmount" class="col-form-label labelmiddle"></label>
                    </div>
                </div>
            </div> 
                        
           <div id="divDirectSellAlert"></div>
        </form>
      </div>      
      
      <div class="modal-footer">
        <button id="btnDirectSell" type="button" class="btn btn-nse-green">SUBMIT SELL ORDER</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
        
        <p align="center" class="redtext makebold"><br><i><span class="redtext">*</span> All transfers attract transfer fee set by the payment processor. Fee are borne by transfer recipients.</i></p>
      </div>
    </div>
  </div>
</div>
<!-- End Direct Sell Popup-->


<!--Direct Buy Popup-->
<div id="divDirectBuyModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        	<b><span class="redtext" style="margin-right:39px;">BUY ASSET</span> </b>
            
           <span style="float:right">Fields With <span class="redtext">*</span> Are Required               
               <button style="margin-left:50px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
           </span>            
        </h5>        
      </div>
      
      <div class="modal-body">
        <form>
        	<!--Balance/Investor-->
             <div class="position-relative row form-group">
                 <!--Balance-->
                <label title="Wallet Balance" for="lblDirectBuyBalance" class="col-sm-2 col-form-label  nsegreen text-right labelmiddle">Wallet Balance</label>
                
                <div title="Wallet Balance" class="col-sm-3">
                	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectBuyBalance" class="col-form-label labelmiddle"></label>
                    </div>                    
                </div>
               
               <!--Investor-->
                <label title="Investor" for="lblDirectBuyInvestor" class="col-sm-2 col-form-label nsegreen text-right">Investor<span class="redtext">*</span></label>
                
                <div title="Investor" class="col-sm-5">
                    <label id="lblDirectBuyInvestor" class="col-form-label labelmiddle"></label>
                </div>
            </div>
                        
            <!--Asset/No Of Tokens-->
             <div class="position-relative row form-group">
                <label title="Asset" for="lblDirectBuySymbol" class="col-sm-2 col-form-label nsegreen text-right labelmiddle">Asset</label>
                
                <div title="Asset" class="col-sm-3">
                    <label id="lblDirectBuySymbol" class="col-form-label redalerttext labelmiddle"></label>
                </div>
                
                
                <!--No Of Tokens-->
                <label title="Number of tokens to sell" for="txtDirectBuyQty" class="col-sm-2 col-form-label text-right nsegreen text-right">No Of Tokens<span class="redtext">*</span></label>
                
                <div title="Number of tokens to sell" class="col-sm-5">
                    <input type="text" class="form-control" placeholder="No Of Tokens To Buy" id="txtDirectBuyQty">
                </div>               
            </div>
            
            <!--Minimum Price/Maximum Price-->
            <div class="position-relative row form-group">
                <label title="Minimum Request Price" for="lblDirectBuyMinPrice" class="col-sm-2 col-form-label nsegreen text-right labelmiddle">Minimum Request Price</label>
                
                <div title="Minimum Request Price" class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                        <label id="lblDirectBuyMinPrice" class="col-form-label redalerttext labelmiddle"></label>
                    </div>                    
                </div>
                
                
                <!--Maximum Price-->
                <label title="Maximum Request Price" for="lblDirectBuyMaxPrice" class="col-sm-2 col-form-label text-right nsegreen text-right">Maximum Request Price</label>
                
                <div title="Maximum Request Price" class="col-sm-5">
                    <div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                        <label id="lblDirectBuyMaxPrice" class="col-form-label redalerttext labelmiddle"></label>
                    </div>
                </div>               
            </div>
            
            
            <!--Sellers Table-->
            <div class="position-relative row form-group">
                <div title="Asset Sellers" class="col-sm-12">
                    <table class="hover table table-bordered data-table display wrap" id="tabSellers">
                      <thead style="background-color:#585A18; color:#ffffff;">
                        <tr>
                            <th style="text-align:center" width="15%">ASSET</th>
                            <th style="text-align:center" width="16%">AVAILABLE&nbsp;QTY</th>
                            <th style="text-align:center" width="14%">PRICE</th> 
                            <th style="text-align:center" width="35%">BROKER</th>
                            <th style="text-align:center" width="10%"></th>                           
                        </tr>
                      </thead>
        
                      <tbody id="tbsellersbody"></tbody>
                    </table>        
                </div>             
            </div>
                        
           <div id="divDirectBuyAlert"></div>
        </form>
        
      </div>      
      
      <div class="modal-footer">
        <span class="redtext makebold size-16" style="float:left;"><i><span class="redtext">*</span>All transfers attract a transfer fee set by the payment processor. Transfer fees are borne by each transfer recipients.</i>
        </span>
        
        <span class="redtext makebold size-17" style="float:right;">
        	<button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
        </span>
      </div>
    </div>
  </div>
</div>
<!--End Direct Buy Popup-->

<!--Start Pix Popup-->
<div id="myPixModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog " role="document">
        <div class="modal-content" style="background-color:#000000; padding:0; width:100%;">
          <div class="modal-header" style="background-color:#363131;">              
              <span><h4 style="color:#ffffff; margin-right:39px; display:inline;" id="modPixTitle" class="modal-title">PICTURE</h4>
              <button style="color:#E1D4D4;" title="Click X to close the picture screen" type="button" class="close" data-dismiss="modal">×</button></span>
          </div>
          
          <div align="center" class="modal-body" style="padding:1px;">
          	<a style="border:none; color:#ffff00; font-style:italic; margin-bottom:0px; " id="ancBlockchainUrl" target="_blank"></a><br>
          
            <img class="modal-content" id="img01" style="margin-top:0; border:none; ">
          </div>
          
          <div class="modal-footer">
            <center><button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button></center>
          </div>
        </div>
      </div>
</div>
<!--End Pix Popup-->

</html>
