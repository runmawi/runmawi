<?php

    $latest_videos = App\Video::where('active', '=', '1')->where('status', '=', '1')
            ->where('draft', '=', '5')->orderBy('created_at', 'desc')->take(5);

    if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
         $latest_videos = $latest_videos  ->whereNotIn('videos.id',Block_videos());
    }

    $latest_videos = $latest_videos->get();

    $latest_livestreams =  App\LiveStream::limit('5')->latest()->get();

    $latest_audio =  App\Audio::where('active', '=', '1')->where('status', '=', '1')
                                ->limit('5')->latest()->get();

    $latest_Episode = App\Episode::where('active', '=', '1')->where('status', '=', '1')
                                ->limit('5')->latest()->get();   

    $latest_Series = App\Series::where('active', '=', '1')->limit('5')->latest()->get();  


// Top Trending
    
    $Most_view_videos = App\RecentView::Join('videos','videos.id','=','recent_views.video_id')
                ->where('videos.active', '=', '1')
                ->where('videos.status', '=', '1')
                ->where('videos.draft', '=', '1')
                ->groupBy('video_id')
                ->limit('5')
                ->latest('videos.created_at');
                if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                    $Most_view_videos = $Most_view_videos ->whereNotIn('videos.id',Block_videos());
                }
                $Most_view_videos = $Most_view_videos->get();
    

    $Most_view_audios = App\RecentView::Join('audio','audio.id','=','recent_views.audio_id')
        ->where('audio.active', '=', '1')
        ->where('audio.status', '=', '1')
        ->limit('5')
        ->latest('audio.created_at')
        ->groupBy('audio_id')
        ->get();

    $Most_view_live   = App\RecentView::Join('live_streams','live_streams.id','=','recent_views.live_id')
        ->where('live_streams.active', '=', '1')
        ->latest('live_streams.created_at')
        ->groupBy('recent_views.live_id')
        ->limit('5')
        ->get();

    $Most_view_episode  = App\RecentView::Join('episodes','episodes.id','=','recent_views.episode_id')
        ->where('episodes.active', '=', '1')
        ->where('episodes.status', '=', '1')
        ->limit('5')
        ->latest('episodes.created_at')
        ->groupBy('episode_id')
        ->get();

    $Most_view_Series  = App\RecentView::select('series.*')
        ->Join('episodes','episodes.id','=','recent_views.episode_id')
        ->Join('series','series.id','=','episodes.series_id')
        ->where('series.active', '=', '1')
        ->limit('5')
        ->latest('series.created_at')
        ->groupBy('series.id')
        ->get();

// Highlighted

    $videos = App\Video::where('active', '=', '1')
                ->where('status', '=', '1')
                ->where('draft', '=', '1')
                ->where('featured', '=', '1')
                ->orderBy('created_at', 'desc')
                ->take(5);
                if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                    $videos = $videos ->whereNotIn('videos.id',Block_videos());
                }
    $videos = $videos->get();

    $livestreams = App\LiveStream::where('active', '=', '1')
                    ->where('featured','=', '1')
                    ->limit('5')
                    ->latest()
                    ->get();

    $audio = App\Audio::where('active', '=', '1')
        ->where('status', '=', '1')
        ->where('featured', '=', '1')
        ->limit('5')
        ->latest()
        ->get();

    $Episode = App\Episode::where('active', '=', '1')
        ->where('status', '=', '1')
        ->where('featured', '=', '1')
        ->limit('5')
        ->latest()
        ->get();    

    $Series = App\Series::where('active', '=', '1')
        ->where('featured', '=', '1')
        ->limit('5')
        ->latest()
        ->get();  
?>
 
                        
<!-- Latest video -->

