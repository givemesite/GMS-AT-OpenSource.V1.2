@echo off
color 13
call "C:/php/bin/AHP/64bit-php-7.3/php.exe" -f "c:/php/WWW/Stock_Market/A_SYNC/a_sync_sub.php"
call "C:\php\cmd.exe" -run "C:/php/bin/AHP/64bit-php-7.3/php.exe c:/php/WWW/Stock_Market/A_SYNC/a_sync.php"
