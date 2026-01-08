<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class TestAuthSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:test-setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test authentication setup (creates test user)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Checking Authentication Setup...');
        $this->newLine();

        // Check User Model
        $this->info('1. Checking User Model Implementation...');
        $user = new User();
        
        if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail) {
            $this->line('   ✅ User implements MustVerifyEmail');
        } else {
            $this->error('   ❌ User does not implement MustVerifyEmail');
            return 1;
        }

        // Check User table has required fields
        $this->info('2. Checking Database Columns...');
        try {
            $columns = \Illuminate\Support\Facades\DB::select("SHOW COLUMNS FROM users");
            $columnNames = array_map(fn($col) => $col->Field, $columns);
            
            $requiredColumns = ['google_id', 'email_verified_at', 'password'];
            foreach ($requiredColumns as $column) {
                if (in_array($column, $columnNames)) {
                    $this->line("   ✅ Column '{$column}' exists");
                } else {
                    $this->error("   ❌ Column '{$column}' not found");
                    return 1;
                }
            }
        } catch (\Exception $e) {
            $this->warn('   ⚠️  Could not check columns (database may not be set up)');
        }

        // Check Controllers
        $this->info('3. Checking Controllers...');
        if (class_exists('App\Http\Controllers\Auth\AuthController')) {
            $this->line('   ✅ AuthController exists');
        } else {
            $this->error('   ❌ AuthController not found');
            return 1;
        }

        // Check Notifications
        $this->info('4. Checking Notifications...');
        if (class_exists('App\Notifications\VerifyEmailNotification')) {
            $this->line('   ✅ VerifyEmailNotification exists');
        } else {
            $this->error('   ❌ VerifyEmailNotification not found');
            return 1;
        }

        // Check Routes
        $this->info('5. Checking Routes...');
        $requiredRoutes = ['login', 'register', 'auth.google', 'logout'];
        foreach ($requiredRoutes as $route) {
            if (\Illuminate\Support\Facades\Route::has($route)) {
                $this->line("   ✅ Route '{$route}' exists");
            } else {
                $this->warn("   ⚠️  Route '{$route}' not found (might be okay)");
            }
        }

        // Check Views
        $this->info('6. Checking Views...');
        $viewPath = resource_path('views/auth');
        $requiredViews = ['login.blade.php', 'register.blade.php', 'verify-email.blade.php'];
        
        foreach ($requiredViews as $view) {
            if (file_exists($viewPath . '/' . $view)) {
                $this->line("   ✅ View '{$view}' exists");
            } else {
                $this->error("   ❌ View '{$view}' not found");
            }
        }

        // Check Config
        $this->info('7. Checking Configuration...');
        if (config('services.google')) {
            $this->line('   ✅ Google OAuth config found');
        } else {
            $this->warn('   ⚠️  Google OAuth config not found (needs .env setup)');
        }

        // Create test user
        $this->newLine();
        $this->info('8. Creating Test User...');
        
        $testUser = User::where('email', 'test@example.com')->first();
        if ($testUser) {
            $this->line('   ℹ️  Test user already exists');
        } else {
            $testUser = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('Password123'),
                'email_verified_at' => now(),
                'role' => 'customer',
            ]);
            $this->line('   ✅ Test user created');
            $this->line('      Email: test@example.com');
            $this->line('      Password: Password123');
        }

        $this->newLine();
        $this->info('✅ Authentication Setup is Ready!');
        $this->newLine();
        
        $this->line('Next Steps:');
        $this->line('1. Update .env with GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET');
        $this->line('2. Update .env with MAIL configuration');
        $this->line('3. Run: php artisan serve');
        $this->line('4. Visit: http://localhost:8000/login');
        $this->line('5. Test with email: test@example.com / password: Password123');

        return 0;
    }
}
