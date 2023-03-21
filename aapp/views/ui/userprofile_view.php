<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$logged_in = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Derived Homes | <?php echo $usertype; ?> User Profile</title>
    <!-- base:css -->
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
    <link rel="shortcut icon" href="https://www.naijaartmart.com/assets/images/d_favicon.png" />
    <style type="text/css">
        @media (max-width: 720px)
            .container-fluid {
                padding: 4px 25px;
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
            font-size: 16px;
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
            font-size: 16px;
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
    <!--=====s==================================
                Modal Start Here
    ========================================-->

        <div id="myNav" class="overlay-content-otr">
          <?php
            include 'mobNav.php';

            ?>
        </div>

    <!--=======================================
                Modal End Here
    ========================================-->

	<section class="hero-navbar-9">
    <?php
    include 'nav.php';

    ?>
    <div class="create-main" style="padding-top: 12px !important;">
            <div class="container-fluid" >
                <div class="row create-inr">
                    <div class="col-lg-8 col-heading-otr">
                        <div class="heading-inr">
                            <h3 class="heading heading-h3"><?php echo $usertype; ?> Profile</h3>
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
                <div class="card mb-4">
                    <form>
                        <div class="card-header">Profile Information</div>
                        <div class="card-body">
                                    
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (last name)-->
                                <div class="col-md-3">
                                    <label class="small mb-1" for="inputLastName">Broker Name</label>
                                    <input class="form-control" id="txtBrokerName" value="<?php echo $company; ?>" type="text" placeholder="Your Name or company name">
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-3">
                                    <label class="small mb-1" for="inputLastName">Member Code</label>
                                    <input class="form-control" id="txtBrokerId" value="<?php echo $broker_id; ?>" type="text" placeholder="Broker ID" disabled>
                                </div>
                                <!-- Form Group (first name)-->
                                <div class="col-md-3">
                                    <label class="small mb-1" title="Your registered email address" for="txtEmail">Email Address</label>
                                    <input class="form-control" value="<?php echo $email; ?>" type="email" id="txtEmail" placeholder="Enter Email" disabled>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="small mb-1" for="inputPhone">Phone number</label>
                                    <input class="form-control" id="txtPhone" type="tel" placeholder="Enter your phone number" value="<?php echo $phone; ?>">
                                </div>
                                <!-- Form Group (birthday)-->
                                <div class="col-md-3">
                                    <label class="small mb-1" for="txtDate">Incorporation Date</label>
                                    <input class="form-control" type="text" id="txtDate" placeholder="Your Date Of Birth Or Incorporation (For Company)" value="<?php if ($incorporationdate) echo date("d M Y",strtotime($incorporationdate)); else echo ''; ?>">
                                </div>
                                <!-- Form Group (location)-->
                                <div class="col-md-3">
                                    <label class="small mb-1" for="cboState">State</label>
                                    <select class="form-control" id="cboState"></select>
                                </div>
                                <!-- Form Group (organization name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputOrgName">Address</label>
                                    <input class="form-control" id="txtAddress" type="text" placeholder="Your Address" value="<?php echo $address; ?>">
                                </div>
                                
                               
                            </div>
                            <!-- Form Group (email address)-->
                            <div class="row gx-3 mb-3">
                                <?php
                                if (trim(strtolower($usertype))=='investor') {
                                echo '
                                <div class="col-md-6">
                                    <label for="cboBroker" class="small mb-1">Broker<span class="redtext">*</span></label>
                                
                                    <select class="form-control" title="Select a Broker" id="cboBroker"></select>
                                 </div>';                                      
                                    }
                                ?>
                                <div class="col-md-6 ">
                                    <label for="txtBlockchainAddress" title="Blockchain Address" class="small mb-1">Blockchain Address</label>
                                    <a class="text-info form-control" style="background:#F4F4EE; cursor:pointer;margin-left:6px; padding: 16px;text-overflow: ellipsis;overflow-wrap: anywhere; border-radius: 6px;" readonly id="txtBlockchainAddress" target="_blank" href="https://mumbai.polygonscan.com/address/<?php echo $blockchain_address; ?>"><?php echo $blockchain_address; ?></a>
                                </div>
                            </div>         
                        </div>
                        <div class="card-header">Account Details</div>
                        <div class="card-body">
                            <div class="row gx-3 mb-3">
                                <div class="col-md-3">
                                    <label for="txtAccName" title="Your Account Name" class="small mb-1">Account Name<span class="redtext">*</span></label>
                                    <input id="txtAccName" title="Your Account Name" placeholder="Account Name" type="text" class="form-control" value="<?php echo $account_name; ?>">
                                               
                                </div>
                                        
                                <!--Bank-->
                                <div class="col-md-3 ">
                                    <label for="cboBank" title="Your Bank" class="small mb-1">Bank
                                        <span class="redtext">*</span>
                                    </label>
                                    <select class="form-control" id="cboBank"></select>
                                    
                                </div>
                                <div class="col-md-3 ">
                                    <label for="txtAccNo" title="Your Account Number" class="small mb-1">Account Number
                                        <span class="redtext">*</span>
                                    </label>
                                    <input id="txtAccNo" title="Your Account Number" placeholder="Account Number" type="text" class="form-control redalerttext" value="<?php echo $account_number; ?>">
                                </div>
                                        
                                <!--Recipient Code-->
                                <div class="col-md-3">
                                    <label for="txtRecipientCode"  title="Transfer Recipient Code"  class="small mb-1">Recipient Code</label>
                                    <input readonly id="txtRecipientCode"  title="Transfer Recipient Code"  placeholder="Recipient Code" type="text" class="form-control" value="<?php echo $recipient_code; ?>" style="background:#ffffff; cursor:default;">
                                </div>                                
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-5"></div>
                                <div class="col-md-7">
                                    <button id="btnUpdate" type="button" class="btn btn-primary btn-lg text-white">Save Changes</button>                                
                                    <button onClick="window.location.reload(true);" type="button" class="btn btn-lg btn-danger">Refresh</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    
        <!-- container-scroller -->   
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
    
    <!-- <script src="<?php echo base_url(); ?>/newassets/libs/jquery/dist/jquery.min.js"></script> -->
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/jquery.countdown/jquery.countdown.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/tilt.js/dest/tilt.jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/klorofil-common.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progress.js"></script> -->
    <script src="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>/newassets/js/app.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/datatables.min.js"></script>

    <script src="<?php echo base_url();?>assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/chartist/js/chartist.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/klorofil-common.js"></script>
    <script src="<?php echo base_url();?>assets/js/aes256.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/sum().js"></script>
    


    <script src="<?php echo base_url();?>assets/js/general.js"></script>
   <script>
        var Title='Derived Homes Help';
        var m='';
        var Email='<?php echo $email; ?>';
        var Usertype='<?php echo $usertype; ?>';
        
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
              button: ['cancel','Ok']
            })
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

            $('#txtDate').datepicker({
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
            
            if ('<?php echo $set_rc;  ?>') displayMessage('<?php echo $set_rc; ?>', 'info',Title,'success');
            
            LoadStates();           
            LoadPaystackBanks();
            LoadCountries();
            LoadBrokers();
            
            function LoadStates() {
                try {
                    timedAlert('Loading States. Please Wait.',2000,'','info');  

                    $('#cboState').empty();         
    
                    $.ajax({
                        url: "<?php echo site_url('ui/Userprofileiv/GetStates');?>",
                        type: 'POST',
                        dataType: 'json',
                        success: function(data,status,xhr) {        
                            if ($(data).length > 0) {
                                $("#cboState").append(new Option("Select State", ""));
    
                                $.each($(data), function(i,e) {
                                    if (e.state) {
                                        $("#cboState").append(new Option($.trim(e.state), $.trim(e.state)));
                                    }
                                });//End each
                                
                                var st='<?php echo $state; ?>';
                                
                                if (st) $('#cboState').val(st);
                            }   
                        },
                        error:  function(xhr,status,error) {
                            m='Error '+ xhr.status + ' Occurred: ' + error;
                            displayMessage(m, 'Error',Title,'error');
                        }
                    });
                }catch(e) {
                    m='LoadStates ERROR:\n'+e;
                    displayMessage(m, 'error',Title,'error');
                }
            }
            
            function LoadCountries()
            {
                try {
                    timedAlert('Loading Countries. Please Wait.',2000,'','info');   

                    $('#cboCountry').empty();           
    
                    $.ajax({
                        url: "<?php echo site_url('ui/Userprofileiv/GetCountries');?>",
                        type: 'POST',
                        dataType: 'json',
                        success: function(data,status,xhr) {    
    
                            if ($(data).length > 0) {
                                $("#cboCountry").append(new Option("Select Country", ""));
    
                                $.each($(data), function(i,e) {
                                    if (e.country)
                                    {
                                        $("#cboCountry").append(new Option($.trim(e.country), $.trim(e.country)));
                                    }
                                });//End each
                                
                                var cn='<?php echo $nationality; ?>';
                                
                                if (cn) $('#cboCountry').val(cn);
                            }   
                        },
                        error:  function(xhr,status,error) {
                            m='Error '+ xhr.status + ' Occurred: ' + error;
                            displayMessage(m, 'error',Title);
                        }
                    });
                }catch(e) {
                    m='LoadCountries ERROR:\n'+e;
                    displayMessage(m, 'Error',Title,'error');
                }
            }
            
            function LoadBrokers()
            {
                try
                {
                    //timedAlert('Loading Brokers. Please Wait.',2000,'','info'); 

                    $('#cboBroker').empty();            
    
                    $.ajax({
                        url: "<?php echo site_url('ui/Userprofileiv/GetBrokers');?>",
                        type: 'POST',
                        dataType: 'json',
                        success: function(data,status,xhr) {    
    
                            if ($(data).length > 0)
                            {
                                $("#cboBroker").append(new Option("Select Brokers", ""));
    
                                $.each($(data), function(i,e)
                                {
                                    if (e.broker_id && e.company)
                                    {
                                        $("#cboBroker").append(new Option($.trim(e.company), $.trim(e.broker_id)));
                                    }
                                });//End each
                                
                                var bid='<?php echo $broker_id; ?>';
                                
                                if (bid) $('#cboBroker').val(bid);
                            }   
                        },
                        error:  function(xhr,status,error) {
                            m='Error '+ xhr.status + ' Occurred: ' + error;
                            displayMessage(m, 'error',Title,'error');
                        }
                    });
                }catch(e)
                {
                    m='LoadBrokers ERROR:\n'+e;
                    displayMessage(m, 'error',Title);
                }
            }
            
            $('#btnUpdate').click(function(e) {
                try
                {
                    if (!CheckForm()) return false;             
                }catch(e)
                {
                    m='Update Profile Button Clicked ERROR:\n'+e;               
                    displayMessage(m, 'error',Title,'error');
                    return false;
                }
            });//btnUpdate Click Ends
        
            function CheckForm()
            {
                try
                {
                    var cm=$.trim($('#txtBrokerName').val()); 
                    var add=$.trim($('#txtAddress').val());
                    var st=$.trim($('#cboState').val());
                    var ph=$.trim($('#txtPhone').val());
                    var dt=$.trim($('#txtDate').val());
                    var cn=$.trim($('#cboCountry').val());                                  
                    var bid=$.trim($('#txtBrokerId').val());

                    var acnm=$.trim($('#txtAccName').val());
                    var acno=$.trim($('#txtAccNo').val());
                    var bnk=$.trim($('#cboBank').val());
                    
                    if (dt) dt = ChangeDateFrom_dMY_To_Ymd($('#txtDate').val());
                    
                    //Email
                    if (!Email)
                    {
                        m='Email field is blank. Refresh the window. If it is still blank, sign out and sign in again before continuing with the profile update.';
                        
                        displayMessage(m, 'error',Title,'error');
                        return false;
                    }   
                                        
                    //Name
                    if (cm)
                    {
                        if ($.isNumeric(cm))
                        {
                            m='Your name or company name MUST NOT be a number. Current entry '+cm+'</b> is not valid.';                      
                            displayMessage(m, 'error',Title,'warning');
                            $('#txtName').focus(); return false;
                        }
                        
                        if (cm.length < 3)
                        {
                            m='Please enter your correct name or company name. Current entry '+cm+'</b> is too short.';                      
                            displayMessage(m, 'error',Title,'warning');
                            $('#txtName').focus(); return false;
                        }   
                    }                   
                            
                    //Address
                    if (!add)
                    {
                        m='Your address or company address field must not be blank.';                   
                        displayMessage(m, 'error',Title,'warning');                 
                        $('#txtAddress').focus(); return false; 
                    }
                    
                    if ($.isNumeric(add))
                    {
                        m='Your address or company address entry is valid. Please type the full address.';                  
                        displayMessage(m, 'error',Title,'warning');                 
                        $('#txtAddress').focus(); return false;
                    }
                    
                    if (add.length<3)
                    {
                        m='Your address or company address entry is valid. Please type the full address.';                  
                        displayMessage(m, 'error',Title,'warning');                 
                        $('#txtAddress').focus(); return false;
                    }
                    
                    //State
                    if ($('#cboState > option').length < 2)
                    {
                        m='Records of states in Nigeria have not been captured. Please contact the system administrator at support@naijaartmart.com.';
                        displayMessage(m, 'error',Title,'warning');                 
                        return false;
                    }
                    
                    if (!st)
                    {
                        m='Please select the state where you live or your company is located.';
                        displayMessage(m, 'error',Title,'warning');                 
                        $('#cboState').focus(); return false;
                    }
                    
                    //Phone                             
                    if (!ph)
                    {
                        m="Phone number field must not be blank.";
                        displayMessage(m, 'error',Title,'warning');                 
                        $('#txtPhone').focus(); return false;
                    }
                    
                    if (!$.isNumeric(ph.replace('+','')))
                    {
                        m="Phone number field must be numeric.";
                        displayMessage(m, 'error',Title,'warning');                 
                        $('#txtPhone').focus(); return false;
                    }
                    /*
                    //Broker Id
                    if ($.trim(Usertype).toLowerCase()=='investor')//($.trim(Usertype).toLowerCase()=='investor/issuer') or 
                    {
                        if ($('#cboBroker > option').length < 2)
                        {
                            m='Brokers records have not been captured. Please contact the system administrator at support@naijaartmart.com.';
                            DisplayMessage(m, 'error',Title);                   
                            return false;
                        }
                        
                        if (!bid)
                        {
                            m='Please select a broker.';
                            DisplayMessage(m, 'error',Title);                   
                            $('#cboBroker').focus(); return false;
                        }   
                    }*/
                    
                    //Account Name
                    if (acnm=='')
                    {
                        m='Your account name field must not be blank.';
                        
                        displayMessage(m, 'error',Title,'warning');
                        $('#txtAccName').focus(); return false;
                    }
                    
                    if ($.isNumeric(acnm))
                    {
                        m='Your account name MUST NOT be a number. Current entry '+acnm+' is not valid.';                        
                        displayMessage(m, 'error',Title,'warning');
                        $('#txtAccName').focus(); return false;
                    }
                    
                    if (acnm.length < 3)
                    {
                        m='Please enter your correct account name. Current entry '+acnm+' is too short.';                        
                        displayMessage(m, 'error',Title,'warning');
                        $('#txtAccName').focus(); return false;
                    }
                    
                    //Bank Name
                    if ($('#cboBank > option').length < 2)
                    {
                        m='No bank record has been retrieved. Please contact the system administrator at support@.naijaartmart.com.';
                        displayMessage(m, 'error',Title,'warning');                 
                        return false;
                    }
                    
                    if (!bnk)
                    {
                        m='Please select your bank from the list of banks.';
                        displayMessage(m, 'error',Title,'warning');                 
                        $('#cboBank').focus(); return false;
                    }
                    
                    //Your Account No
                    if (acno=='')
                    {
                        m='Your account number field must not be blank.';                       
                        displayMessage(m, 'error',Title,'warning');
                        $('#txtAccNo').focus(); return false;
                    }
                    
                    if (!$.isNumeric(acno))
                    {
                        m='Your account number MUST be a number. Current entry '+acno+' is not valid.';                      
                        displayMessage(m, 'error',Title,'warning');
                        $('#txtAccNo').focus(); return false;
                    }
                    
                    if (acno.length != 10)
                    {
                        m='Please enter the correct account number. Valid account number must be 10 digits long (NUBAN).';                      
                        displayMessage(m, 'error',Title,'warning');
                        $('#txtAccNo').focus(); return false;
                    }
                                                            
                    //Confirm Update            
                    swal({
                      title: 'PLEASE CONFIRM',
                      text: 'Do you want to proceed with the updating of your profile?',
                      type: 'question',
                      showCancelButton: true,
                      cancelButtonColor: '#d33',
                      cancelButtonText: 'No',
                      confirmButtonText: 'Yes, Go Ahead'
                    }).then((result) => {
                      if (result)
                      {
                        timedAlert('Updating Profile. Please Wait.',2000,'','info');
                                            
                        //Initiate POST
                        var uri = "<?php echo site_url('ui/Userprofile/UpdateProfile'); ?>";
                        var xhr = new XMLHttpRequest();
                        var fd = new FormData();
                        
                        xhr.open("POST", uri, true);
                        
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState == 4 && xhr.status == 200)
                            {
                                
                                var res=$.trim(xhr.responseText);
                                console.log(res);
                                                            
                                if (res.toUpperCase()=='OK')
                                {
                                    m='Profile Update Was successful';
                                    displayMessage(m, 'success','Profile Update','success');
                                    window.location.reload(true);                                                                                   
                                }else
                                {
                                    m=res;                              
                                    displayMessage(m, 'error',Title,'error');
                                }
                            }
                        };
                    
                        fd.append('usertype', Usertype);
                        fd.append('company', cm);
                        fd.append('email', Email);
                        fd.append('phone', ph);
                        fd.append('broker_id', bid);                      
                        fd.append('address', add);
                        fd.append('state', st);                     
                        fd.append('dob', dt);
                        // fd.append('nationality', cn);                       
                        fd.append('account_name', acnm);
                        fd.append('account_number', acno);
                        fd.append('bank_code', bnk);
                        // console.log(fd);                                                                               
                        xhr.send(fd);
                      }
                    })
                }catch(e)
                {
                    m='CheckForm ERROR:\n'+e;
                    displayMessage(m, 'error',Title,'error');
                    return false;
                }
            }
        });
        
        function LoadPaystackBanks()
        {
            try
            {
                timedAlert('Loading Banks. Please Wait...',2000,'','info');             
    
                $('#cboBank').empty();              
    
                $.ajax({
                    url: "<?php echo site_url('admin/Settings/GetPaystackBanks');?>",
                    type: 'POST',
                    dataType: 'json',
                    success: function(data,status,xhr) {    
    
                        if ($(data).length > 0)
                        {
                            $("#cboBank").append(new Option("Select Bank", ""));
                            
                            $.each($(data), function(i,e)
                            {
                                if (e.name && e.code)
                                {
                                    if (e.name) $("#cboBank").append(new Option($.trim(e.name), $.trim(e.code)));
                                }
                            });//End each
                            
                            $('#cboBank').val('<?php echo $bank_code; ?>');
                        }   
                    },
                    error:  function(xhr,status,error) {
                        m='Error '+ xhr.status + ' Occurred: ' + error;
                        displayMessage(m, 'error',Title);
                    }
                });
            }catch(e)
            {
                m='LoadPaystackBanks ERROR:\n'+e;
                displayMessage(m, 'error',Title,'error');
            }
        }
    </script>
</body>
</html>