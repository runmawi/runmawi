<?php include 'header.php'; ?>
<?php
$ads_details = App\AdsVideo::join(
    "advertisements",
    "advertisements.id",
    "ads_videos.ads_id"
)
    ->where("ads_videos.video_id", $first_videos->id)
    ->pluck("ads_path")
    ->first();

$default_ads_url = App\Setting::pluck("default_ads_url")->first();
$default_ads_status = App\Video::where("id", $first_videos->id)
    ->pluck("default_ads")
    ->first();

if ($default_ads_url != null && $default_ads_status == 1) {
    $default_ads = $default_ads_url;
} else {
    $default_ads = null;
}

if ($ads_details != null) {
    $ads_path = $ads_details;
} else {
    $ads_path = $default_ads;
}


$autoplay =  "autoplay" ;
?>
@extends('Adstagurl.php')

<?php
$str = $first_videos->m3u8_url;
if (!empty($str)) {
    $request_url = "m3u8";
    // dd($first_videos->m3u8);
}
if (!empty($request_url)) { ?>
<input type="hidden" id="request_url" name="request_url" value="<?php echo $request_url; ?>">
<?php }
?>

<input type="hidden" name="ads_path" id="ads_path" value="<?php echo $ads_path; ?>">

<input type="hidden" name="video_id" id="video_id" value="<?php echo $first_videos->id; ?>">
<!-- <input type="hidden" name="logo_path" id='logo_path' value="{{ URL::to('/') . '/public/uploads/settings/' . $playerui_settings->watermark }}"> -->
<input type="hidden" name="logo_path" id='logo_path' value="<?php echo $playerui_settings->watermark_logo; ?>">
<input type="hidden" name="video_title" id="video_title" value="<?php echo $first_videos->title; ?>">

  <input type="hidden" name="current_time" id="current_time" value="<?php if (
      isset($watched_time)
  ) {
      echo $watched_time;
  } else {
      echo "0";
  } ?>">
  <input type="hidden" id="videoslug" value="<?php if (isset($first_videos->slug)) {
      echo $first_videos->slug;
  } else {
      echo "0";
  } ?>">
  <input type="hidden" id="base_url" value="<?php echo URL::to("/"); ?>">
  <input type="hidden" id="video_type" value="<?php echo $first_videos->type; ?>">
  <input type="hidden" id="video_video" value="video">
  <input type="hidden" id="adsurl" value="<?php if (isset($ads->ads_id)) {
      echo get_adurl($ads->ads_id);
  } ?>">
  <style>
       .plyr__video-embed{
          position: relative;
      }
    .vjs-error .vjs-error-display .vjs-modal-dialog-content {
   font-size: 2.4em;
   text-align: center;
   padding-top: 20%; 
}
.vjs-seek-to-live-control {
           display: none !important;
       }

input.skips,input#Recaps_Skip{
  background-color: #21252952;
    color: white;
    padding: 15px 32px;
    text-align: center;
    margin: 4px 2px;
}
      .bg-border{
         
          
      }
#intro_skip{
	display: none;
}
#Auto_skip{
	display: none;
}
div#url_linkdetails {
    position: absolute;
    top: 22%;
    left: 10%;
    font-size: x-large;
  
}
   .intro_skips,.Recap_skip {
   position: absolute;
       z-index: 5;
       top: 60%;
       right: 0;
       display: flex;
       justify-content: flex-end;
   
        
}
      .skips{
          position: absolute;
          top:-20%;
      }
 .end_card_video {
    position: absolute;
    top: -19%;
    left: 79%;
     
} 
       .video-list {padding: 10px;
  
}
      li.slide-item{
         padding: 5px 5px!important; 
      }
.video-list::-webkit-scrollbar-track {
  background: #CFD8DC;
}
.video-list::-webkit-scrollbar-thumb {
  background-color: rgb(0, 82, 204) ;
  border-radius: 6px;
  border: 3px solid var(--scrollbarBG);
}
.video-list{
   
   
}
      .plyr audio, .plyr iframe, .plyr video{
          background-color: #141414;
      }
      .video-list{
      
          
      }

