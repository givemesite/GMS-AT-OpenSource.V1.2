<?php
//kris galante krisgcell@gmail.com
$id 			= $_POST['id'];
$array_a		= $_POST['array_a'];
$array_b 		= $_POST['array_b'];
$key 			= $_POST["API"];
$predict 		= $_POST["predict"];
	$key_secret = "C:/php/www/Stock_Market/API/api.KEY"; // I was running the code on localhost, and hence the path!
	$api_key	= file_get_contents($key_secret);
if ("$key" <> "$api_key"){
	DIE('BAD POST KEY!');
}
require_once __DIR__ . '/vendor/autoload.php';
use Phpml\Regression\LeastSquares;
$samples = json_decode($array_a);
$targets = json_decode($array_b);
$regression = new LeastSquares();
$regression->train($samples, $targets);
$arr = array($regression->predict(["$predict"]));
$o= json_encode    ($arr);
echo($o);