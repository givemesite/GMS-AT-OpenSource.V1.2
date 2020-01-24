<?php	
	//kris galante krisgcell@gmail.com
	
	//to do list
	//dont trigger if
	
	//not at or above trigger price more then 3 times 
	//price recall
	//trigger session set 
	
	//BUY RISKS
	//echo "here";sleep(300);
	session_start();
	$index_adv = $_SESSION['INDEXS_ADV'];
	//echo round(($index_adv/8),0,PHP_ROUND_HALF_UP);
	
	//echo "The max stock price".$MAX_STOCK_PRICE;
	$ok_to_trade 	= FALSE;
	$base_trend 	= null;	
	$ok_trade 		= FALSE;
	
	// only compute for gaing % in a 23 min bracket
	//im my case 9:36 am to 9:59
	
	$call_min = $_SESSION['CL_Start_time'];
	$last_min = $_SESSION['CL_time'];	


if(!isset($sim)){
	$responce   = (call_trade_brokerage_API($call_type, $quantitative_trade[3], $price, $order_type, $STOCK_QTY_I_CAN_BUY));
					
			$json_obj = json_decode($responce);
			
			
					$bias_raw_cost = round(( $json_obj->avg_entry_price ),2,PHP_ROUND_HALF_UP);
	
		if ($bias_raw_cost > 0.001){
		$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		//print_r($row);
		$sql = "UPDATE `buy` SET `BUY_PRICE` = '".$bias_raw_cost."' WHERE id = ".$quantitative_trade[9]."";
		if (mysqli_query($sub_conn, $sql)) {
			//  echo "\n\n Stock ". $trade[2]." ".$trade[1]." is moveing down in data set  \n";
			} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($sub_conn);usleep(60);
		
	}
}	
	
	//set the start time, if this is not set it wont buy a stock
	if ($the_hr == 9 && $the_min < 59 && $the_min > 31 
	//&& $call_min == ''
	){
		$_SESSION['CL_Start_time'] = $the_min;
		
	}
	if (ISSET($call_min)){
		
		$ok_trade = TRUE;
		
	}
	
	$ok_trade = TRUE;
	

	
	//get the index adv
	$INDXADV = round(($index_adv/8),0,PHP_ROUND_HALF_UP);
	$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
	//see if we have done a day trade today
	$query = "SELECT * FROM `stock` WHERE `trading_name` = '".$trade[1]."' LIMIT 1 ";
	if ($result=mysqli_query($sub_conn,$query)){ 
		// Fetch one and one row
		while ($stock_trend=mysqli_fetch_row($result))
		{
			$base_trend=$stock_trend;
		}mysqli_close($sub_conn);usleep(60);}else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	//time the stock was put into the database 
	$data_time    = date("i",$base_trend[11]);
	$data_hr_time = date("g",$base_trend[11]);
	$data_ap      = date("a",$base_trend[11]);
	$data_day     = date("d",$base_trend[11]);
	if ($base_trend[11]<1){
		
		
		ECHO "\n ERROR : TIME DATA IN STOCK TABLE - No Match\n";
	}
	
	
	
	
	
	
	//update prices if stocks with incresing values are meet to constrantes
	//buy price updates
	////////////////////////////////////////////////////////////////////////////
	//update the price to follow in the watch / day trades table
	if ($trade[7] == 'CW'){
		$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		//print_r($row);
		$sql = "UPDATE `day_trades` SET `BUY_PRICE` = '".$the_price_now."' WHERE id = ".$trade[0]."";
		if (mysqli_query($sub_conn, $sql)) {
			//  echo "\n\n Stock ". $trade[2]." ".$trade[1]." is moveing down in data set  \n";
			} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($sub_conn);usleep(60);
		
	}
	//update the price to follow in the buy table 
	if ($trade[7] == 'CW' && $stock_was_bught == TRUE && $quantitative_trade[1] == $trade[1]){
		$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		//print_r($row);
		$sql = "UPDATE `buy` SET `price_now` = '".$the_price_now."' WHERE id = ".$quantitative_trade[9]."";
		if (mysqli_query($sub_conn, $sql)) {
			//  echo "\n\n Stock ". $trade[2]." ".$trade[1]." is moveing down in data set  \n";
			} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($sub_conn);usleep(60);
		
	}
	//update the price to follow in the buy table for the higest recoarded value 
	if ($trade[7] == 'CW' && $stock_was_bught == TRUE && $quantitative_trade[1] == $trade[1]){
		
		$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		//print_r($row);
		
		//if price is larger then last recoarded value
		if ( $the_price_now>$quantitative_trade[5]){						
			$sql = "UPDATE `buy` SET `MAX_POINT_ADV` = '".$the_price_now."' WHERE id = ".$quantitative_trade[9]."";
			if (mysqli_query($sub_conn, $sql)) {
				//  echo "\n\n Stock ". $trade[2]." ".$trade[1]." is moveing down in data set  \n";
				} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
			
				 $_SESSION[($quantitative_trade[1])]['DTI'][1]["LAST_PRICE"] = null;
				 $_SESSION[($quantitative_trade[1])]['DTI'][2]["LAST_PRICE"] = null;
				 $_SESSION[($quantitative_trade[1])]['DTI'][3]["LAST_PRICE"] = null;
		}
		mysqli_close($sub_conn);usleep(60);
		
	}
	
	
	
		//update the price to follow in the buy table for the higest recoarded value -the hr
	if ($trade[7] == 'CW' && $stock_was_bught == TRUE && $quantitative_trade[1] == $trade[1]){
		
		$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		//print_r($row);
		
		//if price is larger then last recoarded value
		if ( $the_price_now>$quantitative_trade[5]){						
			$sql = "UPDATE `buy` SET `HH` = '".$the_hour."' WHERE id = ".$quantitative_trade[9]."";
			if (mysqli_query($sub_conn, $sql)) {
				//  echo "\n\n Stock ". $trade[2]." ".$trade[1]." is moveing down in data set  \n";
				} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
			

		}
		mysqli_close($sub_conn);usleep(60);
		
	}	//update the price to follow in the buy table for the higest recoarded value - the min 
	if ($trade[7] == 'CW' && $stock_was_bught == TRUE && $quantitative_trade[1] == $trade[1]){
		
		
		$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		//print_r($row);
		
		//if price is larger then last recoarded value
		if ( $the_price_now>$quantitative_trade[5]){						
			$sql = "UPDATE `buy` SET `HM` = '".$the_min."' WHERE id = ".$quantitative_trade[9]."";
			if (mysqli_query($sub_conn, $sql)) {
				//  echo "\n\n Stock ". $trade[2]." ".$trade[1]." is moveing down in data set  \n";
				} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
			

		}
		mysqli_close($sub_conn);usleep(60);
		
	}
	
	//Lowest price recalled 
	if ($trade[7] == 'CW' && $stock_was_bught == TRUE && $quantitative_trade[1] == $trade[1]){
		$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		//print_r($row);
		
		//the more this gets triggered the more i will want to sell - note
		
		
		
		
		//if price is lower then last recoarded value
		if ( $the_price_now<$quantitative_trade[18]){						
			$sql = "UPDATE `buy` SET `LPR` = '".$the_price_now."' WHERE id = ".$quantitative_trade[9]."";
			if (mysqli_query($sub_conn, $sql)) {
				//  echo "\n\n Stock ". $trade[2]." ".$trade[1]." is moveing down in data set  \n";
				} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}		
		mysqli_close($sub_conn);usleep(60);	
	}
	
	
	
	
	//Lowest price recalled 
	if ($trade[7] == 'OC'){
		$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		//print_r($row);
		
		//if price is lower then last recoarded value
		if (		$base_trend[1]		 == 		$trade[1] && 
					$the_price_now		 <		$trade[4] && 
					$the_price_now 		 >		 0 && 
					$the_price_now		<		$trade[11] || 
					$trade[11]			<		"0.01" &&
					$the_price_now		<		$trade[4] && 
					$base_trend[1] 		==		$trade[1] && 
					$the_price_now 		> 		0
		){						
			$sql = "UPDATE `day_trades` SET `PLAN_A_CHANGE_PCT` = '".$the_price_now."' WHERE id = ".$trade[0]."";
			if (mysqli_query($sub_conn, $sql)) {
				//  echo "\n\n Stock ". $trade[2]." ".$trade[1]." is moveing down in data set  \n";
				} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}
		mysqli_close($sub_conn);usleep(60);
		
	}
	////////////////////////////////////////////////////////////////////////
	$ok_to_trade = FALSE;
	
	

	//check inputs for missing data
	if ($trade[4]> 0.001 && $trade[12] > 0.001  && $GAIN_Percent > 0.05){
	
	
	//print_r($base_trend);
	//echo $data_hr_time;	
	//echo $data_ap;	
	
	//only buy the data if its in the corrent timeframe
	//only buy a stock that is in our database during market hrs on the same day
	if   (  $data_day  == $the_day && $data_ap == "am" && $data_hr_time >="9"  && $data_hr_time <="12"  ||
			$data_day  == $the_day && $data_ap == "pm" && $data_hr_time >="1"  && $data_hr_time <="2"   ){
		
		$ok_to_trade = TRUE; 
		
	}else {$ok_to_trade = FALSE;}
	
	//echo$ok_to_trade;
	
	
	
	//map the gains needed to make a buy	
	
	
	if ($trade[11] ==0 || !isset($trade[11]) || $trade[11] < 0.1 )
	
	{
	$low_threshold   = ($trade[12] * $GAIN_Percent)+ $trade[12];}
	
	else{   $low_threshold   =  $trade[12] + ($trade[11]   * $GAIN_Percent);}
	//
	$high_threshold  = ($trade[12] * $GAIN_Percent)+ $trade[12];
	//price found at  the price now
	$proxy_Degradation = round(((1 - $trade[12] / $trade[11]) * 100), 1, PHP_ROUND_HALF_DOWN );
	
	
	//Note
	//chaned the input of the function from the $the_price_now to $trade [12]
	
	// 7 /24 /19
	
	$price_to_buy_at = round(map($trade[12], $MIN_STOCK_PRICE, $MAX_STOCK_PRICE, $low_threshold , $high_threshold),4,PHP_ROUND_HALF_UP);
	
	echo " Trade Watch ".substr($trade[2],0,17) . " 	Price ".$trade[4] ." "  .$price_to_buy_at. "	".$the_price_now ." FREQ Histogram :"." ".$trade[9]." ";
	
///Basic Floor Model	
//last price indicator

$LAST_PRICE_IND = $_SESSION[($trade[1])]['LPI'];

//ML - MUX  buy model
$prididct_data= array([$the_price_now,
								$the_hour,
								$the_min,
								$INDXADV,
								$CHANGE_VOL,
								$quantitative_trade[19] ,
								$quantitative_trade[20] ,
								$quantitative_trade[21] ,
								$quantitative_trade[5] ,
								$CHANGE_PCT , 
							//	(time()),
							    ($trade[20]), //org price
								($trade[9]), //FREQ
								($trade[28]),//org call price
								($trade[29]),//org gain%
								($trade[30]) //last 5 days adverage
							]);//5 day trend
							
	//pink noise data							
		$_SESSION['MODEL_BUILD']['ML_Training']['potentials_samples_MODE'][(time())]= $prididct_data;	
		$_SESSION['MODEL_BUILD']['ML_Training']['potentials_targets_MODE'][(time())]= $the_price_now;	
	
	
	//echo "\n proxy_Degradation ". $proxy_Degradation."\n";
	//echo "\n Degradation_Percent ". $Degradation_Percent."\n";
	//echo "\n the_price_now ". $the_price_now."\n";
	//echo "\n price_to_buy_at ". $price_to_buy_at."\n";
	//echo "\n trade[11]  ". $trade[11] ."\n";
	//print_r($base_trend);
	
	//a stock that has a price thats gone up
	
	
	
	}
	
	//need to make arduino api first
	
	//would like to use ai and sessions with no sql 
	
	//htf defalut - ALPHA
	
	//down trend - $DOWN_TREND == TRUE
	
	//low change under 3
	
	//stock price drop $ > (price 1 TRG $0.05) price $4)$0.20 
	
	
	
	if (
	isset($the_price_now) &&
	//$the_price_now >= $trade[4] &&
	//$the_price_now > $trade[3] &&
	//$low_threshold<$the_price_now &&
	//	$proxy_Degradation >= $Degradation_Percent &&
	//	$proxy_Degradation >= "-34.0000" &&//defalut
	$the_price_now >= $price_to_buy_at && 
	//	$the_price_now > $trade[11] && 
	//$the_price_now<> $trade[11] && 
	
	//the amount of risk im willing to take in the market -60 -TO  -2
	//so if the market is louseing money it wont buy a stock
	$INDXADV >= -2 && 
	
	//prevents it from buying data 
	//older then the age of the script 
	$ok_to_trade   <> FALSE &&
	$ok_trade      <> FALSE &&
	$base_trend[1] == $trade[1] //make sure its the same stock
	){//sql/local/day-trade/c-PLAN_A_PRICE
		
		
		
		//find first OC / CW in data set and buy on cycle A
		if ($trade[7] == 'OC' || $trade[7] == 'CW'){ 
			
			//back up plan if all else fails
			$Price_dif = $the_price_now - $trade[12];
			
			//buy price range 
			$buy_price_range =  round( map($the_price_now, $MIN_STOCK_PRICE, $MAX_STOCK_PRICE,  "0.0117", "0.0296"), 0, PHP_ROUND_HALF_DOWN ); 
			//	if ($Price_dif > $buy_price_range){
			//	$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
			
			//make investment
			$raw_sell_price      = $the_price_now   * $GAIN_Percent;          //keep a stock at 0.06% gains 
			$sell_price          = $raw_sell_price  + $the_price_now;             //around what price i think i should buy the stock at
			$max_money_out       = $CASH_BAL        * $min_investing_Percent; //this is the max amount im willing to spend on this stock
			$MAX_STOCK_QTY       = $max_money_out   / $the_price_now;             //this is the max amount of soock i can buy (QTY)
			$The_Max_sell_Price;									//the max sell price in what i expect from the stock when it reaches meuteraty
			$Call_per_SALE; 										// the qanaty of how meany stock i think i can buy at the first sale
			$the_quantiy_i_plan_to_buy; 							// the amount i plan to buy in the first sale
			$STOCK_QTY_I_CAN_BUY =  round( $MAX_STOCK_QTY, 0, PHP_ROUND_HALF_DOWN );
			
			$order_type="buy";
			$call_type= "TRADE";
			$symbol = $trade[1];
			$check_freq = explode("-",$freq_a);
			$min_freq   = explode("-",$freq_b);
			
			//mapped for 9:32 to 9:50
			//get time and hour stuff              
			
			//linear flex
			//Buy in
			//make buy for a stock (not over < not under >)
			//time < 9:30AM but not > over the hour 
			//FREQ >= 16
			//time < 9:40AM but not > over the hour 
			//FREQ >= 11		
			//dont buy after
			//by 9:50 am look for stock with a freq of 11			
			
			
			
			
			
			if ($the_ap == "am" && "9" == $the_hour &&  $the_min >= "31"
			){
				$FREQ = round( map($the_min, "31", "59", $check_freq[0], $min_freq[0]), 0, PHP_ROUND_HALF_UP );//get historagram freq
			}	
			
			if ($the_ap == "am" && "10" == $the_hour 
			){
				if ($the_min>= "30"){
					$FREQ = round( map($the_min, "30", "59", $min_freq[0], $check_freq[0]), 0, PHP_ROUND_HALF_UP );
					}else {
					$FREQ = round( map($the_min, "0", "30", $check_freq[0],$min_freq[0] ), 0, PHP_ROUND_HALF_UP );
					
				}
			}		
			if ($the_ap == "am" && "11" == $the_hour 
			){
				if ($the_min>= "30"){
					$FREQ = round( map($the_min, "30", "59", $min_freq[0], $check_freq[0]), 0, PHP_ROUND_HALF_UP );
					}else {
					$FREQ = round( map($the_min, "0", "30", $check_freq[0],$min_freq[0] ), 0, PHP_ROUND_HALF_UP );
					
				}
			}			
			if ($the_ap == "pm" && "12" == $the_hour 
			){
				if ($the_min>= "30"){
					$FREQ = round( map($the_min, "30", "59", $min_freq[0], $check_freq[0]), 0, PHP_ROUND_HALF_UP );
					}else {
					$FREQ = round( map($the_min, "0", "30", $check_freq[0],$min_freq[0] ), 0, PHP_ROUND_HALF_UP );
					
				}
				
			}		
			
			if ($the_ap == "pm" && "1" == $the_hour 
			){
				if ($the_min>= "30"){
					$FREQ = round( map($the_min, "30", "59", $min_freq[0], $check_freq[0]), 0, PHP_ROUND_HALF_UP );
					}else {
					$FREQ = round( map($the_min, "0", "30", $check_freq[0],$min_freq[0] ), 0, PHP_ROUND_HALF_UP );
					
				}
				
				
			}	
			if ($the_ap == "pm" && "2" == $the_hour 
			){
				if ($the_min>= "30"){
					$FREQ = round( map($the_min, "30", "59", $min_freq[0], $check_freq[0]), 0, PHP_ROUND_HALF_UP );
					}else {
					$FREQ = round( map($the_min, "0", "30", $check_freq[0],$min_freq[0] ), 0, PHP_ROUND_HALF_UP );
					
				}
			}
			
			
			session_start();
			$index_adv = $_SESSION['INDEXS_ADV'];
			echo " \n\033[1;33m Trade Watch ".substr($trade[2],0,17) . " 	Price ".$trade[4] ." "  .$price_to_buy_at. "	".$the_price_now ." FREQ Histogram :"." ".$trade[9]." \033[0m \n";
			
//AI is just used to help buying its not used for selling at the moment but this will change in 2020
			
			$traning_sample = array($trade[12],$trade[4],$quantitative_trade[3],$quantitative_trade[4],$quantitative_trade[5]);
			
			$_SESSION['ML_Training'][($trade[1])]["BTarget"] = $traning_sample;
			
			
			 $target_bias = $trade[4] - ($trade[4]* (0.20));
			$_SESSION['ML_Training'][($trade[1])]["Target"] = $trade[4];


			
			$INDXADV = round(($index_adv/8),0,PHP_ROUND_HALF_UP);
		//cell       //tag
 AI ( ($trade[1]), ($trade[1]."-".
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
					 $the_price_now,
					 (time()),
					$GAIN,//gain        5
					$INDXADV,// market index 6
					$loss_val,//loss in a stock 7
					$time_divergence,//8
					$trade,//9
					 $quantitative_trade,//10
					 $LAST_MIN,
					 array('galante'=>TRUE,'BUY'=>TRUE), $sim );
								 
			
			
			
			$market_map =     round( map($INDXADV,    "-15", "1","6",    "1"),0,PHP_ROUND_HALF_DOWN);// 10-2, 8-4, 6-1

//last price indicator

$LAST_PRICE_IND = $_SESSION[($trade[1])]['LPI'];

//ML - buy model
$bprididct_data= array([$the_price_now,
								$the_hour,
								$the_min,
								$INDXADV,
								$CHANGE_VOL,
								$quantitative_trade[19] ,
								$quantitative_trade[20] ,
								$quantitative_trade[21] ,
								$quantitative_trade[5] ,
								$CHANGE_PCT , 
							//	(time()),
							    ($trade[20]), //org price
								($trade[9]), //FREQ
								($trade[28]),//org call price
								($trade[29]),//org gain%
								($trade[30]) //last 5 days adverage
							]);//5 day trend
//buy data
		$_SESSION['MODEL_BUILD']['ML_Training']['BUY_samples_MODE'][(time())]= $bprididct_data;	
		$_SESSION['MODEL_BUILD']['ML_Training']['BUY_targets_MODE'][(time())]= $the_price_now;
		
		
			echo " \n\033[1;33m Market Map: $market_map  \033[0m\n";
			
					//break the current loop with some stuff 
						//
						$_SESSION['LOOPBREAK']=1;
			
			
			if(isset($sim)){
				//sleep(10);
			}
			if ($market_map > 10 ){$market_map =10;}
			if ($market_map <  0 ){$market_map =1;}
			
			
			//looks at the min and max freq and sets the error handle
			//	if ($trade[9]>=$FREQ  && $FREQ > 1 || $trade[9] >= $market_map){//catch all / first in first out
			//echo"here";
			$bad_day_trade =false;	
			//}else{$bad_day_trade = TRUE;}
			
			//	echo $trade[9];
			//	echo$bad_day_trade;
			//if we should make a day trade
			//echo "\n";
			//					echo $Price_dif;
			//		echo "\n";		
			//		echo $day_trades_used ;
			//		echo "\n";	
			//		echo $bad_day_trade;
			
			//- ALPHA
			$pass_path_Trend = ($_SESSION['SYSTEM']['MSC']['PATH_TREND']) + ($INDXADV * $INDXADV);
			//used with the ai system
			$call_it_quits = $_SESSION[($trade[1])]['SYSTEM']['ACTION']['CTQ'];
			
			
			if (
			//- ALPHA
				//$pass_path_Trend >= "-10.00"	 && need to fix
				$day_trades_used <> TRUE	 &&
				$bad_day_trade <> TRUE	 && 
				$call_it_quits <> "N"	 && 
				isset($call_it_quits)
				
				){
				
				//			echo "\n";
				//			echo "looking in to trade";
				//get the price from robin hood
				//$price_responce = (brokerage_API(NULL, $symbol, $price, $order_type, $STOCK_QTY_I_CAN_BUY));	
				//$json_obj = json_decode($price_responce);
				//print_r($json_obj);
				//$price_len = strlen ( $the_price_now );
				
				/* Using PHP_ROUND_HALF_UP with 2nd decimal digit precision PHP_ROUND_HALF_UP */
				//$intrest = $json_obj->last_trade_price * "0.04";//need to mark the stock up for the coller 0.04- 0.06 | 3%=0.0375 4%=0.05 5%=0.0625 6%=0.075
				//$cold_price = $json_obj->last_trade_price +$intrest;
				//$price = round( $cold_price, 4, PHP_ROUND_HALF_DOWN );
				//the call to buy if its in a sim
				
				
				//7.17.19 5 % got rejected trying 4
				//8.12.19 4-5 rejected trying 6
				//8/13/19
				//order was pending for most of the day 
				//think the price in the order was to low to execute, under market value
				//im thinking a good defult to set the buffer to coller would be around 17%
				//
				//also on a side note. saw that 6% of $the_price_now can be the NEXT PRICE POINT 
				//the price incressed by 6% is around the next lowest price right before a incline, usuley the secened to last 
				//
				
				
				// 6%     15%     20%
				//low gaining
				//defalut  0.05- 0.06
				//large gaining
				//Defalut  17- 0.19
				//18 is not working, to high of a coller going back down to 6 
				$DEFF_BUFFER = 0.06;
				
				
				if($sim["mode"]=="live"){
					//$responce = (brokerage_API(null, $symbol, $price, $order_type, $STOCK_QTY_I_CAN_BUY));
					$price_bught = round(($the_price_now + ( ($the_price_now) * $DEFF_BUFFER)), 4, PHP_ROUND_HALF_UP );
				}
				else{									//4% markup
					$price = round(($the_price_now + ($the_price_now * $DEFF_BUFFER)),4, PHP_ROUND_HALF_DOWN);
					$responce   = (brokerage_API($call_type, $symbol, $price, $order_type, $STOCK_QTY_I_CAN_BUY));
					
					
				}
				if($sim["mode"]<>"live"){
					$json_obj = json_decode($responce);
					$raw_cost = ( ($json_obj->portfolio_value - $json_obj->buying_power)    /  $STOCK_QTY_I_CAN_BUY);
					$price_bught =round($raw_cost, 4, PHP_ROUND_HALF_UP );		
					
					
					//if we cant buy the stock from lack of funds, save the price in the db
					if ($STOCK_QTY_I_CAN_BUY < '1'){
						$price_bught = round(($the_price_now + ( ($the_price_now) * $DEFF_BUFFER)), 4, PHP_ROUND_HALF_UP );
					}
				}
				
				//get the daytrade data and throw it into a array for debugging 
							ob_start();

							//(var_dump($trade));

							$out = ob_get_clean();
							$out = strtolower($out);
							$out  = json_encode($out);
							var_dump($out);
							
							
							$dump = get_defined_vars();
						//ob_start();
						$Dump_out  = json_encode($dump);
						//(var_dump($dump));

						//$Dump_out = ob_get_clean();
						//$Dump_out = strtolower($Dump_out);
						//$Dump_out  = json_encode($Dump_out);
													
				//to fix if a order is rejected $0 returned price  
				if ($price_bught <> 0 ){
					$time= time ();
					//$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);		
					$sql = "INSERT INTO `buy` (`trading_name`, 
					`MAX_POINT_ADV`,
					`BUY_PRICE`,
					`SELL_PRICE`, 
					`price_now`,
					`TYPE`, 
					`quantity`, 
					`BUY_CYCLE_TIME`, 
					`tranAct_id`, `HR`, `MIN`,
					`AP`, `YEAR`, `MON`, `DAY`, `DAY_SYMBL`, 
					`GP_id`,`AG`)
					VALUES ('".$trade[1]."',
					'".$price_bught."', 
					'".$price_bught."',
					'$price', 
					'$the_price_now',
					'BUY', 
					'".$STOCK_QTY_I_CAN_BUY."', 
					'".$time."',
					'".$model . "     ".$responce."     ". $Dump_out ."     ".$out."',
					'".$the_hour."',
					'".$the_min."', 
					'".$the_ap."', 
					'".$the_year."', 
					'".$the_mon."', 
					'".$the_day."',
					'".$the_day_symbl."', 
					'0','".$GAIN_Percent."')";//
					$_SESSION['QTY']= $STOCK_QTY_I_CAN_BUY;
					$bsql = "UPDATE `day_trades` SET `TYPE` = 'CW', `PRICE`  =  '".$the_price_now ."' WHERE id = ".$trade[0]."";
					//if responce has '504 Gateway Time-out'
					if (strpos($responce, '504 Gateway') !== false) {
						echo "504 Gateway Error"; sleep(4);
						$sql =null;	
						$bsql=null;  
					}
					
					
					
					$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
					if (mysqli_query($sub_conn, $sql)) {
						echo "\n\033[1;32m New record created successfully \033[0m \n";
						} else {
						echo "Error: " . $sql . "<br>" . mysqli_error($conn);
					}	usleep(1000);
					mysqli_close($sub_conn);usleep(60);
					
					
					$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
					//set bad stock index
					
					
					if (mysqli_query($sub_conn, $bsql)) {
						echo "\n\n Stock ". $trade[2]." ".$trade[1]." is moveing UP in data set  \n";
						
						//break the current loop with some stuff 
						//since we just bought a stock
						$_SESSION['LOOPBREAK']=1;
						 return false;//defalut output
						 $day_trades_used = TRUE;//sets a trade in local vars
						 $RUN_LIVE= TRUE;//this stops the loop
						// break;
						
						
						} else {
						echo "Error: " . $bsql . "<br>" . mysqli_error($conn);
					}
					usleep(1000);
					mysqli_close($sub_conn);usleep(60);
					if(isset($sim)){
						sleep(10);
					}
					//continue;
					
				}else{
					//sql for rejected a order
					
				}
			}
			//	} //price deff
		}
	}	