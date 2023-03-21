<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$logged_in = true;
$artwork = $LastestPixs;

// echo "<pre>";
// print_r($artwork); die();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://www.naijaartmart.com/assets/images/d_favicon.png" sizes="16x16">
    <title> Derived Homes | <?php echo $userType; ?> Art Work</title>
   <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progressjs.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/fonts/fonts.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/css/app.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datatables.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/linearicons/style.css">
    <link rel='stylesheet' id='font-awesome-cdn-css'  href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css?ver=5.7.8' type='text/css' media='all' />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/chartist/css/chartist-custom.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker3.min.css" >
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet"><!-- GOOGLE FONTS -->
    <link href="<?php echo base_url();?>assets/css/datatables.min.css" rel="stylesheet">
    <style type="text/css">
        box-below {
            display: flex;
            justify-content: space-between;
            padding-inline: 8px;
            align-items: center;
            font-family: "DMSans-Bold";
            color: #212529;
            font-size: 14px;
        }
    </style>
</head>
<body>
  <div id="myNav" class="overlay-content-otr">
      <div class="modal-content-custom">
          <div class="overlay-content">
              <svg class="icon-close" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 1L1 17M17 17L1 1" stroke="#CFCFCF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              <div class="logo-otr">
                  <a href="#" class="logo-inr">
                      <img class="logo" style="min-height: 70px; min-width: 160px;" src="<?php echo base_url(); ?>/newassets/img/naija_art_mart1.png" alt="brand-logo">
                  </a>
              </div>
          </div>
      </div>
  </div>
  <section class="hero-navbar-9">
    <?php
    include 'nav.php';

    ?>
    <div class="hero-main">
            <div class="container-fluid" style="padding-top: 6px !important;">
                <div class="hero-inr" style="padding-top: 18px !important;">
                <?php if (trim(strtolower($usertype)) == 'investor') {  ?>
                    <div class="row row-custom">
                        <div class="col-lg-7 col-img-otr">
                            <div class="col-img-inr" style="padding: 16px !important;">
                                <a href="#" class="img-otr img-tilt" data-tilt="">
                                    <img class="artwork-img img-fluid" src="<?php echo base_url().'art-works/'.$artwork['pix'] ?>" alt="img" style="max-height: 450px; width:100%">
                                <div class="js-tilt-glare" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; overflow: hidden; pointer-events: none;"><div class="js-tilt-glare-inner" style="position: absolute; top: 50%; left: 50%; background-image: linear-gradient(0deg, rgba(255, 255, 255, 0) 0%, rgb(255, 255, 255) 100%); width: 869.334px; height: 869.334px; transform: rotate(180deg) translate(-50%, -50%); transform-origin: 0% 0%; opacity: 0;"></div></div></a>
                                <div class="create-otr">
                                    <div class="create-inr">
                                        <div class="create-content">
                                            <p class="body-s create-p">Owned by</p>
                                            <a href="" class="body-sb create-pb"><?php echo $artwork['artist'] ?></a>
                                        </div>
                                        
                                    </div>
                                    <div class="create-inr">
                                        <div class="create-content">
                                            <p class="body-s create-p">Created </p>
                                            <a href="" class="body-sb create-pb"><?php echo $artwork['creationyear'] ?></a>
                                        </div>
                                        
                                    </div>
                                </div>
                                <span class="line"></span>
                                <h4 class="heading-h4 head" style="text-align:center !important;">Art work Description
                                </h4>
                                <p class="body-m desc para1" style="display: contents; !important;">
                                    <?php echo trim(htmlspecialchars_decode($artwork['description'])); ?>
                                    <br>
                                    <?php echo trim(htmlspecialchars_decode($artwork['materials'])); ?>
                                    <br>
                                    <?php echo trim(htmlspecialchars_decode($artwork['dimensions'])); ?>
                                    <br>
                                    

                                </p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-content-otr">
                            <div class="col-content-inr">
                                <h1 class="heading-h1 heading titleGreathorned">
                                   <?php echo $artwork['title'] ?>
                                </h1>
                                <div class="boxes-main">
                                    <div class="bid-main">
                                        <p class="bid body-mb">Current Value</p>
                                        <h3 class="heading-h5 bid-head"><?php echo '₦'.number_format($artwork['artwork_value'],2) ?></h3>
                                        <p class="dollor body-mb"><?php echo '₦'.number_format($artwork['tokens_available'],2) ?></p>
                                    </div>
                                    <div class="auction-main">
                                        <p class="body-mb acution">Tokens</p>
                                        <div id="clock" class="timer">
                                            <div class="hours-main main">
                                                <p class="heading-h5" ><?php echo number_format($artwork['tokens_on_issue'],0) ?></p>
                                                <p class="hours-p body-mb">Issued</p>
                                            </div>
                                            <div class="minutes-main main">
                                                <p class="heading-h5" ><?php echo number_format($artwork['tokens_for_sale'],0) ?></p>
                                                <p class="minutes-p body-mb">Sale</p>
                                            </div>
                                            <div class="seconds-main main">
                                                <p class="heading-h5" ><?php echo number_format($artwork['tokens_available'],0) ?></p>
                                                <p class="seconds-p body-mb">Available</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="background: white; border-radius: 20px; font-family: sans-serif; padding: 12px">
                                    <form>
                                    <!--Balance-->
                                       <div class="position-relative row form-group">
                                           <!--Balance-->
                                          <label title="Wallet Balance" for="lblDirectBuyBalance" class="col-sm-2 col-form-label  nsegreen text-right ">Wallet Balance</label>
                                          
                                          <div title="Wallet Balance" class="col-sm-3">
                                            <div class="input-group">
                                                  <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn " type="button">₦</button></span>                        
                                                   <label id="lblDirectBuyBalance" class="col-form-label "><?php echo number_format($balance,2) ?></label>
                                              </div>                    
                                          </div>
                                         
                                         <!--Investor-->
                                         <?php if (trim(strtolower($usertype)) == 'broker') {?>
                                             // code...
                                        <?php } else {  ?>
                                          <label title="Investor" for="lblDirectBuyInvestor" class="col-sm-2 col-form-label text-right">Investor<span class="redtext">*</span></label>
                                          
                                          <div title="Investor" class="col-sm-5">
                                              <label id="lblDirectBuyInvestor" class="col-form-label "><?php echo $fullname; ?></label>
                                          </div>
                                      <?php } ?>
                                      </div>
                                                  
                                      <!--Asset/Available Tokens-->
                                       <div class="position-relative row form-group">
                                          <label title="Asset" for="lblDirectBuySymbol" class="col-sm-2 col-form-label  text-right ">Asset</label>
                                          <?php echo $artwork->symbol ?>
                                          
                                          <div title="Asset" class="col-sm-3">
                                              <label id="lblDirectBuySymbol" class="col-form-label  "><?php echo $artwork['symbol'] ?></label>
                                          </div>
                                          
                                          
                                          <!--Available Tokens-->
                                          <label title="Number of tokens available for sell" for="lblDirectBuyAvailableQty" class="col-sm-2 col-form-label text-right nsegreen text-right">Available Tokens<span class="redtext">*</span></label>
                                          
                                          <div title="Number of tokens available for sell" class="col-sm-5">
                                              <label id="lblDirectBuyAvailableQty" class="col-form-label  "><?php echo number_format($artwork['tokens_available'],0) ?></label>
                                          </div>               
                                      </div>
                                      
                                      <!--Price/Tokens To Buy-->
                                      <div class="position-relative row form-group">
                                          <label title="Price Per Token" for="lblDirectBuyPrice" class="col-sm-2 col-form-label">Price</label>
                                          
                                          <div title="Price Per Token" class="col-sm-3">
                                            <div class="input-group">
                                                  <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn" type="button">₦</button></span>                        
                                                   <label id="lblDirectBuyPrice" class="col-form-label  "><?php echo number_format($artwork['price'],2) ?></label>
                                              </div>                    
                                          </div>
                                          
                                          
                                          <!--Tokens To Buy-->
                                          <label title="Number Of Tokens To Buy" for="txtDirectBuyQty" class="col-sm-2 col-form-label">Buy Quantity<span class="redtext">*</span></label>
                                          
                                          <div title="Number of tokens to buy" class="col-sm-3">
                                              <input type="text" class="form-control " placeholder="Tokens" id="txtDirectBuyQty">
                                          </div>             
                                      </div>
                                      
                                      <!--NSE Transaction Fee/Transfer Fee-->
                                      <div class="position-relative row form-group">
                                         <!--NSE Transaction Fee-->
                                          <label title="NSE Transaction Fee" for="lblDirectNSEFee" class="col-sm-2 col-form-label text-right nsegreen text-right">NSE Fee<span class="redtext">*</span> </label>
                                          
                                          <div title="NSE Transaction Fee" class="col-sm-3">
                                            <div class="input-group">
                                                  <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn " type="button">₦</button></span>                        
                                                   <label id="lblDirectNSEFee" class="col-form-label "><?php echo $nse_rate ?></label>
                                              </div>
                                          </div>
                                          
                                           <!--Transfer Fee-->
                                          <label title="Transfer Fee" for="lblDirectTransferFee" class="col-sm-2 col-form-label text-right nsegreen text-right">Transfer Fee<span class="redtext">*</span></label>
                                          
                                          <div title="Transfer Fee" class="col-sm-5">
                                            <div class="input-group">
                                                  <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn " type="button">₦</button></span>                        
                                                   <label id="lblDirectTransferFee" class="col-form-label  "><?php echo $transfer_fee ?></label>
                                              </div>
                                          </div>          
                                      </div>
                                      
                                      
                                      <!--SMS Fee/Issuer Email-->
                                      <div class="position-relative row form-group">
                                          <!--SMS Fee-->
                                          <label title="SMS Fee" for="lblDirectSMSFee" class="col-sm-2 col-form-label nsegreen text-right ">SMS Fee</label>
                                          
                                          <div title="SMS Fee" class="col-sm-3">
                                            <div class="input-group">
                                                  <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn " type="button">₦</button></span>                        
                                                   <label id="lblDirectSMSFee" class="col-form-label  "><?php echo $sms_fee ?></label>
                                              </div>
                                          </div>
                                          
                                          
                                          <!--Issuer Email-->
                                          <label title="Issuer Email" for="lblDirectIssuerEmail" class="col-sm-2 col-form-label text-right nsegreen text-right">Issuer Email</label>
                                          
                                          <div title="Issuer Email" class="col-sm-5">
                                              <label id="lblDirectIssuerEmail" class="col-form-label  "><?php echo $artwork['issuer_email'] ?></label>
                                          </div>         
                                      </div>
                                      
                                      
                                      <!--Token Amount/Total Amount-->
                                      <div class="position-relative row form-group">
                                        <!--Token Amount-->
                                          <label title="Token Amount" for="lblDirectTokenAmount" class="col-sm-2 col-form-label nsegreen text-right ">Token Amount</label>
                                          
                                          <div title="Token Amount" class="col-sm-3">
                                              <div class="input-group">
                                                <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn " type="button">₦</button></span>                        
                                                   <label id="lblDirectTokenAmount" class="col-form-label redalerttext "></label>                         
                                              </div>
                                          </div>
                                          
                                          <!--Total Amount-->
                                          <label title="Total Amount" for="lblDirectTotalAmount" class="col-sm-2 col-form-label nsegreen text-right ">Total Amount</label>
                                          
                                          <div title="Total Amount" class="col-sm-3">
                                              <div class="input-group">
                                                  <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px; color:darkgray;" class="btn " type="button">₦</button></span>                        
                                                   <label id="lblDirectTotalAmount" class="col-form-label redalerttext "></label>
                                              </div>
                                          </div>
                                          <div class="action-otr">
                                            <a href="#" id="btnDirectBuy" class="btn-outline2 btn-wallet">Buy Artwork</a>
                                            </div>      
                                      </div>
                                      
                                                  
                                     <div id="divDirectBuyAlert"></div>
                                  </form>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                <?php }elseif (trim(strtolower($usertype)) == 'broker') {  ?>
                    <div class="row row-custom">
                        <div class="col-lg-7 col-img-otr">
                            <div class="col-img-inr" style="padding: 16px !important;">
                                <a href="#" class="img-otr img-tilt" data-tilt="">
                                    <img class="artwork-img img-fluid" src="<?php echo base_url().'art-works/'.$artwork['pix'] ?>" alt="img" style="max-height: 450px; width:100%">
                                <div class="js-tilt-glare" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; overflow: hidden; pointer-events: none;"><div class="js-tilt-glare-inner" style="position: absolute; top: 50%; left: 50%; background-image: linear-gradient(0deg, rgba(255, 255, 255, 0) 0%, rgb(255, 255, 255) 100%); width: 869.334px; height: 869.334px; transform: rotate(180deg) translate(-50%, -50%); transform-origin: 0% 0%; opacity: 0;"></div></div></a>
                                <div class="create-otr">
                                    <div class="create-inr">
                                        <div class="create-content">
                                            <p class="body-s create-p">Owned by</p>
                                            <a href="" class="body-sb create-pb"><?php echo $artwork['artist'] ?></a>
                                        </div>
                                        
                                    </div>
                                    <div class="create-inr">
                                        <div class="create-content">
                                            <p class="body-s create-p">Created </p>
                                            <a href="" class="body-sb create-pb"><?php echo $artwork['creationyear'] ?></a>
                                        </div>
                                        
                                    </div>
                                </div>
                                <span class="line"></span>
                                <h4 class="heading-h4 head" style="text-align:center !important;">Art work Description
                                </h4>
                                <p class="body-m desc para1" style="display: contents; !important;">
                                    <?php echo trim(htmlspecialchars_decode($artwork['description'])); ?>
                                    <br>
                                    <?php echo trim(htmlspecialchars_decode($artwork['materials'])); ?>
                                    <br>
                                    <?php echo trim(htmlspecialchars_decode($artwork['dimensions'])); ?>
                                    <br>
                                    

                                </p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-content-otr">
                            <div class="col-content-inr">
                                <h1 class="heading-h1 heading titleGreathorned">
                                   <?php echo $artwork['title'] ?>
                                </h1>
                                <div class="boxes-main">
                                    <div class="bid-main">
                                        <p class="bid body-mb">Current Value</p>
                                        <h3 class="heading-h5 bid-head"><?php echo '₦'.number_format($artwork['artwork_value'],2) ?></h3>
                                        <p class="dollor body-mb"><?php echo '₦'.number_format($artwork['tokens_available'],2) ?></p>
                                    </div>
                                    <div class="auction-main">
                                        <p class="body-mb acution">Tokens</p>
                                        <div id="clock" class="timer">
                                            <div class="hours-main main">
                                                <p class="heading-h5" ><?php echo number_format($artwork['tokens_on_issue'],0) ?></p>
                                                <p class="hours-p body-mb">Issued</p>
                                            </div>
                                            <div class="minutes-main main">
                                                <p class="heading-h5" ><?php echo number_format($artwork['tokens_for_sale'],0) ?></p>
                                                <p class="minutes-p body-mb">Sale</p>
                                            </div>
                                            <div class="seconds-main main">
                                                <p class="heading-h5" ><?php echo number_format($artwork['tokens_available'],0) ?></p>
                                                <p class="seconds-p body-mb">Available</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="background: white; border-radius: 20px; font-family: sans-serif; padding: 12px">
                                    <form>
                                    <!--Balance-->
                                       <div class="position-relative row form-group">
                                           <!--Balance-->
                                          <label title="Wallet Balance" for="lblDirectBuyBalance" class="col-sm-2 col-form-label  nsegreen text-right ">Wallet Balance</label>
                                          
                                          <div title="Wallet Balance" class="col-sm-3">
                                            <div class="input-group">
                                                  <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn " type="button">₦</button></span>                        
                                                   <label id="lblDirectBuyBalance" class="col-form-label "><?php echo number_format($balance,2) ?></label>
                                              </div>                    
                                          </div>
                                         
                                         <!--Investor-->
                                         <?php if (trim(strtolower($usertype)) == 'broker') {?>
                                             // code...
                                        <?php } else {  ?>
                                          <label title="Investor" for="lblDirectBuyInvestor" class="col-sm-2 col-form-label text-right">Investor<span class="redtext">*</span></label>
                                          
                                          <div title="Investor" class="col-sm-5">
                                              <label id="lblDirectBuyInvestor" class="col-form-label "><?php echo $fullname; ?></label>
                                          </div>
                                      <?php } ?>
                                      </div>
                                                  
                                      <!--Asset/Available Tokens-->
                                       <div class="position-relative row form-group">
                                          <label title="Asset" for="lblDirectBuySymbol" class="col-sm-2 col-form-label  text-right ">Asset</label>
                                          <?php echo $artwork->symbol ?>
                                          
                                          <div title="Asset" class="col-sm-3">
                                              <label id="lblDirectBuySymbol" class="col-form-label  "><?php echo $artwork['symbol'] ?></label>
                                          </div>
                                          
                                          
                                          <!--Available Tokens-->
                                          <label title="Number of tokens available for sell" for="lblDirectBuyAvailableQty" class="col-sm-2 col-form-label text-right nsegreen text-right">Available Tokens<span class="redtext">*</span></label>
                                          
                                          <div title="Number of tokens available for sell" class="col-sm-5">
                                              <label id="lblDirectBuyAvailableQty" class="col-form-label  "><?php echo number_format($artwork['tokens_available'],0) ?></label>
                                          </div>               
                                      </div>
                                      
                                      <!--Price/Tokens To Buy-->
                                      <div class="position-relative row form-group">
                                          <label title="Price Per Token" for="lblDirectBuyPrice" class="col-sm-2 col-form-label">Price</label>
                                          
                                          <div title="Price Per Token" class="col-sm-3">
                                            <div class="input-group">
                                                  <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn" type="button">₦</button></span>                        
                                                   <label id="lblDirectBuyPrice" class="col-form-label  "><?php echo number_format($artwork['price'],2) ?></label>
                                              </div>                    
                                          </div>
                                          
                                          
                                          <!--Tokens To Buy-->
                                          <label title="Number Of Tokens To Buy" for="txtDirectBuyQty" class="col-sm-2 col-form-label">Buy Quantity<span class="redtext">*</span></label>
                                          
                                          <div title="Number of tokens to buy" class="col-sm-3">
                                              <input type="text" class="form-control " placeholder="Tokens" id="txtDirectBuyQty">
                                          </div>             
                                      </div>
                                      
                                      <!--NSE Transaction Fee/Transfer Fee-->
                                      <div class="position-relative row form-group">
                                         <!--NSE Transaction Fee-->
                                          <label title="NSE Transaction Fee" for="lblDirectNSEFee" class="col-sm-2 col-form-label text-right nsegreen text-right">NSE Fee<span class="redtext">*</span> </label>
                                          
                                          <div title="NSE Transaction Fee" class="col-sm-3">
                                            <div class="input-group">
                                                  <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn " type="button">₦</button></span>                        
                                                   <label id="lblDirectNSEFee" class="col-form-label "><?php echo $nse_rate ?></label>
                                              </div>
                                          </div>
                                          
                                           <!--Transfer Fee-->
                                          <label title="Transfer Fee" for="lblDirectTransferFee" class="col-sm-2 col-form-label text-right nsegreen text-right">Transfer Fee<span class="redtext">*</span></label>
                                          
                                          <div title="Transfer Fee" class="col-sm-5">
                                            <div class="input-group">
                                                  <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn " type="button">₦</button></span>                        
                                                   <label id="lblDirectTransferFee" class="col-form-label  "><?php echo $transfer_fee ?></label>
                                              </div>
                                          </div>          
                                      </div>
                                      
                                      
                                      <!--SMS Fee/Issuer Email-->
                                      <div class="position-relative row form-group">
                                          <!--SMS Fee-->
                                          <label title="SMS Fee" for="lblDirectSMSFee" class="col-sm-2 col-form-label nsegreen text-right ">SMS Fee</label>
                                          
                                          <div title="SMS Fee" class="col-sm-3">
                                            <div class="input-group">
                                                  <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn " type="button">₦</button></span>                        
                                                   <label id="lblDirectSMSFee" class="col-form-label  "><?php echo $sms_fee ?></label>
                                              </div>
                                          </div>
                                          
                                          
                                          <!--Issuer Email-->
                                          <label title="Issuer Email" for="lblDirectIssuerEmail" class="col-sm-2 col-form-label text-right nsegreen text-right">Issuer Email</label>
                                          
                                          <div title="Issuer Email" class="col-sm-5">
                                              <label id="lblDirectIssuerEmail" class="col-form-label  "><?php echo $artwork['issuer_email'] ?></label>
                                          </div>         
                                      </div>
                                      
                                      
                                      <!--Token Amount/Total Amount-->
                                      <div class="position-relative row form-group">
                                        <!--Token Amount-->
                                          <label title="Token Amount" for="lblDirectTokenAmount" class="col-sm-2 col-form-label nsegreen text-right ">Token Amount</label>
                                          
                                          <div title="Token Amount" class="col-sm-3">
                                              <div class="input-group">
                                                <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn " type="button">₦</button></span>                        
                                                   <label id="lblDirectTokenAmount" class="col-form-label redalerttext "></label>                         
                                              </div>
                                          </div>
                                          
                                          <!--Total Amount-->
                                          <label title="Total Amount" for="lblDirectTotalAmount" class="col-sm-2 col-form-label nsegreen text-right ">Total Amount</label>
                                          
                                          <div title="Total Amount" class="col-sm-3">
                                              <div class="input-group">
                                                  <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px; color:darkgray;" class="btn " type="button">₦</button></span>                        
                                                   <label id="lblDirectTotalAmount" class="col-form-label redalerttext "></label>
                                              </div>
                                          </div>
                                          <div class="action-otr">
                                            <a href="#" id="btnDirectBuy" class="btn-outline2 btn-wallet">Buy Artwork</a>
                                            </div>      
                                      </div>
                                      
                                                  
                                     <div id="divDirectBuyAlert"></div>
                                  </form>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                <?php }?>
                </div>
            </div>
            <img class="circle-1" src="<?php echo site_url() ?>newassets/img/svg/circles-1.svg" alt="circale">
            <img class="circle-2" src="<?php echo site_url() ?>newassets/img/svg/circles-2.svg" alt="circale">
        </div>

  </section>


  <div class="copy-otr-home2">
      <div class="container-fluid">
          <div class="copy-inr">
              <a href="#" class="logo-otr">
                  <img class="logo" style="min-height: 40px; min-width: 30px; border-radius: 16px;" src="<?php echo base_url(); ?>/newassets/img/derivedlogo.png"  alt="brand-logo">
              </a>
              <div class="copy-name body-s">
                  Copyright © 2022  <a href="#" target="_blank" class="name body-sb">Derived Homes.</a>
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
<!--Direct Buy Popup-->

