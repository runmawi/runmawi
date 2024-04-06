<?php


namespace App\Http\Controllers;

use App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
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
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\TranscodeVideo;
use App\Jobs\VideoSchedule;
use App\Jobs\VideoClip;
use Illuminate\Contracts\Filesystem\Filesystem;
use FFMpeg\Filters\Video\VideoFilters;
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
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ParseM3U8;
use App\Playerui;
use App\PlayerSeekTimeAnalytic;
use App\AdminVideoPlaylist as AdminVideoPlaylist;
use App\VideoPlaylist as VideoPlaylist;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\VideoExtractedImages;
use FFMpeg\Filters\Video\VideoResizeFilter;
use FFMpeg\Filters\Video\Resizer;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\SiteTheme;
use App\AdminVideoAds;
use App\MusicGenre;
use App\SeriesCategory as SeriesCategory;
use App\SeriesLanguage as SeriesLanguage;
use App\SeriesGenre;
use App\SeriesSubtitle as SeriesSubtitle;
use App\SeriesNetwork;
use App\Series;
use App\Seriesartist;
use App\Episode;

class AdminBulkImportExportController extends Controller
{


    public function index(Request $request)
    {
        $data = [
            "videos" => Video::with("category.categoryname")->orderBy("created_at", "DESC")->paginate(9),
            "series" => Series::latest()->get(),
            "Episodes" => Episode::latest()->get(),
        ];
        return View("admin.bulk_management.Index", $data);

    }

    
    public function BulkImport(Request $request)
    {
        $data = $request->all();
        $Bulk_Management = $request->Bulk_Management ;
        if($Bulk_Management == 'Videos'){
            return $this->VideoBulkImport($data);
        }elseif($Bulk_Management == 'Series'){
            return $this->SeriesBulkImport($data);
        }elseif($Bulk_Management == 'Episode'){
            return $this->EpisodeBulkImport($data);
        }else{
            return $this->VideoBulkImport($data);
        }
    }

