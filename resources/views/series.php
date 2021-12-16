<?php include('header.php'); ?>
<style type="text/css">
	.nav-pills li a {color: #fff !important;}
    nav{
       margin: 0 auto;
        align-items: center;
    }
</style>

<?php //dd($season) ?>
<div class="container" >
	<div id="series_bg_dim" <?php if($series->access == 'guest' || ($series->access == 'subscriber' && !Auth::guest()) ): ?><?php else: ?>class="darker"<?php endif; ?>></div>

	<div class="row mt-3">
		<?php if($series->access == 'guest' || ( ($series->access == 'subscriber' || $series->access == 'registered') && !Auth::guest() && Auth::user()->subscribed()) || (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) || (!Auth::guest() && $series->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered') ): ?>
		<div class="col-md-7 p-0">
			<div id="series_title">
				<div class="container">
					<span class="label"></span> <h1><?= $series->title ?></h1><br><br>
					<div class="col-md-6 p-0">
						<select class="form-control">
							<?php foreach($season as $key => $seasons): ?>
								<option value="season_<?= $seasons->id;?>">Season <?= $key+1; ?></option>
							<?php endforeach; ?>
						</select>
					</div><br><br>
					<div class="row p-2">
						<p class="desc" style="color:#fff;"><?php echo $series->description;?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3 text-center">
			<img src="<?= URL::to('/') . '/public/uploads/images/' . $series->image; ?>" class="w-100">
		</div>
	</div>
</div>

<section id="tabs" class="project-tab">
	<div class="container">
		<div class="row">
			<div class="col-md-12 mt-4">
				<nav class="nav-justified">
					<div class="nav nav-tabs nav-fill " id="nav-tab" role="tablist">
						<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Episode</a>
						<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Related</a>
						<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Detail</a>
					</div>
				</nav>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
<!-- $series->title -->
						
						<?php foreach($season as $key => $seasons):  
							foreach($seasons->episodes as $key => $episodes): ?>
								<a href="<?php echo URL::to('episode').'/'.$series->title.'/'.$episodes->title;?>">
								<div class="row mt-4 episodes_div season_<?= $seasons->id;?>">
									<div class="col-md-3">
										<img src="<?php echo URL::to('/').'/public/uploads/images/'.$episodes->image;  ?>" width="200" >
									</div>
									<div class="col-md-7">
										<h2><?= $episodes->title; ?></h2>
										<p class="desc"><?php if(strlen($series->description) > 90){ echo substr($series->description, 0, 90) . '...'; } else { echo $series->description; } ?></p>
                                        <p class="date"><?= date("F jS, Y", strtotime($episodes->created_at)); ?></p>
										<p><?= gmdate("H:i:s", $episodes->duration); ?></p>
									</div>
									<div class="col-md-2">
										
									</div>
								</div>
							</a>
							<?php endforeach; 
						endforeach; ?>
							</div>
							<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
								Related
							</div>
							<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
								Detail
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
<?php endif;?>
<script type="text/javascript">
	var first = $('select').val();
	$(".episodes_div").hide();
	$("."+first).show();

	$('select').on('change', function() {
		$(".episodes_div").hide();
		$("."+this.value).show();
	});
</script>
<?php include('footer.blade.php'); ?>