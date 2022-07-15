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
                <img src="<?php echo URL::to('/').'/public/uploads/artists/'.$artist->image;?>" alt=""  class="w-100">
            </div>
            <div class=" col-md-8 abu p-0">
                <h2>About</h2>
                <p><?php echo $artist->description;?></p>
                <div class=" mt-3 mb-5">
                     
        <div class="d-flex align-items-center">
            <div>
           
                <!-- <i  class="fa fa-play-circle-o" aria-hidden="true" style="color:#fff!important;"></i> -->
            </div>

            <?php if(Auth::User() != null ){ ?>
                <?php if($artist_following == 0){ ?>
                    <div class="flw" id="followingone" >
                        <button type="button" id="follow" class="btn btn-outline-secondary">Follow</button>
                    </div>
                <?php } ?>

                <?php if($artist_following > 0){ ?>
                    <div class="flw" id="removefollowingone">
                        <button type="button" id="removefollow" class="btn btn-outline-Danger">Remove Follow</button>
                    </div>
                <?php } ?>

                <div class="flw" id="following" >
                    <button type="button" id="follow" class="btn btn-outline-secondary">Follow</button>
                </div>

                <div class="flw" id="removefollowing" >
                    <button type="button" id="removefollow" class="btn btn-outline-Danger">Remove Follow</button>
                </div>
            <?php }else{ ?>

                <div class="flw" id="" >
                    <button type="button" id="sign_in_follow" class="btn btn-outline-secondary">Follow</button>
                </div>

            <?php }?>

            <div class="flw">
                <!-- <i class="fa fa-share-square-o" aria-hidden="true" style="color:#fff!important;"></i> -->
                <?php $media_url = URL::to('/').'/artist/'.$artist->artist_name; ?>
                <input type="hidden" value="<?= $media_url ?>" id="media_url">
                <ul class="list-inline p-0 mt-4 share-icons music-play-lists">
                <li class="share">
                    <span><i class="ri-share-fill"></i></span>
                        <div class="share-box">
                        <div class="d-flex align-items-center"> 
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>" class="share-ico"><i class="ri-facebook-fill"></i></a>
                            <a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>" class="share-ico"><i class="ri-twitter-fill"></i></a>
                            <a href="#"onclick="Copy();" class="share-ico"><i class="ri-links-fill"></i></a>
                        </div>
                    </div>
                </li>
                 </ul>

            </div>
        </div>
    </div>
            </div>
        </div>
    </div>

                <!-- Latest Videos -->

        <?php if(count($latest_audios) > 0) { ?>

            <div class="container-fluid mt-3">
                <h4 class="main-title">Latest Release</h4>
            </div>

            <div class="container-fluid mt-2">
                <div class="favorites-contens">
                        <ul class="favorites-slider list-inline  row p-0 mb-0">
                            <?php foreach ($latest_audios as $key => $latest_audio) {  ?>
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
        <?php } ?>

          <!-- Album Videos -->

        <?php if(count($albums) > 0) { ?>

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

        <?php } ?>
  
             <!-- Artist Audios -->

        <?php if(count($artist_audios) > 0) { ?>
            <div class="container-fluid mt-3">
                <h4 class="main-title">Audio</h4>
            </div>

            <div class="container-fluid mt-2">
                <div class="favorites-contens">
                            <ul class="favorites-slider list-inline  row p-0 mb-0">
                                <?php  foreach ($artist_audios as $key => $artist_audio) { ?>
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
        <?php } ?>

            <!-- Artist Series -->

        <?php if(count($artist_series) > 0) { ?>

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
        <?php } ?>

          <!-- Artist videos -->

        <?php if(count($artist_videos) > 0) { ?>

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

        <?php } ?>

<?php include('footer.blade.php'); ?>

<script>


function Copy() {
    var media_path = $('#media_url').val();
  var url =  navigator.clipboard.writeText(window.location.href);
  var path =  navigator.clipboard.writeText(media_path);
  $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>');
               setTimeout(function() {
                $('.add_watch').slideUp('fast');
               }, 3000);
}

            $('#following').hide();
            $('#removefollowing').hide();
    $('#follow').click(function(){
        var artist_id = '<?=  $artist->id ?>';
        // alert(artist_id);
         $.post('<?= URL::to('artist/following') ?>', { artist_id : artist_id, following : 1, _token: '<?= csrf_token(); ?>' },
          function(data){
            $('#following').hide();
            $('#followingone').hide();
            $('#removefollowing').show();
            // followingone removefollowingone
          });
               $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Artist Added To Your Following List </div>');
               setTimeout(function() {
                $('.add_watch').slideUp('fast');
               }, 3000);
              //  alert();             
     });




     $('#removefollow').click(function(){
        var artist_id = '<?=  $artist->id ?>';
        // alert(artist_id);
         $.post('<?= URL::to('artist/following') ?>', { artist_id : artist_id, following : 0, _token: '<?= csrf_token(); ?>' },
          function(data){
            $('#following').show();
            $('#removefollowing').hide();
            $('#removefollowingone').hide();
          });
          $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Artist Removed To Your Following List</div>');
               setTimeout(function() {
                $('.add_watch').slideUp('fast');
               }, 3000);
              //  alert();             
     });

     $("#sign_in_follow").click(function(){
        
        window.location.href = "<?php echo URL::to('/login') ; ?>";

    });

</script>