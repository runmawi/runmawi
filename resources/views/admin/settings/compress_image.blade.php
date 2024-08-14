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
                                    <option value="webp" {{ !empty($Compress_image->compress_resolution_format) && $Compress_image->compress_resolution_format == "webp" ? 'selected' :  '' }} > WebP Format </option>
                                    <option value="jpg"  {{ !empty($Compress_image->compress_resolution_format) && $Compress_image->compress_resolution_format == "jpg" ? 'selected'  :  ''  }} > JPG  Format</option>
                                    <option value="jpeg" {{ !empty($Compress_image->compress_resolution_format) && $Compress_image->compress_resolution_format == "jpeg" ? 'selected' :  '' }} > JPEG Format</option>
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

                    <div class="iq-card-header d-flex justify-content-between mb-3">
                        <div class="iq-header-title">
                           <h4 class="card-title">{{ 'Dimension Image validation' }}</h4>
                        </div>
                    </div>

                    <div class="iq-card-body table-responsive p-0">
                        <div class="table-view">
                           <table class="table table-striped table-bordered table movie_table iq-card" style="width:100%" id="Thumbnail">
                              <thead>
                                 <tr class="r1">
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                 </tr>
                              </thead>
                           @csrf 
                           <tbody>
                                <td> {{ '1'}} </td>
                                <td> {{ 'Videos'}} </td>
                                <td> 
                                    <div class="mt-1 row align-items-center justify-content-around">
                                        <div class="col-2">
                                            <label class="switch">
                                                <input name="videos" class="videos" id="videos" type="checkbox" @if( $Compress_image != null &&  $Compress_image->videos == "1") checked   @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-10 size-validation" id="videos-size-validation" style="display: none;">
                                            <div class="row align-items-center">
                                                <span>{{ 'Video Thumbnail:' }}</span>
                                                <div class="col-4 d-flex align-items-center">
                                                    Width: <input class="form-control m-1" id="width_validation_videos" maxlength="4" pattern="\d{1,4}" name="width_validation_videos" type="text" value="{{ $Compress_image->width_validation_videos }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                                <div class="col-4 d-flex align-items-center">
                                                    Height: <input class="form-control m-1" id="height_validation_videos" maxlength="4" pattern="\d{1,4}" name="height_validation_videos" type="text" value="{{ $Compress_image->height_validation_videos }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <span>{{ 'Player Thumbnail:' }}</span>
                                                <div class="col-4 d-flex align-items-center">
                                                    Width:<input class="form-control m-1" id="width_validation_player_img" name="width_validation_player_img" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->width_validation_player_img }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);" />px
                                                </div>
                                                <div class="col-4 d-flex align-items-center">
                                                    Height: <input class="form-control m-1" id="height_validation_player_img" maxlength="4" pattern="\d{1,4}" name="height_validation_player_img" type="text" value="{{ $Compress_image->height_validation_player_img }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tbody>
                            
                            <tbody>
                                <td> {{ "2" }} </td>
                                <td> {{ 'Live Videos'}} </td>
                                <td> 
                                    <div class="mt-1 row align-items-center justify-content-around">
                                        <div class="col-2">
                                            <label class="switch">
                                                <input name="tv_image_live_validation" class="tv_image_live_validation" id="tv_image_live_validation" type="checkbox" @if(  $Compress_image != null &&  $Compress_image->tv_image_live_validation == "1") checked  @endif  >
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-10 size-validation" id="live-size-validation" style="display: none;">
                                            <div class="row align-items-center">
                                                <span>{{ 'Video Thumbnail:' }}</span>
                                                <div class="col-4 d-flex align-items-center">
                                                    Width: <input class="form-control m-1" id="width_validation_live" name="width_validation_live" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->width_validation_live }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);" />px
                                                </div>
                                                <div class="col-4 d-flex align-items-center">
                                                    Height: <input class="form-control m-1" id="height_validation_live" name="height_validation_live" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->height_validation_live }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);" />px
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <span>{{ 'Player Thumbnail:' }}</span>
                                                <div class="col-4 d-flex align-items-center">
                                                    Width: <input class="form-control m-1" id="live_player_img_width" name="live_player_img_width" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->live_player_img_width }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);" />px
                                                </div>
                                                <div class="col-4 d-flex align-items-center">
                                                    Height: <input class="form-control m-1" id="live_player_img_height" name="live_player_img_height" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->live_player_img_height }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);" />px
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tbody>
                            
                            <tbody>
                                <td> {{ "3" }} </td>
                                <td> {{ 'Series' }} </td>
                                <td> 
                                    <div class="mt-1 row align-items-center justify-content-around">
                                        <div class="col-2">
                                            <label class="switch">
                                                <input name="series" class="series" id="series" type="checkbox" @if(  $Compress_image != null &&  $Compress_image->series == "1") checked  @endif  >
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-10 size-validation" id="series-size-validation" style="display: none;">
                                            <div class="row align-items-center">
                                                <span>{{ 'Video Thumbnail:' }}</span>
                                                <div class="col-4 d-flex align-items-center">
                                                    Width: <input class="form-control m-1" id="width_validation_series" name="width_validation_series" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->width_validation_series }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                                <div class="col-4 d-flex align-items-center">
                                                    Height: <input class="form-control m-1" id="height_validation_series" name="height_validation_series" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->height_validation_series }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <span>{{ 'Player Thumbnail:' }}</span>
                                                <div class="col-4 d-flex align-items-center">
                                                    Width: <input class="form-control m-1" id="series_player_img_width" name="series_player_img_width" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->series_player_img_width }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                                <div class="col-4 d-flex align-items-center">
                                                    Height: <input class="form-control m-1" id="series_player_img_height" name="series_player_img_height" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->series_player_img_height }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tbody>
                            
                            <tbody>
                                <td> {{ "4" }} </td>
                                <td> {{ 'Season' }} </td>
                                <td> 
                                    <div class="mt-1 row align-items-center justify-content-around">
                                        <div class="col-2">
                                            <label class="switch">
                                                <input name="season" class="season" id="season" type="checkbox" @if(  $Compress_image != null &&  $Compress_image->season == "1") checked  @endif >
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-10 size-validation" id="season-size-validation" style="display: none;">
                                            <div class="row align-items-center">
                                                <span>{{ 'Season Thumbnail:' }}</span>
                                                <div class="col-4 d-flex align-items-center">
                                                    Width: <input class="form-control m-1" id="width_validation_season" name="width_validation_season" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->width_validation_season }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                                <div class="col-4 d-flex align-items-center">
                                                    Height: <input class="form-control m-1" id="height_validation_season" name="height_validation_season" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->height_validation_season }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tbody>
                            
                            <tbody>
                                <td> {{ "5" }} </td>
                                <td> {{ 'Episode' }} </td>
                                <td> 
                                    <div class="mt-1 row align-items-center justify-content-around">
                                        <div class="col-2">
                                            <label class="switch">
                                                <input name="episode" class="episode" id="episode" type="checkbox"  @if(  $Compress_image != null &&  $Compress_image->episode == "1") checked  @endif >
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-10 size-validation" id="episode-size-validation" style="display: none;">
                                            <div class="row align-items-center">
                                                <span>{{ 'Video Thumbnail:' }}</span>
                                                <div class="col-4 d-flex align-items-center">
                                                    Width: <input class="form-control m-1" id="width_validation_episode" name="width_validation_episode" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->width_validation_episode }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                                <div class="col-4 d-flex align-items-center">
                                                    Height: <input class="form-control m-1" id="height_validation_episode" name="height_validation_episode" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->height_validation_episode }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <span>{{ 'Player Thumbnail:' }}</span>
                                                <div class="col-4 d-flex align-items-center">
                                                    Width: <input class="form-control m-1" id="episode_player_img_width" name="episode_player_img_width" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->episode_player_img_width }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                                <div class="col-4 d-flex align-items-center">
                                                    Height: <input class="form-control m-1" id="episode_player_img_height" name="episode_player_img_height" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->episode_player_img_height }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tbody>
                            
                            <tbody>
                                <td> {{ "6" }} </td>
                                <td> {{ 'Audio' }} </td>
                                <td> 
                                    <div class="mt-1 row align-items-center justify-content-around">
                                        <div class="col-2">
                                            <label class="switch">
                                                <input name="audios" class="audios" id="audios" type="checkbox" @if(  $Compress_image != null &&  $Compress_image->audios == "1") checked  @endif >
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-10 size-validation" id="audio-size-validation" style="display: none;">
                                            <div class="row align-items-center">
                                                <span>{{ 'Video Thumbnail:' }}</span>
                                                <div class="col-4 d-flex align-items-center">
                                                    Width: <input class="form-control m-1" id="width_validation_audio" name="width_validation_audio" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->width_validation_audio }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                                <div class="col-4 d-flex align-items-center">
                                                    Height: <input class="form-control m-1" id="height_validation_audio" name="height_validation_audio" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->height_validation_audio }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <span>{{ 'Player Thumbnail:' }}</span>
                                                <div class="col-4 d-flex align-items-center">
                                                    Width: <input class="form-control m-1" id="audio_player_img_width" name="audio_player_img_width" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->audio_player_img_width }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                                <div class="col-4 d-flex align-items-center">
                                                    Height: <input class="form-control m-1" id="audio_player_img_height" name="audio_player_img_height" type="text" maxlength="4" pattern="\d{1,4}" value="{{ $Compress_image->audio_player_img_height }}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);"/>px
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tbody>
                        

                               </table>
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

