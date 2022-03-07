<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Deploy;

class Autodeploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Autodeploy:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull the files from git Daily';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $Deploy = Deploy::first();
        if($Deploy != null){   
                $username           =   $Deploy['username'];
                $password           =   $Deploy['password'];
                $host               =   $Deploy['host'];
                $port               =   $Deploy['port'];
            
            // SSh connection
                $connection = ssh2_connect( $host, 22527);
                ssh2_auth_password($connection, $username, $password);

                $Stream1 = ssh2_exec($connection, "cd public_html &&  git pull origin master;");
                $errorStream1 = ssh2_fetch_Stream($Stream1, SSH2_STREAM_STDERR);

                Stream_set_blocking($errorStream1, true);
                Stream_set_blocking($Stream1, true);

                $Auto_Pull =  Stream_get_contents($Stream1);
                    
                fclose($errorStream1);
                fclose($Stream1);
                return true;
         }
         else{
             return 0;
         }
    }
}
