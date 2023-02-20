<div class="modal-content-custom">
                <div class="overlay-content">
                    <svg class="icon-close" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 1L1 17M17 17L1 1" stroke="#CFCFCF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <div class="logo-otr">
                        <a href="#" class="logo-inr">
                            <img class="logo" style="min-height: 70px; min-width: 160px;" src="<?php echo base_url(); ?>/newassets/img/naija_art_mart1.png" alt="brand-logo">
                        </a>
                    </div>
                    <div class="navigation-otr">
                        <?php if ($logged_in) {?>
                        
                        <ul class="navigation-inr">
                            <li class="nav-li">
                                <a href="#" class="nav-a heading-h4 home">Dashboard</a>
                            </li>
                            <li class="nav-li">
                                <a class="nav-a heading-h4 explore">Market</a>
                                <ul class="dropdown-otr drop-2">
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
                                <a href="<?php echo site_url(); ?>ui/Portfolio" class="nav-a heading-h4">Port Folio</a>
                            </li>
                            <li class="nav-li">
                                <a href="<?php echo site_url(); ?>ui/Wallet" class="nav-a heading-h4 pages">Wallet</a>
                            </li>
                            <li class="nav-li">
                                <a href="<?php echo site_url(); ?>ui/Messages" class="nav-a heading-h4 community">Messages</a>
                            </li>
                        </ul>
                        <?php }else { ?>
                            <ul class="navigation-inr">
                                <li class="nav-li">
                                    <a href="<?php echo site_url('ui/Home'); ?>" class="nav-a body-sb home" style="<?php echo ($route == 'home' || $route == '')? 'color: #366CE3 !important': ''; ?>">Home</a>
                                </li>
                                <li class="nav-li">
                                    <a href="<?php echo site_url('ui/Ourstory'); ?>" class="nav-a body-sb" style="<?php echo ($route == 'about')? 'color: #366CE3 !important': ''; ?>">Our Story</a>
                                </li>
                                <li class="nav-li">
                                    <a href="<?php echo site_url('ui/Howitworks'); ?>" class="nav-a body-sb" style="<?php echo ($route == 'process')? 'color: #366CE3 !important': ''; ?>">How it works</a>
                                </li>
                                <li class="nav-li" >
                                    <a href="<?php echo site_url('ui/Aboutus'); ?>" class="nav-a body-sb pages" style="<?php echo ($route == 'contact')? 'color: #366CE3 !important': ''; ?>">Contact Us</a>
                                </li>
                                <li class="nav-li">
                                    <a class="nav-a body-sb community">Community</a>
                                    <ul class="dropdown-otr drop-5">
                                        <li class="dropdown-li">
                                            <a href="<?php echo site_url('ui/Faq'); ?>" class="dropdown-a body-sb" style="<?php echo ($route == 'faq')? 'color: #366CE3 !important': ''; ?>">Frequently Asked Questions</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        <?php } ?>
                    </div>
                    <div class="action-otr">
                        <?php 
                        if (!$logged_in) { ?>
                            <a href="<?php echo site_url('ui/Login'); ?>" class="btn btn-create " style="margin-right: 2px;">Sign In</a>
                            <a href="<?php echo site_url('ui/Signup'); ?>" class="btn-fill btn-outline1 btn-wallet" >Get Started</a>
                            <?php  
                        } else {?>
                            <a href="#" class="btn-fill btn-create">Profile</a>
                            <a href="#" class="btn-outline1 btn-wallet">Sign Out</a>
                        <?php }?>
                        
                    </div>
                    
                </div>
            </div>