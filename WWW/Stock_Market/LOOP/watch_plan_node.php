<?php
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
include("$SERVER_DIR/LOOP/logic_functions.php");
//include("$SERVER_DIR/LOOP/loop_stats.php");
//include("$SERVER_DIR/fibonacci/seo/seo_api.php");
//include("$SERVER_DIR/LOOP/all_starts_here.php");
//include("$SERVER_DIR/fibonacci/seo/seo_finviz_api.php");
//include("$SERVER_DIR/fibonacci/seo/seo_finviz_api_freq.php");
//include("$SERVER_DIR/LOOP/basic_test.php");
//include("$SERVER_DIR/MODELS/galante.php");
include("$SERVER_DIR/fibonacci/seo/seo_investing_api_indexs.php");
//make a connection to the database we will be using the most - local stock data



	
function neural_get_node($stocks_watch_mode=null,$SERVER_DIR=null,$BACK_CALL=null,$emu=null,$sim=null,$in_loop_count=null){
 

	
	
	include("$SERVER_DIR/LOOP/time_base.php");

	
	
	
	
	
	include("$SERVER_DIR/LOOP/multidimensional_hyperbola.php");

//UP TREND


	
//20	21 - 22   23  25  30
//	$GAIN_Percent = 0.08;
	
		//echo "\n\033[4;37mTable Adv\033[0m";echo "	\n";
		//echo "-------------------------------------------------------------------------------\n";
		//echo"\n AVD / PADV: ".$old_advs."/".$old_a." GAIN: ".$GAIN_Percent." OCG".$base_ocg . " FRQ". $base_frq . " ILC".$in_loop_count. "   COUNT". $base_count ."\n";//sleep(3);
		//reaction
		//find gains
		//even
		//Alpaca
			//echo "\n Alpaca Balance: ".$json_obj->buying_power;
			if($day_trades_used <>TRUE){
			sleep(1);
			}
		 $_SESSION['BAL'] = $json_obj->buying_power;
		//a day trade with 25K equity 
		$gain= (round(($ocg),0,PHP_ROUND_HALF_DOWN));
		$seach_gain= "0"  .($gain*$gain)-1;
		$end_gain=   "0"  .($gain*$gain)+1;
		//you will find this kind of trade will make profit around 10:20AM
		"SELECT * FROM `day_trades` WHERE CONVERT(`OCG` USING utf8mb4) >= '".$seach_gain.
		"' AND CONVERT(`OCG` USING utf8mb4) <= '".$end_gain.
		"' AND `frequency` < '".(round(($frequency),0,PHP_ROUND_HALF_DOWN))."' ORDER BY `VOL` DESC LIMIT 200";
		
		
		
		
		
		
		
		
		
		//if we aleredy found a stock and tried to buy it 
		if ($day_trades_used==TRUE){
			$qquery = "SELECT * FROM `day_trades` WHERE CONVERT(`trading_name` USING utf8mb4) = '".$quantitative_trade[1]."' ORDER BY `id` DESC LIMIT 1";
			//sleep(2);
			}else{		
			
			//SELECT * FROM `stock` ORDER BY `CHANGE_PCT` DESC LIMIT 1
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
$model					= "";	
			
		//even	
		if ($in_loop_count % 2 == 0){
		
		//$day_trades_used= null;
		
		
//i saw this had a problem with negitive numbers on a winning stock 		
//AND CONVERT(`5DT` USING utf8mb4) > '".$a[0]."'

		//the best kinda stocks - espoused
		//$qquery = "SELECT * FROM `day_trades` WHERE CONVERT(`OCG` USING utf8mb4) > '".$base_ocg.
		//"' AND `frequency` > '".$base_frq."' LIMIT 150";
		
		//DESC
		
		//$qquery = "SELECT * FROM `day_trades` WHERE CONVERT(`OCG` USING utf8mb4) > '".$base_ocg.
		//"' AND `frequency` > '".$base_frq."' AND `id` < '".$table_offset."'ORDER BY `id`";
		$xmodel = "MODEL: Hyper-Node";
		}else{//here is where i test other odd trading ideas

		//basic trade reaction
		if ($lab_test_count == '1' ){ 
		//test low risk - large gains
		//$qquery = "SELECT * FROM `day_trades` WHERE `frequency` > '3' AND `VOL` > '500' ORDER BY `VOL` LIMIT 50";
		//$model = "MODEL: VOL";
		}
		//high - risk & exposure
		if ($lab_test_count == '3' ){
	//	$qquery = "SELECT * FROM `day_trades` WHERE CONVERT(`OCG` USING utf8mb4) > '".$base_ocg.
	//	"' AND `frequency` > '".$base_frq."' ORDER BY `OCG` DESC LIMIT 50";
		//$model = "MODEL: OC GAIN";
		}		
		
		//high - risk & exposure
		if ($lab_test_count == '5' ){
			
		//$qquery = "SELECT * FROM `day_trades` WHERE CONVERT(`OCG` USING utf8mb4) > '".$base_ocg.
		//"' AND `frequency` > '".$base_frq."' AND CONVERT(`5DT` USING utf8mb4) > '".$a[0]."' ORDER BY `frequency` LIMIT 50";
		//$model = "MODEL: FREQ";
		}		
		}
		//SELECT *
		//FROM `day_trades` 
		//WHERE `PLAN_A_CHANGE_PCT` > '0.0001'
		//ORDER BY `PLAN_A_CHANGE_PCT` < `PRICE`
		//LIMIT 50
		
		
		
			//SELECT * FROM `stock` ORDER BY `CHANGE_PCT` DESC LIMIT 1
			
			
	$pqquery = "SELECT * FROM `stock` ORDER BY `CHANGE_PCT` DESC LIMIT ". $lab_test_count;

	$sub_loop_sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		$trade= null;
	if ($sub_main_trade_loop=mysqli_query($sub_loop_sub_conn,$pqquery)){ 
	// Fetch one row

	while ($sub_trade=mysqli_fetch_row($sub_main_trade_loop))
		{
			$mount_trade = $sub_trade;
		}
	}
	
if ($INDXADV <"0"){
//$model = "MODEL: GAIN";
//	$qquery = "SELECT * FROM `day_trades` WHERE `trading_name` = '".$mount_trade[1]."' LIMIT 1";
}
	
			if ($lab_test_count > '1' ){
			$_SESSION['lab_test_count']= '0';
			$lab_test_count = 0;
			}
		$lab_test_count++;
		$_SESSION['lab_test_count'] = $lab_test_count;
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
			
		$symbol = $_GET['symb'];
		
		
		



$start = microtime(true);


$login_session= $_SESSION['finviz_login'] ;

if ($login_session=='yes'){}

else{FINVIZ_LOGIN();$_SESSION['finviz_login'] = 'yes';}




$url = "https://elite.finviz.com/export.ashx?v=111&t=". $symbol;

$cookie = "C:/php/www/Stock_Market/API/FINVIZ.COOKIE"; // I was running the code on localhost, and hence the path!
$ch = curl_init();
$timeout = 5;
curl_setopt($ch,CURLOPT_ENCODING , "gzip");
			curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie); 
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'User-Agent: a-bot',

    ));
