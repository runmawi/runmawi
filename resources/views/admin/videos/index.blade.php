@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection

@section('content')

     <div id="content-page" class="content-page">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Video Lists</h4>
                        </div>
                        <div class="iq-card-header-toolbar d-flex align-items-center">
                           <a href="{{ URL::to('admin/videos/create') }}" class="btn btn-primary">Add movie</a>
                        </div>
                     </div>
                     <div class="iq-card-body">
                        <div class="table-view">
                           <table class="data-tables table movie_table " style="width:100%">
                              <thead>
                                 <tr>
                                    <th>Title</th>
                                    <th>Rating</th>
                                    <th>Category</th>
                                    <th>Release Year</th>
                                    <th>Language</th>
                                    <!--<th style="width: 20%;">Description</th>-->
                                     <th>Views</th>
                                    <th>Action</th>
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
                                             <!-- <small>2h 15m</small> -->
                                          </div>
                                       </div>
                                    </td>
                                    <td>{{ $video->rating }}</td>
                                    <td>@if(isset($video->categories->name)) {{ $video->categories->name }} @endif</td>
                                    <td>{{ $video->year }}</td>
                                    <td> @if(isset($video->languages->name)) {{ $video->languages->name }} @endif</td>
                                    <td>
                                       <!--<p> {{ substr($video->description, 0, 50) . '...' }} </p>-->
                                        {{ $video->views }}<i class="lar la-eye "></i>
                                    </td>
                                    <td>
                                       <div class="flex align-items-center list-user-action">
                                          <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="View" href="{{ URL::to('/category/videos') . '/' . $video->slug }}"><i class="lar la-eye"></i></a>
                                          <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit" href="{{ URL::to('admin/videos/edit') . '/' . $video->id }}"><i class="ri-pencil-line"></i></a>
                                          <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Delete" href="{{ URL::to('admin/videos/delete') . '/' . $video->id }}"><i
                                                class="ri-delete-bin-line"></i></a>
                                       </div>
                                    </td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                           <div class="clear"></div>

		<div class="pagination-outter"><?= $videos->appends(Request::only('s'))->render(); ?></div>
		
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
				swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this video?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
			    return false;
			});
		});

	</script>

	@stop

@stop

