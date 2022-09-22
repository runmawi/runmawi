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
<link rel="stylesheet" href="cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

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
                       
                     <div class="col-md-12">
                  <div class="row">
                     <div class="col-md-6">
                        <a href="{{ URL::to('/admin/assign_videos/partner') }}"><button type="button" class="btn btn-default">Move Videos CPP </button></a>
                     </div>
                     <div class="col-md-6">
                        <a href="{{ URL::to('/admin/assign_videos/channel_partner') }}"><button type="button" class="btn btn-default" >Move Videos Channel </button></a>
                     </div>
                  </div>
               </div>
                        <h4>Channel Uploaded Videos</h4>
                         <div class="iq-card-header-toolbar d-flex align-items-baseline">
                             <div class="form-group mr-2">
                    </div>
                        </div>
                     </div>
                     <div class="iq-card-body table-responsive p-0">
                        
                     <form action="{{ URL::to('/admin/move/channel-partner') }}"  method= "post">

                        <div class="col-md-12">
                           <div class="row">
                              <div class="col-md-12">
                                 <label for="">Choose Content Partner</label>
                                 <select name="channel_users" class="form-control" id="channel_users">
                                    @foreach(@$channel as $value)
                                       <option value="{{ $value->id }}">{{ $value->channel_name }}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           <br>
                           <div class="row">
                              <div class="col-md-12">
                              <label for="">Choose Video (*To Be Moved)</label>
                                    <select name="video_data" class="form-control" id="video_data">
                                       @foreach(@$video as $value)
                                          <option value="{{ $value->id }}">{{ $value->title }}</option>
                                       @endforeach
                                    </select>
                                 </div>
                           </div>
                        </div>
                        <br>
                        <div class="col-md-12">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                              <button type="submit" style="margin-right: 10px;" class="btn btn-primary" value="submit">Submit</button>
                        </div>
                        </form>

                           <div class="clear"></div>
		
		</div>
                        </div>
                     </div>

<script src="cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
      
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

