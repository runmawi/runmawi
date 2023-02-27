@foreach($categoryVideos  as $category_video)

    <div class="col-md-3 p-0"  data-video-id="{{ $category_video->id }}" data-trailer-videos="{{ $category_video->trailer }}" onmouseover="video_trailer(this)" >
        <div class="card" style="">
            <div style="position: relative;">
                <img class="w-100 " src="<?php echo URL::to('/public/uploads/images/'.$category_video->image); ?>" style="">
                <p class="small bkm"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ sprintf('%dh %dm', $category_video->duration / 3600, floor($category_video->duration / 60) % 60)  }}
                  </p>
            </div>

            <div class="card-body">
                <p class="card-text" >{{ strip_tags( $category_video->description) }}</p>
                <div class="d-flex small-t ">
                    <a herf="" class="btn btn-success suce mr-3"><i class="fa fa-thumbs-up mr-2" aria-hidden="true"></i> {{ $category_video->id }} </a>
                    <p><i class="fa fa-eye" aria-hidden="true"></i> {{  $category_video->views }} </p>
                </div>
            </div>
        </div>
    </div>
@endforeach
