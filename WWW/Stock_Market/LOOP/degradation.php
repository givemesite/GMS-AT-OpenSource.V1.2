<?php
//kris galante krisgcell@gmail.com

			//things to add 
			//if we are testing this script seen in test/12.php
				if(!isset($sim)){
				//used when looking at stocks to buy
				//$OLD_ADV =  $old_a;
				//$NEW_ADV = $padv;//
				}
				$DOWN_TREND = null;
				$sum_adv = $NEW_ADV - $OLD_ADV ; 
			
			//the gain it bought it at 
			//the higest gain 
			//$sum_adv   = round((map((abs($sum_adv)), 0, 20,  10 , 80)-0),0,PHP_ROUND_HALF_DOWN);
			

			
			//used when selling to map a down trend|| $over_ride_pct <= 30
			if ($DOWN_TREND == TRUE )  {
				$risk = 1.7; $pad=1.4;
				$DOWN_TREND = TRUE;
			}
			 //|| $over_ride_pct >=30
			if ($DOWN_TREND ==  null){
				$risk = 2.7; $pad=3.4;
				$DOWN_TREND = null;
			}
			//die($NEW_ADV);
			//if the new table adverage is low
			if ($NEW_ADV < 4){
			$time_divergence =  "-".round((map((abs($sum_adv)), 1, 20,  10 , 15)/$pad),0,PHP_ROUND_HALF_DOWN);
			$base_divergence =  "-".round((map((abs($sum_adv)), 1, 20,  10 , 15)/$risk),0,PHP_ROUND_HALF_DOWN);
			}else{
			$time_divergence =  "-".round((map((abs($sum_adv)), 1, 20,  10 , 15)*$pad),0,PHP_ROUND_HALF_DOWN);
			$base_divergence =  "-".round((map((abs($sum_adv)), 1, 20,  10 , 15)*$risk),0,PHP_ROUND_HALF_DOWN);
			}
			if ($NEW_ADV < 3){
			$time_divergence =  "-".round((map((abs($sum_adv)), 1, 20,  10 , 15)/($pad*2)),0,PHP_ROUND_HALF_DOWN);
			$base_divergence =  "-".round((map((abs($sum_adv)), 1, 20,  10 , 15)/($risk*2)),0,PHP_ROUND_HALF_DOWN);
			}
			if ($NEW_ADV < 2){
			$time_divergence =  "-".round((map((abs($sum_adv)), 1, 20,  10 , 15)/($pad*6)),0,PHP_ROUND_HALF_DOWN);
			$base_divergence =  "-".round((map((abs($sum_adv)), 1, 20,  10 , 15)/($risk*6)),0,PHP_ROUND_HALF_DOWN);
			}
			
			$base_divergence = 50;
			//sell around 9 am 
			if ($the_hour == 9 && $the_min >=30 && $the_min<=59 && $the_ap == "am" ){
				
				$time_divergence =  "-". round( map($the_min,    "1", "59", abs($base_divergence),		"15" ),1,PHP_ROUND_HALF_DOWN);
			}			
			//sell around 10 am 
			if ($the_hour == 10 && $the_min >=1 && $the_min<=59 && $the_ap == "am" ){
			//local change
			$time_divergence =  "-". round( map($the_min,    "1", "59",abs($base_divergence),		  "30"),1,PHP_ROUND_HALF_DOWN);//walking the % back down helps 
			}
			
			//sell around 10:30 am 
			if ($the_hour == 10 && $the_min >=30 && $the_min<=59 && $the_ap == "am" ){
			//local change
				$time_divergence =  "-". round( map($the_min,    "30", "59","40",		  abs($base_divergence)),1,PHP_ROUND_HALF_DOWN);//walking the % back down helps 
			}
			if ($DOWN_TREND == TRUE){
			//sell around 10:30 am 
			if ($the_hour == 10 && $the_min >=30 && $the_min<=59 && $the_ap == "am" ){
			//local change
				$time_divergence =  "-". round( map($the_min,    "30", "59","40",		  abs($base_divergence)),1,PHP_ROUND_HALF_DOWN);//walking the % back down helps 
			}
			}
			
			//skip 11am lunch to sell after
			
			
			//sell around 11:00 am 
			if ($the_hour == 11 && $the_min >=30 && $the_min<=59 && $the_ap == "am" ){
			//local change
				$time_divergence =  "-". round( map($the_min,    "30", "59","50",		  abs($base_divergence)),1,PHP_ROUND_HALF_DOWN);//walking the % back down helps 
			}
			if ($DOWN_TREND == TRUE){
			//sell around 10:30 am 
			if ($the_hour == 11 && $the_min >=30 && $the_min<=59 && $the_ap == "am" ){
			//local change
				$time_divergence =  "-". round( map($the_min,    "30", "59","50",		  abs($base_divergence)),1,PHP_ROUND_HALF_DOWN);//walking the % back down helps 
			}
			}
	
			
			
	// 12:30am sell after
			
			if ($the_hour == 12 ){
				
				if ($DOWN_TREND == TRUE){
				$time_divergence =  "-5.0";
			}
				if ($DOWN_TREND ==  null){
				$time_divergence =  "-35.00";
			}
				
			}
			
			//sell around 1pm
			if ($the_hour == 1 && $the_min >=10 && $the_min<=59 && $the_ap == "pm"){
				$time_divergence =   "-".round( map($the_min,    "10", "59",abs($base_divergence),        "30"),1,PHP_ROUND_HALF_DOWN);
			}
			//sell around 2pm
			if ($the_hour == 2 && $the_min >=10 && $the_min<=59 && $the_ap == "pm"){
				$time_divergence =  "-". round( map($the_min,    "10", "59",abs($base_divergence),        "30"),1,PHP_ROUND_HALF_DOWN);
			}
			//sell around 3pm
			if ($the_hour == 3 && $the_min >=10 && $the_min<=46 && $the_ap == "pm"){
				$time_divergence =  "-". round( map($the_min,    "10", "59",abs($base_divergence),        "30"),1,PHP_ROUND_HALF_DOWN);
			}
			//sell around 4pm
			if ($the_hour == 3 && $the_min >=45 && $the_min<=59 && $the_ap == "pm"){
				$time_divergence =  "-". round( map($the_min,    "45", "59","30",        abs( $base_divergence)),1,PHP_ROUND_HALF_DOWN);
			}
			
			
			//if ($time_divergence == -17 && $the_hour ==12 || $time_divergence == -17 && $the_hour ==11 || $time_divergence == -17 && $the_hour < 1){
			//	$time_divergence = -50;
			//	}
			//$loss_val ECH_LOSS_VAL
			if ((abs($loss_val	))  >= ( abs($time_divergence))	){
				
				$what_i_do = "Ill sell it";
				
			}else {	$what_i_do = "Ill keep it";}
			echo "\n gain pct $over_ride_pct %\n";
			echo "Loss is $loss_val \n";
			echo "Time Divergence At $the_hour:$the_min:$the_ap is ".$time_divergence. " ". $what_i_do;
			echo "\n";
			
			