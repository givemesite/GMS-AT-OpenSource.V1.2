<?php
	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//
	//	looks at stock in data set and makes
	//   buy and sell calls baised on triggers
	//
	//
	// watch plan .php 
	//kris galante krisgcell@gmail.com
	//////////////////////////////////////////////
	//Parts of this script link to 
	//////////////////////////////////////////////	
	//	c:/php/WWW/Stock_Market/LOOP/sell_risks.php for documenting 
	//	c:/php/WWW/Stock_Market/LOOP/buy_risks.php  for documenting 
	
	/* DEV HINT
	Whats a alpha?
	if you search for - ALPHA in the files
	you will find some functions that are currentley being debugged 
	
	
	
	this is a faster way to dev and find current 
	functions and arithmatic that is being tested and debugged in the present
	
	
	
	*/
	//to do
	
	//auto trade server
	
	//get/save system historic data from stock table - helps find a stock sooner | time server - DONE
	
	//calculate gain adv bias, from mysql stock table - improve thee gain and loss functions - DONE
	
	//get price back from alpaca and set trade value - save the price returned from alpace in the buy table 
	
	//fixed but now need to make call back url for returning order
	
	
	//mobile 
	
	
	
	
	//cdn api & token
	
	
	
	
	//condition's for trade
	
	
	
	
	
	
	//used to test live data 
	
	//MYSQL DAY TRADES TYPE
	//OC = opening cycle
	//CC = closeing cycle
	//CW = call watch/wait 
	//CB = call buy
	//CS = call sell
	//CN = call new buy cycle
	
	
	//CO = cycle one
	//CT = cycle 2 and 3
	//CF = cycle 4
	//TW = Win
	//TL = Loss
	//DW = trigger dip watch
	
	//////////////////////////////////////////////		
	//Strategies 	
	//////////////////////////////////////////////	
	
	//clean all old data in mysql
	//delete old data in tables 
	//stocks
	//day_tradess
	//when time is > 9:25am
	
	//////////////////////////////////////////////	
	//tradeing days
	//////////////////////////////////////////////	
	//alpha api
	//////////////////////////////////////////////	
	//if bught, sold
	//////////////////////////////////////////////
	session_start();
	include("$SERVER_DIR/fibonacci/seo/seo_investing_api_indexs.php");
	
	
	function WATCH_STOCKS($stocks_watch_mode= null,$SERVER_DIR= null,$BACK_CALL= null,$emu= null,$sim= null,$in_loop_count= null,  $sql_inject = null, $Z_pre_sql_inject = null){
	$leep_A = "10";
	$leep_B = "20";
	$leep_C = "50";
	$leep_D = "100";
	include("$SERVER_DIR/LOOP/time_base.php");

	//get node id 
	$node_id = $_GET['node'];
		if (isset($node_id)){
	
	$file  = "C:/php/www/Stock_Market/API/temp/AI-NODE-".$node_id .".PLH"; // I was running the code on localhost, and hence the path!
	if (isset($node_id)){
		if ((file_exists (  $file ))== FALSE){
		
		fopen($file, "w");
	}
	}
	// WHERE `id` = '1'
		$RW_QLOOK = $_GET['RW_LOOK'];
		
		if ($RW_QLOOK == "TRUE"){
			
	
					$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
						$cquery = "SELECT COUNT(*) FROM `day_trades`";
						if ($fresult=mysqli_query($sub_conn,$cquery)){ 
							// Fetch one and one row
							while ($get_adv=mysqli_fetch_row($fresult))
							{
								$count      = $get_adv[0];
								
							}}
							mysqli_close($sub_conn);usleep(60);

							$last 			= file_get_contents($file);	
							
							
		if ($last <1 || $last == ""){
				file_put_contents($file, $count);	
			
				$sql_inject = " LIMIT 5";
				
				
			
					
			
				

			
		}else{
		
				$pre_sql_inject = " WHERE `id` = '".$last."'";
			$next_cell = $last - "1";
				file_put_contents($file, $next_cell);sleep (1);	
			$sql_inject = " LIMIT 5";
		}
			
		
		}else{

		$last 			= file_get_contents($file);	
		
		if (isset($last)){
			
			if ($last < 1){
				file_put_contents($file, "1");
					$sql_inject = " LIMIT 5";
			}else {
			$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
						$cquery = "SELECT COUNT(*) FROM `day_trades`";
						if ($fresult=mysqli_query($sub_conn,$cquery)){ 
							// Fetch one and one row
							while ($get_adv=mysqli_fetch_row($fresult))
							{
								$count      = $get_adv[0];
								
							}}
							mysqli_close($sub_conn);usleep(60);
			if ($last  > $count){
				
				
					file_put_contents($file, "1");	
					
				
				
			}else{
				
				
				$next_cell = $last + 1;
				
				file_put_contents($file, $next_cell);	
					
				$pre_sql_inject = " WHERE `id` = '".$last."'";
			}
			

			}
			
		}else{$sql_inject = " LIMIT 5";}
		
		}

		
		}
		
if (isset(($_GET['node']))){
//	echo $pre_sql_inject;
		//keep a look at all the stocks 
		$sql_inject = " LIMIT 5";
		
}
	
	
	
	$PREsub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
	
	$equery = "SELECT AVG(`5DT`) FROM `day_trades`";
	if ($eresult=mysqli_query($PREsub_conn,$equery)){ 
		
		while ($rawa=mysqli_fetch_row($eresult))
		{$a = $rawa;
			
		}}
		
		
		mysqli_close($PREsub_conn);		
		
		
		
		//add adverages to the index string		
		
		$lab_test_count = $_SESSION['lab_test_count'];
		//get adverages
		
		$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		$mqmquery = "SELECT * FROM `advs` LIMIT 1";
		if ($aresult=mysqli_query($sub_conn,$mqmquery)){ 
			// Fetch one and one row
			while ($get_advsnum=mysqli_fetch_row($aresult))
			{
				$old_advs      = $get_advsnum[0];
				$old_day      = $get_advsnum[2];
				$old_a      = $get_advsnum[3];
			}}
			mysqli_close($sub_conn);usleep($leep_C);
			
			
			
			
			$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
			$qmquery = "SELECT * FROM `day_trades` LIMIT 1";
			if ($bresult=mysqli_query($sub_conn,$qmquery)){ 
				// Fetch one and one row
				while ($get_num=mysqli_fetch_row($bresult))
				{
					$table_number      = $get_num[0] + 20;
					$table_offset      = $get_num[0] + 200;
				}}
				mysqli_close($sub_conn);usleep($leep_C);
				
				
				
				$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
				$dquery = "SELECT COUNT(*) FROM `day_trades`";
				if ($cresult=mysqli_query($sub_conn,$dquery)){ 
					// Fetch one and one row
					while ($get_count=mysqli_fetch_row($cresult))
					{
						$table_count      = $get_count[0];
						
					}}
					mysqli_close($sub_conn);usleep($leep_C);
					

						
						
						
						$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
						$cquery = "SELECT AVG(`OCG`) FROM `day_trades`";
						if ($fresult=mysqli_query($sub_conn,$cquery)){ 
							// Fetch one and one row
							while ($get_adv=mysqli_fetch_row($fresult))
							{
								$ocg      = $get_adv[0];
								
							}}
							mysqli_close($sub_conn);usleep($leep_C);
							
							
							
							$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
							$aquery = "SELECT AVG(`frequency`) FROM `day_trades`";
							if ($gresult=mysqli_query($sub_conn,$aquery)){ 
								// Fetch one and one row
								while ($get_frq=mysqli_fetch_row($gresult))
								{
									$frequency= $get_frq[0];
									
								}}
								mysqli_close($sub_conn);usleep($leep_C);
								
								
								
								
								$base_count =  		    round($table_count       ,0,PHP_ROUND_HALF_UP);
								//006-06 to 60
								$base_ocg   =  "00000000"  .  round(($ocg + $ocg /20-2)      ,0,PHP_ROUND_HALF_UP).".9";
								$base_frq   =               round(($frequency-$ocg) ,0,PHP_ROUND_HALF_UP);
								$base_frq = 0;
								
								
								
								
								
								
								
								
								if (!isset($sim)){
									// $WEIGHT['FREQ'] =
									}else{
									
									
								}
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								//kris will talk about what this dose in later docs 
								//ill give a link for this in my google drive and how it works
								include("$SERVER_DIR/LOOP/multidimensional_hyperbola.php");

														
														
														
														
														
					
				
					
					
					if (!isset(($_GET['node']))){echo "\n\033[4;37mTable Adv\033[0m";echo "	\n";}
					echo "-------------------------------------------------------------------------------\n";
					echo"\n AVD / PADV: ".$old_advs."/".$old_a." GAIN: ".$GAIN_Percent." OCG".$base_ocg . " FRQ". $base_frq . " ILC".$in_loop_count. "   COUNT". $base_count ."\n";//sleep(3);
					//reaction
					//find gains
					//even
					//Alpaca
					echo "\n Alpaca Balance: ".$json_obj->buying_power;
					if($day_trades_used <>TRUE){
						//sleep(1);
					}
					
					
					$_SESSION['BAL'] = $json_obj->buying_power;
					//a day trade with 25K equity 
					$gain= (round(($ocg),0,PHP_ROUND_HALF_DOWN));
					$seach_gain= "0"  .($gain*$gain)-1;
					$end_gain=   "0"  .($gain*$gain)+1;
					//you will find this kind of trade will make profit around 10:20AM
					"SELECT * FROM `day_trades` WHERE CONVERT(`OCG` USING utf8mb4) >= '".$seach_gain.
					"' AND CONVERT(`OCG` USING utf8mb4) <= '".$end_gain.
					"' AND `frequency` < '".(round(($frequency),0,PHP_ROUND_HALF_DOWN))."' ORDER BY `VOL` DESC LIMIT 200";
					
					
					if ( ($json_obj->daytrade_count) < 3){
					//need to code a responce catch here 
					//Error in query (2006): MySQL server has gone away
					
					//9/17/19
					
					
					//if we aleredy found a stock and tried to buy it 
					if ($day_trades_used==TRUE){
					//for a indexed table
					//$qquery = "SELECT * FROM `day_trades` WHERE MATCH (`trading_name`) AGAINST ('".$quantitative_trade[1]."') ORDER BY `id` //DESC LIMIT 1";
						//for tabe that is not indexed 
						$qquery = "SELECT * FROM `day_trades` WHERE CONVERT(`trading_name` USING utf8mb4) = '".$quantitative_trade[1]."' ORDER BY `id` DESC LIMIT 1";
						//sleep(2);
						}else{		
						
						//SELECT * FROM `stock` ORDER BY `CHANGE_PCT` DESC LIMIT 1
						

						
						
						
						
						
						
						$model					= "";	
					//	if (isset($_GET['node'])){			$qquery = "SELECT * FROM `day_trades`".$pre_sql_inject." ORDER BY `TYPE`".$sql_inject ;}
						//even	
						if ($in_loop_count % 2 == 0){
							
							//$day_trades_used= null;
							
							
							//i saw this had a problem with negitive numbers on a winning stock 		
							//AND CONVERT(`5DT` USING utf8mb4) > '".$a[0]."'
							
							//the best kinda stocks - espoused
							//$qquery = "SELECT * FROM `day_trades` WHERE CONVERT(`OCG` USING utf8mb4) > '".$base_ocg.
							//"' AND `frequency` > '".$base_frq."' LIMIT 150";
							
							//DESC
							
							//$qquery = "SELECT * FROM `day_trades` WHERE CONVERT(`OCG` USING utf8mb4) > '".$base_ocg.
							//"' AND `frequency` > '".$base_frq."' AND `id` < '".$table_offset."'ORDER BY `id`";

							
							
							
							
							}else{//here is where i test other odd trading ideas
								if (isset($sql_inject)){}else{$sql_inject = " LIMIT 500";}
							//basic trade reaction
									if ($lab_test_count == '1' ){ 
							$xmodel = "MODEL: A Sort";
							if ($sim["sim"]==FALSE){
								//ORDER BY `TYPE`
							$qquery = "SELECT * FROM `day_trades`".$pre_sql_inject." ORDER BY `TYPE`".$sql_inject ;
							}
							else{
							$qquery = "SELECT * FROM `day_trades` LIMIT 150";
							}
							
							}
							//high - risk & exposure
							if ($lab_test_count == '3' ){
								$qquery = "SELECT * FROM `day_trades` ORDER BY `VOL` DESC LIMIT 50";
								
							
								$xmodel = "MODEL: OC VOL";
							}
							if ($lab_test_count == '5' ){
								$qquery = "SELECT * FROM `day_trades` ORDER BY `OCG` DESC LIMIT 50";
						
								$xmodel = "MODEL: OC GAIN";
							}		
							
							//high - risk & exposure
							if ($lab_test_count == '6' ){
								$qquery = "SELECT * FROM `day_trades` ORDER BY `PLAN_B_CHANGE_PCT` DESC LIMIT 50";
								$xmodel = "MODEL: LOSS";
							}		
						}
			
						
	}
	}
	
	else {	echo "\n Automated PDT HALT! \n";}
						
						//SELECT * FROM `stock` ORDER BY `CHANGE_PCT` DESC LIMIT 1
						
						
						$pqquery = "SELECT * FROM `stock` ORDER BY `CHANGE_PCT` DESC LIMIT ". $lab_test_count;
						
						$sub_loop_sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
						$trade= null;
						if ($sub_main_trade_loop=mysqli_query($sub_loop_sub_conn,$pqquery)){ 
							// Fetch one row
							
							while ($sub_trade=mysqli_fetch_row($sub_main_trade_loop))
							{
								$mount_trade = $sub_trade;
							}
						}
						
						if ($INDXADV <"0"){
							//$model = "MODEL: GAIN";
							//	$qquery = "SELECT * FROM `day_trades` WHERE `trading_name` = '".$mount_trade[1]."' LIMIT 1";
						}
						
						if ($lab_test_count > '6' ){
							$_SESSION['lab_test_count']= '0';
							$lab_test_count = 0;
						}
						$lab_test_count++;
						$_SESSION['lab_test_count'] = $lab_test_count;
						
															
	
															
															
															
							//print_r( $qquery);								
															
															
	$RUN_LIVE = null;
	
	//no need to look for stocks to buy if the market is not +1.00/PT up
	$test_adv = $old_advs - $old_a;

	//only calc advarages after 20 rows	and if the data in the 
	//db is incressing in change by more the or equal to 1.00/pt	
	//dont change unless you plan on changing the tabe adv and its correlations
	//it might be tempting but can have adverse effects
	if ($base_count >'20' ){//also this system normaley can see 500 rows per day on adverage 				
		$loop_sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		$trade= null;
		if ($main_trade_loop=mysqli_query($loop_sub_conn,$qquery)){ 
			// Fetch one row
			
			while ($trade=mysqli_fetch_row($main_trade_loop))
			{
				//This will break the loop after the system puts out a buy order
				$sessionCarrier = $_SESSION['LOOPBREAK'];
				if ($sessionCarrier == 1){$_SESSION['LOOPBREAK']=0;break;}
				
				
				//- ALPHA
				
			//used to set the diffrence in price to the lowest price 	
				$price_diff = $trade[4] - $trade[11];
				if ($price_diff <> $trade[4] ){							
		$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		$aquery = "UPDATE `day_trades` SET `PLAN_B_CHANGE_PCT` = '".$price_diff."' WHERE `id` = '".$trade[0]."'";
		if ($result=mysqli_query($sub_conn,$aquery)){ 
			// Fetch one and one row
			while ($get_worker_row=mysqli_fetch_row($result))
			{
				$worker_row= $get_worker_row;
				
			}}
			mysqli_close($sub_conn);usleep($leep_C);	
				
				}
				
				
				$model					= "";	
				
				
				
				//used to find the row the worker process is on
							
							
							//x is the amount of worker nodes
							for ($x = 0; $x <= 1; $x++) {
							
		$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		$aquery = "SELECT * FROM `nodes` WHERE `node_id` = '".$x."' LIMIT 1";
		if ($result=mysqli_query($sub_conn,$aquery)){ 
			// Fetch one and one row
			while ($get_worker_row=mysqli_fetch_row($result))
			{
				$worker_row= $get_worker_row;
				
			}}
			mysqli_close($sub_conn);usleep($leep_C);																		
							
							
							
							
							}
							
							if ($trade[0]==$worker_row[2]){
								//nural net node
								$RUN_LIVE = null;
								
							}else{
								
								$RUN_LIVE = TRUE;
							}
							
							
							
							
							$RUN_LIVE = TRUE;
							
							
							
																		
							
							
		if (!isset(($_GET['node']))||isset(($_GET['node']))){					
//get adverages
$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
$hquery = "SELECT AVG(`OCG`) FROM `day_trades` WHERE `id` < '$table_number'"; //- ALPHA just added WHERE `id` < '$table_number' 
//need to do a emulation 
if ($dresult=mysqli_query($sub_conn,$hquery)){ 
	// Fetch one and one row
	while ($get_padv=mysqli_fetch_assoc($dresult))
	{
		//print_r($get_padv); sleep(1000000);
		$padv      = $get_padv["AVG(`OCG`)"];
		
	}}
	mysqli_close($sub_conn);usleep($leep_C);
							
							//print($padv);
							
							
							//set new day advarages in the advs table
							
							usleep($leep_C);
							
							$raw_old_day = $old_day+ 0;
							
							if($padv<100 && $raw_old_day <> $the_day && $the_ap == "am" && "9" == $the_hour && $the_min > "30" && $the_min <= "59"){
								//- ALPHA
								//compare last 3 result and make adverage
												$padv	;   //1st newest
												$old_advs ; //2nd
												$old_a    ; //3rd oldest
												
												$main_adv = $padv + $old_a + $old_advs;
												$clean_main_adv = ($main_adv / 3);
								//look at the last three for a pattern
								//oldest
								if ($old_advs  > $old_a){
										//newest
										//up trend
										
										$_SESSION['SYSTEM']['MSC']['PATH_TREND']= "-5";
									if ($padv  > $old_advs){
											//in 
											}else{
										//down
										// try not to buy
										
									}
									
								}else{
									//down - try not to buy
									 $_SESSION['SYSTEM']['MSC']['PATH_TREND']= "-10";
								}
								//down trend
								if ($old_advs  < $old_a && $padv  < $old_a){
									 $_SESSION['SYSTEM']['MSC']['PATH_TREND']= "-15";

								}
								
								//if pattern is uptrend then do nothing 
								
								//if pattern is a down trend make adverge and use in the gain % result durning buy 
								
							
								
											$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
									$bsql = "UPDATE `advs` SET `adv` = '".(round(($padv),2,PHP_ROUND_HALF_DOWN))."' WHERE id = 1";
									
									
									if (mysqli_query($sub_conn, $bsql)) {
										// echo "New record created successfully \n";
										} else {
										echo "Error: " . $sql . "<br>" . mysqli_error($conn);
										sleep(700);
									}mysqli_close($sub_conn);usleep($leep_A);
									usleep($leep_D);	//set new adv in database 
								if((abs($padv)) >  0 ){			
					
								}else {
									
									
																if (isset($sim)){
																$_SESSION["SIM_id"] = 1000;//reset simulation buffer
									}
								}
								
								
								$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
								$bsql = "UPDATE `advs` SET `day` = '".$the_day."' WHERE id = 1";
								
								
								if (mysqli_query($sub_conn, $bsql)) {
									// echo "New record created successfully \n";
									} else {
									echo "Error: " . $sql . "<br>" . mysqli_error($conn);
									sleep(700);
								}mysqli_close($sub_conn);usleep($leep_A);
								usleep($leep_D);
								
								
								$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
								$bsql = "UPDATE `advs` SET `old_adv` = '".$old_advs."' WHERE id = 1";
								
								if (mysqli_query($sub_conn, $bsql)) {
									// echo "New record created successfully \n";
									} else {
									echo "Error: " . $sql . "<br>" . mysqli_error($conn);
									sleep(700);
								}mysqli_close($sub_conn);usleep($leep_A);
								usleep($leep_D);
								
								
							}
		}							usleep($leep_B); 
							//	echo "\n The Price Now:".$the_price_now."\n";
							
				//no need to look for stocks to buy if the market is not 20 +0.50/PT up
							if ((abs($test_adv)) >= 0.20 && $padv<>0){
							//print_r($trade);
							if ($sim["sim"]==TRUE){
								
								
								
								$the_hour       = $sim["h"]; 
								$the_min        = $sim["m"];
								$the_seconds    = date('s');
								$the_year       = $sim["y"];//year
								$the_mon        = $sim["mo"];//month
								$the_day        = $sim["d"];//
								
								$FREQ			= null;
								
							}
							else
							
							{
								
								$the_hour       = date('g'); 
								$the_min        = date('i');
								$the_seconds    = date('s');
								$the_year       = date('Y');//year
								$the_mon        = date('m');//month
								$the_day        = date('d');//mon-fri
								$the_ap         = date('a');//am or pm
								$the_day_symbl  = date('D');
								$FREQ			= null;
								
							}
							//echo "TEST";
							
							
							
							//echo $trade[0];
							// echo "\n";
							//echo $trade[1];
							// echo "\n"; 
							//echo $trade[2];
							// echo "\n"; 
							//echo $trade[4];
							// echo "\n"; 			
							
							$stock_was_bught		= null;		
							$day_trades_sold		= null;
							//$day_trades_used	 	= FALSE;
							$dec_price 				= 0;
							
							
							
							//chech if we sold a trade today	
							//dont over sell
							$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
							//see if we have done a day trade today
							$query = "SELECT * FROM `cycle_sell` WHERE `YEAR` = '$the_year' AND `MON` = '$the_mon' AND `DAY` = '$the_day' LIMIT 1 ";
							
							if ($result=mysqli_query($sub_conn,$query)){ 
								// Fetch one and one row
								while ($quantitative_trade=mysqli_fetch_row($result))
								{
									//ECHO"\nONE TRADE WAS EXECUTED TODAY.";			
									$day_trades_sold = TRUE;//continue(1);
									//ECHO"|\n\n Day Trade End Trigger........   DONE";		
								}}
								mysqli_close($sub_conn);usleep($leep_A);
								
								
								
								//check to see if we bught a set of stock today
								//dont over buy	
								$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
								//see if we have done a day trade today
								$query = "SELECT * FROM `buy` WHERE `YEAR` = '$the_year' AND `MON` = '$the_mon' AND `DAY` = '$the_day' LIMIT 1 ";
								if ($result=mysqli_query($sub_conn,$query)){ 
									// Fetch one and one row
									while ($call_quantitative_trade=mysqli_fetch_row($result))
									{
										if ($day_trades_sold <> TRUE){
											//			ECHO"\nONE TRADE IN PROGRESS.";			
										}
										$day_trades_used = TRUE;//continue(1);
										//ECHO"|\n\n Day Trade End Trigger........   DONE";		
									}}
									mysqli_close($sub_conn);usleep($leep_A);
									//re cast the vars
									
									$quantitative_trade = null;			
									$sub_conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
									$query = "SELECT * FROM `buy` WHERE `YEAR` = '$the_year' AND `MON` = '$the_mon' AND `DAY` = '$the_day' LIMIT 1 ";
									if ($result=mysqli_query($sub_conn,$query)){ 
										// Fetch one and one row
										while ($quantitative_trades=mysqli_fetch_row($result))
										{
											$quantitative_trade = null;
											$quantitative_trade = $quantitative_trades;
											$stock_was_bught = TRUE;
											
										}}			
										
										mysqli_close($sub_conn);usleep($leep_A);			
										
										//make a call to alphavantage to get a price of the stock we are looking at 
										//get price for
										//OC open call
										//CW call watch
										//CS call sale
									//	echo "HERE";
										if ($trade[7]=='CS'||$trade[7]=='CB'||$trade[7]=='CW'||$trade[7]=='OC'){
											$symbol = $trade[1];
											$call_type=null;
											
											if (!isset($sim)){
												usleep($leep_B); //1100 - 1300	
												
											}
												
												
																							
																							
																							
																							
																							
																							
																							
						
						
						//check adv data for the same day
						if($raw_old_day <> $the_day ){ $RUN_LIVE= FALSE; }
						
						
						
						
						
						
							if ( $RUN_LIVE== TRUE && $sim["sim"]<>TRUE){
						
						//need to change the price feed		
						
						$key_file = "C:/php/www/Stock_Market/API/alphavantage.KEY"; // I was running the code on localhost, and hence the path!
						
						$api_key = file_get_contents($key_file);
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL,("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=".$symbol."&interval=1min&apikey=".$api_key."&outputsize=compact"));
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$server_output = curl_exec ($ch);
						curl_close ($ch);
						
						
						
						
						
									


			
			//Need to change this to use finviz	and|| or have a switch	
			
			
			$LINK_CHOICE = "finviz";// alpha or finviz
			
			
			
			
			
			
			
			if ($sim["sim"]==FALSE){
	
				
				if($LINK_CHOICE== "alpha"){
					
					
					
					
					
					
					
					
					$key_file = "C:/php/www/Stock_Market/API/alphavantage.KEY"; // I was running the code on localhost, and hence the path!
					
					$api_key = file_get_contents($key_file);
					$array_count = 0;
				
					$trend_glob = null;
					$ch = curl_init();
					curl_setopt($ch,
					CURLOPT_URL,
					("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=".$symbol."&interval=1min&apikey=".$api_key."&outputsize=compact"));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$server_output = curl_exec ($ch);
					curl_close ($ch);
					$result = json_decode($server_output);
					
					if (isset($result->{'Note'})){echo "\n".$result->{'Note'}."\n";}
					
					$glob = $result->{'Time Series (1min)'};
					
					//count data points 
					
			
					
					
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
								if ($array_count >$dataPoints){break;}
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
				}	
				
				if (	$LINK_CHOICE == "finviz"){
					
					$start = microtime(true);
					
					$login_session= $_SESSION['finviz_login'] ;
					
					if ($login_session=='yes'){}
					
					else{FINVIZ_LOGIN();$_SESSION['finviz_login'] = 'yes';}
					
					
					
					
					//usleep(40);
					//jason responce
					
					$url = "https://elite.finviz.com/export.ashx?v=111&t=". $symbol;
					
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
						$finviz_price_now   = $data[8];
						$day_high   = 0;
						$day_low   = 0;
						$CHANGE_PCT   = str_replace('%','',$data[8]);
						$CHANGE_RATIO   = $data[9];
						$CHANGE_VOL   = $data[10];
						$DATE_ADDED   = time();
						$TIME   = time();
						fclose ($stream );
						$time_elapsed_secs = microtime(true) - $start;
			}	
			}	
			}
			}
																							
																							
																							
																					
									
									
									$trend_glob  = null;	
									$array_count = 0;
									$item_count = 0;
									
									IF($sim["sim"]==true){
										$dir = "$SERVER_DIR/test/snapshots".$sim['FOLDER']."/".$symbol.".json";
										$server_output = file_get_contents ($dir);
										//	echo $server_output;
										//		usleep(2000);
									}
									
									
									
									
									$result = json_decode($server_output);
									
									if (isset($result->{'Note'})){echo "\n".$result->{'Note'}."\n";
									//	sleep(4);
									}
									
									
									$glob = $result->{'Time Series (1min)'};
									
						
									
									
									//counts the data in the dataset for today
									foreach ($glob as $test => $old_data_not_used_in_this){
										$time_date  = explode(" ", $test);
										$date_stamp = explode("-", $time_date[0] );
										$time_stamp = explode(":", $time_date[1]);
										//print_r($node_glo
										if ($date_stamp[2]==$the_day ){
											
											$item_count++;
										}else{break;}
										
									}
									//echo $item_count; echo "\n";
									foreach ($glob as $adate_stamp => $node_glob){
										//fix abnormal data 
										
										//echo  $map_bid;
										$atime_date  = explode(" ", $adate_stamp);
										$adate_stamp = explode("-", $atime_date[0] );
										$atime_stamp = explode(":", $atime_date[1]);
										//
										//used to simulate stock data
										if ($sim["sim"]==TRUE){
											
											$map_bid =  round( map(($sim["slot"]), "1", $item_count,"1"  , $item_count), 0, PHP_ROUND_HALF_DOWN ); 
											if ($adate_stamp[2]==$the_day ){
												if ($map_bid==$array_count){
													$trend_glob = $node_glob;
													break;
													//print_r($node_glob);
												}
												//print_r($node_glob);
												//if ($array_count >400){break;}
											}
											//else{break;}
										}
										
										//set data from simulation 	
										
										if ($sim["sim"]==FALSE){
											if ($adate_stamp[2]==$the_day ){
												
												
												$trend_glob = $node_glob;
												//print_r($node_glob);
												break;
												if ($array_count >1){break;}
												
											}//if the data io is not = to today
											else{break;}
										}
										$array_count++;//1 for the most current and this data point only supports 100 for the day
									}
									
									
									
									if ($sim["sim"]==TRUE){
									//	echo "\n";
										//echo "Sediment Time: FRAME ($the_mon   $the_day   $the_year $the_hour $the_min //$the_ap )  CALLED ( \n";
										//print_r($atime_date); echo " ) \n";
										//sleep(3);
									}
									
									
									
									
									//echo $array_count;
									//$dataForSingleDate = $glob->{'2017-10-30'};
									//gets alphavantage price
									//echo "\n";
									//echo $glob->{'05. price'} . '';
									//Break out
									$the_price_now = null;
									//conpare global price quote
									//$json_obj = json_decode($responce);
									//$alpha_price =$json_obj['Global Quote'];
									//$the_price_now   =  $alpha_price->{'5. price'};
									//echo $alpha_price;
									//print_r($json_obj['Global Quote']);
									//$dec_price = '0.9000';
									//$the_price_now = '0.9000';
									//	echo"here";
									
									
									
										if ($the_price_now == null && $RUN_LIVE== TRUE){
									
									$dec_price       =  $trend_glob->{'1. open'} - $trade[4] ;
								
									
									
								
											if (	$LINK_CHOICE == "finviz"){
												if ($sim["sim"]==FALSE){
												$the_price_now = $finviz_price_now;
												}
												}
											if (!isset($the_price_now)){//if its not set
												$test_the_price_now 	=  $trend_glob->{'1. open'};
												$the_price_now   		=  $trend_glob->{'1. open'};
												}else{//if it is set
													if($finviz_price_now == $test_the_price_now){
														//all good
														
														}else{ }//to do some math to compare alpha to finviz
												
												
												
												}
											
										
										
									
									// $model .
									$model .= " $xmodel (GAIN : $GAIN_Percent  TIMESTAMP :".$atime_date[1]." FREQ : $FREQ  Adverages :$old_advs $old_a COUNT:". $base_count .")" ;
									
									//set data points in php - ml for price bits
									
									$sample_test = $_SESSION['ML_Training'][($trade[1])];
									if ($sample_test==""){
										
									$Sample_array = array( $GAIN_Percent  , $FREQ  ,$old_advs ,$old_a , $base_count );	
						
									
									$_SESSION['ML_Training'][($trade[1])] = $Sample_array;
									
									
									}
																		
									
									//if we dont have price data
									//	if (!isset($the_price_now))
									//	{break;}
										//echo "\n";
										//echo $the_price_now;
										include("c:/php/WWW/Stock_Market/LOOP/sell_risks.php");
										include("c:/php/WWW/Stock_Market/LOOP/buy_risks.php");																						
									

									
									
									if(isset($trend_glob)){

										
										
									
								}
								}
								
							
								}
								usleep($leep_B);
								
				}
				//mysqli_close($conn);	
			}
		
	}
	mysqli_close($loop_sub_conn);
}
//sleep(10000000000);
}