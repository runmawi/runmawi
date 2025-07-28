@php
    include(public_path('themes/default/views/header.php'));
@endphp
    
<section id="iq-tvthrillers" class="s-margin">
    <div class="container-fluid">

        <?php
                
            if(count($parentCategories)>0):  

            foreach($parentCategories as $category) {
            
                $videos = App\LiveStream::join('livecategories', 'livecategories.live_id', '=', 'live_streams.id')
                                    ->where('category_id', '=', $category->id) 
                                    ->where('active', '=', '1')
                                    ->orderBy('live_streams.created_at','desc')
                                    ->get();

        ?>
                
            <?php if (count($videos) > 0) {  ?>
                
                    <div class="">
                        <div class="row">
                            <div class="col-sm-12 overflow-hidden">
                                <div class="iq-main-header d-flex align-items-center justify-content-between">
                                    <a href="<?php echo URL::to('/live/').'/'.$category->slug;?>" class="category-heading"  style="text-decoration:none;color:#fff">
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
                                             <a href="<?php echo URL::to('live') ?><?= '/' . $category_video->slug ?>">
                                                <div class="block-images position-relative">
                                              
                                                <div class="img-box">
                                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.$category_video->image;  ?>"class="img-fluid" alt=""  loading="lazy">
                                            
                                                        @if($ThumbnailSetting->free_or_cost_label == 1) 

                                                            @if( $category_video->access == 'subscriber' )
                                                            <p class="p-tag"> <i class="fas fa-crown" style='color:gold'></i> </p>

                                                            @elseif(!empty($category_video->ppv_price))
                                                                <p class="p-tag1" >
                                                                    {{  $currency->symbol.' '.$category_video->ppv_price}}
                                                                </p>
                                                            @elseif( !empty($category_video->global_ppv || !empty($category_video->global_ppv) && $category_video->ppv_price == null))
                                                                <p class="p-tag1">
                                                                    {{ $category_video->global_ppv.' '.$currency->symbol }}
                                                                </p>
                                                            @elseif($category_video->global_ppv == null && $category_video->ppv_price == null )
                                                                <p class="p-tag" > 
                                                                    {{  __("Free")}} 
                                                                </p>
                                                            @endif
                                                        @endif 
                                                </div>
 
                                                <div class="block-description">
                    
                                                        @if($ThumbnailSetting->title == 1)          <!-- Title -->
                                                            <a href="<?php echo URL::to('live') ?><?= '/' . $category_video->slug ?>">
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
                    
                                                        <div class="movie-time text-white ugc-text d-flex align-items-center pt-1">  <!-- Category Thumbnail  setting -->        
                                                          <?php
                                                          $CategoryThumbnail_setting =  App\CategoryVideo::join('video_categories','video_categories.id','=','categoryvideos.category_id')
                                                                      ->where('categoryvideos.video_id',$category_video->video_id)
                                                                      ->pluck('video_categories.name');        
                                                          ?>

                                                        @if ( ($ThumbnailSetting->category == 1 ) &&  ( count($CategoryThumbnail_setting) > 0 ) )
                                                              <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                              <?php
                                                                  $Category_Thumbnail = array();
                                                                      foreach($CategoryThumbnail_setting as $key => $CategoryThumbnail){
                                                                      $Category_Thumbnail[] = $CategoryThumbnail ; 
                                                                      }
                                                                  echo implode(','.' ', $Category_Thumbnail);
                                                              ?>
                                                        @endif
                                                      </div>
                    
                                                    <div class="hover-buttons">
                                                        <a type="button" class="text-white d-flex align-items-center"
                                                             href="<?php echo URL::to('live') ?><?= '/' . $category_video->slug ?>">
                                                            <img class="ply mr-1" alt="ply" src="<?php echo URL::to('/').'/assets/img/default_play_buttons.svg';  ?>"  width="10%" height="10%"/>{{ __('Watch Now') }} 
                                                        </a>
                                                      
                                                    </div>                
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
            
            <?php } else:?>

            <div class="col-md-12 text-center mt-4">
                <h1 class="text-white text-center med">{{ __('Coming Soon') }}......</h1>
                <img class=" text-center w-100" src="<?php echo  URL::to('/assets/img/watch.png')?>" >
            </div>

        <?php endif; ?>
    </div>
</section>

@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp