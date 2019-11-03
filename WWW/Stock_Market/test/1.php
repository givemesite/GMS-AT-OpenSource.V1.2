<?php
//echo getHostByName(getHostName());
//echo exec('c:\php\www\Stock_Market\upnp\upnpc.exe -e GMS_Stock_Cloud -a '.getHostByName(getHostName()).' 80 3005 TCP');
include('c:/php/WWW/Stock_Market/config.php');
//include("$SERVER_DIR/LOOP/logic_functions.php");
include("$SERVER_DIR/LOOP/all_starts_here.php");
//echo map("59", "32", "40", "20", "11");
$servername         = "127.0.0.1";
$username           = "root";
$dbname             = "stock_market_local";
$password           = "";

	$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
			$dquery = "SELECT * FROM `buy` ORDER BY `id` DESC LIMIT 3";
	if ($result=mysqli_query($sub_conn,$dquery)){ 
	// Fetch one and one row
	while ($get_count=mysqli_fetch_row($result))
	{
		print_r( $get_count);
		//day
		$today = date('j');
		$time= time ();
		// j day
		// if this day trade is within the last 5 days
		 $count = $get_count[1];
		 
		 $numDays = abs(($get_count[2]) - $time)/60/60/24;
		 echo "$numDays \n";
		 if($numDays <= 5.5){
			 $PDT++;
		 }
		echo "Numb of trades count $PDT";
		 if($PDT>=3){
			 echo "\n PDT HALT! \n";
		// for ($i = 1; $i < $numDays; $i++) {
        // echo date('Y m d', strtotime("+{$i} day", ($count))) . '<br />';
        // }
		$day_trades_used = TRUE;
		     }
	}}
	














die();
	echo  round( map("0",    "-15", "70","777777",    "47777777"),0,PHP_ROUND_HALF_DOWN);//io{(6=50) 30-110 = $32.00/val   $0.51/s}
		die();
	 $low_scale=  round( map("32.00",    "1", "1000","1",    "1000"),1,PHP_ROUND_HALF_DOWN);
	 $high_scale= round( map("32.00",    "1", "1000","3.6",  "3300"),1,PHP_ROUND_HALF_DOWN);
		
		
		
		
	

 echo round( map(6,    "-15", "70",$low_scale,    $high_scale),0,PHP_ROUND_HALF_DOWN);//io(6=50) 30-110 = $32.00/val   $0.51/s
die();
	$ch = curl_init();

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$server_output = curl_exec ($ch);
			curl_close ($ch);
				$result = json_decode($server_output);
				
			if (isset($result->{'Note'})){echo "\n".$result->{'Note'}."\n";}
			$trend_glob  = null;
				$glob = $result->{'Time Series (1min)'};
				$array_count = 0;
				foreach ($glob as $node_glob){

					if ($sim["sim"]==TRUE){
					
					if ($sim["slot"]==$array_count){
					$trend_glob = $node_glob;
					}

					//print_r($node_glob);
					
					if ($array_count >100){break;}

					
					}
					else
					{

			    	$trend_glob = $node_glob;
					//print_r($node_glob);
					
					//if ($array_count >1){break;}
						
						
					}
					$array_count++;//1 for the most current and this data point only supports 100 for the day
					}
				
echo $array_count;



die();

$Router_responce = exec('c:\php\www\Stock_Market\upnp\upnpc.exe -e GMS_Stock_Cloud -a '.getHostByName(getHostName()).' 80 3005 TCP');
//external 69.126.50.97:3005 TCP is redirected to internal 192.168.1.16:80 (duration=0)
$router_wan = explode(" ",$Router_responce);
$wan = explode(":",$router_wan[1]);
echo $wan[0];//ip   
echo $wan[1]; //port
echo getHostByName(getHostName());//LAN IP

echo "\n";

//c:/php/www/Stock_Market/upnp/upnpc.exe -e GMS Stock Cloud -a 192.168.1.153 3003 3004 TCP

