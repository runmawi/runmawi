@extends('admin.master')
@section('content')
<?php
    //   echo "<pre>";  
    // print_r($moderators->user_role);
    // exit();
    ?>

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script src="category/videos/js/rolespermission.js"></script>


<div id="content-page" class="content-page">
         <div class="container-fluid">
              <div class="iq-card">

<div id="moderator-container">
<!-- This is where -->
	
	<div class="moderator-section-title">
		<h4><i class="entypo-globe"></i>Update Audio Category</h4> 
	</div>
	<div class="clear"></div>


                    <form method="POST" action="{{ URL::to('admin/audios/categories/update') }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
                        @csrf
                        <div class="container mt-4">
                        <div class="row justify-content-between">
                        <div class="col-md-5" >

                        <div class="form-group row">
                        <label>Name:</label>
                            <input type="text" id="name" name="name" value="{{ $categories[0]->name }}" class="form-control" placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="col-md-6" >

                        <div class="form-group row">
                        <label>Slug:</label>
                        <input type="text" id="slug" name="slug" value="{{ $categories[0]->slug }}" class="form-control" placeholder="Enter Slug">
                            </div>
                        </div>
                        </div>
                            <div class="row">
                        <div class="col-md-6" >

                        <div class="form-group row">
                        <label>Image:</label>
                        @if(!empty($categories[0]->image))
                        <img src="{{ URL::to('/audiocategory').'/'.$categories[0]->image }}" class="movie-img" width="200"/>
                        @endif
                        <p>Select the Category image (1280x720 px or 16:9 ratio):</p> 
                        <input type="file" multiple="true" class="form-control" name="image" id="image" />

                            </div>
                        </div>

                        <div class="col-md-6" >


                        <div class="form-group row">
                        <label>Category:</label>

                     
                            <select id="parent_id" name="parent_id" class="form-control">
                        	
                            <option value="0">Select</option>
                            @foreach($allCategories as $rows)
                                <option value="{{ $rows->id }}" @if ($rows->id == $categories[0]->parent_id) selected  @endif >{{ $rows->name }}</option>
                            @endforeach
                        </select>

                              
                        </div>
                        </div>
                            </div>
                    </div>
                    <br>
                    <div class="form-group row mb-0">
                        <div class="col-md-12 ">
                        <input type="hidden" name="id" id="id" value="{{ $categories[0]->id }}" />
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                    <button type="submit" id ="submit" class="btn btn-primary">
                                                        {{ __('Update') }}
                                                    </button>             
                                                           </div>
                    </div>
                </form>
            
                </div> 
        </div>

        </div>

    </div>
                    @endsection
                    <!-- //    display: flex; -->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="jquery-3.5.1.min.js"></script>

                    <script>
                   	$(document).ready(function(){
		$('#submit-update-cat').click(function(){
			$('#update-cat-form').submit();
		});
	});

                    </script>