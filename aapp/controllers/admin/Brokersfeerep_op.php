<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
date_default_timezone_set('Africa/Lagos');
set_time_limit(0);

require_once(realpath('.')."/vendor/autoload.php"); 
require_once(realpath('.').'/reportmaker/config/lang/eng.php');
require_once(realpath('.').'/reportmaker/tcpdf.php');
require_once(realpath('.').'/classes/PHPExcel.php');

class Brokersfeerep_op extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	 }
	
	function GetBrokers()
	{
		$sql="SELECT DISTINCT company,recipient_code FROM brokers ORDER BY company";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetBrokers
	
	function CreateExcelReport()
	{
		$recipient_code=''; $startdate=''; $enddate=''; $period=''; $ReportTitle='';
		
		if ($this->input->post('recipient_code')) $recipient_code = trim($this->input->post('recipient_code'));	
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
				$outputfile=FCPATH."reports\brokerfee_op_report_".str_replace(' ','-',$dstart).".xls";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile=FCPATH."reports/brokerfee_op_report_".str_replace(' ','-',$dstart).".xls";
			}
			
			$filename="brokerfee_op_report_".str_replace(' ','-',$dstart).".xls";
		}else
		{
			if (strtolower(trim($_SERVER['HTTP_HOST']))=='localhost')
			{
				$outputfile=FCPATH."reports\brokerfee_op_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".xls";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile=FCPATH."reports/brokerfee_op_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".xls";
			}
			
			$filename="brokerfee_op_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".xls";
		}
		
		$xls_file=$filename;
		
		$BrokerCommission=array();
				
		$qry = "SELECT * FROM trades_payments WHERE (INSTR(recipient,'broker') > 0) AND (DATE_FORMAT(trade_date,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."')";
		
		if (trim($recipient_code) <> '') $qry .= " AND (TRIM(recipient_code)='".$recipient_code."')";
		
		$qry .= " ORDER BY trade_date";

		$query = $this->db->query(stripslashes($qry));		
		$BrokerCommission = $query->result_array();
						
		if ($query->num_rows() == 0 )
		{		
			if ($startdate and $enddate)
			{
				echo "There is no broker commission record for the selected period.";
			}else
			{
				echo "There is no broker commission record.";
			}
		}else
		{				
		############################################# START REPORT HERE #################
			if (count($BrokerCommission) > 0)
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
											 ->setKeywords("Brokers Commission Report,Trades")
											 ->setCategory("Brokers Commission Report");
				
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
				
					
				#A to G
				$styleArray = array('font' => array('bold' => true));
				
				$objPHPExcel->getActiveSheet()->setCellValue('A4','');
				$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
				
				$objPHPExcel->getActiveSheet()->getStyle('A1:G1')
											  ->getAlignment()
											  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setSize(14);
				
				
				$objPHPExcel->getActiveSheet()->setCellValue('A2','')
											  ->mergeCells('A2:G2');
								
				$objPHPExcel->getActiveSheet()->setCellValue('A3','')
											  ->mergeCells('A3:G3');	
				
				$styleArray = array(
					'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '000000'),
					'size'  => 14,
					'name'  => 'Calibri'
				));
				
				$objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($styleArray);
						
				$objPHPExcel->getActiveSheet()->setCellValue('A4',strtoupper($ReportTitle))
											  ->mergeCells('A4:G4');
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				#HEADING
				$objPHPExcel->getActiveSheet()->setCellValue('A5', "TRADE DATE")
									  ->setCellValue('B5', "TRADE ID")
									  ->setCellValue('C5', "ASSET")
									  ->setCellValue('D5', "TOKENS")
									  ->setCellValue('E5', "PRICE")
									  ->setCellValue('F5', "TRADE AMOUNT")
									  ->setCellValue('G5', "BROKER COMMISSION");
					
				$objPHPExcel->getActiveSheet()->getStyle('A5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$objPHPExcel->getActiveSheet()->getStyle('E5:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->applyFromArray($styleArray);	
				$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFont()->setSize(10);
													  
				$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFill()->getStartColor()->setRGB('3D3E11');
				$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFont()->setBold(true);	
									
				$styleArrayWhite = array(
					'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => 'FFFFFF'),
					'size'  => 10,
					'name'  => 'Calibri'
				));				  
				
				
				$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->applyFromArray($styleArrayWhite);				
				$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				$i=5;

				$styleArrayBlack = array(
					'font'  => array(
					'bold'  => false,
					'color' => array('rgb' => '000000'),
					'size'  => 10,
					'name'  => 'Calibri'
				));
				
				$tamt=0;
				
				foreach($BrokerCommission as $k => $v):
					$i++; $sn++; $dt=''; $tid=''; $sym=''; $tok=''; $fee=''; $amt=''; $pr='';
					
					if ($v['trade_date']) $dt=date('d M Y',strtotime($v['trade_date']));				
					if ($v['trade_id']) $tid = $v['trade_id'];
					if ($v['symbol']) $sym = $v['symbol'];
					if ($v['num_tokens']) $tok = number_format($v['num_tokens'],0);
					if ($v['price']) $pr = number_format($v['price'],2);
					if ($v['trade_amount']) $amt = number_format($v['trade_amount'],2);
					if ($v['recipient_amount'])
					{
						$fee = number_format($v['recipient_amount'],2);	
						$tamt += $v['recipient_amount'];			
					}
																										
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $dt);
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $tid);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $sym);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $tok);
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, '₦ '.$pr);
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, '₦ '.$amt);
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, '₦ '.$fee);
					
					//Wrap Text
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setWrapText(true);
					#Value Format
																						
					$objPHPExcel->getActiveSheet()->getStyle('E'.$i.':G'.$i)->getNumberFormat()
								->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);						
			
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					$objPHPExcel->getActiveSheet()->getStyle('E'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFill()->getStartColor()->setRGB('FFFFFF');
					
					$styleArray = array(
						'font'  => array(
						'bold'  => false,
						'color' => array('rgb' => '000000'),
						'size'  => 10,
						'name'  => 'Calibri'
					));
						
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->applyFromArray($styleArrayBlack);	
				endforeach;
				
				//Dimensions
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
				$i++;
				
				$tamt=number_format($tamt,2);
				
				#FOOTER
				
				//Merge Agenda Column
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,"TOTAL BROKER COMMISSION: ")
											  ->mergeCells('A'.$i.':F'.$i);
											  
				$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, '₦ '.$tamt);
												
				$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()
								->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
									
													  
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFill()->getStartColor()->setRGB('3D3E11');
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->applyFromArray($styleArrayWhite);
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				
				
				$styleArray = array(
					  'borders' => array(
						  'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
						  )
					  )
				  );
				  
				$objPHPExcel->getActiveSheet()->getStyle('A5:G'.$i)->applyFromArray($styleArray);	
				
				
				$style = array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				$objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($style);
				
				
					
				
				///// FOOTER INFO ////
				
				#Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->setTitle('BROKERS COMMISSION REPORT');
				
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
				echo 'There is no broker commission record for the selected date.';
			}			
		}//End Build Report	
	}
		
	function CreatePDFReport()
	{
		$period=''; $ReportTitle=''; $recipient_code=''; $startdate=''; $enddate='';
		
		if ($this->input->post('recipient_code')) $recipient_code = trim($this->input->post('recipient_code'));
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
				$outputfile="reports\brokerfee_op_report_".str_replace(' ','-',$dstart).".pdf";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile="reports/brokerfee_op_report_".str_replace(' ','-',$dstart).".pdf";
			}
			
			$filename="brokerfee_op_report_".str_replace(' ','-',$dstart).".pdf";
		}else
		{
			if (strtolower(trim($_SERVER['HTTP_HOST']))=='localhost')
			{
				$outputfile="reports\brokerfee_op_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile="reports/brokerfee_op_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
			}
			
			$filename="brokerfee_op_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
		}
		
		$outputfile=getcwd()."/".$outputfile;
		//$outputfile=base_url().$outputfile;
		
		$qry = "SELECT * FROM trades_payments WHERE (INSTR(recipient,'broker') > 0) AND (DATE_FORMAT(trade_date,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."')";
		
		if (trim($recipient_code) <> '') $qry .= " AND (TRIM(recipient_code)='".$recipient_code."')";
		
		$qry .= " ORDER BY trade_date";
	
		$query = $this->db->query(stripslashes($qry));
		
		$logo='images/logo.png';
		
		//Get client logo
		$clientlogo='';
		
		//if ($cl) $clientlogo = base_url().'images/'.$cl;
		
		
		if ($query->num_rows() == 0 )
		{		
			if ($startdate and $enddate)
			{
				echo "There is no broker commission record for the selected period.";
			}else
			{
				echo "There is no broker commission record.";
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
	<td align="center" valign="middle" width="15%"><b><font size="10pt" face="Arial">TRADE ID</font></b></td>
	<td align="center" valign="middle" width="13%"><b><font size="10pt" face="Arial">ASSET</font></b></td>
	<td align="center" valign="middle" width="13%"><b><font size="10pt" face="Arial">TOKENS</font></b></td>
	<td align="right" valign="middle" width="12%"><b><font size="10pt" face="Arial">PRICE (NGN)</font></b></td>
	<td align="right" valign="middle" width="17%"><b><font size="10pt" face="Arial">TRADE AMOUNT (NGN)</font></b></td>
	
	<td align="right" valign="middle" width="20%"><b><font size="10pt" face="Arial">BROKER COMMISSION (NGN)</font></b></td>
  </tr>
</thead>';//10,17,13,13,13,17,17
			$sn=0; $tfee=0;
			
			while ($row = $query->unbuffered_row('array'))
			{					
				$sn++; $dt='&nbsp;'; $tid='&nbsp;'; $sym='&nbsp;'; $tok='&nbsp;'; $fee='&nbsp;';
				$amt='&nbsp;'; $pr='&nbsp;';
				
				if ($row['trade_date']) $dt=date('d M Y',strtotime($row['trade_date']));				
				if ($row['trade_id']) $tid = $row['trade_id'];
				if ($row['symbol']) $sym = $row['symbol'];
				if ($row['num_tokens']) $tok = number_format($row['num_tokens'],0);
				if ($row['price']) $pr = number_format($row['price'],2);
				if ($row['trade_amount']) $amt = number_format($row['trade_amount'],2);
				if ($row['recipient_amount'])
				{
					$fee = number_format($row['recipient_amount'],2);	
					$tfee += $row['recipient_amount'];			
				}
											
				$tbrow .= '
<tr align="center">										
	<td valign="middle" align="center" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$dt.'</font></td>	
	<td valign="middle" align="center" width="15%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$tid.'</font></td>	
	<td valign="middle" align="center" width="13%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$sym.'</font></td>
	<td valign="middle" align="center" width="13%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$tok.'</font></td>
	<td valign="middle" align="right" width="12%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$pr.'</font></td>
	<td valign="middle" align="right" width="17%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$amt.'</font></td>		
	<td valign="middle" align="right" width="20%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$fee.'</font></td>
</tr>';
			}//10,17,13,13,13,17,17
			
			$tfee=number_format($tfee,2);
			
			$tablefooter='
			<tfoot>
			  <tr bgcolor="#EEEEEE">
				<th colspan="6" valign="middle" align="right" width="80%"><b><font size="9pt" face="Arial">TOTAL BROKER COMMISSION (NGN):&nbsp;</font></b></th>   
			   
			   <th align="right" valign="middle" width="20%"><b><font size="9pt" face="Arial">'.$tfee.'</font></b></th>
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
			$pdf->SetCreator('LVI');
			$pdf->SetAuthor('LVI');
			$pdf->SetTitle('Naija Art Mart');
			$pdf->SetSubject('Technovation');
			$pdf->SetKeywords('Naija Art Mart, Brokers Commission');			
			$pdf->SetFont('dejavusans', 'B', 20, '', true);
						
			// set header and footer fonts
			$pdf->setFooterFont(Array('timesI', 'I', 10, '', true));
			$pdf->setHeaderFont(Array('timesI', 'I', 10, '', true));			
			$pdf->SetHeaderData($logo, 0, 2, 'Brokers Commission Report');						
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
		$recipient_code=''; $startdate=''; $enddate='';
		
		if ($this->input->post('recipient_code')) $recipient_code = trim($this->input->post('recipient_code'));		
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
		
		$qry = "SELECT * FROM trades_payments WHERE (INSTR(recipient,'broker') > 0) AND (DATE_FORMAT(trade_date,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."')";
		
		if (trim($recipient_code) <> '') $qry .= " AND (TRIM(recipient_code)='".$recipient_code."')";
		
		$qry .= " ORDER BY trade_date";
			
		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		if ($results)
		{
			$data=array();

			if (is_array($results))
			{
				foreach($results as $row):
					$dt='';
										
					if ($row['trade_date']) $dt=date('d M Y',strtotime($row['trade_date']));
										
					$tp=array($dt,$row['trade_id'],$row['symbol'],number_format($row['num_tokens'],0),number_format($row['price'],2),number_format($row['trade_amount'],2),number_format($row['recipient_amount'],2));

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
			
			$this->load->view('admin/brokersfeerep_op_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
