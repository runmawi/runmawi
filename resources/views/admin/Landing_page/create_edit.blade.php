@extends('admin.master')

@include('admin.favicon')

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid p-0">
            <div class="iq-card">
                <div id="admin-container" style="padding: 15px;">

                            {{-- Header Title --}}
                    <div class="admin-section-title">
                        <h5><i class="entypo-plus"></i> {{ $Header_title }}</h5>
                        <hr/>
                    </div>

                    @if (Session::has('message'))
                        <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif 
                    
                    <div class="clear"></div>

                    <form method="POST" action="{{ route( $post_route )  }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" style="" id="live_video">
                        @csrf

                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <label class="m-0">Content 1 </label>
                                <div class="panel-body">
                                    <input type="text" class="form-control" name="content_1" id="content_1" placeholder="" value="@if(!empty($landing_page_details->content_1)){{ $landing_page_details->content_1 }}@endif" />
                                </div>
                            </div>

                             <div class="col-sm-6">
                                <label class="m-0">Content 2</label>
                                <div class="panel-body">
                                    <input type="text" class="form-control" name="content_2" id="content_2" placeholder=" " value="@if(!empty($landing_page_details->content_2)){{ $landing_page_details->content_2 }}@endif" />
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <label class="m-0">Content 3 </label>
                                <div class="panel-body">
                                    <input type="text" class="form-control" name="content_3" id="content_3" placeholder="" value="@if(!empty($landing_page_details->content_3)){{ $landing_page_details->content_3 }}@endif" />
                                </div>
                            </div>

                             <div class="col-sm-6">
                                <label class="m-0">Content 4</label>
                                <div class="panel-body">
                                    <input type="text" class="form-control" name="content_4" id="content_4" placeholder=" " value="@if(!empty($landing_page_details->content_4)){{ $landing_page_details->content_4 }}@endif" />
                                </div>
                            </div>
                        </div>

                        </div>

                    
                        <div class="d-flex justify-content-end">
                            <input type="submit" value="{{ $button_text }}" class="btn btn-primary" />
                        </div>
                    </form>

                    <div class="clear"></div>
                </div>
            </div>
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
    @stop

