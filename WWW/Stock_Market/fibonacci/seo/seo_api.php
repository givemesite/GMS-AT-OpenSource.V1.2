<?php
//seo_api

$use_rerun=true;
//include("$SERVER_DIR/fibonacci/seo/seo_investing_api_equities.php");
//include("$SERVER_DIR/fibonacci/seo/seo_investing_api_Service.php");
//include("$SERVER_DIR/fibonacci/seo/seo_investing_api_Service_YTD.php");


/////////////
//saves a index of top stocks with high gains
//
//
// used with investing.com
////////////
// Comp_Name, Last_Price, Day_High, Day_Low, Chg#, Chg %,Vol, UMT_Time


function TEST_VALS ($VALS= null){return strpos (  $VALS , '%' ,0 );return strpos ( $VALS , '+' ,0 );}










function set_stock_index($conn= null, 
$RENDER_id= null,
$ticker_name= null,$Buffer_comp_name= null,$price_now= null, 
												$day_high= null,
												$day_low= null,
												$Buffer_CHANGE_RATIO= null,
												$Buffer_CHANGE_PCT= null,
												$Buffer_CHANGE_VOL= null,
												$TIME= null,
												$aDataTableDetailHTML= null,
												$investing_table_count= null,
$servername= null, $username= null, $password= null, $dbname= null, $seo_api= null){
//Parse the Price now and parse the changing % and 
										
//clean up data 	
	//name	
$pattern = '/\?/';
$replacement = '';
$A_Buffer_comp_name= preg_replace($pattern, $replacement, $Buffer_comp_name);	
	$comp_name = str_replace(array("'","%","&","?",'?','┬á'),"",$A_Buffer_comp_name);													
	//%
	$comp_name=htmlentities ( $comp_name);
	$BUFFER_CHANGE_PCT = str_replace("+","",$Buffer_CHANGE_PCT);
	$CHANGE_PCT = str_replace("%","",$BUFFER_CHANGE_PCT);
	//do the same for the ratio
	$CHANGE_RATIO = str_replace("+","",$Buffer_CHANGE_RATIO);
	
//formating change %		


//fix the format so mysql can count the data
//first part of string
//format for mysql
$PME  = explode('.',$CHANGE_PCT);
$test_set = $PME[0];
$first_set = strlen ($test_set);
$string_content = array();


//echo $first_set;
if ($first_set ==1){
	$CHANGE_PCT = str_replace("0.","000.",$CHANGE_PCT);
	$CHANGE_PCT = str_replace("1.","001.",$CHANGE_PCT);
	$CHANGE_PCT = str_replace("2.","002.",$CHANGE_PCT);
	$CHANGE_PCT = str_replace("3.","003.",$CHANGE_PCT);
	$CHANGE_PCT = str_replace("4.","004.",$CHANGE_PCT);	
	$CHANGE_PCT = str_replace("5.","005.",$CHANGE_PCT);
	$CHANGE_PCT = str_replace("6.","006.",$CHANGE_PCT);
	$CHANGE_PCT = str_replace("7.","007.",$CHANGE_PCT);
	$CHANGE_PCT = str_replace("8.","008.",$CHANGE_PCT);
	$CHANGE_PCT = str_replace("9.","009.",$CHANGE_PCT);	
}
if ($first_set ==2){
$CHANGE_PCT = '0' . $CHANGE_PCT; 
}
//dont add the item if theres no data set or its in the wrong place
//if  (!isset() ||==null||<>) {}
//find the "data not aval"
//if (){}

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
//quantitative analytics
$quant_price        = 0;
$quant_price_change = 0;
$quant_vol          = 0;
$quant_change       = 0;
//mysql data driver

$expedite=null;

	$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);

		//what is the site or http proxy
	if ($seo_api<>null && $seo_api<>''){
		
		//if its not set put it in the basic table stock 
		//investing 
		//yahoo
		//Google top stocks
	}
	
	else{
		
		
	}

	//lets expedite what we are looking for 
			$query = "SELECT * FROM `stock` WHERE `expedite`>='0'";//see if we have this stock
	if ($result=mysqli_query($conn,$query)){ 
	// Fetch one and one row
	while ($row=mysqli_fetch_row($result))
		{
	
	$expedite_row = $row[0];
	
	//print_r($row);
	//sleep(30000);
	$expedite= TRUE;
	}}
	mysqli_close($conn);	
		$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
	//see if we have this row in the table
		$query = "SELECT * FROM `stock` WHERE `name`='".$comp_name."'";//see if we have this stock
	if ($result=mysqli_query($conn,$query)){ 
	// Fetch one and one row
	while ($row=mysqli_fetch_row($result))
		{
		//test
			// var_dump($row);
	if ($expedite<>null){ if($expedite_row<>$row[0]){//continue;
	}else{
		//update the row so we dont re try to expedite
		$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		$sql = "UPDATE `stock` SET `expedite` = '0' WHERE id = ".$row[0]."";
if (mysqli_query($conn, $sql)) {
   // echo "\n\n Stock ". $row[2]." had been expedited in the dataset  \n";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);
		
	}
	}
		 
////////////////////////////////////////////////////
////////////////////////////////////////////////////		 
////////////////////////////////////////////////////		 
//
//		This script is used to plan the 
//		investment times 
//
//it finds the momentum of the stock
//and will setup a investment strgatry 
		 
				 
////////////////////////////////////////////////////
////////////////////////////////////////////////////
////////////////////////////////////////////////////
		 
			investing_planner (
$RENDER_id,     //the row this item is on 
$row, 			//mysql row data 
$trading_name,  //The Ticker Symbol
$comp_name,			//comp name
$price_now,	// the price from investing.com
$DAY_HIGH,	// 
$DAY_LOW,	//
$CHANGE_PCT,
$MOVING_ADV,//
$CAP,		//

$BUY_PRICE,

$ADV,$conn
			);
	
	
	$NotAStock = null;
	
	//if the id dosnt not equle its placement 	
	if ($row[0]== $RENDER_id){
		
		
	}else{
		
		
	}
	
	
	//$A_Ticker_investing_table_count = $investing_table_count - 8; //symb

	
	
	//find ticker symbol and set it 
	
	//this has some parts of the fail safes in it 
         //if there is none set it 


	


	


//end of finding current stock loop
		}
	}
	//	mysqli_close($conn);

		
//end of finding stock by name		
		
		
		
		
/////////////
/////////////
//update
//data
//
/////////////
		//	UPDATE_DATABASE($conn, 
//$RENDER_id,
//$ticker_name,$Buffer_comp_name,$price_now, 
//												$day_high,
///												$day_low,
//												$Buffer_CHANGE_RATIO,
//												$Buffer_CHANGE_PCT,
//												$Buffer_CHANGE_VOL,
//												$TIME,
//												$aDataTableDetailHTML,
//												$investing_table_count,
//$servername, $username, $password, $dbname, $seo_api);
			$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
	if ($is_a_stock== true && $set_stock==true){
		//$trading_name= 'test';
		// Attempt update query execution
		$time = time();
			$sql = "UPDATE stock SET name='".$comp_name."',price='".$price_now."',day_low='".$day_low."',day_high='".$day_high."',CHANGE_PCT='".$CHANGE_PCT."',CHANGE_RATIO='".$CHANGE_RATIO."',CHANGE_VOL='".$Buffer_CHANGE_VOL."',TIME='".$time."',PLACEMENT='".$RENDER_id."' WHERE id=".$UPDATE_ROW;
			if(mysqli_query($conn, $sql)){
							echo "Records were updated successfully. \n";
			} else {
							echo "ERROR: Could not update, unable to execute $sql. " . mysqli_error($conn) ."\n";
			}
 
		}
							mysqli_close($conn);
		
		
		
		
			$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
	
	//see if we have this row in the table
		$query = "SELECT * FROM `stock` WHERE `id`='".$RENDER_id."'";//see if we have this stock
	if ($result=mysqli_query($conn,$query)){ 
	// Fetch one and one row
	while ($row=mysqli_fetch_row($result))
	{
		//see if the stock is in the same placement 
		if ($row[2]==$comp_name){
			echo "Same Placement  \n";
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
	//$comp_name = substr($comp_name, 0, 8);
	$has_a = stripos($comp_name, '+');
	$has_a .= stripos($comp_name, '%');
	$has_a .= stripos($comp_name, '.');
	
	$string = $comp_name;
//With this pattern you found everything except 0-9a-zA-Z
$array = str_split($string);

foreach($array as $key => $letter){
   if($letter == '+'){
      $new_string= 1;
   }  
      if($letter == '%'){
      $new_string= 1;
   }  
      if($letter == '.'){
      $new_string= 1;
   }  
   else{
    //  $new_string.= $letter;  
   }
}

if($new_string > 0 )
{$NotAStock=false;}
if ($NotAStock==true ){
	
 $time = time();
$sql = "INSERT INTO stock ( name, price, day_low, day_high, CHANGE_RATIO, CHANGE_PCT, CHANGE_VOL, TIME, PLACEMENT, OLD_PLACEMENT, trading_name)
VALUES ( '$comp_name', '$price_now', '$day_low','$day_high','$CHANGE_RATIO','$CHANGE_PCT','$Buffer_CHANGE_VOL', '$time', '$RENDER_id', '$RENDER_id', '$ticker_name')";
if (mysqli_query($conn, $sql)) {
    echo "New stock created successfully \n";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);
usleep(300);
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
//mysqli_close($conn);


	
////////////
//end of function
////////////
}





