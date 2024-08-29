<?php $comment_loop = App\WebComment::where('source_id', $source_id)
    ->where('commentable_type', $commentable_type)
    ->whereNull('child_id')
    ->latest()
    ->get(); ?>

<?php $user = Auth::user()->first() ?>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<div class="">
    <h4><?= $comment_loop->count() ?> Comment</h4>
</div>

<div class="row pt-3">
    <div class="col-1 d-none d-md-block">
        <img class="rounded-circle"
        src="<?= $user->avatar ? URL::to('/') . '/public/uploads/avatars/' . $user->avatar : URL::to('/assets/img/placeholder.webp') ?>"  alt="profile" style="height: 70px; width: 70px;">
    </div>

    <div class="col-12 col-md-11">
    <?php 
    if( !Auth::guest() ){
        include public_path('themes/theme5-nemisha/views/ugc-comments/commentbox.blade.php'); 
    }
    ?>
    </div>
</div>



<div class="bg-border col-lg-6 p-2">
    <?php foreach( $comment_loop as $key => $comment ): ?>

    <div class="media-body">
        <div class="d-flex align-items-center">
            <h6 class="mt-0 mb-1"><?= ucfirst(App\User::where('id',$comment->user_id)->pluck('username')->first()); ?> | <?= $comment->created_at->diffForHumans() ?></h6>
        </div>

        <div style="white-space: pre-wrap;" class="mt-2 text-white"><?= $comment->comment ?></div>

        
        <div>
            <?php if( Auth::user() != null ):?>
            <div class="d-flex py-2">   
                <div class="like-button" >
                    <a data-comment-id="<?= $comment->id ?>" data-user-id="<?= auth()->id() ?>" onclick="handleLike(this)">
                        <i class=" <?= $comment->has_liked ? 'ri-thumb-up-fill p-2 rounded-circle' : 'ri-thumb-up-line p-2 rounded-circle' ?> px-1 text-white" style="background-color: #ED563C;" ></i>  <span class="like-count" style="color: white;" ><?= $comment->comment_like ? $comment->comment_like : 0 ?></span>
                    </a>
                </div>
                <div class="px-3 dislike-button">
                    <a data-comment-id="<?= $comment->id ?>" data-user-id="<?= auth()->id() ?>" onclick="handleDislike(this)" >
                        <i class="<?= $comment->has_disliked ? 'ri-thumb-down-fill p-2 rounded-circle' : 'ri-thumb-down-line p-2 rounded-circle' ?> px-1 text-white" style="background-color: #ED563C;"></i> <span class="dislike-count" style="color: white;" ><?= $comment->comment_dislike ? $comment->comment_dislike : 0 ?></span>
                    </a>
                </div>
                
                <div class="px-3">
                    <a data-toggle="modal" data-target="#reply-modal-<?= $comment->id ?>"
                    class=" text-uppercase text-white" style="font-size: 14px; font-weight:700;" >Reply</a>
                </div>
            </div>
            <?php endif; ?>

            <?php if( Auth::user() != null && Auth::user()->id == $comment->user_id && Auth::user()->role != 'register' ):?>

                <a data-toggle="modal" data-target="#comment-modal-<?= $comment->id ?>"
                    class=" edu  text-success text-uppercase"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                <a onclick="return confirm('Are you sure to remove Comment ?')"
                    href="<?= route('comments.destroy', $comment->id) ?>" class="dele text-uppercase text-danger"><i
                        class="fa fa-trash-o" aria-hidden="true"></i></a>

                <a id="comment-delete-form-<?= $comment->id ?>" href="<?= route('comments.destroy', $comment->id) ?>"
                    method="get" style="display: none;"></a>
            <?php endif; ?>
        </div>

        <?php

                $reply_comment = App\WebComment::where('source_id',$source_id)->where('commentable_type',$commentable_type)
                                    ->where('approved',1)->where('child_id',$comment->id)->latest()->get();

        
             if(count($reply_comment) > 0 ):
            
            foreach ($reply_comment as $key => $reply_comments) : ?>
            <div class="reply-button">
            <span class="text-capitalize text-white" style="font:600; font-size:15px; cursor: pointer;" >2 replies</span>
            <div class="replycomments ">
            <div style="margin-left:10% !important">

                <div class="d-flex align-items-center"><img class="mr-3"
                        src="https://via.placeholder.com/128/fe669e/ffcbde.png?text=<?= ucfirst(substr(App\User::where('id', $reply_comments->user_id)->pluck('username')->first(), 0, 1));?>"
                        width="40px" alt="<?= ucfirst(App\User::where('id',$reply_comments->user_id)->pluck('username')->first())  ?>" style="border-radius: 30px;">
                    
                    <h5 class="mt-0 mb-1"><?= ucfirst(App\User::where('id',$reply_comments->user_id)->pluck('username')->first())  ?><br> <small class="text-muted">
                        <?= $reply_comments->created_at->diffForHumans() ?></small>
                    </h5>
                </div>

            <div style="white-space: pre-wrap;" class="rep text-white"><?= $reply_comments->comment ?></div>

            <div>

                <?php if( Auth::user() != null && Auth::user()->id == $reply_comments->user_id && Auth::user()->role != 'register' ):?>

                <a data-toggle="modal" data-target="#reply-edit-comment-modal-<?= $reply_comments->id ?>"
                    class="text-success text-uppercase"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                <a onclick="return confirm('Are you sure to remove Comment?')"
                    href="<?= route('comments.destroy', $reply_comments->id) ?>"
                    class="dele text-uppercase text-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>

                <a id="comment-delete-form-<?= $reply_comments->id ?>"
                    href="<?= route('comments.destroy', $reply_comments->id) ?>" method="get"
                    style="display: none;"></a>
                <?php endif; ?>
            </div>
        </div>
        </div>
        </div>
        <?php endforeach; 
        endif; ?>

        <?php include public_path('themes/theme5-nemisha/views/ugc-comments/comment_edit_modal.blade.php'); ?>
        <?php include public_path('themes/theme5-nemisha/views/ugc-comments/comment_edit_reply_modal.blade.php'); ?>
        <?php include public_path('themes/theme5-nemisha/views/ugc-comments/comment_reply_modal.blade.php'); ?>

        <br />
    </div>

    <?php endforeach; ?>
