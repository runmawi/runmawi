@extends('admin.master')

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('dropzone/dist/min/dropzone.min.css')}}">

    <!-- JS -->
    <script src="{{asset('dropzone/dist/min/dropzone.min.js')}}" type="text/javascript"></script>
@section('content')
<style>
    #optionradio {color: #000;}
    #video_upload {margin-top: 5%;}
   .file {
        padding: 30;
        background: rgba(56, 87, 127, 0.34);
        border-radius: 10px;
        text-align: center;
        margin: 0 auto;
        width: 75%;
    }
    #video_upload .file form{border: 2px dashed;}
    #video_upload .file form i {display: block; font-size: 50px;}
</style>

<div id="content-page content_videopage" class="content-page">
    <div class="container-fluid" id="content_videopage">
        <div class="admin-section-title">
            <div class="iq-card">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="entypo-archive"></i> Add Video </h4>
                    </div>
                                        @if (Session::has('message'))
                       <div id="successMessage" class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif
                        @if(count($errors) > 0)
                        @foreach( $errors->all() as $message )
                        <div class="alert alert-danger display-hide" id="successMessage" >
                        <button id="successMessage" class="close" data-close="alert"></button>
                        <span>{{ $message }}</span>
                        </div>
                        @endforeach
                        @endif
                    <div class="col-md-8" align="right">
                        <div id="optionradio"  >
                                <input type="radio" class="text-black" value="videoupload" id="videoupload" name="videofile" checked="checked"> Video Upload &nbsp;&nbsp;&nbsp;
                                <input type="radio" class="text-black" value="m3u8"  id="m3u8" name="videofile">m3u8 Url &nbsp;&nbsp;&nbsp;
                                <input type="radio" class="text-black" value="videomp4"  id="videomp4" name="videofile"> Video mp4 &nbsp;&nbsp;&nbsp;
                                <input type="radio" class="text-black" value="embed_video"  id="embed_video" name="videofile"> Embed Code              
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div class="col-md-12">
                            <!-- M3u8 Video --> 
                            <div id="m3u8_url" style="">
                                <div class="new-audio-file mt-3">
                                    <label for="embed_code"><label>m3u8 URL:</label></label>
                                    <input type="text" class="form-control" name="m3u8_video_url" id="m3u8_video_url" value="" />
                                </div>
                            </div> 
                            <!-- Embedded Video -->        
                            <div id="embedvideo" style="">
                                <div class="new-audio-file mt-3">
                                    <label for="embed_code"><label>Embed URL:</label></label>
                                    <input type="text" class="form-control" name="embed_code" id="embed_code" value="" />
                                </div>
                            </div> 

                            <!-- MP4 Video -->        
                            <div id="video_mp4" style="">
                                <div class="new-audio-file mt-3" >
                                    <label for="mp4_url"><label>Mp4 File URL:</label></label>
                                    <input type="text" class="form-control" name="mp4_url" id="mp4_url" value="" />
                                </div>
                            </div> 

                            <!-- Video upload -->        
                            <div id="video_upload" style="">
                            <div class='content file'>
                                    <h4 class="card-title">Upload Full Video Here</h4>
                                    <!-- Dropzone -->
                                    <form action="{{URL::to('admin/uploadFile')}}" method= "post" class='dropzone' ></form> 
                                </div> 
                            <p style="margin-top: -3%;margin-left: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Trailers Can Be Uploaded From Video Edit Screen</p>
                                
                            </div> 
   
                            <div class="text-center" style="margin-top: 30px;">
                                <input type="button" id="Next" value='Proceed to Next Step' class='btn btn-primary'>
                            </div>
                            <input type="hidden" id="embed_url" value="<?php echo URL::to('/admin/embededcode');?>">
                            <input type="hidden" id="mp4url" value="<?php echo URL::to('/admin/mp4url');?>">
                            <input type="hidden" id="m3u8url" value="<?php echo URL::to('/admin/m3u8url');?>">
                        </div>
                    <hr />
                </div>
            </div>
        </div>
                </div>
            </div>
         </div>
    </div>
 </div>
 </div>
</div>
<div id="video_details">

