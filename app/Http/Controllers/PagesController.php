<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Redirect as Redirect;
use App\Setting;
use App\Page as Page;
use App\User as User;
use App\VideoCategory as VideoCategory;
use App\Menu as Menu;
use App\HomeSetting;
use Auth;
use View;
use Theme;
use App\AdminLandingPage;

class PagesController extends Controller
{
    public function index($slug)
    {
        $settings = Setting::first();

        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);

        $dynamic_page = Page::where('slug', '=', $slug)->first();

        if (!empty($dynamic_page) && @$dynamic_page->active) {
            $data = [
                'pager' => $dynamic_page,
                'author' => '',
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'pages' => Page::where('active', '=', 1)->get(),
            ];
            return Theme::view('page', $data);
        } else {
            return Redirect::to('pages')->with(['note' => 'Sorry, this page is no longer active.', 'note_type' => 'error']);
        }
    }

   
}
