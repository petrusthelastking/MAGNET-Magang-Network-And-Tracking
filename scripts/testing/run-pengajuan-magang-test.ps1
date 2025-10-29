# PowerShell Script: Run Pengajuan Magang E2E Tests
# Usage: .\run-pengajuan-magang-test.ps1

Write-Host ""
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "Pengajuan Magang E2E Test Runner" -ForegroundColor Cyan
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host ""

# Get project root directory
$scriptDir = Split-Path -Parent $PSCommandPath
$projectRoot = Split-Path -Parent (Split-Path -Parent $scriptDir)
Write-Host "Project Root: $projectRoot" -ForegroundColor Yellow
Write-Host ""

# Change to project root
Set-Location $projectRoot

Write-Host "Starting PHP Development Server..." -ForegroundColor Yellow

# Start PHP development server in background
$job = Start-Job -ScriptBlock {
    param($rootPath)
    Set-Location "$rootPath\public"
    php -S 127.0.0.1:8000
} -ArgumentList $projectRoot

Write-Host "Waiting for server to start..." -ForegroundColor Yellow
Start-Sleep -Seconds 3

# Check if server is accessible
try {
    $response = Invoke-WebRequest -Uri "http://127.0.0.1:8000" -TimeoutSec 5 -ErrorAction Stop
    Write-Host "Server is accessible at http://127.0.0.1:8000" -ForegroundColor Green
    Write-Host ""
} catch {
    Write-Host "Failed to start server" -ForegroundColor Red
    Write-Host "Error: $_" -ForegroundColor Red
    Write-Host ""
    Stop-Job $job -ErrorAction SilentlyContinue
    Remove-Job $job -ErrorAction SilentlyContinue
    exit 1
}

Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "Running Pengajuan Magang Tests..." -ForegroundColor Cyan
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host ""

# Run the Playwright tests
npx playwright test mahasiswa-pengajuan-magang --reporter=list

$testExitCode = $LASTEXITCODE

Write-Host ""
Write-Host "==========================================" -ForegroundColor Cyan

if ($testExitCode -eq 0) {
    Write-Host "All Tests Passed!" -ForegroundColor Green
} else {
    Write-Host "Some Tests Failed" -ForegroundColor Red
    Write-Host "Check the test results above for details." -ForegroundColor Yellow
}

Write-Host ""

# Cleanup: Stop the PHP server
Write-Host "Stopping PHP Development Server..." -ForegroundColor Yellow
Stop-Job $job -ErrorAction SilentlyContinue
Remove-Job $job -ErrorAction SilentlyContinue
Write-Host "Server stopped" -ForegroundColor Green
Write-Host ""

Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "Test Summary Complete" -ForegroundColor Cyan
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host ""

exit $testExitCode
