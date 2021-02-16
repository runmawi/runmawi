<?php include('header.php'); ?>

	<div class="container">

		<div class="row page-height">
			<div class="col-md-2 page page-height">

				<ul class="nav flex-column">
					<?php foreach($pages as $page): ?>
                        <?php if ( $page->slug != 'promotion' ){ 
								$url = $_SERVER['REQUEST_URI'];
								$id = substr(strrchr(rtrim($url, '/'), '/'), 1);
					?>
							<li class="<?php if ($page->slug == $id ){echo 'active'; } ?> "><a href="<?php echo URL::to('page'); ?><?= '/' . $page->slug ?>"><?= __($page->title) ?></a></li>
                        <?php } ?>
					<?php endforeach; ?>
					
				  </ul>

			</div>

			<div class="col-md-10 page ">

						<h2 class="vid-title text-left"><?php echo __($pager->title); ?></h2>
						<div class="border-line"></div>

						<div class="page-body">
							<?php echo __($pager->body); ?>
						</div>

			</div>

		</div>
    

	</div>     

<?php include('footer.blade.php'); ?>