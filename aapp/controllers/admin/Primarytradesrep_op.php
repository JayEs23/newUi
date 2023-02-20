<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
date_default_timezone_set('Africa/Lagos');
set_time_limit(0);

require_once(realpath('.')."/vendor/autoload.php"); 
require_once(realpath('.').'/reportmaker/config/lang/eng.php');
require_once(realpath('.').'/reportmaker/tcpdf.php');
require_once(realpath('.').'/classes/PHPExcel.php');

class Primarytradesrep_op extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	 }
	 
	function GetIssuers()
	{
		$sql="SELECT DISTINCT user_name,email FROM issuers ORDER BY user_name";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetIssuers
	
	function GetInvestors()
	{
		$sql="SELECT DISTINCT user_name,email FROM investors ORDER BY user_name";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetInvestors
	
	function GetBrokers()
	{
		$sql="SELECT DISTINCT company,broker_id FROM brokers ORDER BY company";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetBrokers
	
	function GetSymbols()
	{
		$sql="SELECT DISTINCT(symbol),(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(primary_trades.symbol)) AS title FROM primary_trades ORDER BY title";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetSymbols
	
	function CreateExcelReport()
	{
		$buyer=''; $buyerbroker=''; $seller=''; $symbol='';
		$startdate=''; $enddate=''; $period=''; $ReportTitle='';
		
		if ($this->input->post('buyer')) $buyer = trim($this->input->post('buyer'));
		if ($this->input->post('buyerbroker')) $buyerbroker = trim($this->input->post('buyerbroker'));
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
				$outputfile=FCPATH."reports\primarytrade_op_report_".str_replace(' ','-',$dstart).".xls";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile=FCPATH."reports/primarytrade_op_report_".str_replace(' ','-',$dstart).".xls";
			}
			
			$filename="primarytrade_op_report_".str_replace(' ','-',$dstart).".xls";
		}else
		{
			if (strtolower(trim($_SERVER['HTTP_HOST']))=='localhost')
			{
				$outputfile=FCPATH."reports\primarytrade_op_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".xls";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile=FCPATH."reports/primarytrade_op_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".xls";
			}
			
			$filename="primarytrade_op_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".xls";
		}
		
		$xls_file=$filename;
		
		$PrimaryTrades=array();
				
		$qry = "SELECT primary_trades.*,(SELECT user_name FROM investors WHERE (TRIM(investors.email)=TRIM(primary_trades.buy_investor_email)) LIMIT 0,1) AS investor FROM primary_trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."')";
		
		if (trim($buyer) <> '') $qry .= " AND (TRIM(buy_investor_email)='".$buyer."')";
		if (trim($buyerbroker) <> '') $qry .= " AND (TRIM(buy_broker_id)='".$buyerbroker."')";
		if (trim($seller) <> '') $qry .= " AND (TRIM(sell_investor_email)='".$seller."')";
		if (trim($sellerbroker) <> '') $qry .= " AND (TRIM(sell_broker_id)='".$sellerbroker."')";
		if (trim($symbol) <> '') $qry .= " AND (TRIM(symbol)='".$symbol."')";
		
		$qry .= " ORDER BY tradedate";

		$query = $this->db->query(stripslashes($qry));		
		$PrimaryTrades = $query->result_array();
						
		if ($query->num_rows() == 0 )
		{		
			if ($startdate and $enddate)
			{
				echo "There is no primary trade record for the selected period.";
			}else
			{
				echo "There is no primary trade record.";
			}
		}else
		{				
		############################################# START REPORT HERE #################
			if (count($PrimaryTrades) > 0)
			{
				//$logo=dirname(__FILE__).'/images/emaillogo.png';
				$logo='images/logo.png';
				$company='Naija Art Mart';
				
				//Get client logo
				$clientlogo='';				
					
				//if ($cl) $clientlogo = dirname(__FILE__).'images/'.$cl;				
								
				#Create new PHPExcel object
				$objPHPExcel = new PHPExcel();
				
				$objPHPExcel->getProperties()->setCreator("Naija Art Mart")
											 ->setLastModifiedBy("Naija Art Mart")
											 ->setTitle($ReportTitle)
											 ->setSubject($ReportTitle)
											 ->setDescription($ReportTitle)
											 ->setKeywords("Primary Trade Report,Trades")
											 ->setCategory("Primary Trade Report");
				
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
				$objDrawing->setHeight(50);
				$objDrawing->setWidth(90);
				$objDrawing->setOffsetX(1);
				$objDrawing->setOffsetY(1);
				$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
				
					
				#A to H
				$styleArray = array('font' => array('bold' => true));
				
				$objPHPExcel->getActiveSheet()->setCellValue('A4','');
				$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
				
				$objPHPExcel->getActiveSheet()->getStyle('A1:H1')
											  ->getAlignment()
											  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setSize(14);
				
				
				$objPHPExcel->getActiveSheet()->setCellValue('A2','')
											  ->mergeCells('A2:H2');
								
				$objPHPExcel->getActiveSheet()->setCellValue('A3','')
											  ->mergeCells('A3:H3');	
				
				$styleArray = array(
					'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '000000'),
					'size'  => 14,
					'name'  => 'Calibri'
				));
				
				$objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($styleArray);
						
				$objPHPExcel->getActiveSheet()->setCellValue('A4',strtoupper($ReportTitle))
											  ->mergeCells('A4:H4');
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				#HEADING
				$objPHPExcel->getActiveSheet()->setCellValue('A5', "TRADE DATE")
									  ->setCellValue('B5', "TRADE ID")
									  ->setCellValue('C5', "ASSET")
									  ->setCellValue('D5', "TOKENS")
									  ->setCellValue('E5', "PRICE (₦)")
									  ->setCellValue('F5', "ISSUER FEE (₦)")
									  ->setCellValue('G5', "SELLER EMAIL")
									  ->setCellValue('H5', "BUYER EMAIL");
					
				$objPHPExcel->getActiveSheet()->getStyle('A5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$objPHPExcel->getActiveSheet()->getStyle('E5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				$objPHPExcel->getActiveSheet()->getStyle('G5:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$objPHPExcel->getActiveSheet()->getStyle('A5:H5')->applyFromArray($styleArray);	
				$objPHPExcel->getActiveSheet()->getStyle('A5:H5')->getFont()->setSize(10);
													  
				$objPHPExcel->getActiveSheet()->getStyle('A5:H5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle('A5:H5')->getFill()->getStartColor()->setRGB('3D3E11');
				$objPHPExcel->getActiveSheet()->getStyle('A5:H5')->getFont()->setBold(true);	
									
				$styleArrayWhite = array(
					'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => 'FFFFFF'),
					'size'  => 10,
					'name'  => 'Calibri'
				));				  
				
				
				$objPHPExcel->getActiveSheet()->getStyle('A5:H5')->applyFromArray($styleArrayWhite);				
				$objPHPExcel->getActiveSheet()->getStyle('A5:H5')->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle('A5:H5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				$i=5; $total=0;

				$styleArrayBlack = array(
					'font'  => array(
					'bold'  => false,
					'color' => array('rgb' => '000000'),
					'size'  => 10,
					'name'  => 'Calibri'
				));
				
				$tamt=0;
				
				foreach($PrimaryTrades as $k => $v):
					$i++; $sn++; $dt=''; $amt=''; $tid=''; $sym=''; $tok=''; $sem=''; $pr=''; $bem='';
					
					if ($v['tradedate']) $dt=date('d M Y',strtotime($v['tradedate']));				
					if ($v['trade_id']) $tid = $v['trade_id'];
					if ($v['symbol']) $sym = $v['symbol'];
					if ($v['num_tokens']) $tok = number_format($v['num_tokens'],0);
					if ($v['trade_price']) $pr = number_format($v['trade_price'],2);
					
					if ($v['issuer_fee'])
					{			
						$amt=number_format($v['issuer_fee'],2);
						$tamt += $v['issuer_fee'];				
					}
					
					if ($v['issuer_email']) $sem = $v['issuer_email'];				
					if ($v['buy_investor_email']) $bem = $v['buy_investor_email'];
																										
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $dt);
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $tid);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $sym);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $tok);
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, '₦ '.$pr);
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, '₦ '.$amt);
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $sem);
					$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $bem); 
					
					//Wrap Text
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getAlignment()->setWrapText(true);
					#Value Format
																						
					$objPHPExcel->getActiveSheet()->getStyle('E'.$i.':F'.$i)->getNumberFormat()
								->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);						
			
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					$objPHPExcel->getActiveSheet()->getStyle('E'.$i.':F'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					
					$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':H'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getFill()->getStartColor()->setRGB('FFFFFF');
					
					$styleArray = array(
						'font'  => array(
						'bold'  => false,
						'color' => array('rgb' => '000000'),
						'size'  => 10,
						'name'  => 'Calibri'
					));
						
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->applyFromArray($styleArrayBlack);	
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
				
				$i++;
				
				$tamt=number_format($tamt,2);
				
				#FOOTER
				
				//Merge Agenda Column
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,"TOTAL ISSUER/SELLER FEE: ")
											  ->mergeCells('A'.$i.':E'.$i);
											  
				$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, '₦ '.$tamt);
												
				$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()
								->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
									
													  
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getFill()->getStartColor()->setRGB('3D3E11');
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->applyFromArray($styleArrayWhite);
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				
				
				$styleArray = array(
					  'borders' => array(
						  'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
						  )
					  )
				  );
				  
				$objPHPExcel->getActiveSheet()->getStyle('A5:H'.$i)->applyFromArray($styleArray);	
				
				
				$style = array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				$objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($style);
				
				
					
				
				///// FOOTER INFO ////
				
				#Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->setTitle('SECONDARY TRADE REPORT');


				
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
				echo 'There is no primary trade record for the selected date.';
			}			
		}//End Build Report	
	}
		
	function CreatePDFReport()
	{
		$period=''; $ReportTitle='';$buyer=''; $buyerbroker=''; $seller=''; $symbol=''; $startdate=''; $enddate='';
		
		if ($this->input->post('buyer')) $buyer = trim($this->input->post('buyer'));
		if ($this->input->post('buyerbroker')) $buyerbroker = trim($this->input->post('buyerbroker'));
		if ($this->input->post('seller')) $seller = trim($this->input->post('seller'));
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));		
		if ($this->input->post('startdate')) $startdate = trim($this->input->post('startdate'));
		if ($this->input->post('enddate')) $enddate = trim($this->input->post('enddate'));
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
				$outputfile="reports\primarytrade_op_report_".str_replace(' ','-',$dstart).".pdf";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile="reports/primarytrade_op_report_".str_replace(' ','-',$dstart).".pdf";
			}
			
			$filename="primarytrade_op_report_".str_replace(' ','-',$dstart).".pdf";
		}else
		{
			if (strtolower(trim($_SERVER['HTTP_HOST']))=='localhost')
			{
				$outputfile="reports\primarytrade_op_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile="reports/primarytrade_op_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
			}
			
			$filename="primarytrade_op_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
		}
		
		$outputfile=getcwd()."/".$outputfile;
		//$outputfile=base_url().$outputfile;
		
		$qry = "SELECT primary_trades.*,(SELECT user_name FROM investors WHERE (TRIM(investors.email)=TRIM(primary_trades.buy_investor_email)) LIMIT 0,1) AS investor FROM primary_trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."')";
		
		if (trim($buyer) <> '') $qry .= " AND (TRIM(buy_investor_email)='".$buyer."')";
		if (trim($buyerbroker) <> '') $qry .= " AND (TRIM(buy_broker_id)='".$buyerbroker."')";
		if (trim($seller) <> '') $qry .= " AND (TRIM(sell_investor_email)='".$seller."')";
		if (trim($sellerbroker) <> '') $qry .= " AND (TRIM(sell_broker_id)='".$sellerbroker."')";
		if (trim($symbol) <> '') $qry .= " AND (TRIM(symbol)='".$symbol."')";
		
		$qry .= " ORDER BY tradedate";
	
		$query = $this->db->query(stripslashes($qry));
		
		$logo='images/logo.png';
		
		//Get client logo
		$clientlogo='';
		
		//if ($cl) $clientlogo = base_url().'images/'.$cl;
		
		
		if ($query->num_rows() == 0 )
		{		
			if ($startdate and $enddate)
			{
				echo "There is no primary trade record for the selected period.";
			}else
			{
				echo "There is no primary trade record.";
			}	
		}else
		{
			$tbrow = '';
			
			$path_parts = pathinfo($logo);
			$ext=trim(strtolower($path_parts['extension']));
		
/////////////////////////////////////REPORT BELOW/////////////////////////////////////////
			//Table Headers
			$tableheader='
<table nobr="false" border="1" cellpadding="2" cellspacing="0" width="100%">	
<thead>
   <tr bgcolor="#EEEEEE">
	<td align="center" valign="middle" width="10%"><b><font size="10pt" face="Arial">TRADE DATE</font></b></td>
	<td align="center" valign="middle" width="10%"><b><font size="10pt" face="Arial">TRADE ID</font></b></td>
	<td align="center" valign="middle" width="10%"><b><font size="10pt" face="Arial">ASSET</font></b></td>
	<td align="center" valign="middle" width="8%"><b><font size="10pt" face="Arial">TOKENS</font></b></td>
	<td align="right" valign="middle" width="10%"><b><font size="10pt" face="Arial">PRICE (NGN)</font></b></td>
	<td align="right" valign="middle" width="12%"><b><font size="10pt" face="Arial">ISSUER FEE (NGN)</font></b></td>
	
	<td align="center" valign="middle" width="20%"><b><font size="10pt" face="Arial">SELLER EMAIL</font></b></td>	
	
	<td align="center" valign="middle" width="20%"><b><font size="10pt" face="Arial">BUYER EMAIL</font></b></td>
  </tr>
</thead>';
			$sn=0; $tfee=0;
			
			while ($row = $query->unbuffered_row('array'))
			{					
				$sn++; $tid='&nbsp;'; $sym='&nbsp;'; $tok='&nbsp;'; $fee='&nbsp;';
				$em='&nbsp;'; $pr='&nbsp;'; $dt='&nbsp;'; $bem='&nbsp;';
				
				if ($row['tradedate']) $dt=date('d M Y',strtotime($row['tradedate']));				
				if ($row['trade_id']) $tid = $row['trade_id'];
				if ($row['symbol']) $sym = $row['symbol'];
				if ($row['num_tokens']) $tok = number_format($row['num_tokens'],0);
				if ($row['trade_price']) $pr = number_format($row['trade_price'],2);
				if ($row['issuer_fee'])
				{
					$fee = number_format($row['issuer_fee'],2);	
					$tfee += $row['issuer_fee'];			
				}
				if ($row['issuer_email']) $em = $row['issuer_email'];				
				if ($row['buy_investor_email']) $bem = $row['buy_investor_email'];
											
				$tbrow .= '
<tr align="center">										
	<td valign="middle" align="center" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$dt.'</font></td>	
	<td valign="middle" align="center" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$tid.'</font></td>	
	<td valign="middle" align="center" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$sym.'</font></td>
	<td valign="middle" align="center" width="8%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$tok.'</font></td>
	<td valign="middle" align="right" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$pr.'</font></td>
	<td valign="middle" align="right" width="12%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$fee.'</font></td>	
		
	<td valign="middle" align="center" width="20%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$em.'</font></td>	
		
	<td valign="middle" align="center" width="20%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$bem.'</font></td>
</tr>';
			}//14,10,10,10,10,12,17,17
			
			$tfee=number_format($tfee,2);
			
			$tablefooter='
			<tfoot>
			  <tr bgcolor="#EEEEEE">
				<th colspan="5" valign="middle" align="right" width="48%"><b><font size="9pt" face="Arial">TOTAL ISSUER/SELLER FEE (NGN):&nbsp;</font></b></th>   
			   
			   <th align="right" valign="middle" width="12%"><b><font size="9pt" face="Arial">'.$tfee.'</font></b></th>
			   
			   <th align="right" valign="middle" width="20%"><b><font size="9pt" face="Arial"></font></b></th>
			   
			   <th align="right" valign="middle" width="20%"><b><font size="9pt" face="Arial"></font></b></th>
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
			$pdf->SetKeywords('Naija Art Mart, NSE, Primary Trade, Issuer');			
			$pdf->SetFont('dejavusans', 'B', 20, '', true);
						
			// set header and footer fonts
			$pdf->setFooterFont(Array('timesI', 'I', 10, '', true));
			$pdf->setHeaderFont(Array('timesI', 'I', 10, '', true));			
			$pdf->SetHeaderData($logo, 0, 2, 'Primary Trades Report');						
			$pdf->setHeaderFont(Array('timesI', 'I', 10, '', true));			
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);// set default monospaced font			
			$pdf->SetMargins("0.2", 0.2, "0.2");//set margins			
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetPrintHeader(false);						
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);//set auto page breaks			
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);//set image scale factor			
			$pdf->setLanguageArray($l);//set some language-dependent strings			
			$pdf->SetFont('times', '', 10);				
			$pdf->setFontSubsetting(true);// set default font subsetting mode			
			
			$pdf->AddPage();// Add a page
			
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
	
	function DisplayReport()
	{
		$buyer=''; $buyerbroker=''; $seller=''; $symbol=''; $startdate=''; $enddate='';
		
		if ($this->input->post('buyer')) $buyer = trim($this->input->post('buyer'));
		if ($this->input->post('buyerbroker')) $buyerbroker = trim($this->input->post('buyerbroker'));
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
		
		$qry = "SELECT primary_trades.*,(SELECT user_name FROM investors WHERE (TRIM(investors.email)=TRIM(primary_trades.buy_investor_email)) LIMIT 0,1) AS investor FROM primary_trades WHERE (DATE_FORMAT(tradedate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."')";
		
		if (trim($buyer) <> '') $qry .= " AND (TRIM(buy_investor_email)='".$buyer."')";
		if (trim($buyerbroker) <> '') $qry .= " AND (TRIM(buy_broker_id)='".$buyerbroker."')";
		if (trim($seller) <> '') $qry .= " AND (TRIM(sell_investor_email)='".$seller."')";
		if (trim($sellerbroker) <> '') $qry .= " AND (TRIM(sell_broker_id)='".$sellerbroker."')";
		if (trim($symbol) <> '') $qry .= " AND (TRIM(symbol)='".$symbol."')";
		
		$qry .= " ORDER BY tradedate";
//$file = fopen('aaa.txt',"w"); fwrite($file,print_r($qry,true)); fclose($file);
				
		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		if ($results)
		{
			$data=array();

			if (is_array($results))
			{
				foreach($results as $row):
					$dt='';
										
					if ($row['tradedate']) $dt=date('d M Y',strtotime($row['tradedate']));
					
					$tp=array($dt,$row['trade_id'],$row['symbol'],number_format($row['num_tokens'],0),number_format($row['trade_price'],2),number_format($row['issuer_fee'],2),$row['issuer_email'],$row['buy_investor_email']);
					
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
			
			$this->load->view('admin/primarytradesrep_op_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
