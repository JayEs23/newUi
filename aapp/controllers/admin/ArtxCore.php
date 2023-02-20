<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
date_default_timezone_set('Africa/Lagos');
set_time_limit(0);

class ArtxCore extends CI_Controller {
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
	}	
	
	function Test()
	{
		$file = fopen('cron-test.txt',"a"); fwrite($file,date("Y-m-d H:i:s")."\r\n"); fclose($file);
	}
	
	function CloseMarket()
	{
		// echo "string"; die();
		$logdate=date('Y-m-d H:i:s');
		$today=date('Y-m-d');
		
		//$today='2020-11-10';
		//$logdate='2020-11-10 '.date('H:i:s');
				
		$ret=$this->getdata_model->GetMarketStatus();
		
		$sta=$ret['MarketStatus'];	

		// echo $sta; die();
		if (trim(strtoupper($sta)) == 'CLOSED')
		{
			//Update historical_prices at the close of day
			$sql="SELECT * FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".$today."')";
		
			$query=$this->db->query($sql);
			
			if ($query->num_rows() > 0)
			{
				//Clear daily_price
				$this->db->trans_start();
				$this->db->delete('historical_prices', array('price_date' => $today)); 				
				$this->db->trans_complete();				
				
				$prices = $query->result_array();
					
				foreach($prices as $row):
					if ($row['symbol'] and $row['close_price'])
					{						
						//Compute price change at the close of day
						$prev=0;
					
						if (floatval($row['previous_close_price']) > 0) $prev=$row['previous_close_price'];
						
						$change=floatval($row['close_price']) - $prev;
						
						$this->db->trans_start();
					
						$dat=array(
							'symbol' 				=> $this->db->escape_str($row['symbol']),
							'previous_close_price'	=> $this->db->escape_str($row['previous_close_price']),
							'open_price' 			=> $this->db->escape_str($row['open_price']),
							'high_price'			=> $this->db->escape_str($row['high_price']),
							'low_price'				=> $this->db->escape_str($row['low_price']),
							'close_price'			=> $this->db->escape_str($row['close_price']),
							'change'				=> $this->db->escape_str($change),
							'trades'				=> $this->db->escape_str($row['trades']),
							'volume'				=> $this->db->escape_str($row['volume']),
							'trade_value'			=> $this->db->escape_str($row['trade_value']),
							'price_date' 			=> $this->db->escape_str($today),
							'last_updated_date' 	=> $this->db->escape_str($row['last_updated_date'])			
						);
						
						$this->db->insert('historical_prices', $dat);
						
						$this->db->trans_complete();
					}
				endforeach; //End $prices
				
				//Log activity
				$username='System';
				$fullname='Naija Art Mart Core';
				$operation='Closed Market';
				$activity='Market For '.date('d M Y').' Was Closed By System At '.$logdate.'.';
				$remote_ip=$_SERVER['REMOTE_ADDR'];
				$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
				
				//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
				$this->getdata_model->LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
			}
			
			//Check for expired orders
			$sql="SELECT * FROM orders WHERE (DATE_FORMAT(expirydate,'%Y-%m-%d %H:%i:%s') <= '".$logdate."')";
		
			$query=$this->db->query($sql);
			
			// print_r($query); die();
			if ($query->num_rows() > 0)
			{//Expired
				$rows = $query->result_array();
				
				foreach($rows as $row):
					if ($row['order_id'])
					{
						$this->db->trans_start();
					
						$dat=array('orderstatus' => 'Expired');							
						$this->db->where(array('order_id'=>$this->db->escape_str($row['order_id'])));
						$this->db->update('orders', $dat);
						
						$this->db->trans_complete();
					}
				endforeach;
			}
			
			
			//Check for expired messages
			$msgs=$this->getdata_model->CheckIfMessageDateHasExpired();
			
			if (count($msgs) > 0)
			{
				foreach($msgs as $msg):
					$this->db->trans_start();					
					$dat=array('display_status' => '0');							
					$this->db->where('msgid',$msg['msgid']);
					$this->db->update('messages', $dat);						
					$this->db->trans_complete();
				endforeach;	
			}		
			
			
			//Check if listing period has ended today
			$sql="SELECT * FROM primary_market WHERE (DATE_FORMAT(listing_ends,'%Y-%m-%d') < DATE_FORMAT(NOW(),'%Y-%m-%d')) AND (TRIM(listing_status)='Started')";
			
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0 )
			{
				$listings = $query->result_array();
				
				foreach($listings as $row):
					$this->db->trans_start();
					
					$dat=array('listing_status'=>'Ended', 'market_date'=>$today);
					$this->db->where('art_id', $row['art_id']);
					$this->db->update('primary_market', $dat);
					
					$this->db->trans_complete();
					
					//Update issuers_to_pay in readiness for payment
					$sq="SELECT * FROM issuers_to_pay WHERE (issuer_uid=".$row['uid'].") AND (TRIM(symbol)='".$row['symbol']."')";
					
					$qry = $this->db->query($sq);
					
					if ($qry->num_rows() > 0 )
					{
						$this->db->trans_start();
					
						$dat=array('listing_ended'=>1);
						$this->db->where(array('issuer_uid'=>$row['uid'], 'symbol'=>$row['symbol']));
						$this->db->update('issuers_to_pay', $dat);
						
						$this->db->trans_complete();
					}					
					
				endforeach;
			}
		}
	}
	
	function OpenMarket()
	{		
		$logdate=date('Y-m-d H:i:s');
		$today=date('Y-m-d');
		
		$ret=$this->getdata_model->GetMarketStatus();		
		$sta=$ret['MarketStatus'];		
		
		if (trim(strtoupper($sta)) == 'OPEN')
		{		
			$sql="SELECT * FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".$today."')";
		
			$query=$this->db->query($sql);
			// print_r($query->num_rows()); die();
			if ($query->num_rows() == 0) $this->SetDayPrice();
			
			//Empty price_changes table
			$this->db->trans_start();
			$this->db->truncate('price_changes');				
			$this->db->trans_complete();
			
			//Log activity
			$username='System';
			$fullname='Naija Art Mart Core';
			$operation='Opened Market';
			$activity='Market For '.date('d M Y').' Was Opened By System At '.$logdate.'.';
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
			$this->getdata_model->LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
		}
		
		//Check for expired messages
		$msgs=$this->getdata_model->CheckIfMessageDateHasExpired();
		
		if (count($msgs) > 0)
		{
			foreach($msgs as $msg):
				$this->db->trans_start();					
				$dat=array('display_status' => '0');							
				$this->db->where('msgid',$msg['msgid']);
				$this->db->update('messages', $dat);						
				$this->db->trans_complete();
			endforeach;	
		}
	}
	
	function SetDayPrice()
	{//$file = fopen('aaa.txt',"w"); fwrite($file,print_r("In 2",true)); fclose($file);	
		$logdate=date('Y-m-d H:i:s');
		$today=date('Y-m-d');
		$yesterday=date('Y-m-d',strtotime('yesterday'));
		
		//$today='2020-09-02';
		//$logdate='2020-09-02 '.date('H:i:s');
		//$yesterday='2020-09-01';
		
		//check if yesterday was weekend of public holiday
		$weekend_holiday=$this->getdata_model->IsDateWeekendOrHoliday($yesterday);
		// print_r($weekend_holiday); die();
		
		if ($weekend_holiday)
		{
			$latestdate=$this->getdata_model->GetLatestDate('historical_prices','price_date');
			if ($latestdate == '') {
				$latestdate=$this->getdata_model->GetLatestDate('daily_price','price_date');
			}	
			
			$sql="SELECT * FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')='".$latestdate."')";
		}else
		{
			//Get yesterday's prices from historical_prices table
			 $sql="SELECT * FROM daily_price WHERE (DATE_FORMAT(price_date,'%Y-%m-%d')!='".$today."')";	
		}
				
		$query=$this->db->query($sql);
		// print_r($query->result_array()); die;
		if ($query->num_rows() > 0)
		{
			//Clear daily_price
			$this->db->trans_start();
			$this->db->truncate('daily_price');				
			$this->db->trans_complete();
			
			
			$prices = $query->result_array();
			
			foreach($prices as $row):
				if ($row['symbol'] and $row['close_price'])
				{
					$this->db->trans_start();
				
					$dat=array(
						'symbol' 				=> $this->db->escape_str($row['symbol']),
						'previous_close_price'	=> $this->db->escape_str($row['close_price']),
						'open_price' 			=> $this->db->escape_str($row['close_price']),
						'close_price'			=> $this->db->escape_str($row['close_price']),
						'price_date' 			=> $this->db->escape_str($today),
						'last_updated_date' 	=> $this->db->escape_str($logdate)			
					);
					
					$this->db->insert('daily_price', $dat);
					
					$this->db->trans_complete();
				}
			endforeach; //End $prices	
			
			//Log activity
			$username='System';
			$fullname='Naija Art Mart Core';
			$operation='Set Daily Prices';
			$activity='Daily Prices For '.date('d M Y').' Was Set By System At '.$logdate.'.';
			$remote_ip=$_SERVER['REMOTE_ADDR'];
			$remote_host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
			
			//LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$ip,$host)
			$this->getdata_model->LogTradeActivity($logdate,$activity,$username,$fullname,$operation,$remote_ip,$remote_host);
		}
		
		//Check for expired registration
		$sql="SELECT * FROM temp_users WHERE (DATE_FORMAT(expire,'%Y-%m-%d %H:%i') <= DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i'))";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 )
		{
			$where="(DATE_FORMAT(expire,'%Y-%m-%d %H:%i') <= DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i'))";
			
			$this->db->trans_start();									
			$this->db->where($where);
			$this->db->delete('temp_users');					
			$this->db->trans_complete();
		}		
				
		//Check in primary_market table if there is a listing that starts today
		$sql="SELECT * FROM primary_market WHERE (DATE_FORMAT(listing_starts,'%Y-%m-%d') <= DATE_FORMAT(NOW(),'%Y-%m-%d')) AND (TRIM(listing_status)='Pending')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 )
		{
			$listings = $query->result_array();
			
			foreach($listings as $row):
				$this->db->trans_start();
				
				$dat=array('listing_status'=>'Started', 'market_date'=>$today);
				$this->db->where('art_id', $row['art_id']);
				$this->db->update('primary_market', $dat);
				
				$this->db->trans_complete();
			endforeach;
		}
		
				
		//Check for end of holding period (create symbol record in daily_price)
		$sql="SELECT * FROM primary_market WHERE (DATE_FORMAT(holding_period_ends,'%Y-%m-%d') <= DATE_FORMAT(NOW(),'%Y-%m-%d')) AND (TRIM(listing_status)='Ended')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 )
		{
			$listings = $query->result_array();
			
			foreach($listings as $row):
				if ($row['symbol'] and $row['price'])
				{
					//Check if asset already been added to daily price
					$sq="SELECT * FROM daily_price WHERE (TRIM(symbol)='".$this->db->escape_str($row['symbol'])."')";
					
					//$file = fopen('aaa.txt',"a"); fwrite($file,print_r($qry."\r\n",true)); fclose($file);	
					
					$qry=$this->db->query($sq);
				
					if ($qry->num_rows() == 0)
					{
						$this->db->trans_start();
					
						$dat=array(
							'symbol' 				=> $this->db->escape_str($row['symbol']),
							'previous_close_price'	=> '0',
							'open_price' 			=> $this->db->escape_str($row['price']),
							'close_price'			=> $this->db->escape_str($row['price']),
							'price_date' 			=> $this->db->escape_str($today),
							'last_updated_date' 	=> $this->db->escape_str($logdate)			
						);
						
						$this->db->insert('daily_price', $dat);
						
						$this->db->trans_complete();	
					}
										
					//Update listing_status
					$this->db->trans_start();
					
					$dat=array('listing_status'=>'Secondary');
					$this->db->where('symbol', $row['symbol']);
					$this->db->update('primary_market', $dat);
					
					$this->db->trans_complete();
				}
			endforeach; //End $prices
		}
		
		//Check if listing period has ended today
		$sql="SELECT * FROM primary_market WHERE (DATE_FORMAT(listing_ends,'%Y-%m-%d') <= DATE_FORMAT(NOW(),'%Y-%m-%d')) AND (TRIM(listing_status)='Started')";
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0 )
		{
			$listings = $query->result_array();
			
			foreach($listings as $row):
				$this->db->trans_start();
				
				$dat=array('listing_status'=>'Ended', 'market_date'=>$today);
				$this->db->where('art_id', $row['art_id']);
				$this->db->update('primary_market', $dat);
				
				$this->db->trans_complete();
				
				//Update issuers_to_pay in readiness for payment
				$sq="SELECT * FROM issuers_to_pay WHERE (issuer_uid=".$row['uid'].") AND (TRIM(symbol)='".$row['symbol']."')";
				
				$qry = $this->db->query($sq);
				
				if ($qry->num_rows() > 0 )
				{
					$this->db->trans_start();
				
					$dat=array('listing_ended'=>1);
					$this->db->where(array('issuer_uid'=>$row['uid'], 'symbol'=>$row['symbol']));
					$this->db->update('issuers_to_pay', $dat);
					
					$this->db->trans_complete();
				}					
				
			endforeach;
		}
		
		
		return true;
	}

	public function SendServerIPAdrress()
	{
		return $_SERVER['SERVER_ADDR'];
	}
	
	
	public function index()
	{
		#$this->load->view('home_view');
	}
}
