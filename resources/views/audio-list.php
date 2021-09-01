<?php include('header.php'); ?>

<div class="container mt-4">

		
		<?php if(isset($page_title)): ?>
			<h1 class="vid-title"><?= $page_title ?></h1>
            <p><?php if(isset($page_description)): ?><span style="color:#fff;">Today treading <!--<?=$page_description?>--></span><?php endif; ?></p>
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
			if(isset($audios) ||  isset($audios_category)) { include('partials/audio.php'); } ?>
			

		</div>


	<?php include('partials/pagination.php'); ?>

</div>
<div class="container mt-2">

		
		<?php if(isset($page_title)): ?>
			<h1 class="vid-title">Aritst</h1>
            <p><?php if(isset($page_description)): ?><span style="color:#fff;">Album list <!--<?=$page_description?>--></span><?php endif; ?></p>
		<?php endif; ?>
		<div class="row nomargin">

			<?php 
			if(isset($audios) ||  isset($audios_category)) { include('partials/audio.php'); } ?>
			

		</div>


	<?php include('partials/pagination.php'); ?>

</div>


<?php include('footer.blade.php'); ?>