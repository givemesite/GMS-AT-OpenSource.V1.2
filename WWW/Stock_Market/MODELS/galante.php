<?php
//		The Galante Model
//
//Built to day trade one transaction
//within the pattern day trade rule
//there are some constraints based 
//off this model 
//the weights and biases are set below
//it is advised not to change these paramaters
//
//by Kristopher A Galante

//Time base in micro secends  - seen by servers ie (TCP)
$USLEEP = 60;

//UI time base -seen by user IE UX
$SLEEP  = 7;

//INDEX Count - the numeric amount of indexs ie (dow,nadax,dpw,snp)=4
$WEIGHT['INDEX_COUNT'] = 8;

//RAM Spawn 
$RAM_SPAWN = 200;

//POINTS AND GAIN % - used in watch table scripts 
//The top of the market 
$WEIGHT['TOP_MARKET'] = 40;
//The bottom of the market
$WEIGHT['BOTTOM_MARKET'] = -15;
//Mid Point Advarage of the market 
$WEIGHT['MPA_MARKET'] = 1;
//High Mapped Gain %
$WEIGHT['HMGP_MARKET'] = 0.40494;
//Low Mapped Gain %
$WEIGHT['LMGP_MARKET'] = 0.127;
//Decimal place for percentages
$BIASES['DPP'] = 5;

//Buy in settings 
$BIASES['proxy_Degradation']= -34.0000;
//Market map base freq 
$WEIGHT['FREQ'] = 6;
//Market map top
$WEIGHT['MM_TOP'] = 10;
//Mark Up
$BIASES['STOCK_MARKUP'] = 0.04;
//Decimal place for USD
$BIASES['DPFUSD'] = 4;


//$WEIGHT[]
//$BIASES[]


