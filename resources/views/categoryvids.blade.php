@include('header')
<script type="text/javascript" src="<?php echo URL::to('/').'/assets/js/jquery.hoverplay.js';?>"></script>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
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


</style>

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
 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo URL::to('/').'/assets/js/jquery.hoverplay.js';?>"></script>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

<?php

$settings = App\Setting::all();

?>

<div class="container">
     <div id="channel-content">  
  <div class="video-list-cat page-height">
            <h4 class="Continue Watching"><?php echo __($data['category_title']);?></h4>
      <div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>
      <?php if (count($data['categoryVideos']) > 0) { ?>
            <div class="">
                    @foreach($data['categoryVideos']  as $video)  
                <div class="new-art col-sm-3">
                            <article class="block expand">
                               <div class="block-thumbnail"  > 
								
                                    <div class="play-button-cat-vid">
										<a href="<?=  URL::to('category') ?><?= '/videos/' . $video->slug ?>">
                                        <div class="play-block">
                                            <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                                        </div>
									</a>
                                        <div class="detail-block">
										<a href="<?=  URL::to('category') ?><?= '/videos/' . $video->slug ?>">	
                                        <p class="movie-title"><?php echo __($video->title); ?></p>
											</a>	
                                        <p class="movie-rating">
                                            <span class="star-rate"><i class="fa fa-star"></i><?= $video->rating;?></span>
                                            <span class="viewers"><i class="fa fa-eye"></i>(<?= $video->views;?>)</span> 
                                                                <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $video->duration); ?></span>
                                        </p>
                                        </div>
                                        <!--<div class="thriller"> <p><?php echo __($video->title);?></p></div>-->
										<div>
		<button class="show-details-button" data-id="<?= $video->id;?>">
			<span class="text-center thumbarrow-sec">
				<!--<img src="<?php echo URL::to('/').'/assets/img/arrow-white.png';?>" class="thumbarrow thumbarrow-white" alt="left-arrow">-->
				<img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
			</span>
				</button></div>
                                    </div>
                                     <?php if (!empty($video->trailer)) { ?>

                                <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" data-play="hover" muted="muted">
                                    <source src="<?= $video->trailer; ?>" type="video/mp4">
                                </video>
                            <?php } else { ?>
                                <img class="thumb-img" src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>">
                            <?php } ?>
								</div>

                                 <div class="block-contents">
                                    <!--<p class="movie-title padding"><?php echo __($video->title); ?></p>-->
                                </div>
                            </article>
                    </div>
                        @endforeach
            </div>
      </div>
      <?php } else { ?>
            <p class="no_video"> <?php echo __('No Video Found');?></p>
      <?php } ?>
		 </div>
          <?php echo $data['categoryVideos']->links("pagination::bootstrap-4");?>
    </div>
    
</div>

@extends('footer')