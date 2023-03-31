<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Current Time</title>

    <style>
        @import url('href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap');
        @import url('https://fonts.googleapis.com/css?family=Odibee+Sans&display=swap');

        body {
            background: #62c6c9;
            font-family: 'Varela Round', sans-serif;
            margin: 0;
        }

        .clock-wapper {
            width: 250px;
            height: 250px;
            background: #222;
            border-radius: 50%;
            margin: auto;
            padding: 5px;
            position: absolute;
            top: 50%;
            bottom: 50%;
            left: 0;
            right: 0;
            box-shadow: 0 0 5px rgba(0, 0, 0);
            border: 20px solid #111
        }

        .dial {
            position: absolute;
            z-index: 1;
            top: 15px;
            left: 15px;
            width: 230px;
            height: 230px;
        }

        .mark {
            width: 2px;
            height: 6px;
            background: #777;
            margin: 113px 114px;
            position: absolute;
            box-shadow: 0 0 7px rgba(0, 0, 0, .8);
        }

        .mark:nth-child(1) {
            transform: rotate(30deg) translateY(-113px);
        }

        .mark:nth-child(2) {
            transform: rotate(60deg) translateY(-113px);
        }

        .mark:nth-child(3) {
            transform: rotate(90deg) translateY(-113px);
            height: 10px;
            width: 3px;
        }

        .mark:nth-child(4) {
            transform: rotate(120deg) translateY(-113px);
        }

        .mark:nth-child(5) {
            transform: rotate(150deg) translateY(-113px);
        }

        .mark:nth-child(6) {
            transform: rotate(180deg) translateY(-113px);
            height: 10px;
            width: 2px;
            background: #ffeb3b;
        }

        .mark:nth-child(7) {
            transform: rotate(210deg) translateY(-113px);
        }

        .mark:nth-child(8) {
            transform: rotate(240deg) translateY(-113px);
        }

        .mark:nth-child(9) {
            transform: rotate(270deg) translateY(-113px);
            height: 10px;
            width: 2px;
        }

        .mark:nth-child(10) {
            transform: rotate(300deg) translateY(-113px);
        }

        .mark:nth-child(11) {
            transform: rotate(330deg) translateY(-113px);
        }

        .mark:nth-child(12) {
            transform: rotate(360deg) translateY(-113px);
            height: 10px;
            width: 2px;
            background: #ffeb3b;
        }

        .hour {
            z-index: 2;
            width: 6px;
            height: 55px;
            background: #777;
            position: absolute;
            left: 129px;
            top: 75px;
            animation: rotate-hour 43200s infinite linear;
            transform-origin: 3px 100%;
        }

        .minute {
            z-index: 3;
            width: 4px;
            height: 85px;
            background: #777;
            position: absolute;
            left: 129px;
            top: 45px;
            animation: rotate-minute 3600s infinite steps(60);
            transform-origin: 2px 100%;
        }

        .second {
            z-index: 4;
            width: 4px;
            height: 100px;
            background: #ffeb3b;
            position: absolute;
            left: 129px;
            top: 30px;
            transition: .5s;
            animation: rotate-second 60s infinite steps(60);
            transform-origin: 2px 100%;
        }

        .hour,
        .minute,
        .second,
        .fixed-center {
            box-shadow: 0 2px 17px rgba(0, 0, 0, 1);
            border-radius: 3px 3px 0px 0px;
        }

        .fixed-center {
            z-index: 5;
            width: 8px;
            height: 8px;
            border: 2px solid #ffeb3b;
            background: #888;
            border-radius: 50%;
            position: absolute;
            left: 125px;
            top: 125px;
        }

        .logo {
            z-index: 1;
            color: #aaa;
            position: absolute;
            left: 91px;
            top: 70px;
            letter-spacing: 2px;
            font-weight: bold;
            text-align: center; 
        }

        #week-day {
            color: #ddd;
            z-index: 1;
            position: absolute;
            left: 96px;
            top: 155px;
            font-size: 1.5em;
            font-family: 'Odibee Sans', cursive;
            letter-spacing: 2px;
        }

        #show-time {
            color: #ddd;
            z-index: 1;
            position: absolute;
            left: 88px;
            top: 185px;
            font-size: 1.5em;
            font-family: 'Odibee Sans', cursive;
            letter-spacing: 2px;
        }
    </style>
</head>

<style id="clock-animations"> </style>

<body onload="ShowTime()">
    <div class="clock-wapper">
        <div class="dial">
            <div class="mark"></div>
            <div class="mark"></div>
            <div class="mark"></div>
            <div class="mark"></div>
            <div class="mark"></div>
            <div class="mark"></div>
            <div class="mark"></div>
            <div class="mark"></div>
            <div class="mark"></div>
            <div class="mark"></div>
            <div class="mark"></div>
            <div class="mark"></div>
        </div>

        <div class="hour"></div>
        <div class="minute"></div>
        <div class="second"></div>
        <div class="fixed-center"></div>

        <div class="logo d-flex justify-content-between">{{ strtoupper(GetWebsiteName()) }}</div>

        <div id="week-day">Sun 11</div>
        <div id="show-time">00:00AM</div>
    </div>
</body>

<script>
    let Get_hours   = "{{ $data['Get_hours'] }}" ;
    let Get_Minutes = "{{ $data['Get_Minutes'] }}" ;
    let Get_Seconds = "{{ $data['Get_Seconds'] }}" ;
    let Get_Date    = "{{ $data['Get_Date'] }}" ;
    let Get_Day     = "{{ $data['Get_Day']  }}" ;
    let Get_Year    = "{{ $data['Get_Year'] }}";

    let hourDeg   = Get_hours / 12 * 360 + Get_Minutes / 60 * 30;
    let minuteDeg = Get_Minutes / 60 * 360 + Get_Seconds / 60 * 6;
    let secondDeg = Get_Seconds / 60 * 360;
    let showtime  = Get_hours + '：' + Get_Minutes + '：' + Get_Seconds;

        stylesDeg = [
            "@keyframes rotate-hour{from{transform:rotate(" + hourDeg + "deg);}to{transform:rotate(" + (hourDeg + 360) +
            "deg);}}",
            "@keyframes rotate-minute{from{transform:rotate(" + minuteDeg + "deg);}to{transform:rotate(" + (minuteDeg +
                360) + "deg);}}",
            "@keyframes rotate-second{from{transform:rotate(" + secondDeg + "deg);}to{transform:rotate(" + (secondDeg +
                360) + "deg);}}"
        ].join("");
    document.getElementById("clock-animations").innerHTML = stylesDeg;

    function ShowTime() {
       
            let week = Get_Day ;
            let day = (Get_Date < 10 ? '0' : '') + Get_Date;
            let hour = Get_hours;
            let APhour = hour > 12 ? hour - 12 : hour;
            let zeroHour = (APhour < 10 ? '' : '') + APhour;
            let minute = (Get_Minutes < 10 ? '0' : '') + Get_Minutes;
            let format = hour >= 12 ? 'PM' : 'AM';
            let showtime = zeroHour + ':' + minute + format;

        document.getElementById('week-day').innerHTML = week + ' ' + day ;
        document.getElementById('show-time').innerHTML = showtime;
        setTimeout('ShowTime()', 1000);
    }
</script>

</html>
