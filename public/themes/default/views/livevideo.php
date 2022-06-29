
<?php include ('header.php'); 
        //    dd($data);
          ?>

<meta name="csrf-token" content="{{ csrf_token() }}">
<style type="text/css">
	
#video_bg_dim{
    /*background: rgb(0 0 0 / 45%);*/
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}
.countdown {
  text-align: center;
  font-size: 60px;
  margin-top: 0px;
  color:red;
}
h2{
  text-align: center;
  font-size: 35px;
  margin-top: 0px;
    font-weight: 400;
}
#videoPlayer {
    width: 100%;
    height: 100%;
    margin: 20px auto;
}
    .plyr audio, .plyr iframe, .plyr video {
    display: block;
    /* height: 100%; */
    /* width: 100%; */
}
    .plyr--video{
         height: calc(80vh - 80px - 75px);
    max-width: none;
    width: 100%;
    }  
</style>

<style>

.vjs-skin-hotdog-stand { color: #FF0000; }
.vjs-skin-hotdog-stand .vjs-control-bar { background: #FFFF00; }
.vjs-skin-hotdog-stand .vjs-play-progress { background: #FF0000; }

</style>

<input type="hidden" name="video_id" id="video_id" value="<?php echo $video->id; ?>">

<?php
$str = $video->mp4_url;
if(!empty($str)){
$uri_parts = explode('.', $video->mp4_url);
$request_url = end($uri_parts);
}


$rtmp_url = $video->rtmp_url;

$Rtmp_url = str_replace ('rtmp', 'http', $rtmp_url);

if(empty($new_date)){

if(!Auth::guest()){
    
 if(!empty($password_hash)){
if ($ppv_exist > 0 || Auth::user()->subscribed()  || $video->access == "guest" && $video->ppv_price == null ) { ?>
<div id="video_bg"> 
        <div class="">
            <div id="video sda" class="fitvid" style="margin: 0 auto;">

            <?php if(!empty($video->mp4_url && $request_url != "m3u8"  && $video->url_type == "mp4" )){  ?>

                    <video id="videoPlayer"  class="" poster="<?=URL::to('/') . '/public/uploads/images/' . $video->player_image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?=$video->mp4_url; ?>"  type="application/x-mpegURL" data-authenticated="<?=!Auth::guest() ?>">
                        <source src="<?= $video->mp4_url; ?>" type='application/x-mpegURL' label='Auto' res='auto' />
                        <source src="<?php echo $video->mp4_url; ?>" type='application/x-mpegURL' label='480p' res='480'/>
                        <!-- <source src="<?php echo URL::to('/storage/app/public/') . '/' . $video->path . '_2_1000.m3u8'; ?>" type='application/x-mpegURL' label='720p' res='720'/>  -->
                    </video>

            <?php }elseif(!empty($video->embed_url)  && $video->url_type == "embed"){ ?> 
                <div class="plyr__video-embed" id="player">
                    <iframe
                        src="<?php if(!empty($video->embed_url)){ echo $video->embed_url	; }else { } ?>"
                        allowfullscreen
                        allowtransparency
                        allow="autoplay">
                    </iframe>
                </div>
                <?php  }elseif(!empty($request_url == "m3u8")  && $video->url_type == "mp4"){  ?> 
                    <!-- <div class="plyr__video-embed" id="player"> -->
                        <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo $video->mp4_url ?>">
                        <input type="hidden" id="type" name="type" value="<?php echo $video->type ?>">
                        <input type="hidden" id="live" name="live" value="live">
                        <input type="hidden" id="request_url" name="request_url" value="<?php echo $request_url ?>">

                        <video id="video"  controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
                            <source  type="application/x-mpegURL"  src="<?php echo $video->mp4_url; ?>" >
                        </video>
                    <!-- </div>  -->
            <?php }elseif(!empty($video->url_type == "Encode_video")){  ?>

                        <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo $video->hls_url ; ?>">
                        <input type="hidden" id="type" name="type" value="<?php echo $video->type ?>">
                        <input type="hidden" id="live" name="live" value="live">
                        <input type="hidden" id="request_url" name="request_url" value="<?php echo "m3u8" ?>">

                         <video id="video"  controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
                            <source  type="application/x-mpegURL"  src="<?php echo $video->hls_url ; ?>" >
                        </video>

               <?php  }elseif(!empty($video->url_type ) && $video->url_type == "live_stream_video"){  ?>

                <input type="hidden" id="hls_m3u8" name="hls_m3u8" value="<?php echo $video->live_stream_video; ?>">
                <input type="hidden" id="type" name="type" value="<?php echo $video->type ?>">
                <input type="hidden" id="live" name="live" value="live">
                <input type="hidden" id="request_url" name="request_url" value="<?php echo "m3u8" ?>">
                    <video id="video"  controls crossorigin playsinline poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' >
                                <source type="application/x-mpegURL" src="<?php echo $video->live_stream_video ; ?>">
                    </video>

            <?php } ?>

                <div class="playertextbox hide">
                    <p> <?php if (isset($videonext)) { ?>
                        <?=App\LiveStream::where('id', '=', $videonext->id)->pluck('title'); ?>
                        <?php } elseif (isset($videoprev)) { ?>
                        <?=App\LiveStream::where('id', '=', $videoprev->id)->pluck('title'); ?>
                        <?php } ?>

                        <?php if (isset($videos_category_next)) { ?>
                        <?=App\LiveStream::where('id', '=', $videos_category_next->id)->pluck('title'); ?>
                        <?php } elseif (isset($videos_category_prev)) { ?>
                        <?=App\LiveStream::where('id', '=', $videos_category_prev->id)->pluck('title'); ?>
                        <?php } ?>
                    </p>
                </div>
            </div>

            <?php  } else {  ?>       
                <div id="subscribers_only" style="background:linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.4)), url(<?=URL::to('/') . '/public/uploads/images/' . $video->image ?>); background-repeat: no-repeat; background-size: cover; padding:150px 10px;">
                    <div id="video_bg_dim" <?php if ( ($video->access == 'subscriber' && !Auth::guest())): ?><?php else: ?> class="darker"<?php endif; ?>></div>
                    <div class="row justify-content-center pay-live">
                        <div class="col-md-4 col-sm-offset-4">
                            <div class="ppv-block">
                                <h2 class="mb-3">Pay now to watch <?php echo $video->title; ?></h2>
                                <div class="clear"></div>

                               
                    <!-- Stripe Button -->
                            <button class="btn btn-primary btn-block" onclick="pay(<?php echo $video->ppv_price; ?>)">Watch Now For <?php echo $currency->symbol.' '.$video->ppv_price; ?></button>

                    <!-- Razorpay Button -->
                    <?php if($Razorpay_payment_setting !=null && $Razorpay_payment_setting->payment_type == "Razorpay" ){?>
                            <button class="btn btn-primary btn-block" onclick="location.href ='<?= URL::to('RazorpayLiveRent/'.$video->id.'/'.$video->ppv_price) ?>' ;" >Razorpay Purchase For <?php echo $currency->symbol.' '.$video->ppv_price; ?></button>
                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } }
        }
    
    else{  
        //   dd($settings);

                if (Auth::guest() && empty($video->ppv_price)) { ?>
                <div id="video_bg"> 
        <div class="container">
            <div id="video sda" class="fitvid" style="margin: 0 auto;">
                <video id="videoPlayer" autoplay onplay="playstart()" onended="autoplay1()" class="video-js vjs-default-skin vjs-big-play-centered" poster="<?=URL::to('/') . '/public/uploads/images/' . $video->image ?>" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' src="<?=$video->mp4_url; ?>"  type="application/x-mpegURL" data-authenticated="<?=!Auth::guest() ?>">

                    <source src="<?=$video->mp4_url; ?>" type='application/x-mpegURL' label='Auto' res='auto' />
                    <!--
                    <source src="<?php echo URL::to('/storage/app/public/') . '/' . $video->path . '_0_250.m3u8'; ?>" type='application/x-mpegURL' label='480p' res='480'/>
                    <source src="<?php echo URL::to('/storage/app/public/') . '/' . $video->path . '_2_1000.m3u8'; ?>" type='application/x-mpegURL' label='720p' res='720'/> 
                    -->
                </video>

                <div class="playertextbox hide">
                    <p> <?php if (isset($videonext)) { ?>
                        <?=App\LiveStream::where('id', '=', $videonext->id)->pluck('title'); ?>
                        <?php } elseif (isset($videoprev)) { ?>
                        <?=App\LiveStream::where('id', '=', $videoprev->id)->pluck('title'); ?>
                        <?php } ?>

                        <?php if (isset($videos_category_next)) { ?>
                        <?=App\LiveStream::where('id', '=', $videos_category_next->id)->pluck('title'); ?>
                        <?php } elseif (isset($videos_category_prev)) { ?>
                        <?=App\LiveStream::where('id', '=', $videos_category_prev->id)->pluck('title'); ?>
                        <?php } ?>
                    </p>
                </div>
            </div>

            <?php  } else { ?>       
                <div id="subscribers_only"style="background:linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.5)), url(<?=URL::to('/') . '/public/uploads/images/' . $video->image ?>); background-repeat: no-repeat; background-size: cover; padding:150px 10px;">
                    <div id="video_bg_dim" <?php if (($video->access == 'subscriber' && !Auth::guest())): ?><?php else: ?> class="darker"<?php endif; ?>></div>
                    <div class="row justify-content-center pay-live">
                        <div class="col-md-4 col-sm-offset-4">
                            <div class="ppv-block">
                                <h2 class="mb-3">Pay now to watch <?php echo $video->title; ?></h2>
                                <div class="clear"></div>
                                <button class="btn btn-primary btn-block" onclick="pay(<?php echo $video->ppv_price; ?>)">Purchase For Pay <?php echo $currency->symbol.' '.$video->ppv_price; ?></button>
                            </div>
                        </div>
                    </div>
                </div>
           <?php }
            }
            } elseif(!empty($new_date)){ ?>
                <div id="subscribers_only"style="background:linear-gradient(0deg, rgba(0, 0, 0, 1.4), rgba(0, 0, 0, 0.3)), url(<?=URL::to('/') . '/public/uploads/images/' . $video->image ?>); background-repeat: no-repeat; background-size: cover; padding:150px 10px;">
                    <h2> COMING SOON </h2>
                    <p class="countdown" id="demo"></p>
                    </div>
                   <?php }
            ?>
            
            <input type="hidden" class="videocategoryid" data-videocategoryid="<?=$video->video_category_id; ?>" value="<?=$video->video_category_id; ?>">

            <div class="container-fluid video-details">
                <div class="row">
                    <div class="col-sm-9 col-md-9 col-xs-12">
                        <h1 class="trending-text big-title text-uppercase mt-3"><?php echo __($video->title);?> <?php if( Auth::guest() ) { ?>  <?php } ?></h1>
                            <!-- Category -->
                        <ul class="p-0 list-inline d-flex align-items-center movie-content">
                         <li class="text-white"><?//= $videocategory ;?></li>
                        </ul>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class=" d-flex mt-4 pull-right"> 
                            <div class="views">
                                <span class="view-count"><i class="fa fa-eye"></i> 
                                    <?php if(isset($view_increment) && $view_increment == true ): ?><?= $video->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> <?php echo __('Views');?> 
                                </span>
                            </div>
                        </div>
                    </div>        
                </div>
                <!-- Year, Running time, Age -->
               <?php 
               if(!empty($video->publish_time)){
                $originalDate = $video->publish_time;
                $publishdate = date('d F Y', strtotime($originalDate));
               }else{
                $originalDate = $video->created_at;
                $publishdate = date('d F Y', strtotime($originalDate));
               }
             ?>
                <div class=" align-items-center text-white text-detail p-0">
                <span class="badge badge-secondary p-2"><?php echo __(@$video->languages->name);?></span>
                <span class="badge badge-secondary p-2"><?php echo __(@$video->categories->name);?></span>
                <span class="badge badge-secondary p-2">Published On : <?php  echo $publishdate;?></span>
                <span class="badge badge-secondary p-2"><?php echo __($video->age_restrict);?></span>
             
                  </div>
                
                <?php if(!Auth::guest()) { ?>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-xs-12">
                         <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                              <!-- Social Share, Like Dislike -->
                                 <?php // include('partials/social-share.php'); ?>                     
                          </ul>
                    </div>

<!--                    <div class="col-sm-6 col-md-6 col-xs-12">-->
        <!--
                          <div class="d-flex align-items-center series mb-4">
                             <a href="javascript:void();"><img src="images/trending/trending-label.png" class="img-fluid"
                                   alt=""></a>
                             <span class="text-gold ml-3">#2 in Series Today</span>
                          </div>
        -->                 
<!--                        <ul class="list-inline p-0 mt-4 rental-lists">-->
                        <!-- Subscribe -->
<!--
                            <li>
                                <?php     
                                    $user = Auth::user(); 
                                    if (  ($user->role!="subscriber" && $user->role!="admin") ) { ?>
                                        <a href="<?php echo URL::to('/becomesubscriber');?>"><span class="view-count btn btn-primary subsc-video"><?php echo __('Subscribe');?> </span></a>
                                <?php } ?>
                            </li>
-->
                            <!-- PPV button -->
<!--
                            <li>
                                <?php if ( ($ppv_exist == 0 ) && ($user->role!="subscriber" && $user->role!="admin")  ) { ?>
                                    <button  data-toggle="modal" data-target="#exampleModalCenter" class="view-count btn btn-primary rent-video">
                                    <?php echo __('Rent');?> </button>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
-->
                </div>

                <?php } ?>
                
                <?php if(Auth::guest()) { ?>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-xs-12">
                         <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                              <!-- Social Share, Like Dislike -->
                                 <?php include('partials/social-share.php'); ?>                     
                          </ul>
                    </div>


                  
                    <div class="col-sm-6 col-md-6 col-xs-12">
    <!--
                          <div class="d-flex align-items-center series mb-4">
                             <a href="javascript:void();"><img src="images/trending/trending-label.png" class="img-fluid"
                                   alt=""></a>
                             <span class="text-gold ml-3">#2 in Series Today</span>
                          </div>
        -->                 
                        <ul class="list-inline p-0 mt-4 rental-lists">
                        <!-- Subscribe -->
                            <li>
                                <a href="<?php echo URL::to('/login');?>"><span class="view-count btn btn-primary subsc-video"><?php echo __('Subscribe');?> </span></a>
                            </li>
                            <!-- PPV button -->
                            <li>
                                <a data-toggle="modal" data-target="#exampleModalCenter" class="view-count btn btn-primary rent-video" href="<?php echo URL::to('/login');?>">
                                    <?php echo __('Rent');?> </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php   }?>
                <div class="text-white col-md-6 p-0">
                    <p class="trending-dec w-100 mb-0 text-white"><?php echo __($video->description); ?></p>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div class="video-details-container">
                            <?php if (!empty($video->details)) { ?>
                                <h6 class="mt-3 mb-1">Live Details</h6>
                                <p class="trending-dec w-100 mb-3 text-white"><?=$video->details; ?></p>
                            <?php  } ?>
                        </div>
                    </div>
                </div>


                
<!-- <div style="text-align:right;padding:5px 0";>
<span class="view-count" style="margin-right:10px";><i class="fa fa-eye"></i> <?php if (isset($view_increment) && $view_increment == true): ?><?=$video->views + 1 ?><?php
else: ?><?=$video->views ?><?php
endif; ?> Views </span>
<div class="favorite btn btn-default <?php if (isset($favorited->id)): ?>active<?php
endif; ?>" data-authenticated="<?=!Auth::guest() ?>" data-videoid="<?=$video->id ?>"><i class="fa fa-heart"></i> Favorite</div>
</div> -->
                
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title text-center" id="exampleModalLongTitle" style="color:#000;font-weight: 700;">Rent Now</h4>
           
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-sm-2" style="width:52%;">
                    <span id="paypal-button"></span> 
                  </div>
                  
                  <div class="col-sm-4">
                    <a onclick="pay(<?php echo $video->ppv_price;?>)">
                        <img src="<?php echo URL::to('/assets/img/card.png');?>" class="rent-card">
                    </a>
                  </div>
              </div>                    
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary"  data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>



                <?php if (isset($videonext)) { ?>
                    <div class="next_video" style="display: none;"><?=$videonext->slug; ?></div>
                    <div class="next_url" style="display: none;"><?=$url; ?></div>
                <?php } elseif (isset($videoprev)) { ?>
                    <div class="prev_video" style="display: none;"><?=$videoprev->slug; ?></div>
                    <div class="next_url" style="display: none;"><?=$url; ?></div>
                <?php } ?>

                <?php if (isset($videos_category_next)) { ?>
                    <div class="next_cat_video" style="display: none;"><?=$videos_category_next->slug; ?></div>
                <?php } elseif (isset($videos_category_prev)) { ?>
                    <div class="prev_cat_video" style="display: none;"><?=$videos_category_prev->slug; ?></div>
                <?php } ?>
                <div class="clear"></div>
<!--
<div id="tags">Tags: 
<php foreach($video->tags as $key => $tag): ?>
<span><a href="/videos/tag/<= $tag->name ?>"><= $tag->name ?></a></span><php if($key+1 != count($video->tags)): ?>,<php endif; ?>
<php endforeach; ?>
</div>
-->

                <div id="social_share">
                <!--            <php include('partials/social-share.php'); ?>-->
                </div>
                <script>
                    //$(".share a").hide();
                    $(".share").on("mouseover", function() {
                        $(".share a").show();
                    }).on("mouseout", function() {
                        $(".share a").hide();
                    });
                </script>

            </div>
    </div>
</div>
        <script src="<?=THEME_URL . '/assets/js/jquery.fitvid.js'; ?>"></script>
        <script type="text/javascript">

$(document).ready(function(){
$('#video_container').fitVids();
$('.favorite').click(function(){
if($(this).data('authenticated')){
$.post('<?=URL::to('favorite') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
$(this).toggleClass('active');
} else {
window.location = '<?=URL::to('login') ?>';
}
});
//watchlater
$('.watchlater').click(function(){

if($(this).data('authenticated')){
$.post('<?=URL::to('ppvWatchlater') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
$(this).toggleClass('active');
$(this).html("");
if($(this).hasClass('active')){
$(this).html('<a><i class="fa fa-check"></i>Watch Later</a>');
}else{
$(this).html('<a><i class="fa fa-clock-o"></i>Watch Later</a>');
}
} else {
window.location = '<?=URL::to('login') ?>';
}
});

//My Wishlist
$('.mywishlist').click(function(){
if($(this).data('authenticated')){
$.post('<?=URL::to('ppvWishlist') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
$(this).toggleClass('active');
$(this).html("");
if($(this).hasClass('active')){
$(this).html('<a><i class="fa fa-check"></i>Wishlisted</a>');
}else{
$(this).html('<a><i class="fa fa-plus"></i>Add Wishlist</a>');
}

} else {
window.location = '<?=URL::to('login') ?>';
}
});

});

</script>

<!-- RESIZING FLUID VIDEO for VIDEO JS -->

<script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/1.0.0/dist/progressbar.js"></script>


<script type="text/javascript">
$(document).ready(function(){
$('a.block-thumbnail').click(function(){
var myPlayer = videojs('video_player');
var duration = myPlayer.currentTime();

$.post('<?=URL::to('watchhistory'); ?>', { video_id : '<?=$video->id ?>', _token: '<?= csrf_token(); ?>', duration : duration }, function(data){});
}); 
});
</script>
<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
<script>
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
</script>

<input type="hidden" id="purchase_url" name="purchase_url" value="<?php echo URL::to("/purchase-live") ?>">
<input type="hidden" id="publishable_key" name="publishable_key" value="<?php echo $publishable_key ?>">


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>

<script type="text/javascript">
var livepayment = $('#purchase_url').val();
var publishable_key = $('#publishable_key').val();


// alert(livepayment);

$(document).ready(function () {  
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
});

function pay(amount) {
var video_id = $('#video_id').val();

var handler = StripeCheckout.configure({

key: publishable_key,
locale: 'auto',
token: function (token) {
// You can access the token ID with `token.id`.
// Get the token ID to your server-side code for use.
console.log('Token Created!!');
console.log(token);
$('#token_response').html(JSON.stringify(token));
$.ajax({
 url: '<?php echo URL::to("purchase-live") ;?>',
 method: 'post',
 data: {"_token": "<?= csrf_token(); ?>",tokenId:token.id, amount: amount , video_id: video_id },
 success: (response) => {
   alert("You have done  Payment !");
   setTimeout(function() {
     location.reload();
   }, 2000);

 },
 error: (error) => {
   swal('error');
//swal("Oops! Something went wrong");
/* setTimeout(function() {
location.reload();
}, 2000);*/
}
})
// $.ajax({
// url: livepayment,
// method: 'post',
// data: {  _token: '<?= csrf_token(); ?>',tokenId: token.id, amount: amount , video_id: video_id },
// success: (response) => {
// swal("You have done  Payment !");
// setTimeout(function() {
// location.reload();
// }, 2000);

// },
// error: (error) => {
// swal('error');
// //swal("Oops! Something went wrong");
// /* setTimeout(function() {
// location.reload();
// }, 2000);*/
// }
// })
}
});


handler.open({
name: '<?php $settings = App\Setting::first(); echo $settings->website_name;?>',
description: 'PAY PeR VIEW',
amount: amount * 100
});
}
</script>

<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>

<script>
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
</script>
<!-- <script src="https://vjs.zencdn.net/7.8.3/video.js"></script> -->


<script>
// Set the date we're counting down to
var date = "<?= $new_date ?>";
var countDownDate = new Date(date).getTime();
// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>

<?php include ('footer.blade.php'); ?>
