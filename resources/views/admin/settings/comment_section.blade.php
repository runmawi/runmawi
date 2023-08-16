@extends('admin.master')

@include('admin.favicon')

@section('content')

<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="iq-card">

                            {{-- Header  --}}
            <div class="iq-card-header d-flex justify-content-between mb-3">
                <div class="iq-header-title">
                   <h4 class="card-title">{{ 'Comment Section' }}</h4>
                </div>
            </div>
                             {{-- Header alert message  --}}
            @if (Session::has('message'))
                <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
            @endif

            <div class="">
	            <form  accept-charset="UTF-8" action="{{ route('comment_section_update') }}" method="post">
                    @csrf
                    <div class="col-md-12">
                        <div class="row">

                            <div class="col-md-9 row">
                                <label class="col-md-6" for="">Enable Comment Section for Videos </label>
                                <div class="mt-1 col-md-4">
                                    <label class="switch">
                                        <input name="videos" id="videos" class="" type="checkbox" {{ !empty($comment_section->videos) == "1" ? 'checked' : ''  }}  >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-9 row">
                                <label class="col-md-6" for="">Enable Comment Section for Live Videos </label>
                                <div class="mt-1 col-md-4">
                                    <label class="switch">
                                        <input name="livestream" id="livestream" class="" type="checkbox" {{ !empty($comment_section->livestream) == "1" ? 'checked' : ''  }}  >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-9 row">
                                <label class="col-md-6" for=""> Enable Comment Section for Episode  </label>
                                <div class="mt-1 col-md-4">
                                    <label class="switch">
                                        <input name="episode" id="episode" class="" type="checkbox" {{ !empty($comment_section->episode) == "1" ? 'checked' : ''  }}  >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-9 row">
                                <label class="col-md-6" for=""> Enable Comment Section for Audios  </label>
                                <div class="mt-1 col-md-4">
                                    <label class="switch">
                                        <input name="audios" id="audios" class="" type="checkbox" {{ !empty($comment_section->audios) == "1" ? 'checked' : ''  }}  >
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