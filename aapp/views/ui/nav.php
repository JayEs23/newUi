            <header class="navbar" style="padding: 2px !important;">
                <div class="container-fluid">
                    <div class="navbar-inr">
                        <div class="logo-main">
                            <a href="<?php echo site_url('ui/Home') ?>" class="logo-otr">
                                <img class="logo" style="padding: 2px; margin: 4px;min-height: 70px; min-width: 160px;" src="<?php echo base_url(); ?>/newassets/img/naija_art_mart1.png"alt="Logo">
                            </a>
                        </div>
                        <div class="navigation-otr">
                            <?php
                                if ($logged_in) {
                            ?>
                            <ul class="navigation-inr">
                                <li class="nav-li">
                                <?php
                                if (trim(strtolower($usertype))=='broker'){?>
                                  <a class="nav-a body-sb home" href="<?php echo site_url('ui/Dashboard') ?>">
                                 <?php }elseif ((trim(strtolower($usertype))=='issuer') or (trim(strtolower($usertype))=='investor')){ ?>
                                  <a class="nav-a body-sb home" href="<?php echo site_url('ui/Dashboardiv') ?>">
                                    <?php } ?>Dashboard
                                  </a>
                                </li>
                                <?php if ($usertype == 'Issuer') {?>
                                   <li class="nav-li">
                                        <a href="<?php echo site_url(); ?>ui/Primarytradehistory" class="nav-a body-sb pages">Primary Trade History</a>
                                    </li>
                                    <li class="nav-li">
                                        <a href="<?php echo site_url('ui/Requestlisting'); ?>" class="nav-a body-sb">Request For Listing</a>
                                    </li>
                                
                                <?php } else { ?>
                                <li class="nav-li">
                                    <a class="nav-a body-sb pages">Markets</a>
                                    <ul class="dropdown-otr drop-3">
                                        <li class="dropdown-li">
                                            <?php
                                            if (trim(strtolower($usertype))=='broker'){?>
                                              <a class="dropdown-a body-sb home" href="<?php echo site_url('ui/Primarymarket') ?>">
                                             <?php }elseif ((trim(strtolower($usertype))=='issuer') or (trim(strtolower($usertype))=='investor')){ ?>
                                              <a class="dropdown-a body-sb home" href="<?php echo site_url('ui/Directinvestorprymarket') ?>">
                                                <?php } ?>Primary Market</a>
                                            
                                        </li>
                                        <li class="dropdown-li">
                                            <?php
                                            if (trim(strtolower($usertype))=='broker'){?>
                                              <a class="dropdown-a body-sb home" href="<?php echo site_url('ui/Directexchange') ?>">
                                             <?php }elseif ((trim(strtolower($usertype))=='issuer') or (trim(strtolower($usertype))=='investor')){ ?>
                                              <a class="dropdown-a body-sb home" href="<?php echo site_url('ui/Directinvestorsecmarket') ?>">
                                                <?php } ?>Secondary Market</a>
                                            
                                        </li> 
                                        
                                        
                                    </ul>
                                </li> 
                                <li class="nav-li">
                                    <a href="<?php echo site_url(); ?>ui/Portfolio" class="nav-a body-sb">Portfolio</a>
                                </li>
                                <li class="nav-li">
                                    <a href="<?php echo site_url(); ?>ui/Wallet" class="nav-a body-sb">Wallet</a>
                                </li>
                                <?php } ?>                               
                                <li class="nav-li">
                                    <a href="<?php echo site_url(); ?>ui/Messages" class="nav-a body-sb">Messages</a>
                                </li>
                                
                                
                                <!-- <li class="nav-li">
                                    <a class="nav-a body-sb pages">Reports</a>
                                    <ul class="dropdown-otr drop-3">
                                    <?php if ($usertype == 'Issuer') { ?>
                                        <li class="dropdown-li">
                                            <a href="<?php echo site_url('ui/Listingrep') ?>" class="dropdown-a body-mb">Listings Report</a>
                                        </li>
                                        <li class="dropdown-li">
                                            <a href="<?php echo site_url('ui/Primarytradesrep') ?>" class="dropdown-a body-mb">Primary Trades</a>
                                        </li>
                                    
                                    <?php } else { ?>
                                        <li class="dropdown-li">
                                            <a href="<?php echo site_url('ui/Listingrep') ?>" class="dropdown-a body-mb">Listings Report</a>
                                        </li>
                                        <li class="dropdown-li">
                                            <a href="<?php echo site_url('ui/Primarytradesrep') ?>" class="dropdown-a body-mb">Primary Trades</a>
                                        </li>
                                    <?php }
                                     ?>                                       
                                    </ul>
                                </li> -->
                                
                            </ul>
                            <?php
                                }else{
                            ?>
                            <ul class="navigation-inr">
                                <li class="nav-li">
                                    <a href="<?php echo site_url('ui/Home'); ?>" class="nav-a body-sb home" style="<?php echo ($route == 'home' || $route == '')? 'color: #366CE3 !important': ''; ?>">Home</a>
                                </li>
                                <!-- <li class="nav-li">
                                    <a href="../../explore" class="nav-a body-sb explore" style="<?php echo ($route == 'explore')? 'color: #366CE3 !important': ''; ?>">Explore</a>
                                </li> -->
                                <li class="nav-li">
                                    <a href="#" class="nav-a body-sb" style="<?php echo ($route == 'about')? 'color: #366CE3 !important': ''; ?>">Our Story</a>
                                    <!-- <a href="<?php echo site_url('ui/Ourstory'); ?>" class="nav-a body-sb" style="<?php echo ($route == 'about')? 'color: #366CE3 !important': ''; ?>">Our Story</a> -->
                                </li>
                                <li class="nav-li">
                                    <a href="#" class="nav-a body-sb" style="<?php echo ($route == 'process')? 'color: #366CE3 !important': ''; ?>">How it works</a>
                                    <!-- <a href="<?php echo site_url('ui/Howitworks'); ?>" class="nav-a body-sb" style="<?php echo ($route == 'process')? 'color: #366CE3 !important': ''; ?>">How it works</a> -->
                                </li>
                                <li class="nav-li" >
                                    <a href="#" class="nav-a body-sb pages" style="<?php echo ($route == 'contact')? 'color: #366CE3 !important': ''; ?>">Contact Us</a>
                                    <!-- <a href="<?php echo site_url('ui/Aboutus'); ?>" class="nav-a body-sb pages" style="<?php echo ($route == 'contact')? 'color: #366CE3 !important': ''; ?>">Contact Us</a> -->
                                </li>
                                <li class="nav-li">
                                    <a class="nav-a body-sb community">Community</a>
                                    <ul class="dropdown-otr drop-5">
                                        <li class="dropdown-li">
                                            <a href="#" class="dropdown-a body-sb" style="<?php echo ($route == 'faq')? 'color: #366CE3 !important': ''; ?>">Frequently Asked Questions</a>
                                            <!-- <a href="<?php echo site_url('ui/Faq'); ?>" class="dropdown-a body-sb" style="<?php echo ($route == 'faq')? 'color: #366CE3 !important': ''; ?>">Frequently Asked Questions</a> -->
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                            <?php
                                }
                            ?>
                            
                        </div>
                              
                        <div class="action-otr">
                            <div class="action">
                                <?php if (!$logged_in) { ?>
                                <a href="<?php echo site_url('ui/Login'); ?>" class="btn btn-outline1 dropdown-a body-mb" style="margin-right: 2px;">Sign In</a>
                                <a href="<?php echo site_url('ui/Signup'); ?>" class="btn-fill btn-create body-mb" >Get Started</a>
                                <?php  
                                } else {?>
                                <!-- <?php if($usertype == 'Investor'){?>
                                <a class="btn btn-sm body-mb"  href="site_url('ui/Wallet')" style="padding-bottom:0; padding-top:10px; padding-right:4px; width:100%;">
                                    <span style="color:lightgray;" >Wallet: </span> 
                                    <span class="makebold size-15" style="color:lightgray;">₦ 
                                        <span style="top:0;" id="uiWalletBalance"> <?php echo number_format($balance,2) ?>
                                        </span>
                                    </span>
                                </a> 
                                <?php }?> -->
                                
                                <a href="<?php echo (trim(strtolower($usertype)) == 'broker') ? site_url('ui/Userprofile') : site_url('ui/userprofileiv'); ?>" class="btn btn-outline1 body-mb" style="margin-right: 2px;"> Profile</a>
                                <a href="<?php echo site_url('ui/signout'); ?>" class=" btn btn-outline1 body-mb" >Signout</a>
                                <?php }
                                 ?>                      
                            </div>
                           
                        </div>
                        <div class="burger-menu">
                            <div class="burger-icon-otr">
                                <svg class="burger-icon" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.75 12h16.5M4 6h9M11 18h9" stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </header>