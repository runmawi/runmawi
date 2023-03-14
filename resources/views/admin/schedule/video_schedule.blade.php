@extends('admin.master')
<style type="text/css">
	.has-switch .switch-on label {
		background-color: #FFF;color: #000;
	}
	.make-switch{
		z-index:2;
	}
    .iq-card{
        padding: 15px;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
@section('content')

<div id="content-page" class="content-page">
         <div class="container-fluid mt-4">
	<div class="admin-section-title">
        <div class="iq-card">
		<div class="row justify-content-start">
			<div class="col-md-8 d-flex justify-content-between">
				<h4><i class="entypo-list"></i> Stream Scheduled Videos </h4>
               	<div>
					<a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Create a New Schedule</a>
			   	</div>
			</div>
            <div class="col-md-8" align="right">
                
            </div>
            
		</div>
	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header d-flex ">
                    <h4 class="modal-title">New Schedule</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				
				<div class="modal-body">
					<form id="new-menu-form" accept-charset="UTF-8" enctype="multipart/form-data" action="{{ URL::to('admin/video-schedule/store') }}" method="post">
				        <label for="name">Name *</label>
				        <input name="name" id="name" placeholder="Schedule Name" class="form-control" value="" /><br />
				        <label for="description">Description *</label>
				        <input name="description" id="description" placeholder="Description" class="form-control" value="" /><br />
						<div style="margin-left: -5%;">
							<div class="mt-1 d-flex align-items-center justify-content-around">
								<div><label class="mt-1"> Display on Home page </label></div>
									<div class="mr-2">OFF</div>
										<label class="switch mt-2">
										<input name="in_home" type="checkbox" >
										<span class="slider round"></span>
										</label>
									<div class="ml-2">ON</div>
							</div>
						</div><br>
						<label class="m-0">Home Thumbnail: <small>(9:16 Ratio or 1080X1920px)</small></label>
						<input type="file" class="form-group" name="image"  id="image"  >
						<label class="m-0">Player Thumbnail: <small>(16:9 Ratio or 1280X720px)</small></label>
						<input type="file" class="form-group" name="player_image"  id="player_image"  >
				        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
				    </form>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="submit-new-menu">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Add New Modal -->
	<div class="modal fade" id="update-menu">
		<div class="modal-dialog">
			<div class="modal-content">
				
			</div>
		</div>
	</div>

	<div class="clear"></div>
		
		<div class="col-md-8 p-0">
		<div class="panel panel-primary menu-panel" data-collapsed="0">
					
			<div class="panel-heading">
				<div class="panel-title">
					<p class="p1">Organize the video below :</p>
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			
			<div class="">
		
            <table id="table" class="table table-bordered iq-card text-center schedules">
              <thead>
                <tr class="r1 ">
                  <th width="30px">#</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Video Schedule</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="tablecontents">
              <!-- VideoSchedules -->
              @foreach($VideoSchedules as $key => $Schedules)

                <tr class="text-center">
                    <td> {{ $key+1 }} </td>
                    <td> {{ $Schedules->name }} </td>
                    <td> {{ $Schedules->description }} </td>
                    <td> 
                        <a href="{{ URL::to('/') }}/admin/manage/schedule/{{ $Schedules->id }}" class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Schedule">
                        <i class="fa fa-calendar"> Manage Schedule</i></a> 
                    </td>
                    <td class="align-items-center list-user-action">
                        <a href="{{ URL::to('/') }}/admin/video-schedule/edit/{{ $Schedules->id }}" class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                        <i class="ri-pencil-line"></i></a> 
                        <a href="{{ URL::to('/')}}/admin/video-schedule/delete/{{ $Schedules->id }}" onclick="return confirm('Are you sure?')" class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                        <i class="ri-delete-bin-line"></i></a>
                    </td>
                </tr>

                @endforeach
              </tbody>                  
            </table>
						
				</div>
		
			</div>
		
            </div></div></div></div></div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />

	@section('javascript')

	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>


	<script>
  			$('#submit-new-menu').click(function(){
				$('#new-menu-form').submit();
			});
            // $('.schedules').DataTable();

    </script>
		<script src="{{ URL::to ('/assets/admin/js/jquery.nestable.js') }}"></script>

	@stop

@stop
