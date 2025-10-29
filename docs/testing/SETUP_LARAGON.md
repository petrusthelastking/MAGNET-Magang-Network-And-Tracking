# 🚀 Setup Laragon Virtual Host untuk Testing

## ✅ Yang Sudah Siap:
- ✅ User NIM `6705300038` sudah ada di database
- ✅ Password sudah diupdate ke `mahasiswa123`
- ✅ Laragon Apache sudah running di port 80
- ✅ Test files Playwright sudah siap

---

## 📋 CARA SETUP LARAGON (MUDAH!)

### **Langkah 1: Pindah/Link Project ke Laragon**

**Opsi A: Symlink (Rekomendasi - tidak perlu pindah file)**
1. Buka PowerShell sebagai **Administrator**
2. Jalankan command ini:
```powershell
New-Item -ItemType SymbolicLink -Path "C:\laragon\www\magnet" -Target "c:\Peyimpanan Pribadi\Data D\New folder (2)\Semester 5\pmpl\MAGNET-Magang-Network-And-Tracking"
```

**Opsi B: Copy Project (alternatif)**
```powershell
# Copy seluruh project ke folder Laragon
Copy-Item -Path "c:\Peyimpanan Pribadi\Data D\New folder (2)\Semester 5\pmpl\MAGNET-Magang-Network-And-Tracking" -Destination "C:\laragon\www\magnet" -Recurse
```

### **Langkah 2: Buat Virtual Host Configuration**

Saya sudah buatkan file konfigurasi Apache. Tolong copy file `magnet.conf` ke folder Laragon:

**Manual Steps:**
1. Buka **Laragon**
2. Klik **Menu** → **Apache** → **sites-enabled**
3. Buat file baru: `magnet.conf`
4. Copy isi dari file `laragon-vhost.conf` yang saya buat
5. Save

### **Langkah 3: Update hosts file**

1. Buka PowerShell sebagai **Administrator**
2. Jalankan:
```powershell
Add-Content -Path "C:\Windows\System32\drivers\etc\hosts" -Value "`n127.0.0.1 magnet.test"
```

Atau edit manual:
1. Buka: `C:\Windows\System32\drivers\etc\hosts`
2. Tambahkan baris: `127.0.0.1 magnet.test`

### **Langkah 4: Restart Laragon Apache**

Di Laragon:
1. Klik tombol **Stop All**
2. Tunggu beberapa detik
3. Klik tombol **Start All**

### **Langkah 5: Test di Browser**

Buka browser dan akses:
```
http://magnet.test
```

Jika muncul halaman Laravel, berarti **BERHASIL!** ✅

---

## 🧪 TESTING LOGIN MANUAL

1. **Buka browser**: `http://magnet.test/login`
2. **Login dengan**:
   - NIM: `6705300038`
   - Password: `mahasiswa123`
3. **Klik Login**
4. Jika berhasil masuk dashboard mahasiswa → **SUKSES!** 🎉

---

## 🎭 JALANKAN PLAYWRIGHT TEST

Setelah server berjalan dan login manual berhasil:

### 1. Update baseURL di playwright.config.js
```javascript
use: {
  baseURL: 'http://magnet.test',
  // ... config lainnya
}
```

### 2. Jalankan Test
```powershell
# Test dengan browser visible
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --headed

# Test debug mode
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --debug

# Lihat report
npx playwright show-report
```

---

## 🔧 TROUBLESHOOTING

### Jika `http://magnet.test` tidak bisa diakses:

**1. Cek Apache Error Log**
```
C:\laragon\bin\apache\apache-x.x.x\logs\error.log
```

**2. Cek hosts file sudah benar**
```powershell
Get-Content C:\Windows\System32\drivers\etc\hosts | Select-String "magnet"
```

Harus muncul: `127.0.0.1 magnet.test`

**3. Restart DNS Cache**
```powershell
ipconfig /flushdns
```

**4. Cek Virtual Host Configuration**
Di Laragon, klik Menu → Apache → httpd-vhosts.conf
Pastikan ada konfigurasi untuk magnet.test

---

## ✅ HASIL AKHIR

Jika semua berhasil:
- ✅ Server running di: `http://magnet.test`
- ✅ Login manual berhasil
- ✅ Playwright test bisa dijalankan
- ✅ Test report tersedia

**Kredensial Test:**
- NIM: `6705300038`
- Password: `mahasiswa123`
