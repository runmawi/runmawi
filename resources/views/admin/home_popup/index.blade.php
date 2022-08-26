@extends('admin.master')

@include('admin.favicon')

    @section('css')
        <link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    @endsection

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

@section('content')

<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> Pop-up </h4>
                        </div>
                    </div>

                        {{-- Success Message --}}
                    @if (Session::has('message'))
                        <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif

                    <div class="iq-card-body table-responsive">
                        <form  accept-charset="UTF-8" action="{{ route('homepage_popup_update') }}" method="post" enctype="multipart/form-data" >
                        @csrf
                        <fieldset>
                            <div class="form-card">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        
                                                    {{-- Popup Enable --}}
                                        <div class="row">
                                            <div class="col-sm-6 form-group" >
                                                <div class="input-group color-picker d-flex align-items-center justify-content-between" style="width: ;">
                                                <div><label class="mt-1"> Enable Home Page Pop Up : </label></div>
                                                    <div class="mt-1 d-flex align-items-center justify-content-around">
                                                        <div class="mr-2">OFF</div>
                                                        <label class="switch mt-2">
                                                            <input type="checkbox" name="popup_enable" id="popup_enable"  @if ($pop_up_content && $pop_up_content->popup_enable  == 1) {{ "checked='checked'" }} @else {{ "" }} @endif >
                                                            <span class="slider round"></span>
                                                        </label>
                                                        <div class="ml-2">ON</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                                    {{-- Popup Header and Footer --}}
                                        <div class="row">
                                            <div class="col-sm-6 form-group" >
                                                <label class="m-0"> {{ ucwords('header') }} :</label>
                                                <input type="text"  class="form-control summary-ckeditor" name="popup_header" id="popup_header" placeholder="Pop-up Header" value="{{  $pop_up_content ? $pop_up_content->popup_header : " " }}">
                                            </div>
    
                                            <div class="col-sm-6 form-group" >
                                                <label class="m-0"> {{ ucwords('footer') }} :</label>
                                                <input type="text"  class="form-control summary-ckeditor" name="popup_footer" id="popup_footer" placeholder="Pop-up Footer"value="{{ $pop_up_content ? $pop_up_content->popup_footer : " "}}" >
                                             </div>
                                        </div>

                                                    {{-- Popup before Login & After Login Link --}}
                                        <div class="row">
                                            <div class="col-sm-6 form-group" >
                                                <label class="m-0"> {{ ucwords('Before Login Link') }} :</label>
                                                <input type="text"  class="form-control" name="before_login_link" id="before_login_link" placeholder="signup" value="{{  $pop_up_content ? $pop_up_content->before_login_link : " " }}">
                                            </div>
    
                                            <div class="col-sm-6 form-group" >
                                                <label class="m-0"> {{ ucwords('After Login Link') }} :</label>
                                                <input type="text"  class="form-control" name="after_login_link" id="after_login_link" placeholder="becomesubscriber" value="{{ $pop_up_content ? $pop_up_content->after_login_link : " "}}" >
                                             </div>
                                        </div>

                                                    {{-- image --}}
                                        <div class="row">
                                            <div class="col-sm-6 form-group" >
                                                <label class="m-0"> {{ ucwords('Pop-up image') }} :</label>
                                                <input type="file"  class="form-control" name="popup_image" id="popup_image"  value="{{ $pop_up_content ? $pop_up_content->popup_image : " " }}">
                                            </div>

                                            @if ( $pop_up_content != null && $pop_up_content->popup_image != null )
                                                <div class="col-sm-6 d-flex" >
                                                    <img src="{{ URL::to('public/images/'. $pop_up_content->popup_image ) }}" alt="pop-up Image" width="250px" height="250px">
                                                </div>
                                            @endif
                                        </div>

                                                    {{-- Popup Content --}}
                                        <div class="row">
                                            <div class="col-sm-12 form-group" >
                                                <label class="m-0"> {{ ucwords('content') }} :</label>
                                                <textarea name="popup_content" class="form-control summary-ckeditor"  id="popup_content" cols="30" rows="10" value="{{ $pop_up_content ? $pop_up_content->popup_content : " " }}" > {{ html_entity_decode($pop_up_content ? $pop_up_content->popup_content : " ") }} </textarea>
                                            </div>
                                        </div>

                                                    {{--update Button  --}}
                                        <div class="row">
                                            <div class="col-sm-12" >
                                                <input type="submit" class="btn btn-primary action-button" id="" value="update" style="float: right;" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.home_popup.popup_script')

