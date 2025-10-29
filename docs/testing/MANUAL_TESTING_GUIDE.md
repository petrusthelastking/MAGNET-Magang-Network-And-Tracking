# Testing Login Mahasiswa - Manual Steps

## ⚠️ Sebelum Menjalankan Test

### 1. Start Laravel Server secara Manual
Buka terminal PowerShell BARU dan jalankan:
```powershell
cd "C:\Peyimpanan Pribadi\Data D\New folder (2)\Semester 5\pmpl\MAGNET-Magang-Network-And-Tracking"
php artisan serve
```

**Penting:** Biarkan terminal ini tetap terbuka! Server harus tetap running.

### 2. Verifikasi Server Running
Buka browser dan akses: **http://localhost:8000**  
Pastikan aplikasi Laravel muncul.

### 3. Verifikasi User Test Ada
User mahasiswa sudah dibuat dengan kredensial:
- **NIM**: 6705300038
- **Password**: mahasiswa123

## ▶️ Menjalankan Test

Setelah server Laravel running, buka terminal PowerShell BARU dan jalankan:

```powershell
# Test dengan browser terlihat (RECOMMENDED untuk melihat proses)
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --headed --project=chromium

# Test tanpa browser terlihat (headless)
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --project=chromium

# Test dengan UI mode (interactive)
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --ui

# Test dengan debug mode
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --debug
```

## 📋 Test yang Akan Dijalankan

File test: `tests/e2e/mahasiswa-login-real.spec.js`

### Test Cases:
1. ✅ **Login Sukses** - Login dengan NIM 6705300038 dan password mahasiswa123
2. ✅ **Dashboard** - Memverifikasi dashboard mahasiswa tampil setelah login
3. ✅ **Password Salah** - Test error handling saat password salah
4. ✅ **Navigasi** - Test kemampuan navigasi setelah login

## 📸 Screenshots
Test akan otomatis membuat screenshots di folder `test-results/`:
- `01-login-page.png` - Halaman login
- `02-login-form-filled.png` - Form sudah diisi
- `03-after-login.png` - Setelah login berhasil
- `04-mahasiswa-dashboard.png` - Dashboard mahasiswa
- `05-login-error.png` - Error saat password salah
- `06-nav-*.png` - Berbagai halaman navigasi

## 📊 Melihat Report
Setelah test selesai:
```powershell
npx playwright show-report
```

## 🐛 Troubleshooting

### Test gagal dengan "Connection Refused"
**Penyebab:** Laravel server belum running  
**Solusi:** Pastikan `php artisan serve` masih running di terminal lain

### Test gagal di halaman login
**Penyebab:** Selector mungkin tidak cocok dengan UI  
**Solusi:** Buka test file dan sesuaikan selector dengan elemen HTML yang sebenarnya

### User tidak ditemukan
**Penyebab:** User belum di-seed  
**Solusi:** Jalankan:
```powershell
php artisan db:seed --class=RealMahasiswaSeeder
```

## 💡 Tips
- Gunakan `--headed` untuk melihat browser beraksi (bagus untuk debugging)
- Gunakan `--ui` untuk mode interactive (bisa pause/resume test)
- Gunakan `--debug` untuk step-by-step debugging
- Screenshots otomatis tersimpan saat test gagal

## 📝 Modifikasi Test
Edit file: `tests/e2e/mahasiswa-login-real.spec.js`

Anda bisa:
- Tambah test case baru
- Ubah kredensial login
- Tambah assertion tambahan
- Customize screenshot path

## ✅ Expected Result
Jika semua berjalan lancar:
```
Running 4 tests using 1 worker

  ✓ should successfully login as mahasiswa with NIM 6705300038
  ✓ should display mahasiswa dashboard after login  
  ✓ should show error with wrong password
  ✓ should be able to navigate after login

4 passed
```
