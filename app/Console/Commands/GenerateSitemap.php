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

        // Video Management 
        $sitemap = app(Sitemap::class);
        Video::get()->each(function (Video $Video) use ($sitemap) {
            $sitemap->add(
                URL::to("/videos/category/".$Video->slug),
                now(), '1.0',
                 'daily'
            );
        });

        $sitemap->add(URL::to('/'), now(), '1.0', 'daily');
        $sitemap->store('xml', '/uploads/sitemap/sitemap');

        $this->info('Sitemap generated successfully.');


    }
}