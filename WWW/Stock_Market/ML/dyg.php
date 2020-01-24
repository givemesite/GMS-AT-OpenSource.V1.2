<?php

//sample training from model 
$nodesample = array(["test",1,2,3,5]);
//$sample= array([$the_price_now,$the_hr ]);
$samples = [[1,1,5,5,"B",$nodesample], [1,2], [2,3], [3,45], [4,6]];			
//$samples = [[60-6-51], [61-6-51], [62-6-5], [63-6-5], [64-6-5]];



//training from real time price 
$targets = [1.10, 0.95, 1.22, 1.20, 1.19];
	//print_r($samples);
	
	session_start();
	
	$test = $_SESSION['ML_Training'];
	
	//echo $test;
	
	$key_secret = "C:/php/www/Stock_Market/API/api.KEY"; // I was running the code on localhost, and hence the path!
		$api_key = file_get_contents($key_secret);
		$url = "http://127.0.0.1/Stock_Market/ML/";
		$cookie = "C:/php/www/Stock_Market/API/AI.COOKIE"; // I was running the code on localhost, and hence the path!
		$fields_string = '';
		$user = $api_key ;
		$pass = $api_secret;
		$submit = "AI"; //
$rpdt =array([76]);
$pdct_a = json_encode($rpdt);
		$array_a = json_encode($samples);
		$array_b = json_encode($targets);
		
		
		
		$fields = array(
		'API'=>urlencode($api_key),
		'id'=>urlencode($pass),
		'array_a'=>urlencode($array_a),
		'array_b'=>urlencode($array_b),
				'predict'=>urlencode("1"),
	//'predict'=>urlencode($pdct_a),
		'USE'=>urlencode($submit)
        );
		
		//url-ify the data for the POST
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string,'&');
		
		$ch = curl_init ($url);
		curl_setopt($ch,CURLOPT_ENCODING , "gzip");
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
	// Decode the response.
		ob_start();
		//execute post
		$result = (curl_exec($ch));
		$out1 = ob_get_contents();
		ob_end_clean();
		curl_close($ch);
		$dec_result = json_decode($result);
	print_r($result);die();