<?php
	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//
	//	
	//   
	//
	//Part of
	// watch plan .php
	//kris galante krisgcell@gmail.com
	//////////////////////////////////////////////
	//Parts of this script link to 
	//////////////////////////////////////////////	
	
	
	
				//if we are testing this script seen in test/12.php
				if(!isset($sim)){
				//used when looking at stocks to buy
				$OLD_ADV =  $old_a;
				$NEW_ADV = $padv;//
				}
				$DOWN_TREND = null;
				$sum_adv = $NEW_ADV - $OLD_ADV ; 
				
				
		
				//if the adv moves in the same amount or under 1/pt
				//the normal gains to expect by 10 is under 13%
				
				//if the adv moves under or above 2/pt
				//the normal gains to expect by 10 is under 20% - 30%
				
				//if the adv moves under or above 5/pt
				//the normal gains to expect by 10 is under 80% - 170%

				//lets map the adv to a gain % for the high side of each maped X/pt
				
				//2.6 - shows some slippage (waited to long to buy)
				//1.6 - testing for 10/2/19 - ALPHA
				//1.3 - next test
				//1 = defalut (basic gain)
				$slippage = 0.6;
				
				//if the adv is low
				if($NEW_ADV < 4){
						$POS_GAIN = round((map((abs($sum_adv)), 0, 20,  10 , 80)/$slippage),0,PHP_ROUND_HALF_DOWN);
				}else{
				$POS_GAIN = round((map((abs($sum_adv)), 0, 20,  10 , 80)*$slippage),0,PHP_ROUND_HALF_DOWN);
				}
				
		
				if($NEW_ADV < 2){
					$PMTS = ( $slippage *2);
						$POS_GAIN = round((map((abs($sum_adv)), 0, 20,  10 , 80)/ $PMTS),0,PHP_ROUND_HALF_DOWN);
				}
				//if the new adverage is less
				
				if ($sum_adv < 0){
					$DOWN_TREND = TRUE;
					//$GAIN = "07";
				}
				
				
				
				//The gain (%) is maped from the database 
				//advarage gain compaired to the prevous day
				//if its more then well will want to buy
				if ($sum_adv > 0){
					//$GAIN = str_pad((round((map($sum_adv , 0, 2,  5 , 16)-0),0,PHP_ROUND_HALF_DOWN)), 2, '0', STR_PAD_LEFT);
					$DOWN_TREND = NULL;
				}
				
				
				//UP TREND

				//starts the up slope after 9am
				if ($the_hour == 9 && $the_min <= 59 && $the_min >= 0 && $DOWN_TREND == NULL){
					$GAIN = str_pad((round(map($the_min, 1, 59, 1 ,  $POS_GAIN),0,PHP_ROUND_HALF_UP)), 2, '0', STR_PAD_LEFT);
				}
				
				//starts the up slope after 10am	
				if ($the_hour == 10 && $the_min <= 59 && $the_min >= 0 && $DOWN_TREND == NULL){
					$GAIN = str_pad((round(map($the_min, 1, 59,   $POS_GAIN, 99),0,PHP_ROUND_HALF_UP)), 2, '0', STR_PAD_LEFT);
				}
				
				//starts the up slope after 9am
				if ($the_hour == 9 && $the_min <= 59 && $the_min >= 0 && $DOWN_TREND == TRUE){
					$GAIN = str_pad((round(map($the_min, 1, 59, 1 ,  $POS_GAIN),0,PHP_ROUND_HALF_UP)), 2, '0', STR_PAD_LEFT);
				}
				
				//starts the up slope after 10am	
				if ($the_hour == 10 && $the_min <= 59 && $the_min >= 0 && $DOWN_TREND == TRUE){
					$GAIN = str_pad((round(map($the_min, 1, 59,  $POS_GAIN , 99),0,PHP_ROUND_HALF_UP)), 2, '0', STR_PAD_LEFT);
				}
				
				if ($the_hour == 10 && $the_min <= 59 && $the_min >= 47  && $DOWN_TREND == TRUE){
				//	$GAIN = "20";
				}	
				
				
				//if its past 11 am try not to buy anything 
				if ($the_hour > 10){
					$GAIN  = 99;
				}
				//if its past 11 am try not to buy anything 
				if ($the_ap == "pm"){
					$GAIN  = 99;
				}

				if (!isset($GAIN  )){
				//	$GAIN  = 10;
				}
				if ($GAIN<"02"){
					$GAIN  = 90;
				}
				//$GAIN = "02";
				$GAIN_Percent ="0.". $GAIN;