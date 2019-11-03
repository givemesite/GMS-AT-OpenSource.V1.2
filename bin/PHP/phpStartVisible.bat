@echo off
TASKKILL /F /IM php-cgi.exe

REM Kill PHP-CGI in WinNMP before executing this file !!
REM This starts PHP-CGI servers with visible windows, so any output could be seen


start "PHP-CGI 127.0.0.1:9001" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9001
start "PHP-CGI 127.0.0.1:9002" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9002
start "PHP-CGI 127.0.0.1:9003" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9003
EXIT
