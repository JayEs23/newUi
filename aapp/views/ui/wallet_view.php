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
    <title> Derived Homes | <?php echo $usertype; ?> Wallet</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/assets/owl.theme.default.min.css">
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progressjs.css"> -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/fonts/fonts.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/newassets/css/app.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datatables.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/linearicons/style.css">
    <link rel='stylesheet' id='font-awesome-cdn-css'  href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css?ver=5.7.8' type='text/css' media='all' />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/chartist/css/chartist-custom.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker3.min.css" >
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet"><!-- GOOGLE FONTS -->
    <link href="<?php echo base_url();?>assets/css/datatables.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>/newassets/libs/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/chartist/js/chartist.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/klorofil-common.js"></script>
  <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/aes256.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/datatables.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/moment.min.js"></script>
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
        <div class="container-fluid" style="padding-top: 20px !important;">
            <div class="explore-artwork-inr">
              <div class="row create-inr">
                    <div class="col-lg-8 col-heading-otr">
                        <div class="heading-inr">
                            <h3 class="heading heading-h3"><?php echo $usertype ?> Wallet</h3>
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
                  <div id="tab-1" class="tab-content active">
                        
                        <!--Table-->
                    <div class="row form-group">  
                    
               </div>
              
              <div id="divAlert"></div>
               
              <div class="card" >
                <div class="card-body">
                  <!--Display Period-->           
                  <div class="row">
                    <div class="col-sm-2">
                      <span>Display Period</span>
                        
                      <select class="form-control" id="cboPeriod">
                        <option value="Last 10 Days">Last 10 Days</option>
                        <option value="Today">Today</option>
                        <option value="This Week">This Week</option>
                        <option value="Last Week">Last Week</option>
                        <option value="Last Month">Last Month</option>
                        <option value="Range Of Dates">Range Of Dates</option>
                      </select>
                    </div>
                    <div class="col-sm-2 date datepicker" id="divFrom">
                      <span>From</span>
                      <div class="input-group">
                        <input style="cursor:default;" readonly id="txtStartDate" placeholder="From Date" type="text" class="form-control" data-date-format="yyyy-mm-dd">
                        <span class="input-group-btn"><button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button></span>
                      </div>
                    </div>
                    <div class="col-sm-4" id="divTo">
                      <div class="row">
                        <div class="col-sm-8">
                          <span>To</span>
                          <div class="input-group">
                            <div class="input-group date datepicker">
                              <input style="background:#ffffff; cursor:default;" readonly id="txtEndDate" placeholder="To Date" type="text" class="form-control" data-date-format="yyyy-mm-dd">
                                  
                              <div class="input-group-btn">
                                <button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                          <span class="input-group-btn">
                            <button style="margin-left:20px;" id="btnDisplay" type="button" class="btn btn-info">Display</button>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3" style="float:right;">
                      <span>Payment Status</span>
                      <select class="form-control text-right" id="cboStatus"></select>
                    </div>
                  </div>     
                  <div class="row">
                    <div class="col-sm-8"> 
                      <label for="txtAmount" class=" col-form-label">Enter The Amount:</label>
                          
                      <div class="" title="Enter the amount to top-up your wallet with">
                        <input id="txtAmount" min="0" placeholder="Amount " type="number" class="form-control">
                      </div>
                           
                      <div class="">
                        <button id="btnCredit" href="#" class="btn btn-info">Add Funds</button>
                      </div>
                    </div>
                    

                  </div>
                    
                  <div class="row">
                    <table class="hover table table-bordered data-table display wrap" id="recorddisplay">
                      <thead>
                        <tr>
                            <th style="text-align:center" width="17%">Date</th>
                            <th style="text-align:center" width="25%">Reference</th> 
                            <th style="text-align:center" width="18%">Channel</th>
                            <th style="text-align:right" width="21%">Amount</th>
                            <th style="text-align:center" width="19%">Status</th>
                        </tr>
                      </thead>

                      <tbody id="tbbody"></tbody>
                      
                      <tfoot >
                        <tr>
                            <th colspan="3" style="text-align:center; padding:3px; padding-right:10px; font-weight:bold; font-size:14px;">Total Payment for the Period:</th>
                            <th id="tdAmount" style="text-align:right; padding:3px; padding-right:8px; font-weight:bold; font-size:13px;"></th>
                            <th style="padding:3px; padding-right:8px; font-weight:bold; font-size:13px;" width="19%"></th>
                        </tr>
                      </tfoot>
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

  <!-- <script src="<?php echo base_url(); ?>/newassets/libs/jquery.countdown/jquery.countdown.js"></script> -->
  <script src="<?php echo base_url(); ?>/newassets/libs/tilt.js/dest/tilt.jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
     <script src="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progress.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/js/app.js"></script>
  <script src="https://js.paystack.co/v1/inline.js"></script>
  <script src="<?php echo base_url();?>assets/js/datatables.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>  
  <script src="<?php echo base_url();?>assets/js/sum().js"></script>

  <script src="<?php echo base_url();?>assets/vendor/chartist/js/chartist.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/klorofil-common.js"></script>
  <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/aes256.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/datatables.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/moment.min.js"></script>


