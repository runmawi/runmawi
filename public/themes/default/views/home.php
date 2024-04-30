<!-- Header Start Test MEssage -->
<?php include('header.php'); 
   $order_settings = App\OrderHomeSetting::select('id','order_id','url','video_name','header_name')->orderBy('order_id', 'asc')->get();  
   $order_settings_list = App\OrderHomeSetting::get();  
   $continue_watching_setting = App\HomeSetting::pluck('continue_watching')->first();  
   $slider_choosen = App\HomeSetting::pluck('slider_choosen')->first();  
   
?>
<!-- Header End -->

<!-- Slider Start -->
   <section id="home" class="iq-main-slider m-0 p-0">

      <div id="home-slider" class="slider m-0 p-0">
         <?php
               if($slider_choosen == 2){
                  include('partials/home/slider-2.php'); 
               }
               else{
                  include('partials/home/slider-1.php'); 
               }
         ?>
      </div>

      <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
         <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44" width="44px" height="44px" id="circle"
            fill="none" stroke="currentColor">
            <circle r="20" cy="22" cx="22" id="test"></circle>
         </symbol>
      </svg>

   </section>
<!-- Slider End -->

<!-- MainContent -->
<div class="main-content">
   <?php if( !Auth::guest() && $continue_watching_setting != null &&  $continue_watching_setting == 1 ){ ?>
   <section id="iq-continue">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/continue-watching.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php  } ?>

   <?php 
      foreach($order_settings as $key => $value){
         
        //  if($value == ){}
        if($value->video_name == 'Recommendation'){
      
      if(count($top_most_watched) > 0){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/Top_videos.blade.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } ?>
   <?php if(count($most_watch_user) > 0){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/most_watched_user.blade.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } ?>
   <?php 
      if(count($Most_watched_country) > 0){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/most_watched_country.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } ?>
   <?php 
      if(($preference_genres) != null && count($preference_genres) > 0){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/preference_genres.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } ?>
   <?php 
      if(($preference_Language) != null && count($preference_Language) > 0){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/preference_Language.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } } ?>
   <?php 
      if($value->video_name == 'latest_videos'){
      
      if($home_settings->latest_videos == 1){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/latest-videos.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } } ?>

   <?php 
      if($value->video_name == 'watchlater_videos' && $home_settings->watchlater_videos == 1 && !(Auth::guest())){ ?>
         <section id="iq-favorites">
            <div class="container-fluid overflow-hidden">
               <div class="row">
                  <div class="col-sm-12 ">
                     <?php include('partials/home/watchlater_videos.php'); ?>
                  </div>
               </div>
            </div>
         </section>
   <?php }  ?>

   <?php 
      if($value->video_name == 'wishlist_videos' && $home_settings->wishlist_videos == 1 && !(Auth::guest()) ){ ?>
         <section id="iq-favorites">
            <div class="container-fluid overflow-hidden">
               <div class="row">
                  <div class="col-sm-12 ">
                     <?php include('partials/home/wishlist_videos.php'); ?>
                  </div>
               </div>
            </div>
         </section>
   <?php  } ?>

   <?php 
      if($value->video_name == 'latest_episode_videos' && $home_settings->latest_episode_videos == 1 ){ ?>
         <section id="iq-favorites">
            <div class="container-fluid overflow-hidden">
               <div class="row">
                  <div class="col-sm-12 ">
                     <?php include('partials/home/Latest-videos-episode.blade.php'); ?>
                  </div>
               </div>
            </div>
         </section>
   <?php  } ?>

<!-- Playlist -->

   <?php 
   if(!Auth::guest()){
      if($value->video_name == 'my_play_list'){
      
      if($home_settings->my_playlist == 1){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/my-playlist.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } }  } ?>

   <?php 
   if(!Auth::guest()){
      if($value->video_name == 'video_play_list'){
      
      if($home_settings->video_playlist == 1){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/playlist-videos.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } }  } ?>

   <!-- Document -->

   
   <?php 
      if($value->video_name == 'Document'){
      
      if($home_settings->Document == 1){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/Documents.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } }  ?>

   <?php
         if($value->video_name == 'Document_Category'){
            if($home_settings->Document_Category == 1){ ?>
            <section id="iq-favorites">
            <div class="container-fluid overflow-hidden">

                  <?php
                     $parentCategories = App\DocumentGenre::get();
                     foreach($parentCategories as $category) {
                        $Documents =  App\Document::where('category','!=',null)->WhereJsonContains('category',(string) $category->id)->limit(20)->get();
                  ?>

                  <?php 
                     if (count($Documents) > 0) { 
                        include('partials/home/Document-Category.php');
                     } 
                     else { 
                  ?>
                     <p class="no_video"></p>
                  <?php } }?>
         </section>
      <?php } } ?>

   <!-- Audio Genre -->
   <?php
       if( $value->video_name == "Audio_Genre"){
         if($home_settings->AudioGenre == 1){  ?>
            <section id="iq-favorites">
               <div class="container-fluid overflow-hidden">
                     <div class="row">
                        <div class="col-sm-12">
                           <?php include 'partials/home/AudioGenre.php'; ?>
                        </div>
                     </div>
               </div>
            </section>
    <?php } } ?> 

   <!-- Audio Genre based videos -->
   <?php 
      if($value->video_name == 'Audio_Genre_audios'){
         
      if($home_settings->AudioGenre_audios == 1){ ?>
   <section id="iq-favorites">
         <div class="container-fluid overflow-hidden">
         <div class="row">
            
         <?php
               $parentCategories = App\AudioCategory::all();
               foreach($parentCategories as $category) {

               $audios = App\Audio::join('category_audios', 'category_audios.audio_id', '=', 'audio.id')
                                 ->where('category_id','=',$category->id)->where('active', '=', '1')
                                 ->where('active', '=', '1')
                                 ->where('status', '=', '1');
                $audios = $audios->latest('audio.created_at')->get();
               //  dd($audios);
            ?>

            <div class="col-sm-12 p-0">
            <?php 
               if (count($audios) > 0) { 
                  include('partials/home/audiocategoryloop.php');
               } 
               else { 
            ?>
               <p class="no_audio"></p>
            <?php } }?>
            </div>
             </div></div>
   </section>
   <?php } } ?>


         <!-- Latest Viewed Videos -->
         <?php
       if( $value->video_name == "latest_viewed_Videos"){
         if($home_settings->latest_viewed_Videos == 1){  ?>
            <section id="iq-favorites">
               <div class="container-fluid overflow-hidden">
                     <div class="row">
                        <div class="col-sm-12">
                           <?php include 'partials/home/latest_viewed_Videos.php'; ?>
                        </div>
                     </div>
               </div>
            </section>
    <?php } } ?> 
   
         <!-- Latest Viewed Livestream -->
   <?php
      if($value->video_name == 'latest_viewed_Livestream'){
         if($home_settings->latest_viewed_Livestream == 1){ ?>
            <section id="iq-favorites">
               <div class="container-fluid overflow-hidden">
                     <div class="row">
                        <div class="col-sm-12">
                           <?php include 'partials/home/latest_viewed_Livestream.php'; ?>
                        </div>
                     </div>
               </div>
            </section>
   <?php } }?>

            <!-- Latest Viewed Audios -->
   <?php
      if($value->video_name == 'latest_viewed_Audios'){
         if($home_settings->latest_viewed_Audios == 1){ ?>
            <section id="iq-favorites">
               <div class="container-fluid overflow-hidden">
                     <div class="row">
                        <div class="col-sm-12">
                           <?php include 'partials/home/latest_viewed_Audios.php'; ?>
                        </div>
                     </div>
               </div>
            </section>
   <?php } }?>

               <!-- Latest Viewed Episode -->
   <?php
      if($value->video_name == "latest_viewed_Episode" ){
         if($home_settings->latest_viewed_Episode == 1){ ?>
            <section id="iq-favorites">
               <div class="container-fluid overflow-hidden">
                     <div class="row">
                        <div class="col-sm-12">
                           <?php include 'partials/home/latest_viewed_Episode.php'; ?>
                        </div>
                     </div>
               </div>
            </section>
   <?php } }?>
   
   <?php 
      if($value->video_name == 'ChannelPartner'){
      
      if($home_settings->channel_partner == 1){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/ChannelPartners.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } } ?>
   <?php 
      if($value->video_name == 'ContentPartner'){
      
      if($home_settings->content_partner == 1){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/ContentPartners.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } } ?>
   <?php 
      if($value->video_name == 'live_videos'){
      
      if($home_settings->live_videos == 1){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php 
                  include('partials/home/live-videos.php'); 
                      // $parentCategories = App\LiveCategory::get();
                    
                      // foreach($parentCategories as $category) {
                      //    $live_videos = App\LiveStream::join('livecategories', 'livecategories.live_id', '=', 'live_streams.id')
                      //    ->where('livecategories.category_id','=',$category->id)
                      //    ->where('active', '=', '1')->get();
                         // ->where('status', '=', '1')
                         // if (count($live_videos) > 0) { 
                            // include('partials/home/livecategory-videos.php'); 
                  
                      //   } else { 
                           ?>
               <!-- <p class="no_video"> <?php //echo __('No Video Found');?></p> -->
               <?php
                  //    } 
                  // }
                  // dd($live_videos);
                  
                  
                  ?>
            </div>
         </div>
      </div>
   </section>
   <?php } }?>
   <?php 
      if($value->video_name == 'video_schedule'){
      
      if($home_settings->video_schedule == 1){
         if(count(@$VideoSchedules) > 0){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
            <?php include('partials/home/schedule.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } } } ?>
   <?php 
      if($value->video_name == 'videoCategories'){
      
      if($home_settings->videoCategories == 1){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/videoCategories.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } } ?>
   <?php 
      if($value->video_name == 'liveCategories'){
      
      if($home_settings->liveCategories == 1){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/liveCategories.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } } ?>
   <?php 
      if($value->video_name == 'audios'){
      
      if($home_settings->audios == 1){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/latest-audios.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } } ?>

   <?php
   if($value->video_name == 'Series_Genre'){
    
    if($home_settings->SeriesGenre == 1){ ?>
            <section id="iq-favorites">
                    <div class="container-fluid overflow-hidden">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <?php include 'partials/home/SeriesGenre.php'; ?>
                            </div>
                        </div>
                    </div>
                </section>
            <?php } } ?>
            <?php
            if($value->video_name == 'Series_Genre_videos'){

            if($home_settings->SeriesGenre_videos == 1){ ?>
                <section id="iq-tvthrillers" class="s-margin">

            <?php
               $parentCategories = App\SeriesGenre::all();
               foreach($parentCategories as $category) {

                $Episode_videos =  App\Series::select('episodes.*','series.title as series_name','series.slug as series_slug')
                ->join('series_categories', 'series_categories.series_id', '=', 'series.id')
                ->join('episodes', 'episodes.series_id', '=', 'series.id')
                ->where('series_categories.category_id','=',$category->id)
                ->where('episodes.active', '=', '1')
                ->where('series.active', '=', '1')
                ->groupBy('episodes.id')
                ->latest('episodes.created_at')
                ->get();
                
               $series = App\Series::join('series_categories', 'series_categories.series_id', '=', 'series.id')
                                 ->where('category_id','=',$category->id)->where('active', '=', '1')
                                 ->where('active', '=', '1');
                $series = $series->latest('series.created_at')->get();
                // dd($series);
            ?>

            <?php 
               if (count($series) > 0) { 
                  include('partials/home/seriescategoryloop.php');
               } 
               else { 
            ?>
               <p class="no_video"></p>
            <?php } }?>
    </section>
            <?php } } ?>


   <?php 
      if($value->video_name == 'albums'){
      
      if($home_settings->albums == 1){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/latest-albums.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } } ?>
   <!-- Artist -->
   <?php 
      if($value->video_name == 'artist'){
      
      if($home_settings->artist == 1){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/artist-videos.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } } ?>
   <?php 
      if($value->video_name == 'series'){
      
        if($home_settings->series == 1){ ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php include('partials/home/latest-series.php'); ?>
            </div>
         </div>
      </div>
   </section>
   <?php } } ?>
   <?php 
      if($value->video_name == 'featured_videos'){
      
      if ( GetTrendingVideoStatus() == 1 ) { ?>
   <section id="iq-favorites">
      <div class="container-fluid overflow-hidden">
         <div class="row">
            <div class="col-sm-12 ">
               <?php if ( count($featured_videos) > 0 ) { 
                  include('partials/home/trending-videoloop.php');
                  } else {  ?>
               <p class="no_video"> </p>
               <?php } ?>
            </div>
         </div>
      </div>
   </section>
   <?php } } ?>
 
<section id="iq-tvthrillers" class="s-margin">
   <?php 
      if($value->video_name == 'category_videos'){
           
           if ( GetCategoryVideoStatus() == 1 ) {  
                     ?>
   <div class="">
      <?php
         $Multiuser=Session('subuser_id');
         $Multiprofile= App\Multiprofile::where('id',$Multiuser)->first();
         
         $parentCategories = App\VideoCategory::where('in_home','=',1)->orderBy('order','ASC')->get();
         
         foreach($parentCategories as $category) {
         
           if( $Multiprofile != null ){
         
               if($Multiprofile->user_type == "Kids"){
             
            $videos = App\Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                                 ->where('category_id','=',$category->id)->where('active', '=', '1')
                                 ->where('category_id','=','data')
                                 ->where('status', '=', '1')
                                 ->where('draft', '=', '1')
                                 ->where('age_restrict','<',18);
         
               if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
                  $videos = $videos  ->whereNotIn('videos.id',Block_videos()); }
                  if($Family_Mode == 1){
                     $videos = $videos->where('age_restrict', '<', 18);
                 }
                 if($Kids_Mode == 1){
                     $videos = $videos->where('age_restrict', '<', 10);
                 }
                  $videos = $videos->latest('videos.created_at')->get();
                  
                  $Episode_videos =  App\Series::select('episodes.*','series.title as series_name','series.slug as series_slug')
                                 ->join('series_categories', 'series_categories.series_id', '=', 'series.id')
                                 ->join('episodes', 'episodes.series_id', '=', 'series.id')
                                 ->where('series_categories.category_id','=',$category->id)
                                 ->where('episodes.active', '=', '1')
                                 ->where('series.active', '=', '1')
                                 ->groupBy('episodes.id')
                                 ->latest('episodes.created_at')
                                 ->get();
         
               }else{
         
         $videos = App\Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                              ->where('category_id','=',$category->id)->where('active', '=', '1')
                              ->where('status', '=', '1')
                              ->where('draft', '=', '1');
         
         if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
            $videos = $videos  ->whereNotIn('videos.id',Block_videos());
            }
            if($Family_Mode == 1){
               $videos = $videos->where('age_restrict', '<', 18);
           }
           if($Kids_Mode == 1){
               $videos = $videos->where('age_restrict', '<', 10);
           }
          $videos = $videos->latest('videos.created_at')->get();
         
          $Episode_videos =  App\Series::select('episodes.*','series.title as series_name','series.slug as series_slug')
                        ->join('series_categories', 'series_categories.series_id', '=', 'series.id')
                        ->join('episodes', 'episodes.series_id', '=', 'series.id')
                        ->where('series_categories.category_id','=',$category->id)
                        ->where('episodes.active', '=', '1')
                        ->where('series.active', '=', '1')
                        ->groupBy('episodes.id')
                        ->latest('episodes.created_at')
                        ->get();
         
           } } else {
         
         
         $videos = App\Video::join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
                              ->where('category_id','=',$category->id)->where('active', '=', '1')
                              ->where('status', '=', '1')
                              ->where('draft', '=', '1');
         
         if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){
            $videos = $videos  ->whereNotIn('videos.id',Block_videos());
               }
               if($Family_Mode == 1){
                  $videos = $videos->where('age_restrict', '<', 18);
              }
              if($Kids_Mode == 1){
                  $videos = $videos->where('age_restrict', '<', 10);
              }
         $videos = $videos->latest('videos.created_at')->get();
         
         
         $Episode_videos =  App\Series::select('episodes.*','series.title as series_name','series.slug as series_slug')
                  ->join('series_categories', 'series_categories.series_id', '=', 'series.id')
                  ->join('episodes', 'episodes.series_id', '=', 'series.id')
                  ->where('series_categories.category_id','=',$category->id)
                  ->where('episodes.active', '=', '1')
                  ->where('series.active', '=', '1')
                  ->groupBy('episodes.id')
                  ->latest('episodes.created_at')
                  ->get();
         
         }
         $Episode_videos = [];
         ?>
      <?php if (count($videos) > 0 || count($Episode_videos) > 0) { 
         include('partials/category-videoloop.php');
         } else { ?>
      <p class="no_video">
         <!--<?php echo __('No Video Found');?>-->
      </p>
      <?php } ?>
      <?php }?>
   </div>
   <?php }  }  ?>
   <?php 
      if($value->video_name == 'live_category'){
           
           if ( GetCategoryLiveStatus() == 1 ) {  
                     ?>
   <div class="">
      <?php
         $Multiuser=Session('subuser_id');
         $Multiprofile= App\Multiprofile::where('id',$Multiuser)->first();
         
         $parentCategories = App\LiveCategory::orderBy('order','ASC')->groupBy('name')->get();
         // dd($parentCategories);
         foreach($parentCategories as $category) {
         
         $live_streams = App\LiveStream::join('livecategories', 'livecategories.live_id', '=', 'live_streams.id')
            ->where('category_id','=',$category->id)->where('live_streams.active', '=', '1')
            ->where('live_streams.status', '=', '1');
         
               if(Geofencing() !=null && Geofencing()->geofencing == 'ON'){

                     $BlockLiveStream = App\BlockLiveStream::where('country',$countryName)->get();
                     
                     if(!$BlockLiveStream->isEmpty()){
                        foreach($BlockLiveStream as $block_LiveStream){
                           $blockLiveStreams[]=$block_LiveStream->live_id;
                        }
                     }else{
                        $blockLiveStreams[]='';
                     }
                     $live_streams =   $live_streams->whereNotIn('live_streams.id',$blockLiveStreams);
            } 

            $live_streams = $live_streams->orderBy('live_streams.created_at','desc')->get();
         
         ?>
      <?php if (count($live_streams) > 0 ) { 
         include('partials/home/live-category.php');
         } else { ?>
      <p class="no_video">
         <!--<?php echo __('No Video Found');?>-->
      </p>
      <?php } ?>
      <?php }?>
   </div>
   <?php }  } } ?>
   <!-- Most watched Videos - category -->
   <?php
      // $parentCategories = App\VideoCategory::where('in_home','=',1)->orderBy('order','ASC')->get();
      // foreach($parentCategories as $category){
      
      // $top_category_videos = App\RecentView::select('recent_views.video_id','videos.*',DB::raw('COUNT(recent_views.video_id) AS count')) 
      // ->join('videos', 'videos.id', '=', 'recent_views.video_id')
      // ->join('categoryvideos', 'categoryvideos.video_id', '=', 'videos.id')
      // ->groupBy('recent_views.video_id')->orderByRaw('count DESC' )
      // ->where('categoryvideos.category_id','=',$category->id)
      // ->limit(20)
      // ->get();  
      ?>
   <?php //if (count($top_category_videos) > 0) { 
      // include('partials/home/most_Watched_category.blade.php');
      // } else { ?>
   <!-- <p class="no_video"> <?php echo __('No Video Found');?></p> -->
   <?php //} } ?>
</section>
</div>
<script>
   document.addEventListener("DOMContentLoaded", function() {
   var lazyloadImages = document.querySelectorAll("img.lazy");    
   var lazyloadThrottleTimeout;
   
   function lazyload () {
   if(lazyloadThrottleTimeout) {
     clearTimeout(lazyloadThrottleTimeout);
   }    
   
   lazyloadThrottleTimeout = setTimeout(function() {
       var scrollTop = window.pageYOffset;
       lazyloadImages.forEach(function(img) {
           if(img.offsetTop < (window.innerHeight + scrollTop)) {
             img.src = img.dataset.src;
             img.classList.remove('lazy');
           }
       });
       if(lazyloadImages.length == 0) { 
         document.removeEventListener("scroll", lazyload);
         window.removeEventListener("resize", lazyload);
         window.removeEventListener("orientationChange", lazyload);
       }
   }, 20);
   }
   
   document.addEventListener("scroll", lazyload);
   window.addEventListener("resize", lazyload);
   window.addEventListener("orientationChange", lazyload);
   });
   
   //  family & Kids Mode Restriction   
   
   $( document ).ready(function() {
   $('.kids_mode').click(function () {
     var kids_mode = $(this).data("custom-value");
              $.ajax({
              url: "<?php echo URL::to('/kidsMode');?>",
              type: "get",
              data:{
                 kids_mode:kids_mode, 
              },
              success: function (response) {
                 location.reload();               
              },
           });   
   });
   
   $('.family_mode').click(function () {
        var family_mode = $(this).data("custom-value");
   
              $.ajax({
              url: "<?php echo URL::to('/FamilyMode');?>",
              type: "get",
              data:{
                 family_mode:family_mode, 
              },
              success: function (response) {
                 location.reload();               
              },
           });   
   });
   
   $('.family_mode_off').click(function () {
        var family_mode = $(this).data("custom-value");
   
              $.ajax({
              url: "<?php echo URL::to('/FamilyModeOff');?>",
              type: "get",
              data:{
                 family_mode:family_mode, 
              },
              success: function (response) {
                 location.reload();               
              },
           });   
   });
   
   $('#kids_mode_off').click(function () {
     var kids_mode = $(this).data("custom-value");
              $.ajax({
              url: "<?php echo URL::to('/kidsModeOff');?>",
              type: "get",
              data:{
                 kids_mode:kids_mode, 
              },
              success: function (response) {
                 location.reload();               
              },
           });   
   });
   
   });
   
   $(".main-content , .main-header , .container-fluid").click(function(){
     $(".home-search").hide();
   });
   
</script>
<!-- Trailer -->
<?php
   include(public_path('themes/default/views/partials/home/Trailer-script.php'));
   include(public_path('themes/default/views/partials/home/home_pop_up.php'));
   ?>
<?php include('footer.blade.php');?>
<!-- End Of MainContent -->

<style>
   body{
      overflow-x:hidden;
      overflow-y:scroll;
   }
</style>