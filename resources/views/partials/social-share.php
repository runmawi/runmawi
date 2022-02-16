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
<li>
    <span><i <?php if( isset($like_dislike[0]) && $like_dislike[0]->liked == 1 ) {}?> class="ri-thumb-up-line <?php if( isset($like_dislike[0]) && $like_dislike[0]->liked == 1 ) { echo 'active';}?>" aria-hidden="true" style="cursor:pointer;" data-like-val="1" like="1" id="like"  data-authenticated="<?= !Auth::guest() ?>"></i></span>
</li>
<li>
    <span><i <?php if( isset($like_dislike[0]) && $like_dislike[0]->disliked == 1 ) {}?> class="ri-thumb-down-line <?php if( isset($like_dislike[0]) && $like_dislike[0]->disliked == 1 ) { echo 'active';}?>" aria-hidden="true" style="cursor:pointer;" data-like-val="1" dislike="1"  id="dislike" data-authenticated="<?= !Auth::guest() ?>"></i></span>
</li>
<li>
    <span><a href="#"onclick="EmbedCopy();" class="share-ico"><i class="ri-links-fill"></i></a></span>
</li>
<?php echo $hidden; if (Auth::user()) { ?>
    <input type="hidden" value="<?php echo Auth::user()->id;?>" id="user_id">
<?php } ?>
<!-- Buttons end here -->


<script>
	$('#like').click(function(){
        var  videoid = $("#videoid").val();
        var user_id = $("#user_id").val();
        if($(this).data('authenticated')){
            $(this).toggleClass('active');
            if($(this).hasClass('active')){
                var like = 1;
                //$(this).css('color','#34c1d8');
                $.ajax({
                url: "<?php echo URL::to('/').'/like-video';?>",
                type: "POST",
                data: {like: like,videoid:videoid,user_id:user_id, _token: '<?= csrf_token(); ?>'},
                dataType: "html",
                success: function(data) {
                    $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">you have liked this media</div>');
               setTimeout(function() {
                $('.add_watch').slideUp('fast');
               }, 3000);
                    
                }
            });
            // $(this).html('<i class="ri-thumb-up-fill"></i>');

            // $(this).replaceClass('ri-thumb-up-line ri-thumb-up-fill');

            }else{
                var like = 0;
                //$(this).css('color','#4895d1');
                $.ajax({
                url: "<?php echo URL::to('/').'/like-video';?>",
                type: "POST",
                data: {like: like,videoid:videoid,user_id:user_id, _token: '<?= csrf_token(); ?>'},
                dataType: "html",
                success: function(data) {
               $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">you have removed from liked this media </div>');
                setTimeout(function() {
                    $('.remove_watch').slideUp('fast');
                     }, 3000);
                }
            });
            // $(this).html('<i class="ri-thumb-up-line"></i>');

                // $(this).replaceClass('ri-thumb-up-fill ri-thumb-up-line');
            }
           
        } else {
          window.location = '<?= URL::to('login') ?>';
      }
  });



	$('#dislike').click(function(){
        var  videoid = $("#videoid").val();
        var user_id = $("#user_id").val();
        if($(this).data('authenticated')){
            $(this).toggleClass('active');
            if($(this).hasClass('active')){
                var dislike = 1;
                //$(this).css('color','#34c1d8');
                
                    $.ajax({
                        url: "<?php echo URL::to('/').'/dislike-video';?>",
                        type: "POST",
                        data: {dislike: dislike,videoid:videoid,user_id:user_id, _token: '<?= csrf_token(); ?>'},
                        dataType: "html",
                        success: function(data) {
                            $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">you have disliked this media</div>');
               setTimeout(function() {
                $('.add_watch').slideUp('fast');
               }, 3000);
                //     $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Removed From Dislike </div>');
                // setTimeout(function() {
                //     $('.remove_watch').slideUp('fast');
                //      }, 300);
                
                    }
                });





            }else{
                var dislike = 0;
                //$(this).css('color','#4895d1');
                $.ajax({
            url: "<?php echo URL::to('/').'/dislike-video';?>",
            type: "POST",
            data: {dislike: dislike,videoid:videoid,user_id:user_id, _token: '<?= csrf_token(); ?>'},
            dataType: "html",
            success: function(data) {
                    $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">you have removed from disliked this media</div>');
                setTimeout(function() {
                    $('.remove_watch').slideUp('fast');
                     }, 3000);
                
          }
      });
            }
            // alert('test');
        
          
        } else {
          window.location = '<?= URL::to('login') ?>';
      }
  });
</script>
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
function EmbedCopy() {
    // var media_path = $('#media_url').val();
    var media_path = '<?= $url_path ?>';
  var url =  navigator.clipboard.writeText(window.location.href);
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