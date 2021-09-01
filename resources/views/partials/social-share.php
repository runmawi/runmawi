<?php

if(isset($video)):
    $media_title = $video->title;
    $url = URL::to('/category/videos');
    $media_url = $url . '/' . $video->slug;
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
    $media_url = $url . '/' . $series->id; 
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
<!--
<span class="share text-center">
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>" class="popup"><i class="fa fa-facebook"></i></a>
    <a href="http://twitter.com/home?status=<?= $media_subject ?> : <?= $media_url ?>" class="popup"><i class="fa fa-twitter"></i></a>
    <a href="https://plus.google.com/share?url=<?= $media_subject ?> : <?= $media_url ?>" class="popup"><i class="fa fa-google-plus"></i></a>
    <a href="mailto:?subject=<?= $media_subject ?>&amp;body=<?= $media_url ?>"><i class="fa fa-envelope"></i></a>
</span> -->
<!-- Buttons start here. Copy this ul to your document. -->
<ul class="rrssb-buttons clearfix">
    <li class="" >

      <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>" target="_blank" class="popup"><i class="fa fa-facebook" style="color: #3b5998;padding: 10px;border-radius: 50%;
      font-size: 14px;width:35px;"></i></a>
  </li>
  <li class="">
    <a  href="https://twitter.com/intent/tweet?text=<?= $media_url ?>" target="_blank" class="popup">
        <i class="fa fa-twitter" style="color: #00acee;padding: 10px;border-radius: 50%;
        font-size: 14px;">
    </i>
</a>
</li>
<i <?php if( isset($like_dislike[0]) && $like_dislike[0]->disliked == 1 ) { echo 'style="color: #34c1d8;cursor:pointer;"';}?> class="fa fa-thumbs-o-down <?php if( isset($like_dislike[0]) && $like_dislike[0]->disliked == 1 ) { echo 'active';}?>" aria-hidden="true" style="cursor:pointer;" data-like-val="1" dislike="1"  id="dislike" data-authenticated="<?= !Auth::guest() ?>"></i>
<li>

    <i <?php if( isset($like_dislike[0]) && $like_dislike[0]->liked == 1 ) { echo 'style="color: #34c1d8;cursor:pointer;"';}?> class="fa fa-thumbs-o-up <?php if( isset($like_dislike[0]) && $like_dislike[0]->liked == 1 ) { echo 'active';}?>" aria-hidden="true" style="cursor:pointer;" data-like-val="1" like="1" id="like"  data-authenticated="<?= !Auth::guest() ?>"></i>
    <li>


    </li>
</ul>

<?php echo $hidden; if (Auth::user()) { ?>
    <input type="hidden" value="<?php echo Auth::user()->id;?>" id="user_id">
<?php } ?>
<!-- Buttons end here -->
<script>
    $(document).ready(function(){
//   $("#like").click(function(){
//       var like = $("#like").attr("like");
//             alert(like);
//             return false;
//         $.ajax({url: "demo_test.txt", success: function(result){
//         $("#div1").html(result);
//         }});
//   });
});
</script>

<script>
	$('#like').click(function(){
        var  videoid = $("#videoid").val();
        var user_id = $("#user_id").val();
        if($(this).data('authenticated')){
            $(this).toggleClass('active');
            if($(this).hasClass('active')){
                var like = 1;
                $(this).css('color','#34c1d8');
            }else{
                var like = 0;
                $(this).css('color','white');
            }
            $.ajax({
                url: "<?php echo URL::to('/').'/like-video';?>",
                type: "POST",
                data: {like: like,videoid:videoid,user_id:user_id, _token: '<?= csrf_token(); ?>'},
                dataType: "html",
                success: function() {
                    
                }
            });
        } else {
          window.location = '<?= URL::to('login') ?>';
      }
  });

    $('#dislike').click(function(){
        $(this).toggleClass('active');
        if($(this).hasClass('active')){
            var dislike = 1;
            $(this).css('color','#34c1d8');
        }else{
            var dislike = 0;
            $(this).css('color','white');
        }
        var  videoid = $("#videoid").val();
        var user_id = $("#user_id").val();

        $.ajax({
            url: "<?php echo URL::to('/').'/dislike-video';?>",
            type: "POST",
            data: {dislike: dislike,videoid:videoid,user_id:user_id, _token: '<?= csrf_token(); ?>'},
            dataType: "html",
            success: function() {
          }
      });

    });

</script>