    public function VideoBulkExport(Request $request){

        try {
           $video_start_id = $request->video_start_id;
           $video_end_id = $request->video_end_id;


            $videos = Video::whereBetween('id', [$video_start_id, $video_end_id])->get()->map(function ($item){
                    $languages = LanguageVideo::Join('languages','languages.id','=','languagevideos.language_id')
                        ->where('languagevideos.video_id',$item->id)->pluck('language_id')->toArray();
                        $item['languages'] = implode(',', $languages);
                    $CategoryVideo = CategoryVideo::Join('video_categories','video_categories.id','=','categoryvideos.category_id')
                        ->where('video_id',$item->id)->pluck('category_id')->toArray();
                        $item['CategoryVideo'] = implode(',', $CategoryVideo);

                    $video_cast = Videoartist::join("artists","video_artists.artist_id", "=", "artists.id")
                        ->where("video_artists.video_id", "=", $item->id)
                        ->pluck('artist_id')->toArray();
                        $item['video_cast_crew'] = implode(',', $video_cast);

                    return $item;
                });

            $filePath = 'videos.csv';
            
            if (!Storage::exists($filePath)) {
                Storage::put($filePath, '');
            }

            $fileStream = fopen(storage_path('app/' . $filePath), 'w');

            $firstVideo = $videos->first();
            $titles = array_keys($firstVideo->getAttributes());
            fputcsv($fileStream, $titles);

            foreach ($videos as $video) {
                $attributes = $video->getAttributes();

                $rowData = [];
                foreach ($titles as $title) {
                    if (property_exists($video, $title)) {
                        $rowData[] = $title === 'languages' ? $video->{$title} : $video->{$title};
                        $rowData[] = $title === 'CategoryVideo' ? $video->{$title} : $video->{$title};
                        $rowData[] = $title === 'video_cast_crew' ? $video->{$title} : $video->{$title};
                    }else if (array_key_exists($title, $attributes)) {
                        $rowData[] = $attributes[$title];
                    } else {
                        $rowData[] = '';
                    }
                }

                fputcsv($fileStream, $rowData);
            }

            fclose($fileStream);

            return 1;

           
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function VideoBulkImport($data){
        
        try {

            if (isset($data['csv_file']) && is_file($data['csv_file'])) {
                // Get the uploaded CSV file
                $csvFile = $data['csv_file'];
    
                $file = fopen($csvFile->getPathname(), 'r');
    
                $headers = fgetcsv($file);
                $rowNumber = 1; 
                while (($row = fgetcsv($file)) !== false) {
                    $data = array_combine($headers, $row);
                    $video = Video::find($data['id']);
                    if ($video) {
                        $video->update([
                            'title' => $data['title'],
                            'slug' => empty($data["slug"]) ? str_replace(" ", "-", $data["title"]) : $data['slug'],
                            'video_category_id' => $data['video_category_id'],
                            'type' => $data['type'],
                            'access' => $data['access'],
                            'ppv_price' => $data['ppv_price'],
                            'global_ppv' => $data['global_ppv'],
                            'details' => $data['details'],
                            'description' => $data['description'],
                            'active' => $data['active'],
                            'featured' => $data['featured'],
                            'banner' => $data['banner'],
                            'today_top_video' => $data['today_top_video'],
                            'enable' => $data['enable'],
                            'user_id' => $data['user_id'],
                            'footer' => $data['footer'],
                            'original_name' => $data['original_name'],
                            'disk' => $data['disk'],
                            'stream_path' => $data['stream_path'],
                            'processed_low' => $data['processed_low'],
                            'converted_for_streaming_at' => $data['converted_for_streaming_at'],
                            'path' => $data['path'],
                            'old_path_mp4' => $data['old_path_mp4'],
                            'duration' => $data['duration'],
                            'slug' => $data['slug'],
                            'rating' => $data['rating'],
                            'status' => $data['status'],
                            'publish_type' => $data['publish_type'],
                            'publish_status' => $data['publish_status'],
                            'publish_time' => $data['publish_time'],
                            'skip_recap' => $data['skip_recap'],
                            'skip_intro' => $data['skip_intro'],
                            'recap_start_time' => $data['recap_start_time'],
                            'recap_end_time' => $data['recap_end_time'],
                            'intro_start_time' => $data['intro_start_time'],
                            'intro_end_time' => $data['intro_end_time'],
                            'image' => $data['image'],
                            'embed_code' => $data['embed_code'],
                            'mp4_url' => $data['mp4_url'],
                            'm3u8_url' => $data['m3u8_url'],
                            'webm_url' => $data['webm_url'],
                            'ogg_url' => $data['ogg_url'],
                            'views' => $data['views'],
                            'language' => $data['language'],
                            'year' => $data['year'],
                            'trailer' => $data['trailer'],
                            'url' => $data['url'],
                            'draft' => $data['draft'],
                            'age_restrict' => $data['age_restrict'],
                            'video_gif' => $data['video_gif'],
                            'Recommendation' => $data['Recommendation'],
                            'country' => $data['country'],
                            'pdf_files' => $data['pdf_files'],
                            'reelvideo' => $data['reelvideo'],
                            'url_link' => $data['url_link'],
                            'url_linktym' => $data['url_linktym'],
                            'url_linksec' => $data['url_linksec'],
                            'urlEnd_linksec' => $data['urlEnd_linksec'],
                            'mobile_image' => $data['mobile_image'],
                            'tablet_image' => $data['tablet_image'],
                            'default_ads' => $data['default_ads'],
                            'player_image' => $data['player_image'],
                            'video_tv_image' => $data['video_tv_image'],
                            'ads_status' => $data['ads_status'],
                            'ads_category' => $data['ads_category'],
                            'pre_ads_category' => $data['pre_ads_category'],
                            'mid_ads_category' => $data['mid_ads_category'],
                            'post_ads_category' => $data['post_ads_category'],
                            'pre_ads' => $data['pre_ads'],
                            'mid_ads' => $data['mid_ads'],
                            'mid_ads' => $data['mid_ads'],
                            'ads_tag_url_id' => $data['ads_tag_url_id'],
                            'tag_url_ads_position' => $data['tag_url_ads_position'],
                            'video_js_pre_position_ads' => $data['video_js_pre_position_ads'],
                            'video_js_post_position_ads' => $data['video_js_post_position_ads'],
                            'video_js_mid_position_ads_category' => $data['video_js_mid_position_ads_category'],
                            'video_js_mid_advertisement_sequence_time' => $data['video_js_mid_advertisement_sequence_time'],
                            'trailer_type' => $data['trailer_type'],
                            'reels_thumbnail' => $data['reels_thumbnail'],
                            'trailer_description' => $data['trailer_description'],
                            'search_tags' => $data['search_tags'],
                            'ios_ppv_price' => $data['ios_ppv_price'],
                            'uploaded_by' => $data['uploaded_by'],
                            'video_title_image' => $data['video_title_image'],
                            'enable_video_title_image' => $data['enable_video_title_image'],
                            'free_duration_status' => $data['free_duration_status'],
                            'free_duration' => $data['free_duration'],
                            'expiry_date' => $data['expiry_date'],
                            'tiny_video_image' => $data['tiny_video_image'],
                            'tiny_player_image' => $data['tiny_player_image'],
                            'tiny_video_title_image' => $data['tiny_video_title_image'],
                            'music_genre' => $data['music_genre'],
                            'country_by_origin' => $data['country_by_origin'],
                            'writers' => $data['writers'],
                            'created_at' => $data['created_at'],
                        ]);
                    }
                    
                    if (!empty($data["languages"])) {
                        $languageIds = explode(',', $data["languages"]);
                        LanguageVideo::where("video_id", $video->id)->delete();
                        foreach ($languageIds as $languageId) {
                            $languageVideo = new LanguageVideo();
                            $languageVideo->video_id = $video->id;
                            $languageVideo->language_id = $languageId;
                            $languageVideo->save();
                        }
                    }else {
                        return Redirect::back()->with('error_message', 'Language Video field is required in row'. $rowNumber);
                    }

                    if (!empty($data["CategoryVideo"])) {
                        $CategoryIds = explode(',', $data["CategoryVideo"]);
                        CategoryVideo::where("video_id", $video->id)->delete();
                        foreach ($CategoryIds as $CategoryId) {
                            $CategoryVideo = new CategoryVideo();
                            $CategoryVideo->video_id = $video->id;
                            $CategoryVideo->category_id = $CategoryId;
                            $CategoryVideo->save();
                        }
                    }else {
                        return Redirect::back()->with('error_message', 'Category Video field is required in row'. $rowNumber);
                    }

                    if (!empty($data["video_cast_crew"])) {
                        $VideoartistIds = explode(',', $data["video_cast_crew"]);
                        Videoartist::where("video_id", $video->id)->delete();
                        foreach ($VideoartistIds as $VideoartistId) {
                            $Videoartist = new Videoartist();
                            $Videoartist->video_id = $video->id;
                            $Videoartist->artist_id = $VideoartistId;
                            $Videoartist->save();
                        }
                    }else {
                        return Redirect::back()->with('error_message', 'Cast and Crew field is required in row'. $rowNumber);
                    }
                    $rowNumber++;
                }
    
                fclose($file);
    
                return Redirect::back()->with('message', 'CSV File updated successfully');

            } else {
                return Redirect::back()->with('error_message', 'No CSV file uploaded.');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function ImageBulkImport(Request $request){

        try {

            return View("admin.bulk_management.IndexImage");

        } catch (\Throwable $th) {
            throw $th;
        }
    
    }


    public function ImageZipImport(Request $request){

        try {
                
            if ($request->hasFile('zip_file')) {
                    $zipFile = $request->file('zip_file');
        
                    if ($zipFile->getClientOriginalExtension() !== 'zip') {
                        return Redirect::back()->with('error_message', 'Invalid file type. Please upload a ZIP file.');
                    }
        
                    $storedPath = $zipFile->storeAs('uploads/images', $zipFile->getClientOriginalName());
        
                    $absolutePath = storage_path('app/' . $storedPath);
        
                    if (!file_exists($absolutePath)) {
                        return Redirect::back()->with('error_message', 'Uploaded file not found.');
                    }
        
                    $extractPath = public_path('uploads/images/');
                    
                    if (!is_dir($extractPath)) {
                        mkdir($extractPath, 0777, true);
                    }
        
                    // Extract files
                    $zip = new \ZipArchive;
                    if ($zip->open($absolutePath) === TRUE) {
                        $zip->extractTo($extractPath);
                        $zip->close();
        
                        Storage::delete($storedPath);
        
                        return Redirect::back()->with('message', 'ZIP Uploaded and extracted successfully');
                    } else {
                        return Redirect::back()->with('error_message', 'Failed to open ZIP file');
                    }
                } else {
                    return Redirect::back()->with('error_message', 'No ZIP file found in the request');
                }
        } catch (\Throwable $th) {
            throw $th;
        }
    
    }


    
    public function SeriesBulkExport(Request $request){

        try {
           $start_id = $request->video_start_id;
           $end_id = $request->video_end_id;


            $series = Series::whereBetween('id', [$start_id, $end_id])->get()->map(function ($item){
                    $languages = SeriesLanguage::Join('languages','languages.id','=','series_languages.language_id')
                        ->where('series_languages.series_id',$item->id)->pluck('language_id')->toArray();
                        $item['languages'] = implode(',', $languages);
                    $SeriesCategory = SeriesCategory::Join('series_genre','series_genre.id','=','series_categories.category_id')
                        ->where('series_id',$item->id)->pluck('category_id')->toArray();
                        $item['SeriesCategory'] = implode(',', $SeriesCategory);

                    $Seriesartist = Seriesartist::join("artists","series_artists.artist_id", "=", "artists.id")
                        ->where("series_artists.series_id", "=", $item->id)
                        ->pluck('artist_id')->toArray();
                        $item['Seriesartist_crew'] = implode(',', $Seriesartist);

                    return $item;
                });
            $filePath = 'series.csv';
            
            if (!Storage::exists($filePath)) {
                Storage::put($filePath, '');
            }

            $fileStream = fopen(storage_path('app/' . $filePath), 'w');

            $firstSerie = $series->first();
            $titles = array_keys($firstSerie->getAttributes());
            fputcsv($fileStream, $titles);

            foreach ($series as $serie) {
                $attributes = $serie->getAttributes();

                $rowData = [];
                foreach ($titles as $title) {
                    if (property_exists($serie, $title)) {
                        $rowData[] = $title === 'languages' ? $serie->{$title} : $serie->{$title};
                        $rowData[] = $title === 'SeriesCategory' ? $serie->{$title} : $serie->{$title};
                        $rowData[] = $title === 'Seriesartist_crew' ? $serie->{$title} : $serie->{$title};
                    }else if (array_key_exists($title, $attributes)) {
                        $rowData[] = $attributes[$title];
                    } else {
                        $rowData[] = '';
                    }
                }

                fputcsv($fileStream, $rowData);
            }

            fclose($fileStream);

            return 1;
           
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function SeriesBulkImport($data){
        
        try {

            if (isset($data['csv_file']) && is_file($data['csv_file'])) {
                // Get the uploaded CSV file
                $csvFile = $data['csv_file'];
    
                $file = fopen($csvFile->getPathname(), 'r');
    
                $headers = fgetcsv($file);
                $rowNumber = 1; 
                while (($row = fgetcsv($file)) !== false) {
                    $data = array_combine($headers, $row);
                    $Series = Series::find($data['id']);
                    if ($Series) {
                        $Series->update([
                            'user_id' => $data['user_id'],
                            'genre_id' => $data['genre_id'],
                            'network_id' => $data['network_id'],
                            'title' => $data['title'],
                            'slug' => empty($data["slug"]) ? str_replace(" ", "-", $data["title"]) : $data['slug'],
                            'type' => $data['type'],
                            'access' => $data['access'],
                            'details' => $data['details'],
                            'description' => $data['description'],
                            'active' => $data['active'],
                            'ppv_status' => $data['ppv_status'],
                            'featured' => $data['featured'],
                            'duration' => $data['duration'],
                            'views' => $data['views'],
                            'rating' => $data['rating'],
                            'image' => $data['image'],
                            'embed_code' => $data['embed_code'],
                            'mp4_url' => $data['mp4_url'],
                            'webm_url' => $data['webm_url'],
                            'ogg_url' => $data['ogg_url'],
                            'language' => $data['language'],
                            'year' => $data['year'],
                            'trailer' => $data['trailer'],
                            'url' => $data['url'],
                            'player_image' => $data['player_image'],
                            'tv_image' => $data['tv_image'],
                            'banner' => $data['banner'],
                            'search_tag' => $data['search_tag'],
                            'series_trailer' => $data['series_trailer'],
                            'season_trailer' => $data['season_trailer'],
                            'uploaded_by' => $data['uploaded_by'],
                            'created_at' => $data['created_at'],
                        ]);
                    }
                    
                    if (!empty($data["languages"])) {
                        $languageIds = explode(',', $data["languages"]);
                        SeriesLanguage::where('series_id', $Series->id)->delete();
                        foreach ($languageIds as $languageId) {
                            $SeriesLanguage = new SeriesLanguage();
                            $SeriesLanguage->series_id = $Series->id;
                            $SeriesLanguage->language_id = $languageId;
                            $SeriesLanguage->save();
                        }
                    }else {
                        return Redirect::back()->with('error_message', 'Language Video field is required in row'. $rowNumber);
                    }

                    if (!empty($data["SeriesCategory"])) {
                        $CategoryIds = explode(',', $data["SeriesCategory"]);
                        SeriesCategory::where('series_id', $Series->id)->delete();
                        foreach ($CategoryIds as $CategoryId) {
                            $SeriesCategory = new SeriesCategory();
                            $SeriesCategory->series_id = $Series->id;
                            $SeriesCategory->category_id = $CategoryId;
                            $SeriesCategory->save();
                        }
                    }else {
                        return Redirect::back()->with('error_message', 'Category Video field is required in row'. $rowNumber);
                    }

                    if (!empty($data["Seriesartist_crew"])) {
                        $SeriesartistIds = explode(',', $data["Seriesartist_crew"]);
                        Seriesartist::where('series_id', $Series->id)->delete();
                        foreach ($SeriesartistIds as $SeriesartistId) {
                            $Seriesartist = new Seriesartist();
                            $Seriesartist->series_id = $Series->id;
                            $Seriesartist->artist_id = $SeriesartistId;
                            $Seriesartist->save();
                        }
                    }else {
                        return Redirect::back()->with('error_message', 'Cast and Crew field is required in row'. $rowNumber);
                    }
                    $rowNumber++;
                }
    
                fclose($file);
    
                return Redirect::back()->with('message', 'CSV File updated successfully');

            } else {
                return Redirect::back()->with('error_message', 'No CSV file uploaded.');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function EpisodeBulkExport(Request $request){

        try {
           $video_start_id = $request->video_start_id;
           $video_end_id = $request->video_end_id;


            $Episodes = Episode::whereBetween('id', [$video_start_id, $video_end_id])->get();

            $filePath = 'episodes.csv';
            
            if (!Storage::exists($filePath)) {
                Storage::put($filePath, '');
            }

            $fileStream = fopen(storage_path('app/' . $filePath), 'w');

            $firstVideo = $Episodes->first();
            $titles = array_keys($firstVideo->getAttributes());
            fputcsv($fileStream, $titles);

            foreach ($Episodes as $Episode) {
                $attributes = $Episode->getAttributes();

                $rowData = [];
                foreach ($titles as $title) {
                     if (array_key_exists($title, $attributes)) {
                        $rowData[] = $attributes[$title];
                    } else {
                        $rowData[] = '';
                    }
                }

                fputcsv($fileStream, $rowData);
            }

            fclose($fileStream);

            return 1;

           
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    
    public function EpisodeBulkImport($data){
            
        try {

            if (isset($data['csv_file']) && is_file($data['csv_file'])) {
                // Get the uploaded CSV file
                $csvFile = $data['csv_file'];

                $file = fopen($csvFile->getPathname(), 'r');

                $headers = fgetcsv($file);
                $rowNumber = 1; 
                while (($row = fgetcsv($file)) !== false) {
                    $data = array_combine($headers, $row);
                    $Episode = Episode::find($data['id']);
                    if ($Episode) {
                        $Episode->update([
                            'series_id' => $data['series_id'],
                            'season_id' => $data['season_id'],
                            'type' => $data['type'],
                            'access' => $data['access'],
                            'title' => $data['title'],
                            'slug' => empty($data["slug"]) ? str_replace(" ", "-", $data["title"]) : $data['slug'],
                            'ppv_status' => $data['ppv_status'],
                            'ppv_price' => $data['ppv_price'],
                            'active' => $data['active'],
                            'skip_recap' => $data['skip_recap'],
                            'skip_intro' => $data['skip_intro'],
                            'recap_start_time' => $data['recap_start_time'],
                            'recap_end_time' => $data['recap_end_time'],
                            'intro_start_time' => $data['intro_start_time'],
                            'intro_end_time' => $data['intro_end_time'],
                            'featured' => $data['featured'],
                            'banner' => $data['banner'],
                            'footer' => $data['footer'],
                            'duration' => $data['duration'],
                            'episode_description' => $data['episode_description'],
                            'age_restrict' => $data['age_restrict'],
                            'views' => $data['views'],
                            'rating' => $data['rating'],
                            'image' => $data['image'],
                            'mp4_url' => $data['mp4_url'],
                            'url' => $data['url'],
                            'status' => $data['status'],
                            'free_content_duration' => $data['free_content_duration'],
                            'path' => $data['path'],
                            'player_image' => $data['player_image'],
                            'tv_image' => $data['tv_image'],
                            'search_tags' => $data['search_tags'],
                            'video_js_mid_advertisement_sequence_time' => $data['video_js_mid_advertisement_sequence_time'],
                            'pre_post_ads' => $data['pre_post_ads'],
                            'pre_ads' => $data['pre_ads'],
                            'mid_ads' => $data['mid_ads'],
                            'post_ads' => $data['post_ads'],
                            'disk' => $data['disk'],
                            'stream_path' => $data['stream_path'],
                            'processed_low' => $data['processed_low'],
                            'converted_for_streaming_at' => $data['converted_for_streaming_at'],
                            'episode_order' => $data['episode_order'],
                            'uploaded_by' => $data['uploaded_by'],
                            'user_id' => $data['user_id'],
                            'ads_position' => $data['ads_position'],
                            'episode_ads' => $data['episode_ads'],
                            'created_at' => $data['created_at'],
                        ]);
                    }
                    
                    $rowNumber++;
                }

                fclose($file);

                return Redirect::back()->with('message', 'CSV File updated successfully');

            } else {
                return Redirect::back()->with('error_message', 'No CSV file uploaded.');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}