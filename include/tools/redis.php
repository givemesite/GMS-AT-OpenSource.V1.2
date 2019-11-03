<?php



if (!class_exists("Redis")) die ("<b>Fatal error</b>: <b>php_redis</b> extension is not enabled.<br> Add/Uncomment in WinNMP\conf\php.ini: <br>extension = <b>php_redis.dll</b><br><p>Also Instal Redis Cache by running WinNMP Installer!</p><hr>");

error_reporting(E_ALL & ~E_NOTICE);



$redis=new Redis();
$addr=empty($_SERVER['REDIS']) ? 'localhost' : $_SERVER['REDIS'];
try {
	if (!empty($_GET['pingRedis'])) {
			$redis->connect($addr, null, 0.02);
			$infoRedis=$redis->info();
			$redisVersion="Redis/".$infoRedis['redis_version'];
			header("X-pingRedis: $redisVersion");
			die("PONG");
		
	} else $redis->connect($addr, null, 0.05);
} catch( Exception $e ) {
	die("Error: Unable to connect");
}

$db_num=intval($_REQUEST['db']);
if ($_REQUEST['a']=='i') $db_num=null;

$is_demo 		= false;
$script_name 	= isset( $_SERVER['SCRIPT_NAME'] ) ? $_SERVER['SCRIPT_NAME'] : "rb.php";



