
<div id="player">
<video id="" class="" poster="<?= URL::to('/') . '/public/uploads/images/' . $video->image ?>"
    controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}'>
            <source src="<?php echo URL::to('public/uploads/reelsVideos').'/'.$video->reelvideo;?>" type="video/mp4" label='720p' res='720'/> 
</video>


</div>
<?php
$EndSec = URL::to('public/uploads/reelsVideos').'/'.$video->reelvideo;
?>

<script src="<?= URL::to('/'). '/assets/js/playerjs.js';?>"></script>


<script>

var End = <?php echo json_encode($EndSec); ?>;

    
    alert(End);
    var player = new Playerjs({id:"player", file:End});
</script>