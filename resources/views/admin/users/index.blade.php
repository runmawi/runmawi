@extends('admin.master')

@section('content')
  <div id="content-page" class="content-page">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">User Lists</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                           <div class="table-view">
                              <table class="data-tables table movie_table" style="width:100%">
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
                                          <img src="../assets/images/user/01.jpg" class="img-fluid avatar-50" alt="author-profile">
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
                                          <div class="align-items-center list-user-action">
                                             <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="{{ URL::to('admin/user/edit') . '/' . $user->id }}"><i
                                                class="ri-pencil-line"></i></a>
                                                <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="{{ URL::to('admin/user/delete') . '/' . $user->id }}"><i
                                                   class="ri-delete-bin-line"></i></a>
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

		$ = jQuery;
		$(document).ready(function(){
			$('.delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this user?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});

	</script>

	@stop

@stop

