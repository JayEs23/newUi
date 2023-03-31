<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Derived Homes | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Naija Art Mart - The Revamped Face of Transportation In Nigeria!">    
    <meta name="msapplication-tap-highlight" content="no"><!-- Disable tap highlight on IE -->

	<?php include('header.php'); ?>
    <?php include('scripts.php'); ?>
    
    <script>
		var Usertype='<?php echo $usertype; ?>';
		var RefreshInterval=1;
		RefreshInterval=parseInt(RefreshInterval,10) * 60 * 250;
    	
		$(document).ready(function(e) {								
			$(document).ajaxStop($.unblockUI);
			
			setInterval(function() {
				LoadSummary();
			}, RefreshInterval);
			
			function LoadSummary()
			{
				try
				{
					$.ajax({
						url: "<?php echo site_url('admin/Dashboard/GetSummary');?>",
						type: 'POST',
						data: {usertype:Usertype},
						dataType: 'json',
						success: function(data,status,xhr) {
							if ($(data).length > 0)
							{
								$.each($(data), function(i,e)
								{
									if (Usertype.toLowerCase() == 'admin')
									{										
										$('#spnTotalAdminTradeOrders').html(number_format(e.TotalAdminTradeOrders, '0', '', ','));
										$('#spnTotalAdminListedSecurities').html(number_format(e.TotalAdminListedSecurities, '0', '', ','));
										
										$('#spnTotalAdminSecondaryTrades').html(number_format(e.TotalAdminSecondaryTrades, '0', '', ','));
										$('#spnTotalAdminPrimaryTrades').html(number_format(e.TotalAdminPrimaryTrades, '0', '', ','));
										
										$('#spnTotalAdminSecondaryMarketSecurities').html(number_format(e.TotalAdminSecondaryMarketSecurities, '0', '', ','));
										$('#spnTotalAdminPrimaryMarketSecurities').html(number_format(e.TotalAdminPrimaryMarketSecurities, '0', '', ','));
										
										$('#spnTotalAdminApprovedSecurities').html(number_format(e.TotalAdminApprovedSecurities, '0', '', ','));
										$('#spnTotalAdminListedSecuritiesAwaitingApproval').html(number_format(e.TotalAdminListedSecuritiesAwaitingApproval, '0', '', ','));
										
										$('#spnTotalAdminDayMarketValue').html('₦' + number_format(e.TotalAdminDayMarketValue, '2', '.', ',')).css('font-weight','bold');
										$('#spnTotalAdminTotalMarketValue').html('₦' + number_format(e.TotalAdminTotalMarketValue, '2', '.', ','));
										
									}else if (Usertype.toLowerCase() == 'operator')
									{
										$('#spnTotalOperatorTradeOrders').html(number_format(e.TotalOperatorTradeOrders, '0', '', ','));
										$('#spnTotalOperatorListedSecurities').html(number_format(e.TotalOperatorListedSecurities, '0', '', ','));
										
										$('#spnTotalOperatorSecondaryTrades').html(number_format(e.TotalOperatorSecondaryTrades, '0', '', ','));
										$('#spnTotalOperatorPrimaryTrades').html(number_format(e.TotalOperatorPrimaryTrades, '0', '', ','));
										
										$('#spnTotalOperatorSecondaryMarketSecurities').html(number_format(e.TotalOperatorSecondaryMarketSecurities, '0', '', ','));
										$('#spnTotalOperatorPrimaryMarketSecurities').html(number_format(e.TotalOperatorPrimaryMarketSecurities, '0', '', ','));
										
										$('#spnTotalOperatorDayMarketValue').html(number_format('₦' + e.TotalOperatorDayMarketValue, '2', '.', ','));
										$('#spnTotalOperatorTotalMarketValue').html('₦' + number_format(e.TotalOperatorTotalMarketValue, '2', '.', ','));
										
									}else  if (Usertype.toLowerCase() == 'gallery')
									{
										$('#spnTotalGalleryListedSecurities').html(number_format(e.TotalGalleryListedSecurities, '0', '', ','));
										$('#spnTotalGalleryPrimaryMarketSecurities').html(number_format(e.TotalGalleryPrimaryMarketSecurities, '0', '', ','));
										
										$('#spnTotalGalleryApprovedSecurities').html(number_format(e.TotalGalleryApprovedSecurities, '0', '', ','));
										$('#spnTotalGalleryListedSecuritiesAwaitingApproval').html(number_format(e.TotalGalleryListedSecuritiesAwaitingApproval, '0', '', ','));
										
										$('#spnTotalGalleryDayMarketValue').html('₦' + number_format(e.TotalGalleryDayMarketValue, '2', '.', ','));
										$('#spnTotalGalleryTotalMarketValue').html('₦' + number_format(e.TotalGalleryTotalMarketValue, '2', '.', ','));
										
									}
									
									
									return;
								});//End each
							}
						},
						error:  function(xhr,status,error) {
							$.unblockUI();
							m='Error '+ xhr.status + ' Occurred: ' + error;
							alert(m);
						}
					});
				}catch(e)
				{
					$.unblockUI();
					m='LoadSummary ERROR:\n'+e;
					alert(m);
				}
			}
        });
    </script>
    <style type="text/css">
    	. {
		    background-color: #e2e2e9 !important;
		    color: black !important;
		}
		.yellowtext {
		    color: #757573 !important;
		}
		.text-white {
		    color: #131010 !important;
		}
    </style>
        
