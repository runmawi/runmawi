<?php

if(isset($video)):
    $media_title = $video->title;
    $url = URL::to('/category/videos');
    $embed_url = URL::to('/category/videos/embed');
    $media_url = $url . '/' . $video->slug;
    $embed_media_url = $embed_url . '/' . $video->slug;
    $hidden = '<input type="hidden" value="'.$video->id.'" id="videoid">';
elseif(isset($audio)):
    $media_title = $audio->title;
    $url = URL::to('/');
    $media_url = $url . '/' . $audio->slug;
    $hidden = '<input type="hidden" value="'.$audio->id.'" id="audioid">';
elseif(isset($post)):
    $media_title = $post->title;
    $url = URL::to('post');
    $media_url = $url . '/' . $post->slug; 
    $hidden = '<input type="hidden" value="'.$post->id.'" id="videoid">';
elseif(isset($movie)):
    $media_title = $movie->title;
    $url = URL::to('play_movie');
    $media_url = $url . '/' . $movie->slug; 
    $hidden = '<input type="hidden" value="'.$movie->id.'" id="videoid">';
elseif(isset($episode)):
    $media_title = $episode->title;
    $url = URL::to('episode');
    $media_url = $url . '/' . $episode->id; 
    $hidden = '<input type="hidden" value="'.$episode->id.'" id="videoid">';
elseif(isset($series)):
    $media_title = $series->title;
    $url = URL::to('play_series');
    $media_url = $url . '/' . $series->slug; 
    $hidden = '<input type="hidden" value="'.$series->id.'" id="videoid">';
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
<?php
$url_path = '<iframe width="853" height="480" src="'.$embed_media_url.'" frameborder="0" allowfullscreen></iframe>';
?>
<!-- Buttons start here. Copy this ul to your document. -->
<ul class="list-inline p-0 m-0 share-icons music-play-lists">
                                        <!-- Share -->
                                <li class="share sharemobres" style="display: inline-flex; margin-right: 5px; width: 45px; height: 45px;" >
                                    <span >
                                    <i class="ri-share-fill"></i>
                                    </span>
                                    <div class="share-box">
                                        <div class="d-flex align-items-center"> 
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>" class="share-ico"><i class="ri-facebook-fill"></i></a>
                                            <a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>" class="share-ico"><i class="ri-twitter-x-fill"></i></a>
                                            <a href="#"onclick="Copy();" class="share-ico"><i class="ri-links-fill"></i></a>
                                        </div>
                                    </div>
                                </li>
                            </ul>

<!-- <li class="share">
<span><i class="ri-share-fill"></i></span>
    <div class="share-box">
       <div class="d-flex align-items-center"> 
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>" class="share-ico"><i class="ri-facebook-fill"></i></a>
          <a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>" class="share-ico"><i class="ri-twitter-x-fill"></i></a>
          <a href="#"onclick="Copy();" class="share-ico"><i class="ri-links-fill"></i></a>
       </div>
    </div>
</li>

<li>
    <span><i  <?php if((isset($like_dislike[0]) && $like_dislike[0]->liked == 1 )): ?> class="ri-thumb-up-fill" <?php else: ?> class="ri-thumb-up-line" <?php endif; ?> <?php if( isset($like_dislike[0]) && $like_dislike[0]->liked == 1 ) { echo 'active';}?> aria-hidden="true" style="cursor:pointer;" data-like-val="1" like="1" id="like"  ></i></span>
</li>
<li>
    <span><i <?php if((isset($like_dislike[0]) && $like_dislike[0]->disliked == 1 )): ?> class="ri-thumb-down-fill" <?php else: ?> class="ri-thumb-down-line" <?php endif; ?>  class="ri-thumb-down-line <?php if( isset($like_dislike[0]) && $like_dislike[0]->disliked == 1 ) { echo 'active';}?>" aria-hidden="true" style="cursor:pointer;" data-like-val="1" dislike="1"  id="dislike"></i></span>
</li>

<?php if($video->access != 'ppv') { ?>
<li>
    <a href="#"onclick="EmbedCopy();" class="share-ico"><span><i class="ri-links-fill mt-1"></i></span></a>
</li> -->
<?php } ?>
<?php echo $hidden; if (Auth::user()) { ?>
    <input type="hidden" value="<?php echo Auth::user()->id;?>" id="user_id">
<?php } ?>
<!-- Buttons end here -->


