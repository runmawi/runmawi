<?php include('header.php');?>

  


 <!-- loader Start -->
 <!--<div id="loading">
    <div id="loading-center">
    </div>
 </div>-->
 <!-- loader END -->

 <!-- MainContent -->
 <div class="main-content">
     <div class="col-sm-12 overflow-hidden">
        <div class="iq-main-header d-flex align-items-center justify-content-between">
            <h4 class="Continue Watching">Media in My WishLists</h4>
        </div>
     </div>
     <section class="movie-detail ">
         <div class="row">
             <?php if(count($channelwatchlater) > 0):
                   foreach($channelwatchlater as $video): ?>
            <div class="col-1-5 col-md-6 iq-mb-30">
                 <a href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>">
                <div class=" position-relative">
                <!-- block-images -->
                   
                        <video  width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$video->image; ?>"  data-play="hover" >
                            <source src="<?php echo $video->trailer;  ?>" type="video/mp4">
                        </video>
                   
                    <div class="corner-text-wrapper">
                        <div class="corner-text">
                            <p class="p-tag1">
                                <?php if(!empty($category_video->ppv_price)) {
                                    echo $category_video->ppv_price.' '.$currency->symbol ; 
                                    } elseif(!empty($category_video->global_ppv) && $category_video->ppv_price == null) {
                                    echo $category_video->global_ppv .' '.$currency->symbol;
                                    } elseif(empty($category_video->global_ppv) && $category_video->ppv_price == null) {
                                    echo "Free"; 
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="block-description">
                        <a href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>">
                            <h6>
                                <?php echo __($video->title); ?>
                            </h6>
                        </a>
                        <div class="movie-time d-flex align-items-center my-2">
                            <div class="badge badge-secondary p-1 mr-2"><?php echo $video->age_restrict ?></div>
                            <span class="text-white"><i class="fa fa-clock-o"></i>
                                <?= gmdate('H:i:s', $video->duration); ?>
                            </span>
                        </div>
                        <div class="hover-buttons">
                            <a type="button" class="text-white"
                            href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>">
                                <i class="fa fa-play mr-1" aria-hidden="true"></i>
                            Watch Now
                            </a>
                            <div>
                                <span style="color: white;"class="mywishlist <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>">
                                    <i style="" <?php if(isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php else: ?> class="ri-heart-line " <?php endif; ?> style="" ></i>
                                </span>
                                <div style="color:white;" id="<?= $category_video->id ?>">
                                    <?php if(@$video->mywishlisted->user_id == Auth::user()->id && @$video->mywishlisted->video_id == $video->id  ) { echo "Remove From Wishlist"; } 
                                    else { echo "Add To Wishlist" ; } ?>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
<!--
                 <div class="epi-box">
                    <div class="epi-img position-relative">
                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" class="img-fluid img-zoom" alt="">
                       <div class="episode-play-info">
                          <div class="episode-play">
                             <a href="<?= URL::to('/') ?><?= '/live'.'/'.@$video->categories->name.'/'. $video->slug ?>">
                                <i class="ri-play-fill"></i>
                             </a>
                          </div>
                       </div>
                    </div>
                    <div class="epi-desc p-3">
                       <div class="d-flex align-items-center justify-content-between">
                          <span class="text-white"><?php echo __($video->title); ?></span>
                       </div>
                       <a href="<?= URL::to('/') ?><?= '/live'.'/'.@$video->categories->name.'/'. $video->slug ?>">
                          <h6 class="epi-name text-white mb-0"><i class="fa fa-clock-o"></i> Live Now</h6>
                       </a>
                    </div>
                 </div>
-->
                </a>
            </div>
    <?php endforeach; 
        endif; ?>
         </div>
      </section>
    <section id="iq-favorites">
       <div class="container-fluid">
          <div class="row">
             <div class="col-sm-12 overflow-hidden">
                <div class="iq-main-header d-flex align-items-center justify-content-between">
       <h4 class="Continue Watching">My WishList Rental Videos</h4>
                </div>
                <div class="favorites-contens">
                   <ul class="favorites-slider list-inline  row p-0 mb-0">
                                 <?php if(count($channelwatchlater) > 0) : 
       foreach($channelwatchlater as $video): ?>
                      <li class="slide-item">
                         <a href="movie-details.html">
                            <div class="block-images position-relative">
                               <div class="img-box">
                                  <img src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" class="img-fluid" alt="">
                               </div>
                                
                               <div class="block-description">
                                  <h6><?php echo __($video->title); ?></h6>
                                  <div class="movie-time d-flex align-items-center my-2">
                                     <div class="badge badge-secondary p-1 mr-2">13+</div>
                                     <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $video->duration); ?></span>
                                  </div>
                                  <div class="hover-buttons">
                                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl">
                                     <span class="btn btn-hover">
                                     <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                     Play Now
                                     </span>
                                         </button>	
                                  </div>
                                   <div>
                                       <button class="show-details-button" data-id="<?= $video->id;?>">
                                           <span class="text-center thumbarrow-sec">
                                               <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                           </span>
                                               </button></div>
                                   </div>
                               <div class="block-social-info">
                                  <ul class="list-inline p-0 m-0 music-play-lists">
                                     <li><span><i class="ri-volume-mute-fill"></i></span></li>
                                     <li><span><i class="ri-heart-fill"></i></span></li>
                                     <li><span><i class="ri-add-line"></i></span></li>
                                  </ul>
                               </div>
                            </div>
                         </a>
                      </li>
                      
                                               
                                                         <?php endforeach; 

                        } else { ?>
                                   <p class="no_video" style="color:#fff!important;"> <?php echo __('No Video Found');?></p>
 <?php } ?>
                   </ul>
                    
                </div>
                 
             </div>
          </div>
       </div>

                     <?php if(isset($channelwatchlater)) :
                           foreach($channelwatchlater as $video): ?>
                           <div class="thumb-cont" id="<?= $video->id;?>"  style="background:url('<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>') no-repeat;background-size: cover;"> 
                               <div class="img-black-back">
                               </div>
                               <div align="right">
                               <button type="button" class="closewin btn btn-danger" id="<?= $video->id;?>"><span aria-hidden="true">X</span></button>
                                   </div>
                           <div class="tab-sec">
                               <div class="tab-content">
                               <div id="overview<?= $video->id;?>" class="container tab-pane active"><br>
                                      <h1 class="movie-title-thumb"><?php echo __($video->title); ?></h1>
                                              <p class="movie-rating">
                                               <span class="thumb-star-rate"><i class="fa fa-star fa-w-18"></i><?= $video->rating;?></span>
                                               <span class="viewers"><i class="fa fa-eye"></i>(<?= $video->views;?>)</span>
                                               <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $video->duration); ?></span>
                                               </p>
                                             <p>Welcome</p>
                                      <a class="btn btn-hover"  href="<?php echo URL::to('category') ?><?= '/videos/' . $video->slug ?>">	
                                                   <div class="btn btn-danger btn-right-space br-0">
                                               <i class="fa fa-play flexlink" aria-hidden="true"></i> Play
                                           </div></a>
                               </div>
   <div id="trailer<?= $video->id;?>" class="container tab-pane "><br>

    <div class="block expand">
   
   <a class="block-thumbnail-trail" href="<? URL::to('category') ?><?= '/videos/' . $video->slug ?>" >
 
    <?php if (!empty($video->trailer)) { ?>
    <video class="trail-vid" width="30%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" data-play="hover" muted="muted">
    <source src="<?= $video->trailer; ?>" type="video/mp4">
    </video>
    <?php } else { ?>
    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" class="thumb-img">
    <?php } ?>  
   </a>
   <div class="block-contents">
       <!--<p class="movie-title padding"><?php echo __($video->title); ?></p>-->
   </div>
