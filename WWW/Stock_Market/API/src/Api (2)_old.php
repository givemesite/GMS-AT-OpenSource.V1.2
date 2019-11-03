<?php

namespace Cloudmanic\RobinHood;
  
use GuzzleHttp\Client;
  
class Api
{
  private static $i = null;
  
	//
	// Instance ...
	//
	public static function instance()
	{
		if(is_null(static::$i))
		{
			static::$i = new RobinHoodObj();
		}
        
		return static::$i;
	}  
  
  //
  // Magic function to catch all static calls.
  //
  public static function __callStatic($name, $args)
  {
    return call_user_func_array([ static::instance(), $name ], $args);
  }
}

/* End File */