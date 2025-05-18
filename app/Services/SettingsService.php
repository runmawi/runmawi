<?php

namespace App\Services;

use App\Setting;
use App\HomeSetting;
use App\EmailSetting;
use App\StorageSetting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    /**
     * Cache duration in minutes
     */
    protected $cacheDuration = 1440; // 24 hours

    /**
     * Get all settings with caching
     * 
     * @return array
     */
    public function getAllSettings()
    {
        return Cache::remember('app_settings_all', $this->cacheDuration, function () {
            // Use a single query to get all settings
            $settings = [
                'app' => Setting::first(),
                'home' => HomeSetting::first(),
                'email' => EmailSetting::first(),
                'storage' => StorageSetting::first(),
                'site_theme' => \App\SiteTheme::first(),
                'pages' => \App\Page::where('footer_active', 1)->get(),
                'footer_script' => \App\Script::value('footer_script'),
            ];
            
            // Cache individual settings for faster access
            foreach ($settings as $key => $value) {
                if ($value !== null) {
                    Cache::put("app_settings_{$key}", $value, $this->cacheDuration);
                }
            }
            
            return $settings;
        });
    }

    /**
     * Get specific setting by key
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $settings = $this->getAllSettings();
        
        // Check in app settings first
        if (isset($settings['app']->$key)) {
            return $settings['app']->$key;
        }
        
        // Check in home settings
        if (isset($settings['home']->$key)) {
            return $settings['home']->$key;
        }
        
        // Check in email settings
        if (isset($settings['email']->$key)) {
            return $settings['email']->$key;
        }
        
        // Check in storage settings
        if (isset($settings['storage']->$key)) {
            return $settings['storage']->$key;
        }
        
        return $default;
    }

    /**
     * Get site theme with caching
     * 
     * @return \App\SiteTheme|null
     */
    public function getSiteTheme()
    {
        if ($this->siteTheme) {
            return $this->siteTheme;
        }
        
        $this->siteTheme = Cache::remember('app_settings_site_theme', $this->cacheDuration, function () {
            return \App\SiteTheme::first();
        });
        
        return $this->siteTheme;
    }
    
    /**
     * Get button background color with caching
     * 
     * @return string
     */
    public function getButtonBgColor()
    {
        return Cache::remember('button_bg_color', $this->cacheDuration, function () {
            $theme = $this->getSiteTheme();
            return $theme ? $theme->button_bg_color : '#000000';
        });
    }
    
    /**
     * Get active footer pages with caching
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFooterPages()
    {
        return Cache::remember('footer_pages', $this->cacheDuration, function () {
            return \App\Page::where('footer_active', 1)->get();
        });
    }
    
    /**
     * Get footer script with caching
     * 
     * @return string
     */
    public function getFooterScript()
    {
        return Cache::remember('footer_script', $this->cacheDuration, function () {
            return \App\Script::value('footer_script') ?? '';
        });
    }
    
    /**
     * Clear all cached settings
     * 
     * @return void
     */
    public function clearCache()
    {
        // Clear all settings cache
        Cache::forget('app_settings_all');
        
        // Clear individual caches that might be used elsewhere
        $caches = [
            'app_settings', 'home_settings', 'email_settings', 'storage_settings',
            'bunny_cdn_enable', 'bunny_cdn_url', 'videos_expiry_status',
            'default_vertical_image', 'default_horizontal_image', 'current_timezone',
            'app_settings_site_theme', 'button_bg_color', 'footer_pages', 'footer_script'
        ];
        
        foreach ($caches as $cache) {
            Cache::forget($cache);
        }
        
        $this->siteTheme = null;
    }

    /**
     * Get theme-related settings
     * 
     * @return array
     */
    public function getThemeSettings()
    {
        $settings = $this->getAllSettings();
        $homeSettings = $settings['home'] ?? (object)[];
        
        return [
            'theme_mode' => $homeSettings->theme_mode ?? 'light',
            'theme_choosen' => $homeSettings->theme_choosen ?? 'default',
            'theme_settings' => $homeSettings->theme_settings ?? null,
            'logo' => $homeSettings->logo ?? null,
            'favicon' => $homeSettings->favicon ?? null,
            'website_name' => $homeSettings->website_name ?? config('app.name'),
            'light_mode_logo' => $homeSettings->light_mode_logo ?? null,
            'dark_mode_logo' => $homeSettings->dark_mode_logo ?? null,
            'enable_dark_mode' => $homeSettings->enable_dark_mode ?? true,
            'primary_color' => $homeSettings->primary_color ?? '#4e54c8',
            'secondary_color' => $homeSettings->secondary_color ?? '#8f94fb',
            'background_color' => $homeSettings->background_color ?? '#f8f9fa',
            'text_color' => $homeSettings->text_color ?? '#212529',
            'font_family' => $homeSettings->font_family ?? 'Nunito, sans-serif',
            'font_size' => $homeSettings->font_size ?? '16px',
            'border_radius' => $homeSettings->border_radius ?? '4px',
            'box_shadow' => $homeSettings->box_shadow ?? '0 2px 4px rgba(0,0,0,0.1)'
        ];
    }

    /**
     * Get storage settings
     * 
     * @return array
     */
    public function getStorageSettings()
    {
        $settings = $this->getAllSettings();
        
        return [
            'bunny_cdn_enabled' => $settings['storage']->bunny_cdn_storage ?? false,
            'bunny_cdn_url' => $settings['storage']->bunny_cdn_base_url ?? null,
            'local_url' => url('/public/uploads'),
        ];
    }
}
