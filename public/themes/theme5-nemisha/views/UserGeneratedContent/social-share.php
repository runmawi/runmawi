<?php

if(isset($videodetail)):
    $media_title = $videodetail->title;
    $url = URL::to('ugc/video-player');
    $media_url = $url . '/' . $videodetail->slug;
    $hidden = '<input type="hidden" value="'.$videodetail->id.'" id="videoid">';
else:
    $media_title = '';
    $media_url = '';
endif;
$media_subject = $media_title;
?>

        <input type="hidden" value="<?= $media_url ?>" id="media_url">

        <ul class="list-inline p-0 m-0 share-icons music-play-lists">
            <li class="share sharemobres"  style="display: inline-flex; margin-right: 5px; width: 45px; height: 45px;" ><span><i class="ri-share-fill"></i></span>
                <div class="share-box">
                    <div class="d-flex"> 
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>" ><i class="ri-facebook-fill"></i></a>
                        <a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>" ><i class="ri-twitter-fill"></i></a>
                    </div>
                </div>
            </li>
        </ul>


<script>
function Copy() {
    var media_path = $('#media_url').val();
  var url =  navigator.clipboard.writeText(window.location.href);
  var path =  navigator.clipboard.writeText(media_path);
  $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>');
               setTimeout(function() {
                $('.add_watch').slideUp('fast');
               }, 3000);
// console.log(url);
// console.log(media_path);
// console.log(path);
}

</script>