<style>

    .p1{
        font-size: 12px;
    }
    .select2-selection__rendered{
        background-color: #f7f7f7!important;
        border: none!important;
    }
    .select2-container--default .select2-selection--multiple{
        border: none!important;
    }
    #video{
        background-color: #f7f7f7!important;
    }
</style>
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="http://malsup.github.com/jquery.form.js"></script>

        <div id="content-page" class="content-page1">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div >
                            <div class="iq-header-title">
                                <h4 class="card-title">Add Video</h4>
                            </div>
                          
<!-- multistep form -->
<form id="msform">
	<!-- progressbar -->
	<ul id="progressbar">
		<li class="active"></li>
		<li></li>
		<li></li>
<li></li>
<li></li>
<li></li>
<li></li>
<li></li>
<li></li>
<li></li>
	</ul>
	<!-- fieldsets -->
	<fieldset>
		<h2 class="fs-title">Question 1</h2>
		<h3 class="fs-subtitle">What do you consider your main strengths to be?</h3>
    <!--<p class="help-block">List your strengths here.</p>-->
    <textarea class="form-control" name="CAT_Custom_1" id="CAT_Custom_1" rows="4" onkeydown="if(this.value.length>=4000)this.value=this.value.substring(0,3999);"></textarea>
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>
	<fieldset>
		<h2 class="fs-title">Question 2</h2>
		<h3 class="fs-subtitle">What do your colleagues consider your main strengths to be?</h3>
<textarea class="form-control" name="CAT_Custom_2" id="CAT_Custom_2" rows="4" onkeydown="if(this.value.length>=4000)this.value=this.value.substring(0,3999);"></textarea>
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>
	<fieldset>
		<h2 class="fs-title">Question 3</h2>
		<h3 class="fs-subtitle">What have been your main achievements?</h3>
<textarea class="form-control" name="CAT_Custom_3" id="CAT_Custom_3" rows="4" onkeydown="if(this.value.length>=4000)this.value=this.value.substring(0,3999);"></textarea>
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>
	<fieldset>
		<h2 class="fs-title">Question 4</h2>
		<h3 class="fs-subtitle">What do you consider your main weaknesses to be?</h3>
<textarea class="form-control" name="CAT_Custom_4" id="CAT_Custom_4" rows="4" onkeydown="if(this.value.length>=4000)this.value=this.value.substring(0,3999);"></textarea>
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="button" name="next" class="next action-button" value="Next" />
</fieldset>
	<fieldset>
		<h2 class="fs-title">Question 5</h2>
		<h3 class="fs-subtitle">What do your colleagues consider your main weaknesses to be?</h3>
<textarea class="form-control" name="CAT_Custom_5" id="CAT_Custom_5" rows="4" onkeydown="if(this.value.length>=4000)this.value=this.value.substring(0,3999);"></textarea>
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>
	<fieldset>
		<h2 class="fs-title">Question 6</h2>
		<h3 class="fs-subtitle">In what areas would you like to improve your clinical skills?</h3>
<textarea class="form-control" name="CAT_Custom_6" id="CAT_Custom_6" rows="4" onkeydown="if(this.value.length>=4000)this.value=this.value.substring(0,3999);"></textarea>
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>
	<fieldset>
		<h2 class="fs-title">Question 7</h2>
		<h3 class="fs-subtitle">In what areas would you like to improve your non-clinical skills?</h3>
<textarea class="form-control" name="CAT_Custom_7" id="CAT_Custom_7" rows="4" onkeydown="if(this.value.length>=4000)this.value=this.value.substring(0,3999);"></textarea>
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>
	<fieldset>
		<h2 class="fs-title">Question 8</h2>
		<h3 class="fs-subtitle">Are there any specific areas of compliance training that you need to complete?</h3>
<textarea class="form-control" name="CAT_Custom_8" id="CAT_Custom_8" rows="4" onkeydown="if(this.value.length>=4000)this.value=this.value.substring(0,3999);"></textarea>
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>
	<fieldset>
		<h2 class="fs-title">Question 9</h2>
		<h3 class="fs-subtitle">What postgraduate qualifications do you hold?</h3>