<style>
    input.form-control.m-1 {height: 30px;background: #ccc;}
</style>
@section('javascript')

    <script>

        $(document).ready(function () {
            
            function toggleSizeValidation(id, validationId, widthId, heightId, player_width, player_height) {
                const isChecked = $(id).is(":checked");
                if (isChecked) {
                    $(validationId).show();
                    $(widthId).prop('disabled', false);
                    $(heightId).prop('disabled', false);
                    $(player_width).prop('disabled', false);
                    $(player_height).prop('disabled', false);
                } else {
                    $(validationId).hide();
                    $(widthId).val(null).prop('disabled', true);
                    $(heightId).val(null).prop('disabled', true);
                    $(player_width).val(null).prop('disabled', true);
                    $(player_height).val(null).prop('disabled', true);
                }
            }

            function setupSizeValidation(toggleId, validationId, widthId, heightId, player_width, player_height) {
                toggleSizeValidation(toggleId, validationId, widthId, heightId, player_width, player_height);
                $(toggleId).change(function() {
                    toggleSizeValidation(toggleId, validationId, widthId, heightId, player_width, player_height);
                });
            }

            // Initial setup
            setupSizeValidation('#videos', '#videos-size-validation', '#width_validation_videos', '#height_validation_videos','#width_validation_player_img','#height_validation_player_img');
            setupSizeValidation('#tv_image_live_validation', '#live-size-validation', '#width_validation_live', '#height_validation_live','#live_player_img_width','#live_player_img_height');
            setupSizeValidation('#series', '#series-size-validation', '#width_validation_series', '#height_validation_series','#series_player_img_width','series_player_img_height');
            setupSizeValidation('#season', '#season-size-validation', '#width_validation_season', '#height_validation_season', '#season_player_img_width','#season_player_img_height');
            setupSizeValidation('#episode', '#episode-size-validation', '#width_validation_episode', '#height_validation_episode','#episode_player_img_width','#episode_player_img_height');
            setupSizeValidation('#audios', '#audio-size-validation', '#width_validation_audio', '#height_validation_audio','#audio_player_img_width','#audio_player_img_height');

        });

    </script>
    
    <script>
        setTimeout(function () {
                $("#successMessage").fadeOut("fast");
            }, 3000);
    </script>

@stop