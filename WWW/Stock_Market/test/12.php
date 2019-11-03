<?php

include('c:/php/WWW/Stock_Market/config.php');
//include("$SERVER_DIR/LOOP/logic_functions.php");
include("$SERVER_DIR/LOOP/all_starts_here.php");





//echo $_SERVER['SERVER_ADDR'] ;
Function HYPERBOLIC_TIME_BASE($time , $price , $NAME, $MPA){
	
/*	
UP
	|            *
	|          *
	|     *
	|   *
	|* *
	|________________
DOWN	
	|            
	|          
	|     
	|   **
	|* *    *     *
	|________________
*/	
	
	
	
}




//echo  HYPERBOLIC_TIME_BASE($time , $price , $NAME, $MPA);


//gain control
//------------------------------------------------------------------------



// %6.09 < - - - - 0 - - - - >%7.89
// %22   < - - - - 0 - - - - >%9


//buy risk
//------------------------------------------------------------------------
$time  = time();
 $price= 0.0;
 $NAME ="TEST";
 $MPA  = 0.0;


$OLD_ADV =  3.29 ;// row 3
$NEW_ADV =  1.69 ;// row 0
$M_ADV =0.01;
$MM_ADV= 22.0;



$the_hour = '09';
$the_min  = 55;
$the_ap   = "am";
$quantitative_trade[4]=2.40;
$quantitative_trade[5]=2.70;
$time_divergence = -17;

$MAX_STOCK_PRICE = 3.00;

$MIN_STOCK_PRICE = 0.10;


$the_price_now = 0.40;


$GAIN_Percent = 0.15;

$trade[12]= 0.41; //first seen price 

$trade[11]= 0.40; //lowest price 

$DOWN_TREND = null;
$sim = TRUE;



include("$SERVER_DIR/LOOP/multidimensional_hyperbola.php");
	

if ($trade[11] ==0 || !isset($trade[11]) || $trade[11] < 0.1 )
	
	{
		$low_threshold   = ($trade[12] * $GAIN_Percent)+ $trade[12];}
		
else{   $low_threshold   =  $trade[12] + ($trade[11]   * $GAIN_Percent);}
							//
    	$high_threshold  = ($trade[12] * $GAIN_Percent)+ $trade[12];
							//price found at  the price now
$proxy_Degradation = round(((1 - $trade[12] / $trade[11]) * 100), 1, PHP_ROUND_HALF_DOWN );


								
								//chaned the imput of the function from the $the_price_now to $trade 
								
								// 7 /24 /19
								
$price_to_buy_at = round(map($trade[12], $MIN_STOCK_PRICE, $MAX_STOCK_PRICE, $low_threshold , $high_threshold),4,PHP_ROUND_HALF_UP);
echo "estmated buy price ";
echo $price_to_buy_at;
echo "\n";


	
	$GAIN_Percent ="0.". $GAIN;
	echo "sum adv: $sum_adv Down Trend : ".$DOWN_TREND." Gain to time divergence at $the_hour:$the_min:$the_ap GAIN :$GAIN_Percent POS GAIN IDENTFIER : " . ($POS_GAIN  / 1.1);
echo '';
