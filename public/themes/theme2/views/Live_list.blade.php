@php
    include(public_path('themes/theme2/views/header.php'));
@endphp
    
<section id="iq-tvthrillers" class="s-margin">
    <div class="container-fluid">

        <?php
                
            foreach($parentCategories as $category) {
            
                $videos = App\LiveStream::join('livecategories', 'livecategories.live_id', '=', 'live_streams.id')
                                    ->where('category_id', '=', $category->id) 
                                    ->where('active', '=', '1')
                                    ->orderBy('live_streams.created_at','desc')
                                    ->get();
        ?>

        @if (count($videos) > 0) 
            <div class="">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">
                            <div class="iq-main-header d-flex align-items-center justify-content-between">
                                <a href="<?php echo URL::to('/category/').'/'.$category->slug;?>" class="category-heading" style="text-decoration: none; color: #fff;">
                                    <h4 class="movie-title"> {{ $category->name }} </h4>
                                </a>
                            </div>

                        <div class="favorites-contens">
                            <ul class="favorites-slider list-inline row p-0 mb-0">
                                @php  if(!empty($data['password_hash'])) { 
                                    $id = Auth::user()->id ; } else { $id = 0 ; } @endphp

                                @if(isset($videos)) 
                                    @forelse($videos as $category_video)
                                        <li class="slide-item">
                                            <div class="block-images position-relative">
                                                <!-- block-images -->
                                                <a href="<?php echo URL::to('live') ?><?= '/' . $category_video->slug ?>">
                                                    <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>" class="img-fluid" alt=""> 
                                                </a>
                                            
                                                @if($ThumbnailSetting->free_or_cost_label == 1) 
                                                    @if(!empty($category_video->ppv_price))  <!-- PPV price -->
                                                        <p class="p-tag1" >
                                                            {{  $currency->symbol.' '.$category_video->ppv_price}}
                                                        </p>
                                                    @elseif( !empty($category_video->global_ppv || !empty($category_video->global_ppv) && $category_video->ppv_price == null))
                                                        <p class="p-tag1">
                                                            {{ $category_video->global_ppv.' '.$currency->symbol }}
                                                        </p>
                                                    @elseif($category_video->global_ppv == null && $category_video->ppv_price == null )
                                                        <p class="p-tag" > 
                                                            {{  "Free"}} 
                                                        </p>
                                                    @endif
                                                @endif 
                                            </div>

                                            <div class="block-description">
                                                <div class="hover-buttons">
                                                    <a type="button" class="text-white btn-cl" href="<?php echo URL::to('live') ?><?= '/' . $category_video->slug ?>">
                                                        <img class="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>" />
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="mt-2 d-flex justify-content-between p-0">
                                                @if($ThumbnailSetting->title == 1)          <!-- Title -->
                                                    <h6>
                                                        <?php  echo (strlen($category_video->title) > 17) ? substr($category_video->title,0,18).'...' : $category_video->title; ?>
                                                    </h6>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2">
                                                @if($ThumbnailSetting->duration == 1)  <!-- Duration -->
                                                    <span class="text-white">
                                                        <i class="fa fa-clock-o"></i>
                                                        <?= gmdate('H:i:s', $category_video->duration); ?>
                                                    </span>
                                                @endif

                                                @if($ThumbnailSetting->rating == 1 && $category_video->rating != null)  <!-- Rating -->
                                                    <span class="text-white">
                                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                            {{ $category_video->rating}}
                                                    </span>
                                                @endif

                                                @if($ThumbnailSetting->featured == 1 && $category_video->featured == 1)   <!-- Featured -->
                                                    <span class="text-white">
                                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2">
                                                @if ( ($ThumbnailSetting->published_year == 1) && ( $category_video->year != null ) )   <!-- published_year -->
                                                    <span class="text-white">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            {{ ($category_video->year) }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="movie-time my-2"> <!-- Category Thumbnail  setting -->
                                                <?php
                                                $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                            ->where('categoryvideos.video_id',$category_video->video_id)
                                                            ->pluck('video_categories.name');   
                                                ?>
                                                @if ( ($ThumbnailSetting->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) ) 
                                                    <span class="text-white">
                                                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                        <?php
                                                            $Category_Thumbnail = array();
                                                                foreach($CategoryThumbnail_setting as $key => $CategoryThumbnail){
                                                                $Category_Thumbnail[] = $CategoryThumbnail ; 
                                                                }
                                                            echo implode(','.' ', $Category_Thumbnail);
                                                        ?>
                                                    </span>
                                                @endif
                                            </div>
                                        
                                        </li>
                                    @empty

                                    @endforelse
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <?php }?>
    </div>
</section>

@php
    include(public_path('themes/theme2/views/footer.blade.php'));
@endphp