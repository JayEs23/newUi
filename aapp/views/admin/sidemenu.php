<style type="text/css">
	app-sidebar.sidebar-text-light .vertical-nav-menu li a {
	    color: #292525b3 !important;
	}
	.logo-src {
		background-repeat: no-repeat !important;
	}

</style>
<script>
	
	$(function() {			
	$.blockUI.defaults.css = {};// clear out plugin default styling
});

	$(document).ajaxStop($.unblockUI);

       
     function DBbackup()
	{
		try
		{
			var Title='<font color="#AF4442">Derived Homes Help</font>';
			var m='';
			
			Swal.fire({
			  title: 'PLEASE CONFIRM',
			  html: "<font size='3' face='Arial'>Database backup process might take a few minutes. Do you want to proceed with the backup?</font>",
			  type: 'question',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  cancelButtonText: '<font size="3" face="Arial">No</font>',
			  confirmButtonText: '<font size="3" face="Arial">Yes, Proceed!</font>'
			}).then((result) => {
			  if (result.value)
			  {
				$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Backing Up Database. Please Wait...</p>",theme: false,baseZ: 2000});
				
				$.ajax({
					url: "<?php echo site_url('admin/Dashboard/BackupDb'); ?>",
					type: 'POST',
					dataType: 'text',
					success: function(data,status,xhr) {	
						$.unblockUI();
								
						if ($.trim(data).toUpperCase() == 'OK')
						{
							m="Application Database Has Been Backed Up successfully.";
							
							DisplayMessage(m, 'success','Backup Result','SuccessTheme');	
						}else
						{
							DisplayMessage(data, 'error',Title);
						}				
					},
					error:  function(xhr,status,error) {
						$.unblockUI();
						m='Error '+ xhr.status + ' Occurred: ' + error;
						DisplayMessage(m, 'error',Title);
					}
				});				
			  }
			})
		}catch(e)
		{
			$.unblockUI();
			m='DBbackup Function ERROR:\n'+e;			
			DisplayMessage(m, 'error',Title);
			return false;
		}
	}

</script>

<!--**************Side Menu***************-->
<div class="app-sidebar sidebar-shadow sidebar-text-light" style="color: gray !important;">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>  
    
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
            	<li class="">
               		<a style="color:gray !important" href="<?php echo site_url('admin/Dashboard'); ?>">
                        <i class="metismenu-icon pe-7s-home"></i>
                        Dashboard
                    </a>
                </li>            
            
                
