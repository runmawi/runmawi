@extends('admin.master')

@include('admin.favicon')

@section('css')

<link rel="stylesheet" href="{{ URL::to('/assets/admin/css/sweetalert.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>


@section('content')

    <div id="content-page" class="content-page">
        <div class="iq-card" id="file_log_data">

            <div class="iq-header-title p-0">
                <h4>Deleted Logs</h4>
            </div>

            <div class="select-type col-lg-4 col-12 mt-3 pl-0">
                <select id="log-value" class="form-control" aria-label="Default select example">
                    {{-- <option value="3">Show All</option> --}}
                    <option selected value="1">Video</option>
                    <option value="2">Episode</option>
                </select>
            </div>

            <!-- Video Logs -->
            <div id="video-log" class="mt-5">
                @if(!empty($videoLogs->count() > 0))
                    <div class="iq-card-header justify-content-between">
                        <div class="iq-header-title text-center p-0">
                            <h6>Videos Deleted Logs</h6>
                        </div>
                    </div>
                    <div id="video-logs-container">
                        @include('admin.partials.video_delete_log_table')
                    </div>
                @else
                    <h6 class="text-center mt-3">There are no deleted video items. Please select Episode deleted items instead.</h6>
                    <div class="no-data-img" style="height: 200px;">
                        <img class="" src="<?php echo  URL::to('/assets/img/no-data.webp')?>" style="width: 100%;height:100%;object-fit:contain;">
                    </div>

                @endif
            </div>

            <!-- Episode Logs -->
            <div id="episode-log">
                @if(!empty($episodeLogs->count() > 0))
                    <div class="iq-card-header justify-content-between">
                        <div class="iq-header-title text-center p-0">
                            <h6>Episode Deleted Logs</h6>
                        </div>
                    </div>
                    <div id="episode-logs-container">
                        @include('admin.partials.episode_delete_log_table')
                    </div>
                @else
                    <h6 class="text-center mt-3">There are no deleted episode items. Please select Video deleted items instead.</h6>
                    <div class="no-data-img" style="height: 200px;">
                        <img class="" src="<?php echo  URL::to('/assets/img/no-data.webp')?>" style="width: 100%;height:100%;object-fit:contain;">
                    </div>

                @endif
            </div>

        </div> 
    </div> 

@stop

<script>
    $(document).ready(function(){
        console.log("select value: " + $('#log-value').val());
        
        $('#log-value').change(function(){
            let selectedValue = $(this).val();
            if (selectedValue == "1") {
                $('#episode-log').hide();
                $('#video-log').show();
            } else if (selectedValue == "2") {
                $('#episode-log').show();
                $('#video-log').hide();
            } else {
                $('#video-log').show();
                $('#episode-log').show();
            }
        });
    });
</script>


<script>

    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        let logType = $('#log-value').val() == "1" ? 'video' : 'episode';

        fetchPage(page, logType);
    });

    function fetchPage(page, logType) {
        $.ajax({
            url: "{{ route('deleted-logs') }}?page=" + page + "&type=" + logType,
            success: function(response) {
                console.log("res type: " + response.html);
                
                if (response.type === 'video') {
                    $('#video-logs-container').html(response.html);
                } else {
                    $('#episode-logs-container').html(response.html);
                }
            }
        });
    }
</script>


<style>
    #file_log_data thead {background-color: #e4ecfe;}
    #file_log_data .table thead th {font-size: 13px;}
    .table td, .table th{text-align: center;}
    #episode-log{display:none;}
    /* #episode-logs-table table{display:block !important;}
    .table-hover{display:none;} */
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
