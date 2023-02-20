<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php

$action = $_POST['action'];
$logged_in = true;
$artwork = $LastestPixs;
// echo "<pre>";
// print_r($artwork);
// die();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://www.naijaartmart.com/assets/images/favicon_artsquare_16x16.png" sizes="16x16">
    <title> Naija Art Mart | <?php echo $artwork['title']; ?> - Buy</title>
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
            font-size: 18px;
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
                                    <img class="artwork-img img-fluid" src="<?php echo base_url().'art-works/'.$artwork['pix'] ?>" alt="img">
                                <div class="js-tilt-glare" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; overflow: hidden; pointer-events: none;"><div class="js-tilt-glare-inner" style="position: absolute; top: 50%; left: 50%; background-image: linear-gradient(0deg, rgba(255, 255, 255, 0) 0%, rgb(255, 255, 255) 100%); width: 869.334px; height: 869.334px; transform: rotate(180deg) translate(-50%, -50%); transform-origin: 0% 0%; opacity: 0;"></div></div></a>
                                <h2 class="heading-h2 head" style="text-align: center !important;">
                                    <?php echo $artwork['title'] ?>
                                </h2>
                                <span class="line"></span>
                                <div class="row" >
                                    <div class="create-otr">
                                        <div class="create-inr">
                                            <div class="create-content">
                                                <p class="body-s create-p">Created by</p>
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
                                </div>
                                <br>
                                <span class="line"></span>
                                <h4 class="heading-h4 head" style="text-align:center !important;">Art work Description
                                </h4>
                                <p class="body-m desc para1" style="display: block !important;">
                                    <?php echo html_entity_decode($artwork['description']); ?>
                                    <br>
                                    <?php echo html_entity_decode($artwork['materials']); ?>
                                    <br>
                                    <?php echo html_entity_decode($artwork['dimensions']); ?>
                                    <br>
                                    

                                </p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-content-otr" style="margin: -12px !important;">
                            <div class="col-content-inr">
                                <div style="background: white; border-radius: 20px; font-family: sans-serif; padding: 12px">
                                   
                                    <form>
                            <!--Balance-->
                            <div class="position-relative row form-group mb-4">
                                 <!--Balance-->
                                <label title="Wallet Balance" for="lblDirectBuyBalance" class="col-sm-2 col-form-label  nsegreen text-right labelmiddle">Wallet Balance</label>
                                
                                <div title="Wallet Balance" class="col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>                        
                                         <label id="lblDirectBuyBalance" class="col-form-label labelmiddle"></label>
                                    </div>                    
                                </div>
                               
                               <!--Investor-->
                                <label title="Investor" for="lblDirectBuyInvestor" class="col-sm-2 col-form-label nsegreen text-right">Investor<span class="redtext">*</span></label>
                                
                                <div title="Investor" class="col-sm-5">
                                    <label id="lblDirectBuyInvestor" class="col-form-label labelmiddle"><?php echo $fullname; ?></label>
                                </div>
                            </div>
                                        
                            <!--Asset/No Of Tokens-->
                            <div class="position-relative row form-group">
                                <label title="Asset" for="lblDirectBuySymbol" class="col-sm-2 col-form-label nsegreen text-right labelmiddle">Asset</label>
                                
                                <div title="Asset" class="col-sm-3">
                                    <label id="lblDirectBuySymbol" class="col-form-label redalerttext labelmiddle"></label>
                                </div>
                                
                                
                                <!--No Of Tokens-->
                                <label title="Number of tokens to sell" for="txtDirectBuyQty" class="col-sm-2 col-form-label text-right nsegreen text-right">No Of Tokens<span class="redtext">*</span></label>
                                
                                <div title="Number of tokens to sell" class="col-sm-5">
                                    <input type="text" class="form-control" placeholder="No Of Tokens To Buy" id="txtDirectBuyQty">
                                </div>               
                            </div>
                            
                            
                            <div class="card mb-4">
                                <div class="card-heading">
                                     <h4 class="heading-h4 heading titleGreathorned" style="text-align:center !important;">
                                      <?php echo $artwork['symbol'] ?>'s Order Book
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="position-relative row form-group">
                                <div title="Asset Sellers" class="col-sm-12">
                                    <table class="hover table table-responsive data-table display wrap" id="tabSellers">
                                      <thead style="">
                                        <tr>
                                            <th style="text-align:center" width="15%">ASSET</th>
                                            <th style="text-align:center" width="16%">AVAILABLE&nbsp;QTY</th>
                                            <th style="text-align:center" width="14%">PRICE</th> 
                                            <th style="text-align:center" width="10%">Action</th>                           
                                        </tr>
                                      </thead>
                                      <tbody id="tbsellersbody" style="padding:4px !important"></tbody>
                                      <tfoot style="">
                                        <tr>
                                            <th style="text-align:center" width="15%">ASSET</th>
                                            <th style="text-align:center" width="16%">AVAILABLE&nbsp;QTY</th>
                                            <th style="text-align:center" width="14%">PRICE</th> 
                                            <th style="text-align:center" width="10%">Action</th>                           
                                        </tr>
                                      </tfoot>
                        
                                      
                                    </table>        
                                </div>             
                            </div>
                                        
                           <div id="divDirectBuyAlert"></div>
                            </form>
                                </div>
                                
                            </div>
                            <!--Sellers Table-->
                            
                                    
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
        <div class="artwork-body">
            <div class="container-fluid">
                <div class="artwork-body-inr">
                    <div class="row row-custom">
                        <div class="col-lg-5 col-left-otr">
                            <div class="col-left-inr">
                                <div class="user-main-otr">
                                   <!--  <div class="create-otr">
                                        <div class="create-inr">
                                            
                                            <div class="create-content">
                                                <p class="body-s create-p">Created by</p>
                                                <a href="#" class="body-sb create-pb"><?php echo $artwork['artist'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="create-otr">
                                        <div class="create-inr">
                                            
                                            <div class="create-content">
                                                <p class="body-s create-p">Created</p>
                                                <a href="#" class="body-sb create-pb"><?php echo $artwork['creationyear'] ?></a>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                
                                
                                <!-- <p class="body-m desc para2">
                                    Egestas purus sit nullam quis. Ornare magna rutrum tellus tellus porta massa. 
                                    Lectus viverra amet velit consequat sit.
                                </p> -->
                            </div>
                        </div>
                        <div class="col-lg-7 col-right-otr">
                            
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
    let artwork = <?php echo json_encode($artwork) ?> ;
    let symbol = artwork.symbol;
    let invEmail = '<?php echo trim($email);?>';

    var Title='Naija Art Mart Help';
    var m='';
    var table,tabletrade,tablenews,tableorder,tableseller;
    var Email='<?php echo trim($email); ?>';
    var Usertype='<?php echo trim($usertype); ?>';
    var InvestorName='<?php echo trim($fullname); ?>';
    var MarketStatus='<?php echo trim($MarketStatus); ?>';
    var CurrentSymbolPrice='';
    var RefreshInterval='<?php echo $RefreshInterval; ?>';
    RefreshInterval=parseInt(RefreshInterval,10) * 60 * 1000;

    function DisplayMessage(msg,msgtype,msgtitle,theme='AlertTheme')
    {
        try
        {//SuccessTheme, AlertTheme
            $('#divAlert').html(msg).addClass(theme);
            
            
            swal({
                  type: msgtype,
                  title: msgtitle,
                  background: '#F3D3F2',
                  color: '#f00',
                  allowEscapeKey: false,
                  allowOutsideClick: false,
                  text: msg,
                  showCloseButton: true,
                })
                                
            // setTimeout(function() {
            //  $('#divAlert').load(location.href + " #divAlert").removeClass(theme);
            // }, 10000);
        }catch(e)
        {
            alert('ERROR Displaying Message: '+e);
        }
    }
    
    function DisplaySellMessage(msg,msgtype,msgtitle,theme='AlertTheme')
    {
        try
        {//SuccessTheme, AlertTheme
            $('#divSellAlert').html(msg).addClass(theme);
            
            
            swal({
                  type: msgtype,
                  title: msgtitle,
                  text: msg,
                })
                
            
            //Swal.close()
            // setTimeout(function() {
            //  $('#divSellAlert').load(location.href + " #divSellAlert").removeClass(theme);
            // }, 10000);
        }catch(e)
        {
            alert('ERROR Displaying Message: '+e);
        }
    }
    
    function DisplayDirectSellMessage(msg,msgtype,msgtitle,theme='AlertTheme')
    {
        try
        {//SuccessTheme, AlertTheme
            $('#divDirectSellAlert').html(msg).addClass(theme);
            
            
            swal({
                  type: msgtype,
                  title: msgtitle,
                  background: '#F3D3F2',
                  color: '#f00',
                  allowEscapeKey: false,
                  text: msg,
                  showCloseButton: true,
                })
                
            //Swal.showLoading(); Swal.hideLoading() 
            
            //Swal.close()
            // setTimeout(function() {
            //  $('#divDirectSellAlert').load(location.href + " #divDirectSellAlert").removeClass(theme);
            // }, 10000);
        }catch(e)
        {
            alert('ERROR Displaying Message: '+e);
        }
    }
    
    function DisplayDirectBuyMessage(msg,msgtype,msgtitle,theme='AlertTheme')
    {
        try
        {//SuccessTheme, AlertTheme
            // $('#divDirectBuyAlert').html(msg).addClass(theme);
            
            
            swal({
                  type: msgtype,
                  title: msgtitle,
                  text: msg,
                  showCloseButton: true,
                })
                
            //Swal.showLoading(); Swal.hideLoading() 
            
            //Swal.close()
            // setTimeout(function() {
            //  $('#divDirectBuyAlert').load(location.href + " #divDirectBuyAlert").removeClass(theme);
            // }, 10000);
        }catch(e)
        {
            alert('ERROR Displaying Message: '+e);
        }
    }
    
    function DisplayDirectSellEditMessage(msg,msgtype,msgtitle,theme='AlertTheme')
    {
        try
        {//SuccessTheme, AlertTheme
            // $('#divDirectSellEditAlert').html(msg).addClass(theme);
            
            
            swal({
                  type: msgtype,
                  title: msgtitle,
                  text: msg,
                })
                
            //Swal.showLoading(); Swal.hideLoading() 
            
            //Swal.close()
            // setTimeout(function() {
            //  $('#divDirectSellEditAlert').load(location.href + " #divDirectSellEditAlert").removeClass(theme);
            // }, 10000);
        }catch(e)
        {
            alert('ERROR Displaying Message: '+e);
        }
    }
    
    
    $(document).ready(function(e) {
        // $(function() {           
        //  timeAlert.defaults.css = {};// clear out plugin default styling
        // });
        
        $('[data-toggle="tooltip"]').tooltip();
        
        setInterval(function(){
            //LoadDirectMarketData();
            GetDirectPortfolioTokens(symbol,invEmail)
        }, (RefreshInterval));

        // $(document).ajaxStop($.unblockUI);
        
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
                        
                        DisplayMessage(m, 'error',Title);
                    }   
                }
                
                
                if ($('#txtTradeEndDate').val())
                {
                    if (!edt.isValid())
                    {
                        m="Trade End Date Is Not Valid. Please Select A Valid Trade End Date.";
                        DisplayMessage(m, 'error',Title);
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
                    DisplayMessage(m, 'error',Title);
                }
            }catch(e)
            {
                
                m="VerifyStartAndEndDates ERROR:\n"+e;              
                DisplayMessage(m, 'error',Title);
                return false;
            }
        }
        
        
        setInterval(function() {
            updateClock();
        }, 1000);
        
        // LoadDirectMarketData();
        GetDirectPortfolioTokens(symbol,invEmail)
        LoadOrders();
        LoadMessages();
        LoadSellers(symbol)
        // LoadSymbols();
        // LoadTrades('<?php echo date("d M Y"); ?>','<?php echo date("d M Y"); ?>');
        
        $('#btnDisplayTrades').click(function(e) {
            try
            {
                var p=$.trim($('#txtTradeStartDate').val());
                var d=$.trim($('#txtTradeEndDate').val());
                                    
                //Start date
                if (!p)
                {
                    m='You have not selected the trade start date.';                    
                    DisplayMessage(m,'error',Title);
                    return false;
                }                   

                //End Date
                if (!d)
                {
                    m='You have not selected the trade end date.';
                    DisplayMessage(m,'error',Title);
                    return false;
                }   
                
                if (!p && d)
                {
                    m='You have selected the trade end date. Trade start date field must also be selected.';                        
                    DisplayMessage(m,'error',Title);
                    return false;
                }                   

                if (p && !d)
                {
                    m='You have selected the trade start date. Trade end date field must also be selected.';                        

                    DisplayMessage(m,'error',Title);
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
                        DisplayMessage(m, 'error',Title);
                        return false;
                    }
                }                   
                
                LoadTrades(startdt,enddt);
            }catch(e)
            {
                
                m='Display Trades Button Click ERROR:\n'+e;
                DisplayMessage(m,'error',Title);
            }
        });
        
        
        
        
        $('#cboSellInvestor').change(function(e) {
            try
            {
                $('#lblSellPortfolioQty').html('');
                
                var inv=$.trim($(this).val());
                var sym=$.trim($('#lblSellSymbol').html());
                
                if (inv) GetPortfolioTokens(sym,inv);
                //$('#lblSellPortfolioQty').html(number_format(portfolioqty, '0', '', ','));
            }catch(e)
            {
                
                m='Sell Investor Change ERROR:\n'+e;            
                DisplayMessage(m, 'error',Title);
            }
        });
        
        $('#cboDirectSellOrderType').change(function(e) {
            try
            {   
                var ty=$(this).val();
                
                if ($.trim(ty).toLowerCase() == 'limit')
                {
                    $('#txtDirectSellPrice').val('');
                    $('#lblDirectSellPrice').html('Selling Price<span class="redtext">*</span>');
                    $('#txtDirectSellPrice').prop('readonly',false).css('background-color','#ffffff').css('cursor','text');
                }else
                {
                    $('#lblDirectSellPrice').html('Selling Price');
                    $('#txtDirectSellPrice').val($('#lblDirectSellMarketPrice').html());
                    $('#txtDirectSellPrice').prop('readonly',true).css('background-color','#ffffff').css('cursor','default');
                }
            }catch(e)
            {
                
                m='Direct Sell Order Type Change ERROR:\n'+e;           
                DisplayDirectSellMessage(m, 'error',Title);
            }
        });
        
        $('#cboDirectSellEditOrderType').change(function(e) {
            try
            {   
                var ty=$(this).val();
                
                if ($.trim(ty).toLowerCase() == 'limit')
                {
                    $('#txtDirectSellEditPrice').val('');
                    $('#lblDirectSellEditPrice').html('Selling Price<span class="redtext">*</span>');
                    $('#txtDirectSellEditPrice').prop('readonly',false).css('background-color','#ffffff').css('cursor','text');
                }else
                {
                    $('#lblDirectSellEditPrice').html('Selling Price');
                    $('#txtDirectSellEditPrice').val($('#lblDirectSellEditMarketPrice').html());
                    $('#txtDirectSellEditPrice').prop('readonly',true).css('background-color','#ffffff').css('cursor','default');
                }
            }catch(e)
            {
                
                m='Edit Direct Sell Order Type Change ERROR:\n'+e;          
                DisplayDirectSellEditMessage(m, 'error',Title);
            }
        });
        
        $('#btnDirectSell').click(function(e) {
            try
            {
                $('#divDirectSellAlert').html('');          
                if (!CheckDirectSell()) return false;
            }catch(e)
            {
                
            }
        });
        
        $('#btnDirectSellEdit').click(function(e) {
            try
            {
                $('#divDirectSellEditAlert').html('');          
                if (!CheckDirectSellEdit()) return false;
            }catch(e)
            {
                
            }
        });         
        
        $("#txtBuyQty").on("keyup",function(event)
        {
            try
            {
                ComputeBuyAmount();
            }catch(e)
            {
                
                m='Buy Quantity Keyup ERROR:\n'+e;          
                DisplayMessage(m, 'error',Title);
            }
        });         
        
        $("#txtBuyQty").on("change",function(event)
        {
            try
            {
                ComputeBuyAmount();
            }catch(e)
            {
                
                m='Buy Quantity Changed ERROR:\n'+e;            
                DisplayMessage(m, 'error',Title);
            }
        });
                    
        $("#txtBuyPrice").on("change",function(event)
        {
            try
            {
                ComputeBuyAmount();
            }catch(e)
            {
                
                m='Buy Price Changed ERROR:\n'+e;           
                DisplayMessage(m, 'error',Title);
            }
        });
        
        $("#txtBuyPrice").on("keyup",function(event)
        {
            try
            {
                ComputeBuyAmount();
            }catch(e)
            {
                
                m='Buy Price Keyup ERROR:\n'+e;         
                DisplayMessage(m, 'error',Title);
            }
        });
                    
        $("#chkBuySMS").on("click",function(event)
        {
            try
            {
                ComputeBuyAmount();
            }catch(e)
            {
                
                m='SMS Fee Clicked ERROR:\n'+e;         
                DisplayMessage(m, 'error',Title);
            }
        });
                
        function LoadBuyPrice(sym)
        {
            try
            {
                $('#lblBuyMarketPrice').html('');
                
                $.ajax({
                    url: "<?php echo site_url('ui/Directinvestorsecmarket/GetPrice');?>",
                    type: 'POST',
                    data:{symbol:sym},
                    dataType: 'text',
                    success: function(data,status,xhr) {    
                        
                        
                        var p=data;
                        
                        $('#lblBuyMarketPrice').html(number_format(p, 2, '.', ','));
                    },
                    error:  function(xhr,status,error) {
                        
                        m='Error '+ xhr.status + ' Occurred: ' + error;
                        DisplayMessage(m, 'error',Title);
                    }
                });     
            }catch(e)
            {
                
                m="LoadBuyPrice ERROR:\n"+e;
                DisplayMessage(m,'error',Title);
            }
        }
        
        //Direct Sell
        $("#txtDirectSellQty").on("keyup",function(event)
        {
            try
            {
                ComputeDirectSellAmount();
            }catch(e)
            {
                
                m='Sell Quantity Keyup ERROR:\n'+e;         
                DisplayDirectSellMessage(m, 'error',Title);
            }
        });
        
        $("#txtDirectSellQty").on("change",function(event)
        {
            try
            {
                ComputeDirectSellAmount();
            }catch(e)
            {
                
                m='Sell Quantity Changed ERROR:\n'+e;           
                DisplayDirectSellMessage(m, 'error',Title);
            }
        });
                    
        $("#txtDirectSellPrice").on("keyup",function(event)
        {
            try
            {
                ComputeDirectSellAmount();
            }catch(e)
            {
                
                m='Sell Price Keyup ERROR:\n'+e;            
                DisplayDirectSellMessage(m, 'error',Title);
            }
        }); 
        
        $("#txtDirectSellPrice").on("change",function(event)
        {
            try
            {
                ComputeDirectSellAmount();
            }catch(e)
            {
                
                m='Sell Price Changed ERROR:\n'+e;          
                DisplayDirectSellMessage(m, 'error',Title);
            }
        }); 
        
        function ComputeDirectSellAmount()
        {
            try
            {
                $('#lblDirectSellAmount').html('');
                $('#lblDirectSellNSEFee').html('');
                $('#lblDirectSellTotalAmount').html('');                    
                
                var qty=$.trim($('#txtDirectSellQty').val()).replace(new RegExp(',', 'g'), '');                 
                var price=$.trim($('#txtDirectSellPrice').val()).replace(new RegExp(',', 'g'), '');             
                price=price.replace(new RegExp('₦', 'g'), '');
                
                var sms=$.trim($('#lblDirectSellSMS').html()).replace(new RegExp(',', 'g'), '');                
                sms=sms.replace(new RegExp('₦', 'g'), '');
                                                        
                CurrentSymbolPrice=CurrentSymbolPrice.replace(new RegExp(',', 'g'), '');                
                CurrentSymbolPrice=CurrentSymbolPrice.replace(new RegExp('₦', 'g'), '');
                
                var transfer_fee='<?php echo $transfer_fee; ?>';
                var price_limit_percent = '<?php echo $price_limit_percent; ?>';
                var diff=(parseFloat(price_limit_percent)/100) * parseFloat(CurrentSymbolPrice);        
                
                var lowerlimit = parseFloat(CurrentSymbolPrice) - parseFloat(diff);
                var upperlimit = parseFloat(CurrentSymbolPrice) + parseFloat(diff);
                            
                var nse_rate = '<?php echo $nse_rate; ?>';
                
                var amount = parseFloat(qty) * parseFloat(price);
                var nsefee = (parseFloat(nse_rate)/100) * amount;
                var total = parseFloat(amount) + parseFloat((nsefee/2)) + parseFloat(sms) + parseFloat(transfer_fee);
            
                if (parseFloat(amount) > 0) $('#lblDirectSellAmount').html('₦' + number_format(amount, 2, '.', ','));
                if (parseFloat(nsefee) > 0) $('#lblDirectSellNSEFee').html('₦' + number_format((nsefee/2), 2, '.', ','));
                if (parseFloat(total) > 0) $('#lblDirectSellTotalAmount').html('₦' + number_format(total, 2, '.', ','));
            }catch(e)
            {
                
                m='ComputeDirectSellAmount ERROR:\n'+e;         
                DisplayDirectSellMessage(m, 'error',Title);
            }
        }           
        
        //Edit Direct Sell
        $("#txtDirectSellEditQty").on("keyup",function(event)
        {
            try
            {
                ComputeDirectSellEditAmount();
            }catch(e)
            {
                
                m='Edit Sell Quantity Keyup ERROR:\n'+e;            
                DisplayDirectSellEditMessage(m, 'error',Title);
            }
        });
        
        $("#txtDirectSellEditQty").on("change",function(event)
        {
            try
            {
                ComputeDirectSellEditAmount();
            }catch(e)
            {
                
                m='Edit Sell Quantity Changed ERROR:\n'+e;          
                DisplayDirectSellEditMessage(m, 'error',Title);
            }
        });
                    
        $("#txtDirectSellEditPrice").on("keyup",function(event)
        {
            try
            {
                ComputeDirectSellEditAmount();
            }catch(e)
            {
                
                m='Edit Sell Price Keyup ERROR:\n'+e;           
                DisplayDirectSellEditMessage(m, 'error',Title);
            }
        }); 
        
        $("#txtDirectSellEditPrice").on("change",function(event)
        {
            try
            {
                ComputeDirectSellEditAmount();
            }catch(e)
            {
                
                m='Edit Sell Price Changed ERROR:\n'+e;         
                DisplayDirectSellEditMessage(m, 'error',Title);
            }
        }); 
        
        function ComputeDirectSellEditAmount()
        {
            try
            {
                $('#lblDirectSellEditAmount').html('');                 
                $('#lblDirectSellEditNSEFee').html('');
                $('#lblDirectSellEditTotalAmount').html('');                    
                
                var qty=$.trim($('#txtDirectSellEditQty').val()).replace(new RegExp(',', 'g'), '');                 
                var price=$.trim($('#txtDirectSellEditPrice').val()).replace(new RegExp(',', 'g'), '');             
                price=price.replace(new RegExp('₦', 'g'), '');
                
                var sms=$.trim($('#lblDirectSellEditSMS').html()).replace(new RegExp(',', 'g'), '');                
                sms=sms.replace(new RegExp('₦', 'g'), '');
                                                        
                CurrentSymbolPrice=CurrentSymbolPrice.replace(new RegExp(',', 'g'), '');                
                CurrentSymbolPrice=CurrentSymbolPrice.replace(new RegExp('₦', 'g'), '');
                
                var transfer_fee='<?php echo $transfer_fee; ?>';
                var price_limit_percent = '<?php echo $price_limit_percent; ?>';
                var diff=(parseFloat(price_limit_percent)/100) * parseFloat(CurrentSymbolPrice);        
                
                var lowerlimit = parseFloat(CurrentSymbolPrice) - parseFloat(diff);
                var upperlimit = parseFloat(CurrentSymbolPrice) + parseFloat(diff);
                            
                var brokers_rate = '<?php echo $brokers_rate; ?>';
                var nse_rate = '<?php echo $nse_rate; ?>';
                
                var amount = parseFloat(qty) * parseFloat(price);
                var nsefee = (parseFloat(nse_rate)/100) * amount;
                var total = parseFloat(amount) + parseFloat((nsefee/2)) + parseFloat(sms) + parseFloat(transfer_fee);
            
                if (parseFloat(amount) > 0) $('#lblDirectSellEditAmount').html('₦' + number_format(amount, 2, '.', ','));
                if (parseFloat(nsefee) > 0) $('#lblDirectSellEditNSEFee').html('₦' + number_format((nsefee/2), 2, '.', ','));
                if (parseFloat(total) > 0) $('#lblDirectSellEditTotalAmount').html('₦' + number_format(total, 2, '.', ','));
            }catch(e)
            {
                
                m='ComputeDirectSellEditAmount ERROR:\n'+e;         
                DisplayDirectSellEditMessage(m, 'error',Title);
            }
        }
        
        function ResetDirectSellEdit()
        {
            try
            {
                CurrentSymbolPrice='';
                
                $('#hidOrderId').val('');
                $('#hidSold').val('');
                $('#hidOld_inv').val('');
                
                $('#lblDirectSellEditDate').html('<?php echo date('d M Y'); ?>');
                $('#lblDirectSellEditInvestor').html('');
                $('#lblDirectSellEditBalance').html('');
                $('#lblDirectSellEditSymbol').html('');
                $('#lblDirectSellEditPortfolioQty').html('');
                $('#lblDirectSellEditMarketPrice').html('');
                $('#txtDirectSellEditQty').val('');
                $('#lblDirectSellEditNSEFee').html('');
                $('#lblDirectSellEditAmount').html(''); 
                $('#lblDirectSellEditTotalAmount').html('');
                $('#cboDirectSellEditOrderType').val('');
                
                $('#lblDirectSellEditPrice').html('Selling Price');
                $('#txtDirectSellEditPrice').val($('#lblDirectSellEditMarketPrice').html());
                $('#txtDirectSellEditPrice').prop('readonly',true).css('background-color','#ffffff').css('cursor','default');
                
                GetBalance();               
                                    
            }catch(e)
            {
                
                m='ResetDirectSellEdit ERROR:\n'+e;             
                DisplayDirectSellEditMessage(m, 'error',Title);
            }
        }
        
        function CheckDirectSellEdit()
        {
            try
            {
                var oid=$.trim($('#hidOrderId').val());
                var sold=$.trim($('#hidSold').val());
                var old_inv=$.trim($('#hidOld_inv').val());
                var bal=$.trim($('#lblDirectSellEditBalance').html()).replace(new RegExp(',', 'g'), '');                
                bal=bal.replace(new RegExp('₦', 'g'), '');
                
                var inv=Email;
                var invname=InvestorName
                
                var sym=$.trim($('#lblDirectSellEditSymbol').html());
                
                var mktpr=$.trim($('#lblDirectSellEditMarketPrice').html()).replace(new RegExp(',', 'g'), '');              
                mktpr = mktpr.replace(new RegExp('₦', 'g'), '');
                
                var typ=$.trim($('#cboDirectSellEditOrderType').val());
                
                var pr=$.trim($('#txtDirectSellEditPrice').val()).replace(new RegExp(',', 'g'), '');                
                pr = pr.replace(new RegExp('₦', 'g'), '');
                
                var qty=$.trim($('#txtDirectSellEditQty').val()).replace(new RegExp(',', 'g'), '');
                
                var portqty=$.trim($('#lblDirectSellEditPortfolioQty').html()).replace(new RegExp(',', 'g'), '');
                
                var nse=$.trim($('#lblDirectSellEditNSEFee').html()).replace(new RegExp(',', 'g'), '');             
                nse=nse.replace(new RegExp('₦', 'g'), '');
                
                var amt=$.trim($('#lblDirectSellEditAmount').html()).replace(new RegExp(',', 'g'), '');             
                amt=amt.replace(new RegExp('₦', 'g'), '');
                
                var tot=$.trim($('#lblDirectSellEditTotalAmount').html()).replace(new RegExp(',', 'g'), '');                
                tot=tot.replace(new RegExp('₦', 'g'), '');
                
                var sms=$.trim($('#lblDirectSellEditSMS').html()).replace(new RegExp(',', 'g'), '');                
                sms=sms.replace(new RegExp('₦', 'g'), '');  
                
                var transfer_fee='<?php echo $transfer_fee; ?>';
                        
                                                        
                //UNCOMMENT THIS LATER
                /*if ($.trim(MarketStatus).toLowerCase() == 'closed')
                {
                    m='Market is closed. You cannot edit any order.';                       

                    DisplayDirectSellEditMessage(m, 'error',Title);             

                    return false;
                }*/
                
                //Investor Email
                if (!Email)
                {
                    m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the editing of the sell order.';                        

                    DisplayDirectSellEditMessage(m, 'error',Title);             

                    return false;
                }
                
                if (!oid)
                {
                    m='Sell order Id was not captured. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the editing of the sell order.';                       

                    DisplayDirectSellEditMessage(m, 'error',Title);             

                    return false;
                }               
                                
                //Symbol
                if (!sym)
                {
                    m='No asset is displaying. Refresh the page or logout and login again before continue.';
                    DisplayDirectSellEditMessage(m, 'error',Title);                 
                    return false;
                }                   
                
                //Market Price
                if (!mktpr)
                {
                    m='Asset current market price field MUST not be blank.';                
                    DisplayDirectSellEditMessage(m, 'error',Title);                 
                    return false;
                }
                
                if (!$.isNumeric(mktpr))
                {
                    m='Asset current market price MUST be a number.';                       
                    DisplayDirectSellEditMessage(m, 'error',Title);
                    return false;
                }

                if (parseFloat(mktpr) == 0)
                {
                    m='Asset current market price must not be zero.';               
                    DisplayDirectSellEditMessage(m, 'error',Title);
                    return false;
                }
                
                if (parseFloat(mktpr) < 0)
                {
                    m='Asset current market price must not be a negative number.';              
                    DisplayDirectSellEditMessage(m, 'error',Title);
                    return false;
                }                   
                
                //Sell Order Type
                if ($('#cboDirectSellEditOrderType > option').length < 2)
                {
                    m='Sell order types have not been captured. Please contact the system administrator at support@naijaartmart.com';
                    DisplayDirectSellEditMessage(m, 'error',Title);                 
                    return false;
                }
                
                if (!typ)
                {
                    m='Please select the type of the sell order you want to edit.';
                    DisplayDirectSellEditMessage(m, 'error',Title);                 
                    $('#cboDirectSellOrderType').focus(); return false;
                }                   
                
                //Selling Price
                if (!pr)
                {
                    m='Asset selling price field MUST not be blank.';               
                    DisplayDirectSellEditMessage(m, 'error',Title);                 
                    return false;
                }
                
                if (!$.isNumeric(pr))
                {
                    m='Asset selling price MUST be a number.';                      
                    DisplayDirectSellEditMessage(m, 'error',Title);
                    return false;
                }

                if (parseFloat(pr) == 0)
                {
                    m='Asset selling price must not be zero.';              
                    DisplayDirectSellEditMessage(m, 'error',Title);
                    return false;
                }
                
                if (parseFloat(pr) < 0)
                {
                    m='Asset selling price must not be a negative number.';             
                    DisplayDirectSellEditMessage(m, 'error',Title);
                    return false;
                }           
                
                var price_limit_percent = '<?php echo $price_limit_percent; ?>';
                var diff=(parseFloat(price_limit_percent)/100) * parseFloat(mktpr);     
                
                var lowerlimit = parseFloat(mktpr) - parseFloat(diff);
                var upperlimit = parseFloat(mktpr) + parseFloat(diff);                                  
                                    
                //Lower/Upper Price Limits                  
                if (parseFloat(pr) < parseFloat(lowerlimit))//Exceeded lower limit
                {
                    m="The selling price, ₦" + number_format(pr,2,'.',',') + ", is less than the minimum price of ₦" + number_format(lowerlimit,2,'.',',') + " allowed for the asset. Please enter a value not less than ₦" + number_format(lowerlimit,2,'.',',') +", or more than ₦" + number_format(upperlimit,2,'.',',') + ".";
                    
                    DisplayDirectSellEditMessage(m, 'error',Title);
                    return false;
                }
                
                if (parseFloat(pr) > parseFloat(upperlimit))//Exceeded upper limit
                {
                    m="The selling price, ₦" + number_format(pr,2,'.',',') + ", is more than the maximum price of ₦" + number_format(upperlimit,2,'.',',') + " allowed for the asset. Please enter a value not less than ₦" + number_format(lowerlimit,2,'.',',') +", or more than ₦" + number_format(upperlimit,2,'.',',') + ".";
                    
                    DisplayDirectSellEditMessage(m, 'error',Title);
                    return false;
                }
                
                
                //Portfolio Quantity
                if (!$.isNumeric(portqty))
                {
                    m='There is no valid number of tokens of the selected asset in your portfolio. Selling order editing cannot continue.';                     
                    DisplayDirectSellEditMessage(m, 'error',Title);
                    return false;
                }
                
                if (parseInt(portqty) == 0)
                {
                    m="You do not have any token of "+ sym.toUpperCase() + " in your portfolio to sell.";
                    DisplayDirectSellEditMessage(m, 'error',Title);
                    return false;
                }                   

                if (parseInt(portqty) == 0)
                {
                    m='Number of tokens of '+ sym.toUpperCase() + ' in your portfolio must not be zero.';                
                    DisplayDirectSellEditMessage(m, 'error',Title);
                    return false;
                }
                
                if (parseInt(portqty) < 0)
                {
                    m='Number of tokens of '+ sym.toUpperCase() + ' in your portfolio must not be less than zero.';              
                    DisplayDirectSellEditMessage(m, 'error',Title);
                    return false;
                }
                            
                                                                
                //Qty to sell
                if (!qty)
                {
                    m='Number of tokens of the asset to sell MUST not be blank.';               
                    DisplayDirectSellEditMessage(m, 'error',Title);                 
                    return false;
                }
                
                if (!$.isNumeric(qty))
                {
                    m='Number of tokens of the asset to sell MUST be a number. Current entry '+qty+' is not valid.';                     
                    DisplayDirectSellEditMessage(m, 'error',Title);
                    return false;
                }

                if (parseInt(qty) == 0)
                {
                    m='Number of tokens of the asset to sell must not be zero.';                
                    DisplayDirectSellEditMessage(m, 'error',Title);
                    return false;
                }
                
                if (parseInt(qty) < 0)
                {
                    m='Number of tokens of the asset to sell must not be less than zero.';              
                    DisplayDirectSellEditMessage(m, 'error',Title);
                    return false;
                }
                
                                    
                if (parseInt(portqty) < parseInt(qty))
                {
                    m="You do not have enough tokens of "+ sym.toUpperCase() + " in your portfolio to sell. The number of tokens of the asset in your portfolio currently is "+ number_format(portqty,0,'',',') + ".";
                    DisplayDirectSellEditMessage(m, 'error',Title);
                    return false;
                }
                
                //sold
                //(qty - sold) (if zero, stop order, if < 0 refuse update)
                var dq=parseInt(qty)-parseInt(sold);
                
                if (parseInt(dq)==0)
                {
                    m='You have already sold '+number_format(dq,0,'',',')+' tokens from this order. Entering the current qunatity of '+number_format(qty,0,'',',') + ' tokens, will bring the net trade quantity to zero. This process will stop this sell order or mark it as EXECUTED. If you want stop or cancel this order, you can click directly on the CANCEL button.';                        

                    DisplayDirectSellEditMessage(m, 'error',Title);             

                    return false;
                }
                
                if (parseInt(dq)<0)
                {
                    m='You have already sold '+number_format(dq,0,'',',')+' tokens from this order. Entering the current qunatity of '+number_format(qty,0,'',',') + ' tokens, will bring the net trade quantity to less than zero. If you want stop or cancel this order, you can click directly on the CANCEL button.';

                    DisplayDirectSellEditMessage(m, 'error',Title);             

                    return false;
                }
                
                //NSE Fee
                if (!nse)
                {
                    m='NSE fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the editing of the sell order. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';                     

                    DisplayDirectSellEditMessage(m, 'error',Title);             

                    return false;
                }
                
                //Token Amount
                if (!amt)
                {
                    m='Amount for the token to sell is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the editing of sell the order. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';                        

                    DisplayDirectSellEditMessage(m, 'error',Title);             

                    return false;
                }
                
                //Total Amount
                if (!tot)
                {
                    m='Total trade amount for the sell order is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the editing of the sell order. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';                       

                    DisplayDirectSellEditMessage(m, 'error',Title);             

                    return false;
                }

                
                //Confirm Update                
                swal({
                    title: 'PLEASE CONFIRM',
                    html: 'Do you want to proceed with the editing of the sell order for the selected asset?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                  if (result)
                  {
                var mdata={email:Email, order_id:oid, old_invid:old_inv, investor_id:inv, investor_name:invname, ordertype:typ, symbol:sym, price:pr, qty:qty, available_qty:dq, nse_commission:nse, sms_fee:sms, transfer_fee:transfer_fee,total_amount:tot}                       

                                
                    //Make Ajax Request         
                    $.ajax({
                        url: '<?php echo site_url('ui/Directinvestorsecmarket/UpdateSellOrder'); ?>',
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
                                        $('#lblDirectSellEditInvestor').html('');
                                        $('#lblDirectSellEditBalance').html('');
                                        $('#lblDirectSellEditPrice').html('Selling Price');
                                        $('#txtDirectSellEditPrice').val($('#lblDirectSellEditMarketPrice').html());
                                        $('#txtDirectSellEditPrice').prop('readonly',true).css('background-color','#ffffff').css('cursor','default');
                                        $('#txtDirectSellEditQty').val('');
                                        $('#lblDirectSellEditNSEFee').html('');
                                        $('#lblDirectSellEditAmount').html(''); 
                                        $('#lblDirectSellEditTotalAmount').html('');
                                        $('#cboDirectSellEditOrderType').val('');   
                                        
                                        
                                        $('#hidOrderId').val('');   
                                        $('#hidSold').val('');
                                        $('#hidOld_inv').val('');
                                                                                                                                
                                        LoadOrders();
                                        LoadMessages();
                                        // LoadDirectMarketData();
                                        GetBalance();
                                        GetPortfolioTokens(sym,inv);
            
                                        m= 'Updating of sell order was successfully.';
                                        
                                        DisplayDirectSellEditMessage(m, 'success','Updated Sell Order','SuccessTheme');
                                    }else
                                    {
                                        m=e.Msg;
                                        
                                        DisplayDirectSellEditMessage(m,'error',Title);      
                                    }
                                    
                                    return;
                                });//End each
                            }
                        },
                        error:  function(xhr,status,error) {
                            m='Error '+ xhr.status + ' Occurred: ' + error
                            DisplayDirectSellEditMessage(m,'error',Title);
                        }
                    });
                  }
                })  
            }catch(e)
            {
                
                m='CheckDirectSellEdit ERROR:\n'+e;             
                DisplayDirectSellEditMessage(m, 'error',Title);
            }       
        }//End CheckDirectSellEdit
        
        
        function ResetDirectSell()
        {
            try
            {
                CurrentSymbolPrice='';
                
                $('#lblDirectSellDate').html('<?php echo date('d M Y'); ?>');
                $('#lblDirectSellInvestor').html('');
                $('#lblDirectSellBalance').html('');
                $('#lblDirectSellSymbol').html('');
                $('#lblDirectSellPortfolioQty').html('');
                $('#lblDirectSellMarketPrice').html('');
                $('#txtDirectSellQty').val('');
                $('#lblDirectSellNSEFee').html('');
                $('#lblDirectSellAmount').html(''); 
                $('#lblDirectSellTotalAmount').html('');
                $('#cboDirectSellOrderType').val('');
                
                $('#lblDirectSellPrice').html('Selling Price');
                $('#txtDirectSellPrice').val($('#lblDirectSellMarketPrice').html());
                $('#txtDirectSellPrice').prop('readonly',true).css('background-color','#ffffff').css('cursor','default');
                
                GetBalance();               
                                    
            }catch(e)
            {
                
                m='ResetDirectSell ERROR:\n'+e;             
                DisplayDirectSellMessage(m, 'error',Title);
            }
        }
        
        function CheckDirectSell()
        {
            try
            {                   
                var inv=Email;
                var inv_name=$.trim($('#lblDirectSellInvestor').html());
                
                var sym=$.trim($('#lblDirectSellSymbol').html());

                
                var mktpr=$.trim($('#lblDirectSellMarketPrice').html()).replace(new RegExp(',', 'g'), '');              
                mktpr = mktpr.replace(new RegExp('₦', 'g'), '');
                
                var typ=$.trim($('#cboDirectSellOrderType').val());
                
                var pr=$.trim($('#txtDirectSellPrice').val()).replace(new RegExp(',', 'g'), '');                
                pr = pr.replace(new RegExp('₦', 'g'), '');
                
                var qty=$.trim($('#txtDirectSellQty').val()).replace(new RegExp(',', 'g'), '');
                
                var portqty=$.trim($('#lblDirectSellPortfolioQty').html()).replace(new RegExp(',', 'g'), '');

                
                var nse=$.trim($('#lblDirectSellNSEFee').html()).replace(new RegExp(',', 'g'), '');             
                nse=nse.replace(new RegExp('₦', 'g'), '');
                
                var amt=$.trim($('#lblDirectSellAmount').html()).replace(new RegExp(',', 'g'), '');             
                amt=amt.replace(new RegExp('₦', 'g'), '');
                
                var tot=$.trim($('#lblDirectSellTotalAmount').html()).replace(new RegExp(',', 'g'), '');                
                tot=tot.replace(new RegExp('₦', 'g'), '');
                
                var sms=$.trim($('#lblDirectSellSMS').html()).replace(new RegExp(',', 'g'), '');                
                sms=sms.replace(new RegExp('₦', 'g'), '');  
                
                var transfer_fee='<?php echo $transfer_fee; ?>';
                        
                                                        
                //UNCOMMENT THIS LATER
                /*if ($.trim(MarketStatus).toLowerCase() == 'closed')
                {
                    m='Market is closed. You cannot place any order.';                      

                    DisplayDirectSellMessage(m, 'error',Title);             

                    return false;
                }*/
                
                //User Email
                if (!Email)
                {
                    m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the placing of sell order.';                        

                    DisplayDirectSellMessage(m, 'error',Title);             

                    return false;
                }                   
                                
                //Symbol
                if (!sym)
                {
                    m='No asset is displaying. Refresh the page or logout and login again before continue.';
                    DisplayDirectSellMessage(m, 'error',Title);                 
                    return false;
                }
                
                
                //Market Price
                if (!mktpr)
                {
                    m='Asset current market price field MUST not be blank.';                
                    DisplayDirectSellMessage(m, 'error',Title);                 
                    return false;
                }
                
                if (!$.isNumeric(mktpr))
                {
                    m='Asset current market price MUST be a number.';                       
                    DisplayDirectSellMessage(m, 'error',Title);
                    return false;
                }

                if (parseFloat(mktpr) == 0)
                {
                    m='Asset current market price must not be zero.';               
                    DisplayDirectSellMessage(m, 'error',Title);
                    return false;
                }
                
                if (parseFloat(mktpr) < 0)
                {
                    m='Asset current market price must not be a negative number.';              
                    DisplayDirectSellMessage(m, 'error',Title);
                    return false;
                }
                
                
                //Sell Order Type
                if ($('#cboDirectSellOrderType > option').length < 2)
                {
                    m='Sell order types have not been captured. Please contact the system administrator at support@naijaartmart.com';
                    DisplayDirectSellMessage(m, 'error',Title);                 
                    return false;
                }
                
                if (!typ)
                {
                    m='Please select the type of sell order you want to place.';
                    DisplayDirectSellMessage(m, 'error',Title);                 
                    $('#cboDirectSellOrderType').focus(); return false;
                }
                
                
                //Selling Price
                if (!pr)
                {
                    m='Asset selling price field MUST not be blank.';               
                    DisplayDirectSellMessage(m, 'error',Title);                 
                    return false;
                }
                
                if (!$.isNumeric(pr))
                {
                    m='Asset selling price MUST be a number.';                      
                    DisplayDirectSellMessage(m, 'error',Title);
                    return false;
                }

                if (parseFloat(pr) == 0)
                {
                    m='Asset selling price must not be zero.';              
                    DisplayDirectSellMessage(m, 'error',Title);
                    return false;
                }
                
                if (parseFloat(pr) < 0)
                {
                    m='Asset selling price must not be a negative number.';             
                    DisplayDirectSellMessage(m, 'error',Title);
                    return false;
                }
        
                
                var price_limit_percent = '<?php echo $price_limit_percent; ?>';
                var diff=(parseFloat(price_limit_percent)/100) * parseFloat(mktpr);     
                
                var lowerlimit = parseFloat(mktpr) - parseFloat(diff);
                var upperlimit = parseFloat(mktpr) + parseFloat(diff);                                  
                                    
                //Lower/Upper Price Limits                  
                if (parseFloat(pr) < parseFloat(lowerlimit))//Exceeded lower limit
                {
                    m="The selling price, ₦" + number_format(pr,2,'.',',') + ", is less than the minimum price of ₦" + number_format(lowerlimit,2,'.',',') + " allowed for the asset. Please enter a value not less than ₦" + number_format(lowerlimit,2,'.',',') +", or more than ₦" + number_format(upperlimit,2,'.',',') + ".";
                    
                    DisplayDirectSellMessage(m, 'error',Title);
                    return false;
                }
                
                if (parseFloat(pr) > parseFloat(upperlimit))//Exceeded upper limit
                {
                    m="The selling price, ₦" + number_format(pr,2,'.',',') + ", is more than the maximum price of ₦" + number_format(upperlimit,2,'.',',') + " allowed for the asset. Please enter a value not less than ₦" + number_format(lowerlimit,2,'.',',') +", or more than ₦" + number_format(upperlimit,2,'.',',') + ".";
                    
                    DisplayDirectSellMessage(m, 'error',Title);
                    return false;
                }
                
                
                //Portfolio Quantity
                if (!$.isNumeric(portqty))
                {
                    m='There is no valid number of tokens of the selected asset in your portfolio. Selling order cannot continue.';                     
                    DisplayDirectSellMessage(m, 'error',Title);
                    return false;
                }
                
                if (parseInt(portqty) == 0)
                {
                    m="You do not have any token of "+ sym.toUpperCase() + " in your portfolio to sell.";
                    DisplayDirectSellMessage(m, 'error',Title);
                    return false;
                }                   

                if (parseInt(portqty) < 0)
                {
                    m='Number of tokens of '+ sym.toUpperCase() + ' in your portfolio must not be a negative number.';               
                    DisplayDirectSellMessage(m, 'error',Title);
                    return false;
                }
                            
                                                                
                //Qty to sell
                if (!qty)
                {
                    m='Number of tokens of the asset to sell MUST not be blank.';               
                    DisplayDirectSellMessage(m, 'error',Title);                 
                    return false;
                }
                
                if (!$.isNumeric(qty))
                {
                    m='Number of tokens of the asset to sell MUST be a number. Current entry '+qty+' is not valid.';                     
                    DisplayDirectSellMessage(m, 'error',Title);
                    return false;
                }

                if (parseInt(qty) == 0)
                {
                    m='Number of tokens of the asset to sell must not be zero.';                
                    DisplayDirectSellMessage(m, 'error',Title);
                    return false;
                }
                
                if (parseInt(qty) < 0)
                {
                    m='Number of tokens of the asset to sell must not be less than zero.';              
                    DisplayDirectSellMessage(m, 'error',Title);
                    return false;
                }
                
                                    
                if (parseInt(portqty) < parseInt(qty))
                {
                    m="You do not have enough tokens of "+ sym.toUpperCase() + " in your portfolio to sell. The number of tokens of the asset in your portfolio currently is "+ number_format(portqty,0,'',',') + ".";
                    DisplayDirectSellMessage(m, 'error',Title);
                    return false;
                }
                
                //NSE Fee
                if (!nse)
                {
                    m='NSE fee is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the placing of sell order. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';                     

                    DisplayDirectSellMessage(m, 'error',Title);             

                    return false;
                }
                
                //Token Amount
                if (!amt)
                {
                    m='Amount for the token to sell is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the placing of sell order. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';                        

                    DisplayDirectSellMessage(m, 'error',Title);             

                    return false;
                }
                
                //Estimated Total Amount
                if (!tot)
                {
                    m='Total trade amount for the sell order is not displaying. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the placing of sell order. If the issue still persists after signout and signin, please contact the system administrator at support@naijaartmart.com.';                       

                    DisplayDirectSellMessage(m, 'error',Title);             

                    return false;
                }

                
                //Confirm Update                
                swal({
                    title: 'PLEASE CONFIRM',
                    text: 'Do you want to proceed with the placing of sell order for the selected asset?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                  if (result)
                  {
                    // timeAlert({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Placing Selling Order. Please Wait...</p>',theme: false,baseZ: 2000});

                var mdata={email:Email, investor_id:inv, investor_name:inv_name, ordertype:typ, symbol:sym, price:pr, qty:qty, available_qty:qty, nse_commission:nse, sms_fee:sms, transfer_fee:transfer_fee,total_amount:tot,trade_amount:amt}                     

                                
                    //Make Ajax Request         
                    $.ajax({
                        url: '<?php echo site_url('ui/Directinvestorsecmarket/PlaceSellOrder'); ?>',
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
                                        $('#lblDirectSellBalance').html('');
                                        $('#lblDirectSellPrice').html('Selling Price');
                                        $('#txtDirectSellPrice').val($('#lblDirectSellMarketPrice').html());
                                        $('#txtDirectSellPrice').prop('readonly',true).css('background-color','#ffffff').css('cursor','default');
                                        $('#txtDirectSellQty').val('');
                                        $('#lblDirectSellNSEFee').html('');
                                        $('#lblDirectSellAmount').html(''); 
                                        $('#lblDirectSellTotalAmount').html('');
                                        $('#cboDirectSellOrderType').val('');
                                                                                    
                                        LoadOrders();
                                        LoadMessages();
                                        // LoadDirectMarketData();
                                        GetBalance();
                                        GetPortfolioTokens(sym,inv);
            
                                        m= 'Order to sell '+number_format(qty, '0', '', ',') + ' tokens of '+ $.trim(sym).toUpperCase() +' was placed successfully.';
                                        
                                        DisplayDirectSellMessage(m, 'success','Sell Order Placed','SuccessTheme');
                                    }else
                                    {
                                        m=e.Message;
                                        
                                        DisplayDirectSellMessage(m,'error',Title);      
                                    }
                                    
                                    return;
                                });//End each
                            }
                        },
                        error:  function(xhr,status,error) {
                            m='Error '+ xhr.status + ' Occurred: ' + error
                            DisplayDirectSellMessage(m,'error',Title);
                        }
                    });
                  }
                })  
            }catch(e)
            {
                
                m='CheckDirectSell ERROR:\n'+e;             
                DisplayDirectSellMessage(m, 'error',Title);
            }       
        }//End CheckDirectSell
        
        function ResetDirectBuy()
        {
            try
            {
                CurrentSymbolPrice='';
                
                $('#lblDirectBuyDate').html('<?php echo date('d M Y'); ?>');
                $('#txtDirectBuyQty').val('');
                $('#lblDirectBuySymbol').html('');                  
                
                $('#tabSellers > tbody').html('');                  
                                    
                GetBalance();               
                                    
            }catch(e)
            {
                
                m='ResetDirectBuy ERROR:\n'+e;              
                DisplayDirectBuyMessage(m, 'error',Title);
            }
        }
        
        $("#divDirectSellModal").on('hidden.bs.modal', function()
        {
            try
            {               
                $('#lblDirectSellSymbol').html('');                 
                $('#lblDirectSellMarketPrice').html('');                    
                $('#lblDirectSellNSEFee').html('');                 
                $('#lblDirectSellAmount').html('');                 
                $('#lblDirectSellPortfolioQty').html('');                   
                $('#lblDirectSellTotalAmount').html('');                    
                $('#txtDirectSellQty').val('');
                $('#txtDirectSellPrice').val('');
                $('#cboDirectSellOrderType').val('');
            }catch(e)
            {
                
                m='Direct Sell Modal Hidden ERROR:\n'+e;            
                DisplayMessage(m, 'error',Title);
            }
        });
        
        $("#divDirectBuyModal").on('hidden.bs.modal', function()
        {
            try
            {
                $('#txtDirectBuyQty').val('');
            }catch(e)
            {
                
                m='Direct Buy Modal Hidden ERROR:\n'+e;         
                DisplayMessage(m, 'error',Title);
            }
        });
        
    });//End document ready
    
    function LoadMessages()
    {
            try
            {
                
                $('#tabNews > tbody').html('');
                
                var tw=$('#news').width();
                var det_cell=tw * 0.45;
                var head_cell=tw * 0.38;
                
                $.ajax({
                    url: '<?php echo site_url('ui/Directinvestorsecmarket/LoadMessages'); ?>',
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
                        DisplayMessage(m,'error',Title);
                    }
                });
                
                
            }catch(e)
            {
                
                m='LoadMessages ERROR:\n'+e;
                DisplayMessage(m, 'error',Title);
            }
        }               
        
    function LoadDirectMarketData()
    {
        try
        {
                
            //$('#tabMarket > tbody').html('');

            $.ajax({
                url: "<?php echo site_url('ui/Directinvestorsecmarket/GetDirectMarketData');?>",
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
                        language: {zeroRecords: "No Market Data Record Found"},
                        lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],                                    
                        columnDefs: [
                            {
                                "targets": [ 0,1,2,3,4,5,6,7,8,9 ],
                                "visible": true
                            },
                            {
                                "targets": [ 0,8,9 ],
                                "orderable": false,
                                "searchable": false
                            },
                            {
                                "targets": [ 1,2,3,4,5,6,7 ],
                                "searchable": true
                            },
                            { className: "dt-center", "targets": [ 0,1,2,3,4,5,6,7,8,9 ] }
                        ],                  
                        order: [[ 2, 'asc' ]],
                        data: dataSet, 
                        columns: [
                            { width: "15%" },//Pix
                            { width: "12%" },//Symbol
                            { width: "10%" },//Open
                            { width: "10%" },//High
                            { width: "10%" },//Low
                            { width: "10%" },//Close
                            { width: "11%" },//Trades
                            { width: "12%" },//Volume
                            { width: "5%" },//Buy
                            { width: "5%" }//Sell
                        ],
                    } );
                    
                },
                error:  function(xhr,status,error) {
                    
                    m='Error '+ xhr.status + ' Occurred: ' + error;
                    DisplayMessage(m,'error',Title);
                }
            });
        }catch(e)
        {
            
            m='LoadDirectMarketData ERROR:\n'+e;
            DisplayMessage(m,'error',Title);
        }
    }
        
    function LoadOrders()
    {
        try
        {
                
            //$('#tabMarket > tbody').html('');
                
            $.ajax({
                url: "<?php echo site_url('ui/Directinvestorsecmarket/GetOrders');?>",
                type: 'POST',
                data: {email:Email},
                dataType: 'json',
                success: function(dataSet,status,xhr) { 
                    
                        
                    if (tableorder) tableorder.destroy();
                        
                    //f-filtering, l-length, i-information, p-pagination
                    tableorder = $('#tabOrders').DataTable( {
                        dom: '<"top"if>rt<"bottom"lp><"clear">',
                        responsive: true,
                        ordering: false,
                        autoWidth:false,
                        language: {zeroRecords: "No Order Record Found"},
                        lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],                                    
                        columnDefs: [
                            {
                                "targets": [ 0,1,2,3,4,5,6,7,8,9 ],
                                "visible": true
                            },
                            {
                                "targets": [ 8,9 ],
                                "orderable": false,
                                "searchable": false
                            },
                            {
                                "targets": [ 0,1,2,3,4,5,6,7 ],
                                "searchable": true
                            },
                            { className: "dt-center", "targets": [ 0,1,2,3,4,5,6,7,8,9 ] }
                        ],                  
                        order: [[ 2, 'asc' ]],
                        data: dataSet, 
                        columns: [
                            { width: "15%" },//Order Date
                            { width: "10%" },//Order Id
                            { width: "10%" },//Asset
                            { width: "9%" },//Tokens
                            { width: "10%" },//Price
                            { width: "12%" },//Order Type
                            { width: "15%" },//Investor
                            { width: "11%" },//Status
                            { width: "4%" },//Update
                            { width: "4%" }//Delete
                        ],//15,10,10,10,10,12,14,11,4,4
                    } );        
                },
                error:  function(xhr,status,error) {
                    
                    m='Error '+ xhr.status + ' Occurred: ' + error;
                    DisplayMessage(m,'error',Title);
                }
            });
        }catch(e)
        {
            
            m='LoadOrders ERROR:\n'+e;
            DisplayMessage(m,'error',Title);
        }
    }
        
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
            DisplayMessage(m, 'error',Title);
            return false;
        }
    }
    
    function GetDirectPortfolioTokens(symbol,invEmail)
    {
        try
        {
            $('#lblDirectSellPortfolioQty').html('');
            $('#lblDirectSellEditPortfolioQty').html('');
                                                                
            //Make Ajax Request         
            $.ajax({
                url: '<?php echo site_url('ui/Directinvestorsecmarket/GetTokensFromPortfolio'); ?>',
                data: {email:invEmail,symbol:symbol},
                type: 'POST',
                dataType: 'text',
                success: function(data,status,xhr) {                
                    
                    
                    var b=data;                         
                    
                    if ($.isNumeric(b))
                    {
                        $('#lblDirectSellPortfolioQty').html(number_format(b, '0', '', ','));
                        $('#lblDirectSellEditPortfolioQty').html(number_format(b, '0', '', ','));
                    }else
                    {
                        m=data;
                        DisplayDirectSellEditMessage(m,'error',Title);  
                    }
                },
                error:  function(xhr,status,error) {
                    m='Error '+ xhr.status + ' Occurred: ' + error;
                    DisplayDirectSellEditMessage(m,'error',Title);
                }
            });
        }catch(e)
        {
            
            m='GetDirectPortfolioTokens ERROR:\n'+e;                
            DisplayDirectSellEditMessage(m, 'error',Title);
            return false;
        }       
    }//End GetDirectPortfolioTokens
    
    function GetPortfolioTokens(symbol,invEmail)
    {
        try
        {
            $('#lblBuyPortfolioQty').html('');
            $('#lblSellPortfolioQty').html('');
                                                            
            //Make Ajax Request         
            $.ajax({
                url: '<?php echo site_url('ui/Directinvestorsecmarket/GetTokensFromPortfolio'); ?>',
                data: {email:invEmail,symbol:symbol},
                type: 'POST',
                dataType: 'text',
                success: function(data,status,xhr) {                
                    
                    
                    var b=data;                         
                    if ($.isNumeric(b))
                    {
                        $('#lblBuyPortfolioQty').html(number_format(b, '0', '', ','));
                        $('#lblSellPortfolioQty').html(number_format(b, '0', '', ','));
                    }else
                    {
                        m=data;
                        DisplayMessage(m,'error',Title);    
                    }
                },
                error:  function(xhr,status,error) {
                    m='Error '+ xhr.status + ' Occurred: ' + error;
                    DisplayMessage(m,'error',Title);
                }
            });
        }catch(e)
        {
            
            m='GetPortfolioTokens ERROR:\n'+e;              
            DisplayMessage(m, 'error',Title);
            return false;
        }       
    }//End GetPortfolioTokens
    
    function GetBalance()
    {
        try
        {
            var bal=$.trim($('#uiWalletBalance').html()).replace(new RegExp(',', 'g'), '');             
            bal=bal.replace(new RegExp('₦', 'g'), '');
            
            if (parseFloat(bal) > 0)
            {
                $('#lblBuyBalance').html('₦'+number_format(bal, '2', '.', ','));
                $('#lblSellBalance').html('₦'+number_format(bal, '2', '.', ','));
                $('#uiWalletBalance').html(number_format(bal, '2', '.', ','));
                $('#lblDirectSellBalance').html(number_format(bal, '2', '.', ','));
                $('#lblDirectBuyBalance').html(number_format(bal, '2', '.', ','));
                $('#lblDirectSellEditBalance').html(number_format(bal, '2', '.', ','));
            }else
            {
                $('#lblBuyBalance').html('');
                $('#lblSellBalance').html('');
                $('#uiWalletBalance').html('');
                $('#lblDirectSellBalance').html('');
                $('#lblDirectBuyBalance').html('');
                $('#lblDirectSellEditBalance').html('');
                
                                        
                //Make Ajax Request         
                $.ajax({
                    url: '<?php echo site_url('ui/Directinvestorsecmarket/GetBalance'); ?>',
                    data: {email:Email},
                    type: 'POST',
                    dataType: 'text',
                    success: function(data,status,xhr) {                
                        
                        
                        var b=data;                         
                        
                        if ($.isNumeric(b))
                        {
                            $('#lblBuyBalance').html('₦'+number_format(b, '2', '.', ','));
                            $('#lblSellBalance').html('₦'+number_format(b, '2', '.', ','));
                            $('#uiWalletBalance').html(number_format(b, '2', '.', ','));
                            $('#lblDirectSellBalance').html(number_format(b, '2', '.', ','));
                            $('#lblDirectBuyBalance').html(number_format(b, '2', '.', ','));
                            $('#lblDirectSellEditBalance').html(number_format(b, '2', '.', ','));
                        }else
                        {
                            m=data;
                            DisplayMessage(m,'error',Title);    
                        }
                    },
                    error:  function(xhr,status,error) {
                        m='Error '+ xhr.status + ' Occurred: ' + error;
                        DisplayMessage(m,'error',Title);
                    }
                }); 
            }
        }catch(e)
        {
            
            m='GetBalance ERROR:\n'+e;              
            DisplayMessage(m, 'error',Title);
            return false;
        }       
    }//End GetBalance   
    
    function CancelOrder(sn,symbol,order_id,qty,price,ordertype,transtype)
    {
        try
        {               
            //Confirm Update                
            swal({
              title: 'PLEASE CONFIRM',
              text: 'This action will permanently delete the sell order record. Do you want to proceed with the deleting of the sell order record from the database?',
              icon: 'warning', 
              buttons: true,
              dangerMode: true,
            }).then((result) => {
              if (result.value)
              {
                
                //Initiate POST
                var uri = "<?php echo site_url('ui/Directinvestorsecmarket/CancelSellOrder'); ?>";
                var xhr = new XMLHttpRequest();
                var fd = new FormData();
                
                xhr.open("POST", uri, true);
                
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200)
                    {
                        // Handle response.

                        
                        
                        var res=$.trim(xhr.responseText);
                                                    
                        if (res.toUpperCase()=='OK')
                        {
                            LoadOrders();
                            LoadMessages();
                            // LoadDirectMarketData();
                            GetBalance();
                            GetPortfolioTokens(symbol,Email);

                            m= 'Order with Id '+order_id+' for '+number_format(qty, '0', '', ',') + ' tokens of '+ $.trim(symbol).toUpperCase() +' was cancelled successfully.';
                            
                            DisplayMessage(m, 'success','Sell Order Cancelled','SuccessTheme');                                                                                                     
                        }else
                        {
                            m=res;                              
                            DisplayMessage(m, 'error',Title);
                        }
                    }
                };

                fd.append('symbol', symbol);
                fd.append('order_id', order_id);
                fd.append('qty', qty);
                fd.append('price', price);
                fd.append('ordertype', ordertype);
                fd.append('transtype', transtype);
                fd.append('email', Email);
                fd.append('investor_name', InvestorName);
                                                                            
                xhr.send(fd);// Initiate a multipart/form-data upload
              }
            })
        }catch(e)
        {
            
            m='CancelOrder ERROR:\n'+e;
            DisplayMessage(m,'error',Title);
        }
    }
    
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
    
    //Direct Sell
    function UpdateOrder(sym,order_id,qty,price,ordertype,transtype,inv,pqty,transfer_fee,nse,amt,tot,sms,symprice,avail)
    {
        try
        {
            GetBalance();
            
            $('#hidOrderId').val(order_id);
            $('#hidOld_inv').val(inv);
            //$('#lblDirectSellEditBalance').html(GetBalance());
            $('#lblDirectSellEditSymbol').html(sym);
            $('#lblDirectSellEditMarketPrice').html(number_format(symprice, '2', '.', ','));
            $('#txtDirectSellEditPrice').val(number_format(price, '2', '.', ','));                          
            $('#lblDirectSellEditInvestor').html(InvestorName);             
            $('#cboDirectSellEditOrderType').val(ordertype);
            $('#txtDirectSellEditQty').val(number_format(qty, '0', '', ','));               
            $('#lblDirectSellEditPortfolioQty').html(number_format(pqty, '0', '', ','));                
            $('#lblDirectSellEditNSEFee').html(number_format(nse, '2', '.', ','));
            $('#lblDirectSellEditAmount').html(number_format(amt, '2', '.', ','));              
            $('#lblDirectSellEditTotalAmount').html(number_format(tot, '2', '.', ','));
            $('#lblDirectSellEditSMS').html(number_format(sms, '2', '.', ','));             
            $('#lblDirectSellEditTransferFee').html(number_format(transfer_fee, '2', '.', ','));
            
            if ($.trim(ordertype).toLowerCase() == 'limit')
            {
                $('#lblDirectSellEditPrice').html('Selling Price<span class="redtext">*</span>');
                $('#txtDirectSellEditPrice').prop('readonly',false).css('background-color','#ffffff').css('cursor','text');
            }else
            {
                $('#lblDirectSellEditPrice').html('Selling Price');
                $('#txtDirectSellEditPrice').prop('readonly',true).css('background-color','#ffffff').css('cursor','default');
            }
            
            var sold = parseFloat(qty) - parseFloat(avail);
            
            $('#hidSold').val(sold);
            
            $('#divDirectSellEditModal').modal({
                fadeDuration:   1000,
                    fadeDelay:      0.50,
                keyboard:       false,
                backdrop:       'static'
            });
        }catch(e)
        {
            
            m='UpdateOrder ERROR:\n'+e;
            DisplayMessage(m,'error',Title);
        }
    }       
    
    function SellDirectArt(sn,sym,price,vol)
    {
        try
        {
            CurrentSymbolPrice= $('#tabMarket > tbody').find("tr").eq(sn).find("td").eq(5).html();
            
            GetBalance();
            
            
            $('#lblDirectSellPortfolioQty').html('');
            
            $('#lblDirectSellEditInvestor').html(InvestorName);
            $('#lblDirectSellInvestor').html(InvestorName);
            
            GetDirectPortfolioTokens(sym,Email);
            
            $('#lblDirectSellSymbol').html(sym);
            $('#lblDirectSellMarketPrice').html(number_format(CurrentSymbolPrice, '2', '.', ','));
            $('#txtDirectSellPrice').val(number_format(CurrentSymbolPrice, '2', '.', ','));
                            
            var sms='<?php echo floatval($sms_fee); ?>';
            var transfer_fee='<?php echo floatval($transfer_fee); ?>';
            
            $('#lblDirectSellSMS').html(number_format(sms, '2', '.', ','));                     
            $('#lblDirectSellTransferFee').html(number_format(transfer_fee, '2', '.', ','));        
            
            $('#divDirectSellModal').modal({
                fadeDuration:   1000,
                    fadeDelay:      0.50,
                keyboard:       false,
                backdrop:       'static'
            });
        }catch(e)
        {
            
            m='SellDirectArt ERROR:\n'+e;
            DisplayMessage(m,'error',Title);
        }
    }       
    
    //Direct Buy
    function LoadSellers(symbol)
    {
        try
        {
            $('#tabSellers > tbody').html('');
            GetBalance();
            $.ajax({
                url: "<?php echo site_url('ui/Directinvestorsecmarket/GetSellers');?>",
                type: 'POST',
                data: {symbol:symbol},
                dataType: 'json',
                success: function(dataSet,status,xhr) { 
                    
                    
                    if (tableseller) tableseller.destroy();
                    
                    //f-filtering, l-length, i-information, p-pagination
                    tableseller = $('#tabSellers').DataTable( {
                        dom: '<"top"i>rt<"bottom"lp><"clear">',
                        responsive: true,
                        ordering: false,
                        autoWidth:false,
                        language: {zeroRecords: "No Sell Orders Record Found"},
                        lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],                                  
                        columnDefs: [
                            {
                                "targets": [ 0,1,2,3 ],
                                "visible": true
                            },
                            {
                                "targets": [ 3 ],
                                "orderable": false,
                            },
                            {
                                "targets": [ 1,2,3 ],
                                "orderable": true
                            },
                            { className: "dt-center", "targets": [ 0,1,2,3 ] }
                        ],                  
                        order: [[ 2, 'asc' ]],
                        data: dataSet, 
                        columns: [
                            { width: "20%" },//Asset
                            { width: "10%" },//Available Qty
                            { width: "20%" },//Price
                            { width: "20%" }//Buy button
                        ],
                    } );        
                },
                error:  function(xhr,status,error) {
                    
                    m='Error '+ xhr.status + ' Occurred: ' + error;
                    DisplayDirectBuyMessage(m,'error',Title);
                }
            });
        }catch(e)
        {
            
            m='LoadSellers ERROR:\n'+e;
            DisplayDirectBuyMessage(m,'error',Title);
        }
    }
    
    function BuyDirectArt(sn,sym,order_id,broker_id,price,investor_id,available_qty,ordertype)
    {
        try
        {
            var qty=$.trim($('#txtDirectBuyQty').val()).replace(new RegExp(',', 'g'), '');
            var inv=Email;
            
            if (!Email)
            {
                m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the request.';                      

                DisplayDirectBuyMessage(m, 'error',Title);              

                return false;
            }
                        
            //Qty
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
                m='Number of tokens to buy must not be less than zero.';                
                DisplayDirectBuyMessage(m, 'error',Title);
                return false;
            }               
                                
            if (parseInt(available_qty) < parseInt(qty))
            {
                m="The number of tokens to buy ("+number_format(qty,0,'',',')+") is more than the available tokens for sale (" + number_format(available_qty,0,'',',') + ").";
                DisplayDirectBuyMessage(m, 'error',Title);
                return false;
            }
            
            //Wallet balance
            var bal=$.trim($('#lblDirectBuyBalance').html()).replace(new RegExp(',', 'g'), '');             
            bal=bal.replace(new RegExp('₦', 'g'), '');
            
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
            
            var sms='<?php echo $sms_fee; ?>';
            var transfer_fee='<?php echo $transfer_fee; ?>';            
            var nse_rate = '<?php echo $nse_rate; ?>';
            
            var amount = parseFloat(qty) * parseFloat(price);
            var nsefee = (parseFloat(nse_rate)/100) * amount;
            var total = parseFloat(amount) + parseFloat((nsefee/2)) + parseFloat(sms) + parseFloat(transfer_fee);
            
            if (parseFloat(bal) < parseFloat(total))
            {
                m="You do not have enough balance in your e-wallet to buy this asset. Your current e-wallet balance is (₦"+number_format(bal,2,'.',',')+") and the total amount needed for buying "+number_format(qty,0,'',',')+" tokens of the asset is (₦" + number_format(total,2,'.',',') + ").";
                DisplayDirectBuyMessage(m, 'error',Title);
                return false;
            }
            var nf=(nsefee/2);

            var det='You are about to Purchase '+ number_format(qty,0,'',',') + ' token of ' + sym + ' @ ₦' + number_format(price,2,'.',',') + ' per token. A total amount of ₦' + number_format(total,2,'.',',') + ' which consists of ₦' + number_format(nf,2,'.',',') + ' NSE Fee, ₦' + number_format(sms,2,'.',',') + ' SMS Fee and ₦' + number_format(transfer_fee,2,'.',',') + ' Transfer Fee will be subtracted from your wallet balance. Do You Want To Proceed With The Buying Of The Asset?';
                        
            //Confirm Update                
            swal({
              title: 'Please Confirm Buy',
              text: det,
              icon: 'warning', 
              buttons: true,
              dangerMode: false,
            }).then((result) => {
              if (result)
              {

            var mdata={investor_mail:Email, sell_broker_id:broker_id, sell_order_id:order_id, sell_investor_id:investor_id, buy_investor_id:inv, symbol:sym, price:price, qty:qty, available_qty:available_qty, nse_commission:nf, sms_fee:sms, transfer_fee:transfer_fee,total_amount:total,min_buy_qty:'<?php echo $min_buy_qty; ?>',brokers_rate:'<?php echo $brokers_rate; ?>',ordertype:ordertype};    
                            
                //Make Ajax Request         
                $.ajax({
                    url: '<?php echo site_url('ui/Directinvestorsecmarket/BuyTokens'); ?>',
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
                                    $('#txtDirectBuyQty').val('');
        
                                    m= 'Purchase of '+number_format(qty, '0', '', ',') + ' tokens of '+ $.trim(sym).toUpperCase() +' was successful.';
                                    
                                    DisplayMessage(m, 'success','Token Purchase','SuccessTheme');
                                    
                                    GetBalance();
                                    
                                    $("#divDirectBuyModal").modal('hide');//Close modal
                                    
                                    LoadOrders();
                                    LoadMessages();
                                    //LoadDirectMarketData();
                                    
                                    GetPortfolioTokens(sym,inv);
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
            
            m='BuyDirectArt ERROR:\n'+e;
            DisplayDirectBuyMessage(m,'error',Title);
        }
    }
    
    function ShowBuyers(sym,price)
    {
        try
        {   
            GetBalance();           
            
            $('#lblDirectBuySymbol').html(sym);
                                                        
            LoadSellers(sym);
            
            $('#divDirectBuyModal').modal({
                fadeDuration:   1000,
                    fadeDelay:      0.50,
                keyboard:       false,
                backdrop:       'static'
            });
        }catch(e)
        {
            
            m='ShowBuyers ERROR:\n'+e;
            DisplayMessage(m,'error',Title);
        }
    }
</script>
</body>
</html>