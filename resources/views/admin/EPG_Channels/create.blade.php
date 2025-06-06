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
            <a class="black" href="{{ route('admin.Channel.index') }}"> {{ ucwords('All Channel') }} </a>
            <a class="black" style="background:#fafafa!important;color: #006AFF!important;"  href="{{ route('admin.Channel.create') }}"> {{ ucwords('Create Channel') }} </a>
        </div>

        <div class="iq-card">

            @if (Session::has('message'))
                <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
            @endif

            <div class="admin-section-title">
                <h4 class="fs-title">Create Channel</h4>
            </div>
            <hr />

            <div class="clear"></div>

            <form id="Channels_form" method="POST" action="{{ route('admin.Channel.store') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                @csrf

                <div class="row mt-3 p-3 align-items-center">

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> Name </label>
                        <div class="panel-body">
                            <input type="text" placeholder="Enter Channel Name" class="form-control" name="name" id="name" value="" />
                        </div>
                    </div>

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0">  Slug </label>
                        <div class="panel-body">
                            <input type="text" placeholder="Enter Channel Slug" class="form-control" name="slug" id="slug" value="" />
                        </div>
                    </div>
                </div>

                <div class="row mt-3 p-3 align-items-center">
                    <div class="col-sm-12 mt-3" data-collapsed="0">
                        <label class="m-0"> {{ ucwords('Description') }}</label>
                        <div class="panel-body">
                            <textarea class="form-control" placeholder="Enter Channel Description" name="description" id="summary-ckeditor"> </textarea>
                        </div>
                    </div>
                </div>

                <div class="row mt-3 p-3 align-items-center">

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> {{ ucwords('Channel Logo') }}</label>
                        <p class="p1">Select the Channel image Logo :</p>
                        <div class="panel-body">
                            <input type="file" multiple="true" class="form-control" name="logo" id="logo" accept="image/*"  />
                        </div>
                    </div>

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> {{ ucwords('channel image') }}</label>
                        <p class="p1">Select the Channel image :</p>
                        <div class="panel-body">
                            <input type="file" multiple="true" class="form-control" name="image" id="image" accept="image/*" />
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3 p-3 align-items-center">

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> {{ ucwords('Channel player image') }}</label>
                        <p class="p1">Select the Channel Player image :</p>
                        <div class="panel-body">
                            <input type="file" multiple="true" class="form-control" name="player_image" id="player_image"  accept="image/*" />
                        </div>
                    </div>

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> {{ ucwords('Channel intro video') }}</label>
                        <p class="p1">Select the Channel intro video :</p>
                        <div class="panel-body">
                            <input type="file" multiple="true" class="form-control" name="intro_video" id="intro_video"  accept="video/mp4,video/x-m4v,video/*" />
                        </div>
                    </div>
                </div>

                <div class="row mt-3 p-3 align-items-center" align="left">
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

        <script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
            .create( document.querySelector( '#summary-ckeditor' ) )
            .catch( error => {
                console.error( error );
            });

        </script>

        <script>

            $('form[id="Channels_form"]').validate({
                rules: {
                    name: "required",
                    slug: {
                        remote: {
                            url: "{{ route('admin.Channel.slug_validation') }}",
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
                        required: "Please Enter the Channel Slug",
                        remote: "Name already in taken ! Please try another Channel Slug"
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                },
            });
        </script>
    @stop
@stop