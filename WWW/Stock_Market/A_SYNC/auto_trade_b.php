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
include("$SERVER_DIR/fibonacci/seo/seo_finviz_api_freq.php");  //total historey of a company +20 years
include("$SERVER_DIR/fibonacci/seo/seo_finviz_api_5d_HIS.php");//the last five days of moveing advreagres 
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
	RUN_FREQ_FINVIZ();
	
	sleep(1);
	
$servername         = "127.0.0.1";
$username           = "root";
$dbname             = "stock_market_local";
$password           = "";
$bsub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);

		$aquery = "SELECT * FROM `day_trades` WHERE `5DT` = '' LIMIT 500";
	if ($aresult=mysqli_query($bsub_conn,$aquery)){

	while ($rawquantitative_trade=mysqli_fetch_row($aresult))
		{$quantitative_trade = $rawquantitative_trade;
		
$PREsub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);

		$bquery = "SELECT * FROM `stock` WHERE `trading_name` = '".$quantitative_trade[1]."' LIMIT 1 ";
	if ($bresult=mysqli_query($PREsub_conn,$bquery)){ 

	while ($rawa=mysqli_fetch_row($bresult))
		{$a = $rawa;

	}}

	mysqli_close($PREsub_conn);
	$PREsub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
				$cquery = "UPDATE `day_trades` SET `5DT` = '".$a[8]."' WHERE `id` = '".$quantitative_trade[0]."'";
HD_BACKTRACK($quantitative_trade[1]);

usleep(200);
		mysqli_close($PREsub_conn);

	}}	mysqli_close($bsub_conn);

	
	
//if you want to use investing.com
//	RUN_INVESTING();//runs the investing planer /                  seo_investing_api.php
//	RUN_INVESTING_helper(); //                                     seo_investing_api_Service.php
//	RUN_INVESTING_helper_long();

	//mysqli_close($conn);
			
			
 // 


$time = date('m/d/y g:i:sA');//set the date
date_default_timezone_set('America/New_York'); //set the time zone

//echo "\033[31mred\033[37m\r\n";
//echo "\033[32mgreen\033[37m\r\n";
//echo "\033[41;30mblack on red\033[40;37m\r\n";


//start the main menu for stock tradeing durning the day 

	
		
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

