<meta http-equiv="refresh" content="0"><?php
//////////////////////////////////////////////
//////////////////////////////////////////////
//
//	looks at stock in data set and makes
//   buy and sell calls baised on triggers
//
//
// watch plan .php kris galante
//////////////////////////////////////////////
//Parts of this script link to 
//////////////////////////////////////////////	
//	c:/php/WWW/Stock_Market/LOOP/sell_risks.php for documenting 
//	c:/php/WWW/Stock_Market/LOOP/buy_risks.php  for documenting 


//to do

//auto trade server

//get/save system historic data from stock table - helps find a stock sooner | time server - DONE

//calculate gain adv bias, from mysql stock table - improve thee gain and loss functions - DONE

//get price back from alpaca and set trade value - save the price returned from alpace in the buy table 

//fixed but now need to make call back url for returning order


//mobile 




//cdn api & token




//condition's for trade






//used to test live data 

//MYSQL DAY TRADES TYPE
		//OC = opening cycle
		//CC = closeing cycle
		//CW = call watch/wait 
		//CB = call buy
		//CS = call sell
		//CN = call new buy cycle
		
		
		//CO = cycle one
		//CT = cycle 2 and 3
		//CF = cycle 4
		//TW = Win
		//TL = Loss
		//DW = trigger dip watch
		
//////////////////////////////////////////////		
	//Strategies 	
//////////////////////////////////////////////	
	
//clean all old data in mysql
		//delete old data in tables 
		//stocks
		//day_tradess
	//when time is > 9:25am
	
//////////////////////////////////////////////	
	//tradeing days
//////////////////////////////////////////////	
	//alpha api
//////////////////////////////////////////////	
	//if bught, sold
//////////////////////////////////////////////
$HTTP_MODE = true;
include('c:/php/WWW/Stock_Market/config.php');
//include("$SERVER_DIR/LOOP/logic_functions.php");
//include("$SERVER_DIR/LOOP/loop_stats.php");
//include("$SERVER_DIR/fibonacci/seo/seo_api.php");
//include("$SERVER_DIR/LOOP/all_starts_here.php");
//include("$SERVER_DIR/fibonacci/seo/seo_finviz_api.php");
//include("$SERVER_DIR/fibonacci/seo/seo_finviz_api_freq.php");
//include("$SERVER_DIR/LOOP/basic_test.php");
//include("$SERVER_DIR/MODELS/galante.php");
//include("$SERVER_DIR/fibonacci/seo/seo_investing_api_indexs.php");
//make a connection to the database we will be using the most - local stock data
	include("$SERVER_DIR/LOOP/loop_stats.php");
	include("$SERVER_DIR/fibonacci/seo/seo_api.php");
	include("$SERVER_DIR/LOOP/all_starts_here.php");
	include("$SERVER_DIR/fibonacci/seo/seo_finviz_api.php");
	include("$SERVER_DIR/fibonacci/seo/seo_finviz_api_freq.php");
	include("$SERVER_DIR/LOOP/basic_test.php");
	include("$SERVER_DIR/MODELS/galante.php");
include("$SERVER_DIR/LOOP/watch_plan.php");

//get node id 
	$node_id = $_GET['node'];

		
		
		
if (isset(($_GET['node']))){
//	echo $pre_sql_inject;
		//keep a look at all the stocks 
		$sql_inject = " LIMIT 5";
		$output = (	WATCH_STOCKS($watch_mode,$SERVER_DIR,$BACK_CALL,null,null,$x,$WEIGHT,$BIASES,$USLEEP,$SLEEP,$RAM_SPAWN, $sql_inject , $pre_sql_inject)); //gets the stocks from all the seo LOOP/       watch_plan.php
			
}	