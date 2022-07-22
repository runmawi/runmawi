@extends('admin.master')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

@section('content')
<div id="content-page" class="content-page">
    <div class="container-fluid">
    	<h1>Log Activity Lists</h1>
			<div class="container">
				<!-- <h1>Log Activity Lists</h1> -->
				<div class="iq-card-body table-responsive p-0">
                        <div class="table-view">
						<table class="table text-center table-striped table-bordered table movie_table iq-card " style="width:100%" id="logtable">
							<thead>
								<tr>
									<th>No</th>
									<th>Subject</th>
									<!-- <th>URL</th> -->
									<!-- <th>Method</th> -->
									<!-- <th>Ip</th> -->
									<th width="300px">User Agent</th>
									<!-- <th>User Id</th> -->
									<th width="300px">User Name</th>
									<th width="300px">Video Title</th>
									<th width="300px">Video Category</th>
									<th width="300px">Video Language</th>
									<th width="300px">Video Cast Crew</th>
									<th width="300px">Created</th>
									<!-- <th width="300px">Updated</th> -->

									<!-- <th>Action</th> -->
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
