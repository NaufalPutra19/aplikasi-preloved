# Quick Start - Login & Register dengan Email Verification dan Google OAuth

## 🚀 Apa yang Baru?

Aplikasi Anda sekarang memiliki sistem authentication lengkap dengan:
- ✅ Login dengan email & password
- ✅ Register dengan email & password
- ✅ **Email Verification** (wajib verify sebelum bisa login)
- ✅ **Google OAuth** (Login/Register dengan akun Google)

## 📋 Setup Awal (Penting!)

### 1. Install Dependencies
```bash
php artisan migrate
```

### 2. Setup Google OAuth (Opsional tapi Recommended)

**Langkah-langkah:**
1. Buka https://console.cloud.google.com
2. Buat project baru
3. Aktifkan "Google+ API"
4. Buat OAuth 2.0 credentials untuk Web Application
5. Tambahkan authorized redirect URI:
   ```
   http://localhost:8000/auth/google/callback
   ```
6. Copy Client ID dan Client Secret

**Tambahkan ke .env:**
```env
GOOGLE_CLIENT_ID=your_client_id_here
GOOGLE_CLIENT_SECRET=your_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### 3. Setup Email (Penting untuk Email Verification!)

Pilih salah satu:

**Option A: Mailtrap (Recommended untuk Development)**
1. Daftar di https://mailtrap.io
2. Copy SMTP credentials
3. Update .env:
```env
MAIL_MAILER=smtp
MAIL_HOST=live.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=xxx
MAIL_PASSWORD=xxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourapp.com
```

**Option B: Gmail**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
```

## 🔗 Routes yang Tersedia

```
GET  /login              - Tampilkan form login
POST /login              - Process login
GET  /register           - Tampilkan form register
POST /register           - Process register
POST /logout             - Logout user
GET  /auth/google        - Redirect ke Google login
GET  /auth/google/callback - Google callback handler
GET  /email/verify/{id}/{hash} - Verify email link
POST /email/resend       - Resend verification email
```

## 📚 File yang Berubah

```
app/
  ├── Http/Controllers/Auth/AuthController.php (BARU)
  ├── Models/User.php (UPDATED)
  ├── Notifications/VerifyEmailNotification.php (BARU)

resources/views/auth/
  ├── login.blade.php (UPDATED - ada Google button)
  ├── register.blade.php (UPDATED - ada Google button)
  └── verify-email.blade.php (BARU)

routes/
  └── web.php (UPDATED - auth routes)

config/
  └── services.php (UPDATED - Google OAuth config)

database/migrations/
  └── 2026_01_08_131540_add_oauth_fields_to_users_table.php (BARU)
```

## 🧪 Testing di Local

### 1. Start Application
```bash
php artisan serve
```

### 2. Buka Browser
```
http://localhost:8000
```

### 3. Register User Baru
- Klik link "Daftar di sini" di page login
- Isi form: Nama, Email, Password (min 8 karakter)
- Klik Register
- Cek email Anda (atau Mailtrap inbox kalau pakai Mailtrap)
- Klik link verifikasi di email
- Kalo udah verified, baru bisa login

### 4. Test Google OAuth (Optional)
- Klik "Sign up with Google"
- Login dengan akun Google Anda
- Akun otomatis dibuat dan email terverifikasi
- Langsung bisa akses aplikasi

## 🔒 Keamanan

User yang belum verify email **TIDAK BISA LOGIN**, mereka akan dapat error:
```
Email anda belum diverifikasi. Silahkan cek email anda untuk verifikasi.
```

## 🛠 Customization

### Ubah pesan error
Edit `AuthController.php` di method `login()`

### Ubah design form login/register
Edit `resources/views/auth/login.blade.php` dan `register.blade.php`

### Ubah email template
Edit `app/Notifications/VerifyEmailNotification.php`

### Protect route dengan verified email
```php
Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
```

## ❓ FAQ

**Q: User tidak dapat email verifikasi?**
A: Cek .env MAIL config, pastikan sudah setup SMTP yang benar

**Q: Google login tidak bekerja?**
A: Pastikan GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, dan GOOGLE_REDIRECT_URI sudah benar di .env

**Q: Link verifikasi expired?**
A: Link valid 60 menit, user bisa klik "Resend" untuk dapat link baru

**Q: Mau tambah provider OAuth lain (Facebook, Github)?**
A: Pakai Laravel Socialite, ikuti pattern yang sama seperti Google OAuth

## 📧 Testing Email tanpa Mailtrap

**Cara 1: Gunakan PHP Mail (tapi kurang reliable)**
```env
MAIL_MAILER=log
```

**Cara 2: Lihat di Storage Logs**
```bash
tail -f storage/logs/laravel.log
```

**Cara 3: Pakai Mailgun (free tier tersedia)**
- Daftar di mailgun.com
- Update config di .env

## 🎯 Flow Diagram

```
┌─────────────────────────────────────┐
│     User mengunjungi /register      │
├─────────────────────────────────────┤
│  Form: Nama, Email, Password        │
├─────────────────────────────────────┤
│   User submit form                  │
├─────────────────────────────────────┤
│   ✅ Akun dibuat                    │
│   ✅ Email verifikasi dikirim       │
└────────────┬────────────────────────┘
             │
    ┌────────▼────────┐
    │ User cek email  │
    └────────┬────────┘
             │
    ┌────────▼──────────────┐
    │ Klik link verifikasi  │
    └────────┬──────────────┘
             │
    ┌────────▼────────────────┐
    │ ✅ Email terverifikasi  │
    │ ✅ Akun siap digunakan  │
    └────────┬────────────────┘
             │
    ┌────────▼──────────┐
    │ User bisa login   │
    └──────────────────┘
```

## 📞 Kontak Support

Untuk pertanyaan lebih lanjut, lihat file `AUTHENTICATION_SETUP.md` di root project.

---

**Last Updated:** 8 January 2026
**Version:** 1.0
