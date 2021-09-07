<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>-->

<?php 
$video_id =$video->id;

// SELECT artists.*,video_artists.* FROM `artists` INNER JOIN `video_artists` ON `artists`.id = `video_artists`.artist_id where video_id = 79;

$cast_crew = \DB::table('video_artists')
     ->select(['artists.*', 'video_artists.*'])
     ->join('artists', 'artists.id', '=', 'video_artists.artist_id')
     ->where('video_artists.video_id', '=', $video_id)
     ->get();

     foreach ($cast_crew as $key => $value) { ?>
     <div class="artist" style="display: flex;">

     <div class="artist-image">
     <!-- <img src="{{ URL::to('/') . '/public/uploads/artists/'.$cast_crew->image }}" class="img" alt="Avatar"> -->
        <a href="javascript:void(0);" ><img style="border-radius: 50%;"
        src="<?php echo URL::to('/') . '/public/uploads/artists/'.$value->image ;?>"
        class="img-border-radius avatar-40 img-fluid" alt=""></a>
        <br>
        <br>
        <?php echo $value->artist_name; ?>
        <br>
        <br>
        <?php echo $value->description; ?>
        </div>

    <?php }
?>
<style>
.artist-image{
    color: white;
}
.artist-images {
    border-radius: 50%;
}
</style>