# 🎯 SOLUSI: Testing Login Mahasiswa dengan Playwright

## ❗ MASALAH YANG TERJADI
Laravel development server (`php artisan serve`) tidak bisa start di sistem Anda.

## ✅ SOLUSI LENGKAP

### Langkah 1: Start Server Laravel dengan Cara Manual

Silakan pilih **salah satu** cara berikut:

#### Opsi A: Menggunakan XAMPP (RECOMMENDED)
1. Install XAMPP jika belum ada
2. Start Apache di XAMPP Control Panel
3. Copy folder project ini ke `C:\xampp\htdocs\`
4. Akses via browser: `http://localhost/MAGNET-Magang-Network-And-Tracking/public`
5. Test manual login dulu dengan browser

#### Opsi B: Menggunakan Laragon (RECOMMENDED)
1. Install Laragon jika belum ada
2. Copy folder project ke `C:\laragon\www\`
3. Laragon akan auto-detect project Laravel
4. Akses via: `http://magnet.test` atau `http://localhost/MAGNET-Magang-Network-And-Tracking/public`

#### Opsi C: PHP Built-in Server (Alternatif)
Buka PowerShell di folder project, jalankan:
```powershell
cd public
php -S localhost:8000 server.php
```
Akses: `http://localhost:8000`

### Langkah 2: Verifikasi Server Berjalan

1. Buka browser (Chrome/Edge/Firefox)
2. Akses URL server Anda
3. Pastikan halaman Laravel muncul
4. Coba akses halaman login manual
5. Test login dengan:
   - **NIM**: 6705300038
   - **Password**: mahasiswa123

✅ Jika login berhasil manual, lanjut ke Langkah 3

### Langkah 3: Update URL di Playwright Config

Edit file `playwright.config.js`, cari baris:
```javascript
baseURL: 'http://127.0.0.1:8000',
```

Ganti dengan URL server Anda, contoh:
```javascript
// Untuk XAMPP/Laragon
baseURL: 'http://localhost/MAGNET-Magang-Network-And-Tracking/public',

// Atau jika menggunakan PHP built-in
baseURL: 'http://localhost:8000',

// Atau jika Laragon dengan virtual host
baseURL: 'http://magnet.test',
```

### Langkah 4: Jalankan Test Playwright

Buka PowerShell BARU di folder project, jalankan:

```powershell
# Test dengan browser visible (bisa lihat prosesnya)
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --headed --project=chromium

# Atau test dalam UI mode (interactive)
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --ui

# Atau debug mode (step by step)
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --debug
```

## 📋 Kredensial Test

- **NIM**: `6705300038`
- **Password**: `mahasiswa123`

User ini sudah dibuat di database via seeder.

## 🎯 Yang Akan Di-test

✅ Login dengan NIM dan password yang benar  
✅ Verifikasi redirect ke dashboard  
✅ Test error handling (password salah)  
✅ Test navigasi setelah login  

## 📸 Output Test

- Screenshots otomatis di folder `test-results/`
- Video recording (jika test gagal)
- HTML report (jalankan `npx playwright show-report`)

## 🐛 Troubleshooting

### Test masih gagal "Connection Refused"
**Solusi**: 
1. Pastikan server benar-benar running (cek di browser)
2. Pastikan `baseURL` di `playwright.config.js` sudah benar
3. Jalankan test debug: `npx playwright test tests/e2e/debug-server-connectivity.spec.js`

### Login gagal di test tapi berhasil manual
**Solusi**:
- Selector mungkin perlu disesuaikan
- Jalankan dengan `--debug` untuk inspect element
- Cek screenshot di `test-results/` untuk lihat apa yang terjadi

### User not found
**Solusi**:
```powershell
php artisan db:seed --class=RealMahasiswaSeeder
```

## 💡 Tips

1. **Selalu test manual dulu** di browser sebelum run Playwright
2. **Gunakan --headed** untuk lihat apa yang terjadi
3. **Check screenshots** di test-results jika ada error
4. **Gunakan --debug** untuk debugging step-by-step

## 📞 Butuh Bantuan?

1. Pastikan aplikasi Laravel bisa diakses di browser
2. Pastikan bisa login manual dengan kredensial test
3. Update `baseURL` di playwright.config.js
4. Jalankan test dengan --headed untuk lihat prosesnya

---

**Next Step**: Start server Laravel Anda dulu, lalu update `baseURL` di config! 🚀
