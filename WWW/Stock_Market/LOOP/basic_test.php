<?php
//////////////////////////////////////////////
//////////////////////////////////////////////
//
//	find trending stocks by gains % over time
//
//
//to do
//
//////////////////////////////////////////////
// a break down of stocks by gains 
//////////////////////////////////////////////		
$time = time();
//echo $time;

	
//some stuff for mysql data base
$servername         = $_SESSION['IP_X_server_ip'];
$username           = "root";
$dbname             = "stock_market_local";
$password           = "";
$day_trades_used    = null;
$day_trade_sold     = null;
$bad_day_trade      = null;
$call_type          = null;
$stock_was_bught    = null;
		$order_type = null;
		$call_type  = null;
 $GLOBALS['stocks_watch_mode'] = "TEST";
//echo   $stocks_watch_mode;    

mysqli_close($conn);
	
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
$freq_a_time			=$row[28];//char(11)
$freq_b_time			=$row[29];//char(11)

//print_r($row);
	 
}}
mysqli_close($conn);

