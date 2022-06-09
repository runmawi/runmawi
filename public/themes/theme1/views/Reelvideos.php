<?php include('header.php');  ?>


<video id="videoPlayer" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->reels_thumbnail ?>"
    controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>
            <source src="<?php echo URL::to('public/uploads/reelsVideos').'/'.$video->reelvideo;?>" type="video/mp4" label='720p' res='720'/> 
</video>

<?php include('footer.blade.php');?>
