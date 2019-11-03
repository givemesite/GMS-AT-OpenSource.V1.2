<?php
/*

seo investing api

this collects some data from the internet
*/

set_time_limit ( 30000000000000000000000000000000000000000000000000000000000000000000000000 );

function investing_symb_lookup($id, $aDataTableDetailHTML, $comp_name){
	
	usleep(3);





$sym_data = 449 + $id;
//echo $aDataTableDetailHTML[0][-1]['seo_data'][$sym_data];
$url = "https://www.investing.com".$aDataTableDetailHTML;
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36'
    ));
$html = curl_exec($ch);
curl_close($ch);




# Create a DOM parser object
$dom = new DOMDocument();
libxml_use_internal_errors(true);
//print_r($html);




$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
$c=1;

	$Header = $dom->getElementsByTagName('th');
	//$Detail = $dom->getElementsByTagName('td');
	$aDetail = $dom->getElementsByTagName('title');
	
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
 $ticker_symb= trim($NodeDetail->textContent);
	//	$i = $i + 1;
	//	$j = $i % count($aDataTableHeaderHTML) == 0 ? $j + 1 : $j;
	}
	
	$symb = explode(' |',$ticker_symb);
	$rsymb = $symb[0];
	//print_r($symb);
	
	//clean the title 
	$dcompare_comp_name = str_replace(" Stock - Investing.com", "" , $symb[1]); 
	//print_r($dcompare_comp_name);
	$ocomp_name = htmlentities(substr($comp_name, 0, 1));
	//count onle the first 7 
		$compare_comp_name = htmlentities(  substr($dcompare_comp_name, 1, 1));
		echo $compare_comp_name;
	//echo $ocomp_name;  
		//sleep(300);
	if ($ocomp_name == $compare_comp_name) {
		if ($compare_symb <> false) {}
		return $rsymb. "";
		} else {return "NANANA";}
	 
	

}
echo investing_symb_lookup('',"/equities/wsi-industries-inc","WSI Industries Inc");