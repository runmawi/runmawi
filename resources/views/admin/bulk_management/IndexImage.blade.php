@extends('admin.master')
<style>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

@section('content')


<div id="content-page" class="content-page">
    <div class="container-fluid p-0">
        <div class="row ">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header ">

                        <div class="col-md-6">
                            <h4><i class="entypo-archive"></i> Upload Image Zip </h4>
                        </div>
                        <br>
                        @if (Session::has('message'))
                            <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif

                        @if (Session::has('error_message'))
                            <div id="successMessage" class="alert alert-danger ">{{ Session::get('error_message') }}</div>
                        @endif

                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $message)
                                <div class="alert alert-danger display-hide" id="successMessage">
                                    <button id="successMessage" class="close" data-close="alert"></button>
                                    <span>{{ $message }}</span>
                                </div>
                            @endforeach
                        @endif
                        <form action="{{ URL::to('admin/zip_bulk_import') }}" method="post" enctype="multipart/form-data">

                            <div class="col-md-12">
                                <input type="file" class="form-control"  name="zip_file" accept=".zip">
                                <br>
                                <!-- <span id="zip_file_error" style="color:red;">* Choose ZIP File</span> -->
                                <br>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            </div> 
                            <br>

                            <input type="submit" id="ZipImport" class="btn btn-primary" value="Upload">
                        </form>

                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>

          <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
  		$(document).ready(function() {
			setTimeout(function() {
				$('#successMessage').fadeOut('fast');
			}, 3000);
		})
</script>

@stop

