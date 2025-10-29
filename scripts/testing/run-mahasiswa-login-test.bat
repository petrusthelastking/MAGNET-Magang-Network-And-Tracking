@echo off
echo ============================================
echo Testing Login Mahasiswa dengan Playwright
echo ============================================
echo.
echo Kredensial Test:
echo NIM: 6705300038
echo Password: mahasiswa123
echo.
echo Server URL: http://magnet.test
echo.
echo ============================================
echo.

cd /d "c:\Peyimpanan Pribadi\Data D\New folder (2)\Semester 5\pmpl\MAGNET-Magang-Network-And-Tracking"

echo Menjalankan test...
echo.

npx playwright test tests/e2e/mahasiswa-login-real.spec.js --headed --project=chromium

echo.
echo ============================================
echo Test selesai!
echo.
echo Untuk melihat report:
echo   npx playwright show-report
echo.
echo ============================================
pause