//c:\php\www\Stock_Market\upnp\upnpc.exe -e GMS_Stock_Cloud -a 192.168.1.153 3003 3004 TCP
session_start();
$index_adv = -1;
$INDXADV = $index_adv;
$market_map =      map($INDXADV,    "-15", "40","8",    "4");// 10-6, 8-4, 6-2
if ($market_map > 10 ){$market_map =10;}
if ($market_map <  0 ){$market_map =1;}


if ($INDXADV >="-15"){
$market_map =      map($INDXADV, "-15", "140","1", "140");
if ($market_map > 140 ){$market_map =140;}
 $relation_high =  map($market_map, "1", "140","0.02", "3.52");
 $relation_low  =  map($market_map, "1", "140","9.02", "15.0");
}else{$relation_low="4.02"; $relation_high="0.02";}
                                                                     //12.0-4.05   3.52-0.02
$loss_freq= "-".(round( map(0.27, "0.10", "1.90",$relation_low,  $relation_high ), 1, PHP_ROUND_HALF_DOWN ));//end sales
echo $loss_freq;

$asset_value = ($trade[11] + ($trade[11] * $Degradation_Percent));
echo "\n \n ";
//($the_price_now, "0.30", "1.50",  ($trade[11] + ($trade[11] * $Degradation_Percent)), (($trade[12]* $GAIN_Percent)+$trade[12]))
//echo round(map(1.10, "0.30", "1.50", 1.02 ,1.22),4,PHP_ROUND_HALF_UP);
echo round(((1 - 1.50 / 1.29) * 100), 1, PHP_ROUND_HALF_DOWN );
if (-9.4 <= -9.0){echo "TRUE";}
//$price_to_buy_at = round((map($the_price_now, "0.30", "1.50",  ($trade[11] + ($trade[11] * $Degradation_Percent)), (($trade[12]* $GAIN_Percent)+$trade[12]))),4,PHP_ROUND_HALF_DOWN);


$price_def = 1.50 - (1.00 * 0.60);
//echo $price_def ;//(1.50 - 0)
echo "\n";
$asset_value = (1.50 - (1.00 * 0.92));

//echo round(((1.50* 0.12)+$asset_value),4,PHP_ROUND_HALF_DOWN);

//if ("1" >="-39"){ECHO "TRUE";}
//echo"% test".(1 - 1.09 / 1.07) * 100;
//	ECHO "\n Round/MAP Test :". round( map("12","9", "12", "-0.0100", "-0.0169"), 4, PHP_ROUND_HALF_DOWN ). "\n";
//some stuff for mysql data base

$day_trades_used    = null;
$day_trade_sold     = null;
$bad_day_trade      = null;
$call_type          = null;
$stock_was_bught    = null;
		$order_type = null;
		$call_type  = null;


