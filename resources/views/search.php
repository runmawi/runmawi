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

</style>


<div class="container movlistt" id="home-content">
    
    <div class="new-art">
        <h4 class="Continue Watching text-left padding-top-40" >Search Result of "<?php echo $search_value;?>" Channel Videos</h4>
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
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt="">
                                    </div>
                                    <div class="block-description">
                                       <h6><?php echo __($watchlater_video->title); ?></h6>
                                       <div class="movie-time d-flex align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2">13+</div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                       </div>
                                       <div class="hover-buttons">
                                           <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">	
                                          <span class="btn btn-hover">
                                          <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                          Play Now
                                          </span>
                                           </a>
                                       </div>
                                        <div>
                                           <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $watchlater_video->id;?>">
                                                <span class="text-center thumbarrow-sec">
                                                    <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                                </span>
                                                    </button></div>
                                        </div>
                                   <!-- <div class="block-social-info">
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
        } else {?>
             <p class="no_video">No Channel Video Found</p>
            <?php } ?> 
        
    </ul>
                     </div>

    
    
</div>
 <?php if(isset($videos)) :
foreach($videos as $watchlater_video): ?>
                                <div class="modal fade thumb-cont" id="myModal<?= $watchlater_video->id;?>" role="dialog"  style="background:url('<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>') no-repeat;background-size: cover;"> 
                                    <div class="img-black-back">
                                    </div>
                                    <div align="right">
                                    <button type="button" class="btn btn-danger closewin" data-dismiss="modal"><span aria-hidden="true">X</span></button>
                                         <!--<a type="button" class="btn btn-danger closewin"  href="<?php echo URL::to('latest-videos') ?>"><span aria-hidden="true">X</span></a>-->
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
                                        <a href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" class="btn btn-hover"><i class="fa fa-play mr-2"
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
endif; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>





<?php include('footer.blade.php');?>