@extends('admin.master')

@section('css')
@endsection

@section('content')

	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
			</div>
		</div>
	</div>
	<div class="clear"></div>

    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  
    <title>{{ config('app.name', 'File Manager') }}</title>
  
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <link href="{{ asset('public/vendor/file-manager/css/file-manager.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
<div id="content-page" class="content-page">
         <div class="container-fluid">
	<div class="admin-section-title">
    <div class="container">
        <!-- <h2>Laravel File Manager Tutorial Example - ItSolutionStuff.Com</h2> -->
        <div class="row">
            <div class="col-md-12" id="fm-main-block">
                <div id="fm"></div>
            </div>
        </div>
    </div>
    </div>
    </div>        </div>
    </div>
    <!-- File manager -->
    <script src="{{ asset('public/vendor/file-manager/js/file-manager.js') }}"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('fm-main-block').setAttribute('style', 'height:' + window.innerHeight + 'px');
  
        fm.$store.commit('fm/setFileCallBack', function(fileUrl) {
          window.opener.fmSetLink(fileUrl);
          window.close();
        });
      });
    </script>
</body>

        </div>
	</div>
</div>