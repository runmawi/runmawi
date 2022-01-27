

<?php if(isset($recomended)) :
foreach($recomended as $video): ?>
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 new-art">
	<article class="block expand">
		
		<div class="block-thumbnail" >
            <div class="play-button-block">
				
			<a  href="<?= ($settings->enable_https) ? secure_url('category') : URL::to('category') ?><?= '/videos/' . $video->slug ?>">	
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
				</div></a>
                <div class="detail-block">
					<a class="title-dec" href="<?= ($settings->enable_https) ? secure_url('category') : URL::to('category') ?><?= '/videos/' . $video->slug ?>">
                <p class="movie-title"><?php echo __($video->title); ?></p>
					</a>
					
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $video->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $video->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $video->duration); ?></span>
					</p>

				</div>
				
		<div>
		<button class="show-details-button" data-id="<?= $video->id;?>">
			<span class="text-center thumbarrow-sec">
				<!--<img src="<?php echo URL::to('/').'/assets/img/arrow-white.png';?>" class="thumbarrow thumbarrow-white" alt="left-arrow">-->
				<img  src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
			</span>
				</button></div>
		</div>
		
				<?php if (!empty($video->trailer)) { ?>
                        <video width="100%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" data-play="hover" muted="muted">
                                    <source src="<?= $video->trailer; ?>" type="video/mp4">
								 </video>
                            <?php } else { ?>
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" class="thumb-img">
			
		                   <?php } ?>  
		</div>
		<div class="block-contents">
			<!--<p class="movie-title padding"><?php echo __($video->title); ?></p>-->
        </div>
	</article>
</div>
<?php endforeach; 
else: ?>
	<p class="no_video">No  Video Found</p>
<?php endif; ?>
<!--<?php if(isset($recomended)) :
foreach($recomended as $video): ?>
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
			<a class="" href="<?= ($settings->enable_https) ? secure_url('category') : URL::to('category') ?><?= '/videos/' . $video->slug ?>">	
						<div class="btn btn-danger btn-right-space br-0">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> Play
				</div></a>
    </div>
    <div id="trailer<?= $video->id;?>" class="container tab-pane "><br>

         <div class="block expand">
		
		<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('category') : URL::to('category') ?><?= '/videos/' . $video->slug ?>" >

		
				<?php if (!empty($video->trailer)) { ?>
                        <video class="trail-vid" width="30%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" data-play="hover" muted="muted">
                                    <source src="<?= $video->trailer; ?>" type="video/mp4">
								 </video>
                            <?php } else { ?>
                                <img src="<?php echo URL::to('/').'/public/uploads/images/'.$video->image;  ?>" class="thumb-img">
			
		                   <?php } ?>  
			            <div class="play-button-trail" >
				
			<a  href="<?= ($settings->enable_https) ? secure_url('category') : URL::to('category') ?><?= '/videos/' . $video->slug ?>">	
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
				</div></a>
                <div class="detail-block">
					<a class="title-dec" href="<?= ($settings->enable_https) ? secure_url('category') : URL::to('category') ?><?= '/videos/' . $video->slug ?>">
                <p class="movie-title"><?php echo __($video->title); ?></p>
					</a>
					
                <p class="movie-rating">
                    <span class="star-rate"><i class="fa fa-star"></i><?= $video->rating;?></span>
                    <span class="viewers"><i class="fa fa-eye"></i>(<?= $video->views;?>)</span>
                    <span class="running-time"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $video->duration); ?></span>
					</p>

				</div>
		</div>
		</a>
		<div class="block-contents">
			<p class="movie-title padding"><?php echo __($video->title); ?></p>
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


	
	</div></div>

<?php endforeach; 
endif; ?>-->
<!--
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
-->

