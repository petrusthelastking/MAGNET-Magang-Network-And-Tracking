# Mahasiswa Testing Guide

Panduan lengkap untuk testing fitur Mahasiswa di MAGNET system.

## 📋 Test Files

### 1. mahasiswa-login-real.spec.js
Test untuk fitur login mahasiswa.

**Status:** ⚠️ Perlu review

**Run:**
```bash
npx playwright test tests/e2e/mahasiswa/mahasiswa-login-real.spec.js --project=chromium
```

---

### 2. mahasiswa-pengajuan-magang.spec.js
Test untuk fitur pengajuan magang oleh mahasiswa.

**Status:** ⚠️ Perlu review

**Run:**
```bash
npx playwright test tests/e2e/mahasiswa/mahasiswa-pengajuan-magang.spec.js --project=chromium
```

---

## 🚀 Quick Commands

**Run semua test mahasiswa:**
```bash
npx playwright test tests/e2e/mahasiswa --project=chromium
```

**Run dengan UI mode (debugging):**
```bash
npx playwright test tests/e2e/mahasiswa --ui
```

---

## 🎯 Fitur Mahasiswa yang Bisa Ditambahkan

### Login & Authentication
**File:** `mahasiswa-login.spec.js`
- [ ] Login dengan NIM dan password valid
- [ ] Error handling untuk credentials invalid
- [ ] Validasi form kosong
- [ ] Logout functionality

### Profil Mahasiswa
**File:** `mahasiswa-profil.spec.js`
- [ ] Lihat profil mahasiswa
- [ ] Edit profil mahasiswa
- [ ] Upload foto profil
- [ ] Update CV/dokumen

### Lowongan Magang
**File:** `mahasiswa-lowongan.spec.js`
- [ ] Lihat daftar lowongan magang
- [ ] Search lowongan
- [ ] Filter lowongan (lokasi, bidang, dll)
- [ ] Lihat detail lowongan
- [ ] Apply lowongan

### Pengajuan Magang
**File:** `mahasiswa-pengajuan.spec.js`
- [ ] Buat pengajuan magang baru
- [ ] Upload dokumen persyaratan
- [ ] Lihat status pengajuan
- [ ] Edit pengajuan (jika masih pending)
- [ ] Cancel pengajuan

### Status Magang
**File:** `mahasiswa-status-magang.spec.js`
- [ ] Lihat status magang aktif
- [ ] Upload laporan progress
- [ ] Lihat feedback dari dosen
- [ ] Submit laporan akhir

### Rekomendasi
**File:** `mahasiswa-rekomendasi.spec.js`
- [ ] Lihat rekomendasi lowongan (berbasis preferensi)
- [ ] Set preferensi lowongan
- [ ] Lihat matching score

---

## 💡 Template Login Mahasiswa

```javascript
import { test, expect } from '@playwright/test';

async function loginAsMahasiswa(page, nim, password) {
  await page.goto('/login');
  await page.waitForLoadState('domcontentloaded');
  
  const userIDInput = page.locator('input[name="userID"]');
  const passwordInput = page.locator('input[type="password"]');
  
  await userIDInput.fill(nim);
  await passwordInput.fill(password);
  
  const loginButton = page.locator('button[type="submit"]');
  await loginButton.click();
  
  await page.waitForLoadState('domcontentloaded');
  await page.waitForTimeout(3000);
}

test.describe('Mahasiswa - Login Flow', () => {
  test('should successfully login as mahasiswa', async ({ page }) => {
    await loginAsMahasiswa(page, '2341720228', 'password123');
    
    // Verify redirect to mahasiswa dashboard
    await expect(page).toHaveURL(/\/dashboard/);
    console.log('✓ Successfully logged in as mahasiswa');
  });
});
```

---

## 💡 Template Pengajuan Magang

```javascript
test.describe('Mahasiswa - Pengajuan Magang', () => {
  test.beforeEach(async ({ page }) => {
    await loginAsMahasiswa(page, 'NIM_TEST', 'password');
  });

  test('should create new pengajuan magang', async ({ page }) => {
    // Navigate to pengajuan page
    await page.goto('/mahasiswa/pengajuan-magang');
    console.log('✓ Navigated to pengajuan page');
    
    // Click "Buat Pengajuan" button
    await page.locator('button').filter({ 
      hasText: /Buat Pengajuan/i 
    }).click();
    console.log('✓ Clicked create button');
    
    // Fill form
    await page.locator('input[name="perusahaan"]').fill('PT Test Company');
    await page.locator('input[name="posisi"]').fill('Software Engineer Intern');
    await page.locator('textarea[name="deskripsi"]').fill('Test description');
    console.log('✓ Filled form');
    
    // Submit
    await page.locator('button[type="submit"]').click();
    console.log('✓ Submitted form');
    
    // Verify success
    await expect(page.locator('text=/berhasil/i')).toBeVisible();
    console.log('✅ Pengajuan created successfully');
  });
});
```

---

## 📊 Test Coverage Target

| Fitur | Priority | Status |
|-------|----------|--------|
| Login | 🔴 High | ⚠️ Review needed |
| Profil | 🟡 Medium | ❌ Not created |
| Lowongan | 🔴 High | ❌ Not created |
| Pengajuan | 🔴 High | ⚠️ Review needed |
| Status Magang | 🟡 Medium | ❌ Not created |
| Rekomendasi | 🟢 Low | ❌ Not created |

---

## 🐛 Common Issues & Solutions

### Issue: Session timeout
**Solution:** Login ulang di setiap test atau gunakan `beforeEach`

### Issue: Element not found
**Solution:** Tambahkan `waitForTimeout` atau `waitForSelector`

### Issue: Test flaky
**Solution:** Tingkatkan timeout dan tambahkan retry logic

---

## 📝 Checklist untuk Test Baru

- [ ] Test independent (bisa jalan sendiri)
- [ ] Login credentials valid
- [ ] Console.log untuk tracking
- [ ] Assertion untuk verifikasi
- [ ] Cleanup setelah test
- [ ] Dokumentasi lengkap

---

**Semangat Testing! 💪**
