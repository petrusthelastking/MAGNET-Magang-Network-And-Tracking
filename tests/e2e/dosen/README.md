# Dosen Testing

Folder ini digunakan untuk semua test terkait role Dosen.

## 📋 Test yang Perlu Dibuat

### 1. Login Dosen
**File:** `dosen-login.spec.js`
- [ ] Login dengan NIP dan password valid
- [ ] Error handling untuk credentials invalid
- [ ] Validasi form kosong

### 2. Monitoring Mahasiswa Bimbingan
**File:** `dosen-monitoring-mahasiswa.spec.js`
- [ ] Lihat daftar mahasiswa bimbingan
- [ ] Filter mahasiswa berdasarkan status
- [ ] View detail progress mahasiswa

### 3. Approve Pengajuan Magang
**File:** `dosen-approve-pengajuan.spec.js`
- [ ] Lihat daftar pengajuan yang pending
- [ ] Approve pengajuan magang
- [ ] Reject pengajuan dengan alasan
- [ ] Lihat history approval

### 4. Evaluasi Mahasiswa
**File:** `dosen-evaluasi-mahasiswa.spec.js`
- [ ] Input nilai/evaluasi mahasiswa
- [ ] Upload dokumen evaluasi
- [ ] Lihat riwayat evaluasi

---

## 🚀 Cara Mulai

1. Copy template dari salah satu file di `tests/e2e/admin/` sebagai referensi
2. Sesuaikan credentials untuk login dosen
3. Identifikasi selector HTML untuk fitur dosen
4. Tulis test step by step

---

## 📝 Template Login Dosen

```javascript
import { test, expect } from '@playwright/test';

async function loginAsDosen(page) {
  await page.goto('/login');
  await page.waitForLoadState('domcontentloaded');
  
  const userIDInput = page.locator('input[name="userID"]');
  const passwordInput = page.locator('input[type="password"]');
  
  await userIDInput.fill('NIP_DOSEN'); // Ganti dengan NIP dosen
  await passwordInput.fill('PASSWORD_DOSEN'); // Ganti dengan password
  
  const loginButton = page.locator('button[type="submit"]');
  await loginButton.click();
  
  await page.waitForLoadState('domcontentloaded');
  await page.waitForTimeout(3000);
}

test.describe('Dosen - Login Flow', () => {
  test('should successfully login as dosen', async ({ page }) => {
    await loginAsDosen(page);
    
    // Verify redirect to dosen dashboard
    await expect(page).toHaveURL(/\/dashboard/);
  });
});
```

---

**Silakan mulai membuat test dosen! 🎓**
