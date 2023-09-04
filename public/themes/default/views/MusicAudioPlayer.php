<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat&amp;display=swap"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php include(public_path('themes/default/views/header.php')); ?>

<div class="floating-icon"><a href="https://jewel998.github.io/playlist" style="color:white"><i class="fa fa-github"></i></a></div>
<div class="floating-icon"><a href="https://codepen.io/jewel998" style="color:white"><i class="fa fa-codepen"></i></a></div>
<div id="music-player">
        <img id="album-art"/>
        <div id="top-bar">
          <button id="back"><i class="fa fa-arrow-left"></i></button>
          <div id="about-song"><h2 class="song-name"></h2><h4 class="artist-name"></h4></div>
        </div>
        <div id="lyrics">
          <h2 class="song-name"></h2><h4 class="artist-name"></h4>
          <div id="lyrics-content">
          </div>
        </div>
        <audio id="audioFile" preload="true">
        </audio>
        <div id="player">
          <div id="bar">
            <div id="currentTime"></div>
            <div id="progress-bar">
              <div id="progress"><i id="progressButton" class="fa fa-circle"></i></div>
            </div>
            <div id="totalTime"></div>
          </div>
          <div id="menu">
            <button id="repeat" style="color:grey"><i class="fa fa-repeat"></i></button>
            <button id="prev"><i class="fa fa-step-backward"></i></button>
            <button id="play"><i class="fa fa-play"></i></button>
            <button id="next"><i class="fa fa-step-forward"></i></button>
            <button id="shuffle" style="color:grey"><i class="fa fa-random"></i></button>
          </div>
        </div>
        <div id="playlist">
          <div id="label">
            <h1>Playlist</h1>
            <input id="search" type="text" placeholder="&#xF002; Search from all songs"></input>
          </div>
          <div id="show-box">
            <div id="show-list">
            </div>
          </div>
        </div>
    </div>

    <style>
        :root{
            --bg-color: background-color: #7f5a83;
            background-image: linear-gradient(315deg, #7f5a83 0%, #0d324d 74%);
            --menu-color: #00000045;
            --lyrics-color: white;
            --font-family: "Montserrat",sans-serif;
            }
            html,body{
            margin: 0;
            padding: 0;
            font-family: var(--font-family);
            overflow: hidden;
            }
            #music-player{
            width:100%;
            height:100vh;
            background: var(--bg-color);
            }
            #album-art{ position:fixed; z-index:-1; left: 50%; transform: translateX(-50%);opacity: 0.15;width: auto; height: 100%;}
            #top-bar{
            position: relative;
            height: 8vh;
            color: white;
            width: 90%;
            padding: 0 0 0 5%;
            z-index: 50;
            }
            #top-bar > *{ display:inline-block; }
            #top-bar button{ margin:0;background: inherit; border: none; color: white; font-size: 100%;vertical-align:middle;transform:translateY(-40%);padding: 5px 10px;}
            #about-song{ width: 60%; margin: 0 5%; line-height: 1vh; font-size:70%;}
            .artist-name{ color: #ffffff79;}
            @media only screen and (max-width: 340px){
            #top-bar > button{ font-size: 15px; }
            #top-bar > #about-song *{ font-size:120%;line-height:0; }
            #menu > button{ font-size: 5vw !important; padding: 4px 6px !important;  }
            #progress-bar{
                width: 50% !important;
            }
            }
            #lyrics{
            width: 100%;
            height: 60vh;
            color: var(--lyrics-color);
            text-align: center;
            overflow-Y: scroll;
            font-size: 2vh;
            }
            #lyrics-content{
            margin:0;
            padding: 20vh 0;
            transition: ease 0.1s all;
            }
            #lyrics h2{
            opacity: 0.25;
            }
            #lyrics .current{
            opacity: 1;
            font-size: 250%;
            transform: translateY(25%);
            }
            #lyrics .current + h2{
            opacity: 0.5;
            font-size: 180%;
            }
            #player{
            background: var(--menu-color);
            position: fixed;
            bottom: 0;
            height: 25vh;
            width: 100%;
            z-index: 50;
            }
            #bar{
            position:relative;
            text-align: center;
            width:100%;
            padding-top: 25px;
            }
            #currentTime,#totalTime{transform:translateY(-50%);padding: 0 2%;font-size: 3vh}
            @media only screen and (min-height: 500px){#currentTime,#totalTime{font-size: 2.25vh !important;}}
            #currentTime,#progress-bar,#totalTime{color: white;display: inline-block;}
            #progress-bar{
            position: relative;
            text-align: center;
            height: 0.25em;
            width: 70%;
            border: 1px solid #222;
            background: #333;
            border-radius: 20px;
            margin:0;padding:0;
            cursor: pointer;
            transform: translateY(-160%);
            }
            #progress{
            height:100%;
            width:0%;
            background: red;
            border-radius: 20px;
            text-align: right;
            transition: ease all;
            }
            #progress > i{
            position: absolute;
            transform: translate(-50%,-35%);
            }
            #menu{
            position:relative;
            text-align: center;
            width:100%;
            overflow: hidden;
            }
            #menu > button{
            padding: 10px 14px;
            border-radius: 50%;
            border: none;
            margin: 0 5px;
            background: inherit;
            color: white;
            font-size: 20px;
            text-align: center;
            opacity: 0.75;
            cursor: pointer;
            }
            #menu > button > i{
            padding: 5px 3px 5px 5px;
            }
            #menu > button#play{
            opacity: 1;
            border: 2px solid white;
            }
            #menu > button:focus{
            outline: none;
            }
            #playlist{
            position:fixed;
            top:8vh;
            left:0;
            height:67vh;
            width:100%;
            z-index: 4;
            color: var(--lyrics-color);
            background-color: #7f5a8399;
            background-image: linear-gradient(315deg, #7f5a8399 0%, #0d324d99 74%);
            transition: cubic-bezier(0.175, 0.885, 0.32, 1.275) 1s all;
            transform:translateX(100%);
            }
            #show-box{
            position: absolute;
            top: 70%;
            left:50%;
            height: 30vh;
            width:70%;
            padding: 4vh;
            transform: translate(-50%,-70%);
            overflow: auto;
            }
            #show-list{
            position: relative;
            transition: ease-in-out 0.5s all;
            height: 100%;
            }
            #show-list .float-song-card{
            position: relative;
            display:inline-block;
            height: 130px;
            width: 110px;
            padding: 20px 10px;
            background: #00000089;
            text-align: center;
            font-size: 70%;
            border-radius:8px;
            margin: 4px 10px;
            overflow:hidden;
            cursor: pointer;
            }
            .float-song-card > .album-art{
            position: absolute;
            top:0;
            left:50%;
            transform: translateX(-50%);
            height:100%;
            width: auto;
            opacity:0.75;
            transition: ease-in-out 0.5s all;
            }
            .float-song-card:hover > .album-art{
            transform: translateX(-50%) scale(1.2,1.2);
            opacity:1;
            }
            .float-song-card > h2,
            .float-song-card > h4{position:relative;z-index:49;margin:2px 0;}
            #playlist > #label{
            width:100%;
            text-align: center;
            font-size:100%;
            }
            #playlist > #label > h1{ line-height:0;margin: 6vh 0 2.5vh;}
            #search{
            background: transparent;
            color: white;
            border:1px solid #ffffff99;
            padding: 8px;
            margin: 2.5vh 0;
            border-radius: 50%;
            font-family: FontAwesome,"Montserrat",sans-serif;
            transition: cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.5s all;
            width: 12px;
            background: white;
            }
            #search:focus{outline:none;border-radius:8px;border:1px solid #ffffff;width:25vw;padding: 1vh 1.5vw;background: inherit;}
            @media only screen and (max-height: 500px){
            #show-list .float-song-card{font-size:40% !important;height:60px;width:50px;}
            #playlist > #label{font-size:70%;}
            #search{font-size:10px;padding:4px;width:10px;}
            #search:focus{width:40vw;}
            #playlist > #label > h1{margin:8vh 0 4vh !important;}
            }

            #lyrics::-webkit-scrollbar,#show-box::-webkit-scrollbar{
            width:5px;
            }
            #lyrics::-webkit-scrollbar-track,#show-box::-webkit-scrollbar-track{
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            }
            #lyrics::-webkit-scrollbar-thumb,#show-box::-webkit-scrollbar-thumb{
            background-color: darkgrey;
            outline: 1px solid slategrey;
            border-radius: 15px;
            }
            .floating-icon{
            position: absolute;
            bottom: 5%;
            z-index: 1000;
            font-size: 4vh;
            border: 1.5px solid white;
            border-radius: 50%;
            padding: 1vh 2vh;
            background: #222;
            }
            .floating-icon:nth-child(1){
            right: 3vh;
            }
            .floating-icon:nth-child(2){
            right: 12vh;
            }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        console.clear();
            $.expr[":"].contains = $.expr.createPseudo(function(arg) {
                return function( elem ) {
                    return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
                };
            });
            var buttonColorOnPress = "white";
            $(document).ready(function(){
            $.getJSON('https://jewel998.github.io/playlist/playlist.json',function(data){
                var abort_other_json;
                var playlist = data;
                var index = 0;
                var indexing = playlist.songs[index];
                var time = 0;
                var totalTime = 0;
                var timeList = [];
                var play = 0;
                var counter = 0;
                var songRepeat = 0;
                var songShuffle = 0;
                var mute = 0;
                var stopTimer;
                var previousTime;
                var safeKill = 0;
                var audio = document.getElementById('audioFile');
                function centerize() {
                    if(play == 0) return;
                    if($(".current").length == 0) return;
                    var a = $(".current").height();
                    var c = $("#lyrics").height();
                    var d = $(".current").offset().top - $(".current").parent().offset().top;
                    var e = d + (a/2) - (c*1/4);
                    $("#lyrics").animate(
                        {scrollTop: e + "px"}, {easing: "swing", duration: 500}
                    );
                }
                function next(){
                    var current = $('#lyrics .current');
                    if(current.length == 0){ $('#lyrics-content h2:nth-child(1)').addClass("current"); return; }
                    current.removeClass('current');
                    current.next().addClass('current');
                }
                function previous(){
                    var current = $('#lyrics .current');
                    if(current.length == 0){ return; }
                    var first = $('#lyrics-content h2:nth-child(1)');
                    current.removeClass('current');
                    if(current === first){ return; }
                    current.prev().addClass('current');
                }
                function setSongName(songName){
                    var context = $('.song-name');
                    for(var i=0;i<context.length;i++){
                        context[i].innerHTML = songName;

                    }
                }
                function setArtistName(artistName){
                    var context = $('.artist-name');
                    for(var i=0;i<context.length;i++){
                        context[i].innerHTML = artistName;
                    }
                }
                function setAlbumArt(albumart){
                    var context = $('#album-art');
                    context.attr("src",albumart);
                }
                function processTime(a){
                    var b = parseInt(a/60000);
                    var c = parseInt((a%60000)/1000);
                    if(c < 10){ c = "0"+c; }
                    return b+":"+c;
                }
                function reset(){
                    time = 0;
                    audio.currentTime = 0;
                }
                function playSong(){
                    if(play==0){play = 1;audio.play();$('#menu button#play i').removeClass("fa-play");$('#menu button#play i').addClass("fa-pause");}
                    else{play = 0;audio.pause();$('#menu button#play i').removeClass("fa-pause");$('#menu button#play i').addClass("fa-play");}
                }
                function processing(data,indexing){
                    if(data.author == ""){ data.author = "Unknown"; }
                    // alert(indexing.song);
                    // console.log(data );

                    setSongName(indexing.song);
                    setArtistName(indexing.author);
                    setAlbumArt(indexing.albumart);
                    var html = "";
                    timeList=[];
                    for(var i=0;i<data.lyrics.length;i++){
                        timeList.push(data.lyrics[i].time);
                        html = html + "<h2>"+data.lyrics[i].line+"</h2>";
                    }
                    $('#lyrics-content').html(html);
                    $('#totalTime').html(processTime(totalTime));
                    $('#currentTime').html(processTime(time));
                    var percent = time/totalTime * 100;
                    $('#progress').css("width",percent+"%");
                }
                $('#progress-bar').on('mousedown',function(){
                    $('#progress-bar').on('mousemove',function handler(event){
                    event.preventDefault;
                    if(event.offsetY > 5 || event.offsetY < 1) return;
                    var width = $('#progress-bar').css("width");
                    var percent = parseInt(event.offsetX)/parseInt(width)*100;
                    $('#progress').css("width",percent+"%");
                    time = parseInt(totalTime * (percent/100));
                    audio.currentTime = parseInt(time/1000);
                    });
                });
            function changeProgress(){
            dragHandler = (event)=>{
                    event.preventDefault;
                    if(event.offsetY > 5 || event.offsetY < 1) return;
                    var width = $('#progress-bar').css("width");
                    var percent = parseInt(event.offsetX)/parseInt(width)*100;
                    $('#progress').css("width",percent+"%");
                    time = parseInt(totalTime * (percent/100));
                    audio.currentTime = parseInt(time/1000);
                    }
                }
                $('#progressButton').on('mousedown',changeProgress());
                $('#progress-bar').mouseup(function(){
                    $('#progress-bar').off('mousemove');
                });
                $('#progressButton').mouseup(function(){
                    $('#progress-bar').off('mousemove');
                });
                function rewind5s(){
                    if(time > 5000)
                        time = time - 5000;
                    else
                        time = 0;
                    audio.currentTime = parseInt(time/1000);
                }
                function forward5s(){
                    if((time+5000) < totalTime)
                        time = time + 5000;
                    else
                        time = totalTime;
                    audio.currentTime = parseInt(time/1000);
                }
                $(document).bind('keydown',function(event){
                    switch(event.keyCode){
                        case 37:
                        rewind5s();
                        break;
                        case 39:
                        forward5s();
                        break;
                    }
                });
                function toggleRepeat(){if(songRepeat == 0){$('#repeat').css("color",buttonColorOnPress);songRepeat=1;}else{$('#repeat').css("color","grey");songRepeat=0;}}function toggleShuffle(){if(songShuffle == 0){$('#shuffle').css("color",buttonColorOnPress);songShuffle = 1;}else{$('#shuffle').css("color","grey");songShuffle = 0;}}function toggleMute(){if(mute == 0){mute=1;audio.volume = 0;}else{mute = 0;audio.volume = 1;}}
                $(document).bind('keypress',function(event){
                    //console.log(event.keyCode);
                    switch(event.keyCode){
                        case 32:
                        playSong();
                        break;
                        case 109:
                        toggleMute();
                        break;
                        case 114:
                        toggleRepeat();
                        break;
                        case 115:
                        toggleShuffle();
                        break;
                    }
                });
                function prevSong(){
                    if(abort_other_json){abort_other_json.abort();}reset();timeList=[];previousTime=0;counter=0;
                    clearInterval(stopTimer);
                    index = (index-1)%playlist.songs.length;
                    indexing = playlist.songs[index];
                    $('#audioFile').attr('src',indexing.audio);
                    loadSong();
                }
                function nextSong(){
                    if(abort_other_json){abort_other_json.abort();}reset();timeList=[];previousTime=0;counter=0;
                    clearInterval(stopTimer);
                    index = (index+1)%playlist.songs.length;
                    indexing = playlist.songs[index];
                    $('#audioFile').attr('src',indexing.audio);
                    loadSong(); 
                }
                function updateTimer(data){
                    if(totalTime == 0 || isNaN(totalTime)){totalTime = parseInt((audio.duration * 1000));processing(data);}
                    //for the end of the song
                    if(time >= totalTime){if(play == 0) return; playSong(); if(songRepeat == 1){ reset(); playSong(); return; }else{ nextSong(); playSong(); } return;}
                    //update timer
                    if(play == 1){time = time + 1000;}
                    else if(play == -1){time = 0;}
                    //upadate time on the progress bar
                    if(audio.currentTime != previousTime){previousTime=audio.currentTime;$('#currentTime').html(processTime(time));var percent = time/totalTime * 100;$('#progress').css("width",percent+"%");}
                    else{ time = parseInt(audio.currentTime*1000);if(time>100)time=time-100;if(play==1){audio.pause();if(audio.readyState == 4){audio.play();}} }
                    safeKill = 0;
                    while(true){
                        safeKill += 1;
                        if(safeKill >= 100) break;
                        if(counter == 0){if(time < timeList[counter]){previous();break;}}
                        if((counter == timeList.length) && (time <= timeList[counter-1])){counter--;previous();}
                        if(time >= timeList[counter]){if(counter<=timeList.length){counter++;}next();}
                        else if(time < timeList[counter-1]){counter--;previous();}
                        else{if(play == 1 && !audio.paused && !audio.ended)centerize();break;}
                    }
                }
                function loadSong(){
                    $('#audioFile').attr('src',indexing.audio);
                    abort_other_json = $.getJSON(indexing.json,function(data){
                        processing(data,indexing);
                        totalTime = NaN;
                        stopTimer = setInterval(function(){updateTimer(data);},1000);
                    });
                }
                loadSong();
                $('#prev').on('click',prevSong);
                $('#next').on('click',nextSong);
                $('#play').on('click',playSong);
                $('#repeat').on('click',toggleRepeat);
                $('#shuffle').on('click',toggleShuffle);
                function playSongAtIndex(data){
                    if(data == index) return;
                    if(index >= playlist.songs.length) return;
                    if(abort_other_json){abort_other_json.abort();reset();clearInterval(stopTimer);timeList=[];previousTime=0;counter=0;}
                    index = data;
                    indexing = playlist.songs[index];
                    $('#audioFile').attr('src',indexing.audio);
                    loadSong();
                }
                function addToPlayList(data,index){
                    var html = "";html = $('#show-list').html();html +="<div class=\"float-song-card\" data-index=\""+index+"\"><img class=\"album-art\" src=\""+data.albumart+"\"><h2 class=\"song\">"+data.song+"</h2><h4 class=\"artist\">"+data.author+"</h4></div>";$('#show-list').html(html);$('.float-song-card').on('click',function(){playSongAtIndex($(this).attr("data-index"));});
                }
                function setPlaylist(){
                    for(var i=0;i<playlist.songs.length;i++){
                        $.getJSON(playlist.songs[i].json,function(i){ return function(data){addToPlayList(data,i)}; }(i));
                    }
                }
                setPlaylist();
            });
            $('#search').keyup(function(){
                var toSearch = $(this).val();
                $('.float-song-card').css("display","none");
                $('.float-song-card:contains('+toSearch+')').css("display","inline-block");
            });
            var togglePlaylist = 0;
            $('#back').on('click',function(){
            if(togglePlaylist == 0){
                $('#playlist').css("transform","translateX(0)");
                togglePlaylist = 1;
            }
            else{
                $('#playlist').css("transform","translateX(100%)");
                togglePlaylist = 0;
            }
            });
            });

    </script>
<?php include(public_path('themes/default/views/footer.blade.php')); ?>
