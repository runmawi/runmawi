@php
    include public_path('themes/theme5-nemisha/views/header.php');
@endphp

<style>
    /* Main EPG Container */
    .epg-container {
        width: 100%;
        padding: 10px;
    }

    /* Header Row */
    .epg-header {
        display: flex;
        align-items: center;
        padding: 10px;
        font-weight: bold;
        background-color: black;
        color: white;
    }

    .epg-channel-header {
        flex: 0 0 160px;
        text-align: center;
    }

    .epg-time-slots {
        flex: 1;
        display: flex;
    }

    .epg-time-slot {
        flex: 1;
        text-align: center;
        padding: 10px;
    }

    /* Each Channel Row */
    .epg-channel-row {
        display: flex;
        align-items: center;
        padding: 10px 0;
    }

    /* Channel Name Styling */
    .channel-name {
        flex: 0 0 150px;
        font-weight: bold;
        text-align: center;
    }

    /* Programs Layout */
    .epg-programs {
        flex: 1;
        display: flex;
    }

    .epg-show {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
        margin-left: 10px;
        background-color: #f2f2f2;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Optional Styling: Hover and Striped Background */
    .epg-show:hover {
        background-color: #e0e0e0;
    }

</style>

<div class="m-4">
    <!-- Program Information Section -->

    <div class="pb-2">
        <h1>GUIDE</h1>
        <h6>Antenna / today / All CH</h6>
    </div>
    <div class="row">
        <div class="col-3">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4bGIutSVn_5mYkrDJWjAiu8RoP4zdw069i8q1AjTV1j3JySgLTrZiBIyQjcfgB4X5bLM&usqp=CAU"
                alt="">
        </div>
        <div class="col-9 bg-secondary p-3">
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
        <!-- Header Row: Time Slots -->
        <div class="epg-header d-flex">
            <div class="epg-channel-header">TODAY</div>
            <div class="epg-time-slots">
                <div class="epg-time-slot">9:30</div>
                <div class="epg-time-slot">10:00</div>
                <div class="epg-time-slot">10:30</div>
                <div class="epg-time-slot">11:00</div>
            </div>
        </div>

        <!-- Row for Sun TV -->
        <div class="epg-channel-row d-flex">
            <div class="channel-name">Sun TV</div>
            <div class="epg-programs d-flex">
                <div class="epg-show" style="flex: 1;">Game of Thrones</div>
                <div class="epg-show" style="flex: 2;">Breaking Bad</div>
                <div class="epg-show" style="flex: 1;">Friends</div>
            </div>
        </div>

        <!-- Row for Star Plus -->
        <div class="epg-channel-row d-flex">
            <div class="channel-name">Star Plus</div>
            <div class="epg-programs d-flex">
                <div class="epg-show" style="flex: 2;">The Office</div>
                <div class="epg-show" style="flex: 1;">Sherlock</div>
                <div class="epg-show" style="flex: 1;">Stranger Things</div>
            </div>
        </div>
    </div>


</div>

@php
    include public_path('themes/theme5-nemisha/views/footer.blade.php');
@endphp
