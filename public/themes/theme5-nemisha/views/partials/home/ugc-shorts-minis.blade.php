<style>
    .shorts-minis-videos img{
        width: 100%;
        height: 120px;
        border-radius: 15px;
    }

    .shorts-minis {
            color: white;
            height: 170px;
            width: 35px;
            position: absolute;
            z-index: 9999;
            top: 90%;
            right: 0;
            background: #ED563C;
            transition: width 0.8s, height 0.8s, margin-right 0.8s;
            overflow-x: hidden;
            white-space: nowrap;
            cursor: pointer;
}
</style>

<div id="ShortsMinis" class="shorts-minis"  onclick="toggleShortsMinis()">
  
    <div class="text-center">
        <div class="">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-video2" viewBox="0 0 16 16">
            <path d="M10 9.05a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
            <path d="M2 1a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zM1 3a1 1 0 0 1 1-1h2v2H1zm4 10V2h9a1 1 0 0 1 1 1v9c0 .285-.12.543-.31.725C14.15 11.494 12.822 10 10 10c-3.037 0-4.345 1.73-4.798 3zm-4-2h3v2H2a1 1 0 0 1-1-1zm3-1H1V8h3zm0-3H1V5h3z"/>
          </svg>
        </div>
        <div style="transform: rotate(90deg); padding-left:7px; font-weight:bold; ">
            Shorts & Minis
        </div>
    </div>
    <div id="shorts-content" style="display: none;" >
        <div style="padding: 10px 0px 10px 10px;" >
        <h5>Shorts & Minis</h5>
        </div>
        <p style="text-align: right; cusrsor:pointer;" > 
            <a href="<?php echo URL::to('ugc') ?><?= '/view_all_profile/' ?>" target="_blank" >View All Profile </a>
        </p>
       
        <div class="d-flex flex-row">
            <?php  if(isset($ugc_users)) :
            foreach($ugc_users as $user): 
            ?>
            <div>
                <a href="{{ route('profile.show', ['username' => $eachuserdata->username]) }}" >
                <div>
                    <img style="height: 80px; width: 80px;" loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/avatars/'.$user->avatar;  ?>" class="rounded-circle img-fluid text-center m-2" alt="<?php echo $user->username; ?>">
                </div>
                <div class="text-center">
                    <p> <?php echo $user->username ?> </p>
                </div>
                </a>
            </div>
            <?php endforeach; endif; ?>
        </div>
        <div style="padding: 10px 0px 10px 10px;" >
            <h5>Recents</h5>
       </div>

       <div class="row" style="padding: 0px 10px;" >

        <?php  if(isset($ugc_shorts_minis)) :
        foreach($ugc_shorts_minis as $eachshortsminis): 
        ?>
        <div class="col-6">          
             <a  href="<?php echo URL::to('ugc') ?><?= '/video-player/' . $eachshortsminis->slug ?>" class="m-1">
                        <div class="shorts-minis-videos" style="position: relative;" >
                             <img loading="lazy" data-src="<?php echo URL::to('/').'/public/uploads/images/'.$eachshortsminis->image;  ?>" alt="<?php echo $eachshortsminis->title; ?>">
                        </div>
                        <div class="text-white pt-3">
                            <h6><?php  echo (strlen($eachshortsminis->title) > 17) ? substr($eachshortsminis->title,0,18).'...' : $eachshortsminis->title; ?></h6>
                            <p style="margin:5px 0px;"><?php  echo (strlen($eachshortsminis->user->username) > 17) ? substr($eachshortsminis->user->username,0,18).'...' : $eachshortsminis->user->username; ?></p>
                            <p> <?php echo $eachshortsminis->created_at->diffForHumans(); ?> |  <?php echo $eachshortsminis->views ? $eachshortsminis->views : '0'  ?> views
                                | <?php echo $eachshortsminis->like_count ?> Likes</p>
                        </div>
            </a>
        </div>
        <?php endforeach; endif; ?>

    </div>


    </div>
    </div>
</div>

<script>
    var mini = true;
    
    function toggleShortsMinis() {

        if (mini) {
            document.getElementById("ShortsMinis").style.width = "500px";
            document.getElementById("ShortsMinis").style.height = "100vh";
            document.getElementById("shorts-content").style.display = "block";
            document.querySelector("#ShortsMinis .text-center").style.display = "none";
            
            this.mini = false;
            } else {
            document.getElementById("ShortsMinis").style.width = "35px";
            document.getElementById("ShortsMinis").style.height = "170px";
            document.getElementById("shorts-content").style.display = "none";
            document.querySelector("#ShortsMinis .text-center").style.display = "block";
            this.mini = true;
        }
    }
</script>