<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Derived Homes - Paystack Countries</title>
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
		  		
		LoadCountries();
		
		$('#btnRetrieve').click(function(e)
		{
			try
			{
				$('#divAlert').html('');			
				if (!CheckRetrieve()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Retrieve Countries Button Click ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		});//btnRetrieve Click Ends
		

		function CheckRetrieve()
		{
			try
			{
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the addition of payment record.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}
								
				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: '<font size="3" face="Arial">Do you want to proceed with the retrieving of Paystack countries record?</font>',
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Paystack Countries Record. Please Wait...</p>',theme: false,baseZ: 2000});
										
					//Initiate POST
					var uri = "<?php echo site_url('admin/Paystackcountries/RetrieveCountries'); ?>";
					var xhr = new XMLHttpRequest();
					var fd = new FormData();
					
					xhr.open("POST", uri, true);
					
					xhr.onreadystatechange = function() {
						if (xhr.readyState == 4 && xhr.status == 200)
						{
							// Handle response.
							$.unblockUI();
							
							var res = JSON.parse(xhr.responseText);
							
							if ($.trim(res.status).toUpperCase()=='OK')
							{
								LoadCountries();
								m='Paystack countries records have been retrieved successfully.';
								DisplayMessage(m, 'success','Countries Retrieved','SuccessTheme');																						
							}else
							{
								m=res.Message;
								DisplayMessage(m, 'error',Title);
							}
						}
					};

					xhr.send(fd);// Initiate a multipart/form-data upload
				  }
				})	
			}catch(e)
			{
				$.unblockUI();
				m='CheckRetrieve ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End CheckRetrieve
    });//Document Ready
	
	function LoadCountries()
	{
		try
		{
			$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Countries. Please Wait...</p>',theme: false,baseZ: 2000});
			
			$('#recorddisplay > tbody').html('');
			
			$.ajax({
				url: "<?php echo site_url('admin/Paystackcountries/GetCountries');?>",
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
						language: {zeroRecords: "No Country Record Found"},
						lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
						columnDefs: [
							{
								"targets": [ 0,1,2 ],
								"visible": true
							},
							{
								"targets": [ 0,1,2 ],
								"orderable": true,
								"searchable": true
							},
							{
								"targets": [ 0,1,2 ],
								"searchable": true
							},
							{ className: "dt-center", "targets": [ 0,1,2 ] }
						],					
						order: [[ 0, 'asc' ]],
						data: dataSet, 
						columns: [
							{ width: "40%" },//Name
							{ width: "30%" },//Iso Code
							{ width: "30%" }//Current Code
						]
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
			m='LoadCountries ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
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
                                                    Paystack Countries
                                                </li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    
            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <form class="">                                
                                 <div class="position-relative row form-group">
                                 	<label class="col-sm-2 col-form-label"></label>
                                    
                                 	<div class="col-sm-8">
                                        <table class="hover table table-bordered data-table display" id="recorddisplay">
                                          <thead>
                                            <tr>
                                                    <th style="text-align:center" width="40%">COUNTRY NAME</th>
                                                    <th style="text-align:center" width="30%">COUNTRY ISO CODE</th>
                                                    <th style="text-align:center" width="30%">CURRENCY CODE</th>
                                                </tr>
                                          </thead>
    
                                          <tbody id="tbbody"></tbody>
                                        </table>
                                    </div>                                     
                                 </div>
                                
                                
                                
                                <div align="center"><br>
                                    <button id="btnRetrieve" type="button" class="btn btn-primary size-16 ">Get Countries</button>                               	
                                        
                                     <button style="margin-left:10px;" onClick="window.location.reload(true);" class="btn btn-danger size-16">Refresh</button>
                                </div>
                            </form>
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
