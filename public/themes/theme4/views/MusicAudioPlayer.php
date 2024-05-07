<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php include(public_path('themes/theme4/views/header.php')); 
  $music_station_url = array_slice(explode('/', request()->url()), -2, 1); 
  if(count($music_station_url) > 0){
    $music_station_button = $music_station_url[0];
  }

 ?>
<style>

</style>
<div id="music-player">
  
        <img id="album-art"/>
        <div id="top-bar">
          <button id="backStationbutton"><i class="fa fa-arrow-left"></i></button> 
          <div id="about-song"><h2 class="song-name"></h2><h4 class="artist-name"></h4></div>
          <div id="station-music">
          <button id="addtoqueuebtn" class="addqubt"><i class="fa fa-plus" aria-hidden="true"></i></button>    
          <button class='btn bd btn-action station_auto_create' data-toggle="modal" data-target="#myModal" style='position: absolute;margin-left: 15%;'><?php echo __('Add to Queue'); ?></button></div>
        </div>
        <div id="lyrics">
          <!-- <h2 class="song-name"></h2><h4 class="artist-name"></h4> -->
          <div id="lyrics-content">
          </div>
          <div class="<?php echo URL::to('/becomesubscriber'); ?>">
              <img height="250" width="250"  id="audio_img" src="" style="object-fit: contain;">
              <!-- height="150" width="150"  -->
           </div>
           <div id="description-content">
          </div>
           <div class="Subscribe_stripe_button">
                <!-- Subscriber Button -->
  
              <a href="<?php echo URL::to('/becomesubscriber'); ?>"  ><button  id="Subscriber_button" style="margin-left: -9%;position: absolute;margin-top: 20px;"
                      class="btn bd btn-action"><?php echo __('Subscribe to continue listening'); ?></button> 
                  </a>
              </div>
              <div class="ppv_stripe_button">
                  <!-- stripe Button -->
                  <button  onclick="stripe_checkout()" id="enable_button" style="margin-left: -9%;position: absolute;margin-top: 20px;"
                      class="btn bd btn-action"><?php echo __('Purchase to Play Audio'); ?></button> 
                  </a>
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
          <button id="like-button" style="color:grey" class="like" title="Like"><i class="fa fa-thumbs-up"></i></button>
          <button id="lyrics-toggle"><i class="fa fa-file-text" title="Lyrics"></i></button> <!-- Add this line -->
          <button id="description-toggle"><i class="fa fa-book" title="Description"></i></button> <!-- Add this line -->
          <button id="back" title="Songs List"><i class="fas fa-list"></i></button> 
          <button id="prev" title="Previous"><i class="fa fa-step-backward"></i></button>
          <button id="play" ><i class="fa fa-play"></i></button>
          <button id="next" title="Next"><i class="fa fa-step-forward"></i></button>
          <button id="shuffle" style="color:grey" title="Shuffle"><i class="fa fa-random"></i></button>
          <button id="repeat" style="color:grey" title="Repeat"><i class="fa fa-repeat"></i></button>
          <button id="dislike-button" style="color:grey" class="dislike" title="DisLike"><i class="fa fa-thumbs-down"></i></button>
          <?php if(@$playlist_station == 1){ ?>
          <button id="backstation" title="Station List" ><i class="fas fa-stream"></i></button>
          <?php } ?>
          </div>
        </div>
        <div id="playlist">

          <div id="label">
            <h1><?php echo @$playlist_name ; ?></h1>
            <input id="search" type="text" placeholder="&#xF002; Search from all songs"></input>
          </div>

        <button id="backbutton"><i class="fas fa-times"></i></button> 

          <div id="show-box">
            <div id="show-list">
            </div>
          </div>
        </div>
        <div id="playlistStation">
          <div id="label">
            <h1><?php echo __('Other Music Station') ; ?></h1>
            <input id="Stationsearch" type="text" placeholder="&#xF002; Search from all Station"></input>
          </div>
          <div id="show-box">
            <div id="show-list-Station">
            </div>
          </div>
        </div>
    </div>
