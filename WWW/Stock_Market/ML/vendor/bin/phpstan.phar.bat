@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../phpstan/phpstan-shim/phpstan.phar
php "%BIN_TARGET%" %*
