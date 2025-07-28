<?php 

$adveristment_plays_24hrs = App\Setting::pluck('ads_play_unlimited_period')->first();

$current_time = Carbon\Carbon::now()->format('H:i:s');


if(  plans_ads_enable() == 1 ){
  
      $episode_ads = App\AdsEvent::Join('advertisements','advertisements.id','=','ads_events.ads_id');
        // ->whereDate('start', '=', Carbon\Carbon::now()->format('Y-m-d'))
        // ->whereTime('start', '<=', $current_time)
        // ->whereTime('end', '>=', $current_time)

      if($adveristment_plays_24hrs == 0){
            $episode_ads =  $episode_ads->whereTime('start', '<=', $current_time)->whereTime('end', '>=', $current_time);
      }

      $episode_ads =  $episode_ads->where('ads_events.status',1)

      ->where('advertisements.status',1)
      ->where('advertisements.id',$episode->episode_ads)
      ->where('advertisements.ads_position',$episode->ads_position)
      ->pluck('ads_path')->first();	
  }
  else
  {
        $episode_ads = null ;
  } 

?>