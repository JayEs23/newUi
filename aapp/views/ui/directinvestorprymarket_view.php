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
    <link rel="icon" href="https://www.naijaartmart.com/assets/images/d_favicon.png" sizes="16x16">
    <title>Derived Homes| <?php echo $usertype; ?> Primary Market</title>
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
  <style type="text/css">
    .box-below {
      display: flex;
      justify-content: space-between;
      padding-inline: 8px;
      align-items: center;
      font-family: "DMSans-Bold";
      color: #212529;
      font-size: 14px;
    }
    .img-fluid {
      width: 100%;
      height: 250px;
      background-size: contain;
    }
    .body-sb{
      font-family: inherit; !important;
    }
    .body-s{
      font-family: inherit; !important;
    }

    @import url('https://fonts.googleapis.com/css?family=Muli:400,400i,700,700i');
    body{
      font-family: 'Muli', sans-serif;
      background:white;
    }
    .shell{
      padding:80px 0;
    }
    .wsk-cp-product{
      background:#fff;
      padding:15px;
      border-radius:6px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
      position:relative;
      margin:20px auto;
    }
    .wsk-cp-img{
      position:absolute;
      top:5px;
      left:50%;
      transform:translate(-50%);
      -webkit-transform:translate(-50%);
      -ms-transform:translate(-50%);
      -moz-transform:translate(-50%);
      -o-transform:translate(-50%);
      -khtml-transform:translate(-50%);
      width: 100%;
      padding: 15px;
      transition: all 0.2s ease-in-out;
    }
    .wsk-cp-img img{
      width:100%;
      transition: all 0.2s ease-in-out;
      border-radius:6px;
    }
    .wsk-cp-product:hover .wsk-cp-img{
      top:-40px;
    }
    .wsk-cp-product:hover .wsk-cp-img img{
      box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);
    }
    .wsk-cp-text{
      padding-top:85%;
    }
    .wsk-cp-text .category{
      text-align:center;
      font-size:12px;
      font-weight:bold;
      padding:5px;
      margin-bottom:45px;
      position:relative;
      transition: all 0.2s ease-in-out;
    }
    .wsk-cp-text .category > *{
      position:absolute;
      top:50%;
      left:50%;
      transform: translate(-50%,-50%);
      -webkit-transform: translate(-50%,-50%);
      -moz-transform: translate(-50%,-50%);
      -ms-transform: translate(-50%,-50%);
      -o-transform: translate(-50%,-50%);
      -khtml-transform: translate(-50%,-50%);

    }
    .wsk-cp-text .category > span{
      padding: 12px 30px;
      border: 1px solid #313131;
      background:#000113;
      color:#fff;
      box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);
      border-radius:27px;
      opacity: .9;
      transition: all 0.05s ease-in-out;

    }
    .wsk-cp-product:hover .wsk-cp-text .category > span{
      border-color:#ddd;
      box-shadow: none;
      padding: 11px 28px;
    }
    .wsk-cp-product:hover .wsk-cp-text .category{
      margin-top: 0px;
    }
    .wsk-cp-text .title-product{
      text-align:center;
    }
    .wsk-cp-text .title-product h3{
      font-size:20px;
      font-weight:bold;
      margin:15px auto;
      overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
      width:100%;
    }
    .wsk-cp-text .description-prod p{
      margin:0;
    }
    /* Truncate */
    .wsk-cp-text .description-prod {
      text-align:center;
      width: 100%;
      height:62px;
      overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
      margin-bottom:15px;
    }
    .card-footer{
      padding: 25px 0 5px;
      border-top: 1px solid #ddd;
    }
    .card-footer:after, .card-footer:before{
      content:'';
      display:table;
    }
    .card-footer:after{
      clear:both;
    }

    .card-footer .wcf-left{
      float:left;

    }

    .card-footer .wcf-right{
      float:right;
    }

    .price{
      font-size:18px;
      font-weight:bold;
      color: #000017 !important;
    }

    a.buy-btn{
      display:block;
      color:#212121;
      text-align:center;
      font-size: 18px;
      width:35px;
      height:35px;
      line-height:35px;
      border-radius:50%;
      border:1px solid #212121;
      transition: all 0.2s ease-in-out;
    }
    a.buy-btn:hover , a.buy-btn:active, a.buy-btn:focus{
      border-color: #FF9800;
      background: #FF9800;
      color: #fff;
      text-decoration:none;
    }
    .wsk-btn{
      display:inline-block;
      color:#212121;
      text-align:center;
      font-size: 18px;
      transition: all 0.2s ease-in-out;
      border-color: #FF9800;
      background: #FF9800;
      padding:12px 30px;
      border-radius:27px;
      margin: 0 5px;
    }
    .wsk-btn:hover, .wsk-btn:focus, .wsk-btn:active{
      text-decoration:none;
      color:#fff;
    }
    .red{
      color:#F44336;
      font-size:22px;
      display:inline-block;
      margin: 0 5px;
    }
    @media screen and (max-width: 991px) {
      .wsk-cp-product{
        margin:40px auto;
      }
      .wsk-cp-product .wsk-cp-img{
          top:-40px;
        }
        .wsk-cp-product .wsk-cp-img img{
          box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);
        }
          .wsk-cp-product .wsk-cp-text .category > span{
          border-color:#ddd;
          box-shadow: none;
          padding: 11px 28px;
        }
        .wsk-cp-product .wsk-cp-text .category{
          margin-top: 0px;
        }
        a.buy-btn{
          border-color: #FF9800;
          background: #FF9800;
          color: #fff;
        }
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
            <div class="container-fluid" style="font-family: inherit; !important;" >
                <div class="explore-artwork-inr">
                    <div class="row create-inr">
                    <div class="col-lg-8 col-heading-otr">
                        <div class="heading-inr">
                            <h3 class=""><?php echo $usertype; ?>  Primary Market</h3>
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
                    <div class="teb-main">
                        <div class="tab-otr">
                            <div class="tab-inr">
                                <ul class="tabs">
                                    <li class="tab-link tab-1 active" data-tab="1">
                                        <p class="tab-p body-sb">Market</p>
                                    </li>
                                    <!-- <li class="tab-link tab-2 " data-tab="2">
                                        <p class="tab-p body-sb">Trades History</p>
                                    </li>
                                    <li class="tab-link tab-3 " data-tab="3">
                                        <p class="tab-p body-sb">News</p>
                                    </li> -->
                                    
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                    <span class="line"></span>
                    <div class="row row-custom-main">
                        <div id="tab-1" class="tab-content active">
                            <div class="row row-custom-inr">
                                
                            	<?php 
								if (count($LastestPixs) > 0)
								{
									foreach($LastestPixs as $row) {
										$url='&nbsp;';
										if ($row['blockchainUrl']) {
											$url='<a class="redtext" title="Click To View Asset Blockchain Details" target="_blank" href="'.$row['blockchainUrl'].'"><i>View Asset Blockchain Record</i></a>';
										} ?>
                    <div class="col-md-3">
                        <div class="wsk-cp-product">
                          <div class="wsk-cp-img">
                                <a href="<?php echo site_url('ui/Directinvestorprymarket/ArtworkDetails/').$row['art_id'] ?>" class="tilt-otr img-tilt" data-tilt="">
                                <img class="img-inr img-fluid img-responsive" src="<?php echo base_url().'art-works/'.trim($row['pix']) ?>" alt="artwork-img">
                                <div class="js-tilt-glare" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; overflow: hidden; pointer-events: none;">
                                    <div class="js-tilt-glare-inner" style="position: absolute; top: 50%; left: 50%; background-image: linear-gradient(0deg, rgba(255, 255, 255, 0) 0%, rgb(255, 255, 255) 100%); width: 761px; height: 761px; transform: rotate(180deg) translate(-50%, -50%); transform-origin: 0% 0%; opacity: 0;"></div>
                                </div>
                            </a>
                          </div>
                          <div class="wsk-cp-text">
                            <div class="category">
                              <span><?php echo ucwords(trim($row['artist'])) ?> </span>
                            </div>
                            <div class="title-product">
                              <h3><?php echo trim($row['title']) ?></h3>
                            </div>
                            <div class="card-footer">
                              <div class="wcf-left">Artwork Value : <span class="price"><?php echo '₦'.number_format($row['artwork_value'],2) ?> &nbsp; <br></span></div>
                              <div class="wcf-left">Price per Token : <span class="price"><?php echo '₦'.number_format($row['price'],2) ?></span></div>
                              <div class="wcf-right"><a href="<?php echo site_url('ui/Directinvestorprymarket/ArtworkDetails/').$row['art_id'] ?>" class="buy-btn"><i class="fa fa-shopping-cart"></i></a></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    
                    <?php }				
        						}else{ ?>
                      <div class="row">
                        <div class="col-lg-12">
                          <h4 style="text-align:center;" class="justify-content-center text-danger">There are no active listings at the moment</h4>
                        </div>
                      </div>

                    <?php }
        					?>
                                
                            </div>
                        </div>
                        <div id="tab-2" class="tab-content">
                            <div class="row row-custom-inr">
                                <div id="trade" >
                                  <!--Start Date/End Date-->                                       
                                    <div class="position-relative row form-group">
                                         <!--Start Date--> 
                                        <label title="Start Date" for="txtTradeStartDate" class="col-sm-2 col-form-label text-right">Start Date</label>
                                    
                                        <div title="Start Date" class="col-sm-3 date tradedatepicker">
                                            <div class="input-group">
                                                <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtTradeStartDate" placeholder="Trade Start Date">
                                                
                                                <span class="input-group-btn"><button class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                            </div>
                                         </div>
                                         
                                          <!--End Date--> 
                                          <label title="End Date" for="txtTradeEndDate" class="col-sm-2 col-form-label text-right">End Date</label>
                                    
                                        <div title="End Date" class="col-sm-3 date tradedatepicker">
                                            <div class="input-group">
                                                <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtTradeEndDate" placeholder="Trade End Date">
                                                
                                                <span class="input-group-btn"><button class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                            </div>
                                            
                                         </div>
                                         
                                         <!--Display Trade-->
                                         <div title="Click to display trades" class="col-sm-2">
                                            <button id="btnDisplayTrades" type="button" class="btn btn-primary form-control makebold">DISPLAY TRADES</button>
                                         </div>
                                    </div>
                        
                                  <table class="hover table table-bordered data-table display wrap" id="tabTrades">
                                      <thead>
                                        <tr>
                                            <th style="text-align:center" width="15%">TRADE DATE</th>
                                            <th style="text-align:center" width="13%">TRADE ID</th>
                                            <th style="text-align:center" width="11%">ASSET</th> 
                                            <th style="text-align:center" width="11%">TOKENS</th>
                                            <th style="text-align:right; padding-right:7px;" width="10%">PRICE</th>
                                            <th style="text-align:right; padding-right:7px;" width="14%">AMOUNT</th>
                                            <th style="text-align:center" width="13%">SELLER</th>
                                            <th style="text-align:center" width="13%">BUYER</th>
                                        </tr>
                                      </thead>

                                      <tbody id="tbtradebody"></tbody>
                                      
                                        <tfoot style="color:#ffffff; background-color:#7E7B7B;">
                                                <tr>
                                                    <th colspan="5" style="text-align:right; padding:3px; padding-right:10px; font-weight:bold; font-size:13px;" width="54%">TOTAL TRADE AMOUNT (₦):</th>
                                                    
                                                    <th id="tdAmount" style="text-align:right; padding:3px; padding-right:8px; font-weight:bold; font-size:12px;" width="14%"></th>
                                                    
                                                     <th colspan="2" id="tdAmount" style="text-align:right; padding:3px; padding-right:8px; font-weight:bold; font-size:12px;" width="26%"></th>
                                                </tr>
                                          </tfoot>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                        <div id="tab-3" class="tab-content">
                            <div class="row row-custom-inr">
                                <div id="news" >
                                    <table class="hover table table-bordered data-table display wrap" id="tabNews">
                                      <thead>
                                        <tr>
                                            <th style="text-align:center" width="12%">DATE</th>
                                            <th style="text-align:center" width="53%">HEADER</th>
                                            <th style="text-align:center;" width="30%">SENDER</th>
                                            <th title="Click Icon To View Message" style="text-align:center" width="5%">VIEW</th> <!--View-->
                                        </tr>
                                      </thead>

                                      <tbody id="tbnewsbody"></tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
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

    <script src="<?php echo base_url(); ?>/newassets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/jquery.countdown/jquery.countdown.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/tilt.js/dest/tilt.jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progress.js"></script> -->
    <script src="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/js/app.js"></script>
    <script src="<?php echo base_url();?>assets/js/datatables.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="<?php echo base_url();?>assets/js/klorofil-common.js"></script>

    <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>

    <script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

    <script src="<?php echo base_url();?>assets/js/general.js"></script>

    <script src="<?php echo base_url();?>assets/js/sum().js"></script>


