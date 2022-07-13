<?php include('header.php'); ?>
<style>
    .main-title{
        padding-bottom: 0px!important;
    }
</style>

<!--<div class="aud" style="background-image:url(<?php echo URL::to('/').'/public/uploads/artists/'.$artist->image;?>)">
        <h2 class="font-weight-bold"><?php echo $artist->artist_name;?></h2>
        <!-- <p>8,239,0056 Monthly viewers</p>
    </div> -->
    
    <div class="mt-5 container-fluid">
        <div class="row justify-content-between  align-items-center">
            <div class="col-md-4">
                <img src="<?php echo URL::to('/').'/public/uploads/artists/'.$artist->image;?>" alt="" height="300" class="w-100">
            </div>
            <div class=" col-md-8 abu p-0">
                <h2>About</h2>
                <p><?php echo $artist->description;?></p>
                <div class=" mt-3 mb-5">
        <div class="d-flex align-items-center">
            <div>
                <i  class="fa fa-play-circle-o" aria-hidden="true" style="color:#fff!important;"></i>
            </div>
            <div class="flw">
                <button type="button" class="btn btn-outline-secondary">Follow</button>

            </div>
            <div class="flw">
                <i class="fa fa-share-square-o" aria-hidden="true" style="color:#fff!important;"></i>
            </div>
        </div>
    </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-3">
        <h4 class="main-title">Lastest Release</h4>
    </div>
    <div class="container-fluid mt-2">
       <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
<?php foreach ($latest_audios as $key => $latest_audio) { 
        		?>
                       <li class="slide-item">
                            <a href="<?php echo URL::to('/').'/audio/'.$latest_audio[0]['slug'];?>">
                             <div class="block-images position-relative">
                             <!-- block-images -->
                                <div class="img-box">
                                <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_audio[0]['image'];?>" alt="" class="img-fluid loading w-100">

                                       
                                 </div>
                             

                                <div class="block-description">
                                 
                                
                                  <div class="hover-buttons text-white">
                                           <a href="<?php echo URL::to('/').'/audio/'.$latest_audio[0]['slug'];?>">
                                           <h6 class="dc"><?php echo $latest_audio[0]['title'];?></h6>
                            <p><?php echo $latest_audio[0]['year'];?></p>
                                        </a>
                                   <i class="fa fa-eye" aria-hidden="true"></i>
                                    </div>
                                </div>
                              </div>
                          </a>
                       </li>
                       <?php } ?>
                    </ul>
                 </div>




    </div>
    <div class="container-fluid mt-3">
        <h4 class="main-title">Album</h4>
    </div>
    <div class="container-fluid mt-2">
        <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
<?php foreach ($albums as $key => $album) { ?>
                       <li class="slide-item">
                          <a href="<?php echo URL::to('/').'/album/'.$album->slug;?>">
                             <div class="block-images position-relative">
                             <!-- block-images -->
                                <div class="img-box">
                                <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/albums/'.$album->album;?>" alt="" class="img-fluid loading w-100">

                                       
                                 </div>
                             

                                <div class="block-description">
                                 
                                
                                  <div class="hover-buttons text-white">
                                          <a href="<?php echo URL::to('/').'/album/'.$album->slug;?>">
                                            <h6 class=""><?php echo $album->albumname;?></h6>
                                        </a>
                                   <i class="fa fa-eye" aria-hidden="true"></i>
                                    </div>
                                </div>
                              </div>
                          </a>
                       </li>
                       <?php } ?>
                    </ul>
                 </div>
    </div>
  
    <div class="container-fluid mt-3">
        <h4 class="main-title">Audio</h4>
    </div>
    <div class="container-fluid mt-2">
       <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
<?php  foreach ($artist_audios as $key => $artist_audio) { 
        		?>
                       <li class="slide-item">
                         <a href="<?php echo URL::to('/').'/audio/'.$artist_audio->slug;?>">
                             <div class="block-images position-relative">
                             <!-- block-images -->
                                <div class="img-box">
                                <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$artist_audio->image;?>" alt="" class="img-fluid loading w-100">

                                       
                                 </div>
                             

                                <div class="block-description">
                                 
                                
                                  <div class="hover-buttons text-white">
                                          <a href="<?php echo URL::to('/').'/audio/'.$artist_audio->slug;?>">
                                             <h6 class="dc"><?php echo $artist_audio->title;?></h6>
                            <p><?php echo $artist_audio->year;?></p>
                                        </a>
                                   <i class="fa fa-eye" aria-hidden="true"></i>
                                    </div>
                                </div>
                              </div>
                          </a>
                       </li>
                       <?php } ?>
                    </ul>
                 </div>

    </div>
    <div class="container-fluid mt-3">
        <h4 class="main-title">Series</h4>
    </div>
    <div class="container-fluid mt-2">
       <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                      <?php  foreach ($artist_series as $key => $artist_serie) { 
        		?>
                       <li class="slide-item">
                        <a href="<?php echo URL::to('/').'/play_series/'.$artist_serie->id;?>">
                             <div class="block-images position-relative">
                             <!-- block-images -->
                                <div class="img-box">
                                <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$artist_serie->image;?>" alt="" class="img-fluid loading w-100">

                                       
                                 </div>
                             

                                <div class="block-description">
                                 
                                
                                  <div class="hover-buttons text-white">
                                         <a href="<?php echo URL::to('/').'/play_series/'.$artist_serie->id;?>">
                                              <h6 class=""><?php echo $artist_serie->title;?></h6>
                            <p><?php echo $artist_serie->year;?></p>
                                          
                                        </a>
                                   <i class="fa fa-eye" aria-hidden="true"></i>
                                    </div>
                                </div>
                              </div>
                          </a>
                       </li>
                       <?php } ?>
                    </ul>
                 </div>




    </div>
    <div class="container-fluid mt-3">
        <h4 class="main-title">Videos</h4>
    </div>
    <div class="container-fluid mt-2">
        <div class="favorites-contens">
                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                       <?php  foreach ($artist_videos as $key => $artist_video) { 
                ?>  
                       <li class="slide-item">
                         <a href="<?php echo URL::to('/').'/category/videos/'.$artist_video->slug;?>">
                             <div class="block-images position-relative">
                             <!-- block-images -->
                                <div class="img-box">
                                <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$artist_video->image;?>" alt="" class="img-fluid loading w-100">

                                       
                                 </div>
                             

                                <div class="block-description">
                                 
                                
                                  <div class="hover-buttons text-white">
                                        <a href="<?php echo URL::to('/').'/category/videos/'.$artist_video->slug;?>">
                                             <h6 class="dc"><?php echo $artist_video->title;?></h6>
                                            <p><?php echo $artist_video->year;?></p>
                                          
                                        </a>
                                   <i class="fa fa-eye" aria-hidden="true"></i>
                                    </div>
                                </div>
                              </div>
                          </a>
                       </li>
                       <?php } ?>
                    </ul>
                 </div>
    </div>
<?php include('footer.blade.php'); ?>