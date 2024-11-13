@extends('admin.master')

<style>
    .form-control{background: #fff!important;}
    .btn-danger:hover, .btn-danger.focus, .btn-danger:focus {background-color: var(--iq-danger) !important;border-color: var(--iq-danger) !important;}
</style>

@section('content')

   <script src="//cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css"></script>
   <script src="//cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
   <link rel="stylesheet" href="cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
   <script src="cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

  <div id="content-page" class="content-page">
      <div class="container-fluid">
         <div class="row ">
            <div class="col-sm-4 mb-4 col-xs-6 text-center">
               <div class="iq-card" >
                  <div class="tile-stats tile-red">
                     <div class="icon"><i class="entypo-users"></i></div>
                        <div class="num" data-start="0" data-end="{{ $total_subscription }}" data-postfix="" data-duration="1500" data-delay="0">{{ $total_subscription }}</div>
                        <h4>Total Subscribers</h4>
                        <p class="p1">The total amount of subscribers on your site.</p>
                  </div>
               </div>
            </div><!-- column -->
		
			<div class="col-sm-4 col-xs-6 mb-4 text-center">
                 <div class="iq-card" >
				<div class="tile-stats tile-green">
					<div class="icon"><i class="entypo-user-add"></i></div>
					<div class="num" data-start="0" data-end="{{ $total_recent_subscription }}" data-postfix="" data-duration="1500" data-delay="600">{{ $total_recent_subscription }}</div>
					<h4>New Subscribers</h4>
					<p class="p1">New Subscribers for today.</p>
				</div>
                </div>
			</div><!-- column -->
		
			<div class="col-sm-4 col-xs-6 mb-4 text-center">
                 <div class="iq-card" >
				<div class="tile-stats tile-aqua">
					<div class="icon"><i class="entypo-video"></i></div>
					<div class="num" data-start="0" data-end="{{ $total_revenew }}" data-postfix="" data-duration="1500" data-delay="1200">{{ $total_revenew }}</div>
					<h4>Revenue</h4>
					<p class="p1">Total Revenue</p>
				</div>
                </div>
			</div>
          <!-- column -->
         <div class="col-md-12">
             
    	<!-- <form  accept-charset="UTF-8" action="{{ URL::to('admin/export') }}" method="post"> -->
            <div class="row justify-content-between">
						<div class="col-md-4">
                            <label class="mb-1">  Start Date:</label>
                            <input type="date" id="start_date" name="start_date" value="" class="form-control" >
                        </div>
						<div class="col-md-4">
                            <label class="mb-1">  End Date:</label>
                            <input type="date" id="end_date" name="end_date" value="" class="form-control" >
                        </div>
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

              <div class="col-md-2 mt-4" >
			  <label class="mb-1">  </label>
                <!-- <button type="button" class="btn btn-black" data-dismiss="modal">Close</button> -->
                <input style="" type="submit" class="btn btn-primary" id="Export" value="Export" />
            </div>
                </div>
        <!-- </form> -->
</div>
                  <div class="col-sm-12 mt-4">
                     <div class="">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title"></div>
                           <button id="delete-selected" style="padding:6px 10px; border-radius:9px;" class="btn btn-danger">Delete Selected</button>
                        </div>

                        <div class="iq-card-body">
                           <div class="table-view">
                              <table id="users_table" class="table movie_table text-center table-bordered" style="width:100%">
                                 <thead>
                                    <tr class="r1">
                                       <th><input type="checkbox" id="select-all"></th>
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
                                       <tr id="user-{{ $user->id }}">
                                          <td><input type="checkbox" class="user-checkbox" value="{{ $user->id }}"></td>

                                          <td>
                                             <img src="{{ $user->avatar ? URL::to('public/uploads/avatars/' . $user->avatar) : URL::to('public/uploads/avatars/default_profile_image.png') }}"
                                             class="img-fluid avatar-50" alt="author-profile">
                                          </td>

                                          <td> {{ !empty($user->username) ? $user->username : $user->name }} </td>
                                          <td>{{ @$user->mobile}}</td>
                                          <td>{{ @$user->email}}</td>
                                          <td>{{ @$user->role}}</td>

                                          <td>
                                             @if($user->active)
                                                <span class="badge iq-bg-success">Active</span>
                                             @else
                                                <span class="badge iq-bg-danger">Deactive</span>
                                             @endif
                                          </td>

                                          <td>
                                             <div class="d-flex align-items-center list-user-action">
                                                <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="{{ URL::to('admin/user/edit/'{$user->id}) }}"><img class="ply" src="{{ URL::to('assets/img/icon/edit.svg') }}" ></a>
                                                <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="{{ URL::to('admin/user/delete/'{$user->id})  }}"><img class="ply" src="{{ URL::to('assets/img/icon/delete.svg') }}" onclick="return confirm('Are you sure?')" ></a>
                                                <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="{{ URL::to('admin/user/view/'{$user->id})  }}"><img class="ply" src="{{ URL::to('assets/img/icon/view.svg') }}"></a>
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


	@section('javascript')

   <script>
      document.getElementById('select-all').addEventListener('change', function() {
         let checkboxes = document.querySelectorAll('.user-checkbox');
         checkboxes.forEach(checkbox => checkbox.checked = this.checked);
      });

      document.getElementById('delete-selected').addEventListener('click', function() {
         let selected = [];
         document.querySelectorAll('.user-checkbox:checked').forEach(checkbox => {
               selected.push(checkbox.value);
         });

         if(selected.length > 0) {
               if(confirm('Are you sure you want to delete the selected Users?')) {
                  fetch("{{ route('admin.users.deleteSelected') }}", {
                     method: 'POST',
                     headers: {
                           'Content-Type': 'application/json',
                           'X-CSRF-TOKEN': '{{ csrf_token() }}'
                     },
                     body: JSON.stringify({ids: selected})
                  }).then(response => response.json())
                  .then(data => {
                     if(data.success) {
                           selected.forEach(id => {
                              document.getElementById('user-' + id).remove();
                           });
                           alert('Deleted Successfully.');
                     } else {
                           alert('An error occurred while deleting users.');
                     }
                  });
               }
         } else {
               alert('No User selected.');
         }
      });
   </script>

	<script>

		$ = jQuery;
		$(document).ready(function(){

        $('#users_table').DataTable();

			$('.delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this user?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});

      $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
          $('#Export').click(function(){
            var start_time =  $('#start_date').val();
            var end_time =  $('#end_date').val();
            var url = "{{ URL::to('admin/export') }}";
            // alert(start_time);
            $.ajax({
            url: url,
            type: "post",
                data: {
                _token: '{{ csrf_token() }}',
                start_time: start_time,
                end_time: end_time,

                },      
                success: function(data){
                var Excel = data ;
                var Excel_url =  "{{ URL::to('public/uploads/csv/')  }}";
                var link_url = Excel_url+'/'+Excel;
                $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Downloaded User CSV File </div>');
                            setTimeout(function() {
                                $('.add_watch').slideUp('fast');
                            }, 3000);

                location.href = link_url;
            }
            });
        });
    });
	</script>
<style>

.form-control {
background-color: #f7f7f7;
}
body.dark input[type="search"] {
    color: #000 !important;
}

</style>
	@stop

@stop


 