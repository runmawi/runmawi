@extends('admin.master')
<style>
      .black{
        color: #000;
        background: #f2f5fa;
        padding: 20px 20px;
border-radius: 0px 4px 4px 0px;
    }
    .black:hover{
        background: #fff;
         padding: 20px 20px;
        color: rgba(66, 149, 210, 1);

    }

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
    background-color: #20222c;
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
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@stop
<?php //dd($series);
$settings  = App\Setting::first();?>
<?php $message = "Title Already Exits";  ?>
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<div id="content-page" class="content-page">
    <div class="d-flex">
    <a class="black" href="{{ URL::to('admin/series-list') }}"> Series List</a>
        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/series/create') }}"> Add New Series</a></div>
    <div class="container-fluid p-0">
<!-- This is where -->
	<div class="iq-card" style="padding:20px;">
	<div class="admin-section-title pull-right">
        @if(!empty($series->id))
        <div class="d-flex justify-content-between">
            <div>
                <a href="{{ URL::to('play_series') . '/' . $series->slug }}" target="_blank" class="btn btn-primary">
                    <i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i>
                </a>
            </div>
        </div>
        @endif
	</div>
        <h4><i class="entypo-plus"></i> Add New Series</h4> 
        <hr>
		<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="series_form">

		
			<div class="row mt-3">
				<div class="col-sm-6 mb-3">
                    <label class="m-0">Title</label> 
                    <p class="p1">Add the series title in the textbox below.</p> 
                    <input type="text" class="form-control" name="title" id="title" placeholder="Series Title" value="@if(!empty($series->title)){{ $series->title }}@endif"  />
                    <span class="invalid-feedback" id="title_error" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                </div>
					
