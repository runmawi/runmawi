@extends('admin.master')
<style>
     .form-control {
    background: #fff!important; */
   
}
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

@section('content')

     <div id="content-page" class="content-page">
         <div class="mb-5">
         <a class="black" href="{{ URL::to('admin/audios') }}">Audio List</a>
        <a class="black" href="{{ URL::to('admin/audios/create') }}">Add New Audio</a>
        <a class="black" href="{{ URL::to('admin/audios/categories') }}">Manage Audio Categories</a>
             <a class="black" href="{{ URL::to('admin/audios/albums') }}">Manage Albums</a></div>
         <div class="container-fluid p-0">
            <div class="row">
               <div class="col-sm-12">
                  <div class="">
                     <div class="iq-card-header d-flex justify-content-between mb-3">
                        <div class="iq-header-title">
                           <h4 class="card-title">Audio Lists</h4>
                        </div>
                        <div class="iq-card-header-toolbar d-flex align-items-center">
                           <a href="{{ URL::to('admin/audios/create') }}" class="btn btn-primary">Add Audio</a>
                        </div>
                     </div>
                     <div class=" p-0">
                        <div class="table-view">
                           <table class="data-tables table audio_table iq-card text-center p-0" style="width:100%">
                              <thead>
                                 <tr class="r1">
                                    <th>Title</th>
                                    <th>Rating</th>
                                    <th>Category</th>
                                     <th>Views</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                              @foreach($audios as $audio)
                                 <tr>
                                    <td>
                                       <div class="media align-items-center">
                                          <div class="iq-audio">
                                             <a href="javascript:void(0);"><img
                                                   src="{{ URL::to('/') . '/public/uploads/images/' . $audio->image }}"
                                                   class="img-border-radius avatar-40 img-fluid" alt=""></a>
                                          </div>
                                          <div class="media-body text-white text-left ml-3">
                                             <p class="mb-0">{{ $audio->title }}</p>
                                             <!-- <small>2h 15m</small> -->
                                          </div>
                                       </div>
                                    </td>
                                    <td>{{ $audio->rating }}</td>
                                    <td>@if(isset($audio->categories->name)) {{ $audio->categories->name }} @endif</td>
                                  
                                    <td>
                                        {{ $audio->views }}</i>
                                    </td>
                                    <td>
                                       <div class=" align-items-center list-user-action">
                                          <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="View" href="{{ URL::to('/audio') . '/' . $audio->slug }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/view.svg';  ?>"></a>
                                          <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit" href="{{ URL::to('admin/audios/edit') . '/' . $audio->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
                                          <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" onclick="return confirm('Are you sure?')"
                                             data-original-title="Delete" href="{{ URL::to('admin/audios/delete') . '/' . $audio->id }}"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
                                       </div>
                                    </td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                           <div class="clear"></div>

		<div class="pagination-outter"><?= $audios->appends(Request::only('s'))->render(); ?></div>
		
		</div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      

@section('javascript')
	<script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>
	<script>

		$(document).ready(function(){
			var delete_link = '';

			$('.delete').click(function(e){
				e.preventDefault();
				delete_link = $(this).attr('href');
				swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this audio?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
			    return false;
			});
		});

	</script>

	@stop

@stop

