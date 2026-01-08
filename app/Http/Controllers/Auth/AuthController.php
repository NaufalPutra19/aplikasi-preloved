<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // DEVELOPMENT MODE: Skip email verification check
            // PRODUCTION: Uncomment lines below untuk enforce email verification
            /*
            if (!$user->email_verified_at) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Email anda belum diverifikasi. Silahkan cek email anda untuk verifikasi.'
                ])->withInput();
            }
            */

            $request->session()->regenerate();
            return redirect()->intended(route('home.redirect'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => 'required|in:customer,penjual',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => now(), // Auto-verify for development
        ]);

        event(new Registered($user));

        return redirect()->route('login')
            ->with('status', 'Registrasi berhasil! Silahkan login dengan email dan password Anda.');
    }

    /**
     * Handle email verification
     */
    public function verifyEmail(Request $request)
    {
        if (!hash_equals((string) $request->route('id'), (string) Auth::user()->getKey())) {
            throw new AuthorizationException;
        }

        if (!hash_equals((string) $request->route('hash'), sha1(Auth::user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('home.redirect')->with('status', 'Email sudah diverifikasi!');
        }

        Auth::user()->markEmailAsVerified();

        event(new Verified(Auth::user()));

        return redirect()->route('home.redirect')->with('status', 'Email berhasil diverifikasi!');
    }

    /**
     * Redirect to Google for authentication
     */
    public function redirectToGoogle()
    {
        // Check if Google OAuth credentials are configured
        if (!config('services.google.client_id') || !config('services.google.client_secret')) {
            return redirect()->route('login')
                ->with('error', 'Google OAuth belum dikonfigurasi. Hubungi administrator.');
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            \Log::info('Google OAuth Success:', [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
            ]);
        } catch (Exception $e) {
            \Log::error('Google OAuth Error (Socialite): ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('login')
                ->with('error', 'Gagal authenticate dengan Google: ' . $e->getMessage());
        }

        try {
            // Check if user already exists
            $existingUser = User::where('email', $googleUser->getEmail())->first();

            if ($existingUser) {
                \Log::info('User exists, logging in: ' . $googleUser->getEmail());
                
                // Update Google ID if not already set
                if (!$existingUser->google_id) {
                    $existingUser->update(['google_id' => $googleUser->getId()]);
                }
                Auth::login($existingUser, true);
            } else {
                \Log::info('Creating new user from Google: ' . $googleUser->getEmail());
                
                // Create new user from Google
                $newUser = User::create([
                    'name' => $googleUser->getName() ?? 'Google User',
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => now(),
                    'password' => Hash::make(uniqid()),
                    'role' => 'customer', // Default role for Google OAuth
                ]);

                \Log::info('New user created successfully: ' . $newUser->email);
                Auth::login($newUser, true);
            }

            \Log::info('User logged in successfully via Google: ' . Auth::user()->email);
            return redirect()->route('home.redirect');
            
        } catch (Exception $e) {
            \Log::error('Google OAuth Error (Database/Login): ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'email' => $googleUser->getEmail() ?? 'unknown'
            ]);
            
            return redirect()->route('login')
                ->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /**
     * Resend email verification
     */
    public function resendVerificationEmail(Request $request)
    {
        if (Auth::check() && Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('home.redirect');
        }

        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        if ($user->hasVerifiedEmail()) {
            return back()->with('status', 'Email sudah diverifikasi.');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('status', 'Link verifikasi email telah dikirim.');
    }
}
