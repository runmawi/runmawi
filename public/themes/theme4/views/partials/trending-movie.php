<?php foreach($movies as $movie): ?>
<div class="new-art">
    <article class="block expand">
        <a class="block-thumbnail" data-id="<?= $movie->id; ?>" data-toggle="collapse" data-target="#<?= $movie->id; ?>">
        <div class="thumbnail-overlay"></div>
            <img src="">
        </a>
        <div class="block-overlap block-class_<?= $movie->id ?>" style="display: none;">
            <div style="display:flex;align-items: center;">
                <div>
                    <a class="flexlink" href="play_movie/<?= $movie->id;?>"><i class="fa fa-play" aria-hidden="true"></i></a>
                </div>
                <div style="width: 90%;">
                    <h4><?php  echo (strlen($movie->title) > 17) ? substr($movie->title,0,18).'...' : $movie->title; ?></h4>
                    <p style="margin-bottom: 30px;">
                        IMDb <?= $movie->rating;?> 
                        <span>(<?= $movie->views;?>)</span>
                        <span style="margin-left:5%;">1h 50m</span>
                        <span style="margin-left:5%;">2018</span>
                    </p>
                    <div class="thriller">
                        <p><?= $movie->genre->name;?></p>
                        <div class="flex-icons">
                            <a href="play_movie/<?= $movie->id;?>"><i class="fa fa-play" aria-hidden="true"></i></a>
                            <a href="play_movie/<?= $movie->id;?>"><i class="fa fa-info" aria-hidden="true"></i></a>
                            <a href="play_movie/<?= $movie->id;?>"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>
                            <a href="play_movie/<?= $movie->id;?>"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>
<?php endforeach; ?>
