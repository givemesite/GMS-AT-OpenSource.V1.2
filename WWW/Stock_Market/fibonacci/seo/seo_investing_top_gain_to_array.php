<?php


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

function seo_investing(){


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
//echo $dom->getElementsByTagName('table') ->find('table[class=friendsComments] td a');
//echo $dom->getElementsByTagName('table') -> item(28)-> nodeValue;
# Iterate over all the <a> tags
$finder = new DomXPath($dom);
//$node = $finder->query("//*[contains(@class, 'text')]");
$node = $finder->query("//*[contains(@class, 'div')]");
$comments = $finder->query("//*[contains(@class, 'friendsComments')]");

//print_r($node);

foreach($dom->getElementsByTagName('table') as $link) {
        # Show the <a href>
		//if ($c==11){print_r($link);}

        //echo "<br />";
		$c++;
}
echo <<<EDO

EDO;
$investing_export = array();
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($html);
libxml_clear_errors();

$xpath = new DOMXPath($dom);

$tr_no = 0;
foreach( $xpath->evaluate('//tr') as $sel ){
    $investing_export[$tr_no] = array();
    $td_no = 0;
    foreach( $sel->childNodes as $td ){
       if( strtolower( $td->tagName )  == 'td' ){
            $innerHTML = '';
            foreach ($td->childNodes as $child){
                $innerHTML .= $td->ownerDocument->saveHTML($child);
            }
            $investing_export[$tr_no][$td_no] = $innerHTML;
            $td_no++;
       }
    }
    $tr_no++;
}
return $investing_export;
}

