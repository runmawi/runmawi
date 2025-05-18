<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use App\Facades\Settings as SettingsFacade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

class AuthPageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Always load settings for all views to ensure $settings is always available
        $this->loadMinimalSettings();
        
        // For non-auth pages, we still want to share the settings
        if (!$this->isAuthPage()) {
            $this->shareSettings();
        }
    }
    
    /**
     * Share settings with all views
     */
    protected function shareSettings()
    {
        try {
            $allSettings = SettingsFacade::getAllSettings();
            
            // Get settings with null coalescing to prevent undefined index errors
            $settings = (object)($allSettings['app'] ?? []);
            
            // Ensure required properties exist
            $settings->website_name = $settings->website_name ?? config('app.name');
            $settings->favicon = $settings->favicon ?? 'favicon.ico';
            $settings->login_content = $settings->login_content ?? 'Landban.png';
            $settings->login_text = $settings->login_text ?? 'Welcome Back';
            $settings->demo_mode = $settings->demo_mode ?? 0;
            
            // Share settings with all views
            View::share('settings', $settings);
            
        } catch (\Exception $e) {
            Log::error('Failed to share settings', ['error' => $e->getMessage()]);
            
            // Fallback settings
            $fallbackSettings = (object)[
                'website_name' => config('app.name'),
                'favicon' => 'favicon.ico',
                'login_content' => 'Landban.png',
                'login_text' => 'Welcome Back',
                'demo_mode' => 0,
                'logo' => null,
            ];
            
            View::share('settings', $fallbackSettings);
        }
    }

    /**
     * Check if the current request is for an authentication page.
     *
     * @return bool
     */
    protected function isAuthPage()
    {
        $path = request()->path();
        $authPaths = [
            'login', 'register', 'password/reset', 
            'password/email', 'password/reset/*', 'email/verify/*', 'logout',
            'admin/login', 'admin/password/reset', 'admin/password/email',
            'admin/verify', 'admin/verify/*', 'admin/logout'
        ];

        foreach ($authPaths as $authPath) {
            if ($path === $authPath || 
                (str_ends_with($authPath, '/*') && str_starts_with($path, rtrim($authPath, '/*')))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Load minimal settings required for auth pages
     */
    protected function loadMinimalSettings()
    {
        try {
            // Get all settings through our service
            $allSettings = [];
            try {
                $allSettings = SettingsFacade::getAllSettings();
                Log::debug('Successfully loaded all settings', ['keys' => array_keys($allSettings)]);
            } catch (\Exception $e) {
                Log::error('Failed to load settings', ['error' => $e->getMessage()]);
                throw $e;
            }
            
            // Get theme settings
            $themeSettings = [];
            try {
                $themeSettings = SettingsFacade::getThemeSettings();
                Log::debug('Successfully loaded theme settings', ['themeSettings' => $themeSettings]);
            } catch (\Exception $e) {
                Log::error('Failed to load theme settings', ['error' => $e->getMessage()]);
                $themeSettings = [
                    'theme_mode' => 'light',
                    'theme_choosen' => 'default',
                    'logo' => null,
                    'favicon' => null,
                    'website_name' => config('app.name'),
                ];
            }
            
            // Cache OTP settings
            $otpEnabled = false;
            try {
                $otpEnabled = Cache::remember('otp_enabled', now()->addDay(), function () {
                    return \App\AdminOTPCredentials::where('status', 1)->exists();
                });
                Log::debug('OTP status loaded', ['enabled' => $otpEnabled]);
            } catch (\Exception $e) {
                Log::error('Failed to load OTP settings', ['error' => $e->getMessage()]);
            }

            // Cache country codes
            $countryJsonData = Cache::remember('country_codes', 60 * 24 * 7, function () {
                try {
                    $filePath = base_path('assets/country_code.json');
                    if (!file_exists($filePath)) {
                        Log::warning('Country code file not found at: ' . $filePath);
                        return [];
                    }
                    $jsonString = file_get_contents($filePath);
                    $data = json_decode($jsonString, true) ?? [];
                    usort($data, function ($a, $b) {
                        return strcmp($a['code'] ?? '', $b['code'] ?? '');
                    });
                    Log::debug('Country codes loaded', ['count' => count($data)]);
                    return $data;
                } catch (\Exception $e) {
                    Log::error('Failed to load country codes', ['error' => $e->getMessage()]);
                    return [];
                }
            });

            // Get settings with null coalescing to prevent undefined index errors
            $settings = (object)($allSettings['app'] ?? []);
            $homeSettings = (object)($allSettings['home'] ?? []);
            $emailSettings = (object)($allSettings['email'] ?? []);
            $storageSettings = (object)($allSettings['storage'] ?? []);
            
            // Ensure required properties exist with fallbacks
            $settings->website_name = $settings->website_name ?? config('app.name');
            $settings->favicon = $settings->favicon ?? 'favicon.ico';
            $settings->login_content = $settings->login_content ?? 'Landban.png';
            $settings->login_text = $settings->login_text ?? 'Welcome Back';
            $settings->demo_mode = $settings->demo_mode ?? 0;
            $settings->logo = $settings->logo ?? null;
            
            // Set app locale
            $locale = 'en';
            if (isset($settings->translate_language)) {
                $locale = $settings->translate_language;
            } elseif (isset($settings->website_default_language)) {
                $locale = $settings->website_default_language;
            }
            
            try {
                app()->setLocale($locale);
                Log::debug('App locale set', ['locale' => $locale]);
            } catch (\Exception $e) {
                Log::error('Failed to set locale', ['locale' => $locale, 'error' => $e->getMessage()]);
            }
            
            // Ensure theme_mode is always set
            $themeMode = $themeSettings['theme_mode'] ?? 'light';
            
            // Ensure theme is an object for backward compatibility
            $theme = (object)$themeSettings;
            
            // Prepare view data - using both array and direct variable assignments for backward compatibility
            $viewData = [
                'settings' => $settings,
                'HomeSetting' => $homeSettings,
                'storageSettings' => $storageSettings,
                'email_settings' => $emailSettings,
                'theme' => $theme, // Pass as object for compatibility
                'themeSettings' => $themeSettings, // Pass as array if needed
                'theme_mode' => $themeMode, // Direct variable for backward compatibility
                'otp_enabled' => $otpEnabled,
                'country_json_data' => $countryJsonData,
                'system_settings' => (object)[], // Empty object for backward compatibility
            ];
            
            // Share all data with views first
            View::share($viewData);
            
            // Then make all view data available as variables
            foreach ($viewData as $key => $value) {
                ${$key} = $value;
            }
            
            Log::debug('Sharing data with views', array_keys($viewData));
            
            // Share all data with views
            View::share($viewData);
            
            return $viewData;
        } catch (\Exception $e) {
            Log::error('Critical error in loadMinimalSettings', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Provide fallback data to prevent complete failure
            $fallbackSettings = (object)[
                'website_name' => config('app.name'),
                'favicon' => 'favicon.ico',
                'login_content' => 'Landban.png',
                'login_text' => 'Welcome Back',
                'demo_mode' => 0,
            ];
            
            $fallbackTheme = (object)[
                'theme_mode' => 'light',
                'light_mode_logo' => null,
                'dark_mode_logo' => null,
            ];
            
            $fallbackData = [
                'settings' => $fallbackSettings,
                'HomeSetting' => (object)[],
                'storageSettings' => (object)[],
                'email_settings' => (object)[],
                'theme' => $fallbackTheme,
                'themeSettings' => (array)$fallbackTheme,
                'theme_mode' => 'light',
                'otp_enabled' => false,
                'country_json_data' => [],
                'system_settings' => (object)[],
                'login_bgimg' => false,
            ];
            
            // Share all data with views first
            View::share($fallbackData);
            
            // Then make all view data available as variables
            foreach ($fallbackData as $key => $value) {
                ${$key} = $value;
            }
            
            return $fallbackData;
        }
    }
}