<!-- Station Modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-black" id="myModalLabel"><?php echo __('Create Station'); ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">      
      <div class="col-sm-10 p-0">
          <label for="name"><?php echo __('Station Title'); ?></label>
            <input name="station_name" id="station_name" placeholder="<?php echo __('Station Title'); ?>" class="form-control form-control1 text-black"  />
            <span id='station_error' class="" style='color:red;'><?php echo __('Station Name Required'); ?></span>
        </div>
          </div>
     
<br>
      <div class="modal-footer">
        <button type="button" id="station_save" class="btn btn-primary"><?php echo __('Save'); ?></button>
      </div>
    </div>
  </div>
</div>

</div>

<style>
    .form-control1 {
      color:black !important;
    }
</style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
    <script>
        console.clear();
$.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function( elem ) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});
var buttonColorOnPress = "white";
var $j = jQuery.noConflict();
$('#station_error').hide();

var music_station_button = <?php echo json_encode(@$music_station_button); ?>;

if(music_station_button == 'music-station'){
  $('.station_auto_create').css('display','none');

}

$(document).ready(function(){
  $('.Subscribe_stripe_button').hide();
  $('.ppv_stripe_button').hide();
    var lyrics = $('#lyrics-content');
    if (lyrics.is(':visible')) {
        lyrics.hide(); // Hide lyrics
    }

    var description = $('#description-content');
        if (description.is(':visible')) {
            description.hide(); // Hide lyrics
        }

    var backbutton = $('#backbutton');
    backbutton.hide();

    var backStationbutton = $('#backStationbutton');
    backStationbutton.hide();
    
    $('#audio_img').show();
    var listAudio = <?php echo json_encode($songs); ?>;
    var listAudio = <?php echo json_encode($songs); ?>;
    var OtherMusicStation = <?php echo json_encode(@$OtherMusicStation); ?>;
    // console.log(listAudio);

var data = listAudio; // Assuming listAudio contains the URL

// $.getJSON(listAudioURL, function(data) {
// $.getJSON('https://jewel998.github.io/playlist/playlist.json',function(data){
    
    // console.log(data);
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
    // function setArtistName(artistName){
    //     var context = $('.artist-name');
    //     for(var i=0;i<context.length;i++){
    //         context[i].innerHTML = artistName;
    //     }
    // }

    function setArtistName(artistslug,artistName) {
      var context = document.querySelectorAll('.artist-name');
      var baseUrl = '<?= URL::to('/artist'); ?>';
      
      context.forEach(function(element) {
        element.innerHTML += `<a href="${baseUrl}/${artistslug}"> ${artistName}</a>`;
      });
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
    function processing(indexing){
        // if(indexing.author == ""){ indexing.author = "Unknown"; }
        // console.log(data);
        setSongName(indexing.song);
          // for (var i = 0; i < indexing.artistscrew.length; i++) {
          //     // Access the inner array
          //     var innerArray = indexing.artistscrew[i];
          //     // Loop through the inner array
          //     for (var j = 0; j < innerArray.length; j++) {
          //       // Access the object
          //       var obj = innerArray[j];
          //       setArtistName(obj.artist_slug,obj.artist_name)
          //       console.log(obj.artist_slug,obj.artist_name);
          //     }
          //   }
        setAlbumArt(indexing.albumart);

        var image = document.querySelector('#audio_img')
        image.src =  indexing.image_url 

        // Decode the JSON string into a JavaScript object
        if(indexing.countjson == 1){
            var jsonString = indexing.json;
                  
            var jsonString = indexing.lyrics_json;
            var data = JSON.parse(jsonString);
            // console.log(jsonString);
            var html = "";
            timeList=[];
            for(var i=0;i<data.lyrics.length;i++){
                timeList.push(data.lyrics[i].time);
                html = html + "<h2>"+data.lyrics[i].line+"</h2>";
            }
            // console.log(timeList +'timeList')
            $('#lyrics-content').html(html);
            $('#totalTime').html(processTime(totalTime));
            $('#currentTime').html(processTime(time));
            var percent = time/totalTime * 100;
            $('#progress').css("width",percent+"%");

        }else{
            var data = '';
        }

       
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
        // console.log(indexing.audio);
        document.querySelector(".station_auto_create").setAttribute("data-audio-id", indexing.id);

      if(indexing.access == 'ppv' && indexing.PpvPurchase_Status == 0 && indexing.role == 'registered' ){
        // alert(indexing.role);

        $('.ppv_stripe_button').show();

        $('#audioFile').attr('src','');
            document.querySelector(".like").setAttribute("data-audio-id", indexing.id);
            document.querySelector(".dislike").setAttribute("data-audio-id", indexing.id);

            document.getElementById("enable_button").setAttribute("data-price",indexing.ppv_price );
            document.getElementById("enable_button").setAttribute("audio-id", indexing.id);

            var likeButton = document.querySelector(".like");
            var dislikeButton = document.querySelector(".dislike");

            // Check and set the color for the like button
            if (indexing.liked === 1) {
                likeButton.style.color = "white";
            } else {
                likeButton.style.color = "grey";
            }

            // Check and set the color for the dislike button
            if (indexing.disliked === 1) {
                dislikeButton.style.color = "white";
            } else {
                dislikeButton.style.color = "grey";
            }

        // Toggle lyrics visibility when the button is clicked
        $('#lyrics-toggle').on('click', function() {
            var lyrics = $('#lyrics-content');
            $('#audio_img').show();

            if (lyrics.is(':visible')) {
                lyrics.hide(); // Hide lyrics
            } else {
                $('#audio_img').hide();
                lyrics.show(); // Show lyrics
                centerize(); // Centerize lyrics (assuming you have this function)
            }
        });


        var html = "";
        html = html + "<h2>"+'Lyrics not Available'+"</h2>";

        // var html = "Lyrics not Available ";
        $('#lyrics-content').html(html);

        $('#description-toggle').on('click', function() {

          var lyrics = $('#description-content');
            $('#audio_img').show();

            if (description.is(':visible')) {
                description.hide(); // Hide description
            } else {
                $('#audio_img').show();
                description.show(); // Show description
                centerize(); // Centerize description (assuming you have this function)
            }

        });

        var html = "";
            html = html + "<h2>"+indexing.description+"</h2>";

            // var html = "Lyrics not Available ";
            $('#description-content').html(html);


            setSongName(indexing.title);
            
            for (var i = 0; i < indexing.artistscrew.length; i++) {
              // Access the inner array
              var innerArray = indexing.artistscrew[i];
              // Loop through the inner array
              for (var j = 0; j < innerArray.length; j++) {
                // Access the object
                var obj = innerArray[j];
                setArtistName(obj.artist_slug,obj.artist_name)
              }
            }
            setAlbumArt(indexing.image_url);
            processing(indexing);
            totalTime = 'NaN';
            // stopTimer = setInterval(function(){updateTimer(indexing);},1000);
      }else if(indexing.access == 'subscriber' && indexing.role == 'registered'){
        // alert(indexing.access);
        $('.Subscribe_stripe_button').show();

        $('#audioFile').attr('src','');
            document.querySelector(".like").setAttribute("data-audio-id", indexing.id);
            document.querySelector(".dislike").setAttribute("data-audio-id", indexing.id);

            var likeButton = document.querySelector(".like");
            var dislikeButton = document.querySelector(".dislike");

            // Check and set the color for the like button
            if (indexing.liked === 1) {
                likeButton.style.color = "white";
            } else {
                likeButton.style.color = "grey";
            }

            // Check and set the color for the dislike button
            if (indexing.disliked === 1) {
                dislikeButton.style.color = "white";
            } else {
                dislikeButton.style.color = "grey";
            }

        // Toggle lyrics visibility when the button is clicked
        $('#lyrics-toggle').on('click', function() {
            var lyrics = $('#lyrics-content');
            $('#audio_img').show();

            if (lyrics.is(':visible')) {
                lyrics.hide(); // Hide lyrics
            } else {
                $('#audio_img').hide();
                lyrics.show(); // Show lyrics
                centerize(); // Centerize lyrics (assuming you have this function)
            }
        });

        var html = "";
        html = html + "<h2>"+'Lyrics not Available'+"</h2>";

        // var html = "Lyrics not Available ";
        $('#lyrics-content').html(html);

        $('#description-toggle').on('click', function() {

          var lyrics = $('#description-content');
            $('#audio_img').show();

            if (description.is(':visible')) {
                description.hide(); // Hide description
            } else {
                $('#audio_img').show();
                description.show(); // Show description
                centerize(); // Centerize description (assuming you have this function)
            }

          });

          var html = "";
            html = html + "<h2>"+indexing.description+"</h2>";

            // var html = "Lyrics not Available ";
            $('#description-content').html(html);


            setSongName(indexing.title);
            for (var i = 0; i < indexing.artistscrew.length; i++) {
              // Access the inner array
              var innerArray = indexing.artistscrew[i];
              // Loop through the inner array
              for (var j = 0; j < innerArray.length; j++) {
                // Access the object
                var obj = innerArray[j];
                setArtistName(obj.artist_slug,obj.artist_name)
              }
            }
            setAlbumArt(indexing.image_url);
            processing(indexing);
            totalTime = 'NaN';
            // stopTimer = setInterval(function(){updateTimer(indexing);},1000);

      }else{ 
        // alert(indexing.access);
        // alert(indexing.artistscrew);
        
        $('#audioFile').attr('src',indexing.audio);
        // abort_other_json = $.getJSON(indexing.json,function(data){
            // alert(data);
            // if(data != null){
            //     var data = indexing.json;
            // }else{
            //     var data = '';
            // }
            document.querySelector(".like").setAttribute("data-audio-id", indexing.id);
            document.querySelector(".dislike").setAttribute("data-audio-id", indexing.id);

            var likeButton = document.querySelector(".like");
            var dislikeButton = document.querySelector(".dislike");

            // Check and set the color for the like button
            if (indexing.liked === 1) {
                likeButton.style.color = "white";
            } else {
                likeButton.style.color = "grey";
            }

            // Check and set the color for the dislike button
            if (indexing.disliked === 1) {
                dislikeButton.style.color = "white";
            } else {
                dislikeButton.style.color = "grey";
            }

        // Toggle lyrics visibility when the button is clicked
        $('#lyrics-toggle').on('click', function() {
            var lyrics = $('#lyrics-content');
            $('#audio_img').show();

            if (lyrics.is(':visible')) {
                lyrics.hide(); // Hide lyrics
            } else {
                $('#audio_img').hide();
                lyrics.show(); // Show lyrics
                centerize(); // Centerize lyrics (assuming you have this function)
            }
        });

        var html = "";
        html = html + "<h2>"+'Lyrics not Available'+"</h2>";

        // var html = "Lyrics not Available ";
        $('#lyrics-content').html(html);

        $('#description-toggle').on('click', function() {

          var lyrics = $('#description-content');
            $('#audio_img').show();

            if (description.is(':visible')) {
                description.hide(); // Hide description
            } else {
                $('#audio_img').show();
                description.show(); // Show description
                centerize(); // Centerize description (assuming you have this function)
            }

        });

        var html = "";
            html = html + "<h2>"+indexing.description+"</h2>";

            // var html = "Lyrics not Available ";
            $('#description-content').html(html);

          for (var i = 0; i < indexing.artistscrew.length; i++) {
              // Access the inner array
              var innerArray = indexing.artistscrew[i];
              // Loop through the inner array
              for (var j = 0; j < innerArray.length; j++) {
                // Access the object
                var obj = innerArray[j];
                setArtistName(obj.artist_slug,obj.artist_name)
              }
            }
            setSongName(indexing.title);

            setAlbumArt(indexing.image_url);
            processing(indexing);
            totalTime = NaN;
            stopTimer = setInterval(function(){updateTimer(indexing);},1000);
        // });
      }
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
    function addToPlayList(data,index,playlistsongs){
        // alert('addplaylist')
        // var html = "";html = $('#show-list').html();html +="<div class=\"float-song-card\" data-index=\""+index+"\"><img class=\"album-art\" src=\""+data.albumart+"\"><h2 class=\"song\">"+data.song+"</h2><h4 class=\"artist\">"+data.author+"</h4></div>";$('#show-list').html(html);$('.float-song-card').on('click',function(){playSongAtIndex($(this).attr("data-index"));});
        // var html = "";html = $('#show-list').html();html +="<div class=\"float-song-card\" data-index=\""+index+"\"><img class=\"album-art\" src=\""+playlistsongs.image_url+"\"><h2 class=\"song\">"+playlistsongs.title+"</h2><h4 class=\"artist\">"+playlistsongs.slug+"</h4></div>";$('#show-list').html(html);$('.float-song-card').on('click',function(){playSongAtIndex($(this).attr("data-index"));});
        var html = "";
        var redirect_url = '<?php echo URL::to('audio/').'/' ?>';
        html = $('#show-list').html();
        html += "<a href='" + redirect_url + playlistsongs.slug + "' class='float-song-card' data-index='" + index + "'>";
        html += "<img class='album-art' src='" + playlistsongs.image_url + "'>";
        html += "<h2 class='song'>" + playlistsongs.title + "</h2>";
        html += "<h4 class='artist'>" + playlistsongs.slug + "</h4>";
        html += "</a>";

        $('#show-list').html(html);

        $('.float-song-card').on('click', function () {
            playSongAtIndex($(this).attr("data-index"));
        });
    }
    function setPlaylist(){
        // console.log(playlist)

            for(var i=0;i<playlist.songs.length;i++){
                data = [];
            addToPlayList(data,i,playlist.songs[i])}; 
        }
    
    setPlaylist();

    function addToplaylistStationt(data,index,OtherMusicStation){
        var html = "";
        var redirect_url = '<?php echo URL::to('music-station').'/' ?>';
        html = $('#show-list-Station').html();
        html += "<a href='" + redirect_url + OtherMusicStation.station_slug + "' class='float-song-card' data-index='" + index + "'>";
        html += "<img class='album-art' src='" + OtherMusicStation.image + "'>";
        html += "<h2 class='song'>" + OtherMusicStation.station_name + "</h2>";
        html += "<h4 class='artist'>" + OtherMusicStation.station_slug + "</h4>";
        html += "</a>";

        $('#show-list-Station').html(html);

        $('.float-song-card').on('click', function () {
            playSongAtIndex($(this).attr("data-index"));
        });
    }

    function setplaylistStation(){
        // console.log(playlist)

            for(var i=0;i<OtherMusicStation.length;i++){
                data = [];
            addToplaylistStationt(data,i,OtherMusicStation[i])}; 
        }
    
        setplaylistStation();
// });
$('#search').keyup(function(){
    var toSearch = $(this).val();
    $('.float-song-card').css("display","none");
    $('.float-song-card:contains('+toSearch+')').css("display","inline-block");
});

$('#Stationsearch').keyup(function(){
    var toSearch = $(this).val();
    $('.float-song-card').css("display","none");
    $('.float-song-card:contains('+toSearch+')').css("display","inline-block");
});

var togglePlaylist = 0;
$('#back').on('click',function(){
// alert();  
  var backbutton = $('#backbutton');
  backbutton.show();
  backbutton.css('opacity', 1); 

  var backStationbutton = $('#backStationbutton');
  backStationbutton.hide();

  if(togglePlaylist == 0){
    $('#playlist').css("transform","translateX(0)");
    togglePlaylist = 1;
  }
  else{
    $('#playlist').css("transform","translateX(100%)");
    togglePlaylist = 0;
  }
});

$('#backbutton').on('click',function(){

var backbutton = $('#backbutton');
backbutton.hide();

if(togglePlaylist == 0){
  $('#playlist').css("transform","translateX(0)");
  togglePlaylist = 1;
}
else{
  $('#playlist').css("transform","translateX(100%)");
  togglePlaylist = 0;
}
});


// Station

var togglePlaylist = 0;
$('#backstation').on('click',function(){

  var backStationbutton = $('#backStationbutton');
  backStationbutton.show();

  var backbutton = $('#backbutton');
  backbutton.hide();

  if(togglePlaylist == 0){
    $('#playlistStation').css("transform","translateX(0)");
    togglePlaylist = 1;
  }
  else{
    $('#playlistStation').css("transform","translateX(100%)");
    togglePlaylist = 0;
  }
});

$('#backStationbutton').on('click',function(){

var backStationbutton = $('#backStationbutton');
  backStationbutton.hide();

if(togglePlaylist == 0){
  $('#playlistStation').css("transform","translateX(0)");
  togglePlaylist = 1;
}
else{
  $('#playlistStation').css("transform","translateX(100%)");
  togglePlaylist = 0;
}
});

});

$('.like').click(function(){
        var  audio_id = document.querySelector(".like").getAttribute("data-audio-id");
        // alert(audio_id);

                var likeButton = $(this);
                var audio_id = likeButton.data("audio-id");

                // Toggle the color of the like button while clicking
                if (likeButton.css("color") === "rgb(128, 128, 128)") {
                    likeButton.css("color", "white");
                } else {
                    likeButton.css("color", "grey");
                }

                var dislikeButton = document.querySelector(".dislike");

                // Check and set the color for the dislike button
                    dislikeButton.style.color = "grey";

                
                var like = 1;
                $.ajax({
                url: "<?php echo URL::to('/').'/like-audio';?>",
                type: "POST",
                data: {like: like,audio_id:audio_id, _token: '<?= csrf_token(); ?>'},
                dataType: "html",
                success: function(data) {
                    $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">you have liked this media</div>');
               setTimeout(function() {
                $('.add_watch').slideUp('fast');
               }, 3000);
                    
                }
            });           
  });

  
	$('.dislike').click(function(){
        var  audio_id = document.querySelector(".dislike").getAttribute("data-audio-id");
        // alert(audio_id);

                var DislikeButton = $(this);
                var audio_id = DislikeButton.data("audio-id");
                
                // Toggle the color of the like button while clicking
                if (DislikeButton.css("color") === "rgb(128, 128, 128)") {
                    DislikeButton.css("color", "white");
                } else {
                    DislikeButton.css("color", "grey");
                }

                var likeButton = document.querySelector(".like");

                // Check and set the color for the like button
                    likeButton.style.color = "grey";

                var like = 1;
                $.ajax({
                url: "<?php echo URL::to('/').'/dislike-audio';?>",
                type: "POST",
                data: {like: like,audio_id:audio_id, _token: '<?= csrf_token(); ?>'},
                dataType: "html",
                success: function(data) {
                  $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">you have removed from liked this media </div>');
                setTimeout(function() {
                  $('.remove_watch').slideUp('fast');
                }, 3000);
                    
                }
            });           
  });
  

  // Auto Create Station 
  $('#station_error').hide();

  $('#station_save').click(function(){
        var  audio_id = document.querySelector(".station_auto_create").getAttribute("data-audio-id");  
        var station_name = $('#station_name').val();      
        $('#station_error').hide();
        if(station_name != ''){

       
                $.ajax({
                url: "<?php echo URL::to('/').'/auto-station/store';?>",
                type: "POST",
                data: {station_name:station_name,audio_id:audio_id, _token: '<?= csrf_token(); ?>'},
                dataType: "html",
                success: function(data) {
                  if(data == 1){

                      $("body").append('<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Created Music Station</div>');
                    setTimeout(function() {
                      $('.add_watch').slideUp('fast');
                    }, 3000);

                    location.reload();

                  }else{
                    $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Unable to Create Music Station </div>');
                    setTimeout(function() {
                      $('.remove_watch').slideUp('fast');
                    }, 3000);
                  }
                    
                }
            });   
        }else{
        $('#station_error').show();

          $("body").append('<div class="remove_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; text-align: center; right: 0; width: 225px; padding: 11px; background: hsl(11deg 68% 50%); color: white;">Need Music Station Name </div>');
                    setTimeout(function() {
                      $('.remove_watch').slideUp('fast');
                    }, 3000);
                  }
                        
       
  });


</script>


<script src="https://checkout.stripe.com/checkout.js"></script>

<?php                 
$payment_settings = App\PaymentSetting::first();

$mode = $payment_settings->live_mode;
if ($mode == 0) {
    $secret_key = $payment_settings->test_secret_key;
    $publishable_key = $payment_settings->test_publishable_key;
} elseif ($mode == 1) {
    $secret_key = $payment_settings->live_secret_key;
    $publishable_key = $payment_settings->live_publishable_key;
} else {
    $secret_key = null;
    $publishable_key = null;
} ?>

<input type="hidden" id="publishable_key" name="publishable_key" value="<?php echo $publishable_key; ?>">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

function stripe_checkout() {
  
  var publishable_key = $('#publishable_key').val();

  var  audio_id = document.querySelector(".like").getAttribute("data-audio-id");

  var audio_id = $('#audio_id').val();

  var ppv_price = document.getElementById("enable_button").getAttribute("data-price");
  var audio_id = document.getElementById("enable_button").getAttribute("audio-id");

  // alert(ppv_price);
  // alert(audio_id);
  var handler = StripeCheckout.configure({

      key: publishable_key,
      locale: 'auto',
      token: function(token) {
          // You can access the token ID with `token.id`.
          // Get the token ID to your server-side code for use.
          console.log('Token Created!!');
          console.log(token);
          $('#token_response').html(JSON.stringify(token));

          $.ajax({
              url: '<?php echo URL::to('purchase-audio'); ?>',
              method: 'post',
              data: {
                  "_token": "<?php echo csrf_token(); ?>",
                  tokenId: token.id,
                  amount: ppv_price,
                  audio_id: audio_id
              },
              success: (response) => {
                  // alert("You have done  Payment !");
                  swal("You have done  Payment !");

                  setTimeout(function() {
                      location.reload();
                  }, 2000);

              },
              error: function (xhr) {
                console.log('Event handler executed');
                console.log(xhr.responseJSON.message);
                // alert(xhr.responseJSON.message);
                swal(xhr.responseJSON.message);
                  //swal("Oops! Something went wrong");
                  /* setTimeout(function() {
                  location.reload();
                  }, 2000);*/
              }
          })
      }
  });


  handler.open({
      name: '<?php $settings = App\Setting::first();
      echo $settings->website_name; ?>',
      description: 'Purchase a Audio',
      amount: ppv_price * 100
  });
}

</script>

<style>

.swal2-container.swal2-center>.swal2-popup {
        background: linear-gradient(180deg, #C4C4C4 50%, rgba(196, 196, 196, 0) 100%);

    }

    .swal2-html-container {
        color: #fff !important;
    }
    
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
    /* z-index: 999; */
}
#top-bar > *{ display:inline-block; }
#top-bar button{ margin:0;background: inherit; border: none; color: white; font-size: 100%;vertical-align:middle;transform:translateY(-40%);padding: 5px 10px;}
#about-song{ width: 60%; margin: 0 5%; line-height: 1vh; font-size:70%;}
.artist-name{ color: #ffffff79;}
@media only screen and (max-width: 340px){
  #top-bar > button{ font-size: 15px; }
  #top-bar > #about-song *{ font-size:120%;line-height:1.2; }
  #menu > button{ font-size: 5vw !important; padding: 4px 6px !important;  }
  #progress-bar{
    width: 50% !important;
  }
}
@media (max-width:460px){
  #top-bar > #about-song *{ font-size:140%;line-height:1.2; }
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
#currentTime,#totalTime{transform:translateY(-28%);padding: 0 2%;font-size: 3vh}
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
  position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 100%;
    z-index: 99;
    color: var(--lyrics-color);
    background-color: #857f8599;
    background-image: linear-gradient(315deg, #837f5a99 0%, #0f0d4d99 74%);
    transition: cubic-bezier(0.175, 0.885, 0.32, 1.275) 1s all;
    transform: translateX(100%);
}
#show-box {
    position: absolute;
    top: 65%;
    left: 50%;
    height: 55vh;
    width: 83%;
    padding: 4vh 0vh;
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
    display: inline-block;
    height: 142px;
    width: 80px;
    padding: 0px 0px;
    background: #00000089;
    text-align: center;
    font-size: 70%;
    border-radius: 8px;
    margin: 4px 10px;
    overflow: hidden;
    cursor: pointer;
}

#show-list-Station{
  position: relative;
  transition: ease-in-out 0.5s all;
  height: 100%;
}
#show-list-Station .float-song-card{
    position: relative;
    display: inline-block;
    height: 142px;
    width: 80px;
    padding: 0px 0px;
    background: #00000089;
    text-align: center;
    font-size: 70%;
    border-radius: 8px;
    margin: 4px 10px;
    overflow: hidden;
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
.float-song-card > h2, .float-song-card > h4 {
    position: relative;
    z-index: 49;
    margin: 2px 0;
    visibility: hidden;
}
#playlist > #label{
  width:100%;
  text-align: center;
  font-size:100%;
}
#playlist > #label > h1{ line-height:0;margin: 6vh 0 2.5vh;}
#search{
  background: transparent;
    color: white;
    border: 1px solid #5c5c5c99;
    padding: 1vh 1.5vw;
    margin: 2.5vh 0;
    border-radius: 3px;
    font-family: FontAwesome,"Montserrat",sans-serif;
    transition: cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.5s all;
    width: 25vw;
    background: #4444448a;
}
#search:focus{
  outline: none;
    border-radius: 3px;
    border: 1px solid #818181;
    width: 25vw;
    padding: 1vh 1.5vw;
    background: inherit;
  }

  @media (max-width:655px){
    .station_auto_create{
        display: none;
    }
  }
  @media (min-width:654px){
    .addqubt{
      display: none;
    }
  }
