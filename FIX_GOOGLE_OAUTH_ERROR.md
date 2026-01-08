# 🔧 Google OAuth Error - Panduan Perbaikan

## Error yang Anda Hadapi

```
Akses diblokir: Error Otori risasi
Missing required parameter: client_id Pelajari lebih lanjut error ini
Error 400: invalid_request
```

### Penyebab
**GOOGLE_CLIENT_ID atau GOOGLE_CLIENT_SECRET belum diset (atau salah) di `.env` file**

---

## ✅ Solusi Cepat (5 Menit)

### Step 1: Buka Google Cloud Console
Kunjungi: https://console.cloud.google.com

### Step 2: Setup Project & Google+ API

1. **Buat Project Baru atau Gunakan Existing**
   - Di dropdown project, klik "Create New Project"
   - Beri nama: "Aplikasi Preloved" (atau nama apapun)
   - Klik "Create"
   - Tunggu project selesai dibuat

2. **Aktifkan Google+ API**
   - Pergi ke **APIs & Services** → **Enabled APIs & services**
   - Klik **"+ Enable APIs and Services"**
   - Cari "Google+ API"
   - Klik dan **Enable**

### Step 3: Buat OAuth Credentials

1. **Pergi ke Credentials**
   - **APIs & Services** → **Credentials**

2. **Klik "Create Credentials"**
   - Pilih **"OAuth 2.0 Client IDs"**

3. **Select Application Type**
   - Pilih **"Web application"**
   - Beri nama: "Aplikasi Preloved"

4. **Authorized JavaScript Origins**
   - Klik **"Add URI"**
   - Masukkan: `http://localhost:8000`
   - Klik **"Add URI"** lagi jika mau tambah production URL

5. **Authorized Redirect URIs**
   - Klik **"Add URI"**
   - Masukkan: `http://localhost:8000/auth/google/callback`
   - **PENTING:** Harus PERSIS seperti ini (termasuk `/auth/google/callback`)

6. **Klik "Create"**

### Step 4: Copy Credentials

Setelah klik Create, Anda akan melihat popup dengan:
- **Client ID** (berbentuk: xxx.apps.googleusercontent.com)
- **Client Secret** (string random)

**COPY KEDUA NILAI INI**

### Step 5: Update .env File

Buka file `.env` di root project, cari atau tambahkan:

```env
GOOGLE_CLIENT_ID=your_client_id_here.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

**GANTI:**
- `your_client_id_here.apps.googleusercontent.com` → dengan Client ID Anda
- `your_client_secret_here` → dengan Client Secret Anda

**Contoh:**
```env
GOOGLE_CLIENT_ID=123456789-abc.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-abcdef123456
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### Step 6: Save dan Test

1. **Save .env file** (Ctrl+S)
2. **Refresh browser** atau restart `php artisan serve`
3. **Buka** http://localhost:8000/login
4. **Klik** "Sign in with Google" atau "Sign up with Google"
5. Seharusnya tidak ada error lagi

---

## ❌ Masalah Umum & Solusi

### "Error 400: invalid_request"
**Penyebab:** GOOGLE_CLIENT_ID kosong atau salah

**Solusi:**
```env
# Pastikan ada di .env
GOOGLE_CLIENT_ID=your_client_id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your_secret
```

### "Redirect URI mismatch"
**Penyebab:** GOOGLE_REDIRECT_URI tidak sesuai dengan yang didaftar di Google Console

**Solusi:**
1. Cek di Google Cloud Console → Credentials → Edit OAuth Client
2. Pastikan **Authorized redirect URIs** sudah ada `http://localhost:8000/auth/google/callback`
3. Pastikan di `.env` sama persis:
```env
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### "Akses diblokir: Error Otorisasi"
**Penyebab:** Google+ API belum diaktifkan

**Solusi:**
1. Buka Google Cloud Console
2. Pergi ke **APIs & Services** → **Enabled APIs & services**
3. Cari "Google+ API" di list
4. Jika belum ada, klik **"+ Enable APIs and Services"**
5. Cari "Google+ API"
6. Klik dan **Enable**

### "Missing required parameter: client_id"
**Penyebab:** GOOGLE_CLIENT_ID belum diset di `.env`

**Solusi:**
1. Buka `.env`
2. Pastikan ada baris:
```env
GOOGLE_CLIENT_ID=...
GOOGLE_CLIENT_SECRET=...
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```
3. Jika tidak ada, tambahkan
4. Restart server: `php artisan serve`

---

## 🔍 Debug Lebih Lanjut

### Check Config via PHP
```bash
php artisan tinker
```

Lalu ketik:
```php
config('services.google')
```

Seharusnya output:
```
array:3 [
  "client_id" => "xxx.apps.googleusercontent.com"
  "client_secret" => "xxx"
  "redirect" => "http://localhost:8000/auth/google/callback"
]
```

Jika ada yang `null`, berarti .env tidak tersave dengan benar.

### Check Laravel Log
```bash
tail -f storage/logs/laravel.log
```

Coba login dengan Google, lihat error message di logs.

---

## 📋 Checklist Sebelum Test

- [ ] Google Cloud Console project dibuat
- [ ] Google+ API sudah diaktifkan
- [ ] OAuth Client ID dibuat (Web Application)
- [ ] `http://localhost:8000` ada di Authorized JavaScript Origins
- [ ] `http://localhost:8000/auth/google/callback` ada di Authorized Redirect URIs
- [ ] `.env` file sudah update dengan GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET
- [ ] `.env` file sudah di-save (penting!)
- [ ] Browser di-refresh atau server di-restart
- [ ] Test login dengan Google

---

## 🚀 Production Setup

Jika ingin test di production domain (bukan localhost):

### Google Cloud Console
1. Klik credentials OAuth Client yang sudah dibuat
2. **Authorized JavaScript origins** tambahkan:
   - `https://yourdomain.com`
3. **Authorized Redirect URIs** tambahkan:
   - `https://yourdomain.com/auth/google/callback`

### .env (Production)
```env
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
```

---

## 🎯 Testing Flow Lengkap

1. **Setup Google OAuth** (lihat step di atas)
2. **Start server**: `php artisan serve`
3. **Buka login page**: http://localhost:8000/login
4. **Klik "Sign in with Google"**
5. **Select Google account** yang ingin digunakan
6. **Grant permission** saat diminta
7. **Seharusnya berhasil login** dan redirect ke dashboard
8. **Email seharusnya terverifikasi otomatis**

---

## 📞 Support

Jika masih error:

1. Pastikan sudah follow semua step di atas
2. Check `storage/logs/laravel.log` untuk error details
3. Run `php artisan auth:test-setup` untuk verify setup
4. Baca file `QUICK_START_AUTH.md` untuk step-by-step guide

---

## ✅ Verifikasi Berhasil

Setelah fix, run:
```bash
php artisan auth:test-setup
```

Harusnya output:
```
✅ Google OAuth config found
✅ Authentication Setup is Ready!
```

---

**Selesai! Google OAuth seharusnya sudah bekerja.** 🎉

Jika masih ada masalah, lihat error message yang detail di production dan share di logs.
