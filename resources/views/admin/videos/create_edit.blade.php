@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.css') }}" />
@stop
 
    <style>
        .progress { position:relative; width:100%; }
        .bar { background-color: #008000; width:0%; height:20px; }
         .percent { position:absolute; display:inline-block; left:50%; color: #7F98B2;}
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
                        <form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                           <div class="row">
                              <div class="col-lg-7">
                                 <div class="row">
                                    <div class="col-12 form-group">
                                       <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="@if(!empty($video->title)){{ $video->title }}@endif">
                                    </div>
                                    <div class="col-12 form-group">
                                       <input type="text" class="form-control" name="slug" id="slug" placeholder="Video Slug" value="@if(!empty($video->slug)){{ $video->slug }}@endif">
                                    </div>
                                 <div class="col-sm-12 form-group">
                                     <input type="file" accept="video/mp4,video/x-m4v,video/*" name="image" id="image" >
                                     <p>Upload Thumnail</p>
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
                                     
                                    <div class="col-12 form-group">
                                       <textarea  rows="5" class="form-control" name="description" id="summary-ckeditor"
                                          placeholder="Description">@if(!empty($video->description)){{ strip_tags($video->description) }}@endif</textarea>
                                    </div>
                                    <div class="col-12 form-group">
                                       <textarea   rows="5" class="form-control" name="details" 
                                          placeholder="Link , and details">@if(!empty($video->details)){{ htmlspecialchars($video->details) }}@endif</textarea>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-lg-5">
                                  <div class="row">
                                   <div class="col-md-6 form-group">
                                       <select class="form-control" id="video_category_id" name="video_category_id">
                                       <option value="0">Uncategorized</option>
						                        @foreach($video_categories as $category)
                                          <option value="{{ $category->id }}" @if(!empty($video->video_category_id) && $video->video_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
						                        @endforeach

                                       </select>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                          <select id="type" name="type" class="form-control" required>
                                             <option>--Video Type--</option>
                                             <option value="file" @if(!empty($video->type) && $video->type == 'file'){{ 'selected' }}@endif>Video File</option>
                                             <option value="embed" @if(!empty($video->type) && $video->type == 'embed'){{ 'selected' }}@endif >Embed Code</option>
                                          </select>   
                                      </div></div>
                                 @if(!empty($video->type) && ($video->type == 'upload' || $video->type == 'file'))
                                    <video width="200" height="200" controls>
                                    <source src="{{ URL::to('/storage/app/public/').'/'.$video->mp4_url }}" type="video/mp4">
                                    </video>
                                 @endif
                                 <div class="d-block position-relative">
                                 <div class="new-video-embed" @if(!empty($video->type) && $video->type == 'embed')style="display:block"@else style = "display:none" @endif>
                                    <label for="embed_code">Embed Code:</label>
                                    <textarea class="form-control" name="embed_code" id="embed_code">@if(!empty($video->embed_code)){{ $video->embed_code }}@endif</textarea>
                                 </div>

                                 <div class="new-video-file form_video-upload" @if(!empty($video->type) && $video->type == 'upload')style="display:block"@else style = "display:none" @endif>
                                    <!-- <label for="embed_code">Upload Video</label>
                                    <input type="file" name="video" id="video"> -->
                                    <input type="file" accept="video/mp4,video/x-m4v,video/*" name="video" id="video">
                                    <p>Upload video</p>
                                 </div>
                                    <!-- <div class="form_video-upload" class="new-video-file" >
                                       <input type="file" accept="video/mp4,video/x-m4v,video/*" name="video" id="video">
                                       <p>Upload video</p>
                                       
                                    </div>
                                     -->
                                 </div>
                              </div>
                            
                           </div>
                             <div class="col-sm-12 form-group">
                             @if(!empty($video->trailer) && $video->trailer != '')
                              <video width="200" height="200" controls>
                                    <source src="{{ $video->trailer }}" type="video/mp4">
                              </video>
                              @endif
                                 <input type="file" accept="video/mp4,video/x-m4v,video/*" name="trailer" id="trailer" >
                                       <p>Upload Trailer video</p>
                              </div>
                              <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
        <div class="panel-title">Subtitles</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
        <div class="panel-body" style="display: block;"> 
          @foreach($subtitles as $subtitle)
          <div class="subtitle1" style="clear: both;" >
            <label for="embed_code"  style="float:left; margin-right:10px; padding-top:1px;">Upload Subtitle {{ $subtitle->language }}</label>
            <input type="file" name="subtitle_upload" id="subtitle_upload_{{ $subtitle->short_code }}">
            <input type="hidden" name="short_code" value="{{ $subtitle->short_code }}">
            <input type="hidden" name="language" value="{{ $subtitle->language }}">
          </div>
          @endforeach
          
        </div> 
      </div>

                           <div class="row">
                              <div class="col-sm-6 form-group">
                                 <select class="form-control" id="language" name="language">
                                    <option selected disabled="">Choose Language</option>
                                    @foreach($languages as $language)
							                  <option value="{{ $language->id }}" @if(!empty($video->language) && $video->language == $language->id)selected="selected"@endif>{{ $language->name }}</option>
						                  @endforeach
                              </select>
                              </div>   
                              <div class="col-sm-6 form-group">
                              <select id="access" name="access"  class="form-control" >
                                <option value="subscriber" @if(!empty($video->access) && $video->access == 'subscriber'){{ 'selected' }}@endif>Subscriber (only paid subscription users)</option>
                                 <option value="guest" @if(!empty($video->access) && $video->access == 'guest'){{ 'selected' }}@endif>Guest (everyone)</option>
                                 <option value="registered" @if(!empty($video->access) && $video->access == 'registered'){{ 'selected' }}@endif>Registered Users (free registration must be enabled)</option>   
                              </select>
                              </div> 
                                
                        </div>

             <div class="row">
                              <div class="col-sm-6 form-group">
                                  <input type="text" class="form-control" placeholder="Release Year" name="year" id="year" value="@if(!empty($video->year)){{ $video->year }}@endif">
                              </div>
                          <div class="col-sm-6 form-group">
                                   <input type="text" class="form-control" placeholder="Video Duration" name="duration" id="duration" value="@if(!empty($video->duration)){{ gmdate('H:i:s', $video->duration) }}@endif">
                              </div>
                             </div>
                         <div class="row">
                              <div class="col-sm-6 form-group">
                                  <input type="text" class="form-control" placeholder="Movie Ratings" name="rating" id="rating" value="@if(!empty($video->rating)){{ $video->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);">
                              </div>
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
	
	<script type="text/javascript" src="{{ URL::to('/assets/admin/js/tinymce/tinymce.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/jquery.mask.min.js') }}"></script>
<script type="text/javascript">
 $ = jQuery;
	$(document).ready(function(){
		$("#type").change(function(){
			if($(this).val() == 'file'){
				$('.new-video-file').show();
				$('.new-video-embed').hide();
				$('.new-video-upload').hide();

			} else if($(this).val() == 'embed'){ 
				$('.new-video-file').hide();
				$('.new-video-embed').show();
				$('.new-video-upload').hide();

			}else{
				$('.new-video-file').hide();
				$('.new-video-embed').hide();
				$('.new-video-upload').show();
				
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
