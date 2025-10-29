# ✅ CHECKLIST: Testing Login Mahasiswa

## 📋 PERSIAPAN (Sudah Selesai)
- [x] User test NIM `6705300038` sudah dibuat
- [x] Password sudah diupdate ke `mahasiswa123`
- [x] Test file Playwright sudah dibuat
- [x] Laragon Apache sudah running
- [x] Virtual Host configuration sudah dibuat (`laragon-vhost.conf`)
- [x] Setup script sudah dibuat (`setup-laragon.ps1`)
- [x] Playwright baseURL sudah diupdate ke `http://magnet.test`

---

## 🚀 LANGKAH EKSEKUSI (Yang Perlu Anda Lakukan)

### ✅ Step 1: Setup Laragon Virtual Host

**Command:**
```powershell
# Buka PowerShell sebagai Administrator (Klik Kanan → Run as Administrator)
cd "c:\Peyimpanan Pribadi\Data D\New folder (2)\Semester 5\pmpl\MAGNET-Magang-Network-And-Tracking"
.\setup-laragon.ps1
```

**Hasil yang diharapkan:**
```
✅ Running as Administrator
✅ Laragon found at: C:\laragon
✅ Virtual Host configuration copied
✅ Added 'magnet.test' to hosts file
✅ DNS cache flushed
✅ SETUP SELESAI!
```

**Lalu:**
1. Buka aplikasi **Laragon**
2. Klik tombol **"Stop All"**
3. Tunggu beberapa detik
4. Klik tombol **"Start All"**

---

### ✅ Step 2: Verifikasi Server Running

**Test 1: Cek di browser**
```
http://magnet.test
```

**Hasil yang diharapkan:**
- ✅ Muncul homepage Laravel (MAGNET application)
- ❌ Jika error: Cek troubleshooting di bawah

**Test 2: Cek login page**
```
http://magnet.test/login
```

**Hasil yang diharapkan:**
- ✅ Muncul halaman login dengan form username & password

---

### ✅ Step 3: Test Login Manual

**Di browser** `http://magnet.test/login`:
1. Isi **NIM/Username**: `6705300038`
2. Isi **Password**: `mahasiswa123`
3. Klik tombol **Login**

**Hasil yang diharapkan:**
- ✅ Redirect ke dashboard mahasiswa
- ✅ Muncul nama: "Dejuan Wiegand"
- ✅ Muncul data mahasiswa yang sesuai
- ❌ Jika error "kredensial salah": Cek database

---

### ✅ Step 4: Jalankan Playwright Test

**Command:**
```powershell
# Di terminal biasa (tidak perlu Administrator)
.\run-mahasiswa-login-test.bat
```

**Atau manual:**
```powershell
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --headed --project=chromium
```

**Hasil yang diharapkan:**
```
Running 4 tests using 1 worker

  ✓ 1 mahasiswa-login-real.spec.js:7:5 › should successfully login as mahasiswa with NIM 6705300038
  ✓ 2 mahasiswa-login-real.spec.js:23:5 › should display mahasiswa dashboard after login
  ✓ 3 mahasiswa-login-real.spec.js:34:5 › should show error with wrong password
  ✓ 4 mahasiswa-login-real.spec.js:50:5 › should be able to navigate after login

  4 passed (XXs)
```

---

### ✅ Step 5: Lihat Test Report

**Command:**
```powershell
npx playwright show-report
```

**Hasil yang diharapkan:**
- Browser terbuka dengan HTML report
- Semua test case berwarna hijau (passed)
- Screenshots tersedia untuk setiap step
- Video tersedia jika ada test yang gagal

---

## 🔧 TROUBLESHOOTING

### ❌ Problem: `http://magnet.test` tidak bisa diakses

**Solusi 1: Cek hosts file**
```powershell
Get-Content C:\Windows\System32\drivers\etc\hosts | Select-String "magnet"
```
Harus muncul: `127.0.0.1 magnet.test`

**Solusi 2: Flush DNS lagi**
```powershell
ipconfig /flushdns
```

**Solusi 3: Restart browser dan clear cache**
- Tutup semua tab browser
- Buka lagi dan coba akses `http://magnet.test`

**Solusi 4: Cek Laragon Apache running**
- Buka Laragon
- Pastikan Apache berwarna hijau (running)
- Jika tidak, klik "Start All"

---

### ❌ Problem: Login gagal dengan "Kredensial tidak valid"

**Solusi: Cek password di database**
```powershell
php artisan tinker --execute="print_r(\App\Models\Mahasiswa::where('nim', '6705300038')->first());"
```

Jika password masih salah, update lagi:
```powershell
php artisan db:seed --class=UpdateMahasiswaPasswordSeeder
```

---

### ❌ Problem: Playwright test timeout

**Solusi 1: Cek baseURL di playwright.config.js**
Pastikan:
```javascript
baseURL: 'http://magnet.test',
```

**Solusi 2: Test koneksi dari Playwright**
```powershell
npx playwright test tests/e2e/debug-server-connectivity.spec.js --headed
```

**Solusi 3: Tambah timeout**
Edit `playwright.config.js`:
```javascript
timeout: 60000, // 60 seconds
```

---

## 📊 HASIL AKHIR YANG DIHARAPKAN

### ✅ Checklist Keberhasilan:
- [ ] Setup Laragon selesai tanpa error
- [ ] `http://magnet.test` bisa diakses dan muncul homepage
- [ ] Login manual berhasil dengan NIM `6705300038`
- [ ] Playwright test semua passed (4/4)
- [ ] Test report bisa dibuka
- [ ] Screenshots & videos tersimpan

---

## 📁 FILE PENTING

- **Setup Script**: `setup-laragon.ps1`
- **Virtual Host Config**: `laragon-vhost.conf`
- **Test Runner**: `run-mahasiswa-login-test.bat`
- **Test File**: `tests/e2e/mahasiswa-login-real.spec.js`
- **Playwright Config**: `playwright.config.js`
- **Dokumentasi Lengkap**: `PANDUAN_TESTING_LOGIN.md`
- **Setup Guide**: `SETUP_LARAGON.md`

---

## 🎯 KREDENSIAL TEST

**Mahasiswa:**
- NIM: `6705300038`
- Password: `mahasiswa123`
- Nama: Dejuan Wiegand
- Email: anjali18@example.com

**Server:**
- URL: `http://magnet.test`
- Login Page: `http://magnet.test/login`
- Dashboard: `http://magnet.test/mahasiswa/dashboard`

---

## 🚀 NEXT STEPS SETELAH BERHASIL

1. ✅ Test login mahasiswa berhasil → Lanjut ke test lain
2. ✅ Buat test untuk role Admin
3. ✅ Buat test untuk role Perusahaan
4. ✅ Buat test untuk fitur lowongan magang
5. ✅ Buat test untuk sistem rekomendasi
6. ✅ Setup CI/CD untuk automated testing

---

**Selamat testing! 🎉**