<?php
	echo '<li class="app-sidebar__heading" style="color:gray !important">Menu</li>';
	
	if ((trim(strtolower($usertype))=='operator') or (trim(strtolower($usertype))=='admin'))
	{
		echo '<li title="View Primary And Secondary Market Trades">
			<a style="color:gray !important" href="'.site_url('admin/Viewtrades').'">
				<i class="metismenu-icon pe-7s-graph1"></i>
				View Trades
				<i class="metismenu-state-icon"></i>
			</a>
		</li>';
		
		//if ($ViewOrders==1)//Match Orders
		//{
			/*echo '<li title="View Trade">
				<a style="color:gray !important" href="'.site_url('admin/Trades').'">
					<i class="metismenu-icon pe-7s-portfolio"></i>
					View Trade
					<i class="metismenu-state-icon"></i>
				</a>
			</li>';*/
		//}	
		
		if ($RegisterBroker==1)
		{
			echo '<li title="Register Brokers">
				<a style="color:gray !important" href="'.site_url('admin/Registerbroker').'">
					<i class="metismenu-icon pe-7s-add-user"></i>
					Register Brokers
					<i class="metismenu-state-icon"></i>
				</a>
			</li>';	
		}
		
		echo '<li title="Send News/Messages">
			<a style="color:gray !important" href="'.site_url('admin/Messages').'">
				<i class="metismenu-icon pe-7s-mail"></i>
				Send Messages
				<i class="metismenu-state-icon"></i>
			</a>
		</li>';
	}
	
	
	
	
	if (($PublishWork==1) and ((trim(strtolower($usertype))=='gallery') or (trim(strtolower($usertype))=='admin')))//Primary Market
	{
		echo '		
		<li title="Approve Listing Requests">
			<a style="color:gray !important" href="'.site_url('admin/Approvelisting').'">
				<i class="metismenu-icon pe-7s-check"></i>
				Approve Listing
				<i class="metismenu-state-icon"></i>
			</a>
		</li>
		
		';	
	}
	
	if (trim(strtolower($usertype))=='admin')
	{
		echo '		
		<li title="Pay Issuers For Primary Trade At End Of Issuance">
			<a style="color:gray !important" href="'.site_url('admin/Payissuers').'">
				<i class="metismenu-icon pe-7s-cash"></i>
				Pay Issuers
				<i class="metismenu-state-icon"></i>
			</a>
		</li>
		
		';
		
		//Webhooks
		echo '		
		<li title="View paystack transactions status">
			<a style="color:gray !important" href="'.site_url('admin/Paystacktransstatus').'">
				<i class="metismenu-icon pe-7s-helm"></i>
				Paystack Transactions Status
				<i class="metismenu-state-icon"></i>
			</a>
		</li>
		
		';
	}
	
	
	//Blockchain Data
	if ((trim(strtolower($usertype))=='operator') or (trim(strtolower($usertype))=='admin') or (trim(strtolower($usertype))=='gallery'))
	{
		echo '
				<li>
					<a style="color:gray !important" href="#"  title="Blockchain Data">
						<i class="metismenu-icon fa fa-link"></i>
						Blockchain Data
						<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
					</a>
					<ul>
					
						<li title="View Assets On Blockchain">
							<a style="color:gray !important" href="'.site_url('admin/Blockchainassets').'">
								<i class="metismenu-icon"></i>
								Assets On Blockchain
							</a>
						</li>';
		
		if ((trim(strtolower($usertype))=='operator') or (trim(strtolower($usertype))=='admin'))
		{
			echo '
				<li title="View Users On Blockchain">
							<a style="color:gray !important" href="'.site_url('admin/Blockchainusers').'">
								<i class="metismenu-icon"></i>
								Users On Blockchain
							</a>
						</li>
												
				';		
				
				//<li title="View Users\' Portfolio On Blockchain">
						//	<a style="color:gray !important" href="'.site_url('admin/Blockchainportfolios').'">
						//		<i class="metismenu-icon"></i>
						//		Portfolios On Blockchain
						//	</a>
						//</li>	
		}		
		
						
		  echo '              
					</ul>
				</li>
		';
	}
	
	
	if ((trim(strtolower($usertype))=='operator') or (trim(strtolower($usertype))=='admin'))
	{
		if ($SetParameters==1)//Settings
		{
			echo '		
			<li title="Capture Public Holidays">
				<a style="color:gray !important" href="'.site_url('admin/Publicholidays').'">
					<i class="metismenu-icon pe-7s-smile"></i>
					Public Holidays
					<i class="metismenu-state-icon"></i>
				</a>
			</li>
			
			';	
		}
		
		if ($SetMarketParameters==1)
		{
			echo '
					<li>
						<a style="color:gray !important" href="#"  title="Set Market Parameters">
							<i class="metismenu-icon fa fa-universal-access"></i>
							Market Parameters
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
						</a>
						<ul>
							<li title="Set Trading Parameters">
								<a style="color:gray !important" href="'.site_url('admin/Tradingsettings').'">
									<i class="metismenu-icon"></i>
									Trading Parameters
								</a>
							</li>
							
							<li title="Define Market Orders">
								<a style="color:gray !important" href="'.site_url('admin/Ordertypes').'">
									<i class="metismenu-icon"></i>
									Define Market Orders
								</a>
							</li>
							
			';
							
			  echo '              
						</ul>
					</li>
			';
		}
		
		if ($SetParameters==1)//Settings
		{
			echo '
					<li>
						<a style="color:gray !important" href="#"  title="Set System Parameters">
							<i class="metismenu-icon pe-7s-config"></i>
							System Parameters
							<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
						</a>
						<ul>						
							<li title="Add States In Nigeria">
								<a style="color:gray !important" href="'.site_url('admin/States').'">
									<i class="metismenu-icon"></i>
									States In Nigeria
								</a>
							</li>
							
							 <li title="Set application settings">
								<a style="color:gray !important" href="'.site_url('admin/Settings').'">
									<i class="metismenu-icon"></i>
									Application Settings
								</a>
							</li>
							
							<li title="Set Paystack settings">
								<a style="color:gray !important" href="'.site_url('admin/Paystack').'">
									<i class="metismenu-icon"></i>
									Paystack Settings
								</a>
							</li>
							
							<li title="Add Countries Supported By Paystack">
								<a style="color:gray !important" href="'.site_url('admin/Paystackcountries').'">
									<i class="metismenu-icon"></i>
									Paystack Countries
								</a>
							</li>
							
							<li title="Get Paystack Banks">
								<a style="color:gray !important" href="'.site_url('admin/Paystackbanks').'">
									<i class="metismenu-icon"></i>
									Paystack Banks
								</a>
							</li>
							
							<li title="Create/Modify User Accounts">
								<a style="color:gray !important" href="'.site_url('admin/Users').'">
									<i class="metismenu-icon"></i>
									User Account
								</a>
							</li>
							
							 <li title="Backup Application Database">
								<a style="color:gray !important" onClick="DBbackup();" style="cursor:pointer;">
									<i class="metismenu-server"></i>
									Backup Database
								</a>
							</li>
							';
							
					if ($ClearLogFiles==1)
					{
						echo '
							<li title="Delete Log Files">
								<a style="color:gray !important" href="'.site_url('admin/Deletelogs').'">
									<i class="metismenu-icon"></i>
									Delete Log Files
								</a>
							</li>
						';
					}
					if ($ManageUsers==1)
					{
						echo '
							<li title="Manage All Users">
								<a style="color:gray !important" href="'.site_url('admin/ManageUsers').'">
									<i class="metismenu-icon"></i>
									Manage Users
								</a>
							</li>
						';
					}
							
							
			echo '           
						</ul>
					</li>
			';
		}	
	}
	
	
	if ($ViewReports==1)//Reports
	{		
		echo '
			<li>
				<a style="color:gray !important" href="#"  title="Reports">
					<i class="metismenu-icon pe-7s-graph2"></i>
					Reports
					<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
				</a>
				
				<ul>';
		
		if (trim(strtolower($usertype))=='gallery')
		{
			echo  '
				<li title="Listings Report">
					<a style="color:gray !important" href="'.site_url('admin/Listingsrep_gal').'">
						<i class="metismenu-icon"></i>
						Listings
					</a>
				</li>
			';	
		}
		
		if ((trim(strtolower($usertype))=='operator') Or (trim(strtolower($usertype))=='admin'))
		{
			echo '
				<li title="Secondary Trading Report">
					<a style="color:gray !important" href="'.site_url('admin/Secondarytradesrep_op').'">
						<i class="metismenu-icon"></i>
						Secondary Trades
					</a>
				</li>
				
				<li title="Primary Trading Report">
					<a style="color:gray !important" href="'.site_url('admin/Primarytradesrep_op').'">
						<i class="metismenu-icon"></i>
						Primary Trades
					</a>
				</li>
				
				<li title="Listings Report">
					<a style="color:gray !important" href="'.site_url('admin/Listingsrep_op').'">
						<i class="metismenu-icon"></i>
						Listings
					</a>
				</li>
				
				<li title="Issuers Payment Report">
					<a style="color:gray !important" href="'.site_url('admin/Issuerspaymentrep_op').'">
						<i class="metismenu-icon"></i>
						Issuers Payment
					</a>
				</li>
				
				<li title="Trade Orders Report">
					<a style="color:gray !important" href="'.site_url('admin/Tradeordersrep_op').'">
						<i class="metismenu-icon"></i>
						Trade Orders
					</a>
				</li>
				
				<li title="Asset Prices Report">
					<a style="color:gray !important" href="'.site_url('admin/Assetpricesrep_op').'">
						<i class="metismenu-icon"></i>
						Asset Prices
					</a>
				</li>
				
				<li>
					<a style="color:gray !important" href="#"  title="Trade Commissions">
						<i class="metismenu-icon fa fa-cogs"></i>
						Commissions
						<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
					</a>
					<ul>
						<li title="Brokers Commission Report">
							<a style="color:gray !important" href="'.site_url('admin/Brokersfeerep_op').'">
								<i class="metismenu-icon"></i>
								Brokers Commission
							</a>
						</li>
						
						<li title="NSE Commission Report">
							<a style="color:gray !important" href="'.site_url('admin/Nsefeerep_op').'">
								<i class="metismenu-icon"></i>
								NSE Commission
							</a>
						</li>           
					</ul>
				</li>
			';
		}
		
		if (trim(strtolower($usertype))=='admin')
		{
			echo '
				<li title="Registered Brokers Report">
					<a style="color:gray !important" href="'.site_url('admin/Registerbrokersrep_ad').'">
						<i class="metismenu-icon"></i>
						Registered Brokers
					</a>
				</li>
			';	
		}							

					
		if ($ViewLogReports==1)//View Log Reports
		{
			echo '
				<li title="View Log Report">
                    <a style="color:gray !important" href="'.site_url('admin/Logrep_ad').'">
                        <i class="metismenu-icon"></i>
                        Audit Trail
                    </a>
                </li>
				
				<li title="View Log Of Trading Activities">
                    <a style="color:gray !important" href="'.site_url('admin/Tradelogrep_ad').'">
                        <i class="metismenu-icon"></i>
                        Trade Activities
                    </a>
                </li>
			';
		}
					
					
					
					
echo '			</ul>
			</li>		
		';		
		
		
		
	}
?>      
                     
            </ul>
        </div>
        
        <center><img id="imgSideMenu" src="<?php echo base_url(); ?>images/smallheader.png" alt=""></center> 
         
    </div>
</div>


<!--**************Side Menu***************-->