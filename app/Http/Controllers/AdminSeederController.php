<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class AdminSeederController extends Controller
{
    public function index(Request $request)
    {
        try {
            
            $seederClasses = [];

            $seederPath = database_path('seeds');
            $files = scandir($seederPath);

            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && $file !== "DatabaseSeeder.php") {
                    $className = str_replace('.php', '', $file);
                    $seederClasses[] = $className;
                }
            }

            $data = array(
                'seederClasses'  => $seederClasses ,
            );

            return view('admin.seeding.index',$data);

        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function unique_seeding(Request $request)
    {
        try {

            Artisan::call('db:seed', ['--class' => $request->seed_class ]);

            return redirect()->route('seeding-index')->with('success', 'Seeding for '. $request->seed_class.' has successfully run and finished.');


        } catch (\Throwable $th) {

            return redirect()->route('seeding-index')->with('failure', $th->getMessage());
        }
    }

    public function refresh_seeding(Request $request)
    {
        try {

            Artisan::call('db:seed'); 

            $data = [
                'status' => true,
                'message' => 'Refresh the seeding Successfully!!',
            ];

        } catch (\Throwable $th) {
            $data = [
                'status' => false,
                'message' => $th->getMessage(),
            ];

            return abort(404);
        }

    }
}
