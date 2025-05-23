@extends('moderator.master')
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
   $users = App\User::where('id',1)->first();


   $LoggedDevice = App\LoggedDevice::count(); 
   $GuestLoggedDevice = App\GuestLoggedDevice::count();
   $total_visitors = $LoggedDevice + $GuestLoggedDevice ;
   $user = Session::get('user'); 
   $total_videos = App\Video::where('user_id',@$user->id)->where('uploaded_by','CPP')->count() ;

?>


      <div id="content-page" class="content-page">
         <div class="container-fluid">
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
                                 <div class="icon iq-icon-box-top rounded-circle bg-primary">
                                    <i class="las la-eye"></i>
                                 </div>
                              </div>
                              <div class="d-flex align-items-center justify-content-between mt-3">
                                 <h4 class=" mb-0">{{ $view }}</h4>
                                 <p class="mb-0 text-primary"><span><i class="fa fa-caret-down mr-2"></i></span>35%</p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="iq-card0 iq-card-block iq-card-stretch iq-card-height">
                           <div class="iq-card-body1">
                              <div class="d-flex  justify-content-between align-items-center">
                                 <div class="iq-cart-text text-capitalize">
                                    <p class="mb-0 font-size-14">
                                       Rated This App
                                    </p>
                                 </div>
                                 <div class="icon iq-icon-box-top rounded-circle bg-warning">
                                    <i class="lar la-star"></i>
                                 </div>
                              </div>
                              <div class="d-flex align-items-center justify-content-between mt-3">
                                 <h4 class=" mb-0">+55K</h4>
                                 <p class="mb-0 text-warning"><span><i class="fa fa-caret-up mr-2"></i></span>50%</p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="iq-card0 iq-card-block iq-card-stretch iq-card-height">
                           <div class="iq-card-body1">
                              <div class="d-flex align-items-center justify-content-between">
                                 <div class="iq-cart-text text-capitalize">
                                    <p class="mb-0 font-size-14">
                                       Downloaded
                                    </p>
                                 </div>
                                 <div class="icon iq-icon-box-top rounded-circle bg-info">
                                     <i class="las la-download"></i>
                                 </div>
                              </div>
                              <div class="d-flex mt-4 align-items-center justify-content-between mt-3">
                                 <h4 class=" mb-0">+1M</h4>
                                 <p class="mb-0 text-info"><span><i class="fa fa-caret-up mr-2"></i></span>80%</p>
                              </div>
                           </div>
                        </div>
                     </div> -->
                     <div class="col-sm-6 col-lg-6 col-xl-3">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                           <div class="iq-card-body1">
                              <div class="d-flex align-items-center justify-content-between">
                                 <div class="iq-cart-text text-uppercase">
                                    <p class="mb-0 font-size-14">
                                       Visitors
                                    </p>
                                 </div>
                                 <div class="icon iq-icon-box-top rounded-circle bg-success">
                                    <i class="lar la-user"></i>
                                 </div>
                              </div>
                              <div class="d-flex align-items-center justify-content-between mt-3">
                                 <h4 class=" mb-0">{{  $visitor }} </h4>
                                 <p class="mb-0 text-success"><span><i class="fa fa-caret-up mr-2"></i></span>100%</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="iq-card">
            
               
                     <div class="iq-card-header d-flex align-items-center justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Top Category</h4>
                        </div>

                     </div>
                     <div class="iq-card-body row align-items-center">
                        <div class="col-lg-7">
                           <div class="row list-unstyled mb-0 pb-0">
                           <?php $all_category = App\VideoCategory::where('uploaded_by','CPP')->get();
                                    foreach($all_category as $category) { 
                                       $categoty_sum = App\Video::where("video_category_id","=",$category->id)->sum('views');
                                       ?>                                   
                              <div class="col-sm-6 col-md-4 col-lg-6 mb-3">
                                 <div class="iq-progress-bar progress-bar-vertical iq-bg-primary">
                                    <span class="bg-primary" data-percent="100" style="transition: height 2s ease 0s; width: 100%; height: 40%;"></span>
                                 </div>
                                 <div class="media align-items-center">
                                    <div class="iq-icon-box-view rounded mr-3 iq-bg-secondary"><i class="las la-film font-size-32"></i></div>
                                    <div class="media-body text-white">
                                       <h6 class="mb-0 font-size-14 line-height"><?php echo ucfirst($category->name);?></h6>
                                       <small class="text-primary mb-0">+ {{ $categoty_sum }} views</small>
                                    </div>
                                 </div>
                              </div>
                               <?php } ?>
                           </div>
                        
                        <div class="col-lg-5">
                           <div id="view-chart-02" class="view-cahrt-02"></div>
                        </div>
                     </div>
                  </div>
                     <div class="iq-card-body">
                        <!-- <p style="color:black;">Subscribed To {{ $users->package }}</p> -->
                        <?php
                        
                        $date=date_create($users->package_ends);
                          $package_ends = date_format($date,"Y-M-d"); ?>
                        <!-- <p style="color:black;">Package Ends On {{ $package_ends }} </p> -->
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
                           <div class="col-sm-12 col-md-3 col-lg-12 iq-user-list">
                              <div class="iq-card1">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box bg-primary">{{ TotalSubscribercount() }}</div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height">Total Subscriber's 
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
                                       <div class="iq-user-box bg-warning">{{ TotalNewSubscribercount() ? TotalNewSubscribercount() : 0 }}</div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height">New
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
                                       <div class="iq-user-box bg-info">{{ @$total_videos }}</div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height">Total
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
                                       <div class="iq-user-box bg-danger">{{ $total_visitors }}</div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height">Total <br>
                                          Visitor's
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
            </div>

               </div>
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Recently Viewed Items</h4>
                        </div>
                        
                     </div>
                      <div class="iq-card-body">
                        <div class="table-responsive">
                           <table class="data-tables table movie_table" style="width:100%">
                              <thead>
                                 <tr>
                                    <th style="width:20%;">Video</th>
                                    <th style="width:10%;">Rating</th>
                                    <th style="width:20%;">Category</th>
                                    <th style="width:10%;">Views</th>
                                    
                                    <!-- <th style="width:20%;">Date</th> -->
                                    <th style="width:10%;"><i class="lar la-heart"></i></th>
                                 </tr>
                              </thead>
                              <tbody>
                              @foreach($recent_views as $views)
                                  <?php 
                                  $video_detail = App\Video::where('uploaded_by','CPP')->where('id',$views->video_id)->first(); 
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
                                    <td><i class="lar la-star mr-2"></i> {{ $video_detail->rating }}</td>
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