</div> 
           
</div>
<div id="like<?= $video->id;?>" class="container tab-pane "><br>

      <h2>More Like This</h2>
</div>
<div id="details<?= $video->id;?>" class="container tab-pane "><br>
   <h2>Description</h2>

</div>
</div>
<div align="center">
       <ul class="nav nav-tabs">
               <li class="nav-item">
                 <a class="nav-link active" data-toggle="tab" href="#overview<?= $video->id;?>">OVERVIEW</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link" data-toggle="tab" href="#trailer<?= $video->id;?>">TRAILER AND MORE</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link" data-toggle="tab" href="#like<?= $video->id;?>">MORE LIKE THIS</a>
               </li>
                <li class="nav-item">
                 <a class="nav-link" data-toggle="tab" href="#details<?= $video->id;?>">DETAILS </a>           
               </li>
         </ul>
   </div>



</div></div>

<?php endforeach; 
endif; ?>
                   
</section>
 </div>

  <script>
$(document).ready(function () {
 $(".thumb-cont").hide();
 $(".show-details-button").on("click", function () {
   var idval = $(this).attr("data-id");
   $(".thumb-cont").hide();
   $("#" + idval).show();
 });
   $(".closewin").on("click", function () {
   var idval = $(this).attr("data-id");
   $(".thumb-cont").hide();
   $("#" + idval).hide();
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
<script>
// Prevent closing from click inside dropdown
$(document).on('click', '.dropdown-menu', function (e) {
e.stopPropagation();
});

// make it as accordion for smaller screens
if ($(window).width() < 992) {
$('.dropdown-menu a').click(function(e){
 e.preventDefault();
 if($(this).next('.submenu').length){
   $(this).next('.submenu').toggle();
 }
 $('.dropdown').on('hide.bs.dropdown', function () {
   $(this).find('.submenu').hide();
 }
                  )
}
                          );
}
</script>
   
<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
if (window.pageYOffset > sticky) {
header.classList.add("sticky");
} else {
header.classList.remove("sticky");
}
}
</script>
<script src="<?= THEME_URL . '/assets/js/rrssb.min.js'; ?>"></script>
<script src="<?= THEME_URL . '/assets/js/videojs-resolution-switcher.js';?>"></script>
<link href=”//vjs.zencdn.net/7.0/video-js.min.css” rel=”stylesheet”>
<script src=”//vjs.zencdn.net/7.0/video.min.js”></script>

<script src="<?= THEME_URL .'/assets/dist/video.js'; ?>"></script>
 <script src="<?= THEME_URL .'/assets/dist/videojs-resolution-switcher.js'; ?>"></script>
 <script src="<?= THEME_URL .'/assets/dist/videojs-watermark.js'; ?>"></script>
<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
<script src="https://vjs.zencdn.net/7.10.2/video.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-seek-buttons/dist/videojs-seek-buttons.min.js"></script>
<script src="<?php echo URL::to('/').'/assets/js/videojs.hotkeys.js';?>"></script>


<?php include('footer.blade.php');?>
 

