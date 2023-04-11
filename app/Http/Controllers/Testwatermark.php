<?php

namespace App\Http\Controllers;
use App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use URL;
use File;
use App\Test as Test;
use App\Video as Video;
use App\CountryCode;
use App\MoviesSubtitles as MoviesSubtitles;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\AdsVideo as AdsVideo;
use App\Advertisement as Advertisement;
use App\VideoLanguage as VideoLanguage;
use App\Subtitle as Subtitle;
use App\Tag as Tag;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use View;
use Validator;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\VideoSchedule;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Str;
use App\Artist;
use App\Videoartist;
use App\ModeratorsUser;
use GifCreator\GifCreator;
use App\AgeCategory as AgeCategory;
use App\Setting as Setting;
use DB;
use App\BlockVideo;
use App\LanguageVideo;
use App\CategoryVideo;
use Exception;
use getID3;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\ReelsVideo;
use App\PpvPurchase as PpvPurchase;
use App\Adscategory;
use App\VideoSearchTag;
use App\RelatedVideo;
use Streaming\Representation;
use App\Jobs\ConvertVideoTrailer;
use App\InappPurchase;
use App\CurrencySetting as CurrencySetting;
use App\VideoSchedules as VideoSchedules;
use App\ScheduleVideos as ScheduleVideos;
use App\TestServerUploadVideo as TestServerUploadVideo;
use App\Channel as Channel;
use App\ReSchedule as ReSchedule;
use App\TimeZone as TimeZone;
use App\StorageSetting as StorageSetting;
use App\TimeFormat as TimeFormat;
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;
use Aws\S3\S3MultiRegionClient;
use App\EmailTemplate;
use Mail;
use App\PlayerAnalytic;
use Carbon\Carbon;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\Point;
use FFMpeg\Exception\RuntimeException;

class Testwatermark extends Controller
{
    public function index()
    {
        // $ffmpeg = FFMpeg::create([
        //     'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
        //     'ffprobe.binaries' => '/usr/bin/ffprobe',
        //     'timeout'          => 3600,
        //     'ffmpeg.threads'   => 12,
        // ]);
        $ffmpeg = \FFMpeg\FFMpeg::create([
            'ffmpeg.binaries'  => 'H:/ffmpeg/bin/ffmpeg.exe', // the path to the FFMpeg binary
            'ffprobe.binaries' => 'H:/ffmpeg/bin/ffprobe.exe', // the path to the FFProbe binary
            'timeout'          => 0, // the timeout for the underlying process
            'ffmpeg.threads'   => 1,   // the number of threads that FFMpeg should use
        ]);
        $storepath = URL::to("/storage/app/public/4zZc3dr829Os0Xfx.mp4");

        $video = $ffmpeg->open(public_path('uploads/settings/test.mp4'));
        $settings = Setting::first();
        
        $logo = URL::to('/').'/public/uploads/settings/'. $settings->logo;


        $watermarkPath = public_path('uploads/settings/webnexs-250.png');

        $watermark = imagecreatefrompng($watermarkPath);
        $watermarkWidth = imagesx($watermark);
        $watermarkHeight = imagesy($watermark);
        $videoWidth = $video->getStreams()->videos()->first()->get('width');
        $videoHeight = $video->getStreams()->videos()->first()->get('height');
        $paddingX = 10;
        $paddingY = 10;
        $watermarkPosition = new Point($paddingX, $paddingY);

        $video->filters()
    //   ->watermark($watermarkPath, $watermarkPosition, 100)
    ->watermark($watermarkPath)
      ->synchronize();
      $format = new X264();
      $format->setKiloBitrate(1000);
      $format->setAudioCodec('libmp3lame');
      $format->setVideoCodec('libx264');
        // $format->setAudioCodec('libmp3lame');
     
        try {
            // Your FFmpeg code here
        $video->save($format, public_path('uploads/settings/video.mp4'));

        } catch (RuntimeException $e) {
            \Log::error('FFmpeg encoding failed: ' . $e->getMessage());
        }

    }
}