 <script>
 	$(document).ready(function(e) {
		var targetleft=$('#divTarget').offset().left;
		var marqueeleft= $('#.simple-marquee-container');
		var sidebar=280;
		var status=150
		var utype=280;
		var doc=$(document).width();
		
		var wd=doc-sidebar-status-utype;
		
		$('#.simple-marquee-container').css('width',wd);
		//alert(wd);
		
	   
        $('#btnSideMenuLogo').click(function(e) 
		{
			 var src=document.getElementById("imgSideMenu").src;
			 
			 if (src.indexOf("smallheader.png") != -1)
			 {
				 document.getElementById("imgSideMenu").src="<?php echo base_url(); ?>images/logo-60x60.png";
			 }else if (src.indexOf("logo-60x60.png") != -1)
			 {
				 document.getElementById("imgSideMenu").src="<?php echo base_url(); ?>images/smallheader.png";
			 }
        });
					
    });
	
	function LogOut()
	{
		try
		{
			var m="Signing out will abort every active process and unsaved data will be lost. Do you still want to sign out?";
			
			Swal.fire({
			  title: 'Confirm Signout!',
			  text: m,
			  type: 'question',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  cancelButtonText: 'NO',
			  confirmButtonText: 'YES'
			}).then((result) => {
				if (result.value) window.location.href='<?php echo site_url('admin/Signout'); ?>';
			})	
		}catch(e)
		{
	
		}			
	}
	
 </script>
 <style type="text/css">
 	.logo-src {
		background-repeat: no-repeat !important;
	}
 </style>
 <div class="app-header header-shadow header-text-dark" style="color:darkgray !important;">
        <div class="app-header__logo">
            <div class="logo-src"></div>
            <div class="header__pane ml-auto">
                <div>
                    <button id="btnSideMenuLogo" type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="app-header__mobile-menu">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
        <div class="app-header__menu">
            <span>
                <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                    <span class="btn-icon-wrapper">
                        <i class="fa fa-ellipsis-v fa-w-6"></i>
                    </span>
                </button>
            </span>
        </div>    <div class="app-header__content">
            <div class="app-header-left">
 <?php
 		/*if ($SetParameters==1)
		{
			echo '
					
					<ul class="header-megamenu nav">
						<li class="nav-item">
							<a href="javascript:void(0);" data-placement="bottom" rel="popover-focus" data-offset="300" data-toggle="popover-custom" class="nav-link">
								<i class="nav-link-icon fa fa-cogs"> </i>
								General&nbsp;Settings
								<i class="fa fa-angle-down ml-2 opacity-5"></i>
							</a>
							<div class="rm-max-width">
								<div class="d-none popover-custom-content">
									<div class="dropdown-mega-menu">
										<div class="grid-menu grid-menu-3col">
											<div class="no-gutters row">
						';
						
									if ($SetMarketParameters==1)
									{
										echo '<div class="col-sm-6 col-xl-4">';
									}else
									{
										echo '<div class="col-sm-6 col-xl-6">';
									}				
								
								echo '	
													<ul class="nav flex-column">
														<li class="nav-item-header nav-item">
															Market Parameters
														</li>
														<li class="nav-item">
															<a href="'.site_url('admin/Tradingsettings').'" class="nav-link">
																<span>
																	Trading Parameters
																</span>
															</a>
														</li>
														<li class="nav-item">
															<a href="'.site_url('admin/Ordertypes').'" class="nav-link">
																<span>
																	Define Market Orders
																</span>
															</a>
														</li>
													</ul>
												</div>
							';
								
							
									if (($ViewOrders==1) or ($ViewOffers==1))
									{
										echo '<div class="col-sm-6 col-xl-4">';
									}else
									{
										echo '<div class="col-sm-6 col-xl-6">';
									}
									
									if (($ViewOrders==1) or ($ViewOffers==1))
									{
										echo '												
											<ul class="nav flex-column">
												<li class="nav-item-header nav-item">Trading
												</li>
												<li class="nav-item">
													<a href="javascript:void(0);" class="nav-link">View Trades
													</a>
												</li>
												
												<li class="nav-item">
													<a href="javascript:void(0);" class="nav-link">Process/Approve Listing
													</a>
												</li>
										';	
									}
				
		echo '	
													</ul>
												</div>';
												
												
												if ($CreateAccount==1)
												{				
													echo '
														<div class="col-sm-6 col-xl-4">
															<ul class="nav flex-column">
																<li class="nav-item-header nav-item">
																	Dealing Members
																</li>
																<li class="nav-item">
																	<a href="'.site_url('admin/Registerbroker').'" class="nav-link">
																		Register Broker 
																	</a>
																</li>
															</ul>
														</div>
													';
												}
					echo '								
												
											</div>
										</div>
									</div>
								</div>
							</div>
						</li>
					
					</ul>
				';	
		}
 		*/
 ?>      
             </div>
             
              
            <div class="app-header-left" style="width:100%; background:transparent;">                 
            	<span id="spnP" class="whitetext size-12 makebold" style="padding-right:10px; text-transform:uppercase;color:gray !important">
              			Market&nbsp;Status:&nbsp;&nbsp;<span id="spnMarketStatus"><?php if (trim(strtoupper($_SESSION['MarketStatus'])) == 'OPEN') echo '<font color="#82E99B">'.$_SESSION['MarketStatus'].'</font>'; else echo '<font color="#FF5858">'.$_SESSION['MarketStatus'].'</font>'; ?></span>
              	 </span>
                 
              	<!--<div id="idMarquee" onMouseOver="this.classList.add('pause');" onMouseOut="this.classList.remove('pause');" class="marquee size-12" style="background:transparent; color:#F1EA93; margin-right:10px; "><?php //echo $ScrollingPrices; ?></div>-->
                
                <div class="simple-marquee-container size-12" style="background:transparent; color:#F1EA93; margin-right:10px;line-height:35px " id="idMarquee">
					<div class="marquee"><?php echo $ScrollingPrices; ?></div>
                </div>
             </div>
           
                    
            <div id="divTarget" class="app-header-right">
            	<!--Start Notiicationa-->
            	<div class="header-dots">
                    <div id="adminAlert" title="" class="dropdown">
                    	 
                            <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                                <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                    <span class="icon-wrapper-bg bg-danger"></span>
                                    <i class="icon text-danger icon-anim-pulse ion-android-notifications"></i>
                                    <span id="adminMsgCount" class="badge badge-dot badge-dot-sm badge-danger"></span>
                                </span>
                            </button>
                                      
                        
                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right" >
                                <div class="dropdown-menu-header mb-0">
                                    <div class="dropdown-menu-header-inner bg-deep-blue">
                                        <div class="menu-header-image opacity-1" style="background-image: url('<?php echo base_url(); ?>assets/images/dropdown-header/city3.jpg');"></div>
                                        <div class="menu-header-content text-dark">
                                            <h6 class="menu-header-subtitle redalerttext makebold" id="adminMsgHeader"></h6>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab-messages-header" role="tabpanel">
                                        <div class="scroll-area-sm" style="height:350px;">
                                            <div class="scrollbar-container">
                                                <div class="p-3">
                                                    <div id="adminMessages" class="notifications-box">
                                                        <!--Messages Here-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                 </div><!--End Notifications-->
                 
                 
                 
                <div class="header-btn-lg pr-0">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="btn-group">
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                        <img width="42" class="rounded-circle" src="<?php echo base_url(); ?>assets/images/avatars/1.jpg" alt="">
                                        <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                    </a>
                                    <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-menu-header">
                                            <div class="dropdown-menu-header-inner bg-info">
                                                <div class="menu-header-image opacity-10" style="background-image: url('<?php echo base_url(); ?>assets/images/dropdown-header/abstract7.jpg');"></div>
                                                <div class="menu-header-content text-left">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <img width="42" class="rounded-circle"
                                                                     src="<?php echo base_url(); ?>assets/images/avatars/1.jpg"
                                                                     alt="">
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div style="color:#600;" class="widget-heading"><?php echo $fullname; ?>
                                                                </div>
                                                                <div style="color:#ff0;" class="widget-subheading opacity-9"><?php echo $usertype; ?>
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-right mr-2">
                                                                <a onClick="LogOut();" href="#" class="btn-pill btn-shadow btn-shine btn btn-focus">Logout
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="scroll-area-xs" style="height:auto;">
                                            <div class="scrollbar-container ps">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a href="<?php echo site_url('admin/Profile'); ?>" class="nav-link">Update Profile
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div title="<?php echo $fullname; ?> User" class="widget-content-left  ml-3 header-user-info">
                                <div class="widget-heading">
                                    <?php //echo $fullname; ?>
                                </div>
                                <div class="widget-subheading">
                                    <?php echo $usertype; ?>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </div>   