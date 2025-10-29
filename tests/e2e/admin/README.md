# Admin Testing Guide

Panduan lengkap untuk testing fitur Admin di MAGNET system.

## 📋 Test Files

### 1. admin-login.spec.js (4 tests)
Test untuk fitur login admin.

**Test Cases:**
- ✅ Login dengan NIP dan password yang valid
- ✅ Error message saat credentials invalid
- ✅ Validasi error saat submit form kosong
- ✅ Struktur form login (input fields, button)

**Credentials:**
- NIP: `077583473350128777`
- Password: `admin123`

**Run:**
```bash
npx playwright test tests/e2e/admin/admin-login.spec.js --project=chromium
```

---

### 2. admin-data-mahasiswa.spec.js (7 tests)
Test untuk fitur kelola data mahasiswa (display, navigation, search).

**Test Cases:**
- ✅ Navigasi dari dashboard ke Data Mahasiswa
- ✅ Display page dengan title dan table
- ✅ Search functionality
- ✅ Pagination
- ✅ Display record count
- ✅ View detail mahasiswa
- ✅ Display action buttons

**Run:**
```bash
npx playwright test tests/e2e/admin/admin-data-mahasiswa.spec.js --project=chromium
```

---

### 3. admin-data-mahasiswa-crud.spec.js (5 tests)
Test untuk CRUD operations data mahasiswa.

**Test Cases:**
- ✅ Open modal Tambah Mahasiswa dengan 8 fields
- ✅ Form validation (14 error messages)
- ✅ Import button (UI only)
- ✅ Export button (UI only)
- ✅ Button layout verification

**Form Fields:**
1. Nama
2. NIM
3. Email
4. Jenis Kelamin
5. Tanggal Lahir
6. Angkatan
7. Program Studi
8. Alamat

**Run:**
```bash
npx playwright test tests/e2e/admin/admin-data-mahasiswa-crud.spec.js --project=chromium
```

---

## 🚀 Quick Commands

**Run semua test admin:**
```bash
npx playwright test tests/e2e/admin --project=chromium
```

**Run dengan UI mode (debugging):**
```bash
npx playwright test tests/e2e/admin --ui
```

**Run specific test:**
```bash
npx playwright test tests/e2e/admin/admin-login.spec.js -g "should successfully login" --project=chromium
```

---

## 📊 Current Status

| File | Tests | Status | Coverage |
|------|-------|--------|----------|
| admin-login.spec.js | 4 | ✅ 100% | Login flow |
| admin-data-mahasiswa.spec.js | 7 | ✅ 100% | Display & navigation |
| admin-data-mahasiswa-crud.spec.js | 5 | ✅ 100% | CRUD operations |
| **TOTAL** | **16** | **✅ 100%** | **16/16 Passing** |

---

## 🎯 Fitur Admin yang Bisa Ditambahkan

### Kelola Data Dosen
**File baru:** `admin-kelola-dosen.spec.js`
- [ ] Lihat daftar dosen
- [ ] Tambah dosen baru
- [ ] Edit data dosen
- [ ] Hapus data dosen
- [ ] Search dan filter dosen

### Kelola Lowongan Magang
**File baru:** `admin-kelola-lowongan.spec.js`
- [ ] Lihat daftar lowongan
- [ ] Tambah lowongan baru
- [ ] Edit lowongan
- [ ] Hapus lowongan
- [ ] Approve/reject lowongan dari perusahaan

### Laporan dan Statistik
**File baru:** `admin-laporan.spec.js`
- [ ] Lihat dashboard statistik
- [ ] Export laporan mahasiswa
- [ ] Export laporan lowongan
- [ ] Filter laporan berdasarkan periode

### Pengaturan Sistem
**File baru:** `admin-pengaturan.spec.js`
- [ ] Update profil admin
- [ ] Ubah password
- [ ] Konfigurasi sistem
- [ ] Manage roles & permissions

---

## 💡 Tips untuk Menulis Test Admin

### 1. Helper Functions
Gunakan helper function untuk login:
```javascript
async function loginAsAdmin(page) {
  await page.goto('/login');
  await page.waitForLoadState('domcontentloaded');
  
  await page.locator('input[name="userID"]').fill('077583473350128777');
  await page.locator('input[type="password"]').fill('admin123');
  await page.locator('button[type="submit"]').click();
  
  await page.waitForLoadState('domcontentloaded');
  await page.waitForTimeout(3000);
}
```

### 2. Navigation Helper
Untuk navigasi ke submenu:
```javascript
async function navigateToDataMahasiswa(page) {
  // Klik menu Kelola Data Master
  await page.locator('button, div, a').filter({ 
    hasText: /Kelola Data Master/i 
  }).first().click();
  
  await page.waitForTimeout(500);
  
  // Klik Data Mahasiswa
  await page.locator('a[href*="data-mahasiswa"]').first()
    .evaluate(el => el.click());
  
  await page.waitForLoadState('domcontentloaded');
}
```

### 3. Form Validation
Check validasi dengan menghitung error messages:
```javascript
const errorMessages = page.locator('[class*="error"], [class*="invalid"]');
const errorCount = await errorMessages.count();
console.log(`✓ Found ${errorCount} validation error(s)`);
expect(errorCount).toBeGreaterThan(0);
```

### 4. Table Operations
Untuk test table data:
```javascript
// Check table exists
await expect(page.locator('table').first()).toBeVisible();

// Count rows
const rows = page.locator('tbody tr');
const rowCount = await rows.count();
console.log(`✓ Found ${rowCount} row(s) in table`);

// Check specific cell
const firstCell = page.locator('tbody tr').first()
  .locator('td').first();
const cellText = await firstCell.textContent();
```

---

## 🐛 Debugging Tips

**Screenshot saat error:**
```javascript
await page.screenshot({ path: 'debug-screenshot.png' });
```

**Print current URL:**
```javascript
console.log('Current URL:', page.url());
```

**Wait for element:**
```javascript
await page.waitForSelector('selector', { timeout: 10000 });
```

**Check if element exists:**
```javascript
const exists = await page.locator('selector').count() > 0;
console.log('Element exists:', exists);
```

---

## 📝 Checklist untuk Test Baru

Sebelum commit test baru, pastikan:

- [ ] Test bisa berjalan sendiri (independent)
- [ ] Test bisa berjalan bersamaan dengan test lain
- [ ] Ada console.log untuk tracking progress
- [ ] Ada assertion (`expect`) untuk verifikasi
- [ ] Timeout yang cukup untuk loading
- [ ] Clean up setelah test (jika perlu)
- [ ] Dokumentasi di bagian atas file

---

**Happy Testing! 🎉**
