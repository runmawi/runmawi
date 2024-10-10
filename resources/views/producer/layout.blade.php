<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />

    <title> {{ GetWebsiteName() ." - Producer Page" }}</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ url('resources/views/producer/assets/materialize/css/materialize.css')}}" type="text/css" rel="stylesheet" media="screen,projection" />
    <link href="{{ url('resources/views/producer/assets/css/style.css') }}" type="text/css" rel="stylesheet" media="screen,projection" />
    <link href="{{ url('resources/views/producer/assets/materialize/css/materialize.min.css')}}" type="text/css" rel="stylesheet" media="screen,projection" />

    <!--  Scripts-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ url('resources/views/producer/assets/materialize/js/materialize.js') }}"></script>

    <script src="{{ url('resources/views/producer/assets/js/init.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-D7DFV3NKJ9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-D7DFV3NKJ9');
    </script>
</head>

<body>
    
    @include('producer.header')

    @include('producer.source-modal')

    <div class="container">
        <div class="section" id="div-main">
            @yield('producer.section')
        </div>
        <br><br>
    </div>

    @include('producer.footer')
</body>