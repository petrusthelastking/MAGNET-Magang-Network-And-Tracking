# Script untuk start Laravel server dan testing Playwright
# Gunakan script ini untuk memudahkan testing

Write-Host "🚀 Starting Laravel Server for Playwright Testing..." -ForegroundColor Green

# Stop any existing server on port 8000
$existingProcess = Get-NetTCPConnection -LocalPort 8000 -ErrorAction SilentlyContinue | Select-Object -ExpandProperty OwningProcess -Unique
if ($existingProcess) {
    Write-Host "⚠ Stopping existing process on port 8000 (PID: $existingProcess)..." -ForegroundColor Yellow
    Stop-Process -Id $existingProcess -Force -ErrorAction SilentlyContinue
    Start-Sleep -Seconds 2
}

# Start Laravel server
Write-Host "✓ Starting Laravel server on http://127.0.0.1:8000..." -ForegroundColor Cyan
Start-Process powershell -ArgumentList "-NoExit", "-Command", "php artisan serve --host=127.0.0.1 --port=8000"

# Wait for server to be ready
Write-Host "⏳ Waiting for server to be ready..." -ForegroundColor Yellow
Start-Sleep -Seconds 5

# Test if server is responding
try {
    $response = Invoke-WebRequest -Uri "http://127.0.0.1:8000" -TimeoutSec 5 -UseBasicParsing
    Write-Host "✅ Server is ready!" -ForegroundColor Green
    Write-Host ""
    Write-Host "📝 You can now run Playwright tests:" -ForegroundColor Cyan
    Write-Host "   npx playwright test tests/e2e/mahasiswa-login-real.spec.js --headed" -ForegroundColor White
    Write-Host ""
} catch {
    Write-Host "❌ Server might not be ready yet. Please check manually at http://127.0.0.1:8000" -ForegroundColor Red
}
