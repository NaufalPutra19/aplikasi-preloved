# ✅ Setup Checklist - Login & Register System

Ikuti checklist ini untuk mengsetup dan test authentication system Anda.

## Phase 1: Initial Setup ⏱️ ~5 minutes

### Database
- [x] Migration sudah dijalankan (`google_id` column added)
- [x] Users table sudah updated

### Code Files
- [x] AuthController dibuat
- [x] User Model diupdate
- [x] VerifyEmailNotification dibuat
- [x] Views diupdate (login, register, verify-email)
- [x] Routes diupdate
- [x] Services config diupdate

### Testing
- [x] Run test command: `php artisan auth:test-setup`
- [x] All checks passed ✅

---

## Phase 2: Google OAuth Setup ⏱️ ~10 minutes (Optional tapi Recommended)

### Google Cloud Console Setup
- [ ] Buka https://console.cloud.google.com
- [ ] Buat project baru atau gunakan existing
- [ ] Cari dan aktifkan "Google+ API"
- [ ] Pergi ke Credentials
- [ ] Klik "Create Credentials" → "OAuth 2.0 Client ID"
- [ ] Pilih "Web Application"
- [ ] Tambahkan authorized redirect URI:
  - [ ] `http://localhost:8000/auth/google/callback`
- [ ] Untuk production, tambahkan juga:
  - [ ] `https://yourdomain.com/auth/google/callback`
- [ ] Copy Client ID
- [ ] Copy Client Secret

### Update .env
- [ ] Buka file `.env` di root project
- [ ] Tambahkan atau update:
  ```env
  GOOGLE_CLIENT_ID=your_client_id_here
  GOOGLE_CLIENT_SECRET=your_client_secret_here
  GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
  ```
- [ ] Save file

### Verify Configuration
- [ ] Buka file `.env`
- [ ] Pastikan 3 konfigurasi sudah ada dan benar
- [ ] Jangan share credentials ini di public/github

---

## Phase 3: Email Configuration ⏱️ ~10 minutes (PENTING!)

### Pilih Email Service
Email configuration **WAJIB** agar email verification bisa bekerja.

#### Option A: Mailtrap (Recommended untuk Development)
- [ ] Buka https://mailtrap.io
- [ ] Sign up dengan email/Github
- [ ] Copy SMTP credentials
- [ ] Update `.env`:
  ```env
  MAIL_MAILER=smtp
  MAIL_HOST=live.smtp.mailtrap.io
  MAIL_PORT=587
  MAIL_USERNAME=your_mailtrap_username
  MAIL_PASSWORD=your_mailtrap_password
  MAIL_ENCRYPTION=tls
  MAIL_FROM_ADDRESS=noreply@yourapp.com
  MAIL_FROM_NAME="The Order"
  ```

#### Option B: Gmail
- [ ] Enable "Less secure app access" di Gmail settings
- [ ] Atau gunakan App Password (recommended)
- [ ] Update `.env`:
  ```env
  MAIL_MAILER=smtp
  MAIL_HOST=smtp.gmail.com
  MAIL_PORT=587
  MAIL_USERNAME=your_email@gmail.com
  MAIL_PASSWORD=your_app_password
  MAIL_ENCRYPTION=tls
  MAIL_FROM_ADDRESS=your_email@gmail.com
  MAIL_FROM_NAME="The Order"
  ```

#### Option C: SendGrid
- [ ] Daftar di https://sendgrid.com
- [ ] Get API Key
- [ ] Update `.env`:
  ```env
  MAIL_MAILER=sendgrid
  SENDGRID_API_KEY=your_api_key_here
  MAIL_FROM_ADDRESS=noreply@yourapp.com
  ```

### Verify Email Configuration
- [ ] Buka file `.env`
- [ ] Cek MAIL_MAILER value
- [ ] Cek semua MAIL_* variables sudah filled
- [ ] Pastikan MAIL_FROM_ADDRESS valid
- [ ] Jangan share password di public

---

## Phase 4: Run & Test ⏱️ ~15 minutes

### Start Application
- [ ] Buka terminal/command prompt
- [ ] Navigate ke project folder: `cd c:\laragon\www\aplikasi-preloved`
- [ ] Run: `php artisan serve`
- [ ] Output: `INFO  Server running on [http://127.0.0.1:8000]`
- [ ] Buka browser: `http://localhost:8000`

### Test Login
- [ ] Klik "Login" atau buka `/login`
- [ ] Login dengan test account:
  - Email: `test@example.com`
  - Password: `Password123`
- [ ] Seharusnya login berhasil (test user sudah verified)
- [ ] Setelah login, klik Logout

### Test Register - Full Flow
- [ ] Klik "Register" atau buka `/register`
- [ ] Isi form:
  - Name: `John Doe`
  - Email: `john@example.com` (atau email baru)
  - Password: `Password123` (min 8 chars)
  - Confirm: `Password123`
- [ ] Klik "Create Account"
- [ ] Seharusnya redirect ke login dengan pesan sukses
- [ ] Cek email Anda:
  - [ ] Jika pakai Mailtrap: cek Mailtrap inbox
  - [ ] Jika pakai Gmail: cek Gmail inbox
  - [ ] Cari email dari noreply@yourapp.com
- [ ] Copy verification link dari email
- [ ] Paste link ke browser
- [ ] Seharusnya email terverifikasi
- [ ] Sekarang bisa login dengan email baru

