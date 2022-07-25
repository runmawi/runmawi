@extends('admin.master')

@include('admin.favicon')

@section('css')

<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>


@section('content')

<div id="content-page" class="content-page">
	<div class="iq-card">
		<div class="iq-card-header  justify-content-between">
			<div class="iq-header-title p-0">
			<h4>Log Activity Lists</h4>
			</div>
		</div>

		<hr>
			<div class="col-md-12">
				<div class="row mt-3"> 
					<div class="col-md-4">
						<!-- <label for="start_time">  Start Date: </label>
						<input type="date" id="start_time" name="start_time" > -->
					</div>

					<div class="col-md-4">
						<!-- <label for="start_time">  End Date: </label>
						<input type="date" id="end_time" name="end_time"> -->
					</div>

					<div class="col-md-4 ">
						<!-- <span  id="export" class="btn btn-success btn-sm" >Export</span> -->
					</div>
				</div>
	
				<div class="clear"></div>

				<div class="row align-items-center">
					<div class="row">
						<div class="col-md-12">
							<table class="table" id="logtable" style="width:100%">
								<thead>
									<tr class="r1">
										<th>No</th>
										<th>Subject</th>
										<!-- <th>URL</th> -->
										<!-- <th>Method</th> -->
										<!-- <th>Ip</th> -->
										<th >User Agent</th>
										<!-- <th>User Id</th> -->
										<th >User Name</th>
										<th >Video Title</th>
										<th >Video Category</th>
										<th >Video Language</th>
										<th >Video Cast Crew</th>
										<th >Created</th>
									</tr>
								</thead>
								<tbody>
									@if($logs->count())
									@foreach($logs as $key => $log)

									<tr>
										<td>{{ ++$key }}</td>
										<td>{{ $log->subject }}</td>
										<!-- <td class="text-success">{{ $log->url }}</td> -->
										<!-- <td><label class="label label-info">{{ $log->method }}</label></td> -->
										<!-- <td class="text-warning">{{ $log->ip }}</td> -->
										<td class="text-danger">{{ $log->agent }}</td>
										<!-- <td>{{ $log->user_id }}</td> -->
										<td>{{ $log->username->username }}</td>
										<td>@if(!empty($log->video_title->title)){{ @$log->video_title->title }} @else No Title @endif</td>
										<td>@if(!empty($log->video_category->name)){{ @$log->video_category->name }} @else No Category @endif</td>
										<td>@if(!empty($log->video_language->name)){{ @$log->video_language->name }} @else No Language @endif</td>
										<td>@if(!empty($log->video_cast->artist_name)){{ @$log->video_cast->artist_name }} @else No Cast @endif</td>
										<td >{{ $log->created_at }}</td>
										<!-- <td >{{ $log->updated_at }}</td> -->
										<!-- <td><button class="btn btn-danger btn-sm">Delete</button></td> -->
									</tr>

									@endforeach
									@endif
								</tbody>
							</table>
						</div>
					</div>
		</div> 
</div> 
@stop

<script>
	$.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).ready(function(){
		$('#logtable').DataTable();
	});
</script>
