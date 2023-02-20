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
    <title> Naija Art Mart - How it works.</title>
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
            <div class="work-main how-it-work">
            <div class="container-fluid">
                <div class="wrapper">
                    <h3 class="head heading-h3">How Ethoz Works</h3>
                    <div class="teb-main">
                        <ul class="tabs">
                            <li class="tab-link-work tab-work1 active" data-tab="work1">
                                <p class="tab-p body-sb">For Creators</p>
                            </li>
                            <li class="tab-link-work tab-work2" data-tab="work2">
                                <p class="tab-p body-sb">For Collectors</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row-work">
                    <div id="tab-work1" class="tab-content active">
                        <div class="row row-work-inr">
                            <div class="col-lg-4 col-md-6 col-work-otr">
                                <div class="col-work-inr box1">
                                    <div class="icon-otr">
                                        <div class="icon-inr">
                                            <!-- <span class="bg-icon"></span>
                                            <svg class="icon" width="32" height="32" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity=".2" d="M5 24a2 2 0 002 2h20a1 1 0 001-1V11a1 1 0 00-1-1H7a2 2 0 01-2-2v16z" fill="#fff"/><path d="M5 8v16a2 2 0 002 2h20a1 1 0 001-1V11a1 1 0 00-1-1H7a2 2 0 01-2-2zm0 0a2 2 0 012-2h17" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M22.5 19.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" fill="#fff"/></svg> -->
                                        </div>
                                        <h4 class="heading heading-h4">Real-world artworks are turned into shares</h4>
                                    </div>
                                    <p class="desc body-m">In the Naija Art Mart ecosystem, real-world artworks are turned into shares, sold through a live sale, and traded on a dedicated exchange. We are opening the art market to the people and making art ownership secure, profitable and fun. Here’s how we do it.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-work-otr">
                                <div class="col-work-inr box3">
                                    <div class="icon-otr">
                                        <div class="icon-inr">
                                            <!-- <span class="bg-icon"></span>
                                            <svg class="icon" width="32" height="32" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity=".2" d="M16 16H5.5V6.5a1 1 0 011-1H16V16z" fill="#000"/><path d="M25.5 5.5h-19a1 1 0 00-1 1v19a1 1 0 001 1h19a1 1 0 001-1v-19a1 1 0 00-1-1zM16 5.5v21M26.5 16h-21" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> -->
                                        </div>
                                        <h4 class="heading heading-h4">How do we issue shares of real-world artworks?</h4>
                                    </div>
                                    <p class="desc body-m">We use Blockchain technology to divide the value of artworks into equal portions, the Digital Art Shares or DAS. The process allows us to issue real, tradable shares for physical assets like paintings and sculptures. DAS live on Blockchain, meaning that they can be securely bought and sold. Together with DAS, we issue a Modular Smart Contract that is also stored on Blockchain. The creation of a Modular Smart Contract guarantees that ownership rights of DAS are legally defined, protected, and immutable.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-work-otr">
                                <div class="col-work-inr box3">
                                    <div class="icon-otr">
                                        <div class="icon-inr">
                                            <!-- <span class="bg-icon"></span>
                                            <svg class="icon" width="32" height="32" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity=".2" d="M7.818 18h15.695a2 2 0 001.967-1.642L27 8H6l1.818 10z" fill="#fff"/><path d="M23 23H8.727L5.24 3.821A1 1 0 004.256 3H2M10 28a2.5 2.5 0 100-5 2.5 2.5 0 000 5zM23 28a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.818 18h15.695a2 2 0 001.967-1.642L27 8H6" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> -->
                                        </div>
                                        <h4 class="heading heading-h4">What is the listing about?</h4>
                                    </div>
                                    <p class="desc body-m">Once DAS are generated for the artwork, Naija Art Mart launches a live listing, selling shares at the same price. Our community can buy DAS of listed artworks directly with fiat currencies. The listing ends when all the art shares for an Artwork have been sold or on the agreed end date.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-work2" class="tab-content">
                        <div class="row row-work-inr">
                            <div class="col-lg-4 col-md-6 col-work-otr">
                                <div class="col-work-inr box1">
                                    <div class="icon-otr">
                                        <div class="icon-inr">
                                            <span class="bg-icon"></span>
                                            <svg class="icon" width="32" height="32" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity=".2" d="M5 24a2 2 0 002 2h20a1 1 0 001-1V11a1 1 0 00-1-1H7a2 2 0 01-2-2v16z" fill="#fff"/><path d="M5 8v16a2 2 0 002 2h20a1 1 0 001-1V11a1 1 0 00-1-1H7a2 2 0 01-2-2zm0 0a2 2 0 012-2h17" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M22.5 19.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" fill="#fff"/></svg>
                                        </div>
                                        <h4 class="heading heading-h4">Set Up Your Wallet</h4>
                                    </div>
                                    <p class="desc body-m">Set up your wallet and then you can create, sell & collect NFTs at Ethoz.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-work-otr">
                                <div class="col-work-inr box2">
                                    <div class="icon-otr">
                                        <div class="icon-inr">
                                            <span class="bg-icon"></span>
                                            <svg class="icon" width="32" height="32" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity=".2" d="M16 16H5.5V6.5a1 1 0 011-1H16V16z" fill="#000"/><path d="M25.5 5.5h-19a1 1 0 00-1 1v19a1 1 0 001 1h19a1 1 0 001-1v-19a1 1 0 00-1-1zM16 5.5v21M26.5 16h-21" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </div>
                                        <h4 class="heading heading-h4">Add Your NFTs</h4>
                                    </div>
                                    <p class="desc body-m">After setting up your wallet, you can add your NFTs on Ethoz.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-work-otr">
                                <div class="col-work-inr box3">
                                    <div class="icon-otr">
                                        <div class="icon-inr">
                                            <span class="bg-icon"></span>
                                            <svg class="icon" width="32" height="32" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity=".2" d="M7.818 18h15.695a2 2 0 001.967-1.642L27 8H6l1.818 10z" fill="#fff"/><path d="M23 23H8.727L5.24 3.821A1 1 0 004.256 3H2M10 28a2.5 2.5 0 100-5 2.5 2.5 0 000 5zM23 28a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.818 18h15.695a2 2 0 001.967-1.642L27 8H6" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </div>
                                        <h4 class="heading heading-h4">Sell Your NFTs</h4>
                                    </div>
                                    <p class="desc body-m">After adding your NFTs, you can list your NFTs for sale.</p>
                                </div>
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