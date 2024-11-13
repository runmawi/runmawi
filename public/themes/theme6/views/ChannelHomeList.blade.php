<?php
include public_path('themes/theme6/views/header.php');

$order_settings = App\OrderHomeSetting::orderBy('order_id', 'asc')->get();
$order_settings_list = App\OrderHomeSetting::get();
$continue_watching_setting = App\HomeSetting::pluck('continue_watching')->first();
?>

<link rel="shortcut icon" href="<?= URL::to('/') . '/public/uploads/settings/' . $settings->favicon ?>" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<section>
    <div>
        @foreach ($channel as $ch)
            @if ($ch)  <!-- Check if $ch is not null -->
                <div class="channel">
                    <h3>{{ $ch->channel_name }}</h3>  <!-- Display channel name or other channel info -->

                    @if($ch->videos->isNotEmpty())  <!-- Check if there are videos -->
                        <div class="videos">
                            @foreach ($ch->videos as $video)
                                <div class="video">
                                    <h4>{{ $video->title }}</h4>  <!-- Display video title -->
                                    <!-- Add more video details as needed -->
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No videos available for this channel.</p>  <!-- Handle case when no videos are available -->
                    @endif
                </div>
            @endif
        @endforeach
    </div>
</section>

