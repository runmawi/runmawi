@extends('admin.master')

<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>


    <!-- calendar  -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ URL::to('assets/calendar/css/calendar.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/calendar/css/theme.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/calendar/css/spinner.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/calendar/css/style.css') }}">
    
    <?php
        $embed_url = URL::to('/schedule/videos/embed');
        $embed_media_url = $embed_url . '/' . $schedule->name;
        $url_path = '<iframe width="853" height="480" src="'.$embed_media_url.'" frameborder="0" allowfullscreen></iframe>';
        $media_url = URL::to('/schedule/videos').'/'.$schedule->name;
    ?>

@section('content')
    <div id="content-page" class="content-page">
        <div class="iq-card">
        <div class="col-md-12">
            <div class="iq-card-header  justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Video Schedule :</h4>
                </div>
            </div>
             

                <div class="clear"></div>
                <br>
                <h4 class="card-title"> </h4>

                <div class="row">
                <div class="col-3">
                    <label for=""><h4 class="fs-title m-0">{{ $schedule->name }}</h4></label>

                </div>
                <div class="col-3">
                <a href="#" onclick="EmbedCopy();" class="share-ico">
                        <!-- <label for=""><h3 class="fs-title m-0">Your IFRAME URL:</h3></label> -->
                        <!-- {{ $url_path }} -->
                        Click Here To Copy IFRAME URL
                        </a>
                        </div>
                    </div>
                    <!-- <div class="col-3">
                        <label for=""><h3 class="fs-title m-0">Embed Link:</h3></label>
                        <p>Click <a href="#" onclick="EmbedCopy();" class="share-ico"><i class="ri-links-fill"></i> here</a> to get the Embedded URL</p>
                        </div>
                    </div> -->
                <div class="row">
                    <div class="container py-5">
                    
                    <div id="calendar" class="bg-white"></div>
                
                </div>

            </div>
        </div>
    </div>
</div>
    
<input type="hidden" name="token" id= "token" value="{{ csrf_token() }}">
<input type="hidden" name="schedule_id" id= "schedule_id" value="{{ $schedule->id }}">
<input type="hidden" name="url" id= "url" value="{{ URL::to('admin/calendar/schedule')  }}">


@section('javascript')

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/js/all.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
  <script type="module" src="{{URL::to('assets/calendar/js/main.js') }}"></script>

  <script>
    
   function EmbedCopy() {
   // var media_path = $('#media_url').val();
   var media_path = '<?= $url_path ?>';
   var url =  navigator.clipboard.writeText(window.location.href);
   var path =  navigator.clipboard.writeText(media_path);
   $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Copied Embed URL</div>');
              setTimeout(function() {
               $('.add_watch').slideUp('fast');
              }, 3000);
   // console.log(url);
   // console.log(media_path);
   // console.log(path);
   }

  </script>
@stop

@stop

