<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vedmant\FeedReader\Facades\FeedReader ;
use App\ThumbnailSetting ;
use App\HomeSetting;
use App\Video;
use App\LiveStream;
use App\Episode;
use App\Audio;
use SimplePie;
use Theme;

class RssFeedController extends Controller
{
    public function __construct()
    {
        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses( $this->Theme );
    }

    public function index()
    {
        $data = array(
            'videos_count'  => Video::count(),
            'livestreams_count'  => livestream::count(),
            'Episode_count'  => Episode::count(),
        );

        return Theme::view('Rss-feed.index', $data);
    }

    public function videos_view()
    {
        $data = array(
            'title'       => GetWebsiteName() ,
            'description' => GetWebsiteName() ,
            'link'      => route('Rss-Feed-videos-view') ,
            'language'  => 'en' ,
            'pubDate' => now() ,
            'videos'  => Video::latest()->get(),
        );

        return response()->view('Rss-feed.videos_view', $data)->header('Content-Type', 'text/xml');
    }

    public function livestream_view()
    {
        $data = array(
            'title'       => GetWebsiteName() ,
            'description' => GetWebsiteName() ,
            'link'      => route('Rss-Feed-Livestream-view') ,
            'language'  => 'en' ,
            'pubDate' => now() ,
            'livestreams'  => LiveStream::latest()->get(),
        );

        return response()->view('Rss-feed.livestream_view', $data)->header('Content-Type', 'text/xml');
    }

    public function episode_view()
    {
        $data = array(
            'title'       => GetWebsiteName() ,
            'description' => GetWebsiteName() ,
            'link'      => route('Rss-Feed-episode-view') ,
            'language'  => 'en' ,
            'pubDate' => now() ,
            'episodes'  => Episode::latest()->get(),
        );

        return response()->view('Rss-feed.Episode_view', $data)->header('Content-Type', 'text/xml');
    }

    public function audios_view()
    {
        $data = array(
            'title'       => GetWebsiteName() ,
            'description' => GetWebsiteName() ,
            'link'      => route('Rss-Feed-audios-view') ,
            'language'  => 'en' ,
            'pubDate' => now() ,
            'audios'  => Audio::latest()->get(),
        );

        return response()->view('Rss-feed.audio_view', $data)->header('Content-Type', 'text/xml');
    }

    public function artist_view()
    {
        $data = array(
            'title'       => GetWebsiteName() ,
            'description' => GetWebsiteName() ,
            'link'      => route('Rss-Feed-view') ,
            'language'  => 'en' ,
            'pubDate' => now() ,
            'artists'  => Video::latest()->get(),
        );

        return response()->view('Rss-feed.view', $data)->header('Content-Type', 'text/xml');
    }

    public function feed(Request $request)
    {
        try {
            $feed = FeedReader::read($request->rss_url);

            $result = [
                'title'       => $feed->get_title(),
                'description' => $feed->get_description(),
                'permalink'   => $feed->get_permalink(),
                'link'        => $feed->get_link(),
                'copyright'   => $feed->get_copyright(),
                'language'    => $feed->get_language(),
                'image_url'   => $feed->get_image_url(),
                'author'      => $feed->get_author()
            ];

            foreach ($feed->get_items(0, $feed->get_item_quantity()) as $item) {

                $i['id']          = $item->get_id();
                $i['title']       = $item->get_title();
                $i['description'] = $item->get_description();
                $i['content']     = $item->get_content();
                // $i['thumbnail']   = $item->get_thumbnail();
                $i['category']    = $item->get_category();
                $i['categories']  = $item->get_categories();
                $i['author']      = $item->get_author();
                $i['authors']     = $item->get_authors();
                $i['contributor'] = $item->get_contributor();
                $i['copyright']   = $item->get_copyright();
                $i['date']        = $item->get_date();
                $i['updated_date'] = $item->get_updated_date();
                $i['local_date']   = $item->get_local_date();
                $i['permalink']    = $item->get_permalink();
                $i['link']         = $item->get_link();
                $i['links']        = $item->get_links();
                $i['enclosure']    = $item->get_enclosure();
                $i['audio_link']   = $item->get_enclosure()->get_link();
                $i['enclosures']   = $item->get_enclosures();
                $i['latitude']     = $item->get_latitude();
                $i['longitude']    = $item->get_longitude();
                $i['source']      = $item->get_source();

                $result['items'][] = $i;
            }

            $response = array(
                'status' => true ,
                'message' => 'RSS Feed data Retrieved Successfully',
                'data' => $result,
            );
        } catch (\Throwable $th) {

            $response = array(
                'status' => false ,
                'data' => $th->getMessage(),
            );
        }

        return response()->json($response, 200);

    }
}
