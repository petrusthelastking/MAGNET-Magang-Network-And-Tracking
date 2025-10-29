@echo off
echo ========================================
echo   Playwright E2E Test - Mahasiswa Login
echo ========================================
echo.
echo Kredensial Test:
echo   NIM:      6705300038
echo   Password: mahasiswa123
echo.
echo ========================================
echo.

REM Check if server is running
curl -s http://localhost:8000 >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Laravel server belum running!
    echo.
    echo Silakan start server Laravel terlebih dahulu:
    echo   php artisan serve
    echo.
    echo Kemudian jalankan script ini lagi.
    pause
    exit /b 1
)

echo [OK] Laravel server detected at http://localhost:8000
echo.
echo Starting Playwright test...
echo.

npx playwright test tests/e2e/mahasiswa-login-real.spec.js --headed --project=chromium --workers=1

echo.
echo ========================================
echo Test selesai!
echo.
echo Untuk melihat report:
echo   npx playwright show-report
echo ========================================
pause
