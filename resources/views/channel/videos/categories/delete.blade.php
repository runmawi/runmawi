<?php

?>
<form action="{{ URL::to('admin/age/destory/') }}/{{$id}}}" method="post">
    <div class="modal-body">
        @csrf
        <h5 class="text-center">This age category that you wanted to delete has got {{ $video_count }} ? videos attached to it. Would you mind to delete the category still?</h5>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger">Yes, Delete Age Group</button>
    </div>
</form>

