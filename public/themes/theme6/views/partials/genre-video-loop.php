<?php foreach($genre_video_display as $movie): ?>

<div class="new-art">
    <article class="block expand">
        <a class="block-thumbnail" href="<?php echo URL::to('/').'/channelVideos/'.$movie->id;?>">
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= ucfirst($movie->name); ?></p>
               
                </div>
                <div class="thriller"> <p><?= $movie->name;?></p></div>
            </div>
            <img src="<?php echo URL::to('/').'/public/uploads/videocategory/'.$movie->image;  ?>" />
        </a>

     
         <div class="block-contents">
            <p class="movie-title padding"><?php echo $movie->name; ?></p>
        </div>
    </article>
</div>
<?php endforeach; ?>
