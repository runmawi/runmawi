@extends('admin.master')

@section('content')

    <div id="content-page" class="content-page">

        <div class="container-fluid">
            <div class="iq-card">
                <div id="moderator-container">

                    <div class="moderator-section-title">
                        <h4><i class="entypo-globe"></i> {{ ucwords( "Import user Bulk Data" ) }}  </h4> 
                    </div>

                    <div class="col-md-12">
                        @if (Session::has('message'))
                            <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif

                        @if (Session::has('import-error-message'))
                            <div id="successMessage" class="alert alert-danger">{{ Session::get('import-error-message') }}</div>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('users_import')  }}" id="Import_user" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                        @csrf

                        <div class="container mt-4">
                            <div class="row justify-content-between">
                                <div class="col-md-6" >
                                    <label for=""> {{ ucwords('Import Excel file') }} </label>
                                    <div class="form-group row">
                                        <div class="col-md-12 form-group" align="left">
                                            <input type="file" name="file" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6" >
                                    <label for=""> {{ ucwords('Sample Excel file') }}   </label>
                                    <div class="form-group row">
                                        <div class="col-md-12 form-group" align="left">
                                            <div class="text-white">
                                                <a href="{{ URL::to("/public/sample_Excel/Sample-Excel.xlsx")}}" style="font-size:48px; color: #1fa113 !important;" class="fa fa-file-excel-o video_pdf"  download ></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12 form-group" align="right">
                            <button class="btn btn-success"> Import  </button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>
@endsection    

@section('javascript')

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $("#successMessage,.alt-message").fadeOut("fast");
            }, 3000);
        });

        $( "#Import_user" ).validate({
            rules: {
                file: {
                    required: true,
                    extension: "xlsx|csv"
                },
            },
        });

    </script>   
@stop
