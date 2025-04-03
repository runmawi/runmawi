@php
include(public_path('themes/theme5-nemisha/views/header.php'));
$settings = App\Setting::first(); 
@endphp

<style type="text/css">
      #myProgress {
    background-color: #8b0000; 
    cursor: pointer;
    border-radius: 10px;
  }
  
  #myBar {
    width: 0%;
    height: 3px;
    background-color:red;
    border-radius: 10px;
  }
      .title{
          text-align: left!important;
          color: #fff;
      }
  .logo {
    fill: red;
  }
    .fa-plus{
        color: Red;
    }
      .play-border{
          border:1px solid rgba(255,255,255,0.3);
          border-radius: 10px;
          padding: 10px;
          border-width:2px;
      }

  .btn-action{
    cursor: pointer;
    /*padding-top: 10px;*/
    width: 30px;
  }

  .btn-ctn{
    display: flex;
   /* align-items: center;
    justify-content: space-evenly;*/
  }
  .infos-ctn{
  padding-top: 8px;
      display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .btn-ctn > div {
  padding: 5px;
  margin-top: 18px;
  margin-bottom: 18px;
  }

  .infos-ctn > div {
  margin-bottom: 8px;
  color: #fff;
      text-align: left;
  }

  .first-btn{
    margin-left: 3px;
  }

  .duration{
    margin-left: 10px;
  }

  .title{
    margin-left: 10px;
    /*
    text-align: center;
      border-top:1px solid rgba(255, 255, 255,0.1)*/
  }
    ol{
        list-style: decimal-leading-zero;
    }

  .player-ctn{
    
            }
 
  padding: 25px;
  /*background: linear-gradient(180deg, #151517 127.69%, #282834 0% );*/
      box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);

    margin:auto;
    
      border-radius: 10px;
  
  }

  .playlist-track-ctn{
    display: flex;
     padding: 6px 6px 6px 15px;
      border-radius: 5px;
    
      background-color: #464646;
    margin-top: 3px;
      margin-right: 10px;
    
    cursor: pointer;
      align-items: center;
  }
  .playlist-track-ctn:last-child{
    /*border: 1px solid #ffc266; */
  }

  .playlist-track-ctn > div{
    margin:5px;
      color: #fff;
  }
  .playlist-info-track{
    width: 80%;
    
      padding: 2px;
  }
  .playlist-info-track,.playlist-duration{
    /*padding-top: 7px;
    padding-bottom: 7px;*/
    color: #e9cc95;
    font-size: 14px;
    pointer-events: none;
  }
    .playlist-ctn {
  
  }
      .playlist-ctn::-webkit-scrollbar {
  width: 2px;
  }
  .playlist-ctn::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.2);
      
  }
  .playlist-ctn::-webkit-scrollbar-thumb {
    background-color: red;
    border-radius: 2px;
    border: 2px solid red;
      width: 2px;
  }
    .plus-minus-toggle {
  cursor: pointer;
  
  position: relative;
  width: 21px;
  &:before,
  &:after{
    background: red;
    content: '';
    height: 5px;
    left: 0;
    position: absolute;
    top: 0;
    width: 21px;
    transition: transform 500ms ease;
  }
  &:after {
    transform-origin: center;
  }
  &.collapsed {
    &:after {
      transform: rotate(90deg);
    }
    &:before {
      transform: rotate(180deg);
    }
  }
}
  .playlist-ctn{
    padding-bottom: 20px;
      /*overflow: scroll;
      scroll-behavior: auto;
      min-height:335px;
      scrollbar-color: rebeccapurple green!important;
      overflow-x: hidden;*/
  }
  .active-track{
    background: #4d4d4d;
    color: #ffc266 !important;
    font-weight: bold;
    
  }

  .active-track > .playlist-info-track,.active-track >.playlist-duration,.active-track > .playlist-btn-play{
    color: #ffc266 !important;
  }


  .playlist-btn-play{
      color: #fff!important;
    pointer-events: none;
    padding-top: 5px;
    padding-bottom: 5px;
  }
  .fas{
    color: rgb(255,0,0)!important;
    font-size: 14px;
  }
      .img-responsive{
          border-radius: 10px;
      }
      
  .fa-heart{color: red !important;}
  .audio-js *, .audio-js :after, .audio-js :before {box-sizing: inherit;display: grid;}
  .vjs-big-play-button{
  top: 50% !important;
  left: 50% !important;
  margin: -25px 0 0 -25px;
  width: 50px !important;
  height: 50px !important;
  border-radius: 25px !important;
  }
  .vjs-texttrack-settings { display: none; }
  .audio-js .vjs-big-play-button{ border: none !important; }
  .bd{
  background: #2bc5b4!important;}
  .bd:hover{

  }
      th,td {
      padding: 10px;
      color: #fff!important;
  }
      tr{
          border:#141414;
      }
  p{
  color: #fff;
  }
  .flexlink{
  position: relative;
  top: 63px;
  left: -121px;
  }
  #ff{
  border: 1px solid #fff;
      border-radius: 50%;
      padding: 5px;
      font-size: 12px;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
  }
  li{
  list-style: none; 
  }
  .audio-lp{
  background: #000000;
  padding: 33px;
      border-radius: 25px;

  }

  .audio-lpk:hover {
  background-color: #1414;
  color:#fff;
  border: 1px #e9ecef;
  border-radius: .25rem;
  border-bottom-left-radius:0;
  border-bottom-right-radius:0;

  }
  .aud-lp{
  border-bottom: 1px solid #141414;
  }
    .btn-action i{
        color: Red;
    }
