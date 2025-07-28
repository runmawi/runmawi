<?php
if(isset($ModeratorsUser)):
    $media_title = $ModeratorsUser->slug;
    $url = URL::to('/contentpartner/');
    $media_url = $url . '/' . $ModeratorsUser->slug;
    $hidden = '<input type="hidden" value="'.$ModeratorsUser->id.'" id="videoid">';
else:
    $media_title = '';
    $media_url = '';
endif;
$media_subject = $media_title;
?>
<style>
i#dislike {
    padding: 10px !important;
}
i#like {
    padding: 10px;
}
</style>
<input type="hidden" value="<?= $media_url ?>" id="media_url">

<!-- Buttons start here. Copy this ul to your document. -->
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




<script>

</script>
<script>
function Copy() {
    var media_path = $('#media_url').val();
  var url =  navigator.clipboard.writeText(window.location.href);
  var path =  navigator.clipboard.writeText(media_path);
  $("body").append('<div class="channel_social_share" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>');
               setTimeout(function() {
                $('.channel_social_share').slideUp('fast');
               }, 3000);
}
</script>