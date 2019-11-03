<?php

/** Log all queries to SQL file (manual queries through SQL command are not logged)
* @link http://www.adminer.org/plugins/#use
* @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerSqlLog {

	var $filename;
    var $dir;
    var $database;
	

	function AdminerSqlLog() {
		$this->filename = "adminer-";
        $this->dir=dirname(ini_get('error_log'));
	}
	
	function messageQuery($query) {
		if (!preg_match("/^\s*(ALTER|CREATE|DROP|RENAME)/i",$query)) return;  
		if (preg_match("/^\s*CREATE\s+TABLE/i",$query) && !preg_match("/^\s*CREATE\s+TABLE\s+IF\s+NOT\s+EXISTS/i",$query)) {
			//CREATE TABLE IF NOT EXISTS
			$query=preg_replace("/\s*CREATE\s+TABLE/i", 'CREATE TABLE IF NOT EXISTS', $query );
		}
		$adminer = adminer();
		$this->database = $adminer->database(); 
        $query=preg_replace( '/\s+(`[\w\.]+`)\s+/i' , ' \1 ' , $query); 
        $query=preg_replace( '/;[\s\-\.\w]+$/i' , ';' , $query);
		$query=preg_replace( '/\s*\)\s*COMMENT=\'\';\s*$/i' , ' );' , $query);
		$query=preg_replace( '/\s*,\s*COMMENT=\'\';\s*$/i' , ' ;' , $query);
		$query=preg_replace( '/,\s*\v+ADD\s+/i' , ",\n  ADD " , $query);
		$query=preg_replace( '/,\s*\v+DROP\s+/i' , ",\n  DROP " , $query);
		$query=preg_replace( '/,\s*\v+CHANGE\s+/i' , ",\n  CHANGE " , $query);
		$fp = fopen($this->dir.'/'.$this->filename.$this->database.'.sql', "a");
		flock($fp, LOCK_EX);
		fwrite($fp, $query);
		fwrite($fp, "\n");
		flock($fp, LOCK_UN);
		fclose($fp);
	}
	
}

function adminer_object() {
    // required to run any plugin
    include_once __DIR__."/adminer-plugin.php";
    
   
    $plugins = array(
        // specify enabled plugins here
        new AdminerSqlLog,
    );
    
    /* It is possible to combine customization and plugins:
    class AdminerCustomization extends AdminerPlugin {
    }
    return new AdminerCustomization($plugins);
    */
    
    return new AdminerPlugin($plugins);
}

// include original Adminer or Adminer Editor
include __DIR__."/adminer.php";