</style>

<section style="background-image:linear-gradient(to bottom, rgba(0, 0, 0, 0.25)0%, rgba(0, 0, 0, 1)80%), url(<?= @$MyPlaylist->image ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:cover;">
    <div class="container-fluid">
        <br>
        <br>
        <div class="row">
            <div class="col-lg-7">
                <div class="row align-items-center">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-5">
                         <img src="<?= @$MyPlaylist->image ?>" height="250" width="250" class="img-responsive" >
                    </div>
                    <div class="col-lg-4 p-0">
                <p>PLAYLIST</p>
                <h3>My Playlist</h3>
                        


    <div class="btn-ctn">
          <div class="btn-action" onclick="toggleAudio()">
          <div id="btn-faws-play-pause">
            <a href="{{URL::to('/').'/playlist/play/'.@$MyPlaylist->slug}}"><i class='fas fa-play' id="icon-play"></i></a>
            <i class='fas fa-pause' id="icon-pause" style="display: none"></i>
          </div>
      </div>
        <div class="btn-action" >
          <div id="">
            <a href="{{ URL::to('playlist/delete').'/'. @$MyPlaylist->id }}">
            <i class='fa fa-trash-o' id="icon-play"></i></a>
           
          </div>
      </div>
        <div class="btn-action" >
          <div id="">
            <i class='fa fa-share-alt'type="button" id="dropdownMenuButton icon-play" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id=""></i>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"  style="background-color: black;border:1px solid white;padding: 0;">
        <a class="dropdown-item popup" href="https://twitter.com/intent/tweet?text=<?= $media_url ?>" target="_blank">
            <i class="fa fa-twitter" style="color: #00acee;padding: 10px;border-radius: 50%;font-size: 26px;"></i>
        </a>
        <div class="divider" style="border:1px solid white"></div>
        <a class="dropdown-item popup" href="https://www.facebook.com/sharer/sharer.php?u=<?= $media_url ?>" target="_blank"><i class="fa fa-facebook" style="color: #3b5998;padding: 10px;border-radius: 50%; font-size: 26px;"></i></a>
    </div>
</div>&nbsp;
          </div>
      </div>
     
     

    

  

    

    </div>
  </div>
</div>

            </div>
                </div>
                 <hr>
        
            </div> 
            
     
    <div class="container-fluid">
 <div class="playlist-ctn">
             <h4 class="mb-3">Tracks</h4>
     <table class="w-100">
     <?php foreach ($All_Audios as $key => $audio) { ?>
            <tr>
                    <td> {{ $key+1 }}</td>
                    <td><img src="<?= URL::to('/').'/public/uploads/images/' . $audio->image ?>" class="" height="50" width="50"></td>
                    <td> <h4>{{ $audio->title }}</h4></td>
                    <td>{{ $audio->albumname }}</td>
                    <td><div class="plus-minus-toggle collapsed add_audio_playlist" data-authenticated="<?= !Auth::guest() ?>" data-audioid="<?= $audio->id ?>"></div></td>
                    <td><?php echo gmdate("H:i:s", $audio->duration);?></td>
              </tr>
      <?php } ?>
      
        
     </table>
     <ol>
         <li>
             <div class="track d-flex">
                 
                
             </div>
         </li>
     </ol>
    </div></div>   
    
