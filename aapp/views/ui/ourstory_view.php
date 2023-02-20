<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naija Art Mart | Our Story</title>
    
    <?php include('fcss.php'); ?>

</head>
<body>
    <header class="innerpage-header" style="background-image: url(<?php echo base_url(); ?>assets/front/images/our-story-header.jpg);">
        
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: black;">
            <a class="navbar-brand" href="<?php echo site_url('ui/Home'); ?>"><img src="<?php echo base_url(); ?>assets/front/images/logo.png" width="" height="" alt="" loading="lazy"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                  <a class="nav-link text-white active" href="<?php echo site_url('ui/Ourstory'); ?>">Our Story<span class="sr-only">(current)</span></a>
                </li>
                
                <li class="nav-item">
                  <a class="nav-link text-white" href="<?php echo site_url('ui/Aboutus'); ?>">Contact Us</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-white" href="<?php echo site_url('ui/Howitworks'); ?>">How it works</a>
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
                <div class="col-md-6" style="padding-left: 5%;">
                    <h1 class="h1-home-header">Our Story</h1>
                    <h4>Shape the future of the art market with us.</h4>
                </div>
            </div>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="row" style="display: flex; justify-content: center; align-items: center;">
                <div class="col-md-6 my-5 order-md-2">
                    <img src="<?php echo base_url(); ?>assets/front/images/shape-the-future.jpg" alt="" class="img-fluid">
                </div>
                <div class="col-md-6 my-md-5">
                    <h1 style="font-size: 66px;">Shape the future of the art market with us.</h1>
                    <p>We believe that the future of art ownership is digitally-based and built on affordability and flexibility.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr>
                </div>
                
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="card p-3 m-4 m-md-0 ">
                        <div class="text-center my-3">
                            <img src="<?php echo base_url(); ?>assets/front/images/co-own-icon.png" alt="" width="100px">
                        </div>
                       
                        <h5 class="text-center py-2" style="color: #c53739;">Digital Co-Ownership</h5>
                        <div></div>
                        <p>We are committed to changing the art market through the principles of a digital sharing economy. When art is shareable and co-owned, all of us can afford it.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 m-4 m-md-0">
                        <div class="text-center my-3">
                            <img src="<?php echo base_url(); ?>assets/front/images/arttist-icon.png" alt="" width="100px">
                        </div>
                       
                        <h5 class="text-center py-2" style="color: #c53739;">World-Class Artists</h5>
                        <div></div>
                        <p>We work with a network of art galleries and private collectors who share our vision. They bring works by world-class artists with a strong market record, we add the innovation.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 m-4 m-md-0">
                        <div class="text-center my-3">
                            <img src="<?php echo base_url(); ?>assets/front/images/authentic-icon.png" alt="" width="100px">
                        </div>
                       
                        <h5 class="text-center py-2" style="color: #c53739;">Authentic and Certified</h5>
                        <div></div>
                        <p>Our Art Department views and examines all the artworks to be listed. In collaboration with a top-notch art advisory firm, we certify their authenticity and review their documentation.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 m-4 m-md-0">
                        <div class="text-center my-3">
                            <img src="<?php echo base_url(); ?>assets/front/images/transparent-icon.png" alt="" width="100px">
                        </div>
                       
                        <h5 class="text-center py-2" style="color: #c53739;">Transparent and Secure</h5>
                        <div></div>
                        <p>We applied the Blockchain’s potential for security and transparency to the creation of a legal ownership agreement. The tool makes ownership of DAS safe and hassle-free for buyers and owners.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center py-5">
                        <a href="" class="py-2 px-3 mt-5" style="background-color: #c53739; color: white;" >Join Now</a>
                    </div>
                    
                    <hr>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row" style="display: flex; justify-content: center; align-items: center;">
                <div class="col-md-6 my-5 order-md-2">
                    <img src="<?php echo base_url(); ?>assets/front/images/the-art-market.jpg" alt="" class="img-fluid">
                </div>
                <div class="col-md-6 my-5">
                    <h1 style="font-size: 66px;">The art market has been closed off to people for far too long</h1>
                    <p class="mb-5">Naija Art Mart is tearing down the main barriers to entry to the art market: usability and accessibility. We select artworks by masters of contemporary art and turn them into affordable digital shares. Our community can become co-owners of art with a small budget.</p>
                    <a href="<?php echo site_url('ui/Signup'); ?>" class="py-2 px-3 mt-5" style="background-color: #c53739; color: white;" >Join Now</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row" style="display: flex; justify-content: center; align-items: center;">
                <div class="col-md-6 my-5">
                    <img src="<?php echo base_url(); ?>assets/front/images/we-have-designed.jpg" alt="" class="img-fluid">
                </div>
                <div class="col-md-6 my-5">
                    <h1 style="font-size: 66px;">We have designed a whole market ecosystem</h1>
                    <p>The Naija Art Mart enables our community to make a profit out of art. This is the place to trade and divest your shares. We are confident that in the near future only listed, tradable artworks will be considered valuable assets by art collectors, auction houses, and investors.</p>
                    <a href="<?php echo site_url('ui/Signup'); ?>" class="py-2 px-3 mt-5" style="background-color: #c53739; color: white;" >Join Now</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row" style="display: flex; justify-content: center; align-items: center;">
                <div class="col-md-6 my-5 order-md-2">
                    <img src="<?php echo base_url(); ?>assets/front/images/the-art-market.jpg" alt="" class="img-fluid">
                </div>
                <div class="col-md-6 my-5">
                    <h1 style="font-size: 66px;">Naija Art Mart is committed to continuity and diversification</h1>
                    <p class="mb-5">We strive to offer a mixed range of artworks to our community. This is key to a well-diversified and profitable Portfolio. As you add shares of various artworks to your Portfolio, you are also putting together an art collection that you’re sharing with other co-owners.</p>
                    <a href="<?php echo site_url('ui/Signup'); ?>" class="py-2 px-3 mt-5" style="background-color: #c53739; color: white;" >Join Now</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="row my-5">
            <div class="col-md-12">
                <h1 class="h1-big">Be part of the art market</h1>
                <div class="d-md-flex">
                    <h4 style="font-size: 65px; color: #c53739; font-weight: 300;">Make money while you enjoy art</h4>
                    <div><a href="" class="button-primary ml-5 px-3" style="position: absolute; margin-bottom: -5px;">Join Now</a></div>
                </div>
                
            </div>
        </div>
        
    </section>

    
 	<?php include('footer.php'); ?>
    
    <?php include('fscripts.php'); ?>
    
</body>
</html>