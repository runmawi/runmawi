<?php $settings = App\Setting::first(); ?>
  <body 
        <?php if ( Session::get('locale') == 'arabic') { echo 'dir="rtl"';}?>> 
  <?php if(isset($video->id)): ?>
      <title>
        <?= $video->title; ?>
      </title>
  <meta name="description" content="<?= $video->description ?>">
  <?php 
    $keywords = '';
    $keywords = $video->title;
    ?>
  <!-- for Google -->
  <meta name="keywords" content="<?= $keywords ?>" />
  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="<?= $video->title ?>">
  <meta itemprop="description" content="<?= $video->description ?>">
  <!-- for Facebook --> 
      <img style="display:none;" src="<?= URL::to('/public/') . '/uploads/images/'.$video->image ?>">
  <meta property="og:image" content="<?= URL::to('/public/') . '/uploads/images/'.$video->image ?>">
  <meta property="og:title" content="<?= $video->title ?>" />
  <meta property="og:type" content="video.other" />
  <meta property="og:url" content="<?= Request::url(); ?>" />
  <meta property="og:description" content="<?= $video->description ?>" />
  <!-- for Twitter -->          
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:title" content="<?= $video->title ?>" />
  <meta name="twitter:description" content="<?= $video->description ?>" />
  <?php elseif(isset($post->id)): ?>
  <?php $post_description = preg_replace('/^\s+|\n|\r|\s+$/m', '', strip_tags($post->body)); ?>
  <title>
    <?= $post->title; ?>
  </title>
  <meta name="description" content="<?= $post_description ?>">
  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="<?= $post->title ?>">
  <meta itemprop="description" content="<?= $post_description ?>">
  <meta itemprop="image" content="<?= URL::to('/public/') . '/uploads/images/' . $post->image ?>">
  <!-- for Facebook -->          
  <meta property="og:title" content="<?= $post->title ?>" />
  <meta property="og:type" content="article" />
  <meta property="og:image" content="<?= URL::to('/public/') . '/uploads/images/' . $post->image ?>" />
  <meta property="og:url" content="<?= Request::url(); ?>" />
  <meta property="og:description" content="<?= $post_description ?>" />
  <!-- for Twitter -->          
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:title" content="<?= $post->title ?>" />
  <meta name="twitter:description" content="<?= $post_description ?>" />
  <meta name="twitter:image" content="<?= URL::to('/public/') . '/uploads/images/' . $post->image ?>" />
  <?php elseif(isset($data->id)): ?>
  <title>
    <?= $movie->title. '-' . $settings->website_name; ?>
  </title>
  <meta name="description" content="<?= $movie->description; ?>">
  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="<?= $data->title. '-' . $data->website_name; ?>">
  <meta itemprop="description" content="<?= $data->description; ?>">
  <!-- for Facebook -->          
  <meta property="og:title" content="<?= $data->title. '-' . $settings->website_name; ?>" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="<?= Request::url(); ?>" />
  <meta property="og:description" content="<?= $data->description; ?>" />
  <!-- for Twitter -->          
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:title" content="<?= $data->title. '-' . $settings->website_name; ?>" />
  <meta name="twitter:description" content="<?= $movie->description; ?>" />
  
  <?php elseif(isset($page->id)): ?>
  <title>
    <?= $page->title . '-' . $settings->website_name; ?>
  </title>
  <meta name="description" content="<?= $page->title . '-' . $settings->website_name; ?>">
  <?php else: ?>
  <title>
    <?php echo $settings->website_name . ' - ' . $settings->website_description; ?>
  </title>
  <meta name="description" content="<?= $settings->website_description ?>">
  <?php endif; ?>
      
  <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1">
  <link rel="icon" href="<?= getFavicon();?>" type="image/gif" sizes="16x16">
  <link rel="stylesheet" href="<?= URL::to('/').'/assets/css/bootstrap.min.css'; ?>" />
  <link rel="stylesheet" href="<?= URL::to('/').'/assets/css/noty.css'; ?>" />
  <link rel="stylesheet" href="<?= URL::to('/').'/assets/css/font-awesome.min.css'; ?>" />
  <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/hellovideo-fonts.css'; ?>" />
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css"/>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js">
  </script>
  <link rel="stylesheet" href="<?= URL::to('/').'/assets/css/style.css'; ?>" />
  <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/rrssb.css'; ?>" />
  <link rel="stylesheet" href="<?= URL::to('/'). '/assets/css/animate.min.css'; ?>" />
  <link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
  </script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script>if (!window.jQuery) {
      document.write('<script src="<?= URL::to('/'). '/assets/js/jquery.min.js'; ?>"><\/script>');
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
  <script type="text/javascript">
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({
        pageLanguage: 'en'}
                                            , 'google_translate_element');
    }
  </script>