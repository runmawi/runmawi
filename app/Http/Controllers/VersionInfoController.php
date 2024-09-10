<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VersionInfoController extends Controller
{

    public function version_info()
    {
        try {

            $composerJsonPath = base_path('composer.json'); // Laravel's base path to locate composer.json
            $composerJson = [];
        
            if (file_exists($composerJsonPath)) {
                $composerJson = json_decode(file_get_contents($composerJsonPath), true);
            }

            $data = array(
                "laravel_version"  => app()->version(),
                "composer_version" => trim(shell_exec('composer --version')),
                "php_version"      => phpversion(),
                'composer_json'   => $composerJson,
                'redirect_url'        => URL('/home'),
            );
    
            return view('version-info', $data);

        } catch (\Throwable $th) {

            return abort(404);
        }
    }
}