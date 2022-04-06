<?php

return [
    'ffmpeg' => [
        'binaries' => '/usr/bin/ffmpeg',
        // 'binaries' => env('FFMPEG_BINARIES', 'ffmpeg'),
        'threads'  => 12,
    ],

    'ffprobe' => [
        // 'binaries' => env('FFPROBE_BINARIES', 'ffprobe'),
        'binaries' => '/usr/bin/ffprobe',

    ],

    'timeout' => 3600,

];
