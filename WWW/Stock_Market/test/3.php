<?php

include('c:/php/WWW/Stock_Market/config.php');
//include("$SERVER_DIR/LOOP/logic_functions.php");
include("$SERVER_DIR/LOOP/all_starts_here.php");

set_time_limit ( 30000000000000000000000000 );

ini_set('memory_limit', '2048M');
ini_set('display_errors', '0');
ini_set('log_errors', '0');


//some stuff for mysql data base
$servername         = "127.0.0.1";
$username           = "root";
$dbname             = "stock_market_local";
$password           = "";




	
		
		//look at all the stock we are about to own or own - dont look at closing call trades
		$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		$query = "SELECT * FROM `day_trades` ORDER BY `id` DESC LIMIT 500";//lets see how the stocks we own are doing first
		//	$query = "SELECT * FROM `stock` DESC LIMIT 350";//lets see how the stocks we own are doing first

		$trade= null;
	if ($main_trade_loop=mysqli_query($conn,$query)){ 
	// Fetch one row
	while ($trade=mysqli_fetch_row($main_trade_loop))
		{
			$symbol = $trade[1];
						$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$server_output = curl_exec ($ch);
			curl_close ($ch);
				$result = json_decode($server_output);
		
	file_put_contents(("./snapshots/".$symbol.".json"),$server_output);


	
	}
	
	}