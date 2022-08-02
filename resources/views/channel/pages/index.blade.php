@extends('channel.master')
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
@section('content')
<div id="content-page" class="content-page">
         <div class="container-fluid">

	<div class="admin-section-title">
         <div class="iq-card">
		<div class="row">
			<div class="col-md-4">
				<h3><i class="entypo-newspaper"></i> Page</h3>
			</div>
            <div class="col-md-8" align="right">
                <a href="{{ URL::to('cpp/pages/create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
            </div>
            
             @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
            @endif    
            
            
			<!--div class="col-md-4">	
				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" name="s" id="search-input" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
			</div-->
		</div>
	
	<div class="clear"></div>

	<div class="gallery-env" style="padding:15px;">
        <div class="row">
	<table class="table table-bordered genres-table">
		<tr class="table-header">
			<th>Page</th>
			<th>URL</th>
			<th>Active</th>
			<th>Actions</th>
			@foreach($pages as $page)
			<tr>
				<td>
					<a href="{{ URL::to('page') . '/' . $page->slug }}" target="_blank">{{ $page->title }}</a>
				</td>
				<td valign="bottom"><p>{{ $page->slug }}</p></td>
				<td><p>{{ $page->active }}</p></td>
				<td>
					<div class="align-items-center list-user-action">
						<a href="{{ URL::to('cpp/pages/edit') . '/' . $page->id }}" class="iq-bg-success" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Edit"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a>
						<a href="{{ URL::to('cpp/pages/delete') . '/' . $page->id }}" class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Delete"><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
					</div>
				</td>
			</tr>
			@endforeach
	</table>

	<div class="clear"></div>

	<div class="pagination-outter"><?= $pages->render(); ?></div>
       </div>
</div>
    </div>
</div>
    </div>
	<script>

		$ = jQuery;
		$(document).ready(function(){
			$('.delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this page?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});

	</script>


@stop

