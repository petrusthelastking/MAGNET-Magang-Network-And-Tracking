@echo off
echo ============================================
echo Starting Laravel Development Server
echo ============================================
echo.
echo This will start Laravel on http://127.0.0.1:8000
echo Press Ctrl+C to stop the server
echo.

cd /d "c:\Peyimpanan Pribadi\Data D\New folder (2)\Semester 5\pmpl\MAGNET-Magang-Network-And-Tracking"

php artisan serve --host=127.0.0.1 --port=8000

pause