<!--End Direct Buy Popup-->  
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-3.5.1.min.js"></script>

    <!-- <script src="<?php echo base_url(); ?>/newassets/libs/jquery/dist/jquery.min.js"></script> -->
  <script src="<?php echo base_url(); ?>/newassets/libs/jquery.countdown/jquery.countdown.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/libs/tilt.js/dest/tilt.jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
  <!-- <script src="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progress.js"></script> -->
  <script src="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/js/app.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/datatables.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/klorofil-common.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/chartist/js/chartist.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/klorofil-common.js"></script>
  <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/aes256.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/js/sum().js"></script>


<script src="<?php echo base_url();?>assets/js/general.js"></script>
<script>
    var Title='Derived Homes Help';
    var m='';
    var table,tabletrade,tablenews;
    var artId='<?php echo $artwork['art_id']; ?>';
    var Email='<?php echo $email; ?>';
    var Usertype='<?php echo $usertype; ?>';
    var InvestorId='<?php echo $investor_id; ?>';
    var InvestorName='<?php echo trim($fullname); ?>';
    var RefreshInterval='<?php echo $RefreshInterval; ?>';
    RefreshInterval=parseInt(RefreshInterval,10) * 60 * 1000;

        /**
    * Displays Alert Message
    * @param {string} msg
    * @param {string} type
    * @param {string} title
    * @param {string} theme
    * @return void
    */
    function displayMessage(msg,type,title,theme){
      swal({
        title: title,
        text: msg,
        icon: theme,
        dangerMode: false,
      })
    }

    /**
    * Displays Alert Message
    * @param {string} msg
    * @param {number} timer
    * @param {string} title
    * @param {string} theme
    * @return void
    */

    function timedAlert(msg,timer,title,theme){
      swal({
        title: title,
        text: msg,
        icon: theme,
        timer: timer,
      })
    }
  

        function DisplayMessage(msg,msgtype,msgtitle,theme='AlertTheme')
        {
            try
            {//SuccessTheme, AlertTheme                
                
                swal({
                      type: msgtype,
                      title: msgtitle,
                      text: msg,
                      showCloseButton: true,
                    })
                    
            }catch(e)
            {
                alert('ERROR Displaying Message: '+e);
            }
        }
        
        function DisplayDirectBuyMessage(msg,msgtype,msgtitle,theme='AlertTheme')
        {
            try
            {//SuccessTheme, AlertTheme
                
                
                swal({
                      type: msgtype,
                      title: msgtitle,
                      text: msg,
                      showCloseButton: true,
                    })
                    
            }catch(e)
            {
                alert('ERROR Displaying Message: '+e);
            }
        }
        
        $(document).ready(function(e) {
            
            $('[data-toggle="tooltip"]').tooltip();
            
            setInterval(function(){
                LoadArtworkData();
            }, (RefreshInterval));
    
            
            $('.datepicker').datepicker({
                weekStart: 1,
                todayBtn:  "linked",
                autoclose: 1,
                todayHighlight: 1,
                minViewMode: 1,//Months
                clearBtn: 1,
                forceParse: 0,
                daysOfWeekHighlighted: "0,6",
                //daysOfWeekDisabled: "0,6",
                format: 'M yyyy'
            });         

            $('#txtBuyExpiryDate').datepicker({
                weekStart: 1,
                todayBtn:  "linked",
                autoclose: 1,
                todayHighlight: 1,
                minViewMode: 1,//Months
                clearBtn: 1,
                forceParse: 0,
                daysOfWeekHighlighted: "0,6",
                //daysOfWeekDisabled: "0,6",
                format: 'M yyyy'
            });
            
            $('.tradedatepicker').datepicker({
                weekStart: 1,
                todayBtn:  "linked",
                autoclose: 1,
                todayHighlight: 1,
                maxViewMode: 1,//Months
                clearBtn: 1,
                forceParse: 0,
                daysOfWeekHighlighted: "0,6",
                //daysOfWeekDisabled: "0,6",
                format: 'd M yyyy'
            });         

            
           
            
            setInterval(function() {
                updateClock();
            }, 1000);
            
            LoadArtworkData();
            LoadMessages();
    
            
            function LoadMessages()
            {
                try
                {
                   timedAlert("Loading Messages/News. ",2000,'','info');
                    
                    $('#tabNews > tbody').html('');
                    
                    var tw=$('#news').width();
                    var det_cell=tw * 0.45;
                    var head_cell=tw * 0.38;
                    
                    $.ajax({
                        url: '<?php echo site_url('ui/Directinvestorprymarket/LoadMessages'); ?>',
                        type: 'POST',
                        data: {email:Email, detail_width:det_cell, header_width:head_cell,usertype:'<?php echo $usertype; ?>'},
                        dataType: 'json',
                        success: function(dataSet,status,xhr) { 
                            
                            
                            if (tablenews) tablenews.destroy();
                            
                            //f-filtering, l-length, i-information, p-pagination
                            tablenews = $('#tabNews').DataTable( {
                                dom: '<"top"if>rt<"bottom"lp><"clear">',
                                responsive: true,
                                ordering: false,
                                autoWidth:false,
                                language: {zeroRecords: "No News/Message Record Found"},
                                lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],                                    
                                columnDefs: [
                                    {
                                        "targets": [ 0,1,2,3 ],
                                        "visible": true
                                    },
                                    {
                                        "targets": [ 3 ],
                                        "orderable": false,
                                        "searchable": false
                                    },
                                    {
                                        "targets": [ 0,1,2 ],
                                        "searchable": true
                                    },
                                    { className: "dt-center", "targets": [ 0,1,2,3 ] }
                                ],                  
                                order: [[ 2, 'asc' ]],
                                data: dataSet, 
                                columns: [
                                    { width: "12%" },//Date
                                    { width: "53%" },//Header
                                    { width: "30%" },//Sender
                                    { width: "5%" } //View
                                ]
                            } );
                            
                            //UiActivateTab('view');        
                        },
                        error:  function(xhr,status,error) {
                            
                            m='Error '+ xhr.status + ' Occurred: ' + error;
                            displayMessage(m,'error',Title,'error');
                        }
                    });
                    
                    
                }catch(e)
                {
                    
                    m='LoadMessages ERROR:\n'+e;
                   displayMessage(m, 'error',Title,'error');
                }
            }
            
            function LocateMesssage(mid,hd,det,dt,cat)
            {
                try
                {
                    $.redirect("<?php echo base_url(); ?>ui/Messages", {msgid:mid, header:hd, details:det, msgdate:dt,category:cat}, "POST");   
                }catch(e)
                {
                    
                    m='LocateMesssage ERROR:\n'+e;
                   displayMessage(m, 'error',Title,'error');
                }
            }           
                        
            function LoadArtworkData()
            {
                try
                {
                    timedAlert('Loading Artwork Data. Please Wait...',2000,'','');
                    
                    //$('#tabMarket > tbody').html('');
    
                    $.ajax({
                        url: "<?php echo site_url('ui/Directinvestorprymarket/GetArtWorkData');?>",
                        type: 'POST',
                        data: {art_id:artId},
                        dataType: 'json',
                        success: function(dataSet,status,xhr) { 
                            console.log(JSON.parse(dataSet));

                            $('#lblDirectBuySymbol').html('');
                            $('#lblDirectBuyAvailableQty').html('');
                            $('#lblDirectBuyPrice').html('');
                            $('#txtDirectBuyQty').val('');
                            $('#lblDirectNSEFee').html('');
                            $('#lblDirectTotalAmount').html('');
                            $('#lblDirectTokenAmount').html('');
                        },
                        error:  function(xhr,status,error) {
                            
                            m='Error '+ xhr.status + ' Occurred: ' + error;
                            displayMessage(m,'error',Title,'error');
                        }
                    });
                }catch(e)
                {
                    
                    m='LoadArtworkData ERROR:\n'+e;
                    displayMessage(m,'error',Title,'error');
                }
            }
            
            $('#btnDirectBuy').click(function(e) {
                try
                {
                    $('#divAlert').html('');            
                    if (!CheckDirectBuy()) return false;
                }catch(e)
                {
                    
                    m='Direct Buy Button Click ERROR:\n'+e;         
                    DisplayDirectBuyMessage(m, 'error',Title);
                }
            });             
            
            function CheckDirectBuy()
            {
                try
                {
                    var inv=Email;
                    var inv_name=$.trim($('#lblDirectBuyInvestor').html());
                    var bal=$.trim($('#lblDirectBuyBalance').html()).replace(new RegExp(',', 'g'), '');             
                    bal=bal.replace(new RegExp('₦', 'g'), '');
                    
                    var sym=$.trim($('#lblDirectBuySymbol').html());
                    var available_qty=$.trim($('#lblDirectBuyAvailableQty').html()).replace(new RegExp(',', 'g'), '');
                    var price=$.trim($('#lblDirectBuyPrice').html()).replace(new RegExp(',', 'g'), '');             
                    price=price.replace(new RegExp('₦', 'g'), '');
                    
                    var qty=$.trim($('#txtDirectBuyQty').val()).replace(new RegExp(',', 'g'), '');
                    var nsefee=$.trim($('#lblDirectNSEFee').html()).replace(new RegExp(',', 'g'), '');              
                    nsefee=nsefee.replace(new RegExp('₦', 'g'), '');
                    
                    var transfer_fee=$.trim($('#lblDirectTransferFee').html()).replace(new RegExp(',', 'g'), '');               
                    transfer_fee=transfer_fee.replace(new RegExp('₦', 'g'), '');
                    
                    var sms=$.trim($('#lblDirectSMSFee').html()).replace(new RegExp(',', 'g'), '');             
                    sms=sms.replace(new RegExp('₦', 'g'), '');
                    
                    var issuer_email=$.trim($('#lblDirectIssuerEmail').html());                 
                    
                    var tradeamt=$.trim($('#lblDirectTokenAmount').html()).replace(new RegExp(',', 'g'), '');
                    tradeamt=tradeamt.replace(new RegExp('₦', 'g'), '');
                    
                    var total=$.trim($('#lblDirectTotalAmount').html()).replace(new RegExp(',', 'g'), '');
                    total=total.replace(new RegExp('₦', 'g'), '');
                    
                    
                    if (!Email)//Investor email not displaying
                    {
                        m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request.';                      
    
                        DisplayDirectBuyMessage(m, 'error',Title);              
    
                        return false;
                    }                   
                    
                    //Symbol not displaying
                    if (!sym)
                    {
                        m='The asset to buy is not displaying. Current session may have timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of the asset.';                     
    
                        DisplayDirectBuyMessage(m, 'error',Title);              
    
                        return false;
                    }
                    
                    if (parseInt(available_qty) == 0)
                    {
                        m='Number of available tokens to buy from is zero. Trade cannot continue';              
                        DisplayDirectBuyMessage(m, 'error',Title);
                        return false;
                    }
                    
                    if (parseFloat(price) == 0)
                    {
                        m='Price per token for the asset is zero. Trade cannot continue';               
                        DisplayDirectBuyMessage(m, 'error',Title);
                        return false;
                    }
                    
                    //Buy Qty
                    if (!qty)
                    {
                        m='Number of tokens to buy MUST not be blank.';             
                        DisplayDirectBuyMessage(m, 'error',Title);                  
                        return false;
                    }
                    
                    if (!$.isNumeric(qty))
                    {
                        m='Number of tokens to buy MUST be a number. Current entry '+qty+' is not valid.';                       
                        DisplayDirectBuyMessage(m, 'error',Title);
                        return false;
                    }
    
                    if (parseInt(qty) == 0)
                    {
                        m='Number of tokens to buy must not be zero.';              
                        DisplayDirectBuyMessage(m, 'error',Title);
                        return false;
                    }
                    
                    if (parseInt(qty) < 0)
                    {
                        m='Number of tokens to buy must not be a negative number.';             
                        DisplayDirectBuyMessage(m, 'error',Title);
                        return false;
                    }               
                                        
                    if (parseInt(available_qty) < parseInt(qty))
                    {
                        m="The number of tokens to buy ("+number_format(qty,0,'',',')+") is more than the available tokens for sale (" + number_format(available_qty,0,'',',') + ").";
                        DisplayDirectBuyMessage(m, 'error',Title);
                        return false;
                    }                   
                
                    if (!bal)
                    {
                        m='Your e-wallet balance is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the buying of asset. If the issue still persists after signout and signin and you are sure that you have credited your e-wallet, please contact the system administrator at support@naijaartmart.com, otherwise credit your wallet through <a href="<?php echo site_url('ui/Wallet'); ?>">Wallet Module</a> on your side menu.';  
                                
                        DisplayDirectBuyMessage(m, 'error',Title);                  
                        return false;
                    }
                    
                    if (!$.isNumeric(bal))
                    {
                        m='E-wallet balance MUST be a number.';                     
                        DisplayDirectBuyMessage(m, 'error',Title);
                        return false;
                    }
    
                    if (parseFloat(bal) == 0)
                    {
                        m='E-wallet balance is zero. Please fund your e-wallet so that you can trade with it.';             
                        DisplayDirectBuyMessage(m, 'error',Title);
                        return false;
                    }
                    
                    if (parseFloat(bal) < 0)
                    {
                        m='E-wallet balance must not be a negative number. Please fund your e-wallet so that you can trade with it.';               
                        DisplayDirectBuyMessage(m, 'error',Title);
                        return false;
                    }
                                        
                    if (parseFloat(bal) < parseFloat(total))
                    {
                        m="You do not have enough balance in your e-wallet to buy this asset. Your current e-wallet balance is (₦"+number_format(bal,2,'.',',')+") and the total amount needed for buying "+number_format(qty,0,'',',')+" tokens of the asset is (₦" + number_format(total,2,'.',',') + ").";
                        DisplayDirectBuyMessage(m, 'error',Title);
                        return false;
                    }
                     if (parseFloat(total) < parseFloat(100))
                    {
                        m="The minimum amount you may send in a single transfer is ₦100, please increase the amount.";
                        DisplayDirectBuyMessage(m, 'warning',Title);
                        return false;
                    }
                                        
                                        
                    //Confirm Update                
                    swal({
                      title: 'Are you sure?',
                      text: "Do You Want To Proceed With The Buying Of The Asset? Please note that ₦"+number_format(total,2,'.',',')+" will be charged from your wallet balance",
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                      confirmButtonText: 'Yes'
                    }).then((result) => {
                        if (result){

                            timedAlert('Buying Asset. Please Wait...',3000,'','info');
    
                            var mdata={buy_investor_email:inv, buy_investor_name:inv_name, symbol:sym, price:price, qty:qty, available_qty:available_qty, nse_commission:nsefee, sms_fee:sms, transfer_fee:transfer_fee, tradeamount:tradeamt, total_amount:total, issuer_email:issuer_email};      
                                    
                            //Make Ajax Request         
                            $.ajax({
                                url: '<?php echo site_url('ui/Directinvestorprymarket/BuyPrimaryTokens'); ?>',
                                data: mdata,
                                type: 'POST',
                                dataType: 'json',
                                success: function(data,status,xhr) {
                                if ($(data).length > 0) {
                                    $.each($(data), function(i,e) {
                                        if ($.trim(e.status).toUpperCase() == 'OK') {               
                                            $('#lblDirectBuySymbol').html('');
                                            $('#lblDirectBuyAvailableQty').html('');
                                            $('#lblDirectBuyPrice').html('');
                                            $('#txtDirectBuyQty').val('');
                                            $('#lblDirectNSEFee').html('');
                                            $('#lblDirectTotalAmount').html('');
                                            $('#lblDirectTokenAmount').html('');                    
                
                                            m= 'Purchase of '+number_format(qty, '0', '', ',') + ' token(s) of '+ $.trim(sym).toUpperCase() +' was successful.';
                                            
                                            // timedAlert(m, 4000,'Token Purchase','success');
                                            swal({
                                              title: "Token Purchase",
                                              text: m,
                                              icon: "success",
                                              buttons: true,
                                              dangerMode: false,
                                            })
                                            .then((res) => {
                                              if (res) {
                                               $('#lblDirectBuyInvestor').val('');
                                            
                                                window.location.reload(true);
                                                GetBalance();
                                                
                                                $("#divDirectBuyModal").modal('hide');//Close modal
                                                
                                                LoadArtworkData();
                                                LoadMessages();
                                              } else {
                                                GetBalance();
                                                
                                                $("#divDirectBuyModal").modal('hide');//Close modal
                                                
                                                LoadArtworkData();
                                                LoadMessages();
                                              }
                                            });

                                            
                                        }else {
                                            m=e.Message;
                                            DisplayDirectBuyMessage(m,'error',Title);       
                                        }
                                        
                                        return;
                                    });//End each
                                }
                            },
                            error:  function(xhr,status,error) {
                                m='Error '+ xhr.status + ' Occurred: ' + error
                                DisplayDirectBuyMessage(m,'error',Title);
                            }
                        });
                        }
                    })
                }catch(e)
                {
                    
                    m='CheckDirectBuy ERROR:\n'+e;          
                    DisplayDirectBuyMessage(m, 'error',Title);
                }       
            }//End CheckDirectBuy
            
            //Direct Buy
            $("#txtDirectBuyQty").on("keyup",function(event)
            {
                try
                {
                    ComputeDirectBuyAmount();
                }catch(e)
                {
                    
                    m='Buy Quantity Keyup ERROR:\n'+e;          
                    DisplayDirectBuyMessage(m, 'error',Title);
                }
            });
            
            $("#txtDirectBuyQty").on("change",function(event)
            {
                try
                {
                    ComputeDirectBuyAmount();
                }catch(e)
                {
                    
                    m='Buy Quantity Changed ERROR:\n'+e;            
                    DisplayDirectBuyMessage(m, 'error',Title);
                }
            }); 
            
            function ComputeDirectBuyAmount()
            {
                try
                {
                    $('#lblDirectTotalAmount').html('');
                    $('#lblDirectTokenAmount').html('');
                    $('#lblDirectNSEFee').html('');             
                    
                    var qty=$.trim($('#txtDirectBuyQty').val()).replace(new RegExp(',', 'g'), '');                  
                    var price=$.trim($('#lblDirectBuyPrice').html()).replace(new RegExp(',', 'g'), '');             
                    price=price.replace(new RegExp('₦', 'g'), '');
                    
                    var sms=$.trim($('#lblDirectSMSFee').html()).replace(new RegExp(',', 'g'), '');             
                    sms=sms.replace(new RegExp('₦', 'g'), '');
                                                            
                    var transfer_fee='<?php echo $transfer_fee; ?>';
                    var nse_rate = '<?php echo $nse_rate; ?>';                  
                    var amount = parseFloat(qty) * parseFloat(price);
                    var nsefee = (parseFloat(nse_rate)/100) * amount;
                    var total = parseFloat(amount) + parseFloat((nsefee/2)) + parseFloat(sms) + parseFloat(transfer_fee);
                
                    if (parseFloat(nsefee) > 0) $('#lblDirectNSEFee').html(number_format((nsefee/2), 2, '.', ','));
                    if (parseFloat(amount) > 0) $('#lblDirectTokenAmount').html(number_format(amount, 2, '.', ','));
                    if (parseFloat(total) > 0) $('#lblDirectTotalAmount').html(number_format(total, 2, '.', ','));
                }catch(e)
                {
                    
                    m='ComputeDirectBuyAmount ERROR:\n'+e;          
                    DisplayDirectBuyMessage(m, 'error',Title);
                }
            }
            
        });//End document ready
        
        
        function GetBalance()
        {
            try
            {
                var bal=$.trim($('#uiWalletBalance').html()).replace(new RegExp(',', 'g'), '');             
                bal=bal.replace(new RegExp('₦', 'g'), '');
                
                if (parseFloat(bal) > 0)
                {
                    $('#lblBuyBalance').html('₦'+number_format(bal, '2', '.', ','));
                    $('#uiWalletBalance').html(number_format(bal, '2', '.', ','));
                    $('#lblDirectBuyBalance').html(number_format(bal, '2', '.', ','));
                }else
                {
                    $('#lblBuyBalance').html('');
                    $('#uiWalletBalance').html('');
                    $('#lblDirectBuyBalance').html('');
                    
                    timedAlert('Retrieving Wallet Balance.',2000,'','info');
                                            
                    //Make Ajax Request         
                    $.ajax({
                        url: '<?php echo site_url('ui/Directinvestorprymarket/GetBalance'); ?>',
                        data: {email:Email},
                        type: 'POST',
                        dataType: 'text',
                        success: function(data,status,xhr) {                
                            
                            
                            var b=data;                         
                            
                            if ($.isNumeric(b))
                            {
                                $('#lblBuyBalance').html('₦'+number_format(b, '2', '.', ','));
                                $('#uiWalletBalance').html(number_format(b, '2', '.', ','));
                                $('#lblDirectBuyBalance').html(number_format(b, '2', '.', ','));
                            }else
                            {
                                m=data;
                                displayMessage(m,'error',Title,'error');    
                            }
                        },
                        error:  function(xhr,status,error) {
                            m='Error '+ xhr.status + ' Occurred: ' + error;
                            displayMessage(m,'error',Title,'error');
                        }
                    }); 
                }               
            }catch(e)
            {
                
                m='GetBalance ERROR:\n'+e;              
               displayMessage(m, 'error',Title,'error');
                return false;
            }       
        }//End GetBalance
        
        function updateClock()
        {
            var currentTime = new Date ( );
            var currentHours = currentTime.getHours ( );
            var currentMinutes = currentTime.getMinutes ( );
            var currentSeconds = currentTime.getSeconds ( );                
            var month=currentTime.getMonth()+1;
            var day=currentTime.getDate();
            var year=currentTime.getFullYear();
            
            var weekdays = new Array(7);
            weekdays[0] = "Sunday";
            weekdays[1] = "Monday";
            weekdays[2] = "Tuesday";
            weekdays[3] = "Wednesday";
            weekdays[4] = "Thursday";
            weekdays[5] = "Friday";
            weekdays[6] = "Saturday";
            
            var dayname = weekdays[currentTime.getDay()];
            
            
            if (month <10 ){month='0' + month;}
            if (day <10 ){day='0' + day;}
            
            var dt= day+' '+GetMonthName(month)+' '+year;
            
            // Pad the minutes and seconds with leading zeros, if required
            currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
            currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
            
            // Choose either "AM" or "PM" as appropriate
            var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";
            
            // Convert the hours component to 12-hour format if needed
            currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;
            
            // Convert an hours component of "0" to "12"
            currentHours = ( currentHours == 0 ) ? 12 : currentHours;
            
            // Compose the string for display
            var currentTimeString = dayname+", "+dt+" "+currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
            
            $("#lblTime").html(currentTimeString);
        
        }
    
        function ShowMarketData(sn,sym,price,tokens,title,issuer_email)
        {
            try
            {
                //var avtoks = $('#tabMarket > tbody').find("tr").eq(sn).find("td").eq(4).html();
                GetBalance();
                
                //$('#lblDirectBuyBalance').html();
                $('#lblDirectBuySymbol').html(sym);
                $('#lblDirectIssuerEmail').html(issuer_email);
                $('#lblDirectBuyAvailableQty').html(number_format(tokens,0,'',','));
                $('#lblDirectBuyPrice').html(number_format(price,2,'.',','));
                
                var sms='<?php echo floatval($sms_fee); ?>';                
                $('#lblDirectSMSFee').html(number_format(sms, '2', '.', ','));  
                
                var tf='<?php echo (floatval($transfer_fee)); ?>';              
                $('#lblDirectTransferFee').html(number_format(tf, '2', '.', ','));
            }catch(e)
            {
                
                m='ShowMarketData ERROR:\n'+e;
                displayMessage(m,'error',Title,'error');
            }
        }
    </script>
</body>
</html>