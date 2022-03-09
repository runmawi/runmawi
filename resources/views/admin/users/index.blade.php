@extends('admin.master')

@section('content')
<?php //dd(URL::to('/') . '/public/uploads/avatars/thumb-2.jpg'); ?>
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script src="//cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <div id="content-page" class="content-page">
            <div class="container-fluid">
               <div class="row">
               <div class="col-sm-6 col-xs-6">
                   <div class="iq-card" style="height: 150px;">
				<div class="tile-stats tile-red">
					<div class="icon"><i class="entypo-users"></i></div>
					<div class="num" data-start="0" data-end="{{ $total_subscription }}" data-postfix="" data-duration="1500" data-delay="0">{{ $total_subscription }}</div>
					<h4>Total Subscribers</h4>
					<p>The total amount of subscribers on your site.</p>
				</div>
                       </div>
			</div><!-- column -->
		
			<div class="col-sm-6 col-xs-6">
                 <div class="iq-card" style="height: 150px;">
				<div class="tile-stats tile-green">
					<div class="icon"><i class="entypo-user-add"></i></div>
					<div class="num" data-start="0" data-end="{{ $total_recent_subscription }}" data-postfix="" data-duration="1500" data-delay="600">{{ $total_recent_subscription }}</div>
					<h4>New Subscribers</h4>
					<p>New Subscribers for today.</p>
				</div>
                </div>
			</div><!-- column -->
		
			<div class="col-sm-4 col-xs-6">
                 <div class="iq-card" style="height: 150px;">
				<div class="tile-stats tile-aqua">
					<div class="icon"><i class="entypo-video"></i></div>
					<div class="num" data-start="0" data-end="{{ $total_revenew }}" data-postfix="" data-duration="1500" data-delay="1200">{{ $total_revenew }}</div>
					<h3>Revenue</h3>
					<p>Total Revenue</p>
				</div>
                </div>
			</div>
          <!-- column -->
         <div class="col-md-12">
             
    	<form  accept-charset="UTF-8" action="{{ URL::to('admin/export') }}" method="post">
            <div class="row">
						<div class="col-md-4">
                            <label>  Start Date:</label>
                            <input type="date" id="start_date" name="start_date" value="" class="form-control" >
                        </div>
						<div class="col-md-4">
                            <label>  End Date:</label>
                            <input type="date" id="end_date" name="end_date" value="" class="form-control" >
                        </div>
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

              <div class="col-md-4" >
			  <label>  </label>
                <!-- <button type="button" class="btn btn-black" data-dismiss="modal">Close</button> -->
                <input style="margin-top: 10%;" type="submit" class="btn btn-bk" id="Export" value="Export" />
            </div>
                </div>
        </form>
</div>
                  <div class="col-sm-12 mt-4">
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">User Lists</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                           <div class="table-view">
                              <table class="table movie_table" id="users_details" style="width:100%">
                                 <thead>
                                    <tr>
                                       <th style="width: 10%;">Profile</th>
                                       <th style="width: 10%;">Name</th>
                                       <th style="width: 20%;">Contact</th>
                                       <th style="width: 20%;">Email</th>
                                       <th style="width: 10%;">Role</th>
                                       <th style="width: 10%;">Status</th>
                                       <th style="width: 10%;">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 @foreach($users as $user)
                                    <tr>
                                       <td>
                                       <img src="{{ URL::to('/') . '/public/uploads/avatars/' . $user->avatar }}"
                                       class="img-fluid avatar-50" alt="author-profile">
                                          <!-- <img src="../assets/images/user/01.jpg" class="img-fluid avatar-50" alt="author-profile"> -->
                                       </td>
                                       <td>@if(!empty($user->username)){{$user->username}} @else {{$user->name}} @endif</td>
                                       <td>{{$user->mobile}}</td>
                                       <td>{{$user->email}}</td>
                                       <td>{{$user->role}}</td>
                                       <td>
                                       @if($user->active)
                                       <span class="badge iq-bg-success">Active</span>
                                       @else
                                       <span class="badge iq-bg-danger">Deactive</span>
                                       @endif
                                       
                                       </td>
                                       <td>
                                          <div class="d-flex align-items-center list-user-action">
                                             <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="{{ URL::to('admin/user/edit') . '/' . $user->id }}"><i
                                                class="ri-pencil-line"></i></a>
                                                <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="{{ URL::to('admin/user/delete') . '/' . $user->id }}"><i
                                                   class="ri-delete-bin-line"></i></a>
                                                   <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="{{ URL::to('admin/user/view') . '/' . $user->id }}"><i
                                                   class="fa fa-eye"></i></a>
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
                                             <?php echo $users->render(); ?>


	@section('javascript')

	<script>
// Datatables
$(document).ready( function () {
   //  $('#users_detail').DataTable();
});
	

		$ = jQuery;
		$(document).ready(function(){
         
         // $('#users_detail').DataTable();

			$('.delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this user?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});

	</script>
<style>

.form-control {
background-color: #f7f7f7;
}

</style>
	@stop

@stop

