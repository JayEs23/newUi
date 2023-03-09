<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Derived Homes - Order Types</title>
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
	
	var Title='<font color="#AF4442">Order Types Message</font>';
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
				  		
		LoadOrderTypes();
		
		$('#btnAdd').click(function(e)
		{
			try
			{
				$('#divAlert').html('');			
				if (!CheckAdd()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Add Order Type Button Click ERROR:\n'+e;				
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
				m='Edit Order Types Button Click ERROR:\n'+e;					
				DisplayMessage(m, 'error',Title);
			}
		});//btnEdit Click Ends
		
		function CheckEdit()
		{
			try
			{
				var cd=$.trim($('#txtCode').val()).toUpperCase();
				var des=$.trim($('#txtDescription').val());
				var sta=$.trim($('#cboStatus').val());
				var id=$.trim($('#hidId').val());
									
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the order type update.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}
				
				//Order Type Description
				if (!des)
				{
					m='Order type description field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtDescription').focus(); return false;
				}
				
				if ($.isNumeric(des))
				{
					m='Order type description field must not be a number.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtDescription').focus(); return false;
				}
				
				if (des.length<3)
				{
					m='Please enter a meaningful order type description.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtDescription').focus(); return false;
				}
				
				//Order Type Code
				if (!cd)
				{
					m='Order type code field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtCode').focus(); return false;
				}
				
				if ($.isNumeric(cd))
				{
					m='Order type code field must not be a number.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtCode').focus(); return false;
				}
				
				if (cd.length<2)
				{
					m='Please enter a meaningful order type code.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtCode').focus(); return false;
				}
				
				//Status
				if (!sta)
				{
					m='Please select order type status. This indicates whether the order type will be active in trading (activate) or not (disabled).';
					DisplayMessage(m, 'error',Title);					
					$('#cboStatus').focus(); return false;
				}
				
				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: '<font size="3" face="Arial">Do you want to proceed with the editing of the order type record?</font>',
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Editing Order Type Record. Please Wait...</p>',theme: false,baseZ: 2000});
															
					//Initiate POST
					var uri = "<?php echo site_url('admin/Ordertypes/EditOrdertype'); ?>";
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
							m='Order type record has been edited successfully.';
							DisplayMessage(m, 'success','Order Type Edited','SuccessTheme');
							
							ResetControls();
							LoadOrderTypes();																					
						}else
						{
							m=res.Message;								
							DisplayMessage(m, 'error',Title);
						}
					}
				};
				
					fd.append('ordertype', cd);
					fd.append('description', des);
					fd.append('status', sta);
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
				var cd=$.trim($('#txtCode').val()).toUpperCase();
				var des=$.trim($('#txtDescription').val());
				var sta=$.trim($('#cboStatus').val());
									
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the addition of order type record.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}
								
				//Order Type Description
				if (!des)
				{
					m='Order type description field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtDescription').focus(); return false;
				}
				
				if ($.isNumeric(des))
				{
					m='Order type description field must not be a number.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtDescription').focus(); return false;
				}
				
				if (des.length<3)
				{
					m='Please enter a meaningful order type description.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtDescription').focus(); return false;
				}
				
				//Order Type Code
				if (!cd)
				{
					m='Order type code field must not be blank.';
					DisplayMessage(m, 'error',Title);					
					$('#txtCode').focus(); return false;
				}
				
				if ($.isNumeric(cd))
				{
					m='Order type code field must not be a number.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtCode').focus(); return false;
				}
				
				if (cd.length<2)
				{
					m='Please enter a meaningful order type code.';					
					DisplayMessage(m, 'error',Title);					
					$('#txtCode').focus(); return false;
				}
				
				//Status
				if (!sta)
				{
					m='Please select order type status. This indicates whether the order type will be active in trading (activate) or not (disabled).';
					DisplayMessage(m, 'error',Title);					
					$('#cboStatus').focus(); return false;
				}
						
				
				//Confirm Update				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: '<font size="3" face="Arial">Do you want to proceed with the addition of the order type record?</font>',
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Adding Order Type Record. Please Wait...</p>',theme: false,baseZ: 2000});
										
					//Initiate POST
					var uri = "<?php echo site_url('admin/Ordertypes/AddOrdertype'); ?>";
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
							m='Order type record has been added successfully.';
							DisplayMessage(m, 'success','Order Type Added','SuccessTheme');
							
							ResetControls();
							LoadOrderTypes();																							
						}else
						{
							m=res.Message;
							DisplayMessage(m, 'error',Title);
						}
					}
				};

					fd.append('ordertype', cd);
					fd.append('description', des);
					fd.append('status', sta);
																				
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
	
	function LoadOrderTypes()
	{
		try
		{
			$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Order Types. Please Wait...</p>',theme: false,baseZ: 2000});
			
			$('#recorddisplay > tbody').html('');
			
			$.ajax({
				url: "<?php echo site_url('admin/Ordertypes/GetOrdertypes');?>",
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
						language: {zeroRecords: "No Order Type Record Found"},
						lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
						columnDefs: [
							{
								"targets": [ 0,1,2,3,4 ],
								"visible": true
							},
							{
								"targets": [ 0,1 ],
								"orderable": false,
								"searchable": false
							},
							{
								"targets": [ 2,3,4 ],
								"searchable": true
							},
							{ className: "dt-center", "targets": [ 0,1,2,3,4 ] }
						],					
						order: [[ 2, 'asc' ]],
						data: dataSet, 
						columns: [
							{ width: "10%" },//Select
							{ width: "10%" },//Delete
							{ width: "20%" },//Code
							{ width: "45%" }, //Description
							{ width: "15%" } //Status
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
			m='LoadOrderTypes ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}

	function SelectRow(cd,des,sta,id)
	{
		try
		{
			if (document.getElementById('btnEdit')) document.getElementById('btnEdit').disabled=false;
			if (document.getElementById('btnAdd')) document.getElementById('btnAdd').disabled=true;

			$('#txtCode').val(cd);
			$('#txtDescription').val(des);
			$('#cboStatus').val(sta);
			$('#hidId').val(id);

			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m='SelectRow ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}
	
	function DeleteRow(cd,des,sta,id)
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
				  html: '<font size="3" face="Arial">Do you want to delete this order type record from the database?. Please note that this action is irreversible.</font>',
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Delete!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Deleting Order Type Record. Please Wait...</p>',theme: false,baseZ: 2000});
					
					$('#divAlert').html('');
					
					m=''
					
					//Make Ajax Request			
					$.ajax({
						url: '<?php echo site_url('admin/Ordertypes/DeleteOrderType'); ?>',
						data: {ordertype:cd,description:des,id:id},
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
										LoadOrderTypes();
										
										m='Order type was deleted successfully.';
										
										DisplayMessage(m, 'success','Order Type Deleted','SuccessTheme');
								
										if (parseInt(e.rowcount) > 0)
										{
											AdminActivateTab('view');
										}else
										{
											AdminActivateTab('data');
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
			m='Delete Order Type Button Click ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}
	
	function ResetControls()
	{
		try
		{					
			if (document.getElementById('btnEdit')) document.getElementById('btnEdit').disabled=true;
			if (document.getElementById('btnAdd')) document.getElementById('btnAdd').disabled=false;
			
			$('#txtCode').val('');		
			$('#txtDescription').val('');
			$('#cboStatus').val('');
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
                                                    Order Types
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
                                <span>Order Type Data</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabView" data-toggle="tab" href="#view">
                                <span>View Order Types</span>
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
                                        
                                        <!--Order Type Description-->
                                        <div title="Order Type Description" class="position-relative row form-group">
                                        	<label for="txtDescription" class="col-sm-2 col-form-label">Order Type Description<span class="redtext">*</span></label>
                                            
                                            <div class="col-sm-9">
                                            	<input style="text-transform:capitalize;" class="form-control" id="txtDescription" placeholder="Order Type Description">
                                             </div>
                                        </div>
                                        
                                                                                
                                        <!--Order Type Code-->
                                        <div title="Order Type Code" class="position-relative row form-group">
                                        	<label for="txtCode" class="col-sm-2 col-form-label">Order Type Code<span class="redtext">*</span></label>
                                             
                                             <div class="col-sm-9">
                                             	<input style="text-transform:uppercase;" id="txtCode" placeholder="Order Type Code" type="text" class="form-control">
                                             </div>
                                        </div>
                                        
                                        <!--Order Type Status-->
                                        <div title="Order Type Status" class="position-relative row form-group">
                                        	<label for="cboStatus" class="col-sm-2 col-form-label">Order Type Status<span class="redtext">*</span></label>
                                             
                                             <div class="col-sm-9">
                                             	<select id="cboStatus" class="form-control">
                                                    <option value="">[SELECT]</option>
                                                    <option value="1">Activate</option>
                                                    <option value="0">Disable</option>
                                                  </select>
                                             </div>
                                        </div>
                                        
                                        
                                        <div align="center"><br>
                                        	<button id="btnAdd" type="button" class="btn btn-primary size-16 ">Add Order Type</button>
                                            <button style="margin-left:10px;" id="btnEdit" type="button" class="btn btn-info size-16">Edit Order Type</button>                                	
                                                
                                             <button type="button" style="margin-left:10px;" onClick="window.location.reload(true);" class="btn btn-danger size-16">Refresh</button>
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
                                                        <th style="text-align:center" width="10%">SELECT</th>
                                                        <th style="text-align:center" width="10%">DELETE</th>
                                                        <th style="text-align:center" width="20%">ORDER TYPE CODE</th>
                                                        <th style="text-align:center" width="45%">ORDER TYPE DESCRIPTION</th>
                                                         <th style="text-align:center" width="15%">ORDER TYPE STATUS</th>
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
