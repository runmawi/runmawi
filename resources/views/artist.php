<?php include('header.php'); ?>
<div class="aud mt-5" style="background-image:url(<?php echo URL::to('/').'/public/uploads/artists/'.$artist->image;?>)">
        <h2 class="font-weight-bold"><?php echo $artist->artist_name;?></h2>
        <!-- <p>8,239,0056 Monthly viewers</p> -->
    </div>
    <div class="m-5 mt-3">
        <div class="d-flex align-items-center">
            <div>
                <i class="fa fa-play-circle-o" aria-hidden="true"></i>
            </div>
            <div class="flw">
                <button type="button" class="btn btn-outline-secondary">Follow</button>

            </div>
            <div class="flw">
                <i class="fa fa-share-square-o" aria-hidden="true"></i>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <div class="d-flex justify-content-between m-4 align-items-center">
            <div>
                <img src="<?php echo URL::to('/').'/public/uploads/artists/'.$artist->image;?>" alt="" height="350" width="200">
            </div>
            <div class="abu p-2">
                <h2>About</h2>
                <p><?php echo $artist->description;?></p>
            </div>
        </div>
    </div>
    <div class="m-4 mt-3">
        <h2>Lastest Release</h2>
    </div>
    <div class="container">
        <div class="row">
        	<?php foreach ($latest_audios as $key => $latest_audio) { 
        		?>
        		
            <div class="col-sm-4">
                <div class="bg">
                    <img src="<?php echo URL::to('/').'/public/uploads/images/'.$latest_audio[0]['image'];?>" alt="" height="200" width="300">
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
            </div>
        <?php } ?>
        </div>
    </div>
    <div class="m-4 mt-3">
        <h2>Album</h2>
    </div>
    <div class="container">
        <div class="row">
        	<?php foreach ($albums as $key => $album) { ?>
        		
            <div class="col-sm-4">
                <div class="bg">
                    <img src="<?php echo URL::to('/').'/public/uploads/albums/'.$album->album;?>" alt="" height="200" width="300">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="dc"><?php echo $album->albumname;?></p>
                        </div>
                        <div>
                            <i class="fa fa-eye" aria-hidden="true"></i>

                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
   <!--  <div class="m-4 mt-3">
        <h2>Music Concert</h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="bg">
                    <img src="1.png" alt="" height="200" width="300">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="dc">Dear Camrod</p>
                            <p>2018</p>
                        </div>
                        <div>
                            <i class="fa fa-eye" aria-hidden="true"></i>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
<?php include('footer.blade.php'); ?>