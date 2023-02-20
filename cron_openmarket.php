
<?php
	date_default_timezone_set('Africa/Lagos');
	error_reporting(-1); ini_set('display_errors', 'On');
	set_time_limit(0);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"http://www.naijaartmart.com/admin/ArtxCore/OpenMarket");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec ($ch);
	curl_close ($ch);
?>