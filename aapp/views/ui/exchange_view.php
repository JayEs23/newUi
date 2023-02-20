<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<title>Naija Art Market | Exchange</title>
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
		
		.labelmiddle{padding-top:8px; margin-bottom:0; padding-left:5px;}
		
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
    </style>
        
    <script>
		var Title='<font color="#AF4442">Naija Art Mart Help</font>';
		var m='';
		var table,tabletrade,tablenews,tableorder,tablebuybook,tablesellbook;
		var Email='<?php echo $email; ?>';
		var Usertype='<?php echo $usertype; ?>';
		var BrokerId='<?php echo $broker_id; ?>';
		var MarketStatus='<?php echo $MarketStatus; ?>';
		var CurrentSymbolPrice='';
		var RefreshInterval='<?php echo $RefreshInterval; ?>';
		RefreshInterval=parseInt(RefreshInterval,10) * 60 * 1000;

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
		
		function DisplaySellMessage(msg,msgtype,msgtitle,theme='AlertTheme')
		{
			try
			{//SuccessTheme, AlertTheme
				$('#divSellAlert').html(msg).addClass(theme);
				
				
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
					$('#divSellAlert').load(location.href + " #divSellAlert").removeClass(theme);
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
			
			$('[data-toggle="tooltip"]').tooltip();
			
			setInterval(function(){
				LoadDirectMarketData();
			}, (RefreshInterval));
	
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

			$('#txtBuyExpiryDate').datepicker({
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
			
			$('#txtSellExpiryDate').datepicker({
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
			
			$('.tradedatepicker').datepicker({
				weekStart: 1,
				todayBtn:  "linked",
				autoclose: 1,
				todayHighlight: 1,
				maxViewMode: 1,//Months
				clearBtn: 1,
				forceParse: 0,
				daysOfWeekHighlighted: "0,6",
				//daysOfWeekDisabled: "0,6",
				format: 'd M yyyy'
			});			

			$('#txtTradeStartDate').datepicker({
				weekStart: 1,
				todayBtn:  "linked",
				autoclose: 1,
				todayHighlight: 1,
				maxViewMode: 1,//Months
				clearBtn: 1,
				forceParse: 0,
				daysOfWeekHighlighted: "0,6",
				//daysOfWeekDisabled: "0,6",
				format: 'd M yyyy'
			});
			
			$('#txtTradeEndDate').datepicker({
				weekStart: 1,
				todayBtn:  "linked",
				autoclose: 1,
				todayHighlight: 1,
				maxViewMode: 1,//Months
				clearBtn: 1,
				forceParse: 0,
				daysOfWeekHighlighted: "0,6",
				//daysOfWeekDisabled: "0,6",
				format: 'd M yyyy'
			});
			
			function VerifyStartAndEndDates()
			{
				try
				{
					$('#divAlert').html('');
					
					var startdt=ChangeDateFrom_dMY_To_Ymd($('#txtTradeStartDate').val());
					var enddt=ChangeDateFrom_dMY_To_Ymd($('#txtTradeEndDate').val());
					var sdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
					var edt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
					var d;
					
					if ($('#txtTradeStartDate').val()=='0000-00-00') $('#txtTradeStartDate').val('');
					if ($('#txtTradeEndDate').val()=='0000-00-00') $('#txtTradeEndDate').val('');
					
					if ($('#txtTradeStartDate').val())
					{
						if (!sdt.isValid())
						{
							m="Trade Start Date Is Not Valid. Please Select A Valid Trade Start Date.";
							
							DisplayMessage(m, 'error',Title);
						}	
					}
					
					
					if ($('#txtTradeEndDate').val())
					{
						if (!edt.isValid())
						{
							m="Trade End Date Is Not Valid. Please Select A Valid Trade End Date.";
							DisplayMessage(m, 'error',Title);
						}	
					}
					
										
					//moment('2010-10-20').isSameOrBefore('2010-10-21');  // true				
					var dys=edt.diff(sdt, 'days') //If this -ve invalid date entries. Delivery earlier than pickup
					var diff = moment.duration(edt.diff(sdt));
					var mins = parseInt(diff.asMinutes());
					
					
					if (dys<0)
					{
						$('#txtTradeEndDate').val('');
											
						m="Trade End Date Is Before Trade Start Date. Please Correct Your Entries!";
						DisplayMessage(m, 'error',Title);
					}
				}catch(e)
				{
					$.unblockUI();
					m="VerifyStartAndEndDates ERROR:\n"+e;				
					DisplayMessage(m, 'error',Title);
					return false;
				}
			}
			
			
			setInterval(function() {
				updateClock();
			}, 1000);
			
			LoadDirectMarketData();
			LoadOrders();
			LoadInvestors();
			LoadOrderTypes();
			LoadMessages();
			LoadSymbols();
			LoadTrades('<?php echo date("d M Y"); ?>','<?php echo date("d M Y"); ?>');
			
			$('#btnDisplayTrades').click(function(e) {
                try
				{
					var p=$.trim($('#txtTradeStartDate').val());
					var d=$.trim($('#txtTradeEndDate').val());
										
					//Start date
					if (!p)
					{
						m='You have not selected the trade start date.';					
						DisplayMessage(m,'error',Title);
						return false;
					}					
	
					//End Date
					if (!d)
					{
						m='You have not selected the trade end date.';
						DisplayMessage(m,'error',Title);
						return false;
					}	
					
					if (!p && d)
					{
						m='You have selected the trade end date. Trade start date field must also be selected.';						
						DisplayMessage(m,'error',Title);
						return false;
					}					
	
					if (p && !d)
					{
						m='You have selected the trade start date. Trade end date field must also be selected.';						
	
						DisplayMessage(m,'error',Title);
						return false;
					}					
	
					var startdt = ChangeDateFrom_dMY_To_Ymd($('#txtTradeStartDate').val());
					var enddt = ChangeDateFrom_dMY_To_Ymd($('#txtTradeEndDate').val());
					var sdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
					var edt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
				
					if (p && d)
					{
						var dys=edt.diff(sdt, 'days') //If this -ve invalid date entries.
								
						if (dys<0)
						{
							m="Trade End Date Is Before The Trade Start Date. Please Correct Your Entries!";
							DisplayMessage(m, 'error',Title);
							return false;
						}
					}					
					
					LoadTrades(startdt,enddt);
				}catch(e)
				{
					$.unblockUI();
					m='Display Trades Button Click ERROR:\n'+e;
					DisplayMessage(m,'error',Title);
				}
            });
			
			function LoadTrades(sdt,edt)
			{
				try
				{
					$.ajax({
						url: "<?php echo site_url('ui/Exchange/GetTrades');?>",
						type: 'POST',
						data: {email:Email,broker_id:BrokerId,startdate:sdt,enddate:edt},
						dataType: 'json',
						success: function(dataSet,status,xhr) {	
							$.unblockUI();
							
							if (tabletrade) tabletrade.destroy();
							
							//f-filtering, l-length, i-information, p-pagination
							tabletrade = $('#tabTrades').DataTable( {
								dom: '<"top"if>rt<"bottom"lp><"clear">',
								responsive: true,
								ordering: false,
								autoWidth:false,
								language: {zeroRecords: "No Trade Record Found"},
								lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
								columnDefs: [
									{
										"targets": [ 0,1,2,3,4,5,6,7 ],
										"visible": true
									},
									{
										"targets": [ 0,1,2,3,4,5,6,7 ],
										"searchable": true
									},
									{ className: "dt-center", "targets": [ 0,1,2,3,6,7 ] },
									{ className: "dt-right", "targets": [ 4,5 ] }
								],					
								order: [[ 2, 'asc' ]],
								data: dataSet, 
								columns: [
									{ width: "15%" },//Trade Date
									{ width: "13%" },//Trade Id
									{ width: "11%" },//Asset
									{ width: "11%" },//Tokens
									{ width: "10%" },//Price
									{ width: "14%" },//Amount
									{ width: "13%" },//Seller
									{ width: "13%" }//Buyer
								],
							} );
							
							var total=0; 
						
							total=tabletrade.column(5).data().sum();
														
							if (parseFloat(total) > 0)
							{
								$('#tdAmount').html(number_format (total, 2, '.', ','));
							}else
							{
								$('#tdAmount').html('');
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
					m='LoadTrades ERROR:\n'+e;
					DisplayMessage(m,'error',Title);
				}
			}
			
			function LoadSymbols()
			{
				try
				{
					$('#cboOrderSymbol').empty();
										
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Assets. Please Wait....</p>',theme: false,baseZ: 2000});	
	
					
					$.ajax({
						url: "<?php echo site_url('ui/Exchange/GetSymbols');?>",
						type: 'POST',
						dataType: 'json',
						success: function(data,status,xhr) {	
							$.unblockUI();
	
							if ($(data).length > 0)
							{
								$("#cboOrderSymbol").append(new Option('[SELECT]', ''));
								
								$.each($(data), function(i,e)
								{
									if (e.symbol)
									{
										$("#cboOrderSymbol").append(new Option($.trim(e.symbol).toUpperCase(), $.trim(e.symbol).toUpperCase()));
									}
								});//End each
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
					m="LoadSymbols ERROR:\n"+e;
					DisplayMessage(m,'error',Title);
				}
			}
			
			function LoadMessages()
			{
				try
				{
					$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Loading Messages/News. Please Wait...</p>",theme: false,baseZ: 2000});
					
					$('#tabNews > tbody').html('');
					
					var tw=$('#news').width();
					var det_cell=tw * 0.45;
					var head_cell=tw * 0.38;
					
					$.ajax({
						url: '<?php echo site_url('ui/Exchange/LoadMessages'); ?>',
						type: 'POST',
						data: {email:Email, detail_width:det_cell, header_width:head_cell,usertype:'<?php echo $usertype; ?>'},
						dataType: 'json',
						success: function(dataSet,status,xhr) {	
							$.unblockUI();
							
							if (tablenews) tablenews.destroy();
							
							//f-filtering, l-length, i-information, p-pagination
							tablenews = $('#tabNews').DataTable( {
								dom: '<"top"if>rt<"bottom"lp><"clear">',
								responsive: true,
								ordering: false,
								autoWidth:false,
								language: {zeroRecords: "No News/Message Record Found"},
								lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
								columnDefs: [
									{
										"targets": [ 0,1,2,3 ],
										"visible": true
									},
									{
										"targets": [ 3 ],
										"orderable": false,
										"searchable": false
									},
									{
										"targets": [ 0,1,2 ],
										"searchable": true
									},
									{ className: "dt-center", "targets": [ 0,1,2,3 ] }
								],					
								order: [[ 2, 'asc' ]],
								data: dataSet, 
								columns: [
									{ width: "12%" },//Date
									{ width: "53%" },//Header
									{ width: "30%" },//Sender
									{ width: "5%" } //View
								]
							} );
							
							//UiActivateTab('view');		
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
					m='LoadMessages ERROR:\n'+e;
					DisplayMessage(m, 'error',Title);
				}
			}
			
			function LocateMesssage(mid,hd,det,dt,cat)
			{
				try
				{
					$.redirect("<?php echo base_url(); ?>ui/Messages", {msgid:mid, header:hd, details:det, msgdate:dt,category:cat}, "POST");	
				}catch(e)
				{
					$.unblockUI();
					m='LocateMesssage ERROR:\n'+e;
					DisplayMessage(m, 'error',Title);
				}
			}
			
			function LoadOrders()
			{
				try
				{
					//$.blockUI({message: '<img src="<?php //echo base_url();?>images/loader.gif" /><p>Loading Market Data. Please Wait...</p>',theme: false,baseZ: 2000});
					
					//$('#tabMarket > tbody').html('');
					
					$.ajax({
						url: "<?php echo site_url('ui/Exchange/GetOrders');?>",
						type: 'POST',
						data: {email:Email},
						dataType: 'json',
						success: function(dataSet,status,xhr) {	
							$.unblockUI();
							
							if (tableorder) tableorder.destroy();
							
							//f-filtering, l-length, i-information, p-pagination
							tableorder = $('#tabOrders').DataTable( {
								dom: '<"top"if>rt<"bottom"lp><"clear">',
								responsive: true,
								ordering: false,
								autoWidth:false,
								language: {zeroRecords: "No Order Record Found"},
								lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
								columnDefs: [
									{
										"targets": [ 0,1,2,3,4,5,6,7,8,9 ],
										"visible": true
									},
									{
										"targets": [ 8,9 ],
										"orderable": false,
										"searchable": false
									},
									{
										"targets": [ 0,1,2,3,4,5,6,7 ],
										"searchable": true
									},
									{ className: "dt-center", "targets": [ 0,1,2,3,4,5,6,7,8,9 ] }
								],					
								order: [[ 2, 'asc' ]],
								data: dataSet, 
								columns: [
									{ width: "15%" },//Order Date
									{ width: "10%" },//Order Id
									{ width: "10%" },//Asset
									{ width: "9%" },//Tokens
									{ width: "10%" },//Price
									{ width: "12%" },//Order Type
									{ width: "15%" },//Investor
									{ width: "11%" },//Status
									{ width: "4%" },//Update
									{ width: "4%" }//Delete
								],//15,10,10,10,10,12,14,11,4,4
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
					m='LoadOrders ERROR:\n'+e;
					DisplayMessage(m,'error',Title);
				}
			}
			
			function LoadMarketData()
			{
				try
				{
					//$.blockUI({message: '<img src="<?php //echo base_url();?>images/loader.gif" /><p>Loading Market Data. Please Wait...</p>',theme: false,baseZ: 2000});
					
					//$('#tabMarket > tbody').html('');
	
					$.ajax({
						url: "<?php echo site_url('ui/Exchange/GetMarketData');?>",
						type: 'POST',
						data: {usertype:Usertype, broker_id:BrokerId},
						dataType: 'json',
						success: function(dataSet,status,xhr) {	
							$.unblockUI();
							
							if (table) table.destroy();
							
							//f-filtering, l-length, i-information, p-pagination
							table = $('#tabMarket').DataTable( {
								dom: '<"top"if>rt<"bottom"lp><"clear">',
								responsive: true,
								ordering: false,
								autoWidth:false,
								language: {zeroRecords: "No Market Data Record Found"},
								lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
								columnDefs: [
									{
										"targets": [ 0,1,2,3,4,5,6,7,8 ],
										"visible": true
									},
									{
										"targets": [ 7,8 ],
										"orderable": false,
										"searchable": false
									},
									{
										"targets": [ 0,1,2,3,4,5,6 ],
										"searchable": true
									},
									{ className: "dt-center", "targets": [ 0,1,2,3,4,5,6,7,8 ] }
								],					
								order: [[ 2, 'asc' ]],
								data: dataSet, 
								columns: [
									{ width: "15%" },//Symbol
									{ width: "11%" },//Open
									{ width: "11%" },//High
									{ width: "11%" },//Low
									{ width: "11%" },//Close
									{ width: "12%" },//Trades
									{ width: "13%" },//Volume
									{ width: "8%" },//Buy
									{ width: "8%" }//Sell
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
					m='LoadMarketData ERROR:\n'+e;
					DisplayMessage(m,'error',Title);
				}
			}
			
			function LoadDirectMarketData()
			{
				try
				{
					//$.blockUI({message: '<img src="<?php //echo base_url();?>images/loader.gif" /><p>Loading Market Data. Please Wait...</p>',theme: false,baseZ: 2000});
					
					//$('#tabMarket > tbody').html('');
	
					$.ajax({
						url: "<?php echo site_url('ui/Exchange/GetDirectMarketData');?>",
						type: 'POST',
						data: {usertype:Usertype, broker_id:BrokerId},
						dataType: 'json',
						success: function(dataSet,status,xhr) {	
							$.unblockUI();
							
							if (table) table.destroy();
							
							//f-filtering, l-length, i-information, p-pagination
							table = $('#tabMarket').DataTable( {
								dom: '<"top"if>rt<"bottom"lp><"clear">',
								responsive: true,
								ordering: false,
								autoWidth:false,
								language: {zeroRecords: "No Market Data Record Found"},
								lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
								columnDefs: [
									{
										"targets": [ 0,1,2,3,4,5,6,7,8 ],
										"visible": true
									},
									{
										"targets": [ 7,8 ],
										"orderable": false,
										"searchable": false
									},
									{
										"targets": [ 0,1,2,3,4,5,6 ],
										"searchable": true
									},
									{ className: "dt-center", "targets": [ 0,1,2,3,4,5,6,7,8 ] }
								],					
								order: [[ 2, 'asc' ]],
								data: dataSet, 
								columns: [
									{ width: "15%" },//Symbol
									{ width: "11%" },//Open
									{ width: "11%" },//High
									{ width: "11%" },//Low
									{ width: "11%" },//Close
									{ width: "12%" },//Trades
									{ width: "13%" },//Volume
									{ width: "8%" },//Buy
									{ width: "8%" }//Sell
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
					m='LoadDirectMarketData ERROR:\n'+e;
					DisplayMessage(m,'error',Title);
				}
			}
			
			function LoadOrderBook(symbol)
			{
				try
				{
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Order Book. Please Wait...</p>',theme: false,baseZ: 2000});
					
					$.ajax({
						url: "<?php echo site_url('ui/Exchange/GetOrderBook');?>",
						type: 'POST',
						data: {symbol:symbol},
						dataType: 'json',
						success: function(orders,status,xhr) {	
							$.unblockUI();
							
							if (tablebuybook) tablebuybook.destroy();
							if (tablesellbook) tablesellbook.destroy();
							
							var selldata=[],buydata=[];
							
							//Sell orders
							if ($(orders.Sell).length > 0)
							{							
								$.each($(orders.Sell), function(i,e)
								{
									selldata.push([e.orderdate, e.order_id,e.broker_id, e.Qty,e.price]);
								});//End each
							}
							
							//Buy orders
							if ($(orders.Buy).length > 0)
							{							
								$.each($(orders.Buy), function(i,e)
								{
									buydata.push([e.orderdate, e.order_id,e.broker_id, e.Qty,e.price]);
								});//End each
							}
					
							//f-filtering, l-length, i-information, p-pagination
							tablesellbook = $('#tabSellBook').DataTable( {
								dom: '<"top"if>rt<"bottom"lp><"clear">',
								responsive: true,
								ordering: false,
								autoWidth:false,
								language: {zeroRecords: "No Sell Orders"},
								lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
								columnDefs: [
									{
										"targets": [ 0,1,2,3,4 ],
										"visible": true
									},
									{
										"targets": [ 0,1,2,3,4 ],
										"orderable": true,
										"searchable": true
									},
									{ className: "dt-center", "targets": [ 0,1,2,3 ] },
									{ className: "dt-right", "targets": [ 4 ] }
								],					
								//order: [[ 2, 'asc' ]],
								data: selldata, 
								columns: [
									{ width: "33%" },//Order Date/Time
									{ width: "15%" },//Order Id
									{ width: "23%" },//Broker ID
									{ width: "14%" },//Qty
									{ width: "15%" }//Price
								],
							} );
							
							//f-filtering, l-length, i-information, p-pagination
							tablebuybook = $('#tabBuyBook').DataTable( {
								dom: '<"top"if>rt<"bottom"lp><"clear">',
								responsive: true,
								ordering: false,
								autoWidth:false,
								language: {zeroRecords: "No Buy Orders"},
								lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
								columnDefs: [
									{
										"targets": [ 0,1,2,3,4 ],
										"visible": true
									},
									{
										"targets": [ 0,1,2,3,4 ],
										"orderable": true,
										"searchable": true
									},
									{ className: "dt-center", "targets": [ 0,1,2,3 ] },
									{ className: "dt-right", "targets": [ 4 ] }
								],					
								//order: [[ 2, 'asc' ]],
								data: buydata, 
								columns: [
									{ width: "33%" },//Order Date/Time
									{ width: "15%" },//Order Id
									{ width: "23%" },//Broker ID
									{ width: "14%" },//Qty
									{ width: "15%" }//Price
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
					m='LoadOrderBook ERROR:\n'+e;
					DisplayMessage(m,'error',Title);
				}
			}
			
			
			$('#cboDirectSellInvestor').change(function(e) {
                try
				{
					$('#lblDirectSellPortfolioQty').html('');
					
					var inv=$.trim($(this).val());
					var sym=$.trim($('#lblDirectSellSymbol').html());
					
					if (inv) GetDirectPortfolioTokens(sym,inv);
				}catch(e)
				{
					$.unblockUI();
					m='Direct Sell Investor Change ERROR:\n'+e;			
					DisplayDirectSellMessage(m, 'error',Title);
				}
            });
			
			$('#cboSellInvestor').change(function(e) {
                try
				{
					$('#lblSellPortfolioQty').html('');
					
					var inv=$.trim($(this).val());
					var sym=$.trim($('#lblSellSymbol').html());
					
					if (inv) GetPortfolioTokens(sym,inv);
					//$('#lblSellPortfolioQty').html(number_format(portfolioqty, '0', '', ','));
				}catch(e)
				{
					$.unblockUI();
					m='Sell Investor Change ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
            });
			
			$('#cboBuyInvestor').change(function(e) {
                try
				{
					$('#lblBuyPortfolioQty').html('');
					
					var inv=$.trim($(this).val());
					var sym=$.trim($('#lblBuySymbol').html());
					
					if (inv) GetPortfolioTokens(sym,inv);
				}catch(e)
				{
					$.unblockUI();
					m='Buy Investor Change ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
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
			
			$('#cboOrderSymbol').change(function(e) {
                try
				{
					//$('#tabBuyBook> tbody').html('');
					//$('#tabSellBook> tbody').html('');
					
					 if (tablebuybook) tablebuybook.clear().draw();
					 if (tablesellbook) tablesellbook.clear().draw();
						
					var sym=$(this).val();
					
					if (sym) LoadOrderBook(sym);
				}catch(e)
				{
					$.unblockUI();
					m='Order Symbol Change ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
            });
			
			$('#btnBuy').click(function(e) {
                try
				{
					$('#divAlert').html('');			
					if (!CheckBuy()) return false;
				}catch(e)
				{
					
				}
            });
			
			$('#btnSell').click(function(e) {
                try
				{
					$('#divSellAlert').html('');			
					if (!CheckSell()) return false;
				}catch(e)
				{
					
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
			
			$("#txtBuyQty").on("keyup",function(event)
			{
				try
				{
					ComputeBuyAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Buy Quantity Keyup ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			});
			
			$("#txtSellQty").on("keyup",function(event)
			{
				try
				{
					ComputeSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Sell Quantity Keyup ERROR:\n'+e;			
					DisplaySellMessage(m, 'error',Title);
				}
			});
			
			$("#txtSellQty").on("change",function(event)
			{
				try
				{
					ComputeSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Sell Quantity Changed ERROR:\n'+e;			
					DisplaySellMessage(m, 'error',Title);
				}
			});
						
			$("#txtSellPrice").on("keyup",function(event)
			{
				try
				{
					ComputeSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Sell Price Keyup ERROR:\n'+e;			
					DisplaySellMessage(m, 'error',Title);
				}
			});	
			
			$("#txtSellPrice").on("change",function(event)
			{
				try
				{
					ComputeSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Sell Price Changed ERROR:\n'+e;			
					DisplaySellMessage(m, 'error',Title);
				}
			});	
			
			$("#txtBuyQty").on("change",function(event)
			{
				try
				{
					ComputeBuyAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Buy Quantity Changed ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			});
						
			$("#txtBuyPrice").on("change",function(event)
			{
				try
				{
					ComputeBuyAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Buy Price Changed ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			});
			
			$("#txtBuyPrice").on("keyup",function(event)
			{
				try
				{
					ComputeBuyAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Buy Price Keyup ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			});
						
			$("#chkBuySMS").on("click",function(event)
			{
				try
				{
					ComputeBuyAmount();
				}catch(e)
				{
					$.unblockUI();
					m='SMS Fee Clicked ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			});
			
			$("#chkSellSMS").on("click",function(event)
			{
				try
				{
					ComputeSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='SMS Fee Clicked ERROR:\n'+e;			
					DisplaySellMessage(m, 'error',Title);
				}
			});			
			
			$('#cboBuyOrderType').change(function(e) {
                try
				{
					$('#divExpire').addClass('hide').removeClass('show');
					
					var s=$.trim($(this).val()).toLowerCase();
					
					if (s == 'gtm') $('#divExpire').addClass('show').removeClass('hide');
				}catch(e)
				{
					$.unblockUI();
					m='Order Type Change ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
            });
			
			$('#cboSellOrderType').change(function(e) {
                try
				{
					$('#divSellExpire').addClass('hide').removeClass('show');
					
					var s=$.trim($(this).val()).toLowerCase();
					
					if (s == 'gtm') $('#divSellExpire').addClass('show').removeClass('hide');
				}catch(e)
				{
					$.unblockUI();
					m='Order Type Change ERROR:\n'+e;			
					DisplaySellMessage(m, 'error',Title);
				}
            });
			
			function LoadBuyPrice(sym)
			{
				try
				{
					$('#lblBuyMarketPrice').html('');
										
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Symbol Price. Please Wait....</p>',theme: false,baseZ: 2000});	
	
					
					$.ajax({
						url: "<?php echo site_url('ui/Exchange/GetPrice');?>",
						type: 'POST',
						data:{symbol:sym},
						dataType: 'text',
						success: function(data,status,xhr) {	
							$.unblockUI();
							
							var p=data;
							
							$('#lblBuyMarketPrice').html(number_format(p, 2, '.', ','));
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
					m="LoadBuyPrice ERROR:\n"+e;
					DisplayMessage(m,'error',Title);
				}
			}
			
			function LoadSellPrice(sym)
			{
				try
				{
					$('#lblSellMarketPrice').html('');
										
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Symbol Price. Please Wait....</p>',theme: false,baseZ: 2000});	
	
					
					$.ajax({
						url: "<?php echo site_url('ui/Exchange/GetPrice');?>",
						type: 'POST',
						data:{symbol:sym},
						dataType: 'text',
						success: function(data,status,xhr) {	
							$.unblockUI();
							
							var p=data;
							
							$('#lblSellMarketPrice').html(number_format(p, 2, '.', ','));
						},
						error:  function(xhr,status,error) {
							$.unblockUI();
							m='Error '+ xhr.status + ' Occurred: ' + error;
							DisplaySellMessage(m, 'error',Title);
						}
					});		
				}catch(e)
				{
					$.unblockUI();
					m="LoadSellPrice ERROR:\n"+e;
					DisplaySellMessage(m,'error',Title);
				}
			}
			
			function LoadInvestors()
			{
				try
				{
					$('#cboDirectSellInvestor').empty();
					$('#cboBuyInvestor').empty();
					$('#cboSellInvestor').empty();
										
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Investors. Please Wait....</p>',theme: false,baseZ: 2000});	
	
					
					$.ajax({
						url: "<?php echo site_url('ui/Exchange/GetInvestors');?>",
						type: 'POST',
						data:{email:Email},
						dataType: 'json',
						success: function(data,status,xhr) {	
							$.unblockUI();
	
							if ($(data).length > 0)
							{
								$("#cboBuyInvestor").append(new Option('[SELECT]', ''));
								$("#cboSellInvestor").append(new Option('[SELECT]', ''));
								$("#cboDirectSellInvestor").append(new Option('[SELECT]', ''));
								
								$.each($(data), function(i,e)
								{
									if (e.email)
									{
										$("#cboBuyInvestor").append(new Option($.trim(e.user_name).toUpperCase(), $.trim(e.email)));
										$("#cboSellInvestor").append(new Option($.trim(e.user_name).toUpperCase(), $.trim(e.email)));
										$("#cboDirectSellInvestor").append(new Option($.trim(e.user_name).toUpperCase(), $.trim(e.email)));
									}
								});//End each
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
					m="LoadInvestors ERROR:\n"+e;
					DisplayMessage(m,'error',Title);
				}
			}
			
			function LoadOrderTypes()
			{
				try
				{
					$('#cboBuyOrderType').empty();
					$('#cboSellOrderType').empty();
										
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Order Types. Please Wait....</p>',theme: false,baseZ: 2000});	
	
					
					$.ajax({
						url: "<?php echo site_url('ui/Exchange/GetOrderTypes');?>",
						type: 'POST',
						dataType: 'json',
						success: function(data,status,xhr) {	
							$.unblockUI();
	
							if ($(data).length > 0)
							{
								$("#cboBuyOrderType").append(new Option('[SELECT]', ''));
								$("#cboSellOrderType").append(new Option('[SELECT]', ''));
								
								$.each($(data), function(i,e)
								{
									if (e.ordertype)
									{
										var ty='';
										
										if (e.description) ty = $.trim(e.description).toUpperCase();
										
										if (ty)
										{
											ty += ' (' + $.trim(e.ordertype).toUpperCase() + ')';
										}else
										{
											ty = $.trim(e.ordertype).toUpperCase();
										}
										
										$("#cboBuyOrderType").append(new Option(ty, $.trim(e.ordertype).toUpperCase()));
										$("#cboSellOrderType").append(new Option(ty, $.trim(e.ordertype).toUpperCase()));
									}
								});//End each
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
					m="LoadOrderTypes ERROR:\n"+e;
					DisplayMessage(m,'error',Title);
				}
			}
			
			function ComputeSellAmount()
			{
				try
				{
					$('#lblSellAmount').html('');					
					$('#lblSellBrokerFee').html('');
					$('#lblSellNSEFee').html('');
					$('#lblSellTotalAmount').html('');					
					
					var qty=$.trim($('#txtSellQty').val()).replace(new RegExp(',', 'g'), '');					
					var price=$.trim($('#txtSellPrice').val()).replace(new RegExp(',', 'g'), '');				
					price=price.replace(new RegExp('₦', 'g'), '');
					
					var sms=0;
					
					if ($('#chkSellSMS').is(':checked')) sms='<?php echo $sms_fee; ?>';
										
					
					CurrentSymbolPrice=CurrentSymbolPrice.replace(new RegExp(',', 'g'), '');				
					CurrentSymbolPrice=CurrentSymbolPrice.replace(new RegExp('₦', 'g'), '');
					
					var price_limit_percent = '<?php echo $price_limit_percent; ?>';
					var diff=(parseFloat(price_limit_percent)/100) * parseFloat(CurrentSymbolPrice);		
					
					var lowerlimit = parseFloat(CurrentSymbolPrice) - parseFloat(diff);
					var upperlimit = parseFloat(CurrentSymbolPrice) + parseFloat(diff);
					
					
					var brokers_rate = '<?php echo $brokers_rate; ?>';
					var nse_rate = '<?php echo $nse_rate; ?>';
					
					var amount = parseFloat(qty) * parseFloat(upperlimit);
					var brokerfee = (parseFloat(brokers_rate)/100) * upperlimit;
					var nsefee = (parseFloat(nse_rate)/100) * upperlimit;
					var total = parseFloat(amount) + parseFloat(brokerfee) + parseFloat((nsefee/2)) + parseFloat((sms*2));
				
					if (parseFloat(amount) > 0) $('#lblSellAmount').html('₦' + number_format(amount, 2, '.', ','));
					if (parseFloat(brokerfee) > 0) $('#lblSellBrokerFee').html('₦' + number_format(brokerfee, 2, '.', ','));
					if (parseFloat(nsefee) > 0) $('#lblSellNSEFee').html('₦' + number_format((nsefee/2), 2, '.', ','));
					if (parseFloat(total) > 0) $('#lblSellTotalAmount').html('₦' + number_format(total, 2, '.', ','));
				}catch(e)
				{
					$.unblockUI();
					m='ComputeSellAmount ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			}
			
			function ComputeBuyAmount()
			{
				try
				{
					$('#lblBuyAmount').html('');					
					$('#lblBuyBrokerFee').html('');
					$('#lblBuyNSEFee').html('');
					$('#lblBuyTotalAmount').html('');					
					
					var qty=$.trim($('#txtBuyQty').val()).replace(new RegExp(',', 'g'), '');					
					var price=$.trim($('#txtBuyPrice').val()).replace(new RegExp(',', 'g'), '');				
					price=price.replace(new RegExp('₦', 'g'), '');
					
					var sms=0;
					
					if ($('#chkBuySMS').is(':checked')) sms='<?php echo $sms_fee; ?>';
										
					
					CurrentSymbolPrice=CurrentSymbolPrice.replace(new RegExp(',', 'g'), '');				
					CurrentSymbolPrice=CurrentSymbolPrice.replace(new RegExp('₦', 'g'), '');
					
					var price_limit_percent = '<?php echo $price_limit_percent; ?>';
					var diff=(parseFloat(price_limit_percent)/100) * parseFloat(CurrentSymbolPrice);		
					
					var lowerlimit = parseFloat(CurrentSymbolPrice) - parseFloat(diff);
					var upperlimit = parseFloat(CurrentSymbolPrice) + parseFloat(diff);
					
					
					var brokers_rate = '<?php echo $brokers_rate; ?>';
					var nse_rate = '<?php echo $nse_rate; ?>';
					
					var amount = parseFloat(qty) * parseFloat(upperlimit);
					var brokerfee = (parseFloat(brokers_rate)/100) * upperlimit;
					var nsefee = (parseFloat(nse_rate)/100) * upperlimit;
					var total = parseFloat(amount) + parseFloat(brokerfee) + parseFloat((nsefee/2)) + parseFloat((sms*2));
				
					if (parseFloat(amount) > 0) $('#lblBuyAmount').html('₦' + number_format(amount, 2, '.', ','));
					if (parseFloat(brokerfee) > 0) $('#lblBuyBrokerFee').html('₦' + number_format(brokerfee, 2, '.', ','));
					if (parseFloat(nsefee) > 0) $('#lblBuyNSEFee').html('₦' + number_format(nsefee, 2, '.', ','));
					if (parseFloat(total) > 0) $('#lblBuyTotalAmount').html('₦' + number_format(total, 2, '.', ','));
					
					//alert('token amount = '+amount+'\nbrokerfee = '+brokerfee+'\nNSE fee = '+(nsefee/2)+'\nSMS = '+sms+'\nEST Total = '+total);
					
				}catch(e)
				{
					$.unblockUI();
					m='ComputeBuyAmount ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
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
			
			$("#divSellModal").on('hidden.bs.modal', function(){
				try
				{
					ResetSell();
				}catch(e)
				{
					$.unblockUI();
					m='Modal Close ERROR:\n'+e;			
					DisplaySellMessage(m, 'error',Title);
				}
			});
			
			function ResetBuy()
			{
				try
				{
					CurrentSymbolPrice='';
					
					$('#lblBuyDate').html('<?php echo date('d M Y'); ?>');
					$('#cboBuyInvestor').val('');
					$('#lblBuyBalance').html('');
					$('#lblBuySymbol').html('');
					$('#lblBuyPortfolioQty').html('');
					$('#txtBuyPrice').val('');
					$('#lblBuyMarketPrice').html('');
					$('#txtBuyQty').val('');
					$('#lblBuyBrokerFee').html('');
					$('#lblBuyNSEFee').html('');
					$('#lblBuyAmount').html('');	
					$('#lblBuyTotalAmount').html('');
					$('#cboBuyOrderType').val('');					
					$('#txtBuyExpiryDate').val('');
					$("#chkBuySMS").prop("checked", false);	
				}catch(e)
				{
					$.unblockUI();
					m='ResetBuy ERROR:\n'+e;				
					DisplayMessage(m, 'error',Title);
				}
			}
			
			function ResetSell()
			{
				try
				{
					CurrentSymbolPrice='';
					
					$('#lblSellDate').html('<?php echo date('d M Y'); ?>');
					$('#cboSellInvestor').val('');
					$('#lblSellBalance').html('');
					$('#lblSellSymbol').html('');
					$('#lblSellPortfolioQty').html('');
					$('#txtSellPrice').val('');
					$('#lblSellMarketPrice').html('');
					$('#txtSellQty').val('');
					$('#lblSellBrokerFee').html('');
					$('#lblSellNSEFee').html('');
					$('#lblSellAmount').html('');	
					$('#lblSellTotalAmount').html('');
					$('#cboSellOrderType').val('');					
					$('#txtSellExpiryDate').val('');	
					$("#chkSellSMS").prop("checked", false);
				}catch(e)
				{
					$.unblockUI();
					m='ResetSell ERROR:\n'+e;				
					DisplaySellMessage(m, 'error',Title);
				}
			}
			
			function CheckBuy()
			{
				try
				{
					var inv=$.trim($('#cboBuyInvestor').val());
					var bal=$.trim($('#lblBuyBalance').html()).replace(new RegExp(',', 'g'), '');				
					bal=bal.replace(new RegExp('₦', 'g'), '');
					
					var sym=$.trim($('#lblBuySymbol').html());
					
					var pr=$.trim($('#txtBuyPrice').val()).replace(new RegExp(',', 'g'), '');				
					pr = pr.replace(new RegExp('₦', 'g'), '');
					
					var qty=$.trim($('#txtBuyQty').val()).replace(new RegExp(',', 'g'), '');
					
					var brfee=$.trim($('#lblBuyBrokerFee').html()).replace(new RegExp(',', 'g'), '');				
					brfee=brfee.replace(new RegExp('₦', 'g'), '');
					
					var nse=$.trim($('#lblBuyNSEFee').html()).replace(new RegExp(',', 'g'), '');				
					nse=nse.replace(new RegExp('₦', 'g'), '');
					
					var amt=$.trim($('#lblBuyAmount').html()).replace(new RegExp(',', 'g'), '');				
					amt=amt.replace(new RegExp('₦', 'g'), '');
					
					var tot=$.trim($('#lblBuyTotalAmount').html()).replace(new RegExp(',', 'g'), '');				
					tot=tot.replace(new RegExp('₦', 'g'), '');
					
					var ty=$.trim($('#cboBuyOrderType').val());
					
					var d=$.trim($('#txtBuyExpiryDate').val());
					
					var sms=0;
					
					if ($('#chkBuySMS').is(':checked'))
					{
						sms = '<?php echo $sms_fee; ?>';						
						sms = parseFloat(sms) * 2;
					}
					
					/************UNCOMMENT LATER *************/
					//Market Status
					/*if ($.trim(MarketStatus).toLowerCase() == 'closed')
					{
						m='Market is closed. You cannot place any order.';						
	
						DisplayMessage(m, 'error',Title);				
	
						return false;
					}*/
					
					//User Email
					if (!Email)
					{
						m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of tokens.';						
	
						DisplayMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Investor					
					if ($('#cboBuyInvestor > option').length < 2)
					{
						m='You have not registered any investor under your account.';
						DisplayMessage(m, 'error',Title);					
						return false;
					}
					
					if (!inv)
					{
						m='Please select the investor who is buying the tokens.';
						DisplayMessage(m, 'error',Title);					
						$('#cboBuyInvestor').focus(); return false;
					}					
									
					//Symbol
					if (!sym)
					{
						m='No asset is displaying. Refresh the page or logout and login again before continue.';
						DisplayMessage(m, 'error',Title);					
						return false;
					}
					
					//Order Type
					if ($('#cboBuyOrderType > option').length < 2)
					{
						m='Types of market orders have not been captured. Please contact the system administrator at support@naijaartmart.com';
						DisplayMessage(m, 'error',Title);					
						return false;
					}
					
					/*if (!ty)
					{
						m='Please select the type or order you want to place.';
						DisplayMessage(m, 'error',Title);					
						$('#cboBuyOrderType').focus(); return false;
					}*/
					
					if ($.trim(ty).toUpperCase() == 'AON')
					{
						//Price
						if (!pr)
						{
							m='Asset price field MUST not be blank.';				
							DisplayMessage(m, 'error',Title);					
							return false;
						}
						
						if (!$.isNumeric(pr))
						{
							m='Asset price MUST be a number.';						
							DisplayMessage(m, 'error',Title);
							return false;
						}
		
						if (parseFloat(pr) == 0)
						{
							m='Asset price must not be zero.';				
							DisplayMessage(m, 'error',Title);
							return false;
						}
						
						if (parseFloat(pr) < 0)
						{
							m='Asset price must not be a negative number.';				
							DisplayMessage(m, 'error',Title);
							return false;
						}	
					}else
					{
						if (!ty) $('#cboBuyOrderType').val('MO');
						
						//Price
						if (parseFloat(pr) > 0)
						{
							if (!$.isNumeric(pr))
							{
								m='Asset price MUST be a number.';						
								DisplayMessage(m, 'error',Title);
								return false;
							}
			
							if (parseFloat(pr) == 0)
							{
								m='Asset price must not be zero.';				
								DisplayMessage(m, 'error',Title);
								return false;
							}
							
							if (parseFloat(pr) < 0)
							{
								m='Asset price must not be a negative number.';				
								DisplayMessage(m, 'error',Title);
								return false;
							}		
						}
					}										
										
					//Lower/Upper Price Limits
					if (parseFloat(pr) > 0)
					{
						CurrentSymbolPrice=CurrentSymbolPrice.replace(new RegExp(',', 'g'), '');				
						CurrentSymbolPrice=CurrentSymbolPrice.replace(new RegExp('₦', 'g'), '');
						
						var price_limit_percent = '<?php echo $price_limit_percent; ?>';
						var diff=(parseFloat(price_limit_percent)/100) * parseFloat(CurrentSymbolPrice);		
						
						var lowerlimit = parseFloat(CurrentSymbolPrice) - parseFloat(diff);
						var upperlimit = parseFloat(CurrentSymbolPrice) + parseFloat(diff);	
						
						if (parseFloat(pr) < parseFloat(lowerlimit))//Exceeded lower limit
						{
							m="The order price, <b>₦" + number_format(pr,2,'.',',') + "</b>, is less than the minimum price, <b>₦" + number_format(lowerlimit,2,'.',',') + "</b>, allowed for the asset.";
							
							DisplayMessage(m, 'error',Title);
							return false;
						}
						
						if (parseFloat(pr) > parseFloat(upperlimit))//Exceeded upper limit
						{
							m="The order price, <b>₦" + number_format(pr,2,'.',',') + "</b>, is more than the maximum price, <b>₦" + number_format(upperlimit,2,'.',',') + "</b>, allowed for the asset. Please resend the order with a valid price.";
							
							DisplayMessage(m, 'error',Title);
							return false;
						}	
					}					
																	
					//Qty
					if (!qty)
					{
						m='Order quantity MUST not be blank.';				
						DisplayMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(qty))
					{
						m='Order quantity MUST be a number. Current entry <b>'+qty+'</b> is not valid.';						
						DisplayMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(qty) == 0)
					{
						m='Order quantity must not be zero.';				
						DisplayMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(qty) < 0)
					{
						m='Order quantity must not be a negative number.';				
						DisplayMessage(m, 'error',Title);
						return false;
					}	
					
					//Broker
					if (!brfee)
					{
						m='Broker fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of tokens. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayMessage(m, 'error',Title);				
	
						return false;
					}
					
					//NSE Fee
					if (!nse)
					{
						m='NSE fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of tokens. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Token Amount
					if (!amt)
					{
						m='Amount for the token to buy is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of tokens. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Estimated Total Amount
					if (!tot)
					{
						m='Total estimated amount for the order is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of tokens. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayMessage(m, 'error',Title);				
	
						return false;
					}
								
					
					//Wallet balance
					if (!bal)
					{
						m='Your e-wallet balance is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of tokens. If the issue still persists after signout and signin and you are sure that you have credited your e-wallet, please contact the system administrator at support@naijaartmart.com, otherwise credit your wallet through <a href="<?php echo site_url('ui/Wallet'); ?>">Wallet Module</a> on your side menu.';	
								
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
					
					//Check if balance can buy
					if (parseFloat(bal) < parseFloat(tot))//Not enough balance
					{
						m="Your e-wallet balance, <b>₦" + number_format(bal,2,'.',',') + "</b>, is not sufficient to fund the order. Total estimated order amount is <b>₦" + number_format(tot,2,'.',',') + "</b>. Please fund your e-wallet with enough funds before placing the order.";
						
						DisplayMessage(m, 'error',Title);
						return false;
					}					
					
					//Expiry Date - GTM
					if ($.trim(ty).toUpperCase() == 'GTM')
					{
						if (!d)
						{
							m="You must select the month and year this order is expected to expire if not executed. Select from the date control. Format is MONTH YEAR (Eg. Jan 2020).";
							
							DisplayMessage(m, 'error',Title);					
							$('#txtBuyExpiryDate').focus(); return false;
						}
					}				
		
					if (!ty) ty='MO';			
					
					//Confirm Update				
					Swal.fire({
					  title: 'PLEASE CONFIRM',
					  html: '<font size="3" face="Arial">Do you want to proceed with the buying of the tokens?</font>',
					  type: 'question',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  cancelButtonText: '<font size="3" face="Arial">No</font>',
					  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
					}).then((result) => {
					  if (result.value)
					  {
						$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Buying Tokens. Please Wait...</p>',theme: false,baseZ: 2000});

					var mdata={email:Email, investor_id:inv, transtype:'Buy',symbol:sym, price:pr, qty:qty, available_qty:qty, ordertype:ty, orderstatus:'Submitted', expirydate:d, sms_fee:sms}						
									
						//Make Ajax Request			
						$.ajax({
							url: '<?php echo site_url('ui/Exchange/BuyTokens'); ?>',
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
											$("#chkBuySMS").prop("checked", false);
											$('#cboBuyInvestor').val('');
											$('#lblBuyBalance').html('');
											$('#txtBuyPrice').val('');
											$('#lblBuyMarketPrice').html(CurrentSymbolPrice);
											$('#txtBuyQty').val('');
											$('#lblBuyBrokerFee').html('');
											$('#lblBuyNSEFee').html('');
											$('#lblBuyAmount').html('');	
											$('#lblBuyTotalAmount').html('');
											$('#cboBuyOrderType').val('');					
											$('#txtBuyExpiryDate').val('');	
											$('#divExpire').addClass('hide').removeClass('show');	
											
											GetBalance();
											LoadOrders();
											LoadMessages();
											LoadMarketData();
											GetPortfolioTokens(sym,inv);
											LoadBuyPrice(sym);
				
											m= 'Order to buy '+number_format(qty, '0', '', ',') + ' tokens of '+ $.trim(sym).toUpperCase() +' was placed successfully.';
											
											DisplayMessage(m, 'success','Buy Order Placed','SuccessTheme');
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
					m='CheckBuy ERROR:\n'+e;				
					DisplayMessage(m, 'error',Title);
				}		
			}//End CheckBuy
			
			function CheckSell()
			{
				try
				{
					var inv=$.trim($('#cboSellInvestor').val());
					var bal=$.trim($('#lblSellBalance').html()).replace(new RegExp(',', 'g'), '');				
					bal=bal.replace(new RegExp('₦', 'g'), '');
					
					var sym=$.trim($('#lblSellSymbol').html());
					
					var pr=$.trim($('#txtSellPrice').val()).replace(new RegExp(',', 'g'), '');				
					pr = pr.replace(new RegExp('₦', 'g'), '');
					
					var qty=$.trim($('#txtSellQty').val()).replace(new RegExp(',', 'g'), '');
					
					var portqty=$.trim($('#lblSellPortfolioQty').html()).replace(new RegExp(',', 'g'), '');
					
					var brfee=$.trim($('#lblSellBrokerFee').html()).replace(new RegExp(',', 'g'), '');				
					brfee=brfee.replace(new RegExp('₦', 'g'), '');
					
					var nse=$.trim($('#lblSellNSEFee').html()).replace(new RegExp(',', 'g'), '');				
					nse=nse.replace(new RegExp('₦', 'g'), '');
					
					var amt=$.trim($('#lblSellAmount').html()).replace(new RegExp(',', 'g'), '');				
					amt=amt.replace(new RegExp('₦', 'g'), '');
					
					var tot=$.trim($('#lblSellTotalAmount').html()).replace(new RegExp(',', 'g'), '');				
					tot=tot.replace(new RegExp('₦', 'g'), '');
					
					var ty=$.trim($('#cboSellOrderType').val());
					
					var d=$.trim($('#txtSellExpiryDate').val());
					
					var sms='0';
					
					if ($('#chkSellSMS').is(':checked'))
					{
						sms = '<?php echo $sms_fee; ?>';						
						sms = parseFloat(sms) * 2;
					}
					
					//UNCOMMENT THIS LATER
					/*if ($.trim(MarketStatus).toLowerCase() == 'closed')
					{
						m='Market is closed. You cannot place any order.';						
	
						DisplaySellMessage(m, 'error',Title);				
	
						return false;
					}*/
					
					//User Email
					if (!Email)
					{
						m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of tokens.';						
	
						DisplaySellMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Investor					
					if ($('#cboSellInvestor > option').length < 2)
					{
						m='You have not registered any investor under your account.';
						DisplaySellMessage(m, 'error',Title);					
						return false;
					}
					
					if (!inv)
					{
						m='Please select the investor who is selling the tokens.';
						DisplaySellMessage(m, 'error',Title);					
						$('#cboSellInvestor').focus(); return false;
					}					
									
					//Symbol
					if (!sym)
					{
						m='No asset is displaying. Refresh the page or logout and login again before continue.';
						DisplaySellMessage(m, 'error',Title);					
						return false;
					}
					
					//Order Type
					if ($('#cboSellOrderType > option').length < 2)
					{
						m='Types of market orders have not been captured. Please contact the system administrator at support@naijaartmart.com';
						DisplaySellMessage(m, 'error',Title);					
						return false;
					}
					
					/*if (!ty)
					{
						m='Please select the type or order you want to place.';
						DisplaySellMessage(m, 'error',Title);					
						$('#cboSellOrderType').focus(); return false;
					}*/
					
					if ($.trim(ty).toUpperCase() == 'AON')
					{
						//Price
						if (!pr)
						{
							m='Asset price field MUST not be blank.';				
							DisplaySellMessage(m, 'error',Title);					
							return false;
						}
						
						if (!$.isNumeric(pr))
						{
							m='Asset price MUST be a number.';						
							DisplaySellMessage(m, 'error',Title);
							return false;
						}
		
						if (parseFloat(pr) == 0)
						{
							m='Asset price must not be zero.';				
							DisplaySellMessage(m, 'error',Title);
							return false;
						}
						
						if (parseFloat(pr) < 0)
						{
							m='Asset price must not be a negative number.';				
							DisplaySellMessage(m, 'error',Title);
							return false;
						}	
					}else
					{
						if (!ty) $('#cboSellOrderType').val('MO');
						
						//Price
						if (parseFloat(pr) > 0)
						{
							if (!$.isNumeric(pr))
							{
								m='Asset price MUST be a number.';						
								DisplaySellMessage(m, 'error',Title);
								return false;
							}
			
							if (parseFloat(pr) == 0)
							{
								m='Asset price must not be zero.';				
								DisplaySellMessage(m, 'error',Title);
								return false;
							}
							
							if (parseFloat(pr) < 0)
							{
								m='Asset price must not be a negative number.';				
								DisplaySellMessage(m, 'error',Title);
								return false;
							}		
						}
					}										
										
					//Lower/Upper Price Limits
					if (parseFloat(pr) > 0)
					{
						CurrentSymbolPrice=CurrentSymbolPrice.replace(new RegExp(',', 'g'), '');				
						CurrentSymbolPrice=CurrentSymbolPrice.replace(new RegExp('₦', 'g'), '');
						
						var price_limit_percent = '<?php echo $price_limit_percent; ?>';
						var diff=(parseFloat(price_limit_percent)/100) * parseFloat(CurrentSymbolPrice);		
						
						var lowerlimit = parseFloat(CurrentSymbolPrice) - parseFloat(diff);
						var upperlimit = parseFloat(CurrentSymbolPrice) + parseFloat(diff);	
						
						if (parseFloat(pr) < parseFloat(lowerlimit))//Exceeded lower limit
						{
							m="The order price, <b>₦" + number_format(pr,2,'.',',') + "</b>, is less than the minimum price, <b>₦" + number_format(lowerlimit,2,'.',',') + "</b>, allowed for the asset.";
							
							DisplaySellMessage(m, 'error',Title);
							return false;
						}
						
						if (parseFloat(pr) > parseFloat(upperlimit))//Exceeded upper limit
						{
							m="The order price, <b>₦" + number_format(pr,2,'.',',') + "</b>, is more than the maximum price, <b>₦" + number_format(upperlimit,2,'.',',') + "</b>, allowed for the asset. Please resend the order with a valid price.";
							
							DisplaySellMessage(m, 'error',Title);
							return false;
						}	
					}					
																	
					//Qty
					if (!qty)
					{
						m='Order quantity MUST not be blank.';				
						DisplaySellMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(qty))
					{
						m='Order quantity MUST be a number. Current entry <b>'+qty+'</b> is not valid.';						
						DisplaySellMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(qty) == 0)
					{
						m='Order quantity must not be zero.';				
						DisplaySellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(qty) < 0)
					{
						m='Order quantity must not be a negative number.';				
						DisplaySellMessage(m, 'error',Title);
						return false;
					}
					
					//Available and qty to sell
					if (parseFloat(portqty) == 0)
					{
						m="You do not have any token of <b>"+ sym.toUpperCase() + "</b> in your portfolio to sell.";
						DisplaySellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(portqty) < parseFloat(qty))
					{
						m="You don't have enough tokens of <b>"+ sym.toUpperCase() + "</b> in your portfolio to sell. The number of tokens of the asset in your portfolio currently is <b>"+ number_format(portqty,0,'',',') + "</b>.";
						DisplaySellMessage(m, 'error',Title);
						return false;
					}
					
					//Broker
					if (!brfee)
					{
						m='Broker fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the selling of tokens. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplaySellMessage(m, 'error',Title);				
	
						return false;
					}
					
					//NSE Fee
					if (!nse)
					{
						m='NSE fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the selling of tokens. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplaySellMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Token Amount
					if (!amt)
					{
						m='Amount for the token to sell is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the selling of tokens. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplaySellMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Estimated Total Amount
					if (!tot)
					{
						m='Total estimated amount for the order is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the selling of tokens. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplaySellMessage(m, 'error',Title);				
	
						return false;
					}
								
					
					//Wallet balance
					/*if (!bal)
					{
						m='Your e-wallet balance is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the selling of tokens. If the issue still persists after signout and signin and you are sure that you have credited your e-wallet, please contact the system administrator at support@naijaartmart.com, otherwise credit your wallet through <a href="<?php echo site_url('ui/Wallet'); ?>">Wallet Module</a> on your side menu.';	
								
						DisplaySellMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(bal))
					{
						m='E-wallet balance MUST be a number.';						
						DisplaySellMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(bal) == 0)
					{
						m='E-wallet balance is zero. Please fund your e-wallet so that you can trade with it.';				
						DisplaySellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(bal) < 0)
					{
						m='E-wallet balance must not be a negative number. Please fund your e-wallet so that you can trade with it.';				
						DisplaySellMessage(m, 'error',Title);
						return false;
					}*/					
					
					//Expiry Date - GTM
					if ($.trim(ty).toUpperCase() == 'GTM')
					{
						if (!d)
						{
							m="You must select the month and year this order is expected to expire if not executed. Select from the date control. Format is MONTH YEAR (Eg. Jan 2020).";
							
							DisplaySellMessage(m, 'error',Title);					
							$('#txtSellExpiryDate').focus(); return false;
						}
					}				
		
					if (!ty) ty='MO';			
					
					//Confirm Update				
					Swal.fire({
					  title: 'PLEASE CONFIRM',
					  html: '<font size="3" face="Arial">Do you want to proceed with the selling of the tokens?</font>',
					  type: 'question',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  cancelButtonText: '<font size="3" face="Arial">No</font>',
					  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
					}).then((result) => {
					  if (result.value)
					  {
						$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Selling Tokens. Please Wait...</p>',theme: false,baseZ: 2000});

					var mdata={email:Email, investor_id:inv, transtype:'Sell',symbol:sym, price:pr, qty:qty, available_qty:qty, ordertype:ty, orderstatus:'Submitted', expirydate:d, sms_fee:sms}						
									
						//Make Ajax Request			
						$.ajax({
							url: '<?php echo site_url('ui/Exchange/SellTokens'); ?>',
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
											$("#chkSellSMS").prop("checked", false);
											$('#cboSellInvestor').val('');
											$('#lblSellBalance').html('');
											$('#txtSellPrice').val('');
											$('#lblSellMarketPrice').html(CurrentSymbolPrice);
											$('#txtSellQty').val('');
											$('#lblSellBrokerFee').html('');
											$('#lblSellNSEFee').html('');
											$('#lblSellAmount').html('');	
											$('#lblSellTotalAmount').html('');
											$('#cboSellOrderType').val('');					
											$('#txtSellExpiryDate').val('');	
											$('#divSellExpire').addClass('hide').removeClass('show');
											
											LoadOrders();
											LoadMessages();
											LoadMarketData();
											GetBalance();
											GetPortfolioTokens(sym,inv);
											LoadSellPrice(sym);
				
											m= 'Order to sell '+number_format(qty, '0', '', ',') + ' tokens of '+ $.trim(sym).toUpperCase() +' was placed successfully.';
											
											DisplaySellMessage(m, 'success','Sell Order Placed','SuccessTheme');
										}else
										{
											m=e.Msg;
											
											DisplaySellMessage(m,'error',Title);		
										}
										
										return;
									});//End each
								}
							},
							error:  function(xhr,status,error) {
								m='Error '+ xhr.status + ' Occurred: ' + error
								DisplaySellMessage(m,'error',Title);
							}
						});
					  }
					})	
				}catch(e)
				{
					$.unblockUI();
					m='CheckSell ERROR:\n'+e;				
					DisplaySellMessage(m, 'error',Title);
				}		
			}//End CheckSell
			
			
			//Direct Sell
			$("#txtDirectSellQty").on("keyup",function(event)
			{
				try
				{
					ComputeSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Sell Quantity Keyup ERROR:\n'+e;			
					DisplaySellMessage(m, 'error',Title);
				}
			});
			
			$("#txtDirectSellQty").on("change",function(event)
			{
				try
				{
					ComputeSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Sell Quantity Changed ERROR:\n'+e;			
					DisplaySellMessage(m, 'error',Title);
				}
			});
						
			$("#txtDirectSellPrice").on("keyup",function(event)
			{
				try
				{
					ComputeSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Sell Price Keyup ERROR:\n'+e;			
					DisplaySellMessage(m, 'error',Title);
				}
			});	
			
			$("#txtDirectSellPrice").on("change",function(event)
			{
				try
				{
					ComputeSellAmount();
				}catch(e)
				{
					$.unblockUI();
					m='Sell Price Changed ERROR:\n'+e;			
					DisplaySellMessage(m, 'error',Title);
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
					
					var price_limit_percent = '<?php echo $price_limit_percent; ?>';
					var diff=(parseFloat(price_limit_percent)/100) * parseFloat(CurrentSymbolPrice);		
					
					var lowerlimit = parseFloat(CurrentSymbolPrice) - parseFloat(diff);
					var upperlimit = parseFloat(CurrentSymbolPrice) + parseFloat(diff);
					
					
					var brokers_rate = '<?php echo $brokers_rate; ?>';
					var nse_rate = '<?php echo $nse_rate; ?>';
					
					var amount = parseFloat(qty) * parseFloat(upperlimit);
					var brokerfee = (parseFloat(brokers_rate)/100) * upperlimit;
					var nsefee = (parseFloat(nse_rate)/100) * upperlimit;
					var total = parseFloat(amount) + parseFloat(brokerfee) + parseFloat((nsefee/2)) + parseFloat((sms*2));
				
					if (parseFloat(amount) > 0) $('#lblSellAmount').html('₦' + number_format(amount, 2, '.', ','));
					if (parseFloat(brokerfee) > 0) $('#lblSellBrokerFee').html('₦' + number_format(brokerfee, 2, '.', ','));
					if (parseFloat(nsefee) > 0) $('#lblSellNSEFee').html('₦' + number_format((nsefee/2), 2, '.', ','));
					if (parseFloat(total) > 0) $('#lblSellTotalAmount').html('₦' + number_format(total, 2, '.', ','));
				}catch(e)
				{
					$.unblockUI();
					m='ComputeDirectSellAmount ERROR:\n'+e;			
					DisplayDirectSellMessage(m, 'error',Title);
				}
			}
			
			function ResetDirectSell()
			{
				try
				{
					CurrentSymbolPrice='';
					
					$('#lblDirectSellDate').html('<?php echo date('d M Y'); ?>');
					$('#cboDirectSellInvestor').val('');
					$('#lblDirectSellBalance').html('');
					$('#lblDirectSellSymbol').html('');
					$('#lblDirectSellPortfolioQty').html('');
					$('#lblDirectSellMarketPrice').html('');
					$('#txtDirectSellQty').val('');
					$('#lblDirectSellBrokerFee').html('');
					$('#lblDirectSellNSEFee').html('');
					$('#lblDirectSellAmount').html('');	
					$('#lblDirectSellTotalAmount').html('');
					$('#cboDirectSellOrderType').val('');
					
					$('#lblDirectSellPrice').html('Selling Price');
					$('#txtDirectSellPrice').val($('#lblDirectSellMarketPrice').html());
					$('#txtDirectSellPrice').prop('readonly',true).css('background-color','#ffffff').css('cursor','default');
					
					GetBalance();				
										
				}catch(e)
				{
					$.unblockUI();
					m='ResetDirectSell ERROR:\n'+e;				
					DisplayDirectSellMessage(m, 'error',Title);
				}
			}
			
			function CheckDirectSell()
			{
				try
				{
					var bal=$.trim($('#lblDirectSellBalance').html()).replace(new RegExp(',', 'g'), '');				
					bal=bal.replace(new RegExp('₦', 'g'), '');
					
					var inv=$.trim($('#cboDirectSellInvestor').val());
					
					var sym=$.trim($('#lblDirectSellSymbol').html());
					
					var mktpr=$.trim($('#lblDirectSellMarketPrice').val()).replace(new RegExp(',', 'g'), '');				
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
					
					var ty=$.trim($('#cboDirectSellOrderType').val());
					
					var sms=$.trim($('#lblDirectSellSMS').html()).replace(new RegExp(',', 'g'), '');				
					sms=sms.replace(new RegExp('₦', 'g'), '');				
															
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
						m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of tokens.';						
	
						DisplayDirectSellMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Investor					
					if ($('#cboSellInvestor > option').length < 2)
					{
						m='You have not registered any investor under your account.';
						DisplayDirectSellMessage(m, 'error',Title);					
						return false;
					}
					
					if (!inv)
					{
						m='Please select the investor who is selling the tokens.';
						DisplayDirectSellMessage(m, 'error',Title);					
						$('#cboSellInvestor').focus(); return false;
					}					
									
					//Symbol
					if (!sym)
					{
						m='No asset is displaying. Refresh the page or logout and login again before continue.';
						DisplayDirectSellMessage(m, 'error',Title);					
						return false;
					}
					
					
					
					if ($.trim(ty).toUpperCase() == 'AON')
					{
						//Price
						if (!pr)
						{
							m='Asset price field MUST not be blank.';				
							DisplayDirectSellMessage(m, 'error',Title);					
							return false;
						}
						
						if (!$.isNumeric(pr))
						{
							m='Asset price MUST be a number.';						
							DisplayDirectSellMessage(m, 'error',Title);
							return false;
						}
		
						if (parseFloat(pr) == 0)
						{
							m='Asset price must not be zero.';				
							DisplayDirectSellMessage(m, 'error',Title);
							return false;
						}
						
						if (parseFloat(pr) < 0)
						{
							m='Asset price must not be a negative number.';				
							DisplayDirectSellMessage(m, 'error',Title);
							return false;
						}	
					}else
					{
						if (!ty) $('#cboSellOrderType').val('MO');
						
						//Price
						if (parseFloat(pr) > 0)
						{
							if (!$.isNumeric(pr))
							{
								m='Asset price MUST be a number.';						
								DisplayDirectSellMessage(m, 'error',Title);
								return false;
							}
			
							if (parseFloat(pr) == 0)
							{
								m='Asset price must not be zero.';				
								DisplayDirectSellMessage(m, 'error',Title);
								return false;
							}
							
							if (parseFloat(pr) < 0)
							{
								m='Asset price must not be a negative number.';				
								DisplayDirectSellMessage(m, 'error',Title);
								return false;
							}		
						}
					}										
										
					//Lower/Upper Price Limits
					if (parseFloat(pr) > 0)
					{
						CurrentSymbolPrice=CurrentSymbolPrice.replace(new RegExp(',', 'g'), '');				
						CurrentSymbolPrice=CurrentSymbolPrice.replace(new RegExp('₦', 'g'), '');
						
						var price_limit_percent = '<?php echo $price_limit_percent; ?>';
						var diff=(parseFloat(price_limit_percent)/100) * parseFloat(CurrentSymbolPrice);		
						
						var lowerlimit = parseFloat(CurrentSymbolPrice) - parseFloat(diff);
						var upperlimit = parseFloat(CurrentSymbolPrice) + parseFloat(diff);	
						
						if (parseFloat(pr) < parseFloat(lowerlimit))//Exceeded lower limit
						{
							m="The order price, <b>₦" + number_format(pr,2,'.',',') + "</b>, is less than the minimum price, <b>₦" + number_format(lowerlimit,2,'.',',') + "</b>, allowed for the asset.";
							
							DisplayDirectSellMessage(m, 'error',Title);
							return false;
						}
						
						if (parseFloat(pr) > parseFloat(upperlimit))//Exceeded upper limit
						{
							m="The order price, <b>₦" + number_format(pr,2,'.',',') + "</b>, is more than the maximum price, <b>₦" + number_format(upperlimit,2,'.',',') + "</b>, allowed for the asset. Please resend the order with a valid price.";
							
							DisplayDirectSellMessage(m, 'error',Title);
							return false;
						}	
					}					
																	
					//Qty
					if (!qty)
					{
						m='Order quantity MUST not be blank.';				
						DisplayDirectSellMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(qty))
					{
						m='Order quantity MUST be a number. Current entry <b>'+qty+'</b> is not valid.';						
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(qty) == 0)
					{
						m='Order quantity must not be zero.';				
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(qty) < 0)
					{
						m='Order quantity must not be a negative number.';				
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
					
					//Available and qty to sell
					if (parseFloat(portqty) == 0)
					{
						m="You do not have any token of <b>"+ sym.toUpperCase() + "</b> in your portfolio to sell.";
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(portqty) < parseFloat(qty))
					{
						m="You don't have enough tokens of <b>"+ sym.toUpperCase() + "</b> in your portfolio to sell. The number of tokens of the asset in your portfolio currently is <b>"+ number_format(portqty,0,'',',') + "</b>.";
						DisplayDirectSellMessage(m, 'error',Title);
						return false;
					}
					
					//Broker
					if (!brfee)
					{
						m='Broker fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the selling of tokens. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayDirectSellMessage(m, 'error',Title);				
	
						return false;
					}
					
					//NSE Fee
					if (!nse)
					{
						m='NSE fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the selling of tokens. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayDirectSellMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Token Amount
					if (!amt)
					{
						m='Amount for the token to sell is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the selling of tokens. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayDirectSellMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Estimated Total Amount
					if (!tot)
					{
						m='Total estimated amount for the order is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the selling of tokens. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayDirectSellMessage(m, 'error',Title);				
	
						return false;
					}
								
					
					//Wallet balance
					/*if (!bal)
					{
						m='Your e-wallet balance is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the selling of tokens. If the issue still persists after signout and signin and you are sure that you have credited your e-wallet, please contact the system administrator at support@naijaartmart.com, otherwise credit your wallet through <a href="<?php echo site_url('ui/Wallet'); ?>">Wallet Module</a> on your side menu.';	
								
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
					
					//Expiry Date - GTM
					if ($.trim(ty).toUpperCase() == 'GTM')
					{
						if (!d)
						{
							m="You must select the month and year this order is expected to expire if not executed. Select from the date control. Format is MONTH YEAR (Eg. Jan 2020).";
							
							DisplayDirectSellMessage(m, 'error',Title);					
							$('#txtSellExpiryDate').focus(); return false;
						}
					}				
		
					if (!ty) ty='MO';			
					
					//Confirm Update				
					Swal.fire({
					  title: 'PLEASE CONFIRM',
					  html: '<font size="3" face="Arial">Do you want to proceed with the selling of the tokens?</font>',
					  type: 'question',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  cancelButtonText: '<font size="3" face="Arial">No</font>',
					  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
					}).then((result) => {
					  if (result.value)
					  {
						$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Selling Tokens. Please Wait...</p>',theme: false,baseZ: 2000});

					var mdata={email:Email, investor_id:inv, transtype:'Sell',symbol:sym, price:pr, qty:qty, available_qty:qty, ordertype:ty, orderstatus:'Submitted', expirydate:d, sms_fee:sms}						
									
						//Make Ajax Request			
						$.ajax({
							url: '<?php echo site_url('ui/Exchange/SellTokens'); ?>',
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
											$("#chkSellSMS").prop("checked", false);
											$('#cboSellInvestor').val('');
											$('#lblSellBalance').html('');
											$('#txtSellPrice').val('');
											$('#lblSellMarketPrice').html(CurrentSymbolPrice);
											$('#txtSellQty').val('');
											$('#lblSellBrokerFee').html('');
											$('#lblSellNSEFee').html('');
											$('#lblSellAmount').html('');	
											$('#lblSellTotalAmount').html('');
											$('#cboSellOrderType').val('');					
											$('#txtSellExpiryDate').val('');	
											$('#divSellExpire').addClass('hide').removeClass('show');
											
											LoadOrders();
											LoadMessages();
											LoadDirectMarketData();
											GetBalance();
											GetPortfolioTokens(sym,inv);
											LoadSellPrice(sym);
				
											m= 'Order to sell '+number_format(qty, '0', '', ',') + ' tokens of '+ $.trim(sym).toUpperCase() +' was placed successfully.';
											
											DisplayDirectSellMessage(m, 'success','Sell Order Placed','SuccessTheme');
										}else
										{
											m=e.Msg;
											
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
			
        });//End document ready
		
		function GetDirectPortfolioTokens(symbol,invEmail)
		{
			try
			{
				$('#lblDirectSellPortfolioQty').html('');
								
				$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Number Of Tokens. Please Wait...</p>',theme: false,baseZ: 2000});
										
				//Make Ajax Request			
				$.ajax({
					url: '<?php echo site_url('ui/Exchange/GetTokensFromPortfolio'); ?>',
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
		
		function GetPortfolioTokens(symbol,invEmail)
		{
			try
			{
				$('#lblBuyPortfolioQty').html('');
				$('#lblSellPortfolioQty').html('');
								
				$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Number Of Tokens. Please Wait...</p>',theme: false,baseZ: 2000});
										
				//Make Ajax Request			
				$.ajax({
					url: '<?php echo site_url('ui/Exchange/GetTokensFromPortfolio'); ?>',
					data: {email:invEmail,symbol:symbol,brokerid:BrokerId},
					type: 'POST',
					dataType: 'text',
					success: function(data,status,xhr) {				
						$.unblockUI();
						
						var b=data;							
						
						if ($.isNumeric(b))
						{
							$('#lblBuyPortfolioQty').html(number_format(b, '0', '', ','));
							$('#lblSellPortfolioQty').html(number_format(b, '0', '', ','));
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
				m='GetPortfolioTokens ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End GetPortfolioTokens
		
		function GetBalance()
		{
			try
			{
				$('#lblBuyBalance').html('');
				$('#lblSellBalance').html('');
				$('#uiWalletBalance').html('');
				$('#lblDirectSellBalance').html('');
				
				$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Wallet Balance. Please Wait...</p>',theme: false,baseZ: 2000});
										
				//Make Ajax Request			
				$.ajax({
					url: '<?php echo site_url('ui/Exchange/GetBalance'); ?>',
					data: {email:Email},
					type: 'POST',
					dataType: 'text',
					success: function(data,status,xhr) {				
						$.unblockUI();
						
						var b=data;							
						
						if ($.isNumeric(b))
						{
							$('#lblBuyBalance').html('₦'+number_format(b, '2', '.', ','));
							$('#lblSellBalance').html('₦'+number_format(b, '2', '.', ','));
							$('#uiWalletBalance').html(number_format(b, '2', '.', ','));
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
			}catch(e)
			{
				$.unblockUI();
				m='GetBalance ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End GetBalance
		
		function BuyArt(sn,sym,price,vol)
		{
			try
			{
				CurrentSymbolPrice = $('#tabMarket > tbody').find("tr").eq(sn).find("td").eq(4).html();
				
				$('#lblBuyBalance').html(GetBalance());
				$('#lblBuySymbol').html(sym);
				$('#lblBuyMarketPrice').html(number_format(CurrentSymbolPrice, '2', '.', ','));
				
				$('#divBuyModal').modal({
				  	fadeDuration: 	1000,
  					fadeDelay: 		0.50,
					keyboard: 		false,
					backdrop:		'static'
				});
			}catch(e)
			{
				$.unblockUI();
				m='BuyArt ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}
		
		function SellArt(sn,sym,price,vol)
		{
			try
			{
				CurrentSymbolPrice= $('#tabMarket > tbody').find("tr").eq(sn).find("td").eq(4).html();
				
				$('#lblSellBalance').html(GetBalance());
				$('#lblSellSymbol').html(sym);
				$('#lblSellMarketPrice').html(number_format(CurrentSymbolPrice, '2', '.', ','));
				
				$('#divSellModal').modal({
				  	fadeDuration: 	1000,
  					fadeDelay: 		0.50,
					keyboard: 		false,
					backdrop:		'static'
				});
			}catch(e)
			{
				$.unblockUI();
				m='SellArt ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}
		
		function UpdateOrder(sn,symbol,order_id,qty,price,ordertype,expirydate,transtype)
		{
			try
			{
				m='Update '+symbol+' '+transtype+' order.';
				
				DisplayMessage(m,'error',Title);
			}catch(e)
			{
				$.unblockUI();
				m='UpdateOrder ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}
		
		function CancelOrder(sn,symbol,order_id,qty,price,ordertype,expirydate,transtype)
		{
			try
			{
				m='Cancel '+symbol+' '+transtype+' order.';
				
				DisplayMessage(m,'error',Title);
			}catch(e)
			{
				$.unblockUI();
				m='CancelOrder ERROR:\n'+e;
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
		
		//Direct Sell
		function SellDirectArt(sn,sym,price,vol)
		{
			try
			{
				CurrentSymbolPrice= $('#tabMarket > tbody').find("tr").eq(sn).find("td").eq(4).html();
				
				$('#lblDirectSellBalance').html(GetBalance());
				$('#lblDirectSellSymbol').html(sym);
				$('#lblDirectSellMarketPrice').html(number_format(CurrentSymbolPrice, '2', '.', ','));
				$('#txtDirectSellPrice').val(number_format(CurrentSymbolPrice, '2', '.', ','));
								
				var sms='<?php echo (floatval($sms_fee) * 2); ?>';
				
				$('#lblDirectSellSMS').html(number_format(sms, '2', '.', ','));				
				
				
				$('#divDirectSellModal').modal({
				  	fadeDuration: 	1000,
  					fadeDelay: 		0.50,
					keyboard: 		false,
					backdrop:		'static'
				});
			}catch(e)
			{
				$.unblockUI();
				m='SellDirectArt ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
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
                                            <a class="nsegreen-dark">Exchange</a>
                                        </li>
                                    </ol>
                                </nav>   
                            </div>
                            
                            <div class="col-sm-9">
                                <div class="col-sm-3">&nbsp;</div>
                                
                                 
                                    
                                <div class="col-sm-7 text-right">
                                    <label for="lblBuyBalance" class=" col-form-label size-17 text-right nsegreen">Trading Date:</label>
                                   <span style="margin-left:5px;" id="lblTime" class=" makebold size-17 redalerttext"></span>
                                 </div>
                            </div>                         
                         </div>                        
                    </div>
                   
					
                    <ul class="nav nav-tabs">
                       <li class="active makebold size-18"><a data-toggle="tab" href="#market">Secondary Market</a></li>
                                              
                       <li class="makebold size-18"><a data-toggle="tab" href="#order">Orders History</a></li>
                       
                       <li class="makebold size-18"><a data-toggle="tab" href="#trade">Trades History</a></li>

                       <!--<li class="makebold size-18"><a data-toggle="tab" href="#book">Oorder Book</a></li>-->
                       
                        <li class="makebold size-18"><a data-toggle="tab" href="#news">News</a></li>
                       <li title="Click to refresh page" onClick="window.location.reload(true);" class="makebold size-18"><a data-toggle="tab" href="#refresh" class="redtext">Refresh</a></li>
                   </ul>
                
                  <div class="tab-content">
                  <!--Market Tab-->
                    <div id="market" class="tab-pane fade in active">
                     	<table class="hover table table-bordered data-table display wrap" id="tabMarket">
                          <thead>
                            <tr>
                                <th style="text-align:center" width="15%">ASSET</th>
                                <th title="Open Price" style="text-align:center" width="11%">OPEN</th>
                                <th title="High Price" style="text-align:center" width="11%">HIGH</th> 
                                <th title="Low Price" style="text-align:center" width="11%">LOW</th>
                                <th title="Close Price"style="text-align:center" width="11%">CLOSE</th>
                                <th style="text-align:center" width="12%">TRADES</th>
                                <th style="text-align:center" width="13%">VOLUME</th>
                                <th style="text-align:center" width="8%"></th>
                                <th style="text-align:center" width="8%"></th>                           
                            </tr>
                          </thead>

                          <tbody id="tbmarketbody"></tbody>
                        </table>
                    </div>
                    
                    <!--Orders Tab-->
                    <div id="order" class="tab-pane fade">                        
                      <table class="hover table table-bordered data-table display wrap" id="tabOrders">
                          <thead>
                            <tr>
                                <th style="text-align:center" width="15%">ORDER&nbsp;DATE</th>
                                <th style="text-align:center" width="10%">ORDER&nbsp;ID</th>
                                <th style="text-align:center" width="10%">ASSET</th> 
                                <th style="text-align:center" width="9%">TOKENS</th>
                                <th style="text-align:center" width="10%">PRICE</th>
                                <th style="text-align:center" width="12%">ORDER&nbsp;TYPE</th>
                                <th style="text-align:center" width="15%">INVESTOR</th>
                                <th style="text-align:center" width="11%">STATUS</th>
                                <th style="text-align:center" width="4%"></th>
                                <th style="text-align:center" width="4%"></th>
                            </tr>
                          </thead>

                          <tbody id="tbtablebody"></tbody>
                        </table>
                    </div>
                    
                    
                    <!--Trades Tab-->
                    <div id="trade" class="tab-pane fade">
                      <!--Start Date/End Date-->                                       
                        <div class="position-relative row form-group">
                             <!--Start Date--> 
                            <label title="Start Date" for="txtTradeStartDate" class="col-sm-2 col-form-label text-right">Start Date</label>
                        
                            <div title="Start Date" class="col-sm-3 date tradedatepicker">
                                <div class="input-group">
                                    <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtTradeStartDate" placeholder="Trade Start Date">
                                    
                                    <span class="input-group-btn"><button class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                </div>
                             </div>
                             
                              <!--End Date--> 
                              <label title="End Date" for="txtTradeEndDate" class="col-sm-2 col-form-label text-right">End Date</label>
                        
                            <div title="End Date" class="col-sm-3 date tradedatepicker">
                                <div class="input-group">
                                    <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtTradeEndDate" placeholder="Trade End Date">
                                    
                                    <span class="input-group-btn"><button class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                </div>
                                
                             </div>
                             
                             <!--Display Trade-->
                             <div title="Click to display trades" class="col-sm-2">
                             	<button id="btnDisplayTrades" type="button" class="btn btn-primary form-control makebold">DISPLAY TRADES</button>
                             </div>
                        </div>
                        
                      <table class="hover table table-bordered data-table display wrap" id="tabTrades">
                          <thead>
                            <tr>
                                <th style="text-align:center" width="15%">TRADE DATE</th>
                                <th style="text-align:center" width="13%">TRADE ID</th>
                                <th style="text-align:center" width="11%">ASSET</th> 
                                <th style="text-align:center" width="11%">TOKENS</th>
                                <th style="text-align:right; padding-right:7px;" width="10%">PRICE</th>
                                <th style="text-align:right; padding-right:7px;" width="14%">AMOUNT</th>
                                <th style="text-align:center" width="13%">SELLER</th>
                                <th style="text-align:center" width="13%">BUYER</th>
                            </tr>
                          </thead>

                          <tbody id="tbtradebody"></tbody>
                          
                          	<tfoot style="color:#ffffff; background-color:#7E7B7B;">
                                    <tr>
                                        <th colspan="5" style="text-align:right; padding:3px; padding-right:10px; font-weight:bold; font-size:13px;" width="54%">TOTAL TRADE AMOUNT (₦):</th>
                                        
                                        <th id="tdAmount" style="text-align:right; padding:3px; padding-right:8px; font-weight:bold; font-size:12px;" width="14%"></th>
                                        
                                         <th colspan="2" id="tdAmount" style="text-align:right; padding:3px; padding-right:8px; font-weight:bold; font-size:12px;" width="26%"></th>
                                    </tr>
                              </tfoot>
                        </table>
                    </div>
                    
                     <!--order book Tab-->
                  <!--  <div id="book" class="tab-pane fade">-->
                      <!--Asset-->                                       
                      <!--  <div title="Asset" class="position-relative row form-group">
                            <label for="cboOrderSymbol" class="col-sm-2 col-form-label">Symbol</label>
                        
                            <div class="col-sm-4">
                                <select id="cboOrderSymbol" class="form-control"></select>
                             </div>
                        </div>
                        
                      	<span> <span style="font-weight:bold; color:#A00;">SELL ORDERS</span> <span style="float:right; margin-right:10px; font-weight:bold; color:#00A;">BUY ORDERS</span></span>
                        
                        <table class="size-14" align="center" width="100%" style="width:100%; background:#E7E7E7; height:auto">
                            <tr>
                                <td valign="top" style="width:49.5%;">
                                    <!--(Sell) Bid - Blue	-->										
                                    <!-- <table id="tabSellBook" style="width:100%;" class="hover sell-table-striped table table-bordered data-table display wrap">
                                        <thead>
                                            <tr style="background:#413A3A; color: #ffffff;">
                                                <th style="width:30%; text-align:center;">Submit&nbsp;Date</th>
                                                <th style="width:15%; text-align:center;">Order&nbsp;ID</th>
                                                <th style="width:23; text-align:center;%">Broker&nbsp;ID</th>
                                                <th style="width:16; text-align:center;%">Qty</th>
                                                <th style="width:16%; text-align:right;">Price</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody id="tbsellbody"></tbody>
                                     </table>              
                                </td>
                                
                                
                                <td valign="top" style="width:5px; "></td>
                               
                                <td valign="top" style="width:49.5%;">
                                   <!--(Buy) Ask - Red-->
                                <!--     <table id="tabBuyBook" width="100%" class="hover buy-table-striped table table-bordered data-table display wrap">
                                        <thead>
                                            <tr style="background:#413A3A; color: #ffffff;">
                                                <th style="width:30%; text-align:center;">Submit&nbsp;Date</th>
                                                <th style="width:15; text-align:center;%">Order&nbsp;ID</th>
                                                <th style="width:23%; text-align:center;">Broker&nbsp;ID</th>
                                                <th style="width:16%; text-align:center;">Qty</th>
                                                <th style="width:16%; text-align:right;">Price</th>														
                                            </tr>
                                        </thead>
                                        
                                        <tbody id="tbbuybody"></tbody>
                                     </table> 
                                </td>
                            </tr>
                        </table>
                               
                    </div> -->
                    
                    
                    <!--news Tab-->
                    <div id="news" class="tab-pane fade">
                      <table class="hover table table-bordered data-table display wrap" id="tabNews">
                          <thead>
                            <tr>
                                <th style="text-align:center" width="12%">DATE</th>
                                <th style="text-align:center" width="53%">HEADER</th>
                                <th style="text-align:center;" width="30%">SENDER</th>
                                <th title="Click Icon To View Message" style="text-align:center" width="5%">VIEW</th> <!--View-->
                            </tr>
                          </thead>

                          <tbody id="tbnewsbody"></tbody>
                        </table>
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


<!-- ******************************** DIRECT TRADE SECTION ****************************-->
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
                    <label for="cboDirectSellInvestor" class="col-sm-3 col-form-label nsegreen text-right">Investor<span class="redtext">*</span></label>
                    
                    <div class="col-sm-9">
                        <select id="cboDirectSellInvestor" class="form-control" ></select>
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
                        
                         <input type="text" id="txtDirectSellPrice" placeholder="Selling Price" class="form-control size-19 makebold">
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
            
             <!--Token Amount/SMS Fee-->
             <div class="position-relative row form-group">
                <label style="padding-left:0px;" title="Token Amount" for="lblDirectSellAmount" class="col-sm-3 col-form-label nsegreen text-right labelmiddle">Token Amount <i data-toggle="tooltip" data-placement="right auto" title="This is the amount for the quantity of tokens to sell excluding fees/commission." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="Token Amount" class="col-sm-4">
                	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellAmount" class="col-form-label redalerttext labelmiddle"></label>
                    </div>                    
                </div>
                
                <!--SMS Fee-->
                <label title="SMS Fee" for="lblDirectSellSMS" class="col-sm-2 col-form-label text-right nsegreen labelmiddle">SMS Fee<i data-toggle="tooltip" data-placement="right auto" title="Covers cost of sending trading status SMS to investor and broker." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="SMS Fee" class="col-sm-3">
                	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellSMS" class="col-form-label labelmiddle"></label>
                    </div>
                </div>
            </div>   
            
            <!--Total Trade Amount-->
             <div class="position-relative row form-group">
                <!--Total Trade Amount-->
                <label title="Total Trade Amount" for="lblDirectSellTotalAmount" class="col-sm-3 col-form-label text-right nsegreen labelmiddle">Total Trade Amount <i data-toggle="tooltip" data-placement="right auto" title="This is the total trade amount including all the fees/commission." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="Total Trade Amount" class="col-sm-4">
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
      </div>
    </div>
  </div>
</div>
<!-- End Direct Sell Popup-->
<!-- ******************************** END OF DIRECT TRADE SECTION *********************-->



<!-- ******************************** MATCHING ENGINE TRADE SECTION ****************************-->
<!--Buy Popup-->
<div id="divBuyModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        	<b><span class="redtext" style="margin-right:39px;">BUY ORDER:</span> <span class="col-form-label text-right nsegreen">Order Date&nbsp;&nbsp;</span> <span style="margin-left:10px;" id="lblBuyDate" class="col-form-label"><?php echo date('d M Y'); ?></span></b>
            
           <span style="float:right">Fields With <span class="redtext">*</span> Are Required               
               <button style="margin-left:50px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
           </span>            
        </h5>        
      </div>
      
      <div class="modal-body">
        <form>            
            <!--Investor-->
            <div class="row">
                 <div title="Investor" class="position-relative row form-group">
                    <label for="cboBuyInvestor" class="col-sm-3 col-form-label  nsegreen">Investor<span class="redtext">*</span></label>
                    
                    <div class="col-sm-9">
                        <select id="cboBuyInvestor" class="form-control" ></select>
                    </div>
                </div>
            </div>
            
            <!--Balance-->
             <div title="Wallet Balance" class="position-relative row form-group">
                <label for="lblBuyBalance" class="col-sm-3 col-form-label  nsegreen">Wallet Balance</label>
                
                <div class="col-sm-4">
                    <label id="lblBuyBalance" class="col-form-label"></label>
                </div>
                
                <!--Portfolio Qty-->
                <label title="Number of tokens in portfolio" for="lblBuyPortfolioQty" class="col-sm-2 col-form-label nsegreen">Portfolio Qty</label>
                
                <div title="Number of tokens in portfolio" class="col-sm-3">
                    <label id="lblBuyPortfolioQty" class="col-form-label redalerttext"></label>
                </div>
            </div>
                        
            <!--Asset/Market Price-->
             <div class="position-relative row form-group">                
                <label title="Asset" for="lblBuySymbol" class="col-sm-3 col-form-label nsegreen">Asset</label>
                
                <div title="Asset" class="col-sm-4">
                    <label id="lblBuySymbol" class="col-form-label redalerttext"></label>
                </div>
                
                <!--Market Price-->
                <label title="Market Price" for="lblBuyMarketPrice" class="col-sm-2 col-form-label nsegreen text-right">Market Price</label>
                
                
                <div title="Current Market Price" class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                        
                         <label id="lblBuyMarketPrice" class="col-form-label redalerttext"></label>
                    </div>    
                </div>
            </div>
            
            <!--Price/Portfolio Qty-->            
             <div class="position-relative row form-group">
                <label style="padding-left:0px;" title="Asset Price" for="txtBuyPrice" class="col-sm-3 col-form-label nsegreen">Price</label>
                
                <div  title="Asset Price" class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                        
                         <input min="0" type="text" id="txtBuyPrice" placeholder="Buying Price" class="form-control size-19 makebold">
                    </div>
                </div>
                
                <!--No Of Tokens-->
                <label title="Number of tokens to buy" for="txtBuyQty" class="col-sm-2 col-form-label text-right nsegreen">No Of Tokens<span class="redtext">*</span></label>
                
                <div title="Number of tokens to buy" class="col-sm-3">
                    <input min="0" type="number" class="form-control" placeholder="No Of Tokens To Buy" id="txtBuyQty">
                </div>
            </div>
                      
            <!--Broker Fee/NSE Fee-->
             <div class="position-relative row form-group">
                <label style="padding-left:0px;" title="Broker Fee" for="lblBuyBrokerFee" class="col-sm-3 col-form-label  nsegreen">Broker Fee <i data-toggle="tooltip" data-placement="right auto" title="Please note that the Broker fee displayed is an estimated value. The actual value will be determined during trade execution." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="Broker Fee" class="col-sm-4">
                    <label id="lblBuyBrokerFee" class="col-form-label redalerttext"></label>
                </div>
                
                  <!--NSE Fee-->
                 <label title="NSE Fee" for="lblBuyNSEFee" class="col-sm-2 col-form-label text-right nsegreen">NSE Fee <i data-toggle="tooltip" data-placement="right auto" title="Please note that the NSE fee displayed is an estimated value. The actual value will be determined during trade execution." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                 
                 <div title="NSE Fee" class="col-sm-3">
                    <label id="lblBuyNSEFee" class="col-form-label redalerttext"></label>
                </div>  
            </div>
            
             <!--Token Amount/Total Amount-->
             <div class="position-relative row form-group">
                <label style="padding-left:0px;" title="Token Amount" for="lblBuyAmount" class="col-sm-3 col-form-label nsegreen">Token Amount <i data-toggle="tooltip" data-placement="right auto" title="Please note that the token amount displayed is an estimated value. The actual value will be determined during trade execution." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="Token Amount" class="col-sm-4">
                    <label id="lblBuyAmount" class="col-form-label redalerttext"></label>
                </div>
                
                <!--Total Amount-->
                <label title="Total Estimated Amount" for="lblBuyTotalAmount" class="col-sm-2 col-form-label text-right nsegreen">EST. TOTAL <i data-toggle="tooltip" data-placement="right auto" title="Please note that the total amount displayed here is an estimated value. The actual value will be determined during trade execution." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div style="background:#AF4442; color:#ffffff;" title="Total Estimated Amount" class="col-sm-3">
                    <label id="lblBuyTotalAmount" class="col-form-label"></label>
                </div>
            </div>                 
            
            <!--Order Type-->
            <div class="row">
                 <div title="Order Type" class="position-relative row form-group">
                    <label for="cboBuyOrderType" class="col-sm-3 col-form-label nsegreen">Order Type <i data-toggle="tooltip" data-placement="right auto" title="Please note that if you select GOOD TILL MONTH-END (GTM), you will be required to select the month and year the order is expected to expire from the control below if the order is not executed." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                    
                    <div class="col-sm-9">
                        <select id="cboBuyOrderType" class="form-control"></select>
                    </div>
                </div>
            </div>
            
             <!--Expiry Date For Good Till Cancelled-->
            <div id="divExpire" class="row hide">
                 <div title="Expiry Date (Month Year)" class="position-relative row form-group">
                    <label for="txtBuyExpiryDate" class="col-sm-3 col-form-label nsegreen">Expiry Mon/Year</label>
                    
                   <div title="Expiry Date (Month Year)" class="col-sm-9 date datepicker">
                   		<div class="input-group">
                            <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtBuyExpiryDate" placeholder="Expiry Date (Month Year)">
                            
                            <span class="input-group-btn"><button class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                        </div>
                        
                     </div>
                </div>
            </div>
            
            <!--SMS-->
            <div title="Click to request for sms when there is trade (incurs extra cost)" class="row">
                <div class="custom-checkbox custom-control  makebold col-sm-9 col-sm-offset-3">
                    <input type="checkbox" id="chkBuySMS" class="custom-control-input">
                    <label class="custom-control-label redalerttext" for="chkBuySMS">Send Me SMS When There Is Trade <i data-toggle="tooltip" data-placement="right auto" title="Please note that selecting this option adds extra charge on the total trade amount for the SMS." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                </div>                                        
            </div>
            
           <div id="divAlert"></div>
        </form>
      </div>      
      
      <div class="modal-footer">
        <button id="btnBuy" type="button" class="btn btn-nse-green">SUBMIT BUY ORDER</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>
<!--End Buy Popup-->


<!--Sell Popup-->
<div id="divSellModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        	<b><span class="redtext" style="margin-right:39px;">SELL ORDER:</span> <span class="col-form-label text-right nsegreen">Order Date&nbsp;&nbsp;</span> <span style="margin-left:10px;" id="lblSellDate" class="col-form-label"><?php echo date('d M Y'); ?></span></b>
            
           <span style="float:right">Fields With <span class="redtext">*</span> Are Required               
               <button style="margin-left:50px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
           </span>            
        </h5>        
      </div>
      
      <div class="modal-body">
        <form>            
            <!--Investor-->
            <div class="row">
                 <div title="Investor" class="position-relative row form-group">
                    <label for="cboSellInvestor" class="col-sm-3 col-form-label  nsegreen">Investor<span class="redtext">*</span></label>
                    
                    <div class="col-sm-9">
                        <select id="cboSellInvestor" class="form-control" ></select>
                    </div>
                </div>
            </div>
            
            <!--Balance/Portfolio Quantity-->
             <div class="position-relative row form-group">
                 <!--Balance-->
                <label title="Wallet Balance" for="lblSellBalance" class="col-sm-3 col-form-label  nsegreen">Wallet Balance</label>
                
                <div title="Wallet Balance" class="col-sm-4">
                    <label id="lblSellBalance" class="col-form-label"></label>
                </div>
                
                <!--Portfolio Qty-->
                <label title="Number of tokens in portfolio" for="lblSellPortfolioQty" class="col-sm-2 col-form-label nsegreen">Portfolio Qty</label>
                
                <div title="Number of tokens in portfolio" class="col-sm-3">
                    <label id="lblSellPortfolioQty" class="col-form-label redalerttext"></label>
                </div>
            </div>
                        
            <!--Asset/Market Price-->
             <div class="position-relative row form-group">
                <label title="Asset" for="lblSellSymbol" class="col-sm-3 col-form-label nsegreen">Asset</label>
                
                <div title="Asset" class="col-sm-4">
                    <label id="lblSellSymbol" class="col-form-label redalerttext"></label>
                </div>
                
                
                <!--Market Price-->
                <label title="Market Price" for="lblSellMarketPrice" class="col-sm-2 col-form-label nsegreen text-right">Market Price</label>
                
                <div title="Current Market Price" class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                        
                         <label id="lblSellMarketPrice" class="col-form-label redalerttext"></label>
                    </div>
                </div>                
            </div>
            
            <!--Price/No of Token-->            
             <div class="position-relative row form-group">
                <label style="padding-left:0px;" title="Asset Price" for="txtSellPrice" class="col-sm-3 col-form-label nsegreen">Price</label>
                
                <div  title="Asset Price" class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                        
                         <input min="0" type="text" id="txtSellPrice" placeholder="Selling Price" class="form-control size-19 makebold">
                    </div>
                </div>
                
                <!--No Of Tokens-->
                <label title="Number of tokens to sell" for="txtSellQty" class="col-sm-2 col-form-label text-right nsegreen">No Of Tokens<span class="redtext">*</span></label>
                
                <div title="Number of tokens to sell" class="col-sm-3">
                    <input min="0" type="number" class="form-control" placeholder="No Of Tokens To Sell" id="txtSellQty">
                </div>
            </div>
                      
            <!--Broker Fee-->
             <div class="position-relative row form-group">
                <label style="padding-left:0px;" title="Broker Fee" for="lblSellBrokerFee" class="col-sm-3 col-form-label  nsegreen">Broker Fee <i data-toggle="tooltip" data-placement="right auto" title="Please note that the Broker fee displayed is an estimated value. The actual value will be determined during trade execution." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="Broker Fee" class="col-sm-4">
                    <label id="lblSellBrokerFee" class="col-form-label redalerttext"></label>
                </div>
                
                  <!--NSE Fee-->
                 <label title="NSE Fee" for="lblSellNSEFee" class="col-sm-2 col-form-label text-right nsegreen">NSE Fee  <i data-toggle="tooltip" data-placement="right auto" title="Please note that the NSE fee displayed is an estimated value. The actual value will be determined during trade execution." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                 
                 <div title="NSE Fee" class="col-sm-3">
                    <label id="lblSellNSEFee" class="col-form-label redalerttext"></label>
                </div>  
            </div>
            
             <!--Token Amount-->
             <div class="position-relative row form-group">
                <label style="padding-left:0px;" title="Token Amount" for="lblSellAmount" class="col-sm-3 col-form-label nsegreen">Token Amount <i data-toggle="tooltip" data-placement="right auto" title="Please note that the token amount displayed is an estimated value. The actual value will be determined during trade execution." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="Token Amount" class="col-sm-4">
                    <label id="lblSellAmount" class="col-form-label redalerttext"></label>
                </div>
                
                <!--Total Amount-->
                <label title="Total Estimated Amount" for="lblSellTotalAmount" class="col-sm-2 col-form-label text-right nsegreen">EST. TOTAL <i data-toggle="tooltip" data-placement="right auto" title="Please note that the total amount displayed here is an estimated value. The actual value will be determined during trade execution." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div style="background:#AF4442; color:#ffffff;" title="Total Estimated Amount" class="col-sm-3">
                    <label id="lblSellTotalAmount" class="col-form-label"></label>
                </div>
            </div>                 
            
            <!--Order Type-->
            <div class="row">
                 <div title="Order Type" class="position-relative row form-group">
                    <label for="cboSellOrderType" class="col-sm-3 col-form-label nsegreen">Order Type <i data-toggle="tooltip" data-placement="right auto" title="Please note that if you select GOOD TILL MONTH-END (GTM), you will be required to select the month and year the order is expected to expire from the control below if the order is not executed." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                    
                    <div class="col-sm-9">
                        <select id="cboSellOrderType" class="form-control"></select>
                    </div>
                </div>
            </div>
            
             <!--Expiry Date For Good Till Cancelled-->
            <div id="divSellExpire" class="row hide">
                 <div title="Expiry Date (Month Year)" class="position-relative row form-group">
                    <label for="txtSellExpiryDate" class="col-sm-3 col-form-label nsegreen">Expiry Mon/Year</label>
                    
                   <div title="Expiry Date (Month Year)" class="col-sm-9 date datepicker">
                   		<div class="input-group">
                            <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtSellExpiryDate" placeholder="Expiry Date (Month Year)">
                            
                            <span class="input-group-btn"><button class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                        </div>
                        
                     </div>
                </div>
            </div>
            
            <!--SMS-->
            <div title="Click to request for sms when there is trade (incurs extra cost)" class="row">
                <div class="custom-checkbox custom-control  makebold col-sm-9 col-sm-offset-3">
                    <input type="checkbox" id="chkSellSMS" class="custom-control-input">
                    <label class="custom-control-label redalerttext" for="chkSellSMS">Send Me SMS When There Is Trade <i data-toggle="tooltip" data-placement="right auto" title="Please note that selecting this option adds extra charge on the total trade amount for the SMS." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                </div>                                        
            </div>
            
           <div id="divSellAlert"></div>
        </form>
      </div>      
      
      <div class="modal-footer">
        <button id="btnSell" type="button" class="btn btn-nse-green">SUBMIT SELL ORDER</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>
<!-- End Sell Popup-->

<!-- ******************************** END OF MATCHING ENGINE TRADE SECTION *********************-->


</body>

</html>
