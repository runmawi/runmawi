<?php include('header.php'); ?>

<div class="container language-page" id="home-content">
<h4 style="color:#fff;"></h4>
    <div  style="margin-bottom:15px;border-bottom: 1px solid #232429;"></div>
	<div class="row page-height-lang">
	<!--<div class="slider" data-slick='{"slidesToShow": 4, "slidesToScroll": 4, "autoplay": false}'>-->
		<div class=" ">
        <?php  if(isset($lang_videos)) :
			foreach($lang_videos as $watchlater_video): ?>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 new-art latest">
	
	<article class="block expand">
		
		<div class="block-thumbnail" >
            <div class="play-button-block">
				
			<a  href="<?= ($settings->enable_https) ? secure_url('category') : URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">	
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
				</div></a>
                <div class="detail-block">
					<a class="title-dec" href="<?= ($settings->enable_https) ? secure_url('category') : URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                <p class="movie-title"><?php echo __($watchlater_video->title); ?></p>
					</a>
					
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $watchlater_video->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $watchlater_video->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
					</p>

				</div>
				
		<div>
		<button class="show-details-button" data-id="<?= $watchlater_video->id;?>">
			<span class="text-center thumbarrow-sec">
				<!--<img src="<?php echo URL::to('/').'/assets/img/arrow-white.png';?>" class="thumbarrow thumbarrow-white" alt="left-arrow">-->
				<img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
			</span>
				</button></div>
		</div>
		
				<?php if (!empty($watchlater_video->trailer)) { ?>
                        <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" data-play="hover" muted="muted">
                                    <source src="<?= $watchlater_video->trailer; ?>" type="video/mp4">
								 </video>
                            <?php } else { ?>
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="thumb-img">
			
		                   <?php } ?>  
		</div>
		<div class="block-contents">
			<!--<p class="movie-title padding"><?php echo __($watchlater_video->title); ?></p>-->
        </div>
	</article>
</div>
			<?php endforeach; 
		endif; ?>
        </div>
		        <?php  if(isset($lang_videos)) :
			foreach($lang_videos as $watchlater_video): ?>
<div class="thumb-cont" id="<?= $watchlater_video->id;?>"  style="background:url('<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>') no-repeat;background-size: cover;"> 
	<div class="img-black-back">
	</div>
	<div align="right">
	<button type="button" class="closewin btn btn-danger" id="<?= $watchlater_video->id;?>"><span aria-hidden="true">X</span></button>
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
			<a class="" href="<?= ($settings->enable_https) ? secure_url('category') : URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">	
						<div class="btn btn-danger btn-right-space br-0">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> Play
				</div></a>
    </div>
    <div id="trailer<?= $watchlater_video->id;?>" class="container tab-pane "><br>

         <div class="block expand">
		
		<a class="block-thumbnail-trail" href="<?= ($settings->enable_https) ? secure_url('category') : URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" >

		
				<?php if (!empty($watchlater_video->trailer)) { ?>
                        <video class="trail-vid" width="30%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" data-play="hover" muted="muted">
                                    <source src="<?= $watchlater_video->trailer; ?>" type="video/mp4">
								 </video>
                            <?php } else { ?>
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="thumb-img">
			
		                   <?php } ?>  
			            <div class="play-button-trail" >
				
			<a  href="<?= ($settings->enable_https) ? secure_url('category') : URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">	
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
				</div></a>
                <div class="detail-block">
					<a class="title-dec" href="<?= ($settings->enable_https) ? secure_url('category') : URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                <p class="movie-title"><?php echo __($watchlater_video->title); ?></p>
					</a>
					
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $watchlater_video->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $watchlater_video->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
					</p>

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


	
	</div></div>

<?php endforeach; 
endif; ?>
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

	</div>

</div>
    <div style="height: 10px;"></div>


 <script> 
        
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

<?php include('footer.blade.php'); ?>