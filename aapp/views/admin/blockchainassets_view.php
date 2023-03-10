<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Derived Homes - Assets On Blockchain</title>
    <meta name="viewport" content="width=device-width,initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Naija Art Mart - The New Art Market For Everyone">    
    <meta name="msapplication-tap-highlight" content="no"><!-- Disable tap highlight on IE -->

	<?php include('header.php'); ?>
    <?php include('scripts.php'); ?>

	 <style>
    	/* DivTable.com */
				
		.divTableCell, .divTableHead {
			border: 0px solid #ffffff;
			/*display: table-cell;
			padding: 3px 10px;*/
			text-align: center;
		}
			
		@media (max-width: 320px) { 
			.divTableCell {
				width: 90%;
			}
		}
		
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

	<script type = "text/javascript">
	
	var Title='<font color="#AF4442">Naija Art Mart Message</font>';
	var Email='<?php echo $email; ?>';
	var emptypix='<?php echo base_url(); ?>images/nopix.jpg';
	var m='',table;
	
	function DisplayMessage(msg,msgtype,msgtitle,theme='AlertTheme')
	{
		try
		{//SuccessTheme, AlertTheme
			$('#divAlert').html(msg).addClass(theme);
			
			
			Swal.fire({
				  type: msgtype,
				  title: '<strong>'+msgtitle+'</strong>',
				  background: '#E2F3D4',
				  color: '#f00',
				  allowEscapeKey: false,
				  allowOutsideClick: false,
				  html: '<font color="#000000">'+msg+'</font>',
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
		
		$('#imgPix').prop('src',emptypix);
		
		LoadBlockchainAssets();
		
		$('#imgPix').click(function(e) {
            try
			{
				var img = document.getElementById('imgPix');
				var modalImg = document.getElementById("img01");				
							
				if (img.src=='<?php echo base_url(); ?>images/empty.jpg') return;
				
				modalImg.src = img.src;
				var c=$.trim($('#txtTitle').val());
				
				if (!c) c = 'Picture';
				
				$("#modPixTitle").html(TitleCase(c)); 
			}catch(e)
			{
				$.unblockUI();
				m='Image Click ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
        });	
		
    });//Document Ready
	
	
	
	function ViewRow(ArtId,Desc,Sym,noOfToks,price,issuer,Artist,Title,listdate,ToksForSale,cYear,ArtVal,Pix,url)
	{
		try
		{
			ResetControls();
			
			$('#txtTitle').val(Title);
			$('#txtSymbol').val(Sym);
			$('#txtArtistName').val(Artist);
			$('#txtDescription').val(Desc);
			$('#txtValue').val(number_format(ArtVal,2,'.',','));
			$('#txtTokens').val(number_format(noOfToks,0,'',','));						
			$('#txtTokensForSale').val(number_format(ToksForSale,0,'',','));
			$('#txtTokenPrice').val(number_format(price,2,'.',','));
			$('#txtCreationYear').val(cYear);	
			$('#txtIssuerName').val(issuer);
			$('#txtListingDate').val(listdate);
			$('#txtArtId').val(ArtId);
			
			if (url)
			{
				$('#ancBlockchainUrl').html(url);
				$('#ancBlockchainUrl').prop('href',url).prop('title',"Click To View Asset Blockchain Details");
			}

			if (Pix) $('#imgPix').css('cursor','pointer').attr({'data-toggle':'modal','data-target':'.bd-example-modal-lg', 'data-backdrop':'static','data-keyboard':'false','data-fadeDuration':'1000', 'data-fadeDelay':'0.50','src':Pix});
			
			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m='ViewRow ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}

	function ResetControls()
	{
		try
		{
			$('#txtTitle').val('');
			$('#txtSymbol').val('');
			$('#txtArtistName').val('');
			$('#txtDescription').val('');
			$('#txtValue').val('');
			$('#txtTokens').val('');						
			$('#txtTokensForSale').val('');
			$('#txtTokenPrice').val('');
			$('#txtCreationYear').val('');	
			$('#txtIssuerName').val('');
			$('#txtListingDate').val('');
			$('#txtArtId').val('');		
			
			$('#ancBlockchainUrl').html('').prop('href','').prop('title','');
			$('#ancBlockchainUrl').removeAttr('href');
					
			$('#imgPix').prop('src',emptypix).css('cursor','default');
						
			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m="ResetControls ERROR:\n"+e;
			DisplayMessage(m,'error',Title);
		}
	}//End ResetControls
	
	function LoadBlockchainAssets()
	{
		try
		{			
			$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Loading Blockchain Assets. Please Wait...</p>",theme: false,baseZ: 2000});
			
			$('#recorddisplay > tbody').html('');
			
			$.ajax({
				url: "<?php echo site_url('admin/Blockchainassets/GetAssets');?>",
				type: 'POST',
				dataType: 'json',
				success: function(dataSet,status,xhr) {	

					console.log(dataSet);
					$.unblockUI();
					
					if (table) table.destroy();
					
					//f-filtering, l-length, i-information, p-pagination
					table = $('#recorddisplay').DataTable( {
						dom: '<"top"if>rt<"bottom"lp><"clear">',
						responsive: true,
						ordering: false,
						autoWidth:false,
						language: {zeroRecords: "No Blockchin Asset Record Found"},
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
							{ className: "dt-center", "targets": [ 0,1,2,3,5,6,8 ] },
							{ className: "dt-right", "targets": [ 4,7 ] }
						],					
						order: [[ 7, 'asc' ]],
						data: dataSet, 
						columns: [
							{ width: "10%" },//Picture
							{ width: "18%" },//Title/Year
							{ width: "11%" },//Symbol
							{ width: "15%" }, //Artist
							{ width: "10%" }, //Value
							{ width: "10%" }, //Tokens
							{ width: "12%" }, //Tokens For Sale
							{ width: "10%" }, //Price Per Token
							{ width: "4" } //View
						]
					} );//10,18,11,15,10,10,12,10,4

					//AdminActivateTab('view');		
				},
				error:  function(xhr,status,error) {
					$.unblockUI();
					m='Error '+ xhr.status + ' Occurred: ' + error;
					DisplayMessage(m,'error',Title);
				}
			});
		}catch(e)
		{
			$.unblockUI();
			m='LoadBlockchainAssets ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}
		
    </script>
</head>
<body>

<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    <?php include('dheader.php'); //Dashboard Header ?>
    
    
    <div class="app-main">
          	<?php include('sidemenu.php'); //Side Menu ?>
            
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title" style="padding:5px">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div>
                                    
                                    <div class="page-title-subheading opacity-10">
                                        <nav class="" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item">
                                                    <a>
                                                        <i aria-hidden="true" class="fa fa-home"></i>
                                                    </a>
                                                </li>
                                                <li class="active breadcrumb-item">
                                                    <a href="<?php echo site_url('admin/Dashboard'); ?>">Dashboards</a>
                                                </li>
                                                <li class="breadcrumb-item" aria-current="page">
                                                    Assets On Blockchain
                                                </li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    
                    <ul class="body-tabs-layout tabs-animated body-tabs-animated nav">
                        <li class="nav-item">
                            <a role="tab" class="nav-link active" id="tabView" data-toggle="tab" href="#view">
                                <span>Blockchain Assets</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabData" data-toggle="tab" href="#data">
                                <span>Asset Details</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabDetails" data-toggle="tab" href="#details">
                                <span>Asset Picture</span>
                            </a>
                        </li>           
                        
                        <li onClick="window.location.reload(true);" class="nav-item">
                            <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#refresh">
                                <span>Refresh</span>
                            </a>
                        </li>
                    </ul>
                    
                    
                    <div class="tab-content">
                    	 <!--Request Tab-->
                        <div class="tab-pane tabs-animation fade show active" id="view" role="tabpanel">
                        	<div class="row">
                            	<div class="col-md-12">
                                	<div class="mb-3 card">
                                        <div class="card-body">
                                            <table class="hover table table-bordered data-table display wrap" id="recorddisplay">
                                              <thead>
                                                <tr>
                                                    <th style="text-align:center" width="10%">PICTURE</th>
                                                    <th style="text-align:center" width="18%">ARTWORK TITLE (YEAR)</th>
                                                    <th style="text-align:center" width="11%">SYMBOL</th>
                                                    <th style="text-align:center" width="15%">ARTIST</th>
                                                    <th style="text-align:right; padding-right:10px;" width="10%">VALUE&nbsp;(&#8358;)</th> 
                                                    <th style="text-align:center" width="10%">TOKENS</th>
                                                    <th style="text-align:center" width="12%">TOKENS&nbsp;FOR&nbsp;SALE</th>
                                                    <th style="text-align:right; padding-right:10px;" width="10%">PRICE/TOKEN&nbsp;(&#8358;)</th> 
                                                    <th style="text-align:center" width="4%">VIEW</th>
                                                </tr>
                                              </thead>

                                              <tbody id="tbbody"></tbody>
                                            </table>                                           
                                        </div>
                                    </div> 
                                </div>
                            </div>                            
                        </div>
                       
                       	 <!--Request Data Tab-->
                        <div class="tab-pane tabs-animation fade" id="data" role="tabpanel">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                	<form class="">
                                    	<!--Art Title-->
                                         <div title="Artwork Title" class="position-relative row form-group">
                                            <label for="txtTitle" class="col-sm-2 col-form-label nsegreen">Art Title</label>
                                        
                                            <div class="col-sm-10">
                                                <input style="background:#F5F5F5; color:#000000; cursor:default;" readonly id="txtTitle" placeholder="Artwork Title" type="text" class="form-control">
                                            </div>
                                         </div>
                                                                          
                                        <!--Symbol/Artist Name-->
                                        <div class="position-relative row form-group">
                                            <label title="Artwork Symbol" for="txtSymbol" class="col-sm-2 col-form-label nsegreen">Artwork symbol</label>
                                        
                                            <div title="Artwork Symbol" class="col-sm-4">
                                                <input style="background:#F5F5F5; color:#000000; cursor:default;" id="txtSymbol" placeholder="Artwork symbol" type="text" class="form-control">
                                            </div>
                                            
                                            <!--Artist Name-->
                                            <label title="Artist Name" for="txtArtistName" class="col-sm-2 col-form-label nsegreen text-right">Artist Name</label>
                                             
                                             <div title="Artist Name" class="col-sm-4">
                                                <input style="background:#ffffff; color:#ff0000; cursor:default;" readonly class="form-control" type="text" id="txtArtistName" placeholder="Artist Name">                                               
                                             </div>
                                         </div>
      
                                         <!--Art Description-->
                                         <div title="Artwork Description" class="position-relative row form-group">
                                            <label for="txtDescription" class="col-sm-2 col-form-label nsegreen">Description</label>
                                        
                                            <div class="col-sm-10">
                                                <textarea rows="3" style="background:#F5F5F5; color:#000000; cursor:default;" readonly id="txtDescription" placeholder="Artwork Description" class="form-control"></textarea>
                                            </div>
                                         </div>
                                        
                                        <!--Art Value/No Of Tokens-->
                                        <div class="position-relative row form-group">
                                            <label title="Artwork Value" for="txtValue" class="col-sm-2 col-form-label nsegreen">Artwork Value</label>
                                        
                                            
                                            <div title="Artwork Value" class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                                                    
                                                     <input style="background:#F5F5F5; color:#000000; cursor:default;" type="text" id="txtValue" placeholder="Artwork Value" class="form-control">
                                                </div>
                                            </div>
                                            
                                            <!--No Of Tokens-->
                                            <label title="No Of Tokens" for="txtTokens" class="col-sm-2 col-form-label nsegreen text-right">No Of Tokens</label>
                                             
                                             <div title="No Of Tokens" class="col-sm-4">
                                                <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtTokens" placeholder="No Of Tokens">                                               
                                             </div>
                                         </div>
                                        
                                         <!--No Of Tokens For Sale/Price Per Token-->
                                        <div class="position-relative row form-group">
                                        	<!--No Of Tokens For Sale-->
                                             <label title="Number Of Tokens For Sale" for="txtTokensForSale" class="col-sm-2 col-form-label nsegreen">Tokens For Sale</label>
                                            
                                            <div title="Number Of Tokens For Sale" class="col-sm-4">
                                                <input style="background:#F5F5F5; color:#000000; cursor:default;" type="text" class="form-control" placeholder="No Of Tokens For Sale" id="txtTokensForSale">
                                            </div>
                                            
                                             <!--Price Per Token-->
                                            <label title="Artwork Price Per Token" for="txtTokenPrice" class="col-sm-2 col-form-label nsegreen text-right">Price Per Token</label>
                                        
                                            
                                            <div title="Artwork Price Per Token" class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-btn size-20 makebold"><button style="padding-left:10px; padding-right:10px;" class="btn btn-nse-green" type="button">₦</button></span>
                                                    
                                                     <input style="background:#F5F5F5; color:#000000; cursor:default;" type="text" id="txtTokenPrice" placeholder="Price Per Token" class="form-control">
                                                </div>
                                            </div>
                                         </div>   
                                         
                                         <!--Creation Year/Issuer Name-->
                                         <div class="position-relative row form-group">
                                         	<!--Creation Year-->
                                            <label title="Year Of Creation" for="txtCreationYear" class="col-sm-2 col-form-label nsegreen">Creation Year</label>
                                            
                                            <div title="Year Of Creation" class="col-sm-4">
                                                <div class="input-group">
                                                    <input style="background:#F5F5F5; color:#000000; cursor:default;" type="text" class="form-control" placeholder="Year Of Creation" id="txtCreationYear">
                                            	</div>
                                            </div>
                                            
                                            <!---->
                                            <label title="Name Of Issuer" for="txtIssuerName" class="col-sm-2 col-form-label nsegreen text-right">Issuer Name</label>
                                             <div title="Name Of Issuer" class="col-sm-4">
                                                <input style="background:#F5F5F5; color:#000000; cursor:default;" type="text" id="txtIssuerName" placeholder="Name Of Issuer" class="form-control">
                                            </div>
                                         </div>
                                         
                                         <!--Listing Date/Art Id-->
                                         <div class="position-relative row form-group">
                                         <!--Listing Date-->
                                             <label title="Listing Date" for="txtListingDate" class="col-sm-2 col-form-label nsegreen">Listing Date</label>
                                             
                                             <div title="Listing Date" class="col-sm-4">
                                             	 <input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtListingDate" placeholder="Listing Date">
                                             </div>
                                             
                                             <!--Art Id-->
                                             <label title="Art Id" for="txtArtId" class="col-sm-2 col-form-label nsegreen text-right">Art Id</label>
                                             
                                             <div title="Art Id" class="col-sm-4">
                                             	<input style="background:#ffffff; cursor:default;" readonly class="form-control" type="text" id="txtArtId" placeholder="Art Id">                                               
                                             </div>
                                         </div>      
                                     </form>
                                </div>                              
                            </div>
                        </div>
                        
                        <!--Picture Tab-->
                        <div class="tab-pane tabs-animation fade" id="details" role="tabpanel">
                        	<div class="main-card mb-3 card">
                            	<div class="card-body">
                                	<form class="">
                                        <!--Artwork Picture-->
                                        <div class="position-relative row form-group">
                                             <label title="Art picture" for="imgPix" class="col-sm-2 col-form-label nsegreen text-right">Art Picture</label>
                                             
                                             <div class="col-sm-4">
                                                <img class="rounded img-thumbnail" id="imgPix" style="height:350px; margin-top:10px; border:solid 1px dotted;" />
                                             </div>
                                        </div>  
                                        
                                        <!--Blockchain Url-->              
                                		<div title="Blockchain Url" class="position-relative row form-group">
                                         <label for="ancBlockchainUrl" class="col-sm-2 col-form-label nsegreen">Blockchain Url</label>
                                         
                                         <div title="" class="col-sm-10">
                                            <a style="border:none;" class="form-control" id="ancBlockchainUrl" target="_blank"></a>
                                         </div>
                                     </div>
                                </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>                                                                
                </div>
                
                
                <!--Footer-->
               <?php include('footer.php'); ?>
           </div>
    </div>
</div>


<!--Start Pix Popup-->
<div id="myPixModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background-color:#000000; padding:0;">
          <div class="modal-header" style="background-color:#363131;">              
              <h4 style="color:#ffffff; margin-right:39px;" id="modPixTitle" class="modal-title">PICTURE</h4>
              <button title="Click X to close the picture screen" type="button" class="close" data-dismiss="modal">×</button>
          </div>
          
          <div align="center" class="modal-body" style="padding:1px;">
            <img class="modal-content" id="img01" style="margin-top:0; border:none; ">
          </div>
          
          <div class="modal-footer">
            <center><button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button></center>
          </div>
        </div>
      </div>
</div>

<!--End Pix Popup-->


<script type="text/javascript" src="<?php echo base_url();?>assets/js/main.8d288f825d8dffbbe55e.js"></script>
</body>
</html>