$html = curl_exec($ch);
curl_close($ch);



$stream = fopen('data://text/plain;base64,' . base64_encode($html),'r');


$csv = fgetcsv  ( $stream,  "," , '"') ;

    while (($data = fgetcsv($stream, null, ",")) !== FALSE) {
        $num = count($data);

        $row++;


                $ticker_name   = $data[1];
				  $comp_name   = str_replace(',',' ',str_replace('.',' ',$data[2]));
				  $price_now   = $data[8];
				   $day_high   = 0;
				    $day_low   = 0;
				 $CHANGE_PCT   = str_replace('%','',$data[8]);
			   $CHANGE_RATIO   = $data[9];
				 $CHANGE_VOL   = $data[10];
				 $DATE_ADDED   = time();
					   $TIME   = time();


  
        }
		
		
	fclose ($stream );
		
	$time_elapsed_secs = microtime(true) - $start;	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	
//$symbol = 'MSFT';

$key_file = "C:/php/www/Stock_Market/API/alphavantage.KEY"; // I was running the code on localhost, and hence the path!

$api_key = file_get_contents($key_file);
				$array_count = 0;
				$item_count = 0;
				$trend_glob  = null;
//$api_key = 'SRVVSN6GU8B88U3D';

//$the_url = 	"https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=".$symbol."&interval=1min&apikey=".$api_key."";
$the_url = 	"https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=".$symbol."&interval=1min&apikey=".$api_key;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,($the_url));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$server_output = curl_exec ($ch);
			curl_close ($ch);
			
			
			
		//	$the_day=13;




				$result = json_decode($server_output);
		//print_r($result);
			if (isset($result->{'Note'})){echo "\n".$result->{'Note'}."\n";
			sleep(4);
			}
			

				$glob = $result->{'Time Series (1min)'};

				//counts the data in the dataset for today
				foreach ($glob as $test => $old_data_not_used_in_this){
						$time_date  = explode(" ", $test);
						$date_stamp = explode("-", $time_date[0] );
						$time_stamp = explode(":", $time_date[1]);
						//print_r($node_glob);
					if ($date_stamp[2]==$the_day ){
						
					$item_count++;
					}else{break;}
					
				}
				//echo $item_count; echo "\n";
				foreach ($glob as $adate_stamp => $node_glob){
					//fix abnormal data 
					
					//echo  $map_bid;
						$atime_date  = explode(" ", $adate_stamp);
						$adate_stamp = explode("-", $atime_date[0] );
						$atime_stamp = explode(":", $atime_date[1]);
						//
				//used to simulate stock data
					if ($sim["sim"]==TRUE){
						
						$map_bid =  round( map(($sim["slot"]), "1", "400","1"  , $item_count), 0, PHP_ROUND_HALF_DOWN ); 
						if ($adate_stamp[2]==$the_day ){
						if ($map_bid==$array_count){
					$trend_glob = $node_glob;
					break;
					//print_r($node_glob);
					}
					//print_r($node_glob);
					//if ($array_count >400){break;}
					}
					//else{break;}
					}

							
						
					if ($sim["sim"]==FALSE){
					if ($adate_stamp[2]==$the_day ){
				
					
			    	$trend_glob = $node_glob;
					//print_r($node_glob);
					break;
					if ($array_count >1){break;}
					
					}//if the data io is not = to today
					else{break;}
					}
				$array_count++;//1 for the most current and this data point only supports 100 for the day
				}
				
				
				
				if ($sim["sim"]==TRUE){
					//echo "\n";
					//echo "Sediment Time: FRAME ($the_mon   $the_day   $the_year $the_hour $the_min $the_ap )  CALLED ( \n";
					//print_r($atime_date); echo " ) \n";
				//sleep(3);
				}
				//echo $array_count;
//$dataForSingleDate = $glob->{'2017-10-30'};
//gets alphavantage price
//echo "\n";
//echo $glob->{'05. price'} . '';
		//Break out
					$the_price_now = null;
			//conpare global price quote
			//$json_obj = json_decode($responce);
			//$alpha_price =$json_obj['Global Quote'];
			//$the_price_now   =  $alpha_price->{'5. price'};
			//echo $alpha_price;
			//print_r($json_obj['Global Quote']);
			//$dec_price = '0.9000';
			//$the_price_now = '0.9000';
		    //	echo"here";
			

			
			
			
			$dec_price       =  $trend_glob->{'1. open'} - $trade[4] ;
			$the_price_now   =  $trend_glob->{'1. open'};			

echo $the_price_now;
echo "<br>";
echo $the_mon ."/". $the_day .'/'. $the_year .' '. $the_hour .':'. $the_min.':'.$the_ap ;
mysqli_close($loop_sub_conn);
}


//get id for adruino worker

//look up next php row 


//return next row id and price data ( call , low , high , now )


echo neural_get_node($stocks_watch_mode,$SERVER_DIR,$BACK_CALL,null,null,null);
