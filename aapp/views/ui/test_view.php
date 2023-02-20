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
  
    <title>Naija Art Market – Test</title>

	<?php //include('reportsheader.php'); ?>
    <?php //include('reportscripts.php'); ?>
  
  </head>
  
  <body style="margin-top:30px;">
    <div class="container-fluid">					
      <div class="row col-sm-12">
         <form class="">                                   
             <div class="position-relative row form-group">
                <div class="col-sm-12" style="overflow:auto; height:600px;">
                 <?php
				 	
					//echo 'DONE';
					print_r($users); exit();
					
					if ($asset['status']==1)
					{
						echo 'ART ID: '.$asset['artId'].'<br>'.
						 'ARTIST NAME: '.$asset['artistName'].'<br>'.
						 'ARTWORK TITLE: '.$asset['artTitle'].'<br>'.
						 'SYMBOL: '.$asset['artSymbol'].'<br>'.				 
						 'DESCRIPTION: '.$asset['artDescription'].'<br>'.
						 'CREATION YEAR: '.$asset['artCreationYear'].'<br>'.
						 'ARTWORK VALUE: ₦'.number_format($asset['artValue'],2).'<br>'.
						 'NO. OF TOKENS: '.number_format($asset['numberOfTokens'],0).'<br>'.
						 'TOKENS FOR SALE: '.number_format($asset['numberOfTokensForSale'],0).'<br>'.
						 'PRICE PER TOKEN: ₦'.number_format($asset['pricePerToken'],2).'<br>'.
						 'ARTWORK PICTURE: '.$asset['artPicture'].'<br>'.
						 'BLOCKCHAIN URL: '.$asset['blockchainUrl'].'<br>'.
						 'ISSUER EMAIL: '.$asset['issuerEmail'].'<br>';
					}else
					{
						if (count($asset) > 0)
						{
							echo 'STATUS CODE: '.$asset['code'].'<br>'.
							 'ERROR MESSAGE: '.$asset['message'].'<br>'.
							 'DATE/TIME: '.$asset['datetime'].'<br>'.
							 'PATH: '.$asset['path'].'<br>';	
						}						
					}
					
					if ($user['status']==1)
					{
						echo 'USER ID: '.$user['userId'].'<br>'.
							 'USER TYPE: '.$user['userType'].'<br>'.
							 'USER NAME: '.$user['userName'].'<br>'.				 
							 'EMAIL: '.$user['email'].'<br>'.
							 'PHONE: '.$user['phone'].'<br>'.
							 'BLOCKCHAIN ADDRESS: '.$user['blockchainAddress'].'<br>';
					}else
					{
						if (count($user) > 0)
						{
							echo 'STATUS CODE: '.$user['code'].'<br>'.
								 'ERROR MESSAGE: '.$user['message'].'<br>'.
								 'DATE/TIME: '.$user['datetime'].'<br>'.
								 'PATH: '.$user['path'].'<br>';	
						}						
					}
					
					return;
					
					if (is_array($OrderBook))
					{
						$symbol=''; $buy=array(); $sell=array();
						
						if (count($OrderBook) > 0) $symbol=$OrderBook['Symbol'];
						
						if (count($OrderBook['Buy'])) $buy=$OrderBook['Buy'];
						if (count($OrderBook['Sell'])) $sell=$OrderBook['Sell'];						
						
						//print_r($buy);return;
						echo '<p align="center" class="size-22" style="font-weight:bold;">ASSET: <span class="redtext">'.strtoupper($symbol).'</span></p>';
						
						echo '<span> <span style="font-weight:bold; Margin-right:20px;">ORDER BOOK:  </span> <span style="font-weight:bold; color:#A00;">SELL ORDERS</span> <span style="float:right; margin-right:10px; font-weight:bold; color:#00A;">BUY ORDERS</span></span>';
						
						$table='<table align="center" width="100%" style="width:100%; background:#707331; height:auto">';
						
						//Ask - Red
						$tabSell='<table width="100%" class="hover sell-table-striped table table-bordered data-table display wrap">
							<thead>
								<tr style="background:#413A3A; color: #ffffff;">
									<th style="width:28%; text-align:center;">Submit Date & Time</th>
									<th style="width:17; text-align:center;%">Order ID</th>
									<th style="width:25%; text-align:center;">Broker ID</th>
									<th style="width:15%; text-align:center;">Qty</th>
									<th style="width:15%; text-align:right;">Price</th>														
								</tr>
							</thead>
						';
						
						//Bid - Blue											
						$tabBuy='<table style="width:100%;" class="hover buy-table-striped table table-bordered data-table display wrap">
							<thead>
								<tr style="background:#413A3A; color: #ffffff;">
									<th style="width:28%; text-align:center;">Submit Date & Time</th>
									<th style="width:17%; text-align:center;">Order ID</th>
									<th style="width:25; text-align:center;%">Broker ID</th>
									<th style="width:15; text-align:center;%">Qty</th>
									<th style="width:15%; text-align:right;">Price</th>
								</tr>
							</thead>
						';
						
						//Buy
						foreach($buy as $row):
							$tabBuy .= '
								<tr title="Order To Buy '.$row['available_qty'].' Tokens Of '.$symbol.' At ₦'.$row['price'].' Per Token By '.$row['broker_id'].'">
									<td style="text-align:center;">'.$row['orderdate'].' '.$row['ordertime'].'</td>
									<td style="text-align:center;">'.$row['order_id'].'</td>
									<td style="text-align:center;">'.$row['broker_id'].'</td>
									<td style="text-align:center;">'.number_format($row['available_qty'],0).'</td>
									<td style="text-align:right;">'.number_format($row['price'],2).'</td>
								</tr>
							';
						endforeach;
						
						//Sell
						foreach($sell as $row):
							$tabSell .= '
								<tr title="Order To Sell '.$row['available_qty'].' Tokens Of '.$symbol.' At ₦'.$row['price'].' Per Token By '.$row['broker_id'].'">
									<td style="text-align:center;">'.$row['orderdate'].' '.$row['ordertime'].'</td>
									<td style="text-align:center;">'.$row['order_id'].'</td>
									<td style="text-align:center;">'.$row['broker_id'].'</td>
									<td style="text-align:center;">'.number_format($row['available_qty'],0).'</td>
									<td style="text-align:right;">'.number_format($row['price'],2).'</td>
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
						
						print_r($table);	
					}else
					{
						print_r($OrderBook);
					}					
				?>        
                 </div>
            </div>
        </form>
     </div>
   </div>
  </body>
</html>
