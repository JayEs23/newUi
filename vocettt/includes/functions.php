<?php

include_once "dbconfig.php";

function gotoLogin($source){
	$host=strtolower(trim($_SERVER['HTTP_HOST']));
		
		if (strtolower(trim($source)) == 'admin')
		{
			if ($host=='localhost')
			{
				echo '<script>window.location.replace("http://localhost/lvi/admin/Signin");</script>';
			}else
			{
				echo '<script>window.location.replace("https://www.naijaartmart.com/admin/Signin");</script>';
			}	
		}else
		{
			if ($host=='localhost')
			{
				echo '<script>window.location.replace("http://localhost/lvi/ui/Home");</script>';
			}else
			{
				echo '<script>window.location.replace("https://www.naijaartmart.com/ui/Home");</script>';
			}	

		}
}

function GetBlockchainUserID()
	{		
		$max=0;
		
		//investors
		$sql="SELECT MAX(userId) AS userId FROM investors";
			
		$query = $this->db->query($sql);
				
		if ( $query->num_rows() > 0 )
		{
			$row = $query->row();			
			if (intval($row) > 0)
			{
				if (intval($row->userId) > intval($max)) $max = $row->userId;
			}
		}
		
		//brokers
		$sql="SELECT MAX(userId) AS userId FROM brokers";
			
		$query = $this->db->query($sql);
				
		if ( $query->num_rows() > 0 )
		{
			$row = $query->row();	
					
			if (intval($row) > 0)
			{
				if (intval($row->userId) > intval($max)) $max = $row->userId;
			}
		}
		
		//issuers
		$sql="SELECT MAX(userId) AS userId FROM issuers";
			
		$query = $this->db->query($sql);
				
		if ( $query->num_rows() > 0 )
		{
			$row = $query->row();	
					
			if (intval($row) > 0)
			{
				if (intval($row->userId) > intval($max)) $max = $row->userId;
			}
		}
		
		//settings
		$sql="SELECT MAX(userId) AS userId FROM settings";
			
		$query = $this->db->query($sql);
				
		if ( $query->num_rows() > 0 )
		{
			$row = $query->row();	
					
			if (intval($row) > 0)
			{
				if (intval($row->userId) > intval($max)) $max = $row->userId;
			}
		}
		
		$max += 1;
		
		if ($max==30) $max=31;
		
		return $max;
	}


?>