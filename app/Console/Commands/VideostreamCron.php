<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\User as User;
use Carbon\Carbon;
use App\LiveStream as LiveStream;
use Mail;
use Auth;
use Laravel\Cashier\Invoice;
use App\Video as Video;

class VideostreamCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renewalnotify:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
      
      	$users = User::all();
          $all = Video::where('publish_type', '=', 'publish_later')->where('publish_status', '=', 0)->get();
          // echo "<pre>";
          $current_date = date('Y-m-d h:i:s');    
          $daten = date('Y-m-d h:i:s ', time());  
          $d = new \DateTime('now');
          $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));  
          $now = $d->format('Y-m-d h:i:s a');
          $current_time = date('Y-m-d h:i A', strtotime($now));
          foreach($all as $key => $value){
              $id = $value['id'];
              $publish_time = date('Y-m-d h:i A', strtotime($value['publish_time']));

              if($publish_time == $current_time){
                  $video = Video::findOrFail($id); 
                  $video->publish_status = 1; 
                  $video->save();
              }else{
                  $video = Video::findOrFail($id); 
                  $video->publish_status = 0; 
                  $video->save();
              }
          }
        }
      
                   
}