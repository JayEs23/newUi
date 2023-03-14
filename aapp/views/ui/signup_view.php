
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://www.naijaartmart.com/assets/images/d_favicon.png" sizes="16x16">
    <title>Derived Homes - Sign Up</title>
    <link rel="stylesheet" href="<?php echo site_url();?>newassets/libs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo site_url();?>newassets/libs/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo site_url();?>newassets/libs/owl.carousel/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo site_url();?>newassets/libs/progress.js-master/src/progressjs.css">
    <link rel="stylesheet" href="<?php echo site_url();?>newassets/fonts/fonts.css">
    <link rel="stylesheet" href="<?php echo site_url();?>newassets/css/app.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/aes256.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/general.js"></script>

</head>
<body>
    <!--=======================================
            signup Start Here
    ========================================-->

        <div class="signup-main">
            <div class="container-fluid">
                <div class="sign-up">
                    <div class="nav-bar">
                        <div class="logo-otr">
                            <!-- <a href="../index.html" class="logo-inr">
                                <img class="logo-img" src="<?php echo site_url();?>newassets/img/brand-logo-white.png" alt="logo">
                            </a> -->
                        </div>
                        <div class="button-otr">
                            <a href="" class="member body-sb">Already a member?</a>
                            <div class="action-otr">
                                <a href="<?php echo site_url('ui/Login');?>" class="btn-fill-white btn-signup">Login</a>
                            </div>
                        </div>
                    </div>
                    <div class="row row-login">
                        <div class="col-lg-6 col-login-otr">
                            <div class="col-login-inr">
                                <div class="content">
                                    <h3 class="head heading-h3">Sign Up to Naija Art Mart</h3>
                                    <div class="login-social">
                                        <span class="line"></span>
                                        <p class="desc body-s">Choose Category</p>
                                        <span class="line"></span>
                                    </div>
                                    <div class="btn-main">
                                        <div class="btn-otr">
                                            <input type="radio" onchange="userType(this.value)" name="cboUserType" id="cboUserType" value="Investor" class="input-check opacity-0"> <span style="font-family: sans-serif; font-size: px; color: gray;">Investor </span>
                                        </div>
                                        <div class="btn-otr">
                                            <input type="radio" onchange="userType(this.value)" value="Issuer" name="cboUserType" id="cboUserType" class="input-check opacity-0"> <span style="font-family: sans-serif; font-size: px; color: gray;">Issuer</span>                                       </div>
                                    </div>
                                    <div class="login-social">
                                        <span class="line"></span>
                                    </div>
                                    <form class="form-main" method="post">
                                        <div class="input-otr">
                                            <input class="input" type="text" name="fname" placeholder="Your Full Name" id="txtUserName" required>
                                        </div>
                                        <div class="input-otr">
                                            <input class="input" type="email" id="txtEmail" placeholder="Your Email Address" required>
                                        </div>
                                        <div class="input-otr">
                                            <input class="input" type="tel" id="txtPhone" placeholder="Your Phone Number" required>
                                        </div>
                                        <div class="input-otr">
                                            <input class="input" type="password" id="txtPwd" placeholder="Set Your Password" required>
                                        </div>
                                        <div class="input-otr input-otr-2">
                                            <input class="input" type="password" id="txtConfirm" placeholder="Confirm Password" required>
                                        </div>
                                        <div class="check-main">
                                            <div class="check">
                                                <label>
                                                    <span class="check-inner">
                                                        <input type="checkbox"  id="chkAgree" class="input-check opacity-0 absolute">
                                                        <svg class="fill-current" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="12" fill="#366CE3"/><path d="M16.521 8.938l-6.125 6.125L7.335 12" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </span>
                                                    <span class="select-none body-sb">I agree to the <a href="<?php echo site_url('ui/Privacy') ?>" class="link body-sb" target="_blank"> Privacy Policy </a> & <a href="<?php echo site_url('ui/Terms') ?>" class="link body-sb" target="_blank"> Terms of Service </a></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="action-otr">
                                            <button class="button body-sb" type="button" id="nextBtn" onclick="validateForm()"> Sign Up</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer-login">
                        <div class="copy-inr">
                            <div class="language-selector">
                                <ul class="language-ul">
                                   
                                </ul>
                            </div>
                            <div class="privacy-link">
                                <a href="<?php echo site_url('ui/Privacy') ?>" class="link body-sb">Privacy Policy</a>
                                <span class="dot">•</span>
                                <a href="<?php echo site_url('ui/Terms') ?>" class="link body-sb">Terms of Service</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!--=======================================
            signup End Here
    ========================================-->


    <script src="<?php echo site_url();?>newassets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo site_url();?>newassets/libs/jquery.countdown/jquery.countdown.js"></script>
    <script src="<?php echo site_url();?>newassets/libs/tilt.js/dest/tilt.jquery.min.js"></script>
    <script src="<?php echo site_url();?>newassets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
    <!-- <script src="<?php echo site_url();?>newassets/libs/progress.js-master/src/progress.js"></script> -->
    <script src="<?php echo site_url();?>newassets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo site_url();?>newassets/js/app.js"></script>
    <script>

    var type; 

    function userType(value){
        type = value;
    }

    function IsValidPassword(pwd,uname,len) { 
        var ret='';
        var re;
        
        if (!pwd) return 'Password must not be blank.'; 
        if (pwd.length < len) return "Password must contain at least "+len+" characters!";
        
        re = /[0-9]/g;  
        if (!re.test(pwd)) return "Password must contain at least one number (0-9)!";
        
        re = /[a-z]/g;
        if (!re.test(pwd)) return "Password must contain at least one lowercase character (a-z)!";
        
        re = /[A-Z]/g;
        if (!re.test(pwd)) return "Password must contain at least one uppercase character (A-Z)!";
        
        re = /[^a-zA-Z\d]/g;
        if (!re.test(pwd)) return "Password must contain at least one special character (#,$,%,&,etc)!";
        
        if (uname)
        {
            if(pwd == uname) return "Password must be different from username/login email!";
        }

        return 1;
    }

    function CheckRegister()
    {
        var m;       


        try
        {
            var ut=$.trim($('#cboUserType').val()).toLowerCase();           
            var nm=$.trim($('#txtUserName').val());
            
            var em=$.trim($('#txtEmail').val());
            var ph=$.trim($('#txtPhone').val());
            var pwd=$('#txtPwd').val();
            var cpw=$('#txtConfirm').val();
                        
            var chk='0';            
            if ($('#chkAgree').is(':checked')) chk='1';
            
            // var bvn=$.trim($('#txtBvn').val());
            // var acnm=$.trim($('#txtAccName').val());
            // var acno=$.trim($('#txtAccNo').val());
            // var bnk=$.trim($('#cboBank').val());
            //User type
            if (!ut)
            {
                m='Please indicate the type of user you want to register as.';
                displayMessage(m, 'error',Title,'error');
                $('#cboUserType').focus(); return false;
            }
            
            //Name
            if (!nm)
            {
                m='Name field must not be blank.';
                displayMessage(m, 'error',Title,'error');                   
                $('#txtUserName').focus(); return false;
            }
            
            if ($.isNumeric(nm))
            {
                m='Name field must not be a number.';                   
                displayMessage(m, 'error',Title,'error');                   
                $('#txtUserName').focus(); return false;
            }
            
            if (nm.length<3)
            {
                m='Please enter a meaningful name.';                    
                displayMessage(m, 'error',Title,'error');                   
                $('#txtUserName').focus(); return false;
            }
            
            //Account Name
            // if (acnm=='')
            // {
            //     m='Your account name field must not be blank.';
                
            //     displayMessage(m, 'error',Title,'error');
            //     $('#txtAccName').focus(); return false;
            // }
            
            // if ($.isNumeric(acnm))
            // {
            //     m='Your account name MUST NOT be a number. Current entry '+acnm+' is not valid.';                        
            //     displayMessage(m, 'error',Title,'error');
            //     $('#txtAccName').focus(); return false;
            // }
            
            // if (acnm.length < 3)
            // {
            //     m='Please enter your correct account name. Current entry '+acnm+' is too short.';                        
            //     displayMessage(m, 'error',Title,'error');
            //     $('#txtAccName').focus(); return false;
            // }
                    
            // //Bank Name
            // if ($('#cboBank > option').length < 2)
            // {
            //     m='No bank record has been retrieved. Please contact the system administrator at support@.naijaartmart.com.';
            //     displayMessage(m, 'error',Title,'error');                   
            //     return false;
            // }
            
            // if (!bnk)
            // {
            //     m='Please select your bank from the list of banks.';
            //     displayMessage(m, 'error',Title,'error');                   
            //     $('#cboBank').focus(); return false;
            // }
            
            // //Your Account No
            // if (acno=='')
            // {
            //     m='Your account number field must not be blank.';                       
            //     displayMessage(m, 'error',Title,'error');
            //     $('#txtAccNo').focus(); return false;
            // }
            
            // if (!$.isNumeric(acno))
            // {
            //     m='Your account number MUST be a number. Current entry '+acno+' is not valid.';                      
            //     displayMessage(m, 'error',Title,'error');
            //     $('#txtAccNo').focus(); return false;
            // }
            
            // if (acno.length != 10)
            // {
            //     m='Please enter the correct account number. Valid account number must be 10 digits long (NUBAN).';                      
            //     displayMessage(m, 'error',Title,'error');
            //     $('#txtAccNo').focus(); return false;
            // }
            // //BVN
            // if (bvn=='')
            // {
            //     m='Your BVN field must not be blank.';                       
            //     displayMessage(m, 'error',Title,'error');
            //     $('#txtBvn').focus(); return false;
            // }
            
            // if (!$.isNumeric(bvn))
            // {
            //     m='Your BVN MUST be a number. Current entry '+bvn+' is not valid.';                      
            //     displayMessage(m, 'error',Title,'error');
            //     $('#txtBvn').focus(); return false;
            // }
            
            // if (bvn.length != 11)
            // {
            //     m='Please enter the correct account number. Valid Bank Verification must be 11 digits long.';                      
            //     displayMessage(m, 'error',Title,'error');
            //     $('#txtBvn').focus(); return false;
            // }
            
            //Email
            if (!em)
            {
                m='Email address field must not be blank.';
                displayMessage(m, 'error',Title,'error');
                return false;
            }               

            //Valid Email?
            if (!isEmail(em))
            {
                m='The email address entered '+em+' is invalid. Please check your entry.';                        
                displayMessage(m, 'error',Title,'error');
                return false;
            }
            
            //Phone                             
            if (!ph)
            {
                m="Phone number field must not be blank.";
                displayMessage(m, 'error',Title,'error');                   
                $('#txtPhone').focus(); return false;
            }
            
            if (!$.isNumeric(ph.replace('+','')))
            {
                m="Phone number field must be numeric. Please enter a valid phone number.";
                displayMessage(m, 'error',Title,'error');                   
                $('#txtPhone').focus(); return false;
            }

            //Pwd
            if (!$.trim(pwd))
            {
                m='Login password field must not be blank.';
                displayMessage(m, 'error',Title,'error');                   
                return false;
            }
            
            var v=IsValidPassword(pwd,em,8);

            console.log(v);
            
            if (v != 1)
            {
                displayMessage(v, 'error',Title,'error');                   
                return false;
            }               
            
            //Confirm Password
            if (pwd != cpw)
            {
                m='Login password and confirming password fields do not match.';
                displayMessage(m, 'error',Title,'error');                   
                return false;
            }
                        
            //Agree To Terms
            if ($.trim(chk)=='0')
            {
                m='You have to agree to Naija Art Market terms and condition before you can register.';             
                displayMessage(m, 'error',Title,'error');
                return false;
            }
            
            return true;
        }catch(e)
        {
            
            m='CheckRegister ERROR:\n'+e;                   
            displayMessage(m, 'error',Title,'error');
        }
    }

    function register() 
    {
        try
        {
            if (!CheckRegister()) return false;
            
            var investor =$.trim($('#cboUserType').val()).toLowerCase();           
            var issuer =$.trim($('#cboUserType1').val()).toLowerCase(); 
            var ut = type.toLowerCase();
                
            var nm=$.trim($('#txtUserName').val());         
            var em=$.trim($('#txtEmail').val());
            var ph=$.trim($('#txtPhone').val());
            // var bvn=$.trim($('#txtBvn').val());
            // var acnm=$.trim($('#txtAccName').val());
            // var acno=$.trim($('#txtAccNo').val());
            // var bnk=$.trim($('#cboBank').val());
            var mydata,url;
            
            if ((ut=='investor') || (ut=='both'))
            {
                // mydata={usertype:ut, name:nm, email:em, bvnNo:bvn,accNo:acno,accName:acnm,bank:bnk, phone:ph, pwd:AES256.encrypt($('#txtPwd').val(),'<?php echo ACCESS_STAMP; ?>')};
                mydata={usertype:ut, name:nm, email:em,phone:ph, pwd:AES256.encrypt($('#txtPwd').val(),'<?php echo ACCESS_STAMP; ?>')};
                    
                url="<?php echo site_url('ui/Signup/RegisterInvestor');?>";
            }else if (ut=='issuer')
            {
                url="<?php echo site_url('ui/Signup/RegisterIssuer');?>";
                
                // mydata={user_name:nm, email:em, bvnNo:bvn,accNo:acno,accName:acnm,bank:bnk, phone:ph, pwd:AES256.encrypt($('#txtPwd').val(),'<?php echo ACCESS_STAMP; ?>')};
                mydata={user_name:nm, email:em, phone:ph, pwd:AES256.encrypt($('#txtPwd').val(),'<?php echo ACCESS_STAMP; ?>')};
            }
            
            timedAlert('Signing up as an '+ut+', Please Wait....',2000,'','info');
            $.ajax({
                url: url,
                data: mydata,
                type: 'POST',
                dataType: 'json',
                success: function(data,status,xhr) {    
                    
                    
                    if ($(data).length > 0)
                    {                                                                                               
                        $.each($(data), function(i,e)
                        {
                            m=e.status;
                            
                            if ($.trim(e.Flag).toUpperCase() == 'OK')
                            {
                                $('#cboUserType').val('');
                                $('#txtUserName').val('');                              
                                $('#txtPhone').val('');
                                $('#txtEmail').val('');
                                $('#txtPwd').val('');
                                $('#txtConfirm').val('');
                                $("#chkAgree").prop("checked", false);
                                
                                displayMessage(m, 'success','Signup User','success');
                                window.location.href = "<?php echo site_url('ui/Login'); ?>"
                            }else
                            {
                                displayMessage(m, 'error',Title,'error');
                            }
                            
                            return;
                        });
                    }               
                },
                error:  function(xhr,status,error) {
                    
                    m='Error '+ xhr.status + ' Occurred: ' + error;
                    displayMessage(m, 'error',Title,'error');
                }
            });
            
        }catch(e)
        {
            
            m='Register Button Click ERROR:\n'+e;           
            displayMessage(m, 'error',Title,'error');
            return false;
        }
    };
    var currentTab = 0; // Current tab is set to be the first tab (0)

    function validateForm() {
      var x, y, i, valid = true;
      // x = document.getElementsByClassName("tab");
      // y = x[currentTab].getElementsByTagName("input");
      // for (i = 0; i < y.length; i++) {
      //   if (y[i].value == "") {
      //     y[i].className += " invalid";
      //     valid = false;
      //   }
      // }
      if (valid) {
        register();
      }
    }

    var Title='Naija Art Mart Help';
    var m='';
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
    
    });

</script>

</body>
</html>