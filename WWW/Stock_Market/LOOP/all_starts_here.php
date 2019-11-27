<?php
	
	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//
	//	Find trending stocks by gains % over time
	//
	//
	//to do
	//all starts here . php
	//////////////////////////////////////////////
	// a break down of stocks by gains 
	//////////////////////////////////////////////		
	session_start();
	include("$SERVER_DIR/LOOP/logic_functions.php");
	
	//include('c:/php/WWW/Stock_Market/LOOP/watch_pickups.php'); programmer refrence for a function in the script	
	
	
	function investing_planner (
	
	$RENDER_id= null,		// can also be the placement id ,should be The mysql id of the item
	$raw_row= null, 		// what row
	$trading_name= null,  // The Ticker Symbol
	$name= null,			// comp name
	$price_now= null,		//
	$DAY_HIGH= null,		//
	$DAY_LOW= null,		//
	$CHANGE_PCT= null,
	$MOVING_ADV= null,	//
	$CAP= null,		
	$BUY_PRICE= null,
	$ADV= null
	
	){//START FUNCTION
		
		//some stuff for mysql data base
		$servername         = "127.0.0.1";
		$username           = "root";
		$password           = "";
		$dbname             = "stock_market_local";
		//some vars for each time the script runs
		$STOCK_IN_WATCH     = null;
		$TOTAL_RATIO_SELL   = 0;
		$TOTAL_RATIO_BUY    = 0;
		$max_investing_cash = 0;
		
		/////////////////////////////////////////////////
		/////////////////////////////////////////////////
		/////////////////////////////////////////////////
		//
		//		Test for where the item are in the list
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
		//SELECT *
		//FROM `stock`
		//WHERE CONVERT(`price` USING utf8mb4) < '00.60000'
		//ORDER BY `CHANGE_PCT`, `id`, `price` DESC
		//LIMIT 50
		/////////////////////////////////////////////////
		
		
		
		
		
		///////////////////////////////////////
		//+ change % Function 
		// Watch table
		///////////////////////////////////////
		
		//old script to pick up stocks - was to slow
		//if the new position is higer on the list
		//include("$SERVER_DIR/LOOP/watch_pickups.php");
		
		///////////////////////////////////////
		//end of render id (html table)
		//+ change % Function 
		//
		///////////////////////////////////////
		
		
		
		
		///////////////////////////////////////
		//start change percent trigger
		//+ change % Function 
		//
		///////////////////////////////////////
		
		//be sure this stock is in the watch list 
		
		
		//mysqli_close($conn);usleep(60);	
		
		
		//echo $Change_result ;
		
		///////////////////
		///////////////////
		//
		//	get the buying and
		//	investing settings
		//	set the settings 
		//  for the investing pan
		//
		//
		//
		///////////////////
		///////////////////
		
		//biasis the change percent - todo
		//mysqli_close($conn);usleep(60);
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
				$moving_average			=$row[19];//char(11)	how much gains a stock must makr before going into the dataset  
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
			
			
			mysqli_close($conn);usleep(60);
			
			
			
			
			
			////////////////////
			//End of init 
			//
			//cycle vars
			////////////////////
			
			
			
			//mysqli_close($conn);usleep(60);
			
			
			
			///////////////////
			///////////////////
			//
			// Stock buy routine
			//
			//
			///////////////////
			///////////////////
			
			
			
			
			//$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);	
			
			//////////////
			//caculate 
			//sell price
			//target
			//gains
			//how much to spend
			///////////////
			//caculate the gains of the stock at the point of investment 	
			
			$raw_sell_price = $price_now * $GAIN_Percent;        //keep a stock at 0.06% gains 
			
			$sell_price = $raw_sell_price + $price_now;          //around what price i think i should buy the stock at
			
			$max_money_out = $CASH_BAL * $min_investing_Percent; //this is the max amount im willing to spend on this stock
			$MAX_STOCK_QTY = $max_money_out / $price_now;          //this is the max amount of soock i can buy (QTY)
			$The_Max_sell_Price;									//the max sell price in what i expect from the stock when it reaches meuteraty
			$Call_per_SALE; 										// the qanaty of how meany stock i think i can buy at the first sale
			$the_quantiy_i_plan_to_buy; 							// the amount i plan to buy in the first sale
			
			//qty to buy rounded down
			$STOCK_QTY_I_CAN_BUY =  round( $MAX_STOCK_QTY, 0, PHP_ROUND_HALF_DOWN );
			
			//
			
			
			
			$Stock_in_trade	= null;
			//see if the change PCT is higher then the old dataset
			
			$Change_result = $CHANGE_PCT - $raw_row[8];
			$CHANGE_POINTS = $raw_row[12] - $RENDER_id;
			
			
			mysqli_close($conn);usleep(60);
			$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
			
			
			////////////////////
			//End of init 
			//
			//cycle vars
			////////////////////
			
			//$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
			$query = "SELECT * FROM `day_trades` WHERE `name` = '$name'";//see if we have this stock
			
			if ($result=mysqli_query($conn,$query)){ 
				// Fetch one row
				while ($row=mysqli_fetch_row($result))
				{
					//test the stock so that the dataset is not compeled fron the old one 	
					
					//set the var so the stock is not add'ed again 		
					$STOCK_IN_WATCH = true;
				}
			}
			
			mysqli_close($conn);usleep(60);
			$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
			
			
			
			//dont watch a stock if its price is higher then whats set in my constrents
			if ($price_now > $MAX_STOCK_PRICE){
				
				//set the stock so that the database is not gonna try to add it again
				$STOCK_IN_WATCH = true;
				}	else{
				
				
				
				
			}
			if ($price_now < $MIN_STOCK_PRICE){
				
				//set the stock so that the database is not gonna try to add it again
				$STOCK_IN_WATCH = true;
			}	else{}
			
			
			
			$the_hour       = date('g'); 
			$the_min        = date('i');
			$the_seconds    = date('s');
			$the_year       = date('Y');//year
			$the_mon        = date('m');//month
			$the_day        = date('d');//mon-fri
			$the_ap         = date('a');//am or pm
			$FREQ			= null;
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			//Need to change this to use finviz	and|| or have a switch	
			
			
			$LINK_CHOICE = "finviz";// alpha or finviz
			
			
			
			
			
			
			
			
			if($STOCK_IN_WATCH<>true){
				
				if($LINK_CHOICE== "alpha"){
					
					
					
					
					
					
					
					
					$key_file = "C:/php/www/Stock_Market/API/alphavantage.KEY"; // I was running the code on localhost, and hence the path!
					
					$api_key = file_get_contents($key_file);
					$array_count = 0;
					$trend_glob = null;
					$ch = curl_init();
					curl_setopt($ch,
					CURLOPT_URL,
					("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=".$raw_row[1]."&interval=1min&apikey=".$api_key."&outputsize=compact"));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$server_output = curl_exec ($ch);
					curl_close ($ch);
					$result = json_decode($server_output);
					
					if (isset($result->{'Note'})){echo "\n".$result->{'Note'}."\n";}
					
					$glob = $result->{'Time Series (1min)'};
					
					foreach ($glob as $date_stamp => $node_glob){
						//fix abnormal data 
						
						$time_date  = explode(" ", $date_stamp);
						$date_stamp = explode("-", $time_date[0] );
						$time_stamp = explode(":", $time_date[1]);
						//print_r($node_glob);
						if ($date_stamp[2]==$the_day ){
							if ($sim["sim"]==TRUE){
								if(isset($sim)){
									//make sure im only using data from the day i need listed in the dataset
									//	if ($date_stamp[2]<$the_day ){break;}
								}
							}
							if ($sim["sim"]==TRUE){
								if ($sim["slot"]==$array_count){
									$trend_glob = $node_glob;
								}
								//print_r($node_glob);
								if ($array_count >400){break;}
							}
							else
							{
								$trend_glob = $node_glob;
								//print_r($node_glob);
								if ($array_count >1){break;}
							}
							
						}else{break;}
						$array_count++;//1 for the most current and this data point only supports 100 for the day
					}
				}	
				
				if (	$LINK_CHOICE == "finviz"){
					
					$start = microtime(true);
					
					$login_session= $_SESSION['finviz_login'] ;
					
					if ($login_session=='yes'){}
					
					else{FINVIZ_LOGIN();$_SESSION['finviz_login'] = 'yes';}
					
					
					
					
					//usleep(40);
					//jason responce
					
					$url = "https://elite.finviz.com/export.ashx?v=111&t=". $raw_row[1];
					
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
					//	 'Content-Type: application/json'
					//	  'X-Requested-With: XMLHttpRequest'
					));
					$html = curl_exec($ch);
					curl_close($ch);
					
					
					
					$stream = fopen('data://text/plain;base64,' . base64_encode($html),'r');
					
					
					$csv = fgetcsv  ( $stream,  "," , '"') ;
					
					while (($data = fgetcsv($stream, null, ",")) !== FALSE) {
						$num = count($data);
						
						$row++;
						//print_r($data);
						//	print_r($data);
						//echo " \n ";
						//echo $data[1]."\n";
						
						$ticker_name   = $data[1];
						$comp_name   = str_replace(',',' ',str_replace('.',' ',$data[2]));
						$finviz_price_now   = $data[8];
						$day_high   = 0;
						$day_low   = 0;
						$CHANGE_PCT   = str_replace('%','',$data[8]);
						$CHANGE_RATIO   = $data[9];
						$CHANGE_VOL   = $data[10];
						$DATE_ADDED   = time();
						$TIME   = time();
						fclose ($stream );
						$time_elapsed_secs = microtime(true) - $start;
					}		}	
					
					
					
					
					
					
					
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			//var_dump();
			//
			
			//echo $Change_result . "\n" ;
			//echo $moving_average . "\n" ;
			//echo $STOCK_IN_WATCH . "\n" ;
			//echo $Stock_in_trade . "\n" ;
			//print_r($raw_row);
			//die('here');
			
			//dont let fake stock prices affect us 
			
			//see if the price is off from what i can see
			//think of this like a firewall or a save my ass idea
			
			
			$Test_the_price_now   =  $finviz_price_now;
			
				if (	$LINK_CHOICE == "alpha"){
			$the_price_now   =  $trend_glob->{'1. open'};
				}
				if (	$LINK_CHOICE == "finviz"){
			$the_price_now   =  $finviz_price_now;
				}
			//to do 
			// a stock can drop 15% on a bad day but also make 20% after that 
			// use the math below to let the price drop 15% on input into the dataset
			//but also most importently make a trigger 
			//$Test_the_price_now   =  $trend_glob->{'1. open'} - 0.05;
			
			
			if (
			$CHANGE_PCT   <= "90"         &&//- ALPHA
			$Change_result>$moving_average &&
			
			$Change_result > 0 && 
			$Change_result <> 0 && 
			//$the_price_now > 0.0100 &&//the price needs to be set to a number
			$finviz_price_now > 0.0100 &&
			$price_now<= $Test_the_price_now && //the price needs to be gainging value
			$STOCK_IN_WATCH <> true
			){
				
				
				
				
				
				
				//look in day trades and make updates 
				//$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
				$query = "SELECT * FROM `day_trades` WHERE `SYMB` = '".$raw_row[1]."'";//lets see how the stocks we own are doing first
				
				if ($result=mysqli_query($conn,$query)){ 
					// Fetch one row
					while ($row=mysqli_fetch_row($result))
					{//print_r($row);
						$Stock_in_trade = true;
					}
				}
				
				
				
				mysqli_close($conn);usleep(60);
				$time = time();
				if ($Stock_in_trade == true){
					
					
					////////////////////////////
					//update stock that is  
					// 
					//moveing in data set
					//
					////////////////////////////
					$servername         = "127.0.0.1";
					$username           = "root";
					$password           = "";
					$dbname             = "stock_market_local";
					//$STOCK_QTY_I_CAN_BUY =  round( $MAX_STOCK_QTY, PHP_ROUND_HALF_DOWN );
					
					
					
					
					
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
					
				}
				$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
				
				
				
				
				
				
				//mysqli_close($conn);usleep(60);
				if ($Stock_in_trade <> true && $raw_row[1] <> "" && isset($raw_row[1]) && $the_price_now > 0.001 ){		
					//	echo "\n";
					//	echo $CHANGE_PCT;
					//	echo "\n";
					//	echo $raw_row[8];	 
					//PLAN_A_CHANGE_PCT doller val | Lowest price value
					$sql = "INSERT INTO `day_trades` (`trading_name`, 
					`name`, 
					`SYMB`,
					`PRICE`,
					`QTY`, 
					`TIME`,
					`TYPE`, 
					`PLAN_A_CHANGE_PCT`, 
					`PLAN_A_PRICE`, 
					`PLAN_A_QTY`, 
					`OCP`, `PLAN_B_PRICE`, `PLAN_B_QTY`,
					`PLAN_C_CHANGE_PCT`, `PLAN_C_PRICE`, `PLAN_C_QTY`, `VOL`, `OCG`)
					VALUES ('".$raw_row[1]."',
					'$name', 
					'".$raw_row[1]."', 
					'$the_price_now',
					'$STOCK_QTY_I_CAN_BUY', 
					'".$time."',
					'OC', 
					'',
					
					'$the_price_now',
					'$STOCK_QTY_I_CAN_BUY',
					'$the_price_now',
					'', '', 
					'', 
					'', 
					'',
					'".$raw_row[10]."',
					'000000".$raw_row[8]."')";
					if (mysqli_query($conn, $sql)) {
						echo "New record created successfully \n";
						} else {
						echo "Error: " . $sql . "<br>" . mysqli_error($conn);
					}
					mysqli_close($conn);usleep(60);
					
					
				}
				//end of triggers/planing function
			}	
			
			
			
			
			///
			//end of function
	}
	
	
