<?php

$logged_in = false;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://www.naijaartmart.com/assets/images/favicon_artsquare_16x16.png" sizes="16x16">
    <title> Naija Art Mart | Confirm Registration.</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progressjs.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/fonts/fonts.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/css/app.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>


<!--     <div class="loader"></div>
 -->
    <!--=======================================
            login Start Here
    ========================================-->

        <div class="login-main" style="background: url('https://www.naijaartmart.com/assets/front/images/we-have-designed.jpg') !important; background-repeat: no-repeat; background-size: cover !important;">
            <div class="container-fluid">
                <div class="log-in">
                    <div class="nav-bar">
                        
                    </div>
                    <div class="row row-login">
                        <div class="col-lg-6 col-md-8 col-login-otr">
                            <div class="col-login-inr">
                                <div class="content">
                                    <h3 class="head heading-h3">Naija Art Mart</h3>
                                    <div class="login-social">
                                        <span class="line"></span>
                                        <p class="desc body-s">Registration Confirmation</p>
                                        <span class="line"></span>
                                    </div>
                                    <form class="form-main" method="post">
                                      <div align="center"  style="background:#F2DEDE; color:#A94481; padding:25px;">
                                        <?php echo $RegisterInfo; ?>
                                      </div>
                                      <div class="action-otr">
                                          <button id="btnLogin" class="button body-sb" type="button" onclick="window.location.href='<?php echo site_url("ui/Login"); ?>'">Login</button>
                                      </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="copy-otr-home2">
          <div class="container-fluid">
              <div class="copy-inr">
                  <a href="#" class="logo-otr">
                      <img class="logo" style="min-height: 40px; min-width: 30px; border-radius: 16px;" src="<?php echo base_url(); ?>/newassets/img/naija_art_mart1.png"  alt="brand-logo">
                  </a>
                  <div class="copy-name body-s">
                      Copyright © 2022  <a href="#" target="_blank" class="name body-sb">Naija Art Mart.</a>
                  </div>
                  <div class="all-rights">
                      <p class="all body-s">
                          All rights reserved.
                      </p>
                  </div>
              </div>
          </div>    
        </div>
        </div>

    <!--=======================================
            login End Here
    ========================================-->
    

    <script src="<?php echo base_url(); ?>/newassets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/jquery.countdown/jquery.countdown.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/tilt.js/dest/tilt.jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progress.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/js/app.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/general.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/js/aes256.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/js/sum().js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/js/back.js"></script>
</body>
</html>