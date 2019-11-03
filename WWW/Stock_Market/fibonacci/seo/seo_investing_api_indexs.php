<?php
/*

seo  api 
investing

this collects some data from the INTERNET
*/



///////////////////////////////////////////////////
///////////////////////////////////////////////////
///////////////////////////////////////////////////
//Function to turn curl data from html 
//(table & HREF) into an array
//
//
//
//
//
//
///////////////////////////////////////////////////
///////////////////////////////////////////////////
///////////////////////////////////////////////////

$index_adv = $_SESSION['INDEXS_ADV'];




function INDEXS_FOR_INVESTING (){

			

//usleep(1000);
//jason responce
//used for multi thread
$data_file = "C:/php/www/Stock_Market/API/index.data"; // I was running the code on localhost, and hence the path!
$file      = "C:/php/www/Stock_Market/API/index.TIME"; // I was running the code on localhost, and hence the path!
$key_file  = "C:/php/www/Stock_Market/API/alphavantage.KEY"; // I was running the code on localhost, and hence the path!
	$time_now= time();
$last = file_get_contents($file);	
$next_call_time = strtotime("+200 seconds");
if ($time_now > $last){
	file_put_contents($file, $next_call_time);
	
	$run_index=TRUE;
}else{
	
	$run_index=FALSE;

	//return false;
	}	
$api_key = file_get_contents($key_file);

//indexs into arrays

$index_array = array(
"1" => "INX",
"2" => "ES",
"3" => "DJI",
"4" => "NDX",
"5" => "RUT",
"6" => "VIX",
"7" => "UAX",
"8" => "DAX"
);

if ($run_index = TRUE){
$_SESSION['INDEXS_ADV']= 0;

			$the_hour       = date('g'); 
			$the_min        = date('i');
			$the_seconds    = date('s');
			$the_year       = date('Y');//year
			$the_mon        = date('m');//month
			$the_day        = date('d');
			//$the_day        = "29";
			//"29";//day
			$the_ap         = date('a');//am or pm
			$the_day_symbl  = date('D');
			$FREQ			= null;
			//echo $the_day ;
foreach ($index_array as $index_key => $index_symb){
$ch = curl_init();
curl_setopt($ch,
 CURLOPT_URL,
 ("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=".$index_symb."&interval=1min&apikey=".$api_key."&outputsize=compact"));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$server_output = curl_exec ($ch);
			curl_close ($ch);
				$result = json_decode($server_output);
				
			if (isset($result->{'Note'})){echo "\n".$result->{'Note'}."\n";}
			
				$glob = $result->{'Time Series (1min)'};
				$array_count = 0;
				$trend_glob = null;
				foreach ($glob as $date_stamp => $node_glob){
					//fix abnormal data 

						$time_date  = explode(" ", $date_stamp);
						$date_stamp = explode("-", $time_date[0] );
						$time_stamp = explode(":", $time_date[1]);
						//print_r($node_glob);
					if ($date_stamp[2]==$the_day ){
						if ($sim["sim"]==TRUE){
						if(isset($sim)){
							//make sure im only using data from the day i need listed in the dataset
					//	if ($date_stamp[2]<$the_day ){break;}
					}
					}
					if ($sim["sim"]==TRUE){
					if ($sim["slot"]==$array_count){
					$trend_glob = $node_glob;
					}
					//print_r($node_glob);
					if ($array_count >400){break;}
					}
					else
					{
			    	$trend_glob = $node_glob;
					//print_r($node_glob);
					if ($array_count >1){break;}
					}

					}else{break;}
				$array_count++;//1 for the most current and this data point only supports 100 for the day
				}

			$index_adv = $_SESSION['INDEXS_ADV'];
			
			
//get the last day close
$last_day_close   =  $trend_glob->{'4. close'};	
//now add the new price to that
$Test_index   =  $trend_glob->{'1. open'} - $last_day_close;
			$save_to_session = $Test_index + $index_adv;
			$_SESSION['INDEXS_ADV']= $save_to_session;
			
			$adv_data = $_SESSION['INDEXS_ADV'];
			file_put_contents($data_file, $adv_data);	
}

	
	
$adv_data = file_get_contents($data_file);
$_SESSION['INDEXS_ADV'] = $adv_data;
}
}
$adv_data = file_get_contents($data_file);
$_SESSION['INDEXS_ADV'] = $adv_data;

//echo INDEXS_FOR_INVESTING  () ;