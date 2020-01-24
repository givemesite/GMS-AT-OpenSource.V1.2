<?php
//kris galante krisgcell@gmail.com
//include('c:/php/WWW/Stock_Market/config.php');
	usleep(1000);
			//if we are buying or selling the stock 	
			if ($call_type='TRADE'){
				$url = 'http://127.0.0.1/Stock_Market/API/alpaca_call_trade.php?action=trade';
				}else{$url = 'http://127.0.0.1/Stock_Market/API/alpaca_call_trade.php';}
				
$fields = array(
	'Trading_name' => urlencode(	$symbol),//BDR
	'symbol' => urlencode(			"GNMX"),//BDR
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
echo $out1;
//close connection
curl_close($ch);