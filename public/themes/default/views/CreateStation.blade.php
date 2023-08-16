@php
    include(public_path('themes/default/views/header.php'));
@endphp

<style>
    .error{
        color:red;
    }
    .artist{
        color:white;

    }
    select,.select2-results__option{
        color:black;

    }
</style>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>

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

<div id="content-page" class="content-page">
         <div class="container-fluid">
	<div class="">
          <div class="">
		<div class="row">
			<div class="col-md-12 text-center" >
				<h4 class="font-weight-bold"><i class="entypo-archive"></i> Create Station </h4>
			</div>
		</div>
<div class="row justify-content-center mt-4 mb-5">
    <div class="col-xl-8 col-lg-8">
        <div class="login-form">
            <form  id="station_form" method="POST" action="{{ URL::to('/station/store/') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="station_name" class="col-form-label text-md-right">{{ __('Station Name (country, hip hop, rock, etc.)') }}</label>
                            <input type="text" class="form-control @error('station_name') is-invalid @enderror" name="station_name"  autofocus>
                        </div>
                    </div>
                    
                    <!-- <div class="col-6">
                        <div class="form-group">
                            <label for="image" class="col-form-label text-md-right">{{ __('Station Image') }}</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" autofocus>
                        </div>
                    </div> -->
                <!-- </div>

                <div class="row"> -->

                    <div class="col-md-6">
                <label for="password" class="col-form-label text-md-right">{{ __('Station Type') }}</label>

                        <div class="form-group">
                            <input type="radio" class="text-white" value="artist"   id="artist"   name="station_type" checked="checked"> <span class='artist'> Choose By Artist</span> &nbsp;&nbsp;&nbsp;
                            <input type="radio" class="text-white" value="keyword"  id="keyword" name="station_type"> <span class='artist'> Choose By KeyWords</span>                
                        </div>
                        </div>
                        </div>
                        <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" id='based_artists'>
                        <label for="password" class="col-form-label text-md-right">{{ __('Station Based Artist') }}</label>

                            <select class="form-control js-example-basic-multiple"  multiple="multiple" id="station_based_artists" name="station_based_artists[]">
                            @foreach($Artists as $Artist)
                            <option  value="{{ $Artist->id }}" >{{ $Artist->artist_name }}</option>
                            @endforeach
                            </select>
                        </div>

                    <div class="form-group" id='based_keywords'>
                        <label for="password" class="col-form-label text-md-right">{{ __('Station Based Keywords') }}</label>

                            <select class="form-control js-example-basic-multiple"   multiple="multiple"  id="station_based_keywords" name="station_based_keywords[]">
                            @foreach($AudioCategory as $Category)
                            <option  value="{{ $Category->id }}" >{{ $Category->name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    </div>

                </div>
            
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Station Create') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
        </div>
             </div>
    </div>
@php
    include(public_path('themes/default/views/footer.blade.php'));
@endphp

<script>
    $(document).ready(function(){
        setTimeout(function() {
            $('#successMessage').fadeOut('fast');
        }, 3000);


       $('.js-example-basic-multiple').select2();

        $('#based_artists').show();
        $('#based_keywords').hide();

        $('#artist').click(function(){
            $('#based_artists').show();
            $('#based_keywords').hide();
        })
        $('#keyword').click(function(){
            $('#based_keywords').show();
            $('#based_artists').hide();
        })
    })
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    $('#station_form').validate({
        rules: {
            station_name: "required",
            station_type: "required",
        },
        messages: {
            station_name: "This field is required",
            station_type: "This field is required",
        },

        submitHandler: function (form) {
            form.submit();
        },
    });
});

</script>