<textarea class="form-control" name="CAT_Custom_9" id="CAT_Custom_9" rows="4" onkeydown="if(this.value.length>=4000)this.value=this.value.substring(0,3999);"></textarea>
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>
	<fieldset>
		<h2 class="fs-title">Question 10</h2>
		<h3 class="fs-subtitle">What postgraduate qualifications or training do you wish to obtain?</h3>
<textarea class="form-control" name="CAT_Custom_10" id="CAT_Custom_10" rows="4" onkeydown="if(this.value.length>=4000)this.value=this.value.substring(0,3999);"></textarea>
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="submit" name="submit" class="submit action-button" value="Submit" />
	</fieldset>
</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<!-- jQuery easing plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js" type="text/javascript"></script>
<style>
    /*custom font*/
@import url(https://fonts.googleapis.com/css?family=Open+Sans);

@primary-color: #63a2cb;
@secondary-color: #67d5bf;
/*basic reset*/
* {margin: 0; padding: 0;}

html {
	height: 100%;
	background: #0e0e0e;
}

body {
	font-family: "Open Sans", arial, verdana;
}
/*form styles*/
#msform {
	width: 600px;
	/* margin: 50px auto; */
	text-align: center;
	/* position: relative; */
}
#msform fieldset {
	background: white;
	border: 0 none;
	border-radius: 3px;
	box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
	padding: 20px 30px;
	left: -49%;
	box-sizing: border-box;
	width: 160%;
	margin: 0 10%;
	
	/*stacking fieldsets above each other*/
	/* position: absolute; */
}
/*Hide all except first fieldset*/
#msform fieldset:not(:first-of-type) {
	display: none;
}
/*inputs*/
#msform input, #msform textarea {
	padding: 15px;
	border: 1px solid #ccc;
	border-radius: 3px;
	margin-bottom: 10px;
	width: 100%;
	box-sizing: border-box;
	font-family: montserrat;
	color: #2C3E50;
	font-size: 13px;
}
/*buttons*/
#msform .action-button {
	width: 100px;
	background: @secondary-color;
	font-weight: bold;
	color: white;
	border: 0 none;
	border-radius: 1px;
	cursor: pointer;
	padding: 10px 5px;
	margin: 10px 5px;
}
#msform .action-button:hover, #msform .action-button:focus {
	box-shadow: 0 0 0 2px white, 0 0 0 3px @secondary-color;
}
/*headings*/
.fs-title {
	font-size: 16px;
	text-transform: uppercase;
	color: @primary-color;
	margin-bottom: 10px;
}
.fs-subtitle {
	font-weight: normal;
	font-size: 14px;
	color: #666;
	margin-bottom: 20px;
}
/*progressbar*/
#progressbar {
	margin-bottom: 30px;
	overflow: hidden;
	/*CSS counters to number the steps*/
	counter-reset: step;
}
#progressbar li {
	list-style-type: none;
	color: white;
	text-transform: uppercase;
	font-size: 9px;
	width: 10%;
	float: left;
	position: relative;
}
#progressbar li:before {
	content: counter(step);
	counter-increment: step;
	width: 20px;
	line-height: 20px;
	display: block;
	font-size: 10px;
	color: #333;
	background: white;
	border-radius: 3px;
	margin: 0 auto 5px auto;
}
/*progressbar connectors*/
#progressbar li:after {
	content: '';
	width: 100%;
	height: 2px;
	background: white;
	position: absolute;
	left: -50%;
	top: 9px;
	z-index: -1; /*put it behind the numbers*/
}
#progressbar li:first-child:after {
	/*connector not needed before the first step*/
	content: none; 
}
/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
#progressbar li.active:before,  #progressbar li.active:after{
	background: @secondary-color;
	color: white;
}

.help-block {
  font-size: .8em;
  color: #7c7c7c;
  text-align: left;
  margin-bottom: .5em;
}
</style>
<script>
    //jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
	
	//show the next fieldset
	next_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'transform': 'scale('+scale+')'});
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 500, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeOutQuint'
	});
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 500, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeOutQuint'
	});
});

$(".submit").click(function(){
	return false;
})
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
   
