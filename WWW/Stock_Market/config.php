<?php
	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//gms stock investing 
	//	System Configuration settings
	//kris galante krisgcell@gmail.com
	//////////////////////////////////////////////
	// GMS INC 2018
	//////////////////////////////////////////////		
	
	// Error settings
	//error_reporting(E_ERROR | E_PARSE);
	//error_reporting(E_ALL ^ E_NOTICE);  
	//error_reporting(E_ALL ^ E_WARNING);
	
	
	//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	ini_set('display_errors', '0');
	ini_set('log_errors', '1');
	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//	set session 
	//	get mysql database
	//	set prams
	//
	//////////////////////////////////////////////
	// Loop of the data owned by user 
	//////////////////////////////////////////////		
	date_default_timezone_set('America/New_York');
	
	session_unset();
	session_start();
	set_time_limit ( 30000000000000000000000000 );
	
	ini_set('memory_limit', '2048M');

	
	
	$SERVER_DIR  = "c:/php/WWW/Stock_Market";
	$SERVER_IP   = "127.0.0.1";
	$SERVER_HOST = "";
	$SERVER_PREF = "IP";//HOST or IP
	
	$api_key_file = "C:/php/www/Stock_Market/API/api.KEY"; // I was running the code on localhost, and hence the path!
	
	$api = file_get_contents($api_key_file);
	
	//AI functions
	include("$SERVER_DIR/AI/index.php");
	
	
	
	
	
	
	function FINVIZ_LOGIN()
	{
		$key_file = "C:/php/www/Stock_Market/API/finviz_user.DATA"; // I was running the code on localhost, and hence the path!
		$key_secret = "C:/php/www/Stock_Market/API/finviz_pass.DATA"; // I was running the code on localhost, and hence the path!
		$api_key = file_get_contents($key_file);
		$api_secret = file_get_contents($key_secret);
		$url = "https://finviz.com/login_submit.ashx";
		$cookie = "C:/php/www/Stock_Market/API/FINVIZ.COOKIE"; // I was running the code on localhost, and hence the path!
		$fields_string = '';
		$user = $api_key ;
		$pass = $api_secret;
		$submit = "login"; // this an actual code, I had used on one of the sites, but the password is fake!
		$fields = array(
		'email'=>urlencode($user),
		'password'=>urlencode($pass),
		'form'=>urlencode($submit)
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
		$output = curl_exec ($ch);
		curl_close($ch);
	}
	
	
	
	
	
	
	
	
	FUNCTION CDN_REST_API($ip, $port, $api_key, $API_PK, $HASH_TOKEN){
		usleep(10);
		
		
		$url = 'https://stocks.givemesite.com/MOBILE/APP/login_api/remote_port_route.php';
		
		
		$fields = array(
		'LOC_IP' => urlencode(	''),
		'ip' => urlencode(				$ip),//BDR
		//'port' => urlencode(			$port),//BDR
		'api_key' => urlencode(			$api_key),//1.88
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
	//make cdn hand-shake 	
	if($HTTP_MODE<>TRUE){
		$my_ip =   file_get_contents('https://stocks.givemesite.com/MOBILE/APP/login_api/remote.php');
		$my_port =	CDN_REST_API($my_ip, $my_port, $api, $API_PK, $HASH_TOKEN);	
	}	
	
	$CDN_URI = "proxy.php?url=". base64_encode("http://".$my_ip.":$my_port");
	
	
	
	
	
	
	
	
	
	FUNCTION gms_cdn_API($cdn, $aSERVER_IP){
		usleep(10);
		//if we are buying or selling the stock 	
		if ($cdn=='cdn'){
			$url = 'http://'.$aSERVER_IP.'/Stock_Market/test/8.php';
		}//else{$url = 'http://127.0.0.1/Stock_Market/API/alpaca.php';}
		
		$fields = array(
		//	'Trading_name' => urlencode(	$symbol),//BDR
		//	'symbol' => urlencode(			$symbol),//BDR
		//	'price' => urlencode(			$price),//1.88
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
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 400); //timeout in seconds
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
	
	$_SESSION["search_new"]		 	= '';
	$_SESSION["search_trends"] 		= '';
	$_SESSION["search_gains"] 		= '';
	$_SESSION["search"] 			= '';
	$search 			= '';
	$row[2] 			= '';
	// Default vars
	$maxStock_onHand	= 8;
	$DegradationPercent = '11.50';
	//protocol single preference
	if ($SERVER_PREF == "HOST"){$BACK_CALL =$SERVER_HOST;}
	if ($SERVER_PREF == "IP")  {$BACK_CALL =$SERVER_IP;}
	
	//MySQL stuff
	$servername         = $BACK_CALL;
	
	$MYSQLIP            = "127.0.0.1";
	$username           = "root";
	$password           = "";
	$iframe_null        = '';
	$conn               = '';
	$_SESSION["search"] = '';
	$search             = '';
	$row[2]             = '';
	
	
	
	
	//a better function to map vals i use it for the freq to time correlation
	function map($value= null, $fromLow= null, $fromHigh= null, $toLow= null, $toHigh= null) {
		$fromRange = $fromHigh - $fromLow;
		$toRange = $toHigh - $toLow;
		$scaleFactor = $toRange / $fromRange;
		
		// Re-zero the value within the from range
		$tmpValue = $value - $fromLow;
		// Rescale the value to the to range
		$tmpValue *= $scaleFactor;
		// Re-zero back to the to range
		return $tmpValue + $toLow;
	}
	
	
	
	
	
	function MYSQL_retry ($MYSQLIP= null, $username= null, $password= null, $dbname= null, $use_rerun= null){
		// Create connection
		$conn = mysqli_connect($MYSQLIP, $username, $password, $dbname);
		// Check connection
		//echo "Starting Mysql Database.... ";
		// Check connection
		if (mysqli_connect_errno())
		{
			echo " \n Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else{
			//echo "DONE \n";
		} 
		if (!$conn) {
			
			RUN_AUTTOTRADE($conn, $watch_mode,$SERVER_DIR,$BACK_CALL,$loop_count,$SERVER_IP); // 
			//include ("c:/php/WWW/Stock_Market/A_SYNC/a_sync.php");
			//re run
			if($use_rerun==true){
			}
			print("\n Connection failed: " . mysqli_connect_error());
		}
		return $conn;
	}
	
	function MYSQL_CONNECTOR($MYSQLIP= null, $username= null, $password= null, $dbname= null, $use_rerun= null){
		// Create connection
		$conn = mysqli_connect($MYSQLIP, $username, $password, $dbname);
		// Check connection
		//echo "Starting Mysql Database.... ";
		// Check connection
		if (mysqli_connect_errno())
		{
			echo " \n Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else{
			//echo "DONE \n";
		} 
		if (!$conn) {
			//$conn =	MYSQL_retry($servername, $username, $password, $dbname);
			RUN_AUTTOTRADE($conn, $watch_mode,$SERVER_DIR,$BACK_CALL,$loop_count,$SERVER_IP); // 
			//include ("c:/php/WWW/Stock_Market/A_SYNC/a_sync.php");
			//re run
			if($use_rerun==true){
			}
			print("\n Connection failed: " . mysqli_connect_error());
		}
		return $conn;
	}
	
	
	function getHTMLByID($id= null, $html= null) {
		$dom = new DOMDocument;
		libxml_use_internal_errors(true);
		$dom->loadHTML($html);
		$node = $dom->getElementById($id);
		if ($node) {
			return $dom->saveXML($node);
		}
		return FALSE;
	}
	
	$servername         = $BACK_CALL;
	$username           = "root";
	$password           = "";
	$dbname             = "stock_market_local";
	
	
	
