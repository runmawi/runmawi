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
    .lar {
    font-family: 'Line Awesome Free';
    font-weight: 400;
    margin: 4px;
}
     .form-control {
   
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
   
    <div class="d-flex">
        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/livestream') }}">All Live Videos</a>
        <a class="black" href="{{ URL::to('admin/livestream/create') }}">Add New Live Video</a>
        <a class="black" href="{{ URL::to('admin/CPPLiveVideosIndex') }}">Live Videos For Approval</a>
        <a class="black" href="{{ URL::to('admin/livestream/categories') }}">Manage Live Video Categories</a>
    </div>

    <div class="container-fluid p-0">
	    <div class="admin-section-title">
            <div class="iq-card">
		        <div class="row">
			        <div class="col-md-6">
                        <h4><i class="entypo-video"></i> Live Videos</h4>
			        </div>

			        @if (Session::has('message'))
                       <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif

                    <div class="col-md-6" align="right">	
                        <a href="{{ URL::to('admin/livestream/create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus-circle"></i> Add New</a>
                    </div>
		        </div>    
	
	            <div class="clear"></div>
	                <div class="gallery-env mt-2">
			            <table class="data-tables table livestream_table iq-card text-center p-0" style="width:100%">
				            <thead>
                                <tr class="r1">
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>User Name</th>
                                    <th>Video Type</th>
                                    <th>Video Access</th>
                                    <th>Status</th>
                                    <th>Stream Type</th>
                                    <th>Slider</th>
                                    <th>Action</th>
                                </tr>
				            </thead>

                            <tbody>
                                @forelse ($videos as $item)
                                    
                                @empty
                                    
                                @endforelse
                            </tbody>
			            </table>
		                <div style="position: relative;top: -50px;" class="pagination-outter mt-3 pull-right"><?= $videos->appends(Request::only('s'))->render(); ?></div>
	                </div>
                </div>
            </div>
        </div>
    </div>


	

@stop