</section>

<?php if(isset($playlist_audio)){ $playlist_audio_count = count(@$playlist_audio) ; }else{$playlist_audio_count = 0 ;} if( $playlist_audio_count == 0 ){ ?>

  <div class="col-md-12 text-center mt-4" style="background: url(<?=URL::to('/assets/img/watch.png') ?>);heigth: 500px;background-position:center;background-repeat: no-repeat;background-size:contain;height: 500px!important;">
      <p ><h3 class="text-center">No Audio Available</h3>
  </div>
  
<?php }else{ ?>

<?php if (isset($error)) { ?>

  <h2 class="text-center"><?php echo $message;?></h2>

<?php } else { ?>

  <input type="hidden" value="<?php echo URL('/');?>" id="base_url">


  <div id="audio_bg" >
    <div class="container-fluid">
      <div class="row album-top-30 mt-4 align-items-center">

        <div class="col-lg-8">
          <audio id="myAudio" ontimeupdate="onTimeUpdate()">
            <source id="source-audio" src="" type="audio/mpeg"> Your browser does not support the audio element.
          </audio>
              <div class="cinetpay_button">
                  <!-- CinetPay Button -->
                  <button onclick="cinetpay_checkout()" id="enable_button" style="display:none;margin-left: 72%;position: absolute;margin-top: 20px;"
                      class="btn2  btn-outline-primary">Purchase to Play Audio</button>

                                     <!-- Subscriber Button -->
                         
                                      <a href="<?php echo URL::to('/becomesubscriber'); ?>"  ><button  id="Subscriber_button" style="display:none;margin-left: 72%;position: absolute;margin-top: 20px;"
                      class="btn2  btn-outline-primary">Become Subscriber</button> 
                      </a>


            
              </div>
          

<div class="clear"></div>  

<?php } ?>

<?php } ?>
<input type="hidden" id="MyPlaylist_slug" value="{{ @$MyPlaylist->slug }}">
<script>
    $('.add_audio_playlist').click(function() {
      
        var audioid = $(this).data('audioid');
        var playlistid = <?php echo json_encode(@$MyPlaylist->id); ?>;

        // alert(playlistid);

        if ($(this).data('authenticated')) {
            $(this).toggleClass('active');
            if ($(this).hasClass('active')) {
        // alert(audioid);

                $.ajax({
                    url: "<?php echo URL::to('/add_audio_playlist'); ?>",
                    type: "POST",
                    data: {
                        audioid: $(this).data('audioid'),
                        playlistid: <?php echo json_encode(@$MyPlaylist->id); ?>,

                        _token: '<?= csrf_token() ?>'
                    },
                    dataType: "html",
                    success: function(data) {
                        if (data == "Added To Wishlist") {

                            // $('#' + audioid).text('');
                            // $('#' + audioid).text('Remove From Wishlist');
                            $("body").append(
                                '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to Playlist</div>'
                            );
                            setTimeout(function() {
                                $('.add_watch').slideUp('fast');
                            }, 3000);
                        } else {

                      
                        }
                    }
                });
            }
        } else {
            window.location = '<?= URL::to('login') ?>';
        }
    });
</script>

<script type="text/javascript">
$(document).ready(function() {
$(".my-div").on("contextmenu",function(){
return false;
}); 
});
</script>

<!--<script type="text/javascript">

var base_url = $('#base_url').val();