<!--<input type="text" class="form-control" name="title" id="title" placeholder="Series Title" value="@if(!empty($series->title)){{ $series->title }}@endif" style="background-color:#000000;!important" />
						</div> -->
                    
                @if(!empty($series->created_at))
                    
                    <div class="col-sm-6">
                        <label class="m-0">Created Date</label>
                        <div class="panel-body" style="display: block;"> 
                            <p class="p1">Select Date/Time Below</p> 
                            <input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($series->created_at)){{ $series->created_at }}@endif" />
                        </div> 
                    </div>   
                @endif
            
			<div class="col-sm-6" data-collapsed="0">
                <label class="m-0">Slug</label>
				<div class="panel-body">
                    <p class="p1">Add a URL Slug</p> 
					<input type="text" class="form-control" name="slug" id="slug" placeholder="Series Slug" value="@if(!empty($series->slug)){{ $series->slug }}@endif"  />			
				</div> 
			</div>
            </div>
			<div class="row">
				<div class="col-md-6">
				<div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title font-weight-bold"><label class="m-0">Series Image Cover</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body col-sm-6 p-0" style="display: block;"> 
                    <p class="p1">Select the series image (1080 X 1920px or 9:16 ratio):</p> 
					@if(!empty($series->image))
						<img src="{{ URL::to('/') . '/public/uploads/images/' . $series->image }}" class="series-img" width="200"/>
					@endif
					<input type="file" multiple="true" class="form-group" name="image" id="image" />
					{{-- for validate --}}
					<input type="hidden" id="check_image" name="check_image" value="@if(!empty($series->image) ) {{ "validate" }} @else {{ " " }} @endif"  />
					<input type="hidden" id="player_check_image" name="player_check_image" value="@if(!empty($series->player_image) ) {{ "validate" }} @else {{ " " }} @endif"  />

				</div> 
			</div>
			</div>
			<div class="col-md-6">
		<div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title font-weight-bold"><label class="m-0">Series Player Image </label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body col-sm-6 p-0" style="display: block;"> 
                    <p class="p1">Select the Player image (16:9 Ratio or 1280X720px):</p> 
					@if(!empty($series->player_image))
						<img src="{{ URL::to('/') . '/public/uploads/images/' . $series->player_image }}" class="series-img" width="200"/>
					@endif
					<input type="file" multiple="true" class="form-group" name="player_image" id="player_image" />
					{{-- for validate --}}
					<input type="hidden" id="player_image" name="player_image" value="@if(!empty($series->player_image) ) {{ "validate" }} @else {{ " " }} @endif"  />

				</div> 
			</div>
			</div>
			</div>


			<div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 

			<div class="panel panel-primary mt-3" data-collapsed="0"> 
                <div class="panel-heading"> 
				<div class="panel-title font-weight-bold"><label class="m-0">Series Details, Links, and Info</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body col-sm-12 p-0" style="display: block; padding:0px;">
					<textarea class="form-control" name="details" id="summary-ckeditor" >@if(!empty($series->details)){{ htmlspecialchars($series->details) }}@endif</textarea>
				</div> 
			</div>

			<div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title font-weight-bold"><label class="m-0">Short Description</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body col-sm-12 p-0" style="display: block;"> 
					<p class="p1">Add a short description of the series below:</p> 
					<textarea class="form-control" name="description" id="description" >@if(!empty($series->description)){{ htmlspecialchars($series->description) }}@endif</textarea>
				</div> 
			</div>
			<div class="row mt-3"> 
				<div class="col-sm-6">
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title font-weight-bold"><label class="m-0">Cast and Crew</label> </div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<p class="p1">Add artists for the series below:</p> 
							<select class="form-control js-example-basic-multiple" name="artists[]"  style="width: 100%;" multiple="multiple">
								@foreach($artists as $artist)
								@if(in_array($artist->id, $series_artist))
								<option value="{{ $artist->id }}" selected="true">{{ $artist->artist_name }}</option>
								@else
								<option value="{{ $artist->id }}">{{ $artist->artist_name }}</option>
								@endif 
								@endforeach
							</select>

						</div> 
					</div>
				</div>

                <div class="col-sm-6">
                    <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
                        <div class="panel-title font-weight-bold"><label class="m-0">Category</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                        <div class="panel-body" style="display: block;"> 
                            <p class="p1">Select a Series Category Below:</p>
                            <select name="genre_id[]" id="genre_id" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
                            	@foreach($series_categories as $category)
                            		@if(in_array($category->id, $category_id))
                            			<option value="{{ $category->id }}" selected="true">{{ $category->name }}</option>
                            		@else
                            			<option value="{{ $category->id }}">{{ $category->name }}</option>
                            		@endif 
                            	@endforeach
                        	</select>
                        </div> 
                    </div>
                </div>

			</div>
			<div class="row mt-3"> 
                <div class="col-sm-6">
                    <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
                        <div class="panel-title font-weight-bold"><label class="m-0">Series Ratings</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                        <div class="panel-body p-0 " style="display: block;"> 
                            <p class="p1">IMDb Ratings 10 out of 10</p>
                            <input class="form-control" name="rating" id="rating" value="@if(!empty($series->rating)){{ $series->rating }}@endif" onkeyup="NumAndTwoDecimals(event , this);" >
                        </div> 
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
                        <div class="panel-title font-weight-bold"><label class="m-0">Language</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
                        <div class="panel-body" style="display: block;"> 
                            <p class="p1">Select a Series Language Below:</p>
                            <select class="form-control js-example-basic-multiple" id="language" name="language[]"  style="width: 100%;" multiple="multiple" >
                                @foreach($languages as $language)
                                @if(in_array($language->id, $languages_id))
                                    <option value="{{ $language->id }}" selected="true">{{ $language->name }}</option>
                                    @else
                                    <option value="{{ $language->id }}" >{{ $language->name }}</option>					
                                @endif 
                                @endforeach
                            </select>
                        </div> 
                    </div>
			     </div>
			</div>

			<div class="row align-items-center mt-3"> 
			
			<div class="col-sm-6">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title font-weight-bold"><label class="m-0">Series Year</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body  p-0" style="display: block;"> 
                    <p class="p1">Series Created Year</p>
					<input class="form-control" name="year" id="year" value="@if(!empty($series->year)){{ $series->year }}@endif" >
				</div> 
			</div>
			</div>

            <div class="col-sm-6" data-collapsed="0">
				<div class="panel-heading"> 
					<div class="panel-title font-weight-bold"><label class="m-0">Search Tags</label></div>
						<div class="panel-options"> 
							<a href="#" data-rel="collapse">
								<i class="entypo-down-open"></i>
							</a> 
						</div>
					</div> 
					<div class="panel-body  p-0" style="display: block;"> 
						<p class="p1">Add series tags below:</p> 
						<input type="text"  class="form-control"  id="tag-input1" name="search_tag" >
					</div> 
				</div>    
			</div>

			<div class="clear"></div>


			<div class="row align-items-center mt-3 p-3"> 

				<div class="col-sm-4 p-0"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title font-weight-bold"> <label class="m-0">Duration</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<p class="p1">Enter the duration in the (HH: MM : SS) format </p> 
							<input class="form-control" name="duration" id="duration" value="@if(!empty($series->duration)){{ gmdate('H:i:s', $series->duration) }}@endif" >
						</div> 
					</div>
				</div>

				<div class="col-sm-4"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title font-weight-bold"> <label class="m-0">User Access</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<p class="p1">Who is allowed to view this series?</p>
							<select class="form-control" id="access" name="access">
								<option value="guest" @if(!empty($series->access) && $series->access == 'guest'){{ 'selected' }} @endif >Guest (everyone)</option>
								<option value="registered" @if(!empty($series->access) && $series->access == 'registered'){{ 'selected' }}@endif>Registered Users (free registration must be enabled)</option>
								<option value="subscriber" @if(!empty($series->access) && $series->access == 'subscriber'){{ 'selected' }}@endif>Subscriber (only paid subscription users)</option>
							</select>
							<div class="clear"></div>
						</div> 
					</div>
				</div>

				<div class="col-sm-4"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title font-weight-bold"> <label class="m-0">Status Settings</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body"> 
							<div class="d-flex align-items-baseline">
								<label class="p2" for="featured" style="float:left; display:block; margin-right:10px;">Is this series Featured:</label>
								<input type="checkbox" @if(!empty($series->featured) && $series->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
							</div>
							<div class="clear"></div>

							<div class="d-flex align-items-baseline">
								<label class="p2" for="active" style="float:left; display:block; margin-right:10px;">Is this series Active:</label>
								<input type="checkbox" @if(!empty($series->active) && $series->active == 1){{ 'checked="checked"' }}@elseif(!isset($series->active)){{ 'checked="checked"' }}@endif name="active" value="1" id="active" />
							</div>

							<div class="d-flex align-items-baseline">
								<label class="p2" for="featured" style="float:left; display:block; margin-right:10px;">Enable this series as Slider:</label>
								<input type="checkbox" @if(!empty($series->banner) && $series->banner == 1){{ 'checked="checked"' }}@elseif(!isset($series->banner)){{ 'checked="checked"' }}@endif name="banner" value="1" id="banner" />
							</div>

									{{-- Trailer option --}}
							<div class="d-flex align-items-baseline">
								<label class="p2" for="active" style="float:left; display:block; margin-right:10px;">Season Trailer:</label>
								<input type="checkbox" @if(!empty($series->series_trailer) && $series->series_trailer == 1){{ 'checked="checked"' }}@elseif(!isset($series->series_trailer)){{ 'checked="checked"' }}@endif name="series_trailer" value="1" id="series_trailer" />
							</div>

							@if( $button_text == "Add New Series" )

								<div class="d-flex align-items-baseline season_trailer">
									<label class="p2" for="active" style="float:left; display:block; margin-right:10px;">Season 1 :</label>
									<input type="radio" name="season_trailer" value="1" checked> 
								</div>

							@elseif($button_text == "Update Series" )

							@php
								$season_id = App\Series::Select('series_seasons.id','series.season_trailer','series.id as series_id')
											->Join('series_seasons','series_seasons.series_id','=','series.id')
											->where('series_id',$series->id)
											->get();
							@endphp

								<div class="d-flex align-items-baseline season_trailer">
										@forelse ($season_id as $key => $item)
											<label class="p2" for="active" style="float:left; display:block; margin-right:10px;">Season {{ $key + 1 }} :</label>
											<input type="radio" name="season_trailer" value="{{ $item->id }}" @if( $item->id  == $series->season_trailer ) {{ 'checked' }} @endif  > 
										@empty
											
										@endforelse
								</div>
							
							@endif

						</div> 
					</div>
				</div>
                </div>
				@if($settings->series_season == 0)
                <div class="row align-items-center mt-3 p-3"> 
                    <div class="col-sm-3 p-0"> 
                       
                            <div class="panel-body"> 
                                <div class="d-flex justify-content-between align-items-baseline">
                                     <label class="m-0 p2">Apply Global PPV Price:</label>
                                <?php if($settings->ppv_status == 1){ ?>
                                  <input type="checkbox" name="ppv_status" value="1" id="ppv_status" {{  !empty($series->ppv_status) && $series->ppv_status == "1" ? "checked" : "" }} />
                                  <?php } else{ ?>
                                    <div class="global_ppv_status ml-2">
                                        <input type="checkbox" name="ppv_status" value="1" id="ppv_status" {{  !empty($series->ppv_status) && $series->ppv_status == "1" ? "checked" : "" }} />
                                    </div>
                                   <?php } ?>

                                <div class="clear"></div>
                            </div> 
                        </div>
                    </div>
                </div>
				@else
				<input type="hidden" name="ppv_status" value="" id="ppv_status" />
				@endif
            </div>
            <div class="row mt-3">
                <div class="col-sm-12 ml-1"> 
                    @if(!isset($series->user_id))
                        <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
                    @endif

                    @if(isset($series->id))
                        <input type="hidden" id="id" name="id" value="{{ $series->id }}" />
                    @endif

                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                    <input type="submit" value="{{ $button_text }}" class="btn btn-primary " />
                </div>
			</div><!-- row -->
        </div>
    </form>
</div>

		<div class="clear"></div>
		<!-- Manage Season -->
		@if(!empty($series->id))
		
		<div class="admin-section-title">
            <div class="row p-3">
                <div class="col-md-8">
                    <h3 class="fs-title">Manage Season &amp; Episodes</h3> 
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-primary"><i class="fa fa-plus-circle"></i>Create Season</a>

                    <!-- <a href="{{ URL::to('admin/season/create/') . '/' . $series->id  }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i>Create Season</a> -->
                </div>
            </div>
		<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
                    <h4 class="modal-title">Add Season</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/season/create/') }}" enctype="multipart/form-data" method="post">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
						<input type="hidden" name="series_id" value="<?= $series->id ?>" />

							<div class="form-group" >
								<label> Season Trailer :</label>
								<div class="new-video-file form_video-upload" style="position: relative;" >
								<input type="file" accept="video/mp4,video/x-m4v,video/*" name="trailer" id="trailer">
								<p style="font-size: 14px!important;">Drop and drag the video file</p>
								</div>
							</div>
							<div class="form-group">
								<label>Season Thumbnail <span>(16:9 Ratio or 1280X720px)</span></label><br>
								<input type="file" name="image" id="image" >
							</div>
                                
						    <div class="form-group">
		                        <label> Choose User Access:</label>
								<select class="form-control" id="ppv_access" name="ppv_access">
								<option value="free" >Free (everyone)</option>
								@if($settings->series_season == 1)
								<option value="ppv" >PPV  (Pay Per Season(Episodes))</option>   
								@endif
							</select>
		                        <!-- <input type="text" id="ppv_price" name="ppv_price" value="" class="form-control" placeholder="Plan Name"> -->
                            </div>
                      
                            <div class="form-group" id="ppv_price">
							<label class="">PPV Price:</label>
								<input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" value="@if(!empty($video->ppv_price)){{ $video->ppv_price }}@endif">
		                    </div>  
							@if($settings->series_season == 1)
							<div class="form-group">
		                        <label>PPV Interval:</label>
								<p class="p1">Please Mention How Many Episodes are Free:</p>
		                        <input type="text" id="ppv_interval" name="ppv_interval" value="" class="form-control">
		                    </div>  
							@endif                   
				    </form>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="submit-new-cat">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	
		<div class="row p-3">
<table class="table table-bordered genres-table">

		<tr class="table-header">
			<th>Seasons</th>
			<th>Episodes</th>
			<th>Operation</th>
			
			@foreach($seasons as $key=>$seasons_value)
			<tr>
				<td valign="bottom"><p>Season {{$key+1}}</p></td>
				<td valign="bottom"><p>{{count($seasons[$key]['episodes'])}} Episodes</p></td>
				<td>
					<p>
						<a href="{{ URL::to('admin/season/edit') . '/' . $series->id. '/' . $seasons_value->id }}" class="btn btn-xs btn-black"><span class="fa fa-edit"></span> Manage Episodes</a>
						<a href="{{ URL::to('admin/season/edit') . '/' . $seasons_value->id }}" class="btn btn-xs btn-black"><span class="fa fa-edit"></span> Edit Season</a>
						<a href="{{ URL::to('admin/season/delete') . '/' . $seasons_value->id }}" class="btn btn-xs btn-white delete"><span class="fa fa-trash"></span> Delete</a>
					</p>
				</td>
			</tr>
			@endforeach
	</table>
            </div>
	

		<div class="clear"></div>

		
		</div>
		</div>
		@endif
<!-- This is where now -->
</div>
<script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script type="text/javascript">
   $ = jQuery;
   $(document).ready(function($){
    $("#duration").mask("00:00:00");
   });

		$(document).ready(function(){

			$('#title_error').hide();
			$('#ppv_price').hide();


			$('#access').change(function(){
				if($('#access').val() == "ppv"){
				$('#ppv_price').show();
				}
			});

			

		$('#title').change(function(){
   		//  alert(($('#title').val()));

			var title = $('#title').val();
			$.ajax({
				url:"{{ URL::to('admin/titlevalidation') }}",
				method:'GET',
				data: {
					_token: '{{ csrf_token() }}',
					title: $('#title').val()

				},  
		    success: function(value){
			console.log(value.Series);
            if(value.Series == "yes"){
            $('#title_error').show();
            }else{
            $('#title_error').hide();
            }
        }
    });
})
			// alert("fd");
		$('.js-example-basic-multiple').select2();

		// $('#duration').mask('00:00:00');

		$('#type').change(function(){
			if($(this).val() == 'file'){
				$('.new-series-file').show();
				$('.new-series-embed').hide();
				$('.new-series-upload').hide();

			} else if($(this).val() == 'embed'){ 
				$('.new-series-file').hide();
				$('.new-series-embed').show();
				$('.new-series-upload').hide();

			}else{
				$('.new-series-file').hide();
				$('.new-series-embed').hide();
				$('.new-series-upload').show();
				
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

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    	
        <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

        <script>
        CKEDITOR.replace( 'summary-ckeditor', {
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });


        </script>

<script>
			
$('#ppv_access').change(function(){
	// alert($(this).val());

	if($(this).val() == "ppv"){
	$('#ppv_price').show();
	}
});

$('#submit-new-cat').click(function(){
	$('#new-cat-form').submit();
});
</script>

@section('javascript')

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>

$('form[id="series_form"]').validate({
	rules: {
		title: 'required',
		image: {
			required: '#check_image:blank'
		},
		'language[]': {
					required: true
		},
		player_image: {
			required: '#player_check_image:blank'
		},
	},
	
	messages: {
	  title: 'This field is required',
	  image: 'This field is required',
	},
	submitHandler: function(form) {
	  form.submit();
	}
  });


$('form[id="new-cat-form"]').validate({
	rules: {
		trailer: 'required',
	  image: 'required',

		},
	messages: {
		trailer: 'This field is required',
	  image: 'This field is required',

	},
	submitHandler: function(form) {
	  form.submit();
	}
  });
</script>

{{-- Search Tag --}}

<script>
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


	var tagsdata= "{{ !empty($series->search_tag) ? $series->search_tag : null }}";
	var series_search_tag = [];
	var newVal = tagsdata.split(',');
	series_search_tag.push(...newVal);


if(tagsdata == ""){
		tagInput1.addData([])
}else{
	tagInput1.addData(series_search_tag	)
}

</script>


	@stop

@stop
