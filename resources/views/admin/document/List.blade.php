@extends('admin.master')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css" />
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

    <div class="container-fluid p-0">
	   <div class="admin-section-title">
            <div class="iq-card">
                <div class="row">
                    <div class="col-md-6">
                        <h4><i class="entypo-archive"></i> Document List</h4>

                        @if (Session::has('message'))
                            <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif

                        @if(count($errors) > 0)
                            @foreach( $errors->all() as $message )
                                <div class="alert alert-danger display-hide" id="successMessage" >
                                    <button id="successMessage" class="close" data-close="alert"></button>
                                    <span>{{ $message }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>

	           <div class="clear"></div>
               </div>
				<div class="panel panel-primary category-panel" data-collapsed="0">
							
					<div class="panel-heading">
						
						<div class="panel-options">
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
						</div>
					</div>
					
					<div class="panel-body">
						<div id="nestable" class="nested-list dd with-margins">
                            <table class="table table-bordered iq-card text-center" id="DocumentTb1">
                                <thead>
                                    <tr class="table-header r1">
                                        <th><label>S.No</label></th>
                                        <th><label>Document Image</label></th>
                                        <th><label>Document Name</label></th>
                                        <th><label>Operation</label></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Documents as $key => $document)
                                    <tr id="{{ $document->id }}">
                                        <td valign="bottom" class="">{{ $key+1}}</td>
                                        <td valign="bottom" class=""><img src="{{ $document->image_url }}" width="50" height="50"></td>
                                        <td valign="bottom"><p>{{ $document->name }}</p></td>
                                        <td>
                                            <div class=" align-items-center list-user-action">
                                                <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="Edit" href="{{ URL::to('admin/document/edit/') }}/{{$document->id}}" ><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/edit.svg';  ?>"></a> 
                                                <a class="iq-bg-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are you sure?')" href="{{ URL::to('admin/document/delete/') }}/{{$document->id}}" ><img class="ply" src="<?php echo URL::to('/').'/assets/img/icon/delete.svg';  ?>"></a>
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

		<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />
	</div>

	@section('javascript')
	
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
		
<script>
    $(document).ready(function(){
        // $('#DocumentTb1').DataTable();

        let table = new DataTable('#DocumentTb1', {
            responsive: true
        });
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>
	@stop



@stop

    
   