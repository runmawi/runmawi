<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use App\Test as Test;
use App\Video as Video;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Setting as Setting;
use App\Menu as Menu;
use App\Language as Language;
use App\VideoLanguage as VideoLanguage;
use App\Subtitle as Subtitle;
use App\Tag as Tag;
use App\Audio as Audio;
use App\AudioCategory as AudioCategory;
use App\Page as Page;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use View;
use Validator;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use Illuminate\Contracts\Filesystem\Filesystem;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Str;
use App\Artist;
use App\Audioartist;
use App\AudioAlbums;
use DB;
use App\SystemSetting as SystemSetting;
use Session;
use App\CountryCode;
use App\BlockAudio;
use App\CategoryAudio;
use App\AudioLanguage;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\InappPurchase;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\StorageSetting as StorageSetting;
use App\ModeratorsUser as ModeratorsUser;
use File;
use Maatwebsite\Excel\Facades\Excel;
use App\Channel;


class AdminChannelScheduleController extends Controller
{

}