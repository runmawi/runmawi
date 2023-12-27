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

    .black {
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
        border-radius: 0px 4px 4px 0px;
    }

    .black:hover {
        background: #fff;
        padding: 20px 20px;
        color: rgba(66, 149, 210, 1);

    }
</style>

@section('css')
@stop

@section('content')

    <div id="content-page" class="content-page">

        <div class="d-flex">
            <a class="black" href="{{ route('admin.EPG-Channel.index') }}"> {{ ucwords('All EPG Channel') }} </a>
            <a class="black" href="{{ route('admin.EPG-Channel.create') }}"> {{ ucwords('Create EPG Channel') }} </a>
            <a class="black" style="background:#fafafa!important;color: #006AFF!important;"  href="{{ route('admin.EPG-Channel.edit',$Admin_EPG_Channel->id) }}"> {{ ucwords('Edit EPG Channel') }} </a>
        </div>

        <div class="iq-card">

            @if (Session::has('message'))
                <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
            @endif

            <div class="admin-section-title">
                <h4 class="fs-title"> {{ ('Edit EPG Channel - '. $Admin_EPG_Channel->name ) }}</h4>
            </div>
            <hr />

            <div class="clear"></div>

            <form id="EPG_Channels_form" method="post" action="{{ route('admin.EPG-Channel.update',$Admin_EPG_Channel->id) }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                @csrf

                <div class="row mt-3 p-3 align-items-center">

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> Name </label>
                        <div class="panel-body">
                            <input type="text" placeholder="Enter EPG Channel Name" class="form-control" name="name" id="name" value="{{ optional($Admin_EPG_Channel)->name }}" />
                        </div>
                    </div>

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0">  Slug </label>
                        <div class="panel-body">
                            <input type="text" placeholder="Enter EPG Channel Slug" class="form-control" name="slug" id="slug" value="{{ optional($Admin_EPG_Channel)->slug }}" />
                        </div>
                    </div>
                </div>

                <div class="row mt-3 p-3 align-items-center">
                    <div class="col-sm-12 mt-3" data-collapsed="0">
                        <label class="m-0"> {{ ucwords('Description') }}</label>
                        <div class="panel-body">
                            <textarea class="form-control" placeholder="Enter EPG Channel Description" name="description" id="summary-ckeditor" >  {{ optional($Admin_EPG_Channel)->description  }} </textarea>
                        </div>
                    </div>
                </div>

                <div class="row mt-3 p-3 align-items-center">

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> {{ ucwords('EPG Channel Logo') }}</label>
                        <p class="p1">Select the EPG Channel image Logo :</p>
                        <div class="panel-body">
                            <input type="file" multiple="true" class="form-control" name="logo" id="logo"  accept="image/*"/>
                        </div>
                        
                        <div class="col-sm-6 mt-3" data-collapsed="0">
                            <img src="{{ optional($Admin_EPG_Channel)->Logo_url }}" alt="" width="100px" height="100px">
                        </div>
                    </div>

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> {{ ucwords('EPG channel image') }}</label>
                        <p class="p1">Select the EPG Channel image :</p>

                        <div class="panel-body">
                            <input type="file" multiple="true" class="form-control" name="image" id="image" accept="image/*" />
                        </div>

                        <div class="col-sm-6 mt-3" data-collapsed="0">
                            <img src="{{ optional($Admin_EPG_Channel)->image_url }}" alt="" width="100px" height="100px">
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3 p-3 align-items-center">

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> {{ ucwords('EPG Channel player image') }}</label>
                        <p class="p1">Select the EPG Channel Player image :</p>
                        
                        <div class="panel-body">
                            <input type="file" multiple="true" class="form-control" name="player_image" id="player_image"  accept="image/*"/>
                        </div>

                        <div class="col-sm-6 mt-3" data-collapsed="0">
                            <img src="{{ optional($Admin_EPG_Channel)->Player_image_url }}" alt="" width="100px" height="100px">
                        </div>

                    </div>

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> {{ ucwords('EPG Channel intro video') }}</label>
                        <p class="p1">Select the EPG Channel intro video :</p>
                        <div class="panel-body">
                            <input type="file" multiple="true" class="form-control" name="intro_video" id="intro_video" />
                        </div>

                        <div class="col-sm-6 mt-3" data-collapsed="0">
                            <video  controls controlsList="nodownload"  width="400px"  height="300px">
                                <source src="{{ optional($Admin_EPG_Channel)->Intro_videos_url}} "  type='video/mp4' label='auto' >
                            </video>
                        </div>
                    </div>
                </div>

                <div class="row col-md-12" align="justify" >
                    <input type="submit" value="{{ $button_text }}" class="btn btn-primary mr-2" />
                </div>
            </form>
        </div>

        <div class="clear"></div>
    </div>
    </div>

    @section('javascript')

        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $("#successMessage").fadeOut("fast");
                }, 3000);
            });
        </script>

        {{-- validation --}}

        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

        <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

        <script>

            CKEDITOR.replace( 'summary-ckeditor', {
                filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
                filebrowserUploadMethod: 'form'
            });

            $('form[id="EPG_Channels_form"]').validate({
                rules: {
                    name: "required",
                    slug: {
                        remote: {
                            url: "{{ route('admin.EPG-Channel.slug_validation') }}",
                            type: "get",
                            data: {
                                _token: "{{ csrf_token() }}",
                                button_type: "{{ $button_text }}",
                                success: function() {
                                    return $('#slug').val();
                                }
                            }
                        }
                    },
                },
                messages: {
                    title: "This field is required",
                    slug: {
                        required: "Please Enter the Channel EPG Slug",
                        remote: "Name already in taken ! Please try another Channel EPG Slug"
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                },
            });
        </script>
    @stop
@stop