<?php include('header.php');?>
  <link href="<?php echo URL::to('/').'/assets/dist/videojs-watermark.css';?>" rel="stylesheet">
<link href="<?php echo URL::to('/').'/assets/dist/videojs-resolution-switcher.css';?>" rel="stylesheet">
<link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/videojs-seek-buttons/dist/videojs-seek-buttons.css" rel="stylesheet">
 
<!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
<script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-seek-buttons/dist/videojs-seek-buttons.min.js"></script>

       <style>
         
           .video-js{height: 500px !important;}
.video-js *, .video-js :after, .video-js :before {box-sizing: inherit;display: grid;}
.vjs-big-play-button{
top: 50% !important;
left: 50% !important;
margin: -25px 0 0 -25px;
width: 50px !important;
height: 50px !important;
border-radius: 25px !important;
}
.social_share {
display: inline-block !important;
border-radius: 5px !important;
vertical-align: middle !important;
}
.rrssb-buttons.tiny-format li {
padding-right: 7px;
}
.rrssb-buttons li {
float: left;
height: 100%;
line-height: 13px;
list-style: none;
margin: 0;
padding: 0 2.5px;
}
.video-details {
margin: 0 auto !important;
padding-bottom: 30px !important;
padding-left: 40px !important;
}
.social_share p {
display: inline-block;
font-weight: 700;
font-family: 'Roboto', sans-serif;
font-size: 16px;
}
#social_share {
display: inline-block;
vertical-align: middle;
}
#video_title h1 {
color: #fff;
font-size: 30px;
margin: 20px 0px;
line-height: 22px;
}
.btn.watchlater, .btn.mywishlist {
font-weight: 600;
font-family: 'Roboto', sans-serif;
font-size: 15px;
background: #000;
border: 1px solid #000;
color: #fff;
}
a.ytp-impression-link {
display: none !important;
}
.ytp-impression-link {
display: none !important;
}
.vjs-texttrack-settings { display: none; }
.video-js .vjs-big-play-button{ border: none !important; }
#video_container{height: auto;padding-top: 120px !important;;width: 95%;margin: 0 auto;}
/*    #video_bg_dim {background: #1a1b20;}*/
.video-js .vjs-tech {outline: none;}
.video-details h1{margin: 0 0 10px;color: #fff;}
.vid-details{margin-bottom: 20px;}
#tags{margin-bottom: 10px;}
.share{display: flex;align-items: center;}
.share span, .share a{display: inline-block;text-align: center;font-size: 20px;padding-right: 20px;color: #fff;}
.share a{padding: 0 20px;}
.cat-name span{margin-right: 10px;}
.video-js .vjs-seek-button.skip-back.skip-10::before,
.video-js.vjs-v6 .vjs-seek-button.skip-back.skip-10 .vjs-icon-placeholder::before,
.video-js.vjs-v7 .vjs-seek-button.skip-back.skip-10 .vjs-icon-placeholder::before {
content: '\e059'
}
.btn.btn-default.views {
color: #fff !important;
}
           
.vjs-skin-hotdog-stand { color: #FF0000; }
.vjs-skin-hotdog-stand .vjs-control-bar { background: #FFFF00; }
.vjs-skin-hotdog-stand .vjs-play-progress { background: #FF0000; }
.rent-card{
width: 120% !important;
height: 30px !important;
}
           .overflow-hidden {
    margin-top: 70px;
    overflow: hidden;
    min-height: 450px !important;
}
           /* scroller */
.scroller { overflow-y: auto; scrollbar-color: var(--iq-primary) var(--iq-light-primary); scrollbar-width: thin; }
.scroller::-webkit-scrollbar-thumb { background-color: var(--iq-primary); }
.scroller::-webkit-scrollbar-track { background-color: var(--iq-light-primary); }
#sidebar-scrollbar { overflow-y: auto; scrollbar-color: var(--iq-primary) var(--iq-light-primary); scrollbar-width: thin; }
#sidebar-scrollbar::-webkit-scrollbar-thumb { background-color: var(--iq-primary); }
/*#sidebar-scrollbar { height: calc(100vh - 153px) !important; }*/
#sidebar-scrollbar::-webkit-scrollbar-track { background-color: var(--iq-light-primary); }
::-webkit-scrollbar { width: 8px; height: 8px; border-radius: 5px; }
           
            li.slide-item .block-images{
         margin-bottom: 2rem !important;
     }
            .thumb-cont{
         position: fixed;
	z-index: 1040;
	height: 521px !important;
    width: 100% !important;
    margin-top: 80px !important;
    opacity: none;
}
            li.list-group-item a:hover{
             color: var(--iq-primary) !important;
         }
     .modal-backdrop.show {
    opacity: 0 !important;
         visibility: hidden;
}
     .modal-backdrop {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1;
    background-color: #000;
}
     .img-black-back:before {
    content: "";
    position: absolute;
    /* z-index: 10; */
    background-image: linear-gradient(
90deg
,#000,transparent);
    width: 90%;
    height: 521px !important;
}
    .btn.btn-danger.closewin {
    margin-right: -17px;
        background-color: #4895d1 !important;
}
     .tab-pane {
    color: #ffff;
    display: none;
    padding: 50px;
    text-align: left;
    height: 410px !important;
}
             li.list-group-item {
              background-color: transparent !important;
               padding-right: unset !important;
}
           li.list-group-item a{
              background: transparent !important;
               color: var(--iq-body-text) !important;
               font-size: 12px !important;
               padding-left: 10px !important;
               
}
           .search_content{
                           top: 85px !important;
                           width: 400px !important;
                           margin-right: -15px !important;
                           
                          }
                           ul.list-group {
                    text-align: left !important;
                               max-height: 450px !important;
                }
           li.list-group-item {
    width: 375px;
}
           h3 {
    font-size: 24px !important;
}
           .playvid {
    display: block;
    width: 280%;
    height: auto !important;
    margin-left: -410px;
}
            .btn.btn-primary.close {
    margin-right: -17px;
        background-color: #4895d1 !important;
}
           button.close {
            padding: 9px 30px !important;   
            border: 0;
           -webkit-appearance: none;
}
           .close{
               margin-right: -429px !important;
    margin-top: -1132px !important;
           }
           .modal-footer {
    border-bottom: 0px !important;
                border-top: 0px !important;
   
}
        .p-tag{
    color: #000000!important;
    position: absolute;
    top: 8px;
    left: 22px!important;
    background-color: #00a8e1;
    padding: 5px;
    font-size: 12px;
    border: 3px solid #000000;
    border-radius: 3px;
    font-family: "HelveticaNeue-CondensedBold", "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
    font-weight: 700;
    border-top: none;
    border-left: none;
       
    border-bottom-right-radius: 15px;
   
   
}

       </style>
  

       <!-- Header -->
    
      <!-- Header End -->

<?php if(!empty($data['password_hash'])) { $id = Auth::user()->id ; } else { $id = 0 ; } ?>
            
         <section id="iq-favorites">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12 overflow-hidden">
                     <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <!--<h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Latest Videos</a></h4> -->                     
                     </div>
                     

                     <div class="favorites-contens">
                        <ul class="category-page list-inline  row p-0 mb-0">
                                     <?php  if(isset($lang_videos)) {
			foreach($lang_videos as $watchlater_video): ?>
                           <li class="slide-item col-sm-2 col-md-2 col-xs-12 margin-bottom-30">
                              <a href="<?php echo URL::to('home') ?>">
                                 <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt="">
                                         <div class="corner-text-wrapper">
        <div class="corner-text">
         <p class="p-tag" style="">FREE!</p>
          </div>
    </div>
                                    </div>
                                    <div class="block-description">
                                        <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                                       <h6><?php echo __($watchlater_video->title); ?></h6>
                                        </a>
                                       <div class="movie-time d-flex align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2">13+</div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                       </div>
                                       <div class="hover-buttons ">
                                             <a type="button" class="text-white" data-toggle="modal" data-target=".bd-example-modal-xl<?= $watchlater_video->id;?>">
                                          <span class=" ">
                                          <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                          Watch Now
                                          </span>
                                              </a>
                                           <div >
                                           <!-- <a   href="" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist
                       </a> -->
                       <!-- <span style="color: white;"class="mywishlist <?php //if(isset($mywishlisted->id)): ?>active<?php// endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $watchlater_video->id ?>">
                            <i style="" <?php// if(isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php //else: ?> class="ri-heart-line " <?php// endif; ?> style="" ></i>
                          </span>
              
                          <div style="color:white;" id="<?= $watchlater_video->id ?>"><?php //if(@$watchlater_video->mywishlisted->user_id == $id && @$watchlater_video->mywishlisted->video_id == $watchlater_video->id  ) { echo "Remove From Wishlist"; } else { echo "Add To Wishlist" ; } ?></div> 
                              </div> -->
                      </div>
                                       </div>
                                        <!--<div>
                                            <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $watchlater_video->id;?>">
                                                <span class="text-center thumbarrow-sec">
                                                    <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                                </span>
                                                    </button></div>-->
                                        </div>
                                  <!--  <div class="block-social-info">
                                       <ul class="list-inline p-0 m-0 music-play-lists">
                                          <li><span><i class="ri-volume-mute-fill"></i></span></li>
                                          <li><span><i class="ri-heart-fill"></i></span></li>
                                          <li><span><i class="ri-add-line"></i></span></li>
                                       </ul>
                                    </div>-->
                                 </div>
                              </a>
                           </li>
                           
                            <?php endforeach; 
		                                  }else{
                                        echo "No Video ";
                                      } ?>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
               <?php /* if(isset($lang_videos)) :
                                foreach($lang_videos as $watchlater_video): ?>
              <div class="modal fade bd-example-modal-xl<?= $watchlater_video->id;?>"  id="vidModal"   tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                 
  <div class="modal-dialog modal-xl" role="document">
        
       
    <div class="modal-content" style="background-color: transparent !important;">
       
         
          <div class="modal-body playvid">
                             <?php if($watchlater_video->type == 'embed'): ?>
                                        <div id="video_container" class="fitvid">
                                            <?= $watchlater_video->embed_code ?>
                                        </div>
                                    <?php  elseif($watchlater_video->type == 'file'): ?>
                                        <div id="video_container" class="fitvid">
                                        <video id="videojs-seek-buttons-player"  onplay="playstart()"  class="video-js vjs-default-skin" controls preload="auto" poster="<?= URL::to('/public/') . '/uploads/images/' . $watchlater_video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

                                            <source src="<?= $watchlater_video->trailer; ?>" type='video/mp4' label='auto' >
                                            <!--<source src="<?php echo URL::to('/storage/app/public/').'/'.$watchlater_video->webm_url; ?>" type='video/webm' label='auto' >
                                            <source src="<?php echo URL::to('/storage/app/public/').'/'.$watchlater_video->ogg_url; ?>" type='video/ogg' label='auto' >-->

                                            <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                                        </video>
                                        <div class="playertextbox hide">
                                        <h2>Up Next</h2>
                                        <p><?php if(isset($videonext)){ ?>
                                        <?= $watchlater_video::where('id','=',$videonext->id)->pluck('title'); ?>
                                        <?php }elseif(isset($videoprev)){ ?>
                                        <?= Video::where('id','=',$videoprev->id)->pluck('title'); ?>
                                        <?php } ?>

                                        <?php if(isset($videos_category_next)){ ?>
                                        <?= Video::where('id','=',$videos_category_next->id)->pluck('title');  ?>
                                        <?php }elseif(isset($videos_category_prev)){ ?>
                                        <?= Video::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
                                        <?php } ?></p>
                                        </div>
                                        </div>
                                    <?php  else: ?>
                                        <div id="video_container" class="fitvid" atyle="z-index: 9999;">
                                        <video id="videojs-seek-buttons-player" onplay="playstart()" class="video-js vjs-default-skin" controls preload="auto" poster="<?= Config::get('site.uploads_url') . '/images/' . $watchlater_video->image ?>"  data-setup='{ "playbackRates": [0.5, 1, 1.5, 2] }' width="100%" style="width:100%;" data-authenticated="<?= !Auth::guest() ?>">

                                        <source src="<?= $watchlater_video->trailer; ?>" type='video/mp4' label='auto' >

                                        </video>


                                        <div class="playertextbox hide">
                                        <h2>Up Next</h2>
                                        <p><?php if(isset($videonext)){ ?>
                                        <?= Video::where('id','=',$videonext->id)->pluck('title'); ?>
                                        <?php }elseif(isset($videoprev)){ ?>
                                        <?= Video::where('id','=',$videoprev->id)->pluck('title'); ?>
                                        <?php } ?>

                                        <?php if(isset($videos_category_next)){ ?>
                                        <?= Video::where('id','=',$videos_category_next->id)->pluck('title');  ?>
                                        <?php }elseif(isset($videos_category_prev)){ ?>
                                        <?= Video::where('id','=',$videos_category_prev->id)->pluck('title');  ?>
                                        <?php } ?></p>
                                        </div>
                                        </div>
                             <?php endif; ?>
                        </div>
        <div class="modal-footer" align="center" >
                <button type="button"   class="close btn btn-primary" data-dismiss="modal" aria-hidden="true" 
 onclick="document.getElementById('videojs-seek-buttons-player').pause();" id="<?= $watchlater_video->id;?>"  ><span aria-hidden="true">X</span></button>
                  
                    </div>
         
  </div>
                  </div></div>
              <?php endforeach; 
endif; */?>
             
         
                                  <?php  if(isset($lang_videos)) {
			foreach($lang_videos as $watchlater_video): ?>
                                <div class="modal fade thumb-cont" id="myModal<?= $watchlater_video->id;?>"  style="background:url('<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>') no-repeat;background-size: cover;"> 
                                    <div class="img-black-back">
                                    </div>
                                    <div align="right">
                                    <button type="button" class="closewin btn btn-danger" id="<?= $watchlater_video->id;?>"><span aria-hidden="true">X</span></button>
                                       <!-- <a type="button" class="btn btn-danger closewin"  href="<?php echo URL::to('latest-videos') ?>"><span aria-hidden="true">X</span></a>-->
                                        </div>
                                <div class="tab-sec">
                                    <div class="tab-content">
                                    <div id="overview<?= $watchlater_video->id;?>" class="container tab-pane active"><br>
                                           <h1 class="movie-title-thumb"><?php echo __($watchlater_video->title); ?></h1>
                                                   <p class="movie-rating">
                                                    <span class="thumb-star-rate"><i class="fa fa-star fa-w-18"></i><?= $watchlater_video->rating;?></span>
                                                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $watchlater_video->views;?>)</span>
                                                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                                    </p>
                                                  <p>Welcome</p>
                                           	
                                                       <!-- <div class="btn btn-danger btn-right-space br-0">
                                                    <i class="fa fa-play flexlink" aria-hidden="true"></i> Play
                                                </div>-->
                                        <a class="btn btn-hover"  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>"><i class="fa fa-play mr-2"
                                 aria-hidden="true"></i>Play Now</a>
                                    </div>
        <div id="trailer<?= $watchlater_video->id;?>" class="container tab-pane "><br>

         <div class="block expand">
		
		<a class="block-thumbnail-trail" href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" >

		
				<?php if (!empty($watchlater_video->trailer)) { ?>
                        <video class="trail-vid" width="30%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" data-play="hover" muted="muted">
                                    <source src="<?= $watchlater_video->trailer; ?>" type="video/mp4">
								 </video>
                            <?php } else { ?>
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="thumb-img">
			
		                   <?php } ?>  
			            <div class="play-button-trail" >
				
<!--			<a  href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">	
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
				</div></a>-->
                <div class="detail-block">
<!--					<a class="title-dec" href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                <p class="movie-title"><?php echo __($watchlater_video->title); ?></p>
					</a>-->
					
                <!--<p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $watchlater_video->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $watchlater_video->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
					</p>-->

				</div>
		</div>
		</a>
		<div class="block-contents">
			<!--<p class="movie-title padding"><?php echo __($watchlater_video->title); ?></p>-->
        </div>
	</div> 
	            
    </div>
    <div id="like<?= $watchlater_video->id;?>" class="container tab-pane "><br>
     
           <h2>More Like This</h2>
    </div>
     <div id="details<?= $watchlater_video->id;?>" class="container tab-pane "><br>
        <h2>Description</h2>

    </div>
	</div>
    <div align="center">
            <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#overview<?= $watchlater_video->id;?>">OVERVIEW</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#trailer<?= $watchlater_video->id;?>">TRAILER AND MORE</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#like<?= $watchlater_video->id;?>">MORE LIKE THIS</a>
                    </li>
                     <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#details<?= $watchlater_video->id;?>">DETAILS </a>           
                    </li>
              </ul>
        </div>


	
	</div></div>

<?php endforeach; 
}else{
  echo "No Video ";
} ?>
</section>
<!--End Of MainContent-->
<script type="text/javascript">
    $(document).ready(function(){
      $('.bd-example-modal-xl<?php  if(empty($watchlater_video->id)){ echo "No Videos Found" ; }else{ echo $watchlater_video->id; };?>').modal({
          show: false
      }).on('hidden.bs.modal', function(){
          $(this).find('video')[0].pause();
      });
    });
</script>
<script>
function about(evt , id) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    
  }
	
  document.getElementById(id).style.display = "block";
 
}
// Get the element with id="defaultOpen" and click on it
//document.getElementById("defaultOpen").click();
</script>
 
 <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>-->
 <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->


    <div style="height: 10px;"></div>

<!--<script type="text/javascript">

        $(document).ready(function() { 
            $(".play-video").hover(function() { 
                $(this).css("display", "block"); 
            }, function() { 
             //$(this).css("display", "none"); 
                 $(".play-video").load(); 
            }); 
            
          $( ".play-video" ).mouseleave(function() {
            $(this).load(); 
        });
         
            
            
        }); 
    </script> -->
<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>

<!--<script>
    $(".slider").slick({
 
  // normal options...
  infinite: false,
 
  // the magic
  responsive: [{
 
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        infinite: true
      }
 
    }, {
 
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        dots: true
      }
 
    }, {
 
      breakpoint: 300,
      settings: "unslick" // destroys slick
 
    }]
});

  //My Wishlist
    $('.mywishlist').click(function(){
      if($(this).data('authenticated')){
        var getid = $(this).data('url');
        if(getid == 'video'){
          id = 'video_id';
        } else if(getid == 'play_movie'){
          id = 'movie_id';
        }else if(getid == 'episodes'){
          id = 'episode_id';
        }
        var data = {   _token: '<?= csrf_token(); ?>' };
        data[id] = $(this).data('videoid');
        $.post('<?php URL::to('/') ?>mywishlist', data, function(data){});
        $(this).toggleClass('active');
        $(this).html("");
        if($(this).hasClass('active')){
          $(this).html('<a><i class="fa fa-check"></i>Wishlisted</a>');
        }else{
          $(this).html('<a><i class="fa fa-plus"></i>Add Wishlist</a>');
        }

      } else {
        window.location = '<?php URL::to('/') ?>signup';
      }
    });


    var $myGroup = $('.video-list');

    $myGroup.on('show.bs.collapse','.collapse', function() {
      $myGroup.find('.in').collapse('hide');
    }).on('hidden.bs.collapse', function (e) {

    });

/*    $('.new-art').hover(function(){
      var movie_id = $(this).attr('data-id');
      $('.new-art').removeClass('active');
      $(this).addClass('active');
      $(".block-overlap").css('display','none');
      $(".block-class_"+movie_id).css('display','block');
    }); */
</script>-->
<script>
$('.mywishlist').click(function(){
     var video_id = $(this).data('videoid');
        if($(this).data('authenticated')){
            $(this).toggleClass('active');
            if($(this).hasClass('active')){
                    $.ajax({
                        url: "<?php echo URL::to('/mywishlist');?>",
                        type: "POST",
                        data: { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>'},
                        dataType: "html",
                        success: function(data) {
                          if(data == "Added To Wishlist"){
                            $(this).html('<i class="ri-heart-fill"></i>');                            
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Remove From Wishlist');
                            $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to wishlist</div>');
                          setTimeout(function() {
                            $('.add_watch').slideUp('fast');
                          }, 3000);
                          }else{
                            $(this).html('<i class="ri-heart-line"></i>');
                            $('#'+video_id).text('') ;
                            $('#'+video_id).text('Add To Wishlist');
                            $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Media removed from wishlist</div>');
                          setTimeout(function() {
                          $('.remove_watch').slideUp('fast');
                          }, 3000);
                          }               
                    }
                });
            }                
        } else {
          window.location = '<?= URL::to('login') ?>';
      }
  });

</script>
 <script type="text/javascript">
  $(document).ready(function () {
    $('.searches').on('keyup',function() {
      var query = $(this).val();
      //alert(query);
      // alert(query);
       if (query !=''){
      $.ajax({
        url:"<?php echo URL::to('/search');?>",
        type:"GET",
        data:{
          'country':query}
        ,
        success:function (data) {
          $('.search_list').html(data);
        }
      }
            )
       } else {
            $('.search_list').html("");
       }
    }
                     );
    $(document).on('click', 'li', function(){
      var value = $(this).text();
      $('.search').val(value);
      $('.search_list').html("");
    }
                  );
  }
                   );
</script>
<script src="<?= THEME_URL . '/assets/js/rrssb.min.js'; ?>"></script>
	<script src="<?= THEME_URL . '/assets/js/videojs-resolution-switcher.js';?>"></script>
<script>
     var player = videojs('video_player').videoJsResolutionSwitcher({
        default: '480p', // Default resolution [{Number}, 'low', 'high'],
        dynamicLabel: true
      })
	$(".playertextbox").appendTo($('#video_player'));

  // var res = player.currentResolution();
  // player.currentResolution(res);
 
    function autoplay1() {
    	
    	var playButton = document.getElementsByClassName("vjs-big-play-button")[0];
		playButton.setAttribute("id", "myPlayButton");
	    var next_video_id = $(".next_video").text();
	    var prev_video_id = $(".prev_video").text();
	    var next_cat_video = $(".next_cat_video").text();
	    var prev_cat_video = $(".prev_cat_video").text();
	    var url = $(".next_url").text();
	    if(next_video_id != ''){

	    	$(".vjs-big-play-button").show();$(".playertextbox").removeClass('hide');
			var bar = new ProgressBar.Circle(myPlayButton, {
			strokeWidth: 7,
			easing: 'easeInOut',
			duration: 2400,
			color: '#98cb00',
			trailColor: '#eee',
			trailWidth: 1,
			svgStyle: null
			});

			bar.animate(1.0);  // Number from 0.0 to 1.0
	    	setTimeout(function(){ 	
         	window.location = "<?= URL::to('/');?>"+"/"+url+"/"+next_video_id;
         }, 3000);
	    }else if(prev_video_id != ''){
	    	
	    	$(".vjs-big-play-button").show();$(".playertextbox").removeClass('hide');
			var bar = new ProgressBar.Circle(myPlayButton, {
			strokeWidth: 7,
			easing: 'easeInOut',
			duration: 2400,
			color: '#98cb00',
			trailColor: '#eee',
			trailWidth: 1,
			svgStyle: null
			});

			bar.animate(1.0);  // Number from 0.0 to 1.0
	    	setTimeout(function(){ 	
         	window.location = "<?= URL::to('/');?>"+"/"+url+"/"+prev_video_id;
         }, 3000);
	    
	    }

	    if(next_cat_video != ''){

	    	$(".vjs-big-play-button").show();$(".playertextbox").removeClass('hide');
			var bar = new ProgressBar.Circle(myPlayButton, {
			strokeWidth: 7,
			easing: 'easeInOut',
			duration: 2400,
			color: '#98cb00',
			trailColor: '#eee',
			trailWidth: 1,
			svgStyle: null
			});

			bar.animate(1.0);  // Number from 0.0 to 1.0
	    	setTimeout(function(){ 	
         	window.location = "<?= URL::to('/');?>"+"/videos_category/"+next_cat_video;
         }, 3000);
	    }else if(prev_cat_video != ''){
	    	
	    	$(".vjs-big-play-button").show();$(".playertextbox").removeClass('hide');
			var bar = new ProgressBar.Circle(myPlayButton, {
			strokeWidth: 7,
			easing: 'easeInOut',
			duration: 2400,
			color: '#98cb00',
			trailColor: '#eee',
			trailWidth: 1,
			svgStyle: null
			});

			bar.animate(1.0);  // Number from 0.0 to 1.0
	    	setTimeout(function(){ 	
         	window.location = "<?= URL::to('/');?>"+"/videos_category/"+prev_cat_video;
         }, 3000);
	    
	    }
 	}

 	/*on video Play*/
 	function playstart() {
 		// if($("#video_player").data('authenticated')){
		// 	$.post('<?= URL::to('watchhistory');?>', { video_id : '<?// $watchlater_video->id ?>', _token: '<?= csrf_token(); ?>' }, function(data){});
		// 	$.post('<?= URL::to('recommendedcategories');?>', { videocategoryid : $('.videocategoryid').data('videocategoryid'), _token: '<?= csrf_token(); ?>' }, function(data){});

		// } else {
		// 	$.post('<?= URL::to('recommendedcategories');?>', { videocategoryid : $('.videocategoryid').data('videocategoryid'), _token: '<?= csrf_token(); ?>' }, function(data){});
		// }
    $(".vjs-big-play-button").hide();
 	}
  </script>


   
<link href=”//vjs.zencdn.net/7.0/video-js.min.css” rel=”stylesheet”>
<script src=”//vjs.zencdn.net/7.0/video.min.js”></script>

   <!-- <script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>-->
   <!-- <script src="https://vjs.zencdn.net/7.8.3/video.js"></script> -->
    <script src="<?= THEME_URL .'/assets/dist/video.js'; ?>"></script>
  	<script src="<?= THEME_URL .'/assets/dist/videojs-resolution-switcher.js'; ?>"></script>
  	<script src="<?= THEME_URL .'/assets/dist/videojs-watermark.js'; ?>"></script>
<script>
	videojs('videojs-seek-buttons-player', {
    controls: true,
    plugins: {
      videoJsResolutionSwitcher: {
        default: 'low', // Default resolution [{Number}, 'low', 'high'],
        dynamicLabel: true
      }
    }
  }, function(){
    var player = this;
    window.player = player
    player.updateSrc([
      {
        
        src: 'if(empty($watchlater_video->id)){ echo "No Videos Found" ; }else{ echo $watchlater_video->id; };?>',
        type: 'video/mp4',
        label: 'SD',
        res: 360
      },
      {
        src: 'if(empty($watchlater_video->id)){ echo "No Videos Found" ; }else{ echo $watchlater_video->id; };?>',
        type: 'video/mp4',
        label: 'HD',
        res: 720
      }
    ])
    player.on('resolutionchange', function(){
      console.info('Source changed to %s', player.src())
    })
  })
        
</script>
<!--<script src="https://vjs.zencdn.net/7.7.5/video.js"></script>
<script>
var vid = document.getElementById("videojs-seek-buttons-player");
vid.onloadeddata = function() {

    // get the current players AudioTrackList object
    var player = videojs('videojs-seek-buttons-player')
    let tracks = player.audioTracks();

    alert(tracks.length);

    for (let i = 0; i < tracks.length; i++) {
        let track = tracks[i];
        console.log(track);
        alert(track.language);
    }
};
</script>-->



<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
 <script src="https://vjs.zencdn.net/7.10.2/video.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/videojs-seek-buttons/dist/videojs-seek-buttons.min.js"></script>

  <script>
    // fire up the plugin
    videojs('video_player', {
	  playbackRates: [0.5, 1, 1.5, 2],
      controls: true,
      muted: true,
      width: 991,
      fluid: true,
      plugins: {
        videoJsResolutionSwitcher: {
		  ui: true,
          default: 'low', // Default resolution [{Number}, 'low', 'high'],
          dynamicLabel: true
        }
      }
    }, function(){
      var player = this;
      window.player = player
	  player.watermark({
        image: '',
		fadeTime: null,
        url: ''
      });
    });
  </script>


      <script>
        (function(window, videojs) {
            
          var examplePlayer = window.examplePlayer = videojs('videojs-seek-buttons-player');
          var seekButtons = window.seekButtons = examplePlayer.seekButtons({
            forward: 10,
            back: 10
          });
        }(window, window.videojs));
      </script>

    <script src="<?php echo URL::to('/').'/assets/js/videojs.hotkeys.js';?>"></script>
    <script>
        
      videojs('videojs-seek-buttons-player').ready(function() {
        this.hotkeys({
          volumeStep: 0.1,
          seekStep: 10,
          enableMute: true,
          enableFullscreen: true,
          enableNumbers: false,
          enableVolumeScroll: true,
          enableHoverScroll: true,

          // Mimic VLC seek behavior, and default to 5.
          seekStep: function(e) {
            if (e.ctrlKey && e.altKey) {
              return 5*60;
            } else if (e.ctrlKey) {
            
              return 60;
            } else if (e.altKey) {
              return 10;
            } else {               
              return 5;
            }
          },

          // Enhance existing simple hotkey with a complex hotkey
          fullscreenKey: function(e) {
            // fullscreen with the F key or Ctrl+Enter
            return ((e.which === 70) || (e.ctrlKey && e.which === 13));
          },

          // Custom Keys
          customKeys: {

            // Add new simple hotkey
            simpleKey: {
              key: function(e) {
                // Toggle something with S Key
                return (e.which === 83);
              },
              handler: function(player, options, e) {
                // Example
                if (player.paused()) {
                  player.play();
                } else {
                  player.pause();
                }
              }
            },

            // Add new complex hotkey
            complexKey: {
              key: function(e) {
                // Toggle something with CTRL + D Key
                return (e.ctrlKey && e.which === 68);
              },
              handler: function(player, options, event) {
                // Example
                if (options.enableMute) {
                  player.muted(!player.muted());
                }
              }
            },

            // Override number keys example from https://github.com/ctd1500/videojs-hotkeys/pull/36
            numbersKey: {
              key: function(event) {
                // Override number keys
                return ((event.which > 47 && event.which < 59) || (event.which > 95 && event.which < 106));
              },
              handler: function(player, options, event) {
                // Do not handle if enableModifiersForNumbers set to false and keys are Ctrl, Cmd or Alt
                if (options.enableModifiersForNumbers || !(event.metaKey || event.ctrlKey || event.altKey)) {
                  var sub = 48;
                  if (event.which > 95) {
                    sub = 96;
                  }
                  var number = event.which - sub;
                  player.currentTime(player.duration() * number * 0.1);
                }
              }
            },

            emptyHotkey: {
              // Empty
            },

            withoutKey: {
              handler: function(player, options, event) {
                  console.log('withoutKey handler');
              }
            },

            withoutHandler: {
              key: function(e) {
                  return true;
              }
            },

            malformedKey: {
              key: function() {
                console.log('I have a malformed customKey. The Key function must return a boolean.');
              },
              handler: function(player, options, event) {
          
              }
            }
          }
        });
      });
        
    var video = videojs('videojs-seek-buttons-player');

    video.on('pause', function() {
      this.bigPlayButton.show();
        $(".vjs-big-play-button").show();
        video.one('play', function() {
        this.bigPlayButton.hide();
      });
    });
 
$(document).ready(function () { 
    $(window).on("beforeunload", function() { 

        var vid = document.getElementById("videojs-seek-buttons-player_html5_api");
        var currentTime = vid.currentTime;
        var videoid = video_id;
            $.post('<?= URL::to('continue-watching') ?>', { video_id : videoid,currentTime:currentTime, _token: '<?= csrf_token(); ?>' }, function(data){
                      //    toastr.success(data.success);
            });
      // localStorage.setItem('your_video_'+video_id, currentTime);
        return;
    }); });

    var current_time = $('#current_time').val();
    var myPlayer = videojs('videojs-seek-buttons-player_html5_api');
    var duration = myPlayer.currentTime(current_time);
    </script>

<?php include('footer.blade.php'); ?>