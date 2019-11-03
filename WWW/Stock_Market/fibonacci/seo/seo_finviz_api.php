<?php
	/*
		
		seo  api 
		investing
		
		this collects some data from the INTERNET
	*/
	
	session_start();
	# Create a DOM parser object
	$dom = new DOMDocument();
	libxml_use_internal_errors(true);
	
	
	///////////////////////////////////////////////////
	///////////////////////////////////////////////////
	///////////////////////////////////////////////////
	//Function to turn curl data from html 
	//(table & HREF) into an array
	//
	//
	//
	//
	//
	//
	///////////////////////////////////////////////////
	///////////////////////////////////////////////////
	///////////////////////////////////////////////////
	
	
	
	
	function old_FINVIZ_LOGIN()
	{	
		$key_file = "C:/php/www/Stock_Market/API/finviz_user.DATA"; // I was running the code on localhost, and hence the path!
		$key_secret = "C:/php/www/Stock_Market/API/finviz_pass.DATA"; // I was running the code on localhost, and hence the path!
		$api_key = file_get_contents($key_file);
		$api_secret = file_get_contents($key_secret);
		$url = "https://finviz.com/login_submit.ashx";
		$cookie = "C:/php/www/Stock_Market/API/FINVIZ.COOKIE"; // I was running the code on localhost, and hence the path!
		$fields_string = '';
		$user = $api_key ;
		$pass = $api_secret;
		$submit = "login"; // this an actual code, I had used on one of the sites, but the password is fake!
		$fields = array(
		'email'=>urlencode($user),
		'password'=>urlencode($pass),
		'form'=>urlencode($submit)
        );
		
		//url-ify the data for the POST
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string,'&');
		
		$ch = curl_init ($url);
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
		$output = curl_exec ($ch);
		curl_close($ch);
	}
	
	
	
	
	function RUN_FINVIZ (){
		
		
		
		
		
		$login_session= $_SESSION['finviz_login'] ;
		
		if ($login_session=='yes'){}
		
		else{FINVIZ_LOGIN();$_SESSION['finviz_login'] = 'yes';}
		
		
		
		
		usleep(40);
		//jason responce
		
		$url = "https://elite.finviz.com/export.ashx?v=111&f=sh_price_u7,ta_change_u1&o=-change";
		//$url = "https://elite.finviz.com/export.ashx?v=111&f=sh_price_u3,ta_change_u1,ta_highlow50d_a40h&ft=4&o=-change";
		$cookie = "C:/php/www/Stock_Market/API/FINVIZ.COOKIE"; // I was running the code on localhost, and hence the path!
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie); 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'User-Agent: its-a-bot',
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
			$price_now   = $data[8];
			$day_high   = 0;
			$day_low   = 0;
			$CHANGE_PCT   = str_replace('%','',$data[8]);
			$CHANGE_RATIO   = $data[9];
			$CHANGE_VOL   = $data[10];
			$DATE_ADDED   = time();
			$TIME   = time();
			
			set_stock_index($conn, $url_offset,//SQL ID
			$ticker_name,
			$comp_name,
			$price_now, 
			$day_high,
			$day_low,
			$CHANGE_PCT,
			$CHANGE_RATIO,
			$CHANGE_VOL,
			$TIME,
			$aDataTableDetailHTML,
			$investing_table_count
			);	
			
			for ($c=0; $c < $num; $c++) {
				
				
				
			}
			
			//  echo $data[$c] . "<br />\n";
		}
		
		
		fclose ($stream );
		
		
		
		//print_r($csv);
		
		
		
		
	}
	//RUN_FINVIZ();
