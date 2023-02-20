<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Tradespayments extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	 }
	 
	function GetBrokers()
	{
		$sql="SELECT DISTINCT company,broker_id FROM brokers ORDER BY company";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetBrokers
	
	function GetSymbols()
	{
		$sql="SELECT symbol,(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(listed_artworks.symbol)) AS title FROM listed_artworks ORDER BY title";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetSymbols
	
	function CreateExcelReport()
	{
		$buyer=''; $seller=''; $symbol=''; $startdate=''; $enddate=''; $period=''; $ReportTitle='';
		
		if ($this->input->post('buyer')) $buyer = trim($this->input->post('buyer'));
		if ($this->input->post('seller')) $seller = trim($this->input->post('seller'));
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));	
		if ($this->input->post('startdate')) $startdate = $this->input->post('startdate');
		if ($this->input->post('enddate')) $enddate = $this->input->post('enddate');
		if ($this->input->post('ReportTitle')) $ReportTitle = $this->input->post('ReportTitle');
		
		$dstart=date("d M Y",strtotime($startdate));
		$dend=date("d M Y",strtotime($enddate));
		
		$dstart=date("jS M Y",strtotime($startdate));
		$dend=date("jS M Y",strtotime($enddate));

		if ($dstart==$dend)
		{
			$period=$dstart;
		}else
		{
			$period=$dstart.' - '.$dend;
		}
		
		if ($startdate==$enddate)
		{
			if (strtolower(trim($_SERVER['HTTP_HOST']))=='localhost')
			{
				$outputfile=FCPATH."reports\tradespaymentreport_".str_replace(' ','-',$dstart).".xls";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile=FCPATH."reports/tradespaymentreport_".str_replace(' ','-',$dstart).".xls";
			}
			
			$filename="tradespaymentreport_".str_replace(' ','-',$dstart).".xls";
		}else
		{
			if (strtolower(trim($_SERVER['HTTP_HOST']))=='localhost')
			{
				$outputfile=FCPATH."reports\tradespaymentreport_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".xls";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile=FCPATH."reports/tradespaymentreport_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".xls";
			}
			
			$filename="tradespaymentreport_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".xls";
		}
		
		$xls_file=$filename;
		
		$Payments=array();
				
		$qry = "SELECT * FROM trades_payments WHERE (DATE_FORMAT(transfer_date,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') ";
		
		//if (isset($buyer)) $qry .= " AND (TRIM(buy_broker_id)='".$buyer."')";
		//if (isset($seller)) $qry .= " AND (TRIM(sell_broker_id)='".$seller."')";
		if (isset($symbol)) $qry .= " AND (TRIM(symbol)='".$symbol."')";
		
		$qry .= " ORDER BY transfer_date";

		$query = $this->db->query(stripslashes($qry));		
		$Payments = $query->result_array();
						
		if ($query->num_rows() == 0 )
		{		
			if ($startdate and $enddate)
			{
				echo "There is no trade payment record for the selected period.";
			}else
			{
				echo "There is no trade payment record.";
			}
		}else
		{				
		############################################# START REPORT HERE #################
			if (count($Payments) > 0)
			{
				//$logo=dirname(__FILE__).'/images/emaillogo.png';
				$logo='images/logo.png';
				$company='Naija Art Mart';
				
				//Get client logo
				$clientlogo='';				
				//$cl=$this->getdata_model->GetUserLogo($company);//   
				
				//if ($cl) $clientlogo = dirname(__FILE__).'images/'.$cl;
				
								
				#Create new PHPExcel object
				$objPHPExcel = new PHPExcel();
				
				$objPHPExcel->getProperties()->setCreator("Naija Art Mart")
											 ->setLastModifiedBy("Naija Art Mart")
											 ->setTitle($ReportTitle)
											 ->setSubject($ReportTitle)
											 ->setDescription($ReportTitle)
											 ->setKeywords("Trades Payments Report,Payments,Trades")
											 ->setCategory("Trades Payments Report");
				
				$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
				//$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
				//$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
				//$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
				
				$margin = 0.5; #Margin is set in inches (0.5cm)
				
				$objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($margin);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);				
				
				$objPHPExcel->setActiveSheetIndex(0);
				
				#Add Client Logo
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName($company.' Logo');
				$objDrawing->setDescription($company.' Logo');
				$objDrawing->setPath($logo);
				$objDrawing->setCoordinates('A1');
				$objDrawing->setResizeProportional(false);
				$objDrawing->setHeight(70);
				$objDrawing->setWidth(70);
				$objDrawing->setOffsetX(1);
				$objDrawing->setOffsetY(1);
				$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
				
					
				#A to K
				$styleArray = array('font' => array('bold' => true));
				
				$objPHPExcel->getActiveSheet()->setCellValue('A4','');
				$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
				
				$objPHPExcel->getActiveSheet()->getStyle('A1:K1')
											  ->getAlignment()
											  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setSize(14);
				
				
				$objPHPExcel->getActiveSheet()->setCellValue('A2','')
											  ->mergeCells('A2:K2');
								
				$objPHPExcel->getActiveSheet()->setCellValue('A3','')
											  ->mergeCells('A3:K3');	
				
				$styleArray = array(
					'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '000000'),
					'size'  => 14,
					'name'  => 'Calibri'
				));
				
				$objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($styleArray);
						
				$objPHPExcel->getActiveSheet()->setCellValue('A4',strtoupper($ReportTitle))
											  ->mergeCells('A4:K4');
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				#HEADING
				$objPHPExcel->getActiveSheet()->setCellValue('A5', "TRADE DATE")
									  ->setCellValue('B5', "TRADE ID")
									  ->setCellValue('C5', "BUYER")
									  ->setCellValue('D5', "SELLER")
									  ->setCellValue('E5', "ASSET")
									  ->setCellValue('F5', "NO. OF TOKENS")
									  ->setCellValue('G5', "PRICE")
									  ->setCellValue('H5', "TRADE AMOUNT")
									  ->setCellValue('I5', "BROKER FEE")
									  ->setCellValue('J5', "NSE FEE")
									  ->setCellValue('K5', "TRANSFER FEE");
					
				$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$objPHPExcel->getActiveSheet()->getStyle('G5:K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				$objPHPExcel->getActiveSheet()->getStyle('A5:K5')->applyFromArray($styleArray);	
				$objPHPExcel->getActiveSheet()->getStyle('A5:K5')->getFont()->setSize(10);
													  
				$objPHPExcel->getActiveSheet()->getStyle('A5:K5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle('A5:K5')->getFill()->getStartColor()->setRGB('3D3E11');
				$objPHPExcel->getActiveSheet()->getStyle('A5:K5')->getFont()->setBold(true);	
									
				$styleArrayWhite = array(
					'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => 'FFFFFF'),
					'size'  => 10,
					'name'  => 'Calibri'
				));				  
				
				
				$objPHPExcel->getActiveSheet()->getStyle('A5:K5')->applyFromArray($styleArrayWhite);				
				$objPHPExcel->getActiveSheet()->getStyle('A5:K5')->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle('A5:K5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				$i=5; $total=0;

				$styleArrayBlack = array(
					'font'  => array(
					'bold'  => false,
					'color' => array('rgb' => '000000'),
					'size'  => 10,
					'name'  => 'Calibri'
				));
				
				$tamt=0; $tf=0; $nf=0; $bc=0; $pr=0;
				
				foreach($Payments as $k => $v):
					$i++;
					
					$sn++; $dt=''; $amt=''; $tid=''; $bid=''; $sid=''; $sym='';
					$tok=''; $pr=''; $bc=''; $nf=''; $tf='';
					
					if ($v['trade_id']) $tid = $v['trade_id'];
					//if ($v['buy_broker_id']) $bid = $v['buy_broker_id'];
					//if ($v['sell_broker_id']) $sid = $v['sell_broker_id'];
					if ($v['symbol']) $sym = $v['symbol'];
					
					if ($v['transfer_date']) $dt=date('d M Y',strtotime($v['transfer_date']));
					$amt=floatval($v['num_tokens']) * floatval($v['price']);
					
					if ($v['num_tokens']) $tok = $v['num_tokens'];
					
					if ($v['transfer_fees'])
					{
						$tfee += $v['transfer_fees'];
						$tf=$v['transfer_fees'];
					}
					
					if ($v['nse_commission'])
					{
						$nfee += $v['nse_commission'];
						$nf=$v['nse_commission'];
					}
					
					if ($v['broker_commission'])
					{
						$bfee += $v['broker_commission'];
						$bc=$v['broker_commission'];
					}
					
					$tamt += floatval($v['num_tokens']) * floatval($v['price']);
					
					if ($v['price'])
					{
						$tprice += $v['price'];
						$pr = $v['price'];
					}
																
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $dt);
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $tid);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $bid);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $sid);
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $sym);
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $tok);
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, '₦ '.$pr);
					$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, '₦ '.$amt);
					$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, '₦ '.$bc);
					$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, '₦ '.$nf);
					$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, '₦ '.$tf); 
					
					//Wrap Text
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':K'.$i)->getAlignment()->setWrapText(true);
					#Value Format
																						
					$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getNumberFormat()
								->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);						
			
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					$objPHPExcel->getActiveSheet()->getStyle('G'.':K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':K'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':K'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':K'.$i)->getFill()->getStartColor()->setRGB('FFFFFF');
					
					$styleArray = array(
						'font'  => array(
						'bold'  => false,
						'color' => array('rgb' => '000000'),
						'size'  => 10,
						'name'  => 'Calibri'
					));
						
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':K'.$i)->applyFromArray($styleArrayBlack);	
				endforeach;
				
				//Dimensions
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
				
				$i++;
				
				$tfee=number_format($tfee,2);
				$nfee=number_format($nfee,2);
				$bfee=number_format($bfee,2);
				$tprice=number_format($tprice,2);
				$tamt=number_format($tamt,2);
				
				#FOOTER
				
				//Merge Agenda Column
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,"TOTAL PAYMENTS/FEES: ")
											  ->mergeCells('A'.$i.':F'.$i);
											  
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':K'.$i)->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, '₦ '.$tprice);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, '₦ '.$tamt);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, '₦ '.$bfee);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, '₦ '.$nfee);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, '₦ '.$tfee);
								
				$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getNumberFormat()
								->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
									
													  
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':K'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':K'.$i)->getFill()->getStartColor()->setRGB('3D3E11');
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':K'.$i)->applyFromArray($styleArrayWhite);
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':K'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				
				
				$styleArray = array(
					  'borders' => array(
						  'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
						  )
					  )
				  );
				  
				$objPHPExcel->getActiveSheet()->getStyle('A5:K'.$i)->applyFromArray($styleArray);	
				
				
				$style = array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				$objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($style);
				
				
					
				
				///// FOOTER INFO ////
				
				#Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->setTitle('TRADE PAYMENT REPORT');


				
				#Set print footers
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&D &T&C&LPage &P Of &N');
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&L&D &T&C&RPage &P Of &N');
				
				#Save Excel 2007 file
				//if (file_exists(base_url().'reports/'.$xls_file)) unlink(base_url().'reports/'.$xls_file);
				if (file_exists('reports/'.$xls_file)) unlink('reports/'.$xls_file);
				
				#Save Excel 95 file
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');#Excel5
				$objWriter->save('reports/'.$xls_file);
				
				echo $xls_file;
			}else
			{
				echo 'There is no trade payment record for the selected date.';
			}			
		}//End Build Report	
	}
		
	public function CreatePDFReport()
	{
		$buyer=''; $seller=''; $symbol=''; $startdate=''; $enddate=''; $period=''; $ReportTitle='';
		
		if ($this->input->post('buyer')) $buyer = trim($this->input->post('buyer'));
		if ($this->input->post('seller')) $seller = trim($this->input->post('seller'));
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));	
		if ($this->input->post('startdate')) $startdate = $this->input->post('startdate');
		if ($this->input->post('enddate')) $enddate = $this->input->post('enddate');	
		if ($this->input->post('ReportTitle')) $ReportTitle = $this->input->post('ReportTitle');
		
		$dstart=date("d M Y",strtotime($startdate));
		$dend=date("d M Y",strtotime($enddate));

		if ($dstart==$dend)
		{
			$period=$dstart;
		}else
		{
			$period=$dstart.' - '.$dend;
		}
		
		$dstart=date("jS M Y",strtotime($startdate));
		$dend=date("jS M Y",strtotime($enddate));
		$filename='';
		
		if ($startdate==$enddate)
		{
			if (strtolower(trim($_SERVER['HTTP_HOST']))=='localhost')
			{
				$outputfile="reports\tradespaymentreport_".str_replace(' ','-',$dstart).".pdf";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile="reports/tradespaymentreport_".str_replace(' ','-',$dstart).".pdf";
			}
			
			$filename="tradespaymentreport_".str_replace(' ','-',$dstart).".pdf";
		}else
		{
			if (strtolower(trim($_SERVER['HTTP_HOST']))=='localhost')
			{
				$outputfile="reports\tradespaymentreport_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile="reports/tradespaymentreport_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
			}
			
			$filename="tradespaymentreport_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
		}
		
		$outputfile=getcwd()."/".$outputfile;
		//$outputfile=base_url().$outputfile;
		
		$qry = "SELECT * FROM trades_payments WHERE (DATE_FORMAT(transfer_date,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') ";
		
		//if (isset($buyer)) $qry .= " AND (TRIM(buy_broker_id)='".$buyer."')";
		//if (isset($seller)) $qry .= " AND (TRIM(sell_broker_id)='".$seller."')";
		if (isset($symbol)) $qry .= " AND (TRIM(symbol)='".$symbol."')";
		
		$qry .= " ORDER BY transfer_date";
	
		$query = $this->db->query(stripslashes($qry));
		
		$logo='images/logo.png';
		
		//Get client logo
		$clientlogo='';
		
		//$cl=$this->getdata_model->GetUserLogo($company);//    
		
		if ($cl) $clientlogo = base_url().'images/'.$cl;
		
		
		if ($query->num_rows() == 0 )
		{		
			if ($startdate and $enddate)
			{
				echo "There is no trade payment record for the selected period.";
			}else
			{
				echo "There is no trade payment record.";
			}	
		}else
		{
			$tbrow = '';
			
			$path_parts = pathinfo($logo);
			$ext=trim(strtolower($path_parts['extension']));
		
/////////////////////////////////////REPORT BELOW/////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
			//Table Headers
			$tableheader='
<table nobr="false" border="1" cellpadding="2" cellspacing="0" width="100%">	
<thead>
   <tr bgcolor="#EEEEEE">
	<td align="center" valign="middle" width="8%"><b><font size="10pt" face="Arial">TRADE DATE</font></b></td>
	<td align="center" valign="middle" width="10%"><b><font size="10pt" face="Arial">TRADE ID</font></b></td>
	<td align="center" valign="middle" width="10%"><b><font size="10pt" face="Arial">BUYER</font></b></td>
	<td align="center" valign="middle" width="10%"><b><font size="10pt" face="Arial">SELLER</font></b></td>
	<td align="center" valign="middle" width="8%"><b><font size="10pt" face="Arial">ASSET</font></b></td>
	<td align="center" valign="middle" width="8%"><b><font size="10pt" face="Arial">TOKENS</font></b></td>	
	<td align="right" valign="middle" width="8%"><b><font size="10pt" face="Arial">PRICE</font></b></td>
	<td align="right" valign="middle" width="10%"><b><font size="10pt" face="Arial">TRADE AMOUNT</font></b></td>
	<td align="right" valign="middle" width="10%"><b><font size="10pt" face="Arial">BROKER FEE</font></b></td>
	<td align="right" valign="middle" width="10%"><b><font size="10pt" face="Arial">NSE FEE</font></b></td>
    <td align="right" valign="middle" width="8%"><b><font size="10pt" face="Arial">TRANSFER FEE</font></b></td>
  </tr>
</thead>';
			$sn=0; 	$tprice=0; $bfee=0; $nfee=0; $tfee=0; $tamt=0;
			
			while ($row = $query->unbuffered_row('array'))
			{					
				$sn++; $dt='&nbsp;'; $amt='&nbsp;'; $tid='&nbsp;'; $bid='&nbsp;'; $sid='&nbsp;'; $sym='&nbsp;';
				$tok='&nbsp;'; $pr='&nbsp;'; $bc='&nbsp;'; $nf='&nbsp;'; $tf='&nbsp;';
				
				if ($row['trade_id']) $tid = $row['trade_id'];
				//if ($row['buy_broker_id']) $bid = $row['buy_broker_id'];
				//if ($row['sell_broker_id']) $sid = $row['sell_broker_id'];
				if ($row['symbol']) $sym = $row['symbol'];
				
				if ($row['transfer_date']) $dt=date('d M Y',strtotime($row['transfer_date']));
				$amt=floatval($row['num_tokens']) * floatval($row['price']);
				
				if ($row['num_tokens']) $tok = $row['num_tokens'];
				
				if ($row['transfer_fees'])
				{
					$tfee += $row['transfer_fees'];
					$tf=$row['transfer_fees'];
				}
				
				if ($row['nse_commission'])
				{
					$nfee += $row['nse_commission'];
					$nf=$row['nse_commission'];
				}
				
				if ($row['broker_commission'])
				{
					$bfee += $row['broker_commission'];
					$bc=$row['broker_commission'];
				}
				
				$tamt += floatval($row['num_tokens']) * floatval($row['price']);
				
				if ($row['price'])
				{
					$tprice += $row['price'];
					$pr = $row['price'];
				}
								
				$tbrow .= '
<tr align="center">										
	<td valign="middle" align="center" width="8%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$dt.'</font></td>	
	<td valign="middle" align="center" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$tid.'</font></td>	
	<td valign="middle" align="center" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$bid.'</font></td>	
	<td valign="middle" align="center" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$sid.'</font></td>	
	<td valign="middle" align="center" width="8%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$sym.'</font></td>	
	<td valign="middle" align="center" width="8%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.number_format($tok,0).'</font></td>	
	<td valign="middle" align="right" width="8%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">N '.number_format($pr,2).'</font></td>	
	<td valign="middle" align="right" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">N '.number_format($amt,2).'</font></td>	
	<td valign="middle" align="right" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">N '.number_format($bc,2).'</font></td>	
	<td valign="middle" align="right" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">N '.number_format($nf,2).'</font></td>	
	<td valign="middle" align="right" width="8%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">N '.number_format($tf,2).'</font></td>	
</tr>';
			}
			
			$tfee=number_format($tfee,2);
			$nfee=number_format($nfee,2);
			$bfee=number_format($bfee,2);
			$pr=number_format($pr,2);
			$tamt=number_format($tamt,2);
		
			$tablefooter='
			<tfoot>
			  <tr bgcolor="#EEEEEE">
				<th colspan="6" valign="middle" align="right" width="54%"><b><font size="9pt" face="Arial">TOTAL AMOUNT/FEES (NGN):&nbsp;</font></b></th>   
			   
			   <th align="right" valign="middle" width="8%"><b><font size="9pt" face="Arial">N '.$pr.'</font></b></th>
			   
			   <th align="right" valign="middle" width="10%"><b><font size="9pt" face="Arial">N '.$tamt.'</font></b></th>
			   
			   <th align="right" valign="middle" width="10%"><b><font size="9pt" face="Arial">N '.$bfee.'</font></b></th>
			   
			   <th align="right" valign="middle" width="10%"><b><font size="9pt" face="Arial">N '.$nfee.'</font></b></th>
			   
			   <th align="right" valign="middle" width="8%"><b><font size="9pt" face="Arial">N '.$tfee.'</font></b></th>
			  </tr>
			</tfoot>';

			//Build Report Html
			$content=$tableheader.$tbrow.$tablefooter.'</table>';

			$repdate=$ReportTitle;
			
			$reportheader = '
				<p align="center" >
				<font size="13pt" face="Arial,Helvetica, sans-serif"><b><u>'.$repdate.'</u></b></font>
				</p>';
			
			//////PDF OUT STARTS//////////////
			//////////////////////////////////
			// create new PDF document
			// page orientation (P=portrait, L=landscape)		
			$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			
			// set document information
			$pdf->SetCreator('NSE');
			$pdf->SetAuthor('NSE');
			$pdf->SetTitle('Naija Art Mart');
			$pdf->SetSubject('Technovation');
			$pdf->SetKeywords('Naija Art Mart, NSE, Payments, Trades');
			
			$pdf->SetFont('dejavusans', 'B', 20, '', true);
			//$pdf->SetFont('helvetica', 'B', 20, '', true);
			
			// set default header data
			//$pdf->SetHeaderData('images/'.$logo, PDF_HEADER_LOGO_WIDTH, $company, '');
			
			// set header and footer fonts
			$pdf->setFooterFont(Array('timesI', 'I', 10, '', true));
			$pdf->setHeaderFont(Array('timesI', 'I', 10, '', true));
			//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));	
			
			$pdf->SetHeaderData($logo, 0, 2, 'Trades Payment Report');
			
			
			$pdf->setHeaderFont(Array('timesI', 'I', 10, '', true));
			
			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
			//set margins
			$pdf->SetMargins("0.2", 0.2, "0.2");
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			//$pdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255) );  
			$pdf->SetPrintHeader(false);
			
			//set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			
			//set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			
			//set some language-dependent strings
			$pdf->setLanguageArray($l);
			
			// ---------------------------------------------------------
			$pdf->SetFont('times', '', 10);				
			$pdf->setFontSubsetting(true);// set default font subsetting mode
			
			// Add a page
			$pdf->AddPage();
			
			//Print Logo				
			$header='
			<table border="0" cellpadding="4" cellspacing="0">'; 
			
			if (file_exists($logo))
			{				
				if (($ext=='jpg') or ($ext=='png') or ($ext=='gif'))
				{
					if (file_exists($clientlogo))
					{
						$header.='<tr>	
							<td valign="top" width="50%;" align="left"><img height="50px" src="'.$logo.'"></td>
							<td valign="top" width="50%;" align="right"><img height="50px" src="'.$clientlogo.'"></td>
						</tr>';	
					}else
					{
						$header.='<tr>	
							<td valign="top" width="50%;" align="left"><img height="50px" src="'.$logo.'"></td>
							<td valign="top" width="50%;" align="right">&nbsp;</td>
						</tr>';	
					}					
				}else
				{
					$header.='<tr>	
						<td valign="top" align="center" width="100%">'.$reportheader.'
					</td>
				</tr>';
				}							
			}else
			{
				$header.='<tr>	
					<td valign="top" align="center" width="100%">'.$reportheader.'</td>
				</tr>';
			}
			
			$header.='</table>';
				
			//*******BUILD CONTENTS HERE***********************
							
			$content = $reportheader.$content;			
			//$content = $reportheader.$tableheader.$content;
			
		
			$pdf->writeHTMLCell($w=0, $h=$pdf->GetY(), $x='', $y='0.30', $header, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		
			$pdf->SetFont('times', '', 12);
			$pdf->writeHTMLCell($w=0, $h=$pdf->GetY(), $x='', $y='1.2', $content, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
			
			$pdf->SetFont('times', '', 10);
			
			$chartheight=100;
			
			$factor=0.5;
			//Formular= 0.5 * (freq * 100)
			$x = 1; $y = $pdf->GetY();// + the highest chart height + 5
			$w = 6; $h = 50;
			
			//Insert Charts
			//$pdf->Image($file,TCPDF $x,TCPDF $y,image Width, Image Height, Image Type,$link, align, $resiz, $dpi,palign,ismask,imgmask,border,fitbox,hidden,fitonpage,alt,altimgs)	
			
			$pageDimensions=$pdf->getPageDimensions();
			$pagewidth=$pageDimensions['wk'];

			// Close and output PDF document
			// This method has several options, check the source code documentation for more information.
			ob_clean();
						
			$pdf->Output($outputfile, 'F');
		
			echo $filename;	
		}//End Build Report	
	}
	 
	public function DisplayReport()
	{
		$buyer=''; $seller=''; $symbol=''; $startdate=''; $enddate='';
		
		if ($this->input->post('buyer')) $buyer = trim($this->input->post('buyer'));
		if ($this->input->post('seller')) $seller = trim($this->input->post('seller'));
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));		
		if ($this->input->post('startdate')) $startdate = trim($this->input->post('startdate'));
		if ($this->input->post('enddate')) $enddate = trim($this->input->post('enddate'));
				
		$dstart=date("d M Y",strtotime($startdate));
		$dend=date("d M Y",strtotime($enddate));

		if ($dstart==$dend)
		{
			$period=$dstart;
		}else
		{
			$period=$dstart.' - '.$dend;
		}
		
		$qry = "SELECT * FROM trades_payments WHERE (DATE_FORMAT(transfer_date,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') ";
		
		//if (isset($buyer)) $qry .= " AND (TRIM(buy_broker_id)='".$buyer."')";
		//if (isset($seller)) $qry .= " AND (TRIM(sell_broker_id)='".$seller."')";
		if (isset($symbol)) $qry .= " AND (TRIM(symbol)='".$symbol."')";
		
		$qry .= " ORDER BY transfer_date";

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		if ($results)
		{
			$data=array();

			if (is_array($results))
			{
				foreach($results as $row):
					$dt='';
										
					if ($row['transfer_date']) $dt=date('d M Y',strtotime($row['transfer_date']));
					
					$amt=floatval($row['num_tokens']) * floatval($row['price']);
					
					$tp=array($dt,$row['trade_id'],$row['recipient_code'],$row['sell_broker_id'],$row['symbol'],number_format($row['num_tokens'],0),number_format($row['price'],2),number_format($amt,2),number_format($row['broker_commission'],2),number_format($row['nse_commission'],2),number_format($row['transfer_fees'],2));
					
					$data[]=$tp;
				endforeach;
			}

			print_r(json_encode($data));
		}else
		{
			print_r(json_encode($results));
		}
	}
	
	public function index()
	{
		$data['fullname']=''; $data['email']=''; $data['phone']='';
		$data['accountstatus'] = ''; $data['usertype'] = ''; $data['datecreated'] = '';
		
		$data['CreateAccount']='0';
		$data['AddItem']='0'; $data['EditItem']='0'; $data['DeleteItem']='0'; $data['ClearLogFiles']='0';
		$data['ViewLogReports']='0'; $data['ViewReports']='0'; $data['SetParameters']='0';
		
		$data['SetMarketParameters']=''; $data['ViewOrders']=''; $data['ViewPrices']='';
		$data['BuyAndSellToken']=''; $data['RegisterBroker']=''; $data['PublishWork']='';
		$data['RequestListing']='';
		
		if ($_SESSION['email'])
		{
			$data['email']=trim($_SESSION['email']);
						
			#User Info
			if ($_SESSION['fullname']) $data['fullname']=$_SESSION['fullname'];
			if ($_SESSION['accountstatus']) $data['accountstatus'] = $_SESSION['accountstatus'];
			if ($_SESSION['datecreated']) $data['datecreated'] = $_SESSION['datecreated'];
			if ($_SESSION['usertype']) $data['usertype'] = $_SESSION['usertype'];
			if ($_SESSION['phone']) $data['phone']=$_SESSION['phone'];
			
			//Get Permissions
			$perm=$this->getdata_model->GetPermissions($data['email']);				
			
			if ($perm->RequestListing==1) $data['RequestListing']=1;
			if ($perm->PublishWork==1) $data['PublishWork']=1;
			if ($perm->RegisterBroker==1) $data['RegisterBroker']=1;			
			if ($perm->BuyAndSellToken==1) $data['BuyAndSellToken']=1;			
			if ($perm->ViewPrices==1) $data['ViewPrices']=1;			
			if ($perm->ViewOrders==1) $data['ViewOrders']=1;				
			if ($perm->SetMarketParameters==1) $data['SetMarketParameters']=1;			
			if ($perm->CreateAccount==1) $data['CreateAccount']=1;
			if ($perm->ClearLogFiles==1) $data['ClearLogFiles']=1;			
			if ($perm->SetParameters==1) $data['SetParameters']=1;			
			if ($perm->ViewLogReports==1) $data['ViewLogReports']=1;					
			if ($perm->ViewReports==1) $data['ViewReports']=1;			
			if ($perm->AddItem==1) $data['AddItem']=1;
			if ($perm->EditItem==1) $data['EditItem']=1;
			if ($perm->DeleteItem==1) $data['DeleteItem']=1;
			
			$ret=$this->getdata_model->GetMarketStatus();				
			$data['MarketStatus']=$ret['MarketStatus'];
			$data['ScrollingPrices']=$this->getdata_model->MarketData();	
			
			$set=$this->getdata_model->GetParamaters();
				
			if (intval($set->refreshinterval) > 0)
			{
				$data['RefreshInterval'] = $set->refreshinterval;
			}else
			{
				$data['RefreshInterval']=5;
			}		
			
			$this->load->view('admin/tradespayments_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
