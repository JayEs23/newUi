<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="https://www.naijaartmart.com/wp-content/uploads/favicon_artsquare_16x16.png">
  <link rel="icon" type="image/png" href="https://www.naijaartmart.com/wp-content/uploads/favicon_artsquare_16x16.png">

  <title> Naijaartmart | Login</title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />

  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

  <!-- CSS Files -->

  <link id="pagestyle" href="./assets/css/material-dashboard.css" rel="stylesheet" />
  </head>
  <body class="g-sidenav-show  bg-gray-100">
    <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://www.naijaartmart.com/assets/front/images/login-img.jpg');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg py-3 pe-1">
                  <center>
                    <img class="img-fluid align-items-center" src="https://www.naijaartmart.com/images/logo-120x120.png" style="max-height: 80px !important; align-content: center !important;">
 
                  </center>
                  <h5 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in</h5>
                </div>
              </div>
              <div id="divAlert"></div>
              <div class="card-body">
                <form role="form" class="text-start">
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control">
                  </div>
                  <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control">
                  </div>
                  <div class="d-flex align-items-right mb-3 text-sm text-right">
                      <a title="Click here to reset password" href="#" data-keyboard="false" data-backdrop="static" data-toggle="modal" data-target="#myModal"><small id="emailHelp" class="text-primary text-gradient font-weight-bold">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <button type="button"  class="btn btn-rounded w-100 mb-2" style="color: white !important;" onclick="alert('Signing In')">Sign in</button>
                  </div>
                  
                  <p class="mt-4 text-sm text-center">
                    Don't have an account?
                    <a href="/signup.php" class="text-info text-gradient font-weight-bold">Sign up</a>
                  </p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer position-absolute bottom-2 py-2 w-100">
        <?php include './footer.php'; ?>
      </footer>
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script>
    var Title='<font color="#AF4442">Naija Art Mart Help</font>';
    var m='';
    
    function DisplayMessage(msg,msgtype,msgtitle,theme='AlertTheme')
    {
      try
      {//SuccessTheme, AlertTheme
        $('#divAlert').html(msg).addClass(theme);
        
        
        Swal.fire({
            type: msgtype,
            title: '<strong>'+msgtitle+'</strong>',
            background: '#F3D3F2',
            color: '#f00',
            allowEscapeKey: false,
            allowOutsideClick: false,
            html: '<font size="3" face="Arial">'+msg+'</font>',
            showCloseButton: true,
            //footer: '<a href>Why do I have this issue?</a>'
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
    
    $(document).ready(function(e) {
          $(function() {      
        $.blockUI.defaults.css = {};// clear out plugin default styling
      });
    
      $(document).ajaxStop($.unblockUI);
      
      $(".toggle-password").click(function() 
      {
        $(this).toggleClass("fa-eye fa-eye-slash");
        
        var input = $($(this).attr("toggle"));
        
        if (input.attr("type") == "password") 
        {
          input.attr("type", "text");
        }else 
        {
          input.attr("type", "password");
        }
      });
      
      $("#myModal").on('show.bs.modal', function(){
        try
        {
          $.unblockUI();
        }catch(e)
        {
          $.unblockUI();
          m='Show Modal Event ERROR:\n'+e;      
          DisplayMessage(m, 'error',Title);
        }
        });
    
      $("#myModal").on('hidden.bs.modal', function(){
        try
        {
          $('#txtForgotEmail').val('');
        }catch(e)
        {
          $.unblockUI();
          m='Hide Modal Event ERROR:\n'+e;        
          DisplayMessage(m, 'error',Title);
        }
       });
       
      $('#btnLogin').click(function(e) {
              try
        {
          if (!CheckLogin()) return false;
          
          
        }catch(e)
        {
          $.unblockUI();
          m='Login Button Click ERROR:\n'+e;
          DisplayMessage(m, 'error',Title);
        }
      }); 
        
        
      $('#btnRequest').click(function(e) {
        try
        {
          var em=$.trim($('#txtForgotEmail').val());
          
          //Email
          if (!em)
          {
            m='Registered email field must not be blank.';
            DisplayMessage(m, 'error',Title);
            $('#txtForgotEmail').focus(); return false;
          }
          
          //Valid Email?
          //  /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
          var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-zA-Z]{2,4}$");
          if(!rx.test(em))
          {
            m='Invalid registered email.';          
            DisplayMessage(m, 'error',Title);         
            $('#txtForgotEmail').focus(); return false;
          }
          
          $.blockUI({message: '<img src="<?php echo $_SERVER['RE'];?>images/loader.gif" /><p>Requesting For Password Change. Please Wait...</p>',theme: false,baseZ: 2000});
          
          //Make Ajax Request
          var em=$.trim($('#txtForgotEmail').val());
                        
          var mydata={email:em};
              
          $.ajax({
            url: "<?php echo $_SERVER['SERVER_NAME'].'/'.'Signin/ForgotPwd';?>",
            data: mydata,
            type: 'POST',
            dataType: 'text',
            success: function(data,status,xhr) {  
              $.unblockUI();
                
              if ($.trim(data.toUpperCase())=='OK')
              {
                $('#txtForgotEmail').val('');
                        
                m='Password Reset Link Has Been Sent To <b>'+em+'</b>.';        
                DisplayMessage(m, 'success','Payment Added','SuccessTheme');
                $("#myModal").modal("hide");
              }else
              {
                m=data;
                alert(m);
                DisplayMessage(m, 'error',Title);
              }         
            },
            error:  function(xhr,status,error) {
              $.unblockUI();
              m='Error '+ xhr.data + ' Occurred: ' + error;       
              DisplayMessage(m, 'error',Title);
            }
          }); 
        }catch(e)
        {
          $.unblockUI();
          m='Request For Password Change Button Click ERROR:\n'+e;        
          DisplayMessage(m, 'error',Title);
          return false;
        }
      });
      
      function CheckLogin()
      {
        var m;        

        try
        {
          var em=$.trim($('#txtEmail').val());
          //var pwd=$('#txtPwd').val();
          
          //Email
          if (em.toLowerCase() != 'master')
          {
            if (!em)
            {
              m='Email field must not be blank.';
              DisplayMessage(m, 'error',Title);
              $('#txtEmail').focus(); return false;
            }       
    
            //Valid Email?
            //  /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
            var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-zA-Z]{2,4}$");
            if(!rx.test(em))
            {
              m='Invalid email address.';               
              DisplayMessage(m, 'error',Title);
              $('#txtEmail').focus(); return false;
            } 
          }
          
          //Password      
          if (!$.trim($('#txtPwd').val()))
          {
            m='Password field must not be blank.';
            DisplayMessage(m, 'error',Title);
            $('#txtPwd').focus(); return false;
          }
          
          var rt=false;
          
          //Check if user is at correct login
          $.ajax({
            url: "<?php echo $_SERVER['SERVER_NAME'].'/'.'admin/Signin/CheckLogin';?>",
            data: {email:em},
            type: 'POST',
            dataType: 'text',
            success: function(data,status,xhr) {
              $.unblockUI();
              
              var ret=$.trim(data.toLowerCase());
              
              if ((ret=='operator') || (ret=='gallery') || (ret=='admin'))
              {                       
                Swal.fire({
                  title: 'LOGIN',
                  html: "<font size='3' face='Arial'>You are at the wrong login screen. You will now be redirected to the correct login screen where you will enter your login details to log in.</font>",
                  type: 'info',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: '<font size="3" face="Arial">OK</font>'
                }).then((result) => {
                  window.location.href='<?php echo $_SERVER['SERVER_NAME'].'/'."admin/Signin";?>';
                })
              }else
              {
                Login(ret);
              }         
            },
            error:  function(xhr,status,error) {
              $.unblockUI();
              m='Error '+ xhr.status + ' Occurred: ' + error;
              DisplayMessage(m,'error',Title);
            }
          });   
          
          //return rt;
        }catch(e)
        {
          $.unblockUI();
          m='CheckLogin ERROR:\n'+e;          
          DisplayMessage(m, 'error',Title);
        }
      }
      
      function Login(ut)
      {
        try
        {
          //Make Ajax Request
          var em=$.trim($('#txtEmail').val());        
          var mydata={email:em, pwd:AES256.encrypt($('#txtPwd').val(),'<?php echo ACCESS_STAMP; ?>')};
          
          $.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Signing In. Please Wait...</p>',theme: false,baseZ: 2000});


          if (ut=='broker')
            {
              window.location.href='<?php echo $_SERVER['SERVER_NAME'].'/'."ui/Dashboard"; ?>';
            }else if ((ut=='issuer') || (ut=='investor'))//(ut=='investor/issuer') or
            {
              window.location.href='<?php echo $_SERVER['SERVER_NAME'].'/'."ui/Dashboardiv"; ?>';
            }

          $.ajax({
            url: "<?php echo $_SERVER['SERVER_NAME'].'/'.'ui/Login/UserLogin';?>",
            data: mydata,
            type: 'POST',
            dataType: 'json',
            success: function(data,status,xhr) {
              $.unblockUI();
              
              var sta='';
              
              if ($(data).length > 0)
              {
                $.each($(data), function(i,e)
                {
                  sta=e.status;
    
                  if ($.trim(sta).toUpperCase()=='OK')
                  {
                    if (ut=='broker')
                    {
                      window.location.href='<?php echo $_SERVER['SERVER_NAME'].'/'."ui/Dashboard"; ?>';
                    }else if ((ut=='issuer') || (ut=='investor'))//(ut=='investor/issuer') or
                    {
                      window.location.href='<?php echo $_SERVER['SERVER_NAME'].'/'."ui/Dashboardiv"; ?>';
                    }                 
                  }else
                  {
                    m=e.msg;
                    DisplayMessage(m, 'error',Title);
                  }
                  
                  return;
                });//End each
              }else
              {
                $.unblockUI();    
                m='Login Failed.';
                DisplayMessage(m, 'error',Title);
              } 
            },
            error:  function(xhr,status,error) {
              $.unblockUI();
              m='Error '+ xhr.status + ' Occurred: ' + error;
              DisplayMessage(m, 'error',Title);
            }
          });
        }catch(e)
        {
          $.unblockUI();
          m='Login ERROR:\n'+e;         
          DisplayMessage(m, 'error',Title);
        }
      }
      
      function Login_bak(ut)
      {
        try
        {
          //Make Ajax Request
          var em=$.trim($('#txtEmail').val());        
          var mydata={email:em, pwd:AES256.encrypt($('#txtPwd').val(),'<?php echo ACCESS_STAMP; ?>')};
          
          $.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Signing In. Please Wait...</p>',theme: false,baseZ: 2000});

          $.ajax({
            url: "<?php echo $_SERVER['SERVER_NAME'].'/'.'ui/Login/UserLogin';?>",
            data: mydata,
            type: 'POST',
            dataType: 'json',
            success: function(data,status,xhr) {
              $.unblockUI();
              
              var sta='';
              
              if ($(data).length > 0)
              {
                $.each($(data), function(i,e)
                {
                  sta=e.status;
    
                  if ($.trim(sta).toUpperCase()=='OK')
                  {
                    if (ut=='broker')
                    {
                      window.location.href='<?php echo $_SERVER['SERVER_NAME'].'/'."Dashboard"; ?>';
                    }else if (ut=='investor')
                    {
                      window.location.href='<?php echo $_SERVER['SERVER_NAME'].'/'."Investor/Dashboard"; ?>';
                    }
                    else if (ut=='issuer')
                    {
                      window.location.href='<?php echo $_SERVER['SERVER_NAME'].'/'."Issuer/Dashboard"; ?>';
                    }                  
                  }else
                  {
                    m=e.msg;
                    DisplayMessage(m, 'error',Title);
                  }
                  
                  return;
                });//End each
              }else
              {
                $.unblockUI();    
                m='Login Failed.';
                DisplayMessage(m, 'error',Title);
              } 
            },
            error:  function(xhr,status,error) {
              $.unblockUI();
              m='Error '+ xhr.status + ' Occurred: ' + error;
              DisplayMessage(m, 'error',Title);
            }
          });
        }catch(e)
        {
          $.unblockUI();
          m='Login ERROR:\n'+e;         
          DisplayMessage(m, 'error',Title);
        }
      }
      });
  </script>

  <script src="../assets/js/material-dashboard.min.js?v=3.0.4"></script>
</body>
<!--Reset Password-->
    <div class="col-md-12">
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
        <h4 class="modal-title">Request For Password Change</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              
              <div class="modal-body">
                <form class="form-horizontal">
                    <!--Email-->
                        <div title="Enter your registered email" class="form-group">
                            <div class="col-sm-12">
                                <input id="txtForgotEmail" type="text" class="form-control" placeholder="Enter Your Registered Email">
                            </div>
                       </div>
                       
                       <div align="center" style="margin-top:-10px;" id="divModalAlert"></div>
                </form>
              
                 
              </div>
              
              <div class="modal-footer">
                <div class="form-group">
                                      
                    <div class="col-sm-12 ">
                        <button id="btnRequest" type="button" class="btn btn-info">Submit Request</button>
                      <button id="btnCloseModal" type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
                    </div>
                           
                </div>
                
              </div>
            </div>
            
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>

</html>





































































<script>
  var win = navigator.platform.indexOf('Win') > -1;
  if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
      damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
  }
</script>

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>


<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc --><script src="./assets/js/material-dashboard.min.js?v=3.0.4"></script>
  </body>

</html>
