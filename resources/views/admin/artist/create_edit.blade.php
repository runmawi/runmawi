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
@stop @section('content')

<div id="content-page" class="content-page">
    <div class="d-flex">
    <a class="black" href="{{ URL::to('admin/artists') }}">All Artists</a>
    <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/artists/create') }}">Add New Artist</a></div>
    <!-- This is where -->
    <div class="iq-card">
        <!--<ol class="breadcrumb"> <li> <a href="{{ Url::to('/admin/artist_list') }}"><i class="fa fa-newspaper-o"></i>Manage Artist</a> </li> <li class="active">@if(!empty($artist->id)) <strong>{{ $artist->name }}</strong> @else <strong>Create Artist</strong> @endif</li> </ol>-->
        @if (Session::has('message'))
        <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
        @endif @if(count($errors) > 0) @foreach( $errors->all() as $message )
        <div class="alert alert-danger display-hide" id="successMessage">
            <button id="successMessage" class="close" data-close="alert"></button>
            <span>{{ $message }}</span>
        </div>
        @endforeach @endif
        <div class="admin-section-title">
            @if(!empty($artist->id))
            <h3 class="fs-title">Editing Artist - {{ $artist->artist_name }}</h3>
            @else
            <h4 class="fs-title">Create Artist</h4>
            @endif
        </div>
        <hr />

        <div class="clear"></div>

        <form id="artist_form" method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
            <div class="@if(!empty($artist->created_at)) col-sm-12 @else col-sm-12 @endif">
                <div class="row mt-3">
                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0">Artist</label>
                        <div class="panel-body">
                            <input type="text" class="form-control" name="artist_name" id="artist_name" value="@if(!empty($artist->artist_name)){{ $artist->artist_name }}@endif" />
                        </div>
                    </div>

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0">Description</label>
                        <div class="panel-body">
                            <textarea class="form-control" name="description" id="description">@if(!empty($artist->description)){{ $artist->description }}@endif</textarea>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0">Picture</label>
                        <p class="p1">Select the artist image (300x300 px or 2:2 ratio):</p>
                        <div class="panel-body">
                            <input type="file" multiple="true" class="form-control" name="image" id="image" />
                        </div>
                    </div>

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <div class="panel-body">
                            @if(!empty($artist->image))
                            <img src="{{ URL::to('/public/uploads/artists/') . '/'.$artist->image }}" class="movie-img" width="200" />
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function () {
        // $('#message').fadeOut(120);
        setTimeout(function () {
            $("#successMessage").fadeOut("fast");
        }, 3000);
    });
</script>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script>
    $('form[id="artist_form"]').validate({
        rules: {
            artist_name: "required",
            description: "required",
            parent_id: {
                required: true,
            },
        },
        messages: {
            title: "This field is required",
            description: "This field is required",
            parent_id: {
                required: "This field is required",
            },
        },
        submitHandler: function (form) {
            form.submit();
        },
    });
</script>
@stop @stop
