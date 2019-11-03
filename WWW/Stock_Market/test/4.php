<?php
include('c:/php/WWW/Stock_Market/config.php');
//include("$SERVER_DIR/LOOP/logic_functions.php");
include("$SERVER_DIR/LOOP/all_starts_here.php");


//include("$SERVER_DIR/LOOP/all_starts_here.php");

$servername         = "127.0.0.1";
$username           = "root";
$dbname             = "stock_market_local";
$password           = "";
$bsub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);

		$aquery = "SELECT * FROM `day_trades` WHERE `OCG` = '0' LIMIT 50";
	if ($aresult=mysqli_query($bsub_conn,$aquery)){

	while ($rawquantitative_trade=mysqli_fetch_row($aresult))
		{$quantitative_trade = $rawquantitative_trade;
		
$PREsub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);

		$bquery = "SELECT * FROM `stock` WHERE `trading_name` = '".$quantitative_trade[1]."' LIMIT 1 ";
	if ($bresult=mysqli_query($PREsub_conn,$bquery)){ 

	while ($rawa=mysqli_fetch_row($bresult))
		{$a = $rawa;

	}}

	mysqli_close($PREsub_conn);
	$PREsub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
				$cquery = "UPDATE `day_trades` SET `OCG` = '000000".$a[8]."' WHERE `id` = '".$quantitative_trade[0]."'";
		if ($cresult=mysqli_query($PREsub_conn,$cquery)){ 
print_r($quantitative_trade);
}usleep(200);
		mysqli_close($PREsub_conn);

	}}	mysqli_close($bsub_conn);