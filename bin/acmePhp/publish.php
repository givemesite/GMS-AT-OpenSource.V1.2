<?php


echo " WinNMP ACME PHP token publisher\r\n";

function problem($msg='') {
	$usage="\r\n  USAGE:> acmePhp publish [domain] [WinNMPProject]\r\n";
	die("ERROR: $msg!$usage");
}


$argc=&$_SERVER['argc'];
$argv=&$_SERVER['argv'];
if ($argc <= 2) problem("Invalid number of arguments");


$dom=idn_to_ascii($argv[1] , IDNA_USE_STD3_RULES , INTL_IDNA_VARIANT_UTS46, $ok); //IDNA_USE_STD3_RULES   IDNA_DEFAULT
if (!empty($ok['isTransitionalDifferent'])) problem("idn_to_ascii possibly inconsistent :".$ok['result']);
if (!$dom) problem("Invalid Domain");

//._-1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz
$prj=preg_replace("|[^\w\d._-]|", '', $argv[2]);
if (!$prj) problem("Invalid Project");



echo "Domain: $dom\r\n";
echo "Project: $prj\r\n";


$domDir=realpath(__DIR__."/../../conf/.acmephp/master/private/$dom");

if (!$domDir || !is_dir($domDir)) problem("Domain $dom not found. Try < acmePhp authorize $dom > first");

$domJson=realpath(__DIR__."/../../conf/.acmephp/master/private/$dom/authorization_challenge.json");

if (!$domJson || !file_exists($domJson)) problem("unable to find $dom/authorization_challenge.json");

$txt=file_get_contents($domJson);
$json=json_decode($txt,true);

if (empty($json['domain']) || $json['domain']!=$dom) problem("JSON domain missmach");
if (empty($json['token']) || empty($json['payload'])) problem("JSON data invalid");

$token=$json['token'];
$payload=$json['payload'];
unset($json);

$prjConf=realpath(__DIR__."/../../conf/domains.d/$prj.conf");
if (!$prjConf || !file_exists($prjConf)) problem("Project $prj config file not found. Create the project in WinNMP Manager");

$txt=file_get_contents($prjConf);
if (!preg_match( '|(*ANYCRLF)^\s+root\s+"([^"]+)"|im' , $txt , $m)) problem("Unable to find the project`s root directive in the config file");
$prjRoot=$m[1];
if (!$prjRoot || !is_dir($prjRoot)) problem("Project directory <$prjRoot> dose not exist");

mkdir("$prjRoot/.well-known/acme-challenge",null,true);
file_put_contents("$prjRoot/.well-known/acme-challenge/$token",$payload,LOCK_EX);

echo "\r\n";
echo " SUCCESS! \r\n";
echo "  NOW EXECUTE < acmePhp check $dom >\r\n";


?>