<script src="<?php echo base_url();?>assets/js/general.js"></script>


<script>
  var Title='Derived Homes Help';
  var m='',table;
  var Email='<?php echo $email; ?>';
  var bal='<?php echo $balance; ?>';
  
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
      var targetleft=$('#ulUsertype').offset().left;
      var marqueeleft=$('.simple-marquee-container').offset().left;
      var dif=targetleft - marqueeleft;
      dif -= 20;
      
      $('.simple-marquee-container').css('width',dif);
      
    });


  function LogOut()
  {
    try
    {
      var m='Signing out will abort every active process and unsaved data will be lost. Do you still want to sign out?';
      swal({
        icon: 'warning',
        title: 'Confirm Signout!',
        text: m,
            buttons: ["Cancel","Yes!"],
        showCancelButton: true,
      }).then((result) => {
        if (result) {
          window.location.href='<?php echo site_url('ui/Signout'); ?>';
        }
      })  
    }catch(e)
    {

    }     
  }

  $(document).ready(function(e) {
          
    $('.datepicker').datepicker({
      weekStart: 1,
      todayBtn:  "linked",
      autoclose: 1,
      todayHighlight: 1,
      maxViewMode: 4,
      clearBtn: 1,
      forceParse: 0,
      daysOfWeekHighlighted: "0,6",
      //daysOfWeekDisabled: "0,6",
      format: 'd M yyyy'
    });     
        
    $('#txtStartDate').datepicker({
      weekStart: 1,
      todayBtn:  "linked",
      autoclose: 1,
      todayHighlight: 1,
      maxViewMode: 4,
      clearBtn: 1,
      forceParse: 0,
      daysOfWeekHighlighted: "0,6",
      //daysOfWeekDisabled: "0,6",
      format: 'd M yyyy'
    }); 
    
    $('#txtStartDate').blur(function(e) {
      try
      {
        if ($('#txtStartDate').val() && $('#txtEndDate').val())
        {
          VerifyStartAndEndDates();
        } 
      }catch(e)
      {
        
        m="Start Date Blur ERROR:\n"+e;
        displayMessage(m, 'error',Title,'error');
        return false;
      }

    });
    
    $('#txtStartDate').change(function(e) {
      try
      {
        if ($('#txtStartDate').val() && $('#txtEndDate').val())
        {
          VerifyStartAndEndDates();
        } 
      }catch(e)
      {
        
        m="Start Date Change ERROR:\n"+e;
        displayMessage(m, 'error',Title,'error');
        return false;
      }

    });
        
    $('#txtEndDate').datepicker({
      weekStart: 1,
      todayBtn:  "linked",
      autoclose: 1,
      todayHighlight: 1,
      maxViewMode: 4,
      clearBtn: 1,
      forceParse: 0,
      daysOfWeekHighlighted: "0,6",
      //daysOfWeekDisabled: "0,6",
      format: 'd M yyyy'
    });
    
    $('#txtEndDate').blur(function(e) 
    {
      try
      {
        if ($('#txtStartDate').val() && $('#txtEndDate').val())
        {
          VerifyStartAndEndDates();
        } 
      }catch(e)
      {
        
        m="End Date Blur ERROR:\n"+e;
        displayMessage(m, 'error',Title,'error');
        return false;
      }

    });
    
    $('#txtEndDate').change(function(e) 
    {
      try
      {
        if ($('#txtStartDate').val() && $('#txtEndDate').val())
        {
          VerifyStartAndEndDates();
        } 
      }catch(e)
      {
        
        m="End Date Change ERROR:\n"+e;
        displayMessage(m, 'error',Title,'error');
        return false;
      }

    });   
    
    function VerifyStartAndEndDates()
    {
      try
      {
        $('#divAlert').html('');
        
        var startdt=ChangeDateFrom_dMY_To_Ymd($('#txtStartDate').val());
        var enddt=ChangeDateFrom_dMY_To_Ymd($('#txtEndDate').val());
        var sdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
        var edt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
        var d;
        
        if ($('#txtStartDate').val()=='0000-00-00') $('#txtStartDate').val('');
        if ($('#txtEndDate').val()=='0000-00-00') $('#txtEndDate').val('');
        
        if ($('#txtStartDate').val())
        {
          if (!sdt.isValid())
          {
            m="From Date Is Not Valid. Please Select A Valid From Date.";
            
            displayMessage(m, 'error',Title,'error');
          } 
        }
        
        
        if ($('#txtEndDate').val())
        {
          if (!edt.isValid())
          {
            m="To Date Is Not Valid. Please Select A Valid To Date.";
            displayMessage(m, 'error',Title,'error');
          } 
        }
        
                  
        //moment('2010-10-20').isSameOrBefore('2010-10-21');  // true       
        var dys=edt.diff(sdt, 'days') //If this -ve invalid date entries. Delivery earlier than pickup
        var diff = moment.duration(edt.diff(sdt));
        var mins = parseInt(diff.asMinutes());
        
        
        if (dys<0)
        {
          $('#txtEndDate').val('');
                    
          m="To Date Is Before From Date. Please Correct Your Entries!";
          displayMessage(m, 'error',Title,'error');
        }
      }catch(e)
      {
        
        m="VerifyStartAndEndDates ERROR:\n"+e;        
        displayMessage(m, 'error',Title,'error');
        return false;
      }
    }
    
    $('#divFrom').hide();
    $('#divTo').hide();     
    
    LoadStatus();
    
    DisplayPayments('Last 10 Days','','','');
    
    $('#cboPeriod').change(function(e) {
              try
      {
        $('#divFrom').hide();
        $('#divTo').hide();
        
        $('#txtStartDate').val('');
        $('#txtEndDate').val('');
    
        var p=$.trim($(this).val());
        var s=$.trim($('#cboStatus').val());
        
        if ($.trim(p).toLowerCase()=='range of dates')
        {
          $('#divFrom').show();
          $('#divTo').show();
        }else
        {
          if (s)
          {
            DisplayPayments(p,'','',s)
          }else
          {
            DisplayPayments(p,'','','')
          }           
        }
      }catch(e)
      {
        
        m="Period Change ERROR:\n"+e;
        displayMessage(m, 'error',Title,'error');
        return false;
      }
          });
    
    $('#cboStatus').change(function(e) {
              try
      {
        var s=$.trim($(this).val());
        var p=$.trim($('#cboPeriod').val());
        
        if ($.trim(p).toLowerCase() != 'range of dates')
        {
          DisplayPayments(p,'','',s);
        }else
        {
          var sd=$.trim($('#txtStartDate').val());
          var ed=$.trim($('#txtEndDate').val());
          
          if (sd && ed)
          {
            var sdt=ChangeDateFrom_dMY_To_Ymd($('#txtStartDate').val());
            var edt=ChangeDateFrom_dMY_To_Ymd($('#txtEndDate').val());
            
            if (s)
            {
              DisplayPayments('range of dates',sdt,edt,s);
            }else
            {
              DisplayPayments('range of dates',sdt,edt,'');
            }             
          }
        }
      }catch(e)
      {
        
        m="Payment Status Change ERROR:\n"+e;
        displayMessage(m, 'error',Title,'error');
        return false;
      }
          });
    
    function CheckDate()
    {
      try
      {
        var startdt=ChangeDateFrom_dMY_To_Ymd($('#txtStartDate').val());
        var enddt=ChangeDateFrom_dMY_To_Ymd($('#txtEndDate').val());
        var pdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
        var ddt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
        var p=$.trim($('#txtStartDate').val());
        var d=$.trim($('#txtEndDate').val());   
                    
        //From date Not Select. To Date Selected
        if (!p)
        {
          m='You have not selected <b>from</b> date.';
          
          displayMessage(m, 'error',Title,'error');
          return false; 
        }
                
        if (!d)
        {
          m='You have not selected <b>to</b> date.';
          
          displayMessage(m, 'error',Title,'error');
          return false; 
        }
          
        if (!p && d)
        {
          m='You have selected <b>to</b> date. <b>From</b> date field must also be selected.';
          
          displayMessage(m, 'error',Title,'error');
          return false; 
        }
          
        //End date Not Select. Start Date Selected
        if (p && !d)
        {
          m='You have selected <b>from</b> date. <b>To</b> date must also be selected.';
          
          displayMessage(m, 'error',Title,'error');
          return false; 
        }
          
        if (p)
        {
          if (!pdt.isValid())
          {
            m="<b>From</b> Date Is Not Valid. Please Select A Valid <b>To</b> Date";
            displayMessage(m, 'error',Title,'error');
            return false;
          } 
        }
          
        if (d)
        {
          if (!ddt.isValid())
          {
            m="<b>To</b> Date Is Not Valid. Please Select A Valid <b>To</b> Date";
            displayMessage(m, 'error',Title,'error');           
            return false;
          } 
        }
                
        if (p && d)
        {
          var dys=ddt.diff(pdt, 'days') //If this -ve invalid date entries. Delivery earlier than pickup
          
          if (dys<0)
          {
            m="<b>To</b> Date Is Before The <b>From</b> Date. Please Correct Your Entries!";
            displayMessage(m, 'error',Title,'error');
            return false;
          }
        }     
        
        return true;
      }catch(e)
      {
        
        m="CheckForm ERROR:\n"+e;
        displayMessage(m, 'error',Title,'error');
      }
    }//End CheckDate
    
    $('#btnDisplay').click(function(e) {
              try
      {
        if (!CheckDate()) return false;
        
        var sdt=ChangeDateFrom_dMY_To_Ymd($('#txtStartDate').val());
        var edt=ChangeDateFrom_dMY_To_Ymd($('#txtEndDate').val());
        var p=$.trim($('#cboPeriod').val());
        var s=$.trim($('#cboStatus').val());
        
        if ($.trim(p).toLowerCase()=='range of dates')
        {
          if (s)
          {
            DisplayPayments('range of dates',sdt,edt,s);
          }else
          {
            DisplayPayments('range of dates',sdt,edt,'');
          }           
        }else
        {
          if (s)
          {
            DisplayPayments(p,'','',s);
          }else
          {
            DisplayPayments(p,'','','');
          }
        }
      }catch(e)
      {
        
        m='GO Button Click ERROR:\n'+e;
        displayMessage(m, 'error',Title,'error');
        return false;
      }
          });
    
    function DisplayPayments(period,sdt,edt,sta)
    {
      try
      {
        timedAlert('Loading Payments Records.',2000,'','info');
        var mail = '<?php echo $email;?>';
        var mydata={period:period,email:mail,startdate:sdt,enddate:edt,trans_status:sta};  
        
        $('#recorddisplay > tbody').html('');
        
        $.ajax({
          url: "<?php echo site_url('ui/Wallet/GetPayments');?>",
          data: mydata,
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
              language: {zeroRecords: "No Payments Record Found"},
              lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],                  
              columnDefs: [
                {
                  "targets": [ 0,1,2,3,4 ],
                  "visible": true
                },
                {
                  "targets": [ 0,1,2,3,4 ],
                  "orderable": true
                },
                {
                  "targets": [ 0,1,2,3,4 ],
                  "searchable": true
                },
                { className: "dt-center", "targets": [ 0,1,2,4 ] },
                { className: "dt-right", "targets": [ 3 ] }
              ],          
              order: [[ 2, 'asc' ]],
              data: dataSet, 
              columns: [
                { width: "17%" },//Payment Date
                { width: "25%" },//Payment Ref
                { width: "18%" },//Channel
                { width: "21%" },//Amount
                { width: "19%" }//Transaction Status
              ],
            } );
            
            //Compute Total
            var Tot=table.column(3).data().sum(); //Cost
                        
            $('#tdAmount').html('₦' + number_format(Tot, 2, '.', ','));
          },
          error:  function(xhr,status,error) {
            
            m='Error '+ xhr.status + ' Occurred: ' + error;
            displayMessage(m,'error',Title,'error');
          }
        });
      }catch(e)
      {
        
        m='DisplayPayments ERROR:\n'+e;
        displayMessage(m,'error',Title,'error');
      }
    }
    
    $('#btnCredit').click(function(e) {
              try
      {
        e.preventDefault();
        
        if (!CheckForm()) return false;
      }catch(e)
      {
        
        m='Credit Button Click ERROR:\n'+e;
        displayMessage(m, 'error',Title,'error');
        return false;
      }
          });
    
    $('#lblBalance').html('₦'+number_format(bal, '2', '.', ','));//Update balance
    
    function PayStackPayment(result)
    {
      try
      {
        var amt=$.trim($('#txtAmount').val()).replace(new RegExp(',', 'g'), '');          
        var sid=GetId();
        var TransAmt=parseFloat(amt) * 100;
        var desc='Naija Art Market Wallet Top-up.';
        var mydata={amount:TransAmt, currency:'NGN', email:Email, description:desc, TransRef:sid};
        
        //Log Transaction Here
        $.ajax({
          url: '<?php echo site_url('ui/Wallet/LogTrans'); ?>',
          data: mydata,
          type: 'POST',
          dataType: 'text',
          success: function(data,status,xhr) {        
            var ret='';
            ret=$.trim(data);
                        
            if (ret.toUpperCase()=='OK')
            {
              var handler = PaystackPop.setup({
                //key: 'pk_test_eea6f8898c138852d1c14365b6c60b0527756d1c',
                key: 'pk_test_8a3cb47a51ef50f7eb36be01eaedecb388c0efa4',
                email: Email,
                amount: TransAmt,
                reference: sid,
                //container: 'paystackEmbedContainer',
                metadata: {
                   custom_fields: [
                    {
                      trans_ref: sid,
                      usertype:'<?php echo $usertype; ?>'
                      //display_name: "Mobile Number",
                      //variable_name: "mobile_number",
                      //value: "+2348012345678"
                    }
                   ]
                  },
                callback: function(response){
                  VerifyPayment(sid,Email,TransAmt,response.reference);
                },onClose: function(){
                  CancelLog(Email,sid);
                }
              });
              
              handler.openIframe();
            }else
            {
              m=ret;
              displayMessage(m, 'error',Title,'error'); 
            }
          },
          error:  function(xhr,status,error) {
            m='Error '+ xhr.status + ' Occurred: ' + error;
            displayMessage(m, 'error',Title,'error');
          }
        });
      }catch(e)
      {
        
        m="PayStackPayment ERROR:\n"+e;
        displayMessage(m, 'error',Title,'error');
      }    
    }
  
  function VerifyPayment(TransRef,email,TransAmt,reference) 
  {
    var self;
    var m;
    
    try
    {
      timedAlert('Verifying Payment. ',2000,'','info');
      
      var PayMethod='PayStack';           
      var mydata={email:email, amount:TransAmt, TransRef:TransRef, payment_reference:reference,usertype:'<?php echo $usertype; ?>'};
      
      //Log Transaction Here
      $.ajax({
        url: '<?php echo site_url('ui/Wallet/VerifyTransaction'); ?>',
        data: mydata,
        type: 'POST',
        dataType: 'json',
        success: function(data,status,xhr) {        
          
          
          var sta='';
        
          if ($(data).length > 0)
          {
            $.each($(data), function(i,e)
            {
              sta=e.status;
              
              if ($.trim(sta).toUpperCase()=='OK')
              {
                LoadStatus();
                
                $('#txtAmount').val('');
                
                var b=number_format((parseFloat(TransAmt)/100), '2', '.', ',');
                
                //m='Payment was successful. Your wallet has been topped up with the sum of <b>₦' + b + '</b> and your new wallet balance is now ₦' + number_format(e.balance, "2", ".", ",");
                
                m='Payment was successful. Your wallet will be credited with the sum of <b>₦' + b + '</b>.';              
                
                DisplayMessage(m, 'success','Payment Successful','SuccessTheme');
                
                setTimeout(GetBalance(email), 10000);                                       
              }else
              {
                m=e.messages;
                displayMessage(m, 'error',Title,'error');
              }
              
              return;
            });//End each
          }else
          {   
            m='Top-up Failed.';
            displayMessage(m, 'error',Title,'error');
          }
        },
        error:  function(xhr,status,error) 
        {
          
          m='Error '+ xhr.status + ' Occurred: ' + error;
          displayMessage(m, 'error',Title,'error');
        }
      });
    }catch(e)
    {
      
      m='VerifyPayment Module ERROR:\n'+e;
      displayMessage(m, 'error',Title,'error'); 
    }
  }   
  
  function CancelLog(Email,ref)
  {
    try
    {
      timedAlert('Cancelling Transaction.',2000,'','info');        
  
      $.ajax({
        url: "<?php echo site_url('ui/Wallet/CancelTransLog');?>",
        data: {transref:ref,email:Email},
        type: 'POST',
        dataType: 'json',
        success: function(data,status,xhr) {  
          
          
          if ($(data).length > 0)
          {
            $.each($(data), function(i,e)
            {
              if (parseInt(e.Status) == 1)
              {
                m='Transaction was cancelled successfully.';
                displayMessage(m, 'error',Title,'error');
              }else
              {
                m=e.Message;
                displayMessage(m, 'error',Title,'error');
              }
                  
              return;
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
      
      m='CancelLog ERROR:\n'+e;
      displayMessage(m, 'error',Title,'error');
    }
  }
  
  function GetBalance(email)
  {
    try
    {
      $.ajax({
        url: "<?php echo site_url('ui/Wallet/LoadWalletBalance');?>",
        type: 'POST',
        data:{email:email},
        dataType: 'text',
        success: function(bal,status,xhr) { 
          

          DisplayPayments('Last 10 Days','','','');
          
          $('#lblBalance').html('₦'+number_format(bal, '2', '.', ','));
          $('#uiWalletBalance').html('₦'+number_format(bal, '2', '.', ','));
        },
        error:  function(xhr,status,error) {
          
          m='Error '+ xhr.status + ' Occurred: ' + error;
          displayMessage(m, 'error',Title,'error');
        }
      });
    }catch(e)
    {
      
      m='GetBalance ERROR:\n'+e;
      displayMessage(m, 'error',Title,'error');
    }
  }
    
  
  function CheckForm()
  {
    var m='';
    
    try
    {
      var amt=$.trim($('#txtAmount').val()).replace(new RegExp(',', 'g'), '');
                
      //Email
      if (!Email)
      {
        m='Cannot determine your email. Refresh the window. If it is still blank, sign out and sign in again before continuing with the payment.';
        
        displayMessage(m, 'error',Title,'error');
        return false;
      }     
      
      //Amount
      if (!amt)
      {
        m='The amount to top-up must not be blank.';        
        displayMessage(m, 'error',Title,'error');         
        return false;
      }
      
      if (!$.isNumeric(amt))
      {
        m='The amount to top-up MUST be a number. Current entry <b>'+amt+'</b> is not valid.';            
        displayMessage(m, 'error',Title,'error');
        return false;
      }

      if (parseFloat(amt) == 0)
      {
        m='The amount to top-up must not be zero.';       
        displayMessage(m, 'error',Title,'error');
        return false;
      }
      
      if (parseFloat(amt) < 0)
      {
        m='The amount to top-up must not be a negative number.';        
        displayMessage(m, 'error',Title,'error');
        return false;
      }
      
                          
      //Confirm Update      
      swal({
        title: 'PLEASE CONFIRM',
        text: 'Do you want to proceed with the wallet top-up?',
        type: 'question',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result) PayStackPayment(true);
      })
    }catch(e)
    {
      
      m='CheckForm ERROR:\n'+e;
      displayMessage(m, 'error',Title,'error');
      return false;
    }
  }
  
  function LoadStatus()
  {
    try
    {
      timedAlert('Loading Transaction Status.',2000,'',''); 

      $('#cboStatus').empty();    

      $.ajax({
        url: "<?php echo site_url('ui/Wallet/GetStatuses');?>",
        type: 'POST',
        dataType: 'json',
        success: function(data,status,xhr) {  
          

          if ($(data).length > 0)
          {
            $("#cboStatus").append(new Option("ALL", ""));
              
            $.each($(data), function(i,e)
            {
              if (e.trans_status)
              {
                $("#cboStatus").append(new Option($.trim(e.trans_status).toUpperCase(), $.trim(e.trans_status)));
              }
            });//End each
            
            $("#cboStatus").append(new Option("PENDING", "PENDING"));
          } 
        },
        error:  function(xhr,status,error) {
          
          m='Error '+ xhr.status + ' Occurred: ' + error;
          displayMessage(m, 'error',Title,'error');
        }
      });
    }catch(e)
    {
      
      m='LoadStatus ERROR:\n'+e;
      displayMessage(m, 'error',Title,'error');
    }
  }
    });
</script>
</body>
</html>