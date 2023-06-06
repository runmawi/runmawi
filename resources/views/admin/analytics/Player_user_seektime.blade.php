@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">

@endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 

    <meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
    <div id="content-page" class="content-page">
        <div class="iq-card">
        <div class="col-md-12">
            <div class="iq-card-header  justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Player User Analytics :</h4>
                </div>
            </div>
             

                <div class="clear"></div>

                <form action="{{ URL::to('/admin/analytics/PlayerSeekUserTimeDateAnalytics') }}" method= "post">
                    <div class="row mt-3">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

                        <div class="col-md-4">
                            <label for="start_time">  Start Date: </label>
                            <input type="date"  value="{{ @$start_time }}" id="start_time" name="start_time" >               
                        </div>

                        <div class="col-md-4">
                            <label for="end_time">  End Date: </label>
                            <input type="date" id="end_time" value="{{ @$end_time }}" name="end_time">     
                        </div>
                        <div class="col-md-4">
                            <input type="submit" value="Show Result" class="btn btn-primary">
                        </div>
                    </div>

                </form>
                    <br>
                <div class="row mt-3">
                    
                    <div class="col-md-3">
                        <span  id="export" class="btn btn-primary" >Download CSV</span>
                    </div>
                    
                </div>

                <div class="clear"></div>
                            <br>
                <br>

                <!-- <h4 class="card-title">Player User SeekTime Graph :</h4> -->
                
                <div class="row">
                    <!-- <div class="col-md-6">
                    <div id="google-line-chart" style="width: 900px; height: 500px"></div>
                 </div> -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <a href="{{ URL::to('admin/analytics/PlayerUserAnalytics/')  }}">
                            <button class="tablinks btn btn-primary" id="openPayPerView" >Player User Analytics</button></a>
                    </div>
                 </div>
                 <br>
                        <div class="row" id="player_user">
                            <div class="col-md-12">
                                <table class="table text-center" id="player_table" style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>#</th>
                                            <!-- <th>User Name</th> -->
                                            <th>User Name</th>
                                            <th>Video Name</th>
                                            <th>Video Slug</th>
                                            <th>Seek Time</th>
                                            <th>Total Duration</th>
                                        </tr>
                                    </thead>
                                <tbody class='player_user'>
                                <tr>
                                    @foreach($PlayerSeekTimeAnalytic as $key => $playervideo)
                                        @if(gmdate("H:i:s", @$playervideo->SeekTime) != '00:00:00')
                                            <td>{{ $key+1  }}</td>   
                                            <td>{{ $playervideo->user_name  }}</td>   
                                            <td>{{ $playervideo->video_title  }}</td>  
                                            <td>{{ $playervideo->video_slug  }}</td>   
                                            <td><?= gmdate("H:i:s", @$playervideo->SeekTime) ?></td> 
                                            <td><?= gmdate("H:i:s", @$playervideo->duration) ?></td>   
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                           </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
    
@stop
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
         $(document).ready(function(){
            $('#player_table').DataTable();
         });

         
$.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
          $('#export').click(function(){
            var start_time =  $('#start_time').val();
            var end_time =  $('#end_time').val();
        var url = "{{ URL::to('admin/analytics/PlayerUserSeekTime_export/')  }}";

            $.ajax({
            url: url,
            type: "post",
                data: {
                _token: '{{ csrf_token() }}',
                start_time: start_time,
                end_time: end_time,

                },      
                success: function(data){
                var Excel = data ;
                var Excel_url =  "{{ URL::to('public/uploads/csv/')  }}";
                var link_url = Excel_url+'/'+Excel;
                $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Downloaded User CSV File </div>');
                            setTimeout(function() {
                                $('.add_watch').slideUp('fast');
                            }, 3000);

                location.href = link_url;
            }
            });
        });
    });

</script>
