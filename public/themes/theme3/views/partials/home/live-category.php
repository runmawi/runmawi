
<div class="container-fluid overflow-hidden">
    <div class="row">
        <div class="col-sm-12 ">
            
            <div class="iq-main-header d-flex align-items-center justify-content-between">
                <!-- <h4 class="main-title"><a href="<?php echo URL::to('home') ?>">Latest Videos</a></h4> -->
                <a href="<?php echo URL::to('/live/category/').'/'.$category->slug;?>" class="category-heading" style="text-decoration:none;color:#fff">
                    <h4 class="movie-title">
                        <?php
                        if(!empty($category->home_genre)){ echo 'Live'.' '.$category->home_genre ; }else{ echo 'Live'.' '.$category->name ; }  
                        //   echo __($category->name);
                          ?>
                    </h4>
                </a>
            </div>

            <div class="favorites-contens">
                <ul class="favorites-slider list-inline p-0 mb-0">
                <?php  if(!Auth::guest() && !empty($data['password_hash'])) { 
                          $id = Auth::user()->id ; } else { $id = 0 ; } ?>

                    <?php  if(isset($live_streams)) :
                       foreach($live_streams as $livestream):
                        if (!empty($livestream->publish_time))
                        {
                          $currentdate = date("M d , y H:i:s");
                          date_default_timezone_set('Asia/Kolkata');
                          $current_date = Date("M d , y H:i:s");
                          $date = date_create($current_date);
                          $currentdate = date_format($date, "D h:i");
                          $publish_time = date("D h:i", strtotime($livestream->publish_time));
                          if ($livestream->publish_type == 'publish_later')
                          {
                              if ($currentdate < $publish_time)
                              {
                                $publish_time = date("D h:i", strtotime($livestream->publish_time));
                                $publish_time  = \Carbon\Carbon::create($livestream->created_at, 'Asia/Kolkata')->format('h:i');
                                $publish_day  = \Carbon\Carbon::create($livestream->created_at, 'Asia/Kolkata')->format('l');
                              }else{
                                $publish_time = 'Published';
                                $publish_day = '';
                              }
                          }
                          elseif ($livestream->publish_type == 'publish_now')
                          {
                            $currentdate = date_format($date, "y M D");

                            $publish_time = date("y M D", strtotime($livestream->created_at));

                              if ($currentdate == $publish_time)
                              {
                                $publish_time = date("D h:i", strtotime($livestream->created_at));
                                $publish_time  = \Carbon\Carbon::create($livestream->created_at, 'Asia/Kolkata')->format('h:i');
                                $publish_day  = \Carbon\Carbon::create($livestream->created_at, 'Asia/Kolkata')->format('l');
                              }else{
                                $publish_time = 'Published';
                                $publish_day = '';
                              }
                          }else{
                            $publish_time = 'Published';
                            $publish_day = '';
                          }
                        }else{

                            date_default_timezone_set('Asia/Kolkata');
                            $current_date = Date("M d , y H:i:s");
                            $date = date_create($current_date);

                            $currentdate = date_format($date, "y M D");

                            $publish_time = date("y M D", strtotime($livestream->created_at));

                              if ($currentdate == $publish_time)
                              {
                                $publish_time = date("D h:i", strtotime($livestream->created_at));
                                $publish_time  = \Carbon\Carbon::create($livestream->created_at, 'Asia/Kolkata')->format('h:i');
                                $publish_day  = \Carbon\Carbon::create($livestream->created_at, 'Asia/Kolkata')->format('l');
                              }else{
                                $publish_time = 'Published';
                                $publish_day = '';
                              }
                          }
                           ?>
                        <li class="slide-item">
                            <a href="<?php echo URL::to('live') ?><?= '/' . $livestream->slug ?>">
                                <div class="block-images position-relative">
                                                                
                                    <div class="img-box">    <!-- block-images -->
                                        <img src="<?php echo URL::to('/').'/public/uploads/images/'.$livestream->image;  ?>" class="img-fluid w-100" alt="live-c">
                                    
                                        
                                    </div>

                                    <div class="block-description">
                                        

                                        <div class="hover-buttons">
                                            <a class="" href="<?php echo URL::to('live') ?><?= '/' . $livestream->slug ?>">
                                                <div class="playbtn" style="gap:5px">    {{-- Play --}}
                                                    <span class="text pr-2"> Play </span>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7" xml:space="preserve">
                                                        <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="73.5,62.5 148.5,105.8 73.5,149.1 " style="stroke: white !important;"></polygon>
                                                        <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3" style="stroke: white !important;"></circle>
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>
                                    </a>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php   endforeach;  endif; ?>


            </div>
        </div>
    </div>
</div>
