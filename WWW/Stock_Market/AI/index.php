<?php
session_start();
//	ini_set('display_errors', '1');
//////////////////////////////////////////////
//////////////////////////////////////////////
//
//////////////////////////////////////////////
//kris galante krisgcell@gmail.com
//////////////////////////////////////////////	

	
//MAX NEURONS
$MAX_NEURON = 700;

//MAX CELLS
$MAX_CELL   = 500;


FUNCTION AI (
$CELL		= null,		// the cell id 
$TAG		= null,		// a tag for the cell to look it up by 
$Memory_1	= null,	// The Price First Seen
$Memory_2	= null,	// The Price Expected To Buy At
$Memory_3	= null,	// Last Recalled Price 
$Memory_4	= null,	// TIME
$Memory_5	= null,	// GAIN
$Memory_6	= null,	// market index adv
$Memory_7	= null,	// loss of a stock 
$Memory_8	= null,	// time divergence
$Memory_9	= null,	// SQL trade DATA
$Memory_10	= null,	// quantitative trade
$LAST_MIN	= null,	// null
$Model		= null, // buying / selling 
$sim        = null
){
		$servername         = "127.0.0.1";
		$username           = "root";
		$dbname             = "stock_market_local";
		$password           = "";
			
$samples = [[60-6-5], [61-6-5], [62-6-5], [63-6-5], [64-6-5]];
$targets = [1.10, 0.95, 1.22, 1.20, 1.19];
	
	
	
	
	
	
	
	$file  = "C:/php/www/Stock_Market/API/temp/ai.$CELL.thought"; // I was running the code on localhost, and hence the path!
	$time_now= time();


		$last 			= file_get_contents($file);	
		//100/s 3 c     = 5mins
		//333/s 3 calls = 16 min
		//every 400/s = 8 mins update the data in the cell
		
					$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
			$mqmquery = "SELECT * FROM `advs` LIMIT 1";
			if ($aresult=mysqli_query($sub_conn,$mqmquery)){ 
				// Fetch one and one row
				while ($get_advsnum=mysqli_fetch_row($aresult))
				{
					$old_advs      = $get_advsnum[0];
					$old_day      = $get_advsnum[2];
					$old_a      = $get_advsnum[3];
				}}
				mysqli_close($sub_conn);usleep(200);
		//wait time 8 min intval
		//225-600
		//60-120?  80 10/3/16 - ALPHA
		//5-15
		if($sim["mode"]<>"live"){
			
			//the time the program has to think about the price changeing when it buys 
			if ($old_advs > 4){
		$next_cell_time = strtotime("+1 seconds");//190-220
			}else {
				$next_cell_time = strtotime("+1 seconds");//150-200
				
			}
		
		if ($old_advs < 3){
			$next_cell_time = strtotime("+50 seconds");//50-110
		}
		if ($old_advs < 2){
			$next_cell_time = strtotime("+25 seconds");//25-55
		}
		
		//if we are in a sim rember each row is 1 min in a snapshot
		}else{
			$next_cell_time = strtotime("+0 seconds");
			
			
		}
		//momentum
		
		
		
		
		
		
//LIVE time spaceing since we dont want this to hop on just any riseing number 
if ($time_now > $last){
	
	file_put_contents($file, $next_cell_time);
	
	$run_me="N";
}else{
	
	$run_me="O";

	//return false;
	}
	//make file if no file is found
	if ((file_exists (  $file ))== FALSE){
		
		fopen($file, "w");
	}
	
	else{
		
		if ($run_me == "N"){//echo "HEAP";print_r($Memory_3);sleep('100'); 
	if ($Memory_3 > 0.05) {	//CHECK VALS
	//set price memmory 
				$LPI_A = $_SESSION[($Memory_9[1])]['LPI'][1]["LAST_PRICE"];
				$LPI_B = $_SESSION[($Memory_9[1])]['LPI'][2]["LAST_PRICE"];
				$LPI_C = $_SESSION[($Memory_9[1])]['LPI'][3]["LAST_PRICE"];
				if ($LPI_A <0.01){
				$_SESSION[($Memory_9[1])]['LPI'][1]["LAST_PRICE"] = $Memory_3 ;
				}
				if (isset($LPI_A) && $LPI_A >0.01){
	            $_SESSION[($Memory_9[1])]['LPI'][2]["LAST_PRICE"]= $Memory_3 ;
				}
				if (isset($LPI_B)&&   $LPI_B >0.01){
	            $_SESSION[($Memory_9[1])]['LPI'][3]["LAST_PRICE"]= $Memory_3 ;
				}
			
	//find and set LPI
	//Last Price indicator 
	$LPI_A = $_SESSION[($Memory_9[1])]['LPI'][1]["LAST_PRICE"];
	$LPI_B = $_SESSION[($Memory_9[1])]['LPI'][2]["LAST_PRICE"];
	$LPI_C = $_SESSION[($Memory_9[1])]['LPI'][3]["LAST_PRICE"];
	$SPW	= $_SESSION[($Memory_9[1])]['SYSTEM']['ACTION']['SPW'];
	
	$calls_count = $_SESSION[($Memory_9[1])]['SYSTEM']['ACTION']['CALLS_SPW'];
	
	$DIP_PRICE = $_SESSION[($Memory_9[1])]['SYSTEM']['ACTION']['DIP_PRICE_SPW'];
	
	
		//SET STOCKS WITH a LEVEL OF LPI 2 set TO a CW TYPE  
		if ($LPI_B > 0.05  ){
			$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		$bsql = "UPDATE `day_trades` SET `TYPE` = 'CW' WHERE id = ".$Memory_9[0]."";
							if (mysqli_query($sub_conn, $bsql)) {
						echo "\n\n Stock ". $Memory_9[2]." ".$Memory_9[1]." setting CW  \n";
						} else {
						echo "Error: " . $bsql . "<br>" . mysqli_error($conn);
					}
					usleep(1000);
					mysqli_close($sub_conn);usleep(60);
		
		
		}//set filter after 10- 18 mins
		IF ($LPI_C >= $LPI_B && $LPI_B > 0.05){
			$BUY_IT = "Y";
			
			//set price watch
			$_SESSION[($Memory_9[1])]['SYSTEM']['ACTION']['SPW'] = "Y";
		}
		
		if ($SPW == "Y"){
			

			if (!isset($DIP_PRICE)){$_SESSION[($Memory_9[1])]['SYSTEM']['ACTION']['DIP_PRICE_SPW'] = $Memory_3;}
			
			//look for price dip 
			if ($LPI_C > $Memory_3  && $Memory_3 < $DIP_PRICE){
				
				if ($calls_count < 30){//count calls
				
				$_SESSION[($Memory_9[1])]['SYSTEM']['ACTION']['CALLS_SPW'] = ($calls_count +1);
				}
				
				$BUY_IT = "N";
			}
			
			//buy after dip
			if ( $Memory_3 < $DIP_PRICE ){$_SESSION[($Memory_9[1])]['SYSTEM']['ACTION']['DIP_PRICE_SPW'] = $Memory_3;}
			
			if ( $Memory_3 > $DIP_PRICE && $calls_count > 5){$BUY_IT = "Y";}
		}
		else{
			
			$BUY_IT = "N";
		}
		
			
	if($BUY_IT == "Y"){
		
		//BUY IT
		$_SESSION[($Memory_9[1])]['SYSTEM']['ACTION']['CTQ'] = "Y";
		
	}
	else{
		//DONT BUY IT
	$_SESSION[($Memory_9[1])]['SYSTEM']['ACTION']['CTQ'] = "N";
	}
		
		
		
		
		
		
		
		
		
		
		
	}
	}
	//
	}
	
	
	
	
	
	
	
	
	
		$OLD_h  = $_SESSION[$CELL][$TAG]["h"]; //high
		$OLD_l  = $_SESSION[$CELL][$TAG]["l"]; //low
	
		$OLD_Org_Price  = $_SESSION[$CELL][$TAG]["PRICE"];
		$OLD_BUY_PRICE  = $_SESSION[$CELL][$TAG]["BUY_PRICE"];
		$OLD_LAST_PRICE = $_SESSION[$CELL][$TAG]["LAST_PRICE"];
	$OLD_NEURON_time  = $_SESSION[$CELL][$TAG]["TIME"];
	$OLD_NEURON_array = $_SESSION[$CELL][$TAG];
	
	//$new_NEURON = $_SESSION[$cell][$TAG];
	
	

	
	
	$Memory_9[1];

	
	
	
	
	
	
	if($recall== TRUE){
		//set neuron array
		$_SESSION[$CELL][$TAG]	=	$new_NEURON;
		
		
		//collect high low
		 $_SESSION[$CELL][$TAG]["h"]	=	$new_NEURON;
		 $_SESSION[$CELL][$TAG]["l"]	=	$new_NEURON;
		
		
		  
		  $_SESSION[$CELL][$TAG]["$time"]	=	$new_NEURON;
		  
	}	  
		  
		  if ($post_ai == "true"){
		$key_secret = "C:/php/www/Stock_Market/API/api.KEY"; // I was running the code on localhost, and hence the path!
		$api_key = file_get_contents($key_secret);
		$url = "http://127.0.0.1/Stock_Market/ML/";
		$cookie = "C:/php/www/Stock_Market/API/AI.COOKIE"; // I was running the code on localhost, and hence the path!
		$fields_string = '';
		$user = $api_key ;
		$pass = $api_secret;
		$submit = "AI"; //

		$array_a = json_encode($samples);
		$array_b = json_encode($targets);
		
		
		
		$fields = array(
		'API'=>urlencode($api_key),
		'id'=>urlencode($pass),
		'array_a'=>urlencode($array_a),
		'array_b'=>urlencode($array_b),
		'predict'=>urlencode("65-6-5"),
		'USE'=>urlencode($submit)
        );
		
		//url-ify the data for the POST
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string,'&');
		
		$ch = curl_init ($url);
		curl_setopt($ch,CURLOPT_ENCODING , "gzip");
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
	// Decode the response.
		ob_start();
		//execute post
		$result = (curl_exec($ch));
		$out1 = ob_get_contents();
		ob_end_clean();
		curl_close($ch);
		$dec_result = json_decode($result);
	print_r($dec_result);die();
	}
		  
		  
	//end of function
}



