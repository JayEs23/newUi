<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Derived Homes - Users On Blockchain</title>
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
		
		LoadBlockchainUsers('-1');			
		
		$('#cboUserType').change(function(e) {
            try
			{
				var ty = $.trim($(this).val());
				LoadBlockchainUsers(ty);
			}catch(e)
			{
				$.unblockUI();
				m='User Type Changed ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
        });
    });//Document Ready
	
	
	
	function ViewRow(uId,Em,Ph,uName,uType,badd)
	{
		try
		{
			ResetControls();
			
			$('#txtUserName').val(uName);
			$('#txtEmail').val(Em);
			$('#txtPhone').val(Ph);
			$('#txtUserType').val(uType);						
			$('#txtUserId').val(uId);
			$('#txtAddress').val(badd);
			
			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m='ViewRow ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}

	function ResetControls()
	{
		try
		{
			$('#txtUserName').val('');
			$('#txtEmail').val('');
			$('#txtPhone').val('');
			$('#txtUserType').val('');				
			$('#txtUserId').val('');
			$('#txtAddress').val('');
									
			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m="ResetControls ERROR:\n"+e;
			DisplayMessage(m,'error',Title);
		}
	}//End ResetControls
	
	function LoadBlockchainUsers(role)
	{
		try
		{			
			$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Loading Blockchain Users. Please Wait...</p>",theme: false,baseZ: 2000});
			
			$('#recorddisplay > tbody').html('');
			
			$.ajax({
				url: "<?php echo site_url('admin/Blockchainusers/GetUsers');?>",
				type: 'POST',
				data:{usertype:role},
				dataType: 'json',
				success: function(dataSet,status,xhr) {	
					console.log(dataSet);
					console.log(xhr);
					$.unblockUI();
					
					if (table) table.destroy();
					
					//f-filtering, l-length, i-information, p-pagination
					table = $('#recorddisplay').DataTable( {
						dom: '<"top"if>rt<"bottom"lp><"clear">',
						responsive: true,
						ordering: true,
						autoWidth:false,
						language: {zeroRecords: "No Blockchain User Record Found"},
						lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
						columnDefs: [
							{
								"targets": [ 0,1,2,3,4,5 ],
								"visible": true
							},
							{
								"targets": [ 0,1,2,3,4 ],
								"orderable": true,
								"searchable": true
							},
							{
								"targets": [ 5 ],
								"orderable": false,
								"searchable": false
							},
							{ className: "dt-center", "targets": [ 0,1,2,3,4,5 ] }
						],					
						order: [[ 0, 'asc' ],[ 1, 'asc' ]],
						data: dataSet, 
						columns: [
							{ width: "14%" }, //User Type
							{ width: "27%" },//User Name
							{ width: "28%" },//Email
							{ width: "13%" },//Phone
							{ width: "13%" }, //User Id
							{ width: "5" } //View
						]
					} );//15,27,27,13,13,5

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
			m='LoadBlockchainUsers ERROR:\n'+e;
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
                                                    Users On Blockchain
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
                            <a role="tab" class="nav-link active" id="tabView" data-toggle="tab" href="#view">
                                <span>Blockchain Users</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabData" data-toggle="tab" href="#data">
                                <span>User Details</span>
                            </a>
                        </li>         
                        
                        <li onClick="window.location.reload(true);" class="nav-item">
                            <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#refresh">
                                <span>Refresh</span>
                            </a>
                        </li>
                    </ul>
                    
                    
                    <div class="tab-content">
                    	 <!--Display Tab-->
                        <div class="tab-pane tabs-animation fade show active" id="view" role="tabpanel">
                        	<div class="row">
                            	<div class="col-md-12">
                                	<div class="mb-3 card">
                                        <div class="card-body">
                                            <!--User Type-->
                                             <div title="User Type" class="position-relative row form-group">
                                                <label for="cboUserType" class="col-sm-2 col-form-label nsegreen">User Type</label>
                                            
                                                <div class="col-sm-4">
                                                    <select id="cboUserType" class="form-control">
                                                    	<option value="-1">[ALL USER TYPES]</option>
                                                        <option value="-2">INVESTORS</option>
                                                        <option value="1">ADMINS</option>
                                                        <option value="2">ISSUERS</option>
                                                        <option value="3">BROKERS</option>
                                                    </select>
                                                </div>
                                             </div>
                                            
                                            <table class="hover table table-bordered data-table display wrap" id="recorddisplay">
                                              <thead>
                                                <tr>
                                                	<th style="text-align:center; " width="14%">USER&nbsp;TYPE</th> 
                                                    <th style="text-align:center" width="27%">NAME&nbsp;OF&nbsp;USER</th>
                                                    <th style="text-align:center" width="28%">EMAIL</th>
                                                    <th style="text-align:center" width="13%">PHONE</th>
                                                    <th style="text-align:center" width="13%">USER ID</th>
                                                      
                                                    <th style="text-align:center" width="5%">VIEW</th>
                                                </tr>
                                              </thead>

                                              <tbody id="tbbody"></tbody>
                                            </table>                                           
                                        </div>
                                    </div> 
                                </div>
                            </div>                            
                        </div>
                       
                       	 <!--Request Data Tab-->
                        <div class="tab-pane tabs-animation fade" id="data" role="tabpanel">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                	<form class="">
                                    	<!--Name Of User-->
                                         <div title="Name Of User" class="position-relative row form-group">
                                            <label for="txtUserName" class="col-sm-2 col-form-label nsegreen">Name Of User</label>
                                        
                                            <div class="col-sm-10">
                                                <input style="background:#F5F5F5; color:#000000; cursor:default;" readonly id="txtUserName" placeholder="Name Of User" type="text" class="form-control">
                                            </div>
                                         </div>
                                                                          
                                        <!--Email-->
                                        <div class="position-relative row form-group">
                                            <label title="User Email" for="txtEmail" class="col-sm-2 col-form-label nsegreen">Email</label>
                                        
                                            <div title="User Email" class="col-sm-10">
                                                <input style="background:#F5F5F5; color:#000000; cursor:default;" id="txtEmail" placeholder="User Email" type="text" class="form-control">
                                            </div>
                                         </div>
      
                                         <!--Phone-->
                                         <div title="User Phone Number" class="position-relative row form-group">
                                            <label for="txtPhone" class="col-sm-2 col-form-label nsegreen">Phone Number</label>
                                        
                                            <div class="col-sm-10">
                                                <input style="background:#F5F5F5; color:#000000; cursor:default;" id="txtPhone" placeholder="User Phone Number" type="text" class="form-control">
                                            </div>
                                         </div>
                                        
                                        <!--User Type-->
                                        <div title="User Type" class="position-relative row form-group">
                                            <label for="txtUserType" class="col-sm-2 col-form-label nsegreen">User Type</label>
                                            
                                            <div class="col-sm-10">
                                                    <input style="background:#F5F5F5; color:#000000; cursor:default;" type="text" id="txtUserType" placeholder="User Type" class="form-control">
                                            </div>
                                        </div>
                                        
                                         <!--User Id-->
                                        <div title="User ID" class="position-relative row form-group">
                                             <label for="txtUserId" class="col-sm-2 col-form-label nsegreen">User ID</label>
                                            
                                            <div class="col-sm-10">
                                                <input style="background:#F5F5F5; color:#000000; cursor:default;" type="text" class="form-control" placeholder="User ID" id="txtUserId">
                                            </div>
                                         </div>   
                                         
                                         <!--Blockchain Address-->
                                         <div title="User Blockchain Address" class="position-relative row form-group">
                                         	<label for="txtAddress" class="col-sm-2 col-form-label nsegreen">Blockchain Address</label>
                                            
                                            <div class="col-sm-10">
                                                <input style="background:#F5F5F5; color:#000000; cursor:default;" type="text" class="form-control" placeholder="User Blockchain Address" id="txtAddress">
                                            </div>
                                         </div> 
                                     </form>
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
