# ⚡ INSTRUKSI SETUP GOOGLE OAUTH - LANGSUNG JALAN (5 MENIT)

## 🔴 ERROR YANG ANDA ALAMI

```
Google OAuth belum dikonfigurasi. Hubungi administrator.
```

**Penyebab:** GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET di `.env` masih kosong!

---

## ✅ SOLUSI CEPAT (COPY-PASTE)

### LANGKAH 1️⃣ : BUKA GOOGLE CLOUD CONSOLE
```
https://console.cloud.google.com
```

Login dengan akun Google Anda.

---

### LANGKAH 2️⃣ : BUAT PROJECT BARU

1. **Klik dropdown Project** (atas, sebelah logo Google)
2. **Klik "New Project"**
3. Nama: `Aplikasi Preloved`
4. **Klik "Create"**
5. Tunggu ~2 menit sampai selesai

---

### LANGKAH 3️⃣ : LANGSUNG KE CREDENTIALS (SKIP GOOGLE+ API)

**PENTING:** Google+ API sudah dinonaktifkan oleh Google (sejak 7 Maret 2019).
Kita tidak perlu mengaktifkannya! Langsung ke step berikutnya.

**Pergi ke:** APIs & Services → **Credentials**

### LANGKAH 4️⃣ : BUAT OAUTH CLIENT

1. **Klik tombol biru:** "+ Create Credentials"
2. **Pilih:** "OAuth 2.0 Client ID"

1. **Pilih:** Web application
2. **Nama:** Aplikas
### LANGKAH 6️⃣ : MASUKKAN AUTHORIZED ORIGINS

Di form yang muncul, bagian **"Authorized JavaScript origins"**:

1. **Klik "Add URI"**
2. **Ketik:** `http://localhost:8000`
3. **Klik tombol centang ✓**

---

### LANGKAH 7️⃣ : MASUKKAN REDIRECT URI

Di bagian **"Authorized redirect URIs"**:

1. **Klik "Add URI"**
2. **Ketik PERSIS:** `http://localhost:8000/auth/google/callback`
### LANGKAH 6️⃣ : MASUKKAN AUTHORIZED ORIGINS

Di form yang muncul, bagian **"Authorized JavaScript origins"**:

1. **Klik "Add URI"**
2. **Ketik:** `http://localhost:8000`
3. **Klik tombol centang ✓**

---

### LANGKAH 7️⃣ : MASUKKAN REDIRECT URI
```env
# Google OAuth Configuration
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

**GANTI dengan nilai Anda:**
```env
GOOGLE_CLIENT_ID=123456789-abcd.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-xxx123456
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

**CONTOH REAL:**
```env
GOOGLE_CLIENT_ID=1234567890-abc1def2.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-a1b2c3d4e5f6g7h8
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

---

### LANGKAH 🔟 : SAVE FILE

**Tekan:** Ctrl+S (atau Cmd+S)

Pastikan file sudah tersave (tidak ada dot di tab file).

---

### LANGKAH 1️⃣1️⃣ : RESTART SERVER

Di terminal tempat server berjalan:

1. **Tekan:** Ctrl+C (untuk stop)
2. **Jalankan lagi:**
   ```bash
   php artisan serve
   ```

---

### LANGKAH 1️⃣2️⃣ : TEST

1. **Buka:** http://localhost:8000/login
2. **Klik:** "Sign in with Google" atau "Sign up with Google"
3. **Pilih akun Google Anda**
4. **Klik "Allow" atau "Grant Permission"**
5. **Seharusnya berhasil login!** ✅

---

## ❌ JIKA MASIH ERROR

### Cek 1: Apakah nilai sudah diisi?
```env
# Buka .env dan pastikan:
GOOGLE_CLIENT_ID=xxx.apps.googleusercontent.com  # TIDAK BOLEH KOSONG
GOOGLE_CLIENT_SECRET=xxx                          # TIDAK BOLEH KOSONG
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback  # Sudah benar
```

### Cek 2: Apakah nilai benar?
### LANGKAH 8️⃣ : COPY CLIENT ID DAN SECRET

Setelah klik Create, Anda akan lihat popup dengan:

```
Client ID: xxx.apps.googleusercontent.com
Client Secret: xxx
```

**COPY KEDUA NILAI INI!**

---

### LANGKAH 9️⃣ : EDIT FILE .envda petik (")

### Cek 3: Apakah server sudah restart?
```bash
# Stop dengan Ctrl+C
# Jalankan: php artisan serve
```

### Cek 4: Apakah di Google Console sudah benar?
- ✅ Authorized JavaScript origins ada `http://localhost:8000`
- ✅ Authorized Redirect URIs ada `http://localhost:8000/auth/google/callback`
- ✅ Google+ API sudah diaktifkan

### Cek 5: Clear browser cache
- Tekan Ctrl+Shift+Delete
- Clear cache dan cookies
- Refresh page

---

## 📝 CHECKLIST FINAL

Sebelum test, pastikan:

- [ ] .env sudah punya GOOGLE_CLIENT_ID (tidak kosong)
- [ ] .env sudah punya GOOGLE_CLIENT_SECRET (tidak kosong)
- [ ] Nilai PERSIS sama dengan di Google Console
- [ ] .env sudah di-save
- [ ] Server sudah di-restart
- [ ] Google+ API sudah diaktifkan
- [ ] Redirect URI di Google Console sudah benar

---

## ✅ VERIFIKASI

Setelah selesai, jalankan:

```bash
php artisan auth:test-setup
```

Output harus:
```
✅ Google OAuth config found
✅ Authentication Setup is Ready!
```

---

## 🎉 BERHASIL!

Sekarang seharusnya:
- ✅ Bisa login dengan Google
- ✅ Email terverifikasi otomatis
- ✅ Akun sudah bisa digunakan

---

## 📞 BANTUAN

Jika masih error, cek file:
- `GOOGLE_OAUTH_VISUAL_GUIDE.md` - Visual step-by-step
- `FIX_GOOGLE_OAUTH_ERROR.md` - Troubleshooting lengkap

---

**PENTING:** Jangan biarkan GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET kosong!

Kedua nilai WAJIB diisi agar Google OAuth bisa bekerja.

---

*Estimated time: 5-10 minutes*
