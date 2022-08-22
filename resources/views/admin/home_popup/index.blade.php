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
                        <form  accept-charset="UTF-8" action="{{ route('homepage_popup_update') }}" method="post" >
                        @csrf
                        <fieldset>
                            <div class="form-card">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        
                                                    {{-- Popup Header and Footer --}}
                                        <div class="row">
                                            <div class="col-sm-6 form-group" >
                                                <label class="m-0"> {{ ucwords('header') }} :</label>
                                                <input type="text"  class="form-control summary-ckeditor" name="popup_header" id="popup_header" placeholder="Pop-up Header" value="{{ $pop_up_content->popup_header }}">
                                            </div>
    
                                            <div class="col-sm-6 form-group" >
                                                <label class="m-0"> {{ ucwords('footer') }} :</label>
                                                <input type="text"  class="form-control summary-ckeditor" name="popup_footer" id="popup_footer" placeholder="Pop-up Footer"value="{{ $pop_up_content->popup_footer }}" >
                                             </div>
                                        </div>

                                                    {{-- Popup Content --}}
                                        <div class="row">
                                            <div class="col-sm-12 form-group" >
                                                <label class="m-0"> {{ ucwords('content') }} :</label>
                                                <textarea name="popup_content" class="form-control summary-ckeditor"  id="popup_content" cols="30" rows="10" value="{{ $pop_up_content->popup_content }}" > {{ html_entity_decode($pop_up_content->popup_content) }} </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary action-button" id="" value="Save" />
                        </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.home_popup.popup_script')