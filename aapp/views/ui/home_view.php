<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$logged_in = false;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://www.naijaartmart.com/assets/images/d_favicon.png" sizes="16x16">
    <title> Derived Homes - Real Estate for Everyone.</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/remixicon/fonts/remixicon.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/assets/owl.theme.default.min.css">
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progressjs.css"> -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/fonts/fonts.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/css/app.css">
    <!-- <style type="text/css">
        .body-sb{
        font-family: cursive !important; 
      }
      .body-s{
        font-family: cursive !important; 
      }
    </style> -->
</head>
<body>


    <!--=======================================
                Modal Start Here
    ========================================-->

        <div id="myNav" class="overlay-content-otr">
            <?php include 'mobNav.php'; ?>
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
            <?php /*<!-- <div class="hero-main">
                <div class="container-fluid">
                    <div class="row row-custom">
                        <div class="col-lg-6 col-content-otr">
                            <div class="col-content-inr">
                                <h1 class="heading-h1 ">Art Market For Everyone.</h1>
                                <p class="body-l desc">Partner with one of the world’s largest retailers to showcase your brand and products. Partner showcase and products.</p>
                                <div class="action-otr">
                                    <?php if (!$logged_in) {?>
                                    <div class="action">
                                        <a href="<?php echo site_url('ui/Login'); ?>" class="btn-fill place-btn body-sb">Sign In</a>
                                    </div>
                                    <div class="action">
                                        <a href="<?php echo site_url('ui/Signup'); ?>" class="btn-outline1 view-btn body-sb">Get Started</a>
                                    </div>
                                    <?php }
                                    ?>
                                </div>
                                <div class="statistics-otr">
                                    <div class="content box-1">
                                        <h2 class="heading-h2 num">2M+</h2>
                                        <p class="body-sb text">Exclusive Product</p>
                                    </div>
                                    <div class="content box-2">
                                        <h2 class="heading-h2 num">2k+</h2>
                                        <p class="body-sb text">Digital Artist</p>
                                    </div>
                                    <div class="content box-3">
                                        <h2 class="heading-h2 num">22k+</h2>
                                        <p class="body-sb text">Auction</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-slide-otr">
                            <div class="swiper swiper-slider4" id="swiper4">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="img-otr">
                                            <img class="img-innr img-fluid" src="<?php echo base_url(); ?>/newassets/img/cover-img1.jpg" alt="img">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="img-otr">
                                            <img class="img-innr img-fluid" src="<?php echo base_url(); ?>/newassets/img/cover-img2.jpg" alt="img">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="img-otr">
                                            <img class="img-innr img-fluid" src="<?php echo base_url(); ?>/newassets/img/cover-img3.jpg" alt="img">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="img-otr">
                                            <img class="img-innr img-fluid" src="<?php echo base_url(); ?>/newassets/img/cover-img4.jpg" alt="img">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="img-otr">
                                            <img class="img-innr img-fluid" src="<?php echo base_url(); ?>/newassets/img/cover-img5.jpg" alt="img">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="img-otr">
                                            <img class="img-innr img-fluid" src="<?php echo base_url(); ?>/newassets/img/cover-img6.jpg" alt="img">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="img-otr">
                                            <img class="img-innr img-fluid" src="<?php echo base_url(); ?>/newassets/img/cover-img7.jpg" alt="img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->*/?>
            
            <div class="hero-main">
                <div class="container-fluid">
                    <div class="row row-custom">
                        <div class="col-lg-6 col-content-otr">
                            <div class="col-content-inr">
                                <h1 class="heading-h1 heading">Easily Invest in rental homes & Vacation rentals</h1>
                                <p class="body-l desc">Buy shares of properties, earn rental income and appreciation -- Let Derived Homes take care of the rest.</p>
                                <div class="action-otr">
                                    <?php 
                                    if ($logged_in) {?>
                                        <div class="action">
                                            <a href="<?php echo site_url('ui/Login'); ?>" class="btn-fill place-btn">Buy Tokens</a>
                                        </div>
                                        <div class="action">
                                            <a href="<?php echo site_url('ui/Signup'); ?>" class="btn-outline1 view-btn">Get Started</a>
                                        </div>
                                    <?php }else{?>
                                        <div class="action">
                                            <a href="#" class="btn-fill place-btn">Buy Tokens</a>
                                        </div>
                                        <div class="action">
                                            <a href="#" class="btn-outline1 view-btn">Invest in Real Estate</a>
                                        </div>
                                    <?php }

                                    ?>
                                    
                                </div>
                                <div class="statistics-otr">
                                    <div class="content box-1">
                                        <h2 class="heading-h2 num">2M+</h2>
                                        <p class="body-s text">Exclusive Product</p>
                                    </div>
                                    <div class="content box-2">
                                        <h2 class="heading-h2 num">2k+</h2>
                                        <p class="body-s text">Digital Artist</p>
                                    </div>
                                    <div class="content box-3">
                                        <h2 class="heading-h2 num">22k+</h2>
                                        <p class="body-s text">Auction</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-imgs-otr">
                            <div class="row col-imgs-inr">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-img-otr">
                                    <div class="col-img-inr">
                                        <img class="img" src="https://www.naijaartmart.com/assets/front/images/derived1.jpg" alt="img">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-img-otr">
                                    <div class="col-img-inr">
                                        <img class="img" src="https://www.naijaartmart.com/assets/front/images/derived2.jpg" alt="img">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-img-otr">
                                    <div class="col-img-inr">
                                        <img class="img" src="https://www.naijaartmart.com/assets/front/images/derived3.jpg" alt="img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div> 
            <div class="explore-artwork-home2">
            <div class="container-fluid">
                <div class="explore-artwork-inr">
                    <div class="heading-otr">
                        <div class="head-otr">
                            <h3 class="heading heading-h3">Explore Artworks</h3>
                        </div>
                        
                    </div>
                    <span class="line"></span>
                    <div class="row row-custom-main">
                        <div class="row row-custom-inr">
                        <?php 
                        if (count($LastestPixs) > 0)
                        {
                            foreach($LastestPixs as $row) {
                                $url='&nbsp;';
                                if ($row->blockchainUrl) {
                                    $url='<a class="redtext" title="Click To View Asset Blockchain Details" target="_blank" href="'.$row->blockchainUrl.'"><i>View Asset Blockchain Record</i></a>';
                                } ?>

                            <div class="col-otr col-lg-3 mb-2">
                                <div class="col-inr box1" style="padding:8px !important; background:#f2f2f2;box-shadow: 4px 4px 6px #e1dbdb; border-radius:6px;">
                                    <div class="img-otr">
                                        <a href="<?php echo site_url('ui/Directinvestorprymarket') ?>" class="tilt-otr img-tilt" style="width: 100%; height: 100%; overflow: hidden; pointer-events: none;" data-tilt>
                                            <img class="img-inr img-fluid" src="<?php echo base_url().'art-works/'.trim($row->pix) ?>" style="width: 100%; height:250px" alt="artwork-img">
                                        </a>
                                    </div>
                                    <div class="time-main" style="padding:2px !important; background:#ffffff; border-radius:6px;">
                                        <a style="align-content: center; color: darkgray;" href="<?php echo site_url('ui/Directinvestorprymarket') ?>" class="body-mb box-head"><center><?php echo trim($row->title) ?></center></a>
                                        <p class="body-sb num"><center>By <i><?php echo ucwords(trim($row->artist)) ?> </i></center></p>
                                    </div>
                                    
                                    <div class="bid-main" style="display:flex; width:100%;padding: 12px;">
                                        <p class="body-sb " style="width:40%;position: relative;align-content: left;">Price : </p>
                                        <p class="body-mb " style="width:60;position: relative;align-text: right;"><?php echo '₦'.number_format($row->price_on_issue,2) ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php }             
                            }
                        ?>
                        </div>
                    </div>
                </div>
        </section>

    <!--=======================================
                Navbar/Hero End Here
    ========================================-->

    <!--=======================================
            Copy Section Start Here
    ========================================-->

        <div class="copy-otr-home2">
            <div class="container-fluid">
                <div class="copy-inr">
                    <a href="#" class="logo-otr">
                        <img class="logo" style="min-height: 40px; min-width: 30px; border-radius: 16px;" src="<?php echo base_url(); ?>/newassets/img/derivedlogo.png"  alt="brand-logo">
                    </a>
                    <div class="copy-name body-s">
                        Copyright © <?php echo date('Y') ?>  <a href="#" target="_blank" class="name body-sb">Derived Homes</a>
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
    <!-- <script src="<?php echo base_url(); ?>/newassets/libs/jquery.countdown/jquery.countdown.js"></script> -->
    <script src="<?php echo base_url(); ?>/newassets/libs/tilt.js/dest/tilt.jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/swiper/swiper-bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progress.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/js/app.js"></script>
</body>
</html>