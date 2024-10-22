<style>
    body{background-color:#000;color:#fff;font-family:Arial,sans-serif}
    .epg-container{padding:20px}
    .epg-header{display:flex;align-items:center;background-color:#1c1c1c;padding:15px;border-radius:8px}
    .epg-header img{width:120px;height:auto;border-radius:8px}
    .epg-info{margin-left:20px;flex-grow:1}
    .epg-info h2{font-size:24px;font-weight:700;margin-bottom:10px}
    .epg-info p{font-size:14px;color:#bbb}
    .epg-time{text-align:right;width:20%;position:relative;top:-25px}
    .epg-time span{font-size:12px;color:#f0f0f0}
    .epg-grid{margin-top:20px;background-color:#1c1c1c;border-radius:8px;padding:10px;height:50vh!important;overflow:overlay}
    .epg-timeline-container{overflow-x:auto;white-space:nowrap;position:relative;top:-37px}
    .epg-timeline{display:flex;justify-content:flex-start;padding:10px;color:#ccc;font-size:12px; position: relative;width:100%; white-space: nowrap;scroll-behavior: smooth;}
    .timeline{margin:0 10px}
    .epg-timeline div{flex:0 0 60px;text-align:center;}
    .epg-channels{width:16%;float:left;padding-right:10px}
    .epg-channels div{margin-bottom:10px;padding:10px;background-color:#333;border-radius:8px;height:75px}
    .epg-programs{overflow-x:auto;white-space:nowrap; padding-bottom: 20px;}
    .epg-program-row{display:flex;margin-bottom:10px}
    .epg-program{position:relative;color:#fff;text-align:center;line-height:75px; height: 75px; width: 100%;}
    .clearfix::after{content:"";display:table;clear:both}
    .epg-navigation{width:15%;height:38px;z-index:0;position:relative;overflow-x:auto;border-bottom:1px solid #555}
    .nav-arrow{background:grey;border:none;height:30px;margin-top:5px;margin-left:3px}
    .day-nav{margin:0 50px}
    .date-nav{gap:25px;white-space:nowrap;align-items:center;border-bottom:1px solid #555;background-color:#333;padding-left:20px}
    .epg-programs::-webkit-scrollbar,.epg-navigation::-webkit-scrollbar,.epg-grid::-webkit-scrollbar{display:none}
 
    .epg-arrow-buttons {
        display: flex;
        justify-content: space-between;
        position: absolute;
        left: 0;
        right: 0;
        z-index: 10;
        padding-bottom: 50px;
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
        margin: 5px 0;
    }

    
    .timeline {
        text-align: center;
        font-size: 12px;
        margin-bottom: 15px;
    }
</style>

@php
    $now = \Carbon\Carbon::now(); 
@endphp

<div class="epg-container">

    <div class="epg-header">
        <img src="{{ @$Livestream_details->Player_thumbnail }}" alt="Program Image">

        <div class="epg-info">
            <h2> {{ ucwords(@$Livestream_details->title) }} </h2>
            <p>  {!! html_entity_decode( @$Livestream_details->details) !!} </p>
        </div>
        
        <div class="epg-time">
            <span>{{ $now->toDayDateTimeString() }}</span>
        </div>
    </div>

    <div class="epg-grid clearfix">

        {{-- <div class="epg-navigation d-flex" style="overflow: auto;">
            <div class="date-nav d-flex">
                <div class="day-nav active">Today</div>
                <div class="day-nav">Tomorrow</div>
                <div class="day-nav">Day After Tomorrow</div>
            </div>
            <button class="nav-arrow" style="position: absolute;">&lt;</button>
            <button class="nav-arrow" style="left: 85%; position: absolute;">&gt;</button>
        </div> --}}

        <div class="epg-navigation ">
            <div class="date-nav">
                @for ($i = 0; $i < 7; $i++)

                    @php $day = $now->copy()->addDays($i); @endphp

                    <div class="day-nav" data-day="{{ $day->format('N') }}" data-date="{{ $now->format('Y-m-d\TH:i') }}" >
                        {{ $day->format('l') }} 
                    </div>
                @endfor
            </div>
        </div>

        <div class="epg-channels mt-2">
            <div class="epg-channel"> {{ ucwords(@$Livestream_details->title) }}</div>
        </div>

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