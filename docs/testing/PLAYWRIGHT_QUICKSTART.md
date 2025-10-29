# Quick Start - Playwright E2E Testing

## 🚀 Setup (Sudah Dilakukan)
✅ Playwright sudah terinstall
✅ Browser sudah terdownload
✅ Test users sudah dibuat:
- **Admin**: ADMIN001 / password
- **Mahasiswa**: TEST123456 / password

## ▶️ Jalankan Tests

### 1. Pastikan Laravel Running
```powershell
php artisan serve
```

### 2. Jalankan Test (Terminal Baru)
```powershell
# Run semua test
npm run test:e2e

# Run dengan UI mode (Interactive - RECOMMENDED untuk pertama kali)
npm run test:e2e:ui

# Run test tertentu
npx playwright test tests/e2e/homepage.spec.js
npx playwright test tests/e2e/auth.spec.js

# Run dengan browser terlihat (headed)
npm run test:e2e:headed

# Debug mode
npm run test:e2e:debug
```

### 3. Lihat Report
```powershell
npm run test:e2e:report
```

## 📁 Test Files
- `tests/e2e/homepage.spec.js` - Test homepage
- `tests/e2e/auth.spec.js` - Test login/logout
- `tests/e2e/admin-data-mahasiswa.spec.js` - Test admin features
- `tests/e2e/lowongan-magang.spec.js` - Test lowongan magang
- `tests/e2e/recommendation-system.spec.js` - Test Multi-MOORA recommendation
- `tests/e2e/helpers.js` - Helper functions

## 📖 Dokumentasi Lengkap
Lihat `docs/PLAYWRIGHT_TESTING.md` untuk dokumentasi lengkap

## 🐛 Troubleshooting

### Test gagal karena timeout?
Edit `playwright.config.js` dan tingkatkan timeout

### Port 8000 sudah digunakan?
Pastikan hanya ada 1 `php artisan serve` yang running

### Element tidak ditemukan?
Test selector mungkin perlu disesuaikan dengan UI Anda yang sebenarnya
