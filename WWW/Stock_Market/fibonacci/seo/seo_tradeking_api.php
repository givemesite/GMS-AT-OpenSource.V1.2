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
	//$OAuth->setCAPath ((

	//)) ;
    // Manually update the access token/secret.  Typically this would be done through an OAuth callback when 
    // authenticating other users.
    $oauth->setToken($access_token,$access_secret);
	$oauth->disableSSLChecks(); 
    // Make a request to the API endpoint
/*
A:	American Stock Exchange
N:	New York Stock Exchange
Q:	NASDAQ
U:	NASDAQ Bulletin Board
V:	NASDAQ OTC Other
*/
	
	
    $oauth->fetch("https://api.tradeking.com/v1/market/toplists/topgainers.json?exchange=Q");
    // Handle the response
    $response_info = $oauth->getLastResponseInfo();
    // header("Content-Type: {$response_info["content_type"]}");
    echo $oauth->getLastResponse();
  } catch(OAuthException $E) {
    // Display any errors
    echo "Exception caught!\n";
	
	var_dump($E);
	
    echo "Response: ". $E->lastResponse . "\n";
  }
  
  
  
  
  