@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../phpstan/phpstan-shim/phpstan
php "%BIN_TARGET%" %*
