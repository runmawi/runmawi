@extends('admin.master')

<style type="text/css">

    .has-switch .switch-on label {
        background-color: #FFF;
        color: #000;
    }

    .make-switch {
        z-index: 2;
    }

    .iq-card {
        padding: 25px;
    }

    .lar {
        margin: 4px;
    }

    .form-control {
        /* background: #fff!important; */

    }

    .black {
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
        border-radius: 0px 4px 4px 0px;
    }

    .black:hover {
        background: #fff;
        padding: 20px 20px;
        color: rgba(66, 149, 210, 1);

    }
</style>

@section('css')
    <link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
@endsection

@section('content')

    <div class="admin-section-title">
        <div id="content-page" class="content-page">
            <div class="container-fluid">
                <div class="d-flex">
                    <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/series-list') }}"> TV Shows List</a>
                    <a class="black" href="{{ URL::to('admin/series/create') }}"> Add TV Shows Series</a>
                </div>

                <div class="iq-card">
                    <div class="row align-items-center p-2">
                        <div class="col-md-10"> <h4><i class="entypo-movie"></i> TV Shows</h4></div>
                        <div class="col-md-2 mb-2"><a href="{{ URL::to('admin/series/create') }}" class="btn btn-primary mt-2"><i class="fa fa-plus-circle"></i> Add New</a></div>
                    </div>

                    <div class="clear"></div>

					<div class="row">
						<div class="col-md-12">
							<table class="table text-center" id="sitemeta_table" style="width:100%">
								<thead>
									<tr class="r1">
										<th><label>S.No</label></th>
										<th><label>Image</label></th>
										<th><label>Title</label></th>
	
										@if (Series_Networks_Status() == 1)
											<th><label>Networks</label></th>
										@endif
	
										<th><label>Slider</label></th>
										<th><label>Operation</label></th>
									</tr>
								</thead>

								<tbody>
									@foreach ($series as $key => $series_value)
										<tr>
											<td>{{ $key + 1 }}</td>
											<td><img src="{{ URL::to('public/uploads/images/' . $series_value->image) }}" width="100"></td>
											<td valign="bottom"> <p>{{ $series_value->title }}</p> </td>

											@if (Series_Networks_Status() == 1)
												<td valign="bottom">
													@php
														if (!empty($series_value->network_id) && !is_null($series_value->network_id)):
															$SeriesNetwork = App\SeriesNetwork::WhereIn('id', json_decode($series_value->network_id))->pluck('name');
															$Series_Network_name = implode(', ', $SeriesNetwork->toArray());
														else:
															$Series_Network_name = '-';
														endif;
													@endphp
													{{ $Series_Network_name }}
													</p>
												</td>
											@endif

											<td valign="bottom">
												<div class="mt-1">
													<label class="switch">
														<input name="video_status" class="video_status" id="{{ 'video_' . $series_value->id }}" type="checkbox"
															@if ($series_value->banner == '1') checked @endif
																data-video-id={{ $series_value->id }} data-type="video" onchange="update_series_banner(this)">
														<span class="slider round"></span>
													</label>
												</div>
											</td>
											<td>
												<div class=" align-items-center">
													<a href="{{ URL::to('play_series/'.$series_value->slug )   }}"
														class="iq-bg-warning"><img class="ply" src="{{ URL::to('assets/img/icon/view.svg') }}">
														<!--Visit Site-->
													</a>
													<a href="{{ URL::to('admin/series/edit/'.$series_value->id )  }}"
														class="iq-bg-success ml-2"><img class="ply" src="{{ URL::to('assets/img/icon/edit.svg') }} ">
														<!--Edit--></a>
													<a href="{{ URL::to('admin/series/delete/'. $series_value->id ) }}"
														class="iq-bg-danger ml-2" onclick="return confirm('Are you sure?')"><img
															class="ply" src="{{ URL::to('assets/img/icon/delete.svg') }}"><i></i> </a>
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

    	@section('javascript')
      
			<script>

				$(document).ready(function() {

					$('#sitemeta_table').DataTable();

					var delete_link = '';

					$('.delete').click(function(e) {
						e.preventDefault();
						delete_link = $(this).attr('href');
						swal({
							title: "Are you sure?",
							text: "Do you want to permanantly delete this series?",
							type: "warning",
							showCancelButton: true,
							confirmButtonColor: "#DD6B55",
							confirmButtonText: "Yes, delete it!",
							closeOnConfirm: false
						}, function() {
							window.location = delete_link
						});
						return false;
					});
				});
		
				function update_series_banner(ele) {

					var video_id = $(ele).attr('data-video-id');
					var status = '#video_' + video_id;
					var video_Status = $(status).prop("checked");

					if (video_Status == true) {
						var banner_status = '1';
						var check = confirm("Are you sure you want to active this slider?");

					} else {
						var banner_status = '0';
						var check = confirm("Are you sure you want to remove this slider?");
					}


					if (check == true) {

						$.ajax({
							type: "POST",
							dataType: "json",
							url: "{{ url('admin/series_slider_update') }}",
							data: {
								_token: "{{ csrf_token() }}",
								video_id: video_id,
								banner_status: banner_status,
							},
							success: function(data) {
								if (data.message == 'true') {
									//  location.reload();
								} else if (data.message == 'false') {
									swal.fire({
										title: 'Oops',
										text: 'Something went wrong!',
										allowOutsideClick: false,
										icon: 'error',
										title: 'Oops...',
									}).then(function() {
										location.href = '{{ URL::to('admin/ActiveSlider') }}';
									});
								}
							},
						});
					} else if (check == false) {
						$(status).prop('checked', true);

					}
				}
			</script>
   		@stop
@stop