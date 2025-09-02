@echo off
set PHP_INI=C:\xampp\php\php.ini
set APACHE_BIN=C:\xampp\apache\bin\httpd.exe

echo Enabling ext-gd in %PHP_INI%...

rem backup dulu
copy "%PHP_INI%" "%PHP_INI%.bak"

rem hilangkan tanda ; di depan extension=gd atau extension=gd2
powershell -Command "(Get-Content '%PHP_INI%') -replace ';extension=gd', 'extension=gd' | Set-Content '%PHP_INI%'"
powershell -Command "(Get-Content '%PHP_INI%') -replace ';extension=gd2', 'extension=gd2' | Set-Content '%PHP_INI%'"

echo Restarting Apache...
taskkill /F /IM httpd.exe >nul 2>&1
start "" "%APACHE_BIN%"

echo Done! ext-gd should now be enabled.
pause
