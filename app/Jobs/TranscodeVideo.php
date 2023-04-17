<?php

namespace App\Jobs;


use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Filters\Video\VideoFilters;
use FFMpeg\Filters\Video\WatermarkFilter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TranscodeVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video;
    protected $watermark;

    /**
     * Create a new job instance.
     *
     * @param  string  $video
     * @param  string  $watermark
     * @return void
     */
    public function __construct($video, $watermark)
    {
        $this->video = $video;
        $this->watermark = $watermark;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ffmpeg = FFMpeg::create();

        $video = $ffmpeg->open($this->video);

        $bitrates = [240, 360, 480, 720, 1080];
        $format = new X264('aac');

        foreach ($bitrates as $bitrate) {
            $width = floor($bitrate * 16 / 9);
            $filters = new VideoFilters();
            $filters->resize($width, $bitrate);
            $filters->watermark($this->watermark, [
                'position' => 'relative',
                'bottom' => 50,
                'right' => 50,
            ]);

            $video->filters()
                  ->addWatermarkFilter($filters->getWatermarkFilter())
                  ->addResizeFilter($filters->getResizeFilter())
                  ->synchronize();

            $format->setVideoCodec('libx264');
            $format->setAudioCodec('aac');
            $format->setAdditionalParameters(['-strict', 'experimental']);
            $format->setKiloBitrate($bitrate);

            $outputPath = '/path/to/output_' . $bitrate . '.m3u8';
            $video->exportForHLS()
                  ->setHlsOptions([
                      '-hls_time' => 10,
                      '-hls_list_size' => 0,
                  ])
                  ->toDisk('s3')
                  ->inFormat($format)
                  ->save($outputPath);
        }
    }
}
// Dispatch the job from your controller or wherever you want to start the transcoding process:
// php
// Copy code
// use App\Jobs\TranscodeVideo;

// $video = '/path/to/video.mp4';
// $watermark = '/path/to/watermark.png';

// TranscodeVideo::dispatch($video, $watermark);
// This will dispatch the TranscodeVideo job to the queue, which will then be executed by a queue worker. The job will transcode the video to HLS with different bitrates (240p, 360




// Regenerate