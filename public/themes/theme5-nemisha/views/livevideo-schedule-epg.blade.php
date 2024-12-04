<style>
    body{background-color:#000;color:#fff;font-family:Arial,sans-serif}
    .epg-header {display: flex; align-items: center; background-color: #1c1c1c; padding: 15px; border-radius: 8px; gap: 15px;}
    .epg-header img { width: 120px; height: auto; border-radius: 8px; flex-shrink: 0;}
    .epg-info { flex-grow: 1; flex-basis: 60%;}
    .epg-info h2 {font-size: 22px;font-weight: 700;margin: 0 0 10px;color: #ffffff;}
    .epg-info p {font-size: 14px;color: #bbb;margin: 0;line-height: 1.4;}
    .epg-time {flex-basis: 20%;text-align: right;align-self: flex-start;}
    .epg-time span {font-size: 12px;color: #f0f0f0;}
    .epg-left{width: 20%}
    .epg-right{width: 80%}

    @media (max-width: 768px) {
        .epg-header {flex-wrap: nowrap;flex-direction: row;align-items: flex-start;padding: 10px;}
        .epg-header img {width: 90px;}
        .epg-info {flex-grow: 1;flex-basis: auto;margin: 0 10px;}
        .epg-info h2 {font-size: 18px;}
        .epg-info p {font-size: 13px;}
        .epg-time {flex-basis: auto;text-align: left;font-size: 12px;}
        .epg-left{width: 30%}
        .epg-right{width: 70%}
    }
    @media (max-width: 480px) {
        .epg-header {flex-wrap: nowrap;flex-direction: row;gap: 10px;}
        .epg-header img {width: 70px;}
        .epg-info h2 {font-size: 16px;}
        .epg-info p {font-size: 12px;}
        .epg-time {text-align: left;font-size: 10px}
        .epg-left{width: 30%}
        .epg-right{width: 70%}
    }

    .epg-grid{margin-top:25px;background-color:#000;border-radius:8px;padding:10px;height:50vh!important;overflow:overlay}
    .epg-timeline-container{overflow-x:auto;white-space:nowrap;position:relative;top:-37px}
    .epg-timeline{display:flex;justify-content:flex-start;padding:10px;color:#ccc;font-size:12px; position: relative;width:100%; white-space: nowrap;scroll-behavior: smooth;}
    /* .timeline{margin:0 10px} */
    .epg-timeline div{flex:0 0 100px;text-align:center;}
    .epg-channels{padding-right:10px}
    .epg-channels div{margin-bottom:10px;padding:10px;background-color:#333;border-radius:8px;height:75px;text-align: center;}
    .epg-programs{overflow-x:auto;white-space:nowrap; padding-bottom: 20px;}
    .epg-program-row{display:flex;margin-bottom:10px}
    .epg-program{position:relative;color:#fff;text-align:center;line-height:75px; height: 75px; width: 100%;}
    .clearfix::after{content:"";display:table;clear:both}
    .epg-navigation{height:38px;z-index:0;position:relative;overflow-x:auto; background-color: #333;}
    .nav-arrow{background:grey;border:none;height:30px;margin-top:5px;margin-left:3px}
    .day-nav{margin:0 50px; cursor: pointer;}
    .date-nav{align-items:center;background-color:#333;padding:7px 0 0 0;display:flex;}
    .epg-programs::-webkit-scrollbar,.epg-navigation::-webkit-scrollbar,.epg-grid::-webkit-scrollbar{display:none}
    .epg-channel {width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis;max-width: 250px; display: inline-block; }

    /* .timeline-slot:last-child{border-left: 1px solid;} */
    .epg-arrow-buttons {
        display: flex;
        justify-content: space-between;
        position: absolute;
        left: 0;
        right: 0;
        z-index: 10;
        /* padding-bottom: 50px; */
        top: 20px;  
    }


    .timeline-slot {
        width: calc(100% / 96);
        flex-direction: column;
        align-items: center;
        position: relative;
    }


    .epg-timeline-container {
        position: relative;
    }


    .epg-program {
        position: relative;
        padding: 5px;
        /* margin: 5px 0; */
    }

    
    .timeline {
        text-align: center;
        font-size: 12px;
        color: white;
        padding: 12px 0px;
    }
    #data{margin: 0 20px;overflow: hidden;}
    .fa-chevron-right:before{font-size: 22px}
    .fa-chevron-left:before{font-size: 22px}
</style>

@php
    $now = \Carbon\Carbon::now(); 
@endphp

<div class="epg-container">

    <div class="epg-header m-1">
        <img src="{{ @$Livestream_details->Player_thumbnail }}" alt="Program Image">

        <div class="epg-info">
            <h2> {{ ucwords(@$Livestream_details->title) }} </h2>
            <p>  {!! html_entity_decode( @$Livestream_details->details) !!} </p>
        </div>
        
        <div class="epg-time">
            <span>{{ $now->toDayDateTimeString() }}</span>
        </div>
    </div>

    <div class="row epg-grid clearfix m-1">

        <div class="epg-left">


        <div class="epg-navigation ">
            <div class="date-nav">
                @for ($i = 0; $i < 7; $i++)
                    @php $day = $now->copy()->addDays($i); @endphp
                    <div class="day-nav" data-day="{{ $day->format('N') }}" data-date="{{ $day->format('Y-m-d\TH:i') }}" >
                        {{ $day->format('l') }} 
                    </div>
                @endfor
            </div>
        </div>

        <div class="epg-channels mt-2">
            <div class="epg-channel"> {{ ucwords(@$Livestream_details->title) }}</div>
        </div>
        </div>

        <div class="epg-right" style="margin-top:25px;">
        <div class="epg-timeline-container">
            <div class="epg-programs">

                <div class="epg-arrow-buttons">
                    <div class="left-arrow">
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    </div>
                    <div class="right-arrow">
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </div>
                </div>

                <div id="data">
                    {!! Theme::uses("{$current_theme}")->load("public/themes/{$current_theme}/views/livevideo-schedule-epg-partial",  
                    ['Livestream_details' => $Livestream_details ,'current_theme' => $current_theme, 'now' => $now])->content() !!}
                </div>

            </div>
        </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.day-nav').click(function() {
            var selectedDay = $(this).data('day'); 
            var selectedDate = $(this).data('date'); 
            $.ajax({
                url: "{{ route('livestream-fetch-timeline') }}", 
                type: "GET",
                data: {
                    day: selectedDay ,
                    date: selectedDate ,
                    publish_type  : "<?php echo $Livestream_details->publish_type ?>",
                    Livestream_id : "<?php echo $Livestream_details->id ?>"
                },
                success: function(response) {
                    $('#data').html(response);
                },
                error: function(xhr) {
                    console.log(xhr.responseText); 
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const leftArrow = document.querySelector('.left-arrow');
    const rightArrow = document.querySelector('.right-arrow');
    const timeSlots = document.querySelector('.epg-timeline');
    const programRows = document.querySelectorAll('.timeline-slot');

    let currentOffset = 0;
    const scrollAmount = 100;

    function getMaxScroll() {
        const timeSlotsWidth = timeSlots.scrollWidth;
        const wrapperWidth = timeSlots.parentElement.offsetWidth;
        return -(timeSlotsWidth - wrapperWidth);
    }

    function scrollEPG(offset) {
        const maxScroll = getMaxScroll();

        currentOffset += offset;

        if (currentOffset > 0) {
            currentOffset = 0;
        } else if (currentOffset < maxScroll) {
            currentOffset = maxScroll;
        }

        timeSlots.style.transition = 'transform 0.3s ease-in-out'; 
        timeSlots.style.transform = `translateX(${currentOffset}px)`;
        programRows.forEach(row => {
            row.style.transform = `translateX(${currentOffset}px)`;
        });
    }

    leftArrow.addEventListener('click', function () {
        scrollEPG(scrollAmount);
    });

    rightArrow.addEventListener('click', function () {
        scrollEPG(-scrollAmount);
    });
});
</script>