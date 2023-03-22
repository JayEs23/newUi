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
    <title> Derived Homes | <?php echo $userType; ?> Primary Trade History</title>
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
    
    <div class="explore-artwork" style="padding-top: 12px !important;">
      <div class="container-fluid" style="padding-top: 20px !important;">
        <div class="explore-artwork-inr">
          <div class="heading-otr">
            <div class="head-otr">
                <h3 class="heading heading-h3">Primary Trade History</h3>
            </div>
          </div>
          <div class="teb-main">
            <div class="tab-otr">
              <div class="tab-inr">
                <ul class="tabs">
                  <li class="tab-link tab-1 active" data-tab="1">
                    <p class="tab-p body-sb">Trade History</p>
                  </li>
                  <li class="tab-link tab-2 " data-tab="2">
                    <p class="tab-p body-sb">News</p>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <span class="line"></span>
          <div class="row row-custom-main">
            	<div id="tab-1" class="tab-content active">
                <div style="padding: 12px;padding-top: 50px;box-shadow: 2px 6px 6px 6px lightgrey;border-radius: 12px; margin: 12px;">
         			      <div class="position-relative row form-group">
                       <!--Start Date--> 
                      <label title="Start Date" for="txtTradeStartDate" class="col-sm-1 col-form-label text-right">Start Date</label>
                  
                        <div title="Start Date" class="col-sm-2 date tradedatepicker">
                          <div class="input-group">
                              <input style="color:darkgray; cursor:default;" readonly class="form-control" type="text" id="txtTradeStartDate" placeholder="Trade Start Date">
                              
                              <span class="input-group-btn"><button class="btn btn-info" type="button"><i class="fa fa-calendar size-18"></i></button></span>
                          </div>
                        </div>
                       
                        <!--End Date--> 
                        <label title="End Date" for="txtTradeEndDate" class="col-sm-2 col-form-label text-right">End Date</label>
                  
                      <div title="End Date" class="col-sm-2 date tradedatepicker">
                        <div class="input-group">
                          <input style="color:darkgray; cursor:default;" readonly class="form-control" type="text" id="txtTradeEndDate" placeholder="Trade End Date">
                          
                          <span class="input-group-btn">
                            <button class="btn btn-info" type="button"><i class="fa fa-calendar size-18"></i></button>
                          </span>
                        </div>
                          
                      </div>
                       
                       <!--Display Trade-->
                       <div title="Click to display trades" class="col-sm-1">
                       	<button id="btnDisplayTrades" type="button" class="btn btn-outline1 btn-sm">Search</button>
                       </div>
                    </div>
                  
                	 <table class="hover table table-bordered data-table display wrap" id="tabTrades">
                    <thead>
                      <tr >
                          <th style="text-align:center" width="15%">Date</th>
                          <th style="text-align:center" width="13%">ID</th>
                          <th style="text-align:center" width="11%">Asset</th> 
                          <th style="text-align:center" width="11%">Tokens</th>
                          <th style="text-align:right; padding-right:7px;" width="10%">Price</th>
                          <th style="text-align:right; padding-right:7px;" width="14%">Amount</th>
                          <th style="text-align:center" width="13%">Seller</th>
                          <th style="text-align:center" width="13%">Buyer</th>
                      </tr>
                    </thead>

                    <tbody id="tbtradebody"></tbody>
                    
                  	<tfoot style="color:#ffffff; background-color:#7E7B7B;">
                            <tr>
                                <th colspan="5" style="text-align:right; padding:3px; padding-right:10px; font-weight:bold; font-size:13px;" width="54%">Total Trade Amount (₦):</th>
                                
                                <th id="tdAmount" style="text-align:right; padding:3px; padding-right:8px; font-weight:bold; font-size:12px;" width="14%"></th>
                                
                                 <th colspan="2" id="tdAmount" style="text-align:right; padding:3px; padding-right:8px; font-weight:bold; font-size:12px;" width="26%"></th>
                            </tr>
                      </tfoot>
                   </table>
        		  
            	   </div>
  	           <div id="tab-2" class="tab-content ">
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
<!--     <script src="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progress.js"></script>
-->    <script src="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/js/app.js"></script>
  <script src="https://js.paystack.co/v1/inline.js"></script>
  <script src="<?php echo base_url();?>assets/js/datatables.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/chartist/js/chartist.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/klorofil-common.js"></script>
  <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/aes256.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/datatables.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script src="<?php echo base_url();?>assets/js/aes256.min.js"></script>
<script src="<?php echo base_url();?>assets/js/sum().js"></script>
<script src="<?php echo base_url();?>assets/js/general.js"></script>

<script>
	var Title='Derived Homes Help';
	var m='';
	var tablenews,tabletrade;
	var Email='<?php echo $email; ?>';
	var Uid='<?php echo $issuer_id; ?>';
	var Usertype='<?php echo $usertype; ?>';
	var Issuername='<?php echo $issuer_name; ?>';
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


	$(document).ready(function(e) {
		
		
		$('[data-toggle="tooltip"]').tooltip();
		
		setInterval(function(){
			LoadPrimaryMarket();
		}, (RefreshInterval));

		
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
		
		LoadMessages();
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
				$.ajax({
					url: "<?php echo site_url('ui/Primarytradehistory/GetTrades');?>",
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
		
		function LoadMessages()
		{
			try
			{
				timedAlert("Loading Messages, Please Wait...",2000,'','info');
				
				$('#tabNews > tbody').html('');
				
				var tw=$('#news').width();
				var det_cell=tw * 0.45;
				var head_cell=tw * 0.38;
				
				$.ajax({
					url: '<?php echo site_url('ui/Primarytradehistory/LoadMessages'); ?>',
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

		function LoadPrimaryMarket()
		{
			try
			{
				timedAlert('Loading Market Data. Please Wait...',2000,'','info');
				
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
				$.unblockUI();
				m='LoadPrimaryMarket ERROR:\n'+e;
				displayMessage(m,'error',Title,'error');
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
		
    });//End document ready
	

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
	</script>
</body>
</html>