?>
<html>
	<head>
		<title>WinNMP Redis Cache Manager</title>
		<link href="/tools/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>

		<div id="main">
			<div id="menu">
				<ul class="tabs" id="menu_tabs">
					<li><h2 title="Redis Cache Manager">Redis</h2></li>
					<li><?php $active=( is_null($db_num) ? ' class="active"' : '' ); echo "<a$active href='" . $script_name . "?a=i'>[ Info ]</a>"; ?></li>
					<?php display_databases( $redis, $db_num ); ?>
					<li style="float:right;"><a href="http://localhost">My Projects</a></li>
				</ul>
			</div>

			<div class="evaluator redis">


				<?php



				/***************************************************************************
				*
				* parse parameters for action, sort and pattern
				*
				*/

				$action = "b";

				if( !empty( $_REQUEST['a'] ) ) {
					$action = $_REQUEST['a'];
				}

				$sort    = "key";
				if( !empty( $_REQUEST["s"] ) ) {

					if( ( $_REQUEST["s"] !== "ttl" ) &&
					( $_REQUEST["s"] !== "key" ) &&
					( $_REQUEST["s"] !== "sz"  ) &&
					( $_REQUEST["s"] !== "1"   ) &&            // "1" is for sorting sets, lists
					( $_REQUEST["s"] !== "no"  ) ) {
						die;
					}

					$sort = $_REQUEST["s"];
				}

				$pattern = "*";
				if( !empty( $_REQUEST["p"] ) ) {

					$pattern = $_REQUEST["p"];
				}



				/*********************************************
				*
				*    check if server is available
				*
				*/

				try {

					$res = $redis->ping();

				} catch( Exception $e ) {

					echo "Error Connecting to Redis Server (Redis server is available only on 64bit systems)";
					die;
				}




				/***************************************************************************
				*
				* select database
				* ( demo version allows access to DB #0 only )
				*
				*/

				if( $is_demo ) {
					$redis->select( 0 );
				} else {
					$redis->select( $db_num );
				}










				/***************************************************************************
				*
				* handle actions
				*
				*/

				switch( $action ) {

					case "s": {   // show


						if( isset( $_REQUEST["k"] ) ) {
							$k = base64_decode( $_REQUEST["k"] );

							display_key( $k );
							die;
						}
						break;
					}


					case "as": {   // add string

						if( ( isset( $_REQUEST['key'] ) ) &&
						( isset( $_REQUEST['val'] ) ) ) {
							$redis->set( $_REQUEST['key'], $_REQUEST['val'] );
						}
						break;
					}
					case "ah": {   // add hash

						if( ( isset( $_REQUEST['key']  ) ) &&
						( isset( $_REQUEST['val']  ) ) &&
						( isset( $_REQUEST['hash'] ) ) ) {
							$redis->hset( $_REQUEST['hash'], $_REQUEST['key'], $_REQUEST['val'] );
						}
						break;
					}
					case "d": {   // delete

						if( ( isset( $_REQUEST['sel'] ) )    &&
						( count( $_REQUEST['sel'] ) > 0 ) ) {

							foreach( $_REQUEST['sel'] as $s ) {
								$redis->del( base64_decode( $s ) );
							}
						}
						break;
					}

					case "f": {   // flush DB

						$redis->flushdb();
						break;
					}

					case "p": {    // make persistent

						if( ( isset( $_REQUEST['sel'] ) )    &&
						( count( $_REQUEST['sel'] ) > 0 ) ) {

							foreach( $_REQUEST['sel'] as $s ) {
								$redis->persist( base64_decode( $s ) );
							}
						}
						break;
					}
					case "i": {   // display server info

						display_info( $redis );
						die; // done here
					}

				}


				/***************************************************************************
				*
				*
				* done with actions - display the rest of the header section
				*
				*/





				echo '<br><center><form name="search" method="get" action="' . $script_name . '">';
				echo '<input type="hidden" name="db" value="' . intval( $db_num ) . '" />';
				echo 'Pattern <input type="text" size=30 name="p" value="' . $pattern . '" />';
				echo '<input type="submit" value="Search" /> ';

				echo 'sort by: ';
				echo '<input type="radio" name="s"  value="key"' . ( $sort == 'key' ? "checked" : "" ) .  ' />Key ';
				echo '<input type="radio" name="s" value="sz" '  . ( $sort == 'sz' ? "checked" : ""  ) .  ' />Size ';
				echo '<input type="radio" name="s" value="ttl" ' . ( $sort == 'ttl' ? "checked" : "" ) .  ' />TTL ';
				echo '<input type="radio" name="s"  value="no"'  . ( $sort == 'no' ? "checked" : ""  ) .  ' />No ';

				echo '</form></center>' . "<br/>\n";





				/***************************************************************************
				*
				*
				* done with the header section - display the keys
				*
				*/


				$count_all_keys_in_db = $redis->dbsize();

				$all_keys 		= array();
				$matched_keys   = $redis->keys( $pattern );

				foreach( $matched_keys as $k ) {

					$sz = -1;

					$type = $redis->type( $k );
					$ttl  = $redis->ttl ( $k );
					$sz   = getSize($k, $type);

					if( !isset( $all_keys[$type] ) ) {
						$all_keys[$type] = array();
					}

					array_push( $all_keys[$type], array( "key" => $k, "ttl" => $ttl, "sz" => $sz ));
				}

				// sort by type
				ksort( $all_keys );

				util_html_form_start( "form_select", $pattern, $sort, "post", false );

				echo "Showing " . count( $matched_keys ) . " of " . $count_all_keys_in_db . " keys";

				?>
				&nbsp;&nbsp;
				<select name="a">
					<option value="d">Delete selected</option>
					<!-- <option value="p">Persist selected</option> -->
					<option value="f">Flush DB</option>
				</select>
				<input type="submit" value="Execute" onClick="return confirmSubmit()" /><br/><br/>


				<table class="mainTable" border="0" cellpadding="2" cellspacing="1">
				<tr>
					<th align=center  width='40'>
						<input type="checkbox" name="check_all" value="Check All" onClick="javascript:selectToggle('form_select');">
					</th>
					<th align=left width='50'> Type </th>
					<th align=left > Key </th>
					<th align=center width='75'> Size </th>
					<th align=center width='75'> TTL </th>
				</tr>



				<?php

				foreach( $all_keys as $type => $keys ) {


					$typeTitle= getTypeTitle($type);

					switch( $sort ) {

						case "key": uasort( $keys, 'util_custom_cmp_key' ); break;
						case "ttl": uasort( $keys, 'util_custom_cmp_ttl' ); break;
						case "sz" : uasort( $keys, 'util_custom_cmp_sz' );  break;
					}


					foreach( $keys as $k ) {

						$ttl_txt = util_format_ttl( $k['ttl'] );

						$sz_txt  = util_format_size( $type, $k['sz'] );

						echo '<tr><td align=center><input type="checkbox" name="sel[]" value="' . htmlspecialchars( base64_encode( $k['key'] ) ) . '" />' . "</td>";
						echo "<td>$typeTitle</td><td><a href='$script_name?a=s&db=".intval( $db_num )."&k=".htmlspecialchars( base64_encode( $k['key'] ) ) ."'>" . $k['key'] . "</a> </td>";
						echo "<td  align=center>" . $sz_txt . "</td>";
						echo "<td  align=center>" . $ttl_txt . "</td>";
						echo "</tr>\n";
					}

				}
				echo "</table>";
				echo "</form>";
				echo "<br/><br/>";


				util_html_form_start( "as", '*', $sort );
				?>
				<input type="text" name="key" value="<key>"			onfocus="this.value==this.defaultValue?this.value='':null"/>
				<input type="text" name="val" value="<value>"		onfocus="this.value==this.defaultValue?this.value='':null"/>
				<input type="submit" value="Create String" /><br/>
				</form>
				<?php
				util_html_form_start( "ah", '*', $sort );
				?>
				<input type="text" name="hash" 	value="<key>" 		onfocus="this.value==this.defaultValue?this.value='':null"/>
				<input type="text" name="val" 	value="<field>"		onfocus="this.value==this.defaultValue?this.value='':null"/>
				<input type="text" name="key" 	value="<value>"		onfocus="this.value==this.defaultValue?this.value='':null"/>
				<input type="submit" value="Create Hash" /><br/>
				</form>

				<SCRIPT LANGUAGE="JavaScript">

					function selectToggle(n) {

					var fo = document.forms[n];

					t = fo.elements['check_all'].checked;

					for( var i=0; i < fo.length; i++ )  {

					if( fo.elements[i].name == 'check_all' ) {
					continue;
					}

					if( t ) {
					fo.elements[i].checked = "checked";
					} else {
					fo.elements[i].checked = "";
					}
					}
					}

					function confirmSubmit() {

					if( document.form_select.a.selectedIndex !== 2 ) {
					return true;
					}

					return confirm("Are you sure you wish to continue?");
					}


				</script>
			</div>
		</div>
	</body>
