@extends('channel.master') @section('css')
<style>
    
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
    background-color: #fa0e7e;
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

<?php
$series = App\Series::where('id',$episodes->series_id)->first()  ;
// dd($series->title);
$media_url = URL::to('/episode/').'/'.$series->title.'/'.$episodes->slug;
$embed_media_url = URL::to('/episode/embed').'/'.$series->title.'/'.$episodes->slug;
$url_path = '<iframe width="853" height="480" src="'.$embed_media_url.'"  allowfullscreen></iframe>';
?>
<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
@stop @section('content')
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <!-- This is where -->
        <div class="iq-card">
            <div class="admin-section-title">
                @if(!empty($episodes->id))
                <div class="d-flex justify-content-between">
                    <div><h1 class="card-title">{{ $episodes->title }}</h1></div>
                    <div class="pull-right">
                        <a href="{{URL::to('episode') . '/' . @$episodes->series_title->title . '/' . $episodes->slug }}" target="_blank" class="btn btn-primary"> <i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i> </a>
                    </div>
                </div>
                @endif
            </div>
            

            <hr />
            <div class="clear"></div>

            <form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="Episode_edit">
                

                <div class="row ">
                    <div class="col-md-6 mb-3">
                        <label class="m-0" ><h4 class="fs-title m-0">Embed Link:</h4></label>
                        <p>Click <a href="#"onclick="EmbedCopy();" class="share-ico"><i class="ri-links-fill"></i> here</a> to get the Embedded URL</p>
                    </div>
    
                    <div class="col-md-6 mb-3">
                        <label class="m-0" ><h4 class="fs-title m-0">Social Share:</h4></label>
                        <div class="share-box">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>" class="share-ico"><i class="ri-facebook-fill"></i></a>&nbsp;  <!-- Facebook -->
                            <a href="https://twitter.com/intent/tweet?text=<?= $media_url ?>" class="share-ico"><i class="ri-twitter-fill"></i></a> <!-- Twitter -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label class="m-0">Title</label>
                        <p class="p1">Add the episodes title in the textbox below:</p>

                        <div class="panel-body">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Episode Title" value="@if(!empty($episodes->title)){{ $episodes->title }}@endif" style="" />
                        </div>
                    </div>
                    @if(!empty($episodes->created_at))
                    <div class="col-sm-6 mb-3">
                        <label class="m-0">Created Date</label>
                        <p class="p1">Select Date/Time Below</p>
                        
                        <div class="panel-body">
                            <input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($episodes->created_at)){{ $episodes->created_at }}@endif" />
                        </div>
                    </div>
                    @endif
                    <div class="col-sm-6 mb-3">
                        <label class="m-0">Slug</label>
                        <p class="p1">Add the episodes Slug in the textbox below:</p>
                        
                        <div class="panel-body">
                            <input type="text" class="form-control" name="slug" id="slug" placeholder="Episode Slug" value="@if(!empty($episodes->slug)){{ $episodes->slug }}@endif" />
                        </div>
                    </div>
                </div>
                

                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label class="m-0">Episode Image Cover</label>
                        <p class="p1">Select the episodes image (1080X1920px / 1280X720px or 9:16 / 16:9 ratio)</p>

                        <div class="panel-body">
                            @if(!empty($episodes->image))
                                <img src="{{ URL::to('/') . '/public/uploads/images/' . $episodes->image }}" class="episodes-img" width="200" />
                            @endif
                            <input type="file" multiple="true" class="form-group" name="image" id="image" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="m-0">Episode Player Image</label>
                        <p class="p1">Select the player image ( 1280X720px or 16:9 Ratio)</p>

                        <div class="panel-body">
                            @if(!empty($episodes->player_image))
                                <img src="{{ URL::to('/') . '/public/uploads/images/' . $episodes->player_image }}" class="episodes-img" width="200" />
                            @endif
                            <input type="file" multiple="true" class="form-group" name="player_image" id="player_image" />
                        </div>
                    </div>

                         {{-- for validate --}} 
                    <input type="hidden" id="check_image" name="check_image" value="@if(!empty($episodes->image) ) {{ "validate" }} @else {{ " " }} @endif"  />
                    <input type="hidden" id="player_check_image" name="player_check_image" value="@if(!empty($episodes->player_image) ) {{ "validate" }} @else {{ " " }} @endif"  />

                </div>
                <div class="row mb-3">

                <div class="col-sm-6">
                        <label class="m-0">Episode Ratings</label>
                        <p class="p1">IMDb Ratings 10 out of 10</p>

                        <div class="panel-body">
                            <input class="form-control" name="rating" id="rating" value="@if(!empty($episodes->rating)){{ $episodes->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);" />
                        </div>
                    </div>

                            <div class="col-sm-6">
                            <label class="m-0">Search Tags</label>

                                <div class="panel-body">
								<input type="text" id="tag-input1" class="form-control" name="searchtags">

                             </div>
                        </div>
                    </div>

                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label class="m-0">Episode Source</label>
                        <p class="p1">Episode Format</p>

                        <div class="panel-body">
                            <select id="type" name="type" class="form-control">
                                <option value="embed">Embed Code</option>
                                <option value="file" @if(!empty($episodes->type) && $episodes->type == 'file'){{ 'selected' }}@endif>Episode File</option>
                                <option value="upload" @if(!empty($episodes->type) && $episodes->type == 'upload'){{ 'selected' }}@endif>Upload Episode</option>
                            </select>
                            <hr />
                        </div>
                        
                        <div class="panel-body">
                            <div class="new-episodes-file" @if(!empty($episodes->type) && $episodes->type == 'file'){{ 'style="display:block"' }}@else style = "display:none" @endif>
                                <label for="mp4_url">Mp4 File URL:</label>
                                <input type="text" class="form-control" name="mp4_url" id="mp4_url" value="@if(!empty($episodes->mp4_url)){{ $episodes->mp4_url }}@endif" />
                            </div>
                            <div class="new-episodes-embed" @if(!empty($episodes->type) && $episodes->type == 'embed')style="display:block"@else style = "display:none" @endif>
                                <label for="embed_code">Embed Code:</label>
                                <textarea class="form-control" name="embed_code" id="embed_code">@if(!empty($episodes->embed_code)){{ $episodes->embed_code }}@endif</textarea>
                            </div>
                            @error('episode_upload')
                            <div class="alert alert-danger">{{ $episode_upload }}</div>
                            @enderror
                            <div class="new-episodes-upload" @if(!empty($episodes->type) && $episodes->type == 'upload')style="display:block"@else style = "display:none" @endif>
                                <label for="embed_code">Upload Episode</label>
                                <input type="file" name="episode_upload" id="episode_upload" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">

                        @if(!empty($episodes->type) && ($episodes->type == 'upload' || $episodes->type == 'file'))
                        <video width="200" height="200" controls>
                            <source src="{{ $episodes->mp4_url }}" type="video/mp4" />
                        </video>
                        @endif @if(!empty($episodes->type) && $episodes->type == 'embed')
                        <iframe src="{{ $episodes->mp4_url }}"></iframe>
                        @endif
                        
                    </div>
                </div>

                {{--
                <div class="panel-body col-sm-6 p-0" style="display: block;">
                    <label><h6>Age Restrict :</h6></label>
                    <select class="form-control" id="age_restrict" name="age_restrict">
                        <option selected disabled="">Choose Age</option>
                        @foreach($age_categories as $age)
                        <option value="{{ $age->id }}" @if(!empty($episodes->age_restrict) && $episodes->age_restrict == $age->id)selected="selected"@endif>{{ $age->slug }}</option>
                        @endforeach
                    </select>
                </div>
                --}}

                <div class="clear"></div>

                <div class="row mt-3">
                    <div class="col-sm-4">
                        
                        <label class="m-0">Skip Intro Time <small>(Please Give In Seconds)</small></label>
                        <div class="panel-body">
                            <input class="form-control" name="skip_intro" id="skip_intro" value="@if(!empty($episodes->skip_intro)){{ $episodes->skip_intro }}@endif" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="m-0">Intro Start Time <small>(Please Give In Seconds)</small></label>
                        <div class="panel-body">
                            <input class="form-control" name="intro_start_time" id="intro_start_time" value="@if(!empty($episodes->intro_start_time)){{ $episodes->intro_start_time }}@endif" />
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <label class="m-0">Intro End Time <small>(Please Give In Seconds)</small></label>
                        <div class="panel-body">
                            <input class="form-control" name="intro_end_time" id="intro_end_time" value="@if(!empty($episodes->intro_end_time)){{ $episodes->intro_end_time }}@endif" />
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-4">
                     <label class="m-0">Skip Recap Time <small>(Please Give In Seconds)</small></label>
                        <div class="panel-body">
                            <input class="form-control" name="skip_recap" id="skip_recap" value="@if(!empty($episodes->skip_recap)){{ $episodes->skip_recap }}@endif" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="m-0">Recap Start Time <small>(Please Give In Seconds)</small></label>
                        <div class="panel-body">
                            <input class="form-control" name="recap_start_time" id="recap_start_time" value="@if(!empty($episodes->recap_start_time)){{ $episodes->recap_start_time }}@endif" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="m-0">Recap End Time <small>(Please Give In Seconds)</small></label>
                        <div class="panel-body">
                            <input class="form-control" name="recap_end_time" id="recap_end_time" value="@if(!empty($episodes->recap_end_time)){{ $episodes->recap_end_time }}@endif" />
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-4">
                        <label class="m-0">Duration</label>
                        <p class="p1">Enter the episode duration in (HH : MM : SS)</p>

                        <div class="panel-body">
                            <input class="form-control" name="duration" id="duration" value="@if(!empty($episodes->duration)){{ gmdate('H:i:s', $episodes->duration) }}@endif" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="m-0">Free content Duration</label>
                        <p class="p1">Enter the episode duration in (HH : MM : SS) </p>

                        <div class="panel-body">
                            <input class="form-control" name="free_content_duration" id="free_content_duration" value="@if(!empty($episodes->free_content_duration)){{ gmdate('H:i:s', $episodes->free_content_duration) }}@endif" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="m-0">User Access</label>
                        <p class="p1">Who is allowed to view this episode?</p>

                        <div class="panel-body">
                            <select id="access" name="access">
                                    <option value="guest" @if(!empty($episodes->access) && $episodes->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option>
                                    <option value="registered" @if(!empty($episodes->access) && $episodes->access == 'registered'){{ 'selected' }}@endif>Registered Users (free registration must be enabled)</option>
                                    <option value="subscriber" @if(!empty($episodes->access) && $episodes->access == 'subscriber'){{ 'selected' }}@endif>Subscriber (only paid subscription users)</option>
                                    <?php if($settings->ppv_status == 1){ ?>
                                    <!-- <option value="ppv" @if(!empty($episodes->access) && $episodes->access == 'ppv'){{ 'selected' }}@endif>PPV Users (Pay per movie)</option>    -->
                                    <?php } else{ ?>
                                    <!-- <option value="ppv" @if(!empty($episodes->access) && $episodes->access == 'ppv'){{ 'selected' }}@endif>PPV Users (Pay per movie)</option>    -->
                                    <?php } ?>
                            </select>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-4">
                        <label class="m-0">Status Settings</label>
                        <div class="panel-body">
                            <div>
                                <label class="m-0" >Is this episode Featured:</label>
                                <input type="checkbox" @if(!empty($episodes->featured) && $episodes->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
                            </div>
                            <div class="clear"></div>
                            <div>
                                <label class="m-0">Is this episode Active:</label>
                                <input type="checkbox" @if(!empty($episodes->active) && $episodes->active == 1){{ 'checked="checked"' }}@elseif(!isset($episodes->active)){{ 'checked="checked"' }}@endif name="active" value="1"
                                id="active" />
                            </div>
                            <div class="clear"></div>
                            <div>
                                <label class="m-0">Is this episode display in Banner:</label>
                                <input type="checkbox" @if(!empty($episodes->banner) && $episodes->banner == 1){{ 'checked="checked"' }}@endif name="banner" value="1" id="banner" />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- <div class="col-sm-4" id="ppv_price"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"> <label>PPV Price :</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" value="@if(!empty($episodes->ppv_price)){{ $episodes->ppv_price }}@endif">

					</div>
				</div> -->

                    <div class="col-sm-4 mt-3">
                        <div class="panel panel-primary" data-collapsed="0">
                            <!-- <div class="panel-heading"> <div class="panel-title"> <label>Is this video Is Global PPV:</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>  -->
                            <?php //if($settings->ppv_status == 1){ ?>
                            <!-- <label for="global_ppv">Is this video Is Global PPV:</label> -->
                            <!-- <input type="checkbox" name="ppv_status" value="1" id="ppv_status"@if(!empty($episodes->ppv_status) && $episodes->ppv_status == 1){{ 'checked="checked"' }}@elseif(!isset($episodes->ppv_status)){{ 'checked="checked"' }}@endif /> -->
                            <?php //} else{ ?>
                            <!-- <div class="global_ppv_status"> -->
                            <!-- <label for="global_ppv">Is this video Is PPV:</label> -->
                            <!-- <input type="checkbox" name="ppv_status" value="1" id="ppv_status"@if(!empty($episodes->ppv_status) && $episodes->ppv_status == 1){{ 'checked="checked"' }}@elseif(!isset($episodes->ppv_status)){{ 'checked="checked"' }}@endif /> -->
                            <!-- </div> -->
                            <?php //} ?>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="col-sm-8 p-3">
                        @if(isset($series->id))
                        <input type="hidden" id="series_id" name="series_id" value="{{ $episodes->series_id }}" />
                        @endif @if(isset($episodes->id))
                        <input type="hidden" id="season_id" name="season_id" value="{{ $episodes->season_id }}" />
                        @endif @if(isset($episodes->id))
                        <input type="hidden" id="id" name="id" value="{{ $episodes->id }}" />
                        @endif

                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                        <input type="submit" value="{{ $button_text }}" class="btn btn-primary pull-right" />
                    </div>
                </div>
                <!-- row -->
            </form>

            <div class="clear"></div>
        </div>
    </div>
        @section('javascript')

        <script type="text/javascript" src="{{ URL::to('/assets/admin/js/tinymce/tinymce.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::to('/assets/js/jquery.mask.min.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

        <script>

            
            $(document).ready(function ($) {
                $("#duration").mask("00:00:00");
                $('#intro_start_time').mask("00:00:00");
                $('#intro_end_time').mask("00:00:00");
                $('#recap_start_time').mask("00:00:00");
                $('#recap_end_time').mask("00:00:00");
                $('#skip_intro').mask("00:00:00");
                $('#skip_recap').mask("00:00:00");
            });

            $(document).ready(function () {
                $("#ppv_price").hide();
                $("#global_ppv_status").hide();
                // alert($(this).val());
                if ($("#access").val() == "ppv") {
                    // alert($(this).val());
                    $("#ppv_price").show();
                    $("#global_ppv_status").show();
                } else {
                    $("#ppv_price").hide();
                    $("#global_ppv_status").hide();
                }
                $("#access").change(function () {
                    if ($(this).val() == "ppv") {
                        // alert($(this).val());
                        $("#ppv_price").show();
                        $("#global_ppv_status").show();
                    } else {
                        $("#ppv_price").hide();
                        $("#global_ppv_status").hide();
                    }
                });
            });
            // $("#intro_start_time").datetimepicker({
            //     format: "hh:mm ",
            // });
            // $("#intro_end_time").datetimepicker({
            //     format: "hh:mm ",
            // });
            // $("#recap_start_time").datetimepicker({
            //     format: "hh:mm ",
            // });
            // $("#recap_end_time").datetimepicker({
            //     format: "hh:mm ",
            // });
        </script>
        <script type="text/javascript">
            $ = jQuery;

            $(document).ready(function () {
                $("#duration").mask("00:00:00");
                $("#tags").tagsInput();

                $("#type").change(function () {
                    if ($(this).val() == "file") {
                        $(".new-episodes-file").show();
                        $(".new-episodes-embed").hide();
                        $(".new-episodes-upload").hide();
                    } else if ($(this).val() == "embed") {
                        $(".new-episodes-file").hide();
                        $(".new-episodes-embed").show();
                        $(".new-episodes-upload").hide();
                    } else {
                        $(".new-episodes-file").hide();
                        $(".new-episodes-embed").hide();
                        $(".new-episodes-upload").show();
                    }
                });

                tinymce.init({
                    relative_urls: false,
                    selector: "#details",
                    toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor | code",
                    plugins: ["advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen", "save table contextmenu directionality emoticons template paste textcolor code"],
                    menubar: false,
                });
            });

            function NumAndTwoDecimals(e, field) {
                var val = field.value;
                var re = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)$/g;
                var re1 = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)/g;
                if (re.test(val)) {
                    if (val > 10) {
                        alert("Maximum value allowed is 10");
                        field.value = "";
                    }
                } else {
                    val = re1.exec(val);
                    if (val) {
                        field.value = val[0];
                    } else {
                        field.value = "";
                    }
                }
            }
        </script>

        @section('javascript')

        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script>

            $.validator.addMethod('greaterThan', function(value, element) {
                var intro_start_time = $("#intro_start_time").val();
                var intro_end_time = $('#intro_end_time').val();
                return intro_start_time < intro_end_time;
            });

            $.validator.addMethod('Skipintro_greaterThan', function(value, element) {
                var intro_end_time = $("#intro_end_time").val();
                var skip_time = $('#skip_intro').val();
                return skip_time > intro_end_time;
            });


            $.validator.addMethod('RecapgreaterThan', function(value, element) {
                var recap_start_time = $("#recap_start_time").val();
                var recap_end_time = $('#recap_end_time').val();
                return recap_start_time < recap_end_time;
            });

            $.validator.addMethod('Recapintro_greaterThan', function(value, element) {
                var recap_end_time = $("#recap_end_time").val();
                var skip_recap = $('#skip_recap').val();
                return skip_recap > recap_end_time;
            });

                // Image upload dimention validation
                $.validator.addMethod('dimention', function(value, element, param) {
            if(element.files.length == 0){
                return true; 
            }

            var width = $(element).data('imageWidth');
            var height = $(element).data('imageHeight');
            var ratio = $(element).data('imageratio');

            if( ratio == '0.56'|| ratio == '1.78' || width == param[0] && height == param[1]){
                return true;
            }else{
                return false;
            }
        },'Please upload an image with 1080 x 1920 pixels dimension  or 9:16 Ratio or 16:9 Ratio ');

                // player Image upload validation
        $.validator.addMethod('player_dimention', function(value, element, param) {
            if(element.files.length == 0){
                return true; 
            }

            var width = $(element).data('imageWidth');
            var height = $(element).data('imageHeight');
            var ratio = $(element).data('imageratio');

            if( ratio == '1.78'||  width == param[0] && height == param[1]){
                return true;
            }else{
                return false;
            }
        },'Please upload an image with 1280 x 720 pixels dimension  or 16:9 Ratio');


        $('#image').change(function() {

            $('#image').removeData('imageWidth');
            $('#image').removeData('imageHeight');
            $('#image').removeData('imageratio');

            var file = this.files[0];
            var tmpImg = new Image();

            tmpImg.src=window.URL.createObjectURL( file ); 
            tmpImg.onload = function() {
                width = tmpImg.naturalWidth,
                height = tmpImg.naturalHeight;
				ratio =  Number(width/height).toFixed(2) ;
                $('#image').data('imageWidth', width);
                $('#image').data('imageHeight', height);
                $('#image').data('imageratio', ratio);

            }
        });

        $('#player_image').change(function() {

            $('#player_image').removeData('imageWidth');
            $('#player_image').removeData('imageHeight');
            $('#player_image').removeData('imageratio');

            var file = this.files[0];
            var tmpImg = new Image();

            tmpImg.src=window.URL.createObjectURL( file ); 
            tmpImg.onload = function() {
                width = tmpImg.naturalWidth,
                height = tmpImg.naturalHeight;
				ratio =  Number(width/height).toFixed(2) ;
                $('#player_image').data('imageWidth', width);
                $('#player_image').data('imageHeight', height);
                $('#player_image').data('imageratio', ratio);
            }
        });



        $("#Episode_edit").validate({
            rules: {
                title: { 
                    required: true, 
                },

                image: {
                    required: '#check_image:blank',
                    dimention:[1080,1920]
                },

                player_image: {
                    required: '#player_check_image:blank',
                    player_dimention:[1280,720]
                },

                intro_start_time: {
                    required: function(element){
                        if($('#skip_intro').val() !='' || $('#intro_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                    greaterThan:function(element){
                        if($('#skip_intro').val() !='' || $('#intro_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                },

                skip_intro: {
                    required: function(element){
                        if($('#intro_start_time').val() !='' || $('#intro_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                    Skipintro_greaterThan:function(element){
                        if($('#intro_start_time').val() !='' || $('#intro_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                },

                intro_end_time: {
                    required: function(element){
                        if($('#intro_start_time').val() !='' || $('#skip_intro').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                    Skipintro_greaterThan:function(element){
                        if($('#intro_start_time').val() !='' || $('#intro_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                },
                
                recap_start_time: {
                    required: function(element){
                        if($('#skip_recap').val() !='' || $('#recap_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                    RecapgreaterThan:function(element){
                        if($('#skip_recap').val() !='' || $('#recap_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                },

                skip_recap: {
                    required: function(element){
                        if($('#recap_start_time').val() !='' || $('#recap_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                    Recapintro_greaterThan:function(element){
                        if($('#recap_start_time').val() !='' || $('#recap_end_time').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                },
                recap_end_time: {
                    required: function(element){
                        if($('#recap_start_time').val() !='' || $('#skip_recap').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                    Recapintro_greaterThan:function(element){
                        if($('#recap_start_time').val() !='' || $('#skip_recap').val() !='' ){
                             return true;
                        } else {
                             return false;
                        }
                    },
                },
            },

            messages: {
                intro_start_time: "Please Enter the valid Intro Start Time,  Lesser than End Time",
                intro_end_time: "Please Enter the valid Intro End Time,  Greater than End Time",
                skip_intro: "Please Enter the valid Skip Intro Time,  Greater than End Time",

                recap_start_time: "Please Enter the valid Intro Start Time,  Lesser than End Time",
                recap_end_time: "Please Enter the valid Intro End Time,  Greater than End Time",
                skip_recap: "Please Enter the valid Skip Intro Time,  Greater than End Time",
        }
        });




        
        (function(){

"use strict"


// Plugin Constructor
var TagsInput = function(opts){
    this.options = Object.assign(TagsInput.defaults , opts);
    this.init();
}

// Initialize the plugin
TagsInput.prototype.init = function(opts){
    this.options = opts ? Object.assign(this.options, opts) : this.options;

    if(this.initialized)
        this.destroy();
        
    if(!(this.orignal_input = document.getElementById(this.options.selector)) ){
        console.error("tags-input couldn't find an element with the specified ID");
        return this;
    }

    this.arr = [];
    this.wrapper = document.createElement('div');
    this.input = document.createElement('input');
    init(this);
    initEvents(this);

    this.initialized =  true;
    return this;
}

// Add Tags
TagsInput.prototype.addTag = function(string){

    if(this.anyErrors(string))
        return ;

    this.arr.push(string);
    var tagInput = this;

    var tag = document.createElement('span');
    tag.className = this.options.tagClass;
    tag.innerText = string;

    var closeIcon = document.createElement('a');
    closeIcon.innerHTML = '&times;';
    
    // delete the tag when icon is clicked
    closeIcon.addEventListener('click' , function(e){
        e.preventDefault();
        var tag = this.parentNode;

        for(var i =0 ;i < tagInput.wrapper.childNodes.length ; i++){
            if(tagInput.wrapper.childNodes[i] == tag)
                tagInput.deleteTag(tag , i);
        }
    })


    tag.appendChild(closeIcon);
    this.wrapper.insertBefore(tag , this.input);
    this.orignal_input.value = this.arr.join(',');

    return this;
}

// Delete Tags
TagsInput.prototype.deleteTag = function(tag , i){
    tag.remove();
    this.arr.splice( i , 1);
    this.orignal_input.value =  this.arr.join(',');
    return this;
}

// Make sure input string have no error with the plugin
TagsInput.prototype.anyErrors = function(string){
    if( this.options.max != null && this.arr.length >= this.options.max ){
        console.log('max tags limit reached');
        return true;
    }
    
    if(!this.options.duplicate && this.arr.indexOf(string) != -1 ){
        console.log('duplicate found " '+string+' " ')
        return true;
    }

    return false;
}

// Add tags programmatically 
TagsInput.prototype.addData = function(array){
    var plugin = this;
    
    array.forEach(function(string){
        plugin.addTag(string);
    })
    return this;
}

// Get the Input String
TagsInput.prototype.getInputString = function(){
    return this.arr.join(',');
}


// destroy the plugin
TagsInput.prototype.destroy = function(){
    this.orignal_input.removeAttribute('hidden');

    delete this.orignal_input;
    var self = this;
    
    Object.keys(this).forEach(function(key){
        if(self[key] instanceof HTMLElement)
            self[key].remove();
        
        if(key != 'options')
            delete self[key];
    });

    this.initialized = false;
}

// Private function to initialize the tag input plugin
function init(tags){
    tags.wrapper.append(tags.input);
    tags.wrapper.classList.add(tags.options.wrapperClass);
    tags.orignal_input.setAttribute('hidden' , 'true');
    tags.orignal_input.parentNode.insertBefore(tags.wrapper , tags.orignal_input);
}

// initialize the Events
function initEvents(tags){
    tags.wrapper.addEventListener('click' ,function(){
        tags.input.focus();           
    });
    

    tags.input.addEventListener('keydown' , function(e){
        var str = tags.input.value.trim(); 

        if( !!(~[9 , 13 , 188].indexOf( e.keyCode ))  )
        {
            e.preventDefault();
            tags.input.value = "";
            if(str != "")
                tags.addTag(str);
        }

    });
}


// Set All the Default Values
TagsInput.defaults = {
    selector : '',
    wrapperClass : 'tags-input-wrapper',
    tagClass : 'tag',
    max : null,
    duplicate: false
}

window.TagsInput = TagsInput;

})();

var tagInput1 = new TagsInput({
        selector: 'tag-input1',
        duplicate : false,
        max : 10
    });

	
var tagsdata = '<?= $episodes->search_tags ?>';

    // tagInput1.addData([])
	if(tagsdata == ""){
// alert(tagsdata);
tagInput1.addData([])
        }else{
    tagInput1.addData(['<?= $episodes->search_tags ?>'])
            // tagInput1.addData([])
        }

		

        function EmbedCopy() {
   // var media_path = $('#media_url').val();
   var media_path = '<?= $url_path ?>';
   var url =  navigator.clipboard.writeText(window.location.href);
   var path =  navigator.clipboard.writeText(media_path);
   $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied Embed URL</div>');
              setTimeout(function() {
               $('.add_watch').slideUp('fast');
              }, 3000);
   // console.log(url);
   // console.log(media_path);
   // console.log(path);
   }
        </script>
        @stop @stop @stop
    </div>
</div>
