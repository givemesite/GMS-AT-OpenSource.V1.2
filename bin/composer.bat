@ECHO off
SET WINNMP=windows
SET TMP=c:\php\tmp
SET TEMP=c:\php\tmp
SET OPENSSL_CONF=c:\php\conf\openssl.conf
SET cwd=%cd%
SET COMPOSER_HOME=c:\php\bin\composer
SET COMPOSER_CACHE_DIR=c:\php\tmp\composer
 IF "%1" == "global" (
	SET cwd=c:\php\bin\composer
	GOTO runGlobal 
) 

SET ARGS="%*" 
SET CLEAR_ARGS=%ARGS:--working-dir=% 
SET CLEAR_ARGS=%CLEAR_ARGS:-d =% 
IF %CLEAR_ARGS% NEQ %ARGS% GOTO runGlobal 

"c:\php\bin\PHP\64bit-php-7.3\php.exe" -c "c:\php\conf" -dcurl.cainfo="c:\php\src\cacert.pem" -dopenssl.cafile="c:\php\src\cacert.pem" -dopen_basedir="" -ddisable_functions="" -ddisable_classes="" "c:\php\bin\composer\composer.phar" --working-dir="%cwd%" %* 
exit /b %ERRORLEVEL% 

:runGlobal 
"c:\php\bin\PHP\64bit-php-7.3\php.exe" -c "c:\php\conf" -dcurl.cainfo="c:\php\src\cacert.pem" -dopenssl.cafile="c:\php\src\cacert.pem" -dopen_basedir="" -ddisable_functions="" -ddisable_classes="" "c:\php\bin\composer\composer.phar" %* 
exit /b %ERRORLEVEL%
