<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;
use Victorybiz\GeoIPLocation\GeoIPLocation;

class HomepageCacheService
{
    protected $geoip;
    protected $agent;

    public function __construct(GeoIPLocation $geoip, Agent $agent)
    {
        $this->geoip = $geoip;
        $this->agent = $agent;
    }

    public function getGeoLocation($ip)
    {
        return Cache::remember("geoip_{$ip}", now()->addDay(), function () use ($ip) {
            return [
                'country' => $this->geoip->getCountry(),
                'region' => $this->geoip->getRegion(),
                'city' => $this->geoip->getCity()
            ];
        });
    }

    public function getDeviceType()
    {
        $userAgent = request()->userAgent();
        return Cache::remember("device_{$userAgent}", now()->addDay(), function () {
            return $this->agent->isDesktop() ? 'desktop' :
                ($this->agent->isTablet() ? 'tablet' :
                    ($this->agent->isMobile() ? 'mobile' :
                        ($this->agent->isTv() ? 'tv' : 'unknown')));
        });
    }

    public function getHomeSettings()
    {
        return Cache::remember('home_settings', now()->addHour(), function () {
            return \App\HomeSetting::first();
        });
    }

    public function getPages()
    {
        return Cache::remember('all_pages', now()->addDay(), function () {
            return \App\Page::all();
        });
    }
}