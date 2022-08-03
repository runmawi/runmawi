@extends('admin.master')
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
</style>
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
@section('content')

     <div id="content-page" class="content-page">
          <div class="d-flex">
                        <a class="black" href="{{ URL::to('admin/livestream') }}">All Live Videos</a>
                        <a class="black" href="{{ URL::to('admin/livestream/create') }}">Add New Live Video</a>
                        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/CPPLiveVideosIndex') }}">Live Videos For Approval</a>
                        <a class="black" href="{{ URL::to('admin/livestream/categories') }}">Manage Live Video Categories</a></div>
         <div class="container-fluid p-0">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                     <div class="row">
                           <div class="col-md-5">
                              <a href="{{ URL::to('/admin/CPPLiveVideosIndex') }}"><button type="button" class="btn btn-default">CPP Uploaded Live Videos</button></a>
                           </div>
                           <div class="col-md-5">
                              <a href="{{ URL::to('/admin/ChannelLiveVideosIndex') }}"><button type="button" class="btn btn-default" >Channel Uploaded Live Videos</button></a>
                           </div>
                        <div>
                           <br>
                        <div class="iq-header-title">
                           <h4 class="card-title">Channel Live Video Lists</h4>
                        </div>

                         <div class="iq-card-header-toolbar d-flex align-items-baseline">
                             <div class="form-group mr-2">
                    <!-- <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" /> -->
                    </div>
                        </div>
                     </div>
                     <div class="iq-card-body table-responsive p-0">
                        <div class="table-view">
                           <table class="table table-striped table-bordered table movie_table iq-card text-center" style="width:100%">
                              <thead>
                                 <tr class="r1">
                                     
                                    <th>Title</th>
                                    <th>User Name</th>
                                    <th>Year</th>
                                    <th>Video Access</th>
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
                                    <td>{{ $video->year }}</td>
                                    <td>{{ $video->access }}</td>
                                    <?php if($video->active == 0){ ?>
                                       <td class="bg-warning"> <?php echo "Pending"; ?></td>
                                    <?php }elseif($video->active == 1){ ?>
                                       <td class="bg-success"> <?php  echo "Approved"; ?></td>
                                    <?php }elseif($video->active == 2){ ?>
                                       <td class="bg-danger"> <?php  echo "Rejected"; ?></td>
                                    <?php }?>                              
                                    <td colspan="2">
                                       <div class="flex align-items-center list-user-action">
                                          <a class="iq-bg-warning" 
                                          onclick="return confirm('Do you want to approve this Live Stream ?')"  href="{{ URL::to('admin/ChannelLiveVideosApproval') . '/' . $video->id }}">  <i class="fa fa-check-circle" style="font-size:24px;color:green;"></i></a>
                                          <a class="iq-bg-success" 
                                              onclick="return confirm('Do you want to reject this Live Stream  ?')" href="{{ URL::to('admin/ChannelLiveVideosReject') . '/' . $video->id }}"> <i class="fa fa-close" style="font-size:20px;color:white;background:red;border-radius:50%;"></i></a>
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
      
         <script>
$(document).ready(function(){

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

