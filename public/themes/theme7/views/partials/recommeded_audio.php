<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>-->

 <!-- MainContent iq-favorites-->
<section id="">
            <div class="">
               <div class="row">
                  <div class="col-sm-12 ">
                     <div class="iq-main-header align-items-center justify-content-between">
                        <!--<h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Latest Videos</a></h4> -->                     
                     </div>
                     <div class="favorites-contens ml-2">
                        <ul class="favorites-slider list-inline row mb-0">
                            <?php if(isset($recommended_audios)) :
                           foreach($recommended_audios as $recommended): ?>

                           <li class="slide-item">
                             <div class="block-images position-relative">
                              <!-- block-images -->
                              
                              <div class="border-bg">
                                <div class="img-box">
                                  <a href="<?php echo URL::to('audio')?><?='/' .$recommended->slug ?>">
                                       <img src="<?php echo URL::to('/').'/public/uploads/images/'.$recommended->image;  ?>" class="img-fluid w-100" alt="recom">
                                  </a>
                                </div>
                                    <div class="block-description">
                                       <h6><?php  echo (strlen($recommended->title) > 15) ? substr($recommended->title,0,15).'...' : $recommended->title; ?></h6>
                                       <div class="movie-time  align-items-center my-2">
                                          <div class="badge badge-secondary p-1 mr-2"><?php echo $recommended->age_restrict.' '.'+' ?></div>
                                          <span class="text-white"><i class="fa fa-clock-o"></i> <?= gmdate('H:i:s', $recommended->duration); ?></span>
                                       </div>
                                       <div class="hover-buttons">
                                           <a  href="<?php echo URL::to('audio')?><?='/' .$recommended->slug ?>">	
                                          <span class="text-white">
                                          <i class="fa fa-play mr-1" aria-hidden="true"></i>
                                          <?= __('Play Now') ?>
                                          </span>
                                           </a>
                                       </div>
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
</section>



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




   