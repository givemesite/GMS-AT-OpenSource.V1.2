<?php
/*

seo stock index
	Trending stocks
	Fastest growing stocks
	Most volatility Good
	most volatility bad

*/

function GetStockSymb ($company_name){
	
$q = str_replace(" ","+",$company_name);
if ($q == "" || $q == null){
	$q ="hewlett+packard";
}
$url = "https://www.google.com/search?&q=" . $q ."&oq=" . $q;
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

$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
$c=1;

	$Header = $dom->getElementsByTagName('div');
	$Detail = $dom->getElementsByTagName('span');

    //#Get header name of the table
	foreach($Header as $NodeHeader) 
	{
		$aDataTableHeaderHTML[] = trim($NodeHeader->textContent);
	}
	//print_r($aDataTableHeaderHTML); die();

	//#Get row data/detail table without header name as key
	$i = 0;
	$j = 0;
	foreach($Detail as $sNodeDetail) 
	{
		$aDataTableDetailHTML[$j][] = trim($sNodeDetail->textContent);
		$i = $i + 1;
		$j = $i % count($aDataTableHeaderHTML) == 0 ? $j + 1 : $j;
	}
	$stock_ticker = null;
	$stock_symb   = null;
for ($x = 0; $x <= 500;$x++) {	
	//$aDataTableDetailHTML[$x];
//	echo $aDataTableDetailHTML[0][$x];
	if ($aDataTableDetailHTML[0][$x] == "Stock price:"){
		$stock_ticker= 	$aDataTableDetailHTML[0][$x+1];
		//	echo$stock_symb;
	}
	
}
//print_r($aDataTableDetailHTML); die();
	$stock_symb = explode (' ', $stock_ticker);
	return $stock_symb[0];
}

function getHTMLByID($id, $html) {
    $dom = new DOMDocument;
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $node = $dom->getElementById($id);
    if ($node) {
        return $dom->saveXML($node);
    }
    return FALSE;
}


//jason responce

$url = "https://www.investing.com/equities/top-stock-gainers";
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
	$Detail = $dom->getElementsByTagName('td');

    //#Get header name of the table
	foreach($Header as $NodeHeader) 
	{
		$aDataTableHeaderHTML[] = trim($NodeHeader->textContent);
	}
	//print_r($aDataTableHeaderHTML); die();

	//#Get row data/detail table without header name as key
	$i = 0;
	$j = 0;
	foreach($Detail as $sNodeDetail) 
	{
		$aDataTableDetailHTML[$j][] = trim($sNodeDetail->textContent);
		$i = $i + 1;
		$j = $i % count($aDataTableHeaderHTML) == 0 ? $j + 1 : $j;
	}
	$stock_mux = array_values(array_filter(array_slice($aDataTableDetailHTML,0,18)));
    //$mux     = array_values(array_filter(array_slice($aDataTableDetailHTML,0,19)));
	//$stock_mux[][];
	
//1	


	
	

//echo $dom->getElementsByTagName('table') ->find('table[class=friendsComments] td a');
//echo $dom->getElementsByTagName('table') -> item(28)-> nodeValue;
# Iterate over all the <a> tags
$finder = new DomXPath($dom);
//$node = $finder->query("//*[contains(@class, 'text')]");
$node = $finder->query("//*[contains(@class, 'div')]");
$comments = $finder->query("//*[contains(@class, 'friendsComments')]");
//$node = $finder->query("//*[contains(@class, 'word-wrap')]");
$table = $dom->saveHTML($dom->getElementsByTagName('table') ->item(2)); //myspace user
//$con_mb .= $dom->saveHTML($dom->getElementsByTagName('table') ->item(17)); //myspace user
//$con_mb .= $dom->saveHTML($dom->getElementsByTagName('table') ->item(20)); //myspace url user
//$con_mb .= $dom->saveHTML($dom->getElementsByTagName('table') ->item(22)); //myspace url music
//$con_mb .= $dom->saveHTML($dom->getElementsByTagName('table') ->item(24)); //myspace info
//$con_mb .= $dom->saveHTML($comments->item(0)); //Friends comments
//print_r(mb_convert_encoding($con_mb,'HTML-ENTITIES', 'UTF-8'));
print_r($table);

foreach($dom->getElementsByTagName('table') as $link) {
        # Show the <a href>
		//if ($c==11){print_r($link);}

        //echo "<br />";
		$c++;
}
echo <<<EDO

EDO;
