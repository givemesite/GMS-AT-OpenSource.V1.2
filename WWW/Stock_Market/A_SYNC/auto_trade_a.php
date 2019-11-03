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
	RUN_FINVIZ();
//	RUN_FREQ_FINVIZ();
	
	sleep(1);
//if you want to use investing.com
//	RUN_INVESTING();//runs the investing planer /                  seo_investing_api.php
//	RUN_INVESTING_helper(); //                                     seo_investing_api_Service.php
//	RUN_INVESTING_helper_long();

	//mysqli_close($conn);
			
			
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