$(document).ready(function(){
	$('#video_upload').show();
	$('#video_mp4').hide();
	$('#embedvideo').hide();
	$('#m3u8_url').hide();



$('#videoupload').click(function(){
	$('#video_upload').show();
	$('#video_mp4').hide();
	$('#embedvideo').hide();
	$('#m3u8_url').hide();

	$("#video_upload").addClass('collapse');
	$("#video_mp4").removeClass('collapse');
	$("#embed_video").removeClass('collapse');
	$("#m3u8").removeClass('m3u8');


})
$('#videomp4').click(function(){
	$('#video_upload').hide();
	$('#video_mp4').show();
	$('#embedvideo').hide();
	$('#m3u8_url').hide();

	$("#video_upload").removeClass('collapse');
	$("#video_mp4").addClass('collapse');
	$("#embed_video").removeClass('collapse');
	$("#m3u8").removeClass('m3u8');


})
$('#embed_video').click(function(){
	$('#video_upload').hide();
	$('#video_mp4').hide();
	$('#embedvideo').show();
	$('#m3u8_url').hide();

	$("#video_upload").removeClass('collapse');
	$("#video_mp4").removeClass('collapse');
	$("#embed_video").addClass('collapse');
	$("#m3u8").removeClass('m3u8');


})
$('#m3u8').click(function(){
	$('#video_upload').hide();
	$('#video_mp4').hide();
	$('#embedvideo').hide();
	$('#m3u8_url').show();
	$("#video_upload").removeClass('collapse');
	$("#video_mp4").removeClass('collapse');
	$("#embed_video").removeClass('collapse');
	$("#m3u8").addClass('m3u8');


})
});




</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   
   <script>
 $.ajaxSetup({
            headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
     });
 
 
     $(document).ready(function(){
 
 var url =$('#m3u8url').val();
 $('#m3u8_video_url').change(function(){
     // alert($('#m3u8_video_url').val());
     $.ajax({
         url: url,
         type: "post",
 data: {
                _token: '{{ csrf_token() }}',
                m3u8_url: $('#m3u8_video_url').val()
 
          },        success: function(value){
             console.log(value);
             $('#Next').show();
            $('#video_id').val(value.video_id);
 
         }
     });
 })
 
 });
     
 </script>
 <script>
 $.ajaxSetup({
    headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
 });
 
 
 $(document).ready(function(){
     var url =$('#mp4url').val();
     $('#mp4_url').change(function(){
     // alert($('#mp4_url').val());
     $.ajax({
         url: url,
         type: "post",
     data: {
                _token: '{{ csrf_token() }}',
                mp4_url: $('#mp4_url').val()
 
          },        success: function(value){
             console.log(value);
             $('#Next').show();
            $('#video_id').val(value.video_id);
 
         }
         });
     })
 
 });
 </script>
 
 <script>
 $.ajaxSetup({
            headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
     });
 
 
     $(document).ready(function(){
 
 var url =$('#embed_url').val();
 $('#embed_code').change(function(){
     // alert($('#embed_code').val());
     $.ajax({
         url: url,
         type: "post",
 data: {
                _token: '{{ csrf_token() }}',
                embed: $('#embed_code').val()
 
          },        success: function(value){
             console.log(value);
             $('#Next').show();
            $('#video_id').val(value.video_id);
 
         }
     });
 })
 
 });
     // http://localhost/flicknexs/public/uploads/audios/23.mp3
 </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>                       
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>

<script>
    $('#intro_start_time').datetimepicker(
    {
        format: 'hh:mm '
    });
    $('#intro_end_time').datetimepicker(
    {
        format: 'hh:mm '
    });
    $('#recap_start_time').datetimepicker(
    {
        format: 'hh:mm '
    });
    $('#recap_end_time').datetimepicker(
    {
        format: 'hh:mm '
    });
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>


<script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script type="text/javascript">
$ = jQuery;

$(document).ready(function($){

$('#duration').mask("00:00:00");

});

$('#publishlater').hide();

$(document).ready(function(){
// $('#duration').mask('00:00:00');

$('#publish_now').click(function(){
    // alert($('#publish_now').val());
    $('#publishlater').hide();
});
$('#publish_later').click(function(){
    // alert($('#publish_later').val());
    $('#publishlater').show();
});

if($("#publish_now").val() == 'publish_now'){
$('#publishlater').show();
}else if($("#publish_later").val() == 'publish_later'){
    $('#publishlater').hide();		
}
});





