<?php

include('c:/php/WWW/Stock_Market/config.php');
//include("$SERVER_DIR/LOOP/logic_functions.php");
include("$SERVER_DIR/LOOP/all_starts_here.php");

$the_hour = 10;
$the_min  = '15';
$the_ap   = "am";
//most current advarage
	 $padv  = '2.40';
	 //past day advarage 
    	$old_a = '5.56';
//buy in price
$quantitative_trade[3]=0.40;
//emulated price now
$quantitative_trade[4]=0.45;
//high price 
$quantitative_trade[5]=0.49;

$time_divergence = -17;
			$over_ride_pct = round(((1 - $quantitative_trade[3] / $quantitative_trade[5]) * 100), 1, PHP_ROUND_HALF_DOWN );
			$loss_val = round(((1 - $quantitative_trade[5] / $quantitative_trade[4]) * 100), 1, PHP_ROUND_HALF_DOWN );

include("$SERVER_DIR/LOOP/degradation.php");
 //the output sent to user 
if ($ECH_LOSS_VAL	  <=  $time_divergence	){
	
	$what_i_do = "Ill sell it";
	
}else {	$what_i_do = "Ill keep it";}
echo "\n";
//echo "Loss is $loss_val \n";
//echo "Time Divergence At $the_hour:$the_min:$the_ap is ".$time_divergence. " ". $what_i_do;
echo "\n";

