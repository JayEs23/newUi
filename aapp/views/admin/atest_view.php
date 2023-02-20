<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<!--[if !(IE 6) | !(IE 7) | !(IE 8)]><!-->
<html lang="en-GB" class="no-js">
  <!--<![endif]-->

  <!--    Sun, 12 Jan 2020 04:31:08 GMT -->
  <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
  
    <title>Naija Art Mart – Test</title>

	<?php include('reportsheader.php'); ?>
    <?php include('reportscripts.php'); ?>
  
  </head>
  
  <body style="margin-top:30px;">
    <div class="container-fluid">					
      <div class="row col-sm-12">
         <form class="">                                   
             <div class="position-relative row form-group">
                <div class="col-sm-12">
                 <?php
				 	print_r($GLOBALS['OrderBook']); return;
					$symbol=''; $buy=array(); $sell=array();
					
					if (count($OrderBook) > 0)
					{
						$symbol=$OrderBook['Symbol'];
						$buy=$OrderBook['Buy'];
						$sell=$OrderBook['Sell'];
						//print_r($buy);return;
						echo '<p align="center" class="size-22" style="font-weight:bold;">ASSET: <span class="redtext">'.strtoupper($symbol).'</span></p>';
						
						echo '<span> <span style="font-weight:bold; Margin-right:20px;">ORDER BOOK:  </span> <span style="font-weight:bold; color:#A00;">SELL ORDERS</span> <span style="float:right; margin-right:10px; font-weight:bold; color:#00A;">BUY ORDERS</span></span>';
						
						$table='<table align="center" width="100%" style="width:100%; background:#707331; height:auto">';
						
						//Ask - Red
						$tabSell='<table width="100%" class="hover sell-table-striped table table-bordered data-table display wrap">
							<thead>
								<tr style="background:#413A3A; color: #ffffff;">
									<th style="width:15; text-align:center;%">Order ID</th>
									<th style="width:30%; text-align:center;">Broker ID</th>
									<th style="width:15%; text-align:center;">Qty</th>
									<th style="width:20%; text-align:right;">Price</th>														
									<th style="width:20%; text-align:center;">Cummulative Qty</th>
								</tr>
							</thead>
						';
						
						//Bid - Blue											
						$tabBuy='<table style="width:100%;" class="hover buy-table-striped table table-bordered data-table display wrap">
							<thead>
								<tr style="background:#413A3A; color: #ffffff;">
									<th style="width:15%; text-align:center;">Order ID</th>
									<th style="width:30; text-align:center;%">Broker ID</th>
									<th style="width:15; text-align:center;%">Qty</th>
									<th style="width:20%; text-align:right;">Price</th>														
									<th style="width:20%; text-align:center;">Cummulative Qty</th>
								</tr>
							</thead>
						';
						
						//Buy
						foreach($buy as $row):
							$tabBuy .= '
								<tr title="Order To Buy '.$row['Qty'].' Tokens Of '.$symbol.' At ₦'.$row['price'].' Per Token By '.$row['broker_id'].'">
									<td style="text-align:center;">'.$row['order_id'].'</td>
									<td style="text-align:center;">'.$row['broker_id'].'</td>
									<td style="text-align:center;">'.number_format($row['Qty'],0).'</td>
									<td style="text-align:right;">'.number_format($row['price'],2).'</td>														
									<td style="text-align:center;">'.number_format($row['total_qty'],0).'</td>
								</tr>
							';
						endforeach;
						
						//Sell
						foreach($sell as $row):
							$tabSell .= '
								<tr title="Order To Sell '.$row['Qty'].' Tokens Of '.$symbol.' At ₦'.$row['price'].' Per Token By '.$row['broker_id'].'">
									<td style="text-align:center;">'.$row['order_id'].'</td>
									<td style="text-align:center;">'.$row['broker_id'].'</td>
									<td style="text-align:center;">'.number_format($row['Qty'],0).'</td>
									<td style="text-align:right;">'.number_format($row['price'],2).'</td>														
									<td style="text-align:center;">'.number_format($row['total_qty'],0).'</td>
								</tr>
							';
						endforeach;
						
						$tabSell .= '</table>';
						$tabBuy .= '</table>';
						
						$table .= '
							<tr>
								<td valign="top" style="width:49.5%;">'.$tabSell.'</td>
								<td valign="top" style="width:5px; "></td>
								<td valign="top" style="width:49.5%;">'.$tabBuy.'</td>
							</tr>
						</table>';
					}
					
					print_r($table);
				?>        
                 </div>
            </div>
        </form>
     </div>
   </div>
  </body>
</html>
