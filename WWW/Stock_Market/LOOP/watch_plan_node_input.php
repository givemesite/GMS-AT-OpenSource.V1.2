<?php

$HTTP_MODE = true;
include('c:/php/WWW/Stock_Market/config.php');
include("$SERVER_DIR/LOOP/logic_functions.php");
//include("$SERVER_DIR/LOOP/loop_stats.php");
//include("$SERVER_DIR/fibonacci/seo/seo_api.php");
//include("$SERVER_DIR/LOOP/all_starts_here.php");
//include("$SERVER_DIR/fibonacci/seo/seo_finviz_api.php");
//include("$SERVER_DIR/fibonacci/seo/seo_finviz_api_freq.php");
//include("$SERVER_DIR/LOOP/basic_test.php");
//include("$SERVER_DIR/MODELS/galante.php");
//include("$SERVER_DIR/fibonacci/seo/seo_investing_api_indexs.php");
//make a connection to the database we will be using the most - local stock data
$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
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

	
function neural_set_node($stocks_watch_mode,$SERVER_DIR,$BACK_CALL,$emu,$sim,$in_loop_count){

								include("$SERVER_DIR/LOOP/time_base.php");

	
	
							
							
							$PREsub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
							
							$equery = "SELECT AVG(`5DT`) FROM `day_trades`";
							if ($eresult=mysqli_query($PREsub_conn,$equery)){ 
								
								while ($rawa=mysqli_fetch_row($eresult))
								{$a = $rawa;
									
								}}
								
								
								mysqli_close($PREsub_conn);		
								
								
								
								//add adverages to the index string		
								
								$lab_test_count = $_SESSION['lab_test_count'];
								//get adverages
								
								$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
								$mqmquery = "SELECT * FROM `advs` LIMIT 1";
								if ($aresult=mysqli_query($sub_conn,$mqmquery)){ 
									// Fetch one and one row
									while ($get_advsnum=mysqli_fetch_row($aresult))
									{
										$old_advs      = $get_advsnum[0];
										$old_day      = $get_advsnum[2];
										$old_a      = $get_advsnum[3];
									}}
									mysqli_close($sub_conn);usleep(200);
									
									
									
									
									$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
									$qmquery = "SELECT * FROM `day_trades` LIMIT 1";
									if ($bresult=mysqli_query($sub_conn,$qmquery)){ 
										// Fetch one and one row
										while ($get_num=mysqli_fetch_row($bresult))
										{
											$table_number      = $get_num[0] + 20;
											$table_offset      = $get_num[0] + 200;
										}}
										mysqli_close($sub_conn);usleep(200);
										
										
										
										$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
										$dquery = "SELECT COUNT(*) FROM `day_trades`";
										if ($cresult=mysqli_query($sub_conn,$dquery)){ 
											// Fetch one and one row
											while ($get_count=mysqli_fetch_row($cresult))
											{
												$table_count      = $get_count[0];
												
											}}
											mysqli_close($sub_conn);usleep(200);
											

												
												
												
												$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
												$cquery = "SELECT AVG(`OCG`) FROM `day_trades`";
												if ($fresult=mysqli_query($sub_conn,$cquery)){ 
													// Fetch one and one row
													while ($get_adv=mysqli_fetch_row($fresult))
													{
														$ocg      = $get_adv[0];
														
													}}
													mysqli_close($sub_conn);usleep(200);
													
													
													
													$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
													$aquery = "SELECT AVG(`frequency`) FROM `day_trades`";
													if ($gresult=mysqli_query($sub_conn,$aquery)){ 
														// Fetch one and one row
														while ($get_frq=mysqli_fetch_row($gresult))
														{
															$frequency= $get_frq[0];
															
														}}
														mysqli_close($sub_conn);usleep(200);
														
														
														
														
														$base_count =  		    round($table_count       ,0,PHP_ROUND_HALF_UP);
														//006-06 to 60
														$base_ocg   =  "00000000"  .  round(($ocg + $ocg /20-2)      ,0,PHP_ROUND_HALF_UP).".9";
														$base_frq   =               round(($frequency-$ocg) ,0,PHP_ROUND_HALF_UP);
														$base_frq = 0;
														
														
														
														
														
														
														
														
														if (!isset($sim)){
															// $WEIGHT['FREQ'] =
															}else{
															
															
														}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
							
$model					= "";	
		
		
		//echo $qquery; sleep(10);
		
//only calc advarages after 20 rows		


			//	echo "\n The Price Now:".$the_price_now."\n";
			
			//print_r($trade);
if ($sim["sim"]==TRUE){
		

	
			$the_hour       = $sim["h"]; 
			$the_min        = $sim["m"];
			$the_seconds    = date('s');
			$the_year       = $sim["y"];//year
			$the_mon        = $sim["mo"];//month
			$the_day        = $sim["d"];//
		
			$FREQ			= null;
	
}
else

	{
		
			$the_hour       = date('g'); 
			$the_min        = date('i');
			$the_seconds    = date('s');
			$the_year       = date('Y');//year
			$the_mon        = date('m');//month
			$the_day        = date('d');//mon-fri
			$the_ap         = date('a');//am or pm
			$the_day_symbl  = date('D');
			$FREQ			= null;

	}
	//echo "TEST";

	
	
//echo $trade[0];
// echo "\n";
//echo $trade[1];
// echo "\n"; 
//echo $trade[2];
// echo "\n"; 
//echo $trade[4];
// echo "\n"; 			

	$stock_was_bught		= null;		
	$day_trades_sold		= null;
	//$day_trades_used	 	= FALSE;
	$dec_price 				= 0;


			
//chech if we sold a trade today	
//dont over sell
$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
//see if we have done a day trade today
		$query = "SELECT * FROM `cycle_sell` WHERE `YEAR` = '$the_year' AND `MON` = '$the_mon' AND `DAY` = '$the_day' LIMIT 1 ";

	if ($result=mysqli_query($sub_conn,$query)){ 
	// Fetch one and one row
	while ($quantitative_trade=mysqli_fetch_row($result))
		{
//ECHO"\nONE TRADE WAS EXECUTED TODAY.";			
$day_trades_sold = TRUE;//continue(1);
	//ECHO"|\n\n Day Trade End Trigger........   DONE";		
	}}
mysqli_close($sub_conn);usleep(60);


	
//check to see if we bught a set of stock today
//dont over buy	
$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
//see if we have done a day trade today
		$query = "SELECT * FROM `buy` WHERE `YEAR` = '$the_year' AND `MON` = '$the_mon' AND `DAY` = '$the_day' LIMIT 1 ";
	if ($result=mysqli_query($sub_conn,$query)){ 
	// Fetch one and one row
	while ($call_quantitative_trade=mysqli_fetch_row($result))
		{
			if ($day_trades_sold <> TRUE){
	//			ECHO"\nONE TRADE IN PROGRESS.";			
			}
$day_trades_used = TRUE;//continue(1);
	//ECHO"|\n\n Day Trade End Trigger........   DONE";		
	}}
mysqli_close($sub_conn);usleep(60);
	//re cast the vars
	
$quantitative_trade = null;			
$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		$query = "SELECT * FROM `buy` WHERE `YEAR` = '$the_year' AND `MON` = '$the_mon' AND `DAY` = '$the_day' LIMIT 1 ";
	if ($result=mysqli_query($sub_conn,$query)){ 
	// Fetch one and one row
	while ($quantitative_trades=mysqli_fetch_row($result))
	{
		$quantitative_trade = null;
		$quantitative_trade = $quantitative_trades;
		$stock_was_bught = TRUE;
		
	}}			
			
mysqli_close($sub_conn);usleep(60);			
			

		$symb = mysqli_real_escape_string($conn, ($_GET['symb']));

					$the_price_now = null;

			$num_get_string = $_GET['row'];
			$row = preg_replace('/[^0-9]/', '', $num_get_string);
			$num_get_string = $_GET['row'];
			$row = preg_replace('/[^0-9]/', '', $num_get_string);
			
			$dec_price       =  $trend_glob->{'1. open'} - $trade[4] ;
			$the_price_now   =  $trend_glob->{'1. open'};	
			// $model .
			$model = " $xmodel (GAIN : $GAIN_Percent  TIMESTAMP :".$atime_date[1]." FREQ : $FREQ  Adverages :$old_advs $old_a )" ;
			
			
			
			//if we dont have price data
			//if (!isset($the_price_now))
			//{break;}
			
 
			//echo $the_price_now;
			include("c:/php/WWW/Stock_Market/LOOP/sell_risks.php");
			include("c:/php/WWW/Stock_Market/LOOP/buy_risks.php");
			




	usleep(300);


mysqli_close($loop_sub_conn);
}

echo neural_set_node($stocks_watch_mode,$SERVER_DIR,$BACK_CALL,null,null,null);