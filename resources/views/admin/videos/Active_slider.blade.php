@include('admin.master')

@include('admin.favicon')

<style>
       .form-control {
    background: #fff!important; */
   
}
    .black{
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
border-radius: 0px 4px 4px 0px;
    }
    .black:hover{
        background: #fff;
         padding: 20px 20px;
        color: rgba(66, 149, 210, 1);

    }
</style>
@section('content')

<div id="content-page" class="content-page">
      <div class=" d-flex">
         <a class="black" href="{{ URL::to('admin/videos') }}">All Videos</a>
         <a class="black" href="{{ URL::to('admin/videos/create') }}">Add New Video</a>
         <a class="black" href="{{ URL::to('admin/CPPVideosIndex') }}">Videos For Approval</a>
         <a class="black"  href="{{ URL::to('admin/Masterlist') }}" class="iq-waves-effect"> Master Video List</a>
         <a class="black" href="{{ URL::to('admin/videos/categories') }}">Manage Video Categories</a>
         <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/ActiveSlider') }}">Active Slider List</a>
      </div>

    <div class="container-fluid p-0">
       <div class="row">
          <div class="col-sm-12">
             <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                   <div class="iq-header-title">
                      <h4 class="card-title">Active Slider Lists</h4>
                   </div>
                </div>

                {{-- Title Card --}}
                        <div class="row">
                           <div class="col-md-3">
                                 <div class="iq-card-body">
                                    <div class="media align-items-center">
                                       <div class="iq-user-box" style="background: #20c997 !important;"><p class="text-white">{{ ($Active_count) }}</p></div>
                                       <div class="media-body text-white">
                                          <p class="mb-0 font-size-14 line-height"> 
                                             Total Active Slider list
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                           </div>

                           <div class="col-md-3">
                              <div class="iq-card-body">
                                 <div class="media align-items-center">
                                    <div class="iq-user-box" style="background: #24c0d9 !important;"><p class="text-white">{{ count($Videos) }}</p></div>
                                    <div class="media-body text-white">
                                       <p class="mb-0 font-size-14 line-height"> 
                                          Total Active Slider Videos
                                       </p>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-3">
                              <div class="iq-card-body">
                                 <div class="media align-items-center">
                                    <div class="iq-user-box"  style="background: hsl(39deg 74% 73%) !important"><p class="text-white">{{ count($LiveStream) }}</p></div>
                                    <div class="media-body text-white">
                                       <p class="mb-0 font-size-14 line-height"> 
                                          Total Active Slider Live Videos
                                       </p>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-3">
                              <div class="iq-card-body">
                                 <div class="media align-items-center">
                                    <div class="iq-user-box"  style="background: #17a2b8 !important;"><p class="text-white">{{ count($Episode) }}</p></div>
                                    <div class="media-body text-white">
                                       <p class="mb-0 font-size-14 line-height"> 
                                          Total Active Slider Episodes
                                       </p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                     </div>

                  <div class="iq-card-body table-responsive">
                     <div class="table-view">
                        <table class="table table-striped table-bordered table movie_table text-center" style="width:100%" id="master_list">
                           <thead>
                              <tr class="r1">
                                 <th>Title</th>
                                 <th>Rating</th>
                                 <th>Uploaded by</th>
                                 <th>Video Type</th>
                                 <th>Video Access</th>
                                 <th>Status</th>
                                 <th>Source</th>
                                 <th>Slider</th>
                                 <th>Action</th>
                              </tr>
                           </thead>

                           {{-- Videos --}}
                           <tbody>
                              @foreach($Videos as $key => $video)
                                 <tr>
                                    <td>
                                       <div class="media align-items-center">
                                          <div class="iq-movie">
                                             <a href="javascript:void(0);">
                                                <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}"
                                                         class="img-border-radius avatar-40 img-fluid" alt=""></a>
                                          </div>
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0">{{ $video->title }}</p>
                                          </div>
                                       </div>
                                    </td>
                                    
                                    <td>@if(isset($video->rating))  
                                       <svg class="duration-style" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M287.9 0C297.1 0 305.5 5.25 309.5 13.52L378.1 154.8L531.4 177.5C540.4 178.8 547.8 185.1 550.7 193.7C553.5 202.4 551.2 211.9 544.8 218.2L433.6 328.4L459.9 483.9C461.4 492.9 457.7 502.1 450.2 507.4C442.8 512.7 432.1 513.4 424.9 509.1L287.9 435.9L150.1 509.1C142.9 513.4 133.1 512.7 125.6 507.4C118.2 502.1 114.5 492.9 115.1 483.9L142.2 328.4L31.11 218.2C24.65 211.9 22.36 202.4 25.2 193.7C28.03 185.1 35.5 178.8 44.49 177.5L197.7 154.8L266.3 13.52C270.4 5.249 278.7 0 287.9 0L287.9 0zM287.9 78.95L235.4 187.2C231.9 194.3 225.1 199.3 217.3 200.5L98.98 217.9L184.9 303C190.4 308.5 192.9 316.4 191.6 324.1L171.4 443.7L276.6 387.5C283.7 383.7 292.2 383.7 299.2 387.5L404.4 443.7L384.2 324.1C382.9 316.4 385.5 308.5 391 303L476.9 217.9L358.6 200.5C350.7 199.3 343.9 194.3 340.5 187.2L287.9 78.95z"/></svg>
                                       {{ $video->rating }} @else
                                       <svg class="duration-style" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M287.9 0C297.1 0 305.5 5.25 309.5 13.52L378.1 154.8L531.4 177.5C540.4 178.8 547.8 185.1 550.7 193.7C553.5 202.4 551.2 211.9 544.8 218.2L433.6 328.4L459.9 483.9C461.4 492.9 457.7 502.1 450.2 507.4C442.8 512.7 432.1 513.4 424.9 509.1L287.9 435.9L150.1 509.1C142.9 513.4 133.1 512.7 125.6 507.4C118.2 502.1 114.5 492.9 115.1 483.9L142.2 328.4L31.11 218.2C24.65 211.9 22.36 202.4 25.2 193.7C28.03 185.1 35.5 178.8 44.49 177.5L197.7 154.8L266.3 13.52C270.4 5.249 278.7 0 287.9 0L287.9 0zM287.9 78.95L235.4 187.2C231.9 194.3 225.1 199.3 217.3 200.5L98.98 217.9L184.9 303C190.4 308.5 192.9 316.4 191.6 324.1L171.4 443.7L276.6 387.5C283.7 383.7 292.2 383.7 299.2 387.5L404.4 443.7L384.2 324.1C382.9 316.4 385.5 308.5 391 303L476.9 217.9L358.6 200.5C350.7 199.3 343.9 194.3 340.5 187.2L287.9 78.95z"/></svg>
                                          @endif
                                    </td>

                                    <td> @if(isset($video->cppuser->username)) Uploaded by {{ $video->cppuser->username }} @else Uploaded by Admin @endif </td>
                                    <td>{{ $video->type }}</td>
                                 
                                    @if ($video->active == 0) 
                                          <td > <p class = "bg-warning video_active"><?php echo "Pending"; ?></p></td>
                                    @elseif ($video->active == 1) 
                                          <td > <p class = "bg-success video_active"><?php echo "Approved"; ?></p></td>
                                    @elseif ($video->active == 2) 
                                          <td> <p class = "bg-danger video_active"><?php echo "Rejected"; ?></p></td>
                                    @endif

                                    <td> {{ $video->access }} </td>

                                    <td> {{ 'Videos'}} </td>

                                    <td>
                                       <div class="mt-1">
                                          <label class="switch">
                                              <input name="video_status" class="video_status" id="{{ 'video_'.$video->id }}" type="checkbox" @if( $video->banner == "1") checked  @endif data-id={{ $video->id }}  data-type="video" onchange="updatebanner(this)" >
                                              <span class="slider round"></span>
                                          </label>
                                      </div>
                                    </td>


                                    <td>
                                       <div class="align-items-center list-user-action">
                                          <a class="iq-bg-warning mt-" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="View" href="{{ URL::to('/category/videos') . '/' . $video->slug }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>">
                                          </a>
                                       </div>
                                    </td>
                                 </tr>
                              @endforeach
                           </tbody>

                           {{-- livestream --}}

                           <tbody>
                              @foreach($LiveStream as $key => $video)
                                 <tr>
                                    <td>
                                       <div class="media align-items-center">
                                          <div class="iq-movie">
                                             <a href="javascript:void(0);">
                                                   <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}"
                                                   class="img-border-radius avatar-40 img-fluid" alt=""></a>
                                          </div>
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0"> @if(strlen($video->title) > 25) {{ substr($video->title, 0, 25) . '...' }}  @else {{ $video->title }} @endif</p>
                                          </div>
                                       </div>
                                    </td>
                                    
                                    <td>@if(isset($video->rating))  
                                       <svg class="duration-style" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M287.9 0C297.1 0 305.5 5.25 309.5 13.52L378.1 154.8L531.4 177.5C540.4 178.8 547.8 185.1 550.7 193.7C553.5 202.4 551.2 211.9 544.8 218.2L433.6 328.4L459.9 483.9C461.4 492.9 457.7 502.1 450.2 507.4C442.8 512.7 432.1 513.4 424.9 509.1L287.9 435.9L150.1 509.1C142.9 513.4 133.1 512.7 125.6 507.4C118.2 502.1 114.5 492.9 115.1 483.9L142.2 328.4L31.11 218.2C24.65 211.9 22.36 202.4 25.2 193.7C28.03 185.1 35.5 178.8 44.49 177.5L197.7 154.8L266.3 13.52C270.4 5.249 278.7 0 287.9 0L287.9 0zM287.9 78.95L235.4 187.2C231.9 194.3 225.1 199.3 217.3 200.5L98.98 217.9L184.9 303C190.4 308.5 192.9 316.4 191.6 324.1L171.4 443.7L276.6 387.5C283.7 383.7 292.2 383.7 299.2 387.5L404.4 443.7L384.2 324.1C382.9 316.4 385.5 308.5 391 303L476.9 217.9L358.6 200.5C350.7 199.3 343.9 194.3 340.5 187.2L287.9 78.95z"/></svg>
                                       {{ $video->rating }} @else
                                       <svg class="duration-style" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M287.9 0C297.1 0 305.5 5.25 309.5 13.52L378.1 154.8L531.4 177.5C540.4 178.8 547.8 185.1 550.7 193.7C553.5 202.4 551.2 211.9 544.8 218.2L433.6 328.4L459.9 483.9C461.4 492.9 457.7 502.1 450.2 507.4C442.8 512.7 432.1 513.4 424.9 509.1L287.9 435.9L150.1 509.1C142.9 513.4 133.1 512.7 125.6 507.4C118.2 502.1 114.5 492.9 115.1 483.9L142.2 328.4L31.11 218.2C24.65 211.9 22.36 202.4 25.2 193.7C28.03 185.1 35.5 178.8 44.49 177.5L197.7 154.8L266.3 13.52C270.4 5.249 278.7 0 287.9 0L287.9 0zM287.9 78.95L235.4 187.2C231.9 194.3 225.1 199.3 217.3 200.5L98.98 217.9L184.9 303C190.4 308.5 192.9 316.4 191.6 324.1L171.4 443.7L276.6 387.5C283.7 383.7 292.2 383.7 299.2 387.5L404.4 443.7L384.2 324.1C382.9 316.4 385.5 308.5 391 303L476.9 217.9L358.6 200.5C350.7 199.3 343.9 194.3 340.5 187.2L287.9 78.95z"/></svg>
                                          @endif
                                       </td>
      
                                    <td> @if(isset($video->cppuser->username)) Uploaded by {{ $video->cppuser->username }} @else Uploaded by Admin @endif </td>
                                    
                                    @if($video->access == "ppv" )
                                       <td> {{ "Paid" }}</td>
                                    @else
                                        <td> {{ "Free" }}</td>
                                    @endif

                                       @if ($video->active == 0) 
                                          <td > <p class = "bg-warning video_active"><?php echo "Pending"; ?></p></td>
                                       @elseif ($video->active == 1) 
                                          <td > <p class = "bg-success video_active"><?php echo "Approved"; ?></p></td>
                                       @elseif ($video->active == 2) 
                                          <td> <p class = "bg-danger video_active"><?php echo "Rejected"; ?></p></td>
                                       @endif
      
                                       <td> {{ $video->access }} </td>

                                       <td> {{ 'Live Stream'}} </td>

                                       <td>
                                          <div class="mt-1">
                                             <label class="switch">
                                                 <input name="livevideo_status" class="livevideo_status" id="{{ 'livestream_'.$video->id }}" 
                                                         type="checkbox" @if( $video->banner == "1") checked  @endif data-id={{ $video->id }}  data-type="livestream" onchange="updatebanner(this)" >
                                                 <span class="slider round"></span>
                                             </label>
                                         </div>
                                       </td>

                                    <td>
                                       <div class="align-items-center list-user-action">
                                          <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="View" href="{{ URL::to('live') .'/'.$video->slug }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>">
                                          </a>
                                       </div>
                                    </td>
                                 </tr>
                              @endforeach
                           </tbody>

                           {{-- Episodes --}}
                           <tbody>
                              @foreach($Episode as $key => $Episodes)
                                 <tr>
                                    <td>
                                       <div class="media align-items-center">
                                          <div class="iq-movie">
                                             <a href="javascript:void(0);">
                                                   <img src="{{ URL::to('/') . '/public/uploads/images/' . $Episodes->image }}"
                                                   class="img-border-radius avatar-40 img-fluid" alt=""></a>
                                          </div>
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0"> @if(strlen($Episodes->title) > 25) {{ substr($Episodes->title, 0, 25) . '...' }}  @else {{ $Episodes->title }} @endif</p>
                                          </div>
                                       </div>
                                    </td>
                                    
                                    <td>@if(isset($Episodes->rating))  
                                       <svg class="duration-style" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M287.9 0C297.1 0 305.5 5.25 309.5 13.52L378.1 154.8L531.4 177.5C540.4 178.8 547.8 185.1 550.7 193.7C553.5 202.4 551.2 211.9 544.8 218.2L433.6 328.4L459.9 483.9C461.4 492.9 457.7 502.1 450.2 507.4C442.8 512.7 432.1 513.4 424.9 509.1L287.9 435.9L150.1 509.1C142.9 513.4 133.1 512.7 125.6 507.4C118.2 502.1 114.5 492.9 115.1 483.9L142.2 328.4L31.11 218.2C24.65 211.9 22.36 202.4 25.2 193.7C28.03 185.1 35.5 178.8 44.49 177.5L197.7 154.8L266.3 13.52C270.4 5.249 278.7 0 287.9 0L287.9 0zM287.9 78.95L235.4 187.2C231.9 194.3 225.1 199.3 217.3 200.5L98.98 217.9L184.9 303C190.4 308.5 192.9 316.4 191.6 324.1L171.4 443.7L276.6 387.5C283.7 383.7 292.2 383.7 299.2 387.5L404.4 443.7L384.2 324.1C382.9 316.4 385.5 308.5 391 303L476.9 217.9L358.6 200.5C350.7 199.3 343.9 194.3 340.5 187.2L287.9 78.95z"/></svg>
                                       {{ $video->Episodes }} @else
                                       <svg class="duration-style" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M287.9 0C297.1 0 305.5 5.25 309.5 13.52L378.1 154.8L531.4 177.5C540.4 178.8 547.8 185.1 550.7 193.7C553.5 202.4 551.2 211.9 544.8 218.2L433.6 328.4L459.9 483.9C461.4 492.9 457.7 502.1 450.2 507.4C442.8 512.7 432.1 513.4 424.9 509.1L287.9 435.9L150.1 509.1C142.9 513.4 133.1 512.7 125.6 507.4C118.2 502.1 114.5 492.9 115.1 483.9L142.2 328.4L31.11 218.2C24.65 211.9 22.36 202.4 25.2 193.7C28.03 185.1 35.5 178.8 44.49 177.5L197.7 154.8L266.3 13.52C270.4 5.249 278.7 0 287.9 0L287.9 0zM287.9 78.95L235.4 187.2C231.9 194.3 225.1 199.3 217.3 200.5L98.98 217.9L184.9 303C190.4 308.5 192.9 316.4 191.6 324.1L171.4 443.7L276.6 387.5C283.7 383.7 292.2 383.7 299.2 387.5L404.4 443.7L384.2 324.1C382.9 316.4 385.5 308.5 391 303L476.9 217.9L358.6 200.5C350.7 199.3 343.9 194.3 340.5 187.2L287.9 78.95z"/></svg>
                                          @endif
                                       </td>
      
                                    <td> @if(isset($Episodes->cppuser->username)) Uploaded by {{ $Episodes->cppuser->username }} @else Uploaded by Admin @endif </td>
                                    
                                    @if($Episodes->access == "ppv" )
                                       <td> {{ "Paid" }}</td>
                                    @else
                                     <td> {{ "Free" }}</td>
                                    @endif

                                    @if ($Episodes->active == 0) 
                                       <td > <p class = "bg-warning video_active"><?php echo "Pending"; ?></p></td>
                                    @elseif ($Episodes->active == 1) 
                                       <td > <p class = "bg-success video_active"><?php echo "Approved"; ?></p></td>
                                    @elseif ($Episodes->active == 2) 
                                       <td> <p class = "bg-danger video_active"><?php echo "Rejected"; ?></p></td>
                                    @endif
      
                                    <td> {{ $Episodes->access }} </td>

                                    <td> {{ 'Episodes'}} </td>

                                    <td>
                                       <div class="mt-1">
                                          <label class="switch">
                                              <input name="episode_status" class="episode_status" id="{{ 'episodes_'.$Episodes->id }}" 
                                                   type="checkbox" @if( $Episodes->banner == "1") checked  @endif data-id={{ $Episodes->id }} data-type="episode"   onchange="updatebanner(this)" >
                                              <span class="slider round"></span>
                                          </label>
                                      </div>
                                    </td>
                                       
                                    <td>
                                       <div class="align-items-center list-user-action">
                                          <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="View" href="{{ URL::to('/episode'.'/'.$Episodes->series_title.'/'.$Episodes->slug) }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>">
                                          </a>
                                       </div>
                                    </td>
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