<?php if( (count($latest_videos) > 1) || (count($latest_livestreams) > 1) || (count($latest_audio) > 1) ||  (count($latest_Episode) > 1) ||  (count($latest_Series) > 1)   ){ ; ?>
<ul class="list-group home-search" style="display: block; position: relative; z-index: 999999; margin-bottom: 0; border-radius: 0; ">
    <h6 style="margin: 0; text-align: left; padding: 10px;">Recent Videos </h6>

    <?php foreach ($latest_videos as $row) { ?>
        <li class="list-group-item">
            <img width="35px" height="35px" src="<?php echo URL::to('/') . '/public/uploads/images/' . $row->image ;  ?>" />
            <a href="<?php echo URL::to('/') . '/category/videos/' . $row->slug ; ?>" style="font-color: #c61f1f00; color: #000; text-decoration: none;"> <?php echo $row->title ; ?> </a>
        </li>
    <?php } ?>

    <?php foreach ($latest_livestreams as $row) { ?>
        <li class="list-group-item">
            <img width="35px" height="35px" src="<?php echo URL::to('/') . '/public/uploads/images/' . $row->image ;  ?>" />
            <a href="<?php echo URL::to('/') . '/live' .'/'. $row->slug ; ?>" style="font-color: #c61f1f00; color: #000; text-decoration: none;"> <?php echo $row->title ; ?> </a>
        </li>
    <?php } ?>

    <?php foreach ($latest_audio as $row) { ?>
        <li class="list-group-item">
            <img width="35px" height="35px" src="<?php echo URL::to('/') . '/public/uploads/images/' . $row->image ;  ?>" />
            <a href="<?php echo URL::to('/') . '/audio/' . $row->slug ; ?>" style="font-color: #c61f1f00; color: #000; text-decoration: none;"> <?php echo $row->title ; ?> </a>
        </li>
    <?php } ?>


    <?php foreach ($latest_Episode as $row) {  
         $series_slug = App\Series::where('id',$row->series_id)->pluck('slug')->first(); 
    ?>
        <li class="list-group-item">
            <img width="35px" height="35px" src="<?php echo URL::to('/') . '/public/uploads/images/' . $row->image ;  ?>" />
            <a href="<?php echo URL::to('/') . '/episode' .'/'. $series_slug . '/'. $row->slug ; ?>" style="font-color: #c61f1f00; color: #000; text-decoration: none;"> <?php echo $row->title ; ?> </a>
        </li>
    <?php } ?>


    <?php foreach ($latest_Series as $row) { ?>
        <li class="list-group-item">
            <img width="35px" height="35px" src="<?php echo URL::to('/') . '/public/uploads/images/' . $row->image ;  ?>" />
            <a href="<?php echo URL::to('/') . '/play_series' .'/'. $row->slug ; ?>" style="font-color: #c61f1f00; color: #000; text-decoration: none;"> <?php echo $row->title ; ?> </a>
        </li>
    <?php } ?>

</ul>
<?php } ?>



<!-- Top Trending -->
<?php if( (count($Most_view_videos) > 1) || (count($Most_view_live) > 1) || (count($Most_view_audios) > 1) ||  (count($Most_view_episode) > 1) ||  (count($Most_view_Series) > 1)   ){ ; ?>
<ul class="list-group home-search" style="display: block; position: relative; z-index: 999999; margin-bottom: 0; border-radius: 0;background:#000;">
    <h6 style="margin: 0; text-align: left; padding: 10px;">Trending  Video</h6>

    <?php foreach ($Most_view_videos as $row) { ?>
        <li class="list-group-item">
            <img width="35px" height="35px" src="<?php echo URL::to('/') . '/public/uploads/images/' . $row->image ;  ?>" />
            <a href="<?php echo URL::to('/') . '/category/videos/' . $row->slug ; ?>" style="font-color: #c61f1f00; color: #000; text-decoration: none;"> <?php echo $row->title ; ?> </a>
        </li>
    <?php } ?>

    <?php foreach ($Most_view_live as $row) { ?>
        <li class="list-group-item home-search">
            <img width="35px" height="35px" src="<?php echo URL::to('/') . '/public/uploads/images/' . $row->image ;  ?>" />
            <a href="<?php echo URL::to('/') . '/live' .'/'. $row->slug ; ?>" style="font-color: #c61f1f00; color: #000; text-decoration: none;"> <?php echo $row->title ; ?> </a>
        </li>
    <?php } ?>

    <?php foreach ($Most_view_audios as $row) { ?>
        <li class="list-group-item">
            <img width="35px" height="35px" src="<?php echo URL::to('/') . '/public/uploads/images/' . $row->image ;  ?>" />
            <a href="<?php echo URL::to('/') . '/audio/' . $row->slug ; ?>" style="font-color: #c61f1f00; color: #000; text-decoration: none;"> <?php echo $row->title ; ?> </a>
        </li>
    <?php } ?>


    <?php foreach ($Most_view_episode as $row) {  
         $series_slug = App\Series::where('id',$row->series_id)->pluck('slug')->first(); 
    ?>
        <li class="list-group-item">
            <img width="35px" height="35px" src="<?php echo URL::to('/') . '/public/uploads/images/' . $row->image ;  ?>" />
            <a href="<?php echo URL::to('/') . '/episode' .'/'. $series_slug . '/'. $row->slug ; ?>" style="font-color: #c61f1f00; color: #000; text-decoration: none;"> <?php echo $row->title ; ?> </a>
        </li>
    <?php } ?>


    <?php foreach ($Most_view_Series as $row) { ?>
        <li class="list-group-item">
            <img width="35px" height="35px" src="<?php echo URL::to('/') . '/public/uploads/images/' . $row->image ;  ?>" />
            <a href="<?php echo URL::to('/') . '/play_series' .'/'. $row->slug ; ?>" style="font-color: #c61f1f00; color: #000; text-decoration: none;"> <?php echo $row->title ; ?> </a>
        </li>
    <?php } ?>

</ul>
<?php } ?>


