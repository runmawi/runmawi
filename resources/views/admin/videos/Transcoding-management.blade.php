@extends('admin.master')
@include('admin.favicon')
<!DOCTYPE html>
<html>
    <head>
        <!-- Meta -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- CSS -->
        <link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">

        <link rel="stylesheet" type="text/css" href="{{asset('dropzone/dist/min/dropzone.min.css')}}">

        <style>
            #content_videopage{height: 90%;}
            .page-title{font-weight: 600;font-size: 25px;}
            .content-of-page{padding: 0 2rem;}
            .content-of-page .transdatas{height: 70px;overflow: hidden;border-radius: 4px;}
            .transdatas p{margin-bottom: 0 !important;}
            .content-of-page .transdatas .col-2{height: 100%;}
            .translatedataheading{height: 60px;}
            .content-of-page .transdatas img{height: 100%;width: 100%;object-fit: contain;padding: 5px;}

            .transdatas:nth-child(even) {background-color: #f9f9f9;}
            .transdatas:nth-child(odd) {background-color: #ffffff;}
            .transdatas:hover {background-color: #ccc;}
        </style>
    </head>
    <body>
        @section('content')
            <div id="content_videopage" class="content-page">
                <div class="title-of-page">
                    <h4 class="text-primary page-title">{{ "Transcoding Management" }}</h4>
                </div>
                <div class="content-of-page mt-4">
                    @if((!empty($video)) && (!empty($episode)) && (!empty($failed_serieTrailer)))
                        <div class="row translatedataheading align-items-center">
                            <div class="col-1 d-flex justify-content-center align-items-center"><h6>{{ "Type" }}</h6></div>
                            <div class="col-2 d-flex justify-content-center align-items-center"><h6>{{ "Image" }}</h6></div>
                            <div class="col-6 d-flex justify-content-center align-items-center"><h6>{{ "Title" }}</h6></div>
                            <div class="col-2 d-flex justify-content-center align-items-center"><h6>{{ "Percentage" }}</h6></div>
                            <div class="col-1 d-flex justify-content-center align-items-center"><h6>{{ "Duration" }}</h6></div>
                        </div>
                    
                        @foreach($video as $data)
                            <div class="row transdatas">
                                <div class="col-1 d-flex justify-content-center align-items-center"><p>{{ "Video" }}</p></div>
                                <div class="col-2 d-flex justify-content-center align-items-center"><img src="{{ URL::to('public/uploads/images/'.$data->getVideo()->player_image) }}" alt="{{ $data->getVideo()->title ?? 'N/A' }}"></div>
                                <div class="col-6 d-flex justify-content-center align-items-center"><p>{{ $data->getVideo()->title ?? 'N/A' }}</p></div>
                                <div class="col-2 d-flex justify-content-center align-items-center"><p>@if(!empty($data->getVideo()->processed_low)){{ $data->getVideo()->processed_low.'%' }}@else{{ "Not started yet" }} @endif</p></div>
                                <div class="col-1 d-flex justify-content-center align-items-center">
                                    @php
                                        $durationInSeconds = $data->getVideo()->duration;
                                        $hours = str_pad(floor($durationInSeconds / 3600), 2, '0', STR_PAD_LEFT);
                                        $minutes = str_pad(floor(($durationInSeconds % 3600) / 60), 2, '0', STR_PAD_LEFT);
                                        $seconds = str_pad($durationInSeconds % 60, 2, '0', STR_PAD_LEFT);
                                    @endphp
                                    <p>{{ $hours }}:{{ $minutes }}:{{ $seconds }}</p>
                                </div>
                            </div>
                        @endforeach
                        @foreach($episode as $data)
                            <div class="row transdatas">
                                <div class="col-1 d-flex justify-content-center align-items-center"><p>{{"Episode"}}</p></div>
                                <div class="col-2 d-flex justify-content-center align-items-center"><img src="{{ URL::to('public/uploads/images/'.$data->getEpisode()->player_image) }}" alt="{{ $data->getEpisode()->title }}"></div>
                                <div class="col-6 d-flex justify-content-center align-items-center"><p>{{ $data->getEpisode()->title ?? 'N/A' }}</p></div>
                                <div class="col-2 d-flex justify-content-center align-items-center"><p>@if(!empty($data->getEpisode()->processed_low)){{ $data->getEpisode()->processed_low.'%' }}@else{{ "Not started yet" }} @endif</p></div>
                                <div class="col-1 d-flex justify-content-center align-items-center">
                                    @php
                                        $durationInSeconds = $data->getEpisode()->duration;
                                        $hours = str_pad(floor($durationInSeconds / 3600), 2, '0', STR_PAD_LEFT);
                                        $minutes = str_pad(floor(($durationInSeconds % 3600) / 60), 2, '0', STR_PAD_LEFT);
                                        $seconds = str_pad($durationInSeconds % 60, 2, '0', STR_PAD_LEFT);
                                    @endphp
                                    <p>{{ $hours }}:{{ $minutes }}:{{ $seconds }}</p>
                                </div>
                            </div>
                        @endforeach
                        @foreach($failed_serieTrailer as $data)
                            <div class="row transdatas">
                                <div class="col-1 d-flex justify-content-center align-items-center"><p>{{"Series Trailer"}}</p></div>
                                <div class="col-2 d-flex justify-content-center align-items-center"><img src="{{ $data->getSeries()->image }}" alt="{{ $data->getSeries()->series_seasons_name }}"></div>
                                <div class="col-6 d-flex justify-content-center align-items-center"><p>{{ $data->getSeries()->series_seasons_name ?? 'N/A' }}</p></div>
                                <div class="col-2 d-flex justify-content-center align-items-center"><p style="color:red !important;">Failed</p></div>
                                <div class="col-1 d-flex justify-content-center align-items-center">
                                    <p>00:07:04</p>
                                </div>
                            </div>
                        @endforeach
                    
                    @else
                            <div class="h-100 d-flex align-items-center justify-content-center">
                                <h6>{{ "There are currently no videos being transcoded!" }}</h6>
                            </div>
                    @endif
                </div>
            </div>






            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="{{ URL::to('/assets/admin/js/sweetalert.min.js') }}"></script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </body>
</html>

@stop