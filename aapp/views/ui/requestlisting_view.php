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
    <link rel="icon" href="https://www.naijaartmart.com/assets/images/d_favicon.png" sizes="16x16">
    <title> Derived Homes | <?php echo $userType; ?> Listings</title>
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
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker3.min.css" >

    <style>
        .modal-content {
          background-color: #fefefe;
          margin: 10% auto; /* 15% from the top and centered */
          padding: 10px;
          border: 1px solid #888;/*888*/
          position: relative;
          margin-top:30px;
          width: 100%; /* Could be more or less, depending on screen size */
        }

        
        /* The Close Button */
        .close {
          /*color: #fefefe;*/
          float: right;
          font-size: 28px;
          font-weight: bold;
        }
        
        .close:hover,
        .close:focus {
          color: yellow;
          text-decoration: none;
          cursor: pointer;
        }
            
    </style>
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
            padding: 20px !important;
            font-weight: bold;
            font-family: sans-serif;
            color: gray;
            vertical-align: middle;
            text-align: left;
            font-size: 18px;
        }
        .form-control {
            display: block;
            width: 100%;
            padding: .385rem .90rem !important;
            font-size: 1.2rem !important;
            font-weight: 400;
            margin: 10px !important;
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
            padding: 20px !important;
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
        .img-thumbnail {
            padding: .75rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
            min-width: 100%;
            height: 270px !important;
            background-size: contain !important;
        }
    </style>
</head>
<body>
	<div id="myNav" class="overlay-content-otr">
          <?php
            include 'mobNav.php';

            ?>
        </div>
  <section class="hero-navbar-9">
      <?php
      include 'nav.php';
      ?>
    <div class="explore-artwork" style="padding: 26px 0 28px 0;">
        <div class="container-fluid">
            <div class="explore-artwork-inr">
                <div class="heading-otr">
                    <div class="head-otr">
                        <h3 class="heading heading-h3">Listings</h3>
                    </div>
                </div>
                <div class="teb-main">
                    <div class="tab-otr">
                        <div class="tab-inr">
                            <ul class="tabs">
                                <li class="tab-link tab-1 active" data-tab="1">
                                    <p class="tab-p body-sb">All</p>
                                </li>
                                <li class="tab-link tab-2" data-tab="2">
                                    <p class="tab-p body-sb">Request Form</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <span class="line"></span>
                <div class="row row-custom-main">
                    <div id="tab-1" class="tab-content active">
                        <div class="row row-custom-inr">
                            <!--View Listing Tab-->
                            <div id="view" style="padding:0; display:block !important;">
                                <table class="hover table table-bordered data-table display wrap" id="recorddisplay">
                                  <thead>
                                    <tr>
                                        <th style="text-align:center" width="10%">PICTURE</th>
                                        <th style="text-align:center" width="21%">PROPERTY TITLE</th>
                                        <th style="text-align:right" width="10%">VALUE</th> 
                                        <th style="text-align:center" width="10%">TOKENS</th>
                                        <th style="text-align:right" width="10%">PRICE/TOKEN</th>
                                        <th style="text-align:center" width="11%">LISTING&nbsp;STARTS</th>
                                        <th style="text-align:center" width="11%">LISTING&nbsp;ENDS</th>
                                        <th style="text-align:center" width="13%">STATUS</th>
                                        <th style="text-align:center" width="4%"></th>
                                    </tr>
                                  </thead>
        
                                  <tbody id="tbbody"></tbody>
                                </table>
                           </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-content">
                        <div class="row row-custom-inr">
                            <div id="data">
                                <div class="card mb-4">
                    <form>
                        <div class="card-header">Listing Information</div>
                        <div class="card-body">
                                    
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (last name)-->
                                <div class="col-md-3">
                                    <label class="small mb-1" for="txtArtist">Listing Agent Name *</label>
                                    <input class="form-control" id="txtArtist" type="text" placeholder="Name of Agent">
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-3">
                                    <label class="small mb-1" for="txtCreationYear">Creation Year *</label>
                                    <input class="form-control" id="txtCreationYear"  type="text" placeholder="" >
                                </div>
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" title="Title of work" for="txtTitle">Listing Title *</label>
                                    <input class="form-control"  type="text" id="txtTitle" placeholder="Title of Listing" >
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="small mb-1" for="txtLocation">Display Location *</label>
                                    <input class="form-control" id="txtLocation" type="text" placeholder="Listing Display Location" >
                                </div>
                                <!-- Form Group (birthday)-->
                                <div class="col-md-3">
                                    <label class="small mb-1" for="txtDimension">Listing Dimensions</label>
                                    <input class="form-control" type="text" id="txtDimension" placeholder="Listing Dimensions">
                                </div>
                                <!-- Form Group (location)-->
                                <div class="col-md-3">
                                    <label class="small mb-1" for="txtValue">Listing Value(₦)</label>
                                    <input class="form-control" type="text" id="txtValue" placeholder="Listing's Value">
                                </div>
                                <!-- Form Group (organization name)-->
                                <div class="col-md-3">
                                    <label class="small mb-1" for="txtDocument">Listing Document Document</label>
                                     <input accept=".pdf" title="Upload Art Document" type="file" id="txtDocument" class="input-file" placeholder="Upload Listing Document" style="padding: 12px;" />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="txtDocument">Listing Description</label>
                                    <textarea rows="3" id="txtDescription" placeholder="Listing Description" class="form-control"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="txtDocument">Listing Materials</label>
                                    <textarea rows="3" id="txtMaterials" placeholder="Listing's Materials" class="form-control"></textarea>
                                </div>
                                <div class="col-md-3">
                                    <label class="small mb-1" for="txtTokens">No Of Tokens</label>
                                    <input min="0" type="text" class="form-control" placeholder="No Of Tokens" id="txtTokens">
                                </div>
                                <div class="col-md-3">
                                    <label class="small mb-1" for="txtTokenPrice">Price Per Token (₦) *</label>
                                    <input min="0" type="text" id="txtTokenPrice" placeholder="Price Per Token" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="small mb-1" for="txtPercentTokens">Tokens For Sale (%)</label>
                                    <input min="0" max="100" type="text" class="form-control" placeholder="Percentage Of Tokens For Sale" id="txtPercentTokens">
                                </div>
                                <div class="col-md-3">
                                    <label class="small mb-1" for="txtTokensForSale">Tokens For Sale</label>
                                    <input style="background:#ffffff; cursor:default;" readonly type="text" id="txtTokensForSale" placeholder="Tokens For Sale" class="form-control">
                                </div>

                                 
                                
                               
                            </div>
                            <!-- Form Group (email address)-->
                                  
                        </div>
                        <div class="card-header">Listing Media</div>
                        <div class="card-body">
                            <div class="row gx-3 mb-3">
                                <div class="col-md-3">
                                    <label title="Upload Listing Image number one (jpg or png format)" for="txtPix1" class="small mb-1">Listing Image 1
                                        <span class="redtext">*</span>
                                    </label>
                                    <img class="rounded img-thumbnail" id="imgPix1" onclick="LoadPix('imgPix1','1');" style="height:200px; margin-top:10px; border:solid 1px inherit;" />
                                            
                                    <input accept="image/jpg, .jpg" type="file" id="txtPix1" class="input-file" placeholder="Listing Image 1" onchange="GetPix(this,'1');" />
                                               
                                </div>
                                <div class="col-md-3">
                                    <label title="Upload Listing Image number one (jpg or png format)" for="txtPix2" class="small mb-1">Listing Image 2
                                    </label>
                                    <img class="rounded img-thumbnail" id="imgPix2" onclick="LoadPix('imgPix2','2');" style="height:200px; margin-top:10px; border:solid 1px inherit;" />
                                            
                                    <input accept="image/jpg, .jpg" type="file" id="txtPix2" class="input-file" placeholder="Listing Image 2" onchange="GetPix(this,'2');" />
                                               
                                </div>
                                <div class="col-md-3">
                                    <label title="Upload Listing Image number one (jpg or png format)" for="txtPix3" class="small mb-1">Listing Image 3
                                        <span class="redtext">*</span>
                                    </label>
                                    <img class="rounded img-thumbnail" id="imgPix3" onclick="LoadPix('imgPix3','3');" style="height:200px; margin-top:10px; border:solid 1px inherit;" />
                                            
                                    <input accept="image/jpg, .jpg" type="file" id="txtPix3" class="input-file" placeholder="Listing Image 3" onchange="GetPix(this,'3');" />
                                               
                                </div>
                                <div class="col-md-3">
                                    <label title="Upload Listing Image number one (jpg or png format)" for="txtPix4" class="small mb-1">Listing Image 4
                                        <span class="redtext">*</span>
                                    </label>
                                    <img class="rounded img-thumbnail" id="imgPix4" onclick="LoadPix('imgPix4','4');" style="height:200px; margin-top:10px; border:solid 1px inherit;" />
                                            
                                    <input accept="image/jpg, .jpg" type="file" id="txtPix4" class="input-file" placeholder="Listing Image 4" onchange="GetPix(this,'4');" />
                                               
                                </div>
                                <div class="col-md-6" style="display:none;">
                                    <input type="hidden" id="hidArtId" />
                                    <input type="hidden" id="hidId" />
                                    <label title="Artwork Symbol" for="txtSymbol" class="small mb-1">Artwork Symbol
                                    <input style="background:#ffffff; cursor:default;" readonly id="txtSymbol" placeholder="Artwork symbol" type="text" class="form-control">

                                            <!--Listing Status-->
                                            <label title="Listing Status" for="txtListingStatus" class="col-sm-2 profile_input text-right">Listing Status</label>
                                             
                                             <div title="Listing Status" class="col-sm-4">
                                                <input style="background:#ffffff; color:#ff0000; cursor:default;" readonly class="form-control" type="text" id="txtListingStatus" placeholder="Listing Status">                                               
                                             </div>
                                         </div>
                                </div>
                                        
                                                             
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-5"></div>
                                <div class="col-md-7 row">
                                    <div class="col-md-4">
                                        <button id="btnAdd" type="button" class="btn btn-primary btn-lg text-white">Request Listing</button>
                                    </div>
                                    <div class="col-md-4">
                                        <button id="btnEdit" type="button" class="btn btn-primary btn-lg text-white">Edit Listing</button>
                                    </div>
                                    <div class="col-md-4">
                                        <button onClick="window.location.reload(true);" type="button" class="btn btn-lg btn-danger">Refresh</button>
                                    </div>
                                    
                                                                    
                                                                    
                                    
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </div>
                            
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

  <!-- <script src="<?php echo base_url(); ?>/newassets/libs/jquery/dist/jquery.min.js"></script> -->  
  <script src="<?php echo base_url();?>assets/js/jquery.3.4.1.min.js"></script>

  <script src="<?php echo base_url(); ?>/newassets/libs/jquery.countdown/jquery.countdown.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/libs/tilt.js/dest/tilt.jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/libs/progress.js-master/src/progress.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>/newassets/js/app.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/chartist/js/chartist.min.js"></script>
<script src="<?php echo base_url();?>assets/js/klorofil-common.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/js/general.js"></script>
<script src="<?php echo base_url();?>assets/js/loader.js"></script>
<script src="<?php echo base_url();?>assets/js/s8.min.js"></script>
<script src="<?php echo base_url();?>assets/js/aes256.min.js"></script>
<script src="<?php echo base_url();?>assets/js/sum().js"></script>
<script src="<?php echo base_url();?>assets/js/back.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.redirect.js"></script>
<script src="<?php echo base_url();?>assets/js/pdf.js"></script>
<script src="https://cdn.tiny.cloud/1/0drkx3ls1u5dm98dftetsvhgco3h7u5lhopv6db67rijvzec/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="<?php echo base_url();?>assets/js/marquee.js"></script>
<script>
    tinymce.init({
        selector: 'textarea#txtDescription',
    });

    tinymce.init({
        selector: 'textarea#txtMaterials',
    });
</script>


  <script>
    var Title='Derived Homes Help';
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
  
    
  </script>
  <script>
		var Title='Derived Homes Help';
		var m='';
		var Email='<?php echo $email; ?>';
		var emptypix='<?php echo base_url(); ?>images/empty.jpg';		
		var pixfile1=null,pixfile2=null,pixfile3=null,pixfile4=null;
		var pdffile=null,table;
		var selFiles = [];
		
		const PDF_TYPE = "application/pdf";
		//const TXT_TYPE = "text/plain";
		
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("closepix")[0];
		
		function DisplayMessage(msg,msgtype,msgtitle,theme='AlertTheme')
		{
			try
			{//SuccessTheme, AlertTheme
				$('#divAlert').html(msg).addClass(theme);
				
				
				swal({
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
			
	
			
			// document.getElementById('btnEdit').disabled=true;
			document.getElementById('btnAdd').disabled=false;
						
			document.getElementById('txtDocument').addEventListener('change', handleFileSelect, false);
			
			$('.datepicker').datepicker({
				weekStart: 1,
				todayBtn:  "linked",
				autoclose: 1,
				todayHighlight: 1,
				minViewMode: 2,
				clearBtn: 1,
				forceParse: 0,
				daysOfWeekHighlighted: "0,6",
				//daysOfWeekDisabled: "0,6",
				format: 'yyyy'
			});			

			$('#txtCreationYear').datepicker({
				weekStart: 1,
				todayBtn:  "linked",
				autoclose: 1,
				todayHighlight: 1,
				minViewMode: 2,
				clearBtn: 1,
				forceParse: 0,
				daysOfWeekHighlighted: "0,6",
				//daysOfWeekDisabled: "0,6",
				format: 'yyyy'
			});
			
			$('#imgPix1').prop('src',emptypix);	$('#imgPix2').prop('src',emptypix);
			$('#imgPix3').prop('src',emptypix);	$('#imgPix4').prop('src',emptypix);
			
			LoadListings();
			
			$('#btnAdd').click(function(e) {
				try
				{
					$('#divAlert').html('');
					if (!CheckRequest()) return false;				
				}catch(e)
				{

					m='Update Profile Button Clicked ERROR:\n'+e;				
					displayMessage(m,'error',Title,'error');
					return false;
				}
			});//btnAdd Click Ends
			
			$('#btnEdit').click(function(e) {
				try
				{					
					$('#divAlert').html('');
					
					if (!CheckEdit()) return false;
				}catch(e)
				{

					m='Edit Request Button Click ERROR:\n'+e;					
					displayMessage(m,'error',Title,'error');
				}
			});//btnEdit Click Ends..
			
			function CheckEdit()
			{
				try
				{
					var nm=$.trim($('#txtArtist').val());
					var dt=$.trim($('#txtCreationYear').val());	
					var tit=$.trim($('#txtTitle').val());
					var des=$.trim(tinymce.get("txtDescription").getContent());					
					var mat=$.trim(tinymce.get("txtMaterials").getContent());				
					var dim=$.trim($('#txtDimension').val());
					var loc=$.trim($('#txtLocation').val());
					
					var px1=$.trim($('#txtPix1').val());
					var px2=$.trim($('#txtPix2').val());
					var px3=$.trim($('#txtPix3').val());
					var px4=$.trim($('#txtPix4').val());
					
					var doc=$.trim($('#txtDocument').val());
					
					var val=$.trim($('#txtValue').val()).replace(new RegExp(',', 'g'), '');
					var tok=$.trim($('#txtTokens').val()).replace(new RegExp(',', 'g'), '');
					var pr=$.trim($('#txtTokenPrice').val()).replace(new RegExp(',', 'g'), '');
					var sale=$.trim($('#txtTokensForSale').val()).replace(new RegExp(',', 'g'), '');
					var per=$.trim($('#txtPercentTokens').val()).replace(new RegExp(',', 'g'), '');
					var id=$.trim($('#hidId').val());
					var aid=$.trim($('#hidArtId').val());
										
					//User Email
					if (!Email)
					{
						m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the editing.';						
	
						displayMessage(m,'error',Title,'error');				
	
						return false;
					}
					
					//Artist Name								
					if (!nm)
					{
						m='Artist name field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
							
					}
					
					if ($.isNumeric(nm))
					{
						m='Artist name field must not be a number.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					if (nm.length<2)
					{
						m='Artist name must be in full.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					//Creation year
					if (!dt)
					{
						m='Artwork creation year field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
							
					}
					
					//Art Title
					if (!tit)
					{
						m='Artwork title field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
								
					}
					
					if ($.isNumeric(tit))
					{
						m='Artwork title field must not be a number.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					if (tit.length<2)
					{
						m='Artwork title must be in full.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					//Description
					if (!des)
					{
						m='Artwork description field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
								
					}
					
					if ($.isNumeric(des))
					{
						m='Artwork description field must not be a number.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					if (des.length<2)
					{
						m='Please type a meaninful artwork description.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					//Material
					if (!mat)
					{
						m='Artwork materials field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
								
					}
					
					if ($.isNumeric(mat))
					{
						m='Artwork materials field must not be a number.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					if (mat.length<2)
					{
						m='Please type a meaninful artwork materials.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					//Dimensions
					if (!dim)
					{
						m='Artwork dimensions field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
								
					}
					
					if ($.isNumeric(dim))
					{
						m='Artwork dimensions field must not be a number.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					if (dim.length<2)
					{
						m='Please type a meaninful artwork dimensions.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					//Display location
					if (!loc)
					{
						m='Artwork display location field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
								
					}
					
					if ($.isNumeric(loc))
					{
						m='Artwork display location field must not be a number.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					if (loc.length<2)
					{
						m='Please type a meaninful artwork display location.';					
						displayMessage(m,'error',Title,'error');					
						
					}				
					
					//Artwork Value
					if (!val)
					{
						m='Artwork value field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
						UiActivateTab('listing'); return false;		
					}
					
					if (!$.isNumeric(val))
					{
						m='Artwork value field must be a number.';					
						displayMessage(m,'error',Title,'error');					
						UiActivateTab('listing'); return false;
					}
					
					if (parseFloat(val) == 0)
					{
						m='Artwork value must not be zero.';				
						displayMessage(m,'error',Title,'error');
						UiActivateTab('listing'); return false;
					}
					
					if (parseFloat(val) < 0)
					{
						m='Artwork value must not be a negative number.';				
						displayMessage(m,'error',Title,'error');
						UiActivateTab('listing'); return false;
					}
					
					//Tokens
					if (!tok)
					{
						m='Number of artwork tokens field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
						UiActivateTab('listing'); return false;		
					}
					
					if (!$.isNumeric(tok))
					{
						m='Number of artwork tokens field must be a number.';					
						displayMessage(m,'error',Title,'error');					
						UiActivateTab('listing'); return false;
					}
					
					if (parseInt(tok) == 0)
					{
						m='Number of artwork tokens must not be zero.';				
						displayMessage(m,'error',Title,'error');
						UiActivateTab('listing'); return false;
					}
					
					if (parseInt(tok) < 0)
					{
						m='Number of artwork tokens must not be a negative number.';				
						displayMessage(m,'error',Title,'error');
						UiActivateTab('listing'); return false;
					}
					
					//Price/Token
					if (!pr)
					{
						m='Artwork price per token field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
						UiActivateTab('listing'); return false;		
					}
					
					if (!$.isNumeric(pr))
					{
						m='Artwork price per token field must be a number.';					
						displayMessage(m,'error',Title,'error');					
						UiActivateTab('listing'); return false;
					}
					
					if (parseFloat(pr) == 0)
					{
						m='Artwork price per token must not be zero.';				
						displayMessage(m,'error',Title,'error');
						UiActivateTab('listing'); return false;
					}
					
					if (parseFloat(pr) < 0)
					{
						m='Artwork price per token must not be a negative number.';				
						displayMessage(m,'error',Title,'error');
						UiActivateTab('listing'); return false;
					}
					
					//Tokens For Sale
					if (!sale)
					{
						m='Number of artwork tokens for sale field must not be blank. Enter the percentage of the artworks token for sale (value is from 1 to 100).';						
						displayMessage(m,'error',Title,'error');						
						UiActivateTab('listing'); return false;		
					}
					
					if (!$.isNumeric(sale))
					{
						m='Number of artwork tokens for sale field must be a number. Enter the percentage of the artworks token for sale (value is from 1 to 100).';					
						displayMessage(m,'error',Title,'error');					
						UiActivateTab('listing'); return false;
					}
					
					if (parseInt(sale) <= 0)
					{
						m='Number of artwork tokens for sale must be greater than zero. Enter the percentage of the artworks token for sale (value is from 1 to 100).';				
						displayMessage(m,'error',Title,'error');
						UiActivateTab('listing'); return false;
					}
					
					//Confirm Update				
					swal({
					  title: 'PLEASE CONFIRM',
					  text: "Do you want to proceed with the editing of the listing request record?",
					  type: 'question',
					  buttons: true,
                      dangerMode: true,
					}).then((result) => {
					  if (result)
					  {
						timedAlert("Editing Listing Request Record. Please Wait...", 4000,'','info');
																
						//Initiate POST
						var uri = "<?php echo site_url('ui/Requestlisting/EditListing'); ?>";
						var xhr = new XMLHttpRequest();
						var fd = new FormData();
						
						xhr.open("POST", uri, true);
						
						xhr.onreadystatechange = function() {
						if (xhr.readyState == 4 && xhr.status == 200)
						{
							// Handle response.
							
							var res = JSON.parse(xhr.responseText);
                            console.log(res);
                            return false;
														
							if ($.trim(res.status).toUpperCase()=='OK')
							{
								m="Listing request record has been edited successfully.";
								displayMessage(m, 'success','Listing Request Edited','success');
								
								ResetControls();
								LoadListings();																					
							}else
							{
								m=res.Message;								
								displayMessage(m,'error',Title,'error');
							}
						}
					};
					
						if (pixfile1 != null) fd.append('art_pix1', pixfile1);
						if (pixfile2 != null) fd.append('art_pix2', pixfile2);
						if (pixfile3 != null) fd.append('art_pix3', pixfile3);
						if (pixfile4 != null) fd.append('art_pix4', pixfile4);
						if (pdffile != null) fd.append('document', pdffile);				
				
						fd.append('uid', '<?php echo $uid; ?>');
						fd.append('email', Email);
						fd.append('artist', nm);
						fd.append('title', tit);
						fd.append('creationyear', dt);
						fd.append('dimensions', dim);
						fd.append('materials', mat);
						fd.append('description', des);
						fd.append('display_location', loc);						
						fd.append('artwork_value', val);
						fd.append('tokens', tok);
						fd.append('tokens_for_sale', sale);						
						fd.append('price_per_token', pr);
						fd.append('art_id', aid);						
						fd.append('id', id);
																					
						xhr.send(fd);// Initiate a multipart/form-data upload
					  }
					})	
				}catch(e)
				{
					m='CheckEdit ERROR:\n'+e;				
					displayMessage(m,'error',Title,'error');
					return false;
				}		
			}//End CheckEdit
		
			function CheckRequest()
			{
				try
				{
					var nm=$.trim($('#txtArtist').val());
					var dt=$.trim($('#txtCreationYear').val());	
					var tit=$.trim($('#txtTitle').val());
					// var des=$.trim($('#txtDescription').val());					
                    var des=$.trim(tinymce.get("txtDescription").getContent());                
					var mat=$.trim(tinymce.get("txtMaterials").getContent());				
					var dim=$.trim($('#txtDimension').val());
					var loc=$.trim($('#txtLocation').val());
					
					var px1=$.trim($('#txtPix1').val());
					var px2=$.trim($('#txtPix2').val());
					var px3=$.trim($('#txtPix3').val());
					var px4=$.trim($('#txtPix4').val());
					
					var doc=$.trim($('#txtDocument').val());
					
					var val=$.trim($('#txtValue').val()).replace(new RegExp(',', 'g'), '');
					var tok=$.trim($('#txtTokens').val()).replace(new RegExp(',', 'g'), '');
					var pr=$.trim($('#txtTokenPrice').val()).replace(new RegExp(',', 'g'), '');					
					var sale=$.trim($('#txtTokensForSale').val()).replace(new RegExp(',', 'g'), '');
					var per=$.trim($('#txtPercentTokens').val()).replace(new RegExp(',', 'g'), '');
					
					//Email
					if (!Email)
					{
						m='Email field is blank. Refresh the window. If it is still blank, sign out and sign in again before continuing with the profile update.';
						
						displayMessage(m,'error',Title,'error');
						return false;
					}			
					
					//Artist Name								
					if (!nm)
					{
						m='Artist name field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
							
					}
					
					if ($.isNumeric(nm))
					{
						m='Artist name field must not be a number.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					if (nm.length<2)
					{
						m='Artist name must be in full.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					//Creation year
					if (!dt)
					{
						m='Artwork creation year field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
							
					}
					
					//Art Title
					if (!tit)
					{
						m='Artwork title field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
								
					}
					
					if ($.isNumeric(tit))
					{
						m='Artwork title field must not be a number.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					if (tit.length<2)
					{
						m='Artwork title must be in full.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					//Description
					if (!des)
					{
						m='Artwork description field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
								
					}
					
					if ($.isNumeric(des))
					{
						m='Artwork description field must not be a number.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					if (des.length<2)
					{
						m='Please type a meaninful artwork description.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					//Material
					if (!mat)
					{
						m='Artwork materials field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
								
					}
					
					if ($.isNumeric(mat))
					{
						m='Artwork materials field must not be a number.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					if (mat.length<2)
					{
						m='Please type a meaninful artwork materials.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					//Dimensions
					if (!dim)
					{
						m='Artwork dimensions field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
								
					}
					
					if ($.isNumeric(dim))
					{
						m='Artwork dimensions field must not be number alone. You must include the unit (E.g. inches or cm).';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					if (dim.length<2)
					{
						m='Please type a meaninful artwork dimensions.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					//Display location
					if (!loc)
					{
						m='Artwork display location field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
								
					}
					
					if ($.isNumeric(loc))
					{
						m='Artwork display location field must not be a number.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					if (loc.length<2)
					{
						m='Please type a meaninful artwork display location.';					
						displayMessage(m,'error',Title,'error');					
						
					}
					
					//Picture 1
					if (pixfile1==null)
					{
						m="Please select artwork's picture 1.";						
						displayMessage(m,'error',Title,'error');
						UiActivateTab('upload'); return false;		
					}
					
					//Picture 2
					// if (pixfile2==null)
					// {
					// 	m="Please select artwork's picture 2.";						
					// 	displayMessage(m,'error',Title,'error');						
					// 	UiActivateTab('upload'); return false;		
					// }
					
					// //Picture 3
					// if (pixfile3==null)
					// {
					// 	m="Please select artwork's picture 3.";						
					// 	displayMessage(m,'error',Title,'error');						
					// 	UiActivateTab('upload'); return false;		
					// }
					
					// //Picture 4
					// if (pixfile4==null)
					// {
					// 	m="Please select artwork's picture 3.";						
					// 	displayMessage(m,'error',Title,'error');						
					// 	UiActivateTab('upload'); return false;		
					// }
					
					
					//Artwork Value
					if (!val)
					{
						m='Artwork value field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
					}
					
					if (!$.isNumeric(val))
					{
						m='Artwork value field must be a number.';					
						displayMessage(m,'error',Title,'error');					
					}
					
					if (parseFloat(val) == 0)
					{
						m='Artwork value must not be zero.';				
						displayMessage(m,'error',Title,'error');
					}
					
					if (parseFloat(val) < 0)
					{
						m='Artwork value must not be a negative number.';				
						displayMessage(m,'error',Title,'error');
					}
					
					//Tokens
					if (!tok)
					{
						m='Number of artwork tokens field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
					}
					
					if (!$.isNumeric(tok))
					{
						m='Number of artwork tokens field must be a number.';					
						displayMessage(m,'error',Title,'error');					
					}
					
					if (parseInt(tok) == 0)
					{
						m='Number of artwork tokens must not be zero.';				
						displayMessage(m,'error',Title,'error');
					}
					
					if (parseInt(tok) < 0)
					{
						m='Number of artwork tokens must not be a negative number.';				
						displayMessage(m,'error',Title,'error');
					}
					
					//Price/Token
					if (!pr)
					{
						m='Artwork price per token field must not be blank.';						
						displayMessage(m,'error',Title,'error');						
					}
					
					if (!$.isNumeric(pr))
					{
						m='Artwork price per token field must be a number.';					
						displayMessage(m,'error',Title,'error');					
					}
					
					if (parseFloat(pr) == 0)
					{
						m='Artwork price per token must not be zero.';				
						displayMessage(m,'error',Title,'error');
					}
					
					if (parseFloat(pr) < 0)
					{
						m='Artwork price per token must not be a negative number.';				
						displayMessage(m,'error',Title,'error');
					}
					
					//Tokens For Sale
					if (!sale)
					{
						m='Number of artwork tokens for sale field must not be blank. Enter the percentage of the artworks token for sale (value is from 1 to 100).';						
						displayMessage(m,'error',Title,'error');						
					}
					
					if (!$.isNumeric(sale))
					{
						m='Number of artwork tokens for sale field must be a number. Enter the percentage of the artworks token for sale (value is from 1 to 100).';					
						displayMessage(m,'error',Title,'error');					
					}
					
					if (parseInt(sale) <= 0)
					{
						m='Number of artwork tokens for sale must be greater than zero. Enter the percentage of the artworks token for sale (value is from 1 to 100).';				
						displayMessage(m,'error',Title,'error');
					}
					
										
													
					//Confirm Update			
					swal({
					  title: 'PLEASE CONFIRM',
					  text: 'Do you want to proceed with the listing request?',
					  type: 'question',
					  buttons: true,
                      dangerMode: true,
					}).then((result) => {
					  if (result)
					  {
						timedAlert('Requesting Listing. Please Wait...',4000,'info');
											
						//Initiate POST
						var uri = "<?php echo site_url('ui/Requestlisting/AddListingRequest'); ?>";
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
									ResetControls();
									LoadListings();
									m='Artwork Listing Request Was successful';
									displayMessage(m, 'success','Listing Requesting','success');	
                                    window.location.reload(true);																				
								}else
								{
									m=res;								
									displayMessage(m,'error',Title,'error');
								}
							}
						};					
						
						
						if (pixfile1 != null) fd.append('art_pix1', pixfile1);
						if (pixfile2 != null) fd.append('art_pix2', pixfile2);
						if (pixfile3 != null) fd.append('art_pix3', pixfile3);
						if (pixfile4 != null) fd.append('art_pix4', pixfile4);
						if (pdffile != null) fd.append('document', pdffile);				
				
						fd.append('uid', '<?php echo $uid; ?>');
						fd.append('email', Email);
						fd.append('artist', nm);
						fd.append('title', tit);
						fd.append('creationyear', dt);
						fd.append('dimensions', dim);
						fd.append('materials', mat);
						fd.append('description', des);
						fd.append('display_location', loc);						
						fd.append('artwork_value', val);
						fd.append('tokens', tok);
						fd.append('tokens_for_sale', sale);
						fd.append('price_per_token', pr);
																											
						xhr.send(fd);// Initiate a multipart/form-data upload
					  }
					})
				}catch(e)
				{

					m='CheckRequest ERROR:\n'+e;
					displayMessage(m,'error',Title,'error');
					return false;
				}
			}
			
			$('#ancView').click(function(e) {
                try
				{
					$('#divPDFModal').modal({
						fadeDuration: 	1000,
						fadeDelay: 		0.50,
						keyboard: 		false,
						backdrop:		'static'
					});
				}catch(e)
				{
					m='View PDF Anchor Clicked ERROR:\n'+e;				
					displayMessage(m,'error',Title,'error');
					return false;
				}
            });	
			
			$("#txtPercentTokens").on("keyup",function(event)
			{
				try
				{
					var p=$.trim($(this).val()).replace(new RegExp(',', 'g'), '');
					
					if (parseFloat(p) < 0)
					{
						beep();						
						m='You entered '+p+'. Percentage of token for sale must not be a negative number.';			
						displayMessage(m,'error',Title,'error');
						$("#txtPercentTokens").val('');
						return false;
					}
					
					if (parseFloat(p) > 100)
					{
						beep();						
						m='You entered '+p+'. Percentage of token for sale must not be more than 100 percent.';			
						displayMessage(m,'error',Title,'error');
						$("#txtPercentTokens").val('');
						return false;
					}
					 
					ComputeTokenPercent();
				}catch(e)
				{
					m='Tokens Percentage Keyup ERROR:\n'+e;			
					displayMessage(m,'error',Title,'error');
				}
			});
			
			$("#txtPercentTokens").on("change",function(event)
			{
				try
				{
					var p=$.trim($(this).val()).replace(new RegExp(',', 'g'), '');
					
					if (parseFloat(p) < 0)
					{
						beep();						
						m='You entered '+p+'. Percentage of token for sale must not be a negative number.';			
						displayMessage(m,'error',Title,'error');
						$("#txtPercentTokens").val('');
						return false;
					}
					
					if (parseFloat(p) > 100)
					{
						beep();						
						m='You entered '+p+'. Percentage of token for sale must not be more than 100 percent.';			
						displayMessage(m,'error',Title,'error');
						$("#txtPercentTokens").val('');
						return false;
					}
					
					ComputeTokenPercent();
				}catch(e)
				{
					m='Tokens Percentage Changed ERROR:\n'+e;			
					displayMessage(m,'error',Title,'error');
				}
			});
			
			$("#txtTokens").on("keyup",function(event)
			{
				try
				{
					ComputeTokenPercent();
				}catch(e)
				{

					m='Tokens Keyup ERROR:\n'+e;			
					displayMessage(m,'error',Title,'error');
				}
			});
			
			$("#txtTokens").on("change",function(event)
			{
				try
				{
					ComputeTokenPercent();
				}catch(e)
				{

					m='Tokens Changed ERROR:\n'+e;			
					displayMessage(m,'error',Title,'error');
				}
			});
			
			function ComputeTokenPercent()
			{
				try
				{
					$('#txtTokensForSale').val('');									
					
					var per=$.trim($('#txtPercentTokens').val()).replace(new RegExp(',', 'g'), '');
					var tok=$.trim($('#txtTokens').val()).replace(new RegExp(',', 'g'), '');					
					var sale=0;
					
					if ((parseFloat(tok) == 0) || (parseFloat(per) == 0))
					{
						$('#txtTokensForSale').val('0');
						
						return;	
					}					
					
					sale = (parseFloat(per)/100) * parseFloat(tok);
					
					$('#txtTokensForSale').val(number_format(sale, 0, '', ','));
				}catch(e)
				{

					m='ComputeTokenPercent ERROR:\n'+e;			
					displayMessage(m,'error',Title,'error');
				}
			}
			
        });//(document).ready
		
		function LoadListings()
		{
			try
			{			
				timedAlert("Loading Listings. Please Wait...",1000,'','info');
				
				$('#recorddisplay > tbody').html('');
				
				$.ajax({
					url: "<?php echo site_url('ui/Requestlisting/GetListings');?>",
					type: 'POST',
					data: {email:Email},
					dataType: 'json',
					success: function(dataSet,status,xhr) {		
						
						if (table) table.destroy();
						
						//f-filtering, l-length, i-information, p-pagination
						table = $('#recorddisplay').DataTable( {
							dom: '<"top"if>rt<"bottom"lp><"clear">',
							responsive: true,
							ordering: true,
							autoWidth:false,
							language: {zeroRecords: "No Listing Record Found"},
							lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
							columnDefs: [
								{
									"targets": [ 0,1,2,3,4,5,6,7,8 ],
									"visible": true
								},
								{
									"targets": [ 1,2,3,4,5,6,7 ],
									"orderable": true,
									"searchable": true
								},
								{
									"targets": [ 0,8 ],
									"orderable": false,
									"searchable": false
								},
								{ className: "dt-center", "targets": [ 0,1,3,5,6,7,8 ] },
								{ className: "dt-right", "targets": [ 2,4 ] }
							],					
							order: [[ 1, 'asc' ]],
							data: dataSet, 
							columns: [
								{ width: "10%" },//Picture
								{ width: "21%" },//Title
								{ width: "10%" },//Value
								{ width: "10%" }, //Tokens
								{ width: "10%" }, //Price/Token
								{ width: "11%" }, //Listing Starts
								{ width: "11%" }, //Listing Ends
								{ width: "13%" }, //Status
								{ width: "4%" } //Select
							]
						} );
	                    if (document.getElementById('btnEdit')) document.getElementById('btnEdit').disabled=true;
                        if (document.getElementById('btnAdd')) document.getElementById('btnAdd').disabled=false;
                        if (document.getElementById('btnAdd')) document.getElementById('btnAdd').style.display="block";
                        if (document.getElementById('btnEdit')) document.getElementById('btnEdit').style.display="none";

                        document.getElementById("tab-2").classList.remove("active");                
                        document.getElementById("tab-1").classList.add("active"); 
						//UiActivateTab('view');		
					},
					error:  function(xhr,status,error) {
	
						m='Error '+ xhr.status + ' Occurred: ' + error;
						displayMessage(m,'error',Title,'error');
					}
				});
			}catch(e)
			{
				
				m='LoadListings ERROR:\n'+e;
				displayMessage(m,'error',Title,'error');
			}
		}
		
		function LoadPix(id,no)
		{
			try
			{				
				var modal = document.getElementById("myPixModal");
				var img = document.getElementById(id);
				var modalImg = document.getElementById("img01");				
				var captionText = document.getElementById("caption");
				
				if (img.src=='<?php echo base_url(); ?>images/empty.jpg') return;
				
				modalImg.src = img.src;
				var c=$.trim($('#txtTitle').val().toUpperCase());
				
				if (c) captionText.innerHTML = c+': PICTURE '+no; else captionText.innerHTML = 'PICTURE '+no;
				
				$('#myPixModal').modal({
					fadeDuration: 	1000,
					fadeDelay: 		0.50,
					keyboard: 		false,
					backdrop:		'static'
				});
			}catch(e)
			{
				
				m='Pix Modal Click ERROR:\n'+e;			
				displayMessage(m,'error',Title,'error');
			}
		}
		
		function GetPix(input,no)
		{
			try
			{
				var img;
				var pixfile=null;
				
				if (parseInt(no)==1) pixfile1=null;
				if (parseInt(no)==2) pixfile2=null;
				if (parseInt(no)==3) pixfile3=null;
				if (parseInt(no)==4) pixfile4=null;

				const img_reader = new FileReader();

                var input = document.querySelector("#txtPix"+no);

				$('#imgPix'+no).css('cursor', 'default');
				
				if (input.files && input.files[0])
				{
					pixfile=input.files[0];

                    img_reader.readAsDataURL(pixfile);

                    var size = pixfile.size;

                    if (size > 2002085) {
                        displayMessage('Image file is too large; please compress image or select an image with a smaller filesize','warning','Upload Image','warning');
                        $('#txtPix'+no).val('');  $('#imgPix'+no).prop('src',emptypix).css('cursor','default');

                        return false;
                    }
					
					if (pixfile != null)
					{
						//Check if file exists
						if (selFiles.length==0)
						{
							selFiles[no] = pixfile.name;
						}else
						{
							for (var i=0; i < selFiles.length; i++)
							{
								if ($.trim(selFiles[i]).toLowerCase() == $.trim(pixfile.name).toLowerCase())
								{
									m="You have already selected the artwork picture with filename "+pixfile.name+" for  Listing Image "+i;
									displayMessage(m, 'error','Request Listing','error');
									
									$('#txtPix'+no).val(''); 
									$('#imgPix'+no).prop('src',emptypix);
																	
									return false;
								}
							}
							
                            selFiles[no] = pixfile.name;

						}
					}
					
					if (parseInt(no)==1) pixfile1=input.files[0];
					if (parseInt(no)==2) pixfile2=input.files[0];
					if (parseInt(no)==3) pixfile3=input.files[0];
					if (parseInt(no)==4) pixfile4=input.files[0];
				}				
				
				if (pixfile != null)
				{
					//check whether browser fully supports all File API
					if (window.File && window.FileReader && window.FileList && window.Blob) 
					{
						var fr = new FileReader;
						fr.onload = function() { // file is loaded
							img = new Image;
							img.onload = function() 
							{ // image is loaded; sizes are available
								if (this.width < 400)
								{
									m="The selected picture's width is "+this.width+" pixels. The picture width must be at least 400 pixels.";
									displayMessage(m, 'error','Request Listing','error');
									$('#txtPix'+no).val(''); 
									$('#imgPix'+no).prop('src',emptypix);
																	
									return false;
								}
							};
							
							img.src = fr.result; // is the data URL because called with readAsDataURL
						};
						
						fr.readAsDataURL(input.files[0]);
					}else
					{
						m="Please upgrade your browser, because your current browser lacks some new features we need!";
						displayMessage(m, 'error','Request Listing','error');
											
						return false;
					}
					
					var s=pixfile.name.split('.'); var ext=$.trim(s[s.length-1]);
					
					if ((ext.toLowerCase() != 'jpg') && (ext.toLowerCase() != 'jpeg'))
					{
						m="The selected picture file format is "+ext.toUpperCase()+" and it is accepted for this listing request. Only JPG or JPEG format is allowed.";
						displayMessage(m, 'error','Request Listing','warning');
						
						$('#txtPix'+no).val(''); 
						$('#imgPix'+no).prop('src',emptypix);
						
						return false;
					}
						
					var reader = new FileReader();
					 reader.onload = function(e){
					   $('#imgPix'+no).attr('src', e.target.result);
					   $('#imgPix'+no).css('cursor', 'pointer');
					 }
					 
					 reader.readAsDataURL(input.files[0]);
				}
			}catch(e)
			{
				
				m='GetPix ERROR:\n'+e;
				displayMessage(m, 'error','Request Listing','error');
			}
		} //End GetPix
		
		function handleFileSelect(evt) 
		{
			try
			{
				pdffile=null;
				
				var files = evt.target.files; // FileList object
				
				for (var i = 0, f; f = files[i]; i++)
				{
					let fileType = files[i].type;
					
					var s=files[i].name.split('.'); var ext=$.trim(s[s.length-1]);
					
					if (fileType === PDF_TYPE)
					{
						$('#divPdfViewer').html('');
						
						$('#modTitle').html('ARTWORK DOCUMENT: '+files[i].name);
						
						// $('#ancView').html('Click Here To View The PDF File');
			  			
						pdffile=files[i];
						
						handlePDFFile(files[i]);
					}else
					{
						$('#ancView').html('');
						$('#txtDocument').val('');
						
						var canvas = document.getElementById('the-canvas');
						
						const context = canvas.getContext('2d');
						context.clearRect(0, 0, canvas.width, canvas.height);
						
			  			m='Cannot handle file type: '+ $.trim(ext).toUpperCase()+'. Only PDF files are allowed.';
						displayMessage(m, 'error','Request Listing','warning');
					}
		  		}	
			}catch(e)
			{
				
				m='handleFileSelect ERROR:\n'+e;
				displayMessage(m, 'error','Request Listing','error');
			}		  
		  
		}
		
		function handlePDFFile(file) 
		{
			try
			{
				var reader = new FileReader();
				
				reader.onload = (function(reader) 
				{
					return function()
					{
						var scale = 1.5;
						var pageStarts = new Array();
					    pageStarts[0] = 0;
						
				  		var contents = reader.result;
				  		var loadingTask = pdfjsLib.getDocument(contents);
				
				  		loadingTask.promise.then(function(pdf)
						{
							viewer = document.getElementById('divPdfViewer');							
							
							for(var pg = 1; pg <= pdf.numPages; pg++)
							{
								pdf.getPage(pg).then(function(page)
								{
									
									var viewport = page.getViewport({scale: scale,});					
									var canvas = document.createElement( "canvas" );
									canvas.style.display = "block";
									
									var context = canvas.getContext('2d');
									canvas.height += viewport.height;
									canvas.width = viewport.width;
					
									var renderContext = {canvasContext: context,viewport: viewport};
									page.render(renderContext);
									
									viewer.appendChild(canvas); 
								});
							}
				  		});
					}
				})(reader);
				
				reader.readAsDataURL(file);
			}catch(e)
			{
				
				m='handlePDFFile ERROR:\n'+e;
				displayMessage(m, 'error','Request Listing','error');
			}
		}
		
		function SelectRow(artist,aid,tit,sym,cyr,dim,mat,des,doc,loc,tval,tok,sale,pr,sdt,edt,p1,p2,p3,p4,sta,adt,id)
		{
			try
			{
				ResetControls();
				
				if (document.getElementById('btnEdit')) document.getElementById('btnEdit').disabled=false;
				if (document.getElementById('btnAdd')) document.getElementById('btnAdd').disabled=true;
                if (document.getElementById('btnAdd')) document.getElementById('btnAdd').style.display="none";
                if (document.getElementById('btnEdit')) document.getElementById('btnEdit').style.display="block";
	           
				$('#txtArtist').val(artist);
				$('#txtCreationYear').val(cyr);	
				$('#txtTitle').val(tit);
				// $('#txtDescription').val(des);
                tinymce.get('txtDescription').setContent(des);				
                tinymce.get('txtMaterials').setContent(mat);              
				$('#txtDimension').val(dim);
				$('#txtLocation').val(loc);	

				$('#txtSymbol').val(sym);
				$('#txtListingStatus').val(sta);		
				$('#txtValue').val(number_format(tval,2,'.',','));
				$('#txtApprovalDate').val(adt);
				$('#txtTokens').val(number_format(tok,0,'',','));
				$('#txtTokenPrice').val(number_format(pr,2,'.',','));
				
				$('#txtTokensForSale').val(number_format(sale,0,'',','));
				
				if (parseFloat(tok) != 0)
				{
					var p=parseFloat(sale)/parseFloat(tok) * 100;
					$('#txtPercentTokens').val(number_format(p,2,'.',','));	
				}else
				{
					$('#txtPercentTokens').val('0.00');	
				}
				
				
				$('#txtListingStart').val(sdt);
				$('#txtListingEnd').val(edt);
				
				var path='<?php echo base_url()."art-works/"; ?>';
				
				if (p1) $('#imgPix1').prop('src',path+p1).css('cursor','pointer');
				if (p2) $('#imgPix2').prop('src',path+p2).css('cursor','pointer');
				if (p3) $('#imgPix3').prop('src',path+p3).css('cursor','pointer');
				if (p4) $('#imgPix4').prop('src',path+p4).css('cursor','pointer');
				
				$('#ancView').html('');
				$('#txtDocument').val('');						
				$('#modTitle').html('ARTWORK DOCUMENT: '+doc);
				
				$('#divPdfViewer').html('');				
				$('#ancView').html('Click Here To View The PDF File');
				
				LoadPDFFile(path+'docs/'+doc);				


                document.getElementById("tab-1").classList.remove("active");				
                document.getElementById("tab-2").classList.add("active");             
				
				$('#hidId').val(id);
				$('#hidArtId').val(aid);
	
			}catch(e)
			{
				
				m='SelectRow ERROR:\n'+e;
				displayMessage(m,'error',Title,'error');
			}
		}
		
		function LoadPDFFile(fn) 
		{
			try
			{
				var scale = 1.5;
				var pageStarts = new Array();
				pageStarts[0] = 0;
				
				var loadingTask = pdfjsLib.getDocument(fn);
		
				loadingTask.promise.then(function(pdf)
				{
					viewer = document.getElementById('divPdfViewer');							
					
					for(var pg = 1; pg <= pdf.numPages; pg++)
					{
						pdf.getPage(pg).then(function(page)
						{
							
							var viewport = page.getViewport({scale: scale,});					
							var canvas = document.createElement( "canvas" );
							canvas.style.display = "block";
							
							var context = canvas.getContext('2d');
							canvas.height += viewport.height;
							canvas.width = viewport.width;
			
							var renderContext = {canvasContext: context,viewport: viewport};
							page.render(renderContext);
							
							viewer.appendChild(canvas); 
						});
					}
				});
			}catch(e)
			{
				
				m='LoadPDFFile ERROR:\n'+e;
				displayMessage(m, 'error','Request Listing','error');
			}
		}
		
		function DeleteRow(tit,artist,art_id,id)
		{			
			try
			{
				if (!Email)
				{
					m='There is a problem with the selected row. Click on REFRESH button to refresh the page. If this message keeps coming up, please contact us at support@naijaartmart.com.';
					
					displayMessage(m,'error',Title,'error');
					return false;
				}else
				{
					swal({
					  title: 'PLEASE CONFIRM',
					  text: "Do you want to delete this listing request record from the database?. Please note that this action is irreversible.",
					  type: 'question',
					  buttons: true,
                      dangerMode: true,
					}).then((result) => {
					  if (result)
					  {
						timedAlert("Deleting Listing Request Record. Please Wait...",4000,'','info');
						
						$('#divAlert').html('');
						
						m=''
						
						//Make Ajax Request			
						$.ajax({
							url: '<?php echo site_url('ui/Requestlisting/DeleteListing'); ?>',
							data: {email:Email, art_id:art_id, title:tit, artist:artist, id:id},
							type: 'POST',
							dataType: 'json',
							success: function(data,status,xhr) {				
			
								
								if ($(data).length > 0)
								{
									$.each($(data), function(i,e)
									{
										if ($.trim(e.status).toUpperCase() == 'OK')
										{
											ResetControls();
											LoadListings();
											
											m='Listinig request was deleted successfully.';
											
											displayMessage(m, 'success','Listing Request Deleted','success');
									
											if (parseInt(e.rowcount) > 0)
											{
												activateTab('view');
											}else
											{
												activateTab('data');
											}
										}else
										{
											m=e.Msg;
											
											displayMessage(m,'error',Title,'error');		
										}
										
										return;
									});//End each
								}
							},
							error:  function(xhr,status,error) {
								m='Error '+ xhr.status + ' Occurred: ' + error
								displayMessage(m,'error',Title,'error');
							}
						});
					  }
					})				
				}
			}catch(e)
			{
				
				m='Delete Listing Button Click ERROR:\n'+e;
				displayMessage(m,'error',Title,'error');
			}
		}
		
		function ResetControls()
		{
			try
			{					
				// if (document.getElementById('btnEdit')) document.getElementById('btnEdit').disabled=true;
				if (document.getElementById('btnAdd')) document.getElementById('btnAdd').disabled=false;
				
				$('#txtArtist').val('');
				$('#txtCreationYear').val('');	
				$('#txtTitle').val('');
				$('#txtDescription').val('');					
				$('#txtMaterials').val('');
				$('#txtDimension').val('');
				$('#txtLocation').val('');	
				
				$('#txtSymbol').val('');
				$('#txtListingStatus').val('');		
				$('#txtValue').val('');
				$('#txtApprovalDate').val('');
				$('#txtTokens').val('');
				$('#txtTokenPrice').val('');
				
				$('#txtTokensForSale').val('');
				$('#txtPercentTokens').val('');
				
				$('#txtListingStart').val('');
				$('#txtListingEnd').val('');				
				
				$('#txtPix1').val('');  $('#imgPix1').prop('src',emptypix).css('cursor','default');
				$('#txtPix2').val('');  $('#imgPix2').prop('src',emptypix).css('cursor','default');
				$('#txtPix3').val('');  $('#imgPix3').prop('src',emptypix).css('cursor','default');
				$('#txtPix4').val('');  $('#imgPix4').prop('src',emptypix).css('cursor','default');
				
				pixfile1=null;  pixfile2=null;  pixfile3=null;  pixfile4=null;  pdffile=null;
				selFiles=[];
				
				$('#ancView').html('');
				$('#txtDocument').val('');						
				$('#modTitle').html('ARTWORK DOCUMENT');
				
				$('#hidArtId').val('');
				$('#hidId').val('');
				
			}catch(e)
			{
				
				m="ResetControls ERROR:\n"+e;
				displayMessage(m,'error',Title,'error');
			}
		}//End ResetControls
		
	</script>
</body>
</html>