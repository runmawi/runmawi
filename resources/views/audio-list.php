<?php include('header.php'); ?>

<div class="container mt-4">

		
		<?php if(isset($page_title)): ?>
			<h1 class="vid-title"><?= $page_title ?></h1>
            <p><?php if(isset($page_description)): ?><span style="color:#fff;">Today Trending <!--<?=$page_description?>--></span><?php endif; ?></p>
		<?php endif; ?>
		<div class="row nomargin">

			<?php 
			if(isset($audios) ||  isset($audios_category)) { include('partials/audio.php'); } ?>
			

		</div>


	<?php include('partials/pagination.php'); ?>

</div>
<div class="container mt-2">

		
		<?php if(isset($page_title)): ?>
			<h1 class="vid-title">Album</h1>
            <p><?php if(isset($page_description)): ?><span style="color:#fff;">Album list <!--<?=$page_description?>--></span><?php endif; ?></p>
		<?php endif; ?>
		<div class="row nomargin">

			<?php 
			if(isset($albums)) { 
				foreach($albums as $album): ?>
					<div class="iq-main-header col-md-3 d-flex align-items-center justify-content-between">
						<div class="favorites-contens">
							<ul class="favorites-slider list-inline  row p-0 mb-0">
								<li class="slide-item">
									<article class="block expand">
										<a class="block-thumbnail" href="<?= URL::to('album') ?><?= '/' . $album->slug ?>">
											<!-- <div class="thumbnail-overlay"></div> -->
											<div class="play-button">
												<div class="play-block">
													<i class="fa fa-play flexlink" aria-hidden="true"></i> 
												</div>
												<div class="detail-block">
													<!--  <p class="movie-title"><?//= $audio->title; ?></p>-->
												</div>
											</div>
											<img src="<?php echo URL::to('/').'/public/uploads/albums/'.$album->album;?>" width="280">
										</a>
										<div class="block-contents">
											<p class="movie-title padding p1"><?php echo $album->albumname; ?></p>
										</div>

									</article>
								</li>
							</ul>
						</div>
					</div>


				<?php endforeach; 
			} ?>
			

		</div>


	<?php include('partials/pagination.php'); ?>

</div>
<div class="container mt-2">

		
		<?php if(isset($page_title)): ?>
			<h1 class="vid-title">Aritst</h1>
            <p><?php if(isset($page_description)): ?><span style="color:#fff;">Artist list <!--<?=$page_description?>--></span><?php endif; ?></p>
		<?php endif; ?>
		<div class="row nomargin">

			<?php 
			if(isset($artists)) { 
				foreach($artists as $artist): ?>
					<div class="iq-main-header col-md-3 d-flex align-items-center justify-content-between">
						<div class="favorites-contens">
							<ul class="favorites-slider list-inline  row p-0 mb-0">
								<li class="slide-item">
									<article class="block expand">
										<a class="block-thumbnail" href="<?= URL::to('artist') ?><?= '/' . $artist->id ?>">
											<!-- <div class="thumbnail-overlay"></div> -->
											<div class="play-button">
												<div class="play-block">
													<i class="fa fa-play flexlink" aria-hidden="true"></i> 
												</div>
												<div class="detail-block">
													<!--  <p class="movie-title"><?//= $audio->title; ?></p>-->
												</div>
											</div>
											<img src="<?php echo URL::to('/').'/public/uploads/artists/'.$artist->image;?>" width="280">
										</a>
										<div class="block-contents">
											<p class="movie-title padding p1"><?php echo $artist->artist_name; ?></p>
										</div>

									</article>
								</li>
							</ul>
						</div>
					</div>


				<?php endforeach; 
			} ?> 
			

		</div>


	<?php include('partials/pagination.php'); ?>

</div>


<?php include('footer.blade.php'); ?>