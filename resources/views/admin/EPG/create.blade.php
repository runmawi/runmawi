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

        <div class="iq-card">

            @if (Session::has('message'))
                <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
            @endif

            <div class="admin-section-title">
                <h4 class="fs-title">Generate EPG </h4>
            </div>
            <hr />

            <div class="clear"></div>

            <form id="EPG_form" method="post" action="{{ route('admin.epg.generate') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                @csrf

                <div class="row mt-3 p-3 align-items-center">

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> EPG Name </label>
                        <div class="panel-body">
                            <input type="text" id="name" name="name"  class="form-control" placeholder="Enter the EPG Name">
                        </div>
                    </div>

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0">  EPG Slug   </label>
                        <div class="panel-body">
                            <input type="text" id="slug" name="slug"  class="form-control" placeholder="Enter the EPG Slug">
                        </div>
                    </div>
                </div>

                <div class="row mt-3 p-3 align-items-center">

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> Channel </label>
                        <div class="panel-body">
                            <select class="form-control m-bot15" name="epg_channel_id">
                                <option value="" >{{ "Select the Channel" }}</option>
                                @foreach($EPG_channels as $key => $EPG_channel)
                                    <option value="{{$EPG_channel->id}}">{{ $EPG_channel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0">  EPG Format   </label>
                        <div class="panel-body">
                            <select class="form-control m-bot15" name="epg_format">
                                <option value="{{ "XML-FILE"}}" selected> {{ 'XML FILE' }}  </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-3 p-3 align-items-center">

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> {{ ucwords('Start Date') }}</label>
                        <div class="panel-body">
                            <input type="date" class="form-control"  name="epg_start_date"  max="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <label class="m-0"> {{ ucwords('End Date') }}</label>
                        <div class="panel-body">
                            <input type="date" class="form-control"  name="epg_end_date" max="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3 p-3 align-items-center">
                    <div class="col-sm-6 mt-3" data-collapsed="0">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                    <div><label class="mt-1">  {{ ucwords('Exclude Content ') }}   </label></div>
                                    <div class="d-flex justify-content-between">
                                        <div class="mt-2">
                                            <input type="checkbox" checked  name="include_gaps_status" />
                                            <label class="m-0">Gaps</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

        <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

        <script>

            $('form[id="EPG_form"]').validate({
                rules: {
                    name: "required",
                    epg_channel_id : "required",
                    epg_start_date : "required",
                    epg_end_date : "required",
                    
                },
                messages: {
                    title: "This field is required",
                },
                submitHandler: function(form) {
                    form.submit();
                },
            });
        </script>
    @stop
@stop