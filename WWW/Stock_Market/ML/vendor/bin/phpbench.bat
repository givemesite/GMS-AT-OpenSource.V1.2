@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../phpbench/phpbench/bin/phpbench
php "%BIN_TARGET%" %*
