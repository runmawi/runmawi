<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Setting;
use App\SystemSetting;
use App\SiteTheme;
use App\EmailSetting;
use App\AdminOTPCredentials;

class PrecacheAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'precache:assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pre-cache important assets and routes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting asset pre-caching...');
        
        // Cache settings
        $this->cacheSettings();
        
        // Pre-warm routes
        $this->prewarmRoutes();
        
        $this->info('Asset pre-caching completed!');
        
        return 0;
    }
    
    /**
     * Cache application settings
     */
    protected function cacheSettings()
    {
        $this->info('Caching application settings...');
        
        // Cache settings for 1 day
        Cache::remember('app_settings_auth', now()->addDay(), function () {
            return Setting::select(['id', 'enable_landing_page', 'access_free', 'website_name', 'favicon', 'login_content', 'login_text'])->first();
        });
        
        // Cache system settings
        Cache::remember('system_settings', now()->addDay(), function () {
            return SystemSetting::first(['id']);
        });
        
        // Cache theme settings
        Cache::remember('site_theme', now()->addDay(), function () {
            return SiteTheme::first();
        });
        
        // Cache OTP settings
        Cache::remember('otp_enabled', now()->addDay(), function () {
            return AdminOTPCredentials::where('status', 1)->exists();
        });
        
        // Cache country codes
        $countryJsonData = Cache::remember('country_codes', now()->addWeek(), function () {
            $jsonString = file_get_contents(base_path('assets/country_code.json'));
            $data = json_decode($jsonString, true);
            usort($data, function ($a, $b) {
                return strcmp($a['code'], $b['code']);
            });
            return $data;
        });
    }
    
    /**
     * Pre-warm important routes
     */
    protected function prewarmRoutes()
    {
        $this->info('Pre-warming important routes...');
        
        $routes = [
            '/',
            '/login',
            '/register',
            '/password/reset',
            // Add more important routes here
        ];
        
        $client = new \GuzzleHttp\Client();
        
        foreach ($routes as $route) {
            try {
                $url = config('app.url') . $route;
                $this->info("Pre-warming: $url");
                $client->get($url, ['http_errors' => false]);
            } catch (\Exception $e) {
                $this->warn("Failed to pre-warm $route: " . $e->getMessage());
            }
        }
    }
}
