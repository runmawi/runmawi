@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
@section('content')

     <div id="content-page" class="content-page">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Channel Users Lists</h4>
                        </div>

                         <div class="iq-card-header-toolbar d-flex align-items-baseline">
                             <div class="form-group mr-2">
                    <!-- <input type="text" name="search" id="search" class="form-control" placeholder="Search Data" /> -->
                    </div>
                        </div>
                     </div>
                     <div class="iq-card-body table-responsive p-0">
                        <div class="table-view">
                           <table class="table table-striped table-bordered table movie_table iq-card text-center" id="channeluser" style="width:100%">
                              <thead>
                                 <tr class="r1">
                                    <th>Id</th>                            
                                    <!-- <th>Profile</th> -->
                                    <th>Channel Name</th>
                                    <th>Email ID</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th >Intro Video</th>
                                    <th >Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                  <?php $i = 1 ;?>
                              @foreach($users as $user)
                                 <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $user->channel_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile_number }}</td>
                                    <?php if($user->status == 0){ ?>
                                       <td class="bg-warning"> <?php echo "Pending"; ?></td>
                                    <?php }elseif($user->status == 1){ ?>
                                       <td class="bg-success"> <?php  echo "Approved"; ?></td>
                                    <?php }elseif($user->status == 2){ ?>
                                       <td class="bg-danger"> <?php  echo "Rejected"; ?></td>
                                    <?php }?>                              
                                    <td >
                                    <div class=" align-items-center list-user-action">
                                        <video  width="100" height="100" id="videoPlayer" class="" controls data-setup='{"controls": true, "aspectRatio":"16:9", "fluid": true}' 
                                        src="{{ $user->intro_video }}"  type="video/mp4" >
                                        </td>
                                    <td colspan="2">
                                    <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit" href="{{ URL::to('admin/channel/user/edit') . '/' . $user->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
                                       
                                       <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Delete" onclick="return confirm('Are you sure?')" 
                                             href="{{ URL::to('/admin/channel/user/delete') . '/' . $user->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
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

         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
         <script src="<?= URL::to('/'). '/assets/js/playerjs.js';?>"></script>

<script>
            $(document).ready(function(){
              var players_multiple = Plyr.setup('#videoPlayer');
});

</script>

      
         <script>
$(document).ready(function(){

    $('#channeluser').DataTable();

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
