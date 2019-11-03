@ECHO off
SET WINNMP=windows
SET TMP=c:\php\tmp
SET TEMP=c:\php\tmp
SET OPENSSL_CONF=c:\php\conf\openssl.conf
"c:\php\bin\PHP\64bit-php-7.3\php.exe" -c "c:\php\conf" -dcurl.cainfo="c:\php\src\cacert.pem" -dopenssl.cafile="c:\php\src\cacert.pem" -dopen_basedir="" -ddisable_functions="" -ddisable_classes="" %*
exit /b %ERRORLEVEL%
