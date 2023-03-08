@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection

<style>
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
     .content-page {
    overflow: hidden;
        margin-left: 300px;}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">-->

@section('content')

     <div id="content-page" class="content-page">
         <div class="mt-5 d-flex">
                        <a class="black" href="{{ URL::to('admin/videos') }}">All Videos</a>
                        <a class="black" href="{{ URL::to('admin/videos/create') }}">Add New Video</a>
                        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/CPPVideosIndex') }}">Videos For Approval</a>
                        <a class="black" href="{{ URL::to('admin/Masterlist') }}" class="iq-waves-effect"> Master Video List</a>
                       <a class="black" href="{{ URL::to('admin/videos/categories') }}">Manage Video Categories</a>
                       <a class="black"  href="{{ URL::to('admin/ActiveSlider') }}">Active Slider List</a></div>

                       
         <div class="container-fluid p-0">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                       
                        <div class="row">
                           <div class="col-md-5">
                              <a href="{{ URL::to('/admin/CPPVideosIndex') }}"><button type="button" class="btn btn-default">CPP Uploaded Videos</button></a>
                           </div>
                           <div class="col-md-5">
                              <a href="{{ URL::to('/admin/ChannelVideosIndex') }}"><button type="button" class="btn btn-default" >Channel Uploaded Videos</button></a>
                           </div>
                        <div>
                           <br>
                        <h4>CPP Uploaded Videos</h4>
                           
                         <div class="iq-card-header-toolbar d-flex align-items-baseline">
                             <div class="form-group mr-2">
                    <!-- <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" /> -->
                    </div>
                        </div>
                     </div>
                     <div class="iq-card-body table-responsive p-0">
                        <div class="table-view">
                           <table class="table text-center table-striped table-bordered table movie_table iq-card"id="videocpp" style="width:100%">
                              <thead>
                                 <tr>
                                     
                                    <th>Title</th>
                                    <th>Video Uploaded By</th>
                                    <th>Video Type</th>
                                    <th>Uploaded Date</th>
                                    <th>Video Duration</th>
                                    <th>Video Category</th>
                                    <th>Video Meta</th>
                                    <th>Status</th>
                                    <th >Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                              @foreach($videos as $video)
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
                                          </div>
                                       </div>
                                    </td>
                                    <td>{{ $video->username }}</td>
                                    <td>{{ $video->type }}</td>
                                    <td>{{ $video->created_at }}</td>
                                    <td>{{ gmdate('H:i:s', $video->duration) }}</td>
                                    <td>{{ $video->name }}</td>
                                    <td>{{ $video->description }}</td>
                                    <!-- <td>{{ $video->access }}</td> -->
                                    
                                    <td>
                                    <?php if($video->active == 0){
                                        echo "Pending"; ?>
                                    <?php }elseif($video->active == 1){
                                        echo "Approved"; ?>
                                    <?php }elseif($video->active == 2){ 
                                        echo "Rejected";?>
                                    <?php }?>
                                   </td>                                
                                    <td colspan="2">
                                       <div class="flex align-items-center list-user-action">
                                          <a class="iq-bg-warning" 
                                          onclick="return confirm('Are You Approving Video ?')"  href="{{ URL::to('admin/CPPVideosApproval') . '/' . $video->id }}">  <i class="fa fa-check-circle" style="font-size:24px;color:blue"></i></span></a>
                                          <a class="iq-bg-success" 
                                              onclick="return confirm('Are You Rejecting Video ?')" href="{{ URL::to('admin/CPPVideosReject') . '/' . $video->id }}"> <i class="fa fa-close" style="font-size:24px;color:white;background:red;border-radius:50%"></i></span></a>
                                       </div>
                                    </td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                           <div class="clear"></div>
		
		</div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
</div>
<!--<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>-->
      
         <script>
$(document).ready(function(){
   $('#videocpp').DataTable();

 fetch_customer_data();

 function fetch_customer_data(query = '')
 {
  $.ajax({
   url:"{{ URL::to('/live_search') }}",
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

   <div class="container-fluid p-0">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                       
                        <div class="row">
                         
                     <div class="iq-card-body table-responsive p-0">
                        <div class="table-view">
                           <table class="table text-center table-striped table-bordered table movie_table iq-card"id="videocpp" style="width:100%">
                              <thead>
                                 <tr>
                                     
                                    <th>Title</th>
                                    <th>Video Uploaded By</th>
                                    <th>Video Type</th>
                                    <th>Uploaded Date</th>
                                    <th>Video Duration</th>
                                    <th>Video Category</th>
                                    <th>Video Meta</th>
                                    <th>Status</th>
                                    <th >Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                           
                                 <tr>
                                    <td>
                                       <div class="media align-items-center">
                                          <div class="iq-movie">
                                             <a href="javascript:void(0);"><img
                                                   src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}"
                                                   class="img-border-radius avatar-40 img-fluid" alt=""></a>
                                          </div>
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0"></p>
                                          </div>
                                       </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                   
                                    
                                    <td>
                                   Pending
                                  
                                        Approved
                                    Rejected
                                   </td>                                
                                    <td colspan="2">
                                       <div class="flex align-items-center list-user-action">
                                          <a class="iq-bg-warning" 
                                          onclick="return confirm('Are You Approving Video ?')"  href="{{ URL::to('admin/CPPVideosApproval') . '/' . $video->id }}">  <i class="fa fa-check-circle"></i></a>
                                          <a class="iq-bg-success" 
                                              onclick="return confirm('Are You Rejecting Video ?')" href="{{ URL::to('admin/CPPVideosReject') . '/' . $video->id }}"> <i class="fa fa-close" ></i></a>
                                       </div>
                                    </td>
                                 </tr>
                               
                              </tbody>
                           </table>
                           <div class="clear"></div>
		
		</div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
</div>