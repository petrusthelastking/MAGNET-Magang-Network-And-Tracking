# PowerShell Script untuk Setup Laragon Virtual Host
# HARUS DIJALANKAN SEBAGAI ADMINISTRATOR

Write-Host "============================================" -ForegroundColor Cyan
Write-Host "Setup Laragon Virtual Host untuk MAGNET" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

# Path variables
$projectPath = "c:\Peyimpanan Pribadi\Data D\New folder (2)\Semester 5\pmpl\MAGNET-Magang-Network-And-Tracking"
$vhostConfig = "$projectPath\laragon-vhost.conf"
$hostsFile = "C:\Windows\System32\drivers\etc\hosts"
$domain = "magnet.test"

# Check if running as Administrator
$isAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)

if (-not $isAdmin) {
    Write-Host "❌ ERROR: Script ini harus dijalankan sebagai Administrator!" -ForegroundColor Red
    Write-Host ""
    Write-Host "Cara menjalankan:" -ForegroundColor Yellow
    Write-Host "1. Klik kanan PowerShell → Run as Administrator" -ForegroundColor Yellow
    Write-Host "2. cd ke folder project" -ForegroundColor Yellow
    Write-Host "3. Jalankan: .\setup-laragon.ps1" -ForegroundColor Yellow
    Write-Host ""
    pause
    exit 1
}

Write-Host "✅ Running as Administrator" -ForegroundColor Green
Write-Host ""

# Step 1: Check Laragon exists
Write-Host "📋 Step 1: Checking Laragon installation..." -ForegroundColor Yellow
$laragonPaths = @("C:\laragon", "C:\Program Files\Laragon", "C:\Program Files (x86)\Laragon")
$laragonPath = $null

foreach ($path in $laragonPaths) {
    if (Test-Path $path) {
        $laragonPath = $path
        break
    }
}

if (-not $laragonPath) {
    Write-Host "❌ Laragon tidak ditemukan!" -ForegroundColor Red
    Write-Host "   Install Laragon dari: https://laragon.org/download/" -ForegroundColor Yellow
    pause
    exit 1
}

Write-Host "✅ Laragon found at: $laragonPath" -ForegroundColor Green
Write-Host ""

# Step 2: Copy Virtual Host Config
Write-Host "📋 Step 2: Setting up Virtual Host configuration..." -ForegroundColor Yellow

$vhostDestination = "$laragonPath\etc\apache2\sites-enabled\magnet.conf"
$vhostDir = Split-Path $vhostDestination -Parent

# Create directory if not exists
if (-not (Test-Path $vhostDir)) {
    New-Item -ItemType Directory -Path $vhostDir -Force | Out-Null
}

# Copy vhost config
if (Test-Path $vhostConfig) {
    Copy-Item -Path $vhostConfig -Destination $vhostDestination -Force
    Write-Host "✅ Virtual Host configuration copied" -ForegroundColor Green
} else {
    Write-Host "❌ File laragon-vhost.conf tidak ditemukan!" -ForegroundColor Red
    pause
    exit 1
}
Write-Host ""

# Step 3: Update hosts file
Write-Host "📋 Step 3: Updating Windows hosts file..." -ForegroundColor Yellow

$hostsContent = Get-Content $hostsFile -Raw
if ($hostsContent -notmatch "magnet\.test") {
    Add-Content -Path $hostsFile -Value "`n127.0.0.1 $domain"
    Write-Host "✅ Added '$domain' to hosts file" -ForegroundColor Green
} else {
    Write-Host "✅ '$domain' already exists in hosts file" -ForegroundColor Green
}
Write-Host ""

# Step 4: Flush DNS
Write-Host "📋 Step 4: Flushing DNS cache..." -ForegroundColor Yellow
ipconfig /flushdns | Out-Null
Write-Host "✅ DNS cache flushed" -ForegroundColor Green
Write-Host ""

# Step 5: Instructions to restart Laragon
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "✅ SETUP SELESAI!" -ForegroundColor Green
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "📋 LANGKAH SELANJUTNYA:" -ForegroundColor Yellow
Write-Host ""
Write-Host "1. Buka aplikasi Laragon" -ForegroundColor White
Write-Host "2. Klik tombol 'Stop All'" -ForegroundColor White
Write-Host "3. Tunggu beberapa detik" -ForegroundColor White
Write-Host "4. Klik tombol 'Start All'" -ForegroundColor White
Write-Host ""
Write-Host "5. Buka browser dan akses: http://magnet.test" -ForegroundColor Cyan
Write-Host ""
Write-Host "6. Test login dengan:" -ForegroundColor Yellow
Write-Host "   NIM: 6705300038" -ForegroundColor White
Write-Host "   Password: mahasiswa123" -ForegroundColor White
Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

pause