$('#remove').hide();

$(document).ready(function(){
$('#trailer').change(function(){
var remove = $('#trailer').val();
// alert(remove)
if(remove != ""){
$('#remove').show();
}else{
$('#remove').hide();
}     
$('#remove').click(function(){ 
$('#trailer').val("");
$('#remove').hide();
});

});
});

$(document).ready(function(){
$('#ppv_price').hide();
$('#global_ppv_status').hide();

    $("#access").change(function(){
        if($(this).val() == 'ppv'){
            $('#ppv_price').show();
            $('#global_ppv_status').show();

        }else{
            $('#ppv_price').hide();		
            $('#global_ppv_status').hide();				

        }
    });
});

// $(document).ready(function(){
//     $('#global_ppv_status').hide();
// 		$("#access").change(function(){
// 			if($(this).val() == 'ppv'){
// 				$('#global_ppv_status').show();

// 			}else{
// 				$('#global_ppv_status').hide();				
// 			}
// 		});
// });





$(document).ready(function(){
$('.js-example-basic-multiple').select2();
$('.js-example-basic-single').select2();

    $("#type").change(function(){
        if($(this).val() == 'file'){
            $('.new-video-file').show();
            $('.new-video-embed').show();

        } else if($(this).val() == 'embed'){ 
            $('.new-video-file').hide();
            $('.new-video-embed').show();

        }else{
            $('.new-video-file').hide();
            $('.new-video-embed').hide();
            
        }
    });


    tinymce.init({
        relative_urls: false,
        selector: '#details',
        toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor | code",
        plugins: [
             "advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen",
             "save table contextmenu directionality emoticons template paste textcolor code"
       ],
       menubar:false,
     });

});



function NumAndTwoDecimals(e , field) {
//    alert(); 
    var val = field.value;
    var re = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)$/g;
    var re1 = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)/g;
    if (re.test(val)) {
       if(val > 10){
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

<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script>
CKEDITOR.replace( 'summary-ckeditor', {
filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
filebrowserUploadMethod: 'form'
});
</script>

<script>

$('input[type="checkbox"]').on('change', function(){
 this.value = this.checked ? 1 : 0;
}).change();
</script>



    </div>

</div>

<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">

<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script>
CKEDITOR.replace( 'summary-ckeditor', {
    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
    filebrowserUploadMethod: 'form'
});
</script>






<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

$('#Next').hide();
$('#video_details').show();

$('#video_upload').hide();
$('#video_mp4').hide();
$('#embedvideo').hide();
$('#optionradio').hide();
$('.content_videopage').hide();
$('#content_videopage').hide();


$('#Next').hide();


Dropzone.autoDiscover = false;
var myDropzone = new Dropzone(".dropzone",{ 
  //   maxFilesize: 900,  // 3 mb
    maxFilesize: 500,
    acceptedFiles: "video/mp4,video/x-m4v,video/*",
});
myDropzone.on("sending", function(file, xhr, formData) {
   formData.append("_token", CSRF_TOKEN);
  // console.log(value)
  this.on("success", function(file, value) {
        console.log(value.video_title);
        $('#Next').show();
       $('#video_id').val(value.video_id);
       $('#title').val(value.video_title);

       
    });

}); 



$('#Next').click(function(){
$('#video_upload').hide();
$('#video_mp4').hide();
$('#embedvideo').hide();
$('#optionradio').hide();
$('.content_videopage').hide();
$('#content_videopage').hide();


$('#Next').hide();
$('#video_details').show();

});
</script>
<script>
$(document).ready(function(){
    // $('#message').fadeOut(120);
    setTimeout(function() {
        $('#successMessage').fadeOut('fast');
    }, 3000);
})
</script>

@section('javascript')

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
$('form[id="video_form"]').validate({
ignore: [],
rules: {
  title : 'required',
  image : 'required',
  trailer : 'required',
//   video_country : 'required',
  'video_category_id[]': {
            required: true
        }
},
messages: {
  title: 'This field is required',
  image: 'This field is required',
  trailer : 'This field is required',
//   video_country : 'This field is required',
  video_category_id: {
            required: 'This field is required',
        }
},
submitHandler: function(form) {
  form.submit();
}
});

</script>
@stop