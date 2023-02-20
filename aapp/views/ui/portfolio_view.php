<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
// echo "<pre>";
// print_r($LastestPixs); die;
$logged_in = true;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://www.naijaartmart.com/assets/images/favicon_artsquare_16x16.png" sizes="16x16">
    <title> Naija Art Mart | <?php echo $userType; ?> Portfolio</title>
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
    <script src="<?php echo base_url(); ?>/newassets/libs/jquery/dist/jquery.min.js"></script>

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
      <?php include 'mobNav.php'; ?>
  </div>
  <section class="hero-navbar-9">
    <?php
    include 'nav.php';

    ?>
    <div class="explore-artwork" style="padding-top: 12px !important;">
            <div class="container-fluid">
                <div class="explore-artwork-inr">
                    <div class="row create-inr">
                    <div class="col-lg-8 col-heading-otr">
                        <div class="heading-inr">
                            <h3 class="heading heading-h3"><?php echo $usertype ?> Portfolio</h3>
                            <p><?php echo $email; ?><br><span><?php echo $company ?></span></p>
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <?php 
                        if($usertype == 'Investor'){
                            ?>
                        <a class="view-p view-all" style="font-weight:bold; position:absolute; right:0;padding-right: 12px;margin-right: 40px;" href="<?php echo site_url('ui/Wallet') ?>">
                            <span style="color:inherit;" >Wallet Balance : &nbsp;</span> 
                            <span class="makebold size-15" style="color:inherit;"> ₦ 
                                <span style="top:0;" id="uiWalletBalance"> <?php echo number_format($balance,2); ?>
                                </span>
                            </span>
                        </a> 
                        <?php } ?>
                    </div>
                </div>
                    
                    <span class="line"></span>
                    <div class="row row-custom-main">
                        <table class="hover table table-bordered data-table display wrap" id="recorddisplay">
                          <thead>
                            <tr>
                                <th style="text-align:center" width="23%">INVESTOR</th>
                             
                                <th style="text-align:center" width="25%">ASSET</th>
                             
                                <th title="Available Tokens" style="padding-left:3px; padding-right:3px; text-align:center" width="11%">TOKENS</th>
                                
                                <th width="13%" style="padding-left:2px; padding-right:2px; text-align:center">PRICE BOUGHT</th>
                                <th style="text-align:center" width="13%">CURRENT PRICE</th>
                                
                                <th style="text-align:center" width="15%">LAST UPDATE</th>
                                <th style="text-align:center" width="15%">Action</th>
                            </tr>
                          </thead>

                          <tbody id="tbbody"></tbody>
                        </table>
                        
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

    <script src="<?php echo base_url(); ?>/newassets/libs/jquery.countdown/jquery.countdown.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/tilt.js/dest/tilt.jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progress.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/datatables.min.js"></script>

<script src="<?php echo base_url();?>assets/js/klorofil-common.js"></script>


    <script src="<?php echo base_url(); ?>/newassets/js/app.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="<?php echo base_url();?>assets/js/klorofil-common.js"></script>

    <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>

    <script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

    <script src="<?php echo base_url();?>assets/js/general.js"></script>

    <script src="<?php echo base_url();?>assets/js/sum().js"></script>


<script>
    var Title='Naija Art Mart Help';
    var m='',table;
    var Usertype='<?php echo $usertype; ?>';
    var Email='<?php echo $email; ?>';
        
       
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

    $(document).ready(function(e) {
        // $(function() {          
        //     $.blockUI.defaults.css = {};// clear out plugin default styling
        // });
        
        
        LoadPortfolios();           

        function LoadPortfolios()
        {
            try
            {
                timedAlert('Loading Portfolio. Please Wait...',2000,'','info');          
    
                $('#recorddisplay > tbody').html('');
            
                $.ajax({
                    url: "<?php echo site_url('ui/Portfolio/GetPortfolios');?>",
                    data:{email:Email,usertype:Usertype},
                    type: 'POST',
                    dataType: 'json',
                    success: function(dataSet,status,xhr) { 
                        
                        if (table) table.destroy();
                    
                        //f-filtering, l-length, i-information, p-pagination
                        table = $('#recorddisplay').DataTable( {
                            dom: '<"top"if>rt<"bottom"lp><"clear">',
                            responsive: true,
                            ordering: false,
                            autoWidth:false,
                            language: {zeroRecords: "No Portfolio Record Found"},
                            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],                                    
                            columnDefs: [
                                {
                                    "targets": [ 0,1,2,3,4,5,6],
                                    "visible": true
                                },
                                {
                                    "targets": [ 0,1,2,3,4,5 ],
                                    "orderable": true,
                                    "searchable": true
                                },
                                {
                                    "targets": [ 0,1,2,3,4,5,6 ],
                                    "searchable": true
                                },
                                { className: "dt-center", "targets": [ 0,1,2,3,4,5,6 ] }
                            ],                  
                            order: [[ 2, 'asc' ]],
                            data: dataSet, 
                            columns: [
                                { width: "23%" },//Investor
                                { width: "25%" },//Asset
                                { width: "11%" },//Tokens
                                { width: "13%" },//Price Bought
                                { width: "13%" },//Current Price
                                { width: "15%" },//Last Update
                                { width: "15%" }//Action
                            ],//23,25,13,13,13,13
                        } );            
                    },
                    error:  function(xhr,status,error) {
                        m='Error '+ xhr.status + ' Occurred: ' + error;
                        displayMessage(m, 'error',Title,'error');
                    }
                });
            }catch(e)
            {
                m='LoadPortfolios ERROR:\n'+e;
                displayMessage(m, 'error',Title,'error');
            }
        }
        
    });
    </script>
</body>
</html>