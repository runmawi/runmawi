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
					<h3 class="p-3"><i class="entypo-globe"></i> Player Settings</h3> 
				</div>
				<div class="clear"></div>



				<form method="POST" action="{{ URL::to('admin/players/store') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
					<section class="play">
						<h2></h2> 
						<div class="flex">
							<div>
								<label> Show logos on player</label>
							</div>
							<div>
								<label class="switch">
									<input type="checkbox" name="show_logo" @if(!isset($playerui->show_logo) || (isset($playerui->show_logo) && $playerui->show_logo))checked="checked" value="1"@else value="0"@endif>
									<span class="slider round"></span>

								</label>
							</div>
						</div>
						<div class="flex">
							<div>
								<label>Skip intro <br><span>(Allows end users to skip some <br>portion of thr video opening credits)</span></label>
							</div>
							<div>
								<label class="switch">
									<input type="checkbox" name="skip_intro" @if(!isset($playerui->skip_intro) || (isset($playerui->skip_intro) && $playerui->skip_intro))checked="checked" value="1"@else value="0"@endif>
									<span class="slider round" ></span>

								</label>
							</div>
						</div>
						<div class="flex">
							<div>
								<label>Allow Embed player on specfic domians <br><span>
									Note: Saving without a domain name will restrict <br>your embed player for all the domains.
								</span></label>
							</div>
							<div>
								<label class="switch">
									<input type="checkbox" name="embed_player" @if(!isset($playerui->embed_player) || (isset($playerui->embed_player) && $playerui->embed_player))checked="checked" value="1"@else value="0"@endif>
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
									<input type="checkbox" name="watermark" @if(!isset($playerui->watermark) || (isset($playerui->watermark) && $playerui->watermark))checked="checked" value="1"@else value="0"@endif>
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
									<input type="checkbox" name="thumbnail" @if(!isset($playerui->thumbnail) || (isset($playerui->thumbnail) && $playerui->thumbnail))checked="checked" value="1"@else value="0"@endif>
									<span class="slider round"></span>

								</label>
							</div>
						</div>
						<div class="flex">
							<div>
								<label>Advanced player <br><span>(Allows you to change add html code)</span></label>
							</div>
							<div>
								<label class="switch">
									<input type="checkbox" name="advance_player" @if(!isset($playerui->advance_player) || (isset($playerui->advance_player) && $playerui->advance_player))checked="checked" value="1"@else value="0"@endif>
									<span class="slider round"></span>

								</label>
							</div>
						</div>
						<div class="flex">
							<div>
								<label>Playback speed control</label>
							</div>
							<div>
								<label class="switch">
									<input type="checkbox" name="speed_control" @if(!isset($playerui->speed_control) || (isset($playerui->speed_control) && $playerui->speed_control))checked="checked" value="1"@else value="0"@endif>
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
									<input type="checkbox" name="video_card" @if(!isset($playerui->video_card) || (isset($playerui->video_card) && $playerui->video_card))checked="checked" value="1"@else value="0"@endif>
									<span class="slider round"></span>

								</label>
							</div>
						</div>
						<div class="">
							<h1>Subtitle option</h1>
						</div>
						<div class="flex">
							<div>
								<label>Subtitle on as Default</label>
							</div>
							<div>
								<label class="switch">
									<input type="checkbox" name="subtitle" @if(!isset($playerui->subtitle) || (isset($playerui->subtitle) && $playerui->subtitle))checked="checked" value="1"@else value="0"@endif>
									<span class="slider round"></span>

								</label>
							</div>
						</div>
						<div class="flex">
							<div>
								<label>Remeber subtitle preferences</label>
							</div>
							<div>
								<label class="switch">
									<input type="checkbox" name="subtitle_preference" @if(!isset($playerui->subtitle_preference) || (isset($playerui->subtitle_preference) && $playerui->subtitle_preference))checked="checked" value="1"@else value="0"@endif>
									<span class="slider round"></span>

								</label>
							</div>
						</div>
						<div class="">
							<h1>Subtitle apperance</h1>
							<p>Customize the appearance of subtitle</p>
						</div>

						<div class="flex1">
							<div>
								<label>Font *</label>
							</div>
							<div>

								<select name="font">
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
							<div>
								<select name="size">
									<option value="Smaller" @if(!empty($playerui->size) && $playerui->size == 'Smaller'){{ 'selected' }}@endif>Smaller</option>
									<option value="Medium" @if(!empty($playerui->size) && $playerui->size == 'Medium'){{ 'selected' }}@endif>Medium</option>
									<option value="Bigger" @if(!empty($playerui->size) && $playerui->size == 'Bigger'){{ 'selected' }}@endif>Bigger</option>
								</select>

							</div>
						</div>
						<div class="flex1">
							<div>
								<label>Font color *</label>
							</div>
							<div>
								<input type="text" name="font_color" value="@if(!empty($playerui->font_color)){{ $playerui->font_color }}@endif">
								<input type="color" name="chosecolorr" value="#336600">
							</div>
						</div>
						<div class="flex1">
							<div>
								<label>Background color</label>
							</div>
							<div>
								<input type="text" name="background_color" value="@if(!empty($playerui->background_color)){{ $playerui->background_color }}@endif">
								<input type="color" name="chosecolorr" value="#336600">
							</div>
						</div>
						<div class="flex1">
							<div>
								<label>Opacity</label>
							</div>
							<div>
								<input type="text" name="opacity" value="@if(!empty($playerui->opacity)){{ $playerui->opacity }}@endif">

							</div>
						</div>
						<div class="bt">
							<button name="save" type="submit">Save</button>
							<button name="">Reset Default</button>
						</div>
					</section>
				</form>

			</div>
		</div>
	</div><!-- admin-container -->


	@stop