<script>
    var Title='Derived Homes Help';
    var m='';
    var table,tabletrade,tablenews;
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
            $('#divAlert').html(msg).addClass(theme);
            
            
            swal({
                  type: msgtype,
                  title: msgtitle,
                  allowEscapeKey: false,
                  allowOutsideClick: false,
                  font: msg,
                  showCloseButton: true,
                })
                
            //Swal.showLoading(); Swal.hideLoading() 
            
            //Swal.close()
            setTimeout(function() {
                $('#divAlert').load(location.href + " #divAlert").removeClass(theme);
            }, 10000);
        }catch(e)
        {
            alert('ERROR Displaying Message: '+e);
        }
    }
    
    function DisplayDirectBuyMessage(msg,msgtype,msgtitle,theme='AlertTheme')
    {
        try
        {//SuccessTheme, AlertTheme
            $('#divDirectBuyAlert').html(msg).addClass(theme);
            
            
            swal({
                  type: msgtype,
                  title: msgtitle,
                  allowEscapeKey: false,
                  allowOutsideClick: false,
                  text: msg,
                  showCloseButton: true,
                })
                
            
            setTimeout(function() {
                $('#divDirectBuyAlert').load(location.href + " #divDirectBuyAlert").removeClass(theme);
            }, 10000);
        }catch(e)
        {
            alert('ERROR Displaying Message: '+e);
        }
    }
    
    $(document).ready(function(e) {
        
        $('[data-toggle="tooltip"]').tooltip();
        
        setInterval(function(){
            LoadPrimaryMarket();
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

        $('#txtTradeStartDate').datepicker({
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
        
        $('#txtTradeEndDate').datepicker({
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
        
        function VerifyStartAndEndDates()
        {
            try
            {
                $('#divAlert').html('');
                
                var startdt=ChangeDateFrom_dMY_To_Ymd($('#txtTradeStartDate').val());
                var enddt=ChangeDateFrom_dMY_To_Ymd($('#txtTradeEndDate').val());
                var sdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
                var edt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
                var d;
                
                if ($('#txtTradeStartDate').val()=='0000-00-00') $('#txtTradeStartDate').val('');
                if ($('#txtTradeEndDate').val()=='0000-00-00') $('#txtTradeEndDate').val('');
                
                if ($('#txtTradeStartDate').val())
                {
                    if (!sdt.isValid())
                    {
                        m="Trade Start Date Is Not Valid. Please Select A Valid Trade Start Date.";
                        
                       displayMessage(m, 'error',Title,'error');
                    }   
                }
                
                
                if ($('#txtTradeEndDate').val())
                {
                    if (!edt.isValid())
                    {
                        m="Trade End Date Is Not Valid. Please Select A Valid Trade End Date.";
                       displayMessage(m, 'error',Title,'error');
                    }   
                }
                
                                    
                //moment('2010-10-20').isSameOrBefore('2010-10-21');  // true               
                var dys=edt.diff(sdt, 'days') //If this -ve invalid date entries. Delivery earlier than pickup
                var diff = moment.duration(edt.diff(sdt));
                var mins = parseInt(diff.asMinutes());
                
                
                if (dys<0)
                {
                    $('#txtTradeEndDate').val('');
                                        
                    m="Trade End Date Is Before Trade Start Date. Please Correct Your Entries!";
                   displayMessage(m, 'error',Title,'error');
                }
            }catch(e)
            {
                
                m="VerifyStartAndEndDates ERROR:\n"+e;              
               displayMessage(m, 'error',Title,'error');
                return false;
            }
        }           
        
        setInterval(function() {
            updateClock();
        }, 1000);
        
        LoadPrimaryMarket();
        LoadMessages();
        LoadSymbols();
        LoadTrades('<?php echo date("d M Y"); ?>','<?php echo date("d M Y"); ?>');
                    
        $('#btnDisplayTrades').click(function(e) {
            try
            {
                var p=$.trim($('#txtTradeStartDate').val());
                var d=$.trim($('#txtTradeEndDate').val());
                                    
                //Start date
                if (!p)
                {
                    m='You have not selected the trade start date.';                    
                    displayMessage(m,'error',Title,'error');
                    return false;
                }                   

                //End Date
                if (!d)
                {
                    m='You have not selected the trade end date.';
                    displayMessage(m,'error',Title,'error');
                    return false;
                }   
                
                if (!p && d)
                {
                    m='You have selected the trade end date. Trade start date field must also be selected.';                        
                    displayMessage(m,'error',Title,'error');
                    return false;
                }                   

                if (p && !d)
                {
                    m='You have selected the trade start date. Trade end date field must also be selected.';                        

                    displayMessage(m,'error',Title,'error');
                    return false;
                }                   

                var startdt = ChangeDateFrom_dMY_To_Ymd($('#txtTradeStartDate').val());
                var enddt = ChangeDateFrom_dMY_To_Ymd($('#txtTradeEndDate').val());
                var sdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
                var edt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
            
                if (p && d)
                {
                    var dys=edt.diff(sdt, 'days') //If this -ve invalid date entries.
                            
                    if (dys<0)
                    {
                        m="Trade End Date Is Before The Trade Start Date. Please Correct Your Entries!";
                       displayMessage(m, 'error',Title,'error');
                        return false;
                    }
                }                   
                
                LoadTrades(startdt,enddt);
            }catch(e)
            {
                
                m='Display Trades Button Click ERROR:\n'+e;
                displayMessage(m,'error',Title,'error');
            }
        });
        
        function LoadTrades(sdt,edt)
        {
            try
            {
                //timedAlert('Loading Trades. Please Wait...',2000,'','info');
                
                $.ajax({
                    url: "<?php echo site_url('ui/Directinvestorprymarket/GetTrades');?>",
                    type: 'POST',
                    data: {usertype:Usertype, email:Email,startdate:sdt,enddate:edt},
                    dataType: 'json',
                    success: function(dataSet,status,xhr) { 
                        
                        
                        if (tabletrade) tabletrade.destroy();
                        
                        //f-filtering, l-length, i-information, p-pagination
                        tabletrade = $('#tabTrades').DataTable( {
                            dom: '<"top"if>rt<"bottom"lp><"clear">',
                            responsive: true,
                            ordering: false,
                            autoWidth:false,
                            language: {zeroRecords: "No Trade Record Found"},
                            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],                                    
                            columnDefs: [
                                {
                                    "targets": [ 0,1,2,3,4,5,6,7 ],
                                    "visible": true
                                },
                                {
                                    "targets": [ 0,1,2,3,4,5,6,7 ],
                                    "searchable": true
                                },
                                { className: "dt-center", "targets": [ 0,1,2,3,6,7 ] },
                                { className: "dt-right", "targets": [ 4,5 ] }
                            ],                  
                            order: [[ 2, 'asc' ]],
                            data: dataSet, 
                            columns: [
                                { width: "15%" },//Trade Date
                                { width: "13%" },//Trade Id
                                { width: "11%" },//Asset
                                { width: "11%" },//Tokens
                                { width: "10%" },//Price
                                { width: "14%" },//Amount
                                { width: "13%" },//Seller
                                { width: "13%" }//Buyer
                            ],
                        } );
                        
                        var total=0; 
                    
                        total=tabletrade.column(5).data().sum();
                                                    
                        if (parseFloat(total) > 0)
                        {
                            $('#tdAmount').html(number_format (total, 2, '.', ','));
                        }else
                        {
                            $('#tdAmount').html('');
                        }       
                    },
                    error:  function(xhr,status,error) {
                        
                        m='Error '+ xhr.status + ' Occurred: ' + error;
                        displayMessage(m,'error',Title,'error');
                    }
                });
            }catch(e)
            {
                
                m='LoadTrades ERROR:\n'+e;
                displayMessage(m,'error',Title,'error');
            }
        }
        
        function LoadSymbols()
        {
            try
            {
                $('#cboOrderSymbol').empty();
                                    
                //timedAlert('Loading Assets. Please Wait....',2000,'','info'); 

                
                $.ajax({
                    url: "<?php echo site_url('ui/Directinvestorprymarket/GetSymbols');?>",
                    type: 'POST',
                    dataType: 'json',
                    success: function(data,status,xhr) {    
                        

                        if ($(data).length > 0)
                        {
                            $("#cboOrderSymbol").append(new Option('[SELECT]', ''));
                            
                            $.each($(data), function(i,e)
                            {
                                if (e.symbol)
                                {
                                    $("#cboOrderSymbol").append(new Option($.trim(e.symbol).toUpperCase(), $.trim(e.symbol).toUpperCase()));
                                }
                            });//End each
                        }   
                    },
                    error:  function(xhr,status,error) {
                        
                        m='Error '+ xhr.status + ' Occurred: ' + error;
                       displayMessage(m, 'error',Title,'error');
                    }
                });     
            }catch(e)
            {
                
                m="LoadSymbols ERROR:\n"+e;
                displayMessage(m,'error',Title,'error');
            }
        }
        
        function LoadMessages()
        {
            try
            {
               //timedAlert("Loading Messages/News. ",2000,'','info');
                
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
                    
        function LoadPrimaryMarket()
        {
            try
            {
                //timedAlert('Loading Market Data. Please Wait...',2000,'','');
                
                //$('#tabMarket > tbody').html('');

                $.ajax({
                    url: "<?php echo site_url('ui/Directinvestorprymarket/GetMarketData');?>",
                    type: 'POST',
                    data: {usertype:Usertype},
                    dataType: 'json',
                    success: function(dataSet,status,xhr) { 
                        
                        
                        if (table) table.destroy();
                        
                        //f-filtering, l-length, i-information, p-pagination
                        table = $('#tabMarket').DataTable( {
                            dom: '<"top"if>rt<"bottom"lp><"clear">',
                            responsive: true,
                            ordering: false,
                            autoWidth:false,
                            language: {zeroRecords: "No Primary Market Data Record Found"},
                            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],                                    
                            columnDefs: [
                                {
                                    "targets": [ 0,1,2,3,4,5,6 ],
                                    "visible": true
                                },
                                {
                                    "targets": [ 0,6 ],
                                    "orderable": false,
                                    "searchable": false
                                },
                                {
                                    "targets": [ 1,2,3,4,5 ],
                                    "searchable": true
                                },
                                { className: "dt-center", "targets": [ 0,1,2,3,4,5,6 ] }
                            ],                  
                            order: [[ 2, 'asc' ]],
                            data: dataSet, 
                            columns: [
                                { width: "19%" },//Artwork
                                { width: "16%" },//Artist
                                { width: "13%" },//Symbol
                                { width: "13%" },//Art Value
                                { width: "16%" },//Available Tokens
                                { width: "11%" },//Price
                                { width: "12%" }//Buy
                            ],
                        } );
                    },
                    error:  function(xhr,status,error) {
                        
                        m='Error '+ xhr.status + ' Occurred: ' + error;
                        displayMessage(m,'error',Title,'error');
                    }
                });
            }catch(e)
            {
                
                m='LoadPrimaryMarket ERROR:\n'+e;
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
                    m='Number of tokens to buy MUST be a number. Current entry <b>'+qty+'</b> is not valid.';                       
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
                    m="The number of tokens to buy (<b>"+number_format(qty,0,'',',')+"</b>) is more than the available tokens for sale (<b>" + number_format(available_qty,0,'',',') + "</b>).";
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
                    m="You do not have enough balance in your e-wallet to buy this asset. Your current e-wallet balance is (<b>₦"+number_format(bal,2,'.',',')+"</b>) and the total amount needed for buying "+number_format(qty,0,'',',')+" tokens of the asset is (<b>₦" + number_format(total,2,'.',',') + "</b>).";
                    DisplayDirectBuyMessage(m, 'error',Title);
                    return false;
                }
                                    
                                    
                //Confirm Update                
                swal({
                  title: 'PLEASE CONFIRM BUY',
                  text: 'Do You Want To Proceed With The Buying Of The Asset?',
                  type: 'question',
                  customClass: 'swal-wide',
                  showCancelButton: true,
                  showClass: {popup: 'animate__animated animate__fadeInDown'},
                  hideClass: {popup: 'animate__animated animate__fadeOutUp'},
                  cancelButtonText: 'No',
                  confirmButtonText: 'Yes'
                }).then((result) => {
                  if (result.value)
                  {
                   timedAlert('Buying Asset. Please Wait...</p>',2000,'','info');

                var mdata={buy_investor_email:inv, buy_investor_name:inv_name, symbol:sym, price:price, qty:qty, available_qty:available_qty, nse_commission:nsefee, sms_fee:sms, transfer_fee:transfer_fee, tradeamount:tradeamt, total_amount:total, issuer_email:issuer_email};      
                                
                    //Make Ajax Request         
                    $.ajax({
                        url: '<?php echo site_url('ui/Directinvestorprymarket/BuyPrimaryTokens'); ?>',
                        data: mdata,
                        type: 'POST',
                        dataType: 'json',
                        success: function(data,status,xhr) {                
                            
                            
                            if ($(data).length > 0)
                            {
                                $.each($(data), function(i,e)
                                {
                                    if ($.trim(e.status).toUpperCase() == 'OK')
                                    {               
                                        $('#lblDirectBuySymbol').html('');
                                        $('#lblDirectBuyAvailableQty').html('');
                                        $('#lblDirectBuyPrice').html('');
                                        $('#txtDirectBuyQty').val('');
                                        $('#lblDirectNSEFee').html('');
                                        $('#lblDirectTotalAmount').html('');
                                        $('#lblDirectTokenAmount').html('');                    
            
                                        m= 'Purchase of '+number_format(qty, '0', '', ',') + ' tokens of '+ $.trim(sym).toUpperCase() +' was successful.';
                                        
                                        displayMessage(m, 'success','Token Purchase','success');
                                        $('#lblDirectBuyInvestor').val('');
                                        
                                        GetBalance();
                                        
                                        $("#divDirectBuyModal").modal('hide');//Close modal
                                        
                                        LoadPrimaryMarket();
                                        LoadMessages();
                                        LoadSymbols();
                                        LoadTrades('<?php echo date("d M Y"); ?>','<?php echo date("d M Y"); ?>');
                                    }else
                                    {
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
        
        $("#divDirectBuyModal").on('hidden.bs.modal', function()
        {
            try
            {
                $('#lblDirectBuySymbol').html('');
                $('#lblDirectBuyAvailableQty').html('');
                $('#lblDirectBuyPrice').html('');
                $('#txtDirectBuyQty').val('');
                $('#lblDirectNSEFee').html('');
                $('#lblDirectTotalAmount').html('');
                $('#lblDirectTokenAmount').html('');
            }catch(e)
            {
                
                m='Direct Buy Modal Hidden ERROR:\n'+e;         
                DisplayDirectBuyMessage(m, 'error',Title);
            }
        });
    });//End document ready
    
    function ShowPix(sym,title,p1,url)
    {
        try
        {
            $('#ancBlockchainUrl').html('').prop('href','').prop('title','');
            $('#ancBlockchainUrl').removeAttr('href');
        
            if (p1)
            {
                var pixpath = '<?php echo base_url(); ?>art-works/'+p1;
                
                var c=$.trim(title);
                
                if (c) c = c+': Picture 1'; else c = 'Artwork Picture';
                
                $("#modPixTitle").html(TitleCase(c));

                $('#img01').css('width','100%').attr({'src':pixpath});
                
                if (url)
                {
                    $('#ancBlockchainUrl').html('Click To View Asset Blockchain Record');
                    $('#ancBlockchainUrl').prop('href',url).prop('title',"Click To View Asset Blockchain Details");
                }
                
                $('#myPixModal').modal({
                    fadeDuration:   1000,
                    fadeDelay:      0.50,
                    keyboard:       false,
                    backdrop:       'static'
                }); 
            }
        }catch(e)
        {
            
            m='ShowPix ERROR:\n'+e;             
           displayMessage(m, 'error',Title,'error');
            return false;
        }
    }
    
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
            
            $('#divDirectBuyModal').modal({
                fadeDuration:   1000,
                fadeDelay:      0.50,
                keyboard:       false,
                backdrop:       'static'
            });
        }catch(e)
        {
            
            m='ShowMarketData ERROR:\n'+e;
            displayMessage(m,'error',Title,'error');
        }
    }
</script>
</body>
</html>