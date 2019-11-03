<?php
function seo_get_inv_name($url){
$url = "https://www.investing.com" . $url;
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
//echo $dom->getElementsByTagName('table') ->find('table[class=friendsComments] td a');
//echo $dom->getElementsByTagName('table') -> item(28)-> nodeValue;
# Iterate over all the <a> tags
$finder = new DomXPath($dom);
//$node = $finder->query("//*[contains(@class, 'text')]");
$node = $finder->query("//*[contains(@class, 'div')]");
$comments = $finder->query("//*[contains(@class, 'friendsComments')]");

//print_r($node);

//print $html;


$doc = new DOMDocument;
$doc->loadHTML($html);

$titles = $doc->getElementsByTagName('h1');
if( !is_null($titles->item(0)) ){
	preg_match_all("/\\((.*?)\\)/", $titles->item(0)->nodeValue, $matches); 
return $matches[1][0]; //trade name 
  
}
//hold up
usleep(3000000);
}
