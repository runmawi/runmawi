@extends('admin.master')

<style>
    
    .select2-selection__rendered {
        background-color: #f7f7f7 !important;
        border: none !important;
    }
    .select2-container--default .select2-selection--multiple {
        border: none !important;
    }

    #video {
        background-color: #f7f7f7 !important;
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

    .tags-input-wrapper{
        background: transparent;
        padding: 10px;
        border-radius: 4px;
        max-width: 400px;
        border: 1px solid #ccc
    }
    
    .tags-input-wrapper input{
        border: none;
        background: transparent;
        outline: none;
        width: 140px;
        margin-left: 8px;
    }

    .tags-input-wrapper .tag{
        display: inline-block;
        background-color: #20222c;
        color: white;
        border-radius: 40px;
        padding: 0px 3px 0px 7px;
        margin-right: 5px;
        margin-bottom:5px;
        box-shadow: 0 5px 15px -2px rgba(250 , 14 , 126 , .7)
    }

    .tags-input-wrapper .tag a {
        margin: 0 7px 3px;
        display: inline-block;
        cursor: pointer;
    } */
</style>

@section('content')

<div id="content-page" class="content-page">
    <div class="d-flex">
        {{-- <a class="black" href="{{ URL::to('admin/livestream') }}">All Live Videos</a>
        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/livestream/create') }}">Add New Live Video</a>
        <a class="black" href="{{ URL::to('admin/CPPLiveVideosIndex') }}">Live Videos For Approval</a>
        <a class="black" href="{{ URL::to('admin/livestream/categories') }}">Manage Live Video Categories</a> --}}
    </div>

    <div class="container-fluid p-0">
        <div class="iq-card">
            <div id="admin-container" style="padding: 15px;">  

                                                {{-- Title --}}
                <div class="admin-section-title">
                    <div class="d-flex justify-content-between">
                        <h5><i class="entypo-plus"></i> {{ 'Add Restream OBS' }}</h5>
                    </div>
                    <hr/>
                </div>

                                            {{-- Message  --}}
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

                <div class="clear"></div>
                <form method="POST" action="{{ route('Restream_obs_store') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" style="" id="live_video">
                    @csrf
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label class="m-0"> {{ ucwords('restream title') }} </label>
                            <div class="panel-body">
                                <input type="text" class="form-control" name="restream_title" id="restream_title" placeholder="{{ ucwords('restream title') }}" value="" />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="m-0"> {{ ucwords('Privacy Status') }} </label>
                            <div class="panel-body">
                                <select class="form-control" id="privacy_status" name="privacy_status">
                                    <option value="public" > Public </option>
                                    <option value="private"> Private </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label class="m-0"> {{ ucwords('Resolution') }} </label>
                            <div class="panel-body">
                                <select class="form-control" id="resolution" name="resolution">
                                    <option value="240p" > 240p </option>
                                    <option value="360p">  360p </option>
                                    <option value="480p">  480p </option>
                                    <option value="720p">  720p </option>
                                    <option value="1080p"> 1080p </option>
                                    <option value="1440p"> 1440p </option>
                                    <option value="2160p"> 2160p </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="m-0"> {{ ucwords(' frame Rate') }} </label>
                            <div class="panel-body">
                                <select class="form-control" id="frame_rate" name="frame_rate">
                                    <option value="30fps" > 30 fps </option>
                                    <option value="60fps"> 60 fps </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label class="m-0"> {{ ucwords('Scheduled Start Time') }} </label>
                            <div class="panel-body">
                                <input type="text" class="form-control" name="ScheduledStartTime" id="ScheduledStartTime" placeholder="{{ ucwords('Scheduled Start Time') }}" value="{{ $current_time }}" readonly />
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                    <input type="submit" value="{{ "Create" }}" class="btn btn-primary" /></div>
                </form>
            </div>
        </div>
    </div>
</div>