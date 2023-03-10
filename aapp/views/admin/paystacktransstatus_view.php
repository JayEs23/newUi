<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Derived Homes - Paystack Transaction Status</title>
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
		
		$('#frmChargeSuccess').hide();
		$('#frmTransferFailed').hide();
		$('#frmTransferReversed').hide();
		$('#frmTransferSuccess').hide();
		$('#btnRefresh').hide();
		
		$('#cboType').change(function(e)
		{
			try
			{
				$('#frmChargeSuccess').hide();
				$('#frmTransferFailed').hide();
				$('#frmTransferReversed').hide();
				$('#frmTransferSuccess').hide();
				$('#btnRefresh').hide();
				
				$('#recorddisplay > tbody').html('');
				
				var ev=$.trim($(this).val());
				
				if (ev)
				{
					$('#btnRefresh').show();
					
					if (ev.toLowerCase() == 'charge.success') $('#frmChargeSuccess').show();
					if (ev.toLowerCase() == 'transfer.failed') $('#frmTransferFailed').show();
					if (ev.toLowerCase() == 'transfer.reversed') $('#frmTransferReversed').show();
					if (ev.toLowerCase() == 'transfer.success') $('#frmTransferSuccess').show();
					
					LoadEvents(ev);
				}
			}catch(e)
			{
				$.unblockUI();
				m='Make Payment Button Click ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		});//cboType Change Ends
		
		function LoadEvents(ev)
		{
			try
			{			
				$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Loading Trades List. Please Wait...</p>",theme: false,baseZ: 2000});
				
				$('#recorddisplay > tbody').html('');
				
				$.ajax({
					url: "<?php echo site_url('admin/Paystacktransstatus/GetTransactionStatus');?>",
					type: 'POST',
					data:{event:ev},
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
							language: {zeroRecords: "No Paystack Transaction Record Found"},
							lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
							columnDefs: [
								{
									"targets": [ 0,1,2,3,4,5,6,7 ],
									"visible": true
								},
								{
									"targets": [ 0,1,2,3,4,5,6 ],
									"orderable": true,
									"searchable": true
								},
								{
									"targets": [ 7 ],
									"orderable": false,
									"searchable": false
								},
								{ className: "dt-center", "targets": [ 0,1,2,4,5,6,7 ] },
								{ className: "dt-right", "targets": [ 3 ] }
							],					
							order: [[ 7, 'asc' ]],
							data: dataSet, 
							columns: [
								{ width: "14%" },//Date
								{ width: "13%" },//Event
								{ width: "15%" },//Reference
								{ width: "15%" }, //Amount
								{ width: "13%" }, //Domain
								{ width: "15%" }, //Paystack Ip Address
								{ width: "10%" }, //Status
								{ width: "5" } //Select
							]
						} );
						
						var total=0; 
						
						total=table.column(3).data().sum();
													
						if (parseFloat(total) > 0)
						{
							$('#tdAmount').html('₦'+number_format (total, 2, '.', ','));
						}else
						{
							$('#tdAmount').html('');
						}
	
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
				m='LoadEvents ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}
		
    });//Document Ready
	
	function ViewRow(event,domain,status,reference,amount,message,gateway_response,paid_at,channel,currency,user_ip_address,paystack_ip_address,fees,bin,last4,card_type,bank,country_code,brand,customer_email,reason,transfer_code,transferred_at,recipient_code,recipient_email,recipient_name,account_name,account_number,bank_code,bank_name,provider,session_id,failures,created_at,updated_at)
	{
		try
		{
			ResetChargeControls();
			ResetTransferSuccess();
			ResetTransferFailed();
			ResetTransferReversed();
			
			$('#frmChargeSuccess').hide();
			$('#frmTransferFailed').hide();
			$('#frmTransferReversed').hide();
			$('#frmTransferSuccess').hide();
			
			if (event.toLowerCase() == 'charge.success')
			{
				$('#frmChargeSuccess').show();
				
				$('#lblChargeEvent').html(event);//Event/Domain
				$('#lblChargeDomain').html(domain);                                            
												 
				$('#lblChargeReference').html(reference);//Payment Reference/Payment Status
				$('#lblChargeStatus').html(status);                                               
																				
				$('#lblChargeAmount').html(number_format(amount,2,'.',','));//Transaction Amount/Channel
				$('#lblChargeChannel').html(channel);                               
																						 
				$('#lblChargeFees').html(number_format(fees,2,'.',','));//Transaction Fees/Payment Date
				$('#lblChargePaymentDate').html(paid_at);
											
				$('#lblChargeGatewayResponse').html(gateway_response);//Gateway Response/Message
				$('#divChargeMessage').html(message);
												 
				$('#lblChargeCustomerEmail').html(customer_email);//Customer Email/User IP Address
				$('#lblChargeUserIP').html(user_ip_address);
											
				$('#lblChargeCardType').html(card_type);//Card Type/Card Bin
				$('#lblChargeCardBin').html(bin);                               
												
				$('#lblChargeLast4Digit').html(last4);//Card Last 4 Digits/Card Brand
				$('#lblChargeCardBrand').html(brand);
																							
				$('#lblChargeBank').html(bank);//Bank/Country Code
				$('#lblChargeCountryCode').html(country_code);
																						   
				$('#lblChargeDateCreated').html(created_at);//Created At/Paystack IP Address
				$('#lblChargePaystackIPAddress').html(paystack_ip_address);
			}
			
			if (event.toLowerCase() == 'transfer.failed')
			{
				$('#frmTransferFailed').show();
			
				$('#lblTransferFailedEvent').html(event);//Event/Domain
				$('#lblTransferFailedDomain').html(domain);
													
				$('#lblTransferFailedRecipientCode').html(recipient_code);//Recipient Code/Payment Status
				$('#lblTransferFailedStatus').html(status);                                            
												   
				$('#lblTransferFailedAmount').html(number_format(amount,2,'.',','));//Amount/Transfer Code
				$('#lblTransferFailedTransferCode').html(transfer_code);
											 
				$('#divTransferFailedReason').html(reason);//Reason/Transfer Date
				$('#lblTransferFailedTransferDate').html(transferred_at);
	
				$('#lblTransferFailedAccountName').html(account_name);//Account Name/Account Number
				$('#lblTransferFailedAccountNo').html(account_number);                                
	
				$('#lblTransferFailedBankName').html(bank_name);//Bank Name/Bank Code
				$('#lblTransferFailedBankCode').html(bank_code);                                     
	
				$('#lblTransferFailedDateCreated').html(created_at);//Date Created/Paystack IP Address
				$('#lblTransferFailedPaystackIPAddress').html(paystack_ip_address);
			}
			
			if (event.toLowerCase() == 'transfer.reversed')
			{
				$('#frmTransferReversed').show();
			
				$('#lblTransferReversedEvent').html(event);//Event/Domain
				$('#lblTransferReversedDomain').html(domain);                                             
										
				$('#lblTransferReversedReference').html(reference);//Payment Reference/Payment Status
				$('#lblTransferReversedStatus').html(status);                                 
	
				$('#lblTransferReversedAmount').html(number_format(amount,2,'.',','));//Amount/Recipient Code
				$('#lblTransferReversedRecipientCode').html(recipient_code);											 
				$('#divTransferReversedReason').html(reason);//Reason/Transfer Code
				$('#lblTransferReversedTransferCode').html(transfer_code);                                        
				$('#lblTransferReversedAccountName').html(account_name);//Account Name/Account Number
				$('#lblTransferReversedAccountNo').html(account_number);
				
				$('#lblTransferReversedBankName').html(bank_name);//Bank Name/Bank Code
				$('#lblTransferReversedBankCode').html(bank_code);
	
				$('#lblTransferReversedSessionProvider').html(provider);//Session Provider/Session Id
				$('#lblTransferReversedSessionId').html(session_id);
	
				$('#lblTransferReversedTransferDate').html(transferred_at);//Transfer Date/Paystack IP
				$('#lblTransferReversedPaystackIPAddress').html(paystack_ip_address);
				
				$('#lblTransferReversedDateCreated').html(created_at);//Date Created/Date Updated
				$('#lblTransferReversedDateUpdated').html(updated_at);
	
				$('#lblTransferReversedFailures').html(failures);//Failures
			}
			
			if (event.toLowerCase() == 'transfer.success')
			{
				$('#frmTransferSuccess').show();
				
				$('#lblTransferSuccessEvent').html(event);//Event/Domain
				$('#lblTransferSuccessDomain').html(domain);                                             
				
				$('#lblTransferSuccessReference').html(reference);//Payment Reference/Payment Status
				$('#lblTransferSuccessStatus').html(status);
														 
				$('#lblTransferSuccessAmount').html(number_format(amount,2,'.',','));//Amount/Recipient Code
				$('#lblTransferSuccessRecipientCode').html(recipient_code);
											 
				$('#divTransferSuccessReason').html(reason);//Reason/Transfer Code
				$('#lblTransferSuccessTransferCode').html(transfer_code);
												
				$('#lblTransferSuccessAccountNo').html(account_number);//Account Number/Bank Name
				$('#lblTransferSuccessBankName').html(bank_name);
											
				$('#lblTransferSuccessBankCode').html(bank_code);//Bank Code/Paystack IP Address
				$('#lblTransferSuccessPaystackIPAddress').html(paystack_ip_address);
												
				$('#lblTransferSuccessDateCreated').html(created_at);//Date Created/Dated Updated
				$('#lblTransferSuccessDatedUpdated').html(updated_at);
			}

			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m='ViewRow ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}
	
	function ResetChargeControls()
	{
		try
		{			
			$('#lblChargeEvent').html('');//Event/Domain
   			$('#lblChargeDomain').html('');                                            
                                             
       		$('#lblChargeReference').html('');//Payment Reference/Payment Status
			$('#lblChargeStatus').html('');                                               
                                                                            
			$('#lblChargeAmount').html('');//Transaction Amount/Channel
			$('#lblChargeChannel').html('');                               
                                                                                     
			$('#lblChargeFees').html('');//Transaction Fees/Payment Date
            $('#lblChargePaymentDate').html('');
                                        
			$('#lblChargeGatewayResponse').html('');//Gateway Response/Message
            $('#divChargeMessage').html('');
                                             
			$('#lblChargeCustomerEmail').html('');//Customer Email/User IP Address
            $('#lblChargeUserIP').html('');
                                        
			$('#lblChargeCardType').html('');//Card Type/Card Bin
            $('#lblChargeCardBin').html('');                               
                                            
			$('#lblChargeLast4Digit').html('');//Card Last 4 Digits/Card Brand
            $('#lblChargeCardBrand').html('');
                                                                                        
			$('#lblChargeBank').html('');//Bank/Country Code
            $('#lblChargeCountryCode').html('');
                                                                                       
			$('#lblChargeDateCreated').html('');//Created At/Paystack IP Address
            $('#lblChargePaystackIPAddress').html('');

			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m="ResetChargeControls ERROR:\n"+e;
			DisplayMessage(m,'error',Title);
		}
	}//End ResetChargeControls
	
	function ResetTransferSuccess()
	{
		try
		{
			$('#lblTransferSuccessEvent').html('');//Event/Domain
            $('#lblTransferSuccessDomain').html('');                                             
			
			$('#lblTransferSuccessReference').html('');//Payment Reference/Payment Status
            $('#lblTransferSuccessStatus').html('');
                                                     
			$('#lblTransferSuccessAmount').html('');//Transaction Amount/Recipient Code
            $('#lblTransferSuccessRecipientCode').html('');
                                         
			$('#divTransferSuccessReason').html('');//Reason/Transfer Code
            $('#lblTransferSuccessTransferCode').html('');
                                         	
			$('#lblTransferSuccessAccountNo').html('');//Account Number/Bank Name
            $('#lblTransferSuccessBankName').html('');                                            
                                        
			$('#lblTransferSuccessBankCode').html('');//Bank Code/Paystack IP Address
            $('#lblTransferSuccessPaystackIPAddress').html('');
                                          	
			$('#lblTransferSuccessDateCreated').html('');//Date Created/Dated Updated
            $('#lblTransferSuccessDatedUpdated').html('');
                                             						
			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m="ResetTransferSuccess ERROR:\n"+e;
			DisplayMessage(m,'error',Title);
		}
	}//End ResetTransferSuccess
	
	function ResetTransferFailed()
	{
		try
		{
			$('#lblTransferFailedEvent').html('');//Event/Domain
            $('#lblTransferFailedDomain').html('');
                                                
			$('#lblTransferFailedRecipientCode').html('');//Recipient Code/Payment Status
            $('#lblTransferFailedStatus').html('');                                            
                                               
			$('#lblTransferFailedAmount').html('');//Transaction Amount/Transfer Code
            $('#lblTransferFailedTransferCode').html('');
                                         
			$('#divTransferFailedReason').html('');//Reason/Transfer Date
            $('#lblTransferFailedTransferDate').html('');

			$('#lblTransferFailedAccountName').html('');//Account Name/Account Number
            $('#lblTransferFailedAccountNo').html('');                                

			$('#lblTransferFailedBankName').html('');//Bank Name/Bank Code
            $('#lblTransferFailedBankCode').html('');                                     

			$('#lblTransferFailedDateCreated').html('');//Date Created/Paystack IP Address
            $('#lblTransferFailedPaystackIPAddress').html('');
            						
			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m="ResetTransferFailed ERROR:\n"+e;
			DisplayMessage(m,'error',Title);
		}
	}//End ResetTransferFailed
	
	function ResetTransferReversed()
	{
		try
		{
			$('#lblTransferReversedEvent').html('');//Event/Domain
            $('#lblTransferReversedDomain').html('');                                             
                                    
			$('#lblTransferReversedReference').html('');//Payment Reference/Payment Status
            $('#lblTransferReversedStatus').html('');                                 

			$('#lblTransferReversedAmount').html('');//Transaction Amount/Recipient Code
            $('#lblTransferReversedRecipientCode').html('');											 
             
			$('#divTransferReversedReason').html('');//Reason For Transfer/Transfer Code
            $('#lblTransferReversedTransferCode').html('');                                        

			$('#lblTransferReversedAccountName').html('');//Account Name/Account Number
            $('#lblTransferReversedAccountNo').html('');                                             

			$('#lblTransferReversedBankName').html('');//Bank Name/Bank Code
            $('#lblTransferReversedBankCode').html('');                                            

			$('#lblTransferReversedSessionProvider').html('');//Session Provider/Session Id
            $('#lblTransferReversedSessionId').html('');                                        

			$('#lblTransferReversedTransferDate').html('');//Transfer Date/Paystack IP Address
            $('#lblTransferReversedPaystackIPAddress').html('');
            
			$('#lblTransferReversedDateCreated').html('');//Date Created/Date Updated
            $('#lblTransferReversedDateUpdated').html('');                                              

			$('#lblTransferReversedFailures').html('');//Failures
						
			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m="ResetTransferReversed ERROR:\n"+e;
			DisplayMessage(m,'error',Title);
		}
	}//End ResetTransferReversed
	
	
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
                                                    Paystack Transactions Status
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
                                <span>Paystack Transactions</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabData" data-toggle="tab" href="#data">
                                <span>Transaction Details</span>
                            </a>
                        </li>                       
                        
                        <li onClick="window.location.reload(true);" class="nav-item">
                            <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#refresh">
                                <span>Refresh</span>
                            </a>
                        </li>
                    </ul>
                    
                    
                    <div class="tab-content">
                    	 <!--List Tab-->
                        <div class="tab-pane tabs-animation fade show active" id="view" role="tabpanel">
                        	<div class="row">
                            	<div class="col-md-12">
                                	<div class="mb-3 card">
                                        <div class="card-body">
                                            <!--Transaction Type-->
                                            <div title="Transaction Type" class="position-relative row form-group">
                                                <!--Status--> 
                                                <label for="cboType" class="col-sm-2 col-form-label">Transaction Type</label>
                                                 
                                                 <div class="col-sm-4">
                                                    <select id="cboType" class="form-control">
                                                        <option value="">[SELECT]</option>
                                                        <option value="charge.success">Wallet Topup</option>
                                                        <option value="transfer.success">Successful Transfers</option>
                                                        <option value="transfer.failed">Failed Transfers</option>
                                                        <option value="transfer.reversed">Reversed Transfers</option>
                                                      </select>
                                                 </div>
                                            </div>
                                            
                                            <table class="hover table table-bordered data-table display wrap" id="recorddisplay">
                                              <thead>
                                                <tr>
                                                    <th style="text-align:center" width="14%">DATE</th>
                                                    <th style="text-align:center" width="13%">EVENT</th>
                                                    <th style="text-align:center" width="15%">REFERENCE</th>
                                                    <th style="text-align:right;padding-right:8px;" width="15%">AMOUNT&nbsp;(&#8358;)</th>
                                                    <th style="text-align:center" width="13%">DOMAIN</th>
                                                    <th style="text-align:center" width="15%">PAYSTACK&nbsp;IP</th>
                                                    <th style="text-align:center" width="10%">STATUS</th>
                                                    <th style="text-align:center" width="5%">VIEW</th>
                                                </tr>
                                            </thead>              
				
                                              <tbody id="tbbody"></tbody>
                                              
                                              <tfoot style="color:#ffffff; background-color:#7E7B7B;">
                                                    <tr>
                                                        <th colspan="3" style="text-align:right; padding:3px; padding-right:10px; font-weight:bold; font-size:13px;" width="42%">TOTAL AMOUNT:</th>
                                                        
                                                        <th id="tdAmount" style="text-align:right;padding-right:8px; font-weight:bold; font-size:14px;" width="15%"></th>
                                                        
                                                        <th colspan="4" style="text-align:left; padding-right:8px; font-weight:bold; font-size:14px;" width="43%"></th>
                                                    </tr>
                                              </tfoot>
                                            </table>                                           
                                        </div>
                                    </div> 
                                </div>
                            </div>                            
                        </div>
                       
                       	 <!--Payment Data Tab-->
                        <div class="tab-pane tabs-animation fade" id="data" role="tabpanel">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <form id="frmChargeSuccess" class="">
                                        <!--Event/Domain-->
                                        <div class="position-relative row form-group">
                                            <label title="Event" for="lblChargeEvent" class="col-sm-2 col-form-label nsegreen text-right">Event</label>
                                        
                                            <div title="Event" class="col-sm-4">
                                                <label id="lblChargeEvent" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Domain-->
                                            <label title="Domain" for="lblChargeDomain" class="col-sm-2 col-form-label nsegreen text-right">Domain</label>
                                             
                                             <div title="Domain" class="col-sm-4">
                                                <label id="lblChargeDomain" class="form-control labelmiddle"></label>                                               
                                             </div>
                                         </div>  
                                    
                                    
                                    	<!--Payment Reference/Payment Status-->
                                         <div class="position-relative row form-group">
                                            <label title="Payment Reference" for="lblChargeReference" class="col-sm-2 col-form-label nsegreen text-right">Payment Reference</label>
                                        
                                            <div title="Payment Reference" class="col-sm-4">
                                                <label id="lblChargeReference" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Payment Status-->
                                            <label title="Payment Status" for="lblChargeStatus" class="col-sm-2 col-form-label nsegreen text-right">Status</label>
                                             
                                             <div title="Payment Status" class="col-sm-4">
                                                <label id="lblChargeStatus" class="form-control labelmiddle redtext"></label>                                              
                                             </div>
                                         </div>   
                                                                            
                                        <!--Transaction Amount/Channel-->
                                        <div class="position-relative row form-group">
                                            <!--Amount-->
                                            <label title="Transaction Amount" for="lblChargeAmount" class="col-sm-2 col-form-label nsegreen text-right">Amount</label>
                                             
                                             <div title="Transaction Amount" class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                                                     <label id="lblChargeAmount" class="form-control labelmiddle"></label>
                                                </div>                                               
                                             </div>
                                             
                                              <!--Payment Channel-->
                                             <label title="Payment Channel" for="lblChargeChannel" class="col-sm-2 col-form-label nsegreen text-right">Payment Channel</label>
                                        
                                            <div title="Payment Channel" class="col-sm-4">
                                                <label id="lblChargeChannel" class="form-control labelmiddle"></label>
                                            </div>
                                         </div>
                                         
                                         <!--Transaction Fees/Payment Date-->
                                        <div class="position-relative row form-group">
                                            <!--Fees-->
                                            <label title="Transaction Fees" for="lblChargeFees" class="col-sm-2 col-form-label nsegreen text-right">Transaction Fees</label>
                                        
                                            
                                            <div title="Transaction Fees" class="col-sm-4">                                                <div class="input-group">
                                                    <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                                                     <label id="lblChargeFees" class="form-control labelmiddle"></label>
                                                </div> 
                                            </div>
                                         
                                         	<!--Payment Date-->
                                            <label title="Payment Date" for="lblChargePaymentDate" class="col-sm-2 col-form-label nsegreen text-right">Payment Date</label>
                                        
                                            
                                            <div title="Payment Date" class="col-sm-4">
                                               <label id="lblChargePaymentDate" class="form-control labelmiddle"></label>
                                            </div>
                                         </div>
                                             
                                         <!--Message/Gateway Response-->
                                        <div class="position-relative row form-group">
                                            <!--Message-->
                                            <label title="Message" for="divChargeMessage" class="col-sm-2 col-form-label nsegreen text-right">Message</label>
                                             
                                             <div title="Message" class="col-sm-4">
                                                <div style="height:100px; overflow:auto;" id="divChargeMessage" class="form-control labelmiddle"></div>                                             
                                             </div>
                                             
                                             <label title="Gateway Response" for="lblChargeGatewayResponse" class="col-sm-2 col-form-label nsegreen text-right">Gateway Response</label>
                                        
                                            <div title="Gateway Response" class="col-sm-4">
                                                <label id="lblChargeGatewayResponse" class="form-control labelmiddle"></label>
                                            </div>
                                         </div>
                                       
                                        <!--Customer Email/User IP Address-->
                                        <div class="position-relative row form-group">
                                            <!--Customer Email-->
                                            <label title="Customer Email" for="lblChargeCustomerEmail" class="col-sm-2 col-form-label nsegreen text-right">Customer Email</label>
                                        
                                            
                                            <div title="Customer Email" class="col-sm-4">
                                               <label id="lblChargeCustomerEmail" class="form-control labelmiddle"></label>
                                            </div>
                                         
                                         	<!--User IP Address-->
                                            <label title="User IP Address" for="lblChargeUserIP" class="col-sm-2 col-form-label nsegreen text-right">User IP Address</label>
                                        
                                            
                                            <div title="User IP Address" class="col-sm-4">
                                               <label id="lblChargeUserIP" class="form-control labelmiddle"></label>
                                            </div>
                                         </div>
                                           
                                         <!--Card Type/Card Bin-->
                                        <div class="position-relative row form-group">
                                        	<!--Card Type-->
                                            <label title="Card Type" for="lblChargeCardType" class="col-sm-2 col-form-label nsegreen text-right">Card Type</label>
                                            
                                            <div title="Card Type" class="col-sm-4">
                                               <label id="lblChargeCardType" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                             <!--Card Bin-->
                                            <label title="Card Bin" for="lblChargeCardBin" class="col-sm-2 col-form-label nsegreen text-right">Card Bin</label>                                        
                                            
                                            <div title="Card Bin" class="col-sm-4">
                                                <label id="lblChargeCardBin" class="form-control labelmiddle"></label>
                                            </div>
                                         </div> 
                                                                            
                                         <!--Card Last 4 Digits/Card Brand-->
                                         <div class="position-relative row form-group">
                                         	<label title="Card Last 4 Digits" for="lblChargeLast4Digit" class="col-sm-2 col-form-label nsegreen text-right">Card Last 4 Digits</label>
                                            
                                            <div title="Card Last 4 Digits" class="col-sm-4">
                                                <label id="lblChargeLast4Digit" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Card Brand-->
                                            <label title="Card Brand" for="lblChargeCardBrand" class="col-sm-2 col-form-label nsegreen text-right">Card Brand</label>
                                             
                                             <div title="Card Brand" class="col-sm-4">
                                                <label id="lblChargeCardBrand" class="form-control labelmiddle"></label>
                                            </div>
                                         </div> 
                                         
                                         <!--Bank/Country Code-->
                                         <div class="position-relative row form-group">
                                         	<label title="Bank" for="lblChargeBank" class="col-sm-2 col-form-label nsegreen text-right">Bank</label>
                                            
                                            <div title="Bank" class="col-sm-4">
                                                <label id="lblChargeBank" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Country Code-->
                                            <label title="Country Code" for="lblChargeCountryCode" class="col-sm-2 col-form-label nsegreen text-right">Country Code</label>
                                             
                                             <div title="Country Code" class="col-sm-4">
                                                <label id="lblChargeCountryCode" class="form-control labelmiddle"></label>
                                            </div>
                                         </div> 
                                         
                                         <!--Created At/Paystack IP Address-->
                                        <div class="position-relative row form-group">
                                         	<label title="Date Created" for="lblChargeDateCreated" class="col-sm-2 col-form-label nsegreen text-right">Date Created</label>
                                            
                                            <div title="Date Created" class="col-sm-4">
                                                <label id="lblChargeDateCreated" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Paystack IP Address-->
                                            <label title="Paystack IP Address" for="lblChargePaystackIPAddress" class="col-sm-2 col-form-label nsegreen text-right">Paystack IP Address</label>
                                             
                                             <div title="Paystack IP Address" class="col-sm-4">
                                                <label id="lblChargePaystackIPAddress" class="form-control labelmiddle"></label>
                                            </div>
                                         </div>
                                    </form>
                                    
                                     <!--Transfer Success-->
                                    <form id="frmTransferSuccess" class="">
                                        <!--Event/Domain-->
                                        <div class="position-relative row form-group">
                                            <label title="Event" for="lblTransferSuccessEvent" class="col-sm-2 col-form-label nsegreen text-right">Event</label>
                                        
                                            <div title="Event" class="col-sm-4">
                                                <label id="lblTransferSuccessEvent" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Domain-->
                                            <label title="Domain" for="lblTransferSuccessDomain" class="col-sm-2 col-form-label nsegreen text-right">Domain</label>
                                             
                                             <div title="Domain" class="col-sm-4">
                                                <label id="lblTransferSuccessDomain" class="form-control labelmiddle"></label>                                               
                                             </div>
                                         </div>  
                                    
                                    
                                    	<!--Payment Reference/Payment Status-->
                                         <div class="position-relative row form-group">
                                            <label title="Payment Reference" for="lblTransferSuccessReference" class="col-sm-2 col-form-label nsegreen text-right">Payment Reference</label>
                                        
                                            <div title="Payment Reference" class="col-sm-4">
                                                <label id="lblTransferSuccessReference" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Payment Status-->
                                            <label title="Payment Status" for="lblTransferSuccessStatus" class="col-sm-2 col-form-label nsegreen text-right">Status</label>
                                             
                                             <div title="Payment Status" class="col-sm-4">
                                                <label id="lblTransferSuccessStatus" class="form-control labelmiddle redtext"></label>                                              
                                             </div>
                                         </div>   
                                                                            
                                        <!--Transaction Amount/Recipient Code-->
                                        <div class="position-relative row form-group">
                                            <!--Amount-->
                                            <label title="Transaction Amount" for="lblTransferSuccessAmount" class="col-sm-2 col-form-label nsegreen text-right">Amount</label>
                                             
                                             <div title="Transaction Amount" class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                                                     <label id="lblTransferSuccessAmount" class="form-control labelmiddle"></label>
                                                </div>                                               
                                             </div>
                                             
                                              <!--Recipient Code-->
                                             <label title="Recipient Code" for="lblTransferSuccessRecipientCode" class="col-sm-2 col-form-label nsegreen text-right">Recipient Code</label>
                                        
                                            <div title="Recipient Code" class="col-sm-4">
                                                <label id="lblTransferSuccessRecipientCode" class="form-control labelmiddle"></label>
                                            </div>
                                         </div>
                                         
                                         <!--Reason/Transfer Code-->
                                        <div class="position-relative row form-group">
                                            <!--Fees-->
                                            <label title="Reason For Transfer" for="divTransferSuccessReason" class="col-sm-2 col-form-label nsegreen text-right">Reason For Transfer</label>
                                        
                                            
                                            <div title="Reason For Transfer" class="col-sm-4">                                                <div style="height:120px; overflow:auto;" id="divTransferSuccessReason" class="form-control labelmiddle"></div>
                                            </div>
                                         
                                         	<!--Transfer Code-->
                                            <label title="Transfer Code" for="lblTransferSuccessTransferCode" class="col-sm-2 col-form-label nsegreen text-right">Transfer Code</label>
                                        
                                            
                                            <div title="Transfer Code" class="col-sm-4">
                                               <label id="lblTransferSuccessTransferCode" class="form-control labelmiddle"></label>
                                            </div>
                                         </div>
                                            
                                         <!--Account Number/Bank Name-->
                                        <div class="position-relative row form-group">
                                            <label title="Account Number" for="lblTransferSuccessAccountNo" class="col-sm-2 col-form-label nsegreen text-right">Account Number</label>
                                        
                                            <div title="Account Number" class="col-sm-4">
                                                <label id="lblTransferSuccessAccountNo" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Bank Name-->
                                            <label title="Bank Name" for="lblTransferSuccessBankName" class="col-sm-2 col-form-label nsegreen text-right">Bank Name</label>
                                             
                                             <div title="Bank Name" class="col-sm-4">
                                                <label id="lblTransferSuccessBankName" class="form-control nsebuttongreen labelmiddle makebold"></label>                                               
                                             </div>
                                         </div>
                                        
                                        <!--Bank Code/Paystack IP Address-->
                                        <div class="position-relative row form-group">
                                            <!--Bank Code-->
                                            <label title="Bank Code" for="lblTransferSuccessBankCode" class="col-sm-2 col-form-label nsegreen text-right">Bank Code</label>
                                            
                                            <div title="Bank Code" class="col-sm-4">
                                               <label id="lblTransferSuccessBankCode" class="form-control labelmiddle"></label>
                                            </div>
                                         
                                         	<!--Paystack IP Address-->
                                            <label title="Paystack IP Address" for="lblTransferSuccessPaystackIPAddress" class="col-sm-2 col-form-label nsegreen text-right">Paystack IP Address</label>
                                             
                                             <div title="Paystack IP Address" class="col-sm-4">
                                                <label id="lblTransferSuccessPaystackIPAddress" class="form-control labelmiddle"></label>
                                            </div>
                                         </div>
                                         
                                         <!--Date Created/Dated Updated-->
                                        <div class="position-relative row form-group">
                                        	<!--Date Created-->
                                            <label title="Date Created" for="lblTransferSuccessDateCreated" class="col-sm-2 col-form-label nsegreen text-right">Date Created</label>
                                            
                                            <div title="Date Created" class="col-sm-4">
                                                <label id="lblTransferSuccessDateCreated" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                             <!--Dated Updated-->
                                            <label title="Dated Updated" for="lblTransferSuccessDatedUpdated" class="col-sm-2 col-form-label nsegreen text-right">Dated Updated</label>                                        
                                            
                                            <div title="Dated Updated" class="col-sm-4">
                                                <label id="lblTransferSuccessDatedUpdated" class="form-control labelmiddle"></label>
                                            </div>
                                         </div> 
                                    </form>
                                    
                                    
                                    <!--Transfer Failed-->
                                    <form id="frmTransferFailed" class="">
                                        <!--Event/Domain-->
                                        <div class="position-relative row form-group">
                                            <label title="Event" for="lblTransferFailedEvent" class="col-sm-2 col-form-label nsegreen text-right">Event</label>
                                        
                                            <div title="Event" class="col-sm-4">
                                                <label id="lblTransferFailedEvent" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Domain-->
                                            <label title="Domain" for="lblTransferFailedDomain" class="col-sm-2 col-form-label nsegreen text-right">Domain</label>
                                             
                                             <div title="Domain" class="col-sm-4">
                                                <label id="lblTransferFailedDomain" class="form-control labelmiddle"></label>                                               
                                             </div>
                                         </div>  
                                    
                                    
                                    	<!--Recipient Code/Payment Status-->
                                         <div class="position-relative row form-group">
                                            <label title="Recipient Code" for="lblTransferFailedRecipientCode" class="col-sm-2 col-form-label nsegreen text-right">Recipient Code</label>
                                        
                                            <div title="Recipient Code" class="col-sm-4">
                                                <label id="lblTransferFailedRecipientCode" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Payment Status-->
                                            <label title="Payment Status" for="lblTransferFailedStatus" class="col-sm-2 col-form-label nsegreen text-right">Status</label>
                                             
                                             <div title="Payment Status" class="col-sm-4">
                                                <label id="lblTransferFailedStatus" class="form-control labelmiddle redtext"></label>                                              
                                             </div>
                                         </div>   
                                                                                                          
                                        <!--Transaction Amount/Transfer Code-->
                                        <div class="position-relative row form-group">
                                            <!--Amount-->
                                            <label title="Transaction Amount" for="lblTransferFailedAmount" class="col-sm-2 col-form-label nsegreen text-right">Amount</label>
                                             
                                             <div title="Transaction Amount" class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                                                     <label id="lblTransferFailedAmount" class="form-control labelmiddle"></label>
                                                </div>                                               
                                             </div>
                                             
                                              <!--Transfer Code-->
                                             <label title="Transfer Code" for="lblTransferFailedTransferCode" class="col-sm-2 col-form-label nsegreen text-right">Transfer Code</label>
                                        
                                            <div title="Transfer Code" class="col-sm-4">
                                                <label id="lblTransferFailedTransferCode" class="form-control labelmiddle"></label>
                                            </div>
                                         </div>
                                         
                                         <!--Reason/Transfer Date-->
                                        <div class="position-relative row form-group">
                                            <!--Reason-->
                                            <label title="Reason For Transfer" for="divTransferFailedReason" class="col-sm-2 col-form-label nsegreen text-right">Reason For Transfer</label>
                                        
                                            
                                            <div title="Reason For Transfer" class="col-sm-4">                                                <div style="height:120px; overflow:auto;" id="divTransferFailedReason" class="form-control labelmiddle"></div>
                                            </div>
                                         
                                         	<!--Transfer Date-->
                                            <label title="Transfer Date" for="lblTransferFailedTransferDate" class="col-sm-2 col-form-label nsegreen text-right">Transfer Date</label>
                                        
                                            
                                            <div title="Transfer Date" class="col-sm-4">
                                               <label id="lblTransferFailedTransferDate" class="form-control labelmiddle"></label>
                                            </div>
                                         </div>
                                                      
                                        <!--Account Name/Account Number-->
                                        <div class="position-relative row form-group">
                                            <label title="Account Name" for="lblTransferFailedAccountName" class="col-sm-2 col-form-label nsegreen text-right">Account Name</label>
                                        
                                            <div title="Account Name" class="col-sm-4">
                                                <label id="lblTransferFailedAccountName" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Account Number-->
                                            <label title="Account Number" for="lblTransferFailedAccountNo" class="col-sm-2 col-form-label nsegreen text-right">Account Number</label>
                                             
                                             <div title="Account Number" class="col-sm-4">
                                                <label id="lblTransferFailedAccountNo" class="form-control nsebuttongreen labelmiddle makebold"></label>                                               
                                             </div>
                                         </div>
                                       
                                        <!--Bank Name/Bank Code-->
                                        <div class="position-relative row form-group">
                                            <!--Bank Name-->
                                            <label title="Bank Name" for="lblTransferFailedBankName" class="col-sm-2 col-form-label nsegreen text-right">Bank Name</label>
                                             
                                             <div title="Bank Name" class="col-sm-4">
                                                <label id="lblTransferFailedBankName" class="form-control nsebuttongreen labelmiddle makebold"></label>                                               
                                             </div>
                                         
                                         	<!--Bank Code-->
                                            <label title="Bank Code" for="lblTransferFailedBankCode" class="col-sm-2 col-form-label nsegreen text-right">Bank Code</label>
                                            
                                            <div title="Bank Code" class="col-sm-4">
                                               <label id="lblTransferFailedBankCode" class="form-control labelmiddle"></label>
                                            </div>
                                         </div>      
                                         
                                        <!--Date Created/Paystack IP Address-->
                                        <div class="position-relative row form-group">
                                        	<!--Date Created-->
                                            <label title="Date Created" for="lblTransferFailedDateCreated" class="col-sm-2 col-form-label nsegreen text-right">Date Created</label>
                                            
                                            <div title="Date Created" class="col-sm-4">
                                                <label id="lblTransferFailedDateCreated" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                             <!--Paystack IP Address-->
                                            <label title="Paystack IP Address" for="lblTransferFailedPaystackIPAddress" class="col-sm-2 col-form-label nsegreen text-right">Paystack IP Address</label>
                                             
                                             <div title="Paystack IP Address" class="col-sm-4">
                                                <label id="lblTransferFailedPaystackIPAddress" class="form-control labelmiddle"></label>
                                            </div>
                                         </div> 
                                    </form>


                                    <!--Transfer Reversed-->
                                    <form id="frmTransferReversed" class="">
                                        <!--Event/Domain-->
                                        <div class="position-relative row form-group">
                                            <label title="Event" for="lblTransferReversedEvent" class="col-sm-2 col-form-label nsegreen text-right">Event</label>
                                        
                                            <div title="Event" class="col-sm-4">
                                                <label id="lblTransferReversedEvent" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Domain-->
                                            <label title="Domain" for="lblTransferReversedDomain" class="col-sm-2 col-form-label nsegreen text-right">Domain</label>
                                             
                                             <div title="Domain" class="col-sm-4">
                                                <label id="lblTransferReversedDomain" class="form-control labelmiddle"></label>                                               
                                             </div>
                                         </div>  
                                    
                                    
                                    	<!--Payment Reference/Payment Status-->
                                         <div class="position-relative row form-group">
                                            <label title="Payment Reference" for="lblTransferReversedReference" class="col-sm-2 col-form-label nsegreen text-right">Payment Reference</label>
                                        
                                            <div title="Payment Reference" class="col-sm-4">
                                                <label id="lblTransferReversedReference" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Payment Status-->
                                            <label title="Payment Status" for="lblTransferReversedStatus" class="col-sm-2 col-form-label nsegreen text-right">Status</label>
                                             
                                             <div title="Payment Status" class="col-sm-4">
                                                <label id="lblTransferReversedStatus" class="form-control labelmiddle redtext"></label>                                              
                                             </div>
                                         </div>   
                                                                            
                                        <!--Transaction Amount/Recipient Code-->
                                        <div class="position-relative row form-group">
                                            <!--Amount-->
                                            <label title="Transaction Amount" for="lblTransferReversedAmount" class="col-sm-2 col-form-label nsegreen text-right">Amount</label>
                                             
                                             <div title="Transaction Amount" class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                                                     <label id="lblTransferReversedAmount" class="form-control labelmiddle"></label>
                                                </div>                                               
                                             </div>
                                             
                                              <!--Recipient Code-->
                                             <label title="Recipient Code" for="lblTransferReversedRecipientCode" class="col-sm-2 col-form-label nsegreen text-right">Recipient Code</label>
                                        
                                            <div title="Recipient Code" class="col-sm-4">
                                                <label id="lblTransferReversedRecipientCode" class="form-control labelmiddle"></label>
                                            </div>
                                         </div>
                                         
                                         <!--Reason For Transfer/Transfer Code-->
                                        <div class="position-relative row form-group">
                                            <!--Reason For Transfer-->
                                            <label title="Reason For Transfer" for="divTransferReversedReason" class="col-sm-2 col-form-label nsegreen text-right">Reason For Transfer</label>
                                        
                                            
                                            <div title="Reason For Transfer" class="col-sm-4">                                                <div style="height:120px; overflow:auto;" id="divTransferReversedReason" class="form-control labelmiddle"></div>
                                            </div>
                                         
                                         	<!--Transfer Code-->
                                            <label title="Transfer Code" for="lblTransferReversedTransferCode" class="col-sm-2 col-form-label nsegreen text-right">Transfer Code</label>
                                        
                                            
                                            <div title="Transfer Code" class="col-sm-4">
                                               <label id="lblTransferReversedTransferCode" class="form-control labelmiddle"></label>
                                            </div>
                                         </div>
                                             
                                        <!--Account Name/Account Number-->
                                        <div class="position-relative row form-group">
                                            <label title="Account Name" for="lblTransferReversedAccountName" class="col-sm-2 col-form-label nsegreen text-right">Account Name</label>
                                        
                                            <div title="Account Name" class="col-sm-4">
                                                <label id="lblTransferReversedAccountName" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Account Number-->
                                            <label title="Account Number" for="lblTransferReversedAccountNo" class="col-sm-2 col-form-label nsegreen text-right">Account Number</label>
                                             
                                             <div title="Account Number" class="col-sm-4">
                                                <label id="lblTransferReversedAccountNo" class="form-control nsebuttongreen labelmiddle makebold"></label>                                               
                                             </div>
                                         </div>
                           
										<!--Bank Name/Bank Code-->
                                        <div class="position-relative row form-group">
                                            <!--Bank Name-->
                                            <label title="Bank Name" for="lblTransferReversedBankName" class="col-sm-2 col-form-label nsegreen text-right">Bank Name</label>
                                             
                                             <div title="Bank Name" class="col-sm-4">
                                                <label id="lblTransferReversedBankName" class="form-control nsebuttongreen labelmiddle makebold"></label>                                               
                                             </div>
                                         
                                         	<!--Bank Code-->
                                            <label title="Bank Code" for="lblTransferReversedBankCode" class="col-sm-2 col-form-label nsegreen text-right">Bank Code</label>
                                            
                                            <div title="Bank Code" class="col-sm-4">
                                               <label id="lblTransferReversedBankCode" class="form-control labelmiddle"></label>
                                            </div>
                                         </div>
                                         
                                        <!--Session Provider/Session Id-->
                                        <div class="position-relative row form-group">
                                            <!--Session Provider-->
                                            <label title="Session Provider" for="lblTransferReversedSessionProvider" class="col-sm-2 col-form-label nsegreen text-right">Session Provider</label>              
                                            <div title="Session Provider" class="col-sm-4">
                                               <label id="lblTransferReversedSessionProvider" class="form-control labelmiddle"></label>
                                            </div>
                                         
                                         	<!--Session Id-->
                                            <label title="Session Id" for="lblTransferReversedSessionId" class="col-sm-2 col-form-label nsegreen text-right">Session Id</label>
                                        
                                            
                                            <div title="Session Id" class="col-sm-4">
                                               <label id="lblTransferReversedSessionId" class="form-control labelmiddle"></label>
                                            </div>
                                         </div>
                                         
                                         <!--Transfer Date/Paystack IP Address-->
                                        <div class="position-relative row form-group">
                                        	<!--Transfer Date-->
                                            <label title="Transfer Date" for="lblTransferReversedTransferDate" class="col-sm-2 col-form-label nsegreen text-right">Transfer Date</label>
                                            
                                            <div title="Transfer Date" class="col-sm-4">
                                                <label id="lblTransferReversedTransferDate" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                             <!--Paystack IP Address-->
                                            <label title="Paystack IP Address" for="lblTransferReversedPaystackIPAddress" class="col-sm-2 col-form-label nsegreen text-right">Paystack IP Address</label>
                                             
                                             <div title="Paystack IP Address" class="col-sm-4">
                                                <label id="lblTransferReversedPaystackIPAddress" class="form-control labelmiddle"></label>
                                            </div>
                                         </div> 
                                           
                                         <!--Date Created/Date Updated-->
                                        <div class="position-relative row form-group">
                                         	<label title="Date Created" for="lblTransferReversedDateCreated" class="col-sm-2 col-form-label nsegreen text-right">Date Created</label>
                                            
                                            <div title="Date Created" class="col-sm-4">
                                                <label id="lblTransferReversedDateCreated" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Date Updated-->
                                            <label title="Date Updated" for="lblTransferReversedDateUpdated" class="col-sm-2 col-form-label nsegreen text-right">Date Updated</label>
                                             
                                             <div title="Date Updated" class="col-sm-4">
                                                <label id="lblTransferReversedDateUpdated" class="form-control labelmiddle"></label>
                                            </div>
                                         </div> 
                                         
                                         <!--Failures-->
                                         <div class="position-relative row form-group">
                                         	<label title="Failures" for="lblTransferReversedFailures" class="col-sm-2 col-form-label nsegreen text-right">Failures</label>
                                            
                                            <div title="Failures" class="col-sm-4">
                                                <label id="lblTransferReversedFailures" class="form-control labelmiddle"></label>
                                            </div>
                                         </div>   
                                    </form>
                                    
                                    <!--Buttons-->
                                  <div class="position-relative row form-group">
                                    <label class="col-sm-5 col-form-label"></label>
                                    
                                    <div class="col-sm-7">
                                        <button id="btnRefresh" style="margin-left:10px;" onClick="window.location.reload(true);" type="button" class="btn btn-info makebold size-16">Refresh</button>
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
