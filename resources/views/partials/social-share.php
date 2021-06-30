<?php

    if(isset($video)):
        $media_title = $video->title;
        $url = URL::to('/category/videos');
        $media_url = $url . '/' . $video->slug;
    elseif(isset($post)):
        $media_title = $post->title;
        $url = ($settings->enable_https) ? secure_url('post') : URL::to('post');
        $media_url = $url . '/' . $post->slug; 
    elseif(isset($movie)):
        $media_title = $movie->title;
        $url = ($settings->enable_https) ? secure_url('play_movie') : URL::to('play_movie');
        $media_url = $url . '/' . $movie->slug; 
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
    <i <?php if( isset($like_dislike[0]) && $like_dislike[0]->disliked == 1 ) { echo 'style="color: #fff;cursor:pointer;"';}?> class="fa fa-thumbs-o-down" aria-hidden="true" style="cursor:pointer;color:#fff;" data-like-val="1" dislike="1"  id="dislike"></i>
    <li>

    <i <?php if( isset($like_dislike[0]) && $like_dislike[0]->liked == 1 ) { echo 'style="color: #34c1d8;cursor:pointer;"';}?> class="fa fa-thumbs-o-up" aria-hidden="true" style="cursor:pointer;color:#fff;" data-like-val="1" like="1" id="like" ></i>
    <li>
    
       
    </li>
</ul>
<input type="hidden" value="<?php echo $video->id;?>" id="videoid">
<?php if (Auth::user()) { ?>
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
        var like = $("#like").attr("like");
        var  videoid = $("#videoid").val();
        var user_id = $("#user_id").val();
     toastr.options = {
                              "closeButton": true,
                              "newestOnTop": true,
                              "positionClass": "toast-top-right"
        }; 
        $.ajax({
                url: "<?php echo URL::to('/').'/like-video';?>",
                         type: "POST",
                         data: {like: like,videoid:videoid,user_id:user_id},
                         dataType: "html",
                         success: function() {
                              toastr.success("Successfully Added !");
                         }
            });
        
	});

    $('#dislike').click(function(){
        var like = $("#dislike").attr("dislike");
        var  videoid = $("#videoid").val();
        var user_id = $("#user_id").val();
         toastr.options = {
                              "closeButton": true,
                              "newestOnTop": true,
                              "positionClass": "toast-top-right"
        }; 
        $.ajax({
                url: "<?php echo URL::to('/').'/like-video';?>",
                         type: "POST",
                         data: {like: like,videoid:videoid,user_id:user_id},
                         dataType: "html",
                         success: function() {
                              toastr.success("Successfully Added !");
                         }
            });
        
	});

</script>