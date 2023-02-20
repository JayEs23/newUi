<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php

// print_r($LastestPixs); die();

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
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progressjs.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/fonts/fonts.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/css/app.css">
</head>
<body>


    <!--=======================================
                Modal Start Here
    ========================================-->

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
            <div class="terms-of-services">
            <div class="container-fluid">
                <div class="head-otr">
                    <h2 class="heading-h2 heading">Terms of Service</h2>
                </div>
                <span class="line"></span>
                <div class="wrapper">
                    <p class="desc para body-m">
                        This Privacy Policy document contains types of information that is collected 
                        and recorded by Website Name and how we use it.
                    </p>
                    <p class="desc para body-m">
                        If you have additional questions or require more information about our Privacy 
                        Policy, do not hesitate to contact us through email at contact@Ethoz.com
                    </p>
                    <p class="desc body-m">
                        This privacy policy applies only to our online activities and is valid for visitors to our 
                        website with regards to the information that they shared and/or collect in Website Name. This policy 
                        is not applicable to any information collected offline or via channels other than this website.
                    </p>
                    <h3 class="heading-h3 head">Consent</h3>
                    <p class="desc body-m">
                        By using our website, you hereby consent to our Privacy Policy and agree to its terms.
                    </p>
                    <h3 class="heading-h3 head">Information We Collect</h3>
                    <p class="desc para body-m">
                        The personal information that you are asked to provide, and the reasons why you 
                        are asked to provide it, will be made clear to you at the point we ask you to 
                        provide your personal information.
                    </p>
                    <p class="desc para body-m">
                        If you contact us directly, we may receive additional information about you such as your 
                        name, email address, phone number, the contents of the message and/or attachments you may 
                        send us, and any other information you may choose to provide.
                    </p>
                    <p class="desc body-m">
                        When you register for an Account, we may ask for your contact information, including items 
                        such as name, company name, address, email address, and telephone number.
                    </p>
                    <h3 class="heading-h3 head">Log Files</h3>
                    <p class="desc body-m">
                        Website Name follows a standard procedure of using log files. These files log visitors when 
                        they visit websites. All hosting companies do this and a part of hosting services' analytics. 
                        The information collected by log files include internet protocol (IP) addresses, browser type, 
                        Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the 
                        number of clicks. These are not linked to any information that is personally identifiable. 
                        The purpose of the information is for analyzing trends, administering the site, tracking users' 
                        movement on the website, and gathering demographic information.
                    </p>
                    <h3 class="heading-h3 head">Cookies And Web Beacons</h3>
                    <p class="desc body-m">
                        Like any other website, Website Name uses ‘cookies'. These cookies are used to store information 
                        including visitors' preferences, and the pages on the website that the visitor accessed or visited. 
                        The information is used to optimize the users' experience by customizing our web page content 
                        based on visitors' browser type and/or other information.
                    </p>
                    <h3 class="heading-h3 head">Children's Information</h3>
                    <p class="desc para body-m">
                        Another part of our priority is adding protection for children while using the internet. 
                        We encourage parents and guardians to observe, participate in, and/or monitor and 
                        guide their online activity.
                    </p>
                    <p class="desc body-m">
                        Website Name does not knowingly collect any Personal Identifiable Information from children 
                        under the age of 13. If you think that your child provided this kind of information on our 
                        website, we strongly encourage you to contact us immediately and we will do our best efforts 
                        to promptly remove such information from our records.
                    </p>
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
    <!-- <script src="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progress.js"></script> -->
    <script src="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/js/app.js"></script>
</body>
</html>