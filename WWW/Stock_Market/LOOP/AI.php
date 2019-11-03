<?php
session_start();

//////////////////////////////////////////////
//////////////////////////////////////////////
//
//////////////////////////////////////////////
//
//////////////////////////////////////////////	

//MAX NEURONS
$MAX_NEURON = 700;

//MAX CELLS
$MAX_CELL   = 500;


 //AI ( $CELL, $TAG, $Memory_1, $Memory_2, $Memory_3, $Memory_4, $LAST_MIN, $Model );

 AI ( "XRTX", "XRTX-08-09-19-25-18-22", "161852747", 1.25, $Memory_3, $Memory_4, $LAST_MIN, $Model );

FUNCTION AI (
$CELL,		// the cell id 
$TAG,		// a tag for the cell to look it up by 
$Memory_1,	// time in micro seconds
$Memory_2,	// price 
$Memory_3,	// Max Price 
$Memory_4,	//
$LAST_MIN,	//
$Model		// buying / selling 
){
	$file  = "C:/php/www/Stock_Market/API/temp/ai.thought"; // I was running the code on localhost, and hence the path!
	$time_now= time();


		$last 			= file_get_contents($file);	
		//wait time 1 min intval
		$next_cell_time = strtotime("+60 seconds");
		
		
		
//LIVE		
if ($time_now > $last){
	
	file_put_contents($file, $next_cell_time);
	
	$run_me=TRUE;
}else{
	
	$run_me=FALSE;

	//return false;
	}
	
	
	
	//segment - 1 hour 
	
	
	
	
	
//cell sessons  

//price array

//cell count 

//cell model	
	
	
	$OLD_NEURON = $_SESSION[$CELL][$TAG];
	
	$new_NEURON = $_SESSION[$cell][$TAG];
	
	
		  $_SESSION[$CELL][$TAG]	=	$new_NEURON;
		  
		  
		  
		  
		  
		  
		  
	//end of function
}