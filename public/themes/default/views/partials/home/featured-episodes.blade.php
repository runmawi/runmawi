@if(isset($featured_episodes))
  <div class="iq-main-header d-flex align-items-center justify-content-between">
    <h4 class="main-title">{{ __('Featured Episodes') }}</h4>
  </div>
@endif

@php
  $ThumbnailSetting = App\ThumbnailSetting::first();
@endphp

<div class="favorites-contents">
  <div class="featured-episode home-sec list-inline row p-0 mb-0">
    @if(isset($featured_episodes))
      @foreach($featured_episodes as $latest_episode)
        <div class="items">
          <div class="block-images position-relative">
            <!-- block-images -->
            <div class="border-bg">
              <div class="img-box">
                <a class="playTrailer" href="{{ $latest_episode->series_id == $latest_episode->series_title->id ? URL::to('/episode/'.$latest_episode->series_title->slug.'/'.$latest_episode->slug) : '' }}">
                  <img class="img-fluid w-100" src="{{ URL::to('/public/uploads/images/'.$latest_episode->image) }}" alt="feat">
                </a>
              </div>
            </div>

            <div class="block-description">
              <a class="playTrailer" href="{{ $latest_episode->series_id == $latest_episode->series_title->id ? URL::to('/episode/'.$latest_episode->series_title->slug.'/'.$latest_episode->slug) : '' }}">
               
              </a>

              <div class="hover-buttons text-white">
                <a href="{{ $latest_episode->series_id == $latest_episode->series_title->id ? URL::to('/episode/'.$latest_episode->series_title->slug.'/'.$latest_episode->slug) : '' }}">
                  <p class="epi-name text-left m-0">
                    {{ __($latest_episode->title) }}
                  </p>
                  <div class="movie-time d-flex align-items-center my-2">
                    <div class="badge badge-secondary p-1 mr-2">{{ $latest_episode->age_restrict.' +' }}</div>
                    <span class="text-white"><i class="fa fa-clock-o"></i> {{ gmdate('H:i:s', $latest_episode->duration) }}</span>
                  </div>
                </a>

                <a class="epi-name mt-2 mb-0 btn" href="{{ $latest_episode->series_id == $latest_episode->series_title->id ? URL::to('/episode/'.$latest_episode->series_title->slug.'/'.$latest_episode->slug) : '' }}">
                  <i class="fa fa-play mr-1" aria-hidden="true"></i> {{ __('Watch Series') }}
                </a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    @endif
  </div>
</div>

<script>
  var elem = document.querySelector('.featured-episode');
  var flkty = new Flickity(elem, {
      cellAlign: 'left',
      contain: true,
      groupCells: true,
      pageDots: false,
      draggable: true,
      freeScroll: true,
      imagesLoaded: true,
      lazyLoad: true,
  });
</script>
