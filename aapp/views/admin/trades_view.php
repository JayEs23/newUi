<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Naija Art Mart - Trades</title>
    <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Naija Art Mart - The New Art Market For Everyone">    
    <meta name="msapplication-tap-highlight" content="no"><!-- Disable tap highlight on IE -->

	<?php include('header.php'); ?>
    <?php include('scripts.php'); ?>

	 <style>
    	/* DivTable.com */
				
		.divTableCell, .divTableHead {
			border: 0px solid #ffffff;
			/*display: table-cell;
			padding: 3px 10px;*/
			text-align: center;
		}
			
		@media (max-width: 320px) { 
			.divTableCell {
				width: 100%;
			}
		}
    </style>

	<script type = "text/javascript">
	
	var Title='<font color="#AF4442">Naija Art Mart Message</font>';
	var Email='<?php echo $email; ?>';
	var m='';
	var tabletrade,tablebuybook,tablesellbook;
	
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
		
		$('.datepicker').datepicker({
			weekStart: 1,
			todayBtn:  "linked",
			autoclose: 1,
			todayHighlight: 1,
			maxViewMode: 4,
			clearBtn: 1,
			forceParse: 0,
			daysOfWeekHighlighted: "0,6",
			//daysOfWeekDisabled: "0,6",
			format: 'd M yyyy'
		});			

		$('#txtDate').datepicker({
			weekStart: 1,
			todayBtn:  "linked",
			autoclose: 1,
			todayHighlight: 1,
			maxViewMode: 4,
			clearBtn: 1,
			forceParse: 0,
			daysOfWeekHighlighted: "0,6",
			//daysOfWeekDisabled: "0,6",
			format: 'd M yyyy'
		});
		
		LoadTrades("<?php echo date('d M Y'); ?>");
		LoadSymbols();
			
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
		
		function LoadTrades(dt)
		{
			try
			{
				
			}catch(e)
			{
				$.unblockUI();
				m="LoadTrades ERROR:\n"+e;
				DisplayMessage(m,'error',Title);
			}
		}
    });//Document Ready
	
	
		
    </script>
</head>
<body>

<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    <?php include('dheader.php'); //Dashboard Header ?>
    
    
    <div class="app-main">
          	<?php include('sidemenu.php'); //Side Menu ?>
            
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title" style="padding:5px">
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
                                                    Trades
                                                </li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    
                    <ul class="body-tabs-layout tabs-animated body-tabs-animated nav">
                        <li class="nav-item">
                            <a role="tab" class="nav-link active" id="tabData" data-toggle="tab" href="#data">
                                <span>Trades</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabView" data-toggle="tab" href="#view">
                                <span>Order Book</span>
                            </a>
                        </li>
                        
                        <li onClick="window.location.reload(true);" class="nav-item">
                            <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#refresh">
                                <span>Refresh</span>
                            </a>
                        </li>
                    </ul>
                    
                    
                    <div class="tab-content">
                        <div class="tab-pane tabs-animation fade show active" id="data" role="tabpanel">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <!--Trade Date-->
                                    <div title="Trade Date" class="position-relative row form-group">
                                       <label for="txtDate" class="col-sm-2 col-form-label">Trade Date</label>
                                    
                                     <div class="col-sm-4 date datepicker">
                                        <div class="input-group">
                                            <input style="background:#ffffff; cursor:default;" readonly id="txtDate" placeholder="Trade Date" type="text" class="form-control" value="<?php echo date('d M Y'); ?>">
                                            
                                            <span class="input-group-btn"><button style="border-radius:0;" class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                        </div>
                                     </div>
                                   </div>
                                   
                                  	<table class="hover table table-bordered data-table display wrap" id="tabTrades">
                                      <thead>
                                        <tr>
                                            <th style="text-align:center" width="15%">TRADE DATE</th>
                                            <th style="text-align:center" width="13%">TRADE ID</th>
                                            <th style="text-align:center" width="11%">ASSET</th> 
                                            <th style="text-align:center" width="11%">TOKENS</th>
                                            <th style="text-align:center" width="10%">PRICE</th>
                                            <th style="text-align:center" width="14%">AMOUNT</th>
                                            <th style="text-align:center" width="13%">SELLER</th>
                                            <th style="text-align:center" width="13%">BUYER</th>                           
                                        </tr>
                                      </thead>
            
                                      <tbody id="tbtradebody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane tabs-animation fade" id="view" role="tabpanel">
                        	<div class="row">
                            	<div class="col-md-12">
                                	<div class="mb-3 card">
                                        <div class="card-body">
                                           <!--Symbol-->
                                            <div title="Asset" class="position-relative row form-group">
                                                <label for="cboOrderSymbol" class="col-sm-2 col-form-label">Asset</label>
                                                
                                                <div class="col-sm-4">
                                                    <select id="cboOrderSymbol" class="form-control"></select>
                                                 </div>
                                            </div>
                                           
                                            <span> <span style="font-weight:bold; color:#A00;">SELL ORDERS</span> <span style="float:right; margin-right:10px; font-weight:bold; color:#00A;">BUY ORDERS</span></span>
                                            
                                            <table class="size-14" align="center" width="100%" style="width:100%; background:#E7E7E7; height:auto">
                                                <tr>
                                                    <td valign="top" style="width:49.5%;">
                                                        <!--(Sell) Bid - Blue	-->										
                                                        <table id="tabSellBook" style="width:100%;" class="hover sell-table-striped table table-bordered data-table display wrap">
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
                                                        <table id="tabBuyBook" width="100%" class="hover buy-table-striped table table-bordered data-table display wrap">
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
                                        </div>
                                    </div> 
                                </div>
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
