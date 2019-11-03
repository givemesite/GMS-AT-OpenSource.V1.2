<?php

include('c:/php/WWW/Stock_Market/config.php');
include('c:/php/WWW/Stock_Market/LOOP/all_starts_here.php');
include('c:/php/WWW/Stock_Market/fibonacci/seo/seo_investing_api_equities.php');
/////////////
//saves a index of top stocks with high gains
//
//
// used with investing.com
////////////
// Comp_Name, Last_Price, Day_High, Day_Low, Chg#, Chg %,Vol, UMT_Time

function set_stock_index($conn, 
$mysql_id,
$ticker_name,$comp_name,$price_now, 
												$day_high,
												$day_low,
												$CHANGE_PCT,
												$CHANGE_RATIO,
												$CHANGE_VOL,
												$TIME,
												$aDataTableDetailHTML,
$servername, $username, $password, $dbname, $seo_api
												){
//stuff to connect to mysql													
//Function vars
$SameResult_Set=null;
$is_a_stock= null;
$set_stock= true;
$NotAStock = true;											
$servername         = "127.0.0.1";
$username           = "root";
$password           = "";
$dbname             = "stock_market_local";
//mysql data driver
	$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);

		//what is the site or http proxy
	if ($seo_api<>null && $seo_api<>''){
		
		//if its not set put it in the basic table stock 
		//investing 
		//yahoo
		//google top stocks
	}
	
	else{}
	//get the row and delete the row in the table that is older then this one 

	
	//see if we have this row in the table
		$query = "SELECT * FROM `stock` WHERE `name`='".$comp_name."'";//see if we have this stock
	if ($result=mysqli_query($conn,$query)){ 
	// Fetch one and one row
	while ($row=mysqli_fetch_row($result))
		{
		//test
			// var_dump($row);
	
	//Set some vars for the triggers 
	if($row[1]<>null && $row[1]<>''){
		$is_a_stock=true;
	}
	
	$NotAStock = null;
	
	
	/////////////////////////////////////////////////
	/////////////////////////////////////////////////
	/////////////////////////////////////////////////
	//
	//		Test for where the item is in the list
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
	//Moving ADV - moving to top of list 
	if ($mysql_id<$row[12]){
		//
		
	}   //Same - no change  
		if ($mysql_id==$row[12]){$SameResult_Set=true;// trigger do nothing
		//continue;
		}
		//moving adv higher with same ADV
	if ($mysql_id<=$row[12]){
		
		
	}
	
	//Find stocks that are not doing so well 
	
	//Moving ADV
	if ($row[12]<$mysql_id){
		//stock was lower on list
		
	}   
	
	
	
	
	//Parse the Price now and parse the changing % and adv
	$BUFFER_CHANGE_PCT = explode();
	$BUFFER_CHANGE_PCT = explode("",$BUFFER_CHANGE_PCT);
	$BUFFER_CHANGE_PCT = explode("",$BUFFER_CHANGE_PCT[1]);
	$BUFFER_CHANGE_RATIO = explode("",$BUFFER_CHANGE_RATIO);
	$CHANGE_PCT = $BUFFER_CHANGE_PCT[1];
	
	
	
	
	//find ticker symbol
         //if there is none set it 
		 if (!isset($row[1]) || $row[1]==''){
//die();
$A_Ticker_investing_table_count = $mysql_id  + 449;
$C_SYMB=   investing_symb_lookup("",$aDataTableDetailHTML[0][3]['seo_data'][$A_Ticker_investing_table_count]);
//$C_SYMB = 'test';
$sql = "UPDATE stock SET trading_name = '". $C_SYMB. "' WHERE id = ".$mysql_id;
			if(mysqli_query($conn, $sql)){
							echo "Records were updated successfully. \n set $C_SYMB ";
			} else {
							echo "ERROR: Could not update, unable to execute $sql. " . mysqli_error($conn) ."\n";
			}
			//only update once at a time
			$set_stock= null;
 mysqli_close($conn);
		}
	
		 

	
			$_SESSION["search"] = $row[1];
			echo "Found : " . $row[1].'\n';
			//
			echo " \n FOUND OLD ROW ";
			//   printf ("%s (%s)\n  ",$row[0],$row[0]);
			$_SESSION["stock"] = $comp_name;
			//update price-now

			investing_planer (
					$mysql_id,
					$row[1]
			);

		 if ( isset($row)){
				//die();
			$NotAStock = null;
		 }		

//end of finding current stock loop
		}
	}
		mysqli_close($conn);

		
//end of finding stock by name		
		
		
			$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
	
	//see if we have this row in the table
		$query = "SELECT * FROM `stock` WHERE `id`='".$mysql_id."'";//see if we have this stock
	if ($result=mysqli_query($conn,$query)){ 
	// Fetch one and one row
	while ($row=mysqli_fetch_row($result))
	{
		//see if the stock is in the same placement 
		if ($row[2]==$comp_name){
			echo "Same Placement ";
		}
	}}
			mysqli_close($conn);
			
			
			
			
		
		$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
	
		
	//set the stocks trading name 	

		if ($trading_name==""|| $trading_name==null){
		$trading_name == "NONE";
		}
//var_dump($trading_name); 

//////////
//add stock to local index
//
//////////
if ($NotAStock==true ){
 $time = time();
$sql = "INSERT INTO stock (id, name, price, day_low, day_high, CHANGE_RATIO, CHANGE_PCT, CHANGE_VOL, TIME, PLACEMENT, trading_name)
VALUES ('$mysql_id', '$comp_name', '$price_now', '$day_low','$day_high','$CHANGE_PCT','$CHANGE_RATIO','$CHANGE_VOL', '$time', '$mysql_id', '$trading_name')";
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully \n";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);

}

/////////////
/////////////
//update
//data
//
/////////////

	if ($is_a_stock== true && $set_stock==true){
		//$trading_name= 'test';
		// Attempt update query execution
$sql = "UPDATE stock SET name='".$comp_name."',price='".$price_now."',day_low='".$day_low."',day_high='".$day_high."',CHANGE_RATIO='".$CHANGE_RATIO."',CHANGE_PCT='".$CHANGE_PCT."',CHANGE_VOL='".$CHANGE_VOL."',TIME='".$time."',PLACEMENT='".$mysql_id."' WHERE id=".$mysql_id;
			if(mysqli_query($conn, $sql)){
							echo "Records were updated successfully. \n";
			} else {
							echo "ERROR: Could not update, unable to execute $sql. " . mysqli_error($conn) ."\n";
			}
 
		}
	
	
	
	
/////////////
/////////////
//Error
//handle
//
/////////////	
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 else{

	
	
}
// Close connection
mysqli_close($conn);


	
////////////
//end of function
////////////
}