//ai down trend 

FUNCTION AI_DT (
$CELL		= null,		// the cell id 
$TAG		= null,		// a tag for the cell to look it up by 
$Memory_1	= null,	// The Price First Seen
$Memory_2	= null,	// The Price Expected To Buy At
$Memory_3	= null,	// Last Recalled Price 
$Memory_4	= null,	// TIME
$Memory_5	= null,	// GAIN
$Memory_6	= null,	// market index adv
$Memory_7	= null,	// loss of a stock 
$Memory_8	= null,	// time divergence
$Memory_9	= null,	// SQL trade DATA
$Memory_10	= null,	// quantitative trade
$LAST_MIN	= null,	// null
$Model		= null, // buying / selling 
$sim        = null
){
		$servername         = "127.0.0.1";
		$username           = "root";
		$dbname             = "stock_market_local";
		$password           = "";
			
$samples = [[60-6-5], [61-6-5], [62-6-5], [63-6-5], [64-6-5]];
$targets = [1.10, 0.95, 1.22, 1.20, 1.19];
	
	
	
	
	
	
	
	$file  = "C:/php/www/Stock_Market/API/temp/ai.SELL.$CELL.thought"; // I was running the code on localhost, and hence the path!
	$time_now= time();


		$last 			= file_get_contents($file);	
		//100/s 3 c     = 5mins
		//333/s 3 calls = 16 min
		//every 400/s = 8 mins update the data in the cell
		
					$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
			$mqmquery = "SELECT * FROM `advs` LIMIT 1";
			if ($aresult=mysqli_query($sub_conn,$mqmquery)){ 
				// Fetch one and one row
				while ($get_advsnum=mysqli_fetch_row($aresult))
				{
					$old_advs      = $get_advsnum[0];
					$old_day      = $get_advsnum[2];
					$old_a      = $get_advsnum[3];
				}}
				mysqli_close($sub_conn);usleep(200);
				
				
		//wait time 8 min intval
		//225-600
		//60-120?  80 10/3/16 - ALPHA
		//5-15
		if($sim["mode"]<>"live"){
			
			//the time the program has to think about the price changeing when it buys 
			if ($old_advs > 4){
		$next_cell_time = strtotime("+19 seconds");//190-220
			}else {
				$next_cell_time = strtotime("+15 seconds");//150-200
				
			}
		
		if ($old_advs < 3){
			$next_cell_time = strtotime("+5 seconds");//50-110
		}
		if ($old_advs < 2){
			$next_cell_time = strtotime("+2 seconds");//25-55
		}
		
		//if we are in a sim rember each row is 1 min in a snapshot
		}else{
			$next_cell_time = strtotime("+0 seconds");
			
			
		}
		//momentum
		
		
		
		
		
		
//LIVE time spaceing since we dont want this to hop on just any riseing number 
if ($time_now > $last){
	
	file_put_contents($file, $next_cell_time);
	
	$run_me="N";
}else{
	
	$run_me="O";

	//return false;
	}
	//make file if no file is found
	if ((file_exists (  $file ))== FALSE){
		
		fopen($file, "w");
	}
	
	else{
		
		if ($run_me == "N"){//echo "HEAP";print_r($Memory_3);sleep('100'); 
	if ($Memory_3 > 0.05) {	//CHECK VALS
	//set price memmory 
				$LPI_A = $_SESSION[($Memory_9[1])]['DTI'][1]["LAST_PRICE"];
				$LPI_B = $_SESSION[($Memory_9[1])]['DTI'][2]["LAST_PRICE"];
				$LPI_C = $_SESSION[($Memory_9[1])]['DTI'][3]["LAST_PRICE"];
				if ($LPI_A <0.01){
				$_SESSION[($Memory_9[1])]['DTI'][1]["LAST_PRICE"] = $Memory_3 ;
				}
				if (isset($LPI_A) && $LPI_A >0.01){
	            $_SESSION[($Memory_9[1])]['DTI'][2]["LAST_PRICE"]= $Memory_3 ;
				}
				if (isset($LPI_B)&&   $LPI_B >0.01){
	            $_SESSION[($Memory_9[1])]['DTI'][3]["LAST_PRICE"]= $Memory_3 ;
				}
			
	//find and set LPI
	//Last Price indicator 
	$LPI_A = $_SESSION[($Memory_9[1])]['DTI'][1]["LAST_PRICE"];
	$LPI_B = $_SESSION[($Memory_9[1])]['DTI'][2]["LAST_PRICE"];
	$LPI_C = $_SESSION[($Memory_9[1])]['DTI'][3]["LAST_PRICE"];
		
		//SET STOCKS WITH a LEVEL OF LPI 2 set TO a CW TYPE  
		if ($LPI_B > 0.05  ){

		
		
		}
		//set filter 
		IF ($LPI_C <= $LPI_B && $LPI_B > 0.05){
			$SELL_IT = "Y";
			
			
		}
		
		
			
	if($SELL_IT == "Y"){
		
		//sell IT
		$_SESSION[($Memory_9[1])]['SYSTEM']['ACTION']['DTI'] = "Y";
		
	}
	else{
		//DONT sell IT
	$_SESSION[($Memory_9[1])]['SYSTEM']['ACTION']['DTI'] = "N";
	}
		
		
		
		
		
		
		
		
		
		
		
	}
	}
	//
	}
	
	
	
	
	
	
	
	
	
		$OLD_h  = $_SESSION[$CELL][$TAG]["h"]; //high
		$OLD_l  = $_SESSION[$CELL][$TAG]["l"]; //low
	
		$OLD_Org_Price  = $_SESSION[$CELL][$TAG]["PRICE"];
		$OLD_BUY_PRICE  = $_SESSION[$CELL][$TAG]["BUY_PRICE"];
		$OLD_LAST_PRICE = $_SESSION[$CELL][$TAG]["LAST_PRICE"];
	$OLD_NEURON_time  = $_SESSION[$CELL][$TAG]["TIME"];
	$OLD_NEURON_array = $_SESSION[$CELL][$TAG];
	
	//$new_NEURON = $_SESSION[$cell][$TAG];
	
	

	
	
	$Memory_9[1];

	
	
	
	
	
	
	if($recall== TRUE){
		//set neuron array
		$_SESSION[$CELL][$TAG]	=	$new_NEURON;
		
		
		//collect high low
		 $_SESSION[$CELL][$TAG]["h"]	=	$new_NEURON;
		 $_SESSION[$CELL][$TAG]["l"]	=	$new_NEURON;
		
		
		  
		  $_SESSION[$CELL][$TAG]["$time"]	=	$new_NEURON;
		  
	}	  
		  
		  if ($post_ai == "true"){
		$key_secret = "C:/php/www/Stock_Market/API/api.KEY"; // I was running the code on localhost, and hence the path!
		$api_key = file_get_contents($key_secret);
		$url = "http://127.0.0.1/Stock_Market/ML/";
		$cookie = "C:/php/www/Stock_Market/API/AI.COOKIE"; // I was running the code on localhost, and hence the path!
		$fields_string = '';
		$user = $api_key ;
		$pass = $api_secret;
		$submit = "AI"; //

		$array_a = json_encode($samples);
		$array_b = json_encode($targets);
		
		
		
		$fields = array(
		'API'=>urlencode($api_key),
		'id'=>urlencode($pass),
		'array_a'=>urlencode($array_a),
		'array_b'=>urlencode($array_b),
		'predict'=>urlencode("65-6-5"),
		'USE'=>urlencode($submit)
        );
		
		//url-ify the data for the POST
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string,'&');
		
		$ch = curl_init ($url);
		curl_setopt($ch,CURLOPT_ENCODING , "gzip");
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
	// Decode the response.
		ob_start();
		//execute post
		$result = (curl_exec($ch));
		$out1 = ob_get_contents();
		ob_end_clean();
		curl_close($ch);
		$dec_result = json_decode($result);
	print_r($dec_result);die();
	}
		  
		  
	//end of function
}