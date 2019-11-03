<?php

namespace Cloudmanic\RobinHood;
  
use GuzzleHttp\Client;
  
class RobinHoodObj
{
  private $token = null;
  private $errors = [];
  
  // Different endpoints we can call for the API.
  private $endpoints = [
    'login' => 'https://api.robinhood.com/api-token-auth/',
    'investment_profile' => 'https://api.robinhood.com/user/investment_profile/',
    'accounts' => 'https://api.robinhood.com/accounts/',
    'ach_iav_auth' => 'https://api.robinhood.com/ach/iav/auth/',
    'ach_relationships' => 'https://api.robinhood.com/ach/relationships/',
    'ach_transfers' => 'https://api.robinhood.com/ach/transfers/',
    'applications' => 'https://api.robinhood.com/applications/',
    'dividends' => 'https://api.robinhood.com/dividends/',
    'edocuments' => 'https://api.robinhood.com/documents/',
    'instruments' => 'https://api.robinhood.com/instruments/',
    'margin_upgrades' => 'https://api.robinhood.com/margin/upgrades/',
    'markets' => 'https://api.robinhood.com/markets/',
    'notifications' => 'https://api.robinhood.com/notifications/',
    'orders' => 'https://api.robinhood.com/orders/',
    'password_reset' => 'https://api.robinhood.com/password_reset/request/',
    'quotes' => 'https://api.robinhood.com/quotes/',
    'document_requests' => 'https://api.robinhood.com/upload/document_requests/',
    'user' => 'https://api.robinhood.com/user/',
    'watchlists' => 'https://api.robinhood.com/watchlists/'
  ];
  
  //
  // Set the token. This is useful so we do not have to call the auth function all the time.
  //
  public function set_token($token)
  {    
    $this->token = $token; 
  }
  
  //
  // Send a username and password to Robinhood to get back a token.
  //
  public function auth($username, $password)
  {
    $client = new Client();    
    
    // Make API Call
    $res = $client->post($this->endpoints['login'], [
      'form_params' => [
        'username' => $username,
        'password' => $password
      ],
      
      'headers' => [
        'Accept' => '*/*',
        'Accept-Encoding' =>'gzip, deflate',
        'Accept-Language' => 'en;q=1, fr;q=0.9, de;q=0.8, ja;q=0.7, nl;q=0.6, it;q=0.5',
        'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8',
        'X-Robinhood-API-Version' => '1.0.0',
        'Connection' => 'keep-alive',
        'User-Agent' => 'Robinhood/823 (iPhone; iOS 7.1.2; Scale/2.00)'
      ]     
    ]);

    // Make sure the API returned happy.
    if($res->getStatusCode() != '200')
    {
      $this->errors[] = 'auth(): Robinhood API did not return a status code of 200. (' . $res->getStatusCode() . ')';
      return false;
    }

    // Decode the response.
    $json = $res->getBody();
    $rt = json_decode($json, true);
    
    // Make sure we have a token.
    if(! isset($rt['token']))
    {
      $this->errors[] = 'auth(): Robinhood API did not return a valid token.';
      return false;      
    }
    
    // Set the token we just received.
    $this->set_token($rt['token']); 

    // Just for fun return the token.
    return $rt['token'];
  }
  
  //
  // Return the accounts of the user.
  //
  public function get_accounts()
  {
    return $this->_send_request($this->endpoints['accounts'], 'get_accounts()');
  }
  
  //
  // Return an account of the user.
  //
  public function get_account($url)
  {
    return $this->_send_request($url, 'get_account()');
  }  
  
  //
  // Returns the porfillo summery of an account by url.
  //
  public function get_portfolio_summery($url)
  {
    return $this->_send_request($url, 'get_portfolio()'); 
  }  
  
  //
  // Return the positions. We pass in the positions URL we get from the get_accounts() request.
  // This is sort of a heavy call as it makes many API calls to populate all the data.
  //
  public function get_current_positions($url)
  {
    $rt = [];
    
    // Get the positions.
    $pos =  $this->_send_request($url, 'get_postions()'); 
    
    // Now loop through and get the ticker information.
    foreach($pos['results'] AS $key => $row)
    {
      // We ignore past stocks that we traded.
      if($row['quantity'] > 0)
      {
        // Get the details of the instrument
        $pos['results'][$key]['instrument_data'] = $this->_send_request($row['instrument'], 'get_postions()');
        
        // Get the current quoted price for this instrument.
        $pos['results'][$key]['instrument_data']['quote_data'] = $this->_send_request($pos['results'][$key]['instrument_data']['quote'], 'get_postions()');
        
        // Add on to the new array.
        $rt[] = $pos['results'][$key];
      }
    }
    
    return $rt;
  }
  
  // ---------------- Private Helper Functions --------------- //
  
  //
  // Send request to API.
  //
  private function _send_request($url, $func)
  {
    // Make sure we have a token.
    if(is_null($this->token))
    {
      $this->errors[] = $func . ': No API token set. Please authorize by using auth().';
      return false;      
    }
    
    // Setup request client. 
    $client = new Client();   
    
    // Make API call.
    $res = $client->get($url, [
      'headers' => [
        'Accept' => '*/*',
        'Accept-Encoding' =>'gzip, deflate',
        'Accept-Language' => 'en;q=1, fr;q=0.9, de;q=0.8, ja;q=0.7, nl;q=0.6, it;q=0.5',
        'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8',
        'X-Robinhood-API-Version' => '1.0.0',
        'Connection' => 'keep-alive',
        'User-Agent' => 'Robinhood/823 (iPhone; iOS 7.1.2; Scale/2.00)',
        'Authorization' => 'Token ' . $this->token
      ]
    ]);
    
    // Make sure the API returned happy.
    if($res->getStatusCode() != '200')
    {
      $this->errors[] = $func . ': Robinhood API did not return a status code of 200. (' . $res->getStatusCode() . ')';
      return false;
    } 
    
    // Decode the response.
    $json = $res->getBody();
    $rt = json_decode($json, true);    
    
    // Return happy.
    return $rt;    
  }
}

/* End File */