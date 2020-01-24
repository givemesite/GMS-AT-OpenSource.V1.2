<?php
	ini_set('display_errors', '0');
	set_time_limit ( 30000000000000000000000000 );
	
//kris galante krisgcell@gmail.com
$key_secret = "C:/php/www/Stock_Market/API/api.KEY"; // I was running the code on localhost, and hence the path!
$dir = 'c:/php/www/Stock_Market/TRAINING_SETS/';
$targets_dir = 'c:/php/www/Stock_Market/TARGETS/';


$filepath = 'c:/php/www/Stock_Market/ML/model.data';

$pSamples_dir = 'c:/php/www/Stock_Market/SAMPLE_potential/';
$Ptargets_dir = 'c:/php/www/Stock_Market/TARGET_potential/';
$BUYSamples_dir = 'c:/php/www/Stock_Market/BUY_SAMPLES/';
$BUYtargets_dir = 'c:/php/www/Stock_Market/BUY_TARGETS/';
$SELLSamples_dir = 'c:/php/www/Stock_Market/SELL_SAMPLES/';
$SELLtargets_dir = 'c:/php/www/Stock_Market/SELL_TARGETS/';
$id 			= $_POST['id'];
$array_a		= $_POST['array_a'];
$array_b 		= $_POST['array_b'];
$key 			= $_POST["API"];
$post_predict 	= $_POST["predict"];
$train 			= $_POST['TRAIN'];
$hash_sim 		= $_POST['hash_sim'];
//$Prop_nuron_lan = 50;
//$LEARN_DEPH_MUX = 03;

$skip_lan = 10;
$loop_array = array(
"3" => "120",
"7" => "130",
"8" => "140",
"9" => "150",
"10" => "150",
"11" => "170",
"12" => "236"
);

	$api_key	= file_get_contents($key_secret);
if ("$key" <> "$api_key"){
	DIE('BAD POST KEY!');
}





require_once __DIR__ . '/vendor/autoload.php';
use Phpml\Regression\LeastSquares;

use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;

//use Phpml\ModelManager;

//$samples = [[60], [61], [62], [63], [65]];
//$targets = [3.1, 3.6, 3.8, 4, 4.1];

/*
$kernel (int) - kernel type to be used in the algorithm (default Kernel::RBF)
$degree (int) - degree of the Kernel::POLYNOMIAL function (default 3)
$epsilon (float) - epsilon in loss function of epsilon-SVR (default 0.1)
$cost (float) - parameter C of C-SVC (default 1.0)
$gamma (float) - kernel coefficient for ‘Kernel::RBF’, ‘Kernel::POLYNOMIAL’ and ‘Kernel::SIGMOID’. If gamma is ‘null’ then 1/features will be used instead.
$coef0 (float) - independent term in kernel function. It is only significant in ‘Kernel::POLYNOMIAL’ and ‘Kernel::SIGMOID’ (default 0.0)
$tolerance (float) - tolerance of termination criterion (default 0.001)
$cacheSize (int) - cache memory size in MB (default 100)
$shrinking (bool) - whether to use the shrinking heuristics (default true)

*/
//$regression = new LeastSquares();
$regression = new SVR(Kernel::LINEAR);

//$modelManager = new ModelManager();

//$regression = new SVR(Kernel::POLYNOMIAL, 3, 0.1, 10,0.3,0.1,3,1000,true); 
//if($hash_sim["sim"]==TRUE){
	
	
	
	
//for($learn_depth=03; $learn_depth <= $LEARN_DEPH_MUX;$learn_depth++){
foreach ($loop_array as $learn_depth => $Prop_nuron_lan){
	//echo$learn_depth;
	
	
for ( $Prop_nuron_count=1 ;  $Prop_nuron_count <= $Prop_nuron_lan;$Prop_nuron_count++){
	$test_nuron_count = $Prop_nuron_count + $skip_lan;
	
	if ($Prop_nuron_count < $Prop_nuron_lan && $test_nuron_count<$Prop_nuron_lan &&
	file_exists(($BUYSamples_dir."BUY-".$learn_depth."-".$Prop_nuron_count.".json")) &&
	file_exists(($BUYtargets_dir."BUY-".$learn_depth."-".$Prop_nuron_count.".json"))
	){
	$Prop_nuron_count = $Prop_nuron_count + $skip_lan;
	
	
	
	
	$file_handle = fopen(($BUYSamples_dir."BUY-".$learn_depth."-".$Prop_nuron_count.".json"), "r");
$line = null;
$Tsamples = null;
while (!feof($file_handle)) {
   $line = fgets($file_handle);
   $Tsamples.=  $line;
   
   
}

	$file_handle = fopen(($BUYtargets_dir."BUY-".$learn_depth."-".$Prop_nuron_count.".json"), "r");
$pline = null;
$Targets = null;
while (!feof($file_handle)) {
   $pline = fgets($file_handle);
   $Targets.=  $pline;
   
   
}

fclose($file_handle);
	$sample = json_decode($Tsamples);
	//print_r($sample[0]);
	$targets = [ json_decode($Targets)];


$Xsample[0]=$sample[0][0];
$Xsample[1]=(int)$sample[0][1];
$Xsample[2]=(int)$sample[0][2];
$Xsample[3]=(int)$sample[0][3];
$Xsample[4]=(int)$sample[0][4];
$Xsample[5]=(int)$sample[0][5];
$Xsample[6]=(int)$sample[0][6];
$Xsample[7]=(int)$sample[0][7];
//print_r($Xsample);

$regression->train([$Xsample], $targets);
	}	
}





}
//}


//if we are in a simulation 
//$sim["sim"]==FALSE
if($hash_sim["sim"]==TRUE){
//$modelManager->saveToFile($regression, $filepath);
}
else{
//if not load from file
//$regression = $modelManager->restoreFromFile($filepath);
}

$predict = json_decode(($post_predict));

//print_r($predict[0]);
//$predict = 3.99;






//return predict num price it might move up to
$arr = array($regression->predict(  $predict ));  // ["1.14"]//$predict

$o= json_encode    ($arr);
echo($o);