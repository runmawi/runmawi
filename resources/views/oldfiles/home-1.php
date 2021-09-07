<?php include('header.php'); ?>
<script type="text/javascript" src="<?php echo URL::to('/').'/assets/js/jquery.hoverplay.js';?>"></script>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-beta.2/lazyload.js"></script>
<script>
	$("img .lazyload").lazyload();
jQuery(document).ready(function($) {
    
    $(function(){
        $("img.lazyload").lazyload();
    });
});
</script>

<!--<script>
var myLazyLoad = new LazyLoad({
        elements_selector: "#lazy"
    });
</script>-->
<!--<script>$("img .lazyload").lazyload();</script>-->
<style type="text/css">
   /* #home-content{margin-top:560px;padding: 30px 0 0;}
    #home-content .row{margin-top:30px;}*/
    ul.video_list{margin:0px;padding:0px;}
    .video_list li{display:inline;list-style: none;}
   
</style>

<section class="homeslide">

 <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
	   <ol class="carousel-indicators">
		   <div class="loader">
	 
</div>
		<!--<div class="lazyload">
	 <img  src="https://localhost/assets/admin/admin/images/loader1.gif">
	
</div>-->
       <?php 
           $i = 1;
           foreach ($banner as $key => $bannerdetails) { ?>
		      <li data-target="#myCarousel" data-slide-to="<?=$i;?>" class="<?php if($i==1){ echo "active";}?>"></li>
           <?php  $i++; } ?>
	  </ol>
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
         <?php 
                $i = 1;
                foreach ($banner as $key => $bannerdetails) { ?>
                <div class="item <?php if($key == 0){echo 'active';}?> header-image" >
                    <a href="<?=$bannerdetails->link;  ?>">
                        <img class="lazyload" src="<?php echo URL::to('/').'/assets/img/home/images/images/joker.png'?>" data-src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$bannerdetails->slider;  ?>" alt="Home Slider" >
                    </a>
                </div>
        <?php $i++; } ?>
    </div>

  </div>
	
</section>

<div style="clear:both;height: 15px;"></div>

<div class="container page-height" >
    <div id="home-content"> 
      <?php if ( GetLatestVideoStatus() == 1 ) { ?>
        <div class="video-list">
         <?php if ( count($latest_videos) > 0 ) { 
            include('partials/latest-videoloop.php');
            
          } else {  ?>
                <p class="no_video"> No Video Found</p>
            <?php } ?> 
        </div>
    <?php } ?> 
        
        
    <?php if ( GetTrendingVideoStatus() == 1 ) { ?>
            <div class="video-list">

              <?php if ( count($trendings) > 0 ) { 
                include('partials/trending-videoloop.php');

              } else {  ?>
                    <p class="no_video"> No Video Found</p>
                <?php } ?>
            </div>
    <?php } ?>
        
        
    <?php if ( GetCategoryVideoStatus() == 1 ) { ?>
    <div class="container">
     
        <?php
            $parentCategories = App\VideoCategory::where('in_home','=',1)->get();
            foreach($parentCategories as $category) {
            $videos = App\Video::where('video_category_id','=',$category->id)->get();
        ?>
         <div class="row">
			 			 <div class="loader"></div>
         <a href="<?php echo URL::to('/category/').'/'.$category->slug;?>" class="category-heading" style="text-decoration:none;color:#fff" >
         <h4  class="movie-title">
            <?php echo __($category->name);?>  <i class="fa fa-angle-double-right" aria-hidden="true"></i>
         </h4>
         </a>
         <!-- <a href="<php echo URL::to('/').'/category/'.$category->slug;?>" class="category-heading" style="text-decoration:none;"> 
              <h4 class="Continue Watching text-left category-heading">
                  <php echo __($category->name);?> <i class="fa fa-angle-double-right" aria-hidden="true"></i> 
              </h4>
          </a>-->
             <?php if (count($videos) > 0) { 
                include('partials/category-videoloop.php');
            } else { ?>
            <p class="no_video"> <!--<?php echo __('No Video Found');?>--></p>
            <?php } ?>
         </div>
        <?php }?>
        </div>
        <?php } ?>
     </div>   
</div>

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
</script>
<script>
  $('.loader').addClass("hide-loader");
</script>

<?php //include('includes/footer-above.php'); ?>
<!--<php include('includes/footer.php'); ?>-->
<?php include('footer.blade.php'); ?>