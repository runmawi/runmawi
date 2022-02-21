<?php include('header.php'); ?>
<style type="text/css">
.audio-js *, .audio-js :after, .audio-js :before {box-sizing: inherit;display: grid;}
.vjs-big-play-button{
top: 50% !important;
left: 50% !important;
margin: -25px 0 0 -25px;
width: 50px !important;
height: 50px !important;
border-radius: 25px !important;
}
.vjs-texttrack-settings { display: none; }
.audio-js .vjs-big-play-button{ border: none !important; }
.bd{border-radius: 25px!important;
background: #2bc5b4!important;}
.bd:hover{

}
    th,td {
    padding: 10px;
    color: #fff!important;
}
    tr{
        border:#141414;
    }
p{
color: #fff;
}
.fa-heart{color: red !important;}
.flexlink{
position: relative;
top: 63px;
left: -121px;
}
#ff{
border: 1px solid #fff;
border-radius: 50%;
padding: 10px;
font-size: 20px;
color: #fff;
}
li{
list-style: none; 
}
.audio-lp{
background: #000000;
padding: 33px;
border-radius: 25px;

}

.audio-lpk:hover {
background-color: #1414;
color:#fff;
border: 1px #e9ecef;
border-radius: .25rem;
border-bottom-left-radius:0;
border-bottom-right-radius:0;

}
.aud-lp{
border-bottom: 1px solid #141414;
}
.play-button {
position: absolute;
z-index: 10;
top: 46%;
left: 99px;
transform: translateY(-50%);
display: block;
padding-left: 5px;
text-align: center;
}
#circle{
border-radius: 50%;
}
/* Player Style */
.audioPlayer .jp-jplayer, #jplayer-audio-container {}
.audioPlayer .jp-controls button {text-indent: 0;}
.jp-audio, .jp-video {background: black;font-family: sans-serif;font-size: .75rem;max-width: 85rem;width: 100%;position: fixed;
    top: 85%;
    z-index: 5;margin-left: -110px;}
    .jp-btn{background-color: red;border-radius: 50%;}
