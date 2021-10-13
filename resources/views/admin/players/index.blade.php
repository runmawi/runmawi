@extends('admin.master')

@section('content')


<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<div id="content-page" class="content-page">
	<div class="container-fluid">
		<div class="iq-card">

			<div id="admin-container">
				<!-- This is where -->
                 
				<div class="admin-section-title">
					<h4 class=" card-title p-3"><i class="entypo-globe"></i> Player Settings</h4> 
                    <hr>
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
				<div class="clear"></div>



				<form method="POST" action="{{ URL::to('admin/players/store') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
					<section class="">
						<h2></h2>
                        <div class="row align-items-center" id="pda">
						<div class="col-md-6">
						<div class="flex">
							<div>
								<label> Show logos on player</label>
							</div>
							<div>
								<label class="switch">
								<input type="hidden" value="0" name="show_logo">    
								<input type="checkbox" name="show_logo" @if(!isset($playerui->show_logo) || (isset($playerui->show_logo) && $playerui->show_logo))checked="checked" value="1"@else value="1"@endif>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<div class="flex">
							<div>
								<label>Allow Embed player on specfic domians <br><span class="span1">
									(Note: Saving without a domain name will restrict <br>your embed player for all the domains.)
								</span></label>
							</div>
							<div>
								<label class="switch">
								<input type="hidden" value="0" name="embed_player">    

								<input type="checkbox" name="embed_player" @if(!isset($playerui->embed_player) || (isset($playerui->embed_player) && $playerui->embed_player))checked="checked" value="1"@else value="1"@endif>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<div class="flex">
							<div>
								<label>Add Watermark on the player</label>
							</div>
							<div>
								<label class="switch">
								<input type="hidden" value="0" name="watermark">    

								<input type="checkbox" name="watermark" @if(!isset($playerui->watermark) || (isset($playerui->watermark) && $playerui->watermark))checked="checked" value="1"@else value="1"@endif>
									<span class="slider round"></span>

								</label>
							</div>
						</div>
						<div class="flex">
							<div>
								<label>Thumbnails on seekbar</label>
							</div>
							<div>
								<label class="switch">
								<input type="hidden" value="0" name="thumbnail">    

								<input type="checkbox" name="thumbnail" @if(!isset($playerui->thumbnail) || (isset($playerui->thumbnail) && $playerui->thumbnail))checked="checked" value="1"@else value="1"@endif>
									<span class="slider round"></span>

								</label>
							</div>
						</div>
					
                     </div>
					 <div class="col-md-6">
						<div class="flex">
							<div>
								<label>Skip intro <br><span class="span1">(Allows end users to skip some <br>portion of thr video opening credits)</span></label>
							</div>
							<div>
								<label class="switch">
								<input type="hidden" value="0" name="skip_intro">    

								<input type="checkbox" name="skip_intro" @if(!isset($playerui->skip_intro) || (isset($playerui->skip_intro) && $playerui->skip_intro))checked="checked" value="1"@else value="1"@endif>
									<span class="slider round" ></span>

								</label>
							</div>
						</div>
						<div class="flex">
							<div>
								<label>Playback speed control</label>
							</div>
							<div>
								<label class="switch">
								<input type="hidden" value="0" name="speed_control">    

								<input type="checkbox" name="speed_control" @if(!isset($playerui->speed_control) || (isset($playerui->speed_control) && $playerui->speed_control))checked="checked" value="1"@else value="1"@endif>
									<span class="slider round"></span>

								</label>
							</div>
						</div>
						<div class="flex">
							<div>
								<label>Advanced player <br><span class="span1">(Allows you to change add html code)</span></label>
							</div>
							<div>
								<label class="switch">
								<input type="hidden" value="0" name="advance_player">    

									<input type="checkbox" name="advance_player" @if(!isset($playerui->advance_player) || (isset($playerui->advance_player) && $playerui->advance_player))checked="checked" value="0"@else value="1"@endif>
									<span class="slider round"></span>

								</label>
							</div>
						</div>
						<div class="flex">
							<div>
								<label>Enable video cards</label>
							</div>
							<div>
								<label class="switch">
								<input type="hidden" value="0" name="video_card">    

								<input type="checkbox" name="video_card" @if(!isset($playerui->video_card) || (isset($playerui->video_card) && $playerui->video_card))checked="checked" value="1"@else value="1"@endif>
									<span class="slider round"></span>

								</label>
							</div>
						</div>
						</div></div>
						
						
						<div class="p-3">
							<h4 class="card-title">Subtitle option</h4>
						</div>
						<div class="col-md-6">
						<div class="flex">
							<div>
								<label>Subtitle on as Default</label>
							</div>
							<div>
								<label class="switch">
								<input type="hidden" value="0" name="subtitle">    

								<input type="checkbox" name="subtitle" @if(!isset($playerui->subtitle) || (isset($playerui->subtitle) && $playerui->subtitle))checked="checked" value="1"@else value="1"@endif>
									<span class="slider round"></span>

								</label>
							</div>
						</div>
						</div>

						<div class="col-md-6">

						<div class="flex">
							<div>
								<label>Remeber subtitle preferences</label>
							</div>
							<div>
								<label class="switch">
								<input type="hidden" value="0" name="subtitle_preference">    

								<input type="checkbox" name="subtitle_preference" @if(!isset($playerui->subtitle_preference) || (isset($playerui->subtitle_preference) && $playerui->subtitle_preference))checked="checked" value="1"@else value="1"@endif>
									<span class="slider round"></span>

								</label>
							</div>
						</div>
						</div>

						<div class="p-3">
							<h4 class="card-title">Subtitle apperance</h4>
							<p>Customize the appearance of subtitle</p>
						</div>
						<div class="col-md-6">

						<div class="flex1">
							<div>
								<label>Font *</label>
							</div>
							<div class="col-sm-6">

								<select class="form-control" name="font" >
								<option value="Arial" @if(!empty($playerui->font) && $playerui->font == 'Arial'){{ 'selected' }}@endif>Arial</option>
									<option value="Timesroman" @if(!empty($playerui->font) && $playerui->font == 'Timesroman'){{ 'selected' }}@endif>Timesroman</option>
									<option value="Sans" @if(!empty($playerui->font) && $playerui->font == 'Sans'){{ 'selected' }}@endif>Sans sherif</option>
								</select>
							</div>
						</div>
						<div class="flex1">
							<div>
								<label>Size *</label>
							</div>
							<div class="col-sm-6">
								<select class="form-control" name="size" >
								<option value="Smaller" @if(!empty($playerui->size) && $playerui->size == 'Smaller'){{ 'selected' }}@endif>Smaller</option>
									<option value="Medium" @if(!empty($playerui->size) && $playerui->size == 'Medium'){{ 'selected' }}@endif>Medium</option>
									<option value="Bigger" @if(!empty($playerui->size) && $playerui->size == 'Bigger'){{ 'selected' }}@endif>Bigger</option>
								</select>

							</div>
						</div>
					
						</div>

						<div class="col-md-6">
						<div class="flex1">
							<div>
								<label>Font color *</label>
							</div>
							<div class="d-flex class="col-sm-6"">
							<input class="form-control" type="text" name="font_color" value="@if(!empty($playerui->font_color)){{ $playerui->font_color }}@endif" >
								<input class="form-control" type="color" name="chosecolorr" value="#336600" style="margin-left:5px;">
							</div>
						</div>
						<div class="flex1">
							<div>
								<label>Background color</label>
							</div>
							<div class="d-flex class="col-sm-6"">
							<input class="form-control" type="text" name="background_color" value="@if(!empty($playerui->background_color)){{ $playerui->background_color }}@endif" >
								<input class="form-control" type="color" name="chosecolorr" value="#336600" style="margin-left:5px;">
							</div>
						</div>
						<div class="flex1">
							<div>
								<label>Opacity</label>
							</div>
							<div>
								<input class="form-control" type="text" name="opacity" value="@if(!empty($playerui->opacity)){{ $playerui->opacity }}@endif" >

							</div>
						</div>
						</div>





						<div class="">
						<h4 class="card-title p-3">Video Player Watermark Settings</h4>
						</div>
                        <div class="row p-3">
						<div class="col-md-6">

						<div >
           			 <p> Right:</p>
				    <div class="form-group">
				        <input type="text"  class="form-control"  name="watermark_right" id="watermark_right" value="<?=$playerui->watermark_right;?>" />
				    </div>
				    </div>
					<div >
                    <p> Top:</p>
				    <div class="form-group">
				        <input type="text" class="form-control"  name="watermark_top" id="watermark_top" value="<?=$playerui->watermark_top;?>" />
				    </div>
						</div>
						<div >
							<p> Bottom:</p>
				    <div class="form-group">
				        <input type="text" class="form-control"  name="watermark_bottom" id="watermark_bottom" value="<?=$playerui->watermark_bottom;?>" />
						</div>
						</div>
                            <div >
                    <p> Left:</p>
				    <div class="form-group">
				        <input type="text" class="form-control"  name="watermark_left" id="watermark_left" value="<?=$playerui->watermark_left;?>" />
				    </div>
       			   </div>
				    </div>

				
					<div class="col-md-6">
					
						
          
                		                        
                        <div >
           			   <p> Opacity:</p>
				    <div class="form-group">
				        <input type="text" class="form-control"  name="watermark_opacity" id="watermark_opacity" value="<?=$playerui->watermark_opacity;?>" />
				    </div> 
          </div>
            
            <div >
                <p> Link:</p>
				    <div class="form-group">
				        <input type="text" class="form-control"  name="watermar_link" id="watermar_link" value="<?=$playerui->watermar_link;?>" />
				    </div>
            
          </div>
            
        <div >
		<div >
                <p> Width:</p>
				    <div class="form-group">
				        <input type="text" class="form-control"  name="watermar_width" id="watermar_width" value="<?=$playerui->watermar_width;?>" />
				    </div>
            
          </div>
            
        <div >
            <p>Upload Watermark:</p> 
            <input type="file" multiple="true" class="form-control" name="watermark_logo" id="watermark_logo" />
             @if(!empty($playerui->watermark))
                            <img src="{{  $playerui->watermark_logo }}" style="max-height:100px" />
            @endif
          </div>
		  <div class="panel-heading col-md-10"> <div class="panel-title"><!--Enable https:// sitewide--></div> 
		  <div class="panel-options"> 
			  <a href="#" data-rel="collapse">
				  <i class="entypo-down-open"></i>
				</a> 
			</div>
		</div> 
		</div>
		</div> 
		
						<div class="bt p-3">
							<button name="save" type="submit">Save</button>
							<button name="">Reset Default</button>
						</div>
						</div>

					</section>
				</form>

			</div>
		</div>
	</div><!-- admin-container -->


	@stop


	<style>
        .span1{
            font-weight: 200;
            font-size: 12px;
            font-family: 'Roboto', sans-serif;
        }
        #pda{
            padding: 20px;
        }
		</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        // $('#message').fadeOut(120);
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);
    })
</script>