### Test Google OAuth (Jika sudah setup credentials)
- [ ] Klik "Sign in with Google" di login page
- [ ] Pilih akun Google Anda
- [ ] Grant permission
- [ ] Seharusnya login berhasil
- [ ] Email seharusnya auto-verified
- [ ] Klik Logout

### Test Resend Verification Email
- [ ] Register dengan email baru
- [ ] Jangan verify dulu
- [ ] Try login, seharusnya error (email not verified)
- [ ] Go to verify email page (auto redirect atau manual)
- [ ] Klik "Resend Verification Email"
- [ ] Cek email untuk link baru
- [ ] Klik link baru
- [ ] Sekarang bisa login

---

## Phase 5: Security Check ⏱️ ~5 minutes

### Authentication
- [ ] Login form works
- [ ] Register form validates
- [ ] Password hashing works (bcrypt)
- [ ] CSRF token di semua forms

### Email Verification
- [ ] Email verification wajib
- [ ] Link di-sign dan time-limited
- [ ] Resend functionality works
- [ ] Expired link shows error

### OAuth Security
- [ ] Google OAuth flow secure
- [ ] No credentials exposed
- [ ] Redirect URI matches
- [ ] Email auto-verified from Google

### Password Security
- [ ] Min 8 characters required
- [ ] Confirmation validation works
- [ ] Password tidak visible di logs
- [ ] Hashed di database

---

## Phase 6: Deployment Setup ⏱️ ~10 minutes (When Ready)

### Before Going to Production

Database:
- [ ] Run migrations on production server
- [ ] Backup database
- [ ] Test migrations rollback (if needed)

Environment:
- [ ] Update `.env` dengan production credentials
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Update `GOOGLE_REDIRECT_URI` ke production domain
- [ ] Update `MAIL_FROM_ADDRESS`
- [ ] Update email credentials ke production service

Security:
- [ ] Review all .env variables
- [ ] Ensure .env tidak committed to git
- [ ] Check .gitignore includes .env
- [ ] Backup .env file securely
- [ ] Review password requirements
- [ ] Check CORS settings

Testing:
- [ ] Test all auth flows on production
- [ ] Test email delivery on production
- [ ] Test Google OAuth on production
- [ ] Monitor logs for errors
- [ ] Test with real user account

### Post-Deployment
- [ ] Monitor error logs
- [ ] Check email delivery
- [ ] Verify no security issues
- [ ] Test with multiple users
- [ ] Get user feedback

---

## Troubleshooting Checklist

### Email tidak diterima
- [ ] Cek MAIL_MAILER value
- [ ] Cek semua MAIL_* variables
- [ ] Cek credentials correct (username/password)
- [ ] Cek MAIL_FROM_ADDRESS valid
- [ ] Jika Gmail: setup app password
- [ ] Jika Mailtrap: check inbox (not spam)
- [ ] Cek logs: `storage/logs/laravel.log`
- [ ] Test manual: `php artisan tinker` → `User::first()->sendEmailVerificationNotification()`

### Google OAuth tidak bekerja
- [ ] Cek GOOGLE_CLIENT_ID di .env
- [ ] Cek GOOGLE_CLIENT_SECRET di .env
- [ ] Cek GOOGLE_REDIRECT_URI di .env
- [ ] Pastikan redirect URI di Google Console sesuai
- [ ] Pastikan Google+ API enabled
- [ ] Cek HTTPS untuk production
- [ ] Cek logs untuk error details

### Login tidak bekerja
- [ ] Pastikan email terverifikasi
- [ ] Cek email & password correct
- [ ] Cek akun ada di database
- [ ] Cek password hashing correct
- [ ] Cek session configuration

### Database errors
- [ ] Jalankan: `php artisan migrate:reset`
- [ ] Jalankan: `php artisan migrate`
- [ ] Cek database credentials
- [ ] Cek database server running

---

## Verification Checklist

Run these commands to verify everything:

```bash
# Check setup
php artisan auth:test-setup

# Check migrations
php artisan migrate:status

# Check routes
php artisan route:list | grep auth

# Check configuration
php artisan config:show services
```

All should show ✅ status.

---

## Documentation Files

Read these for more info:

- [ ] `README_AUTH_SYSTEM.md` - Overview & features
- [ ] `QUICK_START_AUTH.md` - Quick reference
- [ ] `AUTHENTICATION_SETUP.md` - Detailed guide
- [ ] `.env.example.auth` - Config examples

---

## Support

Jika ada masalah:

1. Cek documentation files
2. Cek logs: `storage/logs/laravel.log`
3. Run test command: `php artisan auth:test-setup`
4. Check .env configuration
5. Verify credentials correct

---

## Summary

✅ Phase 1: Code & Database - DONE
☐ Phase 2: Google OAuth - OPTIONAL (15 mins)
☐ Phase 3: Email Setup - REQUIRED (10 mins)
☐ Phase 4: Testing - REQUIRED (15 mins)
☐ Phase 5: Security - REQUIRED (5 mins)
☐ Phase 6: Production - WHEN READY (10 mins)

**Total Setup Time:** 15-45 minutes (depending on what you setup)

**Status:** Ready to start Phase 2! 🚀

---

**Printed:** January 8, 2026
**Version:** 1.0
**Estimated Time:** 45 minutes total
