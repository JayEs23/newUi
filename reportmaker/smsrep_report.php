<?php

	session_start();//Continue the session



	//Make sure that the input come from a posted form. Otherwise quit immediately

	if ($_SERVER["REQUEST_METHOD"] <> "POST") die("<h1 style='text-decoration:blink; color:#c00;'>Unauthorized Access!</h1>");

	

	error_reporting(E_ERROR);

	ini_set('memory_limit', '512M');

	

	include('../ajax/loginfo.inc');

	require_once('../ajax/Connections/conn.php');

	require_once('config/lang/eng.php');

	require_once('tcpdf.php');

	require_once("pChart/pData.class");

	require_once("pChart/pChart.class");



	if  (isset($_POST["action"]))

	{

		$Location=''; $fromdate=''; $todate='';

				

		$action = strtoupper(trim($_POST["action"]));

		

		if (isset($_POST["phone"])) $phone = trim($_POST["phone"]);

		if (isset($_POST["fromdate"])) $fromdate = trim($_POST["fromdate"]);

		if (isset($_POST["todate"])) $todate = trim($_POST["todate"]);

		

		mysql_select_db($database_conn, $conn);

				

		if ($action=='DISPLAY_REPORT')

		{

			$crit=''; $u='';

					

			$sql = "SELECT * FROM sentsms WHERE (TRIM(DATE_FORMAT(msgdate,'%Y-%m-%d')) BETWEEN '".$fromdate."' AND '".$todate."')";

							

			if ($phone)

			{

				if (strtoupper($phone)!= "ALL")

				{

					$arr=explode(',',$phone);

					

					if (count($arr)>0)

					{						

						for($i=0; $i<count($arr); $i++):

							if ($arr[$i])

							{

								if ($u == '') $u="(TRIM(sender)='". trim($arr[$i]) . "')"; else $u .= " OR (TRIM(sender)='". trim($arr[$i]) . "')";

							}

						endfor;

					}

				}					

				

				if ($u !='') $crit .= " AND (". $u . ")";

			}

			

			if (trim($crit)!='') $sql .= $crit;

			

			$sql .= " ORDER BY sender,msgdate";

					#$file = fopen('idong.txt',"w");	fwrite($file,$sql); fclose($file);

			$result = mysql_query($sql, $conn) or die('GET MESSAGES RECORDS ERROR: '.mysql_error());



			$TotalExpected = mysql_num_rows($result);

			

			if ($TotalExpected==0)

			{

				$rows[]="There is no transaction record for the selected query criteria";

				

				echo json_encode($rows);

			}else

			{

				$logo='logo.png';

				

				//Get Company Info

				$qry="SELECT * FROM parameters";

				$rsLogo = mysql_query($qry, $conn) or die('ORGANISATION INFORMATION RETRIEVAL ERROR: '.mysql_error());

				$recNo=mysql_num_rows($rsLogo);

				

				if ($recNo>0)

				{

					$row_rsLogo = mysql_fetch_assoc($rsLogo);

					$address=''; $groupname='';

					if ($row_rsLogo['groupname']) $groupname=$row_rsLogo['groupname'];

					if ($row_rsLogo['address']) $address=$row_rsLogo['address'];

				}			

				

/////////////////////////////////////REPORT BELOW/////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////

				//Table Headers

				$tableheader='

<table nobr="false" border="1" cellpadding="2" cellspacing="0" width="100%">	

<thead>

  <tr bgcolor="#EEEEEE">

    <th valign="middle" align="center"  width="7%"><b><font size="11pt" face="Arial">S/NO</font></b></th>

    <th align="center" valign="middle" width="17%"><b><font size="11pt" face="Arial">SENDER</font></b></th>

    <th align="center" valign="middle" width="18%"><b><font size="11pt" face="Arial">MESSAGE DATE</font></b></th>

    <th align="center" valign="middle" width="29%"><b><font size="11pt" face="Arial">MESSAGE</font></b></th>

	<th align="left" valign="middle" width="29%"><b><font size="11pt" face="Arial">RESPONSE TO MESSAGE</font></b></th>

  </tr>

</thead>';

  				

				$sn=0;

				

				while ($row = mysql_fetch_array($result)):

					$sn += 1;

					

					$sender='&nbsp;'; $mdt='&nbsp;'; $tid='&nbsp;'; $msg='&nbsp;'; $dt=''; $resp='&nbsp;';

					

					if ($row['sender']) $sender=trim($row['sender']);

					if ($row['msgdate']) $dt=trim($row['msgdate']);

					if ($row['msg']) $msg=trim($row['msg']);

					if ($row['response']) $resp=trim($row['response']);

					

					#Get Date in dd MMM yyyy

					if ($dt)

					{

						$d=explode(' ',$dt);

						

						$mdt=date('j M Y',strtotime($d[0])).' @ '.$d[1];

					}

					

					$tbrow .= '

<tr align="center">

	<td valign="middle" align="center"  width="7%"><font size="11pt" face="Georgia, Times New Roman, Times, serif">'.number_format($sn,0).'</font></td>

	<td valign="middle" align="center" width="17%"><font size="11pt" face="Georgia, Times New Roman, Times, serif">'.$sender.'</font></td>										

	<td valign="middle" align="center" width="18%"><font size="11pt" face="Georgia, Times New Roman, Times, serif">'.$mdt.'</font></td>										

	<td valign="middle" align="center" width="29%"><font size="11pt" face="Georgia, Times New Roman, Times, serif">'.$msg.'</font></td>

	<td valign="middle" align="left" width="29%"><font size="11pt" face="Georgia, Times New Roman, Times, serif">'.$resp.'</font></td>

</tr>';

				endwhile;

				

				//Build Report Html

				$content=$tableheader.$tbrow.'</table>';					



				//**************Display the chart here*******************

				if ($fromdate==$todate)

				{

					$repdate='Received Messages Report For '.date('jS M Y',strtotime($fromdate));

				}else

				{

					$repdate='Received Messages Report Between '.date('jS M Y',strtotime($fromdate)).' And '.date('jS M Y',strtotime($todate));

				}

				

				$reportheader .= '

					<p align="center" >

					<font size="13pt" face="Arial,Helvetica, sans-serif"><b><u>'.$repdate.'</u></b></font>

					</p>';

				

				//////PDF OUT STARTS//////////////

				//////////////////////////////////

				// create new PDF document

				// page orientation (P=portrait, L=landscape)

				$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				

				// set document information

				$pdf->SetCreator('betPRO');

				$pdf->SetAuthor('betPRO');

				$pdf->SetTitle('betPRO');

				$pdf->SetSubject('betPRO');

				$pdf->SetKeywords('betPRO');

				

				$pdf->SetFont('helvetica', 'B', 20, '', true);

				

				// set default header data

				//$pdf->SetHeaderData('images/'.$logo, PDF_HEADER_LOGO_WIDTH, $groupname, '');

				

				// set header and footer fonts

				$pdf->setFooterFont(Array('timesI', 'I', 10, '', true));

				$pdf->setHeaderFont(Array('timesI', 'I', 10, '', true));

				//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

				//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

				

				if ($logo)

				{

					if (file_exists('../images/'.$logo))

					{

						if (file_exists("../images/".$logo))

						{

							$ext=strtolower(trim(getExtension("../images/".$logo)));

									

							if (($ext=='jpg') || ($ext=='png') || ($ext=='gif'))

							{

								$pdf->SetHeaderData('', 0, '', 'Received Messages Report');

							}else

							{

								$pdf->SetHeaderData('', 0, '', 'Received Messages Report');	

							}

						}else

						{

							$pdf->SetHeaderData('', 0, '', 'Received Messages Report');	

						}

					}else

						{

							$pdf->SetHeaderData('', 0, '', 'Received Messages Report');	

						}

				}else

				{

					$pdf->SetHeaderData('', 0, '', 'Received Messages Report');	

				}

				

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

				$pdf->setFontSubsetting(true);// set default font subsetting mode

				

				// Add a page

				$pdf->AddPage();

								

				//Print Logo				

				$header='

					<table border="0" cellpadding="4" cellspacing="0">'; 

					if ($logo)

					{

						if (file_exists("../images/".$logo))

						{

							$ext=strtolower(trim(getExtension("../images/".$logo)));

									

							if (($ext=='jpg') || ($ext=='png') || ($ext=='gif'))

							{

								$header.='<tr>	

									<td valign="top" width="100%;" align="center"><img width="120px" src="../images/'.$logo.'"></td>

									

								</tr>';

								#<td valign="top" align="left" width="100%">'.$reportheader.'</td>

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

					}else

					{

						$header.='<tr>	

								<td valign="top" align="center" width="100%">'.$reportheader.'</td>

							</tr>';

					}

					

					$header.='</table>

				';

			

				//*******BUILD CONTENTS HERE***********************

								

				$content = $reportheader.$content;			

				

				$pdf->writeHTMLCell($w=0, $h=$pdf->GetY(), $x='', $y='0.30', $header, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

			

				$pdf->SetFont('times', '', 12);

				$pdf->writeHTMLCell($w=0, $h=$pdf->GetY(), $x='', $y='1.4', $content, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

				

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

				

				//Image(file,TCPDF x,TCPDF y,imagewidth,imageheight,Image Type,

				#if (file_exists($chartfilename)) $pdf->Image($chartfilename,$x,$y+0.5,$pagewidth*0.6,0,'PNG','','N',false,300,'C',false,false,0,true,false);		



				// Close and output PDF document

				// This method has several options, check the source code documentation for more information.

				$rows=array();

				

				$outputfile="../reports/SMSMessagesReport.pdf";

				

								

				$pdf->Output($outputfile, 'F');

					

				$rows[]="SMSMessagesReport.pdf";

				

				/*echo "<script language='javascript' type='text/javascript' >window.open('".$outputfile."',null,'left=0, top=0, height=700, width= 1000, status=no, resizable= yes, scrollbars= yes, toolbar= no,location= no, menubar= no');</script>";*/

				

				echo json_encode($rows);

				

				//unlink($chartfilename);

				//============================================================+

				// END OF REPORT SECTION

				//============================================================+

			}//End Build Report

		}

	}

	

function getExtension($str) 

{

	 $i = strrpos($str,".");

	 if (!$i) { return ""; }

	 $l = strlen($str) - $i;

	 $ext = substr($str,$i+1,$l);

	 return $ext;

 }

 

 /////////////////////////////////////////////////

//$file = fopen('idong.txt',"w");	fwrite($file,$t); fclose($file); exit();

?>