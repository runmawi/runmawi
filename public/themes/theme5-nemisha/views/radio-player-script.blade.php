<script type="text/javascript">
    $('#store-play-list').click(function(){
                    $('#my-playlist-form').submit();
                });
    
    var base_url = $('#base_url').val();
    
    $(document).ready(function(){
    $('.favorite').click(function(){
    if($(this).data('authenticated')){
    $.post('/saka/favorite', { audio_id : $(this).data('audioid'), _token: '<?= csrf_token(); ?>' }, function(data){});
    $(this).toggleClass('active');
    } else {
    window.location = base_url+'/signup';
    }
    });
    
    //watchlater
    $('.watchlater').click(function(){
    if($(this).data('authenticated')){
    $.post('<?= URL::to('watchlater') ?>', { audio_id : $(this).data('audioid'), _token: '<?= csrf_token(); ?>' }, function(data){});
    $(this).toggleClass('active');
    $(this).html("");
    if($(this).hasClass('active')){
    $(this).html('<a><i class="fa fa-check"></i>Watch Later</a>');
    }else{
    $(this).html('<a><i class="fa fa-clock-o"></i>Watch Later</a>');
    }
    
    } else {
    window.location = '<?= URL::to('login') ?>';
    }
    });
    
    
    //My Wishlist
    $('.mywishlist').click(function(){
    if($(this).data('authenticated')){
    $.post('<?= URL::to('mywishlist') ?>', { audio_id : $(this).data('audioid'), _token: '<?= csrf_token(); ?>' }, function(data){});
    $(this).toggleClass('active');
    $(this).html("");
    if($(this).hasClass('active')){
    $(this).html('<a><i class="fa fa-check"></i>Wishlisted</a>');
    }else{
    $(this).html('<a><i class="fa fa-plus"></i>Add Wishlist</a>');
    }
    
    } else {
    window.location = '<?= URL::to('login') ?>';
    }
    });
    
    });
    
 </script>
 <script type="text/javascript">
    //Audio Favorite
          $('.favorite').click(function(){
            if($(this).data('authenticated')){
              $.post('<?= URL::to('favorite') ?>', { audio_id : $(this).data('audio_id'), _token: '<?= csrf_token(); ?>' }, function(data){});
              $(this).toggleClass('active');
              $(this).html("");
                  if($(this).hasClass('active')){
                    $(this).html('<i class="fa fa-heart"></i>');
                  }else{
                    $(this).html('<i class="fa fa-heart-o"></i>');
                  }
            } else {
              window.location = '<?= URL::to('login') ?>';
            }
          });
    
 </script>
 <script>
    function createTrackItem(index,name,duration){
    
      var trackItem = document.createElement('div');
      trackItem.setAttribute("class", "playlist-track-ctn");
      trackItem.setAttribute("id", "ptc-"+index);
      trackItem.setAttribute("data-index", index);
      document.querySelector(".playlist-ctn").appendChild(trackItem);
    
      var playBtnItem = document.createElement('div');
      playBtnItem.setAttribute("class", "playlist-btn-play");
      playBtnItem.setAttribute("id", "pbp-"+index);
      document.querySelector("#ptc-"+index).appendChild(playBtnItem);
    
      var btnImg = document.createElement('i');
      btnImg.setAttribute("class", "fas fa-play");
      btnImg.setAttribute("height", "40");
      btnImg.setAttribute("width", "40");
      btnImg.setAttribute("id", "p-img-"+index);
      document.querySelector("#pbp-"+index).appendChild(btnImg);
    
      var trackInfoItem = document.createElement('div');
      trackInfoItem.setAttribute("class", "playlist-info-track");
      trackInfoItem.innerHTML = name
      document.querySelector("#ptc-"+index).appendChild(trackInfoItem);
    
      var trackDurationItem = document.createElement('div');
      trackDurationItem.setAttribute("class", "playlist-duration");
    
      var measuredTime = new Date(null);
      measuredTime.setSeconds(duration); 
      var MHSTime = measuredTime.toISOString().substr(11, 8);
      
      trackDurationItem.innerHTML = MHSTime
    
      document.querySelector("#ptc-"+index).appendChild(trackDurationItem);
    
    }

 
    var listAudio = <?php echo json_encode($ablum_audios); ?>;
    
    for (var i = 0; i < listAudio.length; i++) {
        createTrackItem(i,listAudio[i].title,listAudio[i].duration);
    }
    
    var indexAudio = 0;
    
    function loadNewTrack(index){
      
      var player = document.querySelector('#source-audio')
      player.src = listAudio[index].mp3_url
      document.querySelector('.title').innerHTML = listAudio[index].title
      var image = document.querySelector('#audio_img')
      image.src = '<?php echo URL::to('/public/uploads/images/');?>' + '/' + listAudio[index].image
      
      var divElement = document.getElementById("player-ctn");
      var player_imageURL = '<?php echo URL::to('/public/uploads/images/');?>' + '/' + listAudio[index].player_image 
      divElement.style.backgroundImage = "linear-gradient(to left, rgba(0, 0, 0, 0.25)0%, rgba(117, 19, 93, 1))," + "url('" + player_imageURL + "')";
    
      this.currentAudio = document.getElementById("myAudio");
      this.currentAudio.load()
      this.toggleAudio()
      this.updateStylePlaylist(this.indexAudio,index)
      this.indexAudio = index;
    }
    
    var playListItems = document.querySelectorAll(".playlist-track-ctn");
    
    for (let i = 0; i < playListItems.length; i++){
      playListItems[i].addEventListener("click", getClickedElement.bind(this));
    }
    
    function getClickedElement(event) {
      for (let i = 0; i < playListItems.length; i++){
        if(playListItems[i] == event.target){
          var clickedIndex = event.target.getAttribute("data-index")
          if (clickedIndex == this.indexAudio ) { // alert('Same audio');
              this.toggleAudio()
          }else{
              loadNewTrack(clickedIndex);
          }
        }
      }
    }
    
    document.querySelector('#source-audio').src = <?php echo json_encode(@$audios->mp3_url) ; ?>  
    document.querySelector('.title').innerHTML = <?php echo json_encode(@$audios->title) ; ?>  
    var player_images = '<?php echo URL::to('/public/uploads/images/');?>'; 
    var audio_images = player_images +'/' + <?php echo json_encode(@$audio->image) ; ?>;
    $("#audio_img").attr('src', audio_images);
    
    var currentAudio = document.getElementById("myAudio");
    currentAudio.load()
    currentAudio.onloadedmetadata = function() {
          document.getElementsByClassName('duration')[0].innerHTML = this.getMinutes(this.currentAudio.duration)
    }.bind(this);
    
    var interval1;
    
    function toggleAudio() {
    
      if (this.currentAudio.paused) {
        document.querySelector('#icon-play').style.display = 'none';
        document.querySelector('#icon-pause').style.display = 'block';
        document.querySelector('#ptc-'+this.indexAudio).classList.add("active-track");
        this.playToPause(this.indexAudio)
        this.currentAudio.play();
      }else{
        document.querySelector('#icon-play').style.display = 'block';
        document.querySelector('#icon-pause').style.display = 'none';
        this.pauseToPlay(this.indexAudio)
        this.currentAudio.pause();
      }
    }
    
    function pauseAudio() {
      this.currentAudio.pause();
      clearInterval(interval1);
    }
    
    var timer = document.getElementsByClassName('timer')[0]
    
    var barProgress = document.getElementById("myBar");
    
    
    var width = 0;
    
    function onTimeUpdate() {
      var t = this.currentAudio.currentTime
      timer.innerHTML = this.getMinutes(t);
      this.setBarProgress();
      if (this.currentAudio.ended) {
        document.querySelector('#icon-play').style.display = 'block';
        document.querySelector('#icon-pause').style.display = 'none';
        this.pauseToPlay(this.indexAudio)
        if (this.indexAudio < listAudio.length-1) {
            var index = parseInt(this.indexAudio)+1
            this.loadNewTrack(index)
        }
      }
    }
    
    
    function setBarProgress(){
      var progress = (this.currentAudio.currentTime/this.currentAudio.duration)*100;
      document.getElementById("myBar").style.width = progress + "%";
    }
    
    
    function getMinutes(t){
      var min = parseInt(parseInt(t)/60);
      var sec = parseInt(t%60);
      if (sec < 10) {
        sec = "0"+sec
      }
      if (min < 10) {
        min = "0"+min
      }
      return min+":"+sec
    }
    
    var progressbar = document.querySelector('#myProgress')
    progressbar.addEventListener("click", seek.bind(this));
    
    
    function seek(event) {
      var percent = event.offsetX / progressbar.offsetWidth;
      this.currentAudio.currentTime = percent * this.currentAudio.duration;
      barProgress.style.width = percent*100 + "%";
    }
    
    function forward(){
      this.currentAudio.currentTime = this.currentAudio.currentTime + 5
      this.setBarProgress();
    }
    
    function rewind(){
      this.currentAudio.currentTime = this.currentAudio.currentTime - 5
      this.setBarProgress();
    }
    
    
    function next(){
      if (this.indexAudio <listAudio.length-1) {
          var oldIndex = this.indexAudio
          this.indexAudio++;
          updateStylePlaylist(oldIndex,this.indexAudio)
          this.loadNewTrack(this.indexAudio);
      }
    }
    
    function previous(){
      if (this.indexAudio>0) {
          var oldIndex = this.indexAudio
          this.indexAudio--;
          updateStylePlaylist(oldIndex,this.indexAudio)
          this.loadNewTrack(this.indexAudio);
      }
    }
    
    function updateStylePlaylist(oldIndex,newIndex){
      document.querySelector('#ptc-'+oldIndex).classList.remove("active-track");
      this.pauseToPlay(oldIndex);
      document.querySelector('#ptc-'+newIndex).classList.add("active-track");
      this.playToPause(newIndex)
    }
    
    function playToPause(index){
      var ele = document.querySelector('#p-img-'+index)
      ele.classList.remove("fa-play");
      ele.classList.add("fa-pause");
    }
    
    function pauseToPlay(index){
      var ele = document.querySelector('#p-img-'+index)
      ele.classList.remove("fa-pause");
      ele.classList.add("fa-play");
    }
    
    
    function toggleMute(){
      var btnMute = document.querySelector('#toggleMute');
      var volUp = document.querySelector('#icon-vol-up');
      var volMute = document.querySelector('#icon-vol-mute');
      if (this.currentAudio.muted == false) {
         this.currentAudio.muted = true
         volUp.style.display = "none"
         volMute.style.display = "block"
      }else{
        this.currentAudio.muted = false
        volMute.style.display = "none"
        volUp.style.display = "block"
      }
    }
      
 </script>