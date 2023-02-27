@forelse($SeriesCategory  as $Series_Category)
    <div class="col-md-3 p-0"  data-video-id="{{ $Series_Category->id }}" data-trailer-videos="{{ $Series_Category->trailer }}" onmouseover="video_trailer(this)" >
        <div class="card" style="">
            <div style="position: relative;">
                <img class="w-100 " src="<?php echo URL::to('/public/uploads/images/'.$Series_Category->image); ?>" style="">
                <p class="small bkm"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ sprintf('%dh %dm', $Series_Category->duration / 3600, floor($Series_Category->duration / 60) % 60)  }}
                  </p>
            </div>

            <div class="card-body">
                <p class="card-text" >{{ strip_tags( $Series_Category->episode_description) }}</p>
                <div class="d-flex small-t ">
                    <a herf="" class="btn btn-success suce mr-3"><i class="fa fa-thumbs-up mr-2" aria-hidden="true"></i> {{ $Series_Category->id }} </a>
                    <p><i class="fa fa-eye" aria-hidden="true"></i> {{  $Series_Category->views }} </p>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-md-3 p-0"   >
        <div class="card" style="">
            <h2 class="text-center text-black"> No Episode found </h2>
        </div>
    </div>
@endforelse
