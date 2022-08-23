<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HomeSetting;
use App\ModeratorsUser;
use Theme;

class ContentPartnerController extends Controller
{
    public function __construct()
    {
        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);
    }

    public function index(Request $request)
    {
       $content_partner = array(
            'ModeratorUsers_list' => ModeratorsUser::where('status',1)->get() ,
       );
       return Theme::view('ContentPartner.index',$content_partner);
    }
}
