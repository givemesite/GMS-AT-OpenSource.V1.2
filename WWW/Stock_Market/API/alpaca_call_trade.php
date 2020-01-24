<?php
//kris galante krisgcell@gmail.com
//include('c:/php/WWW/Stock_Market/config.php');


 ini_set('display_errors', '1');
 
 ini_set('log_errors', '0');
 
require './vendor/autoload.php';
 
require './src/Alpaca.php';
require './src/Response.php';
use Alpaca\Alpaca;
 

		$key_file = "C:/php/www/Stock_Market/API/alpaca.KEY"; // I was running the code on localhost, and hence the path!
		$key_secret = "C:/php/www/Stock_Market/API/alpaca.SECRET"; // I was running the code on localhost, and hence the path!
	$api_key = file_get_contents($key_file);
	$api_secret = file_get_contents($key_secret);
	
											//Paper trading
$alpaca = new Alpaca($api_key, $api_secret,   false);

 $Trading_name = $_POST['Trading_name'];
 $symbol       = $_POST['symbol'];
 $dirty_price  = $_POST['price'];
 $ORDER_TYPE   = $_POST['ORDER_TYPE'];
 $quantity     = $_POST['quantity'];

	$get_action = $_GET['action'];

if ($dirty_price < 1) {
$price =	round($dirty_price,4, PHP_ROUND_HALF_UP);
	
}else {
$price =	round($dirty_price,2, PHP_ROUND_HALF_UP);
}
$resp = $alpaca->getAccount();

	

//if we are buying a stock

$test    = json_encode(($alpaca ->getPosition($symbol)->getResponse()));

//$account = json_encode(($alpaca ->getAccount()->getResponse()));

echo $test;