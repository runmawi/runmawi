@extends('admin.master')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop
 
    <style>
        span{
            color: gray;
        }
        .progress { position:relative; width:100%; }
        .bar { background-color: #008000; width:0%; height:20px; }
         .percent { position:absolute; display:inline-block; left:50%; color: #7F98B2;}
        [data-tip] {
	position:relative;

}
        .subtitle1{
            display: flex;
            justify-content: space-between;
            width: 50%;
        }
[data-tip]:before {
	content:'';
	/* hides the tooltip when not hovered */
	display:none;
	content:'';
	border-left: 5px solid transparent;
	border-right: 5px solid transparent;
	border-bottom: 5px solid #1a1a1a;	
	position:absolute;
	
	z-index:8;
	font-size:0;
	line-height:0;
	width:0;
	height:0;
}
[data-tip]:after {
	display:none;
	content:attr(data-tip);
	position:absolute;
	
	padding:5px 8px;
	background:#1a1a1a;
	color:#fff;
	z-index:9;
	font-size: 0.75em;
	height:18px;
	line-height:18px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	white-space:nowrap;
	word-wrap:normal;
}
[data-tip]:hover:before,
[data-tip]:hover:after {
	display:block;
}
   </style>

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="http://malsup.github.com/jquery.form.js"></script>
   
 <div id="content-page" class="content-page">
         <div class="container-fluid">
            <div class="row">
               <div class="col-sm-12">
                  <div class="iq-card">
                     <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Add Video</h4>
                        </div>
                     </div>
                     <div class="iq-card-body">
                         <h5>Video Info Details</h5>
                        <form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="row">
                                    <div class="col-sm-6 form-group" >
                                        <label class="p-2">Title :</label>
                                       <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="@if(!empty($video->title)){{ $video->title }}@endif">
                                    </div>
                                    <div class="col-sm-6 form-group" >
                                         <label class="p-2">
                                             Video Slug <a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="Please enter the name of the video again here" data-original-title="this is the tooltip" href="#">
                                             <i class="las la-exclamation-circle"></i></a>:</label>
                                       <input type="text"   class="form-control" name="slug" id="slug" placeholder="Video Slug" value="@if(!empty($video->slug)){{ $video->slug }}@endif">
                                    </div>
                                    
                                     <div class="col-sm-6 form-group" >
                                       <label class="p-2">Select Video Category :</label>
                                       <select class="form-control" id="video_category_id" name="video_category_id">
						                        @foreach($video_categories as $category)
                                          <option value="{{ $category->id }}" @if(!empty($video->video_category_id) && $video->video_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
						                        @endforeach

                                       </select>
                                                                          </div>
                                           <div class="col-sm-6 form-group" >                               
                                          <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
                                      <div class="panel-title">Cast and Crew </div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                                      <div class="panel-body" style="display: block;"> 
                                        <p>Add artists for the video below:</p> 
                                        <select name="artists[]" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                                          @foreach($artists as $artist)
                                          @if(in_array($artist->id, $video_artist))
                                          <option value="{{ $artist->id }}" selected="true">{{ $artist->artist_name }}</option>
                                          @else
                                          <option value="{{ $artist->id }}">{{ $artist->artist_name }}</option>
                                          @endif 
                                          @endforeach
                                        </select>

                                      </div> 
                                    </div>
                                    </div>
                                    
                                      <div class="col-sm-6 form-group">
                                  <label class="p-2">Choose Language:</label>
                                 <select class="form-control" id="language" name="language">
                                    <option selected disabled="">Choose Language</option>
                                    @foreach($languages as $language)
							                  <option value="{{ $language->id }}" @if(!empty($video->language) && $video->language == $language->id)selected="selected"@endif>{{ $language->name }}</option>
						                  @endforeach
                              </select>
                              </div>   
                                     
                                 <div class="col-sm-12 form-group">
                                     
                                      <label>Thumbnail <span>(16:9 Ratio or 1280X720px)</span></label><br>
                                     <input type="file" accept="video/mp4,video/x-m4v,video/*" name="image" id="image" >
                                  
                                     @if(!empty($video->image))
                                       <img src="{{ URL::to('/') . '/public/uploads/images/' . $video->image }}" class="video-img" width="200" height="200"/>
                                    @endif
                                 </div>
                                   <!-- <div class="col-md-6 form-group">
                                       <select class="form-control" id="video_category_id" name="video_category_id">
                                       <option value="0">Uncategorized</option>
						                        @foreach($video_categories as $category)
                                          <option value="{{ $category->id }}" @if(!empty($video->video_category_id) && $video->video_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
						                        @endforeach

                                       </select>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                          <select id="type" name="type" class="form-control" required>
                                             <option>--Select Video Type--</option>
                                             <option value="file" @if(!empty($video->type) && $video->type == 'file'){{ 'selected' }}@endif>Video File</option>
                                             <option value="embed" @if(!empty($video->type) && $video->type == 'embed'){{ 'selected' }}@endif >Embed Code</option>
                                          </select>   
                                    </div>-->
                                     
                                    <div class="col-lg-12 form-group">
                                        <h5>Video description:</h5>
                                       <textarea  rows="5" class="form-control" name="description" id="summary-ckeditor"
                                          placeholder="Description">@if(!empty($video->description)){{ strip_tags($video->description) }}@endif</textarea>
                                    </div>
                                    <div class="col-12 form-group">
                                       <textarea   rows="5" class="form-control" name="details" 
                                          placeholder="Link , and details">@if(!empty($video->details)){{ htmlspecialchars($video->details) }}@endif</textarea>
                                    </div>
                                 </div>
                              </div>
                              
                            
                           </div>
                            <div>
                                <h5>Video Upload</h5>
                            </div>
                            <div class="row ">
                             <div class="col-sm-8 form-group">
                             @if(!empty($video->trailer) && $video->trailer != '')
                              <video width="200" height="200" controls>
                                    <source src="{{ $video->trailer }}" type="video/mp4">
                              </video>
                              @endif
                                 <label class="p-2">Upload Trailer :</label><br>
                               <div style="margin-left: 57%;margin-top: -4%;"class="form_video-upload" @if(!empty($video->type) && $video->type == 'upload') style="display:none" @else style="display:block" @endif>
                                 <input type="file" accept="video/mp4,video/x-m4v,video/*" name="trailer" id="trailer" >
                                       <!--<p>Upload Trailer video</p>-->
                                       <p style="font-size: 14px!important;">Drop and drag the video file</p>
                                    </div>
                                    </div>
                                    <br>
                                  <div class="col-sm-6 form-group">
                                  @if(!empty($video->path) && $video->path != '')
                              <video width="200" height="200" controls>
                              <source src="{{ URL::to('/storage/app/public/'.$video->path) }}" type="video/mp4">
                                    <!-- <source src="{{ $video->path }}" type="video/mp4"> -->
                              </video>
                              @endif
                                         <label><h5>Video Type :</h5></label>
                                          <select id="type" name="type" class="form-control" required>
                                             <option>--Video Type--</option>
                                             <option value="file" @if(!empty($video->type) && $video->type == 'file'){{ 'selected' }}@endif>Video File</option>
                                             <option value="embed" @if(!empty($video->type) && $video->type == 'embed'){{ 'selected' }}@endif >Embed Code</option>
                                          </select>   
                                      </div>
                              <div class="">
                                  
                                 @if(!empty($video->type) && ($video->type == 'upload' || $video->type == 'file'))
                                    <video width="200" height="200" controls>
                                    <source src="{{ URL::to('/storage/app/public/').'/'.$video->mp4_url }}" type="video/mp4">
                                    </video>
                                 @endif
                                 <div class="d-block position-relative" style="left:80px;top:-50px;">
                                 <div class="new-video-embed" @if(!empty($video->type) && $video->type == 'embed')@else  @endif>
                                    <label for="embed_code">Embed Code:</label>
                                    <textarea class="form-control" name="embed_code" id="embed_code">@if(!empty($video->embed_code)){{ $video->embed_code }}@endif</textarea>
                                 </div>

                                 <div class="new-video-file form_video-upload" @if(!empty($video->type) && $video->type == 'upload') style="display:none" @else  @endif>
                                  
                                    <input type="file" accept="video/mp4,video/x-m4v,video/*" name="video" id="video">
                                    <p>Upload video</p>
                                 </div>
                                    
                                 </div>
                              </div>      
 
                              </div>
                                
                               
                              <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
        <div class="panel-title">Subtitles (srt or txt)<a class="iq-bg-warning" data-toggle="tooltip" data-placement="top" title="Please choose language" data-original-title="this is the tooltip" href="#">
                                             <i class="las la-exclamation-circle"></i></a>:</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
        <div class="panel-body" style="display: block;"> 
          @foreach($subtitles as $subtitle)
          <div class="subtitle1" style="clear: both;" >
            <label for="embed_code"  style="">Upload Subtitle {{ $subtitle->language }}</label>
            <input type="file" name="subtitle_upload[]" id="subtitle_upload_{{ $subtitle->short_code }}">
            <input type="hidden" name="short_code[]" value="{{ $subtitle->short_code }}">
            <input type="hidden" name="sub_language[]" value="{{ $subtitle->language }}">
          </div>
          @endforeach
          
        </div> 
      </div>

         <div class="row">
                              <!--<div class="col-sm-6 form-group">
                                  <label class="p-2">Choose Language:</label>
                                 <select class="form-control" id="language" name="language">
                                    <option selected disabled="">Choose Language</option>
                                    @foreach($languages as $language)
							                  <option value="{{ $language->id }}" @if(!empty($video->language) && $video->language == $language->id)selected="selected"@endif>{{ $language->name }}</option>
						                  @endforeach
                              </select>
                              </div> -->  
                              <div class="col-sm-6 form-group">
                                 <!-- <label class="p-2">Subscriber (only paid subscription users):</label>
                              <select id="access" name="access"  class="form-control" >
                                <option value="subscriber" @if(!empty($video->access) && $video->access == 'subscriber'){{ 'selected' }}@endif>Subscriber (only paid subscription users)</option>
                                 <option value="guest" @if(!empty($video->access) && $video->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option>
                                 <option value="registered" @if(!empty($video->access) && $video->access == 'registered'){{ 'selected' }}@endif>Registered Users (free registration must be enabled)</option>   
                              </select>-->
                                   <label class="">Video Duration:</label>
                                   <input type="text" class="form-control" placeholder="Video Duration" name="duration" id="duration" value="@if(!empty($video->duration)){{ gmdate('H:i:s', $video->duration) }}@endif">
                              </div> 
             <div class="col-sm-6 form-group">
                  <label class="">Year:</label>
                                  <input type="text" class="form-control" placeholder="Release Year" name="year" id="year" value="@if(!empty($video->year)){{ $video->year }}@endif">
             </div>
                                
                        </div>

             <div class="row">
                              <div class="col-sm-6 form-group">
                                 <!-- <label class="p-2">Year:</label>
                                  <input type="text" class="form-control" placeholder="Release Year" name="year" id="year" value="@if(!empty($video->year)){{ $video->year }}@endif">-->
                                  <label class="">Movie Language:</label>
                                 <select class="form-control" id="language" name="language">
                                    <option selected disabled="">Choose Language</option>
                                    @foreach($languages as $language)
							                  <option value="{{ $language->id }}" @if(!empty($video->language) && $video->language == $language->id)selected="selected"@endif>{{ $language->name }}</option>
						                  @endforeach
                              </select>
                              </div>
                          <div class="col-sm-6 form-group">
                              <label class="">Rating:</label>
                                  <input type="text" class="form-control" placeholder="Movie Ratings" name="rating" id="rating" value="@if(!empty($video->rating)){{ $video->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);">
                              </div>
                              </div>
                             
                         <div class="row">
                             <!-- <div class="col-sm-6 form-group">
                                   <label class="p-2">Rating:</label>
                                  <input type="text" class="form-control" placeholder="Movie Ratings" name="rating" id="rating" value="@if(!empty($video->rating)){{ $video->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);">
                              </div>-->
                             <div class="col-sm-6"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"> Status Settings</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<div>
								<label for="featured">Is this video Featured:</label>
								<input type="checkbox" @if(!empty($video->featured) && $video->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
							</div>
							<div class="clear"></div>
							<div>
								<label for="active">Is this video Active:</label>
								<input type="checkbox" @if(!empty($video->active) && $video->active == 1){{ 'checked="checked"' }}@elseif(!isset($video->active)){{ 'checked="checked"' }}@endif name="active" value="1" id="active" />
							</div>
							<div class="clear"></div>
							
						</div> 
					</div>
				</div>
                             </div>
                            
                              @if(isset($video->id))
                                 <input type="hidden" id="id" name="id" value="{{ $video->id }}" />
                              @endif

                              <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                              <div class="col-12 form-group ">
                                 <button type="submit" class="btn btn-primary" value="{{ $button_text }}">{{ $button_text }}</button>
                                 <button type="reset" class="btn btn-danger">cancel</button>
                              </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

	<input type="hidden" id="base_url" value="<?php echo URL::to('/');?>">
	
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script type="text/javascript">
 $ = jQuery;
	$(document).ready(function(){
    $('.js-example-basic-multiple').select2();
    
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
       alert(); 
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

@section('javascript')
	@stop

@stop
