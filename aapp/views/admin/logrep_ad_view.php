<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Naija Art Mart - Audit Trail Report</title>
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
		
		LoadUsers();
		
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
		
		$('#btnPDF').click(function(e) 
		{
			try
			{
				if (!CheckForm()) return false;
				
				$.blockUI({message:'<img src="<?php echo base_url();?>images/loader.gif" /><p>Generating Audit Trail PDF Report. Please Wait...</p>',theme: false,baseZ: 2000});
				
				
				var usr=$.trim($('#cboUser').val());
				var sdt=ChangeDateFrom_dMY_To_Ymd($('#txtReportStartDate').val());
				var edt=ChangeDateFrom_dMY_To_Ymd($('#txtReportEndDate').val());
				var sd =moment(sdt.replace(new RegExp('-', 'g'), '/')).format("Do MMM YYYY");
				var ed =moment(edt.replace(new RegExp('-', 'g'), '/')).format("Do MMM YYYY");
				
				sd=sd.replace(new RegExp(' ', 'g'), '-');//' ','_'
				ed=ed.replace(new RegExp(' ', 'g'), '-');//' ','_'					
				
				var reportfile;
				
				if (sdt==edt)
				{
					reportfile="logrep_ad_report_"+sd+".pdf";
				}else
				{
					reportfile="logrep_ad_report_from_"+sd+'_to_'+ed+".pdf";
				}
				
				var msg;
									
				msg='Audit Trail Report';					
				
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
				
				var mydata={username:usr,startdate:sdt,enddate:edt,ReportTitle:msg};
															
				$.ajax({
					url: "<?php echo site_url('admin/Logrep_ad/CreatePDFReport'); ?>",
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
				
				$.blockUI({message:'<img src="<?php echo base_url();?>images/loader.gif" /><p>Generating Audit Trail Excel Report. Please Wait...</p>',theme: false,baseZ: 2000});
				
				var usr=$.trim($('#cboUser').val());
				var sdt=ChangeDateFrom_dMY_To_Ymd($('#txtReportStartDate').val());
				var edt=ChangeDateFrom_dMY_To_Ymd($('#txtReportEndDate').val());
				var sd =moment(sdt.replace(new RegExp('-', 'g'), '/')).format("Do MMM YYYY");
				var ed =moment(edt.replace(new RegExp('-', 'g'), '/')).format("Do MMM YYYY");
				
				sd=sd.replace(new RegExp(' ', 'g'), '-');//' ','_'
				ed=ed.replace(new RegExp(' ', 'g'), '-');//' ','_'					
				
				var reportfile;
				
				if (sdt==edt)
				{
					reportfile="logrep_ad_report_"+sd+".xls";
				}else
				{
					reportfile="logrep_ad_report_from_"+sd+'_to_'+ed+".xls";
				}

				var msg;
									
				msg='Audit Trail Report';					
				
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
				
				var mydata={username:usr,startdate:sdt,enddate:edt,ReportTitle:msg};
															
				$.ajax({
					url: "<?php echo site_url('admin/Logrep_ad/CreateExcelReport'); ?>",
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
				
				var sdt=$.trim($('#txtReportStartDate').val());
				var edt=$.trim($('#txtReportEndDate').val());
				var usr=$.trim($('#cboUser').val());
				
				if (sdt) sdt=ChangeDateFrom_dMY_To_Ymd(sdt);
				if (edt) edt=ChangeDateFrom_dMY_To_Ymd(edt);
				
				DisplayReport(usr,sdt,edt);
			}catch(e)
			{
				$.unblockUI();
				m='Display Reports Button Click ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		});
		
		function DisplayReport(usr,sdt,edt)
		{
			try
			{
				$.blockUI({message:'<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Audit Trail Report Records. Please Wait...</p>',theme: false,baseZ: 2000});
					
				//Make Ajax Request
				var msg;
																		
				msg='Audit Trail Report';					
				
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
							
				var mydata={username:usr,startdate:sdt,enddate:edt};	
				
				$('#recorddisplay > tbody').html('');
				
				$.ajax({
					url: "<?php echo site_url('admin/Logrep_ad/DisplayReport');?>",
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
							language: {zeroRecords: "No Audit Trail Record Found"},
							lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
							columnDefs: [
								{
									"targets": [ 0,1,2,3,4,5 ],
									"visible": true
								},
								{
									"targets": [ 0,1,2,3,4,5 ],
									"orderable": true
								},
								{
									"targets": [ 0,1,2,3,4,5 ],
									"searchable": true
								},
								{ className: "dt-center", "targets": [ 0,1,2,3,4,5 ] }
							],					
							order: [[ 2, 'asc' ]],
							data: dataSet, 
							columns: [
								{ width: "16%" },//Log Date
								{ width: "17%" },//Email/Username
								{ width: "15%" },//Name Of Username
								{ width: "15%" },//Operation
								{ width: "25%" },//Activity
								{ width: "12%" }//IP Address
							],//16,17,15,15,25,12
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
				
				//Start date Not Select.
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
	
	function LoadUsers()
	{
		try
		{
			$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading System Users. Please Wait...</p>',theme: false,baseZ: 2000});			

			$('#cboUser').empty();				

			$.ajax({
				url: "<?php echo site_url('admin/Logrep_ad/LoadUsers');?>",
				type: 'POST',
				dataType: 'json',
				success: function(data,status,xhr) {	
					$.unblockUI();

					if ($(data).length > 0)
					{
						$("#cboUser").append(new Option("[ALL USERS]", ""));

						$.each($(data), function(i,e)
						{
							if (e.email)
							{
								var n='';
								
								if (e.fullname) n=e.fullname;
								
								if ($.trim(n) != '')
								{
									n += ' ['+$.trim(e.email)+']';
								}else
								{
									n=$.trim(e.email);
								}
								
								$("#cboUser").append(new Option(n, $.trim(e.email)));}
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
			m='LoadUsers ERROR:\n'+e;
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
                                                    Audit Trail Report
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
                                <span>View Audit Trail Report</span>
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
                                    	
                                        <!--System User-->
                                        <div title="System User" class="position-relative row form-group">
                                        	<label for="cboUser" class="col-sm-2 col-form-label">System User</label>
                                            
                                            <div class="col-sm-10">
                                            	<select class="form-control" id="cboUser"></select>
                                             </div>
                                        </div>                                     
                                        
                                        <!--Report Start Date-->
                                        <div title="Report Start Date" class="position-relative row form-group">
                                         	<label for="txtReportStartDate" class="col-sm-2 col-form-label">Report Start Date<span class="redtext">*</span></label>
                                            
                                            <div class="col-sm-4 date datepicker">
                                                <div class="input-group">
                                                    <input style="background:#ffffff; cursor:default;" readonly id="txtReportStartDate" placeholder="Report Start Date" type="text" class="form-control">
                                                    
                                                    <span class="input-group-btn"><button style="border-radius:0;" class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                                </div>
                                             </div>
                                       </div>
                                       
                                       <!--Report End Date-->
                                        <div title="Report End Date" class="position-relative row form-group">
                                         	<label for="txtReportEndDate" class="col-sm-2 col-form-label">Report End Date<span class="redtext">*</span></label>
                                            
                                            <div class="col-sm-4 date datepicker">
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
                                                    <th style="text-align:center" width="16%">LOG&nbsp;DATE</th>
                                                    <th style="text-align:center" width="17%">EMAIL/USERNAME</th> 
                                                    <th style="text-align:center" width="15%">NAME&nbsp;OF&nbsp;USER</th> 
                                                    <th style="text-align:center" width="15%">OPERATION</th>                                       		<th style="text-align:center;" width="25%">ACTIVITY</th>
                                                    <th style="text-align:center;" width="12%">USER&nbsp;IP&nbsp;ADDRESS</th>
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
