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
	
	
	
	if ( $quantitative_trade[1] == $trade[1] && $the_price_now < $quantitative_trade[5] && $the_price_now <> '' && isset ($the_price_now )){
		//16% didnt work 7/20/19 so i moved it to 20
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
				
				
				
		$Base_Degradation_Price    = $quantitative_trade[3]       *   $psale;//1-25% losses of the buy price - ALPHA
		$Base_Price                = $quantitative_trade[3]       -   $Base_Degradation_Price;	
		//lost 20% of portfolio 			
		if ($the_price_now<=$Base_Price ){	
			
			
			
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
						sleep('2');
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
				'Responder ".$psale.": Base Price ".$responce."',
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
					echo "\n\n Stock ". $trade[2]." ".$trade[1]." is TOTAL LOSS (From buy price) in data set  \n";sleep(10);
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
			$over_ride_pct = round(((1 - $quantitative_trade[3] / $quantitative_trade[5]) * 100), 1, PHP_ROUND_HALF_DOWN );
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
			echo "\n".$round_MPA;
			echo "\n".$MPA_loss;
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
			
			
			
			echo "\n";
			echo "\n Stock cycle return risk \n";
			echo "loss val(old/new)".$ECH_LOSS_VAL;
			echo "\n";
			echo "maped loss freq  ".$loss_freq;
			
			
			if (isset($sim)){
				sleep('2');
			}
			
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
			$call_it_quits == 'Y' && (abs($loss_val	)) > "6.0" && ( abs($time_divergence)) > "10.0" && $the_ap == "am"||
			$call_it_quits == 'Y' && (abs($loss_val	)) > "4.0" && ( abs($time_divergence)) > "10.0" && $the_ap == "pm"||
			
			
			
			//the time divergence scripts are used for loss above 6%
			( abs($time_divergence))			 >=		"6.0" && 
			(abs($loss_val	)) 					 > 		"6.0" &&  
			(abs($loss_val	))  				 >= 	( abs($time_divergence)) &&
			$stock_was_bught 					 <> 	null  && 
			$loss_val <> 0 		&&
			$loss_val <> "" 	&& 
			isset($loss_val) 	||//1.0-2.0
			
			//$loss_val 		  >=  -1.8 		  && $stock_was_bught <> null && $loss_val <> "" && $loss_val <> 0 && isset($loss_val) && $the_price_now > 1.00 ||//0.3-0.7
			
			
			//buffer protect %
			//	$ECH_LOSS_VAL 	  <=  $loss_freq  && $stock_was_bught <> null && $loss_val <> "" && isset($loss_val) ||
			
			//gains under loss
			//$loss_val		  <=  $loss_freq  && $stock_was_bught <> null && $loss_val <> "" && isset($loss_val) ||
			$the_hour == 3 && $the_min > 30 && $the_min < 59   //catch all to sell off stock by the end of the day 
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