@php
    include public_path('themes/theme5-nemisha/views/header.php');
@endphp

<style>
    .epg-container {
        display: flex;
        width: 100%;
        height: 500px;
        overflow: hidden;
        background-color: #1a1a1a;
        margin-top: 10px;
    }



    .epg-left {
        flex: 3;
        color: white;
    }

    .epg-channel-header {
        font-size: 24px;
        margin: 9px 0px;
        text-align: center;
    }

    .channel-name {
        margin-bottom: 2px;
        padding: 5px;
        font-size: 12px;
        color: white;
        background-color: #3c3c3c;
    }

    .epg-right {
        flex: 9;
        overflow-x: auto;
        position: relative;
        background-color: #2c2c2c;
    }

    .epg-time-slots {
        display: flex;
        justify-content: flex-start;
        padding: 12px;
        white-space: nowrap;
        width: max-content;
        /* Ensure the time slots expand based on content */
    }



    .epg-time-slot {
        padding: 5px 15px;
        white-space: nowrap;
        text-align: center;
        color: white;
        font-size: 14px;
        margin-right: 50px;
        /* Adjust margin to space out time slots */
    }

    .epg-time-slot:not(:last-child) {
        margin-right: 20px;
        /* Gap between time slots */
    }

    .left-arrow,
    .right-arrow {
        cursor: pointer;
        font-size: 20px;
        padding: 10px;
        color: white;
    }

    .left-arrow:hover,
    .right-arrow:hover {
        color: lightgray;
    }

    .epg-programs {
        display: grid;
        grid-template-columns: repeat(1440, 1fr);

        position: relative;
        padding: 2px 0;
    }

    .epg-show {
        background-color: #3c3c3c;
        color: white;
        text-align: center;
        padding: 3px;
        position: relative;
        height: 100%;
        margin: 0 2px;
        border-radius: 4px;
        border: #1a1a1a 2px solid;
        /* Rounded corners for program boxes */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.055);
        /* Add shadow for depth */
    }

    .program-title {
        white-space: nowrap;
        padding: 12px 20px;
    }
</style>

<div class="m-4">

    <div class="pb-2">
        <h1>GUIDE</h1>
        <h6>Antenna / today / All CH</h6>
    </div>
    <div class="row">
        <div class="col-3">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4bGIutSVn_5mYkrDJWjAiu8RoP4zdw069i8q1AjTV1j3JySgLTrZiBIyQjcfgB4X5bLM&usqp=CAU"
                alt="">
        </div>
        <div class="col-9 p-3" style="background-color: #1a1a1a;">
            <div class="d-flex row justify-content-between px-1">
                <h3>The Tree of Life Season 6 Episode 1</h3>
                <p>4 Mar, Fri 1:30 PM-2.30 PM</p>
            </div>
            <div class="text-white">
                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa ducimus eveniet doloremque cupiditate
                    sequi accusantium repudiandae, ipsum, nemo explicabo atque magnam esse dignissimos eum
                    exercitationem in officia architecto cum quaerat? </p>
            </div>
        </div>
    </div>

    <div class="epg-container">
        <div class="epg-left ">
            <div class="epg-channel-header">TODAY</div>

            @foreach ($programs as $program)
                <div class="channel-name mx-auto">
                    <div class="col text-white">
                        <div class="d-flex row justify-content-between">
                            <div>
                                Radio Station {{ $program['id'] }}
                            </div>
                        </div>
                        <div class="d-flex row justify-content-between">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-mic-fill" viewBox="0 0 16 16">
                                    <path d="M5 3a3 3 0 0 1 6 0v5a3 3 0 0 1-6 0z" />
                                    <path
                                        d="M3.5 6.5A.5.5 0 0 1 4 7v1a4 4 0 0 0 8 0V7a.5.5 0 0 1 1 0v1a5 5 0 0 1-4.5 4.975V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 .5-.5" />
                                </svg>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                    <path
                                        d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="epg-right">

            <div class="epg-time-slots d-flex">
                @foreach ($timeslots as $slot)
                    <div class="epg-time-slot">{{ $slot }}</div>
                @endforeach
            </div>


            <!-- Flexbox Programs Layout -->
            <div class="epg-programs d-flex" style="width: 100%;">
                @foreach ($programs as $program)
                    @if ($program['title'])
                        <!-- Set width of each program based on its duration -->
                        <div class="epg-show"
                            style="flex: 0 0 {{ ($program['column_span'] / 1440) * 100 }}%; margin-left: {{ ($program['start_column'] / 1440) * 100 }}%;">
                            <div class="program-title">
                                {{ $program['title'] }} <br>

                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>


</div>

@php
    include public_path('themes/theme5-nemisha/views/footer.blade.php');
@endphp

<script>
    const leftArrow = document.querySelector('.left-arrow');
    const rightArrow = document.querySelector('.right-arrow');
    const timeSlots = document.querySelector('.epg-time-slots');
    const programRows = document.querySelectorAll('.epg-programs');

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

        timeSlots.style.transform = `translateX(${currentOffset}px)`;
        programRows.forEach(row => {
            row.style.transform = `translateX(${currentOffset}px)`;
        });
    }

    leftArrow.addEventListener('click', function() {
        scrollEPG(scrollAmount);
    });

    rightArrow.addEventListener('click', function() {
        scrollEPG(-scrollAmount);
    });
</script>