$(document).ready(function(){
$('#audio_container').fitVids();

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

<!-- RESIZING FLUID VIDEO for VIDEO JS -->



</div>



<!-- Cinet Pay CheckOut -->

<script src="https://cdn.cinetpay.com/seamless/main.js"></script>

<script>

 
    var user_name = '<?php if (!Auth::guest()) {
        Auth::User()->username;
    } else {
    } ?>';
    var email = '<?php if (!Auth::guest()) {
        Auth::User()->email;
    } else {
    } ?>';
    var mobile = '<?php if (!Auth::guest()) {
        Auth::User()->mobile;
    } else {
    } ?>';
    var CinetPay_APIKEY = '<?= @$CinetPay_payment_settings->CinetPay_APIKEY ?>';
    var CinetPay_SecretKey = '<?= @$CinetPay_payment_settings->CinetPay_SecretKey ?>';
    var CinetPay_SITE_ID = '<?= @$CinetPay_payment_settings->CinetPay_SITE_ID ?>';
    var video_id = $('#video_id').val();

    // var url       = window.location.href;
    // alert(window.location.href);

    function cinetpay_checkout() {

      var ppv_price = document.getElementById("enable_button").getAttribute("data-price");
      var audio_id = document.getElementById("enable_button").getAttribute("audio-id");

  
        CinetPay.setConfig({
            apikey: CinetPay_APIKEY, //   YOUR APIKEY
            site_id: CinetPay_SITE_ID, //YOUR_SITE_ID
            notify_url: window.location.href,
            return_url: window.location.href,
            // mode: 'PRODUCTION'

        });
        CinetPay.getCheckout({
            transaction_id: Math.floor(Math.random() * 100000000).toString(), // YOUR TRANSACTION ID
            amount: ppv_price,
            currency: 'XOF',
            channels: 'ALL',
            description: 'Test paiement',
            //Provide these variables for credit card payments
            customer_name: user_name, //Customer name
            customer_surname: user_name, //The customer's first name
            customer_email: email, //the customer's email
            customer_phone_number: "088767611", //the customer's email
            customer_address: "BP 0024", //customer address
            customer_city: "Antananarivo", // The customer's city
            customer_country: "CM", // the ISO code of the country
            customer_state: "CM", // the ISO state code
            customer_zip_code: "06510", // postcode

        });
        CinetPay.waitResponse(function(data) {
            if (data.status == "REFUSED") {

                if (alert("Your payment failed")) {
                    window.location.reload();
                }
            } else if (data.status == "ACCEPTED") {
              $.ajax({
                    url: '<?php echo URL::to('CinetPay-audio-rent'); ?>',
                    type: "post",
                    data: {
                        _token: '<?php echo csrf_token(); ?>',
                        amount: ppv_price,
                        audio_id: audio_id,

                    },
                    success: function(value) {
                        alert("You have done  Payment !");
                        setTimeout(function() {
                            location.reload();
                        }, 2000);

                    },
                    error: (error) => {
                        swal('error');
                    }
                });

            }
        });
        CinetPay.onError(function(data) {
            console.log(data);
        });
    }
</script>
<script>
    $(function() {
  $('.plus-minus-toggle').on('click', function() {
    $(this).toggleClass('collapsed');

    var audioid = $(this).data('audioid');
        var playlistid = <?php echo json_encode(@$MyPlaylist->id); ?>;

        // alert(playlistid);

        if ($(this).data('authenticated')) {
            $(this).toggleClass('active');
            if ($(this).hasClass('active')) {
        // alert(audioid);

                $.ajax({
                    url: "<?php echo URL::to('/add_audio_playlist'); ?>",
                    type: "POST",
                    data: {
                        audioid: $(this).data('audioid'),
                        playlistid: <?php echo json_encode(@$MyPlaylist->id); ?>,

                        _token: '<?= csrf_token() ?>'
                    },
                    dataType: "html",
                    success: function(data) {
                        if (data == "Added To Wishlist") {

                            // $('#' + audioid).text('');
                            // $('#' + audioid).text('Remove From Wishlist');
                            $("body").append(
                                '<div class="add_watch" style="z-index: 100; position: fixed; top: 73px; margin: 0 auto; left: 81%; right: 0; text-align: center; width: 225px; padding: 11px; background: #38742f; color: white;">Media added to Playlist</div>'
                            );
                            setTimeout(function() {
                                $('.add_watch').slideUp('fast');
                            }, 3000);
                        } else {

                      
                        }
                    }
                });
            }
        } else {
            window.location = '<?= URL::to('login') ?>';
        }
  });
});

</script>
@php
include(public_path('themes/default/views/footer.blade.php'));
@endphp