@php
    include public_path('themes/theme5-nemisha/views/header.php');
    $settings = App\Setting::first();
@endphp

<style>
   .ugc-videos img{
        width: 100%;
        height: 200px;
        border-radius: 15px;
    }
 
.ugc-tabs {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    overflow-y: auto;
    padding-top: 10px;
}

.ugc-playlist {
   display: inline-block;
    padding: 5px 30px;
    margin: 0 5px;
    background-color: #ED563C;
    color: #fff;
    border-radius: 8px;
    white-space: nowrap;
}

</style>

<div class="row">
   <div class="col-8">

   
      


   </div>
   <div class="col-4">
             <div class="ugc-tabs">
                 <div class="ugc-playlist">New</div>
                 <div class="ugc-playlist">Related</div>
                 <div class="ugc-playlist">Your Playlist</div>
                 <div class="ugc-playlist">Watch Now</div>
                 <div class="ugc-playlist">Trending</div>
                 <div class="ugc-playlist">Watch Now</div>
             </div>     

      <div class="col mx-3">
         @foreach ($ugcvideos as $eachugcvideos)
         <div class="px-3">
              <a href="" class="m-1">
                         <div class="ugc-videos">
                             <img src="{{ URL::to('/') . '/public/uploads/images/' . $eachugcvideos->image }}" alt="{{ $eachugcvideos->title }}">
                         </div>
                         <div class="text-white pt-3">
                             <h6>{{$eachugcvideos->title}}</h6>
                             <p style="margin:5px 0px;">{{$user->name}}</p>
                             <p >2 weeks ago | 100k Views | 90k Likes</p>
                         </div>
             </a>
         </div>
         @endforeach
     </div>
   </div>
</div>
@php
include public_path('themes/theme5-nemisha/views/footer.blade.php');
@endphp