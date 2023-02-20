<?php	

	error_reporting(E_ERROR);

		

	require_once('config/lang/eng.php');

	require_once('tcpdf.php');



	$myFile = "sampleset.txt";	

	$file=fopen($myFile,"r") or exit("Unable to open file!");	

	$theData = fread($file, filesize($myFile));	

	fclose($file);	

	//echo $theData;

	

	//////PDF OUT STARTS//////////////

	//////////////////////////////////

	// create new PDF document

	// page orientation (P=portrait, L=landscape)

	$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	

	// set document information

	$pdf->SetCreator('Idongesit Akpan');

	$pdf->SetAuthor('betPRO');

	$pdf->SetTitle('betPRO');

	$pdf->SetSubject('betPRO');

	$pdf->SetKeywords('Surveys, Store, Outlets, Shops, Price, POS, Map, gps, SOS, Share Of Shelf,Parallel Import, Import, Parallel, Visited, Visit, Located');

	

	$pdf->SetFont('helvetica', 'B', 20, '', true);

	

	// set default header data

	//$pdf->SetHeaderData('images/'.$logo, PDF_HEADER_LOGO_WIDTH, $groupname, '');

	

	// set header and footer fonts

	$pdf->setHeaderFont(Array('timesI', 'I', 10, '', true));

	$pdf->setFooterFont(Array('timesI', 'I', 10, '', true));

	//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

	//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	

	$pdf->SetHeaderData('', 0, '', 'Set Pdf utf-8 Character Sets');

	

	$pdf->setHeaderFont(Array('timesI', 'I', 10, '', true));

	

	// set default monospaced font

	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	

	//set margins

	$pdf->SetMargins("0.4", 0.4, "0.4");

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

	// set default font subsetting mode

	$pdf->setFontSubsetting(true);#setFontSubsetting(false)

	

	// Set font

	// dejavusans is a UTF-8 Unicode font, if you only need to print standard ASCII chars, you can use core fonts like

	// helvetica or times to reduce file size.

	

	// Add a page

	// This method has several options, check the source code documentation for more information.

	$pdf->AddPage();

	

	// Set some content to print

	//$html = <<<EOD EOD;

	

	



	//*******BUILD CONTENTS HERE***********************

					

	$content = $reportheader.$contentvisited;			

	

	$pdf->writeHTMLCell($w=0, $h=$pdf->GetY(), $x='', $y='0.30', $theData, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);





	// Close and output PDF document

	// This method has several options, check the source code documentation for more information	

	$outputfile="testpdf.pdf";	

					

	$pdf->Output($outputfile, 'F');

	

	echo "<script language='javascript' type='text/javascript' >window.open('".$outputfile."',null,'left=0, top=0, height=700, width= 1000, status=no, resizable= yes, scrollbars= yes, toolbar= no,location= no, menubar= no');</script>";

	//============================================================+

	// END OF REPORT SECTION

	//============================================================+

?>