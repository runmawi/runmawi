<?php include('includes/header.php'); ?>

<div class="container search-results">

		<?php if(count($videos) >= 1): ?>
			
			<h3>Video Search Results <span>for <?= $search_value ?></span></h3>
		
			<div class="row">

				<?php include('partials/video-loop.php'); ?>

			</div>

		
		<?php elseif(count($movies) >= 1): ?>
		
			<h3>Movie Search Results <span>for <?= $search_value ?></span></h3>
		
			<div class="row">

				<?php include('partials/video-loop.php'); ?>

			</div>
    
		<?php elseif(count($audios) >= 1): ?>
		
			<h3>Audio Search Results <span>for <?= $search_value ?></span></h3>
		
			<div class="row">

				<?php include('partials/audio-search.php'); ?>

			</div>

		<?php elseif(count($episodes) >= 1): ?>
		
			<h3>Episode Search Results <span>for <?= $search_value ?></span></h3>
		
			<div class="row">

				<?php include('partials/video-loop.php'); ?>

			</div>

		<?php elseif(count($series) >= 1): ?>
		
			<h3>Series Search Results <span>for <?= $search_value ?></span></h3>
		
			<div class="row">

				<?php include('partials/video-loop.php'); ?>

			</div>

		<?php else: ?>

			<h4>No Video Search results found for <?= $search_value ?></h4>

		<?php endif; ?>

		

</div>



<?php include('includes/footer.php'); ?>