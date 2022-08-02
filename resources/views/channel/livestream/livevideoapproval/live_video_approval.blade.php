@extends('channel.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
@section('content')

     <div id="content-page" class="content-page">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Live Video Lists</h4>
                        </div>

                         <div class="iq-card-header-toolbar d-flex align-items-baseline">
                             <div class="form-group mr-2">
                    <!-- <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" /> -->
                    </div>
                        </div>
                     </div>
                     <div class="iq-card-body table-responsive">
                        <div class="table-view">
                           <table class="table table-striped table-bordered table movie_table " style="width:100%">
                              <thead>
                                 <tr>
                                     
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
                                          onclick="return confirm('Do you want to approve this Live Stream ?')"  href="{{ URL::to('/CPPLiveVideosApproval') . '/' . $video->id }}">  <i class="fa fa-check-circle" style="font-size:24px;color:green;"></i></span></a>
                                          <a class="iq-bg-success" 
                                              onclick="return confirm('Do you want to reject this Live Stream  ?')" href="{{ URL::to('/CPPLiveVideosReject') . '/' . $video->id }}"> <i class="fa fa-close" style="font-size:20px;color:white;background:red;border-radius:50%;"></i></span></a>
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
   url:"{{ URL::to('/cppusers_videodata') }}",
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

