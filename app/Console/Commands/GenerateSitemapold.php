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

class GenerateSitemapold extends Command
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
        $postsitmap = Sitemap::create();

        // Video Management 
        
        Video::get()->each(function (Video $Video) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/videos/category/{$Video->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });
        
        VideoCategory::get()->each(function (VideoCategory $VideoCategory) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/category/{$VideoCategory->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        VideoSchedules::get()->each(function (VideoSchedules $VideoSchedules) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/schedule/videos/embed/{$VideoSchedules->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });


        // Series And Episode Management 

        Series::get()->each(function (Series $Series) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/play_series/{$Series->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        SeriesGenre::get()->each(function (SeriesGenre $SeriesGenre) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/series/category/{$SeriesGenre->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        Episode::Select('episodes.*','series.id','series.slug as series_slug')
        ->Join('series','series.id','=','episodes.series_id')
        ->get()->each(function (Episode $Episode) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/episode/{$Episode->series_slug}/{$Episode->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        // Live and Live Artist Management 
        
        LiveStream::get()->each(function (LiveStream $LiveStream) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/live/{$LiveStream->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        LiveCategory::get()->each(function (LiveCategory $LiveCategory) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/live/category/{$LiveCategory->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        
        LiveEventArtist::get()->each(function (LiveEventArtist $LiveEventArtist) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/live-artist-event/{$LiveEventArtist->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        // Audios Artist and Audio Albums Management 

        Audio::get()->each(function (Audio $Audio) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/audio/{$Audio->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        AudioCategory::get()->each(function (AudioCategory $AudioCategory) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/audios/category/{$AudioCategory->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        AudioAlbums::get()->each(function (AudioAlbums $AudioAlbums) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/album/{$AudioAlbums->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        Audioartist::get()->each(function (Audioartist $Audioartist) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/artist/{$Audioartist->artist_slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });
        $postsitmap->add(
            Url::create("/artist-list")
            ->setPriority(0.9)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        );

        // Content Partners 

        $postsitmap->add(
            Url::create("/content-partners")
            ->setPriority(0.9)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        );

        ModeratorsUser::get()->each(function (ModeratorsUser $ModeratorsUser) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/contentpartner/{$ModeratorsUser->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        // Channel Partners 

        $postsitmap->add(
            Url::create("/Channel-list")
            ->setPriority(0.9)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        );

        Channel::get()->each(function (Channel $Channel) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/channel/{$Channel->channel_slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        // Site URls
        
        Page::get()->each(function (Page $Page) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/page/{$Page->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        AdminLandingPage::get()->each(function (AdminLandingPage $AdminLandingPage) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/pages/{$AdminLandingPage->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        $postsitmap->add(
            Url::create("/Reset-Password")
            ->setPriority(0.9)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        );
        
        $postsitmap->add(
            Url::create("/login")
            ->setPriority(0.9)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        );

        $postsitmap->add(
            Url::create("/signup")
            ->setPriority(0.9)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        );

        
        $postsitmap->add(
            Url::create("/register2")
            ->setPriority(0.9)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        );

        $postsitmap->add(
            Url::create("/transactiondetails")
            ->setPriority(0.9)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        );

        $postsitmap->add(
            Url::create("/upgrade-subscription_plan ")
            ->setPriority(0.9)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        );

        $postsitmap->add(
            Url::create("/myprofile")
            ->setPriority(0.9)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        );
        // language/{lanid}/{language}
     
        Language::get()->each(function (Language $Language) use ($postsitmap) {
            $postsitmap->add(
                Url::create("/language/{$Language->slug}")
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        $postsitmap->writeToFile(public_path('/uploads/sitemap/sitemap.xml'));
    }
}