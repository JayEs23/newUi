<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Naija Art Mart - Pay Issuers</title>
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
		
		document.getElementById('btnPay').disabled=true;
		$('#btnPay').hide();				
		
		LoadTradesList();
		
		$('#btnPay').click(function(e)
		{
			try
			{
				$('#divAlert').html('');			
				if (!CheckPay()) return false;
			}catch(e)
			{
				$.unblockUI();
				m='Make Payment Button Click ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		});//btnPay Click Ends
		
		
		function CheckPay()
		{
			try
			{
				var issuer_email = $.trim($('#lblIssuerEmail').html());
				var tradeid = $.trim($('#lblTradeId').html());
				var tradedate = ChangeDateFrom_dMY_To_Ymd($('#lblDate').html());				
				var sym = $.trim($('#lblSymbol').html());
				var tok = $.trim($('#lblTokens').html()).replace(new RegExp(',', 'g'), '');
				var pr = $.trim($('#lblPrice').html()).replace(new RegExp(',', 'g'), '');				
				var tradeamt = $.trim($('#lblTradeAmount').html()).replace(new RegExp(',', 'g'), '');			
				var issuer_amt = $.trim($('#lblIssuerAmount').html()).replace(new RegExp(',', 'g'), '');		
				var desc = $.trim($('#divDescription').html());					
				var rec_code = $.trim($('#lblRecipientCode').html());
				var enddate = ChangeDateFrom_dMY_To_Ymd($('#lblListEndDate').html());
				var liststatus = $.trim($('#lblListingStatus').html());
				var bal = $.trim($('#lblBalance').html()).replace(new RegExp(',', 'g'), '');
				
				//User Email
				if (!Email)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the payment.';						

					DisplayMessage(m, 'error',Title);				

					return false;
				}
				
				//Trade Id	
				if (!tradeid)
				{
					m='Trade Id field must not be blank. Refresh the window.';
					DisplayMessage(m, 'error',Title);					
					AdminActivateTab('data'); return false;
				}
						
				//Symbol
				if (!sym)
				{
					m='Artwork symbol field must not be blank. Refresh the window.';
					DisplayMessage(m, 'error',Title);					
					AdminActivateTab('data'); return false;
				}
				
				if ($.isNumeric(sym))
				{
					m='Artwork symbol field must not be a number.';					
					DisplayMessage(m, 'error',Title);					
					AdminActivateTab('data'); return false;
				}
								
				//Artwork Value
				if (!issuer_amt)
				{
					m='Amount to transfer to issuer must not be blank. Refresh the window.';						
					DisplayMessage(m, 'error',Title);						
					AdminActivateTab('data'); return false;		
				}
				
				if (!$.isNumeric(issuer_amt))
				{
					m='Amount to transfer to issuer must be a number. Refresh the window.';					
					DisplayMessage(m, 'error',Title);					
					AdminActivateTab('data'); return false;
				}
				
				//Recipient Code
				if (!rec_code)
				{
					m='Issuer recipient code field must not be blank. Refresh the window.';						
					DisplayMessage(m, 'error',Title);						
					AdminActivateTab('data'); return false;		
				}				
				
				//issuer_email
				if (!issuer_email)
				{
					m='Issuer email field must not be blank. Refresh the window.';						
					DisplayMessage(m, 'error',Title);						
					AdminActivateTab('data'); return false;		
				}
				
				//Paystack Balance
				if (!bal)
				{
					m='Paystack balance is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the payment. If the issue still persists after signout and signin and you are sure that there is enough balance in the paystack account, please contact the system administrator at support@naijaartmart.com, otherwise credit the paystack account.';	
							
					DisplayMessage(m, 'error',Title);					
					return false;
				}
				
				if (!$.isNumeric(bal))
				{
					m='Paystack balance MUST be a number.';						
					DisplayMessage(m, 'error',Title);
					return false;
				}

				if (parseFloat(bal) == 0)
				{
					m='Paystck balance is zero.';				
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
				if (parseFloat(bal) < 0)
				{
					m='E-wallet balance must not be a negative number. Please fund your e-wallet so that you can trade with it.';				
					DisplayDirectBuyMessage(m, 'error',Title);
					return false;
				}
									
				if (parseFloat(bal) < parseFloat(issuer_amt))
				{
					m="You do not have enough balance in the paystack account to pay the issuer. Current paystack balance is (<b>₦"+number_format(bal,2,'.',',')+"</b>) and the total amount needed to pay the issuer is (<b>₦" + number_format(issuer_amt,2,'.',',') + "</b>).";
					DisplayMessage(m, 'error',Title);
					return false;
				}
				
	//m='Trade Date = '+tradedate+'<br>Trade Id = '+tradeid+'<br>Symbol = '+sym+'<br>Paystack Balance = ₦'+bal+'<br>No. Of Tokens = '+tok+'<br>Price Per token = ₦'+pr+'<br>Trade Amount = ₦'+tradeamt+'<br>Issuer Amount = ₦'+issuer_amt+'<br>Listing End Date = '+enddate+'<br>Listing Status = '+liststatus+'<br>Issuer Email = '+issuer_email+'<br>Issuer Recipient Code = '+rec_code+'<br>Trade Description = '+desc;				
					
	//DisplayMessage(m, 'info',Title);	return;	
								
				//Confirm Approval				
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: "<font size='3' face='Arial'>Do you want to proceed with the transfer to the issuer account?</font>",
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Making Payment To Issuer. Please Wait...</p>",theme: false,baseZ: 2000});
										
					//Initiate POST
					var uri = "<?php echo site_url('admin/Payissuers/MakePayment'); ?>";
					var xhr = new XMLHttpRequest();
					var fd = new FormData();
					
					xhr.open("POST", uri, true);
					
					xhr.onreadystatechange = function() {
						
						if (xhr.readyState == 4)
						{
							$.unblockUI();
							
							if (xhr.status == 200)
							{
								var res = JSON.parse(xhr.responseText);
								
								if ($.trim(res.status).toUpperCase()=='OK')
								{
									if ($.trim(res.Message) != '')
									{
										m=res.Message;
									}else
									{
										m="Listing request has been approved successfully.";
									}								
									
									DisplayMessage(m, 'success','Approved Listing Request','SuccessTheme');
									
									ResetControls();
									LoadTradesList();
									AdminActivateTab('view');																						
								}else
								{
									m=res.Message;
									DisplayMessage(m, 'error',Title);
								}	
							}							
						}
					};

					fd.append('trade_date', tradedate);
					fd.append('trade_id', tradeid);
					fd.append('symbol', sym);
					fd.append('num_tokens', tok);
					fd.append('price', pr);
					fd.append('trade_amount', tradeamt);
					fd.append('recipient_amount', issuer_amt);
					fd.append('listingenddate', enddate);
					fd.append('listing_ended', liststatus);
					fd.append('issuer_email', issuer_email);
					fd.append('recipient_code', rec_code);					
					fd.append('email', Email);
					fd.append('description', desc);					
																									
					xhr.send(fd);// Initiate a multipart/form-data upload
				  }
				})	
			}catch(e)
			{
				$.unblockUI();
				m='CheckPay ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}		
		}//End CheckPay
		
    });//Document Ready
	
	function ViewRow(issuer_email,tid,tdate,sym,tok,pr,trade_amt,issuer_amt,cur,desc,recipient,rec_code,tran_code,list_ended,listing_ends,balance)
	{
		try
		{
			ResetControls();

			$('#lblIssuerEmail').html(issuer_email);
			$('#lblTradeId').html(tid);	
			$('#lblDate').html(tdate);
			$('#lblSymbol').html(sym);					
			$('#lblTokens').html(number_format(tok,0,'',','));
			$('#lblPrice').html(number_format(pr,2,'.',','));
			$('#lblTradeAmount').html(number_format(trade_amt,2,'.',','));	
			
			$('#lblIssuerAmount').html(number_format(issuer_amt,2,'.',','));
			$('#divDescription').html(desc);		
			$('#lblRecipientCode').html(rec_code);
			$('#lblListEndDate').html(listing_ends);
			
			if ($.isNumeric(balance))
			{
				$('#lblBalance').html(number_format(balance,2,'.',','));
			}else
			{
				$('#lblBalance').html(balance);
			}
			
			if (parseInt(list_ended) ==1)
			{
				$('#lblListingStatus').html('Ended');
				document.getElementById('btnPay').disabled=false;
				$('#btnPay').show();				
			}else
			{
				$('#lblListingStatus').html('Not Ended');				
				document.getElementById('btnPay').disabled=true;
				$('#btnPay').hide();
			}
			

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
			document.getElementById('btnPay').disabled=false;
				
			$('#lblIssuerEmail').html('');
			$('#lblTradeId').html('');	
			$('#lblDate').html('');
			$('#lblSymbol').html('');					
			$('#lblTokens').html('');
			$('#lblPrice').html('');
			$('#lblTradeAmount').html('');	
			
			$('#lblIssuerAmount').html('');
			$('#divDescription').html('');		
			$('#lblRecipientCode').html('');
			$('#lblListEndDate').html('');
			$('#lblListingStatus').html('');			
			$('#lblBalance').html('');
						
			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m="ResetControls ERROR:\n"+e;
			DisplayMessage(m,'error',Title);
		}
	}//End ResetControls
	
	function LoadTradesList()
	{
		try
		{			
			$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Loading Trades List. Please Wait...</p>",theme: false,baseZ: 2000});
			
			$('#recorddisplay > tbody').html('');
			
			$.ajax({
				url: "<?php echo site_url('admin/Payissuers/GetTradesLists');?>",
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
						language: {zeroRecords: "No Issuance Payment Record Found"},
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
							{ className: "dt-center", "targets": [ 0,1,2,3,5,6,7 ] },
							{ className: "dt-right", "targets": [ 4 ] }
						],					
						order: [[ 7, 'asc' ]],
						data: dataSet, 
						columns: [
							{ width: "10%" },//Date
							{ width: "15%" },//Asset
							{ width: "12%" },//Token
							{ width: "12%" }, //Price
							{ width: "12%" }, //Amount
							{ width: "20%" }, //Email
							{ width: "15%" }, //Listing Ends
							{ width: "4" } //Select
						]
					} );
					
					var total=0; 
					
					total=table.column(4).data().sum();
												
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
			m='LoadTradesList ERROR:\n'+e;
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
                                                    Pay Issuers
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
                                <span>Issuers Payment List</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabData" data-toggle="tab" href="#data">
                                <span>Payment Data</span>
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
                                            <table class="hover table table-bordered data-table display wrap" id="recorddisplay">
                                              <thead>
                                                <tr>
                                                    <th style="text-align:center" width="10%">TRADE&nbsp;DATE</th>
                                                    <th style="text-align:center" width="15%">ASSET</th>
                                                    
                                                    <th style="text-align:center" width="12%">TOKENS</th>
                                                    
                                                    <th style="text-align:center;" width="12%">PRICE&nbsp;(&#8358;)</th>
                                                    <th style="text-align:right; padding-right:10px;" width="12%">ISSUER&nbsp;AMOUNT&nbsp;(&#8358;)</th>
                                                    <th style="text-align:center" width="20%">ISSUER&nbsp;EMAIL</th>
                                                    <th style="text-align:center" width="15%">LISTING&nbsp;END</th>
                                                    <th style="text-align:center" width="4%">VIEW</th>
                                                </tr>
                                            </thead>
                    
                                              <tbody id="tbbody"></tbody>
                                              
                                              <tfoot style="color:#ffffff; background-color:#7E7B7B;">
                                                    <tr>
                                                        <th colspan="4" style="text-align:right; padding:3px; padding-right:10px; font-weight:bold; font-size:13px;" width="49%">TOTAL TRADE AMOUNT:</th>
                                                        
                                                        <th id="tdAmount" style="text-align:right;padding-right:8px; font-weight:bold; font-size:14px;" width="12%"></th>
                                                        
                                                        <th colspan="3" style="text-align:left; padding-right:8px; font-weight:bold; font-size:14px;" width="39%"></th>
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
                                    <form class="">                                    
                                  		<!--Trade Date/Trade Id-->
                                        <div class="position-relative row form-group">
                                            <label title="Trade Date" for="lblDate" class="col-sm-2 col-form-label nsegreen">Trade Date</label>
                                        
                                            <div title="Trade Date" class="col-sm-4">
                                                <label id="lblDate" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Trade Id-->
                                            <label title="Trade Id" for="lblTradeId" class="col-sm-2 col-form-label nsegreen text-right">Trade Id</label>
                                             
                                             <div title="Trade Id" class="col-sm-4">
                                                <label id="lblTradeId" class="form-control labelmiddle"></label>                                               
                                             </div>
                                         </div>  
                                    
                                    
                                    	<!--Art Symbol/Paystack balance-->
                                         <div class="position-relative row form-group">
                                            <label title="Artwork Symbol" for="lblSymbol" class="col-sm-2 col-form-label nsegreen">Art Symbol<span class="redtext">*</span></label>
                                        
                                            <div title="Artwork Symbol" class="col-sm-4">
                                                <label id="lblSymbol" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Paystack balance-->
                                            <label title="Paystack Balance" for="lblBalance" class="col-sm-2 col-form-label nsegreen text-right">Paystack Balance</label>
                                             
                                             <div title="Paystack Balance" class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                                                     <label id="lblBalance" class="form-control labelmiddle redtext"></label>
                                                </div>                                               
                                             </div>
                                         </div>
                                     
                                     
                                        <!--Tokens/Price-->
                                        <div class="position-relative row form-group">
                                            <label title="Number Of Tokens Bought" for="lblTokens" class="col-sm-2 col-form-label nsegreen">No Of Tokens</label>
                                        
                                            <div title="Number Of Tokens Bought" class="col-sm-4">
                                                <label id="lblTokens" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Price-->
                                            <label title="Price Per token" for="lblPrice" class="col-sm-2 col-form-label nsegreen text-right">Price Per token</label>
                                             
                                             <div title="Price Per token" class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                                                     <label id="lblPrice" class="form-control labelmiddle"></label>
                                                </div>                                               
                                             </div>
                                         </div>
                                         
                                         <!--Trade Amount/Issuer Amount-->
                                        <div class="position-relative row form-group">
                                            <label title="Trade Amount" for="lblTradeAmount" class="col-sm-2 col-form-label nsegreen">Trade Amount</label>
                                        
                                            <div title="Trade Amount" class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                                                     <label id="lblTradeAmount" class="form-control labelmiddle"></label>
                                                </div>
                                                
                                            </div>
                                            
                                            <!--Issuer Amount-->
                                            <label title="Amount To Transfer To Issuer" for="lblIssuerAmount" class="col-sm-2 col-form-label nsegreen text-right">Issuer Amount</label>
                                             
                                             <div title="Amount To Transfer To Issuer" class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                                                     <label id="lblIssuerAmount" class="form-control nsebuttongreen labelmiddle makebold"></label>
                                                </div>                                               
                                             </div>
                                         </div>
                                       
                                        <!--Description-->
                                        <div class="position-relative row form-group">
                                            <label title="Trade Description" for="divDescription" class="col-sm-2 col-form-label nsegreen">Trade Description<span class="redtext">*</span></label>
                                        
                                            
                                            <div title="Trade Description" class="col-sm-10">
                                               <div style="height:60px;" id="divDescription" class="form-control labelmiddle"></div>
                                            </div>
                                         </div>
                                         
                                         <!--Listing End Date/Listing Status-->
                                        <div class="position-relative row form-group">
                                        	<label title="Listing End Date" for="lblListEndDate" class="col-sm-2 col-form-label nsegreen">Listing End Date<span class="redtext">*</span></label>
                                            
                                            <div title="Listing End Date" class="col-sm-4">
                                               <label id="lblListEndDate" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                             <!--Listing Status-->
                                            <label title="Listing Status" for="lblListingStatus" class="col-sm-2 col-form-label nsegreen text-right">Listing Status<span class="redtext">*</span></label>
                                        
                                            
                                            <div title="Listing Status" class="col-sm-4">
                                                <label id="lblListingStatus" class="form-control labelmiddle"></label>
                                            </div>
                                         </div> 
                                                                            
                                         <!--Issuer Email/Recipient Code-->
                                         <div class="position-relative row form-group">
                                         	<label title="Issuer Email" for="lblIssuerEmail" class="col-sm-2 col-form-label nsegreen">Issuer Email</label>
                                            
                                            <div title="Issuer Email" class="col-sm-4">
                                                <label id="lblIssuerEmail" class="form-control labelmiddle"></label>
                                            </div>
                                            
                                            <!--Issuer Recipient Code-->
                                            <label title="Issuer Recipient Code" for="lblRecipientCode" class="col-sm-2 col-form-label nsegreen text-right">Recipient Code<span class="redtext">*</span></label>
                                             
                                             <div title="Issuer Recipient Code" class="col-sm-4">
                                                <label id="lblRecipientCode" class="form-control labelmiddle"></label>
                                            </div>
                                         </div> 
                                         
                                         <!--Buttons-->
                                          <div class="position-relative row form-group">
                                          	<label class="col-sm-5 col-form-label"></label>
                                            
                                            <div class="col-sm-7">
                                            	<button title="Click to make payment to issuer" id="btnPay" type="button" class="btn btn-nse-green makebold size-16">Pay Issuer</button>
                                            	
                                                <button style="margin-left:10px;" onClick="window.location.reload(true);" type="button" class="btn btn-info makebold size-16">Refresh</button>
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


<!--Start Pix Popup-->
<div id="myPixModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background-color:#000000; padding:0;">
          <div class="modal-header" style="background-color:#363131;">              
              <h4 style="color:#ffffff; margin-right:39px;" id="modPixTitle" class="modal-title">PICTURE</h4>
              <button title="Click X to close the picture screen" type="button" class="close" data-dismiss="modal">×</button>
          </div>
          
          <div align="center" class="modal-body" style="padding:1px;">
            <img class="modal-content" id="img01" style="margin-top:0; border:none; ">
          </div>
          
          <div class="modal-footer">
            <center><button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button></center>
          </div>
        </div>
      </div>
</div>

<!--End Pix Popup-->


<script type="text/javascript" src="<?php echo base_url();?>assets/js/main.8d288f825d8dffbbe55e.js"></script>
</body>
</html>
