<?php
//kris galante krisgcell@gmail.com
	//SELL RISKS.php
	
	
	//Purchase Price of the stock
	
	//sell %
	
	
	//Triggers
	
	//some exponet math to sell a stock if it dips into the negitives, bars start at 20
	//
	
	//$stock_Degradation_Percent = $trade[] / $Degradation_Percent;
	//                           //buy price
	
	
	
	
	
	
	
	$Call_SELLING = null;
	$oldFigure       = $trade[4];
	$newFigure       = $the_price_now;
	
	
	$last_calc_price            = $dec_price                   / $Degradation_Drop_Percent;
	$percentChange              = (1 - $oldFigure              / $newFigure) * 100;
	$stock_Degradation_Price    = $quantitative_trade[3]       *   $Degradation_Drop_Percent;
	$low_deg_price              = $quantitative_trade[3]       - $stock_Degradation_Price;
	
	$Price_dif                  = $the_price_now               - $quantitative_trade[4];
	//$quantitative_trade[6]-$Price_dif;
	//see if we own this stock today 
	//echo "test";
	
	
	
	if ( $quantitative_trade[1] == $trade[1] && $the_price_now < $quantitative_trade[5] && $the_price_now <> '' && isset ($the_price_now ) ||
		$the_hour == 3 && $the_min > 49 && $the_min < 59 && $the_ap=="pm" //catch all to sell off stock by the end of the day 
	
	
	
	){

		//23 didnt work 9/17
		//25 should work 50 is to much 
				$order_type="sell";
				$call_type= "TRADE";
				$symbol = $quantitative_trade[1];
				$time= time ();
				$qty =   $quantitative_trade[7];
				
				//check the amount of gains 
				$drop_pct = abs(round(((1 - $quantitative_trade[4] / $quantitative_trade[3]) * 100), 1, PHP_ROUND_HALF_DOWN ));
				//map it to the amount of gain ($gain % from buy) 1 - 100 
				$sale_pct=	round( map($drop_pct, "1", "100",   1, 100 ), 4, PHP_ROUND_HALF_DOWN );//first sales
				
			
				//waight 10 - 15 %
				$sale_pct = $sale_pct + ($sale_pct * 0.10);
				//the expected loss in respect to the amount of gains 
				$psale = "0". "." .str_pad((round( $sale_pct, 0, PHP_ROUND_HALF_DOWN )), 2, '0', STR_PAD_LEFT);
				
				
				if ($psale < 0.25 || !isset($psale)){
					
					$psale = 0.25;
					
				}
				
				
				
		$Base_Degradation_Price    = $quantitative_trade[3]       *   0.25;//1-25% losses of the buy price - ALPHA
		$Base_Price                = $quantitative_trade[3]       -   $Base_Degradation_Price;	
		//lost 15% of portfolio 			
		if ($the_price_now<=$Base_Price 
		//||
		//$the_hour >= 3 && $the_min > 29 && $the_min < 59 && $the_ap=="pm" 
		
		){	
			$Call_SELLING = TRUE;
			
			
			if ($day_trades_sold<>TRUE){
				$qty =   $quantitative_trade[7];
				
				//get the price from robinhood
				//$price_responce = (brokerage_API(NULL, $symbol, $price, $order_type, $STOCK_QTY_I_CAN_BUY));	
				//$json_obj = json_decode($price_responce);	
				
				//$MU_adj_price = $json_obj->last_trade_price * "0.00";//mark up
				//$adj_price = $json_obj->last_trade_price + $MU_adj_price;
				/* Using PHP_ROUND_HALF_UP with 2nd decimal digit precision PHP_ROUND_HALF_UP */				
				//$price = round( $json_obj->last_trade_price, 4, PHP_ROUND_HALF_DOWN );
				if($sim["mode"]=="live"){
				}
				else{
					
					if (isset($sim)){
					//	sleep('2');
					}
					//$price    = round(($the_price_now + ($the_price_now * 0.04)),4, PHP_ROUND_HALF_DOWN);
					$price    = round(($the_price_now ),4, PHP_ROUND_HALF_UP);
					$responce = (brokerage_API($call_type, $symbol, $price, $order_type, $qty));
				}
				$price_now = 0;	
				$STOCK_QTY_I_CAN_SELL = 0;
				//	$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
				$sql = "INSERT INTO `cycle_sell` (`trading_name`, 
				`MAX_POINT_ADV`,
				`BUY_PRICE`,
				`SELL_PRICE`, 
				`price_now`,
				`TYPE`, 
				`quantity`, 
				`BUY_CYCLE_TIME`, 
				`tranAct_id`, `HR`, `MIN`,
				`AP`, `YEAR`, `MON`, `DAY`, `DAY_SYMBL`, 
				`GP_id`)
				VALUES ('".$quantitative_trade[1]."',
				'0', 
				'".$quantitative_trade[3]."',
				'".$price."', 
				'".$the_price_now."',
				'SELL', 
				'".$qty."', 
				'".$time."',
				'Responder ".$Base_Price .": Base Price ".$responce."',
				'".$the_hour."',
				'".$the_min."', 
				'".$the_ap."', 
				'".$the_year."', 
				'".$the_mon."', 
				'".$the_day."',
				'".$the_day_symbl."', 
				'0')";
				//update the sell table on the database		
				$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
				$bsql = "UPDATE `day_trades` SET `TYPE` = 'TL' WHERE id = ".$trade[0]."";
				//if responce has '504 Gateway Time-out'
				if (strpos($responce, '504 Gateway') !== false) {
					echo "504 Gateway Error"; sleep(4);
					$sql =null;	
					$bsql=null;  
				}
				
				
				
				if (mysqli_query($sub_conn, $sql)) {
					echo "New record created successfully \n";
					} else {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
					sleep(700);
				}mysqli_close($sub_conn);usleep(60);
				usleep(1000);
			}
			if ($trade[7] == 'CW'){
				
				
				$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
				
				//print_r($row);
				
				if (mysqli_query($sub_conn, $bsql)) {
					echo "\n\n Stock ". $trade[2]." ".$trade[1]." is set in a Down Trend  (From buy price) in data set  \n";sleep(10);
					} else {
					echo "Error: " . $bsql . "<br>" . mysqli_error($conn);
				}
				mysqli_close($sub_conn);usleep(60);
				
			}
			
			
			
		}
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//i took this out 6/26/19
	//it wont sell if MAX_POINT_ADV has no value 
	//$the_price_now < $quantitative_trade[5]
	if ( $quantitative_trade[1] == $trade[1] && $the_price_now < $quantitative_trade[5] && $the_price_now <> '' && isset ($the_price_now )){
		
		
		
		//make sure the price im compareing it to could be real
		//math to sell a stock
		
		//if the price of the stock now, is higher then the buy price cut by 1% of the stock
		//set by the Degradation_Percent known as gain return risk
		if ($the_price_now>$low_deg_price){	
		

		
			
			
			//
			$over_ride_pct = round(((1 - $quantitative_trade[5] / $quantitative_trade[3]) * 100), 1, PHP_ROUND_HALF_DOWN );
			//
			$loss_val = round(((1 - $quantitative_trade[5] / $quantitative_trade[4]) * 100), 1, PHP_ROUND_HALF_DOWN );
			include("$SERVER_DIR/LOOP/degradation.php");
			
			
			
			// - ALPHA
					//loss time frame to profit time frame
					//Large ADV MOVE = low short time     / market is makeing large moves that wont hold profit
					//low ADV moves = long day trade time / market is more stable produceing profites over a long hold time 
					
			//ai down trend 		
			 AI_DT ( ($trade[1]), ($trade[1]."-".
						 $the_mon.
							  "-".
						 $the_day.
							  "-".
					$the_year."-".
					$the_hour."-".
					 $the_min."-".
					 $the_ap.""),
					 $trade[4] ,//mem 1
					 $price_to_buy_at, //mem2
					 $the_price_now,   //3
					 (time()),         //4
					$GAIN,//gain        5
					$INDXADV,// market index 6
					$loss_val,//loss in a stock 7
					$time_divergence,//8
					$trade,//9
					 $quantitative_trade,//10
					 $LAST_MIN,
					 array('galante'=>TRUE,'SELL'=>TRUE), $sim );
					 $call_it_quits = $_SESSION[($trade[1])]['SYSTEM']['ACTION']['DTI'];
			//mysqli_close($conn);			
			//echo $Price_dif;
			// 0.0051 - 0.0185
			
			//this trys to help hold onto a stock 			
			//map the cost to price change 
			//map .30 - 1.50  = .0090 - .03
			$price_change =  map($trade[12], $MIN_STOCK_PRICE, $MAX_STOCK_PRICE,"0.0190", "0.0296");
			$plan_price_a = $price_change - 0.0069;
			$plan_price_b = $price_change + 0.0010;
			$plan_price_c = $price_change - 0.0049;
			$plan_price_d = $price_change + 0.0010;
			
			if ($the_ap == "am"){
				$sale_freq= round( map($the_hour, "9", "12", $price_change  ,  $plan_price_a), 4, PHP_ROUND_HALF_DOWN );//buyins 12:05- 12:15 
				}else{
				if ($the_hour>= "1" && $the_hour <= "2"){
					$sale_freq=	round( map($the_hour, "1", "2",   $plan_price_b , $plan_price_c ), 4, PHP_ROUND_HALF_DOWN );//first sales
					}else{
					$sale_freq= round( map($the_hour, "2", "4",  $price_change  , $plan_price_d), 4, PHP_ROUND_HALF_DOWN );//end sales
				}
			}
			//	
			
			

			//.23 loss per $0.50
			//if the live price falls under the max price   //1.65 - 1.40 on a 3.00 price stock 
			//$round_MPA = round( map($quantitative_trade[5], "0.010", "30.00",  "0.046" , "29.50"), 4, PHP_ROUND_HALF_DOWN );
			$MPA_loss  = round(( $quantitative_trade[5] - 1.70), 2, PHP_ROUND_HALF_DOWN );
			//echo "\n".$round_MPA;
			//echo "\n".$MPA_loss;
			usleep(100);
			
			//0.04 - 0.06 loss control
			//price 0.27 15.4% = 0.04 | 0.69 16% = 0.11
			//$loss_freq= "-".(round( map($quantitative_trade[5], $MIN_STOCK_PRICE, $MAX_STOCK_PRICE,"12.00", "3.52"), 1, PHP_ROUND_HALF_UP ));//end sales
			
			session_start();
			$index_adv = $_SESSION['INDEXS_ADV'];
			
			
			$INDXADV = round(($index_adv/8),0,PHP_ROUND_HALF_UP);
			
			if ($INDXADV >="-20"){// -20
				$market_map =      map($INDXADV,    "-15", "40","1",    "40");
				if ($market_map >  40 ){$market_map =  40;}
				if ($market_map < -15 ){$market_map = -15;} //                                    // |Low risk market |Mid risk      |High risk
				$relation_high =  map($market_map, "1",   "40","48.1", "5.5"); //high   3.52 | high |1|1.5           |2 |2.5        |3 |3.5
				$relation_low  =  map($market_map, "1",   "40","10.9", "20");  //low    5.0  | low  |5|10            |15|20         |25|30
				}else{$relation_low="06.09"; $relation_high="10.00";//$1.40-2.70
				//$relation_low="10.00"; $relation_high="40.00";                                                                
			}				 
			$sum_of_sale =( ($quantitative_trade[4]-$quantitative_trade[3])+$quantitative_trade[5]) *2.5;																	 
			$loss_freq= "-".(round( (map($quantitative_trade[5], $MIN_STOCK_PRICE, $MAX_STOCK_PRICE,$relation_low,  $relation_high ) -8), 1, PHP_ROUND_HALF_UP ));//end sales
			//if the last saved price is more then the price now
			$loss_wa2      = $quantitative_trade[5] - $quantitative_trade[4];
			//$real_loss_wa2 = $quantitative_trade[5] 
			
			//if the trend of all the index's are moveing downward use a amplifier
			if ($DOWN_TREND == NULL){ 
				$ECH_LOSS_VAL = $loss_val * 2.0; //2.0-2.5
				}else{ $ECH_LOSS_VAL = $loss_val * 1.0; //1.0-1.7
			}
			//under a doller $1.00
			$sub_doller = null;
			//sub doller 
			if ($the_price_now < 1.00){
				$sub_doller = true ;
				
			}
			
			//echo "\n\032[1;33m Test\033[0m";
			

		
			
			//this might get a user stuck in a trade
			//&& $Price_dif < $sale_freq 
			if ($loss_val >= $loss_freq){}//set the stock return on investment 
			//$loss_val 
			
			//.02-1.7  1.7 low end to high end 7/22/19
			//$loss_val >= -4.01 && $stock_was_bught <> null && $loss_val <> "" && isset($loss_val) ||
			
			
			
			
			
			//sell by (if its looking bad loosing to much profit)
			//10:30
			//1:00
			//2:30
			//4:00
			//need to map for 3 point values 
			//price
			//under 1 
			//under 2.50 
			//under 5
			
			
			//$time_divergence =  round( map($the_hour,    "1", "1000","1",        "1000"),1,PHP_ROUND_HALF_DOWN);
			
							//check the amount of gains 
				$drop_pct = abs(round(((1 - $quantitative_trade[4] / $quantitative_trade[3]) * 100), 1, PHP_ROUND_HALF_DOWN ));
				//$gain_pct = abs(round(((1 - $quantitative_trade[5] / $quantitative_trade[3]) * 100), 1, PHP_ROUND_HALF_DOWN ));
			
			
			//echo "Over RW %: $over_ride_pct LOSS: $loss_val"; sleep(4);
			
			$drop_base_advs = round((abs(($padv - $old_a))), 0, PHP_ROUND_HALF_UP );
			if( $drop_base_advs <  5 ){	
				if ($padv < $old_a){
					$base_multi_plex = round((3 * ($drop_base_advs + 1)), 0, PHP_ROUND_HALF_DOWN );
					
				}
				else{$base_multi_plex = 3;}
			}
			else{$base_multi_plex = 3;}
			
			
			
			//localise change %
			
			$CHANGE_PCT =abs(round(((1 - $quantitative_trade[4] / $trade[12]) * 100), 1, PHP_ROUND_HALF_DOWN )); 
		//	echo $CHANGE_PCT ; echo "test feld"; sleep(10);
//sleeper function 	
//if change in % of a stock is moving fast 	
$SYSTEM_OVERIDE= FALSE;
$MEMM_ARRAY_BUILD= [];	
$CSELLSample_array= [];	
//$SCSELLSample_array= [];	
$CLSample_array = [];
			$SCSELLSample_array	= $_SESSION['MEM_CASH']['ML_Training'][($trade[1])]["SELL_SAMPLES"];
			$sSELL_Target	    = $_SESSION['MEM_CASH']['ML_Training'][($trade[1])]["SELL_Target"];
	$set_wait = null;
	//stuff to recall
$lastVCall_sell  = $_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['Last'];	
	$Ticks_sell  = $_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['Ticks'];	
	$SUB_Ticks_sell  = $_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['SUB_Ticks'];	
	$ChangeL_sell= $_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['Change'];	
	$CPrice_sell = $_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['PRICE'];		
	$CSTF_sell   = $_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['Time'];	//s	
	
	$MEMstart_sell = $_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['MEM_start'];		
	$MEMrecall_sell= $_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['MEM_recall'];	
	
	//set first recall		
	$time = time();		
	
			//map input from price deff  / change
				$ATestPrice = $CPrice_sell-$the_price_now;
				$FACT_CHANGE_PCT = $CHANGE_PCT - $ChangeL_sell;
	
//if we are past the memmery wait recall window	
	
	//reset session if data is out of range
	if ($CSTF_sell < $time){
		
		 $_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['Time'] = null;
		
	}
	
	if(!isset($CSTF_sell) && 			(abs($loss_val	)) > "7.5"   && $CHANGE_PCT > 50 ||
			$CSTF_sell ==""   		 && (abs($loss_val	)) > "7.5"   && $CHANGE_PCT > 50 
		//|| 
	)	
	{$set_wait=1;	
	
	//if we are in a simulation
	if(isset($sim)){
				$scroe_Sell = 1;	
				}else{
					
					$scroe_Sell = 60;
				}			
				
				
//$CLSample_array = array($time , $the_price_now);
	//$CSELLSample_array = array_merge ($SCSELLSample_array, ([$CLSample_array])); 
	//$_SESSION['MEM_CASH']['ML_Training'][$trade[1]]["SELL_SAMPLES"]= $CSELLSample_array;
				
				
		$_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['Time']	=$time + $scroe_Sell;//60s * 10min =600 
		$_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['PRICE']= $the_price_now;
		$_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['Ticks'] = $Ticks_sell + 1; // a signal to sell
		$_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['Change'] = $CHANGE_PCT;
		
		
		if ($MEMstart_sell<1 || $MEMstart_sell ==""){
	 $_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['MEM_start']=$time;		
	 $_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['MEM_recall']=$time;	
			
			
		}
	}
	
	
	
	
	
	

		//this is with in a 10 sec wait window
		if ($CSTF_sell > 1 && $CSTF_sell > $time  && $SYSTEM_OVERIDE <> TRUE){
			//set call back
			if ($Ticks_sell <10){//60 ticks each tick is 10/s 
			$set_wait=1;}else {$set_wait=0;}
			

				//price going down - theres a loss
				if ($ATestPrice>0.01 ){
					//changeing price
					
			


			if ($CPrice_sell <$the_price_now ){		
			if ($CPrice_sell <>$the_price_now ){	
			//if recall time is less with in 60 secs
	if(isset($sim)){
$recall_buffer = $MEMrecall_sell + 1;

	}
	
	else{
		$recall_buffer = $MEMrecall_sell + 60;
		
	}

if ($recall_buffer < $time&& $recall_buffer <> 60&& $recall_buffer <> 1){

	$_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['Ticks'] = $Ticks_sell + 1;
	
}
			
			$_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['PRICE'] = $the_price_now;	
			 
			}else{ 
			//price is going back up 
			//if recall time is less with in 60 secs
	if(isset($sim)){
$recall_buffer = $MEMrecall_sell + 1;
	}
	
	else{
		
		$recall_buffer = $MEMrecall_sell + 60;
	}

if ($recall_buffer < $time && $recall_buffer <> 60&& $recall_buffer <> 1){
	$_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['MEM_recall'] = 0;
	$_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['SUB_Ticks'] = $SUB_Ticks_sell +1;
	
}
			
			
			$_SESSION['CORE_TIMEBASE']['sell_sleep_timer']['Ticks'] = 0;
			
	
			}
			
				}
			
		$sellit_map =     round( map((abs($FACT_CHANGE_PCT)),    "10", "100","1",    "600"),0,PHP_ROUND_HALF_DOWN);
						//output map 1-600
			if ($sellit_map < 15){
				

			}ELSE{ 
		
			
			}
			
			
				}else{
					//the price is going back up
					
					
					
					}
				

		}	
				else{
					
	
		
		$set_wait=0;
	}	






				
			echo "\n\033[4;37mSelling Strategie\033[0m";
			
			echo "\n";
			
			echo "\n \033[0;96m Time dIV Gain:%" .(abs($time_divergence))."\033[0m \n";
			echo "\n \033[0;96m Feedback Gain:%" .(abs($over_ride_pct))."\033[0m \n";
			echo "\n \033[0;94m Full Stock Gain:%" .$CHANGE_PCT."\033[0m \n";
			
			if ($FACT_CHANGE_PCT<0.001 ){
			echo "\033[0;93mBuy-in Stock Gain:Going Down\033[0m \n";
			//build down trend
			//$MEMM_ARRAY_BUILD
			//$CSELLSample_array	= $_SESSION['ML_Training'][($SYB)]["SELL_SAMPLES"];
			//$SELL_Target	    = $_SESSION['ML_Training'][($SYB)]["SELL_Target"];
			
			
			
$CLSample_array = array($time , $the_price_now,(abs($loss_val	)));
	

	if (isset($CLSample_array)){
	$_SESSION['MEM_CASH']['ML_Training']["DOWN"][$time][($trade[1])]["SELL_SAMPLES"]= $CLSample_array;
	}
	$poc_test = $_SESSION['MEM_CASH'];
	//print_r($poc_test );
			
			if ($Ticks_sell <10){$set_wait=1;}
			}else{
			//build up trend
			//print_r ($trade[1]);
$CLSample_array = array($time , $the_price_now,$FACT_CHANGE_PCT);

	if (isset($CLSample_array)){
	$_SESSION['MEM_CASH']['ML_Training']["UP"][$time][($trade[1])]["SELL_SAMPLES"]= $CLSample_array;
	}
	$poc_test = $_SESSION['MEM_CASH'];
	//print_r($poc_test );
		
			//$CSELLSample_array	= $_SESSION['ML_Training'][($SYB)]["SELL_SAMPLES"];
			//$SELL_Target	    = $_SESSION['ML_Training'][($SYB)]["SELL_Target"];
			
				echo "\033[0;93mBuy-in Stock Gain:%".$FACT_CHANGE_PCT." Going Up\033[0m \n";
			$set_wait=1;	
			}
			
			echo "\n";
			echo "\033[0;95mRecall Price: R/PN ".$CPrice_sell ."/". $the_price_now."\033[0m \n";
			
			echo "\nSleep Timer Sell Ticks:  ". $Ticks_sell; 
			echo "\nSleep Timer Slot State:  ";print_r($CSTF_sell);echo " / ". $time;
			echo "\nThe Loss IN Trade: %".(abs($loss_val	));
			echo "\nWait Timer: ".$set_wait;
			
			
			
			
			
			//account for non change
			
			//account for movement after change 
			
			
			$track_down_trend  = 0;
			$ADDUPSUM = 0;
			$ADDDOWNSUM = 0;
			$track_up_trend  = 0;
			//up trend nounce
				$cpoc_test = $_SESSION['MEM_CASH']['ML_Training']["DOWN"];
				$dpoc_test = $_SESSION['MEM_CASH']['ML_Training']["UP"];
				
			//loop for down trend	
			foreach($cpoc_test as $proc_node){
				
			$ADDDOWNSUM = $ADDDOWNSUM + ($proc_node[($trade[1])]['SELL_SAMPLES'][1]);
				$sell_proc_node = $proc_node[($trade[1])]['SELL_SAMPLES'];
				
				
				$track_up_trend++;
			}
		
			//loop for up trend		
			foreach($dpoc_test as $proc_node){
				$ADDUPSUM = $ADDUPSUM + ($proc_node['CEI']['SELL_SAMPLES'][1]);
				$sell_proc_node = $proc_node['CEI']['SELL_SAMPLES'];
				
				
				$track_down_trend++;
			}echo "\n";
			
			
			$carrtrierDOWN_sum = round((($ADDDOWNSUM ) / $track_up_trend),4, PHP_ROUND_HALF_UP);
			$carrtrierUP_sum = round((($ADDUPSUM ) / $track_down_trend),4, PHP_ROUND_HALF_UP);
			
			
			//adverage the two
			$CARRIR_ADV =($carrtrierDOWN_sum + $carrtrierUP_sum )/2;
			
			//last price
			//$CPrice_sell
			$CHECKP_Price = $quantitative_trade[5] - ($quantitative_trade[5]  * 0.20);
			
			$DCHECKP_Price =$CARRIR_ADV            - ($CARRIR_ADV             * 0.20);
		$CHECKDCHECKP_Price =$CARRIR_ADV            + ($CARRIR_ADV             * 0.20);
			//if the price now is above the adv low price 
			if ($DCHECKP_Price < $the_price_now){
				
				
				
			}else{
				if ($the_price_now < $CHECKP_Price ){
				if ($Ticks_sell >10){
				$set_wait=0;
				
				}
			}
				
				else {//
				
				}			
				
			}
		
		
		//this will auto adjust
			if($CHECKDCHECKP_Price  > $CPrice_sell){ 
              $set_wait=1;

			}
				echo $set_wait."\n";
			
			
			
			
			
			
			
			
			
			//trending price
			echo "Trending price U/D/A:";
			print_r($carrtrierUP_sum);echo"/".$carrtrierDOWN_sum;echo"/".$CARRIR_ADV;
			echo "\n";echo "\n";echo "\n";	
		//to help slow down the sim for your eyes to see
			if (isset($sim)){
				//sleep('4');
			}
	//reset if price goss back up

			
			if (
			//$loss_val <1 && $stock_was_bught <> null && $loss_val <> "" ||
			//	$loss_wa2 > 0.07	  && $stock_was_bught <> null && $loss_val <> "" && $loss_val <> 0 && isset($loss_val) && $the_price_now > 2.00 ||//0.3-0.7
			//slppage
			
			
			//things to do 9/4/19 1:am
			//make backups of the day for emulation done
			//look at $loss_val >= $loss_freq
			//put time stuff in to hold off trade 
			
			
			//for all loss 6% in the am and 4% in the pm a script with ai is used changed to 3%am and 2%pm 11/1/19
			//you can map this to a chance of gain to inturpret a small number
			//but to do this you need a market index marker to wrrent
			
			// - ALPHA
			
			//in simulation test
			//for cei 
			//($Ticks_sell > 44 )||
			
			
			
			//keep when under a 40% gain untill a 3% loss stock made under 40%
			(abs($loss_val	)) > "3.0" && $the_ap == "am" && (abs($over_ride_pct)) < 20 && $CHANGE_PCT <=50 ||
			
			
			//if CHANGE_PCT is above 40% we need to make it wait 10 mins (in chunks) or use momentum
			//NOTE: you can see more then 50% loss of the gains right as the stock is inclineing 

			$set_wait <>1 &&	
			(abs($loss_val	)) > "7.5" && $the_ap == "am"  && $CHANGE_PCT > 50 ||
			
			
			$set_wait <>1 &&	
			(abs($loss_val	)) > "7.5" && $the_ap == "pm"  && $CHANGE_PCT > 50 ||
			
			
			
			
			//stuff to sell later in the day (mostlet around / after lunch)
			//$call_it_quits == 'Y' && 
			$set_wait <>1 &&
			(abs($loss_val	)) > "2.0" && ( abs($time_divergence)) > "10.0" && $the_ap == "pm"  && (abs($over_ride_pct)) < 20||
			
			//$call_it_quits == 'Y' && 
			$set_wait <>1 &&
			(abs($loss_val	)) > "40.0" && ( abs($time_divergence)) > "10.0" && $the_ap == "am" && (abs($over_ride_pct)) < 50||
			//$call_it_quits == 'Y' && 
			$set_wait <>1 &&
			(abs($loss_val	)) > "35.0" && ( abs($time_divergence)) > "10.0" && $the_ap == "pm" && (abs($over_ride_pct)) < 50||			

			//$call_it_quits == 'Y' && 
			$set_wait <>1 &&
			(abs($loss_val	)) > "50.0" && ( abs($time_divergence)) > "10.0" && $the_ap == "am" && (abs($over_ride_pct)) > 100||
			//$call_it_quits == 'Y' && 
			$set_wait <>1 &&
			(abs($loss_val	)) > "45.0" && ( abs($time_divergence)) > "10.0" && $the_ap == "pm" && (abs($over_ride_pct)) > 100||
			
			//the time divergence scripts are used for loss above 6%
			( abs($time_divergence))			 >=		"6.0" && 
			(abs($loss_val	)) 					 > 		"6.0" &&  
			(abs($loss_val	))  				 >= 	( abs($time_divergence)) &&
			$stock_was_bught 					 <> 	null  && 
			$loss_val <> 0 		&&
			$loss_val <> "" 	&& 
			isset($loss_val) 	
			||//1.0-2.0
			
			//$loss_val 		  >=  -1.8 		  && $stock_was_bught <> null && $loss_val <> "" && $loss_val <> 0 && isset($loss_val) && $the_price_now > 1.00 ||//0.3-0.7
			
			
			//buffer protect %
			//	$ECH_LOSS_VAL 	  <=  $loss_freq  && $stock_was_bught <> null && $loss_val <> "" && isset($loss_val) ||
			
			//gains under loss
			//$loss_val		  <=  $loss_freq  && $stock_was_bught <> null && $loss_val <> "" && isset($loss_val) ||
			
			
			
				$the_hour == 3 && $the_min > 55 && $the_min < 59 && $the_ap=="pm" && $Call_SELLING <> TRUE //catch all to sell off stock by the end of the day 
			
			
			
			
			
			
			//	$the_price_now    <=  $MPA_loss   && $stock_was_bught <> null
			
			){	
				
				//echo $quantitative_trade[1];
				//echo $quantitative_trade[4];
				//echo "\n";
				//echo $Price_dif;
				//echo "\n";	
				//sleep(700);		
				//have we made profet on top of the investment
				
				//          the last called price
				
				$raw_sell_price     = $price_now      * $GAIN_Percent;             //keep a stock at 0.06% gains 
				$sell_price         = $raw_sell_price + $price_now;                //around what price i think i should buy the stock at
				$max_money_out      = $CASH_BAL       * $min_investing_Percent;    //this is the max amount im willing to spend on this stock
				$MAX_STOCK_QTY      = $max_money_out  / $price_now;                //this is the max amount of soock i can buy (QTY)
				$The_Max_sell_Price;			  						//the max sell price in what i expect from the stock when it reaches meuteraty
				$Call_per_SALE; 										// the qanaty of how meany stock i think i can buy at the first sale
				$the_quantiy_i_plan_to_buy; 							// the amount i plan to buy in the first sale
				$STOCK_QTY_I_CAN_BUY ;
				$order_type="sell";
				$call_type= "TRADE";
				$symbol = $quantitative_trade[1];
				$time= time ();
				$qty =   $quantitative_trade[7];
				
				//
				//$quantitative_trade[4]  triger on loss of gains of more then 3.500 - 4.500 % in a 5 min interval
				//if in five mins theres a loss of >= then sell hold to make more gains
				
				if ($day_trades_sold<>TRUE){
				
					
					//get the price from robinhood
					//$price_responce = (brokerage_API(NULL, $symbol, $price, $order_type, $STOCK_QTY_I_CAN_BUY));	
					//$json_obj = json_decode($price_responce);	
					
					//$MU_adj_price = $json_obj->last_trade_price * "0.00";//mark up
					//$adj_price = $json_obj->last_trade_price + $MU_adj_price;
					/* Using PHP_ROUND_HALF_UP with 2nd decimal digit precision PHP_ROUND_HALF_UP */				
					//$price = round( $json_obj->last_trade_price, 4, PHP_ROUND_HALF_DOWN );
					if($sim["mode"]=="live"){
					}
					else{
						$price    = round(($the_price_now - ($the_price_now * 0.06)),4, PHP_ROUND_HALF_DOWN);
						//$price    = round(($the_price_now ),4, PHP_ROUND_HALF_UP);
						$responce = (brokerage_API($call_type, $symbol, $price, $order_type, $qty));
					}
					$price_now = 0;	
					$STOCK_QTY_I_CAN_SELL = 0;
					//	$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
					$sql = "INSERT INTO `cycle_sell` (`trading_name`, 
					`MAX_POINT_ADV`,
					`BUY_PRICE`,
					`SELL_PRICE`, 
					`price_now`,
					`TYPE`, 
					`quantity`, 
					`BUY_CYCLE_TIME`, 
					`tranAct_id`, `HR`, `MIN`,
					`AP`, `YEAR`, `MON`, `DAY`, `DAY_SYMBL`, 
					`GP_id`) VALUES ('".$quantitative_trade[1]."',
					'0', 
					'".$quantitative_trade[3]."',
					'".$price."', 
					'".$the_price_now."',
					'SELL', 
					'".$qty."', 
					'".$time."',
					'Loss is $loss_val Divergence %". $time_divergence." ".$responce."',
					'".$the_hour."',
					'".$the_min."', 
					'".$the_ap."', 
					'".$the_year."', 
					'".$the_mon."', 
					'".$the_day."',
					'".$the_day_symbl."', 
					'0')";
					//update the sell table on the database		
					$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
					$bsql = "UPDATE `day_trades` SET `TYPE` = 'TW' WHERE id = ".$trade[0]."";
					//if responce has '504 Gateway Time-out'
					if (strpos($responce, '504 Gateway') !== false) {
						echo "504 Gateway Error"; sleep(4);
						$sql =null;	
						$bsql=null;  
					}
					
					
					
					if (mysqli_query($sub_conn, $sql)) {
						echo "\n\033[1;32m New record created successfully \033[0m \n";
						} else {
						echo "Error: " . $sql . "<br>" . mysqli_error($conn);
						sleep(700);
					}mysqli_close($sub_conn);usleep(60);
					usleep(1000);
				}
				if ($trade[7] == 'CW'){
					
					
					$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
					
					//print_r($row);
					
					if (mysqli_query($sub_conn, $bsql)) {
						echo "\n\n (time divergence) Stock ". $trade[2]." ".$trade[1]." is moveing down in data set  \n"; sleep(30);
						} else {
						echo "Error: " . $bsql . "<br>" . mysqli_error($conn);
					}
					mysqli_close($sub_conn);usleep(60);
					
				}
				
				
				
				if(isset($sim)){
					//sleep(30);
				}			
				
				
			}
		}
	}			