.countdown {
  text-align: center;
  font-size: 60px;
  margin-top: 0px;
  color:red;
}
h2{
  text-align: center;
  font-size: 60px;
  margin-top: 0px;
}
#end_card_video{
  /* end_card_video */
	display: none;
}
      .modal-header {
          padding: 10px!important;
          
      }.modal-title{
          color: #000;
          font-weight: 700;
font-size: 24px!important;
line-height: 33px;
          
      }
      label{
          font-size: 18px;
line-height: 21px;
          padding-left: 5px;
          color: #000;
      }
      .modal-body{
           border-top: 1px solid rgba(0, 0, 0, 0.2)!important;
          border:none;
      }
       .modal-footer {
       
           border-top: 1px solid rgba(0, 0, 0, 0.2)!important;
            border:none;
      }
      .badge-secondary{
          color: #000;
       background: #F1F1F1;
          border-radius: 5px;
          font-weight: 700;
font-size: 12px;
line-height: 10px;
      }
      .modal-body a{
          font-weight: 400;
font-size: 20px;
line-height:30px;
          color: #000!important;
      }
      .movie{
          font-weight: 700;
font-size: 30px!important;
line-height: 38px;
      }
#intro_skip{
	display: none;
}
      .button.close{
          color: red;
      }
#Auto_skip{
	display: none;
}
      .modal-content{
          background-color: #fff;
          border: 1px solid #F1F1F1;
box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
border-radius: 20px;
          padding: 20px;

      }
      .modal-dialog{
          max-width:695px!important;
      }
      .modal {
          top:2%;
      }
      .btn2{
          padding: 13px 45px!important;
          font-weight: 400;
    
  border: 1px solid;
   
   
      }

                 /* <!-- BREADCRUMBS  */

    .bc-icons-2 .breadcrumb-item + .breadcrumb-item::before {
      content: none; 
    } 

    ol.breadcrumb {
        color: white;
        background-color: transparent !important  ;
        font-size: revert;
    }
    
  </style>

     <div class="row m-0 p-0 mb-5">
         <div class="col-lg-8">
             <div class="page-height">
                <div class="video_playlist_content">

<?php if ($first_videos->type == "embed"): ?>
           <div id="video_container" class="fitvid">
             <?php if (!empty($first_videos->embed_code)) { ?>
              <div class="plyr__video-embed" id="player">
            <iframe
              src="<?php if (!empty($first_videos->embed_code)) {
                  echo $first_videos->embed_code;
              } else {
                  echo $first_videos->trailer;
              } ?>"
              allowfullscreen
              allowtransparency
              allow="<?= $autoplay ?>"
            ></iframe>
          </div>
             <?php } ?>
           </div>
           <?php elseif ($first_videos->type == ""): ?>
          <div id="video_container" class="fitvid" atyle="z-index: 9999;">


          <video  <?= $autoplay ?> id="video"  allow="<?= $autoplay ?>" class="adstime_url" poster="<?= URL::to(
    "/"
) .
    "/public/uploads/images/" .
    $first_videos->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
          <source src="<?php echo URL::to("/storage/app/public/") .
              "/" .
              $first_videos->path .
              ".m3u8"; ?>"  type='application/x-mpegURL' label='auto' > 
  <?php if (@$playerui_settings["subtitle"] == 1) {
      if (isset($subtitles)) {
          foreach ($subtitles as $key => $subtitles_file) { ?>
                    <track kind="captions" src="<?= $subtitles_file->url ?>"
                        srclang="<?= $subtitles_file->sub_language ?>"
                        label="<?= $subtitles_file->shortcode ?>" default>
                    <?php }
      }
  } ?>
</video>

  <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo URL::to(
      "/storage/app/public/"
  ) .
      "/" .
      $first_videos->path .
      ".m3u8"; ?>">

