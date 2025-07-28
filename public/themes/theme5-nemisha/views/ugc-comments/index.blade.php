<?php $comment_loop = App\WebComment::where('source_id', $source_id)
    ->where('commentable_type', $commentable_type)
    ->whereNull('child_id')
    ->latest()
    ->get(); ?>

<?php $user = Auth::user(); ?>
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

        <div style="white-space: pre-wrap;" class="mt-2 ugc-text"><?= $comment->comment ?></div>

        
        <div>
            <?php if( Auth::user() != null ):?>
            <div class="d-flex py-2">   
                <div class="ugc-text" data-comment-id="<?= $comment->id ?>" onclick="comment_like(this)">
                    <i class="comment-like <?= $comment->likes()->where('user_id', auth()->id())->exists() ? 'ri-thumb-up-fill' : 'ri-thumb-up-line' ?>"></i>
                    <span id="like-count-<?= $comment->id ?>"><?= $comment->likes()->count() ?></span>
                </div>
                <div class="ugc-text px-3"  data-comment-id="<?= $comment->id ?>" onclick="comment_dislike(this)" > 
                    <i class="comment-dislike <?= $comment->dislikes()->where('user_id', auth()->id())->exists() ? 'ri-thumb-down-fill' : 'ri-thumb-down-line' ?>"></i>
                    <span id="dislike-count-<?= $comment->id ?>"><?= $comment->dislikes()->count() ?></span>
                </div>
            
                <div class="px-3">
                    <a data-toggle="modal" data-target="#reply-modal-<?= $comment->id ?>"
                    class=" text-uppercase ugc-text" style="font-size: 14px; font-weight:700;" >Reply</a>
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
            <span class="text-capitalize text-white" style="font:600; font-size:15px; cursor: pointer;" >
                <?= $reply_comment->count() ?> replies</span>
            <div class="replycomments ">
            <div style="margin-left:10% !important">

                <div class="d-flex align-items-center"><img class="mr-3"
                        src="https://via.placeholder.com/128/fe669e/ffcbde.png?text=<?= ucfirst(substr(App\User::where('id', $reply_comments->user_id)->pluck('username')->first(), 0, 1));?>"
                        width="40px" alt="<?= ucfirst(App\User::where('id',$reply_comments->user_id)->pluck('username')->first())  ?>" style="border-radius: 30px;">
                    
                    <h5 class="mt-0 mb-1"><?= ucfirst(App\User::where('id',$reply_comments->user_id)->pluck('username')->first())  ?><br> <small class="text-muted">
                        <?= $reply_comments->created_at->diffForHumans() ?></small>
                    </h5>
                </div>

                <div style="white-space: pre-wrap;" class="rep ugc-text"><?= $reply_comments->comment ?></div>

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
    $('.replycomments').hide()
    jQuery('.reply-button').on('click',function(){
    jQuery('.replycomments').toggle();
})    

function comment_like(element) {
    const commentId = element.getAttribute('data-comment-id');

    $.ajax({
        url: '<?= route('comment.like') ?>',
        type: 'POST',
        data: {
            comment_id: commentId,
            _token: '<?= csrf_token() ?>'
        },
        success: function(response) {
            console.log(response); 

            if (response.success) {
                
                document.querySelector(`#like-count-${commentId}`).innerText = response.like_count;
                document.querySelector(`#dislike-count-${commentId}`).innerText = response.dislike_count;

                const likeIcon = element.querySelector('i.comment-like');
                const dislikeDiv = element.nextElementSibling;
                const dislikeIcon = dislikeDiv.querySelector('i.comment-dislike');

                console.log(likeIcon, dislikeIcon); 

                if (response.like_status === "Add") {
                    likeIcon.classList.remove('ri-thumb-up-line');
                    likeIcon.classList.add('ri-thumb-up-fill');

                    if (dislikeIcon) {
                        dislikeIcon.classList.remove('ri-thumb-down-fill');
                        dislikeIcon.classList.add('ri-thumb-down-line');
                    }
                } else {
                    likeIcon.classList.remove('ri-thumb-up-fill');
                    likeIcon.classList.add('ri-thumb-up-line');
                }
            }
        }
    });
}

function comment_dislike(element) {
    const commentId = element.getAttribute('data-comment-id');

    $.ajax({
        url: '<?= route('comment.dislike') ?>',
        type: 'POST',
        data: {
            comment_id: commentId,
            _token: '<?= csrf_token() ?>'
        },
        success: function(response) {
            if (response.success) {
               
                document.querySelector(`#dislike-count-${commentId}`).innerText = response.dislike_count;
                document.querySelector(`#like-count-${commentId}`).innerText = response.like_count;
                const dislikeIcon = element.querySelector('i.comment-dislike');
                const likeDiv = element.previousElementSibling; 
                const likeIcon = likeDiv.querySelector('i.comment-like');

                console.log(dislikeIcon, likeIcon); 

                if (response.dislike_status === "Add") {
                    dislikeIcon.classList.remove('ri-thumb-down-line');
                    dislikeIcon.classList.add('ri-thumb-down-fill');

                    if (likeIcon) {
                        likeIcon.classList.remove('ri-thumb-up-fill');
                        likeIcon.classList.add('ri-thumb-up-line');
                    }
                } else {
                    dislikeIcon.classList.remove('ri-thumb-down-fill');
                    dislikeIcon.classList.add('ri-thumb-down-line');
                }
            }
        }
    });
}
</script>


