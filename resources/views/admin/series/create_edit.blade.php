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

.form-select{border: 1px solid #ced4da;border-radius: .25rem;font-size: 14px;padding: 10px;height: 38px;}
#unassignedepisodes .modal-dialog{max-width: 900px;}
#ppv_price_plan select,
#ios_ppv_price_plan select,
#ios_ppv_price_old select 
{
    width: 100%;
    box-sizing: border-box;
    max-width: 100%;
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div id="content-page" class="content-page">
    <div class="d-flex">
    <a class="black" href="{{ URL::to('admin/series-list') }}"> TV Shows List</a>
        <a class="black" style="background:#fafafa!important;color: #006AFF!important;" href="{{ URL::to('admin/series/create') }}"> Add New TV Shows </a></div>
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
        <h4><i class="entypo-plus"></i> {{ $Header_name }}</h4> 
        <hr>
		<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data" id="series_form">

		
			<div class="row mt-3">
				<div class="col-sm-6 mb-3">
                    <label class="m-0">Title</label> 
                    <p class="p1">Add the TV Shows title in the textbox below.</p> 
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

											{{-- Series Image --}}
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-primary mt-3" data-collapsed="0"> 
						<div class="panel-heading"> 
							<div class="panel-title font-weight-bold">
								<label class="m-0">TV Shows Image Cover</label>
							</div> 
							<div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
						</div> 

						<div class="panel-body col-sm-8 p-0" style="display: block;"> 
							@php 
								$width = $compress_image_settings->width_validation_series;
								$heigth = $compress_image_settings->height_validation_series
							@endphp
							@if($width !== null && $heigth !== null)
								<p class="p1">{{ ("Select the TV Shows image1 (".''.$width.' x '.$heigth.'px)')}}:</p> 
							@else
								<p class="p1">{{ "Select the TV Shows image (720X1280px)"}}:</p> 
							@endif
							<input type="file" multiple="true" class="form-group image series_image" name="image" id="series_image" accept="image/png, image/webp, image/jpeg, image/jpg"/>

							<span>
								<p id="video_image_error_msg" style="color:red !important; display:none;">
									* Please upload an image with the correct dimensions.
								</p>
							</span>

							@if(!empty($series->image))
								<img src="{{ URL::to('/') . '/public/uploads/images/' . $series->image }}" class="series-img" width="200"/>
							@endif
							
						</div> 
					</div>
				</div>

											{{-- Series Player Image --}}

				<div class="col-md-6">
					<div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title font-weight-bold"><label class="m-0">Series Player Image </label></div> 
							<div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
						</div> 

						<div class="panel-body col-sm-8 p-0" style="display: block;"> 
							@php 
								$player_width = $compress_image_settings->series_player_img_width;
								$player_heigth = $compress_image_settings->series_player_img_height
							@endphp
							@if($player_width !== null && $player_heigth !== null)
								<p class="p1">{{ ("Select The Player Image2 (".''.$player_width.' x '.$player_heigth.'px)')}}:</p> 
							@else
								<p class="p1">{{ "Player Thumbnail ( 1280X720px)"}}</p> 
							@endif
							<input type="file" multiple="true" class="form-group" name="player_image" id="series_player_image" accept="image/png, image/webp, image/jpeg, image/jpg"/>

							<span>
								<p id="player_image_error_msg" style="color:red !important; display:none;">
									* Please upload an image with the correct dimensions.
								</p>
							</span>
							@if(!empty($series->player_image))
								<img src="{{ URL::to('/') . '/public/uploads/images/' . $series->player_image }}" class="series-img" width="200"/>
							@endif

						</div> 
					</div>
				</div>
			</div>

			{{-- Series TV image --}}

			<div class="row d-flex">

				<div class="col-md-6">
					<div class="panel panel-primary mt-3" data-collapsed="0"> 
						<div class="panel-heading"> 
							<div class="panel-title font-weight-bold">
								<label class="m-0">TV Shows TV Image Cover</label>
							</div> 
							<div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
						</div> 

						<div class="panel-body col-sm-8 p-0" style="display: block;"> 
							<p class="p1">{{ "TV image Thumbnail ( 16:9 Ratio or 1280X720px )"}}</p> 

							<input type="file" multiple="true" class="form-group image" name="tv_image" id="tv_image" />
							
							@if(!empty($series->tv_image))
								<img src="{{ URL::to('/') . '/public/uploads/images/' . $series->tv_image }}" class="series-img" width="200"/>
							@endif
							
							{{-- for validate --}}
							<input type="hidden" id="check_tv_image" name="check_tv_image" value="@if(!empty($series->tv_image) ) {{ "validate" }} @else {{ " " }} @endif"  />
						</div> 
					</div>
				</div>

			</div>

			<div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading">

			<div class="panel panel-primary mt-3" data-collapsed="0"> 
                <div class="panel-heading"> 
				<div class="panel-title font-weight-bold"><label class="m-0">TV Shows Details, Links, and Info</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body col-sm-12 p-0" style="display: block; padding:0px;">
					<textarea class="form-control" name="details" id="summary-ckeditor" >@if(!empty($series->details)){{ ($series->details) }}@endif</textarea>
				</div> 
			</div>

			<div class="panel panel-primary mt-3" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title font-weight-bold"><label class="m-0">Show Description</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
				<div class="panel-body col-sm-12 p-0" style="display: block;"> 
					<p class="p1">Add a short description of the TV Shows below:</p> 
					<textarea class="form-control" name="description" id="description" >@if(!empty($series->description)){{ ($series->description) }}@endif</textarea>
				</div> 
			</div>
			<div class="row mt-3"> 
				<div class="col-sm-6">
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title font-weight-bold"><label class="m-0">Cast and Crew</label> </div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
						<div class="panel-body" style="display: block;"> 
							<p class="p1">Add artists for the TV Shows below:</p> 
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
                            <p class="p1">Select a TV Shows Category Below:</p>
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
                        <div class="panel-title font-weight-bold"><label class="m-0">TV Shows Ratings</label></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div> 
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
                            <p class="p1">Select a TV Shows Language Below:</p>
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
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> 
							<div class="panel-title font-weight-bold"><label class="m-0">TV Shows Year</label></div> 
							<div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
						</div> 
						<div class="panel-body  p-0" style="display: block;"> 
							<p class="p1">TV Shows Created Year</p>
							<input class="form-control" name="year" id="year" value="@if(!empty($series->year)){{ $series->year }}@endif" >
						</div> 
					</div>
				</div>

				<div class="col-sm-6" data-collapsed="0">
					<div class="panel-heading"> 
						<div class="panel-title font-weight-bold"><label class="m-0">TV Shows Tags</label></div>
						<div class="panel-options"> 
							<a href="#" data-rel="collapse">
								<i class="entypo-down-open"></i>
							</a> 
						</div>
					</div> 
					<div class="panel-body  p-0" style="display: block;"> 
						<p class="p1">Add TV Shows tags below:</p> 
						<input type="text"  class="form-control"  id="tag-input1" name="search_tag" >
					</div> 
				</div>    
			</div>

					{{-- Series Network --}}

			@if (Series_Networks_Status() == 1)
				<div class="row align-items-center mt-3"> 
		
					<div class="col-sm-6">
						<div class="panel panel-primary" data-collapsed="0"> 
							<div class="panel-heading"> 
								<div class="panel-title font-weight-bold"><label class="m-0">TV Shows Network</label></div> 
								<div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
							</div> 
							<div class="panel-body  p-0" style="display: block;"> 
								<p class="p1">Select A TV Shows Network Below:</p>
	
								<select name="network_id[]" id="network_id" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
									@foreach($SeriesNetwork as $category)
										@if(in_array($category->id, $series_networks_id))
											<option value="{{ $category->id }}" selected="true">{{ $category->name }}</option>
										@else 
											<option value="{{ $category->id }}">{{ $category->name }}</option>
										@endif 
									@endforeach
								</select>
							</div> 
						</div>
					</div>
					<div class="col-6">
						<div class="panel panel-primary" data-collapsed="0"> 
							<div class="panel-heading"> 
								<div class="panel-title font-weight-bold"><label class="m-0">Block Countries</label></div> 
							</div> 
							<div class="panel-body  p-0" style="display: block;"> 
								<p class="p1">Select A block countires below:</p>
								<select  name="country[]" class="js-example-basic-multiple" style="width: 100%;" multiple="multiple">
									@foreach($countries as $country)
										@if(isset($blcok_CountryName) && in_array($country->country_name, $blcok_CountryName))
											<option value="{{ $country->country_name }}" selected>{{ $country->country_name }}</option>
										@else
											<option value="{{ $country->country_name }}">{{ $country->country_name }}</option>
										@endif
										@endforeach
								 </select>
							</div> 
						</div>
					</div>
				</div>
			@endif

			<div class="clear"></div>

			<div class="row align-items-center mt-3 p-3"> 

				<div class="col-sm-4 p-0"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading">
							<div class="panel-title font-weight-bold"> <label class="m-0">Duration</label></div> 
							<div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
						</div> 
						<div class="panel-body"> 
							<p class="p1">Enter the duration in the (HH: MM : SS) format </p> 
							<input class="form-control" name="duration" id="duration" value="@if(!empty($series->duration)){{ gmdate('H:i:s', $series->duration) }}@endif" >
						</div> 
					</div>
				</div>

				<div class="col-sm-4"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> 
							<div class="panel-title font-weight-bold"> <label class="m-0">User Access</label></div>
						 	<div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
						</div> 
						<div class="panel-body"> 
							<p class="p1">Who is allowed to view this TV Shows?</p>
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
						<div class="panel-heading"> <div class="panel-title font-weight-bold"> <label class="m-0">Status Settings</label></div>
						  <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div>
						</div>

						<div class="panel-body"> 
							<div class="d-flex align-items-baseline">
								<label class="p2" for="featured" style="float:left; display:block; margin-right:10px;">Is this TV Shows Featured:</label>
								<input type="checkbox" @if(!empty($series->featured) && $series->featured == 1){{ 'checked="checked"' }}@endif name="featured" value="1" id="featured" />
							</div>
							<div class="clear"></div>

							<div class="d-flex align-items-baseline">
								<label class="p2" for="active" style="float:left; display:block; margin-right:10px;">Is this TV Shows Active:</label>
								<input type="checkbox" @if(!empty($series->active) && $series->active == 1){{ 'checked="checked"' }}@elseif(!isset($series->active)){{ 'checked="checked"' }}@endif name="active" value="1" id="active" />
							</div>

							<div class="d-flex align-items-baseline">
								<label class="p2" for="featured" style="float:left; display:block; margin-right:10px;">Enable this TV Shows as Slider:</label>
								<input type="checkbox" @if(!empty($series->banner) && $series->banner == 1){{ 'checked="checked"' }}@elseif(!isset($series->banner)){{ 'checked="checked"' }}@endif name="banner" value="1" id="banner" />
							</div>

									{{-- Trailer option --}}
							<div class="d-flex align-items-baseline">
								<label class="p2" for="active" style="float:left; display:block; margin-right:10px;">TV Shows Season Trailer:</label>
								<input type="checkbox" @if(!empty($series->series_trailer) && $series->series_trailer == 1){{ 'checked="checked"' }}@elseif(!isset($series->series_trailer)){{ 'checked="checked"' }}@endif name="series_trailer" value="1" id="series_trailer" />
							</div>

							@if( $button_text == "Add New Series" )

								<div class="row align-items-center season_trailer">
                                    <div class="col-md-3"><label class="p2" for="active" style="display:block; margin-right:10px;">Season 1 :</label></div>
                                    <div class="col-md-3"><input type="radio" name="season_trailer" value="1" > </div>
								</div>

							@elseif($button_text == "Update Series")

								@php
									$season_id = App\Series::Select('series_seasons.id','series.season_trailer','series.id as series_id')
												->Join('series_seasons','series_seasons.series_id','=','series.id')
												->where('series_id',@$series->id)
												->get();
								@endphp	

								<div class="row  season_trailer">
									@forelse ($season_id as $key => $item)
										<div class="col-md-5"><label class="p2" for="active" style="display:block; margin-right:10px;">Season {{ $key + 1 }} :</label></div>
										<div class="col-md-3 mt-2">	
											<input type="radio" name="season_trailer" value="{{ $item->id }}" @if( $item->id  == $series->season_trailer ) {{ 'checked' }} @endif  > 
										</div>
										
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
                    <input type="submit" value="{{ $button_text }}" class="btn btn-primary update_btn" />
                </div>
			</div><!-- row -->
        </div>
    </form>
</div>

		<div class="clear"></div>
		<!-- Manage Season -->
		@if(!empty($series->id))
		
		<div class="iq-card">
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
					<form name="new-cat-form" id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/season/create/') }}" onsubmit="return validateForm()" enctype="multipart/form-data" method="post">
						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
						<input type="hidden" name="series_id" value="<?= $series->id ?>" />

							<div class="form-group">
								<label>Season Title:</label>
								<input type="text" id="series_seasons_name" name="series_seasons_name" value="" placeholder="Enter the Season Title" class="form-control">
								<p class="text-danger" id="season_title_error" style="display: none;color:red !important;">*Please enter the Season Title.</p>
							</div>  

							<div class="form-group" >
								<label> Season Trailer :</label>
								<div class="new-video-file form_video-upload" style="position: relative;" >
								<input type="file" accept="video/mp4,video/x-m4v,video/*" name="trailer" id="trailer">
								<p style="font-size: 14px!important;height: 30%!important;">Drop and drag the video file</p>
								</div>
							</div>
						
							<div class="form-group">
								@php 
									$player_width = $compress_image_settings->width_validation_season;
									$player_heigth = $compress_image_settings->height_validation_season
								@endphp
								@if($player_width !== null && $player_heigth !== null)
									<p class="p1">{{ ("Select Season Thumbnail (".''.$player_width.' x '.$player_heigth.'px)')}}:</p> 
								@else
									<p class="p1">{{ "Select Season Thumbnail ( 1280x720px )"}}:</p> 
								@endif
								{{-- <label>Season Thumbnail <span>(16:9 Ratio or 1280X720px)</span></label><br> --}}
								<input type="file" class="season_image" name="image" id="season_img" accept="image/png, image/webp, image/jpeg">
								<p class="text-danger" id="season_img_error" style="display: none;color:red !important;">*Please upload the Season image.</p>
								<span>
									<p id="season_image_error_msg" style="color:red !important; display:none;">
										* Please upload an image with the correct dimensions.
									</p>
								</span>
							</div>
							@if(Enable_PPV_Plans() == 1)
								<div class="form-group">
									<label> Choose Episode Type:</label>
									<select class="form-control" id="series_seasons_type" name="series_seasons_type">
										<option value="">Choose Upload Type</option>
										<option value="VideoCipher" >VideoCipher Episode</option>
										<option value="m3u8">Episode Upload Url m3u8</option>
										<option value="videomp4">Episode Upload Url MP4</option>
										<option value="embed_video">Embed Episode</option>
									</select>
									<span class="ErrorText"> *User Access Series is set as Subscriber. </span>
								</div>
							@endif
						    <div class="form-group">
		                        <label> Choose User Access:</label>
								<select class="form-control" id="ppv_access" name="ppv_access">
									<option value="free" >Free (everyone)</option>
									@if($settings->series_season == 1)
										<option value="ppv" >PPV  (Pay Per Season(Episodes))</option>   
									@endif
								</select>
								<span class="ErrorText"> *User Access Series is set as Subscriber. </span>
                            </div>
                      
                            <div class="form-group" id="ppv_price">
								<label class="">PPV Price:</label>
								<input type="text" class="form-control" placeholder="PPV Price" name="ppv_price" id="price" value="@if(!empty($video->ppv_price)){{ $video->ppv_price }}@endif">
								<p class="text-danger" id="season_ppv_error" style="display: none;color:red !important;">*Please enter the PPV amount.</p>
							</div>  

							<div class="form-group" id="ppv_price_plan">
								<label class="m-0">PPV Price for 480 Plan:</label>
								<input type="text" class="form-control" placeholder="PPV Price" name="ppv_price_480p"  value="@if(!empty($video->ppv_price_480p)){{ $video->ppv_price_480p }}@endif">
								<span id="error_quality_ppv_price" style="color:red;">*Enter the 480 PPV Price </span>
									<br>
								<label class="m-0">PPV Price for 720 Plan:</label>
								<input type="text" class="form-control" placeholder="PPV Price" name="ppv_price_720p"  value="@if(!empty($video->ppv_price_720p)){{ $video->ppv_price_720p }}@endif">
								<span id="error_quality_ppv_price" style="color:red;">*Enter the 720 PPV Price </span>
								<br>

								<label class="m-0">PPV Price for 1080 Plan:</label>
								<input type="text" class="form-control" placeholder="PPV Price" name="ppv_price_1080p"  value="@if(!empty($video->ppv_price_1080p)){{ $video->ppv_price_1080p }}@endif">
								<span id="error_quality_ppv_price" style="color:red;">*Enter the 1080 PPV Price </span>
		                    </div>  

							<div class="form-group ios_ppv_price_old" id='ios_ppv_price_old' >
                        <label class="m-0">IOS PPV Price:</label>
                           <select  name="ios_ppv_price" class="form-control" id="ios_ppv_price">
                              <option value= "" >Select IOS PPV Price: </option>
                              @foreach($InappPurchase as $Inapp_Purchase)
                                 <option value="{{ $Inapp_Purchase->product_id }}"  >{{ $Inapp_Purchase->plan_price }}</option>
                              @endforeach
                           </select>
								<p class="text-danger" id="season_ios_ppv_error" style="display: none;color:red !important;">*This field is required.</p>
                     </div>

						<div class="form-group ios_ppv_price_plan" id='ios_ppv_price_plan'>
							<div class="form-group" >
								<label class="m-0">IOS PPV Price for 480 Plan:</label>
								<select  name="ios_ppv_price_480p" class="form-control" id="ios_ppv_price_480p">
									<option value= "" >Select 480 IOS PPV Price: </option>
									@foreach($InappPurchase as $Inapp_Purchase)
										<option value="{{ $Inapp_Purchase->product_id }}" >{{ $Inapp_Purchase->plan_price }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group" >
								<label class="m-0">IOS PPV Price for 720 Plan:</label>
								<select  name="ios_ppv_price_720p" class="form-control" id="ios_ppv_price_720p">
									<option value= "" >Select 720 IOS PPV Price: </option>
									@foreach($InappPurchase as $Inapp_Purchase)
										<option value="{{ $Inapp_Purchase->product_id }}" >{{ $Inapp_Purchase->plan_price }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group" >
								<label class="m-0">IOS PPV Price for 1080 Plan:</label>
								<select  name="ios_ppv_price_1080p" class="form-control" id="ios_ppv_price_1080p">
									<option value= "" >Select 1080 IOS PPV Price: </option>
									@foreach($InappPurchase as $Inapp_Purchase)
										<option value="{{ $Inapp_Purchase->product_id }}" >{{ $Inapp_Purchase->plan_price }}</option>
									@endforeach
								</select>
							</div>
						</div>
						@if (Enable_videoCipher_Upload() == 0 && Enable_PPV_Plans() == 0)
							@if($settings->series_season == 1)
							<div class="form-group">
		                        <label>PPV Interval:</label>
								<p class="p1">Please Mention How Many Episodes are Free:</p>
		                        <input type="text" id="ppv_interval" name="ppv_interval" value="" class="form-control">
								<p class="text-danger" id="season_introvel_ppv_error" style="display: none;color:red !important;">*This field is required.</p>
							</div>  
							@endif      
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

<table class="table table-bordered genres-table" id="categorytbl">

		<tr class="table-header">
			<th>Seasons</th>
			<th>Episodes</th>
			<th>Access</th>
			<th>Operation</th>
			
			@foreach($seasons as $key=>$seasons_value)
			<tr id="{{ $seasons_value->id }}">
				<td valign="bottom"><p> {{ optional($seasons_value)->series_seasons_name }}</p></td>
				<td valign="bottom">
					<p>{{ $seasons_value->total_episode }} Episodes <br>
						<span style="color:green;font-size:12px;">Active: {{ $seasons_value->active_episode }}</span>, <span style="color: red;font-size:12px;"> Draft:{{ $seasons_value->draft_episodes }}</span>
					</p></td>
				<td valign="bottom"><p>{{ $seasons_value->access }}</p></td>
				<td>
					<p>
						<a href="{{ URL::to('admin/season/edit') . '/' . $series->id. '/' . $seasons_value->id }}" class="btn btn-xs btn-black"><span class="fa fa-edit"></span> Manage Episodes</a>
						<a href="{{ URL::to('admin/season/edit') . '/' . $seasons_value->id }}" class="btn btn-xs btn-black"><span class="fa fa-edit"></span> Edit Season</a>
						<a href="{{ URL::to('admin/season/delete') . '/' . $seasons_value->id }}" class="btn btn-xs btn-white delete" onclick="return confirm('Are you sure?')" ><span class="fa fa-trash"></span> Delete</a>
					</p>
				</td>
			</tr>
			@endforeach
	</table>

            </div>
			@if(!empty($unassigned_episodes->toArray()))
				<div class="unassigned_episodes">
					@if(!empty($seasons->toArray()))
					<p>We found some unassigned episodes <span class="text-primary" data-toggle="modal" data-target="#unassignedepisodes" style="cursor: pointer;">Click here to assign now.</span></p>
					@else
						<p>We found some unassigned episodes <span class="text-primary" onclick="jQuery('#add-new').modal('show');" style="cursor: pointer;">Create a season to assign now.</span></p>
					@endif
				</div>

				<div class="modal fade" id="unassignedepisodes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
					  <div class="modal-content">
						<div class="modal-header" style="border-bottom: none;">
						  <h5 class="modal-title" id="exampleModalLongTitle">Unassigned Episodes</h5>
						  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						  </button>
						</div>
						<div class="modal-body">
						  <div class="row">
							<div class="col-12">
								<div class="episodes-details">
									<table class="table">
										<thead>
										  <tr>
											<th scope="col" class="text-center">Episode ID</th>
											<th scope="col" class="text-center">Episode Name</th>
											<th scope="col" class="text-center">Season</th>
										  </tr>
										</thead>
										<tbody>
											<form id="assigning_episodes" method="POST" action="{{ route('season.unassigned_episodes') }}">
												@csrf
												@foreach($unassigned_episodes as $item)
													<tr>
														<th scope="row" class="text-center">
															{{$item->id}}
															<input type="hidden" name="episodes[{{ $loop->index }}][id]" value="{{ $item->id }}">
														</th>
														<td class="text-center">{{$item->title}}</td>
														<td class="text-center">
															<select name="episodes[{{ $loop->index }}][season_id]" class="form-select" aria-label="Default select example">
																<option value="{{ $item->season_id }}" selected>{{ optional($item)->season->series_seasons_name ?? 'Select season' }}</option>
																@foreach($seasons as $seasons_value)
																	<option value="{{ optional($seasons_value)->id }}">
																		{{ optional($seasons_value)->series_seasons_name }}
																	</option>
																@endforeach
															</select>
														</td>
													</tr>
												@endforeach
											</form>
										</tbody>
									  </table>
								</div>
							</div>
						  </div>
						</div>
						<div class="modal-footer">
						  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						  <button type="button" class="btn btn-primary" id="submit-assigning-episodes">Save changes</button>
						</div>
					  </div>
					</div>
				</div>


			@endif

		<div class="clear"></div>

		@if(session('success'))
			<script>
				console.log('SweetAlert is being triggered!');
				Swal.fire({
					icon: 'success',
					title: 'Success',
					text: '{{ session('success') }}',
					confirmButtonText: 'OK'
				});
			</script>
		@endif

		</div>
		</div>
		@endif
<!-- This is where now -->
</div>
<script src="<?= URL::to('/assets/js/jquery.mask.min.js');?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<script>
	$(document).ready(function(){
		$('#submit-assigning-episodes').click(function(){
			console.log('un assinged episodes submit form');
			$('#assigning_episodes').submit();
		});
	});
</script>

<script type="text/javascript">
   $ = jQuery;
   $(document).ready(function($){
    $("#duration").mask("00:00:00");
   });
   


		$(document).ready(function(){

			$('#title_error').hide();
			$('#ppv_price').hide();
			$('#ios_ppv_price_old').hide();
			$('#ios_ppv_price').hide();
			$('#ios_ppv_price_plan').hide();
			$('#ppv_price_plan').hide();

			var enable_ppv_plans = '<?= @$theme_settings->enable_ppv_plans ?>';
			var enable_video_cipher_upload = '<?= @$theme_settings->enable_video_cipher_upload ?>';
			var transcoding_access = '<?= @$settings->transcoding_access ?>';

			$('#access').change(function(){
				var series_seasons_type = $('#series_seasons_type').val();
		
				if($('#access').val() == "ppv"){
					$('#ppv_price').show();
					$('#ppv_price_plan').hide();
				}

			});

			$(document).ready(function () {
				$('.ErrorText').hide();
				$('#ppv_access').change(function () {
					var series_seasons_type = $('#series_seasons_type').val();
					var series_access = '<?= @$series->access ?>';
					if(enable_ppv_plans == 1 && enable_video_cipher_upload == 1 && series_seasons_type == 'VideoCipher'){
						if ($('#ppv_access').val() == "ppv") {
							$('#ppv_price').hide();
							$('#ppv_price_plan').show();
							$('.ErrorText').hide();
							$('#submit-new-cat').prop('disabled', false);
							$('#ios_ppv_price_old').hide();
							$('#ios_ppv_price_plan').show();
						} else {
							$('#submit-new-cat').prop('disabled', false);
							$('#ppv_price_plan').hide();
							$('.ErrorText').hide();
							$('#ios_ppv_price_plan').hide();
							$('#ios_ppv_price_old').hide();
						}
					}else{
						if (series_access == 'subscriber' && $('#ppv_access').val() == "ppv") {
							$('#ppv_price').hide();
							$('.ErrorText').show();
							$('#ios_ppv_price_plan').hide();
							$('#submit-new-cat').prop('disabled', true);
							$('#ppv_price_plan').hide();
						} else {
							$('#submit-new-cat').prop('disabled', false);
							$('.ErrorText').hide();
							$('#ios_ppv_price_plan').hide();
							$('#ppv_price_plan').hide();
						}
					}	
				});


			});
		$('#titles').change(function(){
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
    	
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
<script>
         ClassicEditor
            .create( document.querySelector( '#summary-ckeditor' ) )
            .catch( error => {
                console.error( error );
            } );

         ClassicEditor
            .create( document.querySelector( '#description' ) )
            .catch( error => {
                console.error( error );
            } );
			</script>

<script>


$('#ppv_access').change(function(){

		if($(this).val() == "ppv"){
			$('#ppv_price').show();
			$('#ios_ppv_price').show();
			$('#ios_ppv_price_old').show();
		}else{
			$('#ppv_price').hide();
			$('#ios_ppv_price').hide();
			$('#ios_ppv_price_old').hide();
	}
});

$('#submit-new-cat').click(function(){
	$('#new-cat-form').submit();
});
</script>

@section('javascript')

{{-- field validation --}}
<script>
	function validateForm() {

		var enable_ppv_plans = '<?= @$theme_settings->enable_ppv_plans ?>';
		var enable_video_cipher_upload = '<?= @$theme_settings->enable_video_cipher_upload ?>';
		
		let title = document.forms["new-cat-form"]["series_seasons_name"].value;
		
        let seasonImage = document.forms["new-cat-form"]["image"].files.length;
		var ppvAccess = $('#ppv_access').val();
		
        let isValid = true;

		if (title == "") {
            document.getElementById("season_title_error").style.display = "block";
            isValid = false;
        }
		else{
            document.getElementById("season_title_error").style.display = "none";
		}

        if (seasonImage === 0) {
            document.getElementById("season_img_error").style.display = "block";
            isValid = false;
        }
		else{
            document.getElementById("season_img_error").style.display = "none";
		}
		if(enable_ppv_plans == 0 && enable_video_cipher_upload == 0){

			let ppv = document.forms["new-cat-form"]["price"].value; 
			let ios_ppv = document.forms["new-cat-form"]["ios_ppv_price"].value; 
			let intravel = document.forms["new-cat-form"]["ppv_interval"].value; 

			if(ppvAccess === "ppv"){
				if (ppv == "") {
					document.getElementById("season_ppv_error").style.display = "block";
					isValid = false;
				}
				else{
					document.getElementById("season_ppv_error").style.display = "none";
				}
					if (ios_ppv == "") {
						document.getElementById("season_ios_ppv_error").style.display = "block";
						isValid = false;
					}
					else{
						document.getElementById("season_ios_ppv_error").style.display = "none";
					}
					if (intravel == "") {
						document.getElementById("season_introvel_ppv_error").style.display = "block";
						isValid = false;
					}
					else{
						document.getElementById("season_introvel_ppv_error").style.display = "none";
					}
				}
			}

        return isValid;
	}
</script>


{{-- image validation --}}


<script>
	$(document).ready(function(){
	   
	
		  $('#series_image').on('change', function(event) {
	
	
				var file = this.files[0];
				var tmpImg = new Image();
	
				tmpImg.src=window.URL.createObjectURL( file ); 
				tmpImg.onload = function() {
				   width = tmpImg.naturalWidth,
				   height = tmpImg.naturalHeight;
				   image_validation_status = "{{  image_validation_series() }}" ;
				   console.log('img width: ' + width);
				   var validWidth = {{ $compress_image_settings->width_validation_series ?: 720 }};
				   var validHeight = {{ $compress_image_settings->height_validation_series ?: 1280 }};
				   console.log('validation widtth:  ' + validWidth);
	
				   if (width !== validWidth || height !== validHeight) {
						 document.getElementById('video_image_error_msg').style.display = 'block';
						 $('.update_btn').prop('disabled', true);
						 document.getElementById('video_image_error_msg').innerText = 
							`* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
					  } else {
						 document.getElementById('video_image_error_msg').style.display = 'none';
						 $('.update_btn').prop('disabled', false);
					  }
				}
		  });
		 
			$('#series_player_image').on('change', function(event) {
		
				var file = this.files[0];
				var player_Img = new Image();
		
				player_Img.src=window.URL.createObjectURL( file ); 
				player_Img.onload = function() {
				var width = player_Img.naturalWidth;
				var height = player_Img.naturalHeight;
				image_validation_status = "{{  image_validation_series() }}" ;
				console.log('player width ' + width)
		
				var valid_player_Width = {{ $compress_image_settings->series_player_img_width ?: 1280 }};
				var valid_player_Height = {{ $compress_image_settings->series_player_img_height ?: 720 }};
				console.log(valid_player_Width + 'player width');
		
				if (width !== valid_player_Width || height !== valid_player_Height) {
					document.getElementById('player_image_error_msg').style.display = 'block';
					$('.update_btn').prop('disabled', true);
					document.getElementById('player_image_error_msg').innerText = 
						`* Please upload an image with the correct dimensions (${valid_player_Width}x${valid_player_Height}px).`;
				} else {
					document.getElementById('player_image_error_msg').style.display = 'none';
					$('.update_btn').prop('disabled', false);
				}
				}
			});

			$('#season_img').on('change', function(event) {
		
				var file = this.files[0];
				var player_Img = new Image();

				player_Img.src=window.URL.createObjectURL( file ); 
				player_Img.onload = function() {
				var width = player_Img.naturalWidth;
				var height = player_Img.naturalHeight;
				image_validation_status = "{{  image_validation_series() }}" ;
				console.log('upd img width ' + width)

				var valid_player_Width = {{ $compress_image_settings->width_validation_season ?: 1280 }};
				var valid_player_Height = {{ $compress_image_settings->height_validation_season ?: 720 }};
				console.log('validation_player_Width' + valid_player_Width);

				if (width !== valid_player_Width || height !== valid_player_Height) {
					document.getElementById('season_image_error_msg').style.display = 'block';
					$('.submit-new-cat').prop('disabled', true);
					document.getElementById('season_image_error_msg').innerText = 
						`* Please upload an image with the correct dimensions (${valid_player_Width}x${valid_player_Height}px).`;
				} else {
					document.getElementById('season_image_error_msg').style.display = 'none';
					$('.submit-new-cat').prop('disabled', false);
				}
				}
			});
	   });
	
</script>
<script>
	// document.addEventListener('DOMContentLoaded', function() {
		// document.getElementById('series_image').addEventListener('change', function() {
		// 	var file = this.files[0];
		// 	if (file) {
		// 		var img = new Image();
		// 		img.onload = function() {
		// 			var width = img.width;
		// 			var height = img.height;
		// 			console.log(width);
		// 			console.log(height);
	
		// 			var validWidth = {{ $compress_image_settings->width_validation_series }};
		// 			var validHeight = {{ $compress_image_settings->height_validation_series }};
		// 			console.log(validWidth);
		// 			console.log(validHeight);
	
		// 			if (width !== validWidth || height !== validHeight) {
		// 				document.getElementById('video_image_error_msg').style.display = 'block';
		// 				$('.update_btn').prop('disabled', true);
		// 				document.getElementById('video_image_error_msg').innerText =
		// 					`* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
		// 			} else {
		// 				document.getElementById('video_image_error_msg').style.display = 'none';
		// 				$('.update_btn').prop('disabled', false);
		// 			}
		// 		};
		// 		img.src = URL.createObjectURL(file);
		// 	}
		// });
	
		// document.getElementById('series_player_image').addEventListener('change', function() {
		// 	var file = this.files[0];
		// 	if (file) {
		// 		var img = new Image();
		// 		img.onload = function() {
		// 			var width = img.width;
		// 			var height = img.height;
		// 			console.log(width);
		// 			console.log(height);
	
		// 			var validWidth = {{ $compress_image_settings->series_player_img_width }};
		// 			var validHeight = {{ $compress_image_settings->series_player_img_height }};
		// 			console.log(validWidth);
		// 			console.log(validHeight);
	
		// 			if (width !== validWidth || height !== validHeight) {
		// 				document.getElementById('player_image_error_msg').style.display = 'block';
		// 				$('.update_btn').prop('disabled', true);
		// 				document.getElementById('player_image_error_msg').innerText =
		// 					`* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
		// 			} else {
		// 				document.getElementById('player_image_error_msg').style.display = 'none';
		// 				$('.update_btn').prop('disabled', false);
		// 			}
		// 		};
		// 		img.src = URL.createObjectURL(file);
		// 	}
		// });
	
	// 	document.getElementById('season_img').addEventListener('change', function() {
	// 		var file = this.files[0];
	// 		if (file) {
	// 			var img = new Image();
	// 			img.onload = function() {
	// 				var width = img.width;
	// 				var height = img.height;
	// 				console.log(width);
	// 				console.log(height);
	
	// 				var validWidth = {{ $compress_image_settings->width_validation_season }};
	// 				var validHeight = {{ $compress_image_settings->height_validation_season }};
	// 				console.log(validWidth);
	// 				console.log(validHeight);
	
	// 				if (width !== validWidth || height !== validHeight) {
	// 					document.getElementById('season_image_error_msg').style.display = 'block';
	// 					$('#submit-new-cat').prop('disabled', true);
	// 					document.getElementById('season_image_error_msg').innerText =
	// 						`* Please upload an image with the correct dimensions (${validWidth}x${validHeight}px).`;
	// 				} else {
	// 					document.getElementById('season_image_error_msg').style.display = 'none';
	// 					$('#submit-new-cat').prop('disabled', false);
	// 				}
	// 			};
	// 			img.src = URL.createObjectURL(file);
	// 		}
	// 	});
	// });
	</script>
	

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		
        <script type="text/javascript">
			$(function () {
				$("#categorytbl").sortable({
					items: 'tr:not(tr:first-child)',
					cursor: 'pointer',
					axis: 'y',
					dropOnEmpty: false,
					start: function (e, ui) {
						ui.item.addClass("selected");
					},
					stop: function (e, ui) {
						ui.item.removeClass("selected");
						var selectedData = new Array();
						$(this).find("tr").each(function (index) {
							if (index > 0) {
								$(this).find("td").eq(2).html(index);
								selectedData.push($(this).attr("id"));
							}
						});
						updateOrder(selectedData)
					}
				});
			});

			function updateOrder(data) {
				
				$.ajax({
					url:'<?= URL::to('admin/Series_Season_order');?>',
					type:'post',
					data:{position:data, _token : '{{ csrf_token() }}'},
					success:function(){
						alert('Position changed successfully.');
						location.reload();
					}
				})
			}
		</script>


<script>

// 

		// Season Image upload dimention validation
		// $.validator.addMethod('season_dimention', function(value, element, param) {
		// 		if(element.files.length == 0){
		// 			return true; 
		// 		}

		// 		var width = $(element).data('imageWidth');
		// 		var height = $(element).data('imageHeight');
		// 		var ratio = $(element).data('imageratio');
		// 		var image_validation_status = "{{  image_validation_season() }}" ;

		// 		if( image_validation_status == "0" || ratio == '1.78'|| width == param[0] && height == param[1]){
		// 			return true;
		// 		}else{
		// 			return false;
		// 		}
		// 	},'Please upload an image with 1280X720px  pixels dimension or 16:9 Ratio ');


		// 	// Image upload dimention validation
		// $.validator.addMethod('Series_Image_dimention', function(value, element, param) {
        //     if(element.files.length == 0){
        //         return true; 
        //     }

        //     var width = $(element).data('imageWidth');
        //     var height = $(element).data('imageHeight');
        //     var ratio = $(element).data('imageratio');
        //     var image_validation_status = "{{  image_validation_series() }}" ;

        //     if( image_validation_status == "0" || ratio == '0.56'|| width == param[0] && height == param[1]){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // },'Please upload an image with 1080 x 1920 pixels dimension or 9:16 Ratio ');


        //         // player Image upload validation
        // $.validator.addMethod('player_dimention', function(value, element, param) {
        //     if(element.files.length == 0){
        //         return true; 
        //     }

        //     var width = $(element).data('imageWidth');
        //     var height = $(element).data('imageHeight');
        //     var ratio = $(element).data('imageratio');
        //     var image_validation_status = "{{  image_validation_series() }}" ;

        //     if( image_validation_status == "0" || ratio == '1.78'|| width == param[0] && height == param[1]){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // },'Please upload an image with 1280 x 720 pixels dimension or 16:9 Ratio' );


		// $('.series_image').change(function() {

		// 	$('.series_image').removeData('imageWidth');
		// 	$('.series_image').removeData('imageHeight');
		// 	$('.series_image').removeData('imageratio');

		// 	var file = this.files[0];
		// 	var tmpImg = new Image();

		// 	tmpImg.src=window.URL.createObjectURL( file ); 
		// 	tmpImg.onload = function() {
		// 		width = tmpImg.naturalWidth,
		// 		height = tmpImg.naturalHeight;
		// 		ratio =  Number(width/height).toFixed(2) ;
		// 		$('.series_image').data('imageWidth', width);
		// 		$('.series_image').data('imageHeight', height);
		// 		$('.series_image').data('imageratio', ratio);

		// 	}
		// });


        // $('.season_image').change(function() {

        //     $('.season_image').removeData('imageWidth');
        //     $('.season_image').removeData('imageHeight');
        //     $('.season_image').removeData('imageratio');

        //     var file = this.files[0];
        //     var tmpImg = new Image();

        //     tmpImg.src=window.URL.createObjectURL( file ); 
        //     tmpImg.onload = function() {
        //         width = tmpImg.naturalWidth,
        //         height = tmpImg.naturalHeight;
		// 		ratio =  Number(width/height).toFixed(2) ;
        //         $('.season_image').data('imageWidth', width);
        //         $('.season_image').data('imageHeight', height);
        //         $('.season_image').data('imageratio', ratio);
        //     }
        // });

        // $('#player_image').change(function() {

        //     $('#player_image').removeData('imageWidth');
        //     $('#player_image').removeData('imageHeight');
        //     $('#player_image').removeData('imageratio');

        //     var file = this.files[0];
        //     var tmpImg = new Image();

        //     tmpImg.src=window.URL.createObjectURL( file ); 
        //     tmpImg.onload = function() {
        //         width = tmpImg.naturalWidth,
        //         height = tmpImg.naturalHeight;
		// 		ratio =  Number(width/height).toFixed(2) ;
        //         $('#player_image').data('imageWidth', width);
        //         $('#player_image').data('imageHeight', height);
        //         $('#player_image').data('imageratio', ratio);
        //     }
        // });



		$('form[id="series_form"]').validate({
			rules: {
				title: 'required',

				// 'language[]': {
				// 			required: true
				// },

				image: {
					required: '#check_image:blank',
					Series_Image_dimention:[1080,1920]
				},
				
				player_image: {
					required: '#player_check_image:blank',
					player_dimention:[1280,720]
            	},
			},
			
			messages: {
				title: 'This field is required',
			},
			submitHandler: function(form) {
				form.submit();
			}
		});


$('form[id="new-cat-form"]').validate({
	rules: {
		image: {
				required:true,
				season_dimention:[1280,720]
			},
		series_seasons_name: {
			required:true,
		},
	},
	messages: {
		trailer: 'This field is required',
	},
	submitHandler: function(form) {
	  form.submit();
	}
  });
</script>

{{-- Search Tag --}}

<script>

	(function() {

        "use strict"

        // Plugin Constructor
        var TagsInput = function(opts) {
            this.options = Object.assign(TagsInput.defaults, opts);
            this.init();
        }

        // Initialize the plugin
        TagsInput.prototype.init = function(opts) {
            this.options = opts ? Object.assign(this.options, opts) : this.options;

            if (this.initialized)
                this.destroy();

            if (!(this.orignal_input = document.getElementById(this.options.selector))) {
                console.error("tags-input couldn't find an element with the specified ID");
                return this;
            }

            this.arr = [];
            this.wrapper = document.createElement('div');
            this.input = document.createElement('input');
            init(this);
            initEvents(this);

            this.initialized = true;
            return this;
        }

        // Add Tags
        TagsInput.prototype.addTag = function(string) {

            if (this.anyErrors(string))
                return;

            this.arr.push(string);
            var tagInput = this;

            var tag = document.createElement('span');
            tag.className = this.options.tagClass;
            tag.innerText = string;

            var closeIcon = document.createElement('a');
            closeIcon.innerHTML = '&times;';

            // delete the tag when icon is clicked
            closeIcon.addEventListener('click', function(e) {
                e.preventDefault();
                var tag = this.parentNode;

                for (var i = 0; i < tagInput.wrapper.childNodes.length; i++) {
                    if (tagInput.wrapper.childNodes[i] == tag)
                        tagInput.deleteTag(tag, i);
                }
            })

            tag.appendChild(closeIcon);
            this.wrapper.insertBefore(tag, this.input);
            this.orignal_input.value = this.arr.join(',');

            return this;
        }

        // Delete Tags
        TagsInput.prototype.deleteTag = function(tag, i) {
            tag.remove();
            this.arr.splice(i, 1);
            this.orignal_input.value = this.arr.join(',');
            return this;
        }

        // Make sure input string have no error with the plugin
        TagsInput.prototype.anyErrors = function(string) {
            if (this.options.max != null && this.arr.length >= this.options.max) {
                console.log('max tags limit reached');
                return true;
            }

            if (!this.options.duplicate && this.arr.indexOf(string) != -1) {
                console.log('duplicate found " ' + string + ' " ')
                return true;
            }

            return false;
        }

        // Add tags programmatically 
        TagsInput.prototype.addData = function(array) {
            var plugin = this;

            array.forEach(function(string) {
                plugin.addTag(string);
            })
            return this;
        }

        // Get the Input String
        TagsInput.prototype.getInputString = function() {
            return this.arr.join(',');
        }

        // Destroy the plugin
        TagsInput.prototype.destroy = function() {
            this.orignal_input.removeAttribute('hidden');

            delete this.orignal_input;
            var self = this;

            Object.keys(this).forEach(function(key) {
                if (self[key] instanceof HTMLElement)
                    self[key].remove();

                if (key != 'options')
                    delete self[key];
            });

            this.initialized = false;
        }

        // Private function to initialize the tag input plugin
        function init(tags) {
            tags.wrapper.append(tags.input);
            tags.wrapper.classList.add(tags.options.wrapperClass);
            tags.orignal_input.setAttribute('hidden', 'true');
            tags.orignal_input.parentNode.insertBefore(tags.wrapper, tags.orignal_input);
        }

        // initialize the Events
        function initEvents(tags) {
            tags.wrapper.addEventListener('click', function() {
                tags.input.focus();
            });

            tags.input.addEventListener('keydown', function(e) {
                if (!!(~[9, 13, 188].indexOf(e.keyCode))) {
                    e.preventDefault();
                    var str = tags.input.value.trim();
                    if (str == "") return;
                    str.split(",").forEach(function(tag) {
                        tags.addTag(tag.trim());
                    });
                    tags.input.value = "";
                }
            });
        }

        // Set All the Default Values
        TagsInput.defaults = {
            selector: '',
            wrapperClass: 'tags-input-wrapper',
            tagClass: 'tag',
            max: null,
            duplicate: false
        }

        window.TagsInput = TagsInput;

    })();

    var tagInput1 = new TagsInput({
        selector: 'tag-input1',
        duplicate: false,
        max: 10
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