</div>
  
           <?php elseif ($first_videos->type == "aws_m3u8"): ?>
          <div id="video_container" class="fitvid" atyle="z-index: 9999;">

          <video  <?= $autoplay ?> id="video"  allow="<?= $autoplay ?>" class="adstime_url" poster="<?= URL::to(
    "/"
) .
    "/public/uploads/images/" .
    $first_videos->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
          <source src="<?php echo $first_videos->m3u8_url; ?>"  type='application/x-mpegURL' label='auto' > 
          <?php if (@$playerui_settings["subtitle"] == 1) {
              if (isset($subtitles)) {
                  foreach ($subtitles as $key => $subtitles_file) { ?>
                    <track kind="captions" src="<?= $subtitles_file->url ?>"
                        srclang="<?= $subtitles_file->sub_language ?>"
                        label="<?= $subtitles_file->shortcode ?>" default>
                    <?php }
              }
          } ?>
        </video>
        </div>
           <?php elseif ($first_videos->type == "mp4_url"): ?>
           
             
                 <div id="video_container" class="fitvid" atyle="z-index: 9999;">
               <video id="videoPlayer"  class="adstime_url" poster="<?= URL::to(
                   "/"
               ) .
                   "/public/uploads/images/" .
                   $first_videos->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'  type="video/mp4" >
                   <source src="<?php if (!empty($first_videos->mp4_url)) {
                       echo $first_videos->mp4_url;
                   } else {
                       echo $first_videos->trailer;
                   } ?>"  type='video/mp4' label='auto' > 
                
                   <?php if (@$playerui_settings["subtitle"] == 1) {
                       if (isset($subtitles)) {
                           foreach ($subtitles as $key => $subtitles_file) { ?>
                    <track kind="captions" src="<?= $subtitles_file->url ?>"
                        srclang="<?= $subtitles_file->sub_language ?>"
                        label="<?= $subtitles_file->shortcode ?>" default>
                    <?php }
                       }
                   } ?>
               </video>
 
            
           </div>
           <?php elseif ($first_videos->type == "m3u8_url"): ?>
        
        <video  <?= $autoplay ?> id="video" <?= $autoplay ?> class="adstime_url" poster="<?= URL::to(
     "/"
 ) .
     "/public/uploads/images/" .
     $first_videos->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
                <source src="<?php if (!empty($first_videos->m3u8_url)) {
                    echo $first_videos->m3u8_url;
                } else {
                    echo $first_videos->trailer;
                } ?>"  type='application/x-mpegURL' label='auto' > 
                <?php if (@$playerui_settings["subtitle"] == 1) {
                    if (isset($subtitles)) {
                        foreach ($subtitles as $key => $subtitles_file) { ?>
                    <track kind="captions" src="<?= $subtitles_file->url ?>"
                        srclang="<?= $subtitles_file->sub_language ?>"
                        label="<?= $subtitles_file->shortcode ?>" default>
                    <?php }
                    }
                } ?>
            </video>
   <?php else: ?>
               <div id="video_container" class="fitvid" atyle="z-index: 9999;">
               <video  id="videoPlayer" class="adstime_url" poster="<?= URL::to(
                   "/"
               ) .
                   "/public/uploads/images/" .
                   $first_videos->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'   type="video/mp4" >
                   <source src="<?php if (!empty($first_videos->m3u8_url)) {
                       echo $first_videos->m3u8_url;
                   } else {
                       echo $first_videos->trailer;
                   } ?>"  type='application/x-mpegURL' label='auto' > 
                   <?php if (@$playerui_settings["subtitle"] == 1) {
                       if (isset($subtitles)) {
                           foreach ($subtitles as $key => $subtitles_file) { ?>
                    <track kind="captions" src="<?= $subtitles_file->url ?>"
                        srclang="<?= $subtitles_file->sub_language ?>"
                        label="<?= $subtitles_file->shortcode ?>" default>
                    <?php }
                       }
                   } ?>
               </video>
 
            
           </div>
   <?php endif; ?>
   </div>

   </div>
   </div>
         <div class="col-lg-4">
             <div class="container-fluid video-list   overflow-hidden">
        <h4 class="Continue Watching" style="color:#fffff;"><?php echo __("Playlist Videos"); ?></h4>
            <div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "<?= $autoplay ?>": false}'>   
                <?php include "partials/video-playlist.php"; ?>
            </div>
    </div>
         </div>
   </div>
   
    <?php include 'footer.blade.php'; ?>
