

<?php
$req_url = 'https://developers.tradeking.com/oauth/request_token';
$authurl = 'https://developers.tradeking.com/oauth/authorize';
$acc_url = 'https://developers.tradeking.com/oauth/access_token';
$api_url = 'https://api.tradeking.com';
$conskey = '';
$conssec = '';

session_start();

// In state=1 the next request should include an oauth_token.
// If it doesn't go back to 0
if(!isset($_GET['oauth_token']) && $_SESSION['state']==1) $_SESSION['state'] = 0;
try {
  $oauth = new OAuth($conskey,$conssec,OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_URI);
  $oauth->enableDebug();
  $oauth->disableSSLChecks();
 //  var_dump($oauth);
  
  
  if(!isset($_GET['oauth_token']) && !$_SESSION['state']) {
    $request_token_info = $oauth->getRequestToken($req_url);
    $_SESSION['secret'] = $request_token_info['oauth_token_secret'];
    $_SESSION['state'] = 1;
    header('Location: '.$authurl.'?oauth_token='.$request_token_info['oauth_token']);
   //  var_dump($oauth);
	exit;
  } else if($_SESSION['state']==1) {
    $oauth->setToken($_GET['oauth_token'],$_SESSION['secret']);
    $access_token_info = $oauth->getAccessToken($acc_url);
    $_SESSION['state'] = 2;
    $_SESSION['token'] = $access_token_info['oauth_token'];
    $_SESSION['secret'] = $access_token_info['oauth_token_secret'];
  // var_dump($oauth);
  } 
  $oauth->setToken($_SESSION['token'],$_SESSION['secret']);
  $oauth->fetch("$api_url/v1/market/toplists/topgainers.xml?exchange=N");
   print_r($oauth->getLastResponse());
  $json = json_decode($oauth->getLastResponse());
 // print_r($json);
} catch(OAuthException $E) {
 var_dump($oauth); //print_r($E);
}
?>
<?php
  // This is using the PHP OAuth extension.
  // http://www.php.net/manual/en/book.oauth.php
  // Your keys/secrets for access
  $consumer_key     = '';
  $consumer_secret  = '';
  $access_token     = '';
  $access_secret    = '';
  try {
    // Setup an OAuth consumer
    $oauth = new OAuth($consumer_key,$consumer_secret,OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_AUTHORIZATION);
    // Manually update the access token/secret.  Typically this would be done through an OAuth callback when 
    // authenticating other users.
    $oauth->setToken($access_token,$access_secret);
    // Make a request to the API endpoint
    $oauth->fetch("https://api.tradeking.com/v1/market/toplists/topgainers.xml");
    // Handle the response
    $response_info = $oauth->getLastResponseInfo();
    // header("Content-Type: {$response_info["content_type"]}");
	
    echo $oauth->getLastResponse();
  } catch(OAuthException $E) {
    // Display any errors
    echo "Exception caught!\n";
    echo "Response: ". $E->lastResponse . "\n";
  }
?>