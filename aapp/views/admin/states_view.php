<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Derived Homes - States In Nigeria</title>
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
	
	var Title='<font color="#AF4442">States Message</font>';
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
		
		document.getElementById('btnEdit').disabled=true;
		document.getElementById('btnAdd').disabled=false;	
				  		
		LoadStates();
		
		$('#btnAdd').click(function(e)
		{
			try
			{
				$('#divAlert').html('');			
				if (!CheckAdd()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Add State Button Click ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		});//btnAdd Click Ends
		
		$('#btnEdit').click(function(e) {
			try
			{					
				$('#divAlert').html('');
				
				if (!CheckEdit()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Edit State Button Click ERROR:\n'+e;					
				DisplayMessage(m, 'error',Title);
			}
		});//btnEdit Click Ends
		
		function CheckEdit()
		{
			try
			{
				var st=$.trim($('#txtState').val());
				var id=$.trim($('#hidId').val());
									
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the payment update.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}
				
				//State
				if (!st)
				{
					m='State field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtState').focus(); return false;
				}
				
				if ($.isNumeric(st))
				{
					m='State field must not be a number.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtState').focus(); return false;
				}
				
				if (st.length<3)
				{
					m='Please enter a meaningful state name.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtState').focus(); return false;
				}
				
				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: '<font size="3" face="Arial">Do you want to proceed with the editing of the state record?</font>',
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Editing State Record. Please Wait...</p>',theme: false,baseZ: 2000});
															
					//Initiate POST
					var uri = "<?php echo site_url('admin/States/EditState'); ?>";
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
							m='State record has been edited successfully.';
							DisplayMessage(m, 'success','State Edited','SuccessTheme');
							
							ResetControls();
							LoadStates();																					
						}else
						{
							m=res.Message;								
							DisplayMessage(m, 'error',Title);
						}
					}
				};
				
					fd.append('state', st);
					fd.append('id', id);
																				
					xhr.send(fd);// Initiate a multipart/form-data upload
				  }
				})	
			}catch(e)
			{
				$.unblockUI();
				m='CheckEdit ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End CheckEdit
		
		function CheckAdd()
		{
			try
			{
				var st=$.trim($('#txtState').val());
									
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the addition of payment record.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}
								
				//State
				if (!st)
				{
					m='State field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtState').focus(); return false;
				}
				
				if ($.isNumeric(st))
				{
					m='State field must not be a number.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtState').focus(); return false;
				}
				
				if (st.length<3)
				{
					m='Please enter a meaningful state name.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtState').focus(); return false;
				}
						
				
				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: '<font size="3" face="Arial">Do you want to proceed with the addition of the state record?</font>',
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Adding State Record. Please Wait...</p>',theme: false,baseZ: 2000});
										
					//Initiate POST
					var uri = "<?php echo site_url('admin/States/AddState'); ?>";
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
							m='State record has been added successfully.';
							DisplayMessage(m, 'success','State Added','SuccessTheme');
							
							ResetControls();
							LoadStates();																							
						}else
						{
							m=res.Message;
							DisplayMessage(m, 'error',Title);
						}
					}
				};

					fd.append('state', st);
													
					xhr.send(fd);// Initiate a multipart/form-data upload
				  }
				})	
			}catch(e)
			{
				$.unblockUI();
				m='CheckAdd ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End CheckAdd
		
		
    });//Document Ready
	
	function LoadStates()
	{
		try
		{
			$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading States. Please Wait...</p>',theme: false,baseZ: 2000});
			
			$('#recorddisplay > tbody').html('');
			
			$.ajax({
				url: "<?php echo site_url('admin/States/GetStates');?>",
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
						language: {zeroRecords: "No State Record Found"},
						lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
						columnDefs: [
							{
								"targets": [ 0,1,2 ],
								"visible": true
							},
							{
								"targets": [ 0,1 ],
								"orderable": false,
								"searchable": false
							},
							{
								"targets": [ 2 ],
								"searchable": true
							},
							{ className: "dt-center", "targets": [ 0,1,2 ] }
						],					
						order: [[ 2, 'asc' ]],
						data: dataSet, 
						columns: [
							{ width: "15%" },//Select
							{ width: "15%" },//Delete
							{ width: "70%" } //State
						]
					} );	

					//AdminActivateTab('view');		
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
			m='LoadStates ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}

	function SelectRow(st,id)
	{
		try
		{
			if (document.getElementById('btnEdit')) document.getElementById('btnEdit').disabled=false;
			if (document.getElementById('btnAdd')) document.getElementById('btnAdd').disabled=true;

			$('#txtState').val(st);
			$('#hidId').val(id);

			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m='SelectRow ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}
	
	function DeleteRow(st,id)
	{			
		try
		{
			if (!Email)
			{
				m='There is a problem with the selected row. Click on REFRESH button to refresh the page. If this message keeps coming up, please contact us at support@naijaartmart.com.';
				
				DisplayMessage(m,'error',Title);
				return false;
			}else
			{
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: '<font size="3" face="Arial">Do you want to delete this state record from the database?. Please note that this action is irreversible.</font>',
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Delete!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Deleting State Record. Please Wait...</p>',theme: false,baseZ: 2000});
					
					$('#divAlert').html('');
					
					m=''
					
					//Make Ajax Request			
					$.ajax({
						url: '<?php echo site_url('admin/States/DeleteState'); ?>',
						data: {state:st,id:id},
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
										ResetControls();									
										LoadStates();
										
										m='State was deleted successfully.';
										
										DisplayMessage(m, 'success','State Deleted','SuccessTheme');
								
										if (parseInt(e.rowcount) > 0)
										{
											activateTab('view');
										}else
										{
											activateTab('data');
										}
									}else
									{
										m=e.Message;
										
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
			}
		}catch(e)
		{
			$.unblockUI();
			m='Delete State Button Click ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}
	
	function ResetControls()
	{
		try
		{					
			if (document.getElementById('btnEdit')) document.getElementById('btnEdit').disabled=true;
			if (document.getElementById('btnAdd')) document.getElementById('btnAdd').disabled=false;
			
			$('#txtState').val('');
			$('#hidId').val('');
			
			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m="ResetControls ERROR:\n"+e;
			DisplayMessage(m,'error',Title);
		}
	}//End ResetControls
	
		
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
                                                    States In Nigeria
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
                                <span>State Data</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabView" data-toggle="tab" href="#view">
                                <span>View States</span>
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
                                    	<input id="hidId" type="hidden" />
                                        
                                        <!--State-->
                                        <div title="State In Nigeria" class="position-relative row form-group">
                                        	<label for="txtState" class="col-sm-2 col-form-label">State<span class="redtext">*</span></label>
                                            
                                            <div class="col-sm-9">
                                            	<input style="text-transform:capitalize;" class="form-control" id="txtState" placeholder="State In Nigeria">
                                             </div>
                                        </div>
                                        
                                        <div align="center"><br>
                                        	<button id="btnAdd" type="button" class="btn btn-primary size-16 ">Add State</button>
                                            <button style="margin-left:10px;" id="btnEdit" type="button" class="btn btn-info size-16">Edit State</button>                                	
                                                
                                             <button style="margin-left:10px;" onClick="window.location.reload(true);" class="btn btn-danger size-16">Refresh</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane tabs-animation fade" id="view" role="tabpanel">
                        	<div class="row">
                            	<div class="col-md-12">
                                	<div class="mb-3 card">
                                        <div class="card-body">
                                            <table class="hover table table-bordered data-table display" id="recorddisplay">
                                              <thead>
                                                <tr>
                                                        <th style="text-align:center" width="15%">SELECT</th>
                                                        <th style="text-align:center" width="15%">DELETE</th>
                                                        <th style="text-align:center" width="70%">STATE</th>
                                                    </tr>
                                              </thead>
        
                                              <tbody id="tbbody"></tbody>
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
