<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Derived Homes - Paystack Banks</title>
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
	
	var Title='<font color="#AF4442">Artx Exchange Message</font>';
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
		
		LoadPaystackCountries();	
		LoadPaystackBanks('');  		
				
		$('#btnRetrieve').click(function(e)
		{
			try
			{
				$('#divAlert').html('');			
				if (!CheckRetrieve()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Get Banks Button Click ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		});//btnRetrieve Click Ends
		
		$('#cboCountry').change(function(e) {
            try
			{
				$('#recorddisplay > tbody').html('');	

				var cn=$(this).val();
				
				if (cn) LoadPaystackBanks(cn); else LoadPaystackBanks('');
			}catch(e)
			{
				$.unblockUI();
				m='Country Changed ERROR:\n'+e;				

				DisplayMessage(m, 'error',Title);
			}
        });	
		
		function CheckRetrieve()
		{
			try
			{
				var cn=$.trim($('#cboCountry').val());
									
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the addition of payment record.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}
				
				//Country
				if ($('#cboCountry > option').length < 2)
				{
					m='No Paystack bank record has been retrieved. Please contact the system administrator. Meanwhile, Nigeria will be used as the default country in this retrieval process.';
					DisplayMessage(m, 'error',Title);					
					return false;
				}
				
				if (!cn)
				{
					m='Please select Paystack country where the banks are located.';
					DisplayMessage(m, 'error',Title);					
					$('#cboCountry').focus(); return false;
				}					
				
				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: '<font size="3" face="Arial">Do you want to proceed with the retrieving of Paystack banks record?</font>',
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Paystack Banks Record. Please Wait...</p>',theme: false,baseZ: 2000});
										
					//Initiate POST
					var uri = "<?php echo site_url('admin/Paystackbanks/RetrieveBanks'); ?>";
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
								LoadPaystackBanks();
								m='Paystack banks records have been retrieved successfully.';
								DisplayMessage(m, 'success','Banks Retrieved','SuccessTheme');																						
							}else
							{
								m=res.Message;
								DisplayMessage(m, 'error',Title);
							}
						}
					};

					fd.append('country', cn);
													
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
		
		function LoadPaystackBanks(cn)
		{
			try
			{
				$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Paystack Banks. Please Wait...</p>',theme: false,baseZ: 2000});
				
				$('#recorddisplay > tbody').html('');
				
				$.ajax({
					url: "<?php echo site_url('admin/Paystackbanks/GetPaystackBanks');?>",
					data:{country:cn},
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
							language: {zeroRecords: "No Paystack Banks Record Found"},
							lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
							columnDefs: [
								{
									"targets": [ 0,1,2,3,4,5,6,7 ],
									"visible": true
								},
								{
									"targets": [ 0,1,2,3,4,5,6,7 ],
									"orderable": true,
									"searchable": true
								},
								{
									"targets": [ 0,1,2,3,4,5,6,7 ],
									"searchable": true
								},
								{ className: "dt-center", "targets": [ 0,1,2,3,4,5,6,7 ] }
							],					
							order: [[ 2, 'asc' ]],
							data: dataSet, 
							columns: [
								{ width: "10%" },//Country
								{ width: "20%" },//Bank Name
								{ width: "20%" },//Slug
								{ width: "10%" },//Bank Code
								{ width: "10%" },//Long Code
								{ width: "10%" },//Gateway
								{ width: "10%" },//Active
								{ width: "10%" } //Is Deleted
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
				m='LoadPaystackBanks ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}
		
		function LoadPaystackCountries()
		{
			try
			{
				$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Paystack Countries. Please Wait...</p>',theme: false,baseZ: 2000});				
	
				$('#cboCountry').empty();				
	
				$.ajax({
					url: "<?php echo site_url('admin/Paystackbanks/GetPaystackCountries');?>",
					type: 'POST',
					dataType: 'json',
					success: function(data,status,xhr) {	
						$.unblockUI();
	
						if ($(data).length > 0)
						{
							$("#cboCountry").append(new Option("[SELECT]", ""));
							
							$.each($(data), function(i,e)
							{
								if (e.name) $("#cboCountry").append(new Option($.trim(e.name), $.trim(e.name)));
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
				m='LoadPaystackCountries ERROR:\n'+e;
				DisplayMessage(m, 'error',Title);
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
                                                    Paystack Banks
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
                                <input id="hidId" type="hidden" />
                                
                                <!--Country-->
                                <div title="Country Where Banks Located" class="position-relative row form-group">
                                    <label for="cboCountry" class="col-sm-2 col-form-label">Country<span class="redtext">*</span></label>
                                    
                                    <div class="col-sm-4">
                                        <select class="form-control" id="cboCountry"></select>
                                     </div>
                                </div>
                                
                                <div class="position-relative row form-group">
                                    <div class="col-sm-12">
                                        <table class="hover table table-bordered data-table display" id="recorddisplay">
                                      <thead>
                                        <tr>
                                                <th style="text-align:center" width="10%">COUNTRY</th>
                                                <th style="text-align:center" width="20%">BANK NAME</th>
                                                <th style="text-align:center" width="20%">SLUG</th>
                                                <th style="text-align:center" width="10%">BANK CODE</th>
                                                <th style="text-align:center" width="10%">LONG CODE</th>
                                                <th style="text-align:center" width="10%">GATEWAY</th>
                                                <th style="text-align:center" width="10%">ACTIVE</th>
                                                <th style="text-align:center" width="10%">IS DELETED</th>
                                            </tr>
                                      </thead>

                                      <tbody id="tbbody"></tbody>
                                    </table>
                                    </div>
                                </div>
                                
                                <div align="center"><br>
                                    <button id="btnRetrieve" type="button" class="btn btn-primary size-16 ">Get Banks</button>
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