</html>







<?php


/***************************************************************************
*
* util functions
*
*
*/


function display_databases( $redis, $curr_db ) {

	global $is_demo, $script_name, $sort, $pattern;

	$num=util_get_dbs($redis);

	for ($n=0; $n<$num; $n++) {

		$active=( !is_null($curr_db) && $n == $curr_db ? ' class="active"' : '' );

		echo 	"<li><a$active href='" . $script_name .
		"?db=" . $n . "&sort=" . $sort .
		"&p=" . htmlspecialchars( $pattern ) . "'>#" . $n . "</a></li>";


	}


}



function display_info( $redis ) {


	$ts_lastsave = $redis->lastsave();
	$secs = time() - $ts_lastsave;

	echo "<center>Last save " . $secs . " seconds ago. <br/><br/>";

	$info = $redis->info();

	echo '<table class="mainTable" border="0" cellpadding="3" cellspacing="1" width="50%">';

	foreach( $info as $k => $v ) {

		if( $k == 'allocation_stats' ) {
			$v = str_replace( ",", "<br/>", $v );
		}

		#if( substr( $k, 0, 2 ) == "db" ) {
		#	//$v = "Keys: " . $v['keys'] . "<br/>Expires: " . $v['expires'];
		#}

		echo '<tr><td>' .  $k . "</td>";
		echo '<td>' .  $v . "</td></tr>";

	}
	echo "</table></body></html>";
}


function getTypeTitle($type) {
	switch ($type) {
		case Redis::REDIS_STRING: return 'String'; break;
		case Redis::REDIS_HASH: return 'Hash'; break;
		case Redis::REDIS_LIST: return 'List'; break;
		case Redis::REDIS_SET: return 'Set'; break;
		case Redis::REDIS_ZSET: return 'Sorted Set'; break;
		default:  return ' UNKNOWN ';
	}
}

