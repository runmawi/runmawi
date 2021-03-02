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
                           <h4 class="card-title">Add Movie</h4>
                        </div>
                     </div>
                     <div class="iq-card-body">
                        <form action="movie-view.html">
                           <div class="row">
                              <div class="col-lg-7">
                                 <div class="row">
                                    <div class="col-12 form-group">
                                       <input type="text" class="form-control" placeholder="Title">
                                    </div>
                                    <div class="col-12 form_gallery form-group">
                                       <label id="gallery2" for="form_gallery-upload">Upload Image</label>
                                       <input data-name="#gallery2" id="form_gallery-upload" class="form_gallery-upload"
                                          type="file" accept=".png, .jpg, .jpeg">
                                    </div>
                                    <div class="col-md-6 form-group">
                                       <select class="form-control" id="exampleFormControlSelect1">
                                          <option disabled="">Movie Category</option>
                                          <option>Comedy</option>
                                          <option>Crime</option>
                                          <option>Drama</option>
                                          <option>Horror</option>
                                          <option>Romance</option>
                                       </select>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                       <select class="form-control" id="exampleFormControlSelect2">
                                          <option disabled="">Choose quality</option>
                                          <option>FULLHD</option>
                                          <option>HD</option>
                                       </select>
                                    </div>
                                    <div class="col-12 form-group">
                                       <textarea id="text" name="text" rows="5" class="form-control"
                                          placeholder="Description"></textarea>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-lg-5">
                                 <div class="d-block position-relative">
                                    <div class="form_video-upload">
                                       <input type="file" accept="video/mp4,video/x-m4v,video/*" multiple>
                                       <p>Upload video</p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                             <div class="col-sm-12 form-group">
                                                                        <input type="file" accept="video/mp4,video/x-m4v,video/*" multiple>
                                       <p>Upload Trailer video</p>
                              </div>
                           <div class="row">
                              <div class="col-sm-6 form-group">
                                 <input type="text" class="form-control" placeholder="Release year">
                              </div>
                              <div class="col-sm-6 form-group">
                                 <select class="form-control" id="exampleFormControlSelect3">
                                    <option selected disabled="">Choose Language</option>
                                    <option>English</option>
                                    <option>Hindi</option>
                                    <option>Tamil</option>
                                    <option>Gujarati</option>
                                 </select>
                              </div>
                              <div class="col-sm-12 form-group">
                                 <input type="text" class="form-control" placeholder="Movie Duration">
                                   <input type="text" class="form-control" placeholder="Movie Ratings">
                              </div>
                              <div class="col-12 form-group ">
                                 <button type="submit" class="btn btn-primary">Submit</button>
                                 <button type="reset" class="btn btn-danger">cancel</button>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

	
	<input type="text" id="base_url" value="<?php echo URL::to('/');?>">
	
	@section('javascript')


	<script type="text/javascript" src="{{ URL::to('/assets/admin/js/tinymce/tinymce.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/tagsinput/jquery.tagsinput.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::to('/assets/js/jquery.mask.min.js') }}"></script>

	<script type="text/javascript">

	$ = jQuery;

	$(document).ready(function(){

		$('#duration').mask('00:00:00');
		$('#tags').tagsInput();

		$('#type').change(function(){
            
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


	@stop

@stop
