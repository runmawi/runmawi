<!-- Page Create on 01/06/2022 -->


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


@section('content')
    <div id="content-page" class="content-page">
        <div class="iq-card">
        <div class="col-md-12">
            <div class="iq-card-header  justify-content-between">
                <div class="row">

                    <div class="col-7">
                        <div class="iq-header-title">
                            <h4 class="card-title">Content Analytics :</h4>
                        </div>
                    </div>
                    <div class="col-5">
                        <form method="GET" action="{{ route('admin.content.analytics') }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="month_filter" id="month_filter" class="form-control">
                                        <option value="">All Months</option>
                                        @foreach (range(1, 12) as $month)
                                            <option value="{{ $month }}" {{ request('month_filter') == $month ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
             

                <div class="clear"></div>

                <div class="col-md-12">
                    <!-- <div class="row mt-3">
                        <div class="col-md-3">
                            <label for="start_time">  Start Date: </label>
                            <input type="date" id="start_time" name="start_time" style="background: rgba(250, 250, 250, 1);border-color: transparent;">               
                        </div>

                        <div class="col-md-3">
                            <label for="start_time">  End Date: </label>
                            <input type="date" id="end_time" name="end_time" style="background: rgba(250, 250, 250, 1);border-color: transparent;">     
                        </div>

                        <div class="col-md-6 d-flex align-items-end">
                            <span  id="export" class="btn btn-primary" >Download CSV</span>
                        </div>
                        <br>
                           
                    </div> -->
                </div>
                <h4 class="card-title">Movie PPV :</h4>

                <div class="row mt-4">
                            <div class="col-md-12">
                                <table class="table text-center" id="Video_PPV_table" style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>#</th>
                                            <th>Video ID</th>
                                            <th>Movie Title</th>
                                            <th>Count</th>
                                            <th>Total Amount</th>
                                            <th>Purchased Date</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                <tr>
                                    @foreach($videos_ppv_content as $key => $video_content)
                                        <td>{{ $key+1  }}</td>   
                                        <td>{{ $video_content->videoId  }}</td>  
                                        <td>{{ $video_content->title  }}</td>  
                                        <td>{{ $video_content->purchase_count  }}</td>   
                                        <td>{{ $video_content->total_amount  }}</td>  
                                        <td>
                                        @php
                                            $date=date_create($video_content->ppvcreated_at);
                                            $newDate = date_format($date,"d M Y");
                                        @endphp
                                         {{ $newDate }}
                                        </td>   
                                       
                                        </tr>
                                    @endforeach
                                </tbody>
                           </table>

                        <br>

                                                
                                <h4 class="card-title">Series PPV :</h4>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <table class="table text-center" id="Series_PPV_table" style="width:100%">
                                            <thead>
                                                <tr class="r1">
                                                    <th>#</th>
                                                    <th>Tvshow ID</th>
                                                    <th>Tvshow Title</th>
                                                    <th>Count</th>
                                                    <th>Total Amount</th>
                                                    <th>Purchased Date</th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                        <tr>
                                            @foreach($series_ppv_content as $key => $series_content)
                                                <td>{{ $key+1  }}</td>   
                                                <td>{{ $series_content->seriesId  }}</td>  
                                                <td>{{ $series_content->title  }}</td>  
                                                <td>{{ $series_content->purchase_count  }}</td>   
                                                <td>{{ $series_content->total_amount  }}</td>   
                                                <td>
                                                @php
                                                    $date=date_create($series_content->ppvcreated_at);
                                                    $newDate = date_format($date,"d M Y");
                                                @endphp
                                                {{ $newDate }}
                                                </td>   
                                            
                                                </tr>
                                            @endforeach
                                        </tbody>
                                </table>


                                <br>

                                                                        
                        <h4 class="card-title">LiveStream PPV :</h4>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <table class="table text-center" id="LiveStream_PPV_table" style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>#</th>
                                            <th>LiveStream ID</th>
                                            <th>LiveStream Title</th>
                                            <th>Count</th>
                                            <th>Total Amount</th>
                                            <th>Purchased Date</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                <tr>
                                    @foreach($live_ppv_content as $key => $LiveStream_content)
                                        <td>{{ $key+1  }}</td>   
                                        <td>{{ $LiveStream_content->liveId  }}</td>  
                                        <td>{{ $LiveStream_content->title  }}</td>  
                                        <td>{{ $LiveStream_content->purchase_count  }}</td>   
                                        <td>{{ $LiveStream_content->total_amount  }}</td>   
                                        <td>
                                        @php
                                            $date=date_create($LiveStream_content->ppvcreated_at);
                                            $newDate = date_format($date,"d M Y");
                                        @endphp
                                        {{ $newDate }}
                                        </td>   
                                    
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>


                        <br>

                                                                        
                        <h4 class="card-title">Audio PPV :</h4>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <table class="table text-center" id="Audio_PPV_table" style="width:100%">
                                    <thead>
                                        <tr class="r1">
                                            <th>#</th>
                                            <th>Audio ID</th>
                                            <th>Audio Title</th>
                                            <th>Count</th>
                                            <th>Total Amount</th>
                                            <th>Purchased Date</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                <tr>
                                    @foreach($audio_ppv_content as $key => $Audio_content)
                                        <td>{{ $key+1  }}</td>   
                                        <td>{{ $Audio_content->audioId  }}</td>  
                                        <td>{{ $Audio_content->title  }}</td>  
                                        <td>{{ $Audio_content->purchase_count  }}</td>   
                                        <td>{{ $Audio_content->total_amount  }}</td>   
                                        <td>
                                        @php
                                            $date=date_create($Audio_content->ppvcreated_at);
                                            $newDate = date_format($date,"d M Y");
                                        @endphp
                                        {{ $newDate }}
                                        </td>   
                                    
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                        </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>

                <div class="clear"></div>
                <br>

                <!-- <h4 class="card-title">Purchased Content Graph :</h4>
                
                <div class="row">
                    <div class="col-md-6">
                    <div id="google-line-chart" style="width: 900px; height: 500px"></div>
                 </div> -->
                </div>
                       
            </div>
        </div>
    </div>
</div>
    
@stop
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
         $(document).ready(function(){
            $('#LiveStream_PPV_table').DataTable();
            $('#Video_PPV_table').DataTable();
            $('#Series_PPV_table').DataTable();
            $('#Audio_PPV_table').DataTable();
         });
</script>


</script>

    