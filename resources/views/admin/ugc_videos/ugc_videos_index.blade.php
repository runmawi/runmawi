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
            <a class="black" href="{{ URL::to('admin/ugc_videos') }}">All UGC Videos</a>
            <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/ugc_videos_index') }}">UGC Videos For Approval</a>
        </div>

         <div class="container-fluid p-0">
            <div class="row">

                     
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
                                    <th>User Name</th>
                                    <th>Video Type</th>
                                    <th>Uploaded Date</th>
                                    <th>Video Duration</th>
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
                                    <td>{{ $video->uploaded_by }}</td>
                                    <td>{{ $video->user ? $video->user->username : '' }}</td>
                                    <td>{{ $video->type }}</td>
                                    <td>{{ $video->created_at }}</td>
                                    <td>{{ gmdate('H:i:s', $video->duration) }}</td>    
                                    <td>
                                       <?php if($video->active == 0){ ?>
                                          <span class="bg-warning p-2 rounded" >Pending</span>
                                      <?php } elseif($video->active == 1){ ?>
                                          <span class="bg-success p-2 rounded" >Approved</span>
                                      <?php } elseif($video->active == 2){ ?>
                                          <span class="bg-danger p-2 rounded">Rejected</span>
                                      <?php } ?>
                                   </td>                                
                                    <td colspan="2">
                                       <div class="flex align-items-center list-user-action">
                                          <a class="iq-bg-warning" 
                                          onclick="return confirm('Are You Approving Video ?')"  href="{{ URL::to('admin/ugc_videos_approval') . '/' . $video->id }}">  <i class="fa fa-check-circle" style="font-size:24px;color:blue"></i></span></a>
                                          @if($video->active == 0)
                                          <a class="iq-bg-success" 
                                              onclick="return confirm('Are You Rejecting Video ?')" href="{{ URL::to('admin/ugc_videos_reject') . '/' . $video->id }}"> <i class="fa fa-close" style="font-size:24px;color:white;background:red;border-radius:50%"></i></span></a>
                                          @endif
                                          <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                                              data-original-title="Delete" onclick="return confirm('Are you sure?')" href="{{ URL::to('ugc-delete') . '/' . $video->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
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
                              <?= $videos->appends(Request::only('s'))->render(); ?>
                           </div>
                        </div>
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

@stop

@stop

