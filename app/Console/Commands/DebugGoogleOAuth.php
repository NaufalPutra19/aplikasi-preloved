<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Socialite\Facades\Socialite;

class DebugGoogleOAuth extends Command
{
    protected $signature = 'oauth:debug';
    protected $description = 'Debug Google OAuth Configuration';

    public function handle()
    {
        $this->line('=== Google OAuth Debug ===');
        $this->newLine();

        // Check environment variables
        $this->info('📋 Environment Variables:');
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        $redirect = config('services.google.redirect');

        $this->line('GOOGLE_CLIENT_ID: ' . ($clientId ? '✅ ' . substr($clientId, 0, 20) . '...' : '❌ NOT SET'));
        $this->line('GOOGLE_CLIENT_SECRET: ' . ($clientSecret ? '✅ ' . substr($clientSecret, 0, 20) . '...' : '❌ NOT SET'));
        $this->line('GOOGLE_REDIRECT_URI: ' . ($redirect ? '✅ ' . $redirect : '❌ NOT SET'));
        $this->newLine();

        // Test Socialite configuration
        $this->info('🔧 Testing Socialite Configuration:');
        try {
            $driver = Socialite::driver('google');
            $this->line('✅ Socialite Google driver initialized successfully');
        } catch (\Exception $e) {
            $this->error('❌ Socialite Error: ' . $e->getMessage());
            $this->line('   This error will occur during OAuth flow');
        }
        $this->newLine();

        // Check if all required fields are set
        $this->info('✅ Validation:');
        if ($clientId && $clientSecret && $redirect) {
            $this->line('✅ All Google OAuth credentials are configured');
        } else {
            $this->error('❌ Missing Google OAuth credentials');
            if (!$clientId) $this->error('   - GOOGLE_CLIENT_ID is missing');
            if (!$clientSecret) $this->error('   - GOOGLE_CLIENT_SECRET is missing');
            if (!$redirect) $this->error('   - GOOGLE_REDIRECT_URI is missing');
        }
    }
}
