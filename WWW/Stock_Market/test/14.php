<?php
//this script was made to compare finviz to alphavantage callback times 
//to generate an avarge in microseconds that it will take to peform 
include('c:/php/WWW/Stock_Market/config.php');
//include("$SERVER_DIR/LOOP/logic_functions.php");
include("$SERVER_DIR/LOOP/all_starts_here.php");

function post_without_wait($url, $params)
{
    foreach ($params as $key => &$val) {
      if (is_array($val)) $val = implode(',', $val);
        $post_params[] = $key.'='.urlencode($val);
    }
    $post_string = implode('&', $post_params);

    $parts=parse_url($url);

    $fp = fsockopen($parts['host'],
        isset($parts['port'])?$parts['port']:80,
        $errno, $errstr, 30);

    $out = "POST ".$parts['path']." HTTP/1.1\r\n";
    $out.= "Host: ".$parts['host']."\r\n";
    $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
    $out.= "Content-Length: ".strlen($post_string)."\r\n";
    $out.= "Connection: Close\r\n\r\n";
    if (isset($post_string)) $out.= $post_string;

    fwrite($fp, $out);
    fclose($fp);
}



//echo  post_without_wait("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=ABC&interval=1min&apikey=".$api_key."&outputsize=compact", $params);



$start = microtime(true);
for ($s = 0 ; $s <= 10;$s++){
			

	$key_file = "C:/php/www/Stock_Market/API/alphavantage.KEY"; // I was running the code on localhost, and hence the path!
	
$api_key = file_get_contents($key_file);

$ch = curl_init();
curl_setopt($ch,
 CURLOPT_URL,
 //("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=ABC&interval=1min&apikey=".$api_key."&outputsize=compact"));
 ("https://www.investing.com/equities/Service/PriceTopGainers?pairid=5&sid=&filterParams=&smlID=0"));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch,CURLOPT_ENCODING , "gzip");
			curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
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
			//print_r($node_glob);


}

$time_elapsed_secs = microtime(true) - $start;
echo $time_elapsed_secs;
echo "\n";













function OLD_FINVIZ_LOGIN()
{
	$key_file = "C:/php/www/Stock_Market/API/finviz_user.DATA"; // I was running the code on localhost, and hence the path!
	$key_secret = "C:/php/www/Stock_Market/API/finviz_pass.DATA"; // I was running the code on localhost, and hence the path!
	$api_key = file_get_contents($key_file);
	$api_secret = file_get_contents($key_secret);
$url = "https://finviz.com/login_submit.ashx";
$cookie = "C:/php/www/Stock_Market/API/FINVIZ.COOKIE"; // I was running the code on localhost, and hence the path!
$fields_string = '';
$user = $api_key ;
$pass = $api_secret;
$submit = "login"; // this an actual code, I had used on one of the sites, but the password is fake!
$fields = array(
            'email'=>urlencode($user),
            'password'=>urlencode($pass),
            'form'=>urlencode($submit)
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
    $output = curl_exec ($ch);
	curl_close($ch);
}


$start = microtime(true);

for ($s = 0 ; $s <= 10;$s++){
$login_session= $_SESSION['finviz_login'] ;

if ($login_session=='yes'){}

else{FINVIZ_LOGIN();$_SESSION['finviz_login'] = 'yes';}




//usleep(40);
//jason responce

$url = "https://elite.finviz.com/export.ashx?v=111&t=ABC";
//$url = "https://elite.finviz.com/export.ashx?v=111&f=sh_price_u3,ta_change_u1,ta_highlow50d_a40h&ft=4&o=-change";
$cookie = "C:/php/www/Stock_Market/API/FINVIZ.COOKIE"; // I was running the code on localhost, and hence the path!
$ch = curl_init();
$timeout = 5;
curl_setopt($ch,CURLOPT_ENCODING , "gzip");
			curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie); 
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'User-Agent: a-bot',
//	 'Content-Type: application/json'
//	  'X-Requested-With: XMLHttpRequest'
    ));
$html = curl_exec($ch);
curl_close($ch);



$stream = fopen('data://text/plain;base64,' . base64_encode($html),'r');


$csv = fgetcsv  ( $stream,  "," , '"') ;

    while (($data = fgetcsv($stream, null, ",")) !== FALSE) {
        $num = count($data);

        $row++;
		//print_r($data);
	//	print_r($data);
//echo " \n ";
//echo $data[1]."\n";

                $ticker_name   = $data[1];
				  $comp_name   = str_replace(',',' ',str_replace('.',' ',$data[2]));
				  $price_now   = $data[8];
				   $day_high   = 0;
				    $day_low   = 0;
				 $CHANGE_PCT   = str_replace('%','',$data[8]);
			   $CHANGE_RATIO   = $data[9];
				 $CHANGE_VOL   = $data[10];
				 $DATE_ADDED   = time();
					   $TIME   = time();
//print_r($data);
        for ($c=0; $c < $num; $c++) {

		
		
    }

          //  echo $data[$c] . "<br />\n";
        }
		
		
	fclose ($stream );
}
$time_elapsed_secs = microtime(true) - $start;
echo $time_elapsed_secs;