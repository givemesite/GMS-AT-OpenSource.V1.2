<?php
	/////////////////////////////////////////////////
	/////////////////////////////////////////////////
	/////////////////////////////////////////////////
	//
	//		The CLI command line interface for 
	//      Fibbonaci
	//
	//
	//if it finds a item moving up in the table 
	//it will set the item in the investment planer
	//if the data needs to be updated ie. the row 
	//moves up in the list the data will update
	//
	//
	/////////////////////////////////////////////////
	/////////////////////////////////////////////////
	//
	/////////////////////////////////////////////////
	//auto_trade.php
	/////////////////////////////////////////////////
	//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	error_reporting(E_ALL);
	ini_set('display_errors', '0');
	ini_set('log_errors', '0');	
//C:/php/bin/AHP/32bit-php-5.6/php.exe c:/php/WWW/Stock_Market/A_SYNC/a_sync.php
//$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);	

//include('c:/php/WWW/Stock_Market/INCLUDE/cl_colors.php');
include("$SERVER_DIR/LOOP/loop_stats.php");
include("$SERVER_DIR/fibonacci/seo/seo_api.php");
include("$SERVER_DIR/LOOP/all_starts_here.php");
include("$SERVER_DIR/fibonacci/seo/seo_finviz_api.php");
include("$SERVER_DIR/fibonacci/seo/seo_finviz_api_freq.php");
include("$SERVER_DIR/LOOP/basic_test.php");
include("$SERVER_DIR/LOOP/watch_plan.php");


//echo$cli."\n";
function execInBackground($cmd= null) {
    if (substr(php_uname(), 0, 7) == "Windows"){
        pclose(popen("start /B ". $cmd, "r")); 
    }
    else {
        exec($cmd . " > /dev/null &");  
    }
}
function TCP_watchdog($port= null){
	$cli_string = 'c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe -b 127.0.0.1:' . $port;
$acli = ($cli_string);

//pclose(popen($acli, 'r')); 

 execInBackground ($acli);
 
//	  

//$commandString = 'start ""  php-cgi -b 127.0.0.1:9001'; 
//pclose(popen($commandString, 'r')); 
////////////////////////

}
 


 FUNCTION RUN_AUTTOTRADE($conn, $watch_mode,$SERVER_DIR,$BACK_CALL,$loop_count ){


//////////////
//sessions
//
//
//
///////////////

$balance = $_SESSION["BALANCE"];
//some stuff for mysql data base
$servername         = "127.0.0.1";
$username           = "root";
$password           = "";
$dbname             = "stock_market_local";

$_SESSION["MAX_STOCK_QTY_BID"] = '';
$_SESSION["MAX_STOCK_QTY"]     = '';
$_SESSION["MAX_HOLD"]		   = '';
$_SESSION["MAX_RISK"]		   = '';
$_SESSION["MIN_ROI"]		   = '';

$First_Stock_SYMB  = $_SESSION["First_Stock_SYMB"];
$Second_Stock_SYMB = $_SESSION["Second_Stock_SYMB"];
$Thired_Stock_SYMB = $_SESSION["Thired_Stock_SYMB"];
$Forth_Stock_SYMB  = $_SESSION["Forth_Stock_SYMB"];


//echo "Starting Server........... DONE \n";

//echo "Loging into robinhood........... DONE \n";

	// RH_API_LOGIN($call_type, $symbol, $price, $order_type, $qty);




for ($x = 0; $x <= 149;$x++
) { 


//make a connection to the database we will be using the most - local stock data
$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);

//	sleep(00);
	if ($x   >=  140 ){
		$x= 0;
		
		
	}
	
	
	
	/////////////////////////////////////////////////
	/////////////////////////////////////////////////
	/////////////////////////////////////////////////
	//
	//		Simple script to buy and sell on
	//      Fibbonaci
	//
	//
	//
	//
	/////////////////////////////////////////////////
	/////////////////////////////////////////////////
	//
	/////////////////////////////////////////////////
	//
	/////////////////////////////////////////////////	
	//average all stocks in local table 

	//keep a look at all the stocks 
	//WATCH_STOCKS($watch_mode,$SERVER_DIR,$BACK_CALL,null,null,$x); //gets the stocks from all the seo LOOP/       watch_plan.php
	
	
	
	
	
	/////////////////////////////////////////////////
	/////////////////////////////////////////////////
	/////////////////////////////////////////////////
	//
	//		seo server for
	//      Fibbonaci
	//
	//
	//if it finds a item moving up in the table 
	//it will set the item in the investment planer
	//if the data needs to be updated ie. the row 
	//moves up in the list the data will update
	//
	//
	/////////////////////////////////////////////////
	/////////////////////////////////////////////////
	//
	/////////////////////////////////////////////////
	//
	/////////////////////////////////////////////////	
	// search engines  APIS 	
	//RUN_FINVIZ();
//	RUN_FREQ_FINVIZ();
	
	
//if you want to use investing.com
//	RUN_INVESTING();//runs the investing planer /                  seo_investing_api.php
//	RUN_INVESTING_helper(); //                                     seo_investing_api_Service.php
//	RUN_INVESTING_helper_long();

	//mysqli_close($conn);
			
	






//echo $Router_responce;
//foreach($out as $key => $value)

//{

 //   echo "\n ".$value."\n";

//}

//


	$host = 'localhost';
$ports = array(9001,9002,9003,9004,9005,
			   9006,9007,9008,9009,9010,
			   9011,9012,9013,9014,9015,
			   9016,9017,9018,9019,9020,
			//   9021,9022,9023,9024,9025,
			//   9026,9027,9028,9029,9030,
			//   9031,9032,9033,9034,9035,
			//   9036,9037,9038,9039,9040,
			//   9041,9042,9043,9044,9045,
			//   9046,9047,9048,9049,9050
			   );

foreach ($ports as $port)
{
    $connection = @fsockopen($host, $port, $errno, $errstr, 10);

    if (is_resource($connection))
    {
        echo '' . $host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.' . "\n";

        fclose($connection);
    }

    else
    {
		TCP_watchdog($port);
        echo '' . $host . ':' . $port . ' is not responding.' . "\n";
    }
	sleep(2);
}

//usleep(50);


	
 // 
$time = date('m/d/y g:i:sA');//set the date
date_default_timezone_set('America/New_York'); //set the time zone

		

		
//////////////
//buffer stuff
//
//
//delay
///////////////	
		
//
//print_r($GLOBALS);

//End of for loop 
mysqli_close($conn);
}
//exit();


}

