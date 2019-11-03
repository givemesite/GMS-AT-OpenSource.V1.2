<?php
	/*
		
		seo  api 
		
		
		this collects some data from the INTERNET
	*/
	
	session_start();
	
	//include('c:/php/WWW/Stock_Market/config.php');
	///////////////////////////////////////////////////
	///////////////////////////////////////////////////
	///////////////////////////////////////////////////
	//Function to turn curl data from html 
	//(table & HREF) into an array
	//
	//
	//
	//
	//
	//
	///////////////////////////////////////////////////
	///////////////////////////////////////////////////
	///////////////////////////////////////////////////
	
	
	function FREQ_BACKTRACK($symb= null){
		
		
		
		//open
		$_SESSION['FREQ'][$symb]['OPEN'] = 0; 
		//high
		$_SESSION['FREQ'][$symb]['HIGH'] = 0; 
		//low
		$_SESSION['FREQ'][$symb]['LOW'] = 0; 
		//close
		$_SESSION['FREQ'][$symb]['CLOSE'] = 0; 
		//vol
		$_SESSION['FREQ'][$symb]['VOL'] = 0 ; 
		
		
		
		$ch = curl_init();
		
		
		$key_file = "C:/php/www/Stock_Market/API/alphavantage.KEY"; // I was running the code on localhost, and hence the path!
		
		$api_key = file_get_contents($key_file);
		curl_setopt($ch, CURLOPT_URL,("https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=".$symb."&apikey=".$api_key."&outputsize=full"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		$result = json_decode($server_output,false, 5120);
		//print_r($server_output);
		$recall = $server_output ;
		//  echo json_last_error_msg();
		if (isset($result->{'Note'})){echo "\n".$result->{'Note'}."\n";}
		$trend_glob  = null;
		$glob = $result->{'Time Series (Daily)'};
		$array_count = 0;
		$sub_array_count = count($glob);
		foreach ($glob as $node_key => $node_glob){
			$date_code = explode("-",$node_key );
			
			if (isset($date_code)){
				
				//print_r( $node_glob);
				
				//$_SESSION['FREQ'][$symb][] = $node_glob + $_SESSION['FREQ'][$symb][] ; 
				//open
				$_SESSION['FREQ'][$symb]['OPEN'] = $node_glob->{'1. open'} + $_SESSION['FREQ'][$symb]['OPEN'] ; 
				//high
				$_SESSION['FREQ'][$symb]['HIGH'] = $node_glob->{'2. high'} + $_SESSION['FREQ'][$symb]['HIGH'] ; 
				//low
				$_SESSION['FREQ'][$symb]['LOW'] = $node_glob->{'3. low'} + $_SESSION['FREQ'][$symb]['LOW'] ; 
				//close
				$_SESSION['FREQ'][$symb]['CLOSE'] = $node_glob->{'4. close'} + $_SESSION['FREQ'][$symb]['CLOSE'] ; 
				//vol
				$_SESSION['FREQ'][$symb]['VOL'] = $node_glob->{'5. volume'} + $_SESSION['FREQ'][$symb]['VOL'] ; 
			}
			
			$trend_glob = $node_glob;
			//print_r($node_key);echo "\n";
			if ($array_count >1){//break;
			}
			
			
			$array_count++;
		}
		//					print_r($array_count);print_r("\n");
		
		//				print_r("OPEN:".(	$_SESSION['FREQ'][$symb]['OPEN'] / $array_count)."\n");
		//				print_r("LOW:".(	$_SESSION['FREQ'][$symb]['LOW'] / $array_count)."\n");
		//				print_r("HIGH:".(	$_SESSION['FREQ'][$symb]['HIGH'] / $array_count)."\n");
		//				print_r("CLOSE:".(	$_SESSION['FREQ'][$symb]['CLOSE'] / $array_count)."\n");
		//				print_r("VOL:".(	$_SESSION['FREQ'][$symb]['VOL'] / $array_count)."\n");
		//				print_r("CHANGE:".(	$_SESSION['FREQ'][$symb]['CLOSE'] - $_SESSION['FREQ'][$symb]['OPEN'])."\n");
		
		//				echo "FREQ: ";
		$glob_freq = (	$_SESSION['FREQ'][$symb]['CLOSE'] - $_SESSION['FREQ'][$symb]['OPEN']);
		
		
		//
		//	if  ($glob_freq >= "-12.0"){
		//		$CLEAN_glob_freq =  map(round( map($glob_freq, "-12", "5","0","20" ), 0, PHP_ROUND_HALF_UP ), "1","50","1","20");
		if  ($glob_freq >= "-50.0"){
			$CLEAN_glob_freq =  map(round( map($glob_freq, "-50", "3","0","20" ), 0, PHP_ROUND_HALF_UP ), "1","50","1","20");	
			
			if ($CLEAN_glob_freq >="20"){$CLEAN_glob_freq = 20;}
			} else{
			
			$CLEAN_glob_freq = 1;
		}
		
		//echo "\n";
		
		
		$servername         = "127.0.0.1";
		$username           = "root";
		$dbname             = "stock_market_local";
		$password           = "";	
		
		$afrq_conn_sub = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		//print_r($row);
		$sql = "UPDATE `stock` SET `frequency` = '".$CLEAN_glob_freq."' WHERE CONVERT(`trading_name` USING utf8mb4) = '".$symb."'";
		if (mysqli_query($afrq_conn_sub, $sql)) {
			// echo "\n\n \033[32mUpdateing datasets \033[0m \n";
			} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($frq_conn_sub);
		}
		mysqli_close($afrq_conn_sub);
		
		$frq_conn_sub = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		//print_r($row);
		$sql = "UPDATE `day_trades` SET `frequency` = '".$CLEAN_glob_freq."' WHERE CONVERT(`trading_name` USING utf8mb4) = '".$symb."'";
		if (mysqli_query($frq_conn_sub, $sql)) {
			//  echo "\n\n \033[32mUpdateing datasets \033[0m \n";
			} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($frq_conn_sub);
		}
		mysqli_close($frq_conn_sub);
	}
	
	
	function RUN_FREQ_FINVIZ ($BACK_CALL= null){
		
		$servername         = "127.0.0.1";
		$username           = "root";
		$dbname             = "stock_market_local";
		$password           = "";	
		//look at all the stock we are about to own or own - dont look at closing call trades
		$frq_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		$query = "SELECT * FROM `day_trades` WHERE CONVERT(`TYPE` USING utf8mb4) != 'CC' AND `frequency` < '1' ORDER BY `id` LIMIT 5";//lets see how the stocks we own are doing first
		//	$query = "SELECT * FROM `stock` DESC LIMIT 350";//lets see how the stocks we own are doing first
		
		$trade= null;
		if ($main_trade_loop=mysqli_query($frq_conn,$query)){ 
			// Fetch one row
			while ($trade=mysqli_fetch_row($main_trade_loop))
			{
				print_r($trade);echo "\n";
				usleep(40); //1100 - 1300				
				
				FREQ_BACKTRACK($trade[1]);
			}
			mysqli_close($frq_conn);
		}
		
		
		
	}
	
