@extends('admin.master')

@include('admin.favicon')


@section('content')

<div id="content-page" class="content-page">
    <div class="container-fluid p-0">
        <div id="webhomesetting">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Multi User Limit Management</h4>
                    </div>
                </div>

                <div class="panel panel-primary mt-3" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-options">
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    
                    @if (Session::has('message'))
                       <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif

                <form method="POST" action="{{ $post_route }}"  accept-charset="UTF-8" file="1" enctype="multipart/form-data" >
                    @csrf
                    <div class="panel-body">
                        <div class="row align-items-center p-2">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label class="mb-2">Number of simultaneous Sessions  <small>(Give in Number)</small> </label>
                                    <div class="form-group">
                                        <input type="text"  class="form-control"  name="multiuser_limit" id="multiuser_limit" value="{{ $Setting }}" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bt p-3">
                        <input class="btn btn-primary" type="submit" value="{{ $button_text }}" class="btn btn-black pull-right" /></div>
                    </div>
		        </form>
                
                </div>
            </div>
        </div>
    </div>
</div>

@stop





