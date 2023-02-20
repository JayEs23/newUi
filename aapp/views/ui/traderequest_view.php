<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<title>Naija Art Market | Trade Request</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	
    <style>.nav-tabs > li.active > a, .nav-tabs > li > a:hover { border: none;  color: #A8AC2E !important; background: #fff; }</style>
    
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
		  width: 130%; /* Could be more or less, depending on screen size */
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
		
		tableprimary.dataTable tbody td {
		  vertical-align: middle;
		}
		
		table.dataTable tbody td {
		  vertical-align: middle;
		}
		
    </style>
        
    <script>
		var Title='<font color="#AF4442">Naija Art Mart Help</font>';
		var m='';
		var table,tableprimary,tablehistory;
		var Email='<?php echo $email; ?>';
		var Usertype='<?php echo $usertype; ?>';
		var BrokerId='<?php echo $broker_id; ?>';
		var InvestorId='<?php echo $investor_id; ?>';
		var BrokerName='<?php echo $broker_name; ?>';
		var RefreshInterval='<?php echo $RefreshInterval; ?>';
		RefreshInterval=parseInt(RefreshInterval,10) * 60 * 1000;
		var base_url="<?php echo base_url();?>";

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
		
		function DisplayRequestMessage(msg,msgtype,msgtitle,theme='AlertTheme')
		{
			try
			{//SuccessTheme, AlertTheme
				$('#divRequestAlert').html(msg).addClass(theme);
				
				
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
					$('#divRequestAlert').load(location.href + " #divRequestAlert").removeClass(theme);
				}, 10000);
			}catch(e)
			{
				alert('ERROR Displaying Message: '+e);
			}
		}
		
		function DisplaySecBuyMessage(msg,msgtype,msgtitle,theme='AlertTheme')
		{
			try
			{//SuccessTheme, AlertTheme
				$('#divSecBuyAlert').html(msg).addClass(theme);
				
				
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
					$('#divSecBuyAlert').load(location.href + " #divSecBuyAlert").removeClass(theme);
				}, 10000);
			}catch(e)
			{
				alert('DisplaySecBuyMessage ERROR Displaying Message: '+e);
			}
		}
		
		function DisplaySecSellMessage(msg,msgtype,msgtitle,theme='AlertTheme')
		{
			try
			{
				$('#divSecSellAlert').html(msg).addClass(theme);
				
				
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
					$('#divSecSellAlert').load(location.href + " #divSecSellAlert").removeClass(theme);
				}, 10000);
			}catch(e)
			{
				alert('DisplaySecSellMessage ERROR Displaying Message: '+e);
			}
		}
		
		$(document).ready(function(e) {
			$(function() {			
				$.blockUI.defaults.css = {};// clear out plugin default styling
			});
			
			$('[data-toggle="tooltip"]').tooltip();
						
			setInterval(function(){
				LoadPrimaryMarket();
			}, (RefreshInterval));
			
			setInterval(function(){
				LoadSecondaryMarket();
			}, (RefreshInterval));
			
			LoadSecondaryMarket();
			LoadPrimaryMarket();
	
			$(document).ajaxStop($.unblockUI);
			
			$('.datepicker').datepicker({
				weekStart: 1,
				todayBtn:  "linked",
				autoclose: 1,
				todayHighlight: 1,
				minViewMode: 1,//Months
				clearBtn: 1,
				forceParse: 0,
				daysOfWeekHighlighted: "0,6",
				//daysOfWeekDisabled: "0,6",
				format: 'M yyyy'
			});	
			
			setInterval(function() {
				updateClock();
			}, 1000);
			
			LoadPrimaryMarket();
			LoadRequestsHistory();
						
			function LoadSecondaryMarket()
			{
				try
				{
					$('#ancBlockchainUrl').html('').prop('href','').prop('title','');
					$('#ancBlockchainUrl').removeAttr('href');
					
					//$.blockUI({message: '<img src="<?php //echo base_url();?>images/loader.gif" /><p>Loading Market Data. Please Wait...</p>',theme: false,baseZ: 2000});
					
					//$('#tabSecondaryMarket > tbody').html('');
	
					$.ajax({
						url: "<?php echo site_url('ui/Traderequest/GetSecondaryMarketData');?>",
						type: 'POST',
						data: {usertype:Usertype, broker_id:BrokerId, investor_id:InvestorId},
						dataType: 'json',
						success: function(dataSet,status,xhr) {	
							$.unblockUI();
							
							if (table) table.destroy();
							
							//f-filtering, l-length, i-information, p-pagination
							table = $('#tabSecondaryMarket').DataTable( {
								dom: '<"top"if>rt<"bottom"lp><"clear">',
								responsive: true,
								ordering: false,
								autoWidth:false,
								language: {zeroRecords: "No Secondary Market Data Record Found"},
								lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
								columnDefs: [
									{
										"targets": [ 0,1,2,3,4,5,6,7,8 ],
										"visible": true
									},
									{
										"targets": [ 0,8 ],
										"orderable": false,
										"searchable": false
									},
									{
										"targets": [ 1,2,3,4,5,6,7 ],
										"searchable": true
									},
									{ className: "dt-center", "targets": [ 0,1,2,3,4,5,6,7,8 ] }
								],					
								order: [[ 2, 'asc' ]],
								data: dataSet, 
								columns: [
									{ width: "15%" },//Artwork Pix
									{ width: "12%" },//Symbol
									{ width: "10%" },//Open
									{ width: "10%" },//High
									{ width: "10%" },//Low
									{ width: "10%" },//Close
									{ width: "12%" },//Trades
									{ width: "13%" },//Volume
									{ width: "8%" }//Buy
									
								],//15,11,11,11,11,12,13,8,8
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
					m='LoadSecondaryMarket ERROR:\n'+e;
					DisplayMessage(m,'error',Title);
				}
			}
						
			function LoadPrimaryMarket()
			{
				try
				{
					$('#ancBlockchainUrl').html('').prop('href','').prop('title','');
					$('#ancBlockchainUrl').removeAttr('href');
					
					//$.blockUI({message: '<img src="<?php //echo base_url();?>images/loader.gif" /><p>Loading Market Data. Please Wait...</p>',theme: false,baseZ: 2000});
					
					//$('#tabPrimary > tbody').html('');
	
					$.ajax({
						url: "<?php echo site_url('ui/Primarymarket/GetMarketData');?>",
						type: 'POST',
						data: {usertype:Usertype},
						dataType: 'json',
						success: function(dataSet,status,xhr) {	
							$.unblockUI();
							
							if (tableprimary) tableprimary.destroy();
							
							//f-filtering, l-length, i-information, p-pagination
							tableprimary = $('#tabPrimary').DataTable( {
								dom: '<"top"if>rt<"bottom"lp><"clear">',
								responsive: true,
								ordering: false,
								autoWidth:false,
								language: {zeroRecords: "No Primary Market Data Record Found"},
								lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
								columnDefs: [
									{
										"targets": [ 0,1,2,3,4,5,6 ],
										"visible": true
									},
									{
										"targets": [ 0,6 ],
										"orderable": false,
										"searchable": false
									},
									{
										"targets": [ 1,2,3,4,5 ],
										"searchable": true
									},
									{ className: "dt-center", "targets": [ 0,1,2,3,4,5,6 ] }
								],					
								order: [[ 2, 'asc' ]],
								data: dataSet, 
								columns: [
									{ width: "19%" },//Artwork
									{ width: "16%" },//Artist
									{ width: "13%" },//Symbol
									{ width: "13%" },//Art Value
									{ width: "16%" },//Available Tokens
									{ width: "11%" },//Price
									{ width: "12%" }//Buy
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
					m='LoadPrimaryMarket ERROR:\n'+e;
					DisplayMessage(m,'error',Title);
				}
			}
			
			function LoadRequestsHistory()
			{
				try
				{
					//$.blockUI({message: '<img src="<?php //echo base_url();?>images/loader.gif" /><p>Loading Market Data. Please Wait...</p>',theme: false,baseZ: 2000});
					
					//$('#tabPrimary > tbody').html('');
	
					$.ajax({
						url: "<?php echo site_url('ui/Traderequest/GetRequestsHistory');?>",
						type: 'POST',
						data: {usertype:Usertype},
						dataType: 'json',
						success: function(dataSet,status,xhr) {	
							$.unblockUI();
							
							if (tablehistory) tablehistory.destroy();
							
							//f-filtering, l-length, i-information, p-pagination
							tablehistory = $('#tabHistory').DataTable( {
								dom: '<"top"if>rt<"bottom"lp><"clear">',
								responsive: true,
								ordering: false,
								autoWidth:false,
								language: {zeroRecords: "No Request Record Found"},
								lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
								columnDefs: [
									{
										"targets": [ 0,1,2,3,4,5,6,7 ],
										"visible": true
									},
									{
										"targets": [ 0 ],
										"orderable": false,
										"searchable": false
									},
									{
										"targets": [ 1,2,3,4,5,6,7 ],
										"searchable": true
									},
									{ className: "dt-center", "targets": [ 0,1,2,3,4,5,6,7 ] }
								],					
								order: [[ 2, 'asc' ]],
								data: dataSet, 
								columns: [
									{ width: "10%" },//Market Type
									{ width: "20%" },//Artwork
									{ width: "10%" },//Symbol
									{ width: "12%" },//Request Type
									{ width: "12%" },//No Of Tokens
									{ width: "12%" },//Min. Price
									{ width: "12%" },//Max. Price
									{ width: "12%" }//Market Price
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
					m='LoadRequestsHistory ERROR:\n'+e;
					DisplayMessage(m,'error',Title);
				}
			}
			
			$("#txtSecBuyQty").on("keyup",function(event)
			{
				try
				{
					ComputeSecBuyAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Secondary Buy Quantity Keyup ERROR:\n'+e;			
					DisplaySecBuyMessage(m, 'error',Title);
				}
			});	
			
			$("#txtSecBuyQty").on("change",function(event)
			{
				try
				{
					ComputeSecBuyAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Secondary Buy Quantity Changed ERROR:\n'+e;			
					DisplaySecBuyMessage(m, 'error',Title);
				}
			});			
			
			$("#txtSecBuyMaxPrice").on("keyup",function(event)
			{
				try
				{
					ComputeSecBuyAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Maximum Buy Price Keyup ERROR:\n'+e;			
					DisplaySecBuyMessage(m, 'error',Title);
				}
			});				
			
			$("#txtSecBuyMaxPrice").on("change",function(event)
			{
				try
				{
					ComputeSecBuyAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Maximum Buy Price Changed ERROR:\n'+e;			
					DisplaySecBuyMessage(m, 'error',Title);
				}
			});
			
			function ComputeSecBuyAmount()
			{
				try
				{
					$('#lblSecBuyBrokerFee').html('');					
					$('#lblSecBuyNSEFee').html('');
					$('#lblSecBuySMSFee').html('');
					$('#lblSecBuyTotalTradeAmount').html('');
					$('#lblSecBuyTradeAmount').html('');					
					
					var qty=$.trim($('#txtSecBuyQty').val()).replace(new RegExp(',', 'g'), '');					
					var price=$.trim($('#txtSecBuyMaxPrice').val()).replace(new RegExp(',', 'g'), '');				
					price=price.replace(new RegExp('₦', 'g'), '');
					
					var sms='<?php echo $sms_fee; ?>';
					var brokers_rate = '<?php echo $brokers_rate; ?>';
					var nse_rate = '<?php echo $nse_rate; ?>';					
					var amount = parseFloat(qty) * parseFloat(price);
					var brokerfee = (parseFloat(brokers_rate)/100) * amount;
					var nsefee = (parseFloat(nse_rate)/100) * amount;
					var total = parseFloat(amount) + parseFloat(brokerfee) + parseFloat(nsefee/2) + parseFloat((sms*2));
					
					$('#lblSecBuySMSFee').html('₦' + number_format((sms*2), 2, '.', ','));
					
					if (parseFloat(amount) > 0) $('#lblSecBuyTradeAmount').html('₦' + number_format(amount, 2, '.', ','));
					if (parseFloat(brokerfee) > 0) $('#lblSecBuyBrokerFee').html('₦' + number_format(brokerfee, 2, '.', ','));
					if (parseFloat(nsefee) > 0) $('#lblSecBuyNSEFee').html('₦' + number_format(nsefee/2, 2, '.', ','));
					if (parseFloat(total) > 0) $('#lblSecBuyTotalTradeAmount').html('₦' + number_format(total, 2, '.', ','));
				}catch(e)
				{
					$.unblockUI();
					m='ComputeSecBuyAmount ERROR:\n'+e;			
					DisplaySecBuyMessage(m, 'error',Title);
				}
			}		
												
			$("#txtRequestQty").on("keyup",function(event)
			{
				try
				{
					ComputeRequestAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Request Quantity Keyup ERROR:\n'+e;			
					DisplayRequestMessage(m, 'error',Title);
				}
			});
			
			$("#txtRequestQty").on("change",function(event)
			{
				try
				{
					ComputeRequestAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Request Quantity Changed ERROR:\n'+e;			
					DisplayRequestMessage(m, 'error',Title);
				}
			});	
			
			function ComputeRequestAmount()
			{
				try
				{
					$('#lblRequestBrokerFee').html('');					
					$('#lblRequestNSEFee').html('');
					$('#lblRequestSMSFee').html('');
					$('#lblRequestTotalTradeAmount').html('');
					$('#lblRequestTradeAmount').html('');					
					
					var qty=$.trim($('#txtRequestQty').val()).replace(new RegExp(',', 'g'), '');					
					var price=$.trim($('#lblRequestlMarketPrice').html()).replace(new RegExp(',', 'g'), '');				
					price=price.replace(new RegExp('₦', 'g'), '');
					
					var sms='<?php echo $sms_fee; ?>';
					var brokers_rate = '<?php echo $brokers_rate; ?>';
					var nse_rate = '<?php echo $nse_rate; ?>';					
					var amount = parseFloat(qty) * parseFloat(price);
					var brokerfee = (parseFloat(brokers_rate)/100) * amount;
					var nsefee = (parseFloat(nse_rate)/100) * amount;
					var total = parseFloat(amount) + parseFloat(brokerfee) + parseFloat(nsefee/2) + parseFloat((sms*2));
					
					$('#lblRequestSMSFee').html('₦' + number_format((sms*2), 2, '.', ','));
					
					if (parseFloat(amount) > 0) $('#lblRequestTradeAmount').html('₦' + number_format(amount, 2, '.', ','));
					if (parseFloat(brokerfee) > 0) $('#lblRequestBrokerFee').html('₦' + number_format(brokerfee, 2, '.', ','));
					if (parseFloat(nsefee) > 0) $('#lblRequestNSEFee').html('₦' + number_format(nsefee/2, 2, '.', ','));
					if (parseFloat(total) > 0) $('#lblRequestTotalTradeAmount').html('₦' + number_format(total, 2, '.', ','));
				}catch(e)
				{
					$.unblockUI();
					m='ComputeRequestAmount ERROR:\n'+e;			
					DisplayRequestMessage(m, 'error',Title);
				}
			}
			
			$("#divBuyModal").on('hidden.bs.modal', function(){
				try
				{
					ResetBuy();
				}catch(e)
				{
					$.unblockUI();
					m='Modal Close ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			});
						
			
			function CheckRequest()
			{
				try
				{
					var sym=$.trim($('#lblRequestSymbol').html());					
					var avtok=$.trim($('#lblRequestAvailableTokens').html()).replace(new RegExp(',', 'g'), '');			
					var pr=$.trim($('#lblRequestlMarketPrice').html()).replace(new RegExp(',', 'g'), '');				
					pr = pr.replace(new RegExp('₦', 'g'), '');
					
					var qty=$.trim($('#txtRequestQty').val()).replace(new RegExp(',', 'g'), '');
					
					var sms=$.trim($('#lblRequestSMSFee').html()).replace(new RegExp(',', 'g'), '');
					sms = sms.replace(new RegExp('₦', 'g'), '');
					
					var brfee=$.trim($('#lblRequestBrokerFee').html()).replace(new RegExp(',', 'g'), '');				
					brfee=brfee.replace(new RegExp('₦', 'g'), '');
					
					var nse=$.trim($('#lblRequestNSEFee').html()).replace(new RegExp(',', 'g'), '');				
					nse=nse.replace(new RegExp('₦', 'g'), '');
					
					var tot=$.trim($('#lblRequestTotalTradeAmount').html()).replace(new RegExp(',', 'g'), '');				
					tot=tot.replace(new RegExp('₦', 'g'), '');
					
					
					//User Email
					if (!Email)
					{
						m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request.';						
	
						DisplayRequestMessage(m, 'error',Title);				
	
						return false;
					}				
									
					//Symbol
					if (!sym)
					{
						m='No asset is displaying. Refresh the page or logout and login again before continuing.';
						DisplayRequestMessage(m, 'error',Title);					
						return false;
					}
					
					//Available tokens
					if (!avtok)
					{
						m='Available tokens field MUST not be blank. Refresh the page or logout and login again before continuing.';				
						DisplayRequestMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(avtok))
					{
						m='Available tokens MUST be a number. Current entry <b>'+avtok+'</b> is not valid.';						
						DisplayRequestMessage(m, 'error',Title);
						return false;
					}
	
					if (parseInt(avtok) == 0)
					{
						m='Available token is zero. The asset does not have any more token to sell.';				
						DisplayRequestMessage(m, 'error',Title);
						return false;
					}
					
					if (parseInt(avtok) < 0)
					{
						m='Available tokens must not be a negative number.';				
						DisplayRequestMessage(m, 'error',Title);
						return false;
					}
					
					//Market price
					if (!pr)
					{
						m='Price per token (market price) field MUST not be blank. Refresh the page or logout and login again before continuing.';				
						DisplayRequestMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(pr))
					{
						m='Price per token (market price) MUST be a number.';						
						DisplayRequestMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(pr) == 0)
					{
						m='Price per token (market price) must not be zero.';				
						DisplayRequestMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(pr) < 0)
					{
						m='Price per token (market price) must not be a negative number.';				
						DisplayRequestMessage(m, 'error',Title);
						return false;
					}	
					
					//Qty to buy
					if (!qty)
					{
						m='Quantity of tokens to buy field MUST not be blank.';				
						DisplayRequestMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(qty))
					{
						m='Quantity of tokens to buy MUST be a number. Current entry <b>'+qty+'</b> is not valid.';						
						DisplayRequestMessage(m, 'error',Title);
						return false;
					}
	
					if (parseInt(qty) == 0)
					{
						m='Quantity of tokens to buy must not be zero.';				
						DisplayRequestMessage(m, 'error',Title);
						return false;
					}
					
					if (parseInt(qty) < 0)
					{
						m='Quantity of tokens to buy must not be a negative number.';				
						DisplayRequestMessage(m, 'error',Title);
						return false;
					}								
				
					if (parseInt(qty) > parseInt(avtok))
					{
						m="The quantity of the asset you have entered to buy, <b>" + number_format(qty,0,'',',') + "</b>, is more than the available number of tokens for sale which is <b>" + number_format(avtok,0,'',',') + "</b>.";
						
						DisplayRequestMessage(m, 'error',Title);
						return false;
					}				
					
					//Total Trade Amount 
					if (!tot)
					{
						m='Total Trade Amount is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayRequestMessage(m, 'error',Title);				
	
						return false;
					}																
									
					//sms Fee
					if (!sms)
					{
						m='SMS fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayRequestMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Broker
					if (!brfee)
					{
						m='Broker fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayRequestMessage(m, 'error',Title);				
	
						return false;
					}
					
					//NSE Fee
					if (!nse)
					{
						m='NSE fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayRequestMessage(m, 'error',Title);				
	
						return false;
					}			
					
					
					//Confirm Update				
					Swal.fire({
					  title: 'PLEASE CONFIRM',
					  html: '<font size="3" face="Arial">Do you want to proceed with the request to buy this asset?</font>',
					  type: 'question',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  cancelButtonText: '<font size="3" face="Arial">No</font>',
					  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
					}).then((result) => {
					  if (result.value)
					  {
						$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Requesting A Buy. Please Wait...</p>',theme: false,baseZ: 2000});

					var mdata={email:Email, broker_id:BrokerId, brokername:BrokerName, investor_id:InvestorId, symbol:sym, marketprice:pr, tokens:qty, brokerfee:brfee, nsefee:nse, sms_fee:sms}						
									
						//Make Ajax Request			
						$.ajax({
							url: '<?php echo site_url('ui/Primarymarket/RequestBuy'); ?>',
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
											$('#lblRequestBrokerFee').html('');					
											$('#lblRequestNSEFee').html('');
											$('#lblRequestSMSFee').html('');
											$('#lblRequestTotalTradeAmount').html('');
											$('#lblRequestTradeAmount').html('');
											$('#txtRequestQty').val('');
											
											if ($.trim(e.Message) != '')
											{
												m=e.Message;
											}else
											{
												m= 'Request for broker to buy '+number_format(qty, '0', '', ',') + ' tokens of '+ $.trim(sym).toUpperCase() +' was successful. An email has been sent to the broker.';
											}
											
											DisplayRequestMessage(m, 'success','Buy Request Made','SuccessTheme');
											LoadRequestsHistory();
											LoadPrimaryMarket();											
										}else
										{
											m=e.Message;
											
											DisplayRequestMessage(m,'error',Title);		
										}
										
										return;
									});//End each
								}
							},
							error:  function(xhr,status,error) {
								m='Error '+ xhr.status + ' Occurred: ' + error
								DisplayRequestMessage(m,'error',Title);
							}
						});
					  }
					})	
				}catch(e)
				{
					$.unblockUI();
					m='CheckRequest ERROR:\n'+e;				
					DisplayRequestMessage(m, 'error',Title);
				}		
			}//End CheckRequest
			
			$('#btnRequest').click(function(e) {
                try
				{
					$('#divRequestAlert').html('');			
					if (!CheckRequest()) return false;
				}catch(e)
				{
					$.unblockUI();
					m='Request Button Click ERROR:\n'+e;				
					DisplayRequestMessage(m, 'error',Title);
				}
            });
			
			$('#btnSecBuy').click(function(e) {
                try
				{
					$('#divSecBuyAlert').html('');			
					if (!CheckSecondaryBuy()) return false;
				}catch(e)
				{
					$.unblockUI();
					m='Secondary Buy Request Button Click ERROR:\n'+e;				
					DisplaySecBuyMessage(m, 'error',Title);
				}
            });
			
			function CheckSecondaryBuy()
			{
				try
				{				
					var sym=$.trim($('#lblSecBuySymbol').html());
					var brokername=$.trim($('#lblSecBuyBroker').html());
					
					var mktpr=$.trim($('#lblSecBuyMarketPrice').html()).replace(new RegExp(',', 'g'), '');				
					mktpr = mktpr.replace(new RegExp('₦', 'g'), '');
					
					var minpr=$.trim($('#txtSecBuyMinPrice').val()).replace(new RegExp(',', 'g'), '');				
					minpr = minpr.replace(new RegExp('₦', 'g'), '');
					
					var maxpr=$.trim($('#txtSecBuyMaxPrice').val()).replace(new RegExp(',', 'g'), '');				
					maxpr = maxpr.replace(new RegExp('₦', 'g'), '');
					
					var qty=$.trim($('#txtSecBuyQty').val()).replace(new RegExp(',', 'g'), '');
					
					var sms=$.trim($('#lblSecBuySMSFee').html()).replace(new RegExp(',', 'g'), '');
					sms = sms.replace(new RegExp('₦', 'g'), '');
					
					var brfee=$.trim($('#lblSecBuyBrokerFee').html()).replace(new RegExp(',', 'g'), '');				
					brfee=brfee.replace(new RegExp('₦', 'g'), '');
					
					var nse=$.trim($('#lblSecBuyNSEFee').html()).replace(new RegExp(',', 'g'), '');				
					nse=nse.replace(new RegExp('₦', 'g'), '');
					
					var tot=$.trim($('#lblSecBuyTotalTradeAmount').html()).replace(new RegExp(',', 'g'), '');				
					tot=tot.replace(new RegExp('₦', 'g'), '');
					
					var price_limit_percent = '<?php echo $price_limit_percent; ?>';
					
					
					//User Email
					if (!Email)
					{
						m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request.';						
	
						DisplaySecBuyMessage(m, 'error',Title);				
	
						return false;
					}				
									
					//Symbol
					if (!sym)
					{
						m='No asset is displaying. Refresh the page or logout and login again before continuing.';
						DisplaySecBuyMessage(m, 'error',Title);					
						return false;
					}
										
					//Minimum buying price
					if (!minpr)
					{
						m='Minimum buying price field MUST not be blank.';				
						DisplaySecBuyMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(minpr))
					{
						m='Minimum buying price MUST be a number.';						
						DisplaySecBuyMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(minpr) == 0)
					{
						m='Minimum buying price must not be zero.';				
						DisplaySecBuyMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(minpr) < 0)
					{
						m='Minimum buying price must not be a negative number.';				
						DisplaySecBuyMessage(m, 'error',Title);
						return false;
					}					
					
					//Check price limit for minimum price					
					var diff=(parseFloat(price_limit_percent)/100) * parseFloat(mktpr);					
					var lowerlimit = parseFloat(mktpr) - parseFloat(diff);
					var upperlimit = parseFloat(mktpr) + parseFloat(diff);	
					
					if (parseFloat(minpr) < parseFloat(lowerlimit))//Exceeded lower limit
					{
						m="The minimum buying price, <b>₦" + number_format(minpr,2,'.',',') + "</b>, is less than the lower price limit of <b>₦" + number_format(lowerlimit,2,'.',',') + "</b> allowed for the asset. Please enter a valid minimum buying price.";
						
						DisplaySecBuyMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(minpr) > parseFloat(upperlimit))//Exceeded upper limit
					{
						m="The minimum buying price, <b>₦" + number_format(minpr,2,'.',',') + "</b>, is more than the upper price limit of <b>₦" + number_format(upperlimit,2,'.',',') + "</b> allowed for the asset. Please enter a valid minimum buying price.";
						
						DisplaySecBuyMessage(m, 'error',Title);
						return false;
					}
					
					
					//Maximum Buy price
					if (!maxpr)
					{
						m='Maximum buying price field MUST not be blank.';				
						DisplaySecBuyMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(maxpr))
					{
						m='Maximum buying price MUST be a number.';						
						DisplaySecBuyMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(maxpr) == 0)
					{
						m='Maximum buying price must not be zero.';				
						DisplaySecBuyMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(maxpr) < 0)
					{
						m='Maximum buying price must not be a negative number.';				
						DisplaySecBuyMessage(m, 'error',Title);
						return false;
					}
					
					//Check price limit for maximum price					
					if (parseFloat(maxpr) < parseFloat(lowerlimit))//Exceeded lower limit
					{
						m="The maximum buying price, <b>₦" + number_format(maxpr,2,'.',',') + "</b>, is less than the lower price limit of <b>₦" + number_format(lowerlimit,2,'.',',') + "</b> allowed for the asset. Please enter a valid maximum buying price.";
						
						DisplaySecBuyMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(maxpr) > parseFloat(upperlimit))//Exceeded upper limit
					{
						m="The maximum buying price, <b>₦" + number_format(maxpr,2,'.',',') + "</b>, is more than the upper price limit of <b>₦" + number_format(upperlimit,2,'.',',') + "</b> allowed for the asset. Please enter a valid maximum buying price.";
						
						DisplaySecBuyMessage(m, 'error',Title);
						return false;
					}
					
					//Minimun must not be greater than maximum
					if (parseFloat(minpr) > parseFloat(maxpr))
					{
						m='Minimun buying price MUST NOT be greater than maximum buying price.';				
						DisplaySecBuyMessage(m, 'error',Title);
						return false;
					}
					
					//Qty to buy
					if (!qty)
					{
						m='Quantity of tokens to buy field MUST not be blank.';				
						DisplaySecBuyMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(qty))
					{
						m='Quantity of tokens to buy MUST be a number. Current entry <b>'+qty+'</b> is not valid.';						
						DisplaySecBuyMessage(m, 'error',Title);
						return false;
					}
	
					if (parseInt(qty) == 0)
					{
						m='Quantity of tokens to buy must not be zero.';				
						DisplaySecBuyMessage(m, 'error',Title);
						return false;
					}
					
					if (parseInt(qty) < 0)
					{
						m='Quantity of tokens to buy must not be a negative number.';				
						DisplaySecBuyMessage(m, 'error',Title);
						return false;
					}								
				
					//Total Trade Amount 
					if (!tot)
					{
						m='Total Trade Amount is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplaySecBuyMessage(m, 'error',Title);				
	
						return false;
					}																
									
					//sms Fee
					if (!sms)
					{
						m='SMS fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplaySecBuyMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Broker
					if (!brfee)
					{
						m='Broker fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplaySecBuyMessage(m, 'error',Title);				
	
						return false;
					}
					
					//NSE Fee
					if (!nse)
					{
						m='NSE fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplaySecBuyMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Check if the request
					var mdata={broker_id:BrokerId, investor_id:InvestorId, symbol:sym, max_price:maxpr, min_price:minpr, tokens:qty};
					
					$.ajax({
						url: '<?php echo site_url('ui/Traderequest/CheckIfSecBuyExists'); ?>',
						data: mdata,
						type: 'POST',
						dataType: 'text',
						async:false,
						success: function(data,status,xhr) {				
							$.unblockUI();
							
							mdata={email:Email, broker_id:BrokerId, brokername:BrokerName, investor_id:InvestorId, symbol:sym, marketprice:mktpr, max_price:maxpr , min_price:minpr ,tokens:qty, brokerfee:brfee, nsefee:nse, sms_fee:sms};
							
							if (parseInt(data)==1)
							{
								//Post				
								Swal.fire({
								  title: 'CONTINUE WITH REQUEST?',
								  html: '<font size="3" face="Arial">The request to buy <b>'+qty+'</b> tokens of <b>'+sym+'</b> has already been made by you today. Do you want to make a different request for the asset now?</font>',
								  type: 'question',
								  showCancelButton: true,
								  confirmButtonColor: '#3085d6',
								  cancelButtonColor: '#d33',
								  cancelButtonText: '<font size="3" face="Arial">No</font>',
								  confirmButtonText: '<font size="3" face="Arial">Yes</font>'
								}).then((result) => {
								  if (result.value) PostSecBuy(mdata);//Post the request
								})		
							}else
							{
								PostSecBuy(mdata);
							}
						}
					});
					
				}catch(e)
				{
					$.unblockUI();
					m='CheckSecondaryBuy ERROR:\n'+e;				
					DisplaySecBuyMessage(m, 'error',Title);
				}		
			}//End CheckSecondaryBuy
			
			function PostSecBuy(mdata)
			{
				try
				{
					//Post				
					Swal.fire({
					  title: 'PLEASE CONFIRM',
					  html: '<font size="3" face="Arial">Do you want to proceed with the request to buy this asset from the secondary market?</font>',
					  type: 'question',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  cancelButtonText: '<font size="3" face="Arial">No</font>',
					  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
					}).then((result) => {
					  if (result.value)
					  {
						$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Requesting A Buy. Please Wait...</p>',theme: false,baseZ: 2000});										
									
						//Make Ajax Request			
						$.ajax({
							url: '<?php echo site_url('ui/Traderequest/RequestSecBuy'); ?>',
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
											$('#lblSecBuyBrokerFee').html('');					
											$('#lblSecBuyNSEFee').html('');
											$('#lblSecBuySMSFee').html('');
											$('#lblSecBuyTotalTradeAmount').html('');
											$('#lblSecBuyTradeAmount').html('');
											$('#txtSecBuyQty').val('');
											$('#txtSecBuyMaxPrice').val('');
											$('#txtSecBuyMinPrice').val('');
											$('#lblSecBuySymbol').html('');											
											
											if ($.trim(e.Message) != '')
											{
												m=e.Message;
											}else
											{
												m= 'Request for broker to buy <b>'+number_format(mdata.tokens, '0', '', ',') + '</b> tokens of <b>'+ $.trim(mdata.symbol).toUpperCase() +'</b> was successful. An email has been sent to the broker.';
											}
											
											DisplaySecBuyMessage(m, 'success','Buy Request Made','SuccessTheme');
											LoadRequestsHistory();
											LoadSecondaryMarket();											
										}else
										{
											m=e.Message;
											
											DisplaySecBuyMessage(m,'error',Title);		
										}
										
										return;
									});//End each
								}
							},
							error:  function(xhr,status,error) {
								m='Error '+ xhr.status + ' Occurred: ' + error
								DisplaySecBuyMessage(m,'error',Title);
							}
						});
					  }
					})
				}catch(e)
				{
					$.unblockUI();
					m='PostSecBuy ERROR:\n'+e;				
					DisplaySecBuyMessage(m, 'error',Title);
				}
			}
			
			//Sec Sell
			$("#txtSecSellQty").on("keyup",function(event)
			{
				try
				{
					ComputeSecSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Secondary Sell Quantity Keyup ERROR:\n'+e;			
					DisplaySecSellMessage(m, 'error',Title);
				}
			});	
			
			$("#txtSecSellQty").on("change",function(event)
			{
				try
				{
					ComputeSecSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Secondary Sell Quantity Changed ERROR:\n'+e;			
					DisplaySecSellMessage(m, 'error',Title);
				}
			});			
			
			$("#txtSecSellMaxPrice").on("keyup",function(event)
			{
				try
				{
					ComputeSecSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Maximum Sell Price Keyup ERROR:\n'+e;			
					DisplaySecSellMessage(m, 'error',Title);
				}
			});				
			
			$("#txtSecSellMaxPrice").on("change",function(event)
			{
				try
				{
					ComputeSecSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Maximum Sell Price Changed ERROR:\n'+e;			
					DisplaySecSellMessage(m, 'error',Title);
				}
			});
			
			function ComputeSecSellAmount()
			{
				try
				{
					$('#lblSecSellBrokerFee').html('');					
					$('#lblSecSellNSEFee').html('');
					$('#lblSecSellSMSFee').html('');
					$('#lblSecSellTotalTradeAmount').html('');
					$('#lblSecSellTradeAmount').html('');					
					
					var qty=$.trim($('#txtSecSellQty').val()).replace(new RegExp(',', 'g'), '');					
					var price=$.trim($('#txtSecSellMaxPrice').val()).replace(new RegExp(',', 'g'), '');				
					price=price.replace(new RegExp('₦', 'g'), '');
					
					var sms='<?php echo $sms_fee; ?>';
					var brokers_rate = '<?php echo $brokers_rate; ?>';
					var nse_rate = '<?php echo $nse_rate; ?>';					
					var amount = parseFloat(qty) * parseFloat(price);
					var brokerfee = (parseFloat(brokers_rate)/100) * amount;
					var nsefee = (parseFloat(nse_rate)/100) * amount;
					var total = parseFloat(amount) + parseFloat(brokerfee) + parseFloat(nsefee/2) + parseFloat((sms*2));
					
					$('#lblSecSellSMSFee').html('₦' + number_format((sms*2), 2, '.', ','));
					
					if (parseFloat(amount) > 0) $('#lblSecSellTradeAmount').html('₦' + number_format(amount, 2, '.', ','));
					if (parseFloat(brokerfee) > 0) $('#lblSecSellBrokerFee').html('₦' + number_format(brokerfee, 2, '.', ','));
					if (parseFloat(nsefee) > 0) $('#lblSecSellNSEFee').html('₦' + number_format(nsefee/2, 2, '.', ','));
					if (parseFloat(total) > 0) $('#lblSecSellTotalTradeAmount').html('₦' + number_format(total, 2, '.', ','));
				}catch(e)
				{
					$.unblockUI();
					m='ComputeSecSellAmount ERROR:\n'+e;			
					DisplaySecSellMessage(m, 'error',Title);
				}
			}
			
			$('#btnSecSell').click(function(e) {
                try
				{
					$('#divSecSellAlert').html('');			
					if (!CheckSecondarySell()) return false;
				}catch(e)
				{
					$.unblockUI();
					m='Secondary Sell Request Button Click ERROR:\n'+e;				
					DisplaySecSellMessage(m, 'error',Title);
				}
            });
			
			function CheckSecondarySell()
			{
				try
				{				
					var sym=$.trim($('#lblSecSellSymbol').html());
					var brokername=$.trim($('#lblSecSellBroker').html());
					
					var mktpr=$.trim($('#lblSecSellMarketPrice').html()).replace(new RegExp(',', 'g'), '');				
					mktpr = mktpr.replace(new RegExp('₦', 'g'), '');
					
					var minpr=$.trim($('#txtSecSellMinPrice').val()).replace(new RegExp(',', 'g'), '');				
					minpr = minpr.replace(new RegExp('₦', 'g'), '');
					
					var maxpr=$.trim($('#txtSecSellMaxPrice').val()).replace(new RegExp(',', 'g'), '');				
					maxpr = maxpr.replace(new RegExp('₦', 'g'), '');
					
					var avqty=$.trim($('#lblSecSellAvailQty').html()).replace(new RegExp(',', 'g'), '');
					
					var qty=$.trim($('#txtSecSellQty').val()).replace(new RegExp(',', 'g'), '');
					
					var sms=$.trim($('#lblSecSellSMSFee').html()).replace(new RegExp(',', 'g'), '');
					sms = sms.replace(new RegExp('₦', 'g'), '');
					
					var brfee=$.trim($('#lblSecSellBrokerFee').html()).replace(new RegExp(',', 'g'), '');				
					brfee=brfee.replace(new RegExp('₦', 'g'), '');
					
					var nse=$.trim($('#lblSecSellNSEFee').html()).replace(new RegExp(',', 'g'), '');				
					nse=nse.replace(new RegExp('₦', 'g'), '');
					
					var tot=$.trim($('#lblSecSellTotalTradeAmount').html()).replace(new RegExp(',', 'g'), '');				
					tot=tot.replace(new RegExp('₦', 'g'), '');
					
					var price_limit_percent = '<?php echo $price_limit_percent; ?>';
					
					
					//User Email
					if (!Email)
					{
						m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request.';						
	
						DisplaySecSellMessage(m, 'error',Title);				
	
						return false;
					}				
									
					//Symbol
					if (!sym)
					{
						m='No asset is displaying. Refresh the page or logout and login again before continuing.';
						DisplaySecSellMessage(m, 'error',Title);					
						return false;
					}
										
					//Minimum selling price
					if (!minpr)
					{
						m='Minimum selling price field MUST not be blank.';				
						DisplaySecSellMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(minpr))
					{
						m='Minimum selling price MUST be a number.';						
						DisplaySecSellMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(minpr) == 0)
					{
						m='Minimum selling price must not be zero.';				
						DisplaySecSellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(minpr) < 0)
					{
						m='Minimum selling price must not be a negative number.';				
						DisplaySecSellMessage(m, 'error',Title);
						return false;
					}
					
					//Check price limit for minimum price					
					var diff=(parseFloat(price_limit_percent)/100) * parseFloat(mktpr);					
					var lowerlimit = parseFloat(mktpr) - parseFloat(diff);
					var upperlimit = parseFloat(mktpr) + parseFloat(diff);	
					
					if (parseFloat(minpr) < parseFloat(lowerlimit))//Exceeded lower limit
					{
						m="The minimum selling price, <b>₦" + number_format(minpr,2,'.',',') + "</b>, is less than the lower price limit of <b>₦" + number_format(lowerlimit,2,'.',',') + "</b> allowed for the asset. Please enter a valid minimum selling price.";
						
						DisplaySecSellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(minpr) > parseFloat(upperlimit))//Exceeded upper limit
					{
						m="The minimum selling price, <b>₦" + number_format(minpr,2,'.',',') + "</b>, is more than the upper price limit of <b>₦" + number_format(upperlimit,2,'.',',') + "</b> allowed for the asset. Please enter a valid minimum selling price.";
						
						DisplaySecSellMessage(m, 'error',Title);
						return false;
					}
					
					//Maximum Sell price
					if (!maxpr)
					{
						m='Maximum selling price field MUST not be blank.';				
						DisplaySecSellMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(maxpr))
					{
						m='Maximum selling price MUST be a number.';						
						DisplaySecSellMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(maxpr) == 0)
					{
						m='Maximum selling price must not be zero.';				
						DisplaySecSellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(maxpr) < 0)
					{
						m='Maximum selling price must not be a negative number.';				
						DisplaySecSellMessage(m, 'error',Title);
						return false;
					}
					
					//Check price limit for maximum price					
					if (parseFloat(maxpr) < parseFloat(lowerlimit))//Exceeded lower limit
					{
						m="The maximum selling price, <b>₦" + number_format(maxpr,2,'.',',') + "</b>, is less than the lower price limit of <b>₦" + number_format(lowerlimit,2,'.',',') + "</b> allowed for the asset. Please enter a valid maximum selling price.";
						
						DisplaySecSellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(maxpr) > parseFloat(upperlimit))//Exceeded upper limit
					{
						m="The maximum selling price, <b>₦" + number_format(maxpr,2,'.',',') + "</b>, is more than the upper price limit of <b>₦" + number_format(upperlimit,2,'.',',') + "</b> allowed for the asset. Please enter a valid maximum selling price.";
						
						DisplaySecSellMessage(m, 'error',Title);
						return false;
					}
					
					//Minimun must not be greater than maximum
					if (parseFloat(minpr) > parseFloat(maxpr))
					{
						m='Minimun selling price MUST NOT be greater than maximum selling price.';				
						DisplaySecSellMessage(m, 'error',Title);
						return false;
					}
					
					//Available Qty
					if (!avqty)
					{
						m='Available quantity of tokens to sell field MUST not be blank.';				
						DisplaySecSellMessage(m, 'error',Title);					
						return false;
					}
					
					if (parseInt(avqty) <= 0)
					{
						m='Available quantity of tokens to sell must be greater than zero.';				
						DisplaySecSellMessage(m, 'error',Title);
						return false;
					}
					
					//Qty to sell
					if (!qty)
					{
						m='Quantity of tokens to sell field MUST not be blank.';				
						DisplaySecSellMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(qty))
					{
						m='Quantity of tokens to sell MUST be a number. Current entry <b>'+qty+'</b> is not valid.';						
						DisplaySecSellMessage(m, 'error',Title);
						return false;
					}
	
					if (parseInt(qty) == 0)
					{
						m='Quantity of tokens to sell must not be zero.';				
						DisplaySecSellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseInt(qty) < 0)
					{
						m='Quantity of tokens to sell must not be a negative number.';				
						DisplaySecSellMessage(m, 'error',Title);
						return false;
					}
					
					//Qty to sell must not be greater than the available qty
					if (parseInt(qty) > parseInt(avqty))
					{
						m='The quantity of asset to sell MUST NOT be greater than the quantity of asset available in your portfolio.';				
						DisplaySecSellMessage(m, 'error',Title);
						return false;
					}						
				
					//Total Trade Amount 
					if (!tot)
					{
						m='Total Trade Amount is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplaySecSellMessage(m, 'error',Title);				
	
						return false;
					}																
									
					//sms Fee
					if (!sms)
					{
						m='SMS fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplaySecSellMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Broker
					if (!brfee)
					{
						m='Broker fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplaySecSellMessage(m, 'error',Title);				
	
						return false;
					}
					
					//NSE Fee
					if (!nse)
					{
						m='NSE fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplaySecSellMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Check if the request exists
					var mdata={broker_id:BrokerId, investor_id:InvestorId, symbol:sym, max_price:maxpr, min_price:minpr, tokens:qty};
					
					$.ajax({
						url: '<?php echo site_url('ui/Traderequest/CheckIfSecSellExists'); ?>',
						data: mdata,
						type: 'POST',
						dataType: 'text',
						async:false,
						success: function(data,status,xhr) {				
							$.unblockUI();
							
							mdata={email:Email, broker_id:BrokerId, brokername:BrokerName, investor_id:InvestorId, symbol:sym, marketprice:mktpr, max_price:maxpr , min_price:minpr ,tokens:qty, brokerfee:brfee, nsefee:nse, sms_fee:sms};
							
							if (parseInt(data)==1)
							{
								//Post				
								Swal.fire({
								  title: 'CONTINUE WITH REQUEST?',
								  html: '<font size="3" face="Arial">The request to sell <b>'+qty+'</b> tokens of <b>'+sym+'</b> has already been made by you today. Do you want to make a different request for the asset now?</font>',
								  type: 'question',
								  showCancelButton: true,
								  confirmButtonColor: '#3085d6',
								  cancelButtonColor: '#d33',
								  cancelButtonText: '<font size="3" face="Arial">No</font>',
								  confirmButtonText: '<font size="3" face="Arial">Yes</font>'
								}).then((result) => {
								  if (result.value) PostSecSell(mdata);//Post the request
								})		
							}else
							{
								PostSecSell(mdata);
							}
						}
					});
					
				}catch(e)
				{
					$.unblockUI();
					m='CheckSecondarySell ERROR:\n'+e;				
					DisplaySecSellMessage(m, 'error',Title);
				}		
			}//End CheckSecondarySell
			
			function PostSecSell(mdata)
			{
				try
				{
					//Post				
					Swal.fire({
					  title: 'PLEASE CONFIRM',
					  html: '<font size="3" face="Arial">Do you want to proceed with the request to sell this asset from the secondary market?</font>',
					  type: 'question',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  cancelButtonText: '<font size="3" face="Arial">No</font>',
					  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
					}).then((result) => {
					  if (result.value)
					  {
						$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Requesting A Sell. Please Wait...</p>',theme: false,baseZ: 2000});										
									
						//Make Ajax Request			
						$.ajax({
							url: '<?php echo site_url('ui/Traderequest/RequestSecSell'); ?>',
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
											$('#lblSecSellBrokerFee').html('');					
											$('#lblSecSellNSEFee').html('');
											$('#lblSecSellSMSFee').html('');
											$('#lblSecSellTotalTradeAmount').html('');
											$('#lblSecSellTradeAmount').html('');
											$('#txtSecSellQty').val('');
											$('#txtSecSellMaxPrice').val('');
											$('#txtSecSellMinPrice').val('');
											$('#lblSecSellSymbol').html('');											
											
											if ($.trim(e.Message) != '')
											{
												m=e.Message;
											}else
											{
												m= 'Request for broker to sell <b>'+number_format(mdata.tokens, '0', '', ',') + '</b> tokens of <b>'+ $.trim(mdata.symbol).toUpperCase() +'</b> was successful. An email has been sent to the broker.';
											}
											
											DisplaySecSellMessage(m, 'success','Sell Request Made','SuccessTheme');
											LoadRequestsHistory();
											LoadSecondaryMarket();											
										}else
										{
											m=e.Message;
											
											DisplaySecSellMessage(m,'error',Title);		
										}
										
										return;
									});//End each
								}
							},
							error:  function(xhr,status,error) {
								m='Error '+ xhr.status + ' Occurred: ' + error
								DisplaySecSellMessage(m,'error',Title);
							}
						});
					  }
					})
				}catch(e)
				{
					$.unblockUI();
					m='PostSecSell ERROR:\n'+e;				
					DisplaySecSellMessage(m, 'error',Title);
				}
			}
			
        });//End document ready
		
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
			
		function ResetRequest()
		{
			try
			{
				$('#lblRequestSymbol').html('');
				$('#lblRequestAvailableTokens').html('');
				$('#lblRequestlMarketPrice').html('');
				$('#txtRequestQty').val('');
				$('#lblRequestTradeAmount').html('');
				$('#lblRequestBrokerFee').html('');
				$('#lblRequestNSEFee').html('');
				$('#lblRequestBroker').html('');
				$('#lblRequestSMSFee').html('');
				$('#lblRequestTotalTradeAmount').html('');
			}catch(e)
			{
				$.unblockUI();
				m='ResetRequest ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		}
		
		function ResetSecBuy()
		{
			try
			{
				$('#lblSecBuySymbol').html('');
				$('#lblSecBuyMarketPrice').html('');
				$('#txtSecBuyMaxPrice').val('');
				$('#txtSecBuyMinPrice').val('');
				$('#txtSecBuyQty').val('');
				$('#lblSecBuyTradeAmount').html('');
				$('#lblSecBuySMSFee').html('');
				$('#lblSecBuyBrokerFee').html('');
				$('#lblSecBuyNSEFee').html('');
				$('#lblSecBuyBroker').html('');				
				$('#lblSecBuyTotalTradeAmount').html('');				
			}catch(e)
			{
				$.unblockUI();
				m='ResetSecBuy ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		}

		function Request_A_Secondary_Buy(sn,sym,price,vol,BrokerName,avtoks)
		{
			try
			{
				ResetSecBuy();
				
				$('#lblSecBuySymbol').html(sym);
				$('#lblSecBuyMarketPrice').html('₦'+number_format(price, '2', '.', ','));
				$('#lblSecBuyBroker').html(BrokerName);
				
				
				$('#divSecBuyModal').modal({
				  	fadeDuration: 	1000,
					fadeDelay: 		0.50,
					keyboard: 		false,
					backdrop:		'static'
				});
				
			}catch(e)
			{
				$.unblockUI();
				m='Request_A_Secondary_Buy ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}
		
		function Request_A_Buy(sn,sym,price,vol)
		{
			try
			{
				ResetRequest();
				
				var avtoks = $('#tabPrimary > tbody').find("tr").eq(sn).find("td").eq(4).html();
				
				$('#lblRequestSymbol').html(sym);
				$('#lblRequestAvailableTokens').html(number_format(avtoks, '0', '', ','));
				$('#lblRequestlMarketPrice').html('₦'+number_format(price, '2', '.', ','));
				$('#lblRequestBroker').html(BrokerName);
				
				
				$('#divRequestModal').modal({
				  	fadeDuration: 	1000,
					fadeDelay: 		0.50,
					keyboard: 		false,
					backdrop:		'static'
				});
			}catch(e)
			{
				$.unblockUI();
				m='Request_A_Buy ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}
		
		//Sec Sell
		function ResetSecSell()
		{
			try
			{
				$('#lblSecSellSymbol').html('');
				$('#lblSecSellMarketPrice').html('');
				$('#txtSecSellMaxPrice').val('');
				$('#txtSecSellMinPrice').val('');
				$('#txtSecSellQty').val('');
				$('#lblSecSellTradeAmount').html('');
				$('#lblSecSellSMSFee').html('');
				$('#lblSecSellBrokerFee').html('');
				$('#lblSecSellNSEFee').html('');
				$('#lblSecSellBroker').html('');				
				$('#lblSecSellTotalTradeAmount').html('');	
				$('#lblSecSellAvailQty').html('');			
			}catch(e)
			{
				$.unblockUI();
				m='ResetSecSell ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		}
		
		function Request_A_Secondary_Sell(sn,sym,price,vol,BrokerName,avtoks)
		{
			try
			{
				ResetSecSell();
				
				$('#lblSecSellSymbol').html(sym);
				$('#lblSecSellMarketPrice').html('₦'+number_format(price, '2', '.', ','));
				$('#lblSecSellBroker').html(BrokerName);
				$('#lblSecSellAvailQty').html(avtoks);
				
				
				$('#divSecSellModal').modal({
				  	fadeDuration: 	1000,
					fadeDelay: 		0.50,
					keyboard: 		false,
					backdrop:		'static'
				});
				
			}catch(e)
			{
				$.unblockUI();
				m='Request_A_Secondary_Sell ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
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
		<?php include('header.php'); ?>
        <?php include('sidemenu.php'); ?>
		        
        <!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
                	<!-- Breadcrum -->
                     <div class="page-title-subheading opacity-10">
                         <div class="col-sm-12 form-group">
                         	<div class="col-sm-3">
                                 <nav class="" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="<?php echo site_url('ui/Dashboard'); ?>">
                                                <i aria-hidden="true" class="fa fa-home"></i>
                                            </a>
                                        </li>
                                        <li class="active breadcrumb-item" aria-current="page">
                                            <a class="nsegreen-dark">Trade Request</a>
                                        </li>
                                    </ol>
                                </nav>   
                            </div>
                            
                            <div class="col-sm-9">
                                <div class="col-sm-3">&nbsp;</div>
                                
                                 
                                    
                                <div class="col-sm-7 text-right">
                                    <label class=" col-form-label size-17 text-right nsegreen">Trading Date:</label>
                                   <span style="margin-left:5px;" id="lblTime" class=" makebold size-17 redalerttext"></span>
                                 </div>
                            </div>                         
                         </div>                        
                    </div>
                   
					
                    <ul class="nav nav-tabs">
                       <li class="active makebold size-18"><a data-toggle="tab" href="#market">Secondary Market</a></li>
                       
                       <li class="makebold size-18"><a data-toggle="tab" href="#primary">Primary Market</a></li>
                       
                        <?php
							if (strtolower($usertype) == 'investor')// or (strtolower($usertype) == 'investor/issuer'))
							{
								echo '<li class="makebold size-18"><a data-toggle="tab" href="#history">Request History</a></li>';
							}
						?>
                       
                       <li title="Click to refresh page" onClick="window.location.reload(true);" class="makebold size-18"><a data-toggle="tab" href="#refresh" class="redtext">Refresh</a></li>
                   </ul>
                
                  <div class="tab-content">
                  <!--Market Tab-->
                    <div id="market" class="tab-pane fade in active">
                     	<table class="hover table table-bordered data-table display wrap" id="tabSecondaryMarket">
                          <thead>
                            <tr>
                            	<th style="text-align:center" width="15%">ARTWORK</th>
                                <th style="text-align:center" width="12%">SYMBOL</th>
                                <th title="Open Price" style="text-align:center" width="10%">OPEN</th>
                                <th title="High Price" style="text-align:center" width="10%">HIGH</th> 
                                <th title="Low Price" style="text-align:center" width="10%">LOW</th>
                                <th title="Close Price"style="text-align:center" width="10%">CLOSE</th>
                                <th style="text-align:center" width="12%">TRADES</th>
                                <th style="text-align:center" width="13%">VOLUME</th>
                                <th style="text-align:center" width="8%"></th>
                            </tr>
                          </thead>

                          <tbody id="tbmarketbody"></tbody>
                        </table>
                    </div>
                  
                  <!--Primary Market Tab-->
                    <div id="primary" class="tab-pane fade">
                     	<table class="hover table table-bordered data-table display wrap" id="tabPrimary">
                          <thead>
                            <tr>
                                <th style="text-align:center" width="19%">ARTWORK</th>
                                <th style="text-align:center" width="16%">ARTIST</th>
                                <th style="text-align:center" width="14%">SYMBOL</th>
                                <th style="text-align:center" width="13%">VALUE</th>
                                <th style="text-align:center" width="16%">AVAILABLE&nbsp;TOKENS</th>
                                <th style="text-align:center" width="14%">PRICE/TOKEN</th>
                                <th style="text-align:center;" width="8%"></th>
                            </tr>
                          </thead>

                          <tbody id="tbmarketbody"></tbody>
                        </table>
                    </div>
                    
                    <!--Request History Tab-->
                    <?php
						if (strtolower($usertype) == 'investor')// or (strtolower($usertype) == 'investor/issuer'))
						{
							echo '
					<div id="history" class="tab-pane fade">
                     	<table class="hover table table-bordered data-table display wrap" id="tabHistory">
                          <thead>
                            <tr>
								<th style="text-align:center" width="10%">MARKET</th>
                                <th style="text-align:center" width="20%">ARTWORK</th>
                                <th style="text-align:center" width="10%">SYMBOL</th>
                                <th title="Available Tokens" style="text-align:center" width="12%">REQEUST&nbsp;TYPE</th>
                                <th style="text-align:center" width="12%">NO&nbsp;OF&nbsp;TOKENS</th>
								<th style="text-align:center" width="12%">MIN.&nbsp;PRICE</th>
								<th style="text-align:center" width="12%">MAX.&nbsp;PRICE</th>
								<th style="text-align:center" width="12%">MARKET&nbsp;PRICE</th>
                            </tr>
                          </thead>

                          <tbody id="tbhistorybody"></tbody>
                        </table>
                    </div> 		
							';
						}
					?>
                                       
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

<!--Request Secondary Buy Popup-->
<div id="divSecBuyModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        	<b><span style="margin-right:39px; color:#000000;">REQUEST PURCHASE OF ASSET</span></b>
            
           <span style="float:right">Fields With <span class="redtext">*</span> Are Required               
               <button style="margin-left:50px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
           </span>            
        </h5>        
      </div>
      
      <div class="modal-body">
        <form>            
             <!--Market-->
             <div class="position-relative row form-group">
                <label title="Market Type" for="lblSecBuyMarketType" class="col-sm-3 col-form-label nsegreen text-right">Market</label>
                
                <div title="Market Type" class="col-sm-4">
                    <label id="lblSecBuyMarketType" class="col-form-label redtext">Secondary</label>
                </div>              
            </div>            
            
            <!--Asset/Price Per Token-->            
            <div class="position-relative row form-group">
                <!--Asset-->
                <label title="Asset" for="lblSecBuySymbol" class="col-sm-3 col-form-label nsegreen text-right">Asset</label>
                
                <div title="Asset" class="col-sm-4">
                    <label id="lblSecBuySymbol" class="col-form-label redtext"></label>
                </div>
                
                <!--Market Price Per Token-->
                <label title="Market Price Per Token" for="lblSecBuyMarketPrice" class="col-sm-2 col-form-label nsegreen text-right">Market&nbsp;Price</label>
                
                <div title="Current Market Price" class="col-sm-3">
                    <label id="lblSecBuyMarketPrice" class="col-form-label redtext"></label>
                </div>
            </div>
            
            <!--Min. Buy Price/Max. Buy Price-->            
            <div class="position-relative row form-group">
                <label style="padding-left:0px;" title="Minimum buying price" for="txtSecBuyMinPrice" class="col-sm-3 col-form-label nsegreen text-right">Min.&nbsp;Buying&nbsp;Price<span class="redtext">*</span> <i data-toggle="tooltip" data-placement="right auto" title="This price is the minimum price the broker is to buy the asset for you. If you have a fixed price to buy the asset, then enter it in this minimum price box as well as the maximum price box." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                
                <div  title="Minimum buying price" class="col-sm-4">
                    <input min="1" type="number" id="txtSecBuyMinPrice" placeholder="Min. Buying Price" class="form-control size-19 makebold redtext">
                </div>
                
                <!--Maximum buying price-->
                <label title="Maximum buying price" for="txtSecBuyMaxPrice" class="col-sm-2 col-form-label nsegreen text-right">Max.&nbsp;Price<span class="redtext">*</span> <i data-toggle="tooltip" data-placement="right auto" title="This price is the maximum price the broker is to buy the asset for you. If you have a fixed price to buy the asset, then enter it in this maximum price box as well as the minimum price box." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                
                <div title="Maximum buying price" class="col-sm-3">
                    <input min="1" type="number" id="txtSecBuyMaxPrice" placeholder="Max. Buying Price" class="form-control size-19 makebold redtext">
                </div>
            </div>           
            
                      
            <!--Quantity To Buy-->
             <div class="position-relative row form-group">
                 <!--Quantity To Buy-->
                <label title="Number of tokens to buy" for="txtSecBuyQty" class="col-sm-3 col-form-label nsegreen text-right">Quantity To Buy<span class="redtext">*</span></label>
                
                <div title="Number of tokens to buy" class="col-sm-4">
                    <input min="1" type="number" id="txtSecBuyQty" placeholder="Number Of Tokens To Buy" class="form-control size-19 makebold redtext">
                </div>
            </div>
            
            <!--Trade Amount/SMS Fee-->
             <div class="position-relative row form-group">
                <label style="padding-left:0px;" title="Trade Amount" for="lblSecBuyTradeAmount" class="col-sm-3 col-form-label nsegreen text-right">Trade Amount<span class="redtext">*</span> <i data-toggle="tooltip" data-placement="right auto" title="This is the amount required to buy the tokens excluding broker, NSE and SMS fees. This amount is computed using the maximum price entered." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                
                <div title="Trade Amount" class="col-sm-4">
                    <label id="lblSecBuyTradeAmount" class="col-form-label redtext"></label>
                </div>
                
                <!--SMS Fee-->
                 <label title="SMS Fee" for="lblSecBuySMSFee" class="col-sm-2 col-form-label text-right nsegreen">SMS Fee<span class="redtext">*</span> </label>
                 
                 <div title="SMS Fee" class="col-sm-3">
                    <label id="lblSecBuySMSFee" class="col-form-label redtext"></label>
                </div>
            </div>
                                  
            <!--Broker Fee/NSE Fee-->
            <div class="position-relative row form-group">
             	<!--Broker Fee-->
                <label style="padding-left:0px;" title="Broker Fee" for="lblSecBuyBrokerFee" class="col-sm-3 col-form-label  nsegreen text-right">Broker Fee<span class="redtext">*</span> </label>
                
                <div title="Broker Fee" class="col-sm-4">
                    <label id="lblSecBuyBrokerFee" class="col-form-label redtext"></label>
                </div>
                
                  <!--NSE Fee-->
                 <label title="NSE Fee" for="lblSecBuyNSEFee" class="col-sm-2 col-form-label text-right nsegreen">NSE Fee<span class="redtext">*</span> </label>
                 
                 <div title="NSE Fee" class="col-sm-3">
                    <label id="lblSecBuyNSEFee" class="col-form-label redtext"></label>
                </div>  
            </div>
            
            <!--Broker-->
            <div class="row">
                 <div title="Broker" class="position-relative row form-group">
                    <label for="lblSecBuyBroker" class="col-sm-3 col-form-label  nsegreen text-right">Broker</label>
                    
                    <div class="col-sm-9">
                        <label id="lblSecBuyBroker" class="col-form-label redtext"></label>
                    </div>
                </div>
            </div>
            
            <!--Total Trade Amount-->
             <div class="position-relative row form-group">
                <!--Total Trade Amount-->
                <label title="Total Trade Amount" for="lblSecBuyTotalTradeAmount" class="col-sm-3 col-form-label text-right nsegreen text-right">Total Trade Amount <i data-toggle="tooltip" data-placement="right auto" title="This is the total amount required to buy the asset including all the broker, NSE and SMS fees." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div style="background:#AF4442; color:#ffffff;" title="Total Trade Amount" class="col-sm-9">
                    <label id="lblSecBuyTotalTradeAmount" class="col-form-label"></label>
                </div>
            </div>
 
           <div id="divSecBuyAlert"></div>
        </form>
      </div>      
      
      <div class="modal-footer">
        <button id="btnSecBuy" type="button" class="btn btn-nse-green">ASK BROKER TO BUY</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>
<!-- End Request Secondary Buy Popup-->


<!--Request Secondary Sell Popup-->
<div id="divSecSellModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        	<b><span style="margin-right:39px; color:#000000;">REQUEST SELL OF ASSET</span></b>
            
           <span style="float:right">Fields With <span class="redtext">*</span> Are Required               
               <button style="margin-left:50px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
           </span>            
        </h5>        
      </div>
      
      <div class="modal-body">
        <form>            
             <!--Market-->
             <div class="position-relative row form-group">
                <label title="Market Type" for="lblSecSellMarketType" class="col-sm-3 col-form-label nsegreen text-right">Market</label>
                
                <div title="Market Type" class="col-sm-4">
                    <label id="lblSecSellMarketType" class="col-form-label redtext">Secondary</label>
                </div>              
            </div>            
            
            <!--Asset/Price Per Token-->            
            <div class="position-relative row form-group">
                <!--Asset-->
                <label title="Asset" for="lblSecSellSymbol" class="col-sm-3 col-form-label nsegreen text-right">Asset</label>
                
                <div title="Asset" class="col-sm-4">
                    <label id="lblSecSellSymbol" class="col-form-label redtext"></label>
                </div>
                
                <!--Market Price Per Token-->
                <label title="Market Price Per Token" for="lblSecSellMarketPrice" class="col-sm-2 col-form-label nsegreen text-right">Market&nbsp;Price</label>
                
                <div title="Current Market Price" class="col-sm-3">
                    <label id="lblSecSellMarketPrice" class="col-form-label redtext"></label>
                </div>
            </div>
            
            <!--Min. Sell Price/Max. Sell Price-->            
            <div class="position-relative row form-group">
                <label style="padding-left:0px;" title="Minimum selling price" for="txtSecSellMinPrice" class="col-sm-3 col-form-label nsegreen text-right">Min.&nbsp;Selling&nbsp;Price<span class="redtext">*</span> <i data-toggle="tooltip" data-placement="right auto" title="This price is the minimum price the broker is to sell the asset for you. If you have a fixed price to sell the asset, then enter it in this minimum price box as well as the maximum price box." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                
                <div  title="Minimum selling price" class="col-sm-4">
                    <input min="1" type="number" id="txtSecSellMinPrice" placeholder="Min. Selling Price" class="form-control size-19 makebold redtext">
                </div>
                
                <!--Maximum selling price-->
                <label title="Maximum selling price" for="txtSecSellMaxPrice" class="col-sm-2 col-form-label nsegreen text-right">Max.&nbsp;Price<span class="redtext">*</span> <i data-toggle="tooltip" data-placement="right auto" title="This price is the maximum price the broker is to sell the asset for you. If you have a fixed price to sell the asset, then enter it in this maximum price box as well as the minimum price box." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                
                <div title="Maximum selling price" class="col-sm-3">
                    <input min="1" type="number" id="txtSecSellMaxPrice" placeholder="Max. Selling Price" class="form-control size-19 makebold redtext">
                </div>
            </div>           
            
                      
            <!--Available Qty/Quantity To Sell-->
             <div class="position-relative row form-group">
                 <!--Available Qty-->
                <label title="Available Quantity In Portfolio" for="lblSecSellAvailQty" class="col-sm-3 col-form-label nsegreen text-right">Available Qty<span class="redtext">*</span></label>
                
                <div title="Available Quantity In Portfolio" class="col-sm-4">
                    <label id="lblSecSellAvailQty" class="col-form-label redtext"></label>
                </div>
                 
                 
                 <!--Quantity To Sell-->
                <label title="Number of tokens to sell" for="txtSecSellQty" class="col-sm-2 col-form-label nsegreen text-right">Qty To Sell<span class="redtext">*</span></label>
                
                <div title="Number of tokens to sell" class="col-sm-3">
                    <input min="1" type="number" id="txtSecSellQty" placeholder="Tokens To Sell" class="form-control size-19 makebold redtext">
                </div>
            </div>
            
            <!--Trade Amount/SMS Fee-->
             <div class="position-relative row form-group">
                <label style="padding-left:0px;" title="Trade Amount" for="lblSecSellTradeAmount" class="col-sm-3 col-form-label nsegreen text-right">Trade Amount<span class="redtext">*</span> <i data-toggle="tooltip" data-placement="right auto" title="This is the amount required to sell the tokens excluding broker, NSE and SMS fees. This amount is computed using the maximum price entered." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                
                <div title="Trade Amount" class="col-sm-4">
                    <label id="lblSecSellTradeAmount" class="col-form-label redtext"></label>
                </div>
                
                <!--SMS Fee-->
                 <label title="SMS Fee" for="lblSecSellSMSFee" class="col-sm-2 col-form-label text-right nsegreen">SMS Fee<span class="redtext">*</span> </label>
                 
                 <div title="SMS Fee" class="col-sm-3">
                    <label id="lblSecSellSMSFee" class="col-form-label redtext"></label>
                </div>
            </div>
                                  
            <!--Broker Fee/NSE Fee-->
            <div class="position-relative row form-group">
             	<!--Broker Fee-->
                <label style="padding-left:0px;" title="Broker Fee" for="lblSecSellBrokerFee" class="col-sm-3 col-form-label  nsegreen text-right">Broker Fee<span class="redtext">*</span> </label>
                
                <div title="Broker Fee" class="col-sm-4">
                    <label id="lblSecSellBrokerFee" class="col-form-label redtext"></label>
                </div>
                
                  <!--NSE Fee-->
                 <label title="NSE Fee" for="lblSecSellNSEFee" class="col-sm-2 col-form-label text-right nsegreen">NSE Fee<span class="redtext">*</span> </label>
                 
                 <div title="NSE Fee" class="col-sm-3">
                    <label id="lblSecSellNSEFee" class="col-form-label redtext"></label>
                </div>  
            </div>
            
            <!--Broker-->
            <div class="row">
                 <div title="Broker" class="position-relative row form-group">
                    <label for="lblSecSellBroker" class="col-sm-3 col-form-label  nsegreen text-right">Broker</label>
                    
                    <div class="col-sm-9">
                        <label id="lblSecSellBroker" class="col-form-label redtext"></label>
                    </div>
                </div>
            </div>
            
            <!--Total Trade Amount-->
             <div class="position-relative row form-group">
                <!--Total Trade Amount-->
                <label title="Total Trade Amount" for="lblSecSellTotalTradeAmount" class="col-sm-3 col-form-label text-right nsegreen text-right">Total Trade Amount <i data-toggle="tooltip" data-placement="right auto" title="This is the total amount required to sell the asset including all the broker, NSE and SMS fees." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div style="background:#AF4442; color:#ffffff;" title="Total Trade Amount" class="col-sm-9">
                    <label id="lblSecSellTotalTradeAmount" class="col-form-label"></label>
                </div>
            </div>
 
           <div id="divSecSellAlert"></div>
        </form>
      </div>      
      
      <div class="modal-footer">
        <button id="btnSecSell" type="button" class="btn btn-nse-green">ASK BROKER TO SELL</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>
<!-- End Request Secondary Sell Popup-->


<!--Request Popup-->
<div id="divRequestModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        	<b><span style="margin-right:39px; color:#000000;">REQUEST PURCHASE OF ASSET</span></b>
            
           <span style="float:right">Fields With <span class="redtext">*</span> Are Required               
               <button style="margin-left:50px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
           </span>            
        </h5>        
      </div>
      
      <div class="modal-body">
        <form>            
             <!--Asset-->
             <div class="position-relative row form-group">
                <label title="Asset" for="lblRequestSymbol" class="col-sm-3 col-form-label nsegreen text-right">Asset<span class="redtext">*</span></label>
                
                <div title="Asset" class="col-sm-9">
                    <label id="lblRequestSymbol" class="col-form-label redtext"></label>
                </div>               
            </div>
            
            
            <!--Available Tokens-->            
            <div class="position-relative row form-group">
                <label style="padding-left:0px;" title="Tokens Available For Sale" for="lblRequestAvailableTokens" class="col-sm-3 col-form-label nsegreen text-right">Available Tokens<span class="redtext">*</span> <i data-toggle="tooltip" data-placement="right auto" title="Note that the market is very dynamic. Consequently, the available quantity of tokens for sale may change at the actual buying time. If that occurs, the total trade amount will also change." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                
                <div  title="Tokens Available" class="col-sm-9">
                    <label id="lblRequestAvailableTokens" class="col-form-label redtext"></label>
                </div>
            </div>
            
            
            <!--Price Per Token-->
             <div class="position-relative row form-group">
                <!--Market Price Per Token-->
                <label title="Market Price Per Token" for="lblRequestlMarketPrice" class="col-sm-3 col-form-label nsegreen text-right">Price Per Token</label>
                
                <div title="Current Market Price" class="col-sm-9">
                    <label id="lblRequestlMarketPrice" class="col-form-label redtext"></label>
                </div>                
            </div>
            
            <!--Quantity To Buy-->
             <div class="position-relative row form-group">
                 <!--Quantity To Buy-->
                <label title="Number of tokens to buy" for="txtRequestQty" class="col-sm-3 col-form-label nsegreen text-right">Quantity To Buy</label>
                
                <div title="Number of tokens to buy" class="col-sm-9">
                    <input min="1" type="number" id="txtRequestQty" placeholder="Number Of Tokens To Buy" class="form-control size-19 makebold redtext">
                </div>
            </div>
            
            <!--Trade Amount/SMS Fee-->
             <div class="position-relative row form-group">
                <label style="padding-left:0px;" title="Trade Amount" for="lblRequestTradeAmount" class="col-sm-3 col-form-label nsegreen text-right">Trade Amount<span class="redtext">*</span> <i data-toggle="tooltip" data-placement="right auto" title="This is the amount required to buy the tokens excluding broker, NSE and SMS fees." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                
                <div title="Trade Amount" class="col-sm-4">
                    <label id="lblRequestTradeAmount" class="col-form-label redtext"></label>
                </div>
                
                <!--SMS Fee-->
                 <label title="SMS Fee" for="lblRequestSMSFee" class="col-sm-2 col-form-label text-right nsegreen">SMS Fee<span class="redtext">*</span> </label>
                 
                 <div title="SMS Fee" class="col-sm-3">
                    <label id="lblRequestSMSFee" class="col-form-label redtext"></label>
                </div>
            </div>
                                  
            <!--Broker Fee/NSE Fee-->
            <div class="position-relative row form-group">
             	<!--Broker Fee-->
                <label style="padding-left:0px;" title="Broker Fee" for="lblRequestBrokerFee" class="col-sm-3 col-form-label  nsegreen text-right">Broker Fee<span class="redtext">*</span> </label>
                
                <div title="Broker Fee" class="col-sm-4">
                    <label id="lblRequestBrokerFee" class="col-form-label redtext"></label>
                </div>
                
                  <!--NSE Fee-->
                 <label title="NSE Fee" for="lblRequestNSEFee" class="col-sm-2 col-form-label text-right nsegreen">NSE Fee<span class="redtext">*</span> </label>
                 
                 <div title="NSE Fee" class="col-sm-3">
                    <label id="lblRequestNSEFee" class="col-form-label redtext"></label>
                </div>  
            </div>
            
            <!--Broker-->
            <div class="row">
                 <div title="Broker" class="position-relative row form-group">
                    <label for="lblRequestBroker" class="col-sm-3 col-form-label  nsegreen text-right">Broker<span class="redtext">*</span></label>
                    
                    <div class="col-sm-9">
                        <label id="lblRequestBroker" class="col-form-label redtext"></label>
                    </div>
                </div>
            </div>
            
            <!--Total Trade Amount-->
             <div class="position-relative row form-group">
                <!--Total Trade Amount-->
                <label title="Total Trade Amount" for="lblRequestTotalTradeAmount" class="col-sm-3 col-form-label text-right nsegreen text-right">Total Trade Amount <i data-toggle="tooltip" data-placement="right auto" title="This is the total amount required to buy the asset including all the broker, NSE and SMS fees." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div style="background:#AF4442; color:#ffffff;" title="Total Trade Amount" class="col-sm-9">
                    <label id="lblRequestTotalTradeAmount" class="col-form-label"></label>
                </div>
            </div>
 
           <div id="divRequestAlert"></div>
        </form>
      </div>      
      
      <div class="modal-footer">
        <button id="btnRequest" type="button" class="btn btn-nse-green">ASK BROKER TO BUY</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>
<!-- End Request Popup-->

<!--Start Pix Popup-->
<div id="myPixModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
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

</body>

</html>
