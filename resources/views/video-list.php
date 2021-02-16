<?php include('header.php');?>

<div class="container movlistt">

		
		<?php if(isset($page_title)): ?>
			<div class="new-art">
				<h4 class="Continue Watching text-left padding-top-40" style="color:#000;"><?= $page_title ?></h4>
			 <span style="color: #000;"><?php if(isset($page_description)): ?><?= $page_description ?> <?php endif; ?></span>
            <div class="border-line" style="margin-bottom:15px;margin-top:20px;"></div>
          </div>
		<?php endif; ?>
		<div class="row">

			<?php 
			if(isset($videos) || isset($movies) || isset($series) || isset($videos_category) || isset($movies_genre)) { include('partials/series-loop.php'); } ?>
			

		</div>


	<?php include('partials/pagination.php'); ?>

</div>


<?php //include('includes/footer-above.php'); ?>
<?php include('footer.blade.php');?>