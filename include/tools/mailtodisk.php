<?php
$input=file_get_contents('php://stdin');
$input=preg_replace('~\R~u', "\r\n", $input);
$pre=__DIR__.'/../../log/mail-';
$gmd=gmdate('Y-m-d H-m');
$retry = 0;
do {
    $filename = $pre . $gmd . ' - ' . ++$retry . '.eml';
} while(is_file($filename));
file_put_contents($filename, $input);