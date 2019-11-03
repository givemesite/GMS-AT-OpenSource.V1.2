<?php
$responce = "<center><h1>504 Gateway Time-out</h1>";
//if responce has '504 Gateway Time-out'
if (strpos($responce, '504 Gateway') !== false) {
echo "true";
}
