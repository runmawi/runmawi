@extends('admin.master')

@include('admin.favicon')

@section('content')

<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="iq-card">

                            {{-- Header  --}}
            <div class="iq-card-header d-flex justify-content-between mb-3">
                <div class="iq-header-title">
                   <h4 class="card-title">{{ 'Compress Image' }}</h4>
                </div>
            </div>
                             {{-- Header alert message  --}}
            @if (Session::has('message'))
                <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
            @endif

            <div class="">
	            <form  accept-charset="UTF-8" action="{{ route('compress_image_store') }}" method="post">
                    @csrf
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <label for=""> Compress Resolution Size <span> ( kb )</span> </label>
                                <input type="number" name="compress_resolution_size" id="compress_resolution_size" placeholder="Compress Resolution Size" class="form-control"  required value="@if(!empty($Compress_image->compress_resolution_size)){{ $Compress_image->compress_resolution_size }}@endif" /><br />
                            </div>

                            <div class="col-md-6">
                                <label for=""> Compress Resolution Format </label>
                                <select class="form-control" name="compress_resolution_format" id="compress_resolution_format" >
                                    <option value="webp" {{ !empty($Compress_image->compress_resolution_format) == "webp" ? 'selected' :  '' }} > WebP Format </option>
                                    <option value="jpg"  {{ !empty($Compress_image->compress_resolution_format) == "jpg" ? 'selected'  :  ''  }} > JPG  Format</option>
                                    <option value="jpeg" {{ !empty($Compress_image->compress_resolution_format) == "jpeg" ? 'selected' :  '' }} > JPEG Format</option>
                                </select>
                            </div>

                            <div class="col-md-9 row">
                                <label class="col-md-5" for="">Enable Compress for Images </label>
                                <div class="mt-1 col-md-4">
                                    <label class="switch">
                                        <input name="enable_compress_image" id="enable_compress_image" class="" type="checkbox" {{ !empty($Compress_image->enable_compress_image) == "1" ? 'checked' : ''  }}  >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 form-group" align="right">
                        <button type="submit" class="btn btn-primary" >Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- Header alert message Script  --}}

@section('javascript')

    <script>

        $(document).ready(function () {
            setTimeout(function () {
                $("#successMessage").fadeOut("fast");
            }, 3000);
        });
    </script>

@stop