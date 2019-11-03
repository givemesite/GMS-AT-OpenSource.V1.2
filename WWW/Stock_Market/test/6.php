<?php
include('c:/php/WWW/Stock_Market/config.php');
//include("$SERVER_DIR/LOOP/logic_functions.php");
include("$SERVER_DIR/LOOP/all_starts_here.php");

$servername         = "127.0.0.1";
$username           = "root";
$dbname             = "stock_market_local";
$password           = "";


	$dbname             = "user_settings";
	$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
	$dbname             = "stock_market_local";	
	
		$CHANGE_POINTS = $raw_row[12] - $RENDER_id;
		
	//see if we have this row in the table
		$query = "SELECT * FROM `buy_settings`";//see if we have this stock
	if ($result=mysqli_query($sub_conn,$query)){ 
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
$MAX_CASH_OUT			=$row[13];//char(11)	dont set under 40 cash
$RAW_GAIN_Percent			=$row[14];//char(11)	the percent of gain that a stock has that would trigger a buy   
$MAX_STOCK_PRICE		=$row[15];//char(11)	the max price to buy a stock 
$MIN_STOCK_PRICE		=$row[16];//char(11)	the min price to buy a stock 
$MAX_STOCK_LOSS			=$row[17];//char(11)	 
$MIN_STOCK_LOSS			=$row[18];//char(11)	 
$moving_average			=$row[19];//char(11)	 
$max_stock_cap			=$row[20];//char(11)	 
$min_stock_cap			=$row[21];//char(11)
$CASH_BAL   			=$row[22];//char(11)    this is how much money i will let the system play with for the day dont set under 40 cash
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
$Degradation_Drop_Percent = $row[43];//char(11)
//print_r($row);
	 
}}
mysqli_close($sub_conn);usleep(60);

$INDXADV=-15;
if ($INDXADV >="-15"){
$market_map =      map($INDXADV,    "-15", "40","1",    "40");
if ($market_map >  40 ){$market_map =  40;}
if ($market_map < -15 ){$market_map = -15;}     //0.012494                                
 $GAIN_Percent  =  map($market_map, "0",   "40",$RAW_GAIN_Percent, "0.40494"); 
}else{$GAIN_Percent="0.067"; }
echo "INDEX: ".$INDXADV."<br>";
echo "Gain %: ".$GAIN_Percent."<br>";









