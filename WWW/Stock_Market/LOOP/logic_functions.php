<?php
//logic functions
//the function to make calls to the api for robinhood



FUNCTION gms_API($call_type, $symbol, $price, $order_type, $qty){
	usleep(1000);
			//if we are buying or selling the stock 	
			if ($call_type=='TRADE'){
				$url = 'https://127.0.0.1/Stock_Market/API/alpaca.php?action=trade';
				}else{$url = 'http://127.0.0.1/Stock_Market/API/alpaca.php';}
				
$fields = array(
	'Trading_name' => urlencode(	$symbol),//BDR
	'symbol' => urlencode(			$symbol),//BDR
	'price' => urlencode(			$price),//1.88
	'ORDER_TYPE' => urlencode(		$order_type),//sell/buy
	'quantity' => urlencode(		$qty)//1
);

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

// Decode the response.
	ob_start();
//execute post
	$result = (curl_exec($ch));
			$out1 = ob_get_contents();
	ob_end_clean();
//	print_r($out1);
 return $out1;
//close connection
curl_close($ch);

			}




//drop in for alpaca.markets/api
FUNCTION brokerage_API($call_type, $symbol, $price, $order_type, $qty){
	usleep(1000);
			//if we are buying or selling the stock 	
			if ($call_type='TRADE'){
				$url = 'http://127.0.0.1/Stock_Market/API/alpaca.php?action=trade';
				}else{$url = 'http://127.0.0.1/Stock_Market/API/alpaca.php';}
				
$fields = array(
	'Trading_name' => urlencode(	$symbol),//BDR
	'symbol' => urlencode(			$symbol),//BDR
	'price' => urlencode(			$price),//1.88
	'ORDER_TYPE' => urlencode(		$order_type),//sell/buy
	'quantity' => urlencode(		$qty)//1
);

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

// Decode the response.
	ob_start();
//execute post
	$result = (curl_exec($ch));
			$out1 = ob_get_contents();
	ob_end_clean();
//	print_r($out1);
 return $out1;
//close connection
curl_close($ch);

			}

			FUNCTION RH_API_LOGIN($call_type, $symbol, $price, $order_type, $qty){
			//if we are buying or selling the stock 	
			if ($call_type=='TRADE'){
				$url = 'http://127.0.0.1/Stock_Market/API/rh_login.php?action=trade';
				}else{$url = 'http://127.0.0.1/Stock_Market/API/rh_login.php';}
				
$fields = array(
	'Trading_name' => urlencode(	$symbol),//BDR
	'symbol' => urlencode(			$symbol),//BDR
	'price' => urlencode(			$price),//1.88
	'ORDER_TYPE' => urlencode(		$order_type),//sell/buy
	'quantity' => urlencode(		$qty)//1
);

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

// Decode the response.
	ob_start();
//execute post
	$result = (curl_exec($ch));
			$out1 = ob_get_contents();
	ob_end_clean();
//	print_r($out1);
 return $out1;
//close connection
curl_close($ch);

			}
			
	


FUNCTION DAY_TRADE($offset_time, $comp_name){

	
	
		//some stuff for mysql 
$servername         = "127.0.0.1";
$username           = "root";
$password           = "";
$dbname             = "cache";
$time               = time();
	$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);

$datetime1 = new DateTime(date('Y-m-d H:i:s', time()));
$datetime2 = new DateTime(date('Y-m-d H:i:s'));
$oDiff = $datetime1->diff($datetime2);

//echo $oDiff->y.' Years <br/>';
//echo $oDiff->m.' Months <br/>';
//echo $oDiff->d.' Days <br/>';
//echo $oDiff->h.' Hours <br/>';
//echo $oDiff->i.' Minutes <br/>';
//echo $oDiff->s.' Seconds <br/>';


	
	//see if we have this row in the table
		// ORDER BY `time` DESC LIMIT 50
		$query = "SELECT * FROM `ledger_balance` WHERE `time` <= '$time' DESC LIMIT 5";//see if we have this stock
		
	if ($result=mysqli_query($conn,$query)){ 
	// Fetch one row
	while ($row=mysqli_fetch_row($result))
		{
			
			

	}
	}
	
//mysqli_close($conn);
	
	
}


