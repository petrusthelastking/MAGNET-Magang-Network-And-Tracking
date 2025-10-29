# 📖 Dokumentasi Testing - MAGNET Application

> **Panduan lengkap untuk menjalankan E2E testing dengan Playwright**

---

## 📁 Struktur Folder Testing

```
MAGNET-Magang-Network-And-Tracking/
├── tests/
│   └── e2e/                           # Test files Playwright
│       ├── mahasiswa-login-real.spec.js   # ✅ Test login mahasiswa (PASSED)
│       ├── homepage.spec.js               # Test homepage
│       ├── auth.spec.js                   # Test authentication
│       ├── helpers.js                     # Helper functions untuk testing
│       └── ...
│
├── scripts/testing/                   # Script bantuan untuk testing
│   ├── run-mahasiswa-login-test.bat   # Quick run test login mahasiswa
│   ├── start-server.bat               # Start Laravel server
│   ├── setup-laragon.ps1              # Setup Laragon virtual host
│   └── ...
│
├── docs/testing/                      # Dokumentasi testing
│   ├── README.md                      # 👈 File ini
│   └── PLAYWRIGHT_TESTING.md          # Dokumentasi detail Playwright
│
├── test-results/                      # Hasil test (screenshots, videos)
├── playwright-report/                 # HTML report dari Playwright
└── playwright.config.js               # Konfigurasi Playwright
```

---

## 🚀 Quick Start - Menjalankan Test

### **Prasyarat:**

1. ✅ Node.js sudah terinstall
2. ✅ Playwright sudah terinstall (`npm install`)
3. ✅ Database `magnet` sudah ada dan terisi data
4. ✅ User test sudah dibuat (NIM: `6705300038`, Password: `mahasiswa123`)

### **Cara Menjalankan:**

#### **1️⃣ Start Laravel Server (Terminal 1)**

```powershell
# Dari root project
cd public
php -S 127.0.0.1:8000
```

**ATAU** gunakan script helper:

```powershell
.\scripts\testing\start-server.bat
```

#### **2️⃣ Run Test (Terminal 2 - Terminal baru)**

```powershell
# Test login mahasiswa saja (Chromium only - recommended)
npx playwright test tests/e2e/mahasiswa-login-real.spec.js

# Test dengan browser visible
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --headed

# Test semua file
npx playwright test

# Debug mode
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --debug
```

**Note:** Default testing menggunakan **Chromium only** untuk menghindari masalah kompatibilitas. 
Firefox, WebKit, dan Mobile testing sudah di-disable di `playwright.config.js`.

**ATAU** gunakan script helper:

```powershell
.\scripts\testing\run-mahasiswa-login-test.bat
```

#### **3️⃣ Lihat Report**

```powershell
npx playwright show-report
```

---

## ✅ Test yang Sudah Berhasil

### **1. Mahasiswa Login Test** (`mahasiswa-login-real.spec.js`)

**Status:** ✅ **4/4 PASSED** (100%)

**Test Cases:**
- ✅ Login berhasil dengan NIM `6705300038`
- ✅ Dashboard mahasiswa tampil setelah login
- ✅ Error message muncul saat password salah
- ✅ Navigasi ke halaman mahasiswa berhasil

**Kredensial Test:**
- **NIM:** `6705300038`
- **Password:** `mahasiswa123`

**Cara Run:**
```powershell
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --headed
```

---

## 🛠️ Troubleshooting

### ❌ **Problem: Server tidak bisa start**

**Solusi:**
```powershell
# Stop proses PHP yang mungkin masih running
Get-Process | Where-Object {$_.ProcessName -like "*php*"} | Stop-Process -Force

# Clear cache Laravel
php artisan config:clear
php artisan cache:clear

# Start server lagi
cd public
php -S 127.0.0.1:8000
```

### ❌ **Problem: Test timeout**

**Penyebab:** Server belum siap atau tidak running

**Solusi:**
1. Pastikan server sudah running di port 8000
2. Test akses manual: `curl http://127.0.0.1:8000/dashboard`
3. Jika berhasil, baru jalankan test

