<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<title>Naija Art Market | Buy/Sell Requests Report</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	
    <style>.nav-tabs > li.active > a, .nav-tabs > li > a:hover { border: none;  color: #A8AC2E !important; background: #fff; }</style>
    
    <?php include('reportsheader.php'); ?>
    <?php include('reportscripts.php'); ?>
    
    <style>		
		table.dataTable tbody td { vertical-align: middle; }
    </style>
        
    <script>
		var Title='<font color="#AF4442">Naija Art Mart Help</font>';
		var m='';
		var table;
		var Email='<?php echo $email; ?>';
		var Uid='<?php echo $broker_id; ?>';
		var Usertype='<?php echo $usertype; ?>';
				
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
		
		$(document).ready(function(e) {
			$(function() {			
				$.blockUI.defaults.css = {};// clear out plugin default styling
			});
			
			$(document).ajaxStop($.unblockUI);
			
			LoadSymbols();
			
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

			$('#txtReportStartDate').datepicker({
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
			
			$('#txtReportEndDate').datepicker({
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
					m="Trade Start Date Blur ERROR:\n"+e;
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
					m="Trade Start Date Change ERROR:\n"+e;
					DisplayMessage(m, 'error',Title);
					return false;
				}
	
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
					m="Trade End Date Blur ERROR:\n"+e;
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
					m="Trade End Date Change ERROR:\n"+e;
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
							m="Request Start Date Is Not Valid. Please Select A Valid Request Start Date.";
							
							DisplayMessage(m, 'error',Title);
						}	
					}
					
					
					if ($('#txtReportEndDate').val())
					{
						if (!edt.isValid())
						{
							m="Request End Date Is Not Valid. Please Select A Valid Request End Date.";
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
											
						m="Request End Date Is Before Order Start Date. Please Correct Your Entries!";
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
					
					$.blockUI({message:'<img src="<?php echo base_url();?>images/loader.gif" /><p>Generating Requests PDF Report. Please Wait...</p>',theme: false,baseZ: 2000});
					
					
					var sdt=ChangeDateFrom_dMY_To_Ymd($('#txtReportStartDate').val());
					var edt=ChangeDateFrom_dMY_To_Ymd($('#txtReportEndDate').val());
					var sym=$.trim($('#cboSymbol').val());
					var mtyp=$.trim($('#cboMarketType').val());
					var ttyp=$.trim($('#cboTransactionType').val());
					var sta=$.trim($('#cboRequestStatus').val());
					var sd =moment(sdt.replace(new RegExp('-', 'g'), '/')).format("Do MMM YYYY");
					var ed =moment(edt.replace(new RegExp('-', 'g'), '/')).format("Do MMM YYYY");
					
					sd=sd.replace(new RegExp(' ', 'g'), '-');//' ','_'
					ed=ed.replace(new RegExp(' ', 'g'), '-');//' ','_'					
					
					var reportfile;
					
					if (sdt==edt)
					{
						reportfile="bsrequestsbrreport_"+sd+".pdf";
					}else
					{
						reportfile="bsrequestsbrreport_from_"+sd+'_to_'+ed+".pdf";
					}
					
					var msg;
										
					msg=' Buy/Sell Requests Report';					
					
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
					
					var mydata={broker_id:Uid,symbol:sym,market_type:mtyp,trans_type:ttyp,request_status:sta,startdate:sdt,enddate:edt,ReportTitle:msg};
																
					$.ajax({
						url: "<?php echo site_url('ui/Requestsrep_br/CreatePDFReport'); ?>",
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
							
			$('#btnDisplay').click(function(e)
			{
				try
				{
					if (!CheckForm()) return false;
					
					var sdt=ChangeDateFrom_dMY_To_Ymd($('#txtReportStartDate').val());
					var edt=ChangeDateFrom_dMY_To_Ymd($('#txtReportEndDate').val());
					var sym=$.trim($('#cboSymbol').val());					
					var mtyp=$.trim($('#cboMarketType').val());
					var ttyp=$.trim($('#cboTransactionType').val());
					var sta=$.trim($('#cboRequestStatus').val());
					
					DisplayReport(sym,mtyp,ttyp,sta,sdt,edt);
				}catch(e)
				{
					$.unblockUI();
					m='Display Reports Button Click ERROR:\n'+e;				
					DisplayMessage(m, 'error',Title);
				}
			});
			
			function DisplayReport(sym,mtyp,ttyp,sta,sdt,edt)
			{
				try
				{
					$.blockUI({message:'<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Requests Records. Please Wait...</p>',theme: false,baseZ: 2000});
						
					//Make Ajax Request
					var msg;
																			
					msg='Buy/Sell Requests Report';					
					
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
								
					var mydata={broker_id:Uid,symbol:sym,market_type:mtyp,trans_type:ttyp,request_status:sta,startdate:sdt,enddate:edt};	
					
					$('#recorddisplay > tbody').html('');
					
					$.ajax({
						url: "<?php echo site_url('ui/Requestsrep_br/DisplayReport');?>",
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
								language: {zeroRecords: "No Buy/Sell Requests Record Found"},
								lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
								columnDefs: [
									{
										"targets": [ 0,1,2,3,4,5,6,7,8,9 ],
										"visible": true
									},
									{
										"targets": [ 0,1,2,3,4,5,6,7,8,9 ],
										"orderable": true
									},
									{
										"targets": [ 0,1,2,3,4,5,6,7,8,9 ],
										"searchable": true
									},
									{ className: "dt-center", "targets": [ 0,1,2,6,7,8,9 ] },
									{ className: "dt-right", "targets": [ 3,4,5 ] }
								],					
								order: [[ 2, 'asc' ]],
								data: dataSet, 
								columns: [
									{ width: "10%" },//REQ. DATE
									{ width: "10%" },//ASSET
									{ width: "8%" },//TOKENS
									{ width: "10%" },//MAX PRICE
									{ width: "10%" },//MIN PRICE
									{ width: "10%" },//MARKET PRICE
									{ width: "10%" },//MARKET TYPE
									{ width: "9%" },//TRANS. TYPE
									{ width: "10%" },//STATUS
									{ width: "13%" }//BROKER
								],//10,10,10,10,10,10,10,9,10,11
							} );			
		
							UiActivateTab('view');
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
										
				
					//User
					if (!Uid)
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
			
        
			function LoadSymbols()
			{
				try
				{
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Symbol. Please Wait...</p>',theme: false,baseZ: 2000});				
		
					$('#cboSymbol').empty();		
		
					$.ajax({
						url: "<?php echo site_url('ui/Requestsrep_br/GetSymbols');?>",
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
		});//End document ready
		
		
		
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
                         	<div class="col-sm-6">
                                 <nav class="" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="<?php echo site_url('ui/Dashboard'); ?>">
                                                <i aria-hidden="true" class="fa fa-home"></i>
                                            </a>
                                        </li>
                                        <li class="active breadcrumb-item" aria-current="page">
                                            <a class="nsegreen-dark">Buy/Sell Requests Report</a>
                                        </li>
                                    </ol>
                                </nav>   
                            </div>  
                            
                            <div class="col-sm-6">
                            	<span style="float:right; font-style:italic;font-weight:bold; margin-right:5px;">Fields With <span class="redtext">*</span> Are Required!</span>
                            </div>                  
                         </div>                        
                    </div>
                   
					
                    <ul class="nav nav-tabs">
                       <li class="active makebold size-18"><a data-toggle="tab" href="#data">Report Parameters</a></li>
                       
                        <li class="makebold size-18"><a data-toggle="tab" href="#view">View Buy/Sell Requests Report</a></li>
                       <li title="Click to refresh page" onClick="window.location.reload(true);" class="makebold size-18"><a data-toggle="tab" href="#refresh" class="redtext">Refresh</a></li>
                   </ul>
                
                  <div class="tab-content">                                    
                    
                    <!--Trades Tab-->
                    <div id="data" class="tab-pane fade in active">
                      <!--Asset-->
                      <div title="Asset" class="position-relative row form-group">
                      		<label for="cboSymbol" class="col-sm-2 col-form-label text-right">Asset</label>
                            
                            <div class="col-sm-6">
                                <select class="form-control" id="cboSymbol"></select>
                             </div>
                      </div>
                      
                      <!--Market Type-->
                      <div title="Market Type" class="position-relative row form-group">
                      		<label for="cboMarketType" class="col-sm-2 col-form-label text-right">Market Type</label>
                            
                            <div class="col-sm-6">
                                <select class="form-control" id="cboMarketType">
                                	<option value="">[ALL MARKET TYPES]</option>
                                    <option value="Secondary">Secondary Market</option>
                                    <option value="Primary">Primary Market</option>
                                </select>
                             </div>
                      </div>
                      
                      <!--Transaction Type/Request Status-->
                      <div class="position-relative row form-group">
                        <label title="Transaction Type" for="cboTransactionType" class="col-sm-2 col-form-label text-right">Transaction Type</label>
                        
                        <div title="Transaction Type" class="col-sm-4">
                            <select class="form-control" id="cboTransactionType">
                                <option value="">[ALL TRANSACTIONS TYPES]</option>
                                <option value="Sell">Sell</option>
                                <option value="Buy">Buy</option>
                            </select>
                         </div>
                         
                         
                         <!--Request Status-->
                         <label title="Request Status" for="cboRequestStatus" class="col-sm-2 col-form-label text-right">Request Status</label>
                            
                        <div title="Request Status" class="col-sm-4">
                            <select class="form-control" id="cboRequestStatus">
                                <option value="">[ALL REQUESTS STATUS]</option>
                                <option value="Treated">Treated</option>
                                <option value="Pending">Pending</option>
                            </select> 
                         </div>
                      </div>
                      
                      
                      <!--Request Start And End Date-->                                       
                        <div class="position-relative row form-group">
                             <!--Start Date--> 
                            <label title="Request Start Date" for="txtReportStartDate" class="col-sm-2 col-form-label text-right">Request Start Date<span class="redtext">*</span></label>
                        
                            <div title="Request Start Date" class="col-sm-4 date tradedatepicker">
                                <div class="input-group">
                                    <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtReportStartDate" placeholder="Request Start Date">
                                    
                                    <span class="input-group-btn"><button class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                </div>
                             </div>
                             
                             
                             <!--Request End Date-->
                             <label title="Request End Date" for="txtReportEndDate" class="col-sm-2 col-form-label text-right">Request End Date<span class="redtext">*</span></label>
                        
                            <div title="Request End Date" class="col-sm-4 date tradedatepicker">
                                <div class="input-group">
                                    <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtReportEndDate" placeholder="Request End Date">
                                    
                                    <span class="input-group-btn"><button class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                </div>
                                
                             </div>                             
                        </div>
                    </div>
                    
                    
                    <!--Buttons-->
                    <div class="position-relative row form-group">
                         <!--Buttond-->
                         <div class="col-sm-12">
                             <div align="center">
                                <button id="btnDisplay" type="button" class="btn btn-nse-green"><span class="fa fa-play-circle size-18 makebold" ></span> Display Report</button>
            
                <button style="margin-left:10px;" id="btnPDF" type="button" class="btn btn-danger"><i class="fa fa-file-pdf size-18 makebold"></i> Export As PDF</button>
                
                <button style="margin-left:10px; color:#FFFFFF;" id="btnRefresh" type="button" class="btn btn-warning" onClick="window.location.reload(true);"><i class="fa pe-7s-refresh-2 size-18 makebold" ></i> Refresh</button>
                            </div>    
                         </div>
                    </div>
                    
                    
                    
                    <!--View-->
                    <div id="view" class="tab-pane fade">
                    	<table class="hover table table-bordered data-table display wrap" id="recorddisplay">
                          <thead>
                            <tr>
                                <th style="text-align:center" width="10%">REQ.&nbsp;DATE</th>
                                <th style="text-align:center" width="10%">ASSET</th>
                                <th style="text-align:center" width="8%">TOKENS</th>
                                <th style="text-align:right; padding-right:7px;" width="10%">MAX&nbsp;PRICE(₦)</th>
                                <th style="text-align:right; padding-right:7px;" width="10%">MIN&nbsp;PRICE(₦)</th>
                                <th style="text-align:right; padding-right:7px;" width="10%">MARKET&nbsp;PRICE(₦)</th>
                                <th style="text-align:center" width="10%">MARKET&nbsp;TYPE</th>
                                <th style="text-align:center" width="9%">TRANS.&nbsp;TYPE</th>
                                <th style="text-align:center" width="10%">STATUS</th>
                                <th style="text-align:center" width="13%">INVESTOR</th>
                            </tr>
                          </thead>
                          <tbody id="tbbody"></tbody>
                          
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

</body>

</html>
