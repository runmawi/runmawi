<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Laravelium\Sitemap\Sitemap;
use Laravelium\Sitemap\SitemapIndex;
use App\Video;
use App\VideoCategory;
use App\VideoSchedules;
use App\Series;
use App\SeriesGenre;
use App\SeriesSeason;
use App\Episode;
use App\LiveCategory;
use App\LiveEventArtist;
use App\LiveStream;
use App\Audio;
use App\AudioAlbums;
use App\Audioartist;
use App\AudioCategory;
use App\Artist;
use App\ModeratorsUser;
use App\Channel;
use App\Page;
use App\AdminLandingPage;
use App\Language;
use URL;
use Laravelium\Sitemap\SitemapServiceProvider;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically Generate an XML Sitemap';
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $sitemap = app(Sitemap::class);

        // Video Management 
        Video::get()->each(function (Video $Video) use ($sitemap) {
            $sitemap->add(
                URL::to("/videos/category/".$Video->slug),
                now(), '1.0',
                 'daily'
            );
        });

        VideoCategory::get()->each(function (VideoCategory $VideoCategory) use ($sitemap) {
            $sitemap->add(
                URL::to("/category/".$VideoCategory->slug)
                    ,now(), '1.0',
                    'daily'
            );
        });

        VideoSchedules::get()->each(function (VideoSchedules $VideoSchedules) use ($sitemap) {
            $sitemap->add(
                URL::to("/schedule/videos/embed/".$VideoSchedules->slug)
                    ,now(), '1.0',
                    'daily'
            );
        });

        $sitemap->add(URL::to("/categoryList") ,now(), '1.0',  'daily' );

        // Series And Episode Management 

        Series::get()->each(function (Series $Series) use ($sitemap) {
            $sitemap->add(
                URL::to("/play_series/".$Series->slug)
                    ,now(), '1.0',
                    'daily'
            );
        });

        SeriesGenre::get()->each(function (SeriesGenre $SeriesGenre) use ($sitemap) {
            $sitemap->add(
                URL::to("/series/category/".$SeriesGenre->slug)
                    ,now(), '1.0',
                    'daily'
            );
        });

        Episode::Select('episodes.*','series.id','series.slug as series_slug')
        ->Join('series','series.id','=','episodes.series_id')
        ->get()->each(function (Episode $Episode) use ($sitemap) {
            $sitemap->add(
                URL::to("/episode/".$Episode->series_slug."/".$Episode->slug)
                    ,now(), '1.0',
                    'daily'
            );
        });

        $sitemap->add(URL::to("/SeriescategoryList") ,now(), '1.0',  'daily' );

        // Live and Live Artist Management 
        
        LiveStream::get()->each(function (LiveStream $LiveStream) use ($sitemap) {
            $sitemap->add(
                URL::to("/live/".$LiveStream->slug)
                    ,now(), '1.0',
                    'daily'
            );
        });

        LiveCategory::get()->each(function (LiveCategory $LiveCategory) use ($sitemap) {
            $sitemap->add(
                URL::to("/live/category/".$LiveCategory->slug)
                    ,now(), '1.0',
                    'daily'
            );
        });

        
        LiveEventArtist::get()->each(function (LiveEventArtist $LiveEventArtist) use ($sitemap) {
            $sitemap->add(
                URL::to("/live-artist-event/".$LiveEventArtist->slug)
                    ,now(), '1.0',
                    'daily'
            );
        });

        $sitemap->add(URL::to("/CategoryLive") ,now(), '1.0',  'daily' );

        // Audios Artist and Audio Albums Management 

        Audio::get()->each(function (Audio $Audio) use ($sitemap) {
            $sitemap->add(
                URL::to("/audio/".$Audio->slug)
                    ,now(), '1.0',
                    'daily'
            );
        });

        AudioCategory::get()->each(function (AudioCategory $AudioCategory) use ($sitemap) {
            $sitemap->add(
                URL::to("/audios/category/".$AudioCategory->slug)
                    ,now(), '1.0',
                    'daily'
            );
        });

        AudioAlbums::get()->each(function (AudioAlbums $AudioAlbums) use ($sitemap) {
            $sitemap->add(
                URL::to("/album/".$AudioAlbums->slug)
                    ,now(), '1.0',
                    'daily'
            );
        });

        Audioartist::get()->each(function (Audioartist $Audioartist) use ($sitemap) {
            $sitemap->add(
                URL::to("/artist/".$Audioartist->artist_slug)
                    ,now(), '1.0',
                    'daily'
            );
        });
        
        $sitemap->add(URL::to("/artist-list") ,now(), '1.0',  'daily' );

        $sitemap->add(URL::to("/AudiocategoryList") ,now(), '1.0',  'daily' );

        // Content Partners 

        $sitemap->add( URL::to("/content-partners"),now(), '1.0', 'daily' );

        ModeratorsUser::get()->each(function (ModeratorsUser $ModeratorsUser) use ($sitemap) {
            $sitemap->add(
                URL::to("/contentpartner/".$ModeratorsUser->slug)
                    ,now(), '1.0',
                    'daily'
            );
        });

        // Channel Partners 

        $sitemap->add( URL::to("/Channel-list") ,now(), '1.0', 'daily' );

        Channel::get()->each(function (Channel $Channel) use ($sitemap) {
            $sitemap->add(
                URL::to("/channel/".$Channel->channel_slug)
                    ,now(), '1.0',
                    'daily'
            );
        });

        // Site URls
        
        Page::get()->each(function (Page $Page) use ($sitemap) {
            $sitemap->add(
                URL::to("/page/".$Page->slug)
                    ,now(), '1.0',
                    'daily'
            );
        });

        AdminLandingPage::get()->each(function (AdminLandingPage $AdminLandingPage) use ($sitemap) {
            $sitemap->add(
                URL::to("/pages/".$AdminLandingPage->slug)
                    ,now(), '1.0',
                    'daily'
            );
        });

        $sitemap->add(URL::to("/Reset-Password"),now(), '1.0','daily');
        
        $sitemap->add(URL::to("/login"),now(), '1.0','daily');

        $sitemap->add(URL::to("/signup"),now(), '1.0','daily');

        
        $sitemap->add( URL::to("/register2")  ,now(), '1.0','daily');

        $sitemap->add(URL::to("/transactiondetails"),now(), '1.0','daily');

        $sitemap->add(URL::to("/upgrade-subscription_plan "),now(), '1.0','daily' );

        $sitemap->add(URL::to("/myprofile"),now(), '1.0', 'daily');

        // language/{lanid}/{language}
     
        Language::get()->each(function (Language $Language) use ($sitemap) {
            $sitemap->add(
                URL::to("/language/".$Language->slug)
                    ,now(), '1.0',
                    'daily'
            );
        });

        $sitemap->add(URL::to("/language-list"),now(), '1.0', 'daily');

        // Recommended Videos 

        $sitemap->add(URL::to("/Most-watched-videos") ,now(), '1.0',  'daily' );

        $sitemap->add(URL::to("/Most-watched-videos-country") ,now(), '1.0',  'daily' );

        $sitemap->add(URL::to("/Most-watched-videos-site") ,now(), '1.0',  'daily' );

        $sitemap->add(URL::to("/continue-watching-list") ,now(), '1.0',  'daily' );

        $sitemap->add(URL::to("/latest-videos") ,now(), '1.0',  'daily' );

        $sitemap->add(URL::to("/mywishlists") ,now(), '1.0',  'daily' );

        $sitemap->add(URL::to("/watchlater") ,now(), '1.0',  'daily' );


        // Store The xml file 

        $sitemap->store('xml', '/uploads/sitemap/sitemap');

        $this->info('Sitemap generated successfully.');


    }
}