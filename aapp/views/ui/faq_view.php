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
    <link rel="icon" href="https://www.naijaartmart.com/assets/images/favicon_artsquare_16x16.png" sizes="16x16">
    <title> Naija Art Mart - Art for Everyone.</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/assets/owl.theme.default.min.css">
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progressjs.css"> -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/fonts/fonts.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/css/app.css">
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
            <div class="Help-center-main">
            <div class="container-fluid">
                <div class="Help-center-inr">
                    <div class="heading-otr">
                        <div class="head-otr">
                            <h3 class="heading heading-h3">Help Center</h3>
                        </div>
                    </div>
                    <div class="tab-otr">
                        <ul class="tabs">
                            <li class="tab-link tab-1 active" data-tab="1">
                                <p class="tab-p body-sb">Frequently asked Questions</p>
                            </li>
                        </ul>
                    </div>
                    <span class="line"></span>
                    <div class="row row-custom-main">
                        <div id="tab-1" class="tab-content active">
                            <div class="row row-question">
                                <div class="col-lg-6 col-q-otr">
                                    <div class="col-q-inr box-1">
                                        <div class="content-main">
                                            <a href="#" class="link">
                                                <span class="icon-otr">
                                                    <svg class="text-icon" width="18" height="22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.2 20.199H1.8a.8.8 0 01-.8-.8V1.8a.8.8 0 01.8-.8h9.6L17 6.6v12.8a.8.8 0 01-.8.799v0z" stroke="#366CE3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.4 1v5.6H17M5.799 11.4h6.4M5.799 14.6h6.4" stroke="#366CE3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                </span>
                                                <details class="body-sb">
                                                  <summary class="text body-mb text-dark">How is an artwork sold on the platform?</summary>
                                                  <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                                                </details>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-q-otr">
                                    <div class="col-q-inr box-1">
                                        <div class="content-main">
                                            <a href="#" class="link">
                                                <span class="icon-otr">
                                                    <svg class="text-icon" width="18" height="22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.2 20.199H1.8a.8.8 0 01-.8-.8V1.8a.8.8 0 01.8-.8h9.6L17 6.6v12.8a.8.8 0 01-.8.799v0z" stroke="#366CE3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.4 1v5.6H17M5.799 11.4h6.4M5.799 14.6h6.4" stroke="#366CE3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                </span>
                                                <details class="body-sb">
                                                  <summary class="text body-mb text-dark">How are digital art shares of artworks issued?</summary>
                                                  <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                                                </details>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-q-otr">
                                    <div class="col-q-inr box-1">
                                        <div class="content-main">
                                            <a href="#" class="link">
                                                <span class="icon-otr">
                                                    <svg class="text-icon" width="18" height="22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.2 20.199H1.8a.8.8 0 01-.8-.8V1.8a.8.8 0 01.8-.8h9.6L17 6.6v12.8a.8.8 0 01-.8.799v0z" stroke="#366CE3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.4 1v5.6H17M5.799 11.4h6.4M5.799 14.6h6.4" stroke="#366CE3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                </span>
                                                <details class="body-sb">
                                                  <summary class="text body-mb text-dark">How can I add funds to my wallet?</summary>
                                                  <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                                                </details>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-q-otr">
                                    <div class="col-q-inr box-1">
                                        <div class="content-main">
                                            <a href="#" class="link">
                                                <span class="icon-otr">
                                                    <svg class="text-icon" width="18" height="22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.2 20.199H1.8a.8.8 0 01-.8-.8V1.8a.8.8 0 01.8-.8h9.6L17 6.6v12.8a.8.8 0 01-.8.799v0z" stroke="#366CE3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.4 1v5.6H17M5.799 11.4h6.4M5.799 14.6h6.4" stroke="#366CE3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                </span>
                                                <details class="body-sb">
                                                  <summary class="text body-mb text-dark">How is an artwork sold on the platform?</summary>
                                                  <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                                                </details>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-q-otr">
                                    <div class="col-q-inr box-1">
                                        <div class="content-main">
                                            <a href="#" class="link">
                                                <span class="icon-otr">
                                                    <svg class="text-icon" width="18" height="22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.2 20.199H1.8a.8.8 0 01-.8-.8V1.8a.8.8 0 01.8-.8h9.6L17 6.6v12.8a.8.8 0 01-.8.799v0z" stroke="#366CE3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.4 1v5.6H17M5.799 11.4h6.4M5.799 14.6h6.4" stroke="#366CE3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                </span>
                                                <details class="body-sb">
                                                  <summary class="text body-mb text-dark">How is an artwork sold on the platform?</summary>
                                                  <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                                                </details>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-lg-12 col-btn-otr">
                            <div class="col-btn-inr">
                                <h5 class="head heading-h5">Make money while you enjoy art</h5>
                                <a href="<?php echo site_url('ui/Signup'); ?>" class="btn-fill btn-more">Join Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>

    <!--=======================================
                Navbar/Hero End Here
    ========================================-->
    <?php include 'footer.php'; ?>
    <!--=======================================
            Copy Section Start Here
    ========================================-->

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
</body>
</html>