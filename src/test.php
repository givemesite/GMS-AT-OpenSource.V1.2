<?php

echo "<h3>Demo Project 1</h3>";
echo "<br>include_path: ".ini_get('include_path');
echo "<br>Including a global library file - wtnmpIncludeTest.lib.php :";

include "wtnmpIncludeTest.lib.php";

if ( function_exists('wtnmpIncludeTest') ) wtnmpIncludeTest();

?>