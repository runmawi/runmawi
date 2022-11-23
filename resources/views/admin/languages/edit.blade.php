@extends('admin.master')

<style type="text/css">
    .has-switch .switch-on label {
        background-color: #fff;
        color: #000;
    }
    .make-switch {
        z-index: 2;
    }
    .iq-card {
        padding: 15px;
    }
    .p1 {
        font-size: 12px;
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
    <link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
@stop 

@section('content')

    <div id="content-page" class="content-page">
        <div class="d-flex">

            <a class="black" href="{{ URL::to('admin/admin-languages') }}"> All Language </a>
            <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/admin-languages') }}">Add New Language</a></div>
                    
            <div class="iq-card">

                @if (Session::has('message'))
                    <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                @endif 
            
                @if(count($errors) > 0) 
                    @foreach( $errors->all() as $message )
                        <div class="alert alert-danger display-hide" id="successMessage">
                            <button id="successMessage" class="close" data-close="alert"></button>
                            <span>{{ $message }}</span>
                        </div>
                    @endforeach 
                @endif

                <div class="admin-section-title">
                    <h4 class="fs-title"> Edit Language </h4>
                </div>

            <hr/>

            <div class="clear"></div>

            <form id="language_edit" method="POST" action="{{ route('LanguageUpdate') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                @csrf
                <div class="col-sm-12">
                    <div class="row mt-3 p-0">
                        <div class="col-sm-6 mt-3" data-collapsed="0">
                            <label class="m-0"> Name 
                                <p> Enter The Language Name :</p>
                            </label>
                            <div class="panel-body">
                                <input type="text" id="name" name="name" class="form-control" value="{{ $languages->name }}" placeholder="Language Name">
                            </div>
                        </div>

                        <div class="col-sm-6 mt-3" data-collapsed="0">
                            <label class="m-0"> Thumbnail </label>
                            <p> Select The Language Image ( 1:1 Ratio or 1024 X 1024px ) :</p>
                            <div class="panel-body">
                                <input type="file" id="language_image" name="language_image" class="form-control" value="{{ $languages->language_image  }}">
                            </div>
                        </div>

                    </div>

                    <div class="row mt-3 p-3 align-items-center">

                        <div class="col-sm-6 mt-3" data-collapsed="0">
                            <div class="panel-body">
                                @if(!empty( $languages->language_image ) && $languages->language_image != null )
                                    <img src="{{ URL::to('/public/uploads/Language/'.$languages->language_image)  }}" class="movie-img" width="200" alt="No Image Found" />
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" id="check_image" name="check_image" value="@if(!empty($languages->language_image) ) {{"validate"}} @else {{ " " }} @endif"  />
                    <input type="hidden" name="language_id" value="{{ $languages->id }}"  />

                    <div class=" p-0 mt-4">
                        <input type="submit" value="{{ 'Update' }}" class="btn btn-primary mr-2"  />
                    </div>
                </div>
                
                <div class="clear"></div>
            </form>

            <div class="clear"></div>
        </div>
    </div>

    @section('javascript')

    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $("#successMessage").fadeOut("fast");
            }, 3000);
        });
    </script>

    {{-- validation --}}

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script>
        $('form[id="language_edit"]').validate({
            rules: {
                name: "required",
                language_image: {
                    required: '#check_image:blank',
                },
            },
        
            submitHandler: function (form) {
                form.submit();
            },
        });
    </script>
    @stop 
@stop
