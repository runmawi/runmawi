<?php include('includes/header.php'); ?>

<div class="container">
    
    <div class="row">
        <div class="col-sm-12"> 
            <div class="new-art">
				<h4 class="Continue Watching text-left padding-top-40">Listen to our Latest songs!</h4>
                <div class="border-line" style="margin-bottom:15px;margin-top:20px;"></div>
        </div></div>
    </div>

<?php if(isset($allAlbums)) :
foreach($allAlbums as $audio): ?>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 new-art">
	<article class="block expand">
        <a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('audio') : URL::to('audio') ?><?= '/' . $audio->slug ?>">
			<!-- <div class="thumbnail-overlay"></div> -->
            <div class="play-button">
                <div class="play-block">
                    <i class="fa fa-play flexlink" aria-hidden="true"></i> 
                </div>
                <div class="detail-block">
                <p class="movie-title"><?= $audio->albumname; ?></p>
                </div>
            </div>
			<img src="<?php echo URL::to('/').'/content/uploads/albums/'.$audio->album;?>">
		</a>
	   <div class="block-contents">
            <p class="movie-title padding"><?php echo $audio->albumname; ?></p>
        </div>
	</article>
</div>
<?php endforeach;
endif; ?>
    
</div>


<!--<php include('includes/footer-above.php'); ?>-->
<?php include('includes/footer.php'); ?>