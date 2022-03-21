@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
@section('content')
<?php //dd($cppuser); ?>
     <div id="content-page" class="content-page">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Video Lists</h4>
                        </div>
                        
                        
                         <div class="iq-card-header-toolbar d-flex align-items-baseline">
                    <!-- <label class="p-2">Videos By CPP Users:</label> -->
                         <div class="form-group mr-2">                  
                                    <select id="cpp_user_videos" name="cpp_user_videos"  class="form-control" >
                                    <option value="">Select Videos By CPP</option>
                                        <option value="cpp_videos">Videos ( Uploaded By CPP Users )</option>
                                    </select>
                  </div>
                             <div class="form-group mr-2">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" />
                    </div>
                           <a href="{{ URL::to('admin/videos/create') }}" class="btn btn-primary">Add movie</a>
                        </div>
                     </div>
                     <div class="iq-card-body table-responsive p-0">
                        <div class="table-view">
                           <table class="table text-center table-striped table-bordered table movie_table iq-card " style="width:100%">
                              <thead>
                                 <tr class="r1">
                                    <th>Title</th>
                                    <th>Rating</th>
                                    <!-- <th>Category</th> -->
                                    <!-- <th>Release Year</th> -->
                                    <th>Uploaded by</th>
                                    <th>Video Type</th>
                                    <th>Video Access</th>
                                    <th>Status</th>
                                    <!-- <th>Language</th> -->
                                    <!--<th style="width: 20%;">Description</th>-->
                                     <th>Views</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                              @foreach($videos as $key => $video)
                                 <tr>
                                    <td>
                                       <div class="media align-items-center">
                                          <div class="iq-movie">
                                             <a href="javascript:void(0);"><img
                                                   src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}"
                                                   class="img-border-radius avatar-40 img-fluid" alt=""></a>
                                          </div>
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0">{{ $video->title }}</p>
                                             <!-- <small>2h 15m</small> -->
                                          </div>
                                       </div>
                                    </td>
                                    <!-- <td>{{ $video->rating }}</td> -->
                                    <td>@if(isset($video->rating))  
                                       <svg class="duration-style" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M287.9 0C297.1 0 305.5 5.25 309.5 13.52L378.1 154.8L531.4 177.5C540.4 178.8 547.8 185.1 550.7 193.7C553.5 202.4 551.2 211.9 544.8 218.2L433.6 328.4L459.9 483.9C461.4 492.9 457.7 502.1 450.2 507.4C442.8 512.7 432.1 513.4 424.9 509.1L287.9 435.9L150.1 509.1C142.9 513.4 133.1 512.7 125.6 507.4C118.2 502.1 114.5 492.9 115.1 483.9L142.2 328.4L31.11 218.2C24.65 211.9 22.36 202.4 25.2 193.7C28.03 185.1 35.5 178.8 44.49 177.5L197.7 154.8L266.3 13.52C270.4 5.249 278.7 0 287.9 0L287.9 0zM287.9 78.95L235.4 187.2C231.9 194.3 225.1 199.3 217.3 200.5L98.98 217.9L184.9 303C190.4 308.5 192.9 316.4 191.6 324.1L171.4 443.7L276.6 387.5C283.7 383.7 292.2 383.7 299.2 387.5L404.4 443.7L384.2 324.1C382.9 316.4 385.5 308.5 391 303L476.9 217.9L358.6 200.5C350.7 199.3 343.9 194.3 340.5 187.2L287.9 78.95z"/></svg>
                                       {{ $video->rating }} @else
                                       <svg class="duration-style" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M287.9 0C297.1 0 305.5 5.25 309.5 13.52L378.1 154.8L531.4 177.5C540.4 178.8 547.8 185.1 550.7 193.7C553.5 202.4 551.2 211.9 544.8 218.2L433.6 328.4L459.9 483.9C461.4 492.9 457.7 502.1 450.2 507.4C442.8 512.7 432.1 513.4 424.9 509.1L287.9 435.9L150.1 509.1C142.9 513.4 133.1 512.7 125.6 507.4C118.2 502.1 114.5 492.9 115.1 483.9L142.2 328.4L31.11 218.2C24.65 211.9 22.36 202.4 25.2 193.7C28.03 185.1 35.5 178.8 44.49 177.5L197.7 154.8L266.3 13.52C270.4 5.249 278.7 0 287.9 0L287.9 0zM287.9 78.95L235.4 187.2C231.9 194.3 225.1 199.3 217.3 200.5L98.98 217.9L184.9 303C190.4 308.5 192.9 316.4 191.6 324.1L171.4 443.7L276.6 387.5C283.7 383.7 292.2 383.7 299.2 387.5L404.4 443.7L384.2 324.1C382.9 316.4 385.5 308.5 391 303L476.9 217.9L358.6 200.5C350.7 199.3 343.9 194.3 340.5 187.2L287.9 78.95z"/></svg>
                                        0 @endif</td>

                                    <!-- <td>@if(isset($video->category['categoryname']->name)) {{ @$video->category['categoryname']->name }} @endif</td> -->
                                    <!-- <td>@if(!empty(@$value->category[$key]->categoryname->name)) {{ @$value->category[$key]->categoryname->name }} @endif</td> -->

                                    <!-- <td>{{ @$value->category[$key]->categoryname->name }}</td> -->
                                    <!-- <td>{{ $video->draft }}</td> -->
                                    <!-- <td>
                                   
                                    </td> -->
                                    <td>@if(isset($video->cppuser->username)) Uploaded by {{ $video->cppuser->username }} @else Uploaded by Admin @endif</td>

                                    <td>{{ $video->type }}</td>
                                    <td>{{ $video->access }}</td>
                                   
                                    <?php if($video->active == 0){ ?>
                                     <td > <p class = "bg-warning video_active"><?php echo "Pending"; ?></p></td>
                                    <?php }elseif($video->active == 1){ ?>
                                     <td > <p class = "bg-success video_active"><?php  echo "Approved"; ?></p></td>
                                    <?php }elseif($video->active == 2){ ?>
                                     <td> <p class = "bg-danger video_active"><?php  echo "Rejected"; ?></p></td>
                                    <?php }?>

                                    
                                    
                             
                                    <!-- <td> @if(isset($video->languages->name)) {{ $video->languages->name }} @endif</td> -->
                                    <td>
                                       <!--<p> {{ substr($video->description, 0, 50) . '...' }} </p>-->
                                        {{ $video->views }}<i class="lar la-eye "></i>
                                    </td>
                                    <td>
                                       <div class="flex align-items-center list-user-action">
                                          <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="View" href="{{ URL::to('/category/videos') . '/' . $video->slug }}"><i class="lar la-eye"></i></a>
                                          <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit" href="{{ URL::to('admin/videos/edit') . '/' . $video->id }}"><i class="ri-pencil-line"></i></a>
                                          <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Delete" onclick="return confirm('Are you sure?')" href="{{ URL::to('admin/videos/delete') . '/' . $video->id }}"><i
                                                class="ri-delete-bin-line"></i></a>
                                       </div>
                                    </td>
                                 </tr>
                                 @endforeach

                              </tbody>
                           </table>
                           <div class="clear"></div>
		<div class="pagination-outter mt-3 pull-right" >
      <!-- showing 1 to 5 of 2095 -->
      <h6>Showing {{ $videos->firstItem() }} - {{ $videos->lastItem() }} of {{ $videos->total() }} </h6>
      <!-- (for page {{ $videos->currentPage() }} ) -->
      <?= $videos->appends(Request::only('s'))->render(); ?></div>
		
		</div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      
         <script>
$(document).ready(function(){

 fetch_customer_data();

 function fetch_customer_data(query = '')
 {
  $.ajax({
   url:"{{ URL::to('/admin/live_search') }}",
   method:'GET',
   data:{query:query},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
   }
  })
 }

 $(document).on('keyup', '#search', function(){
  var query = $(this).val();
  fetch_customer_data(query);
 });
});
</script>
@section('javascript')
	<script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>
	<script>

		$(document).ready(function(){
			var delete_link = '';

			$('.delete').click(function(e){
				e.preventDefault();
				delete_link = $(this).attr('href');
				swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this video?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
			    return false;
			});
		});

	</script>

<script>
$.ajaxSetup({
           headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });


	$(document).ready(function(){

$('#cpp_user_videos').change(function(){
   var val = $('#cpp_user_videos').val();
   if(val == "cpp_videos"){
	$.ajax({
   url:"{{ URL::to('admin/cppusers_videodata') }}",
   method:'get',
   data:{query:val},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
   }
    });
   }
})

});
	
</script>
	@stop

@stop

