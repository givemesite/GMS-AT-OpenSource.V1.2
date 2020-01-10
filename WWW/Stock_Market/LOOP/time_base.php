<?php
	
		//get the index for the day
		session_start();
		if (!isset($sim) && (!isset(($_GET['node'] )))){
			INDEXS_FOR_INVESTING  () ;
			}else{ 
			$simulate_i_adv = rand(-15, 25);
		$_SESSION['INDEXS_ADV']= $simulate_i_adv ;$_SESSION['BAL']="0";}//-10 to 50-400
		
		//some stuff for mysql data base
		$servername         = $BACK_CALL;
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
		$model		= "";
		
		//mysqli_close($conn);
		
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
				$rawMAX_CASH_OUT		=$row[13];//char(11)	dont set under 40 cash
				$RAW_GAIN_Percent		=$row[14];//char(11)	the percent of gain that a stock has that would trigger a buy   
				$MAX_STOCK_PRICE		=$row[15];//char(11)	the max price to buy a stock 
				$MIN_STOCK_PRICE		=$row[16];//char(11)	the min price to buy a stock 
				$MAX_STOCK_LOSS			=$row[17];//char(11)	 
				$MIN_STOCK_LOSS			=$row[18];//char(11)	 
				$moving_average			=$row[19];//char(11)	 
				$max_stock_cap			=$row[20];//char(11)	 
				$min_stock_cap			=$row[21];//char(11)
				$rawCASH_BAL   			=$row[22];//char(11)    this is how much money i will let the system play with for the day dont set under 40 cash
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
			
			$index_adv = $_SESSION['INDEXS_ADV'];
			
			if ($sim["sim"]<>TRUE){
				$responce   = (brokerage_API(NULL, $symbol, $price, $order_type, $STOCK_QTY_I_CAN_BUY));
				}else{
				
				$responce = '{"id":"a430601d-87a9-45c2-af46-b1154b00f81b","status":"ACTIVE","currency":"USD","buying_power":"50.0","cash":"50.0","cash_withdrawable":"0","portfolio_value":"50.0","pattern_day_trader":false,"trading_blocked":true,"transfers_blocked":false,"account_blocked":false,"created_at":"2019-03-22T12:57:04.710705Z","trade_suspended_by_user":false}';
				$json_obj = json_decode($responce);
			}
			
			
			$json_obj = json_decode($responce);
			$raw_cost = ( ($json_obj->portfolio_value - $json_obj->buying_power)    /  $STOCK_QTY_I_CAN_BUY);
			
			$CASH_BAL     =$json_obj->buying_power;
			$MAX_CASH_OUT =$json_obj->buying_power;
			$INDXADV = round(($index_adv/8),0,PHP_ROUND_HALF_UP);
			
			if ($INDXADV >="-15"){//-15 - 40
				$market_map =      map($INDXADV,    "-15", "40","1",    "40");
				if ($market_map >  40 ){$market_map =  40;}
				if ($market_map < -15 ){$market_map = -15;}     //0.012494                                
				$GAIN_Percent  =  map($market_map, "1",   "40",$RAW_GAIN_Percent, "0.2494"); 
				//index adv =+3
				//0.067 = 20%  0.12 =40% 
			}else{$GAIN_Percent="0.297"; }
			
			
			
			
			$GAIN_Percent= round($GAIN_Percent ,5 , PHP_ROUND_HALF_UP);
			
			////////////////////////////
			//buy trigger and timmer
			// 
			//
			//
			////////////////////////////
			
			$dbname             = "user_settings";
			$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
			$dbname             = "stock_market_local";	
			//see if we have this row in the table
			$query = "SELECT * FROM `trade_cycle`";//see if we have this stock
			if ($result=mysqli_query($sub_conn,$query)){ 
				// Fetch one and one row
				while ($row=mysqli_fetch_row($result))
				{
					
					$BUY_PLAN_A = $row[2];
					$BUY_PLAN_B = $row[3];
					$BUY_PLAN_C = $row[4];
					$BUY_PLAN_D = $row[5];
					$SELL_PLAN_A = $row[6];
					$SELL_PLAN_B = $row[7];
					$SELL_PLAN_C = $row[8];
					$SELL_PLAN_D = $row[9];		
					
					
					
					//echo $percentChange; //= -12%
					
					
				}}
				
				mysqli_close($sub_conn);usleep(60);
				
				$plan_a = explode("-",$freq_a);
				//get the time the cycle should start
				$freq_time = explode(":",$freq_a_time_buy);
				//get the time the cycle should start
				$plan_b_freq_time = explode(":",$freq_b_time);
				//get time and hour stuff
				if ($sim["sim"]==TRUE){
					$the_hour       = $sim["h"]; 
					$the_min        = $sim["m"];;
					$the_seconds    = date('s');
					$the_year       = $sim["y"];//year
					$the_mon        = $sim["mo"];//month
					$the_day        = $sim["d"];//
					$the_day_symbl  = "TEST";
					$the_ap         = $sim["ap"];;//am or pm
					$FREQ			= null;
					
				}
				else
				
				{
					
					$the_hour       = date('g'); 
					$the_min        = date('i');
					$the_seconds    = date('s');
					$the_year       = date('Y');//year
					$the_mon        = date('m');//month
					$the_day        = date('d');//1-30
					$the_ap         = date('a');//am or pm
					$the_day_symbl  = date('D');
					$FREQ			= null;
					
				}
				
				
				
				//wont delete on weekends for debugging - 11/24/19
				//delete old data in tables 
				//stocks
				//day_tradess
				//when time is > 9:25am
				
				//this will delete the old  stuff in the database		
				if ($the_ap == "am" && "9" == $the_hour && $the_min < "31" && $the_min >= "25" && !isset($sim) && $the_day_symbl <> "Sat" && $the_day_symbl <> "Sun"){
					
					
					$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
					//see if we have done a day trade today
					$query = "DELETE FROM `day_trades`";
					if ($result=mysqli_query($sub_conn,$query)){ 
						// Fetch one and one row
					}
					mysqli_close($sub_conn);usleep(60);
					$psub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
					//see if we have done a day trade today
					$query = "DELETE FROM `stock`";
					if ($result=mysqli_query($psub_conn,$query)){ 
						// Fetch one and one row
					}
					//reset table key
					$asub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
					//see if we have done a day trade today
					$query = "ALTER TABLE `day_trades` AUTO_INCREMENT=1";
					if ($result=mysqli_query($asub_conn,$query)){ 
						// Fetch one and one row
					}
					sleep(5);
					mysqli_close($psub_conn);	
					echo "Cleaning MYSQL Database......... \n ";
				}		
				
				
				$index_adv = $_SESSION['INDEXS_ADV'];
				echo "\n INDEX'S AVERAGE :".round(($index_adv/8),0,PHP_ROUND_HALF_UP)."\n";
				
			if (!isset(($_GET['node']))){	echo "\n\033[4;37mAUTO TRADE\033[0m";echo "	\n";}
				echo "-------------------------------------------------------------------------------\n";
				//dont trade by default		
				$call_trade_bypass  = TRUE;		
				//buy plan	 -  time a 	
				if ($the_ap == "am" && $freq_time[0] 	== $the_hour ||
				$the_ap == "am" &&		  $the_hour == "9" 	 ||
					$the_ap == "am" &&		  $the_hour == "10" 	 ||
					$the_ap == "am" &&		  $the_hour == "11" 	 ||
					$the_ap == "pm" &&  	  $the_hour == "12"
				){
					$call_trade_bypass   = FALSE;
					//if its less then or = : 9:30 am hold off untill 32 to make any buys
					if ($freq_time[0] == $the_hour  &&  $the_min <="31"){
						//dont buy	
						$call_trade_bypass   = TRUE;
						}else{
						if ($freq_time[0] == $the_hour){	
							$call_trade_bypass   = FALSE;
						}
					}
				}
				//buy plan	 -  time b 	
				if ($the_ap == "pm" &&  $the_hour == "1" ||
					$the_ap == "pm" &&  $the_hour == "2" ){
					$call_trade_bypass   = FALSE;//when its 10 11
				}
				
				//process and encapsulate- set to hult buy
				if ( $call_trade_bypass  == TRUE  ){
					$day_trades_used     = TRUE; 
					//print put to the server why we stoped this tranaction 
					echo "\n".'Trade Times are (Hr:Min) FOR FREQ (16-20)'.
					$freq_time[0]. ":".$freq_time[1]."AM FOR (11-20) ".
					$the_hour.":".$the_min."".$the_ap;	
				}else{ $day_trades_used   = FALSE;}
				
				
				//is it a day i should trade
				$day = date('D');
				if ($day=='Mon'||$day=='Tue'||$day=='Wed'||$day=='Thu'||$day=='Fri'){ //trading days
				}else{ECHO"\nToday is not a trading day.";$day_trades_used = TRUE; }
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				//the system also takes into consideration pending orders in the account. 
				//In this case, regardless of the order of pending orders,
				// a pair of buy and sell orders is counted as a potential day trade. 
				// This is because orders that are active (pending) in the marketplace may fill in random orders. 
				// Therefore, even if your sell limit order is submitted first (without being filled yet) 
				// and another buy order on the same security is submitted later, 
				// this buy order will be blocked if your account already has 3 day trades in the last 5 business days.
				$PDT = 0;
				$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
				$dquery = "SELECT * FROM `buy` ORDER BY `id` DESC LIMIT 3";
				if ($result=mysqli_query($sub_conn,$dquery)){ 
					// Fetch one and one row
					while ($get_count=mysqli_fetch_row($result))
					{
						
						//day
						$today = date('j');
						//$time= time ();
						//dont let the time from the row be more 
						//or thae same as the current day trade hour
						$time=strtotime("+13005 seconds");
						// j day
						// if this day trade is within the last 7 days
						$count = $get_count[1];
						
						$numDays = abs(($get_count[2]) - $time)/60/60/24;
						$time= time ();
						if($numDays <= 7){//within 7 days
							$PDT++;
						}
						
						
					}}	
					if($PDT>=3){
						echo "\n PDT HALT! \n";
						// for ($i = 1; $i < $numDays; $i++) {
						// echo date('Y m d', strtotime("+{$i} day", ($count))) . '<br />';
						// }
						$day_trades_used = TRUE;
					}
					echo "\n Number of trades used: $PDT \n";
					
					mysqli_close($sub_conn);usleep(60);
					
					//auto run bypass
					if(isset($sim)){
						$day_trades_used = FALSE;
					}
					
					if ($day_trades_used <> TRUE)
					{echo "\n\n	Auto day trading is running \n\n";}
					else{echo "\n\n	Auto day trading is off \n\n";//sleep(1);
					}
					
					$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
					//see if we have done a day trade today
					$query = "SELECT * FROM `cycle_sell` WHERE `YEAR` = '$the_year' AND `MON` = '$the_mon' AND `DAY` = '$the_day' LIMIT 1";
					if ($result=mysqli_query($sub_conn,$query)){ 
						// Fetch one and one row
						while ($quantitative_trade=mysqli_fetch_row($result))
						{
							ECHO"\nONE TRADE WAS EXECUTED TODAY.";	
							
							if (isset($sim)){
								$_SESSION["SIM_id"] = 1000;//reset simulation buffer
							}
							//sleep(4);		
							$day_trades_sold = TRUE;//continue(1);
							//ECHO"|\n\n Day Trade End Trigger........   DONE";		
						}}
						mysqli_close($sub_conn);usleep(60);
						
						//check to see if we bught a set of stock today
						//dont over buy	
						$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
						//see if we have done a day trade today
						$query = "SELECT * FROM `buy` WHERE `YEAR` = '$the_year' AND `MON` = '$the_mon' AND `DAY` = '$the_day' LIMIT 1";
						if ($result=mysqli_query($sub_conn,$query)){ 
							// Fetch one and one row
							while ($call_quantitative_trade=mysqli_fetch_row($result))
							{$quantitative_trade=$call_quantitative_trade;
								$_SESSION['QTY']= $quantitative_trade[7];
								if ($day_trades_sold <> TRUE){
									ECHO"\nONE TRADE IN PROGRESS.";	//print_r($call_quantitative_trade);		
									
								}
								$day_trades_used = TRUE;//continue(1);
								//ECHO"|\n\n Day Trade End Trigger........   DONE";		
							}}
							mysqli_close($sub_conn);usleep(60);	
							//if ($day_trades_used <> TRUE){echo "\n\n	Auto day trading is running \n\n";}else{echo "\n\n	Auto day trading is off \n\n";}
							
							
							
							
							//look at all the stock we are about to own or own - dont look at closing call trades
							//$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);//DESC
							//map the calc qty cap
							$index_adv = $_SESSION['INDEXS_ADV'];
							$INDXADV = round(($index_adv/8),0,PHP_ROUND_HALF_DOWN);
							$max_money_out       = $CASH_BAL        * $min_investing_Percent; //this is the max amount im willing to spend on this stock
							$low_scale=  round( map($max_money_out,    "1", "1000","1",        "1000"),1,PHP_ROUND_HALF_DOWN);
							$high_scale= round( map($max_money_out,    "1", "1000","3.6",      "3400"),1,PHP_ROUND_HALF_DOWN);
							
							