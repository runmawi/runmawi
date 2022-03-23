@extends('admin.master')
<style>
    .form-control {
    background: #fff!important; */
   
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
                <div class="col-lg-8">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between align-items-center">
                            <div class="iq-header-title">
                                <h4 class="card-title">Get Started </h4>
                                <p class="p1">You are 3 steps away from completion</p>
                            </div>
                            <div id="top-rated-item-slick-arrow" class="slick-aerrow-block"></div>
                        </div>
                        <div class="iq-card-body">
                            <p></p>
                             <div class="row">
                                <div class="col-sm-6">
                                   <div class="nav flex-column nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                      <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Upload your Content</a>
                                      <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Go to OTT platform Settings</a>
                                      <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Payment Plans</a>
                                   </div>
                                </div>
                                <div class="col-sm-6">
                                   <div class="tab-content mt-0" id="v-pills-tabContent">
                                      <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                         <label class="m-0">First things firt, you need Video.</label>
                                         <p class="p1">Upload a video to get started.</p>
                                         <a href="/admin/videos/create">Upload Videos Now</a>
                                      </div>
                                      <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                          <p class="p1">Setup website logo, Name, Social Links, Payment Types, etc.</p>
                                          <a href="/admin/settings">Go to Storefront Settings</a>
                                      </div>
                                      <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                          <p class="p1">Setup subscription Plans</p>
                                          <a href="/admin/subscription-plans">Add Subscription Plans</a>
                                      </div>
                                   </div>
                                </div>
                             </div>
                        </div>
                    </div> 
                </div>
             </div>
            <div class="row">
               <div class="col-lg-8">
                  <div class="row">
                     <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                           <div class="iq-card-body1" >
                              <div class="d-flex align-items-center justify-content-between">
                                 <div class="iq-cart-text text-capitalize">
                                    <p class="mb-0">
                                       view
                                    </p>
                                 </div>
                                 <div class="icon iq-icon-box-top rounded-circle ">
                                    <img class="ply" src="<?php echo URL::to('/').'/assets/img/views.png';  ?>"> 
                                 </div>
                              </div>
                              <div class="d-flex align-items-center justify-content-between mt-3">
                                 <h4 class=" mb-0">{{ $view }}</h4>
                                 <p class="mb-0 text-primary"><span><i class="fa fa-caret-down mr-2"></i></span>35%</p>
                              </div>
                           </div>
                        </div>
                     </div>
                     {{-- <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="iq-card0 iq-card-block iq-card-stretch iq-card-height">
                           <div class="iq-card-body1">
                              <div class="d-flex  justify-content-between align-items-center">
                                 <div class="iq-cart-text text-capitalize">
                                    <p class="mb-0 font-size-14">
                                       Rated This App
                                    </p>
                                 </div>
                                 <div class="icon iq-icon-box-top rounded-circle ">
                                    <img class="ply" src="<?php echo URL::to('/').'/assets/img/c.png';  ?>"> 
                                 </div>
                              </div>
                              <div class="d-flex align-items-center justify-content-between mt-3">
                                 <h4 class=" mb-0">+55K</h4>
                                 <p class="mb-0 text-primary"><span><i class="fa fa-caret-up mr-2"></i></span>50%</p>
                              </div>
                           </div>
                        </div>
                     </div> --}}
                     {{-- <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="iq-card0 iq-card-block iq-card-stretch iq-card-height">
                           <div class="iq-card-body1">
                              <div class="d-flex align-items-center justify-content-between">
                                 <div class="iq-cart-text text-capitalize">
                                    <p class="mb-0 font-size-14">
                                       Downloaded
                                    </p>
                                 </div>
                                 <div class="icon iq-icon-box-top rounded-circle ">
                                     <img class="ply" src="<?php echo URL::to('/').'/assets/img/download.png';  ?>"> 
                                 </div>
                              </div>
                              <div class="d-flex mt-4 align-items-center justify-content-between mt-3">
                                 <h4 class=" mb-0">+1M</h4>
                                 <p class="mb-0 text-primary"><span><i class="fa fa-caret-up mr-2"></i></span>80%</p>
                              </div>
                           </div>
                        </div>
                     </div> --}}
                     <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                           <div class="iq-card-body1">
                              <div class="d-flex align-items-center justify-content-between">
                                 <div class="iq-cart-text text-uppercase">
                                    <p class="mb-0 font-size-14">
                                       Visitors
                                    </p>
                                 </div>
                                 <div class="icon iq-icon-box-top rounded-circle ">
                                      <img class="ply" src="<?php echo URL::to('/').'/assets/img/visitor.png';  ?>"> 
                                 </div>
                              </div>
                              <div class="d-flex align-items-center justify-content-between mt-3">
                                 <h4 class=" mb-0">{{  $visitor }} </h4>
                                 <p class="mb-0 text-primary"><span><i class="fa fa-caret-up mr-2"></i></span>100%</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="mt-3">
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
                           <li class="col-sm-6 col-lg-4 col-xl-4 iq-rated-box">
                              <div class="iq-card mb-0">
                                 <div class="iq-card-body p-0">
                                    <div class="iq-thumb">
                                       <a href="javascript:void(0)">
                                          <img src="{{  URL::to('/').'/public/uploads/images/'.$top_video->image }}" class="img-fluid w-100 img-border-radius" alt="">
                                       </a>
                                    </div>
                                    <div class="iq-feature-list">
                                       <h6 class="font-weight-600 mb-0">{{  $top_video->title }}</h6>
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
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="iq-card iq-card iq-card-block iq-card-stretch iq-card-height">
                     <div class="iq-card-header">
                        <div class="iq-header-title">
                           <h4 class="card-title text-center">User's Of {{ GetWebsiteName() }}</h4>
                        </div>
                     </div>
                     <div class="iq-card-body pb-0">
                        <div id="view-chart-01">
                        </div>
                        <div class="row mt-1">
                           <div class="col-sm-6 col-md-3 col-lg-12 iq-user-list">
                              <div class="iq-card1">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box bg-primary"><p class="text-white">{{ TotalSubscribercount() }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height"> Total  
                                          Subscriber's
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-3 col-lg-12 iq-user-list">
                              <div class="iq-card1">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box bg-warning"><p class="bg-warning">{{ TotalNewSubscribercount() ? TotalNewSubscribercount() : 0 }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height">
                                           New Subscriber's
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-3 col-lg-12 iq-user-list">
                              <div class="iq-card1">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box bg-info"><p class="text-white">{{ TotalVideocount() }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height"> Total 
                                                Video's
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-3 col-lg-12 iq-user-list">
                              <div class="iq-card1">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box bg-success"><p class="bg-success">{{  $visitor }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height">  Total
                                          Visitor's
                                          </p>
                                       <!-- <h5 class=" mb-0">{{  $visitor }} </h5> -->
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-12  col-lg-5">
                  <div class=" iq-card-block iq-card-stretch iq-card-height">
                     <div class="iq-card-header d-flex align-items-center justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Categories</h4>
                        </div>
                     </div>
                     <div class="iq-card-body p-0">
                        <!-- <div id="view-chart-03"></div> -->
                        <?php
                        foreach(@ $video_category as $key => $value){ ?>
                           <div class="col-sm-6 col-md-4 col-lg-6 mb-3">
                           <div class="iq-progress-bar progress-bar-vertical iq-bg-primary">
                              <span class="bg-primary" data-percent="100" style="transition: height 2s ease 0s; width: 100%; height: 40%;"></span>
                           </div>
                           <div class="media align-items-center">
                              <div class="iq-icon-box-view rounded mr-3 iq-bg-secondary"><i class="las la-film font-size-32"></i></div>
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
               </div>
               <div class="col-lg-7">
                  <div class=" iq-card-block iq-card-stretch iq-card-height">
                     <div class="iq-card-header d-flex align-items-center justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Top Category</h4>
                        </div>
                        <!-- <div class="iq-card-header-toolbar d-flex align-items-center seasons">
                           <div class="iq-custom-select d-inline-block sea-epi s-margin">
                              <select name="cars" class="form-control season-select">
                                 <option value="season1">Today</option>
                                 <option value="season2">This Week</option>
                                 <option value="season2">This Month</option>
                              </select>
                           </div>
                        </div> -->
                     </div>
                     <div class="iq-card-body row align-items-center">
                        <div class="col-lg-9">
                           <div class="row list-unstyled mb-0 pb-0">
                           <?php $all_category = App\VideoCategory::all();
                                    foreach($all_category as $category) { 
                                       // $categoty_sum = App\Video::where("video_category_id","=",$category->id)->sum('views');
                                       $categoty_sum = App\CategoryVideo::select('videos.*')
                                       ->Join('videos', 'videos.id', '=', 'categoryvideos.video_id')
                                       ->where("category_id","=",$category->id)->sum('videos.views');
                                       ?>                                   
                              <div class="col-sm-6 col-md-5 col-lg-6 mb-3">
                                 <div class="iq-progress-bar progress-bar-vertical iq-bg-primary">
                                    <span class="bg-primary" data-percent="100" style="transition: height 2s ease 0s; width: 100%; height: 40%;"></span>
                                 </div>
                                 <div class="media align-items-center">
                                    <div class="iq-icon-box-view rounded mr-3 iq-bg-secondary"><i class="las la-film font-size-32"></i></div>
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
                  </div>
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
                                    <th style="width:20%;">Video</th>
                                    <th style="width:20%;">Rating</th>
                                    <th style="width:20%;">Category</th>
                                    <th style="width:10%;">Views</th>
                                    
                                    <!-- <th style="width:20%;">Date</th> -->
                                    <th style="width:10%;"><i class="lar la-heart"></i></th>
                                 </tr>
                              </thead>
                              <tbody>
                              @foreach($recent_views as $views)
                                  <?php 
                                  $video_detail = App\Video::find($views->video_id); 
                                  $user_detail = App\User::find($views->user_id);
                                  if (isset($video_detail) && !empty($video_detail)) {
                                  ?>
                                 <tr>
                                    <td>
                                       <div class="media align-items-center">
                                          <div class="iq-movie">
                                             <a href="javascript:void(0);"><img src="{{ URL::to('/').'/public/uploads/images/'.$video_detail->image }}" class="img-border-radius avatar-40 img-fluid" alt=""></a>
                                          </div>
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0">{{ $video_detail->title }}</p>
                                             <small>{{ $video_detail->duration }} </small>
                                          </div>
                                       </div>
                                    </td>
                                    <td><i class="lar la-star mr-2"></i><i class="lar la-star mr-2"></i><i class="lar la-star mr-2"></i><i class="lar la-star mr-2"></i><i class="lar la-star mr-2"></i> <!--{{ $video_detail->rating }}--></td>
                                    <td>{{ @$video_detail->categories->name }}</td>
                                    <td>
                                       {{ $video_detail->views }}<i class="lar la-eye "></i>
                                    </td>
                                    
                                    <!-- <td>21 July,2020</td> -->
                                    <td><i class="las la-heart text-primary"></i></td>
                                 </tr>
                                  <?php } ?>
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

 
         </script>

@stop