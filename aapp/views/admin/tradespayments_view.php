<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Derived Homes - Trades Payments</title>
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
				width: 100%;
			}
		}
    </style>

	<script type = "text/javascript">
	
	var Title='<font color="#AF4442">Naija Art Mart Message</font>';
	var Email='<?php echo $email; ?>';
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

		$('#txtStartDate').datepicker({
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
		
		$('#txtStartDate').blur(function(e) {
			try
			{
				if ($('#txtStartDate').val() && $('#txtEndDate').val())
				{
					VerifyStartAndEndDates();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="Start Date Blur ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});
		
		$('#txtStartDate').change(function(e) {
			try
			{
				if ($('#txtStartDate').val() && $('#txtEndDate').val())
				{
					VerifyStartAndEndDates();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="Start Date Change ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});			

		$('#txtEndDate').datepicker({
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

		$('#txtEndDate').blur(function(e) 
		{
			try
			{
				if ($('#txtStartDate').val() && $('#txtEndDate').val())
				{
					VerifyStartAndEndDates();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="End Date Blur ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});
		
		$('#txtEndDate').change(function(e) 
		{
			try
			{
				if ($('#txtStartDate').val() && $('#txtEndDate').val())
				{
					VerifyStartAndEndDates();
				}	
			}catch(e)
			{
				$.unblockUI();
				m="End Date Change ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
				return false;
			}

		});
		
		function VerifyStartAndEndDates()
		{
			try
			{
				$('#divAlert').html('');
				
				var startdt=ChangeDateFrom_dMY_To_Ymd($('#txtStartDate').val());
				var enddt=ChangeDateFrom_dMY_To_Ymd($('#txtEndDate').val());
				var sdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
				var edt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
				var d;
				
				if ($('#txtStartDate').val()=='0000-00-00') $('#txtStartDate').val('');
				if ($('#txtEndDate').val()=='0000-00-00') $('#txtEndDate').val('');
				
				if ($('#txtStartDate').val())
				{
					if (!sdt.isValid())
					{
						m="Start Date Is Not Valid. Please Select A Valid Start Date.";
						
						DisplayMessage(m, 'error',Title);
					}	
				}
				
				
				if ($('#txtEndDate').val())
				{
					if (!edt.isValid())
					{
						m="End Date Is Not Valid. Please Select A Valid End Date.";
						DisplayMessage(m, 'error',Title);
					}	
				}
				
									
				//moment('2010-10-20').isSameOrBefore('2010-10-21');  // true				
				var dys=edt.diff(sdt, 'days') //If this -ve invalid date entries. Delivery earlier than pickup
				var diff = moment.duration(edt.diff(sdt));
				var mins = parseInt(diff.asMinutes());
				
				
				if (dys<0)
				{
					$('#txtEndDate').val('');
										
					m="End Date Is Before Start Date. Please Correct Your Entries!";
					DisplayMessage(m, 'error',Title);
				}
			}catch(e)
			{
				$.unblockUI();
				m="VerifyStartAndEndDates ERROR:\n"+e;				
				DisplayMessage(m, 'error',Title);
				return false;
			}
		}	
		
		LoadBrokers();
		LoadSymbols();
		
		$('#btnPDF').click(function(e) 
		{
			try
			{
				if (!CheckForm()) return false;
				
				$.blockUI({message:'<img src="<?php echo base_url();?>images/loader.gif" /><p>Generating Payments PDF Report. Please Wait...</p>',theme: false,baseZ: 2000});
				
				
				var buy=$.trim($('#cboBuyer').val());
				var sell=$.trim($('#cboSeller').val());
				var sym=$.trim($('#cboSymbol').val());				
				var sdt=ChangeDateFrom_dMY_To_Ymd($('#txtStartDate').val());
				var edt=ChangeDateFrom_dMY_To_Ymd($('#txtEndDate').val());
				var sd =moment(sdt.replace(new RegExp('-', 'g'), '/')).format("Do MMM YYYY");
				var ed =moment(edt.replace(new RegExp('-', 'g'), '/')).format("Do MMM YYYY");
				
				sd=sd.replace(new RegExp(' ', 'g'), '-');//' ','_'
				ed=ed.replace(new RegExp(' ', 'g'), '-');//' ','_'					
				
				var reportfile;
				
				if (sdt==edt)
				{
					reportfile="tradespaymentreport_"+sd+".pdf";
				}else
				{
					reportfile="tradespaymentreport_from_"+sd+'_to_'+ed+".pdf";
				}
				
				var msg;
									
				msg='Trades Payments Report';					
				
				if (sdt && edt)
				{
					if (sdt == edt)
					{
						msg = msg + ' For '+ $('#txtStartDate').val();
					}else
					{
						msg = msg + ' From '+ $('#txtStartDate').val() + ' - ' + $('#txtEndDate').val();
					}
				}	
				
				var mydata={buyer:buy,seller:sell,symbol:sym,startdate:sdt,enddate:edt,ReportTitle:msg};
															
				$.ajax({
					url: "<?php echo site_url('admin/Tradespayments/CreatePDFReport'); ?>",
					data: mydata,
					type: 'POST',
					dataType: 'text',
					complete: function(xhr, textStatus) {					
						$.unblockUI();
					},
					success: function(data,status,xhr) {
						$.unblockUI();
						
						var ret='';
						ret=$.trim(data);
	
						if (ret.toLowerCase() == $.trim(reportfile).toLowerCase())
						{
							window.open('<?php echo base_url(); ?>reports/'+reportfile,null,'left=0, top=0, height=700, width= 1000, status=no, resizable= yes, scrollbars= yes, toolbar= no,location= no, menubar= no');
						}else
						{
							m='Generating Of PDF Report Failed. Please Try Again.';
							m=m+'<br><br><b>'+ret+'</b>';
							DisplayMessage(m,'error',Title);
						}							
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
				m='PDF Report Button Click ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		});//btnPDF.click
		
		$('#btnExcel').click(function(e) 
		{
			try
			{
				if (!CheckForm()) return false;
				
				$.blockUI({message:'<img src="<?php echo base_url();?>images/loader.gif" /><p>Generating Trades Payments Excel Report. Please Wait...</p>',theme: false,baseZ: 2000});
				
				var buy=$.trim($('#cboBuyer').val());
				var sell=$.trim($('#cboSeller').val());
				var sym=$.trim($('#cboSymbol').val());
				var sdt=ChangeDateFrom_dMY_To_Ymd($('#txtStartDate').val());
				var edt=ChangeDateFrom_dMY_To_Ymd($('#txtEndDate').val());
				var sd =moment(sdt.replace(new RegExp('-', 'g'), '/')).format("Do MMM YYYY");
				var ed =moment(edt.replace(new RegExp('-', 'g'), '/')).format("Do MMM YYYY");
				
				sd=sd.replace(new RegExp(' ', 'g'), '-');//' ','_'
				ed=ed.replace(new RegExp(' ', 'g'), '-');//' ','_'					
				
				var reportfile;
				
				if (sdt==edt)
				{
					reportfile="tradespaymentreport_"+sd+".xls";
				}else
				{
					reportfile="tradespaymentreport_from_"+sd+'_to_'+ed+".xls";
				}

				var msg;
									
				msg='Trades Payments Report';					
				
				if (sdt && edt)
				{
					if (sdt == edt)
					{
						msg = msg + ' For '+ $('#txtStartDate').val();
					}else
					{
						msg = msg + ' From '+ $('#txtStartDate').val() + ' - ' + $('#txtEndDate').val();
					}
				}	
				
				var mydata={buyer:buy,seller:sell,symbol:sym,startdate:sdt,enddate:edt,ReportTitle:msg};
															
				$.ajax({
					url: "<?php echo site_url('admin/Tradespayments/CreateExcelReport'); ?>",
					data: mydata,
					type: 'POST',
					dataType: 'text',
					complete: function(xhr, textStatus) {					
						$.unblockUI();
					},
					success: function(data,status,xhr) {
						$.unblockUI();
						
						var ret='';
						ret=$.trim(data);
	
						if (ret.toLowerCase() == $.trim(reportfile).toLowerCase())
						{
							window.open('<?php echo base_url(); ?>reports/'+reportfile,null,'left=0, top=0, height=350, width= 500, status=no, resizable= yes, scrollbars= yes, toolbar= no,location= no, menubar= no');
						}else
						{
							m='Generating Of Excel Report Failed. Please Try Again.';
							m=m+'<br><br><b>'+ret+'</b>';
							DisplayMessage(m,'error',Title);
						}							
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
				m='Excel Report Button Click ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		});//btnExcel.click	

		$('#btnDisplay').click(function(e)
		{
			try
			{
				if (!CheckForm()) return false;
				
				var sdt=ChangeDateFrom_dMY_To_Ymd($('#txtStartDate').val());
				var edt=ChangeDateFrom_dMY_To_Ymd($('#txtEndDate').val());
				var buy=$.trim($('#cboBuyer').val());
				var sell=$.trim($('#cboSeller').val());
				var sym=$.trim($('#cboSymbol').val());
				
				DisplayReport(buy,sell,sym,sdt,edt);
			}catch(e)
			{
				$.unblockUI();
				m='Display Reports Button Click ERROR:\n'+e;				
				DisplayMessage(m, 'error',Title);
			}
		});
		
		function DisplayReport(buy,sell,sym,sdt,edt)
		{
			try
			{
				$.blockUI({message:'<img src="<?php echo base_url();?>images/loader.gif" /><p>Retrieving Payments Records. Please Wait...</p>',theme: false,baseZ: 2000});
					
				//Make Ajax Request
				var msg;
																		
				msg='Trades Payments Report';					
				
				if (sdt && edt)
				{
					if (sdt == edt)
					{
						msg = msg + ' For '+ $('#txtStartDate').val();
					}else
					{
						msg = msg + ' From '+ $('#txtStartDate').val() + ' To ' + $('#txtEndDate').val();
					}
				}
				
							
				var mydata={buyer:buy,seller:sell,symbol:sym,startdate:sdt,enddate:edt};	
				
				$('#recorddisplay > tbody').html('');
				
				$.ajax({
					url: "<?php echo site_url('admin/Tradespayments/DisplayReport');?>",
					data: mydata,
					type: 'POST',
					dataType: 'json',
					success: function(dataSet,status,xhr) {	
						$.unblockUI();
						
						if (table) table.destroy();
						
						//f-filtering, l-length, i-information, p-pagination
						table = $('#recorddisplay').DataTable( {
							dom: '<"top"if>rt<"bottom"lp><"clear">',
							responsive: true,
							ordering: false,
							autoWidth:false,
							language: {zeroRecords: "No Trade Payment Record Found"},
							lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],									
							columnDefs: [
								{
									"targets": [ 0,1,2,3,4,5,6,7,8,9,10 ],
									"visible": true
								},
								{
									"targets": [ 0,1,2,3,4,5,6,7,8,9,10 ],
									"orderable": true
								},
								{
									"targets": [ 0,1,2,3,4,5,6,7,8,9,10 ],
									"searchable": true
								},
								{ className: "dt-center", "targets": [ 0,1,2,3,4,5 ] },
								{ className: "dt-right", "targets": [ 6,7,8,9,10 ] }
							],					
							order: [[ 2, 'asc' ]],
							data: dataSet, 
							columns: [
								{ width: "8%" },//Trade Date
								{ width: "10%" },//Trade Id
								{ width: "10%" },//Buyer
								{ width: "10%" },//Seller
								{ width: "8%" },//Asset
								{ width: "8%" },//Tokens
								{ width: "8%" },//Price
								{ width: "10%" },//Trade Amount
								{ width: "10%" },//Broker Fee
								{ width: "10%" },//NSE Fee
								{ width: "8%" }//Transfer Fee
							],//8,10,10,10,8,8,8,10,10,10,8
						} );
						
						//Compute Total
						var price=0,amt=0,bfee=0,nsefee=0,tfee=0; 
						
						price=table.column(6).data().sum();
						amt=table.column(7).data().sum();
						bfee=table.column(8).data().sum();
						nsefee=table.column(9).data().sum();
						tfee=table.column(10).data().sum();
						
						if (parseInt(price) > 0) 
						{
							$('#tdPrice').html(number_format (price, 2, '.', ','));
						}else
						{
							$('#tdPrice').html('');
						}
						
						if (parseInt(amt) > 0)
						{
							$('#tdAmount').html(number_format (amt, 2, '.', ','));
						}else
						{
							$('#tdAmount').html('');
						}
						
						if (parseInt(bfee) > 0) 
						{
							$('#tdBroker').html(number_format (bfee, 2, '.', ','));
						}else
						{
							$('#tdBroker').html('');
						}
						
						if (parseInt(nsefee) > 0) 
						{
							$('#tdNSE').html(number_format (nsefee, 2, '.', ','));
						}else
						{
							$('#tdNSE').html('');
						}
						
						if (parseInt(tfee) > 0) 
						{
							$('#tdTransfer').html(number_format (tfee, 2, '.', ','));
						}else
						{
							$('#tdTransfer').html('');
						}
						
	
						AdminActivateTab('view');
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
				m='DisplayReport ERROR:\n'+e;
				DisplayMessage(m,'error',Title);
			}
		}
		
		function CheckForm()
		{
			try
			{
				var startdt=ChangeDateFrom_dMY_To_Ymd($('#txtStartDate').val());
				var enddt=ChangeDateFrom_dMY_To_Ymd($('#txtEndDate').val());
				var pdt = moment(startdt.replace(new RegExp('-', 'g'), '/'));
				var ddt = moment(enddt.replace(new RegExp('-', 'g'), '/'));
				var p=$.trim($('#txtStartDate').val());
				var d=$.trim($('#txtEndDate').val());
				var em='<?php echo $email; ?>';
									
			
				//User
				if (!em)
				{
					m='Current session has timed out. Refresh the window. If this message still comes up, sign out and sign in again before continuing with the reporting.';
					
					DisplayMessage(m, 'error',Title);
					return false;
				}			
										
				//Start date Not Select. End Date Selected
				if (!p)
				{
					m='You have not selected the report start date.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}
								
				if (!d)
				{
					m='You have not selected the report end date.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}
					
				if (!p && d)
				{
					m='You have selected the report end date. Report start date field must also be selected.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}
					
				//End date Not Select. Start Date Selected
				if (p && !d)
				{
					m='You have selected the report start date. Report end date field must also be selected.';
					
					DisplayMessage(m, 'error',Title);
					return false; 
				}
					
				if (p)
				{
					if (!pdt.isValid())
					{
						m="Report Start Date Is Not Valid. Please Select A Valid Report Start Date";
						DisplayMessage(m, 'error',Title);
						return false;
					}	
				}
					
				if (d)
				{
					if (!ddt.isValid())
					{
						m="Report End Date Is Not Valid. Please Select A Valid Report End Date";
						DisplayMessage(m, 'error',Title);						
						return false;
					}	
				}
								
				if (p && d)
				{
					var dys=ddt.diff(pdt, 'days') //If this -ve invalid date entries. Delivery earlier than pickup
					
					if (dys<0)
					{
						m="Report End Date Is Before The Report Start Date. Please Correct Your Entries!";
						DisplayMessage(m, 'error',Title);
						return false;
					}
				}			
				
				return true;
			}catch(e)
			{
				$.unblockUI();
				m="CheckForm ERROR:\n"+e;
				DisplayMessage(m, 'error',Title);
			}
		}//End CheckForm
    });//Document Ready
	
	function LoadBrokers()
	{
		try
		{
			$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Sellers And Buyer. Please Wait...</p>',theme: false,baseZ: 2000});				

			$('#cboBuyer').empty();		
			$('#cboSeller').empty();		

			$.ajax({
				url: "<?php echo site_url('admin/Tradespayments/GetBrokers');?>",
				type: 'POST',
				dataType: 'json',
				success: function(data,status,xhr) {	
					$.unblockUI();

					if ($(data).length > 0)
					{
						$("#cboBuyer").append(new Option("[ALL BUYERS]", ""));
						$("#cboSeller").append(new Option("[ALL SELLERS]", ""));
						
						$.each($(data), function(i,e)
						{
							if (e.company && e.broker_id)
							{
								$("#cboBuyer").append(new Option($.trim(e.company), $.trim(e.broker_id)));
								$("#cboSeller").append(new Option($.trim(e.company), $.trim(e.broker_id)));
							}
						});//End each
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
			m='LoadBrokers ERROR:\n'+e;
			DisplayMessage(m, 'error',Title);
		}
	}
	
	function LoadSymbols()
	{
		try
		{
			$.blockUI({message: '<img src="<?php echo base_url();?>images/loader.gif" /><p>Loading Symbol. Please Wait...</p>',theme: false,baseZ: 2000});				

			$('#cboSymbol').empty();		

			$.ajax({
				url: "<?php echo site_url('admin/Tradespayments/GetSymbols');?>",
				type: 'POST',
				dataType: 'json',
				success: function(data,status,xhr) {	
					$.unblockUI();

					if ($(data).length > 0)
					{
						$("#cboSymbol").append(new Option("[ALL ASSETS]", ""));
						
						$.each($(data), function(i,e)
						{
							if (e.symbol && e.title)
							{
								$("#cboSymbol").append(new Option($.trim(e.title)+' (' + $.trim(e.symbol)+')', $.trim(e.symbol)));
							}
						});//End each
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
			m='LoadSymbols ERROR:\n'+e;
			DisplayMessage(m, 'error',Title);
		}
	}

//company,address,state,email,phone,incorporationdate,broker_id,accountstatus,id
	function SelectRow(cm,add,st,em,ph,dt,bid,sta,id)
	{
		try
		{
			ResetControls();
			
			if (document.getElementById('btnEdit')) document.getElementById('btnEdit').disabled=false;
			if (document.getElementById('btnAdd')) document.getElementById('btnAdd').disabled=true;

			$('#txtCompanyName').val(cm);
			$('#txtAddress').val(add);
			$('#cboState').val(st);
			$('#txtEmail').val(em);
			$('#txtPhone').val(ph);
			$('#txtDate').val(dt);
			$('#txtCode').val(bid);
			$('#cboStatus').val(sta);
			$('#hidId').val(id);

			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m='SelectRow ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}

//company,broker_id,accountstatus,id
	function DeleteRow(cm,bid,sta,id)
	{			
		try
		{
			if (!Email)
			{
				m='There is a problem with the selected row. Click on REFRESH button to refresh the page. If this message keeps coming up, please contact us at support@naijaartmart.com.';
				
				DisplayMessage(m,'error',Title);
				return false;
			}else
			{
				Swal.fire({
				  title: 'PLEASE CONFIRM',
				  html: "<font size='3' face='Arial'>Do you want to delete this broker's record from the database?. Please note that this action is irreversible.</font>",
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonText: '<font size="3" face="Arial">No</font>',
				  confirmButtonText: '<font size="3" face="Arial">Yes, Delete!</font>'
				}).then((result) => {
				  if (result.value)
				  {
					$.blockUI({message: "<img src='<?php echo base_url();?>images/loader.gif' /><p>Deleting Broker's Record. Please Wait...</p>",theme: false,baseZ: 2000});
					
					$('#divAlert').html('');
					
					m=''
					
					//Make Ajax Request			
					$.ajax({
						url: '<?php echo site_url('admin/Registerbroker/DeleteBroker'); ?>',
						data: {company:cm,broker_id:bid,id:id},
						type: 'POST',
						dataType: 'json',
						success: function(data,status,xhr) {				
							$.unblockUI();
							
							if ($(data).length > 0)
							{
								$.each($(data), function(i,e)
								{
									if ($.trim(e.status).toUpperCase() == 'OK')
									{
										ResetControls();									
										LoadBrokers();
										
										m='Broker was deleted successfully.';
										
										DisplayMessage(m, 'success','Broker Deleted','SuccessTheme');
								
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
										
										DisplayMessage(m,'error',Title);		
									}
									
									return;
								});//End each
							}
						},
						error:  function(xhr,status,error) {
							m='Error '+ xhr.status + ' Occurred: ' + error
							DisplayMessage(m,'error',Title);
						}
					});
				  }
				})				
			}
		}catch(e)
		{
			$.unblockUI();
			m='Delete Broker Button Click ERROR:\n'+e;
			DisplayMessage(m,'error',Title);
		}
	}
	
	function ResetControls()
	{
		try
		{					
			if (document.getElementById('btnEdit')) document.getElementById('btnEdit').disabled=true;
			if (document.getElementById('btnAdd')) document.getElementById('btnAdd').disabled=false;
			
			$('#txtCompanyName').val('');
			$('#txtAddress').val('');
			$('#cboState').val('');
			$('#txtEmail').val('');
			$('#txtPhone').val('');
			$('#txtDate').val('');
			$('#txtCode').val('');
			$('#cboStatus').val('');
			$('#txtPwd').val('');
			$('#txtConfirmPwd').val('');
			$('#hidId').val('');
			
			AdminActivateTab('data');
		}catch(e)
		{
			$.unblockUI();
			m="ResetControls ERROR:\n"+e;
			DisplayMessage(m,'error',Title);
		}
	}//End ResetControls
	
		
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
                                                    Trades Payments
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
                            <a role="tab" class="nav-link active" id="tabData" data-toggle="tab" href="#data">
                                <span>Report Parameters</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tabView" data-toggle="tab" href="#view">
                                <span>View Payments Report</span>
                            </a>
                        </li>
                        <li onClick="window.location.reload(true);" class="nav-item">
                            <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#refresh">
                                <span>Refresh</span>
                            </a>
                        </li>
                    </ul>
                    
                    
                    <div class="tab-content">
                        <div class="tab-pane tabs-animation fade show active" id="data" role="tabpanel">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <form class="">
                                    	<input id="hidId" type="hidden" />
                                        
                                        <!--Seller-->
                                        <div title="Selling Broker" class="position-relative row form-group">
                                        	<label for="cboSeller" class="col-sm-2 col-form-label">Selling Broker</label>
                                            
                                            <div class="col-sm-10">
                                            	<select class="form-control" id="cboSeller"></select>
                                             </div>
                                        </div>
                                        
                                        
                                        <!--Buyer-->
                                        <div title="Buying Broker" class="position-relative row form-group">
                                        	<label for="cboBuyer" class="col-sm-2 col-form-label">Buying Broker</label>
                                            
                                            <div class="col-sm-10">
                                            	<select class="form-control" id="cboBuyer"></select>
                                             </div>
                                        </div>
                                        
                                        
                                         <!--Asset-->
                                        <div title="Trade Asset" class="position-relative row form-group">
                                        	<label for="cboSymbol" class="col-sm-2 col-form-label">Asset</label>
                                            
                                            <div class="col-sm-10">
                                            	<select class="form-control" id="cboSymbol"></select>
                                             </div>
                                        </div>                                        
                                        
                                        
                                        
                                        <!--Report Start Date-->
                                        <div title="Report Start Date" class="position-relative row form-group">
                                         	<label for="txtStartDate" class="col-sm-2 col-form-label">Report Start Date<span class="redtext">*</span></label>
                                            
                                            <div class="col-sm-4 date datepicker">
                                            <div class="input-group">
                                                <input style="background:#ffffff; cursor:default;" readonly id="txtStartDate" placeholder="Report Start Date" type="text" class="form-control">
                                                
                                                <span class="input-group-btn"><button style="border-radius:0;" class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                            </div>
                                         </div>
                                       </div>
                                        
                                                                               
                                         <!--Report End Date-->
                                        <div title="Report End Date" class="position-relative row form-group">
                                         	<label for="txtEndDate" class="col-sm-2 col-form-label">Report End Date<span class="redtext">*</span></label>
                                            
                                            <div class="col-sm-4 date datepicker">
                                            <div class="input-group">
                                                <input style="background:#ffffff; cursor:default;" readonly id="txtEndDate" placeholder="Report End Date" type="text" class="form-control">
                                                
                                                <span class="input-group-btn"><button style="border-radius:0;" class="btn btn-nse-green" type="button"><i class="fa fa-calendar size-21"></i></button></span>
                                            </div>
                                         </div>
                                       </div>                                        
                                    </form>
                                </div> 
                                
                                <div id="divAlert" data-type="info" class="btn-show-swal"></div>                               
                            </div>
                        </div>
                        
                        <!--Buttons-->
                                <div class="position-relative row form-group">
                                     <!--Buttond-->
                                     <div class="col-sm-12">
                                         <div align="center">
                                            <button id="btnDisplay" type="button" class="btn btn-nse-green"><span class="fa fa-play-circle size-18 makebold" ></span> Display Report</button>
                         
                            <button style="margin-left:10px;" id="btnExcel" type="button" class="btn btn-primary"><i class="fa fa-file-excel size-18 makebold"></i> Export As Excel</button>
                        
                            <button style="margin-left:10px;" id="btnPDF" type="button" class="btn btn-danger"><i class="fa fa-file-pdf size-18 makebold"></i> Export As PDF</button>
                            
                            <button style="margin-left:10px; color:#FFFFFF;" id="btnRefresh" type="button" class="btn btn-warning" onClick="window.location.reload(true);"><i class="fa pe-7s-refresh-2 size-18 makebold" ></i> Refresh</button>
                                        </div>    
                                     </div>
                                </div>
                        
                        <div class="tab-pane tabs-animation fade" id="view" role="tabpanel">
                        	<div class="row">
                            	<div class="col-md-12">
                                	<div class="mb-3 card">
                                        <div class="card-body">
                                           <table class="hover table table-bordered data-table display wrap " id="recorddisplay">
                                              <thead style="color:#ffffff; background-color:#7E7B7B;">
                                                <tr>
                                                    <th style="text-align:center" width="8%">TRADE&nbsp;DATE</th>
                                                    <th style="text-align:center" width="10%">TRADE&nbsp;ID</th>
                                                    
                                                    <th style="text-align:center" width="10%">BUYER</th>
                                                    <th style="text-align:center" width="10%">SELLER</th>
                                                    
                                                    <th style="text-align:right"  width="8%">ASSET</th>
                                                    <th style="text-align:center" width="8%">TOKENS</th>
                                                    <th style="text-align:right" width="8%">PRICE(₦)</th>
                                                    <th style="text-align:right"  width="10%">TRADE&nbsp;AMOUNT(₦)</th>
                                                    <th style="text-align:right" width="10%">BROKER&nbsp;FEE(₦)</th>
                                                    <th style="text-align:right" width="10%">NSE&nbsp;FEE(₦)</th>
                                                    <th style="text-align:right"  width="8%">TRANSFER&nbsp;FEE(₦)</th>
                                                </tr>
                                              </thead>
        
                                              <tbody id="tbbody"></tbody>
                                          
                                                <tfoot style="color:#ffffff; background-color:#7E7B7B;">
                                                    <tr>
                                                        <th colspan="6" style="text-align:right; padding:3px; padding-right:10px; font-weight:bold; font-size:13px;" width="54%">TOTAL AMOUNT/FEES (₦):</th>
                                                        
                                                        <th id="tdPrice" style="text-align:right; padding:3px; padding-right:8px; font-weight:bold; font-size:12px;" width="8%"></th>
                                                        
                                                        <th id="tdAmount" style="text-align:right; padding:3px; padding-right:8px; font-weight:bold; font-size:12px;" width="10%"></th>
                                                        
                                                        <th id="tdBroker" style="text-align:right; padding:3px; padding-right:8px; font-weight:bold; font-size:12px;" width="10%"></th>
                                                        
                                                        <th id="tdNSE" style="text-align:right; padding:3px; padding-right:8px; font-weight:bold; font-size:12px;" width="10%"></th>
                                                        
                                                        <th id="tdTransfer" style="text-align:right; padding:3px; padding-right:8px; font-weight:bold; font-size:12px;" width="8%"></th>
                                                    </tr>
                                              </tfoot>
                                            </table>                                           
                                        </div>
                                    </div> 
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

<script type="text/javascript" src="<?php echo base_url();?>assets/js/main.8d288f825d8dffbbe55e.js"></script>



</body>
</html>
