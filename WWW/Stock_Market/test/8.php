<?php
//echo getHostByName(getHostName());
//echo exec('c:\php\www\Stock_Market\upnp\upnpc.exe -e GMS_Stock_Cloud -a '.getHostByName(getHostName()).' 80 3005 TCP');
//include('c:/php/WWW/Stock_Market/config.php');
//include("$SERVER_DIR/LOOP/logic_functions.php");
//include("$SERVER_DIR/LOOP/all_starts_here.php");
$port= "3".rand(100,200);
FUNCTION PRE_REST_API($ip, $port, $api_key, $API_PK, $HASH_TOKEN){
	usleep(1000);

	$api_key_file = "C:/php/www/Stock_Market/API/api.KEY"; // I was running the code on localhost, and hence the path!
	
$api = file_get_contents($api_key_file);
				$url = 'https://stocks.givemesite.com/MOBILE/APP/login_api/remote_port_route_control.php';
				
				
$fields = array(
'LOC_IP' => urlencode(	''),
	'ip' => urlencode(				$ip),//BDR
	//'port' => urlencode(			),//BDR
	'api_key' => urlencode(			$api),//1.88
	'API_PK' => urlencode(			$API_PK),//sell/buy
	'HASH_TOKEN' => urlencode(		$HASH_TOKEN)//1
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
FUNCTION CDN_REST_API($ip, $port, $api_key, $API_PK, $HASH_TOKEN){
	usleep(1000);

	$api_key_file = "C:/php/www/Stock_Market/API/api.KEY"; // I was running the code on localhost, and hence the path!
	
$api = file_get_contents($api_key_file);
				$url = 'https://stocks.givemesite.com/MOBILE/APP/login_api/remote_port_route.php';
				
				
$fields = array(
'LOC_IP' => urlencode(	''),
	'ip' => urlencode(				$ip),//BDR
	'port' => urlencode(			$port),//BDR
	'api_key' => urlencode(			$api),//1.88
	'API_PK' => urlencode(			$API_PK),//sell/buy
	'HASH_TOKEN' => urlencode(		$HASH_TOKEN)//1
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
			
		$responce= PRE_REST_API($my_ip, $port, $api_key, $API_PK, $HASH_TOKEN);
		$my_ip=getHostByName(getHostName());	
	 if ($responce=="ok"){}else{die();}
	$responce= CDN_REST_API($my_ip, $port, $api_key, $API_PK, $HASH_TOKEN);
	
	$cli = ('c:\php\www\Stock_Market\upnp\upnpc.exe -e GMS_Stock_Cloud -a '.$_SERVER['SERVER_ADDR'].' 80 '.$port.' TCP');
echo$cli."\n";
$Router_responce = exec($cli,$out);
echo $Router_responce;
foreach($out as $key => $value)

{

    echo "\n ".$value."\n";

}