### ❌ **Problem: Database connection error**

**Solusi:**
```powershell
# Cek database di .env
DB_DATABASE=magnet
DB_USERNAME=root
DB_PASSWORD=

# Clear config
php artisan config:clear

# Test koneksi
php artisan tinker
>>> DB::connection()->getPdo();
```

---

## 📝 Membuat Test Baru

### **Template Test File:**

```javascript
import { test, expect } from '@playwright/test';

test.describe('Nama Fitur Test', () => {
  
  test('should do something', async ({ page }) => {
    // 1. Navigate ke halaman
    await page.goto('/halaman');
    
    // 2. Interact dengan elemen
    await page.fill('input[name="field"]', 'value');
    await page.click('button[type="submit"]');
    
    // 3. Assert hasil
    await expect(page).toHaveURL('/success');
    await expect(page.locator('text=Success')).toBeVisible();
  });
  
});
```

### **Helper Functions yang Tersedia:**

Lihat `tests/e2e/helpers.js`:

```javascript
import { login, loginAsMahasiswa, logout } from './helpers.js';

// Login dengan kredensial custom
await login(page, 'username', 'password');

// Login sebagai mahasiswa test
await loginAsMahasiswa(page);

// Logout
await logout(page);
```

---

## 🎯 Best Practices

### **1. Gunakan Data Test yang Konsisten**

- Jangan gunakan data production
- Gunakan user test khusus (NIM: `6705300038`)
- Reset data test sebelum run test suite lengkap

### **2. Isolasi Test**

- Setiap test harus independent
- Jangan depend pada urutan eksekusi test
- Clear state setelah test selesai

### **3. Meaningful Assertions**

```javascript
// ❌ Bad
await expect(page.locator('div')).toBeVisible();

// ✅ Good
await expect(page.locator('[data-testid="dashboard-title"]')).toBeVisible();
await expect(page.locator('text=Dashboard Mahasiswa')).toBeVisible();
```

### **4. Handle Async dengan Benar**

```javascript
// ❌ Bad
page.click('button');
page.waitForURL('/dashboard');

// ✅ Good
await page.click('button');
await page.waitForURL('/dashboard');
```

---

## 📊 Playwright Configuration

File: `playwright.config.js`

**Key Settings:**
- **Base URL:** `http://127.0.0.1:8000`
- **Timeout:** 30 seconds per action
- **Retries:** 0 (no retry)
- **Browsers:** Chromium, Firefox, Webkit
- **Screenshots:** On failure only
- **Videos:** On failure only

**Modify untuk kebutuhan:**

```javascript
// Tambah timeout jika perlu
timeout: 60000, // 60 detik

// Aktifkan retry di CI
retries: process.env.CI ? 2 : 0,

// Jalankan parallel
workers: process.env.CI ? 1 : 4,
```

---

## 🔄 CI/CD Integration (Coming Soon)

Untuk integrasi dengan GitHub Actions:

```yaml
# .github/workflows/playwright.yml
name: Playwright Tests
on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - name: Install dependencies
        run: npm ci
      - name: Install Playwright Browsers
        run: npx playwright install --with-deps
      - name: Run Playwright tests
        run: npx playwright test
      - name: Upload report
        uses: actions/upload-artifact@v3
        if: always()
        with:
          name: playwright-report
          path: playwright-report/
```

---

## 📞 Bantuan & Support

- **Dokumentasi Playwright:** https://playwright.dev/docs/intro
- **Playwright API:** https://playwright.dev/docs/api/class-playwright
- **Project Issues:** https://github.com/petrusthelastking/MAGNET-Magang-Network-And-Tracking/issues

---

## 📅 Changelog

### **2025-10-29**
- ✅ Setup Playwright E2E testing
- ✅ Implementasi test login mahasiswa (4 test cases)
- ✅ Fix database connection issue
- ✅ Fix build assets issue
- ✅ All tests passing (4/4)
- ✅ Dokumentasi lengkap

---

**Happy Testing! 🎉**
