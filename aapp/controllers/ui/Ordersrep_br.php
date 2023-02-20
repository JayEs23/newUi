<?php session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
date_default_timezone_set('Africa/Lagos');
set_time_limit(0);

require_once(realpath('.')."/vendor/autoload.php"); 
require_once(realpath('.').'/reportmaker/config/lang/eng.php');
require_once(realpath('.').'/reportmaker/tcpdf.php');
require_once(realpath('.').'/classes/PHPExcel.php');

class Ordersrep_br extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
	}
	
	function DisplayReport()
	{
		$broker_id=''; $symbol=''; $ordertype=''; $transtype=''; $orderstatus=''; $startdate=''; $enddate='';
		
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));		
		if ($this->input->post('ordertype')) $ordertype = trim($this->input->post('ordertype'));	
		if ($this->input->post('transtype')) $transtype = trim($this->input->post('transtype'));	
		if ($this->input->post('orderstatus')) $orderstatus = trim($this->input->post('orderstatus'));			
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
		
		$qry = "SELECT direct_orders.*,(SELECT user_name FROM investors WHERE (TRIM(investors.email)=TRIM(direct_orders.investor_id)) LIMIT 0,1) AS investor FROM direct_orders WHERE (DATE_FORMAT(orderdate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND (TRIM(broker_id)='".$this->db->escape_str($broker_id)."')";
		
		if (trim($symbol) <> '') $qry .= " AND (TRIM(symbol)='".$symbol."')";		
		if (trim($ordertype) <> '') $qry .= " AND (TRIM(ordertype)='".$ordertype."')";
		if (trim($transtype) <> '') $qry .= " AND (TRIM(transtype)='".$transtype."')";
		if (trim($orderstatus) <> '') $qry .= " AND (TRIM(orderstatus)='".$orderstatus."')";
		
		$qry .= " ORDER BY orderdate";

		$query = $this->db->query(stripslashes($qry));
		
		$results = $query->result_array();
		
		if ($results)
		{
			$data=array();

			if (is_array($results))
			{
				foreach($results as $row):
					$dt=''; $otyp=''; $ttyp=''; $sta='';
										
					if ($row['orderdate']) $dt=date('d M Y',strtotime($row['orderdate']));
					if ($row['ordertype']) $otyp=ucwords(strtolower(trim($row['ordertype'])));
					if ($row['transtype']) $ttyp=ucwords(strtolower(trim($row['transtype'])));
					if ($row['orderstatus']) $sta=ucwords(strtolower(trim($row['orderstatus'])));
					
					$tp=array($dt,$row['order_id'],$row['symbol'],number_format($row['qty'],0),number_format($row['price'],2),$otyp,$row['investor'],$ttyp,$sta);
			
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
		$period=''; $ReportTitle=''; $broker_id=''; $symbol=''; $startdate=''; $enddate='';
		$ordertype=''; $transtype=''; $orderstatus='';
		
		if ($this->input->post('broker_id')) $broker_id = trim($this->input->post('broker_id'));
		if ($this->input->post('symbol')) $symbol = trim($this->input->post('symbol'));	
		if ($this->input->post('ordertype')) $ordertype = trim($this->input->post('ordertype'));	
		if ($this->input->post('transtype')) $transtype = trim($this->input->post('transtype'));	
		if ($this->input->post('orderstatus')) $orderstatus = trim($this->input->post('orderstatus'));	
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
				$outputfile="reports\ordersbrreport_".str_replace(' ','-',$dstart).".pdf";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile="reports/ordersbrreport_".str_replace(' ','-',$dstart).".pdf";
			}
			
			$filename="ordersbrreport_".str_replace(' ','-',$dstart).".pdf";
		}else
		{
			if (strtolower(trim($_SERVER['HTTP_HOST']))=='localhost')
			{
				$outputfile="reports\ordersbrreport_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
			}elseif (strtolower(trim($_SERVER['HTTP_HOST']))=='www.naijaartmart.com')
			{
				$outputfile="reports/ordersbrreport_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
			}
			
			$filename="ordersbrreport_from_".str_replace(' ','-',$dstart).'_to_'.str_replace(' ','-',$dend).".pdf";
		}
		
		$outputfile=getcwd()."/".$outputfile;
				
		$qry = "SELECT direct_orders.*,(SELECT user_name FROM investors WHERE (TRIM(investors.email)=TRIM(direct_orders.investor_id)) LIMIT 0,1) AS investor FROM direct_orders WHERE (DATE_FORMAT(orderdate,'%Y-%m-%d') BETWEEN '".$startdate."' AND '".$enddate."') AND (TRIM(broker_id)='".$this->db->escape_str($broker_id)."')";
		
		if (trim($symbol) <> '') $qry .= " AND (TRIM(symbol)='".$symbol."')";		
		if (trim($ordertype) <> '') $qry .= " AND (TRIM(ordertype)='".$ordertype."')";
		if (trim($transtype) <> '') $qry .= " AND (TRIM(transtype)='".$transtype."')";
		if (trim($orderstatus) <> '') $qry .= " AND (TRIM(orderstatus)='".$orderstatus."')";
		
		$qry .= " ORDER BY orderdate";
	
		$query = $this->db->query(stripslashes($qry));
		
		$logo='images/logo.png';
		
		//Get client logo
		$clientlogo='';
		
		if ($query->num_rows() == 0 )
		{		
			if ($startdate and $enddate)
			{
				echo "There is no trade order record for the selected period.";
			}else
			{
				echo "There is no trade order record.";
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
	<td align="center" valign="middle" width="10%"><b><font size="10pt" face="Arial">ORDER DATE</font></b></td>
	<td align="center" valign="middle" width="11%"><b><font size="10pt" face="Arial">ORDER ID</font></b></td>
	<td align="center" valign="middle" width="10%"><b><font size="10pt" face="Arial">ASSET</font></b></td>
	<td align="center" valign="middle" width="10%"><b><font size="10pt" face="Arial">TOKENS</font></b></td>
	<td align="right" valign="middle" width="10%"><b><font size="10pt" face="Arial">PRICE (NGN)</font></b></td>
		
	<td align="center" valign="middle" width="11%"><b><font size="10pt" face="Arial">ORDER TYPE</font></b></td>	
	
	<td align="center" valign="middle" width="18%"><b><font size="10pt" face="Arial">INVESTOR</font></b></td>	
	
	<td align="center" valign="middle" width="10%"><b><font size="10pt" face="Arial">TRANS. TYPE</font></b></td>
	
	<td align="center" valign="middle" width="10%"><b><font size="10pt" face="Arial">STATUS</font></b></td>
  </tr>
</thead>';//10,11,10,10,10,11,18,10,10
			$sn=0;
			
			while ($row = $query->unbuffered_row('array'))
			{					
				$sn++; $oid='&nbsp;'; $sym='&nbsp;'; $tok='&nbsp;'; $amt='&nbsp;';
				$em='&nbsp;'; $pr='&nbsp;'; $dt='&nbsp;'; $inv='&nbsp;';
				
				if ($row['order_id']) $oid = $row['order_id'];
				if ($row['orderdate']) $dt=date('d M Y',strtotime($row['orderdate']));
				if ($row['symbol']) $sym = $row['symbol'];
				if ($row['qty']) $tok = number_format($row['qty'],0);
				if ($row['price']) $pr = number_format($row['price'],2);
				if ($row['total_amount']) $amt = number_format($row['total_amount'],2);				
				if ($row['ordertype']) $otyp=ucwords(strtolower(trim($row['ordertype'])));
				if ($row['investor']) $inv = $row['investor'];				
				if ($row['transtype']) $ttyp=ucwords(strtolower(trim($row['transtype'])));
				if ($row['orderstatus']) $sta=ucwords(strtolower(trim($row['orderstatus'])));
											
				$tbrow .= '
<tr align="center">										
	<td valign="middle" align="center" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$dt.'</font></td>	
	<td valign="middle" align="center" width="11%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$oid.'</font></td>	
	<td valign="middle" align="center" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$sym.'</font></td>
	<td valign="middle" align="center" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$tok.'</font></td>
	<td valign="middle" align="right" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$pr.'</font></td>	
	<td valign="middle" align="center" width="11%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$otyp.'</font></td>	
	<td valign="middle" align="center" width="18%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$inv.'</font></td>	
	<td valign="middle" align="center" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$ttyp.'</font></td>		
	<td valign="middle" align="center" width="10%"><font size="9pt" face="Georgia, Times New Roman, Times, serif">'.$sta.'</font></td>
</tr>';//10,11,10,10,10,11,18,10,10
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
			$pdf->SetKeywords('Naija Art Mart, NSE, Trade Order, Broker');			
			$pdf->SetFont('dejavusans', 'B', 20, '', true);
						
			// set header and footer fonts
			$pdf->setFooterFont(Array('timesI', 'I', 10, '', true));
			$pdf->setHeaderFont(Array('timesI', 'I', 10, '', true));			
			$pdf->SetHeaderData($logo, 0, 2, 'Trade Orders Report');						
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
			
			$this->load->view('ui/ordersrep_br_view',$data);
		}else
		{
			$this->getdata_model->GoToLogin('');
		}
	}
}