.jp-type-playlist {display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;-webkit-flex-direction: column;-moz-flex-direction: column;-ms-flex-direction: column;flex-direction: column;height: 100%;}
.jp-type-playlist .jp-close {-webkit-flex-grow: 0;-moz-flex-grow: 0;-ms-flex-grow: 0;flex-grow: 0;}
.jp-type-playlist .jp-gui {-webkit-flex-grow: 0;-moz-flex-grow: 0;-ms-flex-grow: 0;flex-grow: 0;}
.jp-type-playlist .jp-playlist {-webkit-flex-grow: 1;-moz-flex-grow: 1;-ms-flex-grow: 1;flex-grow: 1;overflow-y: auto;}
.jp-btn {border: 0;padding: 0;outline: none;background: none;color: #fff;height: 1.5rem;line-height: 1.5rem;padding: 0 15px;}
.jp-gui {background: rgba(255, 255, 255, 0.05);padding: 1rem;}
.jp-gui .jp-title {display: inline-block;color: #fff;height: 1.5rem;width: 50%;text-align: right;line-height: 1.5rem;overflow: hidden;opacity: 0.5;}
.jp-gui .jp-toggles {display: inline-block;float: right;}
.jp-gui .jp-toggles .jp-repeat,
.jp-gui .jp-toggles .jp-shuffle {display: inline-block;float: left;vertical-align: top;opacity: 0.5;}
.jp-gui .jp-toggles .jp-shuffle i,.jp-gui .jp-toggles .jp-repeat i{font-size: 1.6rem;}
.jp-gui .jp-times {display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;margin-top: .5rem;}
.jp-gui .jp-times .jp-current-time,
.jp-gui .jp-times .jp-duration {-webkit-flex-grow: 1;-moz-flex-grow: 1;-ms-flex-grow: 1;flex-grow: 1;color: #fff;font-size: .6rem;opacity: 0.5;}
    ..jp-gui .jp-controls-holder .jp-controls{
        width: 40%
            margin:0 auto;
    }
.jp-gui .jp-times .jp-current-time {text-align: left;}
.jp-gui .jp-times .jp-duration {text-align: right;}
.jp-gui .jp-volume-controls {display: inline-block;float: right;}
.jp-gui .jp-volume-controls .jp-volume-max {display: none !important;}
.jp-gui .jp-volume-controls .jp-mute {display: inline-block;float: left;vertical-align: top;margin-right: -.75rem;opacity: 0.5;}
.jp-gui .jp-volume-controls .jp-volume-bar {display: none !important;float: left;vertical-align: top;width: 2.5rem;height: 2px;background: rgba(255, 255, 255, 0.5);margin: .65rem 0;}
.jp-gui .jp-volume-controls .jp-volume-bar .jp-volume-bar-value {background: #fff;height: 2px;}
.jp-gui .jp-controls-holder .jp-controls {/*padding: 1rem 0;*/display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;-webkit-align-items: center;-moz-align-items: center;-ms-align-items: center;align-items: center;width: 40%;margin: 0 auto;}
.jp-gui .jp-controls-holder .jp-controls button {-webkit-flex-grow: 1;-moz-flex-grow: 1;-ms-flex-grow: 1;flex-grow: 1;height: 2.5rem;line-height: 2.5rem;}
.jp-gui .jp-controls-holder .jp-controls button i {font-size: 1.25rem;}
.jp-gui .jp-controls-holder .jp-controls button:active i {color: #09f;}
.jp-gui .jp-controls-holder .jp-progress .jp-seek-bar {background: rgba(255, 255, 255, 0.5);height: .15rem;}
.jp-gui .jp-controls-holder .jp-progress .jp-seek-bar .jp-play-bar {background: #fff;height: .15rem;}
.jp-state-playing .jp-play i {color: #09f;}
.jp-state-playing .jp-play i:before {content: "\f04c";}
.jp-state-looped .jp-repeat {opacity: 1 !important;}
.jp-state-looped .jp-repeat i {color: #09f;}
.jp-state-shuffled .jp-shuffle {opacity: 1 !important;}
.jp-state-shuffled .jp-shuffle i {color: #09f;}
.jp-state-muted .jp-mute {opacity: 1 !important;}
.jp-state-muted .jp-mute i {color: #09f;}
.jp-playlist {background: rgba(255, 255, 255, 0);}
.jp-playlist > ul {padding: 0;margin: 0;list-style: none;}
.jp-playlist > ul > li {display: block;padding: 0 !important;}
.jp-playlist > ul > li > div > a.jp-playlist-item {display: block;padding: .75rem 1rem;outline: none;color: rgba(255, 255, 255, 0.5);}
.jp-playlist > ul > li > div > a.jp-playlist-item.jp-playlist-current {background: rgba(255, 255, 255, 0.2);color: #fff;}
.jp-playlist > ul > li:nth-child(odd) > div > a {background: rgba(255, 255, 255, 0.1);}
.jp-gui button {background: transparent;color: #fff;border: 0;}
.jp-interface {-webkit-align-content: center;-ms-align-content: center;align-content: center;-webkit-align-items: center;-ms-align-items: center;align-items: center;display: table;display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-flex-wrap: wrap;-ms-flex-wrap: wrap;flex-wrap: wrap;justify-content: space-between;width: 100%;}
.jp-gui .jp-toggles {-webkit-align-content: center;-ms-align-content: center;align-content: center;-webkit-align-items: center;-ms-align-items: center;align-items: center;display: table;display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-flex-wrap: wrap;-ms-flex-wrap: wrap;flex-wrap: wrap;width: 100%;}
.jp-controls-holder, .jp-progress {width: 100%;}
.jp-seek-bar {background: rgba(255, 255, 255, 0.5);height: .15rem;}
.jp-play-bar {background-color: #fff;height: 100%;}
.jp-gui .jp-toggles button + button {margin-left: .3rem;}
#jp_video {height: auto !important;position: relative;padding-bottom: 54.3%;width: 100% !important;}
#jp_video > * {height: 100% !important;-webkit-object-fit: cover;-ms-object-fit: cover;object-fit: cover;position: absolute;width: 100% !important;}
.sectionContainer {padding: 3.75rem 0;}
.sectionContainer + .sectionContainer {border-top: .1rem solid #fff;}
.sectionContainer:nth-child(odd) {background-color: rgba(255, 255, 255, 0.1);}
.crow {display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-flex-wrap: wrap;-ms-flex-wrap: wrap;flex-wrap: wrap;margin: 0 -15px;}
.chalf {padding: 15px;width: 50%;}
@media only screen and (max-width: 991px) {
    html, body {font-size: 16px;}
    .chalf {width: 100%;}
}
</style>

<div class="container mt-4 audio-list-page">

       <div class="block-space">
           <div class="row">
              <div class="col-sm-12 overflow-hidden">
                 <div class="iq-main-header d-flex align-items-center justify-content-between">
                    <?php if(isset($page_title)): ?>
                    <!-- <h4 class="main-title" style = "color:white;">Audio</h4> -->
                    <!-- <a href="#" class="text-primary">View all</a> -->
                    <?php endif; ?> 
                 </div>
              </div>
           </div>
        </div>
		<div class="row nomargin">
        <?php if(isset($audios_category)) :
foreach($audios_category as $audio): ?>
<div class="iq-main-header col-md-3 d-flex align-items-center justify-content-between">
    <div class="favorites-contens">           
        <div class="epi-box">
            <div class="epi-img position-relative">
               <img src="<?php echo URL::to('/').'/public/uploads/images/'.$audio->image;?>" class="img-fluid img-zoom" alt="">
               <div class="episode-play-info">
                  <div class="episode-play">
                     <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                        <i class="ri-play-fill"></i>
                     </a>
                  </div>
               </div>
            </div>
            <div class="epi-desc p-3"> 
               <a href="<?= URL::to('audio') ?><?= '/' . $audio->slug ?>">
                  <h6 class="epi-name text-white mb-0"><?php echo $audio->title; ?></h6>
               </a>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-white"><small><?php echo get_audio_artist($audio->id); ?></small></span>
                    <span class="text-primary"><small><?php echo gmdate('H:i:s', $audio->duration); ?>m</small></span>
               </div>
            </div>
        </div>
    </div>
</div>


<?php endforeach; 
endif; ?>
			
		</div>
      <?php //if($audios_count > 0){   include('partials/pagination.php'); }else{} ?>

</div>
<?php include('footer.blade.php'); ?>
