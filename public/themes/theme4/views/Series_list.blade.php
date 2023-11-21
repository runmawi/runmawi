@php
    include(public_path('themes/default/views/header.php'));
@endphp
    
<section id="iq-tvthrillers" class="s-margin">
    <div class="container-fluid">

        <?php
                
            foreach($parentCategories as $category) {

            
                $videos = App\Series::join('series_categories', 'series_categories.series_id', '=', 'series.id')
                                    ->where('category_id', '=', $category->id) 
                                    ->where('active', '=', '1')
                                    ->orderBy('series_categories.created_at','desc')
                                    ->get();
        ?>
                
            <?php if (count($videos) > 0) {  ?>
                
                    <div class="">
                        <div class="row">
                            <div class="col-sm-12 overflow-hidden">
                                <div class="iq-main-header d-flex align-items-center justify-content-between">
                                    <a href="<?php echo URL::to('/play_series').'/'.$category->slug;?>" class="category-heading"  style="text-decoration:none;color:#fff">
                                        <h4 class="movie-title"> {{  $category->name }} </h4>
                                    </a>
                                </div>

                                <div class="favorites-contens">
                                    <ul class="favorites-slider list-inline  row p-0 mb-0">
                                        @php if(!empty($data['password_hash'])) { 
                                                $id = Auth::user()->id ; } else { $id = 0 ; } 
                                        @endphp
                                        <?php  if(isset($videos)) :
                                           foreach($videos as $category_video): 
                                        ?>

                                        <li class="slide-item">
                                             <a href="<?php echo URL::to('play_series') ?><?= '/' . $category_video->slug ?>">
                                                <div class="block-images position-relative">
                                              
                                                <div class="img-box">
                                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>"class="img-fluid" alt="">
                                                </div>

                                                <div class="block-description">
                    
                                                        @if($ThumbnailSetting->title == 1)          <!-- Title -->
                                                            <a href="<?php echo URL::to('play_series') ?><?= '/' . $category_video->slug ?>">
                                                                <h6>
                                                                    <?php  echo (strlen($category_video->title) > 17) ? substr($category_video->title,0,18).'...' : $category_video->title; ?>
                                                                </h6>
                                                            </a>
                                                        @endif
                    
                                                        <div class="movie-time d-flex align-items-center pt-1">
                                                          
                        
                                                            @if($ThumbnailSetting->duration == 1)    <!-- Duration -->
                                                                <span class="text-white">
                                                                    <i class="fa fa-clock-o"></i>
                                                                 {{ gmdate('H:i:s', $category_video->duration) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                       
                                                        @if(($ThumbnailSetting->published_year == 1) || ($ThumbnailSetting->rating == 1)) 
                                                            <div class="movie-time d-flex align-items-center pt-1">
                                                                @if($ThumbnailSetting->rating == 1)   <!--Rating  -->   
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                                             {{ ($category_video->rating) }}
                                                                        </span>
                                                                    </div>
                                                                @endif
                    
                                                                @if($ThumbnailSetting->published_year == 1)    <!-- published_year -->                                               
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                        {{ ($category_video->year) }}
                                                                        </span>
                                                                    </div>
                                                                @endif
                    
                                                                @if($ThumbnailSetting->featured == 1 && $category_video->featured == 1) <!-- Featured -->
                                                                    <div class="badge badge-secondary p-1 mr-2">
                                                                        <span class="text-white">
                                                                            <i class="fa fa-flag-o" aria-hidden="true"></i>
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                    
                    
                                                    <div class="hover-buttons">
                                                        <a type="button" class="text-white d-flex align-items-center"
                                                             href="<?php echo URL::to('play_series') ?><?= '/' . $category_video->slug ?>">
                                                            <img class="ply mr-1" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/> {{ __('Watch Now') }}
                                                        </a>
                                                        <div class="d-flex"></div>  
                                                    </div>                
                                                </div>
                                                 </a>
                                        </li>

                                        <?php  endforeach;    endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

            <?php }  ?>
            
            <?php }?>
    </div>
</section>
@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp