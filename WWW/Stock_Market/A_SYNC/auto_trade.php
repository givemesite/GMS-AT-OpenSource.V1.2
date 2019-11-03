<?php
	/////////////////////////////////////////////////
	/////////////////////////////////////////////////
	/////////////////////////////////////////////////
	//
	//		The CLI command line interface for 
	//      GMS
	//
	//
	//if it finds a item moving up in the table 
	//it will set the item in the investment planer
	//if the data needs to be updated ie. the row 
	//moves up in the list the data will update
	//
	//
	/////////////////////////////////////////////////
	/////////////////////////////////////////////////
	//
	/////////////////////////////////////////////////
	//auto_trade.php
	/////////////////////////////////////////////////
	
	//C:/php/bin/AHP/32bit-php-5.6/php.exe c:/php/WWW/Stock_Market/A_SYNC/a_sync.php
	//$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);	
	
	//include('c:/php/WWW/Stock_Market/INCLUDE/cl_colors.php');
	include("$SERVER_DIR/LOOP/loop_stats.php");
	include("$SERVER_DIR/fibonacci/seo/seo_api.php");
	include("$SERVER_DIR/LOOP/all_starts_here.php");
	include("$SERVER_DIR/fibonacci/seo/seo_finviz_api.php");
	include("$SERVER_DIR/fibonacci/seo/seo_finviz_api_freq.php");
	include("$SERVER_DIR/LOOP/basic_test.php");
	include("$SERVER_DIR/MODELS/galante.php");
	include("$SERVER_DIR/LOOP/watch_plan.php");
	
	
	
	
	
	FUNCTION RUN_AUTTOTRADE($conn= null, $watch_mode= null,$SERVER_DIR= null,$BACK_CALL= null,$loop_count= null,$xSERVER_IP= null ){
		
		
		//////////////
		//sessions
		//
		//
		//
		///////////////
		
		$balance = $_SESSION["BALANCE"];
		//some stuff for mysql data base
		$servername         = "127.0.0.1";
		$username           = "root";
		$password           = "";
		$dbname             = "stock_market_local";
		
		$_SESSION["MAX_STOCK_QTY_BID"] = '';
		$_SESSION["MAX_STOCK_QTY"]     = '';
		$_SESSION["MAX_HOLD"]		   = '';
		$_SESSION["MAX_RISK"]		   = '';
		$_SESSION["MIN_ROI"]		   = '';
		
		$First_Stock_SYMB  = $_SESSION["First_Stock_SYMB"];
		$Second_Stock_SYMB = $_SESSION["Second_Stock_SYMB"];
		$Thired_Stock_SYMB = $_SESSION["Thired_Stock_SYMB"];
		$Forth_Stock_SYMB  = $_SESSION["Forth_Stock_SYMB"];
		echo chr(27).chr(91).'H'.chr(27).chr(91).'J'; //clear the command line //^[H^[J  
		
		echo"
	 ___         _    ___          _         ___  _      ___             _                   
	| . | _ _  _| |_ | . |   ___ _| |_  ___ |  _>| |__  / __> _ _  ___ _| |_  ___ ._ _ _     
	|   || | |  | |  | | |  <_-<  | |  / . \| <__| / /  \__ \| | |<_-<  | |  / ._>| ' ' |    
	|_|_|`___|  |_|  `___'  /__/  |_|  \___/`___/|_\_\  <___/`_. |/__/  |_|  \___.|_|_|_|    
								 <___'                           
	 ___                     ___   __ __  ___     _ _  _     ___            __           __  
	| __> _ _  ___ ._ _ _   /  _> |  \  \/ __>   | | |/ |   |   |          / / ___   ___ \ \ 
	| _> | '_>/ . \| ' ' |  | <_/\|     |\__ \   | ' || | _ | / |         | | |___| |___| | |
	|_|  |_|  \___/|_|_|_|  `____/|_|_|_|<___/   |__/ |_|<_>`___'         | |             | |
								      	       \_\           /_/ 
	GMS Auto Stock Trade System: V1.0

		
		";
		
		//echo "Starting Server........... DONE \n";
		
		//echo "Loging into robinhood........... DONE \n";
		
		// RH_API_LOGIN($call_type, $symbol, $price, $order_type, $qty);
		
		//api reporter
		
		//echo (file_get_contents("http://127.0.0.1/Stock_market/test/8.php"));
		//sleep(5);
		//external 69.126.50.97:3005 TCP is redirected to internal 192.168.1.16:80 (duration=0)
		//$router_wan = explode(" ",$Router_responce);
		$time=time();
		
		$api_file = "C:/php/www/Stock_Market/API/alphavantage.KEY"; // I was running the code on localhost, and hence the path!
		
		echo $Router_responce;
		
		//$wan = explode(":",$router_wan[1]);
		//echo $wan[0];//ip   
		//echo $wan[1]; //port
		//echo getHostByName(getHostName());//LAN IP
		
		echo "\n";
		
		//$api_key = file_get_contents($api_file); 
		
		//set the port 
		//file_get_contents("https://stocks.givemesite.com/MOBILE/APP/login_api/remote_port_route.php?set_port=$port&time=$time&api=$api_key");
		
		
		
		if ($_SESSION["AT"]["CDN"]==TRUE){
			
			}	else{ 
			echo (gms_cdn_API("cdn",$xSERVER_IP));
			$_SESSION["AT"]["CDN"]=TRUE;
			sleep(6);
			
		}	
		
		
		
		for ($x = 0; $x <= 149;$x++
		) { 
			
			
			//make a connection to the database we will be using the most - local stock data
			$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
			
			//	sleep(00);
			if ($x   >=  140 ){
				$x= 0;
				
				
			}
			
			
			
			/////////////////////////////////////////////////
			/////////////////////////////////////////////////
			/////////////////////////////////////////////////
			//
			//		Simple script to buy and sell on
			//      
			//
			//
			//
			//
			/////////////////////////////////////////////////
			/////////////////////////////////////////////////
			//
			/////////////////////////////////////////////////
			//
			/////////////////////////////////////////////////	
			//average all stocks in local table 
			
			//keep a look at all the stocks 
			WATCH_STOCKS($watch_mode,$SERVER_DIR,$BACK_CALL,null,null,$x,$WEIGHT,$BIASES,$USLEEP,$SLEEP,$RAM_SPAWN); //gets the stocks from all the seo LOOP/       watch_plan.php
			
			
			
			
			
			/////////////////////////////////////////////////
			/////////////////////////////////////////////////
			/////////////////////////////////////////////////
			//
			//		seo server for
			//      
			//
			//
			//if it finds a item moving up in the table 
			//it will set the item in the investment planer
			//if the data needs to be updated ie. the row 
			//moves up in the list the data will update
			//
			//
			/////////////////////////////////////////////////
			/////////////////////////////////////////////////
			//
			/////////////////////////////////////////////////
			//
			/////////////////////////////////////////////////	
			// search engines  APIS 	
			//RUN_FINVIZ();
			//RUN_FREQ_FINVIZ();
			
			
			//if you want to use investing.com
			//	RUN_INVESTING();//runs the investing planer /                  seo_investing_api.php
			//	RUN_INVESTING_helper(); //                                     seo_investing_api_Service.php
			//	RUN_INVESTING_helper_long();
			
			//mysqli_close($conn);
			
			
			// 
			
			echo chr(27).chr(91).'H'.chr(27).chr(91).'J'; //clear the command line //^[H^[J  
			
			$time = date('m/d/y g:i:sA');//set the date
			date_default_timezone_set('America/New_York'); //set the time zone
			
			//echo "\033[31mred\033[37m\r\n";
			//echo "\033[32mgreen\033[37m\r\n";
			//echo "\033[41;30mblack on red\033[40;37m\r\n";
			
			
			//start the main menu for stock tradeing durning the day 
			
			echo"\033[0;32m
	 ___   __ __  ___     ___    _         ___  _      _                       _    _            
	/  _> |  \  \/ __>   / __> _| |_  ___ |  _>| |__  | |._ _  _ _  ___  ___ _| |_ <_>._ _  ___  
	| <_/\|     |\__ \   \__ \  | |  / . \| <__| / /  | || ' || | |/ ._><_-<  | |  | || ' |/ . | 
	`____/|_|_|_|<___/   <___/  |_|  \___/`___/|_\_\  |_||_|_||__/ \___./__/  |_|  |_||_|_|\_. | 
						                                     	       <___' 
																						   
	 ___             _                 _ _  _     ___                   ___  ___  ___  ___      
	/ __> _ _  ___ _| |_  ___ ._ _ _  | | |/ |   |   |                 | . >| __>|_ _|| . |     
	\__ \| | |<_-<  | |  / ._>| ' ' | | ' || | _ | / |                 | . \| _>  | | |   |     
	<___/`_. |/__/  |_|  \___.|_|_|_| |__/ |_|<_>`___'                 |___/|___> |_| |_|_|     
	     <___'  
		 
			\033[0m";
			echo "\n";
			echo'    Loop ID is : '; echo $x; 
			
			echo "\n Time On Server: ".$time;
			//echo "\n Server Host   : NY-LAN.SUFFOLK-1.stock.givemesite.com";
			echo "                             \n";
			echo "\n";
			echo "\033[4;37mSTOCK CYCLE DATA\033[0m";echo "	\n";
			echo "-------------------------------------------------------------------------------\n";
			echo "-------------9:30AM-----|--9:35AM --|--9:38AM --|--10:00AM--|--10:20--|-\n";
			$bal=	round((abs($_SESSION['BAL'])),2, PHP_ROUND_HALF_DOWN)	;
			$qty = round((abs($_SESSION['QTY'])),2, PHP_ROUND_HALF_DOWN);
			$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
			$query = "SELECT * FROM `buy` ORDER BY `id` DESC LIMIT 1";//see if we have this stock
			//echo "\n STOCK 1:";
			if ($result=mysqli_query($conn,$query)){ 
				// Fetch one row
				while ($row=mysqli_fetch_row($result))
				{
					
					echo "Balance : $".$bal."\n"; 
					$remainder = $row [5] - $row [3];
					$exp = ($remainder * $qty) +$bal;
					echo "Exposure: $". $exp."\n\n";
					$exp = ($remainder * $qty) ;
					//echo "\033[6;37mBold text";
					
					//echo "\033[0m";//text reset
					echo "\033[6;37mBUY \n\033[0m";
					echo substr($row [3],0,10).' Up '; echo$row [5];echo "	\033[44;37m";echo $row [1];echo "\033[0m	   "; echo date('g:i:sA', $row [2]);
					
					
				}}	mysqli_close($conn);
				$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
				$query = "SELECT * FROM `cycle_sell` ORDER BY `id` DESC LIMIT 1";//see if we have this stock
				//echo "\n STOCK 1:";
				if ($result=mysqli_query($conn,$query)){ 
					// Fetch one row
					while ($row=mysqli_fetch_row($result))
					{
						
						echo "\n\033[6;37mSELL \n\033[0m";
						echo substr($row [3],0,10).' Up '; echo$row [4];echo "	\033[44;37m";echo $row [1];
						echo "\033[0m	   "; echo date('g:i:sA', $row [2]);
						
						
					}}	mysqli_close($conn);
					if ($remainder > 0){$trade_mod_ud= "UP";}else{$trade_mod_ud= "DOWN";}
					//   echo "	(NA 1.00/1.99)	(Q+4/+$2.40) (Q+4/+$2.40)	";
					echo "	($trade_mod_ud $remainder) (Q$qty - $$exp)";
					echo "\n";
					echo "------------10:30AM-----|--10:35AM--|--10:38AM--|--11:00AM--|--11:20--|-";
					// echo "\n	(NA 1.00/1.99)	(Q+4/+$2.40) (Q+4/+$2.40)		 ";
					echo "\n";echo "\n";		
					//echo "\n";
					echo"\033[4;37mSTOCK WATCH TABLE\033[0m";	echo "\n";
					echo "------------------------------------------------------------------------------";
					
					
					
					
					echo "\n -------------NAME-------SYMB----------TIME-------PRICE--------QTY------ORDER-";
					
					$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
					$query = "SELECT * FROM `day_trades` ORDER BY `id` DESC LIMIT 1";//see if we have this stock
					echo "\n STOCK 1:";
					if ($result=mysqli_query($conn,$query)){ 
						// Fetch one row
						while ($row=mysqli_fetch_row($result))
						{
							//print_r ($row);
							//$row_time = $row [11]-29000;
							//$row_time = $row [11]-30000;
							//echo  $row [9];
							//echo " ";echo $row [0];echo " ";
							echo substr($row [2],0,10);echo "...	";echo $row [1];echo "	   "; echo date('g:i:sA', $row [6]);
						}}	mysqli_close($conn);
						
						//echo "\n STOCK 2:NA...	 UP4        9:45AM       CGEN    Q-O:0|Q-S:0    ";	
						
						
						$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
						$tquery = "SELECT * FROM `day_trades` ORDER BY `id` DESC LIMIT 1,1";//see if we have this stock
						echo "\n STOCK 2:";
						if ($result=mysqli_query($conn,$tquery)){ 
							// Fetch one row
							while ($row=mysqli_fetch_row($result))
							{
								//print_r ($row);
								
								
								//echo " ";echo $row [0];echo " ";
								echo substr($row [2],0,10);echo "...	";echo $row [1];echo "	   "; echo date('g:i:sA', $row [6]);
							}}	mysqli_close($conn);
							
							$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
							$query = "SELECT * FROM `day_trades` ORDER BY `id` DESC LIMIT 2,1";//see if we have this stock
							echo "\n STOCK 3:";
							if ($result=mysqli_query($conn,$query)){ 
								// Fetch one row
								while ($row=mysqli_fetch_row($result))
								{
									//print_r ($row);
									
									
									//echo " ";echo $row [0];echo " ";
									echo substr($row [2],0,10);echo "...	";echo $row [1];echo "	   "; echo date('g:i:sA', $row [6]);
								}}	mysqli_close($conn);
								
								echo "\n";
								$bal = round($bal,1, PHP_ROUND_HALF_DOWN);
								$exp = round((($remainder * $qty) +$bal),1, PHP_ROUND_HALF_DOWN);
								$pexp = round(($remainder * $qty),1, PHP_ROUND_HALF_DOWN);
								echo "\n \033[4;37mTodays Totals\033[0m";
								echo "\n----------------------------------------------------------------------------";
								echo "\n Ledger Balance :"."\033[44;37m+$$bal\033[0m		"."	|  Day CLOSE  :		\033[44;37m+$$pexp\033[0m             ";
								echo "\n DAY Balance    :\033[44;37m+$$exp\033[0m			|  DAY GAINS  :		\033[44;37m+$$pexp\033[0m               ";
								echo "\n LAST NIGHT-LOSS:\033[41;37m-$0.00\033[0m			|  DAY LOSS   :		\033[41;37m-$0.00\033[0m                 \n";
								
								//echo "\033[46;37mWhite on blue \033[0m\n";
								
								//echo "\033[4;37mUnderlined text";
								//echo "\033[0m";//text reset
								//echo "\n";
								//echo "\033[6;37mBold text";
								
								//echo "\033[0m";//text reset
								
								//$site = fread(STDIN, 80);
								//$site = trim($site);
								//fwrite(STDOUT, "test");
								
								
								
								//////////////
								//buffer stuff
								//
								//
								//delay
								///////////////	
								
								//
								//print_r($GLOBALS);
								
								//End of for loop 
								mysqli_close($conn);
		}
		//exit();
		
		
	}
	