//mysqli_close($conn);
	
	$dbname             = "user_settings";
	$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
	$dbname             = "stock_market_local";	
	
		$CHANGE_POINTS = $raw_row[12] - $RENDER_id;
		
	//see if we have this row in the table
		$query = "SELECT * FROM `buy_settings`";//see if we have this stock
	if ($result=mysqli_query($conn,$query)){ 
	// Fetch one and one row
	while ($row=mysqli_fetch_row($result))
		{
	//Column	Type	Comment
$MAX_STOCK_BUY_QTY		=$row[0];//int(255)	 
$MAX_STOCK_BUY_2ndQTY	=$row[1];//int(11)	 
$MIN_STOCK_BUY_3ndQTY	=$row[2];//int(11)	 
$MAX_DAY_TRADES			=$row[3];//int(11)	 
$MIN_DAY_TRADES			=$row[4];//int(11)	 
$Degradation_Percent	=$row[5];//char(11)	 
$maxStock_onHand		=$row[6];//int(11)	 
$MAX_SAME_STOCK_SALE	=$row[7];//int(11)	 
$MIN_SAME_STOCK_SALE	=$row[8];//int(11)	 
$max_investing_Percent	=$row[9];//char(11)	    the percent i beliave i should invest in all other tranctions of a stock 
$min_investing_Percent	=$row[10];//char(11)	the percent i beliave i should invest in the first tranction of a stock 
$min_RISK				=$row[11];//int(11)	 
$MAX_RISK				=$row[12];//int(11)	 
$MAX_CASH_OUT			=$row[13];//char(11)	 
$GAIN_Percent			=$row[14];//char(11)	the percent of gain that a stock has that would trigger a buy   
$MAX_STOCK_PRICE		=$row[15];//char(11)	the max price to buy a stock 
$MIN_STOCK_PRICE		=$row[16];//char(11)	the min price to buy a stock 
$MAX_STOCK_LOSS			=$row[17];//char(11)	 
$MIN_STOCK_LOSS			=$row[18];//char(11)	 
$moving_average			=$row[19];//char(11)	 
$max_stock_cap			=$row[20];//char(11)	 
$min_stock_cap			=$row[21];//char(11)
$CASH_BAL   			=$row[22];//char(11)    this is how much money i will let the system play with for the day
$min_freq				=$row[24];//char(11)
$max_freq				=$row[25];//char(11)
$freq_a					=$row[26];//char(11)
$freq_b					=$row[27];//char(11)
$freq_a_time_buy		=$row[28];//char(11)
$freq_b_time_buy		=$row[29];//char(11)
$freq_c_time_buy		=$row[30];//char(11)
$freq_d_time_buy		=$row[31];//char(11)
$freq_e_time_buy		=$row[32];//char(11)

$freq_c					=$row[33];//char(11)

$freq_a_time_sell		=$row[34];//char(11)
$freq_b_time_sell		=$row[35];//char(11)
$freq_c_time_sell		=$row[36];//char(11)
$freq_d_time_sell		=$row[37];//char(11)
$TIME_SERVER_MODE		=$row[38];//char(11)
$BROKER_API_MODE		=$row[39];//char(11)
$STOCK_SERVER_MODE		=$row[40];//char(11)
$simulator_mode			=$row[41];//char(11)
$price_simulator_mode	=$row[42];//char(11)

//print_r($row);
	 
}}
//mysqli_close($conn);

echo "ROBINHOOD RESPONCE \n";
	$price_len = strlen ("1.00" );
		//print_r($price_len);
$symbol= "UAVS";
$responce = (RH_API($call_type, $symbol, $price, $order_type, $STOCK_QTY_I_CAN_BUY));
$responce = json_decode($responce);
		print_r($responce);
echo "MYSQL RESPONCE \n";
echo "day trades \n";
	$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		$query = "SELECT * FROM `day_trades` WHERE CONVERT(`SYMB` USING utf8mb4) = '".$symbol."' ORDER BY `id` DESC LIMIT 1";//lets see how the stocks we own are doing first
		//	$query = "SELECT * FROM `stock` DESC LIMIT 350";//lets see how the stocks we own are doing first

		$trade= null;
	if ($main_trade_loop=mysqli_query($conn,$query)){ 
	// Fetch one row
	while ($trade=mysqli_fetch_row($main_trade_loop))
		{
			print_r($trade);
			
			
		}
	}
	echo "stock \n";
	$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		$query = "SELECT * FROM `stock` WHERE CONVERT(`trading_name` USING utf8mb4) = '".$symbol."' ORDER BY `id` DESC LIMIT 1";//lets see how the stocks we own are doing first
		//	$query = "SELECT * FROM `stock` DESC LIMIT 350";//lets see how the stocks we own are doing first

		$trade= null;
	if ($main_trade_loop=mysqli_query($conn,$query)){ 
	// Fetch one row
	while ($trade=mysqli_fetch_row($main_trade_loop))
		{
			print_r($trade);
			
			
		}
	}
echo "ALPHAVANTAGE RESPONCE \n";
			$ch = curl_init();
			//R3K5V8RS9N1D6MQ2
		//	https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=SNES&interval=1min&apikey=R3K5V8RS9N1D6MQ2&outputsize=compact
curl_setopt($ch, CURLOPT_URL,("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=".$symbol."&interval=1min&apikey=R3K5V8RS9N1D6MQ2&outputsize=compact"));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$server_output = curl_exec ($ch);
			curl_close ($ch);
				$result = json_decode($server_output);
print_r($result);

	
$a = 'test';
//include('2.php');