<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use \Redirect as Redirect;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use \App\Setting;
use \App\User;
use View;

class ClearCacheController extends Controller
{
   
    public function index()
    {
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');

        if ($current_date > $duedate)
        {

            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());

           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
            );
            return View::make('admin.expired_dashboard', $data);

        }else{
            return view('admin.cache.index');

        }
    }

    public function clear_caches()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('clear-compiled');
            Artisan::call('package:discover --ansi');

            return response()->json([
                'status' => true,
                'message' => 'Clear all the caches successfully.',
            ], 200);


        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => 'An error occurred.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function clear_buffer_cache(Request $request)
    {
        try {
            $inputPassword = $request->input('password');

            if ( is_null($inputPassword)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid password provided.',
                ], 403);
            }

            $command = 'echo ' . escapeshellarg($inputPassword) . ' | sudo -S sh -c "sync; echo 3 > /proc/sys/vm/drop_caches"';
            $process = Process::fromShellCommandline($command);

            try {
                $process->mustRun();

                return response()->json([
                    'status' => true,
                    'message' => 'Clear buffer cache successfully!',
                    'output' => $process->getOutput(),
                    'error_output' => $process->getErrorOutput(),
                ], 200);

            } catch (ProcessFailedException $exception) {

                return response()->json([
                    'status' => false,
                    'message' => $exception->getMessage(),
                    'error_output' => $exception->getErrorOutput(),
                ], 500);
            }
        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => 'An error occurred.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function view_buffer_cache()
    {
        try {
            
            $process = new Process(['free', '-h']);
            $process->run();
    
            if ($process->isSuccessful()) {

                $output = $process->getOutput();
    
                $lines = explode("\n", trim($output)); 
                $memLine = preg_split('/\s+/', $lines[1]);
                $swapLine = preg_split('/\s+/', $lines[2]); 

                $memoryDetails = [
                    'memory' => [
                        'total' => $memLine[1],
                        'used' => $memLine[2],
                        'free' => $memLine[3],
                        'shared' => $memLine[4],
                        'buff_cache' => $memLine[5],
                        'available' => $memLine[6],
                    ],
                    'swap' => [
                        'total' => $swapLine[1],
                        'used' => $swapLine[2],
                        'free' => $swapLine[3],
                    ],
                ];
        
                return response()->json([
                    'status'  => true,
                    'message' => 'Retrieve memory details.',
                    'data'    => $memoryDetails,
                ]);
            }
    
            return response()->json([
                'status'  => true,
                'message' => 'Failed to retrieve memory details.',
            ], 500);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'An error occurred.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function Env_index(){

        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');

        if ($current_date > $duedate)
        {

            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());

           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
            );
            return View::make('admin.expired_dashboard', $data);

        }else{
           
            return View('admin.env_debug.index');

        }
    }

    public function Env_AppDebug(Request $request)
    {
        try {
             
            $Env_path = realpath(('.env'));

            $status = $request->status == "true" ? "true" : 'false';
            $Replace_data =array(
                'APP_DEBUG' => $status,
            );

            file_put_contents($Env_path, implode('', 
                    array_map(function($Env_path) use ($Replace_data) {
                        return   stristr($Env_path,'APP_DEBUG') ? "APP_DEBUG=".$Replace_data['APP_DEBUG']."\n" : $Env_path;
                    }, file($Env_path))
            ));

            return response()->json(['message'=>"true"]);

        } catch (\Throwable $th) {
           return response()->json(['message'=>"false"]);
        }
    }

    public function testing_command(Request $request)
    {
        try {

            $password = '39|&*kDY,@s1';
            $command = 'echo ' . escapeshellarg($password) . ' | sudo -S sh -c "sync; echo 3 > /proc/sys/vm/drop_caches"';
        
            $process = Process::fromShellCommandline($command);

            try {
                $process->mustRun();
        
                return response()->json([
                    'status'  => true ,
                    'message' => 'clear views Cache successfully !!',
                    'output'  => $process->getOutput(),
                    'error_output' => $process->getErrorOutput(),
                ], 200);

            } catch (ProcessFailedException $exception) {

                return response()->json([
                    'status'  => false ,
                    'message' => $exception->getMessage(),
                    'error_output' => $process->getErrorOutput(),
                ], 500);
            }
            
        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => 'An error occurred.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}