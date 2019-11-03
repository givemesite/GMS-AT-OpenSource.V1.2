<?php




function adminer_object() {



	$server=$_GET['server'];
	$port=ini_get('mysqli.default_port');
	if ((empty($server) || $server=='localhost' || $server=='127.0.0.1') && $port && $port!=3306) $_GET['server']="localhost:$port";

  
  class AdminerSoftware extends Adminer {
    
    function name() {
      // custom name in title and heading
      return '<a href="http://localhost">WinNMP</a> Adminer';
    }
    
    
   
    function login($login, $password) {
	  return true;
    }
    

    
  }
  
  return new AdminerSoftware;
}

// include original Adminer or Adminer Editor
include __DIR__."/adminer-org.php";
