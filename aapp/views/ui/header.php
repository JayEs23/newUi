<link rel="stylesheet" href="https://www.naijaartmart.com/ethoz/newassets/vendor/chartist/css/chartist-custom.css">
<link rel="stylesheet" href="https://www.naijaartmart.com/ethoz/newassets/css/bootstrap-datepicker3.min.css" >
<script src="https://www.naijaartmart.com/ethoz/newassets/js/klorofil-common.js"></script>
<script src="https://www.naijaartmart.com/ethoz/newassets/js/bootstrap-datepicker.min.js"></script>
<script src="https://www.naijaartmart.com/ethoz/newassets/js/moment.min.js"></script>
<script src="https://www.naijaartmart.com/ethoz/newassets/js/general.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
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
		  showConfirmButton: false
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
</script>
<div class="horizontal-menu">
    <nav class="navbar top-navbar col-lg-12 col-12 p-0">
      <div class="container-fluid">
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
          <ul class="navbar-nav navbar-nav-left">
            <li class="nav-item ms-0 me-5 d-lg-flex d-none">
              <a href="#" class="nav-link horizontal-nav-left-menu"><i class="mdi mdi-format-list-bulleted"></i></a>
            </li>              
          </ul>
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
              <a class="navbar-brand brand-logo" href="<?php echo site_url('ui/Home');?>"><img src="<?php echo base_url(); ?>newassets/img/naija_art_mart1.png" style="min-height: 70px !important" alt="logo"/></a>
              <a class="navbar-brand brand-logo-mini" href="index.html"><img src="<?php echo base_url(); ?>assets/img/naija_art_mart1.png" style="min-height: 70px !important" alt="logo"/></a>
          </div>
          <ul class="navbar-nav navbar-nav-right">
			<li class="nav-item dropdown  d-lg-flex d-none text-info">Market Status  &nbsp;
				<span id="spnClientMarketStatus"><?php if (trim(strtoupper($_SESSION['MarketStatus'])) == 'OPENED') echo '<font color="#82E99B">'.$_SESSION['MarketStatus'].'</font>'; else echo '<font color="#FF5858">'.$_SESSION['MarketStatus'].'</font>'; ?></span>
          	<!-- <?php if (trim(strtoupper($_SESSION['MarketStatus'])) == 'OPEN') { ?>
                <button type="button" class="btn btn-inverse-success btn-sm">
                	<?php echo $_SESSION['MarketStatus']; ?></button>
          	<?php
          	}else{?>
          		<button type="button" class="btn btn-inverse-danger btn-sm"><?php echo $_SESSION['MarketStatus']; ?></button>
          	<?php }?> -->
          </li>
              
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                  <span class="nav-profile-name"><?php echo strtoupper($usertype) ?></span>
                  <span class="online-status"></span>
                  <img src="<?php echo base_url(); ?>assets/img/avatar1.png" alt="profile"/>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a href="<?php if (strtolower(trim($usertype))=='broker') echo site_url('ui/Userprofile'); else echo site_url('ui/Userprofileiv'); ?>" class="dropdown-item">
                      <i class="mdi mdi-account-settings text-primary"></i>
                      Profile
                    </a>
                    <a href="<?php echo site_url('ui/Changepassword');?>" class="dropdown-item">
                      <i class="mdi mdi-account-key text-primary"></i>
                      Change Password
                    </a>
                    <a onClick="LogOut();" href="#"class="dropdown-item">
                      <i class="mdi mdi-logout text-primary"></i>
                      Logout
                    </a>
                </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </div>
    </nav>
    <nav class="bottom-navbar">
      <div class="container">
          <ul class="nav page-navigation">
            <li class="nav-item">
            <?php 
            if (trim(strtolower($usertype))=='broker'){
            ?>
              <a class="nav-link" href="<?php echo site_url('ui/Dashboardiv') ?>">
             <?php }elseif ((trim(strtolower($usertype))=='issuer') or (trim(strtolower($usertype))=='investor')){ ?>
              <a class="nav-link" href="<?php echo site_url('ui/Dashboard') ?>">
              	<?php } ?>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('ui/Directinvestorprymarket') ?>">Primary Market</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('ui/Directinvestorsecmarket') ?>">Secondary Market</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo site_url('ui/Portfolio') ?>" class="nav-link">
                  <span class="menu-title">PortFolio</span>
                  <i class="menu-arrow"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo site_url('ui/Messages') ?>" class="nav-link">
                  <span class="menu-title">Messages</span>
                  <i class="menu-arrow"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo site_url('ui/Wallet') ?>" class="nav-link">
                  <span class="menu-title">Wallet</span>
                  <i class="menu-arrow"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                  <span class="menu-title">Reports</span>
                  <i class="menu-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link" href="<?php echo site_url('ui/Ordersrep_in') ?>">Trade Orders</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo site_url('ui/Primarytradesrep_in') ?>">Primary Trades</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo site_url('ui/Secondarytradesrep_in') ?>">Secondary Trades</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo site_url('ui/Portfoliorep_in') ?>">PortFolio</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo site_url('ui/Requestsrep_in') ?>">Buy/Sell Requests</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo site_url('ui/Depositsrep_in') ?>">Deposits</a></li>
                    </ul>
                </div>
            </li>
          </ul>
      </div>
    </nav>
  </div>



