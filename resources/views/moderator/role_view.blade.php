@extends('admin.master')

@section('content')
<div id="content-page" class="content-page">
            <div class="container-fluid">
                
	<div class="admin-section-title">
        <div class="iq-card">

		<div class="row">
			<div class="col-md-6">
                <h4>Roles</h4></div>
<div class="col-md-6" align="right">
<p>
    <a class="btn btn-primary" href="{{ URL::to('admin/moderator/role') }}"><span class="glyphicon glyphicon-plus"></span> Add Role</a>
</p>
</div>
</div>
           

<table class="table table-bordered table-hover">
    <thead class="r1">
        <th>Role Name</th>
        <th>Actions</th>
    </thead>
    <tbody>
        @if ($roles->count() == 0)
        <tr>
            <td colspan="5">No Role to display.</td>
        </tr>
        @endif

        @foreach ($roles as $role)
        <tr>
            <td>{{ $role->role_name }}</td>
            <td>
            <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
            data-original-title="Edit" href="{{ URL::to('admin/moderatorsrole/edit/') }}/{{$role->id}}" ><i class="ri-pencil-line"></i></a> 
        <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
            data-original-title="Delete" href="{{ URL::to('admin/moderatorsrole/delete/') }}/{{$role->id}}" ><i
            onclick="return confirm('Are you sure?')"   class="ri-delete-bin-line"></i></a>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
		
		</div>
    </div>
</div>
<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />

@endsection