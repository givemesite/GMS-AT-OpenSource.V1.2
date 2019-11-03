<?php
/*

seo investing api

this collects some data from the INTERNET
*/


function long_frequency_over_time($comp_name, $daily ,$oneweek , $onemo , $ytd, $tytd){
	


//return $stock_rate;	
$servername         = "127.0.0.1";
$username           = "root";
$password           = "";
$dbname             = "stock_market_local";
//quantitative analytics
$quant_price        = 0;
$quant_price_change = 0;
$quant_vol          = 0;
$quant_change       = 0;
//mysql data driver
$daily   	= str_replace("%","",$daily);
$oneweek	= str_replace("%","",$oneweek);
$onemo		= str_replace("%","",$onemo);
$ytd		= str_replace("%","",$ytd);
$tytd		= str_replace("%","",$tytd);
				$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
			//print_r($row);
$sql = "UPDATE `stock` SET ytd_day = '$daily', ytd_one_week = '$oneweek', ytd_one_mo = '$onemo', ytd = '$ytd', three_ytd = '$tytd'"." WHERE CONVERT(`name` USING utf8mb4) = '".$comp_name."'";
					//	$sql = "UPDATE `day_trades` SET `frequency` = '".$stock_rate."' WHERE CONVERT(`name` USING utf8mb4) = '".$comp_name."'";
if (mysqli_query($conn, $sql)) {
 //   echo "\n\n \033[32mUpdateing dataset percentags \033[0m \n";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);

}

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

FUNCTION to_array($aDataTableDetailHTML){
	//some offsets
$investing_table_count = 5;
$next_table = 5;
$item_head_count= 1;
$Next_head = 5;
$url_offset= 0;
//loop to construct data
while ($investing_table_count <= 502 ){ //502 html items

//count items in array for uri function
			if ($item_head_count == $Next_head){
	//
	$Next_head = 0;
	$Next_head .=  $investing_table_count - 9;
	
		}	
		
	$A_Ticker_investing_table_count= 0;	
	
	//count used for table items
	if ($investing_table_count == $next_table){

		
	//
	$last_table = $investing_table_count;
	//
	$next_table =  $investing_table_count + 8;
	
	
	//table items
	$A_investing_table_count = $investing_table_count + 0; //name
	$B_investing_table_count = $investing_table_count + 1; //price now
	$C_investing_table_count = $investing_table_count + 2; //high
	$D_investing_table_count = $investing_table_count + 3; //low
	$E_investing_table_count = $investing_table_count + 4; //change
	$F_investing_table_count = $investing_table_count + 5; //change%
	$G_investing_table_count = $investing_table_count + 6; //VOL
	$H_investing_table_count = $investing_table_count + 7; //time/date
	
	


	////////////
	//Row data 
	//
	////////////
	// $aDataTableDetailHTML[0][-1]['seo_data'][449];
	//echo "\n";
	//echo $aDataTableDetailHTML[0][$A_investing_table_count];echo "\n";
	//echo $aDataTableDetailHTML[0][$B_investing_table_count];echo "\n";
	//echo $aDataTableDetailHTML[0][$C_investing_table_count];echo "\n";
	//echo $aDataTableDetailHTML[0][$D_investing_table_count];echo "\n";
	//echo $aDataTableDetailHTML[0][$E_investing_table_count];echo "\n";
	//echo $aDataTableDetailHTML[0][$F_investing_table_count];echo "\n";
	//echo $aDataTableDetailHTML[0][$G_investing_table_count];echo "\n";
	//echo $aDataTableDetailHTML[0][$H_investing_table_count];echo "\n";
		
///
//some stuff to prevent empty data
///

if ($aDataTableDetailHTML[0][$A_investing_table_count] == "" || !isset($aDataTableDetailHTML[0][$A_investing_table_count])){
continue;	
}
//echo $aDataTableDetailHTML;
	$A_Ticker_investing_table_count = $url_offset  + 449;//448
//echo "\n";
	 //ticker symb
//	echo   investing_symb_lookup("",$aDataTableDetailHTML[0][3]['seo_data'][$A_Ticker_investing_table_count]);
	// echo "\n";
	//echo$aDataTableDetailHTML[0][3]['seo_data'][$A_Ticker_investing_table_count]; echo "\n";
		//an offset used for uri data
		$url_offset++;
		
                $ticker_name   = '';
				  $comp_name   = $aDataTableDetailHTML[0][$A_investing_table_count];
				  $daily      = $aDataTableDetailHTML[0][$B_investing_table_count];
				   $oneweek      = $aDataTableDetailHTML[0][$C_investing_table_count];
				    $onemo    = $aDataTableDetailHTML[0][$D_investing_table_count];
				 $ytd      = $aDataTableDetailHTML[0][$E_investing_table_count];
				 $tytd      = $aDataTableDetailHTML[0][$F_investing_table_count];
				 $DATE_ADDED   = time();
					   $TIME   = time();
					   //	 echo "\n";
					  // echo   $comp_name;
					  //    echo "\n";
					  // echo $daily;
					  //    echo "\n";
					 //  echo $oneweek;
					  //    echo "\n";
					  // echo $onemo;
					 //     echo "\n";
					 //  echo $ytd;
					 //     echo "\n";
				     //  echo $tytd;
					  //    echo "\n";
long_frequency_over_time($comp_name, $daily ,$oneweek , $onemo , $ytd, $tytd);
					   
					   
			//print_r($aDataTableDetailHTML[0]);		   
///////////////////////////////////////////////////
///////////////////////////////////////////////////
///////////////////////////////////////////////////
//
//
//
//Strong Buy
//Buy
//Neutral
//Sell
//Strong Sell
///////////////////////////////////////////////////
///////////////////////////////////////////////////
///////////////////////////////////////////////////					   
//set_stock_index($conn, $url_offset,//SQL ID
//                $ticker_name,
//				  $comp_name,
//				  $price_now, 
//				   $day_high,
//				    $day_low,
//				 $CHANGE_PCT,
//			   $CHANGE_RATIO,
//				 $CHANGE_VOL,
//					  $TIME,
//					  $aDataTableDetailHTML,
//					  $investing_table_count
//					  );		
		
	}
		if ($A_investing_table_count == $investing_table_count){
		//this is first row
		
	}
	
	$investing_table_count++;
	//$stock_table_bread_crumb= $investing_table_count +2;


//end of loop 
}//die();


}









function RUN_INVESTING_helper_long (){

usleep(500);
//jason responce

$url = "https://www.investing.com/equities/Service/PerformanceTopGainers?pairid=5&sid=26063e384bb5e6847ee6d48315541ff7&filterParams=&smlID=810";

$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'User-Agent: its-a-bot',
	 'Content-Type: application/json',
	  'X-Requested-With: XMLHttpRequest'
    ));
