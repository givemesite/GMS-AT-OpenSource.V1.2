<?php
/*

seo investing api

this collects some data from the internet
*/
//the time limit the scriop has to run
set_time_limit ( 300000000000000000000000000000000 );

function investing_symb_lookup($id, $aDataTableDetailHTML, $comp_name){
	//let the server rest for some time before sending a new request 
	usleep(400); //27-90 500



//////////////
//ofset for stock symb

$url = "https://www.investing.com".$aDataTableDetailHTML;
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  //  'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36'
  'User-Agent: bot'
    ));
$html = curl_exec($ch);
curl_close($ch);




# Create a DOM parser object
$dom = new DOMDocument();
libxml_use_internal_errors(true);
//print_r($html);




$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
$c=1;

	$Header = $dom->getElementsByTagName('h1');
	//$Detail = $dom->getElementsByTagName('td');
	$aDetail = $dom->getElementsByTagName('title');
	
//print_r($Header);
    //#Get header name of the table
	foreach($Header as $NodeHeader) 
	{
		$aDataTableHeaderHTML[] = trim($NodeHeader->textContent);
	}
	//print_r($aDataTableHeaderHTML);// die();
    //echo $aDataTableHeaderHTML[7];
	//#Get row data/detail table without header name as key
	$i = 0;
	$j = 0;
	foreach($aDetail as $NodeDetail) 
	{
	//echo $NodeDetail->nodeValue;
	//echo $NodeDetail->getAttribute('href'), '<br>';
	//	print_r($NodeDetail);
 $ticker_symb= trim($NodeDetail->textContent);
	//	$i = $i + 1;
	//	$j = $i % count($aDataTableHeaderHTML) == 0 ? $j + 1 : $j;
	}
	$symb = explode(' |',$ticker_symb);
	$rsymb = $symb[0];
	//return$rsymb;
	//print_r($symb);
	//clean the title 
	
	
	//look for a match in the company name 
	foreach($aDataTableHeaderHTML as $array_pice){
	
	
	$compare_comp_name = htmlentities(  substr($array_pice, 0, 3));
	//remove any spaces in the name that may be found
$compare_comp_name = str_replace(" ", "", $compare_comp_name);

	
//count only the first 1
	$ocomp_name = htmlentities(substr($comp_name, 0, 3));
	echo "\n";
	//echo $array_pice;		
	//echo $compare_comp_name;
	//echo $ocomp_name;  
		//sleep(300);
	    //	print_r($compare_comp_name);
	//print_r($rsymb);
		
		
	if ($ocomp_name == $compare_comp_name) {
	
		return $rsymb. "";//continue;
		}else{
		//	return"0" ;
			
		} 
	 
}

}
