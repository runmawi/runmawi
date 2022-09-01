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
    } 

</style>


@section('content')

    <div id="content-page" class="content-page">
        <div class="container-fluid p-0">
            <div class="iq-card">
                <div id="admin-container" style="padding: 15px;">
                    
                                {{-- Header --}}
                    <div class="admin-section-title">
                        <h5><i class="entypo-plus"></i> Add New Channel Package </h5>
                        <hr />
                    </div>

                            {{-- Alert Message --}}
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
                    
                    <form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" style="" id="channel_package">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <label class="m-0">Package Name</label>
                                <p class="p1">Add the Channel Package Name in the textbox below:</p>
                                <div class="panel-body">
                                    <input type="text" class="form-control" name="channel_package_name" id="channel_package_name" placeholder="Package Name" value="{{ $Channel_package->channel_package_name }}" />
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="m-0"> Add Channel </label>
                                <p class="p1">Select the List Of Channel in the textbox below:</p>

                                <select name="add_channels[]" id="add_channels" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                                    @foreach ($Channel_list as $Channel_lists) 
                                        @if(in_array($Channel_lists->id, $channel_list_selected))
                                            <option value="{{ $Channel_lists->id }}" selected="true">{{ $Channel_lists->channel_name }}</option>
                                        @else
                                            <option value="{{ $Channel_lists->id }}" >{{ $Channel_lists->channel_name }}</option>
                                        @endif 
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <label class="m-0">Package Plan ID</label>
                                <p class="p1">Add the Channel Package plan id in the textbox below:</p>
                                <div class="panel-body">
                                    <input type="text" class="form-control" name="channel_package_plan_id" id="channel_package_plan_id" placeholder="Package Plan ID" value="{{ $Channel_package->channel_package_plan_id }}" />
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="m-0">Package Price</label>
                                <p class="p1">Add the Channel Package Price in the textbox below:</p>
                                <div class="panel-body">
                                    <input type="text" class="form-control" name="channel_package_price" id="channel_package_price" placeholder="Package Price" value="{{ $Channel_package->channel_package_price }}" />
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <label class="m-0">Plan Interval</label>
                                <p class="p1">Add the Channel Plan Interval in the textbox below:</p>
                                <div class="panel-body">
                                    <input type="text" class="form-control" name="channel_plan_interval" id="channel_plan_interval" placeholder="Plan Interval" value="{{ $Channel_package->channel_plan_interval }}" />
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="m-0">Channel Package Status</label>
                                <p class="p1">Enable the Status for Channel Package:</p>
                                <div class="mt-1">
                                    <label class="switch">
                                        <input name="status" id="status" class="status" type="checkbox" @if( $Channel_package->status == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                        
                    <div class="d-flex justify-content-end">
                        <input type="submit" value="{{ 'Update'}}" class="btn btn-primary" />
                    </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
 @stop

@include('admin.channel_package.channel_package_script')

