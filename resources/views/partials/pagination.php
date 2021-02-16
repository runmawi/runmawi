<?php

if(isset($videos)):
	$media = $videos;
elseif(isset($videos_category)):
	$media = $videos_category;
elseif(isset($audios_category)):
	$media = $audios_category;
elseif(isset($movies_genre)):
	$media = $movies_genre;
elseif(isset($wishlist_videos)):
	$media = $wishlist_videos;
elseif(isset($favorite_videos)):
	$media = $favorite_videos;
elseif(isset($favorite_movies)):
	$media = $favorite_movies;
elseif(isset($posts)):
	$media = $posts;
elseif(isset($movies)):
	$media = $movies;
elseif(isset($series)):
	$media = $series;
elseif(isset($watchlater_videos)):
	$media = $watchlater_videos;
elseif(isset($watchlater_movies)):
	$media = $watchlater_movies;
elseif(isset($watchhistory_videos)):
	$media = $watchhistory_videos;
elseif(isset($watchhistory_movies)):
	$media = $watchhistory_movies;		
endif;

?>

<div class="pagination">
	<?php if($current_page != 1) : ?>
		<a class="previous_page s" href="<?= $pagination_url . '?page=' . intval($current_page - 1); ?>">Prev Page</a>
	<?php endif; ?>
	<?php if($media->hasMorePages()) : ?>
		<a class="next_page" href="<?= $pagination_url . '?page=' . intval($current_page + 1); ?>">Next Page</a>
	<?php endif; ?>
</div>