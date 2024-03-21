@extends('admin.master')
<style type="text/css">
    .has-switch .switch-on label {
        background-color: #FFF;
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
    <style type="text/css">
        .code_editor {
            min-height: 300px;
        }
    </style>
@stop
@section('content')
    <div id="content-page" class="content-page">

        <div class="container-fluid p-0">
            <div class="iq-card">
                <div class="admin-section-title">
                    <h4><i class="entypo-monitor"></i> {{ ucwords('Ads banner Update') }}</h4>
                </div>
                <div class="clear"></div>

                <form action="{{ route('admin.ads_banners_update')}}" method="post" enctype="multipart/form-data">

                    @csrf
                    <div class="panel panel-primary" data-collapsed="0">

                        <div class="panel-body">
                                                    {{-- Left Position --}}
                            <div class="row mt-4 align-items-center">
                                <div class="col-md-6">
                                    <div class="row align-items-center">

                                        <div class="col-sm-12">
                                            <div class="panel-heading">
                                                <div class="panel-title"><p> Left Position Banners </p> </div>
                                                <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex">

                                {{-- Ads Banners upload Type --}}
                                <div class="form-group col-md-3">
                                    <label> Banners upload Type </label>
                                    <select class="form-control left_ads_banners_type" name="left_ads_banners_type">
                                        <option value=" " {{ optional(($ads_banners))->left_ads_banners_type == null ? "selected" : null }}  >Select Banner Type </option>
                                        <option value="left_script_url" {{ optional($ads_banners)->left_ads_banners_type == 'left_script_url' ? "selected" : null }} >Script URL</option>
                                        <option value="left_image_url" {{ optional($ads_banners)->left_ads_banners_type  == 'left_image_url'  ? "selected" : null }}  > Image </option>
                                    </select>
                                </div>

                                {{-- Script Url --}}
                                <div class="form-group col-md-5 left_script_url" style="{{ optional($ads_banners)->left_ads_banners_type == 'left_script_url' ? 'display:block;' : 'display:none;' }}">
                                    <label>Script Url </label>
                                    <input type="text" id="left_script_url" name="left_script_url" class="form-control" value="{{ optional($ads_banners)->left_script_url }}" placeholder="Please! Enter the Script URL" />
                                </div>

                                {{-- Image Upload --}}
                                <div class="form-group col-md-5 left_image_url" style="{{ optional($ads_banners)->left_ads_banners_type == 'left_image_url' ? 'display:block;' : 'display:none;' }}">
                                    <label> Image Upload </label>
                                    <input type="file" id="left_image_url" name="left_image_url" accept="image/png, image/gif, image/jpeg" class="form-control" />
                                    <span style="font-size: small;"> {{ optional($ads_banners)->left_image_url }} </span>
                                </div>

                                <div class="col-md-4">
                                    <label for=""> Status </label>
                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                        <div style="color:red;">In-active</div>
                                        <div class="mt-1">
                                            <label class="switch">
                                                <input type="checkbox" {{ optional($ads_banners)->left_banner_status == 1 ? 'checked' : ' ' }} name="left_banner_status">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div style="color:green;">Active</div>
                                    </div>
                                    <div class="make-switch" data-on="success" data-off="warning"></div>
                                </div>
                            </div>
                        </div>


                        <div class="panel-body">
                                                    {{-- right Position --}}
                            <div class="row mt-4 align-items-center">
                                <div class="col-md-6">
                                    <div class="row align-items-center">

                                        <div class="col-sm-12">
                                            <div class="panel-heading">
                                                <div class="panel-title"><p> Right Position Banners </p> </div>
                                                <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex">

                                {{-- Ads Banners upload Type --}}
                                <div class="form-group col-md-3">
                                    <label> Banners upload Type </label>
                                    <select class="form-control right_ads_banners_type" name="right_ads_banners_type">
                                        <option value=" " {{ optional($ads_banners)->right_ads_banners_type == null ? "selected" : null }}  >Select Banner Type </option>
                                        <option value="right_script_url" {{ optional($ads_banners)->right_ads_banners_type == 'right_script_url' ? "selected" : null }} >Script URL</option>
                                        <option value="right_image_url" {{ optional($ads_banners)->right_ads_banners_type  == 'right_image_url'  ? "selected" : null }}  > Image </option>
                                    </select>
                                </div>

                                {{-- Script Url --}}
                                <div class="form-group col-md-5 right_script_url"
                                    style="{{ optional($ads_banners)->right_ads_banners_type == 'right_script_url' ? 'display:block;' : 'display:none;' }}">
                                    <label>Script Url </label>
                                    <input type="text" id="right_script_url" name="right_script_url" class="form-control" value="{{ optional($ads_banners)->right_script_url }}" placeholder="Please! Enter the Script URL" />
                                </div>

                                {{-- Image Upload --}}
                                <div class="form-group col-md-5 right_image_url" style="{{ optional($ads_banners)->right_ads_banners_type == 'right_image_url' ? 'display:block;' : 'display:none;' }}">
                                    <label> Image Upload </label>
                                    <input type="file" id="right_image_url" name="right_image_url" accept="image/png, image/gif, image/jpeg" class="form-control" />
                                    <span style="font-size: small;"> {{ optional($ads_banners)->right_image_url }} </span>
                                </div>

                                <div class="col-md-4">
                                    <label for=""> Status </label>
                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                        <div style="color:red;">In-active</div>
                                        <div class="mt-1">
                                            <label class="switch">
                                                <input type="checkbox" {{ optional($ads_banners)->right_banner_status == 1 ? 'checked' : ' ' }} name="right_banner_status">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div style="color:green;">Active</div>
                                    </div>
                                    <div class="make-switch" data-on="success" data-off="warning"></div>
                                </div>
                            </div>
                        </div>

                                                
                        <div class="panel-body">
                                                    {{-- bottom Position --}}
                            <div class="row mt-4 align-items-center">
                                <div class="col-md-6">
                                    <div class="row align-items-center">

                                        <div class="col-sm-12">
                                            <div class="panel-heading">
                                                <div class="panel-title"><p> bottom Position Banners </p> </div>
                                                <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex">

                                {{-- Ads Banners upload Type --}}
                                <div class="form-group col-md-3">
                                    <label> Banners upload Type </label>
                                    <select class="form-control bottom_ads_banners_type" name="bottom_ads_banners_type">
                                        <option value=" " {{ optional($ads_banners)->bottom_ads_banners_type == null ? "selected" : null }}  >Select Banner Type </option>
                                        <option value="bottom_script_url" {{ optional($ads_banners)->bottom_ads_banners_type == 'bottom_script_url' ? "selected" : null }} >Script URL</option>
                                        <option value="bottom_image_url" {{ optional($ads_banners)->bottom_ads_banners_type  == 'bottom_image_url'  ? "selected" : null }}  > Image </option>
                                    </select>
                                </div>

                                {{-- Script Url --}}
                                <div class="form-group col-md-5 bottom_script_url"
                                    style="{{ optional($ads_banners)->bottom_ads_banners_type == 'bottom_script_url' ? 'display:block;' : 'display:none;' }}">
                                    <label>Script Url </label>
                                    <input type="text" id="bottom_script_url" name="bottom_script_url" class="form-control" value="{{ optional($ads_banners)->bottom_script_url }}" placeholder="Please! Enter the Script URL" />
                                </div>

                                {{-- Image Upload --}}
                                <div class="form-group col-md-5 bottom_image_url" style="{{ optional($ads_banners)->bottom_ads_banners_type == 'bottom_image_url' ? 'display:block;' : 'display:none;' }}">
                                    <label> Image Upload </label>
                                    <input type="file" id="bottom_image_url" name="bottom_image_url" accept="image/png, image/gif, image/jpeg" class="form-control" />
                                    <span style="font-size: small;"> {{ optional($ads_banners)->bottom_image_url }} </span>
                                </div>

                                <div class="col-md-4">
                                    <label for=""> Status </label>
                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                        <div style="color:red;">In-active</div>
                                        <div class="mt-1">
                                            <label class="switch">
                                                <input type="checkbox" {{ optional($ads_banners)->bottom_banner_status == 1 ? 'checked' : ' ' }} name="bottom_banner_status">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div style="color:green;">Active</div>
                                    </div>
                                    <div class="make-switch" data-on="success" data-off="warning"></div>
                                </div>
                            </div>
                        </div>
                                                
                        <div class="panel-body">
                                                    {{-- top Position --}}
                            <div class="row mt-4 align-items-center">
                                <div class="col-md-6">
                                    <div class="row align-items-center">

                                        <div class="col-sm-12">
                                            <div class="panel-heading">
                                                <div class="panel-title"><p> top Position Banners </p> </div>
                                                <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex">

                                {{-- Ads Banners upload Type --}}
                                <div class="form-group col-md-3">
                                    <label> Banners upload Type </label>
                                    <select class="form-control top_ads_banners_type" name="top_ads_banners_type">
                                        <option value=" " {{ optional($ads_banners)->top_ads_banners_type == null ? "selected" : null }}  >Select Banner Type </option>
                                        <option value="top_script_url" {{ optional($ads_banners)->top_ads_banners_type == 'top_script_url' ? "selected" : null }} >Script URL</option>
                                        <option value="top_image_url" {{ optional($ads_banners)->top_ads_banners_type  == 'top_image_url'  ? "selected" : null }}  > Image </option>
                                    </select>
                                </div>

                                {{-- Script Url --}}
                                <div class="form-group col-md-5 top_script_url"
                                    style="{{ optional($ads_banners)->top_ads_banners_type == 'top_script_url' ? 'display:block;' : 'display:none;' }}">
                                    <label>Script Url </label>
                                    <input type="text" id="top_script_url" name="top_script_url" class="form-control" value="{{ optional($ads_banners)->top_script_url }}" placeholder="Please! Enter the Script URL" />
                                </div>

                                {{-- Image Upload --}}
                                <div class="form-group col-md-5 top_image_url" style="{{ optional($ads_banners)->top_ads_banners_type == 'top_image_url' ? 'display:block;' : 'display:none;' }}">
                                    <label> Image Upload </label>
                                    <input type="file" id="top_image_url" name="top_image_url" accept="image/png, image/gif, image/jpeg" class="form-control" />
                                    <span style="font-size: small;"> {{ optional($ads_banners)->top_image_url }} </span>
                                </div>

                                <div class="col-md-4">
                                    <label for=""> Status </label>
                                    <div class="d-flex justify-content-around align-items-center" style="width:50%;">
                                        <div style="color:red;">In-active</div>
                                        <div class="mt-1">
                                            <label class="switch">
                                                <input type="checkbox" {{ optional($ads_banners)->top_banner_status == 1 ? 'checked' : ' ' }} name="top_banner_status">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div style="color:green;">Active</div>
                                    </div>
                                    <div class="make-switch" data-on="success" data-off="warning"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body mt-4" style="display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn btn-primary " name="submit"> Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('javascript')

    <script>
        $(document).ready(function() {

            $(".left_ads_banners_type").change(function() {

                $('.left_script_url, .left_image_url').hide();

                let left_ads_banners_type = $('.left_ads_banners_type').val();

                if (left_ads_banners_type === 'left_script_url') {
                    $('.left_script_url').css("display", "block");
                } else if (left_ads_banners_type === 'left_image_url') {
                    $('.left_image_url').css("display", "block");
                }
            });

            $(".right_ads_banners_type").change(function() {

                $('.right_script_url, .right_image_url').hide();

                let right_ads_banners_type = $('.right_ads_banners_type').val();

                if (right_ads_banners_type === 'right_script_url') {
                    $('.right_script_url').css("display", "block");
                } else if (right_ads_banners_type === 'right_image_url') {
                    $('.right_image_url').css("display", "block");
                }
            });

            $(".top_ads_banners_type").change(function() {

                $('.top_script_url, .top_image_url').hide();

                let top_ads_banners_type = $('.top_ads_banners_type').val();

                if (top_ads_banners_type === 'top_script_url') {
                    $('.top_script_url').css("display", "block");
                } else if (top_ads_banners_type === 'top_image_url') {
                    $('.top_image_url').css("display", "block");
                }
            });

            $(".bottom_ads_banners_type").change(function() {

                $('.bottom_script_url, .bottom_image_url').hide();

                let bottom_ads_banners_type = $('.bottom_ads_banners_type').val();

                if (bottom_ads_banners_type === 'bottom_script_url') {
                    $('.bottom_script_url').css("display", "block");
                } else if (bottom_ads_banners_type === 'bottom_image_url') {
                    $('.bottom_image_url').css("display", "block");
                }
            });
        });

    </script>
@stop