{{-- Jquery Table --}}
@section('javascript')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <script>
      $(document).ready( function () {
               $('#master_list').DataTable();
      });


      function updatebanner(ele){

            var video_id = $(ele).attr('data-id');
            var source = $(ele).attr('data-type');

               if(video_Status == true){
                     var banner_status  = '1';
               }else{
                     var banner_status  = '0';
               }

               if(source == "video"){
                  var type = "video";
                  var status   = '#video_'+video_id;
               }
               else if(source == "livestream" ){
                  var type = "Livestream";
                  var status   = '#livestream_'+video_id;
               }
               else if(source == "episode" ){
                  var type = "Episode";
                  var status   = '#episodes_'+video_id;
               }

            var video_Status = $(status).prop("checked");
            var check = confirm("Are you sure you want to remove this slider?");  

            if(check == true){ 

               $.ajax({
                        type: "POST", 
                        dataType: "json", 
                        url: "{{ url('admin/ActiveSlider_update') }}",
                              data: {
                                 _token  : "{{csrf_token()}}" ,
                                 video_id: video_id,
                                 banner_status: banner_status,
                                 type: type,
                        },
                        success: function(data) {
                              if(data.message == 'true'){
                                 location.reload();
                              }
                              else if(data.message == 'false'){
                                 swal.fire({
                                 title: 'Oops', 
                                 text: 'Something went wrong!', 
                                 allowOutsideClick:false,
                                 icon: 'error',
                                 title: 'Oops...',
                                 }).then(function() {
                                    location.href = '{{ URL::to('admin/ActiveSlider') }}';
                                 });
                              }
                           },
                     });
            }else if(check == false){
               $(status).prop('checked', true);

            }
      }
		
   </script>

@stop