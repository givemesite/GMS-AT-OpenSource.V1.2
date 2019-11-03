<?php
///////////////////////////////////////////////////
///////////////////////////////////////////////////
///////////////////////////////////////////////////
//Asynchronous script to monitor stock market 
//
//
//Simplicity is the Ultimate Sophistication. Leonardo da Vinci.
//
//
//a_sync.php
///////////////////////////////////////////////////
///////////////////////////////////////////////////
///////////////////////////////////////////////////


include('c:/php/WWW/Stock_Market/config.php');
include ("$SERVER_DIR/A_SYNC/auto_trade.php");

//sleep(10);
//exit();
watch_dog();

//C:/php/bin/AHP/32bit-php-5.6/php.exe c:/php/WWW/Stock_Market/A_SYNC/a_sync.php


//////////////
//sessions
//
//
//
///////////////



for ($x = 0; $x <= 5000000000000000000;$x++
) {
//	sleep(00);
	if ($x   >=  1000000000000000 ){
		$x= 0;
	}
	
	   
	
	RUN_AUTTOTRADE($conn,$stocks_watch_mode,$SERVER_DIR,$BACK_CALL,$x);//auto_trade.php

	
	

	
//End of for loop 
}

 exit();
//mysqli_close($conn);