</div>

<script>
    $(document).ready(function () {
        setTimeout(function () {
            $("#successMessage").fadeOut("fast");
        }, 5000);
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const likeUrlBase = '<?php echo route('comments.like', ['id' => 'placeholder']); ?>';
    const dislikeUrlBase = '<?php echo route('comments.dislike', ['id' => 'placeholder']); ?>';

    function handleLike(ele) {
        let commentId = $(ele).data('comment-id');
        let userId = $(ele).data('user-id');
        let url = likeUrlBase.replace('placeholder', commentId);

        $.ajax({
            url: url,
            method: 'post',
            data: {
                "_token": "<?= csrf_token() ?>",
                "user_id": userId
            },
            success: function(response) {
                if (response.status) {
                    let icon = $(ele).find('i');
                    let isLiked = icon.hasClass('ri-thumb-up-fill');
                    
                    // Toggle like icon
                    if (isLiked) {
                        icon.removeClass('ri-thumb-up-fill').addClass('ri-thumb-up-line');
                    } else {
                        icon.removeClass('ri-thumb-up-line').addClass('ri-thumb-up-fill');
                    }

                    // Update the dislike button if it's active
                    let dislikeBtn = $(ele).siblings('a').find('i.ri-thumb-down-fill');
                    if (dislikeBtn.length) {
                        dislikeBtn.removeClass('ri-thumb-down-fill').addClass('ri-thumb-down-line');
                    }

                    // Update like count display
                    $(ele).find('.like-count').text(response.new_like_count);

                    // Update dislike count display
                    $(ele).siblings('a').find('.dislike-count').text(response.new_dislike_count);

                } else {
                    alert('An error occurred: ' + response.message);
                }
            },
            error: function(xhr) {
                console.error('AJAX request failed:', xhr.responseText);
                alert('AJAX request failed: ' + xhr.responseText);
            }
        });
    }

    function handleDislike(ele) {
        let commentId = $(ele).data('comment-id');
        let userId = $(ele).data('user-id');
        let url = dislikeUrlBase.replace('placeholder', commentId);

        $.ajax({
            url: url,
            method: 'post',
            data: {
                "_token": "<?= csrf_token() ?>",
                "user_id": userId
            },
            success: function(response) {
                if (response.status) {
                    let icon = $(ele).find('i');
                    let isDisliked = icon.hasClass('ri-thumb-down-fill');
                    
                    // Toggle dislike icon
                    if (isDisliked) {
                        icon.removeClass('ri-thumb-down-fill').addClass('ri-thumb-down-line');
                    } else {
                        icon.removeClass('ri-thumb-down-line').addClass('ri-thumb-down-fill');
                    }

                    // Update the like button if it's active
                    let likeBtn = $(ele).siblings('a').find('i.ri-thumb-up-fill');
                    if (likeBtn.length) {
                        likeBtn.removeClass('ri-thumb-up-fill').addClass('ri-thumb-up-line');
                    }

                    // Update like count display
                    $(ele).siblings('a').find('.like-count').text(response.new_like_count);
                    
                    // Update dislike count display
                    $(ele).find('.dislike-count').text(response.new_dislike_count);

                } else {
                    alert('An error occurred: ' + response.message);
                }
            },
            error: function(xhr) {
                console.error('AJAX request failed:', xhr.responseText);
                alert('AJAX request failed: ' + xhr.responseText);
            }
        });
    }
</script>

<script>
    $('.replycomments').hide()
    jQuery('.reply-button').on('click',function(){
    jQuery('.replycomments').toggle();
})    
</script>