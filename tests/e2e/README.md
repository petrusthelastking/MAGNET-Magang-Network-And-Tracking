# E2E Testing Structure

Struktur folder testing ini dirancang agar mudah dipahami dan dikerjakan oleh tim.

## 📁 Struktur Folder

```
tests/e2e/
├── admin/                      # Testing untuk role Admin
│   ├── admin-login.spec.js            # Test login admin
│   ├── admin-data-mahasiswa.spec.js   # Test kelola data mahasiswa
│   └── admin-data-mahasiswa-crud.spec.js  # Test CRUD mahasiswa
│
├── mahasiswa/                  # Testing untuk role Mahasiswa
│   ├── mahasiswa-login-real.spec.js       # Test login mahasiswa
│   └── mahasiswa-pengajuan-magang.spec.js # Test pengajuan magang
│
├── dosen/                      # Testing untuk role Dosen
│   └── (belum ada test)
│
├── shared/                     # File helper dan test umum
│   ├── helpers.js              # Helper functions
│   └── auth.spec.js            # Test authentication umum
│
└── (file lain di root)         # Test general/homepage
    ├── homepage.spec.js
    ├── lowongan-magang.spec.js
    └── recommendation-system.spec.js
```

---

## 🎯 Cara Menjalankan Test

### Test Berdasarkan Role:

**Admin:**
```bash
npx playwright test tests/e2e/admin --project=chromium
```

**Mahasiswa:**
```bash
npx playwright test tests/e2e/mahasiswa --project=chromium
```

**Dosen:**
```bash
npx playwright test tests/e2e/dosen --project=chromium
```

### Test Spesifik File:

```bash
npx playwright test tests/e2e/admin/admin-login.spec.js --project=chromium
```

### Test Semua E2E:

```bash
npx playwright test tests/e2e --project=chromium
```

---

## 📝 Panduan untuk Teman-Teman

### 1️⃣ Admin Testing
**Folder:** `tests/e2e/admin/`

**Yang sudah ada:**
- ✅ Login admin (4 tests)
- ✅ Kelola data mahasiswa (7 tests)
- ✅ CRUD mahasiswa (5 tests)

**Yang bisa ditambahkan:**
- [ ] Kelola data dosen
- [ ] Kelola lowongan magang
- [ ] Laporan dan statistik
- [ ] Pengaturan sistem

### 2️⃣ Mahasiswa Testing
**Folder:** `tests/e2e/mahasiswa/`

**Yang sudah ada:**
- ✅ Login mahasiswa
- ✅ Pengajuan magang

**Yang bisa ditambahkan:**
- [ ] Lihat lowongan magang
- [ ] Update profil mahasiswa
- [ ] Lihat status magang
- [ ] Upload dokumen

### 3️⃣ Dosen Testing
**Folder:** `tests/e2e/dosen/`

**Status:** Folder kosong, siap untuk dikerjakan

**Yang perlu dibuat:**
- [ ] Login dosen
- [ ] Monitoring mahasiswa bimbingan
- [ ] Approve pengajuan magang
- [ ] Evaluasi mahasiswa

---

## 🔧 Template Test Baru

Gunakan template ini untuk membuat test baru:

```javascript
import { test, expect } from '@playwright/test';

test.describe('Nama Fitur - Role', () => {
  test.beforeEach(async ({ page }) => {
    // Setup: Login atau navigasi awal
  });

  test('should do something', async ({ page }) => {
    // Arrange: Persiapan data/state
    
    // Act: Lakukan aksi
    
    // Assert: Verifikasi hasil
    expect(something).toBeTruthy();
  });
});
```

---

## 📊 Test Coverage Saat Ini

| Role | Total Tests | Status |
|------|-------------|--------|
| Admin | 16 | ✅ 100% Passing |
| Mahasiswa | 2 | ⚠️ Perlu review |
| Dosen | 0 | ❌ Belum ada |

---

## 💡 Tips untuk Menulis Test

1. **Gunakan helper function** dari `shared/helpers.js`
2. **Buat test yang independent** - setiap test bisa berjalan sendiri
3. **Gunakan console.log** untuk debugging: `console.log('✓ Step completed')`
4. **Timeout yang cukup** untuk loading: `await page.waitForTimeout(2000)`
5. **Verifikasi hasil** dengan `expect()` setelah setiap aksi penting

---

## 🤝 Kontribusi

Jika ingin menambah test baru:

1. Pilih folder sesuai role (admin/mahasiswa/dosen)
2. Buat file baru: `{role}-{fitur}.spec.js`
3. Ikuti template di atas
4. Jalankan test untuk memastikan passing
5. Commit dengan message yang jelas

**Contoh nama file:**
- `admin-kelola-dosen.spec.js`
- `mahasiswa-lihat-lowongan.spec.js`
- `dosen-monitoring-mahasiswa.spec.js`

---

**Happy Testing! 🚀**
