<?php

include('c:/php/WWW/Stock_Market/config.php');
include('c:/php/WWW/Stock_Market/LOOP/all_starts_here.php');

/////////////
//saves a index of top stocks with high gains
//
////////////
$company_name =	$comp_name. 'hp stock';
$q = str_replace(" ","+",$company_name) ;
if ($q == "" || $q == null){
	$q ="hewlett+packard";
}
$url = "https://www.google.com/search?&q=" . $q ."&oq=" . $q;
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36'
    ));
$html = curl_exec($ch);
//curl_close($ch);




# Create a DOM parser object
$dom = new DOMDocument();
libxml_use_internal_errors(true);

$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
$c=1;

	$Header = $dom->getElementsByTagName('div');
	$Detail = $dom->getElementsByTagName('span');

    //#Get header name of the table
	foreach($Header as $NodeHeader) 
	{
		$aDataTableHeaderHTML[] = trim($NodeHeader->textContent);
	}
	//print_r($aDataTableHeaderHTML); die();

	//#Get row data/detail table without header name as key
	$i = 0;
	$j = 0;
	foreach($Detail as $sNodeDetail) 
	{
		$aDataTableDetailHTML[$j][] = trim($sNodeDetail->textContent);
		$i = $i + 1;
		$j = $i % count($aDataTableHeaderHTML) == 0 ? $j + 1 : $j;
	}
	$stock_ticker = null;
	$stock_symb   = null;
for ($x = 0; $x <= 500;$x++) {	
	//$aDataTableDetailHTML[$x];
//	echo $aDataTableDetailHTML[0][$x];
	if ($aDataTableDetailHTML[0][$x] == "Stock price:"){
		$stock_ticker= 	$aDataTableDetailHTML[0][$x+1];
		//	echo$stock_symb;
	}
	
}
print_r($aDataTableDetailHTML[0]);
 die();

	$stock_symb = explode (': ', $aDataTableDetailHTML[0][21]);
	return $stock_symb[1];




echo GetStockSymb ('HP');die(); 	









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
$servername, $username, $password, $dbname
												){
$servername         = "127.0.0.1";
$username           = "root";
$password           = "";
$dbname             = "stock_market_local";
	$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
	
		$query = "SELECT * FROM `stock` WHERE `name`='".$comp_name."'";//see if we have this stock
	if ($result=mysqli_query($conn,$query)){ 
	// Fetch one and one row
	while ($row=mysqli_fetch_row($result))
		{// var_dump($row);
	
	//Moving ADV
	if ($row[12]>$mysql_id){
		//
		
	}   //Same
		if ($row[12]==$mysql_id){
		//
		
	}//moving adv lower
	if ($row[12]<$mysql_id){
		
	}
	//
	//
	//
	
	//find ticker symb
         
		 if ($row[1]=='' || !isset($row[1]) || $row[1] == null){
//die();

		 }

	
			$_SESSION["search"] = $row[1];
			echo "Found : " . $row[1].'\n';
			//
			echo " \n FOUND OLD ROW ";
			//   printf ("%s (%s)\n  ",$row[0],$row[0]);
			$_SESSION["stock"] = $comp_name;
			//update price-now

//	investing_planer (
//$mysql_id,
//$row[1]
//);

		}
		
		
//$trading_name =  GetStockSymb ($comp_name); 	
		
 var_dump($trading_name); 

//////////
//add stock to local index
//
//////////
 $time = time();
$sql = "INSERT INTO stock (id, name, price, day_low, day_high, CHANGE_PCT, CHANGE_RATIO, CHANGE_VOL, TIME, PLACEMENT, trading_name)
VALUES ('$mysql_id', '$comp_name', '$price_now', '$day_low','$day_high','$CHANGE_PCT','$CHANGE_RATIO','$CHANGE_VOL', '$time', '$mysql_id', '$trading_name')";
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully \n";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


	
	
	
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
 
 

// Attempt update query execution
//$sql = "UPDATE stock SET name='peterparker_new@mail.com' WHERE id=2";
if(mysqli_query($conn, $sql)){
    echo "Records were updated successfully. \n";
} else {
    echo "ERROR: Could not update, unable to execute $sql. " . mysqli_error($conn) ."\n";
}
 
	
	
	
	// Close connection
//mysqli_close($conn);
}
else{
	
	
	
	
}

////////////
//end of function
////////////
}




function GetStockSymb ($comp_name){
$company_name =	$comp_name. ' stock';
$q = str_replace(" ","+",$company_name) ;
if ($q == "" || $q == null){
	$q ="hewlett+packard";
}
$url = "https://www.google.com/search?&q=" . $q ."&oq=" . $q;
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36'
    ));
$html = curl_exec($ch);
//curl_close($ch);




# Create a DOM parser object
$dom = new DOMDocument();
libxml_use_internal_errors(true);

$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
$c=1;

	$Header = $dom->getElementsByTagName('div');
	$Detail = $dom->getElementsByTagName('span');

    //#Get header name of the table
	foreach($Header as $NodeHeader) 
	{
		$aDataTableHeaderHTML[] = trim($NodeHeader->textContent);
	}
	//print_r($aDataTableHeaderHTML); die();

	//#Get row data/detail table without header name as key
	$i = 0;
	$j = 0;
	foreach($Detail as $sNodeDetail) 
	{
		$aDataTableDetailHTML[$j][] = trim($sNodeDetail->textContent);
		$i = $i + 1;
		$j = $i % count($aDataTableHeaderHTML) == 0 ? $j + 1 : $j;
	}
	$stock_ticker = null;
	$stock_symb   = null;
for ($x = 0; $x <= 500;$x++) {	
	//$aDataTableDetailHTML[$x];
//	echo $aDataTableDetailHTML[0][$x];
	if ($aDataTableDetailHTML[0][$x] == "Stock price:"){
		$stock_ticker= 	$aDataTableDetailHTML[0][$x+1];
		//	echo$stock_symb;
	}
	
}
print_r($html);
 die();

	$stock_symb = explode (': ', $aDataTableDetailHTML[0][19]);
	return $stock_symb[1];
}

