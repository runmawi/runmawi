
     <?php include('header.php');?>
   <head>
      <!-- Required meta tags -->
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Flicknexs</title>
       <!--<script type="text/javascript" src="<?php echo URL::to('/').'/assets/js/jquery.hoverplay.js';?>"></script>-->
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
      <!-- Favicon -->
      <link rel="shortcut icon" href="assets/images/fl-logo.png" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/bootstrap.min.css';?>" />
      <!-- Typography CSS -->
      <link rel="stylesheet" href="assets/css/typography.css" />
      <!-- Style -->
      <link rel="stylesheet" href="assets/css/style.css" />
      <!-- Responsive -->
      <link rel="stylesheet" href="assets/css/responsive.css" />
       
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
     
       <style>
           
           .blink_me {
    animation: blinker 2s linear infinite;
  }
  @keyframes blinker {
    50% {
      opacity: 0;
    }
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
            li.list-group-item a:hover{
             color: var(--iq-primary) !important;
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
    margin-top:-1327px !important;
           }
           .modal-footer {
    border-bottom: 0px !important;
                border-top: 0px !important;
   
} 
           
       </style>
   
       </head>
  
      <!-- loader Start -->
      <div id="loading">
         <div id="loading-center">
         </div>
      </div>
      <!-- loader END -->
      <!-- Header -->
  
      <!-- Header End -->
      <!-- Slider Start -->
      <section id="home" class="iq-main-slider p-0">
         <div id="home-slider" class="slider m-0 p-0">
             <?php if(isset($videos)) :
                    foreach($videos as $watchlater_video): ?>
              <?php 
                $i = 1;
                foreach ($banner as $key => $bannerdetails) { ?>
                <div class="item <?php if($key == 0){echo 'active';}?> header-image" >
                    <a href="<?=$bannerdetails->link;  ?>">
            <div class="slide slick-bg s-bg-1" style="background:url('<?php echo URL::to('/').'/public/uploads/images/' .$watchlater_video->image;  ?>') no-repeat;background-size: cover;">
               <div class="container-fluid position-relative h-100">
                  <div class="slider-inner h-100">
                     <div class="row align-items-center  h-100">
                        <div class="col-xl-6 col-lg-12 col-md-12">
                           <a href="javascript:void(0);">
                              <div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5">
                                 <img src="<?php echo URL::to('/').'/assets/img/logo.png'?>" class="c-logo" alt="Flicknexs">
                              </div>
                           </a>
                           <h1 class="slider-text big-title title text-uppercase" data-animation-in="fadeInLeft"
                              data-delay-in="0.6"><?php echo __($watchlater_video->title); ?></h1>
                           <div class="d-flex align-items-center" data-animation-in="fadeInUp" data-delay-in="1">
                              <span class="badge badge-secondary p-2">18+</span>
                              <span class="ml-3">2 Seasons</span>
                           </div>
                           <p data-animation-in="fadeInUp" data-delay-in="1.2">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard
                              dummy text ever since the 1500s.
                           </p>
                            <!--<p data-animation-in="fadeInUp" data-delay-in="1.2" style="overflow: hidden !important;text-overflow: ellipsis !important;height: 100px;"><?php echo __($watchlater_video->description); ?>
                           </p>-->
                           <div class="d-flex align-items-center r-mb-23" data-animation-in="fadeInUp" data-delay-in="1.2">
                              <a href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" class="btn btn-hover"><i class="fa fa-play mr-2"
                                 aria-hidden="true"></i>Play Now</a>
                              <a href="https://flicknexui.webnexs.org/" class="btn btn-link">More details</a>
                           </div>
                        </div>
                     </div>
                     <div class="trailor-video">
                        <a href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" class="video-open playbtn">
                           <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                              x="0px" y="0px" width="80px" height="80px" viewBox="0 0 213.7 213.7"
                              enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                              <polygon class='triangle' fill="none" stroke-width="7" stroke-linecap="round"
                                 stroke-linejoin="round" stroke-miterlimit="10"
                                 points="73.5,62.5 148.5,105.8 73.5,149.1 " />
                              <circle class='circle' fill="none" stroke-width="7" stroke-linecap="round"
                                 stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" />
                           </svg>
                           <span class="w-trailor">Watch Trailer</span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
             </a>
                </div>
             <?php $i++; } ?>
             <?php endforeach; 
                         endif; ?>
         </div>
         <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44" width="44px" height="44px" id="circle"
               fill="none" stroke="currentColor">
               <circle r="20" cy="22" cx="22" id="test"></circle>
            </symbol>
         </svg>
      </section>
      <!-- Slider End -->
      <!-- MainContent -->
      <div class="main-content">
          <section id="iq-continue">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12 overflow-hidden">
                     <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Continue Watching</a></h4>                      
                     </div>
                     <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                             <?php  if(isset($videos)) :
			                       foreach($videos as $watchlater_video): ?>
                           <li class="slide-item">
                              <a href="<?php echo URL::to('home') ?>">
                                 <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt="">
                                    </div>
                                    <div class="block-description">
                                        <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">	 <h6><?php echo __($watchlater_video->title); ?></h6></a>
                                       <div class="movie-time d-flex align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2">13+</div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                       </div>
                                       <div class="hover-buttons">
                                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl">
                                          <span class="btn btn-hover">
                                          <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                          Play Now
                                          </span>
                                              </button>	
                                           
                                       </div>
                                        <div >
                                            <button class="show-details-button" data-id="<?= $watchlater_video->id;?>">
                                                <span class="text-center thumbarrow-sec">
                                                    <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                                </span>
                                                    </button></div>
                                        </div>
                                    <div class="block-social-info">
                                       <ul class="list-inline  music-play-lists list-group-horizontal">
                                          <li><span><i class="ri-volume-mute-fill"></i></span></li>
                                          <li><span><i class="ri-heart-fill"></i></span></li>
                                          <li><span><i class="ri-add-line"></i></span></li>
                                       </ul>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           
                            <?php endforeach; 
		                                   endif; ?>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
              <?php  if(isset($videos)) :
			                       foreach($videos as $watchlater_video): ?>
               <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
        
       
    <div class="modal-content" style="background-color: transparent !important;">
       
         
         <div class="modal-body">
         <?php if($watchlater_video->type == 'embed'): ?>
						<div id="video_container" class="fitvid">
							<?= $watchlater_video->embed_code ?>
						</div>
					<?php  elseif($watchlater_video->type == 'file'): ?>
                                        <video controls=""  id="framevid" class="playvid" name="media"><source src="<?= $watchlater_video->trailer; ?>" type="video/mp4"></video>
                                        <?php endif; ?> </div>
        <div class="modal-footer" align="center" >
                <button type="button"   class="close btn btn-primary" data-dismiss="modal" aria-hidden="true" 
 onclick="document.getElementById('framevid').pause();" id="<?= $watchlater_video->id;?>"  ><span aria-hidden="true">X</span></button>
                  
                    </div>
         
  </div>
</div>
</div>
              <?php endforeach; 
		                                   endif; ?>
              
                          <?php if(isset($videos)) :
                                foreach($videos as $watchlater_video): ?>
                                <div class="thumb-cont" id="<?= $watchlater_video->id;?>"  style="background:url('<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>') no-repeat;background-size: cover;"> 
                                    <div class="img-black-back">
                                    </div>
                                    <div align="right">
                                    <button type="button" class="closewin btn btn-danger" id="cont_vid<?= $watchlater_video->id;?>"><span aria-hidden="true">X</span></button>
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
                                  <a class="btn btn-hover"  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>"><i class="fa fa-play mr-2" aria-hidden="true"></i>Play Now</a>
                                    </div>
        <div id="trailer<?= $watchlater_video->id;?>" class="container tab-pane "><br>

         <div class="block expand">
		
		<a class="block-thumbnail-trail" href="<? URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" >

		
				<?php if (!empty($watchlater_video->trailer)) { ?>
                        <video class="trail-vid" width="30%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>"  muted="muted">
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
        <p><?php echo __($watchlater_video->description); ?></p>

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
</section>
         <section id="iq-favorites">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12 overflow-hidden">
                     <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title"><a href="<?php echo URL::to('/latest-videos') ?>">Latest Videos</a></h4>                      
                     </div>
                     <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                             <?php  if(isset($latest_videos)) :
			                       foreach($latest_videos as $watchlater_video): ?>
                           <li class="slide-item">
                              <a href="<?php echo URL::to('home') ?>">
                                 <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt="">
                                    </div>
                                    <div class="block-description">
                                        <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                                       <h6><?php echo __($watchlater_video->title); ?></h6>
                                        </a>
                                       <div class="movie-time d-flex align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2">13+</div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                       </div>
                                       <div class="hover-buttons">
                                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl1">
                                          <span class="btn btn-hover">
                                          <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                          Play Now
                                          </span>
                                           </button>
                                       </div>
                                        <div>
                                            <button class="show-details-button" data-id="<?= $watchlater_video->id;?>">
                                                <span class="text-center thumbarrow-sec">
                                                    <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                                </span>
                                                    </button></div>
                                        </div>
                                    <div class="block-social-info">
                                       <ul class="list-inline p-0 m-0 music-play-lists">
                                          <li ><span><i class="ri-volume-mute-fill"></i></span></li>
                                          <li><span><i class="ri-heart-fill"></i></span></li>
                                          <li><span><i class="ri-add-line"></i></span></li>
                                       </ul>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           
                            <?php endforeach; 
		                                   endif; ?>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
              <?php  if(isset($latest_videos)) :
			                       foreach($latest_videos as $latest_video): ?>
              <div class="modal fade bd-example-modal-xl1" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
        
       
    <div class="modal-content" style="background-color: transparent !important;">
       
         
         <div class="modal-body">
        <?php if($latest_video->type == 'embed'): ?>
						<div id="video_container" class="fitvid">
							<?= $latest_video->embed_code ?>
						</div>
					<?php  elseif($latest_video->type == 'file'): ?>
                                        <video controls=""  id="framevid" class="playvid" name="media"><source src="<?= $latest_video->trailer; ?>" type="video/mp4"></video>
                                        <?php endif; ?> </div>
        <div class="modal-footer" align="center" >
                <button type="button"   class="close btn btn-primary" data-dismiss="modal" aria-hidden="true" 
 onclick="document.getElementById('framevid').pause();" id="<?= $latest_video->id;?>"  ><span aria-hidden="true">X</span></button>
                  
                    </div>
         
  </div>
</div>
</div>
             <?php endforeach; 
		                                   endif; ?>
                          <?php if(isset($latest_videos)) :
                                foreach($latest_videos as $watchlater_video): ?>
                                <div class="thumb-cont" id="<?= $watchlater_video->id;?>"  style="background:url('<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>') no-repeat;background-size: cover;"> 
                                    <div class="img-black-back">
                                    </div>
                                    <div align="right">
                                    <button type="button" class="closewin btn btn-danger" id="lv_vid<?= $watchlater_video->id;?>"><span aria-hidden="true">X</span></button>
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
                        <video class="trail-vid" width="30%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>"  muted="muted">
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
</section>
          
         <section id="iq-upcoming-movie">
           
              <?php if ( GetTrendingVideoStatus() == 1 ) { ?>
            <div class="video-list">

              <?php if ( count($trendings) > 0 ) { 
                include('partials/trending-videoloop.php');

              } else {  ?>
                    <p class="no_video"> No Video Found</p>
                <?php } ?>
            </div>
    <?php } ?>
         </section>
         <section id="iq-topten">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12 overflow-hidden">
                     <div class="iq-main-header d-flex align-items-center justify-content-between">
                        <h4 class="main-title topten-title-sm">Top 10 in India</h4>
                     </div>
                     <div class="topten-contens">
                        <h4 class="main-title topten-title">Top 10 in India</h4>
                        
                        <ul id="top-ten-slider" class="list-inline p-0 m-0  d-flex align-items-center">
                              <?php  if(isset($latest_videos)) :
			                       foreach($latest_videos as $watchlater_video): ?>
                           <li>
                              <a href="<?php echo URL::to('home') ?>">
                              <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt="">
                              </a>
                           </li> 
                            <?php endforeach; 
		                                   endif; ?>
                        </ul>
                        <div class="vertical_s">
                           <ul id="top-ten-slider-nav" class="list-inline p-0 m-0  d-flex align-items-center">
                                <?php  if(isset($latest_videos)) :
			                       foreach($latest_videos as $watchlater_video): ?>
                              <li>
                                 <div class="block-images position-relative active">
                                    <a href="<?php echo URL::to('home') ?>">
                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt="">
                                    </a>
                                    <div class="block-description">
                                       <h5><?php echo __($watchlater_video->title); ?></h5>
                                       <div class="movie-time d-flex align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2">10+</div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                       </div>
                                       <div class="hover-buttons">
                                          <a href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" class="btn btn-hover" tabindex="0">
                                          <i class="fa fa-play mr-1" aria-hidden="true"></i> Play Now
                                          </a>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                              <?php endforeach; 
		                                   endif; ?>
                           </ul>
                        </div>
                         
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <section id="iq-suggestede" class="s-margin">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12 overflow-hidden">
                     <div class="iq-main-header d-flex align-items-center justify-content-between">                       
                        <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Suggested For You </a></h4>                       
                     </div>
                     <div class="suggestede-contens">
                        <ul class="list-inline favorites-slider row p-0 mb-0">
                            <?php  if(isset($suggested_videos)) :
			                       foreach($suggested_videos as $watchlater_video): ?>
                           <li class="slide-item">
                              <a href="<?php echo URL::to('home') ?>">
                                 <div class="block-images position-relative">
                                    <div class="img-box">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt="">
                                    </div>
                                    <div class="block-description">
                                        <a  href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>">
                                       <h6><?php echo __($watchlater_video->title); ?></h6>
                                        </a>
                                       <div class="movie-time d-flex align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2">11+</div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></span>
                                       </div>
                                       <div class="hover-buttons">
                                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl3">
                                          <span class="btn btn-hover"><i class="fa fa-play mr-1" aria-hidden="true"></i>
                                              Play Now</span></button>
                                       </div>
                                         <div>
                                            <button class="show-details-button" data-id="<?= $watchlater_video->id;?>">
                                                <span class="text-center thumbarrow-sec">
                                                    <img src="<?php echo URL::to('/').'/assets/img/arrow-red.png';?>" class="thumbarrow thumbarrow-red" alt="right-arrow">
                                                </span>
                                                    </button>
                                        </div>
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
		                                   endif; ?>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <?php  if(isset($suggested_videos)) :
                    foreach($suggested_videos as $suggested_video): ?>
                        <div class="modal fade bd-example-modal-xl3" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content" style="background-color: transparent !important;">
                                    <div class="modal-body">
                                         <?php if($suggested_video->type == 'embed'): ?>
						<div id="video_container" class="fitvid">
							<?= $suggested_video->embed_code ?>
						</div>
					<?php  elseif($suggested_video->type == 'file'): ?>
                                        <video controls=""  id="framevid" class="playvid" name="media"><source src="<?= $suggested_video->trailer; ?>" type="video/mp4"></video>
                                        <?php endif; ?>
                                    </div>
                                    <div class="modal-footer" align="center" >
                                        <button type="button"   class="close btn btn-primary" data-dismiss="modal" aria-hidden="true" 
                                    onclick="document.getElementById('framevid').pause();" id="<?= $suggested_video->id;?>"  ><span aria-hidden="true">X</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php endforeach; 
		                                   endif; ?>
             <?php if(isset($suggested_videos)) :
                                foreach($suggested_videos as $watchlater_video): ?>
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
                        <video class="trail-vid" width="30%" height="auto" class="play-video" poster="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>"  muted="muted">
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
         </section>
        <!-- <section id="parallex" class="parallax-window" style="background:url('<?php echo URL::to('/').'/public/uploads/videocategory/';  ?>') no-repeat;background-size: cover;">
             <div id="home-slider" class="slider m-0 p-0">
                 <?php if(isset($videos)) :
                    foreach($videos as $watchlater_video): ?>
              <?php 
                $i = 1;
                foreach ($banner as $key => $bannerdetails) { ?>
                <div class="item <?php if($key == 0){echo 'active';}?> header-image" >
            <div class="container-fluid h-100">
                
               <div class="row align-items-center justify-content-center h-100 parallaxt-details">
                  <div class="col-lg-4 r-mb-23">
                     
                     <div class="text-left">
                        <a href="javascript:void(0);">
                        <img src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$bannerdetails->slider;  ?>" class="img-fluid" alt="bailey">
                        </a>
                        <div class="parallax-ratting d-flex align-items-center mt-3 mb-3">
                           <ul
                              class="ratting-start p-0 m-0 list-inline text-primary d-flex align-items-center justify-content-left">
                              <li><a href="javascript:void(0);" class="text-primary"><i class="fa fa-star"
                                 aria-hidden="true"></i></a></li>
                              <li><a href="javascript:void(0);" class="pl-2 text-primary"><i class="fa fa-star"
                                 aria-hidden="true"></i></a></li>
                              <li><a href="javascript:void(0);" class="pl-2 text-primary"><i class="fa fa-star"
                                 aria-hidden="true"></i></a></li>
                              <li><a href="javascript:void(0);" class="pl-2 text-primary"><i class="fa fa-star"
                                 aria-hidden="true"></i></a></li>
                              <li><a href="javascript:void(0);" class="pl-2 text-primary"><i class="fa fa-star-half-o"
                                 aria-hidden="true"></i></a></li>
                           </ul>
                           <span class="text-white ml-3">9.2 (lmdb)</span>
                        </div>
                        <div class="movie-time d-flex align-items-center mb-3">
                           <div class="badge badge-secondary mr-3">13+</div>
                           <h6 class="text-white"><i class="fa fa-clock-o"></i><?= gmdate('H:i:s', $watchlater_video->duration); ?></h6>
                        </div>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry...</p>
                        <div class="parallax-buttons">
                           <a href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" class="btn btn-hover">Play Now</a>
                           <a href="<?php echo URL::to('home') ?>" class="btn btn-link">More details</a>
                        </div>
                     </div>
                       
                  </div>
                  <div class="col-lg-8">
                     <div class="parallax-img">
                        <a href="<?php echo URL::to('home') ?>">
                        	<img src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$bannerdetails->slider;  ?>" class="img-fluid w-100" alt="bailey">
                        </a>
                     </div>
                  </div>
               </div>
            </div>
             </div>
                 </div>
                  <?php $i++; } ?>
             <?php endforeach; 
                         endif; ?>
             
         </section>-->
          
          
         <section id="iq-trending" class="s-margin">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12 overflow-hidden">
                     <div class="iq-main-header d-flex align-items-center justify-content-between">                      
                        <h4 class="main-title"><a href="http://flicknexui.webnexs.org/">Trending</a></h4>                        
                     </div>
                     <div class="trending-contens">
                        <ul id="trending-slider-nav" class="list-inline p-0 mb-0 row align-items-center">
                            <?php  if(isset($trending_videos)) :
			                       foreach($trending_videos as $watchlater_video): ?>
                           <li>
                              <a href="javascript:void(0);">
                                 <div class="movie-slick position-relative">
                                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt="">
                                 </div>
                              </a>
                           </li>
                            <?php endforeach; 
		                                   endif; ?>
                        </ul>
                        <ul id="trending-slider" class="list-inline p-0 m-0  d-flex align-items-center">
                            <?php  if(isset($trending_videos)) :
			                       foreach($trending_videos as $watchlater_video): ?>
                           <li>
                              <div class="tranding-block position-relative"
                                 style="background-image: url('<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>');">
                                 <div class="trending-custom-tab">
                                    <div class="tab-title-info position-relative">
                                       <ul class="trending-pills d-flex nav nav-pills justify-content-center align-items-center text-center"
                                          role="tablist">
                                          <li class="nav-item">
                                             <a class="nav-link active show" data-toggle="pill" href="#trending-data1"
                                                role="tab" aria-selected="true">Overview</a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link" data-toggle="pill" href="#trending-data2" role="tab"
                                                aria-selected="false">Episodes</a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link" data-toggle="pill" href="#trending-data3" role="tab"
                                                aria-selected="false">Trailers</a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link" data-toggle="pill" href="#trending-data4" role="tab"
                                                aria-selected="false">Similar Like This</a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="trending-content">
                                       <div id="trending-data1" class="overview-tab tab-pane fade active show">
                                          <div class="trending-info align-items-center w-100 animated fadeInUp">
                                             <a href="javascript:void(0);" tabindex="0">
                                                <div class="res-logo">
                                                   <div class="channel-logo">
                                                      <img src="<?php echo URL::to('/').'/assets/img/logo.png' ?>" class="c-logo" alt="Flicknexs">
                                                   </div>
                                                </div>
                                             </a>
                                             <h1 class="trending-text big-title text-uppercase"><?php echo __($watchlater_video->title); ?></h1>
                                             <div class="d-flex align-items-center text-white text-detail">
                                                <span class="badge badge-secondary p-3">18+</span>
                                                <span class="ml-3">3 Seasons</span>
                                                <span class="trending-year">2020</span>
                                             </div>
                                             <div class="d-flex align-items-center series mb-4">
                                                <a href="javascript:void(0);"><img src="assets/images/trending/trending-label.png"
                                                   class="img-fluid" alt=""></a>
                                                <span class="text-gold ml-3">#2 in Series Today</span>
                                             </div>
                                             <p class="trending-dec">Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                             </p>
                                             <div class="p-btns">
                                                <div class="d-flex align-items-center p-0">
                                                   <a href="<?php echo URL::to('category') ?><?= '/videos/' . $watchlater_video->slug ?>" class="btn btn-hover mr-2" tabindex="0"><i
                                                      class="fa fa-play mr-2" aria-hidden="true"></i>Play Now</a>
                                                   <a href="javascript:void(0);" class="btn btn-link" tabindex="0"><i class="ri-add-line"></i>My
                                                   List</a>
                                                </div>
                                             </div>
                                             <div class="trending-list mt-4">
                                                <div class="text-primary title">Starring: <span class="text-body">Wagner
                                                   Moura, Boyd Holbrook, Joanna</span>
                                                </div>
                                                <div class="text-primary title">Genres: <span class="text-body">Crime,
                                                   Action, Thriller, Biography</span>
                                                </div>
                                                <div class="text-primary title">This Is: <span class="text-body">Violent,
                                                   Forceful</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div id="trending-data2" class="overlay-tab tab-pane fade">
                                          <div
                                             class="trending-info align-items-center w-100 animated fadeInUp">
                                             <a href="<?php echo URL::to('home') ?>" tabindex="0">
                                                <div class="channel-logo">
                                                   <img src="<?php echo URL::to('/').'/assets/img/logo.png' ?>" class="c-logo" alt="Flicknexs">
                                                </div>
                                             </a>
                                             <h1 class="trending-text big-title text-uppercase"><?php echo __($watchlater_video->title); ?></h1>
                                             <div class="iq-custom-select d-inline-block sea-epi">
                                                <select name="cars" class="form-control season-select">
                                                   <option value="season1">Season 1</option>
                                                   <option value="season2">Season 2</option>
                                                   <option value="season3">Season 3</option>
                                                </select>
                                             </div>
                                             <div class="episodes-contens mt-4">
                                                <div class="owl-carousel owl-theme episodes-slider1 list-inline p-0 mb-0">
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="<?php echo URL::to('/').'/public/uploads/images/'.$watchlater_video->image;  ?>" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">1</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 1</a>
                                                            <span class="text-primary">2.25 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <!--<div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/02.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">2</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 2</a>
                                                            <span class="text-primary">3.23 m</span>
                                                         </div>
                                                         <p class="mb-0">
                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/03.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">3</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 3</a>
                                                            <span class="text-primary">2 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/04.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">4</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 4</a>
                                                            <span class="text-primary">1.12 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/05.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">5</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 5</a>
                                                            <span class="text-primary">2.54 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>-->
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div id="trending-data3" class="overlay-tab tab-pane fade">
                                          <div
                                             class="trending-info align-items-center w-100 animated fadeInUp">
                                             <a href="javascript:void(0);" tabindex="0">
                                                <div class="channel-logo">
                                                   <img src="<?php echo URL::to('/').'/assets/img/logo.png' ?>" class="c-logo" alt="Flicknexs">
                                                </div>
                                             </a>
                                             <h1 class="trending-text big-title text-uppercase"><?php echo __($watchlater_video->title); ?></h1>
                                             <div class="episodes-contens mt-4">
                                                <div class="owl-carousel owl-theme episodes-slider1 list-inline p-0 mb-0">
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>" target="_blank">
                                                         <img src="assets/images/episodes/01.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">1</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" target="_blank" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>" target="_blank">Trailer 1</a>
                                                            <span class="text-primary">2.25 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>" target="_blank">
                                                         <img src="assets/images/episodes/02.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">2</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" target="_blank" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>" target="_blank">Trailer 2</a>
                                                            <span class="text-primary">3.23 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>" target="_blank">
                                                         <img src="assets/images/episodes/03.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">3</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" target="_blank" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>" target="_blank">Trailer 3</a>
                                                            <span class="text-primary">2 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>" target="_blank">
                                                         <img src="assets/images/episodes/04.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">4</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" target="_blank" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>" target="_blank">Trailer 4</a>
                                                            <span class="text-primary">1.12 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>" target="_blank">
                                                         <img src="assets/images/episodes/05.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">5</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" target="_blank" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>" target="_blank">Trailer 5</a>
                                                            <span class="text-primary">2.54 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div id="trending-data4" class="overlay-tab tab-pane fade">
                                          <div
                                             class="trending-info align-items-center w-100 animated fadeInUp">
                                             <a href="javascript:void(0);" tabindex="0">
                                                <div class="channel-logo">
                                                   <img src="<?php echo URL::to('/').'/assets/img/logo.png' ?>" class="c-logo" alt="Flicknexs">
                                                </div>
                                             </a>
                                             <h1 class="trending-text big-title text-uppercase"><?php echo __($watchlater_video->title); ?></h1>
                                             <div class="episodes-contens mt-4">
                                                <div class="owl-carousel owl-theme episodes-slider1 list-inline p-0 mb-0">
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/01.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">1</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 1</a>
                                                            <span class="text-primary">2.25 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/02.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">2</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 2</a>
                                                            <span class="text-primary">3.23 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/03.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">3</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 3</a>
                                                            <span class="text-primary">2 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/04.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">4</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 4</a>
                                                            <span class="text-primary">1.12 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                   <div class="e-item">
                                                      <div class="block-image position-relative">
                                                         <a href="<?php echo URL::to('home') ?>">
                                                         <img src="assets/images/episodes/05.jpg" class="img-fluid" alt="">
                                                         </a>
                                                         <div class="episode-number">5</div>
                                                         <div class="episode-play-info">
                                                            <div class="episode-play">
                                                               <a href="<?php echo URL::to('home') ?>" tabindex="0"><i
                                                                  class="ri-play-fill"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="episodes-description text-body mt-2">
                                                         <div class="d-flex align-items-center justify-content-between">
                                                            <a href="<?php echo URL::to('home') ?>">Episode 5</a>
                                                            <span class="text-primary">2.54 m</span>
                                                         </div>
                                                         <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                         </p>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </li>
                            <?php endforeach; 
		                                   endif; ?>
                           
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <section id="iq-tvthrillers" class="s-margin">
             <?php if ( GetCategoryVideoStatus() == 1 ) { ?>
    <div class="container">
     
        <?php
            $parentCategories = App\VideoCategory::where('in_home','=',1)->get();
            foreach($parentCategories as $category) {
            $videos = App\Video::where('video_category_id','=',$category->id)->get();
        ?>
         <div class="row">
         <!--<a href="<?php echo URL::to('/category/').'/'.$category->slug;?>" class="category-heading" style="text-decoration:none;color:#fff" >
         <h4  class="movie-title">
            <?php echo __($category->name);?> 
         </h4>
         </a>-->
			  <div style="border-bottom: 1px solid #232429;"></div>
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
         </section>
      </div>


      <!-- MainContent End-->
      <!-- back-to-top -->
      <div id="back-to-top">
         <a class="top" href="#top" id="top"> <i class="fa fa-angle-up"></i> </a>
      </div>
    <!-- MainContent End-->
      <!-- back-to-top -->
      <div id="back-to-top">
         <a class="top" href="#top" id="top"> <i class="fa fa-angle-up"></i> </a>
      </div>
      <!-- back-to-top End -->
      <!-- jQuery, Popper JS -->
      <script src="assets/js/jquery-3.4.1.min.js"></script>
      <script src="assets/js/popper.min.js"></script>
      <!-- Bootstrap JS -->
      <script src="assets/js/bootstrap.min.js"></script>
      <!-- Slick JS -->
      <script src="assets/js/slick.min.js"></script>
      <!-- owl carousel Js -->
      <script src="assets/js/owl.carousel.min.js"></script>
      <!-- select2 Js -->
      <script src="assets/js/select2.min.js"></script>
      <!-- Magnific Popup-->
      <script src="assets/js/jquery.magnific-popup.min.js"></script>
      <!-- Slick Animation-->
      <script src="assets/js/slick-animation.min.js"></script>
      <!-- Custom JS-->
      <script src="assets/js/custom.js"></script>
<script>
  // Prevent closing from click inside dropdown
  $(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
  });
    
  // make it as accordion for smaller screens
  if ($(window).width() < 960) {
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
<script type="text/javascript">
    $(document).ready(function(){
      $('.bd-example-modal-xl').modal({
          show: false
      }).on('hidden.bs.modal', function(){
          $(this).find('video')[0].pause();
      });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
      $('.bd-example-modal-xl1').modal({
          show: false
      }).on('hidden.bs.modal', function(){
          $(this).find('video')[0].pause();
      });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
      $('.bd-example-modal-xl2').modal({
          show: false
      }).on('hidden.bs.modal', function(){
          $(this).find('video')[0].pause();
      });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
      $('.bd-example-modal-xl3').modal({
          show: false
      }).on('hidden.bs.modal', function(){
          $(this).find('video')[0].pause();
      });
    });
</script>
<script type="text/javascript">
     $(document).ready(function(){
   $('.bd-example-modal-xl').on('hidden.bs.modal', function() {
  $('iframe').contents().find('video')[0].pause();
});
          });
</script>
       
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



<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
    

      <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->
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
 
       <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>-->




    <?php include('footer.blade.php');?>