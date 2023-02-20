<?php 
session_start();

if(!isset($_SESSION['user'])){
  //header("Location:login.php");
}
?>

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
                  <h5 class="text-white font-weight-bolder text-center mt-2 mb-0">Welcome</h5>
                </div>
              </div>
              <div id="divAlert"></div>
              <div class="card-body">
                
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
