# 📸 Visual Guide - Setup Google OAuth (Step-by-Step)

## ⚡ Quick Summary

Error Anda terjadi karena **GOOGLE_CLIENT_ID belum dikonfigurasi di `.env`**

Ikuti panduan di bawah untuk setup dalam **5 menit**.

---

## 🔗 Step 1: Buka Google Cloud Console

**URL:** https://console.cloud.google.com

Anda akan melihat dashboard Google Cloud.

---

## 📝 Step 2: Buat Project Baru

1. Klik dropdown **Project** di atas (biasanya ada logo Google)
2. Klik **"Create New Project"**
3. Nama: `Aplikasi Preloved` (atau nama apapun)
4. Klik **"Create"**
5. Tunggu project selesai dibuat (~2 menit)

---

## 🔌 Step 3: Aktifkan Google+ API

1. Di search bar, cari: **"Google+ API"**
2. Klik hasil pencarian
3. Klik **"Enable"** (tombol biru)
4. Tunggu proses selesai

---

## 🔑 Step 4: Buat OAuth Credentials

1. Di sidebar, klik **APIs & Services** → **Credentials**
2. Klik **"+ Create Credentials"** (tombol biru)
3. Pilih **"OAuth 2.0 Client IDs"**

---

## 🌐 Step 5: Pilih Application Type

1. Pilih **"Web application"**
2. Beri nama: `Aplikasi Preloved` atau `My App`
3. Klik **"Create"**

---

## 📍 Step 6: Authorized Origins

Di bagian **"Authorized JavaScript origins"**:

1. Klik **"Add URI"**
2. Masukkan: `http://localhost:8000`
3. Klik checkmark atau Enter

---

## 🔄 Step 7: Authorized Redirect URIs

Di bagian **"Authorized redirect URIs"**:

1. Klik **"Add URI"**
2. Masukkan **PERSIS**: `http://localhost:8000/auth/google/callback`
   - ⚠️ **PENTING:** Harus termasuk `/auth/google/callback`
   - Jangan lupa "callback" di akhir!
3. Klik checkmark atau Enter
4. Klik **"Save"** atau **"Create"**

---

## 📋 Step 8: Copy Credentials

Setelah klik Create, Anda akan melihat popup dengan:

```
Client ID: 123456789-abc.apps.googleusercontent.com
Client Secret: GOCSPX-abcdef123456
```

**Copy kedua nilai ini!** (Anda akan butuh di step berikutnya)

---

## 📝 Step 9: Update `.env` File

Di project Anda, buka file `.env` (di root folder)

Cari atau tambahkan baris ini:

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

**Isi dengan nilai yang Anda copy:**

```env
GOOGLE_CLIENT_ID=123456789-abc.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-abcdef123456
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

---

## 💾 Step 10: Save File

1. **Save `.env` file** (Ctrl+S atau Cmd+S)
2. Pastikan file sudah ter-save (lihat tanda di tab file)

---

## 🔄 Step 11: Restart Server

Jika sudah ada server yang berjalan:

1. **Stop server** (Ctrl+C di terminal)
2. **Jalankan lagi**: `php artisan serve`

---

## ✅ Step 12: Test Login

1. Buka browser: http://localhost:8000/login
2. Klik tombol **"Sign in with Google"** atau **"Sign up with Google"**
3. Pilih akun Google Anda
4. Grant permission jika diminta
5. **Seharusnya berhasil login!** ✅

---

## 🎉 Success!

Jika berhasil, Anda akan:
- Ter-redirect ke dashboard
- Email terverifikasi otomatis
- Akun sudah bisa digunakan

---

## ❌ Jika Masih Error

### Cek 1: Pastikan Nilai Benar
```env
# Check di .env:
# - GOOGLE_CLIENT_ID ada dan benar
# - GOOGLE_CLIENT_SECRET ada dan benar
# - Tidak ada spasi di awal/akhir
```

### Cek 2: Pastikan Redirect URI Sama
```
Di Google Cloud Console: http://localhost:8000/auth/google/callback
Di .env: http://localhost:8000/auth/google/callback
← Harus PERSIS SAMA
```

### Cek 3: Pastikan Server Direstart
```bash
# Stop server dengan Ctrl+C
# Jalankan lagi:
php artisan serve
```

### Cek 4: Clear Browser Cache
- Tekan Ctrl+Shift+Delete
- Clear cache & cookies
- Refresh page

### Cek 5: Check Logs
```bash
# Lihat error details:
tail -f storage/logs/laravel.log
```

---

## 🚀 Production Setup

Jika mau test di domain production (bukan localhost):

### Di Google Cloud Console
1. Klik OAuth Client credentials yang sudah dibuat
2. Di **Authorized Origins** tambahkan: `https://yourdomain.com`
3. Di **Authorized Redirect URIs** tambahkan: `https://yourdomain.com/auth/google/callback`

### Di `.env` Production
```env
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
```

---

## 📚 Reference Files

Jika butuh referensi lebih:

- **FIX_GOOGLE_OAUTH_ERROR.md** - Troubleshooting lengkap
- **QUICK_START_AUTH.md** - Setup cepat
- **GOOGLE_OAUTH_SETUP.txt** - Template .env

---

## ⏱️ Total Time

- Step 1-7: ~5 minutes (setup Google)
- Step 8-9: ~2 minutes (copy & paste)
- Step 10-12: ~1 minute (save & test)

**Total: ~8 minutes**

---

## 🎯 Common Issues & Quick Fix

| Issue | Solution |
|-------|----------|
| "Error 400: invalid_request" | Check GOOGLE_CLIENT_ID di .env |
| "Redirect URI mismatch" | URI harus PERSIS sama di Google Console & .env |
| "Akses diblokir" | Pastikan Google+ API sudah diaktifkan |
| "Missing required parameter" | GOOGLE_CLIENT_SECRET kosong |
| Masih error setelah setup | Restart server (Ctrl+C & php artisan serve) |

---

## ✅ Verification

Setelah setup berhasil:

```bash
php artisan auth:test-setup
```

Cari output:
```
7. Checking Configuration...
   ✅ Google OAuth config found
✅ Authentication Setup is Ready!
```

---

**Selesai! Anda sudah berhasil setup Google OAuth.** 🎉

Sekarang bisa test login dengan Google di: http://localhost:8000/login
