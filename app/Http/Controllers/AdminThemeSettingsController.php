<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User as User;
use \Redirect as Redirect;
//use Request;
use URL;
use Auth;
use App\Setting as Setting;
use App\Slider as Slider;
use App\MobileSlider as MobileSlider;
use App\Language as Language;
use App\VideoLanguage as VideoLanguage;
use App\ThemeSetting as ThemeSetting;
use App\SiteTheme as SiteTheme;
use Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Intervention\Image\Filters\DemoFilter;
use View;
use DB;
use App\SystemSetting as SystemSetting;
use Session;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use Illuminate\Support\Facades\File;
use Str;
use App\AdminAccessPermission as AdminAccessPermission;

class AdminThemeSettingsController extends Controller
{
    public function theme_settings()
    {
        if ((!Auth::guest() && Auth::user()->package == 'Channel') || Auth::user()->package == 'CPP') {
            return redirect('/admin/restrict');
        }
        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        } elseif (check_storage_exist() == 0) {
            $settings = Setting::first();

            $data = [
                'settings' => $settings,
            ];

            return View::make('admin.expired_storage', $data);
        } else {
            $settings = SiteTheme::first();
            $user = Auth::user();
            $data = [
                'settings' => $settings,
                'admin_user' => $user,
                'AdminAccessPermission' => AdminAccessPermission::first(),
        ];
            return View::make('admin.settings.theme_settings', $data);
        }
    }

    public function theme_settings_form()
    {
        $settings = Setting::first();
        $user = Auth::user();

        $data = [
            'settings' => $settings,
            'admin_user' => $user,
            'theme_settings' => ThemeHelper::getThemeSettings(),
        ];
        return View::make('Theme::includes.settings', $data);
    }

    public function update_theme_settings(Request $request)
    {
        // Get the Active Theme
        $active_theme = Setting::first()->theme;

        $input = Input::all();
        /*Move banner image file to folder*/
        $validator = Validator::make($data = Input::all(), Video::$rules);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $image = isset($data['homepage_banner']) ? $data['homepage_banner'] : '';
        if (!empty($image)) {
            unset($input['homepage_banner']);
            $files = $request->file('homepage_banner');
            if (!empty($files) && $files[0] != '') {
                $destinationPath_home = 'content/themes/default/assets/img/home';
                foreach ($files as $key => $file) {
                    $data['homepage_banner'] = $file->move($destinationPath_home, $file->getClientOriginalName());
                    $img_name[] = '"' . THEME_URL . '/assets/img/home/' . $file->getClientOriginalName() . '"';
                }

                if (isset(ThemeHelper::getThemeSettings()->homepage_banner)) {
                    $olderbaner = ThemeHelper::getThemeSettings()->homepage_banner;
                    $exploded_baners = explode(',', $olderbaner);

                    $bannerarray = implode(',', array_merge($exploded_baners, $img_name));
                } else {
                    $bannerarray = implode(',', $img_name);
                }

                $input['homepage_banner'] = $bannerarray;
            }
        }

        $image1 = isset($data['footer_banner']) ? $data['footer_banner'] : '';
        if (!empty($image1)) {
            unset($input['footer_banner']);
            $footer_file = $request->file('footer_banner');
            if ($footer_file) {
                $destinationPath = 'content/themes/default/assets/img/footer';
                $data['footer_banner'] = $footer_file->move($destinationPath, $footer_file->getClientOriginalName());
                $input['footer_banner'] = '"' . THEME_URL . '/assets/img/footer/' . $footer_file->getClientOriginalName() . '"';
            }
        }

        /*Move banner image file to folder*/

        foreach ($input as $key => $value) {
            $this->createOrUpdateThemeSetting($active_theme, $key, $value);
        }

        return Redirect::to('/admin/theme_settings');
    }

    public function SaveTheme(Request $request)
    {
        $data = $request->all();

        $theme_settings = SiteTheme::first();
        $theme_settings->dark_bg_color = $request->dark_bg_color;
        $theme_settings->light_bg_color = $request->light_bg_color;
        $theme_settings->button_bg_color = $request->button_bg_color;

        $theme_settings->dark_text_color = $request->dark_text_color;
        $theme_settings->light_text_color = $request->light_text_color;

        $theme_settings->admin_dark_bg_color = $request->admin_dark_bg_color;
        $theme_settings->admin_light_bg_color = $request->admin_light_bg_color;

        $theme_settings->admin_dark_text_color = $request->admin_dark_text_color;
        $theme_settings->admin_light_text_color = $request->admin_light_text_color;
        
        $path = public_path() . '/uploads/settings/';
        $dark_logo = $request->dark_mode_logo;
        $light_logo = $request->light_mode_logo;

        if ($dark_logo != '') {
            //code for remove old file
            if ($dark_logo != '' && $dark_logo != null) {
                $file_old = $path . $dark_logo;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $dark_logo;
            $theme_settings->dark_mode_logo = $file->getClientOriginalName();
            $file->move($path, $theme_settings->dark_mode_logo);
        }

        if ($light_logo != '') {
            //code for remove old file
            if ($light_logo != '' && $light_logo != null) {
                $file_old = $path . $light_logo;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $light_logo;
            $theme_settings->light_mode_logo = $file->getClientOriginalName();
            $file->move($path, $theme_settings->light_mode_logo);
        }

        $loader_videos = $request->loader_video;

        if ($loader_videos != '') {
            //code for remove old file
            if ($loader_videos != '' && $loader_videos != null) {
                $file_old = $path . $loader_videos;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $loader_videos;
            $theme_settings->loader_video = $file->getClientOriginalName();
            $file->move($path, $theme_settings->loader_video);
        }

        $theme_settings->signup_theme = !empty($data['signup_theme']) ? '1' : '0';

        $theme_settings->prevent_inspect = !empty($data['prevent_inspect']) ? '1' : '0';

        $theme_settings->search_dropdown_setting = !empty($data['search_dropdown_setting']) ? '1' : '0';

        $theme_settings->loader_setting = !empty($data['loader_setting']) ? '1' : '0';

        $theme_settings->loader_format = !empty($data['loader_format']) ? '1' : '0';

        $theme_settings->style_sheet_link = !empty($data['style_sheet_link']) ? $data['style_sheet_link'] : null;

        $theme_settings->typography_link = !empty($data['typography_link']) ? $data['typography_link'] : null;

        $theme_settings->signup_payment_content = $request->signup_payment_content ? $request->signup_payment_content : null;

        $theme_settings->signup_step2_title = $request->signup_step2_title ? $request->signup_step2_title : null;

        $theme_settings->my_profile_theme = !empty($data['my_profile_theme']) ? '1' : '0';

        $theme_settings->signin_header = !empty($data['signin_header']) ? '1' : '0';

        $theme_settings->audio_page_checkout = !empty($data['audio_page_checkout']) ? '1' : '0';

        $theme_settings->content_partner_checkout       = !empty($data['content_partner_checkout']) ? '1' : '0';

        $theme_settings->translate_checkout       = !empty($data['translate_checkout']) ? '1' : '0';

        $theme_settings->header_top_position       = !empty($data['header_top_position']) ? '1' : '0';
        
        $theme_settings->header_side_position       = !empty($data['header_side_position']) ? '1' : '0';
        
        $theme_settings->enable_extract_image       = !empty($data['enable_extract_image']) ? '1' : '0';

        $theme_settings->admin_ads_pre_post_position = !empty($data['admin_ads_pre_post_position']) ? '1' : '0';

        $theme_settings->enable_bunny_cdn       = !empty($data['enable_bunny_cdn']) ? '1' : '0';

        $theme_settings->Tv_Activation_Code       = !empty($data['Tv_Activation_Code']) ? '1' : '0';

        $theme_settings->Tv_Logged_User_List       = !empty($data['Tv_Logged_User_List']) ? '1' : '0';

        $theme_settings->enable_channel_payment       = !empty($data['enable_channel_payment']) ? '1' : '0';

        $theme_settings->enable_moderator_payment       = !empty($data['enable_moderator_payment']) ? '1' : '0';
     
        $theme_settings->enable_moderator_Monetization       = !empty($data['enable_moderator_Monetization']) ? '1' : '0';

        $theme_settings->enable_channel_Monetization       = !empty($data['enable_channel_Monetization']) ? '1' : '0';

        $theme_settings->signup_cpp_title = $request->signup_cpp_title ? $request->signup_cpp_title : null;
        
        $theme_settings->signup_channel_title = $request->signup_channel_title ? $request->signup_channel_title : null;
        
        $theme_settings->enable_logged_device       = !empty($data['enable_logged_device']) ? '1' : '0';

        $theme_settings->enable_default_timezone       = !empty($data['enable_default_timezone']) ? '1' : '0';
        
        $theme_settings->enable_4k_conversion       = !empty($data['enable_4k_conversion']) ? '1' : '0';

        $theme_settings->admin_videoupload_limit_count = $request->admin_videoupload_limit_count ? $request->admin_videoupload_limit_count : null;
        
        $theme_settings->admin_videoupload_limit_status       = !empty($data['admin_videoupload_limit_status']) ? '1' : '0';

        $theme_settings->enable_ppv_plans       = !empty($data['enable_ppv_plans']) ? '1' : '0';
        
        $theme_settings->enable_video_cipher_upload       = !empty($data['enable_video_cipher_upload']) ? '1' : '0';

        $theme_settings->enable_video_compression       = !empty($data['enable_video_compression']) ? '1' : '0';

        $theme_settings->purchase_btn                   = !empty($data['purchase_btn']) ? '1' : '0';

        $theme_settings->subscribe_btn                   = !empty($data['subscribe_btn']) ? '1' : '0';

        $theme_settings->enable_cpp_btn                   = !empty($data['enable_cpp_btn']) ? '1' : '0';

        $theme_settings->enable_channel_btn                   = !empty($data['enable_channel_btn']) ? '1' : '0';
        
        $theme_settings->access_change_pass                   = !empty($data['access_change_pass']) ? '1' : '0';
        
        $theme_settings->save();

        return Redirect::back()->with(['note' => 'Successfully Updated Settings', 'note_type' => 'success']);
    }

    private function createOrUpdateThemeSetting($theme_slug, $key, $value)
    {
        $setting = [
            'theme_slug' => $theme_slug,
            'key' => $key,
            'value' => $value,
        ];

        $theme_setting = ThemeSetting::where('theme_slug', '=', $theme_slug)
            ->where('key', '=', $key)
            ->first();

        if (isset($theme_setting->id)) {
            $theme_setting->update($setting);
            $theme_setting->save();
        } else {
            ThemeSetting::create($setting);
        }
    }

    public function SliderEdit($id)
    {
        if ((!Auth::guest() && Auth::user()->package == 'Channel') || Auth::user()->package == 'CPP') {
            return redirect('/admin/restrict');
        }
        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        } elseif (check_storage_exist() == 0) {
            $settings = Setting::first();

            $data = [
                'settings' => $settings,
            ];

            return View::make('admin.expired_storage', $data);
        } else {
            $categories = Slider::where('id', '=', $id)->get();

            $allCategories = Slider::all();
            return view('admin.sliders.edit', compact('categories', 'allCategories'));
        }
    }

    public function MobileSliderEdit($id)
    {
        $categories = MobileSlider::where('id', '=', $id)->get();
        $allCategories = MobileSlider::all();
        return view('admin.mobile.edit', compact('categories', 'allCategories'));
    }

    public function SliderUpdate(Request $request)
    {
        $input = $request->all();
        $path = public_path() . '/uploads/videocategory/';

        $id = $request['id'];
        $in_home = $request['active'];
        $link = $request['link'];
        $title = $request['title'];
        $trailer_link = $request['trailer_link'];
        $category = Slider::find($id);
        if (isset($request['slider']) && !empty($request['slider'])) {
            $image = $request['slider'];
        } else {
            $request['slider'] = $category->slider;
        }

        if (isset($request['player_image']) && !empty($request['player_image'])) {
            $player_image = $request['player_image'];
        } else {
            $request['player_image'] = $category->player_image;
        }
        // $slug = $request['slug'];
        if ($in_home != '') {
            $input['active'] = $request['active'];
        } else {
            $input['active'] = $request['active'];
        }
        if (isset($image) && $image != '') {
            //code for remove old file
            if ($image != '' && $image != null) {
                $file_old = $path . $image;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            $file = $image;
            // $category->slider  = $file->getClientOriginalName();
            $category->slider = str_replace(' ', '_', $file->getClientOriginalName());

            $file->move($path, $category->slider);
        }
        $path = public_path() . '/uploads/videocategory/';
        if (isset($player_image) && $player_image != '') {
            //code for remove old file
            if ($player_image != '' && $player_image != null) {
                $file_old = $path . $player_image;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            $file = $player_image;
            $category->player_image = $file->getClientOriginalName();
            $file->move($path, $category->player_image);
        }
        $category->link = $link;
        $category->trailer_link = $trailer_link;
        $category->title = $title;
        $category->active = $request['active'];
        $category->save();

        return Redirect::to('admin/sliders')->with(['note' => 'Successfully Updated Category', 'note_type' => 'success']);
    }

    public function MobileSliderUpdate(Request $request)
    {
        $input = $request->all();
        $path = public_path() . '/uploads/videocategory/';

        $id = $request['id'];
        $in_home = $request['active'];
        $link = $request['link'];
        $title = $request['title'];
        $category = MobileSlider::find($id);
        if (isset($request['slider']) && !empty($request['slider'])) {
            $image = $request['slider'];
        } else {
            $request['slider'] = $category->slider;
        }
        // $slug = $request['slug'];
        if ($in_home != '') {
            $input['active'] = $request['active'];
        } else {
            $input['active'] = $request['active'];
        }
        if (isset($image) && $image != '') {
            //code for remove old file
            if ($image != '' && $image != null) {
                $file_old = $path . $image;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            $file = $image;
            // $category->slider  = $file->getClientOriginalName();
            $category->slider = str_replace(' ', '_', $file->getClientOriginalName());

            $file->move($path, $category->slider);
        }
        $category->link = $link;
        $category->title = $title;
        $category->active = $request['active'];
        $category->save();

        return Redirect::back()->with(['note' => 'Successfully Updated Category', 'note_type' => 'success']);
    }

    public function SliderDelete($id)
    {
        Slider::destroy($id);

        return Redirect::to('admin/sliders')->with(['note' => 'Successfully Deleted Category', 'note_type' => 'success']);
    }

    public function MobileSliderDelete($id)
    {
        MobileSlider::destroy($id);
        return Redirect::back()->with(['note' => 'Successfully Deleted Category', 'note_type' => 'success']);
    }

    public function SliderIndex()
    {
        if ((!Auth::guest() && Auth::user()->package == 'Channel') || Auth::user()->package == 'CPP') {
            return redirect('/admin/restrict');
        }
        //$categories = VideoCategory::where('parent_id', '=', 0)->get();
        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        } elseif (check_storage_exist() == 0) {
            $settings = Setting::first();

            $data = [
                'settings' => $settings,
            ];

            return View::make('admin.expired_storage', $data);
        } else {
            $allCategories = Slider::orderBy('order_position', 'ASC')->get();
            $data = [
                'allCategories' => $allCategories,
            ];
            return view('admin.sliders.index', $data);
        }
    }

    public function LanguageTransIndex()
    {
        if ((!Auth::guest() && Auth::user()->package == 'Channel') || Auth::user()->package == 'CPP') {
            return redirect('/admin/restrict');
        }

        $data = Session::all();
        if (!Auth::guest()) {
            $package_id = auth()->user()->id;
            $user_package = User::where('id', $package_id)->first();
            $package = $user_package->package;
            $user = User::where('id', 1)->first();
            $duedate = $user->package_ends;
            $current_date = date('Y-m-d');
            if ($current_date > $duedate) {
                $client = new Client();
                $url = 'https://flicknexs.com/userapi/allplans';
                $params = [
                    'userid' => 0,
                ];

                $headers = [
                    'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
                ];
                $response = $client->request('post', $url, [
                    'json' => $params,
                    'headers' => $headers,
                    'verify' => false,
                ]);

                $responseBody = json_decode($response->getBody());
                $settings = Setting::first();
                $data = [
                    'settings' => $settings,
                    'responseBody' => $responseBody,
                ];
                return View::make('admin.expired_dashboard', $data);
            } elseif (check_storage_exist() == 0) {
                $settings = Setting::first();

                $data = [
                    'settings' => $settings,
                ];

                return View::make('admin.expired_storage', $data);
            } else {
                if ($package == 'Pro' || $package == 'Business' || ($package == '' && Auth::User()->role == 'admin')) {
                    //$categories = VideoCategory::where('parent_id', '=', 0)->get();

                    $allCategories = Language::all();

                    $data = [
                        'allCategories' => $allCategories,
                    ];
                    return view('admin.languagestrans.index', $data);
                } elseif ($package == 'Basic') {
                    return view('blocked');
                }
            }
        } else {
            $system_settings = SystemSetting::first();
            $user = User::where('id', '=', 1)->first();
            return view('auth.login', compact('system_settings', 'user'));
        }
    }

    public function SliderStore(Request $request)
    {
        $input = $request->all();
        $validatedData = $request->validate([
            'slider' => 'required|image',
        ]);
        $s = new Slider();
        $slider = new Slider();
        $path = public_path() . '/uploads/videocategory/';
        $image = $request['slider'];
        $player_image = $request['player_image'];
        $link = $request['link'];
        $title = $request['title'];
        $acive = $request['acive'];
        $trailer_link = $request['trailer_link'];
        if ($image != '') {
            //code for remove old file
            if ($image != '' && $image != null) {
                $file_old = $path . $image;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $image;
            // $slider->slider  = $file->getClientOriginalName();
            $slider->slider = str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $slider->slider);
        }

        $path = public_path() . '/uploads/videocategory/';
        if (isset($player_image) && $player_image != '') {
            //code for remove old file
            if ($player_image != '' && $player_image != null) {
                $file_old = $path . $player_image;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            $file = $player_image;
            //  $slider->player_image  = $file->getClientOriginalName();
            $slider->player_image = str_replace(' ', '_', $file->getClientOriginalName());
            $file->move($path, $slider->player_image);
        }
        $slider->link = $link;
        $slider->trailer_link = $trailer_link;
        $slider->title = $title;

        // $input['slider']  = $file->getClientOriginalName();
        // $input['player_image']  = $player_file->getClientOriginalName();
        $slider->active = $request['active'];
        $slider->save();
        return back()->with('success', 'New Category added successfully.');
    }

    public function MobileSliderStore(Request $request)
    {
        $input = $request->all();
        $validatedData = $request->validate([
            'slider' => 'required|image',
        ]);
        $s = new MobileSlider();
        $slider = new MobileSlider();
        $path = public_path() . '/uploads/videocategory/';
        $image = $request['slider'];
        $link = $request['link'];
        $title = $request['title'];
        $acive = $request['acive'];

        if ($image != '') {
            //code for remove old file
            if ($image != '' && $image != null) {
                $file_old = $path . $image;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $image;
            // $slider->slider  = $file->getClientOriginalName();
            $slider->slider = str_replace(' ', '_', $file->getClientOriginalName());
            $slider->link = $link;
            $slider->title = $title;
            $file->move($path, $slider->slider);
        }

        $input['slider'] = str_replace(' ', '_', $file->getClientOriginalName());
        $slider->active = $request['active'];
        $slider->save();
        return back()->with('success', 'New Category added successfully.');
    }

    public function LanguageDelete($id)
    {
        $data = Session::all();

        if (!Auth::guest()) {
            $package_id = auth()->user()->id;
            $user_package = User::where('id', $package_id)->first();
            $package = $user_package->package;

            if ($package == 'Pro' || $package == 'Business' || ($package == '' && Auth::User()->role == 'admin')) {

                $Language = Language::where('id',$id)->first();
                
                if (File::exists(base_path('public/uploads/Language/'.$Language->language_image))) {
                    File::delete(base_path('public/uploads/Language/'.$Language->language_image));
                }

                Language::destroy($id);

                return Redirect::to('admin/admin-languages')->with(['note' => 'Successfully Deleted Category', 'note_type' => 'success']);
            } elseif ($package == 'Basic') {
                return view('blocked');
            }
        } else {
            $system_settings = SystemSetting::first();
            $user = User::where('id', '=', 1)->first();
            return view('auth.login', compact('system_settings', 'user'));
        }
    }

    public function LanguageTransDelete($id)
    {
        $data = Session::all();
        if (!Auth::guest()) {
            $package_id = auth()->user()->id;
            $user_package = User::where('id', $package_id)->first();
            $package = $user_package->package;
            if ($package == 'Pro' || $package == 'Business' || ($package == '' && Auth::User()->role == 'admin')) {
                Language::destroy($id);

                return Redirect::to('admin/admin-languages-transulates')->with(['note' => 'Successfully Deleted Category', 'note_type' => 'success']);
            } elseif ($package == 'Basic') {
                return view('blocked');
            }
        } else {
            $system_settings = SystemSetting::first();
            $user = User::where('id', '=', 1)->first();
            return view('auth.login', compact('system_settings', 'user'));
        }
    }

    public function LanguageTransStore(Request $request)
    {
        $data = Session::all();
        if (!Auth::guest()) {
            $package_id = auth()->user()->id;
            $user_package = User::where('id', $package_id)->first();
            $package = $user_package->package;
            if ($package == 'Pro' || $package == 'Business' || ($package == '' && Auth::User()->role == 'admin')) {
                $input = $request->all();

                $validatedData = $request->validate([
                    'name' => 'required',
                ]);

                $s = new Language();
                $slider = new Language();

                $slider->name = $request['name'];
                $slider->code = substr($request['name'], 2);
                $file_loc = 'resources/lang/' . $slider->code . '.json';
                fopen($file_loc, 'w');
                ($myfile = fopen($file_loc, 'w')) or die('Unable to open file!');
                $txt = '{}';
                fwrite($myfile, $txt);

                $slider->save();
                return back()->with('success', 'New Language added successfully.');
            } elseif ($package == 'Basic') {
                return view('blocked');
            }
        } else {
            $system_settings = SystemSetting::first();
            $user = User::where('id', '=', 1)->first();
            return view('auth.login', compact('system_settings', 'user'));
        }
    }

    public function LanguageIndex()
    {
        if ((!Auth::guest() && Auth::user()->package == 'Channel') || Auth::user()->package == 'CPP') {
            return redirect('/admin/restrict');
        }
        $data = Session::all();

        if (!Auth::guest()) {
            $package_id = auth()->user()->id;
            $user_package = User::where('id', $package_id)->first();

            $package = $user_package->package;
            $user = User::where('id', 1)->first();
            $duedate = $user->package_ends;
            $current_date = date('Y-m-d');

            if ($current_date > $duedate) {
                $client = new Client();
                $url = 'https://flicknexs.com/userapi/allplans';
                $params = ['userid' => 0];

                $headers = [
                    'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
                ];

                $response = $client->request('post', $url, [
                    'json' => $params,
                    'headers' => $headers,
                    'verify' => false,
                ]);

                $responseBody = json_decode($response->getBody());
                $settings = Setting::first();

                $data = [
                    'settings' => $settings,
                    'responseBody' => $responseBody,
                ];

                return View::make('admin.expired_dashboard', $data);
            } elseif (check_storage_exist() == 0) {
                $settings = Setting::first();

                $data = [
                    'settings' => $settings,
                ];

                return View::make('admin.expired_storage', $data);
            } else {
                if ($package == 'Pro' || $package == 'Business' || ($package == '' && Auth::User()->role == 'admin')) {
                    $allCategories = VideoLanguage::all();

                    $data = [
                        'allCategories' => $allCategories,
                        'languages' => Language::all(),
                    ];

                    return view('admin.languages.index', $data);
                } elseif ($package == 'Basic') {
                    return view('blocked');
                }
            }
        } else {
            $system_settings = SystemSetting::first();
            $user = User::where('id', '=', 1)->first();

            return view('auth.login', compact('system_settings', 'user'));
        }
    }

    public function LanguageStore(Request $request)
    {
        $data = Session::all();

        if (!Auth::guest()) {
            $package_id = auth()->user()->id;
            $user_package = User::where('id', $package_id)->first();
            $package = $user_package->package;

            if ($package == 'Pro' || $package == 'Business' || ($package == '' && Auth::User()->role == 'admin')) {
                $input = $request->all();

                if ($request->hasFile('language_image')) {
                    $file = $request->language_image;

                    if (compress_image_enable() == 1) {
                        $filename = 'Language-image-' . time() . '.' . compress_image_format();
                        Image::make($file)->save(base_path() . '/public/uploads/Language/' . $filename, compress_image_resolution());
                    } else {
                        $filename = 'Language-image-' . time() . '.' . $file->getClientOriginalExtension();
                        Image::make($file)->save(base_path() . '/public/uploads/Language/' . $filename);
                    }
                } else {
                    $filename = default_horizontal_image();
                }

                Language::create([
                    'name' => $request->name,
                    'language_image' => $filename,
                    'slug' => Str::slug($request->name),
                ]);

                return back()->with('success', 'New Language added successfully.');
            } elseif ($package == 'Basic') {
                return view('blocked');
            }
        } else {
            $system_settings = SystemSetting::first();
            $user = User::where('id', '=', 1)->first();
            return view('auth.login', compact('system_settings', 'user'));
        }
    }

    public function LanguageTransEdit($id)
    {
        if ((!Auth::guest() && Auth::user()->package == 'Channel') || Auth::user()->package == 'CPP') {
            return redirect('/admin/restrict');
        }

        $data = Session::all();
        if (!Auth::guest()) {
            $package_id = auth()->user()->id;
            $user_package = User::where('id', $package_id)->first();
            $package = $user_package->package;
            $user = User::where('id', 1)->first();
            $duedate = $user->package_ends;
            $current_date = date('Y-m-d');
            if ($current_date > $duedate) {
                $client = new Client();
                $url = 'https://flicknexs.com/userapi/allplans';
                $params = [
                    'userid' => 0,
                ];

                $headers = [
                    'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
                ];
                $response = $client->request('post', $url, [
                    'json' => $params,
                    'headers' => $headers,
                    'verify' => false,
                ]);

                $responseBody = json_decode($response->getBody());
                $settings = Setting::first();
                $data = [
                    'settings' => $settings,
                    'responseBody' => $responseBody,
                ];
                return View::make('admin.expired_dashboard', $data);
            } elseif (check_storage_exist() == 0) {
                $settings = Setting::first();

                $data = [
                    'settings' => $settings,
                ];

                return View::make('admin.expired_storage', $data);
            } else {
                if ($package == 'Pro' || $package == 'Business' || ($package == '' && Auth::User()->role == 'admin')) {
                    $categories = Language::where('id', '=', $id)->get();
                    $allCategories = Language::all();
                    return view('admin.languagestrans.edit', compact('categories', 'allCategories'));
                } elseif ($package == 'Basic') {
                    return view('blocked');
                }
            }
        } else {
            $system_settings = SystemSetting::first();
            $user = User::where('id', '=', 1)->first();
            return view('auth.login', compact('system_settings', 'user'));
        }
    }

    public function LanguageEdit($id)
    {
        if ((!Auth::guest() && Auth::user()->package == 'Channel') || Auth::user()->package == 'CPP') {
            return redirect('/admin/restrict');
        }

        $data = Session::all();

        if (!Auth::guest()) {
            $package_id = auth()->user()->id;
            $user_package = User::where('id', $package_id)->first();
            $package = $user_package->package;
            $user = User::where('id', 1)->first();
            $duedate = $user->package_ends;
            $current_date = date('Y-m-d');

            if ($current_date > $duedate) {
                $client = new Client();
                $url = 'https://flicknexs.com/userapi/allplans';

                $params = ['userid' => 0];
                $headers = ['api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'];

                $response = $client->request('post', $url, [
                    'json' => $params,
                    'headers' => $headers,
                    'verify' => false,
                ]);

                $responseBody = json_decode($response->getBody());
                $settings = Setting::first();

                $data = [
                    'settings' => $settings,
                    'responseBody' => $responseBody,
                ];

                return View::make('admin.expired_dashboard', $data);
            } elseif (check_storage_exist() == 0) {
                $settings = Setting::first();

                $data = [
                    'settings' => $settings,
                ];

                return View::make('admin.expired_storage', $data);
            } else {
                if ($package == 'Pro' || $package == 'Business' || ($package == '' && Auth::User()->role == 'admin')) {
                    $language = Language::where('id', $id)->first();

                    $data = [
                        'languages' => $language,
                    ];

                    return view('admin.languages.edit', $data);
                } elseif ($package == 'Basic') {
                    return view('blocked');
                }
            }
        } else {
            $system_settings = SystemSetting::first();
            $user = User::where('id', '=', 1)->first();
            return view('auth.login', compact('system_settings', 'user'));
        }
    }

    public function LanguageUpdate(Request $request)
    {
        $data = Session::all();

        $id = $request->language_id;

        if (!Auth::guest()) {

            $package_id = auth()->user()->id;
            $user_package = User::where('id', $package_id)->first();
            $package = $user_package->package;

            if ($package == 'Pro' || $package == 'Business' || ($package == '' && Auth::User()->role == 'admin')) {

                  $input = $request->all();

                  $inputs = array(
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                  );

                  if ($request->hasFile('language_image')) {

                    $Language = Language::where('id',$id)->first();

                    if (File::exists(base_path('public/uploads/Language/'.$Language->language_image))) {
                        File::delete(base_path('public/uploads/Language/'.$Language->language_image));
                    }

                    $file = $request->language_image;

                    if (compress_image_enable() == 1) {

                        $filename = 'Language-image-' . time() . '.' . compress_image_format();
                        Image::make($file)->save(base_path() . '/public/uploads/Language/' . $filename, compress_image_resolution());
                    } 
                    else {

                        $filename = 'Language-image-' . time() . '.' . $file->getClientOriginalExtension();
                        Image::make($file)->save(base_path() . '/public/uploads/Language/' . $filename);
                    }
                    
                    $inputs+= array( 'language_image' => $filename, );
                } 

                Language::where('id', $id)->update($inputs);

                return back()->with('success', 'New Language Updated successfully.');

            } elseif ($package == 'Basic') {
                return view('blocked');
            }
        } else {
            $system_settings = SystemSetting::first();
            $user = User::where('id', '=', 1)->first();

            return view('auth.login', compact('system_settings', 'user'));
        }
    }

    
    public function LanguageTransUpdate(Request $request)
    {
        $data = Session::all();
        if (!Auth::guest()) {
            $package_id = auth()->user()->id;
            $user_package = User::where('id', $package_id)->first();
            $package = $user_package->package;
            if ($package == 'Pro' || $package == 'Business' || ($package == '' && Auth::User()->role == 'admin')) {
                $input = $request->all();
                $id = $request['id'];
                $name = $request['name'];
                $category = Language::find($id);
                $category->name = $request['name'];
                $category->save();

                return back()->with('success', 'New Language Updated successfully.');
            } elseif ($package == 'Basic') {
                return view('blocked');
            }
        } else {
            $system_settings = SystemSetting::first();
            $user = User::where('id', '=', 1)->first();
            return view('auth.login', compact('system_settings', 'user'));
        }
    }

    public function slider_order(Request $request)
    {
        $input = $request->all();
        $position = $_POST['position'];
        $i = 1;
        foreach ($position as $k => $v) {
            $slider = Slider::find($v);
            $slider->order_position = $i;
            $slider->save();
            $i++;
        }
        return 1;
    }
}