@media only screen and (max-height: 500px){
  #show-list .float-song-card{font-size:40% !important;height:60px;width:50px;}
  #playlist > #label{font-size:70%;}
  #search{font-size:10px;padding:4px;width:10px;}
  #search:focus{width:40vw;}
  #playlist > #label > h1{margin:8vh 0 4vh !important;}
}

@media only screen and (max-height: 500px){
  #show-Station .float-song-card{font-size:40% !important;height:60px;width:50px;}
  #playlistStation > #label{font-size:70%;}
  #search{font-size:10px;padding:4px;width:10px;}
  #search:focus{width:40vw;}
  #playlistStation > #label > h1{margin:8vh 0 4vh !important;}
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

#playlistStation{
  position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 100%;
    z-index: 99;
    color: var(--lyrics-color);
    background-color: #857f8599;
    background-image: linear-gradient(315deg, #837f5a99 0%, #0f0d4d99 74%);
    transition: cubic-bezier(0.175, 0.885, 0.32, 1.275) 1s all;
    transform: translateX(100%);
}

#playlistStation > #label{
  width:100%;
  text-align: center;
  font-size:100%;
}
#playlistStation > #label > h1{ line-height:0;margin: 6vh 0 2.5vh;}


#Stationsearch{
  background: transparent;
    color: white;
    border: 1px solid #5c5c5c99;
    padding: 1vh 1.5vw;
    margin: 2.5vh 0;
    border-radius: 3px;
    font-family: FontAwesome,"Montserrat",sans-serif;
    transition: cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.5s all;
    width: 25vw;
    background: #4444448a;
}
#Stationsearch:focus{
  outline: none;
    border-radius: 3px;
    border: 1px solid #818181;
    width: 25vw;
    padding: 1vh 1.5vw;
    background: inherit;
  }

  #backbutton{
    opacity: 1;
    margin: 0;
    position: relative;
    background: inherit;
    border: none;
    color: white;
    font-size: 100%;
    vertical-align: middle;
    transform: translateY(-40%);
    padding: 5px 10px;
    left: 5%;
  }
  
</style>
<?php include(public_path('themes/theme4/views/footer.blade.php')); ?>
