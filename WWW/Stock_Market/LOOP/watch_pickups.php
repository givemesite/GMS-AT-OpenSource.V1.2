<?php
   ////////////////////////////
   //stock market moveing 
   //avg 
   //cal % for stock quantity
   //
   //
   //
   //
   //WATCH Pickups.php
   ////////////////////////////
   
//some stuff for mysql data base
$servername         = "127.0.0.1";
$username           = "root";
$password           = "";

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

mysqli_close($conn);
	$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);

			
	if ($RENDER_id<$raw_row[12]){
		

		
		
//some stuff for mysql data base
$servername         = "127.0.0.1";
$username           = "root";
$password           = "";
$dbname             = "stock_market_local";

	var_dump();
//die();	
		
		// make sure the stock symbol is set (ie xxxxx)
		if (isset($raw_row[1]) && $raw_row[1]<>""){
			
			
			//dont watch a stock if its price is higher then whats set in my constrents
			if ($price_now > $MAX_STOCK_PRICE){
			 
			//set the stock so that the database is not gonna try to add it again
			$STOCK_IN_WATCH = 'na';
			}	
			if ($price_now < $MIN_STOCK_PRICE){
			 
			//set the stock so that the database is not gonna try to add it again
			$STOCK_IN_WATCH = 'na';
			}	
			
			//dont want a stock if its lower then what i have set
			
			//if the stock is not in the watch list
			if ($STOCK_IN_WATCH == null){
		echo "This Stock is moveing up in the dataset \n";	
$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);

		 $time = time();
$sql = "INSERT INTO `watch` (`trading_name`, 
									`name`, 
									`MAX_POINT_ADV`,
									`BUY_PRICE`,
									`SELL_PRICE`, 
									`price_now`,
									`TYPE`, 
									`QTY_ON_HAND`, 
									`1st_time_frame`, 
									`1st_price`, 
									`1st_change_pct`, `1st_QTY`, `1st_TYPE`,
									`2nd_time_frame`, `2nd_price`, `2nd_change_pct`, `2nd_QTY`, `2nd_TYPE`, 
									`3rd_time_frame`, `3rd_price`, `3rd_change_pct`, `3rd_QTY`, `3rd_TYPE`, 
									`4th_time_frame`, `4th_price`, `4th_change_pct`, `4th_QTY`, `4th_TYPE`)
VALUES ('".$raw_row[1]."',
		'$name', 
		'', 
		'$price_now',
		'$sell_price', 
		'$price_now',
		'', 
		'".$STOCK_QTY_I_CAN_BUY."', 
		'".$time."',
		'',
		'".$raw_row[8]."',
		'',
		'', 
		'', 
		'', 
		'', 
		'',
		'', 
		'',
		'',
		'', 
		'', 
		'', 
		'',
		'',
		'', 
		'', 
		'')";
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully \n";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	//stop the loop
	sleep(600000000000000000000000000000000000000000000);
}
//mysqli_close($conn);
		}
		
   ////////////////////////////
   //update stock that is  
   // 
   //moveing up in the list 
   //
   ////////////////////////////
				$servername         = "127.0.0.1";
				$username           = "root";
				$password           = "";
				$dbname             = "stock_market_local";
		
		
		
		
			//$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
				//$C_SYMB = 'test';
	$sql = "UPDATE `watch` SET 	   (`QTY_ON_HAND`, 
									`1st_time_frame`, 
									`1st_price`, 
									`1st_change_pct`, `1st_QTY`, `1st_TYPE`,
									`2nd_time_frame`, `2nd_price`, `2nd_change_pct`, `2nd_QTY`, `2nd_TYPE`, 
									`3rd_time_frame`, `3rd_price`, `3rd_change_pct`, `3rd_QTY`, `3rd_TYPE`, 
									`4th_time_frame`, `4th_price`, `4th_change_pct`, `4th_QTY`, `4th_TYPE`)
 VALUES ('".$raw_row[1]."',
		'$name', 
		'', 
		'$price_now',
		'$sell_price', 
		'$price_now',
		'', 
		'', 
		'".$time."',
		'',
		'".$raw_row[8]."',
		'',
		'')"." WHERE `id` = ".$row[0];
				
				
//how much cash i have to work with 
//echo "Todays max cash on hand \n";
//echo $MAX_CASH_OUT;
  // echo "\n";
   //echo "\n";


		
	}else{//require a symbol to be set now  expedite
			$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
			$sql = "UPDATE `stock` SET `expedite` = '1'"." WHERE id = ".$raw_row[0];
				if (mysqli_query($conn, $sql)) {
					echo "Set expedited successfully \n";
					} else {
							echo "Error: " . $sql . "<br>" . mysqli_error($conn);
					}
					mysqli_close($conn);
		
		}



	
}else {//position less then record - item moveing down in the data set

 }