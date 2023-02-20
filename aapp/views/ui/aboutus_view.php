<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Naija Art Mart | Contact Us</title>
    <?php include('fcss.php'); ?>
  </head>
  <body>
    <header
      class="innerpage-header"
      style="background-image: url(<?php echo base_url(); ?>assets/front/images/about-us-header.jpg);"
    >
      <nav class="navbar navbar-expand-lg fixed-top navbar-dark" style="background-color: black;">
        <a class="navbar-brand" href="<?php echo site_url('ui/Home'); ?>" >
            <img src="<?php echo base_url(); ?>assets/front/images/logo.png" width="" height="" alt="" loading="lazy" />
        </a>
        <button class="navbar-toggler" type="button"
          data-toggle="collapse"
          data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link text-white" href="<?php echo site_url('ui/Ourstory'); ?>">Our Story<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white active" href="<?php echo site_url('ui/Aboutus'); ?>" >Contact Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="<?php echo site_url('ui/Howitworks'); ?>" >How it works</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="<?php echo site_url('ui/Faq'); ?>">FAQ</a>
            </li>
            <!-- <li class="nav-item">
                  <a class="nav-link text-white" href="<?php //echo site_url('ui/Ourblog'); ?>">Our Blog</a>
                </li>-->
          </ul>
          <a href="<?php echo site_url('ui/Login'); ?>" class="btn btn-custom-3 my-2 ml-5 my-sm-0 text-white" type="submit">Login</a>
          <a href="<?php echo site_url('ui/Signup'); ?>" class="btn btn-custom-2 my-2 ml-2 my-sm-0 text-white" type="submit">Sign Up</a>
        </div>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6 pl-md-5">
            <h1 class="h1-home-header"> Contact Us </h1>
            <h4>Feel free to reach out to us if you have enquiries.</h4>
          </div>
        </div>
      </div>
    </header>

    <section id="listed-art" class="container-fluid my-5">
      <div class="row m-md-5" id="contact-us">
        <div class="col-md-3 pt-5 text-center text-md-left">
            <h1 class="mb-3">Contact Us</h1>
        </div>
        <div class="col-md-6 ml-md-5 pt-5">
            <form class="ml-md-10">
                <div class="form-group">
                  <input type="text" class="form-control" id="yourName" aria-describedby="emailHelp" placeholder="Enter your name">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" id="yourEmail" placeholder="Enter your email">
                </div>
                <div class="form-group">
                  <input type="tel" class="form-control" id="phone" placeholder="Enter phone number">
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="yourMessage" rows="6" placeholder="Enter your message"></textarea>
                  </div>
                <a type="submit" class="py-2 px-3 mt-3" style="background-color: #c53739; color: white;">Submit</a>
              </form>
        </div>
      </div>
    </section>

    <section class="container mb-5">
      <div class="row my-5">
        <div class="col-md-12">
          <hr style="background-color: #c53739; color: #c53739; opacity: 0.3;"/>
          <h1 class="h1-big">Be part of the art market</h1>
          <div class="d-md-flex">
            <h4 style="font-size: 65px; color: #c53739; font-weight: 300;">Make money while you enjoy art</h4>
            <div>
              <a href="" class="button-primary ml-5 px-3" style="position: absolute; margin-bottom: -5px;">Join Now</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php include('footer.php'); ?>

    <?php include('fscripts.php'); ?>
  </body>
</html>
