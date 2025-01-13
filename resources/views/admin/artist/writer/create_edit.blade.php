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

        <a class="black" href="{{ URL::to('admin/Writer') }}"> All Writer </a>
        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/Writer/create') }}">Add New Writer</a></div>
                
        <div class="iq-card">

        <!--<ol class="breadcrumb"> <li> <a href="{{ Url::to('/admin/artist_list') }}"><i class="fa fa-newspaper-o"></i>Manage Artist</a> </li> <li class="active">@if(!empty($artist->id)) <strong>{{ $artist->name }}</strong> @else <strong>Create Artist</strong> @endif</li> </ol>-->
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
            @if(!empty($artist->id))
                <h3 class="fs-title">Editing Writer - {{ $artist->artist_name }}</h3>
            @else
                <h4 class="fs-title">Create Writer</h4>
            @endif
        </div>

        <hr />

        <div class="clear"></div>

        <form id="" method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

            <div class="@if(!empty($artist->created_at)) col-sm-12 @else col-sm-12 @endif">
                <div class="row mt-3 p-0">
                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> Writer </label>
                        <div class="panel-body">
                            <input type="text" placeholder="Artist Name" class="form-control" name="artist_name" id="artist_name" value="@if(!empty($artist->artist_name)){{ $artist->artist_name }}@endif" />
                        </div>
                    </div>
                    
                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> Writer Slug </label>
                        <div class="panel-body">
                            <input type="text"  placeholder="Artist Slug" class="form-control" name="artist_slug" id="artist_slug" value="@if(!empty($artist->artist_slug)){{ $artist->artist_slug }}@endif" />                        </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3 p-3 align-items-center">

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> {{ ucwords('Description') }}</label>
                        <div class="panel-body">
                            <textarea class="form-control" placeholder="Artist Description" name="description" id="description">@if(!empty($artist->description)){{ $artist->description }}@endif</textarea>
                        </div>
                    </div>

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> {{ ucwords('Writer type') }}</label>
                        <div class="panel-body">
                            <input class="form-control" type="text" name="artist_type" id="artist_type" value="Writer" readonly>

                        </div>
                    </div>

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0">Picture</label>
                        <p class="p1">Select the Writer image (300x300 px or 2:2 ratio):</p>
                        <div class="panel-body">
                            <input type="file" multiple="true" class="form-control" name="image" id="image" />
                        </div>
                    </div>

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <div class="panel-body">
                            @if(!empty($artist->image) &&  $artist->image != null )
                            <img src="{{ $artist->image }}" class="movie-img" width="200" />
                            @endif
                        </div>
                    </div>
                </div>
                

                @if(isset($artist->id))
                    <input type="hidden" id="id" name="id" value="{{ $artist->id }}" />
                @endif

                <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                
                <div class=" p-0 mt-4">
                    <input type="submit" value="{{ $button_text }}" class="btn btn-primary mr-2" />
                </div>
            </div>
            
            <div class="clear"></div>
        </form>

        <div class="clear"></div>
    </div>
</div>

@section('javascript')

<script type="text/javascript" src="{{ Url::to('/assets/admin/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{ Url::to('/assets/js/jquery.mask.min.js') }}"></script>

<script type="text/javascript">
    $ = jQuery;

    $(document).ready(function () {
        tinymce.init({
            relative_urls: false,
            selector: "#body, #body_guest",
            toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor | code",
            plugins: ["advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen", "save table contextmenu directionality emoticons template paste textcolor code"],
            menubar: false,
        });
    });
</script>

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
    $('form[id="artist_form"]').validate({
        rules: {
            artist_name: "required",
            description: "required",
            artist_type: "required",
            // parent_id: {
            //     required: true,
            // },
            artist_slug: {
                    remote: {
                        url:"{{ URL::to('admin/artist_slug_validation') }}",
                        type: "get",
                        data: {
                            _token: "{{csrf_token()}}" ,
                            button_type : "{{ $button_text }}",
                            success: function() {
                            return $('#artist_slug').val(); }
                        }
                    }
                },
        },
        messages: {
            title: "This field is required",
            description: "This field is required",
            artist_type: "This field is required",
            // parent_id: {
            //     required: "This field is required",
            // },
            // artist_slug: {
            //          required: "Please Enter the Artist Slug",
            //          remote: "Name already in taken ! Please try another Artist Slug"
            //     },
        },
        submitHandler: function (form) {
            form.submit();
        },
    });
</script>
@stop @stop
