@extends('admin.master')
@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">

@endsection
@section('content')
<?php
    //   echo "<pre>";
    //   print_r($moderatorsuser);
    //   exit();
?>
<div id="content-page" class="content-page">
            <div class="container-fluid">
	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-6">
				<h4><i class="entypo-archive"></i> All Moderators</h4>
			</div>
            <div class="col-md-6" align="right">
            <a href="{{ URL::to('moderator') }}" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a></div>
		</div>
	</div>

	<!-- Moderators -->
	<div class="modal fade" id="update-category">
		<div class="modal-dialog">
			<div class="modal-content">
				
			</div>
		</div>
	</div>

	<div class="clear"></div>
		
		
		<div class="panel panel-primary category-panel" data-collapsed="0">
					
			<div class="panel-heading">
				<div class="panel-title">
					<label>Organize the Categories below:</label> 
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			
			<div class="panel-body">
		
				<div id="nestable" class="nested-list dd with-margins">

                            <table class="table table-bordered text-center iq-card" id="categorytbl">
                                <tr class="table-header r1">
                                <th>Profile</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                    <th>Description</th>
                                    <!-- <th>Total Videos</th> -->
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                    @foreach($moderatorsuser as $user)
                                    <tr id="{{ $user->id }}">
                                    	<td valign="bottom" class="text-center"><img src="{{ URL::to('/') . '/public/uploads/picture/' . $user->picture }}" width="50" height="50"></td>
                                        <td valign="bottom"><p>{{ $user->username }}</p></td>
                                        <td valign="bottom"><p>{{ $user->email }}</p></td>
                                        <td valign="bottom"><p>{{ $user->mobile_number }}</p></td>
                                        <td valign="bottom"><p>{{ $user->description }}</p></td>
                                        <?php if($user->status == 0){ ?>
                                       <td class="bg-warning"> <?php echo "Pending"; ?></td>
                                        <?php }elseif($user->status == 1){ ?>
                                        <td class="bg-success"> <?php  echo "Approved"; ?></td>
                                        <?php }elseif($user->status == 2){ ?>
                                        <td class="bg-danger"> <?php  echo "Rejected"; ?></td>
                                        <?php }?> 

                                        <td>
                                            <div class=" align-items-center list-user-action">
                                                <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                                             data-original-title="Edit" href="{{ URL::to('admin/moderatorsuser/edit/') }}/{{$user->id}}" ><i class="ri-pencil-line"></i></a> 
                                            <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                                             data-original-title="Delete" href="{{ URL::to('admin/moderatorsuser/delete/') }}/{{$user->id}}" ><i
                                                             onclick="return confirm('Are you sure?')"   class="ri-delete-bin-line"></i></a></div>

                                        </td>
                                    </tr>
                                    @endforeach
                            </table>
				</div>
		
			</div>
		
		</div>
    </div>
</div>

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />



@stop