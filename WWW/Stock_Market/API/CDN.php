<?php
include('c:/php/WWW/Stock_Market/config.php');
//include("$SERVER_DIR/LOOP/logic_functions.php");
include("$SERVER_DIR/LOOP/all_starts_here.php");
$servername         = "127.0.0.1";
$username           = "root";
$dbname             = "stock_market_local";
$password           = "";


	$conn = MYSQL_CONNECTOR($servername, $username, $password, $dbname);
		$query = "SELECT * FROM `stock`";//lets see how the stocks we own are doing first
		//	$query = "SELECT * FROM `stock` DESC LIMIT 350";//lets see how the stocks we own are doing first

	
	$result=mysqli_query($conn,$query);



//$result = $db_con->query('SELECT * FROM `some_table`');
if (!$result) die('Couldn\'t fetch records');
$num_fields = mysql_num_fields($result);
$headers = array();
for ($i = 0; $i < $num_fields; $i++) {
    $headers[] = mysql_field_name($result , $i);
}
$fp = fopen('php://output', 'w');
if ($fp && $result) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="export.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    fputcsv($fp, $headers);
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        fputcsv($fp, array_values($row));
    }
    die;
}