<script>
	$('#like').click(function(){
        var  videoid = $("#videoid").val();

        $(this).toggleClass('active');

        if($(this).hasClass('active')){

            var like = 1;
            
            $.ajax({
                url: "<?php echo URL::to('like-video'); ?>",
                type: "POST",
                data: {
                    like: like,
                    videoid:videoid,
                     _token: '<?= csrf_token(); ?>'
                },
                dataType: "html",
                success: function(data) {

                    // $('.ri-thumb-up-line').removeClass('ri-thumb-up-line').addClass('ri-thumb-up-fill');
                    // $('.ri-thumb-down-fill').removeClass('ri-thumb-down-fill').addClass('ri-thumb-down-line');

                    $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">you have liked this media</div>');
                        setTimeout(function() {
                        $('.add_watch').slideUp('fast');
                    }, 3000);
                }
            });
        
        }else{

            var like = 0;

            $.ajax({
                url: "<?php echo URL::to('like-video') ;?>",
                type: "POST",
                data: {like: like,
                    videoid:videoid,
                     _token: '<?= csrf_token(); ?>'
                    },
                dataType: "html",

                success: function(data) {

                    // $('.ri-thumb-down-fill').removeClass('ri-thumb-down-fill').addClass('ri-thumb-down-line');
                    // $('.ri-thumb-up-line').removeClass('ri-thumb-up-line').addClass('ri-thumb-up-fill');
                    
                    $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">you have removed from liked this media </div>');
                    setTimeout(function() {
                        $('.remove_watch').slideUp('fast');
                    }, 3000);
                }
            });
        }
    });


	$('#dislike').click(function(){

        var  videoid = $("#videoid").val();
        
        $(this).toggleClass('active');

        if($(this).hasClass('active')){

            var dislike = 1;
            
                $.ajax({
                    url: "<?php echo URL::to('dislike-video') ;?>",
                    type: "POST",
                    data: { dislike: dislike,
                            videoid:videoid,
                             _token: '<?= csrf_token(); ?>'
                        },
                    dataType: "html",
                    success: function(data) {

                        // $('.ri-thumb-down-line').removeClass('ri-thumb-down-line').addClass('ri-thumb-down-fill');
                        // $('.ri-thumb-up-fill').removeClass('ri-thumb-up-fill').addClass('ri-thumb-up-line');

                        $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">you have disliked this media</div>');
                            setTimeout(function() {
                                $('.add_watch').slideUp('fast');
                        }, 3000);
                }
            });

        }else{

            var dislike = 0;
             
            $.ajax({
                url: "<?php echo URL::to('dislike-video') ;?>",
                type: "POST",
                data: {
                    dislike: dislike,
                    videoid:videoid,
                     _token: '<?= csrf_token(); ?>'
                    },
                dataType: "html",
                success: function(data) {

                    // $('.ri-thumb-down-fill').removeClass('ri-thumb-down-fill').addClass('ri-thumb-down-line');
                    // $('.ri-thumb-up-fill').removeClass('ri-thumb-up-fill').addClass('ri-thumb-up-line');

                    $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">you have removed from disliked this media</div>');
                        setTimeout(function() {
                            $('.remove_watch').slideUp('fast');
                        }, 3000);
                    }
            });
        }
    });

</script>

<script>
function Copy() {
    var media_path = $('#media_url').val();
  var url =  navigator.clipboard.writeText(globalThis.location.href);
  var path =  navigator.clipboard.writeText(media_path);
  $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied URL</div>');
               setTimeout(function() {
                $('.add_watch').slideUp('fast');
               }, 3000);
// console.log(url);
// console.log(media_path);
// console.log(path);
}
function EmbedCopy() {
    // var media_path = $('#media_url').val();
    var media_path = '<?= $url_path ?>';
  var url =  navigator.clipboard.writeText(globalThis.location.href);
  var path =  navigator.clipboard.writeText(media_path);
  $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied Embed URL</div>');
               setTimeout(function() {
                $('.add_watch').slideUp('fast');
               }, 3000);
// console.log(url);
// console.log(media_path);
// console.log(path);
}
</script>