<?php  
    if(isset($videodetail->Reels_videos)) :
        foreach($videodetail->Reels_videos as $reel): 
?>

    <div class="sectionArtists broadcast">
        <div class="block-images position-relative" data-toggle="modal" data-target="#Reels" data-name=<?php echo $reel->reels_videos; ?>
            onclick="addvidoes(this)">
            <div class="listItem">
                <div class="profileImg">
                    <span class="lazy-load-image-background blur lazy-load-image-loaded"
                        style="color: transparent; display: inline-block;">
                        <img src="<?= optional($videodetail)->Reels_Thumbnail ?>">
                    </span>
                </div>
                <div class="name">{{ __('Reels') }}</div>
            </div>
        </div>
    </div>

<?php endforeach; endif; ?>


<!-- Reels Modal -->

<div class="modal fade" id="Reels" tabindex="-1" role="dialog" aria-labelledby="Reels" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body" id="Reels_player"> </div>
            <div class="modal-footer" style="">
                <button type="button" class="btn btn-secondary reelsclose" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Reels Player -->

<?php $ReelVideos = URL::to('public/uploads/reelsVideos') . '/'; ?>
<script src="<?= URL::to('assets/js/playerjs.js') ?>"></script>

<script>
    function addvidoes(ele) {
        var Reels_videos = $(ele).attr('data-name');
        var Reels_url = <?php echo json_encode($ReelVideos); ?>;
        var Reels = Reels_url + Reels_videos;
        var player = new Playerjs({
            id: "Reels_player",
            file: Reels,
            autoplay: 1
        });
    }

    $(document).ready(function() {
        $(".reelsclose").click(function() {
            var player = new Playerjs({
                id: "Reels_player",
                file: Reels,
                stop: 1
            });
        });
    });
</script>

<style>
    .modal-body {
        position: unset;
    }

    .modal-footer {
        background: black;
    }
</style>