function getSize($k,$type) {
	global $redis;
	switch ($type) {
		case Redis::REDIS_STRING: return $redis->strLen( $k ); break;
		case Redis::REDIS_HASH: return $redis->hLen( $k ); break;
		case Redis::REDIS_LIST: return $redis->lLen( $k ); break;
		case Redis::REDIS_SET: return $redis->sCard( $k ); break;
		case Redis::REDIS_ZSET: return $redis->zCard( $k ); break;
		default:  null;
	}
}


function getKey($k, $type) {
	global $redis;
	switch( $type ) {
		case Redis::REDIS_STRING:
			return $redis->get( $k );
			break;
		case Redis::REDIS_HASH:
			return $redis->hGetAll( $k );
			break;
		case Redis::REDIS_LIST:
			return $redis->lRange( $k, 0, -1 );
			break;
		case Redis::REDIS_SET:
			return $redis->sMembers( $k );
			break;
		case Redis::REDIS_ZSET:
			return $redis->zRange( $k, 0, -1, array('withscores' => true) );
			break;
		default:
			return null;
	}
}

function display_key( $k ) {

	global $redis;

	$type   = $redis->type( $k );
	$typeTitle= getTypeTitle($type);
	$retval = false;

	echo "<pre>";

	$retval=getKey($k, $type);

	echo "Key:  " . $k 		. "\n";
	echo "Type: " . $typeTitle 	. "\n";

	// unserialize?
	if( isset( $_REQUEST["u"] ) ) {

		$retval = unserialize( $retval );

		echo "Unserialized\n";

	} else {
		if( isset( $_SERVER['REQUEST_URI'] ) ) {
			$u = $_SERVER['REQUEST_URI'] . "&u=1";
			echo "<a href='". $u . "'>Unserialize</a>\n";
		}
	}


	if( isset( $_REQUEST["s"] ) ) {

		asort( $retval );

		echo "Sorted by values\n";

	} else {
		if( isset( $_SERVER['REQUEST_URI'] ) ) {
			$u = $_SERVER['REQUEST_URI'] . "&s=1";
			echo "<a href='". $u . "'>Sort array by values</a>\n";
		}
	}


	echo "\n";

	echo htmlentities( print_r($retval, true) );
}


function util_get_dbs( $redis ) {

	return 11;
}


function util_format_ttl( $ttl ) {

	if( $ttl === -1 ) {
		return $ttl;
	}

	$m = ((int)( ( $ttl ) / 60 ));

	if( $m > 120 ) {
		$m = ( (int) ( $m / 60 ) );
		$s = "" . $m . "h";
	} else {
		$s = "" . $m . "min";
	}

	$s = $ttl . " (" . $s . ")";

	return $s;
}


function util_format_size( $type, $sz ) {

	$s = $sz;

	if( ( $type === "string" ) &&
	( (int)$sz > 1100 ) ) {
		$s = (int)( $sz / 1024 ) . "kb";
	}

	return $s;
}


function util_custom_cmp_key( $a, $b ) {

	return strcmp( $a['key'], $b['key'] );
}


function util_custom_cmp_ttl( $a, $b ) {

	if( $a['ttl'] === $b['ttl'] ) {
		return util_custom_cmp_key( $a, $b );
	}

	return ( $a['ttl'] - $b['ttl'] );
}


function util_custom_cmp_sz( $a, $b ) {

	if( $a['sz'] === $b['sz'] ) {
		return util_custom_cmp_key( $a, $b );
	}

	return ( $a['sz'] - $b['sz'] );
}


function util_html_form_start( $action, $pattern, $sort, $type = "post", $put_action = true ) {

	global $script_name, $db_num;

	echo '<form name="' . $action . '" method="' . $type . '" action="' . $script_name . '">';
	if( $put_action ) echo '<input type="hidden" name="a" value="' . $action . '" />';
	echo '<input type="hidden" name="p" value="' . htmlspecialchars( $pattern ) . '" />';
	echo '<input type="hidden" name="s" value="' . htmlspecialchars( $sort ) . '" />';
	echo '<input type="hidden" name="db" value="' . intval( $db_num ) . '" />';
}







?>




