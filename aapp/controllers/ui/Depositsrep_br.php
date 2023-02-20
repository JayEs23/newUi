<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
date_default_timezone_set('Africa/Lagos');
set_time_limit(0);

require_once(realpath('.')."/vendor/autoload.php"); 
require_once(realpath('.').'/reportmaker/config/lang/eng.php');
require_once(realpath('.').'/reportmaker/tcpdf.php');
require_once(realpath('.').'/classes/PHPExcel.php');

class Depositsrep_br extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	
	function DisplayReport()
	{
		$email=''; $startdate=''; $enddate=''; $channel=''; $trans_status='';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('channel')) $channel = trim($this->input->post('channel'));	
		if ($this->input->post('trans_status')) $trans_status = trim($this->input->post('trans_status'));
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
		
		$qry = "SELECT * FROM payment_log WHERE (DATE_FORMAT(payment_date,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND (TRIM(email)='".$this->db->escape_str($email)."')";
		
		if (trim($channel) <> '') $qry .= " AND (TRIM(channel)='".$channel."')";		
		if (trim($trans_status) <> '') $qry .= " AND (TRIM(trans_status)='".$trans_status."')";
		
		$qry .= " ORDER BY payment_date";

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		if ($results)
		{
			$data=array();

			if (is_array($results))
			{
				foreach($results as $row):
					$dt=''; $amt=''; $fee=''; $sta=''; $bnk=''; $ch='';
										
					if ($row['payment_date']) $dt=date('d M Y H:i',strtotime($row['payment_date']));					
					if ($row['amount']) $amt=number_format($row['amount'],2);
					if ($row['paystack_fees']) $fee=number_format($row['paystack_fees'],2);
					if ($row['trans_status']) $sta=ucwords(strtolower(trim($row['trans_status'])));
					if ($row['bank']) $bnk=ucwords(strtolower(trim($row['bank'])));
					if (strtolower(trim($row['channel']))=='ussd')
					{
						$ch='USSD';
					}elseif (strtolower(trim($row['channel']))=='qr')
					{
						$ch='QR Code';
					}else
					{
						$ch=ucwords(strtolower(trim($row['channel'])));
					}
					
					$tp=array($dt,$amt,$fee,$row['transref'],$row['description'],$ch,$sta,$bnk);
					
					$data[]=$tp;
				endforeach;
			}

			print_r(json_encode($data));
		}else
		{
			print_r(json_encode($results));
		}
	}
	
	function CreatePDFReport()
	{
		$period=''; $ReportTitle=''; $email=''; $startdate=''; $enddate='';
		$channel=''; $trans_status='';
		
		if ($this->input->post('email')) $email = trim($this->input->post('email'));
		if ($this->input->post('channel')) $channel = trim($this->input->post('channel'));	
		if ($this->input->post('trans_status')) $trans_status = trim($this->input->post('trans_status'));
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
				$outputfile="reports\deposit_br_report_".str_replace(' ','-',$dstart).".pdf";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile="reports/deposit_br_report_".str_replace(' ','-',$dstart).".pdf";
			}
			
			$filename="deposit_br_report_".str_replace(' ','-',$dstart).".pdf";
		}else
		{
			if (strtolower(trim($_SERVER['HTTP_HOST']))=='localhost')
			{
				$outputfile="reports\deposit_br_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile="reports/deposit_br_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
			}
			
			$filename="deposit_br_report_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
		}
		
		$outputfile=getcwd()."/".$outputfile;
		//$outputfile=base_url().$outputfile;
		
		$qry = "SELECT * FROM payment_log WHERE (DATE_FORMAT(payment_date,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND (TRIM(email)='".$this->db->escape_str($email)."')";
		
		if (trim($channel) <> '') $qry .= " AND (TRIM(channel)='".$channel."')";		
		if (trim($trans_status) <> '') $qry .= " AND (TRIM(trans_status)='".$trans_status."')";
		
		$qry .= " ORDER BY payment_date";
	
		$query = $this->db->query(stripslashes($qry));
		
		$logo='images/logo.png';
		
		//Get client logo
		$clientlogo='';
		
		//$cl=$this->getdata_model->GetUserLogo($company);//    
		
		//if ($cl) $clientlogo = base_url().'images/'.$cl;
		
		
		if ($query->num_rows() == 0 )
		{		
			if ($startdate and $enddate)
			{
				echo "There is no wallet deposit record for the selected period.";
			}else
			{
				echo "There is no wallet deposit record.";
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
	<td align="center" valign="middle" width="13%"><b><font size="10pt" face="Arial">PAYMENT DATE</font></b></td>
	<td align="right" valign="middle" width="12%"><b><font size="10pt" face="Arial">AMOUNT (NGN)</font></b></td>
	<td align="right" valign="middle" width="12%"><b><font size="10pt" face="Arial">TRANS. FEE (NGN)</font></b></td>
	<td align="center" valign="middle" width="12%"><b><font size="10pt" face="Arial">TRANS. REF.</font></b></td>
	<td align="center" valign="middle" width="16%"><b><font size="10pt" face="Arial">DESCRIPTION</font></b></td>
	<td align="center" valign="middle" width="8%"><b><font size="10pt" face="Arial">CHANNEL</font></b></td>
	<td align="center" valign="middle" width="10%"><b><font size="10pt" face="Arial">STATUS</font></b></td>	
	
	<td align="center" valign="middle" width="17%"><b><font size="10pt" face="Arial">BANK</font></b></td>
  </tr>
</thead>';//13,12,10,10,20,8,10,17
			$sn=0; $tamt=0;
			
			while ($row = $query->unbuffered_row('array'))
			{					
				$dt='&nbsp;'; $amt='&nbsp;'; $fee='&nbsp;'; $ref='&nbsp;';  $bnk='&nbsp;';
				$desc='&nbsp;'; $ch='&nbsp;';  $sta='&nbsp;';
				
				if ($row['payment_date']) $dt=date('d M Y H:i',strtotime($row['payment_date']));					
				
				if ($row['amount'])
				{
					 $amt=number_format($row['amount'],2);
					 $tamt += $row['amount'];
				}
				
				if ($row['paystack_fees']) $fee=number_format($row['paystack_fees'],2);
				if ($row['trans_status']) $sta=ucwords(strtolower(trim($row['trans_status'])));
				if ($row['bank']) $bnk=ucwords(strtolower(trim($row['bank'])));
				if ($row['transref']) $ref=trim($row['transref']);
				if ($row['description']) $desc=trim($row['description']);
				if (strtolower(trim($row['channel']))=='ussd')
				{
					$ch='USSD';
				}elseif (strtolower(trim($row['channel']))=='qr')
				{
					$ch='QR Code';
				}else
				{
					$ch=ucwords(strtolower(trim($row['channel'])));
				}
											
				$tbrow .= '
<tr align="center">										
	<td valign="middle" align="center" width="13%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$dt.'</font></td>	
	<td valign="middle" align="right" width="12%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$amt.'</font></td>	
	<td valign="middle" align="right" width="12%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$fee.'</font></td>
	<td valign="middle" align="center" width="12%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$ref.'</font></td>
	<td valign="middle" align="center" width="16%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$desc.'</font></td>
	<td valign="middle" align="center" width="8%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$ch.'</font></td>	
		
	<td valign="middle" align="center" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$sta.'</font></td>	
		
	<td valign="middle" align="center" width="17%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$bnk.'</font></td>
</tr>';
			}//13,12,10,10,20,8,10,17
			
			$tamt=number_format($tamt,2);
			
			$tablefooter='
			<tfoot>
			  <tr bgcolor="#EEEEEE">
				<th valign="middle" align="right" width="13%"><b><font size="9pt" face="Arial">TOTAL DEPOSIT:&nbsp;</font></b></th>   
			   
			   <th align="right" valign="middle" width="12%"><b><font size="9pt" face="Arial">'.$tamt.'</font></b></th>
			   
			   <th colspan="6" align="right" valign="middle" width="75%"><b><font size="9pt" face="Arial"></font></b></th>
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
			$pdf->SetKeywords('Naija Art Mart, NSE, Wallet Deposits, Investor');			
			$pdf->SetFont('dejavusans', 'B', 20, '', true);
						
			// set header and footer fonts
			$pdf->setFooterFont(Array('timesI', 'I', 10, '', true));
			$pdf->setHeaderFont(Array('timesI', 'I', 10, '', true));			
			$pdf->SetHeaderData($logo, 0, 2, 'Wallet Deposits Report');						
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
	
	
	function GetSymbols()
	{
		$sql="SELECT DISTINCT(symbol),(SELECT title FROM art_works WHERE TRIM(art_works.symbol)=TRIM(daily_price.symbol)) AS title FROM daily_price ORDER BY title";		

		$query=$this->db->query($sql);

		echo json_encode($query->result());

	}#End Of GetSymbols
	
	public function index()
	{
		$data['lastname']=''; $data['firstname']=''; $data['email']=''; $data['phone']=''; $data['pix']='';
		$data['accountstatus'] = ''; $data['role'] = ''; $data['pix'] = '';
		
		$data['CreateAccount']='0';
		$data['AddItem']='0'; $data['EditItem']='0'; $data['DeleteItem']='0'; $data['ClearLogFiles']='0';
		$data['ViewLogReports']='0'; $data['ViewReports']='0'; $data['SetParameters']='0';
		
		$data['SetMarketParameters']=''; $data['ViewOrders']=''; $data['ViewPrices']='';
		$data['BuyAndSellToken']=''; $data['RegisterBroker']=''; $data['PublishWork']='';
		$data['RequestListing']='';
		
		$data['userlogo'] = '';
		
		if (isset($_SESSION['email']))
		{
			$data['email']=trim($_SESSION['email']);
						
			$user=$this->getdata_model->GetUserDetails($data['email']);
								
			#User Info
			if ($user->fullname) $data['fullname']=$user->fullname;
			if ($user->company) $data['company']=$user->company;
			if ($user->accountstatus) $data['accountstatus'] = $user->accountstatus;
			if ($user->datecreated) $data['datecreated'] = $user->datecreated;
			if ($user->usertype) $data['usertype'] = $user->usertype;
			if ($user->phone) $data['phone']=$user->phone;
			
			if ($user->company)
			{
				$data['fullname']=$user->company;
			}elseif ($user->fullname)
			{
				$data['fullname']=$user->fullname;
			}
			
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
			
			$set=$this->getdata_model->GetParamaters();

			if (intval($set->refreshinterval) > 0)
			{
				$data['RefreshInterval'] = $set->refreshinterval;
			}else
			{
				$data['RefreshInterval']=5;
			}
			
			$ret=$this->getdata_model->GetMarketStatus();									
			$data['MarketStatus']=$ret['MarketStatus'];
			$data['ScrollingPrices']=$this->getdata_model->MarketData();
			
			$data['broker_name']=''; $data['broker_id'] = '';
			
			if (trim(strtolower($data['usertype']))=='broker')
			{
				$det = $this->getdata_model->GetBrokerDetails($data['email']);
				
				if ($det->broker_id) $data['broker_id'] = trim($det->broker_id);				
				if ($det->company) $data['broker_name'] = trim($det->company);
			}
			
			$data['balance']=$this->getdata_model->GetWalletBalance($data['email']);			
			
			$this->load->view('ui/depositsrep_br_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('');
		}
	}
}
