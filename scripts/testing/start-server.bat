@echo off
echo ========================================
echo   Starting Laravel Development Server
echo ========================================
echo.

REM Check if port 8000 is available
echo Checking port 8000...
netstat -ano | findstr :8000 | findstr LISTENING >nul
if %ERRORLEVEL% EQU 0 (
    echo [WARNING] Port 8000 is already in use!
    echo.
    echo Trying to free port 8000...
    for /f "tokens=5" %%a in ('netstat -ano ^| findstr :8000 ^| findstr LISTENING') do (
        taskkill /F /PID %%a >nul 2>&1
    )
    timeout /t 2 /nobreak >nul
)

echo Starting Laravel server...
echo Server will be available at: http://localhost:8000
echo.
echo Press Ctrl+C to stop the server
echo ========================================
echo.

REM Start server using Laravel's artisan serve
php artisan serve --host=localhost --port=8000 --tries=0

REM If artisan serve fails, try PHP built-in server
if %ERRORLEVEL% NEQ 0 (
    echo.
    echo [ERROR] php artisan serve failed!
    echo Trying alternative method with PHP built-in server...
    echo.
    cd public
    php -S localhost:8000 server.php
    cd ..
)
