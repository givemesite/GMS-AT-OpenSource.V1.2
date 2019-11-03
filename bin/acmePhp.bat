@ECHO off
SET WINNMP=windows
SET TMP=c:\php\tmp
SET TEMP=c:\php\tmp
SET OPENSSL_CONF=c:\php\conf\openssl.conf
SET HOME=c:\php\conf

IF /I "%1"=="publish" GOTO :PUBLISH

"c:\php\bin\PHP\64bit-php-7.3\php.exe" -c "c:\php\conf" -dcurl.cainfo="c:\php\src\cacert.pem" -dopenssl.cafile="c:\php\src\cacert.pem" -dopen_basedir="" -ddisable_functions="" -ddisable_classes="" "c:\php\bin\acmePhp\acmephp.phar" %*

IF /I "%1"=="list" GOTO :HELP
IF /I "%1"=="" GOTO :HELP
IF /I "%1"=="authorize" GOTO :NOWHELP

GOTO :EOF

:NOWHELP
ECHO   NOW EXECUTE
:HELP
ECHO   publish [domain] [project]      Copy the authorization token, received after running `authorize`, in the project`s directory
GOTO :EOF

:PUBLISH
"c:\php\bin\PHP\64bit-php-7.3\php.exe" -c "c:\php\conf" -dcurl.cainfo="c:\php\src\cacert.pem" -dopenssl.cafile="c:\php\src\cacert.pem" -dopen_basedir="" -ddisable_functions="" -ddisable_classes="" "c:\php\bin\acmePhp\publish.php"  %2 %3
exit /b %ERRORLEVEL%
