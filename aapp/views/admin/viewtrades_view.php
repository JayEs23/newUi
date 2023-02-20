<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Naija Art Mart - View Trades History</title>
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
		
		.modal-content {
		  background-color: #fefefe;
		  margin: 10% auto; /* 15% from the top and centered */
		  padding: 10px;
		  border: 1px solid #888;/*888*/
		  position: relative;
		  margin-top:30px;
		  width: 100%; /* Could be more or less, depending on screen size */
		}

		
		/* The Close Button */
		.close {
		  /*color: #fefefe;*/
		  float: right;
		  font-size: 28px;
		  font-weight: bold;
		}
		
		.close:hover,
		.close:focus {
		  color: yellow;
		  text-decoration: none;
		  cursor: pointer;
		}
    </style>

	<script type = "text/javascript">
	
	var Title='<font color="#AF4442">Naija Art Mart Message</font>';
	var Email='<?php echo $email; ?>';
	var emptypix='<?php echo base_url(); ?>images/empty.jpg';
	var m='',tabletrade2,tabletrade1;
	
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
		
		$('.tradedatepicker2').datepicker({
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

		$('#txtTradeStartDate2').datepicker({
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
		
		$('#txtTradeEndDate2').datepicker({
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
		
		function VerifyStartAndEndDates2()
		{
			try
			{
				$('#divAlert').html('');
				
				var startdt=ChangeDateFrom_dMY_To_Ymd($('#txtTradeStartDate2').val());
				var enddt=ChangeDateFrom_dMY_To_Ymd($('#txtTradeEndDate2').val());
				var sdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
				var edt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
				var d;
				
				if ($('#txtTradeStartDate2').val()=='0000-00-00') $('#txtTradeStartDate2').val('');
				if ($('#txtTradeEndDate2').val()=='0000-00-00') $('#txtTradeEndDate2').val('');
				
				if ($('#txtTradeStartDate').val())
				{
					if (!sdt.isValid())
					{
						m="Secondary Trade Start Date Is Not Valid. Please Select A Valid Secondary Trade Start Date.";
						
						DisplayMessage(m, 'error',Title);
					}	
				}
				
				
				if ($('#txtTradeEndDate').val())
				{
					if (!edt.isValid())
					{
						m="Secondary Trade End Date Is Not Valid. Please Select A Valid Secondary Trade End Date.";
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
										
					m="Trade End Date Is Before TSecondary rade Start Date. Please Correct Your Entries!";
					DisplayMessage(m, 'error',Title);
				}
			}catch(e)
			{
				$.unblockUI();
				m="VerifyStartAndEndDates2 ERROR:\n"+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
		}
		
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
						m="Primary Trade Start Date Is Not Valid. Please Select A Valid Primary Trade Start Date.";
						
						DisplayMessage(m, 'error',Title);
					}	
				}
				
				
				if ($('#txtTradeEndDate').val())
				{
					if (!edt.isValid())
					{
						m="Primary Trade End Date Is Not Valid. Please Select A Valid Primary Trade End Date.";
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
										
					m="Primary Trade End Date Is Before Primary Trade Start Date. Please Correct Your Entries!";
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

		LoadIssuers();
		
		$('#btnDisplayPrimaryTrades').click(function(e) {
			try
			{
				var p=$.trim($('#txtTradeStartDate').val());
				var d=$.trim($('#txtTradeEndDate').val());
				var issuer=$.trim($('#cboIssuer').val());
									
				//Start date
				if (!p)
				{
					m='You have not selected the primary trade start date.';					
					DisplayMessage(m,'error',Title);
					return false;
				}					

				//End Date
				if (!d)
				{
					m='You have not selected the primary trade end date.';
					DisplayMessage(m,'error',Title);
					return false;
				}	
				
				if (!p && d)
				{
					m='You have selected the primary trade end date. Primary trade start date field must also be selected.';						
					DisplayMessage(m,'error',Title);
					return false;
				}					

				if (p && !d)
				{
					m='You have selected the primary trade start date. Primary trade end date field must also be selected.';						

					DisplayMessage(m,'error',Title);
					return false;
				}					

				var startdt = ChangeDateFrom_dMY_To_Ymd($('#txtTradeStartDate').val());
				var enddt = ChangeDateFrom_dMY_To_Ymd($('#txtTradeEndDate').val());
				var sdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
				var edt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
				var sta = $.trim($('#cboPriStatus').val());
			
				if (p && d)
				{
					var dys=edt.diff(sdt, 'days') //If this -ve invalid date entries.
							
					if (dys<0)
					{
						m="Primary Trade End Date Is Before The Primary Trade Start Date. Please Correct Your Entries!";
						DisplayMessage(m, 'error',Title);
						return false;
					}
				}					
				
				LoadPrimaryTrades(startdt,enddt,issuer,sta);
			}catch(e)
			{
				$.unblockUI();
				m='Display Primary Trades Button Click ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		});
		
		function LoadPrimaryTrades(sdt,edt,issuer,sta)
		{
			try
			{
				$.ajax({
					url: "<?php echo site_url('admin/Viewtrades/GetPrimaryTrades');?>",
					type: 'POST',
					data: {issuer:issuer, startdate:sdt,enddate:edt,status:sta},
					dataType: 'json',
					success: function(dataSet,status,xhr) {	
						$.unblockUI();
						
						if (tabletrade1) tabletrade1.destroy();
						
						//f-filtering, l-length, i-information, p-pagination
						tabletrade1 = $('#tabTrades').DataTable( {
							dom: '<"top"if>rt<"bottom"lp><"clear">',
							responsive: true,
							ordering: false,
							autoWidth:false,
							language: {zeroRecords: "No Primary Trade Record Found"},
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
					
						total=tabletrade1.column(5).data().sum();
													
						if (parseFloat(total) > 0)
						{
							$('#tdAmount1').html('₦'+number_format (total, 2, '.', ','));
						}else
						{
							$('#tdAmount1').html('');
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
				m='LoadPrimaryTrades ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}
		
		function LoadSecondaryTrades(sdt,edt,sta)
		{
			try
			{
				$.ajax({
					url: "<?php echo site_url('admin/Viewtrades/GetSecondaryTrades');?>",
					type: 'POST',
					data: {startdate:sdt,enddate:edt,status:sta},
					dataType: 'json',
					success: function(dataSet,status,xhr) {	
						$.unblockUI();
						
						if (tabletrade2) tabletrade2.destroy();
						
						//f-filtering, l-length, i-information, p-pagination
						tabletrade2 = $('#tabSecondaryTrades').DataTable( {
							dom: '<"top"if>rt<"bottom"lp><"clear">',
							responsive: true,
							ordering: false,
							autoWidth:false,
							language: {zeroRecords: "No Secondary Trade Record Found"},
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
					
						total=tabletrade2.column(5).data().sum();
													
						if (parseFloat(total) > 0)
						{
							$('#tdAmount2').html('₦'+number_format (total, 2, '.', ','));
						}else
						{
							$('#tdAmount2').html('');
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
				m='LoadSecondaryTrades ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}
		
		$('#btnDisplaySecondaryTrades').click(function(e) {
			try
			{
				var p=$.trim($('#txtTradeStartDate2').val());
				var d=$.trim($('#txtTradeEndDate2').val());
				var sta = $.trim($('#cboSecStatus').val());
									
				//Start date
				if (!p)
				{
					m='You have not selected the secondary trade start date.';					
					DisplayMessage(m,'error',Title);
					return false;
				}					

				//End Date
				if (!d)
				{
					m='You have not selected the secondary trade end date.';
					DisplayMessage(m,'error',Title);
					return false;
				}	
				
				if (!p && d)
				{
					m='You have selected the secondary trade end date. Secondary trade start date field must also be selected.';						
					DisplayMessage(m,'error',Title);
					return false;
				}					

				if (p && !d)
				{
					m='You have selected the secondary trade start date. Secondary trade end date field must also be selected.';						

					DisplayMessage(m,'error',Title);
					return false;
				}					

				var startdt = ChangeDateFrom_dMY_To_Ymd($('#txtTradeStartDate2').val());
				var enddt = ChangeDateFrom_dMY_To_Ymd($('#txtTradeEndDate2').val());
				var sdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
				var edt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
			
				if (p && d)
				{
					var dys=edt.diff(sdt, 'days') //If this -ve invalid date entries.
							
					if (dys<0)
					{
						m="Secondary Trade End Date Is Before The Secondary Trade Start Date. Please Correct Your Entries!";
						DisplayMessage(m, 'error',Title);
						return false;
					}
				}					
				
				LoadSecondaryTrades(startdt,enddt,sta);
			}catch(e)
			{
				$.unblockUI();
				m='Display Secondary Trades Button Click ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
        });
		
		function LoadIssuers()
		{
			try
			{
				$('#cboIssuer').empty();				
									
				$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Issuers. Please Wait....</p>',theme: false,baseZ: 2000});
				
				$.ajax({
					url: "<?php echo site_url('admin/Viewtrades/GetIssuers');?>",
					type: 'POST',
					dataType: 'json',
					success: function(data,status,xhr) {	
						$.unblockUI();

						if ($(data).length > 0)
						{
							$("#cboIssuer").append(new Option('[ALL ISSUERS]', ''));
							
							$.each($(data), function(i,e)
							{
								if (e.email)
								{
									$("#cboIssuer").append(new Option($.trim(e.user_name).toUpperCase(), $.trim(e.email)));
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
				m="LoadIssuers ERROR:\n"+e;
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
                                                    View Trades
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
                            <a role="tab" class="nav-link active" id="tabView" data-toggle="tab" href="#secondary">
                                <span>Secondary Trades History</span>
                            </a>
                        </li> 
                        
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabView" data-toggle="tab" href="#primary">
                                <span>Primary Trades History</span>
                            </a>
                        </li>                    
                        
                        <li onClick="window.location.reload(true);" class="nav-item">
                            <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#refresh">
                                <span>Refresh</span>
                            </a>
                        </li>
                    </ul>
                    
                    
                    <div class="tab-content">
                    	 <!--Secondary Trades Tab-->
                        <div class="tab-pane tabs-animation fade show active" id="secondary" role="tabpanel">
                        	 <!--Start Date/End Date-->                                       
                            <div class="position-relative row form-group">
                                 <!--Start Date--> 
                                <label title="Start Date" for="txtTradeStartDate2" class="col-sm-1 col-form-label text-right">Start Date</label>
                            
                                <div title="Start Date" class="col-sm-2 date tradedatepicker2">
                                    <div class="input-group">
                                        <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtTradeStartDate2" placeholder="Trade Start Date">
                                        
                                        <span class="input-group-btn"><button class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                    </div>
                                 </div>
                                 
                                  <!--End Date--> 
                                  <label title="End Date" for="txtTradeEndDate2" class="col-sm-1 col-form-label text-right">End Date</label>
                            
                                <div title="End Date" class="col-sm-2 date tradedatepicker2">
                                    <div class="input-group">
                                        <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtTradeEndDate2" placeholder="Trade End Date">
                                        
                                        <span class="input-group-btn"><button class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                    </div>                                    
                                 </div>
                                 
                                 <!--Trade Status--> 
                                 <label title="Trade Status" for="cboSecStatus" class="col-sm-1 col-form-label text-right">Trade&nbsp;Status</label>
                            
                                <div title="Trade Status" class="col-sm-2">
                                    <select id="cboSecStatus" class="form-control">
                                    	<option value="ALL">[ALL STATUS]</option>
                                        <option value="1">Successful Trades</option>
                                        <option value="0">Failed Trades</option>
                                    </select>                                   
                                 </div>
                                 
                                 <!--Display Trade-->
                                 <div title="Click to display trades" class="col-sm-2">
                                    <button id="btnDisplaySecondaryTrades" type="button" class="btn btn-primary form-control makebold">DISPLAY TRADES</button>
                                 </div>
                                 
                            </div>
                            
                            
                            <div class="row">
                            	<div class="col-md-12">
                                	<div class="mb-3 card">
                                        <div class="card-body">
                                            <table class="hover table table-bordered data-table display wrap" id="tabSecondaryTrades">
                                              <thead>
                                                <tr>
                                                    <th style="text-align:center" width="15%">TRADE&nbsp;DATE</th>
                                                    <th style="text-align:center" width="13%">TRADE&nbsp;ID</th>
                                                    <th style="text-align:center" width="11%">ASSET</th> 
                                                    <th style="text-align:center" width="11%">TOKENS</th>
                                                    <th style="text-align:right; padding-right:7px;" width="10%">PRICE</th>
                                                    <th style="text-align:right; padding-right:7px;" width="14%">AMOUNT</th>
                                                    <th style="text-align:center" width="13%">SELLER</th>
                                                    <th style="text-align:center" width="13%">BUYER</th>
                                                </tr>
                                              </thead>
                    
                                              <tbody id="tbbody"></tbody>
                                              
                                              <tfoot style="color:#ffffff; background-color:#7E7B7B;">
                                                    <tr>
                                                        <th colspan="5" style="text-align:right; padding:3px; padding-right:10px; font-weight:bold; font-size:13px;" width="54%">TOTAL TRADE AMOUNT:</th>
                                                        
                                                        <th colspan="3" id="tdAmount2" style="text-align:left; padding:20px; padding-right:8px; font-weight:bold; font-size:14px;" width="26%"></th>
                                                    </tr>
                                              </tfoot>
                                            </table>                                           
                                        </div>
                                    </div> 
                                </div>
                            </div>                            
                        </div>
                        
                         <!--Primary Trades Tab-->
                        <div class="tab-pane tabs-animation fade" id="primary" role="tabpanel">
                        	 <!--Start Date/End Date-->                                       
                            <div class="position-relative row form-group">
                                 <!--Start Date--> 
                                <label title="Start Date" for="txtTradeStartDate" class="col-sm-1 col-form-label text-right">Start Date</label>
                            
                                <div title="Start Date" class="col-sm-3 date tradedatepicker">
                                    <div class="input-group">
                                        <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtTradeStartDate" placeholder="Trade Start Date">
                                        
                                        <span class="input-group-btn"><button class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                    </div>
                                 </div>
                                 
                                  <!--End Date--> 
                                  <label title="End Date" for="txtTradeEndDate" class="col-sm-1 col-form-label text-right">End Date</label>
                            
                                <div title="End Date" class="col-sm-3 date tradedatepicker">
                                    <div class="input-group">
                                        <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtTradeEndDate" placeholder="Trade End Date">
                                        
                                        <span class="input-group-btn"><button class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                    </div>                                    
                                 </div>
                                 
                                 
                                  <!--Trade Status--> 
                                 <label title="Trade Status" for="cboPriStatus" class="col-sm-2 col-form-label text-right">Trade&nbsp;Status</label>
                            
                                <div title="Trade Status" class="col-sm-2">
                                    <select id="cboPriStatus" class="form-control">
                                    	<option value="ALL">[ALL STATUS]</option>
                                        <option value="1">Successful Trades</option>
                                        <option value="0">Failed Trades</option>
                                    </select>                                   
                                 </div>
                                 
                            </div>
                            
                            <!--Issuer-->                                       
                            <div class="position-relative row form-group">
                                 <!--Start Date--> 
                                <label title="Issuer" for="txtTradeStartDate" class="col-sm-1 col-form-label text-right">Issuer</label>
                            
                                <div title="Issuer" class="col-sm-9">
                                    <select id="cboIssuer" class="form-control nsebuttongreen makebold" ></select>
                                 </div>
                                         
                                 
                                 <!--Display Trade-->
                                 <div title="Click to display trades" class="col-sm-2">
                                    <button id="btnDisplayPrimaryTrades" type="button" class="btn btn-primary form-control makebold">DISPLAY TRADES</button>
                                 </div>
                            </div>
                            
                            
                            <div class="row">
                            	<div class="col-md-12">
                                	<div class="mb-3 card">
                                        <div class="card-body">
                                            <table class="hover table table-bordered data-table display wrap" id="tabTrades">
                                              <thead>
                                                <tr>
                                                	<th style="text-align:center" width="15%">TRADE&nbsp;DATE</th>
                                                    <th style="text-align:center" width="13%">TRADE&nbsp;ID</th>
                                                    <th style="text-align:center" width="11%">ASSET</th> 
                                                    <th style="text-align:center" width="11%">TOKENS</th>
                                                    <th style="text-align:right; padding-right:7px;" width="10%">PRICE</th>
                                                    <th style="text-align:right; padding-right:7px;" width="14%">AMOUNT</th>
                                                    <th style="text-align:center" width="13%">SELLER</th>
                                                    <th style="text-align:center" width="13%">BUYER</th>
                                                </tr>
                                              </thead>
                    
                                              <tbody id="tbbody"></tbody>
                                              
                                              <tfoot style="color:#ffffff; background-color:#7E7B7B;">
                                                    <tr>
                                                        <th colspan="5" style="text-align:right; padding:3px; padding-right:10px; font-weight:bold; font-size:13px;" width="54%">TOTAL TRADE AMOUNT:</th>
                                                        
                                                        <th colspan="3" id="tdAmount1" style="text-align:left; padding:20px; padding-right:8px; font-weight:bold; font-size:14px;" width="26%"></th>
                                                    </tr>
                                              </tfoot>
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


<!--Start Pix Popup-->
<div id="myPixModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background-color:#000000; padding:0;">
          <div class="modal-header" style="background-color:#363131;">              
              <h4 style="color:#ffffff; margin-right:39px;" id="modPixTitle" class="modal-title">PICTURE</h4>
              <button title="Click X to close the picture screen" type="button" class="close" data-dismiss="modal">×</button>
          </div>
          
          <div align="center" class="modal-body" style="padding:1px;">
            <img class="modal-content" id="img01" style="margin-top:0; border:none; ">
          </div>
          
          <div class="modal-footer">
            <center><button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button></center>
          </div>
        </div>
      </div>
</div>

<!--End Pix Popup-->


<script type="text/javascript" src="<?php echo base_url();?>assets/js/main.8d288f825d8dffbbe55e.js"></script>
</body>
</html>
