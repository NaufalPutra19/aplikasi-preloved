# Setup Login & Register dengan Email Verification dan Google OAuth

## Fitur yang Telah Diimplementasikan

1. ✅ **Email Verification** - User harus memverifikasi email sebelum bisa login
2. ✅ **Custom Login Form** - Form login yang elegan dan responsif
3. ✅ **Custom Register Form** - Form registrasi dengan validasi password
4. ✅ **Google OAuth** - Login/Register menggunakan akun Google
5. ✅ **Email Verification Notification** - Notifikasi email untuk verifikasi

## Konfigurasi yang Diperlukan

### 1. Konfigurasi Google OAuth

#### Langkah 1: Buat Google OAuth Credentials
1. Buka [Google Cloud Console](https://console.cloud.google.com)
2. Buat project baru atau gunakan yang sudah ada
3. Aktifkan **Google+ API**
4. Pergi ke **Credentials** → **Create Credentials** → **OAuth 2.0 Client IDs**
5. Pilih **Web Application**
6. Tambahkan URI di **Authorized redirect URIs**:
   - `http://localhost:8000/auth/google/callback` (untuk development)
   - `https://yourdomain.com/auth/google/callback` (untuk production)
7. Copy **Client ID** dan **Client Secret**

#### Langkah 2: Update .env file

Tambahkan konfigurasi Google OAuth ke file `.env`:

```env
# Google OAuth
GOOGLE_CLIENT_ID=your_client_id_here
GOOGLE_CLIENT_SECRET=your_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### 2. Konfigurasi Email/SMTP

Untuk mengirim email verifikasi, update konfigurasi MAIL di `.env`:

**Menggunakan Mailtrap (recommended untuk testing):**
```env
MAIL_MAILER=smtp
MAIL_HOST=live.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourapp.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Atau gunakan Gmail:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Untuk production, gunakan sendmail atau hosted SMTP service.**

### 3. Database Migration

Migration sudah dijalankan, tapi jika belum:
```bash
php artisan migrate
```

## Struktur File yang Dibuat/Dimodifikasi

### Controllers
- `app/Http/Controllers/Auth/AuthController.php` - Menangani login, register, OAuth, email verification

### Models
- `app/Models/User.php` - Updated dengan `MustVerifyEmail` interface dan custom email notification

### Notifications
- `app/Notifications/VerifyEmailNotification.php` - Custom notification untuk email verification

### Views
- `resources/views/auth/login.blade.php` - Updated dengan Google OAuth button
- `resources/views/auth/register.blade.php` - Updated dengan Google OAuth button
- `resources/views/auth/verify-email.blade.php` - Page untuk verifikasi email

### Routes
- `routes/web.php` - Updated dengan routes untuk authentication custom

### Config
- `config/services.php` - Updated dengan Google OAuth configuration

### Migrations
- `database/migrations/2026_01_08_131540_add_oauth_fields_to_users_table.php` - Menambah google_id column

## Alur Login/Register

### Register dengan Email & Password
1. User mengisi form register (nama, email, password)
2. System membuat akun baru dengan role 'customer'
3. Email verifikasi dikirim ke email user
4. User harus klik link di email untuk verify
5. Baru bisa login setelah email terverifikasi

### Register dengan Google
1. User klik "Sign up with Google"
2. Di-redirect ke Google login page
3. User select/login dengan akun Google
4. System otomatis membuat akun atau login jika sudah ada
5. Email otomatis terverifikasi (dari Google)
6. User langsung bisa akses aplikasi

### Login dengan Email & Password
1. User masuk email dan password
2. System check apakah email sudah diverifikasi
3. Jika belum: tampil error message dan redirect ke verify email page
4. Jika sudah: user berhasil login

### Login dengan Google
1. User klik "Sign in with Google"
2. Jika sudah pernah login dengan Google atau pakai email yang sama: langsung login
3. Jika akun belum ada: akan di-redirect ke register (atau langsung create akun)

## Testing Instruksi

### 1. Development dengan Mailtrap
1. Daftar di [Mailtrap.io](https://mailtrap.io)
2. Dapat SMTP credentials
3. Update `.env` dengan credentials Mailtrap
4. Saat register, email verifikasi akan masuk ke inbox Mailtrap
5. Copy link dari email dan buka di browser

### 2. Testing Google OAuth (Development)
1. Pastikan sudah setup Google OAuth credentials
2. Run: `php artisan serve`
3. Klik tombol "Sign up with Google" atau "Sign in with Google"
4. Login dengan akun Google test

### 3. Manual Testing
```bash
# Start development server
php artisan serve

# Di terminal lain, start mail catcher (optional)
php artisan tinker
# Lalu coba kirim test email:
\App\Models\User::find(1)->sendEmailVerificationNotification();
```

## Middleware untuk Email Verification

Jika ingin protect route agar hanya user dengan email terverifikasi yang bisa akses:

```php
Route::middleware(['auth', 'verified'])->group(function() {
    // Routes yang butuh verified email
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
```

## Troubleshooting

### Email tidak diterima
- Cek MAIL configuration di `.env`
- Jika pakai Gmail, gunakan App Password bukan password biasa
- Cek spam folder
- Cek log: `storage/logs/laravel.log`

### Google OAuth error
- Cek GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET di `.env`
- Pastikan redirect URI di Google Console sesuai dengan `GOOGLE_REDIRECT_URI`
- Cek apakah Google+ API sudah diaktifkan di Google Cloud Console

### Email verification link expired
- Link valid selama 60 menit (configurable di `config/auth.php`)
- User bisa request email verification baru via resend button

## Security Notes

1. **Password Requirements** - Minimal 8 karakter
2. **Email Verification** - Mandatory untuk semua user
3. **OAuth** - Google handle authentication, data tersimpan secure
4. **CSRF Protection** - Semua form dilindungi CSRF token
5. **Signed URLs** - Email verification links adalah signed temporary URLs

## Kustomisasi Lebih Lanjut

### Ubah redirect setelah login
Edit `AuthController.php` method `login()`:
```php
return redirect()->intended(route('home.redirect'));
```

### Ubah email verification message
Edit `VerifyEmailNotification.php`

### Tambah provider OAuth lain (Facebook, Github, etc)
1. Install provider: `composer require laravel/socialite`
2. Tambah credentials di `.env` dan `config/services.php`
3. Tambah method di `AuthController.php`
4. Tambah button di login/register views

## Support Providers

Socialite mendukung banyak provider:
- Google ✅ (sudah disetup)
- Facebook
- Github
- LinkedIn
- Twitter
- Bitbucket
- Dan lainnya...

Untuk menambah provider, cukup ikuti pattern Google OAuth yang sudah ada.
