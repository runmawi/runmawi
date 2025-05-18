<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed get(string $key, mixed $default = null)
 * @method static array getAllSettings()
 * @method static void clearCache()
 * @method static array getThemeSettings()
 * @method static array getStorageSettings()
 */
class Settings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'settings';
    }
}
