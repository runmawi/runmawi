<?php include('header.php'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>

.pagination>li>a, .pagination>li>span {
    position: relative;
    float: left;
    padding: 11px 15px;
    line-height: 1.42857143;
    text-decoration: none;
    color: #eff2f5;
    background-color: #000;
    border: 1px solid #34383a;
    margin-left: -1px;
}
.pagination a {
    display: inline-block;
    width: 32px;
    height:     36px;
    margin: 0 10px;
    text-indent: -9999px;
}
    .pagination li a {
        color:#ffff;
    }
.pagination>.active>a, .pagination>.active>span, .pagination>.active>a:hover, .pagination>.active>span:hover, .pagination>.active>a:focus, .pagination>.active>span:focus {
    z-index: 2;
    color: #fff;
    background-color: #8c8c8c;
    border-color: #428bca;
    cursor: default;
    width: 32px;
    height: 36px;
    text-align: center;
}
.pagination>.disabled>span, .pagination>.disabled>span:hover, .pagination>.disabled>span:focus, .pagination>.disabled>a, .pagination>.disabled>a:hover, .pagination>.disabled>a:focus {
    color: #fff;
    background-color: #0a0a0a;
    border-color: #ddd;
    cursor: not-allowed;
    height: 36px;
}
    .movlistt {
    padding-top: 90px;
        min-height: 450px;
}
 .thumb-cont{
         position: fixed;
	z-index: 1040;
	height: 521px !important;
    width: 100% !important;
    margin-top: 80px !important;
    opacity: none;
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
     li.slide-item .block-images{
         margin-bottom: 2rem !important;
     }
    /* .navbar-right.menu-right {
    margin-right: -150px !important;
}*/
      .nav-tabs {
    border: 0;
    margin-top: 15px;
    text-align: center;
    width: 60%;
}
    .slick-slide{
        width: 250px!important;
           
    padding-left: 25px!important;
    }

</style>


<div class="container movlistt" id="home-content">
    
    <div class="new-art">
        <h4 class="Continue Watching  padding-top-40" >Search Result of "<?php echo $search_value;?>" Channel Videos</h4>
	    <div class="border-line" style="margin-bottom:15px;margin-top:20px;"></div>
    </div>
    
    <div class="row nomargin">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
        <?php if(isset($videos) && !empty($videos)) { 
            foreach($videos as $watchlater_video): ?>
   <li class="slide-item">
                          <a href="<?php echo URL::to('home') ?>">
                             <div class="block-images position-relative">
                                <div class="img-box">
                                <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                                   <!-- <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt=""> -->
                                   <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>"  data-play="hover" >
                                    <source src="<?php echo $watchlater_video->trailer;  ?>" type="video/mp4">
                                      </video>
                                     </a>
                                     <div class="corner-text-wrapper">
                                        <div class="corner-text">
                                          <?php  if(!empty($watchlater_video->ppv_price)){?>
                                          <p class="p-tag1"><?php echo $currency->symbol.' '.$watchlater_video->ppv_price; ?></p>
                                          <?php }elseif( !empty($watchlater_video->global_ppv || !empty($watchlater_video->global_ppv) && $watchlater_video->ppv_price == null)){ ?>
                                            <p class="p-tag1"><?php echo $watchlater_video->global_ppv.' '.$currency->symbol; ?></p>
                                            <?php }elseif($watchlater_video->global_ppv == null && $watchlater_video->ppv_price == null ){ ?>
                                            <p class="p-tag"><?php echo "Free"; ?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-description">
                                    <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                                   <h6><?php echo __($watchlater_video->title); ?></h6>
                                    </a>
                                   <div class="movie-time d-flex align-items-center my-2">
                                      <div class="badge badge-secondary p-1 mr-2"><?php echo $watchlater_video->age_restrict ?></div>
                                      <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                   </div>
                                    
                                    
                                    
                                   <div class="hover-buttons">
                                       <a class="text-white" href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" >
                                    
                                      <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                      Watch Now
                                      
                                       </a>
                                       <div class="hover-buttons">
                                       <!-- <a   href="<?php // echo URL::to('category') ?><?// '/wishlist/' . $watchlater_video->slug ?>" class="text-white mt-4"><i class="fa fa-plus" aria-hidden="true"></i> Add to Watchlist -->
                       <!-- </a> -->
                          <span style="color: white;"class="mywishlist <?php if(isset($mywishlisted->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $watchlater_video->id ?>"><i style="" <?php if(isset($mywishlisted->id)): ?> class="ri-heart-fill" <?php else: ?> class="ri-heart-line " <?php endif; ?> style="" ></i><span id="addwatchlist"> Add to Watchlist </span> </span>
                              </div>

<!--
                                    <div>
                                        <button class="show-details-button" data-id="<?= $watchlater_video->id;?>">
                                            <span class="text-center thumbarrow-sec">
                                                <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                            </span>
                                                </button>
                                    </div>
-->
                                    </div>
                              
                             </div>
                          </a>
                       </li>
        <?php endforeach; 
        } else {?>
             <p class="no_video">No Channel Video Found</p>
            <?php } ?> 
        
    </ul>
                     </div>

    
    
</div>
 


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  // alert( $(this).data('videoid'));
       $('.mywishlist').click(function(){
       if($(this).data('authenticated')){
         $.post('<?= URL::to('mywishlist') ?>', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
         $(this).toggleClass('active');
         $(this).html("");
             if($(this).hasClass('active')){
              $(this).html('<i class="ri-heart-fill"></i>');
              // $(this).html('<span id="removewatchlist" >Remove From Watchlist</i>');
             }else{
               $(this).html('<i class="ri-heart-line">Add to Watchlist</i>');

             }
             
       } else {
         window.location = '<?= URL::to('login') ?>';
       }
     });

</script>




<?php include('footer.blade.php');?>