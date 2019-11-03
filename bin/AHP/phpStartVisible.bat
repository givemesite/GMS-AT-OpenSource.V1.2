@echo off
TASKKILL /F /IM php-cgi.exe

REM Kill PHP-CGI in WinNMP before executing this file !!
REM This starts PHP-CGI servers with visible windows, so any output could be seen


start "PHP-CGI 127.0.0.1:9001" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9001
start "PHP-CGI 127.0.0.1:9002" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9002
start "PHP-CGI 127.0.0.1:9003" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9003
start "PHP-CGI 127.0.0.1:9004" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9004
start "PHP-CGI 127.0.0.1:9005" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9005
start "PHP-CGI 127.0.0.1:9006" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9006
start "PHP-CGI 127.0.0.1:9007" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9007
start "PHP-CGI 127.0.0.1:9008" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9008
start "PHP-CGI 127.0.0.1:9009" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9009
start "PHP-CGI 127.0.0.1:9010" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9010
start "PHP-CGI 127.0.0.1:9011" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9011
start "PHP-CGI 127.0.0.1:9012" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9012
start "PHP-CGI 127.0.0.1:9013" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9013
start "PHP-CGI 127.0.0.1:9014" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9014
start "PHP-CGI 127.0.0.1:9015" "c:\php\bin\PHP\64bit-php-7.3\php-cgi.exe" -q -dexpose_php=on -c "c:\php\conf" -b 127.0.0.1:9015
EXIT