<!-- Highlighted -->

<?php if( (count($videos) > 1) || (count($livestreams) > 1) || (count($audio) > 1) ||  (count($Episode) > 1) ||  (count($Series) > 1)   ){ ; ?>
<ul class="list-group home-search" style="display: block; position: relative; z-index: 999999; margin-bottom: 0; border-radius: 0;">
    <h6 style="margin: 0; text-align: left; padding: 10px;">Highlighted videos </h6>

    <?php foreach ($videos as $row) { ?>
        <li class="list-group-item">
            <img width="35px" height="35px" src="<?php echo URL::to('/') . '/public/uploads/images/' . $row->image ;  ?>" />
            <a href="<?php echo URL::to('/') . '/category/videos/' . $row->slug ; ?>" style="font-color: #c61f1f00; color: #000; text-decoration: none;"> <?php echo $row->title ; ?> </a>
        </li>
    <?php } ?>

    <?php foreach ($livestreams as $row) { ?>
        <li class="list-group-item">
            <img width="35px" height="35px" src="<?php echo URL::to('/') . '/public/uploads/images/' . $row->image ;  ?>" />
            <a href="<?php echo URL::to('/') . '/live' .'/'. $row->slug ; ?>" style="font-color: #c61f1f00; color: #000; text-decoration: none;"> <?php echo $row->title ; ?> </a>
        </li>
    <?php } ?>

    <?php foreach ($audio as $row) { ?>
        <li class="list-group-item">
            <img width="35px" height="35px" src="<?php echo URL::to('/') . '/public/uploads/images/' . $row->image ;  ?>" />
            <a href="<?php echo URL::to('/') . '/audio/' . $row->slug ; ?>" style="font-color: #c61f1f00; color: #000; text-decoration: none;"> <?php echo $row->title ; ?> </a>
        </li>
    <?php } ?>


    <?php foreach ($Episode as $row) {  
         $series_slug = App\Series::where('id',$row->series_id)->pluck('slug')->first(); 
    ?>
        <li class="list-group-item">
            <img width="35px" height="35px" src="<?php echo URL::to('/') . '/public/uploads/images/' . $row->image ;  ?>" />
            <a href="<?php echo URL::to('/') . '/episode' .'/'. $series_slug . '/'. $row->slug ; ?>" style="font-color: #c61f1f00; color: #000; text-decoration: none;"> <?php echo $row->title ; ?> </a>
        </li>
    <?php } ?>


    <?php foreach ($Series as $row) { ?>
        <li class="list-group-item">
            <img width="35px" height="35px" src="<?php echo URL::to('/') . '/public/uploads/images/' . $row->image ;  ?>" />
            <a href="<?php echo URL::to('/') . '/play_series' .'/'. $row->slug ; ?>" style="font-color: #c61f1f00; color: #000; text-decoration: none;"> <?php echo $row->title ; ?> </a>
        </li>
    <?php } ?>

</ul>
<?php } ?>

<style>
    ul.list-group.home-search {
        overflow: auto;
        height: 150px;
        background: black;
    }
</style>