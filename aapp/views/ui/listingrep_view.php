<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php

$logged_in = true;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://www.naijaartmart.com/assets/images/favicon_artsquare_16x16.png" sizes="16x16">
    <title> Naija Art Mart | <?php echo $userType; ?> Listing Requests Report</title>
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
        @media (max-width: 720px)
            .container-fluid {
                padding: 4px 45px;
            }
        }
        @media (max-width: 1300px)
            .container-fluid {
                padding: 0 35px;
            }
            .profile_input{
            padding-left: 8px;
            font-weight: bold;
            font-family: sans-serif;
            color: gray;
            font-size: 18px;
        }
        .form-control {
            display: block;
            width: 100%;
            padding: .385rem .90rem !important;
            font-size: 1.2rem !important;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
        }
        .profile_input{
            padding-left: 8px !important;
            margin: 8px;
            margin-left: 6px !important ;
            font-weight: bold;
            font-family: sans-serif;
            color: gray;
            font-size: 18px;
        }
        .form-control {
            display: block;
            width: 100%;
            margin: 8px;
            padding: 12px !important;
            font-size: 1.2rem !important;
            font-weight: 400;
            line-height: 1.5;
            text-overflow: wrap !important;
            color: #212529;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
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
    <div class="explore-artwork">
      <div class="container-fluid">
        <div class="explore-artwork-inr">
          <div class="heading-otr">
              <div class="head-otr">
                  <h3 class="heading heading-h3">Listing Requests Report</h3>
              </div>
          </div>
          <div class="teb-main">
              <div class="tab-otr">
                  <div class="tab-inr">
                      <ul class="tabs">
                        <li class="tab-link tab-1 active" data-tab="1">
                          <a href="#data" id="tabData" class="tab-p body-sb">Report Parameters</a>
                        </li>
                        <li class="tab-link tab-2" data-tab="2">
                          <a id="tabView" href="#view" class="tab-p body-sb"> View Listing Report</a>
                        </li>
                      </ul>
                  </div>
              </div>
          </div>
          <span class="line"></span>  
          <div class="row row-custom-main">
            <div id="tab1" class="tab-content active">
              <div id="view" class="row row-custom-inr">
                <div title="Issuer Email" class="position-relative row form-group">
                          <label for="lblIssuer" class="col-sm-2 profile_input text-right">Issuer Email</label>
                            
                            <div class="col-sm-4">
                                <label id="lblIssuer" class="form-control nobold"><?php echo $email; ?></label>
                             </div>
                      </div>
                      
                      
                      <!--Listing Status-->
                      <div title="Listing Status" class="position-relative row form-group">
                          <label for="cboStatus" class="col-sm-2 profile_input text-right">Listing Status</label>
                            
                            <div class="col-sm-4">
                                <select class="form-control" style="all:unset !important" id="cboStatus">
                                  <option value="">All Listings</option>
                                  <option value="Listed">Listed</option>
                                  <option value="Awaiting Approval">Awaiting Approval</option>
                                  <option value="Not Approved">Not Approved</option>
                                </select>
                             </div>
                      </div>
                      
                      
                      <!--Requests Start Date-->                                       
                        <div title="Requests Start Date" class="position-relative row form-group">
                             <!--Start Date--> 
                            <label for="txtReportStartDate" class="col-sm-2 profile_input text-right">Request Start Date<span class="redtext">*</span></label>
                        
                            <div class="col-sm-4 date tradedatepicker">
                                <div class="input-group">
                                    <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtReportStartDate" placeholder="Requests Start Date">
                                    
                                    <span class="input-group-btn"><button class="btn btn-sm" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                </div>
                             </div>
                        </div>
                        
                        <!--Requests End Date-->
                        <div title="Requests End Date" class="position-relative row form-group">
                              <label for="txtReportEndDate" class="col-sm-2 profile_input text-right">Requests End Date<span class="redtext">*</span></label>
                        
                            <div class="col-sm-4 date tradedatepicker">
                                <div class="input-group">
                                    <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtReportEndDate" placeholder="Requests End Date">
                                    
                                    <span class="input-group-btn"><button class="btn btn-sm" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                </div>
                                
                             </div>
                        </div>
              </div>
                     
            </div>
            <div id="tab2" class="tab-content">
              <div id="data" class="row row-custom-inr">
                <form>
                    <input type="hidden" id="hidMsgId">
                    <input type="hidden" id="hidCategory">
                          
                        <!--Date-->                                       
                    <div id="titleDate" title="<?php echo $category; ?> Date" class="position-relative row form-group">
                      <label id="lblDate" for="txtDate" class="col-sm-2 profile_input text-right"><?php echo $category; ?> Date</label>
                      
                      <div class="col-sm-10">
                        <input readonly style="background:#ffffff; cursor:default;" id="txtDate" placeholder="<?php echo $category; ?> Date" type="text" class="form-control" value="<?php echo $msgdate; ?>">
                      </div>
                    </div>                                    
                         
                          <!--Header-->                                    
                    <div id="titleHeaders" title="<?php echo $category; ?> Header" class="position-relative row form-group">
                        <label id="lblHeaders" for="txtHeader" class="col-sm-2 profile_input text-right"><?php echo $category; ?> Header</label>
                    
                        <div class="col-sm-10">
                           <input readonly style="background:#ffffff; cursor:default;" id="txtHeader" placeholder="<?php echo $category; ?> Header" type="text" class="form-control" value="<?php echo urldecode($header); ?>">
                         </div>
                    </div>
                        
                    <!--Details-->
                    <div id="titleDetails" title="<?php echo $category; ?> Details" class="position-relative row form-group">
                        <label id="lblDetails" for="txtDetails" class="col-sm-2 profile_input text-right"><?php echo $category; ?> Details</label>
                    
                        <div class="col-sm-10">
                          <div style="height:250px; overflow:auto;" id="divDetails" class="form-control">
                              <?php echo urldecode($details); ?>
                            </div>                                           
                         </div>
                    </div>
                  </form>
                      
                  <div id="divAlert"></div>
                      
                  <div align="center" class="row">
                    <a onClick="window.location.reload(true);" href="#" class="btn btn-outlined1 btn-sm">Refresh</a>
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

  <script src="<?php echo base_url(); ?>/newassets/libs/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/libs/jquery.countdown/jquery.countdown.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/libs/tilt.js/dest/tilt.jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progress.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/js/app.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/datatables.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/chartist/js/chartist.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/klorofil-common.js"></script>
  <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/aes256.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/datatables.min.js"></script>

<script src="<?php echo base_url();?>assets/js/general.js"></script>


  <script>
    var Title='Naija Art Mart Help';
    var m='',table;
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
      
      LoadMessages();
      
      function LoadMessages()
      {
        try
        {
          timedAlert('Loading Messages.',2000,'','info');
          
          $('#recorddisplay > tbody').html('');
          
          var tw=$('#view').width();
          var det_cell=tw * 0.45;
          var head_cell=tw * 0.38;
          
          $.ajax({
            url: '<?php echo site_url('ui/Messages/LoadMessages'); ?>',
            type: 'POST',
            data: {email:Email, detail_width:det_cell, header_width:head_cell,usertype:'<?php echo $usertype; ?>'},
            dataType: 'json',
            success: function(dataSet,status,xhr) { 
              
              
              if (table) table.destroy();
              
              //f-filtering, l-length, i-information, p-pagination
              table = $('#recorddisplay').DataTable( {
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
                  { width: "19%" },//Date
                  { width: "48%" },//Header
                  { width: "28%" },//Sender
                  { width: "5%" } //View
                ]
              } );
              
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
      
      if ('<?php echo $msgid; ?>')
      {
        //Title
        $('#titleDate').prop('title','<?php echo $category; ?>'+' Date');
        $('#titleHeaders').prop('title','<?php echo $category; ?>'+' Header');
        $('#titleDetails').prop('title','<?php echo $category; ?>'+' Details');
        
        //Label
        $('#lblDate').html('<?php echo $category; ?>'+' Date');
        $('#lblHeaders').html('<?php echo $category; ?>'+' Header');
        $('#lblDetails').html('<?php echo $category; ?>'+' Details'); 
        
      }else
      {
        
        $('#titleDate').prop('title','Date');
        $('#titleHeaders').prop('title','Header');
        $('#titleDetails').prop('title','Details');
        
        //Label
        $('#lblDate').html('Date');
        $('#lblHeaders').html('Header');
        $('#lblDetails').html('Details');
      }
        });
    
    function ViewMessage(msgid,header,details,msgdate,category)
    {
      try
      {
        $('#txtDate').val(msgdate);
        $('#hidMsgId').val(msgid);
        $('#txtHeader').val(urldecode(header));
        $('#divDetails').html(urldecode(details));
        $('#hidCategory').val(category);
        
        //Title
        $('#titleDate').prop('title',category+' Date');
        $('#titleHeaders').prop('title',category+' Header');
        $('#titleDetails').prop('title',category+' Details');
        
        //Label
        $('#lblDate').html(category+' Date');
        $('#lblHeaders').html(category+' Header');
        $('#lblDetails').html(category+' Details');       
        
        UiActivateTab('data');        
      }catch(e)
      {
        
        m='ViewMessage ERROR:\n'+e;
        displayMessage(m,'error',Title,'error');
      }
    }
  </script>
</body>
</html>