@ECHO off
SET WINNMP=windows
SET TMP=c:\php\tmp
SET TEMP=c:\php\tmp
SET OPENSSL_CONF=c:\php\conf\openssl.conf
@"c:\php\bin\openssl\openssl.exe" %*