</head>
<body>


<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    <?php include('dheader.php'); //Dashboard Header ?>
    
    
    <div class="app-main">
          	<?php include('sidemenu.php'); //Side Menu ?>
            
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div>
                                    <div class="page-title-head center-elem">
                                        <span class="d-inline-block pr-2">
                                            <i class="lnr-apartment opacity-6"></i>
                                        </span>
                                        <span class="d-inline-block">Dashboard</span>
                                    </div>                                   
                                </div>
                            </div>
                               </div>
                    </div>            
                    
                    <div class="tabs-animation">
					 <?php
                        if (trim(strtolower($usertype))=='admin')
                        {
                            echo '
							  <div class="row">
								<div class="col-md-4 col-xl-4">									
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Trade Orders</div>
												<div class="widget-subheading size-14">Total Trade Orders</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalAdminTradeOrders">'.number_format($TotalAdminTradeOrders,0).'</span></div>
											</div>
										</div>
									</div>
								</div>								
											   
								<div class="col-md-4 col-xl-4">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Listed Assets</div>
												<div class="widget-subheading size-14">Total No Of Listed Assets</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalAdminListedSecurities">'.number_format($TotalAdminListedSecurities,0).'</span></div>
											</div>
										</div>
									</div> 
								</div>                      
							</div>	
							';
							
							
							//Row 2 - Secondary Trades/Primary Trades
							echo '
							  <div class="row">
								<div class="col-md-6 col-xl-4">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Secondary Trades</div>
												<div class="widget-subheading size-14">Total No Of Secondary Trades</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalAdminSecondaryTrades">'.number_format($TotalAdminSecondaryTrades,0).'</span></div>
											</div>
										</div>
									</div>
								</div>								
								
								
								<div class="col-md-6 col-xl-4">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Primary Trades</div>
												<div class="widget-subheading size-14">Total No Of Primary Trades</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalAdminPrimaryTrades">'.number_format($TotalAdminPrimaryTrades,0).'</span></div>
											</div>
										</div>
									</div>									
								</div>								                         
							</div>	
							';
							
							
							//Row 3 - Securties In Secondary Trades/Assets Primary Trades
							echo '
							  <div class="row">
								<div class="col-md-6 col-xl-4">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Secondary Trade Assets</div>
												<div class="widget-subheading size-14">Total No Of Assets In Secondary Market</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalAdminSecondaryMarketSecurities">'.number_format($TotalAdminSecondaryMarketSecurities,0).'</span></div>
											</div>
										</div>
									</div>									
								</div>
								
								
								<div class="col-md-6 col-xl-4">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Primary Market Assets</div>
												<div class="widget-subheading size-14">Total No Of Assets In Primary Market</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalAdminPrimaryMarketSecurities">'.number_format($TotalAdminPrimaryMarketSecurities,0).'</span></div>
											</div>
										</div>
									</div>
								</div>								                           
							</div>	
							';
							
							
							//Row 4 - Approved Assets/Assets Awaiting Approval
							echo '
							  <div class="row">
								<div class="col-md-6 col-xl-4">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Approved Assets</div>
												<div class="widget-subheading size-14">Total No Of Approved Assets</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalAdminApprovedSecurities">'.number_format($TotalAdminApprovedSecurities,0).'</span></div>
											</div>
										</div>
									</div>
								</div>												
								
								<div class="col-md-6 col-xl-4">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Assets Awaiting Approval</div>
												<div class="widget-subheading size-14">Total No Of Assets Awaiting Approval</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalAdminListedSecuritiesAwaitingApproval">'.number_format($TotalAdminListedSecuritiesAwaitingApproval,0).'</span></div>
											</div>
										</div>
									</div>
								</div> 
								                          
							</div>	
							';
							
							
							//Row 5 - Day Total Market Value/Total Market Value
							echo '
							  <div class="row">
								<div class="col-md-6 col-xl-4">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Day Market Value</div>
												<div class="widget-subheading size-14">Total Day Market Value</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalAdminDayMarketValue">₦'.number_format($TotalAdminDayMarketValue,2).'</span></div>
											</div>
										</div>
									</div>
								</div>
														   
								
								<div class="col-md-6 col-xl-4">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Market Value</div>
												<div class="widget-subheading size-14">Total Market Value</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalAdminTotalMarketValue">₦'.number_format($TotalAdminTotalMarketValue,2).'</span></div>
											</div>
										</div>
									</div>
								</div>  
								                 
							</div>
							
							<div class="row">
								<div class="col-md-6 col-xl-6">&nbsp;</div>
								<div class="col-md-6 col-xl-6">&nbsp;</div> 
							</div>
							<div class="row">
								<div class="col-md-6 col-xl-6">&nbsp;</div>
								<div class="col-md-6 col-xl-6">&nbsp;</div> 
							</div>
						  ';
						}
						
						
						//Operator
						if (trim(strtolower($usertype))=='operator')
						{
							echo '
							  <div class="row">
								<div class="col-md-6 col-xl-6">									
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Trade Orders</div>
												<div class="widget-subheading size-14">Total Trade Orders</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalOperatorTradeOrders">'.number_format($TotalOperatorTradeOrders,0).'</span></div>
											</div>
										</div>
									</div>
								</div>
																			
								<div class="col-md-6 col-xl-6">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Listed Assets</div>
												<div class="widget-subheading size-14">Total No Of Listed Assets</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalOperatorListedSecurities">'.number_format($TotalOperatorListedSecurities,0).'</span></div>
											</div>
										</div>
									</div>
								</div>                           
							</div>	
							';
							
							
							//Row 2 - Secondary Trades/Primary Trades
							echo '
							  <div class="row">
								<div class="col-md-6 col-xl-6">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Secondary Trades</div>
												<div class="widget-subheading size-14">Total No Of Secondary Trades</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalOperatorSecondaryTrades">'.number_format($TotalOperatorSecondaryTrades,0).'</span></div>
											</div>
										</div>
									</div>
								</div>								
								
								
								<div class="col-md-6 col-xl-6">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Primary Trades</div>
												<div class="widget-subheading size-14">Total No Of Primary Trades</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalOperatorPrimaryTrades">'.number_format($TotalOperatorPrimaryTrades,0).'</span></div>
											</div>
										</div>
									</div>
								</div>                           
							</div>	
							';
							
							
							//Row 3 - Assets In Secondary Trades/Assets Primary Trades
							echo '
							  <div class="row">
								<div class="col-md-6 col-xl-6">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Secondary Trade Assets</div>
												<div class="widget-subheading size-14">Total No Of Assets In Secondary Market</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalOperatorSecondaryMarketSecurities">'.number_format($TotalOperatorSecondaryMarketSecurities,0).'</span></div>
											</div>
										</div>
									</div>
								</div>
										
								<div class="col-md-6 col-xl-6">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Primary Market Assets</div>
												<div class="widget-subheading size-14">Total No Of Assets In Primary Market</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalOperatorPrimaryMarketSecurities">'.number_format($TotalOperatorPrimaryMarketSecurities,0).'</span></div>
											</div>
										</div>
									</div>
								</div>                           
							</div>	
							';
							
							
							//Row 4 - Day Total Market Value/Total Market Value
							echo '
							  <div class="row">
								<div class="col-md-6 col-xl-6">									
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Day Market Value</div>
												<div class="widget-subheading size-14">Total Day Market Value</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalOperatorDayMarketValue">₦'.number_format($TotalOperatorDayMarketValue,2).'</span></div>
											</div>
										</div>
									</div>
								</div>
											
								
								<div class="col-md-6 col-xl-6">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Market Value</div>
												<div class="widget-subheading size-14">Total Market Value</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalOperatorTotalMarketValue">₦'.number_format($TotalOperatorTotalMarketValue,2).'</span></div>
											</div>
										</div>
									</div>
								</div>                           
							</div>	
							
							<div class="row">
								<div class="col-md-6 col-xl-6">&nbsp;</div>
								<div class="col-md-6 col-xl-6">&nbsp;</div> 
							</div>
							<div class="row">
								<div class="col-md-6 col-xl-6">&nbsp;</div>
								<div class="col-md-6 col-xl-6">&nbsp;</div> 
							</div>
							';
						}
						
						
						//Gallery
						if (trim(strtolower($usertype))=='gallery')
                        {
							echo '
							  <div class="row">
								<div class="col-md-6 col-xl-6">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Listed Assets</div>
												<div class="widget-subheading size-14">Total No Of Listed Assets</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalGalleryListedSecurities">'.number_format($TotalGalleryListedSecurities,0).'</span></div>
											</div>
										</div>
									</div>
								</div>

								
								<div class="col-md-6 col-xl-6">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Primary Market Assets</div>
												<div class="widget-subheading size-14">Total No Of Assets In Primary Market</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalGalleryPrimaryMarketSecurities">'.number_format($TotalGalleryPrimaryMarketSecurities,0).'</span></div>
											</div>
										</div>
									</div>
								</div>                           
							</div>	
							';
							
							
							//Row 2 - Approved Assets/Assets Awaiting Approval
							echo '
							  <div class="row">
								<div class="col-md-6 col-xl-6">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Approved Assets</div>
												<div class="widget-subheading size-14">Total No Of Approved Assets</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalGalleryApprovedSecurities">'.number_format($TotalGalleryApprovedSecurities,0).'</span></div>
											</div>
										</div>
									</div>
								</div>
														   
								
								<div class="col-md-6 col-xl-6">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Assets Awaiting Approval</div>
												<div class="widget-subheading size-14">Total No Of Assets Awaiting Approval</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalGalleryListedSecuritiesAwaitingApproval">'.number_format($TotalGalleryListedSecuritiesAwaitingApproval,0).'</span></div>
											</div>
										</div>
									</div>
								</div>                           
							</div>	
							';
							
							
							//Row 3 - Securties In Secondary Trades/Assets Primary Trades
							echo '
							  <div class="row">
								<div class="col-md-6 col-xl-6">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Day Market Value</div>
												<div class="widget-subheading size-14">Total Day Market Value</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalGalleryDayMarketValue">₦'.number_format($TotalGalleryDayMarketValue,2).'</span></div>
											</div>
										</div>
									</div>
								</div>
																					
								<div class="col-md-6 col-xl-6">
									<div class="card mb-3 widget-content ">
										<div class="widget-content-wrapper text-white">
											<div class="widget-content-left">
												<div class="widget-heading text-uppercase yellowtext size-18">Market Value</div>
												<div class="widget-subheading size-14">Total Market Value</div>
											</div>
											<div class="widget-content-right">
												<div class="widget-numbers text-white"><span id="spnTotalGalleryTotalMarketValue">₦'.number_format($TotalGalleryTotalMarketValue,2).'</span></div>
											</div>
										</div>
									</div>
								</div>                           
							</div>	
							
							<div class="row">
								<div class="col-md-6 col-xl-6">&nbsp;</div>
								<div class="col-md-6 col-xl-6">&nbsp;</div> 
							</div>
							<div class="row">
								<div class="col-md-6 col-xl-6">&nbsp;</div>
								<div class="col-md-6 col-xl-6">&nbsp;</div> 
							</div>
							';	
						}
                        				
					  ?>
                         <!--Cards End-->
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
