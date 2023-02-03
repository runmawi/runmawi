<?php  $comment_loop =  App\WebComment::where('source_id',$source_id)->where('commentable_type',$commentable_type)->whereNull('child_id')->get(); ?>

<?php foreach( $comment_loop as $key => $comment ): ?>
    <img class="mr-3" src="https://www.gravatar.com/avatar.jpg" width="50px" alt="{{ $comment->user_name }} Avatar">
    <div class="media-body">
        <h5 class="mt-0 mb-1"><?= $comment->user_name ?> <small class="text-muted">- <?= $comment->created_at->diffForHumans() ?></small></h5>
        <div style="white-space: pre-wrap;"><?= ( $comment->comment ) ?></div>

            <div>
                <?php if( Auth::user() != null && Auth::user()->id != $comment->user_id  && Auth::user()->role != 'register' ):?>
                    <button data-toggle="modal" data-target="#reply-modal-<?= $comment->id ?>" class="btn btn-sm btn-link text-uppercase">Reply</button>
                <?php endif; ?>

                <?php if( Auth::user() != null && Auth::user()->id == $comment->user_id && Auth::user()->role != 'register' ):?>
                
                    <button data-toggle="modal" data-target="#comment-modal-<?= $comment->id ?>" class="btn btn-sm btn-link text-uppercase">Edit</button>
                    <a href="<?= route('comments.destroy', $comment->id) ?>" class="btn btn-sm btn-link text-danger text-uppercase">Delete</a>
                    
                    <a  id="comment-delete-form-<?= $comment->id ?>" href="<?= route('comments.destroy', $comment->id) ?>" method="get" style="display: none;"></a>
                <?php endif; ?>
            </div>


            <?php

                $reply_comment = App\WebComment::where('source_id',$source_id)->where('commentable_type',$commentable_type)
                                ->where('child_id',$comment->id)->get();

        if(count($reply_comment) > 0 ):

            foreach ($reply_comment as $key => $reply_comments) : ?>
                <div class="rep text-white" style="white-space: pre-wrap;"><?= ( $reply_comments->comment ) ?></div>

                <div>

                    <?php if( Auth::user() != null && Auth::user()->id == $reply_comments->user_id && Auth::user()->role != 'register' ):?>
                    
                        <button data-toggle="modal" data-target="#reply-edit-comment-modal-<?= $reply_comments->id ?>" class="btn btn-sm btn-link text-uppercase">Edit</button>

                        <a href="<?= route('comments.destroy', $reply_comments->id) ?>" class="btn btn-sm btn-link text-danger text-uppercase">Delete</a>
                        
                        <a  id="comment-delete-form-<?= $reply_comments->id ?>" href="<?= route('comments.destroy', $reply_comments->id) ?>" method="get" style="display: none;"></a>
                    <?php endif; ?>
                </div>

            <?php endforeach; 
        endif; ?>

       
        <?php  include(public_path('themes/default/views/comments/comment_edit_modal.blade.php')); ?>
        <?php  include(public_path('themes/default/views/comments/comment_edit_reply_modal.blade.php')); ?>

        <?php  include(public_path('themes/default/views/comments/comment_reply_modal.blade.php')); ?>

        <br />
    </div>

<?php endforeach; ?>


<?php  include(public_path('themes/default/views/comments/commentbox.blade.php')); ?>
