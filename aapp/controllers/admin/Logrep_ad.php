<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
date_default_timezone_set('Africa/Lagos');
set_time_limit(0);

require_once(realpath('.')."/vendor/autoload.php"); 
require_once(realpath('.').'/reportmaker/config/lang/eng.php');
require_once(realpath('.').'/reportmaker/tcpdf.php');
require_once(realpath('.').'/classes/PHPExcel.php');

class Logrep_ad extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	 
	function LoadUsers()
	{
		$sql="SELECT DISTINCT Username As email,Name As fullname FROM loginfo ORDER BY Name";

		$query=$this->db->query($sql);

		echo json_encode($query->result());
	}
	
	
	function CreateExcelReport()
	{
		$username=''; $startdate=''; $enddate=''; $period=''; $ReportTitle='';
		
		if ($this->input->post('username')) $username = trim($this->input->post('username'));	
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
				$outputfile=FCPATH."reports\logrep_ad_report_".str_replace(' ','-',$dstart).".xls";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile=FCPATH."reports/logrep_ad_report_".str_replace(' ','-',$dstart).".xls";
			}
			
			$filename="logrep_ad_report_".str_replace(' ','-',$dstart).".xls";
		}else
		{
			if (strtolower(trim($_SERVER['HTTP_HOST']))=='localhost')
			{
				$outputfile=FCPATH."reports\logrep_ad_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".xls";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile=FCPATH."reports/logrep_ad_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".xls";
			}
			
			$filename="logrep_ad_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".xls";
		}
		
		$xls_file=$filename;
		
		$RegisteredBrokers=array();
				
		$qry="SELECT loginfo.*,DATE_FORMAT(ActionDate,'%d %b %Y @ %H:%i') AS ADate FROM loginfo WHERE (DATE_FORMAT(ActionDate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."')";
		
		if (trim($username) != '') $qry .= " AND (TRIM(Username)='".$this->db->escape_str($username)."')";
		
		$qry .= " ORDER BY ActionDate,`name`";

		$query = $this->db->query(stripslashes($qry));		
		$RegisteredBrokers = $query->result_array();
						
		if ($query->num_rows() == 0 )
		{		
			if ($startdate and $enddate)
			{
				echo "There is no audit trail record for the selected period.";
			}else
			{
				echo "There is no audit trail record.";
			}
		}else
		{				
		############################################# START REPORT HERE #################
			if (count($RegisteredBrokers) > 0)
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
											 ->setKeywords("Audit Trails")
											 ->setCategory("Audit Trails Report");
				
				$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
				//$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
				
				$margin = 0.4; #Margin is set in inches (0.5cm)
				
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
				
					
				#A to F
				$styleArray = array('font' => array('bold' => true));
				
				$objPHPExcel->getActiveSheet()->setCellValue('A4','');
				$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
				
				$objPHPExcel->getActiveSheet()->getStyle('A1:F1')
											  ->getAlignment()
											  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setSize(14);
				
				
				$objPHPExcel->getActiveSheet()->setCellValue('A2','')
											  ->mergeCells('A2:F2');
								
				$objPHPExcel->getActiveSheet()->setCellValue('A3','')
											  ->mergeCells('A3:F3');	
				
				$styleArray = array(
					'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '000000'),
					'size'  => 14,
					'name'  => 'Calibri'
				));
				
				$objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($styleArray);
						
				$objPHPExcel->getActiveSheet()->setCellValue('A4',strtoupper($ReportTitle))
											  ->mergeCells('A4:F4');
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				#HEADING
				$objPHPExcel->getActiveSheet()->setCellValue('A5', "LOG DATE")
									  ->setCellValue('B5', "EMAIL/USERNAME")
									  ->setCellValue('C5', "NAME OF USER")
									  ->setCellValue('D5', "OPERATION")
									  ->setCellValue('E5', "ACTIVITY")
									  ->setCellValue('F5', "USER IP ADDRESS");
					
				$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->applyFromArray($styleArray);	
				$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->getFont()->setSize(10);
													  
				$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->getFill()->getStartColor()->setRGB('3D3E11');
				$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->getFont()->setBold(true);	
									
				$styleArrayWhite = array(
					'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => 'FFFFFF'),
					'size'  => 10,
					'name'  => 'Calibri'
				));				  
				
				
				$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->applyFromArray($styleArrayWhite);				
				$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				$i=5; $total=0;

				$styleArrayBlack = array(
					'font'  => array(
					'bold'  => false,
					'color' => array('rgb' => '000000'),
					'size'  => 10,
					'name'  => 'Calibri'
				));
				
				foreach($RegisteredBrokers as $k => $v):
					$i++; $sn++; $dt=''; $un=''; $nm=''; $op=''; $act=''; $ip='';
				
					if ($v['ADate']) $dt=trim($v['ADate']);
					if ($v['Username']) $un = trim($v['Username']);
					if ($v['Name']) $nm = trim($v['Name']);
					if ($v['Operation']) $op = trim($v['Operation']);
					if ($v['Activity']) $act=str_replace("\'","'",html_entity_decode($v['Activity']));
					if ($v['remote_ip']) $ip = trim($v['remote_ip']);
																										
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $dt);
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $un);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $nm);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $op);
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $act);
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $ip);
					
					//Wrap Text
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->getAlignment()->setWrapText(true);
					
					//Horizontal Alignment
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					//Vertical Alignment					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->getFill()->getStartColor()->setRGB('FFFFFF');
					
					$styleArray = array(
						'font'  => array(
						'bold'  => false,
						'color' => array('rgb' => '000000'),
						'size'  => 10,
						'name'  => 'Calibri'
					));
						
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->applyFromArray($styleArrayBlack);	
				endforeach;
				
				//Dimensions
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(100);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
												
				$styleArray = array(
					  'borders' => array(
						  'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
						  )
					  )
				  );
				  
				$objPHPExcel->getActiveSheet()->getStyle('A5:F'.$i)->applyFromArray($styleArray);
				
				$style = array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				$objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($style);				
					
				
				///// FOOTER INFO ////				
				#Set active sheet index to the first sheet, so Excel opens this as the first sheet
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->setTitle('AUDIT TRAIL REPORT');
				
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
				echo 'There is no audit trail record for the selected date.';
			}			
		}//End Build Report	
	}
		
	function CreatePDFReport()
	{
		$period=''; $ReportTitle=''; $username=''; $startdate=''; $enddate='';
		
		if ($this->input->post('username')) $username = trim($this->input->post('username'));		
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
				$outputfile="reports\logrep_ad_report_".str_replace(' ','-',$dstart).".pdf";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile="reports/logrep_ad_report_".str_replace(' ','-',$dstart).".pdf";
			}
			
			$filename="logrep_ad_report_".str_replace(' ','-',$dstart).".pdf";
		}else
		{
			if (strtolower(trim($_SERVER['HTTP_HOST']))=='localhost')
			{
				$outputfile="reports\logrep_ad_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile="reports/logrep_ad_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
			}
			
			$filename="logrep_ad_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
		}
		
		$outputfile=getcwd()."/".$outputfile;
		//$outputfile=base_url().$outputfile;
		
		$qry="SELECT loginfo.*,DATE_FORMAT(ActionDate,'%d %b %Y @ %H:%i') AS ADate FROM loginfo WHERE (DATE_FORMAT(ActionDate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."')";
		
		if (trim($username) != '') $qry .= " AND (TRIM(Username)='".$this->db->escape_str($username)."')";
		
		$qry .= " ORDER BY ActionDate,`name`";
	
		$query = $this->db->query(stripslashes($qry));
		
		$logo='images/logo.png';
		
		//Get client logo
		$clientlogo='';
		
		if ($query->num_rows() == 0 )
		{		
			if ($startdate and $enddate)
			{
				echo "There is no audit trail record for the selected period.";
			}else
			{
				echo "There is no audit trail record.";
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
	<td align="center" valign="middle" width="16%"><b><font size="10pt" face="Arial">LOG DATE</font></b></td>
	<td align="center" valign="middle" width="17%"><b><font size="10pt" face="Arial">EMAIL/USERNAME</font></b></td>
	<td align="center" valign="middle" width="15%"><b><font size="10pt" face="Arial">NAME OF USER</font></b></td>
	<td align="center" valign="middle" width="15%"><b><font size="10pt" face="Arial">OPERATION</font></b></td>
	<td align="center" valign="middle" width="25%"><b><font size="10pt" face="Arial">ACTIVITY</font></b></td>
	<td align="center" valign="middle" width="12%"><b><font size="10pt" face="Arial">IP ADDRESS</font></b></td>	
  </tr>
</thead>';//16,17,15,15,25,12
			$sn=0;
			
			while ($row = $query->unbuffered_row('array'))
			{					
				$sn++; $dt='&nbsp;'; $un='&nbsp;'; $nm='&nbsp;'; $op='&nbsp;'; $act='&nbsp;'; $ip='&nbsp;';
				
				if ($row['ADate']) $dt=trim($row['ADate']);
				if ($row['Username']) $un = trim($row['Username']);
				if ($row['Name']) $nm = trim($row['Name']);
				if ($row['Operation']) $op = trim($row['Operation']);
				if ($row['Activity']) $act=str_replace("\'","'",html_entity_decode($row['Activity']));
				if ($row['remote_ip']) $ip = trim($row['remote_ip']);
											
				$tbrow .= '
<tr align="center">										
	<td valign="middle" align="center" width="16%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$dt.'</font></td>	
	<td valign="middle" align="center" width="17%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$un.'</font></td>	
	<td valign="middle" align="center" width="15%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$nm.'</font></td>	
	<td valign="middle" align="center" width="15%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$op.'</font></td>	
	<td valign="middle" align="center" width="25%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$act.'</font></td>	
	<td valign="middle" align="center" width="12%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$ip.'</font></td>		
</tr>';//16,17,15,15,25,12
			}
			

			//Build Report Html
			$content=$tableheader.$tbrow.'</table>';

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
			$pdf->SetKeywords('Naija Art Mart, NSE, Audit Trail');			
			$pdf->SetFont('dejavusans', 'B', 20, '', true);
						
			// set header and footer fonts
			$pdf->setFooterFont(Array('timesI', 'I', 10, '', true));
			$pdf->setHeaderFont(Array('timesI', 'I', 10, '', true));			
			$pdf->SetHeaderData($logo, 0, 2, 'Audit Trail Report');						
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
		$username=''; $startdate=''; $enddate='';
		
		if ($this->input->post('username')) $username = trim($this->input->post('username'));		
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
		
		$qry="SELECT loginfo.*,DATE_FORMAT(ActionDate,'%d %b %Y @ %H:%i') AS ADate FROM loginfo WHERE (DATE_FORMAT(ActionDate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."')";
		
		if (trim($username) != '') $qry .= " AND (TRIM(Username)='".$this->db->escape_str($username)."')";
		
		$qry .= " ORDER BY ActionDate,`name`";
					
		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		if ($results)
		{
			$data=array();

			if (is_array($results))
			{
				foreach($results as $row):
					$tp=array($row['ADate'],$row['Username'],$row['Name'],$row['Operation'],str_replace("\'","'",html_entity_decode($row['Activity'])),$row['remote_ip']);
					
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
			
			$this->load->view('admin/logrep_ad_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('admin');
		}
	}
}
