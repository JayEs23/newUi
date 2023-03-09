<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php

$logged_in = true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo base_url(); ?>/assets/images/favicon_artsquare_16x16.png" sizes="16x16">
    <title> Derived Homes | <?php echo $usertype; ?> Dashboard</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progressjs.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/fonts/fonts.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/css/app.css">
    <link rel='stylesheet' id='font-awesome-cdn-css'  href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css?ver=5.7.8' type='text/css' media='all' />
    <style type="text/css">
      .img-fluid {
          max-width: 100%;
          height: 150px;
      }
      .body-sb{
      }
    </style>
</head>
<body>


    <!--=====s==================================
                Modal Start Here
    ========================================-->

        <div id="myNav" class="overlay-content-otr">
          <?php
            include 'mobNav.php';

            ?>
        </div>

    <!--=======================================
                Modal End Here
    ========================================-->

    <!--=======================================
                Navbar/Hero Start Here
    ========================================-->

        <section class="hero-navbar-9">
            <?php
            include 'nav.php';

            ?>
            <div class="creator-main-home2">
              <div class="container-fluid" >
                  <div class="creator-main-inr">
                      <div class="heading-otr">
                        <div class="head-otr" style="display: block !important;">
                          <h3 class="heading heading-h3"><?php echo $usertype; ?> Dashboard</h3>
                            <p><?php echo $email; ?><br><span><?php echo $company ?></span></p>
                          </div>
                          <?php if($usertype == 'Investor'){?>
                                <a class="view-p view-all"  href="<?php echo site_url('ui/Wallet') ?>">
                                    <span style="color:inherit;" >Wallet Balance : &nbsp;</span> 
                                    <span class="makebold size-15" style="color:inherit;"> ₦ 
                                        <span style="top:0;" id="uiWalletBalance"> <?php echo number_format($balance,2) ?>
                                        </span>
                                    </span>
                                </a> 
                                <?php }?>
                      </div>
                      <span class="line"></span>
                      <?php if ($usertype == 'Investor') { ?>
                      <div class="popular-collection" style="padding: 0 0 30px 0 !important;">
                        <div class="container-fluid">
                          <div class="popular-collection-inr">
                            <div class="heading-otr">
                                <div class="head-otr">
                                    <h3 class="">Recent Art works</h3>
                                </div>
                            </div>
                            <span class="line"></span>
                            <div class="row-custom owl-carousel owl-theme " id="popular-artwork">
                            <?php
                            foreach ($LastestPixs as $artwork) {?>
                                <div class="col-otr">
                                    <div class="col-inr">
                                        <a href="<?php echo site_url('ui/Directinvestorprymarket/ArtworkDetails/'.$artwork->art_id) ?>" class="img-otr">
                                            <img class="img-fluid img-artwork" src="<?php echo site_url(); ?>art-works/<?php echo $artwork->pix ?>" alt="artwork-img">
                                        </a>
                                        <div class="content">
                                            <a href="<?php echo site_url('ui/Directinvestorprymarket/ArtworkDetails/'.$artwork->art_id) ?>" class="create-img">
                                                
                                                <div class="check-otr">
                                                    <svg class="check-icon" width="10" height="10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.438 2.813L4.061 7.188 1.876 5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                                </div>
                                            </a>
                                            <a href="<?php echo site_url('ui/Directinvestorprymarket/ArtworkDetails/'.$artwork->art_id) ?>" class="art-title"><?php echo $artwork->title ?></a>
                                            <a href="<?php echo site_url('ui/Directinvestorprymarket/ArtworkDetails/'.$artwork->art_id) ?>" class="by-otr "> <span class="by body-s">by</span> <?php echo $artwork->artist ?></a>
                                        </div>
                                    </div>
                                </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                      </div> <?php } ?> 

                      <span class="line"></span>
                      <div class="row row-custom">
                      <?php 
                        if (trim(strtolower($usertype))=='investor') { ?>
                          <div class="col-lg-3 col-md-3 col-sm-4 creator-otr">
                              <a href="#" class="create-inr box1">
                                  <div class="create-content">
                                    <div class="create-img">
                                      <i class="fa fa-bank" style="font-size: 60px;color: lightgray;"></i>
                                    </div>
                                      <p  class="body-sb create-p" id="spnTotalInvestorSecurities"><?php echo number_format($TotalInvestorSecurities,0) ?></p>
                                      <p class="body-sb create-pb">Total No Of Assets In Portfolio</p>
                                  </div>
                              </a>
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-4 creator-otr">
                              <a href="#" class="create-inr box1">
                                  <div class="create-content">
                                    <div class="create-img">
                                      <i class="fa fa-money" style="font-size: 60px; color: lightgray;"></i>
                                    </div>
                                      <p  class="body-s create-p" id="spnTotalInvestorSecuritiesValue"><?php echo '₦'.number_format($TotalInvestorSecuritiesValue,2) ?></p>
                                      <p class="body-sb create-pb">Total Value Of Assets In Portfolio</p>
                                  </div>
                              </a>
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-4 creator-otr">
                              <a href="#" class="create-inr box1">
                                  <div class="create-content">
                                    <div class="create-img">
                                      <i class="fa fa-exchange" style="font-size: 60px; color: lightgray;"></i>
                                    </div>
                                      <p  class="body-s create-p" id="spnTotalInvestorPrimaryTrades"><?php echo number_format($TotalInvestorPrimaryTrades,0) ?></p>
                                      <p class="body-sb create-pb">Total No Of Primary Trades</p>
                                  </div>
                              </a>
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-4 creator-otr">
                              <a href="#" class="create-inr box1">
                                  <div class="create-content">
                                    <div class="create-img">
                                      <i class="fa fa-money" style="font-size: 60px; color: lightgray;"></i>
                                    </div>
                                      <p  class="body-s create-p" id="spnTotalInvestorPrimaryTradesValue"><?php echo '₦'.number_format($TotalInvestorPrimaryTradesValue,2) ?></p>
                                      <p class="body-sb create-pb">Total Value Of Primary Trades</p>
                                  </div>
                              </a>
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-4 creator-otr">
                              <a href="#" class="create-inr box1">
                                  <div class="create-content">
                                    <div class="create-img">
                                      <i class="fa fa-tasks" style="font-size: 60px; color: lightgray;"></i>
                                    </div>
                                      <p  class="body-s create-p" id="spnTotalInvestorSellOrders"><?php echo number_format($TotalInvestorSellOrders,0) ?></p>
                                      <p class="body-sb create-pb">Total No Of Sell Orders</p>
                                  </div>
                              </a>
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-4 creator-otr">
                              <a href="#" class="create-inr box1">
                                  <div class="create-content">
                                    <div class="create-img">
                                      <i class="fa fa-money" style="font-size: 60px; color: lightgray;"></i>
                                    </div>
                                      <p  class="body-s create-p" id="spnTotalInvestorSellOrdersValue"><?php echo '₦'.number_format($TotalInvestorSellOrdersValue,2) ?></p>
                                      <p class="body-sb create-pb">Total Value Of Sell Orders</p>
                                  </div>
                              </a>
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-4 creator-otr">
                              <a href="#" class="create-inr box1">
                                  <div class="create-content">
                                    <div class="create-img">
                                      <i class="fa fa-stack-overflow" style="font-size: 60px; color: lightgray;"></i>
                                    </div>
                                      <p  class="body-s create-p" id="spnTotalInvestorExecutedSellOrders"><?php echo number_format($TotalInvestorExecutedSellOrders,0) ?></p>
                                      <p class="body-sb create-pb">Total No Of Executed Sell Orders</p>
                                  </div>
                              </a>
                          </div>
                          <div class="col-lg-3 col-md-3 col-sm-4 creator-otr">
                              <a href="#" class="create-inr box1">
                                  <div class="create-content">
                                    <div class="create-img">
                                      <i class="fa fa-credit-card" style="font-size: 60px; color: lightgray;"></i>
                                    </div>
                                      <p  class="body-s create-p" id="spnTotalInvestorExecutedSellOrdersValue"><?php echo '₦'.number_format($TotalInvestorExecutedSellOrdersValue,2) ?></p>
                                      <p class="body-sb create-pb">Total Value Of Executed Sell Orders</p>
                                  </div>
                              </a>
                          </div>
                      <?php }
                      ?>
                      <?php 
                        if (trim(strtolower($usertype))=='issuer') { ?>
                          <div class="col-lg-4 col-md-3 col-sm-4 creator-otr">
                              <a href="#" class="create-inr box1">
                                  <div class="create-content">
                                    <div class="create-img">
                                      <i class="fa fa-list-alt" style="font-size: 60px; color: lightgray;"></i>
                                    </div>
                                      <p  class="body-s create-p" id="spnTotalIssuerListedSecurities"><?php echo number_format($TotalIssuerListedSecurities,0) ?></p>
                                      <p class="body-sb create-pb">Total No Of Listed Assets</p>
                                  </div>
                              </a>
                          </div>
                          <div class="col-lg-4 col-md-3 col-sm-4 creator-otr">
                              <a href="#" class="create-inr box1">
                                  <div class="create-content">
                                    <div class="create-img">
                                      <i class="fa fa-money" style="font-size: 60px; color: lightgray;"></i>
                                    </div>
                                      <p  class="body-s create-p" id="spnTotalIssuerListedSecuritiesValue"><?php echo '₦'.number_format($TotalIssuerListedSecuritiesValue,2) ?></p>
                                      <p class="body-sb create-pb">Total Listed Asset Value</p>
                                  </div>
                              </a>
                          </div>
                          <div class="col-lg-4 col-md-3 col-sm-4 creator-otr">
                              <a href="#" class="create-inr box1">
                                  <div class="create-content">
                                    <div class="create-img">
                                      <i class="fa fa-list-alt" style="font-size: 60px; color: lightgray;"></i>
                                    </div>
                                      <p  class="body-s create-p" id="spnTotalIssuerExecutedPrimaryTrades"><?php echo number_format($TotalIssuerExecutedPrimaryTrades,0) ?></p>
                                      <p class="body-sb create-pb">Total No Of Executed Primary Trades</p>
                                  </div>
                              </a>
                          </div>
                          <div class="col-lg-4 col-md-3 col-sm-4 creator-otr">
                              <a href="#" class="create-inr box1">
                                  <div class="create-content">
                                    <div class="create-img">
                                      <i class="fa fa-list-alt" style="font-size: 60px; color: lightgray;"></i>
                                    </div>
                                      <p  class="body-s create-p" id="spnTotalIssuerExecutedPrimaryTradesValue"><?php echo '₦'.number_format($TotalIssuerExecutedPrimaryTradesValue,2) ?></p>
                                      <p class="body-sb create-pb">Amount From Total No Of Executed Primary Trades</p>
                                  </div>
                              </a>
                          </div>
                          <div class="col-lg-4 col-md-3 col-sm-4 creator-otr">
                              <a href="#" class="create-inr box1">
                                  <div class="create-content">
                                    <div class="create-img">
                                      <i class="fa fa-list-alt" style="font-size: 60px; color: lightgray;"></i>
                                    </div>
                                      <p  class="body-s create-p" id="spnTotalIssuerCurrentlyListedSecurities"><?php echo number_format($TotalIssuerCurrentlyListedSecurities,0) ?></p>
                                      <p class="body-sb create-pb">Total No Of Currently Active Listings</p>
                                  </div>
                              </a>
                          </div>
                          <div class="col-lg-4 col-md-3 col-sm-4 creator-otr">
                              <a href="#" class="create-inr box1">
                                  <div class="create-content">
                                    <div class="create-img">
                                      <i class="fa fa-credit-card" style="font-size: 60px; color: lightgray;"></i>
                                    </div>
                                      <p  class="body-s create-p" id="spnTotalIssuerCurrentlyListedSecuritiesValue"><?php echo '₦'.number_format($TotalIssuerCurrentlyListedSecuritiesValue,2) ?></p>
                                      <p class="body-sb create-pb">Total Currently Active Listings Value</p>
                                  </div>
                              </a>
                          </div>
                      <?php }
                      ?>
                      </div>
                  </div>
              </div>
          </div>

            
       </section>

        <div class="copy-otr-home2">
            <div class="container-fluid">
                <div class="copy-inr">
                    <a href="#" class="logo-otr">
                        <img class="logo" style="min-height: 40px; min-width: 30px; border-radius: 16px;" src="<?php echo base_url(); ?>/newassets/img/naija_art_mart1.png"  alt="brand-logo">
                    </a>
                    <div class="copy-name body-s">
                        Copyright © <?php echo date('Y') ?>  <a href="#" target="_blank" class="name body-sb">Naija Art Mart.</a>
                    </div>
                    <div class="all-rights">
                        <p class="all body-s">
                            All rights reserved.
                        </p>
                    </div>
                </div>
            </div>    
        </div>

    <!--=======================================
            Copy Section End Here
    ========================================-->

    <script src="<?php echo base_url(); ?>/newassets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/jquery.countdown/jquery.countdown.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/tilt.js/dest/tilt.jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progress.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/js/app.js"></script>

    <script>
    var Title='Naija Art Mart Help';
    var m='';
    var Email='<?php echo $email; ?>';
    var Usertype='<?php echo trim($usertype); ?>';
    var IssuerId='<?php echo $issuer_id; ?>';
    var RefreshInterval=1;
    RefreshInterval=parseInt(RefreshInterval,10) * 60 * 250;
  
    $(document).ready(function(e) {
      
      $('#spnTotalIssuerListedSecurities').css('font-weight','bold');                 
      $('#spnTotalIssuerListedSecuritiesValue').css('font-weight','bold');      
      $('#spnTotalIssuerExecutedPrimaryTrades').css('font-weight','bold');      
      $('#spnTotalIssuerExecutedPrimaryTradesValue').css('font-weight','bold');     
      $('#spnTotalIssuerCurrentlyListedSecurities').css('font-weight','bold');      
      $('#spnTotalIssuerCurrentlyListedSecuritiesValue').css('font-weight','bold');
      
      $('#spnTotalInvestorSecurities').css('font-weight','bold');                 
      $('#spnTotalInvestorSecuritiesValue').css('font-weight','bold');      
      $('#spnTotalInvestorPrimaryTrades').css('font-weight','bold');      
      $('#spnTotalInvestorPrimaryTradesValue').css('font-weight','bold');     
      $('#spnTotalInvestorSellOrders').css('font-weight','bold');     
      $('#spnTotalInvestorSellOrdersValue').css('font-weight','bold');      
      $('#spnTotalInvestorExecutedSellOrders').css('font-weight','bold');     
      $('#spnTotalInvestorExecutedSellOrdersValue').css('font-weight','bold');  
      
      setInterval(function() {
        LoadSummary();
      }, RefreshInterval);
        });
    
    function LoadSummary()
    {
      try
      {
        $.ajax({
          url: "<?php echo site_url('ui/Dashboardiv/GetSummary');?>",
          type: 'POST',
          data: {usertype:Usertype,email:Email,issuer_id:IssuerId},
          dataType: 'json',
          success: function(data,status,xhr) {
            if ($(data).length > 0)
            {
              $.each($(data), function(i,e)
              {
                if (Usertype.toLowerCase() == 'issuer')
                {
                  $('#spnTotalIssuerListedSecurities').html(number_format(e.TotalIssuerListedSecurities, '0', '', ',')).css('font-weight','bold');
                  
                  $('#spnTotalIssuerListedSecuritiesValue').html('₦'+number_format(e.TotalIssuerListedSecuritiesValue, '2', '.', ',')).css('font-weight','bold');                 
                  
                  $('#spnTotalIssuerExecutedPrimaryTrades').html(number_format(e.TotalIssuerExecutedPrimaryTrades, '0', '', ',')).css('font-weight','bold');                  
                  
                  $('#spnTotalIssuerExecutedPrimaryTradesValue').html('₦'+number_format(e.TotalIssuerExecutedPrimaryTradesValue, '2', '.', ',')).css('font-weight','bold');                 
                  
                  $('#spnTotalIssuerCurrentlyListedSecurities').html(number_format(e.TotalIssuerCurrentlyListedSecurities, '0', '', ',')).css('font-weight','bold');
                  
                  $('#spnTotalIssuerCurrentlyListedSecuritiesValue').html('₦'+number_format(e.TotalIssuerCurrentlyListedSecuritiesValue, '2', '.', ',')).css('font-weight','bold');
                  
                }else if (Usertype.toLowerCase() == 'investor')
                {
                  $('#spnTotalInvestorSecurities').html(number_format(e.TotalInvestorSecurities, '0', '', ',')).css('font-weight','bold');                  
                  
                  $('#spnTotalInvestorSecuritiesValue').html('₦'+number_format(e.TotalInvestorSecuritiesValue, '2', '.', ',')).css('font-weight','bold');                 
                  
                  $('#spnTotalInvestorPrimaryTrades').html(number_format(e.TotalInvestorPrimaryTrades, '0', '', ',')).css('font-weight','bold');                  
                  
                  $('#spnTotalInvestorPrimaryTradesValue').html('₦'+number_format(e.TotalInvestorPrimaryTradesValue, '2', '.', ',')).css('font-weight','bold');                 
                  
                  $('#spnTotalInvestorSellOrders').html(number_format(e.TotalInvestorSellOrders, '0', '', ',')).css('font-weight','bold');                  
                  
                  $('#spnTotalInvestorSellOrdersValue').html('₦'+number_format(e.TotalInvestorSellOrdersValue, '2', '.', ',')).css('font-weight','bold');
                  
                  
                  $('#spnTotalInvestorExecutedSellOrders').html(number_format(e.TotalInvestorExecutedSellOrders, '0', '', ',')).css('font-weight','bold');
                  
                  $('#spnTotalInvestorExecutedSellOrdersValue').html('₦'+number_format(e.TotalInvestorExecutedSellOrdersValue, '2', '.', ',')).css('font-weight','bold'); 
                }               
                
                return;
              });//End each
            }
          },
          error:  function(xhr,status,error) {
            m='Error '+ xhr.status + ' Occurred: ' + error;
            displayMessage(m,'error',Title,'error');
          }
        });
      }catch(e)
      {
        $.unblockUI();
        m='LoadSummary ERROR:\n'+e;
        displayMessage(m,'error',Title,'error');
      }
    }
  </script>
</body>
</html>