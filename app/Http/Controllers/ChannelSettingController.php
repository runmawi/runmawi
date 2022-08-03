<?php
namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use File;
use App\Test as Test;
use App\Video as Video;
use App\MoviesSubtitles as MoviesSubtitles;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
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
use Session;
use App\LanguageVideo;
use App\CategoryVideo;
use App\CountryCode;
use App\Advertisement;
use App\BlockVideo;
use Exception;
use getID3;
use App\AdsVideo;
use App\VideoSearchTag;
use App\RelatedVideo;
use App\InappPurchase;
use App\Channel;

class ChannelSettingController extends Controller
{

    public function Accountindex()
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $user = \Session::get('channel');
            $user_id = $user->id;
            $user = Channel::where('id', $user_id)->first();

            $data = array(
                'user_id' => $user_id,
                'user' => $user,
            );

            return view('channel.settings.index', $data);
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }

    public function SaveAccount(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        $data = $request->all();

        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $user = \Session::get('channel');
            $id = $data['id'];

            $data = $request->all();

            $Channel = Channel::where('id', $id)->first();
            // dd($data);
            if (!empty($data['channel_name']))
            {
                $channel_name = $data['channel_name'];
            }
            else
            {
                $channel_name = $Channel->channel_name;
            }

            if (!empty($data['email']))
            {
                $email = $data['email'];
            }
            else
            {
                $email = $Channel->email;
            }
            if (!empty($data['upi_id']))
            {
                $upi_id = $data['upi_id'];
            }
            else
            {
                $upi_id = $Channel->upi_id;
            }
            if (!empty($data['upi_mobile_number']))
            {
                $upi_mobile_number = $data['upi_mobile_number'];
            }
            else
            {
                $upi_mobile_number = $Channel->upi_mobile_number;
            }
            if (!empty($data['mobile_number']))
            {
                $mobile_number = $data['mobile_number'];
            }
            else
            {
                $mobile_number = $Channel->mobile_number;
            }

            if (!empty($data['bank_name']))
            {
                $bank_name = $data['bank_name'];
            }
            else
            {
                $bank_name = $Channel->bank_name;
            }

            if (!empty($data['branch_name']))
            {
                $branch_name = $data['branch_name'];
            }
            else
            {
                $branch_name = $Channel->branch_name;
            }

            if (!empty($data['account_number']))
            {
                $account_number = $data['account_number'];
            }
            else
            {
                $account_number = $Channel->account_number;
            }

            if (!empty($data['IFSC_Code']))
            {
                $IFSC_Code = $data['IFSC_Code'];
            }
            else
            {
                $IFSC_Code = $Channel->IFSC_Code;
            }

            $picture = (isset($data['picture'])) ? $data['picture'] : '';

            $cancelled_cheque = (isset($data['cancelled_cheque'])) ? $data['cancelled_cheque'] : '';

            $logopath = URL::to("/public/uploads/channel/");
            $path = public_path() . "/uploads/channel/";
            if ($cancelled_cheque != "")
            {
                //code for remove old file
                if ($cancelled_cheque != "" && $cancelled_cheque != null)
                {
                    $file_old = $path . $cancelled_cheque;
                    if (file_exists($file_old))
                    {
                        unemail($file_old);
                    }
                }
                //upload new file
                $cheque = $cancelled_cheque;
                $file_cancelled_cheque = str_replace(' ', '_', $cheque->getClientOriginalName());
                $cheque->move($path, $cheque);
            }
            else
            {
                $file_cancelled_cheque = $Channel->cancelled_cheque;
            }

            $Channel->channel_name = $channel_name;
            $Channel->email = $email;
            $Channel->mobile_number = $mobile_number;
            $Channel->bank_name = $bank_name;
            $Channel->branch_name = $branch_name;
            $Channel->account_number = $account_number;
            $Channel->IFSC_Code = $IFSC_Code;
            $Channel->cancelled_cheque = $file_cancelled_cheque;
            $Channel->upi_id = $upi_id;
            $Channel->upi_mobile_number = $upi_mobile_number;

            $Channel->save();

            return \Redirect::back()
                ->with('message', 'Update User Profile');

            $user_id = $user->id;

            $data = array(
                'user_id' => $user_id,
                'user' => $user,
            );

            return view('channel.settings.index', $data);
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }
    public function Aboutindex()
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $user = \Session::get('channel');
            $user_id = $user->id;
            $user = Channel::where('id', $user_id)->first();

            $data = array(
                'user_id' => $user_id,
                'user' => $user,
            );

            return view('channel.settings.Aboutindex', $data);
        }
        else
        {
            return Redirect::to('/blocked');
        }
    }

    public function UpdateChannel(Request $request)
    {
        $user_package = User::where('id', 1)->first();
        $package = $user_package->package;
        $data = $request->all();

        if (!empty($package) && $package == "Pro" || !empty($package) && $package == "Business")
        {
            $user = \Session::get('channel');
            $id = $data['id'];

            $data = $request->all();

            $Channel = Channel::where('id', $id)->first();
            if (!empty($data['channel_name']))
            {
                $channel_name = $data['channel_name'];
            }
            else
            {
                $channel_name = $Channel->channel_name;
            }

            if (!empty($data['channel_about']))
            {
                $channel_about = $data['channel_about'];
            }
            else
            {
                $channel_about = $Channel->channel_about;
            }

            $channel_logo = (isset($data['channel_logo'])) ? $data['channel_logo'] : '';

            $intro_video = (isset($data['intro_video'])) ? $data['intro_video'] : '';

            $logopath = URL::to("/public/uploads/channel/");
            $path = public_path() . "/uploads/channel/";

            if ($intro_video != '')
            {
                //code for remove old file
                if ($intro_video != '' && $intro_video != null)
                {
                    $file_old = $path . $intro_video;
                    if (file_exists($file_old))
                    {
                        unlink($file_old);
                    }
                }
                //upload new file
                $randval = Str::random(16);
                $file = $intro_video;
                $intro_video_ext = $randval . '.' . $request->file('intro_video')
                    ->extension();
                $file->move($path, $intro_video_ext);

                $intro_video = URL::to('/') . '/public/uploads/channel/' . $intro_video_ext;

            }
            else
            {
                $intro_video = $Channel->intro_video;
            }

            $logopath = URL::to("/public/uploads/channel/");
            $path = public_path() . "/uploads/channel/";
            if ($channel_logo != "")
            {
                //code for remove old file
                if ($channel_logo != "" && $channel_logo != null)
                {
                    $file_old = $path . $channel_logo;
                    if (file_exists($file_old))
                    {
                        unemail($file_old);
                    }
                }
                //upload new file
                $logo = $channel_logo;
                $file_channel_logos = str_replace(' ', '_', $logo->getClientOriginalName());
                $file_channel_logo = URL::to('/') . '/public/uploads/channel/' . $file_channel_logos;
                $logo->move($path, $logo);
            }
            else
            {
                $file_channel_logo = $Channel->channel_logo;
            }

            $Channel->channel_name = $channel_name;
            $Channel->channel_about = $channel_about;
            $Channel->channel_logo = $file_channel_logo;
            $Channel->intro_video = $intro_video;
            $Channel->save();
            // dd($Channel);
            return \Redirect::back()
                ->with('message', 'Update User Profile');

        }
        else
        {
            return Redirect::to('/blocked');
        }
    }
}

