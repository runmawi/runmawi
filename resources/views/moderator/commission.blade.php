@extends('admin.master')
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('dropzone/dist/min/dropzone.min.css')}}">

    <!-- JS -->
    <script src="{{asset('dropzone/dist/min/dropzone.min.js')}}" type="text/javascript"></script>
@section('content')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<div id="content-page" class="content-page">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="">
					<div class="iq-card-header d-flex justify-content-between">
						<div class="iq-header-title">
							<h4 class="card-title">Add Commission</h4>
						</div>
					</div>
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
					<div class="iq-card-body">
						<h5></h5>
						<form method="POST" action="{{ URL::to('admin/add/commission') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

							<div class="row mt-12 align-items-center">
								<div class="col-md-6 p-0">
									<div class="panel panel-primary " data-collapsed="0"> <div class="panel-heading"> 
										<div class="panel-title"><label>Percentage</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
										<div class="panel-body" style="display: block;"> 
											<p class="p1">Add the Commissiom Account For Videos:</p> 
											<input type="text" class="form-control" name="percentage" id="percentage" placeholder="Add Commission"  value="@if(!empty($commission->percentage)){{ $commission->percentage }}@endif" />
										</div> 
									</div>
								</div>
                               

								<div class="col-md-6 mt-3">
								<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
								<input type="submit" value="Update Percentage" class="btn btn-primary pull-right" />
                                    </div>
                            </div>
							</form>

							<div class="clear"></div>
							<!-- This is where now -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
				



 
@stop


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>







