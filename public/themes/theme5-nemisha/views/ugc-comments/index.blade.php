<?php $comment_loop = App\WebComment::where('source_id', $source_id)->where('approved',1)
    ->where('commentable_type', $commentable_type)
    ->whereNull('child_id')
    ->latest()
    ->get(); ?>

<?php $user = Auth::user()->first() ?>

<div class="">
    <h4><?= $comment_loop->count() ?> Comment</h4>
</div>

<div class="row pt-3">
    <div class="col-1 d-none d-md-block">
        <img class="rounded-circle"
        src="<?= $user->avatar ? URL::to('/') . '/public/uploads/avatars/' . $user->avatar : URL::to('/assets/img/placeholder.webp') ?>"  alt="profile-bg" style="height: 70px; width: 70px;">
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

        <div style="white-space: pre-wrap;" class="mt-2 mb-2 text-white"><?= $comment->comment ?></div>

        <div>
            <?php if( Auth::user() != null && Auth::user()->id != $comment->user_id  && Auth::user()->role != 'register' ):?>
                <a data-toggle="modal" data-target="#reply-modal-<?= $comment->id ?>"
                class=" text-uppercase text-secondary"> <i class="fa fa-share" aria-hidden="true"></i>Reply</a>
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