<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<title>Naija Art Market | Portfolio Report</title>
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
			
			$('#btnPDF').click(function(e) 
			{
				try
				{
					if (!CheckForm()) return false;
					
					$.blockUI({message:'<img src="<?php echo base_url();?>images/loader.gif" /><p>Generating Portfolio PDF Report. Please Wait...</p>',theme: false,baseZ: 2000});					
					
					var sym=$.trim($('#cboSymbol').val());					
					var reportfile="portfolio_in_report.pdf";					
					var msg;
										
					msg='Portfolio Report';					
					
					var mydata={broker_id:Uid,symbol:sym,ReportTitle:msg};	
																
					$.ajax({
						url: "<?php echo site_url('ui/Portfoliorep_br/CreatePDFReport'); ?>",
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
					
					var sym=$.trim($('#cboSymbol').val());
										
					DisplayReport(sym);
				}catch(e)
				{
					$.unblockUI();
					m='Display Reports Button Click ERROR:\n'+e;				
					DisplayMessage(m, 'error',Title);
				}
			});
			
			function DisplayReport(sym)
			{
				try
				{
					$.blockUI({message:'<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Portfolio Records. Please Wait...</p>',theme: false,baseZ: 2000});
						
					//Make Ajax Request
					var msg;
																			
					msg='Portfolio Report';					
					
					var mydata={broker_id:Uid,symbol:sym};	
					
					$('#recorddisplay > tbody').html('');
					
					$.ajax({
						url: "<?php echo site_url('ui/Portfoliorep_br/DisplayReport');?>",
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
								language: {zeroRecords: "No Portfolio Record Found"},
								lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
								columnDefs: [
									{
										"targets": [ 0,1,2,3,4,5,6 ],
										"visible": true
									},
									{
										"targets": [ 0,1,2,3,4,5,6 ],
										"orderable": true
									},
									{
										"targets": [ 0,1,2,3,4,5,6 ],
										"searchable": true
									},
									{ className: "dt-center", "targets": [ 0,1,2,6 ] },
									{ className: "dt-right", "targets": [ 3,4,5 ] }
								],					
								order: [[ 2, 'asc' ]],
								data: dataSet, 
								columns: [
									{ width: "11%" },//Symbol
									{ width: "23%" },//Title
									{ width: "11%" },//Tokens
									{ width: "12%" },//Price Bought
									{ width: "15%" },//Current Price
									{ width: "16%" },//Current Value
									{ width: "12%" }//Report Date
								],//11,23,11,12,15,16,12
							} );	
							
							//Compute Total
							var fee=0; 
							
							fee=table.column(5).data().sum();
							
							if (parseInt(fee) > 0) 
							{
								$('#tdValue').html(number_format (fee, 2, '.', ','));
							}else
							{
								$('#tdValue').html('');
							}					
		
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
					var em='<?php echo $email; ?>';										
				
					//User
					if (!Uid)
					{
						m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the reporting.';
						
						DisplayMessage(m, 'error',Title);
						return false;
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
						url: "<?php echo site_url('ui/Portfoliorep_br/GetSymbols');?>",
						type: 'POST',
						dataType: 'json',
						success: function(data,status,xhr) {	
							$.unblockUI();
		
							if ($(data).length > 0)
							{
								$("#cboSymbol").append(new Option("[ALL ASSETS]", ""));
								
								$.each($(data), function(i,e)
								{
									if (e.symbol && e.art_title)
									{
										$("#cboSymbol").append(new Option($.trim(e.art_title)+' (' + $.trim(e.symbol)+')', $.trim(e.symbol)));
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
                                            <a class="nsegreen-dark">Secondary Trades Report</a>
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
                       
                        <li class="makebold size-18"><a data-toggle="tab" href="#view">View Secondary Trades Report</a></li>
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
                      
                    </div>
                    
                    
                    <!--Buttons-->
                    <br><div class="position-relative row form-group">
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
                            	<th style="text-align:center" width="11%">ASSET</th>
                                <th style="text-align:center" width="23%">TITLE</th>
                                <th style="text-align:center" width="11%">TOKENS</th>
                                <th style="text-align:right; padding-right:7px;" width="12%">PRICE&nbsp;BOUGHT(₦)</th>
                                <th style="text-align:right; padding-right:7px;" width="15%">CURRENT&nbsp;PRICE(₦)</th>
                                <th style="text-align:right; padding-right:7px;" width="16%">CURRENT&nbsp;VALUE(₦)</th>                                
                                <th style="text-align:center" width="12%">REPORT&nbsp;DATE</th>
                            </tr>
                          </thead>

                          <tbody id="tbbody"></tbody>
                          
                          <tfoot style="color:#ffffff; background-color:#7E7B7B;">
                                <tr>
                                    <th colspan="5" style="text-align:right; padding:3px; padding-right:10px; font-weight:bold; font-size:13px;" width="72%">TOTAL CURRENT VALUE (₦):</th>
                                    
                                    <th id="tdValue" style="text-align:right; padding:3px; padding-right:8px; font-weight:bold; font-size:13px;" width="16%"></th>
                                    
                                   <th style="text-align:right; padding:3px; padding-right:8px; font-weight:bold; font-size:12px;" width="12%"></th>
                                </tr>
                          </tfoot>
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
