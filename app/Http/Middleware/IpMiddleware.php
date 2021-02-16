<?php
   
namespace App\Http\Middleware;
   
use Closure;
use View;
use GeoIPLocation;
use App\Country as Country;
 
   
class IpMiddleware
{
    
    public $restrictIps = ['169.159.82.111'];
        
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle($request, Closure $next)
    {
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $mycountry = $geoip->getCountry();
        $allCountries = Country::all()->pluck('country_name');
        
        $user_country = Country::where('country_name', '=', $mycountry)->first();
        if ($user_country !== null) {
           return redirect('/blocked');
        }

        return $next($request);
    }
}