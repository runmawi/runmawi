@php
   include(public_path('themes/default/views/header.php'));
@endphp

<!-- MainContent -->

<section id="iq-favorites">
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12 page-height">

         @if(isset($DocumentList['latest_Documents']) && count($DocumentList['latest_Documents']) > 0 )

            <div class="iq-main-header align-items-center justify-content-between">
               <h3 class="vid-title">{{ __('Latest Videos') }}</h3>
            </div>
            
            <div class="favorites-contens">
               <ul class="category-page list-inline row p-0 mb-0">
                     @forelse($DocumentList['latest_Documents'] as $Document)

                        <li class="slide-item col-sm-2 col-md-2 col-xs-12">
                           <a  target="_blank" href="{{ url('public/uploads/Document/'.$Document->document) }}">
                              <div class="block-images position-relative">
                                 <div class="img-box">
                                    <img src="<?php echo URL::to('/').'/public/uploads/Document/'.$Document->image;  ?>" class="img-fluid w-100" alt="">
                                 </div>

                                 <div class="block-description">
                                    @if( $DocumentList['ThumbnailSetting']->title == 1)  <!-- Title -->
                                       <a  target="_blank" href="{{ url('public/uploads/Document/'.$Document->document) }}">
                                          <h6><?php  echo (strlen($Document->name) > 17) ? substr($Document->name,0,18).'...' : $Document->name; ?></h6>
                                       </a>
                                    @endif  

                                  
                                    <div class="hover-buttons">
                                       <a   target="_blank" href="{{ url('public/uploads/Document/'.$Document->document) }}">	
                                          <span class="text-white">
                                             <i class="fa fa-play mr-1" aria-hidden="true"></i> {{ __('View Now') }}
                                          </span>
                                       </a>
                                    <div>
                                 </div>
                              </div>

                              <div>
                                 <button type="button" class="show-details-button" data-toggle="modal" data-target="#myModal<?= $Document->id;?>">
                                    <span class="text-center thumbarrow-sec">
                                    </span>
                                 </button>
                              </div>
                              </div>
                              </div>
                           </a>
                        </li>
                     @empty
                        <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
                           <p ><h3 class="text-center">{{ __('No Latest Document Available') }}</h3>
                        </div>
                     @endforelse
               </ul>

               <div class="col-md-12 pagination justify-content-end" >
                  {!! $DocumentList['latest_Documents']->links() !!}
               </div>

            </div>
         @else
            <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
               <p ><h3 class="text-center">{{ __('No Latest Document Available') }}</h3>
            </div>
         @endif
      </div>
   </div>
</div>
<?php include(public_path('themes/default/views/footer.blade.php'));  ?>