$html = curl_exec($ch);
curl_close($ch);

usleep(40);//500


# Create a DOM parser object
$dom = new DOMDocument();
libxml_use_internal_errors(true);
//print_r($html);


$dom->loadHTML($html);
$c=1;

	$Header = $dom->getElementsByTagName('th');
	$Detail = $dom->getElementsByTagName('td');
	$aDetail = $dom->getElementsByTagName('a');
	
//print_r($Detail);
    //#Get header name of the table
	foreach($Header as $NodeHeader) 
	{
		$aDataTableHeaderHTML[] = trim($NodeHeader->textContent);
	}
	//print_r($aDataTableHeaderHTML); die();

	//#Get row data/detail table without header name as key
	$i = 0;
	$j = 0;
	foreach($aDetail as $NodeDetail) 
	{
			//echo $NodeDetail->nodeValue;
		//echo $NodeDetail->getAttribute('href'), '<br>';
		//print_r($sNodeDetail);
		$aDataTableDetailHTML[$j][3]['seo_data'][] = $NodeDetail->getAttribute('href');
	//	$i = $i + 1;
	//	$j = $i % count($aDataTableHeaderHTML) == 0 ? $j + 1 : $j;
	}
	foreach($Detail as $sNodeDetail) 
	{
		if ($j==1 ){
			$aDataTableDetailHTML[$j][2] = '';
		}
		
		//	echo $sNodeDetail->nodeValue;
		//	echo $sNodeDetail->getAttribute('href'), '<br>';
		//print_r($sNodeDetail);
		$aDataTableDetailHTML[$j][] = trim($sNodeDetail->textContent);
		$i = $i + 1;
		//$j = $i % count($aDataTableHeaderHTML) == 0 ? $j + 1 : $j;
	}
	$stock_mux = array_values(array_filter(array_slice($aDataTableDetailHTML,0,18)));
    //$mux     = array_values(array_filter(array_slice($aDataTableDetailHTML,0,19)));
	//$stock_mux[][];
	
	to_array($aDataTableDetailHTML);
	
	
//print_r($aDataTableDetailHTML); //die();
											//-498
//echo $aDataTableDetailHTML[0][-1]['seo_data'][449];




}
