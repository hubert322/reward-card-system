@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../h4cc/wkhtmltopdf-i386/bin/wkhtmltopdf-i386
php "%BIN_TARGET%" %*
