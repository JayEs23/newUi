<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<title>Naija Art Market | Exchange</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	
    <style>.nav-tabs > li.active > a, .nav-tabs > li > a:hover { border: none;  color: #A8AC2E !important; background: inherit; }</style>
    
    <?php include('reportsheader.php'); ?>
    <?php include('reportscripts.php'); ?>
    
    <style>
    	.*{
    		background: inherit !important;
    	}
    	.modal-content {
		  background-color: #fefefe;
		  margin: 15% auto; /* 15% from the top and centered */
		  padding: 20px;
		  border: 1px solid #888;/*888*/
		  position: relative;
		  margin-top:20px;
		  width: 100%; /* Could be more or less, depending on screen size */
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
		
		.swal-wide{
			width:500px !important;
		}
		
		table.dataTable tbody td {
		  vertical-align: middle;
		}
		* {
			background: white;
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
		var Title='<Naija Art Mart Help';
		var m='';
		var table,tabletrade,tablenews,tableorder,tableseller;
		var Email='<?php echo $email; ?>';
		var Usertype='<?php echo $usertype; ?>';
		var BrokerId='<?php echo $broker_id; ?>';
		var BrokerName='<?php echo $brokername; ?>';
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
		
		function DisplayDirectSellEditMessage(msg,msgtype,msgtitle,theme='AlertTheme')
		{
			try
			{//SuccessTheme, AlertTheme
				$('#divDirectSellEditAlert').html(msg).addClass(theme);
				
				
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
					$('#divDirectSellEditAlert').load(location.href + " #divDirectSellEditAlert").removeClass(theme);
				}, 10000);
			}catch(e)
			{
				alert('ERROR Displaying Message: '+e);
			}
		}
		
		
		$(document).ready(function(e) {
			
			
			$('[data-toggle="tooltip"]').tooltip();
			
			setInterval(function(){
				LoadDirectMarketData();
			}, (RefreshInterval));
	
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
					
					m='Display Trades Button Click ERROR:\n'+e;
					DisplayMessage(m,'error',Title);
				}
            });
			
			function LoadTrades(sdt,edt)
			{
				try
				{
					$.ajax({
						url: "<?php echo site_url('ui/Directexchange/GetTrades');?>",
						type: 'POST',
						data: {email:Email,usertype:Usertype,broker_id:BrokerId,startdate:sdt,enddate:edt},
						dataType: 'json',
						success: function(dataSet,status,xhr) {	
							
							
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
							
							m='Error '+ xhr.status + ' Occurred: ' + error;
							DisplayMessage(m,'error',Title);
						}
					});
				}catch(e)
				{
					
					m='LoadTrades ERROR:\n'+e;
					DisplayMessage(m,'error',Title);
				}
			}
			
			function LoadSymbols()
			{
				try
				{
					$('#cboOrderSymbol').empty();
										
					//$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Assets. Please Wait....</p>',theme: false,baseZ: 2000});	
	
					
					$.ajax({
						url: "<?php echo site_url('ui/Directexchange/GetSymbols');?>",
						type: 'POST',
						dataType: 'json',
						success: function(data,status,xhr) {	
							
	
							if ($(data).length > 0)
							{
								$("#cboOrderSymbol").append(new Option('Select Symbol', ''));
								
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
							
							m='Error '+ xhr.status + ' Occurred: ' + error;
							DisplayMessage(m, 'error',Title);
						}
					});		
				}catch(e)
				{
					
					m="LoadSymbols ERROR:\n"+e;
					DisplayMessage(m,'error',Title);
				}
			}			
			
			function LocateMesssage(mid,hd,det,dt,cat)
			{
				try
				{
					$.redirect("<?php echo base_url(); ?>ui/Messages", {msgid:mid, header:hd, details:det, msgdate:dt,category:cat}, "POST");	
				}catch(e)
				{
					
					m='LocateMesssage ERROR:\n'+e;
					DisplayMessage(m, 'error',Title);
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
					
					m='Direct Sell Investor Change ERROR:\n'+e;			
					DisplayDirectSellMessage(m, 'error',Title);
				}
            });
			
			$('#cboDirectSellEditInvestor').change(function(e) {
                try
				{
					$('#lblDirectSellEditPortfolioQty').html('');
					
					var inv=$.trim($(this).val());
					var sym=$.trim($('#lblDirectSellEditSymbol').html());
					
					if (inv) GetDirectPortfolioTokens(sym,inv);
				}catch(e)
				{
					
					m='Edit Direct Sell Investor Change ERROR:\n'+e;			
					DisplayDirectSellEditMessage(m, 'error',Title);
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
					
					m='Sell Investor Change ERROR:\n'+e;			
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
					
					m='Direct Sell Order Type Change ERROR:\n'+e;			
					DisplayDirectSellMessage(m, 'error',Title);
				}
            });
			
			$('#cboDirectSellEditOrderType').change(function(e) {
                try
				{	
					var ty=$(this).val();
					
					if ($.trim(ty).toLowerCase() == 'limit')
					{
						$('#txtDirectSellEditPrice').val('');
						$('#lblDirectSellEditPrice').html('Selling Price<span class="redtext">*</span>');
						$('#txtDirectSellEditPrice').prop('readonly',false).css('background-color','#ffffff').css('cursor','text');
					}else
					{
						$('#lblDirectSellEditPrice').html('Selling Price');
						$('#txtDirectSellEditPrice').val($('#lblDirectSellEditMarketPrice').html());
						$('#txtDirectSellEditPrice').prop('readonly',true).css('background-color','#ffffff').css('cursor','default');
					}
				}catch(e)
				{
					
					m='Edit Direct Sell Order Type Change ERROR:\n'+e;			
					DisplayDirectSellEditMessage(m, 'error',Title);
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
			
			$('#btnDirectSellEdit').click(function(e) {
                try
				{
					$('#divDirectSellEditAlert').html('');			
					if (!CheckDirectSellEdit()) return false;
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
					
					m='Buy Quantity Keyup ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			});
			
			
			$("#txtBuyQty").on("change",function(event)
			{
				try
				{
					ComputeBuyAmount();
				}catch(e)
				{
					
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
					
					m='SMS Fee Clicked ERROR:\n'+e;			
					DisplayMessage(m, 'error',Title);
				}
			});
					
			function LoadBuyPrice(sym)
			{
				try
				{
					$('#lblBuyMarketPrice').html('');
										
					//$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Symbol Price. Please Wait....</p>',theme: false,baseZ: 2000});	
	
					
					$.ajax({
						url: "<?php echo site_url('ui/Directexchange/GetPrice');?>",
						type: 'POST',
						data:{symbol:sym},
						dataType: 'text',
						success: function(data,status,xhr) {	
							
							
							var p=data;
							
							$('#lblBuyMarketPrice').html(number_format(p, 2, '.', ','));
						},
						error:  function(xhr,status,error) {
							
							m='Error '+ xhr.status + ' Occurred: ' + error;
							DisplayMessage(m, 'error',Title);
						}
					});		
				}catch(e)
				{
					
					m="LoadBuyPrice ERROR:\n"+e;
					DisplayMessage(m,'error',Title);
				}
			}
			
			function LoadInvestors()
			{
				try
				{
					$('#cboDirectSellInvestor').empty();
					$('#cboDirectBuyInvestor').empty();
					$('#cboDirectSellEditInvestor').empty();
					$('#cboSellInvestor').empty();
					
										
					//$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Investors. Please Wait....</p>',theme: false,baseZ: 2000});	
	
					
					$.ajax({
						url: "<?php echo site_url('ui/Directexchange/GetInvestors');?>",
						type: 'POST',
						data:{email:Email},
						dataType: 'json',
						success: function(data,status,xhr) {	
							
	
							if ($(data).length > 0)
							{
								$("#cboSellInvestor").append(new Option('[SELECT]', ''));
								$("#cboDirectSellInvestor").append(new Option('[SELECT]', ''));
								$("#cboDirectBuyInvestor").append(new Option('[SELECT]', ''));
								$("#cboDirectSellEditInvestor").append(new Option('[SELECT]', ''));
								
								$.each($(data), function(i,e)
								{
									if (e.email)
									{
										$("#cboDirectBuyInvestor").append(new Option($.trim(e.user_name).toUpperCase(), $.trim(e.email)));
										$("#cboSellInvestor").append(new Option($.trim(e.user_name).toUpperCase(), $.trim(e.email)));
										$("#cboDirectSellInvestor").append(new Option($.trim(e.user_name).toUpperCase(), $.trim(e.email)));
										$("#cboDirectSellEditInvestor").append(new Option($.trim(e.user_name).toUpperCase(), $.trim(e.email)));
									}
								});//End each
							}	
						},
						error:  function(xhr,status,error) {
							
							m='Error '+ xhr.status + ' Occurred: ' + error;
							DisplayMessage(m, 'error',Title);
						}
					});		
				}catch(e)
				{
					
					m="LoadInvestors ERROR:\n"+e;
					DisplayMessage(m,'error',Title);
				}
			}	
			
			//Direct Sell
			$("#txtDirectSellQty").on("keyup",function(event)
			{
				try
				{
					ComputeDirectSellAmount();
				}catch(e)
				{
					
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
					
					m='Sell Price Changed ERROR:\n'+e;			
					DisplayDirectSellMessage(m, 'error',Title);
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
					
					m='ComputeDirectSellAmount ERROR:\n'+e;			
					DisplayDirectSellMessage(m, 'error',Title);
				}
			}
			
			
			//Edit Direct Sell
			$("#txtDirectSellEditQty").on("keyup",function(event)
			{
				try
				{
					ComputeDirectSellEditAmount();
				}catch(e)
				{
					
					m='Edit Sell Quantity Keyup ERROR:\n'+e;			
					DisplayDirectSellEditMessage(m, 'error',Title);
				}
			});
			
			$("#txtDirectSellEditQty").on("change",function(event)
			{
				try
				{
					ComputeDirectSellEditAmount();
				}catch(e)
				{
					
					m='Edit Sell Quantity Changed ERROR:\n'+e;			
					DisplayDirectSellEditMessage(m, 'error',Title);
				}
			});
						
			$("#txtDirectSellEditPrice").on("keyup",function(event)
			{
				try
				{
					ComputeDirectSellEditAmount();
				}catch(e)
				{
					
					m='Edit Sell Price Keyup ERROR:\n'+e;			
					DisplayDirectSellEditMessage(m, 'error',Title);
				}
			});	
			
			$("#txtDirectSellEditPrice").on("change",function(event)
			{
				try
				{
					ComputeDirectSellEditAmount();
				}catch(e)
				{
					
					m='Edit Sell Price Changed ERROR:\n'+e;			
					DisplayDirectSellEditMessage(m, 'error',Title);
				}
			});	
			
			function ComputeDirectSellEditAmount()
			{
				try
				{
					$('#lblDirectSellEditAmount').html('');					
					$('#lblDirectSellEditBrokerFee').html('');
					$('#lblDirectSellEditNSEFee').html('');
					$('#lblDirectSellEditTotalAmount').html('');					
					
					var qty=$.trim($('#txtDirectSellEditQty').val()).replace(new RegExp(',', 'g'), '');					
					var price=$.trim($('#txtDirectSellEditPrice').val()).replace(new RegExp(',', 'g'), '');				
					price=price.replace(new RegExp('₦', 'g'), '');
					
					var sms=$.trim($('#lblDirectSellEditSMS').html()).replace(new RegExp(',', 'g'), '');				
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
				
					if (parseFloat(amount) > 0) $('#lblDirectSellEditAmount').html('₦' + number_format(amount, 2, '.', ','));
					if (parseFloat(brokerfee) > 0) $('#lblDirectSellEditBrokerFee').html('₦' + number_format(brokerfee, 2, '.', ','));
					if (parseFloat(nsefee) > 0) $('#lblDirectSellEditNSEFee').html('₦' + number_format((nsefee/2), 2, '.', ','));
					if (parseFloat(total) > 0) $('#lblDirectSellEditTotalAmount').html('₦' + number_format(total, 2, '.', ','));
				}catch(e)
				{
					
					m='ComputeDirectSellEditAmount ERROR:\n'+e;			
					DisplayDirectSellEditMessage(m, 'error',Title);
				}
			}
			
			function ResetDirectSellEdit()
			{
				try
				{
					CurrentSymbolPrice='';
					
					$('#hidOrderId').val('');
					$('#hidSold').val('');
					$('#hidOld_inv').val('');
					
					$('#lblDirectSellEditDate').html('<?php echo date('d M Y'); ?>');
					$('#cboDirectSellEditInvestor').val('');
					$('#lblDirectSellEditBalance').html('');
					$('#lblDirectSellEditSymbol').html('');
					$('#lblDirectSellEditPortfolioQty').html('');
					$('#lblDirectSellEditMarketPrice').html('');
					$('#txtDirectSellEditQty').val('');
					$('#lblDirectSellEditBrokerFee').html('');
					$('#lblDirectSellEditNSEFee').html('');
					$('#lblDirectSellEditAmount').html('');	
					$('#lblDirectSellEditTotalAmount').html('');
					$('#cboDirectSellEditOrderType').val('');
					
					$('#lblDirectSellEditPrice').html('Selling Price');
					$('#txtDirectSellEditPrice').val($('#lblDirectSellEditMarketPrice').html());
					$('#txtDirectSellEditPrice').prop('readonly',true).css('background-color','#ffffff').css('cursor','default');
					
					GetBalance();				
										
				}catch(e)
				{
					
					m='ResetDirectSellEdit ERROR:\n'+e;				
					DisplayDirectSellEditMessage(m, 'error',Title);
				}
			}
			
			function CheckDirectSellEdit()
			{
				try
				{
					var oid=$.trim($('#hidOrderId').val());
					var sold=$.trim($('#hidSold').val());
					var old_inv=$.trim($('#hidOld_inv').val());
					var bal=$.trim($('#lblDirectSellEditBalance').html()).replace(new RegExp(',', 'g'), '');				
					bal=bal.replace(new RegExp('₦', 'g'), '');
					
					var inv=$.trim($('#cboDirectSellEditInvestor').val());
					
					var sym=$.trim($('#lblDirectSellEditSymbol').html());
					
					var mktpr=$.trim($('#lblDirectSellEditMarketPrice').html()).replace(new RegExp(',', 'g'), '');				
					mktpr = mktpr.replace(new RegExp('₦', 'g'), '');
					
					var typ=$.trim($('#cboDirectSellEditOrderType').val());
					
					var pr=$.trim($('#txtDirectSellEditPrice').val()).replace(new RegExp(',', 'g'), '');				
					pr = pr.replace(new RegExp('₦', 'g'), '');
					
					var qty=$.trim($('#txtDirectSellEditQty').val()).replace(new RegExp(',', 'g'), '');
					
					var portqty=$.trim($('#lblDirectSellEditPortfolioQty').html()).replace(new RegExp(',', 'g'), '');
					
					var brfee=$.trim($('#lblDirectSellEditBrokerFee').html()).replace(new RegExp(',', 'g'), '');				
					brfee=brfee.replace(new RegExp('₦', 'g'), '');
					
					var nse=$.trim($('#lblDirectSellEditNSEFee').html()).replace(new RegExp(',', 'g'), '');				
					nse=nse.replace(new RegExp('₦', 'g'), '');
					
					var amt=$.trim($('#lblDirectSellEditAmount').html()).replace(new RegExp(',', 'g'), '');				
					amt=amt.replace(new RegExp('₦', 'g'), '');
					
					var tot=$.trim($('#lblDirectSellEditTotalAmount').html()).replace(new RegExp(',', 'g'), '');				
					tot=tot.replace(new RegExp('₦', 'g'), '');
					
					var sms=$.trim($('#lblDirectSellEditSMS').html()).replace(new RegExp(',', 'g'), '');				
					sms=sms.replace(new RegExp('₦', 'g'), '');	
					
					var transfer_fee='<?php echo $transfer_fee; ?>';
							
															
					//UNCOMMENT THIS LATER
					/*if ($.trim(MarketStatus).toLowerCase() == 'closed')
					{
						m='Market is closed. You cannot edit any order.';						
	
						DisplayDirectSellEditMessage(m, 'error',Title);				
	
						return false;
					}*/
					
					//User Email
					if (!Email)
					{
						m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the editing of the sell order.';						
	
						DisplayDirectSellEditMessage(m, 'error',Title);				
	
						return false;
					}
					
					if (!oid)
					{
						m='Sell order Id was not captured. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the editing of the sell order.';						
	
						DisplayDirectSellEditMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Wallet balance
					/*if (!bal)
					{
						m='Your e-wallet balance is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the editing of the sell order. If the issue still persists after signout and signin and you are sure that you have credited your e-wallet, please contact the system administrator at support@naijaartmart.com, otherwise credit your wallet through <a href="<?php //echo site_url('ui/Wallet'); ?>">Wallet Module</a> on your side menu.';	
								
						DisplayDirectSellEditMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(bal))
					{
						m='E-wallet balance MUST be a number.';						
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(bal) == 0)
					{
						m='E-wallet balance is zero. Please fund your e-wallet so that you can trade with it.';				
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(bal) < 0)
					{
						m='E-wallet balance must not be a negative number. Please fund your e-wallet so that you can trade with it.';				
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}*/
					
					//Investor					
					if ($('#cboDirectSellInvestor > option').length < 2)
					{
						m='You have not registered any investor under your account.';
						DisplayDirectSellEditMessage(m, 'error',Title);					
						return false;
					}
					
					if (!inv)
					{
						m='Please select the investor whose asset you are placing the sell order for.';
						DisplayDirectSellEditMessage(m, 'error',Title);					
						$('#cboDirectSellInvestor').focus(); return false;
					}					
									
					//Symbol
					if (!sym)
					{
						m='No asset is displaying. Refresh the page or logout and login again before continue.';
						DisplayDirectSellEditMessage(m, 'error',Title);					
						return false;
					}
					
					
					//Market Price
					if (!mktpr)
					{
						m='Asset current market price field MUST not be blank.';				
						DisplayDirectSellEditMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(mktpr))
					{
						m='Asset current market price MUST be a number.';						
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(mktpr) == 0)
					{
						m='Asset current market price must not be zero.';				
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(mktpr) < 0)
					{
						m='Asset current market price must not be a negative number.';				
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}
					
					
					//Sell Order Type
					if ($('#cboDirectSellEditOrderType > option').length < 2)
					{
						m='Sell order types have not been captured. Please contact the system administrator at support@naijaartmart.com';
						DisplayDirectSellEditMessage(m, 'error',Title);					
						return false;
					}
					
					if (!typ)
					{
						m='Please select the type of the sell order you want to edit.';
						DisplayDirectSellEditMessage(m, 'error',Title);					
						$('#cboDirectSellOrderType').focus(); return false;
					}
					
					
					//Selling Price
					if (!pr)
					{
						m='Asset selling price field MUST not be blank.';				
						DisplayDirectSellEditMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(pr))
					{
						m='Asset selling price MUST be a number.';						
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}
	
					if (parseFloat(pr) == 0)
					{
						m='Asset selling price must not be zero.';				
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(pr) < 0)
					{
						m='Asset selling price must not be a negative number.';				
						DisplayDirectSellEditMessage(m, 'error',Title);
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
						
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}
					
					if (parseFloat(pr) > parseFloat(upperlimit))//Exceeded upper limit
					{
						m="The selling price, <b>₦" + number_format(pr,2,'.',',') + "</b>, is more than the maximum price of <b>₦" + number_format(upperlimit,2,'.',',') + "</b> allowed for the asset. Please enter a value not less than <b>₦" + number_format(lowerlimit,2,'.',',') +"</b>, or more than <b>₦" + number_format(upperlimit,2,'.',',') + "</b>.";
						
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}
					
					
					//Portfolio Quantity
					if (!$.isNumeric(portqty))
					{
						m='There is no valid number of tokens of the selected asset in your portfolio. Selling order editing cannot continue.';						
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}
					
					if (parseInt(portqty) == 0)
					{
						m="You do not have any token of <b>"+ sym.toUpperCase() + "</b> in your portfolio to sell.";
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}					
	
					if (parseInt(portqty) == 0)
					{
						m='Number of tokens of <b>'+ sym.toUpperCase() + '</b> in your portfolio must not be zero.';				
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}
					
					if (parseInt(portqty) < 0)
					{
						m='Number of tokens of <b>'+ sym.toUpperCase() + '</b> in your portfolio must not be less than zero.';				
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}
								
																	
					//Qty to sell
					if (!qty)
					{
						m='Number of tokens of the asset to sell MUST not be blank.';				
						DisplayDirectSellEditMessage(m, 'error',Title);					
						return false;
					}
					
					if (!$.isNumeric(qty))
					{
						m='Number of tokens of the asset to sell MUST be a number. Current entry <b>'+qty+'</b> is not valid.';						
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}
	
					if (parseInt(qty) == 0)
					{
						m='Number of tokens of the asset to sell must not be zero.';				
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}
					
					if (parseInt(qty) < 0)
					{
						m='Number of tokens of the asset to sell must not be less than zero.';				
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}
					
										
					if (parseInt(portqty) < parseInt(qty))
					{
						m="You do not have enough tokens of <b>"+ sym.toUpperCase() + "</b> in your portfolio to sell. The number of tokens of the asset in your portfolio currently is <b>"+ number_format(portqty,0,'',',') + "</b>.";
						DisplayDirectSellEditMessage(m, 'error',Title);
						return false;
					}
					
					//sold
					//(qty - sold) (if zero, stop order, if < 0 refuse update)
					var dq=parseInt(qty)-parseInt(sold);
					
					if (parseInt(dq)==0)
					{
						m='You have already sold <b>'+number_format(dq,0,'',',')+'</b> tokens from this order. Entering the current qunatity of '+number_format(qty,0,'',',') + ' tokens, will bring the net trade quantity to zero. This process will stop this sell order or mark it as EXECUTED. If you want stop or cancel this order, you can click directly on the <b>CANCEL</b> button.';						
	
						DisplayDirectSellEditMessage(m, 'error',Title);				
	
						return false;
					}
					
					if (parseInt(dq)<0)
					{
						m='You have already sold <b>'+number_format(dq,0,'',',')+'</b> tokens from this order. Entering the current qunatity of '+number_format(qty,0,'',',') + ' tokens, will bring the net trade quantity to less than zero. If you want stop or cancel this order, you can click directly on the <b>CANCEL</b> button.';
	
						DisplayDirectSellEditMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Broker
					if (!brfee)
					{
						m='Broker fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the editing of the sell order. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayDirectSellEditMessage(m, 'error',Title);				
	
						return false;
					}
					
					//NSE Fee
					if (!nse)
					{
						m='NSE fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the editing of the sell order. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayDirectSellEditMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Token Amount
					if (!amt)
					{
						m='Amount for the token to sell is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the editing of sell the order. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayDirectSellEditMessage(m, 'error',Title);				
	
						return false;
					}
					
					//Total Amount
					if (!tot)
					{
						m='Total trade amount for the sell order is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the editing of the sell order. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';						
	
						DisplayDirectSellEditMessage(m, 'error',Title);				
	
						return false;
					}
	
					
					//Confirm Update				
					Swal.fire({
					  title: 'PLEASE CONFIRM',
					  html: '<font size="3" face="Arial">Do you want to proceed with the editing of the sell order for the selected asset?</font>',
					  type: 'question',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  cancelButtonText: '<font size="3" face="Arial">No</font>',
					  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
					}).then((result) => {
					  if (result.value)
					  {
						//$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Editing Selling Order. Please Wait...</p>',theme: false,baseZ: 2000});

					var mdata={email:Email, order_id:oid, broker_id:BrokerId, old_invid:old_inv, investor_id:inv, ordertype:typ, symbol:sym, price:pr, qty:qty, available_qty:dq, broker_commission:brfee,nse_commission:nse, sms_fee:sms, transfer_fee:transfer_fee,total_amount:tot}						

									
						//Make Ajax Request			
						$.ajax({
							url: '<?php echo site_url('ui/Directexchange/UpdateSellOrder'); ?>',
							data: mdata,
							type: 'POST',
							dataType: 'json',
							success: function(data,status,xhr) {				
								
								
								if ($(data).length > 0)
								{
									$.each($(data), function(i,e)
									{
										if ($.trim(e.status).toUpperCase() == 'OK')
										{
											$('#cboDirectSellEditInvestor').val('');
											$('#lblDirectSellEditBalance').html('');
											$('#lblDirectSellEditPrice').html('Selling Price');
											$('#txtDirectSellEditPrice').val($('#lblDirectSellEditMarketPrice').html());
											$('#txtDirectSellEditPrice').prop('readonly',true).css('background-color','#ffffff').css('cursor','default');
											$('#txtDirectSellEditQty').val('');
											$('#lblDirectSellEditBrokerFee').html('');
											$('#lblDirectSellEditNSEFee').html('');
											$('#lblDirectSellEditAmount').html('');	
											$('#lblDirectSellEditTotalAmount').html('');
											$('#cboDirectSellEditOrderType').val('');	
											
											
											$('#hidOrderId').val('');	
											$('#hidSold').val('');
											$('#hidOld_inv').val('');
																																	
											LoadOrders();
											LoadMessages();
											LoadDirectMarketData();
											GetBalance();
											GetPortfolioTokens(sym,inv);
				
											m= 'Updating of sell order was successfully.';
											
											DisplayDirectSellEditMessage(m, 'success','Updated Sell Order','SuccessTheme');
										}else
										{
											m=e.Msg;
											
											DisplayDirectSellEditMessage(m,'error',Title);		
										}
										
										return;
									});//End each
								}
							},
							error:  function(xhr,status,error) {
								m='Error '+ xhr.status + ' Occurred: ' + error
								DisplayDirectSellEditMessage(m,'error',Title);
							}
						});
					  }
					})	
				}catch(e)
				{
					
					m='CheckDirectSellEdit ERROR:\n'+e;				
					DisplayDirectSellEditMessage(m, 'error',Title);
				}		
			}//End CheckDirectSellEdit
			
			
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
					
					m='ResetDirectSell ERROR:\n'+e;				
					DisplayDirectSellMessage(m, 'error',Title);
				}
			}
			
			function CheckDirectSell()
			{
				try
				{					
					var inv=$.trim($('#cboDirectSellInvestor').val());
					
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
					if ($('#cboDirectSellInvestor > option').length < 2)
					{
						m='You have not registered any investor under your account.';
						DisplayDirectSellMessage(m, 'error',Title);					
						return false;
					}
					
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
						//$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Placing Selling Order. Please Wait...</p>',theme: false,baseZ: 2000});

					var mdata={email:Email, broker_id:BrokerId, investor_id:inv, ordertype:typ, symbol:sym, price:pr, qty:qty, available_qty:qty, broker_commission:brfee,nse_commission:nse, sms_fee:sms, transfer_fee:transfer_fee,total_amount:tot}						

									
						//Make Ajax Request			
						$.ajax({
							url: '<?php echo site_url('ui/Directexchange/PlaceSellOrder'); ?>',
							data: mdata,
							type: 'POST',
							dataType: 'json',
							success: function(data,status,xhr) {				
								
								
								if ($(data).length > 0)
								{
									$.each($(data), function(i,e)
									{
										if ($.trim(e.status).toUpperCase() == 'OK')
										{					
											$('#cboDirectSellInvestor').val('');
											$('#lblDirectSellBalance').html('');
											$('#lblDirectSellPrice').html('Selling Price');
											$('#txtDirectSellPrice').val($('#lblDirectSellMarketPrice').html());
											$('#txtDirectSellPrice').prop('readonly',true).css('background-color','#ffffff').css('cursor','default');
											$('#txtDirectSellQty').val('');
											$('#lblDirectSellBrokerFee').html('');
											$('#lblDirectSellNSEFee').html('');
											$('#lblDirectSellAmount').html('');	
											$('#lblDirectSellTotalAmount').html('');
											$('#cboDirectSellOrderType').val('');
																						
											LoadOrders();
											LoadMessages();
											LoadDirectMarketData();
											GetBalance();
											GetPortfolioTokens(sym,inv);
				
											m= 'Order to sell '+number_format(qty, '0', '', ',') + ' tokens of '+ $.trim(sym).toUpperCase() +' was placed successfully.';
											
											DisplayDirectSellMessage(m, 'success','Sell Order Placed','SuccessTheme');
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
					
					m='CheckDirectSell ERROR:\n'+e;				
					DisplayDirectSellMessage(m, 'error',Title);
				}		
			}//End CheckDirectSell
			
			function ResetDirectBuy()
			{
				try
				{
					CurrentSymbolPrice='';
					
					$('#lblDirectBuyDate').html('<?php echo date('d M Y'); ?>');
					$('#txtDirectBuyQty').val('');
					$('#lblDirectBuySymbol').html('');
					$('#cboDirectBuyInvestor').val('');
					
					
					$('#tabSellers > tbody').html('');					
										
					GetBalance();				
										
				}catch(e)
				{
					
					m='ResetDirectBuy ERROR:\n'+e;				
					DisplayDirectBuyMessage(m, 'error',Title);
				}
			}
        });//End document ready
		
		function LoadMessages()
		{
			try
			{
				//$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Loading Messages/News. Please Wait...</p>",theme: false,baseZ: 2000});
				
				$('#tabNews > tbody').html('');
				
				var tw=$('#news').width();
				var det_cell=tw * 0.45;
				var head_cell=tw * 0.38;
				
				$.ajax({
					url: '<?php echo site_url('ui/Directexchange/LoadMessages'); ?>',
					type: 'POST',
					data: {email:Email, detail_width:det_cell, header_width:head_cell,usertype:'<?php echo $usertype; ?>'},
					dataType: 'json',
					success: function(dataSet,status,xhr) {	
						
						
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
						
						m='Error '+ xhr.status + ' Occurred: ' + error;
						DisplayMessage(m,'error',Title);
					}
				});
				
				
			}catch(e)
			{
				
				m='LoadMessages ERROR:\n'+e;
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
					url: "<?php echo site_url('ui/Directexchange/GetOrders');?>",
					type: 'POST',
					data: {email:Email},
					dataType: 'json',
					success: function(dataSet,status,xhr) {	
						
						
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
						
						m='Error '+ xhr.status + ' Occurred: ' + error;
						DisplayMessage(m,'error',Title);
					}
				});
			}catch(e)
			{
				
				m='LoadOrders ERROR:\n'+e;
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
					url: "<?php echo site_url('ui/Directexchange/GetDirectMarketData');?>",
					type: 'POST',
					data: {usertype:Usertype, broker_id:BrokerId},
					dataType: 'json',
					success: function(dataSet,status,xhr) {	
						
						
						if (table) table.destroy();
						
						if ($.trim(Usertype).toLowerCase()=='broker')
						{
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
						}else if ($.trim(Usertype).toLowerCase()=='investor')
						{
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
									{ width: "16%" },//Pix
									{ width: "13%" },//Symbol
									{ width: "10%" },//Open
									{ width: "10%" },//High
									{ width: "10%" },//Low
									{ width: "10%" },//Close
									{ width: "11%" },//Trades
									{ width: "12%" },//Volume
									{ width: "8%" }//Action
								],
							} );//16,13,10,10,10,10,11,12,8
						}
						
								
					},
					error:  function(xhr,status,error) {
						
						m='Error '+ xhr.status + ' Occurred: ' + error;
						DisplayMessage(m,'error',Title);
					}
				});
			}catch(e)
			{
				
				m='LoadDirectMarketData ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}
		
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
				
				m='ShowPix ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
		}
		
		function GetDirectPortfolioTokens(symbol,invEmail)
		{
			try
			{
				$('#lblDirectSellPortfolioQty').html('');
				$('#lblDirectSellEditPortfolioQty').html('');
								
				//$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Number Of Tokens. Please Wait...</p>',theme: false,baseZ: 2000});
										
				//Make Ajax Request			
				$.ajax({
					url: '<?php echo site_url('ui/Directexchange/GetTokensFromPortfolio'); ?>',
					data: {email:invEmail,symbol:symbol,brokerid:BrokerId},
					type: 'POST',
					dataType: 'text',
					success: function(data,status,xhr) {				
						
						
						var b=data;							
						
						if ($.isNumeric(b))
						{
							$('#lblDirectSellPortfolioQty').html(number_format(b, '0', '', ','));
							$('#lblDirectSellEditPortfolioQty').html(number_format(b, '0', '', ','));
						}else
						{
							m=data;
							DisplayDirectSellEditMessage(m,'error',Title);	
						}
					},
					error:  function(xhr,status,error) {
						m='Error '+ xhr.status + ' Occurred: ' + error;
						DisplayDirectSellEditMessage(m,'error',Title);
					}
				});
			}catch(e)
			{
				
				m='GetDirectPortfolioTokens ERROR:\n'+e;				
				DisplayDirectSellEditMessage(m, 'error',Title);
				return false;
			}		
		}//End GetDirectPortfolioTokens
		
		function GetPortfolioTokens(symbol,invEmail)
		{
			try
			{
				$('#lblBuyPortfolioQty').html('');
				$('#lblSellPortfolioQty').html('');
								
				//$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Number Of Tokens. Please Wait...</p>',theme: false,baseZ: 2000});
										
				//Make Ajax Request			
				$.ajax({
					url: '<?php echo site_url('ui/Directexchange/GetTokensFromPortfolio'); ?>',
					data: {email:invEmail,symbol:symbol,brokerid:BrokerId},
					type: 'POST',
					dataType: 'text',
					success: function(data,status,xhr) {				
						
						
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
				
				m='GetPortfolioTokens ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End GetPortfolioTokens
		
		function GetBalance()
		{
			try
			{
				var bal=$.trim($('#uiWalletBalance').html()).replace(new RegExp(',', 'g'), '');				
				bal=bal.replace(new RegExp('₦', 'g'), '');
				
				if (parseFloat(bal) > 0)
				{
					$('#lblBuyBalance').html('₦'+number_format(bal, '2', '.', ','));
					$('#lblSellBalance').html('₦'+number_format(bal, '2', '.', ','));
					$('#uiWalletBalance').html(number_format(bal, '2', '.', ','));
					$('#lblDirectSellBalance').html(number_format(bal, '2', '.', ','));
					$('#lblDirectBuyBalance').html(number_format(bal, '2', '.', ','));
					$('#lblDirectSellEditBalance').html(number_format(bal, '2', '.', ','));
				}else
				{
					$('#lblBuyBalance').html('');
					$('#lblSellBalance').html('');
					$('#uiWalletBalance').html('');
					$('#lblDirectSellBalance').html('');
					$('#lblDirectBuyBalance').html('');
					$('#lblDirectSellEditBalance').html('');
					
					//$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Wallet Balance. Please Wait...</p>',theme: false,baseZ: 2000});
											
					//Make Ajax Request			
					$.ajax({
						url: '<?php echo site_url('ui/Directexchange/GetBalance'); ?>',
						data: {email:Email},
						type: 'POST',
						dataType: 'text',
						success: function(data,status,xhr) {				
							
							
							var b=data;							
							
							if ($.isNumeric(b))
							{
								$('#lblBuyBalance').html('₦'+number_format(b, '2', '.', ','));
								$('#lblSellBalance').html('₦'+number_format(b, '2', '.', ','));
								$('#uiWalletBalance').html(number_format(b, '2', '.', ','));
								$('#lblDirectSellBalance').html(number_format(b, '2', '.', ','));
								$('#lblDirectBuyBalance').html(number_format(b, '2', '.', ','));
								$('#lblDirectSellEditBalance').html(number_format(b, '2', '.', ','));
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
				
				m='GetBalance ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End GetBalance	
		
		function CancelOrder(sn,symbol,order_id,qty,price,ordertype,transtype)
		{
			try
			{
				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: '<font size="3" face="Arial">This action will permanently delete the sell order record. Do you want to proceed with the deleting of the sell order record from the database?</font>',
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					//$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Deleting Sell Order Record. Please Wait...</p>',theme: false,baseZ: 2000});
					
					//Initiate POST
					var uri = "<?php echo site_url('ui/Directexchange/CancelSellOrder'); ?>";
					var xhr = new XMLHttpRequest();
					var fd = new FormData();
					
					xhr.open("POST", uri, true);
					
					xhr.onreadystatechange = function() {
						if (xhr.readyState == 4 && xhr.status == 200)
						{
							// Handle response.
	
							
							
							var res=$.trim(xhr.responseText);
														
							if (res.toUpperCase()=='OK')
							{
								LoadOrders();
								LoadMessages();
								LoadDirectMarketData();
								GetBalance();
								GetPortfolioTokens(symbol,Email);
	
								m= 'Order with Id <b>'+order_id+'</b> for <b>'+number_format(qty, '0', '', ',') + '</b> tokens of <b>'+ $.trim(symbol).toUpperCase() +'</b> was cancelled successfully.';
								
								DisplayMessage(m, 'success','Sell Order Cancelled','SuccessTheme');																										
							}else
							{
								m=res;								
								DisplayMessage(m, 'error',Title);
							}
						}
					};

					fd.append('symbol', symbol);
					fd.append('order_id', order_id);
					fd.append('qty', qty);
					fd.append('price', price);
					fd.append('ordertype', ordertype);
					fd.append('transtype', transtype);
					fd.append('email', Email);
					fd.append('broker_name', BrokerName);
					fd.append('broker_id', BrokerId);
																				
					xhr.send(fd);// Initiate a multipart/form-data upload
				  }
				})
			}catch(e)
			{
				
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
		function UpdateOrder(sym,order_id,qty,price,ordertype,transtype,inv,pqty,brfee,nse,amt,tot,sms,transfer_fee,symprice,avail)
		{
			try
			{
				$('#hidOrderId').val(order_id);
				$('#hidOld_inv').val(inv);
				//$('#lblDirectSellEditBalance').html(GetBalance());
				$('#lblDirectSellEditSymbol').html(sym);
				$('#lblDirectSellEditMarketPrice').html(number_format(symprice, '2', '.', ','));
				$('#txtDirectSellEditPrice').val(number_format(price, '2', '.', ','));							
				$('#cboDirectSellEditInvestor').val(inv);				
				$('#cboDirectSellEditOrderType').val(ordertype);
				$('#txtDirectSellEditQty').val(number_format(qty, '0', '', ','));				
				$('#lblDirectSellEditPortfolioQty').html(number_format(pqty, '0', '', ','));				
				$('#lblDirectSellEditBrokerFee').html(number_format(brfee, '2', '.', ','));
				$('#lblDirectSellEditNSEFee').html(number_format(nse, '2', '.', ','));
				$('#lblDirectSellEditAmount').html(number_format(amt, '2', '.', ','));				
				$('#lblDirectSellEditTotalAmount').html(number_format(tot, '2', '.', ','));
				$('#lblDirectSellEditSMS').html(number_format(sms, '2', '.', ','));				
				$('#lblDirectSellEditTransferFee').html(number_format(transfer_fee, '2', '.', ','));
				
				if ($.trim(ordertype).toLowerCase() == 'limit')
				{
					$('#lblDirectSellEditPrice').html('Selling Price<span class="redtext">*</span>');
					$('#txtDirectSellEditPrice').prop('readonly',false).css('background-color','#ffffff').css('cursor','text');
				}else
				{
					$('#lblDirectSellEditPrice').html('Selling Price');
					$('#txtDirectSellEditPrice').prop('readonly',true).css('background-color','#ffffff').css('cursor','default');
				}
				
				var sold = parseFloat(qty) - parseFloat(avail);
				
				$('#hidSold').val(sold);
				
				$('#divDirectSellEditModal').modal({
				  	fadeDuration: 	1000,
  					fadeDelay: 		0.50,
					keyboard: 		false,
					backdrop:		'static'
				});
			}catch(e)
			{
				
				m='UpdateOrder ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}		
		
		function SellDirectArt(sn,sym,price,vol)
		{
			try
			{
				CurrentSymbolPrice= $('#tabMarket > tbody').find("tr").eq(sn).find("td").eq(4).html();
				
				GetBalance();
				
				$('#lblDirectSellSymbol').html(sym);
				$('#lblDirectSellMarketPrice').html(number_format(CurrentSymbolPrice, '2', '.', ','));
				$('#txtDirectSellPrice').val(number_format(CurrentSymbolPrice, '2', '.', ','));
								
				var sms='<?php echo (floatval($sms_fee) * 2); ?>';
				var transfer_fee='<?php echo floatval($transfer_fee); ?>';
				
				$('#lblDirectSellSMS').html(number_format(sms, '2', '.', ','));				
				$('#lblDirectSellTransferFee').html(number_format(transfer_fee, '2', '.', ','));
				
				$('#divDirectSellModal').modal({
				  	fadeDuration: 	1000,
  					fadeDelay: 		0.50,
					keyboard: 		false,
					backdrop:		'static'
				});
			}catch(e)
			{
				
				m='SellDirectArt ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}		
		
		//Direct Buy
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
						
						m='Error '+ xhr.status + ' Occurred: ' + error;
						DisplayDirectBuyMessage(m,'error',Title);
					}
				});
			}catch(e)
			{
				
				m='LoadSellers ERROR:\n'+e;
				DisplayDirectBuyMessage(m,'error',Title);
			}
		}
		
		function BuyDirectArt(sn,sym,order_id,broker_id,price,investor_id,available_qty,ordertype)
		{
			try
			{
				var qty=$.trim($('#txtDirectBuyQty').val()).replace(new RegExp(',', 'g'), '');
				var inv=$.trim($('#cboDirectBuyInvestor').val());
				
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
				
				det += '<div class=" form-group size-17"><label title="Quantity Of Tokens To Buy" class="col-sm-6 col-form-label nsegreen text-right">Qty:</label><label class="col-form-label redalerttext col-sm-6 text-left">' + number_format(qty,0,'',',') + '</label></div>';
				
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
				  title: 'PLEASE CONFIRM BUY',
				  html: '<div>'+det+'</div>',
				  type: 'question',
				  customClass: 'swal-wide',
				  showCancelButton: true,
				  showClass: {popup: 'animate__animated animate__fadeInDown'},
				  hideClass: {popup: 'animate__animated animate__fadeOutUp'},
				  confirmButtonColor: '',
				  cancelButtonColor: '',
				  cancelButtonText: '<font size="3" face="Arial" class="text-danger">No</font>',
				  confirmButtonText: '<font size="3" face="Arial" class="text-success">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					//$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Buying Asset. Please Wait...</p>',theme: false,baseZ: 2000});

				var mdata={brokeremail:Email, sell_broker_id:broker_id, sell_order_id:order_id, sell_investor_id:investor_id, buy_broker_id:BrokerId, buy_investor_id:inv, symbol:sym, price:price, qty:qty, available_qty:available_qty, broker_commission:brokerfee,nse_commission:nf, sms_fee:sms, transfer_fee:transfer_fee,total_amount:number_format(total,2,'.',''),min_buy_qty:'<?php echo $min_buy_qty; ?>',ordertype:ordertype};
	
								
					//Make Ajax Request			
					$.ajax({
						url: '<?php echo site_url('ui/Directexchange/BuyTokens'); ?>',
						data: mdata,
						type: 'POST',
						dataType: 'json',
						success: function(data,status,xhr) {				
							
							
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
			}catch(e)
			{
				
				m='BuyDirectArt ERROR:\n'+e;
				DisplayDirectBuyMessage(m,'error',Title);
			}
		}
		
		function ShowBuyers(sym,price)
		{
			try
			{	
				GetBalance();			
				
				$('#lblDirectBuySymbol').html(sym);
															
				LoadSellers(sym);
				
				$('#divDirectBuyModal').modal({
				  	fadeDuration: 	1000,
  					fadeDelay: 		0.50,
					keyboard: 		false,
					backdrop:		'static'
				});
				
				$('#cboDirectBuyInvestor').focus();
			}catch(e)
			{
				
				m='ShowBuyers ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}

		function LocateMesssage(mid,hd,det,dt,cat)
	{
		try
		{
			$.redirect("<?php echo base_url(); ?>ui/Messages", {msgid:mid, header:hd, details:det, msgdate:dt,category:cat}, "POST");	
		}catch(e)
		{

		}
	}
	</script>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<script>

			$(document).ready(function(e) {
				// var targetleft=$('#ulUsertype').offset().left;
				// var marqueeleft=$('.simple-marquee-container').offset().left;
				// var dif=targetleft - marqueeleft;
				// dif -= 20;
				
				// $('.simple-marquee-container').css('width',dif);
				
			});


			function LogOut()
			{
				try
				{
					var m='<span class="size-20">Signing out will abort every active process and unsaved data will be lost. Do you still want to sign out?</span>';
					
					Swal.fire({
					  type: 'question',
					  title: '<h2>Confirm Signout!</h2>',
					  html: m,		 
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  cancelButtonText: '<span class="size-20">NO</span>',
					  confirmButtonText: '<span class="size-20">YES</span>'
					}).then((result) => {
						if (result.value) window.location.href='<?php echo site_url('ui/Signout'); ?>';
					})	
				}catch(e)
				{

				}			
			}

			</script>

<style>
	.msgclass{ color:white; cursor:pointer; }	 
	.msgclass:hover{ opacity:0.5; }
</style>

<!-- NAVBAR -->
<nav class="navbar navbar-default navbar-fixed-top" style="background:inherit; z-index:10;
    box-shadow: 2px 2px 21px 10px lightgrey ">
    <div class="brand" style="background:#inherit;">
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
                                 <h3>Direct Exchange</h3>
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

                        <li class="makebold size-18"><a data-toggle="tab" href="#news">News</a></li>
                       <li title="Click to refresh page" onClick="window.location.reload(true);" class="makebold size-18"><a data-toggle="tab" href="#refresh" class="redtext">Refresh</a></li>
                   </ul>
                
                  <div class="tab-content">
                  <!--Market Tab-->
                    <div id="market" class="tab-pane fade in active">
                     	<table class="hover table table-bordered data-table display wrap" id="tabMarket">
                          <thead>
                            <tr>
                                
                                <?php
									if (trim(strtolower($usertype))=='broker')
									{
										echo '
											<th style="text-align:center" width="15%">ASSET</th>
											<th title="Open Price" style="text-align:center" width="11%">OPEN</th>
											<th title="High Price" style="text-align:center" width="11%">HIGH</th> 
											<th title="Low Price" style="text-align:center" width="11%">LOW</th>
											<th title="Close Price"style="text-align:center" width="11%">CLOSE</th>
											<th style="text-align:center" width="12%">TRADES</th>
											<th style="text-align:center" width="13%">VOLUME</th>
											
											<th style="text-align:center" width="8%"></th>
											<th style="text-align:center" width="8%"></th>
										';  
									}elseif (trim(strtolower($usertype))=='investor')
									{
										echo '
											<th style="text-align:center" width="16%">PIX</th>
											<th style="text-align:center" width="13%">ASSET</th>
											<th title="Open Price" style="text-align:center" width="10%">OPEN</th>
											<th title="High Price" style="text-align:center" width="10%">HIGH</th> 
											<th title="Low Price" style="text-align:center" width="10%">LOW</th>
											<th title="Close Price"style="text-align:center" width="10%">CLOSE</th>
											<th style="text-align:center" width="11%">TRADES</th>
											<th style="text-align:center" width="12%">VOLUME</th>
											<th style="text-align:center" width="8%"></th>
										';
									}
								?>
                                
                                                         
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
                                    
                                    <span class="input-group-btn"><button class="btn btn-outline-primary" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                </div>
                             </div>
                             
                              <!--End Date--> 
                              <label title="End Date" for="txtTradeEndDate" class="col-sm-2 col-form-label text-right">End Date</label>
                        
                            <div title="End Date" class="col-sm-3 date tradedatepicker">
                                <div class="input-group">
                                    <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtTradeEndDate" placeholder="Trade End Date">
                                    
                                    <span class="input-group-btn"><button class="btn btn-outline-primary" type="button"><i class="fa fa-calendar size-21"></i></button></span>
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
		
         <?php //include('footer.php'); ?>
	</div>    
	<!-- END WRAPPER -->


<!-- ******************************** DIRECT TRADE SECTION ****************************-->
<!--Direct Sell Edit Popup-->
<div id="divDirectSellEditModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
        	<b><span class="redtext" style="margin-right:39px;">EDIT SELL ORDER</span> </b>
            
           <span style="float:right">Fields With <span class="redtext">*</span> Are Required               
               <button style="margin-left:50px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
           </span>            
        </h5>        
      </div>
      
      <div class="modal-body">
        <form>
        	<input type="hidden" id="hidOrderId">
            
            <input type="hidden" id="hidOld_inv">
            <input type="hidden" id="hidSold">
            
        	<!--Balance-->
             <div class="position-relative row form-group">
                 <!--Balance-->
                <label title="Wallet Balance" for="lblDirectSellEditBalance" class="col-sm-3 col-form-label  nsegreen text-right labelmiddle">Wallet Balance</label>
                
                <div title="Wallet Balance" class="col-sm-4">
                	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellEditBalance" class="col-form-label labelmiddle"></label>
                    </div>                    
                </div>
            </div>
                       
            <!--Investor-->
            <div class="row">
                 <div title="Investor" class="position-relative row form-group">
                    <label for="cboDirectSellEditInvestor" class="col-sm-3 col-form-label nsegreen text-right">Investor<span class="redtext">*</span></label>
                    
                    <div class="col-sm-9">
                        <select id="cboDirectSellEditInvestor" class="form-control" ></select>
                    </div>
                </div>
            </div>
                        
            <!--Asset/Market Price-->
             <div class="position-relative row form-group">
                <label title="Asset" for="lblDirectSellEditSymbol" class="col-sm-3 col-form-label nsegreen text-right labelmiddle">Asset</label>
                
                <div title="Asset" class="col-sm-4">
                    <label id="lblDirectSellEditSymbol" class="col-form-label redalerttext labelmiddle"></label>
                </div>
                
                
                <!--Market Price-->
                <label title="Market Price" for="lblDirectSellEditMarketPrice" class="col-sm-2 col-form-label nsegreen text-right labelmiddle">Market Price</label>
                
                <div title="Current Market Price" class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                        
                         <label id="lblDirectSellEditMarketPrice" class="col-form-label redalerttext labelmiddle"></label>
                    </div>
                </div>                
            </div>
            
            <!--Order Type/Selling Price-->
            <div class="position-relative row form-group">
                <label title="Order Type" for="cboDirectSellEditOrderType" class="col-sm-3 col-form-label nsegreen text-right">Order Type <i data-toggle="tooltip" data-placement="right auto" title="Not selecting any order type will automatically create this order as a Market Order." style="cursor:pointer;" class="fa fa-question-circle"></i></label>
                
                <div title="Order Type" class="col-sm-4">
                    <select id="cboDirectSellEditOrderType" class="form-control">
                        <option value="">[SELECT]</option>
                        <option value="Market">Market Order</option>
                        <option value="Limit">Limit Order</option>
                    </select>
                </div>
                
                
                <!--Selling Price-->
                <label id="lblDirectSellEditPrice" title="Selling Price" for="txtDirectSellEditPrice" class="col-sm-2 col-form-label nsegreen text-right">Selling Price</label>
                
                <div title="Selling Price" class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                        
                         <input type="text" id="txtDirectSellEditPrice" placeholder="Selling Price" class="form-control size-17 makebold">
                    </div>
                </div>                
            </div>
                        
            <!--Portfolio Qty/No of Token-->            
             <div class="position-relative row form-group">
                <!--Portfolio Qty-->
                <label title="Number of tokens in portfolio" for="lblDirectSellEditPortfolioQty" class="col-sm-3 col-form-label nsegreen text-right">Portfolio Qty</label>
                
                <div title="Number of tokens in portfolio" class="col-sm-4">
                    <label id="lblDirectSellEditPortfolioQty" class="col-form-label redalerttext"></label>
                </div>
                
                
                <!--No Of Tokens-->
                <label title="Number of tokens to sell" for="txtDirectSellEditQty" class="col-sm-2 col-form-label text-right nsegreen text-right">No Of Tokens<span class="redtext">*</span></label>
                
                <div title="Number of tokens to sell" class="col-sm-3">
                    <input type="text" class="form-control" placeholder="No Of Tokens To Sell" id="txtDirectSellEditQty">
                </div>
            </div>
                      
            <!--Broker Fee/NSE Fee-->
             <div class="position-relative row form-group">
                <label style="padding-left:0px;" title="Broker Fee" for="lblDirectSellEditBrokerFee" class="col-sm-3 col-form-label  nsegreen text-right labelmiddle">Broker Fee</label>
                
                <div title="Broker Fee" class="col-sm-4">                    
                    <div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellEditBrokerFee" class="col-form-label redalerttext labelmiddle"></label>
                    </div>
                </div>
                
                  <!--NSE Fee-->
                 <label title="NSE Fee" for="lblDirectSellEditNSEFee" class="col-sm-2 col-form-label text-right nsegreen text-right labelmiddle">NSE Fee</label>
                 
                 <div title="NSE Fee" class="col-sm-3">
                 	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellEditNSEFee" class="col-form-label redalerttext labelmiddle"></label>
                    </div>                    
                </div>  
            </div>
            
             <!--SMS Fee/Transfer Fee-->
             <div class="position-relative row form-group">                
                <!--SMS Fee-->
                <label title="SMS Fee" for="lblDirectSellEditSMS" class="col-sm-3 col-form-label text-right nsegreen labelmiddle">SMS Fee<i data-toggle="tooltip" data-placement="right auto" title="Covers cost of sending trading status SMS to investor and broker." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="SMS Fee" class="col-sm-4">
                	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellEditSMS" class="col-form-label labelmiddle"></label>
                    </div>
                </div>
                
                <!--Transfer Fee-->
                <label title="Transfer Fee" for="lblDirectSellEditTransferFee" class="col-sm-2 col-form-label text-right nsegreen labelmiddle">Transfer Fee <i data-toggle="tooltip" data-placement="right auto" title="This is the fee for transferring of trade amount to your bank account. Transfer is set by the payment processor and it is borne by each transfer recipient." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="Transfer Fee" class="col-sm-3">
                	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellEditTransferFee" class="col-form-label labelmiddle"></label>
                    </div>
                </div>
            </div>   
            
            <!--Token Amount/Total Trade Amount-->
             <div class="position-relative row form-group">
                <label style="padding-left:0px;" title="Token Amount" for="lblDirectSellEditAmount" class="col-sm-3 col-form-label nsegreen text-right labelmiddle">Token Amount <i data-toggle="tooltip" data-placement="right auto" title="This is the amount for the quantity of tokens to sell excluding fees/commission." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="Token Amount" class="col-sm-4">
                	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellEditAmount" class="col-form-label redalerttext labelmiddle"></label>
                    </div>                    
                </div>
                
                <!--Total Trade Amount-->
                <label title="Total Trade Amount" for="lblDirectSellEditTotalAmount" class="col-sm-2 col-form-label text-right nsegreen labelmiddle">Total Amount <i data-toggle="tooltip" data-placement="right auto" title="This is the total trade amount including all the fees/commission. Please note that every transfer to seller and brokers accounts attracts fee set by the payment processor. This transfer fee is borne by each transfer recipient." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="Total Trade Amount" class="col-sm-3">
                	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellEditTotalAmount" class="col-form-label labelmiddle"></label>
                    </div>
                </div>
            </div> 
                        
           <div id="divDirectSellEditAlert"></div>
        </form>
      </div>      
      
      <div class="modal-footer">
        <button id="btnDirectSellEdit" type="button" class="btn btn-nse-green">UPDATE SELL ORDER</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
        
        <p align="center" class="redtext makebold"><br><i><span class="redtext">*</span> All transfers attract transfer fee set by the payment processor. Fee are borne by transfer recipients.</i></p>
      </div>
    </div>
  </div>
</div>
<!-- End Direct Sell Edit Popup-->

<!--Direct Sell Popup-->
<div id="divDirectSellModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
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
            
             <!--Transfer Fee/SMS Fee-->
             <div class="position-relative row form-group">
                <!--Transfer Fee-->
                <label title="Transfer Fee" for="lblDirectSellTransferFee" class="col-sm-3 col-form-label text-right nsegreen labelmiddle">Transfer Fee <i data-toggle="tooltip" data-placement="right auto" title="This is the fee for transferring of trade amount to your bank account. Transfer is set by the payment processor and it is borne by each transfer recipient." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="Transfer Fee" class="col-sm-4">
                	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellTransferFee" class="col-form-label labelmiddle"></label>
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
                <!--Token Amount-->
                <label style="padding-left:0px;" title="Token Amount" for="lblDirectSellAmount" class="col-sm-3 col-form-label nsegreen text-right labelmiddle">Token Amount <i data-toggle="tooltip" data-placement="right auto" title="This is the amount for the quantity of tokens to sell excluding fees/commission." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
                <div title="Token Amount" class="col-sm-4">
                	<div class="input-group">
                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                         <label id="lblDirectSellAmount" class="col-form-label redalerttext labelmiddle"></label>
                    </div>                    
                </div>
                
                <!--Total Trade Amount-->
                <label title="Total Trade Amount" for="lblDirectSellTotalAmount" class="col-sm-2 col-form-label text-right nsegreen labelmiddle">Total Amount <i data-toggle="tooltip" data-placement="right auto" title="This is the total trade amount including all the fees/commission. Please note that every transfer to seller and brokers accounts attracts fee set by the payment processor. This transfer fee is borne by each transfer recipient." style="cursor:pointer;" class="fa fa-question-circle"></i> </label>
                
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
        	<!--Balance-->
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
                <label title="Investor" for="cboDirectBuyInvestor" class="col-sm-2 col-form-label nsegreen text-right">Investor<span class="redtext">*</span></label>
                
                <div title="Investor" class="col-sm-5">
                    <select id="cboDirectBuyInvestor" class="form-control" ></select>
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
        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button></span>
      </div>
    </div>
  </div>
</div>
<!--End Direct Buy Popup-->

<!-- ******************************** END OF DIRECT TRADE SECTION *********************-->

<!--Start Pix Popup-->
<div id="myPixModal" class="modal fade bd-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="background-color:#000000; padding:0; width:100%;">
          <div class="modal-header" style="background-color:#363131; height:50px;">              
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
