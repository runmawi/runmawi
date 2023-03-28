<?php 

$current_time = Carbon\Carbon::now()->format('H:i:s');
$adveristment_plays_24hrs = App\Setting::pluck('ads_play_unlimited_period')->first();

if(  plans_ads_enable() == 1 ){
  
    $live_ads = App\AdsEvent::Join('advertisements','advertisements.id','=','ads_events.ads_id');
        // ->whereDate('start', '=', Carbon\Carbon::now()->format('Y-m-d'))
        // ->whereTime('start', '<=', $current_time)
        // ->whereTime('end', '>=', $current_time)
        if($adveristment_plays_24hrs == 0){
            $live_ads =  $live_ads->whereTime('start', '<=', $current_time)->whereTime('end', '>=', $current_time);
        }

        $live_ads =  $live_ads->where('ads_events.status',1)
        ->where('advertisements.status',1)
        ->where('advertisements.id',$video->live_ads)
        ->where('advertisements.ads_position',$video->ads_position)
        ->pluck('ads_path')->first();
  }
  else
  {
        $live_ads = null ;
  }

?>