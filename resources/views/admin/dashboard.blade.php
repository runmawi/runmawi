@extends('admin.master')
<style>
    .form-control {
    background: #fff!important; */
   
}
    .tab-content{
        background-color: #fafafa;
        padding: 10px;
        border-radius: 10px;
    }
</style>
@section('content')
	<!--[hook_admin_dashboard_widgets_start]-->
		
		  <!-- Page Content  -->
<?php
   $number = TotalViewcount();
   if($number >= 1000) {
      $view = $number/1000 . "k";   // NB: you will want to round this
   }
   else {
      $view = $number;
   }     
   $visitor_count = TotalVisitorcount();
   if($visitor_count >= 1000) {
      $visitor = $visitor_count/1000 . "k";   // NB: you will want to round this
   }
   else {
      $visitor = $visitor_count;
   } 
?>


      <div id="content-page" class="content-page">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-lg-4">
                  <div class="iq-card iq-card iq-card-block iq-card-stretch iq-card-height">
                     <div class="iq-card-header">
                        <div class="iq-header-title">
                           <h4 class="card-title text-center" >User's Of {{ GetWebsiteName() }}</h4>
                        </div>
                     </div>
                     <div class="iq-card-body pb-0">
                        <div id="view-chart-01">
                        </div>
                        <div class="row mt-1">
                           <div class="col-sm-6 col-md-3 col-lg-12 iq-user-list">
                              <div class="">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box "><p class="">{{ TotalUsers() }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height"> Total  
                                          Users
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- <div class="col-sm-6 col-md-3 col-lg-12 iq-user-list">
                              <div class="">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box "><p class="">{{ TotalSubscribercount() }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height"> Total  
                                          Subscriber's
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div> -->
                           <div class="col-sm-6 col-md-3 col-lg-12 iq-user-list">
                              <div class="">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box "><p class="">{{ TotalNewSubscribercount() ? TotalNewSubscribercount() : 0 }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height">
                                           New Subscribers
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-3 col-lg-12 iq-user-list">
                              <div class="">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box "><p class="">{{ TotalVideocount() }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height"> Total 
                                                Videos
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-3 col-lg-12 iq-user-list">
                              <div class="">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box "><p class="">{{ TotalSeriescount() }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height"> Total 
                                                Series
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-3 col-lg-12 iq-user-list">
                              <div class="">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box "><p class="">{{ TotalEpisodescount() }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height"> Total 
                                                Episodes
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-3 col-lg-12 iq-user-list">
                              <div class="">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box "><p class="">{{ TotalLivestreamcount() }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height"> Total 
                                                Live streams
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-3 col-lg-12 iq-user-list">
                              <div class="">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box "><p class="">{{ currency_symbol() }}  {{ TotalRevenue() }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height"> Total 
                                          Revenue
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-3 col-lg-12 iq-user-list">
                              <div class="">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box "><p class="">{{ currency_symbol() }}  {{ TotalMonthlyRevenue() }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height"> Total 
                                          Monthly Revenue
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-3 col-lg-12 iq-user-list">
                              <div class="">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box "><p class="">{{ currency_symbol() }}  {{ TotalWeeklyRevenue() }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height"> Total 
                                          Weekly Revenue
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-3 col-lg-12 iq-user-list">
                              <div class="">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box "><p class="">{{ currency_symbol() }}  {{ TotalDailyRevenue() }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height"> Total 
                                          Daily Revenue
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-3 col-lg-12 iq-user-list">
                              <div class="">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box"><p class="">{{  $total_visitors }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height">  Total
                                          Visitors
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
                <div class="col-lg-8">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between align-items-center">
                            <div class="iq-header-title">
                                <h4 class="card-title">Get Started </h4>
                                <p class="p1">You are 3 steps away from completion</p>
                            </div>
                            <div class="iq-header-title">
                                 <?php 
                                    $users = App\User::where('id',1)->first(); 
                                    $date=date_create($users->package_ends);
                                    $package_ends = date_format($date,"Y-M-d"); 
                                  ?>
                              {{-- <p style="color:black;">Space Available: {{ $space_available }}</p>
                              <p style="color:black;">Space Usage: {{ $space_usage }} </p>
                              <p style="color:black;">Total Space Disk: {{ $space_disk }} </p> --}}
 
                            </div>

                            <div class="iq-header-title">

                                 <?php 
                                    $users = App\User::where('id',1)->first(); 
                                    $date=date_create($users->package_ends);
                                    $package_ends = date_format($date,"Y-M-d"); 
                                  ?>
                                 <p style="color:black;">Subscribed To {{ $users->package }}</p>
                                 <p style="color:black;">Package Ends On {{ $package_ends }} </p>

                                 <p style="color:black;" id="storage-info"></p>
                                 <input type="button" class="btn btn-primary" value="Show Storage" id="show-storage-btn">

                                 <button class="btn btn-primary ml-2" role="button" id="view_image_storage_size"> {{ ucwords('Image Storage Size') }} </button> <br>
                                 <button class="btn btn-primary mt-1" role="button" id="view_content_storage_size"> {{ ucwords('Content Storage Size') }} </button>
                                 {{-- <button class="btn btn-primary ml-2" role="button" id="view_root_folder_storage_size"> {{ ucwords('Root Folder Storage Size') }} </button> --}}
                            </div>
                            <div id="top-rated-item-slick-arrow" class="slick-aerrow-block"></div>
                        </div>
                        <div class="iq-card-body">
                           <p></p>
                           <div class="row align-items-center">
                              <div class="col-sm-6">
                                 <div class="nav flex-column nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Upload your Content</a>
                                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Setup Website Logo, Name, Social Links, Payment Types, Etc</a>
                                    <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Payment Plans</a>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="tab-content mt-0" id="v-pills-tabContent">
                                    <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                       <h6 class="m-0">First things first, you need Video.</h6>
                                       <p class="">Upload a video to get started.</p>
                                       <a href="{{ URL::to('/admin/videos/create') }}">Upload Videos Now</a>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                       
                                       <p class="">Setup website logo, Name, Social Links, Payment Types, etc.</p>
                                       <a href="{{ URL::to('/admin/settings') }}">Go to Storefront Settings</a>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                       <p class="">Setup subscription Plans</p>
                                       <a  href="{{ URL::to('/admin/subscription-plans') }}">Add Subscription Plans</a>
                                    </div>
                                 </div>
                              </div>
                              @if($settings->google_analytics_link != null)
                                 <div class="col-sm-6">
                                    <div class="pt-4">
                                       <a class="btn btn-primary" href="{{$settings->google_analytics_link}}"><span>Google Analytics</span></a>
                                    </div>
                                 </div>
                              @endif
                           </div>
                        </div>
                    </div> 
                </div>
                 
             </div>
            <div class="row">
                
               <div class="col-lg-12">
                  <div class="row">
                     {{-- <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                           <div class="iq-card-body1" >
                              <div class="d-flex align-items-center justify-content-center">
                                 <div class="iq-cart-text text-center text-capitalize">
                                      <img class="ply" src="<?php echo URL::to('/').'/assets/img/views.webp';  ?>" loading="lazy"> 
                                    <p class="mb-0 mt-3">
                                      Video's view
                                    </p>
                                 </div>
                                 
                              </div>
                              <div class="d-flex align-items-center justify-content-between mt-3">
                                 <h4 class=" mb-0">{{ TotalViewcount() }}</h4>
                                 <h6 class="mb-0 text-primary"><span><i class="fa fa-caret-down mr-2"></i></span>35%</h6>
                              </div>
                           </div>
                        </div>
                     </div> --}}
                     {{-- <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="iq-card0 iq-card-block iq-card-stretch iq-card-height">
                           <div class="iq-card-body1">
                              <div class="d-flex  justify-content-between align-items-center">
                                 <div class="iq-cart-text text-center text-capitalize">
                                      <img class="ply" src="<?php echo URL::to('/').'/assets/img/c.png';  ?>"> 
                                    <p class="mb-0 mt-3">
                                       Rated This App
                                    </p>
                                 </div>
                                 
                              </div>
                              <div class="d-flex align-items-center justify-content-between mt-3">
                                 <h4 class=" mb-0">+55K</h4>
                                 <h6 class="mb-0 text-primary"><span><i class="fa fa-caret-up mr-2"></i></span>50%</h6>
                              </div>
                           </div>
                        </div>
                     </div> --}}
                     {{-- <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="iq-card0 iq-card-block iq-card-stretch iq-card-height">
                           <div class="iq-card-body1">
                              <div class="d-flex align-items-center justify-content-center">
                                 <div class="iq-cart-text text-center text-capitalize">
                                      <img class="ply" src="<?php echo URL::to('/').'/assets/img/download.png';  ?>"> 
                                    <p class="mb-0 mt-3">
                                       Downloaded
                                    </p>
                                 </div>
                                 
                              </div>
                              <div class="d-flex mt-4 align-items-center justify-content-between mt-3">
                                 <h4 class=" mb-0">+1M</h4>
                                 <h6 class="mb-0 text-primary"><span><i class="fa fa-caret-up mr-2"></i></span>80%</h6>
                              </div>
                           </div>
                        </div>
                     </div> --}}
                     {{-- <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                           <div class="iq-card-body1">
                              <div class="d-flex align-items-center justify-content-center">
                                 <div class="iq-cart-text text-center text-uppercase">
                                      <img class="ply" src="<?php echo URL::to('/').'/assets/img/visitor.webp';  ?>" loading="lazy"> 
                                    <p class="mb-0 mt-3">
                                       Visitors
                                    </p>
                                 </div>
                                 
                              </div>
                              <div class="d-flex align-items-center justify-content-between mt-3">
                                 <h4 class=" mb-0">{{  $total_visitors }} </h4>
                                <h6 class="mb-0 text-primary"><span><i class="fa fa-caret-up mr-2"></i></span>100%</h6>
                              </div>
                           </div>
                        </div>
                     </div> --}}
                  </div>
                  {{-- <div class="mt-3">
                     <div class="iq-card-header d-flex justify-content-between align-items-center">
                        <div class="iq-header-title">
                           <h4 class="card-title">Top Rated Item </h4>
                            
                        </div>
                         <hr>
                        <div id="top-rated-item-slick-arrow" class="slick-aerrow-block"></div>
                     </div>
                     <div class="iq-card-body">
                        <ul class="list-unstyled row  mb-0">
                       
                            @foreach($top_rated_videos as $top_video)
                           <li class="col-sm-2 col-lg-2 col-xl-2 iq-rated-box p-0">
                              <div class="iq-card mb-0">
                                 <div class="iq-card-body p-0">
                                    <div class="iq-thumb">
                                       <a href="javascript:void(0)">
                                          <img src="{{  URL::to('/').'/public/uploads/images/'.$top_video->image }}" class="img-fluid w-100 img-border-radius" alt="">
                                       </a>
                                    </div>
                                    <div class="iq-feature-list">
                                     
                                    <h6 class="font-weight-600 mb-0">@if(strlen($top_video->title) > 17)  {{  substr($top_video->title,0,18).'...' }} @else {{ $top_video->title }} @endif</h6>
                                       <p class="mb-0 mt-2">{{  @$top_video->categories->name }}</p>
                                       <div class="d-flex align-items-center my-2">
                                          <p class="mb-0 mr-2"><i class="lar la-eye mr-1"></i> {{  $top_video->views }}</p>
                                          <p class="mb-0 "><i class="las la-download ml-2"></i> 30 k</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </li>
                           @endforeach
                        </ul>
                     </div>
                  </div> --}}
               </div>
               
            </div>
            <div class="row">
               {{-- <div class="col-sm-12  col-lg-5">
                  <div class=" iq-card-block iq-card-stretch iq-card-height">
                     <div class="iq-card-header d-flex align-items-center justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Categories</h4>
                        </div>
                     </div>
                     <div class="iq-card-body p-0">
                        <!-- <div id="view-chart-03"></div> -->
                        <?php
                        foreach( $video_category as $key => $value){ ?>
                           <div class="col-sm-6 col-md-4 col-lg-8 mb-3 p-0">
                           <div class="iq-progress-bar progress-bar-vertical iq-bg-primary">
                              <span class="bg-primary" data-percent="100" style="transition: height 2s ease 0s; width: 100%; height: 40%;"></span>
                           </div>
                           <div class="media align-items-center">
                              <div class="iq-icon-box-view rounded mr-3 iq-bg-secondary"> <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/icon.svg';  ?>" loading="lazy"> </div>
                              <div class="media-body text-white">
                                 <h6 class="mb-0 font-size-22 line"><?php echo ucfirst($key);?></h6>
                                 <small class=" mb-0 val">+ {{ $value }} Videos</small>
                              </div>
                           </div>
                        </div>
                   <?php     }
                        ?>                      
                     </div>
                  </div>
               </div> --}}
               <div class="col-lg-7">
                  {{-- <div class=" iq-card-block iq-card-stretch iq-card-height">
                     <div class="iq-card-header d-flex align-items-center justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Top Category</h4>
                        </div>
                         <div class="iq-card-header-toolbar d-flex align-items-center seasons">
                           <div class="iq-custom-select d-inline-block sea-epi s-margin">
                              <select name="cars" class="form-control season-select">
                                 <option value="season1">Today</option>
                                 <option value="season2">This Week</option>
                                 <option value="season2">This Month</option>
                              </select>
                           </div>
                        </div> 
                     </div>
                     <div class="iq-card-body row align-items-center">
                        <div class="col-lg-12">
                           <div class="row list-unstyled mb-0 pb-0">
                           <?php $all_category = App\VideoCategory::all();
                                    foreach($all_category as $category) { 
                                       // $categoty_sum = App\Video::where("video_category_id","=",$category->id)->sum('views');
                                       $categoty_sum = App\CategoryVideo::select('videos.*')
                                       ->Join('videos', 'videos.id', '=', 'categoryvideos.video_id')
                                       ->where("category_id","=",$category->id)->sum('videos.views');
                                       ?>                                   
                              <div class="col-sm-6 col-md-5 col-lg-6 mb-3 p-0">
                                 <div class="iq-progress-bar progress-bar-vertical iq-bg-primary">
                                    <span class="bg-primary" data-percent="100" style="transition: height 2s ease 0s; width: 100%; height: 40%;"></span>
                                 </div>
                                 <div class="media align-items-center">
                                    <div class="iq-icon-box-view rounded mr-3 iq-bg-secondary"> <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/icon.svg';  ?>" loading="lazy"></div>
                                    <div class="media-body text-white">
                                       <h6 class="mb-0 font-size-22 line"><?php echo ucfirst($category->name);?></h6>
                                       <small class="val mb-0">+ {{ $categoty_sum }} views</small>
                                    </div>
                                 </div>
                              </div>
                               <?php } ?>
                           </div>
                        </div>
                        <div class="col-lg-5">
                           <div id="view-chart-02" class="view-cahrt-02"></div>
                        </div>
                     </div>
                  </div> --}}
               </div>
               <div class="col-sm-12 mt-4">
                  <div class="">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Recently Viewed Items</h4>
                        </div>
                        
                     </div>
                      <div class="iq-card-body">
                        <div class="table-responsive">
                           <table class="data-tables table movie_table" style="width:100%">
                              <thead>
                                 <tr class="r1">
                                    <th style=""><img width="25" class="ply" src="<?php echo URL::to('/').'/assets/img/icon/video.svg';  ?>" loading="lazy">Video</th>
                                    <th style=""><img width="25" class="ply" src="<?php echo URL::to('/').'/assets/img/icon/rat.svg';  ?>" loading="lazy">Rating</th>
                                    <th style=""><img width="25" class="ply" src="<?php echo URL::to('/').'/assets/img/icon/ct.svg';  ?>" loading="lazy">Category</th>
                                    <th style=""><img width="25" class="ply" src="<?php echo URL::to('/').'/assets/img/icon/viw.svg';  ?>" loading="lazy">Views</th>
                                    
                                    <!-- <th style="width:20%;">Date</th> -->
                                    <th style=""><img width="25" class="ply" src="<?php echo URL::to('/').'/assets/img/icon/lik.svg';  ?>" loading="lazy">Favourites</th>
                                 </tr>
                              </thead>
                              <tbody>
                              @foreach($recent_views as $views)
                                  <?php 
                                  $video_detail = App\Video::find($views->video_id); 
                                    // $int = (int)$video_detail->rating;
                                    if(!empty($video_detail->rating)){
                                     $video_rating  = $video_detail->rating;
                                    }else{
                                       $video_rating = 0;
                                    }
                                    if($video_rating != 0){
                                    $float = (float)$video_rating;
                                    $rating = round($float, 0);
                                 //  dd(is_numeric($float));
                                  $user_detail = App\User::find($views->user_id);
                                  if($rating == $video_detail->rating ){
                                  if (isset($video_detail) && !empty($video_detail)) {
                                  ?>
                                 <tr>
                                    <td>
                                       <div class="media align-items-center">
                                          <div class="iq-movie">
                                             <a href="javascript:void(0);"><img src="{{ URL::to('/').'/public/uploads/images/'.@$video_detail->image }}" class="img-border-radius avatar-40 img-fluid" alt=""></a>
                                          </div>
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0">{{ @$video_detail->title }}</p>
                                             <small>{{ @$video_detail->duration }} </small>
                                          </div>
                                       </div>
                                    </td>
                                    <td>
                                    <?php    
                                    for($i=1; $i <= $video_detail->rating; $i++ ){ ?>
                                       <span class="fa fa-star checked"></span> 
                                        
                                  
                              
                                       <?php  } // } ?>
                                       <!-- <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/r1.svg';  ?>">
                                        <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/r1.svg';  ?>">
                                        <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/r1.svg';  ?>">
                                        <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/r2.svg';  ?>">
                                        <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/r2.svg';  ?>"> -->
                                        <!--{{ $video_detail->rating }}--></td>
                                    <td>{{ @$video_detail->categories->name }}</td>
                                    <!-- @foreach($video_detail->videocategory as $name)
                                       @foreach($name as $categoryname) -->

                                    <!-- <td> -->
                                    <!-- {{ @$name->name }} -->
                                    <!-- {{ @$video_detail->categories->name }} -->
                                    <!-- </td> -->
                                       <!-- @endforeach
                                    @endforeach -->

                                    <td>

                                       {{ @$video_detail->views }}
                                    </td>
                                    
                                    <!-- <td>21 July,2020</td> -->
                                    <td><i class="las la-heart text-primary"></i></td>
                                  <?php } }
                                   else{ ?>
<td>
                                       <div class="media align-items-center">
                                          <div class="iq-movie">
                                             <a href="javascript:void(0);"><img src="{{ URL::to('/').'/public/uploads/images/'.@$video_detail->image }}" class="img-border-radius avatar-40 img-fluid" alt=""></a>
                                          </div>
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0">{{ @$video_detail->title }}</p>
                                             <small>{{ @$video_detail->duration }} </small>
                                          </div>
                                       </div>
                                    </td>
                                    <td>
                                    <?php    
                                       $rating = round($video_detail->rating);
                                       for($i=1; $i < $rating; $i++ ){ ?>
                                          <span class="fa fa-star checked"></span> 
                                          <span class="fa fa-star-half-o"></span> 
                                       <?php  }   ?>
                                 
                                       

                                       <?php // } } ?>
                                       <!-- <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/r1.svg';  ?>">
                                        <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/r1.svg';  ?>">
                                        <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/r1.svg';  ?>">
                                        <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/r2.svg';  ?>">
                                        <img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/r2.svg';  ?>"> -->
                                        <!--{{ $video_detail->rating }}--></td>
                                    <td>{{ @$video_detail->categories->name }}</td>
                                    <td>
                                       {{ @$video_detail->views }}
                                    </td>
                                    
                                    <!-- <td>21 July,2020</td> -->
                                    <td><i class="las la-heart text-primary"></i></td>
                                    <?php }
                                    }else{ ?>
                                       <td>
                                       <div class="media align-items-center">
                                          <div class="iq-movie">
                                             <a href="javascript:void(0);"><img src="{{ URL::to('/').'/public/uploads/images/'.@$video_detail->image }}" class="img-border-radius avatar-40 img-fluid" alt=""></a>
                                          </div>
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0">{{ @$video_detail->title }}</p>
                                             <small>{{ @$video_detail->duration }} </small>
                                          </div>
                                       </div>
                                    </td>
                                    <td>
                                       
                                    </td>
                                    <td>{{ @$video_detail->categories->name }}</td>
                                    <td>
                                       {{ @$video_detail->views }}
                                    </td>
                                    
                                    <!-- <td>21 July,2020</td> -->
                                    <td><i class="las la-heart text-primary"></i></td>
                                   <?php }
                                       ?>
                                 </tr>

                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <script>
         document.getElementById('show-storage-btn').addEventListener('click', function() {

            fetch('admin/get-storage-data')
               .then(response => response.json())
               .then(data => {
                     document.getElementById('storage-info').innerText = data.storage_vai_symfony;
                     $('#show-storage-btn').hide();
               })
               .catch(error => {
                     console.error('Error fetching storage data:', error);
               });
         });   
         
         function viewStorageSize(message,id) {
            var check = confirm("Are you sure you want to view " + message + "?");
            if (check) {
               $.ajax({
                     type: "get",
                     dataType: "json",
                     url: "{{ route('admin.getFolderStorageData') }}",
                     data: {
                        _token: "{{ csrf_token() }}",
                        id:id,
                     },
                     success: function(response) {
                        if (response.status) {
                           let storageData = response.data;
                           let alertMessage = "Folder Storage Details:\n\n";

                           storageData.forEach(item => {
                                 alertMessage += `${item.path} - ${item.size}\n`;
                           });

                           alert(alertMessage);
                        } else {
                           alert('Oops... Something went wrong!');
                           window.location.href = '{{ url("admin") }}';
                        }
                     },
                     error: function(xhr, status, error) {
                        alert("An error occurred: " + error);
                        window.location.href = '{{ url("admin") }}';
                     }
               });
            }
         }

         $("#view_image_storage_size").click(function() {
            viewStorageSize("image storage size","view_image_storage_size");
         });

         $("#view_content_storage_size").click(function() {
            viewStorageSize("content storage size",'view_content_storage_size');
         });

         $("#view_root_folder_storage_size").click(function() {
            viewStorageSize("root folder storage size",'view_root_folder_storage_size');
         });

      </script>
<style> .fa { color: yellow}</style>
@stop