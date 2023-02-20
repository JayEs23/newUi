<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Naija Art Mart - Trade Orders Report</title>
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
	var m='',table;
	
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

		$('#txtReportStartDate').datepicker({
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
		
		$('#txtReportStartDate').blur(function(e) {
			try
			{
				if ($('#txtReportStartDate').val() && $('#txtReportEndDate').val())
				{
					VerifyStartAndEndDates();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="Report Start Date Blur ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});
		
		$('#txtReportStartDate').change(function(e) {
			try
			{
				if ($('#txtReportStartDate').val() && $('#txtReportEndDate').val())
				{
					VerifyStartAndEndDates();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="Report Start Date Change ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});			

		$('#txtReportEndDate').datepicker({
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

		$('#txtReportEndDate').blur(function(e) 
		{
			try
			{
				if ($('#txtReportStartDate').val() && $('#txtReportEndDate').val())
				{
					VerifyStartAndEndDates();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="End Date Blur ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});
		
		$('#txtReportEndDate').change(function(e) 
		{
			try
			{
				if ($('#txtReportStartDate').val() && $('#txtReportEndDate').val())
				{
					VerifyStartAndEndDates();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="End Date Change ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});
		
		function VerifyStartAndEndDates()
		{
			try
			{
				$('#divAlert').html('');
				
				var startdt=ChangeDateFrom_dMY_To_Ymd($('#txtReportStartDate').val());
				var enddt=ChangeDateFrom_dMY_To_Ymd($('#txtReportEndDate').val());
				var sdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
				var edt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
				var d;
				
				if ($('#txtReportStartDate').val()=='0000-00-00') $('#txtReportStartDate').val('');
				if ($('#txtReportEndDate').val()=='0000-00-00') $('#txtReportEndDate').val('');
				
				if ($('#txtReportStartDate').val())
				{
					if (!sdt.isValid())
					{
						m="Report Start Date Is Not Valid. Please Select A Valid Report Start Date.";
						
						DisplayMessage(m, 'error',Title);
					}	
				}
				
				
				if ($('#txtReportEndDate').val())
				{
					if (!edt.isValid())
					{
						m="Report End Date Is Not Valid. Please Select A Valid Report End Date.";
						DisplayMessage(m, 'error',Title);
					}	
				}
				
									
				//moment('2010-10-20').isSameOrBefore('2010-10-21');  // true				
				var dys=edt.diff(sdt, 'days') //If this -ve invalid date entries. Delivery earlier than pickup
				var diff = moment.duration(edt.diff(sdt));
				var mins = parseInt(diff.asMinutes());
				
				
				if (dys<0)
				{
					$('#txtReportEndDate').val('');
										
					m="Report End Date Is Before Report Start Date. Please Correct Your Entries!";
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
		
		LoadSymbols();
		LoadInvestors();
		LoadBrokers();
		
		$('#btnPDF').click(function(e) 
		{
			try
			{
				if (!CheckForm()) return false;
				
				$.blockUI({message:'<img src="<?php echo base_url();?>images/loader.gif" /><p>Generating Trade Orders PDF Report. Please Wait...</p>',theme: false,baseZ: 2000});
				
				
				var inv=$.trim($('#cboInvestor').val());
				var br=$.trim($('#cboBroker').val());
				var sym=$.trim($('#cboSymbol').val());				
				var otyp=$.trim($('#cboOrderType').val());
				var ttyp=$.trim($('#cboTransactionType').val());
				var sta=$.trim($('#cboStatus').val());			
				var sdt=ChangeDateFrom_dMY_To_Ymd($('#txtReportStartDate').val());
				var edt=ChangeDateFrom_dMY_To_Ymd($('#txtReportEndDate').val());
				var sd =moment(sdt.replace(new RegExp('-', 'g'), '/')).format("Do MMM YYYY");
				var ed =moment(edt.replace(new RegExp('-', 'g'), '/')).format("Do MMM YYYY");
				
				sd=sd.replace(new RegExp(' ', 'g'), '-');//' ','_'
				ed=ed.replace(new RegExp(' ', 'g'), '-');//' ','_'					
				
				var reportfile;
				
				if (sdt==edt)
				{
					reportfile="ordersrep_op_report_"+sd+".pdf";
				}else
				{
					reportfile="ordersrep_op_report_from_"+sd+'_to_'+ed+".pdf";
				}
				
				var msg;
									
				msg='Trade Orders Report';					
				
				if (sdt && edt)
				{
					if (sdt == edt)
					{
						msg = msg + ' For '+ $('#txtReportStartDate').val();
					}else
					{
						msg = msg + ' From '+ $('#txtReportStartDate').val() + ' - ' + $('#txtReportEndDate').val();
					}
				}	
				
				var mydata={broker_id:br,investor_id:inv,symbol:sym,ordertype:otyp,transtype:ttyp,orderstatus:sta,startdate:sdt,enddate:edt,ReportTitle:msg};
															
				$.ajax({
					url: "<?php echo site_url('admin/Tradeordersrep_op/CreatePDFReport'); ?>",
					data: mydata,
					type: 'POST',
					dataType: 'text',
					complete: function(xhr, textStatus) {					
						$.unblockUI();
					},
					success: function(data,status,xhr) {
						$.unblockUI();
						
						var ret='';
						ret=$.trim(data);
	
						if (ret.toLowerCase() == $.trim(reportfile).toLowerCase())
						{
							window.open('<?php echo base_url(); ?>reports/'+reportfile,null,'left=0, top=0, height=700, width= 1000, status=no, resizable= yes, scrollbars= yes, toolbar= no,location= no, menubar= no');
						}else
						{
							m='Generating Of PDF Report Failed. Please Try Again.';
							m=m+'<br><br><b>'+ret+'</b>';
							DisplayMessage(m,'error',Title);
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
				m='PDF Report Button Click ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		});//btnPDF.click
		
		$('#btnExcel').click(function(e) 
		{
			try
			{
				if (!CheckForm()) return false;
				
				$.blockUI({message:'<img src="<?php echo base_url();?>images/loader.gif" /><p>Generating Trade Orders Excel Report. Please Wait...</p>',theme: false,baseZ: 2000});
				
				var inv=$.trim($('#cboInvestor').val());
				var br=$.trim($('#cboBroker').val());
				var sym=$.trim($('#cboSymbol').val());				
				var otyp=$.trim($('#cboOrderType').val());
				var ttyp=$.trim($('#cboTransactionType').val());
				var sta=$.trim($('#cboStatus').val());
				var sdt=ChangeDateFrom_dMY_To_Ymd($('#txtReportStartDate').val());
				var edt=ChangeDateFrom_dMY_To_Ymd($('#txtReportEndDate').val());
				var sd =moment(sdt.replace(new RegExp('-', 'g'), '/')).format("Do MMM YYYY");
				var ed =moment(edt.replace(new RegExp('-', 'g'), '/')).format("Do MMM YYYY");
				
				sd=sd.replace(new RegExp(' ', 'g'), '-');//' ','_'
				ed=ed.replace(new RegExp(' ', 'g'), '-');//' ','_'					
				
				var reportfile;
				
				if (sdt==edt)
				{
					reportfile="ordersrep_op_report_"+sd+".xls";
				}else
				{
					reportfile="ordersrep_op_report_from_"+sd+'_to_'+ed+".xls";
				}

				var msg;
									
				msg='Trade Orders Report';					
				
				if (sdt && edt)
				{
					if (sdt == edt)
					{
						msg = msg + ' For '+ $('#txtReportStartDate').val();
					}else
					{
						msg = msg + ' From '+ $('#txtReportStartDate').val() + ' - ' + $('#txtReportEndDate').val();
					}
				}	
				
				var mydata={broker_id:br,investor_id:inv,symbol:sym,ordertype:otyp,transtype:ttyp,orderstatus:sta,startdate:sdt,enddate:edt,ReportTitle:msg};
															
				$.ajax({
					url: "<?php echo site_url('admin/Tradeordersrep_op/CreateExcelReport'); ?>",
					data: mydata,
					type: 'POST',
					dataType: 'text',
					complete: function(xhr, textStatus) {					
						$.unblockUI();
					},
					success: function(data,status,xhr) {
						$.unblockUI();
						
						var ret='';
						ret=$.trim(data);
	
						if (ret.toLowerCase() == $.trim(reportfile).toLowerCase())
						{
							window.open('<?php echo base_url(); ?>reports/'+reportfile,null,'left=0, top=0, height=350, width= 500, status=no, resizable= yes, scrollbars= yes, toolbar= no,location= no, menubar= no');
						}else
						{
							m='Generating Of Excel Report Failed. Please Try Again.';
							m=m+'<br><br><b>'+ret+'</b>';
							DisplayMessage(m,'error',Title);
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
				m='Excel Report Button Click ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		});//btnExcel.click	

		$('#btnDisplay').click(function(e)
		{
			try
			{
				if (!CheckForm()) return false;
				
				var sdt=ChangeDateFrom_dMY_To_Ymd($('#txtReportStartDate').val());
				var edt=ChangeDateFrom_dMY_To_Ymd($('#txtReportEndDate').val());
				var inv=$.trim($('#cboInvestor').val());
				var br=$.trim($('#cboBroker').val());	
				var sym=$.trim($('#cboSymbol').val());				
				var otyp=$.trim($('#cboOrderType').val());
				var ttyp=$.trim($('#cboTransactionType').val());
				var sta=$.trim($('#cboStatus').val());
				
				DisplayReport(br,inv,sym,otyp,ttyp,sta,sdt,edt);
			}catch(e)
			{
				$.unblockUI();
				m='Display Reports Button Click ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		});
		
		function DisplayReport(br,inv,sym,otyp,ttyp,sta,sdt,edt)
		{
			try
			{
				$.blockUI({message:'<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Trade Orders Report Records. Please Wait...</p>',theme: false,baseZ: 2000});
					
				//Make Ajax Request
				var msg;
																		
				msg='Trade Orders Report';					
				
				if (sdt && edt)
				{
					if (sdt == edt)
					{
						msg = msg + ' For '+ $('#txtReportStartDate').val();
					}else
					{
						msg = msg + ' From '+ $('#txtReportStartDate').val() + ' To ' + $('#txtReportEndDate').val();
					}
				}				
							
				var mydata={broker_id:br,investor_id:inv,symbol:sym,ordertype:otyp,transtype:ttyp,orderstatus:sta,startdate:sdt,enddate:edt};	
				
				$('#recorddisplay > tbody').html('');
				
				$.ajax({
					url: "<?php echo site_url('admin/Tradeordersrep_op/DisplayReport');?>",
					data: mydata,
					type: 'POST',
					dataType: 'json',
					success: function(dataSet,status,xhr) {	
						$.unblockUI();
						
						if (table) table.destroy();
						
						//f-filtering, l-length, i-information, p-pagination
						table = $('#recorddisplay').DataTable( {
							dom: '<"top"if>rt<"bottom"lp><"clear">',
							responsive: true,
							ordering: false,
							autoWidth:false,
							language: {zeroRecords: "No Trade Order Record Found"},
							lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
							columnDefs: [
								{
									"targets": [ 0,1,2,3,4,5,6,7,8 ],
									"visible": true
								},
								{
									"targets": [ 0,1,2,3,4,5,6,7,8 ],
									"orderable": true
								},
								{
									"targets": [ 0,1,2,3,4,5,6,7,8 ],
									"searchable": true
								},
								{ className: "dt-center", "targets": [ 0,1,2,3,5,6,7,8 ] },
								{ className: "dt-right", "targets": [ 4 ] }
							],					
							order: [[ 2, 'asc' ]],
							data: dataSet, 
							columns: [
								{ width: "10%" },//Order Date
								{ width: "11%" },//Order Id
								{ width: "10%" },//Symbol
								{ width: "10%" },//Tokens
								{ width: "10%" },//Price
								{ width: "11%" },//Order Type
								{ width: "18%" },//Investor
								{ width: "10%" },//Trans. Type
								{ width: "10%" }//Trans. Status
							],//10,11,10,10,10,11,18,10,10
						} );
						
						AdminActivateTab('view');
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
				m='DisplayReport ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}
		
		function CheckForm()
		{
			try
			{
				var startdt=ChangeDateFrom_dMY_To_Ymd($('#txtReportStartDate').val());
				var enddt=ChangeDateFrom_dMY_To_Ymd($('#txtReportEndDate').val());
				var pdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
				var ddt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
				var p=$.trim($('#txtReportStartDate').val());
				var d=$.trim($('#txtReportEndDate').val());
				var em='<?php echo $email; ?>';
									
			
				//User
				if (!em)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the reporting.';
					
					DisplayMessage(m, 'error',Title);
					return false;
				}			
										
				//Start date Not Select. End Date Selected
				if (!p)
				{
					m='You have not selected the report start date.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}
								
				if (!d)
				{
					m='You have not selected the report end date.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}
					
				if (!p && d)
				{
					m='You have selected the report end date. Report start date field must also be selected.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}
					
				//End date Not Select. Start Date Selected
				if (p && !d)
				{
					m='You have selected the report start date. Report end date field must also be selected.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}
					
				if (p)
				{
					if (!pdt.isValid())
					{
						m="Report Start Date Is Not Valid. Please Select A Valid Report Start Date";
						DisplayMessage(m, 'error',Title);
						return false;
					}	
				}
					
				if (d)
				{
					if (!ddt.isValid())
					{
						m="Report End Date Is Not Valid. Please Select A Valid Report End Date";
						DisplayMessage(m, 'error',Title);						
						return false;
					}	
				}
								
				if (p && d)
				{
					var dys=ddt.diff(pdt, 'days') //If this -ve invalid date entries. Delivery earlier than pickup
					
					if (dys<0)
					{
						m="Report End Date Is Before The Report Start Date. Please Correct Your Entries!";
						DisplayMessage(m, 'error',Title);
						return false;
					}
				}			
				
				return true;
			}catch(e)
			{
				$.unblockUI();
				m="CheckForm ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
			}
		}//End CheckForm
    });//Document Ready
	
	
	function LoadSymbols()
	{
		try
		{
			$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Symbol. Please Wait...</p>',theme: false,baseZ: 2000});				

			$('#cboSymbol').empty();		

			$.ajax({
				url: "<?php echo site_url('admin/Tradeordersrep_op/GetSymbols');?>",
				type: 'POST',
				dataType: 'json',
				success: function(data,status,xhr) {	
					$.unblockUI();

					if ($(data).length > 0)
					{
						$("#cboSymbol").append(new Option("[ALL ASSETS]", ""));
						
						$.each($(data), function(i,e)
						{
							if (e.symbol && e.title)
							{
								$("#cboSymbol").append(new Option($.trim(e.title)+' (' + $.trim(e.symbol)+')', $.trim(e.symbol)));
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
			m='LoadSymbols ERROR:\n'+e;
			DisplayMessage(m, 'error',Title);
		}
	}
	
	function LoadInvestors()
	{
		try
		{
			$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Investors. Please Wait...</p>',theme: false,baseZ: 2000});				

			$('#cboInvestor').empty();	

			$.ajax({
				url: "<?php echo site_url('admin/Primarytradesrep_op/GetInvestors');?>",
				type: 'POST',
				dataType: 'json',
				success: function(data,status,xhr) {	
					$.unblockUI();

					if ($(data).length > 0)
					{
						$("#cboInvestor").append(new Option("[ALL INVESTORS]", ""));
						
						$.each($(data), function(i,e)
						{
							if (e.user_name && e.email)
							{
								$("#cboInvestor").append(new Option($.trim(e.user_name)+" ("+$.trim(e.email)+")", $.trim(e.email)));
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
			m='LoadInvestors ERROR:\n'+e;
			DisplayMessage(m, 'error',Title);
		}
	}
	
	function LoadBrokers()
	{
		try
		{
			$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Brokers. Please Wait...</p>',theme: false,baseZ: 2000});				

			$('#cboBroker').empty();		
			
			$.ajax({
				url: "<?php echo site_url('admin/Primarytradesrep_op/GetBrokers');?>",
				type: 'POST',
				dataType: 'json',
				success: function(data,status,xhr) {	
					$.unblockUI();

					if ($(data).length > 0)
					{
						$("#cboBroker").append(new Option("[ALL BROKERS]", ""));
						
						$.each($(data), function(i,e)
						{
							if (e.company && e.broker_id)
							{
								$("#cboBroker").append(new Option($.trim(e.company), $.trim(e.broker_id)));
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
			m='LoadBrokers ERROR:\n'+e;
			DisplayMessage(m, 'error',Title);
		}
	}

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
                                                    Trade Orders Report
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
                                <span>Report Parameters</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabView" data-toggle="tab" href="#view">
                                <span>View Trade Orders Report</span>
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
                                    <form class="">
                                        <!--Asset-->
                                        <div title="Trade Asset" class="position-relative row form-group">
                                            <label for="cboSymbol" class="col-sm-2 col-form-label">Asset</label>
                                            
                                            <div class="col-sm-10">
                                                <select class="form-control" id="cboSymbol"></select>
                                             </div>
                                        </div>
                                      
                                        <!--Investor-->
                                        <div title="Investor" class="position-relative row form-group">
                                        	<label for="cboInvestor" class="col-sm-2 col-form-label">Investor</label>
                                            
                                            <div class="col-sm-10">
                                            	<select class="form-control" id="cboInvestor"></select>
                                             </div>
                                        </div>
                                        
                                        <!--Broker-->
                                        <div title="Broker" class="position-relative row form-group">
                                        	<label for="cboBroker" class="col-sm-2 col-form-label">Broker</label>
                                            
                                            <div class="col-sm-10">
                                            	<select class="form-control" id="cboBroker"></select>
                                             </div>
                                        </div>
                                        
                                        <!--Order Type-->
                                        <div title="Order Type" class="position-relative row form-group">
                                            <label for="cboOrderType" class="col-sm-2 col-form-label">Order Type</label>
                                            
                                            <div class="col-sm-4">
                                                <select class="form-control" id="cboOrderType">
                                                    <option value="">[ALL ORDER TYPES]</option>
                                                    <option value="Market">Market Orders</option>
                                                    <option value="Limit">Limit Orders</option>
                                                </select>
                                             </div>
                                        </div>
                                        
                                        <!--Order Status/Transaction Type-->
                                        <div class="position-relative row form-group">
                                        	<!--Order Status-->
                                        	<label title="Order Status" for="cboStatus" class="col-sm-2 col-form-label">Order Status</label>
                                            
                                            <div title="Order Status" class="col-sm-4">
                                            	<select class="form-control" id="cboStatus">
                                                    <option value="">[ALL ORDER STATUS]</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Cancelled">Cancelled</option>
                                                    <option value="Executed">Executed</option>
                                                    <option value="Not Active">Not Active</option>
                                                    <option value="Submitted">Submitted</option>
                                                </select>
                                             </div>
                                             
                                            <!--Transaction Type-->
                                            <label title="Transaction Type" for="cboTransactionType" class="col-sm-2 col-form-label text-right">Transaction Type</label>
                                            
                                            <div title="Transaction Type" class="col-sm-4">
                                            	<select class="form-control" id="cboTransactionType">
                                                    <option value="">[ALL TRANSACTION TYPES]</option>
                                                    <option value="Sell">Sell</option>
                                                    <!--<option value="Buy">Buy</option>-->
                                                </select>
                                             </div>
                                        </div>
                                        
                                        
                                        <!--Report Start Date/Report End Date-->
                                        <div class="position-relative row form-group">
                                         	<!--Report Start Date-->
                                            <label title="Report Start Date" for="txtReportStartDate" class="col-sm-2 col-form-label">Report Start Date<span class="redtext">*</span></label>
                                            
                                            <div title="Report Start Date" class="col-sm-4 date datepicker">
                                                <div class="input-group">
                                                    <input style="background:#ffffff; cursor:default;" readonly id="txtReportStartDate" placeholder="Report Start Date" type="text" class="form-control">
                                                    
                                                    <span class="input-group-btn"><button style="border-radius:0;" class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                                </div>
                                             </div>
                                             
                                            <!--Report End Date-->
                                            <label title="Report End Date" for="txtReportEndDate" class="col-sm-2 col-form-label text-right">Report End Date<span class="redtext">*</span></label>
                                            
                                            <div title="Report End Date" class="col-sm-4 date datepicker">
                                                <div class="input-group">
                                                    <input style="background:#ffffff; cursor:default;" readonly id="txtReportEndDate" placeholder="Report End Date" type="text" class="form-control">
                                                    
                                                    <span class="input-group-btn"><button style="border-radius:0;" class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                                </div>
                                             </div> 
                                       </div>
                                    </form>
                                </div>
                                
                                <div id="divAlert" data-type="info" class="btn-show-swal"></div>                                
                            </div>
                        </div>
                        
                        <!--Buttons-->
                        <div class="position-relative row form-group">
                             <!--Buttond-->
                             <div class="col-sm-12">
                                 <div align="center">
                                    <button id="btnDisplay" type="button" class="btn btn-nse-green"><span class="fa fa-play-circle size-18 makebold" ></span> Display Report</button>
                 
                    <button style="margin-left:10px;" id="btnExcel" type="button" class="btn btn-primary"><i class="fa fa-file-excel size-18 makebold"></i> Export As Excel</button>
                
                    <button style="margin-left:10px;" id="btnPDF" type="button" class="btn btn-danger"><i class="fa fa-file-pdf size-18 makebold"></i> Export As PDF</button>
                    
                    <button style="margin-left:10px; color:#FFFFFF;" id="btnRefresh" type="button" class="btn btn-warning" onClick="window.location.reload(true);"><i class="fa pe-7s-refresh-2 size-18 makebold" ></i> Refresh</button>
                                </div>    
                             </div>
                        </div>
                        
                        <div class="tab-pane tabs-animation fade" id="view" role="tabpanel">
                        	<div class="row">
                            	<div class="col-md-12">
                                	<div class="mb-3 card">
                                        <div class="card-body">
                                           <table class="hover table table-bordered data-table display wrap " id="recorddisplay">
                                              <thead style="color:#ffffff; background-color:#7E7B7B;">
                                                <tr>
                                                    <th style="text-align:center" width="10%">ORDER&nbsp;DATE</th>
                                                    <th style="text-align:center" width="11%">ORDER&nbsp;ID</th>
                                                    <th style="text-align:center" width="10%">ASSET</th>
                                                    <th style="text-align:center" width="10%">TOKENS</th>
                                                    <th style="text-align:right; padding-right:7px;" width="10%">PRICE(₦)</th>
                                                    <th style="text-align:center" width="11%">ORDER&nbsp;TYPE</th>
                                                    <th style="text-align:center" width="18%">INVESTOR</th>
                                                    <th style="text-align:center" width="10%">TRANS.&nbsp;TYPE</th>
                                                    <th style="text-align:center" width="10%">STATUS</th>
                                                </tr>
                                              </thead>
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