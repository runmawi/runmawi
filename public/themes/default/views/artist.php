<?php include('header.php'); ?>

<div class="aud" style="background-image:url(<?php echo URL::to('/').'/public/uploads/artists/'.$artist->image;?>)">
        <h2 class="font-weight-bold"><?php echo $artist->artist_name;?></h2>
        <!-- <p>8,239,0056 Monthly viewers</p> -->
    </div>
    <div class="container-fluid mt-3">
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
    <div class="mt-3 container-fluid">
        <div class="row justify-content-between m-4 align-items-center">
            <div class="col-md-6">
                <img src="<?php echo URL::to('/').'/public/uploads/artists/'.$artist->image;?>" alt="" width="250" >
            </div>
            <div class=" col-md-6 abu p-2">
                <h2>About</h2>
                <p><?php echo $artist->description;?></p>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3">
        <h4 class="main-title">Lastest Release</h4>
    </div>
    <div class="container-fluid mt-2">
        <div class="row mb-5">
        	<?php foreach ($latest_audios as $key => $latest_audio) { 
        		?>
        		
            <div class="col-sm-4">
                <a href="<?php echo URL::to('/').'/audio/'.$latest_audio[0]['slug'];?>">
                <div class="bg">
                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_audio[0]['image'];?>" alt="" width="300">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="dc"><?php echo $latest_audio[0]['title'];?></p>
                            <p><?php echo $latest_audio[0]['year'];?></p>
                        </div>
                        <div>
                            <i class="fa fa-eye" aria-hidden="true"></i>

                        </div>
                    </div>
                </div>
                </a>
            </div>
        <?php } ?>
        </div>
    </div>
    <div class="container-fluid mt-3">
        <h4 class="main-title">Album</h4>
    </div>
    <div class="container-fluid mt-2">
        <div class="row mb-5">
        	<?php foreach ($albums as $key => $album) { ?>
        		
            <div class="col-sm-4">
                <a href="<?php echo URL::to('/').'/album/'.$album->slug;?>">
                <div class="bg">
                    <img src="<?php echo URL::to('/').'/public/uploads/albums/'.$album->album;?>" alt="" width="300">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="dc"><?php echo $album->albumname;?></p>
                        </div>
                        <div>
                            <i class="fa fa-eye" aria-hidden="true"></i>

                        </div>
                    </div>
                </div>
            </a>
            </div>
            <?php } ?>
        </div>
    </div>
  
    <div class="container-fluid mt-3">
        <h4 class="main-title">Audio</h4>
    </div>
    <div class="container-fluid mt-2">
        <div class="row mb-5">
        	<?php  foreach ($artist_audios as $key => $artist_audio) { 
        		?>
        		
            <div class="col-sm-4">
                <a href="<?php echo URL::to('/').'/audio/'.$artist_audio->slug;?>">
                <div class="bg">
                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$artist_audio->image;?>" alt="" width="300">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="dc"><?php echo $artist_audio->title;?></p>
                            <p><?php echo $artist_audio->year;?></p>
                        </div>
                        <div>
                            <i class="fa fa-eye" aria-hidden="true"></i>

                        </div>
                    </div>
                </div>
            </a>
            </div>
        <?php } ?>
        </div>
    </div>
    <div class="container-fluid mt-3">
        <h4 class="main-title">Series</h4>
    </div>
    <div class="container-fluid mt-2">
        <div class="row mb-5">
        	<?php  foreach ($artist_series as $key => $artist_serie) { 
        		?>
        		
            <div class="col-sm-4">
                <a href="<?php echo URL::to('/').'/play_series/'.$artist_serie->id;?>">
                <div class="bg">
                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$artist_serie->image;?>" alt="" width="300">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="dc"><?php echo $artist_serie->title;?></p>
                            <p><?php echo $artist_serie->year;?></p>
                        </div>
                        <div>
                            <i class="fa fa-eye" aria-hidden="true"></i>

                        </div>
                    </div>
                </div>
            </a>
            </div>
        <?php } ?>
        </div>
    </div>
    <div class="container-fluid mt-3">
        <h4 class="main-title">Videos</h4>
    </div>
    <div class="container-fluid mt-2">
        <div class="row mb-5">
            <?php  foreach ($artist_videos as $key => $artist_video) { 
                ?>
                
            <div class="col-sm-4">
                <a href="<?php echo URL::to('/').'/category/videos/'.$artist_video->slug;?>">
                <div class="bg">
                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$artist_video->image;?>" alt="" width="300">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="dc"><?php echo $artist_video->title;?></p>
                            <p><?php echo $artist_video->year;?></p>
                        </div>
                        <div>
                            <i class="fa fa-eye" aria-hidden="true"></i>

                        </div>
                    </div>
                </div>
            </a>
            </div>
        <?php } ?>
        </div>
    </div>
<?php include('footer.blade.php'); ?>